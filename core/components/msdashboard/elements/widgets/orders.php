<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrders extends modDashboardWidgetInterface
{
    public function render() {
        //$keys = preg_replace('/\'|\"|\”|\“/','',$this->modx->getOption('settingswidget_keys'));
        $dashboard = new msDashboard($this->modx);

        //if(empty($keys)) return '<p>[[%emptykeys]]</p>';

        $this->controller->addJavascript($dashboard->config['jsUrl'].'mgr/msdashboard.js');
        $this->controller->addJavascript($dashboard->config['jsUrl'].'mgr/widgets/orders.js');
        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	SettingsWidget.config = ' . json_encode($dashboard->config) . ';
        	SettingsWidget.config.connector_url = "' . $dashboard->config['connectorUrl'] . '";
		    MODx.load({
		        xtype: "msdashboard-orders-grid",
		        renderTo: "msdashboard-orders-grid",
		        //keys: "'.$keys.'"
		    });
		});</script>');

        return '<p>[[%message]]</p>
		<br />
		<div id="msdashboard-orders-grid"></div>';
    }
}
return msDashboardOrders;