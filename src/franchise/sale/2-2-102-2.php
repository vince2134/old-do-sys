<?php

/******************************
 *  �ѹ�����
 *      ����2006-�ߡ�-�ߡߡ�ɽ���ܥ��󲡲����˥����꡼�¹�<suzuki>
 *      ����2006-10-26�����Ψ��0%��ô���Ԥ�ɽ��<suzuki>
 *                      �����衦����åפμ�����֤˴ط��ʤ�ɽ��<suzuki>
 *      ����2006-10-31�˸�������POST��������<suzuki>
 *      ����2006-11-01��Ʊ������饤����ɼ������ɽ�������Τ���<suzuki>
 *      ��              ���ե�󥯲�������TOP�����ܤ��ʤ��褦�˽���<suzuki>
 *      ��              �������ܥ��󲡲�����SQL���顼�ˤʤ�ʤ��褦�˽���<suzuki>
 *
******************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/10      02-061      suzuki      ͽ�����˥�������ɽ������Ƚ���Ԥ��褦�˽���
 *  2007/02/09      ��˾14-1    kajioka-h   ɽ����������ǤޤȤ��ɽ���ʥ�󥯡������
 *                  ��˾14-2    kajioka-h   �������Ϥޤ��ɽ�����ѹ�
 *                  B0702-005   kajioka-h   ���ե�󥯤�;�פʼ��������äƤ����Τ���
 *                  B0702-006   kajioka-h   ľ�Ĥ˼�������������夬ɽ������Ƥ����Τ���
 *                  B0702-007   kajioka-h   �����ɼ�����ե�󥯤˽�ʣ���Ƽ�����ɽ�����Ƥ����Τ���
 *  2007/02/22      xx-xxx      kajioka-h   Ģɼ���ϵ�ǽ����
 *  2007/02/26      B0702-010   kajioka-h   ɽ���ܥ��󲡲�����JS���顼���ФƤ����Τ���
 *  2007/03/14      xx-xxx      kajioka-h   ��α������줿��ɼ��ɽ�����ʤ��褦���ѹ�
 *  2007/03/27                  watanabe-k  ���ô���ԤΥꥹ�Ȥ򥹥��åեޥ������Ȥ˺�������褦�˽���
 *  2007-04-09                  fukuda      ���������������
 *  2007/04/17      B0702-045   kajioka-h   ¾�β��̤������ܤ��Ƥ������ˡ����դθ������ܤ���������ʤ��Х�����
 *                  B0702-046   kajioka-h   ¾�β��̤������ܤ��Ƥ������ˡ��轵�ܥ��󤬵�ǽ���ʤ��Х�����
 *  2007/05/08      ����¾149�� kajioka-h   ���1ǯʬ�����褦���ѹ�
 *                  xx-xxx      kajioka-h   �����ȥ����Ȥ���Ƥ��ս�ʥ������������������ܥ��󤢤���ˤ򤶤ä�����
 *  2010/05/13      Rev.1.5     hashimoto-y ���Ψ����ξ�硢����ͽ��ۤ˽��פ�����Զ��ν���
 *
 */

$page_title = "���ͽ�ꥫ������(��)";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);

//������ʬɽ������Ρ�
$back_cal_month = 12;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_part_1"   => "",
    "form_staff_1"  => "",
    "form_fc"       => "",
);

// �����������
Restore_Filter2($form, "contract", "indicate_button", $ary_form_list);

// �⥸�塼���ֹ����
$module_no = Get_Mod_No();

// �����ܻ���ɽ���������
if ($_GET["search"] == "1"){
    $_POST["next_w_button_flg"] = $_SESSION[$module_no]["all"]["next_w_button_flg"];
    $_POST["back_w_button_flg"] = $_SESSION[$module_no]["all"]["back_w_button_flg"];
    $_POST["form_sale_day"]["y"]= $_SESSION[$module_no]["all"]["form_sale_day"]["y"];
    $_POST["form_sale_day"]["m"]= $_SESSION[$module_no]["all"]["form_sale_day"]["m"];
    $_POST["form_sale_day"]["d"]= $_SESSION[$module_no]["all"]["form_sale_day"]["d"];
}


/****************************/
//����ؿ����
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");

/****************************/
//�����ѿ�
/****************************/
$client_id = $_SESSION["client_id"];

/****************************/
//������������
/****************************/
$sql  = "SELECT ";
$sql .= "    cal_peri ";    //��������ɽ������
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_id = $client_id;";
$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
//�����ǡ���������
if($num == 1){
    $cal_peri      = pg_fetch_result($result, 0,0);
}

//�������
$sql  = "SELECT stand_day FROM t_stand;";
$result = Db_Query($db_con, $sql); 
$stand_day = pg_fetch_result($result,0,0);   
$day_by = substr($stand_day,0,4);
$day_bm = substr($stand_day,5,2);
$day_bd = substr($stand_day,8,2);


/****************************/
//�����ǡ�������
/****************************/
$sql  = "SELECT ";
$sql .= "    holiday ";     //����
$sql .= "FROM ";
$sql .= "    t_holiday ";
$sql .= "WHERE ";
$sql .= "    shop_id = $client_id;";
$result = Db_Query($db_con, $sql);
$h_data = Get_Data($result);
for($h=0;$h<count($h_data);$h++){
    //�����ǡ�����Ϣ������ˤ�ä����
    $holiday[$h_data[$h][0]] = "1";
}

/****************************/
//���եǡ�������
/****************************/
//���������ռ���
$year  = date("Y");
$month = date("m");
$day   = date("d");

//�������ν��������������
$date_tmp = date("Y-m-d", mktime(0, 0, 0, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)), $year));
$date_array_tmp = explode("-", $date_tmp);
$year  = $date_array_tmp[0];
$month = $date_array_tmp[1];
$day   = $date_array_tmp[2];

//ɽ�����֤κǽ�η����
$str = mktime(0, 0, 0, date("n") - $back_cal_month, 1, date("Y"));
$b_year  = date("Y",$str);
$b_month = date("m",$str);

//��������ɽ�����֤κǸ�η����
$str = mktime(0, 0, 0, date("n")+$cal_peri,1,date("Y"));
$c_year  = date("Y",$str);
$c_month = date("m",$str);

//��������ɽ������
$cal_range = $b_year."ǯ ".$b_month."�� �� ".$c_year."ǯ ".$c_month."��";

//�콵�ָ�����ռ���
$next = mktime(0, 0, 0, $month,$day+6,$year);
$nyear  = date("Y",$next);
$nmonth = date("m",$next);
$nday   = date("d",$next);

/****************************/
//POST�������
/****************************/
if ($_POST != null){
    $post_part_id   = $_POST["form_part_1"];    //����
    $post_staff_id  = $_POST["form_staff_1"];   //ô����
    $post_fc_id     = $_POST["form_fc"];        //������
}

//ͽ���������ꤵ��Ƥ��뤫
// ͽ��ǡ��������ܥ��󤬲�����Ƥ��ʤ�����ͽ������POST��������ˤޤ��ϡ�
// ͽ��ǡ��������ܥ��󤬲�����Ƥ��롡����ͽ������SESSION���������
if(
    ($_POST["form_sale_day"]["y"] != NULL || $_POST["form_sale_day"]["m"] != NULL || $_POST["form_sale_day"]["d"] != NULL)
){

        $year  = str_pad($_POST["form_sale_day"]["y"],4, 0, STR_PAD_LEFT);
        $month = str_pad($_POST["form_sale_day"]["m"],2, 0, STR_PAD_LEFT);
        $day   = str_pad($_POST["form_sale_day"]["d"],2, 0, STR_PAD_LEFT);

    //�������ν��������������
    $date_tmp = date("Y-m-d", mktime(0, 0, 0, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)), $year));
    $date_array_tmp = explode("-", $date_tmp);
    $year  = $date_array_tmp[0];
    $month = $date_array_tmp[1];
    $day   = $date_array_tmp[2];

    //�轵Ƚ��
    if($_POST["back_w_button_flg"] == true){
        $snext = mktime(0, 0, 0, $month,$day-7,$year);
    //�⽵Ƚ��
    }else if($_POST["next_w_button_flg"] == true){
        $snext = mktime(0, 0, 0, $month,$day+7,$year);
    }else{
        //ɽ���ܥ��󲡲���
        $snext = mktime(0, 0, 0, $month,$day,$year);
    }
    $snyear  = date("Y",$snext);
    $snmonth = date("m",$snext);
    $snday   = date("d",$snext);

    //��������ɽ������ʬ����ɽ�������ʤ���Ƚ��
    $max_day = date("t",mktime(0, 0, 0, date("m")+$cal_peri,1,date("Y")));
    $fast_day = date("Y-m-d", mktime(0, 0, 0, date("m")+$cal_peri,$max_day,date("Y")));

    //���κǽ�ν���
    $check_day = date("Y-m-d", mktime(0, 0, 0, $snmonth,$snday+7,$snyear));
    if($check_day > $fast_day){
        //�⽵�ܥ������ɽ���ˤ���
        $nw_disabled_flg = true;

        //�����ޤǤ����ռ���
        $nyear = substr($fast_day,0,4);
        $nmonth = substr($fast_day,5,2);
        $nday = substr($fast_day,8,2);
    }else{
        //�콵�ָ�����ռ���
        $next = mktime(0, 0, 0, $snmonth,$snday+6,$snyear);
        $nyear  = date("Y",$next);
        $nmonth = date("m",$next);
        $nday   = date("d",$next);
    }


    //����1���������������ʥ��������κǽ������
    //$last_day = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1 - date("w", mktime(0, 0, 0, date("m")-1, 1, date("Y"))), date("Y")));
    //ɽ�����֤κǽ�η��1�������뽵�������������ʥ��������κǽ������
    $last_day = date("Y-m-d", mktime(0, 0, 0, date("m") - $back_cal_month, 1 - date("w", mktime(0, 0, 0, date("m") - $back_cal_month, 1, date("Y"))), date("Y")));
    
    //����κǽ�ν���
    $check_day = date("Y-m-d", mktime(0, 0, 0, $snmonth,$snday,$snyear));

    //if($check_day < $last_day){
    if($check_day <= $last_day){
        //�轵�ܥ������ɽ���ˤ���
        $bw_disabled_flg = true;
    }


    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    $error_flg = false;            //���顼Ƚ��ե饰

    //����Ƚ��
    if(!ereg("^[0-9]{4}$",$year) || !ereg("^[0-9]{2}$",$month) || !ereg("^[0-9]{2}$",$day)){
        $error_msg = "ͽ������ �����դ������ǤϤ���ޤ���";
        $error_flg = true;        //���顼ɽ��
    }

    //��ʸ��������å�
    $year  = (int)$year;
    $month = (int)$month;
    $day   = (int)$day;
    if(!checkdate($month,$day,$year)){
        $error_msg = "ͽ������ �����դ������ǤϤ���ޤ���";
        $error_flg = true;        //���顼ɽ��
    }

    $ord_date = str_pad($snyear,4,"0", STR_PAD_LEFT)."-".str_pad($snmonth,2,"0", STR_PAD_LEFT)."-".str_pad($snday,2,"0", STR_PAD_LEFT);
    /****************************/
    //������ɽ�����ּ���
    /****************************/
    $cal_array = Cal_range($db_con,$client_id,true);
    $check_edate   = $cal_array[1];     //�оݽ�λ����

    //��������ɽ������Ƚ��
    if($last_day > $ord_date || $ord_date > $check_edate){
        $error_msg2 = "ͽ������ �ϥ�������ɽ�����������ꤷ�Ʋ�������";
        $error_flg = true;        //���顼ɽ��
    }

}

/****************************/
//�������轵�ܥ��󲡲�����
/****************************/
if($_POST["back_w_button_flg"] == true){

    //�轵Ƚ��
    if($_POST["back_w_button_flg"] == true){
        //�轵�����ռ���
        $str = mktime(0, 0, 0, $month,$day-7,$year);
    }else{
        //���������ռ���
        $str = mktime(0, 0, 0, $month,$day-1,$year);
    }

    $year  = date("Y",$str);
    $month = date("m",$str);
    $day   = date("d",$str);

    //��������ɽ������ʬ����ɽ�������ʤ���Ƚ��
    $max_day = date("t",mktime(0, 0, 0, date("m")+$cal_peri,1,date("Y")));
    $fast_day = date("Y-m-d", mktime(0, 0, 0, date("m")+$cal_peri,$max_day,date("Y")));

    //���κǽ�ν���
    $check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day+7,$year));
    if($check_day > $fast_day){
        //�⽵�ܥ������ɽ���ˤ���
        $nw_disabled_flg = true;

        //�����ޤǤ����ռ���
        $nyear = substr($fast_day,0,4);
        $nmonth = substr($fast_day,5,2);
        $nday = substr($fast_day,8,2);
    }else{
        //�콵�ָ�����ռ���
        $next = mktime(0, 0, 0, $month,$day+6,$year);
        $nyear  = date("Y",$next);
        $nmonth = date("m",$next);
        $nday   = date("d",$next);
    }

    //����1���������������ʥ��������κǽ������
    //$last_day = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1 - date("w", mktime(0, 0, 0, date("m")-1, 1, date("Y"))), date("Y")));
    //ɽ�����֤κǽ�η��1�������뽵�������������ʥ��������κǽ������
    $last_day = date("Y-m-d", mktime(0, 0, 0, date("m") - $back_cal_month, 1 - date("w", mktime(0, 0, 0, date("m") - $back_cal_month, 1, date("Y"))), date("Y")));
    
    //����κǽ�ν���
    $check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day-7,$year));

    if($check_day < $last_day){
        //�轵�ܥ������ɽ���ˤ���
        $bw_disabled_flg = true;
    }


    //�������轵���θ��������ͽ����������
    $back_data["form_sale_day"]["y"] = $year;
    $back_data["form_sale_day"]["m"] = $month;
    $back_data["form_sale_day"]["d"] = $day;

    //�������轵���θ�������򥻥å����˵ͤ�ľ��
    $_SESSION[$module_no]["all"]["form_sale_day"]["y"] = $year;
    $_SESSION[$module_no]["all"]["form_sale_day"]["m"] = $month;
    $_SESSION[$module_no]["all"]["form_sale_day"]["d"] = $day;

    //�ե饰�򥯥ꥢ
    $back_data["back_w_button_flg"] = "";
    $form->setConstants($back_data);
}

/****************************/
//�������⽵�ܥ��󲡲�����
/****************************/
if($_POST["next_w_button_flg"] == true){

    //�⽵Ƚ��
    if($_POST["next_w_button_flg"] == true){
        //�⽵�����ռ���
        $str = mktime(0, 0, 0, $month,$day+7,$year);
    }else{
        //���������ռ���
        $str = mktime(0, 0, 0, $month,$day+1,$year);
    }

    $year  = date("Y",$str);
    $month = date("m",$str);
    $day   = date("d",$str);

    //��������ɽ������ʬ����ɽ�������ʤ���Ƚ��
    $max_day = date("t",mktime(0, 0, 0, date("m")+$cal_peri,1,date("Y")));
    $fast_day = date("Y-m-d", mktime(0, 0, 0, date("m")+$cal_peri,$max_day,date("Y")));

    //���κǽ�ν���
    $check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day+7,$year));
    if($check_day > $fast_day){
        //�⽵�ܥ������ɽ���ˤ���
        $nw_disabled_flg = true;

        //�����ޤǤ����ռ���
        $nyear = substr($fast_day,0,4);
        $nmonth = substr($fast_day,5,2);
        $nday = substr($fast_day,8,2);
    }else{
        //�콵�ָ�����ռ���
        $next = mktime(0, 0, 0, $month,$day+6,$year);
        $nyear  = date("Y",$next);
        $nmonth = date("m",$next);
        $nday   = date("d",$next);
    }


    //�������⽵���θ��������ͽ����������
    $next_data["form_sale_day"]["y"] = $year;
    $next_data["form_sale_day"]["m"] = $month;
    $next_data["form_sale_day"]["d"] = $day;

    //�������⽵���θ�������򥻥å����˵ͤ�ľ��
    $_SESSION[$module_no]["all"]["form_sale_day"]["y"] = $year;
    $_SESSION[$module_no]["all"]["form_sale_day"]["m"] = $month;
    $_SESSION[$module_no]["all"]["form_sale_day"]["d"] = $day;

    //�ե饰�򥯥ꥢ
    //$next_data["next_d_button_flg"] = "";
    $next_data["next_w_button_flg"] = "";
    $form->setConstants($next_data);

}

/****************************/
//���ɽ��
/****************************/
$def_fdata = array(
    //"form_output"     => "1",
    "form_sale_day" => array(
        "y" => date("Y"),
        "m" => date("m"),
        "d" => date("d"),
    ),
);
$form->setDefaults($def_fdata);

/****************************/
//�ե��������
/****************************/

//ô����
$select_value = NULL;
//$select_value = Select_Get($db_con, "round_staff_ms");
$select_value = Select_Get($db_con, "round_staff_m");
$form->addElement('select', 'form_staff_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//����
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

// FC�Υ���å�
$select_value = NULL;
$select_value = Select_Get($db_con, "calshop");
$form->addElement('select', 'form_fc', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//ɽ���ܥ���
$form->addElement("submit","indicate_button","ɽ����", null);

//���ꥢ�ܥ���
$form->addElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//��ɼ����
$form->addElement("button","form_slip_button","��ɼ����","onClick=\"javascript:Referer('2-2-201.php')\"");

//�إå���ɽ������ܥ���
$form->addElement("button","week_button","������",$g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","month_button","���","onClick=\"location.href='2-2-101-2.php'\"");


$form->addElement("hidden", "back_w_button_flg");     //�轵�ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_w_button_flg");     //�⽵�ܥ��󲡲�Ƚ��
$form->addElement("hidden", "next_d_count");          //�������鲿����
$form->addElement("hidden", "back_d_count");          //�������鲿����

//ͽ����
$text = NULL;
$text[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[y]', 'form_sale_day[m]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[y]','form_sale_day[m]','form_sale_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
        "text","m","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[m]', 'form_sale_day[d]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[y]','form_sale_day[m]','form_sale_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
        "text","d","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[y]','form_sale_day[m]','form_sale_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$form->addGroup( $text,"form_sale_day","form_sale_day");


/****************************/
// �ե�����ǡ����򥻥å�����
/****************************/
// ɽ���ܥ������շϥܥ��󲡲�����ͽ��ǡ������٤���뤬��������Ƥ��ʤ����ĥ��顼��̵����
if (($_POST["indicate_button"] != null ||
     $_POST["next_w_button_flg"] != null ||
     $_POST["back_w_button_flg"] != null )
    && $error_flg != true){

    // POST�ǡ�����SESSION�˥��å�
    $_SESSION[$module_no]["next_w_button_flg"]  = $_POST["next_w_button_flg"];
    $_SESSION[$module_no]["back_w_button_flg"]  = $_POST["back_w_button_flg"];
    $_SESSION[$module_no]["form_sale_day"]["y"] = $_POST["form_sale_day"]["y"];
    $_SESSION[$module_no]["form_sale_day"]["m"] = $_POST["form_sale_day"]["m"];
    $_SESSION[$module_no]["form_sale_day"]["d"] = $_POST["form_sale_day"]["d"];

}


//���ô���Լ�������
$aorder_staff = array(1=>"0",2=>"1",3=>"2",4=>"3");

//���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
if($error_flg == false && $_POST != null){

    //�����褬���ꤷ�Ƥ��ʤ������̾���ɼɽ��
    if($post_fc_id == NULL){
        /****************************/
        //�Ȳ�ǡ��������ʷ����ʬ���̾��
        /****************************/
        for($i=1;$i<=4;$i++){

            //ô���ԡʥᥤ���Ƚ��
            if($i!=1){
                //�ᥤ��ʳ���UNION�Ƿ��
                $sql .= "UNION \n";
                $sql .= "SELECT \n";
            }else{
                //�ᥤ��
                $sql  = "SELECT \n";
            }

            //������
            $sql .= "    t_part.part_name, \n";             //����̾0
            $sql .= "    t_staff$i.staff_name, \n";         //�����å�̾1
            $sql .= "    t_aorder_h.net_amount, \n";        //�����2
            $sql .= "    t_aorder_h.ord_time, \n";          //������3
            $sql .= "    t_aorder_h.route, \n";             //��ϩ4
            $sql .= "    t_aorder_h.client_cname, \n";      //������̾5
            $sql .= "    t_aorder_h.aord_id, \n";           //����ID6
            $sql .= "    NULL, \n";                         //�����ɼ�ե饰7
            $sql .= "    t_aorder_h.del_flg, \n";   //��α��ɼ����ե饰8
            $sql .= "    NULL, \n";                         //�����ե饰9
            $sql .= "    t_staff$i.staff_cd1, \n";          //�����åե�����1 10
            $sql .= "    t_staff$i.staff_cd2, \n";          //�����åե�����2 11
            $sql .= "    CASE \n";                          //����ID12
            $sql .= "    WHEN t_part.part_id IS NULL THEN 0 \n";
            $sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id \n";
            $sql .= "    END, \n";
            $sql .= "    t_aorder_h.reason, \n";            //��α��ͳ13
            $sql .= "    t_aorder_h.confirm_flg, \n";       //������ɼ14
            $sql .= "    t_aorder_h.client_id, \n";         //������ID15
            $sql .= "    t_staff$i.charge_cd, \n";          //ô���ԥ�����16
            $sql .= "    t_aorder_h.client_cd1, \n";        //�����襳����1 17
            $sql .= "    t_aorder_h.client_cd2, \n";        //�����襳����2 18
            $sql .= "    t_staff$i.staff_id, \n";           //�����å�ID19
            $sql .= "    t_aorder_h.tax_amount, \n";        //�����ǳ� 20
            $sql .= "    t_staff$i.sale_rate, \n";          //���Ψ 21
            $sql .= "    t_part.part_cd, \n";               //����̾CD 22
            $sql .= "    t_staff_count.num, \n";            //��ɼ�Ϳ� 23
            $sql .= "    t_aorder_h.act_id \n";             //�����ID 24

            $sql .= "FROM \n";
            $sql .= "    t_aorder_h \n";

            $sql .= "    INNER JOIN ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            aord_id,\n";
            $sql .= "            count(aord_id)AS num \n";
            $sql .= "        FROM \n";
            $sql .= "            t_aorder_staff \n";
            $sql .= "        WHERE \n";
            $sql .= "            sale_rate IS NOT NULL \n";
            $sql .= "        GROUP BY \n";
            $sql .= "            aord_id \n";
            $sql .= "    )AS t_staff_count ON t_staff_count.aord_id = t_aorder_h.aord_id \n";

            $sql .= "    INNER JOIN \n";
            $sql .= "        (SELECT \n";
            $sql .= "             t_aorder_staff.aord_id, \n";
            $sql .= "             t_staff.staff_id, \n";
            $sql .= "             t_aorder_staff.staff_name, \n";
            $sql .= "             t_staff.staff_cd1, \n";
            $sql .= "             t_staff.staff_cd2, \n";
            $sql .= "             t_staff.charge_cd, \n";
            $sql .= "             t_aorder_staff.sale_rate \n";
            $sql .= "         FROM \n";
            $sql .= "             t_aorder_staff  \n";
            $sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
            $sql .= "         WHERE \n";
            $sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."' \n";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-007��������suzuki-t�������Ψ��0%��ô���Ԥ�ɽ��
 *
            $sql .= "         AND  \n";
            $sql .= "             t_aorder_staff.sale_rate != '0'  \n";
*/
            $sql .= "         AND \n";
            $sql .= "             t_aorder_staff.sale_rate IS NOT NULL \n";
            $sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id \n";

            $sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id \n";

            $sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id \n";

            $sql .= "WHERE \n";

            if($_SESSION["group_kind"] == '2'){
                $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
            }else{
                $sql .= "    t_aorder_h.shop_id = $client_id \n";
            }
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-008��������suzuki-t����������μ�����֤˴ط��ʤ�ɽ��
 *
            $sql .= "    AND ";
            $sql .= "    t_client.state = '1' ";
*/
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.ps_stat != '4' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.confirm_flg = 'f' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.contract_div = '1' \n";
            $sql .= "    AND \n";
            $sql .= "    t_attach.h_staff_flg = 'false' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.del_flg = 'f' \n";

            //�������Ƚ��
            if($post_part_id != NULL){
                $sql .= "    AND \n";
                $sql .= "    t_part.part_id = $post_part_id \n";
            }
            //ô���Ի���Ƚ��
            if($post_staff_id != NULL){
                $sql .= "    AND \n";
                $sql .= "    t_staff$i.staff_id = $post_staff_id \n";
            }

            $sql .= "UNION \n";

            //�����
            $sql .= "SELECT \n";
            $sql .= "    t_part.part_name, \n";             //����̾0
            $sql .= "    t_staff$i.staff_name, \n";         //�����å�̾1
            $sql .= "    t_sale_h.net_amount, \n";          //�����2
            $sql .= "    t_sale_h.sale_day, \n";            //�����3
            $sql .= "    t_aorder_h.route, \n";             //��ϩ4
            $sql .= "    t_sale_h.client_cname, \n";        //������̾5
            $sql .= "    t_sale_h.aord_id, \n";             //����ID6
            $sql .= "    NULL, \n";                         //�����ɼ�ե饰7
            $sql .= "    t_aorder_h.del_flg, \n";   //��α��ɼ����ե饰8
            $sql .= "    NULL, \n";                         //�����ե饰9
            $sql .= "    t_staff$i.staff_cd1, \n";          //�����åե�����1 10
            $sql .= "    t_staff$i.staff_cd2, \n";          //�����åե�����2 11
            $sql .= "    CASE \n";                          //����ID12
            $sql .= "    WHEN t_part.part_id IS NULL THEN 0 \n";
            $sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id \n";
            $sql .= "    END, \n";
            $sql .= "    t_aorder_h.reason, \n";            //��α��ͳ13
            $sql .= "    t_aorder_h.confirm_flg, \n";       //������ɼ14
            $sql .= "    t_sale_h.client_id, \n";           //������ID15
            $sql .= "    t_staff$i.charge_cd, \n";          //ô���ԥ�����16
            $sql .= "    t_sale_h.client_cd1, \n";          //�����襳����1 17
            $sql .= "    t_sale_h.client_cd2, \n";          //�����襳����2 18
            $sql .= "    t_staff$i.staff_id, \n";           //�����å�ID19
            $sql .= "    t_sale_h.tax_amount, \n";          //�����ǳ� 20
            $sql .= "    t_staff$i.sale_rate, \n";          //���Ψ 21
            $sql .= "    t_part.part_cd, \n";               //����̾CD 22
            $sql .= "    t_staff_count.num, \n";            //��ɼ�Ϳ� 23
            $sql .= "    t_aorder_h.act_id \n";             //�����ID 24
               
            $sql .= "FROM \n";
            $sql .= "    t_sale_h \n";

            $sql .= "    INNER JOIN ( \n";
            $sql .= "        SELECT \n";
            $sql .= "            sale_id, \n";
            $sql .= "            count(sale_id)AS num \n";
            $sql .= "        FROM \n";
            $sql .= "            t_sale_staff \n";
            $sql .= "        WHERE \n";
            $sql .= "            sale_rate IS NOT NULL \n";
            $sql .= "        GROUP BY \n";
            $sql .= "            sale_id \n";
            $sql .= "    )AS t_staff_count ON t_staff_count.sale_id = t_sale_h.sale_id  \n";

            $sql .= "    INNER JOIN \n";
            $sql .= "        (SELECT \n";
            $sql .= "             t_sale_staff.sale_id, \n";
            $sql .= "             t_staff.staff_id, \n";
            $sql .= "             t_sale_staff.staff_name, \n";
            $sql .= "             t_staff.staff_cd1, \n";
            $sql .= "             t_staff.staff_cd2, \n";
            $sql .= "             t_staff.charge_cd, \n";
            $sql .= "             t_sale_staff.sale_rate \n";
            $sql .= "         FROM \n";
            $sql .= "             t_sale_staff \n";
            $sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_sale_staff.staff_id \n";
            $sql .= "         WHERE \n";
            $sql .= "             t_sale_staff.staff_div = '".$aorder_staff[$i]."' \n";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-007��������suzuki-t�������Ψ��0%��ô���Ԥ�ɽ��
 *
            $sql .= "         AND  \n";
            $sql .= "             t_sale_staff.sale_rate != '0'  \n";
*/
            $sql .= "         AND \n";
            $sql .= "             t_sale_staff.sale_rate IS NOT NULL \n";
            $sql .= "        )AS t_staff$i ON t_staff$i.sale_id = t_sale_h.sale_id \n";

            $sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id \n";
            $sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id \n";

            $sql .= "    INNER JOIN  t_aorder_h ON t_aorder_h.aord_id = t_sale_h.aord_id \n";

            $sql .= "WHERE \n";
            if($_SESSION["group_kind"] == '2'){
                $sql .= "    t_sale_h.shop_id IN (".Rank_Sql().") \n";
            }else{
                $sql .= "    t_sale_h.shop_id = $client_id \n";
            }
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-008��������suzuki-t����������μ�����֤˴ط��ʤ�ɽ��
 *
            $sql .= "    AND  \n";
            $sql .= "    t_client.state = '1'  \n";
*/
            $sql .= "    AND \n";
            $sql .= "    t_attach.h_staff_flg = 'false' \n";
            $sql .= "    AND \n";
            $sql .= "    t_sale_h.act_request_flg = 'f' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.confirm_flg = 't' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.contract_div = '1' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
            $sql .= "    AND \n";
            $sql .= "    t_aorder_h.del_flg = 'f' \n";

            //�������Ƚ��
            if($post_part_id != NULL){
                $sql .= "    AND \n";
                $sql .= "    t_part.part_id = $post_part_id \n";
            }
            //ô���Ի���Ƚ��
            if($post_staff_id != NULL){
                $sql .= "    AND \n";
                $sql .= "    t_staff$i.staff_id = $post_staff_id \n";
            }

            //FC�ξ��ϡ���ԤΥ��������Ϸ�礷��ɽ��
            if($_SESSION["group_kind"] == '3'){
                $sql .= "UNION \n";

                //������
                $sql .= "SELECT \n";
                $sql .= "    t_part.part_name, \n";             //����̾0
                $sql .= "    t_staff$i.staff_name, \n";         //�����å�̾1
                $sql .= "    t_aorder_h.net_amount, \n";        //�����2
                $sql .= "    t_aorder_h.ord_time, \n";          //������3
                $sql .= "    t_aorder_h.route, \n";             //��ϩ4
                $sql .= "    t_aorder_h.client_cname, \n";      //������̾5
                $sql .= "    t_aorder_h.aord_id, \n";           //����ID6
                $sql .= "    NULL, \n";                         //�����ɼ�ե饰7
                $sql .= "    t_aorder_h.del_flg, \n";   //��α��ɼ����ե饰8
                $sql .= "    NULL, \n";                         //�����ե饰9
                $sql .= "    t_staff$i.staff_cd1, \n";          //�����åե�����1 10
                $sql .= "    t_staff$i.staff_cd2, \n";          //�����åե�����2 11
                $sql .= "    CASE \n";                          //����ID12
                $sql .= "    WHEN t_part.part_id IS NULL THEN 0 \n";
                $sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id \n";
                $sql .= "    END, \n";
                $sql .= "    t_aorder_h.reason, \n";            //��α��ͳ13
                $sql .= "    t_aorder_h.confirm_flg, \n";       //������ɼ14
                $sql .= "    t_aorder_h.client_id, \n";         //������ID15
                $sql .= "    t_staff$i.charge_cd, \n";          //ô���ԥ�����16
                $sql .= "    t_aorder_h.client_cd1, \n";        //�����襳����1 17
                $sql .= "    t_aorder_h.client_cd2, \n";        //�����襳����2 18
                $sql .= "    t_staff$i.staff_id, \n";           //�����å�ID19
                $sql .= "    t_aorder_h.tax_amount, \n";        //�����ǳ� 20
                $sql .= "    t_staff$i.sale_rate, \n";          //���Ψ 21
                $sql .= "    t_part.part_cd, \n";               //����̾CD 22
                $sql .= "    NULL, \n";                         //��ɼ�Ϳ� 23
                $sql .= "    t_aorder_h.act_id \n";             //�����ID 24

                $sql .= "FROM \n";
                $sql .= "    t_aorder_h \n";

                $sql .= "    INNER JOIN \n";
                $sql .= "        (SELECT \n";
                $sql .= "             t_aorder_staff.aord_id, \n";
                $sql .= "             t_staff.staff_id, \n";
                $sql .= "             t_aorder_staff.staff_name, \n";
                $sql .= "             t_staff.staff_cd1, \n";
                $sql .= "             t_staff.staff_cd2, \n";
                $sql .= "             t_staff.charge_cd, \n";
                $sql .= "             t_aorder_staff.sale_rate \n";
                $sql .= "         FROM \n";
                $sql .= "             t_aorder_staff \n";
                $sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
                $sql .= "         WHERE \n";
                $sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."' \n";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-007��������suzuki-t�������Ψ��0%��ô���Ԥ�ɽ��
 *
                $sql .= "         AND  \n";
                $sql .= "             t_aorder_staff.sale_rate != '0'  \n";
*/
                $sql .= "         AND \n";
                $sql .= "             t_aorder_staff.sale_rate IS NOT NULL \n";
                $sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id \n";

                $sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

                $sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id \n";

                $sql .= "WHERE \n";

                $sql .= "    t_aorder_h.act_id = $client_id \n";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-010��������suzuki-t���������μ�����֤˴ط��ʤ�ɽ��
 *              
                $sql .= "    AND  \n";
                $sql .= "    t_client.state = '1'  \n";
*/
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.ps_stat != '4' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.confirm_flg = 'f' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.contract_div = '2' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.del_flg = 'f' \n";

                //�������Ƚ��
                if($post_part_id != NULL){
                    $sql .= "    AND \n";
                    $sql .= "    t_part.part_id = $post_part_id \n";
                }
                //ô���Ի���Ƚ��
                if($post_staff_id != NULL){
                    $sql .= "    AND \n";
                    $sql .= "    t_staff$i.staff_id = $post_staff_id \n";
                }

                $sql .= "UNION \n";

                //�����
                $sql .= "SELECT ";
                $sql .= "    t_part.part_name, \n";             //����̾0
                $sql .= "    t_staff$i.staff_name, \n";         //�����å�̾1
                $sql .= "    t_sale_h.net_amount, \n";          //�����2
                $sql .= "    t_sale_h.sale_day, \n";            //�����3
                $sql .= "    t_aorder_h.route, \n";             //��ϩ4
                $sql .= "    t_sale_h.client_cname, \n";        //������̾5
                $sql .= "    t_sale_h.aord_id, \n";             //����ID6
                $sql .= "    NULL, \n";                         //�����ɼ�ե饰7
                $sql .= "    t_aorder_h.del_flg, \n";   //��α��ɼ����ե饰8
                $sql .= "    NULL, \n";                         //�����ե饰9
                $sql .= "    t_staff$i.staff_cd1, \n";          //�����åե�����1 10
                $sql .= "    t_staff$i.staff_cd2, \n";          //�����åե�����2 11
                $sql .= "    CASE \n";                          //����ID12
                $sql .= "    WHEN t_part.part_id IS NULL THEN 0 \n";
                $sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id \n";
                $sql .= "    END, \n";
                $sql .= "    t_aorder_h.reason, \n";            //��α��ͳ13
                $sql .= "    t_aorder_h.confirm_flg, \n";       //������ɼ14
                $sql .= "    t_sale_h.client_id, \n";           //������ID15
                $sql .= "    t_staff$i.charge_cd, \n";          //ô���ԥ�����16
                $sql .= "    t_sale_h.client_cd1, \n";          //�����襳����1 17
                $sql .= "    t_sale_h.client_cd2, \n";          //�����襳����2 18
                $sql .= "    t_staff$i.staff_id, \n";           //�����å�ID19
                $sql .= "    t_sale_h.tax_amount, \n";          //�����ǳ� 20
                $sql .= "    t_staff$i.sale_rate, \n";          //���Ψ 21
                $sql .= "    t_part.part_cd, \n";               //����̾CD 22
                $sql .= "    NULL, \n";                         //��ɼ�Ϳ� 23
                $sql .= "    t_aorder_h.act_id \n";             //�����ID 24
                   
                $sql .= "FROM \n";
                $sql .= "    t_sale_h \n";

                $sql .= "    INNER JOIN \n";
                $sql .= "        (SELECT \n";
                $sql .= "             t_sale_staff.sale_id, \n";
                $sql .= "             t_staff.staff_id, \n";
                $sql .= "             t_sale_staff.staff_name, \n";
                $sql .= "             t_staff.staff_cd1, \n";
                $sql .= "             t_staff.staff_cd2, \n";
                $sql .= "             t_staff.charge_cd, \n";
                $sql .= "             t_sale_staff.sale_rate \n";
                $sql .= "         FROM \n";
                $sql .= "             t_sale_staff \n";
                $sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_sale_staff.staff_id \n";
                $sql .= "         WHERE \n";
                $sql .= "             t_sale_staff.staff_div = '".$aorder_staff[$i]."' \n";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-007��������suzuki-t�������Ψ��0%��ô���Ԥ�ɽ��
 *
                $sql .= "         AND  \n";
                $sql .= "             t_sale_staff.sale_rate != '0'  \n";
*/
                $sql .= "         AND \n";
                $sql .= "             t_sale_staff.sale_rate IS NOT NULL \n";
                $sql .= "        )AS t_staff$i ON t_staff$i.sale_id = t_sale_h.sale_id \n";

                $sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

                $sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id \n";

                $sql .= "    INNER JOIN  t_aorder_h ON t_aorder_h.aord_id = t_sale_h.aord_id \n";

                $sql .= "WHERE \n";

                $sql .= "    t_aorder_h.act_id = $client_id \n";
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-010��������suzuki-t���������μ�����֤˴ط��ʤ�ɽ��
 *          
                $sql .= "    AND  \n";
                $sql .= "    t_client.state = '1'  \n";
*/
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.contract_div = '2' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.confirm_flg = 't' \n";
                $sql .= "    AND \n";
                $sql .= "    t_sale_h.act_request_flg = 'f' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
                $sql .= "    AND \n";
                $sql .= "    t_aorder_h.del_flg = 'f' \n";

                //�������Ƚ��
                if($post_part_id != NULL){
                    $sql .= "    AND \n";
                    $sql .= "    t_part.part_id = $post_part_id \n";
                }
                //ô���Ի���Ƚ��
                if($post_staff_id != NULL){
                    $sql .= "    AND \n";
                    $sql .= "    t_staff$i.staff_id = $post_staff_id \n";
                }
            }
        }
        $sql .= "ORDER BY \n";
        $sql .= "    23, \n";   //����̾CD
        $sql .= "    17, \n";   //ô���ԥ�����
        $sql .= "    4, \n";    //������
        $sql .= "    18, \n";   //�����襳����1
        $sql .= "    19, \n";   //�����襳����2
        $sql .= "    7 \n";     //����ID
        $sql .= ";";
//print_array($sql);

        $result = Db_Query($db_con, $sql);

        //������θ������ˤ��̾���ɼ��ɽ��
        if($post_fc_id == NULL){
            $data_list = Get_Data($result);
        }

        /****************************/
        //�����إå����ˤ�����ô���ԤΥǡ�����ô��������˾�񤭤���
        /****************************/
        $n_data_list = NULL;
        $staff_data_flg = false;  //�����ǡ���¸�ߥե饰Ƚ��
        for($x=0;$x<count($data_list);$x++){
            $ymd = $data_list[$x][3];          //�����
            $part_id = $data_list[$x][12];     //����ID
            $staff_id = $data_list[$x][19];    //�����å�ID

            //Ϣ���������Ͽ���롣
            $n_data_list[$part_id][$staff_id][$ymd][] = $data_list[$x];

            $data_list2[$part_id][0][0] = $data_list[$x][0];    //����̾
            //$data_list2[$part_id][0][1]++;                          //ͽ����

            //ͽ���� (�����+�����ǳ�)�����Ψ
            $money1 = $data_list[$x][2] + $data_list[$x][20];
            $money2 = $data_list[$x][21] / 100;

            #2010-05-13 hashimoto-y
            #echo "���Ψ:" .$data_list[$x][21];

            #2010-05-13 hashimoto-y
            //���ΨȽ��
            #if($money2 != 0){
            if($staff_id != null){
                //���Ψ����׻�
                $total1 = bcmul($money1,$money2,2);
                //������δݤ��ʬ����������ݤ����
                $sql  = "SELECT";
                $sql .= "   t_client.coax ";
                $sql .= " FROM";
                $sql .= "   t_client ";
                $sql .= " WHERE";
                $sql .= "   t_client.client_id = ".$data_list[$x][15];
                $sql .= ";";
                $result = Db_Query($db_con, $sql); 
                $client_list = Get_Data($result,2);

                $coax            = $client_list[0][0];        //�ݤ��ʬ�ʾ��ʡ�
                $total1 = Coax_Col($coax,$total1);
            }else{
                //���ե饤����Ԥξ��ϡ����Ψ��̵���پ軻���ʤ�
                $total1 = $money1;
            }
            $data_list2[$part_id][0][2] = bcadd($total1,$data_list2[$part_id][0][2]);

            //�����ǡ�����¸�ߤ���
            $staff_data_flg = true;
        }

        //�����ǡ�����¸�ߤ������ˤ���ô���ԥǡ����򥫥���������˾��
        if($staff_data_flg == true){

            //���ͷ����ѹ�
            while($money_num = each($data_list2)){
                $money = $money_num[0];
                //ͽ�����ڼΤ�
                $data_list2[$money][0][2] = floor($data_list2[$money][0][2]);
                $data_list2[$money][0][2] = number_format($data_list2[$money][0][2]);
            }
            //��ɸ��ꥻ�åȤ���
            reset($data_list2);

            /****************************/
            //���������ơ��֥��������
            /****************************/

            //��������HTML
            $calendar   = NULL;
            $date_num_y = NULL;
            $date_num_m = NULL;
            $date_num_d = NULL;

            //ABCD����ɽ���ǡ�������
            for($ab=0;$ab<7;$ab++){
                //����������������������
                $next = mktime(0, 0, 0, $month,$day+$ab,$year);
                $cnyear     = date("Y",$next); //ǯ
                $cnmonth    = date("m",$next); //��
                $cnday      = date("d",$next); //��
                $week[$ab]  = date("w",$next); //����

                $date_num_y[] = $cnyear;       //�콵�֤�ǯ����
                $date_num_m[] = $cnmonth;      //�콵�֤η�����
                $date_num_d[] = $cnday;        //�콵�֤�������

                //ABCDȽ�̴ؿ�
                //��κǽ��������������������
                $base_date = Basic_date($day_by,$day_bm,$day_bd,$cnyear,$cnmonth,$cnday);
                $row = $base_date[0];
                //��������������դξ��ϡ���������
                if($row == NULL){
                    $row = 0;
                }
                $abcd[$ab] = $row;
            }

            //ABCD����ɽ������
            $abcd_w[1] = "A";
            $abcd_w[2] = "B";
            $abcd_w[3] = "C";
            $abcd_w[4] = "D";

            //ABCD���η�������
            $rowspan = array_count_values($abcd);

            /****************************/
            //���������ơ��֥��񤭽���
            /****************************/
            //���𤴤Ȥ˽��ǡ�������
            while($part_num = each($n_data_list)){
                //�����ź������
                $part = $part_num[0];

                //�轵�ܥ���
                //��ɽ��Ƚ��
                if($bw_disabled_flg == true){
                    //��ɽ��
                    $form->addElement("button","back_w_button[$part]","<<���轵","disabled");
                }else{
                    //ɽ��
                    $form->addElement("button","back_w_button[$part]","<<���轵","onClick=\"javascript:Button_Submit('back_w_button_flg','".$_SERVER["PHP_SELF"]."#$part','true')\"");
                }

                //�⽵�ܥ���
                //��ɽ��Ƚ��
                if($nw_disabled_flg == true){
                    //��ɽ��
                    $form->addElement("button","next_w_button[$part]","�⽵��>>","disabled");
                }else{
                    //ɽ��
                    $form->addElement("button","next_w_button[$part]","�⽵��>>",
                        "onClick=\"javascript:Button_Submit('next_w_button_flg','".$_SERVER["PHP_SELF"]."#$part','true')\""
                    );
                }


                /****************************/
                //���ô����
                /****************************/
                //�����°���륹���åդ���������ɽ��
                if($n_data_list[$part] != NULL){
                    //ô���Ԥ��Ȥ˽��ǡ�������
                    while($staff_num = each($n_data_list[$part])){
                        //ô����ID
                        $staff_id = $staff_num[0];

                        /****************************/
                        //ABCD��HTML
                        /****************************/
                        $calendar[$part]  = "<tr height=\"40\">";
                        $calendar[$part] .= "  <td align=\"center\" bgcolor=\"#cccccc\" width=\"60\"><b>�����</b></td>";
                        //ABCD������
                        while($abcd_num = each($rowspan)){
                            //ABCD��ź������
                            $ab_num = $abcd_num[0];
                            $calendar[$part] .= "  <td align=\"center\" bgcolor=\"#e5e5e5\" colspan=\"".$rowspan[$ab_num]."\" style=\"font-size: 130%; font-weight: bold; padding: 0px;\">".$abcd_w[$ab_num]."</td>";
                        }
                        $calendar[$part] .= "</tr>";
                        //��ɸ��ꥻ�åȤ���
                        reset($rowspan);

                        /****************************/
                        //����HTML
                        /****************************/
                        //��������
                        $week_w[0] = "��";
                        $week_w[1] = "��";
                        $week_w[2] = "��";
                        $week_w[3] = "��";
                        $week_w[4] = "��";
                        $week_w[5] = "��";
                        $week_w[6] = "��";

                        $calendar[$part]  .= "<tr height=\"20\">";
                        $calendar[$part]  .= "  <td align=\"center\" bgcolor=\"#cccccc\" rowspan=\"2\" width=\"80\"><b>���ô����</b></td>";
                        //�콵��ʬɽ��
                        for($w=0;$w<7;$w++){
                            //����Ƚ��
                            if($week[$w] == 6 && $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] != 1){
                                //���ˤ��ĵ����ǤϤʤ�
                                $calendar[$part] .= "       <td width=\"135px\" align=\"center\" bgcolor=\"#66CCFF\"><b>";
                            }else if($week[$w] == 0 || $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] == 1){
                                //����or����
                                $calendar[$part] .= "       <td width=\"135px\" align=\"center\" bgcolor=\"#FFBBC3\"><b>";
                            }else{
                                //�����
                                $calendar[$part] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
                            }
                            $calendar[$part] .= $week_w[$week[$w]]."</b></td>";
                        }
                        $calendar[$part] .= "</tr>";

                        //ô����̾
                        $num1 = each($n_data_list[$part][$staff_id]);
                        $num2 = each($n_data_list[$part][$staff_id][$num1[0]]);
                        $staff_name = $n_data_list[$part][$staff_id][$num1[0]][$num2[0]][1];
                        $calendar2[$part][$staff_id]  = "<tr>";
                        $calendar2[$part][$staff_id]  .= "<td width=\"80px\" align=\"center\" valign=\"center\" bgcolor=\"#E5E5E5\" >";
                        $calendar2[$part][$staff_id]  .= "<font size=\"2\">$staff_name</font></td>";

                        //�콵��ʬɽ��
                        for($d=0;$d<7;$d++){
                            //����Ƚ��
                            if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
                                //���ˤ��ĵ����ǤϤʤ�
                                $calendar2[$part][$staff_id] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" class=\"cal3\" width=\"13%\">";
                            }else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
                                //����or����
                                $calendar2[$part][$staff_id] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" class=\"cal3\" width=\"13%\">";
                            }else{
                                //�����
                                $calendar2[$part][$staff_id] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" class=\"cal3\" width=\"13%\">";
                            }
                            //�ǡ���¸��Ƚ��
                            $date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];

                                //��ϩ��������ɽ��

                                //�������˽��ǡ�����ʣ��¸�ߤ�����硢���η��ʬɽ��
                                $calendar_tmp = array();
                                $client_cname_tmp = array();
                                $link_color = null;
                                for($y=0;$y<count($n_data_list[$part][$staff_id][$date]);$y++){
                                    //�������˽��ǡ�����¸�ߤ��뤫Ƚ��
                                    if($n_data_list[$part][$staff_id][$date][$y][6] != NULL){

                                        //�ǡ�����¸�ߤ����١����������󥯤ˤ���
                                        $link_data[$part][$d] = true;

                                        //ͽ�����٤��Ϥ�����ID�������
                                        $aord_id_array[$part][$date][] = $n_data_list[$part][$staff_id][$date][$y][6];

                                        //�����褴�ȤˤޤȤ��
                                        // [������ID][] = ����ID �Ȥ����������
                                        $client_id_tmp = $n_data_list[$part][$staff_id][$date][$y][15];     //������ID
                                        $calendar_tmp[$client_id_tmp][] = $n_data_list[$part][$staff_id][$date][$y][6];     //����ID��ͤ������
                                        $client_cname_tmp[$client_id_tmp] = $n_data_list[$part][$staff_id][$date][$y][5];   //������̾(ά��)��ͤ������
                                        //��󥯤ο���ͤ������
                                        $link_color[$client_id_tmp] = L_Link_Color($link_color[$client_id_tmp], $n_data_list[$part][$staff_id][$date][$y][14], $n_data_list[$part][$staff_id][$date][$y][24], $n_data_list[$part][$staff_id][$date][$y][23]);
                                    }
                                }
                                //�����褴�ȤˤޤȤ᤿�ǡ��������󥯤�����
                                foreach($calendar_tmp as $client_id_key => $aord_id_array_value){
                                    //���ꥢ�饤����
                                    $array_id = serialize($aord_id_array_value);
                                    $array_id = urlencode($array_id);

                                    $calendar2[$part][$staff_id] .= " <a href=\"./2-2-106.php?aord_id_array=".$array_id."&back_display=cal_week\"";
                                    $calendar2[$part][$staff_id] .= " style=\"color: ".$link_color[$client_id_key].";\"";
                                    $calendar2[$part][$staff_id] .= ">";
                                    $calendar2[$part][$staff_id] .= $client_cname_tmp[$client_id_key]."</a><br>";

                                    $data_list2[$part][0][1]++;     //ͽ����
                                }
                            //}
                            $calendar2[$part][$staff_id] .= "</font></td>";
                            $course_array = NULL;
                        }
                        $calendar2[$part][$staff_id] .= "</tr>";
                    }

                    /****************************/
                    //����HTML��񤭽���
                    /****************************/
                    $calendar3[$part]  = "<tr height=\"20\" style=\"font-size: 130%; font-weight: bold; \">";
                    //�콵��ʬɽ��
                    for($d=0;$d<7;$d++){
                        //����Ƚ��
                        if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
                            //���ˤ��ĵ����ǤϤʤ�
                            $calendar3[$part] .= "      <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
                        }else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
                            //����or����
                            $calendar3[$part] .= "      <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
                        }else{
                            //�����
                            $calendar3[$part] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
                        }

                        //���ե��Ƚ��
                        if($link_data[$part][$d] == true){

                            //��������
                            $date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];

                            for($p=0;$p<count($aord_id_array[$part][$date]);$p++){
                                $aord_id_array2[] = $aord_id_array[$part][$date][$p];
                            }

                            //��ʣ����
                            $aord_id_array3 = array_unique($aord_id_array2);
                            //�����ͤ�ľ��
                            $aord_id_array2 = array_values($aord_id_array3);

                            //���ꥢ�饤����
                            $array_id = serialize($aord_id_array2);
                            $array_id = urlencode($array_id);

                            //�����١ʥ�󥯡�
                            $calendar3[$part] .= "<a href=\"2-2-106.php?aord_id_array=".$array_id."&back_display=cal_week\" style=\"color: #555555;\">";
                            $calendar3[$part] .= (int)$date_num_d[$d]."</a></b></td>";

                            $aord_id_array2 = null;
                            $aord_id_array3 = null;
                        }else{
                            //�����١ʥ�󥯤ʤ���
                            $calendar3[$part] .= (int)$date_num_d[$d]."</b></td>";
                        }
                    }
                    $calendar3[$part] .= "</tr>";
                }
                $aord_id_array = null;
            }//����롼��
        }
    }

    //�������ˤ���ԥ���������ɽ��
    if($post_part_id == NULL && $_SESSION["group_kind"] != 3 && $post_staff_id == NULL){

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/01��02-004��������suzuki-t����Ʊ������饤����ɼ������ɽ�������Τ���
 *
*/              
        /****************************/
        //�Ȳ�ǡ��������ʷ����ʬ����ԡ�
        /****************************/
        //������
        $sql  = "SELECT  \n";
        $sql .= "    t_aorder_h.act_name, \n";           //������̾0
        $sql .= "    t_aorder_h.act_id, \n";             //������ID1
        $sql .= "    t_aorder_h.act_cd1, \n";            //�����襳����1 2
        $sql .= "    t_aorder_h.act_cd2, \n";            //�����襳����2 3
        $sql .= "    t_aorder_h.net_amount, \n";         //�����4
        $sql .= "    t_aorder_h.ord_time, \n";           //������5
        $sql .= "    t_aorder_h.route, \n";              //��ϩ6
        $sql .= "    t_aorder_h.client_cname, \n";       //������̾7
        $sql .= "    t_aorder_h.aord_id, \n";            //����ID8
        $sql .= "    t_aorder_h.client_id, \n";          //������ID9
        $sql .= "    NULL,  \n";   
        $sql .= "    t_aorder_h.client_cd1, \n";         //�����襳����1 11
        $sql .= "    t_aorder_h.client_cd2, \n";         //�����襳����2 12
        $sql .= "    t_aorder_h.tax_amount, \n";         //�����ǳ� 13
        $sql .= "    NULL,  \n";   
        $sql .= "    t_aorder_h.confirm_flg \n";         //����ե饰 15

        $sql .= "FROM  \n";
        $sql .= "    t_aorder_h  \n";

        $sql .= "WHERE  \n";

        if($_SESSION["group_kind"] == '2'){
            $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
        }else{
            $sql .= "    t_aorder_h.shop_id = $client_id  \n";
        }

        //���������Ƚ��
        if($post_fc_id != NULL){
            $sql .= "    AND  \n";
            $sql .= "    t_aorder_h.act_id = $post_fc_id  \n";
        }
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-008��������suzuki-t����������μ�����֤˴ط��ʤ�ɽ��
 *          
        $sql .= "    AND  \n";
        $sql .= "    t_client.state = '1'  \n";

 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-010��������suzuki-t���������μ�����֤˴ط��ʤ�ɽ��
 *          
        $sql .= "    AND  \n";
        $sql .= "    t_act.state = '1'  \n";
*/
        $sql .= "    AND  \n";
        $sql .= "    t_aorder_h.ps_stat != '4'  \n";
        $sql .= "    AND  \n";
        $sql .= "    t_aorder_h.confirm_flg = 'f'  \n";
        $sql .= "    AND  \n";
        $sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
        $sql .= "    AND \n";
        $sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
        $sql .= "    AND ";
        $sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
        $sql .= "    AND \n";
        $sql .= "    t_aorder_h.del_flg = 'f' \n";

        $sql .= "UNION  \n";

        //�����
        $sql .= "SELECT  \n";
        $sql .= "    t_aorder_h.act_name, \n";           //������̾0
        $sql .= "    t_aorder_h.act_id, \n";             //������ID1
        $sql .= "    t_sale_h.act_cd1, \n";              //�����襳����1 2
        $sql .= "    t_sale_h.act_cd2, \n";              //�����襳����2 3
        $sql .= "    t_sale_h.net_amount, \n";           //�����4
        $sql .= "    t_sale_h.sale_day, \n";             //�����5
        $sql .= "    t_aorder_h.route, \n";              //��ϩ6
        $sql .= "    t_sale_h.client_cname, \n";         //������̾7
        $sql .= "    t_sale_h.aord_id, \n";              //����ID8
        $sql .= "    t_sale_h.client_id,  \n";           //������ID9
        $sql .= "    NULL,  \n";  
        $sql .= "    t_sale_h.client_cd1, \n";           //�����襳����1 11
        $sql .= "    t_sale_h.client_cd2, \n";           //�����襳����2 12
        $sql .= "    t_sale_h.tax_amount, \n";           //�����ǳ� 13
        $sql .= "    NULL,  \n";  
        $sql .= "    t_aorder_h.confirm_flg \n";         //����ե饰 15

        $sql .= "FROM  \n";
        $sql .= "    t_sale_h  \n";
        $sql .= "    INNER JOIN  t_aorder_h ON t_aorder_h.aord_id = t_sale_h.aord_id  \n";

        $sql .= "WHERE  \n";
        if($_SESSION["group_kind"] == '2'){
            $sql .= "    t_sale_h.shop_id IN (".Rank_Sql().") \n";
        }else{
            $sql .= "    t_sale_h.shop_id = $client_id  \n";
        }

        //���������Ƚ��
        if($post_fc_id != NULL){
            $sql .= "    AND  \n";
            $sql .= "    t_aorder_h.act_id = $post_fc_id  \n";
        }
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-008��������suzuki-t����������μ�����֤˴ط��ʤ�ɽ��
 *          
        $sql .= "    AND  \n";
        $sql .= "    t_client.state = '1'  \n";

 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/26��02-010��������suzuki-t���������μ�����֤˴ط��ʤ�ɽ��
 *          
        $sql .= "    AND  \n";
        $sql .= "    t_act.state = '1'  \n";
*/
        $sql .= "    AND  \n";
        $sql .= "    t_aorder_h.confirm_flg = 't'  \n";
        $sql .= "    AND  \n";
        $sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
        $sql .= "    AND \n";
        $sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
        $sql .= "    AND ";
        $sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
        $sql .= "    AND \n";
        $sql .= "    t_aorder_h.del_flg = 'f' \n";

        $sql .= "ORDER BY  \n";
        $sql .= "    3, \n";    //�����襳����1
        $sql .= "    4, \n";    //�����襳����2
        $sql .= "    6, \n";    //������
        $sql .= "    12, \n";   //�����襳����1
        $sql .= "    13, \n";   //�����襳����2
        $sql .= "    9; \n";    //����ID
//print_array($sql);

        $result = Db_Query($db_con, $sql);
        $act_data_list = Get_Data($result);

        /****************************/
        //������HTML����
        /****************************/
        $n_data_list = NULL;
        $act_data_flg = false;  //�����ǡ���¸�ߥե饰Ƚ��
        for($x=0;$x<count($act_data_list);$x++){
            $ymd = $act_data_list[$x][5];          //�����
            $act_id = "daiko".$act_data_list[$x][1];       //������ID

            //Ϣ���������Ͽ���롣
            $n_data_list[$act_id][$ymd][] = $act_data_list[$x];
            
            //ͽ���� (�����+�����ǳ�)�����Ψ
            $money1 = $act_data_list[$x][4] + $act_data_list[$x][13];
            $money2 = $act_data_list[$x][14] / 100;
            //���ΨȽ��
            if($money2 != 0){
                //���Ψ����׻�
                $total1 = bcmul($money1,$money2,2);
            }else{
                //���ե饤����Ԥξ��ϡ����Ψ��̵���پ軻���ʤ�
                $total1 = $money1;
            }
            $act_data_list2[$act_id][0][1] = bcadd($total1,$act_data_list2[$act_id][0][1]);

            //�����ǡ�����¸�ߤ���
            $act_data_flg = true;
        }
//print_array($n_data_list);
        //�����ǡ�����¸�ߤ������ˤ���ô���ԥǡ����򥫥���������˾��
        if($act_data_flg == true){

            //���ͷ����ѹ�
            $money_num = NULL;
            $link_data = NULL;

            while($money_num = each($act_data_list2)){
                $money = $money_num[0];
                //ͽ�����ڼΤ�
                $act_data_list2[$money][0][1] = floor($act_data_list2[$money][0][1]);
                $act_data_list2[$money][0][1] = number_format($act_data_list2[$money][0][1]);
            }
            //��ɸ��ꥻ�åȤ���
            reset($act_data_list2);

            /****************************/
            //���������ơ��֥��������
            /****************************/

            //��������HTML
            $date_num_y = NULL;
            $date_num_m = NULL;
            $date_num_d = NULL;

            //ABCD����ɽ���ǡ�������
            for($ab=0;$ab<7;$ab++){
                //����������������������
                $next = mktime(0, 0, 0, $month,$day+$ab,$year);
                $nyear     = date("Y",$next); //ǯ
                $nmonth    = date("m",$next); //��
                $nday      = date("d",$next); //��
                $week[$ab] = date("w",$next); //����

                $date_num_y[] = $nyear;       //�콵�֤�ǯ����
                $date_num_m[] = $nmonth;      //�콵�֤η�����
                $date_num_d[] = $nday;        //�콵�֤�������

                //ABCDȽ�̴ؿ�
                //��κǽ��������������������
                $base_date = Basic_date($day_by,$day_bm,$day_bd,$nyear,$nmonth,$nday);
                $row = $base_date[0];
                //��������������դξ��ϡ���������
                if($row == NULL){
                    $row = 0;
                }
                $abcd[$ab] = $row;
            }

            //ABCD����ɽ������
            $abcd_w[1] = "A";
            $abcd_w[2] = "B";
            $abcd_w[3] = "C";
            $abcd_w[4] = "D";

            //ABCD���η�������
            $rowspan = array_count_values($abcd);

            /****************************/
            //���������ơ��֥��񤭽���
            /****************************/
            //�����褴�Ȥ˽��ǡ�������
            while($act_num = each($n_data_list)){
                //�������ź������
                $act = $act_num[0];

                //�轵�ܥ���
                //��ɽ��Ƚ��
                if($bw_disabled_flg == true){
                    //��ɽ��
                    $form->addElement("button","back_w_button[$act]","<<���轵","disabled");
                }else{
                    //ɽ��
                    $form->addElement("button","back_w_button[$act]","<<���轵","onClick=\"javascript:Button_Submit('back_w_button_flg','".$_SERVER["PHP_SELF"]."#$act','true')\"");
                }

                //�⽵�ܥ���
                //��ɽ��Ƚ��
                if($nw_disabled_flg == true){
                    //��ɽ��
                    $form->addElement("button","next_w_button[$act]","�⽵��>>","disabled");
                }else{
                    //ɽ��
                    $form->addElement("button","next_w_button[$act]","�⽵��>>",
                        "onClick=\"javascript:Button_Submit('next_w_button_flg','".$_SERVER["PHP_SELF"]."#$act','true')\""
                    );
                }

                /****************************/
                //ABCD��HTML
                /****************************/
                $act_calendar[$act]  = "<tr height=\"40\">";
                $act_calendar[$act] .=  "  <td align=\"center\" bgcolor=\"#cccccc\" width=\"60\"><b>�����</b></td>";
                //ABCD������
                while($abcd_num = each($rowspan)){
                    //ABCD��ź������
                    $ab_num = $abcd_num[0];
                    $act_calendar[$act] .= "  <td align=\"center\" bgcolor=\"#e5e5e5\" colspan=\"".$rowspan[$ab_num]."\" style=\"font-size: 130%; font-weight: bold; padding: 0px;\">".$abcd_w[$ab_num]."</td>";
                }
                $act_calendar[$act] .= "</tr>";
                //��ɸ��ꥻ�åȤ���
                reset($rowspan);

                /****************************/
                //����HTML
                /****************************/
                $act_calendar[$act]  .= "<tr height=\"20\">";
                $act_calendar[$act]  .= "   <td align=\"center\" bgcolor=\"#cccccc\" rowspan=\"2\" width=\"80\"><b>���ô����</b></td>";
                //�콵��ʬɽ��
                for($w=0;$w<7;$w++){
                    //����Ƚ��
                    if($week[$w] == 6 && $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] != 1){
                        //���ˤ��ĵ����ǤϤʤ�
                        $act_calendar[$act] .= "        <td width=\"135px\" align=\"center\" bgcolor=\"#66CCFF\"><b>";
                    }else if($week[$w] == 0 || $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] == 1){
                        //����or����
                        $act_calendar[$act] .= "        <td width=\"135px\" align=\"center\" bgcolor=\"#FFBBC3\"><b>";
                    }else{
                        //�����
                        $act_calendar[$act] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
                    }
                    $act_calendar[$act] .= $week_w[$week[$w]]."</b></td>";
                }
                $act_calendar[$act] .= "</tr>";

                //������̾
                $num1 = each($n_data_list[$act]);
                $num2 = each($n_data_list[$act][$num1[0]]);
                $act_name = $n_data_list[$act][$num1[0]][$num2[0]][0];
                $act_calendar2[$act]  = "<tr>";
                $act_calendar2[$act]  .= "<td width=\"80px\" align=\"center\" valign=\"center\" bgcolor=\"#E5E5E5\" >";
                $act_calendar2[$act]  .= "<font size=\"2\">$act_name</font></td>";

                //�콵��ʬɽ��
                for($d=0;$d<7;$d++){
                    //����Ƚ��
                    if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
                        //���ˤ��ĵ����ǤϤʤ�
                        $act_calendar2[$act] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" class=\"cal3\" width=\"13%\">";
                    }else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
                        //����or����
                        $act_calendar2[$act] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" class=\"cal3\" width=\"13%\">";
                    }else{
                        //�����
                        $act_calendar2[$act] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" class=\"cal3\" width=\"13%\">";
                    }
                    //�ǡ���¸��Ƚ��
                    $date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];

                        //������ɽ��

                        $calendar_tmp = array();
                        $client_cname_tmp = array();
                        $link_color = null;

                        //�������˽��ǡ�����ʣ��¸�ߤ�����硢���η��ʬɽ��
                        for($y=0;$y<count($n_data_list[$act][$date]);$y++){

                            //�������˽��ǡ�����¸�ߤ��뤫Ƚ��
                            if($n_data_list[$act][$date][$y][8] != NULL){

                                //�ǡ�����¸�ߤ����١����������󥯤ˤ���
                                $link_data[$act][$d] = true;

                                /*
                                 * ����
                                 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
                                 * ��2006/11/01��02-035��������suzuki-t��  ���ե�󥯲�������TOP�����ܤ��ʤ��褦�˽���
                                */
                                //ͽ�����٤��Ϥ�����ID�������
                                $aord_id_array[$act][$date][$y] = $n_data_list[$act][$date][$y][8];

                                //�����褴�ȤˤޤȤ��
                                // [������ID][] = ����ID �Ȥ����������
                                $client_id_tmp = $n_data_list[$act][$date][$y][9];      //������ID
                                $calendar_tmp[$client_id_tmp][] = $n_data_list[$act][$date][$y][8];     //����ID��ͤ������
                                $client_cname_tmp[$client_id_tmp] = $n_data_list[$act][$date][$y][7];   //������̾(ά��)��ͤ������
                                //��󥯤ο���ͤ������
                                $link_color[$client_id_tmp] = L_Link_Color($link_color[$client_id_tmp], $n_data_list[$act][$date][$y][15], $n_data_list[$act][$date][$y][1], 1);

                            }
                        }
                        //�����褴�ȤˤޤȤ᤿�ǡ��������󥯤�����
                        foreach($calendar_tmp as $client_id_key => $aord_id_array_value){
                            //���ꥢ�饤����
                            $array_id = serialize($aord_id_array_value);
                            $array_id = urlencode($array_id);

                            $act_calendar2[$act] .= " <a href=\"./2-2-106.php?aord_id_array=".$array_id."&back_display=cal_week\"";
                            $act_calendar2[$act] .= " style=\"color: ".$link_color[$client_id_key].";\"";
                            $act_calendar2[$act] .= ">";
                            $act_calendar2[$act] .= $client_cname_tmp[$client_id_key]."</a><br>";

                            $act_data_list2[$act][0][0]++;   //ͽ����
                        }
                    //}
                    $act_calendar2[$act] .= "</td>";
                }
                $act_calendar2[$act] .= "</tr>";

                /****************************/
                //����HTML��񤭽���
                /****************************/
                $act_calendar3[$act]  = "<tr height=\"20\" style=\"font-size: 130%; font-weight: bold; \">";
                //�콵��ʬɽ��
                for($d=0;$d<7;$d++){
                    //����Ƚ��
                    if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
                        //���ˤ��ĵ����ǤϤʤ�
                        $act_calendar3[$act] .= "       <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
                    }else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
                        //����or����
                        $act_calendar3[$act] .= "       <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
                    }else{
                        //�����
                        $act_calendar3[$act] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
                    }
                    
                    //���ե��Ƚ��
                    if($link_data[$act][$d] == true){

                        //�������μ���ID���Ƥ�ͽ�����٤��Ϥ�
                        $aord_id_array2 = NULL;
                        //��������
                        $date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];

                        for($p=0;$p<count($aord_id_array[$act][$date]);$p++){
                            $aord_id_array2[] = $aord_id_array[$act][$date][$p];
                        }

                        //��ʣ����
                        $aord_id_array3 = array_unique($aord_id_array2);
                        //�����ͤ�ľ��
                        $aord_id_array2 = array_values($aord_id_array3);

                        //���ꥢ�饤����
                        $array_id = serialize($aord_id_array2);
                        $array_id = urlencode($array_id);

                        //�����١ʥ�󥯡�
                        $act_calendar3[$act] .= "<a href=\"2-2-106.php?aord_id_array=".$array_id."&back_display=cal_week\" style=\"color: #555555;\">";
                        $act_calendar3[$act] .= (int)$date_num_d[$d]."</a></b></td>";
                    }else{
                        //�����١ʥ�󥯤ʤ���
                        $act_calendar3[$act] .= (int)$date_num_d[$d]."</b></td>";
                    }
                }

                $aord_id_array = null;

                $act_calendar3[$act] .= "</tr>";
            }
        }
    }

    //�ǡ�����̵�����ϡ���������ʤ��Υܥ������
    if($staff_data_flg == false && $act_data_flg == false){

        //�轵�ܥ���
        //��ɽ��Ƚ��
        if($bw_disabled_flg == true){
            //��ɽ��
            $form->addElement("button","back_w_button","<<���轵","disabled");
        }else{
            //ɽ��
            $form->addElement("button","back_w_button","<<���轵","onClick=\"javascript:Button_Submit('back_w_button_flg','".$_SERVER["PHP_SELF"]."','true')\"");
        }


        //�⽵�ܥ���
        //��ɽ��Ƚ��
        if($nw_disabled_flg == true){
            //��ɽ��
            $form->addElement("button","next_w_button","�⽵��>>","disabled");
        }else{
            //ɽ��
            $form->addElement("button","next_w_button","�⽵��>>",
                "onClick=\"javascript:Button_Submit('next_w_button_flg','".$_SERVER["PHP_SELF"]."','true')\""
            );
        }

        $data_msg = "���ǡ���������ޤ���";
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
//$page_menu = Create_Menu_f('sale','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[month_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[week_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);


//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'     => "$html_header",
    //'page_menu'       => "$page_menu",
    'page_header'     => "$page_header",
    'html_footer'     => "$html_footer",
    'year'            => "$year",
    'month'           => "$month",
    'staff_data_flg'  => "$staff_data_flg",
    'charge_data_flg' => "$charge_data_flg",
    'act_data_flg'    => "$act_data_flg",
    'cal_range'       => "$cal_range",
    'data_msg'        => "$data_msg",
    'error_msg'       => "$error_msg",
    'error_msg2'      => "$error_msg2",
));

//ɽ���ǡ���
$smarty->assign("disp_data", $data_list2);
$smarty->assign("calendar", $calendar);
$smarty->assign("calendar2", $calendar2);
$smarty->assign("calendar3", $calendar3);

$smarty->assign("act_disp_data", $act_data_list2);
$smarty->assign("act_calendar", $act_calendar);
$smarty->assign("act_calendar2", $act_calendar2);
$smarty->assign("act_calendar3", $act_calendar3);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($_SESSION, "SESSION");
//print_array($_POST, "POST");


/**
 *
 * �����������������̾��󥯤ο����֤�
 *
 * @param       string      $color              ��
 * @param       string      $confirm_flg        ����ե饰
 *                                                  "t" => ������ɼ
 *                                                  "f" => ̤��ǧ����ʪ��
 * @param       int         $act_id             ������ID
 * @param       int         $staff_num          ��ɼ�ν��ô���Կ�
 *
 * @return      string      ���ʿ�̾�ޤ���16�ʿ���
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2007/02/07)
 *
 */
function L_Link_Color($color, $confirm_flg, $act_id, $staff_num)
{
    //������ɼ
    if(($color == "gray" || $color == null) && $confirm_flg == "t"){
        return "gray";
    //�����ɼ
    }elseif(($color == "green" || $color == null) && $act_id != null){
        return "green";
    //ͽ����ɼ(���)
    }elseif(($color == "blue" || $color == null) && $staff_num == 1){
        return "blue";
    //ͽ����ɼ(���)
    }elseif(($color == "Fuchsia" || $color == null) && $staff_num == 2){
        return "Fuchsia";
    //ͽ����ɼ(���Ͱʾ�)
    }elseif(($color == "#FF6600" || $color == null) && ($staff_num == 3 || $staff_num == 4)){
        return "#FF6600";
    //����¾(������Ȥ�)
    }else{
        return "black";
    }

}


?>