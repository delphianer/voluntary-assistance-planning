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

return [
    'private' => [
        'users' => [
            'index',
            'search',
            'edit',
            'create',
            'delete',
            'changePassword',
        ],
        'profiles' => [
            'index',
            'search',
            'edit',
            'create',
            'delete',
        ],
        'certificates' => [
            'index',
            'search',
            'edit',
            'create',
            'delete',
        ],
        'clients' => [
            'index',
            'search',
            'edit',
            'create',
            'delete',
        ],
        'departments' => [
            'index',
            'search',
            'edit',
            'create',
            'delete',
        ],
        'equipment' => [
            'index',
            'search',
            'delete',
            'edit',
            'create',
            'new',
            'delete',
        ],
        // todo: setup all dimensions
        'permissions' => [
            'index',
        ],
    ],
];
