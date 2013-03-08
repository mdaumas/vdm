Ext.define('Ticket.controller.IncomingCall', {
    extend: 'Ext.app.Controller',

    requires:[],

    views: [
    'Ticket.view.IncomingCallGrid'
    ],
    stores: [
    'Ticket.store.IncomingCall'
    ],
    models: [
    'Ticket.model.IncomingCall'
    ],

    init: function(){
        console.log('Initialized Incoming Calls');
    },

    onPanelRendered: function(){
        console.log('Incoming Calls panel was rendered');
    }
});