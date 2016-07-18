<?php

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

'local' => [
    'controleur' => 'Upload',
    'action' => 'localAction'
    ],
        
'upload' => [
    'controleur' => 'Upload',
    'action' => 'indexAction'
    ],
    

'netoiller' => [
        'controleur' => 'Upload',
        'action' => 'netoillerAction'
    ],

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
    'action' => 'indexAction'
    ],

'ficheimage' => [
    'controleur' => 'Checkimages',
    'action' => 'ficheImage'
    ],

'fichemedicament' => [
    'controleur' => 'Medicaments',
    'action' => 'ficheProduit'
    ],

'ficheparapharmacie' => [
    'controleur' => 'Parapharmacie',
    'action' => 'ficheProduit'
    ],
    
'checkerMed' => [
    'controleur' => 'Upload',
    'action' => 'medAction'
    ],

'checkerPara' => [
    'controleur' => 'Upload',
    'action' => 'paraAction'
    ]
];