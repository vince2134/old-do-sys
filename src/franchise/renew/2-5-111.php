<?php
// �ڡ���̾
$page_title = "�Хå�ɽ";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");
$smarty->register_modifier("number_format","number_format");

// DB��³
$db_con = Db_Connect();


/****************************/
// �����ѿ�����
/****************************/
$shop_id        = $_SESSION["client_id"];
$group_kind     = $_SESSION["group_kind"];
$staff_id       = $_GET["staff_id"];

$end_y      = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null; 
$end_m      = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null; 
$end_d      = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null; 
$end_day    = ($end_y != null && $end_m != null && $end_d != null) ? $end_y."-".$end_m."-".$end_d : null;


/****************************/
// �ե�����ѡ������
/****************************/
/* �ᥤ��ե����� */
$form->addElement("button", "form_return_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");


/****************************/
// �ڡ����ɹ����ν���
/****************************/
// �������������å�ID�������ξ��
if ($staff_id != null){
    $sql  = "SELECT staff_id FROM t_ WHERE staff_id = $staff_id;";
//    $res  = Db_Query($db_con, $sql);
//    Get_Id_Check($res);
}


/****************************/
// �ؿ�
/****************************/
function Font_Color($num){
    return ($num < 0) ? "style=\"color: #ff0000;\"" : null; 
}


/****************************/
// �ե�����ѡ������
/****************************/
// ���Ϸ���
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "����", "1");
$radio[] =& $form->createElement("radio", null, null, "Ģɼ", "2");
$form->addGroup($radio, "form_output_radio", "");

// ���״���
$form_end_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\"
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form,'form_end_day[y]','form_end_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_end_day[y]','form_end_day[m]','form_end_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_end_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style \"
    onkeyup=\"changeText(this.form, 'form_end_day[m]','form_end_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_end_day[y]','form_end_day[m]','form_end_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_end_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\"
    style=\"$g_form_style \" 
    onFocus=\"onForm_today(this,this.form,'form_end_day[y]','form_end_day[m]','form_end_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup($form_end_day, "form_end_day", "", " - "); 

// ���ڥ졼��
$select_staff   = null; 
$select_staff   = Select_Get($db_con, "shop_staff");
$form->addElement("select", "form_staff_select", "", $select_staff, "$g_form_option_select");

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");


/****************************/
// ��������������
/****************************/
/* �ǽ����������������� */
$sql  = "SELECT MAX(close_day) ";
$sql .= "FROM   t_sys_renew ";
$sql .= "WHERE  renew_div = '1' ";
$sql .= "AND    shop_id = $shop_id ";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$daily_update_time = pg_fetch_result($res, 0);

// �������������
$sql  = "SELECT to_date(MAX(close_day), 'YYYY-MM-DD') ";
$sql .= "FROM   t_sys_renew ";
$sql .= "WHERE  renew_div = '2' ";
$sql .= "AND    shop_id = $shop_id ";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$monthly_update_time = pg_fetch_result($res, 0);


/****************************/
// ɽ���ܥ��󲡲�������
/****************************/
if (isset($_POST["form_show_button"])){

    // ���顼�ե饰��Ǽ������
    $ary_err_flg = array(null);

    // POST���줿���դ�����
    $end_y = ($_POST["form_end_day"]["y"] != null) ? str_pad($_POST["form_end_day"]["y"], 4, 0, STR_POS_LEFT) : null;
    $end_m = ($_POST["form_end_day"]["m"] != null) ? str_pad($_POST["form_end_day"]["m"], 2, 0, STR_POS_LEFT) : null;
    $end_d = ($_POST["form_end_day"]["d"] != null) ? str_pad($_POST["form_end_day"]["d"], 2, 0, STR_POS_LEFT) : null;

    /****************************/
    // ���顼�����å�
    /****************************/
    // �ɤ줫1�ĤǤ����Ϥ�������
    if ($end_y != null || $end_m != null || $end_d != null){

        // ���������������å�
        if (!checkdate((int)$end_m, (int)$end_d, (int)$end_y)){
            $form->setElementError("form_end_day", "���״��֤����դ������ǤϤ���ޤ���");
            $ary_err_flg[] = true;
        }

        // ����������������դ������å�
        if (mb_substr($daily_update_time, 0, 10) > $end_y."-".$end_m."-".$end_d){
            $form->setElementError("form_end_day", "���״��֤����դ������ǤϤ���ޤ���");
            $ary_err_flg[] = true;
        }

        // YYYY-MM-DD�η��ˤ��Ƥ���
        $end_day = $end_y."-".$end_m."-".$end_d;

    }

    /****************************/
    // �����å����
    /****************************/
    $qf_err_flg = ($form->validate() === false || in_array(true, $ary_err_flg)) ? true : false;

}


/****************************/
// ����ɽ���ѥǡ�������
/****************************/
/* �����ѥǡ������� */
if ($qf_err_flg != true){

    // ���򤵤줿�����å�ID����
    $staff_id = $_POST["form_staff_select"];


    /*-----------------------------------
        ���ǡ�������
    -----------------------------------*/
    // �롼��������������ʬ��
    $ary_sale_div   = array("01", "02", "03", "04", "05", "06", "07", "08");
    // �롼��������ʽ��ô���Լ��̡�
    $ary_main_sub   = array("main", "sub1", "sub2", "sub3");
    
    /*** ���ǡ������� ***/
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.genkin_".$value."_count, \n";
    $sql .= "   t_sale_data.genkin_".$value."_cost_amount, \n";
    $sql .= "   t_sale_data.genkin_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.genkin_tax_amount, \n";
    $sql .= "   t_sale_data.genkin_gai_count, \n";
    $sql .= "   t_sale_data.genkin_gai_cost_amount, \n";
    $sql .= "   t_sale_data.genkin_gai_sale_amount, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.kake_".$value."_count, \n";
    $sql .= "   t_sale_data.kake_".$value."_cost_amount, \n";
    $sql .= "   t_sale_data.kake_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.kake_tax_amount, \n";
    $sql .= "   t_sale_data.kake_gai_count, \n";
    $sql .= "   t_sale_data.kake_gai_cost_amount, \n";
    $sql .= "   t_sale_data.kake_gai_sale_amount \n";
    $sql .= "FROM \n";
    // ������åס�ô����
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "                           ( \n";
    $sql .= "                               SELECT \n";
    $sql .= "                                   shop_id, \n";
    $sql .= "                                   ".$value."_staff_id AS staff_id \n";
    $sql .= "                               FROM \n";
    $sql .= "                                   t_sale_h_amount \n";
    $sql .= "                           ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "                           UNION ALL \n";
        }       
    }
    $sql .= "                       ) \n";
    $sql .= "                       AS t_sale_union \n";
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       collect_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           INNER JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop_union.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop_union.staff_id = $staff_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // �����ǡ���(join ���ʥޥ���)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // ������� - ���ٷ��
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61, 63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_count, \n";
    }
    // ������� - ����
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_cost_amount, \n";
    }
    // ������� - ���
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_sale_amount, \n";
    }
    // ������� - ������������
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61, 63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_manage = '2' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_count, \n";
    // ������� - �������������
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_cost_amount, \n";
    // ������� - ������������
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_sale_amount, \n";
    // ����� - ���ٷ��
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 13, 14, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_count, \n";
    }
    // ����� - ����
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_cost_amount, \n";
    }
    // ����� - ���
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_sale_amount, \n";
    }
    // ����� - ������������
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 13, 14, 15) AND \n";
    $sql .= "                       t_sale_union.sale_manage = '2' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_sale_union.sale_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_count, \n";
    // ����� - �������������
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.cost_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_cost_amount, \n";
    // ����� - ������������
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_sale_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_d_amount.sale_d_id, \n";
    $sql .= "                       t_sale_d_amount.shop_id, \n";
    $sql .= "                       t_sale_d_amount.trade_id, \n";
    $sql .= "                       t_sale_d_amount.sale_div_cd, \n";
    $sql .= "                       t_goods.sale_manage, \n";
    $sql .= "                       t_sale_d_amount.renew_flg, \n";
    $sql .= "                       t_sale_d_amount.sale_day, \n";
    $sql .= "                       t_sale_d_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_d_amount.".$value."_cost_amount, 0) AS cost_amount, \n";
    $sql .= "                       COALESCE(t_sale_d_amount.".$value."_sale_amount, 0) AS sale_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_d_amount \n";
    $sql .= "                       LEFT JOIN t_goods ON t_sale_d_amount.goods_id = t_goods.goods_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           renew_flg = 'f' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_data.staff_id \n";
    // �����إå�(join �����ޥ���)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // ������� - ��ɼ�����ǳ�
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id = 61 AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (63, 64) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_tax_amount, \n";
    // ����� - ��ɼ�����ǳ�
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (11, 15) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (13, 14) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_tax_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_h_amount.shop_id, \n";
    $sql .= "                       t_sale_h_amount.trade_id, \n";
    $sql .= "                       t_sale_h_amount.renew_flg, \n";
    $sql .= "                       t_sale_h_amount.sale_day, \n";
    $sql .= "                       t_client.c_tax_div, \n";
    $sql .= "                       t_sale_h_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_h_amount.".$value."_tax_amount, 0) AS tax_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                       LEFT JOIN t_client ON t_sale_h_amount.client_id = t_client.client_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           renew_flg = 'f' \n";
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_tax \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_tax.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_tax.staff_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_sale_daily_data = Get_data($res, "", "ASSOC");
    }else{
        $ary_sale_daily_data = array(null);
    }
    
    /*** ����ǡ������� ***/
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.genkin_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.genkin_tax_amount, \n";
    $sql .= "   t_sale_data.genkin_gai_sale_amount, \n";
    foreach ($ary_sale_div as $key => $value){
    $sql .= "   t_sale_data.kake_".$value."_sale_amount, \n";
    }
    $sql .= "   t_sale_tax.kake_tax_amount, \n";
    $sql .= "   t_sale_data.kake_gai_sale_amount \n";
    $sql .= "FROM \n";
    // ������åס�ô����
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "                           ( \n";
    $sql .= "                               SELECT \n";
    $sql .= "                                   shop_id, \n";
    $sql .= "                                   ".$value."_staff_id AS staff_id \n";
    $sql .= "                               FROM \n";
    $sql .= "                                   t_sale_h_amount \n";
    $sql .= "                           ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "                           UNION ALL \n";
        }       
    }
    $sql .= "                       ) \n";
    $sql .= "                       AS t_sale_union \n";
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       collect_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           INNER JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop_union.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop_union.staff_id = $staff_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // �����ǡ���(join ���ʥޥ���)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   (\n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // ������� - ���
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_".$value."_sale_amount, \n";
    }
    // ������� - ������������
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (61) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (63, 64) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_gai_sale_amount, \n";
    // ����� - ���
    foreach ($ary_sale_div as $key => $value){
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                       t_sale_union.sale_div_cd = '$value' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_".$value."_sale_amount, \n";
    }
    // ����� - ������������
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (11, 15) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           t_sale_union.trade_id IN (13, 14) AND \n";
    $sql .= "                           t_sale_union.sale_manage = '2' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_sale_union.sale_amount) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_gai_sale_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_d_amount.sale_d_id, \n";
    $sql .= "                       t_sale_d_amount.shop_id, \n";
    $sql .= "                       t_sale_d_amount.trade_id, \n";
    $sql .= "                       t_sale_d_amount.sale_div_cd, \n";
    $sql .= "                       t_goods.sale_manage, \n";
    $sql .= "                       t_sale_d_amount.sale_day, \n";
    $sql .= "                       t_sale_d_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_d_amount.".$value."_sale_amount, 0) AS sale_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_d_amount \n";
    $sql .= "                       LEFT JOIN t_goods ON t_sale_d_amount.goods_id = t_goods.goods_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           sale_d_id IS NOT NULL \n";    // WHERE���б������ɤ������Τ�
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    if ($monthly_update_time != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day > $monthly_update_time \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_data.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_data.staff_id \n";
    // �����إå�(join �����ޥ���)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id, \n";
    // ������� - ��ɼ�����ǳ�
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id = 61 AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (63, 64) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS genkin_tax_amount, \n";
    // ����� - ��ɼ�����ǳ�
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (11, 15) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * 1 \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       ( \n";
    $sql .= "                           trade_id IN (13, 14) AND \n";
    $sql .= "                           c_tax_div = '1' \n";
    $sql .= "                       ) \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(tax_amount, 0) * -1 \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS kake_tax_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    foreach ($ary_main_sub as $key => $value){
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       t_sale_h_amount.sale_id, \n";
    $sql .= "                       t_sale_h_amount.shop_id, \n";
    $sql .= "                       t_sale_h_amount.trade_id, \n";
    $sql .= "                       t_sale_h_amount.sale_day, \n";
    $sql .= "                       t_client.c_tax_div, \n";
    $sql .= "                       t_sale_h_amount.".$value."_staff_id AS staff_id, \n";
    $sql .= "                       COALESCE(t_sale_h_amount.".$value."_tax_amount, 0) AS tax_amount \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_sale_h_amount \n";
    $sql .= "                       LEFT JOIN t_client ON t_sale_h_amount.client_id = t_client.client_id \n";
    $sql .= "               ) \n";
        if ($key+1 < count($ary_main_sub)){
    $sql .= "               UNION ALL \n";
        }
    }
    $sql .= "           ) \n";
    $sql .= "           AS t_sale_union \n";
    $sql .= "       WHERE \n";
    $sql .= "           sale_id IS NOT NULL \n";   // WHERE���б������ɤ������Τ�
    if ($end_day != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day <= '$end_day' \n";
    }
    if ($monthly_update_time != null){
    $sql .= "       AND \n";
    $sql .= "           sale_day > $monthly_update_time \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           shop_id, \n";
    $sql .= "           staff_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_sale_tax \n";
    $sql .= "   ON t_attach_staff.shop_id = t_sale_tax.shop_id \n";
    $sql .= "   AND t_attach_staff.staff_id = t_sale_tax.staff_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_sale_monthly_data = Get_Data($res, "", "ASSOC");
    }else{
        $ary_sale_monthly_data = array(null);
    }
print_array($ary_sale_monthly_data);

    /* ���줾��ι�פ򻻽� */
    $i = 0;
    foreach ($ary_sale_daily_data as $key => $value){

        // ������� - ���
        $ary_sale_total_data[$value["staff_id"]]["genkin_count"]        = $ary_sale_daily_data[$i]["genkin_01_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_02_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_03_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_04_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_05_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_06_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_07_count"]
                                                                        + $ary_sale_daily_data[$i]["genkin_08_count"]
                                                                        ;
        // ������� - ����
        $ary_sale_total_data[$value["staff_id"]]["genkin_cost_amount"]  = $ary_sale_daily_data[$i]["genkin_01_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_02_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_03_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_04_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_05_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_06_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_07_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_08_cost_amount"]
                                                                        ;
        // ������� - ���
        $ary_sale_total_data[$value["staff_id"]]["genkin_sale_amount"]  = $ary_sale_daily_data[$i]["genkin_01_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_02_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_03_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_04_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_05_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_06_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_07_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_08_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["genkin_tax_amount"]
                                                                        ;
        // ������� - ��߷�
        $ary_sale_total_data[$value["staff_id"]]["genkin_monthly_amount"] = $ary_sale_monthly_data[$i]["genkin_01_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_02_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_03_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_04_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_05_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_06_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_07_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_08_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["genkin_tax_amount"]
                                                                        ;
        // ����� - ���
        $ary_sale_total_data[$value["staff_id"]]["kake_count"]          = $ary_sale_daily_data[$i]["kake_01_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_02_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_03_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_04_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_05_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_06_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_07_count"]
                                                                        + $ary_sale_daily_data[$i]["kake_08_count"]
                                                                        ;
        // ����� - ����
        $ary_sale_total_data[$value["staff_id"]]["kake_cost_amount"]    = $ary_sale_daily_data[$i]["kake_01_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_02_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_03_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_04_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_05_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_06_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_07_cost_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_08_cost_amount"]
                                                                        ;
        // ����� - ���
        $ary_sale_total_data[$value["staff_id"]]["kake_sale_amount"]    = $ary_sale_daily_data[$i]["kake_01_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_02_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_03_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_04_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_05_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_06_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_07_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_08_sale_amount"]
                                                                        + $ary_sale_daily_data[$i]["kake_tax_amount"]
                                                                        ;
        // ����� - ��߷�
        $ary_sale_total_data[$value["staff_id"]]["kake_monthly_amount"] = $ary_sale_monthly_data[$i]["kake_01_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_02_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_03_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_04_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_05_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_06_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_07_sale_amount"]
                                                                        + $ary_sale_monthly_data[$i]["kake_08_sale_amount"]
                                                                        ;    

        $i++;

    }
print_array($ary_sale_total_data);

}

/*----------------------------------
    ����ǡ�������
-----------------------------------*/
/* ��Ԥ���Ϥ�������ʬ������ */
$payin_bank_trade_list = array("32", "33", "35");

//$staff_id = 45;

/* �����ʬ��ζ�԰��������ʷ�������ζ�԰���������� */
foreach ($payin_bank_trade_list as $key_trade => $value_trade){
    $sql  = "SELECT \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, \n";
    $sql .= "   t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, \n";
    $sql .= "   t_payin_d.b_bank_name, \n";
    $sql .= "   t_payin_d.account_no \n";
    $sql .= "FROM \n";
    // ������åס�ô����
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       ( \n";
    foreach ($ary_main_sub as $key_staff => $value_staff){
    $sql .= "                           ( \n";
    $sql .= "                               SELECT \n";
    $sql .= "                                   shop_id, \n";
    $sql .= "                                   ".$value_staff."_staff_id AS staff_id \n";
    $sql .= "                               FROM \n";
    $sql .= "                                   t_sale_h_amount \n";
    $sql .= "                           ) \n";
        if ($key_staff+1 < count($ary_main_sub)){
    $sql .= "                           UNION ALL \n";
        }       
    }
    $sql .= "                       ) \n";
    $sql .= "                       AS t_sale_union \n";
    $sql .= "               ) \n";
    $sql .= "               UNION ALL \n";
    $sql .= "               ( \n";
    $sql .= "                   SELECT \n";
    $sql .= "                       shop_id, \n";
    $sql .= "                       collect_staff_id AS staff_id \n";
    $sql .= "                   FROM \n";
    $sql .= "                       t_payin_h \n";
    $sql .= "               ) \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop_union \n";
    $sql .= "           INNER JOIN t_staff ON t_shop_union.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop_union.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop_union.staff_id = $staff_id \n";
    }
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop_union.shop_id, \n";
    $sql .= "           t_shop_union.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ����إå� - �����������
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.pay_id, \n";
    if ($staff_id != null){
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           t_payin_h.collect_staff_id AS staff_id \n";
    }else{
    $sql .= "           t_payin_h.shop_id \n";
    }
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= ($monthly_update_time != null) ? " WHERE pay_day > $monthly_update_time \n" : null;
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_monthly \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_monthly.shop_id \n";
    if ($staff_id != null){
    $sql .= "   AND t_attach_staff.staff_id = t_payin_monthly.staff_id \n";
    }
    // ����ǡ���
    $sql .= "   INNER JOIN t_payin_d \n";
    $sql .= "   ON t_payin_monthly.pay_id = t_payin_d.pay_id \n";
    $sql .= "   AND trade_id = ".$value_trade." \n";
    // ���
    $sql .= "GROUP BY \n";
    $sql .= "   t_attach_staff.staff_id, \n";
    $sql .= "   t_attach_staff.staff_name, \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, t_payin_d.b_bank_name, \n";
    $sql .= "   account_no \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_attach_staff.charge_cd, \n";
    $sql .= "   t_payin_d.trade_id, \n";
    $sql .= "   t_payin_d.bank_cd, t_payin_d.bank_name, \n";
    $sql .= "   t_payin_d.b_bank_cd, t_payin_d.b_bank_name, \n";
    $sql .= "   account_no \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    if ($num > 0){
        $ary_payin_data_list = Get_Data($res, "", "ASSOC");

        $i = 0;
        foreach ($ary_payin_data_list as $key_data => $value_data){
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["bank_cd"]    = $value_data["bank_cd"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["bank_name"]  = $value_data["bank_name"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["b_bank_cd"]  = $value_data["b_bank_cd"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["b_bank_cd"]  = $value_data["b_bank_cd"];
            $ary_payin_trade_bank_list[$value_data["staff_id"]][$value_trade][$i]["account_no"] = $value_data["account_no"];
            $i++;
        }

    }else{

        $ary_payin_trade_bank_list = array(null);

    }

}
print_array($ary_payin_trade_bank_list);

/* ����������԰����򸵤ˤ��ζ�Ԥ����٤���� */
foreach ($ary_payin_trade_bank_list as $key_staff1 => $value_staff2){

    


    // ���������ʬ�˶�ԥǡ�����������
    if ($value != null){
        for ($j=0; $j<count($value); $j++){
            $sql  = "SELECT \n";
            $sql .= "   t_payin_data.bank_cd, \n";
            $sql .= "   t_payin_data.bank_name, \n";
            $sql .= "   t_payin_data.b_bank_cd, \n";
            $sql .= "   t_payin_data.b_bank_name, \n";
            $sql .= "   t_payin_data.account_no, \n";
            $sql .= "   COALESCE(t_payin_data.daily_pay_count, 0) AS daily_pay_count, \n";
            $sql .= "   COALESCE(t_payin_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
            $sql .= "   COALESCE(t_payin_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
            $sql .= "FROM \n";
            // ������åס�ô����
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            $sql .= "           t_shop.shop_id, \n";
            if ($staff_id != null){
            $sql .= "           t_shop.staff_id, \n";
            $sql .= "           t_staff.charge_cd, \n";
            $sql .= "           t_staff.staff_name \n";
            }else{
            $sql .= "           NULL, \n";
            $sql .= "           NULL, \n";
            $sql .= "           NULL \n";
            }
            $sql .= "       FROM \n";
            $sql .= "           ( \n";
            $sql .= "               SELECT \n";
            $sql .= "                   shop_id, \n";
            $sql .= "                   collect_staff_id AS staff_id \n";
            $sql .= "               FROM \n";
            $sql .= "                   t_payin_h \n";
            $sql .= "           ) \n";
            $sql .= "           AS t_shop \n";
            $sql .= "           INNER JOIN t_staff ON t_shop.staff_id = t_staff.staff_id \n";
            $sql .= "       WHERE \n";
            $sql .= "           t_shop.shop_id = $shop_id \n";
            if ($staff_id != null){
            $sql .= "       AND \n";
            $sql .= "           t_shop.staff_id = $staff_id \n";
            $sql .= "       GROUP BY \n";
            $sql .= "           t_shop.shop_id, \n";
            $sql .= "           t_shop.staff_id, \n";
            $sql .= "           t_staff.charge_cd, \n";
            $sql .= "           t_staff.staff_name \n";
            $sql .= "       ORDER BY \n";
            $sql .= "           t_staff.charge_cd \n";
            }else{
            $sql .= "       GROUP BY \n";
            $sql .= "           t_shop.shop_id \n";
            }
            $sql .= "   ) \n";
            $sql .= "   AS t_attach_staff \n";
            // ������إå���JOIN ����ǡ�����
            $sql .= "   LEFT JOIN \n";
            $sql .= "   ( \n";
            $sql .= "       SELECT \n";
            if ($staff_id != null){
            $sql .= "           t_payin_h.collect_staff_id AS staff_id, \n";
            }
            $sql .= "           t_payin_h.shop_id, \n";
            $sql .= "           t_payin_d.bank_cd, \n";
            $sql .= "           t_payin_d.bank_name, \n";
            $sql .= "           t_payin_d.b_bank_cd, \n";
            $sql .= "           t_payin_d.b_bank_name, \n";
            $sql .= "           t_payin_d.account_no, \n";
            $sql .= "           COUNT( \n";
            $sql .= "               CASE \n";
            $sql .= "                   WHEN \n";
            $sql .= "                       t_payin_h.renew_flg = 'f' \n";
            $sql .= "                   THEN \n";
            $sql .= "                       t_payin_d.pay_d_id \n";
            $sql .= "               END \n";
            $sql .= "           ) AS daily_pay_count, \n";
            $sql .= "           SUM( \n";
            $sql .= "               CASE \n";
            $sql .= "                   WHEN \n";
            $sql .= "                       t_payin_h.renew_flg = 'f' \n";
            $sql .= "                   THEN \n";
            $sql .= "                       COALESCE(t_payin_d.amount, 0) \n";
            $sql .= "                   ELSE 0 \n";
            $sql .= "               END \n";
            $sql .= "           ) AS daily_pay_amount, \n";
            $sql .= "           SUM(COALESCE(t_payin_d.amount, 0)) AS monthly_pay_amount \n";
            $sql .= "       FROM \n";
            $sql .= "           t_payin_h \n";
            $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
            $sql .= "       WHERE \n";
            $sql .= "           t_payin_h.sale_id IS NULL \n";
            if ($end_date != null){
            $sql .= "       AND \n";
            $sql .= "           t_payin_h.pay_day <= '$end_date' \n";
            }
            $sql .= "       AND \n";
            $sql .= "           trade_id = ".$value[$j][0]." \n";               // �����ʬ
            $sql .= "       AND \n";
            $sql .= "           bank_cd = '".$value[$j][1]."' \n";              // ��ԥ�����
            $sql .= "       AND \n";
            $sql .= "           bank_name = '".$value[$j][2]."' \n";            // ���̾
            $sql .= "       AND \n";
            $sql .= "           b_bank_cd = '".$value[$j][3]."' \n";            // ��Ź������
            $sql .= "       AND \n";
            $sql .= "           b_bank_name = '".$value[$j][4]."' \n";          // ��Ź̾
            $sql .= "       AND \n";
            $sql .= "           account_no = '".$value[$j][5]."' \n";           // �����ֹ�
            $sql .= "       GROUP BY \n";
            if ($staff_id != null){
            $sql .= "           t_payin_h.collect_staff_id, \n";
            }
            $sql .= "           t_payin_h.shop_id, \n";
            $sql .= "           t_payin_d.bank_cd, \n";
            $sql .= "           t_payin_d.bank_name, \n";
            $sql .= "           t_payin_d.b_bank_cd, \n";
            $sql .= "           t_payin_d.b_bank_name, \n";
            $sql .= "           t_payin_d.account_no \n";
            $sql .= "   ) \n";
            $sql .= "   AS t_payin_data \n";
            $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
            if ($staff_id != null){
            $sql .= "   AND t_attach_staff.staff_id = t_payin_data.staff_id \n";
            }
            $sql .= "   ORDER BY \n";
            $sql .= "       t_payin_data.bank_cd, \n";
            $sql .= "       t_payin_data.b_bank_cd, \n";
            $sql .= "       t_payin_data.account_no \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $ary_payin_bank_data[$key][$j] = pg_fetch_array($res, 0, PGSQL_ASSOC);
            // �ǡ�����������
            if ($ary_payin_bank_data[$key][$j][0] != null){
                while (list($key2, $value2) = each($ary_payin_bank_data[$key][$j])){
                    $ary_payin_bank_data[$key][$j][$key2] = $value2;
                }
            }
        }
    // ���������ʬ�˶�ԥǡ�����̵�����
    }else{
        $ary_payin_bank_data[$key] = null;
    }
}

/*  ��Խ��Ϥ������٤Ρ�����ɽ���Ѱ���������� */
// �����ʬ��롼��
foreach ($payin_bank_trade_list as $key => $value){

    // ����������μ����ǡ�����̵�����
    if ($value != null){

        // ��������ǡ����ζ�Ի�Ź��롼��
        for ($j=0; $j<count($ary_payin_bank_data[$value]); $j++){

            // �����������ǡ�������������ǡ��������������
            // ��ԥ�����-��Ź�����ɡʷ�߷ץǡ������������
            $ary_payin_bank_data[$value][$j]["bank_b_bank_cd"]      = $ary_payin_bank_data[$value][$j]["bank_cd"]."-".
                                                                      $ary_payin_bank_data[$value][$j]["b_bank_cd"];
            // ���̾����Ź̾<br>�����ֹ�ʷ�߷ץǡ������������
            $ary_payin_bank_data[$value][$j]["bank_b_bank_name"]    = $ary_payin_bank_data[$value][$j]["bank_name"]."��".
                                                                      $ary_payin_bank_data[$value][$j]["b_bank_name"]."<br>".
                                                                      $ary_payin_bank_data[$value][$j]["account_no"];
            // ����������ǡ�����
            $ary_payin_bank_data[$value][$j]["daily_pay_count"]     = ($ary_payin_bank_data[$value][$j] == null) ? "0"
                                                                    : $ary_payin_bank_data[$value][$j]["daily_pay_count"];
            // ��ۡ������ǡ�����
            $ary_payin_bank_data[$value][$j]["daily_pay_amount"]    = ($ary_payin_bank_data[$value][$j] == null) ? "0"
                                                                    : $ary_payin_bank_data[$value][$j]["daily_pay_amount"];
            // ��ۡʷ�߷ץǡ�����
            $ary_payin_bank_data[$value][$j]["monthly_pay_amount"]  = $ary_payin_bank_data[$value][$j]["monthly_pay_amount"];

            // ��׻��ФΤ��ᡢ�û����Ƥ���
            $payin_total[$value]["daily_pay_count"]     += $ary_payin_bank_data[$value][$j]["daily_pay_count"];
            $payin_total[$value]["daily_pay_amount"]    += $ary_payin_bank_data[$value][$j]["daily_pay_amount"];
            $payin_total[$value]["monthly_pay_amount"]  += $ary_payin_bank_data[$value][$j]["monthly_pay_amount"];

        }

    }

}

/*** �������Ϥ��ʤ������ʬ�����٥ǡ������� ***/

/* ��Ԥ���Ϥ��ʤ������ʬ������ */
$payin_nonbank_trade_list = array("31", "34", "36", "37", "38");

/* �����������ǡ������� */
foreach ($payin_nonbank_trade_list as $key => $value){
    $sql  = "SELECT \n";
    $sql .= "   t_payin_data.daily_pay_count, \n";
    $sql .= "   COALESCE(t_payin_data.daily_pay_amount, 0) AS daily_pay_amount, \n";
    $sql .= "   COALESCE(t_payin_data.monthly_pay_amount, 0) AS monthly_pay_amount \n";
    $sql .= "FROM \n";
    // ������åס�ô����
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_shop.shop_id, \n";
    if ($staff_id != null){
    $sql .= "           t_shop.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    }else{
    $sql .= "           NULL, \n";
    $sql .= "           NULL, \n";
    $sql .= "           NULL \n";
    }
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   shop_id, \n";
    $sql .= "                   collect_staff_id AS staff_id \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_payin_h \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_shop \n";
    $sql .= "           INNER JOIN t_staff ON t_shop.staff_id = t_staff.staff_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_shop.shop_id = $shop_id \n";
    if ($staff_id != null){
    $sql .= "       AND \n";
    $sql .= "           t_shop.staff_id = $staff_id \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop.shop_id, \n";
    $sql .= "           t_shop.staff_id, \n";
    $sql .= "           t_staff.charge_cd, \n";
    $sql .= "           t_staff.staff_name \n";
    $sql .= "       ORDER BY \n";
    $sql .= "           t_staff.charge_cd \n";
    }else{
    $sql .= "       GROUP BY \n";
    $sql .= "           t_shop.shop_id \n";
    }
    $sql .= "   ) \n";
    $sql .= "   AS t_attach_staff \n";
    // ������إå�(join ����ǡ���)
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_payin_h.shop_id, \n";
    if ($staff_id != null){
    $sql .= "           t_payin_h.collect_staff_id AS staff_id, \n";
    }
    $sql .= "           COUNT( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_h.renew_flg = 'f' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       t_payin_d.pay_d_id \n";
    $sql .= "               END \n";
    $sql .= "           ) AS daily_pay_count, \n";
    $sql .= "           SUM( \n";
    $sql .= "               CASE \n";
    $sql .= "                   WHEN \n";
    $sql .= "                       t_payin_h.renew_flg = 'f' \n";
    $sql .= "                   THEN \n";
    $sql .= "                       COALESCE(t_payin_d.amount, 0) \n";
    $sql .= "                   ELSE 0 \n";
    $sql .= "               END \n";
    $sql .= "           ) AS daily_pay_amount, \n";
    $sql .= "           SUM(COALESCE(t_payin_d.amount, 0)) AS monthly_pay_amount \n";
    $sql .= "       FROM \n";
    $sql .= "           t_payin_h \n";
    $sql .= "           INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_payin_h.sale_id IS NULL \n";
    $sql .= "       AND \n";
    $sql .= "           trade_id = $value \n";
    if ($monthly_update_date != null){
    $sql .= "       AND \n";
    $sql .= "           t_payin_h.pay_day > '$monthly_update_date' \n";
    }
    $sql .= "       GROUP BY \n";
    if ($staff_id != null){
    $sql .= "           t_payin_h.shop_id, \n";
    $sql .= "           t_payin_h.collect_staff_id \n";
    }else{
    $sql .= "           t_payin_h.shop_id \n";
    }
    $sql .= "   ) \n";
    $sql .= "   AS t_payin_data \n";
    $sql .= "   ON t_attach_staff.shop_id = t_payin_data.shop_id \n";
    if ($staff_id != null){
    $sql .= "   AND t_attach_staff.staff_id = t_payin_data.staff_id \n";
    }
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $payin_total[$value] = pg_fetch_array($res, 0 ,PGSQL_ASSOC);
    }else{
        $payin_total[$value] = null;
    }

}


/****************************/
// HTML����
/****************************/
$html  = null; 

/*** ��� ***/
$row   = 0;
$ary_genkin_kake    = array("genkin" => "����", "kake" => "��");
$ary_sale_div       = array(
    "01" => "��ԡ���",
    "02" => "����",
    "03" => "��󥿥�",
    "04" => "�꡼��",
    "05" => "����",
    "06" => "����¾",
    "07" => "�ݸ�",
    "08" => "���",
);

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">��������١�</td> \n";
$html .= "</tr>\n";
foreach ($ary_genkin_kake as $key_g_k => $value_g_k){
    foreach ($ary_sale_div as $key_s_d => $value_s_d){
// �����ʬ��
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>��".$value_g_k."����</td>\n";
$html .= "  <td>��".$value_s_d."��</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_".$key_s_d."_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_".$key_s_d."_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_".$key_s_d."_cost_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_".$key_s_d."_cost_amount"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_".$key_s_d."_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_".$key_s_d."_sale_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data[$key_g_k."_".$key_s_d."_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data[$key_g_k."_".$key_s_d."_sale_amount"])."</td>\n";
$html .= "</tr>\n";
    }
// ��ɼ������
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>��".$value_g_k."����</td>\n";
$html .= "  <td>����ɼ�����ǡ�</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_tax_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_tax_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data[$key_g_k."_tax_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data[$key_g_k."_tax_amount"])."</td>\n";
$html .= "</tr>\n";
// ���������
$html .= "<tr class=\"Result5\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td>��������������ʡ�</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_gai_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_gai_count"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_gai_cost_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_gai_cost_amount"])."</td>\n";
$color = Font_Color($ary_sale_daily_data[$key_g_k."_gai_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_daily_data[$key_g_k."_gai_sale_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_monthly_data[$key_g_k."_gai_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_monthly_data[$key_g_k."_gai_sale_amount"])."</td>\n";
$html .= "</tr>\n";
// ��ɼ������
$html .= "<tr class=\"Result2\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td><b>�ڹ�ס�</b></td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_count_amount"])."</td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_cost_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_cost_amount"])."</td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_sale_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_sale_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($ary_sale_total_data[$key_g_k."_monthly_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($ary_sale_total_data[$key_g_k."_monthly_amount"])."</td>\n";
$html .= "</tr>\n";
    if ($key_g_k == "genkin"){
$html .= "<tr class=\"Result1\">\n";
$html .= "<td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "</tr>\n";
    }
}

/*** ���� ***/
$row = 0;
if ($staff_id != null){
    // �����åդ����򤵤줿���ϸ�������Τ�
    $ary_payin_trade = array("31" => array(false, "��������"));
}else{
    $ary_payin_trade = array(
        // "�����ʬ������" => array(��Խ���̵ͭ�ե饰, "�����ʬ̾")
        "31" => array(false, "��������"),
        "32" => array(true,  "��������"),
        "33" => array(true,  "�������"),
        "34" => array(false, "�껦"),
        "35" => array(true,  "�����"),
        "36" => array(false, "����¾����"),
        "37" => array(false, "�����å��껦"),
        "38" => array(false, "����Ĵ��"),
    );
}

$html .= "<tr class=\"Result3\" style=\"font-weight: bold;\">\n";
$html .= "  <td colspan=\"8\">���������١�</td>\n";
$html .= "</tr>\n";
foreach ($ary_payin_trade as $key_trade1 => $value_trade1){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>��".$value_trade1[1]."��</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "  <td></td>\n";
$html .= "</tr>\n";
    if ($value_trade1[0] == true){
        foreach ($ary_payin_bank_data as $key_trade2 => $value_trade2){
            if ($key_trade1 == $key_trade2 && $value_trade2 != null){
                foreach ($value_trade2 as $key_bank => $value_bank){
$html .= "<tr class=\"Result1\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td>".$value_bank["bank_b_bank_cd"]."</td>\n";
$html .= "  <td>".$value_bank["bank_b_bank_name"]."</td>\n";
$color = Font_Color($value_bank["daily_pay_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($value_bank["daily_pay_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($value_bank["daily_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($value_bank["daily_pay_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($value_bank["monthly_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($value_bank["monthly_pay_amount"])."</td>\n";
$html .= "</tr>\n";
                }
            }
        }
    }
$html .= "<tr class=\"Result2\">\n";
$html .= "  <td align=\"right\">".++$row."</td>\n";
$html .= "  <td></td>\n";
$html .= "  <td><b>�ڹ�ס�</b></td>\n";
$color = Font_Color($payin_total[$key_trade1]["daily_pay_count"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payin_total[$key_trade1]["daily_pay_count"])."</td>\n";
$html .= "  <td align=\"center\">-</td>\n";
$color = Font_Color($payin_total[$key_trade1]["daily_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payin_total[$key_trade1]["daily_pay_amount"])."</td>\n";
$html .= "  <td></td>\n";
$color = Font_Color($payin_total[$key_trade1]["monthly_pay_amount"]);
$html .= "  <td align=\"right\"".$color.">".number_format($payin_total[$key_trade1]["monthly_pay_amount"])."</td>\n";
$html .= "</tr>\n";
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
// ��˥塼����
/****************************/
$page_menu = Create_Menu_h('renew','1');

/****************************/
// ���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
// �ڡ�������
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"       => "$html_header",
    "page_menu"         => "$page_menu",
    "page_header"       => "$page_header",
    "html_footer"       => "$html_footer",
    "html_page"         => "$html_page",
    "html_page2"        => "$html_page2",
    "daily_update_time" => "$daily_update_time",
    "now"               => date("Y-m-d"),
    "end_day"           => "$end_day",
    "numrows"           => "$numrows",
    "html"              => $html,
));

$smarty->assign("disp_staff_data", $disp_staff_data);

$smarty->assign("sale_daily_data",              $disp_sale_daily_data);
$smarty->assign("sale_monthly_data",            $disp_sale_monthly_data);
$smarty->assign("sale_genkin_total_data",       $disp_sale_genkin_total_data);
$smarty->assign("sale_kake_total_data",         $disp_sale_kake_total_data);

$smarty->assign("disp_payin_bank_data",         $disp_payin_bank_data);
$smarty->assign("disp_payin_bank_total",        $disp_payin_bank_total);
$smarty->assign("disp_payin_nonbank_total",     $disp_payin_nonbank_total);
$smarty->assign("row_count_payin",              $row_count_payin);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
