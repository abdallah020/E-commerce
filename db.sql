DROP DATABASE IF EXISTS `ecommerce`;

CREATE DATABASE IF NOT EXISTS `ecommerce`;

USE `ecommerce`;

CREATE TABLE `User`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
 `nom` VARCHAR(100),
 `prenom` VARCHAR(100),
 `adresse` VARCHAR(100),
 `tel` VARCHAR(20) UNIQUE,
 `pwd` VARCHAR(100),
 `profile` ENUM("ADMIN", "BOUTIQUIER", "CLIENT")
);

CREATE TABLE `Produit`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
 `nom` VARCHAR(100),
 `description` TEXT,
 `prixU` float,
 `image` VARCHAR(100),
 `id_boutiquier` int,
 CONSTRAINT FOREIGN KEY (`id_boutiquier`) REFERENCES `User`(`id`)
);

CREATE TABLE `Panier`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
  `montantTOT` float,
  `id_client` int,
  CONSTRAINT FOREIGN KEY (`id_client`) REFERENCES `User`(`id`)
);

CREATE TABLE `Commande`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
 `date` date,
 `montantTOT` float,
 `etat` ENUM("EN COURS", "VALIDER", "REJETER"),
 `id_client` int,
 CONSTRAINT FOREIGN KEY (`id_client`) REFERENCES `User`(`id`)
);

CREATE TABLE `ProduitCommande`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
 `id_commande` int,
 `id_produit` int,
 `nbr` int,
 `montantTOT` float,
 CONSTRAINT FOREIGN KEY (`id_commande`) REFERENCES `Commande`(`id`),
 CONSTRAINT FOREIGN KEY (`id_produit`) REFERENCES `Produit`(`id`)
);

CREATE TABLE `ProduitPanier`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
 `id_panier` int,
 `id_produit` int,
 `nbr` int,
 `montantTOT` float,
 CONSTRAINT FOREIGN KEY (`id_panier`) REFERENCES `Panier`(`id`),
 CONSTRAINT FOREIGN KEY (`id_produit`) REFERENCES `Produit`(`id`)
);

-- Some request:

-- CRUD For User
INSERT INTO `User` VALUE(null,"sene","fatou","762917099","passer123","ADMIN");

INSERT INTO `User` VALUE(null,"bangare","abdoulaye","777777777","azerty123","BOUTIQUIER");

INSERT INTO `User` VALUE(null,"diouf","aliou","75894623","pass14","CLIENT");
-- CRUD For Produit
INSERT INTO `Produit` VALUE(NULL ,"nescafe","donne du gout a ton cafe",1500,"",2);
INSERT INTO `Produit` VALUE(NULL ,"Lait","Vitalait",1600,"",2);
INSERT INTO `Produit` VALUE(NULL ,"riz","parfumé",700,"",2);
SELECT * FROM `Produit`;-- CRUD For Panier
INSERT INTO `Panier` VALUE(NULL,0,3);
-- CRUD For ProduitPanier
-- AJOUTER 2 PRODUIT DANS PANIER ID=1 (DETAILPANIER)
INSERT INTO `ProduitPanier` VALUE(null, 1, 3, 2, (2*700));
INSERT INTO `ProduitPanier` VALUE(null, 1, 2, 3, (3*1600));
UPDATE `Panier` SET `montantTOT`=(2*700)+(3*1600) WHERE `id`=1;

INSERT INTO `Commande` VALUE(null, '2022-02-25', 7000, "EN COURS",3);
-- AJOUTER 2 PRODUIT DANS COMMANDE ID=2 (DETAILCOMMANDE)
INSERT INTO `ProduitCommande` VALUE(null, 2, 3, 2, (2*700));
INSERT INTO `ProduitCommande` VALUE(null, 2, 2, 3, (3*1600));

-- SELECT AVOIRE LE BOUTIQUIER ET SES PRODUITS
SELECT * FROM `User` JOIN `Produit` ON User.id=Produit.id_boutiquier;