# PHP - les bases

+ <a href="http://www.lephpfacile.com/cours/" target="_blank">Le PHP Facile</a>
+ <a href="http://daylerees.com/php-pandas/" target="_blank">PHP Pandas</a>
+ <a href="http://aulas.pierre.free.fr/cou_php_base.html" target="_blank">:memo:Introduction détaillée au PHP :fr:</a>

### Développement Back-end

+ Rappel : Fonctionnement Internet : Client / Serveur

+ Introduction PHP
  + Personal Home Page » PHP : Hypertext Preprocessor
  + langage serveur interpreté
  + exemple
  + http://phpepl.herokuapp.com

+ [LAMP : Linux Apache Mysql PHP](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04)

**Installation**
  + Apache2
  + Mysql
  + PHP5

### PHP

```php

// variables
$nom = "Dupond";
$prenom = 'Jack';
$age = 27;

// fonction
function salut( $nom ){
	echo "Hola ".$nom;
}

salut("Internet");

// tableau
$jours = ["lundi", "mardi", "mercredi", "jeudi","vendredi"];

// tableau associatif ( +-= JS Object )
$notes = [
	"Francais"=> 13,
	"SVT"=> 11,
	"EPS"=>12
];
echo $notes["SVT"];

```

### Exercices

**Accueil / Articles**
Sur une page d'accueil affichez les liens vers trois articles

**Identification Ajax**
créez une page login.html contenant :
- un champ login
- un champ password
- un bouton "login"

Au clic sur le bouton login, via ajax, la page envoie les variables login et password à un fichier login.php

Pour passer les 2 variables login et password au fichier PHP, en mode 'get' :
`login.php?login=toto@gmail.com&password=azerty`

+ si le login/password est correct : login.php renvoie 'ok' » le formulaire est masqué et la page login.html affiche "Bienvenue"

+ sinon login.php renvoie 'error' »  la page login.html affiche "Erreur" au dessus du formulaire


- Correction liste articles / page article

## MYSQL

[:memo:Introduction détaillée à MYSQL :fr:](http://aulas.pierre.free.fr/cou_sql_syntaxe.html)

**Base de données relationnelle**

![exemple table](http://i.stack.imgur.com/ruxKF.png)


** Installation mysql pour PHP ** (ubuntu 15.04)

```bash
sudo apt-get install mysql-server php5-mysql
sudo mysql_install_db
sudo mysql_secure_installation
mysql -u root -p
```

#### Création / destruction de bases de données et de tables

```sql
SHOW DATABASES;
CREATE DATABASE test;
SHOW DATABASES;
DROP DATABASE test;
SHOW DATABASES;

CREATE DATABASE blog;

USE blog

SHOW TABLES;
CREATE TABLE auteurs( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
prenom VARCHAR(30),
nom VARCHAR(30),
mail VARCHAR(40)
);

DESCRIBE auteurs
```

[:memo:Types de colonnes MYSQL court](http://buzut.fr/2012/05/08/les-differents-types-de-colonnes-mysql/)
[:book:Types de colonnes MYSQL détaillé - OC](https://openclassrooms.com/courses/choisir-les-bons-types-de-colonne-sql)

#### Insertion
```sql
INSERT INTO auteurs (`id`, `prenom`, `nom`, `mail`) VALUES (NULL, 'Carl', 'Marques', 'carl.m@gmail.com' );
INSERT INTO auteurs (`id`, `prenom`, `nom`, `mail`) VALUES (NULL, 'Lea', 'Léger', 'leam@gmail.com' );
```

#### Sélection
```sql
SELECT `id`,`prenom`, `nom`, `mail`  FROM auteurs ;
SELECT `id`,`prenom`, `nom`, `mail  FROM auteurs WHERE `prenom`="lea";
```
#### modification
```sql
UPDATE auteurs SET `prenom`="Karl" WHERE `id`=1;
```

#### suppression
```sql
DELETE FROM `auteurs` WHERE id=1;
```

#### Exploration : Créez une/des bases de données, des tables... pays, villes, journal, resultats sportifs

### PHPMyAdmin

```bash
sudo apt-get install phpmyadmin
```

Après installation : <a href="http://localhost/phpmyadmin" target="_blank">ouvrir phpmyadmin</a>

Si dossier non trouvé et qu'aucun *lien* vers phpmyadmin n'existe ds /var/www/html/':

```bash
sudo ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin

sudo service apache2 restart
```

[Guide d'installation](https://doc.ubuntu-fr.org/phpmyadmin)

### AJAX / PHP

**Exercice login ajax - part 2**
En cas d'identification réussie, login.php renvoie des informations au format JSON :
 - le resultat de la requete : 1
 - le nom de l'utilisateur : Pierre Dupont
 - nombre de nouveaux messages : 5

En cas d'erreur seulement
 - resultat de la requete : 0

+ [Correction Login basique](https://github.com/Simplon-lyon/dev-web/tree/master/php/login_basic)
+ [Correction Login Ajax](https://github.com/Simplon-lyon/dev-web/tree/master/php/login_ajax)


#### PHP / MYSQL - Introduction

Il existe plusieurs manières d'accéder à une base de données, mais le principe/process est souvent le même :
+ on crée une connexion à la base de données
+ on décrit une requête
+ on exécute une requête
+ on récupére le résultat
+ on traite le résultat : génération/affichage de HTML ou renvoi de JSON par exemple

+ **[mysqli  - OC](https://openclassrooms.com/courses/maitrisez-mysqli-sans-poo)**

**Sélection**
```php
<?php
if( $connexion = mysqli_connect('localhost', 'root', 'root', 'blog') ){
	$requete = "SELECT * FROM auteurs";

	$reponses  = mysqli_query($connexion, $requete);

	while( $auteur = mysqli_fetch_assoc($reponses) ){
		echo "<div>".$auteur["nom"]."-".$auteur["mail"]."</div>";
	}
	mysqli_free_result($reponses);
} else {
	echo "erreur BDD !";
}
?>
```
**Insertion**

```php
<?php
if( $connexion = mysqli_connect('localhost', 'root', 'root', 'blog') ){
	$requete = "INSERT INTO auteurs(`id`,`prenom`,`nom`,`mail`) VALUES (NULL, 'Li', 'Wang','liwang@gmail.com')";

	$resultat  = mysqli_query($connexion, $requete);

	echo "resultat : ".($resultat ? 'ok':'false');
} else {
	echo "erreur BDD !";
}
?>
```

+ [PDO - OC](https://openclassrooms.com/courses/concevez-votre-site-web-avec-php-et-mysql/lire-des-donnees-2)

```php
<?php
	try
	{
		$connexion = new PDO('mysql:host=localhost; dbname=blog;charset=utf8', 'root', 'root');
	} catch ( Exception $e ){
		die('Erreur : '.$e->getMessage() );
	}

	$requete = "SELECT * FROM auteurs";
	$resultats = $connexion->query($requete);
	while( $auteur = $resultats->fetch() ){
		echo "<div>".$auteur["nom"]."-".$auteur["mail"]."</div>";
	}
	$resultats->closeCursor();
?>
```


### Exercices
+ Imaginez une application de gestion de tâche aka todolist *sauvegardée* en base de données.
  + Quelles informations doivent être enregistrées ? quelle structure de table ?
  + développez l'application

+ Choisissez un blog et essayez d'imaginer sa **structure de données**.

### Défi 1 pour 18/01 : simpllo
+ seul ou à 2 : développer un mini trello avec back-office.
+ publication sur gandi avec Filezilla & sur github


## Formulaire PHP

```html
<form action="ajout.php" method="get">
	<input type="text" name="prenom">
	<input type="text" name="nom">
	<input type="text" name="mail">
	<button>Ajouter</button>
</form>
```

Côté PHP, le traitement peut se faire une fois les variables récupérer via $_GET

```php
if( isset($_GET['nom']) && isset($_GET['prenom'])){
	$connexion = mysqli_connect('localhost', 'root','secret') or die('Erreur de connexion BDD');
	$requete = "INSERT INTO auteurs(`id`,`nom`,`prenom`,`mail`) ";
	$resultat = mysqli_query($connexion, $requete) or die ('Erreur de requête BDD');
	echo $requete === true ? 'Le nouvel auteur a bien été ajouté' : 'Oooops :(';
} else {
	echo 'Données invalides';
}
```

Par défaut, les boutons d'un formulaire déclenchent l'ouverture de la page 'action' du formulaire,
c'est sur cette page que le traitement des données saisies dans le formulaire

#### Méthodes : GET ou POST

Jusqu'à présent on a utilisé la méthode 'get' pour l'envoi de données : les paramètres sont passées dans l'url.
C'est la méthode la plus simple pour comprendre l'envoi de données, mais elle a plusieurs limite :
- ce n'est pas très secure
- il y a un nombre limité de caractères  ( 512 caractères par défaut en PHP )

L'autre méthode 'post', n'affiche pas les données dans l'url et n'a pas les mêmes limites de taille.

```html
<form action="ajout.php" method="get">
	<!-- ... -->
</form>
```

Et côté PHP :

```PHP
if( isset($_POST['nom']) && isset($_POST['prenom'])){
	// ...
} else {
	echo 'Données invalides';
}
```

[:book: W3C - POST ou GET ?](http://www.w3.org/2001/tag/doc/whenToUseGet.html#checklist)


## Dates

On peut utiliser la fonction date() ou un objet DateTime()

+ [date()](http://us1.php.net/manual/fr/function.date.php)

+ [DateTime](http://php.net/manual/fr/class.datetime.php)

[Memo Format date](docs/PHPDateFormat.pdf)

```php
define( "B", "<br/>" );

$maintenant = new DateTime();
echo $maintenant->format('D d-M-Y').B;

$uneDate = new DateTime('2012/12/31');
echo $uneDate->format('d-M-Y H:i:s').B;

// attention au format US mois/jour/annee
$date = new DateTime('01/12/2012 00:01:03');
echo $date->format('d-m-Y H:i:s').B;
```

+ Timestamp : entier représentant le nb de sec écoulées depuis 1/1/1970


#### MYSQL

**requêtes préparées**

```php

<?php
$db = new PDO('mysql:host=localhost; dbname=blog;charset=utf8', 'root', 'secret');

// preparation de la requete
$insertion = "INSERT INTO auteurs(`id`,`nom`,`mail`) ";
$insertion .= "VALUES (NULL, :nom, :mail)";
$requete = $db->prepare($insertion);

// remplissage
$requete->bindParam(':nom', $nom, PDO::PARAM_STR);
$requete->bindParam(':mail', $mail, PDO::PARAM_STR);
$result = $requete->execute(); // renvoie TRUE || FALSE

// la requête pourrait être rappelée plusieurs fois avec de nouvelles valeurs

?>
```

+ **Sauvegarde de mot de passe**

PHP et MySQL proposent des fonctions de [hashage](https://fr.wikipedia.org/wiki/Fonction_de_hachage) permettant de "crypter" les mots de passe
 afin de les rendre illisibles.

ex: SHA('SECRET') = 3c3b274d119ff5a5ec6c1e215c1cb794d9973ac1

**MySQL**

+ insertion
```sql
INSERT INTO users(`mail`,`password`) VALUES ( 'toto@gmail.com', SHA('SECRET'));
```

+ récupération
```sql
SELECT * FROM users WHERE `password`=SHA('SECRET')
```

**PHP**

```php
$code = sha1('SECRET');
```



#### Les Sessions

Les sessions permettent de stocker sur le serveur, des variables associées à un utilisateur.
Ces données sont temporaires, et les sessions et leur données sont détruites à la fermeture du navigateur.


```php
<?php
	session_start();
	if( ! $_SESSION['compteur'] )
		$_SESSION['compteur'] = 0;
	else
		$_SESSION['compteur'] += 1;
	echo "Nombre de vues : ".$_SESSION['compteur'];
?>
<a href="destroy_sessions.php">Effacer</a>
```

[Exemple 1](https://github.com/Simplon-lyon/dev-web/blob/master/php/sessions/sessions.php)

[Exemple 2](https://github.com/Simplon-lyon/dev-web/blob/master/php/sessions/sessions_v2.php)

Typiquement, les sessions sont utilisées pour garder des informations d'identification.
 Une fois l'identification effectuée, le serveur associe des informations, des variables de sessions,
 à l'utilisateur. Ces variables de sessions $_SESSION seront accessibles par tous les scripts PHP,
 et permettront par exemple de savoir si l'utilisateur qui ouvre une page est bien autorisée à le faire.


```php
<?php
	if( !$_SESSION['identifiant']   ){
		// l'utilisateur n'est pas identifié » affichage du formulaire de login
		include('login.php');
	} else if (!$_SESSION['role'] < 3){
		echo "Vous n'avez pas les droits permettant d'accèder à cette page";
	}
// ...
```

+ Destruction de session

```php
session_unset(); // efface les var de session
session_destroy(); // détruit la session
```

[Les sessions ( et les cookies ) sur OC](https://openclassrooms.com/courses/concevez-votre-site-web-avec-php-et-mysql/variables-superglobales-sessions-et-cookies)
[Les sessions sur PHP facile](http://www.lephpfacile.com/cours/18-les-sessions)



:fire: **Tuto SQL**
+ [SQL tutorial - Part 1 : basics :us:](http://net.tutsplus.com/tutorials/other/sql-for-beginners/)
+ [SQL tutorial - Part 2 : index, requêtes avancées, datatypes :us:](http://code.tutsplus.com/tutorials/sql-for-beginners-part-2--net-8274)

### Conception de Bases de données relationnelles

#### [Principes de base de la normalisation des bases de données](https://support.microsoft.com/fr-fr/kb/283878)
[Intro normalisation 2](http://www.phpro.org/tutorials/Introduction-To-Database-Normalization.html#5)

- 1ère forme normale
  + éliminer les répétitions
  + créer une table pour chaque entité distincte
  + définir un chp d'identification unique pour chaque table ( clé primaire )

- 2nde forme normale
  + des tables pour chaque jeu de données pouvant être utilisés à plusieurs reprises
  + créer une clé étrangère entre les tables dépendantes

### Relations entre objets
- one to one : 1 utilisateur a un mail/password
- one to many : 1 utilisateur est propriétaire de plusieurs tâches
- many to many : plusieurs utilisateurs peuvent être proprio de plusieurs tâches

+ [Clés primaire et étrangères - OC :fr:](https://openclassrooms.com/courses/administrez-vos-bases-de-donnees-avec-mysql/cles-primaires-et-etrangeres)
+ [SQL tutorial - Part 3 : Database relationships :us:](http://code.tutsplus.com/tutorials/sql-for-beginners-part-2--net-8274)

**Exemple Todo app**

+ tâches ( task ) : id, titre, etat, description, date_creation, date_completion,...

Est ce que tout le monde peut voir / editer la tâche ? A qui appartient elle ?

+ users : id, mail, nom, password, date_inscription, last_visit

  + si une tâche ne peut appartenir qu'à un user : on pourrait éventuellement ajouter une colonne user_id
  + si on veut prévoir l'éventualité de plusieurs users par tâches » une table de liaison user_task{id_user, id_task}


### Relations entre les tables

+ Clés étrangères » InnoDB / MyISAM

[différences MyISAM / InnoDB](http://www.tux-planet.fr/mysql-les-principales-differences-entre-myisam-et-innodb/)

```sql
CREATE TABLE `users_tasks` (
  `id_user` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```

Il est tout à fait recommandé [d'indexer](http://sql.sh/cours/index) les colonnes liées aux clés étrangères ( KEY est synonyme de INDEX )

```sql
CREATE TABLE `users_tasks` (
  `id_user` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  KEY (`id_task`),
  INDEX  (`id_user`),
  FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
```

**Contraintes : Régles automatisées**

Les clés étrangères ( foreign keys ) permettent également de définir des options de suppressions et/ou de mise à jour.
Pour faire simple, on peut définir que la suppression de l'entité d'une clé étrangère peut provoquer
la suppression des éléments liés.
Exemple : si on supprime le compte de bob@gmail.com, cela supprime automatiquement
les liaisons de la table users_tasks

```sql
CREATE TABLE `users_tasks` (
  `id_user` int(11) NOT NULL,
  `id_task` int(11) NOT NULL,
  KEY `ud_task_fk` (`id_task`),
  KEY `users_fk` (`id_user`),
  CONSTRAINT `users_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  CONSTRAINT `ud_task_fk` FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id_task`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```

Alors concrètement comment ça marche ?!

+ Bob crée une tâche dans la table *tasks*
+ on ajoute une correspondance dans la table users_tasks entre l'id de Bob et l'id de la tâche créée

Pour cela, il est possible de récupérer facilement le dernier id inséré +
+ En SQL : `LAST_INSERT_ID()`,
+ en php, via mysqli : `mysqli_insert_id()` ( ou `mysqli->insert_id`)
+ en php, via PDO : `$db->lastInsertId()`

```php
<?php

$titre = 'Acheter piles';

try
{
    $db = new PDO('mysql:host=localhost; dbname=labz;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
    die('Erreur : '.$e->getMessage() );
}

$requete = "INSERT INTO tasks (`titre`,`date_creation`,`etat` ) VALUES (:titre, NOW(), 0)";
$q = $db->prepare( $requete );
$q->bindParam(":titre", $titre, PDO::PARAM_STR);
$resultats = $q->execute();

if( $resultats ){
    $userId = 1 /* $_SESSION[ 'userId' ]*/;
    $taskId = $db->lastInsertId();
    $q2 = $db->prepare( "INSERT INTO users_tasks(id_user, id_task) VALUES (:userId, :taskId) " );
    $q2->bindParam(":userId", $userId, PDO::PARAM_INT);
    $q2->bindParam(":taskId", $taskId, PDO::PARAM_INT);
    $res_link = $q2->execute();
}

echo $res_link ? "ok" : "error";

?>
```

#### Jointures

Pour effectuer une sélection de données de plusieurs tables, on peut utiliser des jointures.

![jointures](docs/jointure-sql.jpg)

Exemples :

Soit 3 tables :
- users { id_user, mail, password }
- tasks { id_task, titre, etat, date_creation }
- users_tasks { id_user, id_task }

```sql
SELECT mail FROM users
JOIN users_tasks USING(id_user)
WHERE id_task = 1
```
ou
```sql
SELECT mail FROM users
JOIN users_tasks ON users.id_user = users_tasks.id_user
WHERE id_task = 1
```

[Jointures - OC](https://openclassrooms.com/courses/administrez-vos-bases-de-donnees-avec-mysql/jointures-1)
[Jointures SQL](http://sql.sh/cours/jointures)

#### Extras : fonctions SQL

+ ORDER BY
+ LIMIT
+ GROUP BY

+ COUNT(*)

+ IN()
+ LIKE
+ MIN(), MAX(), AVG(), SUM()
+ ...


#### PHP POO

Les bases de données permettent de stocker des jeux de données, représentant des entités / objets.
Ne serait-il pas pratique de pouvoir utiliser le même genre d'objet en PHP ?

Malheureusement, PHP ne connait ni nos *tasks* ni nos *users*... :sad:
Pour pallier à cette ignorance, nous avons la possibilité de déclarer nos propres types d'objets.

Pour ce faire nous allons créer/"déclarer" des *classes* : des définitions de types d'objets
que notre application manipule/utilise.

Plutôt que de manipuler des objets "indéfinis", des tableaux aux propriétés infinies,

type `array("id"->1, "titre"->"acheter du pain")`,

nous pourrions manipuler des entités aux caractéristiques "strictement connues",
choisies par nos soins pour répondre à nos besoins :
des tâches définies par : un id, un titre, une date, un état. NI PLUS NI MOINS!

exemple : `$task->titre`

```php
<?php
class Task{

    var $id;
    var $title;
    var $date_creation;
    var $completed;
}

$tache1 = new Task();
$tache1->title = 'test';
$tache1->date_creation = new DateTime();
$tache1->completed = true;

print_r( $tache1);
?>
```

Cette classe nous permet de déclarer l'existence, au sein des scripts PHP,
d'un type d'objet Task, défini par un id, un titre, une date de création et un état ( completé ou pas).

```php

<?php
class Task{

	public $id;
	public $title;
	public $date_creation;
	public $completed;

	function __construct($id, $title, $date, $completed) {
		$this->id = $id;
		$this->title = $title;
		$this->date_creation = $date;
		$this->completed = $completed;
	}

	function __toString ()
	{
		return "Tâche : [$this->id] $this->title ";
	}
}

$uneTache = new Task( 1, 'acheter du pain', new DateTime(), true );

echo $uneTache;

?>
```

[:tv: PHP POO - Grafikart](https://www.grafikart.fr/formations/programmation-objet-php)
π
[:book: PHP POO - OC](https://openclassrooms.com/courses/programmez-en-oriente-objet-en-php)

:question: (Guide Gandi - Simple Hosting)[https://wiki.gandi.net/fr/simple]

[:tv: PHPStorm tutos](https://www.youtube.com/playlist?list=PLQ176FUIyIUbfeFz-2EbDzwExRlD0Bc-w)

[:tv: PHP Storm - Deployment & Remote Host](https://www.youtube.com/watch?v=AHK20LWEWXQ)


#### [Wordpress](http://fr.wordpress.org)
- installation
- prise en main du backo
- thèmes
- personnalisation

#### Correction Donatello - [PHP simple](https://github.com/Simplon-lyon/donatello-basic)

#### Logs PHP

```php
error_log( "test de log : ".mktime() );
```

Fichier de log apache : `/var/log/apache2/error.log`

```bash
$ tail -F /var/log/apache2/error.log
```

### PHP : Typage

- [typage](http://php.net/manual/fr/language.oop5.typehinting.php) / [Les types PHP](http://php.net/manual/fr/language.types.php)

Lorsqu'une fonction est appellée avec des arguments,
elle s'attend à recevoir un certain type de données.

Le javascript est un langage *non typé*, il ne permet pas ce genre de précision ( d'où [Typescript](http://www.typescriptlang.org) ...).
PHP5 permet un peu de typer, et PHP7 encore un peu plus.

Certaines fonctions PHP attendent des paramètres d'un certain type :

```php
echo array_sum([4,7]);
echo array_sum(8); // warning : array attendu
```

Pour nos fonctions aussi nous allons pouvoir préciser les types des paramètres attendus.

```php
<?php
function min( array $valeurs ){
	//
}
?>
```
:warning: en PHP5 on ne peut pas typer les paramètres avec des valeurs *scalaires* int, float, boolean, string.

Par contre on va pouvoir utiliser nos propres types d'objets, nos classes

### PHP : Définition

- classes
 - propriétés / attributs
 - constantes
 - constructeur
 - méthodes
   + [arguments et méthodes](http://php.net/manual/fr/functions.arguments.php)
- [instanceof](http://php.net/manual/fr/language.operators.type.php)
- héritage
- Interfaces

+ <a href="https://github.com/Simplon-lyon/dev-web/wiki/docs/intro_poo_php.pdf" target="_blank">Support intro POO PHP PDF</a>

```php
<?php
class Panier{
	// constantes
	const FRAIS_PORT = 7.2;

	private $client;

	// propriétés
	public $produits;

	public function getTotal(){
		//
	}

	// constructeur
	function __construct(Client $client) {
		error_log('nouveau panier...' );
	}

	// méthodes
	function ajouteProduit(Produit $produit){
		$this->produits[] = $produit; // ajoute un element à un tableau == array_push($tableau, $item);
	}
}

class Produit{
// ...
}

class Client{
// ...
}

?>
```
+ [**Exemple classes Formes**](https://github.com/Simplon-lyon/dev-web/tree/master/php/intro_poo/formes)
+ [**Exemple classes Panier**](https://github.com/Simplon-lyon/dev-web/tree/master/php/intro_poo/panier)

+ Documentation du code `/** ... */`

+ [:memo: PHP POO - OC](https://openclassrooms.com/courses/programmez-en-oriente-objet-en-php)

+ [:tv: PHP POO - Grafikart](https://www.grafikart.fr/formations/programmation-objet-php)

+ [:book: Design patterns tête la première](https://www.google.fr/search?q=design+pattern+t%C3%AAte+la+premi%C3%A8re+-+Recherche+Google&oq=design+pattern+t%C3%AAte+la+premi%C3%A8re+-+Recherche+Google&aqs=chrome..69i57.206j0j7&sourceid=chrome&es_sm=91&ie=UTF-8#q=design+pattern+t%C3%AAte+la+premi%C3%A8re)
+ :fire: [:book: Design patterns tête la première](https://www.google.fr/search?q=design+pattern+t%C3%AAte+la+premi%C3%A8re+-+Recherche+Google&oq=design+pattern+t%C3%AAte+la+premi%C3%A8re+-+Recherche+Google&aqs=chrome..69i57.206j0j7&sourceid=chrome&es_sm=91&ie=UTF-8#q=design+pattern+t%C3%AAte+la+premi%C3%A8re)

+ [:book: Référence php.net](http://php.net/manual/fr/language.oop5.php)

## Annexes

+ [PHP : plus loin avec variables OC](https://openclassrooms.com/courses/allez-plus-loin-avec-les-variables)
+ [PHP - Espaces de nom](https://openclassrooms.com/courses/les-espaces-de-noms-en-php)


+ Exploration PHP :
  + Espace de noms
  + Traits
  + [Slim](http://www.slimframework.com), [Lumen](https://lumen.laravel.com), [Silex](http://silex.sensiolabs.org)
  + [Composer](https://getcomposer.org)


## Silex

+ [Introduction à Silex](https://openclassrooms.com/courses/premiers-pas-avec-le-framework-php-silex)
+ [Evoluer vers une architecture PHP professionnelle](https://openclassrooms.com/courses/evoluez-vers-une-architecture-php-professionnelle)


## PHP : Autoload

[Exemple](https://github.com/Simplon-lyon/dev-web/tree/master/php/autoload)

## PHP : Namespaces / Espaces de noms

Les namespaces permettent d'organiser ses classes ( et aussi fonctions et constantes depuis PHP 5.6 ) en packages.
[Exemple](https://github.com/Simplon-lyon/dev-web/tree/master/php/nspaces)

## [Composer](https://getcomposer.org/doc/00-intro.md)

Composer est un gestionnaire de packages/librairies pour PHP.

#### [Installation ](https://getcomposer.org/download/)

```bash
php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin/composer
```

#### [Utilisation](https://getcomposer.org/doc/01-basic-usage.md)

+ **composer.json** : permet de décrire les dépendances d'un projet

```json
{
  "require":{
    "monolog/monolog":"1.0.*"
  }
}
```

+ composer install : installe les dépendances
```bash
composer install
```
+ composer update

```json
{
  "require":{
    "monolog/monolog":"1.17.*"
  }
}
```

+ composer require

+ [packagist](https://packagist.org)

+ composer autoload

exemple : autoload des classes trouvées ds `src/`
```json
{
"require":{},
"autoload": { "psr-4": { "App\\": "src/"} }
}
```
» nécessite de regénérer les classes d'autoload

```bash
composer dump-autoload
```

#### Création d'un virtual host

+ création d'un dossier pour nouveau projet et ajout d'un lien symbolique `ln -s` dans /var/www/
```bash
cd ~/sites
mkdir mon-projet
ln -s ~/sites/mon-projet /var/www/mon-projet
```

+ Définition d'une redirection locale du domaine mon-projet.com dans /etc/hosts
```bash
sudo vim /etc/hosts
```
  + Ajouter 1 ligne : `127.0.0.1 mon-projet.com`

+ créer un fichier de configuration pour le vhost
```bash
cd /etc/apache2/sites-available
sudo touch monprojet.conf
sudo vim monprojet.conf
```
+ ajouter le fichier de conf vhost à apache
```bash
sudo a2ensite monprojet.conf
```


```
# monprojet.conf
<Virtualhost :*>
ServerAdmin serveradmin@bbgi.com
    DocumentRoot /home/drupal_1
    ServerName mysite.com
    ServerAlias www.mysite.com
	<Directory /var/www/monprojet>

		Options Indexes FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
</Virtualhost>
```

+ Redémarrer apache
```bash
sudo service apache2 reload
sudo service apache2 restart
```

+ .htaccess
```
<IfModule mod_rewrite.c>
    Options -MultiViews

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```


Pour autoriser la ré-écriture depuis le .htaccess
```bash
sudo a2enmod rewrite
```

» var/apache2/sites-availables » AllowOverride All

+ web/index.php

**[Silex](http://silex.sensiolabs.org)**

- installation

```bash
composer require silex/silex
```


#### Routes & actions

  $app->get('/',function(){
  	// retourne la réponse
  });


- views / twig templates
  + [Twig](http://twig.sensiolabs.org/)
  + views
- routes
  + post('/',...)

- [Sessions](http://silex.sensiolabs.org/doc/providers/session.html)

# Annexes
**Apache**
+ [:tv: Installer serveur LAMP](https://www.grafikart.fr/formations/serveur-linux)
+ [https://serversforhackers.com/series](https://serversforhackers.com/series)
+ [Intro Apache](https://doc.ubuntu-fr.org/projets/ecole/apache)
+ [Apache 2 Ubuntu](https://doc.ubuntu-fr.org/apache2)
+ [VirtualHost avec apache2 / ubuntu](https://doc.ubuntu-fr.org/tutoriel/virtualhosts_avec_apache2)
+ [Gestion de permissions](http://cyberzoide.developpez.com/unix/droits.php3)

+ [Ubuntu CentOS Debian](http://inthebox.webmin.com/choosing-a-linux-distribution-for-web-server)

+ [Boilerplate Silex/Bootstrap](https://github.com/aptoma/silex-bootstrap)


+ [Composer presentation](http://fr.slideshare.net/jasongr/composer-23263197)
+ [.htaccess](http://wiki.apache.org/httpd/Htaccess)

+ **[Doctrine](http://docs.doctrine-project.org/en/latest/)**



### Défis
  - Gestion de todo Vanilla PHP OO / Doctrine (API JSON || Twig)
  - Gestion de todo Silex / Doctrine



- Techlunch : PHPStorm
  - projet et modèle de projet
  - gestion Database
    - accès contenu des tables
    - accès console pour test SQL
  - live templates : snippets / raccourcis de code » pour créer les siens : "Save as live template..."
  - Git cf. settings/version Control & panneau Version Control
  - FTP : Menu Tools / Deployment / Configuration » config (S)FTP »



### PHP POO

+ Classes abstraites

Classe de base, définissant des méthodes et des propriétés, mais destinée à ne pas être instanciée
Seules les classes qui hériteront de la classe abstraites pourront être instanciés


```php
abstract class ObjectManager{
	public $tableName;

	public function connect(){
		//
	}

	public function removeItem(itemId){
		$q = "DELETE FROM $tableName WHERE id=:id";
		// ...
	}
}
```

+ Traits : ajouter des fonctionnalités à plusieurs classes sans lien d'héritage


**Rappels**

+ [Composer](composer)

### <a href="https://phpunit.de" target="_blank">PHP_Unit</a>

```bash
$ composer global require phpunit/phpunit
```

+ <a href="https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html" target="_blank">Tests avec PHP Unit</a>

### [Symfony3](http://symfony.com)

- <a href="http://symfony.com/download" target="_blank">installation</a>
  - <a href="https://github.com/symfony/symfony-installer" target="_blank">Symfony installer</a>

```bash
$ symfony new mon_projet
$ cd mon_projet
$ php bin/console server:run
```
Ouvrir <a href="https://localhost" target="_blank">localhost:8000</a>

**projet demo**

```bash
$ symfony demo
$ cd symfony_demo
$ php app/console server:run
```

#### POO

Une des raisons d'être de la POO est d'offrir un ensemble d'outils et de concepts,
permettant d'obtenir du code "simple" à faire **évoluer**.

- **le typage** permet d'assurer la cohérence du code
- **l'héritage** permet de créer des déclinaisons d'une même entité "originelle"
- les **interfaces** permettent de définir des catégories d'objet, définies par des "savoirs-faire" ( des méthodes ), et sans origine communes

- le principe d'**encapsulation**, invite à réfléchir à la construction des objets en distinguant leur "partie visible" (API) de leur mécanismes internes (private, protected).
- le principe de **composition**, préconise qu'une entité ne doit pas gérer trop de chose différentes,
et qu'en **déléguant** des sous-tâches à d'autres entités,
le système est plus souple qu'en créant des monstres "multi-tâches"

- les **design patterns** sont des schema/stratégies pour régler de manière "souples" à l'aide d'outils de la poo,
des problématiques récurrentes de la programmation logicielle ( faciliter l'ajout de nouveaux types , de nouvelles fonctionnalités, permettre l'annulation de commandes, )

- **MVC / Model-View-Controller** est un agglomérat de design pattern destiné à organiser la séparation données / vue / interactions

- **injection de dépendances** ( inversion de contrôle ) : amène l'idée que si une entité à besoin d'autres entités,
 il est préférable de déléguer la construction des autres entités ( les dépendances ).


- [:tv: POO PHP](https://www.grafikart.fr/formations/programmation-objet-php)

:book: Lecture conseillée :
<a href="https://books.google.fr/books/about/Design_patterns.html?hl=fr&id=zzdn6U95_f8C" target="_blank">Design pattern la tête la 1ère</a>


+ [PHP the right way](http://www.phptherightway.com)

## Symfony

- <a href="http://symfony.com/doc/current/quick_tour/the_big_picture.html" target="_blank">quick tour </a>(Big picture, View, Controllers, Architecture)
- parcourez les contrôleurs et les vues du projet symfony_demo,
- essayez d’appliquer ce que vous comprenez dans un nouveau projet : modifier la page d’index par défaut, ajouter un lien vers une autre page, créer le contrôleur et la vue twig de cette nouvelle page… au mieux essayez de refaire un (bout de) projet php existant avec Symfony
- mettre à jour votre compte Github, au minimum :
- fichier README avec lien vers demo et cours descriptif des sujets étudiés dans le projet


### config symfony
- redirection vers ss-dossier 'symfony_demo'
```
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /symfony_demo
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ web [QSA,L]
</IfModule>
```
