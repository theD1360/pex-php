<?php namespace Favor\Pex;

//use Illuminate\Support\Facades\Config;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

use \Guzzle\Http\Client;
use \Guzzle\Http\Subscriber\History;

class PexConnection {

    public function __construct()
    {
        $this->setConfiguration();
    }

    public function setConfiguration()
    {
        $basePath = str_finish(dirname(__FILE__), '/../../');
        $defaultConfigPath = $basePath . 'config';

        $defaultLoader = new FileLoader(new Filesystem, $defaultConfigPath);
        $this->config = new Repository($defaultLoader, 'production');

        $root = $_SERVER['DOCUMENT_ROOT'];
        $overrideConfigPath = $root.'/../app/config/packages/favor/pex';

        $overrideLoader = new FileLoader(new Filesystem, $overrideConfigPath);
        $overrideConfig = new Repository($overrideLoader, 'production');

        $pexconnection = $overrideConfig->get('pexconnection');

        foreach($pexconnection as $key => $item) {
            $this->config->set('pexconnection.'.$key, $item);
        }
    }

    public function allAccounts()
    {
        $url = $this->config->get('pexconnection.urls.accountlist');

        $postData = [
            'password' => $this->config->get('pexconnection.password'),
            'username' => $this->config->get('pexconnection.username')
        ];

        return self::fetchPost($url, $postData);
    }

    public function findAccount($id)
    {
        $url = $this->config->get('pexconnection.urls.accountdetails');

        $postData = [
            'password'  => $this->config->get('pexconnection.password'),
            'username'  => $this->config->get('pexconnection.username'),
            'id'        => $id
        ];

        return self::fetchPost($url, $postData);
    }

    public function fetchPost($url, $data)
    {
        $client = new Client();

        $request = $client->post($url);

        $request->setBody(json_encode($data), 'application/json');

        $response = $request->send();

        return $response->json();
    }

}