CREATE TABLE ROLE(
   id_role INT AUTO_INCREMENT,
   name VARCHAR(50)  NOT NULL,
   niveau INT NOT NULL,
   PRIMARY KEY(id_role)
);

CREATE TABLE CATEGORIE(
   id_categorie INT AUTO_INCREMENT,
   name VARCHAR(50)  NOT NULL,
   slug VARCHAR(100)  NOT NULL,
   created_at DATETIME NOT NULL,
   PRIMARY KEY(id_categorie)
);

CREATE TABLE USER_(
   id_user INT AUTO_INCREMENT,
   username VARCHAR(100)  NOT NULL,
   password VARCHAR(100)  NOT NULL,
   created_at DATETIME NOT NULL,
   id_role INT NOT NULL,
   PRIMARY KEY(id_user),
   FOREIGN KEY(id_role) REFERENCES ROLE(id_role)
);

CREATE TABLE ARTICLE(
   id_article INT AUTO_INCREMENT,
   titre VARCHAR(100) ,
   contenus TEXT NOT NULL,
   slug VARCHAR(100)  NOT NULL,
   created_at DATETIME NOT NULL,
   id_categorie INT NOT NULL,
   PRIMARY KEY(id_article),
   FOREIGN KEY(id_categorie) REFERENCES CATEGORIE(id_categorie)
);
