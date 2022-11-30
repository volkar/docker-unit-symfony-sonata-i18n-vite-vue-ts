FROM alpine:latest

LABEL maintainer="sergey@volkar.ru"

# Args from .env file
ARG INSTALL_XDEBUG
ARG GIT_EMAIL
ARG GIT_NAME

# Create /www dir for server root
RUN mkdir /www && \
    apk update && \
    apk upgrade && \
    # Add common packages \
    apk add --no-cache curl git bash make && \
    # Install unit & php \
    apk add --no-cache unit unit-php81 unit-openrc && \
    # Symfony required php extensions \
    apk add --no-cache php81-ctype php81-xml php81-tokenizer php81-dom php81-xmlwriter php81-session php81-simplexml php81-fileinfo && \
    # OPCache \
    apk add --no-cache php81-opcache && \
    # Postgres \
    apk add --no-cache php81-pdo_pgsql && \
    # GD
    apk add --no-cache php81-gd && \
    # Imagick
    apk add --no-cache php81-pecl-imagick php81-pecl-imagick-dev && \
    # Composer \
    apk add composer && \
    # Symfony CLI
    curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony && \
    # Git config
    git config --global user.email "${GIT_EMAIL}" && \
    git config --global user.name "${GIT_NAME}"

# Set workdir
WORKDIR /www

# Set permissions
RUN chown -R unit:unit /var/lib/unit
RUN chown -R unit:unit /www

# XDebug
# RUN apk add --no-cache php81-pecl-xdebug
# COPY ./docker_configs/xdebug.ini /etc/php81/conf.d/50_xdebug.ini

# Copy shell script to entrypoint dir
COPY ./docker_configs/docker-entrypoint.sh /docker-entrypoint.d/docker-entrypoint.sh
# Copy unit initial config file to entrypoint dir
COPY ./docker_configs/config.json /docker-entrypoint.d/config.json
# Copy php.ini
COPY ./docker_configs/php.ini /etc/php81/php.ini

# Run unit
CMD ["unitd", "--no-daemon", "--control", "unix:/run/control.unit.sock", "--log", "/dev/stderr"]

# Entrypoint
ENTRYPOINT ["/docker-entrypoint.d/docker-entrypoint.sh"]