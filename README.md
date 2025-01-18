# php-rpg

A small and fast PHP framework.

## System Settings

System settings are defined in settings.php. The settings you can change are Constants, Database, and Defaults.

   * Constants → Timezone, language, and debug definitions.
   * Database → Database connection information.
   * Defaults → Project defaults.

## Root Directory

The root directory of your project is "public". The index.php inside it manages all routes. You can upload CSS, JS, webfonts, images, robots.txt, sitemap.xml, and all accessible resources to this directory.

## Installation

You can clone the php-rpg repository, configure it for your web server, and run it. If you get a page that says "It works!", it is working. It includes the Nginx web server configuration.

## Route Definition

To define a route, a PHP class is created in app/controllers that contains the page name. The file and class name must be in lowercase. The "run" method is automatically executed when the address is accessed.

Example for example.com/contact:

Create file: app/controllers/contact.php

File content:

```
    class contact extends controller
    {
        public function run()
        {
            echo "Hello World!";
        }
    }
```

The controller class is inherited from app/base/controller.php. This serves as a base controller to avoid rewriting methods you need to use on every page.

## Defaults

Defaults are located in system/settings.php. You can enter as many defaults as you want in this field. There are two important variables in the defaults: the $index and $error variables.

   * $index: The page that receives incoming links to your website. If you want your homepage to be accessed as "example.com" or "example.com/index", do not change the default value. You need to create app/controllers/index.php.

   * $error: The page that your website will call when an address is not found. The default value is "not_found". You can call any error page you want by creating app/controllers/not_found.php.
