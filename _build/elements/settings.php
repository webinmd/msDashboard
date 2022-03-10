<?php

return [
    'order_status' => [
        'xtype' => 'numberfield',
        'value' => 0,
        'area' => 'msdashboard_stat',
    ],
    'order_fields' => [
        'xtype' => 'textfield',
        'value' => 'id,customer,num,status,cost,weight,delivery,payment,createdon,updatedon,comment',
        'area' => 'msdashboard_orders',
    ],
];