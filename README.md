# SAE PONEY

## Membre de la SAE
Julian MARQUES  
Chris MATHEVET  
Clement RENAUDIN  

## Consigne 
Un couple passionné d’équitation a ouvert depuis plusieurs années le poney club ≪ **Grand Galop** ≫ dans un village de Sologne. Ce poney club est adhérent à la Fédération Française d’Équitation (FFE), il dispose d’une trentaine de poneys et propose des cours à une centaine de clients qui doivent régler une cotisation annuelle (de septembre à fin août) et chaque cours qu’ils ont reservé.

L’objectif final de cette **SAE** est de proposer une **application web** qui permette de **gérer l’inscription** des élèves à des cours et d’**avoir facilement des plannings** (pour les moniteurs, les adhérents et les poneys).

La description du système d’information du client  
(Grand Galop) est volontairement très succincte (on peut même dire absente), à vous de l’imaginer et d’ajouter les données nécessaires (ou superflues)) 
Pour avoir au final une application agréable et conviviale.

Une **réservation** concerne un **cours** (**particulier** ou **collectif** 10 personnes max) 
entre une personne, un **poney** et un **moniteur**.  

- **Il se deroule a une date.**
- **Une heure precise et dure 1 ou 2 heures.** 
- **Les poneys doivent avoir au moins 1 heure de repos apres 2 heures de cours.** 
- **Ils peuvent porter un cavalier jusqu’a un certain poids.**


## Tache par membre du groupe


### **Julian Marques**
    - Analyse du projet
    - USE CASE
    - Script sql
    - Maquette site
    - Developpement web full stack
### **Chris Mathevet**
    - Analyse du projet
    - MCD
    - Responsable BD
    - Developpement web full stack
### **Clement Renaudin**
    - Analyse du projet
    - USE CASE
    - TRIGGER
    - Developpement web full stack


## Fonctionnalités
### Fonctionnalités du l'application

#### Login / Sign in  
- Possibilité de s'inscrire en tant que client
- Possibilité de se connecter en tant que client, moniteur et moniteur admin

#### Fonctionnalités commune à tous les rôles
- Possibilité de consulter son emploi du temps
- Possibilité de modifier ces informations personnelles

#### Client
- Il peut demander un cours privé
- Il peut rejoindre un cours disponible
- Il peut payer sa cotisation pour participer à des cours (Afin de réserver des cours)
- Il peut rajouter de l'argent sur son solde (Afin de réserver des cours)

#### Moniteur 
- Il peut accepter une demande de cours
- Il peut créer et modifier un cours (1 ou 10 personnes)
- Il peut créer une représentation de cours
- Il peut placer des disponibilités pour créer un cours, une représentation ou accepter une demande de cours (Impossible lorsqu'il n'est pas disponible) 

#### Administrateur 
- Il possède toutes les fonctionnalités d'un moniteur 
- Il peut ajouter/modifier les moniteurs et les poneys du site
- Il peut retirer les poneys, clients, moniteurs du site
- Il peut consulter l'emploi du temps d'un poney
- Il peut transformer un moniteur en administrateur ou révoquer ses droits

#### Autres Fonctionnalités  
- Pop up d'erreur et de validation
- Envoi de mails aux clients et moniteurs pour les demandes de cours (validation de demande au client, validation d'acceptation au moniteur et au client)
- Un client ne peut pas rejoindre qu'un cours dont il n'a pas le niveau
- Un moniteur ne peut pas créer un cours/représentation et accepter une réservation dont il n'a pas le niveau


### Ajout depuis la presentation 
- Correction de quelque fonctionnalités 
- pas d'ajout de fonctionalités supplementaire  

