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

debug($_SERVER, 'SERVER');
debug($_REQUEST, 'REQUEST');
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
        $presentation = $this->inputPresentation();
        $denomination = $this->inputDenomination();
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

    public function inputDenomination()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['denomination']) ? $_SESSION['recherche'][$this->session]['denomination'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }

        return '<input type="texte" name="denomination" placeholder="' . $choix . '" >';
    }

    public function inputPresentation()
    {
        $choix = isset($_SESSION['recherche'][$this->session]['presentation']) ? $_SESSION['recherche'][$this->session]['presentation'] : '';
        if($choix){
            $this->listeRecherche = ": $choix ";
        }

        return '<input type="texte" name="presentation" placeholder="' . $choix . '" >';
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
            $info['image'] = '';
            $info['data'] = '';
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
            $this->zapper = ">= 0 ";
            $this->rechercheCip = " AND i.cip13 LIKE '%{$chercher['cip13']}%' ";
        }

        // recherche par libelle du produit
        if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
            $this->zapper = ">= 0 ";
            $this->rechercheNom = " AND  i.nom LIKE '%{$chercher['nom']}%' ";
        }

        // recherche par libelle du produit
        if (isset($chercher['denomination']) AND !empty($chercher['denomination'])) {
            $option[] = " p.denomination LIKE '%" . utf8_decode($chercher['denomination']) . "%' ";
        }

        // agrementation du libelle du produit
        $_nom = (isset($chercher['denomination']) AND !empty($chercher['denomination']))? explode(' ', $chercher['denomination']) : '';

        if(is_array($_nom) AND count($_nom) > 1){
            foreach ($_nom as $mot){
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

    public function updateImageJpg($produit, $new)
    {
        $origine = $produit['cip13'];

        $produit['cip13'] = $new;
        $this->enregistrerImageJpg($produit);
        
        if($origine != $new AND file_exists(PHOTO . "en_cours/$origine.jpg")){
            unlink(PHOTO . "en_cours/$origine.jpg");
        }
    }

    public function enregistrerImageJpg($produit)
    {
        $_url = $url = str_replace('//'.$produit['nom'], '/'.$produit['nom'], $produit['site'] . '/' . $produit['nom']);

        if(file_exists(SITE . $_url)){
            $url = LINK . $url;
        } else if(file_exists(SITE . $_url . '.jpg')){
            $url = LINK . $url . '.jpg';
        }

        $image = $this->open_image($url);

        if ($image === false) { die ('Unable to open image'); }

        $w = imagesx($image);
        $h = imagesy($image);

        //calculate new image dimensions (preserve aspect)
        if(isset($_GET['w']) && !isset($_GET['h'])){
            $new_w=$_GET['w'];
            $new_h=$new_w * ($h/$w);
        } elseif (isset($_GET['h']) && !isset($_GET['w'])) {
            $new_h=$_GET['h'];
            $new_w=$new_h * ($w/$h);
        } else {
            $new_w=isset($_GET['w'])?$_GET['w']:560;
            $new_h=isset($_GET['h'])?$_GET['h']:560;
            if(($w/$h) > ($new_w/$new_h)){
                $new_h=$new_w*($h/$w);
            } else {
                $new_w=$new_h*($w/$h);
            }
        }

        $im2 = ImageCreateTrueColor($new_w, $new_h);
        imagecopyResampled ($im2, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        //effects
        if(isset($_GET['blur'])){
            $lv=$_GET['blur'];
            for($i=0; $i<$lv;$i++){
                $matrix=array(array(1,1,1),array(1,1,1),array(1,1,1));
                $divisor = 9;
                $offset = 0;
                imageconvolution($im2, $matrix, $divisor, $offset);
            }
        }

        if(isset($_GET['sharpen'])){
            $lv=$_GET['sharpen'];
            for($i=0; $i<$lv;$i++){
                $matrix = array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1));
                $divisor = 8;
                $offset = 0;
                imageconvolution($im2, $matrix, $divisor, $offset);
            }
        }

        //var_dump($produit);
        imagejpeg($im2, PHOTO. "en_cours/{$produit['cip13']}.jpg");
        $this->updateImageURL($produit['id'], 'photos/en_cours', $produit['cip13']);

        if(!preg_match('/(photos.en_cours)/', $_url) AND file_exists(SITE . $_url)){
            unlink(SITE . $_url);
        } else if(file_exists(SITE . $_url) AND $produit['cip13'].'.jpg' != $produit['nom']){
            unlink(SITE . $_url);
        }
    }

    public function open_image ($file) {
        //detect type and process accordinally
        global $type;
        $size=getimagesize($file);
        switch($size["mime"]){
            case "image/jpeg":
                $im = imagecreatefromjpeg($file); //jpeg file
                break;
            case "image/gif":
                $im = imagecreatefromgif($file); //gif file
                break;
            case "image/png":
                $im = imagecreatefrompng($file); //png file
                break;
            default:
                $im=false;
                break;
        }
        return $im;
    }

    public function typeMime($file){
        //$liste .= '<img src="'.(str_replace(__DIR__.'/', '', $test)).'" width="72" height="72">' . "\n";
        $finfo = finfo_open(FILEINFO_MIME); // Retourne le type mime

        if (!$finfo) {
            echo "Échec de l'ouverture de la base de données fileinfo";
            exit();
        }
        $typeFile = finfo_file($finfo, $file);

        /* Fermeture de la connexion */
        finfo_close($finfo);
        if(preg_match('#^image#', $typeFile))
            return true;
    }

    public function uploadImageExist($repertoire, $nom)
    {
        if($images = $this->getImageUpload($repertoire, $nom))
        {
            return false;
        }
        $this->listeLocal['id'] .= ", ".$this->setImageLocal($repertoire, $nom);
        $this->listeLocal['nom'] .= ", '$nom'";
    }

    public function listerReperoires($dir){
        // Ouvre un dossier bien connu, et liste tous les fichiers
        $dir = str_replace('\\', '/', $dir);
        if (is_dir($dir)) {
            
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if($file != '.' AND $file != '..'){
                        $test = $dir . '/' . $file;
                        $type = filetype($test);
                        if($type == 'dir'){
                            $this->listerReperoires($test);
                        }

                        if ( $this->typeMime($test)) {
                            // injection en base de données
                            // $liste .= '<img src="'.(str_replace(__DIR__.'/', '', $test)).'">' . "\n";
                            //$this->listeLocal .= '<br>INSERT INTO '.(str_replace(__DIR__.'/', '', $test))."\n";
                            $name = str_replace('×', '',
                                    str_replace(' ', '',
                                    str_replace('(', '',
                                    str_replace(')', '',
                                    utf8_encode(basename($test))))));

                            //exit($test . " ---> " . dirname($test) . '/'. $name);
                            if($name != basename($test) ) {
                                copy($test, dirname($test) . '/'. $name);
                                unlink($test);
                            }

                            $this->uploadImageExist(str_replace(SITE, '', dirname($test)), $name);
                            
                        }else if($type != 'dir'){
                            // suppression de la source
                            unlink($test);
                        }
                    }
                }
                closedir($dh);
            }
        }
    }

}

