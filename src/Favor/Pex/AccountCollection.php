<?php namespace Favor\Pex;

use \Illuminate\Support;

class AccountCollection extends \Illuminate\Support\Collection
{

    public function __construct($creds)
    {
        $this->connection = new PexConnection($creds);
        $accountlist = $this->connection->allAccounts();

        $items = array();
        foreach($accountlist as $act) {
            $items[] = new Account($act);
        }

        parent::__construct($items);
    }



}