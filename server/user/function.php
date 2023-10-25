<?php

require '../dbconfig.php';
session_start(); // Démarrer la session

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

function sign_up($data){
    global $conn;
     // Sanitize and validate the $username parameter to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $data['username']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);

    if (empty(trim($username))) {
        return error422('Enter your name');
    }elseif (empty(trim($email))) {
        return error422('Enter your email');
    }elseif (empty(trim($password))) {
        return error422('Enter your password');
    }else{
          // Check if the email already exists in the database
    $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
    $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        return error422('Email already exists');
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $query = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$hashedPassword')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 201,
            'message' => 'Account created'
        ];
        /* header("HTTP/1.0 201 Created");
        echo json_encode($data); */

        $user = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $user);
        if ($result) {
            $row = mysqli_fetch_assoc($result);

   //     die($_SESSION['id']);


        $_SESSION['auth'] = true;
        $_SESSION['loggedInUser'] = [
        'id' => $row['id'],
        'username' => $row['username'],
        'email' => $row['email'],
        'role' => $row['role'],
        ];

                header('location:../../index.php');

            }

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

function sign_in($data){
    global $conn;

    $email = mysqli_real_escape_string($conn, $data['email']);
   $password = mysqli_real_escape_string($conn, $data['password']);

   if (empty(trim($email))) {
       return error422('Enter your email');
   }elseif (empty(trim($password))) {
       return error422('Enter your password');
   }else{
    $user = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $user);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            // Maintenant, vous avez les informations de l'utilisateur, y compris le hachage de mot de passe
            $hashedPasswordFromDatabase = $row['password'];
            // Utilisez password_verify pour vérifier le mot de passe
            $verify = password_verify($password, $hashedPasswordFromDatabase);
    
            if ($verify) {
                // Le mot de passe est correct
                // Vous pouvez gérer l'authentification réussie ici
                $_SESSION['auth'] = true;
                $_SESSION['loggedInUser'] = [
                'id' => $row['id'],
                'username' => $row['username'],
                'email' => $row['email'],
                'role' => $row['role'],
                ];
    
                /* $data = [
                    'status' => 200,
                    'message' => 'logged In User',
                    'user' => $_SESSION['loggedInUser']
                ];
                header("HTTP/1.0 200 OK");
                echo json_encode($data); */

                
        if ($row['role'] == 1) { // admin
            $_SESSION['auth'] = true;
            $_SESSION['loggedInUser'] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'role' => $row['role'],
            ];
   
            header('location:../../crud.php');
           } else {
            $_SESSION['auth'] = true;
                $_SESSION['loggedInUser'] = [
                'id' => $row['id'],
                'username' => $row['username'],
                'email' => $row['email'],
                'role' => $row['role'],
                ];
   
            header('location:../../index.php');
           } 
            } else {
                // Le mot de passe ne correspond pas
                $data = [
                    'status' => 401,
                    'message' => 'Invalid Password'
                ];
                header("HTTP/1.0 401 Invalid Password");
                echo json_encode($data);
            }
        } else {
            // Aucun utilisateur trouvé avec cette adresse e-mail
            $data = [
                'status' => 400,
                'message' => 'Invalid Email'
            ];
            header("HTTP/1.0 400 Invalid Email");
            echo json_encode($data);
        }
    } else {
        // Erreur de requête SQL
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
        return json_encode($data);
    }
}
}

function profile($auth){
    if ($auth) {

    }
}

function get_user($id){ // get user by id for admin
    global $conn;
    if ($id== null) {
        return error422('Enter user id');
    }
     // Sanitize and validate the $id parameter to prevent SQL injection
     $id = mysqli_real_escape_string($conn, $id);

     // Query to retrieve user profile based on the provided id
     $query = "SELECT id, username, email FROM users WHERE id = '$id'";
     $query_run = mysqli_query($conn, $query);
 
     if ($query_run) {
         if (mysqli_num_rows($query_run) > 0) {
             $userProfile = mysqli_fetch_assoc($query_run);
             $data = [
                 'status' => 200,
                 'message' => 'User Fetched Successfully',
                 'data' => $userProfile
             ];
             return json_encode($data);
         } else {
             $data = [
                 'status' => 404,
                 'message' => 'User Not Found'
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

function getUserList(){ // get list user for admin
    global $conn;

    $query = "SELECT id, username, email FROM users"; 

    $query_run = mysqli_query($conn, $query);
    if ( $query_run) {
       if (mysqli_num_rows($query_run)>0) {
        $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        
        $data = 
        [
            'status'=> 200,
            'message'=> 'User List Fetched Successfully',
            'data'=> $res
        ];
        header("HTTP/1.0 200 Ok");
        echo json_encode($data); // Use json_encode to convert the data to JSON

       }else {
        $data = 
        [
            'status'=> 404,
            'message'=> $requestMethod.' No User Found'
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

?>