<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 13:20
 */

namespace Model;
use App\Bdd;

class Images extends Bdd
{
    var $rechercheNom = '';
    public  function  getCountR()
    {
        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id = p.id_image ".
                $this->criterMoteurRecherche();

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCount()
    {
        $sql = "SELECT count(*) as num
                FROM images i
                WHERE i.zaper = {$this->zaper}
                {$this->rechercheNom}";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountKoR()
    {

        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id NOT IN  (SELECT id_image FROM produits) ".
                $this->criterMoteurRecherche();
        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountKo()
    {

        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id NOT IN  (SELECT id_image FROM produits) ".
                $this->criterMoteurRecherche();
        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountOkR()
    {
        
        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id = p.id_image 
                AND i.upload = 0".
                $this->criterMoteurRecherche();

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountOk()
    {

        $sql = "SELECT count(*) as num
                FROM images i
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.upload = 1 ";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getOkR($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id = p.id_image " .
                $this->criterMoteurRecherche() . "
                ORDER BY p.denomination ASC,  p.libelle ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }
    
    public function getOk($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.upload = 1
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getKoR($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id = p.id_image
                AND i.upload = 0 " .
                $this->criterMoteurRecherche() . "
                ORDER BY p.libelle ASC,  p.denomination ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getKo($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.upload = 0  
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getR($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE  i.zaper = {$this->zaper}
                {$this->rechercheNom}
                AND i.id = p.id_image ".
                $this->criterMoteurRecherche();

        return $this->query($sql);
    }

    public function get($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i
                WHERE i.zaper = {$this->zaper}
                {$this->rechercheNom}
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function getProduit($id){
        $sql = "SELECT * FROM produits WHERE id_image = $id LIMIT 0, 1";
        return $this->query($sql);
    }

    public function setProduit($id, $cip13, $denomination='', $presentation='', $type=1, $libelle = ''){
        $sql = "INSERT INTO `produits` 
                  (`id_image`, `id`, `cip13`, `denomination`, `presentation`, `type`, `date_traitement`, `libelle`)
                  VALUES ($id, NULL, '$cip13', '$denomination', '$presentation', '$type', CURRENT_TIMESTAMP, '$libelle')";
        $this->queryInsert($sql);
    }

    public function updateZaper($id)
    {
        $sql = "UPDATE `images` SET `zaper` = '1' WHERE `images`.`id` = $id;";
        $this->queryUpdate($sql);
        return true;
    }

    public function updateConserver($id)
    {
        $sql = "UPDATE `images` SET `zaper` = '2' WHERE `images`.`id` = $id;";
        $this->queryUpdate($sql);
        return true;
    }

    public function updateRetirer($id)
    {
        $sql = "UPDATE `images` SET `zaper` = '0' WHERE `images`.`id` = $id;";
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
                    SET `cip13` = '$cip13', `zaper` = '2'
                    WHERE id = $id;";
        $this->queryUpdate($sql);
    }

}