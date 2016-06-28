<div id="upload">
    <div class="ligne">
<?php
$i = 1;
foreach ($liste as $key => $image){
    //var_dump($liste);
    $imageid = $i + 1;
    $id = $image['id'];
    $nom = $image['nom']. ' ['. $image['site'].']';
    $zap = isset($image['zapper'])? $image['zapper'] : 0;
    $existe = (file_exists(PHOTO . $image['nom']. '.jpg'))?
        '<img src="'. PHOTO . $image['nom'] . '.jpg' . '">' : '';

    $existepng = (file_exists(PHOTO . $image['nom']. '.png'))?
        '<img src="'. PHOTO . $image['nom'] . '.png' . '">' : '';

    $zapper2 = ($zap != 2)?
        '<input name="option" type="submit" value="conserver">' :
        '<input name="option" type="submit" value="retirer">';

    $zapper1 = ($zap != 1)? "<input name='option' type='submit' value='zapper'>
        <input name='option' type='submit' value='supprimer'>" : "";

    $denomination = (isset($image['data']['denomination']))? utf8_encode($image['data']['denomination']) : '';
    $presentation = (isset($image['data']['presentation']))? utf8_encode($image['data']['presentation']) : '';
    $cip13 = (isset($image['data']['cip13']))? $image['data']['cip13'] : '';
    $med = (isset($image['data']['type']) && $image['data']['type'] == '1')? 'selected="selected"' : '';
    $para = (isset($image['data']['type']) && $image['data']['type'] == '2')? 'selected="selected"' : '';
    $image = str_replace('//'.$image['nom'], '/'.$image['nom'], $image['site'] . '/' . $image['nom']);
    $_zap = ['sans', 'ecarte', 'conserve'];
    $traitement = $_zap[$zap];

    echo <<<EOL
    <div class="produits $traitement">
    <div class="ligne">
    image : $nom
    </div>
    <div class="ligne">
    <form action="?page=existantimage$f#$i" method="POST">
        <input name="id" type="hidden" value="$id">
        <br> 
        $zapper1
        $zapper2
      <input type="text" name="cip13" placeholder="CIP" value="$cip13" >
      <input type="text" name="denomination" placeholder="Dénomination" value="$denomination" >
      <input type="text" name="presentation" placeholder="Présentation" value="$presentation" >
      <select name="type">
       <option value="0" >TYPE</option>
       <option value="1" $med>Médicament</option>
       <option value="2" $para>Parapharma</option>
       </select>
       <input name="option" type="submit" value="valider">
    </form>
    <img src="$image">
    $existe
    $existepng
    </div>
        <div class="ligne">
            <a href="#" id="$imageid" >&nbsp;</a>
        </div>
    </div>
EOL;
    $i++;
}
?>
    </div>
</div>
<?php
if(!empty($this->msg)){
    echo "<script type='text/javascript'>alert('{$this->msg}');</script>";
}
?>
    