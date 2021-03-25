install:
	docker-compose up -d
	docker-compose exec php php composer.phar install