Ext.define('Ticket.store.OutgoingCall', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Ticket.model.OutgoingCall',
    pageSize: 30,
    remoteSort: true,

    proxy: {
        type: 'ajax',
        url: Vdm.Constants.OUTGOINGCALL_FIND,
        reader: {
            root: 'outgoingcalls',
            successProperty: 'success',
            totalProperty: 'totalCount'
        }
    }
});