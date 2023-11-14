# Dictionnaire de données

## Origamis (table `origamis`)

Contient la liste des origamis et leurs caractéristiques.

| Nom | Type | Description |
| --- | --- | --- |
| id | INT | Identifiant unique de l'origami |
| name | VARCHAR(255) | Nom de l'origami |
| description | TEXT | Description de l'origami |
| created_At | date_time | Date de creation de l'origami |
| updated_At | date_time | Modification de l'origami |
| picture | VARCHAR(255) | photo de l'origami |

## Utilisateurs (table `utilisateurs`)

Contient la liste des utilisateurs et leurs caractéristiques.

| Nom | Type | Description |
| --- | --- | --- |
| id | INT | Identifiant unique de l'utilisateur |
| username | VARCHAR(64) | Nom de l'utilisateur |
| email | VARCHAR(64) | Email de l'utilisateur |
| password | VARCHAR(64) | Mot de passe de l'utilisateur |
| roles | VARCHAR(64) | Rôle de l'utilisateur |
| photo | VARCHAR(64) | Photo/image de l'utilisateur |

## Commentaires (table `comments`)

Contient la liste des commentaires et leurs caractéristiques.

| Nom | Type | Description |
| --- | --- | --- |
| id | INT | Identifiant unique du commentaire |
| utilisateur_id | INT | Identifiant de l'utilisateur qui écrit le commentaire |
| origami_id | INT | Origami commenté |
| comment | TEXT | Commentaire |
| created_At | date_time | Date de creation du commentaire |
| updated_At | date_time | Modification du commentaire |

## Vidéos (table `videos`)

Contient la liste des vidéos et leurs caractéristiques.

| Nom | Type | Description |
| --- | --- | --- |
| id | INT | Identifiant unique de la vidéo |
| title | VARCHAR(255) | Titre de la vidéo |
| utilisateur_id | INT | Identifiant de l'utilisateur qui a posté la vidéo |
| lien_url | VARCHAR(255) | Lien url de la vidéo |

## Favoris (table `favorites`)

Table de liaison entre les favoris et les utilisateurs. 

| Nom | Type | Description |
| --- | --- | --- |
| id | INT | Identifiant unique du favoris |
| utilisateur_id | INT | Identifiant de l'utilisateur qui a posté la vidéo |
| favorite_id | INT | Identifiant du favoris |
