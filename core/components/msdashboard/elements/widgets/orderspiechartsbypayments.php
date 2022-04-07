<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrdersPieChartsByPayments extends modDashboardWidgetInterface
{
    public function render() {

        $dashboard = new msDashboard($this->modx);
        $data = $dashboard->getOrdersByPayments();

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

            var chart = new ApexCharts(document.querySelector("#msdashboard-orders-picharts_bypayments"), options);
            chart.render();            
            
		});</script>');

        return '<div id="msdashboard-orders-picharts_bypayments" class="msdashboard-pie-chart"></div>';
    }
}

return 'msDashboardOrdersPieChartsByPayments';