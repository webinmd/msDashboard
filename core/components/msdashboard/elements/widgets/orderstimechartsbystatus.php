<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrdersTimeChartsByStatus extends modDashboardWidgetInterface
{
    public function render() {

        $dashboard = new msDashboard($this->modx);
        $config['connector_url'] = $dashboard->config['minishopConnectorUrl'];
        $config['id'] = "msdashboard-only-orders";
        $minishopConfig = array_merge($dashboard->config, $config);


        $data = $dashboard->getOrdersByStatusOnTime();
        $categories = [];
        $series = [];

        foreach($data as $key => $value) {
            $categories[] = $key;
            $series[] = $value['status'];
        }

        $cats = implode(',', $categories);


        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';
        	miniShop2.config = ' . json_encode($minishopConfig) . ';
        	msDashboard.config.connector_url = "' . $dashboard->config['connectorUrl'] . '";
            
            var options = {
                series: [
                {
                  name: "High - 2013",
                  data: [28, 29, 33, 36, 32, 32, 33]
                },
                {
                  name: "Low - 2013",
                  data: [12, 11, 14, 18, 17, 13, 13]
                }
              ],
                chart: {
                height: 280,
                type: "line",
                dropShadow: {
                  enabled: true,
                  color: "#000",
                  top: 18,
                  left: 7,
                  blur: 10,
                  opacity: 0.2
                },
                toolbar: {
                  show: false
                }
              },
              colors: ["#77B6EA", "#545454"],
              dataLabels: {
                enabled: true,
              },
              stroke: {
                curve: "smooth"
              },
              title: {
                text: "Average High & Low Temperature",
                align: "left"
              },
              grid: {
                borderColor: "#e7e7e7",
                row: {
                  colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                  opacity: 0.5
                },
              },
              markers: {
                size: 1
              },
              xaxis: {
                categories: ['.$cats.'],
                title: {
                  text: "Month"
                }
              },
              yaxis: {
                title: {
                  text: "'.$this->modx->lexicon("msdashboard_label_orders").'"
                },
                min: 5,
                max: 40
              },
              legend: {
                position: "top",
                horizontalAlign: "right",
                floating: true,
                offsetY: -25,
                offsetX: -5
              }
              };
            
              var chart = new ApexCharts(document.querySelector("#msdashboard-orders-timeharts_bystatus"), options);
              chart.render();
           
            
		});</script>');

        return '<div id="msdashboard-orders-timeharts_bystatus"></div>';
    }
}
return msDashboardOrdersTimeChartsByStatus;