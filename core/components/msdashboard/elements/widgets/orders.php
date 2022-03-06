<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrders extends modDashboardWidgetInterface
{
    public function render() {

        $dashboard = new msDashboard($this->modx);

        // component css/js
        $config['connector_url'] = $dashboard->config['minishopConnectorUrl'];

        $minishopConfig = array_merge($dashboard->config, $config);

        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';
        	miniShop2.config = ' . json_encode($minishopConfig) . ';
        	msDashboard.config.connector_url = "' . $dashboard->config['connectorUrl'] . '";
		    MODx.load({
		        xtype: "minishop2-grid-orders", 
		        renderTo: "msdashboard-orders-grid"
		    });
		});</script>');


        return '<div id="msdashboard-orders-grid"></div>';
    }
}
return msDashboardOrders;