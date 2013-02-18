Ext.onReady(function(){
    Ext.get('login_submit_arrow').on('click', function() {
        submitForm();
    });
    
    Ext.get('password').on('keyup', function(e) {
        if(e.keyCode=='13'){
            submitForm();
        }
    });
    
    Ext.get('password').on('keyup', function(e) {
        if(e.keyCode=='13'){
            submitForm();
        }
    });
  
    function submitForm(){  
        Ext.get('sds-login-dialog-status').update('Connexion en cours. Veuillez patienter.');
        Ext.get('login_submit').dom.click();
    }
});
