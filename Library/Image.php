<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 15/06/2016
 * Time: 13:41
 */

namespace App;

require MOD . 'Images.php';
use Model\Images;

require_once LIB . 'NewImage.php';
use App\NewImage;

class Image extends Images
{
    var $link = '';
    var $_lib = [];
    var $session = '';
    var $page = '';
    var $listeRecherche = 'Recherche ';
    var $selectProduit = '';
    var $debut = 0;
    var $limit = 2;

    public function __construct()
    {
        $this->page = $_GET['page'];
        $this->_lib = file_contents_libelles();
        
        $this->control = new NewImage();
        $this->control->connexion(SURFIMAGE);
        // la valeur de session estinjecté à la suite
        $this->control->session = $this->session;

        $this->selectProduit = isset($_SESSION[$this->session]['produit']) ? $_SESSION[$this->session]['produit'] : '';
        $this->debut = isset($_SESSION[$this->session]['a']) ? $_SESSION[$this->session]['a'] : 0;
        $this->limit = isset($_SESSION[$this->session]['b']) ? $_SESSION[$this->session]['b'] : NUM;
    }

    public function countData()
    {
        $produit = $this->selectProduit . (
            ($this->recherche)? 'R': ''
            );

        debug($produit, __FUNCTION__);
        switch ($produit) {
            case 'okR':
                return $this->getCountOkR();
                break;
            case 'ok':
                return $this->getCountOk();
                break;
            case 'koR':
                return $this->getCountKoR();
                break;
            case 'ko':
                return $this->getCountKo();
                break;
            case 'R':
                return $this->getCountR();
                break;
            case '':
                return $this->getCount();
                break;
        }
    }

    public function produits()
    {
        $produit = $this->selectProduit . (
            ($this->recherche)? 'R': ''
            );
        
        switch ($produit) {
            case 'okR':
                return $this->getOkR();
                break;
            case 'ok':
                return $this->getOk();
                break;
            case 'koR':
                return $this->getKoR();
                break;
            case 'ko':
                return $this->getKo();
                break;
            case 'R':
                return $this->getR();
                break;
            case '':
                return $this->get();
                break;
        }
    }
    
    public function inputLibelle()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['libelle']) ? $_SESSION['recherche'][$this->session]['libelle'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }

        return '<input type="texte" name="libelle" placeholder="' . $choix . '" >';
    }

    public function getImages($liste)
    {
        $_liste = [];
        foreach($liste as $key =>$info){
            $info['image'] = [];
            $info['data'] = '';
            $info['data'] = $this->getProduit($info['id']);
            $info['image']['image'] = $this->testImage($info['nom'], $info['site']);

            $info['image']['encours'] = '';
            if (!empty($info['cip13']) AND file_exists(PHOTO_EN_COUR . "{$info['cip13']}.jpg")) {
                $info['image']['encours'] = figureHTML(LINK_EN_COUR . "{$info['cip13']}.jpg", $this->_lib['imageEnCours']);
                // existante sur le site
            }

            $info['image']['vignette'] = '';
            if (!empty($info['cip13']) AND file_exists(PHOTO_EN_COUR . "{$info['cip13']}_vig.jpg")) {
                $info['image']['vignette'] = figureHTML(LINK_EN_COUR . "{$info['cip13']}_vig.jpg", $this->_lib['imageVignette']);
            }

            if(!empty($info['cip13'])){
                $info['image']['production'] = $this->imgTestProd($info['cip13']);
            }

            // Retour du POST dans le formulaire
            if(isset($_POST['id']) && $_POST['id'] == $info['id']){
                $info['data']['cip13'] = $_POST['cip13'];
                $info['data']['denomination'] = utf8_decode($_POST['denomination']);
                $info['data']['presentation'] = utf8_decode($_POST['presentation']);
                $info['data']['type'] = $_POST['type'];
            }

            $_liste[] = $info;
        }
        return $_liste;
    }

    /*public function imgProd($img, $nom)
    {
        if ($img['image'] == 1) {
            $img['image'] = figureHTML($this->link . $nom . '.jpg',  $nom . ' Grande');
            if($img['image'] == 'NULL'){
                return false;
            }
        }

        if ($img['vignette'] == 1) {
            $img['vignette'] = figureHTML($this->link . $nom . '_vig.jpg', $nom . ' Vignette');
            if($img['vignette'] == 'NULL'){
                return false;
            }
        }

        return $img;
    }*/

    public function imgTestProd($cip13){
        $info = [];
        if ($img = $this->control->getImage($cip13)){
            if($img['type'] == 1){
                $img = $this->medicament->imgProd($img, $cip13);
                $info['medicament'] = ($img)? $img : $this->_lib['erreurTypeMed'];
            } else if($img['type'] == 2){
                $img = $this->parapharmacie->imgProd($img, $cip13);
                $info['pharmacie'] = ($img)? $img : $this->_lib['erreurTypePara'];
            }
        }

        return $info;
    }

    public function imgLocal($img, $nom)
    {
        if ($img['image'] == 1) {
            return figureHTML($nom, 'Originale');
        }
        return false;
    }

    public function testImage($nom, $link)
    {
        $image = str_replace('//'. $nom, '/'. $nom, $link . '/'. $nom);
        $img['image'] = (image_attributs($image))? 1 : 0;
        return $this->imgLocal($img, $image);
    }
/*
    public function criterMoteurRechercheImage()
    {
        $chercher = $_SESSION['recherche'][$this->session];
        $recherche = '';
        $option = [];
        $this->zapper = isset($_POST['all'])? ">= 0 " : $this->zapper;
        
        // recherche par cip
        if (isset($chercher['cip13']) AND !empty($chercher['cip13'])){
            $this->rechercheCip = " AND i.cip13 LIKE '%{$chercher['cip13']}%' ";
        }

        // recherche par le nom de l'image
        if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
            $this->rechercheNom = " AND  i.nom LIKE '%{$chercher['nom']}%' ";
        }

        // recherche par libelle du produit
        if (isset($chercher['denomination']) AND !empty($chercher['denomination'])) {
            $option[] = " p.denomination LIKE '%" . utf8_decode($chercher['denomination']) . "%' ";
        }

        // agrementation du libelle du produit
        $_denomination = (isset($chercher['denomination']) AND !empty($chercher['denomination']))? explode(' ', $chercher['denomination']) : '';

        if(is_array($_denomination) AND count($_denomination) > 1){
            foreach ($_denomination as $mot){
                $option[] = " p.denomination LIKE '%" . utf8_decode($mot) . "%'";
            }
        }

        // recherche par libelle du produit
        if (isset($chercher['presentation']) AND !empty($chercher['presentation'])) {
            $option[] = " p.presentation LIKE '%" . utf8_decode($chercher['presentation']) . "%' ";
        }

        // agrementation du libelle du produit
        $_nom = (isset($chercher['presentation']) AND !empty($chercher['presentation']))? explode(' ', $chercher['presentation']) : '';

        if(is_array($_nom) AND count($_nom) > 1){
            foreach ($_nom as $mot){
                $option[] = " p.presentation LIKE '%" . utf8_decode($mot) . "%'";
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }
        $recherche .= (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : false;

        return $recherche;
    }
*/
    public function renommerImage($produit, $new)
    {
        // on verifie chaque possibilité
        // l'image est dans le repertoire de en cours
        // on verifie si l'image de destination existe déjà
        $urlNew = str_replace( '/',  DIRECTORY_SEPARATOR, PHOTO_EN_COUR . $new . '.jpg');
        $urlNew = str_replace( DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $new,  DIRECTORY_SEPARATOR . $new, $urlNew);
        debug($urlNew, 'URLs IMAGES');
        if (file_exists($urlNew)) {
            return false;
        }

        // on verifie si l'image d'irigine existe bien
        if(preg_match('/^photo/', $produit['site']) ) {

            $url = str_replace( '/',  DIRECTORY_SEPARATOR, PHOTO_EN_COUR . $produit['cip13'] . '.jpg');
            $url = str_replace( DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $produit['cip13'],  DIRECTORY_SEPARATOR . $produit['cip13'], $url);
            debug($url, 'URLs IMAGES');
            if (!file_exists($url)) {
                return false;
            }
            // on renomme l'image
            rename($url, $urlNew);
            return true;
        }
        return false;
    }

    public function updateImageJpg($produit, $new)
    {
        // on renomme l'image avec le CIP
        $origine = $produit['cip13'];
        if(preg_match('/^photo/', $produit['site']) AND $origine != $new ){
            $this->renommerImage($produit, $new);
        } else {
            $produit['cip13'] = $new;
            $this->enregistrerImageJpg($produit);
        }
        return true;
    }

    public function enregistrerImageJpg($produit)
    {
        enregistrerImageJpg($produit);
        $this->updateImageURL($produit['id'], $produit['cip13']);
    }

    public function imageAction()
    {
        if(isset($_POST['id']) and $id = intval($_POST['id'])){
            if($_POST['option'] == $this->_lib['option']['zapper']){
                $this->updateZapper($id);
            } else if($_POST['option'] == $this->_lib['option']['conserver']){
                // verifier si un cip est attribué
                $this->updateConserver($id);
                if(testCIP13($_POST['cip13'])){
                    $this->updateConserver($id);
                    //$this->setData();
                }
            } else if($_POST['option'] == $this->_lib['option']['retirer']){
                $this->updateRetirer($id);
            } else if($_POST['option'] == $this->_lib['option']['supprimer']){
                if($produit = $this->getProduit($id)){
                    $this->deleteUdate($id);
                    $this->deleteUdateProduit($id);

                    $link = SITE . $produit['site'] . DIRECTORY_SEPARATOR . $produit['nom'];
                    if(file_exists($link)){
                        unlink($link);
                    }

                    $link = PHOTO_EN_COUR . $produit['cip13'].'.jpg';
                    if(file_exists($link)){
                        unlink($link);
                    }
                }
            } else if($_POST['option'] == $this->_lib['option']['valider']){
                $this->setData();
            }
        }
    }

    public function setData()
    {
        $id = intval($_POST['id']);
        $_POST['cip13'] = $cip13 = testCIP13($_POST['cip13']);
        $denomination = utf8_decode($_POST['denomination']);
        $presentation = utf8_decode($_POST['presentation']);
        $type = intval($_POST['type']);

        $image = $this->getProduit($id);

        if(empty($cip13) AND !empty($image['cip13'])){
            //$this->msg[$id] = $this->_lib['renseignerCIP'];
            $cip13 = $image['cip13'];
            //return false;
        }


        if(!empty($cip13) and $autreCip = $this->getProduitCip($cip13, $id)){
            $this->msg[$id] = $this->_lib['renseignerCIP_existe'].$autreCip[0]['denomination'];
            $this->alert[$id] = $this->_lib['ATTENTION'];
            return false;
        }

        if(!empty($image['id_image'])){
            $this->msg[$id] = $this->_lib['miseAJoursProduit'] . $cip13;
            $this->updateProduit($id, $cip13, $denomination, $presentation, $type);
            if(!empty($cip13) AND $this->updateImageJpg($image, $cip13)){
                $this->updateImageType($cip13, $type);
            }
        } else {
            $this->msg[$id] = $this->_lib['injectionProduit'] . $cip13;
            $this->setProduit($id, $cip13, $type, $denomination, $presentation);
            $produit = $this->getProduit($id);
            $this->enregistrerImageJpg($produit);
        }

        $this->updateImage($id, $cip13);

        return true;
    }
}

