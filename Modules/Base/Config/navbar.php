<?php

return [
    [
        'type' => 'divider',
        'title' => 'navbar.settings',
    ],
    [
        'title' => 'base::base.users.name',
		'icon_class' => 'flaticon-users',
        'permission' => 'view-user',
        'id' => 'usersNav',
		'items' => [
			[
				'title' => 'base::base.users.list',
				'route' => 'users.list',
                'permission' => 'list-user',
			],
            [
                'title' => 'base::base.users.create',
                'route' => 'users.create',
                'permission' => 'create-user',
                'create' => true
            ]
		]
	],
    [
        'title' => 'base::base.roles.name',
        'icon_class' => 'flaticon-interface-7',
        'permission' => 'view-role',
        'id' => 'rolesNav',
        'items' => [
            [
                'title' => 'base::base.roles.list',
                'route' => 'roles.list',
                'permission' => 'list-role',
            ],
            [
                'title' => 'base::base.roles.create',
                'route' => 'roles.create',
                'permission' => 'create-role',
                'create' => true
            ],
            [
                'title' => 'base::base.roles.group.list',
                'route' => 'roles.group.list',
                'permission' => 'list-role-group',
            ],
            [
                'title' => 'base::base.roles.group.create',
                'route' => 'roles.group.create',
                'permission' => 'create-role-group',
                'create' => true
            ],
            [
                'title' => 'base::base.roles.assign',
                'route' => 'roles.user.assign',
                'permission' => 'assign-role',
            ],
            [
                'title' => 'base::base.roles.hierarchy',
                'route' => 'roles.hierarchy',
                'permission' => 'view-hierarchy-role',
            ]
        ]
    ],
    [
        'title' => 'base::base.languages.name',
        'icon_class' => 'flaticon-chat-2',
        'permission' => 'view-languages',
        'id' => 'langNav',
        'items' => [
            [
                'title' => 'base::base.settings.language.list',
                'route' => 'language.list',
                'permission' => 'list-language',
            ],
            [
                'title' => 'base::base.settings.language.create',
                'route' => 'language.create',
                'permission' => 'create-language',
                'create' => true
            ],
            [
                'title' => 'base::base.settings.language.manage',
                'route' => 'language.manage.get',
                'permission' => 'manage-language',
            ]
        ]
    ],
    [
        'title' => 'base::base.settings.name',
        'icon_class' => 'fa fa-wrench',
        'permission' => 'view-settings',
        'id' => 'settingsNav',
        'items' => [
            [
                'title' => '',
                'route' => 'dashboard',
                'permission' => '',
            ]
        ]
    ]
];
