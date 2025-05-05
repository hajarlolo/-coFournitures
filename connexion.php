<?php
//  // Inclure la connexion à la base de données
$host='localhost';
$dbname='echange_scolaire';
$username='root';
$password='l0tf1710@';
try{
    $connexion=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    /* echo "connexion à la base :$dbname effectué avec succès";*/
} 
catch (PDOException $e)
{
die("impossible de se connecter à la base $dbname:" .$e->getMessage());
}
?>
