<?php
namespace Config;


class Db
{

    // 数据库实例1
    public static $db1 = array(
        'host'    => '114.113.232.8',
        'port'    => 3306,
        'user'    => 'myoomall',
        'password' => 'kouclo_bubugao888',
        'dbname'  => 'recmall',
        'charset'    => 'utf8',
    );

    // 数据库实例2
    public static $db2 = array(
        'host'    => '127.0.0.1',
        'port'    => 3306,
        'user'    => 'mysql_user',
        'password' => 'mysql_password',
        'dbname'  => 'db2',
        'charset'    => 'utf8',
    );
}