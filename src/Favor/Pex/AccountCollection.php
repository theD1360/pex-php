<?php namespace Favor\Pex;

use \Illuminate\Support;

class AccountCollection extends \Illuminate\Support\Collection
{

    public function __construct()
    {
        $connection = new PexConnection;
        $accountlist = $connection->allAccounts();

        $items = array();
        foreach($accountlist as $act) {
            $items[] = new Account($act);
        }

        parent::__construct($items);
    }



}