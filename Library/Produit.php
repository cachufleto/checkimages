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

        $balise = "<select name='labo'>";
        $balise .= "
            <option value='0'>---</option>";

        $choix = isset($_SESSION['recherche'][$this->session]['labo']) ?
                    $_SESSION['recherche'][$this->session]['labo'] : 0;
        foreach ($data as $info) {
            $selected = '';
            if($info['id'] == $choix){
                $selected = 'selected';
                $this->listeRecherche .= "Laboratoire : {$info['designation']}";
            }
            $balise .= "
            <option value='{$info['id']}' $selected >{$info['designation']}</option>";
        }
        $balise .= "
        </select>";

        return $balise;
    }

    public function listeEtat()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['etat'])?
                $_SESSION['recherche'][$this->session]['etat'] : '';

        $checked['i'] = isset($choix['i']) ? 'checked' : '';
        $checked['o'] = isset($choix['o']) ? 'checked' : '';
        $checked['n'] = isset($choix['n']) ? 'checked' : '';
        $checked['a'] = isset($choix['a']) ? 'checked' : '';
        $checked['e'] = isset($choix['e']) ? 'checked' : '';

        $this->listeRecherche .= isset($choix['i']) ? ": {$this->_lib['etat']['i']} " : '';
        $this->listeRecherche .= isset($choix['o']) ? ": {$this->_lib['etat']['o']} " : '';
        $this->listeRecherche .= isset($choix['n']) ? ": {$this->_lib['etat']['n']} " : '';
        $this->listeRecherche .= isset($choix['a']) ? ": {$this->_lib['etat']['a']} " : '';
        $this->listeRecherche .= isset($choix['e']) ? ": {$this->_lib['etat']['e']} " : '';

        $etat = "
            {$this->_lib['etat']['o']}<input name='etat[o]' type='checkbox' value='1' {$checked['o']} >
            {$this->_lib['etat']['i']}<input name='etat[i]' type='checkbox' value='1' {$checked['i']} >
            {$this->_lib['etat']['e']}<input name='etat[e]' type='checkbox' value='1' {$checked['e']} >
            {$this->_lib['etat']['n']}<input name='etat[n]' type='checkbox' value='1' {$checked['n']} >
            {$this->_lib['etat']['a']}<input name='etat[a]' type='checkbox' value='1' {$checked['a']} >
            ";

        return $etat;
    }

    public function inputCip()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['cip13']) ? $_SESSION['recherche'][$this->session]['cip13'] : '';
        if(!empty($choix)){
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
            $info['image'] = !isset($info['image'])? [] : $info['image'];
            if ($img = $this->getImage($info['cip13'])){
                $info['image'] = $this->imgProd($img, $info['cip13']);
            } else if (!empty($img = $this->testImage($info['cip13']))){
                $info['image'] = $img;
            } else {
                $info['image'] = [
                    'vignette'=>'',
                    'image'=>''
                    ];
            }

            if (file_exists(PHOTO . "en_cours/{$info['cip13']}.jpg")) {
                $info['image']['encours'] = figureHTMML('photos/en_cours/'.$info['cip13'].'.jpg', $info['cip13'].' EN COURS');
            }

            $_liste[] = $info;
        }
        return $_liste;
    }

    public function imgProd($img, $nom)
    {
        if ($img['image'] == 1 && $img['vignette'] == 1) {
            return [
                'image'=>figureHTMML($this->link . $nom . '.jpg',  $nom . ' Grande'),
                'vignette'=>figureHTMML($this->link . $nom . '_vig.jpg', $nom . ' Vignette')
                ];
        } else if ($img['image'] == 1) {
            return [
                'image'=>figureHTMML($this->link . $nom . '.jpg',  $nom . ' Grande'),
                'vignette'=>''
                ];
        } else if ($img['vignette'] == 1) {
            return [
                'image'=> '',
                'vignette'=>figureHTMML($this->link . $nom . '_vig.jpg', $nom . ' Vignette')
                ];
        }
        return false;
    }

    public function testImage($nom)
    {
        $img = [];
        $img['image'] = remote_file_exists('' . $this->link . $nom . '.jpg')? 1 : 0;
        $img['vignette'] = remote_file_exists('' . $this->link . $nom . '_vig.jpg')? 1 : 0;
        $this->setImage($nom, $img['image'], $img['vignette']);
        return $this->imgProd($img, $nom);
    }

    public function criterMoteurRecherche()
    {
        $chercher = $_SESSION['recherche'][$this->session];
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
                $option[] = " p.libelle_ospharm LIKE '%" . utf8_decode($chercher['nom']) . "%'";
            }

            // agrementation du libelle du produit
            $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

            if(is_array($_nom) AND count($_nom) > 1){
                foreach ($_nom as $mot){
                    $option[] = " p.libelle_ospharm LIKE '%" . utf8_decode($mot) . "%'";
                }
            }

            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' OR ') . $_r;
            }
            return (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

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

                $option[] = !empty($etat)? ((count($chercher['etat']) > 1 )? "( $etat )" : $etat) : "";

                if(isset($chercher['etat']['e'])){

                    $listeNew = $this->image->getProduitCipOK();
                    $liste = '';
                    if(is_array($listeNew)){
                        foreach ($listeNew as $key=>$cip){
                            $liste .= (empty($liste)? "" : ", ") . "'{$cip['cip13']}'";
                        }
                    }
                    $option[] = !empty($liste)? "p.cip13 IN ($liste)" : "";
                }
            }
            // recherche partielle
            if (isset($chercher['famille']) && !empty($chercher['famille'])){
                $option[] = ' p.id_famille = ' . $chercher['famille'];
            }

            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : '
             AND ') . $_r;
            }

            return (!empty($_option))? '
             AND ' . $_option : '';
        }
    }

    public function criterMoteurRechercheLaboratoires()
    {
        $chercher = $_SESSION['recherche'][$this->session];
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

            return (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

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

            return (!empty($_option))? ' AND ' . $_option : '';
        }
    }

    public function criterMoteurRechercheFamilles()
    {
        $chercher = $_SESSION['recherche'][$this->session];
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

            return (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

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

            return (!empty($_option))? ' AND ' . $_option : '';
        }
    }

}