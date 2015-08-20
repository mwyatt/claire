<?php

return [
    'admin/menu' => [
        ['name' => 'Ads', 'route' => 'admin/ad/all'],
        ['name' => 'Pages', 'route' => 'admin/page/all'],
        ['name' => 'Users', 'route' => 'admin/user/all'],
        ['name' => 'System', 'route' => 'admin/system/all',
            'children' => [
                ['name' => 'Settings', 'route' => 'admin/system/settings/']
            ]
        ]
    ]
];
