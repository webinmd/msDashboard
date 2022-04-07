<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrdersTimeChartsByStatus extends modDashboardWidgetInterface
{
    public function render()
    {

        $dashboard = new msDashboard($this->modx);
        $config['connector_url'] = $dashboard->config['minishopConnectorUrl'];
        $config['id'] = "msdashboard-only-orders";
        $minishopConfig = array_merge($dashboard->config, $config);

        $dataStat = $dashboard->getOrdersByStatusOnTime();
        $categories = [];
        $series = [];
        $colors = [];
        $min = 0;
        $max = 10;

        foreach ($dataStat as $key => $value) {

            $categories[] = $key;

            foreach ($value as $in_val) {
                $colors[] = $in_val['color'];

                if ($max < $in_val['count_orders']) {
                    $max = $in_val['count_orders'];
                }

                if (isset($series[$in_val['status_title']]) && $series[$in_val['status_title']]['name'] == $in_val['status_title']) {
                    $data = $series[$in_val['status_title']]['data'];
                    array_push($data, $in_val['count_orders']);
                } else {
                    $data[] = $in_val['count_orders'];
                }

                $series[$in_val['status_title']] = [
                    'name' => $in_val['status_title'],
                    'data' => $data
                ];

                unset($data);
            }
        }


        $statuses = [];

        foreach ($series as $k => $v) {
            $statuses[] = $v;
        }


        $cats = '"' . implode('","', $categories) . '"';
        $colorsList = '"#' . implode('","#', array_unique($colors)) . '"';


        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        	msDashboard.config = ' . json_encode($dashboard->config) . ';
        	miniShop2.config = ' . json_encode($minishopConfig) . ';
            
            var options = {
                series: ' . json_encode($statuses, JSON_UNESCAPED_UNICODE) . ',
                chart: {
                    height: 284,
                    width: "97%",
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
              colors: [' . $colorsList . '],
              dataLabels: {
                enabled: true,
              },
              stroke: {
                curve: "smooth"
              },
              title: {
                text: "' . $this->modx->lexicon("msdashboard_timecharts_label_statuses") . '",
                align: "left"
              },
              grid: {
                borderColor: "#e7e7e7",
                position: "back",
                row: {
                  colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                  opacity: 0.5
                },
              },
              markers: {
                size: 1
              },
              xaxis: {
                categories: [' . $cats . ']
              },
              yaxis: {
                title: {
                  text: "' . $this->modx->lexicon("msdashboard_label_orders") . '"
                },
                min: ' . $min . ',
                max: ' . $max . '
              },
              legend: {
                    position: "top",
                    horizontalAlign: "right",
                    offsetY: -25
                  }
              };
            
              var chart = new ApexCharts(document.querySelector("#msdashboard-orders-timeharts_bystatus"), options);
              chart.render();
            
		});</script>');

        return '<div id="msdashboard-orders-timeharts_bystatus"></div>';
    }
}

return 'msDashboardOrdersTimeChartsByStatus';