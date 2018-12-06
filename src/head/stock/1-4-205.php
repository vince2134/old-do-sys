<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/06      ban_0017    suzuki      ���դΥ�������ɲ�
 *  2007/03/06      ��ȹ���73  ��          ê�������Ⱥ������ٰ����򣱥⥸�塼��˽��󤷤����ᡢ������ҤȤĤˤޤȤ��
 *
 *
*/

$page_title = "ê�����Ӱ���";

//�Ķ�����ե����� env setting file
require_once("ENV_local.php");

//HTML_QuickForm����� create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³ connect
$db_con = Db_Connect();

// ���¥����å� auth check
$auth       = Auth_Check($db_con);

/************************* ***/
//�����ѿ����� acquire external varibale
/****************************/
$shop_id      = $_SESSION["client_id"]; 

/****************************/
//�ե�������� create form
/****************************/
//Ĵ���ֹ� survey number
$form->addElement("text","form_invent_no","",
        "size=\"13\" maxLength=\"10\" style=\"$g_form_style\"  $g_form_option");

//ê���� survey date
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

//ɽ�� display
$form->addElement("submit","form_show_button","ɽ����");

//���ꥢ clear
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// ê��Ĵ��ɽ��󥯥ܥ��� stocktaking survey chart link button
$form->addElement("button", "4_201_button", "ê��Ĵ��ɽ", "onClick=\"location.href('./1-4-201.php');\"");

// ê�����Ӱ�����󥯥ܥ��� stocktaking result list link button
$form->addElement("button", "4_205_button", "ê�����Ӱ���", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

$form->addElement("hidden", "h_invent_no");          //��������Ĵ��ɼ�ֹ� survey slip number of the search condition
$form->addElement("hidden", "h_ex_start");           //��������ê�������� start date of the stocktaking of the search condition
$form->addElement("hidden", "h_ex_end");             //��������ê����λ�� end date of the stocktaking of the search condition

/****************************/
//�ڡ������������ acquire the page number info
/****************************/
$page_count  = $_POST["f_page1"];       //���ߤΥڡ����� current page number
if($page_count == NULL){
    $offset = 0;
}else{
    $offset = $page_count * 100 - 100;   
}

/****************************/
//ɽ���ܥ��󲡲����� display button pressed process
/****************************/
if($_POST["form_show_button"] == "ɽ����"){
    //���ߤΥڡ���������� initialize the current page number
    $page_count = null;
    $offset = 0;

    /****************************/
    //POST������� acquire the post information
    /****************************/
    //Ĵ��ɽ�ֹ� survey chsart number
    if($_POST["form_invent_no"] != NULL){
        $invent_no = $_POST["form_invent_no"];  
        $invent_data["h_invent_no"] = stripslashes($invent_no);
        $form->setConstants($invent_data);
    }
    //ê�������� stocktaking start date
    if($_POST["form_ex_day"]["sy"] != NULL && $_POST["form_ex_day"]["sm"] != NULL && $_POST["form_ex_day"]["sd"] != NULL){
		$base_date_y = str_pad($_POST["form_ex_day"]["sy"],4, 0, STR_PAD_LEFT);  
		$base_date_m = str_pad($_POST["form_ex_day"]["sm"],2, 0, STR_PAD_LEFT); 
		$base_date_d = str_pad($_POST["form_ex_day"]["sd"],2, 0, STR_PAD_LEFT); 
        $ex_start = $base_date_y."-".$base_date_m."-".$base_date_d;
        $start_data["h_ex_start"] = stripslashes($ex_start);
        $form->setConstants($start_data);
    }
    //ê����λ�� stocktaking end date
    if($_POST["form_ex_day"]["ey"] != NULL && $_POST["form_ex_day"]["em"] != NULL && $_POST["form_ex_day"]["ed"] != NULL){
		$base_date_ey = str_pad($_POST["form_ex_day"]["ey"],4, 0, STR_PAD_LEFT);  
		$base_date_em = str_pad($_POST["form_ex_day"]["em"],2, 0, STR_PAD_LEFT); 
		$base_date_ed = str_pad($_POST["form_ex_day"]["ed"],2, 0, STR_PAD_LEFT); 
        $ex_end = $base_date_ey."-".$base_date_em."-".$base_date_ed;
        $end_data["h_ex_end"] = stripslashes($ex_end);
        $form->setConstants($end_data);
    }

//ɽ���ܥ��󤬲�����Ƥ��ʤ����ʥڡ��������� if the display button is not pressed (page process)
}else if(count($_POST) > 0 && $_POST["form_show_button"] != "ɽ����"){

    /****************************/
    //POST������� acquire post info 
    /****************************/
    if($_POST["h_invent_no"] != NULL){
        $invent_no = $_POST["h_invent_no"];  //ê��Ĵ���ֹ� stocktaking survey number
    }
    //ê�������� stocktaking start date
    if($_POST["h_ex_start"] != NULL){
        $ex_start = $_POST["h_ex_start"];
    }
    //ê����λ�� stocktakin end date
    if($_POST["h_ex_end"] != NULL){
        $ex_end   = $_POST["h_ex_end"];
    }
}

/****************************/
//���顼�����å�(PHP) error check
/****************************/
$error_flg = false;             //���顼Ƚ��ե饰 error decision flag
//��ê�������� start stocktaking date
//�����������������å� check the valiidity of the date
if($_POST["form_ex_day"]["sy"] != null || $_POST["form_ex_day"]["sm"] != null || $_POST["form_ex_day"]["sd"] != null){

	//����Ƚ�� determine the value
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

//��ê�������� start date of the stocktaking
//�����������������å� check date valdity
if($_POST["form_ex_day"]["ey"] != null || $_POST["form_ex_day"]["em"] != null || $_POST["form_ex_day"]["ed"] != null){

	//����Ƚ�� determine the value
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
//ê�����ӥǡ�������SQL SQL that acquire stocktaking result data
/****************************/
//���顼�ξ���ɽ����Ԥʤ�ʤ� do not display if error
if($error_flg == false){
    $sql  = "SELECT DISTINCT ";
    $sql .= "    expected_day,";           //ê���� stocktaking date
    $sql .= "    invent_no ";              //Ĵ��ɽ�ֹ� stocktaking chart number
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    renew_flg = 't' ";
    //ê�����������ꤵ��Ƥ��뤫 is the stocktaking date assigned
    if($ex_start != NULL){
        $sql .= "    AND ";
        $sql .= "        expected_day >= '$ex_start' ";
    }
    if($ex_end != NULL){
        $sql .= "    AND ";
        $sql .= "        expected_day <= '$ex_end' ";
    }
    //Ĵ���ֹ椬���ꤵ��Ƥ����� if the survey nnumber is assigned
    if($invent_no != NULL){
        $sql .= "    AND ";
        $sql .= "        invent_no LIKE '%$invent_no%' ";
    }
    $sql .= "ORDER BY ";
    $sql .= "    invent_no DESC ";

    $result = Db_Query($db_con,$sql."LIMIT 100 OFFSET $offset;");
    $page_data = Get_Data($result);

    $result = Db_Query($db_con,$sql.";");
    //����� all items
    $total_count = pg_num_rows($result);

    //ɽ���ϰϻ��� assign the display area
    $range = "100";
    
}else{
    //����� all items
    $total_count = 0;
    //ɽ���ϰϻ��� assign the display area
    $range = "100";
}

/****************************/
//HTML�إå� header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('stock','2');
/****************************/
//���̥إå������� create screen header
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["4_201_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_205_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ������� create page
/****************************/
$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);


// Render��Ϣ������ render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign the form related variables
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign the other variblaes
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'error'         => "$error",
	'ex_start'      => "$ex_start",
	'ex_end'        => "$ex_end",
));

$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
