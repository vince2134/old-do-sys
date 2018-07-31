<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/06      ban_0028    suzuki      ���դΥ�������ɲ�
 *  2007/03/06      ��ȹ���73  ��          ê�������Ⱥ������ٰ����򣱥⥸�塼��˽��󤷤����ᡢ������ҤȤĤˤޤȤ��
 *
 *
*/

$page_title = "ê�����Ӱ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id      = $_SESSION["client_id"]; 
$shop_div     = $_SESSION["shop_div"];

/****************************/
//�ե��������
/****************************/
//Ĵ���ֹ�
$form->addElement("text","form_invent_no","",
        "size=\"13\" maxLength=\"10\" style=\"$g_form_style\"  $g_form_option");

//ê����
$form_expected_day[] =& $form->createElement(
    "text","sy","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[sy]','form_ex_day[sm]',4)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","sm","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[sm]','form_ex_day[sd]',2)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","sd","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[sd]','form_ex_day[ey]',2)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","��");
$form_expected_day[] =& $form->createElement(
    "text","ey","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[ey]','form_ex_day[em]',4)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","em","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[em]','form_ex_day[ed]',2)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","ed","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup( $form_expected_day,"form_ex_day","");

//�ܼҤξ���������
if($shop_div=='1'){
    //���Ƚ�
    $select_value = Select_Get($db_con,'fcshop');
    $form->addElement('select', 'form_cshop','���쥯�ȥܥå���', $select_value,$g_form_option_select);
}

//ɽ��
$form->addElement("submit","form_show_button","ɽ����");

//���ꥢ
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// ê��Ĵ��ɽ��󥯥ܥ���
$form->addElement("button", "4_201_button", "ê��Ĵ��ɽ", "onClick=\"location.href('./2-4-201.php');\"");

// ê�����Ӱ�����󥯥ܥ���
$form->addElement("button", "4_205_button", "ê�����Ӱ���", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

$form->addElement("hidden", "h_invent_no");          //��������Ĵ��ɼ�ֹ�
$form->addElement("hidden", "h_ex_start");           //��������ê��������
$form->addElement("hidden", "h_ex_end");             //��������ê����λ��
$form->addElement("hidden", "h_cshop");              //�������λ��Ƚ�

/****************************/
//���������
/****************************/
$def_data["form_cshop"] = $shop_id;
$form->setDefaults($def_data);

/****************************/
//�ڡ������������
/****************************/
$page_count  = $_POST["f_page1"];       //���ߤΥڡ�����
if($page_count == NULL){
    $offset = 0;
}else{
    $offset = $page_count * 100 - 100;   
}

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_show_button"] == "ɽ����"){
    //���ߤΥڡ����������
    $page_count = null;
    $offset = 0;

    /****************************/
    //POST�������
    /****************************/
    //Ĵ��ɽ�ֹ�
    if($_POST["form_invent_no"] != NULL){
        $invent_no = $_POST["form_invent_no"];  
        $invent_data["h_invent_no"] = stripslashes($invent_no);
        $form->setConstants($invent_data);
    }
    //ê��������
    if($_POST["form_ex_day"]["sy"] != NULL && $_POST["form_ex_day"]["sm"] != NULL && $_POST["form_ex_day"]["sd"] != NULL){
		$base_date_y = str_pad($_POST["form_ex_day"]["sy"],4, 0, STR_PAD_LEFT);  
		$base_date_m = str_pad($_POST["form_ex_day"]["sm"],2, 0, STR_PAD_LEFT); 
		$base_date_d = str_pad($_POST["form_ex_day"]["sd"],2, 0, STR_PAD_LEFT); 
        $ex_start = $base_date_y."-".$base_date_m."-".$base_date_d;
        $start_data["h_ex_start"] = stripslashes($ex_start);
        $form->setConstants($start_data);
    }
    //ê����λ��
    if($_POST["form_ex_day"]["ey"] != NULL && $_POST["form_ex_day"]["em"] != NULL && $_POST["form_ex_day"]["ed"] != NULL){
		$base_date_ey = str_pad($_POST["form_ex_day"]["ey"],4, 0, STR_PAD_LEFT);  
		$base_date_em = str_pad($_POST["form_ex_day"]["em"],2, 0, STR_PAD_LEFT); 
		$base_date_ed = str_pad($_POST["form_ex_day"]["ed"],2, 0, STR_PAD_LEFT); 
        $ex_end = $base_date_ey."-".$base_date_em."-".$base_date_ed;
        $end_data["h_ex_end"] = stripslashes($ex_end);
        $form->setConstants($end_data);
    }
	//���Ƚ�
	if($_POST["form_cshop"] != NULL){
	    $cshop                 = $_POST["form_cshop"];                     
	    $cshop_data["h_cshop"] = stripslashes($cshop);
	    $form->setConstants($cshop_data);
    }else{
	    $cshop_data["h_cshop"] = "";
		$form->setConstants($cshop_data);
	}
	

//ɽ���ܥ��󤬲�����Ƥ��ʤ����ʥڡ���������
}else if(count($_POST) > 0 && $_POST["form_show_button"] != "ɽ����"){

    /****************************/
    //POST�������
    /****************************/
    if($_POST["h_invent_no"] != NULL){
        $invent_no = $_POST["h_invent_no"];  //ê��Ĵ���ֹ�
    }
    //ê��������
    if($_POST["h_ex_start"] != NULL){
        $ex_start = $_POST["h_ex_start"];
    }
    //ê����λ��
    if($_POST["h_ex_end"] != NULL){
        $ex_end   = $_POST["h_ex_end"];
    }
	//���Ƚ�
	if($_POST["form_cshop"] != NULL){
	    $cshop = $_POST["form_cshop"];  
	}
}

/****************************/
//���Ƚ�̾����
/****************************/
if($cshop == NULL){
	//���å����Υ���å�ID
	$sql  = "SELECT ";
	$sql .= "    client_cname ";
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $shop_id;";
}else{
	//�ץ������Υ���å�ID
	$sql  = "SELECT ";
	$sql .= "    client_cname ";
	$sql .= "FROM ";
	$sql .= "    t_client ";
	$sql .= "WHERE ";
	$sql .= "    client_id = $cshop;";
}
$result = Db_Query($db_con,$sql);
$data = Get_Data($result);
$cshop_name = $data[0][0];

/****************************/
//���顼�����å�(PHP)
/****************************/
$error_flg = false;             //���顼Ƚ��ե饰
//��ê��������
//�����������������å�
if($_POST["form_ex_day"]["sy"] != null || $_POST["form_ex_day"]["sm"] != null || $_POST["form_ex_day"]["sd"] != null){

	//����Ƚ��
	if(!ereg("^[0-9]{4}$",$_POST["form_ex_day"]["sy"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["sm"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["sd"])){
		$error = "ê����(����)�����դ������ǤϤ���ޤ���";
        $error_flg = true;
	}

    $day_y = (int)$_POST["form_ex_day"]["sy"];
    $day_m = (int)$_POST["form_ex_day"]["sm"];
    $day_d = (int)$_POST["form_ex_day"]["sd"];
    if(!checkdate($day_m,$day_d,$day_y)){
        $error = "ê����(����)�����դ������ǤϤ���ޤ���";
        $error_flg = true;
    }
}

//��ê��������
//�����������������å�
if($_POST["form_ex_day"]["ey"] != null || $_POST["form_ex_day"]["em"] != null || $_POST["form_ex_day"]["ed"] != null){

	//����Ƚ��
	if(!ereg("^[0-9]{4}$",$_POST["form_ex_day"]["ey"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["em"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["ed"])){
		$error = "ê����(��λ)�����դ������ǤϤ���ޤ���";
        $error_flg = true;
	}

    $day_y = (int)$_POST["form_ex_day"]["ey"];
    $day_m = (int)$_POST["form_ex_day"]["em"];
    $day_d = (int)$_POST["form_ex_day"]["ed"];
    if(!checkdate($day_m,$day_d,$day_y)){
        $error = "ê����(��λ)�����դ������ǤϤ���ޤ���";
        $error_flg = true;
    }
}

/****************************/
//ê�����ӥǡ�������SQL
/****************************/
//���顼�ξ���ɽ����Ԥʤ�ʤ�
if($error_flg == false){
    $sql  = "SELECT DISTINCT ";
    $sql .= "    expected_day,";           //ê����
    $sql .= "    invent_no ";              //Ĵ��ɽ�ֹ�
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
	//���Ƚ꤬���ꤵ��Ƥ�����
	if($cshop != NULL){
		$sql .= "     shop_id = $cshop ";
	}else{
		 $sql .= "    shop_id = $shop_id ";
	}
	$sql .= "AND ";
    $sql .= "    renew_flg = 't' ";
    //ê�����������ꤵ��Ƥ��뤫
    if($ex_start != NULL){
        $sql .= "    AND ";
        $sql .= "        expected_day >= '$ex_start' ";
    }
    if($ex_end != NULL){
        $sql .= "    AND ";
        $sql .= "        expected_day <= '$ex_end' ";
    }
    //Ĵ���ֹ椬���ꤵ��Ƥ�����
    if($invent_no != NULL){
        $sql .= "    AND ";
        $sql .= "        invent_no LIKE '%$invent_no%' ";
    }
    $sql .= "ORDER BY ";
    $sql .= "    invent_no DESC ";

    $result = Db_Query($db_con,$sql."LIMIT 100 OFFSET $offset;");
    $page_data = Get_Data($result);

    $result = Db_Query($db_con,$sql.";");
    //�����
    $total_count = pg_num_rows($result);

    //ɽ���ϰϻ���
    $range = "100";
    
}else{
    //�����
    $total_count = 0;
    //ɽ���ϰϻ���
    $range = "100";
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
$page_menu = Create_Menu_f('stock','2');
/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["4_201_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_205_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);


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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'error'         => "$error",
	'cshop_name'    => "$cshop_name",
	'ex_start'      => "$ex_start",
	'ex_end'        => "$ex_end",
));

$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
