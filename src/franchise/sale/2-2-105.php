<?php
$page_title = "ͽ��ǡ����Ȳ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

/*****************************/
//�����ѿ�����
/*****************************/
$shop_id    = $_SESSION["client_id"];       //�����ID

/*****************************/
//�ե��������
/*****************************/
//��ɼ�ֹ�
$form->addElement(
    "text","form_slip_no","",
    "size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
     onFocus=\"onForm(this)\"
     onBlur=\"blurForm(this)\""
);

//������(����)
$form_ord_day[] =& $form->createElement(
        "text","sy","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[sy]', 'form_ord_day[sm]',4)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);

$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","sm","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[sm]', 'form_ord_day[sd]',2)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","sd","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_ord_day[sd]','form_ord_day[ey]',2)\"
        onFocus=\"onForm(this)\"
        onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","��");
//������(��λ)
$form_ord_day[] =& $form->createElement(
        "text","ey","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[ey]', 'form_ord_day[em]',4)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","em","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[em]', 'form_ord_day[ed]',2)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","ed","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onFocus=\"onForm(this)\" 
        onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_ord_day,"form_ord_day","");

//���ô��
$form_c_staff_id = Select_Get($db_con,'cstaff');
$form->addElement('select', 'form_staff', '���쥯�ȥܥå���', $form_c_staff_id, $g_form_option_select);

//ɽ���ܥ���
$form->addElement("submit","form_show_button","ɽ����","
        onClick=\"javascript:Which_Type('form_output_type','1-2-207.php','# ');\""
);

//���ꥢ
$form->addElement("button","form_clear_button","���ꥢ",
        "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);

//�����͵�����hidden
$form->addElement("hidden","hdn_slip_no");                                  //��ɼ�ֹ�
$form->addElement("hidden","hdn_ord_day_sy");                               //�������ʳ��ϡ�ǯ
$form->addElement("hidden","hdn_ord_day_sm");                               //�������ʳ��ϡ˷�
$form->addElement("hidden","hdn_ord_day_sd");                               //�������ʳ��ϡ���
$form->addElement("hidden","hdn_ord_day_ey");                               //�������ʳ��ϡ�ǯ
$form->addElement("hidden","hdn_ord_day_em");                               //�������ʳ��ϡ˷�
$form->addElement("hidden","hdn_ord_day_ed");                               //�������ʳ��ϡ���
$form->addElement("hidden","hdn_staff");                                    //���ô����

/****************************/
//��������
/****************************/
$date = date("Y-m-d");                                                      //��������

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_show_button"] == "ɽ����"){
	//���ߤΥڡ����������
    $page_count = null;
    $offset = 0;

    /******************************/
    //POST�������
    /******************************/
    $ord_day_sy  = $_POST["form_ord_day"]["sy"];                      //���������ϡ�ǯ��
    $ord_day_sm  = $_POST["form_ord_day"]["sm"];                      //���������ϡʷ��
    $ord_day_sd  = $_POST["form_ord_day"]["sd"];                      //���������ϡ�����
	if($ord_day_sy != NULL && $ord_day_sm != NULL && $ord_day_sd != NULL){
		$sday = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;        
	}
	$ord_day_ey  = $_POST["form_ord_day"]["ey"];                      //��������λ��ǯ��
    $ord_day_em  = $_POST["form_ord_day"]["em"];                      //��������λ�ʷ��
    $ord_day_ed  = $_POST["form_ord_day"]["ed"];                      //��������λ������
	if($ord_day_ey != NULL && $ord_day_em != NULL && $ord_day_ed != NULL){
		$eday = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;        
	}
    $slip_no      = $_POST["form_slip_no"];                           //��ɼ�ֹ�
    $staff_id     = $_POST["form_staff"];                             //���ô����

    $post_flg       = true;                                           //POST�ե饰
/****************************/
//�ڡ���ʬ����󥯲�������
/****************************/
}elseif(count($_POST)>0 && $_POST["form_show_button"] != "ɽ����"){

	$page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;

    /******************************/
    //POST�������
    /******************************/
    $ord_day_sy  = $_POST["hdn_ord_day_sy"];                      //���������ϡ�ǯ��
    $ord_day_sm  = $_POST["hdn_ord_day_sm"];                      //���������ϡʷ��
    $ord_day_sd  = $_POST["hdn_ord_day_sd"];                      //���������ϡ�����
	if($ord_day_sy != NULL && $ord_day_sm != NULL && $ord_day_sd != NULL){
		$sday = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;        
	}
	$ord_day_ey  = $_POST["hdn_ord_day_ey"];                      //��������λ��ǯ��
    $ord_day_em  = $_POST["hdn_ord_day_em"];                      //��������λ�ʷ��
    $ord_day_ed  = $_POST["hdn_ord_day_ed"];                      //��������λ������
	if($ord_day_ey != NULL && $ord_day_em != NULL && $ord_day_ed != NULL){
		$eday = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;        
	}
    $slip_no      = $_POST["hdn_slip_no"];                           //��ɼ�ֹ�
    $staff_id     = $_POST["hdn_staff"];                             //���ô����

    $post_flg       = true;                                           //POST�ե饰
}

/****************************/
//POST�������
/****************************/
if($post_flg == true){
 
    /****************************/
    //���顼�����å�(PHP)
    /****************************/
	$error_flg = false;            //���顼Ƚ��ե饰

	//��������
    //��ʸ��������å�
    if($ord_day_sy != null || $ord_day_sm != null || $ord_day_sd != null){
        $day_sy = (int)$ord_day_sy;
        $day_sm = (int)$ord_day_sm;
        $day_sd = (int)$ord_day_sd;
        if(!checkdate($day_sm,$day_sd,$day_sy)){
			$error_msg = "���������� �����դ������ǤϤ���ޤ���";
			$error_flg = true;
        }
    }
	if($ord_day_ey != null || $ord_day_em != null || $ord_day_ed != null){
        $day_ey = (int)$ord_day_ey;
        $day_em = (int)$ord_day_em;
        $day_ed = (int)$ord_day_ed;
        if(!checkdate($day_em,$day_ed,$day_ey)){
			$error_msg2 = "��������λ �����դ������ǤϤ���ޤ���";
			$error_flg = true;
        }
    }

    /******************************/
    //�͸���
    /******************************/
    if($error_flg == false){
   
        /*******************************/
        //��������hidden�˥��å�
        /*******************************/
        $def_data["form_ord_day"]["sy"]      = $ord_day_sy;               
        $def_data["form_ord_day"]["sm"]      = $ord_day_sm;               
        $def_data["form_ord_day"]["sd"]      = $ord_day_sd;          
		$def_data["form_ord_day"]["ey"]      = $ord_day_ey;               
        $def_data["form_ord_day"]["em"]      = $ord_day_em;               
        $def_data["form_ord_day"]["ed"]      = $ord_day_ed;          
        $def_data["form_slip_no"]            = $slip_no;  
		$def_data["form_staff"]              = $staff_id;          

        $def_data["hdn_ord_day_sy"]      = stripslashes($ord_day_sy);               
        $def_data["hdn_ord_day_sm"]      = stripslashes($ord_day_sm);               
        $def_data["hdn_ord_day_sd"]      = stripslashes($ord_day_sd);          
		$def_data["hdn_ord_day_ey"]      = stripslashes($ord_day_ey);               
        $def_data["hdn_ord_day_em"]      = stripslashes($ord_day_em);               
        $def_data["hdn_ord_day_ed"]      = stripslashes($ord_day_ed);          
        $def_data["hdn_slip_no"]         = stripslashes($slip_no);  
		$def_data["hdn_staff"]           = stripslashes($staff_id);          
        $def_data["show_button_flg"]            = "";
        $form->setConstants($def_data); 

        /****************************/
        //WHERE_SQL ����
        /****************************/
		$where_sql = NULL;
        //��ɼ�ֹ椬���ꤵ�줿���
        if($slip_no != null){
            $where_sql .= " AND t_aorder_h.ord_no LIKE '$slip_no%' ";
        }

		//�������ʳ��ϡˤ����ꤵ�줿���
        if($sday != null){
            $where_sql  = " AND '$sday' <= t_aorder_h.ord_time ";
        }

        //�������ʽ�λ�ˤ����ꤵ�줿���
        if($eday != null){
            $where_sql  = " AND t_aorder_h.ord_time < '$eday' ";
        }

        //���ô���Ԥ����ꤵ�줿���
        if($staff_id != null){
            $where_sql .= " AND (";
			$where_sql .= "  t_aorder_h.d_staff_id1 = $staff_id ";
			$where_sql .= " OR ";
			$where_sql .= "  t_aorder_h.d_staff_id2 = $staff_id ";
			$where_sql .= " OR ";
			$where_sql .= "  t_aorder_h.d_staff_id3 = $staff_id ";
			$where_sql .= " OR ";
			$where_sql .= "  t_aorder_h.d_staff_id4 = $staff_id ) ";
        }
    }
}

/****************************/
//SQL����
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_aorder_h.ord_no,";        //����ID
$sql .= "    t_aorder_h.aord_id,";       //��ɼ�ֹ�
$sql .= "    t_aorder_h.ord_time,";      //������
$sql .= "    t_client.client_name,";     //������̾
$sql .= "    t_trade.trade_id,";         //�����ʬ������
$sql .= "    t_aorder_h.net_amount,";    //�����
$sql .= "    t_staff1.staff_name,";      //ô���ԣ�
$sql .= "    t_staff2.staff_name,";      //ô���ԣ�
$sql .= "    t_staff3.staff_name,";      //ô���ԣ�
$sql .= "    t_staff4.staff_name ";      //ô���ԣ�
$sql .= "FROM ";
$sql .= "    t_aorder_h ";

$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
$sql .= "    INNER JOIN t_trade ON t_trade.trade_id = t_aorder_h.trade_id ";

$sql .= "    LEFT JOIN t_staff AS t_staff1 ON t_staff1.staff_id = t_aorder_h.d_staff_id1 "; 
$sql .= "    LEFT JOIN t_staff AS t_staff2 ON t_staff2.staff_id = t_aorder_h.d_staff_id2 "; 
$sql .= "    LEFT JOIN t_staff AS t_staff3 ON t_staff3.staff_id = t_aorder_h.d_staff_id3 "; 
$sql .= "    LEFT JOIN t_staff AS t_staff4 ON t_staff4.staff_id = t_aorder_h.d_staff_id4 "; 

$sql .= "WHERE";
$sql .= "    t_aorder_h.shop_id = $shop_id ";
$sql .= "    AND ";
$sql .= "    t_aorder_d.contract_id IS NOT NULL ";
$sql .= $where_sql;
$sql .= "ORDER BY ";
$sql .= "    t_aorder_h.ord_no ";
//�ҥåȷ��
$total_sql = $sql.";";
$result = Db_Query($db_con,$total_sql);
$total_count = pg_num_rows($result);

//OFFSET����
if($page_count != null){
    $offset = $page_count * 100 - 100;}
else{
    $offset = 0;
}

$sql .= " LIMIT 100 OFFSET $offset";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$page_data = Get_Data($result);

//�����ѹ�
for($i=0;$i<count($page_data);$i++){
	//��۷����ѹ�
	$page_data[$i][5] = number_format($page_data[$i][5]);
	//���ô��ɽ��Ƚ��
	for($c=7;$c<=9;$c++){
		//�ͤ����Ϥ���Ƥ�����ϡ��ᥤ��ʳ��ϲ��Ԥ��ɲ�
		if($page_data[$i][$c] != NULL){
			$page_data[$i][$c] = "<br>".$page_data[$i][$c];
		}
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
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
//ɽ���ϰϻ���
$range = "100";

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
	'error_msg'     => "$error_msg",
	'error_msg2'    => "$error_msg2",
));

$smarty->assign("page_data",$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
