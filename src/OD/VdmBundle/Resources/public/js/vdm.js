var vdmApp;

// Les paths de l'application'
Ext.Loader.setPath(Vdm.Constants.LOADER_PATHS);

// Les requires nécessaires : en gros Vdm + les modules
Ext.require(Vdm.Constants.REQUIRES);

// Démarrage effectif
Ext.onReady(function () {

    // Appel de la configuration coté serveur
    if(Vdm.Constants.CONFIG_URL){
        Ext.Ajax.request({
            url	: Vdm.Constants.CONFIG_URL,
            success	: startup,
            failure	: error
        });
    }

    // Création de l'application
    function startup(response){
        // Décodage de la réponse à la requête de consfiguration
        var data = Ext.decode(response.responseText);

        // Création de l'instance ExtJs Application
        vdmApp = Ext.create('Vdm.view.Application', data.config);
    }

    // Erreur de démarrage
    function error(){
        alert('Startup error');
    }
});
