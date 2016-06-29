<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 12:27
 */

namespace Medicaments;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'Menu.php';
use App\Menu;


class Medicaments extends Produit
{
    var $session = 'Medicaments';

    public function __construct()
    {
        parent::__construct();
        $this->link = 'https://www.pharmaplay.fr/m/produits/';
        $this->connexion(MEDICAMENTS);
        $this->menu = new Menu();
        $this->menu->info = $this;
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());

        include_once VUE . 'liste_produits.tpl.php';
    }
}