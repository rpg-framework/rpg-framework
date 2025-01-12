<?php

// System
require __DIR__."/settings.php";
require __DIR__."/route.php";
require __DIR__."/log.php";

$settings = new settings;
$route = new route;
$log = new log;

// Database
require __DIR__."/databases/mysql.php";
require __DIR__."/databases/model.php";

// Framework
require __DIR__."/rpg.php";
