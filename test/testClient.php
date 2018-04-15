<?php

require ("..\dao\Connexion.php");
require ("..\dao\ClientDao.php");

$cnx = null;
$client = new ClientDao($cnx);
$all = $client->findAll();
if ($all != ''){
  print_r($all);
}
else{
  print("Pas de résultats");
}

