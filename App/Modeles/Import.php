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

        $a = 0;
        $b = NUM;

        extract($_SESSION[$this->page]);

        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille,
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, control_images i, laboratoires l
                WHERE p.cip13 = i.cip13
                {$this->criterMoteurRecherche()}
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $a, $b";

        return $this->query($sql);
    }

    public  function  countMedicamentOk(){

        extract($_SESSION[$this->page]);

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, control_images i, laboratoires l
                WHERE p.cip13 = i.cip13
                {$this->criterMoteurRecherche()}
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille ";

        $num = $this->query($sql);
        
        return ($num)? $num[0]['num'] : 0;
    }

    public function selectMedicamentKo(){

        $a = 0;
        $b = NUM;

        extract($_SESSION[$this->page]);

        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 NOT IN  (SELECT cip13 FROM control_images)
                {$this->criterMoteurRecherche()}
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $a, $b";

        return $this->query($sql);
    }

    public  function  countMedicamentKo(){

        extract($_SESSION[$this->page]);

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE p.cip13 NOT IN  (SELECT cip13 FROM control_images)
                {$this->criterMoteurRecherche()}
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_famille = f.id_famille 
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille";

        $num = $this->query($sql);
        
        return ($num)? $num[0]['num'] : 0;
    }

    public function selectMedicament(){

        $a = 0;
        $b = NUM;

        extract($_SESSION[$this->page]);

        $sql = "SELECT p.produit_actif, p.id_produit, p.cip13, p.libelle_ospharm, f.designation as famille, 
                        s.designation as sFamille, ss.designation as ssFamille, l.designation as laboratoire
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE 1
                {$this->criterMoteurRecherche()}
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille 
                ORDER BY l.designation ASC,  p.libelle_ospharm ASC
                LIMIT $a, $b";

        return $this->query($sql);
    }

    public  function  countMedicament(){

        extract($_SESSION[$this->page]);

        $sql = "SELECT count(*) as num
                FROM produits p, familles f, s_familles s, ss_famille ss, laboratoires l
                WHERE 1
                {$this->criterMoteurRecherche()}
                AND p.id_famille = f.id_famille 
                AND p.id_laboratoire = l.id_laboratoire
                AND p.id_sfamille = s.id_sfamille 
                AND p.id_ssfamille = ss.id_ssfamille ";

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

    public function selectLaboratoires()
    {
        $sql = "SELECT id_laboratoire as id, designation as nom FROM laboratoires ORDER BY designation ASC";
        return $this->query($sql);
    }

    public function selectFamilles()
    {
        $sql = "SELECT id_famille as id, designation as nom FROM familles ORDER BY designation";
        return $this->query($sql);
    }

    public function afficheMoteurRecherche()
    {
        include_once VUE . 'moteurRecherche.tpl.php';
    }

    public function getLaboratoires()
    {
        $data = $this->selectLaboratoires();

        $balise = '<select name="labo">';
        $balise .= '
            <option value="0">---</option>';

        $choix = isset($_SESSION['recherche'][$this->page]['labo'])? $_SESSION['recherche'][$this->page]['labo'] : 0;
        foreach ($data as $info) {
            $select = ($info['id'] == $choix)? 'selected' : '' ;
            $balise .= '
            <option value="' . $info['id'] . '" ' . $select . '>' . $info['nom'] . '</option>';
        }
        $balise .= '
        </select>';

        return $balise;
    }

    public function getEtat()
    {
        $choix = isset($_SESSION['recherche'][$this->page]['etat'])? $_SESSION['recherche'][$this->page]['etat'] : '';
        $etat = '
        Inedit<input name="etat[i]" type="checkbox" value="1" ' .
            (isset($choix['i'])? 'checked' : '')
            . ' >';
        $etat .= '
        On Line<input name="etat[o]" type="checkbox" value="1" ' .
            (isset($choix['o'])? 'checked' : '')
                . ' >';
        $etat .= '
        Off line<input name="etat[n]" type="checkbox" value="1" ' .
            (isset($choix['n'])? 'checked' : '')
                . ' >';
        $etat .= '
        Archivé<input name="etat[a]" type="checkbox" value="1" ' .
            (isset($choix['a'])? 'checked' : '')
                . ' >';

        return $etat;
    }

    public function getCip()
    {
        $choix = isset($_SESSION['recherche'][$this->page]['cip'])? $_SESSION['recherche'][$this->page]['cip'] : '';
        return '<input type="texte" name="cip13" placeholder="' . $choix . '" >';
    }

    public function getNoms()
    {
        $choix = isset($_SESSION['recherche'][$this->page]['nom'])? $_SESSION['recherche'][$this->page]['nom'] : '';
        return '<input type="texte" name="nom" placeholder="' . $choix . '" >';
    }

    public function getFamilles()
    {
        $data = $this->selectFamilles();

        $balise = '<select name="famille">';

        $choix = isset($_SESSION['recherche'][$this->page]['famille'])? $_SESSION['recherche'][$this->page]['famille'] : 0;
        foreach ($data as $info) {
            $select = ($info['id'] == $choix)? 'selected' : '' ;
            $balise .= '
            <option value="' . $info['id'] . '" ' . $select . '>' . utf8_encode($info['nom']) . '</option>';
        }
        $balise .= '
        </select>';

        return $balise;
    }

    public function getSousFamilles()
    {
        return 'Sous Familles';
    }

    public function getSousSousFamilles()
    {
        return 'Sous Sous Famille';
    }

    public function criterMoteurRecherche()
    {
        $chercher = $_SESSION['recherche'][$this->page];
        $recherche = '';
        $option = [];
        if( (
        isset($chercher['cip13']) AND !empty($chercher['cip13'])
        ) OR (
        isset($chercher['nom']) AND !empty($chercher['nom'])
        ) )
        {
            // recherche par cip
            if (isset($chercher['cip13']) AND !empty($chercher['cip13'])){
            $option[] = ' p.cip13 LIKE "%' . $chercher['cip13'] . '%"';
            }

            // recherche par libelle du produit
            if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
                $option[] = ' p.libelle_ospharm LIKE "' . $chercher['nom'] . '%"';
            }

            // agrementation du libelle du produit
            $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

            if(is_array($_nom) AND count($_nom) > 1){
                foreach ($_nom as $mot){
                    $option[] = ' p.libelle_ospharm LIKE "%' . $mot .'%"';
                }
            }

            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' OR ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

        } else {

            if (isset($chercher['labo']) && $chercher['labo'] > 0){
                $option[] = ' p.id_laboratoire = ' . $chercher['labo'];
            }

            if(isset($chercher['etat'])){
                $etat = '';
                $etat .= isset($chercher['etat']['i'])?
                    ' p.produit_actif = "i"' : '';
                $etat .= isset($chercher['etat']['o'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "o"' : '';
                $etat .= isset($chercher['etat']['n'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "n"' : '';
                $etat .= isset($chercher['etat']['a'])?
                    (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "a"' : '';
                $option[] = (count($chercher['etat']) > 1 )? "( $etat )" : $etat;
            }
            // recherche partielle
            if (isset($chercher['famille']) && !empty($chercher['famille'])){
                $option[] = ' p.id_famille = ' . $chercher['famille'];
            }
            $_option = '';
            foreach($option as $_r){
                $_option .= (empty($_option)? '' : ' AND ') . $_r;
            }
            $recherche = (!empty($_option))? ' AND ' . $_option : '';
        }

        return $recherche;
    }
}