<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2016/01/20                amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */
$page_title = "Ǽ�ʽ�����";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�ǥե����������
/****************************/
$sql  = "SELECT ";
$sql .= "d_memo1, ";		//Ǽ�ʽ񥳥���1
$sql .= "d_memo2, ";		//Ǽ�ʽ񥳥���2
$sql .= "d_memo3 ";			//Ǽ�ʽ񥳥���3
$sql .= "FROM ";
$sql .= "t_h_ledger_sheet;";

$result = Db_Query($db_con,$sql);
//DB���ͤ��������¸
$d_memo = Get_Data($result, 2);

//�Ԥ�¸��Ƚ��ե饰
$id_null_flg=false;
//�ǡ�����NULLȽ��ե饰
$value_flg=false;
//�ǡ���¸��Ƚ��
if(pg_num_rows($result)==null){
	$id_null_flg = true;
}
//������Ͽ������Ƚ��
for($c=1;$c<count($d_memo[0]);$c++){
	if($d_memo[0][$c] != null){
		$value_flg = true;
	}
}

$def_fdata = array(
    "d_memo1"     	=> $d_memo[0][0],
    "d_memo2"      	=> $d_memo[0][1],
    "d_memo3"     	=> $d_memo[0][2]
);
$form->setDefaults($def_fdata);

/****************************/
//�������
/****************************/

//�����ȭ�
$form->addElement("text","d_memo1".$x,"�ƥ����ȥե�����","size=\"50\" maxLength=\"46\" style=\"font-size:12px;\"".$g_form_option."\"");
//�����ȭ�
$form->addElement("text","d_memo2".$x,"�ƥ����ȥե�����","size=\"50\" maxLength=\"46\" style=\"font-size:12px;\"".$g_form_option."\"");
//�����ȭ�
//$form->addElement("text","d_memo3".$x,"�ƥ����ȥե�����","size=\"39\" maxLength=\"46\" style=\"font-size:12px;\"".$g_form_option."\"");
$form->addElement("textarea","d_memo3",""," rows=\"3\" cols=\"45\" $g_form_option_area");
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("d_memo3","����60ʸ������Ǥ���","mb_maxlength","60");

//��Ͽ�ܥ���
$form->addElement("submit","new_button","�С�Ͽ","onClick=\"javascript: return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");

//Ǽ�ʽ���ϥܥ���
$form->addElement("button","deli_button","�ץ�ӥ塼","onClick=\"javascript:window.open('1-1-317.php','_blank','')\"");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["new_button"] == "�С�Ͽ"){
	$d_memo1 = $_POST["d_memo1"];				//Ǽ�ʽ񥳥���1
	$d_memo2 = $_POST["d_memo2"];				//Ǽ�ʽ񥳥���2
	$d_memo3 = $_POST["d_memo3"];				//Ǽ�ʽ񥳥���3
                                                
	Db_Query($db_con, "BEGIN;");

	//������Ͽ������Ƚ��
	if($id_null_flg==true && $from->validate()){
		//��Ͽ��λ��å�����
		$comp_msg = "��Ͽ���ޤ�����";

		$sql  = "INSERT INTO ";
		$sql .= "t_h_ledger_sheet ";
		$sql .= "(d_memo1,";
		$sql .= "d_memo2,";
		$sql .= "d_memo3) ";
		$sql .= "VALUES(";
		$sql .= "'$d_memo1',";
		$sql .= "'$d_memo2',";
		$sql .= "'$d_memo3');";
	}elseif($form->validate()){
		//�Ԥ�¸�ߤ��뤬��Ǽ�ʽ񥳥��Ȥ�NULL�ξ��
		if($value_flg==false){
			//��Ͽ��λ��å�����
			$comp_msg = "��Ͽ���ޤ�����";
		}else{
			//�ѹ���λ��å�����
			$comp_msg = "�ѹ����ޤ�����";
		}

		$sql  = "UPDATE ";
		$sql .= "t_h_ledger_sheet ";
		$sql .= "SET ";
		$sql .= "d_memo1 = '$d_memo1', ";
		$sql .= "d_memo2 = '$d_memo2', ";
		$sql .= "d_memo3 = '$d_memo3';";
	}

	$result = Db_Query($db_con,$sql);
	if($result == false){
		Db_Query($db_con,"ROLLBACK;");
		exit;
	}
	Db_Query($db_con, "COMMIT;");
}

/****************************/
//HTML�إå�
/****************************/
//$html_header = Html_Header($page_title);
$html_header = Html_Header($page_title, "amenity.js", "global.css", "slip.css");

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_h('system','2');
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
    'auth_r_msg'    => "$auth_r_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
