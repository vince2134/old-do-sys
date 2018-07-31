<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2016/01/20                amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */
$page_title = "��ʸ��ե����ޥå�����";

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
$sql .= "o_memo1, ";		//FAX
$sql .= "o_memo2, ";		//TEL
$sql .= "o_memo3, ";		//��ʸ�񥳥���3
$sql .= "o_memo4, ";		//��ʸ�񥳥���4
$sql .= "o_memo5, ";		//��ʸ�񥳥���5
$sql .= "o_memo6, ";		//��ʸ�񥳥���6
$sql .= "o_memo7, ";		//��ʸ�񥳥���7
$sql .= "o_memo8 ";			//��ʸ�񥳥���8
$sql .= "FROM ";
$sql .= "t_h_ledger_sheet;";

$result = Db_Query($db_con,$sql);
//DB���ͤ��������¸
$o_memo = Get_Data($result, 2);

//�Ԥ�¸��Ƚ��ե饰
$id_null_flg=false;
//�ǡ�����NULLȽ��ե饰
$value_flg=false;
//�ǡ���¸��Ƚ��
if(pg_num_rows($result)==null){
	$id_null_flg = true;
}
//������Ͽ������Ƚ��
for($c=1;$c<count($o_memo[0]);$c++){
	if($o_memo[0][$c] != null){
		$value_flg = true;
	}
}

$def_fdata = array(
    "o_memo1"     	=> $o_memo[0][0],
    "o_memo2"      	=> $o_memo[0][1],
    "o_memo3"     	=> $o_memo[0][2],
    "o_memo4"     	=> $o_memo[0][3],
    "o_memo5"     	=> $o_memo[0][4],
	"o_memo6"     	=> $o_memo[0][5],
    "o_memo7"     	=> $o_memo[0][6],
    "o_memo8"     	=> $o_memo[0][7]
);
$form->setDefaults($def_fdata);

/****************************/
//�������
/****************************/

//FAX
$form->addElement("text","o_memo1","�ƥ����ȥե�����","size=\"13\" maxLength=\"13\" style=\"font-size:14px;\"".$g_form_option."\"");
//TEL
$form->addElement("text","o_memo2","�ƥ����ȥե�����","size=\"13\" maxLength=\"13\" style=\"font-size:12px;\"".$g_form_option."\"");

//������3��8
for($x=3;$x<=8;$x++){
	$form->addElement("text","o_memo".$x,"�ƥ����ȥե�����","size=\"140\" maxLength=\"124\" style=\"font-size:10px;\"".$g_form_option."\"");
}

//��Ͽ�ܥ���
$form->addElement("submit","new_button","�С�Ͽ","onClick=\"javascript: return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");

//��ʸ��ȯ�ԥܥ���
//$form->addElement("button","order_button","��ʸ��ȯ��","onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-308.php','_blank','')\"");
$form->addElement("button","order_button","�ץ�ӥ塼","onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-308.php','_blank','')\"");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["new_button"] == "�С�Ͽ"){
	$o_memo1 = $_POST["o_memo1"];				//FAX
	$o_memo2 = $_POST["o_memo2"];				//TEL
	$o_memo3 = $_POST["o_memo3"];				//��ʸ�񥳥���3
	$o_memo4 = $_POST["o_memo4"];				//��ʸ�񥳥���4
	$o_memo5 = $_POST["o_memo5"];				//��ʸ�񥳥���5
	$o_memo6 = $_POST["o_memo6"];				//��ʸ�񥳥���6
	$o_memo7 = $_POST["o_memo7"];				//��ʸ�񥳥���7
	$o_memo8 = $_POST["o_memo8"];				//��ʸ�񥳥���8

	/****************************/
	//���顼�����å�(PHP)
	/****************************/
	//��FAX
	//��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
	if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$o_memo1)){
		$error_fax_msg = "FAX�Ͽ��ͤȡ�-�פΤ߻��Ѳ�ǽ�Ǥ���";
	}
	//��TEL
	//��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
	if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$o_memo2)){
		$error_tel_msg = "TEL�Ͽ��ͤȡ�-�פΤ߻��Ѳ�ǽ�Ǥ���";
	}
	//���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
	if($error_fax_msg==null && $error_tel_msg==null){
		Db_Query($db_con, "BEGIN;");

		//������Ͽ������Ƚ��
		if($id_null_flg==true){
			//��Ͽ��λ��å�����
			$comp_msg = "��Ͽ���ޤ�����";

			$sql  = "INSERT INTO ";
			$sql .= "t_h_ledger_sheet ";
			$sql .= "(o_memo1,";
			$sql .= "o_memo2,";
			$sql .= "o_memo3,";
			$sql .= "o_memo4,";
			$sql .= "o_memo5,";
			$sql .= "o_memo6,";
			$sql .= "o_memo7,";
			$sql .= "o_memo8) ";
			$sql .= "VALUES(";
			$sql .= "'$o_memo1',";
			$sql .= "'$o_memo2',";
			$sql .= "'$o_memo3',";
			$sql .= "'$o_memo4',";
			$sql .= "'$o_memo5',";
			$sql .= "'$o_memo6',";
			$sql .= "'$o_memo7',";
			$sql .= "'$o_memo8');";
		}else{
			//�Ԥ�¸�ߤ��뤬����ʸ�񥳥��Ȥ�NULL�ξ��
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
			$sql .= "o_memo1 = '$o_memo1', ";
			$sql .= "o_memo2 = '$o_memo2', ";
			$sql .= "o_memo3 = '$o_memo3', ";
			$sql .= "o_memo4 = '$o_memo4', ";
			$sql .= "o_memo5 = '$o_memo5', ";
			$sql .= "o_memo6 = '$o_memo6', ";
			$sql .= "o_memo7 = '$o_memo7', ";
			$sql .= "o_memo8 = '$o_memo8';";
		}

		$result = Db_Query($db_con,$sql);
		if($result == false){
			Db_Query($db_con,"ROLLBACK;");
			exit;
		}
		Db_Query($db_con, "COMMIT;");
	}
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
	'error_tel_msg' => "$error_tel_msg",
	'error_fax_msg' => "$error_fax_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
