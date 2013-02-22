/**
 * @class Vdm.view.desktop.TrayClock
 * @extends Ext.toolbar.TextItem
 * 
 * This class displays a clock on the toolbar.
 */
Ext.define('Vdm.view.desktop.TrayClock', {
    extend: 'Ext.toolbar.TextItem',

    alias: 'widget.trayclock',

    cls: 'ux-desktop-trayclock',

    html: '&#160;',

    timeFormat: 'g:i A',

    tpl: '{time}',

    /**
     * Component initialization
     */
    initComponent: function () {
        var me = this;

        me.callParent();

        if (typeof(me.tpl) == 'string') {
            me.tpl = new Ext.XTemplate(me.tpl);
        }
    },

    /**
     * After Render attach update at 100ms
     */
    afterRender: function () {
        var me = this;
        Ext.Function.defer(me.updateTime, 100, me);
        me.callParent();
    },

    /**
     * Handle Toolbar destroy ; clear the timer
     */
    onDestroy: function () {
        var me = this;

        if (me.timer) {
            window.clearTimeout(me.timer);
            me.timer = null;
        }

        me.callParent();
    },

    /**
     * Draw current time then attach new update at 1s
     */
    updateTime: function () {
        var me = this;
        var time = Ext.Date.format(new Date(), me.timeFormat);
        var text = me.tpl.apply({
            time: time
        });
        
        if (me.lastText != text) {
            me.setText(text);
            me.lastText = text;
        }
        me.timer = Ext.Function.defer(me.updateTime, 1000, me);
    }
});
