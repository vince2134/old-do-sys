<?php

/******************************************************/
//変更履歴  
//  (2006/03/16)
//  ・DB構成変更により、一覧SQL変更
//  ・検索フォーム表示ボタン追加  
//  (2006/07/07 kaji)
//  ・shop_gidをなくす
/******************************************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-05      ban_0005     suzuki     CSV出力時にはサニタイジングしないように修正
 *  2007-01-23      仕様変更     watanabe-k ボタンカラー変更
 *  2007-02-22                   watanabe-k 不要機能の削除 
 *  2007-04-04                   watanabe-k 略称で検索できるように修正 
 *  2007-05-09                   kaku-m     csv出力項目を追加
 *  2007-05-21                   watanabe-k かな検索を追加 
 *  2007-07-27                   watanabe-k ラベル出力を追加 
 *  2010-01-29                   hashimoto-y非課税を追加
 *  2010-05-01      Rev.1.5　　  hashimoto-y請求書の宛先フォントサイズ変更機能の追加
 *  2010-05-13      Rev.1.5　　  hashimoto-y初期表示に検索項目だけ表示する修正
 *
*/

$page_title = "FC・取引先マスタ";

//環境設定ファイル env setting file
require_once("ENV_local.php");

//HTML_QuickFormを作成 create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// テンプレート関数をレジスト register the template function 
$smarty->register_function("Make_Sort_Link_Tpl", "Make_Sort_Link_Tpl");

//DBに接続 connect
$conn = Db_Connect();

// 権限チェック auth check
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ no input/edit auth message
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;

/****************************/
//外部変数取得 acquire external variable
/****************************/
$shop_id  = $_SESSION[shop_id];
//$shop_gid = $_SESSION[shop_gid];
//$shop_aid = $_SESSION[shop_aid];

/****************************/
//フォーム生成 create form
/****************************/
$def_fdata = array(
    "form_output_type"  => "1",
    "form_state_type"   => "1"
);
$form->setDefaults($def_fdata);


// 出力形式output format
$radio1[] =& $form->createElement( "radio", null, null, "画面", "1");
$radio1[] =& $form->createElement( "radio", null, null, "CSV", "2");
$form->addGroup($radio1, "form_output_type", "出力形式");

// 状態 status 
$radio2[] =& $form->createElement( "radio", null, null, "取引中", "1");
$radio2[] =& $form->createElement( "radio", null, null, "解約・休止中", "2");
$radio2[] =& $form->createElement( "radio", null, null, "全て", "3");
$form->addGroup($radio2, "form_state_type", "状態");

// チェックボックス checkbox
$form->addElement("checkbox", "f_check", "チェックボックス", "");

// TEL
$form->addElement("text", "form_tel", "", "size=\"15\" maxLength=\"13\" style=\"$g_form_style\"  $g_form_option");

// ショップコード shop code
$text1[] =& $form->createElement("text", "cd1", "ショップコード１", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onKeyup=\"changeText(this.form,'form_shop_cd[cd1]','form_shop_cd[cd2]',6);\" $g_form_option");
$text1[] =& $form->createElement("static","","","-");
$text1[] =& $form->createElement("text", "cd2", "ショップコード２", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text1, "form_shop_cd", "ショップコード");

// ショップ名・社名 shop name/ company name
$form->addElement("text", "form_shop_name", "ショップ名・社名", "size=\"34\" maxLength=\"15\""." $g_form_option");

// 請求先コード billing client code
$text2[] =& $form->createElement("text", "cd1", "請求先コード１", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_claim_cd[cd1]','form_claim_cd[cd2]',6);\" $g_form_option");
$text2[] =& $form->createElement("static", "", "", "-");
$text2[] =& $form->createElement("text", "cd2", "請求先コード２", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" $g_form_option");
$form->addGroup( $text2, "form_claim_cd", "form_claim_cd");

// 請求先名 billing address naem
$form->addElement("text", "form_claim_name", "請求先名", "size=\"34\" maxLength=\"15\""." $g_form_option");

// FC・取引先区分 FC/trade classification
$select_value = Select_Get($conn, "rank");
$form->addElement("select", "form_rank_1", "FC・取引先区分", $select_value, $g_form_option_select);
 
// 地区 district
$select_value = Select_Get($conn, "area");
$form->addElement("select", "form_area_1", "地区", $select_value, $g_form_option_select);

// 担当者 staff
$select_value = Select_Get($conn, "staff");
$form->addElement("select", "form_staff_1", "担当者", $select_value, $g_form_option_select);

// ソートリンク sort link
$ary_sort_item = array(
    "sl_client_cd"      => "ショップコード",
    "sl_client_name"    => "ショップ名",
    "sl_shop_name"      => "社名",
    "sl_rank"           => "FC・取引先区分",
    "sl_area"           => "地区",
    "sl_claim_cd"       => "請求先コード",
    "sl_claim_name"     => "請求先名",
    "sl_staff"          => "担当者名",
    "sl_tel"            => "T E L",
    "sl_day"            => "契約年月日",
);
AddElement_Sort_Link($form, $ary_sort_item, "sl_area");

//表示ボタン display button
$button[] = $form->createElement("submit","show_button","表　示");

//クリアボタン clear button
$button[] = $form->createElement("button","clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//検索 saerch
$form->addElement("submit","form_search_button","検索フォームを表示","");

//登録 register
$form->addElement("button","new_button","登録画面","onClick=\"javascript:Referer('1-1-103.php')\"");

//変更・一覧 edit/list
//$form->addElement("button","change_button","変更・一覧","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","change_button","変更・一覧", $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addGroup($button, "form_button", "ボタン");

$form->addElement("checkbox", "label_check_all", "", "ラベル出力", "onClick=\"javascript:All_Label_Check('label_check_all');\"");
#2010-05-13 hashimoto-y
#$form->addElement("submit","form_label_button","ラベル出力","onClick=\"javascript:Post_book_vote('./1-1-111.php','#');\"");
$form->addElement("button","form_label_button","ラベル出力","onClick=\"javascript:Post_book_vote3('./1-1-111.php','#');\"");

//一括発行
/*
$form->addElement(
    "button","slip_button","一括発行",
    "onClick=\"javascript:Post_book_vote('".HEAD_DIR."system/1-1-102.php')\""
);
*/
$form->addElement("hidden", "hdn_search_flg");        //検索フォーム表示フラグ search form display flag

//検索条件記憶用 to remember the search condition
$form->addElement("hidden", "hdn_output_type");   //出力形式 output format
$form->addElement("hidden", "hdn_state_type");    //状態 status
$form->addElement("hidden", "hdn_shop_cd1");      //ショップコード１ shop code 1
$form->addElement("hidden", "hdn_shop_cd2");      //ショップコード２ shop code 2
$form->addElement("hidden", "hdn_shop_name");     //ショップ名 shop name
$form->addElement("hidden", "hdn_rank");          //FC・取引先区分 FC/trade classification
$form->addElement("hidden", "hdn_area");          //地区 district
$form->addElement("hidden", "hdn_claim_cd1");     //請求先コード１ billing code 1
$form->addElement("hidden", "hdn_claim_cd2");     //請求先コード２ billing code 2
$form->addElement("hidden", "hdn_claim_name");    //請求先名 billing name
$form->addElement("hidden", "hdn_staff");         //担当者 staff
$form->addElement("hidden", "hdn_tel");



#2010-05-13 hashimoto-y
if($_POST["form_button"]["show_button"] == "表　示"){



/****************************/
//全件数取得 acquire all items
/****************************/
$fc_sql  = " SELECT ";
$fc_sql .= "     t_client.client_id,";                      // 0 得意先ID customer ID
$fc_sql .= "     t_client.client_cd1,";                     // 1 得意先コード１ custoemr code 1
$fc_sql .= "     t_client.client_cd2,";                     // 2 得意先コード２ custoemr code 2
$fc_sql .= "     t_client.client_name,";                    // 3 得意先名 customer name
$fc_sql .= "     t_client.shop_name,";                      // 4 社名 company name 
$fc_sql .= "     t_rank.rank_name,";                        // 5 FC・取引先区分 FC/trade classification
$fc_sql .= "     t_area.area_name,";                        // 6 地区 district
$fc_sql .= "     t_client_claim.client_cd1,";               // 7 請求先コード１ billing code 1
$fc_sql .= "     t_client_claim.client_cd2,";               // 8 請求先コード２ billing code 2
$fc_sql .= "     t_client_claim.shop_name,";                // 9 請求先名 billing name
$fc_sql .= "     t_staff.staff_name,";                      // 10 担当者名 staff name
$fc_sql .= "     t_client.state,";                          // 11 状態 status
$fc_sql .= "     t_client.tel,";                            // 12 Tel
$fc_sql .= "     t_client.cont_sday";                       // 13 契約年月日 contract date
//csv出力用 for csv output
if($_POST["form_button"]["show_button"] == "表　示"){$output_type    = $_POST["form_output_type"];}
if($output_type == 2){
$fc_sql .= "    ,";
$fc_sql .= "    t_sbtype.sbtype_name,";                     // 14 小分類業種名 small business type name
$fc_sql .= "    t_inst.inst_name,";                         // 15 施設名 facility name
$fc_sql .= "    t_bstruct.bstruct_name, ";                  // 16 業態名 business type name
$fc_sql .= "    t_staff_sv.staff_name, ";                   // 17 SV
$fc_sql .= "    t_staff_1.staff_name, ";                    // 18 担当１ staff
$fc_sql .= "    t_staff_2.staff_name, ";                    // 19 担当２ staff
$fc_sql .= "    t_staff_3.staff_name, ";                    // 20 担当３ staff
$fc_sql .= "    t_staff_4.staff_name, ";                    // 21 担当４ staff
$fc_sql .= "    t_client.client_read, ";                    // 22 得意先名（フリガナ） customer name (katkaan)
$fc_sql .= "    t_client.client_cname,";                    // 23 略称 abbreviation
$fc_sql .= "    t_client.client_cread, ";                   // 24 略称（フリガナ） abbreviation (katkana) 
$fc_sql .= "    CASE t_client.compellation ";               // 25 敬称 compellation
$fc_sql .= "        WHEN '1' THEN '御中' ";
$fc_sql .= "        WHEN '2' THEN '様' ";
$fc_sql .= "    END AS compellation, ";
$fc_sql .= "    t_client.shop_read, ";                      // 26 社名（フリガナ） company name (katakanaa)
$fc_sql .= "    t_client.shop_name2, ";                     // 27 社名２ company name 2
$fc_sql .= "    t_client.shop_read2, ";                     // 28 社名２（フリガナ） company name 2 (katakana)
$fc_sql .= "    t_client.post_no1, ";                       // 29 郵便番号１ postal code 1
$fc_sql .= "    t_client.post_no2, ";                       // 30 郵便番号２ postal code 2
$fc_sql .= "    t_client.address1, ";                       // 31 住所１ address
$fc_sql .= "    t_client.address2, ";                       // 32 住所２ address
$fc_sql .= "    t_client.address3, ";                       // 33 住所３ address
$fc_sql .= "    t_client.address_read, ";                   // 34 住所（フリガナ） address (katakana)
$fc_sql .= "    t_client.fax, ";                            // 35 FAX
$fc_sql .= "    t_client.email, ";                          // 36 Email
$fc_sql .= "    t_client.url, ";                            // 37 URL
$fc_sql .= "    t_client.capital, ";                        // 38 資本金 capital
$fc_sql .= "    t_client.rep_name, ";                       // 39 代表者氏名 name of the representative
$fc_sql .= "    t_client.represe, ";                        // 40 代表者役職 position of the rep
$fc_sql .= "    t_client.rep_htel, ";                       // 41 代表者携帯 TEL of the rep
$fc_sql .= "    t_client.direct_tel, ";                     // 42 直通TEL direct TEL
$fc_sql .= "    t_client.join_money, ";                     // 43 加盟金 joining fee
$fc_sql .= "    t_client.guarant_money, ";                  // 44 保証金  security deposit
$fc_sql .= "    t_client.royalty_rate, ";                   // 45 ロイヤリティ royalty
$fc_sql .= "    t_client.cutoff_month, ";                   // 46 決算日（月）cutoff date (month)
$fc_sql .= "    t_client.cutoff_day, ";                     // 47 決算日（日） cutoff date (day)
$fc_sql .= "    t_client.col_terms, ";                      // 48 回収条件 collection condition
$fc_sql .= "    t_client.credit_limit, ";                   // 49 与信限度credit limit
$fc_sql .= "    CASE t_client.close_day ";                  // 50 締日 close day
$fc_sql .= "        WHEN '29' THEN '月末' ";
$fc_sql .= "        ELSE t_client.close_day || '日' ";
$fc_sql .= "    END AS close_day, ";
$fc_sql .= "    CASE t_client.pay_m ";                      // 51 集金日（月） collection date (month)
$fc_sql .= "        WHEN '0' THEN '当月' ";
$fc_sql .= "        WHEN '1' THEN '翌月' ";
$fc_sql .= "        ELSE t_client.pay_m || 'ヵ月後'";
$fc_sql .= "    END AS pay_m, ";
$fc_sql .= "    CASE t_client.pay_d ";                      // 52 集金日（日） collection date (day)
$fc_sql .= "        WHEN '29' THEN '月末' ";
$fc_sql .= "        ELSE t_client.pay_d || '日' ";
$fc_sql .= "    END AS pay_d, ";
$fc_sql .= "    CASE t_client.pay_way ";                    // 53 集金方法 collection method
$fc_sql .= "        WHEN '1' THEN '自動引落' ";
$fc_sql .= "        WHEN '2' THEN '振込' ";
$fc_sql .= "        WHEN '3' THEN '訪問集金' ";
$fc_sql .= "        WHEN '4' THEN '手形' ";
$fc_sql .= "        WHEN '5' THEN 'その他' ";
$fc_sql .= "    END AS pay_way, ";
$fc_sql .= "    t_client.pay_name, ";                       // 54 振込名義 deposit name
$fc_sql .= "    t_client.account_name, ";                   // 55 口座名義 account name
$fc_sql .= "    CASE WHEN t_client.account_id IS NOT NULL ";// 56 振込銀行 deposit bank
$fc_sql .= "        THEN t_bank.bank_name || ' ' || t_b_bank.b_bank_name || ' ' ||CASE t_account.deposit_kind  WHEN '1' THEN '普通 'WHEN '2' THEN '当座 ' END || t_account.account_no ";
$fc_sql .= "    END AS pay_bank, ";
$fc_sql .= "    t_trade.trade_name, ";                      // 57 得意先取引区分 customer trade classification
$fc_sql .= "    CASE t_client.payout_m ";                   // 58 支払日（月） payment date (motnh)
$fc_sql .= "        WHEN '0' THEN '当月' ";
$fc_sql .= "        WHEN '1' THEN '翌月' ";
$fc_sql .= "        ELSE t_client.payout_m || 'ヵ月後' ";
$fc_sql .= "    END AS payout_m, ";
$fc_sql .= "    CASE t_client.payout_d";                    // 59 支払日（日） payment date (day)
$fc_sql .= "        WHEN '29' THEN '月末' ";
$fc_sql .= "        ELSE t_client.payout_d || '日' ";
$fc_sql .= "    END AS payout_d, ";
$fc_sql .= "    t_client.bank_name, ";                      // 60 振込口座 deposit account 
$fc_sql .= "    t_client.b_bank_name, ";                    // 61 振込口座略称 deposit account abbreviation
$fc_sql .= "    t_buy_trade.trade_name, ";                  // 62 仕入先取引区分 supplier trade classifcaiton
$fc_sql .= "    t_client.charger_name, ";                   // 63 連絡担当者氏名 contact in person name
$fc_sql .= "    t_client.charger, ";                        // 64 連絡担当者役職 contact in person position
$fc_sql .= "    t_client.cha_htel, ";                       // 65 連絡担当者携帯 contact in person tel
$fc_sql .= "    t_client.accountant_name, ";                // 66 会計担当者氏名 accounting reprsentative name
$fc_sql .= "    t_client.account_tel, ";                    // 67 会計担当者携帯 accounting reprsentative tel
$fc_sql .= "    t_client.surety_name1, ";                   // 68 保証人１氏名 guarantor1 name
$fc_sql .= "    t_client.surety_addr1, ";                   // 69 保証人１住所 guarantor1 address
$fc_sql .= "    t_client.surety_name2, ";                   // 70 保障人２氏名 guarantor2 name
$fc_sql .= "    t_client.surety_addr2, ";                   // 71 保証人２住所 guarantor2 address
$fc_sql .= "    t_client.trade_base, ";                     // 72 営業拠点 base where sale is conduct
$fc_sql .= "    t_client.holiday, ";                        // 73 休日  holiday
$fc_sql .= "    t_client.trade_area, ";                     // 74 商圏 trade area
$fc_sql .= "    t_client.c_compa_name, ";                   // 75 契約会社名 contracted company name
$fc_sql .= "    t_client.c_compa_rep, ";                    // 76 契約代表社名 contracted representati
$fc_sql .= "    t_client.cont_sday, ";                      // 77 契約年月日 contract start date
$fc_sql .= "    t_client.cont_rday, ";                      // 78 契約更新日 contract update date
$fc_sql .= "    t_client.cont_eday, ";                      // 79 契約終了日 contract end day
$fc_sql .= "    t_client.cont_peri, ";                      // 80 契約期間 contract period
$fc_sql .= "    t_client.establish_day, ";                  // 81 創業日  establishment date
$fc_sql .= "    t_client.regist_day, ";                     // 82 法人登記日 register date
$fc_sql .= "    CASE t_client.slip_out ";                   // 83 伝票発行 issue slip
$fc_sql .= "        WHEN '1' THEN '有' ";
$fc_sql .= "        WHEN '2' THEN '指定' ";
$fc_sql .= "        WHEN '3' THEN '無' ";
$fc_sql .= "    END AS slip_out, ";
$fc_sql .= "    CASE t_client.deliver_effect ";             // 84 納品書コメント（効果） delivery note comment (effect)
$fc_sql .= "        WHEN '1' THEN 'コメント有効' ";
$fc_sql .= "        WHEN '2' THEN '個別コメント有効' ";
$fc_sql .= "        WHEN '3' THEN '全体コメント有効' ";
$fc_sql .= "    END AS deliver_effect, ";
$fc_sql .= "    t_client.deliver_note, ";                   // 85 納品書コメント delivery note comment
$fc_sql .= "    CASE t_client.claim_out ";                  // 86 請求書発行 issue billing statement
$fc_sql .= "        WHEN '1' THEN '明細請求書' ";
$fc_sql .= "        WHEN '2' THEN '合計請求書' ";
$fc_sql .= "        WHEN '3' THEN '出力しない' ";
$fc_sql .= "        WHEN '4' THEN '指定' ";
$fc_sql .= "    END AS claim_out, ";
$fc_sql .= "    CASE t_client.claim_send ";                 // 87 請求書送付  billing statement send
$fc_sql .= "        WHEN '1' THEN '郵送' ";
$fc_sql .= "        WHEN '2' THEN 'メール' ";
$fc_sql .= "        WHEN '3' THEN '両方' ";
$fc_sql .= "    END AS claim_send, ";
$fc_sql .= "    t_claim_sheet.c_pattern_name, ";            // 88 請求書様式 billing statement format
$fc_sql .= "    CASE t_client.coax ";                       // 89 金額丸め区分 amount round up/down
$fc_sql .= "        WHEN '1' THEN '切捨' ";
$fc_sql .= "        WHEN '2' THEN '四捨五入' ";
$fc_sql .= "        WHEN '3' THEN '切上' ";
$fc_sql .= "    END AS coax, ";
$fc_sql .= "    CASE t_client.tax_div ";                    // 90 消費税:課税単位 tax: tax unit 
$fc_sql .= "        WHEN '1' THEN '締日単位' ";
$fc_sql .= "        WHEN '2' THEN '伝票単位' ";
$fc_sql .= "    END AS tax_div, ";
$fc_sql .= "    CASE t_client.tax_franct ";                 // 91 消費税:端数区分 tax: round up/down
$fc_sql .= "        WHEN '1' THEN '切捨' ";
$fc_sql .= "        WHEN '2' THEN '四捨五入' ";
$fc_sql .= "        WHEN '3' THEN '切上' ";
$fc_sql .= "    END AS tax_franct, ";
$fc_sql .= "    CASE t_client.c_tax_div ";                  // 92 消費税:課税区分 tax: tax classification
$fc_sql .= "        WHEN '1' THEN '外税' ";
$fc_sql .= "        WHEN '2' THEN '内税' ";
#2010-01-29 hashimoto-y
$fc_sql .= "        WHEN '3' THEN '非課税' ";
$fc_sql .= "    END AS c_tax_div, ";
$fc_sql .= "    t_client.license, ";                        // 93 取得資格・得意分野  acquired license/field of expertise
$fc_sql .= "    t_client.s_contract, ";                     // 94 特約 special clause
$fc_sql .= "    t_client.importance, ";                     // 95 重要事項 important items
$fc_sql .= "    t_client.other, ";                          // 96 その他 others
$fc_sql .= "    t_client.deal_history, ";                    // 97 取引履歴 trade history

#2010-05-01 hashimoto-y
$fc_sql .= "   CASE t_client.bill_address_font \n";         // 98 請求書宛先 billing address font
$fc_sql .= "       WHEN 't' THEN '大' \n";
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
//csv出力用 csv for output
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
//初期表示時は取引中のデータのみ
if($_POST["form_button"]["show_button"] != "表　示" || $_POST["form_search_button"] != "検索フォームを表示"){
    $fc_sql .= "     AND";
    $fc_sql .= "     t_client.state = '1'";
}

/****************************/
//画面ヘッダー作成 create screen header
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
//ヘッダーに表示させる取引中データ件数 number of transacting data that will be displayed in header
$result = Db_Query($conn, $count_sql);
$dealing_count = pg_fetch_result($result,0,0);

$count_sql  = " SELECT ";
$count_sql .= "     COUNT(client_cd1)";
$count_sql .= " FROM";
$count_sql .= "    t_client ";
$count_sql .= " WHERE";
$count_sql .= "    client_div = '3'";
$count_sql .= ";";
//ヘッダーに表示させる全件数 all items that will be displayed in header
$result = Db_Query($conn, $count_sql);
$total_count = pg_fetch_result($result,0,0);

/****************************/
//検索フォームを表示ボタン押下処理 display button pressed process the saerch form 
/****************************/
if($_POST["form_search_button"] == "検索フォームを表示"){
    $search_flg = true;
    $search_data["hdn_search_flg"] = $search_flg;
    $form->setConstants($search_data);

    $state = '1';
    $output_type = '1';

    $sort_col = $_POST["hdn_sort_col"];

    $post_flg = true;
}

/****************************/
//表示ボタン押下処理 process when the display button is pressed
/****************************/
if($_POST["form_button"]["show_button"] == "表　示"){
    $output_type    = $_POST["form_output_type"];          //出力形式 output format
    $state          = $_POST["form_state_type"];           //状態 status
    $shop_cd1       = trim($_POST["form_shop_cd"]["cd1"]); //ショップコード1 shop code 1
    $shop_cd2       = trim($_POST["form_shop_cd"]["cd2"]); //ショップコード2 sop code 2
    $shop_name      = $_POST["form_shop_name"];            //ショップ名/社名 shop name/company name
    $rank           = $_POST["form_rank_1"];               //FC・取引先区分 fc/trade partner classification
    $area           = $_POST["form_area_1"];               //地区 district
    $claim_cd1      = trim($_POST["form_claim_cd"]["cd1"]);//請求先コード1 billing address code 1
    $claim_cd2      = trim($_POST["form_claim_cd"]["cd2"]);//請求先コード2 billing address code 2
    $claim_name     = $_POST["form_claim_name"];           //請求先名 billing name
    $staff          = $_POST["form_staff_1"];              //担当者 staff
    $tel            = $_POST["form_tel"];                  //TEL
    $post_flg       = true;                                //POSTフラグ post flag

    $sort_col = $_POST["hdn_sort_col"];

/*****************************/
//カラムリンクが押下された場合 if the column link is pressed
/*****************************/
}elseif(count($_POST) > 0
    && $_POST["form_button"]["show_button"] != "表　示"
    && $_POST["form_search_button"] != "検索フォームを表示"){

    $output_type    = $_POST["hdn_output_type"];            //出力形式 ouput format
    $state          = $_POST["hdn_state_type"];             //状態 status
    $shop_cd1       = $_POST["hdn_shop_cd1"];               //ショップコード１  shop code 1
    $shop_cd2       = $_POST["hdn_shop_cd2"];               //ショップコード２ shop code 2
    $shop_name      = $_POST["hdn_shop_name"];              //ショップ名/社名 shop name/company name
    $rank           = $_POST["hdn_rank"];                   //FC・取引先区分 fc/trade classification 
    $area           = $_POST["hdn_area"];                   //地区district
    $claim_cd1      = $_POST["hdn_claim_cd1"];              //請求先コード１ billin gcode 1
    $claim_cd2      = $_POST["hdn_claim_cd2"];              //請求先コード２ billing code 2
    $claim_name     = $_POST["hdn_claim_name"];             //請求先名 billing name
    $staff          = $_POST["hdn_staff"];                  //担当者 staff
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
    //検索データをセット set saerch data
    /****************************/
    $set_data["form_output_type"]       = stripslashes($output_type);     //出力形式 output format
    $set_data["form_state_type"]        = stripslashes($state);           //状態 status
    $set_data["form_shop_cd"]["cd1"]    = stripslashes($shop_cd1);        //ショップコード１ shop code 1
    $set_data["form_shop_cd"]["cd2"]    = stripslashes($shop_cd2);        //ショップコード２ shop code 2
    $set_data["form_shop_name"]         = stripslashes($shop_name);       //ショップ名/社名 shop name/company nmae
    $set_data["form_rank_1"]            = stripslashes($rank);            //FC・取引先区分 fc/trade classification
    $set_data["form_area_1"]            = stripslashes($area);            //地区 district
    $set_data["form_claim_cd"]["cd1"]   = stripslashes($claim_cd1);       //請求先コード１ billing code 1
    $set_data["form_claim_cd"]["cd2"]   = stripslashes($claim_cd2);       //請求先コード２ billing code 2
    $set_data["form_claim_name"]        = stripslashes($claim_name);      //請求先名 billing name
    $set_data["form_staff_1"]           = stripslashes($staff);           //担当者 staff
    $set_data["form_tel"]               = stripslashes($tel);             //TEL

    $set_data["hdn_output_type"]        = stripslashes($output_type);     //出力形式 ouput format
    $set_data["hdn_state_type"]         = stripslashes($state);      //状態 status
    $set_data["hdn_shop_cd1"]           = stripslashes($shop_cd1);        //ショップコード１ shop code 1
    $set_data["hdn_shop_cd2"]           = stripslashes($shop_cd2);        //ショップコード２ shop code 2
    $set_data["hdn_shop_name"]          = stripslashes($shop_name);       //ショップ名/社名  shop name/company nmae
    $set_data["hdn_rank"]               = stripslashes($rank);            //FC・取引先区分  fc/trade classification
    $set_data["hdn_area"]               = stripslashes($area);            //地区 district
    $set_data["hdn_claim_cd1"]          = stripslashes($claim_cd1);       //請求先コード１ billing code 1
    $set_data["hdn_claim_cd2"]          = stripslashes($claim_cd2);       //請求先コード２ billing code 2
    $set_data["hdn_claim_name"]         = stripslashes($claim_name);      //請求先名 billing name
    $set_data["hdn_staff"]              = stripslashes($staff);           //担当者staff
    $set_data["hdn_tel"]                = stripslashes($tel);             //TEL

    $form->setConstants($set_data);
        
    /****************************/
    //where_sql作成 create
    /****************************/
    //ショップコード1 shop code 1
    if($shop_cd1 != null){
        $shop_cd1_sql  = " AND t_client.client_cd1 LIKE '$shop_cd1%'";
    }

    //ショップコード2 shop code 2
    if($shop_cd2 != null){
        $shop_cd2_sql  = " AND t_client.client_cd2 LIKE '$shop_cd2%'";
    }

    //ショップ名 shop name
    if($shop_name != null){
        $shop_name_sql  = " AND (t_client.client_name LIKE '%$shop_name%' 
                            OR t_client.shop_name LIKE '%$shop_name%' 
                            OR t_client.client_read LIKE '%$shop_name%' 
                            OR t_client.client_read2 LIKE '%$shop_name%' 
                            OR t_client.client_cread LIKE '%$shop_name%' 
                            OR t_client.client_cname LIKE '%$shop_name%')";
    }

    //FC・取引先区分 FC/ trade classifciation
    if($rank != 0){
        $rank_id_sql = " AND t_rank.rank_cd = '$rank'";
    }

    //地区 district
    if($area != 0){
        $area_sql = " AND t_area.area_id = '$area'";
    }

    //請求先コード1 billingh code 1
    if($claim_cd1 != null){
        $claim_cd1_sql  = " AND t_client_claim.client_cd1 LIKE '$claim_cd1%'";
    }

    //請求先コード2 billingh code 2
    if($claim_cd2 != null){
        $claim_cd2_sql  = " AND t_client_claim.client_cd2 LIKE '$claim_cd2%'";
    }

    //請求先名 billing name
    if($claim_name != null){
        $claim_name_sql  = " AND t_client_claim.client_name LIKE '%$claim_name%'";
    }

    //担当者 staff
    if($staff != 0){
        $staff_sql = " AND t_staff.staff_id = '$staff'";
    }

    //TEL
    if($tel != null){
        $tel_sql  = " AND t_client.tel LIKE '$tel%'";
    }
        
    //状態 status 
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
//並び替えSQL作成 create change order SQL
/****************************/
//ショップコードの昇順判定 determine the order of shopcode 
if($sort_col == "sl_client_cd"){
    $oder_by_sql = " ORDER BY t_client.client_cd1,t_client.client_cd2 ASC ";
//ショップ名の昇順判定 determine the order of shop name
}else if($sort_col == "sl_client_name"){
    $oder_by_sql = " ORDER BY t_client.client_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//社名の昇順判定determine the order of company name
}else if($sort_col == "sl_shop_name"){
    $oder_by_sql = " ORDER BY t_client.shop_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//FC・取引先区分の昇順判定 determine the order of fc trade classification
}else if($sort_col == "sl_rank"){
    $oder_by_sql = " ORDER BY t_rank.rank_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//地区の昇順判定 determine the order of district
}else if($sort_col == "sl_area"){
    $oder_by_sql = " ORDER BY t_area.area_cd,t_client.client_cd1,t_client.client_cd2 ASC ";
//請求書コードの昇順判定 determine the order of biling statement
}else if($sort_col == "sl_claim_cd"){
    $oder_by_sql = " ORDER BY t_client_claim.client_cd1,t_client_claim.client_cd2 ASC ";
//請求書名の昇順判定 determine the order of billing statement name
}else if($sort_col == "sl_claim_name"){
    $oder_by_sql = " ORDER BY t_client_claim.client_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//担当者の昇順判定 determine the order of staff
}else if($sort_col == "sl_staff"){
    $oder_by_sql = " ORDER BY t_staff.staff_name,t_client.client_cd1,t_client.client_cd2 ASC ";
//TELの昇順判定 determine the order of tel
}else if($sort_col == "sl_tel"){
    $oder_by_sql = " ORDER BY t_client.tel,t_client.client_cd1,t_client.client_cd2 ASC ";
//契約年月日の昇順判定 determine the order of contract start date
}else if($sort_col == "sl_day"){
    $oder_by_sql = " ORDER BY t_client.cont_sday,t_client.client_cd1,t_client.client_cd2 ASC ";
//デフォルトはショップコードの昇順 default is the order of the shop code
}else{
    $oder_by_sql = " ORDER BY t_area.area_cd,t_client.client_cd1,t_client.client_cd2 ASC ";
}

/****************************/
//表示データ作成 create display date
/****************************/
//画面選択時 select screen
if($output_type == 1 || $output_type == null){

    //該当データ corresponding date
    $fc_sql .= $where_sql.$oder_by_sql.";";
    $serch_count_sql = $fc_sql;
    $serch_res = Db_Query($conn, $serch_count_sql);
    $match_count = pg_num_rows($serch_res);
    $page_data = Get_Data($serch_res, $output_type);

    //ラベル出力チェックボックス作成 craete label output checkbox
    for($i = 0; $i < $match_count; $i++){
        $label_shop_id = $page_data[$i][0]; 
        $ary_shop_id[$i] = $label_shop_id;
        $form->addElement("advcheckbox", "form_label_check[$i]", null, null, null, array("null", "$label_shop_id"));
    }

}else if($output_type == 2){

    //データに表示させる全件数 all items that will be displayed in data
    $fc_sql .= $where_sql.$oder_by_sql.";";
    $count_res = Db_Query($conn, $fc_sql);
    $match_count = pg_num_rows($count_res);
    $page_data = Get_Data($count_res,2);

    //CSV作成 create csv
    for($i = 0; $i < $match_count; $i++){
        if($page_data[$i][11] == 1){
            $page_data[$i][11] = "取引中";
        }else{
            $page_data[$i][11] = "解約・休止中";
        }
        $csv_page_data[$i][0] = $page_data[$i][11];         //状態 status 
        $csv_page_data[$i][1] = $page_data[$i][6];          // 地区 district
        $csv_page_data[$i][2] = $page_data[$i][14];         // 小分類業種名 small business type name
        $csv_page_data[$i][3] = $page_data[$i][15];         // 施設名 facility 
        $csv_page_data[$i][4] = $page_data[$i][16];         // 業態名 business type 
        $csv_page_data[$i][5] = $page_data[$i][17];         // SV
        $csv_page_data[$i][6] = $page_data[$i][18];         // 担当１ staff 1
        $csv_page_data[$i][7] = $page_data[$i][19];         // 担当２  staff 2
        $csv_page_data[$i][8] = $page_data[$i][20];         // 担当３ staff 3
        $csv_page_data[$i][9] = $page_data[$i][5];         // FC・取引先区分 fc trade classification
        $csv_page_data[$i][10] = $page_data[$i][1]."-".$page_data[$i][2];        // ショップコード shop code
        $csv_page_data[$i][11] = $page_data[$i][3];         // ショップ名 shop name 
        $csv_page_data[$i][12] = $page_data[$i][22];        // ショップ名（フリガナ） shop name (katakana)
        $csv_page_data[$i][13] = $page_data[$i][23];        // 略称 abbreviation 
        $csv_page_data[$i][14] = $page_data[$i][24];        // 略称（フリガナ） abbreviation (katakana)
        $csv_page_data[$i][15] = $page_data[$i][25];        // 敬称 compellation 
        $csv_page_data[$i][16] = $page_data[$i][4];         // 社名 company name
        $csv_page_data[$i][17] = $page_data[$i][26];        // 社名（フリガナ）  company name (katakana)
        $csv_page_data[$i][18] = $page_data[$i][27];        // 社名２ company name2
        $csv_page_data[$i][19] = $page_data[$i][28];        // 社名２（フリガナ） company name2 (katakana)
        $csv_page_data[$i][20] = $page_data[$i][29]."-".$page_data[$i][30];        // 郵便番号 postal code
        $csv_page_data[$i][21] = $page_data[$i][31];        // 住所１ address 1
        $csv_page_data[$i][22] = $page_data[$i][32];        // 住所２ address 2 
        $csv_page_data[$i][23] = $page_data[$i][33];        // 住所３address 3
        $csv_page_data[$i][24] = $page_data[$i][34];        // 住所（フリガナ）address (katakana)
        $csv_page_data[$i][25] = $page_data[$i][12];        // Tel
        $csv_page_data[$i][26] = $page_data[$i][35];        // FAX
        $csv_page_data[$i][27] = $page_data[$i][36];        // Email
        $csv_page_data[$i][28] = $page_data[$i][37];        // URL
        $csv_page_data[$i][29] = $page_data[$i][38];        // 資本金 capital
        $csv_page_data[$i][30] = $page_data[$i][39];        // 代表者氏名 name of the representative
        $csv_page_data[$i][31] = $page_data[$i][40];        // 代表者役職 position of the rep
        $csv_page_data[$i][32] = $page_data[$i][41];        // 代表者携帯TEL of the rep
        $csv_page_data[$i][33] = $page_data[$i][42];        // 直通TEL direct TEL
        $csv_page_data[$i][34] = $page_data[$i][43];        // 加盟金  joining fee
        $csv_page_data[$i][35] = $page_data[$i][44];        // 保証金 security deposit
        $csv_page_data[$i][36] = $page_data[$i][45];        // ロイヤリティ royalty
        $csv_page_data[$i][37] = (($page_data[$i][46] != null )?$page_data[$i][46]."月":"").(($page_data[$i][47] != null)?$page_data[$i][47]."日":""); // 決算日
        $csv_page_data[$i][38] = $page_data[$i][48];        // 回収条件  collection terms
        $csv_page_data[$i][39] = $page_data[$i][49];        // 与信限度 credit limit
        $csv_page_data[$i][40] = $page_data[$i][50];        // 締日 close day
        $csv_page_data[$i][41] = ($page_data[$i][7]!=null)?$page_data[$i][7]."-".$page_data[$i][8]:""; // 請求先コード billing code
        $csv_page_data[$i][42] = $page_data[$i][9];         // 請求先名 billing client name
        $csv_page_data[$i][43] = $page_data[$i][10];        // 担当者名 staff name
        $csv_page_data[$i][44] = $page_data[$i][51]."の".$page_data[$i][52];        // 集金日 collection date
        $csv_page_data[$i][45] = $page_data[$i][53];        // 集金方法 collection method
        $csv_page_data[$i][46] = $page_data[$i][54];        // 振込名義 deposit name
        $csv_page_data[$i][47] = $page_data[$i][55];        // 口座名義 account name
        $csv_page_data[$i][48] = $page_data[$i][56];        // 振込銀行 deposit bank
        $csv_page_data[$i][49] = $page_data[$i][57];        // 得意先取引区分 custoemr trade classifiation
        $csv_page_data[$i][50] = $page_data[$i][58]."の".$page_data[$i][59];        // 支払日 payment date
        $csv_page_data[$i][51] = $page_data[$i][60];        // 振込口座 deposit account
        $csv_page_data[$i][52] = $page_data[$i][61];        // 振込口座略称deposit account classification
        $csv_page_data[$i][53] = $page_data[$i][62];        // 仕入先取引区分 supplier trade classifciation
        $csv_page_data[$i][54] = $page_data[$i][63];        // 連絡担当者氏名 name of the contact in person
        $csv_page_data[$i][55] = $page_data[$i][64];        // 連絡担当者役職 position of the contact in person
        $csv_page_data[$i][56] = $page_data[$i][65];        // 連絡担当者携帯 TEL of the contact in person
        $csv_page_data[$i][57] = $page_data[$i][66];        // 会計担当者氏名 accounting staff name
        $csv_page_data[$i][58] = $page_data[$i][67];        // 会計担当者携帯 accounting staff tel
        $csv_page_data[$i][59] = $page_data[$i][68];        // 保証人１氏名 guarantor 1 name
        $csv_page_data[$i][60] = $page_data[$i][69];        // 保証人１住所 guarantor1 address
        $csv_page_data[$i][61] = $page_data[$i][70];        // 保障人２氏名 guarantor 2 name
        $csv_page_data[$i][62] = $page_data[$i][71];        // 保証人２住所 guarantor 2 address
        $csv_page_data[$i][63] = $page_data[$i][72];        // 営業拠点 base where sale is conducted
        $csv_page_data[$i][64] = $page_data[$i][73];        // 休日 holdiay
        $csv_page_data[$i][65] = $page_data[$i][74];        // 商圏 trade area
        $csv_page_data[$i][66] = $page_data[$i][75];        // 契約会社名 contracted company name
        $csv_page_data[$i][67] = $page_data[$i][76];        // 契約代表者名 contracted representative name
        $csv_page_data[$i][68] = $page_data[$i][77];        // 契約年月日 contract start date
        $csv_page_data[$i][69] = $page_data[$i][78];        // 契約更新日 contract update date
        $csv_page_data[$i][70] = $page_data[$i][80];        // 契約期間 contract period
        $csv_page_data[$i][71] = $page_data[$i][79];        // 契約終了日 contract end date
        $csv_page_data[$i][72] = $page_data[$i][81];        // 創業日 establishment date
        $csv_page_data[$i][73] = $page_data[$i][82];        // 法人登記日 date of registration
        $csv_page_data[$i][74] = $page_data[$i][83];        // 伝票発行 issue slip
        $csv_page_data[$i][75] = $page_data[$i][84];        // 納品書コメント（効果） delivery note comment (effect
        $csv_page_data[$i][76] = $page_data[$i][85];        // 納品書コメント delivery note comment 
        $csv_page_data[$i][77] = $page_data[$i][86];        // 請求書発行  issue billing statement
        $csv_page_data[$i][78] = $page_data[$i][87];        // 請求書送付  send billing statement
        $csv_page_data[$i][79] = $page_data[$i][88];        // 請求書様式  billing statement format
        $csv_page_data[$i][80] = $page_data[$i][89];        // 金額:丸め区分 amount:round up/down
        $csv_page_data[$i][81] = $page_data[$i][90];        // 消費税:課税単位 tax: tax unit 
        $csv_page_data[$i][82] = $page_data[$i][91];        // 消費税:端数区分 tax: round up/down
        $csv_page_data[$i][83] = $page_data[$i][92];        // 消費税:課税区分 tax: tax classification
        $csv_page_data[$i][84] = $page_data[$i][93];        // 取得資格・得意分野 acquired license/field of expertise
        $csv_page_data[$i][85] = $page_data[$i][94];        // 特約 special clause
        $csv_page_data[$i][86] = $page_data[$i][97];        // 取引履歴  trade history
        $csv_page_data[$i][87] = $page_data[$i][95];        // 重要事項 important items 
        $csv_page_data[$i][88] = $page_data[$i][96];        // その他 others

        #2010-05-01 hashimoto-y
        $csv_page_data[$i][89] = $page_data[$i][98];        // 請求書宛先 billing address

    }

    $csv_file_name = "FC・取引先マスタ".date("Ymd").".csv";
    $csv_header = array(
            "状態",
            "地区",
            "業種",
            "施設",
            "業態",
            "SV",
            "担当１",
            "担当２",
            "担当３",
            "FC・取引先区分",
            "ショップコード",
            "ショップ名",
            "ショップ名（フリガナ）",
            "略称",
            "略称（フリガナ）",
            "敬称",
            "社名１",
            "社名１（フリガナ）",
            "社名２",
            "社名２（フリガナ）",
            "郵便番号",
            "住所１",
            "住所２",
            "住所３",
            "住所２（フリガナ）",
            "Tel",
            "FAX",
            "Email",
            "URL",
            "資本金",
            "代表者氏名",
            "代表者役職",
            "代表者携帯",
            "直通TEL",
            "加盟金",
            "保証金",
            "ロイヤリティ",
            "決算日",
            "回収条件",
            "与信限度",
            "締日",
            "請求先コード",
            "請求先名",
            "担当者名",
            "集金日",
            "集金方法",
            "振込名義",
            "口座名義",
            "振込銀行",
            "得意先取引区分",
            "支払日",
            "振込口座",
            "振込口座略称",
            "仕入先取引区分",
            "連絡担当者氏名",
            "連絡担当者役職",
            "連絡担当者携帯",
            "会計担当者氏名",
            "会計担当者携帯",
            "保証人１氏名",
            "保証人１住所",
            "保証人２氏名",
            "保証人２住所",
            "営業拠点",
            "休日",
            "商圏",
            "契約会社名",
            "契約代表者名",
            "契約年月日",
            "契約更新日",
            "契約期間",
            "契約終了日",
            "創業日",
            "法人登記日",
            "伝票発行",
            "納品書コメント（効果）",
            "納品書コメント",
            "請求書発行",
            "請求書送付",
            "請求書様式",
            "金額:丸め区分",
            "消費税:課税単位",
            "消費税:端数区分",
            "消費税:課税区分",
            "取得資格・得意分野",
            "特約",
            "取引履歴",
            "重要事項",
            "その他",
            "請求書宛先",
          );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/*
//ショップ宛（ALLチェック）
$form->addElement('checkbox', 'form_shop_all', 'チェックボックス', 'ショップ宛',"onClick=\"javascript:All_check('form_shop_all','form_shop_check',$dealing_count)\"");

//代表者宛（ALLチェック）
$form->addElement('checkbox', 'form_staff_all', 'チェックボックス', '代表者宛',"onClick=\"javascript:All_check('form_staff_all','form_staff_check',$dealing_count)\"");

//登録カード（ALLチェック）
$form->addElement('checkbox', 'form_input_all', 'チェックボックス', '登録カード',"onClick=\"javascript:All_check('form_input_all','form_input_check',$dealing_count)\"");

//チェックボックス作成
for($i = 0; $i < $match_count; $i++){
    //ショップ宛
    $form->addElement("checkbox", "form_shop_check[$i]");

    //担当者宛
    $form->addElement("checkbox", "form_staff_check[$i]");

}
*/

//ラベル出力 label output
$javascript  = Create_Allcheck_Js ("All_Label_Check","form_label_check",$ary_shop_id);



#2010-05-13 hashimoto-y
$display_flg = true;
}


/****************************/
//HTMLヘッダ html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= "(取引中".$dealing_count."件/全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定 render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variabl
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assing other variables
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
//テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
