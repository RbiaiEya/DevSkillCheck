<?php
include_once('../dbconfig.php');

if(isset($_POST['create_question']))
{
    $question=$_POST['question'];
    $answer=$_POST['answer'];
    $option1=$_POST['option1'];
    $option2=$_POST['option2'];
    $option3=$_POST['option3'];
    $option4=$_POST['option4'];

    $query = "INSERT INTO questions (question, answer, option1,option2,option3,option4) VALUES ('$question','$answer','$option1','$option2','$option3','$option4')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 201,
            'message' => 'Question created'
        ];

        header('location:../../crud.php');
        } else {
           die(mysqli_error($conn)) ;
        } 
}

?>


<?php
/* error_reporting(0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Content-Type: application/json');


include('function.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "POST") {
    // Get the request body data as JSON
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (!empty($inputData)) {
        // Handle the valid JSON data
        $add_question = create($inputData);
        echo json_encode($add_question);
    } else {
        // Handle the case where the request body is empty
        $data = [
            'status' => 400,
            'message' => 'Bad Request: Missing or invalid JSON data',
        ];
        http_response_code(400);
        echo json_encode($data);
    }
} else {
    // Handle the case where the request method is not allowed
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method not Allowed',
    ];
    http_response_code(405);
    echo json_encode($data);
} */
?>