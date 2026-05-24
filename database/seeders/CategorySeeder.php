<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Expenses
            ['name' => 'Alimentación',       'type' => 'expense', 'icon' => 'utensils',       'color' => '#F97316'],
            ['name' => 'Transporte',          'type' => 'expense', 'icon' => 'car',             'color' => '#3B82F6'],
            ['name' => 'Vivienda',            'type' => 'expense', 'icon' => 'home',            'color' => '#8B5CF6'],
            ['name' => 'Salud',               'type' => 'expense', 'icon' => 'heart-pulse',     'color' => '#EF4444'],
            ['name' => 'Educación',           'type' => 'expense', 'icon' => 'book-open',       'color' => '#06B6D4'],
            ['name' => 'Entretenimiento',     'type' => 'expense', 'icon' => 'tv',              'color' => '#EC4899'],
            ['name' => 'Ropa y Accesorios',   'type' => 'expense', 'icon' => 'shirt',           'color' => '#F59E0B'],
            ['name' => 'Tecnología',          'type' => 'expense', 'icon' => 'laptop',          'color' => '#6366F1'],
            ['name' => 'Servicios',           'type' => 'expense', 'icon' => 'zap',             'color' => '#14B8A6'],
            ['name' => 'Deudas',              'type' => 'expense', 'icon' => 'credit-card',     'color' => '#DC2626'],
            ['name' => 'Otros gastos',        'type' => 'expense', 'icon' => 'circle-ellipsis', 'color' => '#6B7280'],
            // Incomes
            ['name' => 'Salario',             'type' => 'income',  'icon' => 'briefcase',       'color' => '#22C55E'],
            ['name' => 'Freelance',           'type' => 'income',  'icon' => 'laptop-2',        'color' => '#10B981'],
            ['name' => 'Inversiones',         'type' => 'income',  'icon' => 'trending-up',     'color' => '#16A34A'],
            ['name' => 'Otros ingresos',      'type' => 'income',  'icon' => 'circle-ellipsis', 'color' => '#4ADE80'],
            // Both
            ['name' => 'Ahorro',              'type' => 'both',    'icon' => 'piggy-bank',      'color' => '#FBBF24'],
            ['name' => 'Transferencias',      'type' => 'both',    'icon' => 'arrow-left-right', 'color' => '#94A3B8'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insertOrIgnore([
                'user_id'    => null,
                'name'       => $category['name'],
                'type'       => $category['type'],
                'icon'       => $category['icon'],
                'color'      => $category['color'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
