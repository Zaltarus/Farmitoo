# Installation

- composer install
- npm install


## Assets
Pour compiler les assets (à la racine du projet)
- npm run watch 

## Test
- Revenir sur la home et cliquer sur générer un panier modifie les quantité des différent produit
- Sinon éditer directement dans TunnelController.php la fonction initBasket()

## Assets futur
- possibilité de faire un Makefile pour lancer des assets différent (make www.assets-watch ou make admin.assets-watch) avec un webpack.config.js pour chaque dossier

## Explication
- Asset dans un www dans le cas où on voudrait géré dans le même projet une admin
- Un petit echantillon de JS pour gérer les quantité. Je n'ai pas gérer les quantité via le controller car j'ai dépensé déjà pas mal de temps
- Pas de setter dans les entité car pas besoin dans le test
- @OnlyForTest c'est pour indiqué que pour le test je prends un raccourci ou non présent dans un code finale
- @ToDo pour les evolution a faire (mais pas util pour le test)
- Les repository sont construit comme pour récupérer les donnée comme si on avait une BDD
- Peu de commentaire car le nom des variables/fonction est assez explicite selon moi
- Je n'ai pas utilisé PHPCS, PSALM, ESLINT donc si jamais il y a des indentations/espace ou typage ambigue merci de ne pas trop m'en vouloir
- Je n'ai pas pris en compte les optimisations en cas d'utilisation d'une base de donné
- Les collections c'est pratique avec les BDD mais là superflu pour le test :(
- Il aurait été plus pratique de calculer le prix de la livraison dans le normalizer mais le normalizer n'est pas fait pour cela

## La Livraison
- La partie Livraison peut parraître un peu baclé car j'ai déjà passé beaucoup de temps sur le test. Je serais surement partie sur un décorateur plutot que sur un array

## Evolution BACK
- Définir le prix TTC du produit directement dans le produit (et pas le calculer à chaque fois)
- Utiliser la normalization automatique de symfony (NormalizerInterface, supportNormalization) plutôt que de faire appel au normalizer pour l'order
- Faire une normalization spécifique pour le produit
- Gérer les images via webpack
- Pour les frais de livraison (Shipping) pouvoir créer des règles 
- Passer TAX_SHIPPING comme paramètre dans la class TagResolver
- Peut être mieux gérer le total avec la livraison (ne pas le faire dans la vue mais dans le back))

## Evolution UX
- Bouton passer commande sur mobile en fixed et gestion en JS pour le faire disparaitre lorsque l'on voit le récapitulatif de la commande
- Pouvoir augmenter la quantité en javascript (avec côté back vérification du stock) (requete en Ajax, récupération Json et remplacement des données (VueJs est bien pratique dans ce cas ;) sans VueJS création d'une couche JS pour gérer les templates)
- séparation des différent JS par page (exemple JS product.js uniquement charger sur la fiche produit)

# Note
J'ai définie l'installation sur PHP 8.0 mais je n'ai pas utilisé ses fonctionnalité 
car j'ai PHP 2019 qui n'interprète pas PHP8 et je ne sais pas comment le système 
réagira si j'installe PHPStorm 2020 (et sans PHP storm je serais ralentie dans le développement
du test :(). J'espère que tu me l'excusera :)