<?php namespace Favor\Pex;

use Illuminate\Support\Facades\Config;
use \Guzzle\Http\Client;
use \Guzzle\Http\Subscriber\History;

class PexConnection {

    public static function allAccounts()
    {
        $client = new Client();

        $request = $client->post(Config::get('pex::urls.accountlist'));

        $postData = [
            'password' => Config::get('pex::password'),
            'username' => Config::get('pex::username')
        ];

        $request->setBody(json_encode($postData), 'application/json');

        $response = $request->send();

        return $response->json();
    }

}