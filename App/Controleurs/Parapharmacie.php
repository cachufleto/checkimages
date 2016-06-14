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

class Parapharmacie extends Produit
{
    public function __construct()
    {
        parent::__construct();
        $this->link = 'https://www.pharmaplay.fr/p/produits/';
        $this->connexion(PARAPHARMACIE);
    }

    public function indexAction()
    {
        $this->afficheMenu($this->page, $this->count());
        $this->afficheMoteurRecherche();
        $liste = $this->getImages($this->produits());
        
        include_once VUE . 'liste_produits.tpl.php';
    }
}