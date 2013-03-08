Ext.define('Ticket.store.IncomingCall', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Ticket.model.IncomingCall',

    proxy: {
        type: 'ajax',
        url: Vdm.Constants.INCOMINGCALL_FIND,
        reader: {
            type: 'json',
            root: 'incomingcalls',
            successProperty: 'success'
        }
    }
});