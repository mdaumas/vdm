Ext.define('Ticket.controller.PhoneLine', {
    extend: 'Ext.app.Controller',

    requires:[

    ],

    views: [
    'Ticket.view.PhoneLineGrid'
    ],

    init: function(){
        console.log('Initialized Users! This happens before the Application launch function is called');
    },

    onPanelRendered: function(){
        console.log('The panel was rendered');
    }
});