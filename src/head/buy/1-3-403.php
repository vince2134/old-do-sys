<?php

/*
 *  ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-05-07      -           fukuda      ��������̤�»���ɼ����Ф���褦����
 *  2010-04-27      -           hashimoto-y CSV���ϵ�ǽ���ɲá�Rev.1.5��
 *   2016/01/22                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б� 
 * 
 */

// �ڡ���̾ page name
$page_title = "�����踵Ģ";

// �Ķ�����ե����� env seeting file
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_motocho.inc");

// HTML_QuickForm����� create
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³ db connect
$db_con = Db_Connect();


/****************************/
// ���´�Ϣ���� set auth related process
/****************************/
$auth   = Auth_Check($db_con);


/****************************/
// �����ѿ����� acquire external variables
/****************************/


/****************************/
// ������� initial setting
/****************************/
// ɽ�������null�ξ��������display items (if null then all items)
$range = null;

// ������ʬ��2: ������ 3: FC�� trade classification (purchase client: 2 FC:2)
// ������ʬ�ڤ��ؤ�ľ��ξ��if its right after the change in trade classification
if ($_POST["post_client_div"] != null){
    $client_div = $_POST["post_client_div"];
// ����ʳ� other than that
}else{
    $client_div = ($_POST["hdn_client_div"] != null) ? $_POST["hdn_client_div"] : "3";
}

/****************************/
// ������ʬ�ڤ��ؤ��� when trade classification is changed
/****************************/
if ($_POST["post_client_div"] != null){

    // ������ʬ��POST�ѡˤ������ʬ����¸�ѡˤ˥��å� set the trade classification (For POST) in trade classification (FOR SAVE)
    $set_form["hdn_client_div"]     = $_POST["post_client_div"];

    // ������Υե������ͤȻ�����˴ؤ���hidden�򥯥ꥢ clear the form value in the purchase client and the hidden related with purchase client
    $set_form["form_client[cd1]"]   = ""; 
    $set_form["form_client[cd2]"]   = ""; 
    $set_form["form_client[name]"]  = ""; 
    $set_form["hdn_client[cd1]"]    = ""; 
    $set_form["hdn_client[cd2]"]    = ""; 
    $set_form["hdn_client[name]"]   = ""; 
    $set_form["hdn_client_id"]      = "";
    $set_form["hdn_close_day"]      = "";
    $set_form["hdn_pay_m"]          = "";
    $set_form["hdn_pay_d"]          = "";

    // ������ʬ��POST�ѡˤ򥯥ꥢ clear the trade classification (for post)
    $set_form["post_client_div"]    = "";

    $form->setConstants($set_form);

}


/****************************/
// ���ꥢ�ܥ��󲡲������� process when clear button is pressed
/****************************/
if ($_POST["hdn_clear_flg"] == "true"){

    #2010-04-28 hashimoto-y
    #���߻���������ؤϻ��Ѥ��Ƥʤ��ΤǸ����ͣ��򥻥åȤ��� 
    // ������ʬ���� set the trade classification
    #$client_div = $_POST["hdn_client_div"];
    $client_div = 3;

    // ���ꥢ�ե饰 clear flag
    $set_form["hdn_clear_flg"]      = "";

    // �����踡���ե饰 customer search flag
    $set_form["client_search_flg"]  = "";

    // �ե����� form
    $set_form["form_count_day[sy]"] = "";
    $set_form["form_count_day[sm]"] = "";
    $set_form["form_count_day[sd]"] = "";
    $set_form["form_count_day[ey]"] = "";
    $set_form["form_count_day[em]"] = "";
    $set_form["form_count_day[ed]"] = "";
    $set_form["form_client[cd1]"]   = ""; 
    $set_form["form_client[cd2]"]   = ""; 
    $set_form["form_client[name]"]  = ""; 

    #2010-04-27 hashimoto-y
    $set_form["form_output"]  = "1"; 

    // �ե������hidden�� form
    $set_form["hdn_client[cd1]"]    = ""; 
    $set_form["hdn_client[cd2]"]    = ""; 
    $set_form["hdn_client[name]"]   = ""; 
    $set_form["hdn_count_day[sy]"]  = "";
    $set_form["hdn_count_day[sm]"]  = "";
    $set_form["hdn_count_day[sd]"]  = "";
    $set_form["hdn_count_day[ey]"]  = "";
    $set_form["hdn_count_day[em]"]  = "";
    $set_form["hdn_count_day[ed]"]  = "";

    #2010-04-27 hashimoto-y
    $set_form["hdn_output"]         = "";

    // �����������¸��hidden��save purchase client info (hidden)
    $set_form["hdn_client_id"]      = "";
    $set_form["hdn_close_day"]      = "";
    $set_form["hdn_pay_m"]          = "";
    $set_form["hdn_pay_d"]          = "";

    $form->setConstants($set_form);

    // POST�򥢥󥻥å� unset the POST
    unset($_POST);

}


/****************************/
// �ե�����ѡ������ define the form parts
/****************************/
#2010-04-27 hashimoto-y
// ���Ϸ��� output format
$radio = "";
$radio[] =& $form->createElement("radio", null, null, "����", "1");
#2010-04-19 hashimoto-y
#$radio[] =& $form->createElement("radio", null, null, "Ģɼ", "2");
#$radio[] =& $form->createElement("radio", null, null, "CSV",  "3");
$radio[] =& $form->createElement("radio", null, null, "CSV",  "2");

$form->addGroup($radio, "form_output", "");


// ���״��� aggregate period
Addelement_Date_Range($form, "form_count_day", "���״���", "-");

// �������� purchase client link
if ($client_div == "3"){
    $form->addElement("link", "form_client_link", "", "#", "FC�������",
        "onClick=\"javascript:return Open_SubWin('../dialog/1-0-250.php',
         Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]'), 500, 450, '3-403', 1)\""
    );
}else{
    $form->addElement("link", "form_client_link", "", "#", "������",
        "onClick=\"javascript:return Open_SubWin('../dialog/1-0-208.php',
         Array('form_client[cd1]', 'form_client[name]'), 500, 450, 5, 1)\""
    );
}

// ������ purchase client
$text = "";
if ($client_div == "3"){
    $text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onChange=\"javascript:Change_Submit('client_search_flg','#','true','form_client[cd2]');\"
        onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6);\" ".$g_form_option."\""
    );
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onChange=\"javascript:Button_Submit('client_search_flg','#','true', this);\" ".$g_form_option."\""
    );
}else{
    $text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onChange=\"javascript:Button_Submit('client_search_flg','#','true', this);\" 
        $g_form_option
    ");
}
$text[] =& $form->createElement("static", "", "", " ");
$text[] =& $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($text, "form_client", "", "");

// ɽ���ܥ��� display button
$form->addElement("submit", "form_show_button", "ɽ����", "");

// ���ꥢ�ܥ��� clear button
$form->addElement("button", "form_clear_button", "���ꥢ",
    "onClick=\"javascript:Button_Submit_1('hdn_clear_flg', '".$_SERVER["PHP_SELF"]."', 'true', this)\""
);

/*
// FC�ܥ��� FC button
$button_color = ($client_div == "2") ? $g_button_color : null;
$form->addElement("button", "form_client_button_2", "������",
    $button_color." onClick=\"javascript:Button_Submit('post_client_div', '".$_SERVER["PHP_SELF"]."', '2');\"
");

// ������ܥ��� purchase client button
$button_color = ($client_div == "3") ? $g_button_color : null;
$form->addElement("button", "form_client_button_3", "�ơ���",
    $button_color." onClick=\"javascript:Button_Submit('post_client_div', '".$_SERVER["PHP_SELF"]."', '3');\"
");
*/

// hidden  �����踡���ե饰 purchase client search flag
$form->addElement("hidden", "client_search_flg");

// hidden  ���ꥢ�ե饰 clear flag
$form->addElement("hidden", "hdn_clear_flg");

// hidden  ������������� trade client selection detail
$form->addElement("hidden", "post_client_div"); // �ڤ��ؤ���������ʬ��POST������ For POST of trade classification that was changed
$form->addElement("hidden", "hdn_client_div");  // �ڤ��ؤ���������ʬ����¸������ For SAVE trade classification that was changed 

// hidden  ��������� purchase client info
$form->addElement("hidden", "hdn_client_id");
$form->addElement("hidden", "hdn_close_day");
$form->addElement("hidden", "hdn_pay_m");
$form->addElement("hidden", "hdn_pay_d");

// hidden  �ե�����ǡ�����¸�� for save of form data
$form->addElement("hidden", "hdn_count_day[sy]");
$form->addElement("hidden", "hdn_count_day[sm]");
$form->addElement("hidden", "hdn_count_day[sd]");
$form->addElement("hidden", "hdn_count_day[ey]");
$form->addElement("hidden", "hdn_count_day[em]");
$form->addElement("hidden", "hdn_count_day[ed]");
$form->addElement("hidden", "hdn_client[cd1]");
$form->addElement("hidden", "hdn_client[cd2]");
$form->addElement("hidden", "hdn_client[name]");


/****************************/
// �ե������������� set the initial value of form
/****************************/

#2010-04-27 hashimoto-y
$def_fdata = array(
    "form_output"  => "1"
);
$form->setDefaults($def_fdata);


/****************************/
// ������ե���������ϡ��䴰���� input or refill process of purchase client form
/****************************/
// �����踡���ե饰��true�ξ�� if the purchase client search flag is true
if ($_POST["client_search_flg"] == "true"){

    // POST���줿�����襳���ɤ��ѿ������� substitute into variable the purchase client code that was POST
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // ������ξ������� extract the purchase client info
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    if ($client_div == "3"){
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '$client_cd2' \n";
    }
    $sql .= "AND \n";
    $sql .= ($client_div == "2") ? "   client_div = '2' \n" : "   client_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �����ǡ����������� if there is a matching data
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // ������ID purchase client ID
        $client_cname   = pg_fetch_result($res, 0, 1);      // ������̾��ά�Ρ�purchase client name (abbreviation)
    }else{
        $client_id      = "";
        $client_cname   = "";
    }
    // �����襳�������ϥե饰�򥯥ꥢ clear the input purchase client code flag
    // ������ID��������̾��ά�Ρˡ��������ʬ��ե�����˥��å� set purchase client code ID, purchsae client name (abbreviation) and billing client classification to the form
    $client_data["client_search_flg"]   = "";
    $client_data["hdn_client_id"]       = $client_id;
    $client_data["form_client"]["name"] = $client_cname;
    $form->setConstants($client_data);

}


/****************************/
// ���顼�����å� error check
/****************************/
// ɽ���ܥ��󲡲��� when display button is pressed
if ($_POST["form_show_button"] != null){

    // ɽ���ܥ��󲡲��ե饰���� craete a flag for when display button is presed
    $post_show_flg = true;

    // POST�ǡ������ѿ������� substitute POST data to the variable
    $output         = $_POST["form_output"];
    $start_y        = ($_POST["form_count_day"]["sy"] != null) ? str_pad($_POST["form_count_day"]["sy"], 4, 0, STR_POS_LEFT) : null;
    $start_m        = ($_POST["form_count_day"]["sm"] != null) ? str_pad($_POST["form_count_day"]["sm"], 2, 0, STR_POS_LEFT) : null;
    $start_d        = ($_POST["form_count_day"]["sd"] != null) ? str_pad($_POST["form_count_day"]["sd"], 2, 0, STR_POS_LEFT) : null;
    $end_y          = ($_POST["form_count_day"]["ey"] != null) ? str_pad($_POST["form_count_day"]["ey"], 4, 0, STR_POS_LEFT) : null;
    $end_m          = ($_POST["form_count_day"]["em"] != null) ? str_pad($_POST["form_count_day"]["em"], 2, 0, STR_POS_LEFT) : null;
    $end_d          = ($_POST["form_count_day"]["ed"] != null) ? str_pad($_POST["form_count_day"]["ed"], 2, 0, STR_POS_LEFT) : null;
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_cname   = $_POST["form_client"]["name"];

    // �����״��� aggregate period
    // ���顼��å����� error message 
    $err_msg = "���״��֤����դ������ǤϤ���ޤ���";

    // ɬ�ܥ����å� required field
    $form->addGroupRule("form_count_day", array(
        "sy" => array(array($err_msg, "required")),
        "sm" => array(array($err_msg, "required")),
        "sd" => array(array($err_msg, "required")),
        "ey" => array(array($err_msg, "required")),
        "em" => array(array($err_msg, "required")),
        "ed" => array(array($err_msg, "required")),
    ));

    // ���ͥ����å� value check
    $form->addGroupRule("form_count_day", array(
        "sy" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "sm" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "sd" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "ey" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "em" => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "ed" => array(array($err_msg, "regex", "/^[0-9]+$/")),
    ));

    // �ɤ줫1�ĤǤ����Ϥ������� if there is any input in one of them
    if ($start_y != null || $start_m != null || $start_d != null ||
        $end_y   != null || $end_m   != null || $end_d   != null){

        // ���������������å��ʳ��ϡ�check the validity of the date (start)
        if (!checkdate((int)$start_m, (int)$start_d, (int)$start_y)){
            $form->setElementError("form_count_day", $err_msg);
        }

        // ���������������å��ʽ�λ��check the validity of the date (end)
        if (!checkdate((int)$end_m,   (int)$end_d,   (int)$end_y)){
            $form->setElementError("form_count_day", $err_msg);
        }

    }

    // �������� purchase client 
    // ���顼��å����� error message
    $err_msg = "������ �����襳���� �����Ϥ��Ʋ�������";

    // ɬ�ܥ����å� required field 
    if ($client_div == "3"){
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "required")),
            "cd2"   => array(array($err_msg, "required")),
            "name"  => array(array($err_msg, "required")),
        ));
    }else{
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "required")),
            "name"  => array(array($err_msg, "required")),
        ));
    }

    // ���ͥ����å� value check
    if ($client_div == "3"){
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
            "cd2"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));
    }else{
        $form->addGroupRule("form_client", array(
            "cd1"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));
    }

    // �����襳���ɤ������������å� check the vailidty of the purchae client code
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2, \n";
    $sql .= "   client_cname, \n";
    $sql .= "   close_day, \n";
    $sql .= "   payout_m, \n";
    $sql .= "   payout_d \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    if ($client_div == "3"){
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '$client_cd2' \n";
    }
    $sql .= "AND \n";
    $sql .= ($client_div == "2") ? "   client_div = '2' \n" : "   client_div = '3' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        // �����褬¸�ߤ�����ϳ��������������ѿ�������
        $client_id      = pg_fetch_result($res, 0, 0);
        $client_cd1     = pg_fetch_result($res, 0, 1);
        $client_cd2     = pg_fetch_result($res, 0, 2);
        #2010-04-27 hashimoto-y
        #$client_cname   = htmlspecialchars(pg_fetch_result($res, 0, 3));
        $client_cname   = htmlspecialchars($csv_client_cname = pg_fetch_result($res, 0, 3));

        $close_day      = pg_fetch_result($res, 0, 4);
        $pay_m          = pg_fetch_result($res, 0, 5);
        $pay_d          = pg_fetch_result($res, 0, 6);
    }else{
        // �����褬¸�ߤ��ʤ����ϥ��顼�򥻥å� set an error if the purchase client does not exist
        $form->setElementError("form_client", $err_msg);
    }

    /****************************/
    // ���顼�����å�/��̽��� error check/aggregate result
    /****************************/
    // �����å�Ŭ�� apply check
    $form->validate();
    // ��̤�ե饰�� flag the result
    $err_flg = (count($form->_errors) > 0) ? true : false;

    /****************************/
    // hidden���å� set to hidden
    /****************************/
    // ���顼��̵����� if no error
    if ($err_flg != true){
        // �ե�������ͤ�hidden�˥��å� set the value of the form to hidden
        $hdn_set["hdn_output"]          = stripslashes($_POST["form_output"]);
        $hdn_set["hdn_count_day"]["sy"] = stripslashes($_POST["form_count_day"]["sy"]);
        $hdn_set["hdn_count_day"]["sm"] = stripslashes($_POST["form_count_day"]["sm"]);
        $hdn_set["hdn_count_day"]["sd"] = stripslashes($_POST["form_count_day"]["sd"]);
        $hdn_set["hdn_count_day"]["ey"] = stripslashes($_POST["form_count_day"]["ey"]);
        $hdn_set["hdn_count_day"]["em"] = stripslashes($_POST["form_count_day"]["em"]);
        $hdn_set["hdn_count_day"]["ed"] = stripslashes($_POST["form_count_day"]["ed"]);
        $hdn_set["hdn_client"]["cd1"]   = stripslashes($_POST["form_client"]["cd1"]);
        $hdn_set["hdn_client"]["cd2"]   = stripslashes($_POST["form_client"]["cd2"]);
        $hdn_set["hdn_client"]["name"]  = stripslashes($_POST["form_client"]["name"]);
        // ����������hidden�˥��å� set the purchase client info to hidden
        $hdn_set["hdn_client_id"]       = $client_id;
        $hdn_set["hdn_close_day"]       = $close_day;
        $hdn_set["hdn_pay_m"]           = $pay_m;
        $hdn_set["hdn_pay_d"]           = $pay_d;
        $form->setConstants($hdn_set);
    }

}


/****************************/
// �ڡ������ܻ��ν��� process when the page transition
/****************************/
// ɽ���ܥ���̤�������Ļ����踡���ե饰null���ĥڡ�������POST����Ƥ����� if display button is not pressed, purchaese client search is null, and page number is POST 
if ($_POST["form_show_button"] == null && $_POST["client_search_flg"] == null && $_POST["f_page1"] != null){

    // �ڡ������ܥե饰���� create page transition flag
    $post_page_flg = true;

    // hidden�λ����������ѿ������� substitute the, purchase client info that is hidden, to variable
    $client_id      = $_POST["hdn_client_id"];
    $close_day      = $_POST["hdn_close_day"];
    $pay_m          = $_POST["hdn_pay_m"];
    $pay_d          = $_POST["hdn_pay_d"];

    // hidden�θ����ǡ������ѿ������� substitute the search data that is hiddent to the variable
    $output         = $_POST["hdn_output"];
    $start_y        = ($_POST["hdn_count_day"]["sy"] != null) ? str_pad($_POST["hdn_count_day"]["sy"], 4, 0, STR_POS_LEFT) : null;
    $start_m        = ($_POST["hdn_count_day"]["sm"] != null) ? str_pad($_POST["hdn_count_day"]["sm"], 2, 0, STR_POS_LEFT) : null;
    $start_d        = ($_POST["hdn_count_day"]["sd"] != null) ? str_pad($_POST["hdn_count_day"]["sd"], 2, 0, STR_POS_LEFT) : null;
    $end_y          = ($_POST["hdn_count_day"]["ey"] != null) ? str_pad($_POST["hdn_count_day"]["ey"], 4, 0, STR_POS_LEFT) : null;
    $end_m          = ($_POST["hdn_count_day"]["em"] != null) ? str_pad($_POST["hdn_count_day"]["em"], 2, 0, STR_POS_LEFT) : null;
    $end_d          = ($_POST["hdn_count_day"]["ed"] != null) ? str_pad($_POST["hdn_count_day"]["ed"], 2, 0, STR_POS_LEFT) : null;
    $client_cd1     = $_POST["hdn_client"]["cd1"];
    $client_cd2     = $_POST["hdn_client"]["cd2"];
    $client_cname   = htmlspecialchars(stripslashes($_POST["hdn_client"]["name"]));

    // hidden�θ����ǡ�����ե�����˥��å� set the search data that is hidden to form
    $form_set["form_output"]            = stripslashes($_POST["hdn__output"]);
    $form_set["form_count_day"]["sy"]   = stripslashes($_POST["hdn_count_day"]["sy"]);
    $form_set["form_count_day"]["sm"]   = stripslashes($_POST["hdn_count_day"]["sm"]);
    $form_set["form_count_day"]["sd"]   = stripslashes($_POST["hdn_count_day"]["sd"]);
    $form_set["form_count_day"]["ey"]   = stripslashes($_POST["hdn_count_day"]["ey"]);
    $form_set["form_count_day"]["em"]   = stripslashes($_POST["hdn_count_day"]["em"]);
    $form_set["form_count_day"]["ed"]   = stripslashes($_POST["hdn_count_day"]["ed"]);
    $form_set["form_client"]["cd1"]     = stripslashes($_POST["hdn_client"]["cd1"]);
    $form_set["form_client"]["cd2"]     = stripslashes($_POST["hdn_client"]["cd2"]);
    $form_set["form_client"]["name"]    = stripslashes($_POST["hdn_client"]["name"]);
    $form->setConstants($form_set);

}


/****************************/
// ɽ���ǡ������� acquire display data 
/****************************/
// ɽ���ܥ��󲡲��ե饰true�ܥ��顼��̵����硢�ޤ��ϥڡ������ܻ� when page transitioned or flag for when display button is pressed is true + no error
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // POST���줿���եǡ��������դη��� format the date data that was POST into date format
    $start_day  = $start_y."-".$start_m."-".$start_d;
    $end_day    = $end_y."-".$end_m."-".$end_d;

    /****************************/
    // ����Ĺ���� acquire installment balance
    /****************************/
    $sql = Buy_Split_Balance_Sql($end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    // ����ǡ����������� if there is an installment data
    if ($num > 0){
        $split_balance_amount = pg_fetch_result($res, 0, 0);
    }

    /****************************/
    // ��ݥǡ������� acquire payable data
    /****************************/
    // ���ۻĹ���� acquire balance
    $ap_balance_amount = Get_Balance_Amount($db_con, $start_day, $client_id, "ap");

    // ����������� set acquire items 
    $limit      =  ($range != null) ? $range : null;
    // �������ϰ������� set the position for starting of acquire
    $offset     = ($post_show_flg == true) ? 0 : ($_POST["f_page1"] - 1) * $range;
    // ɽ��������ڡ��� page to display 
    $page_count = ($post_show_flg == true) ? 1 : $_POST["f_page1"];

    // �ڡ������ܻ�����1�ڡ����ܤǤʤ���� if its not the first page when page transitioned
    if ($post_page_flg == true && $_POST["f_page1"] != "1"){
        // ɽ������ڡ���������Υڡ�������ɼ���٥ǡ���������ʥڡ������ܻ��η��ۻĹ�����ѡ�acquire the slip detail data of the page previous to the one that will be displayed
        $sql = Ap_Particular_Sql($start_day, $end_day, $client_id, $offset);
        $res = Db_Query($db_con, $sql);
        $num = pg_num_rows($res);
        $balance_particular_data = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);
    }

    // ��ɼ���٥ǡ�������������� acquire all items of the slip detail data
    $sql = Ap_Particular_Sql($start_day, $end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $count_particular_data  = ($total_count > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // ��ɼ���٥ǡ��������ʥǡ�����̵�����϶����������acquire the slip detail data (if ther eis no data then create a blank array)
    $sql = Ap_Particular_Sql($start_day, $end_day, $client_id, $limit, $offset);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_particular_data    = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // ����ɽ���ξ�� if all items is being displayed
    $range = ($range == null) ? $total_count : $range;

    /****************************/
    // ��ݥǡ������� acquire the sales receivable data
    /****************************/
    // ���ۻĹ���� acquire balance
    $ar_balance_amount = Get_Balance_Amount($db_con, $start_day, $client_id, "ar");

    // ��ɼ���٥ǡ��������ʥǡ�����̵�����϶����������acquire slip detail data (if there is no data then create a blank array)
    $sql = Ar_Particular_Sql($start_day, $end_day, $client_id);
    $res = Db_Query($db_con, $sql);
    $num = pg_num_rows($res);
    $ary_ar_particular_data    = ($num > 0) ? Get_Data($res, 2, "ASSOC") : array(null);

    // ��ݻĹ⻻�� compute payable balance 
    foreach ($ary_ar_particular_data as $key => $value){
        $ar_balance_amount += ($value["sale_amount"] - $value["payin_amount"]);
    }

}


/****************************/
// ��������ɽ���ѥǡ��������� fornat the acquire "for display" data
/****************************/
// ɽ���ܥ��󲡲��ե饰true�ܥ��顼��̵����硢�ޤ��ϥڡ������ܻ�  hen page transitioned or flag for when display button is pressed is true + no error
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // ���� closing date
    $close_day  = ($close_day == "29") ? "����" : $close_day."��";

    // ��ʧ�� payment date
    $pay_m = ($pay_m == "0")  ? "����"  : $pay_m;
    $pay_m = ($pay_m == "1")  ? "���"  : $pay_m;
    $pay_m = ($pay_m != "����" && $pay_m != "���") ? $pay_m."�����" : $pay_m;
    $pay_d = ($pay_d == "29") ? "����"  : $pay_d."��";

    // ������/��ʧ�ۤι�׻��Сʺǽ��ڡ����ѡ� compute the total of purchase client amount or payment amount (for the last page)
    foreach ($count_particular_data as $key => $value){
        $sum_buy_amount    += $value["buy_amount"];
        $sum_payout_amount  += $value["payout_amount"];
    }

    // �ڡ������ܻ�����1�ڡ����ܤǤʤ���� if its not the first page when page transitioned
    if ($post_page_flg == true && $_POST["f_page1"] != "1"){
        // ɽ������ڡ���������Υڡ�������ɼ���٥ǡ����򸵤ˡ�ɽ������ڡ����˽��Ϥ���Ĺ�򻻽� compute the balance that will be outputted in the display page from the slip detail data of the previous page
        foreach ($balance_particular_data as $key => $value){
            $ap_balance_amount += ($value["buy_amount"] - $value["payout_amount"]);
        }
    }

    // �Ĺ�׻��ѽ�������� initial value setting for balance computation
    $each_balance_amount = $ap_balance_amount;

    // �Կ������ initial value of row number
    $row_num = 0;

    // ��ɼ���٥ǡ��� slip detail data
    foreach ($ary_particular_data as $key => $value){

        // ��/���λ��ȹԤ����������ƻȤ��䤹�����Ƥ��� put the previous/next reference row to the array
        $back = $ary_particular_data[$key-1];
        $next = $ary_particular_data[$key+1];

        ///// ���٤μ���ʻ���|��ʧ|��������|�����ƥ���type of "details" (purchae, payment, lump tax amount, royalty)
        // �������٥ե饰true purchase detail flag true
        if ($value["buy_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "buy";
        // ��ʧ���٥ե饰true payment detail flag is true
        }elseif ($value["payout_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "payout";
        // �������ǥե饰true tax amount flag is true 
        }elseif ($value["lumptax_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "lumptax";
        // �����ƥ��ե饰true royalty flag is true 
        }elseif ($value["royalty_flg"] == "t"){
            $disp_particular_data[$key]["type"] = "royalty";
        }

        ///// ǯ�ν������� ouput setting for year 
        // ����κǽ顢�ޤ�������Ⱥ����ǯ���ۤʤ��� if its the beginning of an array, or if the year last time and this time is different
        if ($key == 0 ||
            substr($back["trade_day"], 0, 4) != substr($value["trade_day"], 0, 4)
        ){
            $trade_y        = substr($value["trade_day"], 0, 4);
        }else{
            $trade_y        = null;
        }

        ///// �����ν������� output setting for month and day
        // ǯ��null����������Ⱥ���η�����Ʊ����� if year is null and the month and day is the same with the last time
        if ($trade_y == null &&
            substr($back["trade_day"], 5) == substr($value["trade_day"], 5)
        ){
            $trade_d        = null;
        }else{
            $trade_d        = substr($value["trade_day"], 5);
        }

        ///// ��ɼ�ֹ�ν������� output setting for slip number
        // ������null����������Ⱥ������ɼ�ֹ椬Ʊ������������Ⱥ�������٤μ�����Ѳ����ʤ���� if the month/day is null, and the slip number is the same wit h the last time, and if there is no change in the type of "detail" 
        if ($trade_d == null &&
            $back["slip_no"] == $value["slip_no"] &&
            $disp_particular_data[$key-1]["type"] == $disp_particular_data[$key]["type"]
        ){
            $slip_no        = null;
        }else{
            $slip_no        = $value["slip_no"];
        }

/*
        ///// ��ɼ�ֹ��ɽ���������� set the display position of slip number
        // ���٤μ��ब�������Ǥޤ��ϥ����ƥ��ξ�� if the type of detail is lump tax amount or royalty
        if ($disp_particular_data[$key]["type"] == "lumptax" || $disp_particular_data[$key]["type"] == "royalty"){
            $slip_align     = " align=\"center\" ";
        }else{
            $slip_align     = null;
        }
*/

        ///// ô���Ԥν������� output setting for assigned staff
        // ��ɼ�ֹ椬������ if there is slip number
        if ($slip_no != null){
            #2010-04-27 hashimoto-y
            #$c_staff        = htmlspecialchars($value["c_staff"]);
            $c_staff        = htmlspecialchars( $csv_c_staff = $value["c_staff"] );
        }else{
            #2010-04-27 hashimoto-y
            #$c_staff        = null;
            $c_staff        = $csv_c_staff = null;
        }

        ///// �Կ����� set row color 
        // ��ɼ�ֹ椬������ if there is slip number 
        if ($slip_no != null){
            $disp_particular_data[$key]["row_col"] = (bcmod(++$row_num, 2) == 0)    ? "Result1" : "Result2";
        }else{
            $disp_particular_data[$key]["row_col"] = (bcmod($row_num, 2) == 0)      ? "Result1" : "Result2";
        }

        ///// �����ʬ�ν������� output setting for trade classification
        // ��ɼ�ֹ椬null����������Ⱥ���μ����ʬ��Ʊ����� if slip number is null and the trade classification is the same with the last time
        if ($slip_no == null &&
            $back["trade_cd"] == $value["trade_cd"]
        ){
            $trade_cd       = null;
        }else{
            $trade_cd       = $value["trade_cd"];
        }

        ///// ����̾��ɽ���������� set the display position of product name
        // �����ǥե饰true���ޤ��ϰ������ǥե饰true���ޤ��ϥ����ƥ��ե饰true�ξ�� if the tax flag is true, or lump tax amount flag is true, or royalty flag is true 
        if ($value["tax_flg"] == "t" || $value["lumptax_flg"] == "t" || $value["royalty_flg"] == "t"){
            $goods_align    = " align=\"right\"";
        }else{
            $goods_align    = null;
        }

        ///// ���̤ν������� output setting of quantity
        // ���̤��ʤ����ޤ��ϻ�ʧ�ۤ������� if there is no quantity or if there is a payment amount
        if ($value["num"] == null || $value["payout_amount"] != null){
            $num            = null;
        }else{
            $num            = number_format($value["num"]);
        }

        ///// ñ���ν������� output setting of the price per unit
        // ���̤��ʤ����ޤ��ϻ�ʧ�ۤ����롢�ޤ�����ɼ�ֹ椬�ʤ���� if there is no quantity, or if there is payment, or if there is no slip number
        if ($value["num"] == null || $value["payout_amount"] != null || $value["slip_no"] == null){
            $buy_price      = null;
        }else{
            $buy_price      = number_format($value["buy_price"], 2);
        }

        ///// �����ۤν������� output setting for purchase amount
        // �����ۤ������� if there is a purchase amount
        if ($value["buy_amount"] != null){
            $buy_amount     = number_format($value["buy_amount"]);
        }else{
            $buy_amount     = null;
        }

        ///// ��ʧ�ۤν������� output setting for payment amount
        // ��ʧ�ξ�� if its a payment
        if ($value["payout_amount"] != null){
            $payout_amount  = number_format($value["payout_amount"]);
        }else{
            $payout_amount  = null;
        }

        // �Ĺ⻻�� compute the balance
        $each_balance_amount+= ($value["buy_amount"] - $value["payout_amount"]);

        ///// �Ĺ�ν������� output setting for balance
        // ������ɼ�ξ��ϡ���ɼ�����ǥե饰true�ξ�� if its a purchase slip, this is when slip tax flag is true
        // ��ʧ��ɼ�ξ��ϡ�����ȼ������ɼ�ֹ椬�ۤʤ�ޤ��ϼ��󤬻�ʧ���٤�̵����� if its a payment slip, this is when the slip number is different from last time or when there is no next payment detail 
        // �������Ǥξ�硢�����ƥ��ξ�� if its a lumo tax amount or royalty
        if (
            ($value["buy_flg"]  == "t" && ($value["tax_flg"] == "t")) ||
            ($value["payout_flg"] == "t" && ($value["slip_no"] != $next["slip_no"] || $next["payout_amount"] == null)) ||
            ($value["lumptax_flg"] == "t") ||
            ($value["royalty_flg"] == "t")
        ){
            $print_balance_amount = number_format($each_balance_amount);
        }else{
            $print_balance_amount = null;
        }

        ///// ���ͤν������� output setting for remark
        // ������ɼ������ɼ���1���ܤΤ߽��ϡ���塧�إå�����ʧ���ǡ��������ͤ���Ͽ����Ƥ��뤿���output only the first row of the slip if its a purchase slip (since remark is registered in sale: header and payment: data)
        if (    
            ($value["buy_flg"] == "t" && $slip_no != null) ||
            $value["payout_flg"] == "t"
        ){      
            #2010-04-27 hashimoto-y
            #$note           = nl2br(htmlspecialchars($value["note"]));
            $note           = nl2br(htmlspecialchars( $csv_note = $value["note"]));
        }else{  
            #2010-04-27 hashimoto-y
            #$note           = null; 
            $note           = $csv_note = null; 
        }

        #2010-04-27 hashimoto-y
        ///// �ޤȤ� all in all
        // ǯ year
        #$disp_particular_data[$key]["trade_y"]          = $trade_y;
        $disp_particular_data[$key]["trade_y"]          = $csv_page_data[$key][0]  = $trade_y;

        // ���� month and day
        #$disp_particular_data[$key]["trade_m"]          = $trade_d;
        $disp_particular_data[$key]["trade_m"]          = $csv_page_data[$key][1]  = $trade_d;

        // ��ɼNo. slip number
        #$disp_particular_data[$key]["slip_no"]          = $slip_no;
        $disp_particular_data[$key]["slip_no"]          = $csv_page_data[$key][2]  = $slip_no;

        // ��ɼNo.��ɽ������ dispaly position of slip number
        //$disp_particular_data[$key]["slip_align"]       = $slip_align;
        // ô���� assigned staff
        #$disp_particular_data[$key]["c_staff"]          = $c_staff;
        $disp_particular_data[$key]["c_staff"]          = $c_staff;
        $csv_page_data[$key][3]                         = $csv_c_staff;

        // �����ʬ trade classification
        #$disp_particular_data[$key]["trade_cd"]         = $trade_cd;
        $disp_particular_data[$key]["trade_cd"]         = $csv_page_data[$key][4]  = $trade_cd;

        // ����̾ product name
        #$disp_particular_data[$key]["goods_name"]       = htmlspecialchars($value["goods_name"]);
        $disp_particular_data[$key]["goods_name"]       = htmlspecialchars($value["goods_name"]);
        $csv_page_data[$key][5]                         = $value["goods_name"];

        // ����̾��ɽ������ display position of product name
        $disp_particular_data[$key]["goods_align"]      = $goods_align;

        // ���� quantity
        #$disp_particular_data[$key]["num"]              = $num;
        $disp_particular_data[$key]["num"]              = $csv_page_data[$key][6]  = $num;

        // ñ�� price per unit
        #$disp_particular_data[$key]["buy_price"]        = $buy_price;
        $disp_particular_data[$key]["buy_price"]        = $csv_page_data[$key][7]  = $buy_price;

        // ������ purchase amount
        #$disp_particular_data[$key]["buy_amount"]       = $buy_amount;
        $disp_particular_data[$key]["buy_amount"]       = $csv_page_data[$key][8]  = $buy_amount;

        // ��ʧ�� payment amount
        #$disp_particular_data[$key]["payout_amount"]    = $payout_amount;
        $disp_particular_data[$key]["payout_amount"]    = $csv_page_data[$key][9]  = $payout_amount;

        // �Ĺ� balance
        #$disp_particular_data[$key]["balance_amount"]   = $print_balance_amount;
        $disp_particular_data[$key]["balance_amount"]   = $csv_page_data[$key][10] = $print_balance_amount;

        // ���� remarks
        #$disp_particular_data[$key]["note"]             = $note;
        $disp_particular_data[$key]["note"]             = $note;
        $csv_page_data[$key][11]                        = $csv_note;

    }

}


#2010-04-27 hashimoto-y
#CSV�����ɲ� add CSV process
if ($post_show_flg == true && $err_flg != true &&  $_POST["form_output"] == 2){

    $csv_header = array(
            "ǯ",
            "����",
            "��ɼNo.",
            "ô����",
            "���",
            "����",
            "����",
            "ñ��",
            "����",
            "��ʧ",
            "�Ĺ�",
            "����",
          );

    #���ۻĹ� balance
    $balance_carried = array("","","","","","���ۻĹ�","","","","",number_format($ap_balance_amount),"","");
    array_unshift($csv_page_data, $balance_carried);

    #�Ĺ��� balance total
    $total_balance = array("","","","","","���","","",number_format($sum_buy_amount),number_format($sum_payout_amount),number_format($each_balance_amount),"","");
    array_push($csv_page_data, $total_balance);

    #�إå��ɲ� ad dheader
    #array_unshift($csv_page_data, $csv_addheader);

    #$csv_file_name = "����踵Ģ".date("Ymd").".csv";
    $csv_file_name = "�����踵Ģ_". $csv_client_cname .$end_y .$end_m .$end_d .".csv";

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

}


/****************************/
// HTML���� create html
/****************************/
// ɽ���ܥ��󲡲��ե饰true�ܥ��顼��̵����硢�ޤ��ϥڡ������ܻ� when page transitioned or flag for when display button is pressed is true + no error
if (($post_show_flg == true && $err_flg != true) || $post_page_flg == true){

    // �ڡ���ʬ�� page division
    $html_page  = ($range != $total_count) ? Html_Page($total_count, $page_count, 1, $range) : "�� <b>$total_count</b> ��";
    $html_page2 = ($range != $total_count) ? Html_Page($total_count, $page_count, 2, $range) : null;

    // ��������󣱡ʥ����ɡ�̾����purchase client information 1 (code, name)
    $html_1  = "<span style=\"font: bold 16px; color: #555555;\">";
    if ($client_div == "2"){
    $html_1 .= $client_cd1."��".$client_cname;
    }else{
    $html_1 .= $client_cd1."-".$client_cd2."��".$client_cname;
    }
    $html_1 .= "</span>\n";

    // FC���������� FC��trade client info 2
    $html_2 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_2 .= "<col width=\"60\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"120\">\n";
    $html_2 .= "<col width=\"60\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"120\">\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_2 .= "        <td class=\"Value\">$close_day</td>\n";
    $html_2 .= "        <td class=\"Title_Pink\">��ʧ��</td>\n";
    $html_2 .= "        <td class=\"Value\">".$pay_m."��".$pay_d."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    $html_2 .= "        </td>\n";
    $html_2 .= "        <td align=\"right\">\n";

    $html_2 .= "<table class=\"List_Table\" border=\"1\">\n";
    $html_2 .= "<col width=\"70\" align=\"center\" style=\"font-weight: bold;\">\n";
    $html_2 .= "<col width=\"80\">\n";
    if ($client_div == "3"){
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Td_Search_3\">��ݻĹ�</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($ar_balance_amount).">".number_format($ar_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    }
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">��ݻĹ�</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($each_balance_amount).">".number_format($each_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "    <tr>\n";
    $html_2 .= "        <td class=\"Title_Pink\">����Ĺ�</td>\n";
    $html_2 .= "        <td class=\"Value\" align=\"right\"".Font_Color($split_balance_amount).">".number_format($split_balance_amount)."</td>\n";
    $html_2 .= "    </tr>\n";
    $html_2 .= "</table>\n";

    // ���٥ǡ��� detail data
    $html_3  = "<table class=\"List_Table\" border=\"1\">\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"60px\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "<col width=\"30px\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "<col width=\"40px\">\n";
    $html_3 .= "<col width=\"80px\" span=\"4\">\n";
    $html_3 .= "<col>\n";
    $html_3 .= "    <tr align=\"center\" style=\"font-weight: bold;\">\n";
    $html_3 .= "        <td class=\"Title_Pink\">ǯ</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">��ɼNo.</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">ô����</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">���</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">ñ��</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">��ʧ</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">�Ĺ�</td>\n";
    $html_3 .= "        <td class=\"Title_Pink\">����</td>\n";
    $html_3 .= "    </tr>\n";
    $html_3 .= "    <tr class=\"Result1\">\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\">���ۻĹ�</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($ap_balance_amount).">".number_format($ap_balance_amount)."</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "    </tr>\n";
    if (is_array($ary_particular_data[0])){
        foreach ($disp_particular_data as $key => $value){
    $html_3 .= "    <tr class=\"".$value["row_col"]."\">\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_y"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_m"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["slip_no"]."</td>\n";
    $html_3 .= "        <td nowrap nowrap>".$value["c_staff"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"center\">".$value["trade_cd"]."</td>\n";
    $html_3 .= "        <td nowrap nowrap ".$value["goods_align"].">".$value["goods_name"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["num"]).">".$value["num"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["buy_price"]).">".$value["buy_price"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["buy_amount"]).">".$value["buy_amount"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["payout_amount"]).">".$value["payout_amount"]."</td>\n";
    $html_3 .= "        <td nowrap align=\"right\"".Font_Color($value["balance_amount"]).">".$value["balance_amount"]."</td>\n";
    $html_3 .= "        <td nowrap nowrap>".$value["note"]."</td>\n";
    $html_3 .= "    </tr>\n";
        }
    }
    // ��פϺǽ��ڡ����Τ߽��� output the total only for the last page
    if ($total_count < $page_count * $range + 1){
    $html_3 .= "    <tr class=\"Result3\">\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"><b>���</b></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($sum_buy_amount).">".number_format($sum_buy_amount)."</td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($sum_payout_amount).">".number_format($sum_payout_amount)."</td>\n";
    $html_3 .= "        <td align=\"right\"".Font_Color($each_balance_amount).">".number_format($each_balance_amount)."</td>\n";
    $html_3 .= "        <td></td>\n";
    $html_3 .= "    </tr>\n";
    }
    $html_3 .= "</table>\n";

}


/****************************/
// ���򤵤줿������ζ�ʬ���� acquire the purchase client classification that was selected
/****************************/
if ($_POST["form_client"]["cd1"] != null && $_POST["form_client"]["cd2"] != null){

    $sql  = "SELECT \n";
    $sql .= "   rank_cd \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '".$_POST["form_client"]["cd1"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '".$_POST["form_client"]["cd2"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '3' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    $rank_cd = ($num > 0) ? pg_fetch_result($res, 0, 0) : null;

    // FC��������ʬ���ֻ�����פξ��Ͻ����ѥ�å��������� create the message for output if the FC��trade client classification is purchase client
    $rank = ($rank_cd == "0100") ? " <b>������</b>" : null;

}


/****************************/
// HTML�إå� html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå� html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h("buy", "4");

/****************************/
// ���̥إå������� create screen header
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// �ڡ������� create page
/****************************/
// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign assign form related variables
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign assign other variables
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "html_page"     => "$html_page",
    "html_page2"    => "$html_page2",
    "rank"          => "$rank",
));
$smarty->assign("html_1", "$html_1");
$smarty->assign("html_2", "$html_2");
$smarty->assign("html_3", "$html_3");

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
