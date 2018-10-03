<?php

ini_set('html_errors', 1);


// mysql
$mysql = new \Mysqli('mysql', 'root', 'root');
$result = $mysql->query("SELECT NOW()")->fetch_assoc();
var_dump($result);


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


// curl
$ch = curl_init('https://www.google.com');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$result = curl_exec($ch);
var_dump($result); exit;