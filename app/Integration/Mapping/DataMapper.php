<?php

namespace App\Integration\Mapping;

use function _\get;
use Carbon\Carbon;
use App\FlyHub;

use Adbar\Dot;
use Log;

class DataMapper
{
    /**
     * @param array $mapping
     * @param array|object $data
     * @param string $to
     * @return array
     */
    public static function map($mapping, $data,  $to)
    {
        $dotData = new Dot($data);
        $dotMappedData = new Dot();
        $from = $to === 'local' ? 'remote' : 'local';
        $fromKeyPrefix = self::getKeyPrefix($mapping, $from);
        $toKeyPrefix = self::getKeyPrefix($mapping, $to);

        foreach (get($mapping, 'columns', []) as $column) {
            if (empty(get($column, $to))) continue;

            $toKey = self::getKeyWithPrefix($toKeyPrefix, get($column, $to));
            $value = self::parseColumnValue($column, $from, $dotData, $fromKeyPrefix);
            if (empty($value) || is_null($value)) $value = get($column, 'default', '');

            // if to value not empty continue
            if (!empty($dotMappedData->get($toKey))) {
                continue;
            }

            $dotMappedData->set($toKey, $value);
        }

        foreach (get($mapping, 'relations', []) as $relationMapping) {
            $mappedRel = self::mapRelation($relationMapping, $data, $from, $to);
            $toKey = get($relationMapping, "{$to}.key");

            if (empty($toKey)) {
                $dotMappedData->mergeRecursiveDistinct($mappedRel);
            } else {
                $dotMappedData->mergeRecursiveDistinct($toKey, $mappedRel);
            }
        }

        return $dotMappedData->all();
    }

    /**
     * @param mixed $mapping
     * @param mixed $place
     * @return mixed
     */
    private static function getKeyPrefix($mapping,  $place)
    {
        return get($mapping, "{$place}.key");
    }

    /**
     * @param string|null $prefix
     * @param string $key
     * @return mixed
     */
    private static function getKeyWithPrefix($prefix = null,  $key)
    {
        return is_null($prefix) || empty($prefix) ? $key : implode('.', [$prefix, $key]);
    }

    /**
     * @param array $column
     * @param string $from
     * @param Dot $dotData
     * @param string|null $fromKeyPrefix
     * @return mixed
     */
    private static function parseColumnValue($column,  $from, $dotData, $fromKeyPrefix = '')
    {
        try {
            $columnFrom = get($column, $from);
            $value = self::getValue($dotData, $columnFrom, $fromKeyPrefix);
            $type = get($column, 'type');
            $format = get($column, 'format');

            if (!empty($type)) {
                $value = self::parse($value, $type, get($column, 'date_format'));
            }

            if (!empty($format)) {
                $value = self::format($value, $format);
            }

            return $value;
        } catch (\Exception $e) {
            FlyHub::notifyExceptionWithMetaData($e, ['parseColumnValue' => [
                'column' => $column, 'from' => $from, 'dotData' => $dotData
            ]]);

            return '';
        }
    }

    /**
     * @param Dot $dotData
     * @param array|string $columnFrom
     * @param string|null $keyPrefix
     * @return mixed
     */
    public static function getValue(Dot $dotData, $columnFrom, $keyPrefix = '')
    {
        if (is_array($columnFrom)) {
            $type = get($columnFrom, 'type');
            $values = array_map(
                fn ($key) => $dotData->get(self::getKeyWithPrefix($keyPrefix, $key)),
                get($columnFrom, 'keys')
            );

            if ($type === 'sku') {
                return Utils::buildSku($values);
            }

            if ($type === 'concat') {
                return implode($columnFrom['separator'], $values);
            }
        }


        return $dotData->get(self::getKeyWithPrefix($keyPrefix, $columnFrom));
    }

    /**
     * @param mixed $value
     * @param string|null $type
     * @param string|null $dateFormat
     * @return mixed
     */
    public static function parse($value,  $type, $dateFormat = '')
    {
        if (empty($value)) {
            return '';
        }

        if (in_array($type, ['integer', 'int'])) {
            return intval($value);
        }

        if (in_array($type, ['boolean', 'bool'])) {
            return boolval($value);
        }

        if (in_array($type, ['double', 'decimal'])) {
            return floatval($value);
        }

        if (in_array($type, ['string', 'varchar'])) {
            return strval($value);
        }

        try {
            if (in_array($type, ['date', 'datetime']) && !empty($dateFormat)) {
                return Carbon::createFromFormat($dateFormat, $value)->toString();
            }
        } catch (\Exception $ex) {
            Log::info('Error carbon create date from format', [$dateFormat, $value, $ex->getMessage()]);
        }

        try {
            if (in_array($type, ['date', 'datetime'])) {
                return Carbon::parse($value)->toString();
            }
        } catch (\Exception $ex) {
            Log::info('Error carbon parse date', [$dateFormat, $value, $ex->getMessage()]);
        }

        try {
            if (in_array($type, ['date', 'datetime']) && is_numeric($value)) {
                return Carbon::createFromTimestamp($value)->toString();
            }
        } catch (\Exception $ex) {
            Log::info('Error carbon create date from timestamp', [$value, $ex->getMessage()]);
        }

        return $value;
    }

    /**
     * @param array|null $relMapping
     * @param array $data
     * @param string $from
     * @param string $to
     * @return array
     */
    public static function mapRelation($relMapping, $data,  $from,  $to)
    {
        $fromKey = get($relMapping, "{$from}.key");
        $toKey = get($relMapping, "{$to}.key");

        $fromIsArray = !empty($fromKey) && get($relMapping, "{$from}.is_array", false);
        $toIsArray = !empty($toKey) && get($relMapping, "{$to}.is_array", false);

        if ($fromIsArray) unset($relMapping[$from]);
        if ($toIsArray) unset($relMapping[$to]);

        if ($fromIsArray && $toIsArray) {
            return array_map(fn ($item) => self::map($relMapping, $item, $to), get($data, $fromKey, []));
        } else if ($fromIsArray) {
            return self::map($relMapping, head(get($data, $fromKey, [])), $to);
        } else if ($toIsArray) {
            return [get(self::map($relMapping, $data, $to), $toKey)];
        }

        if (isset($relMapping[$to])) {
            unset($relMapping[$to]);
        }

        return self::map($relMapping, $data, $to);
    }

    /**
     * @param mixed $value
     * @param string|array $formats
     * @return string
     */
    public static function format($value, $formats)
    {
        $value = strval($value);

        // recursive format
        if (is_array($formats)) {
            foreach ($formats as $f) {
                $value = self::format($value, $f);
            }

            return $value;
        }

        // return if empty value
        if (empty($value)) {
            return '';
        }

        // try to format type
        switch ($formats) {
            case 'trim':
                return trim($value);
            case 'letters':
                return preg_replace('/[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]/', '', $value);
            case 'numbers':
                return preg_replace('/[^0-9]/', '', $value);
            case 'letters-and-numbers':
                return preg_replace('/[^0-9A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]/', '', $value);
            case 'cpf':
                return preg_replace(
                    '/(\d{3})(\d{3})(\d{3})(\d{2})/',
                    "\$1.\$2.\$3-\$4",
                    self::format($value, 'numbers'),
                );
            case 'cnpj':
                return preg_replace(
                    '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
                    "\$1.\$2.\$3/\$4-\$5",
                    self::format($value, 'numbers'),
                );
            case 'cpf_cnpj':
                return strlen((string) self::format($value, 'numbers')) > 11
                    ? self::format($value, 'cnpj')
                    : self::format($value, 'cpf');
            case 'cep':
                return preg_replace('/(\d{2})(\d{3})(\d{3})/', "\$1.\$2-\$3", self::format($value, 'numbers'));
            case 'html-decode':
                return html_entity_decode($value);
            case 'html-encode':
                return htmlspecialchars($value);
            case 'html-remove':
                return strip_tags($value);
            default:
                return $value;
        }
    }
}
