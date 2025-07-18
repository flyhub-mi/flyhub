<?php

namespace App\Integration\Channels\MercadoLivre\Api;

use App\Models\Tenant\Channel;
use Dsc\MercadoLivre\Storage\StorageInterface;

class Storage implements StorageInterface
{
    /**
     * @var Channel
     */
    private Channel $channel;

    /**
     * Storage constructor.
     * @param Channel $channel
     */
    public function __construct($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function set($name, $value)
    {
        if (!empty($name)) {
            $this->channel->configs()->updateOrCreate(['code' => $name], ['value' => $value]);
        }

        return $this;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        if (!empty($name)) {
            return $this->channel
                ->configs()
                ->where('code', $name)
                ->exists();
        }
        return false;
    }

    /**
     * @param $name
     * @return bool|string
     */
    public function get($name)
    {
        if (!empty($name) && $this->has($name)) {
            $config = $this->channel
                ->configs()
                ->where('code', $name)
                ->first();
            return is_null($config) ? false : $config->value;
        }
        return false;
    }

    /**
     * @param $name
     * @return $this
     */
    public function remove($name)
    {
        if (!empty($name) && $this->has($name)) {
            $this->channel
                ->configs()
                ->where('code', $name)
                ->delete();
        }

        return $this;
    }
}
