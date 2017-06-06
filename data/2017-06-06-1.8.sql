//用于测试Mysql的高并发的访问和锁机制的实验研究
CREATE TABLE test(
    id int unsigned not null default '0'
)engine = innodb default charset=utf8 comment '测试Mysql的锁机制和PHP文件锁机制';