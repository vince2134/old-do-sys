<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

//������ޥ�����̾���˹���
$sql  = "SELECT ";
$sql .= "    client_id, ";
$sql .= "    client_name,";
$sql .= "    client_name2,";
$sql .= "    client_cname ";
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "( ";
$sql .= "    client_name LIKE '%�ޥ��ɥʥ��%' ";
$sql .= "    OR ";
$sql .= "    client_name2 LIKE '%�ޥ��ɥʥ��%' ";
$sql .= "    OR ";
$sql .= "    client_cname LIKE '%�ޥ��ɥʥ��%' ";
$sql .= ");";

$mc_result = Db_Query($db_con,$sql);
while($mc_list = pg_fetch_array($mc_result)){
	$sql  = "UPDATE t_aorder_h SET ";
	$sql .= "    client_name = '".$mc_list[1]."',";
	$sql .= "    client_name2 = '".$mc_list[2]."',";
	$sql .= "    client_cname = '".$mc_list[3]."' ";
	$sql .= " WHERE ";
	$sql .= "    client_id = ".$mc_list[0].";";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

Db_Query($db_con, "COMMIT;");
print "MC������λ";

?>
