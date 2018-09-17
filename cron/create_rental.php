<?php

/******************************
 *  �ѹ�����
 *      ����2006-11-17��ROLLBACK������ˡ����顼���Ƥ���˽��� <suzuki>
 *
*******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/15      10-010      suzuki      ���ʡ�ñ����Ʊ���Ԥϰ�Ĥ�Ż���褦�˽���
 *  2006/11/15      10-020      suzuki      ���ե饤��ȯ��Ȥ�����ɼ�򵯤���
 *  2006/11/16      10-025      suzuki      ��󥿥����򵯤����ݤˡ��֥�󥿥����פȤ������ʤ���Ѥ�����ɼ�򵯤���
*/

//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

//����������
$today_y = date("Y");  
$today_m = date("m");  
$today_d = date("d");    

//����
$today = date("Y-m-d H:i:s");
error_log("$today ��󥿥�ǡ����β��󡦥�󥿥����μ�ȯ�� ���� \n",3,LOG_FILE);

//���顼�ѿ������
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/****************************/
//�ãңϣδؿ����
/****************************/
require_once(INCLUDE_DIR."function_rental.inc");
//require_once(INCLUDE_DIR."function_cron.inc");

//echo date("Y-m-d H:i");
/****************************/
//����󥿥�ID����
/****************************/
$sql  = "SELECT ";
$sql .= "    rental_id ";
$sql .= "FROM ";
$sql .= "    t_rental_h ";
$sql .= "ORDER BY ";
$sql .= "    rental_id;";
$rental_result = Db_Query($db_con, $sql); 
while($rental_list = pg_fetch_array($rental_result)){

	Db_Query($db_con, "BEGIN;");
	$error_msg = NULL;   //���顼����

	/****************************/
	//����¹Խ���     
	/****************************/
	$result = Rental_sql($db_con,$rental_list[0],3);
	if($result === false){

		$error_con = pg_last_error();
		$error_time = date("Y-m-d H:i");
		$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ��󥿥�ǡ����β���¹Խ������� \n��󥿥�ID: ".$rental_list[0]." \n";
		$error_msg[1] = "$error_con \n\n";
	}

	//����˽�������λ
	if($error_msg == NULL){
		Db_Query($db_con, "COMMIT;");

    //�����˰۾郎���ä����
	}else{
		Db_Query($db_con, "ROLLBACK");
		//FILE�˥��顼����
		for($i=0;$i<count($error_msg);$i++){
			error_log($error_msg[$i],3,LOG_FILE);
			$e_contents .= $error_msg[$i];
		}

		$error_flg = true;  //�۾�ȯ���ե饰
	}
}

//����
if($error_flg == false){

	$today = date("Y-m-d H:i:s");
	//FILE�˽���
	error_log("$today ��󥿥�ǡ����β���λ \n\n",3,LOG_FILE);

//�۾�
}else{

	//�᡼��ǥ��顼����
	Error_send_mail($g_error_mail,$g_error_add,"��󥿥�����ǰ۾�ȯ��",$e_contents);
}

?>
