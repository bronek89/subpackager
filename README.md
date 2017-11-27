# SubPackager

Application for tracking changes in sub-packages residing in one monorepo. Automatically detects changed sub-packages and push subtree split repository to sub-package remote.

## Usage

Running `subpackager run` in repository root with configuration file named `subpackager.json`.

## Example configuration

For repository with two subpackages `lib/one` and `lib/two`:

```json
{
    "packages": [
        { "path": "lib/one", "repository": "https://github.com/lib/one.git" },
        { "path": "lib/two", "repository": "https://github.com/lib/two.git" }
    ]
}
```

Making changes in directory `lib/one` and executing: 

```bash
subpackager run --from=HEAD^
```

will result in subtree split to branch `split/lib_one` and push to `https://github.com/lib/one.git`

### License

MIT
