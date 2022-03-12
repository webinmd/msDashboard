<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrdersPieChartsByStatus extends modDashboardWidgetInterface
{
    public function render() {

        $dashboard = new msDashboard($this->modx);
        $config['connector_url'] = $dashboard->config['minishopConnectorUrl'];
        $config['id'] = "msdashboard-only-orders";
        $minishopConfig = array_merge($dashboard->config, $config);

        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';
        	miniShop2.config = ' . json_encode($minishopConfig) . ';
        	msDashboard.config.connector_url = "' . $dashboard->config['connectorUrl'] . '";
            
            
            var options = {
                chart: {
                    width: 480,
                    type: "pie",
                },
                series: [44, 55, 13, 43, 22],
                labels: ["Новый", "Оплачен", "Отправлен", "Отменен", "Оформляется"],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 400
                        },
                        legend: {
                            position: "bottom"
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#msdashboard-orders-picharts_bystatus"), options);
            chart.render();
            
		});</script>');

        return '<div id="msdashboard-orders-picharts_bystatus"></div>';
    }
}
return msDashboardOrdersPieChartsByStatus;