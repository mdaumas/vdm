Ext.define('Ticket.Module', {
    extend: 'Vdm.view.desktop.Module',

    requires:[
    'Ticket.view.PhoneLineGrid',
    'Ticket.view.IncomingCallGrid',
    'Ticket.view.OutgoingCallGrid'
    ],

    id: 'calls-win',
    iconCls: 'tabs',

    createWindow : function(){
        var me = this;
        var desktop = this.app.getDesktop();
        var win = desktop.getWindow(me.id);

        if(!win){
            win = desktop.createWindow({
                id: me.id,
                title: me.title,
                width:740,
                height:480,
                iconCls: me.iconCls,
                animCollapse:false,
                constrainHeader:true,
                layout: 'fit',
                items: [{
                    xtype: 'tabpanel',
                    activeTab:0,
                    bodyStyle: 'padding: 5px;',
                    items: [{
                        xtype: 'phoneline_grid',
                        title: me.tabs.phoneLine.title,
                        colheaders: me.tabs.phoneLine.colheaders,
                        header:false,
                        border:false
                    },{
                        xtype: 'incomingcall_grid',
                        title: me.tabs.incomingCall.title,
                        colheaders: me.tabs.incomingCall.colheaders,
                        header:false,
                        border:false
                    },{
                        xtype: 'outgoingcall_grid',
                        title: me.tabs.outgoingCall.title,
                        colheaders: me.tabs.outgoingCall.colheaders,
                        header:false,
                        border:false
                    }]
                }
                ]
            });
        }

        return win;
    }
});