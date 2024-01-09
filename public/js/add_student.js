function editProfile(role) {
    var form = document.getElementById('addStudentForm');
    
    if (form) {
        form.submit();
    }
}

//Preview avatar
function uploadAvatar(input) {
    const file = input.files[0];

    if (file) {
        // Display the selected image
        const avatarImage = document.getElementById('avatar-image');
        const reader = new FileReader();

        reader.onload = function (e) {
            avatarImage.src = e.target.result;
            
        };
        reader.readAsDataURL(file);
    }
}