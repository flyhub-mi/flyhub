<?php

use App\Integration\Mapping\Column;

uses(Tests\TestCase::class);

describe('Column class', function () {
    describe('string method', function () {
        it('creates string column mapping with basic parameters', function () {
            $result = Column::string('remote_field', 'local_field', 'default_value');

            expect($result)->toBe([
                'remote' => 'remote_field',
                'local' => 'local_field',
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('creates string column mapping with format', function () {
            $result = Column::string('remote_field', 'local_field', 'default_value', 'trim');

            expect($result)->toBe([
                'remote' => 'remote_field',
                'local' => 'local_field',
                'default' => 'default_value',
                'type' => 'string',
                'format' => 'trim',
            ]);
        });

        it('creates string column mapping with empty format', function () {
            $result = Column::string('remote_field', 'local_field', 'default_value', '');

            expect($result)->toBe([
                'remote' => 'remote_field',
                'local' => 'local_field',
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('uses default empty string when no default provided', function () {
            $result = Column::string('remote_field', 'local_field');

            expect($result)->toBe([
                'remote' => 'remote_field',
                'local' => 'local_field',
                'default' => '',
                'type' => 'string',
            ]);
        });
    });

    describe('date method', function () {
        it('creates date column mapping with basic parameters', function () {
            $result = Column::date('remote_date', 'local_date', '2023-01-01');

            expect($result)->toBe([
                'remote' => 'remote_date',
                'local' => 'local_date',
                'default' => '2023-01-01',
                'type' => 'date',
                'date_format' => '',
            ]);
        });

        it('creates date column mapping with date format', function () {
            $result = Column::date('remote_date', 'local_date', '2023-01-01', 'Y-m-d');

            expect($result)->toBe([
                'remote' => 'remote_date',
                'local' => 'local_date',
                'default' => '2023-01-01',
                'type' => 'date',
                'date_format' => 'Y-m-d',
            ]);
        });

        it('uses default empty string when no default provided', function () {
            $result = Column::date('remote_date', 'local_date');

            expect($result)->toBe([
                'remote' => 'remote_date',
                'local' => 'local_date',
                'default' => '',
                'type' => 'date',
                'date_format' => '',
            ]);
        });
    });

    describe('integer method', function () {
        it('creates integer column mapping with basic parameters', function () {
            $result = Column::integer('remote_int', 'local_int', 42);

            expect($result)->toBe([
                'remote' => 'remote_int',
                'local' => 'local_int',
                'default' => 42,
                'type' => 'integer',
            ]);
        });

        it('uses default 0 when no default provided', function () {
            $result = Column::integer('remote_int', 'local_int');

            expect($result)->toBe([
                'remote' => 'remote_int',
                'local' => 'local_int',
                'default' => 0,
                'type' => 'integer',
            ]);
        });
    });

    describe('double method', function () {
        it('creates double column mapping with basic parameters', function () {
            $result = Column::double('remote_double', 'local_double', 3.14);

            expect($result)->toBe([
                'remote' => 'remote_double',
                'local' => 'local_double',
                'default' => 3.14,
                'type' => 'double',
            ]);
        });

        it('uses default 0 when no default provided', function () {
            $result = Column::double('remote_double', 'local_double');

            expect($result)->toBe([
                'remote' => 'remote_double',
                'local' => 'local_double',
                'default' => 0,
                'type' => 'double',
            ]);
        });
    });

    describe('boolean method', function () {
        it('creates boolean column mapping with basic parameters', function () {
            $result = Column::boolean('remote_bool', 'local_bool', false);

            expect($result)->toBe([
                'remote' => 'remote_bool',
                'local' => 'local_bool',
                'default' => false,
                'type' => 'boolean',
            ]);
        });

        it('uses default true when no default provided', function () {
            $result = Column::boolean('remote_bool', 'local_bool');

            expect($result)->toBe([
                'remote' => 'remote_bool',
                'local' => 'local_bool',
                'default' => true,
                'type' => 'boolean',
            ]);
        });
    });

    describe('array method', function () {
        it('creates array column mapping with basic parameters', function () {
            $result = Column::array('remote_array', 'local_array', ['item1', 'item2']);

            expect($result)->toBe([
                'remote' => 'remote_array',
                'local' => 'local_array',
                'default' => ['item1', 'item2'],
                'type' => 'array',
            ]);
        });

        it('uses default empty array when no default provided', function () {
            $result = Column::array('remote_array', 'local_array');

            expect($result)->toBe([
                'remote' => 'remote_array',
                'local' => 'local_array',
                'default' => [],
                'type' => 'array',
            ]);
        });
    });

    describe('remote method', function () {
        it('creates remote-only column mapping with basic parameters', function () {
            $result = Column::remote('remote_key', 'default_value', 'string');

            expect($result)->toBe([
                'remote' => 'remote_key',
                'local' => '',
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('uses default empty string and string type when not provided', function () {
            $result = Column::remote('remote_key');

            expect($result)->toBe([
                'remote' => 'remote_key',
                'local' => '',
                'default' => '',
                'type' => 'string',
            ]);
        });
    });

    describe('local method', function () {
        it('creates local-only column mapping with basic parameters', function () {
            $result = Column::local('local_key', 'default_value', 'integer');

            expect($result)->toBe([
                'remote' => '',
                'local' => 'local_key',
                'default' => 'default_value',
                'type' => 'integer',
            ]);
        });

        it('uses default empty string and string type when not provided', function () {
            $result = Column::local('local_key');

            expect($result)->toBe([
                'remote' => '',
                'local' => 'local_key',
                'default' => '',
                'type' => 'string',
            ]);
        });
    });

    describe('concat method', function () {
        it('creates concat column mapping with string remote and local', function () {
            $result = Column::concat('remote_field', 'local_field', 'default_value', ' - ');

            expect($result)->toBe([
                'remote' => 'remote_field',
                'local' => 'local_field',
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('creates concat column mapping with array remote', function () {
            $result = Column::concat(['field1', 'field2'], 'local_field', 'default_value', ' | ');

            expect($result)->toBe([
                'remote' => [
                    'type' => 'concat',
                    'keys' => ['field1', 'field2'],
                    'separator' => ' | '
                ],
                'local' => 'local_field',
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('creates concat column mapping with array local', function () {
            $result = Column::concat('remote_field', ['local1', 'local2'], 'default_value', ' + ');

            expect($result)->toBe([
                'remote' => 'remote_field',
                'local' => [
                    'type' => 'concat',
                    'keys' => ['local1', 'local2'],
                    'separator' => ' + '
                ],
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('creates concat column mapping with both arrays', function () {
            $result = Column::concat(['remote1', 'remote2'], ['local1', 'local2'], 'default_value', ' & ');

            expect($result)->toBe([
                'remote' => [
                    'type' => 'concat',
                    'keys' => ['remote1', 'remote2'],
                    'separator' => ' & '
                ],
                'local' => [
                    'type' => 'concat',
                    'keys' => ['local1', 'local2'],
                    'separator' => ' & '
                ],
                'default' => 'default_value',
                'type' => 'string',
            ]);
        });

        it('uses default space separator when not provided', function () {
            $result = Column::concat(['field1', 'field2'], 'local_field');

            expect($result)->toBe([
                'remote' => [
                    'type' => 'concat',
                    'keys' => ['field1', 'field2'],
                    'separator' => ' '
                ],
                'local' => 'local_field',
                'default' => null,
                'type' => 'string',
            ]);
        });
    });

    describe('sku method', function () {
        it('creates sku column mapping with string keys', function () {
            $result = Column::sku('product_code', 'default_sku');

            expect($result)->toBe([
                'remote' => [
                    'type' => 'sku',
                    'keys' => 'product_code'
                ],
                'local' => 'sku',
                'default' => 'default_sku',
                'type' => 'string',
            ]);
        });

        it('creates sku column mapping with array keys', function () {
            $result = Column::sku(['brand', 'model', 'color'], 'default_sku');

            expect($result)->toBe([
                'remote' => [
                    'type' => 'sku',
                    'keys' => ['brand', 'model', 'color']
                ],
                'local' => 'sku',
                'default' => 'default_sku',
                'type' => 'string',
            ]);
        });

        it('uses default null when not provided', function () {
            $result = Column::sku('product_code');

            expect($result)->toBe([
                'remote' => [
                    'type' => 'sku',
                    'keys' => 'product_code'
                ],
                'local' => 'sku',
                'default' => null,
                'type' => 'string',
            ]);
        });
    });
});
