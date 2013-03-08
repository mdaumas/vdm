Ext.define('Ticket.controller.outgoingCall', {
    extend: 'Ext.app.Controller',

    requires:[],

    views: [
    'Ticket.view.OutgoingCallGrid'
    ],
    stores: [
    'Ticket.store.OutgoingCall'
    ],
    models: [
    'Ticket.model.OutgoingCall'
    ],

    init: function(){
        console.log('Initialized Outgoing Calls');
    },

    onPanelRendered: function(){
        console.log('Outgoing Calls panel was rendered');
    }
});