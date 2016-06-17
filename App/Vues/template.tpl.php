<!doctype html>
<html lang="fr">
<?php
$body = $__app->routeur[$__app->page]['controleur'];
$titre = $app->_lib['titre'][$body];

echo <<< EOL
<head>
    <meta charset="utf-8">
    <title>$titre</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js"></script>
</head>
<body class="$body">
$contentPage;
<div class="debug">
$contentDebug;
</div>
</body>
</html>
EOL;
