<?php

namespace Database\Seeders;

use App\Actions\User\CreateAccountDefault;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::create([
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ]);

            $user->refresh();

            (new CreateAccountDefault)($user);
        }
    }
}
