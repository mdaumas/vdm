Ext.define('Ticket.view.IncomingCallGrid' ,{
    extend: 'Ext.grid.Panel',
    requires: [
    'Ticket.store.IncomingCall',
    'Ext.PagingToolbar'
    ],

    alias: 'widget.incomingcall_grid',

    initComponent: function() {

        this.store = Ext.create('Ticket.store.IncomingCall');

        this.columns = [
        {
            header: this.colheaders.idkey,
            dataIndex: 'idkey',
            flex: 1
        },
        {
            header: this.colheaders.phoneline,
            dataIndex: 'phoneLine',
            flex: 1
        },
        {
            header: this.colheaders.date,
            dataIndex: 'date',
            flex: 1
        },
        {
            header: this.colheaders.duration,
            dataIndex: 'duration',
            flex: 1
        },
        {
            header: this.colheaders.callingNumber,
            dataIndex: 'callingNumber',
            flex: 1
        },
        {
            header: this.colheaders.nature,
            dataIndex: 'nature',
            flex: 1
        }
        ];

        this.bbar = Ext.create('Ext.PagingToolbar', {
            store: this.store,
            displayInfo: true
        });

        this.callParent(arguments);
    }
});