# Docker Laravel

#### . Clone project
#### . Navigate in project directory  
`cd agendamentos`

#### . Create .env file
`cp .env.example .env`  

#### . Start everything
`docker-compose up -d --build`  

#### Composer

` docker compose exec php bash`
###
`composer install`

#### . Generate key for Laravel application
`php artisan key:generate`  


.env:
```
APP_NAME=EstéticaDental
APP_ENV=local
APP_KEY=base64:iH41/QOu0S9A8krpI/YGTmd9vnFq1KplJd5hOr4006g=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=setup-mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=setup-redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=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
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=atendimento.esteticadental@gmail.com
MAIL_FROM_NAME="Estética Dental"

SENDGRID_API_KEY=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

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```


