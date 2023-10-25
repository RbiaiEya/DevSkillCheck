var selectedRow = null

function onFormSubmit(e) {
	event.preventDefault();
        var formData = readFormData();
        if (selectedRow == null){
            insertNewRecord(formData);
		}
        else{
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
    var table = document.getElementById("question-liste").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.length);
    cell1 = newRow.insertCell(0);
		cell1.innerHTML = data.question;
    cell2 = newRow.insertCell(1);
		cell2.innerHTML = data.answer;
    cell3 = newRow.insertCell(2);
		cell3.innerHTML = data.option1;
        cell4 = newRow.insertCell(3);
		cell4.innerHTML = data.option2;
        cell5= newRow.insertCell(4);
		cell5.innerHTML = data.option3;
        cell6 = newRow.insertCell(5);
		cell6.innerHTML = data.option4;
    
        cell6.innerHTML = `<button onClick="onEdit(this)">Edit</button> <button onClick="onDelete(this)">Delete</button>`;
}

//Edit the data
function onEdit(td) {
    selectedRow = td.parentElement.parentElement;
    document.getElementById("question").value = selectedRow.cells[0].innerHTML;
    document.getElementById("answer").value = selectedRow.cells[1].innerHTML;
    document.getElementById("option1").value = selectedRow.cells[2].innerHTML;
    document.getElementById("option2").value = selectedRow.cells[3].innerHTML;
    document.getElementById("option3").value = selectedRow.cells[4].innerHTML;
    document.getElementById("option4").value = selectedRow.cells[5].innerHTML;

}
function updateRecord(formData) {
    selectedRow.cells[0].innerHTML = formData.question;
    selectedRow.cells[1].innerHTML = formData.answer;
    selectedRow.cells[2].innerHTML = formData.option1;
    selectedRow.cells[3].innerHTML = formData.option2;
    selectedRow.cells[4].innerHTML = formData.option3;
    selectedRow.cells[5].innerHTML = formData.option4;

}

//Delete the data
function onDelete(td) {
    if (confirm('Do you want to delete this record?')) {
        row = td.parentElement.parentElement;
        document.getElementById('question-liste').deleteRow(row.rowIndex);
        resetForm();
    }
}

//Reset the data
function resetForm() {
    document.getElementById("question").value = '';
    document.getElementById("answer").value = '';
    document.getElementById("option1").value = '';
    document.getElementById("option2").value = '';
    document.getElementById("option3").value = '';
    document.getElementById("option4").value = '';

    selectedRow = null;
}