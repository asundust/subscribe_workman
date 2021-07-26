<?php
function sc_send($text, $desc = '', $key = 'SCU14750Tbb954b0c8e9d756972b1d87513dbb49759f47e62b42eb')
{
    $postData = http_build_query(
        [
            'text' => $text,
            'desp' => $desc
        ]
    );
    
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postData
        ],
        // 解决SSL证书验证失败的问题
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];
    $context = stream_context_create($opts);
    return file_get_contents('https://sc.ftqq.com/' . $key . '.send', false, $context);
}