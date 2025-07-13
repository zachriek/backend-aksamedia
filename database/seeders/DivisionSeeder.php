<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $divisions = [
            [
                'name' => 'Mobile Apps',
                'description' => 'Divisi pengembangan aplikasi mobile (Android & iOS)',
            ],
            [
                'name' => 'QA',
                'description' => 'Divisi Quality Assurance untuk testing aplikasi',
            ],
            [
                'name' => 'Full Stack',
                'description' => 'Divisi pengembangan full stack (Frontend & Backend)',
            ],
            [
                'name' => 'Backend',
                'description' => 'Divisi pengembangan backend dan API',
            ],
            [
                'name' => 'Frontend',
                'description' => 'Divisi pengembangan frontend dan user interface',
            ],
            [
                'name' => 'UI/UX Designer',
                'description' => 'Divisi desain user interface dan user experience',
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
