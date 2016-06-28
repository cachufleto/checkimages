<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 24/06/2016
 * Time: 11:56
 */
// actual script begins here
$type=false;
function open_image ($file) {
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

$url = isset($_GET['url'])? $_GET['url'] : '';
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($url))) {
    // send the last mod time of the file back
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($url)).' GMT', true, 304); //is it cached?
} else if(!empty($url)){

    $image = open_image($url);

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
        echo 'blur';
        $lv=$_GET['blur'];
        for($i=0; $i<$lv;$i++){
            $matrix=array(array(1,1,1),array(1,1,1),array(1,1,1));
            $divisor = 9;
            $offset = 0;
            imageconvolution($im2, $matrix, $divisor, $offset);
        }
    }
    if(isset($_GET['sharpen'])){
        echo 'sharpen';
        $lv=$_GET['sharpen'];
        for($i=0; $i<$lv;$i++){
            $matrix = array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1));
            $divisor = 8;
            $offset = 0;
            imageconvolution($im2, $matrix, $divisor, $offset);
        }
    }

    imagejpeg($im2, 'testIMAGE.jpg');
    echo "<img style=\"-webkit-user-select: none\" src=\"http://localhost/testimport/testIMAGE.jpg\">";
    exit('JODER');


}

