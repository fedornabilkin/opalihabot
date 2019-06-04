Развертывание проекта
---

* В файле `docker/dockerfile-composer` комментируем/раскомментируем, чтобы было так
```
ENTRYPOINT /bin/bash
#ENTRYPOINT php /code/run.php
```
* Собираем образы `docker-compose -f docker-compose.dev.yml build`
* Запускаем контейнеры `docker-compose -f docker-compose.dev.yml up -d`
* Заходим в контейнер `docker-compose exec app bash` и выполняем `composer install`

Запуск проекта
---

* В `/code` выполняем `php init`, чтобы создать `code/example/conf.php` 
и `code/example/conf-local.php`
(можно не заходить в контейнер, в файле `conf-local.php` изменяем настройки)
* В файле `docker/dockerfile-composer` комментируем/раскомментируем, чтобы было так
```
#ENTRYPOINT /bin/bash
ENTRYPOINT php /code/run.php
```
* Пересобираем образ `docker-compose -f docker-compose.dev.yml build app`
* Запускаем контейнер `docker-compose -f docker-compose.dev.yml up -d --force-recreate app`

