current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps start

.PHONY: deps
deps: composer-install

# 🐘 Composer
.PHONY: composer-install
composer-install: CMD=install

.PHONY: composer-update
composer-update: CMD=update

.PHONY: composer-require
composer-require: CMD=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: CMD=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

.PHONY: composer
composer composer-install composer-update composer-require composer-require-module:
	@docker run --rm $(INTERACTIVE) --volume $(current-dir)/app:/app --user $(id -u):$(id -g) \
		composer:2 $(CMD) \
			--ignore-platform-reqs \
			--no-ansi

.PHONY: test
test:
	docker exec vending-local ./vendor/bin/phpunit --testsuite vending

# 🐳 Docker Compose
.PHONY: start
start: CMD=up --build -d

.PHONY: stop
stop: CMD=stop

.PHONY: destroy
destroy: CMD=down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
.PHONY: doco
doco start stop destroy:
	@docker-compose $(CMD)

.PHONY: rebuild
rebuild:
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

clean-cache:
	@rm -rf apps/*/*/var
	@docker exec -u0 vending-local php /app/apps/vending/backend/bin/console cache:warmup

init-db:
	@docker exec -u0 vending-local php /app/apps/vending/backend/bin/console vending:machine:setup


