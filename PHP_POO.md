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

#### Classes
Définition de la structure et du fonctionnement d'un type d'entité
Les classes permettent de représenter des entités propres à notre application / code.

Exemple
- données : au plus simple un base de données contenant un table
- Jeu : Si je développe un jeu type Space Invaders, différents types d'entités seront utilisés

[méthodes magiques](http://php.net/manual/fr/language.oop5.overloading.php)
  - constructeur : __construct : que lui faut-il , que se passe t il, quand une *instance* est créée
  - __destruct : que se passe t il quand une *instance* est détruite
  - __toString() : renvoie la description textuelle de l'instance ( debug )

#### Propriétés / Attributs
- visiblité : public, protected
  - informations contenues / exposées par une instance ou par une classe ( static )


#### Méthodes / Fonctions
Une *méthode* est une fonction définie dans une classe.
En POO, elles représentent en quelque sorte les "actions" que peut effectuer une entité.
Là aussi, ce posera la question de la visibilité; les méthodes peuvent être :
- **public**, et être appelées/utilisées depuis *l'extérieur* ()
- ou  **private**, et n'être utilisées qu'au sein de la classe elle-même
- ou  encore **protected**, et dans ce cas être accessible depuis la classe et ses "descendantes"

Les méthodes peuvent également être **static**,

#### [Méthodes de surcharge magique](http://php.net/manual/fr/language.oop5.overloading.php)
PHP offre des méthodes pour gérer l'accès à des proprietés non définies dans la structure de la classe
- __set / __get : gestion de proprietés indéfinies
- __isset : vérification de l'existance de proprietés indéfinies
- __unset() : suppression de proprietés indéfinies


#### Héritage

Les classes peuvent être étendues, c'est à dire qu'on peut créer une nouvelle classe à partir d'une existante.
Cela permet entre autre de partager une même base de code dans plusieurs classes.

```
class BasicView{
    public $backgroundColor;

    protected function render():string{...}
}


class PageView extends BasicView{

    public $title;

    function render() :string{
        parent::render();
        // adaptation
    }
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

- polymorphisme
Si *B* étend *A*, on peut dire que qu'une instance *b* de la classe **B** EST UN **A**


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

    function deplace(){
        $this->vehicule->roule();
    }
}

```
On pourrait plutôt utiliser une Interface

```php

interface InterfaceVehicule{

    function roule();
}

class Vehicule{
    public function roule(){}
}

class Trotinette extends Vehicule{
    public function roule(){}
}


class VehiculeMoteur{
    public function roule(){}
}

class Voiture extends Vehicule{
    public function roule(){}
}

class Voyageur{
    /**
    * @var InterfaceVehicule
    */
    //public $vehicule;

    function deplace(InterfaceVehicule $vehicule ){
        $this->vehicule->roule();
    }
}

```



#### Interface

Une interface permet de définir un type d'objet non pas en fonction de l'implementation de ses méthodes,
mais seulement sur leur déclaration.

Une interface déclare ainsi les **méthodes publiques** qu'une classe doit contenir pour implémenter une interface.

On ne peut pas instancier une interface, c'est juste un type de catégorisation plus souple que le "typage par classe".

```php
<?php
interface View{
    function render():string;
}
```


#### Abstract
Une classe abstraite est un mélange d'héritage et d'interface :
- elle permet de partager une *implémentation*
- elle ne peut pas être instanciée

Classe de base, définissant des méthodes et des propriétés, mais destinée à ne pas être instanciée
Seules les classes qui hériteront de la classe abstraites pourront être instanciées


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

#### Erratums

- Il est possible de passer des functions en paramètre de fonctions - [Exemples](exemples/fonction_anonymes.php)

- Lorsqu'on type un retour de fonction, une fonction ne peut pas renvoyer `null`

:warning: **Différences PHP5.x / PHP7**

- PHP 5.x : pas de typage de renvoi ( la bonne pratique est de précise le typage de retour dans la PHPDoc)
- PHP 5.x : typage des paramètres sauf types scalaires (int, float, string, bool)

#### Classes, fichiers, répertoires et namespaces

Les namespaces permettent d'organiser ses classes ( et aussi fonctions et constantes depuis PHP 5.6 ) en packages.

**co/simplon/exemple/Utils.php**
```php
<?php
namespace co\simplon\exemple;
class Utils{}
?>
```

**index.php**
```php
<?php
use co\simplon\exemple\Utils;

$util = new Utils();
// OU sans le use ...
$util = new co\simplon\exemple\Utils();
?>
```

[Exemple](https://github.com/Simplon-lyon/dev-web/tree/master/php/nspaces)


#### Traits
Les [traits](http://php.net/manual/fr/language.oop5.traits.php) permettent d'ajouter/injecter des fonctionnaltiés ( propriétés et/ou méthodes ) dans des classes.
( des systèmes assez proches portent d'autres noms dans d'autres langages : Ruby : *Module*/*mixin*, Ruby : *extension*, Sass : *mixin*... )


```
trait Loggable{
    public function debug(array $params):string{
        //..
    }

    public function fatal(array $params):string
        //..
    }
}

class Panier{
    use Loggable;
}

```

- [Traits - Grafikart](https://www.grafikart.fr/formations/programmation-objet-php/traits-php)
- [Traits - OC](https://openclassrooms.com/courses/programmez-en-oriente-objet-en-php/les-traits-2)

### Gestion d'erreurs

- Exceptions

lorsqu'une erreur se produit, PHP lance des exceptions. Dans notre code aussi on peut gérer les cas qui peuvent être source d'erreurs,
afin de les gérer et ne pas laisser s'afficher de message d'erreur incompréhensible sur l'écran utilisateur.


```php

```


- Test unitaires

#### <a href="https://phpunit.de" target="_blank">PHP_Unit</a>

Installation globale
```
composer global require "phpunit/phpunit=5.4.*"
```

```bash
$ composer global require phpunit/phpunit
```

+ <a href="https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html" target="_blank">Tests avec PHP Unit</a>
+ [PHP unit - Grafikart](https://www.grafikart.fr/tutoriels/php/phpunit-test-unit-308)

### Principes POO

Une des raisons d'être de la POO est d'offrir un ensemble d'outils et de concepts,
permettant d'obtenir du code + évolutif (modularité, abstraction...).

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
res de méthodes/fonctions, mais pas avec types scalaires : int, bool, string, float


### Défi

- implémenter lé vérification mobile
- organiser les classes en fichiers / namespaces

