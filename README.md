# Сервис мониторинга продукции в торговых точках

### Создание нового пользователя
1. Запустить команду `bin/console app:create-user admin@admin.admin admin` (где, `admin@admin.admin` - email, a `admin` - пароль).

### Локальная установка
1. Запуск контейнеров: `docker-compose up`
2. Скачивание зависимостей: `docker-compose exec php composer install`
3. Доступ: http://127.0.0.1/

### Билд обновленных css-стилей и js-скриптов
1. Для dev-среды: `docker-compose exec php yarn encore dev`
2. Для prod-среды: `docker-compose exec php yarn encore prod`
