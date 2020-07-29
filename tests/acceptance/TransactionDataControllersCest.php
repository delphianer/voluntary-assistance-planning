<?php
declare(strict_types=1);

use Codeception\Util\Locator;

class TransactionDataControllersCest
{
    /**
     * @var string|null
     */
    private $appointmentId;
    private $operationId;
    private $operationShiftId;
    private $operationShiftEquipmentId;
    private $operationShiftVehicleId;
    private $operationShiftDepartmentId;

    private $appointmentUniqueData = [
        'label' => 'HappyNewYear2021',
        'description' => 'just a description for that',
        'descriptionEdited' => 'i edited this description, just to test it',
        'start' => '2020-12-31 20:00:00',
        'end' => '2021-01-01 03:00:00',
    ];

    private $operationUniqueData = [
        'shortDescription' => 'Op!!KeepThemSave2020',
        'longDescription' => 'just a description',
        'longDescriptionEdited' => 'i edited this description, just to test it',
        // let this default 'mainDepartmentId' => '',
        'shift' => [
            // operationId
            'shortDescription' => 'first shift of Op!!KeepThemSave2020',
            'longDescription' => 'just an other description',
            'equipShortDesc' => 'Op!!KeepThemSave2020Equipment',
            'vehicShortDesc' => 'Op!!KeepThemSave2020Vehicle',
            'depShortDesc' => 'Op!!KeepThemSave2020Department',
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
        $I->LoginAsBob($I);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

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
     *   add, list, remove and delete appointment
     *
     * ************************************************************************************** */

/*
    private $appointmentId;
    private $appointmentUniqueData
 * */



    /**
     * @param AcceptanceTester $I
     */
    public function addAnAppointment(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/new');
        $I->fillField('label', $this->appointmentUniqueData['label']);
        $I->fillField('description', $this->appointmentUniqueData['description']);
        $I->click('//input[@type="submit"]');
        $I->seeInCurrentUrl('/appointments/create');
        $I->see('appointment was created successfully');
    }






    /**
     * @param AcceptanceTester $I
     */
    public function searchAppointmentAndGrapID(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/index');
        $I->fillField('label', $this->appointmentUniqueData['label']);
        $I->click('//input[@type="submit"]');
        $I->see($this->appointmentUniqueData['label']);
        $I->see('Search result');

        // get edit-link and extract ID
        $idStr = $I->grabAttributeFrom(Locator::combine('a[class="btn btn-sm btn-outline-warning"]', '//tbody/tr/td/a[0]'), 'href');
        $idStrArr = explode('/', $idStr);
        $this->appointmentId = $idStrArr[3];
    }





    /**
     * @param AcceptanceTester $I
     */
    public function editAppointment(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/edit/'.$this->appointmentId);
        $I->seeInField('label', $this->appointmentUniqueData['label']);
        $I->seeInField('description', $this->appointmentUniqueData['description']);
        $I->fillField('description', $this->appointmentUniqueData['descriptionEdited']);
        $I->click('//button[@type="submit"]');
        $I->seeInCurrentUrl('/appointments/save');
        $I->see('appointment was updated successfully');
        $I->seeInField('description', $this->appointmentUniqueData['descriptionEdited']);
    }




    /**
     * @param AcceptanceTester $I
     */
    public function deleteAppointment(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/search?id='.$this->appointmentId);
        $I->see($this->appointmentUniqueData['label']);
        $I->amOnPage('/appointments/delete/'.$this->appointmentId);
        $I->see('appointment was deleted successfully');
        $I->amOnPage('/appointments/search?id='.$this->appointmentId);
        $I->dontSee($this->appointmentUniqueData['label']);
    }










    /* **************************************************************************************
     *
     * Standard process -> add operation, then 1 shift, then delete everything backwards
     *
     * ************************************************************************************** */





    /**
     * @param AcceptanceTester $I
     */
    public function addAnOperation(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

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
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operations/index');
        $I->fillField('shortDescription', $this->operationUniqueData['shortDescription']);
        $I->click('//input[@type="submit"]');
        $I->see($this->operationUniqueData['shortDescription']);
        $I->see('Search result');

        // get edit-link and extract ID
        $idStr = $I->grabAttributeFrom(Locator::combine('a[class="btn btn-sm btn-outline-warning"]', '//tbody/tr/td/a[0]'), 'href');
        $idStrArr = explode('/', $idStr);
        $this->operationId = $idStrArr[3];
    }




    /**
     * @param AcceptanceTester $I
     */
    public function editOperation(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operations/edit/'.$this->operationId);
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
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operations/edit/'.$this->operationId);
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
        $this->operationShiftId = preg_replace('/^edit/', '', $idStr);
    }


    private function prepareEditOperationShiftAndAddSomething(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operations/edit/'.$this->operationId);
        $I->click('//button[@type="submit"][@value="edit'.$this->operationShiftId.'"]');
        $I->see('Edit Operation Shift');
        $I->seeInField('shortDescription', $this->operationUniqueData['shift']['shortDescription']);
    }



    /**
     * @param AcceptanceTester $I
     */
    public function editOperationShiftAndAddEquippment(AcceptanceTester $I): void
    {
        $this->prepareEditOperationShiftAndAddSomething($I);

        $I->fillField('equipShortDesc', $this->operationUniqueData['shift']['equipShortDesc']);
        $I->seeInCurrentUrl('/operations/save');
        $I->click('//button[@type="submit"][@value="saveEquipDefinition"]');
        $I->seeInCurrentUrl('/OperationShifts/save');
        $I->see($this->operationUniqueData['shift']['equipShortDesc']);
        $idStr = $I->grabAttributeFrom('//*[contains(@value,"equiEdit")]', 'value');
        $this->operationShiftEquipmentId = preg_replace('/^equiEdit/', '', $idStr);

        // todo: delete also like that
    }



    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperationShiftEquipment(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operationshiftsequipmentlink/search?id='.$this->operationShiftEquipmentId);
        $I->see($this->operationUniqueData['shift']['equipShortDesc']);
        $I->amOnPage('/operationshiftsequipmentlink/delete/'.$this->operationShiftEquipmentId);
        $I->see('was deleted successfully');
        $I->amOnPage('/operationshiftsequipmentlink/search?id='.$this->operationShiftEquipmentId);
        $I->dontSee($this->operationUniqueData['shift']['equipShortDesc']);
    }






    /**
     * @param AcceptanceTester $I
     */
    public function editOperationShiftAndAddVehicle(AcceptanceTester $I): void
    {
        $this->prepareEditOperationShiftAndAddSomething($I);

        $I->fillField('vehicShortDesc', $this->operationUniqueData['shift']['vehicShortDesc']);
        $I->seeInCurrentUrl('/operations/save');
        $I->click('//button[@type="submit"][@value="saveVehicleDefinition"]');
        $I->seeInCurrentUrl('/OperationShifts/save');
        $I->see($this->operationUniqueData['shift']['vehicShortDesc']);
        $idStr = $I->grabAttributeFrom('//*[contains(@value,"vehiEdit")]', 'value');
        $this->operationShiftVehicleId = preg_replace('/^vehiEdit/', '', $idStr);

        // todo: delete also like that
    }


    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperationShiftVehicle(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operationshiftsvehicleslink/search?id='.$this->operationShiftVehicleId);
        $I->see($this->operationUniqueData['shift']['vehicShortDesc']);
        $I->amOnPage('/operationshiftsvehicleslink/delete/'.$this->operationShiftVehicleId);
        $I->see('was deleted successfully');
        $I->amOnPage('/operationshiftsvehicleslink/search?id='.$this->operationShiftVehicleId);
        $I->dontSee($this->operationUniqueData['shift']['vehicShortDesc']);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function editOperationShiftAndAddDepartment(AcceptanceTester $I): void
    {
        $this->prepareEditOperationShiftAndAddSomething($I);

        $I->fillField('depShortDesc', $this->operationUniqueData['shift']['depShortDesc']);
        $I->seeInCurrentUrl('/operations/save');
        $I->click('//button[@type="submit"][@value="saveDepDefinition"]');
        $I->seeInCurrentUrl('/OperationShifts/save');
        $I->see($this->operationUniqueData['shift']['depShortDesc']);
        $idStr = $I->grabAttributeFrom('//*[contains(@value,"depEdit")]', 'value');
        $this->operationShiftDepartmentId = preg_replace('/^depEdit/', '', $idStr);

        // todo: delete also like that
    }


    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperationShiftDepartment(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operationshiftsdepartmentslink/search?id='.$this->operationShiftDepartmentId);
        $I->see($this->operationUniqueData['shift']['depShortDesc']);
        $I->amOnPage('/operationshiftsdepartmentslink/delete/'.$this->operationShiftDepartmentId);
        $I->see('was deleted successfully');
        $I->amOnPage('/operationshiftsdepartmentslink/search?id='.$this->operationShiftDepartmentId);
        $I->dontSee($this->operationUniqueData['shift']['depShortDesc']);
    }











    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperationShift(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operationshifts/search?id='.$this->operationShiftId);
        $I->see($this->operationUniqueData['shift']['shortDescription']);
        $I->amOnPage('/operationshifts/delete/'.$this->operationShiftId);
        $I->see('was deleted successfully');
        $I->amOnPage('/operationshifts/search?id='.$this->operationShiftId);
        $I->dontSee($this->operationUniqueData['shift']['shortDescription']);
    }



    /**
     * @param AcceptanceTester $I
     */
    public function deleteOperation(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/operations/search?id='.$this->operationId);
        $I->see($this->operationUniqueData['shortDescription']);
        $I->amOnPage('/operations/delete/'.$this->operationId);
        $I->see('operation was deleted successfully');
        $I->amOnPage('/operations/search?id='.$this->operationId);
        $I->dontSee($this->operationUniqueData['shortDescription']);
    }


    /**
     * @param AcceptanceTester $I
     */
    public function logoutUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('index');
        $I->logoffAsBob($I);
    }
}
