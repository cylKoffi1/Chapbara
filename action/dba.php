<?php
$nomServeur = "localhost";
$username = "root";
$password ="";
$dbname ="chapbara";

//creer connexion 
$bdd= new PDO("mysql:host=$nomServeur;dbname=$dbname;charset=utf8",$username,$password);
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
