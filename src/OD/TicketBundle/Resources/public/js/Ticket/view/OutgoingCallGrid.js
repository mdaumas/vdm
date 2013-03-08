Ext.define('Ticket.view.OutgoingCallGrid' ,{
    extend: 'Ext.grid.Panel',
    requires: ['Ticket.store.OutgoingCall'],

    alias: 'widget.outgoingcall_grid',

    initComponent: function() {

        this.store = Ext.create('Ticket.store.OutgoingCall');

        this.columns = [
        {
            header: this.colheaders.idkey,
            dataIndex: 'idkey',
            flex: 1
        },
        {
            header: this.colheaders.phoneline,
            dataIndex: 'phoneline',
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
            header: this.colheaders.calledNumber,
            dataIndex: 'calledNumber',
            flex: 1
        },
        {
            header: this.colheaders.nature,
            dataIndex: 'nature',
            flex: 1
        },
        {
            header: this.colheaders.type,
            dataIndex: 'type',
            flex: 1
        },
        {
            header: this.colheaders.destination,
            dataIndex: 'destination',
            flex: 1
        },
        {
            header: this.colheaders.price,
            dataIndex: 'price',
            flex: 1
        },
        {
            header: this.colheaders.designation,
            dataIndex: 'designation',
            flex: 1
        },
        {
            header: this.colheaders.callingNumber,
            dataIndex: 'callingNumber',
            flex: 1
        },
        {
            header: this.colheaders.dialedNumber,
            dataIndex: 'dialedNumber',
            flex: 1
        }
        ];

        this.callParent(arguments);
    }
});