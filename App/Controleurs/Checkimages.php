<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/06/2016
 * Time: 13:44
 */

namespace Checkimages;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'Image.php';
use App\Image;

require_once LIB . 'Menu.php';
use App\Menu;

class Checkimages extends Image
{
    var $menu = false;
    var $recherche = false;
    var $session = 'Checkimages';
    var $msg = '';
    var $listeLocal = [];
    var $produit = '';

    public function __construct()
    {
        parent::__construct();
        $this->connexion(SURFIMAGE);
        $this->zapper = isset($_SESSION['recherche'][$this->session]['etat'])? "= ".$_SESSION['recherche'][$this->session]['etat'] : "= 0";
        $this->menu = new Menu();
        $this->menu->info = $this;
        $this->recherche = !empty($this->criterMoteurRecherche())? true : false ;
        $this->listeLocal = ['id'=>'-1','nom'=>"'_'"];
        $this->pharmacie = new Produit();
        $this->pharmacie->connexion(PARAPHARMACIE);
        $this->pharmacie->link = 'https://www.pharmaplay.fr/p/produits/';
        $this->medicament = new Produit();
        $this->medicament->connexion(MEDICAMENTS);
        $this->medicament->link = 'https://www.pharmaplay.fr/m/produits/';
    }

    public function indexAction()
    {
        $this->menu->afficherUpload();
        $liste = $this->getImages($this->produits());
        debug($liste, 'LISTE DES PRODUITS');
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
                if($produit = $this->getProduit($id)){
                    $this->deleteUdate($id);
                    if(!empty($produit['id_produit'])){
                        $this->deleteUdateProduit($produit['id_produit']);
                    }
                    $link = !empty($produit['cip13'])? $produit['cip13'].'.jpg' : $produit['nom'];
                    $link = SITE . $produit['site'] . '/' . $link;
                    if(file_exists($link)){
                        unlink($link);
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
        $cip13 = trim(utf8_decode($_POST['cip13']));
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

        if($produit['id_image']){
            $this->msg = "Mise à Jour du produit: $cip13";
            if($this->updateImageJpg($produit, $cip13)){
                $this->updateProduit($id, $cip13, $denomination, $presentation, $type);
            }
        } else {
            $this->msg = "Isertion Nouveau Produit: $cip13";
            $this->setProduit($id, $cip13, $denomination, $presentation, $type);
            $produit['cip13'] = $cip13;
            $this->enregistrerImageJpg($produit);
        }

        $this->updateImage($id, $cip13);
            
        return true;
    }
    
    public function uploadImagesLocal(){
        $this->menu->afficher();
        $this->listerReperoires(REP_TRAITEMETN);
        header('content-type image/jpeg');
        
        $data = $this->listeLocal;
        $liste = $this->getListeNewImages($data['id'], $data['nom']);
        $f = '';
        include_once VUE . 'listeUploadNouvelles.tpl.php';
    }
}