<?php
/*ñ������*/

/******************************
 *  �ѹ�����
 *      ����2006-11-17��ROLLBACK������ˡ����顼���Ƥ���˽��� <suzuki>
 *      ����2007-06-25��ñ�����ѹ������ޥ�����ͽ��ǡ�����ȿ�Ǥ���褦�˽���<watanabe-k>
 *
*******************************/

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //�����Ϣ�δؿ�

//DB����³
$conn = Db_Connect();

//����
$today = date("Y-m-d H:i:s");
error_log("$today ����ñ�����곫�� \n",3,LOG_FILE);

//���顼�ѿ������
$error_con  = NULL;
$error_time = NULL;
$error_msg  = NULL;
$e_contents = NULL;
$error_flg  = NULL;

/**************************/
//��������ǡ��������
/**************************/
$today = date("Y-m-d");

$price_sql .= " SELECT";
$price_sql .= "     t_rprice.price_id,";
$price_sql .= "     t_rprice.rprice,";
$price_sql .= "     t_price.goods_id, ";
$price_sql .= "     t_price.rank_cd, ";
$price_sql .= "     t_price.shop_id ";
$price_sql .= " FROM";
$price_sql .= "     t_rprice";
$price_sql .= "         INNER JOIN ";
$price_sql .= "     t_price ";
$price_sql .= "     ON t_rprice.price_id = t_price.price_id ";
$price_sql .= " WHERE";
$price_sql .= "     t_rprice.rprice_flg = 'f'";
$price_sql .= "     AND";
$price_sql .= "     t_rprice.price_cday <= '$today'";
$price_sql .= ";";

$res = Db_Query($conn, $price_sql);
$price_num = pg_num_rows($res);

/**************************/
//����
/**************************/
if($price_num > 0){
    Db_Query($conn,"BEGIN");

    for($i = 0; $i < $price_num; $i++){
        $price_data[$i] = pg_fetch_array($res, $i, PGSQL_NUM);

        $update_sql  = " UPDATE";
        $update_sql .= "    t_price";
        $update_sql .= " SET";
        $update_sql .= "    r_price = ".$price_data[$i][1]."";
        $update_sql .= " WHERE";
        $update_sql .= "    price_id = ".$price_data[$i][0]."";
        $update_sql .= " ;";
        $update_sql .= " UPDATE";
        $update_sql .= "    t_rprice";
        $update_sql .= " SET";
        $update_sql .= "    rprice_flg = 't'";
        $update_sql .= " WHERE";
        $update_sql .= "    price_id = ".$price_data[$i][0]."";
        $update_sql .= "    AND";
        $update_sql .= "    rprice_flg = 'f'";
        $update_sql .= ";";  
	    $result = Db_Query($conn, $update_sql);

		if($result === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ñ���ơ��֥�ξ���ñ�����꼺�� \nñ��ID: ".$price_data[$i][0]." \n";
				$error_msg[1] = "$error_con \n\n";
			}
		}

        //ñ�����ѹ������ޥ�����ͽ��ǡ�����ȿ��
        //ɸ�����OR�Ķȸ����ξ��
        if($price_data[$i][3] === '4'){

            //GROUPKIND�����
            $sql  = "SELECT";
            $sql .= "   group_kind ";
            $sql .= "FROM ";
            $sql .= "   t_client ";
            $sql .= "       INNER JOIN ";
            $sql .= "   t_rank ";
            $sql .= "   ON t_client.rank_cd = t_rank.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "   t_client.client_id = ".$price_data[$i][4]." ";
            $sql .= ";"; 

            $result = Db_Query($conn, $sql);
            $group_kind = pg_fetch_result($result, 0,0);

            $_SESSION["group_kind"] = $group_kind;          //����  
            $_SESSION["client_id"]  = $price_data[$i][4];   //������ID

//            $result2 = Mst_Sync_Goods($conn,$price_data[$i][2],"price", "sale");
        }elseif($price_data[$i][3] === '2'){

            //GROUPKIND�����
            $sql  = "SELECT";
            $sql .= "   group_kind ";
            $sql .= "FROM ";
            $sql .= "   t_client ";
            $sql .= "       INNER JOIN ";
            $sql .= "   t_rank ";
            $sql .= "   ON t_client.rank_cd = t_rank.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "   t_client.client_id = ".$price_data[$i][4]." ";
            $sql .= ";"; 

            $result = Db_Query($conn, $sql);
            $group_kind = pg_fetch_result($result, 0,0);

            $_SESSION["group_kind"] = $group_kind;          //����  
            $_SESSION["client_id"]  = $price_data[$i][4];   //������ID

//            $result2 = Mst_Sync_Goods($conn,$price_data[$i][2],"price", "buy");
        }

		if($result2 === false){
			//���顼Ƚ��
			if($error_msg == NULL){
				//���˰۾郎ȯ�����Ƥ��ʤ���Х��顼ɽ��
				$error_con = pg_last_error();
				$error_time = date("Y-m-d H:i");
				$error_msg[0] = "$error_time ".__FILE__." \n".__LINE__."���� ����ޥ�����ͽ��ǡ�����ñ�����꼺�� \nñ��ID: ".$price_data[$i][0]." \n";
			}
		}
	}

/*
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }else{
        shell_exec("echo NOTCE $today >> /home/postgres/cron.log");
    }

    Db_Query($conn,"COMMIT");
*/
}

//����Ƚ��
if($error_msg == NULL){
	//����

	Db_Query($conn,"COMMIT");
	$today = date("Y-m-d H:i:s");
	//FILE�˽���
	error_log("$today ����ñ�����괰λ \n\n",3,LOG_FILE);
}else{
	//�۾�
	Db_Query($conn, "ROLLBACK");

	//FILE�˥��顼����
	$estr = NULL;
	for($i=0;$i<count($error_msg);$i++){
		error_log($error_msg[$i],3,LOG_FILE);
		$e_contents .= $error_msg[$i];
	}
	//�᡼��ǥ��顼����
	Error_send_mail($g_error_mail,$g_error_add,"����ñ����������ǰ۾�ȯ��",$e_contents);
}

/*
else{
    shell_exec("echo There is not a record to fall under $today. >> /home/postgres/cron.log ");
}
*/
?>
