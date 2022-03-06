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

        //$this->includeScriptAssets();

        if (!$this->modx->getService('miniShop2')) {
            return $this->modx->lexicon('msdashboard_minishop_error');
        }

    }



    public function includeScriptAssets()
    {

        $this->addCss($this->config['minishopCssUrl'] . 'mgr/main.css');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/minishop2.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/misc/default.grid.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/misc/default.window.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/misc/strftime-min-1.3.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/misc/ms2.utils.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/misc/ms2.combo.js');

        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.form.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.grid.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.grid.logs.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.grid.products.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.panel.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.window.js');
        $this->modx->controller->addJavascript($this->config['minishopJsUrl'] . 'mgr/orders/orders.window.product.js');

        $this->modx->controller->addJavascript(MODX_MANAGER_URL . 'assets/modext/util/datetime.js');



    }

}