Развертывание проекта
---

* Создаем файл .env
```
B_BOT_TOKEN=
B_HOST_IP=10.0.2.15

# DEV or PROD
B_ENVIRONMENT=DEV

# DB
B_POSTGRES_HOST=10.0.2.15
B_POSTGRES_PORT=5442
B_POSTGRES_NAME=dbname
B_POSTGRES_USER=user
B_POSTGRES_PASSWORD=pass

# Ports host
B_WKHTML_PORT=8089
B_APP_PORT=8092
B_WEB_PORT=8090

# Proxy
B_PROXY_USE=false
B_PROXY_ADDRESS=125.125.125.125
B_PROXY_PORT=8000
B_PROXY_USER=user
B_PROXY_PASSWORD=pass
```

* В файле `docker/dockerfile-composer` комментируем/раскомментируем, чтобы было так
```
ENTRYPOINT composer install --no-interaction && /bin/bash
#ENTRYPOINT php /code/run.php
```
* Собираем образы `docker-compose build`
* Запускаем контейнеры `docker-compose up -d`
* В файле `docker/dockerfile-composer` комментируем/раскомментируем, чтобы было так
```
#ENTRYPOINT composer install --no-interaction && /bin/bash
ENTRYPOINT php /code/run.php
```
* Пересобираем образ `docker-compose build app`
* Запускаем контейнер `docker-compose up -d --force-recreate app`

