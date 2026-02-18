<?php

namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class ResponseHelper
{
// •	we can add more methods like created for 201 responses or noContent for 204.
    /**
     * إرجاع استجابة نجاح
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function success(string $message = 'نجح العملية', $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * إرجاع استجابة خطأ
     *
     * @param string $message
     * @param mixed $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(string $message = 'حدث خطأ', $errors = null, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     * إرجاع استجابة تحقق (مثل للتحقق من البريد)
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function validationError(string $message = 'بيانات غير صحيحة', $errors = [], int $statusCode = 422): JsonResponse
    {
        return self::error($message, $errors, $statusCode);
    }

    /**
     * إرجاع استجابة عدم وجود صلاحية
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function unauthorized(string $message = 'غير مصرح لك'): JsonResponse
    {
        return self::error($message, null, 401);
    }

    /**
     * إرجاع استجابة عدم وجود مورد
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function notFound(string $message = 'المورد غير موجود'): JsonResponse
    {
        return self::error($message, null, 404);
    }
}