Ext.application({
    name: 'VdmPhone',
    launch: function() {
        Ext.create('Ext.container.Viewport', {
            layout: 'fit',
            items: [
            {
                title: 'Viséo Desktop Manager',
                html : 'Hello! Welcome to Viseo Desktop Manager Ext JS Application.'
            }
            ]
        });
    }
});