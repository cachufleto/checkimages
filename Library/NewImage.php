<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 08/07/2016
 * Time: 10:47
 */

namespace App;

require MOD . 'NewImages.php';
use Model\NewImages;

require LIB . 'image.php';
use App\Image;

class NewImage extends NewImages
{
    var $link = '';
    var $_lib = [];
    var $mimes = [];
    var $session = '';
    var $page = '';
    var $listeRecherche = 'Recherche ';
    var $type = 0;
    var $countListeCIP = 0;
    var $selectCIP = '';

    public function __construct()
    {
        $this->page = $_GET['page'];
        $this->_lib = file_contents_libelles();
        $this->mimes = file_contents_mimes();
        $this->session = ($_SESSION['actif']);
        $this->type = ($this->session == 'Medicaments')? 1 : 2;
    }

    public function nettoyerBDD(){
        $liste = $this->getImagesLocal();
        foreach($liste as $key=>$image){
            $supprimer = true;
            // on verifie si l'image à était traité
            if (!empty($image['cip13']) and file_exists(SITE . 'photos/production/original/'.$image['cip13'].'.jpg')){
                $supprimer = false;
            } else if (!empty($image['cip13']) and file_exists(SITE . 'photos/en_cours/'.$image['cip13'].'.jpg')){
                $supprimer = false;
            } else if (file_exists(SITE . $image['site'].'/'.$image['nom'])){
                $supprimer = false;
            }
            
            if($supprimer){
                if(preg_match('#^photo#', $image['site'])){
                    $this->deleteUpdate($image['id']);
                } else {
                    $this->updateUpdate($image['id']);
                }
                $this->deleteUpdateProduit($image['id']);

            } else if(!empty($image['cip13']) AND empty($produit = $this->getProduitCIP($image['cip13']))){
                $this->setProduit($image['id'], $image['cip13'], $this->type);
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
                            $name = str_replace('GoogleChrome', '', $name);
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
                }
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

        if (!empty($cip13) and $this->parapharmacie->getUpdateCount($cip13)){
            $id = $this->setImageLocal($repertoire, $nom, $cip13);
            $this->setProduit($id, $cip13, 2);
            $this->uploadImageJpg(['site'=>$repertoire, 'nom'=>$nom, 'cip13'=>$cip13]);
        } else if (!empty($cip13) and $this->medicament->getUpdateCount($cip13)){
            $id = $this->setImageLocal($repertoire, $nom, $cip13);
            $this->setProduit($id, $cip13, 1);
            $this->uploadImageJpg(['site'=>$repertoire, 'nom'=>$nom, 'cip13'=>$cip13]);
        } else {
            $id = $this->setImageLocal($repertoire, $nom);
        }

        $this->listeLocal['id'] .= ", ".$id;
        $this->listeLocal['nom'] .= ", '$nom'";
    }

    public function listeChangements()
    {
        $liste = $this->produits->getProduits($this->outCIP());
        foreach ($liste as $key=>$produit){
            if($mode = $this->checkProduits($produit)){
                $this->produits->updateProduitEtat($produit['id_produit'], $mode);
            }
        }
        return;
    }

    /*
     * function qui verifie le premier état des produits
     * passage en hors ligne ou en ligne selon les critaires specifiées
     */

    public function checkProduits($produit)
    {
        $img = $this->produits->checkImage($produit['cip13']);
        $mod = ['ko', 'ok'];
        $msg = $ko_msg = $i_msg = '';
        if($produit['produit_actif'] == 'o'){
            if(($img['image'] != 1 OR $img['vignette'] != 1)){
                $msg = 'images';
            }
            $msg .= (!empty($msg)? ', ' : '' ) . $this->testChampsObligatoires($produit);

        } else if($produit['produit_actif'] == 'i'){
            if(($img['image'] == 1 AND $img['vignette'] == 1)){
                $i_msg = 'Images OK. ';
                $msg .= (!empty($msg)? ', ' : '' ) .  $this->testChampsObligatoires($produit);
            }
        }

        if(!empty($msg)) {
            // passage hors ligne
            $this->produitModification($produit, 1, 'Manque: '.$msg);
            return 'i';
        } else if(!empty($i_msg)){
            if(empty($ko_msg)) {
                // passage en ligne
                $this->produitModification($produit, 2, $i_msg);
                return 'o';
            } else {
                return 'i';
            }
        }
        return false;
    }

    public function testChampsObligatoires($produit)
    {
        $msg = '';

        foreach ($this->champsObligatoires as $champ => $function){
            if($function == 'codeceido'){
                if($function($produit[$champ])){
                    if($this->controleIDFamilles($produit)){
                        $msg .= (!empty($msg)? ', ' : '' ) . $this->_lib['champ'][$champ];
                    }
                } else {
                    $this->controleFamilles($produit);
                }
            } else if($function($produit[$champ])){
                $msg .= (!empty($msg)? ', ' : '' ) . $this->_lib['champ'][$champ];
            }
        }

        return $msg;
    }

    public function controleIDFamilles($produit)
    {
        if(empty($produit['id_famille'])){
            return true;
        }

        $code_int_ceido_1 = ($produit['id_famille']<10)? "0{$produit['id_famille']}_" : "{$produit['id_famille']}_";
        $code_int_ceido_1 .= !empty($produit['id_sfamille'])? (($produit['id_sfamille']<10)? "0{$produit['id_sfamille']}_" : "{$produit['id_sfamille']}_") : "0_";
        $code_int_ceido_1 .= !empty($produit['id_ssfamille'])? (($produit['id_ssfamille']<10)? "0{$produit['id_ssfamille']}_" : "{$produit['id_ssfamille']}_") : "0";
        
        $this->produits->updateCodeCeido($produit['cip13'], $code_int_ceido_1);
    }

    public function controleFamilles($produit)
    {
        $familles = explode('_',$produit['code_int_ceido_1']);
        $id_famille = isset($familles[0])? $familles[0] : $produit['code_int_ceido_1'];
        $id_sfamille = isset($familles[1])? $familles[1] : 0;
        $id_ssfamille = isset($familles[2])? $familles[2] : 0;
        
        $this->produits->updateFamilles($produit['cip13'], intval($id_famille), intval($id_sfamille), intval($id_ssfamille));
    }

    public function produitModification($produit, $etat, $msg)
    {
        $mod = $this->getProduitModification($produit['cip13']);

        if(!empty($mod)){
            $this->updateProduitModification($produit['cip13'], $etat, $this->type, $mod['message']."\t\n".$msg);
            return;
        }

        $this->setProduitModification($produit['cip13'], $etat, $this->type, $msg);
        return;
    }

    public function outCIP()
    {
        // verifications des conditions requises
        $out = $this->getProduitModificationKo($this->type);
        $outCIP = " AND cip13 NOT IN (-1";
        foreach ($out as $key=>$cip){
            $outCIP .= ",{$cip['cip13']} ";
        }
        $outCIP .= ")";
        return $outCIP;
    }

    public function listeCIP()
    {

        $selectImages = ' AND '. ( (isset($_SESSION[$this->session]['produit']) AND $_SESSION[$this->session]['produit'] == 'ko')?
            ' (image = 0 OR vignette = 0) ' : '(image = 1 AND vignette = 1)' );

        $produit = isset($_SESSION[$this->session]['produit']) ? $_SESSION[$this->session]['produit'] : '';
        $selectImages = !empty($produit)? $selectImages : '';

        $listeCIP = '';
        if($liste = $this->getCIP($this->type, $selectImages)){
            $this->countListeCIP = $liste;
            foreach ($liste as $key=>$data){
                $listeCIP .= ", '{$data['cip13']}'";
            }
        };
        $this->selectCIP = "(''$listeCIP)";
    }

    public function uploadImageJpg($produit)
    {
        if(!file_exists('photos/en_cours/' . $produit['nom'])){
            enregistrerImageJpg($produit);
        }
    }


}