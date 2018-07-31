<?php
/*
 *  2007-08-28       watanabe-k     ��������ۤ���������ؤ�ɽ��
 *
 *
 *
 */

$page_title = "������Ĺ����";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_count_day"    => array(
        "y" => date("Y"),
        "m" => date("m"),
        "d" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    ),
    "form_display_num"  => "50",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_group"        => array("name" => "", "select" => ""),
    "form_state"        => "1",
);

// �����������
Restore_Filter2($form, "advance", "form_display", $ary_form_list);


/****************************/
//�����ѿ�����
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];


/****************************/
// ���������
/****************************/
$limit          = "50";     // LIMIT
$offset         = "0";      // OFFSET
$display_num    = $limit;   // ɽ�����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����

$form->setDefaults($ary_form_list);


/****************************/
// �ե�����ѡ������
/****************************/
// ������
Addelement_Date($form, "form_count_day", "", "-");

// ɽ�����
$item   =   null;
$item   =   array("10" => "10", "50" => "50", "100" => "100", null => "����");
$form->addElement("select", "form_display_num", "", $item, $g_form_option_select);

// ������
Addelement_Client_64n($form, "form_client", "", "-");

// ���롼��
$item   =   null;
$item   =   Select_Get($db_con, "client_gr");
$obj    =   null;
$obj[]  =   $form->createElement("text", "name", "", "size=\"34\" maxLength=\"25\" $g_form_option");
$obj[]  =   $form->createElement("static", "", "", " ");
$obj[]  =   $form->createElement("select", "select", "", $item, $g_form_option_select);
$form->addGroup($obj, "form_group", "", "");

// ���֡ʼ�����
$obj    =   null;   
$obj[]  =&  $form->createElement("radio", null, null, "�����",       "1");   
$obj[]  =&  $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
$obj[]  =&  $form->createElement("radio", null, null, "����",         "0");   
$form->addGroup($obj, "form_state", "");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button","form_clear","���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ��������
    // ɬ�ܥ����å�
    if ($_POST["form_count_day"]["y"] == null || $_POST["form_count_day"]["m"] == null || $_POST["form_count_day"]["d"] == null){
        $form->setElementError("form_count_day", "������ ��ɬ�ܤǤ���");
    }else{
        Err_Chk_Date($form, "form_count_day", "������ �����դ������ǤϤ���ޤ���");
    }

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $test = $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


/****************************/
// POST���ѿ��˥��å�
/****************************/
if ($_POST != null && $err_flg != true){

    // ����POST�ǡ�����0���
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    // POST�ǡ������ѿ��˥��å�
    $count_day_y    = $_POST["form_count_day"]["y"];
    $count_day_m    = $_POST["form_count_day"]["m"];
    $count_day_d    = $_POST["form_count_day"]["d"];
    $display_num    = $_POST["form_display_num"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client"]["name"];
    $group_name     = $_POST["form_group"]["name"];
    $group_select   = $_POST["form_group"]["select"];
    $state          = $_POST["form_state"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // ������
    $count_day = $count_day_y.$count_day_m.$count_day_d;
    $count_day = ($count_day != null) ? $count_day : date("Ymd");
    // �����襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_client.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳���ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_client.client_cd2 LIKE '$client_cd2%' \n" : null;
    // ������̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_client.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ���롼��̾
    $sql .= ($group_name != null) ? "AND t_client_gr.client_gr_name LIKE '%$group_name%' \n" : null;
    // ���롼�ץ��쥯��
    $sql .= ($group_select != null) ? "AND t_client_gr.client_gr_id = $group_select \n" : null;
    // �������
    $sql .= ($state != "0") ? "AND t_client.state = $state \n" : null;

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   advance_data.advance_total, \n";
    $sql .= "   payin_data.payin_total, \n";
    $sql .= "   COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       UNION \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.client_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS client_list \n";
    $sql .= "   INNER JOIN t_client    ON client_list.client_id = t_client.client_id \n";
    $sql .= "   LEFT  JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id \n";
    $sql .= "   LEFT  JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP \n";
    $sql .= "           BY client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data \n";
    $sql .= "   ON t_client.client_id = advance_data.client_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id, \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.pay_day <= '$count_day' \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           client_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data \n";
    $sql .= "   ON t_client.client_id = payin_data.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_client.client_div = '1' \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "   client_cd1, \n";
    $sql .= "   client_cd2 \n";

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // ɽ�����
    switch ($display_num){
        case "10":
            $limit = "10";
            break;
        case "50":
            $limit = "50";
            break;
        case "100":
            $limit = "100";
            break;
        case null:
            $limit = $total_count;
            break;
    }

    // �������ϰ���
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_data       = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // �����
    $html_l     = null;
    $sum_amount = 0;

    // �����ǡ����������硢�ǡ�����ʬ�롼��
    if (count($ary_data) > 0){
    foreach ($ary_data as $key => $value){

        /****************************/
        // ������
        /****************************/
        // �Կ�
        $ary_disp_data[$key]["css"]     = (bcmod($key, 2) == 0) ? "Result1" : "Result2";

        // No.
        $ary_disp_data[$key]["no"]      = (($page_count - 1) * $limit) + $key + 1;

        // ������
        $ary_disp_data[$key]["client"]  = $value["client_cd"]."<br>".htmlspecialchars($value["client_cname"])."<br>";

        // ������
        $ary_disp_data[$key]["advance"] = $value["advance_total"];

        // �껦��
        $ary_disp_data[$key]["payin"]   = $value["payin_total"];

        // ���(������Ĺ�)
        $ary_disp_data[$key]["amount"]  = $value["advances_balance"];

        // ��׶�۲û�
        $advance_amount += $value["advance_total"];
        $payin_amount   += $value["payin_total"];
        $sum_amount     += $value["advances_balance"];

        /****************************/
        // html����
        /****************************/
        $html_l .= "    <tr class=\"".$ary_disp_data[$key]["css"]."\">\n";
        $html_l .= "        <td align=\"right\">".$ary_disp_data[$key]["no"]."</td>\n";
        $html_l .= "        <td>".$ary_disp_data[$key]["client"]."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($ary_disp_data[$key]["advance"])."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($ary_disp_data[$key]["payin"])."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($ary_disp_data[$key]["amount"])."</td>\n";
        $html_l .= "    </tr>\n";

    }
    }

    // ��׹Ժ���
    $html_g  = "    <tr class=\"Result3\">\n";
    $html_g .= "        <td><b>���</b></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($advance_amount)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($payin_amount)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_amount)."</td>\n";
    $html_g .= "    </tr>\n";

    // �ڡ���ʬ��html����
    $html_page1 = Html_Page2($total_count, $page_count, 1, $limit);
    $html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

}


/****************************/
// HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
    "match_count"   => "$match_count",
));

// html��assign
$smarty->assign("html", array(
    "html_page1"    =>  $html_page1,
    "html_page2"    =>  $html_page2,
    "html_s"        =>  $html_s,
    "html_l"        =>  $html_l,
    "html_g"        =>  $html_g,
));

// ���顼��assign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
