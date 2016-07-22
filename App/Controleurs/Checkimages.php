<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 15/06/2016
 * Time: 13:44
 */

namespace Checkimages;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'Image.php';
use App\Image;

require_once LIB . 'Menu.php';
use App\Menu;

class Checkimages extends Image
{
    var $menu = false;
    var $recherche = false;
    var $session = 'Checkimages';
    var $msg = [];
    var $alert = [];
    var $listeLocal = [];
    var $produit = '';

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->zapper = isset($_SESSION['recherche'][$this->session]['etat'])? "= ".$_SESSION['recherche'][$this->session]['etat'] : "= 0";

        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->recherche = !empty($this->moteurRecherche)? true : false ;
        $this->listeLocal = ['id'=>'-1','nom'=>"'_'"];

        $this->parapharmacie = new Produit();
        $this->parapharmacie->connexion(PARAPHARMACIE);
        $this->parapharmacie->link = 'https://www.pharmaplay.fr/p/produits/';

        $this->medicament = new Produit();
        $this->medicament->connexion(MEDICAMENTS);
        $this->medicament->link = 'https://www.pharmaplay.fr/m/produits/';
    }

    public function indexAction()
    {
        $this->imageAction();
        $this->menu->afficherUpload();
        $liste = $this->getImages($this->produits());
        $display = isset($_SESSION[$this->session]['display'])? $_SESSION[$this->session]['display'] : 0;
        $b = isset($_SESSION[$this->session]['b'])? $_SESSION[$this->session]['b'] : NUM;
        $f = '&display=' . $display . '&nombre=' . $b;
        include_once VUE . 'listeUpload.tpl.php';
    }
    
    /*public function ficheImage()
    {
        if(isset($_GET['cip13']) and intval($_GET['cip13'])){

            $this->imageAction();
            $cip13 = isset($_POST['cip13'])? testCIP13($_POST['cip13']) : $_GET['cip13'];
            $liste = $this->getImages($this->getProduitCip($cip13));
           include_once VUE . 'listeUpload.tpl.php';
        }
    }*/
}