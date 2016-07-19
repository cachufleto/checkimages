<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 12:27
 */

namespace Medicaments;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'Menu.php';
use App\Menu;

require_once LIB . 'Image.php';
use App\Image;


class Medicaments extends Produit
{
    var $session = 'Medicaments';
    var $mage = '';
    var $champsObligatoires =[];

    public function __construct()
    {
        parent::__construct();
        $this->link = 'https://www.pharmaplay.fr/m/produits/';
        $this->champsObligatoires = file_contents_medicaments();
        $this->connexion(MEDICAMENTS);

        $this->menu = new Menu();
        $this->menu->info = $this;

        $this->image = new Image();
        $this->image->connexion(SURFIMAGE);
        //$this->image->session = $this->session;
        $this->image->session = $this->session;
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());

        include_once VUE . 'liste_produits.tpl.php';
    }

    public function ficheProduit(){
        $id = isset($_GET['id'])? $_GET['id'] : -1;
        $produit = $this->getProduit($id);
        include VUE . 'ficheMedicament.tpl.php';
    }

}