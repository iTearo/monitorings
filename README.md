# Сервис мониторинга продукции в торговых точках

### Создание нового пользователя
1. Запустить команду `bin/console app:create-user admin@admin.admin admin` (где, `admin@admin.admin` - email, a `admin` - пароль).

### Локальная установка
1. Запуск контейнеров: `make build`
3. Доступ: http://127.0.0.1/

### Компиляция обновленных css-стилей и js-скриптов
1. Для dev-среды: `make compile-dev`
2. Для prod-среды: `make compile-prod`
