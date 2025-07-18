<?php

namespace App\Integration;

use Illuminate\Support\Collection;

abstract class ChannelConfig
{
    /**
     * Get channel config fields.
     *
     * @return Collection
     */
    abstract static function fields();

    /**
     * @param mixed $name
     * @param mixed $label
     * @param mixed $type
     * @return array
     */
    private static function build($name, $label, $type, $merge = [])
    {
        return array_merge(
            [
                'name' => $name,
                'label' => $label,
                'type' => $type,
            ],
            $merge,
        );
    }

    /**
     * @param mixed $name
     * @param mixed $label
     * @return array
     */
    protected static function text($name, $label)
    {
        return self::build($name, $label, 'text');
    }

    /**
     * @param mixed $name
     * @param mixed $label
     * @return array
     */
    protected static function password($name, $label)
    {
        return self::build($name, $label, 'password');
    }

    /**
     * @param mixed $name
     * @param mixed $label
     * @return array
     */
    protected static function checkbox($name, $label)
    {
        return self::build($name, $label, 'checkbox');
    }

    /**
     * @param string $name
     * @param string $label
     * @param array $options
     * @return array
     */
    protected static function select($name, $label, $options)
    {
        return self::build($name, $label, 'select', ['options' => $options]);
    }
}
