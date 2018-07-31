<?php
/*
 *
 *
 *
 *
 */

$page_title = "�������ʧ����";

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
//�����ѿ�����
/****************************/
// SESSION
$shop_id    = $_SESSION["client_id"];


/****************************/
// �ե�����ѡ������
/****************************/
// ��������
$form->addElement("link", "form_client_link", "", "#", "������", "taxindex=\"-1\"
    onClick=\"return Open_SubWin('../dialog/2-0-402.php',
        Array('form_client[cd1]', 'form_client[cd2]', 'form_client[name]', 'client_search_flg'),
        500, 450, 5, 1
    );\"
");

// ������
$obj    =   null;
$obj[]  =&  $form->createElement("text", "cd1", "", "
    size=\"7\" maxLength=\"6\" class=\"ime_disabled\"
    onChange=\"javascript: Change_Submit('client_search_flg', '#', 'true', 'form_client[cd2]');\"
    onkeyup=\"changeText(this.form, 'form_client[cd1]', 'form_client[cd2]', 6);\" $g_form_option
");
$obj[]  =&  $form->createElement("static", "", "", "-");
$obj[]  =&  $form->createElement("text", "cd2", "", "
    size=\"4\" maxLength=\"4\" class=\"ime_disabled\"
    onChange=\"javascript: Button_Submit('client_search_flg', '#', 'true');\" $g_form_option
");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($obj, "form_client", "", "");

// ���״���
Addelement_Date_Range($form, "form_count_day", "", "-");

// ɽ���ܥ���
$form->addElement("submit", "form_display", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button","form_clear","���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// hidden
$form->addElement("hidden", "client_search_flg");   // �����踡���ե饰
$form->addElement("hidden", "hdn_client_id");       // ������ID


/****************************/
// ������ե���������ϡ��䴰����
/****************************/
// �����踡���ե饰��true�ξ��
if ($_POST["client_search_flg"] == "true"){

    // POST���줿�����襳���ɤ��ѿ�������
    $client_cd1 = $_POST["form_client"]["cd1"];
    $client_cd2 = $_POST["form_client"]["cd2"];

    // ������ξ�������
    $sql  = "SELECT \n";
    $sql .= "   client_id, \n";
    $sql .= "   client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   client_cd1 = '$client_cd1' \n";
    $sql .= "AND \n"; 
    $sql .= "   client_cd2 = '$client_cd2' \n";
    $sql .= "AND \n"; 
    $sql .= "   client_div = '1' \n";
    $sql .= "AND \n"; 
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �����ǡ�����������
    if ($num > 0){
        $client_id      = pg_fetch_result($res, 0, 0);      // ������ID
        $client_cname   = pg_fetch_result($res, 0, 1);      // ������̾ά��
    }else{
        $client_id      = ""; 
        $client_cname   = "";
    }

    // �����襳�������ϥե饰�򥯥ꥢ
    // ������ID��hidden�˥��å�
    // ������̾ά�Υե�����˥��å�
    $client_data["client_search_flg"]   = "";   
    $client_data["hdn_client_id"]       = $client_id;
    $client_data["form_client"]["name"] = $client_cname;
    $form->setConstants($client_data);

}


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
    // ���顼��å�����
    $err_msg = "������ �����襳���� �����Ϥ��Ʋ�������";

    // ɬ�ܥ����å�
    $form->addGroupRule("form_client", array(
        "cd1"   => array(array($err_msg, "required")),
        "cd2"   => array(array($err_msg, "required")),
        "name"  => array(array($err_msg, "required")),
    ));

    // ���ͥ����å�
    $form->addGroupRule("form_client", array(
        "cd1"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
        "cd2"   => array(array($err_msg, "regex", "/^[0-9]+$/")),
    ));

    // �����襳���ɤ������������å�
    $sql  = "SELECT \n";
    $sql .= "   client_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_client \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   client_cd1 = '".$_POST["form_client"]["cd1"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_cd2 = '".$_POST["form_client"]["cd2"]."' \n";
    $sql .= "AND \n";
    $sql .= "   client_div = '1' \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        // �����褬¸�ߤ�����ϳ��������������ѿ�������
        $client_id = pg_fetch_result($res, 0, 0);
    }else{
        // �����褬¸�ߤ��ʤ����ϥ��顼�򥻥å�
        $form->setElementError("form_client", $err_msg);
    }

    // �����״���
    // ɬ�ܥ����å�
    if (
        $_POST["form_count_day"]["sy"] == null || $_POST["form_count_day"]["sm"] == null || $_POST["form_count_day"]["sd"] == null ||
        $_POST["form_count_day"]["ey"] == null || $_POST["form_count_day"]["em"] == null || $_POST["form_count_day"]["ed"] == null
    ){
        $form->setElementError("form_count_day", "���״��� ��ɬ�ܤǤ���");
    }else{
        Err_Chk_Date($form, "form_count_day", "���״��� �����դ������ǤϤ���ޤ���");
    }

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $test = $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = true;

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // ����POST�ǡ�����0���
    $_POST["form_count_day"] = Str_Pad_Date($_POST["form_count_day"]);

    // POST�ǡ������ѿ��˥��å�
    $count_day_s    = $_POST["form_count_day"]["sy"].$_POST["form_count_day"]["sm"].$_POST["form_count_day"]["sd"];
    $count_day_e    = $_POST["form_count_day"]["ey"].$_POST["form_count_day"]["em"].$_POST["form_count_day"]["ed"];
    $client_id      = $_POST["hdn_client_id"];

    // ���ۻĹ����
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(advance_data.advance_total, 0) - COALESCE(payin_data.payin_total, 0) AS advances_balance \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM(amount) AS advance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_advance \n";
    $sql .= "       WHERE \n";
    $sql .= "           pay_day < '$count_day_s' \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS advance_data, \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           SUM(t_payin_d.amount) AS payin_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.pay_day < '$count_day_s' \n";
    $sql .= "       AND \n";
    $sql .= "           t_payin_d.trade_id = 40 \n";
    $sql .= "       AND \n";
    $sql .= "           client_id = $client_id \n";
    $sql .= "       AND \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS payin_data \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $balance_forward = pg_fetch_result($res, 0, 0);
    }else{
        $balance_forward = 0;
    }

    // ���٥ǡ�������
    // ������
    $sql  = "SELECT \n";
    $sql .= "   pay_day     AS trading_day, \n";
    $sql .= "   advance_no  AS slip_no, \n";
    $sql .= "   NULL        AS trade_name, \n";
    $sql .= "   '������'    AS formal_name, \n";
    $sql .= "   amount      AS advance_amount, \n";
    $sql .= "   NULL        AS advance_offset_amount, \n";
    $sql .= "   0           AS line, \n";
    $sql .= "   't'         AS advance_flg, \n";
    $sql .= "   'f'         AS offset_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_advance \n";
    $sql .= "WHERE \n";
    $sql .= "   pay_day >= '$count_day_s' \n";
    $sql .= "AND \n";
    $sql .= "   pay_day <= '$count_day_e' \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= "UNION ALL \n";
    // �����껦��
    $sql .= "SELECT \n";
    $sql .= "   t_sale_h.sale_day               AS trading_day, \n";
    $sql .= "   t_sale_h.sale_no                AS slip_no, \n";
    $sql .= "   t_trade.trade_name              AS trade_name, \n";
    $sql .= "   v_sale_d.formal_name            AS formal_name, \n";
    $sql .= "   NULL                            AS advance_amount, \n";
    $sql .= "   v_sale_d.advance_offset_amount  AS advance_offset_amount, \n";
    $sql .= "   v_sale_d.line                   AS line, \n";
    $sql .= "   'f'                             AS advance_flg, \n";
    $sql .= "   't'                             AS offset_flg ";
    $sql .= "FROM \n";
    $sql .= "   t_sale_h \n";
    $sql .= "   INNER JOIN v_sale_d ON t_sale_h.sale_id = v_sale_d.sale_id \n";
    $sql .= "   INNER JOIN t_trade  ON t_sale_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   v_sale_d.advance_flg = '2' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day >= '$count_day_s' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day <= '$count_day_e' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.shop_id = $shop_id \n";
    // ������
    $sql .= "ORDER BY \n";
    $sql .= "   trading_day, \n";
    $sql .= "   slip_no, \n";
    $sql .= "   line \n";
    $sql .= ";";

    // ���������
    $res            = Db_Query($db_con, $sql);
    $total_count    = pg_num_rows($res);
    $ary_data       = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // �����
    $html_l             = null;
    $sum_advance_amount = 0;                    // ��������
    $sum_advance_offset = 0;                    // �����껦�۹��
    $sum_balance_amount = $balance_forward;     // ������Ĺ��סʽ���ͤ򷫱ۻĹ�������
    $color_row          = 0;                    // �Կ��ֹ�

    /****************************/
    // html�����ʷ��ۻĹ�ԡ�
    /****************************/
    $html_l .= "    <tr class=\"Result1\">\n";
    $html_l .= "        <td align=\"right\">1</td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td align=\"right\">���ۻĹ�</td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td></td>\n";
    $html_l .= "        <td align=\"right\">".Numformat_Ortho($balance_forward)."</td>\n";
    $html_l .= "    </tr>\n";

    // �����ǡ����������硢�ǡ�����ʬ�롼��
    if (count($ary_data) > 0){
    foreach ($ary_data as $key => $value){

        /****************************/
        // ������
        /****************************/
        // Ʊ����ɼ���2���ܰʹߤ���ɼ�ֹ�������Ϥ��ʤ��褦�ˤ��뤿��Υե饰
        // ���ιԤ���ɼ�ֹ椬Ʊ��
        // ���ιԤ�������ե饰��Ʊ��
        // ���ιԤ������껦�ե饰��Ʊ��
        if (
            $value["slip_no"]     == $ary_data[$key - 1]["slip_no"]     &&
            $value["advance_flg"] == $ary_data[$key - 1]["advance_flg"] &&
            $value["offset_flg"]  == $ary_data[$key - 1]["offset_flg"]
        ){
            $top_print_flg  = false;
        }else{
            $top_print_flg  = true;
            $color_row     += 1;
        }

        // Ʊ����ɼ��ǤϺǸ�ιԤΤ�������Ĺ����Ϥ��뤿��Υե饰
        // ���ιԤ���ɼ�ֹ椬�Ѥ��
        // ���ιԤ�������ե饰���Ѥ��
        // ���ιԤ������껦�ե饰���Ѥ��
        if (
            $value["slip_no"]     != $ary_data[$key + 1]["slip_no"]     ||
            $value["advance_flg"] != $ary_data[$key + 1]["advance_flg"] ||
            $value["offset_flg"]  != $ary_data[$key + 1]["offset_flg"]
        ){
            $bottom_print_flg = true;
        }else{
            $bottom_print_flg = false;
        }

        // �������׻���
        // �����껦�۹�׻���
        // ������Ĺ��׻���
        if ($value["advance_amount"] != null){
            $sum_advance_amount += $value["advance_amount"];            // ��������
            $sum_balance_amount += $value["advance_amount"];            // ������Ĺ�
        }
        if ($value["advance_offset_amount"] != null){
            $sum_advance_offset += $value["advance_offset_amount"];     // �����껦�۹��
            $sum_balance_amount -= $value["advance_offset_amount"];     // ������Ĺ�
        }

        /****************************/
        // html���������ٹԡ�
        /****************************/
        $html_l .= "    <tr class=\"".((bcmod($color_row, 2) == 0) ? "Result1" : "Result2")."\">\n";
        $html_l .= "        <td align=\"right\">".($key + 2)."</td>\n";
        if ($top_print_flg == true){
        $html_l .= "        <td align=\"center\">".$value["trading_day"]."</td>\n";
        $html_l .= "        <td align=\"center\">".$value["slip_no"]."</td>\n";
        $html_l .= "        <td align=\"center\">".$value["trade_name"]."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\"></td>\n";
        $html_l .= "        <td align=\"center\"></td>\n";
        $html_l .= "        <td align=\"center\"></td>\n";
        }
        $html_l .= "        <td>".htmlspecialchars($value["formal_name"])."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($value["advance_amount"], null, true)."</td>\n";
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($value["advance_offset_amount"], null, true)."</td>\n";
        if ($bottom_print_flg == true){
        $html_l .= "        <td align=\"right\">".Numformat_Ortho($sum_balance_amount)."</td>\n";
        }else{
        $html_l .= "        <td align=\"center\"></td>\n";
        }
        $html_l .= "    </tr>\n";

    }
    }

    /****************************/
    // html�����ʹ�׹ԡ�
    /****************************/
    $html_g .= "    <tr class=\"Result3\">\n";
    $html_g .= "        <td><b>���</b></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td></td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_advance_amount)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_advance_offset)."</td>\n";
    $html_g .= "        <td align=\"right\">".Numformat_Ortho($sum_balance_amount)."</td>\n";
    $html_g .= "    </tr>\n";

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
    "total_count"   => "$total_count",
));

// html��assign
$smarty->assign("html", array(
    "html_page"     =>  $html_page,
    "html_page2"    =>  $html_page2,
    "html_l"        =>  $html_l,
    "html_g"        =>  $html_g,
));

// ���顼��assign
$errors = $form->_errors;
$smarty->assign("errors", $errors);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
