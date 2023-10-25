var selectedRow = null;

console.log("Crud Question");

// Définissez l'URL à partir de laquelle vous souhaitez récupérer des données
/* var url = "http://localhost/PHP_Projects/devskillcheck_api/question/read.php"; */

// Utilisez JavaScript pour effectuer une requête AJAX
var xhr = new XMLHttpRequest();
xhr.open("GET", url, true);

//console.log("url ", url, " xhr ", xhr);
document.addEventListener("DOMContentLoaded", function () {
  xhr.onreadystatechange = function () {
    //console.log("Ready state:", xhr.readyState);

    if (xhr.readyState === 4) {
      // Check if the request is complete
      if (xhr.status === 200) {
        var responseData = xhr.responseText;
        var jsonData = JSON.parse(responseData);
        var questionsData = jsonData.questions; // Définissez questionsData avec les données récupérées

        console.log("typeof question ", typeof questionsData);

        // Sélectionnez le tableau tbody où vous souhaitez afficher les données
        const tbody = document.querySelector(".list tbody");

        // Assurez-vous que vous avez des données à afficher
        if (questionsData && Array.isArray(questionsData)) {
          // Parcourez chaque question dans les données
          questionsData.forEach((question) => {
            // Créez une nouvelle ligne de tableau
            const newRow = document.createElement("tr");

            // Créez des cellules de tableau pour chaque propriété de la question
            const questionCell = document.createElement("td");
            questionCell.textContent = question.question;

            const answerCell = document.createElement("td");
            answerCell.textContent = question.answer;

            const option1Cell = document.createElement("td");
            option1Cell.textContent = question.option1;

            const option2Cell = document.createElement("td");
            option2Cell.textContent = question.option2;

            const option3Cell = document.createElement("td");
            option3Cell.textContent = question.option3;

            const option4Cell = document.createElement("td");
            option4Cell.textContent = question.option4;

            const actions = document.createElement("td");

            const editButton = document.createElement("button");
            editButton.textContent = "Edit";
            editButton.onclick = "onEdit(td)";

            editButton.addEventListener("click", function () {
              onEdit(question);
            });

            const deleteButton = document.createElement("button");
            deleteButton.textContent = "Supp";

            deleteButton.addEventListener("click", function () {
              // Récupérez l'ID de la question associée à cette ligne du tableau
              const questionID = question.id; // Supposons que l'ID de la question soit stocké dans la variable "question.id"

              // Effectuez une requête HTTP DELETE pour supprimer la question
              const deleteURL = `http://localhost/PHP_Projects/devskillcheck_api/question/delete.php?id=${questionID}`;
              console.log("deleteURL ", deleteURL);
              const xhrDelete = new XMLHttpRequest();
              xhrDelete.open("DELETE", deleteURL, true);

              xhrDelete.onreadystatechange = function () {
                if (xhrDelete.readyState === 4) {
                  if (xhrDelete.status === 200) {
                    // La question a été supprimée avec succès, vous pouvez mettre à jour l'interface ici si nécessaire
                    console.log("Question supprimée avec succès.");
                    // Supprimez également la ligne du tableau correspondante de l'interface
                    newRow.remove();
                  } else {
                    console.error(
                      "Erreur lors de la suppression de la question. Status code:",
                      xhrDelete.status
                    );
                  }
                }
              };

              xhrDelete.send();
            });

            // Ajoutez les boutons à la cellule "actions"
            actions.appendChild(editButton);
            actions.appendChild(deleteButton);

            // Ajoutez les cellules à la ligne du tableau
            newRow.appendChild(questionCell);
            newRow.appendChild(answerCell);
            newRow.appendChild(option1Cell);
            newRow.appendChild(option2Cell);
            newRow.appendChild(option3Cell);
            newRow.appendChild(option4Cell);

            newRow.appendChild(actions);

            // Ajoutez la ligne du tableau au tbody
            tbody.appendChild(newRow);
          });
        }
      } else {
        console.error(
          "Erreur lors de la récupération des données. Status code:",
          xhr.status
        );
      }
    }
  };

  xhr.send(); // Don't forget to actually send the request.
});

function onFormSubmit(e) {
  event.preventDefault();
  var formData = readFormData();
  if (selectedRow == null) {
    insertNewRecord(formData);
  } else {
    updateRecord(formData);
  }
  resetForm();
}

//Retrieve the data
function readFormData() {
  var formData = {};
  formData["question"] = document.getElementById("question").value;
  formData["answer"] = document.getElementById("answer").value;
  formData["option1"] = document.getElementById("option1").value;
  formData["option2"] = document.getElementById("option1").value;
  formData["option3"] = document.getElementById("option1").value;
  formData["option4"] = document.getElementById("option1").value;

  return formData;
}

//Insert the data
function insertNewRecord(data) {
  /*  var table = document
    .getElementById("question-liste")
    .getElementsByTagName("tbody")[0];
  var newRow = table.insertRow(table.length);
  cell1 = newRow.insertCell(0);
  cell1.innerHTML = data.question;
  cell2 = newRow.insertCell(1);
  cell2.innerHTML = data.answer;
  cell3 = newRow.insertCell(2);
  cell3.innerHTML = data.option1;
  cell4 = newRow.insertCell(3);
  cell4.innerHTML = data.option2;
  cell5 = newRow.insertCell(4);
  cell5.innerHTML = data.option3;
  cell6 = newRow.insertCell(5);
  cell6.innerHTML = data.option4;

  cell6.innerHTML = `<button onClick="onEdit(this)">Edit</button> <button onClick="onDelete(this)">Delete</button>`; */

  const createURL =
    "http://localhost/PHP_Projects/devskillcheck_api/question/create.php";
  const xhrCreate = new XMLHttpRequest();
  xhrCreate.open("POST", createURL, true);
  xhrCreate.setRequestHeader("Content-Type", "application/json");
  
  xhrCreate.onreadystatechange = function () {
    console.log("Ready state:", xhrCreate.readyState);
    console.log("Status code:", xhrCreate.status);
    console.log("Response:", xhrCreate.responseText);
  
    if (xhrCreate.readyState === 4) {
      if (xhrCreate.status === 201) {
        console.log("Question created successfully.");
      } else {
        console.error("Error creating the question. Status code:", xhrCreate.status);
      }
    }
  };
  
  console.log("data ", data);
  xhrCreate.send(JSON.stringify(data));
}

//Edit the data
function onEdit(td) {
  document.querySelector(".form_action_create").style.display = "none";
  document.querySelector(".form_action_update").style.display = "block";

  /*   selectedRow = td.parentElement.parentElement;
  document.getElementById("question").value = selectedRow.cells[0].innerHTML;
  document.getElementById("answer").value = selectedRow.cells[1].innerHTML;
  document.getElementById("option1").value = selectedRow.cells[2].innerHTML;
  document.getElementById("option2").value = selectedRow.cells[3].innerHTML;
  document.getElementById("option3").value = selectedRow.cells[4].innerHTML;
  document.getElementById("option4").value = selectedRow.cells[5].innerHTML; */

  console.log("td ", td);
  // selectedRow = td.parentElement.parentElement;
  document.getElementById("id").value = td.id;
  document.getElementById("question_update").value = td.question;
  document.getElementById("answer_update").value = td.answer;
  document.getElementById("option1_update").value = td.option1;
  document.getElementById("option2_update").value = td.option2;
  document.getElementById("option3_update").value = td.option3;
  document.getElementById("option4_update").value = td.option4;

  const updateButton = document.createElement("button");
  updateButton.textContent = "Update";

  const formActionsDiv = document.querySelector(".form_action_update");
  formActionsDiv.appendChild(updateButton);

 /*  updateButton.addEventListener("click", function () {
    const questionID = td.id;

    const updateURL = `http://localhost/PHP_Projects/devskillcheck_api/question/update.php?id=${questionID}, `;
    console.log("updateURL ", updateURL);
    const xhrUpdate = new XMLHttpRequest();
    xhrUpdate.open("PUT", updateURL, true);

    xhrUpdate.onreadystatechange = function () {
      if (xhrUpdate.readyState === 4) {
        if (xhrUpdate.status === 200) {
          // La question a été supprimée avec succès, vous pouvez mettre à jour l'interface ici si nécessaire
          console.log("Question modifier avec succès.");
          // Supprimez également la ligne du tableau correspondante de l'interface
          newRow.remove();
        } else {
          console.error(
            "Erreur lors de la modification de la question. Status code:",
            xhrUpdate.status
          );
        }
      }
    };

    xhrDelete.send();
  }); */
}


/* function updateRecord(formData) {
  selectedRow.cells[0].innerHTML = formData.question;
  selectedRow.cells[1].innerHTML = formData.answer;
  selectedRow.cells[2].innerHTML = formData.option1;
  selectedRow.cells[3].innerHTML = formData.option2;
  selectedRow.cells[4].innerHTML = formData.option3;
  selectedRow.cells[5].innerHTML = formData.option4;
} */

//Delete the data
function onDelete(td) {
  if (confirm("Do you want to delete this record?")) {
    row = td.parentElement.parentElement;
    document.getElementById("question-liste").deleteRow(row.rowIndex);
    resetForm();
  }
}

//Reset the data
function resetForm() {
  document.getElementById("question").value = "";
  document.getElementById("answer").value = "";
  document.getElementById("option1").value = "";
  document.getElementById("option2").value = "";
  document.getElementById("option3").value = "";
  document.getElementById("option4").value = "";

  selectedRow = null;
}
