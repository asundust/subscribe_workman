<?php
if (define(WEIXINAPI)) exit;
//这是备份网站数据命令文件，由于微信服务器需要在5秒内收到正确响应，所以像这种耗时命令，需要使用异步方式。
//实现异步的方式有很多种，比如：
// 1）redis的发布与订阅机制
// 2）PHP Socket框架，Workerman、Swoole，定义一个监听localhost的tcp请求，当收到消息时去做指定的操作，而这个命令文件，只需要使用stream_socket_client连接tcp端口发送数据

//更多用法靠你自己去发掘啦~