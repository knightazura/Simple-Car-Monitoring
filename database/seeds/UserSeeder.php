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
        $administrator = User::create([
            'name' => 'Administrator', 
            'username' => 'administrator',
            'email' => 'admin@email.com',
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => str_random(10)
        ])->each(function ($user){
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => 1
            ]);
        });
        
        /**
         *  In development environment, use Faker package
         *
          factory(User::class, 1)->create()
            ->each(function ($user) {
              DB::table('role_users')->insert([
                'user_id' => $user->id,
                'role_id' => 1
              ]);
            });
         */
    }
}
