<?php
/********************
 * ȯ�����ٹ�ꥹ��
 *
 *
 * �ѹ�����
 *    2006/07/06 (kaji)
 *      ��shop_gid��ʤ���
 *    2006/07/26 (watanabe-k)
 *     �����ʤ���о���ѹ�
 ********************/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2006/10/13  06-007        watanabe-k  ȯ�����ٹ�ꥹ�Ȥ�SQL���顼��ȯ������Х��ν��� 
 *   2006/12/06                watanabe-k  SQL����
 *  2007-04-04                  fukuda      ����������������ɲ�
 *  2009/10/12                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *  2010/05/12   Rev.1.5        hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
 *   2016/01/22                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б� 
 */

$page_title = "ȯ�����ٹ�ꥹ��";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

//HTML_QuickForm�����
//$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);
//$form->registerRule("check_flg", "function", "Check_Flg");

// DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_designated_date"  => "7",
    "form_client"           => array("cd1" => "", "cd2" => ""),
    "form_supplier_name"    => "",
    "form_g_goods"          => "",
    "form_goods_cd"         => "",
    "form_goods_name"       => "",
);

// �����ܻ����������������ե���������
$ary_pass_list = array(
    "order_button_flg"      => "",  
);

// �����������
Restore_Filter2($form, "ord", "form_show_button", $ary_form_list, $ary_pass_list);


/****************************/
// �����ѿ�
/****************************/
$shop_id  = $_SESSION["client_id"];


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);

$designated_date    = "7";
$match_count        = "0";


/****************************/
// �ե�����ѡ������
/****************************/
// �вٲ�ǽ��
$form->addElement("text", "form_designated_date", "",
    "size=\"4\" maxLength=\"4\" style=\"text-align: right; $g_form_style\" $g_form_option"
);

// �����襳����
/*
$form->addElement("text", "form_supplier_cd", "",
    "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" $g_form_option"
);
*/
$obj    =   null;
$obj[]  =   $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\"
    class=\"ime_disabled\" $g_form_option
    onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"
");
$obj[] =    $form->createElement("static", "", "", "-");
$obj[] =    $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" class=\"ime_disabled\" $g_form_option");
$form->addGroup($obj, "form_client", "");

// ��ʻ�����
$form->addElement("text", "form_supplier_name", "", "size=\"34\" maxLength=\"15\" $g_form_option");

// �Ͷ�ʬ
$where  = " WHERE (t_g_goods.shop_id = $shop_id OR t_g_goods.public_flg = 't') ";
$select_value = Select_Get($conn,'g_goods', $where);
$form->addElement("select", "form_g_goods", "", $select_value, $g_form_option_select);

// ���ʥ�����
$form->addElement("text", "form_goods_cd", "",
    "size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option"
);

// ����̾
$form->addElement("text", "form_goods_name", "", "size=\"34\" maxLength=\"15\" $g_form_goods");

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// ȯ�����Ϥإܥ���
$form->addElement("button", "form_order_button", "ȯ�����Ϥ�",
    "onClick=\"javascript:Button_Submit('order_button_flg', '".$_SERVER["PHP_SELF"]."', 'true', this); \" $disabled"
);

// �����ե饰
$form->addElement("hidden", "order_button_flg");

// ���顼���å���
$form->addElement("text", "order_err1");


/*****************************/
// ɽ���ܥ��󲡲�����
/*****************************/

#2010-05-12 hashimoto-y
if($_POST["form_show_button"]=="ɽ����" || $_POST["order_button_flg"] == "true"){


if ($_POST["form_show_button"] != null){

    /****************************/
    // ���顼�����å�
    /****************************/
    // ���вٲ�ǽ��
    $form->addRule("form_designated_date", "�вٲ�ǽ����Ⱦ�ѿ����Τ����ϲ�ǽ�Ǥ���", "regex", "/^[0-9]+$/");

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

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $designated_date    = $_POST["form_designated_date"];
    $client_cd1         = $_POST["form_client"]["cd1"];
    $client_cd2         = $_POST["form_client"]["cd2"];
    $supplier_name      = $_POST["form_supplier_name"];
    $g_goods            = $_POST["form_g_goods"];
    $goods_cd           = $_POST["form_goods_cd"];
    $goods_name         = $_POST["form_goods_name"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    // �����襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_client.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �����襳���ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_client.client_cd2 LIKE '$client_cd2%' \n" : null;
    // ��ʻ�����
    $sql .= ($supplier_name != null) ? "AND t_client.client_name LIKE '%$supplier_name%' \n" : null;
    // �Ͷ�ʬ
    $sql .= ($g_goods != null) ? "AND t_g_goods.g_goods_id = $g_goods \n" : null;
    // ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_stock_total.goods_cd LIKE '$goods_cd%' \n" : null;
    // ����̾
    $sql .= ($goods_name != null) ? "AND t_stock_total.goods_name LIKE '%$goods_name%' \n" : null;

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;

}


/******************************/
// �����ǡ�������
/******************************/
if ($err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_client.client_name, \n";
    $sql .= "   t_g_goods.g_goods_name, \n";
    $sql .= "   t_stock_total.goods_cd, \n";
    $sql .= "   t_stock_total.goods_name, \n";
    $sql .= "   t_price.r_price, \n";
    $sql .= "   t_stock_total.goods_id, \n";
    $sql .= "   t_stock_total.rack_num, \n";
    $sql .= "   COALESCE(t_stock_total.order_num,0) AS order_num, \n";
    $sql .= "   COALESCE(t_stock_total.allowance_total, 0) AS allowance_total, \n";
    $sql .= "   t_goods_info.order_point \n";
    $sql .= "FROM \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_goods.g_goods_id, \n";
    $sql .= "           t_goods.goods_id, \n";
    $sql .= "           t_goods.goods_cd, \n";
    $sql .= "           t_goods.goods_name, \n";
    $sql .= "           t_goods.public_flg, \n";
    $sql .= "           t_stock.stock_num AS rack_num, \n";
    $sql .= "           t_stock_io.order_num AS order_num, \n";
    $sql .= "           t_allowance_io.allowance_io_num AS allowance_total \n";
    $sql .= "       FROM \n";
    $sql .= "           t_goods \n";
    // �߸˿�
    $sql .= "           LEFT JOIN \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   t_stock.goods_id, \n";
    $sql .= "                   SUM(t_stock.stock_num)AS stock_num, \n";
    $sql .= "                   SUM(t_stock.rstock_num)AS rstock_num \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_stock \n";
    $sql .= "                   INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id \n";
    $sql .= "               WHERE \n";
    $sql .= "                   t_stock.shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   t_ware.count_flg = 't' \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   t_stock.goods_id \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_stock \n";
    $sql .= "           ON t_goods.goods_id = t_stock.goods_id \n";
    // ȯ��Ŀ�
    $sql .= "           LEFT JOIN \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   t_stock_hand.goods_id, \n";
    $sql .= "                   SUM( \n";
    $sql .= "                       CASE t_stock_hand.io_div \n";
    $sql .= "                           WHEN '1' THEN t_stock_hand.num *  1 \n";
    $sql .= "                           WHEN '2' THEN t_stock_hand.num * -1 \n";
    $sql .= "                       END \n";
    $sql .= "                   ) \n";
    $sql .= "                   AS order_num \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_stock_hand \n";
    $sql .= "                   INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id \n";
    $sql .= "               WHERE \n";
    $sql .= "                   t_stock_hand.work_div = '3' \n";
    $sql .= "               AND \n";
    $sql .= "                   t_stock_hand.shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   t_ware.count_flg = 't' \n";
    $sql .= "               AND \n";
    $sql .= "                   t_stock_hand.work_day <= (CURRENT_DATE + $designated_date) \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   t_stock_hand.goods_id \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_stock_io \n";
    $sql .= "           ON t_goods.goods_id = t_stock_io.goods_id \n";
    // ������
    $sql .= "           LEFT JOIN\n";
    $sql .= "           ( \n";
    $sql .= "               SELECT t_stock_hand.goods_id,\n";
    $sql .= "                   SUM( \n";
    $sql .= "                       CASE t_stock_hand.io_div \n";
    $sql .= "                           WHEN '1' THEN t_stock_hand.num * -1 \n";
    $sql .= "                           WHEN '2' THEN t_stock_hand.num *  1 \n";
    $sql .= "                       END \n";
    $sql .= "                   ) \n";
    $sql .= "                   AS allowance_io_num \n";
    $sql .= "               FROM\n";
    $sql .= "                   t_stock_hand \n";
    $sql .= "                   INNER JOIN t_ware ON t_stock_hand.ware_id = t_ware.ware_id \n";
    $sql .= "               WHERE \n";
    $sql .= "                   t_stock_hand.work_div = '1' \n";
    $sql .= "               AND \n";
    $sql .= "                   t_stock_hand.shop_id = $shop_id \n";
    $sql .= "               AND \n";
    $sql .= "                   t_ware.count_flg = 't'\n";
    $sql .= "               AND \n";
    $sql .= "                   t_stock_hand.work_day <= (CURRENT_DATE + $designated_date) \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   t_stock_hand.goods_id \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_allowance_io \n";
    $sql .= "           ON t_goods.goods_id = t_allowance_io.goods_id \n";
    #2009-10-12 hashimoto-y
    $sql .= "           INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

    $sql .= "       WHERE \n";
    #2009-10-12 hashimoto-y
    #$sql .= "           t_goods.stock_manage = '1' \n";
    $sql .= "           t_goods_info.stock_manage = '1' \n";
    $sql .= "       AND \n";
    $sql .= "           t_goods_info.shop_id = $shop_id ";

    $sql .= "       AND \n";
    $sql .= "           t_goods.accept_flg = '1' \n";
    $sql .= "       AND \n";
    $sql .= "           t_goods.state <> '2' \n";
    $sql .= "       AND \n";
    $sql .= "           t_goods.compose_flg = 'f' \n";
    $sql .= "       AND \n";
    $sql .= "           t_goods.no_change_flg = 'f' \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_stock_total \n";
    $sql .= "   INNER JOIN t_g_goods    ON t_stock_total.g_goods_id = t_g_goods.g_goods_id \n";
    $sql .= "   INNER JOIN t_price      ON t_stock_total.goods_id = t_price.goods_id \n";
    $sql .= "   INNER JOIN t_goods_info ON t_stock_total.goods_id = t_goods_info.goods_id \n";
    $sql .= "   LEFT  JOIN t_client     ON t_goods_info.supplier_id = t_client.client_id \n";
    // ��о��
    $sql .= "WHERE \n";
    $sql .= "   t_stock_total.public_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_price.rank_cd = '1' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods_info.shop_id = $shop_id \n";
    $sql .= "AND \n";
    $sql .= "   t_goods_info.head_fc_flg = 't' \n";
    $sql .= "AND \n";
    $sql .= "   t_goods_info.order_point > t_stock_total.rack_num \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_g_goods.g_goods_cd, \n";
    $sql .= "   t_stock_total.goods_cd \n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    $match_count = pg_num_rows($result);
    $page_data = Get_Data($result);

}

// �طʿ�����
for($i = 0; $i < count($page_data); $i++){

    if($i == 0){
        $tr[$i] = "Result1";
    // �оݹ��ܤ�NULL�ξ��
    }elseif($page_data[$i][0] == $page_data[$i-1][0]){
        $tr[$i] = $tr[$i-1];
    }else{
        if($tr[$i-1] == "Result1"){
            $tr[$i] = "Result2";
        }else{
            $tr[$i] = "Result1";
        }
    }
}

// ��ʣ�Ԥ�Ż���
for($i = 0; $i < count($page_data); $i++){
    for($j = 0; $j < count($page_data); $j++){
        if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
            $page_data[$j][0] = null;
        }
    }
}

// �ʥ�С��ե����ޥå�
for($i = 0; $i < count($page_data); $i++){
    $page_data[$i][4] = number_format($page_data[$i][4], 2);
}


/****************************/
//�����å��ܥå�������
/****************************/
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


/****************************/
// ȯ��ܥ��󲡲�����
/****************************/
if ($_POST["order_button_flg"] == "true" && $_POST["form_show_button"] == null){

    // ̤�����å���
    if (count($_POST["form_order_check"]) == 0){
        $form->setElementError("order_err1", "ȯ���뾦�ʤ����򤷤Ƥ���������");
        $err_flg = true;
    }

    // ���顼���ʤ����
    if ($err_flg != true){

        /****************************/
        //ȯ����ID�����
        /****************************/
        for($i = 0; $i < $match_count; $i++){
            if($_POST["form_order_check"][$i] == 1){
                $order_goods_id[] = $page_data[$i][5];
            }       
        }       
        //��ʣ��Ż���
        asort($order_goods_id);
        $order_goods_id = array_values(array_unique($order_goods_id));

        /****************************/
        //GET�����ͤ�����
        /****************************/
        $j = 0;
        for($i = 0; $i < count($order_goods_id); $i++){
            $get_goods_id .= "order_goods_id[".$j."]=".$order_goods_id[$i];
            if($i != count($order_goods_id)-1){
                $get_goods_id .= "&"; 
                $j = $j+1;
            }else{  
                break;  
            }
        }

        // ȯ�����Ϥإܥ��󲡲��ե饰�򥯥ꥢ
        $clear_hdn["order_button_flg"] = "";
        $form->setConstants($clear_hdn);

        $get_goods_id = $get_goods_id."&target_goods=".$_POST["form_target_goods"]."&designated_date=".$_POST["form_designated_date"];
        header("Location: ".HEAD_DIR."buy/1-3-102.php?$get_goods_id");

    }

}


#2010-05-12 hashimoto-y
$display_flg = true;
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
$page_menu = Create_Menu_h("buy", "1");

/****************************/
//���̥إå�������
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
	"html_page"     => "$html_page",
	"html_page2"    => "$html_page2",
    "match_count"   => "$match_count",
    "err_flg"       => "$err_flg",
    'display_flg'    => "$display_flg",
));

$smarty->assign("page_data", $page_data);
$smarty->assign("tr", $tr);

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
