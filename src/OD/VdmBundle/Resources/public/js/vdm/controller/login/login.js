$('#login_submit_arrow').click(function() {
    submitForm();
});

$('#password').keyup(function(e) {
    if(e.keyCode=='13'){
        submitForm();
    }
});

$('#username').keyup(function(e) {
    if(e.keyCode=='13'){
        submitForm();
    }
});

function submitForm(){
    $('#sds-login-dialog-status').html('Connexion en cours. Veuillez patienter.');
    $('#login_submit').click();
}