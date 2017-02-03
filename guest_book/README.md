guest_book
==========

A Symfony project created on January 18, 2017, 1:18 pm.

- git clone the project
- install composer at https://getcomposer.org/download/
- setup composer with `php composer-setup.php --install-dir=bin`
- cd into the project directory and run `composer install -o`
- the database_host should be `localhost`, the database_name `symfony`, database_user `root` and database_password `root`
- optionally run `php app/check.php` to check if the system can run symfony
- run `php app/console doctrine:database:drop --force`
- run `php app/console doctrine:database:create`
- run `php app/console doctrine:schema:update --force --dump-sql --complete`
- run `php app/console doctrine:schema:validate` to validate the schema, it should be successful
- run `php app/console hautelook_alice:doctrine:fixtures:load` or `php app/console hautelook_alice:doctrine:fixtures:load --purge-with-truncate` to load fixtures
- run `php app/console cache:clear --env=dev` to clear dev cache, `php app/console cache:clear --env=prod` to clear the production environment or `php app/console cache:clear` to clear all caches
- clearing the cache should come back as successful
- optionally you can execute `rm -rf app/cache` to delete the cache directory
- login into mysql and execute the following command for the database in parameters.yml `update entry a set a.number_of_comments = (select d.cnt from (select a.id, count(b.id) as cnt from entry a inner join entry b where b.entry_id = a.id group by 1) d where d.id = a.id);`
- run the local server `php app/console server:start`
- access the dev site at http://localhost:8000/app_dev.php/ or http://127.0.0.1:8000/app_dev.php/
- access the prod site at http://localhost:8000/ or http://127.0.0.1:8000/
