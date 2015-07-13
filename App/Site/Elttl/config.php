<?php

return [
    'admin/menu' => [
        ['name' => 'Ads', 'route' => 'admin/ad/all'],
        ['name' => 'Pages', 'route' => 'admin/page/all'],
        ['name' => 'Press', 'route' => 'admin/press/all'],
        ['name' => 'Users', 'route' => 'admin/user/all'],
        ['name' => 'Years', 'route' => 'admin/tennis/year/all'],
        ['name' => 'Divisions', 'route' => 'admin/tennis/division/all'],
        ['name' => 'Fixtures', 'route' => 'admin/tennis/fixture/all'],
        ['name' => 'Teams', 'route' => 'admin/tennis/team/all'],
        ['name' => 'Players', 'route' => 'admin/tennis/player/all'],
        ['name' => 'Venues', 'route' => 'admin/tennis/venue/all'],
        ['name' => 'System', 'route' => 'admin/system/all',
            'children' => [
                ['name' => 'Settings', 'route' => 'admin/system/settings/'],
                ['name' => 'Database', 'route' => 'admin/system/database/'],
                ['name' => 'Tennis', 'route' => 'admin/system/tennis/']
            ]
        ]
    ]
];
