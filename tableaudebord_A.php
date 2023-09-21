<?php
session_start();
   
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=garagevparrot;', 'root', '');

// Ajouter un employé
if(isset($_POST['ajouter'])){
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $bdd->prepare("INSERT INTO utilisateurs(email, mot_de_passe, role) VALUES (?, ?, ?)");
    $stmt->execute([$email, $mot_de_passe, $role]);
}

// Supprimer un employé
if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $stmt = $bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
}

// Récupérer tous les employés
$employes = $bdd->query("SELECT * FROM utilisateurs")->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- Ajouter un employé -->
    <form class="employee-form" action="" method="post">
        Email: <input class ="employee-input" type="email" name="email">
        Mot de passe: <input class ="employee-input" type="password" name="mot_de_passe">
        Role:
        <select name="role">
            <option value="admin">Admin</option>
            <option value="employe">Employé</option>
        </select>
        <input class ="employee-button"type="submit" name="ajouter" value="Ajouter">
    </form>
 <!-- Liste des employés -->
    <table border="1"class="employee_table">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach($employes as $employe): ?>
        <tr>
            <td><?= $employe['id'] ?></td>
            <td><?= $employe['email'] ?></td>
            <td><?= $employe['role'] ?></td>
            <td>
                <a href="modifier_employé.php?id=<?= $employe['id'] ?>">Modifier</a> |
                <a href="tableaudebord_A.php?delete_id=<?= $employe['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
 