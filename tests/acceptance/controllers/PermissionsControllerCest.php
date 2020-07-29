<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class PermissionsControllerCest
{
    /**
     * @var string|null
     */

    /**
     * @param AcceptanceTester $I
     */
    public function login(AcceptanceTester $I): void
    {
        $I->amOnPage('index');
        $I->loginAsBob($I);
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/permissions');
        $I->see('Manage Permissions');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        $I->amOnPage('/permissions');
        $I->see('You don\'t have access to this module: private');
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
