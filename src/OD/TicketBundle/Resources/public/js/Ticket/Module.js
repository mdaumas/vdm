Ext.define('Ticket.Module', {
    extend: 'Vdm.view.desktop.Module',

    requires:['Ticket.controller.PhoneLine'],

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
                    }]
                }
                ]
            });
        }

        return win;
    }
});