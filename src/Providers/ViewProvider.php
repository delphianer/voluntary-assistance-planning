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

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

class ViewProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $providerName = 'view';

    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        /** @var Config $config */
        $config = $di->getShared('config');
        /** @var string $viewsDir */
        $viewsDir = $config->path('application.viewsDir');
        /** @var string $cacheDir */
        $cacheDir = $config->path('application.cacheDir');

        $di->setShared($this->providerName, function () use ($viewsDir, $cacheDir, $di) {
            $view = new View();
            $view->setViewsDir($viewsDir);
            $view->registerEngines([
                '.volt' => function (View $view) use ($cacheDir, $di) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions([
                        'path'      => $cacheDir . 'volt/',
                        'separator' => '_',
                        // TODO-003: remove later
                        'always'     => true,
                    ]);

                    $volt->getCompiler()
                         ->addFunction(
                             'isAnArray',
                                function ($resolvedArgs, $exprArgs) {
                                    return 'is_array('.$resolvedArgs.')';
                                }
                         );

                    $volt->getCompiler()
                        ->addFunction(
                            'arrayPush',
                            function ($resolvedArgs, $exprArgs) {
                                return 'array_push('.$resolvedArgs.')';
                            }
                        );

                    $volt->getCompiler()
                        ->addFunction(
                            'numberFormat',
                            function ($resolvedArgs, $exprArgs) {
                                return 'number_format('.$resolvedArgs.')';
                            }
                        );


                    return $volt;
                },
            ]);

            return $view;
        });
    }
}
