<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

/****************************/
//�������ơ������������
/****************************/
$data["����ͽ��ǡ�������"]["02"] = 1;
$data["FCͽ��ǡ�������"]["02"] = 1;
$data["�����ǲ���"]["58"] = 1;
$data["����ñ������"]["58"] = 1;
$data["DB�Хå����å�"]["58"] = 1;
$data["�ե�����Хå����å�"]["58"] = 1;

/****************************/
//�Хå����å���¸������
/****************************/
define('Backup_DB', 1);
define('Backup_File', 1);
define('Log_File', 1);

/****************************/
//���ߤλ������
/****************************/
$time = date("i", time()); 

/****************************/
//����Ƚ��
/****************************/
if($data["����ñ������"]["$time"] == 1){
	shell_exec("echo test1 >> /home/postgres/cron.log");
}
if($data["�����ǲ���"]["$time"] == 1){
	shell_exec("echo test2 >> /home/postgres/cron.log");
}
if($data["����ͽ��ǡ�������"]["$time"] == 1){
	shell_exec("echo test3 >> /home/postgres/cron.log");
}
if($data["FCͽ��ǡ�������"]["$time"] == 1){
	shell_exec("echo test4 >> /home/postgres/cron.log");
}
if($data["DB�Хå����å�"]["$time"] == 1){
	shell_exec("echo test5 >> /home/postgres/cron.log");
}
if($data["�ե�����Хå����å�"]["$time"] == 1){
	shell_exec("echo test6 >> /home/postgres/cron.log");
}

shell_exec("echo test6 >> /home/postgres/cron.log");

/****************************/
//������̤Υ�����
/****************************/



?>
