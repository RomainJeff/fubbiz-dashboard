<?php
/**
 * DashboardFubbiz
 * Developed by Romain QUILLIOT
 *
 * DEVELOPMENT FILE
 *
 **/

// On fake la requete AJAX
$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

// On inclue la configuration mysql de Dev
require_once dirname(__DIR__) ."/config/mysql/dev.php";

// On inclue l'application
require_once __DIR__ ."/app.php";

// On configure l'application
$app['debug'] = true;

// On lance l'appliclation
$app->run();
