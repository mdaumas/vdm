Ext.define('Ticket.model.OutgoingCall', {
    extend: 'Ext.data.Model',
    fields: [
        'idkey',
        'phoneLine',
        'date',
        'duration',
        'calledNumber',
        'nature',
        'type',
        'destination',
        'price',
        'designation',
        'callingNumber',
        'dialedNumber'
    ]
});