<?php


namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;
use Codeception\Util\Locator;

final class MasterDataControllerCest
{
    /**
     * @var string|null
     */
    private $cookie = null;

    private $masterDataModels = [
        'certificates',
        'clients' ,
        'departments',
        'equipment' ,
        'locations' ,
        'vehicleproperties',
        'vehicles' ,
        'volunteers' ,
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

        foreach ($this->masterDataModels as $tbl) {
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


    /**
     * @param AcceptanceTester $I
     */
    public function testWholeProcess(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $this->cookie);
        $testEntryShortDesc = 'simpleTestEntry'.date("Ymd.his");

        foreach ($this->modelsWithDescriptionAndID as $tbl) {
            $I->wantToTest("Create new ".$tbl);
            $I->amOnPage('/'.$tbl.'/new');
            $I->fillField('label', $testEntryShortDesc);
            $I->seeInCurrentUrl('/'.$tbl.'/new');
            $I->see('Label');
            $I->dontSeeInSource('name="id"');
            $I->seeInSource('value="Save"');
            $I->click('//input[@type="submit"]');
            $I->seeInCurrentUrl('/'.$tbl.'/create');
            $I->see('was created successfully');

            $I->wantToTest("Search new created ".$tbl);
            $I->seeInField('label', $testEntryShortDesc);
            $I->click('//input[@type="submit"]');
            $I->see($testEntryShortDesc);

            $I->wantToTest("prepare edit new created data ".$tbl);

            // get edit-link and extract ID
            $idStr = $I->grabAttributeFrom(Locator::combine('a[class="btn btn-sm btn-outline-warning"]', '//tbody/tr/td/a[0]'), 'href');
            $idStrArr = explode('/', $idStr);
            $id = $idStrArr[3];

            $I->wantToTest("edit new created (ID=".$id.") data at ".$tbl);
            $I->click(Locator::combine('a[class="btn btn-sm btn-outline-warning"]', '//tbody/tr/td/a[0]'));
            // stay edit:
            $I->seeInCurrentUrl('/'.$tbl.'/edit/'.$id);
            $I->seeInField('label', $testEntryShortDesc);
            $testEntryShortDescEdited = $testEntryShortDesc. '.edited';
            $I->fillField('label', $testEntryShortDescEdited);
            $I->click('//input[@type="submit"]');
            $I->seeInCurrentUrl('/'.$tbl.'/save');
            $I->see('was updated successfully');

            $I->wantToTest("Search entry again ".$testEntryShortDescEdited);
            $I->amOnPage('/'.$tbl.'/search?label='.$testEntryShortDescEdited);
            $I->see($testEntryShortDescEdited);

            $I->wantToTest("delete entry with ID '.$id.' -> ".$testEntryShortDescEdited);
            $I->amOnPage('/'.$tbl.'/delete/'.$id);
            $I->seeInCurrentUrl('/'.$tbl.'/delete/'.$id);
            $I->see('was deleted successfully');
        }
        /* process-steps:
            1. 'new', ok
            2. 'create', ok
            3. 'index', ok
            4. 'search', ok
            5. 'edit', ok
            6. 'save', ok
            7. 'search', ok
            8. 'delete', ok
        */
    }
    // todo: create tests with tables without short_desc or ID
}
