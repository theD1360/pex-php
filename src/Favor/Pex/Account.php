<?php namespace Favor\Pex;

class Account
{

    public $id;
    public $firstName;
    public $lastName;
    public $ledgerBalance;
    public $availableBalance;
    public $status;
    public $cards = [];

    public function __construct($account = null)
    {
        if ($account) {
            $this->fill($account);
        }
    }

    public function find($pexAccountId)
    {
       $account = PexConnection::findAccount($pexAccountId);
       if ($account) {
            $this->fill($account);
       }
    }

    protected function fill($account)
    {
        if ($account) {
            $this->id               = $account['id'];
            $this->firstName        = $account['firstName'];
            $this->lastName         = $account['lastName'];
            $this->ledgerBalance    = $account['ledgerBalance'];
            $this->availableBalance = $account['availableBalance'];
            $this->status           = $account['status'];
            $this->cards            = $account['cards'];
        }
    }

}