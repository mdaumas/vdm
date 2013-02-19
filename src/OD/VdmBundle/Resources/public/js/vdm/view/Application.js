Ext.define('vdm.view.Application', {
    extend: 'Ext.ux.desktop.Application',

    requires: [
        'vdm.store.LoggedUser'
    ],
    
    loggedUser: null,

    init: function() {
        var me = this;
        me.loggedUser =  new vdm.store.LoggedUser().sync();
        this.callParent();
    },

    getStartConfig : function() {
        var me = this, ret = me.callParent();

        return Ext.apply(ret, {
            title: me.loggedUser.username,
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
            function(button){
                if(button == "yes"){
                    document.location = vdm.Constants.LOGOUT_URL;
                }
            });
    }
});