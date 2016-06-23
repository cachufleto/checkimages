<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 17:05
 */

namespace App;


class Bdd
{
    var $mysqli = false;

    public function __construct()
    {
    }

    public function connexion($bdd)
    {
        $this->mysqli = new \mysqli(HOSTBDD, USERBDD, MDPBDD, $bdd);
        if ($this->mysqli->connect_errno) {
            printf("Erreur de connexion à la base des données: %s\n", $this->mysqli->connect_error);
            exit();
        }

    }

    public function query($sql)
    {
        /* If we have to retrieve large amount of data we use MYSQLI_USE_RESULT */
        if (!($data = $this->mysqli->query($sql)))
        {

            /* Note, that we can't execute any functions which interact with the
               server until result set was closed. All calls will return an
               'out of sync' error */
                printf("Error: %s\n", $sql, $this->mysqli->error);
        }

        /* fetch associative array */
        $liste = [];

        while ($row = $data->fetch_assoc()) {
            $liste[] = $row;
        }
        debug($sql, 'REQUETTE');
        /* free result set */
        $data->free();
        return $liste;
    }

    public function queryUpdate($sql){
        $this->mysqli->query($sql) or die ('ERREUR 801 de mise à jours de la BDD : <br>'.$sql);
        return true;
    }

    public function queryInsert($sql){
        $this->mysqli->query($sql) or die ('ERREUR 802 de mise à jours de la BDD : <br>'.$sql);
        return true;
    }

    public function __destruct()
    {
        if($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
