/**
 * @class Vdm.view.desktop.TaskBar
 * @extends Ext.toolbar.Toolbar
 * 
 * TaskBar Class for the Desktop Application
 */
Ext.define('Vdm.view.desktop.TaskBar', {
    extend: 'Ext.toolbar.Toolbar',

    requires: [
    'Ext.button.Button',
    'Ext.resizer.Splitter',
    'Ext.menu.Menu',
    'Vdm.view.desktop.StartMenu'
    ],

    alias: 'widget.taskbar',

    cls: 'ux-taskbar',

    /**
     * @cfg {String} startBtnText
     * The text for the Start Button.
     */
    startBtnText: 'Start',

    /**
     * Component initalization function
     */
    initComponent: function () {
        var me = this;
        
        me.startMenu = new Vdm.view.desktop.StartMenu(me.startConfig);

        me.quickStart = new Ext.toolbar.Toolbar(me.getQuickStart());

        me.windowBar = new Ext.toolbar.Toolbar(me.getWindowBarConfig());

        me.tray = new Ext.toolbar.Toolbar(me.getTrayConfig());

        me.items = [
        {
            xtype: 'button',
            cls: 'ux-start-button',
            iconCls: 'ux-start-button-icon',
            menu: me.startMenu,
            menuAlign: 'bl-tl',
            text: me.startBtnText
        },
        '-',
        me.quickStart,
        {
            xtype: 'splitter', 
            html: '&#160;',
            height: 14, 
            width: 2, // TODO - there should be a CSS way here
            cls: 'x-toolbar-separator x-toolbar-separator-horizontal'
        },
        //'-',
        me.windowBar,
        '-',
        me.tray
        ];

        me.callParent();
    },

    /**
     * Attach the context menu
     */
    afterLayout: function () {
        var me = this;
        me.callParent();
        me.windowBar.el.on('contextmenu', me.onButtonContextMenu, me);
    },

    /**
     * Returns the configuration object for the QuickStart toolbar.
     */
    getQuickStart: function () {
        var me = this;
        
        var ret = {
            minWidth: 20,
            width: 60,
            items: [],
            enableOverflow: true
        };

        Ext.each(this.quickStart, function (item) {
            ret.items.push({
                tooltip: {
                    text: item.name, 
                    align: 'bl-tl'
                },
                //tooltip: item.name,
                overflowText: item.name,
                iconCls: item.iconCls,
                module: item.module,
                handler: me.onQuickStartClick,
                scope: me
            });
        });

        return ret;
    },

    /**
     * Returns the configuration object for the Tray toolbar. 
     */
    getTrayConfig: function () {
        var ret = {
            width: 80,
            items: this.trayItems
        };
        delete this.trayItems;
        
        return ret;
    },

    /**
     *Returns the configuration object for the WindowBar toolbar. 
     */
    getWindowBarConfig: function () {
        return {
            flex: 1,
            cls: 'ux-desktop-windowbar',
            items: [ '&#160;' ],
            layout: {
                overflowHandler: 'Scroller'
            }
        };
    },

    /**
     * Return the button of a Ext.toolbar.Toolbar
     */
    getWindowBtnFromEl: function (el) {
        var c = this.windowBar.getChildByElement(el);
        return c || null;
    },

    /**
     * Manage the click on a QuickStart button 
     */
    onQuickStartClick: function (btn) {
        var module = this.app.getModule(btn.module);
        var window;

        if (module) {
            window = module.createWindow();
            window.show();
        }
    },
    
    /**
     * Manage context menu on WindowBar buttons
     */
    onButtonContextMenu: function (e) {
        var me = this, t = e.getTarget();
        var btn = me.getWindowBtnFromEl(t);
        
        if (btn) {
            e.stopEvent();
            me.windowMenu.theWin = btn.win;
            me.windowMenu.showBy(t);
        }
    },

    /**
     * Manage click on WindowBar buttons
     */
    onWindowBtnClick: function (btn) {
        var win = btn.win;

        if (win.minimized || win.hidden) {
            win.show();
        } else if (win.active) {
            win.minimize();
        } else {
            win.toFront();
        }
    },

    /**
     * Add a button into the WindowBar Toolbar
     */
    addTaskButton: function(win) {
        var config = {
            iconCls: win.iconCls,
            enableToggle: true,
            toggleGroup: 'all',
            width: 140,
            margins: '0 2 0 3',
            text: Ext.util.Format.ellipsis(win.title, 20),
            listeners: {
                click: this.onWindowBtnClick,
                scope: this
            },
            win: win
        };

        var cmp = this.windowBar.add(config);
        cmp.toggle(true);
        return cmp;
    },

    /**
     * Remove a button into the WindowBar Toolbar
     */
    removeTaskButton: function (btn) {
        var found, me = this;
        me.windowBar.items.each(function (item) {
            if (item === btn) {
                found = item;
            }
            return !found;
        });
        if (found) {
            me.windowBar.remove(found);
        }
        return found;
    },

    /**
     * Set a button active in the WindowBar Toolbar
     */
    setActiveButton: function(btn) {
        if (btn) {
            btn.toggle(true);
        } else {
            this.windowBar.items.each(function (item) {
                if (item.isButton) {
                    item.toggle(false);
                }
            });
        }
    }
});
