<?php

function checkIsAdmin($weObj)
{
    $currentID = $weObj->getRevFrom();
    if (in_array($currentID, explode(',', Config::getConfig('adminids')))) {
        return true;
    } else {
        return false;
    }
}

function checkIsCommand($content)
{
    return strpos($content, '/') === 0 ? true : false;
}

function getResponseText($weObj)
{
    return $weObj->getRevContent();
}

function parseText($weObj)
{
    $content = getResponseText($weObj);
    if (checkIsCommand($content)) {
        parseCommand($content, $weObj);
    } else {
        $weObj->text('你好，请输入 /h 获取命令帮助信息')->reply();
    }
}

function parseShortCommand($content)
{
    $commandArr = Config::$command;
    foreach ($commandArr as $key => $value) {
        if (in_array($content, $value['short'])) {
            return $key;
        }
    }
    return $content;
}

function parseCommand($content, $weObj)
{
    $contentArr = explode(' ', $content);
    //命令的参数
    $prmArr = [];
    for ($i = 1; $i < count($contentArr); $i++) {
        $prmArr[] = $contentArr[$i];
    }
    session_start();
    $_SESSION['prmArr'] = $prmArr;
    // $weObj->text(json_encode($prmArr))->reply();

    $command   = str_replace('/', '', $contentArr[0]);
    $command   = parseShortCommand($command);
    $adminFile = "Command/admin_$command.php";
    $userFile  = "Command/user_$command.php";
    if (file_exists($adminFile) && checkIsAdmin($weObj)) {
        include $adminFile;
    } else if (file_exists($userFile)) {
        include $userFile;
    } else {
        $weObj->text("哎呀，主人还没给我注册这个命令，暂时无法响应你~\n可以输入 /h 获取命令帮助")->reply();
    }
}