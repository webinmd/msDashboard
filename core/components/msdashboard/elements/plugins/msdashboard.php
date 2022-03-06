<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'OnManagerPageBeforeRender':


        if (!$msDashboard = $modx->getService('msdashboard', 'msDashboard', MODX_CORE_PATH . 'components/msdashboard/model/')) {
            return;
        }


        $modx->controller->addCss($msDashboard->config['cssUrl'].'mgr/main.css');
        $modx->controller->addJavascript($msDashboard->config['jsUrl'].'mgr/msdashboard.js');

        $modx->controller->addCss($msDashboard->config['minishopCssUrl'] . 'mgr/bootstrap.buttons.css');
        $modx->controller->addCss($msDashboard->config['minishopCssUrl'] . 'mgr/main.css');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/minishop2.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/misc/default.grid.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/misc/default.window.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/misc/strftime-min-1.3.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/misc/ms2.utils.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/misc/ms2.combo.js');

        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.form.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.grid.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.grid.logs.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.grid.products.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.panel.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.window.js');
        $modx->controller->addJavascript($msDashboard->config['minishopJsUrl'] . 'mgr/orders/orders.window.product.js');

        $modx->controller->addJavascript(MODX_MANAGER_URL . 'assets/modext/util/datetime.js');

        break;

}