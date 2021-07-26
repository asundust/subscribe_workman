<?php

use Workerman\Worker;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . './../common/functions.php';
$isBusy = 0;

// 创建一个文本协议的Worker监听2347接口
$text_worker = new Worker("tcp://0.0.0.0:5002");

// 只启动1个进程，这样方便客户端之间传输数据
$text_worker->count = 1;

// // 当客户端链接进来的时候
// $text_worker->onConnect = function ($connection) use (&$isBusy) {
//     // 向客户端发送消息
//     $connection->send('Connect success');
// };

// 当客户端发送消息进来的时候
// 由于限制直接使用方糖推送结果
$text_worker->onMessage = function ($connection, $data) use (&$isBusy) {
    $time = date('His');
    if ($isBusy == 1) {
        sc_send('(' . $time . ')System is busy, please wait later...');
        $isBusy = 0;
        $connection->close();
        return false;
    }

    $isBusy = 1;
    $data = json_decode($data, true);
    if (!isset($data['dir']) || strlen($data['dir']) == 0) {
        sc_send('参数不正确(' . $time . ')：Data is empty...');
        $isBusy = 0;
        $connection->close();
        return false;
    }

    $path = '/root/app/' . $data['dir'];
    if (!is_dir($path)) {
        $dirResult = shell_exec('cd /root/app/ && ls -F | grep \'/$\'');
        sc_send('项目目录不存在，当前存在的目录为(' . $time . ')：', str_replace('/', "\n\n", $dirResult));
        $isBusy = 0;
        $connection->close();
        return false;
    }
    $result = shell_exec('cd ' . $path . '/ && /usr/bin/git pull 2>&1');
    $isBusy = 0;

    sc_send('您发送给服务器的指令执行结果为(' . $time . ')：', str_replace("\n", "\n\n", $result)
        . ($data['dir'] == 'workerman_server' && strpos($result, 'Already up-to-date.') === false ? ("\n\n" . '**请到服务器执行**' . "\n\n" . '**php start.php stop**' . "\n\n" . '**php start.php start -d**') : ''));
    // 向客户端发送消息
    $connection->close();
    return false;
};

// 当系统出错的时候
$text_worker->onError = function ($connection) {
    // 由于限制直接使用方糖推送结果
    sc_send('5002项目代码更新服务出错');
    return false;
};

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}