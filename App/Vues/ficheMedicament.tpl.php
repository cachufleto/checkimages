<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29/06/2016
 * Time: 16:04
 */
/*
foreach ($produit[0] as $champ=>$data){
    echo "
<div class='ligne'><label>{$this->_lib['champ'][$champ]} : </label><div>" . utf8_encode($data)."</div></div>";
}
echo "
<div class='ligne'><label>VIGNETTE : </label><div><img height='100px' src='{$this->link}{$produit[0]['cip13']}_vig.jpg'> </div></div>";
echo "
<div class='ligne'><label>PHOTO : </label><div><img height='400px' src='{$this->link}{$produit[0]['cip13']}.jpg'> </div></div>";*/
$data = $produit[0];
$data['libelle_ospharm'] = utf8_encode($data['libelle_ospharm']);
$data['ansm'] = utf8_encode($data['ansm']);
$data['presentation'] = utf8_encode($data['presentation']);
$data['famille'] = utf8_encode($data['famille']);
$data['sFamille'] = utf8_encode($data['sFamille']);
$data['ssFamille'] = utf8_encode($data['ssFamille']);
$image = file_exists(SITE . "photos/en_cours/{$data['cip13']}.jpg")? "<img height='400px' src='photos/en_cours/{$data['cip13']}.jpg'>" : "";
echo <<<EOL
<div class="ligne"><label>{$this->_lib['champ']['libelle_ospharm']} : </label><div>{$data['libelle_ospharm']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['denomination']} : </label><div>{$data['denomination']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['laboratoire']} : </label><div>{$data['id_laboratoire']} - {$data['laboratoire']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['cis']} : </label><div>{$data['cis']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['cip13']} : </label><div>{$data['cip13']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['famille']} : </label><div>[{$data['id_famille']}] {$data['famille']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['sFamille']} : </label><div>[{$data['id_sfamille']}] {$data['sFamille']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['ssFamille']} : </label><div>[{$data['id_ssfamille']}] {$data['ssFamille']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['presentation']} : </label><div>{$data['presentation']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['limite']} : </label><div>{$data['limite']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['id_tva']} : </label><div>{$data['id_tva']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['prix_moyen']} : </label><div>{$data['prix_moyen']}0</div></div>
<div class="ligne"><label>{$this->_lib['champ']['prix_public']} : </label><div>{$data['prix_public']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['ordre_top']} : </label><div>{$data['ordre_top']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['date_traitement']} : </label><div>{$data['date_traitement']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['produit_actif']} : </label><div>{$data['produit_actif']}</div></div>
<div class="ligne"><label>{$this->_lib['champ']['ansm']} : </label><div>{$data['ansm']}</div></div>
<div class='ligne'><label>VIGNETTE : </label><div></div></div>
<div class='ligne'>
    <img height='100px' src='{$this->link}{$data['cip13']}_vig.jpg'>
    <img height='400px' src='{$this->link}{$data['cip13']}.jpg'>
    $image
</div>
EOL;
