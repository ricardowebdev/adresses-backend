<?php

namespace App\Traits;

trait Answerable
{

    /**
     * os codigos http ficam em Symfony\Component\HttpFoundation\Response
    */

    public static $ANSWER_SUCCESS = 'success';
    public static $ANSWER_WARNING = 'warning';
    public static $ANSWER_ERROR = 'error';
    public static $ANSWER_INFO = 'info';

    public static function answer($status, $message, $http_code, array $data = []){
        return array_merge(['status' => $status, 'message' => $message, 'http_code' => $http_code], $data);
    }

}
