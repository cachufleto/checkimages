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

    public  function  getCountR()
    {
        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE i.id = p.id_image ".
                criterMoteurRechercheImages($this->page);

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCount()
    {
        $sql = "SELECT count(*) as num
                FROM images";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountKoR()
    {

        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE i.id NOT IN  (SELECT id_image FROM produits) ".
                criterMoteurRechercheImages($this->page);
        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountKo()
    {

        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE i.id NOT IN  (SELECT id_image FROM produits) ".
                criterMoteurRechercheImages($this->page);
        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountOkR()
    {
        
        $sql = "SELECT count(*) as num
                FROM images i, produits p
                WHERE i.id = p.id_image 
                AND i.upload = 0".
                criterMoteurRechercheImages($this->page);

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public  function  getCountOk()
    {

        $sql = "SELECT count(*) as num
                FROM images i
                WHERE i.upload = 1 ";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getOkR($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE i.id = p.id_image " .
                criterMoteurRechercheImages($this->page) . "
                ORDER BY p.denomination ASC,  p.libelle ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }
    
    public function getOk($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE i.upload = 1
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getKoR($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE i.id = p.id_image
                AND i.upload = 0 " .
                criterMoteurRechercheImages($this->page) . "
                ORDER BY p.libelle ASC,  p.denomination ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getKo($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i
                WHERE i.upload = 0  
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getR($debut, $limit)
    {
        $sql = "SELECT *
                FROM images i, produits p
                WHERE i.id = p.id_image ".
                criterMoteurRechercheImages($this->page);

        return $this->query($sql);
    }

    public function get($debut, $limit)
    {
        $sql = "SELECT *
                FROM images
                WHERE 1
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function getImage($id){
        $sql = "SELECT * FROM produits WHERE id_image = $id LIMIT 0, 1";
        return $this->query($sql);
    }

    public function setImage($id_image, $cip13){
        $sql = "INSERT INTO produits (id_image, cip13) VALUES ($id_image, '$cip13');";
        $this->queryInsert($sql);
    }

}