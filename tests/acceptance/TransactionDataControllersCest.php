<?php

class TransactionDataControllersCest
{
    /**
     * @var string|null
     */
    private $cookie = null;

    private $transactionDataTables = [
        'appointments',
    ];



    public function _before(AcceptanceTester $I)
    {
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        foreach ($this->transactionDataTables as $tbl) {
            $I->wantToTest("Dimension as Guest: ".$tbl);
            $I->amOnPage('/'.$tbl);
            $I->see('You don\'t have access to this module: private');
        }
    }

}
