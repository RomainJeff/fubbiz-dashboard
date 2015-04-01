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
        $sqlQuery = "SELECT oeuvre_id, username FROM datas GROUP BY username";

        return $this->db->fetchAll($sqlQuery);
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
     * Recupere le nombre de datas a l'heure passe
     * @param string $date
     * @param int $hour
     * @return int
     *
     */
    public function countDataByDateAndHour($date, $hour)
    {
        $sqlQuery = "SELECT COUNT(*) AS count FROM datas WHERE date = ? AND hour = ? LIMIT 1";
        $result = $this->db->fetchAll($sqlQuery, [$date, $hour]);

        return $result[0]['count'];
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
        $sqlQuery = "SELECT oeuvre_id, date, hour FROM datas WHERE username = ? ORDER BY date, hour";
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
        $sqlQuery = "SELECT oeuvre_id, date, hour FROM datas WHERE username = ? AND date = ? ORDER BY hour ASC";
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


    /**
     * Ajoute une donnee
     * @param array $datas
     * @return bool
     *
     */
    public function add($datas)
    {
        $sqlQuery = "INSERT INTO datas SET
            oeuvre_id = ?,
            username = ?,
            date = ?,
            hour = ?,
            votes = ?,
            facebook = ?,
            twitter = ?
        ";

        return $this->db->executeQuery(
            $sqlQuery,
            [
                $datas['oeuvre'],
                $datas['username'],
                $datas['date'],
                $datas['hour'],
                $datas['votes'],
                $datas['facebook'],
                $datas['twitter']
            ]
        );
    }


    /**
     * Recupere les dates
     * @return array
     *
     */
    public function getAllDates()
    {
        return $this->db->fetchAll("SELECT date FROM datas GROUP BY date");
    }


    /**
     * Met a jour la date
     * @param string $newDate
     * @param string $oldDate
     * @return bool
     *
     */
    public function updateDate($newDate, $date)
    {
        $sqlQuery = "UPDATE datas SET date = ? WHERE date = ?";

        return $this->db->executeQuery(
            $sqlQuery,
            [$newDate, $date]
        );
    }
}
