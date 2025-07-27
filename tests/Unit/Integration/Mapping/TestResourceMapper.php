<?php

namespace Tests\Unit\Integration\Mapping;

use App\Integration\Mapping\ResourceMapper;

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
