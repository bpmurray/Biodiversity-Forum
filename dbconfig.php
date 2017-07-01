<?php

   //$db_host = "mysql2880int.cp.blacknight.com";
   //$db_name = "db1454844_registration";
   //$db_user = "u1454844_root";
   //$db_pass = "Meabh3Sian";
   $db_host = "localhost";
   $db_name = "dbregistration";
   $db_user = "root";
   $db_pass = "me32316";
   
   try {
      
      $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
      $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Load the settings
      $stmt = $db_con->prepare("SELECT enddate, counter FROM settings WHERE id=1;");
      $stmt->execute();
      $settings = $stmt->fetch(PDO::FETCH_BOTH);

   } catch(PDOException $e) {
      echo $e->getMessage();
   }

?>
