<?php

require ('./dao/ClientDao.php');

client = new ClientDao();

function getClient() {
  
  return client.findAll();
}

function setClient() {
   
}