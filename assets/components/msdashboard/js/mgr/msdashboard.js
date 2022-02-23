var msDashboard = function (config) {
    config = config || {};
    msDashboard.superclass.constructor.call(this, config);
};
Ext.extend(msDashboard, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('msdashboard', msDashboard);

msDashboard = new msDashboard();