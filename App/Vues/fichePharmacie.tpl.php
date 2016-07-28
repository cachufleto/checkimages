<?php
/*
foreach ($produit[0] as $champ=>$data){$
    echo "
<div class='ligne'><label>{$this->_lib['champ']['$champ']} : </label><div>{$data['$champ']}</div></div>";
}
echo "
<div class='ligne'><label>VIGNETTE : </label><div><img height='100px' src='{$data[cip13]}_vig.jpg'> </div></div>";
echo "
<div class='ligne'><label>PHOTO : </label><div><img height='400px' src='{$data[cip13]}.jpg'> </div></div>";
*/

$data = $produit[0];
$data['libelle_ospharm'] = utf8_encode($data['libelle_ospharm']);
$data['descriptif'] = utf8_encode($data['descriptif']);
$data['famille'] = utf8_encode($data['famille']);
$data['sFamille'] = utf8_encode($data['sFamille']);
$data['ssFamille'] = utf8_encode($data['ssFamille']);
$image = file_exists(PHOTO_EN_COUR . "{$data['cip13']}.jpg")? "<img height='400px' src='photos" . DIRECTORY_SEPARATOR . "en_cours" . DIRECTORY_SEPARATOR . "{$data['cip13']}.jpg'>" : "";

echo <<<EOL
<div class='ligne'><label>{$this->_lib['champ']['libelle_ospharm']} : </label><div>{$data['libelle_ospharm']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['descriptif']} : </label><div>{$data['descriptif']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['laboratoire']} : </label><div>{$data['id_laboratoire']} - {$data['laboratoire']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['cacl']} : </label><div>{$data['cacl']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['cip13']} : </label><div>{$data['cip13']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['famille']} : </label><div>[{$data['id_famille']}] {$data['famille']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['sFamille']} : </label><div>[{$data['id_sfamille']}] {$data['sFamille']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['ssFamille']} : </label><div>[{$data['id_ssfamille']}] {$data['ssFamille']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['code_int_ceido_1']} : </label><div>{$data['code_int_ceido_1']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['code_int_ceido_2']} : </label><div>{$data['code_int_ceido_2']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['code_int_ceido_3']} : </label><div>{$data['code_int_ceido_3']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['composition']} : </label><div>{$data['composition']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['limite']} : </label><div>{$data['limite']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['id_tva']} : </label><div>{$data['id_tva']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['prix']} : </label><div>{$data['prix']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['ordre_top']} : </label><div>{$data['ordre_top']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['date_traitement']} : </label><div>{$data['date_traitement']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['produit_actif']} : </label><div>{$data['produit_actif']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['id_produit_lien']} : </label><div>{$data['id_produit_lien']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['conseils']} : </label><div>{$data['conseils']}</div></div>
<div class='ligne'><label>{$this->_lib['champ']['id_produit']} : </label><div>{$data['id_produit']}</div></div>
<div class='ligne'><label>PHOTOS : </label><div></div></div>
<div class='ligne'>
    <img height='100px' src='{$this->link}{$data['cip13']}_vig.jpg'>
    <img height='400px' src='{$this->link}{$data['cip13']}.jpg'>
    $image
</div>
EOL;
