<?php
 
//if (!defined('ACCESS')) die ("restricted access");
 
/**
 
 * Classe implémentant le singleton pour PDO
 
 * @author Savageman
 
 */
 
 
 
class Connexion extends PDO {

  private static $_instance;
 
 
 
    /* Constructeur : héritage public obligatoire par héritage de PDO */
 
  public function __construct( ) {
 
  }
 
// End of Connexion::__construct() */
 
 
 
/* Singleton */
 
  public static function getInstance() {
 
    if (!isset(self::$_instance)) {
  
      try {
    
        self::$_instance = new PDO("mysql:host=localhost;dbname=ovdi","root");
    
      } catch (PDOException $e) {
    
        echo $e;
    
        die ('SQL Error');
    
      }
  
    }
  
    return self::$_instance;
  
  }
  
  // End of Connexion::getInstance() */
 
}
