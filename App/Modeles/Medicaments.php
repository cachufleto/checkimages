<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 13:20
 */

namespace Model;
use App\Bdd;

class Medicaments extends Bdd
{

    /*public function getCount()
    {

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE 1 " .
                criterMoteurRecherche($this->page) . "
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille ";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }*/

    /*public function getCountKo()
    {

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 IN  {$this->selectCIP}
                ".criterMoteurRecherche($this->page)."
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }*/

    /*public function getCountOk()
    {
        
        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 IN {$this->selectCIP}
                ".criterMoteurRecherche($this->page)."
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille ";

        $num = $this->query($sql);

        return ($num)? $num[0]['num'] : 0;
    }*/

    /*public function getOk($debut, $limit)
    {
        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille,
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 IN {$this->selectCIP}
                ".criterMoteurRecherche($this->page)."
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }*/
    
    /*public function getKo($debut, $limit)
    {
        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 IN  {$this->selectCIP}
                ".criterMoteurRecherche($this->page)."
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }*/

    /*public function get($debut, $limit)
    {
        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE 1 
                ".criterMoteurRecherche($this->page)."
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $debut, $limit";

        return $this->query($sql);
    }*/

    /*public function getLaboratoires()
    {
        $sql = "SELECT DISTINCT l.id_laboratoire as id, l.designation 
                FROM laboratoires l, produits p 
                WHERE l.id_laboratoire = p.id_laboratoire
                ".$this->criterMoteurRecherche()."
                ORDER BY l.designation ASC";
        return $this->query($sql);
    }*/

    /*public function getFamilles()
    {
        $sql = "SELECT id_famille as id, designation as nom FROM familles ORDER BY designation";
        return $this->query($sql);
    }*/

    /*public function getImage($nom){
        $sql = "SELECT * FROM control_images WHERE cip13 = $nom LIMIT 0, 1";
        return $this->query($sql);
    }*/
}