<?php
    class DBTransaction{
        public $database;

        public function __construct(){
            if ($this->database == null) {
                $urlDB = "mysql:host=localhost;dbname=ecommerce";
                $username="root";
                $password="";
                $this->database = new PDO($urlDB,$username,$password);
                $this->database->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE, 
                    PDO::FETCH_ASSOC
                );
            }
        }

        public function inscription($nom, $prenom, $adresse,$tel, $pwd, $profil){
            try {
                $result = $this->database->query("INSERT INTO `User` VALUE(null,'$nom','$prenom', '$adresse','$tel','$pwd','$profil','0')");
               
            return 1;
            } catch (\PDOException $th) {
                die($th);
                return 0;
            }
        }

        public function connexion($tel, $pwd){
            $result = $this->database->query("SELECT * FROM `User` WHERE tel='$tel' AND pwd='$pwd'");
            return $result->fetch();
        }

        //--------------------------Users-------------------------------
        public function getAllUser(){
            try {
                $result = $this->database->query("SELECT * FROM `User` WHERE corbeille='0'");
            return $result->fetchAll();
            } catch (\PDOException $th) {
                return null;
            }
           
        }
        public function deleteUser($id){
            try {
                $result = $this->database->query("UPDATE `User` SET corbeille='1' WHERE id ='$id'");
                //$result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return null;
             }
        }

        public function getUserById($id){
            $result = $this->database->query("SELECT * FROM `User` WHERE  id='$id' AND corbeille='0'");
            return $result->fetch();
        }
        public function updateUser($id,$nom,$prenom, $adresse, $tel,$pwd,$profil){
            try {
                $result = $this->database->query("UPDATE `User` SET  nom='$nom',prenom='$prenom',adresse='$adresse',tel='$tel',pwd='$pwd',profile='$profil',corbeille='0' WHERE id='$id'");
               
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }
        public function updateProfilUser($id,$profil){
            try {
                $result = $this->database->query("UPDATE `User` SET profile='$profil'WHERE id='$id'");
               
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }

        //---------------------Produit-------------------------
        public function createProduct($nom, $description, $prixU,$img,$id_boutiquier){
            try {
                $result = $this->database->query("INSERT INTO `Produit` VALUE(NULL ,'$nom','$description','$prixU','$img','$id_boutiquier','0')");
                $result->fetchAll();
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }

        public function getAllProduct(){
            $result = $this->database->query("SELECT * FROM Produit WHERE corbeille='0'");
            return $result->fetchAll();
        }

        public function getProductByIdBoutiquier($id_boutiquier){
            $result = $this->database->query("SELECT * FROM `Produit` WHERE id_boutiquier='$id_boutiquier' AND corbeille='0'");
            return $result->fetchAll();
        }
        public function getProduitById($id_produit){
            $result = $this->database->query("SELECT * FROM `Produit` WHERE  id='$id_produit'");
            return $result->fetch();
        }
        public function deleteProduit($id_produit){
            try {
                $result = $this->database->query("UPDATE `Produit`SET corbeille='1' WHERE id ='$id_produit'");
                //$result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return null;
             }
        }
        public function updateProduct($id,$nom, $description, $prixU){
            try {
                $result = $this->database->query("UPDATE `Produit` SET  nom='$nom',description='$description',prixU='$prixU' WHERE id='$id'");
               
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }

        //-------------------------Panier----------------------------
        public function createPanier($montantTOT,$id_client){
            try {
                $result = $this->database->query("INSERT INTO `Panier` VALUE(NULL ,'$montantTOT','$id_client')");
                $result->fetchAll();
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }
        public function getPanierByIdBoutiquier($id_client){
            $result = $this->database->query("SELECT * FROM `Panier` WHERE  id_client='$id_client'");
            return $result->fetchAll();
        }
        
        public function getClientPanier($id_client){
            $result = $this->database->query("SELECT * FROM `Panier` WHERE id_client='$id_client'");
            return $result->fetch();
        }
        public function updatePanier($id_panier,$montantTOT){
            try {
                $result = $this->database->query("UPDATE `Panier` SET montantTOT='$montantTOT' WHERE id='$id_panier'");
                $result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return 0;
             }
        }
        public function deletePanier($id){
            try {
                $result = $this->database->query("DELETE `Panier` WHERE id ='$id'");
                $result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return 0;
             }
        }


        //-------------------------Produit_Panier---------------------------
        
        public function createProduitPanier($id_panier,$id_produit,$nbr,$montantTOT){
            try {
               $result = $this->database->query("INSERT INTO `ProduitPanier` VALUE(null,'$id_panier','$id_produit','$nbr','$montantTOT')");
               $result->fetch();
                return 1;
            } catch (\PDOException $th) {

                return 0;
            }
        }
        public function getProduitPanier($id_panier){
            $result = $this->database->query("SELECT * FROM `Produit` JOIN `ProduitPanier` ON ProduitPanier.id_produit=Produit.id  WHERE id_panier='$id_panier'");
           return $result->fetchAll();
            
        }
        public function deleteProduitPanier($id_produit){
            try {
                $result = $this->database->query("DELETE FROM `ProduitPanier` WHERE id ='$id_produit'");
                //$result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return null;
             }
        }
        public function resetPanier($id_panier){
            $result = $this->database->query("DELETE FROM `ProduitPanier` WHERE id_panier='$id_panier'");
            return $result->fetch();
  
        }
        public function updateProductPanier($id,$nbr,$montantTOT){
            try {
                $result = $this->database->query("UPDATE `ProduitPanier` SET  nbr='$nbr',montantTOT='$montantTOT' WHERE id='$id'");
               
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }
        
        public function getPanierById($id){
            $result = $this->database->query("SELECT * FROM `ProduitPanier` WHERE  id='$id'");
            return $result->fetch();
        }

        //----------------------Commande-------------------
        public function createCommande($date,$montantTOT,$etat,$id_client){
            try {
                $result = $this->database->query("INSERT INTO `Commande` VALUE(NULL ,'$date','$montantTOT','$etat','$id_client')");
                $result->fetch();
                
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }

        }
        public function getCommandeClient($id_client){
            $result = $this->database->query("SELECT * FROM `Commande` WHERE id_client='$id_client' ORDER BY id DESC");
            return $result->fetchAll();
        }
        public function getAllCommande(){
            $result = $this->database->query("SELECT * FROM `Commande` ORDER BY id DESC");
            return $result->fetchAll();
        }
        public function rejetcommande($id){
            try {
                $result = $this->database->query("UPDATE  `Commande` SET etat='REJETER' WHERE id ='$id'");
                //$result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return 0;
             }
        }
        public function createCommandeValider($date,$montantTOT,$etat,$id_client){
            try {
                $result = $this->database->query("INSERT INTO `Commande` VALUE(NULL ,'$date','$montantTOT','$etat','$id_client')");
                $result->fetch();
                
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }

        }
        public function Validercommande($id){
            try {
                $result = $this->database->query("UPDATE  `Commande` SET etat='VALIDER' WHERE id ='$id'");
                //$result->fetch();
                 return 1;
             } catch (\PDOException $th) {
 
                 return 0;
             }
        }


        //--------------------Produit_Commande--------------------
        
        public function createProduitCommande($id_commande,$id_produit,$nbr,$montantTOT){
            try {
                $result = $this->database->query("INSERT INTO `ProduitCommande` VALUE(NULL ,'$id_commande','$id_produit','$nbr','$montantTOT')");
                $result->fetchAll();
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }

        }
        public function getProduitCommande($id_commande){
            $result = $this->database->query("SELECT * FROM `ProduitCommande` JOIN `Produit` ON ProduitCommande.id_produit=Produit.id  WHERE id_commande='$id_commande'");
           return $result->fetchAll();
            
        }

        //---------------------------Profile------------------------
        public function getProfileById($id){
            $result = $this->database->query("SELECT * FROM `User` WHERE  id='$id'");
            return $result->fetch();
        }
        public function updateProfile($id,$nom,$prenom, $adresse, $tel){
            try {
                $result = $this->database->query("UPDATE `User` SET  nom='$nom',prenom='$prenom',adresse='$adresse',tel='$tel' WHERE id='$id'");
               
                return 1;
            } catch (\PDOException $th) {
               return 0;
            }
        }

        

    }
  
?>