<?php

ini_set('html_errors', 1);

// mysql
$mysql = new \Mysqli('mysql', 'root', 'root');
$result = $mysql->query("SELECT NOW()")->fetch_assoc();
var_dump($result['NOW()']);

// memcached
$memcached = new \Memcached();
$memcached->addServer('memcached', 11211);
$memcached->set('test', time());
var_dump($memcached->get('test'));

// redis
$redis = new \Redis();
$redis->connect('redis', 6379);
$redis->set('test', time());
var_dump($redis->get('test'));

