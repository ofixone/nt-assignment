# Test Assignment NT
### Symfony tasks №1-6
I added namespaces simply to delimit scopes and to "theoretically" redo everything into classes and add tests.
Anyway, I hope it won't affect readability :)

#### Structure
All src code located in ``plain-tasks/src/AppBundle`` directory

### Symfony task №7
Here is a completed task on Symfony 3 using some additional libraries and Docker

#### Structure
All src code located in ``symfony-task/src/AppBundle`` directory.

#### Base
- Copy ``.env.example`` to ``.env``:
- Up Docker container by
```bash
docker-compose up -d
```

- Jump into ``bash``
```bash
docker-compose exec app bash
```

- Don't forget to run composer
```bash
composer install
```
- Set Jwt passphrase in ``app/config/parameters.yml`` and default database preset
```yaml
# if you run app buy default docker settings, it should be like this:
parameters:
    database_host: db
    database_port: 3306
    database_name: db
    database_user: root
    database_password: root
    jwt_secret: 12345
```

- Generate your own keys using same passphrase and make keys writeable
```bash
openssl genrsa -out app/config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in app/config/jwt/private.pem -out app/config/jwt/public.pem
chmod -R 0755 app/config/jwt
```

- Copy ``.env.example`` to ``.env`` and change it if you need it

- Up database schema
```bash
php bin/console doctrine:schema:update --force
```

- Run fixtures
```bash
php bin/console doctrine:fixture:load
```

Now you can use ``http://localhost:8000`` url.
Example contains in ``rest_templates.http``