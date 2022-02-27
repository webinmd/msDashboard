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
        return msDashboard.config['order_fields'];
    },

    getColumns: function () {
        var all = {
            id: {width: 35},
            customer: {width: 100, renderer: function (val, cell, row) {
                    return miniShop2.utils.userLink(val, row.data['user_id'], true);
                }},
            num: {width: 50},
            receiver: {width: 100},
            createdon: {width: 75, renderer: miniShop2.utils.formatDate},
            updatedon: {width: 75, renderer: miniShop2.utils.formatDate},
            cost: {width: 50, renderer: this._renderCost},
            cart_cost: {width: 50},
            delivery_cost: {width: 75},
            weight: {width: 50},
            status: {width: 75, renderer: miniShop2.utils.renderBadge},
            delivery: {width: 75},
            payment: {width: 75},
            address: {width: 50},
            context: {width: 50},
            actions: {width: 75, id: 'actions', renderer: miniShop2.utils.renderActions, sortable: false},
        };

        var fields = this.getFields();

        var columns = [];
        for (var i = 0; i < fields.length; i++) {
            var field = fields[i];
            if (all[field]) {
                Ext.applyIf(all[field], {
                    header: _('ms2_' + field),
                    dataIndex: field,
                    sortable: true,
                });
                columns.push(all[field]);
            }
        }

        return columns;
    },

});
Ext.reg('msdashboard-orders-grid', msDashboard.grid);
