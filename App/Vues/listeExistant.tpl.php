<div id="existant">
<?php
/*
     array (size=8)
      'id' => string '3' (length=1)
      'site' => string 'http://www.infos-medicaments.com/monographie/images/' (length=52)
      'nom' => string '178496' (length=6)
      'produit' => null
      'upload' => string '0' (length=1)
      'zaper' => string '2' (length=1)
      'cip13' => null
      'image' => null
 */
$i = 1;
foreach ($liste as $key => $produit){ ?>
<div class="ligne">
    <div class="existant">
        <a class="anchor" href="" id="<?php echo ($i+1); ?>"></a>
        <div class="ligne">
            <div class="existimg">
                <img src="<?php echo $produit['site'].$produit['nom']; ?>">
            </div>
            <div>
                image : <?php echo $produit['nom'], ' CIP: ',  $produit['cip13']; ?>
                <form action="?page=photo<?php echo $f, '#' . $i; ?>" method="POST">
                    <input name="id" type="hidden" value="<?php echo $produit['id']; ?>">
                    <?php echo ($produit['zaper'] != 2)? '
                    <input name="option" type="submit" value="conserver">' : '
                    <input name="option" type="submit" value="retirer">' ;
                    if($produit['zaper'] != 1){
                    echo '
                    <input name="option" type="submit" value="zaper">
                    <input name="option" type="submit" value="CIP">
                    <input name="cip13" type="text" value="">';
                    } ?>
                </form>
            </div>
        </div>
        <?php if(file_exists(PHOTO . $produit['nom'].'.jpg')){
        echo '
        <div class="ligne">
            <div class="existimg">
                <img src="photos/' . $produit['nom'].".jpg" . '">
            </div>';
            echo '
            <div class="ligne">
                NOM JPG : ' . $produit['nom'] . '
            </div>
        </div>';
        }

        if(file_exists(PHOTO . $produit['nom'].'.png')){
            echo '
        <div class="ligne">
            <div class="existimg">
                <img src="photos/' . $produit['nom'].".png" . '">
            </div>';
            echo '
            <div class="ligne">
                NOM PNG : ' . $produit['nom'] . '
            </div>
        </div>';
        }
        if(file_exists(PHOTO . $produit['cip13'].'.jpg')){
            echo '
        <div class="ligne">
            <div class="existimg">
                <img src="photos/' . $produit['cip13'].".jpg" . '">
            </div>';
            echo '
            <div class="ligne">
                CIP JPG : ' . $produit['cip13'] . '
            </div>
        </div>';
        }
        if(file_exists(PHOTO . $produit['cip13'].'.png')){
            echo '
        <div class="ligne">
            <div class="existimg">
                <img src="photos/' . $produit['cip13'].".png" . '">
            </div>';
            echo '
            <div class="ligne">
                CIP PNG : ' . $produit['cip13'] . '
            </div>
        </div>';
        }
        ?>
    </div>
</div>
<?php
    $i++;
}
?>
</div>

    