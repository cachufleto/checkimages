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
    var $recherche = false;
    var $session = 'Checkimages';
    var $msg = '';

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->zapper = isset($_SESSION['recherche'][$this->session]['etat'])? "= ".$_SESSION['recherche'][$this->session]['etat'] : "= 0";
        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->recherche = !empty($this->criterMoteurRecherche())? true : false ;
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());
        $display = isset($_SESSION[$this->session]['display'])? $_SESSION[$this->session]['display'] : 0;
        $l = isset($_SESSION[$this->session]['l'])? $_SESSION[$this->session]['l'] : NUM;
        $f = '&display=' . $display . '&nombre=' . $l;
        //var_dump($liste);
        include_once VUE . 'listeUpload.tpl.php';
    }

    public function imageAction()
    {
        if(isset($_POST['id']) and $id = intval($_POST['id'])){
            if($_POST['option'] == 'zapper'){
                $this->updateZapper($id);
            } else if($_POST['option'] == 'conserver'){
                $this->updateConserver($id);
            } else if($_POST['option'] == 'retirer'){
                $this->updateRetirer($id);
            } else if($_POST['option'] == 'valider'){
                $this->setData($id);
            }
        }
        $this->indexAction();
    }

    public function setData($id)
    {
        $id = intval($_POST['id']);
        $cip13 = utf8_decode($_POST['cip13']);
        $denomination = utf8_decode($_POST['denomination']);
        $presentation = utf8_decode($_POST['presentation']);
        $type = intval($_POST['type']);
        
        if(empty($cip13) OR empty($denomination) OR empty($presentation)){
            $this->msg = 'Le Formulaire est incomplet!';
            return false;
        }

        $produit = $this->getProduit($id);

        if($cip = $this->getProduitCip($cip13, $id)){
            $this->msg = "ATTENTION !!!! Ce produit existe déjà sous le nom de : {$cip[0]['denomination']}";
            return false;
        }

        if($produit[0]['id_image']){
            $this->msg = "Mise à Jour du produit: $cip13";
            $this->updateImageJpg($produit[0], $cip13);
            $this->updateProduit($id, $cip13, $denomination, $presentation, $type);
        } else {
            $this->msg = "Isertion Nouveau Produit: $cip13";
            $this->setProduit($id, $cip13, $denomination, $presentation, $type);
            $this->enregistrerImageJpg($produit[0]);
        }

        $this->updateImage($id, $cip13);
            
        return true;
    }
}