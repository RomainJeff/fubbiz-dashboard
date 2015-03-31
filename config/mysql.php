<?php

/**
 *
 * Configurer les bases de donnees
 *     - Une principale
 *     - Une logs
 *
 */
$app->register(new Silex\Provider\DoctrineServiceProvider(), [
    'dbs.options'    => [
        'default'    => [
            'driver'    => 'pdo_mysql',
            'host'      => $mysqlHost['default'],
            'dbname'    => $mysqlBase['default'],
            'user'      => $mysqlUser['default'],
            'password'  => $mysqlPass['default'],
            'charset'   => 'utf8'
        ]
    ]
]);
