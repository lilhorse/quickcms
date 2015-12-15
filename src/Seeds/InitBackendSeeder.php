<?php

namespace Loopeer\QuickCms\Seeds;

use DB;
use Illuminate\Database\Seeder;

class InitBackendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'YongBin Deng',
            'email' => 'dengyongbin@loopeer.com',
            'password' => sha1('111111'),
            'status' => 1,
        ]);

        DB::table('roles')->insert([
            'name' => 'admin',
            'display_name' => '超级管理员',
            'description' => 'admin',
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $permissions = array(
            [
                'name' => 'admin.index', 'display_name' => '欢迎页', 'parent_id' => '0',
                'level' => 1, 'icon' => 'fa-home', 'route' => '/admin/index', 'sort' => 1,
            ],
//            [
//                'name' => 'admin.dashboard', 'display_name' => '数据面板', 'parent_id' => '0',
//                'level' => 1, 'icon' => 'fa-dashboard', 'route' => '/admin/dashboard', 'sort' => 2,
//            ],
            [
                'name' => 'system', 'display_name' => '系统管理', 'parent_id' => '0',
                'level' => 1, 'icon' => 'fa-puzzle-piece', 'route' => '#', 'sort' => 2,
            ],
            [
                'name' => 'maintenance', 'display_name' => '运维管理', 'parent_id' => '0',
                'level' => 1, 'icon' => 'fa-desktop', 'route' => '#', 'sort' => 3,
            ],
            [
                'name' => 'admin.users', 'display_name' => '用户管理', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/admin/users', 'sort' => 1,
            ],
            [
                'name' => 'admin.permissions', 'display_name' => '权限管理', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/admin/permissions', 'sort' => 2,
            ],
            [
                'name' => 'admin.roles', 'display_name' => '角色管理', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/admin/roles', 'sort' => 3,
            ],
//            [
//                'name' => 'admin.logs', 'display_name' => '操作日志', 'parent_id' => '3',
//                'level' => 2, 'icon' => '', 'route' => '/admin/logs', 'sort' => 1,
//            ],
            [
                'name' => 'admin.feedbacks', 'display_name' => '意见反馈', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/feedbacks', 'sort' => 1,
            ],
            [
                'name' => 'admin.versions', 'display_name' => '版本管理', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/versions', 'sort' => 2,
            ],
            [
                'name' => 'admin.system', 'display_name' => '系统设置', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/systems', 'sort' => 3,
            ],
            [
                'name' => 'admin.logs', 'display_name' => '查看日志', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/logs', 'sort' => 4,
            ]
        );
        DB::table('permissions')->insert($permissions);

        $permission_role = array();
        foreach(range(0, 8) as $index) {
            $permission_role[] = ['permission_id' => $index + 1, 'role_id' => 1];
        }
        DB::table('permission_role')->insert($permission_role);
    }
}
