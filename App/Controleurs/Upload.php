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
    var $champsObligatoires = [];

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->zapper = isset($_SESSION['recherche'][$this->session]['etat'])? "= ".$_SESSION['recherche'][$this->session]['etat'] : "= 0";
        
        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->listeLocal = ['id'=>'-1','nom'=>"'_'"];
        
        $this->parapharmacie = new Produit();
        $this->parapharmacie->BDD = PARAPHARMACIE;
        $this->parapharmacie->connexion(PARAPHARMACIE);
        $this->parapharmacie->link = 'https://www.pharmaplay.fr/p/produits/';
        $this->parapharmacie->session = $this->session;
        
        $this->medicament = new Produit();
        $this->medicament->BDD = MEDICAMENTS;
        $this->medicament->connexion(MEDICAMENTS);
        $this->medicament->link = 'https://www.pharmaplay.fr/m/produits/';
        $this->medicament->session = $this->session;
    }

    public function indexAction()
    {
        $this->menu->afficherNewImages();
        include_once VUE . 'upload.tpl.php';
    }

    public function localAction()
    {
        $this->menu->afficherNewImages();
        $this->listerReperoires(REP_TRAITEMETN);
        header('content-type image/jpeg');

        $data = $this->listeLocal;
        $liste = $this->getListeNewImages($data['id'], $data['nom']);
        $f = '';
        include_once VUE . 'listeUploadNouvelles.tpl.php';
    }
    
    public function netoillerAction()
    {
        $this->netoillerBDD();
        $this->localAction();
    }

    public function medAction()
    {
        // verifications des conditions requises
        $this->champsObligatoires = file_contents_medicaments();
        $this->type = 1;
        $this->checker($this->medicament);
    }

    public function paraAction()
    {
        // verifications des conditions requises
        $this->champsObligatoires = file_contents_parapharmacie();
        $this->type = 2;
        $this->checker($this->parapharmacie);
    }

    public function checker($produits)
    {
        $this->listeChangements( $produits->getProduits($this->outCIP()), $produits);
        $liste = $this->getChangementsOK($this->type);
        include_once VUE . 'produitsModifies.tpl.php';
    }



}