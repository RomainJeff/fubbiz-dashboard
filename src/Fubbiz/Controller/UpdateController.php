<?php
namespace Fubbiz\Controller;

use Goutte\Client;
use Silex\Application;

use Fubbiz\Model\Users as UsersModel;


class UpdateController
{

    /**
     * /update
     * Met a jour les donnees
     *
     */
    public function saveAction(Application $app)
    {
        $date = date('Y-m-d');
        $hour = date('H');
        $usersModel = new UsersModel($app['db']);


        if ($usersModel->countDataByDateAndHour($date, $hour) > 0) {
            return ResponseController::error('Data already saved for this hour', 200);
        }


        $client = new Client();
        $crawler = $client->request('GET', 'https://fubiz.surfacecc.com/galerie?creation=502fbbc9-d281-11e4-9ff2-0cc47a44c586');
        $oeuvres = $this->decodeOeuvres($crawler->filter('script:nth-child(2)')->extract('_text'));


        foreach ($oeuvres as $oeuvre) {
            $datas = [];
            $datas['oeuvre'] = $oeuvre->uid;
            $datas['username'] = $oeuvre->username;
            $datas['date'] = $date;
            $datas['hour'] = $hour;
            $datas['votes'] = $oeuvre->votes_count;
            $datas['facebook'] = $oeuvre->facebook_share_count;
            $datas['twitter'] = $oeuvre->twitter_share_count;

            if (!$usersModel->add($datas)) {
                return ResponseController::error('Error during saving data for '. $oeuvre->username, 500);
            }
        }

        return ResponseController::success("Datas correctly saved", 201);
    }


    /**
     * /fix
     * Fix les dates de la base de donnees
     *
     */
    public function fixAction(Application $app)
    {
        $usersModel = new UsersModel($app['db']);
        $usernames = $usersModel->listing();
        $dates = $usersModel->getAllDates();

        if (!$dates) {
            return ResponseController::error("The user {$username['username']} doesn't exist or the date passed is invalid", 404);
        }

        foreach ($dates AS $date) {
            $date = $date['date'];
            $oldDate = explode('-', $date);
            $newDate = $oldDate[2] ."-". $oldDate[1] ."-". $oldDate[0];

            if (!$usersModel->updateDate($newDate, $date)) {
                return ResponseController::error('Impossible to set the date '. $date .' to '. $newDate, 500);
            }
        }

        return ResponseController::success('Dates correctly updated');
    }


    private function decodeOeuvres($oeuvres)
    {
        $oeuvres = $oeuvres[0];
        $oeuvres = str_replace('var creations = ', '', $oeuvres);
        $oeuvres = str_replace(';', '', $oeuvres);
        $oeuvres = explode('var carousel_jumpTo', $oeuvres);
        $oeuvres = json_decode($oeuvres[0]);

        return $oeuvres;
    }
}
