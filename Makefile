#!make

up: docker-up ## Start server
down: docker-down ## Stop server
restart: docker-down docker-up ## Re-start server (Stop/Start)

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans
