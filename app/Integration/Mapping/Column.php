<?php

namespace App\Integration\Mapping;

class Column
{
    /**
     * @param string|array|null $remote
     * @param string|array|null $local
     * @param mixed $defaultValue
     * @param mixed $type
     * @param array $merge
     * @return array
     */
    private static function build($remote, $local, $defaultValue, $type, $merge = [])
    {
        return array_merge([
            'remote' => $remote,
            'local' => $local,
            'default' => $defaultValue,
            'type' => $type,
        ], $merge);
    }

    /**
     * @param string|array|null $remote
     * @param string|array|null $local
     * @param mixed $default
     * @param string|array $format
     * @return array
     */
    public static function string($remote, $local, $defaultValue = '', $format = '')
    {
        return self::build($remote, $local, $defaultValue, 'string', empty($format) ? [] : ['format' => $format]);
    }

    /**
     * @param string|null $remote
     * @param string|null $local
     * @param mixed $defaultValue
     * @param string $dateFormat
     * @return array
     */
    public static function date($remote, $local, $defaultValue = '',  $dateFormat = '')
    {
        return self::build($remote, $local, $defaultValue, 'date', ['date_format' => $dateFormat]);
    }

    /**
     * @param string|null $remote
     * @param string|null $local
     * @param mixed $defaultValue
     * @param string $date_format
     * @return array
     */
    public static function integer($remote, $local, $defaultValue = 0)
    {
        return self::build($remote, $local, $defaultValue, 'integer');
    }

    /**
     * @param string|null $remote
     * @param string|null $local
     * @param mixed $defaultValue
     * @param string $date_format
     * @return array
     */
    public static function double($remote, $local, $defaultValue = 0)
    {
        return self::build($remote, $local, $defaultValue, 'double');
    }

    /**
     * @param string|boolean|null $remote
     * @param string|boolean|null $local
     * @param mixed $defaultValue
     * @param string $date_format
     * @return array
     */
    public static function boolean($remote, $local, $defaultValue = true)
    {
        return self::build($remote, $local, $defaultValue, 'boolean');
    }

    /**
     * @param string|null $remote
     * @param string|null $local
     * @param mixed $defaultValue
     * @return array
     */
    public static function array($remote, $local, $defaultValue = [])
    {
        return self::build($remote, $local, $defaultValue, 'array');
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @param string $type
     * @return array
     */
    public static function remote($key, $defaultValue = '', $type = 'string')
    {
        return self::build($key, '', $defaultValue, $type);
    }

    /**
     * @param string $key
     * @param mixed $defaultValue
     * @param string $type
     * @return array
     */
    public static function local($key, $defaultValue = '', $type = 'string')
    {
        return self::build('', $key, $defaultValue, $type);
    }

    /**
     * @param string|array|null $remote
     * @param string|array|null $local
     * @param mixed|null $defaultValue
     * @param string $separator
     * @return array
     */
    public static function concat($remote = null, $local = null, $defaultValue = null,  $separator = ' ')
    {
        if (is_array($remote)) {
            $remote = ['type' => 'concat', 'keys' =>  $remote, 'separator' => $separator];
        }

        if (is_array($local)) {
            $local = ['type' => 'concat', 'keys' =>  $local, 'separator' => $separator];
        }

        return self::build($remote, $local, $defaultValue, 'string');
    }

    /**
     * @param string|array $remote
     * @param mixed|null $defaultValue
     * @return array
     */
    public static function sku($remoteKeys, $defaultValue = null)
    {
        return self::build(['type' => 'sku', 'keys' =>  $remoteKeys], 'sku', $defaultValue, 'string');
    }
}
