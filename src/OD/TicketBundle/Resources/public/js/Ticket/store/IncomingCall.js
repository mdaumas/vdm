Ext.define('Ticket.store.IncomingCall', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Ticket.model.IncomingCall',
    pageSize: 30,
    remoteSort: true,

    proxy: {
        type: 'ajax',
        url: Vdm.Constants.INCOMINGCALL_FIND,
        reader: {
            root: 'incomingcalls',
            successProperty: 'success',
            totalProperty: 'totalCount'
        }
    }
});