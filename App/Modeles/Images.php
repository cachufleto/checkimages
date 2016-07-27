<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 13:20
 */

namespace Model;
use App\Bdd;

class Images extends Bdd
{
    public function getCountR()
    {
        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                AND i.id = p.id_image 
                {$this->moteur->RechercheImage};";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCount()
    {
        $sql = "SELECT count(*) as num
                FROM images i
                WHERE i.zapper  {$this->moteur->Zapper}
                {$this->moteur->imageCip13}
                {$this->moteur->imageNom};";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountKoR()
    {

        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                AND i.id NOT IN  (SELECT id_image FROM produits)
                {$this->moteur->RechercheImage};";
        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountKo()
    {

        $sql = "SELECT count(*) as num
                FROM images i
                WHERE  i.zapper  {$this->moteur->Zapper}
                {$this->moteur->imageCip13}
                {$this->moteur->imageNom}
                AND i.id NOT IN  (SELECT id_image FROM produits);";
        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountOkR()
    {
        
        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                AND i.id = p.id_image 
                AND i.upload = 0
                {$this->moteur->RechercheImage};";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountOk()
    {

        $sql = "SELECT count(*) as num
                FROM images i
                WHERE  i.zapper  {$this->moteur->Zapper}
                {$this->moteur->imageCip13}
                {$this->moteur->imageNom}
                AND i.upload = 1;";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getOkR($debut, $limit)
    {
        $sql = "SELECT 
                    i.id, i.site, i.nom, i.produit, i.upload, i.zapper, i.cip13, 
                    p.id_image, p.denomination, p.presentation, 
                    p.type, p.date_traitement, p.libelle
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                AND i.id = p.id_image 
                {$this->moteur->RechercheImage}
                ORDER BY p.denomination ASC, i.nom ASC
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }
    
    public function getOk($debut, $limit)
    {
        $sql = "SELECT 
                    i.id, i.site, i.nom, i.produit, i.upload, i.zapper, i.cip13, 
                    p.id_image, p.denomination, p.presentation, 
                    p.type, p.date_traitement, p.libelle
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                {$this->moteur->RechercheImage}
                AND i.id = p.id_image
                AND i.upload = 1
                ORDER BY p.denomination ASC, i.nom ASC
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function getKoR($debut, $limit)
    {
        $sql = "SELECT 
                    i.id, i.site, i.nom, i.produit, i.upload, i.zapper, i.cip13, 
                    p.id_image, p.denomination, p.presentation, 
                    p.type, p.date_traitement, p.libelle
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                {$this->moteur->imageCip13}
                {$this->moteur->imageNom}
                AND i.id = p.id_image
                AND i.upload = 0 
                ORDER BY p.denomination ASC, i.nom ASC
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function getKo($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i
                WHERE  i.zapper  {$this->moteur->Zapper}
                {$this->moteur->imageCip13}
                {$this->moteur->imageNom}
                AND i.upload = 0  
                ORDER BY i.nom ASC
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function getR($debut, $limit)
    {
        $sql = "SELECT 
                    i.id, i.site, i.nom, i.produit, i.upload, i.zapper, i.cip13, 
                    p.id_image, p.denomination, p.presentation, 
                    p.type, p.date_traitement, p.libelle
                FROM images i, produits p
                WHERE  i.zapper  {$this->moteur->Zapper}
                {$this->moteur->RechercheImage}
                AND i.id = p.id_image 
                ORDER BY p.denomination ASC, i.nom ASC;";

        return $this->query($sql);
    }

    public function get($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i
                WHERE i.zapper  {$this->moteur->Zapper}
                {$this->moteur->imageCip13}
                {$this->moteur->imageNom}
                ORDER BY i.nom ASC
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function getProduit($id){
        $sql = "SELECT 
                    i.id, i.site, i.nom, i.produit, i.upload, i.zapper, i.cip13, 
                    p.id_image, p.denomination, p.presentation, 
                    p.type, p.date_traitement, p.libelle, p.id as id_produit
                FROM images i
                LEFT JOIN produits p ON i.id = p.id_image
                WHERE i.id = $id
                LIMIT 0, 1;";
        $produit = $this->query($sql);
        return (!empty($produit[0]))? $produit[0] : false;
    }

    public function getProduitCip($cip13, $id = -1){
        $sql = "SELECT 
                    i.id, i.site, i.nom, i.produit, i.upload, i.zapper, i.cip13, 
                    p.id_image, p.denomination, p.presentation, 
                    p.type, p.date_traitement, p.libelle
                FROM images i
                LEFT JOIN produits p ON i.id = p.id_image
                WHERE i.id != $id AND i.cip13 = '$cip13'
                LIMIT 0, 1;";
        return $this->query($sql);
    }

    public function getProduitCipOK(){
        $sql = "SELECT cip13
                FROM produits
                WHERE 1;";
        return $this->query($sql);
    }

    public function setProduit($id, $cip13, $type=1, $denomination='', $presentation='', $libelle = ''){
        $sql = "INSERT INTO `produits` 
                  (`id_image`, `id`, `cip13`, `denomination`, `presentation`, `type`, `date_traitement`, `libelle`)
                  VALUES ($id, NULL, '$cip13', '$denomination', '$presentation', '$type', CURRENT_TIMESTAMP, '$libelle');";
        $this->queryInsert($sql);
    }

    public function updateZapper($id)
    {
        $sql = "UPDATE `images` SET `Zapper` = '1' WHERE `images`.`id` = $id;";
        $this->queryUpdate($sql);
        return true;
    }

    public function updateConserver($id)
    {
        $sql = "UPDATE `images` SET `Zapper` = '2' WHERE `images`.`id` = $id;";
        $this->queryUpdate($sql);
        return true;
    }

    public function updateRetirer($id)
    {
        $sql = "UPDATE `images` SET `Zapper` = '0' WHERE `images`.`id` = $id;";
        $this->queryUpdate($sql);
        return true;
    }

    public function updateProduit($id, $cip13, $denomination='', $presentation='', $type=1, $libelle = '')
    {
        $sql = "UPDATE `produits` 
                    SET `cip13` = '$cip13', `denomination` = '$denomination', 
                        `presentation` = '$presentation', `type` = '$type', `libelle` = '$libelle' 
                    WHERE id_image = $id;";

        $this->queryUpdate($sql);
    }

    public function updateImage($id, $cip13)
    {
        $sql = "UPDATE `images` 
                    SET `cip13` = '$cip13'
                    WHERE id = $id;";
        $this->queryUpdate($sql);
    }

    public function updateImageURL($id, $nom)
    {
        $sql = "UPDATE `images` 
                    SET cip13 = '$nom', upload = 1
                    WHERE id = $id;";

        $this->queryUpdate($sql);
    }

    /*
     * Utilisé par l'obejt externe
     * */
    public function getImage($id)
    {
        $sql = "SELECT * FROM images WHERE id = $id;";
        return $this->query($sql);
    }
    
    public function deleteUdate($id)
    {
        $sql = "DELETE FROM `images` WHERE id = $id;";
        return $this->queryUpdate($sql);
    }

    public function deleteUdateProduit($id)
    {
        $sql = "DELETE FROM `produits` WHERE id_image = $id;";
        return $this->queryUpdate($sql);
    }

    public function updateImageType($cip13, $type = 0)
    {
        $sql = "UPDATE `control_images` 
                set `type` = $type 
                WHERE `cip13` = '$cip13';";
        $this->queryUpdate($sql);
    }

}