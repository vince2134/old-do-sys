<?php
/*******************************
�ѹ�����
    ���������ι����ѹ�
    ���������פα�¦�ˡֽ�����ˡ�פ�ɽ�������ֽ������פα�¦�϶����Ƥ����褦�ѹ���
    ���ֽ�����ˡ�פˡּ�ư����פ��ɲä���Ǽ�ʻ��פ���
    ���ּ����ʬ�פǡָ������פ����򤷤����ϡ��������סֽ������פ϶�������򤹤롣
    �����̤��ɲ�
    ��������Υ����å������ѹ�    
   ��2006/07/21�˸��¶�ʬ��Ͽ(suzuki)
    (2006/07/31) ���Ƕ�ʬ����Ͽ�ѹ������ɲá�watanabe-k��
    (2006/08/07) ���ܥ�����������ѹ���watanabe-k��
    (2006/08/29) �����Ȼ�ʧ���������������å��ɲá�watanbe-k��
    2006/11/13  0033    kaku-m  TELFAX�ֹ�Υ����å���ؿ��ǹԤ��褦�˽�����
*******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2009/12/25                  aoyama-n    ���Ƕ�ʬ�����Ǥ���
 *   2016/01/21                amano  Button_Submit_1 �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�  
*/

$page_title = "������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//���������(radio��select)
/****************************/
/*
$def_data["form_state"] = 1;
$def_data["form_slip_out"] = 1;
$def_data["form_deliver_radio"] = 1;
$def_data["form_claim_out"] = 1;
$def_data["form_coax"] = 1;
$def_data["form_tax_div"] = 2;
$def_data["form_tax_franct"] = 1;
$def_data["form_claim_send"] = 1;
$def_data["form_bank_div"] = 1;
$def_data["form_prefix"] = 1;
//$def_data["form_claim_scope"] = 't';
$def_data["form_type"] = 1;
$def_data["form_c_tax_div"] = "1";

$form->setDefaults($def_data);
*/

/****************************/
//����Ƚ��
/****************************/
$shop_id = $_SESSION[client_id];
$staff_id = $_SESSION[staff_id];
if(isset($_GET["client_id"])){
    $get_client_id = $_GET["client_id"];
    $new_flg = false;
}else{
    $new_flg = true;
}

/* GET����ID�������������å� */
if ($_GET["client_id"] != null && Get_Id_Check_Db($conn, $_GET["client_id"], "client_id", "t_client", "num", " client_div = '1' ") != true){
    header("Location: ../top.php");
}elseif($_GET == null){
    header("Location: ../top.php");
}

/****************************/
//��������GET���������
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
    $select_sql .= "    t_client.shop_id, ";
    $select_sql .= "    fc.client_name AS fc_name,";
    $select_sql .= "    fc.client_cd1 AS fc_cd1,";
    $select_sql .= "    fc.client_cd2 AS fc_cd2,";
    $select_sql .= "    fc.state AS fc_state,";
    $select_sql .= "    t_rank.group_kind, ";

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
    $select_sql .= "    t_client_claim.month12_flg ";

    $select_sql .= " FROM\n";
    $select_sql .= "    t_client\n";
    $select_sql .= "        INNER JOIN\n";
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
    $select_sql .= "    (SELECT\n";
    $select_sql .= "        t_claim.client_id,\n";
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
    $select_sql .= "    LEFT JOIN";
    $select_sql .= "        t_client_info";
    $select_sql .= "    ON t_client.client_id = t_client_info.client_id";
    $select_sql .= "    LEFT JOIN t_rank ";
    $select_sql .= "    ON t_rank.rank_cd = t_client.rank_cd ";
    $select_sql .= "    INNER JOIN (SELECT * FROM t_client WHERE client_div = '0' OR client_div = '3' ) AS fc ON t_client.shop_id = fc.client_id";
    $select_sql .= " WHERE\n";
    $select_sql .= "    t_client.client_id = $_GET[client_id]\n";
    $select_sql .= ";";

    //������ȯ��
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    //�ǡ�������
    $client_data = @pg_fetch_array ($result, 0);

    //����ͥǡ���
    $defa_data["form_client"]["cd1"]          = $client_data[0];         // �����襳���ɣ�
    $defa_data["form_client"]["cd2"]          = $client_data[1];         // �����襳���ɣ�
    $defa_data["form_fc"]["cd1"]              = $client_data["fc_cd1"];
    $defa_data["form_fc"]["cd2"]              = $client_data["fc_cd2"];
    $defa_data["form_state"]                  = $client_data[2];         // ����
    $defa_data["form_state_fc"]               = $client_data["fc_state"];  // ����å׾���
    $defa_data["form_client_name"]            = $client_data[3];         // ������̾
    $defa_data["form_fc_name"]                = $client_data["fc_name"];
    $defa_data["form_client_read"]            = $client_data[4];         // ������̾(�եꥬ��)
    $defa_data["form_client_cname"]           = $client_data[5];         // ά��
    $defa_data["form_post"]["no1"]            = $client_data[6];         // ͹���ֹ棱
    $defa_data["form_post"]["no2"]            = $client_data[7];         // ͹���ֹ棲
    $defa_data["form_address1"]               = $client_data[8];         // ���꣱
    $defa_data["form_address2"]               = $client_data[9];         // ���ꣲ
    $defa_data["form_address_read"]           = $client_data[10];        // ����(�եꥬ��)
    $defa_data["form_area_id"]                   = $client_data[11];        // �϶�
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
    $defa_data["sale_pattern"]       = $client_data[98];            //��ɼȯ�ԥѥ�����
    $defa_data["claim_pattern"]       = $client_data[99];            //�����ȯ���ѥ�����
    $defa_data["form_charge_branch_id"]       = $client_data["charge_branch_id"];   //ô����Ź
    $defa_data["form_c_tax_div"]              = $client_data["c_tax_div"];   //���Ƕ�ʬ
    $defa_data["form_claim2"]["cd1"]          = $client_data["claim2_cd1"];  //�����裲�����ɣ�
    $defa_data["form_claim2"]["cd2"]          = $client_data["claim2_cd2"];  //�����裲�����ɣ�
    $defa_data["form_claim2"]["name"]         = $client_data["claim2_name"]; //�����裲̾
    $defa_data["form_bank"][2]                = $client_data["account_id"]; //����ID

    $defa_data["form_client_gr"]              = $client_data["client_gr_id"];
    $defa_data["form_parents_div"]            = $client_data["parents_flg"];
//    $defa_data["form_bank_all"]               = $client_data["bank_name"];

    if($client_data["intro_act_div"] == '3'){
        $defa_data["form_intro_act"]["cd2"]       = $client_data["intro_act_cd2"];  //�Ҳ������CD2
        $defa_data["form_client_div"]         = '1';
    }elseif($client_data["intro_act_div"] == '2'){
        $defa_data["form_client_div"]         = '2';
    }else{
        $defa_data["form_client_div"]         = '1';
    }

    //����������
    for($i = 0; $i < 12; $i++){
        $defa_data["claim1_monthly_check"][$i] = ($client_data["month".($i+1)."_flg"] == 't')? $client_data["month".($i+1)."_flg"] : null;
    }


    //���������
    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "client",$client_data[0].",".$client_data[1]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

	if($shop_id != $client_data[79]){
		$complete_flg = true;
	}

    //��ʬ��������Ȥ���¾�����������Ͽ����Ƥ��뤫
    $sql  = "SELECT";
    $sql .= "   count(client_id)";
    $sql .= " FROM";
    $sql .= "   t_client_info";
    $sql .= " WHERE";
    $sql .= "   client_id <> $get_client_id";
    $sql .= "   AND";
    $sql .= "   claim_id = $get_client_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $claim_num = pg_fetch_result($result,0,0);

    if($claim_num > 0){
        $change_flg = true;
    }else{
        $change_flg = false;
    }

}
$client_div = $client_data[75];
/***************************/
//�ե��������
/***************************/
//����
$form_type[] =& $form->createElement( "radio",NULL,NULL, "��ԡ���","1");
$form_type[] =& $form->createElement( "radio",NULL,NULL, "��ԡ��ȳ�","2");
$form->addGroup($form_type, "form_type", "");

//���롼��
$select_value = null;
//$select_value = Select_Get($conn, "client_gr");
$sql  = "SELECT client_gr_id, client_gr_cd, client_gr_name ";
$sql .= "FROM t_client_gr ";
$sql .= "WHERE ";
if($client_data["group_kind"] == "2"){
    $sql .= "    shop_id IN (".Rank_Sql().")";
}else{
    $sql .= "     shop_id = ".$client_data["shop_id"];
}
$sql .= " ORDER BY client_gr_cd ";
$sql .= ";";
$result = Db_Query($conn,$sql);
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}

$form->addElement("select", "form_client_gr", "",$select_value,$g_form_option_select);
//$form->addElement("text","form_client_gr","");

$form_parents_div[] =& $form->createElement("radio", null, null, "��", "true");
$form_parents_div[] =& $form->createElement("radio", null, null, "��", "false");
$form_parents_div[] =& $form->createElement("radio", null, null, "��Ω", "null");
$form->addGroup($form_parents_div, "form_parents_div", "");

//�����襳����
$form_client[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_client[cd1]','form_client[cd2]',6)\"".$g_form_option."\""
        );
$form_client[] =& $form->createElement(
        "static","","","-"
        );
$form_client[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option"
        );
$form->addGroup( $form_client, "form_client", "");

//����åץ�����
$form_fc[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_fc[cd1]','form_fc[cd2]',6)\"".$g_form_option."\""
        );
$form_fc[] =& $form->createElement(
        "static","","","-"
        );
$form_fc[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option"
        );
$form->addGroup( $form_fc, "form_fc", "");


//����å�̾
$form->addElement(
        "text","form_fc_name","",'size="44" maxLength="25"'." $g_form_option"
        );


//�����
$text = null;
$text[] =& $form->createElement( "radio",NULL,NULL, "�����","1");
$text[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$text[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$form->addGroup($text, "form_state", "");


//����楷��å�
$text = null;
$text[] =& $form->createElement( "radio",NULL,NULL, "�����","1");
$text[] =& $form->createElement("radio", null, null, "���󡦵ٻ���", "2");
//$text[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$form->addGroup($text, "form_state_fc", "");


//������̾
$form->addElement(
        "text","form_client_name","",'size="44" maxLength="25"'." $g_form_option"
        );

//������̾�ʥեꥬ�ʡ�
$form->addElement(
        "text","form_client_read","",'size="46" maxLength="50"'." $g_form_option"
        );

//������̾��
$form->addElement(
        "text","form_client_name2","",'size="44" maxLength="25"'." $g_form_option"
        );

//������̾����ɼ����
$form->addElement("checkbox", "form_client_slip1", "");

//������̾����ɼ����
$form->addElement("checkbox", "form_client_slip2", "");


//������̾���ʥեꥬ�ʡ�
$form->addElement(
        "text","form_client_read2","",'size="46" maxLength="50"'." $g_form_option"
        );

//ά��
$form->addElement(
        "text","form_client_cname","",'size="44" maxLength="20"'." $g_form_option"
        );

//ά�Ρʥեꥬ�ʡ�
$form->addElement(
        "text","form_cname_read","",'size="46" maxLength="40"'." $g_form_option"
        );

//͹���ֹ�
$form_post[] =& $form->createElement(
        "text","no1","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  $g_form_option"
        );
$form->addGroup( $form_post, "form_post", "");

//���꣱
$form->addElement(
        "text","form_address1","",'size="44" maxLength="25"'." $g_form_option"
        );

//���ꣲ
$form->addElement(
        "text","form_address2","",'size="46" maxLength="25"'." $g_form_option"
        );

//����3
$form->addElement(
        "text","form_address3","",'size="44" maxLength="30"'." $g_form_option"
        );

//����(�եꥬ��)
$form->addElement(
        "text","form_address_read","",'size="46" maxLength="50"'." $g_form_option"
        );

//͹���ֹ�
//��ư���ϥܥ��󤬲������줿���
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["no1"];             //͹���ֹ棱
    $post2     = $_POST["form_post"]["no2"];             //͹���ֹ棲
    $post_value = Post_Get($post1,$post2,$conn);
    //͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button_flg"] = "";
    //͹���ֹ椫�鼫ư����
    $cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);
}

//�϶�
//$select_ary = Select_Get($conn,'area');
if($client_data["group_kind"] == '2'){
    $where = "WHERE shop_id IN (".Rank_Sql().")";
}else{
    $where = "WHERE shop_id = ".$client_data["shop_id"];
}
$sqla = "SELECT area_id,area_cd,area_name ";
$sqla .= "FROM t_area ";
$sqla .= $where;
$sqla .= " ORDER BY area_cd";
$sqla .= ";";
$result = Db_Query($conn,$sqla);
$select_value[""] = "";
while($data_list = pg_fetch_array($result) ){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
//$form->addElement('text', 'form_area_id',"","size=\"22\"style=\"$g_form_style\"$g_form_option");
$form->addElement("select", "form_area_id", "",$select_value,$g_form_option_select);
//TEL
$form->addElement(
        "text","form_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option"
        );

//FAX
$form->addElement(
        "text","form_fax","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option"
        );

//Email
$form->addElement(
        "text","form_email","","size=\"34\" maxLength=\"60\" style=\"$g_form_style\" $g_form_option"
        );

//URL
$form->addElement(
        "text","form_url","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//��ɽ��
$form->addElement(
        "text","form_rep_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//��ɽ����
$form->addElement(
        "text","form_rep_position","",'size="22" maxLength="10"'." $g_form_option"
        );

//��ɽ�Է���
$form->addElement(
        "text","form_represent_cell","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//�Ʋ��̾
$form->addElement(
        "text","form_company_name","","size=\"44\" maxLength=\"30\"
        $g_form_option"        );      

//�Ʋ��TEL
$form->addElement(
        "text","form_company_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );      

//�Ʋ�ҽ���
$form->addElement(
        "text","form_company_address","","size=\"120\" maxLength=\"100\" 
        $g_form_option"
        );

//�Ʋ���϶���
$form_parent_establish_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_parent_establish_day[y]','form_parent_establish_day[m]',4)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_parent_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_parent_establish_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_parent_establish_day[m]','form_parent_establish_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_parent_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_parent_establish_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_parent_establish_day,"form_parent_establish_day","");

//�Ʋ����ɽ�Ի�̾
$form->addElement(
        "text","form_parent_rep_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//**************************************//
//ô�����ѹ���2006/04/20��
//**************************************//
//����
$form->addElement(
        "text","form_charger_part1","","size=\"22\" maxLength=\"10\" $g_form_option"
);
//����
$form->addElement(
        "text","form_charger_part2","","size=\"22\" maxLength=\"10\" $g_form_option"
);
//����
$form->addElement(
        "text","form_charger_part3","","size=\"22\" maxLength=\"10\" $g_form_option"
);
//�򿦣�
$form->addElement(
        "text","form_charger_represe1","","size\"22\" maxLength=\"10\" $g_form_option"
);
//�򿦣�
$form->addElement(
        "text","form_charger_represe2","","size\"22\" maxLength=\"10\" $g_form_option"
);
//�򿦣�
$form->addElement(
        "text","form_charger_represe3","","size\"22\" maxLength=\"10\" $g_form_option"
);

//��ô��1
$form->addElement(
        "text","form_charger1","",'size="34" maxLength="15"'." $g_form_option"
        );

//��ô��2
$form->addElement(
        "text","form_charger2","",'size="34" maxLength="15"'." $g_form_option"
        );

//��ô��3
$form->addElement(
        "text","form_charger3","",'size="34" maxLength="15"'." $g_form_option"
        );

//ô��������
$form->addElement(
         "textarea","form_charger_note","",' rows="5" cols="75"'." $g_form_option_area"
);

//��Լ������ô��ʬ
$form_bank_div[] =& $form->createElement( "radio",NULL,NULL, "��������ô","1");
$form_bank_div[] =& $form->createElement( "radio",NULL,NULL, "������ô","2");
$form->addGroup($form_bank_div, "form_bank_div", "");

/***************************************/

//�ĶȻ���
//�������ϻ���
$form_stime1[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_stime1[h]','form_trade_stime1[m]',2)\"".$g_form_option."\""
        );
$form_stime1[] =& $form->createElement(
        "static","","",":"
        );
$form_stime1[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_stime1[m]','form_trade_etime1[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_stime1,"form_trade_stime1","");

//������λ����
$form_etime1[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_etime1[h]','form_trade_etime1[m]',2)\"".$g_form_option."\""
        );
$form_etime1[] =& $form->createElement(
        "static","","",":"
        );
$form_etime1[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_etime1[m]','form_trade_stime2[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_etime1,"form_trade_etime1","");

//��峫�ϻ���
$form_stime2[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_stime2[h]','form_trade_stime2[m]',2)\"".$g_form_option."\""
        );
$form_stime2[] =& $form->createElement(
        "static","","",":"
        );
$form_stime2[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_stime2[m]','form_trade_etime2[h]',2)\"".$g_form_option."\""
        );
$form->addGroup( $form_stime2,"form_trade_stime2","");

//��彪λ����
$form_etime2[] =& $form->createElement(
        "text","h","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_trade_etime2[h]','form_trade_etime2[m]',2)\"".$g_form_option."\""
        );
$form_etime2[] =& $form->createElement(
        "static","","",":"
        );
$form_etime2[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"  $g_form_option"
        );
$form->addGroup( $form_etime2,"form_trade_etime2","");

//����
$form->addElement(
        "text","form_holiday","",'size="22" maxLength="10"'." $g_form_option"
        );

//�ȼ�
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
$sql .= "   INNER JOIN";
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
$select_value = "";
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $space = "";
    for($i = 0; $i< $max_len; $i++){
        if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
                $data_list[1] = $data_list[1]."��";
        }
    }
    
    $select_value[$data_list[2]] = $data_list[0]." �� ".$data_list[1]."���� ".$data_list[3]." �� ".$data_list[4];
}

$form->addElement('select', 'form_btype',"", $select_value,$g_form_option_select);

//����
$sql  = "SELECT";
$sql .= "   inst_id,";
$sql .= "   inst_cd,";
$sql .= "   inst_name";
$sql .= " FROM";
$sql .= "   t_inst";
$sql .= " WHERE";
$sql .= "   accept_flg = '1'";
$sql .= " ORDER BY inst_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

$select_value = "";
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_inst',"", $select_value,$g_form_option_select);

//����
$sql  = "SELECT";
$sql .= "   bstruct_id,";
$sql .= "   bstruct_cd,";
$sql .= "   bstruct_name";
$sql .= " FROM";
$sql .= "   t_bstruct";
$sql .= " WHERE";
$sql .= "   accept_flg = '1'";
$sql .= " ORDER BY bstruct_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

$select_value = "";
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_bstruct',"", $select_value,$g_form_option_select);

//������
$form_claim[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\"  style=\"$g_form_style\"
        onkeyup=\"javascript:client1('form_claim[cd1]','form_claim[cd2]','form_claim[name]'); 
        changeText(this.form,'form_claim[cd1]','form_claim[cd2]',6)\"".$g_form_option."\"" 
        );
$form_claim[] =& $form->createElement(
        "static","","","-"
        );
$form_claim[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\"  style=\"$g_form_style\"
        onKeyUp=\"javascript:client1('form_claim[cd1]','form_claim[cd2]','form_claim[name]')\"".$g_form_option."\"" 
        );
$form_claim[] =& $form->createElement(
        "text","name","","size=\"34\" 
        $g_text_readonly"
        );
$freeze = $form->addGroup( $form_claim, "form_claim", "");
if($change_flg == true){
    $freeze->freeze();
}

//�����裲
$form_claim2= "";
$form_claim2[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
            onkeyup=\"changeText(this.form, 'form_claim2[cd1]', 'form_claim2[cd2]',6)\"
            onkeyup=\"javascript:claim1('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]','','','');
            changeText(this.form,'form_claim2[cd1]','form_claim2[cd2]',6)\"".$g_form_option."\"");
$form_claim2[] =& $form->createElement("static", "", "", "-");
$form_claim2[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"javascript:claim1('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]','','','')\"".$g_form_option."\"");
$form_claim2[] =& $form->createElement("text", "name", "", "size=\"44\" $g_text_readonly");
$freeze = $form->addGroup($form_claim2, "form_claim2", "");

if($change_flg == true){
    $freeze->freeze();
}

//�Ҳ������
/*
$form_intro_act[] =& $form->createElement(
        "text","cd","","size=\"7\" maxLength=\"6\"  style=\"$g_form_style\"
        onKeyUp=\"javascript:client(this,'form_intro_act[name]')\" 
        $g_form_option"
        );
*/
//ľ�Ĥξ��Τ�
if($client_data['intro_act_div'] == '3'){
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

$form_intro_act[] =& $form->createElement(
        "text","name","","size=\"34\" 
        $g_text_readonly"
        );
$form->addGroup( $form_intro_act, "form_intro_act", "");

//�Ȳ�����ѥ饸���ܥ���
$form_client_div[] =& $form->createElement("radio", null, null, "FC", "1", "onClick=code_disable(); onChange=client_div();");
$form_client_div[] =& $form->createElement("radio", null, null, "������", "2", "onClick=code_disable(); onChange=client_div();");
$form->addGroup($form_client_div, "form_client_div", "");


//�����������̾
$form->addElement(
        "text","form_trans_account","",'size="34" maxLength="20"'." $g_form_option"
        );

//��Ի�Ź̾
$form->addElement(
        "text","form_bank_fc","",'size="34" maxLength="20"'." $g_form_option"
        );

//�����ֹ�
$form->addElement(
        "text","form_account_num","","size=\"20\" maxLength=\"15\" style=\"$g_form_style\"  $g_form_option"
        );

//������(����̾������)
$form_account[] =& $form->createElement( 
        "checkbox","1" ,"" ,"" ," 
        onClick='return Check_Button2(1);'"
        );
$form_account[] =& $form->createElement(
        "static","��","","������"
        );
$form_account[] =& $form->createElement(
        "text","price","","size=\"11\" maxLength=\"9\"
        $g_form_option
        style=\"text-align: right; $g_form_style\""
        );
$form_account[] =& $form->createElement(
        "static","","","�ߡ�������"
        );
$form_account[] =& $form->createElement( 
        "checkbox","2" ,"" ,"" ," 
        onClick='return Check_Button2(2);'"
        );
$form_account[] =& $form->createElement(
        "static","","","����"
        );
$form_account[] =& $form->createElement(
        "text","rate","","size=\"3\" maxLength=\"3\" 
        $g_form_option
        style=\"text-align: right; $g_form_style\"");
$form_account[] =& $form->createElement(
        "static","","","��"
        );
$form->addGroup( $form_account, "form_account", "");
//ô����Ź
//$where  = " WHERE";
//$where .= "     t_client.client_div = '3'";


//$select_ary = Select_Get($conn,'cshop', $where);
//$form->addElement('select', 'form_cshop',"", $select_ary, $g_form_option_select );
//$select_value = Select_Get($conn,'branch');

$sql  = "SELECT branch_id, branch_cd, branch_name ";
$sql .= "FROM t_branch ";
$sql .= "WHERE ";
$sql .= " shop_id = ".$client_data["shop_id"]." ";
$sql .= " ORDER BY branch_cd";
$sql .= ";";

$result = Db_Query($conn,$sql);
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_charge_branch_id', '��Ź', $select_value,$g_form_option_select);
//$form->addElement("text","form_charge_branch_id","","");


//����ô��1
$sql  = "SELECT ";
$sql .= "    t_staff.staff_id,";
$sql .= "    charge_cd,";
$sql .= "    staff_name ";
$sql .= "FROM ";
$sql .= "    t_staff LEFT JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
$sql .= "WHERE ";
if($client_data[group_kind] == '2'){
    $sql .= "   t_attach.shop_id IN (".Rank_Sql().")";
}else{
    $sql .= "   t_attach.shop_id = $client_data[shop_id] ";
}
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
$form->addElement('select', 'form_c_staff_id1',"", $select_value, $g_form_option_select );
//$form->addElement("text","form_c_staff_id1","","","");

//����ô��2
//$select_ary = Select_Get($conn,'cstaff');
$form->addElement('select', 'form_c_staff_id2',"", $select_value, $g_form_option_select );
//$form->addElement("text","form_c_staff_id2","","","");

//���ô����1
//$select_ary = Select_Get($conn,'cstaff');
//$form->addElement('select', 'form_d_staff_id1',"", $select_ary, $g_form_option_select );

//���ô����2
//$select_ary = Select_Get($conn,'cstaff');
//$form->addElement('select', 'form_d_staff_id2',"", $select_ary, $g_form_option_select );

//���ô����3
//$select_ary = Select_Get($conn,'cstaff');
//$form->addElement('select', 'form_d_staff_id3',"", $select_ary, $g_form_option_select );

//��󳫻���
$form_round_start[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_round_start[y]','form_round_start[m]',4)\" 
        ".$g_form_option."\""
        );
$form_round_start[] =& $form->createElement(
        "static","","","-"
        );
$form_round_start[] =& $form->createElement(
        "text","m","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_round_start[m]','form_round_start[d]',2)\" 
        ".$g_form_option."\""
        );
$form_round_start[] =& $form->createElement(
        "static","","","-"
        );
$form_round_start[] =& $form->createElement(
        "text","d","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        ".$g_form_option."\""
        );
$form->addGroup( $form_round_start,"form_round_start","");

//������
$form->addElement(
        "text","form_col_terms","",'size="34" maxLength="50"'." $g_form_option"
        );

//Ϳ������
$form->addElement(
        "text","form_cledit_limit","","size=\"11\" maxLength=\"9\" class=\"money\"
        $g_form_option 
        style=\"text-align: right; $g_form_style\""
        );

//���ܶ�
$form->addElement(
        "text","form_capital","","size=\"11\" maxLength=\"9\" class=\"money\"
        $g_form_option
        style=\"text-align: right; $g_form_style\""
        );

//�����ʬ
//$select_value = Select_Get($conn,'trade_aord');
//$select_value[11] .= "��(��������������ɬ�ܤȤʤ�ޤ���)";
//$form->addElement('select', 'trade_aord_1', '���쥯�ȥܥå���', $select_value,
//        "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();pay_way()\"");

$where = "WHERE trade_id = '11' OR trade_id = '61'";
$sql = "SELECT trade_id,trade_cd, trade_name ";
$sql .= "FROM t_trade ";
$sql = $sql.$where;
$sql .= " ORDER BY trade_cd";
$sql .= ";";

$result = Db_Query($conn,$sql);
$select_value[""] = "";
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}

$form->addElement('select', 'trade_aord_1', '���쥯�ȥܥå���', $select_value,
        "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();\"");


//����
$select_value = Select_Get($conn,'close');
$form->addElement("select", "form_close", "����", $select_value);

//������
//������
//��
$select_month[null] = null;
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "����";
    }elseif($i == 1){
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
$form->addElement("select", "form_pay_d", "���쥯�ȥܥå���", $select_day, $g_form_option_select);

//��ʧ����ˡ
$select_value = Select_Get($conn, "pay_way");
$form->addElement(
        'select', 'form_pay_way',"", $select_value,$g_form_option_select
        );     

//�������
/*
$select_ary = Select_Get($conn,'bank');
$sql = " WHERE"; 
$sql .= "   t_bank.shop_id = $shop_id";
$ary_b_bank = Select_Get($conn,'b_bank', $sql);
$bank_select = $form->addElement('hierselect', 'form_bank', '',$g_form_option_select 
    ,"</td><td class=\"Title_Purple\"><b>������Ի�Ź</b></td><td class=\"value\">");
$bank_select->setOptions(array($select_ary, $ary_b_bank));
*/
//$select_ary = Make_Ary_Bank($conn);
// ��ԡ���Ź�����¾������SQL
$sql  = "SELECT ";
$sql .= "   t_bank.bank_id, ";
$sql .= "   t_bank.bank_cd, ";
$sql .= "   t_bank.bank_name, ";
$sql .= "   t_b_bank.b_bank_id, ";
$sql .= "   t_b_bank.b_bank_cd, ";
$sql .= "   t_b_bank.b_bank_name, ";
$sql .= "   t_account.account_id, ";
$sql .= "   CASE t_account.deposit_kind ";
$sql .= "       WHEN '1' THEN '����' ";
$sql .= "       WHEN '2' THEN '����' ";
$sql .= "   END ";
$sql .= "   AS deposit, ";
$sql .= "   t_account.account_no ";
$sql .= "FROM ";
$sql .= "   t_bank ";
$sql .= "   INNER JOIN t_b_bank ON t_bank.bank_id = t_b_bank.bank_id ";
$sql .= "   INNER JOIN t_account ON t_b_bank.b_bank_id = t_account.b_bank_id ";
$sql .= "WHERE ";
$sql .= ($client_data["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$client_data["shop_id"]." ";
$sql .= "ORDER BY ";
$sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
$sql .= ";";

$res  = Db_Query($conn, $sql);
$num  = pg_num_rows($res);
// hierselect���������
$ary_hier1[null] = null;
$ary_hier2       = null;
$ary_hier3       = null;
// 1��ʾ夢����
if ($num > 0){

    for ($i=0; $i<$num; $i++){

        // �ǡ��������ʥ쥳�������
        $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

        // ʬ����䤹���褦�˳Ƴ��ؤ�ID���ѿ�������
        $hier1_id = $data_list[$i]["bank_id"];
        $hier2_id = $data_list[$i]["b_bank_id"];
        $hier3_id = $data_list[$i]["account_id"];

        /* ��1��������������� */
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
            // ��1���ؼ��������ƥ�������
//                $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." �� ".htmlspecialchars($data_list[$i]["bank_name"]);
            $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]." �� ".htmlentities($data_list[$i]["bank_name"], ENT_COMPAT, EUC);
        }

        /* ��2��������������� */
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
            // ��2���إ��쥯�ȥ����ƥ�κǽ��NULL������
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                $ary_hier2[$hier1_id][null] = "";
            }
            // ��2���ؼ��������ƥ�������
//                $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." �� ".htmlspecialchars($data_list[$i]["b_bank_name"]);
            $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]." �� ".htmlentities($data_list[$i]["b_bank_name"], ENT_COMPAT, EUC);
        }

        /* ��3��������������� */
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
        // �ޤ��ϡ����߻��ȥ쥳���ɤθ����ֹ�����˻��Ȥ����쥳���ɤθ����ֹ椬�ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"] ||
            $data_list[$i]["account_no"] != $data_list[$i-1]["account_no"]){
            // ��3���إ��쥯�ȥ����ƥ�κǽ��NULL������
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                $ary_hier3[$hier1_id][$hier2_id][null] = "";
            }
            // ��3���ؼ��������ƥ�������
            $ary_hier3[$hier1_id][$hier2_id][$hier3_id] = $data_list[$i]["deposit"]." �� ".$data_list[$i]["account_no"];
        }

    }
$select_ary = array($ary_hier1, $ary_hier2, $ary_hier3);
}else{
    $ary[null] = "";
    $select_ary = array($ary,$ary,$ary);
}

$bank_select = $form->addElement('hierselect', 'form_bank', '',$g_form_option_select ,"������");
$bank_select->setOptions(array($select_ary[0], $select_ary[1], $select_ary[2]));
//$form->addElement("text","form_bank_all","");

//����̾��1
$form->addElement(
        "text","form_pay_name","",'size="34" maxLength="50"'." $g_form_option"
        );

//����̾��
$form->addElement(
        "text","form_account_name","",'size="34" maxLength="15"'." $g_form_option"
        );

//����ǯ����
$form_cont_s_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_s_day[y]','form_cont_s_day[m]',4)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_s_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_s_day[m]','form_cont_s_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_s_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\"  style=\"$g_form_style\"
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_cont_s_day,"form_cont_s_day","");

//����λ��
$form_cont_e_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" 
         style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_e_day[y]','form_cont_e_day[m]',4)\"".$g_form_option."\""
        );
$form_cont_e_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_e_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" 
         style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_e_day[m]','form_cont_e_day[d]',2)\"".$g_form_option."\""
        );
$form_cont_e_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_e_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" 
         style=\"$g_form_style\"".$g_form_option."\""
        );
$form->addGroup( $form_cont_e_day,"form_cont_e_day","");

//�������
$form->addElement(
        "text","form_cont_peri","","size=\"2\" maxLength=\"2\" style=\"text-align: right; $g_form_style\"
        onkeyup=\"Contract(this.form)\" $g_form_option"
        );

//���󹹿���
$form_cont_r_day[] =& $form->createElement(
        "text","y","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_r_day[y]','form_cont_r_day[m]',4)\" 
        onchange=\"Contract(this.form)\" $g_form_option"
        );
$form_cont_r_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_r_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_r_day[m]','form_cont_r_day[d]',2)\" 
        onchange=\"Contract(this.form)\" $g_form_option"
        );
$form_cont_r_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_r_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onchange=\"Contract(this.form)\" $g_form_option"
        );
$form->addGroup( $form_cont_r_day,"form_cont_r_day","");

//�϶���
$form_establish_day[] =& $form->createElement(
        "text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_establish_day[y]','form_establish_day[m]',4)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_establish_day[] =& $form->createElement(
        "text","m","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_establish_day[m]','form_establish_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_establish_day[] =& $form->createElement(
        "text","d","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_establish_day,"form_establish_day","form_establish_day");

//��ɼȯ��
$form_slip_out[] =& $form->createElement( "radio",NULL,NULL, "ͭ","1");
$form_slip_out[] =& $form->createElement( "radio",NULL,NULL, "̵","2");
$form->addGroup($form_slip_out, "form_slip_out", "");

//Ǽ�ʽ񥳥���
//��¥��ܥ���
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "������̵��","1");
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "���̥�����ͭ��","2");
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "���Υ�����ͭ��","3");
$form->addGroup($form_deliver_radio, "form_deliver_radio", "");
//�ƥ�����
$form->addElement(
        "textarea","form_deliver_note","",' rows="5" cols="75"'." $g_form_option_area"
        );


//�����ȯ��
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "���������","1");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "��������","2");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "�������������", "5");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "���Ϥ��ʤ�","3");
$form_claim_out[] =& $form->createElement( "radio",NULL,NULL, "����",      "4");

$form->addGroup($form_claim_out, "form_claim_out", "");
/*
//�����ϰ�
$form_claim_scope[] =& $form->createElement( "radio",NULL,NULL, "���۳ۤ�ޤ��","t");
$form_claim_scope[] =& $form->createElement( "radio",NULL,NULL, "���۳ۤ�ޤ�ʤ�","f");
$form->addGroup($form_claim_scope, "form_claim_scope", "");
*/

//���������
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "͹��","1");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "�᡼��","2");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "WEB","4");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "͹�����᡼��","3");
$form->addGroup($form_claim_send, "form_claim_send", "");

//����񥳥���
$form->addElement(
        "textarea","form_claim_note","",' rows="5" cols="75"'." $g_form_option_area"
        );

//�ɾ�
$form_prefix_radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$form_prefix_radio[] =& $form->createElement( "radio",NULL,NULL, "��","2");
$form->addGroup($form_prefix_radio,"form_prefix","");
     
//���
//�ݤ��ʬ
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ڼ�","1");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ͼθ���","2");
$form_coax[] =& $form->createElement( "radio",NULL,NULL, "�ھ�","3");
$form->addGroup($form_coax, "form_coax", "");

//����ñ��
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "��ɼñ��","2");
$form_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����ñ��","1");
$form->addGroup($form_tax_div, "form_tax_div", "");

//ü����ʬ
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ڼ�","1");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ͼθ���","2");
$form_tax_franct[] =& $form->createElement( "radio",NULL,NULL, "�ھ�","3");
$form->addGroup($form_tax_franct, "form_tax_franct", "");

//���Ƕ�ʬ
$form_c_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
#2009-12-25 aoyama-n
#$form_c_tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$form->addGroup($form_c_tax_div, "form_c_tax_div", "");

//����������������¾
$form->addElement(
        "textarea","form_note","",' rows="3" cols="75"'." $g_form_option_area"
        );

//�������
$form->addElement(
        "textarea","form_record","",' rows="3" cols="75"'." $g_form_option_area"
        );

//���׻���
$form->addElement(
        "textarea","form_important","",' rows="3" cols="75"'." $g_form_option_area"
        );

//hidden
$form->addElement("hidden", "input_button_flg");
$form->addElement("hidden", "ok_button_flg");

//�����ɼ�ͼ�
//$select_value = Select_Get($conn,'pattern');
$select_value="";
$where  = " WHERE";
if($client_data["group_kind"] == "2"){
    $where .= "    shop_id IN (".Rank_Sql().")";
}else{
    $where .= "     shop_id = ".$client_data["shop_id"];
}
$sql = "SELECT s_pattern_id, s_pattern_no, s_pattern_name ";
$sql .= "FROM t_slip_sheet ";
$sql = $sql.$where;
$sql .= " ORDER BY s_pattern_no";
$sql .= ";";

$result = Db_Query($conn,$sql);
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $data_list[2] = htmlspecialchars($data_list[2]);
    $select_value[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement("select","sale_pattern","",$select_value);

//������ͼ�
//$select_value = Select_Get($conn,'claim_pattern');
$select_value = "";
$sql = "SELECT c_pattern_id,c_pattern_name ";
$sql .= "FROM t_claim_sheet ";
$sql = $sql.$where;
$sql .= " ORDER BY c_pattern_id";
$sql .= ";";
$result = Db_Query($conn,$sql);
while($data_list = pg_fetch_array($result)){
    $data_list[0] = htmlspecialchars($data_list[0]);
    $data_list[1] = htmlspecialchars($data_list[1]);
    $select_value[$data_list[0]] = $data_list[1];
}
$form->addElement("select","claim_pattern","",$select_value);

//���������������裱��
for($i = 0; $i < 12; $i++){
    $form->addElement("checkbox", "claim1_monthly_check[$i]","", ($i+1)."��");
}  

/****************************/
//�롼�����
/****************************/
$form->registerRule("telfax","function","Chk_Telfax");
//���϶�
//��ɬ�ܥ����å�
$form->addRule("form_area_id", "�϶�����򤷤Ʋ�������","required");

//���ȼ�
//��ɬ�ܥ����å�
$form->addRule("form_btype", "�ȼ�����򤷤Ʋ�������","required");

$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
/*
//��FC���롼��
//��ɬ�ܥ����å�
$form->addRule("form_shop_gr_1", "FC���롼�פ����򤷤Ƥ���������","required");
*/

//�������襳����
//��ɬ�ܥ����å�
$form->addGroupRule('form_client', array(
        'cd1' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', 'required')
        ),      
        'cd2' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���','required')
        ),      
));

//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_client', array(
        'cd1' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),      
        'cd2' => array(
                array('�����襳���ɤ�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),      
));

//��������̾
//��ɬ�ܥ����å�
$form->addRule("form_client_name", "������̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_client_name", "������̾�� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//��ά��
//��ɬ�ܥ����å�
$form->addRule("form_client_cname", "ά�Τ�1ʸ���ʾ�20ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->addRule("form_client_cname", "ά�Τ� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//��͹���ֹ�
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
//��ʸ���������å�
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', 'required'),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "regex", "/^[0-9]+$/"),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���','required'),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���',"regex", "/^[0-9]+$/"),
                array('͹���ֹ��Ⱦ�ѿ����Τ�7��Ǥ���', "rangelength", array(4,4))
        ),
));

//�����꣱
//��ɬ�ܥ����å�
$form->addRule("form_address1", "���꣱��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");

//��TEL
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule(form_tel, "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "required");
$form->addRule("form_tel","TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

//����ɽ�Ի�̾
//��ɬ�ܥ����å�
$form->addRule("form_rep_name", "��ɽ�Ի�̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//���Ʋ���϶���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_parent_establish_day', array(
        'y' => array(
                array('�Ʋ�Ҥ��϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�Ʋ�Ҥ��϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('�Ʋ�Ҥ��϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

//���ĶȻ���
//���������ϻ���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_stime1', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),
));

//��������λ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_etime1', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),
));

//����峫�ϻ���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_stime2', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),
));

//����彪λ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_trade_etime2', array(
        'h' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�ĶȻ��֤�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),
));

//��������
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_account', array(
        'price' => array(
                array('��������Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),
        'rate' => array(
                array('��������Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),
));

//��ô����Ź
//�����ϥ����å�
$form->addRule("form_charge_branch_id", "ô����Ź�����򤷤Ʋ�������","required");

//��Ϳ������
//��Ⱦ�ѿ��������å�
$form->addRule("form_cledit_limit", "Ϳ�����٤�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//�����ܶ�
//��Ⱦ�ѿ��������å�
$form->addRule("form_capital", "���ܶ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//���������ʷ��
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_m", "�������ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_pay_m", "�������ʷ�ˤ�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//��������������
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_d", "�����������ˤ�Ⱦ�ѿ����ΤߤǤ���", "required");
$form->addRule("form_pay_d", "�����������ˤ�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");


//������ǯ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));
//������λ��
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_e_day', array(
        'y' => array(
                array('����λ�������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('����λ�������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));
//�����󹹿���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

//���϶���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_establish_day', array(
        'y' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('�϶��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

//�������ʬ
//��ɬ�ܥ����å�
$form->addRule("trade_aord_1", "�����ʬ�����򤷤Ʋ�������","required");

//��Ǽ�ʽ񥳥���
//��Ⱦ�ѿ��������å�
$form->addRule("form_deliver_note", "Ǽ�ʽ񥳥��Ȥ�50ʸ������Ǥ���", "mb_maxlength",'50');

//���������
//��Ⱦ�ѿ��������å�
$form->addRule("form_cont_peri", "������֤�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//����󳫻���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_round_start', array(
        'y' => array(
                array('��󳫻��������դ������ǤϤ���ޤ���', "regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('��󳫻��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('��󳫻��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

/***************************/
//�롼�������PHP��
/***************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ"){
    /****************************/
    //POST����
    /****************************/
//    $shop_gr        = $_POST["form_shop_gr_1"];                 //FC���롼��
    $client_cd1         = $_POST["form_client"]["cd1"];             //�����襳���ɣ�
    $client_cd2         = $_POST["form_client"]["cd2"];             //�����襳���ɣ�
    $state              = $_POST["form_state"];                     //����
    $state_fc           = $_POST["form_state_fc"];
    $client_name        = $_POST["form_client_name"];               //������̾
    $client_read        = $_POST["form_client_read"];               //������̾�ʥեꥬ�ʡ�
    $client_name2       = $_POST["form_client_name2"];              //������̾2
    $client_read2       = $_POST["form_client_read2"];              //������̾2�ʥեꥬ�ʡ�
    $client_cname       = $_POST["form_client_cname"];              //ά��
    $cname_read         = $_POST["form_cname_read"];                //ά�Ρʥեꥬ�ʡ�
    $post_no1           = $_POST["form_post"]["no1"];               //͹���ֹ棱
    $post_no2           = $_POST["form_post"]["no2"];               //͹���ֹ棲
    $address1           = $_POST["form_address1"];                  //���꣱
    $address2           = $_POST["form_address2"];                  //���ꣲ
    $address3           = $_POST["form_address3"];                  //����3
    $address_read       = $_POST["form_address_read"];              //���꣱�ʥեꥬ�ʡ�
    $area_id            = $_POST["form_area_id"];                   //�϶襳����
    $tel                = $_POST["form_tel"];                       //TEL
    $fax                = $_POST["form_fax"];                       //FAX
    $rep_name           = $_POST["form_rep_name"];                  //��ɽ�Ի�̾

/*20060420�ɲ�*/
    $charger1           = $_POST["form_charger1"];                  //��ô���ԣ�
    $charger2           = $_POST["form_charger2"];                  //��ô���ԣ�
    $charger3           = $_POST["form_charger3"];                  //��ô���ԣ�
    $charger_represe1   = $_POST["form_charger_represe1"];          //��ô�����򿦣�
    $charger_represe2   = $_POST["form_charger_represe2"];          //��ô�����򿦣�
    $charger_represe3   = $_POST["form_charger_represe3"];          //��ô�����򿦣�
    $charger_part1      = $_POST["form_charger_part1"];             //��ô��������
    $charger_part2      = $_POST["form_charger_part2"];             //��ô��������
    $charger_part3      = $_POST["form_charger_part3"];             //��ô��������
    $charger_note       = $_POST["form_charger_note"];              //��ô��������
/**************/

    $trade_stime1       = str_pad($_POST["form_trade_stime1"]["h"],2,0,STR_PAD_LEFT);         //�ĶȻ��֡ʸ������ϡ�
    $trade_stime1      .= ":"; 
    $trade_stime1      .= str_pad($_POST["form_trade_stime1"]["m"],2,0,STR_PAD_LEFT);
    $trade_etime1       = str_pad($_POST["form_trade_etime1"]["h"],2,0,STR_PAD_LEFT);         //�ĶȻ��֡ʸ�����λ��
    $trade_etime1      .= ":"; 
    $trade_etime1      .= str_pad($_POST["form_trade_etime1"]["m"],2,0,STR_PAD_LEFT);
    $trade_stime2       = str_pad($_POST["form_trade_stime2"]["h"],2,0,STR_PAD_LEFT);         //�ĶȻ��֡ʸ�峫�ϡ�
    $trade_stime2      .= ":"; 
    $trade_stime2      .= str_pad($_POST["form_trade_stime2"]["m"],2,0,STR_PAD_LEFT);
    $trade_etime2       = str_pad($_POST["form_trade_etime2"]["h"],2,0,STR_PAD_LEFT);         //�ĶȻ��֡ʸ�彪λ��
    $trade_etime2      .= ":"; 
    $trade_etime2      .= str_pad($_POST["form_trade_etime2"]["m"],2,0,STR_PAD_LEFT);
    $holiday            = $_POST["form_holiday"];                   //����
    $btype              = $_POST["form_btype"];                     //�ȼ拾����
    $b_struct           = $_POST["form_b_struct"];                  //����
    $claim_cd1          = $_POST["form_claim"]["cd1"];              //�����襳���ɣ�
    $claim_cd2          = $_POST["form_claim"]["cd2"];              //�����襳���ɣ�
    $claim_name         = $_POST["form_claim"]["name"];             //������̾
    $intro_act_cd       = $_POST["form_intro_act"]["cd"];           //�Ҳ�����襳����
    $intro_act_name     = $_POST["form_intro_act"]["name"];         //�Ҳ������̾
    $price_check        = $_POST["form_account"]["1"];
    $account_price      = $_POST["form_account"]["price"];          //������
    $rate_check         = $_POST["form_account"]["2"];
    $account_rate       = $_POST["form_account"]["rate"];           //����Ψ
//    $cshop_id           = $_POST["form_cshop"];                     //ô����Ź
    $charge_branch_id       = $_POST["form_charge_branch_id"];          // ô����Ź
    $c_staff_id1        = $_POST["form_c_staff_id1"];               //����ô����
    $c_staff_id2        = $_POST["form_c_staff_id2"];               //����ô����
//    $d_staff_id1        = $_POST["form_d_staff_id1"];               //���ô����
//    $d_staff_id2        = $_POST["form_d_staff_id2"];               //���ô����
//    $d_staff_id3        = $_POST["form_d_staff_id3"];               //���ô����
    $col_terms          = $_POST["form_col_terms"];                 //������
    $cledit_limit       = $_POST["form_cledit_limit"];              //Ϳ������
    $capital            = $_POST["form_capital"];                   //���ܶ�
    $trade_id           = $_POST["trade_aord_1"];                   //�����ʬ
    $close_day_cd       = $_POST["form_close"];                     //����
    $pay_m              = $_POST["form_pay_m"];                     //�������ʷ��
    $pay_d              = $_POST["form_pay_d"];                     //������������
    $pay_way            = $_POST["form_pay_way"];                   //������ˡ
//    $bank_enter_cd      = $_POST["form_bank"][1];                   //��ԸƽХ�����
    $bank_enter_cd          = $_POST["form_bank"][2];
    $pay_name           = $_POST["form_pay_name"];                  //����̾��
    $account_name       = $_POST["form_account_name"];              //����̾��
    $cont_s_day         = $_POST["form_cont_s_day"]["y"];           //���󳫻���
    $cont_s_day        .= "-"; 
    $cont_s_day        .= $_POST["form_cont_s_day"]["m"];
    $cont_s_day        .= "-"; 
    $cont_s_day        .= $_POST["form_cont_s_day"]["d"];
    $cont_e_day         = $_POST["form_cont_e_day"]["y"];            //����λ��
    $cont_e_day        .= "-"; 
    $cont_e_day        .= $_POST["form_cont_e_day"]["m"];
    $cont_e_day        .= "-"; 
    $cont_e_day        .= $_POST["form_cont_e_day"]["d"];
    $cont_peri          = $_POST["form_cont_peri"];                 //�������
    $cont_r_day         = $_POST["form_cont_r_day"]["y"];            //���󹹿���
    $cont_r_day        .= "-"; 
    $cont_r_day        .= $_POST["form_cont_r_day"]["m"];
    $cont_r_day        .= "-"; 
    $cont_r_day        .= $_POST["form_cont_r_day"]["d"];
    $slip_out           = $_POST["form_slip_out"];                  //��ɼȯ��
    $deliver_note       = $_POST["form_deliver_note"];              //Ǽ�ʽ񥳥���
    $claim_out          = $_POST["form_claim_out"];                 //�����ȯ��
    $coax               = $_POST["form_coax"];                      //��ۡ��ݤ��ʬ
    $tax_div            = $_POST["form_tax_div"];                   //�����ǡ�����ñ��
    $tax_franct         = $_POST["form_tax_franct"];                //�����ǡ�ü����ʬ
    $note               = $_POST["form_note"];                      //����������������¾
    $email              = $_POST["form_email"];                     //Email
    $url                = $_POST["form_url"];                       //URL
    $represent_cell     = $_POST["form_represent_cell"];            //��ɽ�Է���
    $represe            = $_POST["form_rep_position"];              //��ɽ����
    $bstruct            = $_POST["form_bstruct"];                   //����
    $inst               = $_POST["form_inst"];                      //����
    $establish_day      = $_POST["form_establish_day"]["y"];        //�϶���
    $establish_day     .= "-"; 
    $establish_day     .= $_POST["form_establish_day"]["m"];
    $establish_day     .= "-"; 
    $establish_day     .= $_POST["form_establish_day"]["d"];
    $record             = $_POST["form_record"];                    //�������
    $important          = $_POST["form_important"];                 //���׻���
    $trans_account      = $_POST["form_trans_account"];             //�����������̾
    $bank_fc            = $_POST["form_bank_fc"];                   //���/��Ź̾
    $account_num        = $_POST["form_account_num"];               //�����ֹ�
    $round_start        = $_POST["form_round_start"]["y"];          //��󳫻���
    $round_start       .= "-"; 
    $round_start       .= $_POST["form_round_start"]["m"];
    $round_start       .= "-"; 
    $round_start       .= $_POST["form_round_start"]["d"];
    $deliver_radio      = $_POST["form_deliver_radio"];             //Ǽ�ʽ񥳥���(����
    $claim_send         = $_POST["form_claim_send"];                //���������(͹��)
    $company_name       = $_POST["form_company_name"];              //�Ʋ��̾
    $company_tel        = $_POST["form_company_tel"];               //�Ʋ��TEL
    $company_address    = $_POST["form_company_address"];           //�Ʋ�ҽ���
    $bank_div           = $_POST["form_bank_div"];                  //��Լ������ô��ʬ
    $claim_note         = $_POST["form_claim_note"];                //����񥳥���
    $client_slip1       = $_POST["form_client_slip1"];              //�����裱��ɼ����
    $client_slip2       = $_POST["form_client_slip2"];              //�����裲��ɼ����
    $parent_rep_name    = $_POST["form_parent_rep_name"];           //�Ʋ����ɽ��̾
    $parent_establish_day  = $_POST["form_parent_establish_day"]["y"];
    $parent_establish_day .= "-";
    $parent_establish_day .= $_POST["form_parent_establish_day"]["m"];
    $parent_establish_day .= "-";
    $parent_establish_day .= $_POST["form_parent_establish_day"]["d"];
    $type               = $_POST["form_type"];                      //����
    //$claim_scope        = $_POST["form_claim_scope"];               //�����ϰ�
    $compellation       = $_POST["form_prefix"];                    //�ɾ�
    $c_tax_div          = $_POST["form_c_tax_div"];                 //���Ƕ�ʬ

    //���顼Ƚ�̥ե饰
    $err_flg = false;
    /****************************/
    //�����������å��ܥå���Ƚ��
    /****************************/
    if($price_check == 1){
        $check_which = 1;
    }else if($rate_check == 1){
        $check_which = 2;
    }else{
        $check_which = 0;
    }

    /***************************/
    //�����
    /***************************/
    //�����襳���ɣ�
    $client_cd1 = str_pad($client_cd1, 6, 0, STR_POS_LEFT);

    //�����襳���ɣ�
    $client_cd2 = str_pad($client_cd2, 4, 0, STR_POS_LEFT);

    if(($client_cd1 != null && $client_data[0] != $client_cd1) || ( $client_cd2 != null && $client_data[1] != $client_cd2)){
        $client_cd_sql  = "SELECT";
        $client_cd_sql  .= " client_id FROM t_client";
        $client_cd_sql  .= " WHERE";
        $client_cd_sql  .= " client_cd1 = '$client_cd1'";
        $client_cd_sql  .= " AND";
        $client_cd_sql  .= " client_cd2 = '$client_cd2'";
        $client_cd_sql  .= " AND";
        $client_cd_sql .= "  (t_client.client_div = '1'";
        $client_cd_sql .= "  OR";
        $client_cd_sql .= "  t_client.client_div = '3')";
        $client_cd_sql  .= ";";
        $select_client = Db_Query($conn, $client_cd_sql);
        $select_client = pg_num_rows($select_client);
        if($select_client != 0){
            $client_cd_err = "���Ϥ��줿�����襳���ɤϻ�����Ǥ���";
            $err_flg = true;
        }
    }

    //��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+-?[0-9]+-?[0-9]+$",$tel)){
        $tel_err = "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //��FAX
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_fax","FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+-?[0-9]+-?[0-9]+$",$fax) && $fax != null){
        $fax_err = "FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //��Email
    if (!(ereg("^[^@]+@[^.]+\..+", $email)) && $email != "") {
        $email_err = "Email�������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //��URL
    //�����ϥ����å�
    if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null) {
        $url_err = "������URL�����Ϥ��Ʋ�������";
        $err_flg = true;
    }

    //����ɽ�Է���
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$represent_cell) && $represent_cell != ""){
        $rep_cell_err = "��ɽ�Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //���Ʋ��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_company_tel","�Ʋ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");
/*
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+-?[0-9]+-?[0-9]+$",$company_tel) && $company_tel != ""){
        $company_tel_err = "�Ʋ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���";
        $err_flg = true;
    }
*/

    //������
    //��ɬ�ܥ����å�
    if($_POST["form_close"] == 0){
        $close_err = "���������򤷤Ʋ�������";
        $err_flg = true;
    }

    //�������ʷ�ˤ��������������ʧ�������ˤ���礭�����
    if($_POST["form_pay_m"] == "0" && ($_POST["form_close"] >= $_POST["form_pay_d"])){
        $close_err = "��ʧ���ʷ�ˤ���������򤷤�����������꾮������ʧ�������ˤ����򤷤Ʋ�������";
        $err_flg = true;
    }
    
    //��������
    //�����ϥ����å�
    //������˼��Ҥ����ꤷ�����
    if($_POST["form_client"]["cd1"] == $_POST["form_claim"]["cd1"] && $_POST["form_client"]["cd2"] == $_POST["form_claim"]["cd2"]){
        $claim_flg = true;
    //��������������ͤ����ꤷ�����
    }elseif(
        ($_POST["form_claim"]["cd1"] != null || $_POST["form_claim"]["cd2"] != null || $_POST["form_claim"]["name"] != null)
        &&      
        ($_POST["form_claim"]["cd1"] == null || $_POST["form_claim"]["cd2"] == null || $_POST["form_claim"]["name"] == null)
    ){
        $claim_err = "�����������襳���ɤ����Ϥ��Ʋ�������";
        $err_flg = true;
    //�������¾�Ҥ����ꤷ�����
    }elseif($claim_cd1 != null && $claim_cd2 != null && $claim_name){
        $sql  = "SELECT";
        $sql .= "   close_day,";
        $sql .= "   coax,";
        $sql .= "   tax_div,";
        $sql .= "   tax_franct,";
        $sql .= "   c_tax_div";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= " WHERE";
        $sql .= "   client_cd1 = '$claim_cd1'";
        $sql .= "   AND";
        $sql .= "   client_cd2 = '$claim_cd2'";
        $sql .= "   AND";
        $sql .= "   client_div = '1'";
        $sql .= "   AND";
        $sql .= "   shop_id = $shop_id";
        $sql .= ";"; 

        $result = Db_Query($conn ,$sql);
        $claim_data = pg_fetch_array($result,0);

        $claim_close_day  = $claim_data["close_day"];
        $claim_coax       = $claim_data["coax"];
        $claim_tax_div    = $claim_data["tax_div"];
        $claim_tax_franct = $claim_data["tax_franct"];        
        $claim_c_tax_div  = $claim_data["tax_div"];

        if($close_day_cd != $claim_close_day){
			//����Ƚ��
			if($claim_close_day == "29"){
				$claim_err = "�������������Ʊ�� ���� �����򤷤Ʋ�������";
			}else{
				$claim_err = "�������������Ʊ�� ".$claim_close_day."�� �����򤷤Ʋ�������";
			}
            $err_flg = true;
        }else{
            $claim_flg = true;
        }

        //������δݤ��ʬ��Ʊ���ǤϤʤ�����������
        if($coax != $claim_coax){
            //���顼��å�������ɽ�����뤿��ݤ��ʬ���ִ�
            if($claim_coax == '1'){
                $claim_coax = "�ڼ�";
            }elseif($claim_coax == '2'){
                $claim_coax = "�ͼθ���";
            }elseif($claim_coax == '3'){
                $claim_coax = "�ھ�";
            }

            $claim_coax_err = "�ޤ���ʬ���������Ʊ�� ".$claim_coax." �����򤷤Ʋ�������";
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

            $claim_tax_div_err = "����ñ�̤��������Ʊ�� ".$claim_tax_div." �����򤷤Ʋ�������";
            $err_flg = true;
        }

        //�������ü����Ʊ���Ǥʤ�����������
        if($tax_franct != $claim_tax_franct){
            //���顼��å�������ɽ�����뤿��ü�����ִ�
            if($claim_tax_franct == '1'){
                $claim_tax_franct = "�ڼ�";
            }elseif($claim_tax_franct == '2'){
                $claim_tax_franct = "�ͼθ���";
            }elseif($claim_tax_franct == '3'){
                $claim_tax_franct = "�ھ�";
            }

            $claim_tax_franct_err = "ü�����������Ʊ�� ".$claim_tax_franct." �����򤷤Ʋ�������";
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

            $claim_c_tax_div_err = "���Ƕ�ʬ���������Ʊ�� ".$claim_c_tax_div." �����򤷤Ʋ�������";
            $err_flg = true; 

        }       
    }

    //���Ҳ������
    //�����ϥ����å�
    if($_POST["form_intro_act"]["cd"] != null && $_POST["form_intro_act"]["name"] == null){
        $intro_act_err = "�������Ҳ�����襳���ɤ����Ϥ��Ʋ�������";
        $err_flg = true;
    }
    
    //������ǯ���������󹹿���
    //�����դ������������å�
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
    $parent_esday_y = $_POST["form_parent_establish_day"]["y"];
    $parent_esday_m = $_POST["form_parent_establish_day"]["m"];
    $parent_esday_d = $_POST["form_parent_establish_day"]["d"];
	$ceday_y = $_POST["form_cont_e_day"]["y"];
	$ceday_m = $_POST["form_cont_e_day"]["m"];
	$ceday_d = $_POST["form_cont_e_day"]["d"];

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

    //�Ʋ���϶������������������å�
	//��������
    //��ʸ��������å�
    if($parent_esday_y != null || $parent_esday_m != null || $parent_esday_d != null){
        $parent_esday_y = (int)$parent_esday_y;
        $parent_esday_m = (int)$parent_esday_m;
        $parent_esday_d = (int)$parent_esday_d;
        if(!checkdate($parent_esday_m,$parent_esday_d,$parent_esday_y)){
			$parent_esday_err = "�Ʋ���϶��������դ������ǤϤ���ޤ���";
        	$err_flg = true;
        }
    }

	//����λ�����������������å�
	//������λ��
    //��ʸ��������å�
    if($ceday_y != null || $ceday_m != null || $ceday_d != null){
        $ceday_y = (int)$ceday_y;
        $ceday_m = (int)$ceday_m;
        $ceday_d = (int)$ceday_d;
        if(!checkdate($ceday_m,$ceday_d,$ceday_y)){
			$cont_e_day_err = "����λ�������դ������ǤϤ���ޤ���";
        	$err_flg = true;
        }
    }

    //�����󹹿���������ǯ�����������Ǥʤ��������å�
    if($cont_s_day >= $cont_r_day && $cont_s_day != '--' && $cont_r_day != '--'){
        $csday_rday_err = "���󹹿��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }
}
    //���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
if($_POST["button"]["entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true ){
    /******************************/
    //DB��Ͽ����
    /******************************/
    $create_day = date("Y-m-d");
    /******************************/
    //��Ͽ����
    /******************************/
    if($new_flg == true){
        Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                        //������ID
        $insert_sql .= "    client_cd1,";                       //�����襳����
        $insert_sql .= "    client_cd2,";                       //��Ź������
        $insert_sql .= "    shop_id,";                          //FC���롼��ID
        $insert_sql .= "    create_day,";                       //������
        $insert_sql .= "    state,";                            //����
        $insert_sql .= "    client_name,";                      //������̾
        $insert_sql .= "    client_read,";                      //������̾�ʥեꥬ�ʡ�
        $insert_sql .= "    client_name2,";                     //������̾2
        $insert_sql .= "    client_read2,";                     //������̾2�ʥեꥬ�ʡ�
        $insert_sql .= "    client_cname,";                     //ά��
        $insert_sql .= "    post_no1,";                         //͹���ֹ棱
        $insert_sql .= "    post_no2,";                         //͹���ֹ棲
        $insert_sql .= "    address1,";                         //���꣱
        $insert_sql .= "    address2,";                         //���ꣲ
        $insert_sql .= "    address3,";                         //����3
        $insert_sql .= "    address_read,";                     //����ʥեꥬ�ʡ�
        $insert_sql .= "    area_id,";                          //�϶�ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //��ɽ�Ի�̾
        $insert_sql .= "    c_staff_id1,";                      //����ô����
        $insert_sql .= "    c_staff_id2,";                      //����ô����
//        $insert_sql .= "    d_staff_id1,";                      //���ô����
//        $insert_sql .= "    d_staff_id2,";                      //���ô����
//        $insert_sql .= "    d_staff_id3,";                      //���ô����

/*20060420�ɲ�*/
        $insert_sql .= "    charger1,";                         //��ô���ԣ�
        $insert_sql .= "    charger2,";                         //��ô���ԣ�
        $insert_sql .= "    charger3,";                         //��ô���ԣ�
        $insert_sql .= "    charger_part1,";                    //��ô��������
        $insert_sql .= "    charger_part2,";                    //��ô��������
        $insert_sql .= "    charger_part3,";                    //��ô��������
        $insert_sql .= "    charger_represe1,";                 //��ô��������
        $insert_sql .= "    charger_represe2,";                 //��ô��������
        $insert_sql .= "    charger_represe3,";                 //��ô��������
        $insert_sql .= "    charger_note,";                     //��ô��������
/***************/
        $insert_sql .= "    trade_stime1,";                     //�ĶȻ��֡ʸ������ϡ�
        $insert_sql .= "    trade_etime1,";                     //�ĶȻ��֡ʸ�����λ��
        $insert_sql .= "    trade_stime2,";                     //�ĶȻ��֡ʸ�峫�ϡ�
        $insert_sql .= "    trade_etime2,";                     //�ĶȻ��֡ʸ�彪λ��
        $insert_sql .= "    sbtype_id,";                        //�ȼ�ID
        $insert_sql .= "    holiday,";                          //����
        $insert_sql .= "    close_day,";                        //����
        $insert_sql .= "    trade_id,";                          //�����ʬ
        $insert_sql .= "    pay_m,";                            //�������ʷ��
        $insert_sql .= "    pay_d,";                            //������������
        $insert_sql .= "    pay_way,";                          //������ˡ
        $insert_sql .= "    account_name,";                     //����̾��
        $insert_sql .= "    pay_name,";                         //����̾��
        $insert_sql .= "    b_bank_id,";                        //���ID
        $insert_sql .= "    slip_out,";                         //��ɼ����
        $insert_sql .= "    deliver_note,";                     //Ǽ�ʽ񥳥���
        $insert_sql .= "    claim_out,";                        //��������
        $insert_sql .= "    coax,";                             //��ۡ��ݤ��ʬ
        $insert_sql .= "    tax_div,";                          //�����ǡ�����ñ��
        $insert_sql .= "    tax_franct,";                       //�����ǡ�ü����ʬ
        $insert_sql .= "    cont_sday,";                        //���󳫻���
        $insert_sql .= "    cont_eday,";                        //����λ��
        $insert_sql .= "    cont_peri,";                        //�������
        $insert_sql .= "    cont_rday,";                        //���󹹿���
        $insert_sql .= "    col_terms,";                        //������
        $insert_sql .= "    credit_limit,";                     //Ϳ������
        $insert_sql .= "    capital,";                          //���ܶ�
        $insert_sql .= "    note,";                             //����������/����¾
        $insert_sql .= "    client_div,";                       //�������ʬ
        //������������ΨȽ��
        if($price_check == 1){
            $insert_sql .= "    intro_ac_price,";               //������
        }else if($rate_check == 1){
            $insert_sql .= "    intro_ac_rate,";                //����Ψ
        }
        $insert_sql .= "    email,";                            //Email
        $insert_sql .= "    url,";                              //URL
        $insert_sql .= "    rep_htel,";                         //��ɽ�Է���
        $insert_sql .= "    b_struct,";                         //����
        $insert_sql .= "    inst_id,";                          //����
        $insert_sql .= "    establish_day,";                    //�϶���
        $insert_sql .= "    deal_history,";                     //�������
        $insert_sql .= "    importance,";                       //���׻���
        $insert_sql .= "    intro_ac_name,";                    //�����������̾
        $insert_sql .= "    intro_bank,";                       //���/��Ź̾
        $insert_sql .= "    intro_ac_num,";                     //�����ֹ�
        $insert_sql .= "    round_day,";                        //��󳫻���
        $insert_sql .= "    deliver_effect,";                   //Ǽ�ʽ񥳥���(����)
        $insert_sql .= "    claim_send,";                       //���������(͹��)
        $insert_sql .= "    client_cread,";                     //ά��(�եꥬ��)
        $insert_sql .= "    represe,";                          //��ɽ����
        $insert_sql .= "    shop_name,";
        $insert_sql .= "    shop_div,";
        $insert_sql .= "    royalty_rate,";
        $insert_sql .= "    tax_rate_n,";
        $insert_sql .= "    company_name,";                     //�Ʋ��̾
        $insert_sql .= "    company_tel,";                      //�Ʋ��TEL
        $insert_sql .= "    company_address,";                  //�Ʋ�ҽ���
        $insert_sql .= "    bank_div,";                         //��Լ������ô��ʬ
        $insert_sql .= "    claim_note,";                       //����񥳥���
        $insert_sql .= "    client_slip1,";
        $insert_sql .= "    client_slip2,";
        $insert_sql .= "    parent_establish_day,";
        $insert_sql .= "    parent_rep_name,";
        $insert_sql .= "    type,";                             //����
        $insert_sql .= "    compellation,";                     //�ɾ�
        //$insert_sql .= "    claim_scope";                       //�����ϰ�
		$insert_sql .= "    intro_ac_div, ";                     // ���¶�ʬ
        $insert_sql .= "    c_tax_div";                         //���Ƕ�ʬ
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd1',";                    //�����襳����
        $insert_sql .= "    '$client_cd2',";                    //��Ź������
        $insert_sql .= "    $shop_id,";                         //FC���롼��ID
        $insert_sql .= "    NOW(),";                            //������
        $insert_sql .= "    '$state',";                         //����
        $insert_sql .= "    '$client_name',";                   //������̾
        $insert_sql .= "    '$client_read',";                   //������ʥեꥬ�ʡ�
        $insert_sql .= "    '$client_name2',";                  //������̾2
        $insert_sql .= "    '$client_read2',";                  //������2�ʥեꥬ�ʡ�
        $insert_sql .= "    '$client_cname',";                  //ά��
        $insert_sql .= "    '$post_no1',";                      //͹���ֹ棱
        $insert_sql .= "    '$post_no2',";                      //͹���ֹ棲
        $insert_sql .= "    '$address1',";                      //���꣱
        $insert_sql .= "    '$address2',";                      //���ꣲ
        $insert_sql .= "    '$address3',";                      //���ꣲ
        $insert_sql .= "    '$address_read',";                  //����ʥեꥬ�ʡ�
        $insert_sql .= "    $area_id,";                         //�϶�ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$rep_name',";                      //��ɽ�Ի�̾
        if($c_staff_id1 == ""){
                $c_staff_id1 = "    null"; 
        }
        if($c_staff_id2 == ""){
                $c_staff_id2 = "    null"; 
        }
//        if($d_staff_id1 == ""){
//                $d_staff_id1 = "    null";
//        }
//        if($d_staff_id2 == ""){
//                $d_staff_id2 = "    null";
//        }
//        if($d_staff_id3 == ""){
//                $d_staff_id3 = "    null";
//        }
        $insert_sql .= "    $c_staff_id1,";                    //����ô����
        $insert_sql .= "    $c_staff_id2,";                    //����ô����
//        $insert_sql .= "    $d_staff_id1,";                    //���ô����
//        $insert_sql .= "    $d_staff_id2,";                    //���ô����
//        $insert_sql .= "    $d_staff_id3,";                    //���ô����
 
/*20060420�ɲ�*/
        $insert_sql .= "    '$charger1',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger2',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger3',";                     //��ô���ԣ�
        $insert_sql .= "    '$charger_part1',";                //��ô��������
        $insert_sql .= "    '$charger_part2',";                //��ô��������
        $insert_sql .= "    '$charger_part3',";                //��ô��������
        $insert_sql .= "    '$charger_represe1',";             //��ô�����򿦣�
        $insert_sql .= "    '$charger_represe2',";             //��ô�����򿦣�
        $insert_sql .= "    '$charger_represe3',";             //��ô�����򿦣�
        $insert_sql .= "    '$charger_note',";                 //��ô��������
/***************/

        if($trade_stime1 == ":"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$trade_stime1',";             //�ĶȻ��֡ʸ������ϡ�
        }
        if($trade_etime1 == ":"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$trade_etime1',";             //�ĶȻ��֡ʸ�����λ��
        }
        if($trade_stime2 == ":"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$trade_stime2',";             //�ĶȻ��֡ʸ�峫�ϡ�
        }
        if($trade_etime2 == ":"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$trade_etime2',";             //�ĶȻ��֡ʸ�彪λ��
        }
        if($btype == ""){
                $btype = "    null"; 
        }
        $insert_sql .= "    $btype,";                          //�ȼ�ID
        $insert_sql .= "    '$holiday',";                      //����
        $insert_sql .= "    '$close_day_cd',";                 //����
        $insert_sql .= "    '$trade_id',";                     //�����ʬ
        if($pay_m == ""){
                $pay_m = ""; 
        }
        $insert_sql .= "    '$pay_m',";                        //�������ʷ��
        if($pay_d == ""){
                $pay_d = ""; 
        }
        $insert_sql .= "    '$pay_d',";                        //������������
        $insert_sql .= "    '$pay_way',";                      //��ʧ����ˡ
        $insert_sql .= "    '$account_name',";                 //����̾��
        $insert_sql .= "    '$pay_name',";                     //����̾��
        if($bank_enter_cd == ""){
                $insert_sql .= "    null,"; 
        }else{
	        $insert_sql .= "    $bank_enter_cd,";               //���
        }
        $insert_sql .= "    '$slip_out',";                     //��ɼ����
        $insert_sql .= "    '$deliver_note',";                 //Ǽ�ʽ񥳥���
        $insert_sql .= "    '$claim_out',";                    //��������
        $insert_sql .= "    '$coax',";                         //��ۡ��ݤ��ʬ
        $insert_sql .= "    '$tax_div',";                      //�����ǡ�����ñ��
        $insert_sql .= "    '$tax_franct',";                   //�����ǡ�ü��ñ��
        if($cont_s_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_s_day',";               //���󳫻���
        }
        if($cont_e_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_e_day',";               //����λ��
        }
        if($cont_peri == ""){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_peri',";                //�������
        }
        if($cont_r_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_r_day',";               //���󹹿���
        }
        $insert_sql .= "    '$col_terms',";                    //������
        $insert_sql .= "    '$cledit_limit',";                 //Ϳ������
        $insert_sql .= "    '$capital',";                      //���ܶ�
        $insert_sql .= "    '$note',";                         //����������/����¾
        $insert_sql .= "    '1',";                             //�������ʬ
        //������������ΨȽ��
        if($price_check == 1 && $account_price != NULL){
            $insert_sql .= "    $account_price,";              //������
        }else if($rate_check == 1 && $account_rate != NULL){
            $insert_sql .= "    $account_rate,";               //������(Ψ)
        }
        $insert_sql .= "    '$email',";                        //Email
        $insert_sql .= "    '$url',";                          //URL
        $insert_sql .= "    '$represent_cell',";               //��ɽ�Է���
        if($bstruct == ""){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$bstruct',";                  //����
        }
        if($inst == ""){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    $inst,";                     //����
        }
        if($establish_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$establish_day',";            //�϶���
        }
        $insert_sql .= "    '$record',";                       //�������
        $insert_sql .= "    '$important',";                    //���׻���
        $insert_sql .= "    '$trans_account',";                //�����������̾
        $insert_sql .= "    '$bank_fc',";                      //���/��Ź̾
        $insert_sql .= "    '$account_num',";                  //�����ֹ�
        if($round_start == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$round_start',";              //��󳫻���
        }
        $insert_sql .= "    '$deliver_radio',";                //Ǽ�ʽ񥳥���(����
        $insert_sql .= "    '$claim_send',";                    //���������(͹��)
        $insert_sql .= "    '$cname_read',";                   //ά��(�եꥬ��)
        $insert_sql .= "    '$represe',";                        //��ɽ����
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    (SELECT";                          //������Ψ(����)
        $insert_sql .= "        tax_rate_n";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    '$company_name',";              //�Ʋ��̾
        $insert_sql .= "    '$company_tel',";               //�Ʋ��TEL
        $insert_sql .= "    '$company_address',";           //�Ʋ�ҽ���
        $insert_sql .= "    '$bank_div',";
        $insert_sql .= "    '$claim_note',";
                $insert_sql .= "    '$client_slip1',";
        $insert_sql .= "    '$client_slip2',";
        if($parent_establish_day != '--'){
            $insert_sql .= "    '$parent_establish_day',";      //�Ʋ���϶���
        }else{
            $insert_sql .= "    null,";
        }
        $insert_sql .= "    '$parent_rep_name',";            //�Ʋ����ɽ��̾
        $insert_sql .= "    '$type',";
        $insert_sql .= "    '$compellation',";            //�Ʋ����ɽ��̾
        //$insert_sql .= "    '$claim_scope'";
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
        $insert_sql .= "    $c_tax_div";
        $insert_sql .= ");";
        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //��������
        //�����ϻ�
        if($claim_flg == true){
            $insert_sql  = " INSERT INTO t_client_info (";
            $insert_sql .= "    client_id,";
            $insert_sql .= "    intro_account_id,";
            $insert_sql .= "    claim_id,";
	        $insert_sql .= "    cclient_shop";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$intro_act_cd'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '2'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        client_cd1 = '$claim_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$claim_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
	        $insert_sql .= "    $cshop_id";
            $insert_sql .= ");";
            $result = Db_Query($conn, $insert_sql);
        }else{
            $insert_sql = " INSERT INTO t_client_info (";
            $insert_sql .= "    client_id,";
            $insert_sql .= "    intro_account_id,";
            $insert_sql .= "    claim_id,";
	        $insert_sql .= "    cclient_shop";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$intro_act_cd'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '2'";
            $insert_sql .= "    ),";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$client_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$client_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '1'";
            $insert_sql .= "    ),";
	        $insert_sql .= "    $cshop_id";
            $insert_sql .= ");";
            $result = Db_Query($conn, $insert_sql);
        }
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //��Ͽ�������������˻Ĥ�
        $result = Log_Save( $conn, "client", "1", $client_cd1."-".$client_cd2, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
        
    /******************************/
    //��������
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
            $sql .= "   shop_id = $shop_id";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $claim_id = pg_fetch_result($result, 0,0 );
        }else{
            $claim_id = $get_client_id;
        }

        //������ޥ���
        Db_Query($conn, "BEGIN;");
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
        if($c_staff_id1 == ""){
            $c_staff_id1 = null;
        }
        if($c_staff_id2 == ""){
            $c_staff_id2 = null;
        }
//        if($d_staff_id1 == ""){
//            $d_staff_id1 = null;
//        }
//        if($d_staff_id2 == ""){
//            $d_staff_id2 = null;
//        }
//        if($d_staff_id3 == ""){
//            $d_staff_id3 = null;
//        }
/*20060420�ɲ�*/
        $update_sql .= "    charger1 = '$charger1',";
        $update_sql .= "    charger2 = '$charger2',";
        $update_sql .= "    charger3 = '$charger3',";
        $update_sql .= "    charger_part1 = '$charger_par1',";
        $update_sql .= "    charger_part2 = '$charger_par2',";
        $update_sql .= "    charger_part3 = '$charger_par3',";
        $update_sql .= "    charger_represe1 = '$charger_represe1',";
        $update_sql .= "    charger_represe2 = '$charger_represe2',";
        $update_sql .= "    charger_represe3 = '$charger_represe3',";
        $update_sql .= "    charger_note = '$charger_note',";
/**************/
 
        if($trade_stime1 == ":"){
            $update_sql .= "        trade_stime1 = null,";
        }else{
            $update_sql .= "        trade_stime1 = '$trade_stime1',";
        }
        if($trade_etime1 == ":"){
            $update_sql .= "        trade_etime1 = null,";
        }else{
            $update_sql .= "        trade_etime1 = '$trade_etime1',";
        }
        if($trade_stime2 == ":"){
            $update_sql .= "        trade_stime2 = null,";
        }else{
            $update_sql .= "        trade_stime2 = '$trade_stime2',";
        }
        if($trade_etime2 == ":"){
            $update_sql .= "        trade_etime2 = null,";
        }else{
            $update_sql .= "        trade_etime2 = '$trade_etime2',";
        }
        $update_sql .= "    holiday = '$holiday',";
        if($btype == ""){
            $update_sql .= "    sbtype_id = null,";
        }else{
            $update_sql .= "    sbtype_id = $btype,";
        }
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
        if($c_staff_id1 == ""){
            $update_sql .= "    c_staff_id1 = null,";
        }else{
            $update_sql .= "    c_staff_id1 = $c_staff_id1,";
        }
        if($c_staff_id2 == ""){
            $update_sql .= "    c_staff_id2 = null,";
        }else{
            $update_sql .= "    c_staff_id2 = $c_staff_id2,";
        }
//        if($d_staff_id1 == ""){
//            $update_sql .= "    d_staff_id1 = null,";
//        }else{
//            $update_sql .= "    d_staff_id1 = $d_staff_id1,";
//        }
//        if($d_staff_id2 == ""){
//            $update_sql .= "    d_staff_id2 = null,";
//        }else{
//            $update_sql .= "    d_staff_id2 = $d_staff_id2,";
//        }
//        if($d_staff_id3 == ""){
//            $update_sql .= "    d_staff_id3 = null,";
//        }else{
//            $update_sql .= "    d_staff_id3 = $d_staff_id3,";
//        }
        $update_sql .= "    col_terms = '$col_terms',";
        $update_sql .= "    credit_limit = '$cledit_limit',";
        $update_sql .= "    capital = '$capital',";
        $update_sql .= "    trade_id = '$trade_id',";
        $update_sql .= "    close_day = '$close_day_cd',";
        if($pay_m == ""){
            $update_sql .= "        pay_m = '',";
        }else{
            $update_sql .= "        pay_m = '$pay_m',";
        }
        if($pay_d == ""){
            $update_sql .= "        pay_d = '',";
        }else{
            $update_sql .= "        pay_d = '$pay_d',";
        }
        $update_sql .= "    pay_way = '$pay_way',";
        if($bank_enter_cd == ""){
            $update_sql .= "        b_bank_id = null,";
        }else{
            $update_sql .= "        b_bank_id = $bank_enter_cd,";
        }
        $update_sql .= "    pay_name = '$pay_name',";
        $update_sql .= "    account_name = '$account_name',";
        if($cont_s_day == "--"){
            $update_sql .= "        cont_sday = null,";
        }else{
            $update_sql .= "        cont_sday = '$cont_s_day',";
        }
        if($cont_e_day == "--"){
            $update_sql .= "        cont_eday = null,";
        }else{
            $update_sql .= "        cont_eday = '$cont_e_day',";
        }
        if($cont_peri == ""){
            $update_sql .= "        cont_peri = null,";
        }else{
            $update_sql .= "        cont_peri = '$cont_peri',";
        }
        if($cont_r_day == "--"){
            $update_sql .= "        cont_rday = null,";
        }else{
            $update_sql .= "        cont_rday = '$cont_r_day',";
        }
        $update_sql .= "    slip_out = '$slip_out',";
        $update_sql .= "    deliver_note = '$deliver_note',";
        $update_sql .= "    claim_out = '$claim_out',";
        $update_sql .= "    coax = '$coax',";
        $update_sql .= "    tax_div = '$tax_div',";
        $update_sql .= "    tax_franct = '$tax_franct',";
        $update_sql .= "    note = '$note',";
        $update_sql .= "    email = '$email',";
        $update_sql .= "    url = '$url',";
        $update_sql .= "    rep_htel = '$represent_cell',";
        if($bstruct == ""){
            $update_sql .= "        b_struct = null,";
        }else{
            $update_sql .= "        b_struct = $bstruct,";
        }
        if($inst == ""){
            $update_sql .= "   inst_id = null,";
        }else{
            $update_sql .= "   inst_id = $inst,";
        }
        if($establish_day == "--"){
            $update_sql .= "        establish_day = null,";
        }else{
            $update_sql .= "        establish_day = '$establish_day',";
        }
        $update_sql .= "    deal_history = '$record',";
        $update_sql .= "    importance = '$important',";
        $update_sql .= "    intro_ac_name = '$trans_account',";
        $update_sql .= "    intro_bank = '$bank_fc',";
        $update_sql .= "    intro_ac_num = '$account_num',";
        if($round_start == "--"){
            $update_sql .= "        round_day = null,";
        }else{
            $update_sql .= "        round_day = '$round_start',";
        }
        $update_sql .= "    deliver_effect = '$deliver_radio',";
        $update_sql .= "    claim_send = '$claim_send',";
        $update_sql .= "    client_cread = '$cname_read', ";
        $update_sql .= "    represe = '$represe',";
        $update_sql .= "    company_name = '$company_name',";
        $update_sql .= "    company_tel  = '$company_tel',";
        $update_sql .= "    company_address = '$company_address',";
        $update_sql .= "    bank_div = '$bank_div',";
        $update_sql .= "    claim_note = '$claim_note',";
        $update_sql .= "    client_slip1 = '$client_slip1',";
        $update_sql .= "    client_slip2 = '$client_slip2',";
        if($parent_establish_day != '--'){
            $update_sql .= "    parent_establish_day = '$parent_establish_day',";
        }else{
            $update_sql .= "    parent_establish_day = null,";
        }
        $update_sql .= "    parent_rep_name = '$parent_rep_name',";
        $update_sql .= "    type = '$type',";
        $update_sql .= "    compellation = '$compellation',";
        //$update_sql .= "    claim_scope = '$claim_scope'";
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
        $update_sql .= "    c_tax_div = $c_tax_div";
        $update_sql .= " WHERE";
        $update_sql .= "    shop_id = $shop_id";
        $update_sql .= "    AND";
        $update_sql .= "    client_id = $get_client_id";
        $update_sql .= ";";

        $result = Db_Query($conn, $update_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }

        //��������ơ��֥�
        if($claim_cd1 != null && $claim_cd2 != null && $claim_name != null){
            $update_sql = " UPDATE t_client_info ";
            $update_sql .= "SET ";
            $update_sql .= "    claim_id = (SELECT";
            $update_sql .= "        client_id";
            $update_sql .= "    FROM";
            $update_sql .= "        t_client";
            $update_sql .= "    WHERE";
            $update_sql .= "        shop_id = $shop_id";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd1 = '$claim_cd1'";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd2 = '$claim_cd2'";
            $update_sql .= "        AND";
            $update_sql .= "        client_div = '1'";
            $update_sql .= "    ),";
	        $update_sql .= "    intro_account_id = (SELECT";
	        $update_sql .= "        client_id";
	        $update_sql .= "    FROM";
	        $update_sql .= "        t_client";
	        $update_sql .= "    WHERE";
	        $update_sql .= "        shop_id = $shop_id";
	        $update_sql .= "        AND";
	        $update_sql .= "        client_cd1 = '$intro_act_cd'";
	        $update_sql .= "        AND";
	        $update_sql .= "        client_div = '2'";
	        $update_sql .= "    ),";
	        $update_sql .= "    cclient_shop = $cshop_id ";
            $update_sql .= "WHERE ";
            $update_sql .= "client_id = $get_client_id";
            $update_sql .= ";";
            $result = Db_Query($conn, $update_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
        //��ʬ����Ͽ
        }else if($claim_cd1 == null && $claim_cd2 == null && $claim_name == null){
            $update_sql = " UPDATE t_client_info ";
            $update_sql .= "SET ";
            $update_sql .= "    claim_id = (SELECT";
            $update_sql .= "        client_id";
            $update_sql .= "    FROM";
            $update_sql .= "        t_client";
            $update_sql .= "    WHERE";
            $update_sql .= "        shop_id = $shop_id";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd1 = '$client_cd1'";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd2 = '$client_cd2'";
            $update_sql .= "        AND";
            $update_sql .= "        client_div = '1'";
	        $update_sql .= "    ),";
	        $update_sql .= "    cclient_shop = $cshop_id ";
            $update_sql .= "WHERE ";
            $update_sql .= "client_id = $get_client_id";
            $update_sql .= ";";
            $result = Db_Query($conn, $update_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
        }
        if($client_div == '1'){
            //��������ơ��֥�
            $update_sql  = " INSERT INTO t_renew (";
            $update_sql .= "    client_id,";                        //������ID
            $update_sql .= "    staff_id,";                         //�����å�ID
            $update_sql .= "    renew_time";                        //���ߤ�timestamp
            $update_sql .= " )VALUES(";
            $update_sql .= "    (SELECT";
            $update_sql .= "        client_id";
            $update_sql .= "    FROM";
            $update_sql .= "        t_client";
            $update_sql .= "    WHERE";
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
        }else if($client_div == '3'){
            //��������ơ��֥�
            $update_sql  = " INSERT INTO t_renew (";
            $update_sql .= "    client_id,";                        //������ID
            $update_sql .= "    staff_id,";                         //�����å�ID
            $update_sql .= "    renew_time";                        //���ߤ�timestamp
            $update_sql .= " )VALUES(";
            $update_sql .= "    (SELECT";
            $update_sql .= "        client_id";
            $update_sql .= "    FROM";
            $update_sql .= "        t_client";
            $update_sql .= "    WHERE";
            $update_sql .= "        shop_id = $shop_id";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd1 = '$client_cd1'";
            $update_sql .= "        AND";
            $update_sql .= "        client_cd2 = '$client_cd2'";
            $update_sql .= "        AND";
            $update_sql .= "        client_div = '3'";
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
        //�ѹ��������������˻Ĥ�
        $result = Log_Save( $conn, "client", "2", $client_cd1."-".$client_cd2, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
    }
    Db_Query($conn, "COMMIT;");
    $complete_flg = true;
}

if($_POST["ok_button_flg"]==true){
    header("Location: ./1-1-115.php");
}

//�ܥ���
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:location.href='1-1-113.php'\"");

//��Ͽ(�إå�)
//$form->addElement("button","new_button","��Ͽ����","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","��Ͽ����",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//DB����Ͽ��Υե���������
if($complete_flg == true){
    $form->addElement("static","intro_claim_link","","������");
    $form->addElement("static","intro_act_link","","���Ҳ����");
    $button[] = $form->createElement(
            "button","back_button","�ᡡ��",
            "onClick='javascript:history.back()'
            ");
    //�ϣ�
//    $button[] = $form->addElement("button","ok_button","�ϡ���","onClick=\"javascript:Button_Submit_1('ok_button_flg', '#', 'true')\"");
    $form->freeze();
}else{

    //���Ȳ����Υ����å��ܥå����Υ����å�
    $onload = "Check_Button2($check_which);";
    //DB����Ͽ���Υե���������
    if($change_flg == true){
        $form->addElement("static","intro_claim_link","","������");
    }else{
        $form->addElement("link","intro_claim_link","","#","������","onClick=\"javascript:return Open_SubWin('../dialog/1-0-220-2.php',Array('form_claim[cd1]','form_claim[cd2]','form_claim[name]'), 500, 450, 1,1)\"");
    }
    $form->addElement("link","intro_act_link","","#","���Ҳ����","onClick=\"javascript:return Open_SubWin('../dialog/1-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450)\"");

    //��Ͽ�Ѱ�����ǧ
    $button[] = $form->createElement(
            "button","list_confirm_button","��Ͽ�Ѱ�����ǧ",
            "style=width:110 onClick=\"javascript:return Open_mlessDialog('../dialog/1-0-250-1.php','470','500')\""
            );

    $button[] = $form->createElement(
            "button","input_button","��ư����","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""
            ); 
    $button[] = $form->createElement(
            "button","back_button","�ᡡ��",
            "onClick='javascript:history.back()'
            ");
    if($_GET["client_id"] != null){
    $button[] = $form->createElement(
            "button","res_button","�¡���",
            "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-106.php?client_id=$get_client_id','_blank','width=480,height=600')\""
            );
    }

    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./1-1-115.php?client_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }
    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./1-1-115.php?client_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
    }
}
$form->addGroup($button, "button", "");


/***************************/
//Code_value
/***************************/
//������

$code_value = Code_Value("t_client",$conn,"",5);
$where_sql = "    WHERE";
$where_sql .= "        shop_id = $shop_id";
$where_sql .= "        AND";
$where_sql .= "        client_div = '2'";
$code_value .= Code_Value("t_client",$conn,"$where_sql",2);



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
/*
//������
$contract .= "function pay_way(){\n";
$contract .= "  if(document.dateForm.trade_aord_1.value=='61'){\n";
$contract .= "      document.dateForm.form_close.value='';\n";
$contract .= "      document.dateForm.form_pay_m.value='';\n";
$contract .= "      document.dateForm.form_pay_d.value='';\n";
$contract .= "  }\n";
$contract .= "}\n";

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
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/

/****************************/
//���������
/****************************/
$client_sql  = " SELECT";
$client_sql .= "     COUNT(client_id)";
$client_sql .= " FROM";
$client_sql .= "     t_client";
$client_sql .= " WHERE";
$client_sql .= "     t_client.client_div = '1'";
$client_sql .= ";";

//�إå�����ɽ�������������
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(��".$total_count."��)";
//$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
//����¾���ѿ���assign
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
    'sday_rday_err'         => "$csday_rday_err",
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
    'auth_r_msg'            => "$auth_r_msg",
	'parent_esday_err'      => "$parent_esday_err",
	'cont_e_day_err'        => "$cont_e_day_err",
    'claim_coax_err'        => "$claim_coax_err",
    'claim_tax_div_err'     => "$claim_tax_div_err",
    'claim_tax_franct_err'  => "$claim_tax_franct_err",
    'claim_c_tax_div_err'   => "$claim_c_tax_div_err",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>