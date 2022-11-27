up:
	docker-compose up --build -d

install:
	docker exec -it payment-authorize_app composer install

update:
	docker exec -it payment-authorize_app composer update

down:
	docker-compose down
