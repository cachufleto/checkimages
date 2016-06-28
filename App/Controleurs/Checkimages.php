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
    var $listeLocal = [];

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->zapper = isset($_SESSION['recherche'][$this->session]['etat'])? "= ".$_SESSION['recherche'][$this->session]['etat'] : "= 0";
        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->recherche = !empty($this->criterMoteurRecherche())? true : false ;
        $this->listeLocal = ['id'=>'-1','nom'=>"'_'"];
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());
        $display = isset($_SESSION[$this->session]['display'])? $_SESSION[$this->session]['display'] : 0;
        $b = isset($_SESSION[$this->session]['b'])? $_SESSION[$this->session]['b'] : NUM;
        $f = '&display=' . $display . '&nombre=' . $b;
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
            } else if($_POST['option'] == 'supprimer'){
                if($image = $this->getImage($id)){
                    $image = SITE . $image[0]['site'] . '/' .$image[0]['nom'];
                    $this->deleteUdate($id);
                    if(file_exists($image)){
                        unlink($image);
                    } else {
                        echo $image;
                    }
                }
            } else if($_POST['option'] == 'valider'){
                $this->setData();
            }
        }
        $this->indexAction();
    }

    public function setData()
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
    
    public function uploadImagesLocal(){
        // importer importer en BDD les images existantes en local
        //$liste = 'LISTE:<br>';
        $this->listerReperoires(REP_TRAITEMETN);
        header('content-type image/jpeg');
        
        $data = $this->listeLocal;
        $liste = $this->getListeNewImages($data['id'], $data['nom']);
        $f = '';
        var_dump($data);
        var_dump($liste);
        include_once VUE . 'listeUpload.tpl.php';
    }
}