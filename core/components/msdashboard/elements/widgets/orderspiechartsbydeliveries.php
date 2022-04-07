<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrdersPieChartsByDeliveries extends modDashboardWidgetInterface
{
    public function render() {

        $dashboard = new msDashboard($this->modx);
        $data = $dashboard->getOrdersByDeliveries();

        $series = implode(',', $data["series"]);
        $labels = '"'.implode('","', $data["labels"]).'"';

        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';    	
            
            var options = {
                chart: {
                    width: 450,
                    type: "donut",
                }, 
                series: ['.$series.'],
                labels: ['.$labels.']
            };

            var chart = new ApexCharts(document.querySelector("#msdashboard-orders-picharts_bydeliveries"), options);
            chart.render();            
            
		});</script>');

        return '<div id="msdashboard-orders-picharts_bydeliveries" class="msdashboard-pie-chart"></div>';
    }
}

return 'msDashboardOrdersPieChartsByDeliveries';