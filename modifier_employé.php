<?php
session_start();
   
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=garagevparrot;', 'root', '');

if(!isset($_GET['id'])) {
    die("ID de l'employé non fourni.");
}

$id = $_GET['id'];

// Mettre à jour les informations de l'employé
if(isset($_POST['mettre_a_jour'])){
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $bdd->prepare("UPDATE utilisateurs SET email = ?, mot_de_passe = ?, role = ? WHERE id = ?");
    $stmt->execute([$email, $mot_de_passe, $role, $id]);
}

// Récupérer les informations de l'employé
$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$employe) {
    die("Employé non trouvé.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Employé</title>
</head>
<body>
    <h2>Modifier Employé</h2>
    <form action="" method="post">
        Email: <input type="email" name="email" value="<?= $employe['email'] ?>">
        Nouveau mot de passe (laissez vide pour ne pas changer): <input type="password" name="mot_de_passe">
        Role:
        <select name="role">
            <option value="admin" <?= $employe['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="employe" <?= $employe['role'] == 'employe' ? 'selected' : '' ?>>Employé</option>
        </select>
        <input type="submit" name="mettre_a_jour" value="Mettre à jour">
    </form>

    <a href="tableaudebord_A.php">Retour au tableau de bord</a>
</body>
</html>
