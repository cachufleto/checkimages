<div class ="ligne">
    <?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 16:45
 */
$entete = '
    <div>
        <div>';
$_ent = true;
$l = 1;
foreach($liste as $key=>$info){
    $l++;
    $row = "row".($l%2);
    $vignette = isset($info['image']['vignette'])? $info['image']['vignette'] : '';
    $image = isset($info['image']['image'])? $info['image']['image'] : '';
    $encours = isset($info['image']['encours'])? $info['image']['encours'] : '';
    $ligne = "
    <div class='$row'>
        <div class='ligne'>
            <div class='ligne'><label>{$this->_lib['libelle_ospharm']} : </label><div>".utf8_encode($info['libelle_ospharm'])."</div></div>
            <div class='ligne'><label>{$this->_lib['laboratoire']} : </label><div>".utf8_encode($info['laboratoire'])."</div></div>
        </div>
        <div class='ligne'>
        <div class='' style='float:left;  width:30%;'>
            <div class='ligne'><label>{$this->_lib['cip13']} : </label><div>{$info['cip13']}</div></div>
            <div class='ligne'><label>{$this->_lib['famille']} : </label><div>".utf8_encode($info['famille'])."</div></div>
            <div class='ligne'><label>{$this->_lib['sFamille']} : </label><div>".utf8_encode($info['sFamille'])."</div></div>
            <div class='ligne'><label>{$this->_lib['ssFamille']} : </label><div>".utf8_encode($info['ssFamille'])."</div></div>
            <div class='ligne'><label>{$this->_lib['id_produit']} : </label><div>{$info['id_produit']}</div></div>
            <div class='ligne'><label>{$this->_lib['produit_actif']} : </label><div>{$this->_lib['actif'][$info['produit_actif']]}</div></div>
            <div class='ligne'><label>{$this->_lib['image']} : </label><div></div></div>
            <div class='ligne'><div class='vignette'>$vignette</div></div>
            <div class='ligne'><label>EN COURS : </label><div></div></div>
            <div class='ligne'><div class='encours'>$encours</div></div>
        </div>
        <div class='ligneimg' style='float:left; width:30%;'>
            <div class='image'>$image</div>
        </div>
    </div>
    </div>";
    echo $ligne;
} ?>
</div>



