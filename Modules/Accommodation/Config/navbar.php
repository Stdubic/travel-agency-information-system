<?php

return [
    [
        'type' => 'divider',
        'title' => 'navbar.accommodation',
    ],
    [
        'title' => 'accommodation::accommodation.name',
		'icon_class' => 'flaticon-home',
        'permission' => 'view-accommodation-object',
        'id' => 'accObjectNav',
		'items' => [
            [
                'title' => 'accommodation::accommodation.object.list',
                'route' => 'accommodation.object.list',
                'permission' => 'list-accommodation-object',
            ],
            [
                'title' => 'accommodation::accommodation.object.create',
                'route' => 'accommodation.object.create',
                'permission' => 'create-accommodation-object',
                'create' => true
            ],
            [
                'title' => 'accommodation::accommodation.type.list',
                'route' => 'accommodation.type.list',
                'permission' => 'list-accommodation-object-type',
            ],
			[
				'title' => 'accommodation::accommodation.type.create',
				'route' => 'accommodation.type.create',
                'permission' => 'create-accommodation-object-type',
			],
            [
                'title' => 'accommodation::accommodation.category.list',
                'route' => 'accommodation.category.list',
                'permission' => 'list-accommodation-object-category',
            ],
            [
                'title' => 'accommodation::accommodation.category.create',
                'route' => 'accommodation.category.create',
                'permission' => 'create-accommodation-object-category',
            ],
		]
	],
    [
        'title' => 'accommodation::accommodation.unit.name',
        'icon_class' => 'flaticon-home-2',
        'permission' => 'view-accommodation-unit',
        'id' => 'accUnitNav',
        'items' => [
            [
                'title' => 'accommodation::accommodation.unit.list',
                'route' => 'accommodation.unit.list',
                'permission' => 'list-accommodation-unit',
            ],
            [
                'title' => 'accommodation::accommodation.unit.create',
                'route' => 'accommodation.unit.create',
                'permission' => 'create-accommodation-unit',
                'create' => true
            ],
            [
                'title' => 'accommodation::accommodation.unit.type.list',
                'route' => 'accommodation.unit.type.list',
                'permission' => 'list-accommodation-unit-type',
            ],
            [
                'title' => 'accommodation::accommodation.unit.type.create',
                'route' => 'accommodation.unit.type.create',
                'permission' => 'create-accommodation-unit-type',
            ]
        ]
    ],
    [
        'title' => 'accommodation::accommodation.amenity.name',
        'icon_class' => 'fa fa-list',
        'permission' => 'view-amenity',
        'id' => 'amenityNav',
        'items' => [
            [
                'title' => 'accommodation::accommodation.amenity.list',
                'route' => 'accommodation.amenity.list',
                'permission' => 'list-amenity',
            ],
            [
                'title' => 'accommodation::accommodation.amenity.create',
                'route' => 'accommodation.amenity.create',
                'permission' => 'create-amenity',
                'create' => true
            ],
            [
                'title' => 'accommodation::accommodation.amenity.set.list',
                'route' => 'accommodation.amenity.set.list',
                'permission' => 'list-amenity-set',
            ],
            [
                'title' => 'accommodation::accommodation.amenity.set.create',
                'route' => 'accommodation.amenity.set.create',
                'permission' => 'create-amenity-set',
            ]
        ]
    ],
    [
        'title' => 'accommodation::accommodation.location',
        'icon_class' => 'flaticon-placeholder-2',
        'permission' => 'view-location',
        'id' => 'locationNav',
        'items' => [
            [
                'title' => 'accommodation::accommodation.location.region.list',
                'route' => 'accommodation.location.region.list',
                'permission' => 'list-region',
            ],
            [
                'title' => 'accommodation::accommodation.location.region.create',
                'route' => 'accommodation.location.region.create',
                'permission' => 'create-region',
                'create' => true
            ],
            [
                'title' => 'accommodation::accommodation.location.city.list',
                'route' => 'accommodation.location.city.list',
                'permission' => 'list-city',
            ],
            [
                'title' => 'accommodation::accommodation.location.city.create',
                'route' => 'accommodation.location.city.create',
                'permission' => 'create-city',
            ]
        ]
    ],
    [
        'title' => 'accommodation::accommodation.rate.plan.name',
        'icon_class' => 'flaticon-business',
        'permission' => 'view-rate-plan',
        'id' => 'rateNav',
        'items' => [
            [
                'title' => 'accommodation::accommodation.rate.plan.list',
                'route' => 'accommodation.rate.plan.list',
                'permission' => 'list-rate-plan',
            ],
            [
                'title' => 'accommodation::accommodation.rate.plan.create',
                'route' => 'accommodation.rate.plan.create',
                'permission' => 'create-rate-plan',
            ]
        ]
    ],
    [
        'title' => 'accommodation::accommodation.reservations.name',
        'icon_class' => 'flaticon-list-3',
        'permission' => 'view-reservation',
        'id' => 'reservationNav',
        'items' => [
//            [
//                'title' => 'accommodation::accommodation.rate.plan.list',
//                'route' => 'accommodation.rate.plan.list'
//            ],
            [
                'title' => 'accommodation::accommodation.reservations.create',
                'route' => 'accommodation.reservations.create',
                'permission' => 'create-reservation',
                'create' => true
            ]
        ]
    ],
    [
    'title' => 'accommodation::accommodation.calendar.name',
    'icon_class' => 'flaticon-calendar',
    'permission' => 'view-calendar',
    'id' => 'calendarNav',
    'items' => [
//            [
//                'title' => 'accommodation::accommodation.rate.plan.list',
//                'route' => 'accommodation.rate.plan.list'
//            ],
        [
            'title' => '',
            'route' => 'dashboard',
            'permission' => '',
        ]
    ]
]
];
