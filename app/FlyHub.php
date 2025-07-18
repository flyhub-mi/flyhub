<?php

namespace App;

use App;
use Exception;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Log;

class FlyHub
{
    /**
     * Active Channels
     * @var string[]
     */
    const CHANNELS = ['Bling', 'WooCommerce', 'Magento', 'Magento2', 'MercadoLivre', 'TotalExpress', 'Sisplan', 'Vendure'];

    /**
     * Active Resources
     * @var string[]
     */
    const RESOURCES = ['Categories', 'Orders', 'Products'];

    /**
     * Items to get by page on channel sync
     * @var int
     */
    const LIMIT_PER_PAGE = 20;

    /**
     * @param string $message
     * @param array $metadata
     * @param null|bool $throwException
     * @return void
     * @throws Exception
     */
    public static function notifyWithMetaData($message, $metadata, $throwException = false)
    {
        $exception = new Exception($message);

        if (App::environment('production')) {
            Bugsnag::notifyException($exception, fn ($report) => $report->setMetaData($metadata));
        } else {
            self::localLog($message, $metadata);
        }

        if ($throwException) {
            throw $exception;
        }
    }

    /**
     * @param mixed $exception
     * @param array $metadata
     * @param null|bool $throwException
     * @return void
     */
    public static function notifyException($exception, $throwException = false)
    {
        if (App::environment('production')) {
            Bugsnag::notifyException($exception);
        } else {
            self::localLog($exception);
        }

        if ($throwException) {
            throw $exception;
        }
    }

    /**
     * @param mixed $exception
     * @param array $metadata
     * @param null|bool $throwException
     * @return void
     */
    public static function notifyExceptionWithMetaData($exception, $metadata, $throwException = false)
    {
        if (App::environment('production')) {
            Bugsnag::notifyException($exception, fn ($report) => $report->setMetaData($metadata));
        } else {
            self::localLog($exception, $metadata);
        }

        if ($throwException) {
            throw $exception;
        }
    }

    private static function localLog($ex, $metadata = [])
    {
        if (is_string($ex)) {
            Log::info($ex);
        } else {
            Log::info($ex->getMessage());
            Log::info($ex->getTraceAsString());
            Log::info(json_encode($metadata, JSON_PRETTY_PRINT));
        }
    }
}
