<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/09      03-040      kajioka-h   ��å�󥯤�ɽ����､��
 *  2006/11/11      03-042      kajioka-h   ��α���������Τ�ɽ�����ʤ��褦�˽���
 *  2006/11/13      03-036      kajioka-h   ��ǧ�������˾�ǧ����Ƥ��ʤ��������å������ɲ�
 *                  03-037      kajioka-h   ��û������˼�ä���Ƥ��ʤ��������å������ɲ�
 *                  03-038      kajioka-h   ��ǧ�������˼�ä���Ƥ��ʤ��������å������ɲ�
 *                  03-039      kajioka-h   ��û�������������������Ƥ��ʤ��������å������ɲ�
 *  2007/01/06      xx-xxx      kajioka-h   �����ɼ�������谸�ˤ������ξ����Ĥ������ɲ�
 *  2007/02/21      xx-xxx      watanabe-k  ���ܽв��Ҹˤ�����Ҹˤ��ѹ�
 *
 */

$page_title = "����������ʰ������ѡ�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//��������ؿ����
require_once(PATH ."function/trade_fc.fnc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
//$auth       = Auth_Check($db_con);

// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
// �������å�����˴�
/****************************/
// �����̤Υ⥸�塼���ֹ����
$page_name  = substr($_SERVER[PHP_SELF], strrpos($_SERVER[PHP_SELF], "/")+1);
$module_no  = substr($page_name, 0, strpos($page_name, "."));

// �����̤������������å���󤬤��ꡢPOST���ʤ����
if ($_SESSION[$module_no] != null && $_POST == null){
    // �����̤����������������å������˴�
    unset($_SESSION[$module_no]);
}

$_SESSION["referer"]["f"]["sale"] = $module_no;

/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];    //������ID
$staff_id   = $_SESSION["staff_id"];     //�������ID
$staff_name = addslashes($_SESSION["staff_name"]);   //�������̾
$group_kind = $_SESSION["group_kind"];   //�ܵҶ�ʬ


/****************************/
// ɽ���������
/****************************/
// ɽ���ܥ��󲡲�����POST���줿�ե�������
if ($_POST["form_display"] != null){
    $range = $_POST["form_range_select"];
// ɽ���ܥ���ʳ���POST����hidden����
}elseif ($_POST != null && $_POST["form_display"] == null){
    $range = $_POST["hdn_range_select"];
// POST���ʤ����ϥǥե���Ȥ�100��
}else{
    $range = 100;
}


/****************************/
// �����������å�
/****************************/
//FCȽ��
if ($group_kind != "2"){
    //FC�ʳ��ϡ�TOP������
    header("Location: ".FC_DIR."top.php");
    exit;
}


/****************************/
// �ե�����ǥե����������
/****************************/
$def_fdata = array(
    "form_range_select" => "100", 
);
$form->setDefaults($def_fdata);


/****************************/
// �ե�����ѡ������
/****************************/
// ��ɼ�ֹ�
$form->addElement("text", "form_slip_num", "", "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

// ɽ�����
$ary_range_list = array("10" => "10", "50" => "50", "100" => "100", null => "����");
$form->addElement("select", "form_range_select", "", $ary_range_list, $g_form_option_select);

// �����襳����
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\" $g_form_option"
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text, "form_client", "");

// ������̾
$form->addElement("text", "form_client_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// ����襳����
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_act[cd1]','form_act[cd2]',6)\"
    $g_form_option"
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option"
);
$form->addGroup($text, "form_act", "");

//�����̾
$form->addElement("text", "form_act_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

//�����(����)
$text = ""; 
$text[] =& $form->createElement("text", "sy", "",
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[sy]', 'form_aord_day[sm]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[sy]','form_aord_day[sm]','form_aord_day[sd]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "sm", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[sm]', 'form_aord_day[sd]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[sy]','form_aord_day[sm]','form_aord_day[sd]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "sd", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[sd]','form_aord_day[ey]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[sy]','form_aord_day[sm]','form_aord_day[sd]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","��");
$text[] =& $form->createElement("text", "ey", "",
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[ey]', 'form_aord_day[em]',4)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[ey]','form_aord_day[em]','form_aord_day[ed]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "em", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onkeyup=\"changeText(this.form,'form_aord_day[em]', 'form_aord_day[ed]',2)\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[ey]','form_aord_day[em]','form_aord_day[ed]')\"
     onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "ed", "",
    "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
     onFocus=\"onForm_today(this,this.form,'form_aord_day[ey]','form_aord_day[em]','form_aord_day[ed]')\"
     onBlur=\"blurForm(this)\""
);
$form->addGroup($text, "form_aord_day", "");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

//���ꥢ
$form->addElement("button", "form_clear", "���ꥢ", "onClick=\"javascript: location.href('".$_SERVER[PHP_SELF]."');\"");

//��ǧ�ܥ���
$form->addElement("button", "form_confirm", "����ǧ", 
    "onClick=\"javascript:Button_Submit('confirm_flg','".FC_DIR."system/2-1-237.php',true)\" $disabled"
);

//�����͵�����hidden
$form->addElement("hidden","hdn_aord_day_sy");              //������ʳ��ϡ�ǯ
$form->addElement("hidden","hdn_aord_day_sm");              //������ʳ��ϡ˷�
$form->addElement("hidden","hdn_aord_day_sd");              //������ʳ��ϡ���
$form->addElement("hidden","hdn_aord_day_ey");              //������ʽ�λ��ǯ
$form->addElement("hidden","hdn_aord_day_em");              //������ʽ�λ�˷�
$form->addElement("hidden","hdn_aord_day_ed");              //������ʽ�λ����
$form->addElement("hidden","hdn_slip_num");                 //��ɼ�ֹ�
$form->addElement("hidden","hdn_range_select");             //ɽ�����
$form->addElement("hidden","hdn_client_cd1");               //������ãģ�
$form->addElement("hidden","hdn_client_cd2");               //������ãģ�
$form->addElement("hidden","hdn_client_name");              //������̾
$form->addElement("hidden","hdn_act_cd1");                  //�����ãģ�
$form->addElement("hidden","hdn_act_cd2");                  //�����ãģ�
$form->addElement("hidden","hdn_act_name");                 //�����̾
$form->addElement("hidden","confirm_flg");                  //��ǧ�ե饰
$form->addElement("hidden","hdn_cancel_id");                //������ID

/****************************/
// ɽ���ڡ�������SESSION�˥��å�
/****************************/
// �ڡ����ֹ�POST��������
if ($_POST["f_page1"] != null){
    // ���ߤ�ɽ���ڡ�������SESSION�˥��å�
    $_SESSION[$module_no]["f_page1"] = $_POST["f_page1"];
    $_SESSION[$module_no]["f_page2"] = $_POST["f_page2"];
}


/***************************/
//��å�󥯤������줿���
/***************************/
if($_POST["hdn_cancel_id"] == true){

    $cancel_id = $_POST["hdn_cancel_id"];  //����ID

    Db_Query($db_con, "BEGIN");

    $sql = "SELECT contract_div, trust_confirm_flg FROM t_aorder_h WHERE aord_id = $cancel_id;";
    $result = Db_Query($db_con, $sql);
    $contract_div       = pg_fetch_result($result, 0, "contract_div");
    $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg");

    //����饤����ԤǤ��Ǥ˼�ä���Ƥ���ʥ��ե饤��ξ��ϸ御���Τ���Ƚ�ꤷ�ʤ���
    if($contract_div == "2" && $trust_confirm_flg == "f"){
        $cancel_err = "��ä���Ƥ��뤿�ᡢ��äǤ��ޤ���";
        Db_Query($db_con, "ROLLBACK;");

    //
    }else{

        //���쥳���ɤ����뤫�����å�
        $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $cancel_id;";
        $result = Db_Query($db_con, $sql);
        if(pg_num_rows($result) != 0){
            $renew_flg = pg_fetch_result($result, 0, "renew_flg");
            //������������Ƥ���
            if($renew_flg == "t"){
                $renew_err = "������������Ƥ��뤿�ᡢ��äǤ��ޤ���";
                Db_Query($db_con, "ROLLBACK;");
            }
        }

        //������������Ƥ��ʤ� or ���쥳���ɤ��ʤ��ʥ���饤���̤��ǧ��
        if($renew_err == null){

            //���ǡ������ƺ��SQL
            $sql  = "DELETE FROM t_sale_h ";
            $sql .= "WHERE";
            $sql .= "   sale_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            //����إå��γ���ե饰��false
            $sql  = "UPDATE t_aorder_h SET";
            $sql .= "   confirm_flg = 'f',";         //����ե饰
            $sql .= "   trust_confirm_flg = 'f',";   //����ե饰(����)
            $sql .= "   cancel_flg = 't',";          //��åե饰
            $sql .= "   ps_stat = '1' ";             //��������
            $sql .= "WHERE";
            $sql .= "   aord_id = $cancel_id;";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK");
                exit;
            }

            Db_Query($db_con, "COMMIT");

            $post_flg       = true;                  //POST�ե饰

            $con_data["hdn_cancel_id"] = "";         //�����
            $form->setConstants($con_data);
        }
    }
}

/****************************/
// ��ǧ�ܥ��󲡲�����
/****************************/
if($_POST["confirm_flg"] == true){

    $con_data["confirm_flg"] = false;   // ��ǧ�ܥ�������

    $output_id_array = $_POST["output_id_array"];  //����ID����
    $check_num_array = $_POST["form_slip_check"];  //��ɼ�����å�

    //��ɼ�˥����å���������˹Ԥ�
    if($check_num_array != NULL){
        $aord_array = NULL;    //��ɼ���ϼ���ID����
        while($check_num = each($check_num_array)){
            //����ź���μ���ID����Ѥ���
            $check = $check_num[0];

            //̤��ǧ�ԤΤ�������ɲ�
            if($check_num[1] != NULL){
                $aord_array[] = $output_id_array[$check];
            }
        }
    }

    //�����å�Ƚ��
    if($aord_array != NULL){

        Db_Query($db_con, "BEGIN");

        //�����å���������IDʬ��ɼɽ��
        for($s=0;$s<count($aord_array);$s++){

            //���顼����ɽ��������ɼ�ֹ����
            $sql  = "SELECT ord_no FROM t_aorder_h WHERE aord_id = ".$aord_array[$s].";";
            $result = Db_Query($db_con, $sql);
            $ord_no = pg_fetch_result($result,0,"ord_no"); //��ɼ�ֹ�

            //���˾�ǧ����Ƥ��ʤ��������å�
            $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = ".$aord_array[$s].";";
            $result = Db_Query($db_con, $sql);
            if(pg_num_rows($result) != 0){
                $confirm_err = "�ʲ�����ɼ�ϡ���ǧ����Ƥ��뤿�᾵ǧ�Ǥ��ޤ���";
                $confirm_err_no[$ord_no] = $ord_no;
            }

            //�ޤ���ǧ����Ƥ��ʤ����Τ߰ʹߤν����¹�
            if($confirm_err_no[$ord_no] == NULL){
                $sql  = "SELECT \n";
                $sql .= "    contract_div, \n";
                $sql .= "    confirm_flg, \n";
                $sql .= "    trust_confirm_flg, \n";
                $sql .= "    reserve_del_flg, \n";
                $sql .= "    act_id \n";
                $sql .= "FROM \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "WHERE \n";
                $sql .= "    aord_id = ".$aord_array[$s]." \n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                $contract_div       = pg_fetch_result($result, 0, "contract_div");      //�����ʬ
                $confirm_flg        = pg_fetch_result($result, 0, "confirm_flg");       //����ʾ�ǧ�˥ե饰
                $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg"); //�������������˥ե饰
                $reserve_del_flg    = pg_fetch_result($result, 0, "reserve_del_flg");   //��α����ե饰
                $act_id             = pg_fetch_result($result, 0, "act_id");            //��Լ�ID

                if($reserve_del_flg == "t"){
                    $reserve_del_err = "�ʲ�����ɼ�ϡ���α�������Ƥ��뤿�᾵ǧ�Ǥ��ޤ���";
                    $reserve_del_err_no[$ord_no] = $ord_no;
                }

                //����饤����ԤǼ�ä���Ƥ��뤫�����å�
                if($contract_div == "2" && $trust_confirm_flg == "f"){
                    $cancel_err = "�ʲ�����ɼ�ϡ���ä���Ƥ��뤿�᾵ǧ�Ǥ��ޤ���";
                    $cancel_err_no[$ord_no] = $ord_no;
                }


                $buy_amount = NULL;   //�Ҳ�������

                /****************************/
                //����إå����ơ��֥빹��
                /****************************/
                $sql  = "UPDATE t_aorder_h SET";
                $sql .= "   confirm_flg = 't',";         //����ե饰
                $sql .= "   ps_stat = '3' ";             //��������
                $sql .= "WHERE";
                $sql .= "   aord_id = ".$aord_array[$s];
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                /****************************/
                //����إå������ˡ����إå�������
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    ord_no,"; //0
                $sql .= "    ord_time,"; //1
                $sql .= "    arrival_day,"; //2
                $sql .= "    client_id,"; //3
                $sql .= "    trade_id,"; //4
                $sql .= "    ware_id,"; //5
                $sql .= "    note,"; //6
                $sql .= "    cost_amount,"; //7
                $sql .= "    net_amount,"; //8
                $sql .= "    tax_amount,"; //9
                $sql .= "    intro_ac_name,"; //10
                $sql .= "    slip_flg,"; //11
                $sql .= "    shop_id, "; //12
                $sql .= "    intro_account_id,"; //13
                $sql .= "    intro_amount,"; //14
                $sql .= "    contract_div,"; //15
                $sql .= "    client_cd1,"; //16                  
                $sql .= "    client_cd2,"; //17                
                $sql .= "    client_cname,"; //18              
                $sql .= "    client_name,"; //19               
                $sql .= "    client_name2,"; //20              
                $sql .= "    ware_name, ";    //21             
                $sql .= "    reason_cor,";    //22      
                $sql .= "    route,";         //23       
                $sql .= "    intro_ac_price,"; //24     
                $sql .= "    intro_ac_rate,";  //25          
                $sql .= "    claim_id,";   //26         
                $sql .= "    claim_div,  "; //27
                $sql .= "    round_form,";  //28
                $sql .= "    slip_out ";    //29     
                $sql .= "FROM ";
                $sql .= "    t_aorder_h ";
                $sql .= "WHERE ";
                $sql .= "   aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list = Get_Data($result,3);

                //�����������
                $array_date = explode("-", $data_list[0][1]);
                //��������������������褫�����å�
                if(Check_Monthly_Renew($db_con, $data_list[0][3], "1", $array_date[0], $array_date[1], $array_date[2]) == false){
                    $deli_day_renew_err = "�ʲ�����ɼ�ϡ�������������η������������ɼ�Ǥ���";
                    $deli_day_renew_err_no[$ord_no] = $ord_no;
                }
                //�����������
                $array_date = explode("-", $data_list[0][2]);
                //��������������������褫�����å�
                if(Check_Monthly_Renew($db_con, $data_list[0][3], "1", $array_date[0], $array_date[1], $array_date[2]) == false){
                    $claim_day_renew_err = "�ʲ�����ɼ�ϡ�������������η������������ɼ�Ǥ���";
                    $claim_day_renew_err_no[$ord_no] = $ord_no;
                }
                //���������������褫�����å�
                if(Check_Bill_Close_Day($db_con, $data_list[0][3], $array_date[0], $array_date[1], $array_date[2]) == false){
                    $claim_day_bill_err  = "�ʲ�����ɼ�ϡ������������������Ѥ����դ����Ϥ���Ƥ��ޤ���<br>";
                    $claim_day_bill_err .= "�����������ѹ����뤫�������������Ʋ�������";
                    $claim_day_bill_err_no[$ord_no] = $ord_no;
                }

                $sql  = "INSERT INTO t_sale_h(";
                $sql .= "    sale_id,";         //���ID
                $sql .= "    sale_no,";         //����ֹ�
                $sql .= "    aord_id,";         //����ID
                $sql .= "    sale_day,";        //�����
                $sql .= "    claim_day,";       //������
                $sql .= "    client_id,";       //������ID
                $sql .= "    trade_id,";        //�����ʬ
                $sql .= "    ware_id,";         //�в��Ҹ�
                $sql .= "    note,";            //����
                $sql .= "    cost_amount,";     //�������
                $sql .= "    net_amount,";      //�����
                $sql .= "    tax_amount,";      //�����ǳ�
                $sql .= "    intro_ac_name,";   //�Ҳ����̾
                $sql .= "    slip_flg,";        //��ɼ���ϥե饰
                $sql .= "    shop_id,";         //�����ID
                $sql .= "    intro_account_id,";//�Ҳ����ID
                $sql .= "    intro_amount,";    //�Ҳ������
                $sql .= "    c_shop_name,";     //����å�̾
                $sql .= "    c_shop_name2,";    //����å�̾��
                $sql .= "    client_cd1,";      //������CD1
                $sql .= "    client_cd2,";      //������CD2
                $sql .= "    client_cname,";    //ά��
                $sql .= "    client_name,";     //������̾1
                $sql .= "    client_name2,";    //������̾2
                $sql .= "    c_post_no1,";      //͹���ֹ�1
                $sql .= "    c_post_no2,";      //͹���ֹ�2
                $sql .= "    c_address1,";      //���꣱
                $sql .= "    c_address2,";      //���ꣲ
                $sql .= "    c_address3,";      //���ꣳ
                $sql .= "    ware_name,";       //�в��Ҹ�̾
                $sql .= "    reason_cor,";      //������ͳ
                $sql .= "    route,";           //��ϩ
                $sql .= "    intro_ac_price,";  //����ñ��(������)
                $sql .= "    intro_ac_rate,";   //����Ψ(������)
                $sql .= "    claim_id,";        //������ID
                $sql .= "    claim_div,";       //�������ʬ
                $sql .= "    round_form,";      //������
                $sql .= "    contract_div,";    //�����ʬ
                $sql .= "    slip_out,";        //��ɼ����
                $sql .= "    e_staff_id,";      //���ڥ졼��ID
                $sql .= "    e_staff_name, ";   //���ڥ졼��̾
                $sql .= "    act_id,";          //��Լ�ID
                $sql .= "    act_cd1,";         //��Լ�CD1
                $sql .= "    act_cd2,";         //��Լ�CD2
                $sql .= "    act_name1,";       //��Լ�̾1
                $sql .= "    act_name2,";       //��Լ�̾2
                $sql .= "    act_cname";        //��Լ�̾��ά�Ρ�
                $sql .= ")VALUES(";
                $sql .= "    ".$aord_array[$s].",";
                //�����ֹ����Ƚ��
                if($data_list[0][0] != NULL){
                    $sql .= "    '".$data_list[0][0]."',";
                }else{
                    $sql .= "    NULL,";
                }
                $sql .= "    ".$aord_array[$s].",";
                $sql .= "    '".$data_list[0][1]."',";
                $sql .= "    '".$data_list[0][2]."',";
                $sql .= "    ".$data_list[0][3].",";
                $sql .= "    '".$data_list[0][4]."',";
                $sql .= "    NULL,";         //�����ɼ�νв��Ҹˤ����¦�ʤΤ����ˤ�NULL
                $sql .= "    '".$data_list[0][6]."',";
                $sql .= "    ".$data_list[0][7].",";
                $sql .= "    ".$data_list[0][8].",";
                $sql .= "    ".$data_list[0][9].",";
                $sql .= "    '".$data_list[0][10]."',";
                $sql .= "    '".$data_list[0][11]."',";
                $sql .= "    ".$data_list[0][12].",";
                //�Ҳ����Ƚ��
                if($data_list[0][13] != NULL){
                    $sql .= "    ".$data_list[0][13].",";
                }else{
                    $sql .= "    NULL,";
                }
                //�Ҳ������Ƚ��
                if($data_list[0][14] != NULL){
                    $sql .= "    ".$data_list[0][14].",";
                }else{
                    $sql .= "    NULL,";
                }

                $sql .= "    (SELECT ";
                $sql .= "        t_client.shop_name ";   //����å�̾
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.shop_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.shop_name2 ";  //����å�̾2
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.shop_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    '".$data_list[0][16]."',";
                $sql .= "    '".$data_list[0][17]."',";
                $sql .= "    '".$data_list[0][18]."',";
                $sql .= "    '".$data_list[0][19]."',";
                $sql .= "    '".$data_list[0][20]."',";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.post_no1 ";      //͹���ֹ�1
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.post_no2 ";      //͹���ֹ�2
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address1 ";      //���꣱
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address2 ";      //���ꣲ
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address3 ";      //���ꣳ
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    NULL,";   //�����ɼ�νв��Ҹˤ����¦�ʤΤ����ˤ�NULL
                $sql .= "    '".$data_list[0][22]."',";
                //��ϩ����Ƚ��
                if($data_list[0][23] != NULL){
                    $sql .= "    ".$data_list[0][23].",";
                }else{
                    $sql .= "    NULL,";
                }
                //����ñ��(������)����Ƚ��
                if($data_list[0][24] != NULL){
                    $sql .= "    ".$data_list[0][24].",";
                }else{
                    $sql .= "    NULL,";
                }
                $sql .= "    '".$data_list[0][25]."',";
                $sql .= "    ".$data_list[0][26].",";
                $sql .= "    '".$data_list[0][27]."',";
                $sql .= "    '".$data_list[0][28]."',";
                //�����ʬ
                $sql .= "    '".$data_list[0][15]."',";
                $sql .= "    '".$data_list[0][29]."',";
                $sql .= "    ".$staff_id.",";
                $sql .= "    '".$staff_name."',";
                $sql .= "    $act_id,";     //��Լ�ID
                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $act_id),";     //��Լ�CD1
                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $act_id),";     //��Լ�CD2
                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $act_id),";    //��Լ�̾1
                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $act_id),";   //��Լ�̾2
                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $act_id)";    //��Լ�̾��ά�Ρ�
                $sql .= ");";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK");
                    exit;
                }

                /****************************/
                //���ô���ԥơ��֥���Ͽ
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    staff_div,";
                $sql .= "    staff_id,";
                $sql .= "    sale_rate,";
                $sql .= "    staff_name,";
                $sql .= "    course_id ";
                $sql .= "FROM ";
                $sql .= "    t_aorder_staff ";
                $sql .= "WHERE ";
                $sql .= "    aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list3 = Get_Data($result,3);

                for($a=0;$a<count($data_list3);$a++){
                    $sql  = "INSERT INTO t_sale_staff( ";
                    $sql .= "    sale_id,";                         //���ID
                    $sql .= "    staff_div,";                       //ô���Լ���
                    $sql .= "    staff_id,";                        //ô����ID
                    $sql .= "    sale_rate,";                       //���Ψ
                    $sql .= "    staff_name,";                      //ô����̾
                    $sql .= "    course_id ";                       //������ID
                    $sql .= "    )VALUES(";
                    $sql .= "    ".$aord_array[$s].",";             
                    $sql .= "    '".$data_list3[$a][0]."',";        
                    $sql .= "    ".$data_list3[$a][1].",";          
                    //���Ψ����Ƚ��
                    if($data_list3[$a][2] != NULL){
                        $sql .= "    ".$data_list3[$a][2].",";     
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list3[$a][3]."',";
                    //����������Ƚ��
                    if($data_list3[$a][4] != NULL){
                        $sql .= "    ".$data_list3[$a][4];
                    }else{
                        $sql .= "    NULL";
                    }
                    $sql .= ");";
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }
                }

                /****************************/
                //����ǡ������ˡ����ǡ�������
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    t_aorder_d.aord_d_id,";        //����ǡ���ID0
                $sql .= "    t_aorder_d.line,";             //��1
                $sql .= "    t_aorder_d.sale_div_cd, ";     //�����ʬ2
                $sql .= "    t_aorder_d.serv_print_flg, ";  //�����ӥ�����3
                $sql .= "    t_aorder_d.serv_id,";          //�����ӥ�ID4
                $sql .= "    t_aorder_d.set_flg,";          //�켰�ե饰5
                $sql .= "    t_aorder_d.goods_print_flg, "; //�����ƥ����6
                $sql .= "    t_aorder_d.goods_id,";         //�����ƥ�ID7
                $sql .= "    t_aorder_d.goods_name,";       //�����ƥ�̾8
                $sql .= "    t_aorder_d.num,";              //�����ƥ��9
                $sql .= "    t_aorder_d.tax_div,";          //���Ƕ�ʬ10
                $sql .= "    t_aorder_d.buy_price,";        //����ñ��11
                $sql .= "    t_aorder_d.cost_price,";       //�Ķ�ñ��12
                $sql .= "    t_aorder_d.sale_price,";       //���ñ��13
                $sql .= "    t_aorder_d.buy_amount,";       //�������14
                $sql .= "    t_aorder_d.cost_amount,";      //�Ķȶ��15
                $sql .= "    t_aorder_d.sale_amount,";      //�����16
                $sql .= "    t_aorder_d.rgoods_id,";        //����ID
                $sql .= "    t_aorder_d.rgoods_name,";      //����̾
                $sql .= "    t_aorder_d.rgoods_num,";       //���ο�
                $sql .= "    t_aorder_d.egoods_id,";        //������ID
                $sql .= "    t_aorder_d.egoods_name,";      //������̾
                $sql .= "    t_aorder_d.egoods_num,";       //�����ʿ�
                $sql .= "    t_aorder_d.contract_id,";      //�������ID
                $sql .= "    t_aorder_d.account_price,";    //����ñ��
                $sql .= "    t_aorder_d.account_rate,";     //����Ψ

                $sql .= "    t_aorder_d.serv_name, ";       //�����ӥ�̾
                $sql .= "    t_aorder_d.serv_cd, ";         //�����ӥ�CD
                $sql .= "    t_aorder_d.goods_cd, ";        //�����ƥ�CD
                $sql .= "    t_aorder_d.rgoods_cd, ";       //����CD
                $sql .= "    t_aorder_d.egoods_cd, ";       //������CD
                $sql .= "    t_goods.unit, ";               //����ñ��
                $sql .= "    t_aorder_d.g_product_name,";   //����ʬ��̾
                $sql .= "    t_aorder_d.official_goods_name ";  //����̾
                $sql .= "FROM ";
                $sql .= "    t_aorder_d ";
                $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
                $sql .= "WHERE ";
                $sql .= "   t_aorder_d.aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list2 = Get_Data($result,3);

                for($a=0;$a<count($data_list2);$a++){
    /*
                    //�����ƥ�ID����Ƚ��
                    if($data_list2[$a][7] != NULL){
                        //����ʬ�ࡦ����̾�μ���
                        $sql  = "SELECT ";
                        $sql .= "    t_g_product.g_product_name,";
                        $sql .= "    t_goods.goods_name ";
                        $sql .= "FROM ";
                        $sql .= "    t_g_product ";
                        $sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
                        $sql .= "WHERE ";
                        $sql .= "    t_goods.goods_id = ".$data_list2[$a][7].";";
                        $result = Db_Query($db_con, $sql);
                        $pro_data = NULL;
                        $pro_data = Get_Data($result,3);
                    }
    */

                    $sql  = "INSERT INTO t_sale_d(";
                    $sql .= "    sale_d_id,";         //���ǡ���ID
                    $sql .= "    sale_id,";           //���ID
                    $sql .= "    line,";              //��
                    $sql .= "    sale_div_cd,";       //�����ʬCD
                    $sql .= "    serv_print_flg,";    //�����ӥ�����
                    $sql .= "    serv_id,";           //�����ӥ�ID
                    $sql .= "    set_flg,";           //�켰�ե饰
                    $sql .= "    goods_print_flg, ";  //�����ƥ����
                    $sql .= "    goods_id,";          //�����ƥ�ID
                    $sql .= "    goods_name,";        //�����ƥ�̾
                    $sql .= "    num,";               //�����ƥ��
                    $sql .= "    tax_div,";           //���Ƕ�ʬ
                    $sql .= "    buy_price,";         //����ñ��
                    $sql .= "    cost_price,";        //�Ķ�ñ��
                    $sql .= "    sale_price,";        //���ñ��
                    $sql .= "    buy_amount,";        //�������
                    $sql .= "    cost_amount,";       //�Ķȶ��
                    $sql .= "    sale_amount,";       //�����
                    $sql .= "    rgoods_id,";         //����ID
                    $sql .= "    rgoods_name,";       //����̾
                    $sql .= "    rgoods_num,";        //���ο�
                    $sql .= "    egoods_id,";         //������ID
                    $sql .= "    egoods_name,";       //������̾
                    $sql .= "    egoods_num,";        //�����ʿ�
                    $sql .= "    aord_d_id,";         //����ǡ���ID
                    $sql .= "    contract_id,";       //�������ID
                    $sql .= "    account_price,";     //����ñ��
                    $sql .= "    account_rate, ";     //����Ψ
                    $sql .= "    serv_name,";         //�����ӥ�̾
                    $sql .= "    serv_cd, ";          //�����ӥ�CD
                    $sql .= "    goods_cd, ";         //�����ƥ�CD
                    $sql .= "    rgoods_cd,";         //����CD
                    $sql .= "    egoods_cd, ";        //������CD
                    $sql .= "    unit, ";             //����ñ��
                    $sql .= "    g_product_name,";    //����ʬ��
                    $sql .= "    official_goods_name";//�����ƥ�̾(����̾��)
                    $sql .= ")VALUES(";
                    $sql .= "    ".$data_list2[$a][0].",";
                    $sql .= "    ".$aord_array[$s].",";
                    $sql .= "    '".$data_list2[$a][1]."',";
                    $sql .= "    '".$data_list2[$a][2]."',";
                    $sql .= "    '".$data_list2[$a][3]."',";
                    //�����ӥ�ID
                    if($data_list2[$a][4] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][4].",";
                    }else{
                        $sql .= "    NULL,";
                    }                                      
                    $sql .= "    '".$data_list2[$a][5]."',";
                    $sql .= "    '".$data_list2[$a][6]."',";
                    //�����ƥྦ��ID
                    if($data_list2[$a][7] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][7].",";
                    }else{
                        $sql .= "    NULL,";
                    }            
                    $sql .= "    '".$data_list2[$a][8]."',";
                    //�����ƥ��
                    if($data_list2[$a][9] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][9].",";
                    }else{
                        $sql .= "    NULL,";
                    }                             
                    $sql .= "    '".$data_list2[$a][10]."',";
                    $sql .= "    ".$data_list2[$a][12].",";
                    $sql .= "    ".$data_list2[$a][12].",";
                    $sql .= "    ".$data_list2[$a][13].",";
                    $sql .= "    ".$data_list2[$a][15].",";
                    $sql .= "    ".$data_list2[$a][15].",";
                    $sql .= "    ".$data_list2[$a][16].",";
                    //���ξ���ID
                    if($data_list2[$a][17] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][17].",";
                    }else{
                        $sql .= "    NULL,";
                    }                             
                    $sql .= "    '".$data_list2[$a][18]."',";
                    //���ο�
                    if($data_list2[$a][19] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][19].",";
                    }else{
                        $sql .= "    NULL,";
                    }                
                    //������ID
                    if($data_list2[$a][20] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][20].",";
                    }else{
                        $sql .= "    NULL,";
                    }               
                    $sql .= "    '".$data_list2[$a][21]."',";
                    //�����ʿ�
                    if($data_list2[$a][22] != NULL){                                     
                        $sql .= "    ".$data_list2[$a][22].",";
                    }else{
                        $sql .= "    NULL,";
                    }               
                    $sql .= "    ".$data_list2[$a][0].",";
                    $sql .= "    ".$data_list2[$a][23].",";
                    //����ñ�� 
                    if($data_list2[$a][24] != NULL){  
                        $sql .= "    ".$data_list2[$a][24].",";
                    }else{
                        $sql .= "    NULL,";
                    }   
                    $sql .= "    '".$data_list2[$a][25]."',";

                    $sql .= "    '".$data_list2[$a][26]."',"; 
                    $sql .= "    '".$data_list2[$a][27]."',"; 
                    $sql .= "    '".$data_list2[$a][28]."',"; 
                    $sql .= "    '".$data_list2[$a][29]."',";
                    $sql .= "    '".$data_list2[$a][30]."',";
                    $sql .= "    '".$data_list2[$a][31]."',";
                    $sql .= "    '".$data_list2[$a][32]."',";
                    $sql .= "    '".$data_list2[$a][33]."');";  
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }

                    /****************************/
                    //����������ơ��֥���ˡ����������ơ��֥����
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    aord_d_id,";
                    $sql .= "    line,";
                    $sql .= "    goods_id,";
                    $sql .= "    goods_name,";
                    $sql .= "    num,";
                    $sql .= "    trade_price,";
                    $sql .= "    trade_amount,";
                    $sql .= "    sale_price,";
                    $sql .= "    sale_amount, ";
                    $sql .= "    goods_cd ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_detail ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_d_id = ".$data_list2[$a][0];
                    $result = Db_Query($db_con, $sql);
                    $data_list4 = Get_Data($result,3);

                    for($x=0;$x<count($data_list4);$x++){
                        $sql  = "INSERT INTO t_sale_detail( ";
                        $sql .= "    sale_d_id,";
                        $sql .= "    line,";
                        $sql .= "    goods_id,";
                        $sql .= "    goods_name,";
                        $sql .= "    num,";
                        $sql .= "    trade_price,";
                        $sql .= "    trade_amount,";
                        $sql .= "    sale_price,";
                        $sql .= "    sale_amount,";
                        $sql .= "    goods_cd ";
                        $sql .= "    )VALUES(";
                        $sql .= "    ".$data_list4[$x][0].",";          
                        $sql .= "    ".$data_list4[$x][1].",";    
                        $sql .= "    ".$data_list4[$x][2].",";          
                        $sql .= "    '".$data_list4[$x][3]."',";        
                        $sql .= "    ".$data_list4[$x][4].",";          
                        $sql .= "    ".$data_list4[$x][5].",";          
                        $sql .= "    ".$data_list4[$x][6].",";          
                        $sql .= "    ".$data_list4[$x][7].",";          
                        $sql .= "    ".$data_list4[$x][8].",";
                        $sql .= "    '".$data_list4[$x][9]."'";          
                        $sql .= ");";
                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }

                    /****************************/
                    //����νи��ʥơ��֥���ˡ����νи��ʥơ��֥����
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    aord_d_id,";
                    $sql .= "    goods_id,";
                    $sql .= "    goods_name,";
                    $sql .= "    num,";
                    $sql .= "    goods_cd ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_ship ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_d_id = ".$data_list2[$a][0].";";
                    $result = Db_Query($db_con, $sql);
                    $data_list5 = Get_Data($result,3);

                    //������ID�ξ�������
/*
                    $sql  = "SELECT";
                    $sql .= "   t_ware.ware_id ";
                    $sql .= " FROM";
                    $sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
                    $sql .= " WHERE";
                    $sql .= "   client_id = $shop_id";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql); 
                    $client_data = Get_Data($result);
                    $ware_id     = $client_data[0][0];        //�в��Ҹ�ID
*/
                    //�����Ҹ�ID
                    $ware_id = Get_ware_id($db_con, Get_Branch_Id($db_con));

                    //��ʧ����Ͽ����ǡ�������
                    $sql  = "SELECT ";
                    $sql .= "    t_sale_h.sale_day,";     //�����
                    $sql .= "    t_sale_h.sale_no ";      //�����ֹ�
                    $sql .= "FROM ";
                    $sql .= "    t_sale_h ";
                    $sql .= "    INNER JOIN t_sale_d ON t_sale_d.sale_id = t_sale_h.sale_id ";
                    $sql .= "WHERE ";
                    $sql .= "    t_sale_h.sale_id = ".$aord_array[$s].";";
                    $result = Db_Query($db_con, $sql);
                    $stock_data = Get_Data($result);

                    for($c=0;$c<count($data_list5);$c++){
                        $sql  = "INSERT INTO t_sale_ship( ";
                        $sql .= "    sale_d_id,";
                        $sql .= "    goods_id,";
                        $sql .= "    goods_name,";
                        $sql .= "    num,";
                        $sql .= "    goods_cd ";
                        $sql .= "    )VALUES(";
                        $sql .= "    ".$data_list5[$c][0].",";    
                        $sql .= "    ".$data_list5[$c][1].",";         
                        $sql .= "    '".$data_list5[$c][2]."',";
                        $sql .= "    ".$data_list5[$c][3].",";
                        $sql .= "    '".$data_list5[$c][4]."'";
                        $sql .= ");";
                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
                }

                /****************************/
                //���ID����Ҳ�����׻����������ơ��֥����Ͽ
                /****************************/
                //�Ҳ�������Ƚ��
                $sql  = "SELECT ";
                $sql .= "    intro_amount ";
                $sql .= "FROM ";
                $sql .= "    t_sale_h ";
                $sql .= "WHERE ";
                $sql .= "    sale_id = ".$aord_array[$s];
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
            
                $intro_amount = pg_fetch_result($result, 0, "intro_amount");    //�Ҳ���

                //�Ҳ��������ꤵ��Ƥ�����硢��Ͽ
                if($intro_amount != NULL){
                    $result = FC_Intro_Buy_Query($db_con, $aord_array[$s], $data_list[0][13]);
                    if($result === false){
                        //Ʊ���¹��������
                        $err_message = pg_last_error();
                        $err_format = "t_buy_h_buy_no_key";

                        //�����ֹ椬��ʣ�������            
                        if(strstr($err_message,$err_format) != false){
                            $error_buy = "�ʲ�����ɼ�ϡ������ֹ椬��ʣ���ޤ������⤦���پ�ǧ��ԤäƤ���������";
                            $error_buy_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
                }

                //�����¸��Ƚ��
                $sql  = "SELECT act_sale_id FROM t_buy_h WHERE act_sale_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql.";");
                $aord_count = pg_num_rows($result);
                //¸�ߤ��Ƥ��ʤ������Ͽ
                if($aord_count == 0){
                    /****************************/
                    //�������Ͽ����
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    act_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_h ";
                    $sql .= "WHERE ";
                    $sql .= "   aord_id = ".$aord_array[$s];
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $shop_data = Get_Data($result);
                    $buy_d_id = FC_Act_Buy_Query($db_con, $aord_array[$s],$shop_data[0][0],$shop_id);
                    if($buy_d_id === false){
                        //Ʊ���¹��������
                        $err_message = pg_last_error();
                        $err_format = "t_buy_h_buy_no_key";

                        //�����ֹ椬��ʣ�������            
                        if(strstr($err_message,$err_format) != false){
                            $error_buy = "�ʲ�����ɼ�ϡ������ֹ椬��ʣ���ޤ������⤦���پ�ǧ��ԤäƤ���������";
                            $error_buy_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                             Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
                }
            }
        }

        //���顼�ξ�硢�����̤����ܤ��ʤ�
        if( $error_buy == NULL && 
            $deli_day_renew_err == NULL && 
            $claim_day_renew_err == NULL && 
            $claim_day_bill_err == NULL && 
            $confirm_err == NULL && 
            $reserve_del_err == NULL && 
            $cancel_err == NULL 
        ){
            //����

            Db_Query($db_con, "COMMIT");
//            header("Location: ./2-1-237.php");

        }else{
            //���顼

            Db_Query($db_con, "ROLLBACK;");
            
            //���˾�ǧ
            if($confirm_err_no != NULL){
                while($error_confirm_no = each($confirm_err_no)){
                    $e_confirm_no = $error_confirm_no[0];
                    $confirm_err .= "<br>����".$e_confirm_no;
                }
            }

            //��α���
            if($reserve_del_err_no != NULL){
                while($error_reserve_no = each($reserve_del_err_no)){
                    $e_reserve_no = $error_reserve_no[0];
                    $reserve_del_err .= "<br>����".$e_reserve_no;
                }
            }

            //���˼��
            if($cancel_err_no != NULL){
                while($error_cancel_no = each($cancel_err_no)){
                    $e_cancel_no = $error_cancel_no[0];
                    $cancel_err .= "<br>����".$e_cancel_no;
                }
            }

            //������ ������η��������
            if($deli_day_renew_err_no != NULL){
                while($error_deli_day_no = each($deli_day_renew_err_no)){
                    $e_deli_day_no = $error_deli_day_no[0];
                    $deli_day_renew_err .= "<br>����".$e_deli_day_no;
                }
            }

            //������ ������η��������
            if($claim_day_renew_err_no != NULL){
                while($error_claim_day_renew_no = each($claim_day_renew_err_no)){
                    $e_claim_day_renew_no = $error_claim_day_renew_no[0];
                    $claim_day_renew_err .= "<br>����".$e_claim_day_renew_no;
                }
            }

            //������ ������������
            if($claim_day_bill_err_no != NULL){
                while($error_claim_day_bill_no = each($claim_day_bill_err_no)){
                    $e_claim_day_bill_no = $error_claim_day_bill_no[0];
                    $claim_day_bill_err .= "<br>����".$e_claim_day_bill_no;
                }
            }

            //�����ֹ椬��ʣ
            if($error_buy_no != NULL){
                while($error_buy_no = each($error_buy_no)){
                    $e_buy_no = $error_buy_no[0];
                    $error_buy .= "<br>����".$e_buy_no;
                }
            }
        }
    }else{
        //�����å���̵�����ϥ��顼

        $error_msg3 = "��ǧ������ɼ����Ĥ����򤵤�Ƥ��ޤ���";
        $error_flg = true;
    }
}

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_display"] == "ɽ����"){
    //���ߤΥڡ����������
    $page_count = null;
    $offset = 0;

    /******************************/
    //POST�������
    /******************************/
    $aord_day_sy  = $_POST["form_aord_day"]["sy"];                      //��������ϡ�ǯ��
    $aord_day_sm  = $_POST["form_aord_day"]["sm"];                      //��������ϡʷ��
    $aord_day_sd  = $_POST["form_aord_day"]["sd"];                      //��������ϡ�����
    if($aord_day_sy != NULL && $aord_day_sm != NULL && $aord_day_sd != NULL){
        $sday  = str_pad($_POST["form_aord_day"]["sy"], 4, 0, STR_PAD_LEFT);    //��������ϡ�ǯ��
        $sday .= "-";
        $sday .= str_pad($_POST["form_aord_day"]["sm"], 2, 0, STR_PAD_LEFT);    //��������ϡʷ��
        $sday .= "-";
        $sday .= str_pad($_POST["form_aord_day"]["sd"], 2, 0, STR_PAD_LEFT);    //��������ϡ�����
    }
    $aord_day_ey  = $_POST["form_aord_day"]["ey"];                      //�������λ��ǯ��
    $aord_day_em  = $_POST["form_aord_day"]["em"];                      //�������λ�ʷ��
    $aord_day_ed  = $_POST["form_aord_day"]["ed"];                      //�������λ������
    if($aord_day_ey != NULL && $aord_day_em != NULL && $aord_day_ed != NULL){
        $eday  = str_pad($_POST["form_aord_day"]["ey"], 4, 0, STR_PAD_LEFT);    //�������λ��ǯ��
        $eday .= "-";
        $eday .= str_pad($_POST["form_aord_day"]["em"], 2, 0, STR_PAD_LEFT);    //�������λ�ʷ��
        $eday .= "-";
        $eday .= str_pad($_POST["form_aord_day"]["ed"], 2, 0, STR_PAD_LEFT);    //�������λ������
    }

    $slip_num     = $_POST["form_slip_num"];                           //��ɼ�ֹ�
    $client_cd1   = $_POST["form_client"]["cd1"];                      //������CD1
    $client_cd2   = $_POST["form_client"]["cd2"];                      //������CD2                           
    $client_name  = $_POST["form_client_name"];                        //������̾
    
    $act_cd1   = $_POST["form_act"]["cd1"];                            //�����CD1
    $act_cd2   = $_POST["form_act"]["cd2"];                            //�����CD2                           
    $act_name  = $_POST["form_act_name"];                              //�����̾

    $post_flg     = true;                                              //POST�ե饰

/****************************/
//�ڡ���ʬ����󥯲�������
/****************************/
}elseif(count($_POST)>0 && $_POST["form_display"] != "ɽ����"){

    /******************************/
    //POST�������
    /******************************/
    $aord_day_sy  = $_POST["hdn_aord_day_sy"];                          //��������ϡ�ǯ��
    $aord_day_sm  = $_POST["hdn_aord_day_sm"];                          //��������ϡʷ��
    $aord_day_sd  = $_POST["hdn_aord_day_sd"];                          //��������ϡ�����
    if($aord_day_sy != NULL && $aord_day_sm != NULL && $aord_day_sd != NULL){
        $sday  = str_pad($_POST["hdn_aord_day_sy"], 4, 0, STR_PAD_LEFT);        //��������ϡ�ǯ��
        $sday .= "-";
        $sday .= str_pad($_POST["hdn_aord_day_sm"], 2, 0, STR_PAD_LEFT);        //��������ϡʷ��
        $sday .= "-";
        $sday .= str_pad($_POST["hdn_aord_day_sd"], 2, 0, STR_PAD_LEFT);        //��������ϡ�����
    }
    $aord_day_ey  = $_POST["hdn_aord_day_ey"];                          //�������λ��ǯ��
    $aord_day_em  = $_POST["hdn_aord_day_em"];                          //�������λ�ʷ��
    $aord_day_ed  = $_POST["hdn_aord_day_ed"];                          //�������λ������
    if($aord_day_ey != NULL && $aord_day_em != NULL && $aord_day_ed != NULL){
        $eday  = str_pad($_POST["hdn_aord_day_ey"], 4, 0, STR_PAD_LEFT);        //�������λ��ǯ��
        $eday .= "-";
        $eday .= str_pad($_POST["hdn_aord_day_em"], 2, 0, STR_PAD_LEFT);        //�������λ�ʷ��
        $eday .= "-";
        $eday .= str_pad($_POST["hdn_aord_day_ed"], 2, 0, STR_PAD_LEFT);        //�������λ������
    }
    
    $slip_num     = $_POST["hdn_slip_num"];                         //��ɼ�ֹ�
    $client_cd1   = $_POST["hdn_client_cd1"];                       //������CD1
    $client_cd2   = $_POST["hdn_client_cd2"];                       //������CD2                           
    $client_name  = $_POST["hdn_client_name"];                      //������̾

    $act_cd1   = $_POST["hdn_act_cd1"];                             //���CD1
    $act_cd2   = $_POST["hdn_act_cd2"];                             //�����CD2                           
    $act_name  = $_POST["hdn_act_name"];                            //�����̾

    $page_count  = $_POST["f_page1"];
    
    $offset = $page_count * $range - $range;

    $post_flg       = true;                                         //POST�ե饰

    // hidden�θ�������ե�����˥��å�
    $form_set["form_slip_num"]          = stripslashes($_POST["hdn_slip_num"]);
    $form_set["form_range_select"]      = stripslashes($_POST["hdn_range_select"]);
    $form_set["form_client"]["cd1"]     = stripslashes($_POST["hdn_client_cd1"]);
    $form_set["form_client"]["cd2"]     = stripslashes($_POST["hdn_client_cd2"]);
    $form_set["form_client_name"]       = stripslashes($_POST["hdn_client_name"]);
    $form_set["form_act"]["cd1"]        = stripslashes($_POST["hdn_act_cd1"]);
    $form_set["form_act"]["cd2"]        = stripslashes($_POST["hdn_act_cd2"]);
    $form_set["form_act_name"]          = stripslashes($_POST["hdn_act_name"]);
    $form_set["form_aord_day"]["sy"]    = stripslashes($_POST["hdn_aord_day_sy"]);
    $form_set["form_aord_day"]["sm"]    = stripslashes($_POST["hdn_aord_day_sm"]);
    $form_set["form_aord_day"]["sd"]    = stripslashes($_POST["hdn_aord_day_sd"]);
    $form_set["form_aord_day"]["ey"]    = stripslashes($_POST["hdn_aord_day_ey"]);
    $form_set["form_aord_day"]["em"]    = stripslashes($_POST["hdn_aord_day_em"]);
    $form_set["form_aord_day"]["ed"]    = stripslashes($_POST["hdn_aord_day_ed"]);
    $form->setConstants($form_set);

}

/****************************/
//POST�������
/****************************/
if($post_flg == true){
 
    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    //�������
    //��ʸ��������å�
    if($aord_day_sy != null || $aord_day_sm != null || $aord_day_sd != null){

        $aord_day_sy = str_pad($aord_day_sy,4, 0, STR_PAD_LEFT);  
        $aord_day_sm = str_pad($aord_day_sm,2, 0, STR_PAD_LEFT); 
        $aord_day_sd = str_pad($aord_day_sd,2, 0, STR_PAD_LEFT); 

        //����Ƚ��
        if(!ereg("^[0-9]{4}$",$aord_day_sy) || !ereg("^[0-9]{2}$",$aord_day_sm) || !ereg("^[0-9]{2}$",$aord_day_sd)){
            $error_msg = "��������� �����դ������ǤϤ���ޤ���";
            $error_flg = true;
        }

        //��ʸ��������å�
        $day_sy = (int)$aord_day_sy;
        $day_sm = (int)$aord_day_sm;
        $day_sd = (int)$aord_day_sd;
        if(!checkdate($day_sm,$day_sd,$day_sy)){
            $error_msg = "��������� �����դ������ǤϤ���ޤ���";
            $error_flg = true;
        }
    }

    if($aord_day_ey != null || $aord_day_em != null || $aord_day_ed != null){

        $aord_day_ey = str_pad($aord_day_ey,4, 0, STR_PAD_LEFT);  
        $aord_day_em = str_pad($aord_day_em,2, 0, STR_PAD_LEFT); 
        $aord_day_ed = str_pad($aord_day_ed,2, 0, STR_PAD_LEFT); 

        //����Ƚ��
        if(!ereg("^[0-9]{4}$",$aord_day_ey) || !ereg("^[0-9]{2}$",$aord_day_em) || !ereg("^[0-9]{2}$",$aord_day_ed)){
            $error_msg2 = "�������λ �����դ������ǤϤ���ޤ���";
            $error_flg = true;
        }

        //��ʸ��������å�
        $day_ey = (int)$aord_day_ey;
        $day_em = (int)$aord_day_em;
        $day_ed = (int)$aord_day_ed;
        if(!checkdate($day_em,$day_ed,$day_ey)){
            $error_msg2 = "�������λ �����դ������ǤϤ���ޤ���";
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
/*
        $def_data["form_aord_day"]["sy"]      = stripslashes($aord_day_sy);               
        $def_data["form_aord_day"]["sm"]      = stripslashes($aord_day_sm);               
        $def_data["form_aord_day"]["sd"]      = stripslashes($aord_day_sd);          
        $def_data["form_aord_day"]["ey"]      = stripslashes($aord_day_ey);               
        $def_data["form_aord_day"]["em"]      = stripslashes($aord_day_em);               
        $def_data["form_aord_day"]["ed"]      = stripslashes($aord_day_ed);          
        
        $def_data["form_slip_num"]            = stripslashes($slip_num);
      
        $def_data["form_client"]["cd1"]        = stripslashes($client_cd1);  
        $def_data["form_client"]["cd2"]        = stripslashes($client_cd2); 
        $def_data["form_client_name"]          = stripslashes($client_name);  

        $def_data["form_act"]["cd1"]           = stripslashes($act_cd1);  
        $def_data["form_act"]["cd2"]           = stripslashes($act_cd2); 
        $def_data["form_act_name"]             = stripslashes($act_name);  
*/

        $def_data["hdn_aord_day_sy"]          = stripslashes($aord_day_sy);               
        $def_data["hdn_aord_day_sm"]          = stripslashes($aord_day_sm);               
        $def_data["hdn_aord_day_sd"]          = stripslashes($aord_day_sd);          
        $def_data["hdn_aord_day_ey"]          = stripslashes($aord_day_ey);               
        $def_data["hdn_aord_day_em"]          = stripslashes($aord_day_em);               
        $def_data["hdn_aord_day_ed"]          = stripslashes($aord_day_ed);          
        
        $def_data["hdn_slip_num"]             = stripslashes($slip_num);      
        $def_data["hdn_client_cd1"]           = stripslashes($client_cd1);  
        $def_data["hdn_client_cd2"]           = stripslashes($client_cd2); 
        $def_data["hdn_client_name"]          = stripslashes($client_name);  
         
        $def_data["hdn_act_cd1"]              = stripslashes($act_cd1);  
        $def_data["hdn_act_cd2"]              = stripslashes($act_cd2); 
        $def_data["hdn_act_name"]             = stripslashes($act_name);  

        $def_data["hdn_range_select"]         = $_POST["form_range_select"];

        $form->setConstants($def_data); 

        // ɽ���ܥ��󲡲���
        if ($_POST["form_display"] != null){
            // �ե�����ǡ�����SESSION�˥��å�
            $_SESSION[$module_no]["hdn_slip_num"]       = stripslashes($_POST["form_slip_num"]);
            $_SESSION[$module_no]["hdn_range_select"]   = stripslashes($_POST["form_range_select"]);
            $_SESSION[$module_no]["hdn_client_cd1"]     = stripslashes($_POST["form_client"]["cd1"]);
            $_SESSION[$module_no]["hdn_client_cd2"]     = stripslashes($_POST["form_client"]["cd2"]);
            $_SESSION[$module_no]["hdn_client_name"]    = stripslashes($_POST["form_client_name"]);
            $_SESSION[$module_no]["hdn_act_cd1"]        = stripslashes($_POST["form_act"]["cd1"]);
            $_SESSION[$module_no]["hdn_act_cd2"]        = stripslashes($_POST["form_act"]["cd2"]);
            $_SESSION[$module_no]["hdn_act_name"]       = stripslashes($_POST["form_act_name"]);
            $_SESSION[$module_no]["hdn_aord_day_sy"]    = stripslashes($_POST["form_aord_day"]["sy"]);
            $_SESSION[$module_no]["hdn_aord_day_sm"]    = stripslashes($_POST["form_aord_day"]["sm"]);
            $_SESSION[$module_no]["hdn_aord_day_sd"]    = stripslashes($_POST["form_aord_day"]["sd"]);
            $_SESSION[$module_no]["hdn_aord_day_ey"]    = stripslashes($_POST["form_aord_day"]["ey"]);
            $_SESSION[$module_no]["hdn_aord_day_em"]    = stripslashes($_POST["form_aord_day"]["em"]);
            $_SESSION[$module_no]["hdn_aord_day_ed"]    = stripslashes($_POST["form_aord_day"]["ed"]);
            if ($_POST["f_page1"] == null || $_POST["form_display"] != null){
                $_SESSION[$module_no]["f_page1"]        = "1";
                $_SESSION[$module_no]["f_page2"]        = "1";
            }
        }

        /****************************/
        //WHERE_SQL����
        /****************************/
        $where_sql  = "";

        //������ʳ��ϡ�
        $where_sql .= $sday_sql         = ($sday != null) ? "AND '$sday' <= t_aorder_h.ord_time \n" : null;

        //������ʽ�λ��
        $where_sql .= $eday_sql         = ($eday != null) ? "AND t_aorder_h.ord_time <= '$eday' \n" : null;

        //��ɼ�ֹ�
        $where_sql .= $slip_sql         = ($slip_num != null) ? "AND t_aorder_h.ord_no LIKE '$slip_num%' \n" : null;

        //�����襳����1
        $where_sql .= $client_cd1_sql   = ($client_cd1 != null) ? "AND t_aorder_h.client_cd1 LIKE '$client_cd1%' \n" : null;
           
        //�����襳����2
        $where_sql .= $client_cd2_sql   = ($client_cd2 != null) ? "AND t_aorder_h.client_cd2 LIKE '$client_cd2%' \n" : null;

        //������̾
        if($client_name != null){
            $client_name_sql  = "AND \n";
            $client_name_sql .= "   ( \n";
            $client_name_sql .= "       t_aorder_h.client_name LIKE '%$client_name%' \n";
            $client_name_sql .= "       OR \n";
            $client_name_sql .= "       t_aorder_h.client_name2 LIKE '%$client_name%' \n";
            $client_name_sql .= "       OR \n";
            $client_name_sql .= "       t_aorder_h.client_cname LIKE '%$client_name%' \n";
            $client_name_sql .= "   ) \n";
            $where_sql .= $client_name_sql;
        }

        //����襳����1
        $where_sql .= $act_cd1_sql      = ($act_cd1 != null) ? "AND t_aorder_h.act_cd1 LIKE '$act_cd1%' \n" : null;
           
        //����襳����2
        $where_sql .= $act_cd2_sql      = ($act_cd2 != null) ? "AND t_aorder_h.act_cd2 LIKE '$act_cd2%' \n" : null;

        //�����̾
        $where_sql .= $act_name_sql     = ($act_name != null) ? "AND t_aorder_h.act_name LIKE '%$act_name%' \n" : null;

    }
}

/****************************/
//����إå�������SQL
/****************************/
// ɽ���ե饰�����ꡢ���顼�Τʤ����
if ($post_flg == true && $err_flg != true){

    // ����饤�����
    $sql  = "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // ����ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // �����ֹ�
    $sql .= "   t_staff1.charge_cd, \n";                                                // ô����CD1
    $sql .= "   t_staff1.staff_name, \n";                                               // ô����̾1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // �����
    $sql .= "   t_aorder_h.client_cname, \n";                                           // ά��
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// ������CD
    $sql .= "   t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2 AS act_cd, \n";         // �����CD
    $sql .= "   t_aorder_h.act_name, \n";                                               // �����̾
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '��ǧ' \n";
    $sql .= "       WHEN 'f' THEN '̤��ǧ' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // ����ե饰
    $sql .= "   '����' AS contract_div, \n";                                            // �����ʬ
    $sql .= "   t_trade.trade_name, \n";                                                // �����ʬ
    $sql .= "   t_sale_h.renew_flg, \n";                                                // ���������ե饰
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // ������
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // �����襳����
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // ������̾
    $sql .= "   t_aorder_h.net_amount, \n";                                             // ��ȴ���
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // ������
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount \n";    // ��۹��
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff1 \n";
    $sql .= "   ON t_staff1.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.trust_confirm_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ps_stat = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.reserve_del_flg = 'f' \n";
    $sql .= $where_sql;

    $sql .= "UNION \n";

    // ���ե饤�����
    $sql .= "SELECT \n";
    $sql .= "   t_aorder_h.aord_id, \n";                                                // ����ID
    $sql .= "   t_aorder_h.ord_no, \n";                                                 // �����ֹ�
    $sql .= "   t_staff1.charge_cd, \n";                                                // ô����CD1
    $sql .= "   t_staff1.staff_name, \n";                                               // ô����̾1
    $sql .= "   t_aorder_h.ord_time, \n";                                               // �����
    $sql .= "   t_aorder_h.client_cname, \n";                                           // ά��
    $sql .= "   t_aorder_h.client_cd1 || '-' || t_aorder_h.client_cd2 AS client_cd, \n";// ������CD
    $sql .= "   t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2 AS act_cd, \n";         // �����CD
    $sql .= "   t_aorder_h.act_name, \n";                                               // �����̾
    $sql .= "   CASE t_aorder_h.confirm_flg \n";
    $sql .= "       WHEN 't' THEN '��ǧ' \n";
    $sql .= "       WHEN 'f' THEN '̤��ǧ' \n";
    $sql .= "   END \n";
    $sql .= "   AS confirm_flg, \n";                                                    // ����ե饰
    $sql .= "   '����' AS contract_div, \n";                                            // �����ʬ
    $sql .= "   t_trade.trade_name, \n";                                                // �����ʬ
    $sql .= "   t_sale_h.renew_flg, ";                                                  // ���������ե饰
    $sql .= "   t_aorder_h.arrival_day, \n";                                            // ������
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS claim_cd, \n";     // �����襳����
    $sql .= "   t_client.client_cname AS claim_cname, \n";                              // ������̾
    $sql .= "   t_aorder_h.net_amount, \n";                                             // ��ȴ���
    $sql .= "   t_aorder_h.tax_amount, \n";                                             // ������
    $sql .= "   t_aorder_h.net_amount + t_aorder_h.tax_amount AS net_tax_amount \n";    // ������
    $sql .= "FROM \n";
    $sql .= "   t_aorder_h \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_staff.aord_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_aorder_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_staff \n";
    $sql .= "           LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_staff.staff_div = '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate != '0' \n";
    $sql .= "       AND \n";
    $sql .= "           t_aorder_staff.sale_rate IS NOT NULL \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_staff1 \n";
    $sql .= "   ON t_staff1.aord_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_sale_h ON t_sale_h.sale_id = t_aorder_h.aord_id \n";
    $sql .= "   LEFT JOIN t_client ON t_aorder_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT JOIN t_trade  ON t_aorder_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.contract_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_aorder_h.reserve_del_flg = 'f' \n";
    $sql .= $where_sql;

    // �����Ƚ�
    $sql .= "ORDER BY \n";
    $sql .= "   5, \n";     // ������̾ά��
    $sql .= "   3 \n";      // ���ô����

    // ��������ʷ�������ѡ�
    $res         = Db_Query($db_con, $sql.";");
    $total_count = pg_num_rows($res);

    // OFFSET����
    if($page_count != null || $range != null){
        $offset = $page_count * $range - $range;
    }else{
        $offset = 0;
    }
    if ($range != null){
        $sql .= "LIMIT $range OFFSET $offset \n";
    }

    // �����ǡ��������ʥڡ���ʬ���ѡ�
    $res_h = Db_Query($db_con, $sql.";");
    $num_h = pg_num_rows($res_h);
    if ($num_h > 0){
        $page_data_h = Get_Data($res_h, 2, "ASSOC");
    }else{
        $page_data_h = array(null);
    }

    // �嵭�Ǽ�����������إå��˳����������ǡ����μ���
    if ($num_h > 0){
        $sql  = "SELECT \n";
        $sql .= "   t_aorder_d.aord_id, \n";                // ����ID
        $sql .= "   t_aorder_d.line, \n ";                  // ��
        $sql .= "   CASE t_aorder_d.sale_div_cd \n";
        $sql .= "       WHEN '01' THEN '��ԡ���' \n";
        $sql .= "       WHEN '02' THEN '����' \n";
        $sql .= "       WHEN '03' THEN '��󥿥�' \n";
        $sql .= "       WHEN '04' THEN '�꡼��' \n";
        $sql .= "       WHEN '05' THEN '��' \n";
        $sql .= "       WHEN '06' THEN '����' \n";
        $sql .= "       WHEN '07' THEN '����¾' \n";
        $sql .= "   END \n";
        $sql .= "   AS sale_div_cd, \n";                    // �����ʬ
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.serv_print_flg = 't' \n";
        $sql .= "       THEN '��'\n";
        $sql .= "       ELSE '��' \n";
        $sql .= "   END \n";
        $sql .= "   AS serv_print_flg, \n";                 // �����ӥ������ե饰
        $sql .= "   t_aorder_d.serv_cd, \n";                // �����ӥ�������
        $sql .= "   t_aorder_d.serv_name, \n";              // �����ӥ�̾
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.goods_print_flg = 't' \n";
        $sql .= "       THEN '��'\n";
        $sql .= "       ELSE '��' \n";
        $sql .= "   END \n";
        $sql .= "   AS goods_print_flg, \n";                // ���ʰ����ե饰
        $sql .= "   t_aorder_d.goods_cd, \n";               // ���ʥ�����
        $sql .= "   t_aorder_d.official_goods_name, \n";    // ����̾
        $sql .= "   CASE \n";
        $sql .= "       WHEN t_aorder_d.set_flg = 't' \n";
        $sql .= "       THEN '�켰<br>'\n";
        $sql .= "       ELSE NULL \n";
        $sql .= "   END \n";
        $sql .= "   AS set_flg, \n";                        // �����ӥ��켰�ե饰
        $sql .= "   t_aorder_d.num, \n";                    // ����
        $sql .= "   t_aorder_d.cost_price, \n";             // �Ķȸ���
        $sql .= "   t_aorder_d.sale_price, \n";             // ���ñ��
        $sql .= "   t_aorder_d.cost_amount, \n";            // ������׳�
        $sql .= "   t_aorder_d.sale_amount, \n";            // ����׳�
        $sql .= "   t_aorder_d.egoods_cd, \n";              // �����ʥ�����
        $sql .= "   t_aorder_d.egoods_name, \n";            // ������̾
        $sql .= "   t_aorder_d.egoods_num, \n";             // �����ʿ���
        $sql .= "   t_aorder_d.rgoods_cd, \n";              // ���ξ��ʥ�����
        $sql .= "   t_aorder_d.rgoods_name, \n";            // ���ξ���̾
        $sql .= "   t_aorder_d.rgoods_num \n";              // ���ξ��ʿ���
        $sql .= "FROM \n";
        $sql .= "   t_aorder_d \n";
        $sql .= "WHERE \n";
        $sql .= "   t_aorder_d.aord_id IN (";
        foreach ($page_data_h as $key_h => $value_h){
        $sql .= $value_h["aord_id"];  // ����إå��������Ƥμ���ID
        $sql .= ($key_h+1 < $num_h) ? ", " : null;
        }
        $sql .= ") \n";
        $sql .= "ORDER BY \n";
        $sql .= "   t_aorder_d.aord_id, \n";
        $sql .= "   t_aorder_d.line \n";
        $sql .= ";";
        $res_d = Db_Query($db_con, $sql);
        $num_d = pg_num_rows($res_d);
        if ($num_d > 0){
            $page_data_d = Get_Data($res_d, 2, "ASSOC");
        }else{
            $page_data_d = array(null);
        }
    }

}


/****************************/
// ɽ���ǡ�������
/****************************/
// ��ۤ�����ξ��˥������ʸ�������֤ˤ���ؿ�
function Font_Color($num, $dot = 0){
    return ((int)$num < 0) ? "<font style=\"color: #ff0000;\">".number_format($num, $dot)."</font>" : number_format($num, $dot);
}

// ɽ���ե饰true�����ĥ��顼�Τʤ����
if ($post_flg == true && $err_flg != true){

    /****************************/
    // ��ǧ�����å��ܥå��������ѽ���
    /****************************/
    //�����å��ܥå�����ɽ�����ֹ�����
    $hidden_check = array();

    // �إå����ǥ롼��
    if ($num_h > 0){

        foreach ($page_data_h as $key_h => $value_h){
            // ����ID��hidden���ɲ�
            $form->addElement("hidden","output_id_array[$key_h]");                      // ��ǧ����ID����
            $con_data["output_id_array[$key_h]"] = $page_data_h[$key_h]["aord_id"];     // ����ID
            // ����Ƚ��
            if ($page_data_h[$key_h]["confirm_flg"] != "̤��ǧ"){
                // �����å��ܥå�����ɽ�����ֹ����
                $hidden_check[] = $key_h;
            }
        }

    }

    /****************************/
    // �ե�����ưŪ���ʺ���
    /****************************/
    // ��ǧALL�����å�
    $form->addElement("checkbox", "form_slip_all_check", "", "��ǧ",
        "onClick=\"javascript:All_check('form_slip_all_check','form_slip_check',$num_h)\""
    );

    if ($num_h > 0){
        // ��ǧ�����å�
        foreach ($page_data_h as $key_h => $value_h){
            // ɽ����Ƚ��
            if (!in_array($key_h, $hidden_check)){
                // ̤��ǧ�Ԥϥ����å��ܥå������
                $form->addElement("checkbox", "form_slip_check[$key_h]","","","","");
            }else{
                // ��ǧ�Ԥ���ɽ���ˤ���٤�hidden�����
                $form->addElement("hidden","form_slip_check[$key_h]","");
            }
        }
    }

    /****************************/
    // POST���˥����å���������
    /****************************/
    if(count($_POST) > 0){
        foreach ($page_data_h as $key_h => $value_h){
            $con_data["form_slip_check"][$key_h]  = "";   
        }
        $con_data["form_slip_all_check"] = "";   
    }
    $form->setConstants($con_data); 

    /****************************/
    // html�����������
    /****************************/
    // �Կ��������
    $row_col = "Result1";

    // ��No.�������
    $row_num = ($_POST["f_page1"] != null && $_POST["form_display"] == null) ? ($_POST["f_page1"]-1) * $range : 0;

    /****************************/
    // html����
    /****************************/
    // ���ɽ��/�ڡ���ʬ��
    $range = ($range == null) ? $num_h : $range;
    $html_page  = Html_Page($total_count, $page_count, 1, $range);
    $html_page2 = Html_Page($total_count, $page_count, 2, $range);

    // ���٥ǡ��� �󥿥��ȥ�
    $html_l  = "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
    $html_l .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_l .= "        <td class=\"Title_Pink\">No.</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">��ɼ�ֹ�</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����襳����<br>������̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">����襳����<br>�����̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����襳����<br>������̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���<br>��ʬ</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���ô����<br>�ʥᥤ��1��</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">��ȴ���</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">������</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">��ɼ���</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����ʬ</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����ӥ�������<br>�����ӥ�̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���ʥ�����<br>����̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�Ķȸ���<br>���ñ��</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">������׳�<br>����׳�</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">�����ʥ�����<br>������̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���ξ��ʥ�����<br>���ξ���̾</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">��ǧ</td>\n";
    $html_l .= "        <td class=\"Title_Pink\">���</td>\n";
    $html_l .= "        <td class=\"Title_Pink\" width=\"150\">";
    $html_l .=              $form->_elements[$form->_elementIndex["form_slip_all_check"]]->toHtml();
    $html_l .= "        </td>\n";
    $html_l .= "    </tr>\n";

    // �إå����ǥ롼��
    if ($num_h > 0){
    foreach ($page_data_h as $key_h => $value_h){

        $row_col = ($row_col == "Result1") ? "Result2" : "Result1";  // 1->2, 2->1
        $href    = FC_DIR."sale/2-2-106.php?aord_id[0]=".$value_h["aord_id"]."&back_display=round"; // ��������

        // ���٥ǡ��� �ǡ�������1���ܤΤ߽��Ϥ���إå����ǡ��� ����1
        $html_l .= "    <tr class=\"$row_col\">\n";
        $html_l .= "        <td align=\"right\">".++$row_num."</td>\n";                                                 // No.
        $html_l .= "        <td align=\"center\"><a href=\"$href\">".$value_h["ord_no"]."</a></td>\n";                  // ��ɼ�ֹ�
        $html_l .= "        <td align=\"center\">".$value_h["ord_time"]."</td>\n";                                      // �����
        $html_l .= "        <td align=\"center\">".$value_h["arrival_day"]."</td>\n";                                   // ������
        $html_l .= "        <td>".$value_h["client_cd"]."<br>".htmlspecialchars($value_h["client_cname"])."<br></td>\n";// ������
        $html_l .= "        <td>".$value_h["act_cd"]."<br>".htmlspecialchars($value_h["act_name"])."<br></td>\n";       // �����
        $html_l .= "        <td>".$value_h["claim_cd"]."<br>".htmlspecialchars($value_h["claim_cname"])."<br></td>\n";  // ������
        $html_l .= "        <td align=\"center\">".$value_h["contract_div"]."</td>\n";                                  // ��Զ�ʬ
        if ($value_h["charge_cd"] != null){
        $html_l .= "        <td>".$value_h["charge_cd"]." : ".htmlspecialchars($value_h["staff_name"])."</td>\n";       // ���ô����
        }else{
        $html_l .= "        <td></td>\n";
        }
        $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_amount"])."</td>\n";                         // ��ȴ���
        $html_l .= "        <td align=\"right\">".Font_Color($value_h["tax_amount"])."</td>\n";                         // ������
        $html_l .= "        <td align=\"right\">".Font_Color($value_h["net_tax_amount"])."</td>\n";                     // ��ɼ���

        // �ǡ������ǥ롼��
        foreach ($page_data_d as $key_d => $value_d){
            // �إå����롼�פμ���ID�ȥǡ������롼�פμ���ID��Ʊ�����ʳ�����ɼ�Υǡ������Ǥ������
            if ($value_h["aord_id"] == $value_d["aord_id"]){
                // �ǡ������롼�פ�1���ܤǤʤ����
                if ($value_d["line"] != "1"){
                    // ��td�����֡�12�ġ�
                    $html_l .= "    <tr class=\"$row_col\">\n";
                    for ($i=0; $i<12; $i++){
                        // ���٥ǡ��� �إå�������Ϥ��ʤ��ǡ������ǡ��� ����1��2���ܰʹߤΥǡ������ǡ�����
                        $html_l .= "        <td></td>\n";
                    }
                }
                // ���٥ǡ��� �ǡ������ǡ���
                $html_l .= "        <td align=\"center\">".$value_d["sale_div_cd"]."</td>\n";                           // �����ʬ
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["serv_print_flg"]."��".$value_d["serv_cd"]."<br>\n";                 // ����/�����ӥ�������
                $html_l .= "            ".htmlspecialchars($value_d["serv_name"])."<br>\n";                             // �����ӥ�̾
                $html_l .= "        </td>\n";
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["goods_print_flg"]."��".$value_d["goods_cd"]."<br>\n";               // ����/���ʥ�����
                $html_l .= "            ".htmlspecialchars($value_d["official_goods_name"])."<br>\n";                   // ����̾
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["set_flg"].$value_d["num"]."</td>\n";                // �켰/����
                $html_l .= "        <td align=\"right\">\n";
                $html_l .= "            ".Font_Color($value_d["cost_price"], 2)."<br>\n";                               // �Ķȸ���
                $html_l .= "            ".Font_Color($value_d["sale_price"], 2)."<br>\n";                               // ���ñ��
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">\n";                                                            
                $html_l .= "            ".Font_Color($value_d["cost_amount"])."<br>\n";                                 // ������׳�
                $html_l .= "            ".Font_Color($value_d["sale_amount"])."<br>\n";                                 // ����׳�
                $html_l .= "        </td>\n";
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["egoods_cd"]."<br>\n";                                               // �����ʥ�����
                $html_l .= "            ".htmlspecialchars($value_d["egoods_name"])."<br>\n";                           // ������̾
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["egoods_num"]."</td>\n";                             // ����
                $html_l .= "        <td>\n";
                $html_l .= "            ".$value_d["rgoods_cd"]."<br>\n";                                               // ���ξ��ʥ�����
                $html_l .= "            ".htmlspecialchars($value_d["rgoods_name"])."<br>\n";                           // ���ξ���̾
                $html_l .= "        </td>\n";
                $html_l .= "        <td align=\"right\">".$value_d["rgoods_num"]."</td>\n";                             // ����
                // �ǡ������롼�פ�1���ܤξ��
                if ($value_d["line"] == "1"){
                    // ���٥ǡ��� �ǡ�������1���ܤΤ߽��Ϥ���إå����ǡ��� ����2
                    $html_l .= "        <td align=\"center\">".$value_h["confirm_flg"]."</td>\n";                       // ��ǧ
                    // ����饤�󤫤Ľ񤭹��߸��¤���ξ��
                    if ($value_h["contract_div"] == "����" && $disabled == null){
                        $del_link   = "<a href=\"#\" onClick=\"return Dialogue_1('��ä��ޤ���',".$value_h["aord_id"].",'hdn_cancel_id');\">���</a>";
                    }else{
                        $del_link   = "";
                    }
                    $html_l .= "        <td align=\"center\">$del_link</td>\n";                                         // ��å��
                    $html_l .= "        <td align=\"center\">\n";                                                       // ��ǧ�����å��ܥå���
                    $html_l .= "            ".$form->_elements[$form->_elementIndex["form_slip_check[$key_h]"]]->toHtml()."\n";
                    $html_l .= "        </td>\n";
                // �ǡ������롼�פ�2���ܰʹߤξ��
                }else{
                    // ��td�����֡�3�ġ�
                    for ($i=0; $i<3; $i++){
                        // ���٥ǡ��� �إå�������Ϥ��ʤ��ǡ������ǡ��� ����2��2���ܰʹߤΥǡ������ǡ�����
                        $html_l .= "        <td></td>\n";
                    }
                }
                $html_l .= "    </tr>\n";
            }
        }
    }
    }

    // �ǽ���
    $html_l .= "    <tr class=\"Result3\">\n";
    for ($i=0; $i<24; $i++){
        $html_l .= "        <td></td>\n";
    }
    $html_l .= "        <td align=\"center\">".$form->_elements[$form->_elementIndex["form_confirm"]]->toHtml()."</td>\n";
    $html_l .= "    </tr>\n";

    $html_l .= "</table>\n";

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
//$page_menu = Create_Menu_f('sale','2');

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
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'error_msg'     => "$error_msg",
    'error_msg2'    => "$error_msg2",
    'error_msg3'    => "$error_msg3",
    'error_buy'     => "$error_buy",
    'confirm_err'   => "$confirm_err",
    'reserve_del_err'   => "$reserve_del_err",
    'cancel_err'    => "$cancel_err",
    'renew_err'     => "$renew_err",
    'auth_r_msg'    => "$auth_r_msg",
    'disabled'      => "$disabled",
    'deli_day_renew_err'    => "$deli_day_renew_err",
    'claim_day_renew_err'   => "$claim_day_renew_err",
    'claim_day_bill_err'    => "$claim_day_bill_err",
    'group_kind'    => "$group_kind",
));

$smarty->assign("html_l", $html_l);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
