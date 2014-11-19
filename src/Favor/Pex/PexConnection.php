<?php namespace Favor\Pex;

//use Illuminate\Support\Facades\Config;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

use \Guzzle\Http\Client;
use \Guzzle\Http\Subscriber\History;

class PexConnection {

    public function __construct($creds)
    {
        $this->setConfiguration($creds);
    }

    public function setConfiguration($creds)
    {
        $basePath = str_finish(dirname(__FILE__), '/../../');
        $defaultConfigPath = $basePath . 'config';

        $defaultLoader = new FileLoader(new Filesystem, $defaultConfigPath);
        $this->config = new Repository($defaultLoader, 'production');

        $this->config->set('pexconnection.username', $creds['username']);
        $this->config->set('pexconnection.password', $creds['password']);

        $this->creds = [
            'password' => $this->config->get('pexconnection.password'),
            'username' => $this->config->get('pexconnection.username')
        ];
    }

    public function allAccounts()
    {
        $url = $this->config->get('pexconnection.urls.accountlist');

        return self::post($url, $this->creds);
    }

    public function findAccount($id)
    {
        $url = $this->config->get('pexconnection.urls.accountdetails');

        $postData = array_merge($this->creds, array('id' => $id));

        return self::post($url, $postData);
    }

    public function fund($id, $amount)
    {
        if (!is_numeric($amount)) {
            throw new PexException('Bad Amount');
        }

        $url = $this->config->get('pexconnection.urls.accountfund');

        $postData = array_merge($this->creds, array('id' => $id, 'amount' => $amount));

        return self::post($url, $postData);
    }

    public function updateCardStatus($id, $status)
    {
        if (!in_array($status, Card::$updateableCardStatuses)) {
            throw new PexException('Bad Card Status');
        }

        $url = $this->config->get('pexconnection.urls.cardupdatestatus');

        $postData = array_merge($this->creds, array('id' => $id, 'status' => $status));

        return self::post($url, $postData);
    }

    public static function post($url, $data)
    {
        $client = new Client();

        $request = $client->post($url);

        $request->setBody(json_encode($data), 'application/json');

        $response = $request->send();

        return $response->json();
    }
}