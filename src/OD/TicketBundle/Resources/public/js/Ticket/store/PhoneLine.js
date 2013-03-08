Ext.define('Ticket.store.PhoneLine', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Ticket.model.PhoneLine',
    pageSize: 30,
    remoteSort: true,

    proxy: {
        type: 'ajax',
        url: Vdm.Constants.PHONELINE_FIND,
        reader: {
            root: 'phonelines',
            successProperty: 'success',
            totalProperty: 'totalCount'
        }
    }
});