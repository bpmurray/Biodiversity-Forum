<?php

   require_once 'dbconfig.php';

   if ($_POST)
   {
      $firstname    = $_POST['firstname'];
      $surname      = $_POST['surname'];
      $organisation = $_POST['organisation'];
      $email        = $_POST['email'];
      $password     = $_POST['password'];
      $timestamp    = date('Y-m-d H:i:s');
      $salt         = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
      $options      = [ 'cost' => 11, 'salt' => $salt ];
      $password     = base64_encode(password_hash($password, PASSWORD_BCRYPT, $options));
      $token        = base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));

      try
      {   

         $stmt = $db_con->prepare("SELECT * FROM users WHERE email=:email");
         $stmt->execute(array(":email"=>$email));
         $count = $stmt->rowCount();

         if ($count==0) { 
            $stmt = $db_con->prepare("INSERT INTO users(firstname,surname,organisation,email,password,salt,token,timestamp) VALUES(:firstname, :surname, :organisation, :email, :pass, :salt, :token, :timestamp)");
            $stmt->bindParam(":firstname", $firstname);
            $stmt->bindParam(":surname", $surname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pass", $password);
            $stmt->bindParam(":salt", $salt);
            $stmt->bindParam(":token", $token);
            $stmt->bindParam(":timestamp", $timestamp);
            $stmt->bindParam(":organisation", $organisation);

            if ($stmt->execute()) {
               $counter = $settings['counter'] - 1;
               $stmt = $db_con->prepare("UPDATE settings SET counter=:counter WHERE id=1;");
               $stmt->bindParam(":counter", $counter);
               $stmt->execute();

               $subject = 'Please confirm your attendance';
               $message = '<html><head>
                     <title>Biodiversity Forum Registration</title>
                     </head><body><h1>Biodiversity Forum Registration</h1>
                     Dear ' . $firstname . '<br /><br />
                     Please confirm your attendance at the event by clicking
		     <a href="https://biodiversityforum.eu/confirmation.php?x=' . urlencode($token) .
                     '">here</a>.<br /><br />Regards<br />Registration Team</body></html>';

               $headers = 'From: registration@biodiversityforum.eu' . "\n" .
                          'Reply-To: reghistration@biodiversityforum.eu' . "\n" .
                          'Content-type: text/html; charset=utf-8' . "\n" .
                          'X-Mailer: PHP/' . phpversion();

               mail($email, $subject, $message, $headers);
          
               echo "registered";
            } else {
               echo "Query could not execute !";
            }
         } else{
            echo "1"; //  not available
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   }

?>
