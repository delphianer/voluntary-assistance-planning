<?php

/**
 * This file is part of the Phalcon Developer Tools.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Vokuro;

use Phalcon\DevTools\Bootstrap;

use \Phalcon\Debug;

/**
 * @psalm-suppress MissingFile
 */
include 'webtools.config.php';
include PTOOLSPATH . '/bootstrap/autoload.php';

/**
 * @psalm-suppress UndefinedConstant
 */
$bootstrap = new Bootstrap([
    'ptools_path' => PTOOLSPATH,
    'ptools_ip'   => PTOOLS_IP,
    'base_path'   => BASE_PATH,
]);

try {
    $debug = new Debug();

    if (APPLICATION_ENV === ENV_TESTING) {
        return $bootstrap->run();
    } else {
        echo $bootstrap->run();
    }

    $debug->listen();

} catch (\Exception $ex) {

    var_dump($ex);

    $debug->listen();
}
