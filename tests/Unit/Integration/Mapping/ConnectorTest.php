<?php

use App\Integration\Mapping\Connector;
use App\Integration\Mapping\Utils;
use App\Integration\Mapping\DataMapper;
use Adbar\Dot;

uses(Tests\TestCase::class);

describe('Connector class', function () {
    describe('buildResource method', function () {
        it('builds resource with basic mapping', function () {
            $mapping = [
                'resource' => 'products',
                'pk' => 'id',
                'generator' => 'uuid'
            ];

            $columns = [
                'id' => ['name' => 'id', 'type' => 'integer'],
                'name' => ['name' => 'name', 'type' => 'string'],
                'price' => ['name' => 'price', 'type' => 'double'],
                'pk' => 'id'
            ];

            $wheres = [
                ['column' => 'status', 'value' => 'active']
            ];

            $result = Connector::buildResource($mapping, $columns, $wheres);

            expect($result)->toBe([
                'name' => 'products',
                'pk' => 'id',
                'generator' => 'uuid',
                'wheres' => [
                    ['column' => 'status', 'value' => 'active']
                ],
                'columns' => [
                    'name' => ['name' => 'name', 'type' => 'string'],
                    'price' => ['name' => 'price', 'type' => 'double']
                ]
            ]);
        });

        it('builds resource without generator', function () {
            $mapping = [
                'resource' => 'categories',
                'pk' => 'category_id',
                'generator' => null
            ];

            $columns = [
                'category_id' => ['name' => 'category_id', 'type' => 'integer'],
                'name' => ['name' => 'name', 'type' => 'string'],
                'pk' => 'category_id'
            ];

            $result = Connector::buildResource($mapping, $columns);

            expect($result)->toBe([
                'name' => 'categories',
                'pk' => 'category_id',
                'generator' => '',
                'wheres' => [],
                'columns' => [
                    'name' => ['name' => 'name', 'type' => 'string']
                ]
            ]);
        });

        it('builds resource with empty columns', function () {
            $mapping = [
                'resource' => 'empty_resource',
                'pk' => 'id',
                'generator' => null
            ];

            $result = Connector::buildResource($mapping, ['pk' => 'id']);

            expect($result)->toBe([
                'name' => 'empty_resource',
                'pk' => 'id',
                'generator' => '',
                'wheres' => [],
                'columns' => []
            ]);
        });
    });

    describe('mapWheres method', function () {
        it('maps where conditions with basic mapping', function () {
            $mapping = [
                'wheres' => [
                    [
                        'remote' => 'status',
                        'local' => 'item_status',
                        'comparator' => '=',
                        'default' => 'inactive',
                        'type' => 'string',
                        'format' => null
                    ]
                ]
            ];

            $item = [
                'other_field' => 'value' // Item doesn't have the local key, so uses default
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([
                [
                    'column' => 'status',
                    'comparator' => '=',
                    'value' => 'inactive',
                    'type' => 'string',
                    'format' => null
                ]
            ]);
        });

        it('maps where conditions with type parsing', function () {
            $mapping = [
                'wheres' => [
                    [
                        'remote' => 'quantity',
                        'local' => 'item_quantity',
                        'comparator' => '>',
                        'default' => 0,
                        'type' => 'integer',
                        'format' => null
                    ]
                ]
            ];

            $item = [
                'other_field' => 'value' // Item doesn't have the local key, so uses default
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([
                [
                    'column' => 'quantity',
                    'comparator' => '>',
                    'value' => 0,
                    'type' => 'integer',
                    'format' => null
                ]
            ]);
        });

        it('maps where conditions with format', function () {
            $mapping = [
                'wheres' => [
                    [
                        'remote' => 'name',
                        'local' => 'item_name',
                        'comparator' => 'LIKE',
                        'default' => '',
                        'type' => 'string',
                        'format' => 'trim'
                    ]
                ]
            ];

            $item = [
                'other_field' => 'value' // Item doesn't have the local key, so uses default
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([
                [
                    'column' => 'name',
                    'comparator' => 'LIKE',
                    'value' => '',
                    'type' => 'string',
                    'format' => 'trim'
                ]
            ]);
        });

        it('uses default value when local key is empty', function () {
            $mapping = [
                'wheres' => [
                    [
                        'remote' => 'status',
                        'local' => 'item_status',
                        'comparator' => '=',
                        'default' => 'inactive',
                        'type' => 'string',
                        'format' => null
                    ]
                ]
            ];

            $item = [
                'other_field' => 'value'
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([
                [
                    'column' => 'status',
                    'comparator' => '=',
                    'value' => 'inactive',
                    'type' => 'string',
                    'format' => null
                ]
            ]);
        });

        it('skips where conditions with empty remote key', function () {
            $mapping = [
                'wheres' => [
                    [
                        'remote' => '',
                        'local' => 'item_status',
                        'comparator' => '=',
                        'default' => 'inactive',
                        'type' => 'string',
                        'format' => null
                    ],
                    [
                        'remote' => 'status',
                        'local' => 'item_status',
                        'comparator' => '=',
                        'default' => 'inactive',
                        'type' => 'string',
                        'format' => null
                    ]
                ]
            ];

            $item = [
                'other_field' => 'value' // Item doesn't have the local key, so uses default
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([
                [
                    'column' => 'status',
                    'comparator' => '=',
                    'value' => 'inactive',
                    'type' => 'string',
                    'format' => null
                ]
            ]);
        });

        it('handles multiple where conditions', function () {
            $mapping = [
                'wheres' => [
                    [
                        'remote' => 'status',
                        'local' => 'item_status',
                        'comparator' => '=',
                        'default' => 'inactive',
                        'type' => 'string',
                        'format' => null
                    ],
                    [
                        'remote' => 'category_id',
                        'local' => 'item_category',
                        'comparator' => '=',
                        'default' => 0,
                        'type' => 'integer',
                        'format' => null
                    ]
                ]
            ];

            $item = [
                'other_field' => 'value' // Item doesn't have the local keys, so uses defaults
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([
                [
                    'column' => 'status',
                    'comparator' => '=',
                    'value' => 'inactive',
                    'type' => 'string',
                    'format' => null
                ],
                [
                    'column' => 'category_id',
                    'comparator' => '=',
                    'value' => 0,
                    'type' => 'integer',
                    'format' => null
                ]
            ]);
        });

        it('handles empty where conditions', function () {
            $mapping = [
                'wheres' => []
            ];

            $item = [
                'item_status' => 'active'
            ];

            $result = Connector::mapWheres($mapping, $item);

            expect($result)->toBe([]);
        });
    });
});
