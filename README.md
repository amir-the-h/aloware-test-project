Comment System
===============

Requirements
------------
- php >= 7.3
- nodejs = v16.8.0
- npm = 7.21.0

The js requirements were my machine's version at the time of developing. It may work on lower versions too.

Installation
------------
- ```bash
  composer install && php artisan key:generate
  ```
- ```bash
  npm i && npm run prod
  ```

Testing
-----------
For the first time you need to generate an app key for test env 
```bash
php artisan key:generate --env=testing
``` 
and then set your configs in `.env.testing` file.

```bash
php artisan test
```