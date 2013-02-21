/**
 * @class Vdm.view.desktop.Application
 * @extends Ext.app.Application
 * 
 * requires Vdm.view.desktop.Application
 * @author Marc Daumas
 * 
 * The ExtJs Desktop Application Class
 **/
Ext.define('Vdm.view.desktop.Application', {
    
    extend : "Ext.app.Application",
    
    mixins: {
        observable: 'Ext.util.Observable'
    },

    requires: [
    'Ext.container.Viewport',
    'Vdm.view.desktop.Desktop'
    ],

    modules: null,
    useQuickTips: true,
    getModules: Ext.emptyFn,

    /**
     * Called automatically when the page has completely loaded.
     * This is the Application build starting point
     */
    launch: function() {
        var me = this;
        var desktopCfg;

        if (me.useQuickTips) {
            Ext.QuickTips.init();
        }

        me.modules = me.getModules();
        if (me.modules) {
            me.initModules(me.modules);
        }

        desktopCfg = me.getDesktopConfig();
        me.desktop = new Vdm.view.desktop.Desktop(desktopCfg);

        me.viewport = new Ext.container.Viewport({
            layout: 'fit',
            items: [ me.desktop ]
        });

        Ext.EventManager.on(window, 'beforeunload', me.onUnload, me);
    },

    /**
     * Returns configuration object for the Desktop. 
     */
    getDesktopConfig: function () {
        var me = this;
        
        // Get the taskbar config and add application
        var cfg = {
            app: me,
            taskbarConfig: me.getTaskbarConfig()
        };

        // Merge with desktop config
        Ext.apply(cfg, me.desktopConfig);
        
        return cfg;
    },

    /**
     * Returns configuration object for the Start Button. 
     */
    getStartConfig: function () {
        var me = this;
        var launcher;
        
        // Define empty menu and add application
        var cfg = {
            app: me,
            menu: []
        };
        
        // Merge with startConfig
        Ext.apply(cfg, me.startConfig);

        // Initialize menu modules launcher handler functions
        // If the launcher handler function is defined for the module then use it
        // else use me.createWindow
        Ext.each(me.modules, function (module) {
            launcher = module.launcher;
            if (launcher) {
                launcher.handler = launcher.handler || Ext.bind(me.createWindow, me, [module]);
                cfg.menu.push(module.launcher);
            }
        });

        return cfg;
    },

    /**
     * Default menu launcher handler function
     **/
    createWindow: function(module) {
        var window = module.createWindow();
        window.show();
    },

    /**
     * Returns the configuration object for the TaskBar. 
     */
    getTaskbarConfig: function () {
        var me = this;
        
        // Define the Start Config and add application
        var cfg = {
            app: me,
            startConfig: me.getStartConfig()
        };

        // Merge with Start Config
        Ext.apply(cfg, me.taskbarConfig);
        
        return cfg;
    },

    /**
     * Module initialization : add the app property to each module
     */
    initModules : function(modules) {
        var me = this;
        
        Ext.each(modules, function (module) {
            module.app = me;
        });
    },

    /**
     * Return a module by name
     * 
     * @var string name the name of the module
     * 
     * @return Module object
     */
    getModule : function(name) {
        var ms = this.modules;
        
        for (var i = 0, len = ms.length; i < len; i++) {
            var m = ms[i];
            if (m.id == name || m.appType == name) {
                
                return m;
            }
        }
        return null;
    },

    /**
     * return the Desktop object
     * 
     * @return Desktop
     */
    getDesktop : function() {
        return this.desktop;
    },

    /**
     * Unload function
     * called when application ends
     */
    onUnload : function(e) {
        if (this.fireEvent('beforeunload', this) === false) {
            e.stopEvent();
        }
    }
});
