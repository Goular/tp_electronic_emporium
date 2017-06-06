<?php
error_reporting(0);
mysql_connect("localhost", 'root', '123456');
mysql_select_db('php39');
//只有一个客户端可以锁定表，其他客户端会被阻塞
$rs = mysql_query('select id from test;');
$id = mysql_result($rs, 0, 0);
if ($id > 0) {
    $id--;
    mysql_query("update test set id=" . $id);
}

