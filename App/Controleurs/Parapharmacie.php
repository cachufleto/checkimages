<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 12:27
 */

namespace Parapharmacie;

require LIB . 'Produit.php';
use App\Produit;

require LIB . 'Menu.php';
use App\Menu;

class Parapharmacie extends Produit
{
    var $session = 'Parapharmacie';

    public function __construct()
    {
        parent::__construct();
        $this->link = 'https://www.pharmaplay.fr/p/produits/';
        $this->connexion(PARAPHARMACIE);
        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->menu->file = 'Produits';
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $this->afficheMoteurRecherche();
        $liste = $this->getImages($this->produits());
        
        include_once VUE . 'liste_produits.tpl.php';
    }
}