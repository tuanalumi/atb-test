<?php

namespace Lib;

class Token
{
    /**
     * @return string
     * @throws \Exception
     */
    public static function generate()
    {
        $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $str = '';
        $max = mb_strlen($pool, '8bit') - 1;
        for ($i = 0; $i < 64; ++$i) {
            $str .= $pool[random_int(0, $max)];
        }

        return $str;
    }
}
