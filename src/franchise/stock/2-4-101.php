<?php
/********************
 * �߸˾Ȳ�
 *
 *
 * �ѹ�����
 *    2006/09/19 (kaji)
 *      ���Ȳ����򥯥�å���������������դ�����
 *
 ********************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/18��06-016��������watanabe-k���߸˾Ȳ�ȯ�����Ϥز������ܤ��ƾ��ν��ɽ�������򤷤Ƥ������ʤ�ɽ������Ƥ��ʤ��Х��ν�����
 * ��2006/12/05  ��������������watanabe-k���߸˿����SQL�ѹ�
 * ��2006/12/06  ban_0020������suzuki���������դΥ��顼��å������ѹ�
 * ��2006/12/06  ban_0022������suzuki���������դ˥�������ɲ�
 * ��2007/02/16          ������watanabe-k�����Ƚ�Ǥθ�������
 * ��2007/02/22          ������watanabe-k�����׵�ǽ����
 *  2007-03-30                  fukuda      ����������������ɲ�
 *  2007-04-17   B0702-039     kajioka-h   ������ɥ������ȥ�˲������إܥ����HTML�����Ϥ���Ƥ����Τ���
 *  2007-06-05                 watanabe-k  ���ʥ����ɤ�Ⱦ�����ϤˤʤäƤ��ʤ��Х��ν���
 *  2009/10/12                 hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *   
 */

$page_title = "�߸˾Ȳ�";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

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
    "form_inquiry_day"  => "",
    "form_target_goods" => "3",
    "form_g_goods"      => "",
    "form_product"      => "",
    "form_g_product"    => "",
    "form_goods_cd"     => "",
    "form_goods_name"   => "",
    "form_goods_cname"  => "",
    "form_attri_div"    => "",
    "form_ware"         => "",
    "form_stock_div"    => "",
    "form_staff_ware"   => "",
);

// �����ܻ����������������ե���������
$ary_pass_list = array(
    "order_button_flg"  => "",
);

// �����������
Restore_Filter2($form, array("stock", "ord"), "form_show_button", $ary_form_list, $ary_pass_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];   //����å׼���ID
$shop_div   = $_SESSION["shop_div"];    //�ܼҡ��ټҶ�ʬ
$group_kind = $_SESSION["group_kind"];  //����å׼���


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// �ե�����ѡ������
/****************************/
// �Ȳ���
Addelement_Date($form, "form_inquiry_day", "�Ȳ���", "-");

// �оݾ���
$text = null;
$text[] =& $form->createElement("radio", null, null, "��������",    "1"); 
$text[] =& $form->createElement("radio", null, null, "����¾����",  "2"); 
$text[] =& $form->createElement("radio", null, null, "����",        "3"); 
$form->addGroup($text, "form_target_goods", ""); 

// �Ͷ�ʬ
$select_value = Select_Get($db_con,"g_goods");
$form->addElement("select", "form_g_goods", "", $select_value, $g_form_option_select);

// ������ʬ
$select_value = Select_Get($db_con, "product");
$form->addElement("select", "form_product", "", $select_value, $g_form_option_select);

// ����ʬ��
$select_value = Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "", $select_value, $g_form_option_select);

// ���ʥ�����
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxLength=\"8\" $g_form_option style=\"$g_form_style\"");

// ����̾
$form->addElement("text", "form_goods_name", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// ����̾ά��
$form->addElement("text", "form_goods_cname", "", "size=\"34\" maxLength=\"30\" $g_form_option");

// °����ʬ
$attri_value = array(null => null, 1 => "����", 2 => "����", 3 => "����", 4 => "ƻ��¾", 5 => "�ݸ�");
$form->addElement("select", "form_attri_div", "", $attri_value, $g_form_option_select);

// �Ҹ�
$select_value = Select_Get($db_con, "ware", "WHERE shop_id = $_SESSION[client_id] AND staff_ware_flg = 'f' AND nondisp_flg = 'f' ");
$form->addElement("select", "form_ware",  "", $select_value, $g_form_option_select);

$sql  = "WHERE";
$sql .= "   shop_id = $_SESSION[client_id] ";
$sql .= "   AND ";
$sql .= "   ware_cd IN (SELECT ";
$sql .= "                   lpad(charge_cd, 4,0) ";
$sql .= "               FROM ";
$sql .= "                   t_staff ";
$sql .= "                       INNER JOIN ";
$sql .= "                   t_attach ";
$sql .= "                   ON t_staff.staff_id = t_attach.staff_id ";
$sql .= "               WHERE ";
$sql .= "                   state = '�߿���'";
$sql .= "                   AND ";
$sql .= "                   round_staff_flg = 't' ";
$sql .= "                   AND ";
$sql .= "                   shop_id = $_SESSION[client_id] ";
$sql .= "               ) ";

$select_value = Select_Get($db_con, "ware", $sql);
$form->addElement("select", "form_staff_ware",  "", $select_value, $g_form_option_select);


// �߸˶�ʬ
$stock_value = array(null => "", "�߸�ͭ��", "�߸ˣ�", "�ޥ��ʥ��߸�");
$form->addElement("select", "form_stock_div", "", $stock_value, $g_form_option_select);

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����", "");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// ȯ�����Ϥإܥ���
$form->addElement("button", "form_order_button", "ȯ�����Ϥ�",
    "onClick=\"javascript:Button_Submit('order_button_flg', '".$_SERVER["PHP_SELF"]."', 'true'); \" $disabled"
);

// �߸˾Ȳ��󥯥ܥ���
$form->addElement("button", "4_101_button", "�߸˾Ȳ�", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// �߸˼�ʧ��󥯥ܥ���
$form->addElement("button", "4_105_button", "�߸˼�ʧ", "onClick=\"location.href('./2-4-105.php');\"");

// ��α�߸˰�����󥯥ܥ���
$form->addElement("button", "4_109_button", "��α�߸˰���", "onClick=\"javascript:location.href('./2-4-109.php')\"");

// �����ե饰
$form->addElement("hidden", "order_button_flg");

// ���顼���å���
$form->addElement("text", "order_err1");
$form->addElement("text", "order_err2");


/*****************************/
// ɽ���ܥ��󲡲�����
/*****************************/
if ($_POST["form_show_button"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_inquiry_day"] = Str_Pad_Date($_POST["form_inquiry_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ���Ȳ���
    // ���顼��å�����
    $err_msg = "�Ȳ��� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_inquiry_day", $err_msg);

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();
    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. �ڡ����ڤ��ؤ���
/****************************/
if (($_POST["form_show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_button"] == null)){

    // ����POST�ǡ�����0���
    $_POST["form_inquiry_day"] = Str_Pad_Date($_POST["form_inquiry_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $inquiry_day_y  = $_POST["form_inquiry_day"]["y"];
    $inquiry_day_m  = $_POST["form_inquiry_day"]["m"];
    $inquiry_day_d  = $_POST["form_inquiry_day"]["d"];
    $inquiry_day    = $inquiry_day_y."-".$inquiry_day_m."-".$inquiry_day_d;
    $target_goods   = $_POST["form_target_goods"];
    $g_goods        = $_POST["form_g_goods"];
    $product        = $_POST["form_product"];
    $g_product      = $_POST["form_g_product"];
    $goods_cd       = $_POST["form_goods_cd"];
    $goods_name     = $_POST["form_goods_name"];
    $goods_cname    = $_POST["form_goods_cname"];
    $attri_div      = $_POST["form_attri_div"];
    $ware           = $_POST["form_ware"];
    $stock_div      = $_POST["form_stock_div"];
    $staff_ware     = $_POST["form_staff_ware"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    /* FROM */
    $sql = null;

    // �Ȳ�����̤������դ����ꤵ�줿���
    if ($inquiry_day != "--" && $inquiry_day > date("Y-m-d")){

        $sql  = "( \n";
        $sql .= "   SELECT \n";
        $sql .= "       t_stock.ware_id, \n";
        $sql .= "       t_stock.goods_id, \n";
        $sql .= "       t_stock.stock_num + COALESCE(t_stock1_io.stock1_io_data, 0) \n";
        $sql .= "                         - COALESCE(t_stock2_io.stock2_io_data, 0) \n";
        $sql .= "       AS stock_total \n"; 
        $sql .= "   FROM \n";
        $sql .= "       t_stock \n";
        // �߸˿�
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM( \n";
        $sql .= "                   CASE io_div \n";
        $sql .= "                       WHEN 1 THEN num *  1 \n";
        $sql .= "                       WHEN 2 THEN num * -1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS stock1_io_data \n";
        $sql .= "           FROM \n";
        $sql .= "               t_stock_hand \n";
        $sql .= "           WHERE \n";
        $sql .= "               work_div = '3' \n";
        $sql .= "           AND \n";
        if ($group_kind == "2"){
        $sql .= "               shop_id IN (".Rank_Sql().") \n";
        }else{
        $sql .= "               shop_id = $shop_id \n";
        }
        $sql .= "           AND \n";
        $sql .= "               work_day <= '$inquiry_day' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) AS t_stock1_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock1_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock1_io.ware_id \n";
        // ������
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM(\n";
        $sql .= "                   CASE io_div \n";
        $sql .= "                       WHEN 1 THEN num * -1 \n";
        $sql .= "                       WHEN 2 THEN num *  1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS stock2_io_data \n";
        $sql .= "           FROM \n";
        $sql .= "               t_stock_hand \n";
        $sql .= "           WHERE \n";
        $sql .= "               work_div = '1' \n";
        $sql .= "           AND \n";
        if ($group_kind == "2"){
        $sql .= "               shop_id IN (".Rank_Sql().") \n";
        }else{
        $sql .= "               shop_id = $shop_id \n";
        }
        $sql .= "           AND \n";
        $sql .= "               work_day < '$inquiry_day' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock2_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock2_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock2_io.ware_id \n";
        $sql .= "   WHERE \n";
        if ($group_kind == "2"){
        $sql .= "       shop_id IN (".Rank_Sql().") \n";
        }else{
        $sql .= "       shop_id = $shop_id \n";
        }
        $sql .= ") \n";
        $sql .= "AS t_stock_total \n";

    // �Ȳ����˲������դ����ꤵ�줿���
    }elseif ($inquiry_day != "--" && date("Y-m-d") > $inquiry_day){

        $sql  = "( \n";
        $sql .= "   SELECT \n";
        $sql .= "       t_stock.ware_id, \n";
        $sql .= "       t_stock.goods_id, \n";
        $sql .= "       t_stock.stock_num - COALESCE(t_stock1_io.stock1_io_data,0) \n";
        $sql .= "       AS stock_total \n";
        $sql .= "   FROM \n";
        $sql .= "       t_stock \n";
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM( \n";
        $sql .= "                   CASE io_div \n";
        $sql .= "                       WHEN 1 THEN num *  1 \n";
        $sql .= "                       WHEN 2 THEN num * -1 \n";
        $sql .= "                   END \n";
        $sql .= "               ) \n";
        $sql .= "               AS stock1_io_data \n";
        $sql .= "           FROM \n";
        $sql .= "               t_stock_hand \n";
        $sql .= "           WHERE \n";
        $sql .= "               work_div <> '1' \n";
        $sql .= "           AND \n";
        $sql .= "               work_div <> '3' \n";
        $sql .= "           AND \n";
        if ($group_kind == "2"){
        $sql .= "               shop_id IN (".Rank_Sql().") \n";
        }else{
        $sql .= "               shop_id = $shop_id \n";
        }
        $sql .= "           AND \n";
        $sql .= "               '$inquiry_day' < work_day \n";
        $sql .= "           AND \n";
        $sql .= "               work_day <= '".date("Y-m-d")."' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock1_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock1_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock1_io.ware_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS t_stock_total \n";

    // �Ȳ��������������դ����ꤵ�줿�ޤ��ϻ��꤬�ʤ����
    }elseif ($inquiry_day == "--" || $inquiry_day == date("Y-m-d")){

        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_stock.ware_id, \n";
        $sql .= "           t_stock.goods_id, \n";
        $sql .= "           t_stock.stock_num AS stock_total \n";
        $sql .= "       FROM \n";
        $sql .= "           t_stock \n";
        $sql .= "       WHERE \n";
        if ($group_kind == "2"){
        $sql .= "           shop_id IN (".Rank_Sql().") \n";
        }else{
        $sql .= "           shop_id = $shop_id \n";
        }
        $sql .= "   ) \n";
        $sql .= "   AS t_stock_total \n";

    }

    $from_sql = $sql;

    /* WHERE */
    $sql = null;

    // �оݾ��ʡ��������ʡ�
    if ($target_goods == "1"){
        $sql .= "AND t_goods.public_flg = 't' \n";
    // �оݾ��ʡּ��Ҿ��ʡ�
    }elseif ($target_goods == "2"){
        $sql .= "AND t_goods.shop_id = ".$_SESSION["client_id"]." \n";
        $sql .= "AND t_goods.public_flg = 'f' \n";
    }
    // �Ͷ�ʬ
    $sql .= ($g_goods != null) ? "AND t_goods.g_goods_id = $g_goods \n" : null;
    // ������ʬ
    $sql .= ($product != null) ? "AND t_goods.product_id = $product \n" : null;
    // ����ʬ��
    $sql .= ($g_product != null) ? "AND t_goods.g_product_id = $g_product \n" : null;
    // ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
    // ����̾
    $sql .= ($goods_name != null) ? "AND t_goods.goods_name LIKE '%$goods_name%' \n" : null;
    // ����̾ά��
    $sql .= ($goods_cname != null) ? "AND t_goods.goods_cname LIKE '%$goods_cname%' \n" : null;
    // °����ʬ
    $sql .= ($attri_div != null) ? "AND attri_div = '$attri_div' \n" : null;
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_stock_total.ware_id = $ware \n" : null;
    // �Ŀ��Ҹ�
    $sql .= ($staff_ware != null) ? "AND t_stock_total.ware_id = $staff_ware \n" : null;
    // �߸˶�ʬ�֥ޥ��ʥ��߸ˡ�
    if ($stock_div == "2"){
        $sql .= "AND stock_total < 0 \n";
    // �߸˶�ʬ�ֺ߸ˤ����
    }elseif ($stock_div == "0"){
        $sql .= "AND stock_total > 0 \n";
    // �߸˶�ʬ�ֺ߸ˣ���
    }elseif ($stock_div == "1"){
        $sql .= "AND stock_total = 0 \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
if($post_flg == true && $err_flg != true){
 
    $sql  = "SELECT \n";
    $sql .= "   '', \n";
    $sql .= "   t_product.product_name, \n";
    $sql .= "   t_g_goods.g_goods_name, \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.goods_name, \n";
    $sql .= "   t_goods.goods_cname, \n";
    $sql .= "   t_ware.ware_name, \n";
    $sql .= "   stock_total, \n";
    $sql .= "   t_price.r_price, \n";
    $sql .= "   stock_total * t_price.r_price AS stock_price, \n";
    $sql .= "   t_work_day.last_work_day, \n";
    $sql .= "   t_stock_total.ware_id, \n";
    $sql .= "   t_stock_total.goods_id, \n";
    $sql .= "   t_g_product.g_product_name \n";
    $sql .= "FROM \n";
    $sql .= $from_sql;
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ware_id, \n";
    $sql .= "           goods_id, \n";
    $sql .= "           MAX(work_day) AS last_work_day \n";
    $sql .= "       FROM \n";
    $sql .= "           t_stock_hand \n";
    $sql .= "       WHERE \n";
    $sql .= "           shop_id = $shop_id \n";
    $sql .= "       AND \n";
    $sql .= "           work_day <= '".date("Y-m-d")."' \n";
    $sql .= "       AND \n";
    $sql .= "           (work_div = '2' OR work_div = '4') \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           ware_id, \n";
    $sql .= "           goods_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_work_day \n";
    $sql .= "   ON t_stock_total.ware_id = t_work_day.ware_id \n";
    $sql .= "   AND t_stock_total.goods_id = t_work_day.goods_id \n";
    $sql .= "   INNER JOIN t_goods ON t_stock_total.goods_id = t_goods.goods_id \n";
    $sql .= "   INNER JOIN t_g_goods ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
    $sql .= "   INNER JOIN t_product ON t_goods.product_id = t_product.product_id \n";
    $sql .= "   INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "   INNER JOIN t_ware ON t_stock_total.ware_id = t_ware.ware_id \n";
    $sql .= "   INNER JOIN t_price ON t_stock_total.goods_id = t_price.goods_id \n";
    #2009-10-12 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    $sql .= "WHERE \n";
    #2009-10-12 hashimoto-y
    #$sql .= "   t_goods.stock_manage = '1' \n";
    $sql .= "    t_goods_info.stock_manage = '1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods_info.shop_id = $shop_id ";

    $sql .= "AND \n";
    if ($group_kind == "2"){
    $sql .= "   t_price.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   t_price.shop_id = $shop_id \n";
    }
    $sql .= "AND \n";
    $sql .= "   t_price.rank_cd = '3' \n";
    $sql .= "AND \n";
    if ($group_kind == "2"){
    $sql .= "   t_ware.shop_id IN (".Rank_Sql().") \n";
    }else{
    $sql .= "   t_ware.shop_id = $shop_id \n";
    }
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "   t_g_goods.g_goods_cd, \n";
    $sql .= "   t_product.product_cd, \n";
    $sql .= "   t_g_product.g_product_id, \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.attri_div, \n";
    $sql .= "   t_ware.ware_cd \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $match_count = pg_num_rows($result);
    for($i = 0; $i < $match_count; $i++){
        $page_data[] = pg_fetch_array($result, $i, PGSQL_NUM);

        //�ʥ�С��ե����ޥå�
        //�ޥ��ʥ��ξ����ֻ��˥��å�
        //��۹�פȿ��̤ι�פ����
        $num_total   = bcadd($num_total, $page_data[$i][7]);
        $money_total = bcadd($money_total, $page_data[$i][9]);

        if($page_data[$i][7] < 0){
            $page_data[$i][7] = number_format($page_data[$i][7]);
            $page_data[$i][7] = "<font color=\"red\">".$page_data[$i][7]."</font>";
        }else{
            $page_data[$i][7] = number_format($page_data[$i][7]);
        }
        $page_data[$i][8] = number_format($page_data[$i][8]);
        if($page_data[$i][9] < 0){
            $page_data[$i][9] = number_format($page_data[$i][9]);
            $page_data[$i][9] = "<font color=\"red\">".$page_data[$i][9]."</font>";
        }else{
            $page_data[$i][9] = number_format($page_data[$i][9]);
        }

        //���˥�����
        $page_data[$i][1] = htmlspecialchars($page_data[$i][1]);
        $page_data[$i][2] = htmlspecialchars($page_data[$i][2]);
        $page_data[$i][3] = htmlspecialchars($page_data[$i][3]);
        $page_data[$i][4] = htmlspecialchars($page_data[$i][4]);
        $page_data[$i][5] = htmlspecialchars($page_data[$i][5]);
        $page_data[$i][6] = htmlspecialchars($page_data[$i][6]);
        $page_data[$i][13] = htmlspecialchars($page_data[$i][13]);

    }

    if($num_total < 0){
        $num_total = number_format($num_total);
        $num_total = "<font color=\"red\">".$num_total."</font>";
    }else{
        $num_total = number_format($num_total);
    }

    if($money_total < 0){ 
        $money_total = number_format($money_total);
        $money_total = "<font color=\"red\">".$money_total."</font>";
    }else{
        $money_total = number_format($money_total);
    }

}

/****************************/
// �����å��ܥå�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // ȯ�����ϥ����å�
    $form->addElement("checkbox", "form_order_all_check", "", "ȯ������", "
        onClick=\"javascript:All_check('form_order_all_check', 'form_order_check', $match_count);\"
    ");

    for($i = 0; $i < $match_count; $i++){
        $form->addElement("checkbox", "form_order_check[$i]");
    }

    for($i = 0; $i < $match_count; $i++){
        $clear_data["form_order_check"][$i] = "";
    }
    $clear_data["form_order_all_check"] = "";
       
    $form->setConstants($clear_data);

}


/****************************/
// ȯ��ܥ��󲡲�����
/****************************/
if ($_POST["order_button_flg"] == "true" && $_POST["form_show_button"] == null){

    // ̤�����å���
    if (count($_POST["form_order_check"]) == 0){
        $form->setElementError("order_err1", "ȯ���뾦�ʤ����򤷤Ƥ���������");
        $ord_err_flg = true;
    }

    // �оݾ��ʤ����򤵤�Ƥ��ʤ��ä����
    if ($target_goods == "3"){
        $form->setElementError("order_err2", "�оݾ��ʤ���������ʡפޤ��ϡ֤���¾���ʡפǸ����塢ȯ�����Ϥ��Ʋ�������");
        $ord_err_flg = true;
    }

    // ���顼���ʤ����
    if ($ord_err_flg != true){

        /****************************/
        // ȯ����ID�����
        /****************************/
        for ($i = 0; $i < $match_count; $i++){
            if ($_POST["form_order_check"][$i] == 1){
                $order_goods_id[] = $page_data[$i][12];
            }      
        }      
        //��ʣ��Ż���
        asort($order_goods_id);
        $order_goods_id = array_values(array_unique($order_goods_id));

        /****************************/
        //GET�����ͤ�����
        /****************************/
        $j = 0;
        for ($i = 0; $i < count($order_goods_id); $i++){
            $get_goods_id .= "order_goods_id[$j]=".$order_goods_id[$i];
            if ($i != count($order_goods_id)-1){
                $get_goods_id .= "&";
                $j = $j+1;
            }else{ 
                break;
            }
        }

        // ȯ�����Ϥإܥ��󲡲��ե饰�򥯥ꥢ
        $clear_hdn["order_button_flg"] = "";
        $form->setConstants($clear_hdn);

        $get_goods_id = $get_goods_id."&target_goods=".$_POST["form_target_goods"];
        header("Location: ".FC_DIR."buy/2-3-102.php?$get_goods_id");

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
$page_menu = Create_Menu_f("stock", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["4_101_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_105_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_109_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
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
	'inquiry_day'   => "$inquiry_day",
    'num_total'     => "$num_total",
    'money_total'   => "$money_total",
    'err_flg'       => "$err_flg",
    'match_count'   => "$match_count",
));

$smarty->assign("page_data", $page_data);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>
