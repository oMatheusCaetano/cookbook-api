run:
	docker compose up --build --force-recreate

run-detached:
	docker compose up --build --force-recreate -d

migration-up:
	docker exec -it cookbook-api php artisan migrate

%:
	@:
