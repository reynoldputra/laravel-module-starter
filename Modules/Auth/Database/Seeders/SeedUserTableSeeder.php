<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class SeedUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // $this->call("OthersTableSeeder");
    }
}
