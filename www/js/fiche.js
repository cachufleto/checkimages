
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

