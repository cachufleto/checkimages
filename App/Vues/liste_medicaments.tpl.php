<div class ="ligne">
    <h3>Liste des Médicaments</h3>
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
    //$row .= $info['produit_actif'];
    $ligne = '
        <div class="'.$row.'">';
        foreach ($info as $champ=>$data){

            $ligne .= '<div><span>' . $this->_lib[$champ] . ' : </span>'. utf8_encode($data) .'</div>';
        }
    $ligne .= '
        </div>';

    echo $ligne;
}

?>
</div>



