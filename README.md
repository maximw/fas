
Run that:

```
git clone https://github.com/maximw/fas.git
```

```
cd ./fas
```

```
docker-compose up -d
```

```
docker-compose exec mysql bash
```

```
mysql -u root -p123 < /var/sql/fas.sql
```

```
exit
```

```
docker-compose exec php bash
```

```
composer update --prefer-dist
```

```
mkdir ./rbac
```

```
php yii rbac/init
```

```
chmod -R 777 ./rbac
```

```
chmod -R 777 ./web/assets/
```

```
mkdir ./uploads
```
```
chmod -R 777 ./uploads
```


```
exit
```

Open <a href="http://localhost:8000">http://localhost:8000</a>

use `root:123` in login form
