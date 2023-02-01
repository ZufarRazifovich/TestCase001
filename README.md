# TestCase01
 
## Запустите терминал в директории backend
## Введите команду docker-compose up
## Введите команду docker exec -it {CONTAINER_ID - "backend_php-fpm"} sh
## Внутри контейнера, введите команду composer i
## Переименуйте .env-example в .env
## Запустите команду php artisan queue:work, для того чтобы запустить воркер очереди

## Запустите терминал в директории frontend
## Введите команду npm i чтобы установить все необходимые пакеты
## Введите, и запустите команду npm run dev