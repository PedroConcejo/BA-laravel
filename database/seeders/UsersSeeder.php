<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pwd = hash('sha256', 'pedro1234');
        DB::table('users')->insert([
            'name'      => 'Pedro',
            'role'      => 'owner',
            'email'     => 'pedro@ba.com',
            'password'  => $pwd,
        ]);
        
        $pwd = hash('sha256', 'pedro1234');
        DB::table('users')->insert([
            'name'      => 'Cyclist Membership Center',
            'role'      => 'partner',
            'email'     => 'cmc@ba.com',
            'password'  => $pwd,
        ]);

        $names = array('Lucie','Chadrick','Edd','Kaya','Paco', 'Manolo', 'Kane', 'Wayne');
        foreach($names as $name){
            $pwd = hash('sha256', strtolower($name).'1234');
            DB::table("users")->insert(
                array(
                    'name'      => $name,
                    'email'     => strtolower($name).'@ba.com',
                    'password'  => $pwd,
                )
            );
        }
    }
}