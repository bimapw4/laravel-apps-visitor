<?php
namespace App\Helper;

class Helper
{
    public static function Guzzle($url = null, $query = [], $header = [ 'Accept' => 'application/json' ], $body = [],$type = 'GET')
    {
        $i = 0;
        $separator = ['?','&','='];
        foreach ($query as $key => $value) {
           $url .= $separator[$i != 0 ? 1 : 0].$key.$separator[2].$value;
           $i++;
        };

        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request($type, $url, ["json" => $body, "headers" => $header]);
            return json_decode($res->getBody(),true) ?? $res->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }
    }
}
