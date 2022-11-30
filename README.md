## Docker configuration with PHP 8.1, NGINX Unit 1.28, PostgreSQL 14.2 and Symfony 6.1 for SPA (Single Page Application) development with Vue/Vite, Pinia and SonataAdmin.

SPA preview:
![SPA preview](https://github.com/volkar/docker-unit-symfony-sonata-i18n-vite-vue-ts/blob/main/preview.jpg?raw=true)
Sonata preview:
![SPA preview](https://github.com/volkar/docker-unit-symfony-sonata-i18n-vite-vue-ts/blob/main/preview-sonata.jpg?raw=true)

### Docker container:
- Based on latest Alpine Linux
- Nginx Unit
- Xdebug and PHPUnit
- Makefile

### Symfony backend:
- PHP 8.1
- PostgreSQL
- SonataAdmin
- Internationalization (i18n) setup
- SonataMedia
- Symfony Data Fixtures (pages, categories, projects, users, media)
- Imagick instead of GD
- CKEditor with matched colors
- Custom resizer for SonataMedia
- Symfony Security for SonataAdmin
- [Nightshade theme](https://github.com/volkar/sonataadmin-nightshade-theme) for SonataAdmin

### Vue frontend:
- TypeScript
- Vue 3
- Vite for assets build
- Pinia for data store
- ky for fetching data
- Simple SPA with basic routes for example
- [Cache system](https://github.com/volkar/vue-pinia-cache-composables) requests for symfony backend

## Prerequisites

Required requisites:

1. [Git](https://git-scm.com/book/en/Getting-Started-Installing-Git)
2. [Docker](https://docs.docker.com/engine/installation/)
3. [Docker Compose](https://docs.docker.com/compose/install/)

Docker and Docker Compose can be installed with [Docker Desktop](https://www.docker.com/products/docker-desktop/) app.

## Initialization

1. Clone the project:
```
git clone https://github.com/volkar/docker-symfony-vite-vue-ts.git
```
2. Go to the project's folder
```
cd /path/to/docker-symfony-vite-vue-ts
```
3. Build and up project with Docker Compose
```
docker-compose up -d --build
```
4. Enter container's shell
```
make bash
```
5. Update and install composer packages
```
composer update
```
6. Create database schema
```
symfony console doctrine:schema:update --force
```
7. Load data from symfony fixtures
```
symfony console doctrine:fixtures:load
```
8. Exit container's shell
```
exit
```
9. Install all node's dependencies
```
npm install
```
10. Run Vite dev server
```
npm run dev
```
11. Open `http://localhost` in your browser.

Administrator account created by fixtures (for SonataAdmin access):
- login: **admin@admin.com**
- pass: **admin**

## Using

### Using Docker Composer

Build and up:

```
docker-compose up -d --build
```

Up only:

```
docker-compose up -d
```

Down:

```
docker-compose down
```

Rebuild and up:

```
docker-compose down -v --remove-orphans
docker-compose rm -vsf
docker-compose up -d --build
```

### Using PostgreSQL

Postgres database name, user and password defined in `.env` file.

All .sql files inside `docker/postgres/buildsql` will be executed on container build.

Connect to database with default login:

```
docker-compose exec postgres psql -U dbuser dbname
```

### Using PHP

Default PHP config located at `docker_configs/php.ini`.
Custom settings applied at Unit's config file `docker_configs/config.json`.
You might want to change `date.timezone`, default value is set to `Europe/Helsinki` (GMT+3).

Execute command `php -v` in the `server` container:

```
docker-compose exec server php -v
```

### Using PHPUnit

There is two test for testing Docker environment:

1. PHPUnit self test
2. PostgreSQL connection test
3. Empty test for write Symfony controllers tests

Run the tests:

```
docker-compose exec server vendor/bin/phpunit ./tests
```

Successfully passed tests output:

```
OK (3 tests, 3 assertions)
```

### Using Xdebug

XDebug config located at `docker/php/conf/xdebug.ini`.

To enable Xdebug at the project build, uncomment corresponding lines in `Dockerfile` file.

### Using Makefile

To execute Makefile command use `make <command>` from project's folder

List of commands:

| Command     | Description                                      | 
|-------------|--------------------------------------------------|
| up          | Up containers                                    |
| down        | Down containers                                  |
| build       | Build/rebuild containers                         |
| test        | Run PHPUnit tests                                |
| bash        | Use bash in `server` container as `unit`         |
| bash_root   | Use bash in `server` container as `root`         |
| unit_conf   | Reload `/docker_configs/config.json` to the Unit |
| unit_status | Display Unit status                              |

## Mapping

Folders mapped for default Symfony folder structure (assuming local `/` is project's folder):

| Local | Container | Description |
| - | - | - |
| / | /www | Project root |
| /public | /www/public | Web server document root |
| /docker/postgres/data | /var/lib/postgresql/data | PostgreSQL data files |

Ports mapped default:

| Local | Container | Description |
| - | - | - |
| 80 | 80 | NGINX port |
| 5432 | 5432 | PostgreSQL port |
| 9003 | 9003 | PHPUnit port |

## Contact me

You always welcome to mail me at sergey@volkar.ru