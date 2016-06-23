<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/06/2016
 * Time: 13:41
 */

namespace App;
require MOD . 'Images.php';
use Model\Images;

class Image extends Images
{
    var $link = '';
    var $_lib = [];
    var $page = '';
    var $listeRecherche = 'Recherche ';

    public function __construct()
    {
        $this->page = $_GET['page'];
        include CONF . 'libelles.php';
        $this->_lib = $_libelle;
    }

    public function count($recherche)
    {
        $produit = (
            isset($_SESSION[$this->session]['produit']) ? 
                $_SESSION[$this->session]['produit'] : ''
            ) . (
                empty($recherche)? '': 'R'
            );
        
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
        $debut = isset($_SESSION[$this->session]['a']) ? $_SESSION[$this->session]['a'] : 0;
        $limit = isset($_SESSION[$this->session]['b']) ? $_SESSION[$this->session]['b'] : NUM;
        $produit = (
            isset($_SESSION[$this->session]['produit']) ?
                $_SESSION[$this->session]['produit'] : ''
            ) . (
            ($this->recherche)? 'R': ''
            );
        
        switch ($produit) {
            case 'okR':
                return $this->getOkR($debut, $limit);
                break;
            case 'ok':
                return $this->getOk($debut, $limit);
                break;
            case 'koR':
                return $this->getKoR($debut, $limit);
                break;
            case 'ko':
                return $this->getKo($debut, $limit);
                break;
            case 'R':
                return $this->getR($debut, $limit);
                break;
            case '':
                return $this->get($debut, $limit);
                break;
        }
    }

    function afficheMoteurRecherche()
    {
        $libelle = $this->inputLibelle();
        $Etat = $this->listeEtat();
        $Code = $this->inputCip();
        $Nom = $this->inputNom();
        $listeRecherche = $this->listeRecherche;

        include_once VUE . 'moteurRechercheImages.tpl.php';
    }

    public function selectLaboratoires()
    {
        $data = $this->getLaboratoires();

        $balise = '<select name="labo">';
        $balise .= '
            <option value="0">---</option>';

        $choix = isset($_SESSION['recherche'][$this->session]['labo']) ? $_SESSION['recherche'][$this->session]['labo'] : 0;
        foreach ($data as $info) {
            $select = '';
            if($info['id'] == $choix){
                $select = 'selected';
                $this->listeRecherche .= 'Laboratoire : "' . $info['designation'] . '" ';
            }
            $balise .= '
            <option value="' . $info['id'] . '" ' . $select . '>' . $info['designation'] . '</option>';
        }
        $balise .= '
        </select>';

        return $balise;
    }

    public function listeEtat()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['etat']) ? $_SESSION['recherche'][$this->session]['etat'] : '';
        $etat = $this->_lib['etat'][0].'
        <input name="etat" type="radio" value="0" ' .
            (empty($choix) ? 'checked' : '')
            . ' >';
        $etat .= $this->_lib['etat'][1].'
        <input name="etat" type="radio" value="1" ' .
            ((!empty($choix) && $choix == 1) ? 'checked' : '')
            . ' >';
        $etat .= $this->_lib['etat'][2].'
        <input name="etat" type="radio" value="2" ' .
            ((!empty($choix) && $choix == 2) ? 'checked' : '')
            . ' >';
        $this->listeRecherche .= !empty($choix) ? ": " . $this->_lib['etat'][$choix] : '';
        return $etat;
    }

    public function inputCip()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['cip13']) ? $_SESSION['recherche'][$this->session]['cip13'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }
        return '<input type="texte" name="cip13" placeholder="' . $choix . '" >';

    }

    public function inputNom()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['nom']) ? $_SESSION['recherche'][$this->session]['nom'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }

        return '<input type="texte" name="nom" placeholder="' . $choix . '" >';
    }

    public function inputLibelle()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['libelle']) ? $_SESSION['recherche'][$this->session]['libelle'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }

        return '<input type="texte" name="libelle" placeholder="' . $choix . '" >';
    }

    public function listeFamilles()
    {
        $data = $this->getFamilles();

        $balise = '<select name="famille">';
        $balise .= '
            <option value="0">---</option>';
        $choix = isset($_SESSION['recherche'][$this->session]['famille']) ? $_SESSION['recherche'][$this->session]['famille'] : 0;
        foreach ($data as $info) {
            if($info['id'] == 0){
                continue;
            }
            $select = '';
            if($info['id'] == $choix){
                $select = 'selected';
                $this->listeRecherche .= ': famille "' . utf8_encode($info['nom']) . '" ';
            }
            $balise .= '
            <option value="' . $info['id'] . '" ' . $select . '>' . utf8_encode($info['nom']) . '</option>';
        }
        $balise .= '
        </select>';

        return $balise;
    }

    public function getImages($liste)
    {
        $_liste = [];
        foreach($liste as $key =>$info){

            if ($img = $this->getProduit($info['id'])){
                $info['image'] = $this->imgProd($img, $info['cip13']);
                $info['data'] = $img[0];
            } else if (!($info['image'] = $this->testImage($info['cip13']))){
                $info['image'] = $info['cip13'];
            }
            $_liste[] = $info;
        }
        return $_liste;
    }

    public function imgProd($_img, $nom){
        /*$img = $_img[0];
        if ($img['image'] == 1 && $img['vignette'] == 1) {
            return '<img height="150px" src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />'
            . '<img height="250px" src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($img['image'] == 1) {*/
            //return '<img height="150px" src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
            return '<img height="150px" src="' . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        /*} else if ($img['vignette'] == 1) {
            return '<img height="150px" src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />';
        } */
        return false;
    }

    public function testImage($nom){

        $_grand = remote_file_exists('' . $this->link . $nom . '.jpg');
        $_vignette = remote_file_exists('' . $this->link . $nom . '_vig.jpg');

        if ($_grand && $_vignette) {
            $this->setImage($nom, 1, 1);
            return '<img height="150px" src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />'
            . '<img height="250px" src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($_grand) {
            $this->setImage($nom, 1, 0);
            return '<img height="250px" src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($_vignette) {
            $this->setImage($nom, 0, 1);
            return '<img height="150px" src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />';
        }

        return false;
    }

    public function criterMoteurRecherche()
    {
        $chercher = $_SESSION['recherche'][$this->session];
        $recherche = '';
        $option = [];
        // recherche par cip
        if (isset($chercher['cip13']) AND !empty($chercher['cip13'])){
            $option[] = ' p.cip13 LIKE "%' . $chercher['cip13'] . '%"';
        }

        // recherche par libelle du produit
        if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
            $this->rechercheNom = 'AND  i.nom LIKE "' . $chercher['nom'] . '%"';
        }

        // recherche par libelle du produit
        if (isset($chercher['libelle']) AND !empty($chercher['libelle'])) {
            $option[] = ' p.libelle LIKE "' . $chercher['libelle'] . '%"';
        }

        // agrementation du libelle du produit
        $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

        if(is_array($_nom) AND count($_nom) > 1){
            foreach ($_nom as $mot){
                $option[] = ' p.nom LIKE "%' . $mot .'%"';
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }
        $recherche .= (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : false;


        return $recherche;
    }

}