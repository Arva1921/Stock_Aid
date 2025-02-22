<?php
$servername = 'localhost';
$username = 'root';
$password = '';

//connectiong to database
try 
{
    $conn= new PDO("mysql:host=$servername;dbname=stock_aid",$username,$password);
    //set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
    $error_message = $e->getMessage();
}
?>