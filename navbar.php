<?php
// Démarrez la session (si elle n'est pas déjà démarrée)
if (session_status() === PHP_SESSION_NONE) {
   session_start();
} 
$session = false; // Initialisez $session à false par défaut

if (isset($_SESSION['auth'])) {
    $session = true;
    $email = $_SESSION['loggedInUser']['email'];
    $username = $_SESSION['loggedInUser']['username'];
}
?>

<nav class="col-md-9 col-xs-12">
                    <ul class="nav-list">
                        <li class="list"><a href="#">Home</a></li>
                        <li class="list"><a href="about/index1.html">About</a></li>
                        <li class="list"><a href="#">Contact</a> </li>

                        <?php
        if ($session) {
            // Si l'utilisateur est authentifié, affichez ces éléments du menu
            echo '<li class="list"><a href="profile.php">Profile '.$username.'</a></li>';
            if ($_SESSION['loggedInUser']['role'] == 1) {
                // Si l'utilisateur est un administrateur, affichez le lien vers le panneau d'administration
                echo '<li class="list"><a href="crud.php">Admin</a></li>';
            }
            echo '<li class="list"><a href="./test/index.php">Test</a></li>';
            echo '<li class="list"><a href="./server/user/logout.php">Logout</a></li>';
        } else {
            // Si l'utilisateur n'est pas authentifié, affichez le lien de connexion
            echo '<li class="list"><a href="login/index.html">Login</a></li>';
        }
        ?>

                    </ul>
                </nav>