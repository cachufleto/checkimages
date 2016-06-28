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

                    if (typeMime($test)) {
                        $liste .= '<img src="'.(str_replace(__DIR__.'/', '', $test)).'">' . "\n";
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

$dir = __DIR__ . '/photos/traitement';
//$liste = 'LISTE:<br>';
listerReperoires($dir, $liste);
header('content-type image/jpeg');
echo $liste;
