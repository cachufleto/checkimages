<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08/07/2016
 * Time: 10:52
 */

namespace Model;
use App\Bdd;

class NewImages extends Bdd
{
    var $rechercheNom = '';
    var $rechercheCip = '';

    public function getImagesLocal()
    {
        $sql = "SELECT * 
                FROM images 
                ORDER BY nom ASC;";
        return $this->query($sql);
    }

    public function getImageUpload($repertoire, $nom)
    {
        $sql = "SELECT * 
                FROM images 
                WHERE site LIKE '$repertoire' 
                AND nom LIKE '$nom'
                ORDER BY nom ASC;";
        return $this->query($sql);
    }

    public function setImageLocal($link, $nom, $cip13='')
    {
        $sql = "INSERT INTO `images` (`id`, `site`, `nom`, `produit`, `upload`, `zapper`, `cip13`) 
                VALUES (NULL, '$link', '".$nom."', NULL, '0', '0', '$cip13');";
        return $this->queryInsert($sql);
    }

    public function setProduit($id, $cip13, $type=1){
        $sql = "INSERT INTO `produits` 
                  (`id_image`, `id`, `cip13`, `denomination`, `presentation`, `type`, `date_traitement`, `libelle`)
                  VALUES ($id, NULL, '$cip13', '', '', '$type', CURRENT_TIMESTAMP, '')";
        $this->queryInsert($sql);
    }

    public function getListeNewImages($listeID, $listeNom){

        $sql = "SELECT * 
                FROM images 
                WHERE id IN ($listeID)
                OR nom IN ($listeNom)
                ORDER BY nom ASC";
        return $this->query($sql);
    }
    
    public function updateUpdate($id)
    {
        $sql = "UPDATE `images` 
                set `cip13` = '' 
                WHERE `id` = $id;";
        return $this->queryUpdate($sql);
    }

    public function deleteUpdate($id)
    {
        $sql = "DELETE FROM `images` WHERE id = $id;";
        return $this->queryUpdate($sql);
    }

    public function deleteUpdateProduit($id_image)
    {
        $sql = "DELETE FROM `produits` WHERE id_image = $id_image;";
        return $this->queryUpdate($sql);
    }

    public function getProduitModification($cip13)
    {
        $sql = "SELECT * FROM `produitsmodifications`
                WHERE `cip13` = '$cip13';";

        return $this->query($sql);
    }

    public function getProduitModificationKo($type)
    {
        $sql = "SELECT `cip13` FROM `produitsmodifications`
                WHERE `etat` < 2 AND (`type` = 0 OR `type` = $type)
                LIMIT 0,10;";

        return $this->query($sql);
    }

    public function getChangementsOK($type)
    {
        $sql = "SELECT * FROM `produitsmodifications`
                WHERE `etat` < 2 AND `type` = $type;";

        return $this->query($sql);
    }

    public function updateProduitModification($cip13, $etat, $type, $msg)
    {
        $sql = "UPDATE `produitsmodifications` 
                set `etat` = $etat, `type` = $type, `message` = '$msg' 
                WHERE `cip13` = '$cip13';";
        return $this->queryUpdate($sql);
    }

    public function setProduitModification($cip13, $etat, $type, $msg)
    {
        $sql = "INSERT INTO `produitsmodifications` 
                (`cip13`, `etat`, `type`, `message`) VALUES ('$cip13', $etat, $type, '$msg');";
        return $this->queryInsert($sql);
    }

    public function getCIP($type, $selectImages)
    {
        $sql = "SELECT cip13 FROM control_images WHERE type = $type $selectImages;";
        return $this->query($sql);
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
}