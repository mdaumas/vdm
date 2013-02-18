Ext.define('vdm.view.App', {
    extend: 'Ext.ux.desktop.App',

    requires: [
    ],

    init: function() {
        // custom logic before getXYZ methods get called...
        this.callParent();
    // now ready...
    },

    // config for the start menu
    getStartConfig : function() {
        var me = this, ret = me.callParent();

        return Ext.apply(ret, {
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
        Ext.Msg.confirm(
            'Deconnexion', 
            'Voulez-vous vraiment vous deconnecter?', 
            function(b){
                if(b == "yes"){
                    document.location = vdm.Constants.LOGOUT_URL;
                }
            });
    }
});