//When onclick in table row, redirect to profile of this user
function redirectToProfile(userId) {
    var profileUrl = '/profile?user_id=' + userId;

    window.location.href = profileUrl;
}