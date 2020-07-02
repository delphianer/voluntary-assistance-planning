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

defined('BASE_PATH') || define('BASE_PATH', dirname(dirname(__FILE__)));
defined('APP_PATH') || define('APP_PATH', BASE_PATH.DIRECTORY_SEPARATOR.'src');

// missed ?
return new \Phalcon\Config([
    'database'    => [
        'adapter'  => "mysql",
        'host'     => "127.0.0.1",
        'port'     => '3306',
        'username' => 'root',
        'password' => '',
        'dbname'   => "vokuro",
        'charset'     => 'utf8',
    ],
    'application' => [
        'baseUri'         => '/',
        'publicUrl'       => 'localhost',
        'cryptSalt'       => 'eEAfR|_&G&f,+vU]:jFr!!A&+71w1Ms9~8_4L!<@[N@DyaIP_2My|:+.u>/6m,$D',
        'viewsDir'        => BASE_PATH.'/themes/vokuro/',
        'cacheDir'        => BASE_PATH.'/var/cache/',
        'modelsDir'       => BASE_PATH . '/src/Models/',
        'sessionSavePath' => BASE_PATH.'/var/cache/session/',

        'controllersDir' => BASE_PATH . '/src/Controllers/',
        'migrationsDir'  => BASE_PATH . '/db/migrations/',
        'pluginsDir'     => BASE_PATH . '/src/Plugins/',
        'libraryDir'     => BASE_PATH . '/src/Providers/',



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
]);
