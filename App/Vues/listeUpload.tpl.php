
<script type='text/javascript'>
    function opnw(a) {
        var myWindow = window.open("<?php echo LINK; ?>?page=ficheimage&cip13=" + a, "MsgWindow", "width=400,height=500");
    }
</script>

<div id="upload">
    <div class="ligne">
<?php
debug($_SESSION, 'SESSION');

$i = 1;
$alert = '';
foreach ($liste as $key => $image){
    $imageid = $i + 1;
    $id = $image['id'];
    $nom = $image['nom']. ' ['. $image['site'].']';
    $zap = isset($image['zapper'])? $image['zapper'] : 0;

    $zapper1 = ($zap == 0)?
        "<input name='option' type='submit' value='{$this->_lib['option']['supprimer']}'>
        <input name='option' type='submit' value='{$this->_lib['option']['zapper']}'>
        <input name='option' type='submit' value='{$this->_lib['option']['conserver']}'>"
        : (($zap == 1)?
        "<input name='option' type='submit' value='{$this->_lib['option']['supprimer']}'>
        <input name='option' type='submit' value='{$this->_lib['option']['conserver']}'>"
        : "<input name='option' type='submit' value='{$this->_lib['option']['supprimer']}'>
        <input name='option' type='submit' value='{$this->_lib['option']['zapper']}'>");

    $denomination = (isset($image['data']['denomination']))? utf8_encode($image['data']['denomination']) : '';
    $presentation = (isset($image['data']['presentation']))? utf8_encode($image['data']['presentation']) : '';
    $cip13 = (isset($image['data']['cip13']))? $image['data']['cip13'] : '';
    $msg = isset($this->msg[$id])? $this->msg[$id] : '';
    $existedeja = (isset($this->alert[$id]) and file_exists(PHOTO_EN_COUR . "{$_POST['cip13']}.jpg"))?
        $cip13 : "";
    $alert = (empty($alert) AND isset($this->alert[$id]))? $existedeja : $alert;
    $med = (isset($image['data']['type']) && $image['data']['type'] == '1')? 'selected="selected"' : '';
    $para = (isset($image['data']['type']) && $image['data']['type'] == '2')? 'selected="selected"' : '';
    $photo = $image['image'];
    $encours = $photo['encours'];
    $image = $photo['image'];
    $vignette = $photo['vignette'];
    $imageMedicament =
        $vignetteMedicament =
        $imagePharmacie =
        $vignettePharmacie = '';
    $production = '';
    if(isset($photo['production']) && !empty($photo['production'])) {
        $_images = $photo['production'];
        if (!empty($_images['medicament'])) {
            if (!is_array($_images['medicament'])) {
                $production .= "<span class='alert'>{$_images['medicament']}</span>";
            } else {
                $production .= "
        <div class=\"medicament\">
            <div>MEDICAMENT:</div>
            {$_images['medicament']['image']}
            {$_images['medicament']['vignette']}
        </div>";
            }
        }
        if (!empty($_images['pharmacie'])) {
            if (!is_array($_images['pharmacie'])) {
                $production .= "<span class='alert'>{$_images['pharmacie']}</span>";
            } else {
                    $production .= "
            <div class=\"parapaharmacie\">
                <div>PARAPHARMACIE:</div>
                {$_images['pharmacie']['image']}
                {$_images['pharmacie']['vignette']}
            </div>";
            }
        }
            $production = "
        <div class=\"ligne production\">
        $production
        </div>";
    }

    $_zap = ['sans', 'ecarte', 'conserve'];
    $traitement = $_zap[$zap];

    echo <<<EOL
    <div class="produits $traitement">
    <div class="ligne">
    image : $nom 
    </div>
    <div class="ligne" style="color:red">
        $msg $existedeja
    </div> 
    <div class="ligne">
    <form action="#$i" method="POST">
        <input name="id" type="hidden" value="$id">
        $zapper1
      <input type="text" name="cip13" placeholder="CIP" value="$cip13" >
      <input type="text" name="denomination" placeholder="Dénomination" value="$denomination" >
      <input type="text" name="presentation" placeholder="Présentation" value="$presentation" >
      <select name="type">
       <option value="0" >TYPE</option>
       <option value="1" $med>Médicament</option>
       <option value="2" $para>Parapharma</option>
       </select>
       <input name="option" type="submit" value="{$this->_lib['option']['valider']}">
    </form>
    $image
    $encours
    $vignette
    </div>
    $production
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

if(!empty($alert)){
    echo "<script type='text/javascript'> 
        opnw('$alert');
        </script>";
}
?>
    