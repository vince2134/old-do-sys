<?php

$page_title = "�ѥ�����ѹ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³
$db_con = Db_Connect();

//���å���󳫻�
session_start();

/****************************/
//�����ѿ�����
/****************************/
$staff_id      = $_SESSION["staff_id"];


/**************HTML���᡼������������********************/

//���ߤΥѥ����
$form->addElement("password","password_now","�ƥ����ȥե�����",'size="24" maxLength="20" onFocus="onForm(this)" onBlur="blurForm(this)"');

//���ѥ����
$form->addElement("password","password","�ƥ����ȥե�����",'size="24" maxLength="20" onFocus="onForm(this)" onBlur="blurForm(this)"');

//���ѥ���ɳ�ǧ
$form->addElement("password","password_conf","�ƥ����ȥե�����",'size="24" maxLength="20" onFocus="onForm(this)" onBlur="blurForm(this)"');

//�ѹ��ܥ���
$form->addElement("submit","touroku","�ѡ���","onClick=\"javascript: return Dialogue4('�ѹ����ޤ���');\" $disabled");

/******************���顼�����å����**********************/

//��ʸ�������å�
$form->addRule( "password_now", "���ߤΥѥ���ɤ����Ϥ��Ʋ�������", "required");
$form->addRule( "password", "�������ѥ���� ��6ʸ���ʾ�20ʸ������Ǥ���", "required");
$form->addRule( "password_conf", "�ѥ���ɳ�ǧ�����Ϥ��Ʋ�������", "required");

//��ʸ���������å�
$form->addRule('password','�ѥ���� ��6ʸ���ʾ�20ʸ������Ǥ���','rangelength',array(6,20));

//�����ϥ����å�
$form->addRule( array("password","password_conf"),"�ѥ���ɤȥѥ���ɳ�ǧ�����פ��ޤ���","compare");

/**********************�ѹ��ܥ��󲡲�����*****************/

if($_POST["touroku"] == "�ѡ���"){

	/*********************
	//���顼Ƚ��ʣУȣС�
	**********************/
	$error_flg = false;   //���顼Ƚ��ե饰
	//���ߤΥѥ���ɤ����Ƚ��
	$sql = "SELECT password FROM t_login WHERE staff_id = $staff_id;";
	$result = Db_Query($db_con, $sql); 
	$pass_now = pg_fetch_result($result, 0,0);                  //���ߤΥѥ����
	$pass_now_input = crypt($_POST["password_now"],$pass_now);  //���ϤΥѥ����
	if($pass_now_input != $pass_now){
		$error_msg = "���ߤΥѥ���ɤ����פ��ޤ���";
		$error_flg = true;
	}

	//�����å�Ƚ��
	if($form->validate() && $error_flg == false){
		//POST�������
		$password = $_POST["password"];
		$password_conf = $_POST["password_conf"];
	
		//�ѥ���ɤ�Ź沽����
		$password = crypt($password);

		//DB��³
		Db_Query($db_con, "BEGIN;");
		//�ѥ���ɹ���SQL
		$sql = "UPDATE t_login SET password = '".$password."' WHERE staff_id = '".$staff_id."';";
		$result = Db_Query($db_con,$sql);
		if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
		Db_Query($db_con, "COMMIT;");
		//POST���������
		$delete_data = array(
		"password_now"     => "",
	    "password"         => "",
	    "password_conf"    => "",
		);
		$form->setConstants($delete_data);

		//�ѹ���λ��å�����
		$comp_msg = "�ѹ����ޤ�����";

	}
}

/*********************************************************/


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
$page_menu = Create_Menu_h('system','3');
/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);




// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'comp_msg'   	=> "$comp_msg",
	'error_msg'     => "$error_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
