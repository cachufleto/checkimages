<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/06/2016
 * Time: 11:58
 */
namespace Upload;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'NewImage.php';
use App\NewImage;

require_once LIB . 'Menu.php';
use App\Menu;

class Upload extends NewImage
{
    var $menu = false;
    var $recherche = false;
    var $session = 'Upload';
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
        // $this->recherche = !empty($this->criterMoteurRecherche())? true : false ;
        $this->listeLocal = ['id'=>'-1','nom'=>"'_'"];
        $this->pharamacie = new Produit();
        $this->pharamacie->connexion(PARAPHARMACIE);
        $this->pharamacie->link = 'https://www.pharmaplay.fr/p/produits/';
        $this->pharamacie->session = $this->session;
        $this->medicament = new Produit();
        $this->medicament->connexion(MEDICAMENTS);
        $this->medicament->link = 'https://www.pharmaplay.fr/m/produits/';
        $this->medicament->session = $this->session;
    }

    public function indexAction(){
        $this->menu->afficherNewImages();
        include_once VUE . 'upload.tpl.php';
    }

    public function localAction(){
        $this->menu->afficherNewImages();
        $this->listerReperoires(REP_TRAITEMETN);
        header('content-type image/jpeg');

        $data = $this->listeLocal;
        var_dump($data);
        $liste = $this->getListeNewImages($data['id'], $data['nom']);
        $f = '';
        include_once VUE . 'listeUploadNouvelles.tpl.php';
    }
    
    public function netoillerAction(){
        $this->netoillerBDD();
        $this->localAction();
    }
}