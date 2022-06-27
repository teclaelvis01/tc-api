Prueba técnica [TC]
======================

Requerimientos:

- PHP >= 7.2
- Mysql última versión
- nginx server o apache server

configuración de directiva en nginx
````nginx
location / {
    try_files $uri $uri/ /index.php$query_string;
} 
````

configuración de directiva en apache
````apache
Options +FollowSymLinks -Indexes
RewriteEngine On
 
RewriteCond %{HTTP:Authorization} .
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
 
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
````




Instalación
============

- Descomprimir proyect.zip o clonar este repositorio.
- Dentro de la carpeta del proyecto instalar las depenendicias con `composer install`
- Configurar el servidor para que cargue la carpeta `/public`

Ejemplo en nginx:
``` nginx
    root /var/www/public;
```

### Estructura del proyecto
``` bash
├── database.sql
├── logs
├── public
│   └── index.php
└── src
    ├── Bootstrap.php
    ├── Config
    │   └── database.conf.php
    ├── Core
    │   ├── Database
    │   │   └── DB.php
    │   ├── Libraries
    │   │   ├── Exceptions
    │   │   │   └── TelecomException.php
    │   │   ├── HttpResponse.php
    │   │   ├── Logguer
    │   │   │   └── Logguer.php
    │   │   ├── Traits
    │   │   │   └── ModelManipulation.php
    │   │   └── Validator.php
    │   └── Router
    │       ├── Request.php
    │       ├── Route.php
    │       └── Uri.php
    ├── Http
    │   ├── Controllers
    │   │   ├── BaseController.php
    │   │   └── NotificationsController.php
    │   └── Response.php
    ├── Models
    │   ├── Collection.php
    │   ├── Model.php
    │   └── Subscriptor.php
    └── Routes
        └── api.php
```

### Base de datos
Los credenciales de configuración se encuentran en  `src/Config/database.conf.php`

- Crear base de datos con el nombre `telecoming`
- Cargar la base de datos `database.sql`


Documentación de la api
==========================

La documentación del uso de esta api se puede encontrar en  [Postmant](https://documenter.getpostman.com/view/2447850/UzBsHjCs) 
