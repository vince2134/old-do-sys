<?php
/******************************
*�ѹ�����
*   ��2006/05/15�˽���ʬȿ��
*   ��2006/05/22��������ID����Ͽ���˼�������褦���ѹ�
*   ��2006/05/24�ˡֽ������פ��ѹ���
*   ��2006/05/24�ˡ������פα�¦�ˡֽ�����ˡ�פ�ɽ�������ֽ������פα�¦�϶����Ƥ�����
*   ��2006/05/24�ˡֽ�����ˡ�פˡּ�ư����פ��ɲä���Ǽ�ʻ��פ������롣
*   ��2006/05/24�ˡּ����ʬ�פǡָ������פ����򤷤����ϡ��������סֽ������פ϶�������򤹤롣
*   ��2006/05/29�˼��̤��ɲ�
*   ��2006/06/16�˷ɾ�
*   ��2006/06/19����ɽ�Ԥ�ɬ�ܥ����å���̵���ˤ��롣
*   ��2006/06/22�˷�������ܤ���ݤˡ������ID���Ϥ���
*   ��2006/07/06��shop_gid��ʤ���(kaji)
*   ��2006/07/07����Ԥξ���������̾��ά���ѹ��Բ�(suzuki)
*   ��2006/07/21�˸��¶�ʬ��Ͽ(suzuki)
*    (2006/07/22)������ޥ����ǰۤʤ����������ꤹ����ˤϡ�(watanabe-k)
        �ʲ��ι��ܤ˴ؤ��Ƥ��������Ʊ�ͤ�����򤹤롣
            ������
            ������ñ��
            ��������ü����ʬ
            ����ۤΤޤ���ʬ
*    (2006/07/28) ����������ɼȯ�ԥѥ�������Ͽ�����ɲá�watanabe-k��
*    (2006/07/31) ���Ƕ�ʬ��Ͽ���ѹ������ɲá�watanabe-k��
*    (2006/08/07) ���ܥ������������ѹ���watanabe-k��
*    (2006/08/21) �ֶ�Լ�����פȡ�����������¾�פ��ѹ��Ǥ��ʤ��Х��ν���(watanabe-k)
*    (2006/08/22) �����裲����Ͽ�������ɲá�watanabe-k��
*    (2006/08/23) DB�����ѹ���ȼ�������裲����Ͽ�������ѹ���watanabe-k��
*    (2006/08/29) �������פ������ǡֽ������פ������1���Ȥ������������꤬�Ǥ��Ƥ��ޤ�����watanabe-k��
*    (2006/08/31)�����ֹ����Ͽ�Ǥ���褦���ѹ���watanabe-k��
*    (2006/09/02) �ѹ����˥����ꥨ�顼���Ф�Х�������kaji��
*    (2006/09/30) ������1��Ͽ���˥����꡼���顼���Ф�Х�������kaji��
*    (2006/10/30) �ѹ����ξ��֤��ֵٻ��桦����פΤȤ��μ�����ɼ��������ɲá�suzuki��
*                �ֵٻ��桦����פ���������ѹ������Ȥ��μ�����ɼ���������ɲá�suzuki��
*     2006/11/13          kaku-m  TEL��FAX�ֹ�Υ����å���ؿ��ǹԤ��褦�˽�����
*    (2006/11/22) �ֵٻ��桦����פ���������ѹ������Ȥ��˽�����������������suzuki��

     (2006-11-28) ������η���ν�������������褦�˽���<suzuki>
	              ��ͳ��������Ͽ���ˤϽ������������Ƥ���١�������Τޤޤ���CRON��¹Ԥ��Ƥ������ν�����Ϻ�������ʤ���
	                    �����ʤ�����������˺�������Ф����Τ������ѹ����ƥå׿����礭���١�������¦����
*******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0085    suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *  2006-12-22      new_0005    kajioka-h   ô�����������1���3���ѹ��Ǥ��ʤ��ä��Х�����
 *  2007-01-24                  watanabe-k  �Ȳ�������FC�������ǽ�Ȥ���������ɲ�
 *  2007-02-01                  watanabe-k  ����̾�����ȿ���̾�����������裱�˹�碌��褦�˽���
 *  2007-02-02                  watanabe-k  ����������ɼ�ˤ��ѹ����Ƥ�ȿ�Ǥ���������ɲ�
 *  2007-02-16                  watanabe-k  ������ˡ�˼�����ɲ�
 *  2007-02-16                  morita-d    ô����Ź���Ź�ޥ�������Ф���褦���ѹ�
 *  2007-02-22                  watanabe-k  ���׵�ǽ����
 *  2007-02-28                  watanabe-k  ľ�İʳ��ǾҲ���¤�FC������Ǥ��ʤ��褦�˽���
 *  2007-03-14                  watanabe-k  �Ƥ��ѹ��������Ƥ�Ҥ�ȿ�Ǥ���褦�˽���
 *  2007-03-16     ����¾79     watanabe-k  ���̤κ�������롼�פΰ����ѹ�
 *  2007-03-27     ����¾105    watanabe-k  �����ɼ��ȯ�Է�����̵�����ɲ�
 *  2007-04-03                  watanabe-k  ��������ޥ����η���ô��1�ȷ���ô��2�ϰʲ��Τ褦�ˤ���

                                            ��̾�Τ�ʲ��Τ褦���ѹ�
                                            �ַ���ô��1�עָ͡�����ô����
                                            �ַ���ô��2�עֽ͡������Ұ���

                                            ���ץ�������ɽ�����륹���åդϰʲ��Τ褦�ˤ���
                                            �ָ�����ô���פϺ߿��ԤΤߤ�ɽ������
                                            �ֽ������Ұ��פ��������åդ�ɽ������  
 *  2007-04-04                  watanabe-k���Ҳ�����褬�ѹ����줿����ͽ��ǡ����򥢥åץǡ��Ȥ���褦�˽���
 *  2007-04-05                  morita-d����������֤��ѹ����Ƥ�ͽ��ǡ����������ʤ��褦�˽���
 *  2007-04-05                  morita-d�����Ҳ������������Ǥ��ʤ��褦�˽���
 *  2007-04-11                  watanabe-k���Ҳ�����褬��ͭ���͡�̵���ˤʤä�����������ƥơ��֥�θ���Ψ�ȸ���ñ����null�򥻥å�
 *  2007-04-23                  watanabe-k  ���롼�����������Ω�����å���Ϥ���
 *  2007-05-04                  watanabe-k  ���ꤵ��Ƥ��ʤ���ɼ���ѹ����Ƥ�ȿ�Ǥ���
 *  2007-05-08                  watanabe-k  �����ʬ�˸������ꤷ�����ϡ��������ʧ���Ȥ���
 *  2007-05-09                  morita-d    �ݤ��ʬ���ѹ����줿��硢����ޥ����ζ�ۤ�Ʒ׻����ٹ��ɽ������
 *  2007-05-18                  watanabe-k  �������������������Ǥ���褦�˽���
 *  2007-05-31                  watanabe-k  ��ɼȯ�Է�������ꤵ��Ƥ��ʤ���ɼ��ȿ�Ǥ���褦�˽��� 
 *  2007-06-20                  morita-d    ������μ�����ɼ����ݤ��ѹ�����������ɲ� 
 *  2007-07-12                  watanabe-k  ��ɼȯ�Ԥ�̵��¾ɽ���ѹ�
 *  2009/12/25                  aoyama-n    ���Ƕ�ʬ�����Ǥ���
 *  2010-05-01      Rev.1.5���� hashimoto-y �����ΰ���ե���ȥ������ѹ���ǽ���ɲ�
 *  2011-02-11      Rev.1.6���� watanabe-k  ����ޥ������Ϥ�������ID����Ф��������ʤ��Х��ν���
 *  2015/04/03                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
*/

$page_title = "������ޥ���";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //�����Ϣ�δؿ�

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null, "onSubmit=return confirm(true)");

// DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
// ���������(radio��select)
/****************************/
$def_data["form_state"]         = 1;
$def_data["form_slip_out"]      = 1;
$def_data["form_deliver_radio"] = 1;
#2010-04-30 hashimoto-y
$def_data["form_bill_address_font"]    = 0;

$def_data["form_claim_out"]     = 1;
$def_data["form_coax"]          = 1;
$def_data["form_tax_div"]       = 2;
$def_data["form_tax_franct"]    = 1;
$def_data["form_claim_send"]    = 1;
$def_data["form_bank_div"]      = 1;
//$def_data["form_type"]          = 1;
$def_data["form_prefix"]        = 1;
//$def_data["form_cshop"]         = $_SESSION["client_id"];
$def_data["form_charge_branch_id"] = $_SESSION["branch_id"];
$def_data["form_c_tax_div"]     = 1;
$def_data["form_parents_div"]   = 'null';
$def_data["form_client_div"]    = '1';
for($i = 0; $i < 12; $i++){
    $def_data["claim1_monthly_check"][$i] =  "1";
    $def_data["claim2_monthly_check"][$i] =  "1";
}

$form->setDefaults($def_data);


/****************************/
// ����Ƚ��
/****************************/
$shop_id        = $_SESSION[client_id];
$group_kind     = $_SESSION[group_kind];
$staff_id       = $_SESSION[staff_id];
$get_client_id  = (isset($_GET["client_id"])) ? $_GET["client_id"] : null;
$new_flg        = (isset($_GET["client_id"])) ? false : true;

/* GET����ID�������������å� */
$where  = " client_div = '1' AND ";
$where .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().")" : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["client_id"] != null && Get_Id_Check_Db($conn, $_GET["client_id"], "client_id", "t_client", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
// ��������GET���������
/****************************/
if($new_flg == false){
    $select_sql  = "SELECT \n";
    $select_sql .= "    t_client.client_cd1,\n";
    $select_sql .= "    t_client.client_cd2,\n";
    $select_sql .= "    t_client.state,\n";
    $select_sql .= "    t_client.client_name,\n";
    $select_sql .= "    t_client.client_read,\n";
    $select_sql .= "    t_client.client_cname,\n";
    $select_sql .= "    t_client.post_no1,\n";
    $select_sql .= "    t_client.post_no2,\n";
    $select_sql .= "    t_client.address1,\n";
    $select_sql .= "    t_client.address2,\n";
    $select_sql .= "    t_client.address_read,\n";
    $select_sql .= "    t_client.area_id,\n";
    $select_sql .= "    t_client.tel,\n";
    $select_sql .= "    t_client.fax,\n";
    $select_sql .= "    t_client.rep_name,\n";
    $select_sql .= "    t_client.charger1,\n";
    $select_sql .= "    t_client.charger2,\n";
    $select_sql .= "    t_client.charger3,\n";
    $select_sql .= "    t_client.charger_part1,\n";
    $select_sql .= "    t_client.charger_part2,\n";
    $select_sql .= "    t_client.trade_stime1,\n";
    $select_sql .= "    t_client.trade_etime1,\n";
    $select_sql .= "    t_client.trade_stime2,\n";
    $select_sql .= "    t_client.trade_etime2,\n";
    $select_sql .= "    t_client.holiday,\n";
    $select_sql .= "    t_client.sbtype_id,\n";
    $select_sql .= "    t_client.b_struct,\n";
    $select_sql .= "    t_client_claim.client_cd1,\n";
    $select_sql .= "    t_client_claim.client_cd2,\n";
    $select_sql .= "    t_client_claim.client_name,\n";
    $select_sql .= "    t_client_intro_act.client_cd1,\n";
    $select_sql .= "    t_client_intro_act.client_name,\n";
    //$select_sql .= "    t_client.intro_ac_price,\n";
    //$select_sql .= "    t_client.intro_ac_rate,\n";
    $select_sql .= "    '',\n";
    $select_sql .= "    '',\n";
    $select_sql .= "    t_client_info.cclient_shop,\n";
    $select_sql .= "    t_client.c_staff_id1,\n";
    $select_sql .= "    t_client.c_staff_id2,\n";
//     $select_sql .= "    t_client.d_staff_id1,";
//     $select_sql .= "    t_client.d_staff_id2,";
//     $select_sql .= "    t_client.d_staff_id3,";
    $select_sql .= "    t_client.col_terms,\n";
    $select_sql .= "    t_client.credit_limit,\n";
    $select_sql .= "    t_client.capital,\n";
    $select_sql .= "    t_client.trade_id,\n";
    $select_sql .= "    t_client.close_day,\n";
    $select_sql .= "    t_client.pay_m,\n";
    $select_sql .= "    t_client.pay_d,\n";
    $select_sql .= "    t_client.pay_way,\n";
//    $select_sql .= "    t_client.b_bank_id,\n";
    $select_sql .= "    t_account.b_bank_id,\n";
    $select_sql .= "    t_client.pay_name,\n";
    $select_sql .= "    t_client.account_name,\n";
    $select_sql .= "    t_client.cont_sday,\n";
    $select_sql .= "    t_client.cont_eday,\n";
    $select_sql .= "    t_client.cont_peri,\n";
    $select_sql .= "    t_client.cont_rday,\n";
    $select_sql .= "    t_client.slip_out,\n";
    $select_sql .= "    t_client.deliver_note,\n";
    $select_sql .= "    t_client.claim_out,\n";
    $select_sql .= "    t_client.coax,\n";
    $select_sql .= "    t_client.tax_div,\n";
    $select_sql .= "    t_client.tax_franct,\n";
    $select_sql .= "    t_client.note,\n";
    $select_sql .= "    t_client.email,\n";
    $select_sql .= "    t_client.url,\n";
    $select_sql .= "    t_client.rep_htel,\n";
    $select_sql .= "    t_client.direct_tel,\n";
    $select_sql .= "    t_client.b_struct,\n";
    $select_sql .= "    t_client.inst_id,\n";
    $select_sql .= "    t_client.establish_day,\n";
    $select_sql .= "    t_client.deal_history,\n";
    $select_sql .= "    t_client.importance,\n";
    $select_sql .= "    t_client.intro_ac_name,\n";
    $select_sql .= "    t_client.intro_bank,\n";
    $select_sql .= "    t_client.intro_ac_num,\n";
    $select_sql .= "    t_client.round_day,\n";
    $select_sql .= "    t_client.deliver_effect,\n";
    $select_sql .= "    t_client.claim_send,\n";
    $select_sql .= "    t_client.charger_part3,\n";
    $select_sql .= "    t_client.client_div,\n";
    $select_sql .= "    t_client.client_cread,\n";
    $select_sql .= "    t_client.represe,\n";
    $select_sql .= "    t_b_bank.bank_id,\n";
    $select_sql .= "    t_client.address3,\n";
    $select_sql .= "    t_client.company_name,\n";
    $select_sql .= "    t_client.company_tel,\n";
    $select_sql .= "    t_client.company_address,\n";
    $select_sql .= "    t_client.client_name2,\n";
    $select_sql .= "    t_client.client_read2,\n";
    $select_sql .= "    t_client.charger_represe1,\n";
    $select_sql .= "    t_client.charger_represe2,\n";
    $select_sql .= "    t_client.charger_represe3,\n";
    $select_sql .= "    t_client.charger_note,\n";
    $select_sql .= "    t_client.bank_div,\n";
    $select_sql .= "    t_client.claim_note,\n";
    $select_sql .= "    t_client.client_slip1,\n";
    $select_sql .= "    t_client.client_slip2,\n";
    $select_sql .= "    t_client.parent_rep_name,\n";
    $select_sql .= "    t_client.parent_establish_day,\n";
//    $select_sql .= "    t_client.type,\n";
    $select_sql .= "    '',\n";
    $select_sql .= "    t_client.compellation,\n";
    $select_sql .= "    t_client.act_flg, \n";
    $select_sql .= "    t_client.s_pattern_id,\n";
    $select_sql .= "    t_client.c_pattern_id,\n";
    $select_sql .= "    t_client.charge_branch_id,\n";
    $select_sql .= "    t_client.c_tax_div,\n";
    $select_sql .= "    t_client_claim2.client_cd1 AS claim2_cd1,\n";
    $select_sql .= "    t_client_claim2.client_cd2 AS claim2_cd2,\n";
    $select_sql .= "    t_client_claim2.client_name AS claim2_name,\n";
    $select_sql .= "    t_account.account_id,\n";
    $select_sql .= "    t_client_claim2.claim2_id, \n";
    $select_sql .= "    t_client.client_gr_id, \n";
    $select_sql .= "    CASE\n";
    $select_sql .= "        WHEN t_client.parents_flg IS NULL THEN 'null'\n";
    $select_sql .= "        ELSE CASE t_client.parents_flg\n";
    $select_sql .= "                WHEN 't' THEN 'true'\n";
    $select_sql .= "                WHEN 'f' THEN 'false'\n";
    $select_sql .= "            END \n";
    $select_sql .= "    END AS parents_flg, \n";
    $select_sql .= "    t_client_intro_act.client_div AS intro_act_div,\n";     //�Ҳ�������ʬ
    $select_sql .= "    t_client_intro_act.client_cd2 AS intro_act_cd2, \n";     //�Ҳ�����襳���ɣ�
    $select_sql .= "    t_client_intro_act.intro_account_id  AS intro_act_id, \n";      //�Ҳ������ID

    //����������
    $select_sql .= "    t_client_claim.month1_flg, ";
    $select_sql .= "    t_client_claim.month2_flg, ";
    $select_sql .= "    t_client_claim.month3_flg, ";
    $select_sql .= "    t_client_claim.month4_flg, ";
    $select_sql .= "    t_client_claim.month5_flg, ";
    $select_sql .= "    t_client_claim.month6_flg, ";
    $select_sql .= "    t_client_claim.month7_flg, ";
    $select_sql .= "    t_client_claim.month8_flg, ";
    $select_sql .= "    t_client_claim.month9_flg, ";
    $select_sql .= "    t_client_claim.month10_flg, ";
    $select_sql .= "    t_client_claim.month11_flg, ";
    $select_sql .= "    t_client_claim.month12_flg, ";

    #2010-04-30 hashimoto-y
    //�������ե����
    $select_sql .= "    t_client.bill_address_font ";

    $select_sql .= " FROM\n";
    $select_sql .= "    t_client\n";
    $select_sql .= "        INNER JOIN\n";

    //�����裱�Ѥη��
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_claim.*,\n";
    $select_sql .= "        t_client.client_cd1,\n";
    $select_sql .= "        t_client.client_cd2,\n";
    $select_sql .= "        t_client.client_cname AS client_name\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_claim\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_client\n";
    $select_sql .= "        ON t_claim.claim_id = t_client.client_id\n";
    $select_sql .= "        AND t_claim.claim_div = '1'\n";
    $select_sql .= "    )AS t_client_claim\n";
    $select_sql .= "    ON t_client.client_id = t_client_claim.client_id\n";
    $select_sql .= "        LEFT JOIN\n";

    //��������ơ��֥�
    $select_sql .= "    (SELECT\n";
    $select_sql .= "         t_client_info.intro_account_id,\n";
    $select_sql .= "         t_client_info.client_id,\n";
    $select_sql .= "         t_client.client_cd1,\n";
    $select_sql .= "         t_client.client_cd2,\n";
    $select_sql .= "         t_client.client_div,\n";
    $select_sql .= "         t_client.client_cname AS client_name\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "         t_client_info,\n";
    $select_sql .= "         t_client\n";
    $select_sql .= "    WHERE\n";
    $select_sql .= "         t_client.client_id  = t_client_info.intro_account_id\n";
    $select_sql .= "    ) AS t_client_intro_act\n";
    $select_sql .= "    ON t_client.client_id = t_client_intro_act.client_id\n";
    $select_sql .= "        LEFT JOIN\n";
    $select_sql .= "    t_account\n";
    $select_sql .= "    ON t_client.account_id = t_account.account_id\n";
    $select_sql .= "        LEFT JOIN\n";
    $select_sql .= "    t_b_bank\n";
    $select_sql .= "    ON t_account.b_bank_id = t_b_bank.b_bank_id\n";
    $select_sql .= "        LEFT JOIN\n";

    //�����裲�Ѥη��
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_claim.*,\n";
    $select_sql .= "        t_client.client_id AS claim2_id,\n";
    $select_sql .= "        t_client.client_cd1,\n";
    $select_sql .= "        t_client.client_cd2,\n";
    $select_sql .= "        t_client.client_cname AS client_name\n";
    $select_sql .= "    FROM\n";
    $select_sql .= "        t_claim\n";
    $select_sql .= "            INNER JOIN\n";
    $select_sql .= "        t_client\n";
    $select_sql .= "        ON t_claim.claim_id = t_client.client_id\n";
    $select_sql .= "        AND t_claim.claim_div = '2'\n";
    $select_sql .= "    ) AS t_client_claim2\n";
    $select_sql .= "    ON t_client.client_id = t_client_claim2.client_id\n";
    $select_sql .= "        INNER JOIN";

    //��������ơ��֥�
    $select_sql .= "    t_client_info";
    $select_sql .="     ON t_client.client_id = t_client_info.client_id";
    $select_sql .= " WHERE\n";
    $select_sql .= "    t_client.client_id = $_GET[client_id]\n";
    $select_sql .= ";";

    // ������ȯ��
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    // �ǡ�������
    $client_data = @pg_fetch_array($result, 0);

    // ����ͥǡ���
    $defa_data["form_client"]["cd1"]          = $client_data[0];         // �����襳���ɣ�
    $defa_data["form_client"]["cd2"]          = $client_data[1];         // �����襳���ɣ�
    $defa_data["form_state"]                  = $client_data[2];         // ����
    $defa_data["form_client_name"]            = $client_data[3];         // ������̾
    $defa_data["form_client_read"]            = $client_data[4];         // ������̾(�եꥬ��)
    $defa_data["form_client_cname"]           = $client_data[5];         // ά��
    $defa_data["form_post"]["no1"]            = $client_data[6];         // ͹���ֹ棱
    $defa_data["form_post"]["no2"]            = $client_data[7];         // ͹���ֹ棲
    $defa_data["form_address1"]               = $client_data[8];         // ���꣱
    $defa_data["form_address2"]               = $client_data[9];         // ���ꣲ
    $defa_data["form_address_read"]           = $client_data[10];        // ����(�եꥬ��)
    $defa_data["form_area_id"]                = $client_data[11];        // �϶�
    $defa_data["form_tel"]                    = $client_data[12];        // TEL
    $defa_data["form_fax"]                    = $client_data[13];        // FAX
    $defa_data["form_rep_name"]               = $client_data[14];        // ��ɽ�Ի�̾
    $defa_data["form_charger1"]               = $client_data[15];        // ��ô���ԣ�
    $defa_data["form_charger2"]               = $client_data[16];        // ��ô���ԣ�
    $defa_data["form_charger3"]               = $client_data[17];        // ��ô���ԣ�
    $defa_data["form_charger_part1"]          = $client_data[18];        // �����ô��
    $defa_data["form_charger_part2"]          = $client_data[19];        // �����ޥ�
    $trade_stime1[1] = substr($client_data[20],0,2);
    $trade_stime1[2] = substr($client_data[20],3,2);
    $trade_etime1[1] = substr($client_data[21],0,2);
    $trade_etime1[2] = substr($client_data[21],3,2);
    $trade_stime2[1] = substr($client_data[22],0,2);
    $trade_stime2[2] = substr($client_data[22],3,2);
    $trade_etime2[1] = substr($client_data[23],0,2);
    $trade_etime2[2] = substr($client_data[23],3,2);
    $defa_data["form_trade_stime1"]["h"]      = $trade_stime1[1];        // �ĶȻ���(�������ϻ���)
    $defa_data["form_trade_stime1"]["m"]      = $trade_stime1[2];        // �ĶȻ���(�������ϻ���)
    $defa_data["form_trade_etime1"]["h"]      = $trade_etime1[1];        // �ĶȻ���(������λ����)
    $defa_data["form_trade_etime1"]["m"]      = $trade_etime1[2];        // �ĶȻ���(������λ����)
    $defa_data["form_trade_stime2"]["h"]      = $trade_stime2[1];        // �ĶȻ���(���峫�ϻ���)
    $defa_data["form_trade_stime2"]["m"]      = $trade_stime2[2];        // �ĶȻ���(��峫�ϻ���)
    $defa_data["form_trade_etime2"]["h"]      = $trade_etime2[1];        // �ĶȻ���(��彪λ����)
    $defa_data["form_trade_etime2"]["m"]      = $trade_etime2[2];        // �ĶȻ���(��彪λ����)
    $defa_data["form_holiday"]                = $client_data[24];        // ����
    $defa_data["form_btype"]                  = $client_data[25];        // �ȼ�
    $defa_data["form_b_struct"]               = $client_data[26];        // ����
    $defa_data["form_claim"]["cd1"]           = $client_data[27];        // �����襳���ɣ�
    $defa_data["form_claim"]["cd2"]           = $client_data[28];        // �����襳���ɣ�
    $defa_data["form_claim"]["name"]          = $client_data[29];        // ������̾

    $defa_data["form_intro_act"]["cd"]        = $client_data[30];        // �Ҳ�����襳����
    $defa_data["form_intro_act"]["name"]      = $client_data[31];        // �Ҳ������̾
    /*
		if($client_data[32] != null){
        $defa_data["form_account"]["1"] = checked;
        $check_which = 1;
        $defa_data["form_account"]["price"]       = $client_data[32];        // ������
    }
    if($client_data[33] != null){
        $defa_data["form_account"]["2"] = checked;
        $check_which = 2;
        $defa_data["form_account"]["rate"]        = $client_data[33];        // ������(Ψ)
    }
		*/
    //$defa_data["form_cshop"]                  = $client_data[34];        // ô����Ź
    $defa_data["form_c_staff_id1"]            = $client_data[35];        // ����ô����
    $defa_data["form_c_staff_id2"]            = $client_data[36];        // ����ô����
//     $defa_data["form_d_staff_id1"]            = $client_data[37];        // ���ô����
//     $defa_data["form_d_staff_id2"]            = $client_data[38];        // ���ô����
//     $defa_data["form_d_staff_id3"]            = $client_data[39];        // ���ô����
    $defa_data["form_col_terms"]              = $client_data[37];        // ������
    $defa_data["form_cledit_limit"]           = $client_data[38];        // Ϳ������
    $defa_data["form_capital"]                = $client_data[39];        // ���ܶ�
    $defa_data["trade_aord_1"]                = $client_data[40];        // �����ʬ
    $defa_data["form_close"]                  = $client_data[41];        // ����
    $defa_data["form_pay_m"]                  = $client_data[42];        // ������(��) 
    $defa_data["form_pay_d"]                  = $client_data[43];        // ������(��)
    $defa_data["form_pay_way"]                = $client_data[44];        // ������ˡ
    $defa_data["form_bank"][1]                = $client_data[45];        // �������
    $defa_data["form_pay_name"]               = $client_data[46];        // ����̾��
    $defa_data["form_account_name"]           = $client_data[47];        // ����̾��
    $cont_s_day[y] = substr($client_data[48],0,4);
    $cont_s_day[m] = substr($client_data[48],5,2);
    $cont_s_day[d] = substr($client_data[48],8,2);
    $cont_e_day[y] = substr($client_data[49],0,4);
    $cont_e_day[m] = substr($client_data[49],5,2);
    $cont_e_day[d] = substr($client_data[49],8,2);
    $cont_r_day[y] = substr($client_data[51],0,4);
    $cont_r_day[m] = substr($client_data[51],5,2);
    $cont_r_day[d] = substr($client_data[51],8,2);
    $defa_data["form_cont_s_day"]["y"]        = $cont_s_day[y];          // ����ǯ����(ǯ)
    $defa_data["form_cont_s_day"]["m"]        = $cont_s_day[m];          // ����ǯ����(��)
    $defa_data["form_cont_s_day"]["d"]        = $cont_s_day[d];          // ����ǯ����(��)
    $defa_data["form_cont_e_day"]["y"]        = $cont_e_day[y];          // ����λ��(ǯ)
    $defa_data["form_cont_e_day"]["m"]        = $cont_e_day[m];          // ����λ��(��)
    $defa_data["form_cont_e_day"]["d"]        = $cont_e_day[d];          // ����λ��(��)
    $defa_data["form_cont_peri"]              = $client_data[50];        // �������
    $defa_data["form_cont_r_day"]["y"]        = $cont_r_day[y];          // ���󹹿���(ǯ)
    $defa_data["form_cont_r_day"]["m"]        = $cont_r_day[m];          // ���󹹿���(��)
    $defa_data["form_cont_r_day"]["d"]        = $cont_r_day[d];          // ���󹹿���(��)
    $defa_data["form_slip_out"]               = $client_data[52];        // ��ɼȯ��
    $defa_data["form_deliver_note"]           = $client_data[53];        // Ǽ�ʽ񥳥���
    $defa_data["form_claim_out"]              = $client_data[54];        // �����ȯ��
    $defa_data["form_coax"]                   = $client_data[55];        // �ݤ�
    $defa_data["form_tax_div"]                = $client_data[56];        // ������(����ñ��)
    $defa_data["form_tax_franct"]             = $client_data[57];        // ������(ü����ʬ)
    $defa_data["form_note"]                   = $client_data[58];        // ����������������¾
    $defa_data["form_email"]                  = $client_data[59];        // Email
    $defa_data["form_url"]                    = $client_data[60];        // URL
    $defa_data["form_represent_cell"]         = $client_data[61];        // ��ɽ�Է���
    $defa_data["form_direct_tel"]             = $client_data[62];        // ľ��TEL
    $defa_data["form_bstruct"]                = $client_data[63];        // ����
    $defa_data["form_inst"]                   = $client_data[64];        // ����
    $establish_day[y] = substr($client_data[65],0,4);
    $establish_day[m] = substr($client_data[65],5,2);
    $establish_day[d] = substr($client_data[65],8,2);
    $defa_data["form_establish_day"]["y"]     = $establish_day[y];       // �϶���(ǯ)
    $defa_data["form_establish_day"]["m"]     = $establish_day[m];       // �϶���(��)
    $defa_data["form_establish_day"]["d"]     = $establish_day[d];       // �϶���(��)
    $defa_data["form_record"]                 = $client_data[66];        // �������
    $defa_data["form_important"]              = $client_data[67];        // ���׻���
    $defa_data["form_trans_account"]          = $client_data[68];        // �����������̾
    $defa_data["form_bank_fc"]                = $client_data[69];        // ���/��Ź̾
    $defa_data["form_account_num"]            = $client_data[70];        // �����ֹ�
    $round_start[y] = substr($client_data[71],0,4);
    $round_start[m] = substr($client_data[71],5,2);
    $round_start[d] = substr($client_data[71],8,2);
    $defa_data["form_round_start"]["y"]       = $round_start[y];         // ��󳫻���(ǯ)
    $defa_data["form_round_start"]["m"]       = $round_start[m];         // ��󳫻���(��)
    $defa_data["form_round_start"]["d"]       = $round_start[d];         // ��󳫻���(��)
    $defa_data["form_deliver_radio"]          = $client_data[72];        // Ǽ�ʽ񥳥���(����)
    $defa_data["form_claim_send"]             = $client_data[73];        // ���������(͹��)
    $defa_data["form_charger_part3"]          = $client_data[74];        // ����������
    $defa_data["form_cname_read"]             = $client_data[76];        // ά��(�եꥬ��)
    $defa_data["form_rep_position"]           = $client_data[77];        // ��ɽ����
    $defa_data["form_bank"][0]                = $client_data[78];        // �������
    $defa_data["form_address3"]               = $client_data[79];        // ���ꣳ
    $defa_data["form_company_name"]           = $client_data[80];        // �Ʋ��̾
    $defa_data["form_company_tel"]            = $client_data[81];        // �Ʋ��TEL
    $defa_data["form_company_address"]        = $client_data[82];        // �Ʋ�ҽ���
    $defa_data["form_client_name2"]           = $client_data[83];        // ������̾2
    $defa_data["form_client_read2"]           = $client_data[84];        // ������̾2(�եꥬ��)
    $defa_data["form_charger_represe1"]       = $client_data[85];        // ��ô�����򿦣�
    $defa_data["form_charger_represe2"]       = $client_data[86];        // ��ô�����򿦣�
    $defa_data["form_charger_represe3"]       = $client_data[87];        // ��ô�����򿦣�
    $defa_data["form_charger_note"]           = $client_data[88];        // ��ô��������
    $defa_data["form_bank_div"]               = $client_data[89];        // ��ô��������
    $defa_data["form_claim_note"]             = $client_data[90];        // ����񥳥���
    $defa_data["form_client_slip1"]           = $client_data[91];        // �����裱��ɼ����
    $defa_data["form_client_slip2"]           = $client_data[92];        // �����裲��ɼ����
    $defa_data["form_parent_rep_name"]        = $client_data[93];        // �Ʋ����ɽ�Ի�̾
    $parent_establish_day[y] = substr($client_data[94],0,4);
    $parent_establish_day[m] = substr($client_data[94],5,2);
    $parent_establish_day[d] = substr($client_data[94],8,2);
    $defa_data["form_parent_establish_day"]["y"]   = $parent_establish_day[y];
    $defa_data["form_parent_establish_day"]["m"]   = $parent_establish_day[m];
    $defa_data["form_parent_establish_day"]["d"]   = $parent_establish_day[d];
//    $defa_data["form_type"]                   = $client_data[95];
    $defa_data["form_prefix"]                 = $client_data[96];
    $defa_data["form_act_flg"]                = $client_data[97];            // ��ԥե饰
    $act_flg                                  = $client_data[97];        
    $defa_data["form_s_pattern_select"]       = $client_data[98];            //��ɼȯ�ԥѥ�����
    $defa_data["form_c_pattern_select"]       = $client_data[99];            //�����ȯ���ѥ�����
    $defa_data["form_charge_branch_id"]       = $client_data[charge_branch_id];           //ô����Ź
    $defa_data["form_c_tax_div"]              = $client_data["c_tax_div"];   //���Ƕ�ʬ
    $defa_data["form_claim2"]["cd1"]          = $client_data["claim2_cd1"];  //�����裲�����ɣ�
    $defa_data["form_claim2"]["cd2"]          = $client_data["claim2_cd2"];  //�����裲�����ɣ�
    $defa_data["form_claim2"]["name"]         = $client_data["claim2_name"]; //�����裲̾
    $defa_data["form_bank"][2]                = $client_data["account_id"]; //����ID 

    $defa_data["form_client_gr"]              = $client_data["client_gr_id"];
    $defa_data["form_parents_div"]            = $client_data["parents_flg"];


    #2010-04-30 hashimoto-y
    $defa_data["form_bill_address_font"]      = ($client_data["bill_address_font"] == 't')? 1 : 0;


    if($client_data["intro_act_div"] == '3'){
        $defa_data["form_intro_act"]["cd2"]       = $client_data["intro_act_cd2"];  //�Ҳ������CD2
        $defa_data["form_client_div"]         = '1';
    }elseif($client_data["intro_act_div"] == '2'){
        $defa_data["form_client_div"]         = '2';
    }else{
        $defa_data["form_client_div"]         = '1';
    }
//    $defa_data["hdn_intro_ac_id"]             = $client_data["intro_act_id"];   //�Ҳ����ID


    //����������
    for($i = 0; $i < 12; $i++){
        $defa_data["claim1_monthly_check"][$i] = ($client_data["month".($i+1)."_flg"] == 't')? $client_data["month".($i+1)."_flg"] : null;
    }

   // ���������
    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "client",$client_data[0].",".$client_data[1]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    // ��ʬ��¾��������Ȥ�����Ͽ����Ƥ��뤫
    $sql  = "SELECT\n";
    $sql .= "   count(client_id) ";
    $sql .= "FROM\n";
    $sql .= "   t_claim ";
    $sql .= "WHERE\n";
    $sql .= "   client_id <> $get_client_id ";
    $sql .= "   AND\n";
    $sql .= "   claim_id = $get_client_id ";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $claim_num = pg_fetch_result($result, 0, 0);

    // �ѹ��Բĥե饰
    $change_flg = ($claim_num > 0) ? true : false;

    //�����裲���ͤ����ꡢ��ݻĤ�������
    if($client_data["claim2_id"] != null){
        $warning = "�� �����裲�Ϻ���Ǥ��ޤ��������ޤǤ���ݤ�����˵󤬤�ʤ��ʤ�ޤ���";
        $form->addElement("textarea", "form_warning", "",
            "cols=\"40\" row=\"2\" 
            style=\"color:#0000ff;
                    font-weight: bold; 
                    border : #ffffff 1px solid;
                    background-color: #ffffff;
                    scrollbar-base-color: #ffffff;
                    scrollbar-track-color: #ffffff;
                    scrollbar-face-color: #ffffff;
                    scrollbar-shadow-color: #ffffff;
                    scrollbar-darkshadow-color: #ffffff;
                    scrollbar-highlight-color: #ffffff;
                    scrollbar-3dlight-color: #ffffff;
                    scrollbar-arrow-color: #ffffff;\"
            readonly\"");
        $set_warning["form_warning"] = $warning;
        $form->setConstants($set_warning);
    }
}

$client_div = $client_data[75];

/***************************/
// �ե��������
/***************************/
// ����
/*
$form_type[] =& $form->createElement("radio", null, null, "��ԡ���", "1");
$form_type[] =& $form->createElement("radio", null, null, "��ԡ��ȳ�", "2");
$form->addGroup($form_type, "form_type", "");
*/
// �����襳����
$form_client[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_client[cd1]', 'form_client[cd2]',6)\"".$g_form_option."\"");
$form_client[] =& $form->createElement("static", "", "", "-");
$form_client[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_client, "form_client", "");

// �����襳���ɶ��������ɸ������
$form->addElement("link", "form_cd_search", "", "#", "���������ɸ���", "tabindex=\"-1\" 
    onClick=\"javascript:return Open_SubWin('../dialog/2-0-103.php', Array('form_client[cd1]','form_client[cd2]'), 570, 650, 3, 1);\"
");

// �����
$text = null;
$text[] =& $form->createElement("radio", null, null, "�����", "1");
$text[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$text[] =& $form->createElement("radio", null, null, "����", "3");
$freeze_state = $form->addGroup($text, "form_state", "");

//���Ū�˾��֤��ѹ��Բ�----------------------------------------------------------------------------------------------------------------------------------------
//if($new_flg == false){
//    $freeze_state->freeze();
//}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------



// ������̾
$freeze_text[] = $form->addElement("text", "form_client_name", "",'size="44" maxLength="25"'." $g_form_option");

// ������̾��
$freeze_text[] = $form->addElement("text", "form_client_name2", "",'size="44" maxLength="25"'." $g_form_option");

// ������̾�ʥեꥬ�ʡ�
$freeze_text[] = $form->addElement("text", "form_client_read", "",'size="46" maxLength="50"'." $g_form_option");

// ������̾���ʥեꥬ�ʡ�
$freeze_text[] = $form->addElement("text", "form_client_read2", "",'size="46" maxLength="50"'." $g_form_option");

// ������̾����ɼ����
$form->addElement("checkbox", "form_client_slip1", "");

// ������̾����ɼ����
$form->addElement("checkbox", "form_client_slip2", "");


// ά��
$freeze_text[] = $form->addElement("text", "form_client_cname", "",'size="44" maxLength="20"'." $g_form_option");

// ά�Ρʥեꥬ�ʡ�
$freeze_text[] = $form->addElement("text", "form_cname_read", "",'size="46" maxLength="40"'." $g_form_option");

// ͹���ֹ�
$form_post[] =& $form->createElement("text", "no1", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_post[no1]', 'form_post[no2]',3)\"".$g_form_option."\"");
$form_post[] =& $form->createElement("static", "", "", "-");
$form_post[] =& $form->createElement("text", "no2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_post, "form_post", "");

// ���꣱
$form->addElement("text", "form_address1", "",'size="44" maxLength="25"'." $g_form_option");

// ���ꣲ
$form->addElement("text", "form_address2", "",'size="46" maxLength="25"'." $g_form_option");

// ���ꣳ
$form->addElement("text", "form_address3", "",'size="44" maxLength="30"'." $g_form_option");

// ����(�եꥬ��)
$form->addElement("text", "form_address_read", "",'size="46" maxLength="50"'." $g_form_option");
        
// ͹���ֹ�
// ��ư���ϥܥ��󤬲������줿���
if($_POST["input_button_flg"] == true){
    $post1      = $_POST["form_post"]["no1"];             // ͹���ֹ棱
    $post2      = $_POST["form_post"]["no2"];             // ͹���ֹ棲
    $post_value = Post_Get($post1, $post2, $conn);
    // ͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button_flg"]  = "";
    // ͹���ֹ椫�鼫ư����
    $cons_data["form_post"]["no1"]  = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"]  = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"]     = $post_value[1];
    $cons_data["form_address2"]     = $post_value[2];

    $form->setConstants($cons_data);
}

// �϶�
$select_ary = Select_Get($conn, "area");

$form->addElement("select", "form_area_id", "", $select_ary, $g_form_option_select);

// TEL
$form->addElement("text", "form_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

// FAX
$form->addElement("text", "form_fax", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

// Email
$form->addElement("text", "form_email", "", "size=\"34\" maxLength=\"60\" style=\"$g_form_style\""." $g_form_option");

// URL
$form->addElement("text", "form_url", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option");

// ��ɽ��
$form->addElement("text", "form_rep_name", "",'size="34" maxLength="15"'." $g_form_option");

// ��ɽ����
$form->addElement("text", "form_rep_position", "",'size="22" maxLength="10"'." $g_form_option");

// ��ɽ�Է���
$form->addElement("text", "form_represent_cell", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option");

// ľ��TEL
$form->addElement("text", "form_direct_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

// �Ʋ��̾
$form->addElement("text", "form_company_name", "", "size=\"44\" maxLength=\"30\" $g_form_option");

// �Ʋ��TEL
$form->addElement("text", "form_company_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option");

// �Ʋ�ҽ���
$form->addElement("text", "form_company_address", "", "size=\"120\" maxLength=\"100\" $g_form_option");

// �Ʋ���϶���
$form_parent_establish_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_parent_establish_day[y]', 'form_parent_establish_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_parent_establish_day[] =& $form->createElement("static", "", "", "-");
$form_parent_establish_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_parent_establish_day[m]', 'form_parent_establish_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_parent_establish_day[] =& $form->createElement("static", "", "", "-");
$form_parent_establish_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_parent_establish_day, "form_parent_establish_day", "");

// �Ʋ����ɽ�Ի�̾
$form->addElement("text", "form_parent_rep_name", "",'size="34" maxLength="15"'." $g_form_option");

// ����
$form->addElement("text", "form_charger_part1", "", "size=\"22\" maxLength=\"10\" $g_form_option");
// ����
$form->addElement("text", "form_charger_part2", "", "size=\"22\" maxLength=\"10\" $g_form_option");
// ����
$form->addElement("text", "form_charger_part3", "", "size=\"22\" maxLength=\"10\" $g_form_option");
// �򿦣�
$form->addElement("text", "form_charger_represe1", "", "size\"22\" maxLength=\"10\" $g_form_option");
// �򿦣�
$form->addElement("text", "form_charger_represe2", "", "size\"22\" maxLength=\"10\" $g_form_option");
// �򿦣�
$form->addElement("text", "form_charger_represe3", "", "size\"22\" maxLength=\"10\" $g_form_option");

// ��ô��1
$form->addElement("text", "form_charger1", "",'size="34" maxLength="15"'." $g_form_option");

// ��ô��2
$form->addElement("text", "form_charger2", "",'size="34" maxLength="15"'." $g_form_option");

// ��ô��3
$form->addElement("text", "form_charger3", "",'size="34" maxLength="15"'." $g_form_option");

// ô��������
$form->addElement("textarea", "form_charger_note", "", 'rows="5" cols="75"'." $g_form_option_area");

// ��Լ������ô��ʬ
$form_bank_div[] =& $form->createElement("radio", null, null, "��������ô", "1");
$form_bank_div[] =& $form->createElement("radio", null, null, "������ô", "2");
$form->addGroup($form_bank_div, "form_bank_div", "");

// �ĶȻ���
// �������ϻ���
$form_stime1[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime1[h]', 'form_trade_stime1[m]',2)\"".$g_form_option."\"");
$form_stime1[] =& $form->createElement("static", "", "", "��");
$form_stime1[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime1[m]', 'form_trade_etime1[h]',2)\"".$g_form_option."\"");
$form->addGroup($form_stime1, "form_trade_stime1", "");

// ������λ����
$form_etime1[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_etime1[h]', 'form_trade_etime1[m]',2)\"".$g_form_option."\"");
$form_etime1[] =& $form->createElement("static", "", "", "��");
$form_etime1[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_etime1[m]', 'form_trade_stime2[h]',2)\"".$g_form_option."\"");
$form->addGroup($form_etime1, "form_trade_etime1", "");

// ��峫�ϻ���
$form_stime2[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime2[h]', 'form_trade_stime2[m]',2)\"".$g_form_option."\"");
$form_stime2[] =& $form->createElement("static", "", "", "��");
$form_stime2[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime2[m]', 'form_trade_etime2[h]',2)\"".$g_form_option."\"");
$form->addGroup($form_stime2, "form_trade_stime2", "");

// ��彪λ����
$form_etime2[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_etime2[h]', 'form_trade_etime2[m]',2)\"".$g_form_option."\"");
$form_etime2[] =& $form->createElement("static", "", "", "��");
$form_etime2[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_etime2, "form_trade_etime2", "");

// ����
$form->addElement("text", "form_holiday", "",'size="22" maxLength="10"'." $g_form_option");

// �ȼ�
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_sbtype.sbtype_id,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name";
$sql .= " FROM";
$sql .= "   (SELECT";
$sql .= "       t_lbtype.lbtype_id,";
$sql .= "       t_lbtype.lbtype_cd,";
$sql .= "       t_lbtype.lbtype_name";
$sql .= "   FROM";
$sql .= "       t_lbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_lbtype";
$sql .= "       INNER JOIN";
$sql .= "   (SELECT";
$sql .= "       t_sbtype.sbtype_id,";
$sql .= "       t_sbtype.lbtype_id,";
$sql .= "       t_sbtype.sbtype_cd,";
$sql .= "       t_sbtype.sbtype_name";
$sql .= "   FROM";
$sql .= "       t_sbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_sbtype";
$sql .= "   ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

while($data_list = pg_fetch_array($result)){
    if($max_len < mb_strwidth($data_list[1])){
        $max_len = mb_strwidth($data_list[1]);
    }
}

$result = Db_Query($conn, $sql);
$select_value       = "";
$select_value[""]   = "";
while($data_list = pg_fetch_array($result)){
    $space = "";
    for($i = 0; $i< $max_len; $i++){
        if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
            $data_list[1] = $data_list[1]."��";
        }
    }
    
    $select_value[$data_list[2]] = $data_list[0]." �� ".$data_list[1]."���� ".$data_list[3]." �� ".$data_list[4];
}

$form->addElement("select", "form_btype", "", $select_value, $g_form_option_select);

// ����
$sql    = "SELECT inst_id, inst_cd, inst_name FROM t_inst WHERE accept_flg = '1' ORDER BY inst_cd;";
$result = Db_Query($conn, $sql);
$select_value       = "";
$select_value[""]   = "";
while($data_list = pg_fetch_array($result)){
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement("select", 'form_inst',"", $select_value,$g_form_option_select);

// ����
$sql    = "SELECT bstruct_id, bstruct_cd, bstruct_name FROM t_bstruct WHERE accept_flg = '1' ORDER BY bstruct_cd;";
$result = Db_Query($conn, $sql);
$select_value       = "";
$select_value[""]   = "";
while($data_list = pg_fetch_array($result)){
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement("select", 'form_bstruct',"", $select_value,$g_form_option_select);

// ������1
$form_claim[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" 
            style=\"$g_form_style\" 
            onkeyup=\"changeText(this.form, 'form_claim[cd1]', 'form_claim[cd2]',6)\" 
            onkeyup=\"javascript:claim1('form_claim[cd1]', 'form_claim[cd2]', 'form_claim[name]', 'form_pay_name', 'form_account_name', '1'); 
            changeText(this.form,'form_claim[cd1]','form_claim[cd2]',6)\"".$g_form_option."\"");
$form_claim[] =& $form->createElement("static", "", "", "-");
$form_claim[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
            onkeyup=\"javascript:claim1('form_claim[cd1]', 'form_claim[cd2]', 'form_claim[name]', 'form_pay_name', 'form_account_name', '1')\"".$g_form_option."\"");
$form_claim[] =& $form->createElement("text", "name", "", "size=\"44\" $g_text_readonly");
$freeze = $form->addGroup($form_claim, "form_claim", "");
($change_flg == true) ? $freeze->freeze() : null;

//�����裲
$form_claim2[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" 
            onkeyup=\"changeText(this.form, 'form_claim2[cd1]', 'form_claim2[cd2]',6)\" 
            onkeyup=\"javascript:claim1('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]','','',''); 
            changeText(this.form,'form_claim2[cd1]','form_claim2[cd2]',6)\"".$g_form_option."\"");
$form_claim2[] =& $form->createElement("static", "", "", "-");
$form_claim2[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"javascript:claim1('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]','','','')\"".$g_form_option."\"");
$form_claim2[] =& $form->createElement("text", "name", "", "size=\"44\" $g_text_readonly");
$freeze = $form->addGroup($form_claim2, "form_claim2", "");
($change_flg == true) ? $freeze->freeze() : null;

// �Ҳ������
//ľ�Ĥξ��Τ�
if($group_kind == '2'){
    $form_intro_act[] =& $form->createElement("text", "cd", "", "size=\"7\" maxLength=\"6\" 
            style=\"$g_form_style\" 
            onKeyUp=\"javascript:client2('form_intro_act[cd]','form_intro_act[cd2]','form_intro_act[name]')\" 
            $g_form_option");
    $form_intro_act[] =& $form->createElement("static", "", "", "-");
    $form_intro_act[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onKeyUp=\"javascript:client2('form_intro_act[cd]','form_intro_act[cd2]','form_intro_act[name]')\" $g_form_option");
}else{
    $form_intro_act[] =& $form->createElement("text", "cd", "", "size=\"7\" maxLength=\"6\" 
            style=\"$g_form_style\" 
            onKeyUp=\"javascript:client2('form_intro_act[cd]','form_intro_act[name]')\" 
            $g_form_option");
}

$form_intro_act[] =& $form->createElement("text", "name", "", "size=\"34\" $g_text_readonly");
$form->addGroup($form_intro_act, "form_intro_act", "");

//�Ȳ�����ѥ饸���ܥ���
$form_client_div[] =& $form->createElement("radio", null, null, "FC", "1", "onClick=code_disable(); onChange=client_div();");
$form_client_div[] =& $form->createElement("radio", null, null, "������", "2", "onClick=code_disable(); onChange=client_div();");
$form->addGroup($form_client_div, "form_client_div", "");

// �����������̾
$form->addElement("text", "form_trans_account", "",'size="34" maxLength="20"'." $g_form_option");

// ��Ի�Ź̾
$form->addElement("text", "form_bank_fc", "",'size="34" maxLength="20"'." $g_form_option");

// �����ֹ�
$form->addElement("text", "form_account_num", "", "size=\"20\" maxLength=\"15\" style=\"$g_form_style\""." $g_form_option");

/*
// ������(����̾������)
$form_account[] =& $form->createElement("checkbox", "1" ,"" ,"" ,"onClick='return Check_Button2(1);'");
$form_account[] =& $form->createElement("static", "��", "", "������");
$form_account[] =& $form->createElement("text", "price", "", "size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form_account[] =& $form->createElement("static", "", "", "�ߡ�������");
$form_account[] =& $form->createElement("checkbox", "2" ,"" ,"" ,"onClick='return Check_Button2(2);'");
$form_account[] =& $form->createElement("static", "", "", "����");
$form_account[] =& $form->createElement("text", "rate", "", "size=\"3\" maxLength=\"3\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form_account[] =& $form->createElement("static", "", "", "��");
$form->addGroup($form_account, "form_account", "");
*/


// ô����Ź
/*
if($_SESSION[group_kind] == "2"){
    $select_ary = Select_Get($conn,'dshop');
}else{
    $where  = " AND t_client.client_id = $_SESSION[client_id]";
    $select_ary = Select_Get($conn,'fshop',$where);
}
$form->addElement("select", 'form_cshop',"", $select_ary, $g_form_option_select );
*/

// ô����Ź
$select_value = Select_Get($conn,'branch');
$form->addElement('select', 'form_charge_branch_id', '��Ź', $select_value,$g_form_option_select);

// ����ô��1
/*
$sql  = "SELECT ";
$sql .= "    staff_id,";
$sql .= "    charge_cd,";
$sql .= "    staff_name ";
$sql .= "FROM ";
$sql .= "    t_staff ";
$sql .= "ORDER BY charge_cd";
$sql .= ";";
$result = Db_Query($conn,$sql);
$select_value = NULL;
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[1] = str_pad($data_list[1], 4, 0, STR_POS_LEFT);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
*/

$select_ary = Select_Get($conn,'cstaff');
$form->addElement("select", 'form_c_staff_id1', "", $select_ary, $g_form_option_select );

// ����ô��2
// $select_ary = Select_Get($conn,'cstaff');
$select_ary = Select_Get($conn,'cstaff',"","1");
$form->addElement("select", 'form_c_staff_id2', "", $select_ary, $g_form_option_select );

// ���ô����1
// $select_ary = null;
// $select_ary = Select_Get($conn,'cstaff');
// $form->addElement("select", 'form_d_staff_id1',"", $select_ary, $g_form_option_select );

// ���ô����2
// $form->addElement("select", 'form_d_staff_id2',"", $select_ary, $g_form_option_select );

// ���ô����3
// $form->addElement("select", 'form_d_staff_id3',"", $select_ary, $g_form_option_select );

// ��󳫻���
$form_round_start[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_round_start[y]', 'form_round_start[m]',4)\" ".$g_form_option."\"");
$form_round_start[] =& $form->createElement("static", "", "", "-");
$form_round_start[] =& $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_round_start[m]', 'form_round_start[d]',2)\" ".$g_form_option."\"");
$form_round_start[] =& $form->createElement("static", "", "", "-");
$form_round_start[] =& $form->createElement("text", "d", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup($form_round_start, "form_round_start", "");

// ������
$form->addElement("text", "form_col_terms", "",'size="34" maxLength="50"'." $g_form_option");

// Ϳ������
$form->addElement("text", "form_cledit_limit", "", "class=money size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

// ���ܶ�
$form->addElement("text", "form_capital", "", "class=money size=\"11\" maxLength=\"9\"$g_form_option style=\"text-align: right; $g_form_style\"");

// �����ʬ
$select_value = Select_Get($conn, "trade_aord");
// $select_value[11] .= "��(��������������ɬ�ܤȤʤ�ޤ���)";
//$form->addElement("select", 'trade_aord_1', "", $select_value, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();pay_way()\"");
$form->addElement("select", 'trade_aord_1', "", $select_value, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_close_day();\"");

// ����
$select_value = Select_Get($conn,'close');
$freeze = $form->addElement("select", "form_close", "����", $select_value, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_close_day();\"");
//($change_flg == true) ? $freeze->freeze() : null;

// ������
// ��
$select_month[null] = null; 
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[$i] = "����";
    }elseif($i == 1){
        $select_month[$i] = "���";
    }else{
        $select_month[$i] = $i."�����";
    }
}
$form->addElement("select", "form_pay_m", "", $select_month, $g_form_option_select);

// ��
for($i = 0; $i <= 29; $i++){
    if($i == 29){
        $select_day[$i] = '����';
    }elseif($i == 0){
        $select_day[null] = null;
    }else{
        $select_day[$i] = $i."��";
    }
}
$form->addElement("select", "form_pay_d", "", $select_day, $g_form_option_select);

// ��ʧ����ˡ
$select_value = Select_Get($conn, "pay_way");
$form->addElement("select", 'form_pay_way',"", $select_value,$g_form_option_select);      

// �������
/*
$select_ary = Select_Get($conn,'bank');
$sql  = " WHERE"; 
//$sql .= "   t_bank.shop_gid = $_SESSION[shop_gid]";
$sql .=($_SESSION[group_kind] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $_SESSION[client_id] ";

$ary_b_bank = Select_Get($conn,'b_bank', $sql);
$bank_select = $form->addElement('hierselect', 'form_bank', '',$g_form_option_select ,
    "</td><td class=\"Title_Purple\"><b>������Ի�Ź</b></td><td class=\"value\">");
$bank_select->setOptions(array($select_ary, $ary_b_bank));
*/

$select_ary = Make_Ary_Bank($conn);
$bank_select = $form->addElement('hierselect', 'form_bank', '',$g_form_option_select ,"������");
$bank_select->setOptions(array($select_ary[0], $select_ary[1], $select_ary[2]));


// ����̾��
$form->addElement("text", "form_pay_name", "",'size="34" maxLength="50"'." $g_form_option");

// ����̾��
$form->addElement("text", "form_account_name", "",'size="34" maxLength="15"'." $g_form_option");

// ����ǯ����
$form_cont_s_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_s_day[y]', 'form_cont_s_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_s_day[] =& $form->createElement("static", "", "", "-");
$form_cont_s_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_s_day[m]', 'form_cont_s_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_s_day[] =& $form->createElement("static", "", "", "-");
$form_cont_s_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_cont_s_day, "form_cont_s_day", "");

// ����λ��
$form_cont_e_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_e_day[y]', 'form_cont_e_day[m]',4)\"".$g_form_option."\"");
$form_cont_e_day[] =& $form->createElement("static", "", "", "-");
$form_cont_e_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_e_day[m]', 'form_cont_e_day[d]',2)\"".$g_form_option."\"");
$form_cont_e_day[] =& $form->createElement("static", "", "", "-");
$form_cont_e_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup($form_cont_e_day, "form_cont_e_day", "");

// �������
$form->addElement("text", "form_cont_peri", "", "size=\"2\" maxLength=\"2\" style=\"text-align: right; $g_form_style\" onkeyup=\"Contract(this.form)\" $g_form_option");

// ���󹹿���
$form_cont_r_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_r_day[y]', 'form_cont_r_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_r_day[] =& $form->createElement("static", "", "", "-");
$form_cont_r_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_r_day[m]', 'form_cont_r_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_r_day[] =& $form->createElement("static", "", "", "-");
$form_cont_r_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_cont_r_day, "form_cont_r_day", "");

// �϶���
$form_establish_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_establish_day[y]', 'form_establish_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_establish_day[] =& $form->createElement("static", "", "", "-");
$form_establish_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_establish_day[m]', 'form_establish_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_establish_day[] =& $form->createElement("static", "", "", "-");
$form_establish_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_establish_day, "form_establish_day", "form_establish_day");

// ��ɼȯ��
$form_slip_out[] =& $form->createElement("radio", null, null, "ͭ",   "1");
$form_slip_out[] =& $form->createElement("radio", null, null, "����", "2");
$form_slip_out[] =& $form->createElement("radio", null, null, "¾ɼ�ʺ�ȴ�λ��������",   "3");
$form->addGroup($form_slip_out, "form_slip_out", "");

// Ǽ�ʽ񥳥���
// ��¥��ܥ���
$form_deliver_radio[] =& $form->createElement("radio", null, null, "������̵��", "1");
$form_deliver_radio[] =& $form->createElement("radio", null, null, "���̥�����ͭ��", "2");
$form_deliver_radio[] =& $form->createElement("radio", null, null, "���Υ�����ͭ��", "3");
$form->addGroup($form_deliver_radio, "form_deliver_radio", "");
// �ƥ�����
$form->addElement("textarea", "form_deliver_note", "",' rows="5" cols="75"'." $g_form_option_area");

#2010-04-30 hashimoto-y
// �������ե������
$form->addElement("checkbox", "form_bill_address_font", "");


// �����ȯ��
$form_claim_out[] =& $form->createElement("radio", null, null, "���������", "1");
$form_claim_out[] =& $form->createElement("radio", null, null, "��������", "2");
$form_claim_out[] =& $form->createElement("radio", null, null, "�������������", "5");
$form_claim_out[] =& $form->createElement("radio", null, null, "���Ϥ��ʤ�", "3");
$form_claim_out[] =& $form->createElement("radio", null, null, "����",       "4");
$form->addGroup($form_claim_out, "form_claim_out", "");
/*
// �����ϰ�
$form_claim_scope[] =& $form->createElement("radio", null, null, "���۳ۤ�ޤ��", "t");
$form_claim_scope[] =& $form->createElement("radio", null, null, "���۳ۤ�ޤ�ʤ�", "f");
$form->addGroup($form_claim_scope, "form_claim_scope", "");
*/

// ���������
$form_claim_send[] =& $form->createElement("radio", null, null, "͹��", "1");
$form_claim_send[] =& $form->createElement("radio", null, null, "�᡼��", "2");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "WEB", "4");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "͹�����᡼��", "3");
$form->addGroup($form_claim_send, "form_claim_send", "");

// ����񥳥���
$form->addElement("textarea", "form_claim_note", "",' rows="5" cols="75"'." $g_form_option_area");

// �ɾ�
$form_prefix_radio[] =& $form->createElement("radio", null, null, "����", "1");
$form_prefix_radio[] =& $form->createElement("radio", null, null, "��", "2");
$form->addGroup($form_prefix_radio, "form_prefix", "");

// ���
// �ݤ��ʬ
$form_coax[] =& $form->createElement("radio", null, null, "�ڼ�", "1");
$form_coax[] =& $form->createElement("radio", null, null, "�ͼθ���", "2");
$form_coax[] =& $form->createElement("radio", null, null, "�ھ�", "3");
$freeze = $form->addGroup($form_coax, "form_coax", "");
//($change_flg == true) ? $freeze->freeze() : null;

// ����ñ��
$form_tax_div[] =& $form->createElement("radio", null, null, "��ɼñ��", "2");
$form_tax_div[] =& $form->createElement("radio", null, null, "����ñ��", "1");
$freeze = $form->addGroup($form_tax_div, "form_tax_div", "");
//($change_flg == true) ? $freeze->freeze() : null;

// ���Ƕ�ʬ
$form_c_tax_div[] =& $form->createElement("radio", null, null, "����", "1");
#2009-12-25 aoyama-n
#$form_c_tax_div[] =& $form->createElement("radio", null, null, "����", "2");
$freeze = $form->addGroup($form_c_tax_div, "form_c_tax_div", "");
//($change_flg == true) ? $freeze->freeze() : null;
//���Ū�˾��֤��ѹ��Բ�---------------------------------------------------------------------------------------------------------------
    //���Ū
//    if($new_flg === false){
    $freeze->freeze();
//    }
//



// ü����ʬ
$form_tax_franct[] =& $form->createElement("radio", null, null, "�ڼ�", "1");
$form_tax_franct[] =& $form->createElement("radio", null, null, "�ͼθ���", "2");
$form_tax_franct[] =& $form->createElement("radio", null, null, "�ھ�", "3");
$freeze = $form->addGroup($form_tax_franct, "form_tax_franct", "");
//($change_flg == true) ? $freeze->freeze() : null;

// ����������������¾
$form->addElement("textarea", "form_note", "",' rows="3" cols="75"'." $g_form_option_area");

// �������
$form->addElement("textarea", "form_record", "",' rows="3" cols="75"'." $g_form_option_area");

// ���׻���
$form->addElement("textarea", "form_important", "",' rows="3" cols="75"'." $g_form_option_area");

// hidden
$form->addElement("hidden", "input_button_flg");
$form->addElement("hidden", "ok_button_flg");
$form->addElement("hidden", "form_act_flg");    // ��ԥե饰

//�Ҳ������ID������ޤ��
//$form->addElement("hidden", "hdn_intro_ac_id");     //�Ҳ������ID

// ���쥯�ȥܥå���
/*
$select_value = Null;
$select_value[1] = "�ѥ�����";
$select_value[2] = "�ѥ�����";
$select_value[3] = "�ѥ�����";
$select_value[4] = "�ѥ�����";
$select_value[5] = "�ѥ�����";
$select_value[6] = "�ѥ�����";
$select_value[7] = "�ѥ�����";
$select_value[8] = "�ѥ�����";
$select_value[9] = "�ѥ�����";
$select_value[10] = "�ѥ����󣱣�";
*/

//�����ɼȯ�ԥѥ�����
$select_value = null;
$select_value = Select_Get($conn,"pattern");
$form->addElement("select", "form_s_pattern_select", "",$select_value,$g_form_option_select);

//�����ȯ�ԥѥ�����
$select_value = null;
$select_value = Select_Get($conn,"claim_pattern");
$form->addElement("select", "form_c_pattern_select", "",$select_value,$g_form_option_select);


//���롼��
$select_value = null;
$select_value = Select_Get($conn, "client_gr");
$form->addElement("select", "form_client_gr", "",$select_value,$g_form_option_select);

$form_parents_div[] =& $form->createElement("radio", null, null, "��", "true");
$form_parents_div[] =& $form->createElement("radio", null, null, "��", "false");
$form_parents_div[] =& $form->createElement("radio", null, null, "��Ω", "null");
$freeze = $form->addGroup($form_parents_div, "form_parents_div", "");


//���������������裱��
for($i = 0; $i < 12; $i++){
    $form->addElement("checkbox", "claim1_monthly_check[$i]","", ($i+1)."��");
}

/****************************/
// �롼�����
/****************************/
//telfax�����å��Υ롼���ɲ�
$form->registerRule("telfax","function","Chk_Telfax");

// ���϶�
// ��ɬ�ܥ����å�
$form->addRule("form_area_id", "�϶�����򤷤Ʋ�������", "required");

// ���ȼ�
// ��ɬ�ܥ����å�
$form->addRule("form_btype", "�ȼ�����򤷤Ʋ�������", "required");

$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
/*
// ��FC���롼��
// ��ɬ�ܥ����å�
$form->addRule("form_shop_gr_1", "FC���롼�פ����򤷤Ƥ���������", "required");
*/

// �������襳����
// ��ɬ�ܥ����å�
$form->addGroupRule('form_client', array(
        'cd1' => array(array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', 'required')),      
        'cd2' => array(array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', 'required')),      
));

// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_client', array(
        'cd1' => array(array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),      
        'cd2' => array(array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
));

// ��������̾
// ��ɬ�ܥ����å�
$form->addRule("form_client_name", "������̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���", "required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_client_name", "������̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

// ��ά��
// ��ɬ�ܥ����å�
$form->addRule("form_client_cname", "ά�Τ�1ʸ���ʾ�20ʸ���ʲ��Ǥ���", "required");
$form->addRule("form_client_cname", "ά�� �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

// ��͹���ֹ�
// ��ɬ�ܥ����å�
// ��Ⱦ�ѿ��������å�
// ��ʸ���������å�
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', 'required'),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "regex", "/^[0-9]+$/"),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', 'required'),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "regex", "/^[0-9]+$/"),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(4,4))
        ),
));

// �����꣱
// ��ɬ�ܥ����å�
$form->addRule("form_address1", "���꣱��1ʸ���ʾ�25ʸ���ʲ��Ǥ���", "required");

// ��TEL
// ��ɬ�ܥ����å�
// ��Ⱦ�ѿ��������å�
$form->addRule(form_tel, "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "required");
$form->addRule("form_tel","TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "telfax");

// ����ɽ�Ի�̾
// ��ɬ�ܥ����å�
// $form->addRule("form_rep_name", "��ɽ�Ի�̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���", "required");

// ���Ʋ���϶���
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_parent_establish_day', array(
        'y' => array(array('�Ʋ�Ҥ��϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('�Ʋ�Ҥ��϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'd' => array(array('�Ʋ�Ҥ��϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
));

// ���ĶȻ���
// ���������ϻ���
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_stime1', array(
        'h' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
));

// ��������λ����
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_etime1', array(
        'h' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
));

// ����峫�ϻ���
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_stime2', array(
        'h' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
));

// ����彪λ����
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_etime2', array(
        'h' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
));
/*
// ��������
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_account', array(
        'price' => array(array('��������Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
        'rate' => array(array('��������Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")),
));
*/

// ��ô����Ź
// �����ϥ����å�
//$form->addRule("form_cshop", "ô����Ź�����򤷤Ʋ�������", "required");

// ��ô����Ź
// �����ϥ����å�
$form->addRule("form_charge_branch_id", "ô����Ź�����򤷤Ʋ�������", "required");


// ��Ϳ������
// ��Ⱦ�ѿ��������å�
$form->addRule("form_cledit_limit", "Ϳ�����٤�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

// �����ܶ�
// ��Ⱦ�ѿ��������å�
$form->addRule("form_capital", "���ܶ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

// ���������ʷ��
// ��Ⱦ�ѿ��������å�
$form->addRule("form_pay_m", "�������ʷ�ˤ����򤷤Ʋ�������", "required");

// ��������������
// ��Ⱦ�ѿ��������å�
$form->addRule("form_pay_d", "�����������ˤ����򤷤Ʋ�������", "required");

// ������ǯ����
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(array('����ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('����ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'd' => array(array('����ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
));
// ������λ��
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_e_day', array(
        'y' => array(array('����λ�������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('����λ�������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'd' => array(array('����ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
));
// �����󹹿���
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(array('���󹹿��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('���󹹿��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'd' => array(array('���󹹿��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
));

// ���϶���
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_establish_day', array(
        'y' => array(array('�϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('�϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'd' => array(array('�϶��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
));

// �������ʬ
// ��ɬ�ܥ����å�
$form->addRule("trade_aord_1", "�����ʬ�����򤷤Ʋ�������", "required");

// ��Ǽ�ʽ񥳥���
// ��Ⱦ�ѿ��������å�
$form->addRule("form_deliver_note", "Ǽ�ʽ񥳥��Ȥ�50ʸ������Ǥ���", "mb_maxlength",'50');

// ���������
// ��Ⱦ�ѿ��������å�
$form->addRule("form_cont_peri", "������֤�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

// ����󳫻���
// ��Ⱦ�ѿ��������å�
$form->addGroupRule('form_round_start', array(
        'y' => array(array('��󳫻��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'm' => array(array('��󳫻��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
        'd' => array(array('��󳫻��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")),
));

// ��ɼȯ�ԥѥ�����
$form->addRule("form_s_pattern_select", "�����ɼȯ�ԥѥ���������򤷤Ʋ�������", "required");

// �����ȯ�ԥѥ�����
$form->addRule("form_c_pattern_select", "�����ȯ�ԥѥ���������򤷤Ʋ�������", "required");

/***************************/
// �롼�������PHP��
// ***************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ"){
    /****************************/
    // POST����
    /****************************/
//     $shop_gr        = $_POST["form_shop_gr_1"];                 // FC���롼��
    $client_cd1             = $_POST["form_client"]["cd1"];             // �����襳���ɣ�
    $client_cd2             = $_POST["form_client"]["cd2"];             // �����襳���ɣ�
    $state                  = $_POST["form_state"];                     // ����
    $client_name            = $_POST["form_client_name"];               // ������̾
    $client_read            = $_POST["form_client_read"];               // ������̾�ʥեꥬ�ʡ�
    $client_name2           = $_POST["form_client_name2"];              // ������̾2
    $client_read2           = $_POST["form_client_read2"];              // ������̾�ʥեꥬ�ʡ�2
    $client_cname           = $_POST["form_client_cname"];              // ά��
    $cname_read             = $_POST["form_cname_read"];                // ά�Ρʥեꥬ�ʡ�
    $post_no1               = $_POST["form_post"]["no1"];               // ͹���ֹ棱
    $post_no2               = $_POST["form_post"]["no2"];               // ͹���ֹ棲
    $address1               = $_POST["form_address1"];                  // ���꣱
    $address2               = $_POST["form_address2"];                  // ���ꣲ
    $address3               = $_POST["form_address3"];                  // ���ꣳ
    $address_read           = $_POST["form_address_read"];              // ���꣱�ʥեꥬ�ʡ�
    $area_id                = $_POST["form_area_id"];                   // �϶襳����
    $tel                    = $_POST["form_tel"];                       // TEL
    $fax                    = $_POST["form_fax"];                       // FAX
    $rep_name               = $_POST["form_rep_name"];                  // ��ɽ�Ի�̾

/*20060420�ɲ�*/
    $charger1               = $_POST["form_charger1"];                  // ��ô���ԣ�
    $charger2               = $_POST["form_charger2"];                  // ��ô���ԣ�
    $charger3               = $_POST["form_charger3"];                  // ��ô���ԣ�
    $charger_represe1       = $_POST["form_charger_represe1"];          // ��ô�����򿦣�
    $charger_represe2       = $_POST["form_charger_represe2"];          // ��ô�����򿦣�
    $charger_represe3       = $_POST["form_charger_represe3"];          // ��ô�����򿦣�
    $charger_part1          = $_POST["form_charger_part1"];             // ��ô��������
    $charger_part2          = $_POST["form_charger_part2"];             // ��ô��������
    $charger_part3          = $_POST["form_charger_part3"];             // ��ô��������
    $charger_note           = $_POST["form_charger_note"];              // ��ô��������
/**************/

    $trade_stime1           = str_pad($_POST["form_trade_stime1"]["h"],2,0,STR_PAD_LEFT);         // �ĶȻ��֡ʸ������ϡ�
    $trade_stime1          .= ":"; 
    $trade_stime1          .= str_pad($_POST["form_trade_stime1"]["m"],2,0,STR_PAD_LEFT);
    $trade_etime1           = str_pad($_POST["form_trade_etime1"]["h"],2,0,STR_PAD_LEFT);         // �ĶȻ��֡ʸ�����λ��
    $trade_etime1          .= ":"; 
    $trade_etime1          .= str_pad($_POST["form_trade_etime1"]["m"],2,0,STR_PAD_LEFT);
    $trade_stime2           = str_pad($_POST["form_trade_stime2"]["h"],2,0,STR_PAD_LEFT);         // �ĶȻ��֡ʸ�峫�ϡ�
    $trade_stime2          .= ":"; 
    $trade_stime2          .= str_pad($_POST["form_trade_stime2"]["m"],2,0,STR_PAD_LEFT);
    $trade_etime2           = str_pad($_POST["form_trade_etime2"]["h"],2,0,STR_PAD_LEFT);         // �ĶȻ��֡ʸ�彪λ��
    $trade_etime2          .= ":"; 
    $trade_etime2          .= str_pad($_POST["form_trade_etime2"]["m"],2,0,STR_PAD_LEFT);
    $holiday                = $_POST["form_holiday"];                   // ����
    $btype                  = $_POST["form_btype"];                     // �ȼ拾����
    $b_struct               = $_POST["form_b_struct"];                  // ����
    $claim_cd1              = $_POST["form_claim"]["cd1"];              // �����襳���ɣ�
    $claim_cd2              = $_POST["form_claim"]["cd2"];              // �����襳���ɣ�
    $claim_name             = $_POST["form_claim"]["name"];             // ������̾
    $intro_act_cd           = $_POST["form_intro_act"]["cd"];           // �Ҳ�����襳����
    $intro_act_cd2          = $_POST["form_intro_act"]["cd2"];          // �Ҳ�����襳����2
    $intro_act_name         = $_POST["form_intro_act"]["name"];         // �Ҳ������̾
    $intro_act_div          = $_POST["form_client_div"];         // �Ҳ������̾
    //$price_check            = $_POST["form_account"]["1"];
    //$account_price          = $_POST["form_account"]["price"];          // ������
    //$rate_check             = $_POST["form_account"]["2"];
    //$account_rate           = $_POST["form_account"]["rate"];           // ����Ψ
    //$cshop_id               = $_POST["form_cshop"];                     // ô����Ź
    $charge_branch_id       = $_POST["form_charge_branch_id"];                     // ô����Ź
    $c_staff_id1            = $_POST["form_c_staff_id1"];               // ����ô����
    $c_staff_id2            = $_POST["form_c_staff_id2"];               // ����ô����
//     $d_staff_id1    = $_POST["form_d_staff_id1"];               // ���ô����
//     $d_staff_id2    = $_POST["form_d_staff_id2"];               // ���ô����
//     $d_staff_id3    = $_POST["form_d_staff_id3"];               // ���ô����
    $col_terms              = $_POST["form_col_terms"];                 // ������
    $cledit_limit           = $_POST["form_cledit_limit"];              // Ϳ������
    $capital                = $_POST["form_capital"];                   // ���ܶ�
    $trade_id               = $_POST["trade_aord_1"];                  // �����ʬ
    $close_day_cd           = $_POST["form_close"];                     // ����
    $pay_m                  = $_POST["form_pay_m"];                     // �������ʷ��
    $pay_d                  = $_POST["form_pay_d"];                     // ������������
    $pay_way                = $_POST["form_pay_way"];                   // ������ˡ
//    $bank_enter_cd          = $_POST["form_bank"][1];                      // ��ԸƽХ�����
    $bank_enter_cd          = $_POST["form_bank"][2];
    $pay_name               = $_POST["form_pay_name"];                  // ����̾��
    $account_name           = $_POST["form_account_name"];              // ����̾��
    $cont_s_day             = $_POST["form_cont_s_day"]["y"];           // ���󳫻���
    $cont_s_day            .= "-"; 
    $cont_s_day            .= $_POST["form_cont_s_day"]["m"];
    $cont_s_day            .= "-"; 
    $cont_s_day            .= $_POST["form_cont_s_day"]["d"];
    $cont_e_day             = $_POST["form_cont_e_day"]["y"];            // ����λ��
    $cont_e_day            .= "-"; 
    $cont_e_day            .= $_POST["form_cont_e_day"]["m"];
    $cont_e_day            .= "-"; 
    $cont_e_day            .= $_POST["form_cont_e_day"]["d"];
    $cont_peri              = $_POST["form_cont_peri"];                 // �������
    $cont_r_day             = $_POST["form_cont_r_day"]["y"];            // ���󹹿���
    $cont_r_day            .= "-"; 
    $cont_r_day            .= $_POST["form_cont_r_day"]["m"];
    $cont_r_day            .= "-"; 
    $cont_r_day            .= $_POST["form_cont_r_day"]["d"];
    $slip_out               = $_POST["form_slip_out"];                  // ��ɼȯ��
    $deliver_note           = $_POST["form_deliver_note"];              // Ǽ�ʽ񥳥���
    $claim_out              = $_POST["form_claim_out"];                 // �����ȯ��
    $coax                   = $_POST["form_coax"];                      // ��ۡ��ݤ��ʬ
    $tax_div                = $_POST["form_tax_div"];                   // �����ǡ�����ñ��
    $tax_franct             = $_POST["form_tax_franct"];                // �����ǡ�ü����ʬ
    $note                   = $_POST["form_note"];                      // ����������������¾
    $email                  = $_POST["form_email"];                     // Email
    $url                    = $_POST["form_url"];                       // URL
    $represent_cell         = $_POST["form_represent_cell"];            // ��ɽ�Է���
    $represe                = $_POST["form_rep_position"];              // ��ɽ����
    $direct_tel             = $_POST["form_direct_tel"];                // ľ��TEL
    $bstruct                = $_POST["form_bstruct"];                   // ����
    $inst                   = $_POST["form_inst"];                      // ����
    $establish_day          = $_POST["form_establish_day"]["y"];        // �϶���
    $establish_day         .= "-"; 
    $establish_day         .= $_POST["form_establish_day"]["m"];
    $establish_day         .= "-"; 
    $establish_day         .= $_POST["form_establish_day"]["d"];
    $record                 = $_POST["form_record"];                    // �������
    $important              = $_POST["form_important"];                 // ���׻���
    $trans_account          = $_POST["form_trans_account"];             // �����������̾
    $bank_fc                = $_POST["form_bank_fc"];                   // ���/��Ź̾
    $account_num            = $_POST["form_account_num"];               // �����ֹ�
    $round_start            = $_POST["form_round_start"]["y"];          // ��󳫻���
    $round_start           .= "-"; 
    $round_start           .= $_POST["form_round_start"]["m"];
    $round_start           .= "-"; 
    $round_start           .= $_POST["form_round_start"]["d"];
    $deliver_radio          = $_POST["form_deliver_radio"];             // Ǽ�ʽ񥳥���(����
    $claim_send             = $_POST["form_claim_send"];                // ���������
    $company_name           = $_POST["form_company_name"];              // �Ʋ��̾
    $company_tel            = $_POST["form_company_tel"];               // �Ʋ��TEL
    $company_address        = $_POST["form_company_address"];           // �Ʋ�ҽ���
    $bank_div               = $_POST["form_bank_div"];                  // ��Լ������ô��ʬ
    $claim_note             = $_POST["form_claim_note"];                // ����񥳥���
    $client_slip1           = $_POST["form_client_slip1"];              // �����裱��ɼ����
    $client_slip2           = $_POST["form_client_slip2"];              // �����裲��ɼ����
    $parent_rep_name        = $_POST["form_parent_rep_name"];           // �Ʋ����ɽ��̾
    $parent_establish_day   = $_POST["form_parent_establish_day"]["y"];
    $parent_establish_day  .= "-";
    $parent_establish_day  .= $_POST["form_parent_establish_day"]["m"];
    $parent_establish_day  .= "-";
    $parent_establish_day  .= $_POST["form_parent_establish_day"]["d"];
//    $type                   = $_POST["form_type"];                      // ����
    // $claim_scope    = $_POST["form_claim_scope"];                    // �����ϰ�
    $compellation           = $_POST["form_prefix"];                    // �ɾ�

    $s_pattern_id           = $_POST["form_s_pattern_select"];          //�����ɼȯ�ԥѥ�����
    $c_pattern_id           = $_POST["form_c_pattern_select"];          //�����ȯ�ԥѥ�����
    $c_tax_div              = $_POST["form_c_tax_div"];                 //���Ƕ�ʬ
    $claim2_cd1             = $_POST["form_claim2"]["cd1"];             // ������2�����ɣ�
    $claim2_cd2             = $_POST["form_claim2"]["cd2"];             // ������2�����ɣ�
    $claim2_name            = $_POST["form_claim2"]["name"];            // ������̾2

    $client_gr_id           = $_POST["form_client_gr"];                 //���롼��ID
    $parents_flg            = $_POST["form_parents_div"];               //�ƻҥե饰

    $claim1_monthly_check   = $_POST["claim1_monthly_check"];           //����������
    $claim2_monthly_check   = $_POST["claim2_monthly_check"];           //����������

    #2010-04-30 hashimoto-y
    $bill_address_font      = ($_POST["form_bill_address_font"] == '1')? 't' : 'f'; //������ե����
    

    // ���顼Ƚ�̥ե饰
    $err_flg = false;
    /****************************/
    // �����������å��ܥå���Ƚ��
    /****************************/
    if($price_check == 1){
        $check_which = 1;
    }else if($rate_check == 1){
        $check_which = 2;
    }else{
        $check_which = 0;
    }
    
    /***************************/
    // �����
    /***************************/
    // �����襳���ɣ�
    $client_cd1 = str_pad($client_cd1, 6, 0, STR_POS_LEFT);

    // �����襳���ɣ�
    $client_cd2 = str_pad($client_cd2, 4, 0, STR_POS_LEFT);

    if(($client_cd1 != null && $client_data[0] != $client_cd1) || ($client_cd2 != null && $client_data[1] != $client_cd2)){
        $client_cd_sql  = "SELECT";
        $client_cd_sql .= " client_id FROM t_client";
        $client_cd_sql .= " WHERE";
        $client_cd_sql .= " client_cd1 = '$client_cd1'";
        $client_cd_sql .= " AND";
        $client_cd_sql .= " client_cd2 = '$client_cd2'";
        $client_cd_sql .= "  AND";
        $client_cd_sql .= "  (t_client.client_div = '1'";
        $client_cd_sql .= "  OR";
        $client_cd_sql .= "  t_client.client_div = '3')";
        $client_cd_sql .= " AND ";
        $client_cd_sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
        $client_cd_sql .= ";";
        $select_client = Db_Query($conn, $client_cd_sql);
        $select_client = pg_num_rows($select_client);
        if($select_client != 0){
            $client_cd_err = "���Ϥ��줿�����襳���ɤϻ�����Ǥ���";
            $err_flg = true;
        }
    }

    //���롼�ץ����å�
    if(($parents_flg == "true" || $parents_flg == "false") && $client_gr_id == null){    
        $form->setElementError("form_client_gr", "�Ƥޤ��ϻҤ����򤷤����ϥ��롼�פ�ɬ�ܹ��ܤǤ���");
        $err_flg = true;
    }


    // ���Ҳ������
    // �����ϥ����å�
    if($_POST["form_intro_act"]["cd"] != null && $_POST["form_intro_act"]["name"] == null){
        $intro_act_err = "�������Ҳ�����襳���ɤ����Ϥ��Ʋ�������";
        $err_flg = true;
    }
    
	//�Ҳ������
	//ɬ��Ƚ��(�����������򤵤�Ƥ���Ȥ���ɬ��)
	if(($price_check != NULL || $rate_check != NULL) 
        && 
        (($intro_act_div == '1' && ($intro_act_cd == NULL || $intro_act_cd2 == NULL)) 
        ||
        ($intro_act_div == '2' && $intro_act_cd == NULL) 
        ||
        $intro_act_name == NULL)){
		$form->setElementError("form_intro_act","���Ҳ���� �����򤷤Ʋ�������");
	}


    // ��FAX
    // ��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_fax","FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    // ��Email
    if (!(ereg("^[^@]+@[^.]+\..+", $email)) && $email != "") {
        $email_err = "Email�������ǤϤ���ޤ���";
        $err_flg = true;
    }

    // ��URL
    // �����ϥ����å�
    if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null) {
        $url_err = "������URL�����Ϥ��Ʋ�������";
        $err_flg = true;
    }

    // ����ɽ�Է���     �ºݤˤ��ι��ܤ�¸�ߤ��ʤ�
    // ��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$represent_cell) && $represent_cell != ""){
        $rep_cell_err = "��ɽ�Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }

    // ��ľ��TEL         �ºݤˤ��ι��ܤ�¸�ߤ��ʤ�
    // ��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$direct_tel) && $direct_tel != ""){
        $d_tel_err = "ľ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }

    // ���Ʋ��TEL
    // ��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_company_tel","�Ʋ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    // ������
    // ��ɬ�ܥ����å�
    if($_POST["form_close"] == 0){
        $close_err = "���������򤷤Ʋ�������";
        $err_flg = true;
    //�����ʬ��������������Ȼ�ʧ����Ʊ���Ǥʤ����
    }elseif($trade_id == '61' && ($close_day_cd != $pay_d || $pay_m != '0')){
        $close_err = "�����ʬ�˸������ꤷ�����ν�����������������ˤ��Ʋ�������";
        $err_flg = true;
    //��ʧ������������դ�������꾮�������
    }elseif($trade_id == '11' && $_POST["form_pay_m"] == "0" && ($_POST["form_close"] >= $_POST["form_pay_d"])){
//        $close_err = "�������ʷ�ˤ���������򤷤�����������꾮���������������ˤ����򤷤Ʋ�������";
        $close_err = "���������������������դ�����Ǥ��ޤ���";
        $err_flg = true;
    }

    //����������
    //������1
    if(!is_array($claim1_monthly_check)){
        $claim1_check_flg = false;
        $form->setElementError("claim1_monthly_check[0]", "������1�����������򤷤Ʋ�������");
    }else{
        $claim1_check_flg = true;
    }

    // ��������
    // �����ϥ����å�
    if($client_cd1 == $claim_cd1 && $client_cd2 == $claim_cd2){
        $claim_flg = true;
    }elseif(
        ($_POST["form_claim"]["cd1"] != null || $_POST["form_claim"]["cd2"] != null || $_POST["form_claim"]["name"] != null)
        &&
        ($_POST["form_claim"]["cd1"] == null || $_POST["form_claim"]["cd2"] == null || $_POST["form_claim"]["name"] == null)
    ){
        $claim_err = "�����������襳���ɤ����Ϥ��Ʋ�������";
        $err_flg = true;
    // �����������褬���Ϥ��줿���
    }elseif($claim_cd1 != null && $claim_cd2 != null && $claim_name != null){

        $sql  = "SELECT";
        $sql .= "   t_client.close_day,";
        $sql .= "   t_client.coax,";
        $sql .= "   t_client.tax_div,";
        $sql .= "   t_client.tax_franct,";
        $sql .= "   t_client.c_tax_div,";
        $sql .= "   t_claim.month1_flg,";
        $sql .= "   t_claim.month2_flg,";
        $sql .= "   t_claim.month3_flg,";
        $sql .= "   t_claim.month4_flg,";
        $sql .= "   t_claim.month5_flg,";
        $sql .= "   t_claim.month6_flg,";
        $sql .= "   t_claim.month7_flg,";
        $sql .= "   t_claim.month8_flg,";
        $sql .= "   t_claim.month9_flg,";
        $sql .= "   t_claim.month10_flg,";
        $sql .= "   t_claim.month11_flg,";
        $sql .= "   t_claim.month12_flg ";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_claim";
        $sql .= "   ON t_client.client_id = t_claim.client_id ";
        $sql .= "   AND t_claim.claim_div = '1' ";
        $sql .= " WHERE";
        $sql .= "   t_client.client_cd1 = '$claim_cd1'";
        $sql .= "   AND";
        $sql .= "   t_client.client_cd2 = '$claim_cd2'";
        $sql .= "   AND";
        $sql .= "   t_client.client_div = '1'";
        $sql .= "   AND";
        $sql .= ($group_kind == 2) ? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
        $sql .= ";"; 

        $result = Db_Query($conn ,$sql);
        $claim_data = pg_fetch_array($result ,0 );
        $claim_close_day  = $claim_data["close_day"];    //������
        $claim_coax       = $claim_data["coax"];         //�ݤ��ʬ
        $claim_tax_div    = $claim_data["tax_div"];      //����ñ��
        $claim_tax_franct = $claim_data["tax_franct"];   //ü����ʬ 
        $claim_c_tax_div  = $claim_data["c_tax_div"];    //���Ƕ�ʬ
        //����������
        for($i = 1; $i < 13; $i++){
            if($claim_data["month".$i."_flg"] == 't'){
                $claim_month_data[$i-1] = '1';

                //���顼��å�����
                if($claim_month_msg == null){
                    $claim_month_msg .= $i."��";
                }else{
                    $claim_month_msg .= ",".$i."��";
                }
            }
        }


        //���������������Ʊ���ǤϤʤ�����������
        if($close_day_cd != $claim_close_day){
            // ����Ƚ��
            if($claim_close_day == "29"){
                $claim_err = "������������1��Ʊ�� ���� �����򤷤Ʋ�������";
            }else{
                $claim_err = "������������1��Ʊ�� ".$claim_close_day."�� �����򤷤Ʋ�������";
            }
            $err_flg = true;
        }else{
            $claim_flg = true;
        } 

        //������δݤ��ʬ��Ʊ���ǤϤʤ�����������
        if($coax != $claim_coax){

            //���顼��å�������ɽ�����뤿��ݤ��ʬ���ִ�
            if($claim_coax == "1"){
                $claim_coax = "�ڼ�";
            }elseif($claim_coax == "2"){
                $claim_coax = "�ͼθ���";
            }elseif($claim_coax == "3"){
                $claim_coax = "�ھ�";
            }

            $claim_coax_err = "�ޤ���ʬ��������1��Ʊ�� ".$claim_coax." �����򤷤Ʋ�������";
            $err_flg = true;
        }     

        //������β���ñ�̤�Ʊ���ǤϤʤ�����������
        if($tax_div != $claim_tax_div){

            //���顼��å�������ɽ�����뤿�����ñ�̤��ִ�
            if($claim_tax_div == '2'){
                $claim_tax_div = "��ɼñ��";
            }elseif($claim_tax_div == '1'){
                $claim_tax_div = "����ñ��";
            }

            $claim_tax_div_err = "����ñ�̤�������1��Ʊ�� ".$claim_tax_div." �����򤷤Ʋ�������";

            $err_flg = true;
        }

        //�������ü����ʬ��Ʊ���ǤϤʤ�����������
        if($tax_franct != $claim_tax_franct){

            //���顼��å�������ɽ�����뤿��ü����ʬ���ִ�
            if($claim_tax_franct == '1'){
                $claim_tax_franct = "�ڼ�";
            }elseif($claim_tax_franct == '2'){
                $claim_tax_franct = "�ͼθ���";
            }elseif($claim_tax_franct == '3'){
                $claim_tax_franct = "�ھ�";
            }

            $claim_tax_franct_err = "ü����������1��Ʊ�� ".$claim_tax_franct." �����򤷤Ʋ�������";
            $err_flg = true;
        }

        //������β��Ƕ�ʬ��Ʊ���ǤϤʤ�����������
        if($c_tax_div != $claim_c_tax_div){

            //���顼��å�������ɽ�����뤿����Ƕ�ʬ���ִ�
            if($claim_c_tax_div == '1'){
                $claim_c_tax_div = "����";
            }elseif($claim_c_tax_div == '2'){
                $claim_c_tax_div = "����";
            }

            $claim_c_tax_div_err = "���Ƕ�ʬ��������1��Ʊ�� ".$claim_c_tax_div." �����򤷤Ʋ�������";
            $err_flg = true;
        }

        //����������
        foreach($claim_month_data AS $key => $val){
            if($val != $claim1_monthly_check[$key]){
                $claim_month_err_flg = true;
                break;
            }
        }

        if($claim_month_err_flg === true && $claim1_check_flg === true){
            $claim_month_err = "������������1��Ʊ�� ".$claim_month_msg." �����򤷤Ʋ�������";
        }
    }

    // ��������2
    // �����ϥ����å�
    if(($claim2_cd1 != null || $claim2_cd2 != null || $claim2_name != null)
        &&
        ($claim2_cd1 == null || $claim2_cd2 == null || $claim2_name == null)
    ){
        $claim2_err = "�����������襳���ɤ����Ϥ��Ʋ�������";
        $err_flg = true;
    //�����裱��Ʊ�����
    }elseif(($claim_cd1 == $claim2_cd1 && $claim_cd2 == $claim2_cd2 && $claim_name == $claim2_name)
            &&
        ($claim_cd1 != null && $claim_cd2 != null && $claim_name != null)){
            $claim2_err = "������1��Ʊ�������褬������2�˻��ꤵ��Ƥ��ޤ���";
            $err_flg = true;
    // �����������褬���Ϥ��줿���
    }elseif($claim2_cd1 != null && $claim2_cd2 != null && $claim2_name != null){
        $claim2_flg = true;
    //����ξ��
    }elseif($claim2_cd1 == null && $claim2_cd2 == null && $claim2_name == null && $new_flg == false){
        //����ξ��Ǥ�Ȥ�ȶ����̵�����Ϻ���Ǥ��뤫�����å�
        $sql  = "SELECT\n";
        $sql .= "   COUNT(*) \n";
        $sql .= "FROM\n";
        $sql .= "   t_claim\n";
        $sql .= "WHERE\n";
        $sql .= "   t_claim.client_id = $get_client_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_claim.claim_div = '2'\n";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $add_num = pg_fetch_result($result, 0,0);

        //��Ͽ����Ƥ������
        if($add_num > 0){
            //�����裲����ꤷ�Ƥ������ι��ֹ�����
            $sql  = "SELECT \n";
            $sql .= "   line \n";
            $sql .= "FROM \n";
            $sql .= "   t_contract \n";
            $sql .= "WHERE\n";
            $sql .= "   client_id = $get_client_id\n";
            $sql .= "   AND\n";
            $sql .= "   claim_div = '2' \n";
            $sql .= "   AND\n";
            $sql .= "   claim_id = (SELECT \n";
            $sql .= "                   claim_id\n";
            $sql .= "               FROM\n";
            $sql .= "                   t_claim\n";
            $sql .= "               WHERE\n";
            $sql .= "                   client_id = $get_client_id\n";
            $sql .= "                   AND\n";
            $sql .= "                   claim_div = '2' \n";
            $sql .= "               )\n";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $add_count = pg_num_rows($result);

            //����ޥ����ǻ��Ѥ��Ƥ�����
            if($add_count > 0){
                for($i = 0; $i < $add_count; $i++){
                    $line = pg_fetch_result($result, $i, 0);

                    $mess .= ($i == 0)? " ".$line : " ,".$line;
                }

                $err_mess = "����ޥ�����".$mess."���ܤ�������2����ꤷ�Ƥ��뤿�ᡢ����Ǥ��ޤ���";
                $err_flg = true;
            }
        }
    }

    // ������ǯ���������󹹿���
    // �����դ������������å�
    // ������ǯ���������󹹿���
    // �����դ������������å�
    $csday_y = (int)$_POST["form_cont_s_day"]["y"];
    $csday_m = (int)$_POST["form_cont_s_day"]["m"];
    $csday_d = (int)$_POST["form_cont_s_day"]["d"];
    $crday_y = (int)$_POST["form_cont_r_day"]["y"];
    $crday_m = (int)$_POST["form_cont_r_day"]["m"];
    $crday_d = (int)$_POST["form_cont_r_day"]["d"];
    $rsday_y = (int)$_POST["form_round_start"]["y"];
    $rsday_m = (int)$_POST["form_round_start"]["m"];
    $rsday_d = (int)$_POST["form_round_start"]["d"];
    $esday_y = (int)$_POST["form_establish_day"]["y"];
    $esday_m = (int)$_POST["form_establish_day"]["m"];
    $esday_d = (int)$_POST["form_establish_day"]["d"];
    $parent_esday_y = (int)$_POST["form_parent_establish_day"]["y"];
    $parent_esday_m = (int)$_POST["form_parent_establish_day"]["m"];
    $parent_esday_d = (int)$_POST["form_parent_establish_day"]["d"];

    if($csday_m != null || $csday_d != null || $csday_y != null){
        $csday_flg = true;
    }
    $check_s_day = checkdate($csday_m,$csday_d,$csday_y);
    if($check_s_day == false && $csday_flg == true){
        $csday_err = "����ǯ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
    if($crday_m != null || $crday_d != null || $crday_y != null){
        $crday_flg = true;
    }
    $check_r_day = checkdate($crday_m,$crday_d,$crday_y);
    if($check_r_day == false && $crday_flg == true){
        $crday_err = "���󹹿��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
    if($rsday_m != null || $rsday_d != null || $rsday_y != null){
        $rsday_flg = true;
    }
    $check_r_day = checkdate($rsday_m,$rsday_d,$rsday_y);
    if($check_r_day == false && $rsday_flg == true){
        $rsday_err = "��󳫻��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
    if($esday_m != null || $esday_d != null || $esday_y != null){
        $esday_flg = true;
    }
    $check_r_day = checkdate($esday_m,$esday_d,$esday_y);
    if($check_r_day == false && $esday_flg == true){
        $esday_err = "�϶��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    // �Ʋ���϶������������������å�
    if($parent_esday_m != null || $parent_esday_d != null || $parent_esday_y != null){
        $parent_esday_flg = true;
    }

    $check_r_day = checkdate($esday_m,$esday_d,$esday_y);
    if($check_r_day == false && $esday_flg == true){
        $parent_esday_err = "�϶��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    // �����󹹿���������ǯ�����������Ǥʤ��������å�
    if($cont_s_day >= $cont_r_day && $cont_s_day != '--' && $cont_r_day != '--'){
        $sday_rday_err = "���󹹿��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    #2010-04-30 hashimoto-y
    //������ե���ȥ���������˥����å�������ʲ��ξ���Ķ���Ƥʤ��������å�
    //���꣱��18 , ���ꣲ��18 , ���ꣳ��18 , ������̾����14 , ������̾����14
    if($bill_address_font == 't'){
        if( mb_strlen($address1) > 18 ){
            $address1_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢���꣱�ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
        if( mb_strlen($address2) > 18 ){
            $address2_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢���ꣲ�ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
        if( mb_strlen($address3) > 18 ){
            $address3_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢���ꣳ�ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
        //������̾����������ʤ������å����դ��Ƥʤ�����ġ�����ʸ����Ķ������
        if( $client_slip1 != 1 && mb_strlen($client_name) > 14 ){
            $client_name1_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢������̾���ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
        //������̾����������ʤ������å����դ��Ƥʤ�����ġ�����ʸ����Ķ������
        if( $client_slip2 != 1 && mb_strlen($client_name2) > 14 ){
            $client_name2_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢������̾���ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
    }

}

    // ���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
if($_POST["button"]["entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true ){
    /******************************/
    // DB��Ͽ����
    /******************************/
    $create_day = date("Y-m-d");
    /******************************/
    // ��Ͽ����
    /******************************/

    // ������ޥ�������Ͽ
    if($new_flg == true){
        Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                                        // ������ID
        $insert_sql .= "    client_cd1,";                                       // �����襳����
        $insert_sql .= "    client_cd2,";                                       // ��Ź������
        // $insert_sql .= "    shop_gid,";                                      // FC���롼��ID
        $insert_sql .= "    shop_id,";                                          // FCID
        $insert_sql .= "    create_day,";                                       // ������
        $insert_sql .= "    state,";                                            // ����
        $insert_sql .= "    client_name,";                                      // ������̾
        $insert_sql .= "    client_read,";                                      // ������̾�ʥեꥬ�ʡ�
        $insert_sql .= "    client_name2,";                                     // ������̾2
        $insert_sql .= "    client_read2,";                                     // ������̾2�ʥեꥬ�ʡ�
        $insert_sql .= "    client_cname,";                                     // ά��
        $insert_sql .= "    post_no1,";                                         // ͹���ֹ棱
        $insert_sql .= "    post_no2,";                                         // ͹���ֹ棲
        $insert_sql .= "    address1,";                                         // ���꣱
        $insert_sql .= "    address2,";                                         // ���ꣲ
        $insert_sql .= "    address3,";                                         // ���ꣳ
        $insert_sql .= "    address_read,";                                     // ����ʥեꥬ�ʡ�
        $insert_sql .= "    area_id,";                                          // �϶�ID
        $insert_sql .= "    tel,";                                              // tel
        $insert_sql .= "    fax,";                                              // fax
        $insert_sql .= "    rep_name,";                                         // ��ɽ�Ի�̾
        $insert_sql .= "    c_staff_id1,";                                      // ����ô����
        $insert_sql .= "    c_staff_id2,";                                      // ����ô����
//         $insert_sql .= "    d_staff_id1,";                                     // ���ô����
//         $insert_sql .= "    d_staff_id2,";                                     // ���ô����
//         $insert_sql .= "    d_staff_id3,";                                     // ���ô����
        $insert_sql .= "    charger1,";                                         // ��ô���ԣ�
        $insert_sql .= "    charger2,";                                         // ��ô���ԣ�
        $insert_sql .= "    charger3,";                                         // ��ô���ԣ�
        $insert_sql .= "    charger_part1,";                                    // ��ô��������
        $insert_sql .= "    charger_part2,";                                    // ��ô��������
        $insert_sql .= "    charger_part3,";                                    // ��ô��������
        $insert_sql .= "    charger_represe1,";                                 // ��ô��������
        $insert_sql .= "    charger_represe2,";                                 // ��ô��������
        $insert_sql .= "    charger_represe3,";                                 // ��ô��������
        $insert_sql .= "    charger_note,";                                     // ��ô��������

        $insert_sql .= "    trade_stime1,";                                     // �ĶȻ��֡ʸ������ϡ�
        $insert_sql .= "    trade_etime1,";                                     // �ĶȻ��֡ʸ�����λ��
        $insert_sql .= "    trade_stime2,";                                     // �ĶȻ��֡ʸ�峫�ϡ�
        $insert_sql .= "    trade_etime2,";                                     // �ĶȻ��֡ʸ�彪λ��
        $insert_sql .= "    sbtype_id,";                                        // �ȼ�ID
        $insert_sql .= "    holiday,";                                          // ����
        $insert_sql .= "    close_day,";                                        // ����
        $insert_sql .= "    trade_id,";                                          // �����ʬ
        $insert_sql .= "    pay_m,";                                            // �������ʷ��
        $insert_sql .= "    pay_d,";                                            // ������������
        $insert_sql .= "    pay_way,";                                          // ������ˡ
        $insert_sql .= "    account_name,";                                     // ����̾��
        $insert_sql .= "    pay_name,";                                         // ����̾��
//        $insert_sql .= "    b_bank_id,";                                        // ���ID
        $insert_sql .= "    account_id,";                                       //�����ֹ�ID
        $insert_sql .= "    slip_out,";                                         // ��ɼ����
        $insert_sql .= "    deliver_note,";                                     // Ǽ�ʽ񥳥���
        $insert_sql .= "    claim_out,";                                        // ��������
        $insert_sql .= "    coax,";                                             // ��ۡ��ݤ��ʬ
        $insert_sql .= "    tax_div,";                                          // �����ǡ�����ñ��
        $insert_sql .= "    tax_franct,";                                       // �����ǡ�ü����ʬ
        $insert_sql .= "    cont_sday,";                                        // ���󳫻���
        $insert_sql .= "    cont_eday,";                                        // ����λ��
        $insert_sql .= "    cont_peri,";                                        // �������
        $insert_sql .= "    cont_rday,";                                        // ���󹹿���
        $insert_sql .= "    col_terms,";                                        // ������
        $insert_sql .= "    credit_limit,";                                     // Ϳ������
        $insert_sql .= "    capital,";                                          // ���ܶ�
        $insert_sql .= "    note,";                                             // ����������/����¾
        $insert_sql .= "    client_div,";                                       // �������ʬ
/*
        // ������������ΨȽ��
        if($price_check == 1){
            $insert_sql .= "    intro_ac_price,";                               // ������
        }else if($rate_check == 1){
            $insert_sql .= "    intro_ac_rate,";                                // ����Ψ
        }
*/
        $insert_sql .= "    email,";                                            // Email
        $insert_sql .= "    url,";                                              // URL
        $insert_sql .= "    rep_htel,";                                         // ��ɽ�Է���
        $insert_sql .= "    direct_tel,";                                       // ľ��TEL
        $insert_sql .= "    b_struct,";                                         // ����
        $insert_sql .= "    inst_id,";                                          // ����
        $insert_sql .= "    establish_day,";                                    // �϶���
        $insert_sql .= "    deal_history,";                                     // �������
        $insert_sql .= "    importance,";                                       // ���׻���
        $insert_sql .= "    intro_ac_name,";                                    // �����������̾
        $insert_sql .= "    intro_bank,";                                       // ���/��Ź̾
        $insert_sql .= "    intro_ac_num,";                                     // �����ֹ�
        $insert_sql .= "    round_day,";                                        // ��󳫻���
        $insert_sql .= "    deliver_effect,";                                   // Ǽ�ʽ񥳥���(����)
        $insert_sql .= "    claim_send,";                                       // ���������
        $insert_sql .= "    client_cread,";                                     // ά��(�եꥬ��)
        $insert_sql .= "    represe,";                                          // ��ɽ����
        $insert_sql .= "    shop_name,";
        $insert_sql .= "    shop_div,";
        $insert_sql .= "    royalty_rate,";
        #2009-12-25 aoyama-n
        #$insert_sql .= "    tax_rate_n,";
        $insert_sql .= "    company_name,";                                     // �Ʋ��̾
        $insert_sql .= "    company_tel,";                                      // �Ʋ��TEL
        $insert_sql .= "    company_address,";                                  // �Ʋ�ҽ���
        $insert_sql .= "    bank_div,";                                         // ��Լ������ô��ʬ
        $insert_sql .= "    claim_note,";                                       // ����񥳥���
        $insert_sql .= "    client_slip1,";                                     // �����裱��ɼ����
        $insert_sql .= "    client_slip2,";                                     // �����裲��ɼ����
        $insert_sql .= "    parent_establish_day,";                             // �Ʋ���϶���
        $insert_sql .= "    parent_rep_name,";
//        $insert_sql .= "    type,";                                             // ����
        $insert_sql .= "    compellation,";                                     // �ɾ�
        // $insert_sql .= "    claim_scope";                                    // �����ϰ�
		//$insert_sql .= "    intro_ac_div, ";                                    // ���¶�ʬ
        $insert_sql .= "    s_pattern_id, ";                                    //�����ɼȯ�ԥѥ�����
        $insert_sql .= "    c_pattern_id, ";                                    //�����ȯ�ԥѥ�����
        $insert_sql .= "    c_tax_div,";                                         //���Ƕ�ʬi
        $insert_sql .= "    charge_branch_id,";                                         //ô����Ź
        $insert_sql .= ($client_gr_id != null)? " client_gr_id, " : null;                                     //���롼��ID
        $insert_sql .= "    parents_flg, ";                                     //�ƻҥե饰
        #2010-04-30 hashimoto-y
        $insert_sql .= "    bill_address_font ";                                //�������ե����
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd1',";                                    // �����襳����
        $insert_sql .= "    '$client_cd2',";                                    // ��Ź������
        // $insert_sql .= "    $shop_gid,";                                       // FC���롼��ID
        $insert_sql .= "    $shop_id,";                                         // FCID
        $insert_sql .= "    NOW(),";                                            // ������
        $insert_sql .= "    '$state',";                                         // ����
        $insert_sql .= "    '$client_name',";                                   // ������̾
        $insert_sql .= "    '$client_read',";                                   // ������ʥեꥬ�ʡ�
        $insert_sql .= "    '$client_name2',";                                  // ������̾2
        $insert_sql .= "    '$client_read2',";                                  // ������2�ʥեꥬ�ʡ�
        $insert_sql .= "    '$client_cname',";                                  // ά��
        $insert_sql .= "    '$post_no1',";                                      // ͹���ֹ棱
        $insert_sql .= "    '$post_no2',";                                      // ͹���ֹ棲
        $insert_sql .= "    '$address1',";                                      // ���꣱
        $insert_sql .= "    '$address2',";                                      // ���ꣲ
        $insert_sql .= "    '$address3',";                                      // ���ꣳ
        $insert_sql .= "    '$address_read',";                                  // ����ʥեꥬ�ʡ�
        $insert_sql .= "    $area_id,";                                         // �϶�ID
        $insert_sql .= "    '$tel',";                                           // TEL
        $insert_sql .= "    '$fax',";                                           // FAX
        $insert_sql .= "    '$rep_name',";                                      // ��ɽ�Ի�̾
        $insert_sql .= ($c_staff_id1 == "") ? " null, " : "$c_staff_id1, ";     // ����ô����
        $insert_sql .= ($c_staff_id2 == "") ? " null, " : "$c_staff_id2, ";     // ����ô����
        $insert_sql .= "    '$charger1',";                                      // ��ô���ԣ�
        $insert_sql .= "    '$charger2',";                                      // ��ô���ԣ�
        $insert_sql .= "    '$charger3',";                                      // ��ô���ԣ�
        $insert_sql .= "    '$charger_part1',";                                 // ��ô��������
        $insert_sql .= "    '$charger_part2',";                                 // ��ô��������
        $insert_sql .= "    '$charger_part3',";                                 // ��ô��������
        $insert_sql .= "    '$charger_represe1',";                              // ��ô�����򿦣�
        $insert_sql .= "    '$charger_represe2',";                              // ��ô�����򿦣�
        $insert_sql .= "    '$charger_represe3',";                              // ��ô�����򿦣�
        $insert_sql .= "    '$charger_note',";                                  // ��ô��������
        $insert_sql .= ($trade_stime1 == ":") ? " null, " : " '$trade_stime1', ";   // �ĶȻ��֡ʸ������ϡ�
        $insert_sql .= ($trade_etime1 == ":") ? " null, " : " '$trade_etime1', ";   // �ĶȻ��֡ʸ�����λ��
        $insert_sql .= ($trade_stime2 == ":") ? " null, " : " '$trade_stime2', ";   // �ĶȻ��֡ʸ�峫�ϡ�
        $insert_sql .= ($trade_etime2 == ":") ? " null, " : " '$trade_etime2', ";   // �ĶȻ��֡ʸ�彪λ��
        $insert_sql .= ($btype == "") ? " null, " : " $btype, ";                // �ȼ�ID
        $insert_sql .= "    '$holiday',";                                       // ����
        $insert_sql .= "    '$close_day_cd',";                                  // ����
        $insert_sql .= "    '$trade_id',";                                      // �����ʬ
        $insert_sql .= ($pay_m == "") ? " null, " : " $pay_m, ";                // �������ʷ��
        $insert_sql .= ($pay_d == "") ? " null, " : " $pay_d, ";                // ������������
        $insert_sql .= "    '$pay_way',";                                       // ��ʧ����ˡ
        $insert_sql .= "    '$account_name',";                                  // ����̾��
        $insert_sql .= "    '$pay_name',";                                      // ����̾��
        $insert_sql .= ($bank_enter_cd == "") ? " null, " : " $bank_enter_cd, ";// ���
        $insert_sql .= "    '$slip_out',";                                      // ��ɼ����
        $insert_sql .= "    '$deliver_note',";                                  // Ǽ�ʽ񥳥���
        $insert_sql .= "    '$claim_out',";                                     // ��������
        $insert_sql .= "    '$coax',";                                          // ��ۡ��ݤ��ʬ
        $insert_sql .= "    '$tax_div',";                                       // �����ǡ�����ñ��
        $insert_sql .= "    '$tax_franct',";                                    // �����ǡ�ü��ñ��
        $insert_sql .= ($cont_s_day == "--") ? " null, " : " '$cont_s_day', ";  // ���󳫻���
        $insert_sql .= ($cont_e_day == "--") ? " null, " : " '$cont_e_day', ";  // ����λ��
        $insert_sql .= ($cont_peri == "") ? " null, " : " '$cont_peri', ";      // �������
        $insert_sql .= ($cont_r_day == "--") ? " null, " : " '$cont_r_day', ";  // ���󹹿���
        $insert_sql .= "    '$col_terms',";                                     // ������
        $insert_sql .= "    '$cledit_limit',";                                  // Ϳ������
        $insert_sql .= "    '$capital',";                                       // ���ܶ�
        $insert_sql .= "    '$note',";                                          // ����������/����¾
        $insert_sql .= "    '1',";                                              // �������ʬ
/*
        // ������������ΨȽ��
        if($price_check == 1 && $account_price != NULL){
            $insert_sql .= "    $account_price,";                               // ������
        }else if($rate_check == 1 && $account_rate != NULL){
            $insert_sql .= "    $account_rate,";                                // ������(Ψ)
        }
*/
        $insert_sql .= "    '$email',";                                         // Email
        $insert_sql .= "    '$url',";                                           // URL
        $insert_sql .= "    '$represent_cell',";                                // ��ɽ�Է���
        $insert_sql .= "    '$direct_tel',";                                    // ľ��TEL
        $insert_sql .= ($bstruct == "") ? " null, " : " '$bstruct', ";          // ����
        $insert_sql .= ($inst == "") ? " null, " : " $inst, ";                  // ����
        $insert_sql .= ($establish_day == "--") ? " null, " : " '$establish_day', ";    // �϶���
        $insert_sql .= "    '$record',";                                        // �������
        $insert_sql .= "    '$important',";                                     // ���׻���
        $insert_sql .= "    '$trans_account',";                                 // �����������̾
        $insert_sql .= "    '$bank_fc',";                                       // ���/��Ź̾
        $insert_sql .= "    '$account_num',";                                   // �����ֹ�
        $insert_sql .= ($round_start == "--") ? " null, " : " '$round_start', ";// ��󳫻���
        $insert_sql .= "    '$deliver_radio',";                                 // Ǽ�ʽ񥳥���(����
        $insert_sql .= "    '$claim_send',";                                    // ���������
        $insert_sql .= "    '$cname_read',";                                    // ά��(�եꥬ��)
        $insert_sql .= "    '$represe',";                                       // ��ɽ����
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        #2009-12-25 aoyama-n
        #$insert_sql .= "    (SELECT tax_rate_n FROM t_client WHERE client_div = '0'), ";    // ������Ψ(����)
        $insert_sql .= "    '$company_name',";                                  // �Ʋ��̾
        $insert_sql .= "    '$company_tel',";                                   // �Ʋ��TEL
        $insert_sql .= "    '$company_address',";                               // �Ʋ�ҽ���
        $insert_sql .= "    '$bank_div',";
        $insert_sql .= "    '$claim_note',";
        $insert_sql .= "    '$client_slip1',";
        $insert_sql .= "    '$client_slip2',";
        $insert_sql .= ($parent_establish_day != '--') ? " '$parent_establish_day', " : " null, ";  // �Ʋ���϶���
        $insert_sql .= "    '$parent_rep_name',";                               // �Ʋ����ɽ��̾
//        $insert_sql .= "    '$type',";
        $insert_sql .= "    '$compellation',";                                   // �Ʋ����ɽ��̾
        // $insert_sql .= "    '$claim_scope'";
/*
		//���¶�ʬȽ��
		if($price_check == 1 && $account_price != NULL){
			//������
			$insert_sql .= "    '1',";                                   
		}else if($rate_check == 1 && $account_rate != NULL){
			//�����
			$insert_sql .= "    '2',";                                   
		}else{
			//�ʤ�
			$insert_sql .= "    '',";                                   
		}
*/
        $insert_sql .= "    $s_pattern_id,";
        $insert_sql .= "    $c_pattern_id,";
        $insert_sql .= "    $c_tax_div,";
        $insert_sql .= "    $charge_branch_id,";
        $insert_sql .= ($client_gr_id != null)? " $client_gr_id, ": null ;
        $insert_sql .= "    $parents_flg, \n";
        #2010-04-30 hashimoto-y
        $insert_sql .= "    '$bill_address_font' \n";
        $insert_sql .= ");";

        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //��Ͽ�����������������ID�����
        $sql  = "SELECT";
        $sql .= "   client_id ";
        $sql .= "FROM";
        $sql .= "   t_client ";
        $sql .= "WHERE";
        $sql .= "   client_div = '1'";
        $sql .= "   AND";
        $sql .= "   shop_id = $shop_id";
        $sql .= "   AND";
        $sql .= "   client_cd1 = '$client_cd1'";
        $sql .= "   AND";
        $sql .= "   client_cd2 = '$client_cd2'";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $client_id = pg_fetch_result($result, 0,0);

        // ��������
        $sql  = "INSERT INTO t_claim(";
        $sql .= "   client_id,";
        $sql .= "   claim_id,";
        $sql .= "   claim_div, ";
        $sql .= "   month1_flg,";
        $sql .= "   month2_flg,";
        $sql .= "   month3_flg,";
        $sql .= "   month4_flg,";
        $sql .= "   month5_flg,";
        $sql .= "   month6_flg,";
        $sql .= "   month7_flg,";
        $sql .= "   month8_flg,";
        $sql .= "   month9_flg,";
        $sql .= "   month10_flg,";
        $sql .= "   month11_flg,";
        $sql .= "   month12_flg ";
        $sql .= ")VALUES(";
        $sql .= "   $client_id,";
        // �������裱���ϻ�
        if($claim_flg == true){
            $sql .= "   (SELECT";
            $sql .= "       client_id";
            $sql .= "   FROM";
            $sql .= "       t_client";
            $sql .= "   WHERE";
            $sql .= "       client_div = '1'";
            $sql .= "       AND";
            //$sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : " shop_id = '$claim_cd1'";
            $sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
            $sql .= "       AND";
            $sql .= "       client_cd1 = '$claim_cd1'";
            $sql .= "       AND";
            $sql .= "       client_cd2 = '$claim_cd2'";
            $sql .= "   ),";
        // �������裱̤���ϻ�
        }else{
            $sql .= "   $client_id,";
        }
        $sql .= "   '1', ";
        $sql .= ($claim1_monthly_check[0]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[1]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[2]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[3]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[4]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[5]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[6]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[7]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[8]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[9]  == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[10] == '1')?  " 't'," : " 'f',";
        $sql .= ($claim1_monthly_check[11] == '1')?  " 't' " : " 'f' ";

        $sql .= ");";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //�����裲
        if($claim2_flg == true){
            $sql  = "INSERT INTO t_claim (\n";
            $sql .= "   client_id,\n";
            $sql .= "   claim_id,\n";
            $sql .= "   claim_div \n";
            $sql .= ")VALUES(\n";
            $sql .= "   $client_id,\n";
            $sql .= "   (SELECT\n";
            $sql .= "       client_id\n";
            $sql .= "   FROM\n";
            $sql .= "       t_client";
            $sql .= "   WHERE";
            $sql .= "       client_cd1 = '$claim2_cd1'";
            $sql .= "       AND";
            $sql .= "       client_cd2 = '$claim2_cd2'";
            $sql .= "       AND";
            $sql .= "       client_div = '1'";
            $sql .= "       AND";
            $sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : "  shop_id = $shop_id";
            $sql .= "   ),";
            $sql .= "   '2' ";
            $sql .= ");";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
        }
        
        //�����������ơ��֥����Ͽ
        $insert_sql  = " INSERT INTO t_client_info (";
        $insert_sql .= "    client_id,";
        $insert_sql .= "    intro_account_id,";
        $insert_sql .= "    cclient_shop";
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    $client_id,";

        //�Ҳ������ʻ�����ξ���
        if($intro_act_div == '2' || $intro_act_div == null){
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        client_cd1 = '$intro_act_cd'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '2'";
            $insert_sql .= "        AND";
            $insert_sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : "  shop_id = $shop_id";
            $insert_sql .= "    ),";
        //�Ҳ�������FC�ξ���
        }else{
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        client_cd1 = '$intro_act_cd'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$intro_act_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '3'";
            $insert_sql .= "        AND";
            $insert_sql .= "        shop_id = 1";
            $insert_sql .= "    ),";
        }
        $insert_sql .= "    $_SESSION[client_id]";
        $insert_sql .= ");";

        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        // ��Ͽ�����������˻Ĥ�
        $result = Log_Save( $conn, "client", "1", $client_cd1."-".$client_cd2, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

    /******************************/
    // ��������
    /******************************/
    }else if($new_flg == false){
        // ��������Ͽ����������ID�����
        // �����褬���Ϥ��줿���
        if($claim_name != null){
            $sql  = "SELECT";
            $sql .= "   client_id";
            $sql .= " FROM";
            $sql .= "   t_client";
            $sql .= " WHERE";
            $sql .= "   client_div = '1'";
            $sql .= "   AND";
            $sql .= "   client_cd1 = '$claim_cd1'";
            $sql .= "   AND";
            $sql .= "   client_cd2 = '$claim_cd2'";
            $sql .= "   AND";
            // $sql .= "   shop_gid = $shop_gid";
            $sql .= ($group_kind == 2) ? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $claim_id = pg_fetch_result($result, 0,0 );
        }else{
            $claim_id = $get_client_id;
        }

        //������̾��
        if($claim2_name != Null){
            $sql  = "SELECT";
            $sql .= "   client_id ";
            $sql .= "FROM";
            $sql .= "   t_client ";
            $sql .= "WHERE";
            $sql .= "   client_div = '1'";
            $sql .= "   AND";
            $sql .= "   client_cd1 = '$claim2_cd1'";
            $sql .= "   AND";
            $sql .= "   client_cd2 = '$claim2_cd2'";
            $sql .= "   AND";
            $sql .= ($group_kind == 2) ? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $claim2_id = pg_fetch_result($result, 0,0);
        }else{
            $claim2_id = null;
        }

        // ������ޥ���
        Db_Query($conn, "BEGIN;");

        //�ѹ����δݤ��ʬ�����
        $tax_div_ary = Get_Tax_div($conn,$_GET["client_id"]);
        $coax_before = $tax_div_ary[coax];

        $update_sql = "UPDATE";
        $update_sql .= "    t_client";
        $update_sql .= " SET";
        $update_sql .= "    client_cd1 = '$client_cd1',";
        $update_sql .= "    client_cd2 = '$client_cd2',";
        $update_sql .= "    state = '$state',";
        $update_sql .= "    client_name = '$client_name',";
        $update_sql .= "    client_read = '$client_read',";
        $update_sql .= "    client_name2 = '$client_name2',";
        $update_sql .= "    client_read2 = '$client_read2',";
        $update_sql .= "    client_cname = '$client_cname',";
        $update_sql .= "    post_no1 = '$post_no1',";
        $update_sql .= "    post_no2 = '$post_no2',";
        $update_sql .= "    address1 = '$address1',";
        $update_sql .= "    address2 = '$address2',";
        $update_sql .= "    address3 = '$address3',";
        $update_sql .= "    address_read = '$address_read',";
        $update_sql .= "    area_id = $area_id,";
        $update_sql .= "    tel = '$tel',";
        $update_sql .= "    fax = '$fax',";
        $update_sql .= "    rep_name = '$rep_name',";
        $update_sql .= "    charger1 = '$charger1',";
        $update_sql .= "    charger2 = '$charger2',";
        $update_sql .= "    charger3 = '$charger3',";
        $update_sql .= "    charger_part1 = '$charger_part1',";
        $update_sql .= "    charger_part2 = '$charger_part2',";
        $update_sql .= "    charger_part3 = '$charger_part3',";
        $update_sql .= "    charger_represe1 = '$charger_represe1',";
        $update_sql .= "    charger_represe2 = '$charger_represe2',";
        $update_sql .= "    charger_represe3 = '$charger_represe3',";
        $update_sql .= "    charger_note = '$charger_note',";

        $update_sql .= ($trade_stime1 == ":") ? " trade_stime1 = null, " : " trade_stime1 = '$trade_stime1', ";        
        $update_sql .= ($trade_etime1 == ":") ? " trade_etime1 = null, " : " trade_etime1 = '$trade_etime1', ";
        $update_sql .= ($trade_stime2 == ":") ? " trade_stime2 = null, " : " trade_stime2 = '$trade_stime2', ";
        $update_sql .= ($trade_etime2 == ":") ? " trade_etime2 = null, " : " trade_etime2 = '$trade_etime2', ";
        $update_sql .= "    holiday = '$holiday',";
        $update_sql .= ($btype == "") ? " sbtype_id = null, " : " sbtype_id = $btype, ";
/*
        if($price_check == 1 && $account_price != NULL){
            $update_sql .= "        intro_ac_price = $account_price,";
            $update_sql .= "        intro_ac_rate = null,";
        }else if($rate_check == 1 && $account_rate != NULL){
            $update_sql .= "        intro_ac_rate = $account_rate,";
            $update_sql .= "        intro_ac_price = null,";
        }else{
            $update_sql .= "        intro_ac_price = null,";
            $update_sql .= "        intro_ac_rate = null,";
        }
*/
        $c_staff_id1 = ($c_staff_id1 == "") ? null : $c_staff_id1;
        $c_staff_id2 = ($c_staff_id2 == "") ? null : $c_staff_id2;
        $update_sql .= ($c_staff_id1 == "") ? " c_staff_id1 = null, " : " c_staff_id1 = $c_staff_id1, ";
        $update_sql .= ($c_staff_id2 == "") ? " c_staff_id2 = null, " : " c_staff_id2 = $c_staff_id2, ";
        $update_sql .= "    col_terms       = '$col_terms',";
        $update_sql .= "    credit_limit    = '$cledit_limit',";
        $update_sql .= "    capital         = '$capital',";
        $update_sql .= "    trade_id        = '$trade_id',";
        $update_sql .= "    close_day       = '$close_day_cd',";
        $update_sql .= ($pay_m == "") ? " pay_m = '', " : " pay_m = '$pay_m', ";
        $update_sql .= ($pay_d == "") ? " pay_d = '', " : " pay_d = '$pay_d', ";
        $update_sql .= "    pay_way         = '$pay_way',";
        $update_sql .= ($bank_enter_cd == "") ? " account_id = null, " : " account_id = $bank_enter_cd, ";
        $update_sql .= "    pay_name = '$pay_name',";
        $update_sql .= "    account_name = '$account_name',";
        $update_sql .= ($cont_s_day == "--") ? " cont_sday = null, " : " cont_sday = '$cont_s_day', ";
        $update_sql .= ($cont_e_day == "--") ? " cont_eday = null, " : " cont_eday = '$cont_e_day', ";
        $update_sql .= ($cont_peri == "") ? " cont_peri = null, " : " cont_peri = '$cont_peri', ";
        $update_sql .= ($cont_r_day == "--") ? " cont_rday = null, " : " cont_rday = '$cont_r_day', ";
        $update_sql .= "    slip_out        = '$slip_out',";
        $update_sql .= "    deliver_note    = '$deliver_note',";
        $update_sql .= "    claim_out       = '$claim_out',";
        $update_sql .= "    coax            = '$coax',";
        $update_sql .= "    tax_div         = '$tax_div',";
        $update_sql .= "    tax_franct      = '$tax_franct',";
        $update_sql .= "    note            = '$note',";
        $update_sql .= "    email           = '$email',";
        $update_sql .= "    url             = '$url',";
        $update_sql .= "    rep_htel        = '$represent_cell',";
        $update_sql .= "    direct_tel      = '$direct_tel',";
        $update_sql .= ($bstruct == "") ? " b_struct = null, " : " b_struct = $bstruct, ";
        $update_sql .= ($inst == "") ? " inst_id = null, " : " inst_id = $inst, ";
        $update_sql .= ($establish_day == "--") ? " establish_day = null, " : " establish_day = '$establish_day', ";
        $update_sql .= "    deal_history    = '$record',";
        $update_sql .= "    importance      = '$important',";
        $update_sql .= "    intro_ac_name   = '$trans_account',";
        $update_sql .= "    intro_bank      = '$bank_fc',";
        $update_sql .= "    intro_ac_num    = '$account_num',";
        $update_sql .= ($round_start == "--") ? " round_day = null, " : " round_day = '$round_start', ";
        $update_sql .= "    deliver_effect  = '$deliver_radio',";
        $update_sql .= "    claim_send      = '$claim_send',";
        $update_sql .= "    client_cread    = '$cname_read', ";
        $update_sql .= "    represe         = '$represe',";
        $update_sql .= "    company_name    = '$company_name',";
        $update_sql .= "    company_tel     = '$company_tel',";
        $update_sql .= "    company_address = '$company_address',";
        $update_sql .= "    bank_div        = '$bank_div',";
        $update_sql .= "    claim_note      = '$claim_note',";
        $update_sql .= "    client_slip1    = '$client_slip1',";
        $update_sql .= "    client_slip2    = '$client_slip2',";
        $update_sql .= ($parent_establish_day != '--') ? " parent_establish_day = '$parent_establish_day', " : " parent_establish_day = null, ";
        $update_sql .= "    parent_rep_name = '$parent_rep_name',";
//        $update_sql .= "    type            = '$type',";
        $update_sql .= "    compellation    = '$compellation',";
        // $update_sql .= "    claim_scope = '$claim_scope'";

		/*
		//���¶�ʬȽ��
		if($price_check == 1 && $account_price != NULL){
			//������
			$update_sql .= "    intro_ac_div = '1', ";                                   
		}else if($rate_check == 1 && $account_rate != NULL){
			//�����
			$update_sql .= "    intro_ac_div = '2', ";                                   
		}else{
			//�ʤ�
			$update_sql .= "    intro_ac_div = '', ";                                   
		}
		*/

        $update_sql .= "    s_pattern_id    = $s_pattern_id,";
        $update_sql .= "    c_pattern_id    = $c_pattern_id,";
        $update_sql .= "    c_tax_div       = $c_tax_div,";
        $update_sql .= "    charge_branch_id = $charge_branch_id,";
		if($client_gr_id != null){
			$update_sql .= "    client_gr_id    = $client_gr_id,";
		}else{
			$update_sql .= "    client_gr_id    = NULL,";
		}
        $update_sql .= "    parents_flg     = $parents_flg,";
        #2010-04-30 hashimoto-y
        $update_sql .= "    bill_address_font   = '$bill_address_font' ";

        $update_sql .= " WHERE";
        $update_sql .= "    client_id       = $_GET[client_id]";
        $update_sql .= ";";

        $result = Db_Query($conn, $update_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //�Ƥξ��ϻҤΥǡ��������ƥ��åץǡ���
        if($change_flg == true){
            Child_Update($_GET["client_id"], $close_day_cd, $pay_m, $pay_d, $coax, $tax_div, $tax_franct, $c_tax_div, $claim_out, $conn, $claim1_monthly_check);
        }



        //������1
        $sql  = "UPDATE ";
        $sql .= "   t_claim ";
        $sql .= "SET ";
        $sql .= "    claim_id = $claim_id, ";

        $sql .= ($claim1_monthly_check[0]  == '1')? " month1_flg  = 't', " : " month1_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[1]  == '1')? " month2_flg  = 't', " : " month2_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[2]  == '1')? " month3_flg  = 't', " : " month3_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[3]  == '1')? " month4_flg  = 't', " : " month4_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[4]  == '1')? " month5_flg  = 't', " : " month5_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[5]  == '1')? " month6_flg  = 't', " : " month6_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[6]  == '1')? " month7_flg  = 't', " : " month7_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[7]  == '1')? " month8_flg  = 't', " : " month8_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[8]  == '1')? " month9_flg  = 't', " : " month9_flg  = 'f', ";
        $sql .= ($claim1_monthly_check[9]  == '1')? " month10_flg = 't', " : " month10_flg = 'f', ";
        $sql .= ($claim1_monthly_check[10] == '1')? " month11_flg = 't', " : " month11_flg = 'f', ";
        $sql .= ($claim1_monthly_check[11] == '1')? " month12_flg = 't'  " : " month12_flg = 'f'  ";
        $sql .= "WHERE";
        $sql .= "    client_id = $get_client_id";
        $sql .= "    AND";
        $sql .= "    claim_div = '1'";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        // ��������ơ��֥�
        //��Ͽ���ξȲ������
        $sql  = "SELECT";
        $sql .= "   intro_account_id ";
        $sql .= "FROM ";
        $sql .= "   t_client_info ";
        $sql .= "WHERE ";
        $sql .= "   client_id = $get_client_id ";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $intro_array["def_intro_act_id"] = pg_fetch_result($result, 0,0);

        $sql  = "UPDATE t_client_info SET";

        if($intro_act_div == '2' || $intro_act_div == null){
            $sql .= "   intro_account_id = (SELECT";
            $sql .= "                           client_id";
            $sql .= "                       FROM";
            $sql .= "                           t_client";
            $sql .= "                       WHERE";
            $sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
            $sql .= "                           AND";
            $sql .= "                           client_cd1 = '$intro_act_cd'";
            $sql .= "                           AND";
            $sql .= "                           client_div = '2'";
            $sql .= "                       ),";
        }else{
            $sql .= "   intro_account_id = (SELECT";
            $sql .= "                           client_id";
            $sql .= "                       FROM";
            $sql .= "                           t_client";
            $sql .= "                       WHERE";
            $sql .= "                           shop_id = 1";
            $sql .= "                           AND";
            $sql .= "                           client_cd1 = '$intro_act_cd'";
            $sql .= "                           AND";
            $sql .= "                           client_cd2 = '$intro_act_cd2'";
            $sql .= "                           AND";
            $sql .= "                           client_div = '3'";
            $sql .= "                       ),";
        } 

        $sql .= "   cclient_shop = $_SESSION[client_id] ";
        $sql .= "WHERE";
        $sql .= "   client_id = $_GET[client_id]";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //�����裲�η��󤬤�����
        $check_con_flg = Check_Con_Claim2($conn, $_GET["client_id"]);

        //����ޥ����������裲���Ф�����󤬤�����
        if($check_con_flg === true){
            $sql  = "UPDATE";
            $sql .= "   t_claim ";
            $sql .= "SET ";
            $sql .= "   claim_id = $claim2_id";
            $sql .= "WHERE ";
            $sql .= "   client_id = $_GET[client_id]";
            $sql .= "   AND ";
            $sql .= "   claim_div = '2' ";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

        }else{
            //��������ơ��֥������裲
            //�����裲��ɬ�ܤǤϤʤ�������Ͽ��̵ͭ�ˤ�����餺���ǡ�������
            $sql = "DELETE FROM t_claim WHERE client_id = $get_client_id AND claim_div = '2';";

            $result = Db_Query($conn, $sql);        
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            if($claim2_flg == true){
                $sql  = "INSERT INTO t_claim (";
                $sql .= "   client_id,";
                $sql .= "   claim_id,";
                $sql .= "   claim_div ";
                $sql .= ")VALUES(";
                $sql .= "   $get_client_id,";
                $sql .= "   $claim2_id,";
                $sql .= "   '2' ";

                $sql .= ");";

                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
            }
        }

        if($client_div == '1'){
            // ��������ơ��֥�
            $update_sql  = " INSERT INTO t_renew (";
            $update_sql .= "    client_id,";                        // ������ID
            $update_sql .= "    staff_id,";                         // �����å�ID
            $update_sql .= "    renew_time";                        // ���ߤ�timestamp
            $update_sql .= " )VALUES(";
            $update_sql .= "    (SELECT";
            $update_sql .= "        client_id";
            $update_sql .= "    FROM";
            $update_sql .= "        t_client";
            $update_sql .= "    WHERE";
            // $update_sql .= "        shop_gid = $shop_gid";
            $update_sql .= "        shop_id = $shop_id";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd1 = '$client_cd1'";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd2 = '$client_cd2'";
            $update_sql .= "        AND";
            $update_sql .= "        client_div = '1'";
            $update_sql .= "    ),";
            $update_sql .= "    $staff_id,";
            $update_sql .= "    NOW()";
            $update_sql .= ");";
            
            $result = Db_Query($conn, $update_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
        }

		//�ݤ��ʬ���ѹ�������å���������ޥ����ζ�ۤ�Ʒ׻�����
		$update_con_mesg = Update_Con_Amount($conn, $_GET["client_id"], $coax_before);

        /****************************/
        //����������ɼ���Ф��������Ƥ�ȿ�Ǥ�����
        /****************************/
        //�Ҳ������ID�ȾҲ����̾�����
        if($intro_act_div == '2'){
            $sql  = "SELECT";
            $sql .= "   client_id, ";
            $sql .= "   client_cd1,";
            $sql .= "   client_cname ";
            $sql .= "FROM";
            $sql .= "   t_client ";
            $sql .= "WHERE";
            $sql .= ($group_kind == '2')? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
            $sql .= "   AND";
            $sql .= "   client_cd1 = '$intro_act_cd'";
            $sql .= "   AND";
            $sql .= "   client_div = '2'";
            $sql .= ";";
        }else{
            $sql  = "SELECT";
            $sql .= "   client_id, ";
            $sql .= "   client_cd1, ";
            $sql .= "   client_cd2, ";
            $sql .= "   client_cname ";
            $sql .= "FROM";
            $sql .= "   t_client ";
            $sql .= "WHERE";
            $sql .= "   shop_id = 1 ";
            $sql .= "   AND";
            $sql .= "   client_cd1 = '$intro_act_cd'";
            $sql .= "   AND";
            $sql .= "   client_cd2 = '$intro_act_cd2'";
            $sql .= "   AND";
            $sql .= "   client_div = '3'";
            $sql .= ";";
        }

        $result = Db_Query($conn, $sql);
        $intro_data_num = pg_num_rows($result);
        //�Ҳ�����褬���򤵤�Ƥ������
        if($intro_data_num > 0){
            $intro_array = pg_fetch_array($result);
        }

        $aord_param = array(
                        "client_id"    => $get_client_id,
                        "client_cd1"   => $client_cd1,
                        "client_cd2"   => $client_cd2,
                        "client_cname" => $client_cname,
                        "client_name"  => $client_name,
                        "client_name2" => $client_name2,
                        "trade_id"     => $trade_id,
                        "slip_out"     => $slip_out,
                    );

        Aord_Update($aord_param, $intro_array, $conn);
		Update_Aord_Trade($conn, $get_client_id); //������μ�����ɼ����ݤ��ѹ�
/*
        //�����裱
        $sql    =  Aord_Update($aord_pram, '1', $intro_array);
        $result =  Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //�����裲
        $sql    =  Aord_Update($aord_pram, '2', $intro_array);
        $result =  Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
*/
        // �ѹ������������˻Ĥ�
        $result = Log_Save( $conn, "client", "2", $client_cd1."-".$client_cd2, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
    }

    Db_Query($conn, "COMMIT;");
    $complete_flg = true;

    // ��������ܤ��������Ͽ���������ID���Ϥ��١�����
    $sql  = "SELECT ";
    $sql .= "    client_id ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    // $sql .= "    shop_gid = $shop_gid";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
    $sql .= "    AND";
    $sql .= "    client_cd1 = '$client_cd1'";
    $sql .= "    AND";
    $sql .= "    client_cd2 = '$client_cd2'";
    $sql .= "    AND";
    $sql .= "    client_div = '1';";
    $result = Db_Query($conn, $sql);
    $con_client_id = pg_fetch_result($result, 0,0);
}

($_POST["ok_button_flg"] == true) ? header("Location: ./2-1-103.php") : null;

// �ܥ���
// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:location='2-1-101.php'\"");

// ��Ͽ(�إå�)
$form->addElement("button", "new_button", "��Ͽ����", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// DB����Ͽ��Υե���������
if($complete_flg == true){

    // ���ܥ����������ID����
    // ������Ͽ��
    if ($get_client_id == null){
        $sql    = "SELECT MAX(client_id) FROM t_client WHERE shop_id = $shop_id AND client_div = '1';\n";
        $res    = Db_Query($conn, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    // �ѹ���
    }else{
        $get_id = $get_client_id;
    }

    $form->addElement("static", "intro_claim_link", "", "������1");
    $form->addElement("static", "intro_claim_link2", "", "������2");
    $form->addElement("static", "intro_act_link", "", "���Ҳ����");
    $button[] = $form->createElement("button", "back_button", "�ᡡ��", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."?client_id=$get_id'\"");
    // �ϣ�
    $button[] = $form->addElement("button", "ok_button", "��Ͽ��λ", "onClick=\"javascript:Button_Submit_1('ok_button_flg', '#', 'true')\"");

    // ������Ͽ
    $button[] = $form->addElement("button", "contract_button", "������Ͽ", "onClick=\"location.href='./2-1-115.php?client_id=$con_client_id'\"");

    $form->freeze();
}else{

    // ���Ȳ����Υ����å��ܥå����Υ����å�
    //$onload = "Check_Button2($check_which);";
    // DB����Ͽ���Υե���������
    if($change_flg == true){
        $form->addElement("static", "intro_claim_link", "", "������1");
        $form->addElement("static", "intro_claim_link2", "", "������2");
    }else{
        $form->addElement("link", "intro_claim_link", "", "#", "������1", "onClick=\"javascript:return Open_SubWin('../dialog/2-0-250.php',Array('form_claim[cd1]', 'form_claim[cd2]', 'form_claim[name]', 'form_pay_name', 'form_account_name'), 500, 450,4,2)\"");
        $form->addElement("link", "intro_claim_link2", "", "#", "������2", "onClick=\"javascript:return Open_SubWin('../dialog/2-0-250.php',Array('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]'), 500, 450,4,1)\"");
    }

    //ľ�Ĥξ��
    if($group_kind == '2'){
        $form->addElement("link", "intro_act_link", "", "#", "���Ҳ����", "onClick=\"javascript:return Open_SubWin_client('../dialog/2-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450)\"");
    }else{
        $form->addElement("link", "intro_act_link", "", "#", "���Ҳ����", "onClick=\"javascript:return Open_SubWin('../dialog/2-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450)\"");
    }

    // ��Ͽ�Ѱ�����ǧ
    $button[] = $form->createElement("button", "list_confirm_button", "��Ͽ�Ѱ�����ǧ", "style=width:110 onClick=\"javascript:return Open_mlessDialog('../dialog/2-0-250-1.php', '470', '500')\"");

    $button[] = $form->createElement("button", "input_button", "��ư����", "onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true')\""); 

    if($change_flg === true){
        //����������ɽ�������å�����
        $message  = "�ʲ��ι��ܤϻҤΥǡ����ˤ�ȿ�Ǥ���ޤ���\\n";
        $message .= "������\\n";
        $message .= "��������\\n";
        $message .= "�������ɼȯ��\\n";
        $message .= "�������ȯ��\\n";
        $message .= "���ݤ��ʬ\\n";
        $message .= "������ñ��\\n";
        $message .= "��ü����ʬ\\n";
        $message .= "�����Ƕ�ʬ\\n";
        $message .= "�������\\n";

        $button[] = $form->createElement("submit", "entry_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue('$message', '#', this)\" $disabled");
    }else{
        $button[] = $form->createElement("submit", "entry_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
    }
//    ($get_client_id != null) ? $button[] = $form->createElement("button", "res_button", "�¡���", "onClick=\"javascript:window.open('".FC_DIR."system/2-1-106.php?client_id=$_GET[client_id]', '_blank', 'width=480,height=600')\"") : null;

    // ������Ͽ���Ͻ��Ϥ��ʤ�
    if ($get_client_id != null){
        //$button[] = $form->createElement("button", "back_button", "�ᡡ��", "onClick='javascript:history.back()'");
        $button[] = $form->createElement("button", "back_button", "�ᡡ��", "onClick=\"location.href='./2-1-101.php'\"");
    }

}
// ���إܥ���
if($next_id != null){
    $form->addElement("button", "next_button", "������", "onClick=\"location.href='./2-1-103.php?client_id=$next_id'\"");
}else{
    $form->addElement("button", "next_button", "������", "disabled");
}
// ���إܥ���
if($back_id != null){
    $form->addElement("button", "back_button", "������", "onClick=\"location.href='./2-1-103.php?client_id=$back_id'\"");
}else{
    $form->addElement("button", "back_button", "������", "disabled");
}

$form->addGroup($button, "button", "");

/***************************/
//function
/***************************/
function Aord_Update($aord_param, $intro_act_array, $db_con){

    $aord_update_flg = Intro_Act_Update($intro_act_array,  $aord_param[client_id], $db_con);

    for($i = 1; $i < 3; $i++){
        $sql  = "UPDATE \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "SET \n";
        $sql .= "   client_cname     = '$aord_param[client_cname]',\n";
        $sql .= "   client_name      = '$aord_param[client_name]',\n";
        $sql .= "   client_name2     = '$aord_param[client_name2]',\n";
        $sql .= "   client_cd1       = '$aord_param[client_cd1]',\n";
        $sql .= "   client_cd2       = '$aord_param[client_cd2]',\n";
        $sql .= "   claim_id         = (SELECT";
        $sql .= "                           claim_id";
        $sql .= "                       FROM";
        $sql .= "                           t_claim";
        $sql .= "                       WHERE";
        $sql .= "                           client_id = $aord_param[client_id]";
        $sql .= "                           AND";
        $sql .= "                           claim_div = '$i'";
        $sql .= "                       ), \n";
        $sql .= "   trade_id         = $aord_param[trade_id], \n";
        $sql .= "   slip_out         = $aord_param[slip_out], \n";

        //�Ҳ�����衡ͭ���͡�̵
        if($aord_update_flg === true){
            $sql .= "   intro_ac_div = '1', ";
        }

        $sql .= "   intro_account_id = ";
        $sql .= ($intro_act_array[client_id] != null)? $intro_act_array[client_id]."," : "null,\n";
        $sql .= "   intro_ac_name    = '".addslashes($intro_act_array[client_cname])."', \n";
        $sql .= "   intro_ac_cd1     = '$intro_act_array[client_cd1]', \n";
        $sql .= "   intro_ac_cd2     = '$intro_act_array[client_cd2]' \n";
        $sql .= "WHERE \n";
        $sql .= "   client_id = $aord_param[client_id]";
        $sql .= "   AND\n";
//        $sql .= "   ord_no IS NULL";
        $sql .= "   ps_stat = '1'";
        $sql .= "   AND\n";
        $sql .= "   claim_div = '$i' \n";
/*
        $sql .= "   AND \n";
        $sql .= "   contract_div = '1' \n";
*/
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
    }
}

//����ޥ����ǾҲ��������ȯ�����ʤ��褦�ˤ���
function Intro_Act_Update($intro_act_array, $client_id,  $db_con){

    $aord_update_flg = false;

    //�Ҳ�����衡ͭ���͡�̵
    if($intro_act_array["def_intro_act_id"] != null && $intro_act_array["client_id"] == null){

        $sql  = "UPDATE";
        $sql .= "   t_contract ";
        $sql .= "SET ";
        $sql .= "   intro_ac_div = '1'";
        $sql .= "WHERE ";
        $sql .= "   client_id = $client_id ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }

        //����Ψ������ñ����null�򥻥å�
        $sql  = "UPDATE";
        $sql .= "   t_con_info ";
        $sql .= "SET ";
        $sql .= "   account_rate = null, ";
        $sql .= "   account_price = null ";
        $sql .= "WHERE ";
        $sql .= "   contract_id IN (";
        $sql .= "           SELECT ";
        $sql .= "               contract_id ";
        $sql .= "           FROM ";
        $sql .= "               t_contract ";
        $sql .= "           WHERE ";
        $sql .= "               client_id = $client_id ";
        $sql .= "           ) ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        //����إå����åץǡ��Ȼ��˻���
        $aord_update_flg = true;
    }

    return $aord_update_flg;
}

//�Ҥβ��Ƕ�ʬ��Ƥȹ�碌��
function Child_Update($client_id, $close_day, $pay_m, $pay_d, $coax, $tax_div, $tax_franct, $c_tax_div, $claim_out, $db_con, $claim1_monthly_check){

    $sql  = "UPDATE \n";
    $sql .= "   t_client \n";
    $sql .= "SET \n";
    $sql .= "   coax       = '$coax', \n";
    $sql .= "   tax_div    = '$tax_div', \n";
    $sql .= "   tax_franct = '$tax_franct', \n";
    $sql .= "   c_tax_div  = '$c_tax_div', \n";
    $sql .= "   pay_m      = '$pay_m', \n";
    $sql .= "   pay_d      = '$pay_d', \n";
    $sql .= "   close_day  = '$close_day', \n";
    $sql .= "   claim_out  = '$claim_out' \n";
    $sql .= "WHERE \n";
    $sql .= "   client_id IN (\n";
    $sql .= "       SELECT \n";
    $sql .= "           client_id \n";
    $sql .= "       FROM \n";
    $sql .= "           t_claim \n";
    $sql .= "       WHERE \n";
    $sql .= "           claim_div = '1' \n";
    $sql .= "           AND \n";
    $sql .= "           claim_id = $client_id \n";
    $sql .= "       ) \n";
    $sql .= ";\n";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    //������������碌��
    Child_bill_Make_Month ($claim1_monthly_check, $client_id, $db_con);

}


//�Ҥ�������Ƥȹ�碌��
function Child_bill_Make_Month ($bill_make_month, $claim_id, $db_con){

    $sql  = "UPDATE \n";
    $sql .= "   t_claim \n";
    $sql .= "SET \n";
    $sql .= ($bill_make_month[0]  == '1')? " month1_flg  = 't', " : " month1_flg  = 'f', ";
    $sql .= ($bill_make_month[1]  == '1')? " month2_flg  = 't', " : " month2_flg  = 'f', ";
    $sql .= ($bill_make_month[2]  == '1')? " month3_flg  = 't', " : " month3_flg  = 'f', ";
    $sql .= ($bill_make_month[3]  == '1')? " month4_flg  = 't', " : " month4_flg  = 'f', ";
    $sql .= ($bill_make_month[4]  == '1')? " month5_flg  = 't', " : " month5_flg  = 'f', ";
    $sql .= ($bill_make_month[5]  == '1')? " month6_flg  = 't', " : " month6_flg  = 'f', ";
    $sql .= ($bill_make_month[6]  == '1')? " month7_flg  = 't', " : " month7_flg  = 'f', ";
    $sql .= ($bill_make_month[7]  == '1')? " month8_flg  = 't', " : " month8_flg  = 'f', ";
    $sql .= ($bill_make_month[8]  == '1')? " month9_flg  = 't', " : " month9_flg  = 'f', ";
    $sql .= ($bill_make_month[9]  == '1')? " month10_flg = 't', " : " month10_flg = 'f', ";
    $sql .= ($bill_make_month[10] == '1')? " month11_flg = 't', " : " month11_flg = 'f', ";
    $sql .= ($bill_make_month[11] == '1')? " month12_flg = 't'  " : " month12_flg = 'f'  ";
    $sql .= "WHERE ";
    $sql .= "   claim_id = $claim_id ";
    $sql .= "   AND ";
    $sql .= "   claim_div = '1' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);

    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }
}


/**
 * ���ס��ƤȻҤ�������ID��������ޤ���
 *
 * ����
 *
 * @param object    $db_con      DB���ͥ������
 * @param integer   $client_id   ������ID
 *
 * @return array  ������ID
 *
 */

//���ƤȻҤ�������ID�����
function Get_Claim_Family($db_con, $client_id){
	$sql  = "  SELECT \n";
	$sql .= "      client_id \n";
	$sql .= "  FROM \n";
	$sql .= "      t_claim \n";
	$sql .= "  WHERE \n";
	$sql .= "      claim_div = '1' \n";
	$sql .= "      AND \n";
	//$sql .= "      claim_id = $client_id \n";
	$sql .= "      claim_id = (SELECT claim_id FROM t_claim WHERE client_id = $client_id AND claim_div = '1') \n";


	$result = Db_Query($db_con, $sql);
	if($result === false){
		Db_Query($db_con, "ROLLBACK;");
		exit;
	}

	while($row = pg_fetch_array($result)){
		$data[] = $row[client_id];
	}

	//print_array($data);
	//�ƤȻҤ�������ID���֤�
	return $data;
}


/**
 * ���ס���ۤ�Ʒ׻����٤�����ξ����������ޤ�
 *
 * ����
 *
 * @param object    $db_con      DB���ͥ������
 * @param integer   $client_id   ������ID
 *
 * @return array    �������
 *
 */
function Get_Contract_Coax($db_con, $client_id){
	$sql = "
		SELECT 
		t_contract.contract_id,
		t_contract.line,
		t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd,
		t_client.client_cname,
		CASE 
			--���켰��ñ����ü����������
			WHEN set_flg = 't' AND num IS NULL AND sale_price NOT LIKE '%.00' THEN '1'
		
			--��ñ���߿��̤�ü����������
			WHEN set_flg = 'f' AND (sale_price * num) NOT LIKE '%.00' THEN '1'
		
			--�������ӥ��Τߤ�ü����������
			WHEN num IS NULL AND sale_price NOT LIKE '%.00' THEN '1'
		END AS coax_flg
		
		FROM t_contract
		INNER JOIN t_con_info ON t_contract.contract_id = t_con_info.contract_id
		INNER JOIN t_client   ON t_contract.client_id = t_client.client_id
		WHERE t_contract.client_id = $client_id 
		
		GROUP BY 
		t_contract.contract_id,
		t_contract.line,
		client_cd,
		client_cname,
		coax_flg
		ORDER BY t_contract.contract_id;
	";
	$result = Db_Query($db_con, $sql);
	if($result === false){
		Db_Query($db_con, "ROLLBACK;");
		exit;
	}

	while($data = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
		//ü���Τ������ID�ξ��
		if($data[coax_flg] == "1"){
			$contract_data[] = $data; //���������������Ͽ
		}
	}

	//���������֤�
	//print_array($contract_data);
	return $contract_data;

}

/**
 * ���ס�����ζ�ۤ�Ʒ׻����ޤ���
 *
 * ����
 *
 * @param object    $db_con      DB���ͥ������
 * @param integer   $client_id   ������ID
 * @param integer   $coax        �ѹ����δݤ��ʬ
 *
 * @return string    �ѹ���å�����
 *
 */
//�ݤ���ѹ��ˤ������ۤ��ѹ�����뤫�����å�����
function Update_Con_Amount($db_con, $client_id,$coax){

	//�ѹ���δݤ��ʬ�����
	$tax_div     = Get_Tax_div($db_con,$client_id);
	//echo $coax."<br>";
	//echo $tax_div[coax]."<br>";
	
	//�ѹ������ѹ���δݤ��ʬ���ۤʤ���
	if($coax != $tax_div[coax]){
	
		//�ƻҤ�������ID�����
		$client_id_ary = Get_Claim_Family($db_con, $client_id);
		foreach($client_id_ary AS $key => $client_id ){
		
			//��ۤ�Ʒ׻����٤�����ξ�������
			$contract_ary = Get_Contract_Coax($db_con, $client_id);

			//�Ʒ׻����٤����󤬤�����
			if(count($contract_ary) > 0){
				foreach($contract_ary AS $key => $con_data ){

					$contract_id  = $con_data[contract_id];
					$client_cname = htmlspecialchars($con_data[client_cname]);
					
					//����ζ�ۤ�Ʒ׻�
					Update_Act_Amount($db_con, $contract_id, "contract");
		
					//�Ʒ׻����������襳���ɤȷ����ֹ���֤�
					//$mesg .= "<a href=\"2-1-115.php?client_id=".$client_id."\">";
					$mesg .= $con_data[client_cd]." ".$client_cname." ����No. ".$con_data[line]."<br>";
					//$mesg .= "</a>";

				}	
			}

		}
	
	//�ݤ��ʬ���ѹ�����ʤ��ä����
	}else{
		//echo "�ݤ��ʬ���ѹ�����ޤ���Ǥ���";	
	}

	return $mesg;
}


/**
 * ���ס�������Τ��������ɼ�μ����ʬ����ݤ��ѹ����ޤ���
 *
 * ����
 *
 * @param object    $db_con      DB���ͥ������
 * @param integer   $client_id   ������ID
 *
 * @return boolean  �¹Է��
 *
 */
function Update_Aord_Trade($db_con, $client_id){

	//̤������������μ���
	$sub_sql  = "SELECT aord_id FROM t_aorder_h \n";
	$sub_sql .= " WHERE client_id = $client_id \n";
	$sub_sql .= " AND ps_stat = '1'  \n";
	$sub_sql .= " AND advance_offset_totalamount IS NOT NULL \n";

	//�����ʬ����ݤ��ѹ�
	$sql  = "UPDATE t_aorder_h SET ";
	$sql .= "trade_id = 11 ";
	$sql .= "WHERE aord_id IN (".$sub_sql.") ";
	$result = Db_Query($db_con, $sql);
	if($result === false){
		Db_Query($db_con, "ROLLBACK;");
		return false;
	}

	return true;

}


/**
 * ���ס�������2�η���¸�ߤ��뤫��ǧ��
 *
 * ����
 *
 * @param object    $db_con      DB���ͥ������
 * @param integer   $client_id   ������ID
 *
 * @return boolean  �¹Է��
 *
 */
function Check_Con_Claim2($db_con, $client_id){

    if($client_id == null){
        return false;
    }

    $sql  = "SELECT";
    $sql .= "   COUNT(*) ";
    $sql .= "FROM ";
    $sql .= "   t_contract ";
    $sql .= "WHERE ";
    $sql .= "   t_contract.client_id = $client_id";
    $sql .= "   AND ";
    $sql .= "   t_contract.claim_div = '2' ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $data_count = pg_fetch_result($result, 0,0);

    if($data_count > 0){
        return true;
    }

    return false;
}




/***************************/
// Code_value
/***************************/
// ������
//$code_value = Code_Value("t_client",$conn,"",6);

/*
$where_sql  = "    WHERE";
$where_sql .= "        client_div = '3' ";
$where_sql .= "         OR\n";
$where_sql .= "     (\n";
$where_sql .= ($_SESSION[group_kind] == "2") ? "  shop_id IN (".Rank_Sql().") " : " shop_id = $_SESSION[client_id] ";
$where_sql .= "        AND";
$where_sql .= "        client_div = '2'";
$where_sql .= "     )\n";
$code_value .= Code_Value("t_client",$conn,"$where_sql",2);
*/
//$code_value .= Code_Value("t_client",$conn,"",8);


/****************************����λ������*************************/

$contract = "function Contract(me){\n";
$contract .= "  var TERM = \"form_cont_peri\";\n";
$contract .= "  var SY = \"form_cont_s_day[y]\";\n";
$contract .= "  var SM = \"form_cont_s_day[m]\";\n";
$contract .= "  var SD = \"form_cont_s_day[d]\";\n";
$contract .= "  var EY = \"form_cont_e_day[y]\";\n";
$contract .= "  var EM = \"form_cont_e_day[m]\";\n";
$contract .= "  var ED = \"form_cont_e_day[d]\";\n";
$contract .= "  var RY = \"form_cont_r_day[y]\";\n";
$contract .= "  var RM = \"form_cont_r_day[m]\";\n";
$contract .= "  var RD = \"form_cont_r_day[d]\";\n";
$contract .= "  var s_year = parseInt(me.elements[SY].value);\n";
$contract .= "  var r_year = parseInt(me.elements[RY].value);\n";
$contract .= "  var term = me.elements[TERM].value;\n";
$contract .= "  len_ry = me.elements[RY].value.length;\n";
$contract .= "  len_rm = me.elements[RM].value.length;\n";
$contract .= "  len_rd = me.elements[RD].value.length;\n";
$contract .= "  len_sy = me.elements[SY].value.length;\n";
$contract .= "  len_sm = me.elements[SM].value.length;\n";
$contract .= "  len_sd = me.elements[SD].value.length;\n";
$contract .= "  if(len_rm == 1){\n";
$contract .= "      me.elements[RM].value = '0'+me.elements[RM].value;\n";
$contract .= "      len_rm = me.elements[RM].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(len_rd == 1){\n";
$contract .= "      me.elements[RD].value = '0'+me.elements[RD].value;\n";
$contract .= "      len_rd = me.elements[RD].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(len_sm == 1){\n";
$contract .= "      me.elements[SM].value = '0'+me.elements[SM].value;\n";
$contract .= "      len_sd = me.elements[SD].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(len_sd == 1){\n";
$contract .= "      me.elements[SD].value = '0'+me.elements[SD].value;\n";
$contract .= "      len_sd = me.elements[SD].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(me.elements[RM].value == '02' && me.elements[RD].value == '29' && term != \"\" && len_ry == 4 && len_rm == 2 && len_rd == 2){\n";
$contract .= "      var term = parseInt(term);\n";
$contract .= "      me.elements[EY].value = r_year+term;\n";
$contract .= "      me.elements[EM].value = \"03\";\n";
$contract .= "      me.elements[ED].value = \"01\";\n";
$contract .= "  }else if(term != \"\" && len_ry == 4 && len_rm == 2 && len_rd == 2){\n";
$contract .= "      var term = parseInt(term);\n";
$contract .= "      me.elements[EY].value = r_year+term;\n";
$contract .= "      me.elements[EM].value = me.elements[RM].value;\n";
$contract .= "      me.elements[ED].value = me.elements[RD].value;\n";
$contract .= "  }else if(me.elements[SM].value == '02' && me.elements[SD].value == '29' && term != \"\" && len_sy == 4 && len_sm == 2 && len_sd == 2){\n";
$contract .= "      var term = parseInt(term);\n";
$contract .= "      me.elements[EY].value = s_year+term;\n";
$contract .= "      me.elements[EM].value = \"03\";\n";
$contract .= "      me.elements[ED].value = \"01\";\n";
$contract .= "  }else if(term != \"\" && len_sy == 4 && len_sm == 2 && len_sd == 2){\n";
$contract .= "      var term = parseInt(term);\n";
$contract .= "      me.elements[EY].value = s_year+term;\n";
$contract .= "      me.elements[EM].value = me.elements[SM].value;\n";
$contract .= "      me.elements[ED].value = me.elements[SD].value;\n";
$contract .= "  }else{\n";
$contract .= "      me.elements[EY].value = \"\";\n";
$contract .= "      me.elements[EM].value = \"\";\n";
$contract .= "      me.elements[ED].value = \"\";\n";
$contract .= "  }\n";
$contract .= "}\n";
/****************************************************/


/****************************/
// HTML�إå�
/****************************/
// �����褬��Ԥξ��ϡ�������̾��ά�Τ�ե꡼��
if($act_flg == "t" || $_POST["form_act_flg"] == "t"){
    $freeze_form = $form->addGroup($freeze_text,"freeze_text", "");
    $freeze_form->freeze();
}

/****************************/
//js
/****************************/
//�����裱�ǻ��Ѥ���
$sql  = "SELECT \n";
$sql .= "    client_cd1,   \n";
$sql .= "    client_cd2,   \n";
$sql .= "    client_cname, \n";
$sql .= "    pay_name, \n";
$sql .= "    account_name \n";
$sql .= "FROM \n";
$sql .= "    t_client \n";
$sql .= "        INNER JOIN \n";
$sql .= "    (SELECT \n";
$sql .= "        client_id \n";
$sql .= "    FROM \n";
$sql .= "        t_claim \n"; 
$sql .= "    WHERE \n";
$sql .= "     client_id IN (SELECT";
$sql .= "                     client_id";
$sql .= "                 FROM";
$sql .= "                     t_claim";
$sql .= "                 WHERE";
$sql .= "                     client_id = claim_id";
$sql .= "                 )";
$sql .= "    GROUP BY \n";
$sql .= "        client_id \n"; 
$sql .= "    HAVING COUNT(client_id) = 1 \n";
$sql .= "    ) AS t_claim \n";
$sql .= "    ON t_client.client_id = t_claim.client_id \n"; 
$sql .= "WHERE \n";
$sql .= "    t_client.client_div = '1' \n";
$sql .= "    AND \n";
$sql .= "    t_client.state = '1' \n";
$sql .= "    AND \n";
$sql .= ($group_kind == '2')? "shop_id IN (".Rank_Sql().")" : "shop_id = $shop_id";
$sql .= "; \n";

$result = Db_Query($conn, $sql);

$row = pg_num_rows($result);

$js   = "function claim1(code1,code2,name,pay1,pay2, div){\n";
$js  .= "  data1 = new Array($row);\n";
$js  .= "  data2 = new Array($row);\n";
$js  .= "  data3 = new Array($row);\n";

for($i=0;$i<$row;$i++){
    //code1����
    $cd1 = pg_fetch_result($result,$i,0);
    //code2����
    $cd2 = pg_fetch_result($result,$i,1);
    //name����
    $name = pg_fetch_result($result,$i,2);
    $name = addslashes($name);
    //����̾����
    $pay_name1 = pg_fetch_result($result, $i,3);
    $pay_name1 = addslashes($pay_name1);    
    //����̾����
    $pay_name2 = pg_fetch_result($result, $i,4);
    $pay_name2 = addslashes($pay_name2);    

    //$name = mb_ereg_replace('"','\"',$name);
    $js .= "  data1['$cd1-$cd2'] = \"$name\";\n";
    $js .= "  data2['$cd1-$cd2'] = \"$pay_name1\";\n";
    $js .= "  data3['$cd1-$cd2'] = \"$pay_name2\";\n";
}

$js .= "  var data1 = data1[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
$js .= "  var data2 = data2[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
$js .= "  var data3 = data3[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
$js .= "  len1 = document.dateForm.elements[code1].value.length;\n";
$js .= "  len2 = document.dateForm.elements[code2].value.length;\n";

$js .= "  if(data1 == undefined){\n";
$js .= "      document.dateForm.elements[name].value = \"\";\n";
$js .= "  }else if(len1 == 6 && len2 == 4 && div == '1'){\n";
$js .= "      document.dateForm.elements[name].value = data1; \n";
$js .= "      document.dateForm.elements[pay1].value = data2; \n";
$js .= "      document.dateForm.elements[pay2].value = data3; \n";
$js .= "  }else if(len1 == 6 && len2 == 4 ){\n";
$js .= "      document.dateForm.elements[name].value = data1; \n";
$js .= "  }\n";
$js .= "}\n";

//�Ȳ������ǻ��Ѥ���
$sql  = "SELECT";
$sql .= "   client_cd1,\n";
$sql .= "   CASE client_div\n";
$sql .= "       WHEN '2' THEN ''\n";
$sql .= "       WHEN '3' THEN client_cd2\n";
$sql .= "   END AS client_cd2,\n";
$sql .= "   client_name\n"; 
$sql .= "FROM\n";
$sql .= "   t_client \n";
$sql .= "WHERE\n";

if($group_kind == '2'){
    $sql .= "   (\n";
    $sql .= "   client_div = '3'\n";
    $sql .= "   AND\n";
    $sql .= "   rank_cd != '0003'\n";
    $sql .= "   )\n";
    $sql .= "   OR\n";
}

$sql .= "   (client_div = '2'\n";
$sql .= "   AND\n";
$sql .= ($group_kind == '2')? "shop_id IN (".Rank_Sql().")" : "shop_id = $shop_id";
$sql .= "   )";
$sql .= ";";

$result = Db_Query($conn, $sql);

$row = pg_num_rows($result);

//ľ�Ĥξ��
if($group_kind == '2'){
    $js  .= "function client2(code1,code2,name){\n";
}else{
    $js  .= "function client2(code1,name){\n";
}
$js  .= "  data = new Array($row);\n";

for($i=0;$i<$row;$i++){
    //code1����
    $cd1 = pg_fetch_result($result,$i,0);
    //code2����
    $cd2 = pg_fetch_result($result,$i,1);
    //name����
    $name = pg_fetch_result($result,$i,2);
    $name = addslashes($name);

    //ľ�Ĥξ��
    if($group_kind == '2'){
        $js .= "  data['$cd1-$cd2']=\"$name\";\n";
    }else{
        $js .= "  data['$cd1']=\"$name\";\n";
    }
}

//ľ�Ĥξ��
if($group_kind == '2'){
    $js .= "  var data = data[document.dateForm.elements[code1].value+'-'+document.dateForm.elements[code2].value];\n";
    $js .= "  len1 = document.dateForm.elements[code1].value.length;\n";
    $js .= "  len2 = document.dateForm.elements[code2].value.length;\n";
    $js .= "  chk  = document.dateForm.form_client_div[0].checked; \n";
    $js .= "  next = \"form_intro_act[cd2]\"; \n";

    $js .= "  if(len1 == 6 && chk == true){ \n";
    $js .= "      document.dateForm.elements[next].focus();\n";
    $js .= "  }\n";

    $js .= "  if(data == undefined){\n";
    $js .= "      document.dateForm.elements[name].value = \"\";\n";
    $js .= "  }else if(len1 == 6 && len2 == 4 && chk == true){\n";
    $js .= "      document.dateForm.elements[name].value = data; \n";
    $js .= "  }else if(len1 == 6 && chk == false){\n";
    $js .= "      document.dateForm.elements[name].value = data; \n";
    $js .= "  }\n";
}else{
    $js .= "  var data = data[document.dateForm.elements[code1].value];\n";
    $js .= "  len1 = document.dateForm.elements[code1].value.length;\n";

    $js .= "  if(data == undefined){\n";
    $js .= "      document.dateForm.elements[name].value = \"\";\n";
    $js .= "  }else if(len1 == 6 ){\n";
    $js .= "      document.dateForm.elements[name].value = data; \n";
    $js .= "  }\n";
}

$js .= "}\n";

//ľ�Ĥξ��Τ�
if($group_kind == '2'){

    //�Ҳ����������饸���ܥ���
    $js .= "function client_div(){\n";
    $js .= "    var dis_code = \"form_intro_act[cd]\"\n";
    $js .= "    var dis_code2 = \"form_intro_act[cd2]\"\n";
    $js .= "    var dis_name = \"form_intro_act[name]\"\n";

    $js .= "    document.dateForm.elements[dis_code].value = \"\"\n";
    $js .= "    document.dateForm.elements[dis_code2].value = \"\"\n";
    $js .= "    document.dateForm.elements[dis_name].value = \"\"\n";
    $js .= "}\n";

    //������disable
    $js .= "function code_disable(){\n";
    $js .= "    var dis_code = \"form_intro_act[cd2]\"\n";
    $js .= "    var dis_name = \"form_intro_act[name]\"\n";
    
    $js .= "    if(document.dateForm.form_client_div[0].checked == false ){\n";
    $js .= "        document.dateForm.elements[dis_code].style.backgroundColor = \"gainsboro\"\n";
    $js .= "        document.dateForm.elements[dis_code].disabled = true\n";
    $js .= "    }else{\n";
    $js .= "        document.dateForm.elements[dis_code].disabled = false\n";
    $js .= "        document.dateForm.elements[dis_code].style.backgroundColor = \"white\"\n";
    $js .= "    }\n";

    $js .= "}\n";

    if($complete_flg != true){
        //������disable
        $js .= "function onload_code_disable(){\n";
        $js .= "    var dis_code = \"form_intro_act[cd2]\"\n";
        $js .= "    var dis_name = \"form_intro_act[name]\"\n";

        $js .= "    if(document.dateForm.form_client_div[0].checked == false ){\n";
        $js .= "        document.dateForm.elements[dis_code].style.backgroundColor = \"gainsboro\"\n";
        $js .= "        document.dateForm.elements[dis_code].disabled = true\n";
        $js .= "    }else{\n";
        $js .= "        document.dateForm.elements[dis_code].disabled = false\n";
        $js .= "        document.dateForm.elements[dis_code].style.backgroundColor = \"white\"\n";
        $js .= "    }\n";

        $js .= "}\n";
    }

    //���򤷤��Ҳ���¶�ʬ�ˤ������������ѹ�����
    $js .= "function Open_SubWin_client(url, arr, x, y,display,select_id,shop_aid,place,head_flg){\n";
    $js .= "    if((display == undefined && select_id == undefined) || (display != undefined && select_id != undefined)){\n";

    $js .= "    if(document.dateForm.form_client_div[0].checked == false ){\n";
    $js .= "        var pass = \"../dialog/2-0-208.php\";\n";
    $js .= "        var arr = Array('form_intro_act[cd]', 'form_intro_act[name]')\n";
    $js .= "        rtnarr = Open_Dialog(pass,x,y,display,select_id,shop_aid);\n";
    $js .= "    }else{\n";
    $js .= "        var pass = \"../dialog/2-0-302.php\";\n";
    $js .= "        var arr = Array('form_intro_act[cd]', 'form_intro_act[cd2]', 'form_intro_act[name]')\n";
    $js .= "        rtnarr = Open_Dialog(pass,x,y,3,select_id,shop_aid);\n";
    $js .= "    }\n";

    $js .= "        if(typeof(rtnarr) != \"undefined\"){\n";
    $js .= "            for(i=0;i<arr.length;i++){\n";
    $js .= "                dateForm.elements[arr[i]].value=rtnarr[i];\n";
    $js .= "            }\n";
    $js .= "        }\n";

    $js .= "    }\n";
    $js .= "    return false;\n";
    $js .= "}\n";
}

//�����ʬ�˸�������򤷤����ϡ��������ʧ���ˤ��롣
$js .= "function trade_close_day(){\n";
$js .= "  if(document.dateForm.trade_aord_1.value=='61'){\n";
$js .= "      var close_day = document.dateForm.form_close.value\n";
$js .= "      document.dateForm.form_pay_m.value='0';\n";
$js .= "      document.dateForm.form_pay_d.value=close_day;\n";
$js .= "  } \n";
$js .= "}\n";


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
$page_menu = Create_Menu_f('system', '1');

/****************************/
// ���̥إå�������
/****************************/

/****************************/
// ���������
/****************************/
$client_sql  = " SELECT";
$client_sql .= "     COUNT(client_id)";
$client_sql .= " FROM";
$client_sql .= "     t_client";
$client_sql .= " WHERE";
// $client_sql .= "     t_client.shop_gid = $shop_gid";
$client_sql .= ($_SESSION[group_kind] == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $_SESSION[client_id] ";
$client_sql .= "     AND";
$client_sql .= "     t_client.client_div = '1'";
$client_sql .= ";";

// �إå�����ɽ�������������
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
// ����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'           => "$html_header",
    'page_menu'             => "$page_menu",
    'page_header'           => "$page_header",
    'html_footer'           => "$html_footer",
    'claim_err'             => "$claim_err",
    'intro_act_err'         => "$intro_act_err",
    'close_err'             => "$close_err",
    'sday_err'              => "$csday_err",
    'rday_err'              => "$crday_err",
    'rsday_err'             => "$rsday_err",
    'esday_err'             => "$esday_err",
    'parent_esday_err'      => "$parent_esday_err",
    'sday_rday_err'         => "$sday_rday_err",
    'code_value'            => "$code_value",
    'client_cd_err'         => "$client_cd_err",
    'tel_err'               => "$tel_err",
    'fax_err'               => "$fax_err",
    'contract'              => "$contract",
    'next_id'               =>  $next_id,
    'back_id'               =>  $back_id,
    'onload'                => "$onload",
    'email_err'             => "$email_err",
    'url_err'               => "$url_err",
    'rep_cell_err'          => "$rep_cell_err",
    'd_tel_err'             => "$d_tel_err",
    'company_tel_err'       => "$company_tel_err",
    'claim_coax_err'        => "$claim_coax_err",
    'claim_tax_div_err'     => "$claim_tax_div_err",
    'claim_tax_franct_err'  => "$claim_tax_franct_err",
    'claim_c_tax_div_err'   => "$claim_c_tax_div_err",
    'claim2_err'            => "$claim2_err",
    'claim2_coax_err'       => "$claim2_coax_err",
    'claim2_tax_div_err'    => "$claim2_tax_div_err",
    'claim2_tax_franct_err' => "$claim2_tax_franct_err",
    'claim2_c_tax_div_err'  => "$claim2_c_tax_div_err",
    'warning'               => "$warning",
    'js'                    => "$js",
    'claim_del_err'         => "$err_mess",
    'complete_flg'          => "$complete_flg",
    'err_flg'               => "$err_flg",
    'update_con_mesg'               => "$update_con_mesg",
    'claim_month_err'       => "$claim_month_err",
    #2010-04-30 hashimoto-y
    'address1_err'          => "$address1_err",
    'address2_err'          => "$address2_err",
    'address3_err'          => "$address3_err",
    'client_name1_err'      => "$client_name1_err",
    'client_name2_err'      => "$client_name2_err",
));

// �ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
