<?php
declare(strict_types=1);

/**
 * This file is part of the Vökuró.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Phalcon\Logger;
use function Vokuro\root_path;

defined('BASE_PATH') || define('BASE_PATH', dirname(dirname(__FILE__)));
defined('APP_PATH') || define('APP_PATH', BASE_PATH.DIRECTORY_SEPARATOR.'src');

return [
    'database'    => [
        'adapter'  => "mysql",
        'host'     => "127.0.0.1",
        'port'     => '3306',
        'username' => 'root',
        'password' => '',
        'dbname'   => "vokuro",
    ],
    'application' => [
        'baseUri'         => '/',
        'publicUrl'       => 'localhost',
        'cryptSalt'       => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
        'viewsDir'        => BASE_PATH.'themes/vokuro/',
        'cacheDir'        => BASE_PATH.'var/cache/',
        'modelsDir'       => APP_PATH . '/Models/',
        'sessionSavePath' => BASE_PATH.'/var/cache/session/',

        'controllersDir' => APP_PATH . '/Controllers/',
        'migrationsDir'  => BASE_PATH . 'db/migrations/',
        'pluginsDir'     => APP_PATH . '/Plugins/',
        'libraryDir'     => APP_PATH . '/Providers/',



    ],
    'mail'        => [
        'fromName'  => 'Vokuro',
        'fromEmail' => "mail@mh.io",
        'smtp'      => [
            'server'   => 'smtp.gmail.com',
            'port'     => '587',
            'security' => 'tls',
            'username' => '',
            'password' => '',
        ],
    ],
    'logger'      => [
        'path'     => BASE_PATH.'var/logs/',
        'format'   => '%date% [%type%] %message%',
        'date'     => 'D j H:i:s',
        'logLevel' => Logger::DEBUG,
        'filename' => 'application.log',
    ],
    // Set to false to disable sending emails (for use in test environment)
    'useMail'     => true,
];
