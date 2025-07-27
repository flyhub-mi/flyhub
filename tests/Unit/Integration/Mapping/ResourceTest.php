<?php

use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

uses(Tests\TestCase::class);

describe('Resource class', function () {
    describe('mapping method', function () {
        it('combines multiple mapping arrays', function () {
            $mapping1 = ['columns' => [Column::string('name', 'product_name')]];
            $mapping2 = ['relations' => [['remote' => ['key' => 'category']]]];

            $result = Resource::mapping($mapping1, $mapping2);

            expect($result)->toBe([
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ],
                'relations' => [
                    ['remote' => ['key' => 'category']]
                ]
            ]);
        });

        it('returns single mapping array as is', function () {
            $mapping = ['columns' => [Column::string('name', 'product_name')]];

            $result = Resource::mapping($mapping);

            expect($result)->toBe($mapping);
        });

        it('returns empty array when no parameters provided', function () {
            $result = Resource::mapping();

            expect($result)->toBe([]);
        });
    });

    describe('local method', function () {
        it('creates local key mapping with is_array false', function () {
            $result = Resource::local('products');

            expect($result)->toBe([
                'local' => [
                    'key' => 'products',
                    'is_array' => false
                ]
            ]);
        });

        it('creates local key mapping with is_array true', function () {
            $result = Resource::local('products', true);

            expect($result)->toBe([
                'local' => [
                    'key' => 'products',
                    'is_array' => true
                ]
            ]);
        });
    });

    describe('remote method', function () {
        it('creates remote key mapping with null key and is_array false', function () {
            $result = Resource::remote();

            expect($result)->toBe([
                'remote' => [
                    'key' => null,
                    'is_array' => false
                ]
            ]);
        });

        it('creates remote key mapping with specific key', function () {
            $result = Resource::remote('api_products');

            expect($result)->toBe([
                'remote' => [
                    'key' => 'api_products',
                    'is_array' => false
                ]
            ]);
        });

        it('creates remote key mapping with is_array true', function () {
            $result = Resource::remote('api_products', true);

            expect($result)->toBe([
                'remote' => [
                    'key' => 'api_products',
                    'is_array' => true
                ]
            ]);
        });
    });

    describe('columns method', function () {
        it('creates columns mapping with single column', function () {
            $column = Column::string('name', 'product_name');

            $result = Resource::columns($column);

            expect($result)->toBe([
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ]);
        });

        it('creates columns mapping with multiple columns', function () {
            $column1 = Column::string('name', 'product_name');
            $column2 = Column::integer('price', 'product_price');

            $result = Resource::columns($column1, $column2);

            expect($result)->toBe([
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ],
                    [
                        'remote' => 'price',
                        'local' => 'product_price',
                        'default' => 0,
                        'type' => 'integer'
                    ]
                ]
            ]);
        });

        it('creates columns mapping with array of columns', function () {
            $columns = [
                Column::string('name', 'product_name'),
                Column::integer('price', 'product_price')
            ];

            $result = Resource::columns($columns);

            expect($result)->toBe([
                'columns' => [
                    [
                        [
                            'remote' => 'name',
                            'local' => 'product_name',
                            'default' => '',
                            'type' => 'string'
                        ],
                        [
                            'remote' => 'price',
                            'local' => 'product_price',
                            'default' => 0,
                            'type' => 'integer'
                        ]
                    ]
                ]
            ]);
        });
    });

    describe('line method', function () {
        it('creates line mapping with default parameters', function () {
            $result = Resource::line();

            expect($result)->toBe([
                'line' => [
                    'local' => '{index}',
                    'remote' => '{index}',
                    'type' => 'string'
                ]
            ]);
        });

        it('creates line mapping with custom parameters', function () {
            $result = Resource::line('item_{index}', 'product_{index}', 'integer');

            expect($result)->toBe([
                'line' => [
                    'local' => 'item_{index}',
                    'remote' => 'product_{index}',
                    'type' => 'string'
                ]
            ]);
        });
    });

    describe('relations method', function () {
        it('creates relations mapping with single relation', function () {
            $relation = Resource::mapping(
                Resource::local('category'),
                Resource::columns(Column::string('name', 'category_name'))
            );

            $result = Resource::relations($relation);

            expect($result)->toBe([
                'relations' => [
                    [
                        'local' => [
                            'key' => 'category',
                            'is_array' => false
                        ],
                        'columns' => [
                            [
                                'remote' => 'name',
                                'local' => 'category_name',
                                'default' => '',
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]);
        });

        it('creates relations mapping with multiple relations', function () {
            $relation1 = Resource::mapping(
                Resource::local('category'),
                Resource::columns(Column::string('name', 'category_name'))
            );
            $relation2 = Resource::mapping(
                Resource::local('brand'),
                Resource::columns(Column::string('name', 'brand_name'))
            );

            $result = Resource::relations($relation1, $relation2);

            expect($result)->toBe([
                'relations' => [
                    [
                        'local' => [
                            'key' => 'category',
                            'is_array' => false
                        ],
                        'columns' => [
                            [
                                'remote' => 'name',
                                'local' => 'category_name',
                                'default' => '',
                                'type' => 'string'
                            ]
                        ]
                    ],
                    [
                        'local' => [
                            'key' => 'brand',
                            'is_array' => false
                        ],
                        'columns' => [
                            [
                                'remote' => 'name',
                                'local' => 'brand_name',
                                'default' => '',
                                'type' => 'string'
                            ]
                        ]
                    ]
                ]
            ]);
        });

        it('creates relations mapping with array of relations', function () {
            $relations = [
                Resource::mapping(
                    Resource::local('category'),
                    Resource::columns(Column::string('name', 'category_name'))
                )
            ];

            $result = Resource::relations($relations);

            expect($result)->toBe([
                'relations' => [
                    [
                        [
                            'local' => [
                                'key' => 'category',
                                'is_array' => false
                            ],
                            'columns' => [
                                [
                                    'remote' => 'name',
                                    'local' => 'category_name',
                                    'default' => '',
                                    'type' => 'string'
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
        });
    });

    describe('configs method', function () {
        it('creates configs mapping with single config', function () {
            $config = Column::string('api_key', 'integration_key');

            $result = Resource::configs($config);

            expect($result)->toBe([
                'configs' => [
                    [
                        'remote' => 'api_key',
                        'local' => 'integration_key',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ]);
        });

        it('creates configs mapping with multiple configs', function () {
            $config1 = Column::string('api_key', 'integration_key');
            $config2 = Column::string('api_url', 'integration_url');

            $result = Resource::configs($config1, $config2);

            expect($result)->toBe([
                'configs' => [
                    [
                        'remote' => 'api_key',
                        'local' => 'integration_key',
                        'default' => '',
                        'type' => 'string'
                    ],
                    [
                        'remote' => 'api_url',
                        'local' => 'integration_url',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ]);
        });

        it('creates configs mapping with array of configs', function () {
            $configs = [
                Column::string('api_key', 'integration_key'),
                Column::string('api_url', 'integration_url')
            ];

            $result = Resource::configs($configs);

            expect($result)->toBe([
                'configs' => [
                    [
                        [
                            'remote' => 'api_key',
                            'local' => 'integration_key',
                            'default' => '',
                            'type' => 'string'
                        ],
                        [
                            'remote' => 'api_url',
                            'local' => 'integration_url',
                            'default' => '',
                            'type' => 'string'
                        ]
                    ]
                ]
            ]);
        });
    });

    describe('metadata method', function () {
        it('creates metadata mapping', function () {
            $metadata = [
                'version' => '1.0',
                'description' => 'Product mapping'
            ];

            $result = Resource::metadata($metadata);

            expect($result)->toBe([
                'metadata' => [
                    'version' => '1.0',
                    'description' => 'Product mapping'
                ]
            ]);
        });

        it('creates metadata mapping with empty array', function () {
            $result = Resource::metadata([]);

            expect($result)->toBe([
                'metadata' => []
            ]);
        });
    });

    describe('integration tests', function () {
        it('creates complete resource mapping', function () {
            $mapping = Resource::mapping(
                Resource::local('products'),
                Resource::remote('api_products'),
                Resource::columns(
                    Column::string('name', 'product_name'),
                    Column::integer('price', 'product_price'),
                    Column::boolean('active', 'is_active')
                ),
                Resource::relations(
                    Resource::mapping(
                        Resource::local('category'),
                        Resource::columns(Column::string('name', 'category_name'))
                    )
                ),
                Resource::configs(
                    Column::string('api_key', 'integration_key')
                ),
                Resource::metadata([
                    'version' => '1.0',
                    'description' => 'Product mapping'
                ])
            );

            expect($mapping)->toBe([
                'local' => [
                    'key' => 'products',
                    'is_array' => false
                ],
                'remote' => [
                    'key' => 'api_products',
                    'is_array' => false
                ],
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ],
                    [
                        'remote' => 'price',
                        'local' => 'product_price',
                        'default' => 0,
                        'type' => 'integer'
                    ],
                    [
                        'remote' => 'active',
                        'local' => 'is_active',
                        'default' => true,
                        'type' => 'boolean'
                    ]
                ],
                'relations' => [
                    [
                        'local' => [
                            'key' => 'category',
                            'is_array' => false
                        ],
                        'columns' => [
                            [
                                'remote' => 'name',
                                'local' => 'category_name',
                                'default' => '',
                                'type' => 'string'
                            ]
                        ]
                    ]
                ],
                'configs' => [
                    [
                        'remote' => 'api_key',
                        'local' => 'integration_key',
                        'default' => '',
                        'type' => 'string'
                    ]
                ],
                'metadata' => [
                    'version' => '1.0',
                    'description' => 'Product mapping'
                ]
            ]);
        });
    });
});
