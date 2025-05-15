<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name'       => 'Admin',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Company',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Candidate',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
