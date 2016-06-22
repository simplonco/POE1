<?php

$articles = [
    ["id" => "1", "titre" => "Article 1", "contenu" => "Ceci est le contenu de l'article 1..."],
    ["id" => "2", "titre" => "Article 2", "contenu" => "Ceci est le contenu de l'article 2..."],
    ["id" => "3", "titre" => "Article 3", "contenu" => "Ceci est le contenu de l'article 3..."],
];

function renderArticles()
{
    global $articles;

    $articlesView = '';
    foreach ($articles as $a) {
        $articlesView .= '<p><a href="' . $_SERVER["PHP_SELF"] . '?articleId=' . $a['id'] . '">' . $a['titre'] . '</a></p>';
    }

    return $articlesView;
}

?>

<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<?php echo "<h1>Labérration</h1>" ?>

<?php echo renderArticles() ?>

</body>
</html>