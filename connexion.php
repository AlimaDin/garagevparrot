<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=garagevparrot;', 'root', '');

if(isset($_POST['valider'])){
    if(!empty($_POST['email']) AND !empty($_POST['mot_de_passe'])){

       $email_saisi = htmlspecialchars($_POST['email']);
       $mot_de_passe_saisi = htmlspecialchars($_POST['mot_de_passe']);

       $stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
       $stmt->execute([$email_saisi]);

       if($user = $stmt->fetch()){
           // Vérifier mot de passe 
           if(password_verify($mot_de_passe_saisi, $user['mot_de_passe'])){
               $_SESSION['user_id'] = $user['id'];
               $_SESSION['role'] = $user['role'];
               header("Location: index.php");
               exit();
           }else{
               echo "Veuillez saisir un mot de passe ou email correcte";
           }
       }else{
           echo "Utilisateur non trouvé";
       }
    }else{
        echo "Veuillez compléter tous les champs!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>s'identifier</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form class="login-form"method="POST" action="" align="center">
        <input class="login-input" type="email" name="email" placeholder="Adresse e-mail" autocomplete="off">
        <br>
        <input class="login-input" type="password" name="mot_de_passe" placeholder="Mot de passe">
        <br><br>
        <input class="login-button" type="submit" name="valider" value="Se connecter">
    </form>
</body>
</html>

