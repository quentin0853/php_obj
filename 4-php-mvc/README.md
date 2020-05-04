Les notions de POO sont nécessaires pour cette activité. Par ailleurs, elle se base sur ce qui a été fait durant l'activité précédente

# Qu'est ce que le MVC

Jusqu'à maintenant, vous écriviez tout dans la même page : connexion à la base de données, récupération/insertion des données, mise en forme des données avec l'HTML...  Beaucoup de fichiers et beaucoup de redondance de code.

Pour ranger un peu tout ça on va utiliser le MVC.

Le MVC est ce qu'on appelle un design pattern autrement dit un patron conçu par des développeurs, pour des développeurs. 
Pour le voir autrement, nous faisons tous face aux mêmes problèmes lorsque nous développons, et certaines structures de code
sont plus optimales pour résoudre un même dilemne.

De plus, en utilisant un bon nommage, un développeur aguérri comprends de suite ce que vous êtes en train de mettre en place. 

C'est donc sur la base du pattern MVC que nous allons organiser notre code.

# Comment ça marche

On va organiser notre application en 3 parties : **M**odels, **V**iews, **C**ontrollers.

* Le Model (le modèle) gère les données stockées (en base de données, dans un fichier, etc.) Si on veut récupérer ou insérer un élément en base de données, on passera par lui.
* La View (la vue) se concentre uniquement sur l'affichage. Elle ne fait qu'afficher ce que le controller lui passe.
* Le Controller (le contrôleur) fait le lien entre le Model et la View. Il s'occupe à chercher les bonnes données en utilisant les bons models pour passer à la view.

![Patron MVC](https://upload.wikimedia.org/wikipedia/commons/f/f8/Cakephp_Schema_Einfach.png)

# En pratique

On va mettre en place une mini application CRUD en MVC pour voir le principe. On va rester le plus simple possible en se concentrant sur les concepts.

## Architecture de base

Nous allons séparer nos views,models et controllers dans des dossiers différents :
```
|-controllers/
|-models/
|-views/
|-index.php
```
La structure de notre application est posée, il faut maintenant déterminer qu'est ce qui va où. L'activité d'une ludothèque étant plutôt simple, son "découpage" en MVC donnera :

*     1 controller qu'on appellera BoardgameController
*     1 model qu'on appellera Boardgame
*     3 views : create.php, update.php, read.php

À ce stade, l'architecture de fichier ressemble à ça :
```
|-controllers/
|---BoardgameController.php
|-models/
|---Boardgame.php
|-views/
|---create.php
|---update.php
|---read.php
|-index.php
```
# Comment choisir le bon contrôleur

Notre architecture est posée mais comment faire pour appeler le controller et surtout le bon dans le cas où on en a plusieurs ?

Il y a pleins de solutions. On va opter pour un script `dispatcher`.

L'objectif est d'appeler à chaque fois, partout notre application, le même script, le dispatcher, pour naviguer vers une page et selon l'url il va "choisir" le bon controller.

Vous avez remarqué le fichier **index.php** ? C'est lui qui sera notre `dispacher`.

Pour que ce _dispatcher_ reste simple, on va se fixer un modèle d'URL à respecter. On va se dire que chaque URL doit contenir les variables controller et action. Les liens pour les différentes pages deviennent :

*     read : index.php?controller=Boardgame&action=read
*     update : index.php?controller=Boardgame&action=update
*     create : index.php?controller=Boardgame&action=create
*     delete : index.php?controller=Boardgame&action=delete

Vous allez me dire que certaines actions ont besoin de id, comme update ou delete. Et vous avez raison. Nous allons donc ajouter un troisième paramètre qu'on appellera id. Ce qui donne :

*     read : index.php?controller=Boardgame&action=read
*     update : index.php?controller=Boardgame&action=update&id=18
*     create : index.php?controller=Boardgame&action=create
*     delete : index.php?controller=Boardgame&action=delete&id=5

Ce n'est pas très évolutif et assez contraignant mais encore une fois, ici, le but c'est de comprendre le concept du MVC.

Le dispatcher va fonctionner de la sorte :

*     récupérer le contenu de la variable controller de l'URL
*     récupérer l'action, toujours de l'url
*     regarder si le controller existe
*     vérifier si l'action existe sur le controller (dans notre cas les actions sont read, create, update, delete)
*     appeler l'action sur le controller (avec en paramètre l'id si nécessaire)

## Le model

Le _model_, dans notre cas la classe `Boardgame`, va représenter l'objet stocké dans la base de données.
Afin de faciliter la tâche. Nous aurons une nouvelle méthode sur l'objet boardgame qui se nommera save().

## Le controller

Le controller va faire le lien entre le _model_ et la _view_. Le _controller_ est composé d'_action_. Une action est tout simplement une méthode du _controller_. On a dit plus haut que le controller est composé de 4 actions : **read**, **create**, **update**, **delete** :
```php
//controller/BoardgameController.php
class BoardgameController{
  /**
   * the read action
   * @return string the view name
   */
  public function read(){
   //À compléter
  }

  /**
   * the update action
   * @return string the view name
   */
  public function update(){
    //À compléter
  }

  /**
   * the create action
   * @return string the view name
   */
  public function create(){
    //À compléter
  }

  /**
   * The delete action
   */
  public function delete(){
   //À compléter
  }
}
```
Nous allons prendre en exemple l'action _read_. Pour rappel,lorsqu'on appelle cette action on doit récupérer toutes les jeux de société et les afficher sous forme d'un tableau.

Comme on veut récupérer des données de la base de données il faudra créer le _model_ `Boardgame` et appeler la méthode `readAll()`.
```php
//controller/BoardgameController
public function read(){
    // requête en base de données pour récupérer l'ensemble des board games.
    // $boardgames = DBConnection::getInstance()->query('Select * from boardgames')->fetchAll(PDO::FETCH_CLASS, 'Boardgame');;
    //"appelle" la view
    // include 'views/read.php';
}
```
Vous avez remarqué le `include` à la fin de la méthode. Comme vous pouvez vous en doutez, c'est la _view_ pour cette action.
## La View

Normallement vous l'avez réalisé au sein de l'étape précédente.
C'est la partie la plus simple. On récupère les données envoyées par le _controller_ et puis les met en forme. Dans notre cas, la _view_ a accès à la variable `boardgames`
```html
<h1>Read</h1>
<ul>
<?php foreach($boardgames as $boardgame){ ?>
  <li>
    <?php echo $boardgame['name']; ?>
  </li>
<?php } ?>
</ul>
```
Et voilà ! Maintenant si on va l'adresse `index.php?controller=Boardgame&action=read` on a une liste de jeux de société.
# A votre tour
Pour le moment pas besoin d'ajouter la couche login/mot de passe.

# Aller plus loin

Ce que l'on vient de faire est juste un exemple et n'est pas du tout optimal ! C'est une base pour comprendre les principes.

Rassurez-vous, il y a des frameworks pour vous facilitez la tâche. Jetez un oeil sur [Symfony](https://symfony.com)
ou encore sur [Laravel](https://laravel.com/)

# Ressources

*     [Le MVC](https://openclassrooms.com/courses/concevez-votre-site-web-avec-php-et-mysql/organiser-son-code-selon-l-architecture-mvc) 
*    [Créer son propre framework](http://symfony.com/doc/current/create_framework/index.html) 