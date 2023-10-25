<?php
// Démarrez la session (si elle n'est pas déjà démarrée)
if (session_status() === PHP_SESSION_NONE) {
   session_start();
} 
$session = false; // Initialisez $session à false par défaut

if (isset($_SESSION['auth'])) {
    $session = true;
    $id = $_SESSION['loggedInUser']['id'];
    $username = $_SESSION['loggedInUser']['username'];

}
?>

<!DOCTYPE html>
<html lang ="en">
    <head>
        <meta charset="UTF_8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DevSkillCheck</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="main">
            <header class="header">
                <a href="#"class="logo">devskillcheck</a>
                <nav class="navbar">
                    <a href="#"class="active">Home</a>
                    <a href="#"class=>About</a>
                    <a href="#"class=>Contact</a>

                    <?php
        if ($session) {
            echo '<a href="profile.php">Profile '.$username.'</a>';
            if ($_SESSION['loggedInUser']['role'] == 1) {
                echo '<a href="../crud.php">Admin</a>';
            }
            echo '<a href="../../test/index.php">Test</a></li>';
            echo '<a href="../../server/user/logout.php">Logout</a>';
        } else {
            echo '<a href="../login/index.html">Login</a>';
        }
        ?>
                </nav>
            </header>

            <div class="container">
                <section class="quiz-section">
                    <div class="quiz-box">
                        <h1>devskillcheck Quiz</h1>
                        <div class="quiz-header">
                            <span>Quiz website </span>
                            <span class="header-score">score:0/5</span>
                        </div>

                        <h2 class="question-text"></h2>
                        <div class="option-list">
                           
                        </div>
                        <div class="quiz-footer">
                            <span class="question-total"></span>
                            <button class="next-btn">Next</button>
                    </div>
                </div>

                <div class="result-box">
                    <h2>Quiz Result</h2>
                    <div class="percentage-container">
                        <div class="circular-progress">
                            <span class="progress-value">0%</span>
                        </div>
                        <span class="score-text">Your Score 0 out of 5</span>
                    </div>
                    <div class="buttons">
                        <button class="tryAgain-btn">Try Again</button>
                        <button class="goHome-btn">Go To Home</button>
                    </div>
                </div>
                </section>
                <section class="home">
                    <div class="home-content">
                        <h1>Quiz Website</h1>
                        <p>A simple and fun quiz at your service to test your skills in web programming<br>Are you ready?</p>
                        <button class="start-btn">start quiz</button>
                    </div>
                </section>
            </div>
        </main>
        <div class="popup-info">
            <h2>Quiz Guide</h2>
            <span class="info">1.fdghsjkqlhfjdkslq;hjkdslqhbfns;hfjdsk</span>
            <span class="info">2.fdghsjkqlhfjdkslq;hjkdslqhbfns;hfjdsk</span>
            <span class="info">3.fdghsjkqlhfjdkslq;hjkdslqhbfns;hfjdsk</span>
            <span class="info">4.fdghsjkqlhfjdkslq;hjkdslqhbfns;hfjdsk</span>
            <span class="info">5.fdghsjkqlhfjdkslq;hjkdslqhbfns;hfjdsk</span>
            <div class="btn-group">
                 <button class="info-btn exit-btn">Exit Quiz</button>
                 <a href="#" class="info-btn continue-btn">Continue</a>
            </div>
        </div>



        <script>
                var id = <?php echo $id; ?>;


document.addEventListener("DOMContentLoaded", function () {
    const startBtn = document.querySelector(".start-btn");
    const popupInfo = document.querySelector(".popup-info");
    const exitBtn = document.querySelector(".exit-btn");
    const main = document.querySelector(".main");
    const continueBtn = document.querySelector(".continue-btn");
    const quizSection = document.querySelector(".quiz-section");
    const quizBox = document.querySelector(".quiz-box");
    var resultBox = document.querySelector(".result-box");
    const tryAgainBtn = document.querySelector(".tryAgain-btn");
    var goHomeBtn = document.querySelector(".goHome-btn");

    // Écouteur pour le bouton "Start" (déclenche la requête AJAX)
    startBtn.addEventListener("click", function () {
        fetchQuestions();
        popupInfo.classList.add("active");
        main.classList.add("active");
    });

    // Autres parties de votre script JavaScript...

    function fetchQuestions() {
        // Utilisation de fetch pour effectuer une requête AJAX
        fetch("http://localhost/PHP_Projects/DevSkillCheck/server/question/read.php")
            .then(response => response.json())
            .then(data => {
                // Les données sont disponibles ici, vous pouvez les utiliser comme bon vous semble
              //  console.log(data);
                // Affichez les données dans l'élément HTML
                questions = data.questions;
              //  console.log(typeof questions);
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des données :", error);
            });
    }
});

document.querySelector(".goHome-btn").addEventListener("click", goHome);

function goHome() {
    goHomeBtn.addEventListener("click", function () {
      console.log("id_user ",id, "score ", userScore);
      const newTest = {
        id_user: id,
        score: userScore,
      };
      console.log("newTest avant l'envoi :", newTest);

  
      fetch("../server/test/passer_test.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(newTest),
        })
        .then((response) => {
            console.log("response ",response)
            if (response.status===200) {
            console.log("Test ajouté avec succès :", response.statusText);
            window.location.href = '../profile.php';

            } else {
            console.error("Erreur lors de l'ajout du test :", response.statusText);
            }
        })
        .catch((error) => {
            console.error("Erreur lors de la récupération des données :", error);
        });

    });
  }


</script>
        
<!--         <script src="questions.js"></script>-->       
 <script src="script.js"></script>
       </body>

</html>