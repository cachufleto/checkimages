<div id="upload">
    <div class="ligne">
<?php
$i = 1;
foreach ($liste as $key => $image){
    //var_dump($image);
    $imageid = $i + 1;
    $id = $image['id'];
    $nom = $image['nom'];
    $existe = (file_exists(PHOTO . $image['nom']. '.jpg'))?
        '<img src="'. PHOTO . $image['nom'] . '.jpg' . '">' : '';

    $existepng = (file_exists(PHOTO . $image['nom']. '.png'))?
        '<img src="'. PHOTO . $image['nom'] . '.png' . '">' : '';

    $zaper2 = ($image['zaper'] != 2)?
        '<input name="option" type="submit" value="conserver">' :
        '<input name="option" type="submit" value="retirer">';

    $zaper1 = ($image['zaper'] != 1)? "<input name='option' type='submit' value='zaper'>" : "";

    $denomination = (isset($image['data']['denomination']))? $image['data']['denomination'] : '';
    $presentation = (isset($image['data']['presentation']))? $image['data']['presentation'] : '';
    $cip13 = (isset($image['data']['cip13']))? $image['data']['cip13'] : '';
    $med = (isset($image['data']['type']) && $image['data']['type'] == '1')? 'selected="selected"' : '';
    $para = (isset($image['data']['type']) && $image['data']['type'] == '2')? 'selected="selected"' : '';
    $image = str_replace('//'.$image['nom'], '/'.$image['nom'], $image['site'] . $image['nom']);

    echo <<<EOL
    <div class="produits">
    <a href="" id="$imageid"></a>
    <form action="?page=existantimage$f#$i" method="POST">
        <input name="id" type="hidden" value="$id">
        <br>image : $nom 
        $zaper1
        $zaper2
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
    