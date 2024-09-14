<?php
$servername= "localhost";
$username= "root";
$password= "";
$dbname= "sportadmission";


try{
$pdoConnection = new PDO("mysql:host=$servername;dbname=$dbname", $username,$password);
    // Set the PDO error mode to exception
    $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
  echo $e-> getMessage();
  exit();
}
  ?>