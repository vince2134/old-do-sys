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

//�Ķ�����ե����� env setting file
require_once("ENV_local.php");

//HTML_QuickForm����� create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// �ƥ�ץ졼�ȴؿ���쥸���� register the template function 
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DB����³ connect
$conn = Db_Connect();

// ���¥����å� auth check
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å����� no input/edit auth message
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;

/****************************/
//�����ѿ����� acquire external variable
/****************************/
$shop_id  = $_SESSION[shop_id];
//$shop_gid = $_SESSION[shop_gid];
//$shop_aid = $_SESSION[shop_aid];

/****************************/
//�ե��������� create form
/****************************/
$def_fdata = array(
    "form_output_type"  => "1",
    "form_state_type"   => "1"
);
$form->setDefaults($def_fdata);


// ���Ϸ���output format
$radio1[] =& $form->createElement( "radio", null, null, "����", "1");
$radio1[] =& $form->createElement( "radio", null, null, "CSV", "2");
$form->addGroup($radio1, "form_output_type", "���Ϸ���");

// ���� status 
$radio2[] =& $form->createElement( "radio", null, null, "�����", "1");
$radio2[] =& $form->createElement( "radio", null, null, "���󡦵ٻ���", "2");
$radio2[] =& $form->createElement( "radio", null, null, "����", "3");
$form->addGroup($radio2, "form_state_type", "����");

// �����å��ܥå��� checkbox
$form->addElement("checkbox", "f_check", "�����å��ܥå���", "");

// TEL
$form->addElement("text", "form_tel", "", "size=\"15\" maxLength=\"13\" style=\"$g_form_style\"  $g_form_option");

// ����åץ����� shop code
$text1[] =& $form->createElement("text", "cd1", "����åץ����ɣ�", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onKeyup=\"changeText(this.form,'form_shop_cd[cd1]','form_shop_cd[cd2]',6);\" $g_form_option");
$text1[] =& $form->createElement("static","","","-");
$text1[] =& $form->createElement("text", "cd2", "����åץ����ɣ�", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text1, "form_shop_cd", "����åץ�����");

// ����å�̾����̾ shop name/ company name
$form->addElement("text", "form_shop_name", "����å�̾����̾", "size=\"34\" maxLength=\"15\""." $g_form_option");

// �����襳���� billing client code
$text2[] =& $form->createElement("text", "cd1", "�����襳���ɣ�", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_claim_cd[cd1]','form_claim_cd[cd2]',6);\" $g_form_option");
$text2[] =& $form->createElement("static", "", "", "-");
$text2[] =& $form->createElement("text", "cd2", "�����襳���ɣ�", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text2, "form_claim_cd", "form_claim_cd");

// ������̾ billing address naem
$form->addElement("text", "form_claim_name", "������̾", "size=\"34\" maxLength=\"15\""." $g_form_option");

// FC��������ʬ FC/trade classification
$select_value = Select_Get($conn, "rank");
$form->addElement("select", "form_rank_1", "FC��������ʬ", $select_value, $g_form_option_select);
 
// �϶� district
$select_value = Select_Get($conn, "area");
$form->addElement("select", "form_area_1", "�϶�", $select_value, $g_form_option_select);

// ô���� staff
$select_value = Select_Get($conn, "staff");
$form->addElement("select", "form_staff_1", "ô����", $select_value, $g_form_option_select);

// �����ȥ�� sort link
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

//ɽ���ܥ��� display button
$button[] = $form->createElement("submit","show_button","ɽ����");

//���ꥢ�ܥ��� clear button
$button[] = $form->createElement("button","clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//���� saerch
$form->addElement("submit","form_search_button","�����ե������ɽ��","");

//��Ͽ register
$form->addElement("button","new_button","��Ͽ����","onClick=\"javascript:Referer('1-1-103.php')\"");

//�ѹ������� edit/list
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
$form->addElement("hidden", "hdn_search_flg");        //�����ե�����ɽ���ե饰 search form display flag

//������ﵭ���� to remember the search condition
$form->addElement("hidden", "hdn_output_type");   //���Ϸ��� output format
$form->addElement("hidden", "hdn_state_type");    //���� status
$form->addElement("hidden", "hdn_shop_cd1");      //����åץ����ɣ� shop code 1
$form->addElement("hidden", "hdn_shop_cd2");      //����åץ����ɣ� shop code 2
$form->addElement("hidden", "hdn_shop_name");     //����å�̾ shop name
$form->addElement("hidden", "hdn_rank");          //FC��������ʬ FC/trade classification
$form->addElement("hidden", "hdn_area");          //�϶� district
$form->addElement("hidden", "hdn_claim_cd1");     //�����襳���ɣ� billing code 1
$form->addElement("hidden", "hdn_claim_cd2");     //�����襳���ɣ� billing code 2
$form->addElement("hidden", "hdn_claim_name");    //������̾ billing name
$form->addElement("hidden", "hdn_staff");         //ô���� staff
$form->addElement("hidden", "hdn_tel");



#2010-05-13 hashimoto-y
if($_POST["form_button"]["show_button"] == "ɽ����"){



/****************************/
//��������� acquire all items
/****************************/
$fc_sql  = " SELECT ";
$fc_sql .= "     t_client.client_id,";                      // 0 ������ID customer ID
$fc_sql .= "     t_client.client_cd1,";                     // 1 �����襳���ɣ� custoemr code 1
$fc_sql .= "     t_client.client_cd2,";                     // 2 �����襳���ɣ� custoemr code 2
$fc_sql .= "     t_client.client_name,";                    // 3 ������̾ customer name
$fc_sql .= "     t_client.shop_name,";                      // 4 ��̾ company name 
$fc_sql .= "     t_rank.rank_name,";                        // 5 FC��������ʬ FC/trade classification
$fc_sql .= "     t_area.area_name,";                        // 6 �϶� district
$fc_sql .= "     t_client_claim.client_cd1,";               // 7 �����襳���ɣ� billing code 1
$fc_sql .= "     t_client_claim.client_cd2,";               // 8 �����襳���ɣ� billing code 2
$fc_sql .= "     t_client_claim.shop_name,";                // 9 ������̾ billing name
$fc_sql .= "     t_staff.staff_name,";                      // 10 ô����̾ staff name
$fc_sql .= "     t_client.state,";                          // 11 ���� status
$fc_sql .= "     t_client.tel,";                            // 12 Tel
$fc_sql .= "     t_client.cont_sday";                       // 13 ����ǯ���� contract date
//csv������ for csv output
if($_POST["form_button"]["show_button"] == "ɽ����"){$output_type    = $_POST["form_output_type"];}
if($output_type == 2){
$fc_sql .= "    ,";
$fc_sql .= "    t_sbtype.sbtype_name,";                     // 14 ��ʬ��ȼ�̾ small business type name
$fc_sql .= "    t_inst.inst_name,";                         // 15 ����̾ facility name
$fc_sql .= "    t_bstruct.bstruct_name, ";                  // 16 ����̾ business type name
$fc_sql .= "    t_staff_sv.staff_name, ";                   // 17 SV
$fc_sql .= "    t_staff_1.staff_name, ";                    // 18 ô���� staff
$fc_sql .= "    t_staff_2.staff_name, ";                    // 19 ô���� staff
$fc_sql .= "    t_staff_3.staff_name, ";                    // 20 ô���� staff
$fc_sql .= "    t_staff_4.staff_name, ";                    // 21 ô���� staff
$fc_sql .= "    t_client.client_read, ";                    // 22 ������̾�ʥեꥬ�ʡ� customer name (katkaan)
$fc_sql .= "    t_client.client_cname,";                    // 23 ά�� abbreviation
$fc_sql .= "    t_client.client_cread, ";                   // 24 ά�Ρʥեꥬ�ʡ� abbreviation (katkana) 
$fc_sql .= "    CASE t_client.compellation ";               // 25 �ɾ� compellation
$fc_sql .= "        WHEN '1' THEN '����' ";
$fc_sql .= "        WHEN '2' THEN '��' ";
$fc_sql .= "    END AS compellation, ";
$fc_sql .= "    t_client.shop_read, ";                      // 26 ��̾�ʥեꥬ�ʡ� company name (katakanaa)
$fc_sql .= "    t_client.shop_name2, ";                     // 27 ��̾�� company name 2
$fc_sql .= "    t_client.shop_read2, ";                     // 28 ��̾���ʥեꥬ�ʡ� company name 2 (katakana)
$fc_sql .= "    t_client.post_no1, ";                       // 29 ͹���ֹ棱 postal code 1
$fc_sql .= "    t_client.post_no2, ";                       // 30 ͹���ֹ棲 postal code 2
$fc_sql .= "    t_client.address1, ";                       // 31 ���꣱ address
$fc_sql .= "    t_client.address2, ";                       // 32 ���ꣲ address
$fc_sql .= "    t_client.address3, ";                       // 33 ���ꣳ address
$fc_sql .= "    t_client.address_read, ";                   // 34 ����ʥեꥬ�ʡ� address (katakana)
$fc_sql .= "    t_client.fax, ";                            // 35 FAX
$fc_sql .= "    t_client.email, ";                          // 36 Email
$fc_sql .= "    t_client.url, ";                            // 37 URL
$fc_sql .= "    t_client.capital, ";                        // 38 ���ܶ� capital
$fc_sql .= "    t_client.rep_name, ";                       // 39 ��ɽ�Ի�̾ name of the representative
$fc_sql .= "    t_client.represe, ";                        // 40 ��ɽ���� position of the rep
$fc_sql .= "    t_client.rep_htel, ";                       // 41 ��ɽ�Է��� TEL of the rep
$fc_sql .= "    t_client.direct_tel, ";                     // 42 ľ��TEL direct TEL
$fc_sql .= "    t_client.join_money, ";                     // 43 ������ joining fee
$fc_sql .= "    t_client.guarant_money, ";                  // 44 �ݾڶ�  security deposit
$fc_sql .= "    t_client.royalty_rate, ";                   // 45 �����ƥ� royalty
$fc_sql .= "    t_client.cutoff_month, ";                   // 46 �軻���ʷ��cutoff date (month)
$fc_sql .= "    t_client.cutoff_day, ";                     // 47 �軻�������� cutoff date (day)
$fc_sql .= "    t_client.col_terms, ";                      // 48 ������ collection condition
$fc_sql .= "    t_client.credit_limit, ";                   // 49 Ϳ������credit limit
$fc_sql .= "    CASE t_client.close_day ";                  // 50 ���� close day
$fc_sql .= "        WHEN '29' THEN '����' ";
$fc_sql .= "        ELSE t_client.close_day || '��' ";
$fc_sql .= "    END AS close_day, ";
$fc_sql .= "    CASE t_client.pay_m ";                      // 51 �������ʷ�� collection date (month)
$fc_sql .= "        WHEN '0' THEN '����' ";
$fc_sql .= "        WHEN '1' THEN '���' ";
$fc_sql .= "        ELSE t_client.pay_m || '�����'";
$fc_sql .= "    END AS pay_m, ";
$fc_sql .= "    CASE t_client.pay_d ";                      // 52 ������������ collection date (day)
$fc_sql .= "        WHEN '29' THEN '����' ";
$fc_sql .= "        ELSE t_client.pay_d || '��' ";
$fc_sql .= "    END AS pay_d, ";
$fc_sql .= "    CASE t_client.pay_way ";                    // 53 ������ˡ collection method
$fc_sql .= "        WHEN '1' THEN '��ư����' ";
$fc_sql .= "        WHEN '2' THEN '����' ";
$fc_sql .= "        WHEN '3' THEN 'ˬ�佸��' ";
$fc_sql .= "        WHEN '4' THEN '���' ";
$fc_sql .= "        WHEN '5' THEN '����¾' ";
$fc_sql .= "    END AS pay_way, ";
$fc_sql .= "    t_client.pay_name, ";                       // 54 ����̾�� deposit name
$fc_sql .= "    t_client.account_name, ";                   // 55 ����̾�� account name
$fc_sql .= "    CASE WHEN t_client.account_id IS NOT NULL ";// 56 ������� deposit bank
$fc_sql .= "        THEN t_bank.bank_name || ' ' || t_b_bank.b_bank_name || ' ' ||CASE t_account.deposit_kind  WHEN '1' THEN '���� 'WHEN '2' THEN '���� ' END || t_account.account_no ";
$fc_sql .= "    END AS pay_bank, ";
$fc_sql .= "    t_trade.trade_name, ";                      // 57 ����������ʬ customer trade classification
$fc_sql .= "    CASE t_client.payout_m ";                   // 58 ��ʧ���ʷ�� payment date (motnh)
$fc_sql .= "        WHEN '0' THEN '����' ";
$fc_sql .= "        WHEN '1' THEN '���' ";
$fc_sql .= "        ELSE t_client.payout_m || '�����' ";
$fc_sql .= "    END AS payout_m, ";
$fc_sql .= "    CASE t_client.payout_d";                    // 59 ��ʧ�������� payment date (day)
$fc_sql .= "        WHEN '29' THEN '����' ";
$fc_sql .= "        ELSE t_client.payout_d || '��' ";
$fc_sql .= "    END AS payout_d, ";
$fc_sql .= "    t_client.bank_name, ";                      // 60 �������� deposit account 
$fc_sql .= "    t_client.b_bank_name, ";                    // 61 ��������ά�� deposit account abbreviation
$fc_sql .= "    t_buy_trade.trade_name, ";                  // 62 ����������ʬ supplier trade classifcaiton
$fc_sql .= "    t_client.charger_name, ";                   // 63 Ϣ��ô���Ի�̾ contact in person name
$fc_sql .= "    t_client.charger, ";                        // 64 Ϣ��ô������ contact in person position
$fc_sql .= "    t_client.cha_htel, ";                       // 65 Ϣ��ô���Է��� contact in person tel
$fc_sql .= "    t_client.accountant_name, ";                // 66 ���ô���Ի�̾ accounting reprsentative name
$fc_sql .= "    t_client.account_tel, ";                    // 67 ���ô���Է��� accounting reprsentative tel
$fc_sql .= "    t_client.surety_name1, ";                   // 68 �ݾڿͣ���̾ guarantor1 name
$fc_sql .= "    t_client.surety_addr1, ";                   // 69 �ݾڿͣ����� guarantor1 address
$fc_sql .= "    t_client.surety_name2, ";                   // 70 �ݾ�ͣ���̾ guarantor2 name
$fc_sql .= "    t_client.surety_addr2, ";                   // 71 �ݾڿͣ����� guarantor2 address
$fc_sql .= "    t_client.trade_base, ";                     // 72 �Ķȵ��� base where sale is conduct
$fc_sql .= "    t_client.holiday, ";                        // 73 ����  holiday
$fc_sql .= "    t_client.trade_area, ";                     // 74 ���� trade area
$fc_sql .= "    t_client.c_compa_name, ";                   // 75 ������̾ contracted company name
$fc_sql .= "    t_client.c_compa_rep, ";                    // 76 ������ɽ��̾ contracted representati
$fc_sql .= "    t_client.cont_sday, ";                      // 77 ����ǯ���� contract start date
$fc_sql .= "    t_client.cont_rday, ";                      // 78 ���󹹿��� contract update date
$fc_sql .= "    t_client.cont_eday, ";                      // 79 ����λ�� contract end day
$fc_sql .= "    t_client.cont_peri, ";                      // 80 ������� contract period
$fc_sql .= "    t_client.establish_day, ";                  // 81 �϶���  establishment date
$fc_sql .= "    t_client.regist_day, ";                     // 82 ˡ���е��� register date
$fc_sql .= "    CASE t_client.slip_out ";                   // 83 ��ɼȯ�� issue slip
$fc_sql .= "        WHEN '1' THEN 'ͭ' ";
$fc_sql .= "        WHEN '2' THEN '����' ";
$fc_sql .= "        WHEN '3' THEN '̵' ";
$fc_sql .= "    END AS slip_out, ";
$fc_sql .= "    CASE t_client.deliver_effect ";             // 84 Ǽ�ʽ񥳥��ȡʸ��̡� delivery note comment (effect)
$fc_sql .= "        WHEN '1' THEN '������ͭ��' ";
$fc_sql .= "        WHEN '2' THEN '���̥�����ͭ��' ";
$fc_sql .= "        WHEN '3' THEN '���Υ�����ͭ��' ";
$fc_sql .= "    END AS deliver_effect, ";
$fc_sql .= "    t_client.deliver_note, ";                   // 85 Ǽ�ʽ񥳥��� delivery note comment
$fc_sql .= "    CASE t_client.claim_out ";                  // 86 �����ȯ�� issue billing statement
$fc_sql .= "        WHEN '1' THEN '���������' ";
$fc_sql .= "        WHEN '2' THEN '��������' ";
$fc_sql .= "        WHEN '3' THEN '���Ϥ��ʤ�' ";
$fc_sql .= "        WHEN '4' THEN '����' ";
$fc_sql .= "    END AS claim_out, ";
$fc_sql .= "    CASE t_client.claim_send ";                 // 87 ���������  billing statement send
$fc_sql .= "        WHEN '1' THEN '͹��' ";
$fc_sql .= "        WHEN '2' THEN '�᡼��' ";
$fc_sql .= "        WHEN '3' THEN 'ξ��' ";
$fc_sql .= "    END AS claim_send, ";
$fc_sql .= "    t_claim_sheet.c_pattern_name, ";            // 88 ������ͼ� billing statement format
$fc_sql .= "    CASE t_client.coax ";                       // 89 ��۴ݤ��ʬ amount round up/down
$fc_sql .= "        WHEN '1' THEN '�ڼ�' ";
$fc_sql .= "        WHEN '2' THEN '�ͼθ���' ";
$fc_sql .= "        WHEN '3' THEN '�ھ�' ";
$fc_sql .= "    END AS coax, ";
$fc_sql .= "    CASE t_client.tax_div ";                    // 90 ������:����ñ�� tax: tax unit 
$fc_sql .= "        WHEN '1' THEN '����ñ��' ";
$fc_sql .= "        WHEN '2' THEN '��ɼñ��' ";
$fc_sql .= "    END AS tax_div, ";
$fc_sql .= "    CASE t_client.tax_franct ";                 // 91 ������:ü����ʬ tax: round up/down
$fc_sql .= "        WHEN '1' THEN '�ڼ�' ";
$fc_sql .= "        WHEN '2' THEN '�ͼθ���' ";
$fc_sql .= "        WHEN '3' THEN '�ھ�' ";
$fc_sql .= "    END AS tax_franct, ";
$fc_sql .= "    CASE t_client.c_tax_div ";                  // 92 ������:���Ƕ�ʬ tax: tax classification
$fc_sql .= "        WHEN '1' THEN '����' ";
$fc_sql .= "        WHEN '2' THEN '����' ";
#2010-01-29 hashimoto-y
$fc_sql .= "        WHEN '3' THEN '�����' ";
$fc_sql .= "    END AS c_tax_div, ";
$fc_sql .= "    t_client.license, ";                        // 93 ������ʡ�����ʬ��  acquired license/field of expertise
$fc_sql .= "    t_client.s_contract, ";                     // 94 ���� special clause
$fc_sql .= "    t_client.importance, ";                     // 95 ���׻��� important items
$fc_sql .= "    t_client.other, ";                          // 96 ����¾ others
$fc_sql .= "    t_client.deal_history, ";                    // 97 ������� trade history

#2010-05-01 hashimoto-y
$fc_sql .= "   CASE t_client.bill_address_font \n";         // 98 ������� billing address font
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
//csv������ csv for output
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
//���̥إå������� create screen header
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
//�إå�����ɽ������������ǡ������ number of transacting data that will be displayed in header
$result = Db_Query($conn, $count_sql);
$dealing_count = pg_fetch_result($result,0,0);

$count_sql  = " SELECT ";
$count_sql .= "     COUNT(client_cd1)";
$count_sql .= " FROM";
$count_sql .= "    t_client ";
$count_sql .= " WHERE";
$count_sql .= "    client_div = '3'";
$count_sql .= ";";
//�إå�����ɽ������������� all items that will be displayed in header
$result = Db_Query($conn, $count_sql);
$total_count = pg_fetch_result($result,0,0);

/****************************/
//�����ե������ɽ���ܥ��󲡲����� display button pressed process the saerch form 
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
//ɽ���ܥ��󲡲����� process when the display button is pressed
/****************************/
if($_POST["form_button"]["show_button"] == "ɽ����"){
    $output_type    = $_POST["form_output_type"];          //���Ϸ��� output format
    $state          = $_POST["form_state_type"];           //���� status
    $shop_cd1       = trim($_POST["form_shop_cd"]["cd1"]); //����åץ�����1 shop code 1
    $shop_cd2       = trim($_POST["form_shop_cd"]["cd2"]); //����åץ�����2 sop code 2
    $shop_name      = $_POST["form_shop_name"];            //����å�̾/��̾ shop name/company name
    $rank           = $_POST["form_rank_1"];               //FC��������ʬ fc/trade partner classification
    $area           = $_POST["form_area_1"];               //�϶� district
    $claim_cd1      = trim($_POST["form_claim_cd"]["cd1"]);//�����襳����1 billing address code 1
    $claim_cd2      = trim($_POST["form_claim_cd"]["cd2"]);//�����襳����2 billing address code 2
    $claim_name     = $_POST["form_claim_name"];           //������̾ billing name
    $staff          = $_POST["form_staff_1"];              //ô���� staff
    $tel            = $_POST["form_tel"];                  //TEL
    $post_flg       = true;                                //POST�ե饰 post flag

    $sort_col = $_POST["hdn_sort_col"];

/*****************************/
//������󥯤��������줿��� if the column link is pressed
/*****************************/
}elseif(count($_POST) > 0
    && $_POST["form_button"]["show_button"] != "ɽ����"
    && $_POST["form_search_button"] != "�����ե������ɽ��"){

    $output_type    = $_POST["hdn_output_type"];            //���Ϸ��� ouput format
    $state          = $_POST["hdn_state_type"];             //���� status
    $shop_cd1       = $_POST["hdn_shop_cd1"];               //����åץ����ɣ�  shop code 1
    $shop_cd2       = $_POST["hdn_shop_cd2"];               //����åץ����ɣ� shop code 2
    $shop_name      = $_POST["hdn_shop_name"];              //����å�̾/��̾ shop name/company name
    $rank           = $_POST["hdn_rank"];                   //FC��������ʬ fc/trade classification 
    $area           = $_POST["hdn_area"];                   //�϶�district
    $claim_cd1      = $_POST["hdn_claim_cd1"];              //�����襳���ɣ� billin gcode 1
    $claim_cd2      = $_POST["hdn_claim_cd2"];              //�����襳���ɣ� billing code 2
    $claim_name     = $_POST["hdn_claim_name"];             //������̾ billing name
    $staff          = $_POST["hdn_staff"];                  //ô���� staff
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
    //�����ǡ����򥻥å� set saerch data
    /****************************/
    $set_data["form_output_type"]       = stripslashes($output_type);     //���Ϸ��� output format
    $set_data["form_state_type"]        = stripslashes($state);           //���� status
    $set_data["form_shop_cd"]["cd1"]    = stripslashes($shop_cd1);        //����åץ����ɣ� shop code 1
    $set_data["form_shop_cd"]["cd2"]    = stripslashes($shop_cd2);        //����åץ����ɣ� shop code 2
    $set_data["form_shop_name"]         = stripslashes($shop_name);       //����å�̾/��̾ shop name/company nmae
    $set_data["form_rank_1"]            = stripslashes($rank);            //FC��������ʬ fc/trade classification
    $set_data["form_area_1"]            = stripslashes($area);            //�϶� district
    $set_data["form_claim_cd"]["cd1"]   = stripslashes($claim_cd1);       //�����襳���ɣ� billing code 1
    $set_data["form_claim_cd"]["cd2"]   = stripslashes($claim_cd2);       //�����襳���ɣ� billing code 2
    $set_data["form_claim_name"]        = stripslashes($claim_name);      //������̾ billing name
    $set_data["form_staff_1"]           = stripslashes($staff);           //ô���� staff
    $set_data["form_tel"]               = stripslashes($tel);             //TEL

    $set_data["hdn_output_type"]        = stripslashes($output_type);     //���Ϸ��� ouput format
    $set_data["hdn_state_type"]         = stripslashes($state);      //���� status
    $set_data["hdn_shop_cd1"]           = stripslashes($shop_cd1);        //����åץ����ɣ� shop code 1
    $set_data["hdn_shop_cd2"]           = stripslashes($shop_cd2);        //����åץ����ɣ� shop code 2
    $set_data["hdn_shop_name"]          = stripslashes($shop_name);       //����å�̾/��̾  shop name/company nmae
    $set_data["hdn_rank"]               = stripslashes($rank);            //FC��������ʬ  fc/trade classification
    $set_data["hdn_area"]               = stripslashes($area);            //�϶� district
    $set_data["hdn_claim_cd1"]          = stripslashes($claim_cd1);       //�����襳���ɣ� billing code 1
    $set_data["hdn_claim_cd2"]          = stripslashes($claim_cd2);       //�����襳���ɣ� billing code 2
    $set_data["hdn_claim_name"]         = stripslashes($claim_name);      //������̾ billing name
    $set_data["hdn_staff"]              = stripslashes($staff);           //ô����staff
    $set_data["hdn_tel"]                = stripslashes($tel);             //TEL

    $form->setConstants($set_data);
        
    /****************************/
    //where_sql���� create
    /****************************/
    //����åץ�����1 shop code 1
    if($shop_cd1 != null){
        $shop_cd1_sql  = " AND t_client.client_cd1 LIKE '$shop_cd1%'";
    }

    //����åץ�����2 shop code 2
    if($shop_cd2 != null){
        $shop_cd2_sql  = " AND t_client.client_cd2 LIKE '$shop_cd2%'";
    }

    //����å�̾ shop name
    if($shop_name != null){
        $shop_name_sql  = " AND (t_client.client_name LIKE '%$shop_name%' 
                            OR t_client.shop_name LIKE '%$shop_name%' 
                            OR t_client.client_read LIKE '%$shop_name%' 
                            OR t_client.client_read2 LIKE '%$shop_name%' 
                            OR t_client.client_cread LIKE '%$shop_name%' 
                            OR t_client.client_cname LIKE '%$shop_name%')";
    }

    //FC��������ʬ FC/ trade classifciation
    if($rank != 0){
        $rank_id_sql = " AND t_rank.rank_cd = '$rank'";
    }

    //�϶� district
    if($area != 0){
        $area_sql = " AND t_area.area_id = '$area'";
    }

    //�����襳����1 billingh code 1
    if($claim_cd1 != null){
        $claim_cd1_sql  = " AND t_client_claim.client_cd1 LIKE '$claim_cd1%'";
    }

    //�����襳����2 billingh code 2
    if($claim_cd2 != null){
        $claim_cd2_sql  = " AND t_client_claim.client_cd2 LIKE '$claim_cd2%'";
    }

    //������̾ billing name
    if($claim_name != null){
        $claim_name_sql  = " AND t_client_claim.client_name LIKE '%$claim_name%'";
    }

    //ô���� staff
    if($staff != 0){
        $staff_sql = " AND t_staff.staff_id = '$staff'";
    }

    //TEL
    if($tel != null){
        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
    }
        
    //���� status 
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
//�¤��ؤ�SQL���� create change order SQL
/****************************/
//����åץ����ɤξ���Ƚ�� determine the order of shopcode 
if($sort_col == "sl_client_cd"){
    $oder_by_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 ASC ";
//����å�̾�ξ���Ƚ�� determine the order of shop name
}else if($sort_col == "sl_client_name"){
    $oder_by_sql = " ORDER BY t_client.client_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//��̾�ξ���Ƚ��determine the order of company name
}else if($sort_col == "sl_shop_name"){
    $oder_by_sql = " ORDER BY t_client.shop_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//FC��������ʬ�ξ���Ƚ�� determine the order of fc trade classification
}else if($sort_col == "sl_rank"){
    $oder_by_sql = " ORDER BY t_rank.rank_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//�϶�ξ���Ƚ�� determine the order of district
}else if($sort_col == "sl_area"){
    $oder_by_sql = " ORDER BY t_area.area_cd,t_client.client_cd1,t_client.client_cd2 ASC ";
//����񥳡��ɤξ���Ƚ�� determine the order of biling statement
}else if($sort_col == "sl_claim_cd"){
    $oder_by_sql = " ORDER BY t_client_claim.client_cd1,t_client_claim.client_cd2 ASC ";
//�����̾�ξ���Ƚ�� determine the order of billing statement name
}else if($sort_col == "sl_claim_name"){
    $oder_by_sql = " ORDER BY t_client_claim.client_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//ô���Ԥξ���Ƚ�� determine the order of staff
}else if($sort_col == "sl_staff"){
    $oder_by_sql = " ORDER BY t_staff.staff_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//TEL�ξ���Ƚ�� determine the order of tel
}else if($sort_col == "sl_tel"){
    $oder_by_sql = " ORDER BY t_client.tel,t_client.client_cd1,t_client.client_cd2 ASC ";
//����ǯ�����ξ���Ƚ�� determine the order of contract start date
}else if($sort_col == "sl_day"){
    $oder_by_sql = " ORDER BY t_client.cont_sday,t_client.client_cd1,t_client.client_cd2 ASC ";
//�ǥե���Ȥϥ���åץ����ɤξ��� default is the order of the shop code
}else{
    $oder_by_sql = " ORDER BY t_area.area_cd,t_client.client_cd1,t_client.client_cd2 ASC ";
}

/****************************/
//ɽ���ǡ������� create display date
/****************************/
//��������� select screen
if($output_type == 1 || $output_type == null){

    //�����ǡ��� corresponding date
    $fc_sql .= $where_sql.$oder_by_sql.";";
    $serch_count_sql = $fc_sql;
    $serch_res = Db_Query($conn, $serch_count_sql);
    $match_count = pg_num_rows($serch_res);
    $page_data = Get_Data($serch_res, $output_type);

    //��٥���ϥ����å��ܥå������� craete label output checkbox
    for($i = 0; $i < $match_count; $i++){
        $label_shop_id = $page_data[$i][0]; 
        $ary_shop_id[$i] = $label_shop_id;
        $form->addElement("advcheckbox", "form_label_check[$i]", null, null, null, array("null", "$label_shop_id"));
    }

}else if($output_type == 2){

    //�ǡ�����ɽ������������� all items that will be displayed in data
    $fc_sql .= $where_sql.$oder_by_sql.";";
    $count_res = Db_Query($conn, $fc_sql);
    $match_count = pg_num_rows($count_res);
    $page_data = Get_Data($count_res,2);

    //CSV���� create csv
    for($i = 0; $i < $match_count; $i++){
        if($page_data[$i][11] == 1){
            $page_data[$i][11] = "�����";
        }else{
            $page_data[$i][11] = "���󡦵ٻ���";
        }
        $csv_page_data[$i][0] = $page_data[$i][11];         //���� status 
        $csv_page_data[$i][1] = $page_data[$i][6];          // �϶� district
        $csv_page_data[$i][2] = $page_data[$i][14];         // ��ʬ��ȼ�̾ small business type name
        $csv_page_data[$i][3] = $page_data[$i][15];         // ����̾ facility 
        $csv_page_data[$i][4] = $page_data[$i][16];         // ����̾ business type 
        $csv_page_data[$i][5] = $page_data[$i][17];         // SV
        $csv_page_data[$i][6] = $page_data[$i][18];         // ô���� staff 1
        $csv_page_data[$i][7] = $page_data[$i][19];         // ô����  staff 2
        $csv_page_data[$i][8] = $page_data[$i][20];         // ô���� staff 3
        $csv_page_data[$i][9] = $page_data[$i][5];         // FC��������ʬ fc trade classification
        $csv_page_data[$i][10] = $page_data[$i][1]."-".$page_data[$i][2];        // ����åץ����� shop code
        $csv_page_data[$i][11] = $page_data[$i][3];         // ����å�̾ shop name 
        $csv_page_data[$i][12] = $page_data[$i][22];        // ����å�̾�ʥեꥬ�ʡ� shop name (katakana)
        $csv_page_data[$i][13] = $page_data[$i][23];        // ά�� abbreviation 
        $csv_page_data[$i][14] = $page_data[$i][24];        // ά�Ρʥեꥬ�ʡ� abbreviation (katakana)
        $csv_page_data[$i][15] = $page_data[$i][25];        // �ɾ� compellation 
        $csv_page_data[$i][16] = $page_data[$i][4];         // ��̾ company name
        $csv_page_data[$i][17] = $page_data[$i][26];        // ��̾�ʥեꥬ�ʡ�  company name (katakana)
        $csv_page_data[$i][18] = $page_data[$i][27];        // ��̾�� company name2
        $csv_page_data[$i][19] = $page_data[$i][28];        // ��̾���ʥեꥬ�ʡ� company name2 (katakana)
        $csv_page_data[$i][20] = $page_data[$i][29]."-".$page_data[$i][30];        // ͹���ֹ� postal code
        $csv_page_data[$i][21] = $page_data[$i][31];        // ���꣱ address 1
        $csv_page_data[$i][22] = $page_data[$i][32];        // ���ꣲ address 2 
        $csv_page_data[$i][23] = $page_data[$i][33];        // ���ꣳaddress 3
        $csv_page_data[$i][24] = $page_data[$i][34];        // ����ʥեꥬ�ʡ�address (katakana)
        $csv_page_data[$i][25] = $page_data[$i][12];        // Tel
        $csv_page_data[$i][26] = $page_data[$i][35];        // FAX
        $csv_page_data[$i][27] = $page_data[$i][36];        // Email
        $csv_page_data[$i][28] = $page_data[$i][37];        // URL
        $csv_page_data[$i][29] = $page_data[$i][38];        // ���ܶ� capital
        $csv_page_data[$i][30] = $page_data[$i][39];        // ��ɽ�Ի�̾ name of the representative
        $csv_page_data[$i][31] = $page_data[$i][40];        // ��ɽ���� position of the rep
        $csv_page_data[$i][32] = $page_data[$i][41];        // ��ɽ�Է���TEL of the rep
        $csv_page_data[$i][33] = $page_data[$i][42];        // ľ��TEL direct TEL
        $csv_page_data[$i][34] = $page_data[$i][43];        // ������  joining fee
        $csv_page_data[$i][35] = $page_data[$i][44];        // �ݾڶ� security deposit
        $csv_page_data[$i][36] = $page_data[$i][45];        // �����ƥ� royalty
        $csv_page_data[$i][37] = (($page_data[$i][46] != null )?$page_data[$i][46]."��":"").(($page_data[$i][47] != null)?$page_data[$i][47]."��":""); // �軻��
        $csv_page_data[$i][38] = $page_data[$i][48];        // ������  collection terms
        $csv_page_data[$i][39] = $page_data[$i][49];        // Ϳ������ credit limit
        $csv_page_data[$i][40] = $page_data[$i][50];        // ���� close day
        $csv_page_data[$i][41] = ($page_data[$i][7]!=null)?$page_data[$i][7]."-".$page_data[$i][8]:""; // �����襳���� billing code
        $csv_page_data[$i][42] = $page_data[$i][9];         // ������̾ billing client name
        $csv_page_data[$i][43] = $page_data[$i][10];        // ô����̾ staff name
        $csv_page_data[$i][44] = $page_data[$i][51]."��".$page_data[$i][52];        // ������ collection date
        $csv_page_data[$i][45] = $page_data[$i][53];        // ������ˡ collection method
        $csv_page_data[$i][46] = $page_data[$i][54];        // ����̾�� deposit name
        $csv_page_data[$i][47] = $page_data[$i][55];        // ����̾�� account name
        $csv_page_data[$i][48] = $page_data[$i][56];        // ������� deposit bank
        $csv_page_data[$i][49] = $page_data[$i][57];        // ����������ʬ custoemr trade classifiation
        $csv_page_data[$i][50] = $page_data[$i][58]."��".$page_data[$i][59];        // ��ʧ�� payment date
        $csv_page_data[$i][51] = $page_data[$i][60];        // �������� deposit account
        $csv_page_data[$i][52] = $page_data[$i][61];        // ��������ά��deposit account classification
        $csv_page_data[$i][53] = $page_data[$i][62];        // ����������ʬ supplier trade classifciation
        $csv_page_data[$i][54] = $page_data[$i][63];        // Ϣ��ô���Ի�̾ name of the contact in person
        $csv_page_data[$i][55] = $page_data[$i][64];        // Ϣ��ô������ position of the contact in person
        $csv_page_data[$i][56] = $page_data[$i][65];        // Ϣ��ô���Է��� TEL of the contact in person
        $csv_page_data[$i][57] = $page_data[$i][66];        // ���ô���Ի�̾ accounting staff name
        $csv_page_data[$i][58] = $page_data[$i][67];        // ���ô���Է��� accounting staff tel
        $csv_page_data[$i][59] = $page_data[$i][68];        // �ݾڿͣ���̾ guarantor 1 name
        $csv_page_data[$i][60] = $page_data[$i][69];        // �ݾڿͣ����� guarantor1 address
        $csv_page_data[$i][61] = $page_data[$i][70];        // �ݾ�ͣ���̾ guarantor 2 name
        $csv_page_data[$i][62] = $page_data[$i][71];        // �ݾڿͣ����� guarantor 2 address
        $csv_page_data[$i][63] = $page_data[$i][72];        // �Ķȵ��� base where sale is conducted
        $csv_page_data[$i][64] = $page_data[$i][73];        // ���� holdiay
        $csv_page_data[$i][65] = $page_data[$i][74];        // ���� trade area
        $csv_page_data[$i][66] = $page_data[$i][75];        // ������̾ contracted company name
        $csv_page_data[$i][67] = $page_data[$i][76];        // ������ɽ��̾ contracted representative name
        $csv_page_data[$i][68] = $page_data[$i][77];        // ����ǯ���� contract start date
        $csv_page_data[$i][69] = $page_data[$i][78];        // ���󹹿��� contract update date
        $csv_page_data[$i][70] = $page_data[$i][80];        // ������� contract period
        $csv_page_data[$i][71] = $page_data[$i][79];        // ����λ�� contract end date
        $csv_page_data[$i][72] = $page_data[$i][81];        // �϶��� establishment date
        $csv_page_data[$i][73] = $page_data[$i][82];        // ˡ���е��� date of registration
        $csv_page_data[$i][74] = $page_data[$i][83];        // ��ɼȯ�� issue slip
        $csv_page_data[$i][75] = $page_data[$i][84];        // Ǽ�ʽ񥳥��ȡʸ��̡� delivery note comment (effect
        $csv_page_data[$i][76] = $page_data[$i][85];        // Ǽ�ʽ񥳥��� delivery note comment 
        $csv_page_data[$i][77] = $page_data[$i][86];        // �����ȯ��  issue billing statement
        $csv_page_data[$i][78] = $page_data[$i][87];        // ���������  send billing statement
        $csv_page_data[$i][79] = $page_data[$i][88];        // ������ͼ�  billing statement format
        $csv_page_data[$i][80] = $page_data[$i][89];        // ���:�ݤ��ʬ amount:round up/down
        $csv_page_data[$i][81] = $page_data[$i][90];        // ������:����ñ�� tax: tax unit 
        $csv_page_data[$i][82] = $page_data[$i][91];        // ������:ü����ʬ tax: round up/down
        $csv_page_data[$i][83] = $page_data[$i][92];        // ������:���Ƕ�ʬ tax: tax classification
        $csv_page_data[$i][84] = $page_data[$i][93];        // ������ʡ�����ʬ�� acquired license/field of expertise
        $csv_page_data[$i][85] = $page_data[$i][94];        // ���� special clause
        $csv_page_data[$i][86] = $page_data[$i][97];        // �������  trade history
        $csv_page_data[$i][87] = $page_data[$i][95];        // ���׻��� important items 
        $csv_page_data[$i][88] = $page_data[$i][96];        // ����¾ others

        #2010-05-01 hashimoto-y
        $csv_page_data[$i][89] = $page_data[$i][98];        // ������� billing address

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
            "�����ƥ�",
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

//��٥���� label output
$javascript  = Create_Allcheck_Js ("All_Label_Check","form_label_check",$ary_shop_id);



#2010-05-13 hashimoto-y
$display_flg = true;
}


/****************************/
//HTML�إå� html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå������� create screen header
/****************************/
$page_title .= "(�����".$dealing_count."��/��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variabl
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assing other variables
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
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
