<?php
/***************************
�ѹ�����
    �����å��ܥå������������forʬ��max��$result��$num�ѹ�
    2006/11/29  �в�ͽ������������������ʤ�ȯ������ɽ�������������ʤ�Τ���
***************************/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/11��06-015��������watanabe-k��ȯ���İ�����ȯ����λ�Υ����å��ܥå�����ɽ������ʤ��Х��ν���
 *   2006/10/18  06-012        watanabe-k��ǯ���������ϥ����å���ʸ�������Ϥ��줿��礬��θ����Ƥ��ʤ��Х��ν���
 */

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/13      03-087      ��          ������λ��ȯ���ǡ����ζ�����λ��Ԥ�ʤ��褦����
 *  2006/11/13      03-114      ��          �����å��ܥå�����ȯ���ǡ���ID��Ʊ����Ȥ�褦����
 *  2006/11/13      03-122      ��          ����ޤ����ѹ�����Ƥ���ȯ���ǡ����˶�����λ�Ǥ���Х�����
 *  2006/11/13      06-123      suzuki      ����̾���ά���ʤ��褦�˽���
 *  2006/11/29      scl_104-2.[FC]  suzuki  ʬǼ���������
 *  2006/12/06      ban_0039    suzuki      ���դ˥�������ɲ�
 *  2006/12/06                  watanabe-k  ������λ�ξ����ѹ�
 *  2007/02/06                  watanabe-k  ȯ������ɽ������
 *  2007-03-30                  fukuda      ����������������ɲ�
 *  2007-04-25                  watanabe-k  �ҸˤǤθ������ǽ��
 *  2009-10-16                  hashimoto-y �����ե������ȯ�����ν���ͤ���ͤ��ѹ�
 */

$page_title = "ȯ���İ���";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

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
    "form_display_num"      => "1",
    "form_client_branch"    => "",  
    "form_attach_branch"    => "",  
    "form_client"           => array("cd1" => "", "name" => ""),
    "form_c_staff"          => array("cd" => "", "select" => ""),  
    "form_part"             => "",  
    #2009-10-16 hashimoto-y
    #"form_ord_day"          => array(
    #    "sy" => date("Y"),          
    #    "sm" => date("m"),
    #    "sd" => "01",
    #    "ey" => date("Y"),
    #    "em" => date("m"),
    #    "ed" => date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")))
    #),
    "form_ord_day"          => array(
        "sy" => "",          
        "sm" => "",
        "sd" => "",
        "ey" => "",
        "em" => "",
        "ed" => ""
    ),
    "form_ord_no"           => array("s" => "", "e" => ""),
    "form_multi_staff"      => "",  
    "form_ware"             => "",  
    "form_hope_day"         => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
    "form_direct"           => "",
    "form_goods"            => array("cd" => "", "name" => ""),
    "form_arrival_day"      => array("sy" => "", "sm" => "", "sd" => "", "ey" => "", "em" => "", "ed" => ""),
);

// �����ܻ����������������ե���������
$ary_pass_list = array(
    "ord_comp_button_flg"  => "",
);

// �����������
Restore_Filter2($form, array("buy", "ord"), "show_button", $ary_form_list, $ary_pass_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];


/****************************/
// ���������
/****************************/
$limit          = null;     // LIMIT
$offset         = "0";      // OFFSET
$total_count    = "0";      // �����
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";    // ɽ���ڡ�����


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form_Ord($db_con, $form, $ary_form_list);

/* �⥸�塼���̥ե����� */
// ����
$obj    =   null;   
$obj[]  =&  $form->createElement("text", "cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");
$obj[]  =&  $form->createElement("static", "", "", " ");
$obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"30\" $g_form_option");
$form->addGroup($obj, "form_goods", "", "");

// �����в�ͽ�����ʳ��ϡ���λ��
Addelement_Date_Range($form, "form_arrival_day", "�����в�ͽ����", "-");

// �����ȥ��
$ary_sort_item = array(
    "sl_ord_day"        => "ȯ����",
    "sl_client_cd"      => "ȯ���襳����",
    "sl_client_name"    => "ȯ����̾",
    "sl_ord_no"         => "ȯ���ֹ�",
    "sl_hope_day"       => "��˾Ǽ��",
    "sl_arrival_day"    => "�����в�ͽ����",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_ord_day");

// ɽ���ܥ���
$form->addElement("submit", "show_button", "ɽ����");

//���ꥢ�ܥ���
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('".$_SERVER["PHP_SELF"]."');\"");

// ȯ����λ�ܥ���
$form->addElement("button", "ord_comp_button", "ȯ����λ",
    "onClick=\"javascript:Dialogue_2('ȯ����λ���ޤ���', '".$_SERVER["PHP_SELF"]."', 'true', 'ord_comp_button_flg')\" $disabled"
);

// ȯ���İ����ܥ���
$form->addElement("button", "ord_button", "ȯ���İ���", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// ���ϥܥ���
$form->addElement("button", "new_button", "������", "onClick=\"javascript:Referer('2-3-102.php')\"");

// �Ȳ�ܥ���
$form->addElement("button", "change_button", "�Ȳ��ѹ�", "onClick=\"javascript:Referer('2-3-104.php')\"");

// �����ե饰
$form->addElement("hidden", "ord_comp_button_flg");

// ���顼��å������������ѥե�����
$form->addElement("text", "err_non_buy");       // �����������äƤ��ʤ�
$form->addElement("text", "err_non_check");     // ������λ�����å���1�Ĥ�̵��
$form->addElement("text", "err_bought_slip");   // ��������λ���Ƥ���
$form->addElement("text", "err_non_reason");    // ��ͳ̤����
$form->addElement("text", "err_valid_data");    // �����Ǥʤ����ѹ�/������줿��ȯ���ǡ���


/******************************/
// ȯ����λ�ܥ��󲡲�����
/*****************************/
if($_POST["ord_comp_button_flg"]== "true"){

    $row_num        = $_POST["close_ord_d_id"];         // ȯ����λ�����å����ֹ�
    $reason         = $_POST["form_reason"];            // ������λ��ͳ
    $ord_err_flg    = false;

    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    //��ȯ����λ�����å��ܥå���
    //���ͤ�¸�ߥ����å�
    if($row_num == null){
        $form->setElementError("err_non_check", "ȯ����λ���뾦�ʤ����򤷤Ʋ�������");
        $ord_err_flg = true;
    }

    //ȯ���ǡ���ID����
    for($c=0; $c<count($_POST["hdn_ord_d_id"]); $c++){

        //�����å����դ��Ƥ���Ԥ�ȯ���ǡ���ID����ͳ�Ⱦ���ID�����
        if($row_num[$c]==1){

            // �����å����줿ȯ����������Ĵ�٤����ɼ���������򸵤ˡ�
            $sql  = "SELECT * FROM t_order_h \n";
            $sql .= "INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id \n";
            $sql .= "WHERE t_order_d.ord_d_id = ".$_POST["hdn_ord_d_id"][$c]." \n";
            $sql .= "AND t_order_h.enter_day = '".$_POST["hdn_enter_day"][$c]."' \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);

            // �����ʾ��Τ߰ʲ��ν�����Ԥ�
            if (pg_num_rows($res) > 0){

                // �����������������Ƥ��ʤ�ȯ���ǡ����ϡ�������λ�����ʤ�
                $sql  = "SELECT COUNT(ord_id) FROM t_buy_h \n";
                $sql .= "WHERE ord_id = (SELECT ord_id FROM t_order_d WHERE ord_d_id = ".$_POST["hdn_ord_d_id"][$c].") \n";
                $sql .= ";";
                $res = Db_Query($db_con, $sql);
                $num = pg_fetch_result($res, 0, 0);
                if ($num == 0){
                    $form->setElementError("err_non_buy", "������ԤäƤ��ʤ�ȯ���ϴ�λ�Ǥ��ޤ���");
                    $ord_err_flg = true;
                }

                // �����Ѥ�ȯ���Ĥ˻ĤäƤ��ʤ��ǡ����϶�����λ�����ʤ�
                $sql  = "SELECT * FROM t_order_d WHERE rest_flg = 'f' AND ord_d_id = ".$_POST["hdn_ord_d_id"][$c].";";
                $res  = Db_Query($db_con, $sql);
                if (pg_num_rows($res) > 0){
                    $form->setElementError("err_bought_slip", "��������λ���Ƥ���ȯ���ϴ�λ�Ǥ��ޤ���");
                    $ord_err_flg = true;
                }

                //��������λ��ͳ
                //��ɬ�����ϥ����å�
                if($reason[$c] == null){
                    $form->setElementError("err_non_reason", "ȯ����λ��ͳ ��ɬ�ܤǤ���");
                    $ord_err_flg = true;
                }

                $reason_data[] = $reason[$c];                   //��ͳ
                $ord_d_id[]    = $_POST["hdn_ord_d_id"][$c];    //ȯ��ID
                // ord_d_id�ξ���ID�����
                $sql = "SELECT goods_id FROM t_order_d WHERE ord_d_id = ".$_POST["hdn_ord_d_id"][$c].";";
                $res = Db_Query($db_con, $sql);
                $goods_id[]    = pg_fetch_result($res, 0, 0);

            // �����Ǥʤ���ȯ���ǡ������������Ƥ����ȯ���ǡ��������򤵤줿���
            }else{

                $form->setElementError("err_valid_data", "�ѹ��ޤ��Ϻ������Ƥ���ȯ���ǡ��������򤵤줿���ᡢ��λ�Ǥ��ޤ���");
                $ord_err_flg = true;

            }

        }

    }

    //���顼�κݤˤϡ�������Ԥ�ʤ�
    if($ord_err_flg != true){

        Db_Query($db_con, "BEGIN;");
        for($i=0;$i<count($ord_d_id);$i++){
            //ȯ���إå��ơ��֥�ξ���򹹿�
            $sql  = "UPDATE";
            $sql .= "    t_order_h ";
            $sql .= "SET";
            $sql .= "    finish_flg = 't', ";                     //������λ�ե饰
            $sql .= "    change_day = CURRENT_TIMESTAMP ";
            $sql .= "WHERE";
            $sql .= "    ord_id = (";
            $sql .= "        SELECT ";
            $sql .= "            ord_id ";
            $sql .= "        FROM ";
            $sql .= "            t_order_d ";
            $sql .= "        WHERE ";
            $sql .= "            ord_d_id = ".$ord_d_id[$i];
            $sql .= "        );";
            $result = Db_Query($db_con,$sql);
            if($result == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
            //ȯ���ǡ����ơ��֥�ξ���򹹿�
            $sql  = "UPDATE";
            $sql .= "    t_order_d ";
            $sql .= "SET";
            $sql .= "    rest_flg   = 'f', ";                   //ȯ���ĥե饰
            $sql .= "    finish_flg = 't', ";                   //������λ�ե饰
            $sql .= "    reason     = '".$reason_data[$i]."' "; //������λ��ͳ
            $sql .= "WHERE";
            $sql .= "   ord_d_id = ".$ord_d_id[$i];
            $sql .= ";";
            $result = Db_Query($db_con,$sql);
            if($result == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
            //�߸˼�ʧ�ơ��֥�ξ������Ͽ
            $sql  = "INSERT INTO";
            $sql .= "    t_stock_hand (";
            $sql .= "        goods_id,";              //����ID
            $sql .= "        enter_day,";             //������
            $sql .= "        work_day,";              //��ȼ»���
            $sql .= "        work_div,";              //��ȶ�ʬ
            $sql .= "        client_id,";             //������ID
            $sql .= "        ware_id,";               //�Ҹ�ID
            $sql .= "        io_div,";                //���и˶�ʬ
            $sql .= "        num,";                   //�Ŀ�
            $sql .= "        slip_no,";               //��ɼ�ֹ�
            $sql .= "        ord_d_id,";              //ȯ���ǡ���ID
            $sql .= "        staff_id,";              //��ȼ�
            $sql .= "        shop_id) ";              //����å׼���ID
            $sql .= "VALUES(";
            $sql .= "    (SELECT ";
            $sql .= "        goods_id ";
            $sql .= "    FROM ";
            $sql .= "        t_order_d ";
            $sql .= "    WHERE ";
            $sql .= "        ord_d_id = ".$ord_d_id[$i];
            $sql .= "    ),";
            $sql .= "    (SELECT ";
            $sql .= "        CURRENT_DATE";
            $sql .= "    ),";
            $sql .= "    (SELECT ";
            $sql .= "        CURRENT_DATE";
            $sql .= "    ),";
            $sql .= "    3,";
            $sql .= "    (SELECT ";
            $sql .= "        client_id ";
            $sql .= "    FROM ";
            $sql .= "        t_order_h ";
            $sql .= "    INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id ";
            $sql .= "    WHERE ";
            $sql .= "        t_order_d.ord_d_id = ".$ord_d_id[$i];
            $sql .= "    ),";
            $sql .= "    (SELECT ";
            $sql .= "        ware_id ";
            $sql .= "    FROM ";
            $sql .= "        t_order_h ";
            $sql .= "    INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id  ";
            $sql .= "    WHERE ";
            $sql .= "        t_order_d.ord_d_id = ".$ord_d_id[$i];
            $sql .= "    ),";
            $sql .= "    2,";
            $sql .= "    (SELECT ";
            $sql .= "        t_order_d.num - COALESCE(t_buy.buy_num,0) AS inventory_num ";
            $sql .= "    FROM ";
            $sql .= "        t_order_d ";
            $sql .= "    LEFT JOIN ";
            $sql .= "        (SELECT ";
            $sql .= "            ord_d_id,";
            $sql .= "            SUM(num) AS buy_num";
            $sql .= "        FROM ";
            $sql .= "            t_buy_d ";
            $sql .= "        GROUP BY ";
            $sql .= "            ord_d_id ";
            $sql .= "        )AS t_buy";
            $sql .= "    ON t_order_d.ord_d_id = t_buy.ord_d_id ";
            $sql .= "    WHERE ";
            $sql .= "        t_order_d.ord_d_id = ".$ord_d_id[$i];
            $sql .= "    ),";
            $sql .= "    (SELECT ";
            $sql .= "        ord_no ";
            $sql .= "    FROM ";
            $sql .= "        t_order_h ";
            $sql .= "    INNER JOIN t_order_d ON t_order_h.ord_id = t_order_d.ord_id ";
            $sql .= "    WHERE ";
            $sql .= "        t_order_d.ord_d_id = ".$ord_d_id[$i];
            $sql .= "    ),";
            $sql .= "    ".$ord_d_id[$i].", ";
            $sql .= "    ".$staff_id.", ";
            $sql .= "    ".$shop_id;
            $sql .= ");";
            $result = Db_Query($db_con,$sql);
            if($result == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
        }
        //ȯ���إå��ơ��֥�ξ���򹹿�
        $sql  = "SELECT ";
        $sql .= "DISTINCT ";
        $sql .= "    rest_flg ";
        $sql .= "FROM";
        $sql .= "    t_order_d ";                         //��������
        $sql .= "WHERE";
        $sql .= "    ord_id = (";
        $sql .= "        SELECT ";
        $sql .= "            ord_id ";
        $sql .= "        FROM ";
        $sql .= "            t_order_d ";
        $sql .= "        WHERE ";
        $sql .= "            ord_d_id = ".$ord_d_id[0];
        $sql .= "        );";
        $result = Db_Query($db_con,$sql);
        //���Ƥ�ȯ���ǡ�����ȯ���ĥե饰��false��
        $rest_count = pg_num_rows($result);
        if($rest_count==1){
            //ȯ���ĥե饰��false����¸�ߤ��ʤ�
            $ps_stat = "    ps_stat = '3' ";             //���������ʽ�����λ��
        }else{
            //ȯ���ĥե饰��true��false��¸�ߤ���
            $ps_stat = "    ps_stat = '2' ";             //���������ʽ������
        }

        //ȯ���إå��ơ��֥�ξ���򹹿�
        $sql  = "UPDATE";
        $sql .= "    t_order_h ";
        $sql .= "SET";
        $sql .= $ps_stat;
        $sql .= "WHERE";
        $sql .= "    ord_id = (";
        $sql .= "        SELECT ";
        $sql .= "            ord_id ";
        $sql .= "        FROM ";
        $sql .= "            t_order_d ";
        $sql .= "        WHERE ";
        $sql .= "            ord_d_id = ".$ord_d_id[0];
        $sql .= "        );";
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");
        //����
        header("Location: 2-3-106.php?search=1");

    // ȯ����λ�ܥ��󲡲����˥��顼��������
    }else{

        // ȯ����λ�����å��ܥå����ȴ�λ��ͳ��POST��ե�������䴰
        for ($i=0; $i<$total_count; $i++){
            if ($_POST["close_ord_d_id"][$i] == 1){
                $set_close_check["close_ord_d_id"][$i] = "1";
                $form->setConstants($set_close_check);
            }
            if ($_POST["form_reason"][$i] != null){
                $set_reason["form_reason"][$i] = $_POST["form_reason"][$i];
                $form->setConstants($set_reason);
            }
        }

    }

    //ȯ����λ�ե饰������
    $Cons_date = array(
        "ord_comp_button_flg" => ""
    );
    $form->setConstants($Cons_date);

    // hidden��ȯ���ǡ���ID����ɼ���������򥯥ꥢ
    if (count($_POST["hdn_ord_d_id"]) > 0){
    foreach ($_POST["hdn_ord_d_id"] as $key => $value){
        $clear_hdn_ord_d_id["hdn_ord_d_id"][$key]   = "";   
        $clear_hdn_ord_d_id["hdn_enter_day"][$key]  = "";
    }
    }

    $post_flg = true;

}


/****************************/
// ɽ���ܥ��󲡲�����
/****************************/
if ($_POST["show_button"] != null){

    // ����POST�ǡ�����0���
    $_POST["form_ord_day"]      = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    /****************************/
    // ���顼�����å�
    /****************************/
    // ��ȯ��ô����
    $err_msg = "ȯ��ô���� �Ͽ��ͤΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Num($form, "form_c_staff", $err_msg);

    // ��ȯ����
    // ���顼��å�����
    $err_msg = "ȯ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_ord_day", $err_msg);

    // ��ȯ��ô���ԡ�ʣ�������
    // ���顼��å�����
    $err_msg = "ȯ��ô���ԡ�ʣ������� �Ͽ��ͤȡ�,�פΤ����ϲ�ǽ�Ǥ���";
    Err_Chk_Delimited($form, "form_multi_staff", $err_msg);

    // ����˾Ǽ��
    // ���顼��å�����
    $err_msg = "��˾Ǽ�� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_hope_day", $err_msg);

    // �������в�ͽ����
    // ���顼��å�����
    $err_msg = "�����в�ͽ���� �����դ������ǤϤ���ޤ���";
    Err_Chk_Date($form, "form_arrival_day", $err_msg);

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
if (($_POST["show_button"] != null && $err_flg != true) || ($_POST != null && $_POST["show_button"] == null)){ 

    // ����POST�ǡ�����0���
    $_POST["form_ord_day"]      = Str_Pad_Date($_POST["form_ord_day"]);
    $_POST["form_hope_day"]     = Str_Pad_Date($_POST["form_hope_day"]);
    $_POST["form_arrival_day"]  = Str_Pad_Date($_POST["form_arrival_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $display_num    = $_POST["form_display_num"];
    $client_branch  = $_POST["form_client_branch"];
    $attach_branch  = $_POST["form_attach_branch"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_name    = $_POST["form_client"]["name"];
    $c_staff_cd     = $_POST["form_c_staff"]["cd"];
    $c_staff_select = $_POST["form_c_staff"]["select"];
    $part           = $_POST["form_part"];
    $ord_day_sy     = $_POST["form_ord_day"]["sy"];
    $ord_day_sm     = $_POST["form_ord_day"]["sm"];
    $ord_day_sd     = $_POST["form_ord_day"]["sd"];
    $ord_day_ey     = $_POST["form_ord_day"]["ey"];
    $ord_day_em     = $_POST["form_ord_day"]["em"];
    $ord_day_ed     = $_POST["form_ord_day"]["ed"];
    $hope_day_sy    = $_POST["form_hope_day"]["sy"];
    $hope_day_sm    = $_POST["form_hope_day"]["sm"];
    $hope_day_sd    = $_POST["form_hope_day"]["sd"];
    $hope_day_ey    = $_POST["form_hope_day"]["ey"];
    $hope_day_em    = $_POST["form_hope_day"]["em"];
    $hope_day_ed    = $_POST["form_hope_day"]["ed"];
    $direct_name    = $_POST["form_direct"];
    $ord_no_s       = $_POST["form_ord_no"]["s"];
    $ord_no_e       = $_POST["form_ord_no"]["e"];
    $multi_staff    = $_POST["form_multi_staff"];
    $ware           = $_POST["form_ware"];
    $goods_cd       = $_POST["form_goods"]["cd"];
    $goods_name     = $_POST["form_goods"]["name"];
    $arrival_day_sy = $_POST["form_arrival_day"]["sy"];
    $arrival_day_sm = $_POST["form_arrival_day"]["sm"];
    $arrival_day_sd = $_POST["form_arrival_day"]["sd"];
    $arrival_day_ey = $_POST["form_arrival_day"]["ey"];
    $arrival_day_em = $_POST["form_arrival_day"]["em"];
    $arrival_day_ed = $_POST["form_arrival_day"]["ed"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql = null;

    // �ܵ�ô����Ź
    if ($client_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_order_h.client_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "       WHERE \n";
        $sql .= "           charge_branch_id = $client_branch \n";
        $sql .= "   ) \n";
    }
    // ��°�ܻ�Ź
    if ($attach_branch != null){
        $sql .= "AND \n";
        $sql .= "   t_order_h.c_staff_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_attach.staff_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_attach \n";
        $sql .= "           INNER JOIN t_part ON t_attach.part_id = t_part.part_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_part.branch_id = $attach_branch \n";
        $sql .= "   ) \n";
    }
    // ȯ���襳���ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_order_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // ȯ����̾
    if ($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
    // ȯ��ô���ԥ�����
    $sql .= ($c_staff_cd != null) ? "AND t_staff.charge_cd = '$c_staff_cd' \n" : null;
    // ȯ��ô���ԥ��쥯��
    $sql .= ($c_staff_select != null) ? "AND t_staff.staff_id = $c_staff_select \n" : null;
    // ����
    $sql .= ($part != null) ? "AND t_attach.part_id = $part \n" : null;
    // ȯ�����ʳ��ϡ�
    $ord_day_s = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;
    $sql .= ($ord_day_s != "--") ? "AND t_order_h.ord_time >= '$ord_day_s 00:00:00' \n" : null;
    // ȯ�����ʽ�λ��
    $ord_day_e = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;
    $sql .= ($ord_day_e != "--") ? "AND t_order_h.ord_time <= '$ord_day_e 23:59:59' \n" : null;
    // ȯ���ֹ�ʳ��ϡ�
    $sql .= ($ord_no_s != null) ? "AND t_order_h.ord_no >= '".str_pad($ord_no_s, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ȯ���ֹ�ʽ�λ��
    $sql .= ($ord_no_e != null) ? "AND t_order_h.ord_no <= '".str_pad($ord_no_e, 8, 0, STR_PAD_LEFT)."' \n" : null;
    // ȯ��ô���ԡ�ʣ�������
    if ($multi_staff != null){
        $ary_multi_staff = explode(",", $multi_staff);
        $sql .= "AND \n";
        $sql .= "   t_staff.charge_cd IN (";
        foreach ($ary_multi_staff as $key => $value){
            $sql .= "'".trim($value)."'";
            $sql .= ($key+1 < count($ary_multi_staff)) ? ", " : ") \n";
        }
    }
    // �Ҹ�
    $sql .= ($ware != null) ? "AND t_order_h.ware_id = $ware \n" : null;
    // ��˾Ǽ���ʳ��ϡ�
    $hope_day_s = $hope_day_sy."-".$hope_day_sm."-".$hope_day_sd;
    $sql .= ($hope_day_s != "--") ? "AND '$hope_day_s' <= t_order_h.hope_day \n" : null;
    // ��˾Ǽ���ʽ�λ��
    $hope_day_e = $hope_day_ey."-".$hope_day_em."-".$hope_day_ed;
    $sql .= ($hope_day_e != "--") ? "AND t_order_h.hope_day <= '$hope_day_e' \n" : null;
    // ľ����
    if ($direct_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_order_h.direct_name  LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_name2 LIKE '%$direct_name%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_order_h.direct_cname LIKE '%$direct_name%' \n";
        $sql .= "   ) \n";
    }
    // ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_order_d.goods_cd LIKE '$goods_cd%' \n" : null;
    // ����̾
    $sql .= ($goods_name != null) ? "AND t_order_d.goods_name LIKE '%$goods_name%' \n" : null;
    // �����в�ͽ�����ʳ��ϡ�
    $arrival_day_s = $arrival_day_sy."-".$arrival_day_sm."-".$arrival_day_sd;
    $sql .= ($arrival_day_s != "--") ? "AND '$arrival_day_s' <= t_aorder_h.arrival_day \n" : null;
    // �����в�ͽ�����ʽ�λ��
    $arrival_day_e = $arrival_day_ey."-".$arrival_day_em."-".$arrival_day_ed;
    $sql .= ($arrival_day_e != "--") ? "AND t_aorder_h.arrival_day <= '$arrival_day_e' \n" : null;

    // �ѿ��ͤ��ؤ�
    $where_sql = $sql;


    $sql = null;

    // �����Ƚ�
    switch ($_POST["hdn_sort_col"]){
        // ȯ����
        case "sl_ord_day":
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_d.line, \n";
            $sql .= "   t_aorder.arrival_day \n";
            break;
        // ȯ���襳����
        case "sl_client_cd":
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_d.line, \n";
            $sql .= "   t_aorder.arrival_day \n";
            break;
        // ȯ����̾
        case "sl_client_name":
            $sql .= "   t_order_h.client_cname, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_d.line, \n";
            $sql .= "   t_aorder.arrival_day \n";
            break;
        // ȯ���ֹ�
        case "sl_ord_no":
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_d.line, \n";
            $sql .= "   t_aorder.arrival_day \n";
            break;
        // ��˾Ǽ��
        case "sl_hope_day":
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_d.line, \n";
            $sql .= "   t_aorder.arrival_day \n";
            break;
        // �����в�ͽ����
        case "sl_arrival_day":
            $sql .= "   t_aorder.arrival_day, \n";
            $sql .= "   t_order_h.ord_time, \n";
            $sql .= "   t_order_h.client_cd1, \n";
            $sql .= "   t_order_h.ord_no, \n";
            $sql .= "   t_order_h.hope_day, \n";
            $sql .= "   t_order_d.line \n";
            break;
    }

    // �ѿ��ͤ��ؤ�
    $order_sql = $sql;

}


/****************************/
// ���Ϥ�����ɼ��ꥹ�ȥ��å�
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_order_h.ord_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_order_d  ON  t_order_h.ord_id = t_order_d.ord_id \n";
    $sql .= "                         AND t_order_d.rest_flg = 't' \n";
    $sql .= "   INNER JOIN t_goods    ON  t_order_d.goods_id = t_goods.goods_id \n";
    $sql .= "   LEFT  JOIN t_aorder_h ON  t_order_h.ord_id = t_aorder_h.fc_ord_id \n";
    $sql .= "                         AND t_aorder_h.shop_id = 1 \n";
    $sql .= "   LEFT  JOIN t_aorder_d ON  t_aorder_h.aord_id = t_aorder_d.aord_id \n";
    $sql .= "                         AND t_aorder_d.goods_id = t_order_d.goods_id \n";
    $sql .= "   INNER JOIN t_client   ON  t_order_h.client_id = t_client.client_id \n";
    $sql .= "   INNER JOIN t_attach   ON  t_order_h.c_staff_id = t_attach.staff_id \n";
    $sql .= "                         AND t_attach.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "   INNER JOIN t_staff    ON  t_order_h.c_staff_id = t_staff.staff_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_order_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   (t_order_h.ord_stat IN ('1', '2') OR t_order_h.ord_stat IS NULL) \n";
    $sql .= $where_sql;
    $sql .= "GROUP BY \n";
    $sql .= "   t_order_h.ord_id \n";

    // ���������
    $res            = Db_Query($db_con, $sql.";");
    $total_count    = pg_num_rows($res);

    // ɽ�����
    switch ($display_num){
        case "1":
            $limit = $total_count;
            break;  
        case "2":
            $limit = "100";
            break;  
    }       

    // �������ϰ���
    $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

    // �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
    if($page_count != null){
        // �Ժ����total_count��offset�δط������줿���
        if ($total_count <= $offset){
            // ���ե��åȤ����������
            $offset     = $offset - $limit; 
            // ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
            $page_count = $page_count - 1;
            // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
            $page_count = ($total_count <= $display_num) ? null : $page_count;
        }       
    }else{  
        $offset = 0;
    }       

    // �ڡ�����ǡ�������
    $limit_offset   = ($limit != null) ? "LIMIT $limit OFFSET $offset " : null; 
    $res            = Db_Query($db_con, $sql.$limit_offset.";");
    $match_count    = pg_num_rows($res);
    $ary_list_data  = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ȯ���ĥǡ�������SQL
/****************************/
if ($match_count > 0 && $post_flg == true && $err_flg != true){

    $sql  = "SELECT \n";
    $sql .= "   t_order_h.client_cd1, \n";                                          // �����襳����
    $sql .= "   t_order_h.client_cname, \n";                                        // ������̾
    $sql .= "   t_order_h.ord_id, \n";                                              // ȯ��ID
    $sql .= "   t_order_h.ord_no, \n";                                              // ȯ���ֹ�
    $sql .= "   to_char(t_order_h.ord_time, 'yyyy-mm-dd'), \n";                     // ȯ����
    //$sql .= "   t_order_h.arrival_day AS ord_arr_day, \n";                          // ����ͽ����
    $sql .= "   t_order_h.hope_day, \n";                                            // ��˾Ǽ��
    $sql .= "   t_aorder.arrival_day AS aord_arr_day, \n";                          // �в�ͽ����
    $sql .= "   t_order_d.goods_cd, \n";                                            // ���ʥ�����
    $sql .= "   t_order_d.goods_name, \n";                                          // ����̾
    $sql .= "   t_order_d.num                               AS order_num, \n";      // ȯ����
    $sql .= "   COALESCE(t_buy.buy_num,0)                   AS buy_num, \n";        // ������
    $sql .= "   t_order_d.num - COALESCE(t_buy.buy_num,0)   AS inventory_num,\n";   // ȯ����
    $sql .= "   t_order_h.ware_name, \n";                                           // �Ҹ�̾
    $sql .= "   t_order_d.ord_d_id, \n";                                            // ȯ���ǡ���ID
    $sql .= "   t_order_h.ord_stat, \n";                                            // ȯ������
    $sql .= "   t_order_h.ps_stat, \n";                                             // ��������
    $sql .= "   t_order_d.goods_id, \n";                                            // ����ID
    $sql .= "   to_char(t_order_h.send_date, 'hh24:mi'), \n";
    $sql .= "   to_char(t_order_h.ord_time, 'hh24:mi'), \n";
    $sql .= "   t_order_h.enter_day \n";
    $sql .= "FROM \n";
    $sql .= "   t_order_h \n";
    $sql .= "   INNER JOIN t_order_d ON  t_order_h.ord_id = t_order_d.ord_id \n";
    $sql .= "                        AND t_order_d.rest_flg = 't' \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           ord_d_id, \n";
    $sql .= "           SUM(t_buy_d.num) AS buy_num \n";
    $sql .= "       FROM \n";
    $sql .= "           t_buy_h \n";
    $sql .= "           INNER JOIN t_buy_d ON t_buy_h.buy_id = t_buy_d.buy_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_buy_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           ord_d_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_buy \n";
    $sql .= "   ON t_order_d.ord_d_id = t_buy.ord_d_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_aorder_h.fc_ord_id, \n";
    $sql .= "           t_aorder_h.arrival_day, \n";
    $sql .= "           t_aorder_d.goods_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_aorder_h \n";
    $sql .= "           INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id \n";
    $sql .= "       WHERE \n";
    $sql .= "           t_aorder_h.shop_id = 1 \n";
    $sql .= "       GROUP BY \n";
    $sql .= "           t_aorder_h.fc_ord_id, \n";
    $sql .= "           t_aorder_h.arrival_day, \n";
    $sql .= "           t_aorder_d.goods_id \n";
    $sql .= "   ) \n";
    $sql .= "   AS t_aorder \n";
    $sql .= "   ON  t_order_h.ord_id = t_aorder.fc_ord_id \n";
    $sql .= "   AND t_aorder.goods_id = t_order_d.goods_id \n";
    $sql .= "   INNER JOIN t_client ON t_order_h.client_id = t_client.client_id \n";
    $sql .= "   INNER JOIN t_ware   ON t_order_h.ware_id = t_ware.ware_id \n";
    $sql .= "   INNER JOIN t_goods  ON t_order_d.goods_id = t_goods.goods_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_order_h.ord_id IN (";
    foreach ($ary_list_data as $key => $value){
    $sql .= $value["ord_id"];
    $sql .= ($key+1 < count($ary_list_data)) ? ", " : ") \n";
    }
    $sql .= "ORDER BY \n";
    $sql .= $order_sql;
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    // �ڡ�����ǡ�������
    $res        = Db_Query($db_con, $sql);
    $ary_data   = Get_Data($res, 2, "ASSOC");

}


/****************************/
// ɽ���ѥǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    /****************************/
    // ɽ���ѥǡ������� ���Σ�
    // �����в�ͽ������Ϣ��
    /****************************/
    // �ڡ�����ǡ����ǥ롼��
    if (count($ary_data) > 0){
        // 
        $count = 0;
        foreach ($ary_data as $key => $value){

            // �������λ��ȹԤ��ѿ�������ƻȤ��䤹�����Ƥ���
            $back = $ary_data[$key-1];
            $next = $ary_data[$key+1];

            // ���󻲾ȹԤ������в�ͽ��������
            $aord_arr_day .= $value["aord_arr_day"]."<br>";

            // �����в�ͽ������Ϣ��
            if (
                $value["ord_d_id"] == $next["ord_d_id"] &&
                $value["goods_cd"] == $next["goods_cd"]
            ){
                // Ϣ�����򥫥����
                $count++;
            }else{
                // ��礷�������в�ͽ������ǡ�������إ��å�
                $ary_data[$key-$count]["aord_arr_day_join"] = $aord_arr_day;
                // ���󻲾ȹԤ������в�ͽ�����򿷤����ѿ��إ��å�
                $aord_arr_day = null;
                // Ϣ�������������
                $count  = 0;
            }

        }
    }

    /****************************/
    // ɽ���ѥǡ������� ���Σ�
    // 
    /****************************/
    // No.�����
    $i = 0;
    // �Կ������
    $row = 0;
    // 
    $back_key = 1;
    // 
    $html_l = null;
    // �ڡ�����ǡ����ǥ롼��
    if (count($ary_data) > 0){
        foreach ($ary_data as $key => $value){

            // Ϣ�뤷�������в�ͽ���������Ǥ�������
            if (array_key_exists("aord_arr_day_join", $value)){

                // �������λ��ȹԤ��ѿ�������ƻȤ��䤹�����Ƥ���
                $back = $ary_data[$key-$back_key];
                $next = $ary_data[$key+1];

                // ��No.�ν�������
                // ����κǽ顢�ޤ�������Ⱥ����ȯ��ID���ۤʤ���
                if ($key == 0 || $back["ord_id"] != $value["ord_id"]){
                    $no             = ++$i;
                }else{
                    $no             = null;
                }
                // ��ȯ����
                // No.��������
                if ($no != null){
                    $ord_day        = substr($value["enter_day"], 0, 10)."<br>".$value["to_char"]."<br>";
                }else{
                    $ord_day        = null;
                }
                // ��ȯ����
                // No.��������
                if ($no != null){
                    $client         = $value["client_cd1"];
                    $client        .= "<br>";
                    $client        .= htmlspecialchars($value["client_cname"]);
                    $client        .= "<br>";
                }else{
                    $client         = null;
                }
                // ��ȯ���ֹ���
                // No.��������
                if ($no != null){
                    // ȯ�������ּ�áפޤ��ϡ�ȯ��������null�פ��Ľ���������̤�����פξ��
                    if ($value["ord_stat"] == "3" || ($value["ord_stat"] == null && $value["ps_stat"] == "1")){
                        $ord_no_link= "<a href=\"./2-3-102.php?ord_id=".$value["ord_id"]."\">".$value["ord_no"]."</a>";
                    }else{
                        $ord_no_link= "<a href=\"./2-3-103.php?ord_id=".$value["ord_id"]."\">".$value["ord_no"]."</a>";
                    }
                }else{
                    $ord_no_link    = null;
                }
/*
                // ������ͽ����
                // No.��������
                if ($no != null){
                    $ord_arr_day    = $value["ord_arr_day"];
                }else{
                    $ord_arr_day    = null;
                }
*/
                // ����˾Ǽ��
                // No.��������
                if ($no != null){
                    $hope_day       = $value["hope_day"];
                }else{
                    $hope_day       = null;
                }
                // �������в�ͽ����
                $aord_arr_day       = $value["aord_arr_day_join"];
                // ������
                $goods              = $value["goods_cd"]."<br>".htmlspecialchars($value["goods_name"])."<br>";
                // ��ȯ����
                $order_num          = number_format($value["order_num"]);
                // �����ٿ�
                $buy_num            = number_format($value["buy_num"]);
                // ��ȯ����
                $inventory_num      = number_format($value["inventory_num"]);
                // �������Ҹ�
                $ware_name          = htmlspecialchars($value["ware_name"]);
                // ���������
                // No.��������
                if ($no != null){
                    $buy_link       = "<a href=\"./2-3-201.php?ord_id=".$value["ord_id"]."\">����</a>";
                }else{
                    $buy_link       = null;
                }
                // ��ȯ����λ��ͳ
                $form->addElement("checkbox", "close_ord_d_id[$row]", "");
                $form->addElement("text", "form_reason[$row]", "", "size=\"22\" maxLength=\"15\" $g_form_option");
                // ���Կ�css
                if ($no != null){
                    $css            = (bcmod($no, 2) == 0) ? "Result2" : "Result1";
                }else{
                    $css            = $css;
                }

                // ���ޤȤ�
                // �Կ�css
                $disp_data[$row]["css"]             = $css;
                // No.
                $disp_data[$row]["no"]              = $no;
                // ȯ����
                $disp_data[$row]["ord_day"]         = $ord_day;
                // ȯ����
                $disp_data[$row]["client"]          = $client;
                // ȯ���ֹ���
                $disp_data[$row]["ord_no_link"]     = $ord_no_link;
/*
                // ����ͽ����
                $disp_data[$row]["ord_arr_day"]     = $ord_arr_day;
*/
                // ��˾Ǽ��
                $disp_data[$row]["hope_day"]        = $hope_day;
                // �����в�ͽ����
                $disp_data[$row]["aord_arr_day"]    = $aord_arr_day;
                // ����
                $disp_data[$row]["goods"]           = $goods;
                // ȯ����
                $disp_data[$row]["order_num"]       = $order_num;
                // ������
                $disp_data[$row]["buy_num"]         = $buy_num;
                // ȯ����
                $disp_data[$row]["inventory_num"]   = $inventory_num;
                // �����Ҹ�
                $disp_data[$row]["ware_name"]       = $ware_name;
                // �������
                $disp_data[$row]["buy_link"]        = $buy_link;

                // ȯ����λ��ͳ�ν����
                $set_delete_data["close_ord_d_id"][$row]    = "";
                $set_delete_data["form_reason"][$row]       = "";

                // �ƹԤ�ȯ��ID���������hidden������ʶ�����λ������ȯ��ID��Ƚ�ꤵ���뤿���
                // �ƹԤ���ɼ�����������������hidden������ʶ�����λ������ȯ��ID��Ƚ�ꤵ���뤿���
                $form->addElement("hidden", "hdn_ord_d_id[$row]", null, null);
                $form->addElement("hidden", "hdn_enter_day[$row]", null, null);

                // ��������hidden��ȯ��ID�򥻥å�
                $set_hdn_ord_d_id["hdn_ord_d_id[$row]"]   = $value["ord_d_id"];
                $set_hdn_ord_d_id["hdn_enter_day[$row]"]  = $value["enter_day"];

                // ����html����
                $html_l .= "    <tr class=\"$css\">\n";
                $html_l .= "        <td align=\"right\">$no</td>\n";
                $html_l .= "        <td align=\"center\">$ord_day</td>\n";
                $html_l .= "        <td>$client</td>\n";
                $html_l .= "        <td align=\"center\">$ord_no_link</td>\n";
                //$html_l .= "        <td align=\"center\">$ord_arr_day</td>\n";
                $html_l .= "        <td align=\"center\">$hope_day</td>\n";
                $html_l .= "        <td align=\"center\">$aord_arr_day</td>\n";
                $html_l .= "        <td>$goods</td>\n";
                $html_l .= "        <td align=\"right\">$order_num</td>\n";
                $html_l .= "        <td align=\"right\">$buy_num</td>\n";
                $html_l .= "        <td align=\"right\">$inventory_num</td>\n";
                $html_l .= "        <td>$ware_name</td>\n";
                $html_l .= "        <td align=\"center\">$buy_link</td>\n";
                $html_l .= "        <td align=\"center\">\n";
                $html_l .= "            ".$form->_elements[$form->_elementIndex["close_ord_d_id[$row]"]]->toHtml();
                $html_l .= "            ��ͳ��".$form->_elements[$form->_elementIndex["form_reason[$row]"]]->toHtml()."<br>";
                $html_l .= "        </td>\n";
                $html_l .= "    </tr>\n";

                // �Կ��û�
                $row++;

                // 
                $back_key = 1;

            // �����в�ͽ���������Ǥ��ʤ����
            }else{
                // 
                $back_key++;
            }

        }

    }

    // ȯ����λ�ʥ����å���
    $form->addElement("checkbox", "form_ord_comp_check", "", "ȯ����λ",
        "onClick=\"javascript:All_check('form_ord_comp_check', 'close_ord_d_id', $row);\""
    );

    // ȯ����λ����ͳ�����
    $set_delete_data["form_ord_comp_check"] = "";

    // setConstants
    $form->setConstants($set_delete_data);
    $form->setConstants($set_hdn_ord_d_id);

}


/****************************/
// HTML�����ʸ�������
/****************************/
// ���̸����ơ��֥�
$html_s .= Search_Table_Ord($form);
$html_s .= "<br style=\"font-size: 4px;\">\n";
// �⥸�塼����̸����ơ��֥룱
$html_s .= "\n";
$html_s .= "<table class=\"Table_Search\">\n";
$html_s .= "    <col width=\" 80px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"300px\">\n";
$html_s .= "    <col width=\"120px\" style=\"font-weight: bold;\">\n";
$html_s .= "    <col width=\"230px\">\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td class=\"Td_Search_3\">����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_goods"]]->toHtml()."</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">�����в�ͽ����</td>\n";
$html_s .= "        <td class=\"Td_Search_3\">".$form->_elements[$form->_elementIndex["form_arrival_day"]]->toHtml()."</td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>";
$html_s .= "\n";

$html_page  = Html_Page2($total_count, $page_count, 1, $limit);
$html_page2 = Html_Page2($total_count, $page_count, 2, $limit);


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
$page_menu = Create_Menu_f("buy", "1");

/****************************/
// ���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["change_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["new_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["ord_button"]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
    "html_header"    => "$html_header",
    "page_menu"      => "$page_menu",
    "page_header"    => "$page_header",
    "html_footer"    => "$html_footer",
    "html_page"      => "$html_page",
    "html_page2"     => "$html_page2",
    "r_count"        => "$r_count",
    "ord_d_id_error" => "$ord_d_id_error",
    "reason_error"   => "$reason_error",
    "post_flg"          => "$post_flg",
    "err_flg"           => "$err_flg",
));

$smarty->assign("row", $row_data);

$smarty->assign("html", array(
    "html_s"        => $html_s,
    "html_l"        => $html_l,
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER["PHP_SELF"].".tpl"));

?>