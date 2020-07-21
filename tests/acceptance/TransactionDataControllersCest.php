<?php

use Codeception\Util\Locator;

class TransactionDataControllersCest
{
    /**
     * @var string|null
     */
    private $cookie = null;
    private $_operationId;
    private $_operationShiftId;

    private $operationUniqueData = [
        'shortDescription' => 'Op!!KeepThemSave2020',
        'longDescription' => 'just a description',
        'longDescriptionEdited' => 'i edited this description, just to test it',
        // let this default 'mainDepartmentId' => '',
        'shift' => [
            // operationId
            'shortDescription' => 'first shift of Op!!KeepThemSave2020',
            'longDescription' => 'just an other description',
            'start' => '2021-01-01 00:00:00',
            'end' => '2021-12-31 23:59:59',
        ]
    ];

    private $transactionDataModels = [
        'appointments',
        'operations',
        'operationshifts',
        'operationshiftsdepartmentslink',
        'operationshiftsequipmentlink',
        'operationshiftsvehicleslink',
        'opshdeplvolunteerslink',
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
            $I->dontSee('Fatal error:');
            $I->dontSee('Uncaught ArgumentCountError');
        }
    }





    /* **************************************************************************************
     *
     * Standard process -> add operation, then 1 shift, then delete everything backwards
     *
     * ************************************************************************************** */





    /**
     * @param AcceptanceTester $I
     */
    public function addAOperation(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/operations/new');
        $I->fillField('shortDescription', $this->operationUniqueData['shortDescription']);
        $I->fillField('longDescription', $this->operationUniqueData['longDescription']);
        $I->click('//input[@type="submit"]');
        $I->seeInCurrentUrl('/operations/create');
        $I->see('operation was created successfully');
    }



    /**
     * @param AcceptanceTester $I
     */
    public function searchOperationAndGrapID(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/operations/index');
        $I->fillField('shortDescription', $this->operationUniqueData['shortDescription']);
        $I->click('//input[@type="submit"]');
        $I->see($this->operationUniqueData['shortDescription']);
        $I->see('Search result');

        // get edit-link and extract ID
        $idStr = $I->grabAttributeFrom(Locator::combine('a[class="btn btn-sm btn-outline-warning"]', '//tbody/tr/td/a[0]'), 'href');
        $idStrArr = explode('/', $idStr);
        $this->_operationId = $idStrArr[3];
    }




    /**
     * @param AcceptanceTester $I
     */
    public function editOperation(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/operations/edit/'.$this->_operationId);
        $I->seeInField('shortDescription', $this->operationUniqueData['shortDescription']);
        $I->seeInField('longDescription', $this->operationUniqueData['longDescription']);
        $I->fillField('longDescription', $this->operationUniqueData['longDescriptionEdited']);
        $I->click('//button[@type="submit"]');
        $I->seeInCurrentUrl('/operations/save');
        $I->see('operation was updated successfully');
        $I->seeInField('longDescription', $this->operationUniqueData['longDescriptionEdited']);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function editOperationAndAddShift(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/operations/edit/'.$this->_operationId);
        $I->seeInField('shortDescription', $this->operationUniqueData['shortDescription']);
        $I->click('//button[@type="submit"][@value="goToShift"]');
        $I->see('Create Operation Shift');
        $I->see('Add shift for Operation: '.$this->operationUniqueData['shortDescription']);
        $I->fillField('shortDescription', $this->operationUniqueData['shift']['shortDescription']);
        $I->fillField('longDescription', $this->operationUniqueData['shift']['longDescription']);
        $I->fillField('//input[@name="start"]', $this->operationUniqueData['shift']['start']);
        $I->fillField('//input[@name="end"]', $this->operationUniqueData['shift']['end']);
        $I->click('//input[@type="submit"]');
        $I->see('Edit operation');
        $I->see($this->operationUniqueData['shift']['shortDescription']);

        // get edit-link and extract ID
        $idStr = $I->grabAttributeFrom('//button[@name="submitAction"][@class="btn btn-sm btn-outline-warning"]', 'value');
        $this->_operationShiftId = preg_replace('/^edit/', '', $idStr);

        /*
         *
                private $operationUniqueData = [
                'shortDescription' => 'Op!!KeepThemSave2020',
                'longDescription' => 'just a description',
                'longDescriptionEdited' => 'i edited this description, just to test it',
                // let this default 'mainDepartmentId' => '',
                'shift' => [
                    // operationId
                    'shortDescription' => 'first shift of Op!!KeepThemSave2020',
                    'longDescription' => 'just an other description',
                    'start' => '2021-01-01 00:00:00',
                    'end' => '2021-12-31 23:59:59',
                ]
            ];

        // todo: add equipment, vehicle and a department
        */
    }

    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperationShift(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/operationshifts/search?id='.$this->_operationShiftId);
        $I->see($this->operationUniqueData['shift']['shortDescription']);
        $I->amOnPage('/operationshifts/delete/'.$this->_operationShiftId);
        $I->see('was deleted successfully');
        $I->amOnPage('/operationshifts/search?id='.$this->_operationShiftId);
        $I->dontSee($this->operationUniqueData['shift']['shortDescription']);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperation(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);

        $I->amOnPage('/operations/search?id='.$this->_operationId);
        $I->see($this->operationUniqueData['shortDescription']);
        $I->amOnPage('/operations/delete/'.$this->_operationId);
        $I->see('operation was deleted successfully');
        $I->amOnPage('/operations/search?id='.$this->_operationId);
        $I->dontSee($this->operationUniqueData['shortDescription']);
    }

}
