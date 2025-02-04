
function openLoginPopup() {
    document.getElementById('loginPopup').style.display = 'flex';
}

function closeLoginPopup() {
    document.getElementById('loginPopup').style.display = 'none';
}

function toggleForms(formType) {
    document.getElementById('registration-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'none';

    if (formType === 'registration') {
        document.getElementById('registration-form').style.display = 'block';
    } else if (formType === 'login') {
        document.getElementById('login-form').style.display = 'block';
    }
}
