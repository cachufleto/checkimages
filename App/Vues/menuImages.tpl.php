<?php
echo <<<EOL
<div id="menu">
    <div class="suite">
        {$data['liensPages']}
    </div>
    <div class="suite">
        <a class="page" href="?page={$data['page']}&display={$data['arriere']}&nombre={$data['l']}"><<</a> page précédente
        <a {$data['ok']} href="?page={$data['page']}&produit=ok"> {$data['bouttonAvecImage']}  </a>  
        <a {$data['ko']} href="?page={$data['page']}&produit=ko"> {$data['bouttonSansImage']} </a>  
        <a {$data['tous']} href="?page={$data['page']}"> {$data['bouttonTousImage']} </a>
         page suivante <a class="page" href="?page={$data['page']}&display={$data['suivante']}&nombre={$data['l']}">>></a>  
    </div>
EOL;

echo <<<EOL
    <div class="suite">
        <div class="resultat">Images : {$data['num']}
            [ page: {$data['p']}]
            Affichage de {$data['b']} Images par pages ( TOTAL: {$data['numProduits']} )</div>
    </div>
</div>
<div id="content">
EOL;
