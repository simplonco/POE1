<?php

define("TITLE", "<h1>UEFA</h1>");
define("B", "<br/>");
define("PATH_DATA", "competition.json");
define("PATH_APP", $_SERVER['PHP_SELF']);

/**
 * stdClass : structure de données d'une competition
 */
global $competition;

function initData($path)
{
    global $competition;
    $data = file_get_contents($path);
    $competition = json_decode($data);
}

/**
 * renvoie le rendu html d'une compétition
 * @return string
 */
function renderIndex():string
{
    initData(PATH_DATA); 

    $content = TITLE;

    $content .= getIndexView();

    return $content;
}

function renderHeader($compet):string
{
    return tag('h1', $compet->name);
}


/**
 * renvoie l'affichage html d'une description json de competition
 * @return string
 */
function getIndexView():string
{
    global $competition;

    $content = "";
    $content .= renderHeader($competition) /*p($competition->name)*/
    ;

    $content .= getGroupsViews($competition->groups);

    return $content;
}

/**
 * renvoie l'affichage html d'une liste de groupes
 * @param array $groups
 * @return string
 */
function getGroupsViews(array $groups):string
{
    $content = '';
    foreach ($groups as $group) {
        $content .= getGroupView($group);
    }
    return $content;
}

/**
 * renvoie le rendu html d'un groupe
 * @param $group
 * @return string
 */
function getGroupView($group)
{
    $content = ahref(PATH_APP . '?selectedGroupId=' . $group->id, $group->id);
    foreach ($group->teams as $teamInfo) {
//        echo "<pre>";
//        var_dump($teamInfo);
        $content .= p(img($teamInfo->flag).$teamInfo->nom);
    }
    return $content;
}

/**
 * rendu d'une page de groupe : nom du groupe es
 * @param string $groupId
 * @return string
 */
function renderGroupPage(string $groupId):string
{
    global $competition;

    initData(PATH_DATA);

    // TODO sécuriser : gérer id invalides
    $selectedGroups = array_filter(
        $competition->groups,
        function ($group) use ($groupId) {
            //echo $groupId." / " .$group->id.B;
            return $group->id == $groupId;
        });
    if( count($selectedGroups)>0 )
        $selectedGroup = $selectedGroups[array_keys($selectedGroups)[0]];

    if( count($selectedGroups)<=0) {
        $content = ahref(PATH_APP, "Retour aux groupes");
        $content .= tag("p","Ce groupe n'existe pas");
        return $content;
    }

    $content = renderHeader($competition);
    $content .= ahref(PATH_APP,"Retour aux groupes" );
    $content .= renderGroupMatches($selectedGroup);

    return $content;
}

/**
 * renvoie le rendu de la liste de matchs possible ds un groupe
 * @param $group
 * @return string
 */
function renderGroupMatches($group):string
{
    $teams= $group->teams;
    $count = 0;
    $matches = array_map( function($team) use( $teams , &$count){
        $content = '';
        for($i = $count; $i < 4 ; $i++ ){
            $t = $teams[$i];
            if( $t != $team )
                $content .= p(img($team->flag).$team->nom . '-' . $t->nom.img($t->flag));
        }
        $count++;
        return $content;
    } , $group->teams );

    return implode($matches);
}

/**
 * entoure un texte de balise <p>...</p>
 * @param string $str
 * @return string
 */
function p(string $str):string
{
    return '<p>' . $str . "</p>";
}

/**
 * entoure un texte d'une balise <p>...</p>
 * @param string $tag
 * @param string $str
 * @return string
 */
function tag(string $tag, string $str):string
{
    return "<" . $tag . ">" . $str . "</" . $tag . ">";
}

/**
 * renvoie un lien html basé sur une url et un texte affiché
 * @param string $url
 * @param string $str
 * @return string
 */
function ahref(string $url, string $str):string
{
    return '<a href="' . $url . '">' . $str . "</a>";
}

/**
 * renvoie une image basée sur une url
 * @param string $url
 * @return string
 */
function img(string $url):string
{
    return '<img class="flags" src="' .$url . '"></img>';
}


if (isset($_GET['selectedGroupId'])) {
    $selectedId = $_GET['selectedGroupId'];
    //echo tag('h1', $selectedId);

    $pageContent = renderGroupPage($selectedId);
} else
    $pageContent = renderIndex();

?>

<!doctype html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<?php echo $pageContent ?>

</body>
</html>