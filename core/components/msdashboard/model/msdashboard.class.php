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

        $this->modx = &$modx;
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

        $this->modx->lexicon->load('msdashboard', 'minishop2:manager');
        $this->modx->addPackage('msdashboard', $this->config['modelPath']);

        if (!$this->modx->getService('miniShop2')) {
            return $this->modx->lexicon('msdashboard_minishop_error');
        }
    }


    /*
     *
     *
     */
    public function getSimpleStat()
    {

        // sum
        $order_status = $this->modx->getOption('msdashboard_order_status', null, 0);

        if ($order_status == 0) {
            $where_orders = [];
        } else {
            $where_orders = ['status' => $order_status];
        }

        // sum for rev
        $order_status_rev = $this->modx->getOption('msdashboard_order_status_rev', null, 0);
        $c = $this->modx->newQuery('msOrder');
        $c->select('SUM(cost) as cost');

        if ($order_status_rev > 0) {
            $c->where([
                'status' => $order_status_rev
            ]);
        }

        $c->prepare();
        $c->stmt->execute();
        if (!$rev_sum = $c->stmt->fetchColumn()) {
            $rev_sum = 0;
        }

        $statistic = [
            'total_orders' => $this->modx->getCount('msOrder', $where_orders),
            'total_customers' => $this->modx->getCount('modUser', array('active' => 1, 'primary_group' => 0)),
            'rev' => $rev_sum
        ];

        return $statistic;
    }


    /*
     *
     *
     */
    public function getOrdersByStatus()
    {
        //
        $statusList = $this->modx->getOption('msdashboard_status_list_forpie', null, 0);
        $output = [];

        $c = $this->modx->newQuery('msOrder');
        $c->leftJoin('msOrderStatus', 'Status');

        if ($statusList != 0) {
            $statusArr = explode(',', $statusList);
            $c->where(['Status.id:IN' => $statusArr, 'Status.active' => 1]);
        } else {
            $c->where(['Status.active' => 1]);
        }

        $c->select('Status.name, COUNT(*) as count');
        $c->groupby('msOrder.status');
        $c->prepare();

        $c->stmt->execute();

        if ($result = $c->stmt->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($result as $res) {
                $output['series'][] = $res['count'];
                $output['labels'][] = $res['name'];
            }
        }

        return $output;
    }


    /*
     *
     *
     */
    public function getOrdersByDeliveries()
    {

        $output = [];

        $c = $this->modx->newQuery('msOrder');
        $c->leftJoin('msDelivery', 'Delivery');

        $c->select('Delivery.name, COUNT(*) as count');
        $c->groupby('msOrder.delivery');
        $c->prepare();

        $c->stmt->execute();

        if ($result = $c->stmt->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($result as $res) {
                $output['series'][] = $res['count'];
                $output['labels'][] = $res['name'];
            }
        }

        return $output;
    }


    /*
     *
     *
     */
    public function getOrdersByPayments()
    {

        $output = [];

        $c = $this->modx->newQuery('msOrder');
        $c->leftJoin('msPayment', 'Payment');

        $c->select('Payment.name, COUNT(*) as count');
        $c->groupby('msOrder.payment');
        $c->prepare();

        $c->stmt->execute();

        if ($result = $c->stmt->fetchAll(PDO::FETCH_ASSOC)) {
            foreach ($result as $res) {
                $output['series'][] = $res['count'];
                $output['labels'][] = $res['name'];
            }
        }

        return $output;
    }


    /*
     *
     *
     */
    public function getOrdersByStatusOnTime()
    {

        // get list of statuses 
        $qs = $this->modx->newQuery('msOrderStatus');
        $qs->select('name, color, id');
        $qs->limit(100);
        $qs->prepare();
        $qs->stmt->execute();
        $st = $qs->stmt->fetchAll(PDO::FETCH_ASSOC);
        $statuses_list = [];

        foreach ($st as $v) {
            $statuses_list[$v['id']] = [
                'name' => $v['name'],
                'color' => $v['color']
            ];
        }

        ////

        $output = [];

        $q_stats_month = $this->modx->newQuery('msOrder');
        $q_stats_month->leftJoin('msOrderStatus', 'Status');
        $q_stats_month->select('Status.name as status_title, Status.color as color, status,`createdon`, month(`createdon`) AS `order_month`, count(*) AS `order_count`, SUM(cart_cost) AS order_cost');
        $q_stats_month->groupby('year(`createdon`), month(`createdon`), status');
        $q_stats_month->sortby('createdon', 'ASC');

        if ($q_stats_month->prepare() && $q_stats_month->stmt->execute()) {
            while ($row = $q_stats_month->stmt->fetch(PDO::FETCH_ASSOC)) {
                $date = date_parse($row['createdon']);

                $output[$date['year'].'-'.$date['month']][$row['status']] = [
                    'total_cost'    => $row['order_cost'],
                    'count_orders'  => $row['order_count'],
                    'status'        => $row['status'],
                    'status_title'  => $row['status_title'],
                    'color'         => $row['color']
                ];
              
                foreach ($statuses_list as $k=>$v) {
                    if(!$output[$date['year'].'-'.$date['month']][$k] ) {
                        $output[$date['year'].'-'.$date['month']][$k] = [
                            'total_cost'    => 0,
                            'count_orders'  => 0,
                            'status'        => $k,
                            'status_title'  => $v['name'],
                            'color'         => $v['color']
                        ];
                    }
                }  
            }
        }

        return $output;
    }
}
