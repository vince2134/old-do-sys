<?php
/*****************************
*�ѹ�����
*   ��������Ͽ�����å���watanabe-k��
*   (2006-07-31)���Ƕ�ʬ����Ͽ�ѹ������ɲá�watanabe-k��
*   (2006-08-29)�����Ƚ������������������å�(watanabe-k)
*   (2006-09-01)����ID����Ͽ�Ǥ���褦���ѹ�(watanabe-k)
*   (2006-09-09)���ۤ�������Ȥ�����Ͽ����ݤ�����������ۤȤ�����Ͽ����褦���ѹ���watanabe-k��
*   (2006-09-09)�����������Ȥ�����Ͽ����ݤλ�ʧ��������Ͽ�������ѹ���watanabe-k��
*   2006/11/13  0033    kaku-m  TEL��FAX�ֹ�Υ����å���ؿ��ǹԤ��褦�˽�����
******************************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/11��0083����������watanabe-k��FC����Ͽ�����ݤ���Ͽ����륷��å��̾��ʾ���ơ��֥�����ꤵ���쥳���ɿ������쥳���ɾ��ʤ��Х��ν���
 *   2006/12/14  kaji-193      kajioka-h   �ԣƣ̤�ԣţ̤��ѹ�
 *   2007/01/23  �����ѹ�      watanabe-k  �ܥ���ο����ѹ�
 *   2007/02/19                watanabe-k  ��Ͽ���褦�Ȥ��Ƥ��륳���ɤ�������˻��ꤹ��������褬��Ͽ����Ƥ��ʤ��Х��ν���
 *   2007/02/20                watanabe-k  �������Ѥμ����ʬ���ɲ�
 *   2007/02/21                watanabe-k  FC��Ͽ���˻�Ź���������Ͽ����褦�˽���
 *   2007/03/14                watanabe-k  �Ƥ��ѹ��������˻ҤΥǡ������ѹ�����褦�˽���
 *   2007/05/07                watanabe-k  ���֤Υ��ơ������ѹ�
 *   2007/05/07                watanabe-k  �����ѥ������������ܤ˸��̤��ɲ�
 *   2007/05/08                watanabe-k  �����ʬ������ξ�罸�����������˹�碌�� 
 *   2007/06/08                watanabe-k  �����ʬ������ξ���ʧ���������˹�碌�� 
 *   2009/10/09                hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *   2009/12/25                aoyama-n    ���Ƕ�ʬ�����Ǥ�����Ǥ��ѹ�
 *                                         ��Ͽ�����Ǽ����������ξ����ǣ����ܤ����ꤹ��
 *   2010-05-01  Rev.1.5����   hashimoto-y �����ΰ���ե���ȥ������ѹ���ǽ���ɲ�
 *   2016/01/20                amano  Dialogue, Button_Submit_1 �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 */

$page_title = "FC�������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]","","onSubmit=return confirm(true)");

// DB����³
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
if ($_GET["client_id"] != null && Get_Id_Check_Db($conn, $_GET["client_id"], "client_id", "t_client", "num", null) != true){
    header("Location: ../top.php");
    exit;
}

/****************************/
//�����(radio)
/****************************/
$def_fdata = array(
    "form_claim_num"	=> "1",
    "form_deliver_radio"=> "1",
    "form_state"        => "1",
    "form_head_fc"      => "1",
    "form_slip_issue"   => "1",
    "form_claim_issue"  => "1",
    "form_coax"         => "1",
    "form_tax_unit"     => "1",
    "form_tax_div"      => "2",
    "from_fraction_div" => "1",
    "form_royalty"      => "0",
    "form_claim_send"   => "1",
    "form_prefix"       => "1",
    "form_c_tax_div"    => "1",
    #2010-05-01 hashimoto-y
    "form_bill_address_font" => "0",
);
$form->setDefaults($def_fdata);

/****************************/
//��������GET���������
/****************************/
if($new_flg == false){
    $select_sql  = "SELECT\n";
    $select_sql .= "    t_client.rank_cd,";             //FC���롼��
    $select_sql .= "    t_client.state,";               //����
    $select_sql .= "    t_client.shop_div,";            //�ܼҡ��ټҶ�ʬ
    $select_sql .= "    t_client.client_cd1,";          //����åץ�����1
    $select_sql .= "    t_client.client_cd2,";          //����åץ�����2
    $select_sql .= "    t_client.client_name,";         //����å�̾
    $select_sql .= "    t_client.client_read,";         //����å�̾(�եꥬ��)
    $select_sql .= "    t_client.client_cname,";        //ά��
    $select_sql .= "    t_client.shop_name,";           //��̾
    $select_sql .= "    t_client.shop_read,";           //��̾(�եꥬ��)
    $select_sql .= "    t_client.post_no1,";            //͹���ֹ�
    $select_sql .= "    t_client.post_no2,";            //͹���ֹ�
    $select_sql .= "    t_client.address1,";            //����1
    $select_sql .= "    t_client.address2,";            //����2
    $select_sql .= "    t_client.address_read,";        //����(�եꥬ��)
    $select_sql .= "    t_client.area_id,";             //�϶�
    $select_sql .= "    t_client.tel,";                 //TEL
    $select_sql .= "    t_client.fax,";                 //FAX
    $select_sql .= "    t_client.url,";                 //URL
    $select_sql .= "    t_client_claim.client_cd1,";    //�����襳����1
    $select_sql .= "    t_client_claim.client_cd2,";    //�����襳����2
    $select_sql .= "    t_client_claim.client_name,";   //������̾
    $select_sql .= "    t_client.sv_staff_id,";         //SV
    $select_sql .= "    t_client.b_staff_id1,";         //ô����
    $select_sql .= "    t_client.b_staff_id2,";         //ô����
    $select_sql .= "    t_client.b_staff_id3,";         //ô����
    $select_sql .= "    t_client.b_staff_id4,";         //ô����
    $select_sql .= "    t_client.rep_name,";            //��ɽ�Ի�̾
    $select_sql .= "    t_client.represe,";             //��ɽ����
    $select_sql .= "    t_client.rep_htel,";            //��ɽ�Է���
    $select_sql .= "    t_client.charger_name,";        //Ϣ��ô���Ի�̾
    $select_sql .= "    t_client.charger,";             //Ϣ��ô������
    $select_sql .= "    t_client.cha_htel,";            //Ϣ��ô���Է���
    $select_sql .= "    t_client.surety_name1,";        //�ݾڿͣ�
    $select_sql .= "    t_client.surety_addr1,";        //�ݾڿͣ�����
    $select_sql .= "    t_client.surety_name2,";        //�ݾڿͣ�
    $select_sql .= "    t_client.surety_addr2,";        //�ݾڿͣ�����
    $select_sql .= "    t_client.trade_base,";          //�Ķȵ���
    $select_sql .= "    t_client.holiday,";             //����
    $select_sql .= "    t_client.trade_area,";          //����
    $select_sql .= "    t_client.join_money,";          //������
    $select_sql .= "    t_client.guarant_money,";       //�ݾڶ�
    $select_sql .= "    t_client.royalty_rate,";        //�����ƥ�
    $select_sql .= "    t_client.cutoff_month,";        //�軻��
    $select_sql .= "    t_client.col_terms,";           //������
    $select_sql .= "    t_client.credit_limit,";        //Ϳ������
    $select_sql .= "    t_client.capital,";             //���ܶ�
    $select_sql .= "    t_client.trade_id,";            //�����ʬ
    $select_sql .= "    t_client.close_day,";           //����
    $select_sql .= "    t_client.pay_m,";               //������(��)
    $select_sql .= "    t_client.pay_d,";               //������(��)
    $select_sql .= "    t_client.pay_way,";             //������ˡ
    $select_sql .= "    t_client.pay_name,";            //����̾��
    $select_sql .= "    t_client.account_name,";        //����̾��
//    $select_sql .= "    t_client.bank_id,";             //�������
    $select_sql .= "    t_client.account_id,";             //����ID
    $select_sql .= "    t_client.c_compa_name,";        //������̾
    $select_sql .= "    t_client.c_compa_rep,";         //������ɽ̾
    $select_sql .= "    t_client.cont_sday,";           //����ǯ����
    $select_sql .= "    t_client.cont_eday,";           //����λ��
    $select_sql .= "    t_client.cont_peri,";           //�������
    $select_sql .= "    t_client.cont_rday,";           //���󹹿���
    $select_sql .= "    t_client.establish_day,";       //�϶���
    $select_sql .= "    t_client.regist_day,";          //ˡ���е���
    $select_sql .= "    t_client.slip_out,";            //��ɼȯ��
    $select_sql .= "    t_client.deliver_note,";        //Ǽ�ʽ񥳥���
    $select_sql .= "    t_client.claim_out,";           //�����ȯ��
    $select_sql .= "    t_client.coax,";                //�ޤ���ʬ
    $select_sql .= "    t_client.tax_div,";             //����ñ��
    $select_sql .= "    t_client.tax_franct,";          //ü����ʬ
    $select_sql .= "    t_client.license,";             //������ʡ�����ʬ��
    $select_sql .= "    t_client.s_contract,";          //����
    $select_sql .= "    t_client.other,";               //����¾
    $select_sql .= "    t_client.sbtype_id,";           //�ȼ�
    $select_sql .= "    t_client.inst_id,";             //����
    $select_sql .= "    t_client.b_struct,";            //����
    $select_sql .= "    t_client.accountant_name,";     //���ô���Ի�̾
    $select_sql .= "    t_client.client_cread,";        //ά��(�եꥬ��)
    $select_sql .= "    t_client.email,";               //Email
    $select_sql .= "    t_client.direct_tel,";          //ľ��TEL
    $select_sql .= "    t_client.deal_history,";        //�������
    $select_sql .= "    t_client.importance,";          //���׻���
    $select_sql .= "    t_client.deliver_effect,";      //Ǽ�ʽ񥳥���(����)
    $select_sql .= "    t_client.claim_send,";          //���������(͹��)
    $select_sql .= "    t_client.cutoff_day,";          //�軻��
    $select_sql .= "    t_client.shop_name2,";          //��̾
    $select_sql .= "    t_client.shop_read2,";          //��̾(�եꥬ��)
    $select_sql .= "    t_client.address3,";            //����2
    $select_sql .= "    t_client.account_tel,";         //���ô����
    $select_sql .= "    t_client.compellation,";        //�ɾ�
    //$select_sql .= "    t_client.claim_scope,";         //�����ϰ�
    $select_sql .= "    t_client.c_pattern_id,";         //������ͼ�
    $select_sql .= "    t_client.c_tax_div,";            //���Ƕ�ʬ
    $select_sql .= "    t_account.b_bank_id,";           //��ŹID
    $select_sql .= "    t_b_bank.bank_id,";                //���ID
    $select_sql .= "    t_client.bank_name,";           //����̾��
    $select_sql .= "    t_client.b_bank_name,";         //����̾��ά��
    $select_sql .= "    t_client.payout_m,";            //��ʧ���ʷ��
    $select_sql .= "    t_client.payout_d,";             //��ʧ��������
    $select_sql .= "    t_client.buy_trade_id,";        //�����ʬ

    #2010-05-01 hashimoto-y
    //�������ե����
    $select_sql .= "    t_client.bill_address_font ";

    $select_sql .= " FROM";
    $select_sql .= "    t_client\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "    t_claim\n";
    $select_sql .= "    ON t_client.client_id = t_claim.client_id\n";
    $select_sql .= "        INNER JOIN\n";
    $select_sql .= "    t_client AS t_client_claim\n";
    $select_sql .= "    ON t_claim.claim_id = t_client_claim.client_id\n";
    $select_sql .= "        LEFT JOIN\n";
    $select_sql .= "    t_account\n";
    $select_sql .= "    ON t_client.account_id = t_account.account_id\n";
    $select_sql .= "        LEFT JOIN\n";
    $select_sql .= "    t_b_bank\n";
    $select_sql .= "    ON t_account.b_bank_id = t_b_bank.b_bank_id\n";

/*
    $select_sql .= "    t_claim,";
    $select_sql .= "    t_client,";
    $select_sql .= "    t_client AS t_client_claim";
    $select_sql .= "    t_b_bank,";
*/
    $select_sql .= " WHERE";
    $select_sql .= "    t_client.client_id = $get_client_id";
    $select_sql .= "    AND";
    $select_sql .= "    t_client.client_div = '3'";
    $select_sql .= ";";
    //������ȯ��
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    //�ǡ�������
    $fc_data = @pg_fetch_array ($result, 0);

    //����ͥǡ���
    $defa_data["form_shop_gr_1"]              = $fc_data[0];         //FC���롼��
    $defa_data["form_state"]                  = $fc_data[1];         //����
    $defa_data["form_head_fc"]                = $fc_data[2];         //�ܼҡ��ټҶ�ʬ
    $defa_data["form_shop_cd"]["cd1"]         = $fc_data[3];         //����åץ�����1
    $defa_data["form_shop_cd"]["cd2"]         = $fc_data[4];         //����åץ�����2
    $defa_data["form_shop_name"]              = $fc_data[5];         //����å�̾
    $defa_data["form_shop_read"]              = $fc_data[6];         //����å�̾(�եꥬ��)
    $defa_data["form_shop_cname"]             = $fc_data[7];         //ά��
    $defa_data["form_comp_name"]              = $fc_data[8];         //��̾
    $defa_data["form_comp_read"]              = $fc_data[9];         //��̾(�եꥬ��)
    $defa_data["form_post"]["no1"]            = $fc_data[10];        //͹���ֹ�
    $defa_data["form_post"]["no2"]            = $fc_data[11];        //͹���ֹ�
    $defa_data["form_address1"]               = $fc_data[12];        //����1
    $defa_data["form_address2"]               = $fc_data[13];        //����2
    $defa_data["form_address_read"]           = $fc_data[14];        //����(�եꥬ��)
    $defa_data["form_area_1"]                 = $fc_data[15];        //�϶�
    $defa_data["form_tel"]                    = $fc_data[16];        //TEL
    $defa_data["form_fax"]                    = $fc_data[17];        //FAX
    $defa_data["form_url"]                    = $fc_data[18];        //URL
    $defa_data["form_claim"]["cd1"]           = $fc_data[19];        //�����襳����1
    $defa_data["form_claim"]["cd2"]           = $fc_data[20];        //�����襳����2
    $defa_data["form_claim"]["name"]          = $fc_data[21];        //������̾
    $defa_data["form_staff_1"]                = $fc_data[22];        //SV
    $defa_data["form_staff_2"]                = $fc_data[23];        //ô����
    $defa_data["form_staff_3"]                = $fc_data[24];        //ô����
    $defa_data["form_staff_4"]                = $fc_data[25];        //ô����
    $defa_data["form_staff_5"]                = $fc_data[26];        //ô����
    $defa_data["form_represent_name"]         = $fc_data[27];        //��ɽ�Ի�̾
    $defa_data["form_represent_position"]     = $fc_data[28];        //��ɽ����
    $defa_data["form_represent_cell"]         = $fc_data[29];        //��ɽ�Է���
    $defa_data["form_contact_name"]           = $fc_data[30];        //Ϣ��ô���Ի�̾
    $defa_data["form_contact_position"]       = $fc_data[31];        //Ϣ��ô������
    $defa_data["form_contact_cell"]           = $fc_data[32];        //Ϣ��ô���Է���
    $defa_data["form_guarantor1"]             = $fc_data[33];        //�ݾڿͣ�
    $defa_data["form_guarantor1_address"]     = $fc_data[34];        //�ݾڿͣ�����
    $defa_data["form_guarantor2"]             = $fc_data[35];        //�ݾڿͣ�
    $defa_data["form_guarantor2_address"]     = $fc_data[36];        //�ݾڿͣ�����
    $defa_data["form_position"]               = $fc_data[37];        //�Ķȵ���
    $defa_data["form_holiday"]                = $fc_data[38];        //����
    $defa_data["form_business_limit"]         = $fc_data[39];        //����
    $defa_data["form_join_money"]             = $fc_data[40];        //������
    $defa_data["form_assure_money"]           = $fc_data[41];        //�ݾڶ�
    $defa_data["form_royalty"]                = $fc_data[42];        //�����ƥ�
    $defa_data["form_accounts_month"]         = $fc_data[43];        //�軻��
    $defa_data["form_collect_terms"]          = $fc_data[44];        //������
    $defa_data["form_limit_money"]            = $fc_data[45];        //Ϳ������
    $defa_data["form_capital_money"]          = $fc_data[46];        //���ܶ�
    $defa_data["trade_aord_1"]                = $fc_data[47];        //�����ʬ
    $defa_data["form_close_1"]                = $fc_data[48];        //����
    $defa_data["form_pay_month"]              = $fc_data[49];        //������(��)
    $defa_data["form_pay_day"]                = $fc_data[50];        //������(��)
    $defa_data["form_pay_way"]                = $fc_data[51];        //������ˡ
    $defa_data["form_transfer_name"]          = $fc_data[52];        //����̾��
    $defa_data["form_account_name"]           = $fc_data[53];        //����̾��
//    $defa_data["form_bank_1"]                 = $fc_data[54];        //�������
    $defa_data["form_bank_1"][2]                 = $fc_data[54];        //�������
    $defa_data["form_contract_name"]          = $fc_data[55];        //������̾
    $defa_data["form_represent_contract"]     = $fc_data[56];        //������ɽ̾
    $cont_s_day[y]    = substr($fc_data[57],0,4);
    $cont_s_day[m]    = substr($fc_data[57],5,2);
    $cont_s_day[d]    = substr($fc_data[57],8,2);
    $cont_e_day[y]    = substr($fc_data[58],0,4);
    $cont_e_day[m]    = substr($fc_data[58],5,2);
    $cont_e_day[d]    = substr($fc_data[58],8,2);
    $cont_r_day[y]    = substr($fc_data[60],0,4);
    $cont_r_day[m]    = substr($fc_data[60],5,2);
    $cont_r_day[d]    = substr($fc_data[60],8,2);
    $establish_day[y] = substr($fc_data[61],0,4);
    $establish_day[m] = substr($fc_data[61],5,2);
    $establish_day[d] = substr($fc_data[61],8,2);
    $corpo_day[y]     = substr($fc_data[62],0,4);
    $corpo_day[m]     = substr($fc_data[62],5,2);
    $corpo_day[d]     = substr($fc_data[62],8,2);
    $defa_data["form_cont_s_day"]["y"]        = $cont_s_day[y];      //����ǯ����(ǯ)
    $defa_data["form_cont_s_day"]["m"]        = $cont_s_day[m];      //����ǯ����(��)
    $defa_data["form_cont_s_day"]["d"]        = $cont_s_day[d];      //����ǯ����(��)
    $defa_data["form_cont_e_day"]["y"]        = $cont_e_day[y];      //����λ��(ǯ)
    $defa_data["form_cont_e_day"]["m"]        = $cont_e_day[m];      //����λ��(��)
    $defa_data["form_cont_e_day"]["d"]        = $cont_e_day[d];      //����λ��(��)
    $defa_data["form_cont_peri"]              = $fc_data[59];        //�������
    $defa_data["form_cont_r_day"]["y"]        = $cont_r_day[y];      //���󹹿���(ǯ)
    $defa_data["form_cont_r_day"]["m"]        = $cont_r_day[m];      //���󹹿���(��)
    $defa_data["form_cont_r_day"]["d"]        = $cont_r_day[d];      //���󹹿���(��)
    $defa_data["form_establish_day"]["y"]     = $establish_day[y];   //�϶���
    $defa_data["form_establish_day"]["m"]     = $establish_day[m];
    $defa_data["form_establish_day"]["d"]     = $establish_day[d];
    $defa_data["form_corpo_day"]["y"]         = $corpo_day[y];       //ˡ���е���(ǯ)
    $defa_data["form_corpo_day"]["m"]         = $corpo_day[m];       //ˡ���е���(��)
    $defa_data["form_corpo_day"]["d"]         = $corpo_day[d];       //ˡ���е���(��)
    $defa_data["form_slip_issue"]             = $fc_data[63];        //��ɼȯ��
    $defa_data["form_deli_comment"]           = $fc_data[64];        //Ǽ�ʽ񥳥���
    $defa_data["form_claim_issue"]            = $fc_data[65];        //�����ȯ��
    $defa_data["form_coax"]                   = $fc_data[66];        //�ޤ���ʬ
    $defa_data["form_tax_unit"]               = $fc_data[67];        //����ñ��
    $defa_data["from_fraction_div"]           = $fc_data[68];        //ü����ʬ
    $defa_data["form_qualify_pride"]          = $fc_data[69];        //������ʡ�����ʬ��
    $defa_data["form_special_contract"]       = $fc_data[70];        //����
    $defa_data["form_other"]                  = $fc_data[71];        //����¾
    $defa_data["form_btype"]                  = $fc_data[72];        //�ȼ�
    $defa_data["form_inst"]                   = $fc_data[73];        //����
    $defa_data["form_bstruct"]                = $fc_data[74];        //����
    $defa_data["form_accountant_name"]        = $fc_data[75];        //���ô���Ի�̾
    $defa_data["form_cname_read"]             = $fc_data[76];        //ά��(�եꥬ��)
    $defa_data["form_email"]                  = $fc_data[77];        //Email
    $defa_data["form_direct_tel"]             = $fc_data[78];        //ľ��TEL
    $defa_data["form_record"]                 = $fc_data[79];        //�������
    $defa_data["form_important"]              = $fc_data[80];        //���׻���
    $defa_data["form_deliver_radio"]          = $fc_data[81];        //Ǽ�ʽ񥳥���(����)
    $defa_data["form_claim_send"]             = $fc_data[82];        //���������
    $defa_data["form_accounts_day"]           = $fc_data[83];        //�軻��
    $defa_data["form_comp_name2"]             = $fc_data[84];        //��̾2
    $defa_data["form_comp_read2"]             = $fc_data[85];        //��̾(�եꥬ��)2
    $defa_data["form_address3"]               = $fc_data[86];        //����3
    $defa_data["form_account_tel"]            = $fc_data[87];        //���ô���Է���
    $defa_data["form_prefix"]                 = $fc_data[88];        //�ɾ�
    //$defa_data["form_claim_scope"]            = $fc_data[89];        //�����ϰ�
    $defa_data["claim_pattern"]               = $fc_data[89];        //������ͼ�
    $defa_data["form_rank"]                   = $fc_data[0];        //�ܵҶ�ʬ
    $defa_data["form_c_tax_div"]              = $fc_data["c_tax_div"];//���Ƕ�ʬ
    $defa_data["form_bank_1"][1]              = $fc_data["b_bank_id"];  //��ŹID
    $defa_data["form_bank_1"][0]              = $fc_data["bank_id"];    //���ID
    $defa_data["form_bank_name"]              = $fc_data["bank_name"];  //��������̾��
    $defa_data["form_b_bank_name"]            = $fc_data["b_bank_name"]; //��������̾ά��
    $defa_data["form_payout_day"]               = $fc_data["payout_d"];
    $defa_data["form_payout_month"]               = $fc_data["payout_m"];
    $defa_data["trade_buy_1"]                = $fc_data["buy_trade_id"];

    #2010-05-01 hashimoto-y
    $defa_data["form_bill_address_font"]      = ($fc_data["bill_address_font"] == 't')? 1 : 0;

    //���������                                         
    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "shop", $fc_data[3].",".$fc_data[4]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    //��ʬ��¾��FC��������Ȥ�����Ͽ����Ƥ��뤫
    $sql  = "SELECT";
    $sql .= "   count(client_id)";
    $sql .= " FROM";
    $sql .= "   t_claim";
    $sql .= " WHERE";
    $sql .= "   client_id <> $get_client_id";
    $sql .= "   AND";
    $sql .= "   claim_id = $get_client_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $claim_num = pg_fetch_result($result,0,0);

    //�ѹ���ǽȽ��
    if($claim_num > 0){
        $change_flg = true;
    }else{
        $change_flg = false;
    }

    //�ѹ����륷��åפΥ��롼�פμ��̤����
    $sql  = "SELECT";
    $sql .= "   group_kind";
    $sql .= " FROM";
    $sql .= "   t_rank";
    $sql .= " WHERE";
    $sql .= "   rank_cd = '$fc_data[0]'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $group_kind = pg_fetch_result($result, 0,0);


}else{
    //��ư���֤Υ���åץ����ɼ���
	$sql  = "SELECT";
	$sql .= "   MAX(client_cd1)";
	$sql .= " FROM";
	$sql .= "   t_client ";
	$sql .= " WHERE";
	$sql .= "   client_div = '3' ";
	$sql .= " AND ";
	$sql .= "   shop_id = $shop_id";
	$sql .= ";";
	$result = Db_Query($conn, $sql);
	$client_cd1 = pg_fetch_result($result, 0 ,0);
	//�����ɤθ³��ͤξ��ϼ�ư���֤��ʤ�
	if($client_cd1 != '999999'){
		$client_cd1 = $client_cd1 +1;
		$client_cd1 = str_pad($client_cd1, 6, 0, STR_PAD_LEFT);

		$defa_data["form_shop_cd"]["cd1"] = $client_cd1;
        $defa_data["form_shop_cd"]["cd2"] = '0000';
        $form->setDefaults($defa_data);
	}
}

//�����ƥॳ���ɤ���FC��������ʬ�������ɽ��
/*
if($_POST["shop_gr_flg"]==true && $_POST["form_shop_gr_1"]!=null  || $new_flg == false){
    $sql  = "SELECT";
    $sql .= "   rank_name";
    $sql .= " FROM";
    $sql .= "   t_rank";
    $sql .= " WHERE";
    $sql .= "   rank_cd = ";
    $sql .= "   (SELECT";
    $sql .= "       rank_cd";
    $sql .= "    FROM";
    $sql .= "       t_shop_gr";
    $sql .= "    WHERE";
    if($_POST["shop_gr_flg"]==true){
	    $sql .= "       shop_id = $_POST[form_shop_gr_1]);";
    }else if($new_flg == false){
	    $sql .= "       shop_id = $fc_data[0]);";
	}

    $result = Db_Query($conn, $sql);
    $select_rank_name = pg_fetch_result($result,0,0);
    $cons_data["form_rank"] = $select_rank_name;
    $form->setConstants($cons_data);
}else{
    $cons_data["form_rank"] = "";
    $form->setConstants($cons_data);
}

/****************************/
//�ե���������
/****************************/
//FC��������ʬ
//������Ͽ
if($new_flg == true){
    $sql  = "SELECT";
    $sql .= "   rank_cd,";
    $sql .= "   rank_name";
    $sql .= " FROM";
    $sql .= "   t_rank";
    $sql .= " WHERE";
    $sql .= "   disp_flg = true";
    $sql .= "   AND ";
    $sql .= "   group_kind != '2'";
    $sql .= " ORDER BY rank_cd";
    $sql .= ";";
//ľ��
}elseif($group_kind == '2'){
    $sql  = "SELECT";
    $sql .= "   rank_cd,";
    $sql .= "   rank_name";
    $sql .= " FROM";
    $sql .= "   t_rank";
    $sql .= " WHERE";
    $sql .= "   disp_flg = true";
    $sql .= "   AND";
    $sql .= "   group_kind = '2'";
    $sql .= " ORDER BY rank_cd";
    $sql .= ";";
//����¾FC
}else{
    //�����ʤˤĤ���ñ�������ꤷ�Ƥ��뤫��ǧ
    $sql  = "SELECT\n";
    $sql .= "   COUNT(*)\n";
//    $sql .= "   *\n";
    $sql .= "FROM\n";
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id\n";
    $sql .= "    FROM\n";
    $sql .= "       t_goods\n";
    $sql .= "   WHERE\n";
    $sql .= "       accept_flg = '1'\n";
    $sql .= "       AND\n";
    $sql .= "       public_flg = 't'\n";
    $sql .= "       AND\n";
    $sql .= "       state = '1'\n";
    $sql .= "   ) AS t_goods\n";
    $sql .= "       LEFT JOIN\n";
    $sql .= "   (SELECT\n";
    $sql .= "       goods_id\n";
    $sql .= "   FROM\n";
    $sql .= "       t_price\n";
    $sql .= "   WHERE\n";
    $sql .= "       rank_cd = '3'\n";
    $sql .= "       AND\n";
    $sql .= "       shop_id = $get_client_id\n";
    $sql .= "   ) AS t_price\n";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id \n";
    $sql .= "WHERE\n";
    $sql .= "   t_price.goods_id IS NULL\n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    
    $set_goods_count = pg_fetch_result($result, 0,0);

    $set_goods_flg = ($set_goods_count == 0)? true : false;

    //���ʤ�ñ�������ꤷ�Ƥ�����
    if($set_goods_flg === true){
        $sql  = "SELECT";
        $sql .= "   rank_cd,";
        $sql .= "   rank_name";
        $sql .= " FROM";
        $sql .= "   t_rank";
        $sql .= " WHERE";
        $sql .= "   disp_flg = true";
        $sql .= "   AND";
        $sql .= "   group_kind <> '2'";
        $sql .= " ORDER BY rank_cd";
        $sql .= ";";
    //���ʤ�ñ�������ꤷ�Ƥ��ʤ����
    }else{
        $sql  = "SELECT";
        $sql .= "   rank_cd,";
        $sql .= "   rank_name ";
        $sql .= "FROM";
        $sql .= "   t_rank ";
        $sql .= "WHERE\n";
        $sql .= "   rank_cd = (SELECT rank_cd FROM t_client WHERE client_id = $get_client_id)";
        $sql .= ";";
    }
}

$result   = Db_Query($conn,$sql);
$rank_num = pg_num_rows($result);
$select_value[null] = null;
for($i = 0; $i < $rank_num; $i++){
    $rank_cd   = pg_fetch_result($result , $i, 0);
    $rank_name = pg_fetch_result($result , $i, 1);

    $select_value["$rank_cd"] = $rank_cd."������".$rank_name;
}

//�ܵҶ�ʬ������
$freeze = $form->addElement(
		"select","form_rank","", $select_value, $g_form_option_select);
if($new_flg != true){
    $freeze->freeze();
}

//����åץ�����
$form_shop_cd[] =& $form->createElement(
        "text","cd1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_shop_cd[cd1]','form_shop_cd[cd2]',6)\" $g_form_option"
         );
$form_shop_cd[] =& $form->createElement(
        "static","","","-"
        );
$form_shop_cd[] =& $form->createElement(
        "text","cd2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        $g_form_option"
        );
$form->addGroup($form_shop_cd, "form_shop_cd", "form_shop_cd");

// �����襳���ɶ��������ɸ������
$form->addElement("link", "form_cd_search", "", "#", "���������ɸ���", "tabindex=\"-1\" 
    onClick=\"javascript:return Open_SubWin('../dialog/1-0-103.php', Array('form_shop_cd[cd1]','form_shop_cd[cd2]'), 570, 650, 3, 1);\"
");

//͹���ֹ�
$form_post[] =& $form->createElement(
        "text","no1","�ƥ����ȥե�����","size=\"3\" maxLength=\"3\"  style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        $g_form_option"
        );
$form->addGroup( $form_post, "form_post", "form_post");

//������
$form_claim[] =& $form->createElement(
        "text","cd1","","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
        onkeyup=\"javascript:client1('form_claim[cd1]','form_claim[cd2]','form_claim[name]')\"".$g_form_option."\""
        );
$form_claim[] =& $form->createElement(
        "static","","","-"
        );
$form_claim[] =& $form->createElement(
        "text","cd2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"javascript:client1('form_claim[cd1]','form_claim[cd2]','form_claim[name]')\"".$g_form_option."\""
        );
$form_claim[] =& $form->createElement(
        "text","name","","size=\"34\" 
        $g_text_readonly"
        );
$freeze = $form->addGroup( $form_claim, "form_claim", "");
if($change_flg == true){
    $freeze->freeze();
}

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
        "text","m","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_s_day[m]','form_cont_s_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_s_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_s_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
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
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_r_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_r_day[] =& $form->createElement(
        "text","m","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_cont_r_day[m]','form_cont_r_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_cont_r_day[] =& $form->createElement(
        "static","","","-"
        );
$form_cont_r_day[] =& $form->createElement(
        "text","d","","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onchange=\"Contract(this.form)\"".$g_form_option."\""
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

//ˡ���е���
$form_corpo_day[] =& $form->createElement(
        "text","y","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_corpo_day[y]','form_corpo_day[m]',4)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_corpo_day[] =& $form->createElement(
        "static","","","-"
        );
$form_corpo_day[] =& $form->createElement(
        "text","m","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_corpo_day[m]','form_corpo_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_corpo_day[] =& $form->createElement(
        "static","","","-"
        );
$form_corpo_day[] =& $form->createElement(
        "text","d","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_corpo_day,"form_corpo_day","form_corpo_day");

//����å�̾
$form->addElement(
        "text","form_shop_name","�ƥ����ȥե�����","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//����å�̾(�եꥬ��)
$form->addElement(
        "text","form_shop_read","�ƥ����ȥե�����","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//ά��
$form->addElement(
        "text","form_shop_cname","�ƥ����ȥե�����","size=\"40\" maxLength=\"20\" 
        $g_form_option"
        );

//ά�Ρʥեꥬ�ʡ�
$form->addElement(
        "text","form_cname_read","",'size="40" maxLength="40"'." $g_form_option"
        );

//�ɾ�
$form_prefix_radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$form_prefix_radio[] =& $form->createElement( "radio",NULL,NULL, "��","2");
$form->addGroup($form_prefix_radio,"form_prefix","");
     
//��̾
$form->addElement(
        "text","form_comp_name","�ƥ����ȥե�����","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//��̾(�եꥬ��)
$form->addElement(
        "text","form_comp_read","�ƥ����ȥե�����","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//��̾2
$form->addElement(
        "text","form_comp_name2","�ƥ����ȥե�����","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//��̾2(�եꥬ��)
$form->addElement(
        "text","form_comp_read2","�ƥ����ȥե�����","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//����1
$form->addElement(
        "text","form_address1","�ƥ����ȥե�����","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//����2
$form->addElement(
        "text","form_address2","�ƥ����ȥե�����","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//����3
$form->addElement(
        "text","form_address3","",'size="40" maxLength="30"'." $g_form_option"
        );

//����(�եꥬ��)
$form->addElement(
        "text","form_address_read","�ƥ����ȥե�����","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

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

//��ɽ�Ի�̾
$form->addElement(
        "text","form_represent_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//��ɽ����
$form->addElement(
        "text","form_represent_position","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//ľ��TEL
$form->addElement(
        "text","form_direct_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option"
        );

//��ɽ�Է���
$form->addElement(
        "text","form_represent_cell","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" 
        $g_form_option"
        );

//Ϣ��ô���Ի�̾
$form->addElement(
        "text","form_contact_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//Ϣ��ô������
$form->addElement(
        "text","form_contact_position","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//Ϣ��ô���Է���
$form->addElement(
        "text","form_contact_cell","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//���ô���Ի�̾
$form->addElement(
        "text","form_accountant_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"10\" 
        $g_form_option"
        );
//���ô���Է���
$form->addElement(
        "text","form_account_tel","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//�ݾڿͣ�
$form->addElement(
        "text","form_guarantor1","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//�ݾڿͣ�����
$form->addElement(
        "text","form_guarantor1_address","�ƥ����ȥե�����","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//�ݾڿͣ�
$form->addElement(
        "text","form_guarantor2","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//�ݾڿͣ�����
$form->addElement(
        "text","form_guarantor2_address","�ƥ����ȥե�����","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//�Ķȵ���
$form->addElement(
        "text","form_position","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//����
$form->addElement(
        "text","form_holiday","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//����
$form->addElement(
        "text","form_business_limit","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//������
$form->addElement(
        "text","form_join_money","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\" 
         style=\"text-align: right; $g_form_style\" ".$g_form_option."\""
        );

//�ݾڶ�
$form->addElement(
        "text","form_assure_money","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\" 
         style=\"text-align: right; $g_form_style\"".$g_form_option."\""
        );

//�����ƥ�
$form->addElement(
        "text","form_royalty","�ƥ����ȥե�����","size=\"3\" maxLength=\"3\" 
         style=\"text-align: right; $g_form_style\"".$g_form_option."\""
        );

//�軻��
$form->addElement(
        "text","form_accounts_month","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\"  style=\"text-align: right; $g_form_style\"
        ".$g_form_option."\""
        );

//�軻��
$form->addElement(
        "text","form_accounts_day","�ƥ����ȥե�����","size=\"2\" maxLength=\"2\"  style=\"text-align: right; $g_form_style\"
        ".$g_form_option."\""
        );

//������
$form->addElement(
        "text","form_collect_terms","�ƥ����ȥե�����","size=\"34\" maxLength=\"50\" 
        $g_form_option"
        );

//Ϳ������
$form->addElement(
        "text","form_limit_money","�ƥ����ȥե�����","class=\"money\" size=\"11\" maxLength=\"9\" 
         style=\"text-align: right; $g_form_style\"".$g_form_option."\""
        );

//���ܶ�
$form->addElement(
        "text","form_capital_money","",
        "class=\"money\" size=\"11\" maxLength=\"9\" 
        style=\"text-align: right; $g_form_style\"".$g_form_option.""
        );

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
$form->addElement("select", "form_pay_month", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

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
$form->addElement("select", "form_pay_day", "���쥯�ȥܥå���", $select_day, $g_form_option_select);

//������ˡ
$select_value = Select_Get($conn,'pay_way');
$form->addElement(
        "select","form_pay_way","", $select_value,$g_form_option_select
        );

//����̾��
$form->addElement(
        "text","form_transfer_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"50\" 
        $g_form_option"
        );

//����̾��
$form->addElement(
        "text","form_account_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//������̾
$form->addElement(
        "text","form_contract_name","�ƥ����ȥե�����","size=\"40\" maxLength=\"30\" 
        $g_form_option"
        );

//������ɽ��̾
$form->addElement(
        "text","form_represent_contract","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//Ǽ�ʽ񥳥���
//��¥��ܥ���
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "������̵��","1");
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "���̥�����ͭ��","2");
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "���Υ�����ͭ��","3");
$form->addGroup($form_deliver_radio, "form_deliver_radio", "");
//�ƥ�����
$form->addElement("textarea","form_deli_comment","",' rows="5" cols="75"'." $g_form_option_area");

//�������
$form->addElement("textarea","form_record","",' rows="3" cols="75"'." $g_form_option_area");

//���׻���
$form->addElement("textarea","form_important","",' rows="3" cols="75"'." $g_form_option_area");

//�϶�
$select_ary = Select_Get($conn,'area');
$form->addElement('select', 'form_area_1',"", $select_ary,$g_form_option_select);

//�ȼ�
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_sbtype.sbtype_id,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name";
$sql .= " FROM";
$sql .= "   (SELECT";
$sql .= "       lbtype_id,";
$sql .= "       lbtype_cd,";
$sql .= "       lbtype_name";
$sql .= "   FROM";
$sql .= "       t_lbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_lbtype";
$sql .= "       INNER JOIN";
$sql .= "   (SELECT";
$sql .= "       sbtype_id,";
$sql .= "       lbtype_id,";
$sql .= "       sbtype_cd,";
$sql .= "       sbtype_name";
$sql .= "   FROM";
$sql .= "       t_sbtype";
$sql .= "   WHERE";
$sql .= "       accept_flg = '1'";
$sql .= "   ) AS t_sbtype";
$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);

while($data_list = @pg_fetch_array($result)){
    if($max_len < mb_strwidth($data_list[1])){
        $max_len = mb_strwidth($data_list[1]);
    }
}

$select_value2[""] = "";
$result = Db_Query($conn, $sql);
while($data_list = @pg_fetch_array($result)){
    $space = "";
    for($i = 0; $i< $max_len; $i++){
        if(mb_strwidth($data_list[1]) <= $max_len && $i != 0){
                $data_list[1] = $data_list[1]."��";
        }
    }
    $select_value2[$data_list[2]] = $data_list[0]." �� ".$data_list[1]."���� ".$data_list[3]." �� ".$data_list[4];
}

$form->addElement('select', 'form_btype',"", $select_value2,$g_form_option_select);

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

$select_value3[""] = "";
while($data_list = @pg_fetch_array($result)){
    $select_value3[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_inst',"", $select_value3,$g_form_option_select);

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

$select_value4[""] = "";
while($data_list = @pg_fetch_array($result)){
    $select_value4[$data_list[0]] = $data_list[1]." �� ".$data_list[2];
}
$form->addElement('select', 'form_bstruct',"", $select_value4,$g_form_option_select);

//ô����
for($x=1;$x<=5;$x++){
$select_value5 = Select_Get($conn,'staff');
$form->addElement('select', 'form_staff_'.$x, '���쥯�ȥܥå���', $select_value5,$g_form_option_select);
}

//�����ʬ
$select_value6 = Select_Get($conn,'trade_aord');
$form->addElement('select', 'trade_aord_1', '���쥯�ȥܥå���', $select_value6, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_close_day();\"");

//�����ʬ
$select_value6 = Select_Get($conn,'trade_ord');
$form->addElement('select', 'trade_buy_1', '���쥯�ȥܥå���', $select_value6, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_buy_close_day();\"");

//����
$select_value7 = Select_Get($conn,'close');
$freeze = $form->addElement('select', 'form_close_1', '���쥯�ȥܥå���', $select_value7, 
        "onKeyDown=\"chgKeycode();\" 
        onChange =\"window.focus();trade_close_day();trade_buy_close_day()\"");


$select_ary = Make_Ary_Bank($conn);
$bank_select = $form->addElement('hierselect', 'form_bank_1', '',$g_form_option_select ,"������");
$bank_select->setOptions(array($select_ary[0], $select_ary[1], $select_ary[2]));


//����
$text = null;
$text[] =& $form->createElement( "radio",NULL,NULL, "�����","1");
$text[] =& $form->createElement( "radio",NULL,NULL, "���󡦵ٻ���","2");
//$text[] =& $form->createElement( "radio",NULL,NULL, "����","3");
$form->addGroup($text, "form_state", "");

//��ɼ�ֹ�
$form_slip_issue[] =& $form->createElement("radio",NULL,NULL, "ͭ","1");
$form_slip_issue[] =& $form->createElement("radio",NULL,NULL, "����","2");
$form_slip_issue[] =& $form->createElement("radio",NULL,NULL, "̵","3");
$form->addGroup($form_slip_issue, "form_slip_issue", "��ɼ�ֹ�");

#2010-05-01 hashimoto-y
// �������ե������
$form->addElement("checkbox", "form_bill_address_font", "");


//�����ȯ��
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "���������","1");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "��������","2");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "�������������","5");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "���Ϥ��ʤ�","3");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "����","4");
$form->addGroup($form_claim_issue, "form_claim_issue", "�����ȯ��");
/*
//�����ϰ�
$form_claim_scope[] =& $form->createElement( "radio",NULL,NULL, "���۳ۤ�ޤ��","t");
$form_claim_scope[] =& $form->createElement( "radio",NULL,NULL, "���۳ۤ�ޤ�ʤ�","f");
$form->addGroup($form_claim_scope, "form_claim_scope", "");
*/
//���������
$form_claim_send[] =& $form->createElement( "radio",NULL,NULL, "͹��","1");
$form_claim_send[] =& $form->createElement( "radio",NULL,NULL, "�᡼��","2");
$form_claim_send[] =& $form->createElement( "radio",NULL,NULL, "ξ��","3");
$form->addGroup($form_claim_send, "form_claim_send", "");

//������ͼ�
$select_value = Select_Get($conn,'claim_pattern');
$form->addElement("select","claim_pattern","",$select_value);

//�ޤ���ʬ
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "�ڼ�","1"
         );
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "�ͼθ���","2"
         );
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "�ھ�","3"
         );
$freeze = $form->addGroup($form_coax, "form_coax", "�ޤ���ʬ");
//if($change_flg == true){
//    $freeze->freeze();
//}

//���Ƕ�ʬ
$form_tax_division[] =& $form->createElement(
         "radio",NULL,NULL, "����","1"
         );
$form_tax_division[] =& $form->createElement(
         "radio",NULL,NULL, "����","2"
         );
$form_tax_division[] =& $form->createElement(
         "radio",NULL,NULL, "�����","3"
         );
$freeze = $form->addGroup($form_tax_division, "form_tax_div", "���Ƕ�ʬ");
//if($change_flg == true){
//    $freeze->freeze();
//}

//����ñ��
$form_tax_unit[] =& $form->createElement(
         "radio",NULL,NULL, "����ñ��","1"
         );
$form_tax_unit[] =& $form->createElement(
         "radio",NULL,NULL, "��ɼñ��","2"
         );
$freeze = $form->addGroup($form_tax_unit, "form_tax_unit", "����ñ��");
//if($change_flg == true){
//    $freeze->freeze();
//}

//ü����ʬ
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "�ڼ�","1"
         );
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "�ͼθ���","2"
         );
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "�ھ�","3"
         );
$freeze = $form->addGroup($from_fraction_div, "from_fraction_div", "ü����ʬ");
//if($change_flg == true){
//    $freeze->freeze();
//}

//���Ƕ�ʬ
$form_c_tax_div[] =& $form->createElement(
         "radio",NULL,NULL, "����","1"
         );
#2009-12-25 aoyama-n
#$form_c_tax_div[] =& $form->createElement(
#         "radio",NULL,NULL, "����","2"
#         );
$form_c_tax_div[] =& $form->createElement(
         "radio",NULL,NULL, "�����","3"
         );
$freeze = $form->addGroup($form_c_tax_div, "form_c_tax_div", "���Ƕ�ʬ");
//if($change_flg == true){
//���Ū�˥ե꡼��
#    $freeze->freeze();
//}
#2009-12-25 aoyama-n
if($new_flg == false){
    $freeze->freeze();
}

//������ʡ�����ʬ��
$form->addElement("textarea","form_qualify_pride","�ƥ����ȥե�����"," rows=\"2\" cols=\"75\" $g_form_option_area");

//����
$form->addElement("textarea","form_special_contract","�ƥ����ȥե�����"," rows=\"2\" cols=\"75\" $g_form_option_area");

//����¾
$form->addElement("textarea","form_other","�ƥ����ȥե�����"," rows=\"2\" cols=\"75\" $g_form_option_area");

//��Ͽ�ʥإå���
$form->addElement("button","new_button","��Ͽ����",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('1-1-101.php')\"");

//hidden
$form->addElement("hidden", "input_button_flg");

//����åפ������Ȥ��ư������Υե�����
//��ʧ��
//��ʧ��
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
$form->addElement("select", "form_payout_month", "���쥯�ȥܥå���", $select_month, $g_form_option_select);

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
//$form->addElement("select", "form_payout_day", "���쥯�ȥܥå���", $select_month, $g_form_option_select);
$form->addElement("select", "form_payout_day", "���쥯�ȥܥå���", $select_day, $g_form_option_select);

//���
$form->addElement('text', 'form_bank_name', '', "size=\"95\" maxLength=\"40\" $g_form_option");

//��Ź̾
$form->addElement("text", "form_b_bank_name", "","size=\"47\" maxlength=\"20\" $g_form_option");


/***************************/
//�롼�������QuickForm��
/***************************/
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->registerRule("telfax","function","Chk_Telfax");
//��FC���롼��
//��ɬ�ܥ����å�
//$form->addRule("form_shop_gr_1", "FC���롼�פ����򤷤Ƥ���������","required");
$form->addRule("form_rank", "FC��������ʬ�����򤷤Ʋ�������","required");

//���ȼ�
//��ɬ�ܥ����å�
$form->addRule("form_btype", "�ȼ�����򤷤Ʋ�������","required");

//������åץ�����
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_shop_cd', array(
        'cd1' => array(
                array('����åץ����ɤ�Ⱦ�ѿ����ΤߤǤ���', 'required'),
                array('����åץ����ɤ�Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/")
        ),
        'cd2' => array(
                array('����åץ����ɤ�Ⱦ�ѿ����ΤߤǤ���','required'),
                array('����åץ����ɤ�Ⱦ�ѿ����ΤߤǤ���',"regex", "/^[0-9]+$/")
        ),
));

//������å�̾
//��ɬ�ܥ����å�
$form->addRule("form_shop_name", "����å�̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_shop_name", "����å�̾�� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//��ά��
//��ɬ�ܥ����å�
$form->addRule("form_shop_cname", "ά�Τ�1ʸ���ʾ�20ʸ���ʲ��Ǥ���","required");
$form->addRule("form_shop_cname", "ά�Τ� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//����̾
//��ɬ�ܥ����å�
$form->addRule("form_comp_name", "��̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");

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

//���϶�
//��ɬ�ܥ����å�
$form->addRule("form_area_1", "�϶�����򤷤Ʋ�������","required");

//��TEL
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_tel", "TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���", "required");
$form->addRule("form_tel","TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

//����ɽ�Ի�̾
//��ɬ�ܥ����å�
$form->addRule("form_represent_name", "��ɽ�Ի�̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//��������
//��Ⱦ�ѿ��������å�
$form->addRule("form_join_money", "�������Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//���ݾڶ�
//��Ⱦ�ѿ��������å�
$form->addRule("form_assure_money", "�ݾڶ��Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//�������ƥ�
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_royalty", "�����ƥ���Ⱦ�ѿ����Τ�1ʸ���ʾ�3ʸ���ʲ��Ǥ���","required");
$form->addRule("form_royalty", "�����ƥ���Ⱦ�ѿ����Τ�1ʸ���ʾ�3ʸ���ʲ��Ǥ���","regex", "/^[0-9]+$/");

//���軻��
//��Ⱦ�ѿ��������å�
$form->addRule("form_accounts_month", "�軻���Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//��Ϳ������
//��Ⱦ�ѿ��������å�
$form->addRule("form_limit_money", "Ϳ�����٤�Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//�����ܶ�
//��Ⱦ�ѿ��������å�
$form->addRule("form_capital_money", "���ܶ��Ⱦ�ѿ����ΤߤǤ���","regex", "/^[0-9]+$/");

//������
//��ɬ�ܥ����å�
$form->addRule("form_close_1", "���������򤷤Ƥ���������","required");

//�������ʬ
//��ɬ�ܥ����å�
$form->addRule("trade_aord_1", "�������Ѥμ����ʬ�����򤷤Ƥ���������","required");

//�������ʬ
//��ɬ�ܥ����å�
$form->addRule("trade_buy_1", "�������Ѥμ����ʬ�����򤷤Ƥ���������","required");

//���������ʷ��
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_month", "�������ʷ�ˤ����򤷤Ʋ�������", "required");

//��������������
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_pay_day", "�����������ˤ����򤷤Ʋ�������", "required");

//������ǯ����
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('����ǯ���������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));
//���������
//��Ⱦ�ѿ��������å�
$form->addRule("form_cont_peri", "������֤�Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

//�����󹹿���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(
                array('���󹹿��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
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

//��ˡ���е���
//��Ⱦ�ѿ��������å�
$form->addGroupRule('form_corpo_day', array(
        'y' => array(
                array('ˡ���е��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('ˡ���е��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('ˡ���е��������դ������ǤϤ���ޤ���',"regex", "/^[0-9]+$/")
        ),
));

//��Ǽ�ʽ񥳥���
//��ʸ���������å�
$form->addRule("form_deli_comment", "Ǽ�ʽ񥳥��Ȥ�50ʸ������Ǥ���", "mb_maxlength",'50');

//���������ʷ��
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_payout_month", "��ʧ���ʷ�ˤ����򤷤Ʋ�������", "required");

//��������������
//��ɬ�ܥ����å�
//��Ⱦ�ѿ��������å�
$form->addRule("form_payout_day", "��ʧ�������ˤ����򤷤Ʋ�������", "required");
/***************************/
//�롼�������PHP��
/***************************/
if($_POST["button"]["entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST����
    /****************************/
    $rank_cd             = $_POST["form_rank"];                //�ܵҶ�ʬ������
    $form_state          = $_POST["form_state"];               //����
    $shop_cd1            = $_POST["form_shop_cd"]["cd1"];      //����åץ�����1
    $shop_cd2            = $_POST["form_shop_cd"]["cd2"];      //����åץ�����2
    $shop_name           = $_POST["form_shop_name"];           //����å�̾
    $shop_name_read      = $_POST["form_shop_read"];           //����å�̾(�եꥬ��)
    $shop_cname          = $_POST["form_shop_cname"];          //ά��
    $comp_name           = $_POST["form_comp_name"];           //��̾
    $comp_name_read      = $_POST["form_comp_read"];           //��̾(�եꥬ��)
    $comp_name2          = $_POST["form_comp_name2"];          //��̾
    $comp_name_read2     = $_POST["form_comp_read2"];          //��̾(�եꥬ��)
    $post_no1            = $_POST["form_post"]["no1"];         //͹���ֹ�
    $post_no2            = $_POST["form_post"]["no2"];         //͹���ֹ�
    $address1            = $_POST["form_address1"];            //����1
    $address2            = $_POST["form_address2"];            //����2
    $address3            = $_POST["form_address3"];            //����2
    $address_read        = $_POST["form_address_read"];        //����(�եꥬ��)
    $area_id             = $_POST["form_area_1"];              //�϶�
    $tel                 = $_POST["form_tel"];                 //TEL
    $fax                 = $_POST["form_fax"];                 //FAX
    $url                 = $_POST["form_url"];                 //URL
    $claim_cd1           = $_POST["form_claim"]["cd1"];        //�����襳����1
    $claim_cd2           = $_POST["form_claim"]["cd2"];        //�����襳����2
    $claim_name          = $_POST["form_claim"]["name"];       //������̾
    $sv                  = $_POST["form_staff_1"];             //SV
    $staff1              = $_POST["form_staff_2"];             //ô����
    $staff2              = $_POST["form_staff_3"];             //ô����
    $staff3              = $_POST["form_staff_4"];             //ô����
    $staff4              = $_POST["form_staff_5"];             //ô����
    $represent_name      = $_POST["form_represent_name"];      //��ɽ�Ի�̾
    $represent_position  = $_POST["form_represent_position"];  //��ɽ����
    $represent_cell      = $_POST["form_represent_cell"];      //��ɽ�Է���
    $contact_name        = $_POST["form_contact_name"];        //Ϣ��ô���Ի�̾
    $contact_position    = $_POST["form_contact_position"];    //Ϣ��ô������
    $contact_cell        = $_POST["form_contact_cell"];        //Ϣ��ô���Է���
    $guarantor1          = $_POST["form_guarantor1"];          //�ݾڿͣ�
    $guarantor1_address  = $_POST["form_guarantor1_address"];  //�ݾڿͣ�����
    $guarantor2          = $_POST["form_guarantor2"];          //�ݾڿͣ�
    $guarantor2_address  = $_POST["form_guarantor2_address"];  //�ݾڿͣ�����
    $position            = $_POST["form_position"];            //�Ķȵ���
    $holiday             = $_POST["form_holiday"];             //����
    $business_limit      = $_POST["form_business_limit"];      //����
    $join_money          = $_POST["form_join_money"];          //������
    $assure_money        = $_POST["form_assure_money"];        //�ݾڶ�
    $royalty             = $_POST["form_royalty"];             //�����ƥ�
    $accounts_month      = $_POST["form_accounts_month"];      //�軻��
    $collect_terms       = $_POST["form_collect_terms"];       //������
    $limit_money         = $_POST["form_limit_money"];         //Ϳ������
    $capital_money       = $_POST["form_capital_money"];       //���ܶ�
    $aord_div            = $_POST["trade_aord_1"];             //�������Ѽ����ʬ
    $buy_div             = $_POST["trade_buy_1"];              //�������Ѽ����ʬ
    $close_day           = $_POST["form_close_1"];             //����
    $pay_month           = $_POST["form_pay_month"];           //������(��)
    $pay_day             = $_POST["form_pay_day"];             //������(��)
    $pay_way             = $_POST["form_pay_way"];             //������ˡ
    $transfer_name       = $_POST["form_transfer_name"];       //����̾��
    $account_name        = $_POST["form_account_name"];        //����̾��
    $bank                = $_POST["form_bank_1"][2];              //�������
    $contract_name       = $_POST["form_contract_name"];       //������̾
    $represent_contract  = $_POST["form_represent_contract"];  //������ɽ̾
    $cont_s_day          = $_POST["form_cont_s_day"]["y"];     //����ǯ����(ǯ)
    $cont_s_day         .= "-";
    $cont_s_day         .= $_POST["form_cont_s_day"]["m"];     //����ǯ����(��)
    $cont_s_day         .= "-";
    $cont_s_day         .= $_POST["form_cont_s_day"]["d"];     //����ǯ����(��)
    $cont_e_day          = $_POST["form_cont_e_day"]["y"];     //����λ��(ǯ)
    $cont_e_day         .= "-";
    $cont_e_day         .= $_POST["form_cont_e_day"]["m"];     //����λ��(��)
    $cont_e_day         .= "-";
    $cont_e_day         .= $_POST["form_cont_e_day"]["d"];     //����λ��(��)
    $cont_peri           = $_POST["form_cont_peri"];           //�������
    $cont_r_day          = $_POST["form_cont_r_day"]["y"];     //���󹹿���(ǯ)
    $cont_r_day         .= "-";
    $cont_r_day         .= $_POST["form_cont_r_day"]["m"];     //���󹹿���(��)
    $cont_r_day         .= "-";
    $cont_r_day         .= $_POST["form_cont_r_day"]["d"];     //���󹹿���(��)
    $establish_day       = $_POST["form_establish_day"]["y"];  //�϶���(ǯ)
    $establish_day      .= "-";
    $establish_day      .= $_POST["form_establish_day"]["m"];  //�϶���(��)
    $establish_day      .= "-";
    $establish_day      .= $_POST["form_establish_day"]["d"];  //�϶���(��)
    $corpo_day           = $_POST["form_corpo_day"]["y"];      //ˡ���е���(ǯ)
    $corpo_day          .= "-";
    $corpo_day          .= $_POST["form_corpo_day"]["m"];      //ˡ���е���(��)
    $corpo_day          .= "-";
    $corpo_day          .= $_POST["form_corpo_day"]["d"];      //ˡ���е���(��)
    $slip_issue          = $_POST["form_slip_issue"];          //��ɼȯ��
    $deli_comment        = $_POST["form_deli_comment"];        //Ǽ�ʽ񥳥���
    $claim_issue         = $_POST["form_claim_issue"];         //�����ȯ��
    $coax                = $_POST["form_coax"];                //�ޤ���ʬ
    $tax_div             = $_POST["form_tax_div"];             //���Ƕ�ʬ
    $tax_unit            = $_POST["form_tax_unit"];            //����ñ��
    $fraction_div        = $_POST["from_fraction_div"];        //ü����ʬ
    $qualify_pride       = $_POST["form_qualify_pride"];       //������ʡ�����ʬ�� 
    $special_contract    = $_POST["form_special_contract"];    //����
    $other               = $_POST["form_other"];               //����¾
    $btype               = $_POST["form_btype"];               //�ȼ�
    $inst                = $_POST["form_inst"];                //����
    $bstruct             = $_POST["form_bstruct"];             //����
    $accountant_name     = $_POST["form_accountant_name"];     //���ô���Ի�̾
    $cname_read          = $_POST["form_cname_read"];          //ά��(�եꥬ��)
    $email               = $_POST["form_email"];               //Email
    $direct_tel          = $_POST["form_direct_tel"];          //ľ��TEL
    $record              = $_POST["form_record"];              //�������
    $important           = $_POST["form_important"];           //���׻���
    $deliver_effect      = $_POST["form_deliver_radio"];       //Ǽ�ʽ񥳥���(����)
    $claim_send          = $_POST["form_claim_send"];          //���������
    $accounts_day       .= $_POST["form_accounts_day"];        //�軻��(��)
    $account_tel         = $_POST["form_account_tel"];         //��פ�ô���Է���
    $prefix              = $_POST["form_prefix"];              //�ɾ�
    $claim_pattern       = $_POST["claim_pattern"];            //������ͼ�
    $c_tax_div           = $_POST["form_c_tax_div"];           //���Ƕ�ʬ

    //������Ȥ��Ƥξ�������
    $bank_name           = $_POST["form_bank_name"];            //��������̾
    $b_bank_name         = $_POST["form_b_bank_name"];          //��������̾ά��
    $payout_m            = $_POST["form_payout_month"];            //��ʧ��
    $payout_d            = $_POST["form_payout_day"];             //��ʧ��

    #2010-04-30 hashimoto-y
    $bill_address_font      = ($_POST["form_bill_address_font"] == '1')? 't' : 'f'; //������ե����

    /***************************/
    //�����
    /***************************/
    //�����襳���ɣ�
    $shop_cd1 = str_pad($shop_cd1, 6, 0, STR_POS_LEFT);

    //�����襳���ɣ�
    $shop_cd2 = str_pad($shop_cd2, 4, 0, STR_POS_LEFT);


/***************************/
//�롼�������PHP��
/***************************/
    //����åץ�����
    if($shop_cd1 != null && $shop_cd2 != null){
        if($fc_data[3] != $shop_cd1 || $fc_data[4] != $shop_cd2){
            $shop_cd_sql  = "SELECT";
            $shop_cd_sql  .= " client_id FROM t_client";
            $shop_cd_sql  .= " WHERE";
            $shop_cd_sql  .= " client_cd1 = '$shop_cd1'";
            $shop_cd_sql  .= " AND";
            $shop_cd_sql  .= " client_cd2 = '$shop_cd2'";
            $shop_cd_sql  .= " AND";
            $shop_cd_sql  .= " client_div = '3'";
            $shop_cd_sql  .= ";";
            $select_shop = Db_Query($conn, $shop_cd_sql);
            $select_shop = @pg_num_rows($select_shop);
            if($select_shop != 0){
                $shop_cd_err = "���Ϥ��줿����åץ����ɤϻ�����Ǥ���";
                $err_flg = true;
            }
        }
    }
    
    //��FAX
    $form->addRule("form_fax","FAX��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    //Email
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

    //��ľ��TEL
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_direct_tel","ľ��TEL��Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    //����פ�ô������
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_account_tel","��פ�ô���Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    //����ɽ�Է���
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_represent_cell","��ɽ�Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    //��Ϣ��ô���Է���
    //��Ⱦ�ѿ����ȡ�-�װʳ��ϥ��顼
    $form->addRule("form_contact_cell","Ϣ��ô���Է��Ӥ�Ⱦ�ѿ����Ȏ�-���Τ�30�����Ǥ���","telfax");

    //��������
    if($aord_div == '61' && ($close_day != $pay_day || $pay_month != '0')){
        $close_day_err = "�����ʬ�˸������ꤷ�����ν�����������������ˤ��Ʋ�������";
        $err_flg = true;
    }elseif($aord_div == '11' && $pay_month == "0" && ($close_day >= $pay_day)){
        $close_day_err = "����������������������դ�����Ǥ��ޤ���";
        $err_flg = true;
    }

    //����ʧ��
    if($buy_div == '71' && ($close_day != $payout_d || $payout_m != '0')){
        $close_outday_err = "�����ʬ�˸������ꤷ�����λ�ʧ��������������ˤ��Ʋ�������";
        $err_flg = true;
    }elseif($buy_div == '21' && $payout_m == "0" && ($close_day >= $payout_d)){
        $close_outday_err = "��ʧ�����������������դ�����Ǥ��ޤ���";
        $err_flg = true;
    }
    
    //��������
    //�����ϥ����å�
    if($shop_cd1 == $claim_cd1 && $shop_cd2 == $claim_cd2){
        $claim_flg = true;
    }elseif($claim_cd1 == null && $claim_cd2 == null && $claim_name == null){
        $claim_flg = true;
    }elseif(($_POST["form_claim"]["cd1"] != null || $_POST["form_claim"]["cd2"] != null) && $_POST["form_claim"]["name"] == null){
        $claim_err = "�����������襳���ɤ����Ϥ��Ʋ�������";
        $err_flg = true;

    // �����������褬���Ϥ��줿���
    }elseif($claim_cd1 != null && $claim_cd2 != null && $claim_name != null){
        $sql  = "SELECT";
        $sql .= "   close_day,";
        $sql .= "   coax,";
        $sql .= "   tax_div,";
        $sql .= "   tax_franct,";
        $sql .= "   c_tax_div,";
        $sql .= "   pay_m,";
        $sql .= "   pay_d ";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= " WHERE";
        $sql .= "   client_cd1 = '$claim_cd1'";
        $sql .= "   AND";
        $sql .= "   client_cd2 = '$claim_cd2'";
        $sql .= "   AND";
        $sql .= "   client_div = '3'";
        $sql .= "   AND";
        $sql .= "   shop_id = $shop_id";
        $sql .= ";"; 

        $result = Db_Query($conn ,$sql); 
        $claim_data = @pg_fetch_array($result ,0 );
        $claim_close_day  = $claim_data["close_day"];    //������
        $claim_coax       = $claim_data["coax"];         //�ݤ��ʬ
        $claim_tax_div    = $claim_data["tax_div"];      //����ñ��
        $claim_tax_franct = $claim_data["tax_franct"];   //ü����ʬ 
        $claim_c_tax_div  = $claim_data["c_tax_div"];    //���Ƕ�ʬ
        $claim_pay_m      = $claim_data["pay_m"];        //�������ʷ��
        $claim_pay_d      = $claim_data["pay_d"];        //������������

        //���������������Ʊ���ǤϤʤ�����������
        if($close_day != $claim_close_day){
            // ����Ƚ��
            if($claim_close_day == "29"){
                $claim_close_day_err = "�������������Ʊ�� ���� �����򤷤Ʋ�������";
            }else{  
                $claim_close_day_err = "�������������Ʊ�� ".$claim_close_day."�� �����򤷤Ʋ�������";
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

            $claim_coax_err = "�ޤ���ʬ���������Ʊ�� ".$claim_coax." �����򤷤Ʋ�������";
            $err_flg = true;
        }

        //������β���ñ�̤�Ʊ���ǤϤʤ�����������
        if($tax_unit != $claim_tax_div){
            //���顼��å�������ɽ�����뤿�����ñ�̤��ִ�
            if($claim_tax_div == '2'){
                $claim_tax_div = "��ɼñ��";
            }elseif($claim_tax_div == '1'){
                $claim_tax_div = "����ñ��";
            }

            $claim_tax_div_err = "����ñ�̤��������Ʊ�� ".$claim_tax_div." �����򤷤Ʋ�������";
            $err_flg = true;
        }

        //�������ü����ʬ��Ʊ���ǤϤʤ�����������
        if($fraction_div != $claim_tax_franct){

            //���顼��å�������ɽ�����뤿��ü����ʬ���ִ�
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
            #2005-12-25 aoyama-n
            #}elseif($claim_c_tax_div == '2'){
            #    $claim_c_tax_div = "����";
            #}
            }elseif($claim_c_tax_div == '3'){
                $claim_c_tax_div = "�����";
            }

            $claim_c_tax_div_err = "���Ƕ�ʬ���������Ʊ�� ".$claim_c_tax_div." �����򤷤Ʋ�������";
            $err_flg = true;
        }
        //������ν������ʷ�ˤ�Ʊ���ǤϤʤ�����������
        if($pay_m != $claim_pay_m){

            //���顼��å�������ɽ�����뤿�ὸ�����ʷ�ˤ��ִ�
            if($claim_pay_m == '0'){
                $claim_pay_m = "����";
            }elseif($claim_pay_m == '1'){
                $claim_pay_m = "���";
            }else{
                $claim_pay_m = $claim_pay_m."�����";
            }

            $claim_pay_m_err = "���������������Ʊ�� ".$claim_pay_m." �����򤷤Ʋ�������";
        }
    }

    //������ǯ���������󹹿���
    //�����դ������������å�
    $sday_y = (int)$_POST["form_cont_s_day"]["y"];
    $sday_m = (int)$_POST["form_cont_s_day"]["m"];
    $sday_d = (int)$_POST["form_cont_s_day"]["d"];
    $rday_y = (int)$_POST["form_cont_r_day"]["y"];
    $rday_m = (int)$_POST["form_cont_r_day"]["m"];
    $rday_d = (int)$_POST["form_cont_r_day"]["d"];
    $eday_y = (int)$_POST["form_establish_day"]["y"];
    $eday_m = (int)$_POST["form_establish_day"]["m"];
    $eday_d = (int)$_POST["form_establish_day"]["d"];
    $cday_y = (int)$_POST["form_corpo_day"]["y"];
    $cday_m = (int)$_POST["form_corpo_day"]["m"];
    $cday_d = (int)$_POST["form_corpo_day"]["d"];

    //����ǯ����
    if($sday_m != null || $sday_d != null || $sday_y != null){
        $sday_flg = true;
    }
    $check_s_day = checkdate($sday_m,$sday_d,$sday_y);
    if($check_s_day == false && $sday_flg == true){
        $sday_err = "����ǯ���������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //���󹹿���
    if($rday_m != null || $rday_d != null || $rday_y != null){
        $rday_flg = true;
    }
    $check_r_day = checkdate($rday_m,$rday_d,$rday_y);
    if($check_r_day == false && $rday_flg == true){
        $rday_err = "���󹹿��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //�����󹹿���������ǯ�����������Ǥʤ��������å�
    if($cont_s_day >= $cont_r_day && $cont_s_day != '--' && $cont_r_day != '--'){
        $sday_rday_err = "���󹹿��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //�϶���
    if($eday_m != null || $eday_d != null || $eday_y != null){
        $eday_flg = true;
    }
    $check_e_day = checkdate($eday_m,$eday_d,$eday_y);
    if($check_e_day == false && $eday_flg == true){
        $eday_err = "�϶��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    //ˡ���е���
    if($cday_m != null || $cday_d != null || $cday_y != null){
        $cday_flg = true;
    }
    $check_c_day = checkdate($cday_m,$cday_d,$cday_y);
    if($check_c_day == false && $cday_flg == true){
        $cday_err = "ˡ���е��������դ������ǤϤ���ޤ���";
        $err_flg = true;
    }

    #2010-05-01 hashimoto-y
    //������ե���ȥ���������˥����å�������ʲ��ξ���Ķ���Ƥʤ��������å�
    //���꣱��20 , ���ꣲ��20 , ���ꣳ��28 , ��̾����20 , ��̾����20
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
        if( mb_strlen($comp_name) > 14 ){
            $comp_name1_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢��̾���ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
        if( mb_strlen($comp_name2) > 14 ){
            $comp_name2_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢��̾���ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
        if( mb_strlen($shop_name) > 14 ){
            $shop_name_err = "�����ΰ���ȥ�٥�Υե���ȥ��������礭�������硢����å�̾�ϣ���ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }
    }

}

if($_POST["button"]["entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true ){
    /******************************/
    //��Ͽ����
    /******************************/
    Db_Query($conn, "BEGIN;");
    if($new_flg == true){
        //�����ޥ���
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    rank_cd,";                          //�ܵҶ�ʬ
        $insert_sql .= "    client_id,";                        //������ID
        $insert_sql .= "    shop_id,";                          //����å�ID
        $insert_sql .= "    create_day,";                       //������
        $insert_sql .= "    client_cd1,";                       //�����襳����
        $insert_sql .= "    client_cd2,";                       //��Ź������
        $insert_sql .= "    state,";                            //����
        $insert_sql .= "    client_name,";                      //������̾
        $insert_sql .= "    client_read,";                      //������̾�ʥեꥬ�ʡ�
        $insert_sql .= "    client_cname,";                     //ά��
        $insert_sql .= "    post_no1,";                         //͹���ֹ棱
        $insert_sql .= "    post_no2,";                         //͹���ֹ棲
        $insert_sql .= "    address1,";                         //���꣱
        $insert_sql .= "    address2,";                         //���ꣲ
        $insert_sql .= "    address3,";                         //���ꣳ
        $insert_sql .= "    address_read,";                     //����ʥեꥬ�ʡ�
        $insert_sql .= "    area_id,";                          //�϶�ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //��ɽ��̾
        $insert_sql .= "    sv_staff_id,";                      //SV
        $insert_sql .= "    b_staff_id1,";                      //ô����
        $insert_sql .= "    b_staff_id2,";                      //ô����
        $insert_sql .= "    b_staff_id3,";                      //ô����
        $insert_sql .= "    b_staff_id4,";                      //ô����
        $insert_sql .= "    charger_name,";                     //��ô���ԣ�
        $insert_sql .= "    holiday,";                          //����
        $insert_sql .= "    col_terms,";                        //������
        $insert_sql .= "    credit_limit,";                     //Ϳ������
        $insert_sql .= "    capital,";                          //���ܶ�
        $insert_sql .= "    trade_id,";                         //�����ʬ���������ѡ�
        $insert_sql .= "    buy_trade_id,";                     //�����ʬ�ʻ������ѡ�
        $insert_sql .= "    close_day,";                        //����
        $insert_sql .= "    pay_m,";                            //�������ʷ��
        $insert_sql .= "    pay_d,";                            //������������
        $insert_sql .= "    pay_way,";                          //������ˡ
        $insert_sql .= "    account_name,";                     //����̾��
        $insert_sql .= "    pay_name,";                         //����̾��
        $insert_sql .= "    account_id,";                          //����ID
        $insert_sql .= "    cont_sday,";                        //���󳫻���
        $insert_sql .= "    cont_eday,";                        //����λ��
        $insert_sql .= "    cont_peri,";                        //�������
        $insert_sql .= "    cont_rday,";                        //���󹹿���
        $insert_sql .= "    slip_out,";                         //��ɼ����
        $insert_sql .= "    deliver_note,";                     //Ǽ�ʽ񥳥���
        $insert_sql .= "    claim_out,";                        //��������
        $insert_sql .= "    coax,";                             //��ۡ��ݤ��ʬ
        $insert_sql .= "    tax_div,";                          //�����ǡ�����ñ��
        $insert_sql .= "    tax_franct,";                       //�����ǡ�ü����ʬ
        $insert_sql .= "    client_div,";                       //�������ʬ
        $insert_sql .= "    shop_name,";                        //��̾
        $insert_sql .= "    shop_read,";                        //��̾(�եꥬ��)
        $insert_sql .= "    shop_name2,";                       //��̾2
        $insert_sql .= "    shop_read2,";                       //��̾2(�եꥬ��)
        $insert_sql .= "    url,";                              //URL
        $insert_sql .= "    represe,";                          //��ɽ����
        $insert_sql .= "    rep_htel,";                         //��ɽ�Է���
        $insert_sql .= "    charger,";                          //Ϣ��ô������
        $insert_sql .= "    cha_htel,";                         //Ϣ��ô���Է���
        $insert_sql .= "    surety_name1,";                     //�ݾڿͣ�̾��
        $insert_sql .= "    surety_addr1,";                     //�ݾڿͣ�����
        $insert_sql .= "    surety_name2,";                     //�ݾڿͣ�̾��
        $insert_sql .= "    surety_addr2,";                     //�ݾڿͣ�����
        $insert_sql .= "    trade_base,";                       //�Ķȵ���
        $insert_sql .= "    trade_area,";                       //����
        $insert_sql .= "    join_money,";                       //������
        $insert_sql .= "    guarant_money,";                    //�ݾڶ�
        $insert_sql .= "    royalty_rate,";                     //�����ƥ�
        $insert_sql .= "    cutoff_month,";                      //�軻��
        $insert_sql .= "    c_compa_name,";                     //������̾
        $insert_sql .= "    c_compa_rep,";                      //������ɽ��
        $insert_sql .= "    license,";                          //��ͭ��ʡ�����ʬ��
        $insert_sql .= "    s_contract,";                       //����
        $insert_sql .= "    other,";                            //����¾
        $insert_sql .= "    establish_day,";                    //�϶���
        $insert_sql .= "    regist_day,";                       //ˡ���е���
        $insert_sql .= "    sbtype_id,";                        //�ȼ�
        $insert_sql .= "    inst_id,";                          //����
        $insert_sql .= "    b_struct,";                         //����
        $insert_sql .= "    accountant_name,";                  //���ô���Ի�̾
        $insert_sql .= "    client_cread,";                     //ά��(�եꥬ��)
        $insert_sql .= "    email,";                            //Email
        $insert_sql .= "    direct_tel,";                       //ľ��TEL
        $insert_sql .= "    deal_history,";                     //�������
        $insert_sql .= "    importance,";                       //���׻���
        $insert_sql .= "    deliver_effect,";                   //Ǽ�ʽ񥳥���(����)
        $insert_sql .= "    claim_send,";                       //���������(͹��)
        $insert_sql .= "    cutoff_day,";                       //�軻��
        #2009-12-25 aoyama-n
        #$insert_sql .= "    tax_rate_n,";                       //������Ψ(����)
        $insert_sql .= "    account_tel,";                      //��פ�ô����TEL
	    $insert_sql .= "    compellation,";                     //�ɾ�
	    $insert_sql .= "    c_pattern_id,";                     //������ͼ�
        $insert_sql .= "    c_tax_div,";                         //���Ƕ�ʬ
//��������ϻ��������
        $insert_sql .= "    payout_m,";                         //��ʧ��
        $insert_sql .= "    payout_d,";                         //��ʧ��
        $insert_sql .= "    bank_name,";                        //����̾��
        $insert_sql .= "    b_bank_name,";                      //����̾��ά��
//���ҥץ�ե������Ѥ���Ͽ
        $insert_sql .= "    my_coax,\n";                        //�ޤ��
        $insert_sql .= "    my_tax_franct,\n";                  //ü����ʬ
        $insert_sql .= "    my_pay_m,\n";                       //���ͽ����
        $insert_sql .= "    my_pay_d,\n";                       //���ͽ����
        $insert_sql .= "    my_close_day,\n";                   //����
        $insert_sql .= "    claim_set, \n";                     //�����ֹ�����  
        #2009-12-25 aoyama-n
        #$insert_sql .= "    cal_peri\n";                        //��������ɽ������
        $insert_sql .= "    cal_peri,\n";                        //��������ɽ������
        $insert_sql .= "    tax_rate_old,\n";                   //�������Ψ
        $insert_sql .= "    tax_rate_now,\n";                   //��������Ψ
        $insert_sql .= "    tax_change_day_now,\n";             //����Ψ������
        $insert_sql .= "    tax_rate_new,\n";                   //��������Ψ
        $insert_sql .= "    tax_change_day_new,\n";             //����Ψ������
        #2010-05-01 hashimoto-y
        $insert_sql .= "    bill_address_font \n";              //�������ե����
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    '$rank_cd',";                          //�ܵҶ�ʬ
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";//������ID
        $insert_sql .= "    $shop_id,";                        //FC���롼��ID
        $insert_sql .= "    NOW(),";                            //������
        $insert_sql .= "    '$shop_cd1',";                      //�����襳����
        $insert_sql .= "    '$shop_cd2',";                      //��Ź������
        $insert_sql .= "    '$form_state',";                    //����
        $insert_sql .= "    '$shop_name',";                     //������̾
        $insert_sql .= "    '$shop_name_read',";                //������ʥեꥬ�ʡ�
        $insert_sql .= "    '$shop_cname',";                    //ά��
        $insert_sql .= "    '$post_no1',";                      //͹���ֹ棱
        $insert_sql .= "    '$post_no2',";                      //͹���ֹ棲
        $insert_sql .= "    '$address1',";                      //���꣱
        $insert_sql .= "    '$address2',";                      //���ꣲ
        $insert_sql .= "    '$address3',";                      //���ꣳ
        $insert_sql .= "    '$address_read',";                  //����ʥեꥬ�ʡ�
        $insert_sql .= "    $area_id,";                         //�϶�ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$represent_name',";                //��ɽ�Ի�̾
        if($sv == ""){
                $sv = "    null"; 
        }
        if($staff1 == ""){
                $staff1 = "    null";
        }
        if($staff2 == ""){
                $staff2 = "    null";
        }
        if($staff3 == ""){
                $staff3 = "    null";
        }
        if($staff4 == ""){
                $staff4 = "    null";
        }
        $insert_sql .= "    $sv,";                              //����ô����
        $insert_sql .= "    $staff1,";                          //����ô����
        $insert_sql .= "    $staff2,";                          //���ô����
        $insert_sql .= "    $staff3,";                          //���ô����
        $insert_sql .= "    $staff4,";                          //���ô����
        $insert_sql .= "    '$contact_name',";                  //��ô���ԣ�
        $insert_sql .= "    '$holiday',";                       //����
        $insert_sql .= "    '$collect_terms',";                 //������
        $insert_sql .= "    '$limit_money',";                   //Ϳ������
        $insert_sql .= "    '$capital_money',";                 //���ܶ�
        $insert_sql .= "    '$aord_div',";                      //�����ʬ��������
        $insert_sql .= "    '$buy_div',";                       //�����ʬ��������
        $insert_sql .= "    '$close_day',";                     //����
        if($pay_month == ""){
                $pay_month = "    null"; 
        }
        $insert_sql .= "    '$pay_month',";                     //�������ʷ��
        if($pay_day == ""){
                $pay_day = "    null"; 
        }
        $insert_sql .= "    '$pay_day',";                       //������������
        $insert_sql .= "    '$pay_way',";                       //������ˡ
        $insert_sql .= "    '$account_name',";                  //����̾��
        $insert_sql .= "    '$transfer_name',";                 //����̾��
        if($bank == ""){
                $bank = "    null"; 
        }
        $insert_sql .= "    $bank,";                            //���
        if($cont_s_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_s_day',";                //���󳫻���
        }
        if($cont_e_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_e_day',";                //����λ��
        }
        if($cont_peri == ""){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_peri',";                 //�������
        }
        if($cont_r_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_r_day',";                //���󹹿���
        }
        $insert_sql .= "    '$slip_issue',";                    //��ɼ����
        $insert_sql .= "    '$deli_comment',";                  //Ǽ�ʽ񥳥���
        $insert_sql .= "    '$claim_issue',";                   //��������
        $insert_sql .= "    '$coax',";                          //��ۡ��ݤ��ʬ
        $insert_sql .= "    '$tax_unit',";                      //�����ǡ�����ñ��
        $insert_sql .= "    '$fraction_div',";                  //�����ǡ�ü��ñ��
        $insert_sql .= "    '3',";                              //�������ʬ
        $insert_sql .= "    '$comp_name',";                     //��̾
        $insert_sql .= "    '$comp_name_read',";                //��̾(�եꥬ��)
        $insert_sql .= "    '$comp_name2',";                    //��̾2
        $insert_sql .= "    '$comp_name_read2',";               //��̾2(�եꥬ��)
        $insert_sql .= "    '$url',";                           //URL
        $insert_sql .= "    '$represent_position',";            //��ɽ����
        $insert_sql .= "    '$represent_cell',";                //��ɽ�Է���
        $insert_sql .= "    '$contact_position',";              //Ϣ��ô������
        $insert_sql .= "    '$contact_cell',";                  //Ϣ��ô���Է���
        $insert_sql .= "    '$guarantor1',";                    //�ݾڿͣ�̾��
        $insert_sql .= "    '$guarantor1_address',";            //�ݾڿͣ�����
        $insert_sql .= "    '$guarantor2',";                    //�ݾڿͣ�̾��
        $insert_sql .= "    '$guarantor2_address',";            //�ݾڿͣ�����
        $insert_sql .= "    '$position',";                      //�Ķȵ���
        $insert_sql .= "    '$business_limit',";                //����
        $insert_sql .= "    '$join_money',";                    //������
        $insert_sql .= "    '$assure_money',";                  //�ݾڶ�
        $insert_sql .= "    '$royalty',";                       //�����ƥ�
        $insert_sql .= "    '$accounts_month',";                //�軻��
        $insert_sql .= "    '$contract_name',";                 //������̾
        $insert_sql .= "    '$represent_contract',";            //������ɽ��
        $insert_sql .= "    '$qualify_pride',";                 //��ͭ��ʡ�����ʬ��
        $insert_sql .= "    '$special_contract',";              //����
        $insert_sql .= "    '$other',";                         //����¾
        if($establish_day == "--"){
        $insert_sql .= "    null,";                             //������
        }else{
        $insert_sql .= "    '$establish_day',";
        }
        if($corpo_day == "--"){
        $insert_sql .= "    null,";                              //ˡ���е���
        }else{
        $insert_sql .= "    '$corpo_day',";
        }
        $insert_sql .= "    $btype,";                           //�ȼ�
        if($inst == ""){
                $inst = "    null"; 
        }
        $insert_sql .= "    $inst,";                            //����
        if($bstruct == ""){
                $bstruct = "    null"; 
        }
        $insert_sql .= "    $bstruct,";                         //����
        $insert_sql .= "    '$accountant_name',";               //���ô���Ի�̾
        $insert_sql .= "    '$cname_read',";                    //ά��(�եꥬ��)
        $insert_sql .= "    '$email',";                         //Email
        $insert_sql .= "    '$direct_tel',";                    //ľ��TEL
        $insert_sql .= "    '$record',";                        //�������
        $insert_sql .= "    '$important',";                     //���׻���
        $insert_sql .= "    '$deliver_effect',";                //Ǽ�ʽ񥳥���(����)
        $insert_sql .= "    '$claim_send',";                    //���������(͹��)
        $insert_sql .= "    '$accounts_day',";                  //�軻��(��)
        #2009-12-25 aoyama-n
        #$insert_sql .= "    (SELECT";                           //������Ψ(����)
        #$insert_sql .= "        tax_rate_n";
        #$insert_sql .= "    FROM";
        #$insert_sql .= "        t_client";
        #$insert_sql .= "    WHERE";
        #$insert_sql .= "    client_div = '0'";
        #$insert_sql .= "    ) ,";
        $insert_sql .= "    '$account_tel',";
        $insert_sql .= "    '$prefix',";
        $insert_sql .= "    $claim_pattern,";
        $insert_sql .= "    $c_tax_div,";                        //���Ƕ�ʬ
//��������ϻ��������
        $insert_sql .= "    '$payout_m',";                         //��ʧ��
        $insert_sql .= "    '$payout_d',";                         //��ʧ��
        $insert_sql .= "    '$bank_name',";                        //����̾��
        $insert_sql .= "    '$b_bank_name',";                       //����̾��ά��
//���ҥץ�ե������Ѥ���Ͽ
        $insert_sql .= "    '$coax',\n";
        $insert_sql .= "    '$fraction_div',\n";
        $insert_sql .= "    '$pay_month',\n";
        $insert_sql .= "    '$pay_day',\n";
        $insert_sql .= "    '$close_day',\n";
        $insert_sql .= "    '1', \n";
        #2009-12-25 aoyama-n
        #$insert_sql .= "    '1'\n";
        $insert_sql .= "    '1',\n";
        $insert_sql .= "    (SELECT";                           //�������Ψ
        $insert_sql .= "        tax_rate_old";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //��������Ψ
        $insert_sql .= "        tax_rate_now";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //����Ψ������
        $insert_sql .= "        tax_change_day_now";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //��������Ψ
        $insert_sql .= "        tax_rate_new";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //����Ψ������
        $insert_sql .= "        tax_change_day_new";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        #2010-05-01 hashimoto-y
        $insert_sql .= "    '$bill_address_font' ";

        $insert_sql .= ");";
        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //��Ͽ�����������˻Ĥ�
        $result = Log_Save( $conn, "shop", "1",$shop_cd1."-".$shop_cd2,$shop_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        //��Ͽ��������åפΥ���å�ID�����
        $sql  = "SELECT";
        $sql .= "   client_id";
        $sql .= " FROM";
        $sql .= "   t_client";
        $sql .= " WHERE";
        $sql .= "   client_cd1 = '$shop_cd1'";
        $sql .= "   AND";
        $sql .= "   client_cd2 = '$shop_cd2'";
        $sql .= "   AND";
        $sql .= "   client_div = '3'";
        $sql .= ";";

        $result = Db_Query($conn, $sql);
        $fc_shop_id = pg_fetch_result($result,0,0);


        //��������
        //�����ϻ�
        $insert_sql = " INSERT INTO t_claim (";
        $insert_sql .= "    client_id,";
        $insert_sql .= "    claim_id,";
        $insert_sql .= "    claim_div";
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    $fc_shop_id,";

        if($claim_flg != true){
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        client_id";
            $insert_sql .= "    FROM";
            $insert_sql .= "        t_client";
            $insert_sql .= "    WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd1 = '$claim_cd1'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_cd2 = '$claim_cd2'";
            $insert_sql .= "        AND";
            $insert_sql .= "        client_div = '3'";
            $insert_sql .= "    ),";
        }else{
            $insert_sql .= "    $fc_shop_id, ";
        }

        $insert_sql .= "    '1'";
        $insert_sql .= ");";
        $result = Db_Query($conn, $insert_sql);

        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //���򤷤��ܵҶ�ʬ�����ɤ�ľ�Ĥξ��
        $sql  = "SELECT";
        $sql .= "   group_kind";
        $sql .= " FROM";
        $sql .= "   t_rank";
        $sql .= " WHERE";
        $sql .= "   rank_cd = '$rank_cd'";
        $sql .= ";";

        $result     = Db_Query($conn, $sql);
        $group_kind = pg_fetch_result($result, 0);

        //ľ�Ĥξ�硢����ľ�Ĥ���Ͽ����Ƥ��뤫����
        if($group_kind == '2'){
            $sql  = "SELECT";
            $sql .= "   count(*)";
            $sql .= " FROM";
            $sql .= "   t_client";
            $sql .= " WHERE";
            $sql .= "   rank_cd = '$rank_cd'";
            $sql .= ";";

            $result      = Db_QUery($conn, $sql);
            $fc_rank_num = pg_fetch_result($result,0);
        }

        //ľ�Ĥ���Ͽ����Ƥ��ޤ�������
        if($fc_rank_num == 0 || $fc_rank_num == null){

            //��Ͽ����FC�˴��ܽв��Ҹˤ����򤹤롣
            $sql  = "INSERT INTO t_ware(";
            $sql .= "   ware_id,\n";
            $sql .= "   ware_cd,\n";
            $sql .= "   ware_name,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";   
            $sql .= "   (SELECT COALESCE(MAX(ware_id),0)+1 FROM t_ware ),";
            $sql .= "   '001',\n";
            $sql .= "   '����Ҹ�',\n";
            $sql .= "   $fc_shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //��Ͽ�����Ҹ�ID�����
            $sql  = "SELECT";
            $sql .= "   ware_id ";
            $sql .= " FROM ";
            $sql .= "   t_ware ";
            $sql .= " WHERE ";
            $sql .= "   ware_cd = '001'";
            $sql .= "   AND ";
            $sql .= "   shop_id = $fc_shop_id";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $def_ware_id = pg_fetch_result($result, 0,0);

            $values = array(
                branch_cd     => "001",
                branch_name   => addslashes("��Ź"),
                bases_ware_id => $def_ware_id,
                note          => "",
                shop_id       => $fc_shop_id,
            );
            require_once(INCLUDE_DIR.(basename("2-1-200.php.inc"))); //���⥸�塼����Τߤǻ��Ѥ���ؿ��ե�����

            //�����Ź��Ͽ������������Ͽ����ID���֤���
            $branch_id = Regist_Branch($conn,"default",$values);

            //���������Ͽ
            Regist_Init_Part($conn,$values[shop_id]);

            //����˻�Ź����Ͽ
            if($branch_id != false){
                Update_Part_Branch($conn,$values[shop_id],$branch_id);
            }

            //�����������Ȥ�����Ͽ����
            //�����μ����ޥ����ξ�������
            $sql  = "SELECT\n";
            $sql .= "    t_client.client_cd1,\n";       //����åץ�����1
            $sql .= "    t_client.client_name,\n";      //����å�̾
            $sql .= "    t_client.client_cname,\n";     //ά��
            $sql .= "    t_client.post_no1,\n";         //͹���ֹ�
            $sql .= "    t_client.post_no2,\n";         //͹���ֹ�
            $sql .= "    t_client.address1,\n";         //����1
            $sql .= "    t_client.area_id,\n";          //�϶�
            $sql .= "    t_client.tel,\n";              //TEL
            $sql .= "    t_client.rep_name,\n";         //��ɽ�Ի�̾
            $sql .= "    t_client.trade_id,\n";         //�����ʬ
            $sql .= "    t_client.close_day,\n";        //����
            $sql .= "    t_client.pay_m,\n";            //������(��)
            $sql .= "    t_client.pay_d,\n";            //������(��)
            $sql .= "    t_client.coax,\n";             //�ޤ���ʬ
            $sql .= "    t_client.tax_div,\n";          //����ñ��
            $sql .= "    t_client.tax_franct,\n";       //ü����ʬ
            $sql .= "    t_client.sbtype_id\n";         //�ȼ�
            $sql .= " FROM\n";
            $sql .= "    t_client\n";
            $sql .= " WHERE\n";
            $sql .= "    t_client.client_div = '0'\n";
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            $h_client_data = pg_fetch_array($result, 0);

            //�϶�ޥ����������Ѥ��϶����Ͽ
            //�嵭����Ͽ���ʤ����Τ�
            $sql  = "INSERT INTO t_area(\n";
            $sql .= "   area_id,\n";
            $sql .= "   area_cd,\n";
            $sql .= "   area_name,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";
            $sql .= "   (SELECT COALESCE(MAX(area_id),0)+1 FROM t_area),\n";
            $sql .= "   '0001',\n";
            $sql .= "   '�����϶�',\n";
            $sql .= "   $fc_shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //�϶�ID�����
            $sql  = "SELECT";
            $sql .= "   area_id\n";
            $sql .= " FROM\n";
            $sql .= "   t_area\n";
            $sql .= " WHERE\n";
            $sql .= "   area_cd = '0001'\n";
            $sql .= "   AND\n";
            if($group_kind == '2'){
                $sql .= "   shop_id IN (".Rank_Sql().")";
            }else{
                $sql .= "   shop_id = $fc_shop_id\n";
            }
            $sql .= ";";


            $result = Db_Query($conn, $sql);
            $area_id = pg_fetch_result($result, 0);

            //�����Υǡ�������Ͽ
            $sql  = "INSERT INTO t_client(\n";
            $sql .= "    shop_id,\n";          //�����ޥ���
            $sql .= "    client_id,\n";        //������ID
            $sql .= "    client_cd1,\n";       //������CD
            $sql .= "    client_cd2,\n";       //������CD��
            $sql .= "    state,\n";            //����
            $sql .= "    client_div,\n";       //������ʬ
            $sql .= "    create_day,\n";       //������
            $sql .= "    shop_div,\n";         //�ܼҡ��ټҶ�ʬ
            $sql .= "    client_name,\n";      //������̾
            $sql .= "    client_cname,\n";     //ά��
            $sql .= "    client_read,\n";      //������̾�ʥեꥬ�ʡ�
            $sql .= "    post_no1,\n";         //͹���ֹ棱
            $sql .= "    post_no2,\n";         //͹���ֹ棲
            $sql .= "    address1,\n";         //���꣱
            $sql .= "    area_id,\n";          //�϶�  
            $sql .= "    sbtype_id,\n";        //�ȼ�
            $sql .= "    tel,\n";              //�����ֹ�
            $sql .= "    rep_name,\n";         //��ɽ��̾
            $sql .= "    close_day,\n";        //����  
            $sql .= "    payout_m,\n";         //��ʧ��(��)
            $sql .= "    payout_d,\n";         //��ʧ��(��)
            $sql .= "    coax,\n";             //���(�ݤ��ʬ)
            $sql .= "    tax_div,\n";          //������(����ñ��)
            $sql .= "    tax_franct,\n";       //������(ü��)
            $sql .= "    c_tax_div,\n";
            $sql .= "    head_flg,\n";
            $sql .= "    trade_id, \n";
            $sql .= "    charge_branch_id \n";  //ô����Ź
            $sql .= ")VALUES(\n";
            $sql .= "    $fc_shop_id,\n";       
            $sql .= "    (SELECT COALESCE(MAX(client_id),0)+1 FROM t_client),\n";
            $sql .= "    '$h_client_data[client_cd1]',\n";
            $sql .= "    '0000',\n";
            $sql .= "    '1',\n";
            $sql .= "    '2',\n";
            $sql .= "    NOW(),\n";
            $sql .= "    '1',\n";
            $sql .= "    '".addslashes($h_client_data[client_name])."',\n";
            $sql .= "    '".addslashes($h_client_data[client_cname])."',\n";
            $sql .= "    '".addslashes($h_client_data[client_read])."',\n";
            $sql .= "    '$h_client_data[post_no1]',\n";
            $sql .= "    '$h_client_data[post_no2]',\n";
            $sql .= "    '".addslashes($h_client_data[address1])."',\n";
            $sql .= "    $area_id,\n";
            $sql .= "    62,\n";
            $sql .= "    '$h_client_data[tel]',\n";
            $sql .= "    '".addslashes($h_client_data[rep_name])."',\n";
            $sql .= "    '$close_day',\n";
            $sql .= "    '$h_client_data[pay_m]',\n";
            $sql .= "    '$h_client_data[pay_d]',\n";
            $sql .= "    '$coax',";                          //��ۡ��ݤ��ʬ
            $sql .= "    '$tax_unit',";                      //�����ǡ�����ñ��
            $sql .= "    '$fraction_div',";                  //�����ǡ�ü��ñ��
            $sql .= "    '$c_tax_div',";
            $sql .= "    't',";
            $sql .= "    21,";
            $sql .= "    $branch_id ";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //���ۤ�������Ȥ�����Ͽ����
            //���ۤξ�������
            $sql  = "SELECT\n";
            $sql .= "    t_client.client_cd1,\n";       //����åץ�����1
            $sql .= "    t_client.client_cd2,\n";       //����åץ����ɣ�
            $sql .= "    t_client.client_name,\n";      //����å�̾
            $sql .= "    t_client.client_read,\n";      //����å�̾(�եꥬ��)
            $sql .= "    t_client.client_name2,\n";     //����å�̾��
            $sql .= "    t_client.client_read2,\n";     //����å�̾���ʥեꥬ�ʡ�
            $sql .= "    t_client.client_cname,\n";     //ά��
            $sql .= "    t_client.client_read,\n";      //ά�Ρʥեꥬ�ʡ�
            $sql .= "    t_client.post_no1,\n";         //͹���ֹ�
            $sql .= "    t_client.post_no2,\n";         //͹���ֹ�
            $sql .= "    t_client.address1,\n";         //����1
            $sql .= "    t_client.address2,\n";         //����2
            $sql .= "    t_client.address3,\n";         //����3
            $sql .= "    t_client.address_read,\n";     //����ʥեꥬ�ʡ�
            $sql .= "    t_client.area_id,\n";          //�϶�  
            $sql .= "    t_client.tel,\n";              //TEL   
            $sql .= "    t_client.rep_name,\n";         //��ɽ�Ի�̾
            $sql .= "    t_client.trade_id,\n";         //�����ʬ
            $sql .= "    t_client.close_day,\n";        //����  
            $sql .= "    t_client.pay_m,\n";            //������(��)
            $sql .= "    t_client.pay_d,\n";            //������(��)
            $sql .= "    t_client.coax,\n";             //�ޤ���ʬ
            $sql .= "    t_client.tax_div,\n";          //����ñ��
            $sql .= "    t_client.tax_franct,\n";       //ü����ʬ
            $sql .= "    t_client.sbtype_id,\n";        //�ȼ�  
            $sql .= "    t_client.c_tax_div,\n";
            $sql .= "    t_client.rep_name,\n";         //��ɽ��̾
            $sql .= "    t_client.represe,\n";          //��ɽ����
            $sql .= "    t_client.tel,\n";              //�����ֹ�
            $sql .= "    t_client.fax,\n";              //FAX
            $sql .= "    t_client.establish_day,\n";    //�϶���
            $sql .= "    t_client.email\n";             //ô����Email
            $sql .= " FROM\n";
            $sql .= "    t_client\n";
            $sql .= " WHERE\n";
            $sql .= "    t_client.client_id = 93\n";    //���ۤΥǡ���
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            $fc_client_data = pg_fetch_array($result, 0);


            //��������Ͽ������������Ф���ɬ�פʥޥ����ǡ����������Ͽ
            //�����ե����ޥå�
            $sql  = "INSERT INTO t_claim_sheet(\n";
            $sql .= "   c_pattern_id,\n";
            $sql .= "   c_pattern_name,\n";
            $sql .= "   c_memo1,\n";
            $sql .= "   c_memo2,\n";
            $sql .= "   c_memo3,\n";
            $sql .= "   c_memo4,\n";
            $sql .= "   c_memo5,\n";
            $sql .= "   c_memo6,\n";
            $sql .= "   c_memo7,\n";
            $sql .= "   c_memo8,\n";
            $sql .= "   c_memo9,\n";
            $sql .= "   c_memo10,\n";
            $sql .= "   c_memo11,\n";
            $sql .= "   c_memo12,\n";
            $sql .= "   c_memo13,\n";
            $sql .= "   c_fsize1,\n";
            $sql .= "   c_fsize2,\n";
            $sql .= "   c_fsize3,\n";
            $sql .= "   c_fsize4,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";
            $sql .= "   (SELECT COALESCE(MAX(c_pattern_id),0)+1 FROM t_claim_sheet),\n";
            $sql .= "   '$shop_name',\n";
            $sql .= "   '������ҡ��� �� �� �� ��',\n";
            $sql .= "   '��ɽ�����򡡻����͡�Τ����',\n";
            $sql .= "   '��221-0863 �� �� �� �� �� ��� �� �� Į 685',\n";
            $sql .= "   '�ԣţ�  045-371-7676   �ƣ���  045-371-7717',\n";
            $sql .= "   '�ߤ��۶�ԡ�����������Ź���������������¶⡡*******',\n";
            $sql .= "   '�ߤ��۶�ԡ����ͱ�����Ź���������������¶⡡*******',\n";
            $sql .= "   '�����ɩ��ԡ������ͻ�Ź���������������¶⡡*******',\n";
            $sql .= "   '���Ͷ�ԡ���ë��Ź���������� ���� �����¶⡡*******',\n";
            $sql .= "   '������⡡����������Ź���� �� ���������¶⡡*******',\n";
            $sql .= "   '���Ϳ��Ѷ�ˡ���ë��Ź����������  �����¶⡡*******',\n";
            $sql .= "   '�����ܥ��ƥ���ԡ���Ź���Ķ������������¶⡡*******',\n";
            $sql .= "   '',\n";
            $sql .= "   '����������߼���������˿������������ޤ��󤬡����ҤˤƸ���ô������褦���ꤤ�פ��ޤ���',\n";
            $sql .= "   '12',\n";
            $sql .= "   '9',\n";
            $sql .= "   '6',\n";
            $sql .= "   '6',\n";
            $sql .= "   $fc_shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //��Ͽ���������ID
            $sql  = "SELECT\n";
            $sql .= "   MAX(c_pattern_id) AS c_pattern_id \n";
            $sql .= "FROM\n";
            $sql .= "   t_claim_sheet \n";
            $sql .= "WHERE\n";
            $sql .= "   shop_id = $fc_shop_id\n";
            $sql .= ";";

            $result = Db_Query($conn, $sql);    
            $c_pattern_id = pg_fetch_result($result, 0,0);

            //�����ɼ�ե����ޥå�����
            $sql  = "INSERT INTO t_slip_sheet(\n";
            $sql .= "   s_pattern_id,\n";
            $sql .= "   s_pattern_name,\n";
            $sql .= "   s_memo1,\n";
            $sql .= "   s_memo2,\n";
            $sql .= "   s_memo3,\n";
            $sql .= "   s_memo4,\n";
            $sql .= "   s_memo5,\n";
            $sql .= "   s_memo6,\n";
            $sql .= "   s_memo7,\n";
            $sql .= "   s_memo8,\n";
            $sql .= "   s_memo9,\n";
            $sql .= "   s_fsize1,\n";
            $sql .= "   s_fsize2,\n";
            $sql .= "   s_fsize3,\n";
            $sql .= "   s_fsize4,\n";
            $sql .= "   s_fsize5,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";
            $sql .= "   (SELECT COALESCE(MAX(s_pattern_id),0)+1 FROM t_slip_sheet),\n";
            $sql .= "   '$shop_name',\n";
            $sql .= "   '������ҥ���˥ƥ�',\n";
            $sql .= "   '',\n";
            $sql .= "   '��ɽ������',\n";
            $sql .= "   '����Τ��',\n";
            $sql .= "   '��221-0863�����ͻԿ�����豩��Į������
�ԣţ�045-371-7676���ƣ���045-371-7717 ',";
            $sql .= "   '',\n";
            $sql .= "   '�����ԡ��ߤ��۶�ԡ���������������Ź�����¡�*******
�����������ߤ��۶�ԡ��������ͱ�����Ź�����¡�*******
������������ɩ����գƣʡ������ͻ�Ź�������¡�*******
�������������Ͷ�ԡ���������ë��Ź���������¡�*******
�������������Ϳ��Ѷ�ˡ�������������Ź�����̡�*******��',\n";
            $sql .= "   '',\n";
            $sql .= "   '',\n";
            $sql .= "   '10',\n";
            $sql .= "   '10',\n";
            $sql .= "   '8',\n";
            $sql .= "   '10',\n";
            $sql .= "   '6',\n";
            $sql .= "    $fc_shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //��Ͽ���������ɼID
            $sql  = "SELECT\n";
            $sql .= "   MAX(s_pattern_id) AS s_pattern_id\n ";
            $sql .= "FROM\n";
            $sql .= "   t_slip_sheet\n ";
            $sql .= "WHERE\n";
            $sql .= "   shop_id = $fc_shop_id\n";
            $sql .= ";";

            $result = Db_Query($conn,$sql);
            $s_pattern_id = pg_fetch_result($result, 0,0);

            //���ۤΥǡ�������Ͽ
            $sql  = "INSERT INTO t_client(\n";
            $sql .= "    client_id,\n";                                                                 //������������ID
            $sql .= "    shop_id,\n";                                                                   //����������å�ID
            $sql .= "    client_cd1,\n";                                                                //������������CD��
            $sql .= "    client_cd2,\n";                                                                //������������CD��
            $sql .= "    state,\n";                                                                     //����������
            $sql .= "    client_div,\n";                                                                //������������ʬ
            $sql .= "    create_day,\n";                                                                //������������
            $sql .= "    shop_div,\n";                                                                  //�������ܼҡ��ټҶ�ʬ
            $sql .= "    client_name,\n";                                                               //������������̾
            $sql .= "    client_read,\n";                                                               //������������̾�ʥեꥬ�ʡ�
            $sql .= "    client_name2,\n";                                                              //������������̾��
            $sql .= "    client_read2,\n";                                                              //������������̾���ʥեꥬ�ʡ�
            $sql .= "    client_cname,\n";                                                              //������ά��
            $sql .= "    client_cread,\n";                                                              //������ά�Ρʥեꥬ�ʡ�
            $sql .= "    compellation,\n";                                                              //�������ɾ�
            $sql .= "    rep_name,\n";                                                                  //��������ɽ��̾
            $sql .= "    represe,\n";                                                                   //��������ɽ����
            $sql .= "    tel,\n";                                                                       //�����������ֹ�
            $sql .= "    fax,\n";                                                                       //������FAX
            $sql .= ($fc_client_data[establish_day] != null)? " establish_day,\n" : null;               //�������϶���
            $sql .= "    email,\n";                                                                     //������ô����Email
            $sql .= "    post_no1,\n";                                                                  //������͹���ֹ棱
            $sql .= "    post_no2,\n";                                                                  //������͹���ֹ棲
            $sql .= "    address1,\n";                                                                  //���������꣱
            $sql .= "    address2,\n";                                                                  //���������ꣲ
            $sql .= "    address3,\n";                                                                  //���������ꣳ
            $sql .= "    address_read,\n";                                                              //����������ʥեꥬ�ʡ�
            $sql .= "    area_id,\n";                                                                   //�������϶�
            $sql .= "    sbtype_id,\n";                                                                 //����������ID
            $sql .= "    trade_id,\n";                                                                  //�����������ʬ������
            $sql .= "    close_day,\n";                                                                 //����������
            $sql .= "    pay_m,\n";                                                                     //��������ʧ��(��)
            $sql .= "    pay_d,\n";                                                                     //��������ʧ��(��)
            $sql .= "    coax,\n";                                                                      //���������(�ݤ��ʬ)
            $sql .= "    tax_div,\n";                                                                   //������������(����ñ��)
            $sql .= "    tax_franct,\n";                                                                //������������(ü��)
            $sql .= "    c_tax_div,\n";                                                                 //���������Ƕ�ʬ
            $sql .= "    bank_div,\n";                                                                  //��������Լ������ô��ʬ
            $sql .= "    act_flg,\n";                                                                   //���������ۥե饰
            $sql .= "    c_pattern_id,\n";                                                              //�����������ѥ�����
            $sql .= "    claim_out,\n";                                                                 //�����������ȯ��
            $sql .= "    claim_send,\n";                                                                //���������������    
            $sql .= "    s_pattern_id,\n";                                                              //�����������ɼȯ�ԥѥ�����
            $sql .= "    slip_out,\n";                                                                  //��������ɼȯ��
            $sql .= "    deliver_effect,\n";                                                             //������Ǽ�ʽ񥳥���̵ͭ
            $sql .= "    charge_branch_id ";
            $sql .= ")VALUES(\n";
            $sql .= "    (SELECT COALESCE(MAX(client_id),0)+1 FROM t_client),\n";                       //������������ID
            $sql .= "    $fc_shop_id,\n";                                                               //����������å�ID
            $sql .= "    '$fc_client_data[client_cd1]',\n";                                             //������������CD��
            $sql .= "    '$fc_client_data[client_cd2]',\n";                                             //������������CD��
            $sql .= "    '1',\n";                                                                       //����������
            $sql .= "    '1',\n";                                                                       //�������������ʬ
            $sql .= "    NOW(),\n";                                                                     //������������
            $sql .= "    '1',\n";                                                                       //�������ܼҡ��ټҶ�ʬ
            $sql .= "    '".addslashes($fc_client_data[client_name])."',\n";                            //������������̾
            $sql .= "    '".addslashes($fc_client_data[client_read])."',\n";                            //������������̾�ʥեꥬ�ʡ�
            $sql .= "    '".addslashes($fc_client_data[client_name2])."',\n";                           //������������̾��
            $sql .= "    '".addslashes($fc_client_data[client_read2])."',\n";                           //������������̾���ʥեꥬ�ʡ�
            $sql .= "    '".addslashes($fc_client_data[client_cname])."',\n";                           //������ά��
            $sql .= "    '".addslashes($fc_client_data[client_cread])."',\n";                           //������ά�Ρʥեꥬ�ʡ�
            $sql .= "    '1',\n";                                                                       //�������ɾ�
            $sql .= "    '".addslashes($fc_client_data[rep_name])."',\n";                               //��������ɽ��̾
            $sql .= "    '".addslashes($fc_client_data[represe])."',\n";                                //��������ɽ����
            $sql .= "    '$fc_client_data[tel]',\n";                                                    //�����������ֹ�
            $sql .= "    '$fc_client_data[fax]',\n";                                                    //������FAX
            $sql .= ($fc_client_data[establish_day] != null)? "'$fc_client_data[establish_day]',\n" : null; //�������϶���
            $sql .= "    '$fc_client_data[email]',\n";                                                  //������Email
            $sql .= "    '$fc_client_data[post_no1]',\n";                                               //������͹���ֹ棱
            $sql .= "    '$fc_client_data[post_no2]',\n";                                               //������͹���ֹ棲
            $sql .= "    '".addslashes($fc_client_data[address1])."',\n";                               //���������꣱
            $sql .= "    '".addslashes($fc_client_data[address2])."',\n";                               //���������ꣲ
            $sql .= "    '".addslashes($fc_client_data[address3])."',\n";                               //���������ꣳ
            $sql .= "    '".addslashes($fc_client_data[address_read])."',\n";                           //����������ʥեꥬ�ʡ�
            $sql .= "    $area_id,\n";                                                                  //�������϶�
            $sql .= "    $fc_client_data[sbtype_id],\n";                                                //�������ȼ�
            $sql .= "    '$fc_client_data[trade_id]',\n";                                               //�����������ʬ
            $sql .= "    '$fc_client_data[close_day]',\n";                                              //����������    
            $sql .= "    '$fc_client_data[pay_m]',\n";                                                  //��������ʧ���ʷ��
            $sql .= "    '$fc_client_data[pay_d]',\n";                                                  //��������ʧ��������
            $sql .= "    '$fc_client_data[coax]',\n";                                                   //��������ۡʴݤ��ʬ��
            $sql .= "    '$fc_client_data[tax_div]',\n";                                                //�����������ǡʲ���ñ�̡�
            $sql .= "    '$fc_client_data[tax_franct]',\n";                                             //�����������ǡ�ü����
            $sql .= "    '$fc_client_data[c_tax_div]',\n";                                              //���������Ƕ�ʬ
            $sql .= "    '1',\n";                                                                       //��������Լ������ô��ʬ
            $sql .= "    't',\n";                                                                       //���������ۥե饰
            $sql .= "    $c_pattern_id,\n";                                                             //�����������ѥ�����
            $sql .= "    '1',\n";                                                                       //�����������ȯ��
            $sql .= "    '1',\n";                                                                       //���������������
            $sql .= "    $s_pattern_id,\n";                                                             //�����������ɼȯ�ԥѥ�����
            $sql .= "    '2',\n";                                                                       //��������ɼȯ��
            $sql .= "    '2',\n";                                                                       //������Ǽ�ʽ񥳥���
            $sql .= "    $branch_id ";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //��Ͽ�������ۤΥ���å�ID�����
            $sql  = "SELECT";
            $sql .= "   client_id ";
            $sql .= "FROM";
            $sql .= "   t_client ";
            $sql .= "WHERE";
            $sql .= "   client_cd1 = '$fc_client_data[client_cd1]'";
            $sql .= "   AND";
            $sql .= "   client_cd2 = '$fc_client_data[client_cd2]'";
            $sql .= "   AND";
            $sql .= "   client_div = '1'";
            $sql .= "   AND";
            $sql .= "   shop_id = $fc_shop_id";
            $sql .= ";";

            $result     = Db_Query($conn, $sql);
            $fc_client_id = pg_fetch_result($result ,0,0);
            
            //���ۤΥǡ��������������ơ��֥����Ͽ
            $sql  = "INSERT INTO t_client_info (";
            $sql .= "   client_id,";
            $sql .= "   claim_id,";
            $sql .= "   cclient_shop";
            $sql .= ")VALUES(";
            $sql .= "   $fc_client_id,"; 
            $sql .= "   $fc_client_id,";
            $sql .= "   $fc_shop_id";
            $sql .= ");";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //������ơ��֥����Ͽ
            $sql  = "INSERT INTO t_claim (";
            $sql .= "   client_id,";
            $sql .= "   claim_id,";
            $sql .= "   claim_div";
            $sql .= ")VALUES(";
            $sql .= "   $fc_client_id,";
            $sql .= "   $fc_client_id,";
            $sql .= "   '1'";
            $sql .= ");";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //���˼�ʬ�θܵҶ�ʬ��ñ������Ͽ����Ƥ��뾦�ʤ����
            #2009-10-09 hashimoto-y
            #$sql  = "SELECT";
            #$sql .= "   goods_id";
            #$sql .= " FROM";
            #$sql .= "   t_price";
            #$sql .= " WHERE";
            #$sql .= "   rank_cd = '$rank_cd'";
            #$sql .= "   AND";
            #$sql .= "   r_price IS NOT NULL";
            #$sql .= "   AND";
            #$sql .= "   shop_id = 1\n";          //�����Υǡ���
            #$sql .= ";";

            $sql  = "SELECT";
            $sql .= "   t_price.goods_id, ";
            $sql .= "   t_goods_info.stock_manage ";
            $sql .= " FROM";
            $sql .= "   t_price";
            $sql .= "   INNER JOIN t_goods_info   ON t_price.goods_id  = t_goods_info.goods_id \n";
            $sql .= " WHERE";
            $sql .= "   t_price.rank_cd = '$rank_cd'";
            $sql .= "   AND";
            $sql .= "   t_price.r_price IS NOT NULL";
            $sql .= "   AND";
            $sql .= "   t_price.shop_id = 1\n";          //�����Υǡ���
            $sql .= "   AND";
            $sql .= "   t_goods_info.shop_id = 1\n";     //�����Υǡ���
            $sql .= ";";


            $goods_res = Db_Query($conn, $sql);
            $goods_num = pg_num_rows($goods_res);

            for($i = 0; $i < $goods_num; $i++){

                $goods_id     = pg_fetch_result($goods_res, $i,0);

                #2009-10-09 hashimoto-y
                $stock_manage = pg_fetch_result($goods_res, $i,1);

                //ñ���ơ��֥����Ͽ
                for($j = 2; $j < 4; $j++){
                    $sql  = "INSERT INTO t_price(";
                    $sql .= "   goods_id,";
                    $sql .= "   price_id,";
                    $sql .= "   rank_cd,";
                    $sql .= "   r_price,";
                    $sql .= "   shop_id";
                    $sql .= ")VALUES(";
                    $sql .= "   $goods_id,";
                    $sql .= "   (SELECT COALESCE(MAX(price_id),0)+1 FROM t_price),";
                    $sql .= "   '$j',";
                    $sql .= "   (SELECT r_price FROM t_price WHERE rank_cd = '$rank_cd' AND goods_id = $goods_id AND shop_id = 1),";
                    $sql .= "   $fc_shop_id\n";
                    $sql .= ");\n";

                    $result = Db_Query($conn, $sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK;");
                        exit;
                    }
                }

                $sql  = "INSERT INTO t_goods_info(";
                $sql .= "   goods_id,";
                $sql .= "   compose_flg,";
                $sql .= "   head_fc_flg,";

                #2009-10-09 hashimoto-y
                $sql .= "   stock_manage,";

                $sql .= "   shop_id";
                $sql .= ")VALUES(";
                $sql .= "   $goods_id,";
                $sql .= "   'f',";
                $sql .= "   'f',";

                #2009-10-09 hashimoto-y
                $sql .= "   $stock_manage,";

                $sql .= "   $fc_shop_id";
                $sql .= ");\n";

                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
            }
        }

    //��������
    }else if($new_flg == false){
        // ��������Ͽ����������ID�����
        // �����褬���Ϥ��줿���
        if($claim_name != null){
            $sql  = "SELECT";
            $sql .= "   client_id";
            $sql .= " FROM";
            $sql .= "   t_client";
            $sql .= " WHERE";
            $sql .= "   client_div = '3'";
            $sql .= "   AND";
            $sql .= "   client_cd1 = '$claim_cd1'";
            $sql .= "   AND";
            $sql .= "   client_cd2 = '$claim_cd2'";
            $sql .= "   AND";
            $sql .= " shop_id = $shop_id";
            $sql .= ";";

            $result = Db_Query($conn, $sql);
            $claim_id = pg_fetch_result($result, 0,0 );
        }else{
            $claim_id = $get_client_id;
        }

        //�����ޥ���
        $update_sql = "UPDATE";
        $update_sql .= "    t_client";
        $update_sql .= " SET";
        $update_sql .= "    rank_cd         = '$rank_cd',";
        $update_sql .= "    client_cd1      = '$shop_cd1',";
        $update_sql .= "    client_cd2      = '$shop_cd2',";
        $update_sql .= "    state           = '$form_state',";
        $update_sql .= "    client_name     = '$shop_name',";
        $update_sql .= "    client_read     = '$shop_name_read',";
        $update_sql .= "    client_cname    = '$shop_cname',";
        $update_sql .= "    post_no1        = '$post_no1',";
        $update_sql .= "    post_no2        = '$post_no2',";
        $update_sql .= "    address1        = '$address1',";
        $update_sql .= "    address2        = '$address2',";
        $update_sql .= "    address3        = '$address3',";
        $update_sql .= "    address_read    = '$address_read',";
        $update_sql .= "    area_id         = $area_id,";
        $update_sql .= "    tel             = '$tel',";
        $update_sql .= "    fax             = '$fax',";
        $update_sql .= "    rep_name        = '$represent_name',";
        if($sv == ""){
                $sv = "    null"; 
        }
        if($staff1 == ""){
                $staff1 = "    null";
        }
        if($staff2 == ""){
                $staff2 = "    null";
        }
        if($staff3 == ""){
                $staff3 = "    null";
        }
        if($staff4 == ""){
                $staff4 = "    null";
        }
        $update_sql .= "    sv_staff_id     = $sv,";
        $update_sql .= "    b_staff_id1     = $staff1,";
        $update_sql .= "    b_staff_id2     = $staff2,";
        $update_sql .= "    b_staff_id3     = $staff3,";
        $update_sql .= "    b_staff_id4     = $staff4,";
        $update_sql .= "    charger_name    = '$contact_name',";
        $update_sql .= "    holiday         = '$holiday',";
        $update_sql .= "    col_terms       = '$collect_terms',";
        $update_sql .= "    credit_limit    = '$limit_money',";
        $update_sql .= "    capital         = '$capital_money',";
        $update_sql .= "    bank_name       = '$bank_name',";
        $update_sql .= "    b_bank_name     = '$b_bank_name',";
        $update_sql .= "    trade_id        = '$aord_div',";
        $update_sql .= "    buy_trade_id    = '$buy_div',";
        $update_sql .= "    close_day       = '$close_day',";
        if($pay_month == ""){
        $update_sql .= "        pay_m       = '',";
        }else{
        $update_sql .= "        pay_m       = '$pay_month',";
        }
        if($pay_day == ""){
        $update_sql .= "        pay_d       = '',";
        }else{
        $update_sql .= "        pay_d       = '$pay_day',";
        }
        $update_sql .= "    pay_way         = '$pay_way',";
        $update_sql .= "    account_name    = '$account_name',";
        $update_sql .= "    pay_name        = '$transfer_name',";
        if($bank == ""){
            $update_sql .= "        account_id = null,";
        }else{
            $update_sql .= "        account_id = $bank,";
        }
        if($cont_s_day == "--"){
        $update_sql .= "        cont_sday   = null,";
        }else{
        $update_sql .= "        cont_sday   = '$cont_s_day',";
        }
        if($cont_e_day == "--"){
        $update_sql .= "        cont_eday   = null,";
        }else{
        $update_sql .= "        cont_eday   = '$cont_e_day',";
        }
        if($cont_peri == ""){
        $update_sql .= "        cont_peri   = '',";
        }else{
        $update_sql .= "        cont_peri   = '$cont_peri',";
        }
        if($cont_r_day == "--"){
        $update_sql .= "        cont_rday   = null,";
        }else{
        $update_sql .= "        cont_rday   = '$cont_r_day',";
        }
        $update_sql .= "    slip_out        = '$slip_issue',";
        $update_sql .= "    deliver_note    = '$deli_comment',";
        $update_sql .= "    claim_out       = '$claim_issue',";
        $update_sql .= "    coax            = '$coax',";
        $update_sql .= "    tax_div         = '$tax_unit',";
        $update_sql .= "    tax_franct      = '$fraction_div',";
        $update_sql .= "    shop_id         = $shop_id,";                   //����å�ID
        $update_sql .= "    shop_name       = '$comp_name',";               //��̾
        $update_sql .= "    shop_read       = '$comp_name_read',";          //��̾(�եꥬ��)
        $update_sql .= "    shop_name2      = '$comp_name2',";              //��̾2
        $update_sql .= "    shop_read2      = '$comp_name_read2',";         //��̾2(�եꥬ��)
        $update_sql .= "    url             = '$url',";                     //URL
        $update_sql .= "    represe         = '$represent_position',";      //��ɽ����
        $update_sql .= "    rep_htel        = '$represent_cell',";          //��ɽ�Է���
        $update_sql .= "    charger         = '$contact_position',";        //Ϣ��ô������
        $update_sql .= "    cha_htel        = '$contact_cell',";            //Ϣ��ô���Է���
        $update_sql .= "    surety_name1    = '$guarantor1',";              //�ݾڿͣ�̾��
        $update_sql .= "    surety_addr1    = '$guarantor1_address',";      //�ݾڿͣ�����
        $update_sql .= "    surety_name2    = '$guarantor2',";              //�ݾڿͣ�̾��
        $update_sql .= "    surety_addr2    = '$guarantor2_address',";      //�ݾڿͣ�����
        $update_sql .= "    trade_base      = '$position',";                //�Ķȵ���
        $update_sql .= "    trade_area      = '$business_limit',";          //����
        $update_sql .= "    join_money      = '$join_money',";              //������
        $update_sql .= "    guarant_money   = '$assure_money',";            //�ݾڶ�
        $update_sql .= "    royalty_rate    = $royalty,";                   //�����ƥ�
        $update_sql .= "    cutoff_month    = '$accounts_month',";          //�軻��
        $update_sql .= "    c_compa_name    = '$contract_name',";           //������̾
        $update_sql .= "    c_compa_rep     = '$represent_contract',";      //������ɽ��
        $update_sql .= "    license         = '$qualify_pride',";           //��ͭ��ʡ�����ʬ��
        $update_sql .= "    s_contract      = '$special_contract',";        //����
        $update_sql .= "    other           = '$other',";                   //����¾
        if($establish_day == "--"){
        $update_sql .= "    establish_day   = null,";                       //�϶���
        }else{
        $update_sql .= "    establish_day   = '$establish_day',";
        }
        if($corpo_day == "--"){
        $update_sql .= "    regist_day      = null, ";                      //ˡ���е���
        }else{
        $update_sql .= "    regist_day      = '$corpo_day,',";
        }
        $update_sql .= "    sbtype_id       = $btype,";                     //�ȼ�
        if($inst == ""){
            $update_sql .= "        inst_id = null,";
        }else{
	        $update_sql .= "    inst_id     = $inst,";                      //����
        }
        if($bstruct == ""){
            $update_sql .= "        b_struct = null,";
        }else{
	        $update_sql .= "    b_struct    = $bstruct,";                   //����
        }
        $update_sql .= "    accountant_name = '$accountant_name', ";        //���ô���Ի�̾
        $update_sql .= "    client_cread    = '$cname_read', ";             //ά��(�եꥬ��)
        $update_sql .= "    email           = '$email', ";                  //Email
        $update_sql .= "    direct_tel      = '$direct_tel', ";             //ľ��TEL
        $update_sql .= "    deal_history    = '$record', ";                 //�������
        $update_sql .= "    importance      = '$important', ";              //���׻���
        $update_sql .= "    deliver_effect  = '$deliver_effect' ,";         //Ǽ�ʽ񥳥���(����)
        $update_sql .= "    claim_send      = '$claim_send', ";             //���������(�᡼��)
        $update_sql .= "    cutoff_day      = '$accounts_day', ";           //�軻��
        $update_sql .= "    account_tel     = '$account_tel',";             //��פ�ô���Է���
        $update_sql .= "    compellation    = '$prefix', ";                 //�ɾ�
        $update_sql .= "    c_pattern_id    = $claim_pattern,";             //������ͼ�
        $update_sql .= "    c_tax_div       = $c_tax_div,";                 //���Ƕ�ʬ
        $update_sql .= "    payout_d        = $payout_d,";                  //���Ƕ�ʬ
        $update_sql .= "    payout_m        = $payout_m,";                 

        #2010-05-01 hashimoto-y
        $update_sql .= "    bill_address_font   = '$bill_address_font' ";

        $update_sql .= " WHERE";
        $update_sql .= "    shop_id         = $shop_id";
        $update_sql .= "    AND";
        $update_sql .= "    client_cd1      = '$fc_data[3]'";
        $update_sql .= "    AND";
        $update_sql .= "    client_cd2      = '$fc_data[4]'";
        $update_sql .= "    AND";
        $update_sql .= "    client_div      = '3'";
        $update_sql .= ";";
        $result = Db_Query($conn, $update_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //��Ͽ�����������˻Ĥ�
        $result = Log_Save( $conn, "shop", "2",$shop_cd1."-".$shop_cd2,$shop_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        if($change_flg == true){
            Child_Update($_GET[client_id], $close_day, $pay_month, $pay_day, $coax, $tax_unit, $fraction_div, $c_tax_div, $conn);
        }

        //������ޥ���
        $update_sql = " UPDATE t_claim ";
        $update_sql .= "SET ";
        $update_sql .= "    claim_id = $claim_id";
        $update_sql .= "WHERE ";
        $update_sql .= "    client_id = (SELECT";
        $update_sql .= "            client_id";
        $update_sql .= "        FROM";
        $update_sql .= "            t_client";
        $update_sql .= "        WHERE";
        $update_sql .= "        shop_id = $shop_id";
        $update_sql .= "        AND";
        $update_sql .= "        client_cd1 = '$fc_data[3]'";
        $update_sql .= "        AND";
        $update_sql .= "        client_cd2 = '$fc_data[4]'";
        $update_sql .= "        AND";
        $update_sql .= "        client_div = '3'";
        $update_sql .= "    ) ";
        $update_sql .= ";";
        $result = Db_Query($conn, $update_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }


        //������̾���򥢥åץǡ���
        $act_data = array(
                        "act_id"   => $get_client_id,
                        "act_cd1"  => $shop_cd1,
                        "act_cd2"  => $shop_cd2,
                        "act_name" => $shop_cname 
                        );
        Aord_Act_Data_Update ($conn, $act_data);



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
        $update_sql .= "    shop_id = $shop_id";
        $update_sql .= "    AND";
        $update_sql .= "    client_cd1 = '$fc_data[3]'";
        $update_sql .= "    AND";
        $update_sql .= "    client_cd2 = '$fc_data[4]'";
        $update_sql .= "    AND";
        $update_sql .= "    client_div = '3'";
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
    Db_Query($conn, "COMMIT;");
    $freeze_flg = true;
}

//��ư���ϥܥ��󲡲�
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

if($freeze_flg == true){

    // ���ܥ����������ID�����
    // ������Ͽ��
    if ($get_client_id == null){
        $sql    = "SELECT MAX(client_id) FROM t_client \n";
        $sql   .= "WHERE shop_id = $shop_id \n";
        $sql   .= "AND   client_div = '3' \n";
        $sql   .= ";\n";
        $res    = Db_Query($conn, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    // �ѹ���
    }else{
        $get_id = $get_client_id;
    }

	//��Ͽ��ǧ���̤Ǥϰʲ��Υܥ����ɽ��
	//���
	$form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='".$_SERVER["PHP_SELF"]."?client_id=$get_id'\"");
	//OK
	$form->addElement("button","comp_button","��Ͽ��λ","onClick=\"location.href='./1-1-103.php'\"");

    //������Ͽ��
	//$form->addElement("button","contract_button","������Ͽ","");

    $form->addElement("static","form_claim_link","","������");

    $form->freeze();

}else{

    //��Ͽ��ǧ���̤ξ��ϡ��ʲ��Υܥ������ɽ��
    //��ư����
    $button[] = $form->createElement("button","input_button","��ư����","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""    ); 

    if($change_flg == true){
        $message = "�ʲ��ι��ܤϻҤΥǡ����ˤ�ȿ�Ǥ���ޤ���\\n������\\n��������\\n���ݤ��ʬ\\n������ñ��\\n��ü����ʬ\\n�����Ƕ�ʬ";
    }else{
        $message = "��Ͽ���ޤ���";
    }
    //��Ͽ�ܥ���
    $button[] = $form->createElement("submit", "entry_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue('$message','#', this)\" $disabled");

    // �ѹ����Τ߽���
    if ($get_client_id != null){
        //���ܥ���
        $button[] = $form->createElement("button", "back_button", "�ᡡ��", "onClick='javascript:location.href = \"./1-1-101.php\"'");
    }

    if($change_flg == true){
        $form->addElement("static","form_claim_link","","������");
    }else{
        $form->addElement("link","form_claim_link","","#","������","onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_claim[cd1]','form_claim[cd2]','form_claim[name]'), 500, 450,1,1);\"");
    }

    $form->addGroup($button, "button", "");
    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./1-1-103.php?client_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }
    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./1-1-103.php?client_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
    }
}

/*******************************/
//�ؿ�
/*******************************/
//���������Ͽ�ؿ�
function Regist_Init_Part($db_con,$shop_id){

    $sql  = "INSERT INTO ";
    $sql .= "t_part(";
    $sql .= "part_id, part_cd, part_name, branch_id,note, ";
    $sql .= "shop_id";
    $sql .= ") ";
    $sql .= "VALUES(";
    $sql .= "(SELECT COALESCE(MAX(part_id), 0)+1 FROM t_part), ";
    $sql .= "'001', ";
    $sql .= "'�������', ";
    $sql .= "NULL, ";
    $sql .= "'', ";
    $sql .= "$shop_id ";
    $sql .= ") ";
    $sql .= ";";

    $result  = Db_Query($db_con, $sql);

}

//�����Ź���������Ͽ����ؿ�
function Update_Part_Branch($db_con,$shop_id,$branch_id){

    // �ѹ�SQL
    $sql  = "UPDATE t_part SET ";
    $sql .= "branch_id     = '$branch_id' ";
    $sql .= "WHERE shop_id = $shop_id ";
    $sql .= ";";

    $result  = Db_Query($db_con, $sql);

}


//�Ƥ��ѹ��������˻Ҥ򥢥åץǡ��Ȥ���ؿ�
function Child_Update($client_id, $close_day, $pay_m, $pay_d, $coax, $tax_div, $tax_franct, $c_tax_div, $db_con){

    $sql  = "UPDATE \n";
    $sql .= "   t_client \n";
    $sql .= "SET \n";
    $sql .= "   coax       = '$coax', \n";
    $sql .= "   tax_div    = '$tax_div', \n";
    $sql .= "   tax_franct = '$tax_franct', \n";
    $sql .= "   c_tax_div  = '$c_tax_div', \n";
    $sql .= "   pay_m      = '$pay_m', \n";
    $sql .= "   pay_d      = '$pay_d', \n";
    $sql .= "   close_day  = '$close_day' \n";
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
}

//�ѹ����������OR�Ȳ������Ȥ��ƻ��ꤵ��Ƥ�����ɼ�򥢥åץǡ���
function Aord_Act_Data_Update ($conn, $act_data){

    //�����ɼ���åץǡ���
    $sql  = "UPDATE ";
    $sql .= "   t_aorder_h ";
    $sql .= "SET ";
    $sql .= "   act_cd1  = '".$act_data["act_cd1"]."',";
    $sql .= "   act_cd2  = '".$act_data["act_cd2"]."',";
    $sql .= "   act_name = '".$act_data["act_name"]."'";
    $sql .= "WHERE ";
    $sql .= "   shop_id  = 93 ";
    $sql .= "   AND ";
    $sql .= "   act_id   = ".$act_data["act_id"]." ";
    $sql .= "   AND ";
    $sql .= "   ps_stat  = '1' ";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK;");
        exit;
    }

    //�Ҳ�����襢�åץǡ���
    $sql  = "UPDATE ";
    $sql .= "   t_aorder_h ";
    $sql .= "SET ";
    $sql .= "   intro_ac_cd1 = '".$act_data["act_cd1"]."', ";
    $sql .= "   intro_ac_cd2 = '".$act_data["act_cd2"]."', ";
    $sql .= "   intro_ac_name = '".$act_data["act_name"]."' ";
    $sql .= "WHERE ";
    $sql .= "   shop_id = 93 ";
    $sql .= "   AND ";
    $sql .= "   intro_account_id = ".$act_data["act_id"]." ";
    $sql .= "   AND ";
    $sql .= "   ps_stat = '1' ";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK;");
        exit;
    }
}

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
$contract .= "  var OY = \"form_establish_day[y]\";\n";
$contract .= "  var OM = \"form_establish_day[m]\";\n";
$contract .= "  var OD = \"form_establish_day[d]\";\n";
$contract .= "  var CY = \"form_corpo_day[y]\";\n";
$contract .= "  var CM = \"form_corpo_day[m]\";\n";
$contract .= "  var CD = \"form_corpo_day[d]\";\n";
$contract .= "  var s_year = parseInt(me.elements[SY].value);\n";
$contract .= "  var r_year = parseInt(me.elements[RY].value);\n";
$contract .= "  var term = me.elements[TERM].value;\n";
$contract .= "  len_ry = me.elements[RY].value.length;\n";
$contract .= "  len_rm = me.elements[RM].value.length;\n";
$contract .= "  len_rd = me.elements[RD].value.length;\n";
$contract .= "  len_sy = me.elements[SY].value.length;\n";
$contract .= "  len_sm = me.elements[SM].value.length;\n";
$contract .= "  len_sd = me.elements[SD].value.length;\n";
$contract .= "  len_om = me.elements[OM].value.length;\n";
$contract .= "  len_od = me.elements[OD].value.length;\n";
$contract .= "  len_cm = me.elements[CM].value.length;\n";
$contract .= "  len_cd = me.elements[CD].value.length;\n";
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
$contract .= "  if(len_om == 1){\n";
$contract .= "      me.elements[OM].value = '0'+me.elements[OM].value;\n";
$contract .= "      len_rm = me.elements[OM].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(len_od == 1){\n";
$contract .= "      me.elements[OD].value = '0'+me.elements[OD].value;\n";
$contract .= "      len_rm = me.elements[OD].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(len_cm == 1){\n";
$contract .= "      me.elements[CM].value = '0'+me.elements[CM].value;\n";
$contract .= "      len_rm = me.elements[CM].value.length;\n";
$contract .= "  }\n";
$contract .= "  if(len_cd == 1){\n";
$contract .= "      me.elements[CD].value = '0'+me.elements[CD].value;\n";
$contract .= "      len_rm = me.elements[CD].value.length;\n";
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

/***************************/
//Code_value
/***************************/
//������
$where_sql = "    WHERE";
$where_sql .= "        client_div = '3'";

$code_value = Code_Value("t_client",$conn,'',4);

/****************************/
//js
/****************************/
//�����ʬ�˸�������򤷤����ϡ��������ʧ���ˤ��롣
$contract .= "function trade_close_day(){\n";
$contract .= "  if(document.dateForm.trade_aord_1.value=='61'){\n";
$contract .= "      var close_day = document.dateForm.form_close_1.value\n";
$contract .= "      document.dateForm.form_pay_month.value='0';\n";
$contract .= "      document.dateForm.form_pay_day.value=close_day;\n";
$contract .= "  } \n";
$contract .= "}\n";

$contract .= "function trade_buy_close_day(){\n";
$contract .= "  if(document.dateForm.trade_buy_1.value=='71'){\n";
$contract .= "      var close_day = document.dateForm.form_close_1.value\n";
$contract .= "      document.dateForm.form_payout_month.value='0';\n";
$contract .= "      document.dateForm.form_payout_day.value=close_day;\n";
$contract .= "  } \n";
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
$count_sql  = " SELECT ";
$count_sql .= "     COUNT(client_cd1)";
$count_sql .= " FROM";
$count_sql .= "    t_client ";
$count_sql .= " WHERE";
$count_sql .= "    client_div = '3'";
$count_sql .= "     AND";
$count_sql .= "     t_client.state = 1";
$count_sql .= ";";
//�إå�����ɽ������������ǡ������
$result = Db_Query($conn, $count_sql);
$dealing_count = pg_fetch_result($result,0,0);

$count_sql  = " SELECT ";
$count_sql .= "     COUNT(client_cd1)";
$count_sql .= " FROM";
$count_sql .= "    t_client ";
$count_sql .= " WHERE";
$count_sql .= "    client_div = '3'";
$count_sql .= ";";
//�إå�����ɽ�������������
$result = Db_Query($conn, $count_sql);
$total_count = pg_fetch_result($result,0,0);

$page_title .= "(�����".$dealing_count."��/�� ".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
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
    'code_value'            => "$code_value",
    'contract'              => "$contract",
    'sday_err'              => "$sday_err",
    'rday_err'              => "$rday_err",
    'eday_err'              => "$eday_err",
    'cday_err'              => "$cday_err",
    'sday_rday_err'         => "$sday_rday_err",
    'shop_cd_err'           => "$shop_cd_err",
    'tel_err'               => "$tel_err",
    'fax_err'               => "$fax_err",
    'email_err'             => "$email_err",
    'url_err'               => "$url_err",
    'd_tel_err'             => "$d_tel_err",
    'next_id'               => "$next_id",
    'back_id'               => "$back_id",
    'contact_cell_err'      => "$contact_cell_err",
    'represent_cell_err'    => "$represent_cell_err",
    'account_tel_err'       => "$account_tel_err",
    'auth_r_msg'            => "$auth_r_msg",
    'claim_close_day_err'   => "$claim_close_day_err",
    'claim_coax_err'        => "$claim_coax_err",
    'claim_tax_div_err'     => "$claim_tax_div_err",
    'claim_tax_franct_err'  => "$claim_tax_franct_err",
    'claim_c_tax_div_err'   => "$claim_c_tax_div_err",
    'close_day_err'         => "$close_day_err",
    'close_outday_err'      => "$close_outday_err",
    'claim_err'             => "$claim_err",
    'js'                    => "$js",
    "freeze_flg"            => "$freeze_flg",
    #2010-05-01 hashimoto-y
    'address1_err'          => "$address1_err",
    'address2_err'          => "$address2_err",
    'address3_err'          => "$address3_err",
    'comp_name1_err'        => "$comp_name1_err",
    'comp_name2_err'        => "$comp_name2_err",
    'shop_name_err'         => "$shop_name_err",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
