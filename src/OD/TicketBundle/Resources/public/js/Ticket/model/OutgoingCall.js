Ext.define('Ticket.model.OutgoingCall', {
    extend: 'Ext.data.Model',
    fields: [
        'idkey',
        'phoneline',
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