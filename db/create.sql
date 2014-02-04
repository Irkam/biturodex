create database y-commerce:


/***********

Alter table #nom table# modify #nom column#

Alter table #nom table# add #nom column# // ajoute une ligne à la table choisie

************/


Create table utilisateur

( idUti int(10) not null primary key,

nom varchar(60) not null,

prenom varchar(60) not null,

pseudo varchar(60) not null,

mdp varchar(60) not null,

idEtablissement int(10) not null foreign key references etablissement(idEtablissement),

idEvent int(10) not null foreign key references event(idEvent),

…

);


Create table etablissement

( idEtablissement int(10) not null primary key,

nom varchar(60) not null,

prenom varchar(60) not null,

adresse varchar(200) not null,

ville varchar(60) not null,

codepostal varchar(60) not null,

idEvent int(10) not null foreign key references event(idEvent),

…

);


Create table employe

( idEmploye int(10) not null primary key,

status varchar(60) not null,

idUti int(10) not null foreign key references utilisateur(idUti),

idEtablissement int(10) not null foreign key references etablissement(idEtablissement)

);


Create table friend

( idFriend int(10) not null primary key,

idUti int (10) not null foreign key references utilisateur (idUti)

);


Create table event

( idEvent int(10) not null primary key,

nom varchar(60) not null,

…

);


Create table statUti

( idStatUti int (10) not null primary key,

nbVote int(1000) not null,

pourcentage double(1000) not null,

idUti int (10) not null foreign key references utilisateur (idUti)

...

);


Create table statEtablissement

( idStatEtablissement int (10) not null primary key,

nbVote int(1000) not null,

pourcentage double(1000) not null,

idEtablissement int(10) not null foreign key references etablissement(idEtablissement)

…

);


Create table statEvent

( idStatEvent int (10) not null primary key,

nbVote int(1000) not null,

pourcentage double(1000) not null,

idEvent int(10) not null foreign key references event(idEvent),

…

);


Create table participationEvent

( idParticipationEvent int(10) not null primary key,

idUti int(10) not null foreign key references utilisateur(idUti),

…

);


Create table typeEtablissement

( idTypeEtablissement int (10) not null primary key,

type varchar(60) not null,

idEtablissement int(10) not null foreign key references etablissement(idEtablissement),

...

);
