<div id="upload">
    <div class="ligne">
<?php
$i = 1;
foreach ($liste as $key => $image){

    $id = $i + 1;

    $existe = (file_exists(PHOTO . $image['nom']. '.jpg'))?
        '<img src="'. PHOTO . $image['nom'] . '.jpg' . '">' : '';

    $existepng = (file_exists(PHOTO . $image['nom']. '.png'))?
        '<img src="'. PHOTO . $image['nom'] . '.png' . '">' : '';

    $zaper2 = ($image['zaper'] != 2)?
        '<input name="option" type="submit" value="conserver">' :
        '<input name="option" type="submit" value="retirer">';

    $zaper1 = ($image['zaper'] != 1)? "<input name='option' type='submit' value='zaper'>" : "";

    $denomination = '';
    $presentation = '';
    $med = '';
    $para = '';

    echo <<<EOL
    <div class="produits"><a href="" id="$id"></a>
    <img src="{$image['site']}/{$image['nom']}">
    $existe
    $existepng
    <form action="?page=select$f#$i" method="POST">
        <input name="id" type="hidden" value="{$image['id']}">
        <br>image : {$image['nom']} 
        $zaper1
        $zaper2
      <input type="text" name="cip13" placeholder="CIP" value="{$image['cip13']}" >
      <input type="text" name="denomination" placeholder="Dénomination" value="$denomination" >
      <input type="text" name="presentation" placeholder="Présentation" value="$presentation" >
      <select name="type">
       <option value="0" >TYPE</option>
       <option value="1" $med>Médicament</option>
       <option value="2" $para>Parapharma</option>
       </select>
       <input name="option" type="submit" value="valider">
    </form>
    </div>
EOL;
    $i++;
}
?>
    </div>
</div>


    