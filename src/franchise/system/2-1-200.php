<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/03/29      xx-xxx      kajioka-h   �ܻ�Ź�������������IME̵���Υ��ץ������ɲ�
 *                  xx-xxx      kajioka-h   No.�򱦴󤻤�
 */

/************************************************/
//�������ȥե�����
/************************************************/
require_once("ENV_local.php"); //�Ķ��ե�����
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc"))); //���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����

/*------------------------------------------------
    �ѿ����
------------------------------------------------*/
$page_title        = "�ܻ�Ź�ޥ���"; //�ڡ���̾

// HTML_QuickForm���֥������Ⱥ���
$form =& new HTML_QuickForm("dateForm", "POST");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


// SESSION�ǡ�������
session_start();

/************************************************/
//QuickForm - �ե����४�֥����������
/************************************************/
//�ܻ�ŹID	branch_id
$form->addElement("hidden", "branch_id");

//�ܻ�Ź������	branch_cd
$form->addElement("text", "branch_cd", "�ܻ�Ź������", "size=\"2\" maxlength=\"3\" $g_form_option style=\"$g_form_style\"");

//�ܻ�Ź̾	branch_name
$form->addElement("text", "branch_name", "�ܻ�Ź̾", "size=\"22\" maxlength=\"10\" $g_form_option");

//�����Ҹ�ID	bases_ware_id
//$select_value = Select_Get($db_con,'ware');
$select_value = Select_Get($db_con,'ware',"WHERE shop_id = $_SESSION[client_id] AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
$form->addElement('select', 'bases_ware_id', '�����Ҹ�', $select_value);

//����	note
$form->addElement("text", "note", "����", "size=\"34\" maxlength=\"30\" $g_form_option");

//��Ͽ�ܥ���
$form->addElement("submit", "regist_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue4('��Ͽ���ޤ�');\" $disabled");

//CSV���ϥܥ���
//$form->addElement("submit", "csv_button", "CSV����", "$disabled");
$form->addElement("submit", "csv_button", "CSV����", "onClick=\"javascript:document.forms[0].action='#';\"");

// ���ꥢ�ܥ���
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]')\"");

//hidden
$form->addElement("hidden", "update_button"); //�ѹ��ܥ���

$form->applyFilter('__ALL__', 'trim');

/************************************************/
//��������Ƚ��
/************************************************/
if ($_POST[update_button] == "�ѹ���"){
	$action = "�ѹ���";

} elseif ($_POST[csv_button] == "CSV����"){
	$action = "CSV";

} elseif ($_POST[update_button] == "�ѹ�" && $auth[0] == "w"){
	$action = "�ѹ�";

} elseif ($_POST[regist_button] == "�С�Ͽ" && $auth[0] == "w") {
	$action = "��Ͽ";

} else {
	$action = "���ɽ��";
}
//echo $action;

/************************************************/
//���顼����
/************************************************/
//����Ͽ�פ����ѹ��פξ��ϥ��顼�����å��»�
if ($action == "��Ͽ" || $action == "�ѹ�") {

	//�롼���ɲ�
	$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
	$form->registerRule("no_sp_name", "function", "No_Sp_Name");
	
	//�롼��λ���
	$form->addRule('branch_cd',"���ܻ�Ź�����ɡפ����Ϥ��Ʋ�������",'required');
	$form->addRule("branch_cd","���ܻ�Ź�����ɡפ�Ⱦ�ѿ��ͤΤߤǤ���","regex", '/^[0-9]+$/');
	$form->addRule("branch_name","���ܻ�Ź̾�פ����Ϥ��Ʋ�������",'required');
	$form->addRule("branch_name","���ܻ�Ź̾�פ˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");
	$form->addRule("branch_name","���ܻ�Ź̾�פ�10ʸ������Ǥ���","mb_maxlength","10");
	$form->addRule("bases_ware_id","�ֵ����Ҹˡפ����򤷤Ʋ�������",'required');
	$form->addRule("note","�����͡פ�30ʸ������Ǥ���","mb_maxlength","30");

	//���顼�����ä����Ͻ�����֥��顼�פ��ڤ��ؤ���
	if ($form->validate() == false ){
		$action = "���顼";
	}

}

/************************************************/
//�����¹�
/************************************************/
//����Ͽ����
if ($action == "��Ͽ") {

	//��Ͽ����
	$result = Regist_Branch($db_con);

	//��Ͽ����
	if($result === false){
		$form->setElementError("branch_cd", "Ʊ���˽������Ԥ�줿������Ͽ�����˼��Ԥ��ޤ������⤦������Ͽ���Ʋ�������");

	//��Ͽ����
	}else{
		$mesg = "��Ͽ���ޤ�����";
		//�ե�����ǡ�������ˤ���
		$constants_data = array(
			branch_cd     => "",
			branch_name   => "",
			bases_ware_id => "",
			note          => "",
			branch_id     => "",
			update_button => "",
		);
	}

//���ѹ�����
} elseif ($action == "�ѹ�"){

	//�ѹ�����
	$result = Update_Branch($db_con);

	//�ѹ�����
	if($result === false){
		$form->setElementError("branch_cd", "���˻��Ѥ���Ƥ����ܻ�Ź�����ɤǤ���");

	//��Ͽ����
	}else{
		$mesg = "�ѹ����ޤ�����";
		//�ե�����ǡ�������ˤ���
		$constants_data = array(
			branch_cd     => "",
			branch_name   => "",
			bases_ware_id => "",
			note          => "",
			branch_id     => "",
			update_button => "",
		);
	}

//���ѹ�������
} elseif ($action == "�ѹ���"){
	$constants_data                = Get_Branch($db_con);
	$constants_data[update_button] = "�ѹ�";

//��CSV���Ͻ���
} elseif ($action == "CSV"){
	//CSV����
	Csv_Branch($db_con);
	
//��CSV���Ͻ���
} elseif ($action == "���ɽ��"){
	//�ä˽����ʤ�

//�����顼����
} elseif ($action == "���顼"){
	//�ä˽����ʤ�
}

$form->setConstants($constants_data);
/****************************/
//ɽ���ǡ�������
/****************************/
//DB����ǡ�������
$branch_data = Get_Branch_Data($db_con);

//�����ǡ�����HTML�Ѥ��Ѵ�
$branch_data = Html_Branch_Data($branch_data);

//�����
$total_count = count($branch_data);


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
$page_menu = Create_Menu_f("system", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//���顼��assign
$errors = $form->_errors;
$smarty->assign('errors', $errors);

//����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header" => "$html_header",
	"page_menu"   => "$page_menu",
	"page_header" => "$page_header",
	"html_footer" => "$html_footer",
	"total_count" => "$total_count",
	"mesg" => "$mesg",
	'auth_r_msg'    => "$auth_r_msg",
));
$smarty->assign("branch_data", $branch_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));
//print_array($_POST);

?>
