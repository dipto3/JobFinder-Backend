<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@jobfinder.com',
            'password'          => Hash::make('12345678'),
            'role_id'           => $adminRole->id,
            'email_verified_at' => now(),
        ]);
    }
}
