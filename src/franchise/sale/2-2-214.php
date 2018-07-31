<?php
/************************************/
// �����������
//
//�ѹ�����
//  ��������������ǡ������SQL���ѹ���2006/06/16��watanabe-k��
//
//  �����������饳�ԡ���������Ѥˡ�2006/08/24 kaji��
//
//  ������򺣲������ʹߤβ�����ˡ�2006/09/16 kaji��
//  ʬ������2��ʾ��
//
//  ��ʧ���Υ��쥯�ȥܥå�������0�����פȤʤäƤ����Τ�ʤ�����2006/09/16 kaji��
//
//  ��2006/10/26 kaji��
//    ����ʧ���ϻ������Ϥ����Ϥ��줿�����������
//
//  ��2006/11/27 koji��
//    ����ʧ���ϻ������Ϥ����Ϥ��줿�������ܽ����������
//
/************************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/11      03-010      kajioka-h   ��Ͽľ���˼����ʬ���ѹ�����Ƥ��ʤ�����ǧ����������ɲ�
 *                  03-012      kajioka-h   ��Ͽľ�������������ѹ�����Ƥ��ʤ�����ǧ����������ɲ�
 *  2006-12-12      03-061      suzuki      ��Ͽľ���������褬�ѹ�����Ƥ��ʤ�����ǧ����������ɲ�
 *  2006-12-14      03-062      kajioka-h   ��Ͽľ����������������Ƥ��ʤ�����ǧ����������ɲ�
 *  2007-01-17      �����ѹ�    watanabe-k  ʬ�����򣲡������ޤǤ��ѹ�
 *
 */

//$page_title = "���Ȳ�";
$page_title = "�����������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;


/****************************/
//�����ѿ�����
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];

$sale_id      = $_GET["sale_id"];           //���ID
Get_Id_Check2($sale_id);
Get_Id_Check3($sale_id);
$division_flg = ($_GET["division_flg"] == "true") ? true : false;      //���ϼ��̥ե饰
$change_flg = $_GET["change_flg"];

/****************************/
//���ɽ���ǡ������������SQL��
/****************************/
$sql  = "SELECT \n";
$sql .= "    t_sale_h.sale_no, \n";
$sql .= "    t_sale_h.sale_day, \n";
$sql .= "    t_sale_h.claim_day, \n";
$sql .= "    t_trade.trade_name, \n";
$sql .= "    t_sale_h.client_cd1, \n";
$sql .= "    t_sale_h.client_cd2, \n";
$sql .= "    t_sale_h.client_cname, \n";
$sql .= "    t_sale_h.direct_cd, \n";
$sql .= "    t_sale_h.direct_cname, \n";
$sql .= "    t_sale_h.trans_cname, \n";
$sql .= "    t_sale_h.green_flg, \n";
$sql .= "    t_sale_h.ware_name, \n";
$sql .= "    t_sale_staff.staff_name, \n";
$sql .= "    t_sale_h.net_amount, \n";
$sql .= "    t_sale_h.tax_amount, \n";
$sql .= "    t_sale_h.note, \n";
$sql .= "    t_sale_h.renew_flg, \n";
$sql .= "    t_sale_h.client_id \n";
$sql .= "FROM \n";
$sql .= "    t_sale_h \n";
$sql .= "    INNER JOIN t_trade ON t_sale_h.trade_id = t_trade.trade_id \n";
$sql .= "    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id \n";
$sql .= "        AND t_sale_staff.staff_div = '0' \n";
$sql .= "WHERE \n";
if($_SESSION["group_kind"] == "2"){
    $sql .= "    t_sale_h.shop_id IN (".Rank_Sql().") \n";
}else{
    $sql .= "    t_sale_h.shop_id = $shop_id \n";
}
$sql .= "    AND \n";
$sql .= "    t_sale_h.sale_id = $sale_id \n";
$sql .= ";\n";
//echo "���ɽ�����إå�SQL��<br>$sql<br>";

$result = Db_Query($db_con, $sql);

//GET�ǡ���Ƚ��
Get_Id_Check($result);
$h_data_list = Get_Data($result);


//���إå���ɽ��
$def_fdata["form_sale_no"]          = $h_data_list[0][0];   //��ɼ�ֹ�

//��������
$form_sale_day = explode('-',$h_data_list[0][1]);
$def_fdata["form_sale_day"]["y"]    = $form_sale_day[0];    //�����(ǯ)
$def_fdata["form_sale_day"]["m"]    = $form_sale_day[1];    //�����(��)
$def_fdata["form_sale_day"]["d"]    = $form_sale_day[2];    //�����(��)

$form->addElement("hidden", "hdn_claim_day");
$def_fdata["hdn_claim_day"]         = $h_data_list[0][2];
$claim_day                          = $h_data_list[0][2];
$form_claim_day = explode('-',$h_data_list[0][2]);
$def_fdata["form_claim_day"]["y"]   = $form_claim_day[0];   //������(ǯ)
$def_fdata["form_claim_day"]["m"]   = $form_claim_day[1];   //������(��)
$def_fdata["form_claim_day"]["d"]   = $form_claim_day[2];   //������(��)

$def_fdata["form_trade_sale"]       = $h_data_list[0][3];   //�����ʬ
$trade_name                         = $h_data_list[0][3];   //�����ʬ

$def_fdata["form_client"]["cd1"]    = $h_data_list[0][4];   //������CD1
$def_fdata["form_client"]["cd2"]    = $h_data_list[0][5];   //������CD2
$def_fdata["form_client"]["name"]   = $h_data_list[0][6];   //������̾��ά�Ρ�

//$def_fdata["form_direct_cd"]      = $h_data_list[0][7];   //ľ���襳����
$def_fdata["form_direct_name"]      = $h_data_list[0][8];   //ľ����

$def_fdata["form_trans_name"]       = $h_data_list[0][9];   //�����ȼ�
//���꡼�����Ƚ��
if($h_data_list[0][10] == 't'){
    $def_fdata["form_trans_check"]  = "���꡼����ꤢ�ꡡ";
}

$def_fdata["form_ware_name"]        = $h_data_list[0][11];  //�Ҹ�
$def_fdata["form_cstaff_name"]      = $h_data_list[0][12];  //���ô����

$def_fdata["form_sale_total"]       = number_format($h_data_list[0][13]);   //����ۡ���ȴ��
$def_fdata["form_sale_tax"]         = number_format($h_data_list[0][14]);   //������
$total_money = $h_data_list[0][13] + $h_data_list[0][14];   //�ǹ����
$def_fdata["form_sale_money"]       = number_format($total_money);

$def_fdata["form_note"]             = $h_data_list[0][15];  //����

$def_fdata["hdn_renew_flg"]         = $h_data_list[0][16];  //���������ե饰
$division_flg = ($h_data_list[0][16] == "t") ? "true" : $division_flg;

//�����������
$sql = "SELECT pay_d, pay_m FROM t_client WHERE client_id = ".$h_data_list[0][17].";";
$result = Db_Query($db_con,$sql);
$form->setConstants(array("form_pay_d"=>(int)pg_fetch_result($result, 0, 0)));
$form->setConstants(array("hdn_form_pay_m"=>(int)pg_fetch_result($result, 0, 1)));

//������
$def_fdata["hdn_client_id"] = $h_data_list[0][17];
$client_id                  = $h_data_list[0][17];

$form->setDefaults($def_fdata);

//���Ϥ��줿����������ˤ���
$yy = (int)$form_claim_day[0];
$mm = (int)$form_claim_day[1];


//ʬ������ܥ��󲡲�����������������Ƥ�����票�顼
if($h_data_list[0][16] == "t" && isset($_POST["add_button"])){
    $renew_msg = "������������Ƥ��뤿�ᡢ����������ϤǤ��ޤ���";
}


/****************************/
// ʬ�������ǧ�Τߤξ��
/****************************/
if ($division_flg == "true"){

    // ��������ID��ʬ��ǡ��������
    $sql = "SELECT collect_day, collect_amount FROM t_installment_sales WHERE sale_id = $sale_id ORDER BY collect_day;";
    $res = Db_Query($db_con, $sql);
    $i = 0;
    while ($ary_res = @pg_fetch_array($res, $i, PGSQL_ASSOC)){
        $ary_division_data[$i]["pay_day"] = $ary_res["collect_day"];
        $ary_division_data[$i]["split_pay_amount"] = $ary_res["collect_amount"];
        $i++;
    }

    for ($i=0; $i<count($ary_division_data); $i++){
        $form->addElement("static", "form_pay_date[$i]", "");
        $form->addElement("static", "form_pay_amount[$i]", "");
        $division_data["form_pay_date[$i]"]     = $ary_division_data[$i]["pay_day"];
        $division_data["form_pay_amount[$i]"]   = number_format($ary_division_data[$i]["split_pay_amount"]);
    }
        $form->setConstants($division_data);

/****************************/
// ʬ�������Ԥ���̤����ξ��
/****************************/
}else{
    /****************************/
    // ʬ������ܥ��󲡲�����������
    /****************************/
    if ($_POST["hdn_division_submit"] == "t"){

        /*** ʬ�����ꥨ�顼�����å� ***/

        // ���顼�ե饰��Ǽ�����
        $ary_division_err_flg = array();

        // ��ʧ��
        if ($_POST["form_pay_m"] == null || $_POST["form_pay_d"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "�������ɬ�ܤǤ���";
        }

        // ʬ����
        if ($_POST["form_division_num"] == null){
            $ary_division_err_flg[] = true;
            $ary_division_err_msg[] = "ʬ������ɬ�ܤǤ���";
        }

        // ���顼�����å���̽���
        $division_err_flg = (in_array(true, $ary_division_err_flg)) ? true : false;

        // ʬ������ե饰��Ǽ
        $division_set_flg = ($division_err_flg === false) ? true : false;

        // ʬ���������Ƥ�hidden��SET
        if ($division_set_flg == true){
            $hdn_set["hdn_pay_m"]           = $_POST["form_pay_m"];
            $hdn_set["hdn_pay_d"]           = $_POST["form_pay_d"];
            $hdn_set["hdn_division_num"]    = $_POST["form_division_num"];
            $form->setConstants($hdn_set);
        }

        // hidden��SET���줿ʬ������ܥ��󲡲��������
        $hdn_del["hdn_division_submit"] = "";
        $form->setConstants($hdn_del);

    }

    /****************************/
    // ʬ���ʧ��Ͽ�ܥ��󲡲�����������
    /****************************/
    if (isset($_POST["add_button"])){

        // ��ʬ���ʧ��Ͽ�ܥ���ɽ������Ƥ����ʬ���������Ƥ�����ʤ��ʤΤǡ�ʬ������ե饰ON���Ǽ
        $division_set_flg = true;

        // ��ʬ������ܥ��󲡲����ˡ�hidden��SET����ʬ���������Ƥ��ѿ�������
        $hdn_pay_m           = $_POST["hdn_pay_m"];
        $hdn_pay_d           = $_POST["hdn_pay_d"];
        $hdn_division_num    = $_POST["hdn_division_num"];

        // ����˥ե������SET��ɽ���ѡ�
        $division_set["form_pay_m"]         = $_POST["hdn_pay_m"];
        $division_set["form_pay_d"]         = $_POST["hdn_pay_d"];
        $division_set["form_division_num"]  = $_POST["hdn_division_num"];
        $form->setConstants($division_set);

    }


    /****************************/
    // ʬ���������
    /****************************/
    // ʬ������ե饰�����ξ��
    if ($division_set_flg === true){

        // ʬ������������
        $pay_m          = isset($_POST["add_button"]) ? $hdn_pay_m : $_POST["form_pay_m"];                  // ��ʧ���ʷ��

//        $pay_m          = $pay_m + $_POST["hdn_form_pay_m"];

        $pay_d          = isset($_POST["add_button"]) ? $hdn_pay_d : $_POST["form_pay_d"];                  // ��ʧ��������
        $division_num   = isset($_POST["add_button"]) ? $hdn_division_num : $_POST["form_division_num"];    // ʬ����
        $total_money    = str_replace(",", "", $total_money);   // �ǹ���ۡʥ����ȴ����
        //$yy             = date("Y");
        //$mm             = date("m");

        // �ǹ���ۡ�ʬ�����ξ�
        $division_quotient_price    = bcdiv($total_money, $division_num);
        // �ǹ���ۡ�ʬ������;��
        $division_franct_price      = bcmod($total_money, $division_num);
        // 2���ܰʹߤλ�ʧ���
        $second_over_price          = str_pad(substr($division_quotient_price, 0, 3), strlen($division_quotient_price), 0);
        // 1���ܤλ�ʧ���
        $first_price                = ($division_quotient_price - $second_over_price) * $division_num + $division_franct_price + $second_over_price;
        // ��ۤ�ʬ�����ǳ���ڤ����
        if ($division_franct_price == "0"){
            $first_price = $second_over_price = $division_quotient_price;
        }

        // ʬ����ʬ�롼��
        for ($i=0; $i<$division_num; $i++){

            // ʬ���ʧ������
            $date_y     = date("Y", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $date_m     = date("m", mktime(0, 0, 0, $mm + $pay_m + $i, 1, $yy));
            $mktime_m   = ($pay_d == "29") ? $mm + $pay_m + $i + 1 : $mm + $pay_m + $i;
            $mktime_d   = ($pay_d == "29") ? 0 : $pay_d;
            $date_d     = date("d", mktime(0, 0, 0, $mktime_m, $mktime_d, $yy));

            // ʬ���ʧ���������SET
            $division_date[]    = "$date_y-$date_m-$date_d";

            // ʬ���ʧ��ۤ������SET
            $division_price[]   = ($i == 0) ? $first_price : $second_over_price;

            // ʬ���ʧ���ե��������
            $form_pay_date = null;
            $form_pay_date[] = &$form->createElement("static", "y", "", "");
            $form_pay_date[] = &$form->createElement("static", "m", "", "");
            $form_pay_date[] = &$form->createElement("static", "d", "", "");
            $form->addGroup($form_pay_date, "form_pay_date[$i]", "", "-");

            // ʬ���ʧ��ۥե��������
            $form->addElement("text", "form_split_pay_amount[$i]", "", "class=\"money\" size=\"11\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

            // ʬ���ʧ��ۤ򥻥å�
            $set_data["form_split_pay_amount"][$i] = ($i == 0) ? $first_price : $second_over_price;

            // ʬ���ʧ���򥻥å�
            $set_data["form_pay_date"][$i]["y"] = $date_y;
            $set_data["form_pay_date"][$i]["m"] = $date_m;
            $set_data["form_pay_date"][$i]["d"] = $date_d;

            // ʬ���ʧ��ۡ�ʬ���ʧ���ǡ�����SET��ʬ���ʧ��Ͽ�ܥ��󲡲����ϥե�����ǡ���������Ѥ���
            isset($_POST["add_button"]) ? $form->setDefaults($set_data) : $form->setConstants($set_data);

        }

    }

    /****************************/
    // ʬ��������Ͽ�ܥ��󲡲�����
    /****************************/
    if (isset($_POST["add_button"])){

        /****************************/
        // ���顼�����å�
        /****************************/
        /* ��׶�ۥ����å� */
        // ʬ���ʧ���
        $sum_err_flg = ($total_money != array_sum($_POST["form_split_pay_amount"])) ? true : false;
        if ($sum_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "ʬ�������ۤι�פ������Ǥ���");
        }

        /* Ⱦ�ѿ��������å� */
        // ʬ���ʧ���
        for ($i=0; $i<$division_num; $i++){
            $ary_numeric_err_flg[] = (ereg("^[0-9]+$", $_POST["form_split_pay_amount"][$i])) ? false : true;
        }
        if (in_array(true, $ary_numeric_err_flg)){
            $form->setElementError("form_split_pay_amount[0]", "ʬ�������ۤ�Ⱦ�ѿ����ΤߤǤ���");
        }
    
        /* ɬ�ܹ��ܥ����å� */
        // ʬ���ʧ���
        $required_err_flg = (in_array(null, $_POST["form_split_pay_amount"])) ? true : false;
        if ($required_err_flg == true){
            $form->setElementError("form_split_pay_amount[0]", "ʬ�������ۤ�ɬ�ܤǤ���");
        }

        /* �����ʬ�����å� */
        $trade_err_flg = ($trade_name != "�������") ? true : false;
        if ($trade_err_flg == true){
            $form->setElementError("form_trade_sale", "��ɼ���ѹ�����Ƥ��뤿�ᡢ����������ϤǤ��ޤ���");
        }

        /* �����������å� */
        $claim_day_err_flg = ($claim_day != $_POST["hdn_claim_day"]) ? true : false;
        if ($claim_day_err_flg == true){
            $form->setElementError("form_claim_day", "���������ѹ�����Ƥ��ޤ�������ʬ�����ꤷ�Ƥ���������");
        }

		/* �������ѹ�Ƚ�� */
        $client_id_err_flg = ($client_id != $_POST["hdn_client_id"]) ? true : false;
        if ($client_id_err_flg == true){
            $client_msg = "�����褬�ѹ�����Ƥ��뤿�ᡢ����������ϤǤ��ޤ���";
        }

		/* ���������ѹ�Ƚ�� */
		$sql  = "SELECT renew_flg FROM t_sale_h WHERE sale_id = $sale_id;";
		$result = Db_Query($db_con, $sql);
		$renew_data = Get_Data($result);
		if($renew_data[0][0] == "t"){
            $renew_msg = "������������Ƥ��뤿�ᡢ����������ϤǤ��ޤ���";
        }

        // ���顼�����å���̽���
        $err_flg = ($sum_err_flg == true || in_array(true, $ary_numeric_err_flg) || $required_err_flg == true || $trade_err_flg == true || $claim_day_err_flg == true || $client_id_err_flg == true || $renew_data[0][0] == "t" || $renew_msg != null) ? true : false;

        // �Х�ǡ�������
        $form->validate();

        /****************************/
        // DB����
        /****************************/
        // ���顼��̵�����
        if ($err_flg == false){

            // �ե꡼��
            $form->freeze();

            // �ȥ�󥶥�����󳫻�
            Db_Query($db_con, "BEGIN;");

            // ���������ե饰�����
            $db_err_flg = array();

            /* ���إå��ơ��֥빹������(UPDATE) */
            $sql = "UPDATE t_sale_h SET total_split_num = $division_num WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // �������Ի�����Хå�
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* �����ʧ�ơ��֥빹������(DELETE) */
            $sql = "DELETE from t_installment_sales WHERE sale_id = $sale_id;";
            $res  = Db_Query($db_con, $sql);

            // �������Ի�����Хå�
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                $db_err_flg[] = true;
                exit;
            }

            /* �����ʧ�ơ��֥빹������(INSERT) */
            for ($i=0; $i<$division_num; $i++){
/*
                $sql  = "INSERT INTO t_amortization (";
                $sql .= "    amortization_id,";
                $sql .= "    buy_id,";
                $sql .= "    pay_day,";
                $sql .= "    split_pay_amount";
                $sql .= ") VALUES (";
                $sql .= "    (SELECT COALESCE(MAX(amortization_id), 0)+1 FROM t_amortization),";
                $sql .= "    $sale_id,";
                $sql .= "    '$division_date[$i]',";
                $sql .= $_POST["form_split_pay_amount"][$i];
                $sql .= ");";
*/
                $sql  = "INSERT INTO \n";
                $sql .= "    t_installment_sales \n";
                $sql .= "( \n";
                $sql .= "    installment_sales_id, \n";
                $sql .= "    sale_id, \n";
                $sql .= "    collect_day, \n";
                $sql .= "    collect_amount \n";
                $sql .= ") VALUES ( \n";
                $sql .= "    (SELECT COALESCE(MAX(installment_sales_id), 0)+1 FROM t_installment_sales), \n";
                $sql .= "    $sale_id, \n";
                $sql .= "    '$division_date[$i]', \n";
                $sql .= "    ".$_POST["form_split_pay_amount"][$i]." \n";
                $sql .= ");\n";

                $res  = Db_Query($db_con, $sql);

                // �������Ի�����Хå�
                if ($res == false){
                    Db_Query($db_con, "ROLLBACK;");
                    $db_err_flg[] = true;
                    exit;
                }
            }

            // SQL���顼��̵�����
            if (!in_array(true, $db_err_flg)){

                // ����åȤ���
                Db_Query($db_con, "COMMIT;");

                // ʬ���ʧ��Ͽ�ե饰��TRUE��SET
                $division_comp_flg = true;

                // ����ɽ���Ѥ˥ʥ�С��ե����ޥåȤ���ʬ���ʧ��ۤ򥻥å�
                if (isset($_POST["add_button"])){
                    for ($i=0; $i<count($_POST["form_split_pay_amount"]); $i++){
                        $number_format_data["form_split_pay_amount"][$i] = number_format($_POST["form_split_pay_amount"][$i]);
                    }
                }
                $form->setConstants($number_format_data);
            }

        }

    }

}



/****************************/
//�������
/****************************/
//���׾���
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//������
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//��ɼ�ֹ�
$form->addElement("static","form_sale_no","","");

//������̾
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//���꡼�����
$form->addElement("static","form_trans_check","","");
//�����ȼ�̾
$form->addElement("static","form_trans_name","","");
//ľ����̾
$form->addElement("static","form_direct_name","","");
//�в��Ҹ�
$form->addElement("static","form_ware_name","","");
//�����ʬ
$form->addElement("static","form_trade_sale","","");
//���ô����
$form->addElement("static","form_cstaff_name","","");
//����
$form->addElement("static","form_note","","");

//��¾���顼�ξ���ɽ�����ʤ�
if($trade_err_flg != true && $claim_day_err_flg != true && $client_id_err_flg != true && $renew_data[0][0] != "t"){
	//��ɼȯ��
	$form->addElement("submit","add_button","ʬ��������Ͽ","$disabled");
}

//��ɼȯ��ID
$form->addElement("hidden", "order_sheet_id");

//������
$form->addElement("hidden", "hdn_form_pay_m");

//������
$form->addElement("hidden", "hdn_client_id");

// OK�ܥ���
$form->addElement("button", "ok_button", "�ϡ���", "onClick=\"location.href='".Make_Rtn_Page("sale")."'\"");


//���ܸ������å�
//������ϲ���
//���
if ($_GET["division_flg"] == "true"){
    $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"history.back()\"");
}else{
    $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='./2-2-201.php?sale_id=$sale_id&done_flg=true&change_flg=$change_flg&installment_flg=15'\"");
}


//����۹��
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���)
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����)
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"8\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//ʬ����
$select_value[null] = null;
/*
$select_value[2]    = "2��";
$select_value[3]    = "3��";
$select_value[6]    = "6��";
$select_value[12]   = "12��";
$select_value[24]   = "24��";
$select_value[36]   = "36��";
$select_value[48]   = "48��";
$select_value[60]   = "60��";
*/

for($i = 2; $i <= 60; $i++ ){
    $select_value[$i] = $i."��";
}

$form->addElement(
        "select","form_division_num", "",
        $select_value
);
$form->addElement("hidden","hdn_division_select");

//������
//��
$select_month[null] = null; 
//for($i = 1; $i <= 12; $i++){

for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "����"; 
    }elseif($i == 1){

 //   if($i == 1){
        $select_month[1] = "���"; 
    }else{  
        $select_month[$i] = $i."�����";
    }
}
$form->addElement("select", "form_pay_m", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

//��
for($i = 0; $i <= 29; $i++){
    if($i == 29){ 
        $select_day[$i] = '����'; 
    }elseif($i == 0){
        $select_day[null] = null; 
    }else{  
        $select_day[$i] = $i."��";
    }
}
$freeze_pay_d = $form->addElement("select", "form_pay_d", "���쥯�ȥܥå���", $select_day, $g_form_option_select);
$freeze_pay_d->freeze();

//��¾���顼�ξ���ɽ�����ʤ�
if($trade_err_flg != true && $claim_day_err_flg != true && $client_id_err_flg != true && $renew_data[0][0] != "t"){
	$form->addElement(
	        "button", "form_conf_button", "ʬ������",
	        //"onClick=\"Button_Submit('hdn_division_select','#', 't');\""
	        "onClick=\"Button_Submit('hdn_division_submit','#', 't');\" $disabled"
	);
}

// hidden
$form->addElement("hidden", "hdn_division_submit", "");
$form->addElement("hidden", "hdn_pay_m", "");
$form->addElement("hidden", "hdn_pay_d", "");
$form->addElement("hidden", "hdn_division_num", "");


/*
print_array($_POST);
*/


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
//$page_menu = Create_Menu_h('sale','2');
/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

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
    "division_set_flg"      => $division_set_flg,
    "division_err_flg"      => $division_err_flg,
    "ary_division_err_msg"  => $ary_division_err_msg,
    "division_comp_flg"     => $division_comp_flg,
    "division_flg"          => $division_flg,
    "freeze_flg"            => "$freeze_flg",
//    'aord_id'       => "$aord_id",
//    'input_flg'     => "$input_flg",
//    'order_sheet'   => "$order_sheet",
	'client_msg'    => "$client_msg",
	'renew_msg'     => "$renew_msg",
    'freeze_flg'    => "$freeze_flg",
));
$smarty->assign('item',$row_item);
$smarty->assign('row',$row_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
