<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 11:47
 */

namespace App;

require MOD . 'Produits.php';
use Model\Produits;

require_once LIB . 'NewImage.php';
use App\NewImage;

class Produit extends Produits
{
    var $link = '';
    var $_lib = [];
    var $page = '';
    var $listeRecherche = 'Recherche ';
    var $control = '';
    var $selectCIP = '';
    var $BDD = '';

    public function __construct()
    {
        $this->page = $_GET['page'];
        $this->_lib = file_contents_libelles();
        //$this->session = isset($this->session)? $this->session : 'Checkimages';
        $this->session = $_SESSION['actif'];

        $this->control = new NewImage();
        $this->control->connexion(SURFIMAGE);
        //$this->control->session = $this->session;
        $this->control->session = $this->session;
        $this->control->listeCIP();
        $this->selectCIP = $this->control->selectCIP;
    }

    public function countData()
    {
        $produit = isset($_SESSION[$this->session]['produit']) ? $_SESSION[$this->session]['produit'] : '';
        
        switch ($produit) {
            case 'ok':
                return $this->getCountOk($this->control->listeCIP());
                break;
            case 'ko':
                return $this->getCountKo($this->control->listeCIP());
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
                return $this->getOk($debut, $limit, $this->control->listeCIP());
                break;
            case 'ko':
                return $this->getKo($debut, $limit, $this->control->listeCIP());
                break;
            case '':
                return $this->get($debut, $limit);
                break;
        }
    }
    
    public function getImages($liste)
    {
        $_liste = [];
        foreach($liste as $key =>$info){
            $info['image'] = !isset($info['image'])? [] : $info['image'];
            if ($img = $this->control->getImage($info['cip13'])){
                $info['image'] = $this->imgProd($img, $info['cip13']);
            } else if (!empty($img = $this->imgProd($this->checkImage($info['cip13']), $info['cip13']))){
                $info['image'] = $img;
            } else {
                $info['image'] = [
                    'vignette'=>'',
                    'image'=>''
                    ];
            }

            if (file_exists(PHOTO . "en_cours/{$info['cip13']}.jpg")) {
                $info['image']['encours'] = figureHTML('photos/en_cours/'.$info['cip13'].'.jpg', $info['cip13'].' EN COURS');
            }

            $_liste[] = $info;
        }
        return $_liste;
    }

    public function imgProd($img, $nom)
    {
        //test de validité du type de produit
        $images = ['image'=>'','vignette'=>''];
        // test sur image 600x600
        if ($img['image'] == 1) {
            $images['image'] = figureHTML($this->link . $nom . '.jpg',  $nom . ' Grande');
            if($images['image'] == 'NULL'){
                return false;
            }
        }
        // test sur vignette 162x162
        if ($img['vignette'] == 1) {
            $images['vignette'] = figureHTML($this->link . $nom . '_vig.jpg', $nom . ' Vignette');
            if($images['vignette'] == 'NULL'){
                return false;
            }
        }
        return $images;
    }

    public function testImage($nom)
    {
        return $this->imgProd($this->checkImage($nom), $nom);
    }

    public function checkImage($nom)
    {
        $img = [];
        $img['image'] = remote_file_exists('' . $this->link . $nom . '.jpg')? 1 : 0;
        $img['vignette'] = remote_file_exists('' . $this->link . $nom . '_vig.jpg')? 1 : 0;
        
        if($getimg = $this->control->getImage($nom)){
            if($getimg['image'] != $img['image'] OR $getimg['vignette'] != $img['vignette'] ){
                $this->control->updateImage($nom, $img['image'], $img['vignette'], $this->control->type);
            }
        }else {
            $this->control->setImage($nom, $img['image'], $img['vignette'], $this->control->type);
        }

        return $img;
    }
    /*
    public function criterMoteurRecherche()
    {
        debug(__FUNCTION__, 'FUNCTIONS');
        $chercher = $_SESSION['recherche'][$this->session];
        $option = [];
        $selection = '';
        if( (
                isset($chercher['cip13']) AND !empty($chercher['cip13'])
            ) OR (
                isset($chercher['nom']) AND !empty($chercher['nom'])
            ) )
        {
            // recherche par cip
            if (isset($chercher['cip13']) AND !empty($chercher['cip13'])){
                $selection .= $this->moteurRechercheCip13($chercher['cip13']);
            }

            // recherche par libelle du produit
            if( isset($chercher['nom']) AND !empty($chercher['nom']))
            {
                $selection .= $this->moteurRechecheNom($chercher['nom']);
            }

        } else {

            if (isset($chercher['labo']) && $chercher['labo'] > 0){
                $selection .= $this->moteurRechercheLaboratoire($chercher['labo']);
            }

            if(isset($chercher['etat'])){
                $selection .= $this->moteurRechecheEtat($chercher['etat']);
            }

            // recherche partielle
            if (isset($chercher['famille']) && !empty($chercher['famille'])){
                $selection .= $this->moteurRechercheFamilles($chercher['famille']);
            }

            return (!empty($selection))? $selection : '';
        }
    }

    public function criterMoteurRechercheLaboratoires()
    {
        debug(__FUNCTION__, 'FUNCTIONS');
        $chercher = $_SESSION['recherche'][$this->session];
        $selection = '';
        if( isset($chercher['nom']) AND !empty($chercher['nom']))
        {
            $selection .= $this->moteurRechecheNom($chercher['nom']);
        }

        if(isset($chercher['etat'])){
            $selection .= $this->moteurRechecheEtat($chercher['etat']);
        }

        if (isset($chercher['famille']) && !empty($chercher['famille'])){
            $selection .= $this->moteurRechercheFamilles($chercher['famille']);
        }

        return $selection;

    }

    public function criterMoteurRechercheFamilles()
    {
        debug(__FUNCTION__, 'FUNCTIONS');
        $chercher = $_SESSION['recherche'][$this->session];
        $selection = '';
        if (isset($chercher['labo']) && $chercher['labo'] > 0){
            $selection .= $this->moteurRechercheLaboratoire($chercher['labo']);
        }

        if( isset($chercher['nom']) AND !empty($chercher['nom']))
        {
            $selection .= $this->moteurRechecheNom($chercher['nom']);
        }

        if(isset($chercher['etat'])){
            $selection .= $this->moteurRechecheEtat($chercher['etat']);
        }

        return $selection;
    }

    public function moteurRechercheCip13($cip13)
    {
        // recherche partielle
        return " AND p.cip13 LIKE '%$cip13%'";

    }

    public function moteurRechercheLaboratoire($laboratoire)
    {
        // recherche partielle
        return " AND p.id_laboratoire = $laboratoire ";
    }

    public function moteurRechercheFamilles($famille)
    {
        // recherche partielle
        return ' AND p.id_famille = ' . $famille;
    }

    public function moteurRechecheEtat($etat)
    {
        $_etat = '';
        foreach ($etat as $key=>$val){
            if($key != 'e'){
                $_etat .= (!empty($_etat)? ' OR ' : '' ) . " p.produit_actif = '$key'";
            }
        }

        $_etat = !empty($_etat)? ' AND ' . ((count($etat) > 1 )? "( $_etat )" : $_etat) : '';

        if(isset($etat['e'])){
            $listeNew = $this->image->getProduitCipOK();
            $liste = '';
            if(is_array($listeNew)){
                foreach ($listeNew as $key=>$cip){
                    $liste .= ", '{$cip['cip13']}'";
                }
            }
            $_etat .=  " AND p.cip13 IN (''$liste)";
        }

        return $_etat;
    }

    public function moteurRechecheNom($nom){
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

        return ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option);
    }
    */
}