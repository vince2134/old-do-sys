<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2016/01/20                amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */
$page_title = "ȯ��񥳥�������";

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
//�����ѿ�����
/****************************/
$client_id  = $_SESSION[client_id];

/****************************/
//�ǥե����������
/****************************/
$sql  = "SELECT ";
$sql .= "o_pattern_id, ";
$sql .= "o_memo1_1, ";		//ȯ��񥳥��ȡ�͹�أ���
$sql .= "o_memo1_2, ";		//ȯ��񥳥��ȡ�͹�أ���
$sql .= "o_memo2, ";		//ȯ��񥳥���2
$sql .= "o_memo3, ";		//ȯ��񥳥���3
$sql .= "o_memo4, ";		//ȯ��񥳥���4
$sql .= "o_memo5, ";		//ȯ��񥳥���5
$sql .= "o_memo6, ";		//ȯ��񥳥���6
$sql .= "o_memo7, ";		//ȯ��񥳥���7
$sql .= "o_memo8, ";		//ȯ��񥳥���8
$sql .= "o_memo9, ";		//ȯ��񥳥���9
$sql .= "o_memo10, ";		//ȯ��񥳥���10
$sql .= "o_memo11, ";		//ȯ��񥳥���11
$sql .= "o_memo12, ";		//ȯ��񥳥���12
$sql .= "shop_id ";
$sql .= "FROM ";
$sql .= "t_order_sheet ";
$sql .= "WHERE ";
$sql .= "shop_id = $client_id;";

$result = Db_Query($db_con,$sql);
//DB���ͤ��������¸
$o_memo = Get_Data($result, 2);

//�Ԥ�¸��Ƚ��ե饰
$id_null_flg=false;
//�ǡ�����NULLȽ��ե饰
$value_flg=false;
//�ǡ���¸��Ƚ��
if($o_memo[0][0]==null){
	$id_null_flg = true;
}
//������Ͽ������Ƚ��
for($c=1;$c<count($o_memo[0]);$c++){
	if($o_memo[0][$c] != null){
		$value_flg = true;
	}
}

$def_fdata = array(
    "form_post[o_memo1_1]"     	=> $o_memo[0][1],
    "form_post[o_memo1_2]"     	=> $o_memo[0][2],
    "o_memo2"      				=> $o_memo[0][3],
    "o_memo3"     				=> $o_memo[0][4],
    "o_memo4"     				=> $o_memo[0][5],
    "o_memo5"     				=> $o_memo[0][6],
	"o_memo6"     				=> $o_memo[0][7],
    "o_memo7"     				=> $o_memo[0][8],
    "o_memo8"     				=> $o_memo[0][9],
    "o_memo9"     				=> $o_memo[0][10],
	"o_memo10"     				=> $o_memo[0][11],
    "o_memo11"     				=> $o_memo[0][12],
	"o_memo12"     				=> $o_memo[0][13]
);
$form->setDefaults($def_fdata);

/****************************/
//�������
/****************************/
//͹���ֹ�
$text[] =& $form->createElement("text","o_memo1_1","�ƥ����ȥե�����","size=\"3\" maxLength=\"3\" onkeyup=\"changeText(this.form,'form_post[o_memo1_1]','form_post[o_memo1_2]',3)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","<font color=black>-</font>");
$text[] =& $form->createElement("text","o_memo1_2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\"".$g_form_option."\"");
$form->addGroup( $text, "form_post", "form_post");

//������2��6
for($x=2;$x<=6;$x++){
	$form->addElement("text","o_memo".$x,"�ƥ����ȥե�����","size=\"32\" maxLength=\"32\" style=\"font-size:12px; font-family: '�ͣ� �����å�',monospace;\"".$g_form_option."\"");
}

//������7��12
for($x=7;$x<=12;$x++){
	$form->addElement("text","o_memo".$x,"�ƥ����ȥե�����","size=\"100\" maxLength=\"92\" style=\"font-size:15px;\"".$g_form_option."\"");
}

//��Ͽ�ܥ���
$form->addElement("submit","new_button","�С�Ͽ","onClick=\"javascript: return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");

//ȯ���ȯ�ԥܥ���
//$form->addElement("button","order_button","ȯ���ȯ��","onClick=\"javascript:window.open('".HEAD_DIR."buy/1-3-105.php','_blank','')\"");
$form->addElement("button","order_button","�ץ�ӥ塼","onClick=\"javascript:window.open('".HEAD_DIR."buy/1-3-105.php','_blank','')\"");

/****************************/
//���顼�����å�(AddRule)
/****************************/
//��͹���ֹ�
//��ʸ���������å�
//��ʸ��������å�
$form->addGroupRule('form_post', array(
	'o_memo1_1' => array(
		array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','rangelength',array(3,3)),
		array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','numeric')
	),
	'o_memo1_2' => array(
		array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','rangelength',array(4,4)),
		array('͹���ֹ��Ⱦ�ѿ�����7��Ǥ���','numeric'),
	)
));

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["new_button"] == "�С�Ͽ"){
	$o_memo1_1 = $_POST["form_post"]["o_memo1_1"];		//͹��1
	$o_memo1_2 = $_POST["form_post"]["o_memo1_2"];		//͹��2
	$o_memo2 = $_POST["o_memo2"];						//������2
	$o_memo3 = $_POST["o_memo3"];						//������3
	$o_memo4 = $_POST["o_memo4"];						//������4
	$o_memo5 = $_POST["o_memo5"];						//������5
	$o_memo6 = $_POST["o_memo6"];						//������6
	$o_memo7 = $_POST["o_memo7"];						//������7
	$o_memo8 = $_POST["o_memo8"];						//������8
	$o_memo9 = $_POST["o_memo9"];						//������9
	$o_memo10 = $_POST["o_memo10"];						//������10
	$o_memo11 = $_POST["o_memo11"];						//������11
	$o_memo12 = $_POST["o_memo12"];						//������12

	//���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
	if($form->validate()){
		Db_Query($db_con, "BEGIN;");

		//������Ͽ������Ƚ��
		if($id_null_flg==true){
			//������Ͽ��λ��å�����
			$comp_msg = "��Ͽ���ޤ�����";

			$sql  = "INSERT INTO ";
			$sql .= "t_order_sheet ";
			$sql .= "(o_pattern_id, ";
			$sql .= "o_memo1_1, ";
			$sql .= "o_memo1_2, ";
			$sql .= "o_memo2, ";
			$sql .= "o_memo3, ";
			$sql .= "o_memo4, ";
			$sql .= "o_memo5, ";
			$sql .= "o_memo6, ";
			$sql .= "o_memo7, ";
			$sql .= "o_memo8, ";
			$sql .= "o_memo9, ";
			$sql .= "o_memo10, ";
			$sql .= "o_memo11, ";
			$sql .= "o_memo12, ";
            $sql .= "shop_id) ";
			$sql .= "VALUES(";
            $sql .= "(SELECT COALESCE(MAX(o_pattern_id), 0)+1 FROM t_order_sheet), ";
			$sql .= "'$o_memo1_1', ";
			$sql .= "'$o_memo1_2', ";
			$sql .= "'$o_memo2', ";
			$sql .= "'$o_memo3', ";
			$sql .= "'$o_memo4', ";
			$sql .= "'$o_memo5', ";
			$sql .= "'$o_memo6', ";
			$sql .= "'$o_memo7', ";
			$sql .= "'$o_memo8', ";
			$sql .= "'$o_memo9', ";
			$sql .= "'$o_memo10', ";
			$sql .= "'$o_memo11', ";
			$sql .= "'$o_memo12', ";
			$sql .= "$client_id);";
		}else{
			//�Ԥ�¸�ߤ��뤬��ȯ��񥳥��Ȥ�NULL�ξ��
			if($value_flg==false){
				//��Ͽ��λ��å�����
				$comp_msg = "��Ͽ���ޤ�����";
			}else{
				//�ѹ���λ��å�����
				$comp_msg = "�ѹ����ޤ�����";
			}

			$sql  = "UPDATE ";
			$sql .= "t_order_sheet ";
			$sql .= "SET ";
			$sql .= "o_memo1_1 = '$o_memo1_1', ";
			$sql .= "o_memo1_2 = '$o_memo1_2', ";
			$sql .= "o_memo2 = '$o_memo2', ";
			$sql .= "o_memo3 = '$o_memo3', ";
			$sql .= "o_memo4 = '$o_memo4', ";
			$sql .= "o_memo5 = '$o_memo5', ";
			$sql .= "o_memo6 = '$o_memo6', ";
			$sql .= "o_memo7 = '$o_memo7', ";
			$sql .= "o_memo8 = '$o_memo8', ";
			$sql .= "o_memo9 = '$o_memo9', ";
			$sql .= "o_memo10 = '$o_memo10', ";
			$sql .= "o_memo11 = '$o_memo11', ";
			$sql .= "o_memo12 = '$o_memo12' ";
			$sql .= "WHERE ";
			$sql .= "o_pattern_id = ".$o_memo[0][0].";";
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
	'comp_msg'      => "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
