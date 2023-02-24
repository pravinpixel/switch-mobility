<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
                'is_admin'=>'1',
                'is_super_admin'=>'1',
                'auth_level'=>'9',
                'username'=>'admin',
               'password'=> bcrypt('1234'),
            ]
        ];
  
        foreach ($datas as $key => $value) {
            Permission::create($value);
        }
    }
}
