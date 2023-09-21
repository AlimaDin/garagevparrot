<?php

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=garagevparrot;', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
$response = [];
try {
    $content = $bdd->query("SELECT contenu_texte FROM contenu WHERE toute_la_page_html = 'toute_la_page_html'")->fetch(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['content'] = $content;
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = "Error fetching content: " . $e->getMessage();
}
echo json_encode($response);
?>

