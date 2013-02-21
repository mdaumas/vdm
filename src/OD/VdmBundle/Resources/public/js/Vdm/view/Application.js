Ext.define('Vdm.view.Application', {
    extend: 'Ext.ux.desktop.Application',

    requires: [],
    
    launch: function(){
        var me = this;
		
        me.addEvents({
            "ready"	: true
        });

        me.callParent(arguments);
    },

    getStartConfig : function() {
        var me = this, ret = me.callParent();

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