<?php
/****************************
 * �ѹ�����
 *  ����(2006-07-27)���ʥޥ����ι����ѹ���ȼ������о����ѹ���watanabe-k��
 *      ����2006-12-01�˴ݤ��ʬ�����ۤ��ѹ���suzuki��
 *
 *
 *
*****************************/
$page_title = "����ޥ���";
//�Ķ�����ե�����
require_once("ENV_local.php");

//DB����³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

/****************************/
//�����ѿ�����
/****************************/
$client_id   = $_GET["client_id"];      //������
$get_con_id  = $_GET["contract_id"];    //�������ID
$row         = $_GET["break_row"];      //������Ͽ�ι��ֹ�
$client_h_id = $_SESSION["client_id"];  //������桼��ID
$rank_cd     = $_SESSION["fc_rank_cd"]; //�ܵҶ�ʬ������
$staff_id    = $_SESSION["staff_id"];   //�������ID

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
$get_con_id2  = $_GET["select_id"];     //���פ����Ϥ����������ID
$get_info_id  = $_GET["select_id2"];    //���פ����Ϥ�����������ID
//���ܸ�Ƚ��
if($get_info_id != NULL){
	//�����פ����������ɽ��

	//�ǣţԾ�������Ƚ��
	Get_ID_Check2($get_con_id2);
	Get_ID_Check2($get_info_id);

	/****************************/
	//�������ƥơ��֥�
	/****************************/
	$sql  = "SELECT ";
	$sql .= "    t_con_info.line,";               //�Կ�
	$sql .= "    t_con_info.serv_id,";            //�����ӥ�ID
	$sql .= "    t_goods.goods_cd,";              //����CD
	$sql .= "    t_con_info.goods_name,";         //ά��
	$sql .= "    t_con_info.num, ";               //�����ƥ��
	$sql .= "    t_con_info.trust_trade_price,";  //�Ķȸ���
	$sql .= "    t_con_info.sale_price,";         //���ñ��
	$sql .= "    t_con_info.trust_trade_amount,"; //�Ķȶ��
	$sql .= "    t_con_info.sale_amount ";        //�����
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
	$main_trade_amount = $info_data[0][7];
	//�����
	$main_sale_amount = $info_data[0][8];
	
	/****************************/
	//�����ơ��֥�
	/****************************/
	$sql  = "SELECT ";
	$sql .= "    t_con_detail.line,";               //��
	$sql .= "    t_con_detail.goods_id,";           //����ID
	$sql .= "    t_goods.goods_cd,";                //����CD
	$sql .= "    t_goods.name_change,";             //��̾�ѹ�
	$sql .= "    t_con_detail.goods_name,";         //ά��
	$sql .= "    t_con_detail.num,";                //����
	$sql .= "    t_con_detail.trust_trade_price,";  //�Ķȸ���
	$sql .= "    t_con_detail.sale_price,";         //���ñ��
	$sql .= "    t_con_detail.trust_trade_amount,"; //�Ķȶ��   
	$sql .= "    t_con_detail.sale_amount ";        //�����
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

	$form->setDefaults($con_data);
	$form->freeze();

}else{
	//������Ͽ��������

	//�ǣţԾ�������Ƚ��
	Get_ID_Check2($client_id);
	Get_ID_Check2($row);

	/****************************/
	//������Ƚ��ؿ�
	/****************************/
	Injustice_check($db_con,"trust",$get_con_id,$client_h_id);

	/****************************/
	//hidden�Ƿ�����Ͽ���������
	/****************************/
	require_once(INCLUDE_DIR."keiyaku_hidden.inc");

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
		$sale_1 = number_format($_POST["form_trade_price"][$row][1]);
		$sale_2 = ($_POST["form_trade_price"][$row][2] != null)? $_POST["form_trade_price"][$row][2] : '00';
		$main_trade_price = $sale_1.".".$sale_2;
	}
	$main_sale_price = $_POST["form_sale_price"][$row][1].".".$_POST["form_sale_price"][$row][2];
	$main_trade_amount = $_POST["form_trade_amount"][$row];
	$main_sale_amount = $_POST["form_sale_amount"][$row];

	//�������ܥ����hidden�ˤ���ݻ�����
	if($_POST["return_btn"] == NULL){
		//�ѹ����������ǡ�����hidden�˥��å�
		for($d=1;$d<=5;$d++){
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
	$data_list = Get_Data($result,2);
	$coax = $data_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�

	//POST�����ѹ�
	$con_data2["hdn_coax"]            = $coax;

	/****************************/
	//���������
	/****************************/
	$client_sql  = " SELECT ";
	$client_sql .= "     t_client.client_id ";
	$client_sql .= " FROM";
	$client_sql .= "     t_client ";
	$client_sql .= "     INNER JOIN t_contract ON t_client.client_id = t_contract.client_id ";
	$client_sql .= " WHERE";
	$client_sql .= "     t_contract.trust_id = $client_h_id";
	$client_sql .= "     AND";
	$client_sql .= "     t_client.client_div = '1'";
	//�إå�����ɽ�������������
	$count_res = Db_Query($db_con, $client_sql.";");
	$total_count = pg_num_rows($count_res);

	/****************************/
	//���ꥢ�ܥ��󲡲�����
	/****************************/
	if($_POST["clear_flg"] == true){
		//����������ƽ����
		for($c=1;$c<=5;$c++){
			$con_data2["break_trade_price"][$row][$c]["1"] = "";
			$con_data2["break_trade_price"][$row][$c]["2"] = "";
			$con_data2["break_trade_amount"][$row][$c]     = "";
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
			$freeze_data = $form->addElement(
			    "text","break_goods_cd[$i][$j]","","size=\"10\" maxLength=\"8\"
			    style=\"$g_form_style;$style\" $type
				onChange=\"goods_search_1(this.form, 'break_goods_cd[$i][$j]', 'goods_search_row', $j)\""
			);
			$freeze_data->freeze();
	
			//����̾
			//�ѹ��Բ�Ƚ��
			if($_POST["hdn_bname_change"][$i][$j] == '2' || $hdn_bname_change[$i][$j] == '2'){
				//�Բ�
			    $freeze_data = $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" $g_text_readonly" 
			    );
			}else{
				//��
			    $freeze_data = $form->addElement(
			        "text","break_goods_name[$i][$j]","",
			        "size=\"21\" maxLength=\"20\" 
			        style=\"$style\" $type"
			    );
			}
			$freeze_data->freeze();

			//���ʿ�
			$freeze_data = $form->addElement(
		       "text","break_goods_num[$i][$j]","",
		       "class=\"money_num\" size=\"6\" maxLength=\"5\" 
		        style=\"$g_form_style;$style\" $type"
		    );
			$freeze_data->freeze();

			//����ID
			$form->addElement("hidden","hdn_bgoods_id[$i][$j]");
			//��̾�ѹ��ե饰
			$form->addElement("hidden","hdn_bname_change[$i][$j]");

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
		    $freeze_data = $form->addGroup( $form_sale_price[$i], "break_sale_price[$i][$j]", "",".");
			$freeze_data->freeze();

			//����׳�
			$freeze_data = $form->addElement(
		        "text","break_sale_amount[$i][$j]","",
		        "size=\"17\" maxLength=\"10\" 
		        style=\"color : #000000; 
		        border : #ffffff 1px solid; 
		        background-color: #ffffff; 
		        text-align: right\" readonly'"
		    );
			$freeze_data->freeze();

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
	   "onClick=\"return Dialogue('���ꤷ�ޤ���','./2-1-240.php?client_id=$client_id&contract_id=$get_con_id');\""
	);
	//���ꥢ
	$form->addElement("button","clear_button","���ꥢ","onClick=\"insert_row('clear_flg');\"");
	//���
	$form->addElement("button","form_back","�ᡡ��","onClick=\"SubMenu2('./2-1-240.php?client_id=$client_id&contract_id=$get_con_id')\"");
}

//�ե�����롼�׿�
$loop_num = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");

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
