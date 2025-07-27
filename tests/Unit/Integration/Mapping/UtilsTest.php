<?php

use App\Integration\Mapping\Utils;
use Illuminate\Support\Str;

uses(Tests\TestCase::class);

describe('Utils class', function () {
    describe('slug method', function () {
        it('creates slug with default separator', function () {
            $result = Utils::slug('Test Product Name');

            expect($result)->toBe('test-product-name');
        });

        it('creates slug with custom separator', function () {
            $result = Utils::slug('Test Product Name', '_');

            expect($result)->toBe('test_product_name');
        });

        it('handles special characters', function () {
            $result = Utils::slug('Product & Name (Special)');

            expect($result)->toBe('product-name-special');
        });

        it('handles empty string', function () {
            $result = Utils::slug('');

            expect($result)->toBe('');
        });

        it('handles numbers and spaces', function () {
            $result = Utils::slug('Product 123 Name');

            expect($result)->toBe('product-123-name');
        });
    });

    describe('buildSku method', function () {
        it('builds SKU from string', function () {
            $result = Utils::buildSku('Product Name');

            expect($result)->toBe('PRODUCT-NAME');
        });

        it('builds SKU from array', function () {
            $result = Utils::buildSku(['Brand', 'Model', 'Color']);

            expect($result)->toBe('BRAND-MODEL-COLOR');
        });

        it('handles underscores in string', function () {
            $result = Utils::buildSku('Product_Name_With_Underscores');

            expect($result)->toBe('PRODUCT-NAME-WITH-UNDERSCORES');
        });

        it('handles mixed case', function () {
            $result = Utils::buildSku('ProductName');

            expect($result)->toBe('PRODUCTNAME');
        });

        it('handles special characters', function () {
            $result = Utils::buildSku('Product & Name (Special)');

            expect($result)->toBe('PRODUCT-NAME-SPECIAL');
        });

        it('handles empty array', function () {
            $result = Utils::buildSku([]);

            expect($result)->toBe('');
        });

        it('handles array with empty values', function () {
            $result = Utils::buildSku(['Brand', '', 'Color']);

            expect($result)->toBe('BRAND-COLOR');
        });
    });

    describe('removeColumn method', function () {
        it('removes column by name', function () {
            $items = [
                ['name' => 'id', 'type' => 'integer'],
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'price', 'type' => 'double']
            ];

            $result = Utils::removeColumn($items, 'name');

            expect($result)->toBe([
                0 => ['name' => 'id', 'type' => 'integer'],
                2 => ['name' => 'price', 'type' => 'double']
            ]);
        });

        it('removes column by custom key', function () {
            $items = [
                ['id' => 1, 'type' => 'integer'],
                ['id' => 2, 'type' => 'string'],
                ['id' => 3, 'type' => 'double']
            ];

            $result = Utils::removeColumn($items, 2, 'id');

            expect($result)->toBe([
                0 => ['id' => 1, 'type' => 'integer'],
                2 => ['id' => 3, 'type' => 'double']
            ]);
        });

        it('returns empty array when all items are removed', function () {
            $items = [
                ['name' => 'test', 'type' => 'string']
            ];

            $result = Utils::removeColumn($items, 'test');

            expect($result)->toBe([]);
        });

        it('returns original array when value not found', function () {
            $items = [
                ['name' => 'id', 'type' => 'integer'],
                ['name' => 'name', 'type' => 'string']
            ];

            $result = Utils::removeColumn($items, 'nonexistent');

            expect($result)->toBe($items);
        });
    });

    describe('arrayToXml method', function () {
        it('converts simple array to XML', function () {
            $array = [
                'name' => 'Product',
                'price' => '29.99'
            ];

            $result = Utils::arrayToXml($array);

            expect($result)->toContain('<name>Product</name>');
            expect($result)->toContain('<price>29.99</price>');
        });

        it('converts array with flat structure', function () {
            $array = [
                'name' => 'Test Product',
                'price' => '29.99',
                'category' => 'Electronics'
            ];

            $result = Utils::arrayToXml($array);

            expect($result)->toContain('<name>Test Product</name>');
            expect($result)->toContain('<price>29.99</price>');
            expect($result)->toContain('<category>Electronics</category>');
        });

        it('converts array with mixed data types', function () {
            $array = [
                'string' => 'text',
                'number' => 123,
                'boolean' => true
            ];

            $result = Utils::arrayToXml($array);

            expect($result)->toContain('<string>text</string>');
            expect($result)->toContain('<number>123</number>');
            expect($result)->toContain('<boolean>1</boolean>');
        });

        it('handles empty array', function () {
            $array = [];

            $result = Utils::arrayToXml($array);

            expect($result)->toContain('<root/>');
        });
    });

    describe('arrayToTree method', function () {
        it('converts flat structure to tree', function () {
            $flatStructure = [
                ['id' => 1, 'parent_id' => 0, 'name' => 'Root'],
                ['id' => 2, 'parent_id' => 1, 'name' => 'Child 1'],
                ['id' => 3, 'parent_id' => 1, 'name' => 'Child 2'],
                ['id' => 4, 'parent_id' => 2, 'name' => 'Grandchild']
            ];

            $result = Utils::arrayToTree($flatStructure, 'parent_id', 'id');

            expect($result)->toBe([
                [
                    'id' => 1,
                    'parent_id' => 0,
                    'name' => 'Root',
                    'children' => [
                        [
                            'id' => 2,
                            'parent_id' => 1,
                            'name' => 'Child 1',
                            'children' => [
                                [
                                    'id' => 4,
                                    'parent_id' => 2,
                                    'name' => 'Grandchild'
                                ]
                            ]
                        ],
                        [
                            'id' => 3,
                            'parent_id' => 1,
                            'name' => 'Child 2'
                        ]
                    ]
                ]
            ]);
        });
    });

    describe('treeToArray method', function () {
        it('converts tree structure to flat array', function () {
            $treeStructure = [
                'id' => 1,
                'name' => 'Root',
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'Child 1',
                        'children' => [
                            [
                                'id' => 4,
                                'name' => 'Grandchild',
                                'children' => []
                            ]
                        ]
                    ],
                    [
                        'id' => 3,
                        'name' => 'Child 2',
                        'children' => []
                    ]
                ]
            ];

            $result = Utils::treeToArray($treeStructure);

            expect($result)->toBe([
                [
                    'id' => 1,
                    'name' => 'Root',
                    'children' => []
                ],
                [
                    'id' => 2,
                    'name' => 'Child 1',
                    'children' => []
                ],
                [
                    'id' => 4,
                    'name' => 'Grandchild',
                    'children' => []
                ],
                [
                    'id' => 3,
                    'name' => 'Child 2',
                    'children' => []
                ]
            ]);
        });

        it('uses custom children key', function () {
            $treeStructure = [
                'id' => 1,
                'name' => 'Root',
                'subitems' => [
                    [
                        'id' => 2,
                        'name' => 'Child',
                        'subitems' => []
                    ]
                ]
            ];

            $result = Utils::treeToArray($treeStructure, 'subitems');

            expect($result)->toBe([
                [
                    'id' => 1,
                    'name' => 'Root',
                    'subitems' => []
                ],
                [
                    'id' => 2,
                    'name' => 'Child',
                    'subitems' => []
                ]
            ]);
        });

        it('handles tree without children', function () {
            $treeStructure = [
                'id' => 1,
                'name' => 'Root',
                'children' => []
            ];

            $result = Utils::treeToArray($treeStructure);

            expect($result)->toBe([
                [
                    'id' => 1,
                    'name' => 'Root',
                    'children' => []
                ]
            ]);
        });
    });

    describe('objectToArray method', function () {
        it('converts object to array', function () {
            $object = new stdClass();
            $object->name = 'Product';
            $object->price = 29.99;

            $result = Utils::objectToArray($object);

            expect($result)->toBe([
                'name' => 'Product',
                'price' => 29.99
            ]);
        });

        it('converts array to array (no change)', function () {
            $array = ['name' => 'Product', 'price' => 29.99];

            $result = Utils::objectToArray($array);

            expect($result)->toBe($array);
        });

        it('handles nested objects', function () {
            $nestedObject = new stdClass();
            $nestedObject->category = new stdClass();
            $nestedObject->category->name = 'Electronics';
            $nestedObject->name = 'Product';

            $result = Utils::objectToArray($nestedObject);

            expect($result)->toBe([
                'category' => [
                    'name' => 'Electronics'
                ],
                'name' => 'Product'
            ]);
        });
    });

    describe('filterArrayKeys method', function () {
        it('filters array by allowed keys', function () {
            $array = [
                'name' => 'Product',
                'price' => 29.99,
                'description' => 'Test product',
                'category' => 'Electronics'
            ];

            $allowedKeys = ['name', 'price'];

            $result = Utils::filterArrayKeys($array, $allowedKeys);

            expect($result)->toBe([
                'name' => 'Product',
                'price' => 29.99
            ]);
        });

        it('returns empty array when no keys match', function () {
            $array = [
                'name' => 'Product',
                'price' => 29.99
            ];

            $allowedKeys = ['nonexistent'];

            $result = Utils::filterArrayKeys($array, $allowedKeys);

            expect($result)->toBe([]);
        });

        it('returns original array when all keys are allowed', function () {
            $array = [
                'name' => 'Product',
                'price' => 29.99
            ];

            $allowedKeys = ['name', 'price'];

            $result = Utils::filterArrayKeys($array, $allowedKeys);

            expect($result)->toBe($array);
        });

        it('handles empty allowed keys', function () {
            $array = [
                'name' => 'Product',
                'price' => 29.99
            ];

            $result = Utils::filterArrayKeys($array, []);

            expect($result)->toBe([]);
        });
    });

    describe('buildNamespace method', function () {
        it('builds namespace from folders', function () {
            $result = Utils::buildNamespace('App', 'Integration', 'Mapping');

            expect($result)->toBe('\App\Integration\Mapping');
        });

        it('builds namespace from single folder', function () {
            $result = Utils::buildNamespace('App');

            expect($result)->toBe('\App');
        });

        it('builds namespace from empty folders', function () {
            $result = Utils::buildNamespace();

            expect($result)->toBe('\\');
        });

        it('handles mixed data types', function () {
            $result = Utils::buildNamespace('App', 'Integration', 123);

            expect($result)->toBe('\App\Integration\123');
        });
    });

    describe('groupBy method', function () {
        it('groups items by key', function () {
            $items = [
                ['category' => 'Electronics', 'name' => 'Phone'],
                ['category' => 'Electronics', 'name' => 'Laptop'],
                ['category' => 'Books', 'name' => 'Novel'],
                ['category' => 'Books', 'name' => 'Textbook']
            ];

            $result = Utils::groupBy($items, 'category');

            expect($result)->toBe([
                'Electronics' => [
                    ['category' => 'Electronics', 'name' => 'Phone'],
                    ['category' => 'Electronics', 'name' => 'Laptop']
                ],
                'Books' => [
                    ['category' => 'Books', 'name' => 'Novel'],
                    ['category' => 'Books', 'name' => 'Textbook']
                ]
            ]);
        });

        it('groups items by nested key', function () {
            $items = [
                ['data' => ['type' => 'A'], 'name' => 'Item 1'],
                ['data' => ['type' => 'A'], 'name' => 'Item 2'],
                ['data' => ['type' => 'B'], 'name' => 'Item 3']
            ];

            $result = Utils::groupBy($items, 'data.type');

            expect($result)->toBe([
                'A' => [
                    ['data' => ['type' => 'A'], 'name' => 'Item 1'],
                    ['data' => ['type' => 'A'], 'name' => 'Item 2']
                ],
                'B' => [
                    ['data' => ['type' => 'B'], 'name' => 'Item 3']
                ]
            ]);
        });

        it('handles missing keys', function () {
            $items = [
                ['category' => 'Electronics', 'name' => 'Phone'],
                ['name' => 'Unknown Item'],
                ['category' => 'Books', 'name' => 'Novel']
            ];

            $result = Utils::groupBy($items, 'category');

            expect($result)->toBe([
                'Electronics' => [
                    ['category' => 'Electronics', 'name' => 'Phone']
                ],
                '' => [
                    ['name' => 'Unknown Item']
                ],
                'Books' => [
                    ['category' => 'Books', 'name' => 'Novel']
                ]
            ]);
        });

        it('handles empty array', function () {
            $result = Utils::groupBy([], 'category');

            expect($result)->toBe([]);
        });
    });
});
