<?php

   if(!empty($_GET['id']))    //puxar os dados existentes do banco para editar
   {

   include_once('config.php');
   
   $id = $_GET['id'];

   $sqlSelect = "SELECT * FROM idcloud WHERE id = $id";

   $result = $conexao->query($sqlSelect);
   

   if($result->num_rows > 0)
   {

      $sqlDelete = "DELETE FROM idcloud WHERE id =$id";
      $resultDelete = $conexao->query($sqlDelete);
        
    }    

  }
        header('Location: idcloud.php');
      
    
    
