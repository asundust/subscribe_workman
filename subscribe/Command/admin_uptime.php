<?php
$result = shell_exec('uptime');
$weObj->text($result)->reply();