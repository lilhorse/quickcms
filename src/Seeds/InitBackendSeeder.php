<?php

namespace Loopeer\QuickCms\Seeds;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Loopeer\QuickCms\Models\Selector;
use Loopeer\QuickCms\Models\System;

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
            'password' => Hash::make(config('quickCms.backend_password') ?: '111111'),
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

        Selector::create(array(
            'name' => '上线下线状态',
            'enum_key' => 'online_offline_status',
            'enum_value' => '{"0":"上线","1":"下线"}',
            'type' => 1,
        ));

        Selector::create(array(
            'name' => '正常禁用状态',
            'enum_key' => 'normal_disable_status',
            'enum_value' => '{"0":"正常","1":"禁用"}',
            'type' => 1,
        ));

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
//            [
//                'name' => 'develop', 'display_name' => '开发工具', 'parent_id' => '0',
//                'level' => 1, 'icon' => 'fa-wrench', 'route' => '#', 'sort' => 4,
//            ],
//            [
//                'name' => 'email', 'display_name' => '邮件管理', 'parent_id' => '0',
//                'level' => 1, 'icon' => 'fa-envelope', 'route' => '#', 'sort' => 5,
//            ],
            [
                'name' => 'admin.users.index', 'display_name' => '用户管理', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/admin/users', 'sort' => 1,
            ],
            [
                'name' => 'admin.permissions.index', 'display_name' => '权限管理', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/admin/permissions', 'sort' => 2,
            ],
            [
                'name' => 'admin.roles.index', 'display_name' => '角色管理', 'parent_id' => '2',
                'level' => 2, 'icon' => '', 'route' => '/admin/roles', 'sort' => 3,
            ],
            [
                'name' => 'admin.feedbacks.index', 'display_name' => '意见反馈', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/feedbacks', 'sort' => 1,
            ],
            [
                'name' => 'admin.versions.index', 'display_name' => '版本管理', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/versions', 'sort' => 2,
            ],
            [
                'name' => 'admin.systems.index', 'display_name' => '系统设置', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/systems', 'sort' => 3,
            ],
            [
                'name' => 'admin.statistics.index', 'display_name' => '统计分析', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/statistics/index', 'sort' => 4,
            ],
            [
                'name' => 'admin.document.index', 'display_name' => '文档管理', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/document', 'sort' => 5,
            ],
            [
                'name' => 'admin.pushes.index', 'display_name' => '推送管理', 'parent_id' => '3',
                'level' => 2, 'icon' => '', 'route' => '/admin/pushes', 'sort' => 6,
            ],
//            [
//                'name' => 'admin.logs', 'display_name' => '查看日志', 'parent_id' => '4',
//                'level' => 2, 'icon' => '', 'route' => '/admin/logs', 'sort' => 1,
//            ],
//            [
//                'name' => 'admin.actionLogs.index', 'display_name' => '后台日志管理', 'parent_id' => '4',
//                'level' => 2, 'icon' => '', 'route' => '/admin/actionLogs', 'sort' => 2,
//            ],
//            [
//                'name' => 'admin.selector.index', 'display_name' => '下拉枚举管理', 'parent_id' => '4',
//                'level' => 2, 'icon' => '', 'route' => '/admin/selector', 'sort' => 3,
//            ],
//            [
//                'name' => 'admin.sendcloud.index', 'display_name' => 'SendCloud', 'parent_id' => '5',
//                'level' => 2, 'icon' => '', 'route' => '/admin/sendcloud', 'sort' => 1,
//            ]
        );
        DB::table('permissions')->insert($permissions);
        $permission_role = array();
        foreach(range(0, count($permissions) - 1) as $index) {
            $permission_role[] = ['permission_id' => $index + 1, 'role_id' => 1];
        }
        DB::table('permission_role')->insert($permission_role);

        $system_keys = ['build', 'app_review', 'android_download'];
        $system_values = ['10000', 'false', 'fir.im'];
        $system_descriptions = ['网站标题', '版本号', '版本审核状态', '安卓apk下载链接'];
        $systems = array();
        foreach($system_keys as $key => $value) {
            $systems[] = array(
                'system_key' => $value,
                'system_value' => $system_values[$key],
                'description' => $system_descriptions[$key]
            );
        }
        DB::table('systems')->insert($systems);
    }
}
