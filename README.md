### Тестовый проект TAGREE

> стек - docker + php-fpm (php 8.1.18 + laravel 8.83.27) + nginx + mysql (v5.7) + phpmyadmin

### для запуска проекта:
1. убрать комментарии в файлах:
    - ./docker-compose.local.yml
    - ./.env.local
2. выполнить миграции таблиц в БД
    - php artisan migrate --path=database/migrations/2023_04_30_000010_create_authors_table.php
    - php artisan migrate --path=database/migrations/2023_04_30_000300_create_posts_table.php
3. выполнить наполнение БД тестовыми данными
    - php artisan db:seed
4. сборка docker проекта настроена через make файл, команды посмотреть можно в ./makefile
5. роуты в проекте
    - GET /author - все авторы
    - GET /author/{slug} - автор, детальная информация
    - PUT /author/edit - не реализовывалось
    - GET /author/remove/{id} - не реализовывалось
    - POST /author/add - добавление автора
    - GET /post - все посты
    - GET /post/{slug} - пост, детальная информация
    - PUT /post/edit - не реализовывалось
    - GET /post/remove/{id} - не реализовывалось
    - POST /post/add - добавление новости

>
    в каталоге doc лежат:
    - диаграма БД
    - коллекция postman по эндпоинтам API
