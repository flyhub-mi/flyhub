<?php

namespace App\Integration\Mapping;

use App\Models\Tenant\Channel;

abstract class ResourceMapper
{
    protected $channel;
    protected $configs;
    protected $mapping;

    /**
     * @param Channel|null $channel
     * @param array|null $configs
     * @param array|null $mapping
     * @return void
     */
    protected function __construct($channel = null, $configs = null, $mapping = [])
    {
        $this->channel = $channel;
        $this->configs = $configs;
        $this->mapping = $mapping;
    }

    /**
     * @param array $remoteData
     * @return array
     */
    public function toLocal($remoteData)
    {
        return DataMapper::map($this->mapping, $remoteData, 'local');
    }

    /**
     * @param array $localData
     * @return array
     */
    public function toRemote($localData)
    {
        return DataMapper::map($this->mapping, $localData, 'remote');
    }

    /**
     * @param array $data
     * @param string $to = 'local' | 'remote'
     * @return array
     */
    protected function mapData($data,  $to)
    {
        return DataMapper::map($this->mapping, $data, $to);
    }
}
