<?php
/**
 *
 * ��ݻĹ����
 *   �ޤ���
 * ��ݻĹ����
 *
 *
 *
 *
 *
 *
 *
 *   !! ������FC���̤Ȥ��Ʊ�����������ƤǤ� !!
 *   !! �ѹ�������������򤤤��ä�¾���˥��ԤäƤ������� !!
 *
 *
 *
 *
 *
 *
 *
 * 1.0.0 (2007/01/31) ��������
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/03/07)
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/02/22      xx-xxx      kajioka-h   Ģɼ���ϵ�ǽ����
 *  2007/03/07      ����¾-22   kajioka-h   �������ƥ����������Ǥν����ɲäˤ���ѹ�
 *  2007/05/08      xx-xxx      kajioka-h   ���եե�����˥ǥե�����ͤ�����
 *  2007/05/11      B0702-051   kajioka-h   Ĵ���ۤ���椬�ְ�äƤ���Τ���
 *                  xx-xxx      kajioka-h   FC����ݻĹ�����ξ�硢���롼�פǸ����Ǥ���褦���ѹ�
 *  2007/05/16      xx-xxx      kajioka-h   ���ɽ�����Ϸ�̥ơ��֥��ɽ�����ʤ�
 *                  xx-xxx      kajioka-h   ��̤�0��ξ��ϡ���̥ơ��֥�Ȳ����������ɽ�����ʤ�
 *                  xx-xxx      kajioka-h   ��̥ơ��֥���С���θ�ߤˡ���׹Ԥ򥰥졼ɽ��
 *                  xx-xxx      kajioka-h   ���롼�׸����ˡ�ʸ����Ǹ����Ǥ���褦���ѹ�
 *  2007/05/25      xx-xxx      kajioka-h   ������ݻĹ������FC���������ʬ�θ������ܤ��ɲ�
 *  2007/05/28      B0702-058   kajioka-h   �����ξ�硢Ʊ��client_id�������㤤�⤹��Τǡ��������ƥ����������Ǥζ��̤��Ĥ��ʤ��Х�����
 *  2007/05/30      xx-xxx      kajioka-h   �����ξ��ˡ�FC��������ʬ�Ǹ����Ǥ���褦��
 *                  xx-xxx      kajioka-h   ������ݡ���������ע���FC�������פ�ʸ���ѹ�
 *  2007-06-07                  fukuda      �������1���ܤˤ��׹Ԥ�ɽ��
 *  2007-06-07                  fukuda      �������ܤˡּ�����֡��ɲá��ֻĹ���ǹ��ˡפθ��������ĥ
 *  2007-06-07                  fukuda      ��ۤ��ϰϤǸ�����Ԥ��ȥ����ꥨ�顼���Ф��Զ��ν���
 *  2007-06-07                  fukuda      �ڡ������ڤ��ؤ������������ʬ���ѹ���POST��ǽ���Զ�����
 *  2007-06-13                  fukuda      �Ĺ⸡����0�߰ʳ��פ�"���Ƥι��ܤ�0�ߤξ��Τ���Ф��ʤ�"�˽���
 *  2007/06/21      xx-xxx      kajioka-h   ��ݻĹ�����λ������ʬ��FC��������ʬ��̾���ѹ�����о�������ơ�FC�ʣãԡ��ӣСˡפ��ѹ�
 *  2007/06/25      xx-xxx      kajioka-h   ľ�Ĥ���ݻĹ���������FC��������ʬ�פθ���������
 *                  B0702-064   kajioka-h   �Ĺ�˿��Ͱʳ������Ϥ��Ƥ⥨�顼��å�������ɽ������ʤ��Х�����
 *  2007/06/26      xx-xxx      kajioka-h   ��ʬ�Υ���åפ������衦������Υǡ���������Ф��ʤ��褦���ѹ�
 *  2007/06/28      xx-xxx      kajioka-h   ������ݻĹ�����ξ�硢FC�Υǡ���������Ф��ʤ��褦���ѹ�
 *  2007-07-12                  fukuda      �����������ɲ�
 *  2007-07-27                  fukuda      ����Ĺ������ɲ�
 *  2011-01-22                  watanabe-k  ������ʸ�γ���Ĺ�򤹤٤ƽ��פ��Ƥ��ޤ��Х��ν���
 *  2011-02-11                  watanabe-k  ����Ĺ����꤬����Ĺ�Ȥ�����Ф���ʤ��Х��ν���
 *
 */

//�����ʬ
//����ݻĹ�����ξ��ϡ�sale��
//����ݻĹ�����ξ��ϡ�buy��
//$trade_div = "sale";
$trade_div = "buy";

$page_title = ($trade_div == "sale") ? "��ݻĹ����" : "��ݻĹ����";
$trade_mess = ($trade_div == "sale") ? "���" : "���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("$_SERVER[PHP_SELF]", "POST");

//DB��³
$db_con = Db_Connect();

//SQL�����ؿ�
require_once(INCLUDE_DIR."function_monthly_renew.inc");


//���������ե饰
//����true���оݴ��֤����������ѤΤ�Τ�������
//����false�����������»�̵ͭ�˴ط��ʤ����оݴ��֤Υǡ��������ƽ���
$renew_flg = false;

//��ݤ���ݤǰ㤦�Ȥ��˻Ȥ�
$arp = ($trade_div == "sale") ? "ar" : "ap";
$t_balance_name = "t_".$arp."_balance";
$pay_div = ($trade_div == "sale") ? "payin" : "payout";


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];



/****************************/
// �ե�����ѡ��ĺ���
/****************************/
/*
// ���Ϸ���
$radio_output_type[] =& $form->createElement("radio", null, null, "����", "1");
$radio_output_type[] =& $form->createElement("radio", null, null, "Ģɼ", "2");
$form->addGroup($radio_output_type, "form_output_type", "");
*/

// �оݷ�
$text_input_day[] =& $form->createElement("text", "y", "", 
                        "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option
                         onkeyup=\"changeText(this.form, 'form_input_day[y]', 'form_input_day[m]', 4);\"
                         onFocus=\"onForm_today2(this,this.form,'form_input_day[y]','form_input_day[m]');\"
                        ");
$text_input_day[] =& $form->createElement("static", "", "", "-");
$text_input_day[] =& $form->createElement("text", "m", "", 
                        "size=\"1\" maxLength=\"2\" value=\"\" style=\"$g_form_style\" $g_form_option
                         onFocus=\"onForm_today2(this,this.form,'form_input_day[y]','form_input_day[m]');\"
                        ");
$form->addGroup( $text_input_day, "form_input_day", "");

//ɽ�����
$select_num = array(
    "10"    => "10",
    "50"    => "50",
    "100"   => "100",
    "ALL"   => "����", 
);
$form->addElement("select", "form_display_num", "", $select_num, $g_form_option_select);

// ����襳����
//��ݻĹ�������ޤ�����������ݻĹ�����ξ��ϼ����CD2��
if($trade_div == "sale" || $group_kind == "1"){
    $client_cd[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_client_cd[cd1]', 'form_client_cd[cd2]', 6)\" $g_form_option");
    $client_cd[] =& $form->createElement("static", "", "", "-");
    $client_cd[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" value=\"\" style=\"$g_form_style\" $g_form_option");
//FC����ݻĹ�����ϼ����CD1�Τ�
}else{
    $client_cd[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" value=\"\" style=\"$g_form_style\" $g_form_option");
}
$form->addGroup( $client_cd, "form_client_cd", "");

// �����̾
$form->addElement("text", "form_client_name", "", "size=\"34\" maxLength=\"25\" $g_form_option");

//FC���������������̤Τߡ�
if($group_kind == "1"){
    $rank_select_value = Select_Get($db_con, "rank");
    $form->addElement("select", "form_rank", "", $rank_select_value, $g_form_option_select);
}

/*
// SV
$select_staff1 = Select_Get($db_con, "staff", true);
$form->addElement("select", "form_staff1", "", $select_staff1, $g_form_option_select);

// ���ô����
$select_staff2 = Select_Get($db_con, "staff", true);
$form->addElement("select", "form_staff2", "", $select_staff2, $g_form_option_select);
*/

// ����/��|��/�ݻĹ�
$balance_this[] =& $form->createElement("text", "min", "", "size=\"11\" maxLength=\"9\" value=\"\" onkeyup=\"changeText(this.form, 'form_balance_this[min]', 'form_balance_this[max]', 9)\" $g_form_option style=\"text-align: right; $g_form_style\"");
$balance_this[] =& $form->createElement("static", "", "", "������");
$balance_this[] =& $form->createElement("text", "max", "", "size=\"11\" maxLength=\"9\" value=\"\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form->addGroup( $balance_this, "form_balance_this", "");

// �����
/*
$monthly_renew[] =& $form->createElement("radio", null, null, "������", "1");
$monthly_renew[] =& $form->createElement("radio", null, null, "������", "2");
$form->addGroup($monthly_renew, "form_monthly_renew", "�����");
*/

// ���롼�ס�FC����ݻĹ�����Τߡ�
if($group_kind != "1" && $trade_div == "sale"){
    $select_group = null;
    $select_group = Select_Get($db_con, "client_gr");
    $form->addElement("select", "form_client_gr", "", $select_group, $g_form_option_select);

    $form->addElement("text", "form_client_gr_name", "", "size=\"34\" maxLength=\"25\" $g_form_option");
}

// �Ĺ�ʥ饸���ܥ����
$obj    =   null;   
$obj[]  =&  $form->createElement("radio", null, null, "0�߰ʳ�", "1");
$obj[]  =&  $form->createElement("radio", null, null, "����",  "2");
$form->addGroup($obj, "form_balance_radio", "");

//���֡��������
$obj    =   null;   
$obj[]  =&  $form->createElement("radio", null, null, "�����",       "1");   
$obj[]  =&  $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
$obj[]  =&  $form->createElement("radio", null, null, "����",         "0");   
$form->addGroup($obj, "form_state", "");

// �����ʬ
$item   =   null;
if ($trade_div == "sale"){
    $item   =   Select_Get($db_con, "trade_aord");
}else{
    $item   =   Select_Get($db_con, "trade_ord");
}
$form->addElement("select", "form_trade", "", $item, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();\"");

// ɽ���ܥ���
$form->addElement("submit", "form_display_button", "ɽ����", "");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// ����ͻ���
$def_fdata = array(
    //"form_output_type"      => "1",
    "form_display_num"      => "50",
    "form_monthly_renew"    => "1",
    "form_supplier_div"     => "0",
    "form_input_day"        => array(
        "y" => date("Y"),
        "m" => date("m"),
    ),
    "form_balance_radio"    => "1",
    "form_state"            => "1",
);

$form->setDefaults($def_fdata);


// hidden
//$form->addElement("hidden", "hdn_output_type");
$form->addElement("hidden", "hdn_display_num");
$form->addElement("hidden", "hdn_input_day[y]");
$form->addElement("hidden", "hdn_input_day[m]");
$form->addElement("hidden", "hdn_client_cd[cd1]");
$form->addElement("hidden", "hdn_client_cd[cd2]");
$form->addElement("hidden", "hdn_client_name");
$form->addElement("hidden", "hdn_client_gr");
$form->addElement("hidden", "hdn_client_gr_name");
$form->addElement("hidden", "hdn_rank");
//$form->addElement("hidden", "hdn_staff1");
//$form->addElement("hidden", "hdn_staff2");
$form->addElement("hidden", "hdn_balance_this[min]");
$form->addElement("hidden", "hdn_balance_this[max]");
//$form->addElement("hidden", "hdn_monthly_renew");
$form->addElement("hidden", "hdn_balance_radio");
$form->addElement("hidden", "hdn_state");
$form->addElement("hidden", "hdn_trade");


// ������ݻĹ�����ξ��ϻ������ʬ������
if($trade_div == "buy" && $group_kind == "1"){
    $radio_supplier_div[] =& $form->createElement("radio", null, null, "����", "0");
    //$radio_supplier_div[] =& $form->createElement("radio", null, null, "������", "2");
    $radio_supplier_div[] =& $form->createElement("radio", null, null, "FC�ʣãԡ��ӣС�", "3");
    $form->addGroup($radio_supplier_div, "form_supplier_div", "�������ʬ");
    $form->addElement("hidden", "hdn_supplier_div");
}


/****************************/
//POST����
/****************************/
if($_POST["form_display_button"] == "ɽ����"){
//print_array($select_num);

    $range                  = (array_key_exists($_POST["form_display_num"], $select_num)) ? $_POST["form_display_num"] : "50";   //ɽ�����
    $page_count             = 1;
    $offset                 = 0;

    //$output_type            = (in_array($_POST["form_output_type"], array("1", "2"))) ? $_POST["form_output_type"] : "1";
    $input_day_y            = $_POST["form_input_day"]["y"];
    $input_day_m            = $_POST["form_input_day"]["m"];
    $client_cd1             = $_POST["form_client_cd"]["cd1"];
    $client_cd2             = $_POST["form_client_cd"]["cd2"];
    $client_name            = $_POST["form_client_name"];
    $client_gr              = $_POST["form_client_gr"];
    $client_gr_name         = $_POST["form_client_gr_name"];
    $rank                   = $_POST["form_rank"];
    //$staff1                 = (array_key_exists($_POST["form_staff1"], $select_staff1)) ? $_POST["form_staff1"] : "";
    //$staff2                 = (array_key_exists($_POST["form_staff2"], $select_staff2)) ? $_POST["form_staff2"] : "";
    $balance_this_min       = $_POST["form_balance_this"]["min"];
    $balance_this_max       = $_POST["form_balance_this"]["max"];
    //$monthly_renew          = (in_array($_POST["form_monthly_renew"], array("1", "2"))) ? $_POST["form_monthly_renew"] : "1";
    $balance_radio          = $_POST["form_balance_radio"];
    $state                  = $_POST["form_state"];
    $trade                  = $_POST["form_trade"];

    //��������form�˵ͤ��
    //$con_data["form_output_type"]           = $output_type;
    $con_data["form_display_num"]           = $range;
    $con_data["form_input_day[y]"]          = $input_day_y;
    $con_data["form_input_day[m]"]          = $input_day_m;
    $con_data["form_client_cd[cd1]"]        = $client_cd1;
    $con_data["form_client_cd[cd2]"]        = $client_cd2;
    $con_data["form_client_name"]           = $client_name;
    $con_data["form_client_gr"]             = $client_gr;
    $con_data["form_client_gr_name"]        = $client_gr_name;
    $con_data["form_rank"]                  = $rank;
    //$con_data["form_staff1"]                = $staff1;
    //$con_data["form_staff2"]                = $staff2;
    $con_data["form_balance_this[min]"]     = $balance_this_min;
    $con_data["form_balance_this[max]"]     = $balance_this_max;
    //$con_data["form_monthly_renew"]         = $monthly_renew;
    $con_data["hdn_balance_radio"]          = $balance_radio;
    $con_data["hdn_state"]                  = $state;
    $con_data["hdn_trade"]                  = $trade;

    //��������hidden�˵ͤ��
    //$con_data["hdn_output_type"]            = $output_type;
    $con_data["hdn_display_num"]            = $range;
    $con_data["hdn_input_day[y]"]           = $input_day_y;
    $con_data["hdn_input_day[m]"]           = $input_day_m;
    $con_data["hdn_client_cd[cd1]"]         = $client_cd1;
    $con_data["hdn_client_cd[cd2]"]         = $client_cd2;
    $con_data["hdn_client_name"]            = $client_name;
    $con_data["hdn_client_gr"]              = $client_gr;
    $con_data["hdn_client_gr_name"]         = $client_gr_name;
    $con_data["hdn_rank"]                   = $rank;
    //$con_data["hdn_staff1"]                 = $staff1;
    //$con_data["hdn_staff2"]                 = $staff2;
    $con_data["hdn_balance_this[min]"]      = $balance_this_min;
    $con_data["hdn_balance_this[max]"]      = $balance_this_max;
    //$con_data["hdn_monthly_renew"]          = $monthly_renew;
    $con_data["hdn_balance_radio"]          = $balance_radio;
    $con_data["hdn_state"]                  = $state;
    $con_data["hdn_trade"]                  = $trade;


    if($trade_div == "buy" && $group_kind == "1"){
        $supplier_div       = (in_array($_POST["form_supplier_div"], array("0", "2", "3"))) ? $_POST["form_supplier_div"] : "0";
        $con_data["form_supplier_div"]      = $supplier_div;
        //$supplier_div                       = $_POST["form_supplier_div"];
        $con_data["hdn_supplier_div"]       = $supplier_div;
    }


//�ڡ������ܻ�
}elseif($_POST["form_display_button"] == null && $_POST["f_page1"] != null){

    $range                  = (in_array($_POST["hdn_display_num"], $select_num)) ? $_POST["hdn_display_num"] : "50";   //ɽ�����
    $page_count             = $_POST["f_page1"];
    $offset                 = ($page_count - 1) * $range;

    //$output_type            = (in_array($_POST["hdn_output_type"], array("1", "2"))) ? $_POST["hdn_output_type"] : "1";
    $input_day_y            = $_POST["hdn_input_day"]["y"];
    $input_day_m            = $_POST["hdn_input_day"]["m"];
    $client_cd1             = $_POST["hdn_client_cd"]["cd1"];
    $client_cd2             = $_POST["hdn_client_cd"]["cd2"];
    $client_name            = $_POST["hdn_client_name"];
    $client_gr              = $_POST["hdn_client_gr"];
    $client_gr_name         = $_POST["hdn_client_gr_name"];
    $rank                   = $_POST["hdn_rank"];
    //$staff1                 = (array_key_exists($_POST["hdn_staff1"], $select_staff1)) ? $_POST["hdn_staff1"] : "";
    //$staff2                 = (array_key_exists($_POST["hdn_staff2"], $select_staff2)) ? $_POST["hdn_staff2"] : "";
    $balance_this_min       = $_POST["hdn_balance_this"]["min"];
    $balance_this_max       = $_POST["hdn_balance_this"]["max"];
    //$monthly_renew          = (in_array($_POST["hdn_monthly_renew"], array("1", "2"))) ? $_POST["hdn_monthly_renew"] : "1";
    $balance_radio          = $_POST["hdn_balance_radio"];
    $state                  = $_POST["hdn_state"];
    $trade                  = $_POST["hdn_trade"];


    //ɽ���ܥ��󲡲����ʳ���hidden���ͤ򸡺��ե�����˥��åȤ���
    //$con_data["form_output_type"]           = $output_type;
    $con_data["form_display_num"]           = $range;
    $con_data["form_input_day[y]"]          = $input_day_y;
    $con_data["form_input_day[m]"]          = $input_day_m;
    $con_data["form_client_cd[cd1]"]        = $client_cd1;
    $con_data["form_client_cd[cd2]"]        = $client_cd2;
    $con_data["form_client_name"]           = $client_name;
    $con_data["form_client_gr"]             = $client_gr;
    $con_data["form_client_gr_name"]        = $client_gr_name;
    $con_data["form_rank"]                  = $rank;
    //$con_data["form_staff1"]                = $staff1;
    //$con_data["form_staff2"]                = $staff2;
    $con_data["form_balance_this[min]"]     = $balance_this_min;
    $con_data["form_balance_this[max]"]     = $balance_this_max;
    //$con_data["form_monthly_renew"]         = $monthly_renew;
    $con_data["form_balance_radio"]         = $balance_radio;
    $con_data["form_state"]                 = $state;
    $con_data["form_trade"]                 = $trade;


    if($trade_div == "buy" && $group_kind == "1"){
        //$supplier_div       = (in_array($_POST["form_supplier_div"], array("0", "2", "3"))) ? $_POST["form_supplier_div"] : "0";
        //$con_data["form_supplier_div"]      = $supplier_div;
        $supplier_div                       = $_POST["hdn_supplier_div"];
        $con_data["form_supplier_div"]       = $supplier_div;
    }


//���ɽ��
}else{

    $range                  = 50;
    $page_count             = 1;
    $offset                 = 0;

}

$form->setConstants($con_data);


/****************************/
//ɽ���ܥ��󲡲��ޤ��ϥڡ������ػ�
/****************************/
if($_POST["form_display_button"] == "ɽ����" || $_POST["f_page1"] != null){

    // �оݷ�򥼥���ᤷ�Ƥ���
    $_POST["form_input_day"] = Str_Pad_Date($_POST["form_input_day"]);
    // �ѿ��˥��å�
    $form_day_y = $_POST["form_input_day"]["y"];
    $form_day_m = $_POST["form_input_day"]["m"];
    $input_day = $form_day_y."-".$form_day_m;

    /****************************/
    //���顼�����å�(addRule)
    /****************************/
    // ���оݷ�
    // ɬ�ܥ����å�
    if ($_POST["form_input_day"]["y"] == null || $_POST["form_input_day"]["m"] == null){
        $form->setElementError("form_input_day", "�оݷ� ��ɬ�ܤǤ���");
    }
    // ���ͥ����å�
    elseif (!ereg("^[0-9]+$", $form_day_y) || !ereg("^[0-9]+$", $form_day_m)){
        $form->setElementError("form_input_day", "�оݷ� �������ǤϤ���ޤ���");
    }       
    // ���դ������������å�
    elseif (!checkdate((int)$form_day_m, (int)1, (int)$form_day_y)){
        $form->setElementError("form_input_day", "�оݷ� �������ǤϤ���ޤ���");
    }
    // ����ޤǤ˥��顼���ʤ����
    if ($form->getElementError("form_input_day") == null){
        // �����ƥ೫�����ʹߥ����å��ؿ��¹�
        $sysup_chk = Sys_Start_Date_Chk($form_day_y, $form_day_m, "1", "�оݷ� ");
        // �����ƥ೫�����ʹߥ����å�
        if ($sysup_chk != null){
            $form->setElementError("form_input_day", str_replace("1��", "", $sysup_chk));
        } 
    }

    //����/��|��/�ݻĹ�
    //����
    if($balance_this_min != null){
        if(!ereg("^[-]?[0-9]+$", $balance_this_min)){
            $form->setElementError("form_balance_this", "����".$trade_mess."�Ĺ� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
        }
    }
    //��λ
    if($balance_this_max != null){
        if(!ereg("^[-]?[0-9]+$", $balance_this_max)){
            $form->setElementError("form_balance_this", "����".$trade_mess."�Ĺ� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
        }
    }

    // �����å�Ŭ��
    $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    //���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    //if($form->validate() && $error_flg == false){
    if($err_flg != true){


        //����ǯ�������Ѥ��ɤ���
        $sql  = "SELECT \n";
        $sql .= "    close_day \n";
        $sql .= "FROM \n";
        $sql .= "    t_sys_renew \n";
        $sql .= "WHERE \n";
        $sql .= "    shop_id = ".$shop_id." \n";
        $sql .= "    AND \n";
        $sql .= "    renew_div = '2' \n";
        $sql .= "    AND \n";
        $sql .= "    close_day LIKE '$input_day-%' \n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);


        //������ǡ����������硢�/��|��/�ݻĹ�ơ��֥뤫��ǡ��������
        if(pg_num_rows($result) != 0){

            /* ������������� */

            //��������(��)�����
            $sql = "SELECT my_close_day FROM t_client WHERE client_id = $shop_id;";
            $result = Db_Query($db_con, $sql);
            $my_close_day = pg_fetch_result($result, 0, 0);     //��������(��)

            $close_day_this  = $input_day;
            $close_day_this .= "-";
            $close_day_this .= ($my_close_day == 29) ? date("t", mktime(0, 0, 0, $input_day_m, 1, $input_day_y)) : $my_close_day;   //����ǯ�������(ǯ����)

            //����ǯ��������η�����������
            $sql  = "SELECT \n";
            $sql .= "   close_day \n";
            $sql .= "FROM \n";
            $sql .= "   t_sys_renew \n";
            $sql .= "WHERE \n";
            $sql .= "   shop_id = ".$shop_id." \n";
            $sql .= "AND \n";
            $sql .= "   renew_div = '2' \n";
            $sql .= "AND \n";
            $sql .= "   close_day < '$close_day_this' \n";
            $sql .= "ORDER BY \n";
            $sql .= "   close_day DESC \n";
            $sql .= "LIMIT 1 \n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            $close_day_last = (pg_num_rows($result) == 0) ? START_DAY : pg_fetch_result($result, 0, 0);     //����η������


            $start_day = $close_day_last;   //��д��֤λϤ�
            $end_day   = $close_day_this;   //��д��֤ν����


            //WHERE�����
            $where_sql = "";

            //����襳����
            $where_sql .= ($client_cd1 != null) ? "    AND $t_balance_name.client_cd1 LIKE '".$client_cd1."%' \n" : "";
            $where_sql .= ($client_cd2 != null) ? "    AND $t_balance_name.client_cd2 LIKE '".$client_cd2."%' \n" : "";

            //�����̾
            if($client_name != null){
                $where_sql .= "    AND ( \n";
                $where_sql .= "        $t_balance_name.client_name1 LIKE '%".$client_name."%' OR \n";
                $where_sql .= "        $t_balance_name.client_name2 LIKE '%".$client_name."%' OR \n";
                $where_sql .= "        $t_balance_name.client_cname LIKE '%".$client_name."%' \n";
                $where_sql .= "    ) \n";
            }

            //���롼��
            $where_sql .= ($client_gr != null) ? "    AND t_client.client_gr_id = $client_gr \n" : "";
            $where_sql .= ($client_gr_name != null) ? "    AND t_client_gr.client_gr_name LIKE '%$client_gr_name%' \n" : "";

            //FC��������ʬ
            $where_sql .= ($rank != null) ? "    AND t_client.rank_cd = '$rank' \n" : "";

/*
            //SV
            if($staff1 != null){
                //$where_sql .= "    AND staff1_name = '".$select_staff1[$_POST["form_staff1"]]."' \n";
                $where_sql .= "    AND staff1_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$staff1.") \n";
            }

            //���ô��1
            if($staff2 != null){
                //$where_sql .= "    AND staff2_name = '".$select_staff2[$_POST["form_staff2"]]."' \n";
                $where_sql .= "    AND staff2_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$staff2.") \n";
            }
*/

            //����/��|��/�ݻĹ�
            //����
            if($balance_this_min != null){
                $where_sql .= "    AND ".$arp."_balance_this >= '".$balance_this_min."' \n";
            }
            //��λ
            if($balance_this_max != null){
                $where_sql .= "    AND ".$arp."_balance_this <= '".$balance_this_max."' \n";
            }

            //FC��������ʬ
            if($trade_div == "buy" && $group_kind == "1"){
                if($supplier_div == "2" || $supplier_div == "3"){
                    //$where_sql .= "    AND $t_balance_name.client_div = '".$supplier_div."' \n";
                    $where_sql .= "    AND t_client.rank_cd IN ('0001', '0002') \n";
                }              
            }

            // �Ĺ�ʥ饸���ܥ����
            if ($balance_radio == "1"){
                $where_sql .= "    AND \n";
                $where_sql .= "     ( \n";
                $where_sql .= "         ".$t_balance_name.".".$arp."_balance_last != 0          OR \n"; // ����/��|��/�ݻĹ�
                $where_sql .= "         ".$t_balance_name.".net_".$trade_div."_amount != 0      OR \n"; // ����/���|����/�ۡ���ȴ��
                $where_sql .= "         ".$t_balance_name.".tax_amount != 0                     OR \n"; // �����ǳ�
                $where_sql .= "         ".$t_balance_name.".intax_".$trade_div."_amount != 0    OR \n"; // ����/���|����/�ۡ��ǹ���
                $where_sql .= "         ".$t_balance_name.".pay_amount != 0                     OR \n"; // ����/����|��ʧ/��
                $where_sql .= "          t_".$pay_div."_rebate.".$pay_div."_rebate != 0         OR \n"; // ����/����|��ʧ/�����
                $where_sql .= "         ".$t_balance_name.".tune_amount != 0                    OR \n"; // Ĵ����
                $where_sql .= "         ".$t_balance_name.".rest_amount != 0                    OR \n"; // ���۳�
                $where_sql .= "         ".$t_balance_name.".".$arp."_balance_this != 0 \n";             // ����/��|��/�ݻĹ�
                $where_sql .= "     ) \n";
            }

            // �������
            if ($state != "0"){
                $where_sql .= "    AND t_client.state = '$state' \n";
            }

            // �����ʬ
            if ($trade != null){
                if ($trade_div == "buy" && $group_kind == "1"){
                    $where_sql .= "    AND t_client.buy_trade_id = $trade \n";
                }else{
                    $where_sql .= "    AND t_client.trade_id = $trade \n";
                }
            }

            //�������ɽ���ǡ������SQL
            $sql  = "SELECT \n";
            $sql .= "    $t_balance_name.client_cd1, \n";                   // 0 �����CD1
            $sql .= "    $t_balance_name.client_cd2, \n";                   // 1 �����CD2
            $sql .= "    $t_balance_name.client_cname, \n";                 // 2 �����̾��ά�Ρ�
            #$sql .= "    $t_balance_name.".$arp."_balance_last, \n";        // 3 ����/��|��/�ݻĹ�
            $sql .= "    COALESCE (first_".$arp."_balance.first_".$arp."_balance, $t_balance_name.".$arp."_balance_last) AS ".$arp."_balance_last, \n";        // 3 ����/��|��/�ݻĹ�
            $sql .= "    $t_balance_name.net_".$trade_div."_amount, \n";    // 4 ����/���|����/�ۡ���ȴ��
            $sql .= "    $t_balance_name.tax_amount, \n";                   // 5 �����ǳ�
            $sql .= "    $t_balance_name.intax_".$trade_div."_amount, \n";  // 6 ����/���|����/�ۡ��ǹ���
            $sql .= "    $t_balance_name.pay_amount, \n";                   // 7 ����/����|��ʧ/��
            $sql .= "   COALESCE(t_".$pay_div."_rebate.".$pay_div."_rebate, 0) AS pay_rebate, \n";  // 8 ����/����|��ʧ/�������
            $sql .= "    $t_balance_name.tune_amount, \n";                  // 9 Ĵ����
            $sql .= "    $t_balance_name.rest_amount, \n";                  //10 ���۳�
            if ($trade_div == "sale"){
            $sql .= "    $t_balance_name.installment_receivable_balance, \n";         //11 ������
            }else{
            $sql .= "    $t_balance_name.amortization_trade_balance, \n";         //11 ������
            }

            $sql .= "    $t_balance_name.".$arp."_balance_this, \n";        //12 ����/��|��/�ݻĹ�
            $sql .= "    $t_balance_name.staff1_name, \n";                  //13 SV�������ˤޤ��Ϸ���ô��1��FC��
            if($trade_div == "sale"){
                $sql .= "    $t_balance_name.staff2_name \n";               //14 ���ô��1�������ˤޤ��ϡ�FC��
            }else{
                $sql .= "    NULL, \n";
                $sql .= "    $t_balance_name.client_div \n";                //15 ������ʬ
            }
            $sql .= "FROM \n";
            $sql .= "    $t_balance_name \n";
            //$sql .= "    INNER JOIN t_client ON $t_balance_name.client_id = t_client.client_id \n";
            $sql .= "    INNER JOIN t_sys_renew ON t_".$arp."_balance.monthly_close_day_this = t_sys_renew.close_day \n";
            $sql .= "    INNER JOIN t_client ON $t_balance_name.client_id = t_client.client_id \n";
            $sql .= "    LEFT JOIN t_client_gr ON t_client_gr.client_gr_id = t_client.client_gr_id \n";

            // �����������麣�������ޤǤμ���������
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            if($trade_div == "sale"){
                $sql .= Monthly_Payin_Rebate_Sql ($shop_id, $start_day, $end_day, $renew_flg);
            }else{  
                $sql .= Monthly_Payout_Rebate_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }       
            $sql .= "
                    ) AS t_".$pay_div."_rebate ON t_client.client_id = t_".$pay_div."_rebate.client_id 
            ";

/*
            // �����ۼ�������ݻĹ����
            if ($trade_div == "sale"){
                $sql .= "LEFT JOIN \n";
                $sql .= "( \n";
                $sql .= "   SELECT \n";
                $sql .= "       t_sale_h.client_id, \n";
                $sql .= "       SUM(t_installment_sales.collect_amount) AS split_balance_amount \n";
                $sql .= "   FROM \n";
                $sql .= "       t_installment_sales \n";
                $sql .= "       INNER JOIN t_sale_h \n";
                $sql .= "           ON  t_installment_sales.sale_id = t_sale_h.sale_id \n";
                $sql .= "           AND t_sale_h.trade_id = 15 \n";
                $sql .= "           AND t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
                $sql .= "   WHERE \n";
                $sql .= "       t_installment_sales.collect_day > '$end_day' \n";
                $sql .= "   GROUP BY \n";
                $sql .= "       t_sale_h.client_id \n";
                $sql .= ") \n";
                $sql .= "AS t_split_balance \n";
                $sql .= "ON t_client.client_id = t_split_balance.client_id \n";
            // �����ۼ�������ݻĹ����
            }else{
                $sql .= "LEFT JOIN \n";
                $sql .= "( \n";
                $sql .= "   SELECT \n";
                $sql .= "       t_buy_h.client_id, \n";
                $sql .= "       SUM(t_amortization.split_pay_amount) AS split_balance_amount \n";
                $sql .= "   FROM \n";
                $sql .= "       t_amortization \n";
                $sql .= "       INNER JOIN t_buy_h \n";
                $sql .= "           ON  t_amortization.buy_id = t_buy_h.buy_id \n";
                $sql .= "           AND t_buy_h.trade_id = 25 \n";
                $sql .= "           AND t_buy_h.shop_id = ".$_SESSION["client_id"]." \n";
                $sql .= "   WHERE \n";
                $sql .= "       t_amortization.pay_day > '$end_day' \n";
                $sql .= "   GROUP BY \n";
                $sql .= "       t_buy_h.client_id \n";
                $sql .= ") \n";
                $sql .= "AS t_split_balance \n";
                $sql .= "ON t_client.client_id = t_split_balance.client_id \n";
            }
*/
			# ����Ĺ�Τߤ����
            $sql .= "    LEFT JOIN \n";
            $sql .= "(SELECT \n";
            $sql .= "    t_first_".$arp."_balance.".$arp."_balance AS first_".$arp."_balance, \n";
            $sql .= "    t_first_".$arp."_balance.client_id, \n";
            $sql .= "    first_data.first_close_day \n";
            $sql .= "FROM \n";
            $sql .= "    t_first_".$arp."_balance \n";
            $sql .= "      INNER JOIN \n";
            $sql .= "    (SELECT \n";
            $sql .= "      client_id, \n";
            $sql .= "      MIN(monthly_close_day_this) AS first_close_day \n";
            $sql .= "    FROM \n";
            $sql .= "      ".$t_balance_name . "\n";
            $sql .= "    WHERE shop_id = ".$shop_id."\n";
            $sql .= "    GROUP BY \n";
            $sql .= "     client_id \n";
            $sql .= "    ) first_data \n";
            $sql .= "    ON first_data.client_id = t_first_".$arp."_balance.client_id \n";
			$sql .= "	) first_".$arp."_balance \n";
            $sql .= " ON ".$t_balance_name.".client_id = first_".$arp."_balance.client_id \n";
            $sql .= " AND ".$t_balance_name.".monthly_close_day_this = first_".$arp."_balance.first_close_day \n";

            $sql .= "WHERE \n";
            $sql .= "    t_client.shop_id = $shop_id \n";
            $sql .= "    AND \n";
            //������ݻĹ������FC������Ф���
            if($group_kind == "1" && $trade_div == "buy"){
                $sql .= "    t_client.client_div = '3' \n";
                $sql .= "    AND \n";
            }
            $sql .= "    $t_balance_name.shop_id = $shop_id \n";
            $sql .= "    AND \n";
            //$sql .= "    $t_balance_name.monthly_close_day_this LIKE '$input_day-%' \n";
            $sql .= "    t_sys_renew.shop_id = $shop_id \n";
            $sql .= "    AND \n";
            $sql .= "    t_sys_renew.renew_div = '2' \n";
            $sql .= "    AND \n";
            $sql .= "    t_sys_renew.close_day LIKE '$input_day-%' \n";
            $sql .= $where_sql;
            $sql .= "ORDER BY \n";
            if($trade_div == "buy"){
                $sql .= "    client_div, \n";
            }
            $sql .= "    client_cd1, \n";
            $sql .= "    client_cd2 \n";

            $result = Db_Query($db_con, $sql.";");
            $total_count = pg_num_rows($result);    //�����

            $sql .= "LIMIT $range \n";
            $sql .= "OFFSET $offset \n";
            $sql .= ";\n";
//print_array($sql, "�������/��|��/�ݻĹ����");


            $result = Db_Query($db_con, $sql);
            $data_list_count = pg_num_rows($result);    //ɽ���ǡ������
            $data_list = Get_Data($result);
//print_array($data_list);

        //�Ϥ�Ƚ���꤬�������Ȥ��ʷ����̤�»ܤ�ǯ�����ꤵ�줿����
        }else{

            /* ������������� */

            //��������(��)�����
            $sql = "SELECT my_close_day FROM t_client WHERE client_id = $shop_id;";
            $result = Db_Query($db_con, $sql);
            $my_close_day = pg_fetch_result($result, 0, 0);     //��������(��)

            $close_day_this  = $input_day;
            $close_day_this .= "-";
            $close_day_this .= ($my_close_day == 29) ? date("t", mktime(0, 0, 0, $input_day_m, 1, $input_day_y)) : $my_close_day;   //����ǯ�������(ǯ����)


            //����η�����������
            $sql  = "SELECT \n";
            $sql .= "    close_day \n";
            $sql .= "FROM \n";
            $sql .= "    t_sys_renew \n";
            $sql .= "WHERE \n";
            $sql .= "    shop_id = ".$shop_id." \n";
            $sql .= "    AND \n";
            $sql .= "    renew_div = '2' \n";
            $sql .= "ORDER BY \n";
            $sql .= "    close_day DESC \n";
            $sql .= "LIMIT 1 \n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            $close_day_last = (pg_num_rows($result) == 0) ? START_DAY : pg_fetch_result($result, 0, 0);     //����η������


            $start_day = $close_day_last;   //��д��֤λϤ�
            $end_day   = $close_day_this;   //��д��֤ν����

            //�Ϥ�Ƚ����δط�����������������н���
            //if($start_day < $end_day){


            //WHERE�����
            $where_sql = "";

            //����襳����
            if($client_cd1 != null){
                $where_sql .= ($where_sql == "") ? "    WHERE \n" : "    AND \n";
                $where_sql .= "    client_cd1 LIKE '".$client_cd1."%' \n";
            }
            if($client_cd2 != null){
                $where_sql .= ($where_sql == "") ? "    WHERE \n" : "    AND \n";
                $where_sql .= "    client_cd2 LIKE '".$client_cd2."%' \n";
            }


            $client_where_sql  = "    WHERE \n";
            $client_where_sql .= "        t_client.shop_id = $shop_id \n";
            //������ݻĹ������FC������Ф���
            if($group_kind == "1" && $trade_div == "buy"){
                $client_where_sql .= "        AND \n";
                $client_where_sql .= "        t_client.client_div = '3' \n";
            }

            //�����̾�����롼�ס�FC�������
            //  �������̤��ѿ��ˤ����ʥᥤ��ǤϤʤ����֥��������Ǹ�������Ȥ������
            if($client_name != null || $client_gr != null || $client_gr_name != null || $rank != null){

                //�����̾
                if($client_name != null){
                    $client_where_sql .= "    AND \n";
                    $client_where_sql .= "    ( \n";
                    $client_where_sql .= "        t_client.client_name  LIKE '%".$client_name."%' OR \n";
                    $client_where_sql .= "        t_client.client_name2 LIKE '%".$client_name."%' OR \n";
                    $client_where_sql .= "        t_client.client_cname LIKE '%".$client_name."%' \n";
                    $client_where_sql .= "    ) \n";
                }

                //���롼��
                if($client_gr != null){
                    $client_where_sql .= "    AND \n";
                    $client_where_sql .= "    t_client.client_gr_id = $client_gr \n";
                }
                if($client_gr_name != null){
                    $client_where_sql .= "    AND \n";
                    $client_where_sql .= "    t_client_gr.client_gr_name LIKE '%$client_gr_name%' \n";
                }

                //FC��������ʬ
                if($rank != null){
                    $client_where_sql .= "    AND \n";
                    $client_where_sql .= "    t_client.rank_cd = '$rank' \n";
                }
            }

/*
            //SV
            if($staff1 != null){
                //$where_sql .= "    AND staff1_name = '".$select_staff1[$_POST["form_staff1"]]."' \n";
                $where_sql .= "    AND staff1_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$staff1.") \n";
            }

            //���ô��1
            if($staff2 != null){
                //$where_sql .= "    AND staff2_name = '".$select_staff2[$_POST["form_staff2"]]."' \n";
                $where_sql .= "    AND staff2_name = (SELECT staff_name FROM t_staff WHERE staff_id = ".(int)$staff2.") \n";
            }
*/

            //����/��|��/�ݻĹ�
            //����
            if($balance_this_min != null){
                $where_sql .= ($where_sql == "") ? "    WHERE \n" : "    AND \n";
                $where_sql .= "    ".$arp."_balance_this >= '".$balance_this_min."' \n";
            }
            //��λ
            if($balance_this_max != null){
                $where_sql .= ($where_sql == "") ? "    WHERE \n" : "    AND \n";
                $where_sql .= "    ".$arp."_balance_this <= '".$balance_this_max."' \n";
            }

            //�������ʬ
            if($trade_div == "buy" && $group_kind == "1"){
                if($supplier_div == "2" || $supplier_div == "3"){
                    $client_where_sql .= ($client_where_sql == "") ? "    WHERE \n" : "    AND \n";
                    //$client_where_sql .= "    t_client.client_div = '".$supplier_div."' \n";
                    $client_where_sql .= "    t_client.rank_cd IN ('0001', '0002') \n";
                }              
            }

            // �Ĺ�ʥ饸���ܥ����
            if ($balance_radio == "1"){
                $where_sql .= ($where_sql == "") ? "    WHERE \n" : "    AND \n";
                $where_sql .= "     ( \n";
                $where_sql .= "         ".$arp."_balance_last != 0          OR \n"; // ����/��|��/�ݻĹ�
                $where_sql .= "         net_".$trade_div."_amount != 0      OR \n"; // ����/���|����/�ۡ���ȴ��
                $where_sql .= "         tax_amount != 0                     OR \n"; // �����ǳ�
                $where_sql .= "         intax_".$trade_div."_amount != 0    OR \n"; // ����/���|����/�ۡ��ǹ���
                $where_sql .= "         pay_amount != 0                     OR \n"; // ����/����|��ʧ/��
                $where_sql .= "         tune_amount != 0                    OR \n"; // Ĵ����
                $where_sql .= "         rest_amount != 0                    OR \n"; // ���۳�
                $where_sql .= "         ".$arp."_balance_this != 0 \n";             // ����/��|��/�ݻĹ�
                $where_sql .= "     ) \n";
            }

            // �������
            if ($state != "0"){
                $client_where_sql .= ($client_where_sql == "") ? "    WHERE \n" : "    AND \n";
                $client_where_sql .= "    t_client.state = '$state' \n";
            }

            // �����ʬ
            if ($trade != null){
                if ($trade_div == "buy" && $group_kind == "1"){
                    $client_where_sql .= ($client_where_sql == "") ? "    WHERE \n" : "    AND \n";
                    $client_where_sql .= "    t_client.buy_trade_id = $trade \n";
                }else{
                    $client_where_sql .= ($client_where_sql == "") ? "    WHERE \n" : "    AND \n";
                    $client_where_sql .= "    t_client.trade_id = $trade \n";
                }
            }

            $sql  = "SELECT \n";
            $sql .= "    client_cd1, \n";                   // 0 �����CD1
            $sql .= "    client_cd2, \n";                   // 1 �����CD2
            $sql .= "    client_cname, \n";                 // 2 �����̾��ά�Ρ�
            $sql .= "    ".$arp."_balance_last, \n";        // 3 ����/��|��/�ݻĹ�
            $sql .= "    net_".$trade_div."_amount, \n";    // 4 ����/���|����/�ۡ���ȴ��
            $sql .= "    tax_amount, \n";                   // 5 �����ǳ�
            $sql .= "    intax_".$trade_div."_amount, \n";  // 6 ����/���|����/�ۡ��ǹ���
            $sql .= "    pay_amount, \n";                   // 7 ����/����|��ʧ/��
            $sql .= "    pay_rebate, \n";                   // 8 ����/����|��ʧ/�������
            $sql .= "    tune_amount, \n";                  // 9 Ĵ����
            $sql .= "    rest_amount, \n";                  //10 ���۳�
            $sql .= "    split_balance_amount, \n";         //11 ������
            $sql .= "    ".$arp."_balance_this, \n";        //12 ����/��|��/�ݻĹ�
            $sql .= "    staff1_name, \n";                  //13 SV�������ˤޤ��Ϸ���ô��1��FC��
            $sql .= "    staff2_name, \n";                  //14 ���ô��1�������ˤޤ��ϡ�FC��
            $sql .= "    client_div \n";                    //15 ������ʬ
            $sql .= "FROM \n";
            $sql .= "    ( \n";

            $sql .= "
                SELECT 
                    t_client.client_cd1, 
                    t_client.client_cd2, 
                    t_client.client_cname, 
                    COALESCE(t_".$arp."_balance_last.".$arp."_balance_last, 0) AS ".$arp."_balance_last, 
                    ( COALESCE(t_".$trade_div."_amount.net_".$trade_div."_amount, 0) 
                      + COALESCE(t_royalty.royalty_price, 0) 
                    ) AS net_".$trade_div."_amount, 
                    ( COALESCE(t_".$trade_div."_amount.tax_amount, 0) 
                      + COALESCE(t_royalty.royalty_tax, 0) 
                      + COALESCE(t_adjust_tax.adjust_tax, 0) 
                    ) AS tax_amount, 
                    ( COALESCE(t_".$trade_div."_amount.net_".$trade_div."_amount, 0) 
                      + COALESCE(t_royalty.royalty_price, 0) 
                      + COALESCE(t_".$trade_div."_amount.tax_amount, 0) 
                      + COALESCE(t_royalty.royalty_tax, 0) 
                      + COALESCE(t_adjust_tax.adjust_tax, 0) 
                    ) AS intax_".$trade_div."_amount, 
                    COALESCE(t_".$pay_div."_amount.".$pay_div."_amount, 0) AS pay_amount, 
                    COALESCE(t_".$pay_div."_rebate.".$pay_div."_rebate, 0) AS pay_rebate, 
                    COALESCE(t_".$pay_div."_amount.tune_amount, 0) AS tune_amount, 
                    ( COALESCE(t_".$arp."_balance_last.".$arp."_balance_last, 0) 
                      - COALESCE(t_".$pay_div."_amount.".$pay_div."_amount, 0) 
                      - COALESCE(t_".$pay_div."_amount.tune_amount, 0) 
                    ) AS rest_amount, 
                    ( COALESCE(t_".$arp."_balance_last.".$arp."_balance_last, 0) 
                      - COALESCE(t_".$pay_div."_amount.".$pay_div."_amount, 0) 
                      - COALESCE(t_".$pay_div."_amount.tune_amount, 0) 
                      + COALESCE(t_".$trade_div."_amount.net_".$trade_div."_amount, 0) 
                      + COALESCE(t_royalty.royalty_price, 0) 
                      + COALESCE(t_".$trade_div."_amount.tax_amount, 0) 
                      + COALESCE(t_royalty.royalty_tax, 0) 
                      + COALESCE(t_adjust_tax.adjust_tax, 0) 
                    ) AS ".$arp."_balance_this, 
            ";
            //��ݻĹ�����ξ���ô���Լ���
            if($trade_div == "sale"){
                //�������̤Ǥ�FC�ޥ�����SV�����ô��1��ɽ��
                if($group_kind == "1"){
                    $sql .= "
                    (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.sv_staff_id) AS staff1_name, 
                    (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.b_staff_id1) AS staff2_name, 
                    ";
                //FC���̤Ǥ�������ޥ����η���ô��1������ô��2��ɽ��
                }else{
                    $sql .= "
                    (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.c_staff_id1) AS staff1_name, 
                    (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.c_staff_id2) AS staff2_name, 
                    ";
                }

            //��ݻĹ�����ξ���ô����
            }else{
                //�������̡�FC���̤Ȥ⡢������ξ��Ϸ���ô��1��FC�ξ���SV��ɽ��
                //��2���ܤ���ݻĹ�����ǤϻȤ�ʤ��Τ�NULL��
                $sql .= "
                    CASE t_client.client_div 
                        WHEN '2' THEN (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.c_staff_id1) 
                        ELSE          (SELECT staff_name FROM t_staff WHERE t_staff.staff_id = t_client.sv_staff_id) 
                    END AS staff1_name, 
                    NULL AS staff2_name, 
                ";
            }

            $sql .= "
                    t_client.client_div, 
                    t_split_balance.split_balance_amount 

                FROM 
            ";

            //����������/���|����/��/����|��ʧ/���������/��|��/�ݻĹ�������ˤΤ��ä������ID���������
            $sql .= "
                    ( 
            ";
            $sql .= Monthly_All_Client_Sql_For_Balance($shop_id, $trade_div, $end_day, $renew_flg);
            $sql .= "
                    ) AS t_all_client 

                    INNER JOIN t_client ON t_all_client.client_id = t_client.client_id 
                    LEFT JOIN t_client_gr ON t_client_gr.client_gr_id = t_client.client_gr_id 
            ";

            //�����������η����������ݻĹ�����
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            $sql .= Monthly_Balance_Last_Sql($shop_id, $trade_div);
            $sql .= "
                    ) AS t_".$arp."_balance_last ON t_all_client.client_id = t_".$arp."_balance_last.client_id 
            ";

            //�����������麣�������ޤǤ�/���|����/�ۡ���ȴ�ˡ������ǳۡ�/���|����/�ۡ��ǹ��ˤ����
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            if($trade_div == "sale"){
                $sql .= Monthly_Sale_Amount_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }else{
                $sql .= Monthly_Buy_Amount_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }
            $sql .= "
                    ) AS t_".$trade_div."_amount ON t_all_client.client_id = t_".$trade_div."_amount.client_id 
            ";

            //�����������麣�������ޤǤ�����ۡʽ�Ĵ���ۡˡ�Ĵ���ۤ����
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            if($trade_div == "sale"){
                $sql .= Monthly_Payin_Amount_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }else{
                $sql .= Monthly_Payout_Amount_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }
            $sql .= "
                    ) AS t_".$pay_div."_amount ON t_all_client.client_id = t_".$pay_div."_amount.client_id 
            ";

            // �����������麣�������ޤǤμ���������
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            if($trade_div == "sale"){
                $sql .= Monthly_Payin_Rebate_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }else{
                $sql .= Monthly_Payout_Rebate_Sql($shop_id, $start_day, $end_day, $renew_flg);
            }
            $sql .= "
                    ) AS t_".$pay_div."_rebate ON t_all_client.client_id = t_".$pay_div."_rebate.client_id 
            ";

            //�����������麣�������ޤǤΥ������ƥ��ۡ����ξ����ǳۤ����
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            $sql .= Monthly_Lump_Amount_Sql($shop_id, $start_day, $end_day, "1", $trade_div);
            $sql .= "
                    ) AS t_royalty ON t_all_client.client_id = t_royalty.client_id 
            ";

            //�����������麣�������ޤǤΰ������ǳۤ����
            $sql .= "
                    LEFT JOIN 
                    ( 
            ";
            $sql .= Monthly_Lump_Amount_Sql($shop_id, $start_day, $end_day, "2", $trade_div);
            $sql .= "
                    ) AS t_adjust_tax ON t_all_client.client_id = t_adjust_tax.client_id 
            ";


            // �����ۼ�������ݻĹ����
            if ($trade_div == "sale"){
                $sql .= "LEFT JOIN \n";
                $sql .= "( \n";
                $sql .= "   SELECT \n";
                $sql .= "       t_sale_h.client_id, \n";
                $sql .= "       SUM(t_installment_sales.collect_amount) AS split_balance_amount \n";
                $sql .= "   FROM \n";
                $sql .= "       t_installment_sales \n";
                $sql .= "       INNER JOIN t_sale_h \n";
                $sql .= "           ON  t_installment_sales.sale_id = t_sale_h.sale_id \n";
                $sql .= "           AND t_sale_h.trade_id = 15 \n";
                $sql .= "           AND t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
                $sql .= "   WHERE \n";
                $sql .= "       t_installment_sales.collect_day > '$end_day' \n";
                $sql .= "        AND \n";
                $sql .= "       t_sale_h.sale_day <= '$end_day' \n";
                $sql .= "   GROUP BY \n";
                $sql .= "       t_sale_h.client_id \n";
                $sql .= ") \n";
                $sql .= "AS t_split_balance \n";
                $sql .= "ON t_all_client.client_id = t_split_balance.client_id";
            // �����ۼ�������ݻĹ����
            }else{
                $sql .= "LEFT JOIN \n";
                $sql .= "( \n";
                $sql .= "   SELECT \n";
                $sql .= "       t_buy_h.client_id, \n";
                $sql .= "       SUM(t_amortization.split_pay_amount) AS split_balance_amount \n";
                $sql .= "   FROM \n";
                $sql .= "       t_amortization \n";
                $sql .= "       INNER JOIN t_buy_h \n";
                $sql .= "           ON  t_amortization.buy_id = t_buy_h.buy_id \n";
                $sql .= "           AND t_buy_h.trade_id = 25 \n";
                $sql .= "           AND t_buy_h.shop_id = ".$_SESSION["client_id"]." \n";
                $sql .= "   WHERE \n";
                $sql .= "       t_amortization.pay_day > '$end_day' \n";
                $sql .= "        AND \n";
                $sql .= "       t_buy_h.buy_day <= '$end_day' \n";
                $sql .= "   GROUP BY \n";
                $sql .= "       t_buy_h.client_id \n";
                $sql .= ") \n";
                $sql .= "AS t_split_balance \n";
                $sql .= "ON t_all_client.client_id = t_split_balance.client_id \n";
            }


            $sql .= $client_where_sql;  //������̾�Ǥθ������

            $sql .= "    ) AS $t_balance_name \n";

            $sql .= $where_sql;         //������̾�ʳ��θ������

            $result = Db_Query($db_con, $sql.";");
            $total_count = pg_num_rows($result);    //�����

            $sql .= "ORDER BY \n";
            if($trade_div == "buy"){
                $sql .= "    client_div, \n";
            }
            $sql .= "    client_cd1, \n";
            $sql .= "    client_cd2 \n";
            $sql .= "LIMIT $range \n";
            $sql .= "OFFSET $offset \n";
            $sql .= ";\n";
//print_array($sql, "�������/��|��/�ݽ���SQL��");


            $result = Db_Query($db_con, $sql);
            $data_list_count = pg_num_rows($result);    //ɽ���ǡ������
            $data_list = Get_Data($result);
//print_array($data_list);


            //�Ϥ�Ƚ���꤬�������ʤ���
/*
            }else{
                //$total_count = 0;   //�����
                $data_list_count = 0;   //ɽ���ǡ������
                $data_list = null;      //ɽ���ǡ������
            }
*/

        }//��������ǡ�������н����

        for($i=0;$i<$data_list_count;$i++){
            $disp_data[$i][0]  = $data_list[$i][0]; //�����CD1
            $disp_data[$i][1]  = $data_list[$i][1]; //�����CD2
            $disp_data[$i][2]  = $data_list[$i][2]; //�����̾��ά�Ρ�
            //������ݻĹ⤬�ޥ��ʥ��ξ����Ļ���0�ʾ�ξ����ֻ���
            $money_color = ($data_list[$i][3] < 0) ? "#3366FF" : "red";

            // ����/��ʧ�ۤ�������ʬ�����
            $data_list[$i][7] -= $data_list[$i][8];

            for($j=3;$j<=12;$j++){
                //������ɽ�������۽���
                $total_money[$j] = $total_money[$j] + $data_list[$i][$j];

                //�ޥ��ʥ���ۤ˿���Ĥ����number_format
                if($data_list[$i][$j] < 0){
                    $disp_data[$i][$j] = "<font color=\"$money_color\">".number_format($data_list[$i][$j])."</font>";
                }else{
                    $disp_data[$i][$j] = number_format($data_list[$i][$j]);
                }
            }

            $disp_data[$i][13] = ($data_list[$i][14] == null) ? "&nbsp;" : $data_list[$i][13];  //SV�������ˤޤ��Ϸ���ô��1��FC��
            $disp_data[$i][14] = ($data_list[$i][14] == null) ? "&nbsp;" : $data_list[$i][14];  //���ô��1�������ˤޤ��ϡ�FC��

            $disp_data[$i][15] = $data_list[$i][15];    //������ʬ

            $disp_data[$i][16] = $offset + $i + 1;      //���ֹ�

        }

        //��׶�ۤ�number_format
        for($j=3;$j<=11;$j++){
            $total_money[$j] = Minus_Numformat($total_money[$j]);
        }

    }//���顼����ʤ����ν��������

}//ɽ���ܥ��󲡲����ν��������


//$total_count = ($total_count != null) ? $total_count : 0;


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
//$page_menu = Create_Menu_h('sale','5');

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);


/****************************/
//�ڡ�������
/****************************/

//ɽ���ϰϻ���
//$range = "20";

//�ڡ����������
//$page_count = $_POST["f_page1"];

//����ɽ�����ޤ����������ɽ������ʲ��ξ��
if($range == "ALL" || $total_count <= $range){
    $range = $total_count;
    $page_count = null;
}

$html_page  = Html_Page($total_count, $page_count, 1, $range);
//$html_page  = Html_Page($total_count, $page_count, 1, $total_count);
$html_page2 = Html_Page($total_count, $page_count, 2, $range);


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
    'input_day'     => "$input_day",
    'data_list_count'   => "$data_list_count",
    'group_kind'    => "$group_kind",
    'trade_div'     => "$trade_div",
    "err_flg"       => "$err_flg",
));

//�ơ��֥�ɽ���ǡ�����assign
$smarty->assign('disp_data', $disp_data);
$smarty->assign('total_money', $total_money);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


//print_array($form, "form");

//print_array($_POST);


?>