<?php


namespace App\Helpers;


class Helper
{
    public static function formatNumber($number)
    {
        return !$number ? $number : rtrim(rtrim(number_format($number,2),'0'),'.');
    }
}
