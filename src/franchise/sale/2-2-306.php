<?php

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/12/14��      ��������suzuki��    �ڡ�����������
 *
 */

$page_title = "����Ȳ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//�����Ϣ�ǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR."seikyu.inc");

//���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc")));

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST");

//DB��³
$db_con = Db_Connect();

//�������ϻ���
$s_time = microtime();

/****************************/
//���¥����å�
/****************************/
$auth       = Auth_Check($db_con);
$auth[0] = "w";

// ���ϡ��ѹ�����̵����å�����
if ($auth[0] == "r") {
	$disabled = "disabled";
} 


/****************************/
//�ѿ�̾���֤������ʰʸ�$_POST�ϻ��Ѥ��ʤ���
/****************************/
//�桼������
if ($_POST[renew_flg] == "1"){ 
	$hyoujikensuu     = $_POST[hyoujikensuu];
	$bill_no          = $_POST[bill_no];
	$close_day_s      = $_POST[close_day_s];
	$close_day_e      = $_POST[close_day_e];
	$claim_cd         = $_POST[claiem_cd];
	$claim_cname      = $_POST[claim_cname];
	$client_cd        = $_POST[client_cd];
	$client_cname     = $_POST[client_cname];
	$bill_amount_last = $_POST[bill_amount_last];
	$pay_amount       = $_POST[pay_amount];
	$rest_amount      = $_POST[rest_amount];
	$sale_amount      = $_POST[sale_amount];
	$tax_amount       = $_POST[tax_amount];
	$intax_amount     = $_POST[intax_amount];
	$bill_amount_this = $_POST[bill_amount_this];
	$fix              = $_POST[fix];
	$claim_update     = $_POST[claim_update];
	$where            = $_POST;
 
	//����¾
	$f_page1          = $_POST[f_page1];
	$hyouji_button    = $_POST[hyouji_button];
	$cancel_button    = $_POST[cancel_button];
	$bill_id          = $_POST[bill_id];
	$link_action      = $_POST[link_action];
	$renew_flg        = $_POST[renew_flg];
//���ɽ��
}else{
	$f_page1 = 1;
	$hyoujikensuu = 50;
}


/****************************/
// �ե������������Ū��
/****************************/
// ɽ�����
$hyoujikensuu_arr = array(
"10" => "10",
"50" => "50",
"100" => "100",
"all" => "����",
);
$form->addElement("select", "hyoujikensuu", "ɽ�����", $hyoujikensuu_arr);

// �����ֹ�
$form->addElement("text", "bill_no", "�����ֹ�", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ���������ʳ��ϡ�
Addelement_Date($form,"close_day_s","��������","-");

// ���������ʽ�λ��
Addelement_Date($form,"close_day_e","��������","-");

// �����襳����
$client_cd_arr[] =& $form->createElement("text", "1", "", 
"size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'client_cd[1]', 'client_cd[2]', 6)\" $g_form_option");
$client_cd_arr[] =& $form->createElement("text", "2", "", 
"size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($client_cd_arr, "client_cd", "�����襳����","-");

// ������̾
$form->addElement("text", "client_cname", "������̾", "size=\"34\" maxLength=\"15\" $g_form_option");

// �����襳����
$claim_cd_arr[] =& $form->createElement("text", "1", "", 
"size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'claim_cd[1]', 'claim_cd[2]', 6)\" $g_form_option");
$claim_cd_arr[] =& $form->createElement("text", "2", "", 
"size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($claim_cd_arr, "claim_cd", "�����襳����","-");

// ������̾
$form->addElement("text", "claim_cname", "������̾", "size=\"34\" maxLength=\"15\" $g_form_option");

// ô���ԥ�����
$form->addElement("text", "staff_cd", "ô���ԥ�����", "size=\"34\" maxLength=\"15\" style=\"$g_form_style\" $g_form_option");

// ô����̾
//$select_value = Select_Get($db_con, "staff");
//$form->addElement("select", "staff_name", "ô����̾", $select_value, $g_form_option_select);
$form->addElement("text", "staff_name", "ô����̾", "size=\"34\" maxLength=\"15\" $g_form_option");


// ����������
$bill_amount_last_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$bill_amount_last_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($bill_amount_last_arr, "bill_amount_last", "����������", "������");

// ���������
$pay_amount_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$pay_amount_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($pay_amount_arr, "pay_amount", "���������", "������");

// ���ۻĹ��
$rest_amount_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$rest_amount_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($rest_amount_arr, "rest_amount", "���ۻĹ��", "������");

// ����������
$bill_amount_this_arr[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$bill_amount_this_arr[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" style=\"$g_form_style\" $g_form_option class=\"money\"");
$form->addGroup($bill_amount_this_arr, "bill_amount_this", "����������", "������");

// ���ṹ��
$claim_update_arr[] =& $form->createElement("radio", null, null, "����ʤ�", "1");
$claim_update_arr[] =& $form->createElement("radio", null, null, "�»ܺ�", "2");
$claim_update_arr[] =& $form->createElement("radio", null, null, "̤�»�", "3");
$form->addGroup($claim_update_arr, "claim_update", "���ṹ��");

// ɽ���ܥ���
$form->addElement("button", "hyouji_button", "ɽ����", "onClick=\"javascript:submit(); return false;\"");

// ���ꥢ�ܥ���
$form->addElement("button", "kuria_button", "���ꥢ", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

//hidden
$form->addElement("hidden","link_action");   //��󥯥���å�����ư��
$form->addElement("hidden","bill_id");       //�����ID
$form->addElement("hidden","renew_flg","1"); //���̹����ե饰


/****************************/
//�ե�����Υǥե�����ͤ򥻥å�
/****************************/
$defaults_data = array(
	"hyoujikensuu"  => "$hyoujikensuu",
	"claim_update"  => "1",
);
$form->setDefaults($defaults_data);


/****************************/
//���顼�����å�
/****************************/

//ɽ�����
if (!(0 <= $hyoujikensuu || $hyoujikensuu <= 3)){
	echo "�������ͤ����Ϥ���ޤ�����";
	exit;
}

//���ṹ��
if (!(1 <= $claim_update || $claim_update <= 3)){
	echo "�������ͤ����Ϥ���ޤ�����";
	exit;
}

$form->registerRule("check_date","function","Check_Date");
$form->addRule("bill_no","�������ֹ�פ�Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');
$form->addRule("close_day_s", "�����������ʳ��ϡˡפ����������դ����Ϥ��Ʋ�������",  "check_date", $close_day_s);
$form->addRule("close_day_e", "�����������ʽ�λ�ˡפ����������դ����Ϥ��Ʋ�������",  "check_date", $close_day_e);
$form->addRule("collect_day_s", "�ֲ��ͽ�����ʳ��ϡˡפ����������դ����Ϥ��Ʋ�������",  "check_date", $collect_day_s);
$form->addRule("collect_day_e", "�ֲ��ͽ�����ʽ�λ�ˡפ����������դ����Ϥ��Ʋ�������",  "check_date", $collect_day_e);
$form->addGroupRule('claim_cd', array(
        '1' => array(array('�������襳���ɡפ�Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^[0-9]+$/')),
        '2' => array(array('�������襳���ɡפ�Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^[0-9]+$/'))
));
$form->addGroupRule('client_cd', array(
        '1' => array(array('�������襳���ɡפ�Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^[0-9]+$/')),
        '2' => array(array('�������襳���ɡפ�Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^[0-9]+$/'))
));
$form->addRule("staff_cd","��ô���ԥ����ɡפ�Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');

$form->addGroupRule('pay_amount', array(
        'min' => array(array('�ֺ�������ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('�ֺ�������ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/'))
));

$form->addGroupRule('bill_amount_last', array(
        'min' => array(array('�����������ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('�����������ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/'))
));

$form->addGroupRule('rest_amount', array(
        'min' => array(array('�ַ��ۻĹ�ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('�ַ��ۻĹ�ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/'))
));

$form->addGroupRule('bill_amount_this', array(
        'min' => array(array('�ֺ��������ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/')),
        'max' => array(array('�ֺ��������ۡפ� - �ޤ��� Ⱦ�ѿ��ͤΤߤǤ���', "regex", '/^-?[0-9]+$/'))
));


/****************************/
//����
/****************************/
//����ɽ������
if ($form->validate() || $renew_flg == ""){
	//�����������
	$total_count = Get_Claim_Data($db_con, $where, "", "", "count");

	//1�ڡ�����ɽ�����������ξ��
	if ($hyoujikensuu == "all") {
		$range = $total_count;
	} else {
		$range = $hyoujikensuu;
	}
	
	//���ߤΥڡ�����������å�����
	$page_info = Check_Page($total_count, $range, $f_page1);
	$page      = $page_info[0]; //���ߤΥڡ�����
	$page_snum = $page_info[1]; //ɽ�����Ϸ��
	$page_enum = $page_info[2]; //ɽ����λ���

	//�ڡ����ץ������ɽ��Ƚ��
	if($page == 1){
		//�ڡ����������ʤ�ڡ����ץ���������ɽ��
		$c_page = NULL;
	}else{
		//�ڡ�����ʬ�ץ�������ɽ��
		$c_page = $page;
	}
	
	//�ڡ�������
	$html_page  = Html_Page($total_count,$c_page,1,$range);
	$html_page2 = Html_Page($total_count,$c_page,2,$range);
	
	//�����ǡ�������
	$claim_data  = Get_Claim_Data($db_con, $where, $page_snum, $page_enum);
}

/****************************/
// �ե����������ưŪ��
/****************************/
//for($j = $page_snum; $j <= $page_enum; $j++){
//}

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_f('sale','3');

/****************************/
//���̥إå�������
/****************************/
//$page_header = Create_Header($page_title);
$page_header = Bill_Header($page_title);


/****************************/
//�ƥ�ץ졼�Ȥؤν���
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//���顼��assign
$errors = $form->_errors;
$smarty->assign('errors', $errors);

//�������
$smarty->assign('claim_data', $claim_data);

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
/*
$e_time = microtime();
echo "$s_time"."<br>";
echo "$e_time"."<br>";

echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

?>
