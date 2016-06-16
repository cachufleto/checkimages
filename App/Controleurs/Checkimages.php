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

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->menu = new Menu();
        $this->menu->info = $this;
    }

    public function indexAction(){
        $this->menu->afficher();

        $liste = $this->getImages($this->produits(criterMoteurRechercheImages($this->page)));
        
        include_once VUE . 'listeExistant.tpl.php';
    }
}