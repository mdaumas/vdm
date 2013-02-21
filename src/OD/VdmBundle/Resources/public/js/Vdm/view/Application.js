/**
 * @class Vdm.view.Application
 * @extends Vdm.view.desktop.Application
 * 
 * @author Marc Daumas
 *
 * The ExtJs Application class
 **/
Ext.define('Vdm.view.Application', {
    extend: 'Vdm.view.desktop.Application',

    requires: [
    'Vdm.view.desktop.Settings'
    ],
    
    getStartConfig : function() {
        var me = this;
        ret = me.callParent();

        return Ext.apply(ret, {
            title: me.loggedUser.displayName,
            iconCls: 'user',
            height: 300,
            toolConfig: {
                width: 100,
                items: [
                {
                    text: me.settingsLabel,
                    iconCls:'settings',
                    handler: me.onSettings,
                    scope: me
                },
                {
                    text: me.logoutLabel,
                    iconCls:'logout',
                    handler: me.onLogout,
                    scope: me
                }
                ]
            }
        });
    },

    /**
     * Logout handler function
     */
    onLogout: function () {
        var me = this;
        
        Ext.Msg.confirm(
            me.logoutDialogTitle, 
            me.logoutConfirmText, 
            function(button){
                if(button == "yes"){
                    document.location = me.logoutUrl;
                }
            });
    },
    
    /**
     * Settings handler function
     */
    onSettings: function () {
        var me = this;
        
        var cfg = {
            desktop: this.desktop
        };
        
        Ext.apply(cfg, me.settingsConfig);
        
        var dlg = Ext.create('Vdm.view.desktop.Settings', cfg);
        dlg.show();
    }
});