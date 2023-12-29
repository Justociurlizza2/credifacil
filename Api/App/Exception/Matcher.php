<?php
namespace App\Exception;
use Controllers\Helper;

class Matcher {
    public static $matches = [
        'protected method',
        'private method',
    ];
    static function match(string $msg): string
    {
        foreach (self::$matches as $match) 
            if (str_contains($msg, $match)) return $match;
        return 'none';
    }
    static function clean(string $msg, string $key): string
    {
        $explode = explode(' ', $msg);
        foreach ($explode as $word)
            if(str_contains($word, $key)) $msg = str_replace($word, '', $msg);
        return $msg;
    }
}