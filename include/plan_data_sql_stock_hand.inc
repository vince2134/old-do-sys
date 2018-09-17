<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/02/05      �׷�26-1    kajioka-h   �����ɼ�ξ��˿��̤��ѹ��Ǥ���褦���ѹ�
 *                                          �ʽи��ʥơ��֥롢��ʧ����Ͽ������plan_data_sql_stock_hand.inc�˰�ư��
 *  2007/06/20      B0702-063   kajioka-h   ���ѤΥ���饤����Ԥϰ����Ƥʤ��褦�˽���
 */

/****************************/
//�и��ʥơ��֥���Ͽ
/****************************/

//�����ʬ�����꡼��or��󥿥�ξ�硢�и��ʥơ��֥�ˤ���Ͽ���ʤ�
if($divide[$s] != '03' && $divide[$s] != '04'){

	//�����ʡ������ӥ������η���Ƚ��
	if($goods_item_com[$s] != 't' && $goods_item_id[$s] != NULL){
		//�����ƥब���Ϥ���Ƥ������

		//Ʊ�����ʤ�Ƚ�ꡣ
		if($goods_ship_id[$goods_item_id[$s]] == NULL){
			//�����ξ���

			//�и�����Ͽ����
			//����[����ID][0] = ά��
			//����[����ID][1] = ����
			$goods_ship_id[$goods_item_id[$s]][0] = $goods_item_name[$s];
			$goods_ship_id[$goods_item_id[$s]][1] = $goods_item_num[$s];
		}else{
			//Ʊ�����ʤξ��Ͽ��̤�­��

			//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
			$goods_ship_id[$goods_item_id[$s]][1] = $goods_ship_id[$goods_item_id[$s]][1] + $goods_item_num[$s];
		}
	}else{
		//���ʤ������ʤξ�硢�����ʤλҤ�������Ͽ

		for($d=0;$d<count($item_parts[$s]);$d++){
			//Ʊ�����ʤ�Ƚ�ꡣ
			if($goods_ship_id[$item_parts[$s][$d][0]] == NULL){
				//�����ξ���

				//�и�����Ͽ����
				//����[����ID][0] = ά��
				//����[����ID][1] = ����
				$goods_ship_id[$item_parts[$s][$d][0]][0] = $item_parts_cname[$s][$d];
				$goods_ship_id[$item_parts[$s][$d][0]][1] = $item_parts_num[$s][$d];
			}else{
				//Ʊ�����ʤξ��Ͽ��̤�­��

				//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
				$goods_ship_id[$item_parts[$s][$d][0]][1] = $goods_ship_id[$item_parts[$s][$d][0]][1] + $item_parts_num[$s][$d];
			}
		}
	}
//print_array($goods_ship_id);

	//�����ʡ������ӥ������η���Ƚ��
	if($goods_expend_com[$s] != 't' && $goods_expend_id[$s] != NULL){
		//�����ʤ����Ϥ���Ƥ������

		//Ʊ�����ʤ�Ƚ�ꡣ
		if($goods_ship_id[$goods_expend_id[$s]] == NULL){
			//�����ξ���

			//�и�����Ͽ����
			//����[����ID][0] = ά��
			//����[����ID][1] = ����
			$goods_ship_id[$goods_expend_id[$s]][0] = $goods_expend_name[$s];
			$goods_ship_id[$goods_expend_id[$s]][1] = $goods_expend_num[$s];
		}else{
			//Ʊ�����ʤξ��Ͽ��̤�­��

			//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
			$goods_ship_id[$goods_expend_id[$s]][1] = $goods_ship_id[$goods_expend_id[$s]][1] + $goods_expend_num[$s];
		}
	}else{
		//���ʤ������ʤξ�硢�����ʤλҤ�������Ͽ

		for($d=0;$d<count($expend_parts[$s]);$d++){
			//Ʊ�����ʤ�Ƚ�ꡣ
			if($goods_ship_id[$expend_parts[$s][$d][0]] == NULL){
				//�����ξ���

				//�и�����Ͽ����
				//����[����ID][0] = ά��
				//����[����ID][1] = ����
				$goods_ship_id[$expend_parts[$s][$d][0]][0] = $expend_parts_cname[$s][$d];
				$goods_ship_id[$expend_parts[$s][$d][0]][1] = $expend_parts_num[$s][$d];
			}else{
				//Ʊ�����ʤξ��Ͽ��̤�­��

				//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
				$goods_ship_id[$expend_parts[$s][$d][0]][1] = $goods_ship_id[$expend_parts[$s][$d][0]][1] + $expend_parts_num[$s][$d];
			}
		}
	}

	//�����ӥ������η���ʳ��ϡ��Ѱդ�������ǡ�������Ͽ
	if($goods_ship_id != NULL){
		//�и�����ϿSQL
		while($goods_ship_num = each($goods_ship_id)){
			//ź�����ξ���ID����
			$ship = $goods_ship_num[0];

			//�����ѥ����ǡ�������
			$sql  = "SELECT ";
			$sql .= "    t_goods.goods_cd ";
			$sql .= "FROM ";
			$sql .= "    t_goods ";
			$sql .= "WHERE ";
			$sql .= "    t_goods.goods_id = $ship;";
			$result = Db_Query($db_con, $sql);
			$ship_data = Get_Data($result,5);

			$sql  = "INSERT INTO t_aorder_ship( ";
			$sql .= "    aord_d_id,";
			$sql .= "    goods_id,";
			$sql .= "    goods_name,";
			$sql .= "    num, ";
			$sql .= "    goods_cd ";
			$sql .= "    )VALUES(";
			if($contract_div == "1"){
				$sql .= "    $aord_d_id,";                 //�����ǡ���ID
			}else{
				$sql .= "    (SELECT aord_d_id FROM t_aorder_d WHERE aord_id = $aord_id AND line = $s), ";
			}
			$sql .= "    $ship,";                          //����ID
			$sql .= "    '".$goods_ship_id[$ship][0]."',"; //����̾
			$sql .= "    ".$goods_ship_id[$ship][1].",";   //����
			$sql .= "    '".$ship_data[0][0]."'";          //����CD
			$sql .= "    );";		
			$result = Db_Query($db_con, $sql);
			if($result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}


			//--------------------------//
			//��ʧ�ơ��֥����Ͽ�ؿ�
			//--------------------------//
			//���ҽ��ξ��ϥ���å�ID����Ͽ
			if($contract_div == "1"){
				Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship,$goods_ship_id[$ship][1],'reason');
            //����饤����Ԥξ�����Լ�ID����Ͽ����𤵤�Ƥ��ʤ���ΤΤߡ�
            }elseif($contract_div == "2" && $trust_confirm_flg == "f"){
				Stock_hand_Query($db_con,$cshop_id,$client_id,$aord_id,$aord_d_id,$ship,$goods_ship_id[$ship][1],'reason', $act_id);
			}
		}
	}
}
//�и�����Ͽ��������
$goods_ship_id = NULL;

?>