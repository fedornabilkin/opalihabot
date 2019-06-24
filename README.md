Развертывание проекта
---

* Создаем файл .env
```
# DB
pg_db_name=telebot
pg_db_user=root
pg_db_password=password

# Hosts
host_telegram_api=api.telegram.org:149.154.167.220

# Ports host
port_host_wkhtml=8089
port_host_app=8092

# Ports service
port_service_web=8090
port_service_db=5442
```

* В файле `docker/dockerfile-composer` комментируем/раскомментируем, чтобы было так
```
ENTRYPOINT composer install --no-interaction && /bin/bash
#ENTRYPOINT php /code/run.php
```
* Собираем образы `docker-compose build`
* Запускаем контейнеры `docker-compose up -d`

Запуск проекта
---

* В `/code` выполняем `php init`, чтобы создать `code/config/conf.php` 
и `code/config/conf-local.php`
(можно не заходить в контейнер, в файле `conf-local.php` изменяем настройки)
* В файле `docker/dockerfile-composer` комментируем/раскомментируем, чтобы было так
```
#ENTRYPOINT composer install --no-interaction && /bin/bash
ENTRYPOINT php /code/run.php
```
* Пересобираем образ `docker-compose build app`
* Запускаем контейнер `docker-compose up -d --force-recreate app`

