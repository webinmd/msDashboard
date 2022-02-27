<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var msDashboard $msDashboard */
$msDashboard = $modx->getService('msDashboard', 'msDashboard', MODX_CORE_PATH . 'components/msdashboard/model/');
$modx->lexicon->load('msdashboard:default', 'minishop2:manager');

// handle request
$corePath = $modx->getOption('msdashboard_core_path', null, $modx->getOption('core_path') . 'components/msdashboard/');
$path = $modx->getOption('processorsPath', $msDashboard->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);