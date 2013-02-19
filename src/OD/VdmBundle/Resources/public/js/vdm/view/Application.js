Ext.define('vdm.view.Application', {
    extend: 'Ext.ux.desktop.Application',

    requires: [],
    
    loggedUser: null,
    
    launch: function(){
        var me = this;
		
        me.addEvents({
            "ready"	: true
        });

        me.callParent(arguments);
		
        Ext.Ajax.request({
            url		: vdm.Constants.LOGGED_USER_URL,
            scope	: this,
            success	: this.buildApplication,
            failure	: this.onError
        });        
    },

    buildApplication: function(response) {
        var me = this;
        var data =  Ext.decode(response.responseText);
        me.loggedUser = data.users;
        this.callParent();
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