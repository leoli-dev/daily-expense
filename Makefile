#######################
# DEV TASKS
#######################

setup:
	cp docker-compose.yml.dist docker-compose.yml && \
	cp .env .env.local

init:
	composer install --no-interaction --prefer-dist && \
	php bin/console assets:install && \
	yarn install && \
	yarn build

init_db:
	php bin/console doctrine:schema:update -f && \
	php bin/console doctirne:fixtures:load  --append

follow_logs:
	tail -f var/log/*.log
