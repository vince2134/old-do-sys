<?php

/*************************
 * �ѹ�����
 *  ����2006-11-28�˥��˥������󥰽����ɲ�<suzuki>
 *
 *
**************************/

$page_title = "���������";

//�Ķ�����ե�����
require_once("ENV_local.php");


//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB����³
$conn = Db_Connect();

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION["client_id"];
$display  = $_GET[display];

/****************************/
//�ǥե����������
/****************************/

//hidden�ˤ���ݻ�����
if($_GET['display'] != NULL){
	$set_id_data["hdn_display"] = $display;
	$form->setConstants($set_id_data);
}else{
	$display = $_POST["hdn_display"];
}

$def_fdata = array(
    "form_output_type"     => "1",
    "form_turn"     => "1"
);
$form->setDefaults($def_fdata);

/****************************/
//HTML���᡼������������
/****************************/
//�����襳����
$text[] =& $form->createElement("text","cd1","",
    "size=\"7\" maxLength=\"6\" value=\"\"
    style=\"$g_form_style\" 
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\"
    onkeyup=\"changeText(this.form,'form_client[cd1]', 'form_client[cd2]', 6)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\" value=\"\"
    style=\"$g_form_style\" 
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $text, "form_client", "form_client");

//������̾
$form->addElement(
    "text","form_client_name","",
    'size="34" maxLength="15" 
    onFocus="onForm(this)" 
    onBlur="blurForm(this)"'
);

//�϶�
$select_value = Select_Get($conn, 'area');
$form->addElement('select', 'form_area_id',"", $select_value);

//ɽ����
$radio3[] =& $form->createElement( "radio",NULL,NULL, "�����ɽ�","1");
$radio3[] =& $form->createElement( "radio",NULL,NULL, "������������","2");
$form->addGroup($radio3, "form_turn", "ɽ����");

//�ܥ���
$button[] = $form->createElement("submit","show_button","ɽ����");
$button[] = $form->createElement("button","close_button","�Ĥ���","onClick=\"window.close()\"");
$form->addGroup($button, "form_button", "�ܥ���");

//GET���ͤ��ݻ�����
$form->addElement("hidden","hdn_display","","");

$form->addElement("hidden","hdn_client_cd1");
$form->addElement("hidden","hdn_client_cd2");
$form->addElement("hidden","hdn_client_name");
$form->addElement("hidden","hdn_area_id");
$form->addElement("hidden","hdn_turn");

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $client_cd1     = trim($_POST["form_client"]["cd1"]);   //�����襳����1
    $client_cd2     = trim($_POST["form_client"]["cd2"]);   //�����襳����2
    $client_name    = trim($_POST["form_client_name"]);     //������̾
    $area_id        = $_POST["form_area_id"];               //�϶�ID
    $turn           = $_POST["form_turn"];                  //ɽ����

    $post_flg       = true;
    $offset         = 0;

}elseif(count($_POST) > 0 && $_POST["form_button"]["show_button"] != "ɽ����"){
    $page_count     = $_POST["f_page1"];
    $offset         = $page_count * 100 - 100;

    $client_cd1     = $_POST["hdn_client_cd1"];             //�����襳����1
    $client_cd2     = $_POST["hdn_client_cd2"];             //�����襳����2
    $client_name    = $_POST["hdn_client_name"];            //������̾
    $area_id        = $_POST["hdn_area_id"];                //�϶�ID
    $turn           = $_POST["hdn_turn"];                   //ɽ����

    $post_flg       = true;
}else{
    $offset         = 0;
    $turn           = 1;
}


/****************************/
//�ǡ������å�
/***************************/
$set_data["form_client"]["cd1"] = stripslashes($client_cd1);
$set_data["form_client"]["cd2"] = stripslashes($client_cd2);
$set_data["form_client_name"]   = stripslashes($client_name);
$set_data["form_area_id"]       = stripslashes($area_id);
$set_data["form_turn"]          = stripslashes($turn);

$set_data["hdn_client_cd1"]     = stripslashes($client_cd1);
$set_data["hdn_client_cd2"]     = stripslashes($client_cd2);
$set_data["hdn_client_name"]    = stripslashes($client_name);
$set_data["hdn_area_id"]        = stripslashes($area_id);
$set_data["hdn_turn"]           = stripslashes($turn);

$form->setConstants($set_data);

/****************************/
//WHERE_SQL����
/****************************/
if($post_flg == true){

	//�����襳����1
	if($client_cd1 != null){
	    $client_cd1_sql  = " AND t_client.client_cd1 LIKE '$client_cd1%'";
	}
	   
	//�����襳����2
	if($client_cd2 != null){
	    $client_cd2_sql  = " AND t_client.client_cd2 LIKE '$client_cd2%'";
	}
	   
	//������̾
	if($client_name != null){
	    $client_name_sql  = " AND t_client.client_name LIKE '%$client_name%'";
	}

	//�϶�
	if($area_id != 0){
	    $area_id_sql = " AND t_area.area_id = $area_id";
	}



    $where_sql  = $client_cd1_sql;
    $where_sql .= $client_cd2_sql;
    $where_sql .= $client_name_sql;
    $where_sql .= $area_id_sql;

}

/****************************/
//SQL����
/****************************/
//ɽ����
if($turn == 1){
	$turn_sql = " ORDER BY client_cd1,client_cd2 ASC";
}else{
	$turn_sql = " ORDER BY client_name ASC";
}

if($display == null){
    $sql  = " SELECT";
    $sql .= "     t_client.client_cd1,";
    $sql .= "     t_client.client_cd2,";
    $sql .= "     t_client.client_name,";
    $sql .= "     t_area.area_name,";
    $sql .= "     'true',";
    $sql .= "     t_client.client_cname";
    $sql .= " FROM";
    $sql .= "     t_client,";
    $sql .= "     t_area";
    $sql .= " WHERE";
    $sql .= "     t_client.area_id = t_area.area_id";
    $sql .= "     AND";
    $sql .= "     t_client.shop_id = $shop_id";
    $sql .= "     AND";
    $sql .= "     t_client.state = '1'";
    $sql .= "     AND";
    $sql .= "     t_client.client_div = '1'";
    $sql .=       $where_sql;
    $sql .=       $turn_sql;
}else{
    $sql  = "SELECT";
    $sql .= "    t_client.client_cd1,";
    $sql .= "    t_client.client_cd2,";
    $sql .= "    t_client.client_name,";
    $sql .= "    t_area.area_name,";
    $sql .= "    'true',";
    $sql .= "     t_client.client_cname";
    $sql .= " FROM";
    $sql .= "    t_client";
    $sql .= "        INNER JOIN";
    $sql .= "    (SELECT";
    $sql .= "        client_id";
    $sql .= "     FROM";
    $sql .= "        t_client_info";
    $sql .= "    WHERE";
    $sql .= "        client_id = claim_id";
    $sql .= "    ) AS t_client_info";
    $sql .= "    ON t_client.client_id = t_client_info.client_id";
    $sql .= "        INNER JOIN";
    $sql .= "    t_area";
    $sql .= "    ON t_client.area_id = t_area.area_id";
    $sql .= " WHERE";
    $sql .= "    t_client.client_div = '1'";
    $sql .= "    AND";
    $sql .= "    t_client.state = '1'";
    $sql .= "    AND";
    $sql .= "    t_client.shop_id = $shop_id";
    $sql .=      $where_sql;
    $sql .= " UNION ALL";
    $sql .= " SELECT";
    $sql .= "    t_client.client_cd1,";
    $sql .= "    t_client.client_cd2,";
    $sql .= "    t_client.client_name,";
    $sql .= "    t_area.area_name,";
    $sql .= "    'false',";
    $sql .= "     t_client.client_cname";
    $sql .= " FROM";
    $sql .= "    t_client";
    $sql .= "        INNER JOIN";
    $sql .= "    (SELECT";
    $sql .= "        client_id";
    $sql .= "     FROM";
    $sql .= "        t_client_info";
    $sql .= "    WHERE";
    $sql .= "        client_id != claim_id";
    $sql .= "    ) AS t_client_info";
    $sql .= "    ON t_client.client_id = t_client_info.client_id";
    $sql .= "        INNER JOIN";
    $sql .= "    t_area";
    $sql .= "    ON t_client.area_id = t_area.area_id";
    $sql .= " WHERE";
    $sql .= "    t_client.client_div = '1'";
    $sql .= "    AND";
    $sql .= "    t_client.state = '1'";
    $sql .= "    AND";
    $sql .= "    t_client.shop_id = $shop_id";
    $sql .=      $where_sql;
    $sql .=      $turn_sql;
}

/******************************/
//ɽ���ǡ�������
/******************************/
//�������
$total_count_sql = $sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_num_rows($count_res);

//ɽ���ǡ���
$limit_sql = " LIMIT 100 OFFSET $offset";
$sql       = $sql.$limit_sql.";";
$result    = Db_Query($conn, $sql);
$page_data = Get_Data($result,2);
$match_count = pg_num_rows($result);

for($i = 0; $i < $match_count; $i++){
    for($j = 0; $j < count($page_data[$i]); $j++){
        //�����襳����
        if($j==0){
            $return = "'".$page_data[$i][$j]."'";
		}else if($j==1){
            $return = $return.",'".$page_data[$i][$j]."'";
        //������̾��'�����Ϥ�����ǽ���������
        }else if($j==2){
            $single = addslashes($page_data[$i][$j]);
            $return = $return.",'".htmlspecialchars($single)."'";
        }
        $page_data[$i][$j] = htmlspecialchars($page_data[$i][$j],ENT_QUOTES);
    }
    $return_data[] = $return;
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
$page_title .= "������".$t_count."���";
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
//ɽ���ϰϻ���
$range = "100";

$html_page = Html_Page($total_count,$page_count,1,$range,650);
$html_page2 = Html_Page($total_count,$page_count,2,$range,650);

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
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
	
));
$smarty->assign('row',$page_data);
$smarty->assign('return_data', $return_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
