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
    'controleur' => 'Upload',
    'action' => 'listeAction'
    ],

'existant' => [
    'controleur' => 'Upload',
    'action' => 'existantAction'
    ],

'photo' => [
    'controleur' => 'Upload',
    'action' => 'photoAction'
    ],

'select' => [
    'controleur' => 'Upload',
    'action' => 'selectAction'
    ]
];