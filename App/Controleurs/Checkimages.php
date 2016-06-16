<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/06/2016
 * Time: 13:44
 */

namespace Checkimages;

require LIB . 'Image.php';
use App\Image;

require LIB . 'Menu.php';
use App\Menu;

class Checkimages extends Image
{
    var $menu = false;
    var $recherche = false;

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->zaper = isset($_SESSION['recherche'][$this->page]['etat'])? $_SESSION['recherche'][$this->page]['etat'] : 0;
        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->recherche = !empty($this->criterMoteurRecherche())? true : false ;
    }

    public function indexAction(){
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());
        $display = isset($_SESSION[$this->page]['display'])? $_SESSION[$this->page]['display'] : 0;
        $l = isset($_SESSION[$this->page]['l'])? $_SESSION[$this->page]['l'] : NUM;
        $f = '&display=' . $display . '&nombre=' . $l;
        include_once VUE . 'listeUpload.tpl.php';
        //include_once VUE . 'listeExistant.tpl.php';
    }

    public function indexAction88(){

        extract($_SESSION['upload']);
        $numProduits = $this->count($this->criterMoteurRecherche());
        $f = afficheMenu('upload', $numProduits);

        $liste = $this->getListeImages($a, $b, $p);

        include(VUE . 'listeUpload.tpl.php');

    }

    public function zaperAction(){

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


}