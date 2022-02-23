<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/msDashboard/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/msdashboard')) {
            $cache->deleteTree(
                $dev . 'assets/components/msdashboard/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/msdashboard/', $dev . 'assets/components/msdashboard');
        }
        if (!is_link($dev . 'core/components/msdashboard')) {
            $cache->deleteTree(
                $dev . 'core/components/msdashboard/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/msdashboard/', $dev . 'core/components/msdashboard');
        }
    }
}

return true;