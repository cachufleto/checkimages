<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/06/2016
 * Time: 11:58
 */
namespace Upload;
require APP . 'Modeles/Images.php';

use Upload\Images;


class Upload extends Images
{

    public function listeAction(){

        extract($_SESSION['upload']);
        $this->zaper = $zaper;
        $numProduits = $this->getNumImages();
        $f = afficheMenu('upload', $numProduits);

        $liste = $this->getListeImages($a, $b, $p);
        include(VUE . 'listeUpload.tpl.php');

    }

    public function selectAction(){

        if(isset($_POST['id'])){
            if($_POST['option'] == 'zaper'){
                $this->updateZaper();
            } else if($_POST['option'] == 'conserver'){
                $this->updateConserver();
            } else if($_POST['option'] == 'retirer'){
                $this->updateRetirer();
            }
        }
        if(isset($_GET['mode']) && $_GET['mode'] == 'exist'){
            $this->existantAction();
        }
        else {
            $this->listeAction();
        }
    }

    public function photoAction(){

        if(isset($_POST['id'])){
            if($_POST['option'] == 'zaper'){
                $this->updateZaper();
            } else if($_POST['option'] == 'conserver'){
                $this->updateConserver();
            } else if($_POST['option'] == 'retirer'){
                $this->updateRetirer();
            } else if($_POST['option'] == 'CIP'){
                $this->updateCip();
            }
        }

        $this->existantAction();
    }

    public function existantAction(){

        extract($_SESSION['existant']);
        $this->zaper = $zaper;
        $data = $this->getExistImages($p);
        $data = $this->extractImages($data, $a, $b);
        $liste = $data['liste'];

        $numProduits = $data['num'];

        $f = afficheMenu('existant', $numProduits);

        include(VUE . 'listeexistant.tpl.php');
    }

    public function extractImages($liste, $a=0, $b=5){
        $result = [];
        $i = 1;
        foreach ($liste as $key=>$info){
            if( file_exists( PHOTO . $info['nom'] . '.jpg') OR file_exists( PHOTO . $info['nom'] . '.png')){
                if($i >$a && $i <= ($a + $b)) {
                    $result[] = $info;
                }
                $i++;
            }
        }
        return ['num' => $i, 'liste' => $result];
    }
}