<?php
include './server/dbconfig.php';



global $conn;

$query = "SELECT * FROM questions"; 

$query_run = mysqli_query($conn, $query);
if ( $query_run) {
   if (mysqli_num_rows($query_run)>0) {
    $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
   }
   }

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF_8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <title>DevSkillCheck</title>
    <link type="text/css" rel="stylesheet" href="css/crud.css">
    
</head>

<body>
<?php include "navbar.php";?>
    <table>
        <tr>
            <td>
            <div class="col-5">
              <h4 class="page-title">Question Page</h4>
            <div class="col-7">
              <button type="button" class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Question
              </button>
          </div>
        </div>

                     <!-- Modal add -->
                     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                    <div class="col-lg-12 col-xlg-12 col-md-9">
                      <div class="card">
                        <div class="card-body">
                                      <!-- <form autocomplete="off" onsubmit="onFormSubmit()" class="form_actions">  -->
               <form method="post" action="./server/question/create.php" class="form_action_create" > 
                    <div>
                        <label for="question">question</label>
                        <input type="text" name="question" id="question">
                    </div>
                    <div>
                        <label for="answer">answer</label>
                        <input type="text" name="answer" id="answer">
                    </div>
                    <div>
                        <label for="option1">option1</label>
                        <input type="text" name="option1" id="option1">
                    </div>
                    <div>
                        <label for="option2">option2</label>
                        <input type="text" name="option2" id="option2">
                    </div>
                    <div>
                        <label for="option3">option3</label>
                        <input type="text" name="option3" id="option3">
                    </div>
                    <div>
                        <label for="option4">option4</label>
                        <input type="text" name="option4" id="option4">
                    </div>
                    

                    <div class="form_action--button">
                        <input type="submit" value="Submit" name="create_question">
                        <input type="reset" value="Reset">
                    </div>
                </form>
                        </div>
                      </div>
                    </div>
                    </div>
            </div>
          </div>

               <!-- Modal show -->
               <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                    <div class="col-lg-12 col-xlg-12 col-md-9">
                      <div class="card">
                        <div class="card-body">
                    <div>
                        <label for="question">question</label>
                        <div id="question_show"></div>
                    </div>
                    <div>
                        <label for="answer">answer</label>
                        <div id="answer_show"></div>
                    </div>
                    <div>
                        <label for="option1">option1</label>
                        <div id="option1_show"></div>
                    </div>
                    <div>
                        <label for="option2">option2</label>
                        <div id="option2_show"></div>
                    </div>
                    <div>
                        <label for="option3">option3</label>
                        <div id="option3_show"></div>
                    </div>
                    <div>
                        <label for="option4">option4</label>
                        <div id="option4_show"></div>
                    </div>
                        </div>
                      </div>
                    </div>
                    </div>
            </div>
          </div>

             <!-- Modal update -->
             <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                    <div class="col-lg-12 col-xlg-12 col-md-9">
                      <div class="card">
                        <div class="card-body">
                    <div>
                        <label for="question">question</label>
                        <input type="text" name="question" id="question_update">
                    </div>
                    <div>
                        <label for="answer">answer</label>
                        <input type="text" name="answer" id="answer_update">
                    </div>
                    <div>
                        <label for="option1">option1</label>
                        <input type="text" name="option1" id="option1_update">
                    </div>
                    <div>
                        <label for="option2">option2</label>
                        <input type="text" name="option2" id="option2_update">
                    </div>
                    <div>
                        <label for="option3">option3</label>
                        <input type="text" name="option3" id="option3_update">
                    </div>
                    <div>
                        <label for="option4">option4</label>
                        <input type="text" name="option4" id="option4_update">
                    </div>
                    

                    <div class="form_action--button">
                    <button name="update_question" id="updateQuestionButton"  onclick="updateQuestion()"> update</button>

                    </div>
                        </div>
                      </div>
                    </div>
                    </div>
            </div>
          </div>


                <td>
                    <table class="list" id="question-liste">
                        <thead>
                          <tr>
                          <th>N°</th>
                            <th>question</th>
                            <th>answer</th>
                            <th>option1</th>
                            <th>option2</th>
                            <th>option3</th>
                            <th>option4</th>
                            <th>actions</th>
                          </tr>
                        </thead>
                        <tbody class="list_question"> 

                        <?php
                                      if (!empty($res)) {
                                        $rowNumber = 1; // Initialiser le numéro de ligne à 1
                                          foreach ($res as $r) {
                                              echo '<tr>';
                                              echo '<th scope="row">' . $rowNumber . '</th>'; // Afficher le numéro de ligne
                                              echo '<td>' . $r['question'] . '</td>';
                                              echo '<td>' . $r['answer'] . '</td>';
                                              echo '<td>' . $r['option1'] . '</td>';
                                              echo '<td>' . $r['option2'] . '</td>';
                                              echo '<td>' . $r['option3'] . '</td>';
                                              echo '<td>' . $r['option4'] . '</td>';
                                              ?>
                                              <td scope="col-3" style="min-width: 100px; max-width: 300px;">  
                                              <div class="btn-group"> 
                                              <a href="#" onclick="showQuestion(<?php echo $r['id']; ?>);" class="btn btn-primary btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></a>
                                                <a href="#" onclick="editQuestion(<?php echo $r['id']; ?>);" class="btn btn-success btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                                 <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                                             </a>
                              
                                             <a href="#" onclick="deleteQuestion(<?php echo $r['id']; ?>);" type="button" class="btn btn-danger btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></a>
                                             </div> 
                                            </td>
                                             </tr>
 
                                             <?php

                                              $rowNumber++; 
                                          }
                                      }
                                      ?>
                        </tbody>
                      </table>                    
                </td>
            </td>
        </tr>
    </table>

    <script>
        function deleteQuestion(questionId) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette question ?")) {
                const deleteUrl = `./server/question/delete.php?id=${questionId}`;

                fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                })
                .then(response => {
                    if (response.ok) {
                    alert("La question a été supprimée avec succès.");
                    
                    window.location.href = 'crud.php';
                    } else {
                    alert("Une erreur s'est produite lors de la suppression de la question.");
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la suppression de la question :", error);
                    alert("Une erreur s'est produite lors de la suppression de la question.");
                });
            }
            }

            var questionIdToUpdate = null;


            function editQuestion(questionId) {
                questionIdToUpdate = questionId;
            $.ajax({
                url: `./server/question/read.php?id=${questionId}`, // Remplacez par le bon chemin vers le script PHP de récupération
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                if (data) {
                    // Remplissez les champs du formulaire modal avec les données récupérées
                    
                    document.getElementById("question_update").value = data.data.question;
                    document.getElementById("answer_update").value = data.data.answer;
                    document.getElementById("option1_update").value = data.data.option1;
                    document.getElementById("option2_update").value = data.data.option2;
                    document.getElementById("option3_update").value = data.data.option3;
                    document.getElementById("option4_update").value = data.data.option4;

                    // Affichez le modal d'édition
                    $('#updateModal').modal('show');
                }
                },
                error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de la question :", error);
                alert("Une erreur s'est produite lors de la récupération de la question.");
                }
            });
            }

// Associez le bouton "Update" au traitement approprié dans le JavaScript
$(document).ready(function() {
    $('#updateQuestionButton').click(function() {
        // Utilisez la variable questionIdToUpdate pour effectuer la mise à jour
        alert('ID de la question à mettre à jour : ' + questionIdToUpdate);
    });
});

function updateQuestion() {
    /* alert('ID de la question à mettre à jour : ' + questionIdToUpdate); */
               $.ajax({
        url: `./server/question/update.php`, // Remplacez par le bon chemin vers le script PHP de mise à jour
        method: 'POST', // Utilisez PUT si votre serveur le prend en charge, sinon utilisez POST
        dataType: 'json',
        data: {
            id: questionIdToUpdate,
            question: document.getElementById("question_update").value,
            answer: document.getElementById("answer_update").value,
            option1: document.getElementById("option1_update").value,
            option2: document.getElementById("option2_update").value,
            option3: document.getElementById("option3_update").value,
            option4: document.getElementById("option4_update").value
        },
        success: function(data) {
        if (data.success) {
            // La mise à jour a réussi
            alert(data.message);
            // Redirigez si nécessaire
            window.location.href = 'crud.php';
        } else {
            // Affichez un message d'erreur si la mise à jour a échoué
            alert(data.message);
        }
    },
    error: function(xhr, status, error) {
        console.error("Erreur lors de la mise à jour de la question :", error);
        alert("Une erreur s'est produite lors de la mise à jour de la question.");
    }
        
    });
    // Fermez le modal d'édition (si nécessaire)
    $('#updateModal').modal('hide');
}


function showQuestion(questionId) {
            $.ajax({
                url: `./server/question/read.php?id=${questionId}`, // Remplacez par le bon chemin vers le script PHP de récupération
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                if (data) {
                    document.getElementById("question_show").textContent = data.data.question;
                    document.getElementById("answer_show").textContent = data.data.answer;
                    document.getElementById("option1_show").textContent = data.data.option1;
                    document.getElementById("option2_show").textContent = data.data.option2;
                    document.getElementById("option3_show").textContent = data.data.option3;
                    document.getElementById("option4_show").textContent = data.data.option4;
                    $('#showModal').modal('show');
                }
                },
                error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération de la question :", error);
                alert("Une erreur s'est produite lors de la récupération de la question.");
                }
            });
            }

    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="js/crud.js"></script>
</body>
</html>