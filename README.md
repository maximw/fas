
Run that:

```
git clone https://github.com/maximw/fas.git
```

```
docekr-compose up -d
```

```
docekr-compose exec mysql mysql bash
```

```
mysql -u root -p123 < /var/sql/fas.sql
```

```
exit
```

```
docekr-compose exec php bash
```

```
composer update --prefer-dist
```

```
exit
```

```
chmod -R 777  ./web/assets/
```

use root:123 in login form
