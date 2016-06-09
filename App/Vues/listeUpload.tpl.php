<div class="ligne">
<?php
$i = 1;
foreach ($liste as $key => $produit){
    echo '<div class="produits"><a href="" id="'. ($i+1).'"></a>';
    echo "<img src=\"{$produit['site']}/{$produit['nom']}\">";
    if(file_exists(PHOTO . $produit['nom'].'.jpg')){
        echo "<img src=\"". PHOTO . $produit['nom'].'.jpg' ."\">";
    }
    if(file_exists(PHOTO . $produit['nom'].'.png')){
        echo "<img src=\"". PHOTO . $produit['nom'].'.png' ."\">";
    }
    echo "<br>image : {$produit['nom']}";
    echo "<form action=\"?page=select{$f}#{$i}\" method=\"POST\">
        <input name='id' type='hidden' value='{$produit['id']}'>";
    echo ($produit['zaper'] != 2)?
            "<input name='option' type='submit' value='conserver'>" :
            "<input name='option' type='submit' value='retirer'>" ;
    if($produit['zaper'] != 1){
        echo "<input name='option' type='submit' value='zaper'>";
    }
    echo "</form>";
    echo '</div>';
    $i++;
}
?>
</div>


    