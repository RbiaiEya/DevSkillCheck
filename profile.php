<?php
include './server/dbconfig.php';

global $conn;
// Démarrez la session (si elle n'est pas déjà démarrée)
if (session_status() === PHP_SESSION_NONE) {
   session_start();
} 
$session = false; // Initialisez $session à false par défaut

if (isset($_SESSION['auth'])) {
    $session = true;
    $email = $_SESSION['loggedInUser']['email'];
    $username = $_SESSION['loggedInUser']['username'];
    $id = $_SESSION['loggedInUser']['id'];

    $test_query = "SELECT tests.*, users.username AS username, users.email AS email
FROM tests
INNER JOIN users ON tests.id_user = users.id WHERE tests.id_user = $id";

$test_run = mysqli_query($conn, $test_query);
if ( $test_run) {
if (mysqli_num_rows($test_run)>0) {
 $tests = mysqli_fetch_all($test_run, MYSQLI_ASSOC);
}
}
}
if (!$session) {
    // Rediriger vers une page d'erreur 404
    header('HTTP/1.1 404 Not Found');
    include('error-404.html'); // Inclure le contenu de la page d'erreur 404
    exit(); // Arrêter l'exécution du script
  }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>home</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
            <div class="profile">
                <h2>User Name : <?php echo  $username ?> </h2>
                <a href=""class="btn">update profile</a>
                <a href="./server/user/logout.php" class="delete-btn">Logout</a>
                 <p>new<a href="" > login </a> or <a href="" > register</a></p>
            </div>
        </div>


        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Tests </h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Scrore</th>
                                            <th scope="col">Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      if (!empty($tests)) {
                                        $rowNumber = 1; // Initialiser le numéro de ligne à 1
                                          foreach ($tests as $t) {
                                              echo '<tr>';
                                              echo '<th scope="row">' . $rowNumber . '</th>'; // Afficher le numéro de ligne
                                              echo '<td>' . $t['username'] . '</td>';
                                              echo '<td>' . $t['email'] . '</td>';
                                              echo '<td>' . $t['score'] . '</td>';
                                              echo '<td>' . (!empty($t['created_at']) ? date('Y-m-d H:i:s', strtotime($t['created_at'])) : '') . '</td>';
                                              ?>
                                            </tr>

                                            <?php
                                              $rowNumber++; // Incrémenter le numéro de ligne pour la prochaine itération
                                          }
                                      }
                                      ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

                </body>
</html>