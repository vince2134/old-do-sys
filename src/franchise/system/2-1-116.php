<?php
/****************************
 * �ѹ�����
 *  ����(2006-07-27)���ʥޥ����ι����ѹ���ȼ������о����ѹ���watanabe-k��
 *  ����(2006-09-11) �����ɼ�������ˤ������褦���ѹ���kaji��
 *  ����(2006-10-27) �������̤����ܥ��󲡲������ѹ���suzuki��
 *   (2006/11/16) (suzuki)
 *     �������ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��ä���ɽ�����ʤ��褦�˽���
 *    �� (2006/12/01) �����ɼ�αĶȸ����ϰ�����δݤ�����(suzuki)
 *
 *
*****************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-14      0060        suzuki      �����ɼ��Ͽ���ˡ������αĶȸ����׻������ɲ�
*/

//$page_title = "����ޥ���";
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB����³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//�����ѿ�����
/****************************/
$client_id   = $_GET["client_id"];      //������
$flg         = $_GET["flg"];            //�ɲá�����Ƚ�̥ե饰
$get_con_id  = $_GET["contract_id"];    //�������ID
$row         = $_GET["break_row"];      //������Ͽ�ι��ֹ�
$client_h_id = $_SESSION["client_id"];  //������桼��ID
$rank_cd     = $_SESSION["fc_rank_cd"]; //�ܵҶ�ʬ������
$staff_id    = $_SESSION["staff_id"];   //�������ID
$group_kind  = $_SESSION["group_kind"]; //���롼�׼���

//������ID��hidden�ˤ���ݻ�����
if($_GET["client_id"] != NULL){
	$con_data2["hdn_client_id"] = $client_id;
	
}else{
	$client_id = $_POST["hdn_client_id"];
}

//�ɲá�����Ƚ�̥ե饰��hidden�ˤ���ݻ�����
if($_GET["flg"] != NULL){
	$con_data2["hdn_flg"] = $flg;
}else{
	$flg = $_POST["hdn_flg"];
}

//�������ID��hidden�ˤ���ݻ�����
if($_GET["contract_id"] != NULL){
	$con_data2["hdn_con_id"] = $get_con_id;
}else{
	$get_con_id = $_POST["hdn_con_id"];
}

//������Ͽ�ι��ֹ��hidden�ˤ���ݻ�����
if($_GET["break_row"] != NULL){
	$con_data2["hdn_row"] = $row;
}else{
	$row = $_POST["hdn_row"];
}

//����Ƚ��
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);

/****************************/
//��������ɽ������
/****************************/
$get_con_id2  = $_GET["select_id"];     //���פ����Ϥ���ID1
$get_info_id  = $_GET["select_id2"];    //���פ����Ϥ���ID2
$get_id3      = $_GET["select_id3"];    //���פ����Ϥ���ID3

if($get_id3 == "sale"){
    $page_title = "ͽ��ǡ�������";
}elseif($get_id3 == "sale_h"){
    $page_title = "�����ɼ";
}else{
    $page_title = "����ޥ���";
}

//���ܸ�Ƚ��
if($get_info_id != NULL){
	//�����פ����������ɽ��

	//�ǣţԾ�������Ƚ��
	Get_ID_Check2($get_con_id2);
	Get_ID_Check2($get_info_id);

	//���󡦼���Ƚ��
	if($get_id3 == "sale" || $get_id3 == "sale_h"){

		/****************************/
		//����ǡ����ơ��֥�
		/****************************/
		if($get_id3 == "sale"){
			//FC¦�������ɼɽ��Ƚ��
			$sql  = "SELECT ";
			$sql .= "    act_id ";
			$sql .= "FROM ";
			$sql .= "    t_aorder_h ";
			$sql .= "WHERE ";
			$sql .= "    aord_id = $get_info_id;";
			$result = Db_Query($db_con, $sql);
			$check_data = Get_Data($result);

			$sql  = "SELECT ";
			$sql .= "    t_aorder_d.line,";           //�Կ�
			$sql .= "    t_aorder_d.serv_id,";        //�����ӥ�ID
			$sql .= "    t_goods.goods_cd,";          //����CD
			$sql .= "    t_aorder_d.goods_name,";     //ά��
			$sql .= "    t_aorder_d.num, ";           //�����ƥ��
			//FC¦�������ɼɽ��Ƚ��
			if($check_data[0][0] != NULL && $group_kind == 3){
				//�ƣ�¦�������ɼ
				$sql .= "    t_aorder_d.trust_trade_price,";    //�Ķȸ���(������) 
			}else{
				//�̾���ɼ�����ե饤�������ɼ��ľ��¦�Υ���饤�������ɼ
				$sql .= "    t_aorder_d.cost_price,";           //�Ķȸ���
			}
			$sql .= "    t_aorder_d.sale_price,";     //���ñ��
			//FC¦�������ɼɽ��Ƚ��
			if($check_data[0][0] != NULL && $group_kind == 3){
				//�ƣ�¦�������ɼ
				$sql .= "    t_aorder_d.trust_trade_amount,";    //�Ķȶ��(������) 
			}else{
				//�̾���ɼ�����ե饤�������ɼ��ľ��¦�Υ���饤�������ɼ
				$sql .= "    t_aorder_d.cost_amount,";           //�Ķȶ��
			}
			$sql .= "    t_aorder_d.sale_amount ";    //�����
			$sql .= "FROM ";
			$sql .= "    t_aorder_d ";
			$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    aord_d_id = $get_con_id2;";
		}else{
			$sql  = "SELECT ";
			$sql .= "    t_sale_d.line,";           //�Կ�
			$sql .= "    t_sale_d.serv_id,";        //�����ӥ�ID
			$sql .= "    t_goods.goods_cd,";          //����CD
			$sql .= "    t_sale_d.goods_name,";     //ά��
			$sql .= "    t_sale_d.num, ";           //�����ƥ��
			$sql .= "    t_sale_d.cost_price,";    //�Ķȸ���
			$sql .= "    t_sale_d.sale_price,";     //���ñ��
			$sql .= "    t_sale_d.cost_amount,";   //�Ķȶ��
			$sql .= "    t_sale_d.sale_amount ";    //�����
			$sql .= "FROM ";
			$sql .= "    t_sale_d ";
			$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_sale_d.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    sale_d_id = $get_con_id2;";
		}
		$result = Db_Query($db_con, $sql);
		$info_data = Get_Data($result);

		$row = $info_data[0][0];        //����ǡ����ι��ֹ�
		
		$serv_id = $info_data[0][1];    //�����ӥ�ID
		//�����ӥ������ꤵ��Ƥ��뤫Ƚ��
		if($serv_id != NULL){
			$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
			$result = Db_Query($db_con, $sql); 
			$data_list = Get_Data($result);
			$serv_name = $data_list[0][0];
		}

		$main_goods_cd = $info_data[0][2];     //�����ƥ�CD
	 	$main_goods_name = $info_data[0][3];   //�����ƥ�̾
		$main_goods_num = number_format($info_data[0][4]);    //�����ƥ��

		//�Ķ�ñ��
		$th_price = explode('.', $info_data[0][5]);
		if($th_price[1] == null){
		    $th_price[1] = '00';
		}
		$main_trade_price = $th_price[0].".".$th_price[1];
		$main_trade_price = number_format($main_trade_price,2);

		//���ñ��
		$sh_price = explode('.', $info_data[0][6]);
		if($sh_price[1] == null){
		    $sh_price[1] = '00';
		}
		$main_sale_price = $sh_price[0].".".$sh_price[1];
		$main_sale_price = number_format($main_sale_price,2);

		//�Ķȶ��
		$main_trade_amount = number_format($info_data[0][7]);
		//�����
		$main_sale_amount = number_format($info_data[0][8]);
		
		/****************************/
		//�����ơ��֥�
		/****************************/
		if($get_id3 == "sale"){
			$sql  = "SELECT ";
			$sql .= "    t_aorder_detail.line,";          //��
			$sql .= "    t_aorder_detail.goods_id,";      //����ID
			$sql .= "    t_goods.goods_cd,";              //����CD
			$sql .= "    t_goods.name_change,";           //��̾�ѹ�
			$sql .= "    t_aorder_detail.goods_name,";    //ά��
			$sql .= "    t_aorder_detail.num,";           //����
			//FC¦�������ɼɽ��Ƚ��
			if($check_data[0][0] != NULL && $group_kind == 3){
				//�ƣ�¦�������ɼ
				$sql .= "    t_aorder_detail.trust_trade_price,"; //�Ķȸ���(������) 
			}else{
				//�̾���ɼ�����ե饤�������ɼ��ľ��¦�Υ���饤�������ɼ
				$sql .= "    t_aorder_detail.trade_price,";       //�Ķȸ���
			}
			$sql .= "    t_aorder_detail.sale_price,";    //���ñ��
			//FC¦�������ɼɽ��Ƚ��
			if($check_data[0][0] != NULL && $group_kind == 3){
				//�ƣ�¦�������ɼ
				$sql .= "    t_aorder_detail.trust_trade_amount,"; //�Ķȶ��(������) 
			}else{
				//�̾���ɼ�����ե饤�������ɼ��ľ��¦�Υ���饤�������ɼ
				$sql .= "    t_aorder_detail.trade_amount,";       //�Ķȶ��  
			} 
			$sql .= "    t_aorder_detail.sale_amount ";   //�����
			$sql .= "FROM ";
			$sql .= "    t_aorder_detail ";
			$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_aorder_detail.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    t_aorder_detail.aord_d_id = $get_con_id2;";  
		}else{
			$sql  = "SELECT ";
			$sql .= "    t_sale_detail.line,";          //��
			$sql .= "    t_sale_detail.goods_id,";      //����ID
			$sql .= "    t_goods.goods_cd,";              //����CD
			$sql .= "    t_goods.name_change,";           //��̾�ѹ�
			$sql .= "    t_sale_detail.goods_name,";    //ά��
			$sql .= "    t_sale_detail.num,";           //����
			$sql .= "    t_sale_detail.trade_price,";   //�Ķȸ���
			$sql .= "    t_sale_detail.sale_price,";    //���ñ��
			$sql .= "    t_sale_detail.trade_amount,";  //�Ķȶ��   
			$sql .= "    t_sale_detail.sale_amount ";   //�����
			$sql .= "FROM ";
			$sql .= "    t_sale_detail ";
			$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_sale_detail.goods_id ";
			$sql .= "WHERE ";
			$sql .= "    t_sale_detail.sale_d_id = $get_con_id2;";
		}
		$result = Db_Query($db_con, $sql);
		$detail_data = Get_Data($result,2);

		//����ǡ���ID�˳�������ǡ�����¸�ߤ��뤫
		for($d=0;$d<count($detail_data);$d++){
			$search_line2 = $detail_data[$d][0];                                  //���������
			$con_data["hdn_bgoods_id"][$row][$search_line2]      = $detail_data[$d][1]; //����ID
			$con_data["break_goods_cd"][$row][$search_line2]     = $detail_data[$d][2]; //����CD
			$con_data["hdn_bname_change"][$row][$search_line2]   = $detail_data[$d][3]; //��̾�ѹ�
			$con_data["break_goods_name"][$row][$search_line2]   = $detail_data[$d][4]; //ά��
			$con_data["break_goods_num"][$row][$search_line2]    = number_format($detail_data[$d][5]); //����

			$t_price = explode('.', $detail_data[$d][6]);
			$con_data["break_trade_price"][$row][$search_line2]["1"] = number_format($t_price[0]);     //�Ķȸ���
			$con_data["break_trade_price"][$row][$search_line2]["2"] = ($t_price[1] != null)? $t_price[1] : '00';     

			$s_price = explode('.', $detail_data[$d][7]);
			$con_data["break_sale_price"][$row][$search_line2]["1"] = number_format($s_price[0]);     //���ñ��
			$con_data["break_sale_price"][$row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';     

			$con_data["break_trade_amount"][$row][$search_line2] = number_format($detail_data[$d][8]); //�Ķȶ��
			$con_data["break_sale_amount"][$row][$search_line2]  = number_format($detail_data[$d][9]); //�����
		}

		$form->setDefaults($con_data);
		$form->freeze();
	}else{
		/****************************/
		//�������ƥơ��֥�
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_con_info.line,";           //�Կ�
		$sql .= "    t_con_info.serv_id,";        //�����ӥ�ID
		$sql .= "    t_goods.goods_cd,";          //����CD
		$sql .= "    t_con_info.goods_name,";     //ά��
		$sql .= "    t_con_info.num, ";           //�����ƥ��
		$sql .= "    t_con_info.trade_price,";    //�Ķȸ���
		$sql .= "    t_con_info.sale_price,";     //���ñ��
		$sql .= "    t_con_info.trade_amount,";   //�Ķȶ��
		$sql .= "    t_con_info.sale_amount ";    //�����
		$sql .= "FROM ";
		$sql .= "    t_con_info ";
		$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_con_info.goods_id ";
		$sql .= "WHERE ";
		$sql .= "    con_info_id = $get_info_id;";
		$result = Db_Query($db_con, $sql);
		$info_data = Get_Data($result);

		$row = $info_data[0][0];        //������Ͽ�ι��ֹ�
		
		$serv_id = $info_data[0][1];    //�����ӥ�ID
		//�����ӥ������ꤵ��Ƥ��뤫Ƚ��
		if($serv_id != NULL){
			$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
			$result = Db_Query($db_con, $sql); 
			$data_list = Get_Data($result);
			$serv_name = $data_list[0][0];
		}

		$main_goods_cd = $info_data[0][2];     //�����ƥ�CD
	 	$main_goods_name = $info_data[0][3];   //�����ƥ�̾
		$main_goods_num = number_format($info_data[0][4]);    //�����ƥ��

		//�Ķ�ñ��
		$th_price = explode('.', $info_data[0][5]);
		if($th_price[1] == null){
		    $th_price[1] = '00';
		}
		$main_trade_price = $th_price[0].".".$th_price[1];
		$main_trade_price = number_format($main_trade_price,2);

		//���ñ��
		$sh_price = explode('.', $info_data[0][6]);
		if($sh_price[1] == null){
		    $sh_price[1] = '00';
		}
		$main_sale_price = $sh_price[0].".".$sh_price[1];
		$main_sale_price = number_format($main_sale_price,2);

		//�Ķȶ��
		$main_trade_amount = number_format($info_data[0][7]);
		//�����
		$main_sale_amount = number_format($info_data[0][8]);
		
		/****************************/
		//�����ơ��֥�
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_con_detail.line,";          //��
		$sql .= "    t_con_detail.goods_id,";      //����ID
		$sql .= "    t_goods.goods_cd,";           //����CD
		$sql .= "    t_goods.name_change,";        //��̾�ѹ�
		$sql .= "    t_con_detail.goods_name,";    //ά��
		$sql .= "    t_con_detail.num,";           //����
		$sql .= "    t_con_detail.trade_price,";   //�Ķȸ���
		$sql .= "    t_con_detail.sale_price,";    //���ñ��
		$sql .= "    t_con_detail.trade_amount,";  //�Ķȶ��   
		$sql .= "    t_con_detail.sale_amount ";   //�����
		$sql .= "FROM ";
		$sql .= "    t_con_detail ";
		$sql .= "    INNER JOIN t_goods ON t_goods.goods_id = t_con_detail.goods_id ";
		$sql .= "WHERE ";
		$sql .= "    t_con_detail.con_info_id = $get_info_id;";  
		$result = Db_Query($db_con, $sql);
		$detail_data = Get_Data($result,2);

		//��������ID�˳�������ǡ�����¸�ߤ��뤫
		for($d=0;$d<count($detail_data);$d++){
			$search_line2 = $detail_data[$d][0];                                  //���������
			$con_data["hdn_bgoods_id"][$row][$search_line2]      = $detail_data[$d][1]; //����ID
			$con_data["break_goods_cd"][$row][$search_line2]     = $detail_data[$d][2]; //����CD
			$con_data["hdn_bname_change"][$row][$search_line2]   = $detail_data[$d][3]; //��̾�ѹ�
			$con_data["break_goods_name"][$row][$search_line2]   = $detail_data[$d][4]; //ά��
			$con_data["break_goods_num"][$row][$search_line2]    = number_format($detail_data[$d][5]); //����

			$t_price = explode('.', $detail_data[$d][6]);
			$con_data["break_trade_price"][$row][$search_line2]["1"] = number_format($t_price[0]);     //�Ķȸ���
			$con_data["break_trade_price"][$row][$search_line2]["2"] = ($t_price[1] != null)? $t_price[1] : '00';     

			$s_price = explode('.', $detail_data[$d][7]);
			$con_data["break_sale_price"][$row][$search_line2]["1"] = number_format($s_price[0]);     //���ñ��
			$con_data["break_sale_price"][$row][$search_line2]["2"] = ($s_price[1] != null)? $s_price[1] : '00';     

			$con_data["break_trade_amount"][$row][$search_line2] = number_format($detail_data[$d][8]); //�Ķȶ��
			$con_data["break_sale_amount"][$row][$search_line2]  = number_format($detail_data[$d][9]); //�����
		}

		//��԰�������å��ܥå���
		$form->addElement('hidden',"daiko_check", "");

		$form->setDefaults($con_data);
		$form->freeze();
	}

}else{
	//������Ͽ��������

	//�ǣţԾ�������Ƚ��
	Get_ID_Check2($client_id);
	Get_ID_Check2($flg);
	Get_ID_Check2($row);

	/****************************/
	//hidden�Ƿ�����Ͽ���������
	/****************************/
	require_once(INCLUDE_DIR."keiyaku_hidden.inc");

	/****************************/
	//hidden����§�����������
	/****************************/
	$date_array = NULL;
	//POST�ǡ�����������
	$year  = date("Y");
	$month = date("m");

	for($i=0;$i<28;$i++){
		//�����������
		$now = mktime(0, 0, 0, $month+$i,1,$year);
		$num = date("t",$now);

		//��ǯ��������ʬ�ǡ�������
		for($s=1;$s<=$num;$s++){
			$now = mktime(0, 0, 0, $month+$i,$s,$year);
			$syear  = (int) date("Y",$now);
			$smonth = (int) date("n",$now);
			$sday   = (int) date("d",$now);
			$input_date = "check_".$syear."-".$smonth."-".$sday;

			//�����å����줿���դ��������
			if($_POST["$input_date"] != NULL){
				$smonth = str_pad($smonth,2, 0, STR_POS_LEFT);
				$sday = str_pad($sday,2, 0, STR_POS_LEFT);
				$date_array[] = $syear."-".$smonth."-".$sday;
				
				//�ͤ���������٤���§���Υ����å���hidden�Ǻ���
				$form->addElement("hidden","$input_date","");
			}
		}
	}

	/****************************/
	//POST�������
	/****************************/
	//�����ӥ�
	$serv_id = $_POST["form_serv"][$row];
	//�����ӥ������ꤵ��Ƥ��뤫Ƚ��
	if($serv_id != NULL){
		$sql  = "SELECT serv_name FROM t_serv WHERE serv_id = $serv_id;";
		$result = Db_Query($db_con, $sql); 
		$data_list = Get_Data($result);
		$serv_name = $data_list[0][0];
	}

	//�����ƥ�
	$main_goods_cd = $_POST["form_goods_cd1"][$row];
	$main_goods_name = stripslashes($_POST["form_goods_name1"][$row]);
	//���̷���Ƚ��
	if($_POST["form_goods_num1"][$row] != NULL){
		$main_goods_num = number_format($_POST["form_goods_num1"][$row]);
	}

	//���
	//�Ķ�ñ�������ѹ�Ƚ��
	if($_POST["form_trade_price"][$row][1] != NULL){
		$trade_1 = number_format($_POST["form_trade_price"][$row][1]);
		$trade_2 = ($_POST["form_trade_price"][$row][2] != null)? $_POST["form_trade_price"][$row][2] : '00';
		$main_trade_price = $trade_1.".".$trade_2;
	}
	//���ñ�������ѹ�Ƚ��
	if($_POST["form_sale_price"][$row][1] != NULL){
		$sale_1 = number_format($_POST["form_sale_price"][$row][1]);
		$sale_2 = ($_POST["form_sale_price"][$row][2] != null)? $_POST["form_sale_price"][$row][2] : '00';
		$main_sale_price = $sale_1.".".$sale_2;
	}
	//�Ķȶ�۷����ѹ�Ƚ��
	$main_trade_amount = $_POST["form_trade_amount"][$row];

	//����۷����ѹ�Ƚ��
	$main_sale_amount = $_POST["form_sale_amount"][$row];

	//�������ܥ����hidden�ˤ���ݻ�����
	if($_POST["return_btn"] == NULL){
		//�ѹ����������ǡ�����hidden�˥��å�
		for($d=1;$d<=5;$d++){
			//����饤�󡦥��ե饤�����Ƚ��
			if(($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3) && $_POST["hdn_bgoods_id"][$row][$d] != NULL){
				//��԰����������ñ������԰�����Ψ��
				$com_s_price = $_POST["break_sale_price"][$row][$d]["1"].".".$_POST["break_sale_price"][$row][$d]["2"];
				$daiko_money = bcmul($com_s_price,bcdiv($_POST["form_daiko_price"],100,2),2);

			    $eigyo_money = explode('.',$daiko_money);

				$def_data["break_trade_price"][$row][$d]["1"] = $eigyo_money[0];

				if($eigyo_money[1] != NULL){
					$def_data["break_trade_price"][$row][$d]["2"] = $eigyo_money[1];
				}else{
					$def_data["break_trade_price"][$row][$d]["2"] = '00';
				}

				//��۷׻�����Ƚ��
				if($_POST["break_goods_num"][$row][$d] != null){
					//�Ķȶ�۷׻�
			        $cost_amount = bcmul($daiko_money, $_POST["break_goods_num"][$row][$d],2);
			        $cost_amount = Coax_Col($coax, $cost_amount);
				}
				$def_data["break_trade_amount"][$row][$d]    = number_format($cost_amount);
			}

			$def_data["return_bgoods_id"][$row][$d]        = $_POST["hdn_bgoods_id"][$row][$d];
			$def_data["return_bname_change"][$row][$d]     = $_POST["hdn_bname_change"][$row][$d];
			$def_data["return_goods_cd"][$row][$d]         = $_POST["break_goods_cd"][$row][$d];
			$def_data["return_goods_name"][$row][$d]       = $_POST["break_goods_name"][$row][$d];
			$def_data["return_goods_num"][$row][$d]        = $_POST["break_goods_num"][$row][$d];
			$def_data["return_trade_price"][$row][$d]["1"] = $_POST["break_trade_price"][$row][$d]["1"];
			$def_data["return_trade_price"][$row][$d]["2"] = $_POST["break_trade_price"][$row][$d]["2"];
			$def_data["return_trade_amount"][$row][$d]     = $_POST["break_trade_amount"][$row][$d];
			$def_data["return_sale_price"][$row][$d]["1"]  = $_POST["break_sale_price"][$row][$d]["1"];
			$def_data["return_sale_price"][$row][$d]["2"]  = $_POST["break_sale_price"][$row][$d]["2"];
			$def_data["return_sale_amount"][$row][$d]      = $_POST["break_sale_amount"][$row][$d];
		}
		$def_data["return_btn"] = true;
		$form->setConstants($def_data);
	}

	/****************************/
	//������������
	/****************************/
	//������ξ�������
	$sql  = "SELECT";
	$sql .= "   t_client.coax ";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   client_id = $client_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql); 
	Get_Id_Check($result);
	$data_list = Get_Data($result);
	$coax           = $data_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�

	//POST�����ѹ�
	$con_data2["hdn_coax"]            = $coax;

	/****************************/
	//���������
	/****************************/
	$client_sql  = " SELECT ";
	$client_sql .= "     DISTINCT(t_client.client_id) ";
	$client_sql .= " FROM";
	$client_sql .= "     t_client ";
	$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
	$client_sql .= " WHERE";
	if($_SESSION["group_kind"] == '2'){
	    $client_sql .= "    t_client.shop_id IN (".Rank_Sql().")";
	}else{
	    $client_sql .= "    t_client.shop_id = $client_h_id";
	}
	$client_sql .= "     AND";
	$client_sql .= "     t_client.client_div = '1'";

	//�إå�����ɽ�������������
	$count_res = Db_Query($db_con, $client_sql.";");
	$total_count = pg_num_rows($count_res);

	/****************************/
	//���ʥ���������
	/****************************/
	if($_POST["goods_search_row"] != null){
		
		//���ʥǡ�������������
		$search_row = $_POST["goods_search_row"];

		//�̾ﾦ�ʡ������ʤλҼ���SQL
		$sql  = " SELECT";
		$sql .= "     t_goods.goods_id,";                      //����ID
		$sql .= "     t_goods.name_change,";                   //��̾�ѹ��ե饰
		$sql .= "     t_goods.goods_cd,";                      //���ʥ�����
		$sql .= "     t_goods.goods_cname,";                   //ά��
		$sql .= "     initial_cost.r_price AS initial_price,"; //�Ķ�ñ��
		$sql .= "     sale_price.r_price AS sale_price, ";     //���ñ��
		$sql .= "     t_goods.compose_flg ";                   //�����ʥե饰
		                 
		$sql .= " FROM";
		$sql .= "     t_goods ";

		$sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
		$sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

		$sql .= " WHERE";
		$sql .= "     t_goods.goods_cd = '".$_POST["break_goods_cd"][$row][$search_row]."' ";
		$sql .= " AND ";
		$sql .= "     t_goods.compose_flg = 'f' ";
		$sql .= " AND ";
		$sql .= "     initial_cost.rank_cd = '2' ";
		$sql .= " AND ";
		$sql .= "     sale_price.rank_cd = '4'";
		$sql .= " AND ";
//watanabe-k
        $sql .= "     t_goods.accept_flg = '1'";
        $sql .= " AND ";
        //ľ��Ƚ��
        if($_SESSION[group_kind] == '2'){
            //ľ��
            $sql .= "     t_goods.state IN (1,3)";
        }else{
            //FC
            $sql .= "     t_goods.state = 1";
        }

        $sql .= " AND\n";

		//ľ��Ƚ��
		if($_SESSION[group_kind] == "2"){
			//ľ��
	        $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
	    }else{
			//FC
	        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
	    }
		$sql .= " AND  \n";
		//ľ��Ƚ��
		if($_SESSION[group_kind] == "2"){
			//ľ��
			$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")) \n";
		}else{
			//FC
			$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id) \n";
		}

		//����饤�󡦥��ե饤�����Ƚ��
		if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){
			$sql .= "AND \n";
			$sql .= "    public_flg = 't' \n";
		}

		$sql .= "UNION ";
		//�����ʤοƼ���SQL
		$sql .= " SELECT";
		$sql .= "     t_goods.goods_id,";                      //����ID
		$sql .= "     t_goods.name_change,";                   //��̾�ѹ��ե饰
		$sql .= "     t_goods.goods_cd,";                      //���ʥ�����
		$sql .= "     t_goods.goods_cname,";                   //����̾
		$sql .= "     NULL,";
		$sql .= "     NULL,";
		$sql .= "     t_goods.compose_flg ";                   //�����ʥե饰
		$sql .= " FROM";
		$sql .= "     t_goods ";
		$sql .= " WHERE";
		$sql .= "     t_goods.goods_cd = '".$_POST["break_goods_cd"][$row][$search_row]."' ";
		$sql .= " AND ";
		$sql .= "     t_goods.compose_flg = 't' ";
//watanabe-k�ѹ�
        $sql .= " AND";
        $sql .= "     t_goods.accept_flg = '1' ";
        $sql .= " AND";

        //ľ��Ƚ��
        if($_SESSION[group_kind] == "2"){
            //ľ��
            $sql .= " t_goods.state IN (1,3) ";
        }else{
            //FC
            $sql .= " t_goods.state = 1 ";
        }

		//����饤�󡦥��ե饤�����Ƚ��
		if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){
			$sql .= "AND \n";
			$sql .= "    public_flg = 't' \n";
		}

		$result = Db_Query($db_con, $sql.";");

	    $data_num = pg_num_rows($result);
		//�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ��
		if($data_num == 1){
	    	$goods_data = pg_fetch_array($result);

			$con_data2["hdn_bgoods_id"][$row][$search_row]         = $goods_data[0];   //����ID

			$con_data2["hdn_bname_change"][$row][$search_row]      = $goods_data[1];   //��̾�ѹ��ե饰
			$hdn_bname_change[$row][$search_row]                   = $goods_data[1];   //POST�������˾���̾���ѹ��Բ�Ƚ���Ԥʤ���

			$con_data2["break_goods_cd"][$row][$search_row]        = $goods_data[2];   //����CD
			$con_data2["break_goods_name"][$row][$search_row]      = $goods_data[3];   //ά��

			//������Ƚ��
			if($goods_data[6] == 'f'){
				//�����ʤǤϤʤ�

				//����ñ�����������Ⱦ�������ʬ����
				$com_c_price = $goods_data[4];
		        $c_price = explode('.', $goods_data[4]);
				$con_data2["break_trade_price"][$row][$search_row]["1"] = $c_price[0];  //�Ķ�ñ��
				$con_data2["break_trade_price"][$row][$search_row]["2"] = ($c_price[1] != null)? $c_price[1] : '00';     

				//���ñ�����������Ⱦ�������ʬ����
				$com_s_price = $goods_data[5];
		        $s_price = explode('.', $goods_data[5]);
				$con_data2["break_sale_price"][$row][$search_row]["1"] = $s_price[0];  //���ñ��
				$con_data2["break_sale_price"][$row][$search_row]["2"] = ($s_price[1] != null)? $s_price[1] : '00';

				//��۷׻�����Ƚ��
				if($_POST["break_goods_num"][$row][$search_row] != null){
					//�Ķȶ�۷׻�
		            $cost_amount = bcmul($goods_data[4], $_POST["break_goods_num"][$row][$search_row],2);
		            $cost_amount = Coax_Col($coax, $cost_amount);
					//����۷׻�
		            $sale_amount = bcmul($goods_data[5], $_POST["break_goods_num"][$row][$search_row],2);
		            $sale_amount = Coax_Col($coax, $sale_amount);
				
					$con_data2["break_trade_amount"][$row][$search_row]    = number_format($cost_amount);
					$con_data2["break_sale_amount"][$row][$search_row]     = number_format($sale_amount);
				}
			}else{
				//������

				//�����ʤλҤξ��ʾ������
				$sql  = "SELECT ";
				$sql .= "    parts_goods_id ";                       //������ID
				$sql .= "FROM ";
				$sql .= "    t_compose ";
				$sql .= "WHERE ";
				$sql .= "    goods_id = ".$goods_data[0].";";
				$result = Db_Query($db_con, $sql);
				$goods_parts = Get_Data($result);

				//�ƹ����ʤ�ñ������
				$com_c_price = 0;     //�����ʿƤαĶȸ���
				$com_s_price = 0;     //�����ʿƤ����ñ��

				for($i=0;$i<count($goods_parts);$i++){
					$sql  = " SELECT ";
					$sql .= "     t_compose.count,";                       //����
					$sql .= "     initial_cost.r_price AS initial_price,"; //�Ķ�ñ��
					$sql .= "     sale_price.r_price AS sale_price  ";     //���ñ��
					                 
					$sql .= " FROM";
					$sql .= "     t_compose ";

					$sql .= "     INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
					$sql .= "     INNER JOIN  t_price AS initial_cost ON t_goods.goods_id = initial_cost.goods_id";
					$sql .= "     INNER JOIN  t_price AS sale_price ON t_goods.goods_id = sale_price.goods_id";

					$sql .= " WHERE";
					$sql .= "     t_compose.goods_id = ".$goods_data[0];
					$sql .= " AND ";
					$sql .= "     t_compose.parts_goods_id = ".$goods_parts[$i][0];
					$sql .= " AND ";
					$sql .= "     initial_cost.rank_cd = '2' ";
					$sql .= " AND ";
					$sql .= "     sale_price.rank_cd = '4'";
					$sql .= " AND ";
					//ľ��Ƚ��
					if($_SESSION[group_kind] == "2"){
						//ľ��
				        $sql .= "     initial_cost.shop_id IN (".Rank_Sql().") ";
				    }else{
						//FC
				        $sql .= "     initial_cost.shop_id = $client_h_id  \n";
				    }
					$sql .= " AND  \n";
					//ľ��Ƚ��
					if($_SESSION[group_kind] == "2"){
						//ľ��
						$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id IN (".Rank_Sql().")); \n";
					}else{
						//FC
						$sql .= "     (sale_price.shop_id = (SELECT client_id FROM t_client WHERE client_div = '0') OR sale_price.shop_id = $client_h_id); \n";
					}
					$result = Db_Query($db_con, $sql);
					$com_data = Get_Data($result);
					//�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ���Ƚ��
					if($com_data == NULL){
						$reset_goods_flg = true;   //���Ϥ��줿���ʾ���򥯥ꥢ
					}
	
					//�����ʿƤαĶ�ñ���׻�������ɲ�(�Ҥο��̡߻ҤαĶȸ���)
					$com_cp_amount = bcmul($com_data[0][0],$com_data[0][1],2);
		            $com_cp_amount = Coax_Col($coax, $com_cp_amount);
					$com_c_price = $com_c_price + $com_cp_amount;
					//�����ʿƤ����ñ���׻�������ɲ�(�Ҥο��̡߻Ҥ����ñ��)
					$com_sp_amount = bcmul($com_data[0][0],$com_data[0][2],2);
		            $com_sp_amount = Coax_Col($coax, $com_sp_amount);
					$com_s_price = $com_s_price + $com_sp_amount;
				}

				//����ñ�����������Ⱦ�������ʬ����
		        $cost_price = explode('.', $com_c_price);
				$con_data2["break_trade_price"][$row][$search_row]["1"] = $cost_price[0];  //�Ķ�ñ��
				$con_data2["break_trade_price"][$row][$search_row]["2"] = ($cost_price[1] != null)? $cost_price[1] : '00';     

				//���ñ�����������Ⱦ�������ʬ����
		        $sale_price = explode('.', $com_s_price);
				$con_data2["break_sale_price"][$row][$search_row]["1"] = $sale_price[0];  //���ñ��
				$con_data2["break_sale_price"][$row][$search_row]["2"] = ($sale_price[1] != null)? $sale_price[1] : '00';

				//��۷׻�����Ƚ��
				if($_POST["break_goods_num"][$row][$search_row] != null){
					//�Ķȶ�۷׻�
		            $cost_amount = bcmul($com_c_price, $_POST["break_goods_num"][$row][$search_row],2);
		            $cost_amount = Coax_Col($coax, $cost_amount);
					//����۷׻�
		            $sale_amount = bcmul($com_s_price, $_POST["break_goods_num"][$row][$search_row],2);
		            $sale_amount = Coax_Col($coax, $sale_amount);
				}
			}

			//����饤�󡦥��ե饤�����Ƚ��
			if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){

				//��԰����������������԰�����Ψ��
				$daiko_money = bcmul($com_s_price,bcdiv($_POST["form_daiko_price"],100,2),2);

			    $eigyo_money = explode('.',$daiko_money);

				$con_data2["break_trade_price"][$row][$search_row]["1"] = $eigyo_money[0];

				if($eigyo_money[1] != NULL){
					$con_data2["break_trade_price"][$row][$search_row]["2"] = $eigyo_money[1];
				}else{
					$con_data2["break_trade_price"][$row][$search_row]["2"] = '00';
				}

				//��۷׻�����Ƚ��
				if($_POST["break_goods_num"][$row][$search_row] != null){
					//�Ķȶ�۷׻�
		            $cost_amount = bcmul($daiko_money, $_POST["break_goods_num"][$row][$search_row],2);
		            $cost_amount = Coax_Col($coax, $cost_amount);
				}
			}
			$con_data2["break_trade_amount"][$row][$search_row]    = number_format($cost_amount);
			$con_data2["break_sale_amount"][$row][$search_row]     = number_format($sale_amount);

			//�����ʤλҤ�ñ�������ꤵ��Ƥ��ʤ��Ȥ������ʾ��󥯥ꥢ
			if($reset_goods_flg == true){
				//�ǡ�����̵�����ϡ������
				$con_data2["hdn_bgoods_id"][$row][$search_row]         = "";
				$con_data2["hdn_bname_change"][$row][$search_row]      = "";
				$con_data2["break_goods_cd"][$row][$search_row]        = "";
				$con_data2["break_goods_name"][$row][$search_row]      = "";
		        $con_data2["break_goods_num"][$row][$search_row]       = "";
				$con_data2["break_trade_price"][$row][$search_row]["1"] = "";
				$con_data2["break_trade_price"][$row][$search_row]["2"] = "";
				$con_data2["break_trade_amount"][$row][$search_row]     = "";
				$con_data2["break_sale_price"][$row][$search_row]["1"] = "";
				$con_data2["break_sale_price"][$row][$search_row]["2"] = "";
				$con_data2["break_sale_amount"][$row][$search_row]     = "";
			}
		}else{
			//�ǡ�����̵�����ϡ������
			$con_data2["hdn_bgoods_id"][$row][$search_row]         = "";
			$con_data2["hdn_bname_change"][$row][$search_row]      = "";
			$con_data2["break_goods_cd"][$row][$search_row]        = "";
			$con_data2["break_goods_name"][$row][$search_row]      = "";
	        $con_data2["break_goods_num"][$row][$search_row]       = "";
			$con_data2["break_trade_price"][$row][$search_row]["1"] = "";
			$con_data2["break_trade_price"][$row][$search_row]["2"] = "";
			$con_data2["break_trade_amount"][$row][$search_row]     = "";
			$con_data2["break_sale_price"][$row][$search_row]["1"] = "";
			$con_data2["break_sale_price"][$row][$search_row]["2"] = "";
			$con_data2["break_sale_amount"][$row][$search_row]     = "";
		}
		$con_data2["goods_search_row"]                  = "";

	}

	/****************************/
	//���ꥢ�ܥ��󲡲�����
	/****************************/
	if($_POST["clear_flg"] == true){
		//����������ƽ����
		for($c=1;$c<=5;$c++){
			for($f=1;$f<=3;$f++){
				$con_data2["hdn_bgoods_id"][$row][$c]        = "";
				$con_data2["hdn_bname_change"][$row][$c]     = "";
				$con_data2["break_goods_cd"][$row][$c]       = "";
				$con_data2["break_goods_name"][$row][$c]     = "";
		        $con_data2["break_goods_num"][$row][$c]      = "";
			}
			$con_data2["break_trade_price"][$row][$c]["1"] = "";
			$con_data2["break_trade_price"][$row][$c]["2"] = "";
			$con_data2["break_trade_amount"][$row][$c]     = "";
			$con_data2["break_sale_price"][$row][$c]["1"]  = "";
			$con_data2["break_sale_price"][$row][$c]["2"]  = "";
			$con_data2["break_sale_amount"][$row][$c]      = "";
		}

		$con_data2["clear_flg"] = "";    //���ꥢ�ܥ��󲡲��ե饰
	}
}
/****************************/
//�������
/****************************/
//������Ͽ�ιԿ�ʬ
$type = $g_form_option;
for($i=1;$i<=5;$i++){
	//���������ꤹ��Ԥ�Ƚ��
	if($row == $i){
		//�����

		//�����ιԿ�ʬ
		for($j=1;$j<=5;$j++){

			//���ʥ�����      
			$form->addElement(
			    "text","break_goods_cd[$i][$j]","","size=\"10\" maxLength=\"8\"
			    style=\"$g_form_style;$style\" $type
				onChange=\"goods_search_1(this.form, 'break_goods_cd[$i][$j]', 'goods_search_row', $j)\""
			);
				
			//����̾
			//�ѹ��Բ�Ƚ��
			if($_POST["hdn_bname_change"][$i][$j] == '2' || $hdn_bname_change[$i][$j] == '2'){
				//�Բ�
			    $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" $g_text_readonly" 
			    );
			}else{
				//��
			    $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" maxLength=\"20\" 
			        style=\"$style\" $type"
			    );
			}

			//FC��ľ��Ƚ��
			if($group_kind == 2){
				//ľ��
			    $form->addElement(
					"link","form_search[$i][$j]","","#","����",
					"onClick=\"return Open_SubWin_Plan('../dialog/2-0-210.php', Array('break_goods_cd[$i][$j]','goods_search_row'), 500, 450,6,$client_h_id,$j,".$_POST["daiko_check"].");\""
				);
			}else{
				//FC
			    $form->addElement(
					"link","form_search[$i][$j]","","#","����",
					"onClick=\"return Open_SubWin_Plan('../dialog/2-0-210.php', Array('break_goods_cd[$i][$j]','goods_search_row'), 500, 450,6,$client_h_id,$j);\""
				);
			}

			//FC��ľ��Ƚ��
			if($group_kind == 2){
				//ľ��
				//���ʿ�
				$form->addElement(
			       "text","break_goods_num[$i][$j]","",
			       "class=\"money_num\" size=\"6\" maxLength=\"5\" 
			       onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
			        style=\"$g_form_style;$style\" $type"
			    );
			}else{
				//FC
				//���ʿ�
				$form->addElement(
			       "text","break_goods_num[$i][$j]","",
			       "class=\"money_num\" size=\"6\" maxLength=\"5\" 
			       onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
			        style=\"$g_form_style;$style\" $type"
			    );
			}

			//����ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]");
			//��̾�ѹ��ե饰
			$form->addElement("hidden","hdn_bname_change[$i][$j]");

			//FC��ľ��Ƚ��
			if($group_kind == 2){
				//ľ��
			
				//��Ԥξ��ϡ��ɤ߼��ʤΤ��طʤ򲫿��ˤ��ʤ�
				if($_POST["daiko_check"] != 1){
					$type = NULL;
				}

				//�Ķȸ���
				$form_cost_price = NULL;
				$form_cost_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_cost_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true,$i,true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_cost_price[$i], "break_trade_price[$i][$j]", "",".");

				//�Ķȸ����ʳ��Ϸ����ʬ�ˤ�äƥե����ब�Ѥ��ʤ�
				$type = $g_form_option;

				//������׳�
			    $form->addElement(
			        "text","break_trade_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );

				//���ñ��
				$form_sale_price = NULL;
				$form_sale_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false,$i,true);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_sale_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double3('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true,$i,true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_sale_price[$i], "break_sale_price[$i][$j]", "",".");

				//����׳�
				$form->addElement(
			        "text","break_sale_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );
			}else{
				//FC

				//�Ķȸ���
				$form_cost_price = NULL;
				$form_cost_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_cost_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_cost_price[$i], "break_trade_price[$i][$j]", "",".");

				//������׳�
			    $form->addElement(
			        "text","break_trade_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );

				//���ñ��
				$form_sale_price = NULL;
				$form_sale_price[$i][] =& $form->createElement(
				        "text","1","",
				        "size=\"9\" maxLength=\"8\"
				        class=\"money\"
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',false);\"
				        style=\"$g_form_style;text-align: right; $style\"
				        $type"
				    );
				    $form_sale_price[$i][] =& $form->createElement(
				        "text","2","","size=\"1\" maxLength=\"2\" 
				        onKeyup=\"Mult_double2('break_goods_num[$i][$j]','break_sale_price[$i][$j][1]','break_sale_price[$i][$j][2]','break_sale_amount[$i][$j]','break_trade_price[$i][$j][1]','break_trade_price[$i][$j][2]','break_trade_amount[$i][$j]','form_issiki[$i]','$coax',true);\"
				        style=\"$g_form_style;text-align: left; $style\"
				        $type"
				    );
			    $form->addGroup( $form_sale_price[$i], "break_sale_price[$i][$j]", "",".");

				//����׳�
				$form->addElement(
			        "text","break_sale_amount[$i][$j]","",
			        "size=\"17\" maxLength=\"10\" 
			        style=\"color : #000000; 
			        border : #ffffff 1px solid; 
			        background-color: #ffffff; 
			        text-align: right\" readonly'"
			    );
			}

			/*
			 * ����
			 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
			 * ��2006/10/27��01-001��������suzuki-t�����������̤����ܥ��󲡲������ѹ�
			 *
			*/
			//���ʥ�����
			$form->addElement("hidden","return_goods_cd[$i][$j]","");

			//����̾
			$form->addElement("hidden","return_goods_name[$i][$j]","");
			//���ʿ�
			$form->addElement("hidden","return_goods_num[$i][$j]","");
			//����ID
			$form->addElement("hidden","return_bgoods_id[$i][$j]","");
			//��̾�ѹ��ե饰
			$form->addElement("hidden","return_bname_change[$i][$j]","");

			//�Ķȸ���
			$form->addElement("hidden","return_trade_price[$i][$j][1]","");
			$form->addElement("hidden","return_trade_price[$i][$j][2]","");
			//�������
			$form->addElement("hidden","return_trade_amount[$i][$j]","");
			//���ñ��
			$form->addElement("hidden","return_sale_price[$i][$j][1]","");
			$form->addElement("hidden","return_sale_price[$i][$j][2]","");
			//�����
			$form->addElement("hidden","return_sale_amount[$i][$j]","");

		}
	}else{
		//���������ꤹ��԰ʳ���hidden�Ȥ������

		//������Ͽ�ιԿ�ʬ
		for($j=1;$j<=5;$j++){
			//���ʥ�����
			$form->addElement("hidden","break_goods_cd[$i][$j]","");

			//����̾
			$form->addElement("hidden","break_goods_name[$i][$j]","");
			//���ʿ�
			$form->addElement("hidden","break_goods_num[$i][$j]","");
			//����ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]","");
			//��̾�ѹ��ե饰
			$form->addElement("hidden","hdn_bname_change[$i][$j]","");

			//�Ķȸ���
			$form->addElement("hidden","break_trade_price[$i][$j][1]","");
			$form->addElement("hidden","break_trade_price[$i][$j][2]","");
			//�������
			$form->addElement("hidden","break_trade_amount[$i][$j]","");
			//���ñ��
			$form->addElement("hidden","break_sale_price[$i][$j][1]","");
			$form->addElement("hidden","break_sale_price[$i][$j][2]","");
			//�����
			$form->addElement("hidden","break_sale_amount[$i][$j]","");
		}
	}
}

//���ܸ�Ƚ��
if($get_info_id != NULL){
	//�����פ����������ɽ��
	$form->addElement("button","close_button","�Ĥ���","onClick=\"window.close()\"");
}else{
	//������Ͽ��������
	$form->addElement("hidden", "hdn_row");       //������Ͽ�ι��ֹ�    

	$form->addElement("hidden", "return_btn");    //���ɽ������������򥻥åȤ���ե饰

	//����
	$form->addElement("submit","set","�ߡ���",
	   "onClick=\"return Dialogue('���ꤷ�ޤ���','./2-1-104.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id');\""
	);
	//���ꥢ
	$form->addElement("button","clear_button","���ꥢ","onClick=\"insert_row('clear_flg');\"");
	//���
	$form->addElement("button","form_back","�ᡡ��","onClick=\"SubMenu2('./2-1-104.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id')\"");
	//�ѹ�������
	$form->addElement("button","change_button","�ѹ�������","onClick=\"location.href='2-1-111.php'\"");
	//�������(�إå���)
	$form->addElement("button","all_button","�������","onClick=\"location.href='2-1-114.php'\"");
	//��Ͽ(�إå���)
	$form->addElement("button","new_button","�С�Ͽ","style=color:red onClick=\"location.href='2-1-104.php?flg=add'\"");
}

//�ե�����롼�׿�
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//�Ķȸ����ɤ߼��ؿ�
//����饤�󡦥��ե饤�����Ƚ��
if($_POST["daiko_check"] == 2 || $_POST["daiko_check"] == 3){
	$form_load = "onLoad=\"daiko_checked($row);\"";
}

//�����
$java_sheet  = <<<DAIKO

//��԰�������å��ܥå���
function daiko_checked(row){
	//��԰���Ƚ��
	if(document.dateForm.daiko_check.value != 1){
		//����饤����ԡ����ե饤�����

		//�Ķȸ���
		document.dateForm.elements["break_trade_price["+row+"][1][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][1][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][2][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][2][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][3][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][3][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][4][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][4][2]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][5][1]"].readOnly = true;
		document.dateForm.elements["break_trade_price["+row+"][5][2]"].readOnly = true;

	}else{
		//�̾�

		//�Ķȸ���
		document.dateForm.elements["break_trade_price["+row+"][1][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][1][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][2][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][2][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][3][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][3][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][4][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][4][2]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][5][1]"].readOnly = false;
		document.dateForm.elements["break_trade_price["+row+"][5][2]"].readOnly = false;

	}
	
	return true;

}

//���ʥ��������ؿ�
function Open_SubWin_Plan(url, arr, x, y,display,select_id,shop_aid,head_flg)
{
	//�������������ꤵ��Ƥ�����ϡ��Ҹ�ID or ê��Ĵ��ID ��ɬ��
	if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){

		//�����ʬ���̾�ʳ��ϡ������ξ��ʤ�����ɽ��
		if(head_flg != 1){
			//����饤�󡦥��ե饤�����
			rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,true);
		}else{
			//�̾�
			rtnarr = Open_Dialog(url,x,y,display,select_id,shop_aid,false);
		}

		if(typeof(rtnarr) != "undefined"){
			for(i=0;i<arr.length;i++){
				dateForm.elements[arr[i]].value=rtnarr[i];
			}
		}

		var next = '#';
        document.dateForm.action=next;
		document.dateForm.submit();

	}

	return false;
}

DAIKO;

/****************************/
//POST������ͤ��ѹ�
/****************************/
$form->setConstants($con_data2);

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//���̥إå�������
/****************************/
//������Ͽ�������ܤ��Ƥ�������ɽ��
if($get_info_id == NULL){
	$page_title .= "(��".$total_count."��)";
	$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
	$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
	$page_title .= "��".$form->_elements[$form->_elementIndex[all_button]]->toHtml();
}
$page_header = Create_Header($page_title);

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'       => "$html_header",
	'page_menu'         => "$page_menu",
	'page_header'       => "$page_header",
	'html_footer'       => "$html_footer",
	'java_sheet'        => "$java_sheet",
	'flg'               => "$flg",
	'get_flg'           => "$get_flg",
	'client_id'         => "$client_id",
	'serv_name'         => "$serv_name",
	'main_goods_name'   => "$main_goods_name",
	'main_goods_cd'     => "$main_goods_cd",
	'main_goods_num'    => "$main_goods_num",
	'main_trade_price'  => "$main_trade_price",
	'main_sale_price'   => "$main_sale_price",
	'main_trade_amount' => "$main_trade_amount",
	'main_sale_amount'  => "$main_sale_amount",
	'row'               => "$row",
	'get_info_id'       => "$get_info_id",
	'form_load'         => "$form_load",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
