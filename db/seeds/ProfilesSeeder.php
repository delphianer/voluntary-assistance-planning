<?php
declare(strict_types=1);

namespace Vokuro\Seeds;

use Phinx\Seed\AbstractSeed;

final class ProfilesSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Systemadministrators',
                'active' => 'Y',
            ],
            [
                'id' => 2,
                'name' => 'Management',
                'active' => 'Y',
            ],
            [
                'id' => 3,
                'name' => 'Executive',
                'active' => 'Y',
            ],
            [
                'id' => 4,
                'name' => 'Helpers',
                'active' => 'Y',
            ],
            [
                'id' => 5,
                'name' => 'Read-Only',
                'active' => 'Y',
            ],
        ];

        $posts = $this->table('profiles');
        $posts->insert($data)
            ->save();
    }
}
