<?php

use Dotenv\Dotenv;

class Config
{
    public static $token = 'TOKEN';
    public static $encodingaeskey = 'ENCODINGAESKEY';
    public static $adminids = 'ADMINIDS';
    public static $command = [
        // 'backup'   => [
        //     'isadmin' => 1,
        //     'desc'    => '备份博客网站和数据库',
        //     'short'   => ['bk']
        // ],
        'gitpull' => [
            'isadmin' => 1,
            'desc'    => '项目更新 参数1：项目文件夹名【必须】 参数2：特殊口令，执行高权操作【非必须】',
            'short'   => ['gp']
        ],
        'query'  => [
            'isadmin' => 1,
            'desc'    => '队列服务重启',
            'short'   => ['q']
        ],
        'uptime'  => [
            'isadmin' => 1,
            'desc'    => '查看服务器负载',
            'short'   => ['u']
        ],
        'help'    => [
            'isadmin' => 0,
            'desc'    => '获取命令帮助信息',
            'short'   => ['h']
        ],
        'openid'  => [
            'isadmin' => 0,
            'desc'    => '获取您在这里的唯一编号(Openid)',
            'short'   => ['id']
        ],
        // 'seccode'  => [
        //     'isadmin' => 0,
        //     'desc'    => '获取Wordpress博客后台登录验证码',
        //     'short'   => ['code']
        // ],
    ];

    public static function getConfig($configName)
    {
        $dotEnv = new Dotenv(__DIR__);
        $dotEnv->load();
        return getenv(self::$$configName);
    }
}