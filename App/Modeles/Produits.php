<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/06/2016
 * Time: 13:20
 */

namespace Model;
use App\Bdd;

class Produits extends Bdd
{

    public function getCount()
    {

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE 1 
                ".$this->criterMoteurRecherche()."
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille ";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountKo()
    {

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille
                AND p.cip13 IN  {$this->selectCIP}
                ".$this->criterMoteurRecherche()."";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountOk()
    {
        
        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                AND p.cip13 IN {$this->selectCIP} 
                ".$this->criterMoteurRecherche()."";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getOk($debut, $limit)
    {
        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille,
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille
                AND p.cip13 IN {$this->selectCIP} 
                ".$this->criterMoteurRecherche()."
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }
    
    public function getKo($debut, $limit)
    {
        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                AND p.cip13 IN  {$this->selectCIP}
                ".$this->criterMoteurRecherche()."
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function get($debut, $limit)
    {
        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE 1 
                ".$this->criterMoteurRecherche()."
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getProduit($id)
    {
        $sql = "SELECT p.*, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.id_produit = $id
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille";

        return $this->query($sql);
    }

    public function getLaboratoires()
    {
        $sql = "SELECT DISTINCT l.id_laboratoire as id, l.designation 
                FROM laboratoires l, produits p 
                WHERE l.id_laboratoire = p.id_laboratoire 
                AND p.cip13 IN {$this->selectCIP}
                ".$this->criterMoteurRecherche()."
                ORDER BY l.designation ASC";
        return $this->query($sql);
    }

    public function getFamilles()
    {
        $sql = "SELECT DISTINCT f.id_famille as id, f.designation as nom
                FROM familles f, produits p 
                WHERE f.id_famille = p.id_famille 
                AND p.cip13 IN {$this->selectCIP}
                ".$this->criterMoteurRecherche()."
                ORDER BY F.designation ASC";
        return $this->query($sql);
    }

    public function getProduits($outCIP = '')
    {
        $sql = "SELECT * FROM produits WHERE 1 $outCIP;";
        return $this->query($sql);
    }
    
    public function updateProduitEtat($id_produit, $produit_actif)
    {
        $sql = "UPDATE `produits` 
                set `produit_actif` = '$produit_actif' 
                WHERE `id_produit` = $id_produit;";
        return $this->queryUpdate($sql);
    }


}