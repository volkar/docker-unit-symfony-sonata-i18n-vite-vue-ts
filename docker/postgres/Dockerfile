FROM postgres:latest

LABEL maintainer="sergey@volkar.ru"

# Copy init sql files to container
COPY ./buildsql/* /docker-entrypoint-initdb.d