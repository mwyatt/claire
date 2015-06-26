<?php

return [
    'admin/menu' => [
        ['name' => 'Pages', 'url' => 'page/'],
        ['name' => 'Press', 'url' => 'press/'],
        ['name' => 'Users', 'url' => 'user/'],
        ['name' => 'Years', 'url' => 'tennis/year/'],
        ['name' => 'Divisions', 'url' => 'tennis/division/'],
        ['name' => 'Fixtures', 'url' => 'tennis/fixture/'],
        ['name' => 'Teams', 'url' => 'tennis/team/'],
        ['name' => 'Players', 'url' => 'tennis/player/'],
        ['name' => 'Venues', 'url' => 'tennis/venue/'],
        ['name' => 'System', 'url' => 'system/',
            'children' => [
                ['name' => 'Settings', 'url' => 'system/settings/'],
                ['name' => 'Database', 'url' => 'system/database/'],
                ['name' => 'Tennis', 'url' => 'system/tennis/']
            ]
        ]
    ]
];
