<?php

$page_title = "��󥿥뾦����Ͽ";

//�Ķ�����ե�����
require_once("ENV_local.php");
//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

//�����ʼ���
$code_value = Code_Value("t_goods",$db_con);

//����å�̾����
$shop_id = $_SESSION["client_id"];
$sql = "SELECT client_name ";
$sql .= "FROM t_client ";
$sql .= "WHERE client_id = ".$shop_id.";";
$result = Db_Query($db_con,$sql);
$shop_name = pg_fetch_result($result,0,0);

//�ե�����Υǥե������
$def_date = array(
	"shop_txt"     => "$shop_name"
);
$form->setDefaults($def_date);

/****************************/
//�������
/****************************/

//����å�̾
$form->addElement("text","shop_txt","�ƥ����ȥե�����",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//��󥿥���
$form->addElement("text","rental_txt","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\"".$g_form_option."\"");

//����
$form->addElement("text","note_txt","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\"".$g_form_option."\"");

//��󥿥���
$form->addElement("text","money_txt","�ƥ����ȥե�����","size=\"11\" style=\"text-align: right\" maxLength=\"9\"".$g_form_option."\"");

//��󥿥��
$form->addElement("text","num_txt","�ƥ����ȥե�����","size=\"11\" style=\"text-align: right\" maxLength=\"9\"".$g_form_option."\"");

//����̾
$text[] =& $form->createElement("text","code","�ƥ����ȥե�����","size=\"10\" maxLength=\"8\" onKeyUp=\"javascript:goods(this,'f_goods[name]')\"".$g_form_option."\"");
$text[] =& $form->createElement("text","name","�ƥ����ȥե�����",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text, "f_goods", "f_goods");

//��Ͽ�ܥ���
$button[] = $form->createElement("submit","touroku","�С�Ͽ","onClick=\"javascript: return Dialogue('��Ͽ���ޤ���','#')\"");
//���ꥢ�ܥ���
$button[] = $form->createElement("button","clear","���ꥢ","onClick=\"javascript: return Button_Submit('clear_flg','#','true')\"");
//���ܥ���
$button[] = $form->createElement("button","modoru","�ᡡ��","onClick=\"javascript:history.back()\"");
$form->addGroup($button, "button", "");

//���ꥢ�ܥ��󲡲�Ƚ��ե饰
$form->addElement("hidden", "clear_flg");
//�����󥯲���Ƚ��ե饰
$form->addElement("hidden", "delete_row_id");
//������󥯲���Ƚ��ե饰
$form->addElement("hidden", "update_flg");

/****************************/
//���顼�����å����
/****************************/

//ɬ�����ϥ����å�
$form->addRule('rental_txt','��󥿥����ɬ�ܹ��ܤǤ���','required');
$form->addGroupRule('f_goods', array(
	'code' => array(
		array('����̾��ɬ�ܹ��ܤǤ���','required')
	)
));
$form->addRule('money_txt','��󥿥�����ɬ�ܹ��ܤǤ���','required');
$form->addRule('num_txt','��󥿥����ɬ�ܹ��ܤǤ���','required');
$form->addRule('money_txt','��󥿥�����1��9��ǡ�Ⱦ�ѿ����ΤߤǤ���','numeric');
$form->addRule('num_txt','��󥿥����1��9��ǡ�Ⱦ�ѿ����ΤߤǤ���','numeric');

/****************************/
//�ѹ������ʥ�󥯡�
/****************************/

//�ѹ���󥯲���Ƚ��
if($_GET["rental_id"] != ""){

	//�ѹ������󥿥�ID�����
	$update_num = $_GET["rental_id"];

	//�ѹ������󥿥�����ե����������SQL
	//(��󥿥��衦���ʥ����ɡ�����̾����󥿥�������󥿥��������)
	$sql = "SELECT rental_client,t_goods.goods_cd,t_goods.goods_name,";
	$sql .= "rental_price,rental_num,note ";
	$sql .= "FROM t_goods,t_rental ";
	$sql .= "WHERE t_goods.goods_id = t_rental.goods_id ";
	$sql .= "AND rental_id = ".$update_num.";";
	$result = Db_Query($db_con,$sql);
	//GET�ǡ���Ƚ��
	Get_Id_Check($result);
	$data_list = pg_fetch_array($result,0);

	//�ե���������
	$def_date = array(
	    "rental_txt"     => "$data_list[0]",
		"f_goods[code]"  => "$data_list[1]",
		"f_goods[name]"  => "$data_list[2]",
		"money_txt"      => "$data_list[3]",
		"num_txt"        => "$data_list[4]",
		"note_txt"       => "$data_list[5]",
		"update_flg"     => "true",
	);
	$form->setDefaults($def_date);
}

/****************************/
//��Ͽ����
/****************************/

//��Ͽ�ܥ��󲡲�Ƚ��
if(isset($_POST["button"]["touroku"])){
	//���顼�κݤˤϡ���Ͽ������Ԥ�ʤ�
	if($form->validate()){
		//���ϥե������ͼ���
		$rental_txt = $_POST["rental_txt"];
		$money_txt = $_POST["money_txt"];
		$num_txt = $_POST["num_txt"];
		$note_txt = $_POST["note_txt"];
		$update_flg = $_POST["update_flg"];

		//����ID����SQL
		$code = $_POST["f_goods"]["code"];
		$sql = "SELECT goods_id FROM t_goods WHERE goods_cd = '".$code."';";
		$result = Db_Query($db_con,$sql);
		//��Ͽ����Ƥ��ʤ����ʥ����ɤ�
		if(pg_num_rows($result) != null){
			$goods_id = pg_fetch_result($result,0,0);
			//��󥿥�۷׻�
			$rental_amount = $money_txt * $num_txt;

			Db_Query($db_con, "BEGIN;");
			//��������Ͽ��Ƚ��
			if($update_flg == "true"){
				//�ѹ���λ��å�����
				$comp_msg = "�ѹ����ޤ�����";

				//���������󥿥�ID�����
				$update_num = $_GET["rental_id"];

				//���ʹ���SQL
				$sql = "UPDATE t_rental SET ";
				$sql .= "rental_client = '".$rental_txt;
				$sql .= "',goods_id = ".$goods_id;
				$sql .= ",rental_price = ".$money_txt;
				$sql .= ",rental_num = ".$num_txt;
				$sql .= ",rental_amount = ".$rental_amount;
				$sql .= ",note = '".$note_txt;
				$sql .= "' WHERE rental_id = ".$update_num.";";
			}else{
				//��Ͽ��λ��å�����
				$comp_msg = "��Ͽ���ޤ�����";

				//������ϿSQL
				$sql = "INSERT INTO t_rental VALUES(";
				$sql .= "(SELECT ";
				$sql .= "COALESCE(MAX(rental_id), 0)+1 ";
				$sql .= "FROM ";
				$sql .= "t_rental),";
				$sql .= $shop_id.",'";
				$sql .= $rental_txt."',".$goods_id.",";
				$sql .= $money_txt.",".$num_txt.",";
				$sql .= $rental_amount.",'".$note_txt."');";
			}

		 	$result = Db_Query($db_con,$sql);

			if($result == false){
				Db_Query($db_con,"ROLLBACK;");
				exit;
		    }
		
			Db_Query($db_con, "COMMIT;");

			//�ե�����&�ѹ��ե饰�����
			$def_date = array(
			    "rental_txt"     => "",
				"money_txt"     => "",
				"num_txt"     => "",
				"note_txt"     => "",
				"f_goods[name]" => "",
				"f_goods[code]" => "",
				"update_flg"     => ""
			);
			$form->setConstants($def_date);
		}else{
			//��Ͽ����Ƥ��ʤ��ä��顢���顼ɽ��
			$error_value = "���������ʥ����ɤ����Ϥ��Ʋ�������";
		}
	}
}

/****************************/
//��������ʥ�󥯡�
/****************************/

//�����󥯲���Ƚ��
if($_POST["delete_row_id"] != ""){

	//��������󥿥�ID�����
	$delete_num = $_POST["delete_row_id"];
	Db_Query($db_con, "BEGIN;");
	//���SQL
	$sql = "DELETE FROM t_rental ";
	$sql .= "WHERE rental_id = ".$delete_num.";";

	//�¹�
 	$result = Db_Query($db_con,$sql);
	if($result == false){
		Db_Query($db_con,"ROLLBACK;");
		exit;
	}
	
	Db_Query($db_con, "COMMIT;");

	//����ե饰�����
	$add_data = array(
		"delete_row_id"     => ""
	);
	$form->setConstants($add_data);
}

/****************************/
//���ꥢ����
/****************************/

//���ꥢ�ܥ��󲡲�Ƚ��
if($_POST["clear_flg"] == "true"){

	//�ե���������
	$def_date = array(
	    "rental_txt"     => "",
		"f_goods[code]"  => "",
		"f_goods[name]"  => "",
		"money_txt"      => "",
		"num_txt"        => "",
		"note_txt"       => "",
	);
	$form->setConstants($def_date);
}

/****************************/
//�ǡ�������
/****************************/

//��󥿥�������SQL(��󥿥��衦����̾����󥿥�������󥿥������󥿥�ۡ����͡���󥿥�ID)
//��󥿥���ξ�����¤��ؤ�
$sql = "SELECT rental_client,t_goods.goods_name,rental_price,";
$sql .= "rental_num,rental_amount,t_rental.note,rental_id ";
$sql .= "FROM t_goods,t_rental,t_client ";
$sql .= "WHERE t_goods.goods_id = t_rental.goods_id ";
$sql .= "AND t_client.client_id = t_rental.client_id ";
$sql .= "AND t_rental.client_id = ".$shop_id;
$sql .= " ORDER BY rental_client ASC;";

//��������ǡ�������
$result = Db_Query($db_con,$sql);
$total_count = pg_num_rows($result);


//�ԥǡ������ʤ����
while($data_list = pg_fetch_array($result)){
	$row[] = array($data_list[0],$data_list[1],$data_list[2],$data_list[3],$data_list[4],$data_list[5],$data_list[6]);
}

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
$page_menu = Create_Menu_h('system','1');
/****************************/
//���̥إå�������
/****************************/
$page_title .= "������".$total_count."���";
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
	'code_value'    => "$code_value",
	'total_count' => "$total_count",
	'error_value'  => "$error_value",
	'comp_msg'   	=> "$comp_msg"
));
$smarty->assign('row',$row);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
