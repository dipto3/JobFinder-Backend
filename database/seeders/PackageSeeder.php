<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name'       => 'Basic',
                'limit'      => '10',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Standard',
                'limit'      => '25',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Premium',
                'limit'      => '50',
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('packages')->insert($packages);
    }
}
