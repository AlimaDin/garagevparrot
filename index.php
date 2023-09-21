<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bonjour.css"> 
    <title>Bienvenue</title>
</head>
<body>

<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SESSION['role'] == 'admin') {
    echo "<div class='welcome-text admin-text'>Bienvenue !</div>";
    echo "<a href='tableaudebord_A.php' class='lien-tableaudebord'>Tableau de bord</a>";
} else {
    echo "<div class='welcome-text employee-text'>Bienvenue !</div>";
    echo "<a href='tableaudebord_E.php' class='lien-tableaudebord'>Tableau de bord</a>";
}
?>

</body>
</html>
