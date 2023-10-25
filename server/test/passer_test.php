<?php
include_once('../dbconfig.php');
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

    $id_user = $data->id_user;
    $score = $data->score;
    $created_at = time();
    $date = date("Y-m-d H:i:s", $created_at);
    
    // Modifiez votre requête SQL pour inclure trois signes de substitution
    $query = "INSERT INTO tests (id_user, score, created_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    // Utilisez "iss" dans bind_param pour spécifier trois types de données : entier, entier, chaîne
    $stmt->bind_param("iis", $id_user, $score, $date);

if ($stmt->execute()) {
    
    $data = [
        'status' => 201,
        'message' => 'test created'
    ];

    header('location:../../test/index.php');
} else {
    // Gérez l'erreur ici
    echo "Erreur lors de la création du test : " . $stmt->error;
}

$stmt->close();

?>