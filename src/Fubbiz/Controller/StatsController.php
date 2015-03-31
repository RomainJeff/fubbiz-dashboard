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
}
