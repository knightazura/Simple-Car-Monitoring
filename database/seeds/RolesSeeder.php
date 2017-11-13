<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = Role::create([
            'name' => 'Administrator', 
            'slug' => 'administrator'
        ]);
        $user = Role::create([
            'name' => 'User', 
            'slug' => 'user'
        ]);
    }
}
