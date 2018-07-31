<?php
/************************
 *�ѹ�����
 *  �����ʥޥ����ι����ѹ���ȼ������о���ѹ�
 *  (2007-06-20) ���ɲä�5�Ԥ˽���<watanabe-k>
 *
 *
*************************/


//session_start();


$page_title = "���ʥ��롼������";

//�Ķ�����ե�����
require_once("ENV_local.php");
//����å�ID����
$shop_id = $_SESSION["client_id"];

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//���ʼ���
$where  = " WHERE";
$where .= "     t_goods.public_flg = 't'";
$where .= "     AND";
$where .= "     t_goods.accept_flg = '1'";
$where .= "     AND";
$where .= "     t_goods.compose_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.state IN (1,3)";
$where .= "     AND";
$where .= "     t_goods.no_change_flg = 'f'";
$where .= "     AND\n";
$where .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id)";

$code_value .= Code_Value("t_goods",$db_con , $where);

//�ȥ�󥶥������γ���
$start = "BEGIN;";
$lock = "LOCK TABLE t_goods_gr;";

//�ȥ�󥶥������ν�λ
$end = "COMMIT;";

/****************************/
//HTML���᡼������������(����)
/****************************/

//������
$form->addElement("text","note","�ƥ����ȥե�����",'size="34" maxLength="50" onFocus="onForm(this)" onBlur="blurForm(this)"');

//���롼��̾
$form->addElement("text","g_name","�ƥ����ȥե�����",'size="34" maxLength="10" onFocus="onForm(this)" onBlur="blurForm(this)"');

//��Ͽ�ܥ���
$button[] = $form->createElement("submit","touroku","�С�Ͽ","onClick=\"javascript: return Dialogue('��Ͽ���ޤ���','#')\" $disabled");
//����ܥ���
$button[] = $form->createElement("button","delete","���","onClick=\"javascript: return Dialogue_2('������ޤ���','#','true','delete_button_flg')\" $disabled");
//ɽ���ܥ���
$button[] = $form->createElement("button","display","ɽ����","onClick=\"javascript:Button_Submit('show_button_flg','#','true')\"");

$form->addGroup($button, "button", "");

//�ɲå�󥯲���Ƚ��ե饰
$form->addElement("hidden", "insert_row_flg");
//�����󥯲���Ƚ��ե饰
$form->addElement("hidden", "delete_row_flg");
//����Կ�
$form->addElement("hidden", "max_row");
//����ݻ�
$form->addElement("hidden", "d_history");
//ɽ���ܥ���ե饰
$form->addElement("hidden", "show_button_flg");
//����ܥ���ե饰
$form->addElement("hidden", "delete_button_flg");

/****************************/
//���顼�����å����
/****************************/

//ɬ�����ϥ����å�
$form->addRule('g_name','���롼��̾��ɬ�ܹ��ܤǤ���','required');
$form->addRule('note','�����Ȥ�ɬ�ܹ��ܤǤ���','required');

/****************************/
//�������
/****************************/

//���ߤιԿ�����
if(isset($_POST["max_row"])){
	$row = $_POST["max_row"];
	$d_history[] = null;
}else{
	//�ǡ����ιԿ�
	$row = 10;
	$d_history[] = null;
	//�ǡ����Կ����ݻ���
	$def_date = array(
		"max_row"     => "$row",
	);
	$form->setConstants($def_date);
}

/****************************/
//ɽ������
/****************************/

//ɽ���ܥ��󲡲�Ƚ��
if($_POST["show_button_flg"] == true){
	//���롼�פ����򤵤�Ƥ��뤫��
	if($_POST["g_select"] != ""){
		//���롼��ID����
		$group_id = $_POST["g_select"];

		//���򤵤줿���롼�ץǡ�������SQL(���롼�ץ����ɡ�����̾�����롼��̾��������)
		$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,goods_gname,note FROM t_goods,t_goods_gr";
		$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id and goods_gid = ".$group_id;
		$sql .= " ORDER BY t_goods_gr.goods_id ASC;";
		$result = Db_Query($db_con,$sql);

		//�ǡ����ιԿ�����
		$row = pg_num_rows($result);
		//�ե����༱���ֹ�
		$count = 0;
		//�ǥե������ɽ��
		while($data_list = pg_fetch_array($result)){
			$count++;
			//�ǡ����Կ������򥰥롼�פ��ݻ���
			//�ե�����˾��ʥ����ɡ�����̾�����롼��̾��������ɽ��
			$def_date = array(
				"max_row"     => "$row",
				"g_select"     => "$group_id",
			    "f_goods".$count     => "$data_list[0]",
				"t_goods".$count     => "$data_list[1]",
				"g_name"		     => "$data_list[2]",
				"note"     			 => "$data_list[3]",
				"show_button_flg"    => "",
			);
			$form->setConstants($def_date);
		}
	}else{
		//���롼�ץǡ�������SQL(���ʥ����ɡ�����̾������ID)
		$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,t_goods.goods_id FROM t_goods,t_goods_gr";
		$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id";
		$sql .= " ORDER BY t_goods_gr.goods_id ASC;";
		$result = Db_Query($db_con,$sql);

		//���ɽ���Կ�
		$row = 10;
		//�ե����༱���ֹ�
		$count = 0;

		//�ե����������
		while($data_list = pg_fetch_array($result)){
			$count++;
			$def_date = array(
			    "f_goods".$count     => "",
				"t_goods".$count     => ""
			);
			$form->setConstants($def_date);
		}
	
		//����Կ������롼��̾�������ȡ������
		$add_data = array(
			"max_row"     => "$row",
			"g_name"     => "",
			"note"     => "",
			"g_select"     => ""
		);
		$form->setConstants($add_data);
	}
	//��������POST������ɲá����롼��̾�����򤵤�Ƥ��ʤ��Τǡ�null
	$add_data = array(
		"delete_row_flg"     => "",
		"d_history"         => "",
	);
	$form->setConstants($add_data);
}

/****************************/
//�ɲý���
/****************************/

//�ɲå�󥯲���Ƚ��
if($_POST["insert_row_flg"] == true){
	//����Ԥˡ��ܣ�����
	$row = $_POST["max_row"]+5;
    $add_data = array(
		"max_row"     		 => "$row",
		"insert_row_flg"     => "",
	);  
	$form->setConstants($add_data);
	//��ɽ������Լ���
	$history = $_POST["d_history"];
	//,��ʬ��
	$d_history = explode(",", $history);
}

/****************************/
//��������ʥ�󥯡�
/****************************/

//�����󥯲���Ƚ��
if($_POST["delete_row_flg"] != ""){
	//�������������Ԥ�������ɲ�
	$delete_num = $_POST["delete_row_flg"];
	$history = $delete_num.",".$_POST["d_history"];
	//��������POST������ɲ�
	$add_data = array(
		"delete_row_flg"     => "",
		"d_history"         => "$history"
	);
	$form->setConstants($add_data);
	//,��ʬ��
	$d_history = explode(",", $history);
}

/****************************/
//��Ͽ����
/****************************/

//��Ͽ�ܥ��󲡲�Ƚ��
if(isset($_POST["button"]["touroku"]) && $form->validate()){

	//��ɽ������Լ���
	$history = $_POST["d_history"];
	//,��ʬ��
	$d_history = explode(",", $history);
	
	//���顼�����å��ե饰
	$error_flg = false;
	//���롼��̾�������ȼ���
	$g_name = $_POST["g_name"];
	$note = $_POST["note"];
	$count_goods = 1;
	$goods_id[0] = null;

	//����ɽ�����Ƥ��뾦�ʥ����ɤ����
	$insert = $_POST;

	for($i=0;$i<count($insert);$i++){
		//�ͤ�����С����ʥ�����������ݻ�
		if($insert["f_goods".$i] != null){
			//���ʥ����ɤ�Ⱦ�ѿ�����
			if(ereg("[0-9]{8}", $insert["f_goods".$i])){
				//���ʥ����ɤ�������ݻ�
				$goods_code[$count_goods] = $insert["f_goods".$i];
				$sql = "SELECT goods_id FROM t_goods WHERE goods_cd = '".$goods_code[$count_goods]."';";
				$result = Db_Query($db_con,$sql);
				//��Ͽ����Ƥ��ʤ����ʥ����ɤ�
				if(pg_num_rows($result) != null){
					//��Ͽ����Ƥ�����������¸
					$id = pg_fetch_result($result,0,0);
					//����ID�ν�ʣ�����å�
					if(in_array($id,$goods_id)){
						//��ʣ���Ƥ����顢���顼ɽ��
						$error_value = "���ʥ����ɤ���ʣ���Ƥ��ޤ���";
						//����ʹߤν�����Ԥ�ʤ�����
						$error_flg = true;
						break;
					}
					//����ID��������ݻ�
					$goods_id[$count_goods] = $id;
					$count_goods++;
				}else{
					//��Ͽ����Ƥ��ʤ��ä��顢���顼ɽ��
					$error_value = "���������ʥ����ɤ����Ϥ��Ʋ�������";
					//����ʹߤν�����Ԥ�ʤ�����
					$error_flg = true;
					break;
				}
			}else{
				//Ⱦ�ѿ����ʳ��ʤ饨�顼ɽ��
				$error_value = "���ʥ����ɤϣ�ʸ���ǡ�Ⱦ�ѿ����ΤߤǤ���";
				//����ʹߤν�����Ԥ�ʤ�����
				$error_flg = true;
				break;
			}
		}
	}

	//�����å������顼��
	if($error_flg != true){
		
		//���롼�פ����򤵤�Ƥ����硢���롼��ID�����
		if($_POST["g_select"] != ""){
			$group_id = $_POST["g_select"];

			//���롼��̾�ν�ʣ�����å�
			$sql = "SELECT goods_gname from t_goods_gr ";
			$sql .= "WHERE goods_gname = '".$g_name."' ";
			$sql .= "AND NOT goods_gid = ".$group_id.";";
			$result = Db_Query($db_con,$sql);
			if(pg_num_rows($result) != null){
				//��ʣ���Ƥ����顢���顼ɽ��
				$error_value = "���˻��Ѥ���Ƥ��� ���롼��̾ �Ǥ���";
				//����ʹߤν�����Ԥ�ʤ�����
				$error_flg = true;
			}

			if($error_flg != true){
				//�ȥ�󥶥�����󳫻�
				$result = Db_Query($db_con,$start);
				$result = Db_Query($db_con,$lock);
				//�ǡ������õ�
				$sql = "DELETE FROM t_goods_gr WHERE goods_gid = ".$group_id.";";
				$result = Db_Query($db_con,$sql);
				//�ȥ�󥶥������λ
				$result = Db_Query($db_con,$end);
			}
		}else{
			
			//���򤵤�Ƥ��ʤ���硢�������롼����Ͽ
			//���롼��ID�γ������SQL
			$sql = "SELECT max(goods_gid) FROM t_goods_gr;";
			$result = Db_Query($db_con,$sql);
			//�����礭��ID+1
			$group_id = pg_fetch_result($result,0,0) + 1;

			//���롼��̾�ν�ʣ�����å�
			$sql = "SELECT goods_gname from t_goods_gr ";
			$sql .= "WHERE goods_gname = '".$g_name."';";
			$result = Db_Query($db_con,$sql);
			if(pg_num_rows($result) != null){
				//��ʣ���Ƥ����顢���顼ɽ��
				$error_value = "���˻��Ѥ���Ƥ��� ���롼��̾ �Ǥ���";
				//����ʹߤν�����Ԥ�ʤ�����
				$error_flg = true;
			}

			//���Ϥ������롼��̾������
			$add_data = array(
				"g_select"         => "$group_id"
			);
			$form->setConstants($add_data);
		}

		//�����å������顼��
		if($error_flg != true){
			//��Ͽ���줿�ǡ�����ɽ������
			if(count($goods_id) != 0){

				$result = Db_Query($db_con,$start);
				$result = Db_Query($db_con,$lock);
				//ɽ���ǡ�����Ͽ
				for($i=1;$i<count($goods_id);$i++){
					//ɽ�����Ƥ��륰�롼�ס��ޤ��ϡ��������롼�פ���Ͽ
					$sql = "INSERT INTO t_goods_gr(goods_gid,goods_gname,note,goods_id) VALUES($group_id,'$g_name','$note',$goods_id[$i]);";
					$result = Db_Query($db_con,$sql);
				}
				$result = Db_Query($db_con,$end);

				//���򤵤줿���롼�ץǡ�������SQL
				$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,goods_gname,note FROM t_goods,t_goods_gr";
				$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id and goods_gid = ".$group_id;
				$sql .= " ORDER BY t_goods_gr.goods_id ASC;";

				$result = Db_Query($db_con,$sql);

				//�ǡ����ιԿ�����
				$row = pg_num_rows($result);

				//�ե����༱���ֹ�
				$count = 0;
				//�ǥե������ɽ��
				while($data_list = pg_fetch_array($result)){
					$count++;
					//�ǡ����Կ������򥰥롼�פ��ݻ���
					//�ե�����˾��ʥ����ɡ�����̾�����롼��̾��������ɽ��
					$def_date = array(
						"max_row"     => "$row",
						"g_select"         => "$group_id",
					    "f_goods".$count     => "$data_list[0]",
						"t_goods".$count     => "$data_list[1]",
						"g_name"		     => "$data_list[2]",
						"note"     			 => "$data_list[3]",
						
					);
					$form->setConstants($def_date);
				}
			}else{
				//��Ͽ���뾦�ʤ����Ϥ���Ƥ��ʤ���硢���顼ɽ��
				$error_value = "���ʥ����ɤ�ɬ�ܹ��ܤǤ���";
				//���ɽ���Կ�
				$row = 10;
			}
		}
	}
	if($error_flg != true){
		header("Location: ./1-4-104.php");
	}
}

/****************************/
//��������ʥܥ����
/****************************/

//����ܥ��󲡲�Ƚ��
if($_POST["delete_button_flg"] == true){
	//���롼�פ����򤵤�Ƥ��뤫��
	if($_POST["g_select"] != ""){
		//���롼��ID����
		$group_id = $_POST["g_select"];
		
		$result = Db_Query($db_con,$start);
		$result = Db_Query($db_con,$lock);

		//���򤵤줿���롼�ץǡ�������SQL
		$sql = "DELETE FROM t_goods_gr";
		$sql .= " WHERE goods_gid = ".$group_id.";";
		$result = Db_Query($db_con,$sql);
		
		$result = Db_Query($db_con,$end);

		//���롼�ץǡ�������SQL
		$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,t_goods.goods_id FROM t_goods,t_goods_gr";
		$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id";
		$sql .= " ORDER BY t_goods_gr.goods_id ASC;";
		$result = Db_Query($db_con,$sql);

		//�ե����༱���ֹ�
		$count = 0;

		//�ե����������
		while($data_list = pg_fetch_array($result)){
			$count++;
			$def_date = array(
			    "f_goods".$count     => "",
				"t_goods".$count     => ""
			);
			$form->setConstants($def_date);
		}
	
		//���ɽ���Կ�
		$row = 10;

		//����Կ������롼��̾�������ȡ������
		$add_data = array(
			"max_row"     => "$row",
			"g_name"     => "",
			"note"     => "",
		);
		$form->setConstants($add_data);
		
	}else{
		//������륰�롼��̾�����򤵤�Ƥ��ʤ���硢���顼ɽ��
		$error_value = "������륰�롼��̾�����򤷤Ʋ�������";
	}	
	//��������POST������ɲá����롼��̾�Ϥʤ��Τǡ�null
	$add_data = array(
		"delete_row_flg"     => "",
		"delete_button_flg"     => "",
		"g_select"         => ""
	);
	$form->setConstants($add_data);
}

/****************************/
//HTML���᡼������������(��ư)
/****************************/

//���ʥ��롼��
$select_value = Select_Get($db_con,'goods_gr');
$form->addElement('select', 'g_select', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//�ԥǡ�������
for($r=1;$r<=$row;$r++){
	$form->addElement("text","f_goods".$r,"�ƥ����ȥե�����","size=\"10\" maxLength=\"8\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:goods(this,'t_goods".$r."')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
	$form->addElement("text","t_goods".$r,"�ƥ����ȥե�����","size=\"34\" value=\"\" $g_text_readonly");
}

//�ԥǡ������ʤ�TPL���Ϥ�
$row_count=1;
for($r=1;$r<=$row;$r++){
	if(!in_array("$r", $d_history)){
		$html_row .= "<tr class=\"Result1\">\n";
		$html_row .= "<td align=\"right\">".$row_count."</td>\n";
		$html_row .= "<td align=\"center\">";
		$html_row .=  $form->_elements[$form->_elementIndex["f_goods".$r]]->toHtml();
		$html_row .= "��<a href=\"#\" onClick=\"return Open_SubWin('../dialog/1-0-210.php',Array('f_goods".$r."','t_goods".$r."'),500,450);\">����</a>��</td>\n";
		$html_row .= "<td align=\"left\">\n";
		$html_row .=  $form->_elements[$form->_elementIndex["t_goods".$r]]->toHtml();
		$html_row .= "</td>\n<td align=\"center\">";
		$html_row .= "<a href=\"#\" style=\"color:blue\" onClick=\"javascript: return Dialogue_1('������ޤ���',".$r.",'delete_row_flg')\">���</a>";
		$html_row .= "</td>\n</tr>\n";
		$row_count++;
	}
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
$page_menu = Create_Menu_h('stock','1');
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
	'html_row'      => "$html_row",
	'code_value'    => "$code_value",
	'error_value'   => "$error_value",
));


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
