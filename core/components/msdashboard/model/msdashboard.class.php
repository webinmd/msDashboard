<?php

class msDashboard
{
    /** @var modX $modx */
    public $modx;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {

        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/msdashboard/';
        $assetsUrl = MODX_ASSETS_URL . 'components/msdashboard/';

        $order_fields = array_map('trim', explode(',', $this->modx->getOption(
            'msdashboard_order_fields',
            null,
            'id,customer,num,status,cost,weight,delivery,payment,createdon,updatedon,comment',
            true
        )));
        $order_fields = array_values(array_unique(array_merge($order_fields, array(
            'id', 'user_id', 'num', 'type', 'actions', 'color'
        ))));

        $order_address_fields = array_map('trim', explode(',', $this->modx->getOption(
            'ms2_order_address_fields',
            null,
            'receiver,phone',
            true
        )));

        $order_product_fields =  array_map('trim', explode(',', $this->modx->getOption(
            'ms2_order_product_fields',
            null,
            'receiver,phone',
            true
        )));

        $this->config = array_merge([
            'corePath'              => $corePath,
            'modelPath'             => $corePath . 'model/',
            'processorsPath'        => $corePath . 'processors/',
            'connectorUrl'          => $assetsUrl . 'connector.php',
            'assetsUrl'             => $assetsUrl,
            'cssUrl'                => $assetsUrl . 'css/',
            'jsUrl'                 => $assetsUrl . 'js/',
            'minishopConnectorUrl'  => MODX_ASSETS_URL . 'components/minishop2/connector.php',
            'minishopJsUrl'         => MODX_ASSETS_URL . 'components/minishop2/js/',
            'minishopCssUrl'        => MODX_ASSETS_URL . 'components/minishop2/css/',
            'order_grid_fields'     => $order_fields,
            'order_address_fields'  => $order_address_fields,
            'order_product_fields'  => $order_product_fields,
        ], $config);

        $this->modx->lexicon->load('msdashboard','minishop2:manager');
        $this->modx->addPackage('msdashboard', $this->config['modelPath']);

        if (!$this->modx->getService('miniShop2')) {
            return $this->modx->lexicon('msdashboard_minishop_error');
        }

    }



    public function getSimpleStat() {

        // sum
        $order_status = $this->modx->getOption('msdashboard_order_status', null, 0);

        if($order_status == 0) {
            $where_orders = [];
        } else {
            $where_orders = ['status' => $order_status];
        }

        // sum for rev
        $order_status_rev = $this->modx->getOption('msdashboard_order_status_rev', null, 0);
        $c = $this->modx->newQuery('msOrder');
        $c->select('SUM(cost) as cost'); //amount is my column in the db with the amounts i want to SUM up

        if($order_status_rev > 0) {
            $c->where(array(
                'status' => $order_status_rev
            ));
        }

        $c->prepare();
        $c->stmt->execute();
        $rev_sum = $c->stmt->fetchColumn();

        $statistic = [
            'total_orders' => $this->modx->getCount('msOrder',$where_orders),
            'total_customers' => $this->modx->getCount('modUser',array('active' => 1, 'primary_group' => 0)),
            'rev' => $rev_sum
        ];

        return $statistic;
    }

}