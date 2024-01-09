//redirect to page that show the list filed one student had submitted
function redirectToStudentHomework(id) {
    var url = "../homework/" + id;

    window.location.href = url;
}

//click on edit button
function editExercise() {
    var editExercise = document.getElementById('edit-exercise');
    var exerciseHead = document.getElementById('exercise-head');

    if (editExercise) {
        if (editExercise.classList.contains('display-none')) {
            editExercise.classList.remove('display-none');
        }
    }

    if (exerciseHead) {
        if (!exerciseHead.classList.contains('display-none')) {
            exerciseHead.classList.add('display-none');
        }
    }

}

//delete exercise
function deleteExercise() {
    var form = document.getElementById('delete-exercise');

    if (form) {
        form.submit();
    }
}

//delete one homework file
function homeworkDelete(length) {
    var deleteHomeworkButton = document.getElementById('delete-homework-button');

    if (deleteHomeworkButton) {
        deleteHomeworkButton.innerHTML = deleteHomeworkButton.innerHTML == 'Xoá' ? 'Xong' : 'Xoá';

        if (deleteHomeworkButton.classList.contains('cancel-button')) {
            deleteHomeworkButton.classList.remove('cancel-button');
            deleteHomeworkButton.classList.add('ok-button');
        } else {
            deleteHomeworkButton.classList.remove('ok-button');
            deleteHomeworkButton.classList.add('cancel-button');
        }
    }

    for (let i = 0; i < length; i++) {
        var downloadForm = document.getElementById('download-form-' + i);
        var deleteForm = document.getElementById('delete-form-' + i);

        if (downloadForm && deleteForm) {
            if (downloadForm.classList.contains('display-none')) {
                downloadForm.classList.remove('display-none');
                deleteForm.classList.add('display-none');
            } else {
                downloadForm.classList.add('display-none');
                deleteForm.classList.remove('display-none');
            }
        }
    }
}

//click on delete icon on homework file tile
function onClickDeleteIcon(index) {
    var deleteForm = document.getElementById('delete-form-' + index);

    if (deleteForm) {
        deleteForm.submit();
    }
}

//cancel the edit exercise process
function cancel() {
    var editExercise = document.getElementById('edit-exercise');
    var exerciseHead = document.getElementById('exercise-head');

    if (editExercise) {
        if (!editExercise.classList.contains('display-none')) {
            editExercise.classList.add('display-none');
        }
    }

    if (exerciseHead) {
        if (exerciseHead.classList.contains('display-none')) {
            exerciseHead.classList.remove('display-none');
        }
    }

}