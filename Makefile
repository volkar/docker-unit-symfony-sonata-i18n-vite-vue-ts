up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose down -v --remove-orphans
	docker-compose rm -vsf
	docker-compose up -d --build

test:
	docker-compose exec server vendor/bin/phpunit ./tests

bash:
	docker-compose exec -u unit server bash

bash_root:
	docker-compose exec -u 0 server bash

unit_conf:
	curl -X PUT --data-binary @docker_configs/config.json --unix-socket /var/run/control.unit.sock http://localhost/config

unit_status:
	curl -X GET --unix-socket /var/run/control.unit.sock http://localhost/status/