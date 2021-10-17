.PHONY: install
install:
	docker-compose run --rm composer install --ignore-platform-reqs

.PHONY: test
test:
	docker-compose run --rm php ./vendor/bin/phpunit

.PHONY: phpstan
phpstan:
	docker-compose run --rm phpstan analyse

