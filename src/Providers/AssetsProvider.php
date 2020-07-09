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

namespace Vokuro\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Assets\Manager;

class AssetsProvider implements ServiceProviderInterface
{
    protected const VERSION = "1.0.0";
    /**
     * @var string
     */
    protected $providerName = 'assets';

    /**
     * @param DiInterface $di
     *
     * @return void
     */
    public function register(DiInterface $di): void
    {
        $assetManager = new Manager();

        $di->setShared($this->providerName, function () use ($assetManager) {

            $assetManager->collection('css')
                ->addCss(
                    '/css/bootstrap-4.3.1.min.css?dc=' . self::VERSION, true, true, [
                        "media"       => "screen,projection",
                    ]
                )
                ->addCss('/css/style.css?dc=' . self::VERSION, true, true, [
                    "media" => "screen,projection"
                ]);

            $assetManager->collection('js')
                ->addJs('/js/jquery-3.3.1.slim.min.js?dc=' . self::VERSION, true, true, [])
                ->addJs('/js/bootstrap-4.3.1.min.js?dc=' . self::VERSION, true, true, []);

            return $assetManager;
        });
    }
}
