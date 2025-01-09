<?php
namespace App\Views\Utils;
require_once __DIR__ . '/../../../vendor/autoload.php';

class Validation{
    public static function clean($str){
        $str = trim($str);
        $str = stripcslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }
}