msDashboard.grid = function (config) {
    config = config || {};

    Ext.apply(config, {
        fields: this.getFields(config),
        columns: this.getColumns(config),
        url: msDashboard.config.connector_url,
        baseParams: {
            action: 'mgr/orders/getlist',
            limit: config.limit
        },
        pageSize: 10,
        paging: true
    });

    msDashboard.grid.superclass.constructor.call(this, config);
};

Ext.extend(msDashboard.grid, MODx.grid.Grid, {

    getFields: function () {
        return ['id','customer','num','cost', 'createdon'];
    },

    getColumns: function () {
        return [{
            header: 'id',
            dataIndex: 'id',
            sortable: true,
            width: 50
        }, {
            header: _('ms2_num'),
            dataIndex: 'num',
            sortable: false,
            width: 70,
        }, {
            header: _('ms2_customer'),
            dataIndex: 'customer',
            sortable: true,
            width: 100,
        }, {
            header: _('ms2_cost'),
            dataIndex: 'cost',
            sortable: true,
            width: 100,
        }, {
            header: _('ms2_createdon'),
            dataIndex: 'createdon',
            sortable: true,
            width: 100,
        }, {
            header: _('modextra_grid_actions'),
            dataIndex: 'actions',
            //renderer: modExtra.utils.renderActions,
            sortable: false,
            width: 100,
            id: 'actions'
        }];
    },

});
Ext.reg('msdashboard-orders-grid', msDashboard.grid);
