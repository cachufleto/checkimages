<?php
/**
 * Created by ceidodev.com
 * User: User
 * Date: 26/07/2016
 * Time: 10:55
 */

namespace App;


class Moteur 
{
    var $image = '';
    var $produit = '';
    var $chercher = '';
    var $Nom = '';
    var $Cip13 = '';
    var $Laboratoire = '';
    var $Famille = '';
    var $Etat = '';
    var $EnCours = '';
    var $imageNom = '';
    var $imageCip13 = '';
    var $imageDenomination = '';
    var $imagePresentation = '';
    var $Zapper = '';
    var $Recherche = '';
    var $RechercheImage = '';
    var $listeRecherche = '';
    var $rechercheLaboratoires = '';
    var $rechercheFamilles = '';

    public function __construct($produit, $image, $session)
    {
        $this->produit = $produit;
        $this->image = $image;
        $this->chercher = $session;
        $this->_lib = file_contents_libelles();

        /**********************************/
        $this->rechercheImageZapper();
        $this->rechercheNom();
        $this->rechercheCip13();
        $this->rechercheLaboratoire();
        $this->rechercheFamilles();
        $this->rechecheEtat();
        $this->rechercheImageNom();
        $this->rechercheImageDenomination();
        $this->rechercheImagePresentation();

        /**********************************/
        $this->criterMoteurRecherche();
        $this->criterMoteurRechercheImage();
        $this->criterMoteurRechercheLaboratoires();
        $this->criterMoteurRechercheFamilles();
    }

    public function criterMoteurRecherche()
    {
        $recherche = '';
        if(!empty($this->Cip13) OR !empty($this->Nom))
        {
            $recherche .= $this->Cip13;
            $recherche .= $this->Nom;

        } else {

            $recherche .= $this->Laboratoire;
            $recherche .= $this->Etat;
            $recherche .= $this->Famille;

        }
        $this->Recherche = (!empty($recherche))? $recherche : '';
    }

    public function criterMoteurRechercheImage()
    {
        $recherche = $this->imageNom;
        $recherche .= $this->imageCip13;
        $recherche .= $this->imageDenomination;
        $recherche .= $this->imagePresentation;

        $this->RechercheImage = (!empty($recherche))? $recherche : '';
    }

    /*******************************************************************/

    public function criterMoteurRechercheLaboratoires()
    {
        $this->rechercheLaboratoires = $this->Nom . $this->Etat . $this->Famille;
    }

    public function criterMoteurRechercheFamilles()
    {
        $this->rechercheFamilles = $this->Laboratoire . $this->Nom . $this->Etat;
    }

    /*******************************************************************/
    
    public function rechercheCip13()
    {
        if(!isset($this->chercher['cip13']) OR empty($this->chercher['cip13'])){
            return;
        }
        $this->Cip13 = " AND p.cip13 LIKE '%{$this->chercher['cip13']}%'";
        $this->imageCip13 = " AND i.cip13 LIKE '%{$this->chercher['cip13']}%'";
    }

    public function rechercheLaboratoire()
    {
        $Laboratoire = isset($this->chercher['labo'])? intval($this->chercher['labo']) : 0;
        if(!isset($this->chercher['labo']) OR $Laboratoire<1){
            return;
        }
        $this->Laboratoire = " AND p.id_laboratoire = {$Laboratoire} ";
    }

    public function rechercheFamilles()
    {
        if(!isset($this->chercher['famille']) OR $this->chercher['famille'] < 1){
            return;
        }
        $this->Famille = ' AND p.id_famille = ' . $this->chercher['famille'];
    }

    public function rechecheEtat()
    {
        if(!isset($this->chercher['etat'])){
            return;
        }

        $etat = $this->chercher['etat'];
        $encour = isset($etat['e'])? true : false;

        if($encour){
            unset($etat['e']);
        }

        $recherche = '';
        if(is_array($etat) AND !empty($etat)){
            foreach ($etat as $key=>$val){
                $recherche .= (!empty($recherche)? ' OR ' : '' ) . " p.produit_actif = '$key'";
            }
            $recherche = ' AND ' . ((count($etat) > 1 )? "( $recherche )" : $recherche);
            $this->Etat = $recherche;
        }

        if($encour AND (!isset($this->chercher['cip13']) OR empty($this->chercher['cip13']))){

            $listeNew = $this->image->getProduitCipOK();
            $listeCip = "'0123456789'";
            if(is_array($listeNew)){
                foreach ($listeNew as $key=>$cip){
                    $listeCip .= ", '{$cip['cip13']}'";
                }
            }
            $recherche = " OR p.cip13 IN ($listeCip)";
            $this->EnCours = $recherche;
        }

    }

    public function rechercheNom()
    {

        if(!isset($this->chercher['nom']) OR empty($this->chercher['nom'])){
            return;
        }

        $nom =  $this->chercher['nom'];
        $option = [];
        // recherche par libelle du produit
        $option[] = ' p.libelle_ospharm LIKE "%' . $nom . '%"';
        // agrementation du libelle du produit
        $_nom = explode(' ', $nom);

        if(is_array($_nom) AND count($_nom) > 1){
            foreach ($_nom as $mot){
                $option[] = ' p.libelle_ospharm LIKE "%' . $mot .'%"';
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }

        $this->Nom = ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option);
    }

    public function rechercheImageZapper()
    {
        $this->Zapper = (isset($this->chercher['etat']) and !is_array($this->chercher['etat']))?
                        "= ".$this->chercher['etat'] : "= 0";

        $this->Zapper = isset($_POST['all'])? ">= 0 " : $this->Zapper;
    }

    public function rechercheImageNom()
    {

        if(!isset($this->chercher['nom']) OR empty($this->chercher['nom'])){
            return;
        }

        $nom =  $this->chercher['nom'];
        $option = [];
        // recherche par libelle du produit
        $option[] = ' i.nom LIKE "%' . $nom . '%"';
        // agrementation du libelle du produit
        $_nom = explode(' ', $nom);

        if(is_array($_nom) AND count($_nom) > 1){
            foreach ($_nom as $mot){
                $option[] = ' i.nom LIKE "%' . $mot .'%"';
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }

        $this->imageNom = ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option);
    }

    public function rechercheImageDenomination()
    {

        // recherche par libelle du produit
        if (!isset($this->chercher['denomination']) OR empty($this->chercher['denomination'])) {
            return;
        }

        $option[] = " p.denomination LIKE '%" . utf8_decode($this->chercher['denomination']) . "%' ";
        // agrementation du libelle du produit
        $_denomination = explode(' ', $this->chercher['denomination']);

        if(is_array($_denomination) AND count($_denomination) > 1){
            foreach ($_denomination as $mot){
                $option[] = " p.denomination LIKE '%" . utf8_decode($mot) . "%'";
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }

        $this->imageDenomination = ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option);
    }

    public function rechercheImagePresentation()
    {

        // recherche par libelle du produit
        if (!isset($this->chercher['presentation']) OR empty($this->chercher['presentation'])) {
            return;
        }

        $option[] = " p.presentation LIKE '%" . utf8_decode($this->chercher['presentation']) . "%' ";
        // agrementation du libelle du produit
        $_presentation = explode(' ', $this->chercher['presentation']);

        if(is_array($_presentation) AND count($_presentation) > 1){
            foreach ($_presentation as $mot){
                $option[] = " p.presentation LIKE '%" . utf8_decode($mot) . "%'";
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }

        $this->imagePresentation = ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option);
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

    function afficheMoteurRechercheImages()
    {
        $presentation = $this->inputPresentation();
        $denomination = $this->inputDenomination();
        $Etat = $this->listeEtatImage();
        $Code = $this->inputCip();
        $Nom = $this->inputNom();
        $listeRecherche = $this->listeRecherche;

        include_once VUE . 'moteurRechercheImages.tpl.php';
    }

    public function inputDenomination()
    {
        $choix = isset($this->chercher['denomination']) ? $this->chercher['denomination'] : '';
        if(!empty($choix)){

        }$this->listeRecherche .= ": $choix ";

        return '<input type="texte" name="denomination" placeholder="' . $choix . '" >';
    }

    public function inputPresentation()
    {
        $choix = isset($this->chercher['presentation']) ? $this->chercher['presentation'] : '';
        if(!empty($choix)){
            $this->listeRecherche .= ": $choix ";
        }

        return '<input type="texte" name="presentation" placeholder="' . $choix . '" >';
    }

    public function listeFamilles()
    {
        $data = $this->produit->getFamilles();

        $balise = '<select name="famille">';
        $balise .= '
            <option value="0">---</option>';
        $choix = isset($this->chercher['famille']) ? $this->chercher['famille'] : 0;
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

    public function inputNom()
    {
        $choix = isset($this->chercher['nom']) ? $this->chercher['nom'] : '';
        if(!empty($choix)){
            $this->listeRecherche = ": $choix ";
        }

        return '<input type="texte" name="nom" placeholder="' . $choix . '" >';
    }

    public function inputCip()
    {
        $choix = isset($this->chercher['cip13']) ? $this->chercher['cip13'] : '';
        if(!empty($choix)){
            $this->listeRecherche = ": $choix ";
        }
        return '<input type="texte" name="cip13" placeholder="' . $choix . '" >';

    }

    public function selectLaboratoires()
    {
        $data = $this->produit->getLaboratoires();

        $balise = "<select name='labo'>";
        $balise .= "
            <option value='0'>---</option>";

        $choix = isset($this->chercher['labo']) ?
            $this->chercher['labo'] : 0;
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
        $choix = isset($this->chercher['etat'])?
            $this->chercher['etat'] : '';

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

    public function listeEtatImage()
    {
        $choix = isset($this->chercher['etat'])?
            $this->chercher['etat'] : '';

        $checked[0] = empty($choix) ? 'checked' : '';
        $checked[1] = (!empty($choix) && $choix == 1) ? 'checked' : '';
        $checked[2] = (!empty($choix) && $choix == 2) ? 'checked' : '';

        $etat = "{$this->_lib['etat'][0]}<input name='etat' type='radio' value='0' {$checked[0]} >
            {$this->_lib['etat'][1]}<input name='etat' type='radio' value='1' {$checked[1]} >
            {$this->_lib['etat'][2]}<input name='etat' type='radio' value='2' {$checked[2]} >";

        $this->listeRecherche .= !empty($choix) ? ": " . $this->_lib['etat'][$choix] : '';
        return $etat;
    }

}