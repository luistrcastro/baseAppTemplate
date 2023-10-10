<?php

namespace App\Http\Controllers;

class ResponseUtil
{
    /**
     * @param bool $success
     * @param string $message
     * @param mixed $data
     *
     * @return array
     */
    public static function makeResponse(bool $success = true, string $message = '', mixed $data = []): array
    {
        return [
            'success' => $success,
            'data'    => $data,
            'message' => $message,
        ];
    }
}
