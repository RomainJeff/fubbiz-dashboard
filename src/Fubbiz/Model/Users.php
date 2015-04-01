<?php
namespace Fubbiz\Model;


class Users
{
    /**
     * Constructeur
     * @param object $db
     *
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Recupere et liste les utilisateurs
     * @return array
     *
     */
    public function listing()
    {
        $sqlQuery = "SELECT oeuvre_id, username FROM datas WHERE date = ? AND hour = ?";

        return $this->db->fetchAll($sqlQuery, [date('d-m-Y'), date('H')]);
    }


    /**
     * Recupere l'id de l'utilisateur
     * @param string $username
     * @return array
     *
     */
    public function getOeuvreByUsername($username)
    {
        $sqlQuery = "SELECT oeuvre_id FROM datas WHERE username = ? AND date = ? AND hour = ?";

        return $this->db->fetchAll($sqlQuery, [$username, date('d-m-Y'), date('H')]);
    }


    /**
     * Recupere les stats de l'utilisateur
     * @param string $username
     * @return array
     *
     */
    public function getAllStatsByUsername($username)
    {
        $toReturn = [];
        $sqlQuery = "SELECT oeuvre_id, date, hour FROM datas WHERE username = ?";
        $sqlExecuted = $this->db->fetchAll($sqlQuery, [$username]);

        if (count($sqlExecuted) <= 0) {
            return false;
        }

        $toReturn['oeuvre_id'] = $sqlExecuted[0]['oeuvre_id'];

        foreach ($sqlExecuted as $date) {
            $sqlQueryDate = "SELECT facebook, twitter, votes  FROM datas WHERE username = ? AND date = ? AND hour = ?";
            $sqlExecutedDate = $this->db->fetchAll($sqlQueryDate, [$username, $date['date'], $date['hour']]);

            foreach ($sqlExecutedDate as $data) {
                $hour = $date['hour'];
                $toReturn['stats'][$date['date']][$hour] = $data;
            }
        }

        return $toReturn;
    }


    /**
     * Recupere lest stats de l'utilisateur a une date donnee
     * @param string $username
     * @param string $date
     * @return array
     *
     */
    public function getDateStatsByUsername($username, $date)
    {
        $toReturn = [];
        $sqlQuery = "SELECT oeuvre_id, date, hour FROM datas WHERE username = ? AND date = ?";
        $sqlExecuted = $this->db->fetchAll($sqlQuery, [$username, $date]);

        if (count($sqlExecuted) <= 0) {
            return false;
        }

        $toReturn['oeuvre_id'] = $sqlExecuted[0]['oeuvre_id'];

        foreach ($sqlExecuted as $date) {
            $sqlQueryDate = "SELECT facebook, twitter, votes  FROM datas WHERE username = ? AND date = ? AND hour = ?";
            $sqlExecutedDate = $this->db->fetchAll($sqlQueryDate, [$username, $date['date'], $date['hour']]);

            foreach ($sqlExecutedDate as $data) {
                $hour = $date['hour'];
                $toReturn['stats'][$date['date']][$hour] = $data;
            }
        }

        return $toReturn;
    }
}
