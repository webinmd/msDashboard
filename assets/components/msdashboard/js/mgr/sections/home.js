msDashboard.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'msdashboard-panel-home',
            renderTo: 'msdashboard-panel-home-div'
        }]
    });
    msDashboard.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(msDashboard.page.Home, MODx.Component);
Ext.reg('msdashboard-page-home', msDashboard.page.Home);