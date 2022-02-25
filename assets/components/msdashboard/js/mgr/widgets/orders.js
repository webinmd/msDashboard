msDashboard.grid = function (config) {
    config = config || {};

    Ext.apply(config, {
        //title: _('recent_docs')
        ,url: msDashboard.config.connector_url
        ,baseParams: {
            action: 'orders/getlist',
            limit: config.limit,
            pageSize: 10
            fields: ['id','customer','num','cost'],
            paging: true
        }
    });

    msDashboard.grid.superclass.constructor.call(this, config);
};

Ext.extend(msDashboard.grid, MODx.grid.Grid, {

});
Ext.reg('msdashboard-orders-grid', msDashboard.grid);
