<?php
$page_title = "��ʧ����";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB��³
$db_con = Db_Connect();

//print_array($_POST);
/****************************/
//�����ѿ�����
/****************************/
session_start();
$shop_id    = $_SESSION["client_id"];
$staff_id  = $_SESSION["staff_id"];
//��
$shop_id = 1;
/****************************/
//�������
/****************************/
//ɽ���Կ�
if(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 10;
}
//����Կ�
$del_history[] = null;

/****************************/
//�Կ��ɲ�
/****************************/
if($_POST["add_row_flg"]== 'true'){
    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+1;
    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//�Ժ������
/****************************/
if(isset($_POST["del_row"])){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
}
//print_r($del_history);
//print_r($_POST);

/***************************/
//���������
/***************************/
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

/****************************o
//�����襳��������
/****************************/
if($_POST["layer"] != null || $_POST["layer_flg"] == "true"){

    $l_num = $_POST["layer"];
    $supplier_cd    = $_POST["f_layer$l_num"];

    /****************************/
    //sql����
    /****************************/
    $supplier_sql  = " SELECT";
    $supplier_sql .= "     t_client.client_cd1,";       //�����襳����
    $supplier_sql .= "     t_client.client_name,";      //������̾
    $supplier_sql .= "     t_client.bank_name,";        //���̾
    $supplier_sql .= "     t_client.client_id";         //������ID
    $supplier_sql .= " FROM";
    $supplier_sql .= "     t_client";
    //�����襳����
    $supplier_cd1_sql  = " WHERE t_client.client_cd1 = '$supplier_cd' AND client_div = '2' AND shop_id = $shop_id";

    $supplier_sql .= $supplier_cd1_sql;

    $count_res = Db_Query($db_con,$supplier_sql.";");
    $get_row = pg_num_rows($count_res);
    if($get_row > 0){
    //������̤�������ϡ�������̾�����̾�򥻥å�
        $get_data = pg_fetch_array($count_res);
        $c_name['t_layer'.$l_num] = $get_data['client_name'];       //������̾
        $c_name['form_bank_'.$l_num] = $get_data['bank_name'];      //���̾
        $c_name['h_layer_id'][$l_num] = $get_data['client_id'];     //������ID
    }else{
    //����ξ��ϥ��ꥢ
        $c_name['t_layer'.$l_num] = "";
        $c_name['form_bank_'.$l_num] = "";
        $c_name['h_layer_id'][$l_num] = "";
    }
    $form->setConstants($c_name);
}

/****************************/
//�ե���������ʸ����
/****************************/

// ��ʧͽ�����
$form->addElement("button", "pay_button", "��ʧͽ�����", "onClick=\"javascript:Referer('1-3-301.php')\"");

// ���ϡ��ѹ�
$form->addElement("button", "new_button", "���ϡ��ѹ�", "style=color:#ff0000 onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);

// �Ȳ�
$form->addElement("button", "change_button", "�ȡ���", "onClick=\"javascript:Referer('1-3-303.php')\"");

//hidden
$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden","layer");                //�����
$form->addElement("hidden","layer_flg");            //��������ϥե饰

/*****************************/
//�ե������������ư��
/*****************************/
//���ֹ楫����
$row_num = 1;

for($i = 0; $i < $max_row; $i++){

    //�����Ƚ��
    if(!in_array("$i", $del_history)){
        //�������
        $del_data = $del_row.",".$i;

        // ��ʧ��
        $ary_element[0] = array($text3_1, $text3_3, $text3_5, $text3_7, $text3_9);
        $ary_element[1] = array("1", "3", "5", "7" ,"9","11","13","15","17");
        $ary_element[0][$i][] =& $form->createElement("text", "y_input", "", "size=\"4\" maxLength=\"4\" value=\"\" $g_form_option onkeyup=\"changeText3(this.form,".$i.")\" onFocus=\"onForm2(this,this.form,".$i.");\" style=\"$g_form_style\"");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "m_input", "", "size=\"1\" maxLength=\"2\" value=\"\"  $g_form_option onkeyup=\"changeText4(this.form,".$i.")\" onFocus=\"onForm2(this,this.form,".$i.");\" style=\"$g_form_style\"");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "d_input", "", "size=\"1\" maxLength=\"2\" value=\"\"  $g_form_option onFocus=\"onForm2(this,this.form,".$i.");\" style=\"$g_form_style\"");
        $form->addGroup($ary_element[0][$i], "f_date_a".$i,"");

        // �����ʬ
        $select_value = Select_Get($db_con, "trade_payout");
        $form->addElement("select", "trade_payout_".$i, "", $select_value, $g_form_option_select);
    
        // ���
        $form->addElement("text","form_bank_".$i, "", "size=\"20\" maxLength=\"20\" value=\"\" $g_form_option"); 

        // ������
        $form->addElement("text","f_layer".$i, "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\"onChange=Button_Submit_1('layer','#','$i') $g_form_option");
        $form->addElement("text", "t_layer".$i, "", "size=\"34\" value=\"\" style=\"color : #000000; border : #ffffff 1px solid; background-color: #ffffff;\" readonly");

        // ��ʧ���
        $form->addElement("text", "pay_mon_".$i, "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

        // �����
        $form->addElement("text", "pay_fee_".$i, "", "class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

        // ����
        $form->addElement("text", "f_mark_".$i, "", "size=\"34\" maxLength=\"20\" $g_form_option");

        // ��ʧ�ܥ���
        $form->addElement("submit", "money4", "�١�ʧ", "onClick=\"Dialogue('��ʧ���ޤ���','#')\"");

        //���
        if($row_num == $max_row-$del_num){
            $form->addElement(
                "link","form_del_row".$i,"","#",
                "���",
                "TABINDEX=-1
                onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\""
            );
             //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌��
        }else{
            $form->addElement(
                "link","form_del_row".$i,"","#",
                "���",
                "TABINDEX=-1
                onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""
            );
        }
        
        //������ID
        $form->addElement("hidden","h_layer_id[$i]");


        /****************************/
        //ɽ����HTML����
        /****************************/
        $html .= "<tr class=\"Result1\">\n";
        $html .=    "<td align=\"right\">$row_num</td>\n";

        //������
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["f_layer".$i]]->toHtml();
        $html .=        "��<a href=\"#\" onClick=\"return Open_SubWin_2('../head/dialog/1-0-208.php',Array('f_layer$i','t_layer$i','layer_flg'),500,450,5,$shop_id,$i,$row_num);\">����</a>��\n<br>\n";
        $html .=        $form->_elements[$form->_elementIndex["t_layer".$i]]->toHtml();
        $html .=    "</td>\n";


        //��ʧ��
        $html .=    "<td align=\"left\">\n";
        $html .=    $form->_elements[$form->_elementIndex["f_date_a".$i]]->toHtml();
        $html .=    "</td>\n";

        //�����ʬ
        $html .=    "<td align=\"left\">\n";
        $trade_payout = array("","1","2","3","4","5","6");
        $html .=        $form->_elements[$form->_elementIndex["trade_payout_".$i]]->toHtml();
        $html .=    "</td>\n";

        //���
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_bank_".$i]]->toHtml();
        $html .=    "</td>\n";

        //��ʧ�����
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["pay_mon_".$i]]->toHtml();
        $html .=    "</td>\n";

        //�����
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["pay_fee_".$i]]->toHtml();
        $html .=    "</td>\n";

        //����
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["f_mark_".$i]]->toHtml();
        $html .=    "</td>\n";

        //���
        $html .=    "<td align=\"center\">\n";
        $html .= $form->_elements[$form->_elementIndex["form_del_row".$i]]->toHtml();
        $html .=    "</td>\n";

        $html .= "</tr>\n";

        //���ֹ��ܣ�
        $row_num = $row_num+1;
    }
}

/****************************/
//�����ܥ��󲡲�����
/****************************/
$input_chk_flg = "true";
$l_id_cnt = 0;                                  //�����襳���ɤ�����ʹԿ�
//��ʧ�ܥ��󤬲����줿���
if($_POST['money4']=="�١�ʧ"){

    //�����������ʺ�������sql����
    $renewday_sql = "SELECT ";
    $renewday_sql .= "  max(renew_day) ";       //������������MAX��
    $renewday_sql .= "FROM ";
    $renewday_sql .= "  t_payout_h ";
    $renewday_sql .= "WHERE ";
    $renewday_sql .= "  shop_id = $shop_id";
    $renewday_sql .= ";";

    $day_res = Db_Query($db_con,$renewday_sql);
    $renewday = pg_fetch_array($day_res);
    $day_max = $renewday['max'];
    $day_max = "2006-08-02";
    $l_id = $_POST['h_layer_id'];               //������ID�����
        
     $max_row = $_POST["max_row"];              //����Կ�����
    //���ߤκ����������֤�
    for($j=0;$j<$max_row;$j++){
        //ID������ʹԤ������
        if($l_id[$j] == ""){
            $l_id_cnt++;
        }else{
            $input_id[] = $j;                   //����������Ϥ���Ƥ�����ֹ�
            
        }
    }
//print_r($l_id);
print_r($input_id);
    //����ʹԿ��ȡ���������Ʊ�����
    if($l_id_cnt == $max_row){
        $input_chk_flg = "false";
        $input_err = "�����褬����������ޤ���";
    }else{
        //���Ϥ���Ƥ���Ԥ�ʬ�����֤�
        foreach($input_id as $var){
            $input_year[$var] = $_POST['f_date_a'.$var]['y_input'];     //ǯ����
            $input_month[$var] = $_POST['f_date_a'.$var]['m_input'];    //�����
            $input_day[$var] = $_POST['f_date_a'.$var]['d_input'];      //������
            $input_trade[$var] = $_POST['trade_payout_'.$var];          //�����ʬ����
            $input_bank[$var] = $_POST['form_bank_'.$var];              //������Լ���
            $input_paymon[$var] = $_POST['pay_mon_'.$var];              //��ʧ��ۼ���
            $input_payfee[$var] = $_POST['pay_fee_'.$var];              //���������
            $inpu_mark[$var] = $_POST['f_mark_'.$var];                  //���ͼ���
            $input_date[$var] = date('Y-m-d',mktime(0,0,0,$input_month[$var],$input_day[$var],$input_year[$var]));      //���դ�������

            //���顼�����å�

            //ǯ����������Ǥʤ�
            if(($input_year[$var] !="" && $input_month[$var] != "" && $input_day[$var] != "") &&
            //Ⱦ�ѿ��ͤ����Ϥ���Ƥ���
            (ereg("^([0-9]{4})$",$input_year[$var]) && ereg("^[01]?[0-9]$",$input_month[$var]) && ereg("^[0123]?[0-9]$",$input_day[$var])) &&
            //���դ�����
            (checkdate($input_month[$var], $input_day[$var], $input_year[$var])) &&
            //�����������㡡��ʧ������ả��
            ($day_max < $input_date[$var] && $input_date[$var] <= date('Y-m-d',time()))
            ){
            }else{
                $input_chk_flg = "false";
                $date_err = "��ʧ�������դϺǽ��������������������ޤ����ϲ�ǽ�Ǥ���";
            }
            //�����ʬ������Ǥʤ�
            if($input_trade[$var] == ""){
                $input_chk_flg = "false";
                $trade_err = "�����ʬ��ɬ�����ϤǤ���";
            }
            //��ʧ��ۤ�����Ǥʤ�����������ο���
            if($input_paymon[$var] != "" && ereg("[0-9]{1,9}",$input_paymon[$var])){
            }else{
                $input_chk_flg = "false";
                $paymon_err = "��ʧ��ۤ�Ⱦ�ѿ��������Ϥ��Ƥ���������";
            }
            //������������򤫡���������ο���
            if($input_payfee[$var] == "" || ereg("[0-9]{1,9}",$input_payfee[$var])){
            }else{
                $input_chk_flg = "false";
                $payfee_err = "�������Ⱦ�ѿ��������Ϥ��Ƥ���������";
            }
        }
    }
    //���顼�����å�������true�ʤ��
    if($input_chk_flg == "true"){
        //���Ϥ���Ƥ���Ԥ�ʬ�����֤�
        foreach($input_id as $var){
            $g_num = $l_id[$var];
            $g_day = $input_date[$var];
            $gather_id[$g_num][$g_day][] = $var;
        }
print_array($gather_id);
        //�����ֹ����sql����
        $pay_no_sql = "SELECT ";
        $pay_no_sql .= "    MAX(pay_no) ";
        $pay_no_sql .= "FROM ";
        $pay_no_sql .= "    t_payout_h ";
        $pay_no_sql .= "WHERE ";
        $pay_no_sql .= "    shop_id = $shop_id";
        $pay_no_sql .= ";";

        $pay_res = Db_Query($db_con,$pay_no_sql);
        $pay_data = pg_fetch_array($pay_res);
        $pay_no_max = $pay_data['max'];                     //�����ֹ����
        $pay_no_max += 1;                                   
        $pay_no_max = str_pad($pay_no_max,8,"0",STR_PAD_LEFT);//����ˣ��ͤ�

        //��ʧ��Ͽsql����
        $pay_ragist_sql = "INSERT INTO ";
        $pay_ragist_sql .= "    t_payout_h ";
        $pay_ragist_sql .= "(";
        $pay_ragist_sql .= "    pay_id,";           //��ʧID
        $pay_ragist_sql .= "    pay_no,";           //��ʧ�ֹ�
        $pay_ragist_sql .= "    pay_day,";          //��ʧ��
        $pay_ragist_sql .= "    client_id,";        //������ID
        $pay_ragist_sql .= "    client_name,";      //������̾
        $pay_ragist_sql .= "    client_name2,";     //������̾��
        $pay_ragist_sql .= "    client_cname,";     //������̾��ά�Ρ�
        $pay_ragist_sql .= "    client_cd1,";       //�����襳����
        $pay_ragist_sql .= "    e_staff_id,";       //���ϼ�ID
        $pay_ragist_sql .= "    e_staff_name,";     //���ϼ�̾
        $pay_ragist_sql .= "    staff_id,";         //ô����ID
        $pay_ragist_sql .= "    staff_name,";       //ô����̾
        $pay_ragist_sql .= "    input_day,";        //������
        $pay_ragist_sql .= "    shop_id";           //�����ID
        $pay_ragist_sql .= ")";
        $pay_ragist_sql .= "VALUES (";
        $pay_ragist_sql .= "    ";

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
$page_menu = Create_Menu_h('buy','3');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[pay_button]]->toHtml();
$page_header = Create_Header($page_title);



// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'               => "$html_header",
    'html'                      => "$html",
    'input_err'              => "$input_err",
    'date_err'              => "$date_err",
    'trade_err'             => "$trade_err",
    'paymon_err'            => "$paymon_err",
    'payfee_err'            => "$payfee_err",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
