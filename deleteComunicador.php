<?php

   if(!empty($_GET['id']))    //puxar os dados existentes do banco para editar
   {

   include_once('config.php');
   
   $id = $_GET['id'];

   $sqlSelect = "SELECT * FROM comunicador_servidor WHERE id = $id";

   $result = $conexao->query($sqlSelect);
   

   if($result->num_rows > 0)
   {

      $sqlDelete = "DELETE FROM comunicador_servidor WHERE id =$id";
      $resultDelete = $conexao->query($sqlDelete);
        
    }    

  }
        header('Location: ComunicadorServidor.php');
      
    
    
