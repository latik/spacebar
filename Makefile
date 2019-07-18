DOCKER-COMPOSE	= docker-compose -f docker-compose.yml

build: ## build project docker containers
	$(DOCKER-COMPOSE) build --no-cache

start: ## start the project
	$(DOCKER-COMPOSE) up -d

stop: ## stop the project
	$(DOCKER-COMPOSE) stop

destroy: ## removes containers, networks, volumes, and images
	$(DOCKER-COMPOSE) down --volumes --remove-orphans

.DEFAULT_GOAL := help

help:
	@echo "Please choose a task:"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help