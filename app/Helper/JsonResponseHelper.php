<?php

use App\Enums\HttpResponse;

/**
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function defaultCreate($data = [])
{
    return response()->json(
        [
            'code' => HttpResponse::SUCCESS,
            'message' => translateMessage(__('Record created successfully')),
            'data' => $data,
            'status' => true
        ],
        HttpResponse::SUCCESS
    );
}

/**
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function defaultUpdate($data = [])
{
    return response()->json(
        [
            'code' => HttpResponse::SUCCESS,
            'message' => translateMessage(__('Record updated successfully')),
            'data' => $data,
            'status' => true
        ],
        HttpResponse::SUCCESS
    );
}

/**
 * @return \Illuminate\Http\JsonResponse
 */
function defaultDelete()
{
    return response()->json(
        [
            'code' => HttpResponse::SUCCESS,
            'message' => translateMessage('Record deleted successfully'),
            'status' => true
        ],
        HttpResponse::SUCCESS
    );
}

/**
 * @return \Illuminate\Http\JsonResponse
 */
function unauthorizeAccess()
{
    return response()->json((object)
    [
        'code' => HttpResponse::UNAUTHORIZED,
        'data' => [],
        'status' => false,
        'message' => translateMessage(__('Unauthorized! You are not allowed to access this.'))
    ], HttpResponse::UNAUTHORIZED);
}

/**
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function defaultSuccess($data = [])
{
    return response()->json(
        [
            'code' => HttpResponse::SUCCESS,
            'message' => translateMessage(__('Success')),
            'data' => $data,
            'status' => true
        ],
        HttpResponse::SUCCESS
    );
}
/**
 * @param $data
 * @param string $message
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
function statusResponseSuccess($data, $message = '', $code = HttpResponse::SUCCESS)
{
    return response()->json(
        [
            'code' => $code,
            'data' => $data,
            'status' => true,
            'message' => $message,
        ],
        $code
    );
}

/**
 * @param $data
 * @param string $message
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
function statusResponseError($key = null, $error = '', $code = HttpResponse::VALIDATION, $data = [])
{
    return response()->json(
        [
            'code' => $code,
            'data' => $data,
            'status' => false,
            'key' => $key,
            'error' => $error
        ],
        $code
    );
}
