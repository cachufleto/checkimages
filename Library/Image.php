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
            $info['image'] = [];
            $info['data'] = '';
            $info['data'] = $this->getProduit($info['id']);
            $info['image']['image'] = $this->testImage($info['nom'], $info['site']);

            $info['image']['encours'] = '';
            if (!empty($info['cip13']) AND file_exists(PHOTO . "en_cours/{$info['cip13']}.jpg")) {
                $info['image']['encours'] = figureHTMML("photos/en_cours/{$info['cip13']}.jpg", "EN COURS");
                // existante sur le site
            }

            $info['image']['vignette'] = '';
            if (!empty($info['cip13']) AND file_exists(PHOTO . "en_cours/{$info['cip13']}_vig.jpg")) {
                $info['image']['vignette'] = figureHTMML("photos/en_cours/{$info['cip13']}_vig.jpg", "VIGNETTE");
            }

            if(!empty($info['cip13'])){
                $info['image']['production'] = $this->imgTestProd($info['cip13']);
            }

            // Retour du POST dans le formulaire
            if(!empty($_POST) && $_POST['id'] == $info['id']){
                $info['data']['cip13'] = $_POST['cip13'];
                $info['data']['denomination'] = $_POST['denomination'];
                $info['data']['presentation'] = $_POST['presentation'];
                $info['data']['type'] = $_POST['type'];
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

    public function imgTestProd($cip13){
        $info = [];
        if ($img = $this->medicament->getImage($cip13)){
            $info['medicament'] = $this->medicament->imgProd($img, $cip13);
        }

        if ($img = $this->pharmacie->getImage($cip13)){
            $info['pharmacie'] = $this->medicament->imgProd($img, $cip13);
        }
        return $info;
    }

    public function imgLocal($img, $nom)
    {
        if ($img['image'] == 1) {
            return figureHTMML($nom, 'Originale');
        }
        return false;
    }

    public function testImage($nom, $link)
    {
        $img = [];
        if(preg_match('/^(http)/', $link)){
            $img['image'] = remote_file_exists(str_replace('//'. $nom, '/'. $nom, $link . '/'. $nom) )? 1 : 0;
        } else {
            $img['image'] = file_exists(SITE . str_replace('//'. $nom, '/'. $nom, $link . '/'. $nom) )? 1 : 0;
        }
        return $this->imgLocal($img, str_replace('//'. $nom, '/'. $nom, $link . '/'. $nom));
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

        // recherche par le nom de l'image
        if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
            $this->zapper = ">= 0 ";
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

    public function renommerImage($produit, $new)
    {
        // on verifie chaque possibilité
        // l'image est dans le repertoire de en cours
        // on verifie si l'image de destination existe déjà
        $urlNew = str_replace('//' . $new, '/' . $new, PHOTO . 'en_cours/' . $new . '.jpg');

        if (file_exists($urlNew)) {
            return false;
        }

        // on verifie si l'image d'irigine existe bien
        if(preg_match('/^(photo)/', $produit['site']) ) {

            $url = str_replace('//' . $produit['cip13'], '/' . $produit['cip13'], PHOTO . 'en_cours/' . $produit['cip13'] . '.jpg');
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
        $origine = $produit['cip13'];
        if(preg_match('/^(photo)/', $produit['site']) AND $origine != $new ){
            $this->renommerImage($produit, $new);
        } else {
            $produit['cip13'] = $new;
            $this->enregistrerImageJpg($produit);
        }
    }

    public function enregistrerImageJpg($produit, $url = '')
    {
        $_url = empty($url)?
            str_replace('//'.$produit['nom'], '/'.$produit['nom'], $produit['site'] . '/' . $produit['nom']) :
            $url;

        $image = $this->open_image($_url);
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

        imagejpeg($im2, PHOTO. "en_cours/{$produit['cip13']}.jpg");
        $this->updateImageURL($produit['id'], $produit['cip13']);

        if(preg_match('/^(photos)/', $produit['site']) AND file_exists(SITE . $_url)){
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
    }

    public function setData()
    {
        $id = intval($_POST['id']);
        $cip13 = utf8_decode(trim(str_replace(' ', '', $_POST['cip13'])));
        $denomination = utf8_decode($_POST['denomination']);
        $presentation = utf8_decode($_POST['presentation']);
        $type = intval($_POST['type']);

        if(empty($cip13)){
            $this->msg = 'Le code CIP doit être renseigné!';
            return false;
        }

        if(preg_match('/[a-zA-Z-]/', $cip13)){
            $this->msg = 'Le code CIP doit contenir uniquement des chiffres';
            return false;
        }

        if(strlen($cip13) != 13){
            $this->msg = 'Le code CIP doit contenir 13 chiffres!';
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
}

