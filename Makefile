.DEFAULT_GOAL := help


.PHONY: help
help: ## Справка по командам
	@grep -E '^.*:.*?## .*$$' $(MAKEFILE_LIST) \
		| grep -v '@grep' | grep -v 'BEGIN' | sort \
		| awk 'BEGIN {FS = ":.*? ## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'


.PHONY: build
build: prebuild migrate tests/migrate tests/run ## Билд приложения

prebuild:
	@docker-compose up -d
	@docker-compose exec php composer install


.PHONY: compile-dev
compile-dev: ## Компиляция css-стилей и js-скриптов (development)
	@docker-compose exec php yarn encore dev


.PHONY: compile-prod
compile-prod: ## Компиляция css-стилей и js-скриптов (production)
	@docker-compose exec php yarn encore prod


.PHONY: migrate
migrate: ## Выполнение миграций БД
	@docker-compose exec php bin/phinx migrate


.PHONY: rollback
rollback: ## Откат последней миграции БД
	@docker-compose exec php bin/phinx rollback


.PHONY: tests/run
tests/run: ## Запуск юнит-тестов
	@docker-compose exec php bin/phpunit


.PHONY: tests/migrate
tests/migrate: ## Выполнение миграций тестовой БД
	@docker-compose exec php bin/phinx migrate -e test


.PHONY: tests/rollback
tests/rollback: ## Откат последней миграции тестовой БД
	@docker-compose exec php bin/phinx rollback -e test
