<?php

   require_once 'dbconfig.php';

   if ($_POST)
   {
      $email     = $_POST['email'];
      $password  = $_POST['password'];

      try
      {   
         $stmt = $db_con->prepare("SELECT * FROM users WHERE email=:email");
         $stmt->execute(array(":email"=>$email));
         $count = $stmt->rowCount();

         if ($count==1) { 
            $user = $stmt->fetch(PDO::FETCH_BOTH);

            $salt     = $user['salt'];
            $options  = [ 'cost' => 11, 'salt' => $salt ];
            $password = base64_encode(password_hash($password, PASSWORD_BCRYPT, $options));
            if ($password != $user['password']) {
               echo "badpassword";
            } else {
               $stmt = $db_con->prepare("DELETE FROM users WHERE email=:email");
               $stmt->bindParam(":email", $email);
   
               if ($stmt->execute()) {
                  $counter = $settings['counter'] + 1;
                  $stmt = $db_con->prepare("UPDATE settings SET counter=:counter WHERE id=1;");
                  $stmt->bindParam(":counter", $counter);
                  $stmt->execute();

		  $timestamp = date("Y-m-d H:i:s");
		  $action = "Deleted registration";
                  $stmt = $db_con->prepare("INSERT INTO transactions (who,action,timestamp) VALUES(:who,:action,:timestamp)");
                  $stmt->bindParam(":who", $email);
                  $stmt->bindParam(":timestamp", $timestamp);
                  $stmt->bindParam(":action", $action);
                  $stmt->execute();

                  $subject = 'Your registration has been cancelled';
                  $message = '<html><head>
                     <title>Biodiversity Forum Registration</title>
                     </head><body><h3>Cancellation of your Biodiversity Forum Registration</h3>
                     Dear ' . $user['firstname'] . '<br /><br />
                     This is to confirm cancellation of your attendance at
                     the 2017 Biodiversity Forum event.<br /><br />Regards<br />
                     The Registration Team.</body></html>';
                  $headers = 'From: registration@biodiversityforum.eu' . "\n" .
                           'Reply-To: reghistration@biodiversityforum.eu' . "\n" .
                           'Content-type: text/html; charset=utf-8' . "\n" .
                           'X-Mailer: PHP/' . phpversion();
   
                  mail($email, $subject, $message, $headers);
                  echo "deleted";
               } else {
                  echo "Query could not execute !";
               }
            }
         } else{
            echo "1"; //  not available
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   }

?>
