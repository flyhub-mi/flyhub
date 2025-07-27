<?php

namespace App\Integration\Mapping;

use Illuminate\Support\Str;
use SimpleXMLElement;

use function _\get;

class Utils
{
    /**
     * @param string $value
     * @param string $separator
     * @return string
     */
    public static function slug($value, $separator = '-')
    {
        return Str::slug($value, $separator);
    }

    /**
     * @param array|string $pieces
     * @return string
     */
    public static function buildSku($pieces)
    {
        $sku = is_array($pieces) ? implode('-', $pieces) : $pieces;
        $sku = self::slug($sku, '-');
        $sku = str_replace('_', '-', $sku);
        $sku = strtoupper($sku);

        return $sku;
    }

    /**
     * @param array $items
     * @param string $value
     * @param string $key
     * @return array
     */
    public static function removeColumn($items,  $value, $key = 'name')
    {
        return array_filter($items, fn ($item) => get($item, $key, '') !== $value);
    }

    /**
     * @param $array
     * @param null $rootElement
     * @param null $xml
     * @return string|bool
     */
    public static function arrayToXml($array, $rootElement = null, $xml = null)
    {
        $_xml = $xml ?: new SimpleXMLElement($rootElement ?: '<root/>');

        foreach ($array as $k => $v) {
            if (is_array($v)) {
                self::arrayToXml($v, $k, $_xml->addChild(is_int($k) ? 'item' . $k : $k));
            } else {
                $_xml->addChild($k, $v);
            }
        }

        return $_xml->asXML();
    }

    /**
     * @param mixed $flatStructure
     * @param mixed $parentIdKey
     * @param mixed|null $idKey
     * @return mixed
     */
    public static function arrayToTree($flatStructure, $parentIdKey, $idKey = null)
    {
        $parents = [];

        foreach ($flatStructure as $item) {
            $parents[$item[$parentIdKey]][] = $item;
        }

        $fnBuilder = function ($items, $parents, $idKey) use (&$fnBuilder) {
            foreach ($items as $position => $item) {
                $id = $item[$idKey];

                // when is parent add children
                if (isset($parents[$id])) {
                    $item['children'] = $fnBuilder($parents[$id], $parents, $idKey);
                }

                //reset the value as children have changed
                $items[$position] = $item;
            }

            return $items;
        };

        return $fnBuilder($parents[0], $parents, $idKey);
    }

    /**
     * @param array $treeStructure
     * @param string $chilrensKey
     * @param null|array $flatStructure
     * @return mixed
     */
    public static function treeToArray($treeStructure, $chilrensKey = 'children', $flatStructure = [])
    {
        $childrens = get($treeStructure, $chilrensKey, []);
        $treeStructure[$chilrensKey] = [];
        $flatStructure[] = $treeStructure;

        foreach ($childrens as $children) {
            $flatStructure = self::treeToArray($children, $chilrensKey, $flatStructure);
        }

        return $flatStructure;
    }

    /**
     * @param object|array $data
     * @return array
     */
    public static function objectToArray($data)
    {
        return json_decode(json_encode($data), true);
    }

    /**
     * @param array $array
     * @param array $allowedKeys
     * @return array
     */
    public static function filterArrayKeys($array, $allowedKeys)
    {
        return array_filter(
            $array,
            fn ($key) => in_array($key, $allowedKeys),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @param $folders
     * @return string
     */
    public static function buildNamespace(...$folders)
    {
        return '\\' . join('\\', $folders);
    }

    /**
     * @param array $items
     * @param string $key
     * @return array
     */
    public static function groupBy($items,  $key)
    {
        $result = [];

        foreach ($items as $item) {
            $resultKey = get($item, $key, '');

            $result[$resultKey][] = $item;
        }

        return $result;
    }
}
