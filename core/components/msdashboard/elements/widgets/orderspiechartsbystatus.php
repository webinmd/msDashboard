<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrdersPieChartsByStatus extends modDashboardWidgetInterface
{
    public function render() {

        $dashboard = new msDashboard($this->modx);
        $config['connector_url'] = $dashboard->config['minishopConnectorUrl'];
        $config['id'] = "msdashboard-only-orders";
        $minishopConfig = array_merge($dashboard->config, $config);

        $data = $dashboard->getOrdersByStatus();

        $series = implode(',', $data["series"]);
        $labels = '"'.implode('","', $data["labels"]).'"';

        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';
        	miniShop2.config = ' . json_encode($minishopConfig) . ';	
            
            var options = {
                chart: {
                    width: 450,
                    type: "pie",
                }, 
                series: ['.$series.'],
                labels: ['.$labels.']
            };

            var chart = new ApexCharts(document.querySelector("#msdashboard-orders-picharts_bystatus"), options);
            chart.render();            
            
		});</script>');

        return '<div id="msdashboard-orders-picharts_bystatus"></div>';
    }
}

return 'msDashboardOrdersPieChartsByStatus';