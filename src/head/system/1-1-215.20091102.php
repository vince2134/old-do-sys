<?php
/***********************************/
//�ѹ�����
//  ��2006/03/15��
//  ������SQL�ѹ�
//����shop_id��client_id���ѹ�
/***********************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0006     suzuki     CSV���ϻ��˥��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2007-01-24      �����ѹ�     watanabe-k �ܥ���ο��ѹ�
 *
 *
*/

$page_title = "������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION[client_id];

/****************************/
//�ǥե����������
/****************************/
$def_fdata = array(
    "form_output_type"     => "1",
    "form_state_type"     => "1",
    "form_turn"     => "1"
);
$form->setDefaults($def_fdata);

/****************************/
//HTML���᡼������������
/****************************/
//���Ϸ���
$radio1[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($radio1, "form_output_type", "���Ϸ���");

//�����襳����
$form->addElement("text","form_client_cd","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\""." $g_form_option");

//������̾
$form->addElement("text","form_client_name","�ƥ����ȥե�����",'size="34" maxLength="15"'." $g_form_option");

//ά��
$form->addElement("text","form_client_cname","�ƥ����ȥե�����",'size="21" maxLength="10"'." $g_form_option");

//TEL
$form->addElement("text","form_tel","","size=\"15\" maxLength=\"13\" style=\"$g_form_style\""." $g_form_option");

//����
$radio2[] =& $form->createElement( "radio",NULL,NULL, "�����","1");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "�ٻ���","2");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$radio2[] =& $form->createElement( "radio",NULL,NULL, "����","4");
$form->addGroup($radio2, "form_state_type", "����");

//�϶�
$select_value = Select_Get($conn, "area");
$form->addElement('select', 'form_area_id',"", $select_value);

//�ܥ���
$form->addElement("submit","form_search_button","�����ե������ɽ��","onClick=\"javascript:Button_Submit_1('search_button_flg', '#', 'true')\"");

$button[] = $form->createElement("submit","show_button","ɽ����");
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addGroup($button, "form_button", "�ܥ���");
//$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","�ѹ�������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","��Ͽ����","onClick=\"location.href='1-1-216.php'\"");

//hidden
$form->addElement("hidden", "search_button_flg");

/****************************/
//�ǡ����������
/****************************/
$client_sql  = "SELECT";
$client_sql .= " t_client.client_id,";
$client_sql .= " t_client.client_cd1,";
$client_sql .= " t_client.client_name,";
$client_sql .= " t_area.area_name,";
$client_sql .= " t_client.tel,";
$client_sql .= " t_client.state";
$client_sql .= " FROM";
$client_sql .= " t_client";
$client_sql .= "  LEFT JOIN";
$client_sql .= " t_area ";
$client_sql .= " ON t_client.area_id = t_area.area_id ";
$client_sql .= " WHERE";
$client_sql .= "     t_client.shop_id = $shop_id";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = 2";

//���ɽ�����������ե������ɽ���ܥ���򲡲����ϼ����Υǡ����Τ�ɽ��
if(($_POST["search_button_flg"]!=true && $_POST["show_button"]!="ɽ����") || $_POST["search_button_flg"]==true){
    $state_first_sql .= " AND t_client.state = '1'";
    $cons_data["search_button_flg"] = false;
    $form->setConstants($cons_data);
}

//�ǡ�����ɽ�������������
$total_count_sql = $client_sql;
$count_res = Db_Query($conn, $total_count_sql.$state_first_sql." ORDER BY t_client.client_cd1;");
$page_data = Get_Data($count_res);
$match_count = pg_num_rows($count_res);

/****************************/
//���������
/****************************/
$count_sql  = " SELECT";
$count_sql .= "     COUNT(client_id)";
$count_sql .= " FROM";
$count_sql .= "     t_client";
$count_sql .= " WHERE";
$count_sql .= "     t_client.shop_id = $shop_id";
$count_sql .= "     AND";
$count_sql .= "     t_client.client_div = 2";

//�إå�����ɽ�������������
$total_count_sql = $count_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);


/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];           //���Ϸ���
    $client_cd      = trim($_POST["form_client_cd"]);       //�����襳����1
    $client_name    = trim($_POST["form_client_name"]);     //������̾
    $area_id       = $_POST["form_area_id"];               //�϶�
	$tel            = $_POST["form_tel"];                   //TEL
    $state          = $_POST["form_state_type"];            //����
    $post_flg       = true;                                 //POST�ե饰

/****************************/
//where_sql����
/****************************/
	if($post_flg == true){
	    //�����襳����1
	    if($client_cd != null){
	        $client_cd_sql  = " AND t_client.client_cd1 LIKE '$client_cd%'";
	    }
	   
	    //������̾
	    if($client_name != null){
	        $client_name_sql  = " AND t_client.client_name LIKE '%$client_name%'";
	    }
	    
	    //ά��
	    if($client_cname != null){
	        $client_cname_sql  = " AND t_client.client_cname LIKE '%$client_cname%'";
	    }
	    
		//�϶�
	    if($area_id != 0){
	        $area_id_sql = " AND t_area.area_id = $area_id";
	    }

		//TEL
	    if($tel != null){
	        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
	    }

	    //����
	    if($state != 4){
	        $state_sql = " AND t_client.state = $state";
	    }

	    $where_sql  = $client_cd_sql;
	    $where_sql .= $client_name_sql;
	    $where_sql .= $client_cname_sql;
	    $where_sql .= $area_id_sql;
		$where_sql .= $tel_sql;
	    $where_sql .= $state_sql;
	}
/****************************/
//ɽ���ǡ�������
/****************************/
	//���������
	if($output_type == 1){
		//�������
	    $client_sql .= $where_sql;
		$total_count_sql = $client_sql;
	    $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
	    $match_count = pg_num_rows($count_res);
	    
	    $page_data = Get_Data($count_res, $output_type);
	}else if($output_type == 2){
		//�������
	    $client_sql .= $where_sql;
		$total_count_sql = $client_sql;
	    $count_res = Db_Query($conn, $total_count_sql." ORDER BY t_client.client_cd1;");
	    $match_count = pg_num_rows($count_res);
	    $page_data = Get_Data($count_res,$output_type);

	    //CSV����
	    for($i = 0; $i < $match_count; $i++){
	        $csv_page_data[$i][0] = $page_data[$i][1];
	        $csv_page_data[$i][1] = $page_data[$i][2];
	        $csv_page_data[$i][2] = $page_data[$i][3];
	        $csv_page_data[$i][3] = $page_data[$i][4];
	        if($page_data[$i][5] == 1){
				$page_data[$i][5] = "�����";
			}else{
				$page_data[$i][5] = "����ٻ���";
			}
	        $csv_page_data[$i][5] = $page_data[$i][5];
	    }

	    $csv_file_name = "������ޥ���".date("Ymd").".csv";
	    $csv_header = array(
	        "�����襳����",
	        "������̾",
	        "�϶�",
			"TEL",
	        "����"
	      );

	    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
	    $csv_data = Make_Csv($csv_page_data, $csv_header);
	    Header("Content-disposition: attachment; filename=$csv_file_name");
	    Header("Content-type: application/octet-stream; name=$csv_file_name");
	    print $csv_data;
	    exit;
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
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
	'match_count'   => "$match_count",
));
$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
