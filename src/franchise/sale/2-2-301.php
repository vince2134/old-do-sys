<?php
/****************************/
// ���ѹ�����
//      ����ǡ����Τʤ��������������ˤĤ���������������ʤ��Х�������watanabe-k��
//      (20060929)�Х�������Ģ'0021'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0022'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0023'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0024'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0025'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0026'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0027'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0028'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0029'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0030'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0031'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0032'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0033'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0034'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0035'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0036'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0037'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0038'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0039'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0040'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0041'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0042'�ν�����watanabe-k��
//      (20060930)�Х�������Ģ'0043'�ν�����watanabe-k��
/****************************/
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/20��04-001��������watanabe-�� 7��ʬ�����ṹ���塢8��ʬ���������������ȡ���������ۡפ��������ʤ��Х��ν�����            
 * ��2006/10/20��04-002��������watanabe-�� 7��ʬ�����ṹ���塢8��ʬ���������������ȡֺ�����ʧ�ۡפ��������ʤ��Х��ν�����            
 * ��2006/10/23��04-011��������watanabe-�� �����������Ƥ��ʤ��ǡ��������ä���������ǡ�����������Ƥ��ޤ��Х��ν���            
 * ��2006/11/14��04-127��������watanabe-�� �����裱��������ꤷ����ǡ���������������������裲������񤬺�������Ƥ��ʤ��Х��ν���            
 * ��2006/11/14��04-128��������watanabe-�� �����裱��������ꤷ����ǡ���������������������ʧ�ۤ���פ���Ƥ���Х��ν���
 * ��2006/12/04��ssl-0037������watanabe-�� ����񤬤ʤ��ˤ⤫����餺�����顼��ɽ�������Х��ν���
 * ��2006/12/04����Ŧ���ࡡ����watanabe-�� ���������Ȥ��������������å���ԤäƤ�������������򸫤�褦�˽���
 * ��2007/01/04����Ŧ���ࡡ����watanabe-�� ����ξ��Υ����å��ѹ�
 * ��2007/02/06����Ŧ���ࡡ����watanabe-�� �饸���ܥ����ʸ���ѹ�
 * ��2007/02/06����Ŧ���ࡡ����watanabe-�� ǯ��ʬ����
 * ��2007/02/14��        ������watanabe-�� �������Ǥν������ɲ�
 *   2007/03/23                watanabe-k  ô����Ź�Ǥιʤꤳ�ߵ�ǽ���ɲ�
 *   2007/04/04                watanabe-k  �ƻҴط���Ĥ��褦�˽���
 *   2007/04/10                watanabe-k  ���顼��å�������ɽ������褦�˽���
 *   2007/04/11                watanabe-k  �������ζ�ۤ���Ф���褦�˽���
 *   2007/04/16                watanabe-k  �����������˳���ե饰��t�ˤ���
 *   2007/04/17                watanabe-k  �ǹ���������ۤ���Ͽ
 *   2007/04/17                watanabe-k  �����Ĺ�η׻��򷫱ۻĹ���ǹ�����-��������+������������
 *   2007/05/08                watanabe-k  �о����ۤ���о����ѹ�
 *   2007/06/04                watanabe-k  ��������������Ф�������������Ǥ���褦�˽���
 *   2007/06/13                watanabe-k  ����ǡ���ID����ʣ����Х��ν��� 
 *   2007/06/19                watanabe-k��������������դ����դ����ϤǤ��ʤ��褦�˽��� 
 *   2007/06/21                watanabe-k��������ν������ɲ� 
 *   2007/07/03                watanabe-k�������������ˤ��ۤ����Ǥ����������������ʤ��褦�˽���
 *   2007/07/04                watanabe-k���������������å������������ʬ��ߤƤ��ʤ��Х��ν���
 *   2009/07/30                aoyama-n    ������̺����������������Ǻ����Ѥߤξ��˥��顼��å�������ɽ������ʤ��Х�������
 *   2009/12/29                aoyama-n    ��Ψ��TaxRate���饹�������
 *   2011/11/19                aoyama-n    mktime�ؿ�������ˡ�ν�����������������ݤ�������������Ǥ��ʤ��Х���
 *   2011/12/11                hashimoto-y ����ʧ����ХХ��ν���
 */

$page_title = "����ǡ�������";

//�Ķ�����ե�����
require_once("ENV_local.php");
//require_once("/usr/local/apache2/htdocs/amenity/function/sample_func_watanabe.inc");

//���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR.(basename($_SERVER[PHP_SELF].".inc")));
//����ؿ�
require_once(INCLUDE_DIR."seikyu.inc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null; 

/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];
$staff_id = $_SESSION["staff_id"];
$group_kind= $_SESSION["group_kind"];

unset($_SESSION["no_sheet_data"]);
unset($_SESSION["get_data"]);
unset($_SESSION["renew_data"]);
unset($_SESSION["made_data"]);

/****************************/
//���������
/****************************/
#2009-12-29 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

$def_data["form_slipout_type"] = '1';
$form->setDefaults($def_data);

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
//ȯ�Է���
$r_value = array("����������","������̺���");
for($i = 0; $i < 2; $i++){
    $radio = "";
    $radio[] =& $form->createElement( "radio",NULL,NULL, $r_value[$i],$i+1,"onClick=\"Text_Disabled($i+1);\"");
    $form->addGroup( $radio, "form_slipout_type[]", "");
}

//�����ȯ����
//ô����Ź
$branch_value = Select_Get($db_con,'branch');
$form->addElement('select', 'form_branch_id', '�ܻ�Ź', $branch_value, $g_form_option_select);

// ��������
//$select_value = Select_Get($db_con,'close');
$sql1  = "SELECT";
$sql1 .= "   DISTINCT close_day";
$sql1 .= " FROM";
$sql1 .= "   t_client";
$sql1 .= " WHERE";
$sql1 .= "   client_div = '1'";
$sql1 .= "   AND";
$sql1 .= "   shop_id = $shop_id";
$sql1 .= ";";

$result = Db_Query($db_con, $sql1);
$num = pg_num_rows($result);
$select_value[] = null;
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

$form_claim_day1[] =& $form->createElement(
    "text", "y", "", "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\" 
    onkeyup=\"changeText(this.form,'form_claim_day1[y]','form_claim_day1[m]',4)\" 
    onFocus=\"onForm_today2(this,this.form,'form_claim_day1[y]','form_claim_day1[m]')\"
    onBlur=\"blurForm(this)\""
);
$form_claim_day1[] =& $form->createElement(
        "static","","","ǯ"
        );    
$form_claim_day1[] =& $form->createElement(
    "text", "m", "", "size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\"  
    onkeyup=\"changeText(this.form,'form_claim_day1[m]','form_claim_day1[d]',4)\" 
    onFocus=\"onForm_today2(this,this.form,'form_claim_day1[y]','form_claim_day1[m]')\"
    onBlur=\"blurForm(this)\"");
$form_claim_day1[] =& $form->createElement(
        "static","","","��"
        );    
$form_claim_day1[] =& $form->createElement("select", "d", "", $select_value, $g_form_option_select);
$form->addGroup( $form_claim_day1, "form_claim_day1", "��������","");

//���ȯ����
// ��������
$form_claim_day2[] =& $form->createElement(
    "text", "y", "", "size=\"4\" maxLength=\"4\" 
    style=\"$g_form_style\" 
    onkeyup=\"changeText(this.form,'form_claim_day2[y]','form_claim_day2[m]',4)\" 
    onFocus=\"onForm_today2(this,this.form,'form_claim_day2[y]','form_claim_day2[m]')\"
     onBlur=\"blurForm(this)\""
);
$form_claim_day2[] =& $form->createElement(
        "static","","","ǯ"
        );    
$form_claim_day2[] =& $form->createElement(
    "text", "m", "", "size=\"1\" maxLength=\"2\" 
    style=\"$g_form_style\"  
    onkeyup=\"changeText(this.form,'form_claim_day2[m]','form_claim_day2[d]',2)\" 
    onFocus=\"onForm_today2(this,this.form,'form_claim_day2[y]','form_claim_day2[m]')\" 
    onBlur=\"blurForm(this)\"");
$form_claim_day2[] =& $form->createElement(
        "static","","","��"
        );
$form_claim_day2[] =& $form->createElement("text", "d", "", "size=\"3\" maxLength=\"2\" class=\"nborder\" readonly");

$form->addGroup( $form_claim_day2, "form_claim_day2", "��������","");

//������
$form->addElement(
        "link", "form_claim_link", "", "#", "������", 
        "onClick=\"javascript:return Open_SubWin('../dialog/2-0-250.php',Array('form_claim[cd1]', 'form_claim[cd2]', 'form_claim[name]', 'form_claim_day2[d]'), 550, 450,3,1)\"
");

$form_claim[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\"  style=\"$g_form_style\"
        onkeyup=\"javascript:Claim_Data_Set('form_claim[cd1]','form_claim[cd2]','form_claim[name]','form_claim_day2[d]');
        changeText(this.form,'form_claim[cd1]', 'form_claim[cd2]', 6)\"
        ".$g_form_option."\""
);
$form_claim[] =& $form->createElement(
        "static","","","-"
);      
$form_claim[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\"  style=\"$g_form_style\"
        onKeyUp=\"javascript:Claim_Data_Set('form_claim[cd1]','form_claim[cd2]','form_claim[name]','form_claim_day2[d]')\"
        ".$g_form_option."\""
);
$form_claim[] =& $form->createElement(
        "text","name","","size=\"34\" 
        $g_text_readonly"
);      
$form->addGroup( $form_claim, "form_claim", "");

$code_value = Create_Claim_Close_Day_Js($db_con);

$form->addElement(
    "button", 
    "form_create_button", 
    "���", 
    "onClick=\"Dialog_Double_Post_Prevent('form_create_button', 'hdn_button_flg', 'true', '�������ޤ���')\" $disabled"
);
$form->addElement("hidden", "hdn_button_flg");


//���ꤵ�줿������ȷ�ӤĤ�������Υǡ��������
$sql  = "SELECT\n";
$sql .= "   t_client.client_id,\n";
$sql .= "   t_claim.claim_div,\n";
$sql .= "   COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."') AS client_close_day \n";
$sql .= "FROM\n";
$sql .= "   t_claim\n";
$sql .= "       INNER JOIN\n";
$sql .= "   t_client\n";
$sql .= "   ON t_claim.client_id = t_client.client_id\n";
$sql .= "       LEFT JOIN\n";
$sql .= "   t_bill_d\n";
$sql .= "   ON t_client.client_id = t_bill_d.client_id\n";
$sql .= "   AND\n";
$sql .= "   t_bill_d.claim_div = (SELECT claim_div FROM t_claim WHERE client_id = t_bill_d.client_id AND claim_id = $1 )\n";
$sql .= "WHERE\n";
$sql .= "   t_claim.claim_id = $1 \n";
//$sql .= "   AND\n";
//$sql .= "   t_client.state = '1' \n";
$sql .= "GROUP BY t_client.client_id, t_claim.claim_div, t_client.client_cd1, t_client.client_cd2\n";
$sql .= "ORDER BY t_client.client_cd1, t_client.client_cd2";
$sql .= ";\n";

$sql = "PREPARE close_day_data(int) AS $sql ";
Db_Query($db_con, $sql);

/**********************************************************/
//PREPEAR�Ѥ�SQL�����
//���ꤵ�줿������ȷ�ӤĤ�������Υǡ��������
//��������������
//�����������ǡ������
//��������������
//�������������(������β���ñ�̤���ɼñ�̤ξ��˻���)
//�������������(������β���ñ�̤�����ñ�̤ξ��˻���)
//��ʬ����������
//��ʬ������Ĺ����
/**********************************************************/
$sql  = "SELECT \n";
$sql .= "   t_client.client_id, \n";                                //[5-1]�����ID
$sql .= "   t_client.client_cd1,\n";                                //[5-2]����襳���ɣ�
$sql .= "   t_client.client_cd2,\n";                                //[5-3]����襳���ɣ�
$sql .= "   t_client.client_name,\n";                               //[5-4]�����̾
$sql .= "   t_client.client_name2,\n";                              //[5-5]�����̾��
$sql .= "   t_client.client_cname,\n";                              //[5-6]ά��
$sql .= "   t_client.c_tax_div,\n";                                 //[5-7]���Ƕ�ʬi
$sql .= "   t_client.tax_franct,\n";                                //[5-8]�����ǡ�ü����
$sql .= "   t_client.claim_out,\n";                                 //[5-9]��������
$sql .= "   t_claim.claim_div,\n";                                  //[5-10]�������ʬ
$sql .= "   t_client.coax,\n";                                      //[5-12]��ۡʤޤ���ʬ��
$sql .= "   t_client.close_day,\n";                                 //[5-13]����
$sql .= "   last_claim_data.bill_close_day_last,\n";                //[6-1]������������AS��������������
$sql .= "   t_client.post_no1,\n";
$sql .= "   t_client.post_no2,\n";
$sql .= "   t_client.address1,\n";
$sql .= "   t_client.address2,\n";
$sql .= "   t_client.address3,\n";
$sql .= "   t_client.slip_out,\n";
$sql .= "   t_client.ware_id,\n";
$sql .= "   COALESCE(last_claim_data.bill_amount_last,0) AS bill_amount_last,\n";                   //[6-2]��������ۡ�AS�����������
$sql .= "   COALESCE(last_claim_data.payment_last,0) AS payment_last,\n";                           //[6-3]�����ʧ�ۡ�AS�������ʧ��
$sql .= "   last_claim_data.payment_extraction_s,\n";                                               //[6-4]��ʧͽ�����д��֡ʽ�λ��AS����ʧͽ�����д��֡ʳ��ϡ�
//�������ʬ�����ơ���������إå������ID��NULL�Υǡ���
$sql .= "   COALESCE(money_received_data1.pay_amount, 0) AS pay_amount,\n";                         //[7-1]SUM�ʶ�ۡˡ�AS�����������
//�������ʬ��Ĵ���ۤΤ�
$sql .= "   COALESCE(money_received_data2.tune_amount, 0) AS tune_amount, \n";                      //[7-2]SUM�ʶ�ۡˡ�AS��Ĵ����
//���ݼ����+�ȥޥ��ʥ��ζ�ʬ�ˤ�����
$sql .= "   COALESCE(sale_data1.receivable_net_amount, 0) AS receivable_net_amount, \n";            //[8-1]SUM (����ۡ���ȴ��)
$sql .= "   COALESCE(sale_data1.receivable_tax_amount, 0) AS receivable_tax_amount,\n";             //[8-2]SUM�ʾ����ǳۡ�
$sql .= "   COALESCE(sale_data2.taxation_amount, 0) AS taxation_amount,\n";                         //[9-1]SUM (�����)�������Ƕ�ʬ�����
$sql .= "   COALESCE(sale_data2.notax_amount, 0) AS notax_amount,\n";                               //[9-2]SUM (�����)�������Ƕ�ʬ�������
//���������ǥǡ��������
$sql .= "   COALESCE(sale_data3.installment_net_amount, 0) AS installment_net_amount, \n";          //[8-4]SUM������ۡ���ȴ�ˡ�AS���������������(��ȴ)
$sql .= "   COALESCE(sale_data3.installment_tax_amount, 0) AS installment_tax_amount,\n";           //[8-5]SUM�ʾ����ǳۡ� AS���������ξ����ǳ�
$sql .= "   COALESCE(sale_data1.sales_slip_num, 0) + COALESCE(sale_data3.sales_slip_num, 0) AS sales_slip_num \n";    //[8-3]+[8-6]��ɼ���
$sql .= "FROM\n";
$sql .= "   t_client\n";
$sql .= "        INNER JOIN\n";
$sql .= "   t_claim\n";
$sql .= "   ON t_client.client_id = t_claim.client_id \n";
$sql .= "   AND\n";
$sql .= "   t_claim.claim_id = $1 \n";
$sql .= "   AND\n";
$sql .= "   t_client.client_id = $6\n";
$sql .= "       LEFT JOIN\n";

//-----------------------------------------------------------------------------------------
//���������ǡ���
//-----------------------------------------------------------------------------------------
$sql .= "   (SELECT \n";
$sql .= "       MAX(t_bill_d.bill_d_id), \n";                               
$sql .= "       t_bill_d.client_id, \n";                                    
$sql .= "       t_bill_d.bill_close_day_this AS bill_close_day_last, \n";   //������������
$sql .= "       t_bill_d.bill_amount_this AS bill_amount_last,\n";          //���������
//$sql .= "       t_bill_d.payment_this AS payment_last,\n";                  //������ʧ��


//����Υǡ����λĹ⤬���ˣ��ξ������󤪻�ʧ�ۤϣ�
$sql .= "       CASE t_bill_d.collect_bill_d_id ";
$sql .= "           WHEN 0 THEN 0 ";
$sql .= "           ELSE t_bill_d.payment_this ";
$sql .= "       END AS payment_last, ";



$sql .= "       t_bill_d.payment_extraction_e AS payment_extraction_s\n";   //��ʧͽ�����д��֡ʳ��ϡ�
$sql .= "   FROM \n";

$sql .= "       t_bill_d \n";
$sql .= "   WHERE \n";
$sql .= "       t_bill_d.claim_div = $5\n";
$sql .= "       AND\n";
$sql .= "       t_bill_d.bill_close_day_this = $4\n";
$sql .= "       AND\n";
$sql .= "       t_bill_d.client_id = $6\n";
$sql .= "   GROUP BY\n";
$sql .= "       t_bill_d.client_id,\n";
$sql .= "       t_bill_d.bill_close_day_this,\n";
$sql .= "       t_bill_d.bill_amount_this,\n";
$sql .= "       t_bill_d.payment_this,\n";
$sql .= "       t_bill_d.payment_extraction_e,\n";
$sql .= "       t_bill_d.collect_bill_d_id\n";
$sql .= "   ) AS last_claim_data\n";
$sql .= "   ON t_client.client_id = last_claim_data.client_id\n";
$sql .= "       LEFT JOIN\n";
//-----------------------------------------------------------------------------------------
//���������
//-----------------------------------------------------------------------------------------

$sql .= "   ( \n";
$sql .= "    SELECT \n";
$sql .= "        t_payin.client_id,\n";
$sql .= "        COALESCE(SUM(t_payin.amount), 0)  AS pay_amount\n";
$sql .= "    FROM \n";
$sql .= "        ( \n";
//    --����ǡ�����������
$sql .= "        SELECT \n";
$sql .= "            t_payin_h.client_id, \n";
$sql .= "            t_payin_d.amount \n";
$sql .= "        FROM \n";
$sql .= "            t_payin_h \n";
$sql .= "                INNER JOIN \n";
$sql .= "            t_payin_d \n";
$sql .= "            ON t_payin_h.pay_id = t_payin_d.pay_id \n";
$sql .= "            AND t_payin_h.payin_div = '1' \n";
$sql .= "        WHERE \n";
$sql .= "            t_payin_h.shop_id = $shop_id \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.client_id = $6 \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.renew_flg = 't' \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.pay_day > $4 \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.pay_day <= $2 \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.claim_div = $5\n";
$sql .= "            AND \n";
//$sql .= "            t_payin_h.sale_id IS NULL\n";
$sql .= "            t_payin_d.trade_id != '39'\n";
$sql .= "        UNION ALL \n";
//    --����ʬ���ǡ�����������
$sql .= "        SELECT \n";
$sql .= "            t_payallocation_d.client_id,\n";
$sql .= "            t_payallocation_d.amount \n";
$sql .= "        FROM \n";
$sql .= "            t_payin_h \n";
$sql .= "                INNER JOIN \n";
$sql .= "            t_payallocation_d \n";
$sql .= "            ON t_payin_h.pay_id = t_payallocation_d.pay_id \n";
$sql .= "            AND t_payin_h.payin_div = '2' \n";
$sql .= "        WHERE \n";
$sql .= "            t_payin_h.shop_id = $shop_id \n";
$sql .= "            AND \n";
$sql .= "            t_payallocation_d.client_id = $6 \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.renew_flg = 't' \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.pay_day > $4 \n";
$sql .= "            AND \n";
$sql .= "            t_payin_h.pay_day <= $2 \n";
$sql .= "            AND \n";
$sql .= "            t_payallocation_d.claim_div = $5\n";
$sql .= "        ) AS t_payin \n";
$sql .= "    GROUP BY\n";
$sql .= "        client_id\n";
$sql .= "   ) AS money_received_data1 \n";
$sql .= "   ON t_client.client_id = money_received_data1.client_id\n";
$sql .= "       LEFT JOIN\n";

//-----------------------------------------------------------------------------------------
//Ĵ����
//-----------------------------------------------------------------------------------------
$sql .= "   (SELECT \n";
$sql .= "       t_payin_h.client_id,\n";
$sql .= "       COALESCE(SUM(t_payin_d.amount),0) AS tune_amount\n";
$sql .= "   FROM\n";
$sql .= "       t_payin_h\n";
$sql .= "           INNER JOIN\n";
$sql .= "       t_payin_d \n";
$sql .= "       ON t_payin_h.pay_id = t_payin_d.pay_id\n";
$sql .= "   WHERE\n";
$sql .= "       t_payin_h.pay_day > $4\n";
$sql .= "       AND \n";
$sql .= "       t_payin_h.pay_day <= $2 \n";
$sql .= "       AND \n";
$sql .= "       t_payin_h.claim_div = $5\n";
$sql .= "       AND \n";
$sql .= "       t_payin_h.client_id = $6\n";
$sql .= "       AND\n";
$sql .= "       t_payin_d.trade_id = 38 \n";
$sql .= "   GROUP BY t_payin_h.client_id\n";

$sql .= "   ) AS money_received_data2\n";
$sql .= "   ON t_client.client_id = money_received_data2.client_id\n";
$sql .= "       LEFT JOIN\n";
//-----------------------------------------------------------------------------------------
//�������ۡʳݼ����
//-----------------------------------------------------------------------------------------
            //-----------------------------------------------------------------------------
            //��ȴ��۹�ס������ǹ��
            //-----------------------------------------------------------------------------
$sql .= "   (SELECT\n";
$sql .= "       t_sale_h.client_id,\n";
$sql .= "       COALESCE(SUM(t_sale_h.net_amount * CASE WHEN t_sale_h.trade_id=11 THEN 1 ELSE -1 END),0) AS receivable_net_amount, \n";
$sql .= "       COALESCE(SUM(t_sale_h.tax_amount * CASE WHEN t_sale_h.trade_id=11 THEN 1 ELSE -1 END),0) AS receivable_tax_amount, \n";
$sql .= "       COALESCE(COUNT(t_sale_h.sale_id),0) AS sales_slip_num \n";
$sql .= "   FROM\n";
$sql .= "       t_sale_h\n";
$sql .= "   WHERE\n";
$sql .= "       t_sale_h.claim_day > $4\n"; 
$sql .= "       AND \n";
$sql .= "       t_sale_h.claim_day <= $2 \n";
$sql .= "       AND \n";
$sql .= "       t_sale_h.claim_div = $5\n";
$sql .= "       AND \n";
$sql .= "       t_sale_h.client_id = $6\n";
$sql .= "       AND\n";
$sql .= "       t_sale_h.trade_id IN (11,13,14) \n";
$sql .= "       GROUP BY t_sale_h.client_id \n";
$sql .= "   ) AS sale_data1 \n";
$sql .= "   ON t_client.client_id = sale_data1.client_id\n";
$sql .= "       LEFT JOIN\n";
            //-----------------------------------------------------------------------------
            //���Ƕ�۹�ס�����Ƕ�۹��
            //-----------------------------------------------------------------------------
$sql .= "   (SELECT\n";
$sql .= "       t_sale_h.client_id,\n";
$sql .= "       COALESCE(\n";
$sql .= "           SUM(\n";
$sql .= "               CASE\n";
$sql .= "                   WHEN t_sale_d.tax_div = '1' THEN t_sale_d.sale_amount * \n";
$sql .= "                   CASE\n";
$sql .= "                       WHEN t_sale_h.trade_id = 11 THEN 1\n";
$sql .= "                       ELSE -1\n";
$sql .= "                   END\n";
$sql .= "               END\n";
$sql .= "           )\n";
$sql .= "       ,0) AS taxation_amount,\n";                 
$sql .= "       COALESCE(\n";
$sql .= "           SUM(\n";
$sql .= "               CASE\n";
$sql .= "                   WHEN t_sale_d.tax_div = '3' THEN t_sale_d.sale_amount *\n";
$sql .= "                       CASE\n";
$sql .= "                           WHEN t_sale_h.trade_id = 11 THEN 1 \n";
$sql .= "                           ELSE -1\n";
$sql .= "                       END\n";
$sql .= "                   END\n";
$sql .= "               )\n";
$sql .= "           ,0) AS notax_amount\n";
$sql .= "   FROM\n";
$sql .= "       t_sale_h\n";
$sql .= "           INNER JOIN\n";
$sql .= "       t_sale_d\n";
$sql .= "       ON t_sale_h.sale_id = t_sale_d.sale_id\n";
$sql .= "   WHERE\n";
$sql .= "       t_sale_h.claim_day > $4";
$sql .= "       AND\n";
$sql .= "       t_sale_h.claim_day <= $2\n";
$sql .= "       AND\n";
$sql .= "       t_sale_h.claim_div = $5\n";
$sql .= "       AND \n";
$sql .= "       t_sale_h.client_id = $6\n";
$sql .= "       AND \n";
$sql .= "       t_sale_h.trade_id IN (11,13,14) \n";
$sql .= "   GROUP BY t_sale_h.client_id \n";
$sql .= "   ) AS sale_data2\n";
$sql .= "   ON t_client.client_id = sale_data2.client_id\n";
$sql .= "       LEFT JOIN\n";
//-----------------------------------------------------------------------------------------
//�������ۡʳ�������
//-----------------------------------------------------------------------------------------
$sql .= "    (SELECT\n";
$sql .= "       t_sale_h.client_id,\n";
$sql .= "       COALESCE(SUM(t_sale_h.net_amount),0) AS installment_net_amount,\n";
$sql .= "       COALESCE(SUM(t_sale_h.tax_amount),0) AS installment_tax_amount,\n";
$sql .= "       COALESCE(COUNT(t_sale_h.sale_id),0) AS sales_slip_num \n";
$sql .= "   FROM\n";
$sql .= "       t_sale_h\n";
$sql .= "   WHERE\n";
$sql .= "       t_sale_h.claim_day > $4\n";
$sql .= "       AND\n";
$sql .= "       t_sale_h.claim_day <= $2\n";
$sql .= "       AND \n";
$sql .= "       t_sale_h.claim_div = $5\n";
$sql .= "       AND\n";
$sql .="        t_sale_h.client_id = $6\n";
$sql .= "       AND\n";
$sql .= "       t_sale_h.trade_id = 15\n";
$sql .= "   GROUP BY t_sale_h.client_id \n";
$sql .= "   ) AS sale_data3 \n";
$sql .= "   ON t_client.client_id = sale_data3.client_id\n";

$sql .= "ORDER BY";
$sql .= "   t_client.client_cd1, t_client.client_cd2 \n";
$sql .= ";\n";

$sql = "PREPARE claim_data(int, date, int, date, varchar, int) AS $sql ";
Db_Query($db_con, $sql);

//��������������        
$sql  = "SELECT \n";        
$sql .= "   t_client.close_day, \n";                //[1-1] ����
$sql .= "   t_client.pay_m, \n";                    //[1-2] ��ʧ���ʷ��
$sql .= "   t_client.pay_d, \n";                    //[1-3] ��ʧ��������
$sql .= "   t_client.client_cd1, \n";               //[1-4] ����襳����1
$sql .= "   t_client.client_cd2, \n";               //[1-5] ����襳����2
$sql .= "   t_client.client_name, \n";              //[1-6] �����1
$sql .= "   t_client.client_name2, \n";             //[1-7] �����2        
$sql .= "   t_client.client_cname, \n";             //[1-8] ά��        
$sql .= "   t_client.compellation, \n";             //[1-9] �ɾ�
$sql .= "   t_client.post_no1, \n";                 //[1-10] ͹���ֹ�1
$sql .= "   t_client.post_no2, \n";                 //[1-11] ͹���ֹ�2
$sql .= "   t_client.address1, \n";                 //[1-12] ����1
$sql .= "   t_client.address2, \n";                 //[1-13] ����2
$sql .= "   t_client.address3, \n";                 //[1-14] ����3
$sql .= "   t_claim_sheet.c_memo1, \n";             //[1-15] ����񥳥���1
$sql .= "   t_claim_sheet.c_memo2, \n";             //[1-16] ����񥳥���2
$sql .= "   t_claim_sheet.c_memo3, \n";             //[1-17] ����񥳥���3
$sql .= "   t_claim_sheet.c_memo4, \n";             //[1-18] ����񥳥���4
$sql .= "   t_claim_sheet.c_memo5, \n";             //[1-19] ����񥳥���5
$sql .= "   t_claim_sheet.c_memo6, \n";             //[1-20] ����񥳥���6
$sql .= "   t_claim_sheet.c_memo7, \n";             //[1-21] ����񥳥���7
$sql .= "   t_claim_sheet.c_memo8, \n";             //[1-22] ����񥳥���8
$sql .= "   t_claim_sheet.c_memo9, \n";             //[1-23] ����񥳥���9
$sql .= "   t_claim_sheet.c_memo10, \n";            //[1-24] ����񥳥���10
$sql .= "   t_claim_sheet.c_memo11, \n";            //[1-25] ����񥳥���11
$sql .= "   t_claim_sheet.c_memo12, \n";            //[1-26] ����񥳥���12
$sql .= "   t_claim_sheet.c_memo13, \n";            //[1-27] ����񥳥���13
$sql .= "   t_client.claim_send, \n";               //[1-28] ���������
$sql .= "   t_client.tax_div, \n";                  //[1-29] �����ǡʲ���ñ�̡�
$sql .= "   t_client.c_tax_div, \n";                //[1-30] ���Ƕ�ʬ
$sql .= "   t_client.tax_franct, \n";               //[1-31] �����ǡ�ü����
$sql .= "   t_client.coax, \n";                     //[1-32] ��ۡʤޤ���ʬ��
$sql .= "   t_client.pay_way, \n";                  //[1-33] ������ˡ
$sql .= "   t_staff.charge_cd, \n";                 //[1-34] ô���ԥ����ɡʷ���ô����1��
$sql .= "   t_staff.staff_name, \n";                //[1-35] �����å�̾�ʷ���ô��1��
//���Ϥ��줿����������1�����������������������������������������ξ����θ�������������դ����
$sql .= "   CASE WHEN pay_d = 29 THEN \n";        //[1-36] ���ͽ����
$sql .= "       SUBSTR(TO_DATE(SUBSTR($1, 1, 8) || 01, 'YYYY-MM-DD')\n";
$sql .= "           +\n";
$sql .= "       ((CAST(pay_m AS int) + 1) * interval '1 month') - interval '1 day', 1, 10)\n";
$sql .= "   ELSE\n";
$sql .= "       SUBSTR(TO_DATE($1, 'YYYY-MM-DD') + (CAST(pay_m AS int) * interval '1 month'), 1, 8)\n";
$sql .= "           || \n";
$sql .= "   LPAD(pay_d, 2, 0) \n";
//$sql .= "   END AS after_pay_d,\n";
$sql .= "   END AS next_close_day, \n";
//���Ϥ��줿�������������ʧ���ʷ�˸�λ�ʧ�������ˡ�����ʧ�������ˤ������ξ����θ�������������դ����
$sql .= "   CASE WHEN close_day = 29 THEN \n";    //[1-37] ��ʧͽ�����д��֡ʽ�λ��
$sql .= "       SUBSTR(TO_DATE(SUBSTR($1, 1, 8) || 01, 'YYYY-MM-DD') \n";
$sql .= "           + interval '2 month' - interval '1 day', 1, 10) \n";
$sql .= "       ELSE \n";
$sql .= "       SUBSTR(TO_DATE($1, 'YYYY-MM-DD') + interval '1 month', 1, 8) \n";
$sql .= "           ||\n";
$sql .= "       LPAD(close_day, 2, 0) \n";
//$sql .= "   END AS next_close_day, \n";
$sql .= "   END AS after_pay_d,\n";
$sql .= "   t_claim_sheet.c_fsize1, \n";            //[1-27] ����񥳥���13
$sql .= "   t_claim_sheet.c_fsize2, \n";            //[1-27] ����񥳥���13
$sql .= "   t_claim_sheet.c_fsize3, \n";            //[1-27] ����񥳥���13
$sql .= "   t_claim_sheet.c_fsize4,  \n";            //[1-27] ����񥳥���13
$sql .= "   t_client.claim_out, \n";
$sql .= "   COALESCE(t_sys_renew.renew_close_day, '".START_DAY."') AS renew_day \n";
$sql .= "FROM \n";
$sql .= "   t_claim_sheet \n";
$sql .= "       INNER JOIN \n";
$sql .= "   t_client \n";
//$sql .= "   ON t_claim_sheet.shop_id = $shop_id\n";
//$sql .= "   AND\n";
$sql .="    ON t_client.c_pattern_id = t_claim_sheet.c_pattern_id\n";
$sql .= "   AND\n";
$sql .= "   t_client.client_id = $2\n";
$sql .= "       LEFT JOIN \n";
$sql .= "   t_staff\n";
$sql .= "   ON t_client.c_staff_id1 = t_staff.staff_id \n";
/*�ɲ�ʬ*/
$sql .= "       LEFT JOIN \n";
$sql .= "   (SELECT\n";
$sql .= "       claim_id,\n";
$sql .= "       MAX(close_day) AS renew_close_day \n";
$sql .= "   FROM\n";
//$sql .= "       t_sys_renew\n";
$sql .= "       t_bill_renew\n";
$sql .= "   GROUP BY claim_id\n";
$sql .= "    ) AS t_sys_renew\n";
$sql .= "   ON t_client.client_id = t_sys_renew.claim_id\n";

//$sql .= "WHERE\n";
$sql .= "; \n";
$sql = "PREPARE get_claim_data(date, int) AS $sql ";
Db_Query($db_con, $sql);
/*
//���ꤷ�����������������������Ƥ��ʤ����ޤ�������ǡ��������
//����ơ��֥�ι����ե饰��'��'�Υǡ��������
$sql  = "SELECT\n"; 
$sql .= "   pay_no,\n";
$sql .= "   '1' AS slip_div \n";
$sql .= " FROM\n";
$sql .= "   t_client";
$sql .= "       INNER JOIN ";
$sql .= "   t_claim";
$sql .= "   ON t_client.client_id = t_claim.client_id";
$sql .= "   AND t_claim.claim_id = $1";
$sql .= "       INNER JOIN ";
$sql .= "   t_payin_h\n";
$sql .= "   ON t_claim.client_id = t_payin_h.client_id";
$sql .= "   AND t_claim.claim_div = t_payin_h.claim_div";
$sql .= " WHERE\n";
$sql .= "   t_payin_h.pay_day >\n";
$sql .= "       (\n";
$sql .= "           SELECT\n";                                  //���ꤵ�줿������ˤҤ�Ť�
$sql .= "               COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."')\n";
$sql .= "           FROM\n";
$sql .= "               t_bill\n";
$sql .= "                   INNER JOIN\n";
$sql .= "               t_bill_d\n";
$sql .= "               ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "           WHERE\n";
$sql .= "               t_bill_d.client_id = t_payin_h.client_id\n";
$sql .= "               AND \n";
$sql .= "               t_bill_d.claim_div = t_payin_h.claim_div\n";
$sql .= "       )\n";
$sql .= "   AND\n";
$sql .= "   t_payin_h.pay_day <= $2\n";           //���ꤵ�줿��������
$sql .= "   AND\n"; 
$sql .= "   t_payin_h.shop_id = $shop_id\n";
$sql .= "   AND\n";
$sql .= "   t_payin_h.renew_flg = 'f'\n";

$sql .= " UNION ALL \n";

//���إå��ơ��֥�ι����ե饰��'f'�Υǡ��������
$sql .= "SELECT\n"; 
//$sql .= "   t_sale_h.client_id\n";
$sql .= "   t_sale_h.sale_no, \n";
$sql .= "   '2' AS slip_div \n";
$sql .= " FROM\n";
$sql .= "   t_sale_h\n";
$sql .= " WHERE\n";
$sql .= "   t_sale_h.claim_id = $1\n";              //���ꤷ��������ID
$sql .= "   AND\n";
$sql .= "   t_sale_h.renew_flg = 'f'\n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.shop_id = $shop_id\n";
$sql .= "   AND\n";
//$sql .= "   t_sale_h.claim_day >\n";
$sql .= "   t_sale_h.claim_day >\n";
$sql .= "       (\n";
$sql .= "           SELECT\n";
$sql .= "               COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."')\n";
$sql .= "           FROM\n";
$sql .= "               t_bill\n";
$sql .= "                   INNER JOIN\n";
$sql .= "               t_bill_d\n";
$sql .= "               ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "           WHERE\n";
$sql .= "               t_bill_d.client_id = t_sale_h.client_id\n";
$sql .= "       )\n";
$sql .= "   AND\n";
//$sql .= "   t_sale_h.claim_day <= $2\n";
$sql .= "   t_sale_h.claim_day <= $2\n";

$sql .= " UNION ALL \n";
//������ι����ե饰��'��'�Υǡ��������
$sql .= "SELECT\n";
$sql .= "   t_advance.advance_no, \n";
$sql .= "   '3' AS slip_div \n";
$sql .= "FROM ";
$sql .= "   t_advance ";
$sql .= "WHERE ";
$sql .= "   t_advance.claim_id = $1\n";
$sql .= "   AND \n";
$sql .= "   t_advance.fix_day IS NULL \n";
$sql .= "   AND \n";
$sql .= "   t_advance.shop_id = $shop_id \n";
$sql .= "   AND \n";
$sql .= "   t_advance.pay_day > \n";
$sql .= "       (\n";
$sql .= "           SELECT\n";
$sql .= "               COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."')\n";
$sql .= "           FROM\n";
$sql .= "               t_bill\n";
$sql .= "                   INNER JOIN\n";
$sql .= "               t_bill_d\n";
$sql .= "               ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "           WHERE\n";
$sql .= "               t_bill_d.client_id = t_advance.client_id\n";
$sql .= "       )\n";
$sql .= "   AND \n";
$sql .= "   t_advance.pay_day <= $2 \n";
*/

//���ꤷ�����������������������Ƥ��ʤ����ޤ�������ǡ��������
//����ơ��֥�ι����ե饰��'��'�Υǡ��������
$sql  = "SELECT\n"; 
$sql .= "   pay_no,\n";
$sql .= "   '1' AS slip_div \n";
$sql .= " FROM\n";
$sql .= "   t_client";
$sql .= "       INNER JOIN ";
$sql .= "   t_claim";
$sql .= "   ON t_client.client_id = t_claim.client_id";
$sql .= "   AND t_claim.claim_id = $1";
$sql .= "       INNER JOIN ";
$sql .= "   t_payin_h\n";
$sql .= "   ON t_claim.client_id = t_payin_h.client_id";
$sql .= "   AND t_claim.claim_div = t_payin_h.claim_div";
$sql .= " WHERE\n";
$sql .= "   t_payin_h.pay_day >\n";
$sql .= "       (\n";
$sql .= "           SELECT\n";                                  //���ꤵ�줿������ˤҤ�Ť�
$sql .= "               COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."')\n";
$sql .= "           FROM\n";
$sql .= "               t_bill\n";
$sql .= "                   INNER JOIN\n";
$sql .= "               t_bill_d\n";
$sql .= "               ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "           WHERE\n";
$sql .= "               t_bill_d.client_id = t_payin_h.client_id\n";
$sql .= "               AND \n";
$sql .= "               t_bill_d.claim_div = t_payin_h.claim_div\n";
$sql .= "       )\n";
$sql .= "   AND\n";
$sql .= "   t_payin_h.pay_day <= $2\n";           //���ꤵ�줿��������
$sql .= "   AND\n"; 
$sql .= "   t_payin_h.shop_id = $shop_id\n";
$sql .= "   AND\n";
$sql .= "   t_payin_h.renew_flg = 'f'\n";

$sql .= " UNION ALL \n";

//���إå��ơ��֥�ι����ե饰��'f'�Υǡ��������
$sql .= "SELECT\n"; 
//$sql .= "   t_sale_h.client_id\n";
$sql .= "   t_sale_h.sale_no, \n";
$sql .= "   '2' AS slip_div \n";
$sql .= " FROM\n";
$sql .= "   t_client";
$sql .= "       INNER JOIN ";
$sql .= "   t_claim";
$sql .= "   ON t_client.client_id = t_claim.client_id";
$sql .= "   AND t_claim.claim_id = $1";
$sql .= "       INNER JOIN ";
$sql .= "   t_sale_h\n";
$sql .= "   ON t_claim.client_id = t_sale_h.client_id";
$sql .= "   AND t_claim.claim_div = t_sale_h.claim_div";
$sql .= " WHERE\n";
$sql .= "   t_sale_h.renew_flg = 'f'\n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.shop_id = $shop_id\n";
$sql .= "   AND\n";
//$sql .= "   t_sale_h.claim_day >\n";
$sql .= "   t_sale_h.claim_day >\n";
$sql .= "       (\n";
$sql .= "           SELECT\n";
$sql .= "               COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."')\n";
$sql .= "           FROM\n";
$sql .= "               t_bill\n";
$sql .= "                   INNER JOIN\n";
$sql .= "               t_bill_d\n";
$sql .= "               ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "           WHERE\n";
$sql .= "               t_bill_d.client_id = t_sale_h.client_id\n";
$sql .= "               AND \n";
$sql .= "               t_bill_d.claim_div = t_sale_h.claim_div\n";
$sql .= "       )\n";
$sql .= "   AND\n";
//$sql .= "   t_sale_h.claim_day <= $2\n";
$sql .= "   t_sale_h.claim_day <= $2\n";

$sql .= " UNION ALL \n";
//������ι����ե饰��'��'�Υǡ��������
$sql .= "SELECT\n";
$sql .= "   t_advance.advance_no, \n";
$sql .= "   '3' AS slip_div \n";
$sql .= "FROM ";
$sql .= "   t_client";
$sql .= "       INNER JOIN ";
$sql .= "   t_claim";
$sql .= "   ON t_client.client_id = t_claim.client_id";
$sql .= "   AND t_claim.claim_id = $1";
$sql .= "       INNER JOIN ";
$sql .= "   t_advance\n";
$sql .= "   ON t_claim.client_id = t_advance.client_id";
$sql .= "   AND t_claim.claim_div = t_advance.claim_div ";
$sql .= "WHERE ";
$sql .= "   t_advance.fix_day IS NULL \n";
$sql .= "   AND \n";
$sql .= "   t_advance.shop_id = $shop_id \n";
$sql .= "   AND \n";
$sql .= "   t_advance.pay_day > \n";
$sql .= "       (\n";
$sql .= "           SELECT\n";
$sql .= "               COALESCE(MAX(t_bill_d.bill_close_day_this), '".START_DAY."')\n";
$sql .= "           FROM\n";
$sql .= "               t_bill\n";
$sql .= "                   INNER JOIN\n";
$sql .= "               t_bill_d\n";
$sql .= "               ON t_bill.bill_id = t_bill_d.bill_id\n";
$sql .= "           WHERE\n";
$sql .= "               t_bill_d.client_id = t_advance.client_id\n";
$sql .= "               AND \n";
$sql .= "               t_bill_d.claim_div = t_advance.claim_div\n";
$sql .= "       )\n";
$sql .= "   AND \n";
$sql .= "   t_advance.pay_day <= $2 \n";


$sql  = "PREPARE renew_flg_check(int ,date) AS $sql;";
//print_array($sql);
Db_Query($db_con,$sql);



//Ʊ����������ǡ�����������Ƥ����
$sql  = "SELECT \n";
$sql .= "   COUNT(bill_d_id) \n";
$sql .= "FROM \n";
$sql .= "   t_bill_d \n";
$sql .= "WHERE\n";
$sql .= "   t_bill_d.client_id = $1";
$sql .= "   AND\n";
$sql .= "   t_bill_d.bill_close_day_this = $2";
$sql .= "   AND\n";
$sql .= "   t_bill_d.claim_div = $3\n";
$sql .= ";\n";
$sql  = "PREPARE duplicate_date_check(int, date, varchar) AS $sql;";
Db_Query($db_con,$sql);

//������ƺ�����������̤�����Υǡ��������
$sql  = "SELECT\n";
$sql .= "   t_bill.claim_id,\n";
$sql .= "   t_bill.close_day \n";
$sql .= " FROM\n";
$sql .= "   t_bill\n";
$sql .= " WHERE\n";
$sql .= "   t_bill.claim_id = $1\n";
$sql .= "   AND\n";
$sql .= "   t_bill.shop_id = $2\n";
$sql .= "   AND\n";
$sql .= "   t_bill.last_update_flg = 'f'";
$sql .= ";\n";

$sql = "PREPARE nonupdate_count(int,int) AS $sql;";
Db_Query($db_con, $sql);

//�����ֹ��̾�Ϣ�֤��MAX(Ϣ��)+�������
$sql  = "SELECT\n";
$sql .= "   COALESCE(MAX(serial_num),0)+1\n";
$sql .= " FROM\n";
$sql .= "   t_bill_no_serial\n";
$sql .= " WHERE\n";
$sql .= "   shop_id = $1\n";
$sql .= ";\n";

$sql = "PREPARE get_no_serial(int) AS $sql;";
Db_Query($db_con, $sql);

//�����ֹ�ǯ��Ϣ�֤��MAX(Ϣ��)+�������
$sql  = "SELECT\n";
$sql .= "   COALESCE(MAX(serial_num),0)+1\n";
$sql .= " FROM\n";
$sql .= "   t_bill_no_y_serial\n";
$sql .= " WHERE\n";
$sql .= "   year = to_char(NOW(), 'YYYY')\n";
$sql .= "   AND\n";
$sql .= "   shop_id = $1\n";
$sql .= ";\n";

$sql  = "PREPARE get_no_y_serial(int) AS $sql;";
Db_Query($db_con, $sql);

//�����ֹ����Ϣ�֤��MAX(Ϣ��)+�������
$sql  = "SELECT\n";
$sql .= "   COALESCE(MAX(serial_num),0)+1\n";
$sql .= " FROM\n";
$sql .= "   t_bill_no_m_serial\n";
$sql .= " WHERE";
$sql .= "   month = to_char(NOW(), 'YYYYMM')\n";
$sql .= "   AND\n";
$sql .= "   shop_id = $1";
$sql .= ";";

$sql  = "PREPARE get_no_m_serial(int) AS $sql;";
Db_Query($db_con, $sql);

//��Ϣ�֥ơ��֥����Ͽ����SQL
//��Ϣ�֥ơ��֥����Ͽ����SQL
$sql  = "INSERT INTO t_bill_no_serial (";
$sql .= "   serial_num,";
$sql .= "   shop_id";
$sql .= ")VALUES(";
$sql .= "   $1,";
$sql .= "   $2";
$sql .= ");";

$sql  = "PREPARE insert_no_serial(int, int) AS $sql;";
Db_Query($db_con, $sql);

$sql  = "INSERT INTO t_bill_no_y_serial (";
$sql .= "   serial_num,";
$sql .= "   year,";
$sql .= "   shop_id";
$sql .= ")VALUES(";
$sql .= "   $1,";
$sql .= "   $2,";
$sql .= "   $3";
$sql .= ");";

$sql  = "PREPARE insert_no_y_serial(int, varchar, int) AS $sql;";
Db_Query($db_con, $sql);

$sql  = "INSERT INTO t_bill_no_m_serial (";
$sql .= "   serial_num,";
$sql .= "   month,";
$sql .= "   shop_id";
$sql .= ")VALUES(";
$sql .= "   $1,";
$sql .= "   $2,";
$sql .= "   $3";
$sql .= ");";

$sql  = "PREPARE insert_no_m_serial(int, varchar,int) AS $sql;";
Db_Query($db_con, $sql);

//������������Ͽ���Ƥ���������򥫥����
$sql  = "SELECT";
$sql .= "   COUNT(client_id) ";
$sql .= "FROM";
$sql .= "    t_client ";
$sql .= "WHERE";
$sql .= "   client_id IN (SELECT";
$sql .= "                   client_id";
$sql .= "               FROM";
$sql .= "                   t_claim";
$sql .= "               WHERE";
$sql .= "                   claim_id = $1";
$sql .= "               )";
$sql .= "   AND";
$sql .= "   claim_out = '1'";
$sql .= ";";

$sql  = "PREPARE bill_format_count(int) AS $sql;";
Db_Query($db_con, $sql);

//��Ͽ���������ID�����
$sql  = "SELECT";
$sql .= "   bill_id ";
$sql .= "FROM";
$sql .= "   t_bill ";
$sql .= "WHERE";
$sql .= "   bill_no = $1";
$sql .= "   AND";
$sql .= "   shop_id = $2";
$sql .= ";";

$sql  = "PREPARE get_bill_id(varchar,int) AS $sql;";
Db_Query($db_con, $sql);

//ʬ�������
//ʬ��Ĺ��
$sql  = "SELECT\n";
$sql .= "   COALESCE(SUM(split_bill_data1.split_bill_amount),0),\n";
$sql .= "   COALESCE(SUM(split_bill_data2.installment_receivable_balance),0)\n";
$sql .= "FROM\n";
$sql .= "   t_sale_h\n";
$sql .= "       LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "       sale_id,\n";
$sql .= "       COALESCE(SUM(t_installment_sales.collect_amount), 0) AS split_bill_amount\n";
$sql .= "   FROM\n";
$sql .= "       t_installment_sales\n";
$sql .= "   WHERE\n";
$sql .= "       t_installment_sales.collect_day <= $1\n";
//$sql .= "       AND\n";
//$sql .= "       t_installment_sales.collect_day > $4\n";

$sql .= "       AND \n";
$sql .= "       t_installment_sales.bill_id IS NULL \n";

$sql .= "   GROUP BY sale_id\n";
$sql .= "   ) AS split_bill_data1\n";
$sql .= "   ON t_sale_h.sale_id = split_bill_data1.sale_id\n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.claim_day <= $5\n";
$sql .= "       LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "       sale_id,\n";
$sql .= "       COALESCE(SUM(t_installment_sales.collect_amount), 0) AS installment_receivable_balance\n";
$sql .= "   FROM\n";
$sql .= "       t_installment_sales\n";
$sql .= "   WHERE\n";
$sql .= "       t_installment_sales.collect_day > $1\n";
$sql .= "   GROUP BY sale_id\n";
$sql .= "   ) AS split_bill_data2\n";
$sql .= "   ON t_sale_h.sale_id = split_bill_data2.sale_id \n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.claim_day <= $5\n";
$sql .= "WHERE\n";
$sql .= "   t_sale_h.client_id = $2\n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.trade_id = 15\n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.claim_div = (SELECT\n";
$sql .= "                           claim_div\n";
$sql .= "                       FROM\n";
$sql .= "                           t_claim\n";
$sql .= "                       WHERE\n";
$sql .= "                           client_id = t_sale_h.client_id\n";
$sql .= "                           AND\n";
$sql .= "                           claim_id = $3\n";
$sql .= "                       )\n";
$sql .= "   AND\n";
$sql .= "   t_sale_h.renew_flg = 't'\n";
$sql .= ";\n";

$sql  = "PREPARE get_split_amount(date,int, int, date, date) AS $sql";
Db_Query($db_con, $sql);

//�����ʧ�����
$sql  = "SELECT ";
//$sql .= "   SUM(t_bill_d.intax_amount) AS sum_intax_amount, ";                       //[19-1]SUM���ǹ����ۡ�
$sql .= "   SUM(t_bill_d.first_payment) AS sum_intax_amount, ";                       //[19-1]SUM���ǹ����ۡ�
$sql .= "   SUM(t_bill_d.installment_sales_amount) AS sum_installment_sales_amount "; //[19-2]SUM�ʳ������ۡ�
$sql .= "FROM\n";
$sql .= "   t_bill_d";
$sql .= "       INNER JOIN";
$sql .= "   t_bill";
$sql .= "   ON t_bill_d.bill_id = t_bill.bill_id";
$sql .= "   AND\n";
$sql .= "   t_bill_d.client_id = $1";             //[5-1]
$sql .= "   AND\n";
//$sql .= "   t_bill.collect_day > $2 ";
//$sql .= "   AND\n";
$sql .= "   t_bill.collect_day <= $3";
$sql .= "   AND ";
$sql .= "   collect_bill_d_id IS NULL ";


//�������������оȤȤ��ʤ�
$sql .= "   AND\n";
$sql .= "   t_bill_d.close_day IS NOT NULL\n";
$sql .= "   AND\n";
$sql .= "   t_bill_d.claim_div = $4";
$sql .= ";\n";

$sql  = "PREPARE get_all_amount(int, date, date, varchar) AS $sql";
Db_Query($db_con, $sql);


/****************************/
//�����ܥ��󲡲�����
/****************************/
//�����ܥ��󤬲����줿��硢�����ܥ��󲡲��ե饰��true�ˤ��롣
//$add_create_button_flg = ($_POST["form_create_button"] == "���")? true : false;
$add_create_button_flg = ($_POST["hdn_button_flg"] == "true")? true : false;

//�����ܥ��󲡲��ե饰��true�ξ��
if($add_create_button_flg == true){

    $set_data["hdn_button_flg"] = "";
    $form->setConstants($set_data);

    Db_Query($db_con, "BEGIN;");

    //ȯ�Է���
    $slipout_type = $_POST["form_slipout_type"][0];    //���ξ���1 ����ξ���2
}

/****************************/
//��������н���
/****************************/
//ȯ�Է��������ξ��
if($slipout_type == '1'){

    //����������Ⱦ�ѡ�ɬ�ܥ����å�
    $form->addGroupRule('form_claim_day1', array(
        'y' => array(
                array('�������������դ������ǤϤ���ޤ���','required'),
                array('�������������դ������ǤϤ���ޤ���','numeric')),
        'm' => array(
                array('�������������դ������ǤϤ���ޤ���','required'),
                array('�������������դ������ǤϤ���ޤ���','numeric')),
        'd' => array(
                array('�������������դ������ǤϤ���ޤ���','required')),
    ));

    //�ܻ�Ź
    $form->addRule("form_branch_id","�ܻ�Ź�����򤷤Ʋ�������","required");

    //POST����
    $close_day          = $_POST["form_claim_day1"]["d"];  //����
    $claim_close_day_y  = $_POST["form_claim_day1"]["y"];  //����������ǯ��
    $claim_close_day_m  = $_POST["form_claim_day1"]["m"];  //���������ʷ��
    $branch_id          = $_POST["form_branch_id"];        //�ܻ�Ź

    //������29�ʲ��ξ��
    if($close_day < 29){
        $claim_close_day_d = $close_day;
    //��������29�ʾ�ξ��
    }else{
        $claim_close_day_d = date('d', mktime(0, 0, 0, (int)$claim_close_day_m+1, 0, (int)$claim_close_day_y));
    }

    if($form->validate()){
        //�����0���
        $claim_close_day_y = str_pad($claim_close_day_y, 4, 0, STR_PAD_LEFT);
        $claim_close_day_m = str_pad($claim_close_day_m, 2, 0, STR_PAD_LEFT);
        $claim_close_day_d = str_pad($claim_close_day_d, 2, 0, STR_PAD_LEFT);

        $claim_day_flg = (date('Ymd') < $claim_close_day_y.$claim_close_day_m.$claim_close_day_d)? true : false;

        //�����������դ������ǤϤʤ���硢���������顼�ե饰��Ω�Ƥ�
        $claim_check_flg = (!checkdate((int)$claim_close_day_m, (int)$claim_close_day_d, (int)$claim_close_day_y))? true : false ;
    }else{
        $err_flg = true;
    }

    //���դǥ��顼�����ä����ϥ��顼��ɽ�����롣
    if($claim_check_flg === true || $claim_day_flg === true){
        $claim_day_flg = true;
    }

    //�����������������դ����Ϥ��줿���
    if($claim_day_flg == false && $err_flg != true){
        //���������-�׶��ڤ��Ϣ��
        $claim_close_day = $claim_close_day_y."-".$claim_close_day_m."-".$claim_close_day_d;

        //���������������ƥ೫���������ξ��ϥ��顼
        $system_start_flg = ($claim_close_day < date('Y-m-d',mktime(0,0,0,1,1,2005)))? true : false;

        //������������å�
        $renew_err = Bill_Monthly_Renew_Check($db_con, $claim_close_day);

        //���ꤵ�줿���������ꤵ��Ƥ�������������
        $sql  = "SELECT \n";  
        $sql .= "   DISTINCT t_claim.claim_id \n"; 
        $sql .= "FROM \n";
        $sql .= "   t_client\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_claim\n";
        $sql .= "   ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_claim AS t_client_claim \n";
        $sql .= "   ON t_claim.claim_id = t_client_claim.client_id \n";
        $sql .= "WHERE \n";
        $sql .= "   t_client.charge_branch_id = $branch_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_client.close_day = '$close_day'\n";
        $sql .= "   AND\n"; 
        $sql .= "   t_client.shop_id = $shop_id\n";

        $sql .= "   AND\n";
        $sql .= "   t_client_claim.month".(int)$claim_close_day_m."_flg = 't' \n";

        $sql .= "; \n";


        $result = Db_Query($db_con, $sql);
        $claim_count = pg_num_rows($result);

        for($i = 0; $i < $claim_count; $i++){
            $claim_id[] = pg_fetch_result($result, $i, 0);
        }


    }else{
        $err_flg = true;
    }

//ȯ�Է���������ξ��
}elseif($slipout_type == '2'){

    //����������Ⱦ�ѡ�ɬ�ܥ����å�
    $form->addGroupRule('form_claim_day2', array(
        'y' => array(
                array('�������������դ������ǤϤ���ޤ���','required'),
                array('�������������դ������ǤϤ���ޤ���','numeric'),
                array("����������'2005-01-01'���������դ����ϤǤ��ޤ���","rangelength", array(4,4))),
        'm' => array(
                array('�������������դ������ǤϤ���ޤ���','required'),
                array('�������������դ������ǤϤ���ޤ���','numeric')),
        'd' => array(
                array('�������������դ������ǤϤ���ޤ���','required'))
    ));

    //POST����
    $claim_cd1  = $_POST["form_claim"]["cd1"];                  //�����襳���ɣ�
    $claim_cd2  = $_POST["form_claim"]["cd2"];                  //�����襳���ɣ�
    $claim_name = $_POST["form_claim"]["name"];                 //������̾
    $claim_close_day_y = $_POST["form_claim_day2"]["y"];        //����������ǯ��
    $claim_close_day_m = $_POST["form_claim_day2"]["m"];        //���������ʷ��
    $claim_close_day_d = $_POST["form_claim_day2"]["d"];        //��������������
//    $claim_close_day_d = $_POST["form_claim_day2"]["d"];        //��������������
//���ϥޥ�������������Ѥ���Τǡ����դΥ����å��Τ���ˤȤꤢ����1���򥻥å�
    $claim_close_day_d = 1;

    //�����������ե��顼�����å�
    $claim_day_flg = (checkdate((int)$claim_close_day_m, (int)$claim_close_day_d, (int)$claim_close_day_y) == false)? true : false;
    
    //�����襳���ɤ����ξ��������襨�顼�ե饰��Ω�Ƥ�
    $claim_err_flg = ($claim_name == null)? true : false ;

    //���������顼�ե饰��false�������襨�顼�ե饰��false���
    if($form->validate() && $claim_day_flg == false && $claim_err_flg == false){

        //���ꤷ��������ξ�������
        $sql  = "SELECT\n";
        $sql .= "   client_id,\n";
        $sql .= "   close_day \n";
        $sql .= " FROM\n";
        $sql .= "   t_client\n";
        $sql .= " WHERE\n";
        $sql .= "   client_div = '1'\n";
        $sql .= "   AND\n";
        $sql .= "   shop_id = $shop_id\n";
        $sql .= "   AND\n";
        $sql .= "   client_cd1 = '$claim_cd1'\n";
        $sql .= "   AND\n";
        $sql .= "   client_cd2 = '$claim_cd2'\n";
        $sql .= ";\n";

        $result = Db_Query($db_con, $sql);
        $claim_count    = pg_num_rows($result);
        $claim_id[]     = @pg_fetch_result($result, 0, 0);
        $mst_close_day  = @pg_fetch_result($result, 0, 1);

        //������29�ʲ��ξ��
        if($mst_close_day < 29){
            $mst_close_day = $mst_close_day;
        //��������29�ʾ�ξ��
        }else{  
            $mst_close_day = date('d', mktime(0, 0, 0, (int)$claim_close_day_m+1, 0, (int)$claim_close_day_y));
        }

        //��������(ǯ��ʬ)�ϼ��������Ȥ���
        $year           = $claim_close_day_y;
        $month          = $claim_close_day_m;
        $mst_close_day  = str_pad($mst_close_day, 2, 0, STR_PAD_LEFT);

        $target_close_day = $year."-".$month."-".$mst_close_day;

        //�����0���
        $claim_close_day_m = str_pad($claim_close_day_m, 2, 0, STR_PAD_LEFT);
        $claim_close_day_d = str_pad($claim_close_day_d, 2, 0, STR_PAD_LEFT);

        //���������-�׶��ڤ��Ϣ��
        $claim_close_day = $claim_close_day_y."-".$claim_close_day_m."-".$mst_close_day;

        //���������������ƥ೫���������ξ��ϥ��顼
        $system_start_flg = ($claim_close_day < date('Y-m-d',mktime(0,0,0,1,1,2005)))? true : false;

        //���ꤷ���������MAX�����������
        $sql  = "SELECT";
        $sql .= "   COALESCE(MAX(close_day), '".START_DAY."') AS close_day ";
        $sql .= "FROM"; 
        $sql .= "   t_bill ";
        $sql .= "WHERE";
        $sql .= "   claim_id = $claim_id[0]";
        $sql .= ";"; 

        //aoyama-n 2009-07-30
        //������̺����������������Ǻ����Ѥߤξ��˥��顼��å�������ɽ������ʤ�
        //SQL��¹Ԥ��Ƥ��ʤ���������ɲ�
        $result = Db_Query($db_con, $sql);
        $last_close_day = @pg_fetch_result($result, 0, 0);

        if(($last_close_day >= $claim_close_day)){ 
            $last_close_day_err = true;
        }elseif(($last_close_day >= $target_close_day)){
            $last_close_day_err = true;
        }
                //������������å�
        $renew_err = Bill_Monthly_Renew_Check($db_con, $claim_close_day);
    }else{
        $err_flg = true;
    }
}


/****************************/
//���顼����
/****************************/
//���������顼�ե饰��true�ξ�硢���顼�ե饰��Ω�Ƥ�
if($claim_day_flg == true){
    $form->setElementError("form_claim_day2","�������������դ������ǤϤ���ޤ���");
    $err_flg = true;
}

//�����襨�顼�ե饰��true�ξ�硢���顼�ե饰��Ω�Ƥ�
if($claim_err_flg == true){
    $form->setElementError("form_claim","�����������襳���ɤ����Ϥ��Ʋ�������");
    $err_flg = true;
}

//�����ƥ೫�������顼��ture�ξ��
if($system_start_flg == true){
    $form->setElementError("form_claim_day2","����������'2005ǯ1��1������������դ����ϤǤ��ޤ���");
    $err_flg = true;
}

//�����������ǿ����ṹ�������������������ꤷ�����
if($last_close_day_err == true){
    $form->setElementError("form_claim_day2","���ꤷ����������Ф�������ǡ����ϴ��˺����ѤߤǤ���");
    $err_flg = true;
}

//����������顼
if($renew_err == true){
    $form->setElementError("form_claim_day2","������������������Ϻ����Ǥ��ޤ���");
    $err_flg = true;
}


/***************************/
//���ݻ�
/***************************/
$set_data["form_slipout_type"] = $slipout_type;
$form->setConstants($set_data);

/***************************/
//����إå��ѥǡ�����н���
/***************************/
//���Ҥξ�����Ψ�ʸ��ߡˤ���������������
$sql  = "SELECT\n";
#2009-12-29 aoyama-n
#$sql .= "   tax_rate_n, \n";
$sql .= "   NULL, \n";
$sql .= "   claim_set   \n";
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "WHERE\n";
$sql .= "   t_client.client_id = $shop_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
#2009-12-29 aoyama-n
#$rate      = pg_fetch_result($result ,0,0);       //[0-1]������Ψ
$claim_set = pg_fetch_result($result ,0,1);       //[0-3]����������
#2009-12-29 aoyama-n
#$tax_rate  = bcdiv($rate, 100, 2);                //[0-1]/ 100

if($claim_set == null && $add_create_button_flg == true){
    $form->setElementError("form_claim_day2","������ֹ������ԤäƤ���������");
    $err_flg = true;
}

//�����å�̾��AS��������̾����SESSION�Υ����å�ID�ȥޥå����륹���å�̾�����
$sql  = "SELECT\n";
$sql .= "   staff_name \n";
$sql .= "FROM\n";
$sql .= "   t_staff \n";
$sql .= "WHERE\n";
$sql .= "   staff_id = $staff_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$staff_name = pg_fetch_result($result, 0,0);     //[0-2]�����å�̾��AS��������̾

//���顼�ե饰��true����ʤ����Τ߽�������
if($err_flg != true && $add_create_button_flg == true ){
    //��Ф���������ʬ�����֤�
    for($i = 0; $i < $claim_count; $i++){
        //��ʣ���顼�ե饰��true�ξ��Ͻ�������ߤ��롣
        if($duplicate_err == true){
            break;
        }

        #2009-12-29 aoyama-n
        $tax_rate_obj->setTaxRateDay($claim_close_day);
        $rate = $tax_rate_obj->getClientTaxRate($claim_id[$i]);
        $tax_rate  = bcdiv($rate, 100, 2);

        //���ꤷ�����������������������Ƥ��ʤ����ޤ�������ǡ��������
        $sql = "EXECUTE renew_flg_check(".$claim_id[$i].",'".$claim_close_day."');";

//        print $claim_close_day."<br>";

        $result = Db_QUery($db_con, $sql);
        //$unrenew_count = pg_fetch_result($result,0,0);
        $unrenew_count = pg_num_rows($result);
        $renew_flg = ($unrenew_count > 0)? true : false;

        //���ꤷ�����������������������Ƥ��ʤ�����ǡ�����������ϥ��顼
        if($renew_flg == true){

            $unrenew_data = pg_fetch_all($result);
 //           $form->setElementError("form_claim_day1","��������������������ԤäƤ��ʤ��ǡ���������ޤ���");
            $duplicate_err = true;
 //           Db_Query($db_con, "ROLLBACK");
//            break; 

            for($j = 0; $j < $unrenew_count; $j++){

                if($unrenew_data[$j]["slip_div"] == "1"){
                    $pay_err[] = $unrenew_data[$j]["pay_no"];
                }elseif($unrenew_data[$j]["slip_div"] == "2"){
                    $sale_err[] = $unrenew_data[$j]["pay_no"];
                }else{
                    $advance_err[] = $unrenew_data[$j]["pay_no"];
                }
            }
            continue;
        }

        //������ƺ����������ˡ�̤����������񤬤�����ˤϤ���������������Ͻ������ʤ���
        $sql = "EXECUTE nonupdate_count($claim_id[$i], $shop_id);";
        $result = Db_Query($db_con, $sql);
        $num = @pg_num_rows($result);

        if($num > 0){
            if($slipout_type == '1'){
	            $make_day = $claim_close_day;                                 //���Ϥ�������
            }else{
                $make_day = $target_close_day;
            }

            $chk_date = pg_fetch_result($result, 0,1);
            if($chk_date != $make_day){
                $judge_count[] = pg_fetch_result($result, 0, 0);
            }else{
                $made_slip_count[] = pg_fetch_result($result, 0,0);
            }
            continue;
        }

        //��������������
        $sql = "EXECUTE get_claim_data('".$claim_close_day."', ".$claim_id[$i].");";
        $result = Db_Query($db_con, $sql);
        $claim_data_count = pg_num_rows($result);

        //�����쥳���ɤ�������
        if($claim_data_count > 0){
            $claim_data = pg_fetch_array($result, 0);
        //�����쥳���ɤ��ʤ����
        }else{  
            $no_claim_sheet_count[] = $claim_id[$i];
            continue;
        }       

        //��������������꺣���������������ξ��Ͻ������ʤ���
        if($claim_close_day <= $claim_data[renew_day]){
            $renew_claim_count[] = $claim_id[$i];
            continue;
        }

        //������ˤҤ�Ť����������������ǡ������������������
        $sql = "EXECUTE close_day_data(".$claim_id[$i].");";
        $close_day_result = Db_Query($db_con,$sql);
        $child_count = pg_num_rows($close_day_result);

        //�������������褬������
        if($child_count > 0){

            //������ֹ椬�֣����̾�ˤξ���
            if($claim_set == '1'){
                //�����ֹ��̾�Ϣ�֤��MAX(Ϣ��)+�������
                $sql    = "EXECUTE get_no_serial($shop_id);";
                $result = Db_Query($db_con, $sql);
                $max_no = pg_fetch_result($result ,0,0);

                //��Ф���Ϣ�֤�8��ˤʤ�褦�˺�¦��0��᤹��
                $claim_sheet_no = str_pad($max_no, 8, 0, STR_PAD_LEFT);     //[3-1]������ֹ�

            //������ֹ����꤬��2��ǯ���̡ˡפξ��
            }elseif($claim_set == '2'){
                //�����ֹ�ǯ��Ϣ�֤��MAX(Ϣ��)+�������
                $sql = "EXECUTE get_no_y_serial($shop_id);";
                $result = Db_Query($db_con, $sql);
                $max_no = pg_fetch_result($result, 0,0);

                //��Ф���Ϣ�֤�6��ˤʤ�褦�˺�¦��0��᤹��
                $claim_sheet_no = str_pad($max_no, 6, 0, STR_PAD_LEFT);

                //ǯ�β�����0��ᤷ��Ϣ�֤��Ȥ߹�碌��
                $year = date('y');
                $claim_sheet_no = $year.$claim_sheet_no;                    //[3-1]������ֹ�

            //������ֹ����꤬��3�ʷ��̡ˡפξ��
            }elseif($claim_set == '3'){
                //�����ֹ����Ϣ�֤��MAX(Ϣ��)+�������
                $sql = "EXECUTE get_no_m_serial($shop_id);";
                $result = Db_Query($db_con, $sql);
                $max_no = pg_fetch_result($result,0,0);

                //��Ф���Ϣ�֤�4��ˤʤ�褦�˺�¦��0��᤹��
                $claim_sheet_no = str_pad($max_no, 4, 0, STR_PAD_LEFT);

                //ǯ�β�����0��ᤷ��Ϣ�֤��Ȥ߹�碌��
                $year_month = date('ym');
                $claim_sheet_no = $year_month.$claim_sheet_no;              //[3-1]������ֹ�
            }


            //���������ꤷ�Ƥ���������ο��򥫥����
            $sql = "EXECUTE bill_format_count($claim_id[$i]);";
            $result = Db_Query($db_con, $sql);
            $claim_out_count = pg_fetch_result($result, 0,0);

            //����إå�����Ͽ������[4-1]
            //COUNT�η�̤����ʾ�ξ��
            if($claim_out_count >= 1){
                $claim_out = '1';       //(����)
            }else{
                $claim_out = '2';       //(���)
            }

            //����Ū�˿Ƥ˹�碌��
            $claim_out = $claim_data["claim_out"];
            /**********************************************************/
            //�������إå��ơ��֥����Ͽ�ʣ��쥳�����ɲ�/**********************************************************/
            //�إå��ơ��֥����Ͽ��1��Τ��ᡢ�롼�ײ����1���ܤΤ߽�������
            //if($j == 0){
            $sql  = "INSERT INTO t_bill (\n";
            $sql .= "   bill_id,\n";            //[14-1]�����ID
            $sql .= "   bill_no,\n";            //[14-2]������ֹ�
	        $sql .= "   close_day,\n";          //[14-3]����
	        $sql .= "   collect_day,\n";        //[14-4]���ͽ����
	        $sql .= "   claim_id,\n";           //[14-5]������ID
	        $sql .= "   claim_cd1,\n";          //[14-6]�����襳���ɣ�
	        $sql .= "   claim_cd2,\n";          //[14-7]�����襳���ɣ�
	        $sql .= "   claim_name1,\n";        //[14-8]������̾��
	        $sql .= "   claim_name2,\n";        //[14-9]������̾��
	        $sql .= "   claim_cname,\n";        //[14-10]������̾
	        $sql .= "   compellation,\n";       //[14-11]�ɾ�
	        $sql .= "   post_no1,\n";           //[14-12]������͹���ֹ棱
	        $sql .= "   post_no2,\n";           //[14-13]������͹���ֹ棲
	        $sql .= "   address1,\n";           //[14-14]�����轻�꣱
	        $sql .= "   address2,\n";           //[14-15]�����轻�ꣲ
	        $sql .= "   address3,\n";           //[14-16]�����轻�ꣳ
	        $sql .= "   c_memo1,\n";            //[14-17]����񥳥��ȣ�
	        $sql .= "   c_memo2,\n";            //[14-18]�����襳���ȣ�
	        $sql .= "   c_memo3,\n";            //[14-19]�����襳���ȣ�
	        $sql .= "   c_memo4,\n";            //[14-20]�����襳���ȣ�
	        $sql .= "   c_memo5,\n";            //[14-21]�����襳���ȣ�
	        $sql .= "   c_memo6,\n";            //[14-22]�����襳���ȣ�
	        $sql .= "   c_memo7,\n";            //[14-23]�����襳���ȣ�
	        $sql .= "   c_memo8,\n";            //[14-24]�����襳���ȣ�
	        $sql .= "   c_memo9,\n";            //[14-25]�����襳���ȣ�
	        $sql .= "   c_memo10,\n";           //[14-26]�����襳���ȣ���
	        $sql .= "   c_memo11,\n";           //[14-27]�����襳���ȣ���
	        $sql .= "   c_memo12,\n";           //[14-28]�����襳���ȣ���
	        $sql .= "   c_memo13,\n";           //[14-29]�����襳���ȣ���
	        $sql .= "   claim_send,\n";         //[14-30]���������
	        $sql .= "   bill_format,\n";        //[14-31]����������
	        $sql .= "   tax_div,\n";            //[14-32]����ñ��
	        $sql .= "   c_tax_div,\n";          //[14-33]���Ƕ�ʬ
	        $sql .= "   tax_franct,\n";         //[14-34]�����ǡ�ü����
	        $sql .= "   coax,\n";               //[14-35]��ۡʤޤ���ʬ��
	        $sql .= "   pay_way,\n";            //[14-36]������ˡ
	        $sql .= "   staff_cd,\n";           //[14-37]ô���ԥ�����
	        $sql .= "   staff_name,\n";         //[14-38]ô����̾
	        $sql .= "   create_staff_name,\n";  //[14-39]������̾
	        $sql .= "   shop_id,\n";            //[14-40]�����ID
	        $sql .= "   tax_rate_n,\n";         //[14-41]������Ψ
            $sql .= "   c_fsize1,\n";
            $sql .= "   c_fsize2,\n";
            $sql .= "   c_fsize3,\n";
            $sql .= "   c_fsize4,\n";
            $sql .= "   pay_m,\n";
            $sql .= "   pay_d,\n";
            $sql .= "   slipout_type,\n";       //��ɼȯ�Է����ʣ�����硡OR�����������
            $sql .= "   ownership_flg, \n";
            $sql .= "   fix_flg, ";
            $sql .= "   bill_make_month ";

	        $sql .= ")VALUES(";
	        $sql .= "   (SELECT COALESCE(MAX(bill_id), 0)+1 FROM t_bill),\n";   //MAX������ID�ˡܣ�
	        $sql .= "   '$claim_sheet_no',\n";                                  //[3-1]
            //���ξ��
            if($slipout_type == '1'){
	            $sql .= "   '$claim_close_day',\n";                                 //���Ϥ�������
            }else{
                $sql .= "   '$target_close_day',\n";
            }
            $sql .= "   '$claim_data[next_close_day]',\n";                      //[1-36]
	        $sql .= "   $claim_id[$i],\n";                                      //���̤����Ϥ��줿������μ����ID
	        $sql .= "   '$claim_data[client_cd1]',\n";                          //[1-4]
	        $sql .= "   '$claim_data[client_cd2]',\n";                          //[1-5]
	        $sql .= "   '".addslashes($claim_data[client_name])."',\n";         //[1-6]
	        $sql .= "   '".addslashes($claim_data[client_name2])."',\n";        //[1-7]
	        $sql .= "   '".addslashes($claim_data[client_cname])."',\n";        //[1-8]
	        $sql .= "   '$claim_data[compellation]',\n";                        //[1-9]
	        $sql .= "   '$claim_data[post_no1]',\n";                            //[1-10]
	        $sql .= "   '$claim_data[post_no2]',\n";                            //[1-11]
	        $sql .= "   '".addslashes($claim_data[address1])."',\n";            //[1-12]
	        $sql .= "   '".addslashes($claim_data[address2])."',\n";            //[1-13]
	        $sql .= "   '".addslashes($claim_data[address3])."',\n";            //[1-14]
	        $sql .= "   '".addslashes($claim_data[c_memo1])."',\n";             //[1-15]
	        $sql .= "   '".addslashes($claim_data[c_memo2])."',\n";             //[1-16]
	        $sql .= "   '".addslashes($claim_data[c_memo3])."',\n";             //[1-17]
	        $sql .= "   '".addslashes($claim_data[c_memo4])."',\n";             //[1-18]
	        $sql .= "   '".addslashes($claim_data[c_memo5])."',\n";             //[1-19]
	        $sql .= "   '".addslashes($claim_data[c_memo6])."',\n";             //[1-20]
	        $sql .= "   '".addslashes($claim_data[c_memo7])."',\n";             //[1-21]
	        $sql .= "   '".addslashes($claim_data[c_memo8])."',\n";             //[1-22]
	        $sql .= "   '".addslashes($claim_data[c_memo9])."',\n";             //[1-23]
	        $sql .= "   '".addslashes($claim_data[c_memo10])."',\n";            //[1-24]
	        $sql .= "   '".addslashes($claim_data[c_memo11])."',\n";            //[1-25]
	        $sql .= "   '".addslashes($claim_data[c_memo12])."',\n";            //[1-26]
	        $sql .= "   '".addslashes($claim_data[c_memo13])."',\n";            //[1-27]
	        $sql .= "   '$claim_data[claim_send]',\n";                          //[1-28]
	        $sql .= "   '$claim_out',\n";                                       //[4-1]
	        $sql .= "   '$claim_data[tax_div]',\n";                             //[1-29]
	        $sql .= "   '$claim_data[c_tax_div]',\n";                           //[1-30]
	        $sql .= "   '$claim_data[tax_franct]',\n";                          //[1-31]
	        $sql .= "   '$claim_data[coax]',\n";                                //[1-32]
	        $sql .= "   '$claim_data[pay_way]',\n";                             //[1-33]
	        $sql .= ($claim_data[charge_cd] != null)? $claim_data[charge_cd].",\n" : "null,\n";     //[1-34]
	        $sql .= "   '".addslashes($claim_data[staff_name])."',\n";          //[1-35]
	        $sql .= "   '".addslashes($staff_name)."',\n";                      //[0-2]
	        $sql .= "   $shop_id,\n";                                           //$_SESSION[shop_id]
	        $sql .= "   '$rate',\n";                                            //[0-1]
	        $sql .= "   '$claim_data[c_fsize1]',\n";                            //[1-27]
	        $sql .= "   '$claim_data[c_fsize2]',\n";                            //[1-27]
	        $sql .= "   '$claim_data[c_fsize3]',\n";                            //[1-27]
	        $sql .= "   '$claim_data[c_fsize4]',\n";                            //[1-27]
            $sql .= "   '$claim_data[pay_m]',\n";
            $sql .= "   '$claim_data[pay_d]',\n";
            $sql .= "   '$slipout_type',\n";
	        $sql .= ($child_count == 1)? "'f'," : "'t',";                         //�ƻҴط��ե饰
            $sql .= "   't', ";
            $sql .= "   ARRAY[ ";
            $sql .= "       (SELECT month1_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month2_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month3_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month4_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month5_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month6_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month7_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month8_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month9_flg  FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month10_flg FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month11_flg FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1'), ";
            $sql .= "       (SELECT month12_flg FROM t_claim WHERE client_id = $claim_id[$i] AND claim_div = '1')  ";
            $sql .= "   ] ";
	        $sql .= ");\n";

	        $result = Db_Query($db_con, $sql);
	        if($result === false){
                $err_message = pg_last_error();
                $err_format = "t_bill_bill_no_key";
                Db_Query($db_con, "ROLLBACK");

                //ȯ��NO����ʣ�������
                if(strstr($err_message,$err_format) !== false){ 
                    $error = "Ʊ��������ǡ����κ�����Ԥä����ᡢ��ɼ�ֹ椬��ʣ���ޤ������⤦���ٻ�����ԤäƤ���������";
                    $duplicate_err = true;
                    break; 
                }else{  
                    exit;   
                }
	        }   

	        //��Ͽ���������ID�����
            $sql     = "EXECUTE get_bill_id('".$claim_sheet_no."', ".$shop_id.")";
	        $result  = Db_Query($db_con, $sql);
	        $bill_id = pg_fetch_result($result, 0,0);
//	        }
        }

        /**********************************************************/
        //����Ф����ǡ������Ȥ˽��ס�������ñ�̡�
        /**********************************************************/
        //��׶�۽����
        $sum_bill_amount_last               = null;
        $sum_pay_amount                     = null;
        $sum_tune_amount                    = null;
        $sum_rest_amount                    = null;
        $sum_sale_amount                    = null;
        $sum_tax_amount                     = null;
        $sum_intax_amount                   = null;
        $sum_installment_sales_amount       = null;
        $sum_split_bill_amount              = null;
        $sum_installment_receivable_balance = null;
        $sum_bill_amount_this               = null;
        $sum_pay_amount_this                = null;
        $sum_sales_slip_num                 = null;
        $sum_lump_tax_amount                = null;
        $sum_installment_out_amount         = null;
        $sum_advance_balance_this           = null;
        $sum_advance_amount                 = null;
        $sum_advance_offset_amount          = null;

        //��Ф����������ʬ�롼��
        $claim_sheet_data_div = 0;
        for($j = 0; $j < $child_count; $j++){

            $client_close_day_data  = pg_fetch_array($close_day_result, $j);
            $client_close_day       = $client_close_day_data["client_close_day"];
            $client_claim_div       = $client_close_day_data["claim_div"];
            $client_id              = $client_close_day_data["client_id"];

            //Ʊ������������������Ƥ�����Ϻ������ʤ���
            //���ξ��

            if($slipout_type == '1'){
                $sql = "EXECUTE duplicate_date_check(".$client_id.",'".$claim_close_day."', '".$client_claim_div."')"; 
            //����ξ��
            }else{
                $sql = "EXECUTE duplicate_date_check(".$client_id.",'".$target_close_day."', '".$client_claim_div."')"; 
            }

//            $sql = "EXECUTE duplicate_date_check(".$client_id.",'".$client_close_day."', '".$client_claim_div."')"; 
                

            $result = Db_Query($db_con, $sql);
            $num = @pg_fetch_result($result,0,0);

            if($num >0){
//                $form->setElementError("form_claim_day1","���ꤷ���������Ф�������ǡ����Ϻ����ѤߤǤ���");
//                $duplicate_err = true;
                continue;
            }

            $sql  = "EXECUTE claim_data(".$claim_id[$i]." ,\n";
            $sql .= "                   '".$claim_close_day."',\n";
            $sql .= "                    ".$shop_id.",\n";
            $sql .= "                   '".$client_close_day."',\n";
            $sql .= "                   '".$client_claim_div."',\n";
            $sql .= "                    ".$client_id."\n";
            $sql .= ");";

//print_array($sql, "SQL");
            $client_result = Db_Query($db_con,$sql);
            $claim_client_data = pg_fetch_array($client_result, 0);

            $c_client_id[$j]                = $claim_client_data["client_id"];                      //[5-1]�����ID
            $c_client_cd1[$j]               = $claim_client_data["client_cd1"];                     //[5-2]����襳���ɣ�
            $c_client_cd2[$j]               = $claim_client_data["client_cd2"];                     //[5-3]����襳���ɣ�
            $c_client_name[$j]              = $claim_client_data["client_name"];                    //[5-4]�����̾
            $c_client_name2[$j]             = $claim_client_data["client_name2"];                   //[5-5]�����̾��
            $c_client_cname[$j]             = $claim_client_data["client_cname"];                   //[5-6]ά��
            $c_c_tax_div[$j]                = $claim_client_data["c_tax_div"];                      //[5-7]���Ƕ�ʬ
            $c_tax_franct[$j]               = $claim_client_data["tax_franct"];                     //[5-8]�����ǡ�ü����
            $c_claim_out[$j]                = $claim_client_data["claim_out"];                      //[5-9]��������
            $c_claim_div[$j]                = $claim_client_data["claim_div"];                      //[5-10]�������ʬ
            $c_coax[$j]                     = $claim_client_data["coax"];                           //[5-12]��ۡʤޤ���ʬ��
            $c_close_day[$j]                = $claim_client_data["close_day"];                      //[5-13]����
            $c_address1[$j]                 = $claim_client_data["address1"];
            $c_address2[$j]                 = $claim_client_data["address2"];
            $c_address3[$j]                 = $claim_client_data["address3"];
            $c_post_no1[$j]                 = $claim_client_data["post_no1"];
            $c_post_no2[$j]                 = $claim_client_data["post_no2"];
            $c_slip_out[$j]                 = $claim_client_data["slip_out"];
            $c_ware_id[$j]                  = $claim_client_data["ware_id"];                        //���ܽв��Ҹ�
            $bill_close_day_last[$j]        = ($claim_client_data["bill_close_day_last"] != null)? $claim_client_data["bill_close_day_last"] : START_DAY ;  //[6-1]����������
            $bill_amount_last[$j]           = $claim_client_data["bill_amount_last"];               //[6-2]���������
            $payment_last[$j]               = $claim_client_data["payment_last"];                   //[6-3]�����ʧ��
            $payment_extraction_s[$j]       = $claim_client_data["payment_extraction_s"];           //[6-4]��ʧͽ�����д��֡ʳ��ϡ�    
            $pay_amount[$j]                 = $claim_client_data["pay_amount"];                     //[7-1]���������
            $tune_amount[$j]                = $claim_client_data["tune_amount"];                    //[7-2]Ĵ����   
            $receivable_net_amount[$j]      = $claim_client_data["receivable_net_amount"];          //[8-1]�ݼ��������ۡ���ȴ��
            $receivable_tax_amount[$j]      = $claim_client_data["receivable_tax_amount"];          //[8-2]�ݼ���ξ����ǳ�
            $installment_net_amount[$j]     = $claim_client_data["installment_net_amount"];         //[8-4]������������ۡ���ȴ��
            $installment_tax_amount[$j]     = $claim_client_data["installment_tax_amount"];         //[8-5]�������ξ����ǳ�
            $taxation_amount[$j]            = $claim_client_data["taxation_amount"];                //[9-1]�ݼ���β��ǹ��
            $notax_amount[$j]               = $claim_client_data["notax_amount"];                   //[9-2]�ݼ��������ǹ��
            $sales_slip_num[$j]             = $claim_client_data["sales_slip_num"];                 //[13-9]��ɼ���

            //[13-1]���ۻĹ�ۤ����
            //��������ۡݡʺ�������ۡ�
            $rest_amount[$j]        = $bill_amount_last[$j] - ($pay_amount[$j]);   //[13-1]���ۻĹ�
      
            //[13-4]�������ۤ����
            //[13-5]��������ǳۤ����
            //[13-6]�ǹ������ۤ����

            //��������β���ñ�̤�������ñ�̡פξ��
            if($claim_data["tax_div"] == '1'){
                //���ǡ����ơ��֥뤫����Ф���������ۡʲ��ǡˡפȡ�����ۡ�����ǡˡפ����
                //������� [1-30]���Ƕ�ʬ �ˤ������Ǥη׻����ۤʤ�
                //�����Ǥ�ü����������� [1-31]�����ǡ�ü���� �ˤ���������

                //�ڳ��ǡ�
                if($claim_data["c_tax_div"] == '1'){
                    //[9-1] + [9-2] + [8-4]
                    $sale_amount[$j]    = $taxation_amount[$j] + $notax_amount[$j] + $installment_net_amount[$j];   //[13-4]��������
                    //([9-1] * [0-1] / 100) + [8-5]
                    $tax_amount[$j]     = bcadd(bcmul($taxation_amount[$j], $tax_rate,2), $installment_tax_amount[$j], 2);  //[13-5]��������ǳۡ��Ǥޤ������
                    $tax_amount[$j]     = Coax_Col($claim_data["tax_franct"], $tax_amount[$j]);     //[13-5]
            
                    //[13-4] + [13-5]
                    $intax_amount[$j]   = $sale_amount[$j] + $tax_amount[$j];                           //[13-6]�ǹ�������

                //�����ǡ�
                #2009-12-29 aoyama-n
                #}else{
                    //[9-1] + [9-2] + [8-4] + [8-5]
                    #$intax_amount[$j]   = $taxation_amount[$j] + $notax_amount[$j] + $installment_net_amount[$j] + $installment_tax_amount[$j]; //[13-6]�ǹ�������

                    //[9-1] - ([9-1] / ( 1 + [0-1])) + [8-5]
                    #$t_amount_data[$j]  = bcmul($taxation_amount[$j], $tax_rate,2);                 //[9-1] / ( 1 + [0-1])
                    #$tax_amount[$j]     = bcadd(bcsub($taxation_amount[$j], $t_amount_data[$j]), $installment_tax_amount[$j], 2);//[13-5]��������ǳۡ��Ǥޤ������
                    #$tax_amount[$j]     = Coax_Col($claim_data["tax_franct"], $tax_amount[$j]);

                    //[13-6] - [13-5]
                    #$sale_amount[$j]    = $intax_amount[$j] - $tax_amount[$j];

                #2009-12-29 aoyama-n
                //������ǡ�
                }elseif($claim_data["c_tax_div"] == '3'){
                    //[13-4]��������
                    $sale_amount[$j]    = $taxation_amount[$j] + $notax_amount[$j] + $installment_net_amount[$j];

                    $tax_amount[$j]     = 0;
            
                    //[13-6]�ǹ�������
                    $intax_amount[$j]   = $sale_amount[$j] + $tax_amount[$j];

                }

                //��������
//               $lump_tax_amount[$j]    = ($receivable_tax_amount[$j] + $installment_tax_amount[$j] - $tax_amount[$j]) * -1;
                $lump_tax_amount[$j]    = $tax_amount[$j] - ($receivable_tax_amount[$j] + $installment_tax_amount[$j]);

            //��������β���ñ�̤�����ɼñ�̡פξ��
            }else{
                // ���إå��ơ��֥뤫����Ф���������ۡ���ȴ�ˡפȡ־����ǳۡפ����
                //[8-1]+[8-4]
                $sale_amount[$j]    = $receivable_net_amount[$j] + $installment_net_amount[$j];         //[13-4]��������

                //[8-2]+[8-5]
                $tax_amount[$j]     = $receivable_tax_amount[$j] + $installment_tax_amount[$j];         //[13-5]��������ǳ�

                //[13-4]+[13-5]
                $intax_amount[$j]   = $sale_amount[$j] + $tax_amount[$j];                               //[13-6]�ǹ�������

                $lump_tax_amount[$j]    = 0;
            }


            //[13-7]�������ۤ����
            //[8-4] + [8-5]
            $installment_sales_amount[$j]   = $installment_net_amount[$j] + $installment_tax_amount[$j];    //[13-7]��������

            //[13-8]��������ۤ����
            //[13-1] + [13-6]
//            $bill_amount_this[$j]           = $rest_amount[$j] + $intax_amount[$j];                         //[13-8]���������
            //���ζ�ۤˤϺ���γ����ʧ�ۤ����äƤ��ʤ����ᡢ�����ʧ����и�˺��ٷ׻����롣
            $bill_amount_this[$j]           = $rest_amount[$j] + $intax_amount[$j] - $installment_sales_amount[$j]; 

            //�ǹ������������
            $installment_out_amount[$j]     = $intax_amount[$j] - $installment_sales_amount[$j];    //�ǹ����ۡ��ݡ���������

            //�����������
            $advance_ary                = Advance_Offset_Claim_Bill($db_con, $bill_close_day_last[$j], $claim_close_day, $c_client_id[$j], $c_claim_div[$j]);
            $advance_balance_this[$j]   = $advance_ary["advance_total_this"];   //����������Ĺ��
            $advance_balance_last[$j]   = $advance_ary["advance_total_last"];   //����������Ĺ��
            $advance_amount[$j]         = $advance_ary["advance_total"];        //�����������
            $advance_offset_amount[$j]  = $advance_ary["advance_payin_total"];  //�����������껦��


            //���󤬤Ϥ���Ƥ�������������Ƚ��
            $sql  = "SELECT\n";
            $sql .= "   COUNT(bill_d_id) \n";
            $sql .= "FROM\n";
            $sql .= "   t_bill\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_bill_d \n";
            $sql .= "   ON t_bill.bill_id = t_bill_d.bill_id \n";
            $sql .= "      AND\n";
/*
            $sql .= "      t_bill.claim_id = $claim_id[$i]\n";
            $sql .= "      AND\n";
*/
            //2011-12-11 hashimoto-y
            $sql .= "      t_bill_d.claim_div = $c_claim_div[$j]\n";

            $sql .= "      AND\n";
            $sql .= "      t_bill.first_set_flg = 'f'\n";
            $sql .= "      AND\n";
            $sql .= "      t_bill_d.client_id = $c_client_id[$j]\n";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            //����Ͽ�ʤ�н����Ͽ�ե饰��true�˥��å�
            $first_add_flg = (pg_fetch_result($result, 0,0) == 0)? true : false;

            //�����Ͽ�ե饰��true�ʤ����������ۡʽ������Ĺ�ۡˡ� ���ۤ����
            if($first_add_flg === true){
                $first_payment[$j] = $bill_amount_last[$j] + $intax_amount[$j];

            }else{
                $first_payment[$j] = $intax_amount[$j];

            }

	        /**********************************************************/
	        //�������ǡ����ơ��֥���Ͽ��ʣ���쥳������Ͽ��
	        /**********************************************************/
	        //������ֹ����꤬�̾�ޤ��Ͽơ��ҤΥǡ���
            $sql  = "INSERT INTO t_bill_d(\n";
            $sql .= "   bill_d_id,\n";                  //�����ǡ���ID
            $sql .= "   bill_id,\n";                    //[15-2]�����ID
            $sql .= "   bill_close_day_last,\n";        //[15-3]���������������
            $sql .= "   bill_close_day_this,\n";        //[15-4]��������
            $sql .= "   client_id,\n";                  //[15-5]������ID
            $sql .= "   client_cd1,\n";                 //[15-6]�����襳���ɣ�
            $sql .= "   client_cd2,\n";                 //[15-7]�����襳���ɣ�
            $sql .= "   client_name1,\n";               //[15-8]������̾��
            $sql .= "   client_name2,\n";               //[15-9]������̾��
            $sql .= "   client_cname,\n";               //[15-10]������̾��ά�Ρ�
            $sql .= "   bill_type,\n";                  //[15-11]��������
            $sql .= "   bill_data_div,\n";              //[15-12]�����ǡ�����ʬ
            $sql .= "   claim_div,\n";                  //[15-13]�������ʬ
            $sql .= "   bill_amount_last,\n";           //[15-14]���������
            $sql .= "   pay_amount,\n";                 //[15-15]���������
            $sql .= "   tune_amount,\n";                //[15-16]Ĵ����
            $sql .= "   rest_amount,\n";                //[15-17]���ۻĹ��
            $sql .= "   sale_amount,\n";                //[15-18]��������
            $sql .= "   tax_amount,\n";                 //[15-19]��������ǳ�
            $sql .= "   intax_amount,\n";               //[15-20]�ǹ�����
            $sql .= "   installment_sales_amount,\n";   //[15-21]��������
            $sql .= "   bill_amount_this,\n";           //[15-26]���������
            $sql .= "   payment_this,\n";               //[15-27]�����ʧ��
            $sql .= "   sales_slip_num,\n";             //[15-28]��ɼ���
            $sql .= "   payment_extraction_s,\n";       //[15-29]��ʧͽ�����д��֡ʳ��ϡ�
            $sql .= "   payment_extraction_e,\n";       //[15-30]��ʧͽ�����д��֡ʽ�λ��
            $sql .= "   c_tax_div,\n";                  //[15-31]���Ƕ�ʬ
            $sql .= "   tax_franct,\n";                 //[15-32]�����ǡ�ü����
            $sql .= "   coax,\n";                       //[15-33]��ۡʤޤ��� ʬ��
            $sql .= "   close_day,\n";                  //[15-35]����
            $sql .= "   first_payment,\n";              //[]����Ĺ�ۡ��ǹ�����
            $sql .= "   installment_out_amount, \n";    //�ǹ������������
            $sql .= "   advance_balance, \n";           //����������Ĺ�
            $sql .= "   advance_amount, \n";            //����������Ĺ�
            $sql .= "   advance_offset_amount \n";      //����������Ĺ�
            $sql .= ")VALUES(";
  	        $sql .= "   (SELECT COALESCE(MAX(bill_d_id), 0)+1 FROM t_bill_d),";                                 //MAX�������˥ǡ���ID�ܣ�
	        $sql .= "   $bill_id,";                                                                             //[14-1]
	        $sql .= ($bill_close_day_last[$j] != null)? "'".$bill_close_day_last[$j]."'," : "'".START_DAY."',"; //[6-1]
	        $sql .= "   '$claim_close_day',";                                                                   //���̾夫�����Ϥ��줿��������
	        $sql .= "   $c_client_id[$j],";                                                                     //[5-1]
	        $sql .= "   '$c_client_cd1[$j]',";                                                                  //[5-2]
	        $sql .= "   '$c_client_cd2[$j]',";                                                                  //[5-3]
	        $sql .= "   '".addslashes($c_client_name[$j])."',";                                                 //[5-4]
	        $sql .= "   '".addslashes($c_client_name2[$j])."',";                                                //[5-5]
	        $sql .= "   '".addslashes($c_client_cname[$j])."',";                                                //[5-6]
	        $sql .= "   '$c_claim_out[$j]',";                                                                   //[5-9]
	        //��ʬ���̾�ξ��ϣ����Ƥޤ��ϻҤΥǡ����ξ��������襳���ɤξ���ǣ�����ܣ�����
	        //��ʬ���Ƥξ��
	        if($child_count == 1){
	            $sql .= "   0,";
	        //�Ƥޤ��ϻҤΥǡ����ξ��                                           
	        }else{
	            $claim_sheet_data_div++;            //����ǡ�����ʬ������
	            $sql .= "  $claim_sheet_data_div,";
	        }
	        $sql .= "   '$c_claim_div[$j]',";                                                                    //[5-10]
	        $sql .= ($bill_amount_last[$j] != null)?  $bill_amount_last[$j]."," : " 0,";                         //[6-2]
	        $sql .= ($pay_amount[$j] != null)?        $pay_amount[$j].","       : " 0,";                         //[7-1]
	        $sql .= ($tune_amount[$j] != null)?       $tune_amount[$j].","      : " 0,";                         //[7-2]
	        $sql .= ($rest_amount[$j] != null)?       $rest_amount[$j].","      : " 0,";                         //[13-1]
	        $sql .= ($sale_amount[$j] != null)?       $sale_amount[$j].","      : " 0,";                         //[13-4]
	        $sql .= ($tax_amount[$j] != null)?        $tax_amount[$j].","       : " 0,";                         //[13-5]
	        $sql .= ($intax_amount[$j] != null)?      $intax_amount[$j].","     : " 0,";                         //[13-6]
	        $sql .= ($installment_sales_amount[$j] != null)?  $installment_sales_amount[$j]."," : " 0,";         //[13-7]
	        $sql .= ($bill_amount_this[$j] != null)?  $bill_amount_this[$j]."," : " 0,";                         //[13-8]
	        $sql .= "   null,";                                                                                  //NULL
	        $sql .= ($sales_slip_num[$j] != null)?    $sales_slip_num[$j]."," : " 0,";                           //[13-9]
	        $sql .= ($payment_extraction_s[$j] != null)? "   '$payment_extraction_s[$j]'," : "'".START_DAY."',"; //[6-4]
	        $sql .= "   '$claim_data[after_pay_d]',";                                                            //[1-37]
	        $sql .= "   '$c_c_tax_div[$j]',";                                                                    //[5-7]
	        $sql .= "   '$c_tax_franct[$j]',";                                                                   //[5-8]
	        $sql .= "   '$c_coax[$j]',";                                                                         //[5-12]
	        $sql .= "   '$c_close_day[$j]',";                                                                    //[5-13]
            $sql .= ($first_payment[$j] != null)?     $first_payment[$j]."," : " 0,";
            $sql .= ($installment_out_amount[$j] != null) ? $installment_out_amount[$j]."," : " 0,";
            $sql .= "   $advance_balance_this[$j], ";
            $sql .= "   $advance_amount[$j], ";
            $sql .= "   $advance_offset_amount[$j] ";
	        $sql .= ");";
	    
	        $result = Db_Query($db_con, $sql);
	        if($result === false){
	            Db_Query($db_con, "ROLLBACK;");
	            exit;
	        }

            /**********************************************************/
            //��ʬ����������
            /**********************************************************/
            //[10-1] SUM�ʲ����ۡˡ���������������
            //����о��
            //[6-4]���ޤ��ϡ�������������� < �������ơ��֥�β���� <= [1-37]
            //��[6-4]�η�̤�̵�����ˤϺ�������������򳫻����Ȥ���
            $sql  = "EXECUTE get_split_amount(\n";
            $sql .= "           '".$claim_data[after_pay_d]."',\n";
            $sql .= "           $c_client_id[$j],\n";
            $sql .= "           $claim_id[$i],\n";
            $sql .= ($payment_extraction_s[$j] != null)? "   '$payment_extraction_s[$j]'," : "'".START_DAY."',";       //[6-4]
            $sql .= "           '".$claim_close_day."'\n";
            $sql .= "            );";
            $result = Db_Query($db_con, $sql);
            
            $split_bill_amount[$j]              = @pg_fetch_result($result,0,0);         //[10-1]ʬ�������
            $installment_receivable_balance[$j] = @pg_fetch_result($result,0,1);         //[11-1]ʬ������Ĺ�

            $sql  = "UPDATE";
            $sql .= "   t_installment_sales ";
            $sql .= "SET ";
            $sql .= "   bill_id = $bill_id ";
            $sql .= "WHERE ";
            $sql .= "   sale_id IN (SELECT ";
            $sql .= "                   sale_id ";
            $sql .= "               FROM ";
            $sql .= "                   t_sale_h ";
            $sql .= "               WHERE ";
            $sql .= "                   t_sale_h.client_id = $c_client_id[$j]";
            $sql .= "                   AND ";
            $sql .= "                   t_sale_h.claim_div = (SELECT ";
            $sql .= "                                           claim_div\n";
            $sql .= "                                       FROM\n";
            $sql .= "                                           t_claim\n";
            $sql .= "                                       WHERE\n";
            $sql .= "                                           client_id = t_sale_h.client_id\n";
            $sql .= "                                           AND\n";
            $sql .= "                                           claim_id = $claim_id[$i]\n";
            $sql .= "                                       )\n";
            $sql .= "                   AND ";
            $sql .= "                   t_sale_h.trade_id = '15'";
            $sql .= "                   AND ";
            $sql .= "                   t_sale_h.renew_flg = 't'";
            $sql .= "                   AND ";
            $sql .= "                   t_sale_h.claim_day <= '$claim_close_day'\n";
            $sql .= "           ) \n";
            $sql .= "   AND\n";
            $sql .= "   t_installment_sales.collect_day <=  '".$claim_data[after_pay_d]."'\n";
            $sql .= "   AND \n";
            $sql .= "   t_installment_sales.bill_id IS NULL";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);

            if($result === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

	        /**********************************************************/
	        //�������ʧ�ۤ����
	        /**********************************************************/
            $sql  = "EXECUTE get_all_amount($c_client_id[$j],";
            $sql .= ($payment_extraction_s[$j] != null)? "'$payment_extraction_s[$j]'," : "'$claim_close_day',";
            $sql .= "                       '".$claim_data[after_pay_d]."',";
            $sql .= "                       '".$c_claim_div[$j]."'";
            $sql .= ");";   

	        $result = Db_Query($db_con, $sql);

	        $all_intax_amount[$j]               = pg_fetch_result($result, 0,0);        //[19-1]
	        $all_installment_sales_amount[$j]   = pg_fetch_result($result, 0,1);        //[19-2]

	        /**********************************************************/
	        //�������ʧ�ۤ򹹿�
	        /**********************************************************/
	        //��ʧ�ۤ����

	        //[19-1] - [19-2] + [10-1] + [6-3] + [7-1]
	        $pay_amount_this[$j] = $all_intax_amount[$j] 
	                            - 
	                           $all_installment_sales_amount[$j]
	                            +
	                           $split_bill_amount[$j]
	                            +
	                           $payment_last[$j]
	                            -
	                           $pay_amount[$j];     //[19-3]
            $bill_amount_this[$j] = $bill_amount_this[$j] + $split_bill_amount[$j];

/*
print "<hr>";
print "�����衧".$c_client_cd1[$j]."-".$c_client_cd2[$j]."<br>";
print "�ǹ����ۡ�".$all_intax_amount[$j]."<br>";
print "�������ۡ�".$all_installment_sales_amount[$j]."<br>";
print "ʬ������ۡ�".$split_bill_amount[$j]."<br>";
print "�����ʧ�ۡ�".$payment_last[$j]."<br>";
print "��������ۡ�".$pay_amount[$j]."<br>";
//print "�����ʧ�ۡ�".$pay_amount_this[$j]."<br>";
*/	                                                    

	        $sql  = "UPDATE\n";
	        $sql .= "   t_bill_d \n";
	        $sql .= "SET\n";
	        $sql .= "   payment_this = ";
            $sql .= ($pay_amount_this[$j] != null)? $pay_amount_this[$j]."," : "0,\n";
            $sql .= "   split_bill_amount = ";
            $sql .= ($split_bill_amount[$j] != null)? $split_bill_amount[$j]."," : "0,\n";
            $sql .= "   split_bill_rest_amount = ";
            $sql .= ($installment_receivable_balance[$j] != null)? $installment_receivable_balance[$j]."," : "0, \n";
            $sql .= "   bill_amount_this = ";
            $sql .= ($bill_amount_this[$j] != null)? $bill_amount_this[$j] : "0 \n";
	        $sql .= "WHERE\n";
	        $sql .= "   bill_id = $bill_id\n";
            $sql .= "   AND\n";
            $sql .= "   client_id = $c_client_id[$j]\n";
            $sql .= ";\n";

	        $result = Db_Query($db_con, $sql);
	        if($result === false){
	            Db_Query($db_con, "ROLLBACK;");
	            exit;
	        }


	        /**********************************************************/
	        //����׶�ۤ򹹿�
	        /**********************************************************/
            $sum_bill_amount_last                   = $sum_bill_amount_last         + $bill_amount_last[$j];
            $sum_pay_amount                         = $sum_pay_amount               + $pay_amount[$j];
            $sum_tune_amount                        = $sum_tune_amount              + $tune_amount[$j];
            $sum_rest_amount                        = $sum_rest_amount              + $rest_amount[$j];
            $sum_sale_amount                        = $sum_sale_amount              + $sale_amount[$j];
            $sum_tax_amount                         = $sum_tax_amount               + $tax_amount[$j];
            $sum_intax_amount                       = $sum_intax_amount             + $intax_amount[$j];
            $sum_installment_sales_amount           = $sum_installment_sales_amount + $installment_sales_amount[$j];
            $sum_split_bill_amount                  = $sum_split_bill_amount        + $split_bill_amount[$j];
            $sum_installment_receivable_balance     = $sum_installment_receivable_balance + $installment_receivable_balance[$j];
            $sum_bill_amount_this                   = $sum_bill_amount_this         + $bill_amount_this[$j];
            $sum_pay_amount_this                    = $sum_pay_amount_this          + $pay_amount_this[$j];
            $sum_sales_slip_num                     = $sum_sales_slip_num           + $sales_slip_num[$j];
            $sum_lump_tax_amount                    = $sum_lump_tax_amount          + $lump_tax_amount[$j];
            $sum_installment_out_amount             = $sum_installment_out_amount   + $installment_out_amount[$j];
            $sum_advance_balance_this               = $sum_advance_balance_this     + $advance_balance_this[$j];
            $sum_advance_amount                     = $sum_advance_amount           + $advance_amount[$j];
            $sum_advance_offset_amount              = $sum_advance_offset_amount    + $advance_offset_amount[$j];
 
            /**********************************************************/
            //����������
            /**********************************************************/
//            if($sum_lump_tax_amount != 0){
            if($lump_tax_amount[$j] != 0){
                //�����Ͽ�ؿ����Ϥ���������
                $ary = array($claim_close_day,  //��������
                            $c_client_id[$j],      //������ID
                            $bill_id,           //�����ID
                            $shop_id,           //����å�ID
                       );

                Insert_Sale_Head ($db_con, 0, $lump_tax_amount[$j], $ary, '2');
            }

            /**********************************************************/
            //��ۤ�����NULL�ξ�������ǡ�����������ʤ�
            /**********************************************************/
            if($bill_amount_last[$j] == 0
                &&
                $pay_amount[$j] == 0
                &&
                $tune_amount[$j] == 0
                &&
                $rest_amount[$j] == 0
                &&
                $sale_amount[$j] == 0
                &&
                $tax_amount[$j] == 0
                &&
                $intax_amount[$j] == 0
                &&
                $installment_sales_amount[$j] == 0
                &&
                $split_bill_amount[$j] == 0
                &&
                $installment_receivable_balance[$j] == 0
                &&
                $pay_amount_this[$j] == 0
//                &&
//                $sales_slip_num[$j] == 0
                &&
                $advance_balance_this[$j] == 0
                &&
                $advance_amount[$j] == 0
                &&
                $advance_offset_amount[$j] == 0
            ){
                //����ѤߤΥǡ����򥢥åץǡ��ȡʺ������뤿��id���ǥ��åץǡ��ȡ�
                Collect_Bill_D_Update($db_con, 0, $c_client_id[$j], $c_claim_div[$j], $claim_data[after_pay_d]);

                $sql = "DELETE FROM t_bill_d WHERE bill_id = $bill_id AND client_id = $c_client_id[$j];\n";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

            }else{
                //����ѤߤΥǡ����򥢥åץǡ���
                Collect_Bill_D_Update($db_con, $bill_id, $c_client_id[$j], $c_claim_div[$j], $claim_data[after_pay_d]);
            }
	    }

	    /*********************************************************/
	    //������ǡ����ơ��֥����Ͽ�ʿƻҴط���������Τ�1�쥳�����ɲá�
	    /*********************************************************/
        if($child_count > 1){
            $sql  = "INSERT INTO t_bill_d(\n";
            $sql .= "   bill_d_id,\n";                                  //�����ǡ���ID
            $sql .= "   bill_id,\n";                                    //[15-2]�����ID
            $sql .= "   bill_close_day_last,\n";                        //[15-3]���������������
            $sql .= "   bill_close_day_this,\n";                        //[15-4]��������
            $sql .= "   client_id,\n";                                  //[15-5]������ID
            $sql .= "   client_cd1,\n";                                 //[15-6]�����襳���ɣ�
            $sql .= "   client_cd2,\n";                                 //[15-7]�����襳���ɣ�
            $sql .= "   client_name1,\n";                               //[15-8]������̾��
            $sql .= "   client_name2,\n";                               //[15-9]������̾��
            $sql .= "   client_cname,\n";                               //[15-10]������̾��ά�Ρ�
            $sql .= "   bill_type,\n";                                  //[15-11]��������
            $sql .= "   bill_data_div,\n";                              //[15-12]�����ǡ�����ʬ
            $sql .= "   claim_div,\n";                                  //[15-13]�������ʬ
            $sql .= "   bill_amount_last,\n";                           //[15-14]���������
            $sql .= "   pay_amount,\n";                                 //[15-15]���������
            $sql .= "   tune_amount,\n";                                //[15-16]Ĵ����
            $sql .= "   rest_amount,\n";                                //[15-17]���ۻĹ��
            $sql .= "   sale_amount,\n";                                //[15-18]��������
            $sql .= "   tax_amount,\n";                                 //[15-19]��������ǳ�
            $sql .= "   intax_amount,\n";                               //[15-20]�ǹ�����
            $sql .= "   installment_sales_amount,\n";                   //[15-21]��������
            $sql .= "   split_bill_amount,\n";                          //[15-22]ʬ�������
            $sql .= "   split_bill_rest_amount,\n";                     //[15-23]ʬ������Ĺ�
            $sql .= "   bill_amount_this,\n";                           //[15-26]���������
            $sql .= "   payment_this,\n";                               //[15-27]�����ʧ��
            $sql .= "   sales_slip_num,\n";                             //[15-28]��ɼ���
            $sql .= "   payment_extraction_s,\n";                       //[15-29]��ʧͽ�����д��֡ʳ��ϡ�
            $sql .= "   payment_extraction_e,\n";                       //[15-30]��ʧͽ�����д��֡ʽ�λ��
            $sql .= "   c_tax_div,\n";                                  //[15-31]���Ƕ�ʬ
            $sql .= "   tax_franct,\n";                                 //[15-32]�����ǡ�ü����
            $sql .= "   coax,\n";                                       //[15-33]��ۡʤޤ���ʬ��
            $sql .= "   close_day,\n";                                  //[15-35]����
            $sql .= "   installment_out_amount, \n";                    //�ǹ������������
            $sql .= "   advance_balance, \n";                           //����������Ĺ��
            $sql .= "   advance_amount, \n";                            //�����������
            $sql .= "   advance_offset_amount \n";                     //�����������껦��
            $sql .= ")VALUES(";
	        $sql .= "   (SELECT COALESCE(MAX(bill_d_id), 0)+1 FROM t_bill_d), \n";
	        $sql .= "   $bill_id,\n";                                       //
	        $sql .= "   null,\n";                                           //
	        $sql .= "   '$claim_close_day', \n";                            //
	        $sql .= "   $claim_id[$i],\n";                                  //������ID��Ĥ��褦���ѹ�
	        $sql .= "   '".addslashes($claim_data[client_cd1])."',\n";      //[1-4]
	        $sql .= "   '".addslashes($claim_data[client_cd2])."',\n";      //[1-5]
	        $sql .= "   '".addslashes($claim_data[client_name])."',\n";     //[1-6]
	        $sql .= "   '".addslashes($claim_data[client_name2])."',\n";    //[1-7]
	        $sql .= "   '".addslashes($claim_data[client_cname])."',\n";    //[1-8]
	        $sql .= "   '2', \n";
	        $sql .= "   0,\n";
	        $sql .= "   null,\n";
	        $sql .= "   ".(int)$sum_bill_amount_last.",\n";
	        $sql .= "   ".(int)$sum_pay_amount.",\n";
	        $sql .= "   ".(int)$sum_tune_amount.",\n";
	        $sql .= "   ".(int)$sum_rest_amount.",\n";
	        $sql .= "   ".(int)$sum_sale_amount.",\n";
	        $sql .= "   ".(int)$sum_tax_amount.",\n";
	        $sql .= "   ".(int)$sum_intax_amount.",\n";
	        $sql .= "   ".(int)$sum_installment_sales_amount.",\n";
	        $sql .= "   ".(int)$sum_split_bill_amount.",\n";
	        $sql .= "   ".(int)$sum_installment_receivable_balance.",\n";
	        $sql .= "   ".(int)$sum_bill_amount_this.",\n";
	        $sql .= "   ".(int)$sum_pay_amount_this.",\n";
	        $sql .= "   ".(int)$sum_sales_slip_num.",\n";
	        $sql .= "   null,\n";
	        $sql .= "   null,\n";
	        $sql .= "   null,\n";
	        $sql .= "   null,\n";
	        $sql .= "   null,\n";
	        $sql .= "   null,\n";
            $sql .= "   ".(int)$sum_installment_out_amount.",";
            $sql .= "   ".(int)$sum_advance_balance_this.",";
            $sql .= "   ".(int)$sum_advance_amount.",";
            $sql .= "   ".(int)$sum_advance_offset_amount;
            
	        $sql .= ");\n";

	        $result = Db_Query($db_con, $sql);
	        if($result === false){
	            Db_Query($db_con, "ROLLBACK;");
	            exit;
            }
	    }

        //��������ζ�ۤ����ƣ��ξ���������������������
/*
        print "<hr>";
        print $claim_id[$i]."<br>"; 
        print "���";
        print "<hr>";
        print "��������ۡ�".$sum_bill_amount_last;
        print "<br>";
        print "��������ۡ�".$sum_pay_amount;
        print "<br>";
        print "Ĵ���ۡ�".$sum_tune_amount;
        print "<br>";
        print "���ۻĹ�ۡ�".$sum_rest_amount;
        print "<br>";
        print "��������ۡ�".$sum_sale_amount;
        print "<br>";
        print "������������ǳۡ�".$sum_tax_amount;
        print "<br>";
        print "�����ǹ������ۡ�".$sum_intax_amount;
        print "<br>";
        print "�������ۡ�".$sum_installment_sales_amount;
        print "<br>";
        print "ʬ������ۡ�".$sum_split_bill_amount;
        print "<br>";
        print "ʬ������Ĺ�ۡ�".$sum_installment_receivable_balance;
        print "<br>";
        print "��������ۡ�".$sum_pay_amount_this;
        print "<br>";
        print "�����ʧ�ۡ�".$sum_sales_slip_num;
*/ 
       if(($sum_bill_amount_last == null || $sum_bill_amount_last == 0)
            &&
            ($sum_pay_amount == null || $sum_pay_amount == 0)
            &&
            ($sum_tune_amount == null || $sum_tune_amount == 0)
            &&
            ($sum_rest_amount == null || $sum_rest_amount == 0)
            &&
            ($sum_sale_amount == null || $sum_sale_amount == 0)
            &&
            ($sum_tax_amount == null || $sum_tax_amount == 0)
            &&
            ($sum_intax_amount == null || $sum_intax_amount == 0)
            &&
            ($sum_installment_sales_amount == null || $sum_installment_sales_amount == 0)
            &&
            ($sum_split_bill_amount == null || $sum_split_bill_amount == 0)
            &&
            ($sum_installment_receivable_balance == null || $sum_installment_receivable_balance == 0)
            &&
            ($sum_pay_amount_this == null || $sum_pay_amount_this == 0)
//            &&
//            ($sum_sales_slip_num == null || $sum_sales_slip_num == 0)
            &&
            ($sum_advance_balance_this == null || $sum_advance_balance_this == 0)
            &&
            ($sum_advance_amount == null || $sum_advance_amount == 0)
            &&
            ($sum_advance_offset_amount == null || $sum_advance_offset_amount == 0)
        ){
            $sql = "DELETE FROM t_bill WHERE bill_id = $bill_id;\n";
            $result = Db_Query($db_con, $sql);

            if($result === false){ 
                Db_Query($db_con, "ROLLBACK;");
                exit;   
            }       
        }else{
            /*****************************/
            //�����ֹ���Ͽ
            /*****************************/
            //�̾�����ξ��
            if($claim_set == '1'){
                $sql = "EXECUTE insert_no_serial($max_no, $shop_id);";

            //ǯ������ξ��
            }elseif($claim_set == '2'){
                $sql = "EXECUTE insert_no_y_serial($max_no, '".date('Y')."', $shop_id);";

            //��������ξ��
            }elseif($claim_set == '3'){
                $sql = "EXECUTE insert_no_m_serial($max_no, '".date('Ym')."', $shop_id);";
            }

            $result = Db_Query($db_con, $sql);
            if($result === false){
                $err_message = pg_last_error();
                $err_format1 = "t_bill_no_serial_serial_num_key";
                $err_format2 = "t_bill_no_y_serial_year_key";
                $err_format3 = "t_bill_no_m_serial_month_key";

                Db_Query($db_con, "ROLLBACK");
                //ȯ��NO����ʣ�������
                if((strstr($err_message,$err_format1) !== false)
                        ||
                    (strstr($err_message,$err_format2) !== false)
                        ||
                    (strstr($err_message,$err_format3) !== false)){
                        $error = "Ʊ��������ǡ����κ�����Ԥä����ᡢ�����ֹ椬��ʣ���ޤ������⤦���ٻ�����ԤäƤ���������";
                        $duplicate_err = true;
                        break;
                }else{
                    exit;
                }
            }
        }
	}

    //��ʣ���顼���ʤ����
    if($duplicate_err != true ){

        if($slipout_type == '1'){

            //�������򤬤��뤫
            $sql  = "SELECT\n";
            $sql .= "   COUNT(*) \n";
            $sql .= "FROM\n";
            $sql .= "   t_bill_make_history \n";
            $sql .= "WHERE\n";
            $sql .= "   bill_close_day = '$claim_close_day'";
            $sql .= "   AND\n";
            $sql .= "   close_day = '$close_day'\n";
            $sql .= "   AND\n";
            $sql .= "   shop_id = $shop_id\n";

            $sql .= "   AND\n";
            $sql .= "   branch_id = $branch_id \n";
            $sql .= ";\n";

            $result = Db_Query($db_con, $sql);
            $make_count = pg_fetch_result($result, 0,0);
    
            //�������򤬤ʤ����
            if($make_count == 0){
                //����ǡ������������Ĥ�
                $sql  = "INSERT INTO t_bill_make_history(\n";
                $sql .= "   bill_close_day,\n";
                $sql .= "   close_day,\n";
                $sql .= "   shop_id,\n";
                $sql .= "   branch_id ";
                $sql .= ")VALUES(\n";
                $sql .= "   '$claim_close_day', \n";
                $sql .= "   $close_day, \n";
                $sql .= "   $shop_id,\n";
                $sql .= "   $branch_id \n";
                $sql .= ");\n";

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
            }
        }
    
        //�����������Ǥ��ʤ��ä��ꥹ��
        if(count($judge_count) > 0){
            $_SESSION[get_data] = $judge_count;
        }
/*
        //���������ꤷ�ʤ��ä��ꥹ��
        if(count($no_claim_sheet_count) > 0){
            $_SESSION[no_sheet_data] = $no_claim_sheet_count;
        }

        //���ṹ�����������դ����Ϥ����ꥹ��
        if(count($renew_claim_count) > 0){
            $_SESSION[renew_data] = $renew_claim_count;
        }

        //����2���ܤκ���
        if(count($made_slip_count) > 0){
            $_SESSION[made_data] = $made_slip_count;
        }
*/
	    Db_Query($db_con, "COMMIT;");
        header("Location:./2-2-308.php?add_flg=true");
    }else{
	    Db_Query($db_con, "ROLLBACK;");
    }
}


/****************************/
//�����ǡ�������
/****************************/
//����1��
$now_month = date('m');
$last_date = date('Ymd',mktime(0,0,0,$now_month-1,01));
#2011-11-19 aoyama-n
#$last_m = date('Yǯm��', mktime(0,0,0,$now_month-1));
$last_m = date('Yǯm��', mktime(0,0,0,$now_month-1,01));

//�����1��
$now_date = date('Ym')."01";
$now_m = date('Yǯm��', mktime(0,0,0,$now_month));

//����1��
$next_date = date('Ymd',mktime(0,0,0,$now_month+1,01));

$sql  = "SELECT\n";
$sql .= "   close_day_list.close_day,\n";
$sql .= "   CASE ";
$sql .= "       WHEN bill_close_day_list1.bill_close_day IS NOT NULL THEN '��'";
$sql .= "       ELSE '��'";
$sql .= "   END AS bill_close_day_last,\n";
$sql .= "   CASE ";
$sql .= "       WHEN bill_close_day_list2.bill_close_day IS NOT NULL THEN '��'";
$sql .= "       ELSE '��'";
$sql .= "   END AS bill_close_day_now, \n";
$sql .= "   close_day_list.branch_cd, \n";
$sql .= "   close_day_list.branch_name \n";
$sql .= "FROM\n";

$sql .= "   (SELECT \n";
$sql .= "       distinct \n";
$sql .= "       t_client.close_day, \n";
$sql .= "       branch_id, \n"; 
$sql .= "       branch_cd, \n";
$sql .= "       branch_name \n";
$sql .= "   FROM \n";
$sql .= "       t_client \n";
$sql .= "           INNER JOIN \n";
$sql .= "       t_branch \n";
$sql .= "       ON t_client.charge_branch_id = t_branch.branch_id \n";
$sql .= "   WHERE \n";
$sql .= "       t_client.shop_id = $shop_id \n";
$sql .= "       AND \n";
$sql .= "       t_client.close_day != '' \n";
$sql .= "   GROUP BY \n";
$sql .= "       t_branch.branch_id, \n";
$sql .= "       t_branch.branch_cd, \n";
$sql .= "       t_branch.branch_name, \n";
$sql .= "       t_client.close_day \n";
$sql .= "   )close_day_list\n";

//����
$sql .= "   LEFT JOIN\n";
$sql .= "   (\n";
$sql .= "   SELECT\n";
$sql .= "       close_day,\n";
$sql .= "       bill_close_day, \n";
$sql .= "       branch_id \n";
$sql .= "   FROM\n";
$sql .= "       t_bill_make_history\n";
$sql .= "   WHERE\n";
$sql .= "       '$last_date' <= t_bill_make_history.bill_close_day\n";
$sql .= "       AND \n";
$sql .= "       t_bill_make_history.bill_close_day < '$now_date'\n";
$sql .= "       AND \n";
$sql .= "       t_bill_make_history.shop_id = $shop_id";
$sql .= "   ) AS bill_close_day_list1\n";
$sql .= "   ON close_day_list.close_day = bill_close_day_list1.close_day\n";
$sql .= "   AND  close_day_list.branch_id = bill_close_day_list1.branch_id\n";

$sql .= "   LEFT JOIN\n";

//����
$sql .= "   (\n";
$sql .= "   SELECT\n";
$sql .= "       close_day,\n";
$sql .= "       bill_close_day,\n";
$sql .= "       branch_id \n";
$sql .= "   FROM\n";
$sql .= "       t_bill_make_history\n";
$sql .= "   WHERE\n";
$sql .= "       '$now_date' <= t_bill_make_history.bill_close_day\n";
$sql .= "   AND \n";
$sql .= "       t_bill_make_history.bill_close_day < '$next_date'\n";
$sql .= "   AND \n";
$sql .= "       t_bill_make_history.shop_id = $shop_id";
$sql .= "   ) AS bill_close_day_list2\n";
$sql .= "   ON close_day_list.close_day = bill_close_day_list2.close_day\n";
$sql .= "   AND close_day_list.branch_id = bill_close_day_list2.branch_id\n";

$sql .= "ORDER BY branch_cd, CAST(close_day_list.close_day AS int)\n";

$sql .= ";\n";

$result = Db_Query($db_con, $sql);

$page_data = pg_fetch_all($result);

$page_data = Branch_Page_Data($page_data, $now_date, $last_date, $db_con);

/*
print_array($sql);

$page_data = Get_Data($result);

//�������ִ�
for($i = 0; $i < count($page_data); $i++){
    if($page_data[$i][0] < 29){
        $page_data[$i][0] = $page_data[$i][0]."��";
    }else{
        $page_data[$i][0] = "����";
    }
}

print_array($page_data);

/****************************/
//JavaSclipt
/****************************/
$js  = "function Dialog_Double_Post_Prevent(btn_name, hdn_name, hdn_value, str_check)\n";
$js .= "{\n";
    // ��ǧ����������ɽ��
$js .= "    res = window.confirm(str_check+\"\\n��������Ǥ�����\");\n";
$js .= "    var BN = btn_name;\n";
$js .= "    var HN = hdn_name;\n";
$js .= "    var HV = hdn_value;\n";
$js .= "    if (res == true){\n";
$js .= "        dateForm.elements[BN].disabled=true;\n";
$js .= "        dateForm.elements[HN].value=HV;\n";
$js .= "        dateForm.submit();\n";
$js .= "        return true;\n";
$js .= "    }else{\n";
$js .= "        return false;\n";
$js .= "    }\n";
$js .= "}\n";



$js .= "function Text_Disabled(num){\n";

$js .= "  var dis_type    = num;\n";
$js .= "  var dis_date_y1 = \"form_claim_day1[y]\";\n";
$js .= "  var dis_date_m1 = \"form_claim_day1[m]\";\n";
$js .= "  var dis_date_d1 = \"form_claim_day1[d]\";\n";
$js .= "  var dis_branch  = \"form_branch_id\";\n";
$js .= "  var dis_date_y2 = \"form_claim_day2[y]\";\n";
$js .= "  var dis_date_m2 = \"form_claim_day2[m]\";\n";
$js .= "  var dis_date_d2 = \"form_claim_day2[d]\";\n";
$js .= "  var dis_cd1     = \"form_claim[cd1]\";\n";
$js .= "  var dis_cd2     = \"form_claim[cd2]\";\n";
$js .= "  var dis_name    = \"form_claim[name]\";\n";

$js .= "  if(dis_type == '2'){\n";
$js .= "    document.forms[0].elements[dis_date_y2].disabled = false;\n";
$js .= "    document.forms[0].elements[dis_date_m2].disabled = false;\n";
$js .= "    document.forms[0].elements[dis_date_d2].disabled = false;\n";
$js .= "    document.forms[0].elements[dis_cd1].disabled     = false;\n";
$js .= "    document.forms[0].elements[dis_cd2].disabled     = false;\n";
$js .= "    document.forms[0].elements[dis_name].disabled    = false;\n";
$js .= "    document.forms[0].elements[dis_date_y2].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_date_m2].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_date_d2].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_cd1].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_cd2].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_name].style.backgroundColor = \"white\";\n";

$js .= "    document.forms[0].elements[dis_date_y1].disabled = true;\n";
$js .= "    document.forms[0].elements[dis_date_m1].disabled = true;\n";
$js .= "    document.forms[0].elements[dis_date_d1].disabled = true;\n";
$js .= "    document.forms[0].elements[dis_branch].disabled  = true;\n";
$js .= "    document.forms[0].elements[dis_date_y1].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_date_m1].style.backgroundColor = \"gainsboro\"\n";
$js .= "    document.forms[0].elements[dis_date_d1].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_branch].style.backgroundColor  = \"gainsboro\";\n";
$js .= "  }else{\n";
$js .= "    document.forms[0].elements[dis_date_y1].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_date_m1].style.backgroundColor = \"white\"\n";
$js .= "    document.forms[0].elements[dis_date_d1].style.backgroundColor = \"white\";\n";
$js .= "    document.forms[0].elements[dis_branch].style.backgroundColor  = \"white\";\n";
$js .= "    document.forms[0].elements[dis_date_y1].disabled = false;\n";
$js .= "    document.forms[0].elements[dis_date_m1].disabled = false;\n";
$js .= "    document.forms[0].elements[dis_date_d1].disabled = false;\n";
$js .= "    document.forms[0].elements[dis_branch].disabled  = false;\n";

$js .= "    document.forms[0].elements[dis_date_y2].disabled = true;\n";
$js .= "    document.forms[0].elements[dis_date_m2].disabled = true;\n";
$js .= "    document.forms[0].elements[dis_date_d2].disabled = true;\n";
$js .= "    document.forms[0].elements[dis_cd1].disabled     = true;\n";
$js .= "    document.forms[0].elements[dis_cd2].disabled     = true;\n";
$js .= "    document.forms[0].elements[dis_name].disabled    = true;\n";
$js .= "    document.forms[0].elements[dis_date_y2].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_date_m2].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_date_d2].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_cd1].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_cd2].style.backgroundColor = \"gainsboro\";\n";
$js .= "    document.forms[0].elements[dis_name].style.backgroundColor = \"gainsboro\";\n";
$js .= "  }\n";

$js .= "}";

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
$page_menu = Create_Menu_h('sale','3');
/****************************/
//���̥إå�������
/****************************/
//.$page_header = Create_Header($page_title);
$page_header = Bill_Header($page_title);

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
    'code_value'    => "$code_value",
    'last_date'     => "$last_m",
    'now_date'      => "$now_m",
    'error'         => "$error",
    'js'            => "$js",
));

$smarty->assign("page_data",$page_data);
$smarty->assign("err_msg",$err_msg);
$smarty->assign("pay_err",$pay_err);
$smarty->assign("sale_err",$sale_err);
$smarty->assign("advance_err",$advance_err);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>