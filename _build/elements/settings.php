<?php

return [
    'order_fields' => [
        'xtype' => 'textfield',
        'value' => 'id,customer,num,status,cost,weight,delivery,payment,createdon,updatedon,comment',
        'area' => 'msdashboard_orders',
    ],
    'enable_charts' => [
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'msdashboard_main',
    ],
    'order_status' => [
        'xtype' => 'numberfield',
        'value' => 0,
        'area' => 'msdashboard_stat',
    ],
    'order_status_rev' => [
        'xtype' => 'numberfield',
        'value' => 0,
        'area' => 'msdashboard_stat',
    ],
    'status_list_forpie' => [
        'xtype' => 'textarea',
        'value' => '1,2,3,4',
        'area' => 'msdashboard_stat',
    ],
];

