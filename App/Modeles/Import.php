<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 13:07
 */
namespace Site;

use App\Bdd;

class Import extends Bdd
{
    var $_lib = [];

    public function __construct(){
        $this->_lib = file_contents_libelles();
    }
    
    public function selectMedicamentOk(){

        extract($_SESSION['accueil']);

        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, control_images i, laboratoires l
                WHERE p.cip13 = i.cip13
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $a, $b";

        return $this->query($sql);
    }

    public  function  countMedicamentOk(){

        extract($_SESSION['accueil']);
        // $sql = "SELECT count(*) as num FROM produits"
        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, control_images i, laboratoires l
                WHERE p.cip13 = i.cip13
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille";

        $num = $this->query($sql);
        return ($num)? $num[0]['num'] : 0;
    }

    public function selectMedicamentKo(){

        extract($_SESSION['accueil']);

        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 NOT IN  (SELECT cip13 FROM control_images)
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $a, $b";

        return $this->query($sql);
    }

    public  function  countMedicamentKo(){

        extract($_SESSION['accueil']);
        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 NOT IN  (SELECT cip13 FROM control_images)
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille";

        $num = $this->query($sql);
        return ($num)? $num[0]['num'] : 0;
    }

    public function selectMedicament(){

        extract($_SESSION['accueil']);

        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.produit_actif = 'i'
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $a, $b";

        return $this->query($sql);
    }

    public  function  countMedicament(){

        extract($_SESSION['accueil']);
        // $sql = "SELECT count(*) as num FROM produits"
        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss
                WHERE p.produit_actif = 'i'
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille";

        $num = $this->query($sql);
        return ($num)? $num[0]['num'] : 0;
    }

    public function testimage($photo){

        if ($_img = $this->existImageBDD($photo)){
            $img = $_img[0];
            if ($img['image'] == 1 && $img['vignette'] == 1) {
                return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '_vig.jpg" alt="' . $photo . ' Vignette"  border="0" />'
                . '<img height="250px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '.jpg" alt="' . $photo . ' Grande"  border="0" />';
            } else if ($img['image'] == 1) {
                return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '.jpg" alt="' . $photo . ' Grande"  border="0" />';
            } else if ($img['vignette'] == 1) {
                return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '_vig.jpg" alt="' . $photo . ' Vignette"  border="0" />';
            }

        } else {

            $_grand = remote_file_exists('https://www.pharmaplay.fr/m/produits/' . $photo . '.jpg');
            $_vignette = remote_file_exists('https://www.pharmaplay.fr/m/produits/' . $photo . '_vig.jpg');

            if ($_grand && $_vignette) {
                $this->insertControlImage($photo);
                return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '_vig.jpg" alt="' . $photo . ' Vignette"  border="0" />'
                . '<img height="250px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '.jpg" alt="' . $photo . ' Grande"  border="0" />';
            } else if ($_grand) {
                $this->insertControlImageGrande($photo);
                return '<img height="250px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '.jpg" alt="' . $photo . ' Grande"  border="0" />';
            } else if ($_vignette) {
                $this->insertControlImageVignatte($photo);
                return '<img height="150px" src="https://www.pharmaplay.fr/m/produits/' . $photo . '_vig.jpg" alt="' . $photo . ' Vignette"  border="0" />';
            }
        }

        return false;
    }

    public function existImageBDD($photo){
        $sql = "SELECT * FROM control_images WHERE cip13 = $photo LIMIT 0, 1";
        return $this->query($sql);
    }

    public function insertControlImage($cip13){
        $sql = "INSERT INTO `control_images` (`cip13`, `image`, `vignette`) VALUES ('$cip13', '1', '1');";
        $this->queryInsert($sql);
    }

    public function insertControlImageGrande($cip13){
        $sql = "INSERT INTO `control_images` (`cip13`, `image`, `vignette`) VALUES ('$cip13', '1', '0');";
        $this->queryInsert($sql);
    }

    public function insertControlImageVignette($cip13){
        $sql = "INSERT INTO `control_images` (`cip13`, `image`, `vignette`) VALUES ('$cip13', '0', '1');";
        $this->queryInsert($sql);
    }
}