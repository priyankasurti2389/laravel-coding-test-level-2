<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('roles')->truncate();
        DB::table('roles')->insert([
            'id'=>Str::uuid(),
            'role_name' => "SUPERADMIN",
            'access_list' => '[{"path": "*","methods": ["*"]}]',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('roles')->insert([
            'id'=>Str::uuid(),
            'role_name' => "ADMIN",
            'access_list' => '[{"path":"api\/users\/*","methods":["POST","GET","PUT","DELETE"]}]',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('roles')->insert([
            'id'=>Str::uuid(),
            'role_name' => "PRODUCT_OWNER",
            'access_list' => '[{"path":"api\/projects\/*","methods":["POST"]},{"path":"api\/tasks\/*","methods":["POST"]}]',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('roles')->insert([
            'id'=>Str::uuid(),
            'role_name' => "TEAM_MEMBER",
            'access_list' => '[{"path":"api\/tasks\/status\/update\/","methods":["POST"]}]',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
    }
}
