<?php
/***********************
�ѹ�����
    ��URL��ɽ������褦���ѹ�

    (2006-08-07)(kaji)
    ��ľ�İʳ��Υ桼���ǥ����ꥨ�顼���Ф�Τǥ��ڡ����������

***********************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-07      ban_0097    suzuki      ɽ���ܥ��󲡲����˹�NO�����
 *  2006-12-14      ban_0098    kaji        ���֤�̵�����������ʤ�������˴ޤޤ�Ƥ����Τ�ޤޤʤ��褦��
 *  2007-01-16      �����ѹ�    watanabe-k  �����Ƚ���ѹ�
 *  2007-05-15      �����ѹ�    watanabe-k  �ãӣ֤���� 
 *  
 *                  6/28�դ��fukuda�������ȵ�ǽ���դ����Ȼפ���
 *  
 *  2007/09/05      �Х�        kajioka-h   $_SESSION["group_kind"]��$group_kind������Ƥʤ��Τ�$group_kind��ȤäƤ���Х�����
 *  2009-10-08      �����ѹ�    hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2010-05-13      Rev.1.5     hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
 *  2011-06-23      �Х�����    aoyama-n    CSV�˻���������ɽ������ʤ��Զ�罤��
 *
*/

$page_title = "���ʥޥ���";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

// DB����³
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_goods_cd"     => "",
    "form_g_goods"      => "",
    "form_product"      => "",
    "form_g_product"    => "",
    "form_goods_name"   => "",
    "form_goods_cname"  => "",
    "form_stock_only"   => "3",
    "form_state"        => "1",
    "form_output_type"  => "1",
    "form_display_num"  => "1",
);

// �����������
Restore_Filter2($form, "sale", "form_show_button", $ary_form_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
#2011-06-23 aoyama-n
$rank_cd  = $_SESSION["rank_cd"];


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

$limit          = 100;      // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե���������
/****************************/
// ���ʥ�����
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");

// �Ͷ�ʬ
$item   =   null;
$item   =   Select_Get($db_con, "g_goods");
$form->addElement("select", "form_g_goods", "", $item);

// ������ʬ
$item   =   null;
$item   =   Select_Get($db_con, "product");
$form->addElement("select", "form_product", "", $item);

// ����ʬ��
$item   =   null;
$item   =   Select_Get($db_con, "g_product");
$form->addElement("select", "form_g_product", "", $item);

// ����̾
$form->addElement("text", "form_goods_name", "", "size=\"56\" $g_form_option");

// ά��
$form->addElement("text", "form_goods_cname", "", "size=\"34\" $g_form_option");

// �߸˸¤���
$obj    =   null;
$obj[]  =   $form->createElement("radio", null, null, "�߸˸¤�",       "1");
$obj[]  =   $form->createElement("radio", null, null, "�߸˸¤�Ǥʤ�", "2");
$obj[]  =   $form->createElement("radio", null, null, "����",           "3");
$form->addGroup($obj, "form_stock_only", "");

// ����
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "ͭ��", "1");
$obj[]  =&  $form->createElement("radio", null, null, "̵��", "2");
$obj[]  =&  $form->createElement("radio", null, null, "����", "3");
$form->addGroup($obj, "form_state", "");

// ���Ϸ���
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "����", "1");
$obj[]  =&  $form->createElement("radio", null, null, "CSV",  "2");
$form->addGroup($obj, "form_output_type", "���Ϸ���");

// ɽ�����
$obj    =   null;
$obj[]  =&  $form->createElement("radio", null, null, "100��ɽ��", "1");
$obj[]  =&  $form->createElement("radio", null, null, "����ɽ��",  "2");
$form->addGroup($obj, "form_display_num", "ɽ�����");

// °����ʬ�ʤ���ߥ��
$ary_narrow_item = array(
    "nl_attri_div1"     => "����",
    "nl_attri_div2"     => "����",
    "nl_attri_div3"     => "����",
    "nl_attri_div4"     => "ƻ��¾",
    "nl_attri_div5"     => "�ݸ�",
    "nl_attri_div6"     => "����",
);
AddElement_Sort_Link($form, $ary_narrow_item, "nl_attri_div6", "hdn_attri_div");

// °����ʬ�ʤ���߾����������ݻ��ѡ�
$form->addElement("hidden", "hdn_attri_div2");

// �����ȥ��
$ary_sort_item = array(
    "sl_goods_cd"       => "���ʥ�����",
    "sl_g_goods"        => "�Ͷ�ʬ",
    "sl_product"        => "������ʬ",
    "sl_g_product"      => "����ʬ��",
    "sl_goods_name"     => "����̾",
    "sl_goods_cname"    => "ά��",
    "sl_attribute"      => "°����ʬ",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_goods_cd");

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// �إå�����󥯥ܥ���
$ary_h_btn_list = array("��Ͽ����" => "./2-1-221.php", "�ѹ�������" => $_SERVER["PHP_SELF"]);
Make_H_Link_Btn($form, $ary_h_btn_list);


/****************************/
// ɽ���ܥ��󲡲���
/****************************/
if ($_POST["form_display"] != null){

    /****************************/
    // ���顼�����å�
    /****************************/
    // �ʤ�

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $test = $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. �ڡ����ڤ��ؤ���������¾��POST��
/****************************/
if (($_POST["form_show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["form_show_button"] == null)){

    // POST�ǡ������ѿ��˥��å�
    $goods_cd       = $_POST["form_goods_cd"];
    $g_goods        = $_POST["form_g_goods"];
    $product        = $_POST["form_product"];
    $g_product      = $_POST["form_g_product"];
    $goods_name     = $_POST["form_goods_name"];
    $goods_cname    = $_POST["form_goods_cname"];
    $stock_only     = $_POST["form_stock_only"];
    $state          = $_POST["form_state"];
    $output_type    = $_POST["form_output_type"];
    $display_num    = $_POST["form_display_num"];

    $attri_div      = $_POST["hdn_attri_div"];

    $sort_col       = $_POST["hdn_sort_col"];

/****************************/
// 3. ���ɽ����
/****************************/
}elseif ($_POST == null){

    $stock_only     = "3";
    $state          = "1";
    $output_type    = "1";
    $display_num    = "1";

    $attri_div      = "nl_attri_div6";

    $sort_col       = "sl_goods_cd";

}


#2010-05-12 hashimoto-y
if($_POST["form_show_button"]=="ɽ����" || $_POST != null){


/****************************/
// �����ǡ�������������
/****************************/
if ($err_flg != true){

    $sql = null;

    // ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
    // �Ͷ�ʬ
    $sql .= ($g_goods != null) ? "AND t_goods.g_goods_id = $g_goods \n" : null;
    // ������ʬ
    $sql .= ($product != null) ? "AND t_goods.product_id = $product \n" : null;
    // ����ʬ��
    $sql .= ($g_product != null) ? "AND t_goods.g_product_id = $g_product \n" : null;
    // ����̾
    $sql .= ($goods_name != null) ? "AND t_goods.goods_name LIKE '%$goods_name%' \n" : null;
    // ά��
    $sql .= ($goods_cname != null) ? "AND t_goods.goods_cname LIKE '%$goods_cname%' \n" : null;
    // �߸˸¤���
    if ($stock_only == "1"){
        $sql .= "AND t_goods.stock_only = '1' \n";
    }else
    if ($stock_only == "2"){
        $sql .= "AND t_goods.stock_only != '1' \n";
    }
    // ����
    // ľ�Ĥ�����ͭ�����ʤ�ľ�ľ��ʤ��о�
    if ($group_kind == "2"){
        if ($state == "1"){
            $sql .= "AND t_goods.state IN ('1', '3') \n";
        }else
        if ($state == "2"){
            $sql .= "AND t_goods.state = '2' AND t_goods.shop_id IN (".Rank_Sql().") \n";
        }else{  
            $sql .= "AND (t_goods.state IN ('1', '3') OR (t_goods.state = '2' AND t_goods.shop_id IN (".Rank_Sql()."))) \n";
        }
    // FC������ͭ�����ʤ�FC���ʤ��о�
    }else{
        if ($state == "1"){
            $sql .= "AND t_goods.state = '1' \n";
        }else
        if ($state == "2"){
            $sql .= "AND t_goods.state = '2' AND t_goods.shop_id = $shop_id \n";
        }else{  
            $sql .= "AND (t_goods.state = '1' OR (t_goods.state = '2' AND t_goods.shop_id = $shop_id)) \n";
        }
    }

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    // °����ʬ
    switch ($attri_div){
        case "nl_attri_div1":
            $sql .= "AND t_goods.attri_div = '1' \n";
            break;
        case "nl_attri_div2":
            $sql .= "AND t_goods.attri_div = '2' \n";
            break;
        case "nl_attri_div3":
            $sql .= "AND t_goods.attri_div = '3' \n";
            break;
        case "nl_attri_div4":
            $sql .= "AND t_goods.attri_div = '4' \n";
            break;
        case "nl_attri_div5":
            $sql .= "AND t_goods.attri_div = '5' \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $attri_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($sort_col){
        // ���ʥ�����
        case "sl_goods_cd":
            $sql .= "   t_goods.goods_cd, \n";
            $sql .= "   t_g_goods.g_goods_cd, \n";
            $sql .= "   t_product.product_cd, \n";
            $sql .= "   t_g_product.g_product_cd \n";
            break;
        // �Ͷ�ʬ
        case "sl_g_goods":
            $sql .= "   t_g_goods.g_goods_cd, \n";
            $sql .= "   t_goods.goods_cd \n";
            break;
        // ������ʬ
        case "sl_product":
            $sql .= "   t_product.product_cd, \n";
            $sql .= "   t_goods.goods_cd \n";
            break;
        // ����ʬ��
        case "sl_g_product":
            $sql .= "   t_g_product.g_product_cd, \n";
            $sql .= "   t_goods.goods_cd \n";
            break;
        // ����̾
        case "sl_goods_name":
            $sql .= "   t_goods.goods_name, \n";
            $sql .= "   t_goods.goods_cd \n";
            break;
        // ά��
        case "sl_goods_cname":
            $sql .= "   t_goods.goods_cname, \n";
            $sql .= "   t_goods.goods_cd \n";
            break;
        // °����ʬ
        case "sl_attribute":
            $sql .= "   t_goods.attri_div, \n";
            $sql .= "   t_goods.goods_cd \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// ɽ���ǡ�������
/****************************/
if($output_type == "1"){

    /****************************/
    // �ǡ�����ɽ���������������
    /****************************/
    $sql  = "SELECT \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.goods_id, \n";
    $sql .= "   t_goods.goods_name, \n";
    $sql .= "   t_goods.goods_cname, \n";
    $sql .= "   t_product.product_name, \n";
    $sql .= "   t_g_goods.g_goods_name, \n";
    $sql .= "   CASE t_goods.attri_div \n";
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "       WHEN '3' THEN '����' \n";
    $sql .= "       WHEN '4' THEN 'ƻ��¾' \n";
    $sql .= "   END, \n";
    $sql .= "   CASE t_goods.state \n";
    $sql .= "       WHEN '1' THEN 'ͭ��' \n";
    $sql .= "       WHEN '2' THEN '̵��' \n";
    $sql .= "       WHEN '3' THEN 'ͭ����ľ�ġ�' \n";
    $sql .= "   END, \n";
    $sql .= "   t_goods.url, \n";
	$sql .= "   t_g_product.g_product_name,  \n";
	$sql .= "   t_goods.stock_only,  \n";
    $sql .= "   t_goods.no_change_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_goods, \n";
    $sql .= "   t_goods_info, \n";
    $sql .= "   t_g_goods, \n";
    $sql .= "   t_product, \n";
	$sql .= "   t_g_product  \n";
    $sql .= "WHERE";
    $sql .= "   t_goods_info.shop_id = $shop_id  \n";
    $sql .= "AND \n";
    $sql .= "   t_goods_info.goods_id = t_goods.goods_id \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.g_goods_id = t_g_goods.g_goods_id \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.product_id = t_product.product_id \n";
	$sql .= "AND \n";
	$sql .= "   t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.compose_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.accept_flg = '1' \n";
    $sql .= $where_sql;
    $sql .= $attri_sql;
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;

    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // °����ʬ�ιʤ���߾���hidden���������ݻ��ѡˤ˥��å�
    $hdn_set["hdn_attri_div2"] = $_POST["hdn_attri_div"];
    $form->setConstants($hdn_set);

    // °����ʬ��󥯸������������줿����hidden���������ݻ��ѡˤȡ�POST���줿�ʤ���߾�郎�ۤʤ����
    // ���ġ�°����ʬ��󥯸����������ͤ�POST��������
    if ($_POST["hdn_attri_div"] != $_POST["hdn_attri_div2"] && $_POST["hdn_attri_div2"] != null){
        $page_count = 1;
    }

    // ɽ�����
    switch ($display_num){
        case "1":
            $limit = "100";
            break;
        case "2":
            $limit = $total_count;
            break;
    }

    // �������ϰ���
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null;
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $goods_data     = Get_Data($res, $output_type);

    // ���ʥ���Х�򥨥�������
    for ($i = 0; $i < $match_count; $i++){
        $goods_data[$i][8] = addslashes($goods_data[$i][8]);
    }

// ɽ��������CSV�λ�
}elseif ($output_type == "2"){

    $sql  = "SELECT \g_goods_idn";
    $sql .= "   CASE t_goods.state  \n";                // ����
    $sql .= "       WHEN '1' THEN 'ͭ��' \n";
    $sql .= "       WHEN '2' THEN '̵��' \n";
    $sql .= "       WHEN '3' THEN 'ͭ��' \n";
    $sql .= "   END AS state, \n";
    $sql .= "   CASE t_goods.rental_flg \n";
    $sql .= "       WHEN 't' THEN '����' \n";
    $sql .= "       ELSE '�ʤ�' \n";
    $sql .= "   END AS rental_flg, \n";                 // RtoR
    $sql .= "   CASE t_goods.serial_flg \n";
    $sql .= "       WHEN 't' THEN '����' \n";
    $sql .= "       WHEN 'f' THEN '�ʤ�' \n";
    $sql .= "   END AS serial_flg, \n";                 // ���ꥢ�����
    $sql .= "   t_goods.goods_cd, \n";                  // ���ʥ�����
    $sql .= "   t_g_goods.g_goods_cd, \n";              // �Ͷ�ʬ������
    $sql .= "   t_g_goods.g_goods_name, \n";            // �Ͷ�ʬ̾
    $sql .= "   t_product.product_cd, \n";              // ������ʬ������
    $sql .= "   t_product.product_name, \n";            // ������ʬ̾
    $sql .= "   t_g_product.g_product_cd, \n";          // ����ʬ�ॳ����
    $sql .= "   t_g_product.g_product_name, \n";        // ����ʬ��  ʬ̾
    $sql .= "   t_goods.goods_name, \n";                // ����̾
    $sql .= "   t_goods.goods_cname, \n";               // ά��
    $sql .= "   CASE t_goods.attri_div \n";             // °����ʬ
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '����' \n";
    $sql .= "       WHEN '3' THEN '����' \n";
    $sql .= "       WHEN '4' THEN 'ƻ��¾' \n";
    $sql .= "       WHEN '5' THEN '�ݸ�' \n";
    $sql .= "   END AS attri_div, \n";
    $sql .= "   t_goods.url, \n";                       // ���ʥ���Х�
    $sql .= "   CASE t_goods.mark_div \n";              // �ޡ���
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '2' THEN '�ǣ�' \n";
    $sql .= "       WHEN '3' THEN '�ţ�' \n";
    $sql .= "       WHEN '4' THEN '��Ŭ' \n";
    $sql .= "       WHEN '5' THEN '��ʪ' \n";
    $sql .= "   END AS mark_div, \n";
    $sql .= "   t_goods.unit, \n";                      // ñ��
    $sql .= "   t_goods.in_num, \n";                    // ����
    $sql .= "   CASE t_goods.public_flg \n";            // ������1������
    $sql .= "       WHEN 't' THEN t_head_client.client_cd1 \n";
    $sql .= "       WHEN 'f' THEN t_client.client_cd1 \n";
    $sql .= "   END AS client_cd, \n";
    $sql .= "   CASE t_goods.public_flg \n";            // ������1̾
    $sql .= "       WHEN 't' THEN t_head_client.client_name \n";
    $sql .= "       WHEN 'f' THEN t_client.client_name \n";
    $sql .= "   END AS client_name, \n";
    $sql .= "   CASE t_goods.sale_manage \n";           // �������
    $sql .= "       WHEN '1' THEN 'ͭ' \n";
    $sql .= "       WHEN '2' THEN '̵' \n";
    $sql .= "   END AS sale_manage, \n";
    #2009-10-08 hashimoto-y
    #$sql .= "   CASE t_goods.stock_manage \n";          // �߸˴���
    $sql .= "   CASE t_goods_info.stock_manage \n";          // �߸˴���
    $sql .= "       WHEN '1' THEN 'ͭ' \n";
    $sql .= "       WHEN '2' THEN '̵' \n";
    $sql .= "   END AS stock_manage, \n";
    $sql .= "   CASE  t_goods.stock_only \n";           // �߸˸¤���
    $sql .= "       WHEN '1' THEN '��' \n";
    $sql .= "       ELSE '��' \n";
    $sql .= "   END AS stock_only, \n";
    $sql .= "   t_goods_info.order_point, \n";          // ȯ����
    $sql .= "   t_goods_info.order_unit, \n";           // ȯ��ñ�̿�
    $sql .= "   t_goods_info.lead, \n";                 // �꡼�ɥ�����
    $sql .= "   CASE t_goods.name_change \n";           // ��̾�ѹ�
    $sql .= "       WHEN '1' THEN '�ѹ���' \n";
    $sql .= "       WHEN '2' THEN '�ѹ��Բ�' \n";
    $sql .= "   END AS name_change, \n";
    $sql .= "   CASE t_goods.tax_div \n";               // ���Ƕ�ʬ
    $sql .= "       WHEN '1' THEN '����' \n";
    $sql .= "       WHEN '3' THEN '�����' \n";
    $sql .= "   END AS tax_div, \n";
    $sql .= "   t_goods_info.note, \n";                 // ����
    $sql .= "   t_goods.goods_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_goods_info \n";
    $sql .= "   INNER JOIN t_goods                  ON  t_goods.goods_id = t_goods_info.goods_id \n";
    $sql .= "                                       AND t_goods_info.shop_id = $shop_id \n";
    $sql .= "   INNER JOIN t_product                ON  t_goods.product_id = t_product.product_id \n";
    $sql .= "   INNER JOIN t_g_goods                ON  t_goods.g_goods_id = t_g_goods.g_goods_id \n";
    $sql .= "   INNER JOIN t_g_product              ON  t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "   LEFT JOIN t_client                  ON  t_goods_info.supplier_id = t_client.client_id \n";
    $sql .= "                                       AND t_client.client_div = '2' \n";
    $sql .= "   LEFT JOIN t_client AS t_head_client ON  t_goods_info.shop_id = t_head_client.shop_id \n";
    $sql .= "                                       AND t_head_client.head_flg = 't' \n";
    $sql .= "WHERE\n";
    $sql .= "   t_goods.compose_flg = 'f' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.accept_flg = '1' \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "   t_goods.goods_cd \n";
    $sql .= ";";

    $res        = Db_Query($db_con, $sql);
    $goods_data = Get_Data($res, $output_type);
    $data_num   = pg_num_rows($res);

    //CSV����
    //CSV����
    $csv_file_name = "���ʥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "����",
        "RtoR",
        "���ꥢ�����",
        "���ʥ�����", 
        "�Ͷ�ʬ������",
        "�Ͷ�ʬ̾",
        "������ʬ������",
        "������ʬ̾",
        "����ʬ�ॳ����",
        "����ʬ��̾",
        "����̾",
        "ά��",
        "°����ʬ",
        "���ʥ���Х�",
        "�ޡ���",
        "ñ��",
        "����",
        "�����襳����",
        "������̾",
        "�������",
        "�߸˴���",
        "�߸˸¤���",
        "ȯ����",
        "ȯ��ñ�̿�",
        "�꡼�ɥ�����",
        "��̾�ѹ�",
        "���Ƕ�ʬ",
        "����",
        "��������",
        "�߸˸���",
        "�Ķȸ���",
        "ɸ�����",
    );

    for($i = 0; $i < $data_num; $i++){
        //ñ�������
        $sql  = "SELECT \n";
        $sql .= "   t_price.r_price, \n";
        $sql .= "   CASE rank_cd \n";
        $sql .= "       WHEN '2' THEN '3' \n";
        $sql .= "       WHEN '3' THEN '2' \n";
        $sql .= "       WHEN '4' THEN '4' \n";
        $sql .= "       ELSE '1' \n";
        $sql .= "   END AS sort \n"; 
        $sql .= "FROM \n";
        $sql .= "   t_price \n";
        $sql .= "WHERE \n";
        $sql .= "   goods_id = ".$goods_data[$i][28]." \n";
        $sql .= "   AND \n";
        $sql .= "   (shop_id = $shop_id \n";
        $sql .= "   OR ";
        $sql .= "   (rank_cd IN ('$rank_cd', '4') AND shop_id =1)";
        $sql .= "   ) \n";
        $sql .= "ORDER BY \n";
        $sql .= "   sort \n"; 
        $sql .= ";";

        $res = Db_Query($db_con, $sql);

        unset($goods_data[$i][28]);
        $num = pg_num_rows($res);
        for($j = 0; $j < $num; $j++){
            $goods_data[$i][] = pg_fetch_result($res, $j, 0);
        }
    }

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($goods_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;

}


#2010-05-12 hashimoto-y
$display_flg = true;
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
$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
// ���������(�إå���������)
$sql  = "SELECT \n";
$sql .= "   COUNT(t_goods_info.goods_id) \n";
$sql .= "FROM \n";
$sql .= "   t_goods_info, \n";
$sql .= "   t_goods \n";
$sql .= "WHERE \n";
$sql .= "   t_goods_info.shop_id = $shop_id \n";
$sql .= "AND \n";
$sql .= "   t_goods_info.goods_id = t_goods.goods_id \n";
$sql .= "AND \n";
$sql .= "   t_goods.compose_flg = 'f' \n";
$sql .= "AND \n";
$sql .= "   t_goods.accept_flg = '1' \n";
$sql .= "AND \n";
$sql .= "   ( \n";
if ($group_kind == "2"){
$sql .= "       t_goods.state IN ('1', '3') \n";
$sql .= "       OR \n";
$sql .="        (t_goods.state = '2' AND t_goods.shop_id = $shop_id) \n";
}else{
$sql .= "       t_goods.state = '1' \n";
$sql .= "       OR \n";
$sql .= "       t_goods.shop_id = $shop_id \n";
}
$sql .= "    ) \n";
$sql .= "AND \n";
$sql .= "   length(t_goods.goods_cd) = 8 \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$t_count = pg_fetch_result($res, 0, 0);

// ���������(�إå���������)
$sql  = "SELECT \n";
$sql .= "   COUNT(t_goods_info.goods_id) \n";
$sql .= "FROM \n";
$sql .= "   t_goods_info \n";
$sql .= "   INNER JOIN t_goods ON  t_goods_info.goods_id = t_goods.goods_id \n";
$sql .="                       AND t_goods_info.shop_id = $shop_id \n";
$sql .= "WHERE \n";
$sql .= ($group_kind == "2") ? "   t_goods.state IN ('1', '3') \n" : "   t_goods.state = '1' \n";
$sql .= "AND \n";
$sql .= "   t_goods.accept_flg = '1' \n";
$sql .= "AND \n";
$sql .= "   t_goods.compose_flg = 'f' \n";
$sql .= "AND \n";
$sql .= "   length(t_goods.goods_cd) = 8 \n";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$dealing_count = pg_fetch_result($res, 0, 0);

// °����ʬ�̷��
for ($i = 1; $i <= 5; $i++){
    $sql  = "SELECT \n";
    $sql .= "   COUNT(t_goods.goods_id) \n";
    $sql .= "FROM \n";
    $sql .= "   t_goods \n";
    $sql .= "   INNER JOIN t_goods_info ON t_goods.goods_id = t_goods_info.goods_id \n";
    $sql .= "   INNER JOIN t_g_goods    ON t_goods.g_goods_id = t_g_goods.g_goods_id \n";
    $sql .= "   INNER JOIN t_product    ON t_goods.product_id = t_product.product_id \n";
	$sql .= "   INNER JOIN t_g_product  ON t_goods.g_product_id = t_g_product.g_product_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_goods.attri_div = '$i' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.accept_flg = '1' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods_info.shop_id = $shop_id \n";
    $sql .= $where_sql;
    $sql .= ";";
    $res = Db_Query($db_con, $sql);
    $attri_div_num[] = pg_fetch_result($res, 0, 0);
}

$page_title .= "(ͭ��".$dealing_count."��/��".$t_count."��)";
$page_title .= Print_H_Link_Btn($form, $ary_h_btn_list);
$page_header = Create_Header($page_title);


/****************************/
// �ڡ�������
/****************************/
$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);

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
    "match_count"   => "$match_count",
    "html_page"     => "$html_page",
    "order_msg"     => "$order_msg",
    "html_page2"    => "$html_page2",
    "url"           => ALBUM_DIR,
    "display_num"   => "$display_num",
    "display_flg"   => "$display_flg"
));

$smarty->assign("attri_div",$attri_div_num);
$smarty->assign("page_data",$goods_data);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>