<?php

require_once MODX_CORE_PATH . 'components/msdashboard/model/msdashboard.class.php';

class msDashboardSimpleStat extends modDashboardWidgetInterface
{
    public function render() {
        $dashboard = new msDashboard($this->modx);
        $stat = $dashboard->getSimpleStat();

        $html = '<div class="msdashboard-simple-stat" id="msdashboard-simple-stat">
                    <div class="msd-stat-block msd-stat-block-totalorders">
                        <div class="msd-stat-block-icon"><i class="icon icon-shopping-cart"></i></div>
                        <div class="msd-stat-block-data">
                            <div class="msd-stat-block-label">'.$this->modx->lexicon("msdashboard_simplestat_totalorders").'</div>
                            <div class="msd-stat-block-num">'.$stat["total_orders"].'</div>
                        </div>
                    </div>
                    <div class="msd-stat-block msd-stat-block-totalcustomers">
                        <div class="msd-stat-block-icon"><i class="icon icon-users"></i></div>
                        <div class="msd-stat-block-data">
                            <div class="msd-stat-block-label">'.$this->modx->lexicon("msdashboard_simplestat_totalcustomers").'</div>
                            <div class="msd-stat-block-num">'.$stat["total_customers"].'</div>
                        </div>
                    </div>
                    <div class="msd-stat-block msd-stat-block-rev">
                        <div class="msd-stat-block-icon"><i class="icon icon-bar-chart"></i></div>
                        <div class="msd-stat-block-data">
                            <div class="msd-stat-block-label">'.$this->modx->lexicon("msdashboard_simplestat_rev").'</div>
                            <div class="msd-stat-block-num">'.$stat["rev"].'</div>
                        </div>
                    </div>

                </div>';

        $this->controller->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            setTimeout(function(){
                if( dashboardStat = document.getElementById("msdashboard-simple-stat")){ 
                    dashboardStat.closest(".dashboard-block").classList.add("msdashboard-simple-widget");
                }   
            }, 300);     
        });</script>');

        return $html;

    }
}
return msDashboardSimpleStat;