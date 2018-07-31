<?php
/********************
 * �߸˾Ȳ�
 *
 *
 * �ѹ�����
 *    2006/07/10 (kaji)
 *      ��shop_gid��ʤ���
 *    2006/07/28 (watanabe-k)
 *      ���Ȳ����η������ξ��0��᤹��褦���ѹ�
 *    2006/08/07 (watanabe-k)
 *      ������ʬ���ɲ�
 *    2006/08/21 (watanabe-k)
 *      ���߸˶�ۤ򥫥�޶��ڤ��ɽ��
 *      �����̤ȶ�ۤι�פ�ɽ��
 *      ��ά�Τ����ɽ�����ʤ���
 *
 ********************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2006/10/16  06-004        watanabe-k  �߸˾Ȳ�ȯ�����Ϥز������ܤ�����硢��󥿥��२�顼��ȯ������
 *   2006/11/06  06-041        watanabe-k  ���ٸ�������ȯ�����Ϥ����ܤ����������򤷤����ʤȤϰ㤦��Τ�ȯ�����Ϥ�ɽ�������Х��ν���
 *   2006/12/06  ban_0010      suzuki      �����ե��顼��å������ѹ�
                 ban_0012                  �����ե��顼�����å�����
 *   2007/02/22                watanabe-k  ���׵�ǽ�κ��
 *  2007-03-30                  fukuda      ����������������ɲ�
 *  2007-04-09  ����¾No131     fukuda      �إå����˥�󥯥ܥ�������
 *  2007/04/17   B0702-042     kajioka-h   ������ɥ������ȥ�˲������إܥ����HTML�����Ϥ���Ƥ����Τ���
 *  2007/07/13                 watanabe-k  �ơ��֥�����̤�뽤�������˥������󥰤Ǥ��Ƥ��ʤ��Х��ν���
 *  2009/10/12                 hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2016/01/22                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�  
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
    "form_g_goods"      => "",  
    "form_product"      => "",  
    "form_g_product"    => "",  
    "form_goods_cd"     => "",  
    "form_goods_name"   => "",  
    "form_goods_cname"  => "",  
    "form_attri_div"    => "",  
    "form_ware"         => "",  
    "form_stock_div"    => "",  
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
$shop_id    = $_SESSION["client_id"];


/****************************/
// ���������
/****************************/


/****************************/
// �ե�����ѡ������
/****************************/
// �Ȳ���
Addelement_Date($form, "form_inquiry_day", "�Ȳ���", "-");

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

// �߸˶�ʬ
$stock_value = array(null => "", "�߸�ͭ��", "�߸ˣ�", "�ޥ��ʥ��߸�");
$form->addElement("select", "form_stock_div", "", $stock_value, $g_form_option_select);

// �Ҹ�
$select_value = Select_Get($db_con, "ware");
$form->addElement("select", "form_ware",  "", $select_value, $g_form_option_select);

// ���ʥ��롼��
$select_value = Select_Get($db_con, "goods_gr");
$form->addElement("select", "form_goods_gr", "", $select_value, $g_form_option_select);

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����", "");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// ȯ�����Ϥإܥ���
$form->addElement("button", "form_order_button", "ȯ�����Ϥ�",
    "onClick=\"javascript:Button_Submit('order_button_flg', '".$_SERVER["PHP_SELF"]."', 'true', this); \" $disabled"
);

// �߸˾Ȳ��󥯥ܥ���
$form->addElement("button", "4_101_button", "�߸˾Ȳ�", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// �߸˼�ʧ��󥯥ܥ���
$form->addElement("button", "4_105_button", "�߸˼�ʧ", "onClick=\"location.href('./1-4-105.php');\"");

// ��α�߸˰�����󥯥ܥ���
$form->addElement("button", "4_110_button", "��α�߸˰���", "onClick=\"javascript:location.href('./1-4-110.php')\"");

// �����ե饰
$form->addElement("hidden", "order_button_flg");

// ���顼���å���
$form->addElement("text", "order_err1");


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
    $g_goods        = $_POST["form_g_goods"];
    $product        = $_POST["form_product"];
    $g_product      = $_POST["form_g_product"];
    $goods_cd       = $_POST["form_goods_cd"];
    $goods_name     = $_POST["form_goods_name"];
    $goods_cname    = $_POST["form_goods_cname"];
    $attri_div      = $_POST["form_attri_div"];
    $stock_div      = $_POST["form_stock_div"];
    $ware           = $_POST["form_ware"];
    $goods_gr       = $_POST["form_goods_gr"];

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

        $sql .= "( \n";
        $sql .= "   SELECT \n";
        $sql .= "       t_stock.ware_id, \n";
        $sql .= "       t_stock.goods_id, \n";
        $sql .= "       t_stock.stock_num + COALESCE(t_stock1_io.stock1_io_data, 0) \n";
        $sql .= "                         - COALESCE(t_stock2_io.stock2_io_data, 0) \n";
        $sql .= "       AS stock_total \n";
        $sql .= "   FROM \n";
        // �߸˿�
        $sql .= "       t_stock \n";
        // ȯ��Ŀ�
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
        $sql .= "               shop_id = $shop_id \n";
        $sql .= "           AND \n";
        $sql .= "               work_day <= '$inquiry_day' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock1_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock1_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock1_io.ware_id \n";
        // ������
        $sql .= "       LEFT JOIN \n";
        $sql .= "       ( \n";
        $sql .= "           SELECT \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id, \n";
        $sql .= "               SUM( \n";
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
        $sql .= "               shop_id = $shop_id \n";
        $sql .= "           AND \n";
        $sql .= "               work_day <= '$inquiry_day' \n";
        $sql .= "           GROUP BY \n";
        $sql .= "               ware_id, \n";
        $sql .= "               goods_id \n";
        $sql .= "       ) \n";
        $sql .= "       AS t_stock2_io \n";
        $sql .= "       ON t_stock.goods_id = t_stock2_io.goods_id \n";
        $sql .= "       AND t_stock.ware_id = t_stock2_io.ware_id \n";
        $sql .= "   WHERE \n";
        $sql .= "       t_stock.shop_id = $shop_id \n"; 
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
        $sql .= "               shop_id = $shop_id \n";
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
        $sql .= "   WHERE \n";
        $sql .= "       t_stock.shop_id = $shop_id \n";
        $sql .= ") \n";
        $sql .= "AS t_stock_total \n";

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
        $sql .= "           shop_id = $shop_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS t_stock_total \n";

    }

    $from_sql = $sql;

    /* WHERE */
    $sql = null;

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
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_stock_total.ware_id = $ware \n" : null;
    // ���ʥ��롼��
    if ($goods_gr != null){
        $sql .= "AND t_goods_gr.goods_id = t_goods.goods_id \n";
        $sql .= "AND t_goods_gr.goods_gid = $goods_gr \n";
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;

}


/****************************/
// �����ǡ�������
/****************************/
if($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_g_goods.g_goods_name, \n";
    $sql .= "   t_product.product_name, \n";
    $sql .= "   t_g_product.g_product_name, \n";
    $sql .= "   t_goods.goods_name, \n";
    $sql .= "   t_ware.ware_name, \n";
    $sql .= "   stock_total, \n";
    $sql .= "   t_price.r_price, \n";
    $sql .= "   stock_total * t_price.r_price AS stock_price, \n";
    $sql .= "   t_work_day.last_work_day, \n";
    $sql .= "   t_stock_total.ware_id, \n";
    $sql .= "   t_stock_total.goods_id \n";
    $sql .= " FROM \n";
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
    $sql .= "           work_div IN ('2', '4') \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           ware_id, \n";
    $sql .= "           goods_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_work_day \n";
    $sql .= "   ON t_stock_total.ware_id = t_work_day.ware_id \n";
    $sql .= "   AND t_stock_total.goods_id = t_work_day.goods_id \n";
    $sql .= "   INNER JOIN t_goods ON t_goods.goods_id = t_stock_total.goods_id \n";
    $sql .= "   INNER JOIN t_g_goods ON t_g_goods.g_goods_id = t_goods.g_goods_id \n";
    $sql .= "   INNER JOIN t_product ON t_product.product_id = t_goods.product_id \n";
    $sql .= "   INNER JOIN t_g_product ON t_g_product.g_product_id = t_goods.g_product_id \n";
    $sql .= "   INNER JOIN t_ware ON t_stock_total.ware_id = t_ware.ware_id \n";
    $sql .= "   INNER JOIN t_price ON t_price.goods_id = t_stock_total.goods_id \n";
    #2009-10-12 hashimoto-y
    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    //���ʥ��롼�פ����ꤵ�줿���
    if($goods_gr != null){
    $sql .= "   INNER JOIN t_goods_gr ON t_goods.goods_id = t_goods_gr.goods_id \n";
    }
    $sql .= "WHERE \n";
    #2009-10-12 hashimoto-y
    #$sql .= "   t_goods.stock_manage = '1' \n";
    $sql .= "    t_goods_info.stock_manage = '1' \n";
    $sql .= "    AND \n";
    $sql .= "    t_goods_info.shop_id = $shop_id ";

    $sql .= "AND \n";
    $sql .= "   t_goods.public_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.compose_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_price.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_price.rank_cd = '1' \n";
    $sql .= $where_sql;
    $sql .= " ORDER BY \n";
    $sql .= "   t_g_goods.g_goods_cd, \n";
    $sql .= "   t_product.product_cd, \n";
    $sql .= "   t_g_product.g_product_id, \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.attri_div, \n";
    $sql .= "   t_ware.ware_cd \n";

    //�ҥåȷ��
    $total_sql = $sql.";";
    $result = Db_Query($db_con,$total_sql);
    $total_count = pg_num_rows($result);

    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $match_count = pg_num_rows($result);

    for($i = 0; $i < $match_count; $i++){
        $page_data[] = pg_fetch_array($result, $i, PGSQL_NUM);

        //��ۤȽ�λ�ι�פ�ɽ��
        $num_total = bcadd($num_total, $page_data[$i][6]);
        $money_total = bcadd($money_total, $page_data[$i][8]);


        //���˥�������
        $page_data[$i][1] = htmlspecialchars($page_data[$i][1]);
        $page_data[$i][2] = htmlspecialchars($page_data[$i][2]);
        $page_data[$i][3] = htmlspecialchars($page_data[$i][3]);
        $page_data[$i][4] = htmlspecialchars($page_data[$i][4]);
        $page_data[$i][5] = htmlspecialchars($page_data[$i][5]);



        //-�ξ���ɽ�������֤�����
        if($page_data[$i][6] < 0){
            $page_data[$i][6] = number_format($page_data[$i][6]);
            $page_data[$i][6] = "<font color=\"red\">".$page_data[$i][6]."</font>";
        }else{
            $page_data[$i][6] = number_format($page_data[$i][6]);
        }

        $page_data[$i][7] = number_format($page_data[$i][7],2);
        if($page_data[$i][8] < 0){
            $page_data[$i][8] = number_format($page_data[$i][8]);
            $page_data[$i][8] = "<font color=\"red\">".$page_data[$i][8]."</font>";
        }else{
            $page_data[$i][8] = number_format($page_data[$i][8]);
        }
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
// �إå���ɽ�����뾦�ʥ��롼��̾�����
/****************************/
if($goods_gr != null){
    $sql  = "SELECT";
    $sql .= "   goods_gname";
    $sql .= " FROM";
    $sql .= "   t_goods_gr";
    $sql .= " WHERE";
    $sql .= "   goods_gid = $goods_gr";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);    
    $goods_gr_name = pg_fetch_result($result,0,0);
}

/****************************/
//�����å��ܥå�������
/****************************/
//ȯ�����ϥ����å�
$form->addElement(
    "checkbox", "form_order_all_check", '', 'ȯ������',"
    onClick=\"javascript:All_check('form_order_all_check','form_order_check',$match_count)\""
);

for($i = 0; $i < $match_count; $i++){
    $form->addElement("checkbox", "form_order_check[$i]","","","");
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

    // ���顼���ʤ����
    if ($ord_err_flg != true){

        /****************************/
        // ȯ����ID�����
        /****************************/
        for ($i = 0; $i < $match_count; $i++){
            if ($_POST["form_order_check"][$i] == 1){
                $order_goods_id[] = $page_data[$i][11];
            }
        }
        //��ʣ��Ż���
        asort($order_goods_id);
        $order_goods_id = array_values(array_unique($order_goods_id));

        /****************************/
        // GET�����ͤ�����
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

        header("Location: ".HEAD_DIR."buy/1-3-102.php?$get_goods_id");

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
//$page_menu = Create_Menu_h('stock','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["4_101_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_105_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["4_110_button"]]->toHtml();
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
	//'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
    'goods_gr_name' => "$goods_gr_name",
	'day'           => "$inquiry_day",
    'match_count'   => "$match_count",
    'num_total'     => "$num_total",
    'money_total'   => "$money_total",
    "err_flg"       => "$err_flg",
));
$smarty->assign('page_data',$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
