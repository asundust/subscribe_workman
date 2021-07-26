<?php
if (define(WEIXINAPI)) exit;
session_start();
$prmArr = isset($_SESSION['prmArr']) ? $_SESSION['prmArr'] : [];
$count = count($prmArr);

switch ($count) {
    case 1:
        $path = '/data/wwwroot/' . $prmArr[0];
        if (!is_dir($path)) {
            $dirResult = shell_exec('cd /data/wwwroot/ && ls -F | grep \'/$\'');
            $weObj->text('项目目录不存在，当前存在的目录为' . "\n" . str_replace('/', '', $dirResult))->reply();
        }
        $result = shell_exec('cd ' . $path . '/ && /usr/bin/git pull 2>&1');
        $weObj->text($result)->reply();
        break;
    case 2:
        if ($prmArr[1] != 'root') {
            $weObj->text('参数不对，请检查')->reply();
        }
        $client = stream_socket_client('tcp://127.0.0.1:5002');
        $data = [
            'dir' => $prmArr[0],
        ];
        fwrite($client, json_encode($data) . "\n");
        fclose($client);
        $weObj->text('已向服务器发送指令，请去方糖公众号查看结果')->reply();
        break;

    default:
        $weObj->text('参数不对，请检查')->reply();
        break;
}