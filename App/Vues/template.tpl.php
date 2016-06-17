<!doctype html>
<html lang="fr">
<?php
$body = isset($__app->routeur[$__app->page])? $__app->routeur[$__app->page]['controleur'] : 'Site';
$titre = $app->_lib['titre'][$body];

echo <<< EOL
<head>
    <meta charset="utf-8">
    <title>$titre</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/$body.css">
    <script src="js/script.js"></script>
</head>
<body>
$contentPage;
<div class="debug">
$contentDebug;
</div>
</body>
</html>
EOL;
