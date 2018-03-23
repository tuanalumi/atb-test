<?php

namespace Lib;

class Response
{
    public static function error($message)
    {
        $data = [
            'status' => 0,
            'error'  => $message
        ];

        return static::generate($data);
    }

    public static function generate($data)
    {
        header('Content-Type: application/json');

        if (empty($data['status'])) {
            $data['status'] = 1;
        }

        echo json_encode($data);

        exit();
    }
}
