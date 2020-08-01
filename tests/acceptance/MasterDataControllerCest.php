<?php
declare(strict_types=1);


namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;
use Codeception\Util\Locator;

final class MasterDataControllerCest
{
    /**
     * @var string|null
     */
    private $fixTestLabel = 'automaticTestKey20200720original';
    private $editedFixTestLabel = 'automaticTestKey20200720edited';
    private $masterDataIDs = []; // then stop further tests at this controller

    private $masterDataModels = [
        'certificates',
        'clients' ,
        'departments',
        'equipment' ,
        'locations' ,
        'vehicleproperties',
        'vehicles' ,
        'volunteers',
        'volunteerscertificateslink' ,
    ];

    private $modelsWithDescriptionAndID = [
        'certificates',
        'clients' ,
        'departments',
        'equipment' ,
        'locations' ,
        'vehicles' ,
    ];

    // todo-019: 'volunteers' ,
    // todo-019: 'volunteerscertificateslink' ,
    // todo-019: 'vehicleproperties' ,

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        foreach ($this->masterDataModels as $tbl) {
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



    /* **************************************************************************************
     *
     * Tests if there is any php error message not seen yet
     *
     * ************************************************************************************** */


    /**
     * @param AcceptanceTester $I
     */
    private function stdTestsForAllActions(AcceptanceTester $I): void
    {
        $I->dontSee('Call Stack');
        $I->dontSee(' on line ');
        $I->dontSee('Fatal error:');
        $I->dontSee(' Error ');
        $I->dontSee('Uncaught ArgumentCountError');
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testIndexActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl);
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Search');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testSearchActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl.'/search');
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Search result');
            $I->amOnPage('/'.$tbl.'/search');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testNewActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl.'/new');
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Create ');
            $I->amOnPage('/'.$tbl.'/search');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testCreateActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl.'/create');
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Search ');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testEditActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl.'/edit/-1');
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('was not found');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testSaveActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl.'/save');
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Search ');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function testDeleteActionAsAdminUser(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataModels as $tbl) {
            $I->wantToTest("Dimension as AdminUser: ".$tbl);
            $I->amOnPage('/'.$tbl.'/delete/-1');
            $I->dontSee('You don\'t have access to this module: private');
            $I->see('Search ');
            $I->see('was not found');
            $this->stdTestsForAllActions($I);
        }
    }



    /* **************************************************************************************
     *
     * Next Tests are connected between each other
     *
     * ************************************************************************************** */


    /**
     * @param AcceptanceTester $I
     */
    public function testSearchActionNoExistingTestsYet(
        AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->modelsWithDescriptionAndID as $tbl) {
            $I->amOnPage('/'.$tbl.'/index');
            $I->fillField('label', $this->fixTestLabel);
            $I->click('//input[@type="submit"]');
            $I->dontSee($this->fixTestLabel);
            $I->amOnPage('/'.$tbl.'/index');
            $I->fillField('label', $this->editedFixTestLabel);
            $I->click('//input[@type="submit"]');
            $I->dontSee($this->editedFixTestLabel);
            $this->stdTestsForAllActions($I);
        }
    }





    /**
     * @param AcceptanceTester $I
     */
    public function newActionAndCreateActionAllMasterDataController(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->modelsWithDescriptionAndID as $tbl) {
            $I->wantToTest("Create new ".$tbl);
            $I->amOnPage('/'.$tbl.'/new');
            $I->fillField('label', $this->fixTestLabel);
            $I->seeInCurrentUrl('/'.$tbl.'/new');
            $I->click('//input[@type="submit"]');
            $I->seeInCurrentUrl('/'.$tbl.'/create');
            $I->see('was created successfully');
            $this->stdTestsForAllActions($I);
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function searchActionAndExtractIdsAllMasterDataController(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->modelsWithDescriptionAndID as $tbl) {
            $I->amOnPage('/'.$tbl.'/index');
            $I->fillField('label', $this->fixTestLabel);
            $I->click('//input[@type="submit"]');
            $I->see($this->fixTestLabel);
            $this->stdTestsForAllActions($I);

            // get edit-link and extract ID
            $idStr = $I->grabAttributeFrom(Locator::combine('a[class="btn btn-sm btn-outline-warning"]', '//tbody/tr/td/a[0]'), 'href');
            $idStrArr = explode('/', $idStr);
            $this->masterDataIDs[$tbl] = $idStrArr[3];
        }
    }


    /**
     * @param AcceptanceTester $I
     */
    public function searchNewCreatedAndEditThatOnAllMasterDataController(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->modelsWithDescriptionAndID as $tbl) {
            $id = $this->masterDataIDs[$tbl];
            $I->amOnPage('/'.$tbl.'/edit/'.$id);

            $I->seeInField('label', $this->fixTestLabel);
            $I->fillField('label', $this->editedFixTestLabel);
            $I->click('//button[@type="submit"]');
            $I->seeInCurrentUrl('/'.$tbl.'/save');
            $I->see('was updated successfully');
            $this->stdTestsForAllActions($I);
        }
    }




    /**
     * @param AcceptanceTester $I
     */
    public function oldTestLabelNotExistingAnymore(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataIDs as $key => $value) {
            $I->amOnPage('/'.$key.'/index');
            $I->fillField('id', $value);
            $I->click('//input[@type="submit"]');
            $I->seeInCurrentUrl('/'.$key.'/search');
            $I->dontSee($this->fixTestLabel);
            $this->stdTestsForAllActions($I);
        }
    }




    /**
     * @param AcceptanceTester $I
     */
    public function searchNewOneOnAllMasterDataController(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataIDs as $key => $value) {
            $I->amOnPage('/'.$key.'/search/'.$value);
            $I->dontSee($this->fixTestLabel);
            $I->see($this->editedFixTestLabel);
            $this->stdTestsForAllActions($I);
        }
    }





    /**
     * @param AcceptanceTester $I
     */
    public function deleteThatOnAllMasterDataController(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataIDs as $key => $value) {
            $I->amOnPage('/'.$key.'/delete/'.$value);
            $I->dontSee($this->fixTestLabel);
            $I->dontSee($this->editedFixTestLabel);
            $I->seeInCurrentUrl('/'.$key.'/delete/'.$value);
            $this->stdTestsForAllActions($I);
        }
    }




    /**
     * @param AcceptanceTester $I
     */
    public function allTestLabelNotExistingAnymore(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        foreach ($this->masterDataIDs as $key => $value) {
            $I->amOnPage('/'.$key.'/search/'.$value);
            $I->dontSee($this->fixTestLabel);
            $I->dontSee($this->editedFixTestLabel);
            $this->stdTestsForAllActions($I);
        }
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
