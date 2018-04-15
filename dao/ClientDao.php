<?php

/**
 * DAO Client étendu de Generic
 */
//if (!defined('ACCESS')) die ("restricted access");

require_once(dirname(__FILE__).'/GenericDao.php');
 
class ClientDao extends GenericDao{
  public function __construct($cnx) { 
    parent::__construct($cnx,"client","id_client"); 
  }
  
  public function getClient($nom = '', $prenom = ''){

    $sql = "SELECT * FROM " . $this->tableName . " WHERE nom = " . $nom . " OR prenom = " . $prenom;
    $requete = $this->connexion->prepare($sql);

    if($requete->execute()){
      if($donnees = $requete->fetch()){
        return $donnees; 
      }
    }
    else{
      return null;
    } 
  }
}