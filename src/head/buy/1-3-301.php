<?php

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/23��07-017������yamanaka-s����������̾��ά�Τ�����ʸ��������
 * ��2006/10/24��07-019������yamanaka-s���������å��ܥå���������ʧ���ϥܥ��󲡲�������GET����SESSION���ڤ��ؤ�
 * ��2006/12/06��ban_0034����suzuki�����������դ˥�������ɲ�
 * ��2006/12/06��ban_0035����suzuki�������������踡���ե�����ɽ��
 * ��2006/12/06��ban_0036����suzuki��������������CD2��ɽ��
 * ��2006/12/12��ssl_0074����kaji������������������å����ʤ��ǻ�ʧ���Ϥإܥ���򲡲�����ȥ����꡼���顼����
 * ��2006/12/13��ssl_0075����kaji����������ɽ���ܥ���򲡤��Ƥ��ʧ���Ϥ����ܤ��Ƥ��ޤ��Х�����
 * ��2007/01/09��        ����watanabe-k���������褬FC�ξ��ϥ�����2��ɽ��
 * ��2007/01/25��        ����watanabe-k�����ܥ���ο��ѹ�
 *  2007-04-03              fukuda          ����������������ɲ�
 * 
 * �ѹ���
 *�����ա�������ô���ԡ���������
 *��2007/06/14��aizawa_m������ʧ���Ϥ������������������٥�󥯤��ɲ�
 *��2007/06/14��aizawa_m�����������ܤˡֻ��������פ��ɲá���ɽ������פ�����ơס�100��פ�
 *��2007/06/23��watanabe-k�����ä���������ǽ���ɲ�
 *��2007/07/05��watanabe-k���������ˡ�������������о�FC��������ʬ���ɲ�
 *��2007/07/05��watanabe-k�������襳���ɣ��θ������˥����ꥨ�顼��ɽ�������Х��ν���
 *  2007-07-12  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *  2007-07-13  fukuda      �ֻ�ʧ�����פ�ֻ����������פ��ѹ�
 */

// �ڡ���̾
$page_title = "��ʧͽ�����";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");
//���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR."schedule_payment.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_pay_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""), 
    "form_client"       => array("cd1" => "", "cd2" => ""), 
    "form_client_name"  => "",  
    "form_buy_amouont"  => array("s" => "", "e" => ""), 
    "form_pay_amouont"  => array("s" => "", "e" => ""), 
    //����2007.06.14�ɲ�
//    "form_show_num"     => "2", 
    "form_show_num"     => "1", 
    "form_close_day"    => array(   "y" => date("Y") , 
                                    "m" => date("m") , 
                                    "d" => "00" 
                                ),
    "form_update_state" => 'all',
);

// �����������
Restore_Filter2($form, "payout", "show_button", $ary_form_list);


/****************************/
// �����ѿ�����
/****************************/
$group_kind = $_SESSION["group_kind"];
$shop_id    = $_SESSION["client_id"];


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

/////$limit          = "50";     // LIMIT   #2007.06.14������
$limit          = "0";      //LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե�����ѡ������
/****************************/
// ��ʧͽ�����
$form->addElement("button", "pay_button", "��ʧͽ�����", "style=color:#ff0000 onClick=\"location.href='$_SERVER[PHP_SELF]'\"".$g_button_color);

// ����
$form->addElement("button", "new_button", "����������", "onClick=\"javascript:Referer('1-3-307.php')\"");

// ��ʧͽ����
Addelement_Date_Range($form, "form_order_day", "��ʧͽ����", "-");


// �����襳����
$text = null;
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\" $g_form_option
");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup($text, "form_client", "", "");

// ������̾��ά��
$form->addElement("text", "form_client_name", "������̾��ά��", "size=\"34\" maxLength=\"15\" $g_form_option");

// ��������ۡ��ǹ���
$text = null;
$text[] =& $form->createElement("text", "s", "", "size=\"11\" maxLength=\"9\"
    $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\"
    onkeyup=\"changeText(this.form,'form_buy_amount[s]','form_buy_amount[e]',9)\" $g_form_option
");
$text[] =& $form->createElement("static", "", "", "��");
$text[] =& $form->createElement("text", "e", "",
    "size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\""
);
$form->addGroup($text, "form_buy_amount", "", "");

// �����ʧͽ���
$text = null;
$text[] =& $form->createElement("text", "s", "", "size=\"11\" maxLength=\"9\"
    $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\"
    onkeyup=\"changeText(this.form,'form_pay_amount[s]','form_pay_amount[e]',9)\" $g_form_option
");
$text[] =& $form->createElement("static", "", "", "��");
$text[] =& $form->createElement("text", "e", "",
    "size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\" class=\"money\""
);
$form->addGroup($text, "form_pay_amount", "", "");


// ����������ALL
$form->addElement("checkbox", "payment_all_update", "", "����������","onClick=\"javascript:All_Check_Update('payment_all_update');\"");
// ��ʧ���ALL
$form->addElement("checkbox", "payment_all_delete", "", "���������", "onClick=\"javascript:All_Check_Delete('payment_all_delete');\"");

// �����������ܥ���
$form->addElement("submit", "renew_button", "����������", "
    onClick=\"javascript:return(Dialogue4('�������ޤ���'));\" $disabled
");

// ��ʧ��åܥ���
$form->addElement("submit", "cancel_button", "���������", "
    onClick=\"javascript:return(Dialogue4('�������μ�ä��ȡ�������������λ�������ʧ��ɼ���������������Ԥʤ��ޤ���'));\" $disabled
");


//FC���������������̤Τߡ�
$rank_select_value = Select_Get($db_con, "rank");
$form->addElement("select", "form_rank", "", $rank_select_value, $g_form_option_select);

/**************************/
//���������ѹ�  2007.06.14
/**************************/
//ɽ�����
$number[] = $form->createElement("radio" , "num" , Null , "���� " , "1" );
$number[] = $form->createElement("radio" , "num" , Null , "100"  , "2" );
$form->addGroup($number , "form_show_num" , "" , "");
//��������
//Addelement_Date_Range($form, "form_close_day", "��������", "-" );
$sql  = "SELECT \n";
$sql .= "   DISTINCT close_day \n";
$sql .= "FROM \n";
$sql .= "   t_client \n";
$sql .= "WHERE \n";
$sql .= "   client_div = '3' \n";
$sql .= "AND \n";
$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
for ($i = 0; $i < $num; $i++){
    $client_close_day[] = pg_fetch_result($res, $i, 0); 
}
if ($num > 0){
    asort($client_close_day);
    $client_close_day = array_values($client_close_day);
}
$item   =   null;   
$item[0]=   "����"; 
for ($i = 0; $i < $num; $i++){
    if ($client_close_day[$i] < 29 && $client_close_day[$i] != ""){ 
        $item[(int)$client_close_day[$i]] = (int)$client_close_day[$i]."��";
    }elseif ($client_close_day[$i] != "" && $client_close_day[$i] >= 29){ 
        $item[(int)$client_close_day[$i]] = "����"; 
    }       
}
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
    onkeyup=\"changeText(this.form, 'form_close_day[y]', 'form_close_day[m]', 4);\" 
    onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
    onBlur=\"blurForm(this);\"
");
$obj[]  =&  $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" class=\"ime_disabled\"
    onkeyup=\"changeText(this.form, 'form_close_day[m]', 'form_close_day[d]', 4);\" 
    onFocus=\"onForm_today2(this, this.form, 'form_close_day[y]', 'form_close_day[m]');\"
    onBlur=\"blurForm(this);\"
");
$obj[]  =&  $form->createElement("select", "d", "", $item, $g_form_option_select);
$form->addGroup($obj, "form_close_day", "��������", "-");


//��������
$form_update_state[] = $form->createElement("radio" , null , Null , "���� " , "all" );
$form_update_state[] = $form->createElement("radio" , null , Null , "̤�»�", "f" );
$form_update_state[] = $form->createElement("radio" , null , Null , "�»ܺ�", "t" );
$form->addGroup($form_update_state , "form_update_state" , "" , "");


//$number = array("1" => "10", "2" => "50", "3" => "100", "4" => "����");
//$form->addElement("select", "form_show_num", "", $number, $g_form_option_select);
/**************************/

// ɽ���ܥ���
$form->addElement("submit", "show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

/* 2007.06.14#������
// ��ʧ���Ϥإܥ���
$form->addElement(
    "button", "form_order_button", "��ʧ���Ϥ�",
    "onClick=\"javascript: Button_Submit('order_button_flg', '".$_SERVER["PHP_SELF"]."', 'true'); \" $disabled"
);


// �����ե饰
$form->addElement("hidden", "order_button_flg");
*/

/****************************/
// ɽ���ܥ��󲡲�����
/****************************/
if($_POST["show_button"] == "ɽ����"){

    // ����POST�ǡ�����0���
    $_POST["form_order_day"] = Str_Pad_Date($_POST["form_order_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ����ʧͽ����
    // ���顼��å�����
    $err_msg = "��ʧͽ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_order_day", $err_msg);

    // ����������ۡ��ǹ���
    // ���顼��å�����
    $err_msg = "��������ۡ��ǹ��� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_buy_amount", $err_msg);

    // �������ʧͽ���
    // ���顼��å�����
    $err_msg = "�����ʧͽ��� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Int($form, "form_pay_amount", $err_msg);

    //��2007.06.14�ɲâ�
    //����������
    // ���顼��å�����
//    $err_msg = "�������� �����դ������ǤϤ���ޤ���";
//    Err_Chk_Date($form, "form_close_day", $err_msg);

    // ����������
    $err_msg = "�������� �����դ������ǤϤ���ޤ���";
    // ʸ��������å�
    if (    
        ($_POST["form_close_day"]["y"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["y"])) ||
        ($_POST["form_close_day"]["m"] != null && !ereg("^[0-9]+$", $_POST["form_close_day"]["m"]))
    ){
        $form->setElementError("form_close_day", $err_msg);
    }else   
    // �����������å�
    if ($_POST["form_close_day"]["m"] != null && ($_POST["form_close_day"]["m"] < 1 || $_POST["form_close_day"]["m"] > 12)){ 
        $form->setElementError("form_close_day", $err_msg);
    }



    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;


//��������
}elseif($_POST["renew_button"] == "����������"){

    $ary_update_id = $_POST["payment_update"];

    if(count($ary_update_id) > 0){

        while($update_id = each($ary_update_id)){
            if($update_id["1"] == 'f'){
                continue;
            }

            $result = Update_Schedule_Payment($db_con, $update_id["1"]);
            if($result === false){
                exit;
            }
        }
    }

//�������
}elseif($_POST["cancel_button"] == "���������"){

    $ary_delete_id = $_POST["payment_delete"];

    $result = Delete_Schedule_Payment($db_con, $ary_delete_id);

    //��ʧ���顼
    if(is_array($result)){

        foreach($result AS $key => $var){
            $err_message[] = $var["payment_close_day"]."����".$var["client_name"]."�λ�ʧͽ��ǡ������Ф��ƴ���
                            ��ʧ�ֹ桧".$var["pay_no"]."�λ�ʧ�������äƤ��뤿�����Ǥ��ޤ���";
        }

    //�ȥ�󥶥��������
    }elseif($result === false){
        exit;
    }
}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. �ڡ����ڤ��ؤ���
/****************************/
if (($_POST["show_button"] != null && $err_flg != true ) || ($_POST != null && $_POST["show_button"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_order_day"] = Str_Pad_Date($_POST["form_order_day"]);
    $_POST["form_close_day"] = Str_Pad_Date($_POST["form_close_day"]);  //2007.06.14�ɲ�

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $order_day_sy   = $_POST["form_order_day"]["sy"];
    $order_day_sm   = $_POST["form_order_day"]["sm"];
    $order_day_sd   = $_POST["form_order_day"]["sd"];
    $order_day_ey   = $_POST["form_order_day"]["ey"];
    $order_day_em   = $_POST["form_order_day"]["em"];
    $order_day_ed   = $_POST["form_order_day"]["ed"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client_name"];
    $buy_amount_s   = $_POST["form_buy_amount"]["s"];
    $buy_amount_e   = $_POST["form_buy_amount"]["e"];
    $pay_amount_s   = $_POST["form_pay_amount"]["s"];
    $pay_amount_e   = $_POST["form_pay_amount"]["e"];
    //��2007.06.14�ɲ�
    ///$show_num       = $_POST["form_show_num"];
    $show_num       = $_POST["form_show_num"]["num"];
    $close_day_sy   = ($_POST["form_close_day"]["y"] != null)? $_POST["form_close_day"]["y"] : "____";
    $close_day_sm   = ($_POST["form_close_day"]["m"] != null)? $_POST["form_close_day"]["m"] : "__"; 
    $close_day_sd   = $_POST["form_close_day"]["d"];
/*
    $close_day_ey   = $_POST["form_close_day"]["ey"];
    $close_day_em   = $_POST["form_close_day"]["em"];
    $close_day_ed   = $_POST["form_close_day"]["ed"];
*/

    $update_state   = $_POST["form_update_state"];
    $rank_cd        = $_POST["form_rank"];

    $post_flg = true;
}
/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // ��ʧͽ�����ʳ��ϡ�
    $order_day_s = $order_day_sy."-".$order_day_sm."-".$order_day_sd;
    $sql .= ($order_day_s != "--") ? "AND '$order_day_s' <= t_schedule_payment.payment_expected_date \n" : null;
    // ��ʧͽ�����ʽ�λ��
    $order_day_e = $order_day_ey."-".$order_day_em."-".$order_day_ed;
    $sql .= ($order_day_e != "--") ? "AND t_schedule_payment.payment_expected_date <= '$order_day_e' \n" : null;
    // �����襳����1
    $sql .= ($client_cd1 != null) ? "AND t_schedule_payment.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳����2
    if ($client_cd2 != null){
        $sql .= "AND t_schedule_payment.client_cd2 LIKE '$client_cd2%' \n";
//        $sql .= "AND t_client.client_div = '3' \n";
    }
    // ������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_schedule_payment.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ��������ۡ��ǹ��ˡʳ��ϡ�
    $sql .= ($buy_amount_s != null) ? "AND $buy_amount_s <= t_schedule_payment.account_payable \n" : null;
    // ��������ۡ��ǹ��ˡʽ�λ��
    $sql .= ($buy_amount_e != null) ? "AND t_schedule_payment.account_payable <= $buy_amount_e \n" : null;
    // �����ʧͽ��ۡʳ��ϡ�
    $sql .= ($pay_amount_s != null) ? "AND $pay_amount_s <= t_schedule_payment.schedule_of_payment_this \n" : null;
    // �����ʧͽ��ۡʽ�λ��
    $sql .= ($pay_amount_e != null) ? "AND t_schedule_payment.schedule_of_payment_this <= $pay_amount_e \n" : null;


    //��������
    $sql .= ($update_state != 'all') ? "AND t_schedule_payment.last_update_flg = '$update_state' \n" : null; 

    //FC��������ʬ
    $sql .= ($rank_cd != null) ? "AND t_schedule_payment.client_id IN (SELECT 
                                                                            client_id 
                                                                        FROM 
                                                                            t_client 
                                                                        WHERE
                                                                            rank_cd = '$rank_cd'
                                                                            AND
                                                                            shop_id = $shop_id
                                                                        ) \n" : null;


    /*********************/
    // 2007.06.14�ɲ� 
    //********************/
/*
    // ���������ʳ��ϡ�
    $close_day_s = $close_day_sy."-".$close_day_sm."-".$close_day_sd;
    $sql .= ($close_day_s != "--") ? "AND '$close_day_s' <= t_schedule_payment.payment_close_day \n" : null;
    // ���������ʽ�λ��
    $close_day_e = $close_day_ey."-".$close_day_em."-".$close_day_ed;
    $sql .= ($close_day_e != "--") ? "AND t_schedule_payment.payment_close_day <= '$close_day_e' \n" : null;
*/
    // �����������������ơ�
    if ($close_day_sd == "00"){
        $sql .= "AND t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-__' \n";
    }else   
    // ��������������������
    if ($close_day_sd == "29"){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-28' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-29' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-30' \n";
        $sql .= "       OR \n";
        $sql .= "       t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-31' \n";
        $sql .= "   ) \n";
    // �����������������ջ����
    }else{  
        $sql .= "AND t_schedule_payment.payment_close_day LIKE '".$close_day_sy."-".$close_day_sm."-".$close_day_sd."' \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;
//} 2007.06.14#������


/****************************/
// �����ǡ�������
/****************************/
if ($err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   CASE t_client.client_div \n";
    $sql .= "       WHEN '3' THEN t_client.client_cd1 || '-' || t_client.client_cd2 \n";
    $sql .= "       WHEN '2' THEN t_client.client_cd1 \n";
    $sql .= "   END AS client_cd1, \n"; 
    $sql .= "   t_schedule_payment.client_cd2, \n";
    $sql .= "   to_char(t_schedule_payment.payment_expected_date, 'yyyy-mm-dd'), \n";
    $sql .= "   t_schedule_payment.last_account_payable, \n";
    $sql .= "   t_schedule_payment.payment, \n";
    $sql .= "   t_schedule_payment.rest_amount, \n";
    $sql .= "   t_schedule_payment.sale_amount, \n";
    $sql .= "   t_schedule_payment.tax_amount, \n";
    $sql .= "   t_schedule_payment.account_payable, \n";
    $sql .= "   t_schedule_payment.ca_balance_this, \n";
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";
    $sql .= "   t_schedule_payment.schedule_payment_id, \n";
    $sql .= "   t_schedule_payment.client_cname ,\n";
    $sql .= "   t_schedule_payment.payment_close_day , \n"; //������������С�2007.06.14�ɲ�
    $sql .= "   t_schedule_payment.client_id,  \n"; //������ID����С�2007.06.14�ɲ�
    $sql .= "   t_schedule_payment.last_update_flg, \n";
    $sql .= "   t_schedule_payment.last_update_day \n";
    $sql .= "FROM \n";
    $sql .= "   t_schedule_payment \n";
    $sql .= "   INNER JOIN t_client ON t_schedule_payment.client_id = t_client.client_id\n";
    $sql .= "WHERE t_schedule_payment.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "   AND t_schedule_payment.first_set_flg = 'f' ";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    //������������ʧͽ��������ʧͽ��ID�ι߽� #2007.06.14�ѹ�
    //���������������襳���ɣ��������襳���ɣ�
    $sql .= "   payment_close_day , \n";        
    $sql .= "   client_cd1, ";
    $sql .= "   client_cd2 ";

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // LIMIT, OFFSET������
    if ($post_flg == true && $err_flg != true){

        //ɽ����� -2007.06.14�ѹ�-
        if ($show_num == "1" ) {
            $limit = $total_count;  //����
        }
        else {
            $limit = 100;         //100��
        }
 /*       if($show_num == "1"){ 2007.06.14#������
            $limit = "10";
        }else if($show_num == "2"){
           $limit = "50";
        }else if($show_num == "3"){
           $limit = "100";
        }else if($show_num == "4"){
           $limit = $total_count;
        }
*/

        // �������ϰ���
        $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

        // �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
        if($page_count != null){
            // �Ժ����total_count��offset�δط������줿���
            if ($total_count <= $offset){
                // ���ե��åȤ����������
                $offset     = $offset - $limit;
                // ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
                $page_count = $page_count - 1;
                // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
                $page_count = ($total_count <= $display_num) ? null : $page_count;
            }
        }else{
            $offset = 0;
        }
    }

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $row_count      = pg_num_rows($res);
    $page_data      = Get_Data($res);

    /***************************************/
    // �ڡ�������   
    /***************************************/
    //2007.06.14_���������ѹ�������ɽ��ͭ��ξ��Τߺ���
    $html_page  = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

    }

}//IF����SQL����


/****************************/
// �ǿ��η�����������(���ṹ���Υ����å��ܥå�����ɽ��Ƚ����)
/****************************/
$sql  = "SELECT \n";
$sql .= "   COALESCE(MAX(close_day), '".START_DAY."') \n";
$sql .= "FROM \n";
$sql .= "   t_sys_renew \n";
$sql .= "WHERE \n";
$sql .= "   renew_div = '2' \n";
$sql .= "AND \n";
$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
$sql .= ";"; 

$res  = Db_Query($db_con, $sql);
$max_renew_day = pg_fetch_result($res, 0, 0);



//��ۤ򥫥�ޤǶ��ڤ�
for($i = 0; $i < $row_count; $i++){

    //�����褴�Ȥκǿ��Υ쥳���ɤΤ߹�פ�ȿ��
    if(!@in_array($page_data[$i][14],$max_client_id)){

        $max_client_id[] = $page_data[$i][14];

        $sql  = "SELECT";
        $sql .= "   COALESCE(last_account_payable, 0) AS last_account_payable, ";
        $sql .= "   COALESCE(payment, 0) AS payment, ";
        $sql .= "   COALESCE(rest_amount, 0) AS rest_amount, ";
        $sql .= "   COALESCE(sale_amount, 0) AS sale_amount,";
        $sql .= "   COALESCE(tax_amount, 0) AS tax_amount,";
        $sql .= "   COALESCE(account_payable, 0) AS account_payable,";
        $sql .= "   COALESCE(ca_balance_this, 0) AS ca_balance_this,";
        $sql .= "   COALESCE(schedule_of_payment_this, 0) AS schedule_of_payment_this ";
        $sql .= "FROM ";
        $sql .= "   t_schedule_payment ";
        $sql .= "WHERE ";
        $sql .= "   schedule_payment_id IN (SELECT ";
        $sql .= "                               MAX(schedule_payment_id) ";
        $sql .= "                           FROM ";
        $sql .= "                               t_schedule_payment ";
        $sql .= "                           WHERE ";
        $sql .= "                               client_id = ".$page_data[$i][14]."";
        $sql .= "                               $where_sql";
        $sql .= "                               AND shop_id = ".$_SESSION["client_id"]." ";
        $sql .= "                           )";
        $sql .= ";"; 

        $result = Db_Query($db_con, $sql);

        $ary_amount = pg_fetch_assoc($result, 0);


        $sum1 = bcadd($sum1, $ary_amount["last_account_payable"]);  //������ݻĹ�
        $sum2 = bcadd($sum2, $ary_amount["payment"]);               //�����ʧ��
        $sum3 = bcadd($sum3, $ary_amount["rest_amount"]);           //���۳�
        $sum4 = bcadd($sum4, $ary_amount["sale_amount"]);           //���������
        $sum5 = bcadd($sum5, $ary_amount["tax_amount"]);            //��������ǳ�
        $sum6 = bcadd($sum6, $ary_amount["account_payable"]);       //���������(�ǹ�)
        $sum7 = bcadd($sum7, $ary_amount["ca_balance_this"]);       //������ݻĹ�(�ǹ�)
        $sum8 = bcadd($sum8, $ary_amount["schedule_of_payment_this"]);          //�����ʧͽ���
    }

    //������̤�����ξ��
    $check_payment_id = $page_data[$i][11];
    if($page_data[$i][15] == 'f'){
        //�����Υ����å��ܥå��������
        $form->addElement("advcheckbox", "payment_update[$i]", null, null, null, array("f", "$check_payment_id"));
        $payment_update_data[$i] = $check_payment_id;

        //�����������λ�ʧ�Τߺ����ǽ
        if($max_renew_day < $page_data[$i][13]){
            //����Υ����å��ܥå��������
            $form->addElement("advcheckbox", "payment_delete[$i]", null, null, null, array("f", "$check_payment_id"));
            $payment_delete_data[$i] = $check_payment_id;
        }

    }else{
        //�����Υ����å��ܥå��������
        $form->addElement("static", "payment_update[$i]", "", $page_data[$i][16]);
        $set_data["payment_update"][$i] = $page_data[$i][16];
    }
}
$form->setConstants($set_data);


//������(ALL�����å�JS�����)
$javascript  = Create_Allcheck_Js ("All_Check_Update","payment_update", $payment_update_data);
//�������ALL�����å�JS�������
$javascript .= Create_Allcheck_Js ("All_Check_Delete","payment_delete", $payment_delete_data);


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
//$page_menu = Create_Menu_h('buy','3');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[pay_button]]->toHtml();
$page_header = Create_Header($page_title);


//Render��Ϣ������
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
    'sum1'          => "$sum1",
    'sum2'          => "$sum2",
    'sum3'          => "$sum3",
    'sum4'          => "$sum4",
    'sum5'          => "$sum5",
    'sum6'          => "$sum6",
    'sum7'          => "$sum7",
    'sum8'          => "$sum8",
    'r'             => "$limit",
    "err_flg"       => "$err_flg",
    "javascript"    => "$javascript",
));
$smarty->assign('row',$page_data);
$smarty->assign('post_flg',$post_flg);  //2007.06.14�ɲ�
$smarty->assign("err_message", $err_message);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

/*
print "<pre>";
print_array($form);
print "</pre>";
*/
?>
