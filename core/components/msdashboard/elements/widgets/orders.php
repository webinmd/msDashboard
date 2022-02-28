<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrders extends modDashboardWidgetInterface
{
    public function render() {
        $dashboard = new msDashboard($this->modx);

        // minishop styles
        $this->controller->addCss($dashboard->config['minishopCssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->controller->addCss($dashboard->config['minishopCssUrl'] . 'mgr/main.css');

        // minishop js
        $this->controller->addJavascript($dashboard->config['minishopJsUrl'].'mgr/minishop2.js');
        $this->controller->addJavascript($dashboard->config['minishopJsUrl'].'mgr/misc/default.grid.js');
        $this->controller->addJavascript($dashboard->config['minishopJsUrl'].'mgr/misc/default.window.js');
        $this->controller->addJavascript($dashboard->config['minishopJsUrl'].'mgr/misc/strftime-min-1.3.js');
        $this->controller->addJavascript($dashboard->config['minishopJsUrl'].'mgr/misc/ms2.utils.js');
        $this->controller->addJavascript($dashboard->config['minishopJsUrl'].'mgr/orders/orders.window.js');


        // component css/js
        $this->controller->addCss($dashboard->config['cssUrl'].'mgr/main.css');
        $this->controller->addJavascript($dashboard->config['jsUrl'].'mgr/msdashboard.js');
        $this->controller->addJavascript($dashboard->config['jsUrl'].'mgr/widgets/orders.js');

        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';
        	miniShop2.config = ' . json_encode($dashboard->config) . ';
        	msDashboard.config.connector_url = "' . $dashboard->config['connectorUrl'] . '";
		    MODx.load({
		        xtype: "msdashboard-orders-grid",
		        renderTo: "msdashboard-orders-grid"
		    });
		});</script>');

        return '<div id="msdashboard-orders-grid"></div>';
    }
}
return msDashboardOrders;