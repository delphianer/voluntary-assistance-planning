<?php
declare(strict_types=1);

namespace Vokuro\Tests\Acceptance\Controllers;

use AcceptanceTester;
use acceptance\CommonTestIncludes;

final class UsersControllerCest
{
    /**
     * @param AcceptanceTester $I
     */
    public function login(AcceptanceTester $I): void
    {
        $I->amOnPage('index');
        $I->LoginAsBob($I);
    }

    /**
     * @param AcceptanceTester $I
     */
    public function testIndexAsGuest(AcceptanceTester $I): void
    {
        $I->amOnPage('/users');
        $I->see('You don\'t have access to this module: private');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testIndex(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/users');
        $I->see('Search users');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testSearch(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/users/search');
        $I->see('Found users');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testCreate(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/users/create');
        $I->see('Create a User');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testEdit(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/users/edit/1');
        $I->see('Edit users');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testDelete(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/users/delete/4');
        $I->amOnPage('/users/search');
        $I->cantSee('Yukimi Nagano');
    }

    /**
     * @depends login
     * @param AcceptanceTester $I
     */
    public function testChangePassword(AcceptanceTester $I): void
    {
        $I->setCookie('PHPSESSID', $I->getLastLogonCookie($I));

        $I->amOnPage('/users/changePassword');
        $I->see('Change Password');
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
