<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 11:47
 */

namespace App;
require MOD . 'Produits.php';
use Model\Produits;

class Produit extends Produits
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

    public function count()
    {
        $produit = isset($_SESSION[$this->session]['produit']) ? $_SESSION[$this->session]['produit'] : '';
        
        switch ($produit) {
            case 'ok':
                return $this->getCountOk();
                break;
            case 'ko':
                return $this->getCountKo();
                break;
            case '':
                return $this->getCount();
                break;
        }
    }

    public function produits()
    {
        $produit = isset($_SESSION[$this->session]['produit']) ? $_SESSION[$this->session]['produit'] : '';
        $debut = isset($_SESSION[$this->session]['a']) ? $_SESSION[$this->session]['a'] : 0;
        $limit = isset($_SESSION[$this->session]['b']) ? $_SESSION[$this->session]['b'] : NUM;

        switch ($produit) {
            case 'ok':
                return $this->getOk($debut, $limit);
                break;
            case 'ko':
                return $this->getKo($debut, $limit);
                break;
            case '':
                return $this->get($debut, $limit);
                break;
        }
    }

    function afficheMoteurRecherche()
    {
        $Laboratoire = $this->selectLaboratoires();
        $Etat = $this->listeEtat();
        $Code = $this->inputCip();
        $Nom = $this->inputNom();
        $Fam = $this->listeFamilles();
        $listeRecherche = $this->listeRecherche;

        include_once VUE . 'moteurRecherche.tpl.php';
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

        $etat = '
        Inedit<input name="etat[i]" type="checkbox" value="1" ' .
            (isset($choix['i']) ? 'checked' : '')
            . ' >';
        $this->listeRecherche .= isset($choix['i']) ? ": Inedit " : '';

        $etat .= '
        On Line<input name="etat[o]" type="checkbox" value="1" ' .
            (isset($choix['o']) ? 'checked' : '')
            . ' >';
        $this->listeRecherche .= isset($choix['o']) ? ": On line " : '';

        $etat .= '
        Off line<input name="etat[n]" type="checkbox" value="1" ' .
            (isset($choix['n']) ? 'checked' : '')
            . ' >';
        $this->listeRecherche .= isset($choix['n']) ? ":  Off line " : '';

        $etat .= '
        Archivé<input name="etat[a]" type="checkbox" value="1" ' .
            (isset($choix['a']) ? 'checked' : '')
            . ' >';
        $this->listeRecherche .= isset($choix['a']) ? ": Archivés " : '';

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

            if ($img = $this->getImage($info['cip13'])){
                $info['image'] = $this->imgProd($img, $info['cip13']);
            } else if (!($info['image'] = $this->testImage($info['cip13']))){
                    $info['image'] = $info['cip13'];
            }

            if (file_exists(PHOTO . "en_cours/{$info['cip13']}.jpg")) {
                    $info['image']['encours'] = "<img src='photos/en_cours/{$info['cip13']}.jpg' alt='{$info['cip13']} EN COURS'  border='0' />";
            }

            $_liste[] = $info;
        }
        return $_liste;
    }

    public function imgProd($_img, $nom)
    {
        $img = $_img[0];
        if ($img['image'] == 1 && $img['vignette'] == 1) {
            return ['vignette'=>'<img src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />',
                'image'=>'<img src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />'];
        } else if ($img['image'] == 1) {
            return ['vignette'=>'', 
                'image'=>'<img src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />'];
        } else if ($img['vignette'] == 1) {
            return ['vignette'=>'<img src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />',
                'image'=> ''];
        }
        return false;
    }

    public function testImage($nom)
    {

        $_grand = remote_file_exists('' . $this->link . $nom . '.jpg');
        $_vignette = remote_file_exists('' . $this->link . $nom . '_vig.jpg');

        if ($_grand && $_vignette) {
            $this->setImage($nom, 1, 1);
            return ['vignette'=>'<img src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />',
                'image'=>'<img src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />'];
        } else if ($_grand) {
            $this->setImage($nom, 1, 0);
            return ['vignette'=>'',
                'image'=>'<img src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />'];
        } else if ($_vignette) {
            $this->setImage($nom, 0, 1);
            return ['vignette'=>'<img src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />',
                'image'=>''];
        }
        return false;
    }

    public function criterMoteurRecherche()
    {
        $chercher = $_SESSION['recherche'][$this->session];
        $recherche = '';
        $option = [];
        if( (
                isset($chercher['cip13']) AND !empty($chercher['cip13'])
            ) OR (
                isset($chercher['nom']) AND !empty($chercher['nom'])
            ) )
        {
            // recherche par cip
            if (isset($chercher['cip13']) AND !empty($chercher['cip13'])){
                $option[] = " p.cip13 LIKE '%{$chercher['cip13']}%'";
            }

            // recherche par libelle du produit
            if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
                $option[] = " p.libelle_ospharm LIKE '{$chercher['nom']}%'";
            }

            // agrementation du libelle du produit
            $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

            if(is_array($_nom) AND count($_nom) > 1){
                foreach ($_nom as $mot){
                    $option[] = " p.libelle_ospharm LIKE '%$mot%'";
                }
            }

            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' OR ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

        } else {

            if (isset($chercher['labo']) && $chercher['labo'] > 0){
                $option[] = " p.id_laboratoire = {$chercher['labo']} ";
            }

            if(isset($chercher['etat'])){
                $etat = '';
                $etat .= isset($chercher['etat']['i'])?
                    ' p.produit_actif = "i"' : '';
                $etat .= isset($chercher['etat']['o'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "o"' : '';
                $etat .= isset($chercher['etat']['n'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "n"' : '';
                $etat .= isset($chercher['etat']['a'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "a"' : '';
                $option[] = (count($chercher['etat']) > 1 )? "( $etat )" : $etat;
            }
            // recherche partielle
            if (isset($chercher['famille']) && !empty($chercher['famille'])){
                $option[] = ' p.id_famille = ' . $chercher['famille'];
            }
            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' AND ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . $_option : '';
        }
        return $recherche;
    }

    public function criterMoteurRechercheLaboratoires()
    {
        $chercher = $_SESSION['recherche'][$this->session];
        $recherche = '';
        $option = [];
        if( isset($chercher['nom']) AND !empty($chercher['nom']))
        {
            // recherche par libelle du produit
            if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
                $option[] = ' p.libelle_ospharm LIKE "' . $chercher['nom'] . '%"';
            }

            // agrementation du libelle du produit
            $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

            if(is_array($_nom) AND count($_nom) > 1){
                foreach ($_nom as $mot){
                    $option[] = ' p.libelle_ospharm LIKE "%' . $mot .'%"';
                }
            }

            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' OR ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

        } else {

            if(isset($chercher['etat'])){
                $etat = '';
                $etat .= isset($chercher['etat']['i'])?
                    ' p.produit_actif = "i"' : '';
                $etat .= isset($chercher['etat']['o'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "o"' : '';
                $etat .= isset($chercher['etat']['n'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "n"' : '';
                $etat .= isset($chercher['etat']['a'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "a"' : '';
                $option[] = (count($chercher['etat']) > 1 )? "( $etat )" : $etat;
            }
            // recherche partielle
            if (isset($chercher['famille']) && !empty($chercher['famille'])){
                $option[] = ' p.id_famille = ' . $chercher['famille'];
            }
            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' AND ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . $_option : '';
        }

        return $recherche;
    }

    public function criterMoteurRechercheFamilles()
    {
        $chercher = $_SESSION['recherche'][$this->session];
        $recherche = '';
        $option = [];
        if( isset($chercher['nom']) AND !empty($chercher['nom']))
        {
            // recherche par libelle du produit
            if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
                $option[] = ' p.libelle_ospharm LIKE "' . $chercher['nom'] . '%"';
            }

            // agrementation du libelle du produit
            $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

            if(is_array($_nom) AND count($_nom) > 1){
                foreach ($_nom as $mot){
                    $option[] = ' p.libelle_ospharm LIKE "%' . $mot .'%"';
                }
            }

            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' OR ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

        } else {

            if(isset($chercher['etat'])){
                $etat = '';
                $etat .= isset($chercher['etat']['i'])?
                    ' p.produit_actif = "i"' : '';
                $etat .= isset($chercher['etat']['o'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "o"' : '';
                $etat .= isset($chercher['etat']['n'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "n"' : '';
                $etat .= isset($chercher['etat']['a'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "a"' : '';
                $option[] = (count($chercher['etat']) > 1 )? "( $etat )" : $etat;
            }
            // recherche partielle
            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' AND ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . $_option : '';
        }

        return $recherche;
    }

}