<?php
/*****************************/
//  �ѹ�����
//      ��20060920�˷�����������������Υ����å����ɲá�WATANABE-k��
//       2006/10/23 07-001 kaku-m �������������󤬶���ξ�硢00��ɽ������ʤ��褦���ѹ�
//       2006/10/23 07-004 kaku-m �������������å��Υ�å��������Ƥ���
//       2006/10/23 07-008 kaku-m ��Ͽ���˶�ԥǡ������ݻ������ѿ�����������褦�˽���
//       2006/10/24 07-014 kaku-m ��Ͽ�ǡ��������å��μ���������ѹ��������å����ܤ��ɲá���������ʧ��ۤν������
//       2006/10/24 07-006 kaku-m �����ʧ�϶��ɬ�ܤΥ����å��򤹤�褦�˽���
//       2006/10/25 07-005 kaku-m hidden�ѿ����������ɲä򤷡���å�����ɽ��������
//       2006/10/25 kaku-m ��Ͽ��ǧ���̤ǡ���Ͽ�԰ʳ������ˡ�������Ϥʤ��Ȥ��ϥ���ܥܥå�������ɽ���˽���
//       2006/10/26 kaku-m ͽ��������̤�����ѿ������Ϥ���SESSION���ѹ�
//       2006/10/26 kaku-m GET���ͥ����å����ɲ�
//       2006/12/01 kaku-m ��ʧ��Ȼ�ʧ���ʷ�ޤǡˤ��ѹ������Ȥ��ˡ�����������ˤ���褦�˽���
//       2007/01/24 kaku-m �������ʬ�Υ����å��ˤ�äơ�����������ɽ���������Ƥ��ѹ����뤿�ᡢ�������ɲ��ѹ���
//       2007/01/24 kaku-m �������ʬ��JavaScript��onClick���ѹ�����ʬ���Ѥ�ä��Ȥ��ˤΤߥ��֥ߥåȤ���褦�˽�������
//       2007/01/24 kaku-m �֡ݡפ�ɽ�����ե꡼�����̤ΤȤ����������ʤ��ä���ʬ����
//       2007/03/27 kaku-m ���ե����å����mktime�¹Ծ����ѹ�
//       2007/03/28 kaku-m ��ǧ���̤Ƕ�ۤ�ʥ�С��ե����ޥåȤ���褦�˽���
/*****************************/

/*
 * ����
 * �����ա�������BɼNo.������  ô���ԡ��������ơ�
 * ��2006/12/16��scl_0083������watanabe-k���ѹ����˻�ʧͽ��ۤ�ɽ������ʤ��Х��ν���
 * ��2007/01/07��        ������watanabe-k����������ǽ�ɲ�
 * ��2007/01/25��        ������watanabe-k���ܥ���ο��ѹ�
 * ��2007/06/09��        ������watanabe-k����ʧͽ��ۤ˽���Ĺ��ޤ�ʤ��褦�˽���
 * ��2007/07/03��        ������watanabe-k����Ͽ���˥����ꥨ�顼��ɽ�������Х��ν���
 *  2007-07-12                  fukuda      �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *   2007/10/22                watanabe-k  ��ʧ��ǧ���̤ǰ���ܤζ�ۤ�Number_format����Ƥ��ʤ��Х��ν���
 */

$page_title = "��ʧ����";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);

// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å�
/*****************************/
// GET��POST��̵�����
if ($_GET == null && $_POST == null && $_SESSION["schedule_payment_id"] == null){
    Set_Rtn_Page("payout");
}


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];
$group_kind = $_SESSION['group_kind'];


/****************************/
// ��ʧID�μ�갷��
/****************************/
// ��ʧID��POST����Ƥ�����
if ($_POST["pay_id"] != null){

    // POST�λ�ʧID���ѿ���hidden�˥��å�
    $pay_id             = $_POST["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ���åȥե饰true���ѿ���hidden�˥��å�
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// GET�˻�ʧID��������
if ($_GET["pay_id"] != null){

    // GET������ʧID�������������å�
    $safe_flg = Get_Id_Check_Db($db_con, $_GET["pay_id"], "pay_id", "t_payout_h", "num", "shop_id = $shop_id");
    if ($safe_flg === false){
        header("Location:../top.php");
        exit;
    }

    // GET�λ�ʧID���ѿ���hidden�˥��å�
    $pay_id             = $_GET["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ���åȥե饰true���ѿ���hidden�˥��å�
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// POST��GET�˻�ʧID���ʤ����
if ($_POST["pay_id"] == null && $_GET["pay_id"] == null){

    // ���åȥե饰false���ѿ���hidden�˥��å�
    $get_flg             = "";
    $set_hdn["get_flg"]  = $get_flg;

}

$form->setConstants($set_hdn);


/****************************/
// �������
/****************************/
// ɽ���Կ�
if (isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}


/****************************/
// �Կ��ɲ�
/****************************/
if ($_POST["add_row_flg"]== "true"){
    // ����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"] + 5;
    // �Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}


/****************************/
// �Ժ������
/****************************/
if (isset($_POST["del_row"])){
    // ����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];
    // ������������ˤ��롣
    $ary_del_rows = explode(",", $del_row);
    unset($ary_del_rows[0]);
}else{
    // �����������ν���ͺ���
    $ary_del_rows = array();
}


/***************************/
// ���������
/***************************/
// ���ߤκ���Կ���hidden�˥��å�
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

// ��ʧ���ʰ�������
$setdate["form_pay_day_all"]["y"] = date("Y");
$setdate["form_pay_day_all"]["m"] = date("m");
$setdate["form_pay_day_all"]["d"] = date("d");
$form->setDefaults($setdate);


/****************************/
// �ե���������ʸ����
/****************************/
// �إå�����󥯥ܥ���
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-3-303.php", "������" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);

// ��ʧ���ʰ�������
Addelement_Date($form, "form_pay_day_all", "", "-");

// �����ʬ�ʰ�������
$trade_value = Select_Get($db_con, "trade_payout");
unset($trade_value[48]);
unset($trade_value[49]);
$form->addElement("select", "form_trade_all", "", $trade_value, $g_form_option_select);

// ��ԡʰ�������
$bank_value = Make_Ary_Bank($db_con);
$obj    =   null;
$obj    =&  $form->addElement("hierselect", "form_bank_all", "", "", " ");
$obj->setOptions($bank_value);

// �������ܥ���
$form->addElement("button", "all_set_button", "�������", "onClick=\"javascript: Button_Submit_1('all_set_flg', '#', 'true');\"");

// ���ɲåܥ���
$form->addElement("button", "add_row_button", "���ɲ�", "onClick=\"javascript: Button_Submit_1('add_row_flg', '#foot', 'true');\"");

// hidden
$form->addElement("hidden", "del_row");         // �����
$form->addElement("hidden", "add_row_flg");     // �ɲùԥե饰
$form->addElement("hidden", "max_row");         // ����Կ�
$form->addElement("hidden", "layer");           // �����
$form->addElement("hidden", "div_flg");         // ������ʬ
$form->addElement("hidden", "get_flg");         // �ѹ������١ʻ�ʧ�Ȳ񤫤�˥ե饰
$form->addElement("hidden", "pay_id");          // ��ʧID
$form->addElement("hidden", "pay_no");          // ��ʧ�ֹ�
$form->addelement("hidden", "all_set_flg");     // �������ե饰
$form->addElement("hidden", "payout_flg");      // ��ʧ�ܥ��󲡲��ե饰
$form->addElement("hidden", "date_chg");        // �����ѹ����֥ߥåȥե饰
$form->addElement("hidden", "confirm_flg");     // ��ǧ���̤إܥ��󲡲��ե饰
$form->addElement("hidden", "post_flg", "1");   // ���ɽ��Ƚ���ѥե饰


/****************************/
// ����������
/****************************/
if($_POST["all_set_flg"] == "true"){

    // ��ʧ���ʰ��ˤ�0���
    $_POST["form_pay_day_all"]   = Str_Pad_Date($_POST["form_pay_day_all"]);
    $all_set["form_pay_day_all"] = $_POST["form_pay_day_all"];

    for ($i = 0; $i < $_POST["max_row"]; $i++){
        // ��ʧ��
        $all_set["form_pay_day_$i"]["y"]    = ($_POST["form_pay_day_all"]["y"] != "") ? $_POST["form_pay_day_all"]["y"] : "";
        $all_set["form_pay_day_$i"]["m"]    = ($_POST["form_pay_day_all"]["m"] != "") ? $_POST["form_pay_day_all"]["m"] : "";
        $all_set["form_pay_day_$i"]["d"]    = ($_POST["form_pay_day_all"]["d"] != "") ? $_POST["form_pay_day_all"]["d"] : "";
        // �����ʬ
        $all_set["form_trade_$i"]           = $_POST["form_trade_all"];
        // ���
        $all_set["form_bank_$i"][0]         = $_POST["form_bank_all"][0];
        $all_set["form_bank_$i"][1]         = $_POST["form_bank_all"][1];
        $all_set["form_bank_$i"][2]         = $_POST["form_bank_all"][2];
    }

    // �������hidden
    $all_set["all_set_flg"] = "";

    $form->setConstants($all_set);

}


/****************************/
// �����襳���ɡ���ʧǯ�����Ͻ���
/****************************/
// �����оݹ��ֹ椬������
if ($_POST["layer"] != ""){

    $row            = $_POST["layer"];                  // ���ֹ�
    $supplier_cd    = $_POST["form_client_cd1_$row"];   // �����襳���ɣ�
    $supplier_cd2   = $_POST["form_client_cd2_$row"];   // �����襳���ɣ�
    $div_select     = "3";                              // �����衦FC��������ʬ

    // FC��ʬ�λ��������sql
    $sql  = "SELECT \n";
    $sql .= "   t_client.client_id, \n";       // ������ID
    $sql .= "   t_client.client_cd1, \n";      // �����襳���ɣ�
    $sql .= "   t_client.client_cd2, \n";      // �����襳���ɣ�
    $sql .= "   t_client.client_cname, \n";    // ������̾
    $sql .= "   t_client.b_bank_name \n";      // ��������ά��
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    if ($client_id == ""){
        $sql .= "WHERE t_client.client_cd1 = '$supplier_cd' \n";
        $sql .= "AND   t_client.client_cd2 = '$supplier_cd2' \n";
        $sql .= "AND   t_client.client_div = '3' \n";
    }else{
        $sql .= "WHERE t_client.client_id = $client_id \n";
    }
    $sql .= " ;";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �����褬¸�ߤ�����
    if ($num > 0){

        $get_data = pg_fetch_array($res);

        $set_client_data["hdn_client_id"][$row]     = $get_data["client_id"];       // ������ID
        $set_client_data["form_client_cd1_$row"]    = $get_data["client_cd1"];      // �����襳���ɣ�
        $set_client_data["form_client_cd2_$row"]    = $get_data["client_cd2"];      // �����襳���ɣ�
        $set_client_data["form_client_name_$row"]   = $get_data["client_cname"];    // ������̾
        $set_client_data["form_pay_bank_$row"]      = $get_data["b_bank_name"];     // ��������ά��

        // ������ID���ѿ��˥��å�
        $search_client_id = $get_data["client_id"];

        // �ǿ��λ�ʧ��ۤ����
        $sql  = "SELECT \n";
        $sql .= "   t_schedule_payment.schedule_of_payment_this \n";
        $sql .= "FROM \n";
        $sql .= "   t_schedule_payment \n";
        $sql .= "WHERE \n";
        $sql .= "   t_schedule_payment.client_id = ".$get_data["client_id"]." \n";
        $sql .= "AND \n";
        $sql .= "   t_schedule_payment.first_set_flg = 'f' \n";
        $sql .= "ORDER BY \n";
        $sql .= "   payment_expected_date DESC \n";
        $sql .= "LIMIT 1 \n";
        $sql .= ";"; 
        $res  = Db_Query($db_con, $sql);

        // ͽ��ۥ쥳���ɤ�������
        if (pg_num_rows($res) > 0){
            $get_pay_mon = pg_fetch_result($res, 0, 0);
        // ͽ��ۥ쥳���ɤʤ��ξ��
        }else{
            $get_pay_mon = "";
        }

        // ��ۥ��å�
        if ($get_pay_mon != ""){
        $set_client_data["form_pay_mon_plan_$row"]  = number_format($get_pay_mon);  // ��ʧͽ��ۡʥʥ�С��ե����ޥåȡ�
        }else{
        $set_client_data["form_pay_mon_plan_$row"]  = $get_pay_mon;                 // ��ʧͽ���
        }
        $set_client_data["form_pay_mon_$row"]       = $get_pay_mon;                 // ��ʧ��
        $set_client_data["form_pay_fee_$row"]       = "";                           // �����

    // �����褬¸�ߤ��ʤ����
    }else{

        $set_client_data["hdn_client_id"][$row]     = "";
        $set_client_data["form_client_name_$row"]   = "";
        $set_client_data["form_pay_bank_$row"]      = "";
        $set_client_data["form_pay_mon_plan_$row"]  = "";
        $set_client_data["form_pay_mon_$row"]       = "";
        $set_client_data["form_pay_fee_$row"]       = "";
        $search_client_id = null;

    }

    // POST����򥯥ꥢ
    $set_client_data["layer"]       = "";   // �Կ�
    $set_client_data["date_chg"]    = "";   // ?
    $form->setConstants($set_client_data);

}


/****************************/
// ��ʧ��ǧ���̤إܥ��󲡲�����
/****************************/
// ��ʧ��ǧ�ܥ��󲡲����ޤ��ϻ�ʧ�ܥ��󲡲��ե饰��true�ξ��
if ($_POST["confirm_button"] == "��ʧ��ǧ���̤�" || $_POST["payout_flg"] == "true"){

    // ��ʧ�ܥ��󲡲�hidden�򥯥ꥢ
    $clear_hdn["payout_flg"] = "";
    $form->setconstants($clear_hdn);

    // ��׶�۽����
    $sum_pay_mon = 0;
    $sum_pay_fee = 0;

    $ary_input_id_row = null;
    // ���ߤκ����������֤�
    for ($i = 0; $i < $max_row; $i++){
        // ����Ԥ������������ID���������
        if ($ary_client_id[$i] != ""){
            $ary_input_id_row[] = $i;
        }
    }

    // ������ID������ѿ��˥��å�
    $ary_client_id  = $_POST["hdn_client_id"];

    // ����Կ����ѿ��˥��å�
    $max_row        = $_POST["max_row"];

    // ����Կ��ǥ롼��
    for ($key = 0, $row = 0; $key < $max_row; $key++){

        // ���ߤλ��ȹԤ�����������¸�ߤ��ʤ����
        if (!in_array($key, $ary_del_rows)){

            // ���ȹԿ���û�
            $row++;

            // ���դ�0���
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POST�ǡ������ѿ��˥��å�
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];           // ������ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];          // �����襳���ɣ�
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];          // �����襳���ɣ�
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];        // ��ʧ����ǯ��
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];        // ��ʧ���ʷ��
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];        // ��ʧ��������
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];            // �������ά��
            $post_trade[$key]           = $_POST["form_trade_$key"];               // �����ʬ
            $post_bank[$key]            = $_POST["form_bank_$key"];                // ��ԡ���Ź�����¡������
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];             // ��ʧ��
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];             // �����
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];    // �������ǯ��
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];    // ������ʷ��
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];    // �����������
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];          // ��������ֹ�
            $post_note[$key]            = $_POST["form_note_$key"];                // ����

            // ��ʧ�ܥ��󲡲����϶�ۤΥ���޽���
            if ($_POST["payout_flg"] == "true"){
                if ($post_pay_mon[$key] != null){
                    $post_pay_mon[$key] = str_replace(",", "", $post_pay_mon[$key]);
                }
                if ($post_pay_fee[$key] != null){
                    $post_pay_fee[$key] = str_replace(",", "", $post_pay_fee[$key]);
                }
            }

            // ���ϤΤʤ��Ԥ򥫥����
            if ($ary_client_id[$key] == null){
                $null_row += 1;
            }

            /****************************/
            // ��׶�ۻ��Сʽ����ѡ�
            /****************************/
            // ������ID�Τ���ԤΤ�
            if ($ary_client_id[$key] != null){
                $sum_pay_mon += $post_pay_mon[$key];    // ��ʧ���
                $sum_pay_fee += $post_pay_fee[$key];    // �����
            }

            /****************************/
            // ���顼�����å�
            /****************************/
            // ��������
            // ɬ�ܥ����å���
            if ($ary_client_id[$key] == null && ($post_client_cd1[$key] != null || $post_client_cd2[$key] != null)){
                $form->setElementError("form_client_cd1_$key", $row."���ܡ�����������������Ϥ��Ƥ���������");
            }

            // �ʹߡ��������ʳ��Υե���������Ϥ����ä����˥����å���Ԥ�
            if (
                $ary_client_id[$key]        != null ||  // ������ID
                $post_client_cd1[$key]      != null ||  // �����襳���ɣ�
                $post_client_cd2[$key]      != null ||  // �����襳���ɣ�
                $post_pay_mon[$key]         != null ||  // ��ʧ���
                $post_pay_fee[$key]         != null ||  // �����
                $post_account_day_y[$key]   != null ||  // �������ǯ��
                $post_account_day_m[$key]   != null ||  // ������ʷ��
                $post_account_day_d[$key]   != null ||  // �����������
                $post_payable_no[$key]      != null ||  // ��������ֹ�
                $post_note[$key]            != null     // ����
            ){

                // ����ʧ��
                // ɬ�ܥ����å�
                if ($post_pay_day_y[$key] == null && $post_pay_day_m[$key] == null && $post_pay_day_d[$key] == null){
                    $form->setElementError("form_pay_day_$key", $row."���ܡ���ʧ����ɬ�ܤǤ���");
                }else
                // ���ͥ����å�
                if (
                    !ereg("^[0-9]+$", $post_pay_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_d[$key])
                ){
                    $form->setElementError("form_pay_day_$key", $row."���ܡ���ʧ���������ǤϤ���ޤ���");
                }else
                // �����������å�
                if (!checkdate((int)$post_pay_day_m[$key], (int)$post_pay_day_d[$key], (int)$post_pay_day_y[$key])){
                    $form->setElementError("form_pay_day_$key", $row."���ܡ���ʧ���������ǤϤ���ޤ���");
                // ����ʳ�
                }else{
                    // �������������å�
                    if (date("Y-m-d") < $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$$post_pay_day_d[$key]){
                        $form->addElement("text", "err_pay_day_1_$key");
                        $form->setElementError("err_pay_day_1_$key", $row."���ܡ���ʧ����̤������դ����Ϥ���Ƥ��ޤ���");
                    }
                    // �����ƥ೫�����ʹߥ����å�
                    $pay_day_sys_chk[$key] = Sys_Start_Date_Chk($post_pay_day_y[$key], $post_pay_day_m[$key], $post_pay_day_d[$key], "��ʧ��");
                    if ($pay_day_sys_chk[$key] != null){
                        $form->addElement("text", "err_pay_day_2_$key");
                        $form->setElementError("err_pay_day_2_$key", $row."���ܡ�$pay_day_sys_chk[$key]");
                    }
                    // ������ʹߥ����å�
                    if (
                        Check_Monthly_Renew(
                            $db_con,
                            $ary_client_id[$key],
                            "3",
                            $post_pay_day_y[$key],
                            $post_pay_day_m[$key],
                            $post_pay_day_d[$key]
                        ) === false
                    ){
                        $form->addElement("text", "err_pay_day_3_$key");
                        $form->setElementError("err_pay_day_3_$key", $row."���ܡ���ʧ��������η�������������դ����Ϥ���Ƥ��ޤ���");
                    }
                    // ���������ʹߥ����å�
                    if (
                        Check_Payment_Close_Day(
                            $db_con,
                            $ary_client_id[$key],
                            $post_pay_day_y[$key],
                            $post_pay_day_m[$key],
                            $post_pay_day_d[$key]
                        ) === false
                    ){
                        $form->addElement("text", "err_pay_day_4_$key");
                        $form->setElementError("err_pay_day_4_$key", $row."���ܡ���ʧ��������λ��������������դ����Ϥ���Ƥ��ޤ���");
                    }
                }

                // �������ʬ
                // ɬ�ܥ����å�
                if ($post_trade[$key] == null){
                    $form->setElementError("form_trade_$key", $row."���ܡ������ʬ��ɬ�ܤǤ���");
                }

                // �����
                // ������������å�
                if ($post_bank[$key][0] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."���ܡ���Ի�����ϸ����ֹ�ޤǻ��ꤷ�Ƥ���������");
                }else
                // ����դ�ɬ�ܥ����å���
                if (($post_trade[$key] == "43" || $post_trade[$key] == "44") && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."���ܡ�������ʧ�������ʧ���ˤϸ����ֹ����ꤷ�Ƥ���������");
                }else
                // ����դ�ɬ�ܥ����å���
                if ($post_pay_fee[$key] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."���ܡ���������ϻ��϶�Ԥ���ꤷ�Ƥ���������");
                }

                // ����ʧ���
                // ɬ�ܥ����å�
                if ($post_pay_mon[$key] == null){
                    $form->setElementError("form_pay_mon_$key", $row."���ܡ���ʧ��ۤ�ɬ�ܤǤ���");
                }else
                // ���ͥ����å�
                if (!ereg("^[-]?[0-9]+$", $post_pay_mon[$key])){
                    $form->setElementError("form_pay_mon_$key", $row."���ܡ���ʧ��ۤ������ǤϤ���ޤ���");
                }

                // �������
                // ���ͥ����å�
                if ($post_pay_fee[$key] != null && !ereg("^[-]?[0-9]+$", $post_pay_fee[$key])){
                    $form->setElementError("form_pay_fee_$key", $row."���ܡ�������������ǤϤ���ޤ���");
                }

                // �������
                // ̤���ϻ�
                if ($post_account_day_y[$key] == null && $post_account_day_m[$key] == null && $post_account_day_d[$key] == null){
                    if ($post_trade[$key] == "44"){
                        $form->setElementError("form_account_day_$key", $row."���ܡ������ʧ���ˤϷ���������Ϥ��Ƥ���������");
                    }
                }else
                // ���ͥ����å�
                if (
                    !ereg("^[0-9]+$", $post_account_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_d[$key])
                ){
                    $form->setElementError("form_account_day_$key", $row."���ܡ�������������ǤϤ���ޤ���");
                }else
                // �����������å�
                if (!checkdate((int)$post_account_day_m[$key], (int)$post_account_day_d[$key], (int)$post_account_day_y[$key])){
                    $form->setElementError("form_account_day_$key", $row."���ܡ�������������ǤϤ���ޤ���");
                }

            }

        }

    }

    // ���ǡ������ϥ����å�
    if ($row == $null_row){
        $form->addElement("text", "err_no_data");
        $form->setElementError("err_no_data", "��ʧ�ǡ��������Ϥ��Ƥ���������");
    }

    // ����ɼ�ѹ������ɼ�������Ƥ������
    if ($get_flg == "true"){
        $sql  = "SELECT \n";
        $sql .= "   pay_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_payout_h \n";
        $sql .= "WHERE \n";
        $sql .= "   pay_id = $pay_id \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        if ($num == 0){
            header("Location: ./1-3-305.php?err=1");
            exit;
        }
    }

    // ����ɼ�ѹ����������������Ƥ������
    if ($get_flg == "true"){
        $sql  = "SELECT \n";
        $sql .= "   pay_id \n";
        $sql .= "FROM \n";
        $sql .= "   t_payout_h \n";
        $sql .= "WHERE \n";
        $sql .= "   pay_id = $pay_id \n";
        $sql .= "AND \n";
        $sql .= "   renew_flg = 'f' \n";
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $num  = pg_num_rows($res);
        if ($num == 0){
            header("Location: ./1-3-305.php?err=2");
            exit;
        }
    }

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $test = $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;


    /****************************/
    // DB��Ͽ����
    /****************************/
    // ��ʧ�ܥ��󲡲����ܥ��顼�Τʤ����
    if ($_POST["payout_flg"] == "true" && $err_flg != true){

        $ary_input_id_row = null;
        // ���ߤκ����������֤�
        for ($i = 0; $i < $max_row; $i++){
            // ����Ԥ������������ID���������
            if ($ary_client_id[$i] != ""){
                $ary_input_id_row[] = $i;
            }
        }

        // �ȥ�󥶥�����󳫻�
        Db_Query($db_con, "BEGIN;");

        // �����Ƚ��
        foreach ($ary_input_id_row as $key){

            // ���դ�0���
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POST�ǡ������ѿ��˥��å�
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];            // ������ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];           // �����襳���ɣ�
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];           // �����襳���ɣ�
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];         // ��ʧ����ǯ��
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];         // ��ʧ���ʷ��
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];         // ��ʧ��������
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];             // �������ά��
            $post_trade[$key]           = $_POST["form_trade_$key"];                // �����ʬ
            $post_bank[$key]            = $_POST["form_bank_$key"];                 // ��ԡ���Ź�����¡������
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];              // ��ʧ��
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];              // �����
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];     // �������ǯ��
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];     // ������ʷ��
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];     // �����������
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];           // ��������ֹ�
            $post_note[$key]            = $_POST["form_note_$key"];                 // ����

            // ����POST��Ȥ��䤹��
            $post_pay_day[$key]     = $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$post_pay_day_d[$key];
            $post_account_day[$key] = $post_account_day_y[$key]."-".$post_account_day_m[$key]."-".$post_account_day_d[$key];

            // ������ʧ��
            if ($get_flg != "true"){

                // �ǿ��λ�ʧ�ֹ�ܣ�
                $sql  = "SELECT \n";
                $sql .= "   MAX(pay_no) AS max \n";
                $sql .= "FROM \n";
                $sql .= "   t_payout_h \n";
                $sql .= "WHERE \n";
                $sql .= "   shop_id = $shop_id \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                $pay_data    = pg_fetch_array($res);
                $pay_no_max  = $pay_data["max"];
                $pay_no_max += 1;
                $pay_no_max  = str_pad($pay_no_max, 8, "0", STR_PAD_LEFT);

                // ��ʧ�إå�INSERT
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_h \n";
                $sql .= "( \n";
                $sql .= "   pay_id, \n";                // ��ʧID
                $sql .= "   pay_no, \n";                // ��ʧ�ֹ�
                $sql .= "   pay_day, \n";               // ��ʧ��
                $sql .= "   client_id, \n";             // ������ID
                $sql .= "   client_cd1, \n";            // �����襳���ɣ�
                $sql .= "   client_cd2, \n";            // �����襳���ɣ�
                $sql .= "   client_name, \n";           // ������̾��
                $sql .= "   client_name2, \n";          // ������̾��
                $sql .= "   client_cname, \n";          // ������̾ά��
                $sql .= "   input_day, \n";             // ������
                $sql .= "   buy_id, \n";                // ����ID
                $sql .= "   renew_flg, \n";             // ���������ե饰
                $sql .= "   renew_day, \n";             // ����������
                $sql .= "   schedule_payment_id, \n";   // ��ʧͽ��ID
                $sql .= "   shop_id, \n";               // ����å�ID
                $sql .= "   e_staff_id, \n";            // ���ϼ�ID
                $sql .= "   e_staff_name, \n";          // ���ϼ�̾
                $sql .= "   c_staff_id, \n";            // ô����ID
                $sql .= "   c_staff_name, \n";          // ô����̾
                $sql .= "   account_day, \n";           // �����
                $sql .= "   payable_no \n";             // ��������ֹ�
                $sql .= ") \n";
                $sql .= "VALUES \n";
                $sql .= "( \n";
                $sql .= "   (SELECT COALESCE(MAX(pay_id), 0)+1 FROM t_payout_h), \n";
                $sql .= "   '$pay_no_max', \n";
                $sql .= "   '".$post_pay_day[$key]."', \n";
                $sql .= "   ".$post_client_id[$key].", \n";
                $sql .= "   (SELECT client_cd1   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_cd2   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_name  FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_name2 FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   (SELECT client_cname FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   NOW(), \n";
                $sql .= "   NULL, \n";
                $sql .= "   'f', \n";
                $sql .= "   NULL, \n";
                $sql .= "   ( \n";
                $sql .= "       SELECT \n";
                $sql .= "           MAX(schedule_payment_id) \n";
                $sql .= "       FROM \n";
                $sql .= "           t_schedule_payment \n";
                $sql .= "       WHERE \n";
                $sql .= "           payment_expected_date LIKE '".substr($post_pay_day[$key], 0, 7)."%"."' \n";
                $sql .= "       AND \n";
                $sql .= "           t_schedule_payment.client_id = ".$post_client_id[$key]." \n";
                $sql .= "       AND \n";
                $sql .= "           t_schedule_payment.shop_id = $shop_id \n";
                $sql .= "       AND \n";
                $sql .= "           t_schedule_payment.first_set_flg = 'f' ";
                $sql .= "   ), \n";
                $sql .= "   $shop_id, \n";
                $sql .= "   $staff_id, \n";
                $sql .= "   '".addslashes($staff_name)."', \n";
                $sql .= "   $staff_id, \n";
                $sql .= "   '".addslashes($staff_name)."', \n";
                if ($post_account_day[$key] != "--"){
                    $sql .= "   '".$post_account_day[$key]."', \n";
                }else{
                    $sql .= "   NULL, \n";
                }
                $sql .= "   '".addslashes($post_payable_no[$key])."' \n";
                $sql .= ") \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){ 
                    $err_mes = pg_last_error();             // ���顼��å���������
                    $err_format = "t_payout_h_pay_no_key";  // ��ˡ������������̾
                    Db_Query($db_con, "ROLLBACK;");         // ����Хå�
                    // ���顼��å������˥�ˡ������󤬴ޤޤ�Ƥ�����
                    if (strstr($err_mes, $err_format) != false){ 
                        $duplicate_err  = "��ʧ���Ϥ�Ʊ���˹Ԥ�줿���ᡢ��ʧ�ֹ�����֤˼��Ԥ��ޤ�����";
                        $duplicate_flg  = true;             // ���󥨥顼�ե饰��true�򥻥å�
                        $err_flg        = true;
                        break;
                    // ����¾�Υ��顼
                    }else{  
                        exit;                               // ������λ
                    }
                }

            // ��ʧ�ѹ���
            }else{

                // ��ʧ�إå�UPDATE
                $sql  = "UPDATE \n";
                $sql .= "   t_payout_h \n";
                $sql .= "SET \n";
                $sql .= "   client_id    = ".$post_client_id[$key].", \n";
                $sql .= "   client_cd1   = (SELECT client_cd1   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_cd2   = (SELECT client_cd2   FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_name  = (SELECT client_name  FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_name2 = (SELECT client_name2 FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   client_cname = (SELECT client_cname FROM t_client WHERE client_id = ".$post_client_id[$key]."), \n";
                $sql .= "   pay_day      = '".$post_pay_day[$key]."', \n";
                if ($post_account_day[$key] != "--"){
                    $sql .= "   account_day  = '".$post_account_day[$key]."', \n";
                }else{
                    $sql .= "   account_day  = NULL, \n";
                }
                $sql .= "   payable_no   = '".$post_payable_no[$key]."' \n";
                $sql .= "WHERE \n";
                $sql .= "   pay_id = $pay_id \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    break;
                }

                // ��ʧ�ǡ���DELETE
                $sql  = "DELETE FROM \n";
                $sql .= "   t_payout_d \n";
                $sql .= "WHERE \n";
                $sql .= "   pay_id = $pay_id \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    break;
                }

            }

            // �����������/̤���Ϥ˱����ƥ롼�׿�������
            if ($post_pay_fee[$key] == ""){
                $d_insert_cnt = 1;
            }else{
                $d_insert_cnt = 2;
            }

            for ($i = 0; $i < $d_insert_cnt; $i++){

                // ��ʧ�ǡ���INSERT
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_d \n";
                $sql .= "( \n";
                $sql .= "   pay_d_id, \n";          // ��ʧ�ǡ���ID
                $sql .= "   pay_id, \n";            // ��ʧID
                $sql .= "   pay_amount, \n";        // ��ʧ���/�����
                $sql .= "   trade_id, \n";          // �����ʬ
                $sql .= "   bank_name2, \n";        // �������ά��
                $sql .= "   bank_cd, \n";           // ��ԥ�����
                $sql .= "   bank_name, \n";         // ���̾
                $sql .= "   b_bank_cd, \n";         // ��Ź������
                $sql .= "   b_bank_name, \n";       // ��Ź̾
                $sql .= "   account_id, \n";        // ����ID
                $sql .= "   account_no, \n";        // �����ֹ�
                $sql .= "   deposit_kind, \n";      // �¶����
                $sql .= "   note \n";               // ����
                $sql .= ") \n";
                $sql .= "VALUES \n";
                $sql .= "( \n";
                $sql .= "   (SELECT COALESCE(MAX(pay_d_id), 0)+1 FROM t_payout_d),  \n";
                if ($get_flg == "true"){
                    $sql .= "   $pay_id, \n";
                }else{
                    $sql .= "   (SELECT pay_id FROM t_payout_h WHERE pay_no = '$pay_no_max' AND shop_id = $shop_id), \n";
                }
                if ($i == 0){
                    $sql .= "   ".str_replace(",", "", $post_pay_mon[$key]).", \n";
                    $sql .= "   ".$post_trade[$key].", \n";
                }else{
                    $sql .= "   ".str_replace(",", "", $post_pay_fee[$key]).", \n";
                    $sql .= "   48, \n";
                }
                $sql .= "   '".addslashes($post_pay_bank[$key])."', \n";
                if ($post_bank[$key][0] != null){
                    $sql .= "   (SELECT bank_cd      FROM t_bank    WHERE bank_id    = ".$post_bank[$key][0]."), \n";
                    $sql .= "   (SELECT bank_name    FROM t_bank    WHERE bank_id    = ".$post_bank[$key][0]."), \n";
                }else{
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                }
                if ($post_bank[$key][1] != null){
                    $sql .= "   (SELECT b_bank_cd    FROM t_b_bank  WHERE b_bank_id  = ".$post_bank[$key][1]."), \n";
                    $sql .= "   (SELECT b_bank_name  FROM t_b_bank  WHERE b_bank_id  = ".$post_bank[$key][1]."), \n";
                }else{
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                }
                if ($post_bank[$key][2] != null){
                    $sql .= "   ".$post_bank[$key][2].", \n";
                    $sql .= "   (SELECT account_no   FROM t_account WHERE account_id = ".$post_bank[$key][2]."), \n";
                    $sql .= "   (SELECT deposit_kind FROM t_account WHERE account_id = ".$post_bank[$key][2]."), \n";
                }else{
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                    $sql .= "   NULL, \n";
                }
                if ($i == 0){
                    $sql .= "   '".addslashes($post_note[$key])."' \n";
                }else{
                    $sql .= "   NULL \n";
                }
                $sql .= ") \n";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                if ($res === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

            }

        }

        // �ȥ�󥶥������λ
        Db_Query($db_con, "COMMIT;");

        // ��ʣ���顼�ʤ����
        if ($err_flg != true && $duplicate_flg != true){
            // ��λ���̤�����
            header("Location: ./1-3-305.php?flg=".$_POST["get_flg"]."&pay_id=".$pay_id);
            exit;
        }

    }

}


/*****************************/
// �Ȳ���̤�������
/*****************************/
// ���ɽ�����ܻ�ʧID�������GET��������
if ($_POST["post_flg"] == null && $pay_id != null && $get_flg == "true"){

    $henkousyoki_meisai = true;

    // ����������̵ͭ�ˤ�ꡢ��Хǡ������ѹ�
    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";                             // ��ʧID
    $sql .= "   t_payout_h.pay_no, \n";                             // ��ʧ�ֹ�
    $sql .= "   t_payout_h.pay_day, \n";                            // ��ʧ��
    $sql .= "   t_client.client_div, \n";                           // �������ʬ
    $sql .= "   t_payout_h.client_id, \n";                          // ������ID
    $sql .= "   t_client.client_cd1, \n";                           // �����襳���ɣ�
    $sql .= "   t_client.client_cd2, \n";                           // �����襳���ɣ�
    $sql .= "   t_client.client_cname, \n";                         // ������̾
    $sql .= "   t_payout_h.buy_id, \n";                             // ����ID
    $sql .= "   t_payout_d.trade_id, \n";                           // �����ʬID
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // �����ʧͽ���
    $sql .= "   t_payout_d.pay_amount, \n";                         // ��ʧ���
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // �����
    $sql .= "   t_payout_d.bank_name2, \n";                         // �������ά��
    $sql .= "   CAST(t_b_bank.bank_id AS varchar), \n";             // ���ID
    $sql .= "   CAST(t_b_bank.b_bank_id AS varchar), \n";           // ��ŹID
    $sql .= "   CAST(t_payout_d.account_id AS varchar), \n";        // ����ID
    $sql .= "   t_payout_d.note, \n";                               // ����
    $sql .= "   t_payout_h.renew_flg, \n";                          // ���������ե饰
    $sql .= "   t_payout_h.account_day, \n";                        // �����
    $sql .= "   t_payout_h.payable_no \n";                          // ��������ֹ�
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "   LEFT  JOIN t_schedule_payment ON  t_payout_h.schedule_payment_id = t_schedule_payment.schedule_payment_id \n";
    $sql .= "   INNER JOIN t_payout_d         ON  t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "                                 AND t_payout_d.trade_id != 48 \n";
    $sql .= "   INNER JOIN t_client           ON  t_payout_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_payout_d \n";
    $sql .= "           AS t_payout_d_fee     ON  t_payout_h.pay_id = t_payout_d_fee.pay_id \n"; 
    $sql .= "                                 AND t_payout_d_fee.trade_id = 48 \n";
    $sql .= "   LEFT  JOIN t_account          ON  t_account.account_id = t_payout_d.account_id \n";
    $sql .= "   LEFT  JOIN t_b_bank           ON  t_account.b_bank_id = t_b_bank.b_bank_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.pay_id = $pay_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.renew_flg = 'f' \n";

    $sql .= "UNION ALL \n";

    $sql .= "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";                             // ��ʧID
    $sql .= "   t_payout_h.pay_no, \n";                             // ��ʧ�ֹ�
    $sql .= "   t_payout_h.pay_day, \n";                            // ��ʧ��
    $sql .= "   t_client.client_div, \n";                           // �������ʬ
    $sql .= "   t_payout_h.client_id, \n";                          // ������ID
    $sql .= "   t_payout_h.client_cd1, \n";                         // �����襳���ɣ�
    $sql .= "   t_payout_h.client_cd2, \n";                         // �����襳���ɣ�
    $sql .= "   t_payout_h.client_cname, \n";                       // ������̾
    $sql .= "   t_payout_h.buy_id, \n";                             // ����ID
    $sql .= "   t_payout_d.trade_id, \n";                           // �����ʬID
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // �����ʧͽ���
    $sql .= "   t_payout_d.pay_amount, \n";                         // ��ʧ���
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // �����
    $sql .= "   t_payout_d.bank_name2, \n";                         // �������ά��
    $sql .= "   t_payout_d.bank_cd  || '��' || t_payout_d.bank_name, \n";       // ��ԥ����ɡ����̾
    $sql .= "   t_payout_d.b_bank_cd || '��' || t_payout_d.b_bank_name, \n";    // ��Ź�����ɡ���Ź̾
    $sql .= "   CASE t_payout_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '���̡�' || t_payout_d.account_no \n";        // �¶���ܡ������ֹ�
    $sql .= "       WHEN '2' THEN '���¡�' || t_payout_d.account_no \n";
    $sql .= "   END AS account_id, \n";
    $sql .= "   t_payout_d.note, \n";                               // ����
    $sql .= "   t_payout_h.renew_flg, \n";                          // ���������ե饰
    $sql .= "   t_payout_h.account_day, \n";                        // �����
    $sql .= "   t_payout_h.payable_no \n";                          // ��������ֹ�
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "   LEFT  JOIN t_schedule_payment ON  t_payout_h.schedule_payment_id = t_schedule_payment.schedule_payment_id \n";
    $sql .= "   INNER JOIN t_payout_d         ON  t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "                                 AND t_payout_d.trade_id != 48 \n";
    $sql .= "   INNER JOIN t_client           ON  t_payout_h.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_payout_d \n";
    $sql .= "           AS t_payout_d_fee     ON  t_payout_h.pay_id = t_payout_d_fee.pay_id \n";
    $sql .= "                                 AND t_payout_d_fee.trade_id = 48 \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.pay_id = $pay_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.renew_flg = 't' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    $num = pg_num_rows($res);

    // �ǡ�����¸�ߤ�����
    if ($num > 0){

        $refdata = pg_fetch_array($res);

        // �ǡ�������
        $getdata["pay_id"]                  = $refdata["pay_id"];                   // ��ʧID
        $getdata["pay_no"]                  = $refdata["pay_no"];                   // ��ʧ�ֹ�
        $get_pay_day                        = explode("-",$refdata['pay_day']);     // ��ʧ��(�����
        $getdata["form_pay_day_0"]["y"]     = $get_pay_day[0];                      // ǯ
        $getdata["form_pay_day_0"]["m"]     = $get_pay_day[1];                      // ��
        $getdata["form_pay_day_0"]["d"]     = $get_pay_day[2];                      // ��
        $getdata["hdn_client_id"][]         = $refdata["client_id"];                // ������ID
        $get_client_div                     = $refdata["client_div"];               // ������ʬ
        $getdata["form_client_cd1_0"]       = $refdata["client_cd1"];               // �����襳���ɣ�
        if ($get_client_div == "3"){
            $getdata["form_client_cd2_0"]   = $refdata["client_cd2"];               // �����襳���ɣ�
        }
        $getdata["form_client_name_0"]      = $refdata["client_cname"];             // ������̾
        $getdata["form_pay_bank_0"]         = $refdata["bank_name2"];               // �������ά��
        $getdata["form_trade_0"]            = $refdata["trade_id"];                 // �����ʬID
        $get_bank_id                        = $refdata["bank_id"];                  // ���ID OR ��ԥ����ɡܶ��̾
        $get_b_bank_id                      = $refdata["b_bank_id"];                // ��ŹID OR ��Ź�����ɡܻ�Ź̾
        $get_account_id                     = $refdata["account_id"];               // ����ID OR ���¼��ܡܸ����ֹ�
        $getdata["form_note_0"]             = $refdata["note"];                     // ����
        $get_buy_id                         = $refdata['buy_id'];                   // ����ID
        $get_renew_flg                      = $refdata['renew_flg'];                // ���������ե饰

        // �ե꡼������
        // ���������ѡ��ޤ��ϼ�ư��ʧ
        if ($get_renew_flg == "t" || $get_buy_id != null){
            $freeze_flg = true;
        }

        // ��������̤�»ܤ��ļ�ư��ʧ�Ǥʤ����
        if ($get_renew_flg == "f" && $get_buy_id == ""){
            // �ҥ����쥯�ȥե������
            $getdata["form_bank_0"][0]      = $get_bank_id;
            $getdata["form_bank_0"][1]      = $get_b_bank_id;
            $getdata["form_bank_0"][2]      = $get_account_id;
        }else{
            // �꡼�ɥ���꡼�ե������
            $getdata["bank_name_0"]         = $get_bank_id;
            $getdata["b_bank_name_0"]       = $get_b_bank_id;
            $getdata["account_id_0"]        = $get_account_id;
        }

        // �ʥ�С��ե����ޥåȽ���
        // �ե꡼��������
        if($get_renew_flg == "t" || $get_buy_id != ""){
            $getdata["form_pay_mon_0"] = number_format($refdata["pay_amount"]);
            $getdata["form_pay_fee_0"] = ($refdata["fee_amount"] != null) ? number_format($refdata["fee_amount"]) : "";
        // �ե꡼�����ʤ����
        }else{
            $getdata["form_pay_mon_0"] = $refdata["pay_amount"];
            $getdata["form_pay_fee_0"] = $refdata["fee_amount"];
        } 

        if ($refdata["schedule_of_payment_this"] != null){
            $getdata["form_pay_mon_plan_0"] = number_format($refdata['schedule_of_payment_this']);
        }else{
            $getdata["form_pay_mon_plan_0"] = "";
        }

        $get_account_day = explode("-", $refdata["account_day"]);       // �����(�����
        $getdata["form_account_day_0"]["y"] = $get_account_day[0];      // ǯ
        $getdata["form_account_day_0"]["m"] = $get_account_day[1];      // ��
        $getdata["form_account_day_0"]["d"] = $get_account_day[2];      // ��
        $getdata["form_payable_no_0"] = $refdata["payable_no"];         // ��������ֹ�

        // �ѹ������٥ե饰��true�򥻥å�
        $get_flg = "true";
        $getdata["get_flg"] = $get_flg;
        $form->setConstants($getdata);

        // ����Կ��򥻥å�
        $max_row = 1;
        $max_data["max_row"] = $max_row;
        $form->setConstants($max_data);

        $disp_client_id = $refdata["client_id"];

    // �ǡ�����¸�ߤ��ʤ����
    }else{

        header("Location:../top.php");

    }

}


/*****************************/
// �ѥ�����ȥե꡼��
/*****************************/
// ������ʧ��
if (
    $get_flg != "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true))
){

    // �ѥ�����
    $disp_pattern = "1";

}else
// ��ɼ���������ѹ���
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg != "t" && $get_buy_id == null)
){

    // �ѥ�����
    $disp_pattern = "2";

}else
// ��ɼ�����������١�
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg == "t" || $get_buy_id != null)
){

    // �ѥ�����
    $disp_pattern = "3";

    // �ե������ե꡼��
    $form->freeze();

}else
// ��ǧ���̤إܥ��󲡲��ܥ��顼�ʤ�
if ($_POST["confirm_button"] != null && $err_flg != true){

    // �ѥ�����
    $disp_pattern = "4";

    // �ե������ե꡼��
    $form->freeze();

}


/*****************************/
// ������޽���ʥ�С��ե����ޥå�
// ����Ͽ���ʤ��Ԥ��������Ƥ�ä��ʳ�ǧ���̤Τߡ�
/*****************************/
$ary_input_id_row = null;
// ���ߤκ����������֤�
for ($i = 0; $i < $max_row; $i++){
    // ����Ԥ������������ID���������
    if ($ary_client_id[$i] != ""){
        $ary_input_id_row[] = $i;
    }
}

// ����Կ��ǥ롼��
for ($i = 0; $i < $max_row; $i++){

    // �����Ƚ��ܻ����褬�ѹ�����Ƥ��ʤ���
    if (!in_array($i, $ary_del_rows) && $_POST["layer"] !== $i){

        // ����޽���
        // �ե꡼�����ʤ����
        if ($disp_pattern == "1" || $disp_pattern == "2"){
            // �ͤΤ�����Τ�
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = str_replace(",", "", $_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = str_replace(",", "", $_POST["form_pay_fee_$i"]);
            }
        }else

        // �ʥ�С��ե����ޥå�
        // �ե꡼�����Ƥ�����
        if ($disp_pattern == "3" || $disp_pattern == "4"){
            // �ͤΤ�����Τ�
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = number_format($_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = number_format($_POST["form_pay_fee_$i"]);
            }
        }

        // ��ǧ���̤Ǥ���Ͽ���ʤ��Ԥ��������Ƥ�ä�
        // ��ǧ���̻�
        if ($disp_pattern == "4"){
            if (!in_array($i, $ary_input_id_row)){
                $clear_form["hdn_client_id_$i"]         = "";
                $clear_form["form_client_cd1_$i"]       = "";
                $clear_form["form_client_cd2_$i"]       = "";
                $clear_form["form_client_name_$i"]      = "";
                $clear_form["form_pay_bank_$i"]         = "";
                $clear_form["form_pay_day_$i"]["y"]     = "";
                $clear_form["form_pay_day_$i"]["m"]     = "";
                $clear_form["form_pay_day_$i"]["d"]     = "";
                $clear_form["form_trade_$i"]            = "";
                $clear_form["form_bank_$i"][0]          = "";
                $clear_form["form_bank_$i"][1]          = "";
                $clear_form["form_bank_$i"][2]          = "";
                $clear_form["form_pay_mon_plan_$i"]     = "";
                $clear_form["form_pay_mon_$i"]          = "";
                $clear_form["form_pay_fee_$i"]          = "";
                $clear_form["form_account_day_$i"]["y"] = "";
                $clear_form["form_account_day_$i"]["m"] = "";
                $clear_form["form_account_day_$i"]["d"] = "";
                $clear_form["form_payable_no_$i"]       = "";
                $clear_form["form_note_$i"]             = "";
            }
        }
    }
}

// ����޽���ʥ�С��ե����ޥåȴ�Ϣ
$form->setConstants($set_num_format);
// �ե�����ǡ��������Ϣ
$form->setConstants($clear_form);


/*****************************/
// �ե������������ư��
/*****************************/
// ���ֹ楫����
$row_num = 1;

$html_l = null;

// ����Կ��ǥ롼��
for ($i = 0; $i < $max_row; $i++){

    // �����Ƚ��
    if (!in_array($i, $ary_del_rows)){

        // �������
        $del_data = $del_row.",".$i;

        // ������
        $form->addElement("text", "form_client_cd1_$i", "", "
            size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
            onkeyup=\"change_client_cd(this.form, $i);\"
            onChange=\"Change_f2layer(this.form, 'layer', '#$row_num', $i);\"
            $g_form_option
        ");
        $form->addElement("text", "form_client_cd2_$i", "", "
            size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
            onkeyup=\"change_client_cd(this.form, $i);\"
            onChange=\"Change_f2layer(this.form, 'layer', '#$row_num', $i);\"
            $g_form_option
        ");

        $form->addElement("text", "form_client_name_$i", "", "
            size=\"43\"
            style=\"color: #000000; border: #ffffff 1px solid; background-color: #ffffff;\"
            readonly
        ");

        // �������ά��
        $form->addElement("text", "form_pay_bank_$i", "", "
            size=\"20\" maxLength=\"20\"
            style=\"color: #000000; border: #ffffff 1px solid; background-color: #ffffff;\" 
            readonly
        ");

/*
        // ��ʧ��
        $ary_element[0][$i][] =& $form->createElement("text", "y", "", "
            size=\"4\" maxLength=\"4\" $g_form_option class=\"ime_disabled\"
            onkeyup=\"changeText3_row(this.form, $i);\" 
            onChange=\"change_ym(this.form, $i);\"
        ");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "m", "", "
            size=\"1\" maxLength=\"2\" $g_form_option class=\"ime_disabled\"
            onkeyup=\"changeText4_row(this.form, $i);\" 
            onChange=\"change_ym(this.form, $i);\"
        ");
        $ary_element[0][$i][] =& $form->createElement("static", "", "", "-");
        $ary_element[0][$i][] =& $form->createElement("text", "d", "", "
            size=\"1\" maxLength=\"2\" $g_form_option class=\"ime_disabled\"
        ");
        $form->addGroup($ary_element[0][$i], "form_pay_day_$i", "", "");
*/
        Addelement_Date($form, "form_pay_day_$i", "", "-");

        // �����ʬ
        $form->addElement("select", "form_trade_$i", "", $trade_value, $g_form_option_select);

        // ��ԡ���Ź������
        $obj_bank_select =& $form->addElement("hierselect", "form_bank_$i", "", "", "<br>");
        $obj_bank_select->setOptions($bank_value);
 
        // ���̾
        $form->addElement("text", "bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\" 
            readonly
        ");
        // ��Ź̾
        $form->addElement("text", "b_bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");
        // �����ֹ�
        $form->addElement("text", "account_id_$i", "", "
            size=\"20\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");

        // ��ʧͽ���
        $form->addElement("text", "form_pay_mon_plan_$i", "", "
            size=\"11\" maxLength=\"9\" 
            style=\"text-align: right; color: #000000; border: none; background-color: #ffffff;\"
            readonly
        ");

        // ��ʧ���
        $form->addElement("text", "form_pay_mon_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // �����
        $form->addElement("text", "form_pay_fee_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // �����
        Addelement_Date($form, "form_account_day_$i", "�����", "-");

        // ��������ֹ�
        $form->addElement("text", "form_payable_no_$i", "", "size=\"13\" maxLength=\"10\" $g_form_option class=\"ime_disabled\"");

        // ����
        $form->addElement("text", "form_note_$i", "", "size=\"34\" maxLength=\"15\" $g_form_option");

        // ������ʧ��
        if ($disp_pattern == "1"){

            // ��ʧ��ǧ���̤إܥ���
            $form->addElement("submit", "confirm_button", "��ʧ��ǧ���̤�",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true');\" $disabled"
            );

            // ������
            if ($row_num == $max_row - $del_num){
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">���</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row', $row_num-1); return false;\""
                );
            // �ǽ��԰ʳ����������硢�������Ԥ�Ʊ��No.�ιԤ˹�碌��
            }else{
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">���</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row', $row_num  ); return false;\""
                );
            }

        }else
        // ��ɼ���������ѹ���
        if ($disp_pattern == "2"){

            // ��ʧ��ǧ���̤إܥ���
            $form->addElement("submit", "confirm_button", "��ʧ��ǧ���̤�",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true');\" $disabled"
            );

        }else
        // ��ɼ�����������١�
        if ($disp_pattern == "3"){

            // ���ܥ���
            $form->addElement("button", "back_btn", "�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("payout")."'\"");

        }else
        // ��ǧ���̻�
        if ($disp_pattern == "4"){

            // ��ʧ�ܥ���
            $form->addElement("button", "payout_button", "�١�ʧ",
                "onClick=\"Dialogue_2('��ʧ���ޤ���', '#', 'true', 'payout_flg'); return false;\" $disabled"
            );

            // ���ܥ���
            $form->addElement("submit", "back_btn", "�ᡡ��", "onClick=\"Button_Submit_1('confirm_flg', '#', 'false');\"");

            // ��׶��
            $form->addElement("text","sum_mon", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

            // ��׼����
            $form->addElement("text", "sum_fee", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

        }

        // ������ID
        $form->addElement("hidden","hdn_client_id[$i]");

        // ��ʧͽ��ID
        $form->addElement("hidden","schedule_payment_id[$i]");


        /****************************/
        // ������ID�ξ��ּ���
        /****************************/
        // �����������
        if ($_POST["layer"] == "$i"){
            $client_state_print[$i] = Get_Client_State($db_con, $search_client_id);
        }else   
        // �ѹ����̽���������ٲ��̻�
        if ($henkousyoki_meisai == true){
            $client_state_print[$i] = Get_Client_State($db_con, $disp_client_id);
        // ����¾
        }else{  
            $client_state_print[$i] = Get_Client_State($db_con, $_POST["hdn_client_id"][$i]);
        }


        /****************************/
        //ɽ����HTML����
        /****************************/
        $html_l .= "    <tr class=\"Result1\">\n";

        // ���ڡ�������
        $html_l .= "        <A NAME=\"$row_num\"></A>\n";

        // ����No.
        $html_l .= "        <td align=\"right\">$row_num</td>\n";

        // �������襳���ɣ�
        // �������襳���ɣ�
        // ���ʸ�����
        // ��������̾
        // ���������ά��
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_client_cd1_$i"]]->toHtml());
        // �ѹ������ٲ��̡ܻ������ʬ��������ξ��ʻ������ʬ��������ˤʤäƤ������Ƥ���ɼ�������������졢����ɽ������뤳�Ȥ������
        if ($get_flg == "true" && $get_client_div == "2"){
            // �ʤ�
        }else{
        $html_l .=              "-".($form->_elements[$form->_elementIndex["form_client_cd2_$i"]]->toHtml())."\n";
        }
        if ($disp_pattern == "1" || $disp_pattern == "2"){
        $html_l .=              "��<a href=\"#\" onClick=\"return Open_SubWin_2('../dialog/1-0-302.php', ";
        $html_l .=              "Array('form_client_cd1_$i', 'form_client_cd2_$i','form_client_name_$i','hdn_client_id[$i]','div_flg', 'layer'), ";
        $html_l .=              "600, 450, 3, $i, $i, $row_num);\">����</a>��\n";
        }
        $html_l .=              " ".$client_state_print[$i];
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_client_name_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_bank_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ����ʧ��
        $html_l .= "        <td align=\"center\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_day_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // �������ʬ
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_trade_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // �����
        $html_l .= "        <td>\n";
        if ($disp_pattern == "1" || $disp_pattern == "2"){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml())."\n";
        }else
        if ($disp_pattern == "3"){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["bank_name_$i"]]->toHtml())."\n";
        $html_l .= "            <br>";
        $html_l .= "            &nbsp;".($form->_elements[$form->_elementIndex["b_bank_name_$i"]]->toHtml())."\n";
        $html_l .= "            <br>";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["account_id_$i"]]->toHtml())."\n";
        $html_l .= "            <br>";
        }else
        if ($disp_pattern == "4"){
            // �����������褬���򤵤�Ƥ���ܶ�Ԥ����򤵤�Ƥ�����Τ�ɽ������
            if ($_POST["form_bank_$i"][0] != null){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml())."\n";
            }
        }
        $html_l .= "        </td>\n";

        // ����ʧͽ���
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_plan_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ����ʧ�����
        // �������
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_fee_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ����������ֹ�
        // �������
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_account_day_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_payable_no_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ������
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_note_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ��������
        if ($disp_pattern == "1"){
        $html_l .= "        <td align=\"center\" class=\"Title_Add\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_del_row_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";
        }
        $html_l .= "    </tr>\n";

        // ���ֹ�û�
        $row_num++;

    }

}


/****************************/
// JavaScript
/****************************/
$js = "
function change_client_cd(me, num){
    var cd1 = \"form_client_cd1_\"+num;
    var cd2 = \"form_client_cd2_\"+num;
    len = me.elements[cd1].value.length;
    if(6 == len){
        me.elements[cd2].focus();
    }
}

function change_ym(form, layer){

    var yinput = \"form_pay_day_\"+layer+\"[y]\";
    var minput = \"form_pay_day_\"+layer+\"[m]\";
    var row    = layer + 1;

    if (form.elements[yinput].value.length == 4 && form.elements[minput].value.length >= 1){
        form.elements[\"layer\"].value = layer;
        form.elements[\"form_pay_mon_\"+layer].value = \"\";
        form.elements[\"date_chg\"].value = true;
        document.dateForm.target=\"_self\";
        document.dateForm.action=\"".$_SERVER["PHP_SELF"]."#\"+row+\"\";
        document.dateForm.submit();
    }

}

function changeText3_row(me,num){
    var Y = \"form_pay_day_\"+num+\"[y]\";
    var M = \"form_pay_day_\"+num+\"[m]\";
    len = me.elements[Y].value.length;
    if (4 == len){
        me.elements[M].focus();
    }
}

function changeText4_row(me,num){
    var M = \"form_pay_day_\"+num+\"[m]\";
    var D = \"form_pay_day_\"+num+\"[d]\";
    len = me.elements[M].value.length;
    if (2 <= len){
        me.elements[D].focus();
    }
}

function Change_f2layer(form, hidden, url, num){

    var hdn     = hidden;
    var hla     = \"hdn_client_id[\"+num+\"]\";
    var fla     = \"form_client_cd1_\"+num;
    var fla2    = \"form_client_cd2_\"+num;
    var fla_v   = form.elements[fla].value;
    var fla2_v  = form.elements[fla2].value;

    if (fla_v.length == 6 && fla2_v.length == 4){
        form.elements[hdn].value = num;
        form.elements[\"form_pay_mon_\"+num].value = '';
        form.elements[\"form_pay_fee_\"+num].value = '';
        form.target=\"_self\";
        form.action=url;
        form.submit();
    }else
    if(form.elements[hla].value != ''){
        form.elements['layer'].value = num;
        form.elements[\"form_pay_mon_\"+num].value = '';
        form.elements[\"form_pay_fee_\"+num].value = '';
        form.target=\"_self\";
        form.action=url;
        form.submit();
    }

}
";


/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼����
/****************************/
//$page_menu = Create_Menu_h("buy", "3");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    // ����
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",

    // html
    "html_l"            => "$html_l",
    "js"                => "$js",

    // �ե饰��Ϣ
    "confirm_flg"       => "$confirm_flg",
    "get_flg"           => "$get_flg",
    "get_renew_flg"     => "$get_renew_flg",
    "disp_pattern"      => "$disp_pattern",

    // ��۹�ס������ǹ��
    "sum_pay_mon"       => "$sum_pay_mon",
    "sum_pay_fee"       => "$sum_pay_fee",

    // ��ʧ�ֹ��ʣ���顼��å�����
    "duplicate_err"     => "$duplicate_err",
));

// ���顼��assign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
