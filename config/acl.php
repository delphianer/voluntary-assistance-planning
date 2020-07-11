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

$actions_std = [
    'index',
    'search',
    'new',
    'create',
    'edit',
    'save',
    'delete',
];



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
        'permissions' => [
            'index',
        ],
        // vap own defines:
        'appointments' => $actions_std,
        'certificates' => $actions_std,
        'clients' => $actions_std,
        'departments' => $actions_std,
        'equipment' => $actions_std,
        'locations' => $actions_std,
        'operations' => $actions_std,
        'operationshifts' => $actions_std,
        'operationshiftsdepartmentslink' => $actions_std,
        'operationshiftsequipmentlink' => $actions_std,
        'operationshiftsvehicleslink' => $actions_std,
        'opshdeplvolunteerslink' => $actions_std,
        'vehicleproperties' => $actions_std,
        'vehicles' => $actions_std,
        'volunteers' => $actions_std,
        'volunteerscertificateslink'  => $actions_std,
        // todo: setup all dimensions
    ],
];
