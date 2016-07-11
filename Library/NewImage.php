<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08/07/2016
 * Time: 10:47
 */

namespace App;

require MOD . 'NewImages.php';
use Model\NewImages;

class NewImage extends NewImages
{
    var $link = '';
    var $_lib = [];
    var $mimes = [];
    var $page = '';
    var $listeRecherche = 'Recherche ';

    public function __construct()
    {
        $this->page = $_GET['page'];
        include CONF . 'libelles.php';
        $this->_lib = $_libelle;
        include CONF . 'mimes.php';
        $this->mimes = $mimes;
        //var_dump($this);
    }


    public function netoillerBDD(){
        $liste = $this->getImagesLocal();
        foreach($liste as $key=>$image){
            $supprimer = true;
            // on verifie si l'image à était traité
            if (!empty($image['cip13']) and file_exists(SITE . 'photos/en_cours/'.$image['cip13'].'.jpg')){
                $supprimer = false;
            }
            // on verifie si l'image d'origine existe
            if (file_exists(SITE . $image['site'].'/'.$image['nom'])){
                $supprimer = false;
            }
            if($supprimer){
                $this->deleteUdate($image['id']);
                $this->deleteUdateProduit($image['id']);
            }
        }

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

                        if ( $extention = $this->typeMime($test)) {
                            // injection en base de données
                            $name = utf8_encode(basename($test));
                            $name = remove_accents($name);
                            if($name != basename($test) ) {
                                copy($test, dirname($test) . '/'. $name);
                                unlink($test);
                            }

                            $this->uploadImageExist(str_replace(SITE, '', dirname($test)), $name, $extention);

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
        if(preg_match('#^image#', $typeFile)){

            foreach ($this->mimes as $type => $motif){
                if(preg_match("#$type#", $typeFile)){
                    return true;
                };
            }
            
        }

        return false;
    }

    public function uploadImageExist($repertoire, $nom, $extention = '')
    {
        $cip13 = '';
        foreach ($this->mimes as $type => $motif){
            if(preg_match("#$type$#", $nom)){
                $cip13 = testCIP13(str_replace(".$type@", '', $nom.'@'));
            }
        }
        
        if($images = $this->getImageUpload($repertoire, $nom))
        {
            return false;
        }

        $this->pharamacie->zapper =
            $this->medicament->zapper =
                " >= 0 ";
        $this->pharamacie->rechercheCip =
            $this->medicament->rechercheCip =
                " AND cip13 LIKE '$cip13' ";

        if (!empty($cip13) and $this->pharamacie->getCount()){
            $id = $this->setImageLocal($repertoire, $nom, $cip13);
            $this->setProduit($id, $cip13, $type=2);
        } else if (!empty($cip13) and $this->medicament->getCount()){
            $id = $this->setImageLocal($repertoire, $nom, $cip13);
            $this->setProduit($id, $cip13);
        } else {
            $id = $this->setImageLocal($repertoire, $nom);
        }

        $this->listeLocal['id'] .= ", ".$id;
        $this->listeLocal['nom'] .= ", '$nom'";
    }

}