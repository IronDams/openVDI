<?php

 /** Classe génériques pour les dao */
 
//if (!defined('ACCESS')) die ("restricted access");
 
class GenericDao {
 /** PDO Connection */
 
  protected $connexion;
 
 /** Table name */
 
  var $tableName;
 
 /** Nom de la colonne PK */
 
  protected $idColumn;
 
  /**
    * Constructeur de la classe
    * @param cnx : PDO Connexion si la valeur est null alors une instance du singleton sera chargée
    * @param $tableNanme : Nom de la table dans la base de données
    * @param $idColumn : Column Pk de la table 
    * @return void
   */

  public function __construct($cnx,$tableName,$idColumn) { 
 
    if($cnx == null){
      require_once(dirname(__FILE__).'/Connexion.php');
      $this->connexion = Connexion::getInstance();
    }else{
      $this->connexion = $cnx;
    } 
 
    $this->tableName = $tableName;
    $this->idColumn = $idColumn;
  }

 /**
   * Méthode qui retourne tous les éléments d'une table
   * @return les données de la table
   */
 
  public function findAll() {

    $sql = "SELECT * FROM ".$this->tableName;
    $requete = $this->connexion->prepare($sql); 

    if ($requete->execute()){
      if ($donnees = $requete->fetchAll())
      return $donnees;
    }
    else {
      return null;
    }
    
  }
 
 /**
   * Méthode qui retourne tous les éléments d'une table
   * @return les données de la table
   */
 
  public function findAllAdvanced($sortingExpr,$from,$to) {
 
    $sql = "SELECT * FROM ".$this->tableName;
 
    if($sortingExpr != null){
      $sql.=" ORDER BY ".$sortingExpr;
    }
 
    if($from !=null && $to != null){
      $sql .=" LIMIT ".$from.",".$to;
    }
 
    $requete = $this->connexion->prepare($sql);
 
    if($requete->execute()){
      if($donnees = $requete->fetch())
      return $donnees;
    }
    else{
      return null;
    }

  }
 
 /**
  * Méthode qui retourne un élément d'une table selon la valeur de la PK
  * @param $pkVal : La valeur de la PK
  * @return l'enregistrement voulu
  */
 
  public function findById($pkVal){
 
    $sql = "SELECT * FROM ".$this->tableName." WHERE ".$this->idColumn." = :myVal";
    $requete = $this->connexion->prepare($sql);
    $requete->bindValue(':myVal', $pkVal);
 
    if($requete->execute()){
      if($donnees = $requete->fetch())
      return $donnees; 
    }
    else{
      return null;
    } 

  }
 
 /**
   * Méthode qui supprime un élément d'une table selon la valeur de la PK
   * @param $pkVal : La valeur de la PK
   * @return
   */
 
  public function deleteById($pkVal){
 
    $sql = "DELETE FROM ".$this->tableName." WHERE ".$this->idColumn." = :myVal";
    $requete = $this->connexion->prepare($sql);
    $requete->bindValue(':myVal', $pkVal);
 
    if($requete->execute()){
      return true;
    } 
    else{
      return false;
    } 
 
 } 
 
 /**
  * Met à jour des colonnes specifiques de la table
  * @param array $colNames tableau contenant les noms des colonnes à modifier
  * @param array $newVals tableau contenant les nouvelles valeurs
  * @param ? valeur de la pk
  */
 
  public function updateColumns($colNames,$newVals,$pkVal){
 
    $sql = "Update ".$this->tableName." SET ";
 
    for($i=0;$i<count($colNames);$i++){
      $sql.=$colNames[$i]. " = :v".$i;
      
      if($i<count($colNames)-1){
        $sql.=",";
      } 
    }
 
    $sql.= " where ".$this->idColumn ." = :myVal"; 
    $requete = $this->connexion->prepare($sql);
 
    for($i=0;$i<count($colNames);$i++){ 
      $requete->bindValue(':v'.$i, $newVals[$i]); 
    }
 
    $requete->bindValue(':myVal', $pkVal);
 
    if($requete->execute()){
      return true;
    }
    else{
      return false;
    } 

  }
 
}
