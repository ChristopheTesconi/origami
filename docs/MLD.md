# Voici le MLD de mon application 

1. Table utilisateurs :

| Champ ||
|--|--|
| id | INT AUTO_INCREMENT PRIMARY KEY |
| nom | VARCHAR(64) NOT NULL |
| email | 	VARCHAR(64) NOT NULL UNIQUE |
| mot_de_passe | VARCHAR(255) NOT NULL |
| date_creation | DATETIME DEFAULT CURRENT_TIMESTAMP |

2. Table origami :

| Champ ||
|--|--|
| id | INT AUTO_INCREMENT PRIMARY KEY |
| nom | VARCHAR(64) NOT NULL |
| description | TEXT |
| image | VARCHAR(255) NOT NULL |
| date_creation | DATETIME DEFAULT CURRENT_TIMESTAMP |

3. Table commentaires :

| Champ ||
|--|--|
| id | INT AUTO_INCREMENT PRIMARY KEY |
| utilisateur_id | VARCHAR(64) NOT NULL |
| origami_id | VARCHAR(64) NOT NULL UNIQUE |
| commentaire | VARCHAR(255) NOT NULL |
| date_creation | DATETIME DEFAULT CURRENT_TIMESTAMP |
| Contraintes de clé étrangère ||
| FOREIGN KEY (utilisateur_id) | REFERENCES utilisateurs(id) |
| FOREIGN KEY (origami_id) | REFERENCES origamis(id) |

3. Table vidéos :

| Champ ||
|--|--|
| id | INT AUTO_INCREMENT PRIMARY KEY |
| origami_id | INT |
| titre | VARCHAR(100) NOT NULL |
| lien_url | VARCHAR(255) |
| Contrainte de clé étrangère ||
| FOREIGN KEY (origami_id) | REFERENCES origamis(id) |

4. Table favoris :

| Champ ||
|--|--|
| id | INT AUTO_INCREMENT PRIMARY KEY |
| utilisateur_id | INT |
| origami_id | INT |
| date_favori | DATETIME DEFAULT CURRENT_TIMESTAMP
| Contraintes de clé étrangère ||
| FOREIGN KEY (utilisateur_id) | REFERENCES utilisateurs(id) |
| FOREIGN KEY (origami_id) | REFERENCES origamis(id) |