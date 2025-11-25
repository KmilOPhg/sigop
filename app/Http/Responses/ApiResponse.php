<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     *
     * Genera una respuesta JSON estándar para respuestas exitosas.
     */
    public static function success(array $data = [], string $message = 'OK', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return JsonResponse
     *
     * Genera una respuesta JSON estándar para respuestas de advertencia.
     */
    public static function warning(string $message, array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'warning',
            'message' => $message,
            'data' => $data
        ], $code);
    }


    /**
     * @param string $message
     * @param int $code
     * @param array $errors
     * @return JsonResponse
     *
     * Genera una respuesta JSON estándar para respuestas de error.
     */
    public static function error(string $message, int $code = 400, array $errors = []) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
