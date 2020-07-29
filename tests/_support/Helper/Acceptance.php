<?php

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use AcceptanceTester;
use Codeception\TestInterface;
use Exception;
use Page\Acceptance\SessionMgmt;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class Acceptance extends \Codeception\Module
{
    /**
     * @param TestInterface $test
     * @throws Exception
     */
    public function _before(TestInterface $test)
    {
        parent::_before($test);

        $app = new PhinxApplication();
        $app->setAutoExit(false);
        $app->run(new StringInput('rollback -e testing -t 0'), new NullOutput());
        $app->run(new StringInput('migrate -e testing'), new NullOutput());
        $app->run(new StringInput('seed:run -e testing'), new NullOutput());
    }

    /**
     * @param AcceptanceTester $I
     */
    public function loginAsBob(AcceptanceTester $I)
    {
        $sessionMgmt = SessionMgmt::getInstance($I);

        if (!is_null($I->getLastLogonCookie($I))) {
            $I->see('not existing text because of login has been done already?');
        }

        $sessionMgmt->login('bob@phalcon.io', 'password1');
        $I->amOnPage('/session/login');

        if (is_null($I->getLastLogonCookie($I))) {
            $I->see('not existing text because login has failed');
        }
    }

    /**
     * @param AcceptanceTester $I
     * @return string|null
     */
    public function getLastLogonCookie(AcceptanceTester $I)
    {
        return SessionMgmt::getInstance($I)->getCookie();
    }


    /**
     * @param AcceptanceTester $I
     */
    public function logoffAsBob(AcceptanceTester $I)
    {
        $sessionMgmt = SessionMgmt::getInstance($I);
        $sessionMgmt->logoff();
    }
}
