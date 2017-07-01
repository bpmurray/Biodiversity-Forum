<?php
   session_start();
   if ($_SESSION["loggedin"] == NULL || $_SESSION["loggedin"] == "") {
      ob_start();
      header('Location: index.php');
      ob_end_flush();
      die();
   }
   require_once 'dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>Forum on Biodiversity</title>

   <!-- Latest compiled and minified bootstrap CSS -->
   <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
         integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
         crossorigin="anonymous">
   <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
         integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
         crossorigin="anonymous">

   <!-- Latest compiled and minified JQuery -->
   <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

   <link href="styles/style.css" rel="stylesheet" type="text/css" media="screen">

</head>

<body>

   <div class="container">
      <div class="agenda">
         <div class="date">Attendees</div>
         <table>
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Organisation</th>
                  <th>E-mail address</th>
                  <th>Confirmed</th>
               </tr>
            </thead>
            <tbody>
<?php
   try {   
      $stmt = $db_con->prepare("SELECT * FROM users ORDER BY surname ASC, firstname ASC");
      $stmt->execute();
      $count = $stmt->rowCount();
      while ($user = $stmt->fetch(PDO::FETCH_BOTH)) {
         echo "<tr>";
         echo "<td>" . $user['surname'] . ', ' . $user['firstname'] . "</td>";
         echo "<td>" . $user['organisation'] . "</td>";
         echo "<td>" . $user['email'] . "</td>";
	 if ($user['token'] == "") {
            echo "<td></td>";
	 } else {
            echo "<td style='text-align:center'>No</td>";
	 }
         echo "</tr>";
      }
   } catch(PDOException $e) {
      echo $e->getMessage();
   }

?>

            </tbody>
         </table>
         <br />
         <div style="text-align:center">
	 Total number registered: <?php echo $count; ?>
         </div>
      </div>
      <br />
      <div class="agenda" style="text-align:center">
         <a href="dumpcsv.php" class="ui-button ui-widget ui-corner-all">
	    <span class="glyphicon glyphicon-log-in"></span> &nbsp;
            Download the list as CSV
         </a>
      </div>
   </div>

   <!-- Latest compiled and minified JavaScript -->
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
           integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
           crossorigin="anonymous"></script>

</body>
</html>

