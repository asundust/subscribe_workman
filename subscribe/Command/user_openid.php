<?php
if (define(WEIXINAPI)) exit;

$userId = $weObj->getRevFrom();
$text   = "您的OpenID为：\n$userId";
$weObj->text($text)->reply();