# Installation

### Cloner le projet

```bash
git clone https://github.com/alanohayon/ProjetPhpLaravel.git
```

### Ouvrir Docker Desktop
Lancer l'application Docker Desktop

### Lancer le conteneur docker
```bash 
docker-compose up -d
```

### Se connecter au terminal du conteneur docker de l'application Laravel
```bash 
docker exec -it [nom_du_conteneur_laravel] /bin/bash
```
pour moi c'est :
```bash
docker exec -it projetphplaravel_www_1 /bin/bash
```

## Installation des dépendances de l'application (Composer & NPM)
toutes les commandes suivantes sont à executer dans le terminal du conteneur docker de l'application Laravel
```bash
composer install
```
```bash
npm install
```
```bash
php artisan migrate
```
```bash
php artisan storage:link
```

## Utilisation de la librairie "Hootlex - Laravel Friendships" https://github.com/hootlex/laravel-friendships?ssp=1&setlang=fr-FR&safesearch=moderate
Étant une librairie conçue pour Laravel 5 (Version ultérieure à Laravel 10 utilisé dans ce projet), il faut modifier le fichier app/vendor/hootlex/laravel-friendships/src/Traits/Friendable.php :

Il faut remplacer toutes les fonctions "fire()" (qui n'existe plus nativement dans Laravel 10) par "dispatch()" 

Pour faire cela rapidement, on peut utiliser CTRL+R sur ce fichier et remplacer "fire" par "dispatch" dans tout le fichier.
```bash
fire
```
```bash
dispatch
```

## Lancer l'application
lancer l'application avec npm run dev en le laissant tourner dans le terminal
```bash
npm run dev
```
