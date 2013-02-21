var vdmApp;

Ext.Loader.setPath(Vdm.Constants.LOADER_PATHS);
    
Ext.require('Vdm.view.Application');
                
Ext.onReady(function () {
    
    Ext.Ajax.request({
        url	: Vdm.Constants.CONFIG_URL,
        success	: startup,
        failure	: error
    });
    
    function startup(response){
        var data = Ext.decode(response.responseText);
        
        vdmApp = Ext.create('Vdm.view.Application', data.config);   
    }
    
    function error(){
        alert('Startup error');
    }
});
