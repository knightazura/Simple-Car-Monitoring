<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(User::class, 1)->create()
        ->each(function ($user) {
          DB::table('role_users')->insert([
            'user_id' => $user->id,
            'role_id' => 1
          ]);
        });
    }
}
