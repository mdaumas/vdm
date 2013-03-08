Ext.define('Ticket.store.PhoneLine', {
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Ticket.model.PhoneLine',

    proxy: {
        type: 'ajax',
        url: Vdm.Constants.PHONELINE_FIND,
        reader: {
            type: 'json',
            root: 'phonelines',
            successProperty: 'success'
        }
    }
});