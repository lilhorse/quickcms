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
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();

        DB::table('users')->insert([
            'name' => 'bd',
            'email' => 'bd@loopeer.com',
            'password' => sha1('bd@loopeer'),
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
            [
                'name' => 'system', 'display_name' => '权限管理', 'parent_id' => '0',
                'level' => 1, 'icon' => 'fa-group', 'route' => '#', 'sort' => 2,
            ],
            [
                'name' => 'maintenance', 'display_name' => '运维管理', 'parent_id' => '0',
                'level' => 1, 'icon' => 'fa-desktop', 'route' => '#', 'sort' => 3,
            ],
            [
                'name' => 'develop', 'display_name' => '开发工具', 'parent_id' => '0',
                'level' => 1, 'icon' => 'fa-wrench', 'route' => '#', 'sort' => 4,
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
                'name' => 'admin.statistics', 'display_name' => '统计分析', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/statistics', 'sort' => 4,
            ],
            [
                'name' => 'admin.documents', 'display_name' => '文档管理', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/documents', 'sort' => 5,
            ],
            [
                'name' => 'admin.pushes', 'display_name' => '推送管理', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/pushes', 'sort' => 6,
            ],
            [
                'name' => 'admin.logs', 'display_name' => '查看日志', 'parent_id' => '4',
                'level' => 2, 'icon' => '', 'route' => '/logs', 'sort' => 1,
            ],
            [
                'name' => 'admin.selector', 'display_name' => '下拉枚举管理', 'parent_id' => '4',
                'level' => 2, 'icon' => '', 'route' => '/admin/selector', 'sort' => 2,
            ]
        );
        DB::table('permissions')->insert($permissions);
        $selectors = [
            'id'=>1,
            'name'=>'父级权限',
            'enum_key'=>'parent_permissions',
            'type'=>0,
            'enum_value'=>"select id,display_name from permissions where parent_id=0"
        ];
        DB::table('selectors')->insert($selectors);
        $permission_role = array();
        foreach(range(0, count($permissions) - 1) as $index) {
            $permission_role[] = ['permission_id' => $index + 1, 'role_id' => 1];
        }
        DB::table('permission_role')->insert($permission_role);
    }
}
