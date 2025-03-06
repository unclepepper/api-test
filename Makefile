PROJECT_NAME="$(shell basename "$(PWD)")"
PROJECT_DIR="$(shell pwd)"
DOCKER_COMPOSE="$(shell which docker-compose)"
DOCKER="$(shell which docker)"
CONTAINER_PHP="php-fpm"
BLUE_BOLD=\e[1;34m

init:
	cp -n .env .env.local || true && \
	cp -n .env.test .env.test.local || true && \
	make up && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer install --no-interaction && \
	make alert-database && \
	sleep 1 && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:database:create --if-not-exists -n --env=dev && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate -n --env=dev && \
	make alert-tests-start && \
	sleep 1 && \
	make tests-start



alert-database:
	- @echo  $$(tput sgr 1)"${BLUE_BOLD}                        Creating database...                   ${RESET_COLOR}"$$(tput sgr 0)

alert-database-test:
	- @echo $$(tput sqr 1)"${BLUE_BOLD}                      'Creating test database'                  ${RESET_COLOR}"$$(tput sgr 0)

alert-tests-start:
	- @echo $$(tput sqr 1)"${BLUE_BOLD}                         'Tests start'                          ${RESET_COLOR}"$$(tput sgr 0)
up:
	${DOCKER_COMPOSE} up --build -d

build:
	${DOCKER_COMPOSE} build

down:
	${DOCKER_COMPOSE} down --remove-orphans
ps:
	${DOCKER_COMPOSE} ps

bash:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} /bin/bash

migrate-db:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:migrations:migrate -n --env=dev

create-db:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console doctrine:database:create --if-not-exists -n --env=dev

logs:
	${DOCKER_COMPOSE} logs -f

ci:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} composer install


cs-fix:
	${CONTAINER_EXEC} ./vendor/bin/php-cs-fixer fix src

stan:
	${CONTAINER_EXEC} vendor/bin/phpstan analyze -c phpstan.neon --memory-limit 2G src

stan-cc: ## Clear phpStan cache
	${CONTAINER_EXEC} vendor/bin/phpstan clear-result-cache
cc:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console cache:clear

tests-start:
	make alert-database-test && \
	sleep 1 && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console --if-not-exists -n --env=test doctrine:database:create && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console  --env=test doctrine:schema:create && \
	make fixture-load  || true && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} vendor/bin/phpunit
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console  --env=test doctrine:database:drop --force

tests-debug:
	make fixture-load  || true && \
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} vendor/bin/phpunit --debug

fixture-load:
	${DOCKER_COMPOSE} exec ${CONTAINER_PHP} bin/console --env=test doctrine:fixtures:load

