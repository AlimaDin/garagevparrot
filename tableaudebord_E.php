<?php
session_start();
   
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=garagevparrot;', 'root', '');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="tableaudebord.css">
</head>
<body>
    <header>
<ul class="menu">
    <li><a href="le_site.php">Voir le site</a></li>
    <li><a href="déconnexion.php">se déconnecter</a></li> 
        </ul>
        </header>
</body>
</html>