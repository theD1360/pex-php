<?php namespace Favor\Pex;

class Card
{

    public $id;
    public $cardNumber;
    public $status;

    public static $updateableCardStatuses = array('BLOCKED', 'OPEN');

    public function __construct($card = NULL)
    {
        if ($card) {
            $this->fill($card);
        }
    }

    //*************************************************
    //********** Protected Member Functions *********************
    //*************************************************

    protected function fill($cardArray)
    {
        if ($cardArray) {
            $this->id           = $cardArray['id'];
            $this->cardNumber   = $cardArray['cardNumber'];
            $this->status       = $cardArray['status'];
        }
    }

}