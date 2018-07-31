<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/13      10-018      suzuki      ���������顼��å������ѹ�
 *  2006/11/13      10-013      suzuki      ��󥿥�ñ���ξ���������������Ͽ�����褦�˽���
 *  2006/11/13      10-021      suzuki      �ǡ�������Ͽ���뾦�ʤ�ά�Τ��龦��̾���ѹ�
 *  2006/11/13      10-012      suzuki      ����CD����JS��Ƥ֥��٥�Ȥ�OnChange���ѹ�
 *  2006/11/29      scl_201-1-1 suzuki      ����CD����JS��Ƥ֥��٥�Ȥ�onBlur���ѹ�
 *  2006/12/09      ban_0104    suzuki      ���դΥ������
 *  2007/05/11                  morita-d    ������ͳ����������ɲ�
 *  2007/05/31                  morita-d    ����ʬ�����������ɲ�
 *  2007/06/10                  morita-d    ����̾���ѹ��������ǽ�˽���
 *  2007/06/19                  morita-d    ���̤ǹ�������������ȴݤ��ʬ��NULL�ˤʤ��Զ�����
 *
*/

$page_title = "��󥿥�TO��󥿥�";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //����ؿ����
require_once(INCLUDE_DIR."function_rental.inc");  //��󥿥�ؿ����
require_once(INCLUDE_DIR."rental.inc");  //��󥿥���ɼ�����ؿ���

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³
$db_con = Db_Connect();

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
$shop_name  = htmlspecialchars($_SESSION["fc_client_cname"]);
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];
$rental_id  = $_GET["rental_id"];      //��󥿥�ID
$top_menu   = $_GET["top_menu"];       //TOP��˥夫�����ܤ��Ƥ�����Ƚ��
$g_product_ary = Select_Get($db_con, 'g_product'); //����ʬ��ޥ���

//��󥿥�ID��hidden�ˤ���ݻ�����
if($_GET["rental_id"] != NULL){
	$cons_data["hdn_rental_id"] = $rental_id;
}else{
	$rental_id = $_POST["hdn_rental_id"];
}

//TOP��˥塼�ե饰��hidden�ˤ���ݻ�����
if($_GET["top_menu"] != NULL){
	$cons_data["hdn_top_menu"] = $top_menu;
}else{
	$top_menu = $_POST["hdn_top_menu"];
}

//�����褬���ꤵ��Ƥ��뤫
if($_POST["hdn_client_id"] == null){
	$warning = "�桼�������򤷤Ʋ�������";
}else{
	$warning = null;
	$client_id    = $_POST["hdn_client_id"];
	$coax         = $_POST["hdn_coax"];
	$client_name  = $_POST["form_client"]["name"];
}

//����Ƚ��
Get_ID_Check3($rental_id);


//������������ˤ�ID�����
$h_client_id = Get_Client_Id_Head($db_con);
    
//������������ˤδݤ��ʬ
$h_client_tax = Get_Tax_div($db_con,$h_client_id);
$h_coax       = $h_client_tax[coax];

/*****************************/ 
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET["rental_id"] == null && $_POST == null){
	Set_Rtn_Page(array("rental", "contract"));
}

/****************************/
//��󥿥�JS�����ؿ�
/****************************/
$java_sheet = Create_JS_Rental($db_con);

/****************************/
//��󥿥���Ͽ����ɽ������Ƚ��ؿ�
/****************************/
/*
	�����̼�����
	 1:��󥿥�ID̵��
	 2:����ѡ������
	 3:������
	 4:����ͽ��
	 5:��ú�
	 6:����������
*/
$stat_list  = Rental_display($db_con,$rental_id);
$disp_stat  = $stat_list[0];  //���̼�����
$online_flg = $stat_list[1];  //����饤��ե饰

if($_POST["online_flg"] != NULL){
	$online_flg = $_POST["online_flg"];
}

//print_array($_POST);

//�ʲ��ν����ϤۤȤ�ɰ�̵̣��
//$online_flg �� �������Ƥ��ʤ�
//$group_kind �� FC��ɬ��2�Ȥʤ�
/****************************/
//ɽ�����̤ȼºݤΥǡ�����������Ƚ�� 
/****************************/
//����ɽ��Ƚ��(�����ʾ����������̤�ɽ��)
if($_POST["comp_btn"] == "��ǧ��ǧ���̤�" || $_POST["ok_btn"] == "��ǧOK" || $_POST["cancel_btn"] == "������ó�ǧ���̤�" || $_POST["cancel_ok_btn"] == "�������OK"){

	//����������(����)Ƚ��
	if(!($disp_stat == 6 && $group_kind == 1 && $online_flg == 't')){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "�����ǧ���̤�" || $_POST["ok_btn"] == "����OK"){

	//����ѡ������(���ե饤��)Ƚ��
	if(!($disp_stat == 2 && $group_kind == 1 && $online_flg == 'f')){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "�ѹ���ǧ���̤�" || $_POST["ok_btn"] == "�ѹ�OK"){

	//����ѡ������(������FC)Ƚ��
	if(!($disp_stat == 2)){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "����ǧ���»ܳ�ǧ���̤�" || $_POST["ok_btn"] == "����ǧ���»�OK" || $_POST["cancel_btn"] == "�����ó�ǧ���̤�" || $_POST["cancel_ok_btn"] == "������OK"){

	//������(����)Ƚ��
	if(!($disp_stat == 3 && $group_kind == 1 && $online_flg == 't')){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "�����ó�ǧ���̤�" || $_POST["ok_btn"] == "������OK"){

	//����ͽ��(����)Ƚ��
	if(!($disp_stat == 4 && $group_kind == 1)){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "��Ͽ��ǧ���̤�" || $_POST["ok_btn"] == "��ϿOK"){

	//��󥿥�ID̵������úѡ���󥿥�ID̵��(���ե饤��)Ƚ��
	if(!($disp_stat == 1 || $disp_stat == 5 || ($disp_stat == 1 && $online_flg == 'f'))){
		$injust_msg = true;
	}
}elseif($_POST["comp_btn"] == "��������ǧ���̤�" || $_POST["ok_btn"] == "������OK"){

	//����ѡ������(FC)Ƚ��
	if(!($disp_stat == 2)){
		$injust_msg = true;
	}
}

/****************************/
//��󥿥�TO��󥿥���������
/****************************/
//FC�ǥ���饤����
if($online_flg == "t"){
	$freeze_online = array(
		"form_forward_day",
		"form_head_staff",
		"form_claim_day",
		"form_h_note",
	);
}elseif($online_flg == "f"){
	$freeze_online = array(
		"form_head_staff",
		"form_h_note",
	);
}

//����󥿥��ʬ
//����
if($disp_stat == 1){
	$online_flg_arr[] =& $form->createElement("radio", null, null, "���ե饤��", "f","onclick=\"h_column_disabled(this);\"");
	$online_flg_arr[] =& $form->createElement("radio", null, null, "����饤��", "t","onclick=\"h_column_disabled(this);\"");
	$form->addGroup($online_flg_arr, "online_flg", "��󥿥��ʬ");

}else{
	$online_flg_name = "���ե饤��";
	if($online_flg == "t"){
		$online_flg_name = "����饤��";
	}
	$form->addElement("static","online_flg","��󥿥��ʬ");

	$static_data["online_flg"]    = "$online_flg_name";
	$form->setConstants($static_data);

}

//����󥿥��ֹ�
$form->addElement("text","form_rental_no","","class='Textbox_readonly nborder'");

//������å�̾
$form->addElement("text","form_shop_name","","class='Textbox_readonly nborder'");

//����󥿥뿽����
Addelement_Date($form,"form_rental_day","��󥿥뿽����","-");

//FC�����åռ���
$form_staff_id = Select_Get($db_con,'cstaff');

//������ô����
$form->addElement('select', 'form_app_staff', '', $form_staff_id, $g_form_option_select);
//�����ô����
$form->addElement('select', 'form_round_staff', '', $form_staff_id, $g_form_option_select);

//���桼��̾
$form_client[] =& $form->createElement(
	"text","cd1","","size=\"7\" maxLength=\"6\" 
	style=\"$g_form_style\" onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]')\" 
	onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
);
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement(
	"text","cd2","","size=\"4\" maxLength=\"4\" 
	style=\"$g_form_style\" onChange=\"javascript:Button_Submit('client_search_flg','#','true')\"".$g_form_option."\""
);
$form_client[] =& $form->createElement("text","name","","size=\"34\" readonly");
$form->addGroup( $form_client, "form_client", "");
//$form->freeze("form_client");

//���桼��̾���
$form->addElement("link","form_client_link","","./2-1-141.php","�桼��̾","
	onClick=\"return Open_SubWin('".FC_DIR."dialog/2-0-250.php',
	Array('form_client[cd1]','form_client[cd2]','form_client[name]', 'client_search_flg'),500,450,5,1);\""
);

//���桼��TEL
$form->addElement("text", "form_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

//��͹���ֹ�
$form_post[]   =& $form->createElement("text", "no1", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_post[no1]', 'form_post[no2]',3)\"".$g_form_option."\"");
$form_post[]   =& $form->createElement("text", "no2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_post, "form_post", "","-");

$form->addElement("text", "form_add1", "",'size="50" maxLength="25"'." $g_form_option");     //�����꣱
$form->addElement("text", "form_add2", "",'size="50" maxLength="25"'." $g_form_option");     //�����ꣲ
$form->addElement("text", "form_add3", "",'size="55" maxLength="30"'." $g_form_option");     //�����ꣳ
$form->addElement("text", "form_add_read", "",'size="50" maxLength="50"'." $g_form_option"); //������(�եꥬ��)
$form->addElement("textarea","form_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area); //������

//����󥿥�в���
$form_forward_day[] =& $form->createElement("text","y","","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"Rental_claim(this.form,'form_forward_day[y]','form_forward_day[m]',4,'form_forward_day[y]','form_forward_day[m]','form_claim_day[y]','form_claim_day[m]')\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form_forward_day[] =& $form->createElement("text","m","","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onkeyup=\"Rental_claim(this.form,'form_forward_day[m]','form_forward_day[d]',2,'form_forward_day[y]','form_forward_day[m]','form_claim_day[y]','form_claim_day[m]')\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form_forward_day[] =& $form->createElement("text","d","","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"Forward_today(this,this.form,'form_forward_day[y]','form_forward_day[m]','form_forward_day[d]','form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_forward_day,"form_forward_day","form_forward_day","-");

$form->addElement('select', 'form_head_staff', '', $form_staff_id, $g_form_option_select); //����ô����

//�������
$form_claim_day[] =& $form->createElement("text","y","","style=\"ime-mode:disabled;\" size=\"4\" maxLength=\"4\" onkeyup=\"changeText(this.form,'form_claim_day[y]','form_claim_day[m]',4)\" onFocus=\"onForm_today2(this,this.form,'form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form_claim_day[] =& $form->createElement("text","m","","style=\"ime-mode:disabled;\" size=\"1\" maxLength=\"2\" onFocus=\"onForm_today2(this,this.form,'form_claim_day[y]','form_claim_day[m]')\" onBlur=\"blurForm(this)\"");
$form->addGroup( $form_claim_day,"form_claim_day","form_claim_day","-");

$form->addElement("textarea","form_h_note","",'size="30" maxLength="100" cols="40"'.$g_form_option_area); //����(������)



//���ե饤�� or ���� or ��ú�
if($online_flg == "f" || $disp_stat == 1 || $disp_stat == 5){
	//�����ꥢ��������
	$form->addElement("button","input_form_btn", "�������ɽ��", 
		"onClick=\"javascript:Button_Submit_1('input_form_flg', '#', 'true')\"");

	//����ư����
	$form->addElement("button","input_auto", "��ư����", "onClick=\"javascript:Button_Submit_1('auto_flg', '#', 'true')\"");
	//�����ɲåܥ���
	$form->addElement("button","add_row_btn","���ɲ�","onClick=\"javascript:Button_Submit('add_row_flg', '#foot', 'true')\"");

}else{
	$freeze_online[] = "form_rental_day";
}

$form->freeze($freeze_online);




//���� or ��úѡ��ξ��
if($disp_stat == 1 || $disp_stat == 5){
	$form->addElement("submit","comp_btn","��Ͽ��ǧ���̤�","$disabled");
	$form->addElement("submit","ok_btn","��ϿOK");

}else if($disp_stat == 2){

	//����ѡ������(FC)
	$sql  = "SELECT ";
	$sql .= "    CASE rental_stat ";       //��󥿥���� 
	$sql .= "     WHEN '0'  THEN '��ú�' ";
	$sql .= "     WHEN '10' THEN '�����' ";
	$sql .= "     WHEN '11' THEN '����������' ";
	$sql .= "     WHEN '20' THEN '�����' ";
	$sql .= "     WHEN '21' THEN '������' ";
	$sql .= "     WHEN '22' THEN '����ͽ��' ";
	$sql .= "    END ";
	$sql .= "FROM ";
	$sql .= "    t_rental_d ";
	$sql .= "WHERE ";
	$sql .= "    rental_id = $rental_id;";
	$result = Db_Query($db_con, $sql);

	$stat_flg = false;   //�����¸��Ƚ��ե饰
	while($stat_data = pg_fetch_array($result)){

		//$r_stat[] = $stat_data[0];
		if($stat_data[0] == '�����'){
			$stat_flg = true;
		}
	}

	//����Ѥ�1�Ĥ�ʤ� or ���ե饤��
	if($stat_flg != true || $online_flg == "f"){
		$form->addElement("submit","comp_btn","�ѹ���ǧ���̤�","$disabled");
		$form->addElement("submit","ok_btn","�ѹ�OK");

	//����Ѥ�1�ĤǤ⤢����
	}else{
		$form->addElement("submit","comp_btn","��������ǧ���̤�","$disabled");
		$form->addElement("submit","ok_btn","������OK");

	}
	
	/*
	if($stat_flg == true){
		$form->addElement("submit","comp_btn","��������ǧ���̤�","$disabled");
		$form->addElement("submit","ok_btn","������OK");

	//����ѤΤߤξ��
	}else{
		$form->addElement("submit","comp_btn","�ѹ���ǧ���̤�","$disabled");
		$form->addElement("submit","ok_btn","�ѹ�OK");
	}
	*/
}

//TOP��˥塼�ʳ��������ܤ��Ƥ����������ܥ���ɽ��
if($top_menu == NULL){
	$form->addElement("button","return_btn","�ᡡ��","onClick=\"location.href='".Make_Rtn_Page("rental")."'\"");
}

//��ǧ�����Ѥ����ܥ���
$form->addElement("button","back_btn","�ᡡ��","onClick=\"javascript:history.back()\"");

//�إå������إܥ���
$form->addElement("button","disp_btn","�졡��","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
$form->addElement("button", "input_btn","�С�Ͽ",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addElement("hidden", "hdn_client_id");       //�桼��ID
$form->addElement("hidden", "hdn_shop_id");         //����å�ID
$form->addElement("hidden", "hdn_rental_id");       //��󥿥�ID
$form->addElement("hidden", "hdn_online_no");       //����饤��ե饰
$form->addElement("hidden", "auto_flg");            //��ư���ϥܥ��󲡲��ե饰    
$form->addElement("hidden", "client_search_flg");   //�桼����󥯲����ե饰    
$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ�
$form->addElement("hidden", "hdn_top_menu");        //TOP��˥�����Ƚ��ե饰
$form->addElement("hidden", "input_form_flg");      //������ɽ���ե饰
$form->addElement("hidden", "cancel_flg");          //�����åե饰
$form->addElement("hidden", "hdn_coax");            //�ݤ�


//�������ˤϤ���ʹߤν�����Ԥ�ʤ�
if($injust_msg == false){
	/****************************/
	//�������(�ѹ��ξ��)
	/****************************/
	if($rental_id != NULL){

		/****************************/
		//�إå�������
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_rental_h.rental_id,";          //��󥿥�ID 0
		$sql .= "    t_rental_h.rental_no,";          //��󥿥��ֹ� 1
		$sql .= "    t_rental_h.shop_id,";            //����å�ID 2
		$sql .= "    t_rental_h.shop_cd1,";           //����å�CD1 3
		$sql .= "    t_rental_h.shop_cd2,";           //����å�CD2 4
		$sql .= "    t_rental_h.shop_name,";          //����å�̾ 5
		$sql .= "    t_rental_h.ap_staff_id,";        //����ô����ID 6
		$sql .= "    t_rental_h.ap_staff_name,";      //����ô����̾ 7
		$sql .= "    t_rental_h.c_staff_id,";         //���ô����ID 8
		$sql .= "    t_rental_h.c_staff_name,";       //���ô����̾ 9
		$sql .= "    t_rental_h.client_id,";          //������ID 10
		$sql .= "    t_rental_h.client_cd1, ";        //������CD1 11
		$sql .= "    t_rental_h.client_cd2, ";        //������CD2 12
		$sql .= "    t_rental_h.client_name, ";       //������̾1 13
		$sql .= "    t_rental_h.client_name2, ";      //������̾2 14
		$sql .= "    t_rental_h.client_cname, ";      //ά�� 15
		$sql .= "    t_rental_h.tel, ";               //TEL 16
		$sql .= "    t_rental_h.post_no1, ";          //͹���ֹ�1 17
		$sql .= "    t_rental_h.post_no2, ";          //͹���ֹ�2 18
		$sql .= "    t_rental_h.address1, ";          //����1 19
		$sql .= "    t_rental_h.address2, ";          //����2 20
		$sql .= "    t_rental_h.address3, ";          //����3 21
		$sql .= "    t_rental_h.address_read, ";      //���ꥫ�� 22
		$sql .= "    t_rental_h.note_fc, ";           //����(FC) 23
		$sql .= "    t_rental_h.apply_day, ";         //��󥿥뿽���� 24
		$sql .= "    t_rental_h.online_flg, ";        //����饤��ե饰 25

		$sql .= "    t_rental_h.note_h, ";            //����(����) 26
		$sql .= "    t_rental_h.forward_day, ";       //��󥿥�в��� 27
		$sql .= "    t_rental_h.h_staff_id, ";        //����ô����ID 28
		$sql .= "    t_rental_h.h_staff_name, ";      //����ô����̾ 29
		$sql .= "    t_rental_h.claim_day, ";         //����� 30
		
		$sql .= "    t_client.coax ";                //�ݤ��ʬ 31

		$sql .= "FROM ";
		$sql .= "    t_rental_h ";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_rental_h.client_id ";
		$sql .= "WHERE ";
		$sql .= "    t_rental_h.regist_shop_id = $shop_id ";
		$sql .= "AND ";
		$sql .= "    t_rental_h.rental_id = $rental_id;";
		$result = Db_Query($db_con, $sql);
		//GET�ǡ���Ƚ��
		Get_Id_Check($result);
		$ren_h_data = Get_Data($result,2);

		$def_data["form_rental_no"]       = $ren_h_data[0][1];  //��󥿥��ֹ�
		$def_data["form_app_staff"]       = $ren_h_data[0][6];  //����ô����
		$def_data["form_round_staff"]     = $ren_h_data[0][8];  //���ô����

		$def_data["hdn_client_id"]        = $ren_h_data[0][10]; //������ID

		//POST�����������ID����Ƚ��
		if($_POST["hdn_client_id"] != NULL){
			//POST
			$client_id = $_POST["hdn_client_id"]; //SUBMIT�������˻��Ѥ����
		}else{
			//DB
			$client_id = $ren_h_data[0][10]; //SUBMIT�������˻��Ѥ����
		}

		$def_data["form_client"]["cd1"]   = $ren_h_data[0][11]; //�����襳���ɣ�
		$def_data["form_client"]["cd2"]   = $ren_h_data[0][12]; //�����襳���ɣ�
		$def_data["form_client"]["name"]  = $ren_h_data[0][15]; //������̾
		$def_data["form_post"]["no1"]     = $ren_h_data[0][17]; //͹���ֹ�1
		$def_data["form_post"]["no2"]     = $ren_h_data[0][18]; //͹���ֹ�2
		$def_data["form_add1"]            = $ren_h_data[0][19]; //���꣱
		$def_data["form_add2"]            = $ren_h_data[0][20]; //���ꣲ
		$def_data["form_add3"]            = $ren_h_data[0][21]; //���ꣳ
		$def_data["form_add_read"]        = $ren_h_data[0][22]; //���ꥫ��
		$def_data["form_tel"]             = $ren_h_data[0][16]; //TEL
		$def_data["form_note"]            = $ren_h_data[0][23]; //����

		$forward_day_array = explode('-',$ren_h_data[0][27]);
		$def_data["form_forward_day"]["y"] = $forward_day_array[0]; //��󥿥�в���
		$def_data["form_forward_day"]["m"] = $forward_day_array[1];   
		$def_data["form_forward_day"]["d"] = $forward_day_array[2];   
		$def_data["form_head_staff"]       = $ren_h_data[0][28];    //����ô����
	 
		$claim_day_array = explode('-',$ren_h_data[0][30]);
		$def_data["form_claim_day"]["y"] = $claim_day_array[0];     //�����
		$def_data["form_claim_day"]["m"] = $claim_day_array[1];   

		$def_data["online_flg"]          = $ren_h_data[0][25];      //����饤��ե饰 25
		$def_data["form_h_note"]         = $ren_h_data[0][26];      //����(����)
		$def_data["hdn_coax"]            = $ren_h_data[0][31];      //�ݤ��ʬ

		//POST����δݤ��ʬ����Ƚ��
		if($_POST["hdn_coax"] != NULL){
			//POST
			$coax = $_POST["hdn_coax"]; //SUBMIT�������˻��Ѥ����
		}else{
			//DB
			$coax = $ren_h_data[0][31]; //SUBMIT�������˻��Ѥ����
		}

		$rental_day_array = explode('-',$ren_h_data[0][24]);
		$def_data["form_rental_day"]["y"] = $rental_day_array[0];   //��󥿥뿽����
		$def_data["form_rental_day"]["m"] = $rental_day_array[1];   
		$def_data["form_rental_day"]["d"] = $rental_day_array[2];   


		$online_flg = $ren_h_data[0][25];      //����饤��ե饰 25

		/****************************/
		//�ǡ�������
		/****************************/
		$sql  = "SELECT ";
		$sql .= "    t_rental_d.rental_d_id,";            //��󥿥�ǡ���ID 0
		$sql .= "    t_rental_d.rental_id,";              //��󥿥�ID 1
		$sql .= "    t_rental_d.line,";                   //�� 2
		$sql .= "    t_rental_d.goods_id,";               //����ID 3
		$sql .= "    t_rental_d.goods_cd,";               //����CD 4
		//$sql .= "    t_rental_d.official_goods_name,";    //����̾(����) 5
		$sql .= "    '',";                     //����̾(����) 5
		$sql .= "    t_rental_d.num,";                    //���� 6
		$sql .= "    t_rental_d.shop_price,";             //��󥿥�ñ�� 7
		$sql .= "    t_rental_d.shop_amount,";            //��󥿥��� 8
		$sql .= "    t_rental_d.user_price,";             //�桼��ñ�� 9
		$sql .= "    t_rental_d.user_amount,";            //�桼����� 10
		$sql .= "    t_rental_d.serial_no,";              //���ꥢ���ֹ� 11
		$sql .= "    CASE t_rental_d.rental_stat ";       //��󥿥���� 12
		$sql .= "     WHEN '0'  THEN '��ú�' ";
		$sql .= "     WHEN '10' THEN '�����' ";
		$sql .= "     WHEN '11' THEN '����������' ";
		$sql .= "     WHEN '20' THEN '�����' ";
		$sql .= "     WHEN '21' THEN '������' ";
		$sql .= "     WHEN '22' THEN '����ͽ��' ";
		$sql .= "    END,";
		$sql .= "    t_rental_d.calcel_exec,";            //����»� 13
		$sql .= "    t_rental_d.renew_num,";              //����� 14
		$sql .= "    t_rental_d.calcel_day,";             //������ 15
		$sql .= "    t_rental_d.exec_day, ";              //�»��� 16
		$sql .= "    t_rental_d.reason, ";                 //������ͳ 17
		$sql .= "    t_rental_d.rental_stat AS rental_stat_num, ";                 //��󥿥���� 18
		$sql .= "    t_rental_d.serial_flg, ";                     //���ꥢ������ե饰 19
		$sql .= "    t_rental_d.g_product_id, ";                    //����ʬ��ID 20
		$sql .= "    t_rental_d.goods_cname, ";                      //����̾��ά�Ρ� 21
		$sql .= "    t_goods.name_change ";                      //��̾�ѹ� 22
		$sql .= "FROM ";
		$sql .= "    t_rental_d ";
		$sql .= "    INNER JOIN t_goods ON t_rental_d.goods_id = t_goods.goods_id ";		
		$sql .= "WHERE ";
		$sql .= "    t_rental_d.rental_id = $rental_id ";
		$sql .= "ORDER BY line;";
		$result = Db_Query($db_con, $sql);
		$ren_d_data = Get_Data($result,2);

		//�ǡ�������
		for($i=0;$i<count($ren_d_data);$i++){
			$search_line                               = $ren_d_data[$i][2]-1; //���������

			//������font���顼Ƚ��
			if($ren_d_data[$i][12] == "����������" || $ren_d_data[$i][12] == "������"){
				$ren_d_data[$i][12] = "<font color=red>".$ren_d_data[$i][12]."</font>";

			}elseif($ren_d_data[$i][12] == "�����"){
				$ren_d_data[$i][12] = "<font color=blue>".$ren_d_data[$i][12]."</font>";
			}

			//$def_data["rental_stat"][$search_line]     = $ren_d_data[$i][12];  //��󥿥����
			$rental_stat[$search_line]     = $ren_d_data[$i][12];                  //��󥿥����
			$def_data["hdn_rental_stat_num"][$search_line] = $ren_d_data[$i][18];  //��󥿥����
			$def_data["hdn_calcel_day"][$search_line]      = $ren_d_data[$i][15];  //������
			$def_data["hdn_goods_id"][$search_line]        = $ren_d_data[$i][3];   //����ID
			$def_data["form_goods_cd"][$search_line]       = $ren_d_data[$i][4];   //����CD
			//$def_data["form_goods_name"][$search_line]     = $ren_d_data[$i][5];   //����̾
			$def_data["form_goods_cname"][$search_line]    = $ren_d_data[$i][21];  //����̾
			$def_data["form_g_product_id"][$search_line]   = $ren_d_data[$i][20];  //����ʬ��
			$def_data["form_num"][$search_line]            = $ren_d_data[$i][6];   //����
			$serial_num[$search_line]                      = $ren_d_data[$i][6];   //���ꥢ������ϥե������
			$def_data["form_serial"][$search_line][0]      = $ren_d_data[$i][11];  //���ꥢ��
			$def_data["hdn_serial_flg"][$search_line]      = $ren_d_data[$i][19];  //���ꥢ������ե饰
			$serial_flg[$search_line]                      = $ren_d_data[$i][19];  //SUBMIT�������˻��Ѥ����
			$name_change[$search_line]                     = $ren_d_data[$i][22];   //��̾�ѹ���SUBMIT�������˻��Ѥ���١�


			//��󥿥�ñ�����������Ⱦ�������ʬ����
			$ren_price = explode('.', $ren_d_data[$i][7]);
			$def_data["form_shop_price"][$search_line]["i"] = $ren_price[0];                      //��󥿥�ñ��
			$def_data["form_shop_price"][$search_line]["d"] = ($ren_price[1] != null)? $ren_price[1] : '00';     
			$def_data["form_shop_amount"][$search_line]     = number_format($ren_d_data[$i][8]);  //��󥿥���

			//�桼��ñ�����������Ⱦ�������ʬ����
			$use_price = explode('.', $ren_d_data[$i][9]);
			$def_data["form_user_price"][$search_line]["i"] = $use_price[0];  //�桼��ñ��
			$def_data["form_user_price"][$search_line]["d"] = ($use_price[1] != null)? $use_price[1] : '00';
			$def_data["form_user_amount"][$search_line]     = number_format($ren_d_data[$i][10]);  //�桼�����

			//������
			$calcel_day_array = explode('-',$ren_d_data[$i][15]);
			$def_data["form_calcel_day"][$search_line]["y"] = $calcel_day_array[0];           
			$def_data["form_calcel_day"][$search_line]["m"] = $calcel_day_array[1];   
			$def_data["form_calcel_day"][$search_line]["d"] = $calcel_day_array[2];   

			$def_data["form_renew_num"][$search_line]    = $ren_d_data[$i][14];               //�����
			$def_data["reason"][$search_line]            = $ren_d_data[$i][17];               //������ͳ

			$exec_day_array = explode('-',$ren_d_data[$i][16]);
			$def_data["form_exec_day"][$search_line]["y"] = $exec_day_array[0];               //�»���
			$def_data["form_exec_day"][$search_line]["m"] = $exec_day_array[1];   
			$def_data["form_exec_day"][$search_line]["d"] = $exec_day_array[2];   

			//����»ܥ����å�Ƚ��
			if($ren_d_data[$i][13] == 2){
				$def_data["form_calcel1"][$search_line]    = 1;               //¨����
				$calcel_msg_flg[$search_line] = true;                         //�������»�ɽ���ե饰
			}else if($ren_d_data[$i][13] == 3){
				$def_data["form_calcel2"][$search_line]    = 1;               //�������˲���
			}
		}

		//ɽ���Կ�
		if($_POST["max_row"] != NULL){
			$max_row = $_POST["max_row"];
		}else{
			//��󥿥�ǡ����ο�
			$max_row = count($ren_d_data);
		}

		//�ٹ����ɽ��
		$warning = null;

	//****************************
	//�����(������Ͽ)
	//****************************
	}else{
		//��ư���֤Υ�󥿥��ֹ����
		$sql  = "SELECT";
		$sql .= "   MAX(rental_no)";
		$sql .= " FROM";
		$sql .= "   t_rental_h";
		$sql .= ";";
		$result = Db_Query($db_con, $sql);
		$rental_no = pg_fetch_result($result, 0 ,0);
		$rental_no = $rental_no +1;
		$rental_no = str_pad($rental_no, 8, 0, STR_PAD_LEFT);
		$def_data["form_rental_no"] = $rental_no;

		//��󥿥뿽��������������������
		$def_data["form_rental_day"]["y"] = date("Y");
		$def_data["form_rental_day"]["m"] = date("m");
		$def_data["form_rental_day"]["d"] = date("d");

		//����ô���Ԥ�����󤷤��ͤ�����
		$def_data["form_app_staff"] = $staff_id;

		//���ô���Ԥ�����󤷤��ͤ�����
		$def_data["form_round_staff"] = $staff_id;

		//��󥿥��ʬ
		$def_data["online_flg"] = "f";

		//ɽ���Կ�
		if($_POST["max_row"] != null){
			$max_row = $_POST["max_row"];
		}else{
			$max_row = 5;
		}
	}
	$form->setDefaults($def_data); //���Τߥǡ������ѹ�


	/****************************/
	//�Կ��ɲý���
	/****************************/
	if($_POST["add_row_flg"]==true){
		if($_POST["max_row"] == NULL){
			//����ͤ�POST��̵���١�
			$max_row = 10;
		}else{
			//����Ԥ��5
			$max_row = $_POST["max_row"]+5;
		}
		//�Կ��ɲåե饰�򥯥ꥢ
		$cons_data["add_row_flg"] = "";
	}
	$cons_data["max_row"] = $max_row; //����Կ���hidden�˥��å�

	/****************************/
	//�Ժ������
	/****************************/
	//����Կ�
	$del_history[] = NULL; //����Կ�
	if($_POST["del_row"] != ""){

		//����ꥹ�Ȥ����
		$del_row = $_POST["del_row"];

		//������������ˤ��롣
		$del_history = explode(",", $del_row);
		//��������Կ�
		$del_num     = count($del_history)-1;
	}

	/****************************/
	//��ư���ϥܥ��󲡲�
	/****************************/
	if($_POST["auto_flg"] == true){
		$post1      = $_POST["form_post"]["no1"];             // ͹���ֹ棱
		$post2      = $_POST["form_post"]["no2"];             // ͹���ֹ棲
		$post_value = Post_Get($post1, $post2, $db_con);
		// ͹���ֹ�ե饰�򥯥ꥢ
		$cons_data["auto_flg"]  = "";
		// ͹���ֹ椫�鼫ư����
		$cons_data["form_post"]["no1"]  = $_POST["form_post"]["no1"];
		$cons_data["form_post"]["no2"]  = $_POST["form_post"]["no2"];
		$cons_data["form_add_read"] = $post_value[0];
		$cons_data["form_add1"]     = $post_value[1];
		$cons_data["form_add2"]     = $post_value[2];
		$cons_data["auto_flg"]   = "";
	}

	/****************************/
	//������ɽ���ܥ��󲡲�or��ư���ϥܥ���or��Ͽ��ǧ���̤ز���or��ϿOK�ܥ��󲡲�
	/****************************/
	/*if($_POST["input_form_flg"]==true || $_POST["auto_flg"] == true || $online_flg == "f" ||
	($_POST["comp_btn"] == "��Ͽ��ǧ���̤�" && $online_flg == 'f' && $disp_stat == 1) || 
	($_POST["ok_btn"] == "��ϿOK" && $online_flg == 'f' && $disp_stat == 1)){
*/
	if($_POST["input_form_flg"]==true || $_POST["auto_flg"] == true || $online_flg == "f" ||
	($_POST["comp_btn"] == "��Ͽ��ǧ���̤�" && $online_flg == 'f' && $disp_stat == 1) || 
	($_POST["ok_btn"] == "��ϿOK" && $online_flg == 'f' && $disp_stat == 1)){

		$serial_array = $_POST["form_num"];
		if($_POST["form_num"] == NULL){
			$serial_array = $serial_num;
		} 
		$row_disp = 1;    //�֥饦���ι��ֹ�

		for($i = 0; $i < $max_row; $i++){
			//ɽ����Ƚ��
			if(!in_array("$i", $del_history)){
				//�оݤȤʤ�ԤΥ��ꥢ�����Ͽ�
				$serial_num[$i] = $serial_array[$i];

				//���ʣã�����Ƚ��
				if($_POST["form_goods_cd"][$i] != null){
					//���ꥢ�����Ƚ��
					$goods_id[$i] = $_POST["hdn_goods_id"][$i];      //����ID
					$sql  = "SELECT serial_flg FROM t_goods WHERE goods_id = ".$goods_id[$i].";";
					$result = Db_Query($db_con, $sql);
					$goods_data = Get_Data($result);

					$cons_data["hdn_serial_flg"][$i] = $goods_data[0][0];  //���ꥢ������ե饰
					$serial_flg[$i]                  = $goods_data[0][0];  //SUBMIT�������˻��Ѥ����
				}

				//�����ꥢ��
				if($serial_flg[$i] == 't'){
					//�����ꥢ�����ϥե����ब50����礭����Ƚ��
					if($serial_num[$i] > 50){
						//$form->setElementError("form_goods_name[$i]",$row_disp."���� ���ꥢ�������� ��50�İʲ��ˤ��Ʋ�������");
						$form->setElementError("form_goods_cname[$i]",$row_disp."���� ���ꥢ�������� ��50�İʲ��ˤ��Ʋ�������");
						$serial_error_flg = true;   //���ꥢ��ɬ��Ƚ����ʤ��ե饰
						$serial_num[$i] = 0;        //���ꥢ�����ϥե��������ʤ�
					}
				}
				$row_disp++;
			}
		}

		$cons_data["input_form_flg"]   = "";
	}



	/****************************/
	//�桼�����������Ͻ���
	/****************************/
	if($_POST["client_search_flg"] == true){

		$client_cd1  = $_POST["form_client"]["cd1"];       //�桼��������1
		$client_cd2  = $_POST["form_client"]["cd2"];       //�桼��������2

		//������ξ�������
		$sql  = "SELECT";
		$sql .= "   client_id,";
		$sql .= "   client_cname,";
		$sql .= "   coax, ";
		$sql .= "   post_no1, ";
		$sql .= "   post_no2, ";
		$sql .= "   address1, ";
		$sql .= "   address2, ";
		$sql .= "   address3, ";
		$sql .= "   address_read, ";
		$sql .= "   tel ";
		$sql .= " FROM";
		$sql .= "   t_client";
		$sql .= " WHERE";
		$sql .= "   client_cd1 = '$client_cd1'";
		$sql .= "   AND";
		$sql .= "   client_cd2 = '$client_cd2'";
		$sql .= "   AND";
		$sql .= "   client_div = '1' ";
		$sql .= "   AND ";
		$sql .= "   state = '1' ";
		$sql .= "   AND";
		$sql .= "    t_client.shop_id = $shop_id";
		$sql .= ";";

		$result = Db_Query($db_con, $sql); 
		$num = pg_num_rows($result);

		//�����ǡ���������
		if($num == 1){
			$client_data = Get_Data($result,2);
			$client_id      = $client_data[0][0];        //������ID
			$client_name    = $client_data[0][1];        //������̾
			$coax           = $client_data[0][2];        //�ݤ��ʬ�ʾ��ʡ�

			//���������ǡ�����ե�����˥��å�
			$warning = null;
			$cons_data["client_search_flg"]    = "";
			$cons_data["hdn_client_id"]        = $client_id;
			$cons_data["form_client"]["name"]  = $client_name;
			$cons_data["hdn_coax"]             = $coax;

			$cons_data["form_post"]["no1"]     = $client_data[0][3]; //͹���ֹ�1
			$cons_data["form_post"]["no2"]     = $client_data[0][4]; //͹���ֹ�2
			$cons_data["form_add1"]            = $client_data[0][5]; //���꣱
			$cons_data["form_add2"]            = $client_data[0][6]; //���ꣲ
			$cons_data["form_add3"]            = $client_data[0][7]; //���ꣳ
			$cons_data["form_add_read"]        = $client_data[0][8]; //���ꥫ��
			$cons_data["form_tel"]             = $client_data[0][9]; //TEL

		}else{
			$warning = "�桼�������򤷤Ʋ�������";
			$cons_data["client_search_flg"]   = "";
			$cons_data["hdn_client_id"]       = "";
			$cons_data["form_client"]["cd1"]  = "";
			$cons_data["form_client"]["cd2"]  = "";
			$cons_data["form_client"]["name"] = "";
			$cons_data["hdn_coax"]            = "";
			$cons_data["form_post"]["no1"]    = ""; 
			$cons_data["form_post"]["no2"]    = "";
			$cons_data["form_add1"]           = "";
			$cons_data["form_add2"]           = "";
			$cons_data["form_add3"]           = "";
			$cons_data["form_add_read"]       = "";
			$cons_data["form_tel"]            = "";
		}
		//�������Ϥ��줿�ͤ�����
		for($i = 0; $i < $max_row; $i++){
			$cons_data["hdn_goods_id"][$i]           = "";
			$cons_data["rental_stat"][$i]            = "";
			$cons_data["hdn_rental_stat_num"][$i]    = "";
			$cons_data["hdn_calcel_day"][$i]         = "";
			$cons_data["form_goods_cd"][$i]          = "";
			//$cons_data["form_goods_name"][$i]        = "";
			$cons_data["form_goods_cname"][$i]        = "";
			$cons_data["form_g_product_id"][$i]        = "";
			$cons_data["form_num"][$i]               = "";
			$cons_data["form_shop_price"]["$i"]["i"] = "";
			$cons_data["form_shop_price"]["$i"]["d"] = "";
			$cons_data["form_shop_amount"][$i]       = "";
			$cons_data["form_user_price"]["$i"]["i"] = "";
			$cons_data["form_user_price"]["$i"]["d"] = "";
			$cons_data["form_user_amount"][$i]       = "";
		}
		$hdn_goods_id                     = "";
		$hdn_rental_stat                  = "";
		$hdn_rental_stat_num              = "";
		$hdn_calcel_day                   = "";

		//�Խ����
		$cons_data["del_row"]             = "";
		$cons_data["max_row"]             = 5;
		$max_row                          = 5;
		$del_history                      = NULL;
		$del_history[]                    = NULL;
		$del_row                          = NULL; 
		
	}
#echo $disp_stat."<hr>";
	/****************************/
	//���顼�����å�(addRule)
	/****************************/
	$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

	//��󥿥뿽����
	$form->addGroupRule("form_rental_day", "��󥿥뿽���� �����Ϥ��Ʋ�������",  "required"); 

	//����ô����
	$form->addRule("form_app_staff","����ô���� �����Ϥ��Ʋ�������",'required');

	//���ô����
	$form->addRule("form_round_staff","���ô���� �����Ϥ��Ʋ�������",'required');

	//͹���ֹ�
	$form->addGroupRule("form_post", "͹���ֹ� �����Ϥ��Ʋ�������",  "required"); 
	$form->addGroupRule("form_post", "͹���ֹ� �Ͽ��������Ϥ��Ʋ�������",  "numeric"); 

	//���꣱
	$form->addRule("form_add1","����1 �����Ϥ��Ʋ�������",'required');

	//����
	$form->addRule("form_note","���� ��100ʸ������Ǥ���","mb_maxlength","100");

	//���ե饤��
	if($online_flg == "f"){
		$form->addGroupRule("form_forward_day", "��󥿥�в��������Ϥ���Ƥ��ޤ���",  "required"); 
		$form->addGroupRule("form_claim_day", "�������Ϥ���Ƥ��ޤ���",  "required"); 
	}


	/****************************/
	//��Ͽ�ܥ��󡦲������ܥ����ѹ��ܥ��󲡲�����
	/****************************/
	if(($_POST["comp_btn"] == "��Ͽ��ǧ���̤�" || $_POST["comp_btn"] == "��������ǧ���̤�" || $_POST["comp_btn"] == "�ѹ���ǧ���̤�") 
	|| ($_POST["ok_btn"] == "��ϿOK" || $_POST["ok_btn"] == "������OK" || $_POST["ok_btn"] == "�ѹ�OK")){

		//�إå�������
		$rental_id       = $_POST["hdn_rental_id"];              //��󥿥�ID
		$rental_no       = $_POST["form_rental_no"];             //��󥿥��ֹ�

		$ren_day_y       = $_POST["form_rental_day"]["y"];       //��󥿥뿽����
		$ren_day_m       = $_POST["form_rental_day"]["m"];            
		$ren_day_d       = $_POST["form_rental_day"]["d"];            

		if($ren_day_y != null && $ren_day_m != null && $ren_day_d != null){
			$ren_day_y = str_pad($ren_day_y,4, 0, STR_PAD_LEFT);  
			$ren_day_m = str_pad($ren_day_m,2, 0, STR_PAD_LEFT); 
			$ren_day_d = str_pad($ren_day_d,2, 0, STR_PAD_LEFT); 
			$ren_day   = $ren_day_y."-".$ren_day_m."-".$ren_day_d; //���դη����ѹ�
		}

		$for_day_y       = $_POST["form_forward_day"]["y"];      //��󥿥�в���
		$for_day_m       = $_POST["form_forward_day"]["m"];            
		$for_day_d       = $_POST["form_forward_day"]["d"];            

		if($for_day_y != null && $for_day_m != null && $for_day_d != null){
			$for_day_y = str_pad($for_day_y,4, 0, STR_PAD_LEFT);  
			$for_day_m = str_pad($for_day_m,2, 0, STR_PAD_LEFT); 
			$for_day_d = str_pad($for_day_d,2, 0, STR_PAD_LEFT); 
			$for_day   = $for_day_y."-".$for_day_m."-".$for_day_d; //���դη����ѹ�
		}

		$claim_day_y     = $_POST["form_claim_day"]["y"];        //�����
		$claim_day_m     = $_POST["form_claim_day"]["m"];   

		$client_cd1      = $_POST["form_client"]["cd1"];         //������CD1
		$client_cd2      = $_POST["form_client"]["cd2"];         //������CD2
		$app_staff       = $_POST["form_app_staff"];             //����ô����
		$round_staff     = $_POST["form_round_staff"];           //���ô����
		$tel             = $_POST["form_tel"];                   //�桼��TEL
		$post_no1        = $_POST["form_post"]["no1"];           //͹���ֹ�
		$post_no2        = $_POST["form_post"]["no2"];       
		$add1            = $_POST["form_add1"];                  //���꣱
		$add2            = $_POST["form_add2"];                  //���ꣲ
		$add3            = $_POST["form_add3"];                  //���ꣳ
		$add_read        = $_POST["form_add_read"];              //���ꥫ��
		$note            = $_POST["form_note"];                  //����

		//�ǡ�������
		$j = 0;           //�ǡ��������ź��
		$row_disp = 1;    //�֥饦���ι��ֹ�
		for($i = 0; $i < $max_row; $i++){
			//ɽ����Ƚ��
			if(!in_array("$i", $del_history)){

				if($_POST["form_goods_cd"][$i] != null){
					$j = $i;
					$goods_id[$j]         = $_POST["hdn_goods_id"][$i];                          //����ID
					//$goods_name[$j]       = $_POST["form_goods_name"][$i];                     //����̾
					$goods_cname[$j]      = $_POST["form_goods_cname"][$i];                      //����̾
					$g_product_id[$j]     = $_POST["form_g_product_id"][$i];                     //����̾
					$goods_cd[$j]         = $_POST["form_goods_cd"][$i];                         //����CD
					$num[$j]              = $_POST["form_num"][$i];                              //����
					$serial[$j]           = $_POST["form_serial"][$i];                           //���ꥢ��
					$shop_price_i[$j]     = $_POST["form_shop_price"][$i]["i"];                  //��󥿥�ñ������������
					$shop_price_d[$j]     = $_POST["form_shop_price"][$i]["d"];                  //��󥿥�ñ���ʾ�������
					$user_price_i[$j]     = $_POST["form_user_price"][$i]["i"];                  //�桼��ñ������������
					$user_price_d[$j]     = $_POST["form_user_price"][$i]["d"];                  //�桼��ñ���ʾ�������
					$shop_amount[$j]      = str_replace(',','',$_POST["form_shop_amount"][$i]);  //��󥿥���
					$user_amount[$j]      = str_replace(',','',$_POST["form_user_amount"][$i]);  //�桼�����
	
					$renew_num[$j]        = $_POST["form_renew_num"][$i];                        //�����
					$calcel1[$j]          = $_POST["form_calcel1"][$i];                          //��������å���
					$calcel2[$j]          = $_POST["form_calcel2"][$i];                          //��������å���
					$exec_day_y[$j]       = $_POST["form_exec_day"][$i]["y"];                    //�»���
					$exec_day_m[$j]       = $_POST["form_exec_day"][$i]["m"];            
					$exec_day_d[$j]       = $_POST["form_exec_day"][$i]["d"];            
					$reason[$j]           = $_POST["reason"][$i];                  //������ͳ

					$hdn_calcel_day[$j]   = $_POST["hdn_calcel_day"][$i];                          //������
					//$hdn_rental_stat[$j]  = $_POST["hdn_rental_stat"][$i];                       //����
					$rental_stat_num[$j]  = $_POST["hdn_rental_stat_num"][$i];                     //����

					//�إå��ι�׶�۷׻�
					$total_shop = bcadd($total_shop,$shop_amount[$j]);
					$total_user = bcadd($total_user,$user_amount[$j]);
					/****************************/
					//���顼�����å�(PHP)
					/****************************/
					//���ʥ����å�
					//���̡���󥿥�ñ�����桼��ñ�������ϥ����å�
					if($goods_id[$j] != null && ($num[$j] == null || $shop_price_i[$j] == null || $shop_price_d[$j] == null || $user_price_i[$j] == null || $user_price_d[$j] == null)){
						$form->setElementError("form_goods_cd[$i]",$row_disp."���� ���̤ȥ�󥿥�ñ���ȥ桼����ñ����ɬ�ܤǤ���");
					}
	
					//������
					//�����ο�Ƚ��
					if(!ereg("^[0-9]+$",$num[$j]) && $num[$j] != null){
						$form->setElementError("form_num[$i]",$row_disp."���� ���� ��0�ʾ�����Ϥ��Ʋ�������");
					}
	
					//����󥿥�ñ��
					//�����ο�Ƚ��
					if((!ereg("^[0-9]+$",$shop_price_i[$j]) && $shop_price_i[$j] != NULL) || (!ereg("^[0-9]+$",$shop_price_d[$j]) && $shop_price_d[$j] != NULL)){
						$form->setElementError("form_shop_price[$i]",$row_disp."���� ��󥿥�ñ�� ��0�ʾ�����Ϥ��Ʋ�������");
					}
	
					//���桼��ñ��
					//�����ο�Ƚ��
					if((!ereg("^[0-9]+$",$user_price_i[$j]) && $user_price_i[$j] != NULL) || (!ereg("^[0-9]+$",$user_price_d[$j]) && $user_price_d[$j] != NULL)){
						$form->setElementError("form_user_price[$i]",$row_disp."���� �桼����ñ�� ��0�ʾ�����Ϥ��Ʋ�������");
					}
	
					//����ѡ������Ƚ��(����˥����å����դ��Ƥ�����or����������ϺѤ�����Ԥ�)
					if($disp_stat == 2 && ($calcel1[$j] != null || $calcel2[$j] != null || $renew_num[$j] != NULL)){
						//�������
						//��������Ƚ��
						if($num[$j] < $renew_num[$j]){
							//���̤�������������礭���ä���票�顼
							$form->setElementError("form_renew_num[$i]",$row_disp."���� ���ʤβ���������̤�Ķ���Ƥ��ޤ���");
						}
						//�����ο�Ƚ��
						if(!ereg("^[0-9]+$",$renew_num[$j])){
							$form->setElementError("form_renew_num[$i]",$row_disp."���� ����� ��1�ʾ�����Ϥ��Ʋ�������");
						}
						//����������ʾ夫Ƚ��
						if($renew_num[$j] < 1){
							$form->setElementError("form_renew_num[$i]",$row_disp."���� ����� ��1�ʾ�����Ϥ��Ʋ�������");
						}

						//����ʬ�ࡢ����̾��ά�Ρ����ꥢ������ե饰���֤�
						$goods_data = Get_Goods_Info($db_con,$goods_id[$i]);
						if($goods_data[serial_flg] == "t" && $renew_num[$i] != "1"){
							$form->setElementError("form_renew_num[$i]",$row_disp."���� ���ꥢ���������ξ��ʤ� �������1�����Ϥ��Ʋ�������");
						}


						//�»����˥����å����դ��Ƥ������˥��顼Ƚ��
						if($calcel2[$j] != null){
							//���»���
	
							$exec_day_y[$j] = str_pad($exec_day_y[$j],4, 0, STR_PAD_LEFT);  
							$exec_day_m[$j] = str_pad($exec_day_m[$j],2, 0, STR_PAD_LEFT); 
							$exec_day_d[$j] = str_pad($exec_day_d[$j],2, 0, STR_PAD_LEFT); 
	
							//���դη����ѹ�
							//$exec_day[$j]  = date("Y-m-d",mktime(0, 0, 0,$exec_day_m[$j],$exec_day_d[$j],$exec_day_y[$j]));
							$exec_day[$j]  = $exec_day_y[$j]."-".$exec_day_m[$j]."-".$exec_day_d[$j];
	
							//����������Ƚ��
							$exec_today = date("Y-m-d");
							if($exec_today >= $exec_day[$j]){
								$form->setElementError("form_exec_day[$i]",$row_disp."���� �»��� �����դ������ʹߤ����Ϥ��Ʋ�������");
							}
	
							//����Ƚ��
							if(!ereg("^[0-9]{4}$",$exec_day_y[$j]) || !ereg("^[0-9]{2}$",$exec_day_m[$j]) || !ereg("^[0-9]{2}$",$exec_day_d[$j])){
								$form->setElementError("form_exec_day[$i]",$row_disp."���� �»��� �����դ������ǤϤ���ޤ���");
							}
	
							$exec_day_y[$j] = (int)$exec_day_y[$j];
							$exec_day_m[$j] = (int)$exec_day_m[$j];
							$exec_day_d[$j] = (int)$exec_day_d[$j];
	
							//��������Ƚ��
							if(!checkdate($exec_day_m[$j],$exec_day_d[$j],$exec_day_y[$j])){
								$form->setElementError("form_exec_day[$i]",$row_disp."���� �»��� �����դ������ǤϤ���ޤ���");
							}
						}
	
						//����������å�
						//��������Ƚ��
						if($calcel1[$j] != null && $calcel2[$j] != null){
							$form->setElementError("form_calcel1[$i]",$row_disp."���� �»��� �Υ����å��ϰ�ĤޤǤǤ���");
						}
						//��ɬ��Ƚ��
						if($calcel1[$j] == null && $calcel2[$j] == null){
							$form->setElementError("form_calcel1[$i]",$row_disp."���� �»��� �˥����å������դ��Ʋ�������");
						}
					}
	
					$j++;
				}else{
						//���ʰʳ�����������ͤ����뤫Ƚ��
					if($_POST["form_num"][$i] != NULL || $_POST["form_shop_price"][$i]["i"] != NULL || $_POST["form_shop_price"][$i]["d"] != NULL || $_POST["form_user_price"][$i]["i"] != NULL || $_POST["form_user_price"][$i]["d"] != NULL || $_POST["form_renew_num"][$i] != NULL || $_POST["form_calcel1"][$i] != NULL || $_POST["form_calcel2"][$i] != NULL || $_POST["form_exec_day"][$i]["y"] != NULL || $_POST["form_exec_day"][$i]["m"] != NULL || $_POST["form_exec_day"][$i]["d"] != NULL){
							$form->setElementError("form_goods_cd[$i]",$row_disp."���� ���ʤ����򤷤Ʋ�������");
							//������������å���Ԥ�ʤ�
							$goods_check_flg = true;
						}
				}
				$row_disp++;
			}
		}

		/****************************/
		//���顼�����å�(PHP)
		/****************************/
		$error_flg = false;                                         //���顼Ƚ��ե饰

		//��󥿥뿽����
		//��ʸ��������å�
		if($ren_day_y != null && $ren_day_m != null && $ren_day_d != null){

			$ren_day_y = str_pad($ren_day_y,4, 0, STR_PAD_LEFT);  
			$ren_day_m = str_pad($ren_day_m,2, 0, STR_PAD_LEFT); 
			$ren_day_d = str_pad($ren_day_d,2, 0, STR_PAD_LEFT); 

			//���դη����ѹ�
			//$ren_day  = date("Y-m-d",mktime(0, 0, 0,$ren_day_m,$ren_day_d,$ren_day_y));
			$ren_day  = $ren_day_y."-".$ren_day_m."-".$ren_day_d;

			//����Ƚ��
			if(!ereg("^[0-9]{4}$",$ren_day_y) || !ereg("^[0-9]{2}$",$ren_day_m) || !ereg("^[0-9]{2}$",$ren_day_d)){
				$form->setElementError("form_rental_day","��󥿥뿽���� �����դ������ǤϤ���ޤ���");
				$error_flg = true;
			}

			//��ʸ��������å�
			$ren_day_y = (int)$ren_day_y;
			$ren_day_m = (int)$ren_day_m;
			$ren_day_d = (int)$ren_day_d;

			//���դ�������Ƚ��
			if(!checkdate($ren_day_m,$ren_day_d,$ren_day_y)){
				//���顼

				$form->setElementError("form_rental_day","��󥿥뿽���� �����դ������ǤϤ���ޤ���");
				$error_flg = true;
			}else{
				//����������

				//�����ƥ೫�ϻ���Ƚ��
				$err_msge = Sys_Start_Date_Chk($ren_day_y,$ren_day_m,$ren_day_d,"��󥿥뿽����");
				if($err_msge != null){
					$form->setElementError("form_rental_day","$err_msge"); 
				}
			}
		}

		//��󥿥�в���
		//�������������å�
		if($for_day_y != null && $for_day_m != null && $for_day_d != null){

			$for_day_y = str_pad($for_day_y,4, 0, STR_PAD_LEFT);  
			$for_day_m = str_pad($for_day_m,2, 0, STR_PAD_LEFT); 
			$for_day_d = str_pad($for_day_d,2, 0, STR_PAD_LEFT); 

			//���դη����ѹ�
			//$for_day  = date("Y-m-d",mktime(0, 0, 0,$for_day_m,$for_day_d,$for_day_y));
			$for_day  = $for_day_y."-".$for_day_m."-".$for_day_d;

			//����Ƚ��
			if(!ereg("^[0-9]{4}$",$for_day_y) || !ereg("^[0-9]{2}$",$for_day_m) || !ereg("^[0-9]{2}$",$for_day_d)){
				$form->setElementError("form_forward_day","��󥿥�в��� �����դ������ǤϤ���ޤ���");
				$error_flg = true;
			}

			//��ʸ��������å�
			$for_day_y = (int)$for_day_y;
			$for_day_m = (int)$for_day_m;
			$for_day_d = (int)$for_day_d;

			//���դ�������Ƚ��
			if(!checkdate($for_day_m,$for_day_d,$for_day_y)){
				//���顼

				$form->setElementError("form_forward_day","��󥿥�в��� �����դ������ǤϤ���ޤ���");
				$error_flg = true;
			}else{
				//����������

				//�����ƥ೫�ϻ���Ƚ��
				$err_msge = Sys_Start_Date_Chk($for_day_y,$for_day_m,$for_day_d,"��󥿥�в���");
				if($err_msge != null){
					$form->setElementError("form_forward_day","$err_msge"); 
				}
			}
		}

		//��󥿥�в������������������Ƚ��
		if($error_flg == false && $ren_day > $for_day && $for_day != NULL){
			$form->setElementError("form_rental_day","��󥿥뿽���� �����դϥ�󥿥�в������������դ����Ϥ��Ʋ�������");
		}

		//�����
		if($claim_day_y != null && $claim_day_m != null){

			$claim_day_y = str_pad($claim_day_y,4, 0, STR_PAD_LEFT);  
			$claim_day_m = str_pad($claim_day_m,2, 0, STR_PAD_LEFT); 
			$claim_ymd = $claim_day_y."-".$claim_day_m."-01"; //����ǯ����

			//����Ƚ��
			if(!ereg("^[0-9]{4}$",$claim_day_y) || !ereg("^[0-9]{2}$",$claim_day_m)){
				$form->setElementError("form_claim_day","����� �����դ������ǤϤ���ޤ���");
			}

			//��ʸ��������å�
			$claim_day_y = (int)$claim_day_y;
			$claim_day_m = (int)$claim_day_m;
			$claim_day_d = 1;

			//$for_ymd   = date("Y-m-d",mktime(0, 0, 0,$for_day_m,1,$for_day_y));     //�в�ǯ����
			//$claim_ymd = date("Y-m-d",mktime(0, 0, 0,$claim_day_m,1,$claim_day_y)); //����ǯ����
			$for_ymd   = str_pad($for_day_y,4, 0, STR_PAD_LEFT)."-".str_pad($for_day_m,2, 0, STR_PAD_LEFT)."-01";     //�в�ǯ����

			//�����в���������ξ��
			if($claim_ymd < $for_ymd ){
				$form->setElementError("form_claim_day","����� �ϥ�󥿥�в����ʹߤ����Ϥ��Ʋ�������");
			}

			//������󥿥�в����������Ƚ��
			//if($for_ymd >= $claim_ymd){
				//$form->setElementError("form_claim_day","����� �����դϥ�󥿥�в��������ʹߤ����Ϥ��Ʋ�������");
			//}

			//���դη����ѹ�
			$claim_day  = $claim_day_y."-".$claim_day_m."-".$claim_day_d;
			//�������������å�
			if(!checkdate($claim_day_m,$claim_day_d,$claim_day_y)){
				//���顼
				$form->setElementError("form_claim_day","����� �����դ������ǤϤ���ޤ���");

			}else{
				//����������

				//�����ƥ೫�ϻ���Ƚ��
				$err_msge = Sys_Start_Date_Chk($claim_day_y,$claim_day_m,$claim_day_d,"�����");
				if($err_msge != null){
					$form->setElementError("form_claim_day","$err_msge"); 
				}
			}
		}

		//$form->registerRule("check_date","function","check_date");
		//$form->addRule("form_rental_day", "��󥿥뿽���� �����դ������ǤϤ���ޤ���",  "check_date", $_POST["form_rental_day"]);
		//$form->addRule("form_forward_day", "��󥿥�в��� �����դ������ǤϤ���ޤ���",  "check_date", $_POST["form_forward_day"]);

		//��͹���ֹ�
		//�ޥ��ʥ�Ƚ��
		if(!ereg("^[0-9]{3}$",$post_no1) || !ereg("^[0-9]{4}$",$post_no2)){
			$form->setElementError("form_post","͹���ֹ� �Ͽ��������Ϥ��Ʋ�������");
		}

		//TEL
		//��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
		if($tel != NULL && !ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$tel)){
			$form->setElementError("form_tel","TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���");
		}

		//�桼��̾
		//�����ͥ����å�
		$injust = Injustice_check($db_con,"client",$client_id,$client_cd1,$client_cd2);
		if($injust == false){
			$error_msg2 = "�桼�� �ξ��󤬼����Ǥ��ޤ���Ǥ�������������ԤäƲ�������";
			$error_flg = true;        //���顼ɽ��
		}

		//���ʰʳ�����������ͤ����롦�桼���������ͤξ��ʲ��ν����ϹԤ�ʤ�
		if($goods_check_flg == false && $error_msg2 == NULL){
			//������������å�
			for($i = 0; $i < count($goods_id); $i++){
				//if($goods_name[$i] != null){
				if($goods_cname[$i] != null){
				   $input_error_flg = true;
				}
			}
			if($input_error_flg != true){
				$goods_error ="���ʤ���Ĥ����򤵤�Ƥ��ޤ���";
				$error_flg = true;
			}
		}

		//���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
		if($form->validate() && $error_flg == false){

			//��ǧ����Ƚ��
			if($_POST["ok_btn"] == "��ϿOK" || $_POST["ok_btn"] == "������OK" || $_POST["ok_btn"] == "�ѹ�OK"){

				//��󥿥�إå�����󥿥�ǡ�������Ͽ������SQL
				Db_Query($db_con, "BEGIN");

				$duplicate_flg = false;      //��ʣȽ��ե饰

				//����ɽ������Ƚ��
				if($disp_stat == 1){
					//��󥿥�ID̵��

					//��󥿥�إå���Ͽ
					$sql  = "INSERT INTO t_rental_h (";
					$sql .= "    rental_id,";          //��󥿥�ID
					$sql .= "    rental_no,";          //��󥿥��ֹ�
					$sql .= "    shop_id,";            //����å�ID
					$sql .= "    shop_cd1,";           //����å�CD1
					$sql .= "    shop_cd2,";           //����å�CD2
					$sql .= "    shop_name,";          //����å�̾1
					$sql .= "    shop_name2,";         //����å�̾2
					$sql .= "    shop_cname,";         //����å�̾(ά��)
					$sql .= "    ap_staff_id,";        //����ô����ID
					$sql .= "    ap_staff_name,";      //����ô����̾
					$sql .= "    c_staff_id,";         //���ô����ID
					$sql .= "    c_staff_name,";       //���ô����̾
					$sql .= "    client_id,";          //������ID
					$sql .= "    client_cd1, ";        //������CD1
					$sql .= "    client_cd2, ";        //������CD2
					$sql .= "    client_name, ";       //������̾1
					$sql .= "    client_name2, ";      //������̾2
					$sql .= "    client_cname, ";      //ά��
					$sql .= "    tel, ";               //TEL
					$sql .= "    post_no1, ";          //͹���ֹ�1
					$sql .= "    post_no2, ";          //͹���ֹ�2
					$sql .= "    address1, ";          //����1
					$sql .= "    address2, ";          //����2
					$sql .= "    address3, ";          //����3
					$sql .= "    address_read, ";      //���ꥫ��
					//$sql .= "    note_h, ";          //����(����)
					$sql .= "    note_fc, ";           //����(FC)
					$sql .= "    apply_day, ";         //��󥿥뿽����
					$sql .= "    forward_day, ";     //��󥿥�в���
					//$sql .= "    h_staff_id, ";      //����ô����ID
					//$sql .= "    h_staff_name, ";    //����ô����̾
					$sql .= "    claim_day, ";       //�����
					$sql .= "    online_flg, ";        //����饤��ե饰
					$sql .= "    regist_shop_id, ";    //��Ͽ����å�ID
					$sql .= "    shop_amount, ";       //��󥿥���
					$sql .= "    user_amount ";        //�桼�����

					$sql .= ")VALUES(";
					$sql .= "    (SELECT COALESCE(MAX(rental_id), 0)+1 FROM t_rental_h),";         
					$sql .= "    '$rental_no',";          
					$sql .= "    $shop_id,";
					$sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT shop_name FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $shop_id), ";
					$sql .= "    $app_staff,";
					$sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $app_staff), ";
					$sql .= "    $round_staff,";
					$sql .= "    (SELECT staff_name FROM t_staff WHERE staff_id = $round_staff), ";
					$sql .= "    $client_id,"; 
					$sql .= "    '$client_cd1',";
					$sql .= "    '$client_cd2',";   
					$sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";                 
					$sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
					$sql .= "    '$client_name',"; 
					$sql .= "    '$tel',";
					$sql .= "    '$post_no1',";
					$sql .= "    '$post_no2',";
					$sql .= "    '$add1',";
					$sql .= "    '$add2',";
					$sql .= "    '$add3',";
					$sql .= "    '$add_read',";
					$sql .= "    '$note',";
					$sql .= "    '$ren_day',";
					//$sql .= "    't',";
					if($for_day != NULL){
						$sql .= "    '$for_day',"; 
					}else{
						$sql .= "    NULL,"; 
					}
					if($claim_day != NULL){
						$sql .= "    '$claim_day',"; 
					}else{
						$sql .= "    NULL,"; 
					}
					$sql .= "    '$online_flg',";
					$sql .= "    $shop_id,";
					$sql .= "    $total_shop,";
					$sql .= "    $total_user";
					$sql .= ");";

					$result = Db_Query($db_con, $sql);
					//Ʊ���¹��������
					if($result === false){
						$err_message = pg_last_error();
						$err_format = "t_rental_h_rental_no_key";

						Db_Query($db_con, "ROLLBACK");

						//��󥿥��ֹ椬��ʣ�������            
						if(strstr($err_message,$err_format) != false){
							$error_msg = "Ʊ���˿�����Ԥä��١���󥿥��ֹ椬��ʣ���ޤ������⤦���ٿ����򤷤Ʋ�������";
				 
							//���٥�󥿥��ֹ���������
							$sql  = "SELECT";
							$sql .= "   MAX(rental_no)";
							$sql .= " FROM";
							$sql .= "   t_rental_h";
							$sql .= ";";
							$result = Db_Query($db_con, $sql);
							$rental_no = pg_fetch_result($result, 0 ,0);
							$rental_no = $rental_no +1;
							$rental_no = str_pad($rental_no, 8, 0, STR_PAD_LEFT);

							$cons_data["form_rental_no"] = $rental_no;

							$duplicate_flg = true;
						}else{
							exit;
						}
					}

				}else if($disp_stat == 2 || $disp_stat == 5){
					//����ѡ������
					//��ú�
					
					//��󥿥�إå�����
					$sql  = "UPDATE t_rental_h SET";
					$sql .= "    shop_id =  $shop_id,";                                                               //����å�ID
					$sql .= "    shop_cd1 = (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id),";           //����å�CD1
					$sql .= "    shop_cd2 = (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id),";           //����å�CD2
					$sql .= "    shop_name = (SELECT shop_name FROM t_client WHERE client_id = $shop_id),";           //����å�̾
					$sql .= "    shop_name2 = (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id),";         //����å�̾2
					$sql .= "    shop_cname = (SELECT client_cname FROM t_client WHERE client_id = $shop_id),";       //����å�̾(ά��)
					$sql .= "    ap_staff_id = $app_staff,";                                                          //����ô����ID
					$sql .= "    ap_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $app_staff),";      //����ô����̾
					$sql .= "    c_staff_id = $round_staff,";                                                         //���ô����ID
					$sql .= "    c_staff_name = (SELECT staff_name FROM t_staff WHERE staff_id = $round_staff),";     //���ô����̾
					$sql .= "    client_id = $client_id,";                                                            //������ID
					$sql .= "    client_cd1 = '$client_cd1', ";                                                       //������CD1
					$sql .= "    client_cd2 = '$client_cd2', ";                                                       //������CD2
					$sql .= "    client_name = (SELECT client_name FROM t_client WHERE client_id = $client_id), ";    //������̾1
					$sql .= "    client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";  //������̾2
					$sql .= "    client_cname = '$client_name', ";                                                    //ά��
					$sql .= "    tel = '$tel', ";                                                                     //TEL
					$sql .= "    post_no1 = '$post_no1', ";                                                           //͹���ֹ�1
					$sql .= "    post_no2 = '$post_no2', ";                                                           //͹���ֹ�2
					$sql .= "    address1 = '$add1', ";                                                               //����1
					$sql .= "    address2 = '$add2', ";                                                               //����2
					$sql .= "    address3 = '$add3', ";                                                               //����3
					$sql .= "    address_read = '$add_read', ";                                                       //���ꥫ��
					//$sql .= "    note_h, ";                                                                         //����(����)
					$sql .= "    note_fc = '$note', ";                                                                //����(FC)
					$sql .= "    apply_day   = '$ren_day', ";                                                         //��󥿥뿽����
					if($for_day != NULL){
						$sql .= "    forward_day = '$for_day', ";                                                         //��󥿥�в���
					}
					if($claim_day != NULL){
						$sql .= "    claim_day = '$claim_day', ";                                                          //�����
					}


					//$sql .= "    forward_day = '$for_day', ";                                                         //��󥿥�в���
					//$sql .= "    h_staff_id, ";                                                                     //����ô����ID
					//$sql .= "    h_staff_name, ";                                                                   //����ô����̾
					//$sql .= "    claim_day = '$claim_day', ";                                                          //�����
					//$sql .= "    online_flg, ";                                                                     //����饤��ե饰
					$sql .= "    shop_amount = $total_shop, ";                                                        //��󥿥���
					$sql .= "    user_amount = $total_user ";                                                         //�桼�����
					$sql .= "WHERE ";
					$sql .= "    rental_id = $rental_id;";
					$result = Db_Query($db_con, $sql);
					if($result == false){
						Db_Query($db_con, "ROLLBACK");
						exit;
					}
					//��úѤξ��Τߥǡ������
					if($online_flg == "f" || $disp_stat == 5){
						//��󥿥�ǡ�������
						Delete_Rental_D($db_con,$rental_id);
					}
				}


				//****************************
				//��󥿥�ǡ�����Ͽ
				//****************************
				//���ե饤�� or ������Ͽ or ��ú�
				if($online_flg == "f" || $disp_stat == 1 || $disp_stat == 5){

					//��󥿥�ǡ�������
					//Delete_Rental_D($db_con,$rental_id);

					if($duplicate_flg != true){
						//��󥿥�ǡ�����Ͽ
						$line = 1;  //��
						while($goods_num = each($goods_id)){
							$g_num = $goods_num[0];

							//ñ�����������Ⱦ���������
							$r_price = $shop_price_i[$g_num].".".$shop_price_d[$g_num];   //��󥿥�ñ��
							$u_price = $user_price_i[$g_num].".".$user_price_d[$g_num];   //�桼��ñ��

							//��󥿥��������
							//���ե饤��ξ��
							if($online_flg == "f"){
								//POST�ǡ�����̵�����
								if($rental_stat_num[$g_num] == NULL){
									$rental_stat_num[$g_num] = 10; //�����
								}
								
							//����饤��ξ��
							}else{
								$rental_stat_num[$g_num] = 11; //��������
							}
							
							//��󥿥�ID����
							$sql           = "SELECT rental_id FROM t_rental_h WHERE rental_no = '$rental_no'";  
							$result        = Db_Query($db_con, $sql);
							$rental_id_sql = pg_fetch_result($result,0,0);
/*
							//����ʬ�ࡦ����̾�μ���
							$sql  = "SELECT ";
							$sql .= "    t_g_product.g_product_name,";
							$sql .= "    t_g_product.g_product_name || '��' || t_goods.goods_name, ";
							$sql .= "    t_goods.goods_name,";
							$sql .= "    t_goods.serial_flg ";
							$sql .= "FROM ";
							$sql .= "    t_g_product ";
							$sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
							$sql .= "WHERE ";
							$sql .= "    t_goods.goods_id = ".$goods_id[$g_num].";";
							$result = Db_Query($db_con, $sql);
							//$pro_data = Get_Data($result,3);
							$pro_data = pg_fetch_array($result);
*/
							//����ʬ�ࡢ����̾��ά�Ρ����ꥢ������ե饰���֤�
							$pro_data = Get_Goods_Info($db_con,$goods_id[$g_num]);
							$gpro_data = Get_G_Product_Info($db_con,$g_product_id[$g_num]);


							//���ꥢ���������
							if($serial_flg[$g_num] == 't'){

								//���ꥢ��ʬ�ǡ�����Ͽ
								for($n = 0; $n < $num[$g_num]; $n++){
									$rental_d_column = NULL;
									$rental_d_column = array(
										"rental_d_id"         => Get_Pkey(),
										"rental_id"           => "$rental_id_sql",
										"line"                => "$line",
										"goods_id"            => "$goods_id[$g_num]",
										"goods_cd"            => "$goods_cd[$g_num]",
										"g_product_id"        => "$gpro_data[g_product_id]",
										//"g_product_name"      => "$pro_data[g_product_name]",
										//"official_goods_name" => "$pro_data[official_goods_name]",
										//"goods_name"          => "$pro_data[goods_name]",
										//"goods_cname"         => "$pro_data[goods_cname]",
										"goods_cname"         => $goods_cname[$g_num],
										"num"                 => "1",
										"serial_no"           => $serial[$g_num][$n],
										"serial_flg"          => "t",
										"shop_price"          => "$r_price",
										"shop_amount"         => ($shop_amount[$g_num] / $num[$g_num]),
										"user_price"          => "$u_price",
										"user_amount"         => ($user_amount[$g_num] / $num[$g_num]),
										"rental_stat"         => "$rental_stat_num[$g_num]",
										"calcel_exec"         => "1",
										"calcel_day"          => "$hdn_calcel_day[$g_num]",
										"reason"              => "$reason[$g_num]",
									);
									//print_array($rental_d_column,"��");
									$rental_d_column = pg_convert($db_con,'t_rental_d',$rental_d_column);//SQL���󥸥���������к�
									//print_array($rental_d_column,"��");

									$result = Db_Insert($db_con, t_rental_d, $rental_d_column);
									if($result == false){
										Db_Query($db_con, "ROLLBACK");
										exit;
									}
									$line++;

								}

							//���ꥢ��������ʤ�
							}else{

								$rental_d_column = NULL;
								$rental_d_column = array(
									"rental_d_id"         => Get_Pkey(),
									"rental_id"           => "$rental_id_sql",
									"line"                => "$line",
									"goods_id"            => "$goods_id[$g_num]",
									"goods_cd"            => "$goods_cd[$g_num]",
									"g_product_id"        => "$gpro_data[g_product_id]",
									//"g_product_name"      => "$pro_data[g_product_name]",
									//"official_goods_name" => "$pro_data[official_goods_name]",
									//"goods_name"          => "$pro_data[goods_name]",
									//"goods_cname"         => "$pro_data[goods_cname]",
									"goods_cname"         => $goods_cname[$g_num],
									"num"                 => "$num[$g_num]",
									"serial_no"           => NULL,
									"serial_flg"          => "$pro_data[3]",
									"shop_price"          => "$r_price",
									"shop_amount"         => "$shop_amount[$g_num]",
									"user_price"          => "$u_price",
									"user_amount"         => "$user_amount[$g_num]",
									"rental_stat"         => "$rental_stat_num[$g_num]",
									"calcel_exec"         => "1",
									"calcel_day"          => "$hdn_calcel_day[$g_num]",
									"reason"              => "$reason[$g_num]",
								);

								$rental_d_column = pg_convert($db_con,'t_rental_d',$rental_d_column);//SQL���󥸥���������к�
								$result = Db_Insert($db_con, t_rental_d, $rental_d_column);

								if($result == false){
									Db_Query($db_con, "ROLLBACK");
									exit;
								}

								$line++;
							}
						}
						//��ɸ��ꥻ�åȤ���
						reset($goods_id);
					}
				}



				//****************************
				//��󥿥�ǡ�����Ͽ
				//****************************
/*

					if($duplicate_flg != true){
						//��󥿥�ǡ�����Ͽ
						for($g_num = 0; $g_num < count($goods_id); $g_num++){
							//��
							$line = $g_num + 1;


							$rental_d_column = NULL;
							$rental_d_column = array(
								"rental_d_id"         => Get_Pkey(),
								"rental_id"           => "$rental_id_sql",
								"line"                => "$line",
								"goods_id"            => "$goods_id[$g_num]",
								"goods_cd"            => "$goods_cd[$g_num]",
								"g_product_name"      => "$pro_data[0]",
								"official_goods_name" => "$pro_data[1]",
								"goods_name"          => "$pro_data[2]",
								"num"                 => "$num[$g_num]",
								"serial_no"           => "$serial[$g_num]",
								"serial_flg"          => "$pro_data[3]",
								"shop_price"          => "$r_price",
								"shop_amount"         => "$shop_amount[$g_num]",
								"user_price"          => "$u_price",
								"user_amount"         => "$user_amount[$g_num]",
								"rental_stat"         => "$rental_stat_num[$g_num]",
								"calcel_exec"         => "1",
								"calcel_day"          => "$hdn_calcel_day[$g_num]",
								"reason"              => "$reason[$g_num]",
							);
							$rental_d_column = pg_convert($db_con,'t_rental_d',$rental_d_column);//SQL���󥸥���������к�
							$result = Db_Insert($db_con, t_rental_d, $rental_d_column);

							if($result == false){
								Db_Query($db_con, "ROLLBACK");
								exit;
							}

						}
					}
				}
*/
				//****************************
				//�������
				//****************************
				//}else if($disp_stat == 2){
				//����ѡ������
				if($disp_stat == 2){

					//��󥿥�ǡ�������
					for($g_num = 0; $g_num < count($goods_id); $g_num++){
						//��
						$line = $g_num + 1;

						//�����å����դ��Ƥ���ԤΤ߲�����
						if($calcel1[$g_num] != null || $calcel2[$g_num] != null){
							$sql  = "UPDATE t_rental_d SET ";
							//����»�Ƚ��
							if($calcel1[$g_num] != NULL){
								//¨����
								$sql .= "    calcel_exec = '2',";                 //����»�
							}else if($calcel2[$g_num] != NULL){
								//�������˲���
								$sql .= "    calcel_exec = '3',";                 //����»�
								$sql .= "    exec_day = '".$exec_day[$g_num]."',";    //�»���
							}
							$sql .= "    renew_num = ".$renew_num[$g_num].",";        //�����
							$sql .= "    reason    = '".$reason[$g_num]."',";           //������ͳ
							$sql .= "    rental_stat = '21' ";                    //��󥿥������������ˤ���
							$sql .= " WHERE ";
							$sql .= "    rental_id = $rental_id ";
							$sql .= "AND ";
							$sql .= "    line = $line;";
							$result = Db_Query($db_con, $sql);
							if($result == false){
								Db_Query($db_con, "ROLLBACK");
								exit;
							}
						}
					}
					reset($goods_id);
					//���ե饤��Ǥ���в��������»�
					if($online_flg == "f"){
						$result = Rental_sql($db_con,$rental_id,4);
						if($result === false){
							Db_Query($db_con, "ROLLBACK");
							exit;
						}
					}

				}
				Db_Query($db_con, "COMMIT");

				header("Location: ./2-1-143.php?rental_id=$rental_id&disp_stat=$disp_stat&stat_flg=$stat_flg&client_id=$client_id&flg=$online_flg");
			}else{
				//��ǧ����ɽ���ե饰
				$comp_flg = true;
			}
		}
	}


	/****************************/
	//POST�����ѹ�
	/****************************/
	$form->setConstants($cons_data);
	/****************************/
	//���ʺ����ʲ��ѡ�
	/****************************/
	$row_num        = 1;    //���ֹ楫����
	$error_loop_num = NULL; //���顼ɽ���롼������

	for($i = 0; $i < $max_row; $i++){
		//ɽ����Ƚ��
		if(!in_array("$i", $del_history)){
			$del_data = $del_row.",".$i;

			//���ʥ�����      
			$form->addElement(
				"text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
				style=\" $g_form_style \" 
				onBlur=\"goods_display('hdn_goods_id','form_goods_cd','form_goods_cname','form_shop_price','form_user_price',$i,'form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','$h_coax');blurForm(this);\" onKeyDown=\"chgKeycode();\" onFocus=\"onForm(this)\" "
			);

			//����ʬ��ޥ���
			$form->addElement('select', "form_g_product_id[$i]","", $g_product_ary);

			//����̾
			//$form->addElement("text","form_goods_name[$i]","","size=\"55\" maxLength=\"40\" $g_form_option");

			//��̾�ѹ��ʤ��ξ���readonly
			if($name_change[$i] == "1"){
				$readonly = "";
			}else{
				$readonly = readonly;
			}
			//����̾��ά�Ρ�
			$form->addElement("text","form_goods_cname[$i]","","size=\"38\" maxLength=\"20\" $g_form_option $readonly");

			//����
			$form->addElement(
				"text","form_num[$i]","",
				"class=\"money\" size=\"11\" maxLength=\"5\" 
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax','true','$h_coax');\" $g_form_option "
			);

			//��󥿥�ñ��
			$form_shop_price[$i][] =& $form->createElement(
				"text","i","",
				"size=\"11\" maxLength=\"9\"
				class=\"money\"
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: right; $style $g_form_style\"
				$g_form_option"
			);
			$form_shop_price[$i][] =& $form->createElement(
				"text","d","","size=\"2\" maxLength=\"2\" 
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: left; $style $g_form_style\"
				$g_form_option"
			);
			$form->addGroup( $form_shop_price[$i], "form_shop_price[$i]", "",".");

			//��󥿥���
			$form->addElement("text","form_shop_amount[$i]","",'maxLength="18" class="amount"');

		
			//�桼����ñ��
			$form_user_price[$i][] =& $form->createElement(
				"text","i","",
				"size=\"11\" maxLength=\"9\"
				class=\"money\"
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: right; $style $g_form_style\"
				$g_form_option"
			);
			$form_user_price[$i][] =& $form->createElement(
				"text","d","","size=\"2\" maxLength=\"2\" 
					onKeyup=\"Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','true','$h_coax');\"
				style=\"text-align: left; $style $g_form_style\"
				$g_form_option"
			);
			$form->addGroup( $form_user_price[$i], "form_user_price[$i]", "",".");

			//�桼���󶡶��
			$form->addElement("text","form_user_amount[$i]","",'maxLength="18" class="amount"');


			//����ɽ������Ƚ��
			if($disp_stat == 2 && $online_flg == "t"){
				//����ѡ�����Ѥϰʲ��ι��ܥե꡼��
				$form->freeze("form_goods_cd[$i]");
				//$form->freeze("form_goods_name[$i]");
				$form->freeze("form_goods_cname[$i]");
				$form->freeze("form_g_product_id[$i]");
				$form->freeze("form_num[$i]");
				$form->freeze("form_shop_price[$i]");
				$form->freeze("form_shop_amount[$i]");
				$form->freeze("form_user_price[$i]");
				$form->freeze("form_user_amount[$i]");
			}

			//�����ꥢ��������

/*
			if($online_flg == "t" || $disp_stat == 6 || $disp_stat == 1 ){

				if($_POST["form_goods_cd"][$i] != NULL || $goods_cd_flg[$i] != NULL){
					$serial_disp[$i] = "���ꥢ������ʤ�";
				}

			//if($online_flg == "f" || $disp_stat == 6 || $disp_stat == 1 ){
			}elseif($online_flg == "f" || $disp_stat == 6 || $disp_stat == 1 ){
				//����������(����)
				//�쥳����ID̵��

				//���ꥢ���������
				if($serial_flg[$i] == 't' ){
					//����ʬ���ϥե��������
					for($d=0;$d<$serial_num[$i];$d++){
						//���ꥢ��      
						$form->addElement("text","form_serial[$i][$d]","","size=\"18\" maxLength=\"15\" style=\"$g_form_style \" $g_form_option ");
					}

				//���ꥢ��������ʤ� ���� ���ʤ����򤵤�Ƥ���ԤΤ�ɽ��
				}elseif($_POST["form_goods_cd"][$i] != NULL || $goods_cd_flg[$i] != NULL){
					$serial_disp[$i] = "���ꥢ������ʤ�";
				}

			}else{
				//FC
				//����ѡ������(����)

				//���ꥢ��ʿ��̤�ɬ��1�ʤΤǥե������1�����������ʤ���      
				$form->addElement("text","form_serial[$i][0]","","size=\"16\" maxLength=\"15\" style=\"$g_form_style \" $g_form_option ");
				$form->freeze("form_serial[$i][0]");

			}
*/


			//����ʬ���ϥե��������
			for($d=0;$d<$serial_num[$i];$d++){
				//���ꥢ��      
				$form->addElement("text","form_serial[$i][$d]","","size=\"18\" maxLength=\"15\" style=\"$g_form_style \" $g_form_option ");
				//����饤��
				if($online_flg == "t" || $rental_stat[$i] == '�����' || $rental_stat[$i] == '����ͽ��'){
					$form->freeze("form_serial[$i][$d]");
				}
			}



			//������ͳ
			$form->addElement("text","reason[$i]","",'maxLength="20" size="26" style="$g_form_style"'."$g_form_option");
			if($rental_stat[$i] == "�����"){
				$form->freeze("reason[$i]");
			}

			//������
			Addelement_Date($form,"form_calcel_day[$i]","����»���","-");
			$form->freeze("form_calcel_day[$i]");

			//�����
			$form->addElement("text","form_renew_num[$i]","�����",'class="money" size="11" maxLength="5"'.$g_form_option);

			//�»���
			Addelement_Date($form,"form_exec_day[$i]","�»���","-");


			//����ѡ��ޤ��ϡ�����Ѥξ��
			if($online_flg == "f"){
				
				//��������å��ܥå���
				$form->addElement( "checkbox","form_calcel1[".$i."]" ,"");
				$form->addElement( "checkbox","form_calcel2[".$i."]" ,"");

			}elseif($disp_stat == 2){
				
				//��������å��ܥå���
				$form->addElement( "checkbox","form_calcel1[".$i."]" ,"");
				$form->addElement( "checkbox","form_calcel2[".$i."]" ,"");

			//���������ޤ��ϡ�����ͽ��ξ��
			}elseif($disp_stat == "3" || $disp_stat == "4"){
				$form->freeze("form_renew_num[$i]"); //�����
				$form->freeze("form_exec_day[$i]");  //�»���
			}


			//�������
			$form->addElement(
				"link","form_search[$i]","","#","����",
				"TABINDEX=-1 onClick=\"Open_SubWin('../dialog/2-0-210.php', Array('hdn_goods_id[$i]','form_goods_cd[$i]','form_goods_cname[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_user_price[$i][i]','form_user_price[$i][d]'), 500, 450,'rental',$i);
				goods_display('hdn_goods_id','form_goods_cd','form_goods_cname','form_shop_price','form_user_price',$i,'form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax','$h_coax');
				return false;\""
				 //return Mult_double_ren('form_num[$i]','form_user_price[$i][i]','form_user_price[$i][d]','form_user_amount[$i]','form_shop_price[$i][i]','form_shop_price[$i][d]','form_shop_amount[$i]','$coax');
			);

			//������
			$form->addElement(
				"link","form_del_row[$i]","",
				"#","<font color='#FEFEFE'>���</font>",
				"TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\""
			);
			
			//����ID
			$form->addElement("hidden","hdn_goods_id[$i]");

			//��󥿥������ʸ�����
			$form->addElement("hidden","hdn_rental_stat[$i]");

			//��󥿥�����ʿ��͡�
			$form->addElement("hidden","hdn_rental_stat_num[$i]");

			//������
			$form->addElement("hidden","hdn_calcel_day[$i]");

			//���ꥢ�����
			$form->addElement("hidden","hdn_serial_flg[$i]");

			/****************************/
			//�ե�����ե꡼��
			/****************************/
			if($rental_stat[$i] == '����ͽ��' ){
				$form->freeze("form_goods_cd[$i]"); //���ʥ�����      
				//$form->freeze("form_goods_name[$i]");//����̾
				$form->freeze("form_goods_cname[$i]");//����̾
				$form->freeze("form_g_product_id[$i]");//����ʬ��
				$form->freeze("form_num[$i]");//����
				$form->freeze("form_user_price[$i]");//��󥿥�ñ��
				$form->freeze("form_user_amount[$i]");//��󥿥���
				$form->freeze("form_shop_price[$i]");//�桼����ñ��
				$form->freeze("form_shop_amount[$i]");//�桼���󶡶��
				$form->freeze("reason[$i]");
				$form->freeze("form_serial[".$i."][0]");
				$form->freeze("form_calcel_day[$i]");
				$form->freeze("form_renew_num[$i]");
				$form->freeze("form_exec_day[$i]");
				$form->freeze("form_calcel1[$i]");
				$form->freeze("form_calcel2[$i]");
			}


			//��ǧ����
			if($comp_flg == true){
					$form->freeze();

			//�ֿ���������סֲ������סֲ���ͽ���
			}elseif($disp_stat == 6 || $disp_stat == 3 || $disp_stat == 4){
				if($online_flg != f){
					$form->freeze();
				}
			}

			//****************************
			//ɽ����HTML����
			//****************************
			$html .= "<tr class=\"Result1\">";
			$html .=    "<A NAME=$row_num><td align=\"right\">$row_num</td></A>";
			//�����/����ѡ�������������ͽ��Ͼ���ɽ��
			if($disp_stat == 2 || $disp_stat == 3 || $disp_stat == 4){
				$html .=    "<td align=\"center\">".$rental_stat[$i]."</td>";
				//$html .=    "<td align=\"center\">".$hdn_rental_stat[$i]."</td>";
			}
			$html .=    "<td align=\"left\">";
			$html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
			//�������ɽ��Ƚ��(��ǧ���̤���ɽ��)
			if(($disp_stat == 1 || $disp_stat == 5) && $comp_flg != true){
				//�쥳����ID̵��
				//��ú�
				$html .=    "��";
				$html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
				$html .=    "��";
			}
			$html .=    "<br>";
			//$html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
			$html .=        $form->_elements[$form->_elementIndex["form_g_product_id[$i]"]]->toHtml();
			$html .=    "��";
			$html .=        $form->_elements[$form->_elementIndex["form_goods_cname[$i]"]]->toHtml();
			$html .=    "</td>";
			$html .=    "<td align=\"right\">";
			$html .=        $form->_elements[$form->_elementIndex["form_num[$i]"]]->toHtml();
			$html .=    "</td>";


			//�����ꥢ��
			$html .=    "<td align=\"left\">";
			//���ꥢ���������
			if($serial_flg[$i] == 't'){

				//����ʬ���ϥե��������
				for($d=0;$d<$serial_num[$i];$d++){
						if($d != 0){
							$html .= "<br>";
						}
						$html .=        $form->_elements[$form->_elementIndex["form_serial[$i][$d]"]]->toHtml();
				}

			//���ꥢ��������ʤ� ���� ���ʤ����򤵤�Ƥ���ԤΤ�ɽ��
			}elseif($_POST["form_goods_cd"][$i] != NULL || $goods_cd_flg[$i] != NULL){
				$html .=    "���ꥢ������ʤ�";

			}else{
				$html .=    "";
			}

			$html .=    "</td>";

			//����������
			//�쥳����ID̵��
			//if($disp_stat == 6 || $disp_stat == 1){
/*
			if($online_flg == "t" || $disp_stat == 6 || $disp_stat == 1 ){

					$html .=    "<td align=\"center\">";
					$html .=  $serial_disp[$i];

			//if($online_flg == "f" || $disp_stat == 6 || $disp_stat == 1 ){
			}elseif($online_flg == "f" $disp_stat == 6 || $disp_stat == 1 ){

			//if($disp_stat == 6 || $disp_stat == 1 || $online_flg == "f" ){

				//���ꥢ���������
				if($serial_flg[$i] == 't'){
					$html .=    "<td align=\"left\">";
					//����ʬ���ϥե��������
					for($d=0;$d<$serial_num[$i];$d++){
						if($d != 0){
							$html .= "<br>";
						}
						$html .=        $form->_elements[$form->_elementIndex["form_serial[$i][$d]"]]->toHtml();
					}

				//���ꥢ��������ʤ�
				}else{
					$html .=    "<td align=\"center\">";
					$html .=  $serial_disp[$i];
				}
				
			//����ѡ������
			}else{
				$html .=    "<td align=\"left\">";
				$html .=        $form->_elements[$form->_elementIndex["form_serial[$i][0]"]]->toHtml();
			}
*/
			$html .=    "<td align=\"right\">";
			$html .=        $form->_elements[$form->_elementIndex["form_shop_price[$i]"]]->toHtml();
			$html .=    "<br>";
			$html .=        $form->_elements[$form->_elementIndex["form_user_price[$i]"]]->toHtml();
			$html .=    "</td>";
			$html .=    "<td align=\"right\">";
			$html .=        $form->_elements[$form->_elementIndex["form_shop_amount[$i]"]]->toHtml();
			$html .=    "<br>";
			$html .=        $form->_elements[$form->_elementIndex["form_user_amount[$i]"]]->toHtml();
			$html .=    "</td>";


			//�������ޤ��ϡ���äξ��
			if($disp_stat == "1" || $disp_stat == "5"){

			//����ѡ������
			//}elseif($disp_stat == "2" || $online_flg == "f"){
			}elseif($disp_stat == "2"){

				$html .=    "<td align=\"center\">";
				$html .=        $form->_elements[$form->_elementIndex["form_calcel_day[$i]"]]->toHtml();
				$html .= "  </td>";

				//�����Ƚ��
				if($rental_stat[$i] == '�����'){
					//����Ѥϲ�������»�����ɽ��
					$html .=    "<td align=\"right\">��</td>";
					$html .=    "<td align=\"left\">";
					$html .=        $form->_elements[$form->_elementIndex["reason[$i]"]]->toHtml();
					$html .= "  </td>";
					$html .=    "<td align=\"left\">��</td>";
				}else{
					//�����
					$html .=    "<td align=\"right\">";
					$html .=        $form->_elements[$form->_elementIndex["form_renew_num[$i]"]]->toHtml();
					$html .= "  </td>";
					$html .=    "<td align=\"left\">";
					$html .=        $form->_elements[$form->_elementIndex["reason[$i]"]]->toHtml();
					$html .= "  </td>";
					$html .=    "<td align=\"left\">";
					$html .=        $form->_elements[$form->_elementIndex["form_calcel1[$i]"]]->toHtml();
					$html .=    "�������»�<br>";
					$html .=        $form->_elements[$form->_elementIndex["form_calcel2[$i]"]]->toHtml();
					$html .=        $form->_elements[$form->_elementIndex["form_exec_day[$i]"]]->toHtml();
					$html .= "  </td>";
				}

			}elseif($disp_stat == "3" || $disp_stat == "4"){
				//������
				//����ͽ��
				$html .=    "<td align=\"center\">";
				$html .=        $form->_elements[$form->_elementIndex["form_calcel_day[$i]"]]->toHtml();
				$html .=    "</td>";
				$html .=    "<td align=\"right\">";
				$html .=        $form->_elements[$form->_elementIndex["form_renew_num[$i]"]]->toHtml();
				$html .= "  </td>";
				$html .=    "<td align=\"left\">";
				$html .=        $form->_elements[$form->_elementIndex["reason[$i]"]]->toHtml();
				$html .= "  </td>";
				//ɽ������Ƚ��
				if($calcel_msg_flg[$i] == true){
					//¨����
					$html .=    "<td align=\"center\">�������»�</td>";
				}else{
					//����ͽ��
					$html .=    "<td align=\"center\">";
					$html .=        $form->_elements[$form->_elementIndex["form_exec_day[$i]"]]->toHtml();
					$html .=    "</td>";
				}
			}
			
			//���ե饤��ξ��Ϻ����󥯤�ɽ��
			if($online_flg == "f" || $disp_stat == "1" || $disp_stat == "5" ){

				//��ǧ���̤Ϻ�������ɽ��
				if($comp_flg != true){
					//��󥿥�ID̵������ú�
					$html .= "  <td class=\"Title_Add\" align=\"center\">";
					$html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
					$html .= "  </td>";
				}

			}
			$html .= "</tr>\n\n";

			//���ֹ��ܣ�
			$row_num = $row_num+1;

		}
		//���顼�롼�׿��������
		$error_loop_num[] = $i;
	}

	//�����ȥ�β��˥ܥ���ɽ��
	$page_title_btn .= "��".$form->_elements[$form->_elementIndex[input_btn]]->toHtml();
	$page_title_btn .= "��".$form->_elements[$form->_elementIndex[disp_btn]]->toHtml();

}else{
	//�������ˤϰ����ܥ���ɽ���Τ�
	$form->addElement("button","disp_btn","�졡��","onClick=\"location.href='".FC_DIR."system/2-1-142.php'\"");
}

/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title.$page_title_btn);

//  Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer", 
	"shop_name"     => "$shop_name",
	'html'          => "$html",
	'warning'       => "$warning",
	'java_sheet'    => "$java_sheet",
	'error_msg'     => "$error_msg",
	'error_msg2'    => "$error_msg2",
	'goods_error'   => "$goods_error",
	'disp_stat'     => "$disp_stat",
	'comp_flg'      => "$comp_flg",
	'injust_msg'    => "$injust_msg",
	'auth_r_msg'    => "$auth_r_msg",
	'stat_flg'      => "$stat_flg",
	'online_flg'      => "$online_flg",
));

// ɽ���ǡ���
$smarty->assign("disp_data", $disp_data);
//���顼�롼�׿�
$smarty->assign('error_loop_num',$error_loop_num);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
