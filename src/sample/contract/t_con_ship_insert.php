<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB��³
$db_con = Db_Connect();

Db_Query($db_con, "BEGIN;");

//������ơ��֥���
$sql  = "DELETE FROM t_con_ship;";
$result = Db_Query($db_con, $sql);
if($result === false){
    Db_Query($db_con, "ROLLBACK");
    exit;
}

/****************************/
//�и��ʥơ��֥���Ͽ
/****************************/
//��������ID����SQL
$sql  = "SELECT ";
$sql .= "    t_con_info.con_info_id, ";    //��������ID
$sql .= "    t_con_info.divide,";          //�����ʬ
$sql .= "    t_con_info.goods_id,";        //����ID
$sql .= "    t_com.compose_flg,";          //�����ʥե饰
$sql .= "    t_con_info.goods_name,";      //����̾
$sql .= "    t_con_info.num,";             //����
$sql .= "    t_con_info.egoods_id,";       //������ID
$sql .= "    t_com2.compose_flg,";         //�����ʥե饰
$sql .= "    t_con_info.egoods_name,";     //������̾
$sql .= "    t_con_info.egoods_num ";      //����
$sql .= "FROM ";
$sql .= "    t_con_info ";
$sql .= "    LEFT JOIN t_goods AS t_com ON t_com.goods_id = t_con_info.goods_id ";
$sql .= "    LEFT JOIN t_goods AS t_com2 ON t_com2.goods_id = t_con_info.egoods_id ";
$sql .= "WHERE ";
$sql .= "    (t_con_info.goods_id IS NOT NULL OR t_con_info.egoods_id IS NOT NULL);";
$ship_result = Db_Query($db_con, $sql);
while($ship_list = pg_fetch_array($ship_result)){
	
	$con_info_id   = $ship_list[0];      //��������ID
	$divide        = $ship_list[1];      //�����ʬ
	$goods_id      = $ship_list[2];      //����ID
	$compose_flg   = $ship_list[3];      //�����ʥե饰
	$goods_name    = $ship_list[4];      //����̾
	$num           = $ship_list[5];      //����
	$egoods_id     = $ship_list[6];      //������ID
	$compose_flg2  = $ship_list[7];      //�����ʥե饰
    $egoods_name   = $ship_list[8];      //������̾
    $egoods_num    = $ship_list[9];      //����

	$goods_ship_id = NULL;               //�и�����Ͽ����
	$divide_flg    = false;              //�и��ʥơ��֥���ϿȽ��ե饰

	//�����ʬ�����꡼��or��󥿥�ξ�硢�и��ʥơ��֥�ˤ���Ͽ���ʤ�
	if($divide == '03' || $divide == '04'){
		$divide_flg = true;
	}

	//�����ʬ�����꡼��or��󥿥�ξ�硢�и��ʥơ��֥�ˤ���Ͽ���ʤ�
	if($divide_flg == false){

		//�����ƥ�ID¸��Ƚ��
		if($goods_id != NULL){
			//������Ƚ��
			if($compose_flg != 't'){
				//�����ƥब���Ϥ���Ƥ������
		
				//Ʊ�����ʤ�Ƚ�ꡣ
				if($goods_ship_id[$goods_id] == NULL){
					//�����ξ���

					//�и�����Ͽ����
					//����[����ID][0] = ά��
					//����[����ID][1] = ����
					$goods_ship_id[$goods_id][0] = $goods_name;
					$goods_ship_id[$goods_id][1] = $num;
				}else{
					//Ʊ�����ʤξ��Ͽ��̤�­��

					//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
					$goods_ship_id[$goods_id][1] = $goods_ship_id[$goods_id][1] + $num;
				}
			}else{
				//���ʤ������ʤξ�硢�����ʤλҤ�������Ͽ

				//�ƹ����ʤξ��ʾ������
				$sql  = "SELECT ";
				$sql .= "    parts_goods_id ";                       //������ID
				$sql .= "FROM ";
				$sql .= "    t_compose ";
				$sql .= "WHERE ";
				$sql .= "    goods_id = $goods_id;";
				$result = Db_Query($db_con, $sql);
				$item_parts = Get_Data($result);

				//�ƹ����ʤο��̼���
				for($i=0;$i<count($item_parts);$i++){
					$sql  = "SELECT ";
					$sql .= "    t_goods.goods_name,";
					$sql .= "    t_goods.goods_cname,";
					$sql .= "    t_compose.count ";
					$sql .= "FROM ";
					$sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
					$sql .= "WHERE ";
					$sql .= "    t_compose.goods_id = $goods_id ";
					$sql .= " AND ";
					$sql .= "    t_compose.parts_goods_id = ".$item_parts[$i][0].";";
					$result = Db_Query($db_con, $sql);
					$item_parts_name[$i] = pg_fetch_result($result,0,0);    //����̾
					$item_parts_cname[$i] = pg_fetch_result($result,0,1);   //ά��
					$parts_num = pg_fetch_result($result,0,2);              //�����ʤ��Ф������
					$item_parts_num[$i] = $parts_num * $num;                //����
				}

				for($d=0;$d<count($item_parts);$d++){
					//Ʊ�����ʤ�Ƚ�ꡣ
					if($goods_ship_id[$item_parts[$d][0]] == NULL){
						//�����ξ���

						//�и�����Ͽ����
						//����[����ID][0] = ά��
						//����[����ID][1] = ����
						$goods_ship_id[$item_parts[$d][0]][0] = $item_parts_cname[$d];
						$goods_ship_id[$item_parts[$d][0]][1] = $item_parts_num[$d];
					}else{
						//Ʊ�����ʤξ��Ͽ��̤�­��

						//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
						$goods_ship_id[$item_parts[$d][0]][1] = $goods_ship_id[$item_parts[$d][0]][1] + $item_parts_num[$d];
					}
				}
			}
		}

		//������ID¸��Ƚ��
		if($egoods_id != NULL){
			//������Ƚ��
			if($compose_flg2 != 't'){
				//�����ʤ����Ϥ���Ƥ������
		
				//Ʊ�����ʤ�Ƚ�ꡣ
				if($goods_ship_id[$egoods_id] == NULL){
					//�����ξ���

					//�и�����Ͽ����
					//����[����ID][0] = ά��
					//����[����ID][1] = ����
					$goods_ship_id[$egoods_id][0] = $egoods_name;
					$goods_ship_id[$egoods_id][1] = $egoods_num;
				}else{
					//Ʊ�����ʤξ��Ͽ��̤�­��

					//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
					$goods_ship_id[$egoods_id][1] = $goods_ship_id[$egoods_id][1] + $expend_num;
				}
			}else{
				//���ʤ������ʤξ�硢�����ʤλҤ�������Ͽ

				//�ƹ����ʤξ��ʾ������
				$sql  = "SELECT ";
				$sql .= "    parts_goods_id ";                 //������ID
				$sql .= "FROM ";
				$sql .= "    t_compose ";
				$sql .= "WHERE ";
				$sql .= "    goods_id = $egoods_id;";
				$result = Db_Query($db_con, $sql);
				$expend_parts = Get_Data($result);

				//�ƹ����ʤο��̼���
				for($i=0;$i<count($expend_parts);$i++){
					$sql  = "SELECT ";
					$sql .= "    t_goods.goods_name,";
					$sql .= "    t_goods.goods_cname,";
					$sql .= "    t_compose.count ";
					$sql .= "FROM ";
					$sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
					$sql .= "WHERE ";
					$sql .= "    t_compose.goods_id = $egoods_id";
					$sql .= " AND ";
					$sql .= "    t_compose.parts_goods_id = ".$expend_parts[$i][0].";";
					$result = Db_Query($db_con, $sql);

					$expend_parts_name[$i] = pg_fetch_result($result,0,0);      //����̾
					$expend_parts_cname[$i] = pg_fetch_result($result,0,1);     //ά��
					$parts_num = pg_fetch_result($result,0,2);                  //�����ʤ��Ф������
					$expend_parts_num[$i] = $parts_num * $egoods_num;           //����
				}

				for($d=0;$d<count($expend_parts);$d++){
					//Ʊ�����ʤ�Ƚ�ꡣ
					if($goods_ship_id[$expend_parts[$d][0]] == NULL){
						//�����ξ���

						//�и�����Ͽ����
						//����[����ID][0] = ά��
						//����[����ID][1] = ����
						$goods_ship_id[$expend_parts[$d][0]][0] = $expend_parts_cname[$d];
						$goods_ship_id[$expend_parts[$d][0]][1] = $expend_parts_num[$d];
					}else{
						//Ʊ�����ʤξ��Ͽ��̤�­��

						//�и�����Ͽ����(����[����ID] = ���ߤο��� + ����)
						$goods_ship_id[$expend_parts[$d][0]][1] = $goods_ship_id[$expend_parts[$d][0]][1] + $expend_parts_num[$d];
					}
				}
			}
		}

		//�и�����ϿSQL
		while($goods_ship_num = each($goods_ship_id)){
			//ź�����ξ���ID����
			$ship = $goods_ship_num[0];
		
			$sql  = "INSERT INTO t_con_ship( ";
			$sql .= "    con_info_id,";
			$sql .= "    goods_id,";
			$sql .= "    goods_name,";
			$sql .= "    num ";
			$sql .= "    )VALUES(";
			$sql .= "    $con_info_id,";                   //��������ID
			$sql .= "    $ship,";                          //����ID
			$sql .= "    '".$goods_ship_id[$ship][0]."',"; //����̾
			$sql .= "    ".$goods_ship_id[$ship][1];       //����
			$sql .= "    );";

			$in_result = Db_Query($db_con, $sql);
			if($in_result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}

		}
	}
}

Db_Query($db_con, "COMMIT;");
print "�и��ʥơ��֥������λ"
?>
