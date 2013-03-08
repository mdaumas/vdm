Ext.define('Ticket.view.PhoneLineGrid' ,{
    extend: 'Ext.grid.Panel',
    requires: ['Ticket.store.PhoneLine'],

    alias: 'widget.phoneline_grid',

    initComponent: function() {

        this.store = Ext.create('Ticket.store.PhoneLine');

        this.columns = [
        {
            header: this.colheaders.numero,
            dataIndex: 'number',
            flex: 1
        }
        ];

        this.callParent(arguments);
    }
});