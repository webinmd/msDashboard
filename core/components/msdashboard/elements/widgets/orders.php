<?php
require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardOrders extends modDashboardWidgetInterface
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
		    MODx.load({
		        xtype: "minishop2-grid-orders", 
		        renderTo: "msdashboard-orders-grid"
		    });
            
             setTimeout(function(){
                let dash = document.getElementById("msdashboard-orders-grid").closest(".dashboard-block");
                let title = dash.querySelector("h3.title"); 
                let btn = "<a href=\'?a=mgr/orders&namespace=minishop2\' class=\'msdashboard-all-orders x-btn x-btn-small primary-button\'>' . $this->modx->lexicon("msdashboard_allorders") . '</a>";
                
                title.insertAdjacentHTML("beforeend",btn); 

            }, 500);   
             
		});</script>');

        return '<div id="msdashboard-orders-grid"></div>';
    }
}
return msDashboardOrders;