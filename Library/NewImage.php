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
    var $type = 0;

    public function __construct()
    {
        $this->page = $_GET['page'];
        $this->type = ($this->page == 'medicament')? 1 : 2;
        $this->_lib = file_contents_libelles();
        $this->mimes = file_contents_mimes();
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

        $this->parapharmacie->zapper =
            $this->medicament->zapper =
                " >= 0 ";
        $this->parapharmacie->rechercheCip =
            $this->medicament->rechercheCip =
                " AND cip13 LIKE '$cip13' ";

        if (!empty($cip13) and $this->parapharmacie->getCount()){
            $id = $this->setImageLocal($repertoire, $nom, $cip13);
            $this->setProduit($id, $cip13, 2);
        } else if (!empty($cip13) and $this->medicament->getCount()){
            $id = $this->setImageLocal($repertoire, $nom, $cip13);
            $this->setProduit($id, $cip13, 1);
        } else {
            $id = $this->setImageLocal($repertoire, $nom);
        }

        $this->listeLocal['id'] .= ", ".$id;
        $this->listeLocal['nom'] .= ", '$nom'";
    }

    public function listeChangements($liste, $produits)
    {
        $_listeMod = [];
        $_listeMod['ko'] = $_listeMod['ok'] = [];
        foreach ($liste as $key=>$produit){
            $data = $this->checkProduits($produit, $produits->checkImage($produit['cip13']));
            if(isset($data['ko'])){
                $produits->updateProduitEtat($produit['id_produit'], 'i');
            }
            if(isset($data['ok'])){
                $produits->updateProduitEtat($produit['id_produit'], 'o');
            }
        }
        unset($liste);
        return;
    }
    
    /*
     * function qui verifie le premier état des produits
     * passage en hors ligne ou en ligne selon les critaires specifiées
     */

    public function checkProduits($produit, $img)
    {
        $mod = ['ko', 'ok'];
        $msg = $ko_msg = $i_msg = '';
        if($produit['produit_actif'] == 'o'){
            if(($img['image'] != 1 OR $img['vignette'] != 1)){
                $msg = 'Manque images. ';
            } else {
                // on verifie les champs obligatoires
                foreach ($this->champsObligatoires as $champ){
                    if(empty($produit[$champ])){
                        $msg .= "Manque $champ. ";
                    }
                }
            }
        } else if($produit['produit_actif'] == 'i'){
            if(($img['image'] == 1 AND $img['vignette'] == 1)){
                $i_msg = 'Images OK. ';
                // on verifie les champs obligatoires
                foreach ($this->champsObligatoires as $champ){
                    if(empty($produit[$champ])){
                        $ko_msg .= "Manque $champ. ";
                    }
                }
            }
        }

        if(!empty($msg)) {
            // passage hors ligne
            $this->produitModification($produit, 1, $msg);
            $mod['ko'] = 1;
        } else if(!empty($i_msg)){
            if(empty($ko_msg)) {
                // passage en ligne
                $this->produitModification($produit, 2, $i_msg);
                $mod['ok'] = 1;
            } else {
                $mod['ko'] = 1;
            }
        }

        return $mod;
    }

    public function produitModification($produit, $etat, $msg)
    {
        $mod = $this->getProduitModification($produit['cip13']);

        if(!empty($mod)){
            $this->updateProduitModification($produit['cip13'], $etat, $this->type, $msg);
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

    public function getImage($nom)
    {
        $sql = "SELECT * FROM control_images WHERE cip13 LIKE '$nom'";
        $img = $this->query($sql);
        return !empty($img)? $img[0] : false;
    }

    public function setImage($cip13, $grande = 0, $vignette = 0, $type=0)
    {
        $sql = "INSERT INTO `control_images` (`cip13`, `image`, `vignette`, `type`) 
                VALUES ('$cip13', $grande, $vignette, $type);";
        $this->queryInsert($sql);
    }

    public function updateImage($cip13, $grande = 0, $vignette = 0, $type = 0)
    {
        $sql = "UPDATE `control_images` 
                set `image` = $grande, `vignette` = $vignette, `type` = $type 
                WHERE `cip13` = '$cip13';";
        $this->queryUpdate($sql);
    }

    public function listeCIP()
    {
        $liste = $this->getCIP($this->type);
        $listeCIP = '';
        foreach ($liste as $key=>$data){
            $listeCIP .= ", {$data['cip13']}";
        }
        return "(-1$listeCIP)";
    }
}