<?php

namespace App\Integration\Mapping;

use function _\concat;

class Resource
{
    /**
     * @param array $mapping = ...Resource::{method}();
     * @return array
     */
    public static function mapping(...$mapping)
    {
        return isset($mapping[0]) ? concat(...$mapping) : $mapping;
    }

    /**
     * @param string $key
     * @param null|bool $isArray
     * @return array
     */
    public static function local($key, $isArray = false)
    {
        return ['local' => ['key' => $key, 'is_array' => $isArray]];
    }

    /**
     * @param null|string $key
     * @param null|bool $isArray
     * @return array
     */
    public static function remote($key = null, $isArray = false)
    {
        return ['remote' => ['key' => $key, 'is_array' => $isArray]];
    }

    /**
     * @param array<Column> $columns
     * @return array
     */
    public static function columns(...$columns)
    {
        return ['columns' => isset($columns[0]) ? $columns : $columns];
    }

    /**
     * @param array<Column> $columns
     * @return array
     */
    public static function line($localKeyWithIndex = '{index}', $remoteKeyWithIndex = '{index}', $type = 'string')
    {
        return ['line' => ['local' => $localKeyWithIndex, 'remote' => $remoteKeyWithIndex, 'type' => 'string']];
    }

    /**
     * @param array $relations = Resource::mapping()
     * @return array
     */
    public static function relations(...$relations)
    {
        return ['relations' => isset($relations[0]) ? $relations : [$relations]];
    }

    /**
     * @param array<Column> $configs
     * @return array
     */
    public static function configs(...$configs)
    {
        return ['configs' => isset($configs[0]) ? $configs : [$configs]];
    }

    /**
     * @param array $metadata = ['key' => $value]
     * @return array
     */
    public static function metadata($metadata)
    {
        return ['metadata' => $metadata];
    }
}