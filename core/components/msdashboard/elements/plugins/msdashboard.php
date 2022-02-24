<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'OnManagerPageInit':

        if (!$msDashboard = $modx->getService('msdashboard', 'msDashboard',
            $modx->getOption('msdashboard_core_path', null, MODX_CORE_PATH . 'components/msdashboard/') . 'model/')) {
            return;
        }


        break;

}