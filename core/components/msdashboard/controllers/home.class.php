<?php

/**
 * The home manager controller for msDashboard.
 *
 */
class msDashboardHomeManagerController extends modExtraManagerController
{
    /** @var msDashboard $msDashboard */
    public $msDashboard;


    /**
     *
     */
    public function initialize()
    {
        $this->msDashboard = $this->modx->getService('msDashboard', 'msDashboard', MODX_CORE_PATH . 'components/msdashboard/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['msdashboard:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('msdashboard');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->msDashboard->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->msDashboard->config['jsUrl'] . 'mgr/msdashboard.js');
        $this->addJavascript($this->msDashboard->config['jsUrl'] . 'mgr/widgets/orders.js');

        $this->addHtml('<script type="text/javascript">
        msDashboard.config = ' . json_encode($this->msDashboard->config) . ';
        msDashboard.config.connector_url = "' . $this->msDashboard->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "msdashboard-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="msdashboard-panel-home-div"></div>';

        return '';
    }
}