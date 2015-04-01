<?php
namespace Fubbiz\Controller;

use Silex\Application;

use Fubbiz\Model\Users AS UsersModel;


class StatsController
{
    /**
     * /stats/{usernames}
     * Recupere et envoie les stats d'un ou plusieurs utilisateurs
     *
     */
    public function getAction(Application $app, $usernames)
    {
        $usersModel = new UsersModel($app['db']);
        $usernames = (strpos($usernames, ';')) ? explode(';', $usernames) : [$usernames];
        $toReturn = [];

        foreach ($usernames AS $username) {
            $stats = $usersModel->getAllStatsByUsername($username);

            if (!$stats) {
                return ResponseController::error("The user {$username} doesn't exist", 404);
            }

            $toReturn[$username] = [
                "oeuvre" => $stats["oeuvre_id"],
                "stats"  => $stats["stats"]
            ];
        }

        if (count($toReturn) <= 0) {
            return ResponseController::error('No stats for this users', 404);
        }

        return ResponseController::success($toReturn);
    }


    /**
     * /stats/{usernames}/{date}
     * Recupere et envoie les stats d'un ou plusieurs utilisateurs a une date donnee
     *
     */
    public function getDateAction(Application $app, $usernames, $date)
    {
        $usersModel = new UsersModel($app['db']);
        $usernames = (strpos($usernames, ';')) ? explode(';', $usernames) : [$usernames];
        $toReturn = [];

        foreach ($usernames AS $username) {
            $stats = $usersModel->getDateStatsByUsername($username, $date);

            if (!$stats) {
                return ResponseController::error("The user {$username} doesn't exist or the date passed is invalid", 404);
            }

            $toReturn[$username] = [
                "oeuvre" => $stats["oeuvre_id"],
                "stats"  => $stats["stats"]
            ];
        }

        if (count($toReturn) <= 0) {
            return ResponseController::error('No stats for this users and date', 404);
        }

        return ResponseController::success($toReturn);
    }
}
