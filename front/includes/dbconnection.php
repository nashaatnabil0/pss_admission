<?php
$servername= "localhost";
$username= "root";
$password= "";
$dbname= "sportadmission";

//try {
    // Create a PDO connection
  //  $pdoConnection = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Set the PDO error mode to exception
    //$pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
    // Catch and display the error
  //  echo "Connection failed: " . $e->getMessage();
    //exit();
//}

try{
$pdoConnection = new PDO("mysql:host=localhost;dbname=$dbname", $username,$password);
    // Set the PDO error mode to exception
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
  echo $e-> getMessage();
  exit();
}
  ?>