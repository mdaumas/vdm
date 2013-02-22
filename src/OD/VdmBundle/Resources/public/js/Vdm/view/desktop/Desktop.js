/**
 * @class Vdm.view.desktop.Desktop
 * @extends Ext.panel.Panel
 * <p>This class manages the wallpaper, shortcuts and taskbar.</p>
 */
Ext.define('Vdm.view.desktop.Desktop', {
    extend: 'Ext.panel.Panel',

    alias: 'widget.desktop',

    uses: [
    'Ext.util.MixedCollection',
    'Ext.menu.Menu',
    'Ext.view.View', // dataview
    'Ext.window.Window',

    'Vdm.view.desktop.TaskBar',
    'Vdm.view.desktop.Wallpaper'
    ],

    activeWindowCls: 'ux-desktop-active-win',
    inactiveWindowCls: 'ux-desktop-inactive-win',
    lastActiveWindow: null,

    border: false,
    html: '&#160;',
    layout: 'fit',

    xTickSize: 1,
    yTickSize: 1,

    app: null,

    /**
     * @cfg {Array|Store} shortcuts
     * The items to add to the DataView. This can be a {@link Ext.data.Store Store} or a
     * simple array. Items should minimally provide the fields in the
     * {@link Vdm.view.desktop.ShorcutModel ShortcutModel}.
     */
    shortcuts: null,

    /**
     * @cfg {String} shortcutItemSelector
     * This property is passed to the DataView for the desktop to select shortcut items.
     * If the {@link #shortcutTpl} is modified, this will probably need to be modified as
     * well.
     */
    shortcutItemSelector: 'div.ux-desktop-shortcut',

    /**
     * @cfg {String} shortcutTpl
     * This XTemplate is used to render items in the DataView. If this is changed, the
     * {@link shortcutItemSelect} will probably also need to changed.
     */
    shortcutTpl: [
    '<tpl for=".">',
    '<div class="ux-desktop-shortcut" id="{name}-shortcut">',
    '<div class="ux-desktop-shortcut-icon {iconCls}">',
    '<img src="',Ext.BLANK_IMAGE_URL,'" title="{name}">',
    '</div>',
    '<span class="ux-desktop-shortcut-text">{name}</span>',
    '</div>',
    '</tpl>',
    '<div class="x-clear"></div>'
    ],

    /**
     * @cfg {Object} taskbarConfig
     * The config object for the TaskBar.
     */
    taskbarConfig: null,

    windowMenu: null,

    /**
     * Initialize the desktop component
     */
    initComponent: function () {
        var me = this;

        me.windowMenu = new Ext.menu.Menu(me.createWindowMenu());

        me.bbar = me.taskbar = new Vdm.view.desktop.TaskBar(me.taskbarConfig);
        me.taskbar.windowMenu = me.windowMenu;

        me.windows = new Ext.util.MixedCollection();

        me.contextMenu = new Ext.menu.Menu(me.createDesktopMenu());

        me.items = [
        {
            xtype: 'wallpaper', 
            id: me.id+'_wallpaper'
        },
        me.createDataView()
        ];

        me.callParent();

        me.shortcutsView = me.items.getAt(1);
        me.shortcutsView.on('itemclick', me.onShortcutItemClick, me);

        var wallpaper = me.wallpaper;
        me.wallpaper = me.items.getAt(0);
        if (wallpaper) {
            me.setWallpaper(wallpaper, me.wallpaperStretch);
        }
    },

    afterRender: function () {
        var me = this;
        me.callParent();
        me.el.on('contextmenu', me.onDesktopMenu, me);
    },

    //------------------------------------------------------
    // Overrideable configuration creation methods

    /**
     * Desktop data view
     */
    createDataView: function () {
        var me = this;
        return {
            xtype: 'dataview',
            overItemCls: 'x-view-over',
            trackOver: true,
            itemSelector: me.shortcutItemSelector,
            store: me.shortcuts,
            style: {
                position: 'absolute'
            },
            x: 0, 
            y: 0,
            tpl: new Ext.XTemplate(me.shortcutTpl)
        };
    },

    /**
     * Create Desktop context menu
     */
    createDesktopMenu: function () {
        var me = this, ret = {
            items: me.contextMenuItems || []
        };

        if (ret.items.length) {
            ret.items.push('-');
        }

        ret.items.push(
        {
            text: me.contextMenuTileLabel, 
            handler: me.tileWindows, 
            scope: me, 
            minWindows: 1
        },
        {
            text: me.contextMenuCascadeLabel, 
            handler: me.cascadeWindows, 
            scope: me, 
            minWindows: 1
        })

        return ret;
    },

    /**
     * Create Window context menu
     */
    createWindowMenu: function () {
        var me = this;
        return {
            defaultAlign: 'br-tr',
            items: [
            {
                text: me.createWindowRestoreLabel, 
                handler: me.onWindowMenuRestore, 
                scope: me
            },
            {
                text: me.createWindowMinimizeLabel, 
                handler: me.onWindowMenuMinimize, 
                scope: me
            },
            {
                text: me.createWindowMaximizeLabel, 
                handler: me.onWindowMenuMaximize, 
                scope: me
            },
            '-',
            {
                text: me.createWindowCloseLabel, 
                handler: me.onWindowMenuClose, 
                scope: me
            }
            ],
            listeners: {
                beforeshow: me.onWindowMenuBeforeShow,
                hide: me.onWindowMenuHide,
                scope: me
            }
        };
    },

    /**
     * Display Desktop context menu 
     */
    onDesktopMenu: function (e) {
        var me = this, menu = me.contextMenu;
        e.stopEvent();
        if (!menu.rendered) {
            menu.on('beforeshow', me.onDesktopMenuBeforeShow, me);
        }
        menu.showAt(e.getXY());
        menu.doConstrain();
    },

    /**
     * Enable desktop context menu items
     */
    onDesktopMenuBeforeShow: function (menu) {
        var me = this, count = me.windows.getCount();

        menu.items.each(function (item) {
            var min = item.minWindows || 0;
            item.setDisabled(count < min);
        });
    },

    /**
     * Manage click on desktop shortcut
     */
    onShortcutItemClick: function (dataView, record) {
        var me = this, module = me.app.getModule(record.data.module),
        win = module && module.createWindow();

        if (win) {
            me.restoreWindow(win);
        }
    },

    /**
     * Remove TaskBar button of Window
     */
    onWindowClose: function(win) {
        var me = this;
        me.windows.remove(win);
        me.taskbar.removeTaskButton(win.taskButton);
        me.updateActiveWindow();
    },

    /**
     * Desable Window Menu items
     */
    onWindowMenuBeforeShow: function (menu) {
        var items = menu.items.items;
        var win = menu.theWin;
        
        items[0].setDisabled(win.maximized !== true && win.hidden !== true); // Restore
        items[1].setDisabled(win.minimized === true); // Minimize
        items[2].setDisabled(win.maximized === true || win.hidden === true); // Maximize
    },

    /**
     * Handle click on Close Window Menu Item
     */
    onWindowMenuClose: function () {
        var me = this;
        var win = me.windowMenu.theWin;

        win.close();
    },

    /**
     * Hide Window Menu
     */
    onWindowMenuHide: function (menu) {
        menu.theWin = null;
    },

    /**
     * Handle click on Maximize Window menu Item
     */
    onWindowMenuMaximize: function () {
        var me = this;
        var win = me.windowMenu.theWin;

        win.maximize();
        win.toFront();
    },

    /**
     * Handle click on Minimize Window menu Item
     */
    onWindowMenuMinimize: function () {
        var me = this, win = me.windowMenu.theWin;

        win.minimize();
    },

    /**
     * Handle click on Restore Window menu Item
     */
    onWindowMenuRestore: function () {
        var me = this;
        var win = me.windowMenu.theWin;

        me.restoreWindow(win);
    },

    /**
     * Return current wallpaper
     */
    getWallpaper: function () {
        
        return this.wallpaper.wallpaper;
    },

    /**
     * Set size of Windows resizer 
     */
    setTickSize: function(xTickSize, yTickSize) {
        var me = this;
        var xt = me.xTickSize = xTickSize;
        var yt = me.yTickSize = (arguments.length > 1) ? yTickSize : xt;

        me.windows.each(function(win) {
            var dd = win.dd;
            var resizer = win.resizer;
            
            dd.xTickSize = xt;
            dd.yTickSize = yt;
            resizer.widthIncrement = xt;
            resizer.heightIncrement = yt;
        });
    },

    /**
     * Set the Desktop Wallpaper
     */
    setWallpaper: function (wallpaper, stretch) {
        this.wallpaper.setWallpaper(wallpaper, stretch);
        
        return this;
    },

    /**
     * Cascade Windows
     */
    cascadeWindows: function() {
        var x = 0, y = 0,
        zmgr = this.getDesktopZIndexManager();

        zmgr.eachBottomUp(function(win) {
            if (win.isWindow && win.isVisible() && !win.maximized) {
                win.setPosition(x, y);
                x += 20;
                y += 20;
            }
        });
    },

    /**
     * Create a new Window on Desktop
     */
    createWindow: function(config, cls) {
        var me = this;
        var win;
        var cfg = Ext.applyIf(config || {}, {
            stateful: false,
            isWindow: true,
            constrainHeader: true,
            minimizable: true,
            maximizable: true
        });

        cls = cls || Ext.window.Window;
        win = me.add(new cls(cfg));

        me.windows.add(win);

        win.taskButton = me.taskbar.addTaskButton(win);
        win.animateTarget = win.taskButton.el;

        win.on({
            activate: me.updateActiveWindow,
            beforeshow: me.updateActiveWindow,
            deactivate: me.updateActiveWindow,
            minimize: me.minimizeWindow,
            destroy: me.onWindowClose,
            scope: me
        });

        win.on({
            boxready: function () {
                win.dd.xTickSize = me.xTickSize;
                win.dd.yTickSize = me.yTickSize;

                if (win.resizer) {
                    win.resizer.widthIncrement = me.xTickSize;
                    win.resizer.heightIncrement = me.yTickSize;
                }
            },
            single: true
        });

        // replace normal window close w/fadeOut animation:
        win.doClose = function ()  {
            win.doClose = Ext.emptyFn; // dblclick can call again...
            win.el.disableShadow();
            win.el.fadeOut({
                listeners: {
                    afteranimate: function () {
                        win.destroy();
                    }
                }
            });
        };

        return win;
    },

    /**
     * Return the Desktop active window based on zindex
     */
    getActiveWindow: function () {
        var win = null,
        zmgr = this.getDesktopZIndexManager();

        if (zmgr) {
            // We cannot rely on activate/deactive because that fires against non-Window
            // components in the stack.

            zmgr.eachTopDown(function (comp) {
                if (comp.isWindow && !comp.hidden) {
                    win = comp;
                    return false;
                }
                return true;
            });
        }

        return win;
    },

    /**
     * Return the Zindex manager
     */
    getDesktopZIndexManager: function () {
        var windows = this.windows;
        // TODO - there has to be a better way to get this...
        return (windows.getCount() && windows.getAt(0).zIndexManager) || null;
    },

    /**
     * Get Window by id
     */
    getWindow: function(id) {
        return this.windows.get(id);
    },

    /**
     * Minimize a Window
     */
    minimizeWindow: function(win) {
        win.minimized = true;
        win.hide();
    },

    /**
     * Restore a Window
     */
    restoreWindow: function (win) {
        if (win.isVisible()) {
            win.restore();
            win.toFront();
        } else {
            win.show();
        }
        return win;
    },

    /**
     * Tile Desktop Windows
     */
    tileWindows: function() {
        var me = this;
        var availWidth = me.body.getWidth(true);
        var x = me.xTickSize;
        var y = me.yTickSize;
        var nextY = y;

        me.windows.each(function(win) {
            if (win.isVisible() && !win.maximized) {
                var w = win.el.getWidth();

                // Wrap to next row if we are not at the line start and this Window will
                // go off the end
                if (x > me.xTickSize && x + w > availWidth) {
                    x = me.xTickSize;
                    y = nextY;
                }

                win.setPosition(x, y);
                x += w + me.xTickSize;
                nextY = Math.max(nextY, y + win.el.getHeight() + me.yTickSize);
            }
        });
    },

    /**
     * Visualy activate a Window
     */
    updateActiveWindow: function () {
        var me = this;
        var activeWindow = me.getActiveWindow();
        var last = me.lastActiveWindow;
        
        if (activeWindow === last) {
            return;
        }

        if (last) {
            if (last.el.dom) {
                last.addCls(me.inactiveWindowCls);
                last.removeCls(me.activeWindowCls);
            }
            last.active = false;
        }

        me.lastActiveWindow = activeWindow;

        if (activeWindow) {
            activeWindow.addCls(me.activeWindowCls);
            activeWindow.removeCls(me.inactiveWindowCls);
            activeWindow.minimized = false;
            activeWindow.active = true;
        }

        me.taskbar.setActiveButton(activeWindow && activeWindow.taskButton);
    }
});
