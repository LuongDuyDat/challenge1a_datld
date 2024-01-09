//when onclick edit icon
function editProfile(role) {
    var editModeElements = document.querySelectorAll('.edit-mode');

    //make input field for profile information visible
    editModeElements.forEach(function(element) {
        if (role == 0 || (element.getAttribute('name') != 'username' && element.getAttribute('name') != 'fullName')) {
            element.style.display = element.style.display === 'none' ? 'block' : 'none';
        }
    });

    var spanElements = document.querySelectorAll('.profile-field span');
    spanElements.forEach(function(element) {
        if (role == 0 || element.getAttribute('name') != 'not-none') {
            element.style.display = element.style.display === 'none' ? 'block' : 'none';
        }
    });

    //Show edit input for Full Name for teacher
    if (role == 0) {
        var lableName = document.getElementById('label-name');
        lableName.style.display = lableName.style.display === 'none' ? 'block' : 'none';
    }

    //Change edit icon to save icon
    var form = document.getElementById('editProfileForm');
    var editIcon = document.querySelector('.edit-icon i');
    if (editIcon.classList.contains('fa-edit')) {
        editIcon.classList.remove('fa-edit');
        editIcon.classList.add('fa-save');
    } else {
        form.submit();
    }
    
}

function deleteProfile() {
    var form = document.getElementById('deleteProfileForm');
    if (form) {
        form.submit();
    }    
}

function editMessage(icon, i) {
    console.log(icon);
    var messageItem = icon.closest('.message-item');
    var messageText = messageItem.querySelector('p');
    var messageInput = messageItem.querySelector('input');

    if (icon.classList.contains('fa-edit')) {
        icon.classList.remove('fa-edit');
        icon.classList.add('fa-save');
        messageText.style.display = 'none';
        messageInput.style.display = 'block';
        messageInput.focus();
    } else {
        var formId = "edit-message-form-" + i;
        var form = document.getElementById(formId);

        if (form) {
            form.submit();
        }
    }

}

function deleteMessage(i) {
    var formId = "delele-message-form-" + i;
    var form = document.getElementById(formId);

    if (form) {
        form.submit();
    }
}

function uploadAvatar(input) {
    const file = input.files[0];

    if (file) {
        console.log(file);
        // Display the selected image
        var formId = "avatar-form";
        var form = document.getElementById(formId);

        if (form) {
            form.submit();
        }
    }
}        
