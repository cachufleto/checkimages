<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/06/2016
 * Time: 12:19
 */

namespace Upload;
use App\Bdd;

class images extends Bdd
{
    var $_lib = [];
    var $zaper = 0;

    public function __construct()
    {
        // on utilise la base de données pour les images
        $this->connexion(SURFIMAGE);
        $this->_lib = file_contents_libelles();
    }

    public function getListeImages($a = 0, $b = NUM, $p = false){

        $sql = "SELECT * FROM images WHERE zaper = {$this->zaper} LIMIT $a, $b";

        return $this->query($sql);
    }

    public function getExistImages($p = false){

        $sql = "SELECT * FROM images WHERE zaper = {$this->zaper} ";
        
        return $this->query($sql);
    }

    public function getExistProduit($cip13){

        $sql = "SELECT * FROM produits WHERE cip13 = $cip13 ";
        
        return $this->query($sql);
    }

    public function getNumImages(){
        
        $sql = "SELECT count(*) as num FROM images WHERE zaper = {$this->zaper}";

        $data = $this->query($sql);

        return $data[0]['num'];
    }

    public function updateZaper(){

        if($id = intval($_POST['id'])){
            $sql = "UPDATE `images` SET `zaper` = '1' WHERE `images`.`id` = $id;";
            $this->queryUpdate($sql);
        }
        return true;
    }

    public function updateConserver(){

        if($id = intval($_POST['id'])){
            $sql = "UPDATE `images` SET `zaper` = '2' WHERE `images`.`id` = $id;";
            $this->queryUpdate($sql);
        }
        return true;
    }

    public function updateRetirer(){

        if($id = intval($_POST['id'])){
            $sql = "UPDATE `images` SET `zaper` = '0' WHERE `images`.`id` = $id;";
            $this->queryUpdate($sql);
        }
        return true;
    }

    public function updateCip(){

        if($id = intval($_POST['id'])){
            $sql = "UPDATE `images` SET `cip13` = '". htmlentities($_POST['cip13'])."' WHERE `images`.`id` = $id;";
            $this->queryUpdate($sql);
        }
        return true;
    }
}