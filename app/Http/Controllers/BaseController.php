<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="FlyHub API",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppController
 */
class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * AppController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $result
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message = 'OK')
    {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message,
        ]);
    }

    /**
     * @param $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $error,
        ], $code);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], 200);
    }
}
