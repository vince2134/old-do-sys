<?php
/*************************
//  �ѹ�����
//      DB�����ѹ��ˤȤ�ʤ�������20060906��
//
//  (2006-09-15) (kaji)
//  ��DB�����ѹ���ȼ������
//  ���������Ͻ������Ǥ��ʤ��褦���ѹ�
//
//
//
/*************************/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *  -----------------------------------------------------------
 * ��2006/12/28��xx-xxx��������kajioka-h   ���롼��CD��������CD�ǥ����Ȥ���褦���ѹ�
 *   2007/01/09  0043          kajioka-h   ������ơ��֥�˻Ĥ�ô����̾�����ô��1��2�˽���
 *               0044          kajioka-h   ������̾1��2��ά�Ρ������å�̾�ʷ���ô���ˤ�addslashes�ɲ�
 *   2007/04/11                watanabe-k  ������ⵡǽ�ɲäˤ��ƶ��ν����ʰ������Ѥߤ�������ˤϻĹ�����Ǥ��ʤ���
 *   2007/04/19                watanabe-k  ������������ۤ�null�ξ�����ݻĹ���������ǽ�Ȥ��롣 
 *   2009/12/24                aoyama-n    ��Ψ��TaxRate���饹�������
 *   2015/05/01                amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 * 
 */

$page_title = "��ݻĹ�������";

//�Ķ�����ե�����
require_once("ENV_local.php");

$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];


#2009-12-24 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

/****************************/
// �ե�����ǥե������
/****************************/
$def_fdata["form_state_radio"] = "1";
$def_fdata["form_zandaka_radio"] = "2";
$form->setDefaults($def_fdata);


/****************************/
// �ե�����ѡ��ĺ���
/****************************/
// ����
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "�����", "1");
$radio[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$radio[] =& $form->createElement("radio", null, null, "����", "3");
$radio[] =& $form->createElement("radio", null, null, "����", "4");
$form->addGroup($radio, "form_state_radio", "");

// �Ĺ�����
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "0�Τ�", "1");
$radio[] =& $form->createElement("radio", null, null, "����", "2");
$form->addGroup($radio, "form_zandaka_radio", "");

// ɽ���ܥ���
$form->addElement("button", "form_show_button", "ɽ����", "onClick=\"javascript:Button_Submit('show_button_flg','#','true')\"");

// �Ĺ�ܹ�ǯ����
$text3_1[] =& $form->createElement(
    "text", "y", "", "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\" 
    onkeyup=\"changeText(this.form,'form_close_day[y]','form_close_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_close_day[y]','form_close_day[m]','form_close_day[d]')\" 
    onBlur=\"blurForm(this)\""
);
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement(
    "text", "m", "", "size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\" 
    onkeyup=\"changeText(this.form,'form_close_day[m]','form_close_day[d]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_close_day[y]','form_close_day[m]','form_close_day[d]')\" 
    onBlur=\"blurForm(this)\""
);
$text3_1[] =& $form->createElement("static", "", "", "-");
$text3_1[] =& $form->createElement(
    "text", "d", "", "size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\" 
    onFocus=\"onForm_today(this,this.form,'form_close_day[y]','form_close_day[m]','form_close_day[d]')\" 
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $text3_1, "form_close_day", "�Ĺ�ܹ�ǯ����");

// �Ĺ���
$form->addElement("static", "static_sum", "");

// �϶�
$select_value = Select_Get($conn, "area");
$form->addElement("select", "form_area",'', $select_value, $g_form_option_select);

// ��Ͽ�ܥ���
$form->addElement(
    "submit", "form_entry_button", "�С�Ͽ", 
    "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','./2-1-305.php', this)\" $disabled"
);

//���顼�������ѥե�����
$form->addElement("text", "form_set_error","","");

// hidden
$form->addElement("hidden", "show_button_flg");


/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    //POST����
    $close_day_y = str_pad($_POST["form_close_day"]["y"], 4, "0", STR_PAD_LEFT);    //����
    $close_day_m = str_pad($_POST["form_close_day"]["m"], 2, "0", STR_PAD_LEFT);
    $close_day_d = str_pad($_POST["form_close_day"]["d"], 2, "0", STR_PAD_LEFT);

    for($i = 0; $i < count($_POST["form_init_cbln"]); $i++){
        if($_POST["form_init_cbln"][$i] != null && $_POST["hdn_input_flg"][$i] == 'f'){
            $init_cbln[] = $_POST["form_init_cbln"][$i];    //��ݻĹ�
            $client_id[] = $_POST["hdn_client_id"][$i];
        }
    }

    //���ե��顼�����å�
    $form->addGroupRule('form_close_day', array(
        'y' => array(
                array('�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���', 'required'),
                array('�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),              
        'm' => array(
                array('�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���', 'required'),
                array('�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),              
        'd' => array(
                array('�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���', 'required'),
                array('�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),              
    ));
    if(!checkdate((int)$close_day_m, (int)$close_day_d, (int)$close_day_y)){
        $form->setElementError("form_close_day","�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���");
        $err_flg = true;
    }elseif($close_day_y."-".$close_day_m."-".$close_day_d > date("Y-m-d")){
        $form->setElementError("form_close_day","�Ĺ�ܹ�ǯ���������դ������ǤϤ���ޤ���");
        $err_flg = true;
    } 

    //�������������դ������å�
/*
    if($err_flg != true){
        $sql = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = $shop_id;";
        $result = Db_Query($conn, $sql);
        $close_day_last = (pg_fetch_result($result, 0, 0) != null) ? pg_fetch_result($result, 0, 0) : START_DAY;
        if($close_day_y."-".$close_day_m."-".$close_day_d <= $close_day_last){
            $form->setElementError("form_close_day","�Ĺ�ʹ�ǯ���� �ϡ���������ǯ���� ���������դ����Ϥ��Ƥ���������");
            $err_flg = true;
        }
    }
*/
    //�������������դ������å�
    if($err_flg != true){
        $err_mess = Sys_Start_Date_Chk($close_day_y, $close_day_m, $close_day_d, "�ܹ�ǯ����");
        if($err_mess != null){
            $form->setElementError("form_close_day",$err_mess);
            $err_flg = true; 
        }else{  
            $sql = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = $shop_id;";
            $result = Db_Query($conn, $sql);
            $close_day_last = (pg_fetch_result($result, 0, 0) != null) ? pg_fetch_result($result, 0, 0) : START_DAY;

            if($close_day_y."-".$close_day_m."-".$close_day_d <= $close_day_last){
                $form->setElementError("form_close_day","�Ĺ�ʹ�ǯ���� �ϡ���������ǯ���� ���������դ����Ϥ��Ƥ�����>����");
                $err_flg = true; 
            }       
        }       
    }



    //��ݻĹ����ϥ����å�
    if(count($init_cbln) == 0){
        $form->setElementError("form_set_error","��ݽ���Ĺ�Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
        $err_flg = true;
    } 


    for($i = 0; $i < count($init_cbln); $i++){
        //Ⱦ�ѥ����å�
        if(!ereg("^[-]?[0-9]+$", $init_cbln[$i])){
            $form->setElementError("form_set_error","��ݽ���Ĺ�Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
            $err_flg = true;
        }

        //���إå������⤤�ơ��֥����Ͽ���ʤ�����ǧ
        //���إå����䤤��碌
        $sql  = "SELECT";
        $sql .= "   count(sale_id)";
        $sql .= " FROM";
        $sql .= "   t_sale_h";
        $sql .= " WHERE";
        $sql .= "   client_id = $client_id[$i]";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $buy_count = pg_fetch_result($result,0,0);

        //���إå�����Ͽ���ʤ����
        if($buy_count >  0){
            $form->setElementError(
                "form_set_error",
                "������夬�����äƤ��뤿�ᡢ��ݽ���Ĺ������Ǥ��ޤ���"
            );
            $err_flg = true;
            break;
        }
            
        //���⤤�إå����䤤��碌
        $sql  = "SELECT";
        $sql .= "   count(pay_id)";
        $sql .= " FROM";
//        $sql .= "   t_payin";
        $sql .= "   t_payin_h";
        $sql .= " WHERE";
        $sql .= "   client_id = $client_id[$i]";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $pay_count = pg_fetch_result($result,0,0);

        if($pay_count > 0){
            $form->setElementError(
                "form_set_error",
                "�������⤤�������äƤ��뤿�ᡢ��ݽ���Ĺ������Ǥ��ޤ���"
            );
            $err_flg = true;
            break;
        }
    }

    /***********************/
    //����
    /***********************/
    if($form->validate()  && $err_flg != true){

        $close_day = $close_day_y."-".$close_day_m."-".$close_day_d;

        #2009-12-24 aoyama-n
        $tax_rate_obj->setTaxRateDay($close_day);

        /***************************/
        //��Ͽ����
        /**************************/
        Db_Query($conn, "BEGIN;");
        for($i = 0; $i < count($init_cbln); $i++){

            //������2����Ͽ������å�
            $sql  = "SELECT";
            $sql .= "   count(client_id)";
            $sql .= " FROM";
            $sql .= "   t_first_ar_balance";
            $sql .= " WHERE";
            $sql .= "   client_id = $client_id[$i]";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $add_count = pg_fetch_result($result,0,0);
            if($add_count > 0){
                continue;
            }

            //�����ݻĹ�ơ��֥�
            $sql  = "INSERT INTO t_first_ar_balance (";
            $sql .= "   ar_balance,";
            $sql .= "   client_id,";
            $sql .= "   shop_id";
            $sql .= ") VALUES (";
            $sql .= "   $init_cbln[$i],";
            $sql .= "   $client_id[$i],";
            $sql .= "   $shop_id";
            $sql .= ");";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }


            //������ξ�������
            $sql  = "
                SELECT 
                    t_client.close_day, 
                    t_client.pay_m, 
                    t_client.pay_d, 
                    t_client.client_cd1, 
                    t_client.client_cd2, 
                    t_client.client_name AS client_name1, 
                    t_client.client_name2, 
                    t_client.client_cname, 
                    t_staff1.staff_name AS staff1_name, 
                    t_staff2.staff_name AS staff2_name, 
                    t_client.c_tax_div, 
                    t_client.tax_franct, 
                    t_client.coax, 
                    t_client.tax_div 
                FROM 
                    t_client 
                    LEFT JOIN t_staff AS t_staff1 ON t_client.c_staff_id1 = t_staff1.staff_id 
                    LEFT JOIN t_staff AS t_staff2 ON t_client.c_staff_id2 = t_staff2.staff_id 
                WHERE 
                    t_client.client_id = $client_id[$i] 
                ;
            ";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
            $client_data = pg_fetch_array($result);


            //��ݻĹ�ơ��֥�
/*
            $sql  = "INSERT INTO t_ar_balance (";
            $sql .= "   ar_balance,";
            $sql .= "   close_day,";
            $sql .= "   client_id,";
            $sql .= "   shop_id";
            $sql .= ") VALUES (";
            $sql .= "   $init_cbln[$i],";
            $sql .= "   '$close_day',";
            $sql .= "   $client_id[$i],";
            $sql .= "   $shop_id";
            $sql .= ");";
*/

            #2009-12-24 aoyama-n
            $tax_num = $tax_rate_obj->getClientTaxRate($client_id[$i]);

            $sql  = "
                INSERT INTO 
                    t_ar_balance 
                ( 
                    ar_balance_id, 
                    monthly_close_day_last, 
                    monthly_close_day_this, 
                    close_day, 
                    pay_m, 
                    pay_d, 
                    client_id, 
                    client_cd1, 
                    client_cd2, 
                    client_name1, 
                    client_name2, 
                    client_cname, 
                    ar_balance_last, 
                    pay_amount, 
                    tune_amount, 
                    rest_amount, 
                    net_sale_amount, 
                    tax_amount, 
                    intax_sale_amount, 
                    ar_balance_this, 
                    staff1_name, 
                    staff2_name, 
                    installment_receivable_balance, 
                    installment_sales_amount, 
                    shop_id, 
                    tax_rate_n, 
                    c_tax_div, 
                    tax_franct, 
                    coax, 
                    tax_div 
                ) VALUES ( 
                    (SELECT COALESCE(MAX(ar_balance_id), 0)+1 FROM t_ar_balance), 
                    '".START_DAY."', 
                    '$close_day', 
                    '".$client_data["close_day"]."', 
                    '".$client_data["pay_m"]."', 
                    '".$client_data["pay_d"]."', 
                    $client_id[$i], 
                    '".$client_data["client_cd1"]."', 
                    '".$client_data["client_cd2"]."', 
                    '".addslashes($client_data["client_name1"])."', 
                    '".addslashes($client_data["client_name2"])."', 
                    '".addslashes($client_data["client_cname"])."', 
                    0, 
                    0, 
                    0, 
                    0, 
                    0, 
                    0, 
                    0, 
                    $init_cbln[$i], 
                    '".addslashes($client_data["staff1_name"])."', 
                    '".addslashes($client_data["staff2_name"])."', 
                    0, 
                    0, 
                    $shop_id, 
                    '".$tax_num."',
                    '".$client_data["c_tax_div"]."', 
                    '".$client_data["tax_franct"]."', 
                    '".$client_data["coax"]."', 
                    '".$client_data["tax_div"]."' 
                );
            ";
                    #2009-12-24 aoyama-n
                    #(SELECT tax_rate_n FROM t_client WHERE client_id = $shop_id), 

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //$add_msg = "��Ͽ���ޤ�����";

        }

        Db_Query($conn, "COMMIT;");

        $add_msg = "��Ͽ���ޤ�����";
    }
}


/****************************/
// ����ɽ������
/****************************/
if ($_POST["show_button_flg"] == true){

    // ���֤����
    $state = $_POST["form_state_radio"];
    $zandaka    = $_POST["form_zandaka_radio"];

    // �϶�����
    $area = $_POST["form_area"];

    // WHERE�����
    $where_sql = null; 
    $where_sql = ($state == 1) ? " AND t_client.state = '1' " : $where_sql;
    $where_sql = ($state == 2) ? " AND t_client.state = '2' " : $where_sql;
    $where_sql = ($state == 3) ? " AND t_client.state = '3' " : $where_sql;

    $where_sql .= ($zandaka == 1) ? " AND t_first_ar_balance.ar_balance = 0 " : null;

    $where_sql .= ($area != null)? " AND t_client.area_id = $area" : null;

    //--����OR���򵯤����Ƥ���AND����Ĺ�̤����
    $sql  = "SELECT\n";
    $sql .= "    t_client.client_id,\n";
    $sql .= "    t_client.client_cd1,\n";
    $sql .= "    t_client.client_cd2,\n";
    $sql .= "    t_client.client_name,\n";
    $sql .= "    t_client.client_name2,\n";
    $sql .= "    t_first_ar_balance.ar_balance,\n";
    $sql .= "    't' AS input_flg,\n";
    $sql .= "   null,\n";
//�ƶ�ʬ
    $sql .= "   t_client.parents_flg, \n";
    $sql .= "   t_client_gr.client_gr_cd \n";
    $sql .= " FROM\n";
    $sql .= "    t_client\n";
    $sql .= "    LEFT JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    t_sale_h\n";
    $sql .= "    ON t_client.client_id = t_sale_h.client_id\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    t_payin_h\n";
    $sql .= "    ON t_client.client_id = t_payin_h.client_id\n";

    $sql .= "        LEFT JOIN \n";
    $sql .= "    t_payallocation_d \n";
    $sql .= "    ON t_client.client_id = t_payallocation_d.client_id \n";

    $sql .= "   AND t_payallocation_d.amount IS NOT NULL \n";

    $sql .= "        LEFT JOIN\n";
    $sql .= "    t_first_ar_balance\n";
    $sql .= "    ON t_client.client_id = t_first_ar_balance.client_id\n";
    $sql .= " WHERE\n";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "    AND\n";
    $sql .= "    t_client.client_div = '1'\n";
    $sql .= "    AND\n";
    $sql .= "    (t_sale_h.client_id IS NOT NULL\n";
    $sql .= "    OR\n";
    $sql .= "    t_payin_h.client_id IS NOT NULL \n";
    $sql .= "    OR \n";
    $sql .= "    t_payallocation_d.client_id IS NOT NULL \n";
    $sql .= "   )\n";
    $sql .= "    AND\n";
    $sql .= "    t_first_ar_balance.client_id IS NULL\n";
    $sql .= $where_sql;
    $sql .= " GROUP BY\n";
    $sql .= "   t_client_gr.client_gr_cd,\n";
    $sql .= "   t_client.client_id,\n";
    $sql .= "   t_client.client_cd1,\n";
    $sql .= "   t_client.client_cd2,\n";
    $sql .= "   t_client.client_name,\n";
    $sql .= "   t_client.client_name2,\n";
    $sql .= "   t_first_ar_balance.ar_balance,\n";
    $sql .= "   t_client.parents_flg \n";
    $sql .= " UNION ALL\n";
    //--����Ĺ������
    $sql .= " SELECT\n";
    $sql .= "    t_client.client_id,\n";
    $sql .= "    t_client.client_cd1,\n";
    $sql .= "    t_client.client_cd2,\n";
    $sql .= "    t_client.client_name,\n";
    $sql .= "    t_client.client_name2,\n";
    $sql .= "   t_first_ar_balance.ar_balance,\n";
    $sql .= "   't' AS input_flg,\n";
//    $sql .= "   t_ar_balance.close_day\n";
    $sql .= "    t_ar_balance.monthly_close_day_this, \n";
//�ƶ�ʬ
    $sql .= "   t_client.parents_flg, \n";
    $sql .= "   t_client_gr.client_gr_cd \n";
    $sql .= " FROM\n";
    $sql .= "    t_client\n";
    $sql .= "    LEFT JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id \n";
    $sql .= "       INNER JOIN\n";
    $sql .= "    t_first_ar_balance\n";
    $sql .= "    ON t_client.client_id = t_first_ar_balance.client_id\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "    (SELECT\n";
    $sql .= "       client_id,\n";
//    $sql .= "       MIN(close_day) AS close_day\n";
    $sql .= "       MIN(monthly_close_day_this) AS monthly_close_day_this\n";
    $sql .= "   FROM\n";
    $sql .= "       t_ar_balance\n";
    $sql .= "   WHERE\n";
    //$sql .= "       shop_id = $shop_id\n";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= "   GROUP BY client_id\n";
    $sql .= "   ) AS t_ar_balance\n";
    $sql .= "   ON t_client.client_id = t_ar_balance.client_id\n";
    $sql .= " WHERE\n";
    //$sql .= "    t_client.shop_id = $shop_id\n";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "    AND\n";
    $sql .= "    t_client.client_div = '1'\n";
    $sql .= "    AND\n";
    $sql .= "    t_first_ar_balance.client_id IS NOT NULL\n";
    $sql .= $where_sql;
    $sql .= "UNION ALL\n";
    //--����򤪤����Ƥ��ʤ�AND���򵯤����Ƥ��ʤ�AND̤����
    $sql .= "  SELECT\n";
    $sql .= "    t_client.client_id,\n";
    $sql .= "    t_client.client_cd1,\n";
    $sql .= "    t_client.client_cd2,\n";
    $sql .= "    t_client.client_name,\n";
    $sql .= "    t_client.client_name2,\n";
    $sql .= "   t_first_ar_balance.ar_balance,\n";
    $sql .= "   'f' AS input_flg,\n";
    $sql .= "   null,\n";
//�ƶ�ʬ
    $sql .= "   t_client.parents_flg, \n";
    $sql .= "   t_client_gr.client_gr_cd \n";
    $sql .= " FROM\n";
    $sql .= "    t_client\n";
    $sql .= "    LEFT JOIN t_client_gr ON t_client.client_gr_id = t_client_gr.client_gr_id\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    t_sale_h\n";
    $sql .= "    ON t_client.client_id = t_sale_h.client_id\n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    t_payin_h\n";
    $sql .= "    ON t_client.client_id = t_payin_h.client_id\n ";

    $sql .= "       LEFT JOIN \n";
    $sql .= "    t_payallocation_d \n";
    $sql .= "    ON t_client.client_id = t_payallocation_d.client_id \n";

    $sql .= "   AND t_payallocation_d.amount IS NOT NULL \n";
    $sql .= "        LEFT JOIN\n";
    $sql .= "    t_first_ar_balance\n";
    $sql .= "    ON t_client.client_id = t_first_ar_balance.client_id\n";
    $sql .= " WHERE\n";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "    AND\n";
    $sql .= "    t_client.client_div = '1'\n";
    $sql .= "    AND\n";
    $sql .= "    t_sale_h.client_id IS NULL\n";
    $sql .= "    AND\n";
    $sql .= "    t_payin_h.client_id IS NULL\n";

    $sql .= "    AND \n";
    $sql .= "    t_payallocation_d.client_id IS NULL \n";

    $sql .= "    AND\n";
    $sql .= "    t_first_ar_balance IS NULL\n";
    $sql .= $where_sql;
    $sql .= " ORDER BY client_gr_cd, client_cd1, client_cd2\n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    $match_count = pg_num_rows($result);
    $show_data = Get_Data($result);

    /****************************/
    // �ե�����ѡ��ĺ���
    /****************************/
    for($i = 0; $i < count($show_data); $i++){
        $sql  = "SELECT ";
        $sql .= "    COUNT(ar_balance_id) ";
        $sql .= "FROM ";
        $sql .= "    t_ar_balance ";
        $sql .= "WHERE ";
        $sql .= "    client_id = ".$show_data[$i][0]." ";
        $sql .= "    AND shop_id = $shop_id ";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $result_count = pg_fetch_result($result, 0, 0);

        // ��ݻĹ�
        //���ϤǤ�����
        //if($show_data[$i][6] == 'f'){
        if($show_data[$i][6] == 'f' && $result_count == 0){
            $form->addElement(
                "text", "form_init_cbln[$i]", "", "class=\"money\" size=\"11\" maxLength=\"9\" 
                $g_form_option style=\"text-align: right; $g_form_style\""
            );
            $set_data["form_init_cbln[$i]"] = "";
        }else{
            $freeze =& $form->addElement(
                "text", "form_init_cbln[$i]", "","size =\"13\"
                style=\"text-align : right; 
                border : #ffffff 1px solid; 
                background-color: #ffffff;\" 
                readonly"
            );

            $set_data["form_init_cbln[$i]"] = "";
            if($show_data[$i][5] != null){
                $set_data["form_init_cbln[$i]"] = number_format($show_data[$i][5]);
            }else{
                $set_data["form_init_cbln[$i]"] = "0";
            }

            // �Ĺ��­���Ƥ���
            $num += $show_data[$i][5];

        }
        //�����ID
        $form->addElement("hidden","hdn_client_id[$i]");
        //��Ͽ�ѥե饰
        $form->addElement("hidden","hdn_input_flg[$i]");

        $set_data["hdn_client_id[$i]"] = $show_data[$i][0];
        $set_data["hdn_input_flg[$i]"] = $show_data[$i][6];
    }

    // �Ĺ��פ򥻥å�
    $set_data["static_sum"] = number_format($num);

    $form->setConstants($set_data);

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
//$page_menu = Create_Menu_f('system','3');

/****************************/
//���̥إå�������
/****************************/
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
    'match_count'   => "$match_count",
    'add_msg'       => "$add_msg",
));

$smarty->assign("show_data", $show_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>