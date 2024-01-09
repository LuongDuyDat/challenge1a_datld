//redirect to specify exercise
function redirectToSpecifyExercise(id) {
    // Construct the URL with the user_id parameter
    var url = '/exercise/' + id;

    // Redirect to the profile page
    window.location.href = url;
}