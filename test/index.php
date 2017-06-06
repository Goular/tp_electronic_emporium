<?php
error_reporting(0);
mysql_connect("localhost", 'root', '123456');
mysql_select_db('php39');
//只有一个客户端可以锁定表，其他客户端会被阻塞

//mysql_query("LOCK TABLE test WRITE;"); //不允许其他客户端进行读取写入操作,其他线程写入或者读取会阻塞
//mysql_query("LOCK TABLE test READ");//允许其他客户端进行读取操作,其他线程写入会阻塞

$fp = fopen('./a.lock', "r");
flock($fp, LOCK_EX);//设置为写锁

$rs = mysql_query('select id from test;');//
$id = mysql_result($rs, 0, 0);
if ($id > 0) {
    $id--;
    mysql_query("update test set id=" . $id);
}
//mysql_query("UNLOCK TABLES;");

flock($fp, LOCK_UN);
fclose($fp);

//使用php自带的锁能够更好的解决高并发的问题，但是mysql的锁具有通用性

//总结：项目中应该只使用PHP中的文件锁，尽量避免锁表，因为如果表被锁定了，那么整个网站中所有和这个表相关的功能都被拖慢了。
//
//应用场景：
//1.高并发下单时，减库存量时要加锁
//2.高并发抢单、抢票时要使用
//
//如何模拟高并发访问一个脚本：可以使用APACHE中的ab.exe软件：