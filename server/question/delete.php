<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, DELETE");
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Request-With');
    header('HTTP/1.1 200 OK');
    exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "DELETE") {
        $delete_question = delete($_GET['id']); // appel fct
        echo $delete_question;
}else {
    $data = 
    [
        'status'=> 405,
        'message'=> $requestMethod.' Method not Allowed'
    ];
    header("HTTP/1.0 405 Method not Allowed");
    echo json_encode($data); // Use json_encode to convert the data to JSON
}
?>