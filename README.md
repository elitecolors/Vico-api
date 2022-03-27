# Docker && symfony 6 && codeception dev test


**Docker container set-up for Symfony 6.0:**
* nginx
* PHP 8.0
* MariaDB 10.6
* Phpmyadmin 5.1
* codeception

### Installation:

1. Bring up the containers: `docker-compose up -d --build`

2. docker-compose exec vicoapi-phpserver /bin/bash 

3. composer install

### api url 
http://localhost:8080/api/doc.json

### Codeception

    php vendor/bin/codecept build

    php vendor/bin/codecept run api --steps -d


### dev command

* php-cs-fixer

    vendor/bin/php-cs-fixer fix --using-cache=no --rules=@Symfony src

* phpstan

  vendor/bin/phpstan analyse