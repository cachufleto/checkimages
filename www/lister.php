<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20/06/2016
 * Time: 13:10
 */
function typeMime($file){
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
function listerReperoires($dir, &$liste){
// Ouvre un dossier bien connu, et liste tous les fichiers
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if($file != '.' AND $file != '..'){
                    $test = $dir . '/' . $file;
                    $type = filetype($test);
                    if($type == 'dir'){
                        listerReperoires($test, $liste);
                    }
                        $liste .= (typeMime($test))? '<img src="'.(str_replace(__DIR__.'/', '', $test)).'">' . "\n" : "";


                }
            }
            closedir($dh);
        }
    }
}

$dir = __DIR__ . '/photos';
$liste = 'LISTE:<br>';
listerReperoires($dir, $liste);
// Création d'une image vide et ajout d'un texte
// $im = imagecreatetruecolor(120, 20);
//$text_color = imagecolorallocate($im, 233, 14, 91);
// imagestring($im, 1, 5, 5,  'Un texte simple', $text_color);
// Définit le contenu de l'en-tête - dans ce cas, image/vnd.wap.wbmp
// Hint: see image_type_to_mime_type() for content-types
// header('Content-Type: image/vnd.wap.wbmp');
header('content-type image/jpeg');
/*// Affichage de l'image
//imagejpeg($im);
// echo image_type_to_mime_type ( int $imagetype )
//header("Content-type: " . image_type_to_mime_type(IMAGETYPE_JPEG));*/
$filename = 'S:/httpd/developpement/testcheck/www/photos/Cache/f_00290e';
/*$im = imagecreatefromjpeg ( $filename );
echo '<img src="'.(str_replace('S:/httpd/developpement/testcheck/www/', '', $filename)).'" width="72" height="72">';
// Libération de la mémoire
imagedestroy($im);
*/
$finfo = finfo_open(FILEINFO_MIME); // Retourne le type mime

if (!$finfo) {
    echo "Échec de l'ouverture de la base de données fileinfo";
    exit();
}

/* Récupère le mime-type d'un fichier spécifique */
//$filename = "/usr/local/something.txt";
echo finfo_file($finfo, $filename);

/* Fermeture de la connexion */
finfo_close($finfo);
echo $liste;
