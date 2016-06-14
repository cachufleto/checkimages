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
        include CONF . 'libelles.php';
        $this->page = $_GET['page'];
        $this->_lib = $_libelle;
    }

    public function count()
    {
        $produit = isset($_SESSION[$this->page]['produit']) ? $_SESSION[$this->page]['produit'] : '';
        
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
        $produit = isset($_SESSION[$this->page]['produit']) ? $_SESSION[$this->page]['produit'] : '';
        $debut = isset($_SESSION[$this->page]['a']) ? $_SESSION[$this->page]['a'] : 0;
        $limit = isset($_SESSION[$this->page]['b']) ? $_SESSION[$this->page]['b'] : NUM;

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

        $choix = isset($_SESSION['recherche'][$this->page]['labo']) ? $_SESSION['recherche'][$this->page]['labo'] : 0;
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
        $choix = isset($_SESSION['recherche'][$this->page]['etat']) ? $_SESSION['recherche'][$this->page]['etat'] : '';

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
        $choix = isset($_SESSION['recherche'][$this->page]['cip13']) ? $_SESSION['recherche'][$this->page]['cip13'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }
        return '<input type="texte" name="cip13" placeholder="' . $choix . '" >';

    }

    public function inputNom()
    {
        $choix = isset($_SESSION['recherche'][$this->page]['nom']) ? $_SESSION['recherche'][$this->page]['nom'] : '';
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
        $choix = isset($_SESSION['recherche'][$this->page]['famille']) ? $_SESSION['recherche'][$this->page]['famille'] : 0;
        foreach ($data as $info) {
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
            $_liste[] = $info;
        }
        return $_liste;
    }

    public function imgProd($_img, $nom){
        $img = $_img[0];
        if ($img['image'] == 1 && $img['vignette'] == 1) {
            return '<img height="150px" src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />'
            . '<img height="250px" src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($img['image'] == 1) {
            return '<img height="150px" src="' . $this->link . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($img['vignette'] == 1) {
            return '<img height="150px" src="' . $this->link . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />';
        }
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

    public function afficheMenu()
    {


        extract($_SESSION[$this->page]);

        $numProduits = $this->count();
        $titre = ($p)? (
                    ($produit == 'ok')?
                        $this->_lib['avecImage']:
                        $this->_lib['sansImage']
                    ) :
                    $this->_lib['tousImage'];

        $_arriere = ($display >= 1)? $display-1 : 0;
        $_suivante = ($display == intval($numProduits/$b))? $display : $display+1 ;

        $l = ($p)? $b."&produit=$produit" : $b;
        $f = '&display=' . $display . '&nombre=' . $l;
        $link = '
    <a class="page" href="?page=' . $this->page . '&display=' . $_arriere . '&nombre=' . $l .'"><<</a> page précédente
    <a ' . (($produit == 'ok')? 'class="actif"' : "") . ' href="?page=' . $this->page . '&produit=ok"> ' . $this->_lib['bouttonAvecImage'] . '  </a>  
    <a ' . (($produit == 'ko')? 'class="actif"' : "") . ' href="?page=' . $this->page . '&produit=ko"> ' . $this->_lib['bouttonSansImage'] . ' </a>  
    <a ' . (($produit == '')? 'class="actif"' : "") . ' href="?page=' . $this->page . '"> ' . $this->_lib['bouttonTousImage'] . ' </a>
     page suivante <a class="page" href="?page=' . $this->page . '&display=' . $_suivante . '&nombre=' . $l . '">>></a>  
    ';

        include VUE . 'menu.tpl.php';
        return $f;
    }


}