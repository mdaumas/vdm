Ext.Loader.setPath(vdm.Constants.LOADER_PATHS);

Ext.require('vdm.view.App');

var vdmApp;
        
Ext.onReady(function () {
    vdmApp = new vdm.view.App();
});
