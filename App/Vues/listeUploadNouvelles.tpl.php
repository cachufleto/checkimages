<div id="upload">
    <div class="ligne">
<?php
$i = 1;
$alert = '';
foreach ($liste as $key => $image){
    $imageid = $i + 1;
    $id = $image['id'];
    $msg = isset($this->msg[$id])? $this->msg[$id] : '';
    $alert = (empty($alert) AND isset($this->alert[$id]))? isset($this->alert[$id]) : $alert;
    $existedeja = (isset($this->alert[$id]) and file_exists(PHOTO . "en_cours/{$_POST['cip13']}.jpg"))?
        "<img width='150' src='photos/en_cours/{$_POST['cip13']}.jpg'>" : "";
    $nom = $image['nom']. ' ['. $image['site'].']';
    $zap = isset($image['zapper'])? $image['zapper'] : 0;
    $existe = (file_exists(PHOTO . $image['nom']. '.jpg'))?
        figureHTML(PHOTO . $image['nom'] . '.jpg', $image['nom']) : '';

    $existepng = (file_exists(PHOTO . $image['nom']. '.png'))?
        figureHTML(PHOTO . $image['nom'] . '.png', $image['nom']) : '';

    $existesans = (file_exists(PHOTO . $image['nom']))?
        figureHTML(PHOTO . $image['nom'], $image['nom']) : '';

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
    <div class="ligne" style="color:red">
        $msg $existedeja 
    </div> 
    <div class="ligne">
    <img src="$image">
    $existe
    $existepng
    $existesans
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
if(!empty($msg)){
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>
    