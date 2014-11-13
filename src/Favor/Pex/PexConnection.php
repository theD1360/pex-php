<?php namespace Favor\Pex;

use Illuminate\Support\Facades\Config;
use \Guzzle\Http\Client;
use \Guzzle\Http\Subscriber\History;

class PexConnection {

    public static function allAccounts()
    {
        $url = Config::get('pex::urls.accountlist');

        $postData = [
            'password' => Config::get('pex::password'),
            'username' => Config::get('pex::username')
        ];

        return self::fetchPost($url, $postData);
    }

    public static function findAccount($id) {
        $url = Config::get('pex::urls.accountdetails');

        $postData = [
            'password'  => Config::get('pex::password'),
            'username'  => Config::get('pex::username'),
            'id'        => $id
        ];

        return self::fetchPost($url, $postData);
    }

    public static function fetchPost($url, $data)
    {
        $client = new Client();

        $request = $client->post($url);

        $request->setBody(json_encode($data), 'application/json');

        $response = $request->send();

        return $response->json();
    }

}