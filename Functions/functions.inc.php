<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 01/06/2016
 * Time: 13:07
 */

/*
 * RETURN array route
 */
function file_contents_route(){
    include ( CONF . 'route.inc');
    return $_r;
}

/*
 * RETURN array Textes du site
 */
function file_contents_libelles()
{
    include CONF . 'libelles.php';
    return $_libelle;
}

/*
 * RETURN array Type Mimes des images
 */
function file_contents_mimes()
{
    include CONF . 'mimes.php';
    return $mimes;
}

/*
 * RETURN array Items de navigation
 */
function file_contents_nav()
{
    include CONF . 'nav.inc';
    return $nav;
}

/*
 * RETURN array Items de navigation Optionels
 */
function file_contents_option()
{
    include CONF . 'nav.inc';
    return $option;
}

/*
 * RETURN array Champs Obligatoires
 */
function file_contents_medicaments()
{
    include CONF . 'champsObligatoires.php';
    return $medicaments;
}

/*
 * RETURN array Champs Obligatoires
 */
function file_contents_parapharmacie()
{
    include CONF . 'champsObligatoires.php';
    return $parapharmacie;
}


/*
   Return error codes:
   1 = Invalid URL host
   2 = Unable to connect to remote host
*/

function remote_file_exists ($url)
{
    $head = "";

    $url_p = parse_url ($url);
    
    if (isset ($url_p["host"])){
        $host = $url_p["host"]; 
    } else { 
        return false; 
    }
    
    if (isset ($url_p["path"])){ 
        $path = $url_p["path"];
    }

    $_host = preg_match('#https#', $url)? 'tls://'.$host : $host;
    $_port = preg_match('#https#', $url)? 443 : 80;

    $fp = fsockopen ($_host, $_port);

    if (!$fp) {
        return false; 
    } else {
        $parse = parse_url($url);
        $host = $parse['host'];
        fputs($fp, "HEAD ".$url." HTTP/1.1\r\n");
        fputs($fp, "HOST: ".$host."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        $headers = "";
        while (!feof ($fp))
        { $headers .= fgets ($fp, 128); }
    }
    
    fclose ($fp);

    $arr_headers = explode("\n", $headers);
    $return = false;

    if (isset ($arr_headers[0])) {
        $return = strpos ($arr_headers[0], "404") === false;
    }

    return $return;
}

function figureHTML($nom, $texte)
{
    /*
     * trouver le moyens de anticiper l'erreur du type 1 ou 2
     * */
    $info = "ERREUR : l'image n'est plus disponible";
    if($attributs = image_attributs($nom)){
        $info = "({$attributs[0]} x {$attributs[1]})";

    return "<figure>
            <img src='$nom' alt='$texte'/>
            <figcaption>$texte $info</figcaption>
            </figure>";
    }
    
    return "NULL";
}

function image_attributs($nom)
{
    if(preg_match('#^http#', $nom)){
        if(remote_file_exists($nom)) {
            return getimagesize($nom);
        }
    } else if(file_exists(SITE . $nom)){
        return getimagesize($nom);
    }

    return false;
}

function testCIP13($cip13)
{
    $cip13 = utf8_decode(trim(str_replace(' ', '', $cip13)));
    return (!preg_match('/[a-zA-Z-]/', $cip13) and strlen($cip13) == 13)? $cip13 : false;
}

function remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_SUBSTITUTE, $charset);
    $str = preg_replace('#&([A-za-z])(?:mp|acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
    // supprime les caractères reservées
    $str = str_replace('!', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('×', '', $str);
    $str = str_replace(' ', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);

    return $str;
}

function enregistrerImageJpg($produit)
{
    $_url = str_replace('//'.$produit['nom'], '/'.$produit['nom'], $produit['site'] . '/' . $produit['nom']);

    $image = open_image($_url);
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
        $new_w=isset($_GET['w'])?$_GET['w']:600;
        $new_h=isset($_GET['h'])?$_GET['h']:600;
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

    imagejpeg($im2, PHOTO_EN_COUR . $produit['cip13'] . ".jpg");
}

function open_image ($file)
{
    //detect type and process accordinally
    $im=false;
    if($size=image_attributs($file)){
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
        }
    }

    return $im;
}

function variablenumerique($data)
{
    if(empty($data) OR preg_match('#[a-zA-Z]#', $data)){
        return true;
    }

    return false;
}

function variabletexte($data)
{
    if(empty($data)){
        return true;
    }

    return false;
}

function numerique($data)
{
    $datatest = intval($data);
    if(strlen($data) != strlen($datatest)){
        exit("ERROR $data != $datatest");
    }

    if(empty($datatest) OR $datatest < 1 OR strlen($data) != strlen($datatest) ){
        return true;
    }

    return false;
}

function codeceido($data)
{
    if(empty($data) OR preg_match('#^(0_)#', $data) OR preg_match('#^[a-zA-Z]#', $data)){
        return true;
    }
    
    return false;
}