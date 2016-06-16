<div id="existant">
<?php
$i = 1;
foreach ($liste as $key => $produit) {

    $anchor = $i+1;
    echo <<<EOL
<div class="ligne">
    <div class="existant">
        <a class="anchor" href="" id="$anchor"></a>
        <div class="ligne">
            <div class="existimg">
                <img src="{$produit['site']}{$produit['nom']}">
            </div>
            <div>
                image : {$produit['nom']} CIP: {$produit['cip13']}
                <form action="?page=photo$f#$i" method="POST">
                    <input name="id" type="hidden" value="{$produit['id']}">
EOL;

    echo ($produit['zaper'] != 2)? '
                    <input name="option" type="submit" value="conserver">' : '
                    <input name="option" type="submit" value="retirer">';

    if($produit['zaper'] != 1){
        echo '
                    <input name="option" type="submit" value="zaper">
                    <input name="option" type="submit" value="CIP">
                    <input name="cip13" type="text" value="">';
    }
    echo "
    </form>
            </div>
        </div>";

if(file_exists(PHOTO . $produit['nom'].'.jpg')){

        echo <<<EOL
        <div class="ligne">
            <div class="existimg">
                <img src="photos/{$produit['nom']}.jpg">
            </div>
            <div class="ligne">
                NOM JPG : {$produit['nom']}
            </div>
        </div>
EOL;
        }

        if(file_exists(PHOTO . $produit['nom'].'.png')){
            echo <<<EOL
        <div class="ligne">
            <div class="existimg">
                <img src="photos/{$produit['nom']}.png">
            </div>
            <div class="ligne">
                NOM PNG : {$produit['nom']}
            </div>
        </div>
EOL;
        }

        if(file_exists(PHOTO . $produit['cip13'].'.jpg')){
            echo <<<EOL
        <div class="ligne">
            <div class="existimg">
                <img src="photos/{$produit['cip13']}.jpg">
            </div>
            <div class="ligne">
                CIP JPG : {$produit['cip13']}
            </div>
        </div>
EOL;
        }

        if(file_exists(PHOTO . $produit['cip13'].'.png')){
            echo <<<EOL
        <div class="ligne">
            <div class="existimg">
                <img src="photos/{$produit['cip13']}.png">
            </div>';
            echo '
            <div class="ligne">
                CIP PNG : {$produit['cip13']}
            </div>
        </div>
EOL;
        }

echo '
    </div>
</div>';
    $i++;
}
?>
</div>

    