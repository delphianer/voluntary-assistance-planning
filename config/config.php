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

$standardConfigFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.orig.php";
$cliConfigFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . "config4cli.php";

return function_exists("root_path") ?
    include_once( $standardConfigFile) :
    include_once( $cliConfigFile) ;
