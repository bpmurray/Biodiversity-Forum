<?php
   // Force this to be downloaded as CSV
   header('Content-type: text/csv;charset=utf-8');
   header('Content-Disposition: attachment; filename="attendees.csv"');

   require_once 'dbconfig.php';

   try {   
      $stmt = $db_con->prepare("SELECT * FROM users ORDER BY surname ASC, firstname ASC");
      $stmt->execute();
      while ($user = $stmt->fetch(PDO::FETCH_BOTH)) {
         echo '"' . $user['surname'] . ', ' . $user['firstname'] . '", "' .
                    $user['organisation'] . '", "' . $user['email'] . '",' .
		    ($user['token'] == ""? "'YES'" : "'NO'") . PHP_EOL;
      }
   } catch(PDOException $e) {
      echo $e->getMessage();
   }


?>
