<?php

use App\Helpers\ResponseHelper;

// Define helper functions for ApiResponse
if (!function_exists('apiSuccess')) {
    function apiSuccess(string $message = 'Operation successful', $data = null, int $statusCode = 200)
    {
        return ResponseHelper::success($message, $data, $statusCode);
    }
}

if (!function_exists('apiError')) {
    function apiError(string $message = 'An error occurred', $errors = null, int $statusCode = 400)
    {
        return ResponseHelper::error($message, $errors, $statusCode);
    }
}

// New helper functions
if (!function_exists('apiNotFound')) {
    function apiNotFound(string $message = 'Resource not found')
    {
        return ResponseHelper::notFound($message);
    }
}

if (!function_exists('apiValidationError')) {
    function apiValidationError(string $message = 'بيانات غير صحيحة', $errors = [])
    {
        return ResponseHelper::validationError($message, $errors);
    }
}

if (!function_exists('apiUnauthorized')) {
    function apiUnauthorized(string $message = 'Unauthorized')
    {
        return ResponseHelper::unauthorized($message);
    }
}