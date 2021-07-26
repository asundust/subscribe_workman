<?php
if (define(WEIXINAPI)) exit;
session_start();
$prmArr = isset($_SESSION['prmArr']) ? $_SESSION['prmArr'] : [];

if (!isset($prmArr[0])) {
    $weObj->text('参数不对，请检查')->reply();
    return false;
}
$client = stream_socket_client('tcp://127.0.0.1:5001');
$data = [
    'dir' => $prmArr[0],
];
fwrite($client, json_encode($data) . "\n");
fclose($client);
$weObj->text('已向服务器发送指令，请去方糖公众号查看结果')->reply();