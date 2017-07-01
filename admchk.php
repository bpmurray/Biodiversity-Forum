<?php
   session_start();

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
            } else if (1 != $user['admin']) {
               echo "notadmin";
            } else {
               $_SESSION["loggedin"] = $email;
               echo "loggedin";
            }
         } else{
            echo "1"; //  not available
         }
      } catch(PDOException $e) {
         echo $e->getMessage();
      }
   }

?>
