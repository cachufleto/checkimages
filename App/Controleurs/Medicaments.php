<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 12:27
 */

namespace Medicaments;

require LIB . 'Medicaments/Produit.php';
use Medicaments\Produit;

class Medicaments extends Produit
{
    public function __construct()
    {
        $this->page = $_GET['page'];
        $this->_lib = file_contents_libelles();
        $this->connexion(MEDICAMENTS);
    }

    public function indexAction()
    {
        $this->afficheMenu($this->page, $this->count());
        $this->afficheMoteurRecherche();
        $liste = $this->getImages($this->produits());
        
        include_once VUE . 'liste_medicaments.tpl.php';
    }
}