build:
	cd ./client && npm install
	cd ./client && cp .env.example .env
	cd ./api && cp .env.example .env
	docker-compose build
	@make up
	docker exec api_question composer install
	docker exec api_question php artisan key:generate
	sleep 1
	docker exec api_question php artisan migrate:fresh --seed
up:
	docker-compose up -d
down:
	docker-compose down

