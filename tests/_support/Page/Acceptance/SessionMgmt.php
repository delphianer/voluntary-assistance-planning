<?php


namespace Page\Acceptance;

class SessionMgmt
{
    public static $URL = '/session/login';

    public $usernameField = 'email';
    public $passwordField = 'password';
    public $loginButton = '//form/*[@type="submit"]';

    public static $sessionMgmtInstance = null;
    private $cookie = null;

    /**
     * @var AcceptanceTester
     */
    protected $tester;

    public static function getInstance(\AcceptanceTester $I)
    {
        if (is_null(self::$sessionMgmtInstance)) {
            self::$sessionMgmtInstance = new SessionMgmt($I);
        }
        return self::$sessionMgmtInstance;
    }

    private function __clone()
    {
    }

    // we inject AcceptanceTester into our class
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    public function getCookie()
    {
        return $this->cookie;
    }

    public function login($name, $password)
    {
        if (is_null($this->cookie)) {
            $I = $this->tester;

            $I->amOnPage(self::$URL);
            $I->fillField($this->usernameField, $name);
            $I->fillField($this->passwordField, $password);
            $I->click($this->loginButton);

            $this->loginDone = true;

            $this->cookie = $I->grabCookie('PHPSESSID');
        }
    }

    public function logoff()
    {
        if (!is_null($this->cookie)) {
            $I = $this->tester;

            $I->amOnPage('/session/logout');
            $I->see('login');

            $this->cookie = null;
        }
    }
}
