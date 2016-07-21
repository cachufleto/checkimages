<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 13:20
 */

namespace Model;
use App\Bdd;

class Produits extends Bdd
{

    public function getCount()
    {

        $sql = "SELECT 
                    count(*) as num
                FROM
                    produits p
                WHERE 
                    1 
                    {$this->moteurRecherche};";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountKo()
    {

        $sql = "SELECT 
                    count(*) as num
                FROM
                    produits p
                WHERE 
                    p.cip13 IN {$this->selectCIP} 
                    {$this->moteurRecherche};";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getCountOk()
    {
        
        $sql = "SELECT 
                    count(*) as num
                FROM
                    produits p
                WHERE 
                    p.cip13 IN {$this->selectCIP} 
                    {$this->moteurRecherche};";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }

    public function getOk($debut, $limit)
    {
        $sql = "SELECT
                    p.produit_actif,
                    p.id_produit,
                    p.cip13,
                    p.libelle_ospharm,
                    f.designation AS famille,
                    s.designation AS sFamille,
                    ss.designation AS ssFamille,
                    l.designation AS laboratoire
                FROM
                    produits p
                LEFT JOIN
                    familles AS f ON p.id_famille = f.id_famille
                LEFT JOIN
                    s_familles AS s ON p.id_sfamille = s.id_sfamille
                LEFT JOIN
                    ss_famille AS ss ON p.id_ssfamille = ss.id_ssfamille
                LEFT JOIN
                    laboratoires AS l ON p.id_laboratoire = l.id_laboratoire
                WHERE 
                    p.cip13 IN {$this->selectCIP} 
                    {$this->moteurRecherche}
                ORDER BY l.designation ASC, p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }
    
    public function getKo($debut, $limit)
    {
        $sql = "SELECT
                  p.produit_actif,
                  p.id_produit,
                  p.cip13,
                  p.libelle_ospharm,
                  f.designation AS famille,
                  s.designation AS sFamille,
                  ss.designation AS ssFamille,
                  l.designation AS laboratoire
                FROM
                  produits p
                LEFT JOIN
                  familles AS f ON p.id_famille = f.id_famille
                LEFT JOIN
                  s_familles AS s ON p.id_sfamille = s.id_sfamille
                LEFT JOIN
                  ss_famille AS ss ON p.id_ssfamille = ss.id_ssfamille
                LEFT JOIN
                  laboratoires AS l ON p.id_laboratoire = l.id_laboratoire
                WHERE
                  p.cip13 IN {$this->selectCIP}
                  {$this->moteurRecherche}
                ORDER BY
                  l.designation ASC,
                  p.libelle_ospharm ASC
                LIMIT $debut, $limit;";

        return $this->query($sql);
    }

    public function get($debut, $limit)
    {
        $sql = "SELECT
                  p.cip13,
                  p.id_produit,
                  p.produit_actif,
                  p.libelle_ospharm,
                  f.designation AS famille,
                  s.designation AS sFamille,
                  ss.designation AS ssFamille,
                  l.designation AS laboratoire
                FROM
                  produits p
                LEFT JOIN
                  familles AS f ON p.id_famille = f.id_famille
                LEFT JOIN
                  s_familles AS s ON p.id_sfamille = s.id_sfamille
                LEFT JOIN
                  ss_famille AS ss ON p.id_ssfamille = ss.id_ssfamille
                LEFT JOIN
                  laboratoires AS l ON p.id_laboratoire = l.id_laboratoire
                WHERE
                  1
                  {$this->moteurRecherche}
                ORDER BY
                  l.designation ASC,
                  p.libelle_ospharm ASC 
                LIMIT $debut, $limit";

        return $this->query($sql);
    }

    public function getProduit($id)
    {
        $sql = "SELECT
                  p.*,
                  f.designation AS famille,
                  s.designation AS sFamille,
                  ss.designation AS ssFamille,
                  l.designation AS laboratoire
                FROM
                  produits p
                LEFT JOIN
                  familles AS f ON p.id_famille = f.id_famille
                LEFT JOIN
                  s_familles AS s ON p.id_sfamille = s.id_sfamille
                LEFT JOIN
                  ss_famille AS ss ON p.id_ssfamille = ss.id_ssfamille
                LEFT JOIN
                  laboratoires AS l ON p.id_laboratoire = l.id_laboratoire
                WHERE
                  p.id_produit = $id";

        return $this->query($sql);
    }

    public function getUpdateCount($cip13)
    {

        $sql = "SELECT count(*) as num
                FROM produits
                WHERE cip13 = '$cip13'";

        $num = $this->query($sql);

        return ($num AND $num[0]['num'] > 0)? true : false;
    }

    public function getLaboratoires()
    {
        $sql = "SELECT DISTINCT l.id_laboratoire as id, l.designation 
                FROM laboratoires l, produits p 
                WHERE l.id_laboratoire = p.id_laboratoire 
                ".$this->criterMoteurRechercheLaboratoires()."
                ORDER BY l.designation ASC";
        return $this->query($sql);
    }

    public function getFamilles()
    {
        $sql = "SELECT DISTINCT f.id_famille as id, f.designation as nom
                FROM familles f, produits p 
                WHERE f.id_famille = p.id_famille 
                ".$this->criterMoteurRechercheFamilles()."
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