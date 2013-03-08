Ext.define('Ticket.controller.PhoneLine', {
    extend: 'Ext.app.Controller',

    requires:[],

    views: [
    'Ticket.view.PhoneLineGrid'
    ],
    stores: [
    'Ticket.store.PhoneLine'
    ],
    models: [
    'Ticket.model.PhoneLine'
    ],

    init: function(){
        console.log('Initialized Phone Lines');
    },

    onPanelRendered: function(){
        console.log('Phone Line panel was rendered');
    }
});