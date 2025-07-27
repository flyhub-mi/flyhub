<?php

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\DataMapper;
use App\Models\Tenant\Channel;

uses(Tests\TestCase::class);

// Create a concrete test class to test the abstract ResourceMapper
class TestResourceMapper extends ResourceMapper
{
    public function __construct($channel = null, $configs = null, $mapping = [])
    {
        parent::__construct($channel, $configs, $mapping);
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function getConfigs()
    {
        return $this->configs;
    }

    public function getMapping()
    {
        return $this->mapping;
    }

    public function testMapData($data, $to)
    {
        return $this->mapData($data, $to);
    }
}

describe('ResourceMapper class', function () {
    describe('constructor', function () {
        it('initializes with all parameters', function () {
            $channel = new stdClass(); // Mock channel
            $configs = ['api_key' => 'test_key'];
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper($channel, $configs, $mapping);

            expect($mapper->getChannel())->toBe($channel);
            expect($mapper->getConfigs())->toBe($configs);
            expect($mapper->getMapping())->toBe($mapping);
        });

        it('initializes with null parameters', function () {
            $mapper = new TestResourceMapper();

            expect($mapper->getChannel())->toBeNull();
            expect($mapper->getConfigs())->toBeNull();
            expect($mapper->getMapping())->toBe([]);
        });

        it('initializes with only channel', function () {
            $channel = new stdClass();

            $mapper = new TestResourceMapper($channel);

            expect($mapper->getChannel())->toBe($channel);
            expect($mapper->getConfigs())->toBeNull();
            expect($mapper->getMapping())->toBe([]);
        });

        it('initializes with channel and configs', function () {
            $channel = new stdClass();
            $configs = ['api_url' => 'https://api.example.com'];

            $mapper = new TestResourceMapper($channel, $configs);

            expect($mapper->getChannel())->toBe($channel);
            expect($mapper->getConfigs())->toBe($configs);
            expect($mapper->getMapping())->toBe([]);
        });
    });

    describe('toLocal method', function () {
        it('maps remote data to local format', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => '',
                        'type' => 'string'
                    ],
                    [
                        'remote' => 'product_price',
                        'local' => 'price',
                        'default' => 0,
                        'type' => 'double'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $remoteData = [
                'product_name' => 'Test Product',
                'product_price' => '29.99'
            ];

            $result = $mapper->toLocal($remoteData);

            expect($result)->toBe([
                'name' => 'Test Product',
                'price' => 29.99
            ]);
        });

        it('handles empty remote data', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => 'Default Name',
                        'type' => 'string'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $result = $mapper->toLocal([]);

            expect($result)->toBe([
                'name' => 'Default Name'
            ]);
        });

        it('handles complex mapping with relations', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ],
                'relations' => [
                    [
                        'remote' => ['key' => 'category'],
                        'local' => ['key' => 'product_category'],
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
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $remoteData = [
                'name' => 'Test Product',
                'category' => [
                    'name' => 'Electronics'
                ]
            ];

            $result = $mapper->toLocal($remoteData);

            expect($result)->toBe([
                'product_name' => 'Test Product',
                'product_category' => [
                    'category_name' => 'Electronics'
                ]
            ]);
        });
    });

    describe('toRemote method', function () {
        it('maps local data to remote format', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => '',
                        'type' => 'string'
                    ],
                    [
                        'remote' => 'product_price',
                        'local' => 'price',
                        'default' => 0,
                        'type' => 'double'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $localData = [
                'name' => 'Local Product',
                'price' => 19.99
            ];

            $result = $mapper->toRemote($localData);

            expect($result)->toBe([
                'product_name' => 'Local Product',
                'product_price' => 19.99
            ]);
        });

        it('handles empty local data', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => 'Default Name',
                        'type' => 'string'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $result = $mapper->toRemote([]);

            expect($result)->toBe([
                'product_name' => 'Default Name'
            ]);
        });

        it('handles complex mapping with relations', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'name',
                        'local' => 'product_name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ],
                'relations' => [
                    [
                        'remote' => ['key' => 'category'],
                        'local' => ['key' => 'product_category'],
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
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $localData = [
                'product_name' => 'Local Product',
                'product_category' => [
                    'category_name' => 'Electronics'
                ]
            ];

            $result = $mapper->toRemote($localData);

            expect($result)->toBe([
                'name' => 'Local Product',
                'category' => [
                    'name' => 'Electronics'
                ]
            ]);
        });
    });

    describe('mapData method', function () {
        it('maps data to local format', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $data = [
                'product_name' => 'Test Product'
            ];

            $result = $mapper->testMapData($data, 'local');

            expect($result)->toBe([
                'name' => 'Test Product'
            ]);
        });

        it('maps data to remote format', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $data = [
                'name' => 'Local Product'
            ];

            $result = $mapper->testMapData($data, 'remote');

            expect($result)->toBe([
                'product_name' => 'Local Product'
            ]);
        });

        it('handles invalid direction parameter', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => '',
                        'type' => 'string'
                    ]
                ]
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $data = [
                'product_name' => 'Test Product'
            ];

            $result = $mapper->testMapData($data, 'invalid');

            expect($result)->toBe([]); // Invalid direction returns empty array
        });
    });

    describe('integration tests', function () {
        it('handles complete mapping workflow', function () {
            $mapping = [
                'columns' => [
                    [
                        'remote' => 'product_name',
                        'local' => 'name',
                        'default' => '',
                        'type' => 'string'
                    ],
                    [
                        'remote' => 'product_price',
                        'local' => 'price',
                        'default' => 0,
                        'type' => 'double'
                    ],
                    [
                        'remote' => 'product_active',
                        'local' => 'is_active',
                        'default' => true,
                        'type' => 'boolean'
                    ]
                ],
                'relations' => [
                    [
                        'remote' => ['key' => 'category'],
                        'local' => ['key' => 'product_category'],
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
            ];

            $mapper = new TestResourceMapper(null, null, $mapping);

            $remoteData = [
                'product_name' => 'Test Product',
                'product_price' => '29.99',
                'product_active' => '1',
                'category' => [
                    'name' => 'Electronics'
                ]
            ];

            $localResult = $mapper->toLocal($remoteData);

            expect($localResult)->toBe([
                'name' => 'Test Product',
                'price' => 29.99,
                'is_active' => true,
                'product_category' => [
                    'category_name' => 'Electronics'
                ]
            ]);

            $remoteResult = $mapper->toRemote($localResult);

            expect($remoteResult)->toBe([
                'product_name' => 'Test Product',
                'product_price' => 29.99,
                'product_active' => true,
                'category' => [
                    'name' => 'Electronics'
                ]
            ]);
        });
    });
});
