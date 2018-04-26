<?php
use \GatewayWorker\Lib\Gateway;
require_once __DIR__ . '/../../../vendor/autoload.php';
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
Gateway::$registerAddress = '127.0.0.1:1237';

$client_id = $_REQUEST['client_id'];
//接收消息
$message = json_encode(array(
    'type'      => 'message',
    'message' => $_REQUEST['content']
));
$group = '9804';
Gateway::sendToGroup($group, $message,$client_id);



