Ext.define('Ticket.store.OutgoingCall', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Ticket.model.OutgoingCall',

    proxy: {
        type: 'ajax',
        url: Vdm.Constants.OUTGOINGCALL_FIND,
        reader: {
            type: 'json',
            root: 'outgoingcalls',
            successProperty: 'success'
        }
    }
});