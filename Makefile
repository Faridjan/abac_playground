#######################  INITIONs  ##########################
init: down-clear api-clear pull build up composer-i api-wait-db api-migrate api-fixtures
api-clear:
	docker run --rm -v ${PWD}/api:/app -w /app alpine sh -c 'rm -rf var/*'
api-permissions:
	docker run --rm -v ${PWD}/api:/app -w /app alpine chmod -R 777 *
api-wait-db:
	docker-compose run --rm api-php-cli wait-for-it api-postgres:5432 -t 30
api-check: lint psalm-no-diff phpunit phpunit-functional


#######################  DOCKER  ##########################
up:
	docker-compose up -d
down:
	docker-compose down --remove-orphans
restart: down up
down-clear:
	docker-compose down -v --remove-orphans
build:
	docker-compose build --pull
pull:
	docker-compose pull
pure-docker:
	docker system prune -af


#######################  DOCTRINE  ##########################
api-migrate:
	docker-compose run --rm api-php-cli php bin/app.php --ansi migrations:migrate --no-interaction
api-diff:
	docker-compose run --rm api-php-cli php bin/app.php --ansi migrations:diff --no-interaction
api-fixtures:
	docker-compose run --rm api-php-cli php bin/app.php --ansi fixtures:load


#######################  COMPOSER  ##########################
composer-i:
	docker-compose run --rm api-php-cli composer install
composer-da:
	docker-compose run --rm api-php-cli composer dump-autoload
composer-u:
	docker-compose run --rm api-php-cli composer update
composer-u-list:
	docker-compose run --rm api-php-cli composer outdated
composer-u-list-direct:
	docker-compose run --rm api-php-cli composer outdated --direct
composer-rq:
	docker-compose run --rm api-php-cli composer require ${arg}
composer-rm:
	docker-compose run --rm api-php-cli composer remove ${arg}


#######################  CODE STYLE  ####################
lint:
	docker-compose run --rm api-php-cli vendor/bin/phplint
	docker-compose run --rm api-php-cli vendor/bin/phpcs
cs-fix:
	docker-compose run --rm api-php-cli vendor/bin/phpcbf
psalm:
	docker-compose run --rm api-php-cli vendor/bin/psalm
psalm-no-diff:
	docker-compose run --rm api-php-cli vendor/bin/psalm --no-diff

#######################  TESTs  ####################
test:
	docker-compose run --rm api-php-cli vendor/bin/phpunit --colors=always --coverage-html var/coverage ${arg}
coverage:
	docker-compose run --rm api-php-cli vendor/bin/phpunit --colors=always --coverage-html var/test/coverage
phpunit:
	docker-compose run --rm api-php-cli vendor/bin/phpunit --colors=always --coverage-html var/coverage --testsuite=unit ${arg}
phpunit-functional:
	docker-compose run --rm api-php-cli vendor/bin/phpunit --colors=always --coverage-html var/coverage --testsuite=functional ${arg}


#######################  CLI  ####################
php-cli:
	docker-compose run --rm api-php-cli php cli.php ${arg}
app-cli:
	docker-compose run --rm api-php-cli php bin/app.php --ansi ${arg}
