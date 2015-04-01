<?php
/**
 * DashboardFubbiz
 * Developed by Romain QUILLIOT
 *
 * PRODUCTION FILE
 *
 *
 **/
date_default_timezone_set('Europe/Paris');


// On inclue la configuration MySQL de production
require_once __DIR__ ."/config/mysql/prod.php";

// On inclue l'application
require_once __DIR__ ."/web/app.php";

// On inclue le error handler
require_once __DIR__ ."/config/errorhandler.php";

// On lance l'appliclation
$app->run();
