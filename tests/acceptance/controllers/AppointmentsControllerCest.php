<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;

final class AppointmentsControllerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function login(AcceptanceTester $I): void
    {
        $I->amOnPage('index');
        $I->loginAsBob($I);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        $I->amOnPage('/appointments');
        $I->see('You don\'t have access to this module: private');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments');
        $I->see('Search appointments');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testSearch(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/search');
        $I->see('Search result');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testNew(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/new');
        $I->see('Create new appointment');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testEdit(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/appointments/edit/1');
        //$I->see('Edit appointments'); // there is no data
        $I->see('appointment was not found');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testDelete(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        // todo-025: implement: $I->amOnPage('/appointments/delete/4');
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
