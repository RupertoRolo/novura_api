<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Urgente',    'color' => '#EF4444'],
            ['name' => 'Recurrente', 'color' => '#3B82F6'],
            ['name' => 'Planeado',   'color' => '#22C55E'],
            ['name' => 'Personal',   'color' => '#8B5CF6'],
            ['name' => 'Trabajo',    'color' => '#F59E0B'],
            ['name' => 'Familia',    'color' => '#EC4899'],
            ['name' => 'Vacaciones', 'color' => '#06B6D4'],
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insertOrIgnore([
                'user_id'    => null,
                'name'       => $tag['name'],
                'color'      => $tag['color'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
