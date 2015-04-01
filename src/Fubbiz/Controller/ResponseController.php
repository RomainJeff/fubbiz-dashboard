<?php
namespace Fubbiz\Controller;

use Symfony\Component\HttpFoundation\Response AS Response;


class ResponseController
{
    static public function success($result, $code = 200)
    {
        return self::response($code, $result);
    }


    static public function error($message, $code)
    {
        return self::response($code, $message);
    }


    static public function response($code, $data)
    {
        $array = [
            'code' => $code
        ];


        if ($code === 200) {
            $array['result'] = $data;
        } else {
            $array['message'] = $data;
        }


        return new Response(
            json_encode($array, JSON_PRETTY_PRINT),
            $code,
            ['Content-type' => 'application/json']
        );
    }
}
