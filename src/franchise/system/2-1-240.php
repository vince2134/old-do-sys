<?php
/******************************
 *  �ѹ�����
 *      �� 2006/07/26 ���ʥޥ����ι����ѹ���ȼ����о��ν�����watanabe-k��
 *      �� 2006/12/01 �ݤ��ʬ�����ۤ��ѹ���suzuki��
 *      �� 2007/04/06 �Ķȸ����Υǥե�����ͤ϶���Ǥʤ������ʥޥ����αĶȶ�ۤȤ���褦�˽���<morita-d>
 *      �� 2007/04/06 ������֤�ɽ�����ɲ�<morita-d>
 *      �� 2007/04/24 ����ȯ����������ȯ����������������򥨥顼�Ȥ���褦���ѹ�<morita-d>
 *      �� 2007-06-05 ��ɼ�κ����ϡ���������ñ�̡פǤʤ��ַ���ñ�̡פǼ»ܤ���褦�˽���<morita-d>
 *      �� 2007-06-09 ͽ��ǡ�������ʣ���ƺ����������Ϸٹ��ɽ������褦�˽���<morita-d>
******************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-11-10      01-014      suzuki      �����ӥ��Τ���ɼ�λ�����ۤ�������ϻ��˱Ķȶ�ۤ򤤤��褦�˽���
 *  2007/06/28      xx-xxx      kajioka-h   ���ʥޥ���Ʊ���ե饰����Ͽ��ǽ��
 *  2007/07/04      B0702-069   kajioka-h   �������˹����ʤθ�����ɽ������ʤ��Х�����
 *                  B0702-070   kajioka-h   POST�������Զ�ʬ���������ɽ�����֤ˤ�ɤ�Х�����
 *  2007/07/06      B0702-071   kajioka-h   ���ͤ˲��Ԥ���Ͽ����ȡ�ɽ������</ br>���դ���ɽ�������Х�����
 *                  xx-xxx      kajioka-h   �ĥ�å��������ñ���ע��ֱĶȸ����פ��ѹ�
 *  2007/07/23      B0702-074   kajioka-h   �����谸���ͤΥ��˥�������ϳ�콤��
 *  2007/08/01      �ݼ���57  kajioka-h   ���Ψ�������Ƚ��ô���Ԥ���Ͽ�Ǥ��ʤ��ʥ��顼�ˤʤ�ˤΤ���
 *  2009/09/22                  hashimoto-y �Ͱ������ʤ��ֻ�ɽ�����ѹ�
 */

$page_title = "��Է���ޥ���";
require_once("ENV_local.php");                    //�Ķ�����ե����� 
require_once(INCLUDE_DIR."error_msg_list.inc");   //���顼��å�����
require_once(INCLUDE_DIR."function_keiyaku.inc"); //�����Ϣ�δؿ�

//DB����³
$db_con = Db_Connect();

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
//�����ѿ�����
/****************************/
$client_id   = $_GET["client_id"];      //������
$get_con_id  = $_GET["contract_id"];    //�������ID
$client_h_id = $_SESSION["client_id"];  //������桼��ID
$rank_cd     = $_SESSION["fc_rank_cd"]; //�ܵҶ�ʬ������
$staff_id    = $_SESSION["staff_id"];   //�������ID

//ľ��󥯤����ܤ��Ƥ������ˤϡ�TOP�����Ф�
if(count($_GET) == 0){
	$jump = NULL;
	Get_ID_Check2($jump);
}

//������ID��hidden�ˤ���ݻ�����
if($_GET["client_id"] != NULL){
	$con_data2["hdn_client_id"] = $client_id;
	
}else{
	$client_id = $_POST["hdn_client_id"];
}

//�������ID��hidden�ˤ���ݻ�����
if($_GET["contract_id"] != NULL){
	$con_data2["hdn_con_id"] = $get_con_id;
}else{
	$get_con_id = $_POST["hdn_con_id"];
}

//����Ƚ��
Get_ID_Check3($client_id);
Get_ID_Check3($get_con_id);

/****************************/
//������Ƚ��ؿ�
/****************************/
Injustice_check($db_con,"trust",$get_con_id,$client_h_id);
Injustice_check($db_con,"trust_client",$get_con_id,$client_id);



//****************************
//������������
//****************************
//���ۤ�client_id������ʳƥ���åפ�������ޥ����˼�ư����Ͽ������ġ�
$sql = "SELECT client_id FROM t_client WHERE shop_id = $client_h_id AND act_flg = true;";
$result = Db_Query($db_con, $sql);
$toyo_id = pg_fetch_result($result, 0, 0);
//�ݤ��ʬ����
$sql  = "SELECT ";
$sql .= "   t_client.coax ";    
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $toyo_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);
$coax = $data_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�




/****************************/
//�������
/****************************/
//����ޥ���
$sql  = "SELECT ";
$sql .= "    t_contract.trust_line,";      //��No0
$sql .= "    t_contract.route,";           //��ϩ1
$sql .= "    t_staff1.staff_id,";          //ô����1 2
$sql .= "    t_staff1.sale_rate,";         //���Ψ1 3
$sql .= "    t_staff2.staff_id,";          //ô����2 4
$sql .= "    t_staff2.sale_rate,";         //���Ψ2 5
$sql .= "    t_staff3.staff_id,";          //ô����3 6
$sql .= "    t_staff3.sale_rate,";         //���Ψ3 7
$sql .= "    t_staff4.staff_id,";          //ô����4 8
$sql .= "    t_staff4.sale_rate,";         //���Ψ4 9
$sql .= "    t_contract.round_div,";       //����ʬ10
$sql .= "    t_contract.cycle,";           //����11
$sql .= "    t_contract.cycle_unit,";      //����ñ��12
$sql .= "    t_contract.cale_week,";       //��̾13
$sql .= "    t_contract.abcd_week,";       //ABCD��14
$sql .= "    t_contract.rday,";            //������15
$sql .= "    t_contract.week_rday,";       //��������16
$sql .= "    t_contract.stand_day,";       //�����17
$sql .= "    t_contract.act_trust_day,";   //������18
$sql .= "    t_contract.trust_note, ";     //����19
$sql .= "    t_contract.last_day,";        //��§�ǽ���20

$sql .= "    t_contract.contract_div,";    //�����ʬ21
$sql .= "    t_contract.trust_id,";        //������ID22
$sql .= "    t_contract.act_request_rate,";//��԰�����23
$sql .= "    t_contract.trust_ahead_note,";//�����谸����24
$sql .= "    t_contract.act_goods_id,";    //������ξ���ID25
$sql .= "    t_goods.goods_cd,";           //������ξ���CD26
$sql .= "    t_goods.goods_cname, ";       //������ξ���̾27
$sql .= "    t_contract.update_day, ";     //����ͭ����28
$sql .= "    t_contract.contract_eday,";   //����λ��29
$sql .= "    t_contract.state, ";           //�������30
$sql .= "    t_contract.act_div,";          //��԰�����31
$sql .= "    t_contract.act_request_price,";//��԰�����32
$sql .= "    t_contract.request_state, ";    //��԰������33
$sql .= "    t_contract.trust_sale_amount ";    //��԰������34

$sql .= "FROM ";                
$sql .= "    t_contract ";

$sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_contract.act_goods_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '0'";
$sql .= "        )AS t_staff1 ON t_staff1.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '1'";
$sql .= "        )AS t_staff2 ON t_staff2.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '2'";
$sql .= "        )AS t_staff3 ON t_staff3.contract_id = t_contract.contract_id ";

$sql .= "    LEFT JOIN ";
$sql .= "        (SELECT ";
$sql .= "             t_con_staff.contract_id,";
$sql .= "             t_staff.staff_id,";
$sql .= "             t_con_staff.sale_rate ";
$sql .= "         FROM ";
$sql .= "             t_con_staff ";
$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_con_staff.staff_id ";
$sql .= "         WHERE ";
$sql .= "             t_con_staff.staff_div = '3'";
$sql .= "        )AS t_staff4 ON t_staff4.contract_id = t_contract.contract_id ";

$sql .= "WHERE ";
$sql .= "    t_contract.contract_id = $get_con_id;";

$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);
//$data_list = Get_Data($result);
$data_list = Get_Data($result, "5");

//��No.�����Ƚ��
if($data_list[0][0] == NULL){
	//����ι�No.����MAX+1��ե�����˥��å�
	$sql  = "SELECT ";
	$sql .= "    COALESCE(MAX(trust_line), 0)+1 ";
	$sql .= "FROM ";
	$sql .= "    t_contract ";
	$sql .= "WHERE ";
	$sql .= "    trust_id = $client_h_id;";
	$result = Db_Query($db_con, $sql);
	$line_data = Get_Data($result);
	$con_data["form_line"] = $line_data[0][0];
}else{
	$con_data["form_line"] = $data_list[0][0];   //������ι�
}

//�������
//�����
if($data_list[0][31] == "2"){
	$daiko_price = Minus_Numformat($data_list[0][34])."��<br>(�����)";

//��
}elseif($data_list[0][31] == "3"){
	$daiko_price = Minus_Numformat($data_list[0][34])."��<br>(".$data_list[0][23]."%)";

//ȯ�����ʤ�
}else{
	$daiko_price = "̵��";
}

//��ϩ�����ꤵ��Ƥ������˷����ѹ�
if($data_list[0][1] != NULL){
	$data_list[0][1]                   = str_pad($data_list[0][1], 4, 0, STR_POS_LEFT); //��ϩ
	$con_data["form_route_load"][1]    = substr($data_list[0][1],0,2);  
	$con_data["form_route_load"][2]    = substr($data_list[0][1],2,2);
} 

$con_data["form_c_staff_id1"]        = $data_list[0][2];  //ô���ԣ�
$con_data["form_sale_rate1"]         = ($data_list[0][3] != null)? $data_list[0][3] : '100';  //���Ψ��
$con_data["form_c_staff_id2"]        = $data_list[0][4];  //ô���ԣ�
$con_data["form_sale_rate2"]         = $data_list[0][5];  //���Ψ��
$con_data["form_c_staff_id3"]        = $data_list[0][6];  //ô���ԣ�
$con_data["form_sale_rate3"]         = $data_list[0][7];  //���Ψ��
$con_data["form_c_staff_id4"]        = $data_list[0][8];  //ô���ԣ�
$con_data["form_sale_rate4"]         = $data_list[0][9];  //���Ψ��
$con_data["form_round_div1[]"]       = $data_list[0][10]; //����ʬ
$round_div_db                        = $data_list[0][10]; //����ʬ

$contract_day                        = $data_list[0][18]; //������
$con_data["form_note"]               = $data_list[0][19]; //����

$daiko_id                            = $data_list[0][22];  //������ID
$daiko_note                          = nl2br(htmlspecialchars($data_list[0][24]));    //�����谸����
//$daiko_price                         = $data_list[0][23];  //��԰�����
$state                               = $data_list[0][30];  //��԰�����
$request_state                       = $data_list[0][33];  //��԰�����

if($state == "1"){
	$state_val = "�����";
}else{
	$state_val = "���󡦵ٻ���";
}

//$con_data["daiko_check"]            = $data_list[0][21];    //�����ʬ
//$con_data["hdn_daiko_id"]           = $data_list[0][22];  
//$con_data["form_daiko_price"]       = $data_list[0][23];    //��԰�����
//$con_data["form_daiko_note"]        = $data_list[0][24];    //�����谸����
//$con_data["hdn_act_goods_id"]       = $data_list[0][25];    //������ξ���ID
//$con_data["form_act_goods_cd"]      = $data_list[0][26];    //������ξ���CD
//$con_data["form_act_goods_name"]    = $data_list[0][27];    //������ξ���̾


//����ʬȽ�� 
if($data_list[0][10] == 1){
	//���
	$con_data["form_abcd_week1"]      = $data_list[0][14];  //��̾��ABCD��
	$con_data["form_week_rday1"]      = $data_list[0][16];  //��������

}else if($data_list[0][10] == 2){
	//���
	$con_data["form_rday2"]           = $data_list[0][15];  //������

}else if($data_list[0][10] == 3){
	//���
	$con_data["form_cale_week3"]      = $data_list[0][13];  //��̾�ʣ�������
	$con_data["form_week_rday3"]      = $data_list[0][16];  //��������

}else if($data_list[0][10] == 4){
	//���
	$con_data["form_cale_week4"]      = $data_list[0][11];  //����
	//���������ѹ�
	switch($data_list[0][16]){
		case '1':
			$data_list[0][16] = '��';
			break;
		case '2':
			$data_list[0][16] = '��';
			break;
		case '3':
			$data_list[0][16] = '��';
			break;
		case '4':
			$data_list[0][16] = '��';
			break;
		case '5':
			$data_list[0][16] = '��';
			break;
		case '6':
			$data_list[0][16] = '��';
			break;
		case '7':
			$data_list[0][16] = '��';
			break;
	}
	$con_data["form_week_rday4"]      = $data_list[0][16];  //��������

}else if($data_list[0][10] == 5){
	//���
	$con_data["form_cale_month5"]     = $data_list[0][11];  //����
	$con_data["form_week_rday5"]      = $data_list[0][15];  //������

}else if($data_list[0][10] == 6){
	//���
	$con_data["form_cale_month6"]     = $data_list[0][11];  //����
	$con_data["form_cale_week6"]      = $data_list[0][13];  //��̾�ʣ�������
	$con_data["form_week_rday6"]      = $data_list[0][16];  //��������

//}else if($data_list[0][10] == 7 && $c_check != true){
}else if($data_list[0][10] == 7){
	//���(����§�����̤������ܤ��Ƥ����Ȥ��ϡ������ͤ�ͥ�褹��ٰʲ��ν����ϹԤ�ʤ�)
	
	$sql  = "SELECT ";
	$sql .= "    round_day ";                //�����
	$sql .= "FROM ";
	$sql .= "    t_round ";
	$sql .= "WHERE ";
	$sql .= "    contract_id = $get_con_id;";
	$result = Db_Query($db_con, $sql);
	$round_data = Get_Data($result);
	//��Ͽ���줿�����ʬhidden����������ͤ�����
	for($i=0;$i<count($round_data);$i++){
		$year = (int) substr($round_data[$i][0],0,4);
		$month = (int) substr($round_data[$i][0],5,2);
		$day = (int) substr($round_data[$i][0],8,2);
		
		$input_date = "check_".$year."-".$month."-".$day;
		//�ͤ���������٤���§���Υ����å���hidden�Ǻ���
		$form->addElement("hidden","$input_date","");
		//�ͤΥ��å�
		$con_data["$input_date"] = 1;
	}

	$last_day = $data_list[0][20];  //������κǽ���

}



$stand_ymd = explode('-',$data_list[0][17]);             //�����
$con_data["form_stand_day"]["y"] = $stand_ymd[0];
$con_data["form_stand_day"]["m"] = $stand_ymd[1];
$con_data["form_stand_day"]["d"] = $stand_ymd[2];

//$update_day = $data_list[0][28];
$update_ymd = explode('-',$data_list[0][28]);                  //����ͭ����
$con_data["form_update_day"]["y"] = $update_ymd[0];
$con_data["form_update_day"]["m"] = $update_ymd[1];
$con_data["form_update_day"]["d"] = $update_ymd[2];

//$contract_eday = $data_list[0][29];
$contract_ymd = explode('-',$data_list[0][29]);                  //����λ��
$con_data["form_contract_eday"]["y"] = $contract_ymd[0];
$con_data["form_contract_eday"]["m"] = $contract_ymd[1];
$con_data["form_contract_eday"]["d"] = $contract_ymd[2];


/****************************/
//�������ƥơ��֥�
/****************************/
$sql  = "SELECT ";
$sql .= "    t_con_info.line,";                  //�Կ�0
$sql .= "    t_con_info.divide, ";               //�����ʬ1
$sql .= "    t_con_info.serv_pflg,";             //�����ӥ������ե饰2
$sql .= "    t_con_info.serv_id,";               //�����ӥ�ID3

$sql .= "    t_con_info.goods_pflg,";            //�����ƥ�����ե饰4
$sql .= "    t_con_info.goods_id,";              //�����ƥ�ID5
$sql .= "    t_item.goods_cd,";                  //�����ƥ�CD6
$sql .= "    t_item.name_change,";               //�����ƥ���̾�ѹ�7
$sql .= "    t_con_info.goods_name,";            //�����ƥ�̾��ά�Ρ�8
$sql .= "    t_con_info.num,";                   //�����ƥ��9

$sql .= "    t_con_info.set_flg,";               //�켰�ե饰10
$sql .= "    t_con_info.trust_cost_price,";     //�Ķȸ���11
$sql .= "    t_con_info.sale_price,";            //���ñ��12
//$sql .= "    t_con_info.trust_trade_amount,";    //�Ķȶ��13   
$sql .= "    t_con_info.trust_cost_amount,";    //�Ķȶ��13   
$sql .= "    t_con_info.sale_amount,";           //�����14  

$sql .= "    t_con_info.rgoods_id,";             //����ID15
$sql .= "    t_body.goods_cd,";                  //����CD16
$sql .= "    t_body.name_change,";               //������̾�ѹ�17
$sql .= "    t_con_info.rgoods_name,";           //����̾18
$sql .= "    t_con_info.rgoods_num,";            //���ο�19

$sql .= "    t_con_info.egoods_id,";             //������ID20
$sql .= "    t_expend.goods_cd,";                //������CD21
$sql .= "    t_expend.name_change,";             //��������̾�ѹ�22
$sql .= "    t_con_info.egoods_name,";           //������̾23
$sql .= "    t_con_info.egoods_num,";            //�����ʿ�24

$sql .= "    t_con_info.account_price,";         //����ñ��25
$sql .= "    t_con_info.account_rate, ";         //����Ψ26
$sql .= "    t_con_info.con_info_id, ";          //��������ID27
$sql .= "    t_con_info.official_goods_name, ";  //�����ƥ�̾��������28
$sql .= "    t_con_info.trust_mst_sync_flg, ";    //�ʼ������ѡ˥ޥ���Ʊ���ե饰29

#2009-09-22 hashimoto-y
$sql .= "    t_item.discount_flg ";                  //�Ͱ����ե饰30

$sql .= "FROM ";
$sql .= "    t_con_info ";
$sql .= "    LEFT JOIN t_goods AS t_item ON t_item.goods_id = t_con_info.goods_id ";
$sql .= "    LEFT JOIN t_goods AS t_body ON t_body.goods_id = t_con_info.rgoods_id ";
$sql .= "    LEFT JOIN t_goods AS t_expend ON t_expend.goods_id = t_con_info.egoods_id ";

$sql .= "WHERE ";
$sql .= "    contract_id = $get_con_id; ";
$result = Db_Query($db_con, $sql);
$sub_data = Get_Data($result);

//���Ͼ��ʹԿ�
$input_row = NULL;
$input_row2 = NULL;

$break_part_flg = false;       //�����ǡ���¸��Ƚ��ե饰

//����ID�˳�������ǡ�����¸�ߤ��뤫
for($s=0;$s<count($sub_data);$s++){
	$search_line = $sub_data[$s][0];   //���������
	$input_row[] = $search_line;       //���������

	//���¶�ʬ�ν���ͤ����ꤷ�ʤ�������
	$aprice_array[] = $search_line;

	//$con_data["form_divide"][$search_line]                = $sub_data[$s][1];   //�����ʬ
	$form_divide[$search_line]                = $sub_data[$s][1];   //�����ʬ


	//�����å��դ��뤫Ƚ��
	if($sub_data[$s][2] == 't'){
		$print_flg[1][$search_line]   = "��";    //�����ӥ������ե饰

	}else{
		$print_flg[1][$search_line]   = "��";
	}
	$con_data["form_serv"][$search_line]                  = $sub_data[$s][3];    //�����ӥ�

	//�����å��դ��뤫Ƚ��
	if($sub_data[$s][4] == 't'){
		$print_flg[2][$search_line]   = "��";    //�����ƥ���ɼ�����ե饰
	}else{
		$print_flg[2][$search_line]   = "��";
	}
	
	$con_data["hdn_goods_id1"][$search_line]              = $sub_data[$s][5];    //�����ƥ�ID
	$goods_cd[1][$search_line]                            = $sub_data[$s][6];    //�����ƥ�CD
	$goods_name[1][$search_line]                          = $sub_data[$s][8];    //�����ƥ�̾��ά�Ρ�
	$official_goods_name[$search_line]                    = $sub_data[$s][28];   //�����ƥ�̾��������
	$con_data["form_goods_num1"][$search_line]            = $sub_data[$s][9];    //�����ƥ��


	//�����å��դ��뤫Ƚ��
	if($sub_data[$s][10] == 't'){
		$con_data2["form_issiki"][$search_line]       = "�켰";                   //�켰�ե饰
		//$issiki[$search_line]       = "�켰";                   //�켰�ե饰
	}

	//����Ƚ��
	if($sub_data[$s][9] != NULL && $sub_data[$s][10] == 't'){
		//���̤Ȱ켰�ξ��ϡ��֤˲��Ԥ򤤤��
		$br_flg = 'true';
	}

	//�������αĶ�ñ���Ͼ��ʥޥ����򻲾�
	if($request_state == "1"){
		//�Ķȸ���
		$cost_price = Get_Goods_Price($db_con,$sub_data[$s][5]);
		$c_price = explode('.', $cost_price);                                //���ñ��
		$con_data["form_trade_price"][$search_line]["1"] = $c_price[0];  
		$con_data["form_trade_price"][$search_line]["2"] = $c_price[1];
	
		$c_price = bcmul($cost_price, $sub_data[$s][9],2);
		$c_price = Coax_Col($coax, $c_price);
		$con_data["form_trade_amount"][$search_line]  = number_format($c_price);  //�Ķȶ��

	//�����Ѥξ�����Ͽ�ѥǡ�����ɽ��
	}else{
		$cost_price = explode('.', $sub_data[$s][11]);                                //�Ķȸ���
		$con_data["form_trade_price"][$search_line]["1"] = $cost_price[0];  
		$con_data["form_trade_price"][$search_line]["2"] = $cost_price[1];  
		//$con_data["form_trade_price"][$search_line]["2"] = ($cost_price[1] != null)? $cost_price[1] : ($cost_price[0] != null)? '00' : '';    
		//�Ķȶ�ۻ���Ƚ��
		if($sub_data[$s][13] != NULL){
			$con_data["form_trade_amount"][$search_line]    = number_format($sub_data[$s][13]);  //�Ķȶ��
		}

	}

	//���ñ��	
	$sale_price_db = explode('.', $sub_data[$s][12]);                            
	$sale_price_int           = number_format($sale_price_db[0]);  
	$sale_price_decimal       = ($sale_price_db[1] != null)? $sale_price_db[1] : '00';	
	$sale_price[$search_line] = $sale_price_int.".".$sale_price_decimal;

	//�����
	$sale_amount[$search_line]     = number_format($sub_data[$s][14]);

	$con_data["hdn_goods_id2"][$search_line]              = $sub_data[$s][15];    //����ID
	$goods_cd[2][$search_line]             = $sub_data[$s][16];    //����CD
	$goods_name[2][$search_line]           = $sub_data[$s][18];    //����̾
	$goods_num[2][$search_line]            = $sub_data[$s][19];    //���ο�


	$con_data["hdn_goods_id3"][$search_line]              = $sub_data[$s][20];    //������ID
	$goods_cd[3][$search_line]             = $sub_data[$s][21];    //������CD
	$goods_name[3][$search_line]           = $sub_data[$s][23];    //������̾
	$goods_num[3][$search_line]            = $sub_data[$s][24];    //�����ʿ�

	$mst_sync_data["mst_sync_flg"][$search_line] = ($sub_data[$s][29] == "t") ? "1" : "";   //�ʼ�����˥ޥ���Ʊ���ե饰

    #2009-09-22 hashimoto-y
    $con_data["hdn_discount_flg"][$search_line]           = $sub_data[$s][30];    //�Ͱ����ե饰

}
$form->setDefaults($con_data);

/****************************/
//������������
/****************************/
//���ۤ�client_id������ʳƥ���åפ�������ޥ����˼�ư����Ͽ������ġ�
$sql = "SELECT client_id FROM t_client WHERE shop_id = $client_h_id AND act_flg = true;";
$result = Db_Query($db_con, $sql);
$toyo_id = pg_fetch_result($result, 0, 0);
//�ݤ��ʬ����
$sql  = "SELECT ";
$sql .= "   t_client.coax ";    
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $toyo_id";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$data_list = Get_Data($result);
$coax = $data_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�

//������ξ�������
$sql  = "SELECT";
$sql .= "   t_client.client_cname,";
$sql .= "   t_client.intro_ac_name,";
$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
$sql .= "   t_client.trade_id,";
$sql .= "   t_client.tax_franct,";
$sql .= "   t_client.client_cd1, ";
$sql .= "   t_client.client_cd2,";
$sql .= "   t_client.d_staff_id1,";
$sql .= "   t_client.d_staff_id2,";
$sql .= "   t_client.d_staff_id3 ";
$sql .= " FROM";
$sql .= "   t_client ";
$sql .= "   LEFT JOIN t_client_info ON t_client.client_id = t_client_info.client_id ";
$sql .= " WHERE";
$sql .= "   t_client.client_id = $client_id";
$sql .= ";";

$result = Db_Query($db_con, $sql); 
Get_Id_Check($result);
$data_list = Get_Data($result);

$cname           = $data_list[0][0];        //�ܵ�̾
//$ac_name         = $data_list[0][1];        //�Ҳ������
$client_cd       = $data_list[0][2];        //������CD
$trade_id        = $data_list[0][3];        //���������
$tax_franct      = $data_list[0][4];        //�����ǡ�ü����ʬ��
$client_cd1      = $data_list[0][5];        //������CD1
$client_cd2      = $data_list[0][6];        //������CD2
$staff1          = $data_list[0][7];        //���ô���ԣ�
$staff2          = $data_list[0][8];        //���ô���ԣ�
$staff3          = $data_list[0][9];       //���ô���ԣ�
//$form_client = $client_cd1."-".$client_cd2." ".htmlspecialchars($cname); //������̾
$form_client = $client_cd1."-".$client_cd2." ".$cname; //������̾

//POST�����ѹ�
//$con_data2["hdn_coax"]            = $coax;
$con_data2["client_search_flg"]   = "";
//$con_data2["form_client"]["cd1"]  = $client_cd1;
//$con_data2["form_client"]["cd2"]  = $client_cd2;
//$con_data2["form_client"]["name"] = $cname;


/****************************/
//�����ʬ��̵����票�顼ɽ���ʸ�Ǥ��ν����Ϻ����
/****************************/
if($trade_id == NULL){
	$trade_error_flg = true;
}


//��§�����̤������� or �����������˲��̹���
if( $c_check == true || $_POST[renew_flg] == "1" ){

	//�����
	$y_day = str_pad($_POST["form_stand_day"]["y"],4,0,STR_PAD_LEFT);
	$m_day = str_pad($_POST["form_stand_day"]["m"],2,0,STR_PAD_LEFT);
	$d_day = str_pad($_POST["form_stand_day"]["d"],2,0,STR_PAD_LEFT);
	$stand_day = $y_day."-".$m_day."-".$d_day;    //��ȴ����

	//����ͭ��������
	if($_POST["form_update_day"]["y"] !="" && $_POST["form_update_day"]["m"]!="" && $_POST["form_update_day"]["d"]!="" ){
		$update_ymd[0] = str_pad($_POST["form_update_day"]["y"],4,0,STR_PAD_LEFT);
		$update_ymd[1] = str_pad($_POST["form_update_day"]["m"],2,0,STR_PAD_LEFT);
		$update_ymd[2] = str_pad($_POST["form_update_day"]["d"],2,0,STR_PAD_LEFT);
		$update_day = $update_ymd[0]."-".$update_ymd[1]."-".$update_ymd[2]; 
	}

	//����λ������
	if($_POST["form_contract_eday"]["y"] !="" && $_POST["form_contract_eday"]["m"]!="" && $_POST["form_contract_eday"]["d"]!="" ){
		$contract_ymd[0] = str_pad($_POST["form_contract_eday"]["y"],4,0,STR_PAD_LEFT);
		$contract_ymd[1] = str_pad($_POST["form_contract_eday"]["m"],2,0,STR_PAD_LEFT);
		$contract_ymd[2] = str_pad($_POST["form_contract_eday"]["d"],2,0,STR_PAD_LEFT);
		$contract_eday = $contract_ymd[0]."-".$contract_ymd[1]."-".$contract_ymd[2];
	}

}

/****************************/
//���ꥢ�ܥ��󲡲�����
/****************************/
if($_POST["clear_flg"] == true){
	//����������ƽ����
	for($c=1;$c<=5;$c++){
		$con_data2["form_trade_price"][$c]["1"] = "";
		$con_data2["form_trade_price"][$c]["2"] = "";
		$con_data2["form_trade_amount"][$c]     = "";

        $con_data2["mst_sync_flg"][$c]          = "";
	}
	
	$post_flg2 = true;                //���¶�ʬ�򡢽��������ե饰
	$con_data2["clear_flg"] = "";    //���ꥢ�ܥ��󲡲��ե饰
}

/****************************/
//POST�ǡ�������
/****************************/
$line  = $_POST["form_line"];            //��No

$trade_amount = NULL;                    //�Ķȶ�۽����
//$sale_amount = NULL;                     //����۽����

//5��ʬ����
for($s=1;$s<=5;$s++){

	//$divide[$s]  = $_POST["form_divide"][$s];        //�����ʬ
	$serv_id[$s] = $_POST["form_serv"][$s];          //�����ӥ�ID

	$set_flg[$s] = $_POST["form_issiki"][$s];        //�켰�ե饰1
	if($set_flg[$s] == NULL){
		$set_flg[$s] = 'false';
	}else{
		$set_flg[$s] = 'true';
	}

	//�Ķȸ���
	$t_price1 = $_POST["form_trade_price"][$s][1]; 
	$t_price2 = $_POST["form_trade_price"][$s][2];
	$trade_price[$s] = $t_price1.".".$t_price2;

	//���ñ��
	//$s_price1 = $_POST["form_sale_price"][$s][1]; 
	//$s_price2 = $_POST["form_sale_price"][$s][2]; 
	//$sale_price[$s] = $s_price1.".".$s_price2;

	//��۷׻�����Ƚ��
	if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] != null){
	//�켰�������̡��ξ�硢�Ķȶ�ۤϡ�ñ���߿��̡�����ۤϡ�ñ���ߣ�
		//�Ķȶ��
		$trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
		$trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);

		//�����
		//$sale_amount[$s] = bcmul($sale_price[$s], 1,2);
		//$sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
	
	//�켰�������̡ߤξ�硢ñ���ߣ�
	}else if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] == null){
		//�Ķȶ��
		$trade_amount[$s] = bcmul($trade_price[$s], 1,2);
		$trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);

		//�����
		//$sale_amount[$s] = bcmul($sale_price[$s], 1,2);
		//$sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
	
	//�켰�ߡ����̡��ξ�硢ñ���߿���
	}else if($set_flg[$s] == 'false' && $_POST["form_goods_num1"][$s] != null){
		//�Ķȶ��
		$trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
		$trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);

		//�����
		//$sale_amount[$s] = bcmul($sale_price[$s], $_POST["form_goods_num1"][$s],2);
		//$sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
	}

	$trust_trade_amount = $trust_trade_amount+$trade_amount[$s];


    //�ޥ���Ʊ���ե饰
    $trust_mst_sync_flg[$s] = ($_POST["mst_sync_flg"][$s] != null) ? "true" : "false";
    $mst_sync_data2[$s]     = ($_POST["mst_sync_flg"][$s] != null) ? "1" : "";

}

$route  = $_POST["form_route_load"][1];      //��ϩ
$route .= $_POST["form_route_load"][2];

//���ô��������
$staff_check = NULL;                            //��ʣȽ������
$staff_rate = NULL;                             //���Ψ��Ͽ������

$staff1         = $_POST["form_c_staff_id1"];   //���ô����
$staff_check[0] = $staff1;
$rate1          = $_POST["form_sale_rate1"];    //���Ψ��
$staff_rate[0]  = $rate1;

$staff2 = $_POST["form_c_staff_id2"];           //���ô����
//�����ͤ�������˽�ʣȽ�����������
if($staff2 != NULL){
	$staff_check[1] = $staff2;
}
$rate2 = $_POST["form_sale_rate2"];             //���Ψ��
$staff_rate[1] = $rate2;

$staff3 = $_POST["form_c_staff_id3"];           //���ô����
//�����ͤ�������˽�ʣȽ�����������
if($staff3 != NULL){
	$staff_check[2] = $staff3;
}
$rate3 = $_POST["form_sale_rate3"];          //���Ψ��
$staff_rate[2] = $rate3;

$staff4 = $_POST["form_c_staff_id4"];        //���ô����
//�����ͤ�������˽�ʣȽ�����������
if($staff4 != NULL){
	$staff_check[3] = $staff4;
}
$rate4 = $_POST["form_sale_rate4"];          //���Ψ��
$staff_rate[3] = $rate4;

$note = $_POST["form_note"];                 //����


//������ǡ�������
//�ܵ��褬�ѹ����줿��硢���������٤��������ʤ�
$round_div = $_POST["form_round_div1"][0][0];     //����ʬ

//����ʬȽ�� 
if($round_div == 1){
	//���
	$abcd_week = $_POST["form_abcd_week1"];       //��̾��ABCD��
	$week_rday = $_POST["form_week_rday1"];       //��������

}else if($round_div == 2){
	//���
	$rday = $_POST["form_rday2"];                 //������

}else if($round_div == 3){
	//���
	$cale_week = $_POST["form_cale_week3"];       //��̾�ʣ�������
	$week_rday = $_POST["form_week_rday3"];       //��������

}else if($round_div == 4){
	//���
	$cycle_unit = "W";    //����ñ��
	$cycle      = $_POST["form_cale_week4"];      //����
	$week_rday  = $_POST["form_week_rday4"];      //��������
	//���������ѹ�
	switch($week_rday){
		case '��':
			$week_rday = 1;
			break;
		case '��':
			$week_rday = 2;
			break;
		case '��':
			$week_rday = 3;
			break;
		case '��':
			$week_rday = 4;
			break;
		case '��':
			$week_rday = 5;
			break;
		case '��':
			$week_rday = 6;
			break;
		case '��':
			$week_rday = 7;
			break;
	}

}else if($round_div == 5){
	//���
	$cycle_unit = "M";   //����ñ��
	$cycle      = $_POST["form_cale_month5"];     //����
	$rday       = $_POST["form_week_rday5"];      //������

}else if($round_div == 6){
	//���
	$cycle_unit = "M";   //����ñ��
	$cycle      = $_POST["form_cale_month6"];     //����
	$cale_week  = $_POST["form_cale_week6"];      //��̾�ʣ�������
	$week_rday  = $_POST["form_week_rday6"];      //��������

}


//5��ʬ����
for($s=1;$s<=5;$s++){
	//�����󥢥��ƥ�
	$goods_item_id[$s] = $_POST["hdn_goods_id1"][$s];                   //����ID
	//����Ƚ��
	if($goods_item_id[$s] != NULL){

		//$goods_item_name[$s] = $_POST["form_goods_name1"][$s];          //����̾
		//$goods_item_num[$s] = $_POST["form_goods_num1"][$s];            //����
		//$goods_item_flg[$s] = $_POST["form_print_flg2"][$s];            //��ɼ�����ե饰
		if($goods_item_flg[$s] == NULL){
			$goods_item_flg[$s] = 'false';
		}else{
			$goods_item_flg[$s] = 'true';
		}

		$sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$s].";";
		$result = Db_Query($db_con, $sql);
		$goods_item_com[$s] = pg_fetch_result($result,0,0);          //�����ʥե饰

		//������Ƚ��
		if($goods_item_com[$s] == 'f'){
			//�����ʤǤ�̵����硢Ǽ�ʥե饰��false
			$goods_item_deli[$s] = 'false';
		}else{
			//�ƹ����ʤξ��ʾ������
			$sql  = "SELECT ";
			$sql .= "    parts_goods_id ";                       //������ID
			$sql .= "FROM ";
			$sql .= "    t_compose ";
			$sql .= "WHERE ";
			$sql .= "    goods_id = ".$goods_item_id[$s].";";
			$result = Db_Query($db_con, $sql);
			$item_parts[$s] = Get_Data($result);

			//�ƹ����ʤο��̼���
			for($i=0;$i<count($item_parts[$s]);$i++){
				$sql  = "SELECT ";
				$sql .= "    t_goods.goods_name,";
				$sql .= "    t_goods.goods_cname,";
				$sql .= "    t_compose.count ";
				$sql .= "FROM ";
				$sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
				$sql .= "WHERE ";
				$sql .= "    t_compose.goods_id = ".$goods_item_id[$s]." ";
				$sql .= "AND ";
				$sql .= "    t_compose.parts_goods_id = ".$item_parts[$s][$i][0].";";
				$result = Db_Query($db_con, $sql);
				$item_parts_name[$s][$i] = pg_fetch_result($result,0,0);    //����̾
				$item_parts_cname[$s][$i] = pg_fetch_result($result,0,1);   //ά��
				$parts_num = pg_fetch_result($result,0,2);                  //�����ʤ��Ф������
				$item_parts_num[$s][$i] = $parts_num * $goods_item_num[$s]; //����
			}
		}
	}
}

/****************************/
//�������
/****************************/
//�֥ե��������ǿ��ѹ��סܡ�Ⱦ�ѱѿ����󤻡�
$form_option_num = $g_form_option." style=\"ime-mode:disabled;text-align:right;\"";

//������
$form->addElement("static","form_daiko_price","������","$daiko_price");

//�������
$form->addElement("static","state","�������","$state_val");

//�ܵ�̾
$form->addElement("static","form_client","�ܵ�̾","$form_client");

//������
$form->addElement("static","form_contract_day","������","$contract_day");

//�����谸����
$form->addElement("static","form_daiko_note","�����谸����","$daiko_note");


//NO
$form->addElement("text","form_line","�ƥ����ȥե�����",'size="3" maxLength="3" '.$form_option_num);

//���ô��
$form_c_staff_id = Select_Get($db_con,'round_staff_m');
$form->addElement('select', 'form_c_staff_id1', '���쥯�ȥܥå���', $form_c_staff_id, $g_form_option_select);
$form->addElement('select', 'form_c_staff_id2', '���쥯�ȥܥå���', $form_c_staff_id, $g_form_option_select);
$form->addElement('select', 'form_c_staff_id3', '���쥯�ȥܥå���', $form_c_staff_id, $g_form_option_select);
$form->addElement('select', 'form_c_staff_id4', '���쥯�ȥܥå���', $form_c_staff_id, $g_form_option_select);


//���
$form->addElement("text","form_sale_rate1","�ƥ����ȥե�����",'size="3" maxLength="3"'.$form_option_num);
$form->addElement("text","form_sale_rate2","�ƥ����ȥե�����",'size="3" maxLength="3"'.$form_option_num);
$form->addElement("text","form_sale_rate3","�ƥ����ȥե�����",'size="3" maxLength="3"'.$form_option_num);
$form->addElement("text","form_sale_rate4","�ƥ����ȥե�����",'size="3" maxLength="3"'.$form_option_num);

//��ϩ
$form_route[] =& $form->createElement("text","1","�ƥ����ȥե�����",'style="ime-mode:disabled;" size="1" maxLength="2" onkeyup="changeText(this.form,\'form_route_load[1]\',\'form_route_load[2]\',2)" '.$g_form_option);
$form_route[] =& $form->createElement("text","2","�ƥ����ȥե�����",'style="ime-mode:disabled;" size="1" maxLength="2" '.$g_form_option);
$form->addGroup( $form_route,"form_route_load","form_route_load","-");

//����
$form->addElement("textarea","form_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area);

//���̹����ե饰
$form->addElement("hidden","renew_flg","1"); 

//��Բ��̥ե饰����§��������ɥ�������������椹�뤿��˻��ѡ�
$form->addElement("hidden","daiko_page_flg","1"); 

$num = 5;
#2009-09-22 hashimoto-y
for($i = 0; $i < $num; $i++){
    $form->addElement("hidden","hdn_discount_flg[$i]");
}



/**************************************************
�����
**************************************************/
$num = 5;
$type = $g_form_option;
$array_divide = Select_Get($db_con, "divide_con");
for ($i=1; $i<=$num; $i++){


    #2009-09-22 hashimoto-y
    //�Ͱ����ʤ����򤷤����ˤ��ֻ����ѹ�
    $font_color = "";

    if($con_data["hdn_discount_flg"][$i] === 't'){
        $font_color = "color: red; ";
    //$set_goods_data������POST��ͭ����Ͼ��ʥ����ɤ��ѹ��Ϥ���Ƥ��ʤ�
    }elseif( $con_data["form_goods_cd"][$i] == "" && $_POST["hdn_discount_flg"][$i] === 't'
    ){
        $font_color = "color: red; ";

    }else{
        $font_color = "color: #000000; ";
    }


	//�����ʬ
	$divide_value = $form_divide[$i];
	$form->addElement('static', "form_divide[".$i."]", "", $array_divide[$divide_value]);
	
	//�����ӥ�
	$array_serv = Select_Get($db_con, "serv_con");
	$freeze_data2 = $form->addElement('select', "form_serv[".$i."]", "", $array_serv, $g_form_option_select);
	$freeze_data2->freeze();

	//�켰
	//$form->addElement('static', "form_issiki[".$i."]", "", $array_divide[$divide_value]);
	$freeze_data2 = $form->addElement( "text","form_issiki[".$i."]" ,"" ,"");
	$freeze_data2->freeze();


	for($s=1;$s<=3;$s++){

		//��ɼ����
		$form->addElement("static","form_print_flg".$s."[$i]","����̾",$print_flg[$s][$i]);

		//���ʥ�����      
		$form->addElement("static","form_goods_cd".$s."[$i]","���ʥ�����",$goods_cd[$s][$i]);
		//����̾
		$form->addElement("static","form_goods_name".$s."[$i]","����̾��ά�Ρ�",$goods_name[$s][$i]);
		$form->addElement("static","official_goods_name"."[$i]","����̾��������",$official_goods_name[$i]);

		//���ʿ��ʥ����ƥ�ξ���
		if($s == "1"){
			$form->addElement(
		        "text","form_goods_num".$s."[$i]","",
		        " size=\"3\" maxLength=\"3\" class=\"money_num\" 
			    style=\"$font_color 
				border : #ffffff 1px solid; 
				background-color: #ffffff; 
				text-align: right\" readonly'"
		    );

		//�����ʡ����ξ��ʤξ��
		}else{
			$form->addElement("static","form_goods_num".$s."[$i]","����",$goods_num[$s][$i]);
		}

		//����ID
		$form->addElement("hidden","hdn_goods_id".$s."[$i]");
		//��̾�ѹ��ե饰
		//$form->addElement("hidden","hdn_name_change".$s."[$i]");

	}

	//�Ķȸ���
	$form_cost_price[$i][] =& $form->createElement(
	        "text","1","",
	        "size=\"9\" maxLength=\"8\"
	        class=\"money\"
	        onKeyup=\"Mult2('form_goods_num1[$i]','form_trade_price[$i][1]','form_trade_price[$i][2]','form_trade_amount[$i]','form_issiki[$i]','$coax',false);\"
	        style=\"$font_color $g_form_style;text-align: right; $style\"
	        $type"
	    );
	    $form_cost_price[$i][] =& $form->createElement(
	        "text","2","","size=\"1\" maxLength=\"2\" 
	        onKeyup=\"Mult2('form_goods_num1[$i]','form_trade_price[$i][1]','form_trade_price[$i][2]','form_trade_amount[$i]','form_issiki[$i]','$coax',true);\"
	        style=\"$font_color $g_form_style;text-align: left; $style\"
	        $type"
	    );
    $form->addGroup( $form_cost_price[$i], "form_trade_price[$i]", "",".");

	//������׳�
    $form->addElement(
        "text","form_trade_amount[$i]","",
        "size=\"17\" maxLength=\"10\" 
        style=\"$font_color 
        border : #ffffff 1px solid; 
        background-color: #ffffff; 
        text-align: right\" readonly'"
    );

	//���ñ��
	$form->addElement('static', "form_sale_price[".$i."]", "", $sale_price[$i] );

	//����׳�
	$form->addElement('static', "form_sale_amount[".$i."]", "", $sale_amount[$i]);

    //�ޥ����Ȥ�Ʊ��
    $form->addElement("checkbox", "mst_sync_flg[".$i."]");

}
$freeze_list = $form->addGroup($freeze_data,"freeze_list", "");
$freeze_list->freeze();

/**************************************************
�����
**************************************************/
//���쥯�ȥܥå�����
//ABCD��
$array_abcd_week = array(
	"" => "",
	"1" => "A��(4���ֳ�)",
	"2" => "B��(4���ֳ�)",
	"3" => "C��(4���ֳ�)",
	"4" => "D��(4���ֳ�)",
	"5" => "A , C��(2���ֳ�)",
	"6" => "B , D��(2���ֳ�)",
	"21" => "A��(8���ֳ�)",
	"22" => "B��(8���ֳ�)",
	"23" => "C��(8���ֳ�)",
	"24" => "D��(8���ֳ�)",
	
);

//���̤ν�
$array_week = array(
	"" => "",
	"1" => "1",
	"2" => "2",
	"3" => "3",
	"4" => "4"
);

//�����ּ���
$array_while_week = array(
	""   => "",
	"1"  => "1",
	"2"  => "2",
	"3"  => "3",
	"4"  => "4",
	"5"  => "5",
	"6"  => "6",
	"7"  => "7",
	"8"  => "8",
	"9"  => "9",
	"12" => "12",
	"18" => "18",
	"24" => "24"
);

//52���ּ���
$array_while_week2[""] = "";
for($w=1;$w<=52;$w++){
	$array_while_week2["$w"] = $w;
}

//1��29���ܷ���
$array_week_interval[0] = "";
for($i=1;$i<29;$i++){
	$array_week_interval[$i] = $i;
}
$array_week_interval[30] = '����';


//����
$array_week_rday = array(
	"" => "",
	"1" => "��",
	"2" => "��",
	"3" => "��",
	"4" => "��",
	"5" => "��",
	"6" => "��",
	"7" => "��"
);


$need_mark = "<b><font color=\"#ff0000\">��</font></b>";
$readonly = "style=\"border : #ffffff 1px solid; background-color: #ffffff;\" readonly";

//javascript(���դ˹�碌��������ɽ������)
$option =" onkeyup=\"date_week(this.form,'form_update_day[y]','form_update_day[m]','form_update_day[d]','form_week_rday4')\"";
$option.=" onClick=\"date_week(this.form,'form_update_day[y]','form_update_day[m]','form_update_day[d]','form_week_rday4')\"";

//����ȯ����
Addelement_Date($form,"form_stand_day","����ȯ����<b>��</b>","-","y","m","d","$readonly");
//����ȯ����
Addelement_Date($form,"form_update_day","����ȯ����".$need_mark,"-","y","m","d","$option");

//����λ��
Addelement_Date($form,"form_contract_eday","����λ��<b>��</b>","-");

//�����(1)
$form->addElement('select', 'form_abcd_week1', '���쥯�ȥܥå���', $array_abcd_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday1', '���쥯�ȥܥå���', $array_week_rday, $g_form_option_select);

//�����(2)
$form->addElement('select', 'form_rday2', '���쥯�ȥܥå���', $array_week_interval, $g_form_option_select);

//�����(3)
$form->addElement('select', 'form_cale_week3', '���쥯�ȥܥå���', $array_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday3', '���쥯�ȥܥå���', $array_week_rday, $g_form_option_select);

//�����(4)
$form->addElement('select', 'form_cale_week4', '���쥯�ȥܥå���', $array_while_week2, $g_form_option_select);
$form->addElement("text","form_week_rday4","�ƥ����ȥե�����",'size="1" maxLength="2" class="Textbox_readonly" readonly');

//�����(5)
$form->addElement('select', 'form_cale_month5', '���쥯�ȥܥå���', $array_while_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday5', '���쥯�ȥܥå���', $array_week_interval, $g_form_option_select);

//�����(6)
$form->addElement('select', 'form_cale_month6', '���쥯�ȥܥå���', $array_while_week, $g_form_option_select);
$form->addElement('select', 'form_cale_week6', '���쥯�ȥܥå���', $array_week, $g_form_option_select);
$form->addElement('select', 'form_week_rday6', '���쥯�ȥܥå���', $array_week_rday, $g_form_option_select);

//�����(7)
$form->addElement(
    "link","form_irr_day","","#","��§��",
	"onClick=\"javascript:return Submit_Page2('./2-1-105.php?flg=$flg&client_id=$client_id&contract_id=$get_con_id'); \""
);


//������饸���ܥ���
for($i=0;$i<7;++$i){
	$form_round_div1 = "";
	$r_value = $i+1;
	$form_round_div1[] =& $form->createElement("radio", NULL,NULL, "($r_value)", $r_value,"onClick=\"return Check_read('$r_value');\"");
	$form->addGroup($form_round_div1, "form_round_div1[]");
}

/****************************/
//��§���ǡ�������
/****************************/
$date_array = NULL;
//POST�ǡ�����������
$year  = date("Y");
$month = date("m");

for($i=0;$i<28;$i++){
	//�����������
	$now = mktime(0, 0, 0, $month+$i,1,$year);
	$num = date("t",$now);

	//2ǯʬ�ǡ�������
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
			//POST�κǽ�����ͥ�褹��ե饰
			$last_flg = true;
		}
	}
}
//���̤˥����å����դ����Ǹ������ɽ��
if($last_flg == true){
	$last_day = $date_array[count($date_array)-1];
}

$form->addElement("button","entry_button","�С�Ͽ","onClick=\"return Dialogue_2('��Ͽ���ޤ���','2-1-240.php?client_id=$client_id',true,'entry_flg');\" $disabled");
$form->addElement("button","form_back","�ᡡ��","onClick=\"location.href='./2-1-239.php'\"");
$form->addElement("button","clear_button","���ꥢ","onClick=\"insert_row('clear_flg');\"");

$form->addElement("hidden", "entry_flg");           //��Ͽ�ܥ��󲡲��ե饰    
$form->addElement("hidden", "hdn_con_id");          //�������ID
$form->addElement("hidden", "hdn_client_id");       //������
$form->addElement("hidden", "clear_flg");           //���ꥢȽ��ե饰
$form->addElement("hidden", "duplicat_ok");         //��ʣ��ɼOK

//�ʲ��ϲ��̤�ɽ�����ʤ��ʥ��顼ɽ���Τ���˺�����
$form->addElement("text","sale_rate_sum","");
$form->addElement("text","staff_uniq","");
//$form->addElement("text","goods_enter","");
$form->addElement("text","hensoku_err","");


/****************************/
//����ޥ�����Ͽ
/****************************/
if($_POST["entry_flg"] == true){

	/****************************/
	//���顼�����å�(addRule)
	/****************************/
	//���ô���ʥᥤ���
	$form->addRule('form_c_staff_id1',$h_mess[8],'required');
	$form->addRule('form_sale_rate1',$h_mess[8],'required');
	
	//���֣�
	//��ô���Ԥ����Ψ��ξ�����Ϥ���Ƥ��뤫
	if($staff2 == NULL && $rate2 != NULL){
		$form->addRule('form_c_staff_id2',$h_mess[9],'required');
	}
	if($staff2 != NULL && $rate2 == NULL && ((int)$rate1 + (int)$rate3 + (int)$rate4) != 100){
		$form->addRule('form_sale_rate2',$h_mess[9],'required');
	}
	
	//���֣�
	//��ô���Ԥ����Ψ��ξ�����Ϥ���Ƥ��뤫
	if($staff3 == NULL && $rate3 != NULL){
		$form->addRule('form_c_staff_id3',$h_mess[10],'required');
	}
	if($staff3 != NULL && $rate3 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate4) != 100){
		$form->addRule('form_sale_rate3',$h_mess[10],'required');
	}
	
	//���֣�
	//��ô���Ԥ����Ψ��ξ�����Ϥ���Ƥ��뤫
	if($staff4 == NULL && $rate4 != NULL){
		$form->addRule('form_c_staff_id4',$h_mess[11],'required');
	}
	if($staff4 != NULL && $rate4 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate3) != 100){
		$form->addRule('form_sale_rate4',$h_mess[11],'required');
	}
	
	//��ϩ(ɬ�ܡ�Ⱦ�ѱѿ�)
	$form->addGroupRule("form_route_load", $h_mess[18],"required");
	$form->addGroupRule("form_route_load", $h_mess[18],"numeric");
	
	for($n=0;$n<count($input_row);$n++){
	
		//�Ķȸ���(ɬ�ܡ�Ⱦ�ѱѿ�)
		$form->addGroupRule("form_trade_price[$input_row[$n]]", $d_mess[5][$input_row[$n]], "required");
		$form->addGroupRule("form_trade_price[$input_row[$n]]", $d_mess[5][$input_row[$n]], "numeric");
	
		/*
		$form->addGroupRule("form_trade_price[$input_row[$n]]", array(
			'1' => array(
		            array($d_mess[5][$input_row[$n]], 'required'),
					array($d_mess[5][$input_row[$n]], 'numeric')
		    ),      
		    '2' => array(
		            array($d_mess[5][$input_row[$n]],'required'),
					array($d_mess[5][$input_row[$n]], 'numeric')
		    ),             
		));
		*/
	
	}
	
	//����
	//��ʸ���������å�
	$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
	$form->addRule("form_note",$h_mess[23],"mb_maxlength","100");
	
	$form->registerRule("check_date","function","Check_Date");
	//$form->addGroupRule("form_stand_day", $h_mess[20],  "required", $_POST["form_stand_day"]);      //�������
	//$form->addRule("form_stand_day", $h_mess[20],  "check_date", $_POST["form_stand_day"]);         //�������
	$form->addGroupRule("form_update_day", $h_mess[52],  "required", $_POST["form_update_day"]);      //����ͭȯ����
	$form->addRule("form_update_day", $h_mess[52],  "check_date", $_POST["form_update_day"]);       //����ͭȯ����
	$form->addRule("form_contract_eday", $h_mess[53],  "check_date", $_POST["form_contract_eday"]); //����λ��
	
	//����ʬ���顼Ƚ�� 
	if($round_div == 1){
		//���
		$form->addRule('form_abcd_week1',$h_mess[19],'required');
		$form->addRule('form_week_rday1',$h_mess[19],'required');
	
	}else if($round_div == 2){
		//���
		$form->addRule('form_rday2',$h_mess[19],'required');
	
	}else if($round_div == 3){
		//���
		$form->addRule('form_cale_week3',$h_mess[19],'required');
		$form->addRule('form_week_rday3',$h_mess[19],'required');
	
	}else if($round_div == 4){
		//���
		$form->addRule('form_cale_week4',$h_mess[19],'required');
	
	}else if($round_div == 5){
		//���
		$form->addRule('form_cale_month5',$h_mess[19],'required');
		$form->addRule('form_week_rday5',$h_mess[19],'required');
	
	}else if($round_div == 6){
		//���
		$form->addRule('form_cale_month6',$h_mess[19],'required');
		$form->addRule('form_cale_week6',$h_mess[19],'required');
		$form->addRule('form_week_rday6',$h_mess[19],'required');
	
	}else if($round_div == 7){
		//���

		//��§���˥����å����դ��Ƥ��뤫Ƚ��
		if($last_day == NULL){
			$form->setElementError("hensoku_err",$h_mess[24]);
		}

		//����λ���ʹߤ���§��������ȥ��顼
		if(($contract_eday < $last_day) && ($contract_eday != NULL)){
			$form->setElementError("hensoku_err",$h_mess[59]);
		}
	
	}

	
	//����λ��������������ϥ��顼
	if(($contract_eday < $g_today) && ($contract_eday != NULL)){
		$form->setElementError("form_contract_eday",$h_mess[66]);
	}
	
	//����ʬ���������ξ�硢��������ɬ��Ƚ��
	if($rday == 0 && ($round_div == 2 || $round_div == 5)){
		$form->setElementError("form_rday2",$h_mess[19]);
	}
	
	//����ȯ����������������ϥ��顼
	if ($update_day < $g_today){
		$form->setElementError("form_update_day",$h_mess[64]);
	}

	/****************************/
	//���顼�����å�(PHP)
	/****************************/
	//$error_flg = false;            //���顼Ƚ��ե饰

	//�����ô����
	//���Ψ�ι�פ�100%��Ƚ��
	//���Ϥ��줿���Ψ�ι�פ�100��Ƚ��
	if(($rate1 + (int)$rate2 + (int)$rate3 + (int)$rate4) != 100){
		$form->setElementError("sale_rate_sum",$h_mess[16]);
	}

	//���ô���Ԥν�ʣ�����å�
	$cnum1 = count($staff_check);
	$staff_check2 = array_unique($staff_check);
	$cnum2 = count($staff_check2);

	//���ǿ����㤦��硢��ʣ�ͤ�¸�ߤ���
	if($cnum1 != $cnum2){
		$form->setElementError("staff_uniq",$h_mess[17]);
	}

	//���Ψ�����ʾ�ο��ͤ�Ƚ��
	for($s=0;$s<5;$s++){
		$ecount = 12 + $s;
		//�����ͤ�������˿���Ƚ��
		if(!ereg("^[0-9]+$",$staff_rate[$s]) && $staff_rate[$s] != NULL){
			$form->setElementError("form_sale_rate".($s+1),$h_mess[$ecount]);
		}
	}

	//��ϩ
	//��ʸ���������å�
	//�����ͥ����å�
	if(!ereg("^[0-9]{4}$",$route)){
		$form->setElementError("form_route_load","$h_mess[18]");
	}

	//����No.
	//����Ƚ��
	if(ereg("^[0-9]+$",$line) && $line > 0){
		//����(0�����)

		//����ʣ�����å�
		//���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
		$sql  = "SELECT ";
		$sql .= "    trust_line ";
		$sql .= "FROM ";
		$sql .= "    t_contract ";
		$sql .= "WHERE ";
		$sql .= "    trust_line = $line ";
		$sql .= "AND ";
		$sql .= "    trust_id = $client_h_id ";
		$sql .= "AND NOT ";
		$sql .= "    contract_id = $get_con_id";
		$sql .= ";";
		$result = Db_Query($db_con, $sql);
		$row_count = pg_num_rows($result);
		if($row_count != 0){
			$form->setElementError("form_line",$h_mess[7]);
		}
	}else{
		//NULLȽ��
		if($line == NULL){
			//NULL
			$form->setElementError("form_line",$h_mess[5]);
		}else{
			//���Ͱʳ�or����
			$form->setElementError("form_line",$h_mess[6]);
		}
	}

	//�������顼Ƚ��
	for($n=0;$n<count($input_row);$n++){
		/*
		for($b=0;$b<count($input_row2[$input_row[$n]]);$b++){
			//���Ķȸ���
			//��ɬ������
			//������Ƚ��
			if(($bt_price1[$input_row[$n]][$input_row2[$input_row[$n]][$b]] == NULL && $bt_price2[$input_row[$n]][$input_row2[$input_row[$n]][$b]] == NULL) || !ereg("^[0-9]+\.[0-9]+$",$break_trade_price[$input_row[$n]][$input_row2[$input_row[$n]][$b]])){
				$error_msg6[$input_row[$n]][$input_row2[$input_row[$n]][$b]] = $b_mess[0][$input_row[$n]][$input_row2[$input_row[$n]][$b]];
				$error_flg = true;        //���顼ɽ��
			}
		}
		*/
		
		//���Ķȸ���
		//������Ƚ��
		if(!ereg("^[0-9]+\.[0-9]+$",$trade_price[$input_row[$n]])){
			$form->setElementError("form_trade_price[$input_row[$n]]",$d_mess[5][$input_row[$n]]);
		}
	}

	$con_data2["entry_flg"] = "";    //��Ͽ�ܥ��󲡲��ե饰�����


	//$validate_result = $form->validate();

	//�ѹ��ξ��ϡֽ���ȯ�����פȡֽ�����פ�������������å�����
	if ( ($form->getElementError("form_update_day") == NULL)){
		$error_mesg = Round_Check($db_con,$update_ymd[0],$update_ymd[1],$update_ymd[2],$round_div,$abcd_week,$cale_week,$week_rday,$rday);

		if ($error_mesg != NULL){ 
			$form->setElementError("form_update_day","����ȯ������".$error_mesg);
		}
	}

	//���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
	//if($form->validate() && $error_flg == false){
	//if($validate_result && $error_flg == false){
	if( $form->validate() ){

		Db_Query($db_con, "BEGIN");
		//���������ռ���
		$con_today = date("Y-m-d");

		$work_div = 2; //�ѹ�
		$contract_id = $get_con_id; //����ID

		/****************************/
		//����ޥ�������
		/****************************/
		$sql  = "UPDATE t_contract SET ";
		$sql .= "    trust_line = $line,";
		$sql .= "    route = $route,";
		$sql .= "    act_trust_day = '$con_today',";
		$sql .= "    trust_note = '$note',";
		$sql .= "    round_div = '$round_div',";
		$sql .= "    cycle = '$cycle',";
		$sql .= "    cycle_unit = '$cycle_unit',";
		$sql .= "    cale_week = '$cale_week',";
		$sql .= "    abcd_week = '$abcd_week',";
		$sql .= "    rday = '$rday',";
		$sql .= "    week_rday = '$week_rday',";
		$sql .= "    trust_trade_amount = $trust_trade_amount,";


		//�ǽ�����������ꤵ��Ƥ��뤫
		if($last_day != NULL){
			$sql .= "    last_day = '$last_day',";
		}else{
			$sql .= "    last_day = NULL,";
		}
		if($update_day != NULL){
			$sql .= "    update_day = '$update_day', ";        //����ͭ����
		}else{
			$sql .= "    update_day = NULL, ";                 //����ͭ����
		}
		if($contract_eday != NULL){
			$sql .= "    contract_eday = '$contract_eday', ";  //����λ��
		}else{
			$sql .= "    contract_eday = NULL, ";              //����λ��
		}	
		$sql .= "    request_state = '2' ";
		$sql .= " WHERE ";
		$sql .= "    contract_id = $contract_id;";

		$result = Db_Query($db_con, $sql);
		if($result === false){
			Db_Query($db_con, "ROLLBACK");
			exit;
		}
		
		//��Ը�ID����
		$sql  = "SELECT ";
		$sql .= "    shop_id ";
		$sql .= "FROM ";
		$sql .= "    t_contract ";
		$sql .= "WHERE ";
		$sql .= "    contract_id = $contract_id;";
		$result = Db_Query($db_con, $sql);
		$shop_data = Get_Data($result);
		$shop_id = $shop_data[0][0];

		/****************************/
		//������׻�����
		/****************************/
		/*
		$cal_array = Cal_range($db_con,$shop_id);
		
		$cal_end_day = $cal_array[1];    //����������λ��
		$start_day   = $cal_array[0];    //�оݳ��ϴ���
		$end_day     = $cal_array[1];    //�оݽ�λ����
		$cal_peri    = $cal_array[2];    //��������ɽ������

		$stand_day = $update_day;  //�ֽ���ȯ�����פ���Ȥ���

		//����ȯ������������������������ξ�硢����ȯ����������ɼ��ȯ�Ԥ��롣
		if ( ($start_day < $update_day) && ($update_day != NULL) ){
			$start_day = $update_day;
		}

		//�ַ���λ��������������λ��������ס����ġ���NULL�Ǥʤ��ס��ξ��ϡ�����λ���򥫥�������λ���Ȥ��롣
		if ( ($contract_eday < $end_day) && ($contract_eday != NULL) ){
			$end_day = $contract_eday;
		}
		*/

		//��ɼ�κ�����ɬ�פ����դ����
		$cal_date = Cal_Span($db_con,$shop_id,$state,"�ѹ�",$stand_day,$update_day,$contract_eday);
		$stand_day   = $cal_date[0];    //����ȯ�����ʴ������		
		$start_day   = $cal_date[1];    //��ɼ����������
		$end_day     = $cal_date[2];    //��ɼ������λ��

		//��§���ʳ��ϡ�������η׻�����
		if($round_div != 7){
			$date_array = NULL;
			$date_array = Round_day($db_con,$cycle,$cale_week,$abcd_week,$rday,$week_rday,$stand_day,$round_div,$start_day,$end_day);
		}

		//****************************
		//ͽ����ɼ�ν�ʣ���������å�
		//****************************
		if(!empty($date_array)){

			//��������Ȥ˽�ʣ������å�����
			foreach($date_array AS $key => $date){
				$duplicat = Get_Aord_Duplicat($db_con,$contract_id,$date); 

				//��ʣ���ʤ����
				if ($duplicat === false) {

				//��ʣ��������
				} else {
					$duplicat_mesg .= $duplicat;
					$commit_flg = false; //���ߥåȤ��ʤ�
				}

			}
		}


		//print_array($date_array);
		/****************************/
		//������ơ��֥���Ͽ�ʰ��ٺ�����������Ͽ��
		/****************************/
		Delete_ConRound($db_con,$contract_id); 

		//��§���ξ��ϡ�������ơ��֥���Ͽ�����§�ǽ�����UPDATE
		if($round_div == 7){
			//������ơ��֥���Ͽ
			Regist_ConRound($db_con,$contract_id,$date_array,NULL);

			$update_columns           = NULL; //�����
			$update_columns[last_day] = $last_day;

			//SQL���󥸥���������к�
			$update_columns = pg_convert($db_con,'t_contract',$update_columns);	

			//UPDATE���
			$where[contract_id] = $contract_id;
			$where              = pg_convert($db_con,'t_contract',$where);

			//��§�ǽ�����UPDATE
			Db_Update($db_con, t_contract, $update_columns, $where);

		//��§���ʳ��ξ��
		}else{
			//������ơ��֥���Ͽ
			Regist_ConRound($db_con,$contract_id,$date_array,$end_day);
		}

		/****************************/
		//���ô���ԥơ��֥���Ͽ�ʰ��ٺ�����������Ͽ��
		/****************************/
		Delete_ConStaff($db_con,$contract_id);
		Regist_ConStaff($db_con,$contract_id,$staff_check,$staff_rate);

		/****************************/
		//�������ƹ���
		/****************************/
		for($s=0;$s<count($input_row);$s++){                           
			$sql  = "UPDATE t_con_info SET ";
			$sql .= "    trust_cost_price  = ".$trade_price[$input_row[$s]].",";       //�Ķȸ���
			$sql .= "    trust_cost_amount = ".$trade_amount[$input_row[$s]].", ";      //�Ķȶ��
            $sql .= "    trust_mst_sync_flg = ".$trust_mst_sync_flg[$input_row[$s]];    //�ʼ������ѡ˥ޥ���Ʊ���ե饰
			$sql .= " WHERE ";
			$sql .= "    line = ".$input_row[$s];
			$sql .= " AND ";
			$sql .= "    contract_id = $get_con_id;";

			$result = Db_Query($db_con, $sql);
			if($result === false){
			    Db_Query($db_con, "ROLLBACK");
			    exit;
			}
		}

		//����ޥ������ͤ���˽񤭹���
		//�ʥǡ��������ɡ�������CD-��No.  ̾�Ρ�������̾-����ܹ�No.��
		$cname = addslashes($cname);  //��'�פ��ޤޤ���ǽ�������뤿������¹�
		$result = Log_Save($db_con,'contract',$work_div,$client_cd."-".$line,$cname."-����".$line);
		//����Ͽ���˥��顼�ˤʤä����
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
		
		//��ɼ�ι�׶�ۤ�׻��������åץǡ��Ȥ���
		Update_Amount_Act($db_con, $contract_id, "contract");
		/****************************/
		//����ǡ�����Ͽ�ؿ�����ʧ�ơ��֥����Ͽ�ؿ�     
		/****************************/
		//Aorder_Query($db_con,$shop_id,$client_id,$start_day,$end_day,$client_h_id);
		Regist_Aord_Contract($db_con,$shop_id,$contract_id,$start_day,$end_day,$client_h_id);

		//Db_Query($db_con, "COMMIT;");                                                     
		//header("Location: ./2-1-239.php");                                                             


		//****************************
		//���ߥåȽ���
		//****************************
		//��ͽ��ǡ����ν�ʣ�ʤ��פޤ��ϡ�ͽ��ǡ����ν�ʣOK��
		if (($commit_flg !== false) || ($_POST[duplicat_ok] == "1")){
		//if (($commit_flg !== false)){
			Db_Query($db_con, "COMMIT;");                                                     
			header("Location: ./2-1-239.php");                                                             

		//ͽ��ǡ�������ʣ�����������
		}else{
			Db_Query($db_con, "ROLLBACK;");
			$form->setConstants(array(duplicat_ok=>"1"));
		}



	}                                                                 
}                                                                                        


//����ʬ�饸��
if($_POST["form_round_div1"][0][0] == null){
    $round_div = $round_div_db;
}else{
    $round_div = $_POST["form_round_div1"][0][0];
    $con_data2["form_round_div1[]"] = $round_div;
}
$form_load = "onLoad=\"Check_read('$round_div');\"";


/****************************/
//POST������ͤ��ѹ�
/****************************/
$form->setConstants($con_data2);

//��Ʊ�������å��ܥå���
if($_POST["form_stand_day"] == null){
    $form->setConstants($mst_sync_data);
}else{
    $form->setConstants($mst_sync_data2);
}


#2009-09-22 hashimoto-y
$num = 5;
$toSmarty_discount_flg = array();
for ($i=1; $i<=$num; $i++){
    $hdn_discount_flg = $form->getElementValue("hdn_discount_flg[$i]");
    #echo "hdn_discount_flg:" .$hdn_discount_flg ."<br>";
    if($hdn_discount_flg === 't' ||
       $trade_sale_select[0] == '13' || $trade_sale_select[0] == '14' || $trade_sale_select[0] == '63' || $trade_sale_select[0] == '64'
    ){
        $toSmarty_discount_flg[$i] = 't';
    }else{
        $toSmarty_discount_flg[$i] = 'f';

    }
}

/****************************/
//javascript
/****************************/
$java_sheet = Js_Keiyaku();

//�ե�����롼�׿�
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�1
//$error_loop_num1 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�2
//$error_loop_num2 = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

//���顼�롼�׿�3
//$error_loop_num3 = array(0=>"0",1=>"1",2=>"2",3=>"3",4=>"4");

/****************************/
//���������
/****************************/
$client_sql  = " SELECT ";
$client_sql .= "     t_client.client_id ";
$client_sql .= " FROM";
$client_sql .= "     t_client ";
$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
$client_sql .= " WHERE";
$client_sql .= "     t_contract.trust_id = ".$_SESSION["client_id"]." ";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";
$client_sql .= "     AND";
$client_sql .= "     t_contract.contract_div = '2'";

//�إå�����ɽ�������������
$count_res = Db_Query($db_con, $client_sql.";");
$total_count = pg_num_rows($count_res);

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
$page_title .= "(��".$total_count."��)";
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
$smarty->assign('num',$foreach_num);
$smarty->assign('loop_num',$loop_num);
//$smarty->assign('error_loop_num1',$error_loop_num1);
//$smarty->assign('error_loop_num2',$error_loop_num2);
//$smarty->assign('error_loop_num3',$error_loop_num3);
//$smarty->assign('error_msg4',$error_msg4);
//$smarty->assign('error_msg5',$error_msg5);
//$smarty->assign('error_msg6',$error_msg6);
//$smarty->assign('error_msg7',$error_msg7);
//$smarty->assign('error_msg8',$error_msg8);
//$smarty->assign('error_msg9',$error_msg9);
//$smarty->assign('error_msg10',$error_msg10);

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'     => "$html_header",
	'page_menu'       => "$page_menu",
	'page_header'     => "$page_header",
	'java_sheet'      => "$java_sheet",
	'html_footer'     => "$html_footer",
	'flg'             => "$flg",
	'last_day'        => "$last_day",
	//'error_msg'       => "$error_msg",
	//'error_msg2'      => "$error_msg2",
	//'error_msg3'      => "$error_msg3",
	'ac_name'         => "$ac_name",
	'return_flg'      => "$return_flg",
	'get_flg'         => "$get_flg",
	'client_id'       => "$client_id",
	'trade_error_flg' => "$trade_error_flg",
	'auth_r_msg'      => "$auth_r_msg",
	'br_flg'          => "$br_flg",
	'form_load'       => "$form_load",
	'duplicat_mesg'   => "$duplicat_mesg",
));


#2009-09-22 hashimoto-y
$smarty->assign('toSmarty_discount_flg',$toSmarty_discount_flg);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));


//print_array($_POST);


/**
 * ����  ���ʤβ��ʤ�������� 
 *
 * ����  
 *
 * @param resource  $db_con       DB��³�꥽����
 * @param string    $goods_id     �ơ��֥�̾
 * @param array     $rank_cd      �ܵҶ�ʬ
 * @param array     $retrun_type  ���ͤη���
 *
 * @return int                    ����ñ��
 *
 */
function Get_Goods_Price($db_con,$goods_id,$rank_cd=2,$retrun_type="1"){

	if($goods_id == NULL ){
		$price = "0.00";
	}else{
		$sql ="
            SELECT 
                t_price.r_price, 
                t_goods.compose_flg 

            FROM 
                t_goods
                LEFT JOIN t_price ON t_goods.goods_id = t_price.goods_id
                    AND t_price.shop_id    = $_SESSION[client_id]
                    AND t_price.rank_cd    = '$rank_cd'

            WHERE 
                t_goods.goods_id = $goods_id
";

		$result = Db_Query($db_con, $sql);

        //���̤ξ���
        if(pg_fetch_result($result, 0, "compose_flg") == "f"){
            $price = @pg_fetch_result($result, 0, 0);

        //������
        }else{
            $tmp = Compose_price($db_con, $_SESSION["client_id"], $goods_id);

            switch($rank_cd){
                case "2":
                    $price = $tmp[0];
                    break;
                case "4":
                    $price = $tmp[1];
                    break;
                case "3":
                    $price = $tmp[2];
                    break;
                default:
                    $price = "0.00";
            }

            $price = number_format($price, 2, ".", "");

        }

	}

	//�����Ⱦ�����ʬ����
	if($retrun_type != "1"){
		$price = explode('.', $price);
	}
	return $price;

}


?>
