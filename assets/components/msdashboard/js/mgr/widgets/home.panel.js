msDashboard.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'msdashboard-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('msdashboard') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('msdashboard_items'),
                layout: 'anchor',
                items: [{
                    html: _('msdashboard_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'msdashboard-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    msDashboard.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(msDashboard.panel.Home, MODx.Panel);
Ext.reg('msdashboard-panel-home', msDashboard.panel.Home);
