<?php

class TransactionDataControllersCest
{
    /**
     * @var string|null
     */
    private $cookie = null;

    private $transactionDataModels = [
        'appointments',
        'operations',
        'operationshifts',
        'OperationshiftsDepartmentsLink',
        'OperationshiftsEquipmentLink',
        'OperationshiftsVehiclesLink',
        'OpshdeplVolunteersLink',
    ];



    public function _before(AcceptanceTester $I)
    {
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        foreach ($this->transactionDataModels as $tbl) {
            $I->wantToTest("Dimension as Guest: ".$tbl);
            $I->amOnPage('/'.$tbl);
            $I->see('You don\'t have access to this module: private');
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function login(AcceptanceTester $I): void
    {
        $I->amOnPage('/session/login');
        $I->see('Log In');
        $I->fillField('email', 'bob@phalcon.io');
        $I->fillField('password', 'password1');
        $I->click('//form/*[@type="submit"]');
        $I->see('Search users');

        $this->cookie = $I->grabCookie('PHPSESSID');
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        foreach ($this->transactionDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl);
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Search');
            $I->amOnPage('/'.$tbl.'/new');
            $I->dontSee('Call Stack');
            $I->dontSee(' on line ');
            $I->dontSee(' Error ');
        }
    }

}
