<?php


/**
 *
 * USERS ROUTES
 *
 */
$app->get(
    "/users",
    "Fubbiz\Controller\UsersController::getAction"
);


#------------------------------#
#------------------------------#


/**
 *
 * STATS ROUTES
 *
 */
$app->get(
    '/stats/{usernames}',
    "Fubbiz\Controller\StatsController::getAction"
);


$app->get(
    '/stats/{usernames}/{date}',
    "Fubbiz\Controller\StatsController::getDateAction"
);


#------------------------------#
#------------------------------#


/**
 *
 * UPDATE ROUTES
 *
 */
$app->get(
    '/update',
    "Fubbiz\Controller\UpdateController::saveAction"
);
