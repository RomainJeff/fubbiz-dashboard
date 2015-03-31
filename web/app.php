<?php

// On charge l'autoloader
require_once dirname(__DIR__) ."/vendor/autoload.php";


// On instancie l'application
$app = new Silex\Application();

// Configurations MySQL
require_once dirname(__DIR__) ."/config/mysql.php";

// Before & After
require_once dirname(__DIR__) ."/config/calls.php";

// Routing System
require_once dirname(__DIR__) ."/config/routing.php";
