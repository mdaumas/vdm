Ext.define('Ticket.model.IncomingCall', {
    extend: 'Ext.data.Model',
    fields: [
        'idkey',
        'phoneLine',
        'date',
        'duration',
        'callingNumber',
        'nature'
    ]
});