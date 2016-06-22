# PHP orienté Objet

http://www.elated.com/articles/object-oriented-php-delving-deeper-into-properties-and-methods/

## PHP : Tableau associatif / Objet stdClass

```php

$tablo = [];
$tablo['nom'] = "Paul";
$tablo['prenom'] = "Martin";

$objet = new stdClass();
$objet->nom = "Robert";
$objet->prenom = "Henri";

```

:warning: tableau plus rapide / Class moins gourmandes en mémoire


## Définir des classes d'Objet

#### classes
Définition de la structure et du fonctionnement d'un type d'entité
Les classes permettent de représenter des entités propres à notre application / code.

Exemple
- données : au plus simple un base de données contenant un table
- Jeu : Si je développe un jeu type Space Invaders, différents types d'entités seront utilisés

[méthodes magiques](http://php.net/manual/fr/language.oop5.overloading.php)
  - constructeur : __construct : que lui faut-il , que se passe t il, quand une *instance* est créée
  - __destruct : que se passe t il quand une *instance* est détruite
  - __toString() : renvoie la description textuelle de l'instance ( debug )

#### propriétés
- visiblité : public, protected
  - informations contenues / exposées par une instance ou par une classe ( static )


#### méthodes / fonctions
Une *méthode* est une fonction définie dans une classe.
En POO, elles représentent en quelque sorte les "actions" que peut effectuer une entité.
Là aussi, ce posera la question de la visibilité; les méthodes peuvent être :
- **public**, et être appelées/utilisées depuis *l'extérieur* ()
- ou  **private**, et n'être utilisées qu'au sein de la classe elle-même
- ou  encore **protected**, et

#### [méthode de surcharge magique](http://php.net/manual/fr/language.oop5.overloading.php)
PHP offre des méthodes pour gérer l'accès à des proprietés non définies dans la structure de la classe
- __set / __get : gestion de proprietés indéfinies
- __isset : vérification de l'existance de proprietés indéfinies
- __unset() : suppression de proprietés indéfinies


#### Héritage

Les classes peuvent être étendues, c'est à dire qu'on peut créer une nouvelle classe à partir d'une existante.
Cela permet entre autre de partager une même base de code dans plusieurs classes.

```
class PageView extends BasicView{

    public $title;

    function render(){...}
}

class IndexView extends PageView{
    function render(){...} // override
}
```

Même s'il est souvent tentant d'utiliser l'héritage pour ajouter des fonctionnalités à une classe de base,
l'héritage devrait principalement être utilisé pour des spécialisations.

Normalement, si une classe B étend une classe A, elle devrait avoir la même API.
Par exemple, elle devrait pouvoir redéfinir l'implémentation de certaines méthodes de la classe A ( override ),
mais elle ne devrait pas, en principe, ajouter de nouvelles méthodes publiques.

En réalité, ce principe n'est jamais strictement respecté, mais devrait toutefois être gardé en tête pour limiter les trop longues chaines d'héritages, où les classes pourtant parentes, non plus grand chose à voir les unes avec les autres.

```php
class Neandertal{
    public $cerveau;
    public $machoire;
    public $coeur;
    public $taille;
    public $poids;

    public function marche(){...}
    public function court(){...}
    public function construitOutil(){...}
    public function chasse(){...}
}

class Cromagnon extends Neandertal{ // Cromagnon est un Neandertal qui fait +- les m^ trucs différement
    public function court(){...}
    public function construitOutil(){...}
    public function chasse(){...}
}


class Humanoide extends Cromagnon{ // pour un humanoide, étendre Cromagnon serait moins pertinant / cohérent
    public $processeur;
    public $memoire;
    public $moteur;

    public function court(){...}
    public function construitOutil(){...}
    public function chasse(){...}
}

```

- polymorphisme : Si *B* étend *A*, on peut dire que qu'une instance *b* de la classe **B** EST UN **A** :smile:

**Exemple** : ici la classe Trotinette et Voiture

```php
class Vehicule{
    public function roule(){}
}

class Trotinette extends Vehicule{
    public function roule(){}
}

class Voiture extends Vehicule{
    public function roule(){}
}

class Voyageur{
    public $vehicule;

    function deplace
}

```

#### Interface

Une interface permet de définir un type d'objet non pas en fonction de l'implementation de ses méthodes,
mais seulement sur leur déclaration.

```

``

#### interface

```php
<?php

class MyClass
{
  // proprietés
  // constructeur & méthodes
}

?>
```