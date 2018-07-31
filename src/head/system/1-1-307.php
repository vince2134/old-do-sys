<?php

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/12/14��      ��������suzuki��    �ڡ�����������
 *   2016/01/20                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "����Ĺ�������";
//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];
$staff_name = $_SESSION["staff_name"];

/****************************/
// �ե�����ǥե������
/****************************/
$def_fdata["form_state"] = "1";
$def_fdata["form_type"] = "3";
$form->setDefaults($def_fdata);

/****************************/
// �ե�����ѡ������
/****************************/
// ����
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "�����", "1");
$radio[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$radio[] =& $form->createElement("radio", null, null, "����", "3");
$radio[] =& $form->createElement("radio", null, null, "����", "4");
$form->addGroup($radio, "form_state", "");

//����Ĺ�
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "̤��Ͽ", "1");
//$radio[] =& $form->createElement("radio", null, null, "���Τ�", "1");
$radio[] =& $form->createElement("radio", null, null, "��Ͽ�Ѥ�", "2");
//$radio[] =& $form->createElement("radio", null, null, "����", "2");
$radio[] =& $form->createElement("radio", null, null, "����", "3");
$form->addGroup($radio, "form_type", "");

// ɽ�����
$hyoujikensuu_arr = array(
                        "10" => "10",
                        "50" => "50",
                        "100" => "100",
                        "all" => "����", 
                    );
$form->addElement("select", "hyoujikensuu", "ɽ�����", $hyoujikensuu_arr);

// ɽ���ܥ���
$form->addElement("button", "form_show_button", "ɽ����", "onClick=\"javascript:Button_Submit('show_button_flg','#','true', this)\"");

// ��Ͽ�ܥ���
$form->addElement("submit", "form_add_button", "�С�Ͽ", "$disabled");

// hidden
$form->addElement("hidden", "show_button_flg");

//�����ʬ
$select_value6 = Select_Get($db_con,'trade_aord');
$form->addElement('select', 'form_trade', '���쥯�ȥܥå���', $select_value6,$g_form_option_select);

//����
$sql1  = "SELECT";
$sql1 .= "   DISTINCT close_day";
$sql1 .= " FROM";
$sql1 .= "   t_client";
$sql1 .= " WHERE";
$sql1 .= "   client_div = '3'";
$sql1 .= "   AND";
$sql1 .= "   shop_id = $shop_id";
$sql1 .= ";";

$result = Db_Query($db_con, $sql1);
$num = pg_num_rows($result);
$select_value[null] = null;
for($i = 0; $i < $num; $i++){
    $client_close_day[] = pg_fetch_result($result, $i,0);
}

asort($client_close_day);
$client_close_day = array_values($client_close_day);

for($i = 0; $i < $num; $i++){
    if($client_close_day[$i] < 29 && $client_close_day[$i] != ''){
        $select_value[$client_close_day[$i]] = $client_close_day[$i]."��";
    }elseif($client_close_day[$i] != '' && $client_close_day[$i] >= 29){
        $select_value[$client_close_day[$i]] = "����";
    }
}
$form->addElement("select", "form_close_day", "", $select_value);

//
$form_bill_day[] = $form->createElement(
    "text","y","",
    "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_bill_day[y]','form_bill_day[m]',4)\" 
    onFocus=\"onForm_today(this,this.form,'form_bill_day[y]','form_bill_day[m]','form_bill_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_bill_day[] = $form->createElement(
    "text","m","","size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_bill_day[m]','form_bill_day[d]',2)\" 
    onFocus=\"onForm_today(this,this.form,'form_bill_day[y]','form_bill_day[m]','form_bill_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form_bill_day[] = $form->createElement(
    "text","d","",
    "size=\"2\" maxLength=\"2\" 
    style=\"$g_form_style\"
    onFocus=\"onForm_today(this,this.form,'form_bill_day[y]','form_bill_day[m]','form_bill_day[d]')\"
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_bill_day,"form_bill_day","", " - ");

//���顼�����ߥե�����
$form->addElement("text", "bill_amount_err");
$form->addElement("text", "bill_day_err");
$form->addElement("text", "bill_all_err");

//����Ƚ�̥ե饰
$form->addElement("hidden","renew_flg","1");
/****************************/
//�������Ĺ���Ͽ����
/****************************/
if($_POST["form_add_button"] == "�С�Ͽ"){
    $client_id      = $_POST["hdn_client_id"];         //������ID
    $claim_div      = $_POST["hdn_claim_div"];         //�������ʬ
    $bill_amount    = $_POST["form_bill_amount"];      //�������Ĺ�
    $bill_day       = $_POST["form_bill_day"];         //������
    $input_flg      = $_POST["hdn_input_flg"];         //���ϲ�ǽ�ե饰
    $claim_id       = $_POST["hdn_claim_id"];          //������ID

    //���ե����å�
    //Ⱦ�ѥ����å�
    if(!ereg("^[0-9]+$", $bill_day["y"]) || !ereg("^[0-9]+$", $bill_day["m"]) || !ereg("^[0-9]+$", $bill_day["d"])){
        $form->setElementError("bill_day_err","�������������դ������ǤϤ���ޤ���");
        $err_flg = true;
    }else{
        //���������������å�
        if(!checkdate($bill_day["m"],$bill_day["d"],$bill_day["y"])){
            $form->setElementError("bill_day_err","�������������դ������ǤϤ���ޤ���");
            $err_flg = true;
        //̤������դ�NG
        }elseif(date('Ymd') < date('Ymd', mktime(0,0,0,$bill_day["m"], $bill_day["d"], $bill_day["y"]))){
            $form->setElementError("bill_day_err","�������������դ������ǤϤ���ޤ���");
            $err_flg = true;
        //�����ƥ೫��������OR�������������NG
        }else{
            $err_mess = Sys_Start_Date_Chk($bill_day["y"], $bill_day["m"], $bill_day["d"], "��������");
            if($err_mess != null){
                $form->setElementError("form_close_day",$err_mess);
                $err_flg = true;
            }else{
                $sql = "SELECT MAX(close_day) FROM t_sys_renew WHERE renew_div = '2' AND shop_id = $shop_id;";
                $result = Db_Query($db_con, $sql);
                $close_day_last = (pg_fetch_result($result, 0, 0) != null) ? pg_fetch_result($result, 0, 0) : START_DAY;

                if($bill_day["y"]."-".$bill_day["m"]."-".$bill_day["d"] <= $close_day_last){
                    $form->setElementError("form_close_day","�������� �ϡ���������ǯ���� ���������դ����Ϥ��Ƥ���������");
                    $err_flg = true;
                }
            }
        }
    }

    //ɽ�����ʬ�롼��
    for($i = 0; $i < count($client_id); $i++){

/*
        //���ϲ�ǽ�ե饰�����Ƕ�ۤޤ��ϡ����դ����Ϥ�������˽�������    
        if(($bill_amount[$i] != null 
            || 
        ($bill_day[$i]["y"] != null || $bill_day[$i]["m"] != null || $bill_day[$i]["d"] != null))
            && 
        $input_flg[$i] == 't'){

            //���顼�����å�
            //���ϥ����å�
            if($bill_amount[$i] == null 
                || 
            $bill_day[$i]["y"] == null
                || 
            $bill_day[$i]["m"] == null
                || 
            $bill_day[$i]["d"] == null
            ){ 
                $form->setElementError("bill_all_err","�������Ĺ�����˶�ۤ����դ�ɬ�����ϤǤ���");
                $err_flg = true;
            }else{
                $input_data_flg = true;
            }

            //����Ĺ�Ⱦ�ѥ����å�
            if(!ereg("^[-]?[0-9]+$", $bill_amount[$i])){
                $form->setElementError("bill_amount_err","��ݽ���Ĺ�Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
                $err_flg = true;
            } 

            //��Ͽ�оݤΤǡ�����Ż���
            $add_client_id[]    = $client_id[$i];
            $add_claim_id[]     = $claim_id[$i];
            $add_claim_div[]    = $claim_div[$i];
            $add_bill_amount[]  = $bill_amount[$i];
            $add_bill_day[]     = $bill_day[$i];
            $add_claim_id[]     = $claim_id[$i];
        }
        $set_data["input_flg"][$i] = "";

*/
        if($bill_amount[$i] != null && $input_flg[$i] == 't'){
            //����Ĺ�Ⱦ�ѥ����å�
            if(!ereg("^[-]?[0-9]+$", $bill_amount[$i])){
                $form->setElementError("bill_amount_err","��ݽ���Ĺ�Ͽ��ͤΤ����ϲ�ǽ�Ǥ���");
                $err_flg = true;
            }

            //��Ͽ�оݤΤǡ�����Ż���
            $add_client_id[]    = $client_id[$i];
            $add_claim_id[]     = $claim_id[$i];
            $add_claim_div[]    = $claim_div[$i];
            $add_bill_amount[]  = $bill_amount[$i];
            $add_claim_id[]     = $claim_id[$i];    
        }
    }
    /********************************/
    //�͸���
    /********************************/
    if($form->validate() && $err_flg != true && count($add_client_id)> 0){

        /**********************************/
        //���Ϥ��줿�ǡ������ʬ��Ͽ
        /**********************************/
        Db_Query($db_con, "BEGIN;");

        for($i = 0; $i < count($add_client_id); $i++){

            $message = "��Ͽ���ޤ�����";

            //�����Ͽ������å�
            $sql  = "SELECT";
            $sql .= "   COUNT(t_bill_d.bill_d_id) \n";
            $sql .= "FROM\n";
            $sql .= "   t_bill\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_bill_d\n";
            $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id\n";
            $sql .= "WHERE\n";
            $sql .= "   t_bill.first_set_flg = 't'\n";
            $sql .= "   AND\n";
            $sql .= "   t_bill.shop_id = $shop_id\n";
            $sql .= "   AND\n";
            $sql .= "   t_bill_d.client_id = $add_client_id[$i]\n";

            $result = Db_Query($db_con, $sql);
            $add_count = pg_fetch_result($result,0,0);
            if($add_count > 0){
                $message = "";
                continue;
            }

            //������ֹ����    
            $sql  = "SELECT";
            $sql .= "   MAX(bill_no)\n";
            $sql .= "FROM";
            $sql .= "   t_bill\n";
            $sql .= "WHERE\n";
            $sql .= "   first_set_flg = 't'\n";
            $sql .= "   AND\n";
            $sql .= "   shop_id = $shop_id\n";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            $max_no = pg_fetch_result($result,0,0)+1;
            //��Ф���Ϣ�֤�8��ˤʤ�褦�˺�¦��0��᤹��
            $claim_sheet_no = str_pad($max_no, 8, 0, STR_PAD_LEFT);

            $sql  = "INSERT INTO t_bill(";
            $sql .= "   bill_id,";              //����ID
            $sql .= "   bill_no,";              //������ֹ�
            $sql .= "   fix_flg,";              //����ե饰
            $sql .= "   last_update_flg,";      //�����ե饰
            $sql .= "   last_update_day,";      //�����»���
            $sql .= "   create_staff_name,";    //����ǥǡ���������
            $sql .= "   fix_day,";              //������
            $sql .= "   shop_id,";              //�����ID
            $sql .= "   first_set_flg";         //�Ĺ�����ե饰
            $sql .= ")VALUES(";
            $sql .= "   (SELECT COALESCE(MAX(bill_id), 0)+1 FROM t_bill),";
            $sql .= "   '$claim_sheet_no',";
            $sql .= "   't',";
            $sql .= "   't',";
            $sql .= "   NOW(),";
            $sql .= "   '$staff_name',";
            $sql .= "   NOW(),";
            $sql .= "   $shop_id,";
            $sql .= "   't'";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                $err_message = pg_last_error();
                $err_format = "t_bill_bill_no_key";
                Db_Query($db_con, "ROLLBACK");

                //����NO����ʣ�������
                if(strstr($err_message,$err_format) !== false){
                    $error = "Ʊ��������Ĺ��Ԥä����ᡢ��Ͽ�Ǥ��ޤ���Ǥ������������ꤷ�Ƥ���������";
                    $duplicate_err = true;
                    break;
                }else{
                    exit;
                }
            }

            //����ǡ�������Ͽ
            $sql  = "INSERT INTO t_bill_d(";
            $sql .= "   bill_d_id,";
            $sql .= "   bill_id,";
            $sql .= "   bill_close_day_this,";
            $sql .= "   client_id,";
            $sql .= "   claim_div,";
            $sql .= "   bill_amount_this";
            $sql .= ")VALUES(";
            $sql .= "   (SELECT COALESCE(MAX(bill_d_id),0)+1 FROM t_bill_d),";
            $sql .= "   (SELECT";
            $sql .= "       bill_id";
            $sql .= "   FROM";
            $sql .= "       t_bill";
            $sql .= "   WHERE";
            $sql .= "       shop_id = $shop_id";
            $sql .= "       AND";
            $sql .= "       bill_no = '$claim_sheet_no'";
            $sql .= "       AND";   
            $sql .= "       first_set_flg = 't'";
            $sql .= "   ),";
            //$sql .= "   '".$add_bill_day[$i]["y"]."-".$add_bill_day[$i]["m"]."-".$add_bill_day[$i]["d"]."',";
            $sql .= "   '".$bill_day["y"]."-".$bill_day["m"]."-".$bill_day["d"]."',";
            $sql .= "   $add_client_id[$i],";
            $sql .= "   '$add_claim_div[$i]',";
            $sql .= "   $add_bill_amount[$i]";
            $sql .= ");";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
        Db_Query($db_con, "COMMIT;");
    }
}

/****************************/
//�����ǡ�������
/****************************/
//if($_POST["show_button_flg"] == true || $_POST["form_add_button"] == "�С�Ͽ"){
if($_POST["renew_flg"] == 1){

    $state       = $_POST["form_state"];        //����
    $claim_type  = $_POST["form_type"];         //����Ĺ�
    $kensu       = $_POST["hyoujikensuu"];      //ɽ�����
    $f_page1     = $_POST["f_page1"];           //�ڡ�����
    $close_day   = $_POST["form_close_day"];    //����
    $trade       = $_POST["form_trade"];        //�����ʬ

    //���֤Ρ����ơװʳ������ꤵ�줿���
    if($state != '4'){
        $where_sql .= "     AND\n";
        $where_sql .= "     t_client.state = $state\n";
    }

    //����Ĺ�Ρ�0�Τߡפ����ꤵ�줿���
    if($claim_type == '1'){
        $where_sql .= "     AND\n";
        $where_sql .= "     input_data.client_id IS NOT NULL\n";
    }elseif($claim_type == "2"){
        $where_sql .= "     AND\n";
        $where_sql .= "     input_data.client_id IS NULL\n";
    }

    //���������򤷤����
    if($close_day != null){
        $where_sql .= " AND\n";
        $where_sql .= " t_client.close_day = $close_day\n";
    }
    
    //�����ʬ�����򤷤����
    if($trade != null){
        $where_sql .= " AND\n";
        $where_sql .= " t_client.trade_id = $trade\n";
    }

    //ɽ����������    
    $sql_column  = "SELECT\n";
    $sql_column .= "   t_client.client_id,\n";
    $sql_column .= "   t_client.client_cd1||'-'||t_client.client_cd2,\n";
    $sql_column .= "   t_client.client_name,\n";
    $sql_column .= "   t_client.client_name2,\n";
    $sql_column .= "   t_claim.claim_id,\n";
    $sql_column .= "   claim_data.claim_cd1||'-'||claim_data.claim_cd2,\n";
    $sql_column .= "   claim_data.claim_name1,\n";
    $sql_column .= "   claim_data.claim_name2,\n";
    $sql_column .= "   t_claim.claim_div,\n";
    $sql_column .= "   COALESCE(bill_data.bill_amount_this,0) AS bill_amount_this, \n";
    $sql_column .= "   bill_data.bill_close_day_this,\n";
    $sql_column .= "   input_data.input_flg \n";

    $sql  = "FROM\n";
    $sql .= "   t_client\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_claim\n";
    $sql .= "   ON t_client.client_id = t_claim.client_id\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT DISTINCT\n";
    $sql .= "       t_claim.claim_id,\n";
    $sql .= "       t_client.client_cd1 AS claim_cd1,\n";
    $sql .= "       t_client.client_cd2 AS claim_cd2,\n";
    $sql .= "       t_client.client_name AS claim_name1,\n";
    $sql .= "       t_client.client_name2 AS claim_name2\n";
    $sql .= "   FROM\n";
    $sql .= "       t_claim\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_client\n";
    $sql .= "       ON t_claim.claim_id = t_client.client_id\n";
    $sql .= "   ) AS claim_data\n";
    $sql .= "   ON t_claim.claim_id = claim_data.claim_id\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_bill_d.client_id,\n";
    $sql .= "       t_bill_d.claim_div,\n";
    $sql .= "       t_bill_d.bill_amount_this,\n";
    $sql .= "       t_bill_d.bill_close_day_this\n";
    $sql .= "   FROM\n";
    $sql .= "       t_bill\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_bill_d\n";
    $sql .= "       ON t_bill.bill_id = t_bill_d.bill_id\n";
    $sql .= "   WHERE\n";
//    $sql .= "       t_bill.bill_no IS NULL\n";
    $sql .= "       t_bill.first_set_flg = 't'";
    $sql .= "   ) AS bill_data\n";
    $sql .= "   ON t_client.client_id = bill_data.client_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_claim.claim_div = bill_data.claim_div\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       t_client.client_id,\n";
    $sql .= "       t_claim.claim_div,\n";
    $sql .= "       't' AS input_flg\n";
    $sql .= "   FROM\n";
    $sql .= "       t_client\n";
    $sql .= "           INNER JOIN\n";
    $sql .= "       t_claim \n";
    $sql .= "       ON t_client.client_id = t_claim.client_id\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       t_sale_h\n";
    $sql .= "       ON t_client.client_id = t_sale_h.client_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_claim.claim_div = t_sale_h.claim_div\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       t_payin_h\n";
    $sql .= "       ON t_client.client_id = t_payin_h.client_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_claim.claim_div = t_payin_h.claim_div\n";
    $sql .= "           LEFT JOIN\n";
    $sql .= "       t_bill_d\n";
    $sql .= "       ON t_client.client_id = t_bill_d.client_id\n";
    $sql .= "       AND\n";
    $sql .= "       t_claim.claim_div = t_bill_d.claim_div\n";
    $sql .= "   WHERE\n";
    $sql .= "       t_sale_h.client_id IS NULL\n";
    $sql .= "       AND \n";
    $sql .= "       t_payin_h.client_id IS NULL\n";
    $sql .= "       AND\n";
    $sql .= "       t_bill_d.client_id IS NULL\n";
    $sql .= "       AND\n";
    $sql .= "       t_client.client_div = '3'\n";
    $sql .= "       AND\n";
    $sql .= "       t_client.shop_id = $shop_id\n";
    $sql .= "   ) AS input_data\n";
    $sql .= "   ON t_client.client_id = input_data.client_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_claim.claim_div = input_data.claim_div \n";
    $sql .= "WHERE\n";
    $sql .= "   t_client.client_div = '3'\n";
    $sql .= "   AND\n";
    $sql .= "   t_client.shop_id = $shop_id\n";
    $sql .= "   $where_sql";

    //����������
    $count_sql   = "SELECT COUNT(t_client.client_id) ";
    $result      = Db_Query($db_con, $count_sql.$sql.";");
    $total_count = pg_fetch_result($result, 0,0);

    //1�ڡ�����ɽ�����������ξ��
    if ($kensu == "all") {
        $range = $total_count;
    } else {
        $range = $kensu;
    }

    //���ߤΥڡ�����������å�����
    $page_info = Check_Page($total_count, $range, $f_page1);
    $page      = $page_info[0]; //���ߤΥڡ�����
    $page_snum = $page_info[1]; //ɽ�����Ϸ��
    $page_enum = $page_info[2]; //ɽ����λ���

	//�ڡ����ץ������ɽ��Ƚ��
	if($page == 1){
		//�ڡ����������ʤ�ڡ����ץ���������ɽ��
		$c_page = NULL;
	}else{
		//�ڡ�����ʬ�ץ�������ɽ��
		$c_page = $page;
	}

    //�ڡ�������
    $html_page  = Html_Page($total_count,$c_page,1,$range);
    $html_page2 = Html_Page($total_count,$c_page,2,$range);

    //ɽ���ǡ�������
    $offset = $page_snum-1; //ɽ�����ʤ����
    $limit  = ($page_enum - $page_snum) +1;    //��ڡ���������η��

    $sql_another = "ORDER BY t_client.client_cd1, t_client.client_cd2, t_claim.claim_div\n";
    
    $sql .= "   $where_sql";
    if ($kensu != "all") {
        $sql_another .= "LIMIT $limit OFFSET $offset ";
    }

    $result = Db_Query($db_con, $sql_column.$sql.$sql_another.";");
    $page_data = Get_Data($result);
    $data = pg_fetch_all($result);
}

/****************************/
//���ʬ�ե��������
/****************************/
for($i = 0; $i < count($page_data); $i++){

    //������ID
    $form->addElement("hidden", "hdn_client_id[$i]");
    $set_data[hdn_client_id][$i] = "";
    $set_data[hdn_client_id][$i] = $data[$i][client_id];

    //�������ʬ
    $form->addElement("hidden", "hdn_claim_div[$i]");
    $set_data[hdn_claim_div][$i] = "";
    $set_data[hdn_claim_div][$i] = $data[$i][claim_div];

    //���ϲ�ǽ�ե饰�����ξ��
    if($data[$i][input_flg] == 't'){
        $form->addElement(
            "text", "form_bill_amount[$i]", "", "class=\"money\" size=\"11\" maxLength=\"9\"
            $g_form_option style=\"text-align: right; $g_form_style\""
        );
/*
        $form_bill_day[$i][] = $form->createElement(
            "text","y","",
            "size=\"4\" maxLength=\"4\" 
            style=\"$g_form_style\"
            onkeyup=\"changeText(this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]',4)\" 
            onFocus=\"onForm_today(this,this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]','form_bill_day[$i][d]')\"
            onBlur=\"blurForm(this)\""
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","m","","size=\"2\" maxLength=\"2\" 
            style=\"$g_form_style\"
            onkeyup=\"changeText(this.form,'form_bill_day[$i][m]','form_bill_day[$i][d]',2)\" 
            onFocus=\"onForm_today(this,this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]','form_bill_day[$i][d]')\"
            onBlur=\"blurForm(this)\""
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","d","",
            "size=\"2\" maxLength=\"2\" 
            style=\"$g_form_style\"
            onFocus=\"onForm_today(this,this.form,'form_bill_day[$i][y]','form_bill_day[$i][m]','form_bill_day[$i][d]')\"
            onBlur=\"blurForm(this)\""
        );
        $form->addGroup( $form_bill_day[$i],"form_bill_day[$i]","", " - ");

        $set_data[form_bill_day][$i][y]    = "";
        $set_data[form_bill_day][$i][m]    = "";
        $set_data[form_bill_day][$i][d]    = "";
*/
        $set_data[form_bill_amount][$i] = "";
        //���ϲ�ǽ�ե饰
        $form->addElement("hidden", "hdn_input_flg[$i]");
        $set_data[hdn_input_flg][$i] = "";
        $set_data[hdn_input_flg][$i] = $data[$i][input_flg];
    }else{
        $form->addElement(
            "text", "form_bill_amount[$i]", "","size =\"13\"
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
/*
        $form_bill_day[$i][] = $form->createElement(
            "text","y","",
            "size=\"4\" maxLength=\"4\" 
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","m","","size=\"2\" maxLength=\"2\" 
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
        $form_bill_day[$i][] = $form->createElement(
            "text","d","",
            "size=\"2\" maxLength=\"2\" 
            style=\"text-align : right;
            border : #ffffff 1px solid;
            background-color: #ffffff;\"
            readonly"
        );
        $form->addGroup($form_bill_day[$i],"form_bill_day[$i]","", " - ");
*/
        $set_data[form_bill_amount][$i] = "";
        $set_data[form_bill_amount][$i] = number_format($data[$i][bill_amount_this]);
/*
        $set_date = explode("-",$data[$i][bill_close_day_this]);
        $set_data[form_bill_day][$i][y]    = ($set_date[0] != null)? $set_date[0] : "";
        $set_data[form_bill_day][$i][m]    = ($set_date[1] != null)? $set_date[1] : "";
        $set_data[form_bill_day][$i][d]    = ($set_date[2] != null)? $set_date[2] : "";
*/
        //���ϲ�ǽ�ե饰
        $form->addElement("hidden", "hdn_input_flg[$i]");
        $set_data[hdn_input_flg][$i] = "";
        $set_data[hdn_input_flg][$i] = 'f';

        $total_amount = $total_amount + $data[$i][bill_amount_this];
    }
    if($page_data[$i][0] == $page_data[$i-1][0]){
        $page_data[$i][0] = "";
        $page_data[$i][1] = "";
        $page_data[$i][2] = "";
        $page_data[$i][3] = "";
    }
}

//��Ф����ͤ�ե�����˥��å�
$form->setConstants($set_data);

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
$page_menu = Create_Menu_f('system','3');

/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$smarty->register_modifier("number_format","number_format");
$smarty->register_modifier("stripslashes","stripslashes");
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
    'auth_r_msg'    => "$auth_r_msg",
    'total_amount'  => "$total_amount",
    'message'       => "$message",
    'match_count'   => "$match_count",
    'page_snum'     => "$page_snum",
));

$smarty->assign("page_data", $page_data);


//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
