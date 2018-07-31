<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

/****************************/
//���󤫤鵯����������ǡ����������
/****************************/
//�����ʹߤμ���إå���
$today = "2006-07-01";

//���󤫤鵯����������ID����
$sql  = "SELECT ";
$sql .= "    t_aorder_h.aord_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_h.ord_time >= '$today' ";
$sql .= "AND "; 
$sql .= "    (t_aorder_h.confirm_flg = 't' OR t_aorder_h.trust_confirm_flg = 't')";
$sql .= "AND ";
$sql .= "    t_aorder_d.contract_id IS NOT NULL;";
$result = Db_Query($db_con, $sql);
$aord_list = Get_Data($result);

Db_Query($db_con, "BEGIN");
for($a=0;$a<count($aord_list);$a++){

	//�оݴ��֤����إå�����
	$sql  = "DELETE FROM ";
	$sql .= "    t_sale_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id = ".$aord_list[$a][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}

	//�оݴ��֤μ���إå�����
	$sql  = "DELETE FROM ";
	$sql .= "    t_aorder_h ";
	$sql .= "WHERE ";
	$sql .= "    aord_id = ".$aord_list[$a][0].";";
	$result = Db_Query($db_con, $sql);
	if($result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}
Db_Query($db_con, "COMMIT");
print "���󤫤鵯���������ǡ������<br><br>";

/*
��ɼ�ֹ�ơ��֥���
DELETE FROM t_aorder_no_serial;
DELETE FROM t_aorder_no_serial_fc;
DELETE FROM t_payin_no_serial;
INSERT INTO t_aorder_no_serial (SELECT MAX(sale_no) FROM t_sale_h WHERE shop_id = 93);
INSERT INTO t_payin_no_serial (SELECT MAX(pay_no) FROM t_payin_h WHERE shop_id = 93);
*/

?>
