<?php

return [
    'msDashboardFullOrdersPanel' => [
        'description' => 'msdashboard_fullpanelorders_desc',
        'type' => 'file',
        'content' => '[[++core_path]]components/msdashboard/elements/widgets/fullorderspanel.php',
        'namespace' => 'msdashboard',
        'lexicon' => 'msdashboard:default',
        'size' => 'full',
    ],
    'msDashboardOrders' => [
        'description' => 'msdashboard_orders_desc',
        'type' => 'file',
        'content' => '[[++core_path]]components/msdashboard/elements/widgets/orders.php',
        'namespace' => 'msdashboard',
        'lexicon' => 'msdashboard:default',
        'size' => 'full',
    ],
    'msDashboardSimpleStat' => [
        'description' => 'msdashboard_simplestat_desc',
        'type' => 'file',
        'content' => '[[++core_path]]components/msdashboard/elements/widgets/simplestat.php',
        'namespace' => 'msdashboard',
        'lexicon' => 'msdashboard:default',
        'size' => 'full',
    ],
    'msDashboardOrdersPieChartsByStatus' => [
        'description' => 'msdashboard_piecharts_bystatus_desc',
        'type' => 'file',
        'content' => '[[++core_path]]components/msdashboard/elements/widgets/orderspiechartsbystatus.php',
        'namespace' => 'msdashboard',
        'lexicon' => 'msdashboard:default',
        'size' => 'third',
    ],
    'msDashboardOrdersTimeChartsByStatus' => [
        'description' => 'msdashboard_timecharts_bystatus_desc',
        'type' => 'file',
        'content' => '[[++core_path]]components/msdashboard/elements/widgets/orderstimechartsbystatus.php',
        'namespace' => 'msdashboard',
        'lexicon' => 'msdashboard:default',
        'size' => 'two-thirds',
    ],
];