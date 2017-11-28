<?php

namespace tests\Bronek\SubPackager;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class SubtreeSplitTest extends TestCase
{
    // create git repo from test files
    // commit files in test repo

    // create remote repositories for subpackages

    // run subpackager
    // - first
    // - after changes to files

    /** @var string */
    private $testDir;

    /** @var Filesystem */
    private $filesystem;

    function setUp()
    {
        $this->testDir = '/tmp/' . uniqid(mt_rand(), true);
        $this->filesystem = new Filesystem();

        $this->filesystem->mirror(__DIR__ . '/main-repo', $this->testDir . '/main-repo');
        $this->filesystem->mirror(__DIR__ . '/remotes', $this->testDir . '/remotes');

        self::assertTrue($this->filesystem->exists(__DIR__ . '/remotes/one'));
        self::assertTrue($this->filesystem->exists(__DIR__ . '/remotes/two'));

        $this->onMainRepo('git', 'init');
        $this->onMainRepo('git', 'add', '-A');
        $this->onMainRepo('git', 'config', 'user.email', 'you@example.com');
        $this->onMainRepo('git', 'config', 'user.name', 'Me');
        $this->onMainRepo('git', 'commit', '-m', 'Initial commit');

        $this->onFirstRemote('git', 'init', '--bare');
        $this->onSecondRemote('git', 'init', '--bare');
    }

    function tearDown()
    {
        $this->filesystem->remove($this->testDir);
    }

    private function onDir(string $cwd, string ...$command): string
    {
        $process = new Process($command, $cwd, ['PWD' => $cwd]);
        $process->mustRun();

        return \trim($process->getOutput());
    }

    private function onMainRepo(string ...$command): string
    {
        return $this->onDir($this->testDir . '/main-repo', ...$command);
    }

    private function onFirstRemote(string ...$command): string
    {
        return $this->onDir($this->testDir . '/remotes/one', ...$command);
    }

    private function onSecondRemote(string ...$command): string
    {
        return $this->onDir($this->testDir . '/remotes/two', ...$command);
    }

    private function runUpdate(?string $from = null): array
    {
        $command = ['php ' . __DIR__ . '/../bin/subpackager', 'update', '--formatter=json'];

        if ($from) {
            $command[] = '--from=' . $from;
        }

        $resultString = $this->onMainRepo(...$command);

        self::assertJson($resultString);

        $result = \json_decode($resultString, true);

        self::assertArrayHasKey('packages', $result);

        return $result;
    }

    function test_split()
    {
        $result = $this->runUpdate();

        self::assertCount(2, $result['packages']);
        self::assertTrue($result['packages'][0]['pushed']);
        self::assertTrue($result['packages'][1]['pushed']);

        $this->onMainRepo('touch', 'new_file');
        $this->onMainRepo('git', 'add', '-A');
        $this->onMainRepo('git', 'commit', '-m', 'Second commit');

        $result = $this->runUpdate('HEAD^');

        self::assertCount(2, $result['packages']);
        self::assertFalse($result['packages'][0]['pushed']);
        self::assertFalse($result['packages'][1]['pushed']);

        $this->onMainRepo('touch', 'lib/two/new_file2');
        $this->onMainRepo('git', 'add', '-A');
        $this->onMainRepo('git', 'commit', '-m', 'Second commit');

        $result = $this->runUpdate('HEAD^');

        self::assertCount(2, $result['packages']);
        self::assertFalse($result['packages'][0]['pushed']);
        self::assertTrue($result['packages'][1]['pushed']);
    }
}
