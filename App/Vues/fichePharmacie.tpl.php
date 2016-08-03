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
$data['composition'] = utf8_encode($data['composition']);
$data['conseils'] = utf8_encode($data['conseils']);
$data['famille'] = utf8_encode($data['famille']);
$data['sFamille'] = utf8_encode($data['sFamille']);
$data['ssFamille'] = utf8_encode($data['ssFamille']);

$imageVignette = (($imageVignette = figureHTML("{$this->link}{$data['cip13']}_vig.jpg", $this->_lib['imageVignette'])) != 'NULL')?
    $imageVignette : $this->_lib['imageVignette'] . $this->_lib['imageEmpty'];
$imageGrande = (($imageGrande = figureHTML("{$this->link}{$data['cip13']}.jpg", $this->_lib['imageGrande'])) != 'NULL')?
    $imageGrande : $this->_lib['imageGrande'] . $this->_lib['imageEmpty'];
$image = file_exists(PHOTO_EN_COUR . "{$data['cip13']}.jpg")? "photos/en_cours/{$data['cip13']}.jpg" : "";
$imageEnCours = (($imageEnCours = figureHTML($image, $this->_lib['imageEnCours']))!= 'NULL')?
    $imageEnCours : $this->_lib['imageEnCours'] . $this->_lib['imageEmpty'];

echo <<<EOL
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8"/>
    <meta name="description" content="Fiche parapharmacie - ma ph@rmacie en ligne - 36 avenue Pierre Lanfrey">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
    <link href="css/fiches.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://www.pharmaplay.fr/scripts/jquery-1.10.2.min.js"></script>
    <!--utilisé par entetes et pge index services-->
    <script type="text/javascript" src="https://www.pharmaplay.fr/scripts/jssor.core.js"></script>
    <script type="text/javascript" src="https://www.pharmaplay.fr/scripts/jssor.utils.js"></script>
    <script type="text/javascript" src="https://www.pharmaplay.fr/scripts/jssor.slider.js"></script>
    <link rel="icon" type="image/png" href="https://www.pharmaplay.fr/s/banque_images/logos_grpt/45/favicon.png" />
    <title>CEIDO - Fiche parapharmacie</title>
    <!--popup -->
    <link href="https://www.pharmaplay.fr/css/magnific-popup.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://www.pharmaplay.fr/scripts/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="js/fiche.js"></script>
</head>
<body>
<div class="global">
    <div  class="conteneur_corps">
        <div class="corps" onMouseOver="ferme_toutes_div_sf()">
            <div id="colonne_droite">
            </div>
            <div id="contenu">
                <div class="chemin_produit">
                    <a href="https://www.pharmaplay.fr/p/sfam.asp?idf={$data['id_famille']}" class="chemin_arbo">{$data['famille']}</a>
                    <img src="https://www.pharmaplay.fr/s/im/fleche_chemin.png">
                    <a href="https://www.pharmaplay.fr/p/prodlist.asp?idsf={$data['id_sfamille']}" class="chemin_arbo">{$data['sFamille']}</a>
                    <img src="https://www.pharmaplay.fr/s/im/fleche_chemin.png">
                    <a href="https://www.pharmaplay.fr/p/prodlist.asp?idssf={$data['id_ssfamille']}" class="chemin_arbo">{$data['ssFamille']}</a>
                </div>
                <div style="margin-left:100px; padding:20px;">
                    <div class="titre_produit">{$data['libelle_ospharm']}</div>
                    <div class="titre_laboratoire" style="margin-top:10px;">{$data['laboratoire']}</div>
                </div>
                <div style="position:relative; margin-left:10px; margin-right:10px; overflow:auto;">
                    <div style="float:right; width:50%;">
                        <div>
                            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                <!-- non affiché : strcis-->
                                <tr>
                                    <td valign="top" class="libelle_produit">Référence</td>
                                    <td valign="top">{$data['cip13']}</td>
                                </tr>
                                <tr>
                                    <td height="15">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <!--bloc commande-->
                                <form name="ajout_panier" id="ajout_panier" method="post" action="https://www.pharmaplay.fr/communs_detail_panier.asp">
                                    <tr>
                                        <td valign="top">&nbsp;</td valign="top">
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td>
                                                        <div class="prix_produit">
                                                            <div style="font-size:28px; padding:10px; text-align:right; font-weight:bold">{$data['prix']} € <span style="font-size: 50%;"> TTC</span> </div>
                                                        </div>
                                                    </td>
                                                    <td valign="bottom">
                                                        <div style="position:relative; margin-left:10px;" class="libelle_produit">Quantité:
                                                            <select name="quantite_produit" style="width:50px; height:25px;" value="" maxlength="3">
                                                                <option>{$data['limite']}</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">&nbsp;</td valign="top">
                                        <td>
                                            <div class="ajout_panier" onclick="document.getElementById('ajout_panier').submit();">Ajouter au panier</div>
                                        </td>
                                    </tr>
                                    <input name="id_produit" type="hidden" value="1005" />
                                    <input name="nature_produit" type="hidden" value="p" />
                                    <!--p pour la para -->
                                    <input name="mode" type="hidden" value="ajout" />
                                    </tr>
                                </form>
                                <!--bloc fin de commande-->
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <div>Date de mise &agrave; jour:&nbsp;<strong>{data['date_traitement']  }</strong></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="float:left; width:50%;">
                        <div style="margin-top:10px; margin-left:40px; width:300px; height:300px;">
                            <a class="image-popup-no-margins" href="https://www.pharmaplay.fr/p/produits/{$data['cip13']}.jpg">
                                <img src="https://www.pharmaplay.fr/p/produits/{$data['cip13']}.jpg" width="300" height="300" alt="{$data['libelle_ospharm']} - ma ph@rmacie en ligne" /></a>
                        </div>
                        <div style="margin-top:10px; margin-left:40px; width:300px;">
                            <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
                                <tr>
                                    <td align="center" colspan="2">
                                        <div class="chemin_arbo_italic">Photo non contractuelle</div>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div style="width:100%;">
                        <div style="position:relative; width:100%; height:auto;">
                            <table width="100" cellpadding="0" cellspacing="5" border="0" align="center">
                                <tr>
                                    <td>
                                        <div id="bt_descriptif" class="bt_fiche_parapharmacie" onclick="fiche_para('descriptif')">Descriptif</div>
                                    </td>
                                    <td>
                                        <div id="bt_conseils" class="bt_fiche_parapharmacie" onclick="fiche_para('conseils')">Conseil</div>
                                    </td>
                                    <td>
                                        <div id="bt_composition" class="bt_fiche_parapharmacie" onclick="fiche_para('composition')">Composition</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="max-width:100%; padding:10px;">
                            <div id="descriptif" class="contenu_fiche_parapharmacie">
                                <div style="padding:10px;">{$data['descriptif']}</div>
                            </div>
                            <div id="conseils" class="contenu_fiche_parapharmacie">
                                <div style="padding:10px;">{$data['conseils']}</div>
                            </div>
                            <div id="composition" class="contenu_fiche_parapharmacie">
                                <div style="padding:10px;">{$data['composition']}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  ****************************************** -->
                <div class="titre">Mon panier</div>
                <div style="position:relative; margin-left:10px; margin-right:10px; overflow:auto; overflow-x:hidden; overflow-y:hidden;">
                    <div class="detail_ligne_panier">
                        <div class="csstable" >
                            <table >
                                <tr>
                                    <td align="center">
                                        <img src="https://www.pharmaplay.fr/s/im/coche_p.png" />
                                    </td>
                                    <td colspan="5" class="lib_formulaire_neutre" >
                                        <strong>Parapharmacie</strong> (laboratoire {$data['laboratoire']})
                                    </td>
                                    <td>
                                        <div class="bt_sup_detail_panier">Supprimer</div>
                                        <form name="sup_panier{$data['id_produit']}" id="sup_panier{$data['id_produit']}" method="post" action="communs_detail_panier.asp">
                                            <input name="id_produit" type="hidden" value="{$data['id_produit']}" />
                                            <input name="nature_produit" type="hidden" value="p" />
                                            <input name="mode" type="hidden" value="sup" />
                                            <input name="ancien_enregistrement" type="hidden" value="[{$data['id_produit']}]*4#p|" />
                                        </form>
                                    </td>
                                </tr>
                                <form name="modif_panier{$data['id_produit']}" id="modif_panier{$data['id_produit']}" method="post"action="communs_detail_panier.asp">
                                    <tr>
                                        <td>
                                            <div style="width:80px; height:80px; cursor:pointer; ">
                                                <a class="image-popup-no-margins" href="https://www.pharmaplay.fr/p/produits/{$data['cip13']}.jpg">
                                                    <img src="https://www.pharmaplay.fr/p/produits/{$data['cip13']}_vig.jpg" width="80" height="80" alt="{$data['libelle_ospharm']} - ma ph@rmacie en ligne" /></a>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="lien_panier_detailpanier" onClick="goto_url('https://www.pharmaplay.fr/p/prod.asp?idprod={$data['id_produit']}')">{$data['libelle_ospharm']}</div>
                                        </td>
                                        <td>
                                            <div><strong>{$data['prix']}</strong> € <span style="font-size: 70%;"> TTC</span></div>
                                        </td>
                                        <td>
                                            <select name="quantite_produit" style="width:50px; height:25px;"  maxlength="3" onChange="document.getElementById('modif_panier{$data['id_produit']}').submit();">
                                                <option>{$data['limite']}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div style="text-align:right;"><span><strong>00,00</strong> € <span style="font-size: 80%; font-weight:normal;">TTC</span></span></div>
                                            <input name="id_produit" type="hidden" value="{$data['id_produit']}" />
                                            <input name="nature_produit" type="hidden" value="p" />
                                            <input name="mode" type="hidden" value="modif" />
                                            <input name="ancien_enregistrement" type="hidden" value="[{$data['id_produit']}]*4#p|" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </form>
                            </table>
                        </div>
                    </div>
                </div> <!--ferme corps-->
                <!--  ****************************************** -->
            </div>
            <!--ferme contenu-->
        </div> <!--ferme corps-->
    </div>
</div>
<script type="text/javascript">
    document.getElementById('descriptif').style.display="block";
    document.getElementById('bt_descriptif').style.backgroundColor ="#666666";
    $(document).ready(function() {
        $('.image-popup-no-margins').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            }
        });

    });
</script>

<hr>
<div class='ligne'>
    $imageEnCours
</div>

<div class='ficheinfo'><label>{$this->_lib['champ']['laboratoire']} : </label><div>{$data['id_laboratoire']} - {$data['laboratoire']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['cacl']} : </label><div>{$data['cacl']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['famille']} : </label><div>[{$data['id_famille']}] {$data['famille']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['sFamille']} : </label><div>[{$data['id_sfamille']}] {$data['sFamille']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['ssFamille']} : </label><div>[{$data['id_ssfamille']}] {$data['ssFamille']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['code_int_ceido_1']} : </label><div>{$data['code_int_ceido_1']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['code_int_ceido_2']} : </label><div>{$data['code_int_ceido_2']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['code_int_ceido_3']} : </label><div>{$data['code_int_ceido_3']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['id_tva']} : </label><div>{$data['id_tva']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['ordre_top']} : </label><div>{$data['ordre_top']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['date_traitement']} : </label><div>{$data['date_traitement']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['produit_actif']} : </label><div>{$data['produit_actif']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['id_produit_lien']} : </label><div>{$data['id_produit_lien']}</div></div>
<div class='ficheinfo'><label>{$this->_lib['champ']['id_produit']} : </label><div>{$data['id_produit']}</div></div>
<div class='ligne'>
    $imageEnCours
</div>
<hr>
</body>
</html>
EOL;
