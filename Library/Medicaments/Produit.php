<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 11:47
 */

namespace Medicaments;
require MOD . 'Medicaments.php';
use Model\Medicaments;

class Produit extends Medicaments
{
    public function __construct()
    {
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
            $select = ($info['id'] == $choix) ? 'selected' : '';
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
        $etat .= '
        On Line<input name="etat[o]" type="checkbox" value="1" ' .
            (isset($choix['o']) ? 'checked' : '')
            . ' >';
        $etat .= '
        Off line<input name="etat[n]" type="checkbox" value="1" ' .
            (isset($choix['n']) ? 'checked' : '')
            . ' >';
        $etat .= '
        Archivé<input name="etat[a]" type="checkbox" value="1" ' .
            (isset($choix['a']) ? 'checked' : '')
            . ' >';

        return $etat;
    }

    public function inputCip()
    {
        $choix = isset($_SESSION['recherche'][$this->page]['cip13']) ? $_SESSION['recherche'][$this->page]['cip13'] : '';
        return '<input type="texte" name="cip13" placeholder="' . $choix . '" >';
    }

    public function inputNom()
    {
        $choix = isset($_SESSION['recherche'][$this->page]['nom']) ? $_SESSION['recherche'][$this->page]['nom'] : '';
        return '<input type="texte" name="nom" placeholder="' . $choix . '" >';
    }

    public function listeFamilles()
    {
        $data = $this->getFamilles();

        $balise = '<select name="famille">';

        $choix = isset($_SESSION['recherche'][$this->page]['famille']) ? $_SESSION['recherche'][$this->page]['famille'] : 0;
        foreach ($data as $info) {
            $select = ($info['id'] == $choix) ? 'selected' : '';
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
            return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />'
            . '<img height="250px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($img['image'] == 1) {
            return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($img['vignette'] == 1) {
            return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />';
        }
        return false;
    }

    public function testImage($nom){

        $_grand = remote_file_exists('https://www.pharmaplay.fr/m/produits/' . $nom . '.jpg');
        $_vignette = remote_file_exists('https://www.pharmaplay.fr/m/produits/' . $nom . '_vig.jpg');

        if ($_grand && $_vignette) {
            $this->setImage($nom, 1, 1);
            return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />'
            . '<img height="250px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($_grand) {
            $this->setImage($nom, 1, 0);
            return '<img height="250px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '.jpg" alt="' . $nom . ' Grande"  border="0" />';
        } else if ($_vignette) {
            $this->setImage($nom, 0, 1);
            return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $nom . '_vig.jpg" alt="' . $nom . ' Vignette"  border="0" />';
        }

        return false;
    }

    public function afficheMenu($numProduits = 0)
    {

        extract($_SESSION[$this->page]);

        $titre = ($p)? (
                    ($produit == 'ok')?
                        'Liste des produits avec images' :
                        "Produits écartes"
                    ) :
                    "Produits à traiter";

        $_arriere = ($display >= 1)? $display-1 : 0;
        $_suivante = ($display == intval($numProduits/$b))? $display : $display+1 ;

        $l = ($p)? $b."&produit=$produit" : $b;
        $f = '&display=' . $display . '&nombre=' . $l;
        $link = '
    << <a href="?page=' . $this->page . '&display=' . $_arriere . '&nombre=' . $l .'"> page avant</a> ::
    <a href="?page=' . $this->page . '&produit=ok"> Sélectionées  </a> :: 
    <a href="?page=' . $this->page . '&produit=ko"> Ecartés </a> :: 
    <a href="?page=' . $this->page . '"> à traiter </a>
    <a href="?page=' . $this->page . '&display=' . $_suivante . '&nombre=' . $l . '"> page suivante</a> >>  
    ';

        include VUE . 'menu.tpl.php';
        return $f;
    }


}