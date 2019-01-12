FROM ubuntu:16.04
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y software-properties-common locales

RUN locale-gen en_US.UTF-8
ENV LANG=en_US.UTF-8

RUN apt-add-repository ppa:git-core/ppa -y && \
    apt-get update && \
    apt-get install -y --force-yes \
	    nano \
	    git \
	    curl \
	    mysql-client \
	    vim \
	    wget \
        zsh \
        gnupg-agent

RUN useradd -ms /bin/zsh subpackager

WORKDIR /var/www

RUN git clone git://github.com/robbyrussell/oh-my-zsh.git /home/subpackager/.oh-my-zsh \
      && cp /home/subpackager/.oh-my-zsh/templates/zshrc.zsh-template /home/subpackager/.zshrc \
      && sed -i.bak 's/robbyrussell/nebirhos/' /home/subpackager/.zshrc \
      && chown subpackager:subpackager /home/subpackager/.zshrc

RUN apt-add-repository -y ppa:ondrej/php && apt-get update && apt-get install -y --force-yes \
	php7.3-cli \
	php7.3-curl \
	php7.3-intl \
	php7.3-mysql \
	php7.3-xml \
	php7.3-mbstring \
	php7.3-bcmath \
	php7.3-zip \
	php7.3-opcache \
	php7.3-bz2 \
	php7.3-gmp \
    php7.3-redis \
    php-xdebug

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN rm /etc/php/7.3/cli/conf.d/20-xdebug.ini
RUN echo "plugins=(git docker docker-compose symfony symfony2 composer yarn)" >> /home/subpackager/.zshrc

USER subpackager

# from https://hub.docker.com/r/themattrix/develop/~/dockerfile/
RUN git clone https://github.com/junegunn/fzf.git /home/subpackager/.fzf \
    && (cd /home/subpackager/.fzf) \
    && (yes | /home/subpackager/.fzf/install) \
    && echo "export FZF_DEFAULT_OPTS='--no-height --no-reverse'" >> /home/subpackager/.zshrc
