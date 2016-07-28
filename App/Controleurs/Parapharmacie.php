<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 12:27
 */

namespace Parapharmacie;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'Menu.php';
use App\Menu;

require_once LIB . 'Image.php';
use App\Image;

require_once LIB . 'Moteur.php';
use App\Moteur;

class Parapharmacie extends Produit
{
    var $session = 'Parapharmacie';
    var $mage = '';
    var $champsObligatoires = '';

    public function __construct()
    {
        parent::__construct();
        $this->link = 'https://www.pharmaplay.fr/p/produits/';
        $this->connexion(PARAPHARMACIE);

        $this->menu = new Menu($this, 'Produits');

        $this->image = new Image();
        $this->image->connexion(SURFIMAGE);
        //$this->image->session = $this->session;
        $this->image->session = $this->session;

        $this->champsObligatoires = file_contents_parapharmacie();

        $this->moteur = new moteur($this, $this->image, $_SESSION['recherche'][$this->session]);
        debug($this->moteur, 'RECHERCHE');
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());

        include_once VUE . 'liste_produits.tpl.php';
    }

    public function ficheProduit(){
        $id = isset($_GET['id'])? intval($_GET['id']) : -1;
        $produit = $this->getProduit($id);
        include VUE . 'fichePharmacie.tpl.php';
    }
    
}