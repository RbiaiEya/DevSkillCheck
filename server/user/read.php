<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "GET") {
    if (isset($_GET['id'])) {
        $get_user = get_user($_GET['id']);
        echo $get_user;
    }else {
        $userList = getUserList(); // appel fct
        echo $userList;
    }
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