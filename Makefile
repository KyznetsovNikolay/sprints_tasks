up: build
down: stop
restart: down rebuild

start:
	docker-compose up -d

build: start
	docker-compose run --rm app composer install

migrate:
	docker-compose run --rm app bin/console doctrine:migrations:migrate -n

rebuild:
	docker-compose up -d --build

stop:
	docker-compose down -v