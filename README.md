# rpg-framework

A small and fast PHP framework.

## System Settings

System settings are defined in settings.php. The settings you can change are Constants, Database, and Defaults.

   * Constants → Timezone, language, and debug definitions.
   * Database  → Database connection information.
   * Defaults  → Project defaults.

## Root Directory

The root directory of your project is `public`. The index.php inside it manages all routes. You can upload CSS, JS, webfonts, images, robots.txt, sitemap.xml, and all accessible resources to this directory.

## Installation

Clone the rpg-framework repository and upload it to the default directory of your web server.

## Apache Configuration

RPG comes with a `.htaccess` configuration in the `public` directory for Apache.

## Nginx Configuration

You can run the RPG Framework with the nginx configuration provided here.

```
    server {
        listen 80;

        server_name localhost;
        root /var/www/html/rpg-framework/public;
     
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";
     
        index index.php;
     
        charset utf-8;
     
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
     
        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }
     
        error_page 404 /index.php;
     
        location ~ ^/index\.php(/|$) {
            fastcgi_hide_header X-Powered-By;

            include fastcgi_params;
            fastcgi_pass unix:/run/php-fpm/www.sock;

            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
     
        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
```

## Route Definition

To define a route, a PHP class is created in `app/controllers` that contains the page name. The file and class name must be in lowercase. The `main` method is automatically executed when the address is accessed.

Example for `example.com/contact`:

Create file: `app/controllers/contact.php`

File content:

```
    class contact extends controller
    {
        public function main()
        {
            echo "Hello World!";
        }
    }
```

The controller class is inherited from `app/base/controller.php`. This serves as a base controller to avoid rewriting methods you need to use on every page.

## Defaults

Defaults are located in `system/settings.php`. You can enter as many defaults as you want in this field. There are two important variables in the defaults: the `$index` and `$error` variables.

   * `$index`: The page that receives incoming links to your website. If you want your homepage to be accessed as `example.com` or `example.com/index`, do not change the default value. You need to create `app/controllers/index.php`.

   * `$error`: The page that your website will call when an address is not found. The default value is `not_found`. You can call any error page you want by creating `app/controllers/not_found.php`.

## Examples

  * Small scale project example - Documentation (Dual language [tr/en], Internal search, No database!) Fast development process for fixed and small projects, Corporate sites etc. [rpg-docs](https://github.com/fuatboluk/rpg-docs)

  * Medium scale project example - Blog (Dual language [tr/en], Database search, pagination, session and user management, comments and likes etc.) Coming soon!

  * Large scale project example - E-Commerce (Dual language [tr/en], Database search, pagination, session and user management, comments and likes, notifications, admin panel etc.) Coming soon!
