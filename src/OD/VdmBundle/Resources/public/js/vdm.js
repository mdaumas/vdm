Ext.Loader.setPath(vdm.Constants.LOADER_PATHS);

Ext.require('vdm.view.Application');

var vdmApp;
        
Ext.onReady(function () {
    vdmApp = new vdm.view.Application();
});
