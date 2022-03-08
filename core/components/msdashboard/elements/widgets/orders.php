<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrders extends modDashboardWidgetInterface
{
    public function render() {

        $hasOrderWidget = false;

        // checking for double minishop order widgets
        $groups = $this->modx->user->getUserGroups(); // current user groups
        $panel = $this->modx->getObject('modUserGroup', $groups[0]);
        $dashboardId = $panel->get('dashboard');

        $query = $this->modx->newQuery('modDashboardWidget');
        $query->limit(2);
        $query->where([
            'name:IN' => ['msDashboardOrders', 'msDashboardFullOrdersPanel']
        ]);
        $query->select('id');

        $query->prepare();
        $query->stmt->execute();
        $widgetIds = [];
        if($widgets = $query->stmt->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($widgets as $w) {
                $widgetIds[] = $w['id'];
            }
        }

        if(count($widgetIds) > 1) {
            $qp = $this->modx->newQuery('modDashboardWidgetPlacement');
            $qp->limit(2);
            $qp->where([
                'dashboard' => $dashboardId,
                'widget:IN' => $widgetIds
            ]);

            if($this->modx->getCount('modDashboardWidgetPlacement',$qp) > 1) {
                $hasOrderWidget = true;
            }
        }

        if($hasOrderWidget) {
            return $this->modx->lexicon('msdashboard_order_widget_error');
        }

        $dashboard = new msDashboard($this->modx);
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