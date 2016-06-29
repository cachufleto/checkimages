<?php
/* 'medicament' => [
       'controleur' => 'Site',
        'action' => 'medicamentAction'
    ],

*/
$_r = [
'accueil' => [
    'controleur' => 'Site',
    'action' => 'indexAction'
    ],

'404' => [
    'controleur' => 'Site',
    'action' => 'erreur404Action'
    ],

'medicament' => [
        'controleur' => 'Medicaments',
        'action' => 'indexAction'
    ],

'parapharmacie' => [
        'controleur' => 'Parapharmacie',
        'action' => 'indexAction'
    ],

'import' => [
    'controleur' => 'Import',
    'action' => 'importAction'
    ],

'raport' => [
    'controleur' => 'Raport',
    'action' => 'raportAction'
    ],

'upload' => [
    'controleur' => 'Checkimages',
    'action' => 'uploadImagesLocal'
    ],
/*
'upload' => [
    'controleur' => 'Upload',
    'action' => 'listeAction'
    ],*/
/*
'existant' => [
        'controleur' => 'Upload',
        'action' => 'existantAction'
    ],
    */
'existant' => [
    'controleur' => 'Checkimages',
    'action' => 'indexAction'
    ],
    
'photo' => [
    'controleur' => 'Upload',
    'action' => 'photoAction'
    ],

'existantimage' => [
    'controleur' => 'Checkimages',
    'action' => 'imageAction'
    ],

'ficheproduit' => [
    'controleur' => 'Medicaments',
    'action' => 'ficheProduit'
    ]
];