up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear psrfw-clear docker-pull docker-build docker-up psrfw-init psrfw-ready psrfw-init rights
rights: psrfw-cli-rightes psrfw-fpm-rightes

composer-update: psrfw-composer-update
composer-upgrade: psrfw-composer-upgrade

test: psrfw-cli-composer-test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

psrfw-init: psrfw-composer-install psrfw-composer-dev-enable

psrfw-composer-install:
	docker-compose run --rm psrfw-php-cli composer install

psrfw-composer-update:
	docker-compose run --rm psrfw-php-cli composer update

psrfw-clear:
	docker run --rm -v ${PWD}:/app --workdir=/app psrfw-php-cli rm -f .ready

psrfw-ready:
	docker run --rm -v ${PWD}:/app --workdir=/app psrfw-php-cli touch .ready

psrfw-wait-db:
	until docker-compose exec -T psrfw-postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

psrfw-cli-rightes:
	docker-compose run --rm psrfw-php-cli chmod -R 777 /app/var

psrfw-fpm-rightes:
	docker-compose run --rm psrfw-php-fpm chmod -R 777 /app/var

psrfw-cli-composer-test:
	docker-compose run --rm psrfw-php-cli composer test

psrfw-composer-dev-enable:
	docker-compose run --rm psrfw-php-cli composer development-enable

psrfw-composer-dev-disable:
	docker-compose run --rm psrfw-php-cli composer development-disable

psrfw-composer-upgrade:
	docker-compose run --rm psrfw-php-cli composer upgrade

psrfw-assets-watch:
	docker-compose run --rm psrfw-node-watch npm run watch

psrfw-assets-install-mix:
	docker-compose run --rm psrfw-node npm install laravel-mix --save-dev

psrfw-assets-install:
	docker-compose run --rm psrfw-node npm install
