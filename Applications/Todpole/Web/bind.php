<?php
// GatewayClient 3.0.0版本开始要使用命名空间
use \GatewayWorker\Lib\Gateway;

require_once __DIR__ . '/../../../vendor/autoload.php';
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
Gateway::$registerAddress = '127.0.0.1:8282';


$client_id = $_REQUEST['client_id'];
// 加入某个群组（可调用多次加入多个群组）
//Gateway::joinGroup($client_id, $group_id);
Gateway::joinGroup($client_id, '9804',$client_id);