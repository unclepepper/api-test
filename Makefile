PROJECT_NAME="$(shell basename "$(PWD)")"
PROJECT_DIR="$(shell pwd)"
DOCKER_COMPOSE="$(shell which docker-compose)"
DOCKER="$(shell which docker)"
CONTAINER_PHP="php-fpm"
BLUE_BOLD=\e[1;34m



alert-database:
	- @echo  $$(tput sgr 1)"${BLUE_BOLD}                        Creating database...                   ${RESET_COLOR}"$$(tput sgr 0)

up:
	${DOCKER_COMPOSE} up --build -d

build:
	${DOCKER_COMPOSE} build

down:
	${DOCKER_COMPOSE} down
ps:
	${DOCKER_COMPOSE} ps

bash:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} /bin/bash

migrate-db:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate -n --env=dev

logs:
	${DOCKER_COMPOSE} logs -f

ci:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer install


init:
	make copy-env && \
	make up && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer install --no-interaction && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:database:create --if-not-exists -n --env=dev && \
    ${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate -n --env=dev

copy-env:
	cp .env .env.local

cs-fix:
	${CONTAINER_EXEC} ./vendor/bin/php-cs-fixer fix src

stan:
	${CONTAINER_EXEC} vendor/bin/phpstan analyze -c phpstan.neon --memory-limit 2G src

stan-cc: ## Clear phpStan cache
	${CONTAINER_EXEC} vendor/bin/phpstan clear-result-cache