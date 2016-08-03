
function fiche_para (id)
{
    document.getElementById('descriptif').style.display="none";
    document.getElementById('conseils').style.display="none";
    document.getElementById('composition').style.display="none";
    document.getElementById('bt_descriptif').style.backgroundColor ="#92D400";
    document.getElementById('bt_conseils').style.backgroundColor ="#92D400";
    document.getElementById('bt_composition').style.backgroundColor ="#92D400";

    document.getElementById('bt_' + id).style.backgroundColor ="#666666";
    document.getElementById(id).style.display="block";
}

function controle_notice(denom_courte)
{
    if (document.getElementById('notice_panier').checked == false)
    {
        alert("Veuillez confirmer avoir bien pris connaissance de la notice du médicament '" + denom_courte + "'")
    }
    else
    {
        document.getElementById('ajout_panier').submit();
    }
}

// --------------------------------------------------------------------------------------------------------------------------------
function ouvre_confirmation()
{
    document.getElementById('confirmation').style.display="block";
    window.setTimeout(ferme, 3000);
}
function ferme_confirmation()
{
    document.getElementById('confirmation').display="none";
}
function display_or_not(id)
{
    if(document.getElementById(id).style.display=='block')
    {
        document.getElementById(id).style.display='none';
    }
    else
    {
        document.getElementById(id).style.display='block';
    }
}

function afficher_cacher(id)
{
    if(document.getElementById(id).style.visibility=="visible")
    {
        document.getElementById(id).style.visibility="hidden";
    }
    else
    {
        document.getElementById(id).style.visibility="visible";

    }
}

function marquee_over(id)
{
    var div = document.getElementById(id)
    if (div) {
        div.style.visibility="visible";
    }
}

function marquee_out(id)
{
    for (i = 1; i <  200; i++)
    {
        var div = document.getElementById(id)
        if (div) {
            div.style.visibility="hidden";
        }
    }
}


// --------------------------------------------------------------------------------------------------------------------------------

function ferme_div(id)
{
    document.getElementById(id).style.visibility="hidden";
}

// --------------------------------------------------------------------------------------------------------------------------------

function connexion_patient (v1, v2)
{
    var v1 = document.getElementById(v1).value;
    var v2 = document.getElementById(v2).value;
    if (v1 =='' || v2 ==''){
        alert('Veuillez renseigner votre identifiant (adresse email) et/ou votre mot de passe ');
    }
    else
    {
        form_log.submit();
    }
}

function texte_accueil ()
{

    if (fleche_haut.style.display == "none") {
        document.getElementById('fleche_bas').style.display="none";
        document.getElementById('fleche_haut').style.display="block";
        document.getElementById('accueil').style.height="auto";
    }
    else
    {
        document.getElementById('fleche_haut').style.display="none";
        document.getElementById('fleche_bas').style.display="block";
        document.getElementById('accueil').style.height="50px";
    }
}


function fiche_para (id)
{
    document.getElementById('descriptif').style.display="none";
    document.getElementById('conseils').style.display="none";
    document.getElementById('composition').style.display="none";
    document.getElementById('bt_descriptif').style.backgroundColor ="#92D400";
    document.getElementById('bt_conseils').style.backgroundColor ="#92D400";
    document.getElementById('bt_composition').style.backgroundColor ="#92D400";
    document.getElementById('bt_' + id).style.backgroundColor ="#666666";
    document.getElementById(id).style.display="block";
}

function ouvre_div_sf_services(id)
{
    ferme_div_services()
    var div = document.getElementById(id)
    if (div) {
        setTimeout(function(){$("#"+id).slideDown(200)}, 0);
    }
}

function ferme_div_services()
{

    for (i = 1; i <  30; i++)
    {
        var div = document.getElementById('bt_plus_'+i)
        if (div) {
            div.style.display="none";
        }
    }
}

// --------------------------------------------------------------------------------------------------------------------------------

function ouvre_div_sf(id)
{
    ferme_toutes_div_sf()
    var div = document.getElementById(id)
    if (div) {
        setTimeout(function(){$("#"+id).slideDown(100)}, 0);
    }
}

function ferme_toutes_div_sf()
{
    for (i = 1; i <  150; i++)
    {
        var div = document.getElementById('conteneur_sf_'+i)
        if (div) {
            div.style.display="none";
        }
    }
    ferme_div_services()
}

function ouvre_div_ssf(id)
{
    var div = document.getElementById(id)
    if (div) {
        setTimeout(function(){$("#"+id).slideDown(100)}, 0);
    }
}

function ferme_div_ssf(id)
{
    setTimeout(function(){$("#"+id).slideUp(0)}, 0);
}

function ferme_toutes_div_ssf()
{
    for (i = 1; i <  150; i++)
    {
        var div = document.getElementById('conteneur_ssf_'+i)
        if (div) {
            div.style.display="none";
        }
    }
}

// --------------------------------------------------------------------------------------------------------------------------------

var maDiv;
function ferme(id, duree)
{
    maDiv=setTimeout(ferme_div, duree, id);
}

function clear_div(id)
{
    clearTimeout(maDiv);
}

function retour()
{
    window.history.back()
}

function goto_url(lien){
    window.location.href=lien;
}

window.onload = creat_iframe_recherche;

function creat_iframe_recherche() {
    var ifr = document.createElement('iframe');
    var ifr_recherche_paramed = document.createElement('iframe');
    ifr_recherche_paramed.id = 'id_frame_recherche_paramed';
    document.getElementById("div_recherche_paramed").appendChild(ifr_recherche_paramed);
    document.getElementById('id_frame_recherche_paramed').style.width = '100%';
    document.getElementById('id_frame_recherche_paramed').style.height = '290px';
    document.getElementById('id_frame_recherche_paramed').style.visibility='visible';
    document.getElementById('id_frame_recherche_paramed').style.border = 0;
}

function afi_result_recherche_paramed(motcle) {
    var lemotcle = motcle;
    var length = motcle.length;
    if(length >= 3)
    {
        document.getElementById('id_frame_recherche_paramed').src= "https://www.pharmaplay.fr/communs_recherche.asp?motcle="+lemotcle;
        document.getElementById('div_recherche_paramed').style.display='block';
    }
    else
    {
        document.getElementById('div_recherche_paramed').style.display='none';
    }
}

function aff_txt_produitvisite(id, demonination)
{
    var div = document.getElementById(id)
    document.getElementById(id).innerHTML = demonination + '...';
    setTimeout(function(){$("#"+id).slideDown(200)}, 0);
}
//ouverture informations pour pharmaplay.fr et .net
jQuery(function($){
    $('a.poplight').on('click', function() {
        var popID = $(this).data('rel');
        var popWidth = $(this).data('width');
        $('#' + popID).fadeIn().css({ 'width': popWidth}).prepend('<a href="#" class="close"><img src="https://www.pharmaplay.fr/s/im/close_pop.png" class="btn_close" title="Fermer" alt="Fermer" /></a>');
        var popMargTop = ($('#' + popID).height() + 80) / 2;
        var popMargLeft = ($('#' + popID).width() + 80) / 2;
        $('#' + popID).css({
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });
        $('body').append('<div id="fade"></div>');
        $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
        return false;
    });
//Close
    $('body').on('click', 'a.close, #fade', function() { //Au clic sur le body...
        $('#fade , .popup_block').fadeOut(function() {
            $('#fade, a.close').remove();
        });
        return false;
    });
});
