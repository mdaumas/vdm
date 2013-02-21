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

    requires: [],
    
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
                    text:'Logout',
                    iconCls:'logout',
                    handler: me.onLogout,
                    scope: me
                }
                ]
            }
        });
    },

    onLogout: function () {
        var me = this;
        Ext.Msg.confirm(
            'Deconnexion', 
            'Voulez-vous vraiment vous deconnecter?', 
            function(button){
                if(button == "yes"){
                    document.location = me.logoutUrl;
                }
            });
    }
});