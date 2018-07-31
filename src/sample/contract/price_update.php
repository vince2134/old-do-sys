<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

Db_Query($db_con, "BEGIN;");

//����ñ����NULL�μ���ǡ�������
$sql  = "SELECT ";
$sql .= "    t_aorder_d.aord_d_id, ";
$sql .= "    t_aorder_d.goods_id, ";
$sql .= "    t_aorder_h.shop_id, ";
$sql .= "    t_aorder_d.num, ";
$sql .= "    t_aorder_h.client_id ";
$sql .= "FROM ";
$sql .= "    t_aorder_h ";
$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "WHERE ";
$sql .= "    t_aorder_d.buy_price IS NULL;";
$aord_result = Db_Query($db_con,$sql);

while($aord_list = pg_fetch_array($aord_result)){
	$aord_d_id  = $aord_list[0];
	$goods_id   = $aord_list[1];
	$shop_id    = $aord_list[2];
	$num        = $aord_list[3];  
	$client_id  = $aord_list[4];    

	/****************************/
	//�����襳�������Ͻ���
	/****************************/
	$sql  = "SELECT";
	$sql .= "   t_client.coax ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   t_client.client_id = $client_id";
	$sql .= ";";
	$result = Db_Query($db_con, $sql); 
	$data_list = Get_Data($result,3);
	$coax            = $data_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�


	$sql  = "SELECT ";
	$sql .= "    t_goods.goods_cd, ";
	$sql .= "    t_goods.compose_flg, ";
	$sql .= "    t_goods.public_flg  ";
	$sql .= "FROM ";
	$sql .= "    t_goods ";
	$sql .= "WHERE ";
	$sql .= "    t_goods.goods_id = $goods_id;";
	$result = Db_Query($db_con, $sql);
	$item_data = Get_Data($result,3);

	//������Ƚ��
	if($item_data[0][1] == 't'){
		//�����ʿƤκ߸�ñ������
		$price_array = NULL;
		$price_array = Compose_price($db_con,$shop_id,$goods_id);
		$buy_price = $price_array[2];
	}else{
		//�ܵҶ�ʬCD����
		$sql  = "SELECT ";
		$sql .= "    t_rank.group_kind, ";  //���롼�׼���
		$sql .= "    t_rank.rank_cd ";      //�ܵҶ�ʬCD
		$sql .= "FROM ";
		$sql .= "    t_client ";
		$sql .= "    INNER JOIN t_rank ON t_client.rank_cd = t_rank.rank_cd ";
		$sql .= "WHERE ";
		$sql .= "    t_client.client_id = $shop_id;";
		$r_result = Db_Query($db_con,$sql);
		$group_kind = pg_fetch_result($r_result,0,0);
		$rank_code  = pg_fetch_result($r_result,0,1);

		//�����ƥ�κ߸�ñ������
		$sql  = "SELECT ";
		$sql .= "   t_price.r_price ";
		$sql .= " FROM";
    	$sql .= "   t_goods INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id ";
		$sql .= " WHERE ";
		$sql .= "    t_goods.goods_id = $goods_id";
		$sql .= " AND";
    	$sql .= "    t_goods.accept_flg = '1' ";
		$sql .= " AND";
	    //ľ��Ƚ��
		if($group_kind == '2'){
			//ľ��
		    $sql .= "    t_price.shop_id IN (SELECT client_id FROM t_client WHERE t_client.rank_cd = '$rank_code') \n";
		}else{
			//FC
			$sql .= "    t_price.shop_id = $shop_id  \n";
		}
		$sql .= " AND ";
		//����Ƚ��
		if($item_data[0][2] == 't'){
			//��������
			$sql .= "    t_goods.public_flg = 't' ";
		}else{
			//���Ҿ���
			$sql .= "    t_goods.public_flg = 'f' ";
		}
		$sql .= " AND";
	    $sql .= "    t_price.rank_cd = '3';";
		$result = Db_Query($db_con, $sql);
		$buy_data = Get_Data($result,3);
		$buy_price = $buy_data[0][0];
	}

	$buy_amount = bcmul($buy_price,$num,2);
	$buy_amount = Coax_Col($coax, $buy_amount);    

	$sql  = "UPDATE t_aorder_d SET ";
	$sql .= "    buy_price = $buy_price,";
	$sql .= "    buy_amount = $buy_amount ";
	$sql .= " WHERE ";
	$sql .= "    aord_d_id = $aord_d_id;";
	$up_result = Db_Query($db_con, $sql);
	if($up_result === false){
	    Db_Query($db_con, "ROLLBACK");
	    exit;
	}
}

Db_Query($db_con, "COMMIT;");
print "������λ";

?>
