up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear psrfw-clear docker-pull docker-build docker-up psrfw-init rights
rights: psrfw-cli-rightes psrfw-fpm-rightes

test: psrfw-test

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

psrfw-init: psrfw-composer-install

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

psrfw-test:
	docker-compose run --rm psrfw-php-cli composer test
