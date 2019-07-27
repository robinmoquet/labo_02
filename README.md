## Labo 02

### Introduction

Text d'explication ...


### Installation

1- Cloner le dossiers depuis git :
```
$ git clone https://github.com/robinmoquet/labo_02.git
```

2- Installation des dépendances PHP :
```
$ composer update
```

3- Installation des dépendances Javascript pour la compilation de MJML :

``
$ yarn install
``
ou avec npm
``
$ npm install
``

4- Mettre à jour les données du ".env" pour la connection a la base de donnée et le serveur smtp pour l'envoi d'email: 
```
DATABASE_URL=mysql://root:root@127.0.0.1:3306/labo_02

GMAIL_USERNAME=<votre-adresse-gmail>@gmail.com
GMAIL_PASSWORD=<votre-mot-de-passe>
```

Finalement - Lancer le serveur :
```
$ php bin/console server:run
```