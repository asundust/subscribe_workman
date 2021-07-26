<?php
if (define(WEIXINAPI)) exit;
function shortCommand($arr)
{
    $text = '';
    foreach ($arr as $v) {
        $text .= "/$v,";
    }
    return substr($text, 0, strlen($text) - 1);
}

$commandArr = Config::$command;
$userText = "下面是主人给我注册的普通用户命令：\n";
$adminText = "\n下面是主人给我注册的管理员命令：\n";
foreach ($commandArr as $key => $value) {
    switch ($value['isadmin']) {
        case 0:
            $userText .= ('/' . $key . ' [' . shortCommand($value['short']) . ']：' . $value['desc'] . "\n");
            break;
        case 1:
            $adminText .= ('/' . $key . ' [' . shortCommand($value['short']) . ']：' . $value['desc'] . "\n");
            break;
    }
}
if (checkIsAdmin($weObj)) {
    $text = $userText . $adminText;
} else {
    $text = $userText;
}
$weObj->text($text)->reply();