Ext.define('Ticket.model.IncomingCall', {
    extend: 'Ext.data.Model',
    fields: [
        'idkey',
        'phoneline',
        'date',
        'duration',
        'callingNumber',
        'nature'
    ]
});