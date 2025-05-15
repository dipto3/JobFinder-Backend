<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Remote', 'status' => 1],
            ['name' => 'Part-Time', 'status' => 1],
            ['name' => 'Full-Time', 'status' => 1],
            ['name' => 'Internship', 'status' => 1],
            ['name' => 'Contractual', 'status' => 1],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name'       => $category['name'],
                'status'     => $category['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
