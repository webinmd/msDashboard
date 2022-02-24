<?php
$corePath = $modx->getOption('msdashboard_core_path',null,$modx->getOption('core_path'). 'components/msdashboard/');
require_once $corePath . '/model/msdashboard/msdashboard.class.php';

class msDashboardOrders extends modDashboardWidgetInterface
{

}
return msDashboardOrders;