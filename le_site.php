<?php
session_start();
   
if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=garagevparrot;', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Page html présente dans la base de donnée
$verification = $bdd->prepare("SELECT 1 FROM contenu WHERE toute_la_page_html = ?");
$verification->execute(['toute_la_page_html']);
if (!$verification->fetch()) { // If not found, then insert
    try {
        $stmt = $bdd->prepare("INSERT INTO contenu (toute_la_page_html, contenu_texte) VALUES (?, ?)");
        $stmt->execute(['toute_la_page_html', $actualPageContent]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Récupérer toute la opage html
$contenu = $bdd->query("SELECT * FROM contenu WHERE toute_la_page_html = 'toute_la_page_html'")->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['éditeurContenu'])) {
    $nouveauContenu = $_POST['éditeurContenu'];
    
    // Mise à jour du contenu
    $modification = $bdd->prepare("UPDATE contenu SET contenu_texte = ? WHERE toute_la_page_html = ?");
    $modification->execute([$nouveauContenu, 'toute_la_page_html']);
    
    // Sauvegarder sur la page html
    $file = "pagedacceuil.html";
    if (!file_put_contents($file, $nouveauContenu)) {
        echo json_encode(['success' => false, 'message' => 'Unable to write to file.']);
        exit;
    }

    echo json_encode(['success' => true]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le contenu</title>
    <script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#editor'
        });

             // Obtenir le contenu mise à jour de l'éditeur
        function saveChanges() {
            var contenuModfié = tinymce.get('editor').getContent();

            // Envoyer le contenu modifié
            fetch('', { 
                method: 'POST',
                body: new URLSearchParams({ éditeurContenu: contenuModfié }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('La page a été enregistré!');
                } else {
                    alert('Erreur.');
                }
            });
        }
            // Envoyer le contenu modifié
        function updatePageContent() {
    fetch('fetch_new_html.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                tinymce.get('editor').setContent(data.content.contenu_texte);
                alert('La page a été modifié!');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('Erreur: ' + error);
        });
}

    </script>
</head>
<body>

<form method="post" action="">
    <?php 
        foreach ($contenu as $row) {
            echo '<h4>Le contenu</h4>';  
            echo '<textarea id="editor" name="éditeurContenu">' . htmlspecialchars($row['contenu_texte']) . '</textarea>';
        }
    ?>
    <input type="button" value="Enregistrer" onclick="saveChanges()">
</form>
<button onclick="updatePageContent()">Modifier</button>
</body>
</html>

