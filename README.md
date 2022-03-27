# Test Assignment NT
### Symfony task №7
Here is a completed task on Symfony 3 using some additional libraries and Docker

#### Structure
All src code located in ``symfony-task/src/AppBundle`` directory.

#### Base
Up Docker container by:
```bash
docker-compose up -d
```

Jump into ``bash``:
```bash
docker-compose exec app bash
```

Don't forget to run composer
```bash
composer install
```
Set Jwt passphrase in ``app/config/parameters.yml``
```yaml
parameters:
    ...
    jwt_secret: 12345
```

Generate your own keys using same passphrase and make keys writeable:
```bash
openssl genrsa -out app/config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in app/config/jwt/private.pem -out app/config/jwt/public.pem
chmod -R 0755 app/config/jwt
```

Up database schema
```bash
php bin/console doctrine:schema:update --force
```

Now you can use ``http://localhost:8000`` url.
Example contains in ``rest_templates.http``