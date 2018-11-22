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
 *  2016/01/19                  amano  Dialogue_2, Dialogue_3, Button_Submit_1 �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "��ʧ����";

// �Ķ�����ե����� env setting file
require_once("ENV_local.php");

// HTML_QuickForm����� create 
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³ connect 
$db_con = Db_Connect();

// ���¥����å� auth check
$auth   = Auth_Check($db_con);

// �ܥ���Disabled button
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*****************************/
// ���������SESSION�˥��å� set the the page that will be transitioned back to SESSION
/*****************************/
// GET��POST��̵����� if there is no GET and POST
if ($_GET == null && $_POST == null && $_SESSION["schedule_payment_id"] == null){
    Set_Rtn_Page("payout");
}


/****************************/
// �����ѿ����� acquire external variable
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];
$group_kind = $_SESSION['group_kind'];


/****************************/
// ��ʧID�μ�갷�� use of payment ID
/****************************/
// ��ʧID��POST����Ƥ����� if the payment ID is being POST
if ($_POST["pay_id"] != null){

    // POST�λ�ʧID���ѿ���hidden�˥��å� set the POST's payment ID in the variable and hidden
    $pay_id             = $_POST["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ���åȥե饰true���ѿ���hidden�˥��å� set the get flag true in variable and in hidden
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// GET�˻�ʧID�������� if there is a payment ID in GET
if ($_GET["pay_id"] != null){

    // GET������ʧID�������������å� check the validity of the payment ID that was GET
    $safe_flg = Get_Id_Check_Db($db_con, $_GET["pay_id"], "pay_id", "t_payout_h", "num", "shop_id = $shop_id");
    if ($safe_flg === false){
        header("Location:../top.php");
        exit;
    }

    // GET�λ�ʧID���ѿ���hidden�˥��å� set the GET's payment ID in variable and in hidden
    $pay_id             = $_GET["pay_id"];
    $set_hdn["pay_id"]  = $pay_id;

    // ���åȥե饰true���ѿ���hidden�˥��å� set the get flag true in variable and in hidden
    $get_flg            = "true";
    $set_hdn["get_flg"] = $get_flg;

}else
// POST��GET�˻�ʧID���ʤ���� if there is no payment ID in POST and GET
if ($_POST["pay_id"] == null && $_GET["pay_id"] == null){

    // ���åȥե饰false���ѿ���hidden�˥��å� set the get flag false in variable and in hidden
    $get_flg             = "";
    $set_hdn["get_flg"]  = $get_flg;

}

$form->setConstants($set_hdn);


/****************************/
// ������� initial setting
/****************************/
// ɽ���Կ� no of rows being displayed
if (isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}


/****************************/
// �Կ��ɲ� add row number
/****************************/
if ($_POST["add_row_flg"]== "true"){
    // ����Ԥˡ��ܣ����� +5 in the max row
    $max_row = $_POST["max_row"] + 5;
    // �Կ��ɲåե饰�򥯥ꥢ clear the add row flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}


/****************************/
// �Ժ������ delete row process
/****************************/
if (isset($_POST["del_row"])){
    // ����ꥹ�Ȥ���� acquire the delete list
    $del_row = $_POST["del_row"];
    // ������������ˤ��롣 make array of delete history
    $ary_del_rows = explode(",", $del_row);
    unset($ary_del_rows[0]);
}else{
    // �����������ν���ͺ��� create initial value of delete history array
    $ary_del_rows = array();
}


/***************************/
// ��������� inital value setting
/***************************/
// ���ߤκ���Կ���hidden�˥��å� set the current max row number in hidden
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

// ��ʧ���ʰ������� payment date (set all at once)
$setdate["form_pay_day_all"]["y"] = date("Y");
$setdate["form_pay_day_all"]["m"] = date("m");
$setdate["form_pay_day_all"]["d"] = date("d");
$form->setDefaults($setdate);


/****************************/
// �ե���������ʸ���� create form (fixed)
/****************************/
// �إå�����󥯥ܥ��� header link button
$ary_h_btn_list = array("�Ȳ��ѹ�" => "./1-3-303.php", "������" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);

// ��ʧ���ʰ������� payment (set all at once)
Addelement_Date($form, "form_pay_day_all", "", "-");

// �����ʬ�ʰ������� trade classification (set all at once)
$trade_value = Select_Get($db_con, "trade_payout");
unset($trade_value[48]);
unset($trade_value[49]);
$form->addElement("select", "form_trade_all", "", $trade_value, $g_form_option_select);

// ��ԡʰ�������bank (set all at once)
$bank_value = Make_Ary_Bank($db_con);
$obj    =   null;
$obj    =&  $form->addElement("hierselect", "form_bank_all", "", "", " ");
$obj->setOptions($bank_value);

// �������ܥ��� set all at once button
$form->addElement("button", "all_set_button", "�������", "onClick=\"javascript: Button_Submit_1('all_set_flg', '#', 'true', this);\"");

// ���ɲåܥ��� add row button
$form->addElement("button", "add_row_button", "���ɲ�", "onClick=\"javascript: Button_Submit_1('add_row_flg', '#foot', 'true', this);\"");

// hidden
$form->addElement("hidden", "del_row");         // ����� delete row
$form->addElement("hidden", "add_row_flg");     // �ɲùԥե饰 add row flag
$form->addElement("hidden", "max_row");         // ����Կ� max row number
$form->addElement("hidden", "layer");           // ����� trade partner
$form->addElement("hidden", "div_flg");         // ������ʬ trade classification
$form->addElement("hidden", "get_flg");         // �ѹ������١ʻ�ʧ�Ȳ񤫤�˥ե饰 change/detaik(from the payment inquiry)
$form->addElement("hidden", "pay_id");          // ��ʧID payment ID
$form->addElement("hidden", "pay_no");          // ��ʧ�ֹ� payment number 
$form->addelement("hidden", "all_set_flg");     // �������ե饰 set all at once flag
$form->addElement("hidden", "payout_flg");      // ��ʧ�ܥ��󲡲��ե饰 payment button pressed flag
$form->addElement("hidden", "date_chg");        // �����ѹ����֥ߥåȥե饰 change date submit flag
$form->addElement("hidden", "confirm_flg");     // ��ǧ���̤إܥ��󲡲��ե饰 flag for when To confirmation screen is pressed
$form->addElement("hidden", "post_flg", "1");   // ���ɽ��Ƚ���ѥե饰 flag for determining initial display


/****************************/
// ���������� set all at once process
/****************************/
if($_POST["all_set_flg"] == "true"){

    // ��ʧ���ʰ��ˤ�0��� fill payment date (all at once) with 0s
    $_POST["form_pay_day_all"]   = Str_Pad_Date($_POST["form_pay_day_all"]);
    $all_set["form_pay_day_all"] = $_POST["form_pay_day_all"];

    for ($i = 0; $i < $_POST["max_row"]; $i++){
        // ��ʧ�� payment date
        $all_set["form_pay_day_$i"]["y"]    = ($_POST["form_pay_day_all"]["y"] != "") ? $_POST["form_pay_day_all"]["y"] : "";
        $all_set["form_pay_day_$i"]["m"]    = ($_POST["form_pay_day_all"]["m"] != "") ? $_POST["form_pay_day_all"]["m"] : "";
        $all_set["form_pay_day_$i"]["d"]    = ($_POST["form_pay_day_all"]["d"] != "") ? $_POST["form_pay_day_all"]["d"] : "";
        // �����ʬ trade classification
        $all_set["form_trade_$i"]           = $_POST["form_trade_all"];
        // ��� bank
        $all_set["form_bank_$i"][0]         = $_POST["form_bank_all"][0];
        $all_set["form_bank_$i"][1]         = $_POST["form_bank_all"][1];
        $all_set["form_bank_$i"][2]         = $_POST["form_bank_all"][2];
    }

    // �������hidden set all at once setting hidden
    $all_set["all_set_flg"] = "";

    $form->setConstants($all_set);

}


/****************************/
// �����襳���ɡ���ʧǯ�����Ͻ��� supplier code/payment date input process
/****************************/
// �����оݹ��ֹ椬������ if there is a row number to be processed
if ($_POST["layer"] != ""){

    $row            = $_POST["layer"];                  // ���ֹ� row number 
    $supplier_cd    = $_POST["form_client_cd1_$row"];   // �����襳���ɣ� supplier code 1
    $supplier_cd2   = $_POST["form_client_cd2_$row"];   // �����襳���ɣ� supplier code 2
    $div_select     = "3";                              // �����衦FC��������ʬ suppler/FC/trade classification

    // FC��ʬ�λ��������sql sql that extract FC classification`s supplier 
    $sql  = "SELECT \n";
    $sql .= "   t_client.client_id, \n";       // ������ID supplier ID
    $sql .= "   t_client.client_cd1, \n";      // �����襳���ɣ� supplier code 1
    $sql .= "   t_client.client_cd2, \n";      // �����襳���ɣ� supplier code 2
    $sql .= "   t_client.client_cname, \n";    // ������̾ supplier name
    $sql .= "   t_client.b_bank_name \n";      // ��������ά�� abbreviation for the deposti account
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

    // �����褬¸�ߤ����� if there is a supplier
    if ($num > 0){

        $get_data = pg_fetch_array($res);

        $set_client_data["hdn_client_id"][$row]     = $get_data["client_id"];       // ������ID supplier ID
        $set_client_data["form_client_cd1_$row"]    = $get_data["client_cd1"];      // �����襳���ɣ� supplier code 1
        $set_client_data["form_client_cd2_$row"]    = $get_data["client_cd2"];      // �����襳���ɣ� supplier code 2
        $set_client_data["form_client_name_$row"]   = $get_data["client_cname"];    // ������̾ supplier name
        $set_client_data["form_pay_bank_$row"]      = $get_data["b_bank_name"];     // ��������ά�� abbrevication for the deposit account

        // ������ID���ѿ��˥��å� set the supplier ID to variable
        $search_client_id = $get_data["client_id"];

        // �ǿ��λ�ʧ��ۤ���� acquire the latest payment amount
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

        // ͽ��ۥ쥳���ɤ������� if there is a planned amount record
        if (pg_num_rows($res) > 0){
            $get_pay_mon = pg_fetch_result($res, 0, 0);
        // ͽ��ۥ쥳���ɤʤ��ξ�� if there is no planned amount record
        }else{
            $get_pay_mon = "";
        }

        // ��ۥ��å� set the amount
        if ($get_pay_mon != ""){
        $set_client_data["form_pay_mon_plan_$row"]  = number_format($get_pay_mon);  // ��ʧͽ��ۡʥʥ�С��ե����ޥåȡ�planned payment amount (number format)
        }else{
        $set_client_data["form_pay_mon_plan_$row"]  = $get_pay_mon;                 // ��ʧͽ��� planned payment amount
        }
        $set_client_data["form_pay_mon_$row"]       = $get_pay_mon;                 // ��ʧ�� payment amount
        $set_client_data["form_pay_fee_$row"]       = "";                           // ����� fee

    // �����褬¸�ߤ��ʤ���� if there is no supplier
    }else{

        $set_client_data["hdn_client_id"][$row]     = "";
        $set_client_data["form_client_name_$row"]   = "";
        $set_client_data["form_pay_bank_$row"]      = "";
        $set_client_data["form_pay_mon_plan_$row"]  = "";
        $set_client_data["form_pay_mon_$row"]       = "";
        $set_client_data["form_pay_fee_$row"]       = "";
        $search_client_id = null;

    }

    // POST����򥯥ꥢ clear the POST info
    $set_client_data["layer"]       = "";   // �Կ� row number
    $set_client_data["date_chg"]    = "";   // ?
    $form->setConstants($set_client_data);

}


/****************************/
// ��ʧ��ǧ���̤إܥ��󲡲����� process when the payment confirmation screen button is pressed
/****************************/
// ��ʧ��ǧ�ܥ��󲡲����ޤ��ϻ�ʧ�ܥ��󲡲��ե饰��true�ξ�� if the flag for when payment confirmation button or payment button is pressed is true
if ($_POST["confirm_button"] == "��ʧ��ǧ���̤�" || $_POST["payout_flg"] == "true"){

    // ��ʧ�ܥ��󲡲�hidden�򥯥ꥢ clear the pressed flag for payment button 
    $clear_hdn["payout_flg"] = "";
    $form->setconstants($clear_hdn);

    // ��׶�۽���� initialize the total amount
    $sum_pay_mon = 0;
    $sum_pay_fee = 0;

    $ary_input_id_row = null;
    // ���ߤκ����������֤� repeat for the current max digits
    for ($i = 0; $i < $max_row; $i++){
        // ����Ԥ������������ID��������� create an array of supplier ID excluding the blank rows
        if ($ary_client_id[$i] != ""){
            $ary_input_id_row[] = $i;
        }
    }

    // ������ID������ѿ��˥��å� set the supplier ID array to variable
    $ary_client_id  = $_POST["hdn_client_id"];

    // ����Կ����ѿ��˥��å� set the max row number to variable
    $max_row        = $_POST["max_row"];

    // ����Կ��ǥ롼�� loop throught the max row number
    for ($key = 0, $row = 0; $key < $max_row; $key++){

        // ���ߤλ��ȹԤ�����������¸�ߤ��ʤ���� if the current reference row does not exist in the deleted row array
        if (!in_array($key, $ary_del_rows)){

            // ���ȹԿ���û� add the reference row number
            $row++;

            // ���դ�0��� fill the date with 0s
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POST�ǡ������ѿ��˥��å� set the POST data to variable
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];           // ������ID supplier ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];          // �����襳���ɣ� supplier code 1
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];          // �����襳���ɣ� supplier code 2
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];        // ��ʧ����ǯ�� payment date year
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];        // ��ʧ���ʷ�� payment date month
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];        // ��ʧ�������� payment date day
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];            // �������ά�� deposit bank abbreviation
            $post_trade[$key]           = $_POST["form_trade_$key"];               // �����ʬ trade classification
            $post_bank[$key]            = $_POST["form_bank_$key"];                // ��ԡ���Ź�����¡������ bank, branch, account (array)
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];             // ��ʧ�� payment amount
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];             // ����� fee
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];    // �������ǯ��settlement date year
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];    // ������ʷ��settlement date month
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];    // �����������settlement date day
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];          // ��������ֹ� bill number
            $post_note[$key]            = $_POST["form_note_$key"];                // ���� remark

            // ��ʧ�ܥ��󲡲����϶�ۤΥ���޽��� take out the comma in the amount when the payment button is pressed
            if ($_POST["payout_flg"] == "true"){
                if ($post_pay_mon[$key] != null){
                    $post_pay_mon[$key] = str_replace(",", "", $post_pay_mon[$key]);
                }
                if ($post_pay_fee[$key] != null){
                    $post_pay_fee[$key] = str_replace(",", "", $post_pay_fee[$key]);
                }
            }

            // ���ϤΤʤ��Ԥ򥫥���� count the row with no input
            if ($ary_client_id[$key] == null){
                $null_row += 1;
            }

            /****************************/
            // ��׶�ۻ��Сʽ����ѡ� comput the total amount (for output)
            /****************************/
            // ������ID�Τ���ԤΤ� rows that have supplier ID
            if ($ary_client_id[$key] != null){
                $sum_pay_mon += $post_pay_mon[$key];    // ��ʧ��� payment amount
                $sum_pay_fee += $post_pay_fee[$key];    // ����� fee
            }

            /****************************/
            // ���顼�����å� error check
            /****************************/
            // �������� supplier
            // ɬ�ܥ����å��� required field 1
            if ($ary_client_id[$key] == null && ($post_client_cd1[$key] != null || $post_client_cd2[$key] != null)){
                $form->setElementError("form_client_cd1_$key", $row."���ܡ�����������������Ϥ��Ƥ���������");
            }

            // �ʹߡ��������ʳ��Υե���������Ϥ����ä����˥����å���Ԥ� from here, check only if forms that have no all at once setting had inputs
            if (
                $ary_client_id[$key]        != null ||  // ������ID supplier Id
                $post_client_cd1[$key]      != null ||  // �����襳���ɣ� supplier code 1
                $post_client_cd2[$key]      != null ||  // �����襳���ɣ� supplier code 2
                $post_pay_mon[$key]         != null ||  // ��ʧ��� payment amount
                $post_pay_fee[$key]         != null ||  // ����� fee
                $post_account_day_y[$key]   != null ||  // �������ǯ�� settlement date year
                $post_account_day_m[$key]   != null ||  // ������ʷ�� settlement date month
                $post_account_day_d[$key]   != null ||  // ����������� settlement date day
                $post_payable_no[$key]      != null ||  // ��������ֹ� bill number 
                $post_note[$key]            != null     // ���� remarks
            ){

                // ����ʧ�� payment date
                // ɬ�ܥ����å� required field
                if ($post_pay_day_y[$key] == null && $post_pay_day_m[$key] == null && $post_pay_day_d[$key] == null){
                    $form->setElementError("form_pay_day_$key", $row."���ܡ���ʧ����ɬ�ܤǤ���");
                }else
                // ���ͥ����å� check value
                if (
                    !ereg("^[0-9]+$", $post_pay_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_pay_day_d[$key])
                ){
                    $form->setElementError("form_pay_day_$key", $row."���ܡ���ʧ���������ǤϤ���ޤ���");
                }else
                // �����������å� check validity
                if (!checkdate((int)$post_pay_day_m[$key], (int)$post_pay_day_d[$key], (int)$post_pay_day_y[$key])){
                    $form->setElementError("form_pay_day_$key", $row."���ܡ���ʧ���������ǤϤ���ޤ���");
                // ����ʳ� other than that
                }else{
                    // �������������å� check if its a date previous than today
                    if (date("Y-m-d") < $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$$post_pay_day_d[$key]){
                        $form->addElement("text", "err_pay_day_1_$key");
                        $form->setElementError("err_pay_day_1_$key", $row."���ܡ���ʧ����̤������դ����Ϥ���Ƥ��ޤ���");
                    }
                    // �����ƥ೫�����ʹߥ����å� check if it is a day that was after the system started
                    $pay_day_sys_chk[$key] = Sys_Start_Date_Chk($post_pay_day_y[$key], $post_pay_day_m[$key], $post_pay_day_d[$key], "��ʧ��");
                    if ($pay_day_sys_chk[$key] != null){
                        $form->addElement("text", "err_pay_day_2_$key");
                        $form->setElementError("err_pay_day_2_$key", $row."���ܡ�$pay_day_sys_chk[$key]");
                    }
                    // ������ʹߥ����å� check if it is after monthly update
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
                    // ���������ʹߥ����å� check if it is after supply closing date
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

                // �������ʬ trade classification
                // ɬ�ܥ����å� required field
                if ($post_trade[$key] == null){
                    $form->setElementError("form_trade_$key", $row."���ܡ������ʬ��ɬ�ܤǤ���");
                }

                // ����� bank
                // ������������å� check the *select all* 
                if ($post_bank[$key][0] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."���ܡ���Ի�����ϸ����ֹ�ޤǻ��ꤷ�Ƥ���������");
                }else
                // ����դ�ɬ�ܥ����å��� required filed check with condition 1
                if (($post_trade[$key] == "43" || $post_trade[$key] == "44") && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."���ܡ�������ʧ�������ʧ���ˤϸ����ֹ����ꤷ�Ƥ���������");
                }else
                // ����դ�ɬ�ܥ����å��� required filed check with condition 2
                if ($post_pay_fee[$key] != null && $post_bank[$key][2] == null){
                    $form->setElementError("form_bank_$key", $row."���ܡ���������ϻ��϶�Ԥ���ꤷ�Ƥ���������");
                }

                // ����ʧ��� payment amount
                // ɬ�ܥ����å� required field
                if ($post_pay_mon[$key] == null){
                    $form->setElementError("form_pay_mon_$key", $row."���ܡ���ʧ��ۤ�ɬ�ܤǤ���");
                }else
                // ���ͥ����å� value check
                if (!ereg("^[-]?[0-9]+$", $post_pay_mon[$key])){
                    $form->setElementError("form_pay_mon_$key", $row."���ܡ���ʧ��ۤ������ǤϤ���ޤ���");
                }

                // ������� fee
                // ���ͥ����å� value check
                if ($post_pay_fee[$key] != null && !ereg("^[-]?[0-9]+$", $post_pay_fee[$key])){
                    $form->setElementError("form_pay_fee_$key", $row."���ܡ�������������ǤϤ���ޤ���");
                }

                // ������� settlement date
                // ̤���ϻ� if not inputted
                if ($post_account_day_y[$key] == null && $post_account_day_m[$key] == null && $post_account_day_d[$key] == null){
                    if ($post_trade[$key] == "44"){
                        $form->setElementError("form_account_day_$key", $row."���ܡ������ʧ���ˤϷ���������Ϥ��Ƥ���������");
                    }
                }else
                // ���ͥ����å� value check
                if (
                    !ereg("^[0-9]+$", $post_account_day_y[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_m[$key]) ||
                    !ereg("^[0-9]+$", $post_account_day_d[$key])
                ){
                    $form->setElementError("form_account_day_$key", $row."���ܡ�������������ǤϤ���ޤ���");
                }else
                // �����������å� validty check
                if (!checkdate((int)$post_account_day_m[$key], (int)$post_account_day_d[$key], (int)$post_account_day_y[$key])){
                    $form->setElementError("form_account_day_$key", $row."���ܡ�������������ǤϤ���ޤ���");
                }

            }

        }

    }

    // ���ǡ������ϥ����å� data input check
    if ($row == $null_row){
        $form->addElement("text", "err_no_data");
        $form->setElementError("err_no_data", "��ʧ�ǡ��������Ϥ��Ƥ���������");
    }

    // ����ɼ�ѹ������ɼ�������Ƥ������ if the slip was deleted while the slip was edited
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

    // ����ɼ�ѹ����������������Ƥ������ if daily update was done while the slip was edited
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
    // ���顼�����å���̽��� collect error check result
    /****************************/
    // �����å�Ŭ�� apply check
    $test = $form->validate();

    // ��̤�ե饰�� flag the result
    $err_flg = (count($form->_errors) > 0) ? true : false;


    /****************************/
    // DB��Ͽ���� registration process
    /****************************/
    // ��ʧ�ܥ��󲡲����ܥ��顼�Τʤ���� when payment button is pressed and if there is no error
    if ($_POST["payout_flg"] == "true" && $err_flg != true){

        $ary_input_id_row = null;
        // ���ߤκ����������֤� repeat through the current max digits
        for ($i = 0; $i < $max_row; $i++){
            // ����Ԥ������������ID��������� create an array of supplier ID without the blank rows
            if ($ary_client_id[$i] != ""){
                $ary_input_id_row[] = $i;
            }
        }

        // �ȥ�󥶥�����󳫻� start the transaction
        Db_Query($db_con, "BEGIN;");

        // �����Ƚ�� determine the delete row
        foreach ($ary_input_id_row as $key){

            // ���դ�0��� fill the dates with 0s
            $_POST["form_pay_day_$key"]     = Str_Pad_Date($_POST["form_pay_day_$key"]);
            $_POST["form_account_day_$key"] = Str_Pad_Date($_POST["form_account_day_$key"]);

            // POST�ǡ������ѿ��˥��å� set the POST data in variable
            $post_client_id[$key]       = $_POST["hdn_client_id"][$key];            // ������ID supplier ID
            $post_client_cd1[$key]      = $_POST["form_client_cd1_$key"];           // �����襳���ɣ� supplier code 1
            $post_client_cd2[$key]      = $_POST["form_client_cd2_$key"];           // �����襳���ɣ� supplier code 2
            $post_pay_day_y[$key]       = $_POST["form_pay_day_$key"]["y"];         // ��ʧ����ǯ�� payment date year
            $post_pay_day_m[$key]       = $_POST["form_pay_day_$key"]["m"];         // ��ʧ���ʷ��payment date month
            $post_pay_day_d[$key]       = $_POST["form_pay_day_$key"]["d"];         // ��ʧ��������payment date dau
            $post_pay_bank[$key]        = $_POST["form_pay_bank_$key"];             // �������ά�� deposit bank abbreviation
            $post_trade[$key]           = $_POST["form_trade_$key"];                // �����ʬ trade classifcaiton
            $post_bank[$key]            = $_POST["form_bank_$key"];                 // ��ԡ���Ź�����¡������ bank, branch, account (arryu)
            $post_pay_mon[$key]         = $_POST["form_pay_mon_$key"];              // ��ʧ�� paymet
            $post_pay_fee[$key]         = $_POST["form_pay_fee_$key"];              // ����� fee
            $post_account_day_y[$key]   = $_POST["form_account_day_$key"]["y"];     // �������ǯ��settlement date year
            $post_account_day_m[$key]   = $_POST["form_account_day_$key"]["m"];     // ������ʷ��settlement date month
            $post_account_day_d[$key]   = $_POST["form_account_day_$key"]["d"];     // �����������settlement date dau
            $post_payable_no[$key]      = $_POST["form_payable_no_$key"];           // ��������ֹ� bill number
            $post_note[$key]            = $_POST["form_note_$key"];                 // ���� remarks

            // ����POST��Ȥ��䤹�� to make it easy to use the date POST
            $post_pay_day[$key]     = $post_pay_day_y[$key]."-".$post_pay_day_m[$key]."-".$post_pay_day_d[$key];
            $post_account_day[$key] = $post_account_day_y[$key]."-".$post_account_day_m[$key]."-".$post_account_day_d[$key];

            // ������ʧ�� if its a new payment
            if ($get_flg != "true"){

                // �ǿ��λ�ʧ�ֹ�ܣ� new payment number plus 1
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

                // ��ʧ�إå�INSERT INSERT the payment header
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_h \n";
                $sql .= "( \n";
                $sql .= "   pay_id, \n";                // ��ʧID payment ID
                $sql .= "   pay_no, \n";                // ��ʧ�ֹ� payment number
                $sql .= "   pay_day, \n";               // ��ʧ�� payment date
                $sql .= "   client_id, \n";             // ������ID supplier ID
                $sql .= "   client_cd1, \n";            // �����襳���ɣ� supplier code 1
                $sql .= "   client_cd2, \n";            // �����襳���ɣ� supplier code 2
                $sql .= "   client_name, \n";           // ������̾�� supplier name 1
                $sql .= "   client_name2, \n";          // ������̾�� supplier name  2
                $sql .= "   client_cname, \n";          // ������̾ά�� supplier name abbreviation
                $sql .= "   input_day, \n";             // ������ input date
                $sql .= "   buy_id, \n";                // ����ID supplier ID
                $sql .= "   renew_flg, \n";             // ���������ե饰 daily update flag
                $sql .= "   renew_day, \n";             // ���������� daily update date
                $sql .= "   schedule_payment_id, \n";   // ��ʧͽ��ID planned payment ID
                $sql .= "   shop_id, \n";               // ����å�ID shop ID
                $sql .= "   e_staff_id, \n";            // ���ϼ�ID entrant ID
                $sql .= "   e_staff_name, \n";          // ���ϼ�̾ entrant name 
                $sql .= "   c_staff_id, \n";            // ô����ID staff ID
                $sql .= "   c_staff_name, \n";          // ô����̾ staff name
                $sql .= "   account_day, \n";           // ����� settlement date
                $sql .= "   payable_no \n";             // ��������ֹ� bill number
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
                    $err_mes = pg_last_error();             // ���顼��å��������� acquire error message
                    $err_format = "t_payout_h_pay_no_key";  // ��ˡ������������̾ unique restriction's restriction name
                    Db_Query($db_con, "ROLLBACK;");         // ����Хå� rollback
                    // ���顼��å������˥�ˡ������󤬴ޤޤ�Ƥ����� if the uniqeu restraint was included in the error message
                    if (strstr($err_mes, $err_format) != false){ 
                        $duplicate_err  = "��ʧ���Ϥ�Ʊ���˹Ԥ�줿���ᡢ��ʧ�ֹ�����֤˼��Ԥ��ޤ�����";
                        $duplicate_flg  = true;             // ���󥨥顼�ե饰��true�򥻥å� set the restriction error flag to true
                        $err_flg        = true;
                        break;
                    // ����¾�Υ��顼 other errors
                    }else{  
                        exit;                               // ������λ force end
                    }
                }

            // ��ʧ�ѹ��� when payment is edited
            }else{

                // ��ʧ�إå�UPDATE UPDATE payment header
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

                // ��ʧ�ǡ���DELETE payment data DELETE
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

            // �����������/̤���Ϥ˱����ƥ롼�׿������� set the nunmber of loops depending on the fee inputted or not inputted
            if ($post_pay_fee[$key] == ""){
                $d_insert_cnt = 1;
            }else{
                $d_insert_cnt = 2;
            }

            for ($i = 0; $i < $d_insert_cnt; $i++){

                // ��ʧ�ǡ���INSERT INSERT the payment data
                $sql  = "INSERT INTO \n";
                $sql .= "   t_payout_d \n";
                $sql .= "( \n";
                $sql .= "   pay_d_id, \n";          // ��ʧ�ǡ���ID payment data ID
                $sql .= "   pay_id, \n";            // ��ʧID payment ID
                $sql .= "   pay_amount, \n";        // ��ʧ���/����� payment amount/fee
                $sql .= "   trade_id, \n";          // �����ʬ trade classification
                $sql .= "   bank_name2, \n";        // �������ά�� deposit bank abbreviation
                $sql .= "   bank_cd, \n";           // ��ԥ����� bank code
                $sql .= "   bank_name, \n";         // ���̾ bank name
                $sql .= "   b_bank_cd, \n";         // ��Ź������ branch code
                $sql .= "   b_bank_name, \n";       // ��Ź̾branch name
                $sql .= "   account_id, \n";        // ����ID account ID
                $sql .= "   account_no, \n";        // �����ֹ� account number
                $sql .= "   deposit_kind, \n";      // �¶���� deposit type
                $sql .= "   note \n";               // ���� remarks
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

        // �ȥ�󥶥������λ finish transaction
        Db_Query($db_con, "COMMIT;");

        // ��ʣ���顼�ʤ���� if there is no duplication error
        if ($err_flg != true && $duplicate_flg != true){
            // ��λ���̤����� transition to process complete screen
            header("Location: ./1-3-305.php?flg=".$_POST["get_flg"]."&pay_id=".$pay_id);
            exit;
        }

    }

}


/*****************************/
// �Ȳ���̤������� if it transitioned from the inquuiry (list) page
/*****************************/
// ���ɽ�����ܻ�ʧID�������GET�������� if there is a initial display, with payment id, and GET
if ($_POST["post_flg"] == null && $pay_id != null && $get_flg == "true"){

    $henkousyoki_meisai = true;

    // ����������̵ͭ�ˤ�ꡢ��Хǡ������ѹ� edit the extracted data depending if it was daily updated or not
    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_id, \n";                             // ��ʧID payment ID
    $sql .= "   t_payout_h.pay_no, \n";                             // ��ʧ�ֹ� payment number
    $sql .= "   t_payout_h.pay_day, \n";                            // ��ʧ�� payment date
    $sql .= "   t_client.client_div, \n";                           // �������ʬ supplier classification
    $sql .= "   t_payout_h.client_id, \n";                          // ������ID supplier ID
    $sql .= "   t_client.client_cd1, \n";                           // �����襳���ɣ� supplier code 1 
    $sql .= "   t_client.client_cd2, \n";                           // �����襳���ɣ� supllier code 2
    $sql .= "   t_client.client_cname, \n";                         // ������̾ supplier name 
    $sql .= "   t_payout_h.buy_id, \n";                             // ����ID supplier ID
    $sql .= "   t_payout_d.trade_id, \n";                           // �����ʬID trade classification Id
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // �����ʧͽ��� payment planned amount this time
    $sql .= "   t_payout_d.pay_amount, \n";                         // ��ʧ��� payment amount 
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // ����� fee
    $sql .= "   t_payout_d.bank_name2, \n";                         // �������ά�� deposit bank abbreviaiton
    $sql .= "   CAST(t_b_bank.bank_id AS varchar), \n";             // ���ID bank ID
    $sql .= "   CAST(t_b_bank.b_bank_id AS varchar), \n";           // ��ŹID brnach ID
    $sql .= "   CAST(t_payout_d.account_id AS varchar), \n";        // ����ID account Id
    $sql .= "   t_payout_d.note, \n";                               // ���� remarks
    $sql .= "   t_payout_h.renew_flg, \n";                          // ���������ե饰 daily update flag
    $sql .= "   t_payout_h.account_day, \n";                        // ����� settlement date
    $sql .= "   t_payout_h.payable_no \n";                          // ��������ֹ� bill number
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
    $sql .= "   t_payout_h.pay_id, \n";                             // ��ʧID payment ID
    $sql .= "   t_payout_h.pay_no, \n";                             // ��ʧ�ֹ� payment number
    $sql .= "   t_payout_h.pay_day, \n";                            // ��ʧ�� payment date
    $sql .= "   t_client.client_div, \n";                           // �������ʬ supplier classifcaiton
    $sql .= "   t_payout_h.client_id, \n";                          // ������ID supplier ID
    $sql .= "   t_payout_h.client_cd1, \n";                         // �����襳���ɣ� supplier code 1
    $sql .= "   t_payout_h.client_cd2, \n";                         // �����襳���ɣ� supplier code 2
    $sql .= "   t_payout_h.client_cname, \n";                       // ������̾ supplier name
    $sql .= "   t_payout_h.buy_id, \n";                             // ����ID supplier ID
    $sql .= "   t_payout_d.trade_id, \n";                           // �����ʬID trade classification ID
    $sql .= "   t_schedule_payment.schedule_of_payment_this, \n";   // �����ʧͽ��� this time's planned payment amount 
    $sql .= "   t_payout_d.pay_amount, \n";                         // ��ʧ��� payment amount 
    $sql .= "   t_payout_d_fee.pay_amount AS fee_amount, \n";       // ����� fee
    $sql .= "   t_payout_d.bank_name2, \n";                         // �������ά�� deposit bank abbreviation
    $sql .= "   t_payout_d.bank_cd  || '��' || t_payout_d.bank_name, \n";       // ��ԥ����ɡ����̾ bank code: bank name
    $sql .= "   t_payout_d.b_bank_cd || '��' || t_payout_d.b_bank_name, \n";    // ��Ź�����ɡ���Ź̾ branch code: branch name
    $sql .= "   CASE t_payout_d.deposit_kind \n";
    $sql .= "       WHEN '1' THEN '���̡�' || t_payout_d.account_no \n";        // �¶���ܡ������ֹ� deposit type: account number
    $sql .= "       WHEN '2' THEN '���¡�' || t_payout_d.account_no \n";
    $sql .= "   END AS account_id, \n";
    $sql .= "   t_payout_d.note, \n";                               // ���� remark
    $sql .= "   t_payout_h.renew_flg, \n";                          // ���������ե饰 daily update flag
    $sql .= "   t_payout_h.account_day, \n";                        // ����� settlement date
    $sql .= "   t_payout_h.payable_no \n";                          // ��������ֹ� bill number
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

    // �ǡ�����¸�ߤ����� if there is data
    if ($num > 0){

        $refdata = pg_fetch_array($res);

        // �ǡ������� acquire data
        $getdata["pay_id"]                  = $refdata["pay_id"];                   // ��ʧID payment Id
        $getdata["pay_no"]                  = $refdata["pay_no"];                   // ��ʧ�ֹ� payment number
        $get_pay_day                        = explode("-",$refdata['pay_day']);     // ��ʧ��(����� payment date array
        $getdata["form_pay_day_0"]["y"]     = $get_pay_day[0];                      // ǯ year
        $getdata["form_pay_day_0"]["m"]     = $get_pay_day[1];                      // �� month
        $getdata["form_pay_day_0"]["d"]     = $get_pay_day[2];                      // �� day
        $getdata["hdn_client_id"][]         = $refdata["client_id"];                // ������ID supplier ID
        $get_client_div                     = $refdata["client_div"];               // ������ʬ trade classifcation
        $getdata["form_client_cd1_0"]       = $refdata["client_cd1"];               // �����襳���ɣ� supplier code 1
        if ($get_client_div == "3"){
            $getdata["form_client_cd2_0"]   = $refdata["client_cd2"];               // �����襳���ɣ� supplier code 2
        }
        $getdata["form_client_name_0"]      = $refdata["client_cname"];             // ������̾ supplier name
        $getdata["form_pay_bank_0"]         = $refdata["bank_name2"];               // �������ά�� deposit bank abbreviation
        $getdata["form_trade_0"]            = $refdata["trade_id"];                 // �����ʬID trade classification Id
        $get_bank_id                        = $refdata["bank_id"];                  // ���ID OR ��ԥ����ɡܶ��̾ bank ID or bank code+bank name
        $get_b_bank_id                      = $refdata["b_bank_id"];                // ��ŹID OR ��Ź�����ɡܻ�Ź̾ branch Id or branch code+branch name
        $get_account_id                     = $refdata["account_id"];               // ����ID OR ���¼��ܡܸ����ֹ� account ID or account type+ account number
        $getdata["form_note_0"]             = $refdata["note"];                     // ���� remarks 
        $get_buy_id                         = $refdata['buy_id'];                   // ����ID supplier ID
        $get_renew_flg                      = $refdata['renew_flg'];                // ���������ե饰 dailyup update flag

        // �ե꡼������ set freeze
        // ���������ѡ��ޤ��ϼ�ư��ʧ if it iwas dailyupdated or if it is an automatic payment
        if ($get_renew_flg == "t" || $get_buy_id != null){
            $freeze_flg = true;
        }

        // ��������̤�»ܤ��ļ�ư��ʧ�Ǥʤ���� if its not a daily update and not automatic payment
        if ($get_renew_flg == "f" && $get_buy_id == ""){
            // �ҥ����쥯�ȥե������ to here select form
            $getdata["form_bank_0"][0]      = $get_bank_id;
            $getdata["form_bank_0"][1]      = $get_b_bank_id;
            $getdata["form_bank_0"][2]      = $get_account_id;
        }else{
            // �꡼�ɥ���꡼�ե������ to readonly form
            $getdata["bank_name_0"]         = $get_bank_id;
            $getdata["b_bank_name_0"]       = $get_b_bank_id;
            $getdata["account_id_0"]        = $get_account_id;
        }

        // �ʥ�С��ե����ޥåȽ��� number format process
        // �ե꡼�������� if it will freeze
        if($get_renew_flg == "t" || $get_buy_id != ""){
            $getdata["form_pay_mon_0"] = number_format($refdata["pay_amount"]);
            $getdata["form_pay_fee_0"] = ($refdata["fee_amount"] != null) ? number_format($refdata["fee_amount"]) : "";
        // �ե꡼�����ʤ���� if it wont freeze
        }else{
            $getdata["form_pay_mon_0"] = $refdata["pay_amount"];
            $getdata["form_pay_fee_0"] = $refdata["fee_amount"];
        } 

        if ($refdata["schedule_of_payment_this"] != null){
            $getdata["form_pay_mon_plan_0"] = number_format($refdata['schedule_of_payment_this']);
        }else{
            $getdata["form_pay_mon_plan_0"] = "";
        }

        $get_account_day = explode("-", $refdata["account_day"]);       // �����(����� settlement date array
        $getdata["form_account_day_0"]["y"] = $get_account_day[0];      // ǯ year
        $getdata["form_account_day_0"]["m"] = $get_account_day[1];      // �� month
        $getdata["form_account_day_0"]["d"] = $get_account_day[2];      // �� day
        $getdata["form_payable_no_0"] = $refdata["payable_no"];         // ��������ֹ� bill number

        // �ѹ������٥ե饰��true�򥻥å� set edit/detail flag to true
        $get_flg = "true";
        $getdata["get_flg"] = $get_flg;
        $form->setConstants($getdata);

        // ����Կ��򥻥å� set the max row number 
        $max_row = 1;
        $max_data["max_row"] = $max_row;
        $form->setConstants($max_data);

        $disp_client_id = $refdata["client_id"];

    // �ǡ�����¸�ߤ��ʤ���� if there is no data
    }else{

        header("Location:../top.php");

    }

}


/*****************************/
// �ѥ�����ȥե꡼�� patter and freeze
/*****************************/
// ������ʧ�� if its a new payment
if (
    $get_flg != "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true))
){

    // �ѥ����� pattern
    $disp_pattern = "1";

}else
// ��ɼ���������ѹ��� when slip was acquired (edit)
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg != "t" && $get_buy_id == null)
){

    // �ѥ����� pattern
    $disp_pattern = "2";

}else
// ��ɼ�����������١�  when slip was acquired (detail)
if (
    $get_flg == "true" && 
    ($_POST["confirm_button"] == null || ($_POST["confirm_button"] != null && $err_flg == true)) &&
    ($get_renew_flg == "t" || $get_buy_id != null)
){

    // �ѥ����� pattern
    $disp_pattern = "3";

    // �ե������ե꡼�� freeze the form
    $form->freeze();

}else
// ��ǧ���̤إܥ��󲡲��ܥ��顼�ʤ� when the to confirmation screen is button is pressed and there is no error
if ($_POST["confirm_button"] != null && $err_flg != true){

    // �ѥ����� pattern
    $disp_pattern = "4";

    // �ե������ե꡼�� freeze the form
    $form->freeze();

}


/*****************************/
// ������޽���ʥ�С��ե����ޥå� delete comma, number format
// ����Ͽ���ʤ��Ԥ��������Ƥ�ä��ʳ�ǧ���̤Τߡ�delete the input detail of the rows that will not be registered (only in the confirmation screen)
/*****************************/
$ary_input_id_row = null;
// ���ߤκ����������֤� repeat with the current max digit
for ($i = 0; $i < $max_row; $i++){
    // ����Ԥ������������ID��������� create an array of supplier ID without the blank row
    if ($ary_client_id[$i] != ""){
        $ary_input_id_row[] = $i;
    }
}

// ����Կ��ǥ롼�� loop throught the max rows 
for ($i = 0; $i < $max_row; $i++){

    // �����Ƚ��ܻ����褬�ѹ�����Ƥ��ʤ��� rows with delete decision not made and supplier not edited
    if (!in_array($i, $ary_del_rows) && $_POST["layer"] !== $i){

        // ����޽��� delete comma 
        // �ե꡼�����ʤ���� if it wont freeze
        if ($disp_pattern == "1" || $disp_pattern == "2"){
            // �ͤΤ�����Τ� if there is a value
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = str_replace(",", "", $_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = str_replace(",", "", $_POST["form_pay_fee_$i"]);
            }
        }else

        // �ʥ�С��ե����ޥå� number format
        // �ե꡼�����Ƥ����� if it is freeze
        if ($disp_pattern == "3" || $disp_pattern == "4"){
            // �ͤΤ�����Τ� only if there is a value
            if ($_POST["form_pay_mon_$i"] != null){
                $set_num_format["form_pay_mon_$i"] = number_format($_POST["form_pay_mon_$i"]);
            }
            if ($_POST["form_pay_fee_$i"] != null){
                $set_num_format["form_pay_fee_$i"] = number_format($_POST["form_pay_fee_$i"]);
            }
        }

        // ��ǧ���̤Ǥ���Ͽ���ʤ��Ԥ��������Ƥ�ä� in the confirmation screen delete the input detail that wil notbe registered
        // ��ǧ���̻� in thye confirmation screen
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

// ����޽���ʥ�С��ե����ޥåȴ�Ϣ comma deletion and number format related stuff
$form->setConstants($set_num_format);
// �ե�����ǡ��������Ϣ form data delete related stuff
$form->setConstants($clear_form);


/*****************************/
// �ե������������ư�� create form (fluctuate)
/*****************************/
// ���ֹ楫���� row number counter
$row_num = 1;

$html_l = null;

// ����Կ��ǥ롼�� loop through the max row number
for ($i = 0; $i < $max_row; $i++){

    // �����Ƚ�� determine the deletion row
    if (!in_array($i, $ary_del_rows)){

        // ������� delete history
        $del_data = $del_row.",".$i;

        // ������ supplier
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

        // �������ά�� deposit bank abbreviation
        $form->addElement("text", "form_pay_bank_$i", "", "
            size=\"20\" maxLength=\"20\"
            style=\"color: #000000; border: #ffffff 1px solid; background-color: #ffffff;\" 
            readonly
        ");

/*
        // ��ʧ�� payment date
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

        // �����ʬ trade classifciation
        $form->addElement("select", "form_trade_$i", "", $trade_value, $g_form_option_select);

        // ��ԡ���Ź������ bank, branch, account
        $obj_bank_select =& $form->addElement("hierselect", "form_bank_$i", "", "", "<br>");
        $obj_bank_select->setOptions($bank_value);
 
        // ���̾ bank name
        $form->addElement("text", "bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\" 
            readonly
        ");
        // ��Ź̾ branch name
        $form->addElement("text", "b_bank_name_$i", "", "
            size=\"32\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");
        // �����ֹ� account number
        $form->addElement("text", "account_id_$i", "", "
            size=\"20\"
            style=\"color: #000000; border: none; backgrount-color: #ffffff;\"
            readonly
        ");

        // ��ʧͽ��� planned payment amount
        $form->addElement("text", "form_pay_mon_plan_$i", "", "
            size=\"11\" maxLength=\"9\" 
            style=\"text-align: right; color: #000000; border: none; background-color: #ffffff;\"
            readonly
        ");

        // ��ʧ��� payment amount
        $form->addElement("text", "form_pay_mon_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // ����� fee
        $form->addElement("text", "form_pay_fee_$i", "", "
            class=\"money\" size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"
        ");

        // ����� settlemetn date
        Addelement_Date($form, "form_account_day_$i", "�����", "-");

        // ��������ֹ� bill number
        $form->addElement("text", "form_payable_no_$i", "", "size=\"13\" maxLength=\"10\" $g_form_option class=\"ime_disabled\"");

        // ���� remarks
        $form->addElement("text", "form_note_$i", "", "size=\"34\" maxLength=\"15\" $g_form_option");

        // ������ʧ�� when new payment
        if ($disp_pattern == "1"){

            // ��ʧ��ǧ���̤إܥ��� *to payment confirmation screen* button
            $form->addElement("submit", "confirm_button", "��ʧ��ǧ���̤�",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true', this);\" $disabled"
            );

            // ������ delete link
            if ($row_num == $max_row - $del_num){
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">���</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row', $row_num-1, this); return false;\""
                );
            // �ǽ��԰ʳ����������硢�������Ԥ�Ʊ��No.�ιԤ˹�碌�� match with the row number that will be deleted unless it is the las row
            }else{
                $form->addElement("link", "form_del_row_$i", "", "#", "<font color=\"#fefefe\">���</font>",
                    "TABINDEX=-1 onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row', $row_num, this  ); return false;\""
                );
            }

        }else
        // ��ɼ���������ѹ��� when slip is acquired (edit)
        if ($disp_pattern == "2"){

            // ��ʧ��ǧ���̤إܥ��� *go to payment screen confirmation* button
            $form->addElement("submit", "confirm_button", "��ʧ��ǧ���̤�",
                "onClick=\"Button_Submit_1('confirm_flg', '#', 'true', this);\" $disabled"
            );

        }else
        // ��ɼ�����������١� when slip is acquired (detail)
        if ($disp_pattern == "3"){

            // ���ܥ��� back button
            $form->addElement("button", "back_btn", "�ᡡ��", "onClick=\"location.href='".Make_Rtn_Page("payout")."'\"");

        }else
        // ��ǧ���̻� when in the confirmation screen 
        if ($disp_pattern == "4"){

            // ��ʧ�ܥ��� payment button
            $form->addElement("button", "payout_button", "�١�ʧ",
                "onClick=\"Dialogue_2('��ʧ���ޤ���', '#', 'true', 'payout_flg', this); return false;\" $disabled"
            );

            // ���ܥ��� back button
            $form->addElement("submit", "back_btn", "�ᡡ��", "onClick=\"Button_Submit_1('confirm_flg', '#', 'false', this);\"");

            // ��׶�� total amount
            $form->addElement("text","sum_mon", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

            // ��׼���� total fee
            $form->addElement("text", "sum_fee", "", "
                size=\"11\"
                style=\"color: #000000; border: none; background-color: transparent; text-align: right;\" 
                readonly
            ");

        }

        // ������ID supplier ID
        $form->addElement("hidden","hdn_client_id[$i]");

        // ��ʧͽ��ID planned payment ID
        $form->addElement("hidden","schedule_payment_id[$i]");


        /****************************/
        // ������ID�ξ��ּ��� acquire the supplier ID status
        /****************************/
        // ����������� when a supplier is selected 
        if ($_POST["layer"] == "$i"){
            $client_state_print[$i] = Get_Client_State($db_con, $search_client_id);
        }else   
        // �ѹ����̽���������ٲ��̻� first of edit screen, and also detail screen 
        if ($henkousyoki_meisai == true){
            $client_state_print[$i] = Get_Client_State($db_con, $disp_client_id);
        // ����¾ others
        }else{  
            $client_state_print[$i] = Get_Client_State($db_con, $_POST["hdn_client_id"][$i]);
        }


        /****************************/
        //ɽ����HTML���� for creation of display HTML
        /****************************/
        $html_l .= "    <tr class=\"Result1\">\n";

        // ���ڡ������� link in the page
        $html_l .= "        <A NAME=\"$row_num\"></A>\n";

        // ����No. row number
        $html_l .= "        <td align=\"right\">$row_num</td>\n";

        // �������襳���ɣ� supplier code 1
        // �������襳���ɣ� supplier code 2
        // ���ʸ����� search
        // ��������̾ supplier name
        // ���������ά�� deposti bank abbreviation
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_client_cd1_$i"]]->toHtml());
        // �ѹ������ٲ��̡ܻ������ʬ��������ξ��ʻ������ʬ��������ˤʤäƤ������Ƥ���ɼ�������������졢����ɽ������뤳�Ȥ������edit, detail screen,+ if the supplier classification is "supplier" (the assumption is that all slips that has *supplier* in their supplier classfication is daily updated, and that their detail will be displayed)
        if ($get_flg == "true" && $get_client_div == "2"){
            // �ʤ� none
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

        // ����ʧ�� pament date
        $html_l .= "        <td align=\"center\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_day_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // �������ʬ trade classification
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_trade_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ����� bank
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
            // �����������褬���򤵤�Ƥ���ܶ�Ԥ����򤵤�Ƥ�����Τ�ɽ������ only display if the correct sypplier is chosen + bank is being selected
            if ($_POST["form_bank_$i"][0] != null){
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_bank_$i"]]->toHtml())."\n";
            }
        }
        $html_l .= "        </td>\n";

        // ����ʧͽ��� planned payment amount
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_plan_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // ����ʧ����� payment amount
        // ������� fee
        $html_l .= "        <td align=\"right\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_mon_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_pay_fee_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ����������ֹ� bill number
        // ������� settlement date
        $html_l .= "        <td>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_account_day_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_payable_no_$i"]]->toHtml())."\n";
        $html_l .= "            <br>\n";
        $html_l .= "        </td>\n";

        // ������ remarks
        $html_l .= "        <td align=\"left\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_note_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";

        // �������� delete link
        if ($disp_pattern == "1"){
        $html_l .= "        <td align=\"center\" class=\"Title_Add\">\n";
        $html_l .= "            ".($form->_elements[$form->_elementIndex["form_del_row_$i"]]->toHtml())."\n";
        $html_l .= "        </td>\n";
        }
        $html_l .= "    </tr>\n";

        // ���ֹ�û� add row number
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
// HTML�إå� html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå� footer
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼���� create menu
/****************************/
//$page_menu = Create_Menu_h("buy", "3");

/****************************/
// ���̥إå������� create screen header
/****************************/
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign assign form related setting
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign assign other variables
$smarty->assign("var", array(
    // ���� common
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",

    // html
    "html_l"            => "$html_l",
    "js"                => "$js",

    // �ե饰��Ϣ flag related
    "confirm_flg"       => "$confirm_flg",
    "get_flg"           => "$get_flg",
    "get_renew_flg"     => "$get_renew_flg",
    "disp_pattern"      => "$disp_pattern",

    // ��۹�ס������ǹ�� amount total, vat total
    "sum_pay_mon"       => "$sum_pay_mon",
    "sum_pay_fee"       => "$sum_pay_fee",

    // ��ʧ�ֹ��ʣ���顼��å����� payment number duplicatyion error message
    "duplicate_err"     => "$duplicate_err",
)); 

// ���顼��assign assign error
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
