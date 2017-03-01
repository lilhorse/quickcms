<?php
/**
 * Copyright (C) Loopeer, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential.
 *
 * User: DengYongBin
 * Date: 17/2/27
 * Time: 下午4:21
 */
return [
    'feedbacks' => [
        'id' => 'ID',
        'account_id' => '用户ID',
        'content' => '反馈内容',
        'contact' => '联系方式',
        'version' => '版本',
        'device_id' => '设备序号',
        'channel_id' => '渠道',
        'created_at' => '反馈时间',
    ],
    'versions' => [
        'id' => 'ID',
        'version_code' => '版本号',
        'url' => '下载地址',
        'message' => '消息提示',
        'description' => '版本描述',
        'status' => '状态',
        'created_at' => '创建时间',
        'query_form' => '版本查询',
        'create_form' => '新增版本',
        'edit_form' => '编辑版本',
        'index_form' => '版本列表',
    ],
    'systems' => [
        'id' => 'ID',
        'key' => '系统key',
        'value' => '系统value',
        'description' => '描述',
    ],
    'documents' => [
        'id' => 'ID',
        'key' => '文档key',
        'title' => '标题',
        'content' => '内容',
        'created_at' => '创建时间',
        'updated_at' => '更新时间',
    ],
    'users' => [
        'id' => 'ID',
        'name' => '名称',
        'email' => '邮箱',
        'avatar' => '头像',
        'status' => '状态',
        'password' => '密码',
        'role_id' => '所属角色',
        'last_login' => '最后登录时间',
        'created_at' => '创建时间',
        'roles' => ['display_name' => '所属角色'],
    ],
];