<?php

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/10/11���ʤ���������yamanaka-s���������ƥ೫�������������դ�����������Ƚ�Ǥ���������ɲ�
 * ��2006/10/13���ʤ���������yamanaka-s������ʧ���Ϥ�Ʊ���褦��FC(client_div = 3)����Խ����ط��ʤ��оݤȤ���
 * ��2006/10/13���ʤ���������yamanaka-s����̤������դ��������Ǥ��ʤ��褦��
 * ��2006/10/16���ʤ���������yamanaka-s����ľ�Ĥξ���ľ�����ΤΥǡ�����ͭ�򤹤�褦���ѹ�
 * ��2006/10/19���ʤ���������yamanaka-s�����������η׻����оݤη�˥��������򵯤����Ƥ��ʤ���������оݳ��Ȥ���
 * ��2006/10/19���ʤ���������yamanaka-s���������إå����ơ��֥��INSERT��ʬ�Ǽ����̾������̾(ά��)���ѹ�
 *   2006/11/27              watanabe-k    ���ꤷ�����λ�ʧ��ۤ�2����ʬ��Ф����Х��ν���
 *   2006/11/27              watanabe-k    FC�Υǡ�������Ͽ����Ƥ��ʤ��Х��ν���
 *   2006/11/29              watanabe-k    FC�λ�ʧ������Ͽ����Ƥ��ʤ��Х��ν���
 *   2006-12-09  ban_0116    suzuki        ���դ򥼥����
 *   2006-12-10              watanabe-k    �����ʧͽ��ۤ����SQL���Ϥ��������������ʤ��Х��ν���
 *   2006-12-13  scl_0066    watanabe-k    �������ƥ���ɼ�ǻ��������������ʤ��Х��ν��� 
 *   2006-12-14  scl_0080    watanabe-k    2�����ܰʹߤλ�ʧͽ��ۤ��������ʤ��Х��ν��� 
 *   2007-01-22              watanabe-k    ̤������դ������Ԥ���Х��ν���
 *   2007-01-22              watanabe-k    �����ʧͽ��ۤ��������ʤ��Х��ν���
 *   2007-01-22              watanabe-k    2��ʬ�κ����ʧͽ��ۤ��������ʤ��Х��ν��� 
 *   2007-02-22              watanabe-k    �������Ǥν������ɲ� 
 *   2007-03-20              watanabe-k    RtoR����ɼ����� 
 *   2007-05-31              watanabe-k    RtoR����ɼ��ʣ�������Ǥ���褦�˽��� 
 *   2007-06-06              watanabe-k    �������������Ĥ��褦�˽��� 
 *   2007-06-14              watanabe-k    ��ʧ�������˥��󥿥å������顼��ɽ�������Х��ν��� 
 *   2007-06-16              watanabe-k    �Ĺ⣰�ξ��˴ְ�ä�ͽ��ǡ�������夬��Х��ν���
 *   2007-06-27              watanabe-k    Ʊ�����Ǻƺ������ǽ�ˤ���褦���ѹ�
 *   2007-07-11             fukuda-s        �ֻ�ʧ���פ�ֻ������פ��ѹ�
 *   2007-08-21              watanabe-k    ����������ۤ����ξ��˥ǡ����������ʤ��褦�˽���
 *   2007-08-22              watanabe-k    ���������Фλ��ͤ����������
 *   2007-11-15              watanabe-k    ����������ɲä�����ۤ����ƣ��ξ��Ȥ��������ɲ�
 *   2008-05-31              watanabe-k    �������ƥ���0�ʳ��ǵ������褦�˽���
 *   2009-12-29              aoyama-n      ��Ψ��TaxRate���饹�������
 *   2011-11-19              hashimoto-y   mktime�ؿ�������ˡ�ν�����������������ݤ�������������Ǥ��ʤ��Х���
 */
 
 
$page_title = "����������";

//����������
$today = date('Y-m-d');

//�Ķ�����ե�����
require_once("ENV_local.php");

//��󥿥���ɼ�����ؿ��ե�����
require_once(INCLUDE_DIR."rental.inc");
require_once(INCLUDE_DIR."function_keiyaku.inc");
//���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����
require_once(INCLUDE_DIR."schedule_payment.inc");


//HTML_QuickForm
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth = Auth_Check($conn);

// ���ϡ��ѹ�����̵����å�����
//$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;

// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//�������
//$def_data["form_slipout_type"] = '1';
$form->setDefaults($def_data);

// HTML�إå�
$html_header = Html_Header($page_title);

// HTML�եå�
$html_footer = Html_Footer();

// ���̥إå�������
// ��ʧͽ����� �ݥܥ���ο����ѹ� 2007.06.14��
$form->addElement("button", "2-2-307", "����������", "style=color:#ff0000 onClick=\"location.href='$_SERVER[PHP_SELF]'\"".$g_button_color);

// ����
$form->addElement("button", "2-2-301", "��ʧͽ�����", "onClick=\"javascript:Referer('2-3-301.php')\"");
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-307"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-301"]]->toHtml();
$page_header = Create_Header($page_title);
$page_header = Create_Header($page_title);


/************�����ѿ�����****************/
$shop_id = $_SESSION["client_id"];
$staff_id = $_SESSION["staff_id"];
$staff_name = $_SESSION["staff_name"];
//print_array($_SESSION);

#2009-12-29 aoyama-n
//��Ψ���饹�����󥹥�������
$tax_rate_obj = new TaxRate($shop_id);

/***************** �ե�����ѡ������ *****************/
// �¹ԥܥ���
$form->addElement(
    "submit", 
    "submit", 
    "������", 
    "onClick=\"javascript:return Dialogue4('��������Ԥ��ޤ���')\" $disabled"
);




//�����Υե�������
//¸�ߤ����������������
$sql  = "SELECT";
$sql .= "       DISTINCT close_day";
$sql .= " FROM";
$sql .= "       t_client";
$sql .= " WHERE";
$sql .= "( \n";
//ľ�Ĥξ��ϥǡ�����ͭ����	2006-10-16
//$sql .= "       shop_id = $shop_id";
/*
if($_SESSION[group_kind] == "2"){
     $sql .= "   shop_id IN (".Rank_Sql().") ";
     $sql .= " AND \n";
     $sql .= "   client_div = '2'\n";
     $sql .= " ) \n";
     $sql .= " OR";
     $sql .= " ( \n";
     $sql .= "      client_div = '3' \n";
     $sql .= " AND \n";
     $sql .= "      shop_id = 1 \n";
}else{
     $sql .= "   shop_id = $shop_id";
     $sql .= " AND \n";
     $sql .= "        (t_client.client_div = '2' OR t_client.client_div = '3') \n";
}
*/

$sql .= "   t_client.client_div = '2' ";
$sql .= "   AND ";
$sql .= "   t_client.shop_id = $shop_id";
$sql .= ") \n";

/*		2006-10-13	�����ѹ�����ʧ���Ϥ�Ʊ���褦��FC��������Ф���褦�˽���
$sql .= " UNION \n";				//2006-09-19	FC�Τ�client_div��3���оݤˤʤ�١��ѹ�
$sql .= " SELECT \n";
$sql .= "       t_client.close_day \n";
$sql .= " FROM \n";
$sql .= "       t_client \n";
$sql .= " WHERE \n";
$sql .= "       client_id IN ( \n";
$sql .= "              SELECT \n";
$sql .= "                     t_buy_h.client_id \n";
$sql .= "              FROM \n";
$sql .= "                     t_client \n";
$sql .= "              INNER JOIN t_buy_h ON \n";
$sql .= "                     t_buy_h.shop_id = $shop_id \n";
$sql .= "              WHERE \n";
$sql .= "                     t_client.client_id = t_buy_h.client_id \n";
$sql .= "              AND \n";
$sql .= "                     (intro_sale_id IS NOT NULL OR act_sale_id IS NOT NULL) \n";
$sql .= "       ); \n";
*/

$result = Db_Query($conn, $sql);
$num = @pg_num_rows($result);
$select_value[] = null;

//2006/09/12	�����Ƚ������ɲ�
for($i = 0; $i < $num; $i++){
	$client_close_day[] = @pg_fetch_result($result, $i,0);
}
//print_array($client_close_day);
asort($client_close_day);
$client_close_day = array_values($client_close_day);
//print_array($client_close_day);
for($i = 0; $i < $num; $i++){
    //1��28��
    if($client_close_day[$i] < 29 && $client_close_day[$i] != ''){
        $select_value[$client_close_day[$i]] = $client_close_day[$i]."��";
    }
    //29���ʾ�
    elseif($client_close_day[$i] != '' && $client_close_day[$i] >= 29){
        $select_value[$client_close_day[$i]] = "����";
    }
}


//�ե�����ѡ���
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
$form_claim_day1[] =& $form->createElement("select", "d", "", $select_value);
$form->addGroup( $form_claim_day1, "form_claim_day1", "��������","");


/*************PREPARE��SQL*************/
$data  = "SELECT";
$data .= "       t_client.client_id, \n";
$data .= "       t_client.client_name, \n";
$data .= "       t_client.client_name2, \n";
$data .= "       t_client.client_cname, \n";
$data .= "       t_client.client_cd1, \n";
$data .= "       t_client.client_cd2, \n";	//2006/09/12	�����ɲ�
$data .= "       t_client.bank_name, \n";	//���Ѥ��Ƥ��ʤ�
$data .= "       t_client.b_bank_name, \n";
$data .= "       t_client.intro_ac_num, \n";
$data .= "       t_client.account_name, \n";
$data .= "       t_client.trade_id, \n";
$data .= "       t_client.close_day, \n";
$data .= "       t_client.payout_m, \n";
$data .= "       t_client.payout_d, \n";
$data .= "       t_client.coax, \n";
$data .= "       t_client.tax_div, \n";
$data .= "       t_client.tax_franct, \n";
$data .= "       t_client.c_tax_div, \n";
//$data .= "       t_client.tax_rate_n, \n";	2006/09/12
$data .= "       t_client.royalty_rate, \n";
$data .= "       t_client.shop_id, \n";
$data .= "       t_client.col_terms, \n";
$data .= "       last_payment_data.payment_close_day, \n";
$data .= "       last_payment_data.schedule_of_payment_this, \n";
$data .= "       last_payment_data.ca_balance_this, \n";
$data .= "       last_payment_data.payment_extraction_e, \n";
$data .= "       COALESCE(total_buy_payment.total_net_amount, 0) AS total_net_amount, \n";
$data .= "       COALESCE(total_buy_payment.total_tax_amount, 0) AS total_tax_amount, \n";
$data .= "       COALESCE(total_buy_close_day.total_buy_amount, 0) AS total_buy_amount, \n";
$data .= "       COALESCE(total_buy_close_day.total_no_tax_buy_amount, 0) AS total_no_tax_buy_amount, \n";
$data .= "       COALESCE(total_kup.total_net_kup_amount, 0) AS total_net_kup_amount, \n";
$data .= "       COALESCE(total_kup.total_tax_net_amount, 0) AS total_tax_net_amount, \n";
$data .= "       COALESCE(total_split_pay_amount.total_split_pay_amount, 0) AS total_split_pay_amount, \n";
$data .= "       COALESCE(total_pay1.total_pay_amount, 0) AS total_pay_amount, \n";					//2006/09/22	����
$data .= "       COALESCE(total_pay2.total_adjustment_amount, 0) AS total_adjustment_amount, \n";	//2006/09/22	����
$data .= "       COALESCE(total_split_pay_kup_amount.total_split_pay_balance_amount, 0) AS total_split_pay_balance_amount, \n";
$data .= "       COALESCE(total_royalty_amount.total_royalty_buy_amount, 0) AS total_royalty_buy_amount, \n";
$data .= "       COALESCE(total_royalty_amount.total_no_tax_royalty_buy_amount, 0) AS total_no_tax_royalty_buy_amount, \n";
$data .= "       t_client.col_terms, \n";
$data .= "       t_client.client_div, \n";		//2006-09-19	�����ɲ�
$data .= "       t_client.head_flg \n";
/*******�������ݾ�������********/
$data .= " FROM  \n";
$data .= "      t_client LEFT JOIN ( \n";
$data .= "               SELECT \n";
$data .= "                      t_schedule_payment.client_id,  \n";
$data .= "                      t_schedule_payment.payment_close_day,  \n";
//$data .= "                      t_schedule_payment.schedule_of_payment_this,  \n";

$data .= "                      CASE t_schedule_payment.payout_schedule_id ";
$data .= "                          WHEN 0 THEN 0 \n";
$data .= "                          ELSE schedule_of_payment_this ";
$data .= "                      END AS schedule_of_payment_this, ";

$data .= "                      t_schedule_payment.ca_balance_this,  \n";
$data .= "                      t_schedule_payment.payment_extraction_e \n";
$data .= "               FROM \n";
$data .= "                      t_schedule_payment \n";
$data .= "               WHERE \n";
$data .= "                      schedule_payment_id = ( \n";
$data .= "                               SELECT \n";
$data .= "                                      MAX(schedule_payment_id) \n";
$data .= "                               FROM \n";
$data .= "                                      t_schedule_payment \n";
$data .= "                               WHERE \n";
$data .= "                                      client_id = $1 \n";
$data .= "                               AND \n";
$data .= "                                      shop_id = $2 \n";
$data .= "                               GROUP BY \n";
$data .= "                                      client_id, shop_id \n";
$data .= "                               ) \n";
$data .= "              ) AS last_payment_data \n";
$data .= "      ON t_client.client_id = last_payment_data.client_id \n";
$data .= "      LEFT JOIN ( \n";
/*******�ݻ������㤤�夲�ۤ����(����ñ�̤���ɼñ��)********/
$data .= "               SELECT \n";
$data .= "                      COALESCE( SUM(net_amount * CASE trade_id WHEN 21 THEN 1 ELSE -1 END))AS total_net_amount, \n";
$data .= "                      COALESCE( SUM(tax_amount * CASE trade_id WHEN 21 THEN 1 ELSE -1 END))AS total_tax_amount, \n";
$data .= "                      client_id \n";
$data .= "               FROM \n";
$data .= "                      t_buy_h \n";
$data .= "               WHERE \n";
$data .= "                      client_id = $1 \n";
$data .= "               AND \n";
$data .= "                      shop_id = $2 \n";
$data .= "               AND \n";
$data .= "                      buy_day > ( \n";
$data .= "                             SELECT \n";
$data .= "                                    COALESCE (MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                             FROM \n";
$data .= "                                    t_schedule_payment \n";
$data .= "                             WHERE \n";
$data .= "                                    client_id = $1 \n";
$data .= "                             AND \n";
$data .= "                                    shop_id = $2) \n";
$data .= "               AND \n";
$data .= "                      buy_day <= $3 \n";
$data .= "               AND \n";
$data .= "                      trade_id IN (21,23,24) \n";
$data .= "               GROUP BY client_id, shop_id \n";
$data .= "               ) AS total_buy_payment \n";
$data .= "      ON t_client.client_id = total_buy_payment.client_id \n";
$data .= "      LEFT JOIN ( \n";
/*******�ݻ������㤤�夲�ۤ����(����ñ�̤�����ñ��)********/
$data .= "                SELECT \n";
$data .= "                       COALESCE( SUM(CASE WHEN t_buy_d.tax_div = '1' THEN t_buy_d.buy_amount * CASE t_buy_h.trade_id WHEN 21 THEN 1 ELSE -1 END END), 0) AS total_buy_amount, \n";
$data .= "                       COALESCE( SUM(CASE WHEN t_buy_d.tax_div = '3' THEN t_buy_d.buy_amount * CASE t_buy_h.trade_id WHEN 21 THEN 1 ELSE -1 END END), 0) AS total_no_tax_buy_amount, \n";
$data .= "                       t_buy_h.client_id \n";
$data .= "                FROM \n";
$data .= "                       t_buy_h \n";
$data .= "                INNER JOIN \n";
$data .= "                       t_buy_d \n";
$data .= "                ON \n";
$data .= "                       t_buy_h.buy_id = t_buy_d.buy_id \n";
$data .= "                WHERE \n";
$data .= "                       t_buy_h.client_id = $1 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.buy_day > ( \n";
$data .= "                                   SELECT \n";
$data .= "                                          COALESCE (MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                                   FROM \n";
$data .= "                                          t_schedule_payment \n";
$data .= "                                   WHERE \n";
$data .= "                                          client_id = $1 \n";
$data .= "                                   AND \n";
$data .= "                                          shop_id = $2) \n";
$data .= "                AND \n"; 
$data .= "                       t_buy_h.buy_day <= $3 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.trade_id IN (21,23,24) \n";
$data .= "                GROUP BY t_buy_h.client_id \n";
$data .= "               ) AS total_buy_close_day \n";
$data .= "      ON t_client.client_id = total_buy_close_day.client_id \n";
$data .= "      LEFT JOIN ( \n";
/*******�ֳ���������㤤�夲��(����)��********/
$data .= "                SELECT \n";
$data .= "                       SUM(net_amount) AS total_net_kup_amount, \n";	//total_net_amount����total_net_kup_amount��̾�����ѹ�
$data .= "                       SUM(tax_amount) AS total_tax_net_amount, \n";
$data .= "                       t_buy_h.client_id \n";
$data .= "                FROM \n";
$data .= "                       t_buy_h \n";
$data .= "                WHERE \n";
$data .= "                       client_id = $1 \n";
$data .= "                AND \n";
$data .= "                       shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.buy_day > ( \n";
$data .= "                                   SELECT \n";
$data .= "                                           COALESCE( MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                                   FROM \n";
$data .= "                                           t_schedule_payment \n";
$data .= "                                   WHERE \n";
$data .= "                                           client_id = $1 \n";
$data .= "                                   AND \n";
$data .= "                                           shop_id = $2) \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.buy_day <= $3 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.trade_id = 25 \n";
$data .= "                GROUP BY t_buy_h.client_id \n";
$data .= "               ) AS total_kup \n";
$data .= "      ON t_client.client_id = total_kup.client_id \n";
$data .= "      LEFT JOIN ( \n";
/*******�ݻ����ȳ���Υ������ƥ��ۤ����********/
$data .= "                SELECT \n";
$data .= "                       COALESCE( SUM( CASE WHEN t_buy_d.tax_div = '1' THEN t_buy_d.buy_amount * CASE WHEN t_buy_h.trade_id = 21 OR t_buy_h.trade_id = 25 OR t_buy_h.trade_id = 71 THEN 1 ELSE -1 END END ) , 0 ) AS total_royalty_buy_amount, \n";
$data .= "                       COALESCE(  SUM( CASE WHEN t_buy_d.tax_div = '3' THEN t_buy_d.buy_amount * CASE WHEN t_buy_h.trade_id = 21 OR t_buy_h.trade_id = 25 OR t_buy_h.trade_id = 71 THEN 1 ELSE -1 END END ) , 0  ) AS total_no_tax_royalty_buy_amount, \n";
$data .= "                       t_buy_h.client_id \n";
$data .= "                FROM \n";
$data .= "                       t_buy_h \n";
$data .= "                INNER JOIN \n";
$data .= "                       t_buy_d \n";
$data .= "                ON \n";
$data .= "                       t_buy_h.buy_id = t_buy_d.buy_id \n";
$data .= "                WHERE \n";
$data .= "                       t_buy_h.client_id = $1 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.buy_day > ( \n";
$data .= "                                   SELECT \n";
$data .= "                                            COALESCE (MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                                   FROM \n";
$data .= "                                            t_schedule_payment \n";
$data .= "                                   WHERE \n";
$data .= "                                            client_id = $1 \n";
$data .= "                                   AND \n";
$data .= "                                            shop_id = $2) \n";
$data .= "                AND \n";
$data .= "                      t_buy_h.buy_day <= $3 \n";
$data .= "                AND \n";
$data .= "                      t_buy_h.trade_id IN (21, 23, 24, 25, 71, 73, 74) \n";
$data .= "                AND \n";
$data .= "                      t_buy_d.royalty = '1' \n";
$data .= "                GROUP BY t_buy_h.client_id \n";
$data .= "                 ) AS total_royalty_amount \n";
$data .= "      ON t_client.client_id = total_royalty_amount.client_id \n";
$data .= "      LEFT JOIN ( \n";
/*******��������λ�ʧ��ۤ����********/
$data .= "                SELECT \n";
$data .= "                       SUM(t_amortization.split_pay_amount) AS total_split_pay_amount, \n";
$data .= "                       t_buy_h.client_id \n";
$data .= "                FROM \n";
$data .= "                       t_buy_h \n";
$data .= "                INNER JOIN \n";
$data .= "                        t_amortization \n";
$data .= "                ON \n";
$data .= "                       t_buy_h.buy_id = t_amortization.buy_id \n";
$data .= "                WHERE \n";
$data .= "                       t_buy_h.client_id = $1 \n";
$data .= "                AND \n";
$data .= "                       t_buy_h.shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                       t_amortization.pay_day > ( \n";
$data .= "                                   SELECT \n";
$data .= "                                            COALESCE (MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                                   FROM \n";
$data .= "                                            t_schedule_payment \n";
$data .= "                                   WHERE \n";
$data .= "                                            client_id = $1 \n";
$data .= "                                   AND \n";
$data .= "                                            shop_id = $2) \n";
$data .= "                AND \n";
$data .= "                      t_amortization.pay_day <= $3 \n";
$data .= "                AND \n";
$data .= "                      t_buy_h.trade_id = 25 \n";
$data .= "                GROUP BY \n";
$data .= "                      t_buy_h.client_id \n";
$data .= "               ) AS total_split_pay_amount \n";
$data .= "      ON t_client.client_id = total_split_pay_amount.client_id \n";
$data .= "      LEFT JOIN ( \n";
/*******��ʧ�ۤ����********/		//2006-09-22	����
$data .= "                SELECT \n";
$data .= "                       SUM (t_payout_d.pay_amount) AS total_pay_amount, \n";
$data .= "                       t_payout_h.client_id \n";
$data .= "                FROM \n";
$data .= "                       t_payout_h \n";
$data .= "                INNER JOIN t_payout_d \n";
$data .= "                ON t_payout_h.pay_id = t_payout_d.pay_id \n";
$data .= "                WHERE \n";
$data .= "                       t_payout_h.client_id = $1 \n";
$data .= "                AND \n";
$data .= "                       t_payout_h.shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                       t_payout_h.pay_day > ( \n";
$data .= "                                   SELECT \n";
$data .= "                                            COALESCE ( MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                                   FROM \n";
$data .= "                                            t_schedule_payment \n";
$data .= "                                   WHERE \n";
$data .= "                                            client_id = $1 \n";
$data .= "                                   AND \n";
$data .= "                                            shop_id = $2) \n";
$data .= "                AND t_payout_h.pay_day <= $3 \n";
$data .= "                AND buy_id IS NULL \n";
$data .= "                GROUP BY t_payout_h.client_id \n";
$data .= "               ) AS total_pay1 \n";
$data .= "      ON t_client.client_id = total_pay1.client_id \n";
$data .= "      LEFT JOIN ( \n";

/*******��ʧ�ۤ����********/
$data .= "                SELECT \n";
$data .= "                       SUM (CASE WHEN trade_id = 46 THEN t_payout_d.pay_amount END ) AS total_adjustment_amount, \n";
$data .= "                       t_payout_h.client_id \n";
$data .= "                FROM \n";
$data .= "                       t_payout_h \n";
$data .= "                INNER JOIN t_payout_d \n";
$data .= "                ON t_payout_h.pay_id = t_payout_d.pay_id \n";
$data .= "                WHERE \n";
$data .= "                       t_payout_h.client_id = $1 \n";
$data .= "                AND \n";
$data .= "                       t_payout_h.shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                       t_payout_h.pay_day > ( \n";
$data .= "                                   SELECT \n";
$data .= "                                            COALESCE ( MAX(payment_close_day), '".START_DAY."') \n";
$data .= "                                   FROM \n";
$data .= "                                            t_schedule_payment \n";
$data .= "                                   WHERE \n";
$data .= "                                            client_id = $1 \n";
$data .= "                                   AND \n";
$data .= "                                            shop_id = $2) \n";
$data .= "                AND t_payout_h.pay_day <= $3 \n";
$data .= "                GROUP BY t_payout_h.client_id \n";
$data .= "               ) AS total_pay2 \n";
$data .= "      ON t_client.client_id = total_pay2.client_id \n";
$data .= "      LEFT JOIN ( \n";

/*******��������λĹ�����********/
$data .= "                SELECT \n";
$data .= "                      SUM (t_amortization.split_pay_amount) AS total_split_pay_balance_amount, \n";
$data .= "                      t_buy_h.client_id \n";
$data .= "                FROM \n";
$data .= "                      t_buy_h \n";
$data .= "                INNER JOIN t_amortization \n";
$data .= "                ON t_buy_h.buy_id = t_amortization.buy_id \n";
$data .= "                WHERE \n";
$data .= "                      t_buy_h.client_id = $1 \n";
$data .= "                AND \n";
$data .= "                      t_buy_h.shop_id = $2 \n";
$data .= "                AND \n";
$data .= "                      t_amortization.pay_day > $3 \n";
$data .= "                AND \n";
$data .= "                      t_buy_h.trade_id = 25 \n";
$data .= "                GROUP BY t_buy_h.client_id \n";
$data .= "                ) AS total_split_pay_kup_amount \n";
$data .= "      ON t_client.client_id = total_split_pay_kup_amount.client_id \n";
$data .= " WHERE \n";
$data .= "       t_client.close_day = $4 \n";
$data .= " AND \n";
$data .= "       t_client.client_id = $1 \n";


$sql = " PREPARE get_schedule(int, int, date, varchar) AS $data";
Db_Query($conn, $sql);


//��ʧͽ��ơ��֥뤫�麣��λ�ʧͽ����оݤȤʤ�ǡ��������
$data  = "           SELECT \n";
$data .= "                 SUM (account_payable) AS total_account_payable, \n";
$data .= "                 SUM (installment_purchase) AS total_installment_purchase \n";
$data .= "           FROM \n";
$data .= "                 t_schedule_payment \n";
$data .= "           WHERE \n";
$data .= "                 t_schedule_payment.client_id = $1 \n";
$data .= "           AND \n";
$data .= "                 t_schedule_payment.shop_id = $2 \n";
$data .= "           AND \n";
//$data .= "                 payment_expected_date > $3 \n";
$data .= "          payout_schedule_id IS NULL \n";
$data .= "           AND \n";

$data .= "          payment_expected_date <= $4";

//$data .= "          GROUP BY payment_close_day, t_schedule_payment.schedule_payment_id \n";
//$data .= "          GROUP BY payment_close_day \n";

//$sql = " PREPARE get_schedule_payment(int, int, date, date, int, int) AS $data";
$sql = " PREPARE get_schedule_payment(int, int, date, date) AS $data";
Db_Query($conn, $sql);


//�����ʧͽ�������ʧͽ��ơ��֥뤫���������
$data  = " SELECT \n";
$data .= "       MAX(payment_expected_date) AS last_expected_day \n";
$data .= " FROM \n";
$data .= "       t_schedule_payment \n";
$data .= " WHERE \n";
$data .= "       t_schedule_payment.client_id = $1 \n";
$data .= " AND \n";
$data .= "       t_schedule_payment.shop_id = $2 \n";

$sql = " PREPARE get_expected_date(int, int) AS $data";

Db_Query($conn, $sql);


//ʬ���ʧ�ۤ��оݤδ��֤Ǻ������(����λ�ʧͽ������[2-4] �� [11-15])
$data  = " SELECT \n";
$data .= "         SUM(t_amortization.split_pay_amount) AS re_total_split_pay_amount, \n";
$data .= "         t_buy_h.client_id \n";
$data .= " FROM \n";
$data .= "         t_buy_h \n";
$data .= " INNER JOIN \n";
$data .= "         t_amortization \n";
$data .= " ON \n";
$data .= "         t_buy_h.buy_id = t_amortization.buy_id \n";
$data .= " WHERE \n";
$data .= "         t_buy_h.client_id = $1 \n";
$data .= " AND \n";
$data .= "         t_buy_h.shop_id = $2 \n";
$data .= " AND \n";
//���֤ǽ��פ���ΤǤϤʤ�����ʧͽ��ID��NULL�Τ�Τ򽸷��оݤˤ���褦�˽���
//$data .= "         t_amortization.pay_day > $3 \n";
$data .= "        t_amortization.schedule_payment_id IS NULL \n";
$data .= " AND \n";
/*
$data .= "         t_amortization.pay_day <=  ( \n";
$data .= "                 SELECT \n";
$data .= "                        CASE WHEN payout_d = '29' THEN \n";
$data .= "                             SUBSTR(TO_DATE(SUBSTR($4,1,8) || 01, 'YYYY-MM-DD') + (($5 + 1 ) * interval '1 month') - interval '1 day',1,10) \n";
$data .= "                        ELSE \n";
$data .= "                             SUBSTR(TO_DATE($4, 'YYYY-MM-DD') + ($5 * interval '1 month'), 1, 8) || LPAD($6,2,0) \n";
$data .= "                        END \n";
$data .= "                 FROM \n";
$data .= "                        t_client \n";
$data .= "                 WHERE \n";
$data .= "                        client_id = $1 \n";
$data .= "                 AND \n";
$data .= "                        shop_id = $2 \n";
$data .= "                 )\n";
*/
$data .= "      t_amortization.pay_day <= $4 \n";
$data .= " AND \n";
$data .= "         t_buy_h.trade_id = 25 \n";
$data .= " GROUP BY \n";
$data .= "         t_buy_h.client_id \n";

//$sql = " PREPARE re_total_split_pay_amount(int, int, date, date, int, int) AS $data";
$sql = " PREPARE re_total_split_pay_amount(int, int, date, date) AS $data";

Db_Query($conn, $sql);


//UPDATE��PREPARE
$data  = "UPDATE t_schedule_payment set \n";
$data .= "       schedule_of_payment_this = $1, \n";
$data .= "       installment_payment_this = $2, \n";
$data .= "       last_update_day = $4 \n";
$data .= "WHERE \n";
$data .= "       schedule_payment_id = $3";

$sql = "PREPARE update_t_schedule_payment (bigint, bigint, bigint, date) AS $data";
Db_Query($conn, $sql);


/******** Ƚ�� *********/
$post_jikkou = ($_POST["submit"] == "������") ? true : false;

//�������ܥ��󲡲��ե饰��true�ξ��
if($post_jikkou == true){
	//�ȥ�󥶥�����󳫻�
	Db_Query($conn, "BEGIN;");


	//���ռ���
	$post_close_day_y = $_POST["form_claim_day1"]["y"];
	$post_close_day_m = $_POST["form_claim_day1"]["m"];
	$post_close_day_d = $_POST["form_claim_day1"]["d"];
	
	//�����ͥ����å�
	if($post_close_day_y == null || $post_close_day_m == null || $post_close_day_d == 0){
		$payment_day_flg = true;
	}
	else{
	
		//���շ׻�	���Ϥ��줿���� OR ���Ϥ��줿��η������֤�
	    $post_close_day = set_close_day($post_close_day_y,$post_close_day_m,$post_close_day_d);
		
		//��������ξ��
		if($post_close_day_d >= 29){
			
			//�쥢������ ��ǯ�ʳ���2��Ƚ����� ������28�����Ѵ�����
			$day = $post_close_day_y.'-'.$post_close_day_m.'-'.'01';
			$check_last_day = date("t",strtotime($day));
			
			if($post_close_day_m == '2' || $post_close_day_m == '02'){
				$check_day = $check_last_day;
			}
			//��ǯ�ξ���29���򥻥å�
			else{
				$check_day = $check_last_day;
			}
		}
		//�����ʳ�
		else{
			if($post_close_day_d < 10){
				$check_day = str_pad($post_close_day_d, 2, 0, STR_PAD_LEFT);
			}
			else{
				$check_day = $post_close_day_d;
			}
		}
		//���������������å�
		//$payment_day_flg = (checkdate($post_close_day_m, $check_day, $post_close_day_y) == false)? true : false ;		2006/09/21	����
		$payment_day_flg = (checkdate((int)$post_close_day_m, (int)$check_day, (int)$post_close_day_y) == false)? true : false ;
	
		//ǯ����ϰϤ���ꤹ���Ѥ�ǯ������������� sample_day = ���Ϥ��줿��
		$sample_day = str_pad($post_close_day_y,4,0,STR_PAD_LEFT).'-'.str_pad($post_close_day_m,2,0,STR_PAD_LEFT).'-'.$check_day;
		
		//2006-10-11	���Ϥ��줿���դ������ƥ೫���������ξ��ϥ��顼�Ȥ���
		if(strtotime($post_close_day) < strtotime(START_DAY)){
			$payment_day_flg = true;
		}
		
        $renew_day_flg = Payment_Monthly_Renew_Check($conn, $sample_day);

		//2006-10-13	̤���������������
//		$future_flg = (date('Ymt') < $post_close_day_y.$post_close_day_m.$post_close_day_d)? true : false;

        $target_day_y = str_pad($post_close_day_y,4,0,STR_PAD_LEFT);
        $target_day_m = str_pad($post_close_day_m,2,0,STR_PAD_LEFT);
        $target_day_d = str_pad($post_close_day_d,2,0,STR_PAD_LEFT);

        $target_day = $target_day_y.$target_day_m.$target_day_d;
        $future_flg = (date('Ymd') < $target_day)? true : false;
	}
	
	//�����������������դ����Ϥ��줿���
    if($payment_day_flg == false && $future_flg == false && $renew_day_flg != true){
		
		//����(���Τ�)�Ȥ��ƻ��Ѥ�����ѿ�����
		//����
		if($post_close_day_d >= 29){
				$serch_post_day = 29;
			}
		//�����ʳ�
		else{
			//���դ����
			if($post_close_day_d < 10){
				$serch_post_day = str_pad($post_close_day_d, 2, 0, STR_PAD_LEFT);
			}
			//���դ����
			else{
				$serch_post_day = $post_close_day_d;
			}
		}
		
		/*******�������ƥ��ξ��ʤΥǡ��������(FC�Τߤε�ǽ)********/
/*
		$sql  = " SELECT \n";
		$sql .= "       goods_cd, \n";					//[14-1]���ʥ�����
		$sql .= "       goods_name, \n";				//[14-2]����̾
		$sql .= "       royalty as royalty_div \n";		//[14-3]�������ƥ���AS���������ƥ���ʬ
		$sql .= " FROM \n";
		$sql .= "       t_goods \n";
		$sql .= " WHERE \n";
		$sql .= "       goods_cd = '0000002' \n";
		
		$result = Db_Query($conn, $sql);
		$royalty_info = @pg_fetch_all($result);

        /******�������Ǥξ��ʤΥǡ��������**************************/
/*
        $sql  = "SELECT \n";
        $sql .= "   goods_id, \n";
        $sql .= "   goods_cd, \n";
        $sql .= "   goods_name, \n";
        $sql .= "   royalty as royalty_div \n";
        $sql .= "FROM \n";
        $sql .= "   t_goods \n";
        $sql .= "WHERE \n";
        $sql .= "   goods_cd = '0000001' ";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $lump_info = @pg_fetch_all($result);
	
		/*******��ʬ�ξ�����������********/
		$sql  = " SELECT \n";
        #2009-12-29 aoyama-n
		#$sql .= "       tax_rate_n, \n";
		$sql .= "       royalty_rate \n";
		$sql .= " FROM \n";
		$sql .= "       t_client \n";
		$sql .= " WHERE \n";
		$sql .= "       client_id = $shop_id ";
		
		$result = Db_Query($conn, $sql);
		$my_base_info = @pg_fetch_all($result);

		//�ͤ򥭥㥹��
        #2009-12-29 aoyama-n
		#$base_info["tax_rate_n"] = (int)$my_base_info[0]["tax_rate_n"];
		$base_info["royalty_rate"] = (int)$my_base_info[0]["royalty_rate"];
		
		/*******���Ϥ��줿�����ǹʤä�����������********/
		$sql  = " SELECT \n";
		$sql .= "        t_client.client_id, \n";
        $sql .= "        t_client.head_flg \n";
		$sql .= " FROM \n";
		$sql .= "        t_client \n";
		$sql .= " WHERE \n";
		$sql .= "        t_client.close_day = ".(int)$serch_post_day." \n";
		$sql .= " AND \n";
        $sql .= "        t_client.client_div = '2' ";
        $sql .= " AND \n";
        $sql .= "        t_client.shop_id = $shop_id ";
        $sql .= ";";
//        $sql .= "((t_client.client_div = '2' AND shop_id = $shop_id) OR t_client.client_div = '3')";

		$result = Db_Query($conn, $sql);
		$close_day_client_id_cast = @pg_fetch_all($result);

		//2�Ĥ��ͤ򥭥㥹��
		for($i=0; $i < count($close_day_client_id_cast); $i++){
			$close_day_client_id[$i]["client_id"] = (int)$close_day_client_id_cast[$i]["client_id"];
			$close_day_client_id[$i]["head_flg"] = $close_day_client_id_cast[$i]["head_flg"];
//			$close_day_client_id[$i]["tax_rate_n"] = (int)$close_day_client_id_cast[$i]["tax_rate_n"];
		}

		/*******����ǯ�������褦�Ȥ��Ƥ��ʤ���********/
/*
		for($i=0; $i < count($close_day_client_id); $i++){
			$sql  = " SELECT \n";
			$sql .= "        schedule_payment_id \n";
			$sql .= " FROM \n";
			$sql .= "        t_schedule_payment \n";
			$sql .= " WHERE \n";
			$sql .= "        client_id = ".$close_day_client_id[$i]["client_id"]. " \n";
			$sql .= "   AND \n";
			$sql .= "        shop_id = $shop_id \n";
			$sql .= "   AND \n";
			$sql .= "        payment_close_day > '$sample_day' \n";
			$sql .= " ; \n";

			$result = Db_Query($conn, $sql);
			$last_id_count = @pg_fetch_all($result);
		}
		if(count($last_id_count) > 0 && $last_id_count != null){
			//���顼�ե饰����
			$last_month_flg = true;
		}
*/		
	}
	
	/****************************/
	//���顼����
	/****************************/
	//�������顼�ե饰��true�ξ��
	if($payment_day_flg == true){
	    $form->setElementError("form_claim_day1","���ꤷ�����դ������ǤϤ���ޤ���");
	}

/*	
	//���顼�ե饰��true�ξ��
	if($last_month_flg == true){
	    $form->setElementError("form_claim_day1","���ꤷ���������դ������ǤϤ���ޤ���");
	}
*/	
	//2006-10-13	�ɵ�
	//̤�襨�顼�ե饰��true�ξ��
	if($future_flg == true){
		$form->setElementError("form_claim_day1","���ꤷ��̤������դ������ǤϤ���ޤ���");
	}

    if($renew_day_flg === true){
		$form->setElementError("form_claim_day1","����������������դǻ����������ϹԤʤ��ޤ���");
    }
	
	//���顼�ե饰��true�ǤϤʤ����Τ߽�����Ԥ�
//	if($payment_day_flg != true && $last_month_flg != true && $future_flg != true && $renew_day_flg != true){
	if($payment_day_flg != true && $future_flg != true && $renew_day_flg != true){


		for($i= 0; $i < count($close_day_client_id); $i++){

            #2009-12-29 aoyama-n
            $tax_rate_obj->setTaxRateDay($sample_day);
            $tax_rate = $tax_rate_obj->getClientTaxRate($close_day_client_id[$i][client_id]);
            $base_info[$i]["tax_rate_n"] = $tax_rate;
/*
			$sql  = " SELECT \n";
			$sql .= "       COUNT(schedule_payment_id) \n";
			$sql .= " FROM \n";
			$sql .= "       t_schedule_payment \n";
			$sql .= " WHERE \n";
			$sql .= "       t_schedule_payment.shop_id = $shop_id \n";
			$sql .= " AND \n";
			$sql .= "       t_schedule_payment.payment_close_day = '$sample_day' \n";
			
			$result = Db_Query($conn, $sql);
			$num = @pg_fetch_result($result, 0, 0);
			
			if($num > 0){
				$form->setElementError("form_claim_day1","���ꤷ�������Υǡ����Ϻ����ѤߤǤ���");
				$duplicate_err = true;
				break;
			}
*/
		    //���ꤷ����������������������չ������Ƥ��ʤ���ʧ�ǡ��������
		    //��ʧ�ơ��֥�ι����ե饰��'f'�Υǡ���
			$sql  = " SELECT \n";
			$sql .= "        t_payout_h.client_id \n";
			$sql .= " FROM \n";
			$sql .= "        t_payout_h \n";
			$sql .= " WHERE \n";
			$sql .= "        t_payout_h.client_id = ".$close_day_client_id[$i][client_id]." \n";
			$sql .= " AND \n";
			$sql .= "        t_payout_h.pay_day > \n";
			$sql .= "            ( \n";
			$sql .= "              SELECT \n";
			$sql .= "                     COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
			$sql .= "              FROM \n";
			$sql .= "                     t_schedule_payment \n";
			$sql .= "              WHERE \n";
			$sql .= "                     t_schedule_payment.client_id = ".$close_day_client_id[$i][client_id]." \n";
			$sql .= "              AND \n";
			$sql .= "                     shop_id = $shop_id \n";
			$sql .= "            ) \n";
			$sql .= " AND \n";
			$sql .= "        t_payout_h.pay_day <= '$sample_day' \n";
			$sql .= " AND \n";
			$sql .= "        t_payout_h.shop_id = '$shop_id' \n";
			$sql .= " AND \n";
			$sql .= "        t_payout_h.renew_flg = 'f' \n";
			$sql .= " GROUP BY t_payout_h.client_id \n";
			
			$sql .= " UNION ALL \n";
			
			//�����إå��ơ��֥�ι����ե饰��'f'�Υǡ���
			$sql .= " SELECT \n";
			$sql .= "        t_buy_h.client_id \n";
			$sql .= " FROM \n";
			$sql .= "        t_buy_h \n";
			$sql .= " INNER JOIN \n";
			$sql .= "        t_amortization\n";
			$sql .= " ON t_buy_h.buy_id = t_amortization.buy_id \n";
			$sql .= " WHERE \n";
			$sql .= "        t_buy_h.client_id = ".$close_day_client_id[$i][client_id]." \n";
			$sql .= " AND \n";
			$sql .= "        t_buy_h.renew_flg = 'f' \n";
			$sql .= " AND \n";
			$sql .= "        t_buy_h.shop_id = $shop_id \n";
			$sql .= " AND \n";
			$sql .= "        t_amortization.pay_day > \n";
			$sql .= "            ( \n";
			$sql .= "              SELECT \n";
			$sql .= "                     COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
			$sql .= "              FROM \n";
			$sql .= "                     t_schedule_payment \n";
			$sql .= "              WHERE \n";
			$sql .= "                     t_schedule_payment.client_id = ".$close_day_client_id[$i][client_id]." \n";
			$sql .= "              AND \n";
			$sql .= "                     shop_id = $shop_id \n";
			$sql .= "            ) \n";
			$sql .= " AND \n";
			$sql .= "        t_amortization.pay_day <= '$sample_day' \n";
			
			$sql .= " UNION ALL \n";
			
			//�����إå��ơ��֥�ι����ե饰��'f'�Υǡ���
			$sql .= " SELECT \n";
			$sql .= "        t_buy_h.client_id \n";
			$sql .= " FROM \n";
			$sql .= "        t_buy_h \n";
			$sql .= " WHERE \n";
			$sql .= "        t_buy_h.client_id = ".$close_day_client_id[$i][client_id]." \n";
			$sql .= " AND \n";
			$sql .= "        t_buy_h.renew_flg = 'f' \n";
			$sql .= " AND \n";
			$sql .= "        t_buy_h.shop_id = $shop_id \n";
			$sql .= " AND \n";
			$sql .= "        t_buy_h.buy_day > \n";
			$sql .= "            ( \n";
			$sql .= "              SELECT \n";
			$sql .= "                     COALESCE(MAX(payment_close_day), '".START_DAY."')\n";
			$sql .= "              FROM \n";
			$sql .= "                     t_schedule_payment \n";
			$sql .= "              WHERE \n";
			$sql .= "                     t_schedule_payment.client_id = ".$close_day_client_id[$i][client_id]." \n";
			$sql .= "              AND \n";
			$sql .= "                     shop_id = $shop_id \n";
			$sql .= "            ) \n";
			$sql .= " AND \n";
			$sql .= "        t_buy_h.buy_day <= '$sample_day' \n";
			$sql .= " ; \n";

			$result = Db_Query($conn, $sql);
			$unrenew_count = @pg_num_rows($result);
			
			//�������ޤ��ϻ�ʧ���˴ؤ������չ�������������Ƥ��ʤ�����renew_flg��true�ˤ���
			if($unrenew_count > 0){
				$renew_flg = true;
				//���չ���������Ƥ��ʤ����Ϸٹ��å�������ɽ������
				$form->setElementError("form_claim_day1","�������������֤�����������ԤäƤ��ʤ��ǡ���������ޤ�");
			}
		}	

		if($duplicate_err != true && $renew_flg != true){
            //����������ơ��֥����Ͽ
            Add_Payment_Make_History($conn, $sample_day, $post_close_day_d);

			/**********SELECT-1*************/
			//�桼���ξ�����������
			for($i=0; $i < count($close_day_client_id); $i++){

                //���Ϥ��������ʹߤ˻�ʧͽ��ǡ���������¸�ߤ����硢
                //��ʧͽ��ǡ�����������ʤ���
                $remake_flg = Check_Remake_Data($conn, $close_day_client_id[$i]["client_id"], $sample_day);

                if($remake_flg === true){
				    $buying_for_appoint[$i] = null;
                    continue;
                }       

                //�����襢��˥ƥ��ξ��
                if($close_day_client_id[$i]["head_flg"] == 't'){
                    //------------------------------------------------------------
                    //��󥿥����ɼ�����
                    //------------------------------------------------------------
                    $sql  = "SELECT";
                    $sql .= "   COALESCE(MAX(payment_close_day), '".START_DAY."')\n";        
                    $sql .= "FROM ";
                    $sql .= "   t_schedule_payment \n"; 
                    $sql .= "WHERE ";
                    $sql .= "   t_schedule_payment.client_id = (SELECT \n";
                    $sql .= "                                       client_id \n";
                    $sql .= "                                   FROM \n";
                    $sql .= "                                       t_client \n";
                    $sql .= "                                   WHERE ";
                    $sql .= "                                       head_flg = 't' \n";
                    $sql .= "                                       AND \n";
                    $sql .= "                                       shop_id = $shop_id \n";
                    $sql .= "                                       AND \n";
                    $sql .= "                                       client_div = '2' \n";
                    $sql .= "                                   )" ;
                    $sql .= "   AND ";
                    $sql .= "   shop_id = $shop_id ";

                    $day_res = Db_Query($conn, $sql);
                    $buy_day_s = pg_fetch_result($day_res,0,0);
                    $buy_day_e = $sample_day;

                    $ary_buy_id = Regist_Buy_Rental_Range($conn,$buy_day_s,$buy_day_e); 
                    //------------------------------------------------------------
                }

                //̤�����λ�ʧ�ǡ�����������ϻ�ʧ�ǡ�����������ʤ���
                $result = Check_Non_Update_Data ($conn, $close_day_client_id[$i]["client_id"]);
                if(is_array($result)){
                    $buying_for_appoint[$i] = null; 
                    $non_update_err[] = $result;
                    continue;
                } 

                //���ξ��Τ߽���Ĺ����Ͽ
                Add_First_ap_Balance($conn, $close_day_client_id[$i]["client_id"], $sample_day);

				$sql = "EXECUTE get_schedule('".$close_day_client_id[$i][client_id]."',$shop_id,'$sample_day',".(int)$serch_post_day."); \n";

				$result = Db_Query($conn, $sql);
				$var[$i] = @pg_fetch_all($result);
				//����ʤ���
				$buying_for_appoint[$i] = $var[$i][0];
			}


			//���ܤξ��󤬼����Ǥ������Τ߽�����Ԥ�
			//���Ϥ��줿���դ��������Ƥ�1�������Ǥ��ʤ����Ͻ��ɽ���ˤ���	2006-09-23
			//�������줿����0���ܤ�null�Ȥ������ȤϤʤ��Τǰʲ��ξ���ʬ������
//			if($buying_for_appoint[0] != null){
			if(count($buying_for_appoint) > 0){
				//�׻���̤��������
				$result_amount = amount_function($buying_for_appoint, $base_info);
				
				for($count_update = 0; $count_update < count($buying_for_appoint); $count_update ++){
					//����������ʧͽ����д��֤κǸ�
					//���դ���Ͽ����Ƥ���
					if($buying_for_appoint[$count_update]["payment_extraction_e"] != null){
						$payment_extraction_e = $buying_for_appoint[$count_update]["payment_extraction_e"];
					}
					//null�ޤ�����Ͽ����Ƥ��ʤ�
					else{
						$payment_extraction_e = START_DAY;
					}
				}
				
				/*******�׻�********/
				//��������	�����������ξ��Ϻ��������դǤϥޥ����Τ������ؿ��Ƿ׻�����
				//������29�ʲ��ξ��
				if($serch_post_day < 29){
					$payment_close_day_d = $serch_post_day;
				//��������29�ʾ�ξ��
				}
				else{
					$payment_close_day_d = date(29);
				}
				
				$payment_close_day = str_pad($post_close_day_y,4,0,STR_PAD_LEFT).'-'.str_pad($post_close_day_m,2,0,STR_PAD_LEFT).'-'.$check_day;

				for($i = 0; $i < count($buying_for_appoint); $i++){


                    if($buying_for_appoint[$i] == null){
                        continue;
                    }

					//UPDATE�Ѥ�SQL��¹� ����λ�ʧͽ��������Ф��롣�����Ǥ��ʤ�����START_DAY������
					$sql = "EXECUTE get_expected_date(" . $buying_for_appoint[$i][client_id] . ", $shop_id); \n"; 
					$result = Db_Query($conn, $sql);
					$last_expected_date = @pg_fetch_all($result);
					
					//����λ�ʧͽ�������ʤ����(���ǲ��Υǡ�����¸�ߤ��ʤ�)
					if($last_expected_date[0][last_expected_day] == null){
						$last_expected_date = START_DAY;
					}
					//���Υǡ�����¸�ߤ�����
					else{
						$last_expected_date = $last_expected_date[0][last_expected_day];
					}
					
					/**********INSERT*************/
					//�����ʬ
					$set_trade_id                   = $buying_for_appoint[$i]["trade_id"];
					//������̾��
					$set_client_name2               = addslashes($buying_for_appoint[$i]["client_name2"]);
					//������̾(ά��)
					$set_client_cname               = addslashes($buying_for_appoint[$i]["client_cname"]);
					//����襳����
					$set_client_cd1                 = $buying_for_appoint[$i]["client_cd1"];
					//����襳����	2006/09/12	�����ɲ�
					$set_client_cd2                 = $buying_for_appoint[$i]["client_cd2"];
					//���̾
					$set_bank_name                  = addslashes($buying_for_appoint[$i]["b_bank_name"]);
					//�����ֹ�
					$set_intro_ac_num               = $buying_for_appoint[$i]["intro_ac_num"];
					//�ֺ�̾��
					$set_account_name               = addslashes($buying_for_appoint[$i]["account_name"]);
					//��ʧ��(��)
					$set_pay_m                      = $buying_for_appoint[$i]["payout_m"];
					//��ʧ��(��)    
					$set_pay_d                      = $buying_for_appoint[$i]["payout_d"];
					//���(�ݤ��ʬ)
					$set_coax                       = $buying_for_appoint[$i]["coax"];
					//������(����ñ��)
					$set_tax_div                    = $buying_for_appoint[$i]["tax_div"];
					//������(ü��)
					$set_tax_franct                 = $buying_for_appoint[$i]["tax_franct"];
					//������(����ñ��)
					$set_c_tax_div                  = $buying_for_appoint[$i]["c_tax_div"];
					//������Ψ
                    #2009-12-29 aoyama-n
					#$set_tax_rate                   = $base_info["tax_rate_n"];
					$set_tax_rate                   = $base_info[$i]["tax_rate_n"];
					//�������ƥ�
					$set_royalty_rate               = $base_info["royalty_rate"];
					//Ĵ����
					$set_tune_amount                = $buying_for_appoint[$i]["total_adjustment_amount"];
					//���������
					$sale_amount                    = $result_amount[$i]["sale_amount"];
					//��������ǳ�
					$set_tax_amount                 = (int)$result_amount[$i][tax_amount];
					//���������(�ǹ�)
					$set_account_payable            = $result_amount[$i]["account_payable"];
					//��������ʧ��
					$set_installment_payment_this   = (int)$buying_for_appoint[$i]["total_split_pay_amount"];
					//����λ�ʧ��۹��
					$set_installment_balance        = $buying_for_appoint[$i]["total_split_pay_balance_amount"];
					//��ʧͽ����д���(������)
					$set_payment_extraction_s       = $buying_for_appoint[$i]["payment_extraction_e"];
					//��ʧ��ͽ�����д���(��λ��) SQL�Ǽ������Ƥ�����λ���򤽤Τޤ�����롡�����������Ƥ���Ȥ��˴��˷׻����Ƥ����
					$set_payment_extraction_e       = end_close_day((string)$post_close_day_y, (string)$post_close_day_m, (string)$post_close_day_d, (string)1);
					//���������(����)
					$set_installment_purchase       = $result_amount[$i][installment_purchase];
					//�����ʧͽ���
					$set_schedule_of_payment_this   = 0;
					//������ݻĹ�(�ǹ�)
					$set_ca_balance_this            = $result_amount[$i][ca_balance_this];
					//���۳�
					$set_rest_amount                = $result_amount[$i][rest_amount];
					//������ݻĹ�
					$set_last_account_payable       = $buying_for_appoint[$i]["ca_balance_this"];
					//�����ʧ��
					$set_payment                    = $buying_for_appoint[$i]["total_pay_amount"];
					//��ʧ���
					$set_col_terms                  = $buying_for_appoint[$i]["col_terms"];
					//������ID
					$set_client_id                  = $buying_for_appoint[$i]["client_id"];
					//������̾
					$set_client_name                = addslashes($buying_for_appoint[$i]["client_name"]);
					//����
					$set_close_day                  = $buying_for_appoint[$i]["close_day"];
                    //�����ʧͽ���
                    $set_shedule_of_payment_last    = $buying_for_appoint[$i]["schedule_of_payment_this"];
                    //��������
                    $lump_tax_amount                = (int)$result_amount[$i]["lump_tax_amount"];


					//(�����ʧ�ĤȺ��������(�ǹ�)�Ⱥ����ʧ�ۤȷ��۳�)���Ƥ�0�ʳ��ξ���ɽ������
//					if(!($set_last_account_payable == 0 && $set_account_payable == 0 && $set_payment == 0 && $set_rest_amount == 0 && $set_ca_balance_this == 0)){
					if(!($set_shedule_of_payment_last == 0 && $set_account_payable == 0 && $set_payment == 0 && $set_rest_amount == 0 && $set_ca_balance_this == 0)){

						$sql  = "INSERT INTO t_schedule_payment (\n";
						$sql .= "          schedule_payment_id,\n";				//��ʧͽ��ID
						$sql .= "          payment_close_day,\n";				//��������
						$sql .= "          execution_day,\n";					//�����������»���
						$sql .= "          last_update_day,\n";					//������������
						$sql .= "          last_account_payable,\n";			//������ݻĹ�
						$sql .= "          payment,\n";							//�����ʧ��
						$sql .= "          tune_amount,\n";						//Ĵ����
						$sql .= "          rest_amount,\n";						//���۳�
						$sql .= "          sale_amount,\n";						//���������
						$sql .= "          tax_amount,\n";						//��������ǳ�
						$sql .= "          account_payable,\n";					//���������(�ǹ�)
						$sql .= "          ca_balance_this,\n";					//������ݻĹ�(�ǹ�)
						$sql .= "          schedule_of_payment_this,\n";		//�����ʧͽ���
						$sql .= "          installment_purchase,\n";			//���������(����)
						$sql .= "          payment_expected_date,\n";			//��ʧͽ����
						$sql .= "          payment_extraction_s,\n";			//��ʧͽ�����д���(������)
						$sql .= "          payment_extraction_e,\n";			//��ʧͽ����д���(��λ��)
						$sql .= "          installment_payment_this,\n";		//��������ʧ��
						$sql .= "          installment_balance,\n";				//��������ʬ������λĹ�
						$sql .= "          client_id,\n";						//������ID
						$sql .= "          client_name,\n";						//������̾
						$sql .= "          client_name2,\n";					//������̾��
						$sql .= "          client_cname,\n";					//������̾(ά��)
						$sql .= "          client_cd1,\n";						//�����襳����1
						$sql .= "          client_cd2,\n";						//�����襳����2
						$sql .= "          bank_name,\n";						//���̾
						$sql .= "          intro_ac_num,\n";					//�����ֹ�
						$sql .= "          account_name,\n";					//����̾��
						$sql .= "          operation_staff_name,\n";			//�»ܼ�
						$sql .= "          trade_id,\n";						//�����ʬID
						$sql .= "          close_day,\n";						//����
						$sql .= "          pay_m,\n";							//��ʧ��(��)
						$sql .= "          pay_d,\n";							//��ʧ��(��)
						$sql .= "          coax,\n";							//���(�ݤ��ʬ)
						$sql .= "          tax_div,\n";							//������(����ñ��)
						$sql .= "          tax_franct,\n";						//������(ü��)
						$sql .= "          c_tax_div,\n";						//���Ƕ�ʬ
						$sql .= "          tax_rate,\n";						//������Ψ
						$sql .= "          royalty_rate,\n";					//�������ƥ�
						$sql .= "          shop_id,\n";							//�����ID
						$sql .= "          col_terms\n";							//��ʧ���
						$sql .= ")VALUES(\n";
						
						/*******��ʧ��ͽ��ID�μ���********/
						$sql .= "                           ( \n";
						$sql .= "                            SELECT \n";
						$sql .= "                                  COALESCE(MAX(schedule_payment_id), 0)+1 \n";
						$sql .= "                           FROM \n";
						$sql .= "                                  t_schedule_payment \n";
						$sql .= "                          ), \n";
						$sql .=   " '$payment_close_day',\n";
						$sql .=   " '$today',\n";
						$sql .=   ($last_update_day != null) ?          " '$last_update_day',\n "        : "null,\n";
						$sql .=   ($set_last_account_payable != null) ? " $set_last_account_payable,\n " : "0,\n";	//2006/09/16	null��0�˽���
						$sql .=   ($set_payment != null) ?              "$set_payment,\n"                : "0,\n";//
						$sql .=   ($set_tune_amount != null) ?          "$set_tune_amount,\n"            : "0,\n";
						$sql .=   ($set_rest_amount != null) ?          "$set_rest_amount,\n"            : "0,\n";
						$sql .=   ($sale_amount != null) ?              "$sale_amount,\n "               : "0,\n";
						$sql .=   ($set_tax_amount != null) ?           "$set_tax_amount,\n "            : "0,\n";
						$sql .=   ($set_account_payable != null) ?      " $set_account_payable,\n "      : "0,\n";
						$sql .=   ($set_ca_balance_this != null) ?      " $set_ca_balance_this,\n "      : "0,\n";
						$sql .=   ($set_schedule_of_payment_this != null) ? " $set_schedule_of_payment_this,\n " : "0,\n";
						$sql .=   ($set_installment_purchase != null) ? " $set_installment_purchase,\n " : "0,\n";
						$sql .= "                           ( \n";
						$sql .= "                             SELECT \n";
		//				$sql .= "                                  CASE WHEN payout_d >= '29' THEN \n";	2006/09/13	����
						$sql .= "                                  CASE WHEN payout_d = '29' THEN \n";
						$sql .= "                                       SUBSTR(TO_DATE(SUBSTR('$sample_day',1,8) || 01, 'YYYY-MM-DD') + ( ".$buying_for_appoint[$i]["payout_m"]." + 1) * interval '1 month' - interval '1 day' , 1 ,10) \n";
						$sql .= "                                  ELSE \n";
						$sql .= "                                       SUBSTR(TO_DATE('$sample_day','YYYY-MM-DD') + (".$buying_for_appoint[$i]["payout_m"]." * interval '1 month'),1,8) || LPAD('".$buying_for_appoint[$i]["payout_d"]."', 2, 0) \n";
						$sql .= "                                  END \n";
						$sql .= "                              FROM \n";
						$sql .= "                                  t_client \n";
						$sql .= "                              WHERE \n";
						$sql .= "                                  t_client.client_id = ".$buying_for_appoint[$i]["client_id"]." \n";
						$sql .= " ) :: date, \n";
						$sql .=   ($set_payment_extraction_s != null) ?     " '$set_payment_extraction_s',\n " : "'".START_DAY."',\n";	//null�ξ��ϥ����ƥ೫��ǯ����
						$sql .=   ($set_payment_extraction_e != null) ?     " '$set_payment_extraction_e',\n " : "null,\n";
						$sql .=   ($set_installment_payment_this != null) ? " $set_installment_payment_this,\n " : "null,\n";
						$sql .=   ($set_installment_balance != null) ?      " $set_installment_balance,\n " : "null,\n";
						$sql .=   ($set_client_id != null) ?                " $set_client_id ,\n "          : "null,\n";
						$sql .=   ($set_client_name != null) ?              " '$set_client_name' ,\n "      : "null,\n";
						$sql .=   ($set_client_name2 != null) ?             " '$set_client_name2',\n "      : "null,\n";
						$sql .=   ($set_client_cname != null) ?             " '$set_client_cname',\n "      : "null,\n";
						$sql .=   ($set_client_cd1 != null) ?               " '$set_client_cd1',\n "        : "null,\n";
						$sql .=   ($set_client_cd2 != null) ?               " '$set_client_cd2',\n "        : "null,\n";		//2006/09/12	�����ɲ�
						$sql .=   ($set_bank_name != null) ?                " '$set_bank_name',\n "         : "null,\n";
						$sql .=   ($set_intro_ac_num != null) ?             " '$set_intro_ac_num',\n "      : "null,\n";
						$sql .=   ($set_account_name != null) ?             " '$set_account_name',\n "      : "null,\n";
						$sql .=   " '".addslashes($staff_name)."',\n";		//2006/09/22	���å�����staff_name�Ǥ褤
						//$sql .=   ($fix_staff_name != null) ? " '$fix_staff_name',\n " : "null,\n";	2006/09/22	���ι��ܤ�����
						$sql .=   ($set_trade_id != null) ?                 " $set_trade_id,\n "            : "null,\n";
						$sql .=   ($set_close_day != null) ?                " '$set_close_day',\n "         : "null,\n";
						$sql .=   ($set_pay_m != null) ?                    " '$set_pay_m',\n "             : "null,\n";
						$sql .=   ($set_pay_d != null) ?                    " '$set_pay_d',\n "             : "null,\n";
						$sql .=   ($set_coax != null) ?                     " '$set_coax',\n "              : "null,\n";
						$sql .=   ($set_tax_div != null) ?                  " '$set_tax_div',\n "           : "null,\n";
						$sql .=   ($set_tax_franct != null) ?               " '$set_tax_franct',\n "        : "null,\n";
						$sql .=   ($set_c_tax_div != null) ?                " '$set_c_tax_div',\n "         : "null,\n";
                        #2009-12-29 aoyama-n
						#$sql .=   ($set_tax_rate != null) ?                 " '$set_tax_rate',\n "          : "null,\n";
						$sql .=   ($set_tax_rate !== null) ?                 " '$set_tax_rate',\n "          : "null,\n";
						$sql .=   ($set_royalty_rate !== null) ?            " '$set_royalty_rate',\n "      : "null,\n";
						$sql .=   " $shop_id,\n";
						$sql .=   ($set_col_terms != null) ?                " '$set_col_terms'\n "          : "null\n";
						$sql .=   ");";
						
						$result = Db_Query($conn, $sql);
						//���Ԥ������ϥ�����Хå�
						if($result == false){
							Db_Query($conn, "ROLLBACK;");
							exit;
						}
					
						/**********SELECT-2 ����λ�ʧ��ͽ��ۤ����*************/
						//��ʧͽ����д���(��λ��)��null�ξ���START_DAY������
						if($set_payment_extraction_e != null){
							$last_payment_payment_close_day = $set_payment_extraction_e;
						}else{
							$last_payment_payment_close_day = START_DAY;
						}
						
						//EXECUTE�¹�
						$sql  = "EXECUTE get_schedule_payment(\n";
                        $sql .= "   ".$buying_for_appoint[$i][client_id].",\n";
                        $sql .= "   ". $shop_id.",\n";
                        $sql .= ($set_payment_extraction_s != Null) ? "'".$set_payment_extraction_s."',\n" : "'".START_DAY."',\n";
                        $sql .= "   '".$set_payment_extraction_e."'); \n";

						$result = Db_Query($conn, $sql);

						$get_payment_array = @pg_fetch_all($result);
						
						$sql  = " SELECT \n";
						$sql .= "       MAX(schedule_payment_id) \n";
						$sql .= " FROM \n";
						$sql .= "       t_schedule_payment \n";
						$sql .= " WHERE \n";
						$sql .= "       client_id = ".$close_day_client_id[$i][client_id]." \n";
						$sql .= " AND \n";
						$sql .= "       shop_id = $shop_id \n";

						$result = Db_Query($conn, $sql);
						$update_id = @pg_fetch_all($result);

						/*******�����ʧ�ۤ��ʧͽ�����δ��֤Ǻ������********/
						$sql  = "EXECUTE re_total_split_pay_amount(\n";
                        $sql .= "   ".$buying_for_appoint[$i][client_id].",\n";
                        $sql .= "   ".$shop_id.",\n";
                        $sql .= ($set_payment_extraction_s != Null) ? "'".$set_payment_extraction_s."',\n" : "'".START_DAY."',\n";
                        $sql .= "   '".$set_payment_extraction_e."'\n";
                        $sql .= "   ); \n";
						
						$result = Db_Query($conn, $sql);
						$resplit_pay_array = @pg_fetch_all($result);

                        //��������оݤȤʤä�����ǡ����˻�ʧͽ��ID��Ĥ�                      
                        Update_Collect_Amortization ($conn, $set_payment_extraction_e, $update_id[0]["max"], $buying_for_appoint[$i]["client_id"]);
						
						/**********�����ʧͽ��ۤ�׻�*************/
                        $update_schedule_of_payment_this = (int)bcsub(bcadd(bcadd(bcsub($get_payment_array[0][total_account_payable], $get_payment_array[0][total_installment_purchase],0),$resplit_pay_array[0][re_total_split_pay_amount],0),$set_shedule_of_payment_last,0), $set_payment,0);

						/**********UPDATE*************/
						//ľ����SELECT������ϰ���˥ǡ�����������ˤ�UPDATE���ʤ����Ͻ����򤻤��˽�λ
						//��������ʧ�ۤ�null�ξ���0����������
						if($resplit_pay_array[0][re_total_split_pay_amount] == null){
							$update_pay_array = 0;
						}else{
							$update_pay_array = $resplit_pay_array[0][re_total_split_pay_amount];
						}

/*
(2007-11-16)
watanabe-k
                        //��ݻĹ⤬���ǻ�ʧͽ��ۤ�0�ξ��
//                        if($set_ca_balance_this == 0 && $update_schedule_of_payment_this == 0 && $update_pay_array == 0){							
*/
                        //�ƶ�ۤ����ξ��˽�������
                        //��ݻĹ⤬��
                        if($set_ca_balance_this == 0
                            &&
                        //��ʧͽ��ۤ���
                        $update_schedule_of_payment_this == 0
                            &&
                        //�����ʧ�ۤ���
                        $update_pay_array == 0
                            &&
                        //��������(��ȴ)����
                        $sale_amount == 0
                            &&
                        //��������ǳۤ���
                        $set_tax_amount == 0
                            &&
                        //�������ۡ��ǹ��ˤ���
                        $set_account_payable == 0
                            &&
                        //�����ʧ�ۤ���
                        $set_payment == 0
                            &&
                        //���ۻĹ⤬��
                        $set_rest_amount == 0
                            &&
                        //Ĵ���ۤ���
                        $set_tune_amount == 0
                            &&
                        //�����������ۤ���
                        $set_installment_purchase == 0
                            &&
                        //������ݻĹ�ۤ���
                        $set_last_account_payable == 0
                        ){
                            //��ʧͽ��ID�򣰤ˤ��롣
                            Update_Payout_Schedule_Id($conn, $buying_for_appoint[$i]["client_id"], $set_payment_extraction_e, "0");

//                            $sql = "DELETE FROM t_schedule_payment WHERE schedule_payment_id = ".$update_id[0]["max"].";";
                            //����������ɲ�
                            $sql = "DELETE FROM t_schedule_payment WHERE schedule_payment_id = ".$update_id[0]["max"].";";
                            $result = Db_Query($conn, $sql);

                            if($result === false){
                                Db_Query($conn, "ROLLBACK;");
                                exit;
                            }

                            continue;
                        }else{
                            //��ʧͽ��ID��Ĥ�
                            Update_Payout_Schedule_Id($conn, $buying_for_appoint[$i]["client_id"], $set_payment_extraction_e, $update_id[0]["max"]);
                        }

						//EXECUTE�¹�
						$sql = "EXECUTE update_t_schedule_payment (
                                            ".$update_schedule_of_payment_this.", 
                                            ".$update_pay_array.", 
                                            ".$update_id[0]["max"].", 
                                            '$today'); \n";

						$result = Db_Query($conn, $sql);

						//���Ԥ������ϥ�����Хå�
						if($result == false){
							Db_Query($conn, "ROLLBACK;");
							exit;
						}

                        /*********************��󥿥�To��󥿥�************************/
                        if(is_array($ary_buy_id)){
                            foreach($ary_buy_id AS $key => $buy_id){
                                if($buying_for_appoint[$i]["head_flg"] == 't' && $buy_id != false){

                                    //UPDATE���
                                    $where["buy_id"] = $buy_id;
                                    $where           = pg_convert($conn,'t_buy_h',$where);

                                    $buy_head["schedule_payment_id"] = $update_id[0][max];

                                    //�����ǡ�����Ͽ
                                    $return = Db_Update($conn, "t_buy_h", $buy_head, $where);
                                    if($return === false){
                                        Db_Query($conn, "ROLLBACK;");
                                        exit;
                                    }
                                }
                            }
                        }
						
						/**********FC��ǽ�Τߡ��������ƥ���1�ʾ�ξ��Τ���Ͽ������Ԥ�*************/
#						if($result_amount[$i]["royalty"] >= 1){
						#0�ʳ��ǥ������ƥ���������褦�˽���
						if($result_amount[$i]["royalty"] != 0){
							
                            //�����Ͽ�ؿ����Ϥ���������
                            $ary = array(
                                $sample_day,                            //��������
                                $buying_for_appoint[$i]["client_id"],   //������ID
                                $update_id[0][max],                     //��ʧͽ��ID
                                $shop_id,                               //����å�ID
                            );

                            Insert_Sale_Head ($conn, $result_amount[$i][royalty], $result_amount[$i][tax_royalty], $ary, '1');
                        }

						/**********��������*************/
                        if($lump_tax_amount != 0){
                            //�����Ͽ�ؿ����Ϥ���������
                            $ary = array(
                                $sample_day,                           //��������
                                $buying_for_appoint[$i]["client_id"],   //������ID
                                $update_id[0][max],                     //��ʧͽ��ID
                                $shop_id,                               //����å�ID
                            );

                            Insert_Sale_Head ($conn, 0, $lump_tax_amount, $ary, '2');
                        }
                    }
				}
			}
		}
		Db_Query($conn, "COMMIT;");
	}
}

/****************************/
//�����ǡ�������
/****************************/
//����1��
$now_month = date('m');
$last_date = date('Y/m/d',mktime(0,0,0,$now_month-1,01));

#2011-11-19 hashimoto-y
#$last_m = date('Yǯm��', mktime(0,0,0,$now_month-1));
$last_m = date('Yǯm��', mktime(0,0,0,$now_month-1,01));

//�����1��
$now_date = date('Y/m/')."01";

$now_m = date('Yǯm��', mktime(0,0,0,$now_month));

//����1��
$next_date = date('Y/m/d',mktime(0,0,0,$now_month+1,01));

$sql  = " SELECT \n";
$sql .= "        close_day_list.close_day, \n";
$sql .= "        payment_close_day_list1.payment_close_day, \n";
$sql .= "        payment_close_day_list2.payment_close_day \n";
$sql .= " FROM \n";
$sql .= "        ( \n";
$sql .= "           SELECT \n";
$sql .= "                DISTINCT t_client.close_day \n";
$sql .= "           FROM \n";
$sql .= "                t_client \n";
$sql .= "           WHERE \n";
//$sql .= "                t_client.shop_id = $shop_id \n";

$sql .= "  t_client.client_div = '2' AND shop_id = $shop_id\n";

$sql .= "           AND \n";
$sql .= "                t_client.close_day != '' \n";

$sql .= "        )close_day_list \n";
//����
$sql .= "   LEFT JOIN \n";
$sql .= "        ( \n";
$sql .= "           SELECT \n";
$sql .= "                 close_day, \n";
$sql .= "                 payment_close_day \n";
$sql .= "           FROM \n";
$sql .= "                 t_payment_make_history \n";
$sql .= "           WHERE \n";
$sql .= "                 '$last_date' <= t_payment_make_history.payment_close_day \n";
$sql .= "           AND \n";
$sql .= "                 t_payment_make_history.payment_close_day < '$now_date' \n";
$sql .= "           AND \n";														//2006/09/14	�ɵ�
//$sql .= "                 t_schedule_payment.shop_id = $shop_id \n";				//2006/09/14	�ɵ�

     $sql .= "   shop_id = $shop_id";

$sql .= "        ) AS payment_close_day_list1 \n";
$sql .= "   ON close_day_list.close_day = payment_close_day_list1.close_day \n";
$sql .= "   LEFT JOIN \n";
//����
$sql .= "        ( \n";
$sql .= "           SELECT \n";
$sql .= "                close_day, \n";
$sql .= "                payment_close_day \n";
$sql .= "           FROM \n";
$sql .= "                t_payment_make_history \n";
$sql .= "           WHERE \n";
$sql .= "                '$now_date' <= t_payment_make_history.payment_close_day \n";
$sql .= "           AND \n";
$sql .= "                t_payment_make_history.payment_close_day < '$next_date' \n";
$sql .= "           AND \n";														//2006/09/14	�ɵ�
//$sql .= "                t_schedule_payment.shop_id = $shop_id \n";					//2006/09/14	�ɵ�

     $sql .= "   shop_id = $shop_id";

$sql .= "        ) AS payment_close_day_list2 \n";
$sql .= "   ON close_day_list.close_day = payment_close_day_list2.close_day \n";
$sql .= " GROUP BY close_day_list.close_day, payment_close_day_list1.payment_close_day, payment_close_day_list2.payment_close_day \n";
$sql .= " ORDER BY close_day_list.close_day \n";

$sql .= "; \n";

$result = Db_Query($conn, $sql);
$num = pg_num_rows($result);		//	2006/09/12	����
//$page_data = Get_Data($result);

//2006/09/12	ɽ���Ѥ˥����Ƚ������ɲ�
for($i = 0; $i < $num; $i++){
    $page_data = Get_Data($result);
}

asort($page_data);
$page_data = array_values($page_data);

//�������ִ�
for($i = 0; $i < count($page_data); $i++){
    if($page_data[$i][0] < 29){
        $page_data[$i][0] = $page_data[$i][0]."��";
    }else{
        $page_data[$i][0] = "����";
    }
}

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign
$smarty->assign("var", array(
	'html_header'       => "$html_header",
	'page_menu'         => "$page_menu",
	'page_header'       => "$page_header",
	'html_footer'       => "$html_footer",
    'result'			=> "$res",
	'count'				=> "$countData",
	'duplicate_msg'		=> "$duplicate_msg",
	'last_date'			=> "$last_m",
    'now_date'			=> "$now_m",
    'error'				=> "$error" 
));
$smarty->assign("page_data",$page_data);
$smarty->assign("err_msg",$err_msg);
$smarty->assign("non_update_err",$non_update_err);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


/**
 *
 * [��۷׻�] FC
 * ���۳ۡ���������ۡ����������(�ǹ�)�������ǳۤ�׻�����
 * $array�������ˤ������������������
 * $array�γ��ء�2
 * 2�����ܤ˰ʲ��ξ���¸�ߤ���
 * 				int			$ca_balance_this					������ݻĹ�(�ǹ�)[2-3]
 * 				int			$total_pay_amount					��ʧ�۹��[8-1]
 * 				int			$total_net_kup_amount				�������(����)����ȴ���[5-1]
 * 				int			$total_tax_net_amount				�������(����)�ξ����ǳ۹��[5-2]
 * 				int			$total_buy_amount					���Ǥλ�����[4-1]
 * 				int			$total_no_tax_buy_amount			����Ǥλ�����[4-2]
 * 				int			$tax_rate_n							������Ψ(����)[0-1]
 * 				string		$tax_div							������(����ñ��)��1:����ñ�� 2:��ɼñ��
 * 				string		$c_tax_div							���Ƕ�ʬ��1:���� 2:����
 * 				string		$tax_franct							������(ü��)��1:�ڼ� 2:�ͼθ��� 3:�ھ�
 * 				string		$total_net_amount					�������(��ȴ��)������ɼñ�̤η׻����˻��Ѥ���[3-1]
 * 				string		$total_tax_amount					�����ǡ�����ɼñ�̤η׻����˻��Ѥ���[3-2]
 * 				string		$total_no_tax_royalty_buy_amount	����ǤΥ������ƥ���[4-4]
 * 				string		$total_royalty_buy_amount			���ǤΥ������ƥ���[4-3]
 * @param		array		$array					�嵭�����򻲾�
 * @return		bool		����ͤ�����
 * 
 * @author		yamanaka-s <yamanaka-s@bhsk.co.jp>
 * @version		1.0.2 (2006/08/24)
 *
 */

function amount_function(&$array, &$base){
	for($i=0; $i < count($array); $i++){
		//���۳�	$ca_balance_this - $total_pay_amount
		$rest_amount[$i] = bcsub($array[$i][ca_balance_this], $array[$i][total_pay_amount],0);	//������ݻĹ� - �����ʧ��
		
		//client_div=2 ���� head_flg='t'�Υǡ����Τߥ������ƥ��׻���Ԥ�
		if($array[$i]["client_div"] == 2 && $array[$i]["head_flg"] == 't'){
			//�������ƥ�
			//������β��Ƕ�ʬ�����Ǥξ��
			if($array[$i][c_tax_div] == '1'){
//				($array[$i][total_royalty_buy_amount] + $array[$i][total_no_tax_royalty_buy_amount] ) * $array[$i][royalty_rate] / 100
				$royalty_amount[$i] = bcmul(bcadd($array[$i][total_royalty_buy_amount], $array[$i][total_no_tax_royalty_buy_amount],2),bcdiv($base[royalty_rate],100,2),2);
			//������β��Ƕ�ʬ�����Ǥξ��
            #2009-12-29 aoyama-n
			#}elseif($array[$i][c_tax_div] == '2'){
//				($array[$i][total_no_tax_royalty_buy_amount] / (1 + $array[$i][tax_rate_n] / 100) + $array[$i][total_no_tax_royalty_buy_amount]) * $array[$i][royalty_rate] / 100
//				$royalty_amount = bcmul(bcadd(bcdiv($array[$i][total_no_tax_royalty_buy_amount],bcadd(1,bcdiv($base[tax_rate_n],100,2),2),2),$array[$i][total_no_tax_royalty_buy_amount],2),bcdiv($base[royalty_rate],100,2),2);
				//2006/09/13	����
				#$royalty_amount[$i] = bcmul(bcadd(bcdiv($array[$i][total_royalty_buy_amount],bcadd(1,bcdiv($base[tax_rate_n],100,2),2),2),$array[$i][total_no_tax_royalty_buy_amount],2),bcdiv($base[royalty_rate],100,2),2);
            #2009-12-29 aoyama-n
            #����Ǥξ��
			}elseif($array[$i][c_tax_div] == '3'){
				$royalty_amount[$i] = bcmul(bcadd($array[$i][total_royalty_buy_amount], $array[$i][total_no_tax_royalty_buy_amount],2),bcdiv($base[royalty_rate],100,2),2);
            }

			//��۴ݤ�
			//ü���׻�
			if($array[$i][tax_franct] == '1'){
				$royalty[$i] = floor($royalty_amount[$i]);
			}elseif($array[$i][tax_franct] == '2'){
				$royalty[$i] = round($royalty_amount[$i]);
			}elseif($array[$i][tax_franct] == '3'){
				$royalty[$i] = ceil($royalty_amount[$i]);
			}else{
//				print "ü��ñ�̥��顼";
				$royalty[$i] = floor($royalty_amount[$i]);
			}
			//�������ƥ�������
            #2009-12-29 aoyama-n
			#$tax_royalty_appoint[$i] = bcmul($royalty_amount[$i],bcdiv($base[tax_rate_n],100,2),2);
            //���Ǥξ��
            if($array[$i][c_tax_div] == '1'){
                $tax_royalty_appoint[$i] = bcmul($royalty_amount[$i],bcdiv($base[$i][tax_rate_n],100,2),2);
            //����Ǥξ��
            }elseif($array[$i][c_tax_div] == '3'){
                $tax_royalty_appoint[$i] = 0;
            }

			//��۴ݤ�
			if($array[$i][tax_franct] == '1'){
				$tax_royalty[$i] = floor($tax_royalty_appoint[$i]);
			}elseif($array[$i][tax_franct] == '2'){
				$tax_royalty[$i] = round($tax_royalty_appoint[$i]);
			}elseif($array[$i][tax_franct] == '3'){
				$tax_royalty[$i] = ceil($tax_royalty_appoint[$i]);
			}else{
				$tax_royalty[$i] = floor($tax_royalty_appoint[$i]);
			}
		}
		/***************[����ñ��][����]****************/
		//���������	$total_buy_amount + $total_no_tax_buy_amount + $total_net_kup_amount + $royalty
		$sale_amount1[$i] = bcadd(bcadd(bcadd($array[$i][total_buy_amount],$array[$i][total_no_tax_buy_amount],0),$array[$i][total_net_kup_amount],0),$royalty[$i],0);

		//�����ǳ�		($total_buy_amount * $tax_rate_n / 100) + $total_tax_net_amount + $tax_royalty
        #2009-12-29 aoyama-n
		#$before_tax_amount1[$i] = bcadd(bcadd(bcmul($array[$i][total_buy_amount],bcdiv($base[tax_rate_n],100,2),2),$array[$i][total_tax_net_amount],2),$tax_royalty[$i],2);
		$before_tax_amount1[$i] = bcadd(bcadd(bcmul($array[$i][total_buy_amount],bcdiv($base[$i][tax_rate_n],100,2),2),$array[$i][total_tax_net_amount],2),$tax_royalty[$i],2);
		
		//ü���׻�
		if($array[$i][tax_franct] == '1'){
			$tax_amount1[$i] = floor($before_tax_amount1[$i]);
		}elseif($array[$i][tax_franct] == '2'){
			$tax_amount1[$i] = round($before_tax_amount1[$i]);
		}elseif($array[$i][tax_franct] == '3'){
			$tax_amount1[$i] = ceil($before_tax_amount1[$i]);
		//�ǥե������
		}else{
			$tax_amount1[$i] = floor($before_tax_amount1[$i]);
		}
			
		//���������(�ǹ�)	$sale_amount + $tax_amount
		$account_payable1[$i] = bcadd($sale_amount1[$i],$tax_amount1[$i],0);
		
		/****************[����ñ��][����]****************/
		//���������(�ǹ�)	$total_buy_amount + $total_no_tax_buy_amount + $total_net_kup_amount + $total_tax_net_amount + $royalty + $tax_royalty
        /**** 2009-12-29 aoyama-n ****
		$account_payable2[$i] = bcadd(bcadd(bcadd(bcadd(bcadd($array[$i][total_buy_amount],$array[$i][total_no_tax_buy_amount],0),$array[$i][total_net_kup_amount],0),$array[$i][total_tax_net_amount],0),$royalty[$i],2),$tax_royalty[$i],2);

		//�����ǳ�			$total_buy_amount - ($total_buy_amount / (1 + $tax_rate_n)) + $total_tax_net_amount + $tax_royalty
		//$before_tax_amount2 = bcadd(bcadd(bcsub($array[$i][total_buy_amount],bcdiv($array[$i][total_buy_amount],bcadd(1,bcdiv($array[$i][tax_rate_n],100,2),2),2),2),$array[$i][total_tax_net_amount],2),$tax_royalty,2);
		$before_tax_amount2[$i] = bcadd(bcadd(bcsub($array[$i][total_buy_amount],bcdiv($array[$i][total_buy_amount],bcadd(1,bcdiv($base[tax_rate_n],100,2),2),2),2),$array[$i][total_tax_net_amount],2),$tax_royalty[$i],2);
		//ü���׻�
		if($array[$i][tax_franct] == '1'){
			$tax_amount2[$i] = floor($before_tax_amount2[$i]);
		}elseif($array[$i][tax_franct] == '2'){
			$tax_amount2[$i] = round($before_tax_amount2[$i]);
		}elseif($array[$i][tax_franct] == '3'){
			$tax_amount2[$i] = ceil($before_tax_amount2[$i]);
		//�ǥե������
		}else{
			$tax_amount2[$i] = floor($before_tax_amount2[$i]);
		}
		
		//���������		    $account_payable2 - $tax_amount
		$sale_amount2[$i]       = bcsub($account_payable2[$i],$tax_amount2[$i],0);
        **** 2009-12-29 aoyama-n ****/ 

        #2009-12-29 aoyama-n
        /***************[����ñ��][�����]****************/
        //���������    $total_buy_amount + $total_no_tax_buy_amount + $total_net_kup_amount + $royalty
        $sale_amount4[$i] = bcadd(bcadd(bcadd($array[$i][total_buy_amount],$array[$i][total_no_tax_buy_amount],0),$array[$i][total_net_kup_amount],0),$royalty[$i],0);

        //�����ǳ�
        $tax_amount4[$i] = 0;

        //���������(�ǹ�)  $sale_amount + $tax_amount
        $account_payable4[$i] = bcadd($sale_amount4[$i],$tax_amount4[$i],0);

		/****************[��ɼñ��]*****************/
		//���������	        $total_net_amount + $total_net_kup_amount + $royalty
		$sale_amount3[$i]       = bcadd(bcadd($array[$i][total_net_amount],$array[$i][total_net_kup_amount],0),$royalty[$i],0);
		
		//�����ǳ�		        $total_tax_amount + $total_tax_net_amount + $tax_royalty
		$tax_amount3[$i]        = bcadd(bcadd($array[$i][total_tax_amount],$array[$i][total_tax_net_amount],0),$tax_royalty[$i],0);
		
		//���������(�ǹ�)	    $sale_amount + $tax_amount
		$account_payable3[$i]   = bcadd($sale_amount3[$i],$tax_amount3[$i],0);
		
		//���۳ۤ�return������˳�Ǽ
		$result[$i][rest_amount] = $rest_amount[$i];
		
		/****************�嵭3�Ĥη׻��Τɤ��������뤫Ƚ��****************/
		//����ñ��
		if($array[$i][tax_div] == '1'){
			//����
			if($array[$i][c_tax_div] == '1'){
				//����ñ�̤γ���
//				$result[$i][rest_amount] = $rest_amount;
				$result[$i][sale_amount]     = $sale_amount1[$i];
				$result[$i][tax_amount]      = $tax_amount1[$i];
				$result[$i][account_payable] = $account_payable1[$i];
			//����
            #2009-12-29 aoyama-n
			#}elseif($array[$i][c_tax_div] == '2'){
				//����ñ�̤�����
			#	$result[$i][sale_amount]     = $sale_amount2[$i];
			#	$result[$i][tax_amount]      = $tax_amount2[$i];
			#	$result[$i][account_payable] = $account_payable2[$i];
            #2009-12-29 aoyama-n
			//���Ƕ�ʬ���ʤ����ϳ��ǤǷ׻�����
			#}else{
			#	$result[$i][sale_amount]     = $sale_amount1[$i];
			#	$result[$i][tax_amount]      = $tax_amount1[$i];
			#	$result[$i][account_payable] = $account_payable1[$i];
            //�����
            }elseif($array[$i][c_tax_div] == '3'){
                //����ñ�̤������
                $result[$i][sale_amount] = $sale_amount4[$i];
                $result[$i][tax_amount] = $tax_amount4[$i];
                $result[$i][account_payable] = $account_payable4[$i];
            }

            //��������
            $result[$i][lump_tax_amount]     = ($tax_amount3[$i] + $tax_royalty[$i] - $result[$i][tax_amount]) * -1;
 
		//��ɼñ��
		}elseif($array[$i][tax_div] == '2'){
			//��ɼñ��
			$result[$i][sale_amount]         = $sale_amount3[$i];
			$result[$i][tax_amount]          = $tax_amount3[$i];
			$result[$i][account_payable]     = $account_payable3[$i];
		//����ñ�̤��ʤ�������ɼñ�̤Ƿ׻�����
		}else{
			$result[$i][sale_amount]         = $sale_amount3[$i];
			$result[$i][tax_amount]          = $tax_amount3[$i];
			$result[$i][account_payable]     = $account_payable3[$i];
		}
		
		//������ݻĹ�
		$result[$i][ca_balance_this] = bcadd($rest_amount[$i],$result[$i][account_payable],0);
		
		//���������(����)
		$result[$i][installment_purchase] = bcadd($array[$i][total_net_kup_amount],$array[$i][total_tax_net_amount],0);

		if($array[$i]["client_div"] == 2 && $array[$i]["head_flg"] == 't'){
			//�������ƥ�
			$result[$i][royalty] = $royalty[$i];
			//�������ƥ�������
			$result[$i][tax_royalty] = $tax_royalty[$i];
		}else{
			$result[$i][royalty] = 0;
			$result[$i][tax_royalty] = 0;
		}

	}
	return $result;
}


/**
 *
 * �����׻�
 * 1��28�������򤷤����Ϥ��Τޤޥ��å�
 * ���������򤷤����Ϸ׻������б�����ǯ��η����򥻥å�
 *
 * @param		string		$year		ǯ(���Ϲ���) 
 * @param		int			$month		��(���Ϲ���)
 * @param		int			$day		��(���Ϲ���)
 *
 *
 * @return		string		$post_close_day		����
 *
 * @author		yamanaka-s <yamanaka-s@bhsk.co.jp>
 * @version		1.0.0 (2006/08/25)
 *
 */
function set_close_day(&$year, &$month, $day){

	//���դ�����
	$befor_day = $year.'-'.$month.'-'.$day;

	//����Ƚ��
	//1��28������
	if($day > '0' && $day < '29'){
		$day = $day;
	}
	//��������
    elseif($day >= '29'){
//		$day = date("t",strtotime($befor_day));
        $day = date('t',mktime(0,0,0,$month, 1, $year));
	}
	//ɽ�������ʳ������
	else{
		$day = null;
	}
	
	////���դ�����
	$post_close_day = $year.'-'.$month.'-'.$day;

	return $post_close_day;
	
}


/**
 *
 * ���շ׻�
 * �ʲ��Υǡ����������ꡢ���շ׻���Ԥ�
 * string�Τ�ư���ǧ��
 * int����date���Ϸ׻���̤��ۤʤ뤳�Ȥ�����
 * ���Ϥ��줿ǯ��������������
 * 
 *
 * @param		string		$year			�оݤȤʤ�ǯ
 * @param		string		$month			�оݤȤʤ��
 * @param		string		$day			�оݤȤʤ���
 * $param		string		$n				n�����
 *
 *
 * @return		date		 $return_comp	n������ǯ����
 *
 * @author		nishibayashi-t <nishibayashi-t@bhsk.co.jp>
 * @version		1.0.0 (2006/09/02)
 *
 */
function end_close_day($year, $month, $day, $n){

    //�����������ξ��
    if($day == '29'){
        $return_comp = date("Ymt", mktime(0,0,0,$month + 1, 1, $year));
    //�����ʳ��ξ��
    }else{
        $return_comp = date('Ymd', mktime(0,0,0,$month + 1, $day, $year));
    }

/*
	$comp1=	mktime(0, 0, 0, $month, $day, $year);//����
	$comp2=	mktime(0, 0, 0, $month+$n, $day, $year);//�����n�����
	
	//����������n������׻�����
	$tmp1=date("m",$comp1)+$n;
	$tmp2=round($tmp1/12);
	$tmp1=$tmp1-($tmp2*12);
	
	//����������n������׻�(mktime�����)����
	$tmp3=date("m",$comp2);
	$tmp5=round($tmp3/12);
	$tmp3=$tmp3-($tmp5*12);
	
	//��������n������׻�(mktime�����)��ǯ
	$tmp4=date("Y",$comp2);
	
	//������������
	if(date("d",$comp1)==date("t",$comp1)){
		$ytmp=$tmp4;
		if($tmp1!=$tmp3){
			$mtmp=date("m",$comp2)-1;
		}else{
			$mtmp=date("m",$comp2);
		}
		$comp3=	mktime(0, 0, 0, $mtmp, 01, $ytmp);
		$comp4=	mktime(0, 0, 0, $mtmp, date("t",$comp3), date("Y",$comp3));
		
		$return_comp = date("Y/m/d",$comp4);
		
	}
	//���ȭ��η�̤�Ʊ�����
	elseif($tmp1==$tmp3){
		$return_comp = date("Y/m/d",$comp2);
		
	}
	//���Τ�
	else{
		$ytmp=$tmp4;
		$mtmp=date("m",$comp2)-1;
		$comp3=	mktime(0, 0, 0, $mtmp, 01, $ytmp);
		$comp4=	mktime(0, 0, 0, $mtmp, date("t",$comp3), date("Y",$comp3));
		
		$return_comp = date("Y/m/d",$comp4);
	}
*/
	return $return_comp;
}

?>