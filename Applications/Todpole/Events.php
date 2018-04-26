<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 主逻辑
 * 主要是处理 onMessage onClose 三个方法
 */

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;
class Events
{
    /**
     * 当客户端连上时触发
     * @param int $client_id
     */
    public static function onConnect($client_id)
    {
        $client_id = isset($client_id) ? $client_id: time();
        /*$_SESSION['id'] = 2098;
        Gateway::sendToCurrentClient('{"type":"welcome","id":'.$_SESSION['id'].'}');*/
        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id
        )));
    }
    
   /**
    * 有消息时
    * @param int $client_id
    * @param string $message
    */
   public static function onMessage($client_id, $message)
   {
        // 获取客户端请求
        $message_data = json_decode($message, true);
        if(!$message_data)
        {
            return;
        }
        switch($message_data['type'])
        {

            case 'login':
                $passwd = $message_data['pass'];
                $name = $message_data['name'];
                // 获取用户列表（这里是临时的一个测试数据库）
                //$ret = Db::instance('db1')->column("SELECT * FROM `user` WHERE `user_name` ={$name} AND `birthday`={$passwd}");
                $ret = Db::instance('db1')->select('*')->from('user')->where("user_name= '{$name}'")->column();
                if($ret[0]){
                    echo $ret[0];
                }else{
                    Gateway::sendToClient($client_id, json_encode(array(
                        'type'      => 'userNotExists',
                        'message' => '该用户不存在！'
                    )));
                }
                break;
            // 更新用户
            case 'update':
                // 转播给所有用户
                Gateway::sendToAll(json_encode(
                    array(
                        'type'     => 'update',
                        'id'       => $_SESSION['id'],
                        'angle'    => $message_data["angle"]+0,
                        'momentum' => $message_data["momentum"]+0,
                        'x'        => $message_data["x"]+0,
                        'y'        => $message_data["y"]+0,
                        'life'     => 1,
                        'name'     => isset($message_data['name']) ? $message_data['name'] : 'Guest.'.$_SESSION['id'],
                        'authorized'  => false,
                        )
                    ));
                return;
            // 聊天
            case 'message':
                // 向大家说
                $new_message = array(
                    'type'=>'message', 
                    'id'  =>$_SESSION['id'],
                    'message'=>$message_data['message'],
                );
                return Gateway::sendToAll(json_encode($new_message));
        }
   }
   
   /**
    * 当用户断开连接时
    * @param integer $client_id 用户id
    */
   public static function onClose($client_id)
   {
       // 广播 xxx 退出了
       GateWay::sendToAll(json_encode(array('type'=>'closed', 'id'=>$client_id)));
   }
    /**
     * 功能函数从数据库获取用户并进行绑定操作
     */
    public function bindUser($pwd,$name){
        $db = new DbConnection('114.113.232.8', '3306', 'myoomall', 'kouclo_bubugao888', 'recmall','utf8');
        echo "<pre>";
        print_r($db);die;
    }
}
