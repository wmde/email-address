current_user  := $(shell id -u)
current_group := $(shell id -g)

BUILD_DIR     := $(PWD)
COMPOSER_FLAGS :=
DOCKER_FLAGS  := --interactive --tty
DOCKER_IMAGE  := registry.gitlab.com/fun-tech/fundraising-frontend-docker

.PHONY: ci test phpunit cs stan composer

ci: test cs

test: phpunit

cs: phpcs stan

install-php: install

install:
	docker run --rm $(DOCKER_FLAGS) --volume $(BUILD_DIR):/app -w /app --volume /tmp:/tmp --volume ~/.composer:/composer --user $(current_user):$(current_group) $(DOCKER_IMAGE):composer composer install $(COMPOSER_FLAGS)

update-php: update

update:
	docker run --rm $(DOCKER_FLAGS) --volume $(BUILD_DIR):/app -w /app --volume /tmp:/tmp --volume ~/.composer:/composer --user $(current_user):$(current_group) $(DOCKER_IMAGE):composer composer update $(COMPOSER_FLAGS)

phpunit:
	docker compose run --rm app ./vendor/bin/phpunit

phpcs:
	docker compose run --rm app ./vendor/bin/phpcs

stan:
	docker compose run --rm app ./vendor/bin/phpstan analyse --level=9 --no-progress src/ tests/

fix-cs:
	docker compose run --rm app ./vendor/bin/phpcbf
