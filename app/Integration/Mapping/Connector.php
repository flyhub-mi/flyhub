<?php

namespace App\Integration\Mapping;

use Adbar\Dot;

class Connector
{
    /**
     * @param array $mapping
     * @param array $columnsData
     * @param array $whereData
     * @return array
     */
    public static function buildResource($mapping, $columns, $wheres = [])
    {
        return [
            'name' => $mapping['resource'],
            'pk' => $mapping['pk'],
            'generator' => $mapping['generator'] ?: '',
            'wheres' => $wheres,
            'columns' => Utils::removeColumn($columns, $columns['pk']),
        ];
    }

    /**
     * @param array $mapping
     * @param array $item
     * @return array
     * @throws \Exception
     */
    public static function mapWheres($mapping, $item)
    {
        $mappedItemWheres = [];
        $dotItem = new Dot($item);

        foreach ($mapping['wheres'] as $mapKeys) {
            $value = null;

            if (empty($mapKeys['remote'])) {
                continue;
            }

            if ($dotItem->has($mapKeys['local'])) {
                $value = DataMapper::getValue($mapKeys, $dotItem);

                if (isset($mapKeys['type'])) {
                    $value = DataMapper::parse($value, $mapKeys);
                }

                if (isset($mapKeys['format'])) {
                    $value = DataMapper::format($value, $mapKeys['format']);
                }
            }

            $mappedItemWheres[] = [
                'column' => $mapKeys['remote'],
                'comparator' => $mapKeys['comparator'],
                'value' => empty($value) ? $mapKeys['default'] : $value,
                'type' => $mapKeys['type'],
                'format' => $mapKeys['format'],
            ];
        }

        return $mappedItemWheres;
    }
}
