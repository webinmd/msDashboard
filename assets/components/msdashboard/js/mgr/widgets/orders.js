msDashboard.ordersGrid = function (config) {
    config = config || {};

    Ext.apply(config, {
        fields: this.getFields(config),
        columns: this.getColumns(config),
        url: msDashboard.config.connector_url,
        listeners: this.getListeners(config),
        baseParams: {
            action: 'mgr/orders/getlist',
            limit: config.limit
        },
        pageSize: 10,
        paging: true
    });

    msDashboard.ordersGrid.superclass.constructor.call(this, config);
};

Ext.extend(msDashboard.ordersGrid, MODx.grid.Grid, {

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
            comment: {width: 50},
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

    getListeners: function () {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateOrder(grid, e, row);
            },
            afterrender: function (grid) {
                var params = miniShop2.utils.Hash.get();
                var order = params['order'] || '';
                if (order) {
                    this.updateOrder(grid, Ext.EventObject, {data: {id: order}});
                }
            },
        };
    },

    updateOrder: function (btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/orders/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = Ext.getCmp('minishop2-window-order-update');
                        if (w) {
                            w.close();
                        }

                        w = MODx.load({
                            xtype: 'minishop2-window-order-update',
                            id: 'minishop2-window-order-update',
                            record: r.object,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                },
                                hide: {
                                    fn: function () {
                                        miniShop2.utils.Hash.remove('order');
                                        if (miniShop2.grid.Orders.changed === true) {
                                            Ext.getCmp('minishop2-grid-orders').getStore().reload();
                                            miniShop2.grid.Orders.changed = false;
                                        }
                                    }
                                },
                                afterrender: function () {
                                    miniShop2.utils.Hash.add('order', r.object['id']);
                                }
                            }
                        });
                        w.fp.getForm().reset();
                        w.fp.getForm().setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    },

    removeOrder: function () {
        var ids = this._getSelectedIds();

        Ext.MessageBox.confirm(
            _('ms2_menu_remove_title'),
            ids.length > 1
                ? _('ms2_menu_remove_multiple_confirm')
                : _('ms2_menu_remove_confirm'),
            function (val) {
                if (val == 'yes') {
                    this.orderAction('remove');
                }
            },
            this
        );
    },

    _renderCost: function (val, idx, rec) {
        return rec.data['type'] != undefined && rec.data['type'] == 1
            ? '-' + val
            : val;
    },



    _getSelectedIds: function () {
        var ids = [];
        var selected = this.getSelectionModel().getSelections();

        for (var i in selected) {
            if (!selected.hasOwnProperty(i)) {
                continue;
            }
            ids.push(selected[i]['id']);
        }

        return ids;
    },


});
Ext.reg('msdashboard-orders-grid', msDashboard.ordersGrid);
