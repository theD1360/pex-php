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

    public function __construct($creds, $account = null)
    {
        $this->connection = new PexConnection($creds);

        if ($account) {
            $this->fill($account);
        }
    }

    public static function find($pexAccountId, $creds)
    {
        $account = $this->connection->findAccount($pexAccountId);
        if ($account) {
            return new self($creds, $pexAccount);
        }
    }

    public function addCredit($amount)
    {
        if (is_numeric($amount) and $amount > 0) {
            $this->connection->fund($amount);
        }
    }

    public function subtractCredit($amount)
    {
        if (is_numeric($amount) and $amount > 0) {
            $this->connection->fund(-$amount);
        }
    }

    public function zeroOutCredit()
    {
        $this->connection->fund($this->availableBalance);
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