Ext.define('vdm.store.LoggedUser', {
    extend: 'Ext.data.Store',
    model: 'vdm.model.LoggedUser',
    autoLoad: true,
    
    proxy: {
        type: 'ajax',
        url: vdm.Constants.LOGGED_USER_URL,
        reader: {
            type: 'json',
            root: 'users',
            successProperty: 'success'
        }
    }    
});