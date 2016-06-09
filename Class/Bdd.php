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
    var $HOST = '127.0.0.1';
    var $USER = 'root';
    var $MDP = '';
    var $mysqli = false;
    var $_lib = [];

    public function __construct()
    {
        $this->_lib = file_contents_libelles();
    }

    public function connexion($bdd)
    {
        $this->mysqli = new \mysqli($this->HOST, $this->USER, $this->MDP, $bdd);
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
                printf("Error: %s\n", $this->mysqli->error);
        }

        /* fetch associative array */
        $liste = [];

        while ($row = $data->fetch_assoc()) {
            $liste[] = $row;
        }

        /* free result set */
        $data->free();
        return $liste;
    }

    public function queryUpdate($sql){
        $this->mysqli->query($sql) or die ('ERREUR de mise à jours de la BDD');
        return true;
    }

    public function queryInsert($sql){
        $this->mysqli->query($sql) or die ('ERREUR de mise à jours de la BDD');
        return true;
    }

    public function __destruct()
    {
        if($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
