Настройка инфраструктуры проекта
================================

Сразу после запуска
-------------------

Необходимо войти в контейнер mysql и накатить дамп
````
docker exec -it stroimos-mysql bash -c "mysql -u root -p[пароль от root без квадратных скобок] -vvv < /tmp/dump.sql 2>&1" | sed -nE '/^(CREATE|INSERT|UPDATE|DELETE)/{s/(VALUES|SET).*/.../;p}'

Или 

docker exec -it mysql-stroimos bash
mysql -u stroi_mos_ru -p # ввести пароль от stroi_mos_ru
use stroi_mos_ru;
source /tmp/dump.sql;

````
Далее нужно создать ссылки на файлы css, js и png|jpg, подключаемые в проекте из пакета sonata.
Необходимо выполнить в папке проекта команду (в Windows рекомендуется PowerShell) :
```
php app/console assets:install --symlink --relative
```

Настройка Elastic
-----------------
После установки Elasticsearch необходимо добавить плагин analysis-morphology

```
 [tfadm@stroi-prod-db ~]$ curl http://127.0.0.1:9200/_cat/plugins?v
 name component           version type url 
 Tusk analysis-morphology NA      j 
```
