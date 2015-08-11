<?php

return [
    'admin/menu' => [
        ['name' => 'Ads', 'route' => 'admin/ad/all'],
        ['name' => 'Pages', 'route' => 'admin/page/all'],
        ['name' => 'Posts', 'route' => 'admin/post/all'],
        ['name' => 'System', 'route' => 'admin/system/all',
            'children' => [
                ['name' => 'Settings', 'route' => 'admin/system/settings/'],
                ['name' => 'Database', 'route' => 'admin/system/database/'],
                ['name' => 'Tennis', 'route' => 'admin/system/tennis/']
            ]
        ]
    ]
];
