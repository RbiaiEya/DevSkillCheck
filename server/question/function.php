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

function create($data){
    global $conn;
     // Sanitize and validate the $username parameter to prevent SQL injection
    $question = mysqli_real_escape_string($conn, $data['question']);
    $answer = mysqli_real_escape_string($conn, $data['answer']);
    $option1 = mysqli_real_escape_string($conn, $data['option1']);
    $option2 = mysqli_real_escape_string($conn, $data['option2']);
    $option3 = mysqli_real_escape_string($conn, $data['option3']);
    $option4 = mysqli_real_escape_string($conn, $data['option4']);


    if (empty(trim($question))) {
        return error422('question');
    }elseif (empty(trim($answer))) {
        return error422('answer');
    }elseif (empty(trim($option1))) {
        return error422('option1');
    }elseif (empty(trim($option2))) {
        return error422('option2');
    }elseif (empty(trim($option3))) {
        return error422('option3');
    }elseif (empty(trim($option4))) {
        return error422('option4');
    }else{


    $query = "INSERT INTO questions (question, answer, option1,option2,option3,option4) VALUES ('$question','$answer','$option1','$option2','$option3','$option4')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 201,
            'message' => 'Question created'
        ];
        header("HTTP/1.0 201 Created");
        echo json_encode($data);
        } else {
            $data = 
            [
                'status'=> 500,
                'message'=> $requestMethod.' Internal Server Error'
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        } 
    }

}

function get_question($id){ 
    global $conn;
    if ($id== null) {
        return error422('Enter question id');
    }
     // Sanitize and validate the $id parameter to prevent SQL injection
     $id = mysqli_real_escape_string($conn, $id);

     $query = "SELECT * FROM questions WHERE id = '$id'";
     $query_run = mysqli_query($conn, $query);
 
     if ($query_run) {
         if (mysqli_num_rows($query_run) > 0) {
             $question = mysqli_fetch_assoc($query_run);
             $data = [
                 'status' => 200,
                 'message' => 'Question Fetched Successfully',
                 'data' => $question
             ];
             return json_encode($data);
         } else {
             $data = [
                 'status' => 404,
                 'message' => 'Question Not Found'
             ];
             return json_encode($data);
         }
     } else {
         $data = [
             'status' => 500,
             'message' => 'Internal Server Error'
         ];
         return json_encode($data);
     }
}

function get_question_list(){ 
    global $conn;

    $query = "SELECT * FROM questions"; 

    $query_run = mysqli_query($conn, $query);
    if ( $query_run) {
       if (mysqli_num_rows($query_run)>0) {
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
        $data = 
        [
            'status'=> 200,
            'message'=> 'Question List Fetched Successfully',
            'questions'=> $res
        ];
        header("HTTP/1.0 200 Ok");
        echo json_encode($data); // Use json_encode to convert the data to JSON

       }else {
        $data = 
        [
            'status'=> 404,
            'message'=> $requestMethod.' No Question Found'
        ];
        header("HTTP/1.0 404 No User Found");
        echo json_encode($data); // Use json_encode to convert the data to JSON
    }
    }else {
        $data = 
        [
            'status'=> 500,
            'message'=> $requestMethod.' Internal Server Error'
        ];
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode($data); // Use json_encode to convert the data to JSON
    } 
}

function update($data, $id){
    global $conn;
    if (!isset($id)) {
        return error422('id not found in url');
    } elseif (isset($id)==null) {
        return error422('Enter the question id');
    }
    $id = mysqli_real_escape_string($conn, $id);

    $question = mysqli_real_escape_string($conn, $data['question']);
    $answer = mysqli_real_escape_string($conn, $data['answer']);
    $option1 = mysqli_real_escape_string($conn, $data['option1']);
    $option2 = mysqli_real_escape_string($conn, $data['option2']);
    $option3 = mysqli_real_escape_string($conn, $data['option3']);
    $option4 = mysqli_real_escape_string($conn, $data['option4']);


    if (empty(trim($question))) {
        return error422('question');
    }elseif (empty(trim($answer))) {
        return error422('answer');
    }elseif (empty(trim($option1))) {
        return error422('option1');
    }elseif (empty(trim($option2))) {
        return error422('option2');
    }elseif (empty(trim($option3))) {
        return error422('option3');
    }elseif (empty(trim($option4))) {
        return error422('option4');
    }else{

    $query = "UPDATE questions SET question= '$question' , answer='$answer', option1='$option1',option2='$option2',option3='$option3',option4='$option4' WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Question updated'
        ];
        header("HTTP/1.0 200 Updated");
        echo json_encode($data);
    } else {
            $data = 
            [
                'status'=> 500,
                'message'=> $requestMethod.' Internal Server Error'
            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
    } 
    }

}

function delete($id){
    global $conn;
    if (!isset($id)) {
        return error422('id not found in url');
    } elseif (isset($id)==null) {
        return error422('Enter the question id');
    }
    $id = mysqli_real_escape_string($conn, $id); 
    $query = "DELETE FROM questions WHERE id= '$id' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Question deleted'
        ];
        header("HTTP/1.0 200 Deleted");
        echo json_encode($data);
    } else {
            $data = 
            [
                'status'=> 404,
                'message'=> $requestMethod.' Question Not Found'
            ];
            header("HTTP/1.0 500 Not Found");
            echo json_encode($data);
    } 
}

?>