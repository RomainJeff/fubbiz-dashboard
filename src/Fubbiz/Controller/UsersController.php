<?php
namespace Fubbiz\Controller;

use Silex\Application;

use Fubbiz\Model\Users AS UsersModel;


class UsersController
{
    /**
     * /users
     * Recupere et envoie la liste des utilisateurs
     *
     */
    public function getAction(Application $app)
    {
        $usersModel = new UsersModel($app['db']);
        $usersList = $usersModel->listing();

        if (count($usersList) <= 0) {
            return ResponseController::error('No users to display', 404);
        }

        return ResponseController::success($usersList);
    }
}
