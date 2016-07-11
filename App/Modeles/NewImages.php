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
                WHERE site LIKE 'photos/traitement%' 
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
    
    public function deleteUdate($id)
    {
        $sql = "DELETE FROM `images` WHERE id = $id;";
        return $this->queryUpdate($sql);
    }

    public function deleteUdateProduit($id)
    {
        $sql = "DELETE FROM `produits` WHERE id = $id;";
        return $this->queryUpdate($sql);
    }


}