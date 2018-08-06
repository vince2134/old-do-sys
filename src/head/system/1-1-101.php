<?php

/******************************************************/
//�ѹ�����  
//  (2006/03/16)
//  ��DB�����ѹ��ˤ�ꡢ����SQL�ѹ�
//  �������ե�����ɽ���ܥ����ɲ�  
//  (2006/07/07 kaji)
//  ��shop_gid��ʤ���
/******************************************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0005     suzuki     CSV���ϻ��ˤϥ��˥������󥰤��ʤ��褦�˽���
 *  2007-01-23      �����ѹ�     watanabe-k �ܥ��󥫥顼�ѹ�
 *  2007-02-22                   watanabe-k ���׵�ǽ�κ�� 
 *  2007-04-04                   watanabe-k ά�ΤǸ����Ǥ���褦�˽��� 
 *  2007-05-09                   kaku-m     csv���Ϲ��ܤ��ɲ�
 *  2007-05-21                   watanabe-k ���ʸ������ɲ� 
 *  2007-07-27                   watanabe-k ��٥���Ϥ��ɲ� 
 *  2010-01-29                   hashimoto-y����Ǥ��ɲ�
 *  2010-05-01      Rev.1.5����  hashimoto-y�����ΰ���ե���ȥ������ѹ���ǽ���ɲ�
 *  2010-05-13      Rev.1.5����  hashimoto-y���ɽ���˸������ܤ���ɽ�����뽤��
 *
*/

$page_title = "FC�������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// �ƥ�ץ졼�ȴؿ���쥸����
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION[shop_id];
//$shop_gid = $_SESSION[shop_gid];
//$shop_aid = $_SESSION[shop_aid];

/****************************/
//�ե���������
/****************************/
$def_fdata = array(
    "form_output_type"  => "1",
    "form_state_type"   => "1"
);
$form->setDefaults($def_fdata);


// ���Ϸ���
$radio1[] =& $form->createElement( "radio", null, null, "����", "1");
$radio1[] =& $form->createElement( "radio", null, null, "CSV", "2");
$form->addGroup($radio1, "form_output_type", "���Ϸ���");

// ����
$radio2[] =& $form->createElement( "radio", null, null, "�����", "1");
$radio2[] =& $form->createElement( "radio", null, null, "���󡦵ٻ���", "2");
$radio2[] =& $form->createElement( "radio", null, null, "����", "3");
$form->addGroup($radio2, "form_state_type", "����");

// �����å��ܥå���
$form->addElement("checkbox", "f_check", "�����å��ܥå���", "");

// TEL
$form->addElement("text", "form_tel", "", "size=\"15\" maxLength=\"13\" style=\"$g_form_style\"  $g_form_option");

// ����åץ�����
$text1[] =& $form->createElement("text", "cd1", "����åץ����ɣ�", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onKeyup=\"changeText(this.form,'form_shop_cd[cd1]','form_shop_cd[cd2]',6);\" $g_form_option");
$text1[] =& $form->createElement("static","","","-");
$text1[] =& $form->createElement("text", "cd2", "����åץ����ɣ�", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text1, "form_shop_cd", "����åץ�����");

// ����å�̾����̾
$form->addElement("text", "form_shop_name", "����å�̾����̾", "size=\"34\" maxLength=\"15\""." $g_form_option");

// �����襳����
$text2[] =& $form->createElement("text", "cd1", "�����襳���ɣ�", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_claim_cd[cd1]','form_claim_cd[cd2]',6);\" $g_form_option");
$text2[] =& $form->createElement("static", "", "", "-");
$text2[] =& $form->createElement("text", "cd2", "�����襳���ɣ�", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text2, "form_claim_cd", "form_claim_cd");

// ������̾
$form->addElement("text", "form_claim_name", "������̾", "size=\"34\" maxLength=\"15\""." $g_form_option");

// FC��������ʬ
$select_value = Select_Get($conn, "rank");
$form->addElement("select", "form_rank_1", "FC��������ʬ", $select_value, $g_form_option_select);

// �϶�
$select_value = Select_Get($conn, "area");
$form->addElement("select", "form_area_1", "�϶�", $select_value, $g_form_option_select);

// ô����
$select_value = Select_Get($conn, "staff");
$form->addElement("select", "form_staff_1", "ô����", $select_value, $g_form_option_select);

// �����ȥ��
$ary_sort_item = array(
    "sl_client_cd"      => "����åץ�����",
    "sl_client_name"    => "����å�̾",
    "sl_shop_name"      => "��̾",
    "sl_rank"           => "FC��������ʬ",
    "sl_area"           => "�϶�",
    "sl_claim_cd"       => "�����襳����",
    "sl_claim_name"     => "������̾",
    "sl_staff"          => "ô����̾",
    "sl_tel"            => "T E L",
    "sl_day"            => "����ǯ����",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_area");

//ɽ���ܥ���
$button[] = $form->createElement("submit","show_button","ɽ����");

//���ꥢ�ܥ���
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//����
$form->addElement("submit","form_search_button","�����ե������ɽ��","");

//��Ͽ
$form->addElement("button","new_button","��Ͽ����","onClick=\"javascript:Referer('1-1-103.php')\"");

//�ѹ�������
//$form->addElement("button","change_button","�ѹ�������","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","�ѹ�������", $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addGroup($button, "form_button", "�ܥ���");

$form->addElement("checkbox", "label_check_all", "", "��٥����", "onClick=\"javascript:All_Label_Check('label_check_all');\"");
#2010-05-13 hashimoto-y
#$form->addElement("submit","form_label_button","��٥����","onClick=\"javascript:Post_book_vote('./1-1-111.php','#');\"");
$form->addElement("button","form_label_button","��٥����","onClick=\"javascript:Post_book_vote3('./1-1-111.php','#');\"");

//���ȯ��
/*
$form->addElement(
    "button","slip_button","���ȯ��",
    "onClick=\"javascript:Post_book_vote('".HEAD_DIR."system/1-1-102.php')\""
);
*/
$form->addElement("hidden", "hdn_search_flg");        //�����ե�����ɽ���ե饰

//������ﵭ����
$form->addElement("hidden", "hdn_output_type");   //���Ϸ���
$form->addElement("hidden", "hdn_state_type");    //����
$form->addElement("hidden", "hdn_shop_cd1");      //����åץ����ɣ�
$form->addElement("hidden", "hdn_shop_cd2");      //����åץ����ɣ�
$form->addElement("hidden", "hdn_shop_name");     //����å�̾
$form->addElement("hidden", "hdn_rank");          //FC��������ʬ
$form->addElement("hidden", "hdn_area");          //�϶�
$form->addElement("hidden", "hdn_claim_cd1");     //�����襳���ɣ�
$form->addElement("hidden", "hdn_claim_cd2");     //�����襳���ɣ�
$form->addElement("hidden", "hdn_claim_name");    //������̾
$form->addElement("hidden", "hdn_staff");         //ô����
$form->addElement("hidden", "hdn_tel");



#2010-05-13 hashimoto-y
if($_POST["form_button"]["show_button"] == "ɽ����"){



/****************************/
//���������
/****************************/
$fc_sql  = " SELECT ";
$fc_sql .= "     t_client.client_id,";                      // 0 ������ID
$fc_sql .= "     t_client.client_cd1,";                     // 1 �����襳���ɣ�
$fc_sql .= "     t_client.client_cd2,";                     // 2 �����襳���ɣ�
$fc_sql .= "     t_client.client_name,";                    // 3 ������̾
$fc_sql .= "     t_client.shop_name,";                      // 4 ��̾
$fc_sql .= "     t_rank.rank_name,";                        // 5 FC��������ʬ
$fc_sql .= "     t_area.area_name,";                        // 6 �϶�
$fc_sql .= "     t_client_claim.client_cd1,";               // 7 �����襳���ɣ�
$fc_sql .= "     t_client_claim.client_cd2,";               // 8 �����襳���ɣ�
$fc_sql .= "     t_client_claim.shop_name,";                // 9 ������̾
$fc_sql .= "     t_staff.staff_name,";                      // 10 ô����̾
$fc_sql .= "     t_client.state,";                          // 11 ����
$fc_sql .= "     t_client.tel,";                            // 12 Tel
$fc_sql .= "     t_client.cont_sday";                       // 13 ����ǯ����
//csv������
if($_POST["form_button"]["show_button"] == "ɽ����"){$output_type    = $_POST["form_output_type"];}
if($output_type == 2){
$fc_sql .= "    ,";
$fc_sql .= "    t_sbtype.sbtype_name,";                     // 14 ��ʬ��ȼ�̾
$fc_sql .= "    t_inst.inst_name,";                         // 15 ����̾
$fc_sql .= "    t_bstruct.bstruct_name, ";                  // 16 ����̾
$fc_sql .= "    t_staff_sv.staff_name, ";                   // 17 SV
$fc_sql .= "    t_staff_1.staff_name, ";                    // 18 ô����
$fc_sql .= "    t_staff_2.staff_name, ";                    // 19 ô����
$fc_sql .= "    t_staff_3.staff_name, ";                    // 20 ô����
$fc_sql .= "    t_staff_4.staff_name, ";                    // 21 ô����
$fc_sql .= "    t_client.client_read, ";                    // 22 ������̾�ʥեꥬ�ʡ�
$fc_sql .= "    t_client.client_cname,";                    // 23 ά��
$fc_sql .= "    t_client.client_cread, ";                   // 24 ά�Ρʥեꥬ�ʡ�
$fc_sql .= "    CASE t_client.compellation ";               // 25 �ɾ�
$fc_sql .= "        WHEN '1' THEN '����' ";
$fc_sql .= "        WHEN '2' THEN '��' ";
$fc_sql .= "    END AS compellation, ";
$fc_sql .= "    t_client.shop_read, ";                      // 26 ��̾�ʥեꥬ�ʡ�
$fc_sql .= "    t_client.shop_name2, ";                     // 27 ��̾��
$fc_sql .= "    t_client.shop_read2, ";                     // 28 ��̾���ʥեꥬ�ʡ�
$fc_sql .= "    t_client.post_no1, ";                       // 29 ͹���ֹ棱
$fc_sql .= "    t_client.post_no2, ";                       // 30 ͹���ֹ棲
$fc_sql .= "    t_client.address1, ";                       // 31 ���꣱
$fc_sql .= "    t_client.address2, ";                       // 32 ���ꣲ
$fc_sql .= "    t_client.address3, ";                       // 33 ���ꣳ
$fc_sql .= "    t_client.address_read, ";                   // 34 ����ʥեꥬ�ʡ�
$fc_sql .= "    t_client.fax, ";                            // 35 FAX
$fc_sql .= "    t_client.email, ";                          // 36 Email
$fc_sql .= "    t_client.url, ";                            // 37 URL
$fc_sql .= "    t_client.capital, ";                        // 38 ���ܶ�
$fc_sql .= "    t_client.rep_name, ";                       // 39 ��ɽ�Ի�̾
$fc_sql .= "    t_client.represe, ";                        // 40 ��ɽ����
$fc_sql .= "    t_client.rep_htel, ";                       // 41 ��ɽ�Է���
$fc_sql .= "    t_client.direct_tel, ";                     // 42 ľ��TEL
$fc_sql .= "    t_client.join_money, ";                     // 43 ������
$fc_sql .= "    t_client.guarant_money, ";                  // 44 �ݾڶ�
$fc_sql .= "    t_client.royalty_rate, ";                   // 45 �������ƥ�
$fc_sql .= "    t_client.cutoff_month, ";                   // 46 �軻���ʷ��
$fc_sql .= "    t_client.cutoff_day, ";                     // 47 �軻��������
$fc_sql .= "    t_client.col_terms, ";                      // 48 ������
$fc_sql .= "    t_client.credit_limit, ";                   // 49 Ϳ������
$fc_sql .= "    CASE t_client.close_day ";                  // 50 ����
$fc_sql .= "        WHEN '29' THEN '����' ";
$fc_sql .= "        ELSE t_client.close_day || '��' ";
$fc_sql .= "    END AS close_day, ";
$fc_sql .= "    CASE t_client.pay_m ";                      // 51 �������ʷ��
$fc_sql .= "        WHEN '0' THEN '����' ";
$fc_sql .= "        WHEN '1' THEN '���' ";
$fc_sql .= "        ELSE t_client.pay_m || '�����'";
$fc_sql .= "    END AS pay_m, ";
$fc_sql .= "    CASE t_client.pay_d ";                      // 52 ������������
$fc_sql .= "        WHEN '29' THEN '����' ";
$fc_sql .= "        ELSE t_client.pay_d || '��' ";
$fc_sql .= "    END AS pay_d, ";
$fc_sql .= "    CASE t_client.pay_way ";                    // 53 ������ˡ
$fc_sql .= "        WHEN '1' THEN '��ư����' ";
$fc_sql .= "        WHEN '2' THEN '����' ";
$fc_sql .= "        WHEN '3' THEN 'ˬ�佸��' ";
$fc_sql .= "        WHEN '4' THEN '���' ";
$fc_sql .= "        WHEN '5' THEN '����¾' ";
$fc_sql .= "    END AS pay_way, ";
$fc_sql .= "    t_client.pay_name, ";                       // 54 ����̾��
$fc_sql .= "    t_client.account_name, ";                   // 55 ����̾��
$fc_sql .= "    CASE WHEN t_client.account_id IS NOT NULL ";// 56 �������
$fc_sql .= "        THEN t_bank.bank_name || ' ' || t_b_bank.b_bank_name || ' ' ||CASE t_account.deposit_kind  WHEN '1' THEN '���� 'WHEN '2' THEN '���� ' END || t_account.account_no ";
$fc_sql .= "    END AS pay_bank, ";
$fc_sql .= "    t_trade.trade_name, ";                      // 57 ����������ʬ
$fc_sql .= "    CASE t_client.payout_m ";                   // 58 ��ʧ���ʷ��
$fc_sql .= "        WHEN '0' THEN '����' ";
$fc_sql .= "        WHEN '1' THEN '���' ";
$fc_sql .= "        ELSE t_client.payout_m || '�����' ";
$fc_sql .= "    END AS payout_m, ";
$fc_sql .= "    CASE t_client.payout_d";                    // 59 ��ʧ��������
$fc_sql .= "        WHEN '29' THEN '����' ";
$fc_sql .= "        ELSE t_client.payout_d || '��' ";
$fc_sql .= "    END AS payout_d, ";
$fc_sql .= "    t_client.bank_name, ";                      // 60 ��������
$fc_sql .= "    t_client.b_bank_name, ";                    // 61 ��������ά��
$fc_sql .= "    t_buy_trade.trade_name, ";                  // 62 ����������ʬ
$fc_sql .= "    t_client.charger_name, ";                   // 63 Ϣ��ô���Ի�̾
$fc_sql .= "    t_client.charger, ";                        // 64 Ϣ��ô������
$fc_sql .= "    t_client.cha_htel, ";                       // 65 Ϣ��ô���Է���
$fc_sql .= "    t_client.accountant_name, ";                // 66 ���ô���Ի�̾
$fc_sql .= "    t_client.account_tel, ";                    // 67 ���ô���Է���
$fc_sql .= "    t_client.surety_name1, ";                   // 68 �ݾڿͣ���̾
$fc_sql .= "    t_client.surety_addr1, ";                   // 69 �ݾڿͣ�����
$fc_sql .= "    t_client.surety_name2, ";                   // 70 �ݾ�ͣ���̾
$fc_sql .= "    t_client.surety_addr2, ";                   // 71 �ݾڿͣ�����
$fc_sql .= "    t_client.trade_base, ";                     // 72 �Ķȵ���
$fc_sql .= "    t_client.holiday, ";                        // 73 ����
$fc_sql .= "    t_client.trade_area, ";                     // 74 ����
$fc_sql .= "    t_client.c_compa_name, ";                   // 75 ������̾
$fc_sql .= "    t_client.c_compa_rep, ";                    // 76 ������ɽ��̾
$fc_sql .= "    t_client.cont_sday, ";                      // 77 ����ǯ����
$fc_sql .= "    t_client.cont_rday, ";                      // 78 ���󹹿���
$fc_sql .= "    t_client.cont_eday, ";                      // 79 ����λ��
$fc_sql .= "    t_client.cont_peri, ";                      // 80 �������
$fc_sql .= "    t_client.establish_day, ";                  // 81 �϶���
$fc_sql .= "    t_client.regist_day, ";                     // 82 ˡ���е���
$fc_sql .= "    CASE t_client.slip_out ";                   // 83 ��ɼȯ��
$fc_sql .= "        WHEN '1' THEN 'ͭ' ";
$fc_sql .= "        WHEN '2' THEN '����' ";
$fc_sql .= "        WHEN '3' THEN '̵' ";
$fc_sql .= "    END AS slip_out, ";
$fc_sql .= "    CASE t_client.deliver_effect ";             // 84 Ǽ�ʽ񥳥��ȡʸ��̡�
$fc_sql .= "        WHEN '1' THEN '������ͭ��' ";
$fc_sql .= "        WHEN '2' THEN '���̥�����ͭ��' ";
$fc_sql .= "        WHEN '3' THEN '���Υ�����ͭ��' ";
$fc_sql .= "    END AS deliver_effect, ";
$fc_sql .= "    t_client.deliver_note, ";                   // 85 Ǽ�ʽ񥳥���
$fc_sql .= "    CASE t_client.claim_out ";                  // 86 �����ȯ��
$fc_sql .= "        WHEN '1' THEN '���������' ";
$fc_sql .= "        WHEN '2' THEN '��������' ";
$fc_sql .= "        WHEN '3' THEN '���Ϥ��ʤ�' ";
$fc_sql .= "        WHEN '4' THEN '����' ";
$fc_sql .= "    END AS claim_out, ";
$fc_sql .= "    CASE t_client.claim_send ";                 // 87 ���������
$fc_sql .= "        WHEN '1' THEN '͹��' ";
$fc_sql .= "        WHEN '2' THEN '�᡼��' ";
$fc_sql .= "        WHEN '3' THEN 'ξ��' ";
$fc_sql .= "    END AS claim_send, ";
$fc_sql .= "    t_claim_sheet.c_pattern_name, ";            // 88 ������ͼ�
$fc_sql .= "    CASE t_client.coax ";                       // 89 ��۴ݤ��ʬ
$fc_sql .= "        WHEN '1' THEN '�ڼ�' ";
$fc_sql .= "        WHEN '2' THEN '�ͼθ���' ";
$fc_sql .= "        WHEN '3' THEN '�ھ�' ";
$fc_sql .= "    END AS coax, ";
$fc_sql .= "    CASE t_client.tax_div ";                    // 90 ������:����ñ��
$fc_sql .= "        WHEN '1' THEN '����ñ��' ";
$fc_sql .= "        WHEN '2' THEN '��ɼñ��' ";
$fc_sql .= "    END AS tax_div, ";
$fc_sql .= "    CASE t_client.tax_franct ";                 // 91 ������:ü����ʬ
$fc_sql .= "        WHEN '1' THEN '�ڼ�' ";
$fc_sql .= "        WHEN '2' THEN '�ͼθ���' ";
$fc_sql .= "        WHEN '3' THEN '�ھ�' ";
$fc_sql .= "    END AS tax_franct, ";
$fc_sql .= "    CASE t_client.c_tax_div ";                  // 92 ������:���Ƕ�ʬ
$fc_sql .= "        WHEN '1' THEN '����' ";
$fc_sql .= "        WHEN '2' THEN '����' ";
#2010-01-29 hashimoto-y
$fc_sql .= "        WHEN '3' THEN '�����' ";
$fc_sql .= "    END AS c_tax_div, ";
$fc_sql .= "    t_client.license, ";                        // 93 ������ʡ�����ʬ��
$fc_sql .= "    t_client.s_contract, ";                     // 94 ����
$fc_sql .= "    t_client.importance, ";                     // 95 ���׻���
$fc_sql .= "    t_client.other, ";                          // 96 ����¾
$fc_sql .= "    t_client.deal_history, ";                    // 97 �������

#2010-05-01 hashimoto-y
$fc_sql .= "   CASE t_client.bill_address_font \n";         // 98 �������
$fc_sql .= "       WHEN 't' THEN '��' \n";
$fc_sql .= "       WHEN 'f' THEN '' \n";
$fc_sql .= "   END  ";

}
$fc_sql .= " FROM";
$fc_sql .= "     t_client ";
$fc_sql .= "     AS ";
$fc_sql .= "     t_client_claim,";
$fc_sql .= "     t_claim,";
$fc_sql .= "     t_area,";
$fc_sql .= "     t_rank, ";
$fc_sql .= "     t_client ";
$fc_sql .= "     LEFT JOIN ";
$fc_sql .= "     t_staff ";
$fc_sql .= "     ON t_staff.staff_id = t_client.sv_staff_id ";
//csv������
if($output_type == 2){
$fc_sql .= "     LEFT JOIN t_sbtype ";
$fc_sql .= "     ON t_client.sbtype_id = t_sbtype.sbtype_id ";
$fc_sql .= "     LEFT JOIN t_inst ";
$fc_sql .= "     ON t_client.inst_id = t_inst.inst_id ";
$fc_sql .= "     LEFT JOIN t_bstruct ";
$fc_sql .= "     ON t_bstruct.bstruct_id = t_client.b_struct ";
$fc_sql .= "     LEFT JOIN t_staff AS t_staff_sv ";
$fc_sql .= "     ON t_staff_sv.staff_id = t_client.sv_staff_id ";
$fc_sql .= "     LEFT JOIN t_staff AS t_staff_1 ";
$fc_sql .= "     ON t_staff_1.staff_id = t_client.b_staff_id1 ";
$fc_sql .= "     LEFT JOIN t_staff AS t_staff_2 ";
$fc_sql .= "     ON t_staff_2.staff_id = t_client.b_staff_id2 ";
$fc_sql .= "     LEFT JOIN t_staff AS t_staff_3 ";
$fc_sql .= "     ON t_staff_3.staff_id = t_client.b_staff_id3 ";
$fc_sql .= "     LEFT JOIN t_staff AS t_staff_4 ";
$fc_sql .= "     ON t_staff_4.staff_id = t_client.b_staff_id4 ";
$fc_sql .= "     LEFT JOIN t_account \n";
$fc_sql .= "     ON t_account.account_id = t_client.account_id \n";
$fc_sql .= "     LEFT JOIN t_b_bank \n";
$fc_sql .= "     ON t_b_bank.b_bank_id = t_account.b_bank_id \n";
$fc_sql .= "     LEFT JOIN t_bank \n";
$fc_sql .= "     ON t_bank.bank_id = t_b_bank.bank_id \n";
$fc_sql .= "     LEFT JOIN t_trade ";
$fc_sql .= "     ON t_trade.trade_id = t_client.trade_id ";
$fc_sql .= "     LEFT JOIN t_trade as t_buy_trade ";
$fc_sql .= "     ON t_buy_trade.trade_id = t_client.buy_trade_id ";
$fc_sql .= "     LEFT JOIN t_claim_sheet ";
$fc_sql .= "     ON t_claim_sheet.c_pattern_id = t_client.c_pattern_id ";

}
//$fc_sql .= "     t_shop_gr";
$fc_sql .= " WHERE";
$fc_sql .= "     t_client.area_id = t_area.area_id";
$fc_sql .= "     AND";
$fc_sql .= "     t_client.client_id = t_claim.client_id";
$fc_sql .= "     AND";
$fc_sql .= "     t_client_claim.client_id = t_claim.claim_id";
$fc_sql .= "     AND";
//$fc_sql .= "     t_client.attach_gid = t_shop_gr.shop_gid";
//$fc_sql .= "     AND";
//$fc_sql .= "     t_shop_gr.rank_cd = t_rank.rank_cd";
$fc_sql .= "     t_client.rank_cd = t_rank.rank_cd";
$fc_sql .= "     AND";
$fc_sql .= "     t_client.client_div = 3";
/*
//���ɽ�����ϼ����Υǡ����Τ�
if($_POST["form_button"]["show_button"] != "ɽ����" || $_POST["form_search_button"] != "�����ե������ɽ��"){
    $fc_sql .= "     AND";
    $fc_sql .= "     t_client.state = '1'";
}

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

/****************************/
//�����ե������ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_search_button"] == "�����ե������ɽ��"){
    $search_flg = true;
    $search_data["hdn_search_flg"] = $search_flg;
    $form->setConstants($search_data);

    $state = '1';
    $output_type = '1';

    $sort_col = $_POST["hdn_sort_col"];

    $post_flg = true;
}

/****************************/
//ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];          //���Ϸ���
    $state          = $_POST["form_state_type"];           //����
    $shop_cd1       = trim($_POST["form_shop_cd"]["cd1"]); //����åץ�����1
    $shop_cd2       = trim($_POST["form_shop_cd"]["cd2"]); //����åץ�����2
    $shop_name      = $_POST["form_shop_name"];            //����å�̾/��̾
    $rank           = $_POST["form_rank_1"];               //FC��������ʬ
    $area           = $_POST["form_area_1"];               //�϶�
    $claim_cd1      = trim($_POST["form_claim_cd"]["cd1"]);//�����襳����1
    $claim_cd2      = trim($_POST["form_claim_cd"]["cd2"]);//�����襳����2
    $claim_name     = $_POST["form_claim_name"];           //������̾
    $staff          = $_POST["form_staff_1"];              //ô����
    $tel            = $_POST["form_tel"];                  //TEL
    $post_flg       = true;                                //POST�ե饰

    $sort_col = $_POST["hdn_sort_col"];

/*****************************/
//������󥯤��������줿���
/*****************************/
}elseif(count($_POST) > 0
    && $_POST["form_button"]["show_button"] != "ɽ����"
    && $_POST["form_search_button"] != "�����ե������ɽ��"){

    $output_type    = $_POST["hdn_output_type"];            //���Ϸ���
    $state          = $_POST["hdn_state_type"];             //����
    $shop_cd1       = $_POST["hdn_shop_cd1"];               //����åץ����ɣ�
    $shop_cd2       = $_POST["hdn_shop_cd2"];               //����åץ����ɣ�
    $shop_name      = $_POST["hdn_shop_name"];              //����å�̾/��̾
    $rank           = $_POST["hdn_rank"];                   //FC��������ʬ
    $area           = $_POST["hdn_area"];                   //�϶�
    $claim_cd1      = $_POST["hdn_claim_cd1"];              //�����襳���ɣ�
    $claim_cd2      = $_POST["hdn_claim_cd2"];              //�����襳���ɣ�
    $claim_name     = $_POST["hdn_claim_name"];             //������̾
    $staff          = $_POST["hdn_staff"];                  //ô����
    $tel            = $_POST["hdn_tel"];                    //TEL

    $sort_col = $_POST["hdn_sort_col"];
    $post_flg       = true;
}else{
    $post_flg       = true;
    $sort_col       = "sl_area";
    $state = '1';
}

if($post_flg == true){
    /****************************/
    //�����ǡ����򥻥å�
    /****************************/
    $set_data["form_output_type"]       = stripslashes($output_type);     //���Ϸ���
    $set_data["form_state_type"]        = stripslashes($state);           //����
    $set_data["form_shop_cd"]["cd1"]    = stripslashes($shop_cd1);        //����åץ����ɣ�
    $set_data["form_shop_cd"]["cd2"]    = stripslashes($shop_cd2);        //����åץ����ɣ�
    $set_data["form_shop_name"]         = stripslashes($shop_name);       //����å�̾/��̾
    $set_data["form_rank_1"]            = stripslashes($rank);            //FC��������ʬ
    $set_data["form_area_1"]            = stripslashes($area);            //�϶�
    $set_data["form_claim_cd"]["cd1"]   = stripslashes($claim_cd1);       //�����襳���ɣ�
    $set_data["form_claim_cd"]["cd2"]   = stripslashes($claim_cd2);       //�����襳���ɣ�
    $set_data["form_claim_name"]        = stripslashes($claim_name);      //������̾
    $set_data["form_staff_1"]           = stripslashes($staff);           //ô����
    $set_data["form_tel"]               = stripslashes($tel);             //TEL

    $set_data["hdn_output_type"]        = stripslashes($output_type);     //���Ϸ���
    $set_data["hdn_state_type"]         = stripslashes($state);      //����
    $set_data["hdn_shop_cd1"]           = stripslashes($shop_cd1);        //����åץ����ɣ�
    $set_data["hdn_shop_cd2"]           = stripslashes($shop_cd2);        //����åץ����ɣ�
    $set_data["hdn_shop_name"]          = stripslashes($shop_name);       //����å�̾/��̾
    $set_data["hdn_rank"]               = stripslashes($rank);            //FC��������ʬ
    $set_data["hdn_area"]               = stripslashes($area);            //�϶�
    $set_data["hdn_claim_cd1"]          = stripslashes($claim_cd1);       //�����襳���ɣ�
    $set_data["hdn_claim_cd2"]          = stripslashes($claim_cd2);       //�����襳���ɣ�
    $set_data["hdn_claim_name"]         = stripslashes($claim_name);      //������̾
    $set_data["hdn_staff"]              = stripslashes($staff);           //ô����
    $set_data["hdn_tel"]                = stripslashes($tel);             //TEL

    $form->setConstants($set_data);
        
    /****************************/
    //where_sql����
    /****************************/
    //����åץ�����1
    if($shop_cd1 != null){
        $shop_cd1_sql  = " AND t_client.client_cd1 LIKE '$shop_cd1%'";
    }

    //����åץ�����2
    if($shop_cd2 != null){
        $shop_cd2_sql  = " AND t_client.client_cd2 LIKE '$shop_cd2%'";
    }

    //����å�̾
    if($shop_name != null){
        $shop_name_sql  = " AND (t_client.client_name LIKE '%$shop_name%' 
                            OR t_client.shop_name LIKE '%$shop_name%' 
                            OR t_client.client_read LIKE '%$shop_name%' 
                            OR t_client.client_read2 LIKE '%$shop_name%' 
                            OR t_client.client_cread LIKE '%$shop_name%' 
                            OR t_client.client_cname LIKE '%$shop_name%')";
    }

    //FC��������ʬ
    if($rank != 0){
        $rank_id_sql = " AND t_rank.rank_cd = '$rank'";
    }

    //�϶�
    if($area != 0){
        $area_sql = " AND t_area.area_id = '$area'";
    }

    //�����襳����1
    if($claim_cd1 != null){
        $claim_cd1_sql  = " AND t_client_claim.client_cd1 LIKE '$claim_cd1%'";
    }

    //�����襳����2
    if($claim_cd2 != null){
        $claim_cd2_sql  = " AND t_client_claim.client_cd2 LIKE '$claim_cd2%'";
    }

    //������̾
    if($claim_name != null){
        $claim_name_sql  = " AND t_client_claim.client_name LIKE '%$claim_name%'";
    }

    //ô����
    if($staff != 0){
        $staff_sql = " AND t_staff.staff_id = '$staff'";
    }

    //TEL
    if($tel != null){
        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
    }
        
    //����
    if($state != 3){
        $state_sql = " AND t_client.state = '$state'";
    }

    $where_sql  = $shop_cd1_sql;
    $where_sql .= $shop_cd2_sql;
    $where_sql .= $shop_name_sql;
    $where_sql .= $rank_id_sql;
    $where_sql .= $area_sql;
    $where_sql .= $claim_cd1_sql;
    $where_sql .= $claim_cd2_sql;
    $where_sql .= $claim_name_sql;
    $where_sql .= $staff_sql;
    $where_sql .= $tel_sql;
        
    $where_sql .= $state_sql;
}

/****************************/
//�¤��ؤ�SQL����
/****************************/
//����åץ����ɤξ���Ƚ��
if($sort_col == "sl_client_cd"){
    $oder_by_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 ASC ";
//����å�̾�ξ���Ƚ��
}else if($sort_col == "sl_client_name"){
    $oder_by_sql = " ORDER BY t_client.client_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//��̾�ξ���Ƚ��
}else if($sort_col == "sl_shop_name"){
    $oder_by_sql = " ORDER BY t_client.shop_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//FC��������ʬ�ξ���Ƚ��
}else if($sort_col == "sl_rank"){
    $oder_by_sql = " ORDER BY t_rank.rank_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//�϶�ξ���Ƚ��
}else if($sort_col == "sl_area"){
    $oder_by_sql = " ORDER BY t_area.area_cd,t_client.client_cd1,t_client.client_cd2 ASC ";
//����񥳡��ɤξ���Ƚ��
}else if($sort_col == "sl_claim_cd"){
    $oder_by_sql = " ORDER BY t_client_claim.client_cd1,t_client_claim.client_cd2 ASC ";
//�����̾�ξ���Ƚ��
}else if($sort_col == "sl_claim_name"){
    $oder_by_sql = " ORDER BY t_client_claim.client_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//ô���Ԥξ���Ƚ��
}else if($sort_col == "sl_staff"){
    $oder_by_sql = " ORDER BY t_staff.staff_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//TEL�ξ���Ƚ��
}else if($sort_col == "sl_tel"){
    $oder_by_sql = " ORDER BY t_client.tel,t_client.client_cd1,t_client.client_cd2 ASC ";
//����ǯ�����ξ���Ƚ��
}else if($sort_col == "sl_day"){
    $oder_by_sql = " ORDER BY t_client.cont_sday,t_client.client_cd1,t_client.client_cd2 ASC ";
//�ǥե���Ȥϥ���åץ����ɤξ���
}else{
    $oder_by_sql = " ORDER BY t_area.area_cd,t_client.client_cd1,t_client.client_cd2 ASC ";
}

/****************************/
//ɽ���ǡ�������
/****************************/
//���������
if($output_type == 1 || $output_type == null){

    //�����ǡ���
    $fc_sql .= $where_sql.$oder_by_sql.";";
    $serch_count_sql = $fc_sql;
    $serch_res = Db_Query($conn, $serch_count_sql);
    $match_count = pg_num_rows($serch_res);
    $page_data = Get_Data($serch_res, $output_type);

    //��٥���ϥ����å��ܥå�������
    for($i = 0; $i < $match_count; $i++){
        $label_shop_id = $page_data[$i][0]; 
        $ary_shop_id[$i] = $label_shop_id;
        $form->addElement("advcheckbox", "form_label_check[$i]", null, null, null, array("null", "$label_shop_id"));
    }

}else if($output_type == 2){

    //�ǡ�����ɽ�������������
    $fc_sql .= $where_sql.$oder_by_sql.";";
    $count_res = Db_Query($conn, $fc_sql);
    $match_count = pg_num_rows($count_res);
    $page_data = Get_Data($count_res,2);

    //CSV����
    for($i = 0; $i < $match_count; $i++){
        if($page_data[$i][11] == 1){
            $page_data[$i][11] = "�����";
        }else{
            $page_data[$i][11] = "���󡦵ٻ���";
        }
        $csv_page_data[$i][0] = $page_data[$i][11];         //����
        $csv_page_data[$i][1] = $page_data[$i][6];          // �϶�
        $csv_page_data[$i][2] = $page_data[$i][14];         // ��ʬ��ȼ�̾
        $csv_page_data[$i][3] = $page_data[$i][15];         // ����̾
        $csv_page_data[$i][4] = $page_data[$i][16];         // ����̾
        $csv_page_data[$i][5] = $page_data[$i][17];         // SV
        $csv_page_data[$i][6] = $page_data[$i][18];         // ô����
        $csv_page_data[$i][7] = $page_data[$i][19];         // ô����
        $csv_page_data[$i][8] = $page_data[$i][20];         // ô����
        $csv_page_data[$i][9] = $page_data[$i][5];         // FC��������ʬ
        $csv_page_data[$i][10] = $page_data[$i][1]."-".$page_data[$i][2];        // ����åץ�����
        $csv_page_data[$i][11] = $page_data[$i][3];         // ����å�̾
        $csv_page_data[$i][12] = $page_data[$i][22];        // ����å�̾�ʥեꥬ�ʡ�
        $csv_page_data[$i][13] = $page_data[$i][23];        // ά��
        $csv_page_data[$i][14] = $page_data[$i][24];        // ά�Ρʥեꥬ�ʡ�
        $csv_page_data[$i][15] = $page_data[$i][25];        // �ɾ�
        $csv_page_data[$i][16] = $page_data[$i][4];         // ��̾
        $csv_page_data[$i][17] = $page_data[$i][26];        // ��̾�ʥեꥬ�ʡ�
        $csv_page_data[$i][18] = $page_data[$i][27];        // ��̾��
        $csv_page_data[$i][19] = $page_data[$i][28];        // ��̾���ʥեꥬ�ʡ�
        $csv_page_data[$i][20] = $page_data[$i][29]."-".$page_data[$i][30];        // ͹���ֹ�
        $csv_page_data[$i][21] = $page_data[$i][31];        // ���꣱
        $csv_page_data[$i][22] = $page_data[$i][32];        // ���ꣲ
        $csv_page_data[$i][23] = $page_data[$i][33];        // ���ꣳ
        $csv_page_data[$i][24] = $page_data[$i][34];        // ����ʥեꥬ�ʡ�
        $csv_page_data[$i][25] = $page_data[$i][12];        // Tel
        $csv_page_data[$i][26] = $page_data[$i][35];        // FAX
        $csv_page_data[$i][27] = $page_data[$i][36];        // Email
        $csv_page_data[$i][28] = $page_data[$i][37];        // URL
        $csv_page_data[$i][29] = $page_data[$i][38];        // ���ܶ�
        $csv_page_data[$i][30] = $page_data[$i][39];        // ��ɽ�Ի�̾
        $csv_page_data[$i][31] = $page_data[$i][40];        // ��ɽ����
        $csv_page_data[$i][32] = $page_data[$i][41];        // ��ɽ�Է���
        $csv_page_data[$i][33] = $page_data[$i][42];        // ľ��TEL
        $csv_page_data[$i][34] = $page_data[$i][43];        // ������
        $csv_page_data[$i][35] = $page_data[$i][44];        // �ݾڶ�
        $csv_page_data[$i][36] = $page_data[$i][45];        // �������ƥ�
        $csv_page_data[$i][37] = (($page_data[$i][46] != null )?$page_data[$i][46]."��":"").(($page_data[$i][47] != null)?$page_data[$i][47]."��":""); // �軻��
        $csv_page_data[$i][38] = $page_data[$i][48];        // ������
        $csv_page_data[$i][39] = $page_data[$i][49];        // Ϳ������
        $csv_page_data[$i][40] = $page_data[$i][50];        // ����
        $csv_page_data[$i][41] = ($page_data[$i][7]!=null)?$page_data[$i][7]."-".$page_data[$i][8]:""; // �����襳����
        $csv_page_data[$i][42] = $page_data[$i][9];         // ������̾
        $csv_page_data[$i][43] = $page_data[$i][10];        // ô����̾
        $csv_page_data[$i][44] = $page_data[$i][51]."��".$page_data[$i][52];        // ������
        $csv_page_data[$i][45] = $page_data[$i][53];        // ������ˡ
        $csv_page_data[$i][46] = $page_data[$i][54];        // ����̾��
        $csv_page_data[$i][47] = $page_data[$i][55];        // ����̾��
        $csv_page_data[$i][48] = $page_data[$i][56];        // �������
        $csv_page_data[$i][49] = $page_data[$i][57];        // ����������ʬ
        $csv_page_data[$i][50] = $page_data[$i][58]."��".$page_data[$i][59];        // ��ʧ��
        $csv_page_data[$i][51] = $page_data[$i][60];        // ��������
        $csv_page_data[$i][52] = $page_data[$i][61];        // ��������ά��
        $csv_page_data[$i][53] = $page_data[$i][62];        // ����������ʬ
        $csv_page_data[$i][54] = $page_data[$i][63];        // Ϣ��ô���Ի�̾
        $csv_page_data[$i][55] = $page_data[$i][64];        // Ϣ��ô������
        $csv_page_data[$i][56] = $page_data[$i][65];        // Ϣ��ô���Է���
        $csv_page_data[$i][57] = $page_data[$i][66];        // ���ô���Ի�̾
        $csv_page_data[$i][58] = $page_data[$i][67];        // ���ô���Է���
        $csv_page_data[$i][59] = $page_data[$i][68];        // �ݾڿͣ���̾
        $csv_page_data[$i][60] = $page_data[$i][69];        // �ݾڿͣ�����
        $csv_page_data[$i][61] = $page_data[$i][70];        // �ݾ�ͣ���̾
        $csv_page_data[$i][62] = $page_data[$i][71];        // �ݾڿͣ�����
        $csv_page_data[$i][63] = $page_data[$i][72];        // �Ķȵ���
        $csv_page_data[$i][64] = $page_data[$i][73];        // ����
        $csv_page_data[$i][65] = $page_data[$i][74];        // ����
        $csv_page_data[$i][66] = $page_data[$i][75];        // ������̾
        $csv_page_data[$i][67] = $page_data[$i][76];        // ������ɽ��̾
        $csv_page_data[$i][68] = $page_data[$i][77];        // ����ǯ����
        $csv_page_data[$i][69] = $page_data[$i][78];        // ���󹹿���
        $csv_page_data[$i][70] = $page_data[$i][80];        // �������
        $csv_page_data[$i][71] = $page_data[$i][79];        // ����λ��
        $csv_page_data[$i][72] = $page_data[$i][81];        // �϶���
        $csv_page_data[$i][73] = $page_data[$i][82];        // ˡ���е���
        $csv_page_data[$i][74] = $page_data[$i][83];        // ��ɼȯ��
        $csv_page_data[$i][75] = $page_data[$i][84];        // Ǽ�ʽ񥳥��ȡʸ��̡�
        $csv_page_data[$i][76] = $page_data[$i][85];        // Ǽ�ʽ񥳥���
        $csv_page_data[$i][77] = $page_data[$i][86];        // �����ȯ��
        $csv_page_data[$i][78] = $page_data[$i][87];        // ���������
        $csv_page_data[$i][79] = $page_data[$i][88];        // ������ͼ�
        $csv_page_data[$i][80] = $page_data[$i][89];        // ���:�ݤ��ʬ
        $csv_page_data[$i][81] = $page_data[$i][90];        // ������:����ñ��
        $csv_page_data[$i][82] = $page_data[$i][91];        // ������:ü����ʬ
        $csv_page_data[$i][83] = $page_data[$i][92];        // ������:���Ƕ�ʬ
        $csv_page_data[$i][84] = $page_data[$i][93];        // ������ʡ�����ʬ��
        $csv_page_data[$i][85] = $page_data[$i][94];        // ����
        $csv_page_data[$i][86] = $page_data[$i][97];        // �������
        $csv_page_data[$i][87] = $page_data[$i][95];        // ���׻���
        $csv_page_data[$i][88] = $page_data[$i][96];        // ����¾

        #2010-05-01 hashimoto-y
        $csv_page_data[$i][89] = $page_data[$i][98];        // �������

    }

    $csv_file_name = "FC�������ޥ���".date("Ymd").".csv";
    $csv_header = array(
            "����",
            "�϶�",
            "�ȼ�",
            "����",
            "����",
            "SV",
            "ô����",
            "ô����",
            "ô����",
            "FC��������ʬ",
            "����åץ�����",
            "����å�̾",
            "����å�̾�ʥեꥬ�ʡ�",
            "ά��",
            "ά�Ρʥեꥬ�ʡ�",
            "�ɾ�",
            "��̾��",
            "��̾���ʥեꥬ�ʡ�",
            "��̾��",
            "��̾���ʥեꥬ�ʡ�",
            "͹���ֹ�",
            "���꣱",
            "���ꣲ",
            "���ꣳ",
            "���ꣲ�ʥեꥬ�ʡ�",
            "Tel",
            "FAX",
            "Email",
            "URL",
            "���ܶ�",
            "��ɽ�Ի�̾",
            "��ɽ����",
            "��ɽ�Է���",
            "ľ��TEL",
            "������",
            "�ݾڶ�",
            "�������ƥ�",
            "�軻��",
            "������",
            "Ϳ������",
            "����",
            "�����襳����",
            "������̾",
            "ô����̾",
            "������",
            "������ˡ",
            "����̾��",
            "����̾��",
            "�������",
            "����������ʬ",
            "��ʧ��",
            "��������",
            "��������ά��",
            "����������ʬ",
            "Ϣ��ô���Ի�̾",
            "Ϣ��ô������",
            "Ϣ��ô���Է���",
            "���ô���Ի�̾",
            "���ô���Է���",
            "�ݾڿͣ���̾",
            "�ݾڿͣ�����",
            "�ݾڿͣ���̾",
            "�ݾڿͣ�����",
            "�Ķȵ���",
            "����",
            "����",
            "������̾",
            "������ɽ��̾",
            "����ǯ����",
            "���󹹿���",
            "�������",
            "����λ��",
            "�϶���",
            "ˡ���е���",
            "��ɼȯ��",
            "Ǽ�ʽ񥳥��ȡʸ��̡�",
            "Ǽ�ʽ񥳥���",
            "�����ȯ��",
            "���������",
            "������ͼ�",
            "���:�ݤ��ʬ",
            "������:����ñ��",
            "������:ü����ʬ",
            "������:���Ƕ�ʬ",
            "������ʡ�����ʬ��",
            "����",
            "�������",
            "���׻���",
            "����¾",
            "�������",
          );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/*
//����åװ���ALL�����å���
$form->addElement('checkbox', 'form_shop_all', '�����å��ܥå���', '����åװ�',"onClick=\"javascript:All_check('form_shop_all','form_shop_check',$dealing_count)\"");

//��ɽ�԰���ALL�����å���
$form->addElement('checkbox', 'form_staff_all', '�����å��ܥå���', '��ɽ�԰�',"onClick=\"javascript:All_check('form_staff_all','form_staff_check',$dealing_count)\"");

//��Ͽ�����ɡ�ALL�����å���
$form->addElement('checkbox', 'form_input_all', '�����å��ܥå���', '��Ͽ������',"onClick=\"javascript:All_check('form_input_all','form_input_check',$dealing_count)\"");

//�����å��ܥå�������
for($i = 0; $i < $match_count; $i++){
    //����åװ�
    $form->addElement("checkbox", "form_shop_check[$i]");

    //ô���԰�
    $form->addElement("checkbox", "form_staff_check[$i]");

}
*/

//��٥����
$javascript  = Create_Allcheck_Js ("All_Label_Check","form_label_check",$ary_shop_id);



#2010-05-13 hashimoto-y
$display_flg = true;
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
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(�����".$dealing_count."��/��".$total_count."��)";
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
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'match_count'   => "$match_count",
    'order_msg'     => "$order_msg",
    'javascript'    => "$javascript",
    'display_flg'    => "$display_flg",
));

$smarty->assign('row',$page_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>