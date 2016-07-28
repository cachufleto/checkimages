<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 11:47
 */

namespace App;

require MOD . 'Produits.php';
use Model\Produits;

require_once LIB . 'NewImage.php';
use App\NewImage;

class Produit extends Produits
{
    var $link = '';
    var $_lib = [];
    var $page = '';
    var $listeRecherche = 'Recherche ';
    var $control = '';
    var $selectCIP = '';
    var $BDD = '';
    var $selectProduit = '';
    var $debut = 0;
    var $limit = NUM;

    public function __construct()
    {
        $this->page = $_GET['page'];
        $this->_lib = file_contents_libelles();
        //$this->session = isset($this->session)? $this->session : 'Checkimages';
        $this->session = $_SESSION['actif'];

        $this->control = new NewImage();
        $this->control->connexion(SURFIMAGE);
        //$this->control->session = $this->session;
        $this->control->session = $this->session;
        $this->control->listeCIP();
        $this->selectCIP = $this->control->selectImages;

        $this->selectProduit = isset($_SESSION[$this->session]['produit']) ? $_SESSION[$this->session]['produit'] : '';
        $this->debut = isset($_SESSION[$this->session]['a']) ? $_SESSION[$this->session]['a'] : 0;
        $this->limit = isset($_SESSION[$this->session]['b']) ? $_SESSION[$this->session]['b'] : NUM;
    }

    public function countData()
    {
        switch ($this->selectProduit) {
            case 'ok':
                return $this->getCountOk();
                break;
            case 'ko':
                return $this->getCountKo();
                break;
            case '':
                return $this->getCount();
                break;
        }
    }

    public function produits()
    {
        switch ($this->selectProduit) {
            case 'ok':
                return $this->getOk();
                break;
            case 'ko':
                return $this->getKo();
                break;
            case '':
                return $this->get();
                break;
        }
    }
    
    public function getImages($liste)
    {
        $_liste = [];
        foreach($liste as $key =>$info){
            $info['image'] = !isset($info['image'])? [] : $info['image'];
            if ($img = $this->control->getImage($info['cip13'])){
                $info['image'] = $this->imgProd($img, $info['cip13']);
            } else if (!empty($img = $this->imgProd($this->checkImage($info['cip13']), $info['cip13']))){
                $info['image'] = $img;
            } else {
                $info['image'] = [
                    'vignette'=>'',
                    'image'=>''
                    ];
            }

            if (file_exists(PHOTO_EN_COUR . "{$info['cip13']}.jpg")) {
                $info['image']['encours'] = figureHTML(LINK_EN_COUR . "{$info['cip13']}.jpg", $info['cip13'] . $this->_lib['imageEnCours']);
            }

            $_liste[] = $info;
        }
        return $_liste;
    }

    public function imgProd($img, $nom)
    {
        //test de validité du type de produit
        $images = ['image'=>'','vignette'=>''];
        // test sur image 600x600
        if ($img['image'] == 1) {
            $images['image'] = figureHTML($this->link . $nom . '.jpg',  $nom . $this->_lib['imageGrande']);
            if($images['image'] == 'NULL'){
                return false;
            }
        }
        // test sur vignette 162x162
        if ($img['vignette'] == 1) {
            $images['vignette'] = figureHTML($this->link . $nom . '_vig.jpg', $nom . $this->_lib['imageVignette']);
            if($images['vignette'] == 'NULL'){
                return false;
            }
        }
        return $images;
    }

    public function testImage($nom)
    {
        return $this->imgProd($this->checkImage($nom), $nom);
    }

    public function checkImage($nom)
    {
        $img = [];
        $img['image'] = remote_file_exists($this->link . $nom . '.jpg')? 1 : 0;
        $img['vignette'] = remote_file_exists($this->link . $nom . '_vig.jpg')? 1 : 0;
        
        if($getimg = $this->control->getImage($nom)){
            if($getimg['image'] != $img['image'] OR $getimg['vignette'] != $img['vignette'] ){
                $this->control->updateImage($nom, $img['image'], $img['vignette'], $this->control->type);
            }
        }else {
            $this->control->setImage($nom, $img['image'], $img['vignette'], $this->control->type);
        }

        return $img;
    }
}