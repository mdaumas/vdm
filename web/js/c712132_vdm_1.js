var vdmApp;

// Déclaration du path de départ
Ext.Loader.setPath(Vdm.Constants.LOADER_PATHS);

// Classe de départ de construction de l'application
Ext.require('Vdm.view.Application');

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
