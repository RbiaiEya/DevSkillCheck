<?php
/* error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "PUT") {
   $inputData= json_decode(file_get_contents('php://input'), true);
   $update_question= update($inputData, $_GET['id']);
   echo $update_question;
}else {
    $data = 
    [
        'status'=> 405,
        'message'=> $requestMethod.' Method not Allowed'
    ];
    header("HTTP/1.0 405 Method not Allowed");
    echo json_decode($data);
} */



include_once('../dbconfig.php');

    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $id = $_POST['id']; // Assurez-vous d'obtenir correctement l'ID de la question à mettre à jour depuis la requête GET

    // Utilisez une requête préparée pour éviter les injections SQL
    $sql = "UPDATE `questions` SET `question`=?, `answer`=?, `option1`=?, `option2`=?, `option3`=?, `option4`=? WHERE `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $question, $answer, $option1, $option2, $option3, $option4, $id);

    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'Mise à jour réussie',
        ];
        http_response_code(200); // Code de réponse HTTP 200 OK
    } else {
        $response = [
            'success' => false,
            'message' => 'Échec de la mise à jour',
        ];
        http_response_code(400); // Code de réponse HTTP 400 Bad Request en cas d'échec
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    

?>