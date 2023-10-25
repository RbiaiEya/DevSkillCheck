<?php

require '../dbconfig.php';

function error422($message){
    $data = 
        [
            'status'=> 422,
            'message'=> $message
        ];
        header("HTTP/1.0 422 Internal Server Error");
        echo json_encode($data); // Use json_encode to convert the data to JSON
        exit();
}


?>