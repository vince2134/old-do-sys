<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/06      ban_0027    suzuki      ���դΥ�������ɲ�
*/

$page_title = "�߸�Ĵ��";

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
$shop_id    = $_SESSION["client_id"];
$shop_div   = $_SESSION["shop_div"];

/*****************************/
//���������
/*****************************/
//$def_data["form_output_type"] = "1";
$def_data["form_shop"]  = $shop_id;

$form->setDefaults($def_data);

/*****************************/
//�ե��������
/*****************************/
//�谷����
$form_handling_day[] =& $form->createElement(
    "text","sy","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[sy]','form_handling_day[sm]',4)\"  
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[sy]','form_handling_day[sm]','form_handling_day[sd]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","sm","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[sm]','form_handling_day[sd]',2)\" 
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[sy]','form_handling_day[sm]','form_handling_day[sd]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","sd","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[sy]','form_handling_day[sm]','form_handling_day[sd]');\""
);
$form_handling_day[] =& $form->createElement("static","","","������");
$form_handling_day[] =& $form->createElement(
    "text","ey","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[ey]','form_handling_day[em]',4)\" 
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[ey]','form_handling_day[em]','form_handling_day[ed]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","em","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_handling_day[em]','form_handling_day[ed]',2)\" 
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[ey]','form_handling_day[em]','form_handling_day[ed]');\""
);
$form_handling_day[] =& $form->createElement("static","","","-");
$form_handling_day[] =& $form->createElement(
    "text","ed","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
    onKeyDown=\"chgKeycode();\" 
	onBlur=\"blurForm(this);\" 
	onFocus=\"onForm_today(this,this.form,'form_handling_day[ey]','form_handling_day[em]','form_handling_day[ed]');\""
);
$form->addGroup( $form_handling_day,"form_handling_day","f_date_b1");

//button
$form->addElement("button","change_button","�졡��",
		$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","������","
		onClick=\"location.href='2-4-108.php'\"");

//�ܼҤξ�����ɽ��
if($shop_div=='1'){
    //���Ƚ�
    $select_value = Select_Get($db_con,'fcshop');
    $form->addElement('select', 'form_shop','', $select_value,$g_form_option_select);
}

//���ʥ�����
$form->addElement(
    "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
    $g_form_option"
);

//����̾
$form->addElement(
    "text","form_goods_cname","","size=\"34\" maxLength=\"30\" 
    $g_form_option"
);

//�Ҹ�
$select_value = Select_Get($db_con, "ware");
$form->addElement("select","form_ware","",$select_value);

// Ĵ����ͳ
$item   =   null;   
$item   =   array(  
    null => null,
    "4"  => "ȯ��", 
    "2"  => "��»", 
    "3"  => "ʶ��", 
    "5"  => "�߸˵����ߥ�",
    "1"  => "�����ƥ೫�Ϻ߸�",
    "6"  => "���֥����¤",
    "7"  => "Ĵ��", 
);
$form->addElement("select", "form_reason", "", $item, $g_form_option_select);

//ɽ���ܥ���
$form->addElement("submit","form_show_button","ɽ����");

//���ꥢ�ܥ���
$form->addElement(
    "button","form_clear_button","���ꥢ","
    onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_show_button"] == "ɽ����"){

    //POST�������
    $handling_day_sy    = $_POST["form_handling_day"]["sy"];        //�谷���֡ʳ���ǯ��
    $handling_day_sm    = $_POST["form_handling_day"]["sm"];        //�谷���֡ʳ��Ϸ��
    $handling_day_sd    = $_POST["form_handling_day"]["sd"];        //�谷���֡ʳ�������
	$handling_day_sy = str_pad($handling_day_sy,4, 0, STR_PAD_LEFT);  
	$handling_day_sm = str_pad($handling_day_sm,2, 0, STR_PAD_LEFT); 
	$handling_day_sd = str_pad($handling_day_sd,2, 0, STR_PAD_LEFT); 
	if($handling_day_sy != NULL && $handling_day_sm != NULL && $handling_day_sd != NULL){
		$hand_start = $_POST["form_handling_day"]["sy"]."-".$_POST["form_handling_day"]["sm"]."-".$_POST["form_handling_day"]["sd"];
	}

    $handling_day_ey    = $_POST["form_handling_day"]["ey"];        //�谷���֡ʽ�λǯ��
    $handling_day_em    = $_POST["form_handling_day"]["em"];        //�谷���֡ʽ�λ���
    $handling_day_ed    = $_POST["form_handling_day"]["ed"];        //�谷���֡ʽ�λ����
	$handling_day_ey = str_pad($handling_day_ey,4, 0, STR_PAD_LEFT);  
	$handling_day_em = str_pad($handling_day_em,2, 0, STR_PAD_LEFT); 
	$handling_day_ed = str_pad($handling_day_ed,2, 0, STR_PAD_LEFT); 
	if($handling_day_ey != NULL && $handling_day_em != NULL && $handling_day_ed != NULL){
		$hand_end   = $_POST["form_handling_day"]["ey"]."-".$_POST["form_handling_day"]["em"]."-".$_POST["form_handling_day"]["ed"];
	}

    $ware               = $_POST["form_ware"];                      //�Ҹ�
    $goods_cd           = $_POST["form_goods_cd"];                  //���ʥ�����
    $goods_cname         = $_POST["form_goods_cname"];                //����̾
    if($_POST["form_shop"] != null){
        $shop_id        = $_POST["form_shop"];                      //����å�ID�ʻ��Ƚ��
    }
    $reason             = $_POST["form_reason"];                    // Ĵ����ͳ

    /*****************************/
    //���顼�����å�
    /*****************************/
    // ���顼�ե饰��Ǽ�������
    $ary_err_flg = array();

    //���󹹿���
    //�谷���ʳ��ϡ�
    if(!($handling_day_sm == null && $handling_day_sd == null && $handling_day_sy == null)){ 
        if(!checkdate((int)$handling_day_sm, (int)$handling_day_sd, (int)$handling_day_sy)){
            $form->setElementError("form_handling_day","�谷���֤����դ������ǤϤ���ޤ���");
            $ary_err_flg[] = true;
        }
    }
    //�谷���ʽ�λ��
    if(!($handling_day_em == null && $handling_day_ed == null && $handling_day_ey == null)){ 
        if(!checkdate((int)$handling_day_em, (int)$handling_day_ed, (int)$handling_day_ey)){
            $form->setElementError("form_handling_day","�谷���֤����դ������ǤϤ���ޤ���");
            $ary_err_flg[] = true;
        }
    }
}

/****************************/
// ���顼�Τʤ����
/****************************/
if($_POST["form_show_button"] == "ɽ����" && $form->validate() && !(in_array(true, $ary_err_flg))){

    $show_flg = true;

    //���դ���
    //�谷���֡ʳ��ϡ�
    $handling_sday = $handling_day_sy."-".$handling_day_sm."-".$handling_day_sd;

    //�谷���֡ʽ�λ��
    $handling_eday = $handling_day_ey."-".$handling_day_em."-".$handling_day_ed;

    /****************************/
    //���Ƚ�̾����
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    client_cname ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_id = $shop_id;";
    $result = Db_Query($db_con,$sql);
    $data = Get_Data($result);
    $cshop_name = $data[0][0];

    /****************************/
    //WHERE_SQL����
    /****************************/
    //���ʥ����ɤ����ꤵ�줿���
    $where_sql  = ($goods_cd != null) ? " AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
    //����̾�����ꤵ�줿���
    $where_sql .= ($goods_cname != null) ? " AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
    //�Ҹˤ����ꤵ�줿���
    $where_sql .= ($ware != null) ? " AND t_ware.ware_id = $ware \n" : null;
    //�谷���֡ʳ��ϡˤ����ꤵ�줿���
    $where_sql .= ($handling_sday != "--") ? " AND '$handling_sday' <= t_stock_hand.work_day \n" : null;
    //�谷���֡ʽ�λ�ˤ����ꤵ�줿���
    $where_sql .= ($handling_eday != "--") ? " AND t_stock_hand.work_day <= '$handling_eday' \n" : null;
    // Ĵ����ͳ
    $where_sql .= ($reason != null) ? "AND t_stock_hand.adjust_reason = '$reason' \n" : null;

    /****************************/
    //SQL����
    /****************************/
    $sql  = "SELECT\n";
    $sql .= "   t_ware.ware_name,\n";
    $sql .= "   t_stock_hand.work_day,\n";
    $sql .= "   t_goods.goods_name,\n";
    $sql .= "   (t_stock_hand.num *\n";
    $sql .= "   CASE t_stock_hand.io_div\n";
    $sql .= "       WHEN '1' THEN 1\n";
    $sql .= "       WHEN '2' THEN -1\n";
    $sql .= "   END\n";
    $sql .= "   ) AS num,\n";
    $sql .= "   (t_stock_hand.num * t_stock_hand.adjust_price *\n";
    $sql .= "   CASE t_stock_hand.io_div\n";
    $sql .= "       WHEN '1' THEN 1\n";
    $sql .= "       WHEN '2' THEN -1\n";
    $sql .= "   END\n";
    $sql .= "   ) AS price,\n";
    $sql .= "   t_goods.goods_cd,\n";
    $sql .= "   t_stock_hand.adjust_reason ";
    $sql .= " FROM\n";
    $sql .= "   t_stock_hand,\n";
    $sql .= "   t_goods,\n";
    $sql .= "   t_ware\n";
    $sql .= " WHERE\n";
    $sql .= "   t_stock_hand.work_div ='6'\n";
    $sql .= "   AND\n";
    $sql .= "   t_stock_hand.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_ware.ware_id = t_stock_hand.ware_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.goods_id = t_stock_hand.goods_id\n";
    $sql .=     $where_sql;
    $sql .= "   ORDER BY t_ware.ware_cd, t_stock_hand.work_day, t_goods.goods_cd\n";
    $sql .= ";\n";

    /****************************/
    //�ǡ�������
    /****************************/
    $result = Db_Query($db_con, $sql);
    $page_num = pg_num_rows($result);
    $page_data = Get_Data($result);

    $j              = 0;    
    $row_color      = null; 
    $data_color     = null; 

    // �ǡ������ʬ�롼��
    for ($i=0; $i<$page_num; $i++){

        /******************************
        //  ��Ĵ����ɽ���ѥǡ�������
        ******************************/
        // No.��û�
        $j++;   

        // �Կ�����
        $row_color      = ($row_color != "Result1") ? "Result1" : "Result2";

        // Ĵ����������Ƚ��
        $data_color     = ($page_data[$i][3] >= 0) ? "plus" : "minus";

        // Ĵ����ͳ������
        $adjust_reason  = null;
        $adjust_reason  = ($page_data[$i][6] == "1") ? "�����ƥ೫�Ϻ߸�" : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "2") ? "��»"             : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "3") ? "ʶ��"             : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "4") ? "ȯ��"             : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "5") ? "�߸˵����ߥ�"     : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "6") ? "���֥����¤"   : $adjust_reason;
        $adjust_reason  = ($page_data[$i][6] == "7") ? "Ĵ��"             : $adjust_reason;

        // ɽ���ѥǡ�������
        $row_data[] = array(
            $row_color,                         // �Կ�css
            $j,                                 // No.
            $page_data[$i][0],                  // �Ҹ�̾
            $page_data[$i][1],                  // Ĵ����
            $page_data[$i][5],                  // ���ʥ�����
            $page_data[$i][2],                  // ����̾
            $data_color,                        // Ĵ������Ĵ���ۤο�
            number_format($page_data[$i][3]),   // Ĵ����
            number_format($page_data[$i][4]),   // Ĵ����
            $adjust_reason,                     // Ĵ����ͳ
        );

        // �Ҹ˷�ɽ���Ѥˡ�Ĵ������û���������
        $ware_plus_num      = ($page_data[$i][3] >= 0) ? bcadd($ware_plus_num,    $page_data[$i][3]) : $ware_plus_num;
        // �Ҹ˷�ɽ���Ѥˡ�Ĵ������û��������
        $ware_minus_num     = ($page_data[$i][3] <  0) ? bcadd($ware_minus_num,   $page_data[$i][3]) : $ware_minus_num;
         // �Ҹ˷�ɽ���Ѥˡ�Ĵ���ۤ�û���������
        $ware_plus_price    = ($page_data[$i][4] >= 0) ? bcadd($ware_plus_price,  $page_data[$i][4]) : $ware_plus_price;
        // �Ҹ˷�ɽ���Ѥˡ�Ĵ���ۤ�û��������
        $ware_minus_price   = ($page_data[$i][4] <  0) ? bcadd($ware_minus_price, $page_data[$i][4]) : $ware_minus_price;

        /******************************
        //  �Ҹ˷פ�ɽ���ѥǡ�������
        ******************************/
        // �Ҹˤ��Ѥ����
        if ($page_data[$i][0] != $page_data[$i+1][0]){

            // ɽ���ѥǡ�������
            $row_data[] = array(
                "Result3",
                null,
                null,
                "<span align=\"center\"><b>�Ҹ˷ס�����<br>���������и�</b></span>",
                null,
                null,
                null,
                number_format($ware_plus_num)."<br><span style=\"color: #ff0000;\">".number_format($ware_minus_num)."</span>",
                number_format($ware_plus_price)."<br><span style=\"color: #ff0000;\">".number_format($ware_minus_price)."</span>",
                null,
            );

            // ����ɽ���Ѥˡ�Ĵ�������Ҹ˷פ�û���������
            $total_plus_num     = ($ware_plus_num >=   0) ? bcadd($total_plus_num,    $ware_plus_num)  : $total_plus_num;
            // ����ɽ���Ѥˡ�Ĵ�������Ҹ˷פ�û��������
            $total_minus_num    = ($ware_minus_num <   0) ? bcadd($total_minus_num,   $ware_minus_num) : $total_minus_num;

            // ����ɽ���Ѥˡ�Ĵ���ۤ��Ҹ˷פ�û���������
            $total_plus_price   = ($ware_plus_price >= 0) ? bcadd($total_plus_price,  $ware_plus_price)  : $total_plus_price;
            // ����ɽ���Ѥˡ�Ĵ���ۤ��Ҹ˷פ�û��������
            $total_minus_price  = ($ware_minus_price < 0) ? bcadd($total_minus_price, $ware_minus_price) : $total_minus_price;

            // �Կ���ꥻ�åȤ���
            $row_color          = null;

            // �Ҹ˷פ�ꥻ�åȤ���
            $ware_plus_num      = 0;
            $ware_minus_num     = 0;
            $ware_plus_price    = 0;
            $ware_minus_price   = 0;

        }

    }

    /******************************
    //  ���פ�ɽ���ѥǡ�������
    ******************************/
    // Ĵ���������פ������������
    $row_data[] = array(
        "Result4",
        null,
        "<span align=\"center\"><b>���ס�����<br>���������и�</b></span>",
        null,
        null,
        null,
        null,
        number_format($total_plus_num)."<br><span style=\"color: #ff0000;\">".number_format($total_minus_num)."</span>",
        number_format($total_plus_price)."<br><span style=\"color: #ff0000;\">".number_format($total_minus_price)."</span>",
        null,
    );

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
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'       => "$html_header",
	'page_header'       => "$page_header",
	'html_footer'       => "$html_footer",
	'html_page'         => "$html_page",
	'html_page2'        => "$html_page2",
    'match_count'       => "$page_num",
    'total_minus_num'   => "$total_minus_num",
    'total_plus_num'    => "$total_plus_num",
    'total_minus_price' => "$total_minus_price",
    'total_plus_price'  => "$total_plus_price",
	'cshop_name'        => "$cshop_name",
	'hand_start'    => "$hand_start",
    'hand_end'      => "$hand_end",
    'show_flg'          => "$show_flg",
));


//�����assign
$smarty->assign("row_data", $row_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
