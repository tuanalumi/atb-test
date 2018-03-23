<?php

namespace Lib;

class Response
{
    public static function error($message)
    {
        return static::generate([
            'status' => 0,
            'error'  => $message
        ]);
    }

    public static function generate($data = [])
    {
        header('Content-Type: application/json');

        if (!isset($data['status'])) {
            $data['status'] = 1;
        }

        echo json_encode($data);

        exit();
    }
}
