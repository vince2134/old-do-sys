<?php
/*****************************
*変更履歴
*   請求先登録チェック（watanabe-k）
*   (2006-07-31)課税区分の登録変更処理追加（watanabe-k）
*   (2006-08-29)締日と集金日の妥当性チェック(watanabe-k)
*   (2006-09-01)口座IDを登録できるように変更(watanabe-k)
*   (2006-09-09)東陽を得意先として登録する際の請求先を東陽として登録するように変更（watanabe-k）
*   (2006-09-09)本部を仕入先として登録する際の支払月日の登録カラムを変更（watanabe-k）
*   2006/11/13  0033    kaku-m  TEL・FAX番号のチェックを関数で行うように修正。
******************************/

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/11/11　0083　　　　　watanabe-k　FCを登録した際に登録されるショップ別商品情報テーブルの想定されるレコード数が１レコード少ないバグの修正
 *   2006/12/14  kaji-193      kajioka-h   ＴＦＬをＴＥＬに変更
 *   2007/01/23  仕様変更      watanabe-k  ボタンの色を変更
 *   2007/02/19                watanabe-k  登録しようとしているコードを請求先に指定すると請求先が登録されていないバグの修正
 *   2007/02/20                watanabe-k  仕入先用の取引区分を追加
 *   2007/02/21                watanabe-k  FC登録時に支店と部署を登録するように修正
 *   2007/03/14                watanabe-k  親を変更した場合に子のデータも変更するように修正
 *   2007/05/07                watanabe-k  状態のステータス変更
 *   2007/05/07                watanabe-k  請求書パターンの選択項目に個別を追加
 *   2007/05/08                watanabe-k  取引区分が現金の場合集金日を締日に合わせる 
 *   2007/06/08                watanabe-k  取引区分が現金の場合支払日を締日に合わせる 
 *   2009/10/09                hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *   2009/12/25                aoyama-n    課税区分の内税を非課税に変更
 *                                         登録処理で取引先に本部の消費税５項目を設定する
 *   2010-05-01  Rev.1.5　　   hashimoto-y 請求書の宛先フォントサイズ変更機能の追加
 *   2016/01/20                amano  Dialogue, Button_Submit_1 関数でボタン名が送られない IE11 バグ対応
 */

$page_title = "FC・取引先マスタ";

//環境設定ファイル env setting file
require_once("ENV_local.php");

//HTML_QuickFormを作成 create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]","","onSubmit=return confirm(true)");

// DBに接続 connect to 
$conn = Db_Connect();

// 権限チェック auth check
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ no input/edit auth message
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled button
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled delete button
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//新規判別 distinguish if new or not
/****************************/
$shop_id = $_SESSION[client_id];
$staff_id = $_SESSION[staff_id];
if(isset($_GET["client_id"])){
    $get_client_id = $_GET["client_id"];
    $new_flg = false;
}else{
    $new_flg = true;
}

/* GETしたIDの正当性チェック check the validty of the ID that is GET */ 
if ($_GET["client_id"] != null && Get_Id_Check_Db($conn, $_GET["client_id"], "client_id", "t_client", "num", null) != true){
    header("Location: ../top.php");
    exit;
}

/****************************/
//初期値(radio) initial value(radio)
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
//初期設定（GETがある場合）initial value(if there is GET)
/****************************/
if($new_flg == false){
    $select_sql  = "SELECT\n";
    $select_sql .= "    t_client.rank_cd,";             //FCグループ FC group
    $select_sql .= "    t_client.state,";               //状態 status
    $select_sql .= "    t_client.shop_div,";            //本社・支社区分 main company/branch classification
    $select_sql .= "    t_client.client_cd1,";          //ショップコード1 shop code 1
    $select_sql .= "    t_client.client_cd2,";          //ショップコード2 shop code 2
    $select_sql .= "    t_client.client_name,";         //ショップ名 shop name
    $select_sql .= "    t_client.client_read,";         //ショップ名(フリガナ) shop name (katakana)
    $select_sql .= "    t_client.client_cname,";        //略称 abbreviation
    $select_sql .= "    t_client.shop_name,";           //社名 company name
    $select_sql .= "    t_client.shop_read,";           //社名(フリガナ) company name (katakana)
    $select_sql .= "    t_client.post_no1,";            //郵便番号 postal code1
    $select_sql .= "    t_client.post_no2,";            //郵便番号postal code2
    $select_sql .= "    t_client.address1,";            //住所1 address1
    $select_sql .= "    t_client.address2,";            //住所2 address2
    $select_sql .= "    t_client.address_read,";        //住所(フリガナ) address(katakana)
    $select_sql .= "    t_client.area_id,";             //地区 district
    $select_sql .= "    t_client.tel,";                 //TEL 
    $select_sql .= "    t_client.fax,";                 //FAX
    $select_sql .= "    t_client.url,";                 //URL
    $select_sql .= "    t_client_claim.client_cd1,";    //請求先コード1 billing code 1
    $select_sql .= "    t_client_claim.client_cd2,";    //請求先コード2 billing code 2
    $select_sql .= "    t_client_claim.client_name,";   //請求先名 billing name
    $select_sql .= "    t_client.sv_staff_id,";         //SV
    $select_sql .= "    t_client.b_staff_id1,";         //担当１ staff 1
    $select_sql .= "    t_client.b_staff_id2,";         //担当２ staff 2
    $select_sql .= "    t_client.b_staff_id3,";         //担当３ staff 3
    $select_sql .= "    t_client.b_staff_id4,";         //担当４ staff 4
    $select_sql .= "    t_client.rep_name,";            //代表者氏名 name of the representative
    $select_sql .= "    t_client.represe,";             //代表者役職 position of the rep
    $select_sql .= "    t_client.rep_htel,";            //代表者携帯 TEL of the rep
    $select_sql .= "    t_client.charger_name,";        //連絡担当者氏名 name of the contact in person
    $select_sql .= "    t_client.charger,";             //連絡担当者役職 position of the contact in person
    $select_sql .= "    t_client.cha_htel,";            //連絡担当者携帯 TEL of the contact in person
    $select_sql .= "    t_client.surety_name1,";        //保証人１ guarantor 1
    $select_sql .= "    t_client.surety_addr1,";        //保証人１住所 guarantor1 address
    $select_sql .= "    t_client.surety_name2,";        //保証人２ guarantor 2 
    $select_sql .= "    t_client.surety_addr2,";        //保証人２住所 guarantor 2 address
    $select_sql .= "    t_client.trade_base,";          //営業拠点 base where sale is conducted
    $select_sql .= "    t_client.holiday,";             //休日 holdiay
    $select_sql .= "    t_client.trade_area,";          //商圏 trade area
    $select_sql .= "    t_client.join_money,";          //加盟金 joining fee
    $select_sql .= "    t_client.guarant_money,";       //保証金 security deposit
    $select_sql .= "    t_client.royalty_rate,";        //ロイヤリティ royalty
    $select_sql .= "    t_client.cutoff_month,";        //決算月 cutoff month for accounting
    $select_sql .= "    t_client.col_terms,";           //回収条件 collection terms
    $select_sql .= "    t_client.credit_limit,";        //与信限度 credit limit
    $select_sql .= "    t_client.capital,";             //資本金 capital
    $select_sql .= "    t_client.trade_id,";            //取引区分 trade classification
    $select_sql .= "    t_client.close_day,";           //締日 close day
    $select_sql .= "    t_client.pay_m,";               //集金日(月) collection date (month)
    $select_sql .= "    t_client.pay_d,";               //集金日(日) collection date (day) 
    $select_sql .= "    t_client.pay_way,";             //集金方法   collection method
    $select_sql .= "    t_client.pay_name,";            //振込名義   deposit name
    $select_sql .= "    t_client.account_name,";        //口座名義   account name
//    $select_sql .= "    t_client.bank_id,";             //振込銀行 deposit bank
    $select_sql .= "    t_client.account_id,";             //口座ID  account ID
    $select_sql .= "    t_client.c_compa_name,";        //契約会社名 contracted company name
    $select_sql .= "    t_client.c_compa_rep,";         //契約代表名 contracted representative name
    $select_sql .= "    t_client.cont_sday,";           //契約年月日 contract start date
    $select_sql .= "    t_client.cont_eday,";           //契約終了日 contract end date
    $select_sql .= "    t_client.cont_peri,";           //契約期間   contract period
    $select_sql .= "    t_client.cont_rday,";           //契約更新日 contract update date
    $select_sql .= "    t_client.establish_day,";       //創業日     establishment date
    $select_sql .= "    t_client.regist_day,";          //法人登記日 date of registration
    $select_sql .= "    t_client.slip_out,";            //伝票発行   issue slip
    $select_sql .= "    t_client.deliver_note,";        //納品書コメント delivery note comment
    $select_sql .= "    t_client.claim_out,";           //請求書発行 issue billing statement
    $select_sql .= "    t_client.coax,";                //まるめ区分 round up/down
    $select_sql .= "    t_client.tax_div,";             //課税単位   tax unit
    $select_sql .= "    t_client.tax_franct,";          //端数区分   round up/off
    $select_sql .= "    t_client.license,";             //取得資格・得意分野 acquired license/field of expertise
    $select_sql .= "    t_client.s_contract,";          //特約 special clause
    $select_sql .= "    t_client.other,";               //その他 others
    $select_sql .= "    t_client.sbtype_id,";           //業種 industry type
    $select_sql .= "    t_client.inst_id,";             //施設 facility
    $select_sql .= "    t_client.b_struct,";            //業態 business type
    $select_sql .= "    t_client.accountant_name,";     //会計担当者氏名 accounting reprsentative name
    $select_sql .= "    t_client.client_cread,";        //略称(フリガナ) abbreviation (katakana)
    $select_sql .= "    t_client.email,";               //Email
    $select_sql .= "    t_client.direct_tel,";          //直通TEL direct TEL
    $select_sql .= "    t_client.deal_history,";        //取引履歴 trade history
    $select_sql .= "    t_client.importance,";          //重要事項 important items 
    $select_sql .= "    t_client.deliver_effect,";      //納品書コメント(効果) delivery note comment (effect)
    $select_sql .= "    t_client.claim_send,";          //請求書送付(郵送) billing statement send (delivery)
    $select_sql .= "    t_client.cutoff_day,";          //決算日 cutoff day
    $select_sql .= "    t_client.shop_name2,";          //社名 company name
    $select_sql .= "    t_client.shop_read2,";          //社名(フリガナ) company name (katakana)
    $select_sql .= "    t_client.address3,";            //住所2 address 2
    $select_sql .= "    t_client.account_tel,";         //会計担当者 accounting representative name
    $select_sql .= "    t_client.compellation,";        //敬称 compellation
    //$select_sql .= "    t_client.claim_scope,";         //請求範囲 billing scope
    $select_sql .= "    t_client.c_pattern_id,";         //請求書様式 billing format
    $select_sql .= "    t_client.c_tax_div,";            //課税区分 tax classification
    $select_sql .= "    t_account.b_bank_id,";           //支店ID branch bank ID
    $select_sql .= "    t_b_bank.bank_id,";                //銀行ID bank ID
    $select_sql .= "    t_client.bank_name,";           //口座名義 account name
    $select_sql .= "    t_client.b_bank_name,";         //口座名義略称 account name abbreviation
    $select_sql .= "    t_client.payout_m,";            //支払日（月） payment date (month)
    $select_sql .= "    t_client.payout_d,";             //支払日（日）payment date (day)
    $select_sql .= "    t_client.buy_trade_id,";        //取引区分 trade classification 

    #2010-05-01 hashimoto-y
    //請求書宛先フォント billing address font
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
    //クエリ発行 issue query
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    //データ取得 acquire data
    $fc_data = @pg_fetch_array ($result, 0);

    //初期値データ initial value data 
    $defa_data["form_shop_gr_1"]              = $fc_data[0];         //FCグループ FC group
    $defa_data["form_state"]                  = $fc_data[1];         //状態 status
    $defa_data["form_head_fc"]                = $fc_data[2];         //本社・支社区分 main company/branch classification
    $defa_data["form_shop_cd"]["cd1"]         = $fc_data[3];         //ショップコード1 shop code 1
    $defa_data["form_shop_cd"]["cd2"]         = $fc_data[4];         //ショップコード2 shop code 2
    $defa_data["form_shop_name"]              = $fc_data[5];         //ショップ名shop name
    $defa_data["form_shop_read"]              = $fc_data[6];         //ショップ名(フリガナ) shop name (katakana)
    $defa_data["form_shop_cname"]             = $fc_data[7];         //略称 abbreviation
    $defa_data["form_comp_name"]              = $fc_data[8];         //社名 company name
    $defa_data["form_comp_read"]              = $fc_data[9];         //社名(フリガナ) company name (katakana)
    $defa_data["form_post"]["no1"]            = $fc_data[10];        //郵便番号 postal code 1
    $defa_data["form_post"]["no2"]            = $fc_data[11];        //郵便番号　postal code 2
    $defa_data["form_address1"]               = $fc_data[12];        //住所1 address 1
    $defa_data["form_address2"]               = $fc_data[13];        //住所2 address 2
    $defa_data["form_address_read"]           = $fc_data[14];        //住所(フリガナ) address (katakana)
    $defa_data["form_area_1"]                 = $fc_data[15];        //地区 district
    $defa_data["form_tel"]                    = $fc_data[16];        //TEL 
    $defa_data["form_fax"]                    = $fc_data[17];        //FAX
    $defa_data["form_url"]                    = $fc_data[18];        //URL
    $defa_data["form_claim"]["cd1"]           = $fc_data[19];        //請求先コード1 billing code 1
    $defa_data["form_claim"]["cd2"]           = $fc_data[20];        //請求先コード2 billing code 2
    $defa_data["form_claim"]["name"]          = $fc_data[21];        //請求先名 billing name
    $defa_data["form_staff_1"]                = $fc_data[22];        //SV
    $defa_data["form_staff_2"]                = $fc_data[23];        //担当１staff 1
    $defa_data["form_staff_3"]                = $fc_data[24];        //担当２ staff 2
    $defa_data["form_staff_4"]                = $fc_data[25];        //担当３ staff 3
    $defa_data["form_staff_5"]                = $fc_data[26];        //担当４ staff 4
    $defa_data["form_represent_name"]         = $fc_data[27];        //代表者氏名 name of the representative
    $defa_data["form_represent_position"]     = $fc_data[28];        //代表者役職 position of the rep
    $defa_data["form_represent_cell"]         = $fc_data[29];        //代表者携帯 TEL of the rep
    $defa_data["form_contact_name"]           = $fc_data[30];        //連絡担当者氏名 name of the contact in person
    $defa_data["form_contact_position"]       = $fc_data[31];        //連絡担当者役職 position of the contact in person
    $defa_data["form_contact_cell"]           = $fc_data[32];        //連絡担当者携帯 TEL of the contact in person
    $defa_data["form_guarantor1"]             = $fc_data[33];        //保証人１ guarantor 1
    $defa_data["form_guarantor1_address"]     = $fc_data[34];        //保証人１住所 guarantor1 address
    $defa_data["form_guarantor2"]             = $fc_data[35];        //保証人２ guarantor 2 
    $defa_data["form_guarantor2_address"]     = $fc_data[36];        //保証人２住所 guarantor 2 address
    $defa_data["form_position"]               = $fc_data[37];        //営業拠点 base where sale is conducted
    $defa_data["form_holiday"]                = $fc_data[38];        //休日 holdiay
    $defa_data["form_business_limit"]         = $fc_data[39];        //商圏 trade area
    $defa_data["form_join_money"]             = $fc_data[40];        //加盟金 joining fee
    $defa_data["form_assure_money"]           = $fc_data[41];        //保証金 security deposit
    $defa_data["form_royalty"]                = $fc_data[42];        //ロイヤリティ royalty
    $defa_data["form_accounts_month"]         = $fc_data[43];        //決算月 cutoff month for accounting
    $defa_data["form_collect_terms"]          = $fc_data[44];        //回収条件  collection terms
    $["form_limit_money"]            = $fc_data[45];        //与信限度 credit limit
    $defa_data["form_capital_money"]          = $fc_data[46];        //資本金 capital
    $defa_data["trade_aord_1"]                = $fc_data[47];        //取引区分 trade classification
    $defa_data["form_close_1"]                = $fc_data[48];        //締日 close day
    $defa_data["form_pay_month"]              = $fc_data[49];        //集金日(月) collection date (month)
    $defa_data["form_pay_day"]                = $fc_data[50];        //集金日(日) collection date (day) 
    $defa_data["form_pay_way"]                = $fc_data[51];        //集金方法 collection method
    $defa_data["form_transfer_name"]          = $fc_data[52];        //振込名義  deposit name
    $defa_data["form_account_name"]           = $fc_data[53];        //口座名義 account name
//    $defa_data["form_bank_1"]                 = $fc_data[54];        //振込銀行 deposit bank
    $defa_data["form_bank_1"][2]                 = $fc_data[54];        //振込銀行 deposit bank
    $defa_data["form_contract_name"]          = $fc_data[55];        //契約会社名 contracted company name
    $defa_data["form_represent_contract"]     = $fc_data[56];        //契約代表名 contracted representative name
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
    $defa_data["form_cont_s_day"]["y"]        = $cont_s_day[y];      //契約年月日(年) contract start date (year)
    $defa_data["form_cont_s_day"]["m"]        = $cont_s_day[m];      //契約年月日(月) contract start date (month)
    $defa_data["form_cont_s_day"]["d"]        = $cont_s_day[d];      //契約年月日(日) contract start date (day)
    $defa_data["form_cont_e_day"]["y"]        = $cont_e_day[y];      //契約終了日(年) contract end date (year)
    $defa_data["form_cont_e_day"]["m"]        = $cont_e_day[m];      //契約終了日(月) contract end date (month)
    $defa_data["form_cont_e_day"]["d"]        = $cont_e_day[d];      //契約終了日(日) contract end date (day)
    $defa_data["form_cont_peri"]              = $fc_data[59];        //契約期間 contract period
    $defa_data["form_cont_r_day"]["y"]        = $cont_r_day[y];      //契約更新日(年) contract update date (year)
    $defa_data["form_cont_r_day"]["m"]        = $cont_r_day[m];      //契約更新日(月) contract update date (month)
    $defa_data["form_cont_r_day"]["d"]        = $cont_r_day[d];      //契約更新日(日) contract update date (day)
    $defa_data["form_establish_day"]["y"]     = $establish_day[y];   //創業日 establishment date
    $defa_data["form_establish_day"]["m"]     = $establish_day[m];
    $defa_data["form_establish_day"]["d"]     = $establish_day[d];
    $defa_data["form_corpo_day"]["y"]         = $corpo_day[y];       //法人登記日(年) registration date (year)
    $defa_data["form_corpo_day"]["m"]         = $corpo_day[m];       //法人登記日(月) registration date (month)
    $defa_data["form_corpo_day"]["d"]         = $corpo_day[d];       //法人登記日(日) registration date (day)
    $defa_data["form_slip_issue"]             = $fc_data[63];        //伝票発行 issue slip
    $defa_data["form_deli_comment"]           = $fc_data[64];        //納品書コメント delivery note comment
    $defa_data["form_claim_issue"]            = $fc_data[65];        //請求書発行 issue billing statement
    $defa_data["form_coax"]                   = $fc_data[66];        //まるめ区分 round up/down
    $defa_data["form_tax_unit"]               = $fc_data[67];        //課税単位 tax unit
    $defa_data["from_fraction_div"]           = $fc_data[68];        //端数区分 round up/off
    $defa_data["form_qualify_pride"]          = $fc_data[69];        //取得資格・得意分野 acquired license/field of expertise
    $defa_data["form_special_contract"]       = $fc_data[70];        //特約 special clause
    $defa_data["form_other"]                  = $fc_data[71];        //その他 others
    $defa_data["form_btype"]                  = $fc_data[72];        //業種 industry type
    $defa_data["form_inst"]                   = $fc_data[73];        //施設 facility
    $defa_data["form_bstruct"]                = $fc_data[74];        //業態 business type
    $defa_data["form_accountant_name"]        = $fc_data[75];        //会計担当者氏名 accounting reprsentative name
    $defa_data["form_cname_read"]             = $fc_data[76];        //略称(フリガナ) abbreviation (katakana)
    $defa_data["form_email"]                  = $fc_data[77];        //Email
    $defa_data["form_direct_tel"]             = $fc_data[78];        //直通TEL direct TEL
    $defa_data["form_record"]                 = $fc_data[79];        //取引履歴 trade history
    $defa_data["form_important"]              = $fc_data[80];        //重要事項 important items 
    $defa_data["form_deliver_radio"]          = $fc_data[81];        //納品書コメント(効果) delivery note comment (effect)
    $defa_data["form_claim_send"]             = $fc_data[82];        //請求書送付 billing statement send (delivery)
    $defa_data["form_accounts_day"]           = $fc_data[83];        //決算日 cutoff day
    $defa_data["form_comp_name2"]             = $fc_data[84];        //社名2  company name 2
    $defa_data["form_comp_read2"]             = $fc_data[85];        //社名(フリガナ)2 company name (katakana) 2
    $defa_data["form_address3"]               = $fc_data[86];        //住所3 address 2
    $defa_data["form_account_tel"]            = $fc_data[87];        //会計担当者携帯 accounting representative TEL
    $defa_data["form_prefix"]                 = $fc_data[88];        //敬称 compellation
    //$defa_data["form_claim_scope"]            = $fc_data[89];        //請求範囲 billing scope
    $defa_data["claim_pattern"]               = $fc_data[89];        //請求書様式 billing format
    $defa_data["form_rank"]                   = $fc_data[0];        //顧客区分 customer classification
    $defa_data["form_c_tax_div"]              = $fc_data["c_tax_div"];//課税区分 tax classificaiton
    $defa_data["form_bank_1"][1]              = $fc_data["b_bank_id"];  //支店ID branch bank ID
    $defa_data["form_bank_1"][0]              = $fc_data["bank_id"];    //銀行ID bank ID
    $defa_data["form_bank_name"]              = $fc_data["bank_name"];  //振込口座名義 deposit account name
    $defa_data["form_b_bank_name"]            = $fc_data["b_bank_name"]; //振込口座名略称 deposit acct abbreviation
    $defa_data["form_payout_day"]               = $fc_data["payout_d"];
    $defa_data["form_payout_month"]               = $fc_data["payout_m"];
    $defa_data["trade_buy_1"]                = $fc_data["buy_trade_id"];

    #2010-05-01 hashimoto-y
    $defa_data["form_bill_address_font"]      = ($fc_data["bill_address_font"] == 't')? 1 : 0;

    //初期値設定 initial value setting                                         
    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "shop", $fc_data[3].",".$fc_data[4]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    //自分が他のFCの請求先として登録されているか If you are registered as a billing clinet in other FC
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

    //変更可能判定 determine if editable
    if($claim_num > 0){
        $change_flg = true;
    }else{
        $change_flg = false;
    }

    //変更するショップのグループの種別を抽出 extract the group type of the shop that will be edited
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
    //自動採番のショップコード取得 acquire the autoincrement shopcode
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
	//コードの限界値の場合は自動採番しない if its the max limit of the code then do not auto increment
	if($client_cd1 != '999999'){
		$client_cd1 = $client_cd1 +1;
		$client_cd1 = str_pad($client_cd1, 6, 0, STR_PAD_LEFT);

		$defa_data["form_shop_cd"]["cd1"] = $client_cd1;
        $defa_data["form_shop_cd"]["cd2"] = '0000';
        $form->setDefaults($defa_data);
	}
}

//システムコードからFC・取引先区分を取得・表示
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
//フォーム生成
/****************************/
//FC・取引先区分 FC trade classification
//新規登録 new registration
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
//直営 directly managed store (HQ's FC)
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
//その他FC other FC
}else{
    //全商品について単価を設定しているか確認 check if all products have their price set
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

    //商品に単価を設定している場合 if the products are set with their price
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
    //商品に単価を設定していない場合 if they are not priced
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

    $select_value["$rank_cd"] = $rank_cd."　：　".$rank_name;
}

//顧客区分コード customer classification code
$freeze = $form->addElement(
		"select","form_rank","", $select_value, $g_form_option_select);
if($new_flg != true){
    $freeze->freeze();
}

//ショップコード shop code
$form_shop_cd[] =& $form->createElement(
        "text","cd1","テキストフォーム","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_shop_cd[cd1]','form_shop_cd[cd2]',6)\" $g_form_option"
         );
$form_shop_cd[] =& $form->createElement(
        "static","","","-"
        );
$form_shop_cd[] =& $form->createElement(
        "text","cd2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        $g_form_option"
        );
$form->addGroup($form_shop_cd, "form_shop_cd", "form_shop_cd");

// 得意先コード空きコード検索リンク customer code blank code search link
$form->addElement("link", "form_cd_search", "", "#", "空きコード検索", "tabindex=\"-1\" 
    onClick=\"javascript:return Open_SubWin('../dialog/1-0-103.php', Array('form_shop_cd[cd1]','form_shop_cd[cd2]'), 570, 650, 3, 1);\"
");

//郵便番号 postal code
$form_post[] =& $form->createElement(
        "text","no1","テキストフォーム","size=\"3\" maxLength=\"3\"  style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        $g_form_option"
        );
$form->addGroup( $form_post, "form_post", "form_post");

//請求先 billing address
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

//契約年月日 contract date
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

//契約終了日 contract end date
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

//契約期間 contract period
$form->addElement(
        "text","form_cont_peri","","size=\"2\" maxLength=\"2\" style=\"text-align: right; $g_form_style\"
        onkeyup=\"Contract(this.form)\" $g_form_option"
        );

//契約更新日 contract update date
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

//創業日 establishment date
$form_establish_day[] =& $form->createElement(
        "text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_establish_day[y]','form_establish_day[m]',4)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_establish_day[] =& $form->createElement(
        "text","m","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_establish_day[m]','form_establish_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_establish_day[] =& $form->createElement(
        "static","","","-"
        );
$form_establish_day[] =& $form->createElement(
        "text","d","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_establish_day,"form_establish_day","form_establish_day");

//法人登記日 registration date
$form_corpo_day[] =& $form->createElement(
        "text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_corpo_day[y]','form_corpo_day[m]',4)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_corpo_day[] =& $form->createElement(
        "static","","","-"
        );
$form_corpo_day[] =& $form->createElement(
        "text","m","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_corpo_day[m]','form_corpo_day[d]',2)\" 
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form_corpo_day[] =& $form->createElement(
        "static","","","-"
        );
$form_corpo_day[] =& $form->createElement(
        "text","d","テキストフォーム","size=\"2\" maxLength=\"2\" style=\"$g_form_style\"
        onchange=\"Contract(this.form)\"".$g_form_option."\""
        );
$form->addGroup( $form_corpo_day,"form_corpo_day","form_corpo_day");

//ショップ名 shop name
$form->addElement(
        "text","form_shop_name","テキストフォーム","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//ショップ名(フリガナ) shop name (katakana)
$form->addElement(
        "text","form_shop_read","テキストフォーム","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//略称 abbreviation
$form->addElement(
        "text","form_shop_cname","テキストフォーム","size=\"40\" maxLength=\"20\" 
        $g_form_option"
        );

//略称（フリガナ） abbreviation (katakana)
$form->addElement(
        "text","form_cname_read","",'size="40" maxLength="40"'." $g_form_option"
        );

//敬称 compellation
$form_prefix_radio[] =& $form->createElement( "radio",NULL,NULL, "御中","1");
$form_prefix_radio[] =& $form->createElement( "radio",NULL,NULL, "様","2");
$form->addGroup($form_prefix_radio,"form_prefix","");
     
//社名 company name
$form->addElement(
        "text","form_comp_name","テキストフォーム","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//社名(フリガナ) company name (katakana)
$form->addElement(
        "text","form_comp_read","テキストフォーム","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//社名2 company name 2
$form->addElement(
        "text","form_comp_name2","テキストフォーム","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//社名2(フリガナ) company name 2 (katakana)
$form->addElement(
        "text","form_comp_read2","テキストフォーム","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//住所1 address 1
$form->addElement(
        "text","form_address1","テキストフォーム","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );
 
//住所2 address 2 
$form->addElement(
        "text","form_address2","テキストフォーム","size=\"40\" maxLength=\"25\" 
        $g_form_option"
        );

//住所3 address 3
$form->addElement(
        "text","form_address3","",'size="40" maxLength="30"'." $g_form_option"
        );

//住所(フリガナ) address (katakana)
$form->addElement(
        "text","form_address_read","テキストフォーム","size=\"40\" maxLength=\"50\" 
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
        "text","form_url","テキストフォーム","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//代表者氏名 representative name
$form->addElement(
        "text","form_represent_name","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//代表者役職 representative position
$form->addElement(
        "text","form_represent_position","テキストフォーム","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//直通TEL direct TEL
$form->addElement(
        "text","form_direct_tel","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option"
        );

//代表者携帯 representative TEL
$form->addElement(
        "text","form_represent_cell","","size=\"34\" maxLength=\"30\" style=\"$g_form_style\" 
        $g_form_option"
        );

//連絡担当者氏名 contact in person name
$form->addElement(
        "text","form_contact_name","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//連絡担当者役職 contact in person position
$form->addElement(
        "text","form_contact_position","テキストフォーム","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//連絡担当者携帯 contact in person TEL
$form->addElement(
        "text","form_contact_cell","テキストフォーム","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//会計担当者氏名 accountant staff name
$form->addElement(
        "text","form_accountant_name","テキストフォーム","size=\"34\" maxLength=\"10\" 
        $g_form_option"
        );
//会計担当者携帯 accountant staff TEL
$form->addElement(
        "text","form_account_tel","テキストフォーム","size=\"34\" maxLength=\"30\" style=\"$g_form_style\"
        $g_form_option"
        );

//保証人１ guarantor 1
$form->addElement(
        "text","form_guarantor1","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//保証人１住所 guarantor1 address
$form->addElement(
        "text","form_guarantor1_address","テキストフォーム","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//保証人２ guarantor 2 
$form->addElement(
        "text","form_guarantor2","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//保証人２住所 guarantor 2 address
$form->addElement(
        "text","form_guarantor2_address","テキストフォーム","size=\"40\" maxLength=\"50\" 
        $g_form_option"
        );

//営業拠点 base where sale is conducted
$form->addElement(
        "text","form_position","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//休日 holdiay
$form->addElement(
        "text","form_holiday","テキストフォーム","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//商圏 trade area
$form->addElement(
        "text","form_business_limit","テキストフォーム","size=\"22\" maxLength=\"10\" 
        $g_form_option"
        );

//加盟金 joining fee
$form->addElement(
        "text","form_join_money","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\" 
         style=\"text-align: right; $g_form_style\" ".$g_form_option."\""
        );

//保証金 security deposit
$form->addElement(
        "text","form_assure_money","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\" 
         style=\"text-align: right; $g_form_style\"".$g_form_option."\""
        );

//ロイヤリティ royalty
$form->addElement(
        "text","form_royalty","テキストフォーム","size=\"3\" maxLength=\"3\" 
         style=\"text-align: right; $g_form_style\"".$g_form_option."\""
        );

//決算月 cutoff month for accounting
$form->addElement(
        "text","form_accounts_month","テキストフォーム","size=\"2\" maxLength=\"2\"  style=\"text-align: right; $g_form_style\"
        ".$g_form_option."\""
        );

//決算日cutoff dayfor accounting
$form->addElement(
        "text","form_accounts_day","テキストフォーム","size=\"2\" maxLength=\"2\"  style=\"text-align: right; $g_form_style\"
        ".$g_form_option."\""
        );

//回収条件 collection terms
$form->addElement(
        "text","form_collect_terms","テキストフォーム","size=\"34\" maxLength=\"50\" 
        $g_form_option"
        );

//与信限度 credit limit
$form->addElement(
        "text","form_limit_money","テキストフォーム","class=\"money\" size=\"11\" maxLength=\"9\" 
         style=\"text-align: right; $g_form_style\"".$g_form_option."\""
        );

//資本金 capital
$form->addElement(
        "text","form_capital_money","",
        "class=\"money\" size=\"11\" maxLength=\"9\" 
        style=\"text-align: right; $g_form_style\"".$g_form_option.""
        );

//集金日 collection date
//集金日 collection date
//月 month
$select_month[null] = null;
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "当月";
    }elseif($i == 1){
        $select_month[1] = "翌月";
    }else{
        $select_month[$i] = $i."ヶ月後";
    }
}
$form->addElement("select", "form_pay_month", "セレクトボックス", $select_month, $g_form_option_select);

//日 day
for($i = 0; $i <= 29; $i++){
    if($i == 29){
        $select_day[$i] = '月末';
    }elseif($i == 0){
        $select_day[null] = null;
    }else{
        $select_day[$i] = $i."日";
    }
}
$form->addElement("select", "form_pay_day", "セレクトボックス", $select_day, $g_form_option_select);

//集金方法 collection method
$select_value = Select_Get($conn,'pay_way');
$form->addElement(
        "select","form_pay_way","", $select_value,$g_form_option_select
        );

//振込名義 deposit name
$form->addElement(
        "text","form_transfer_name","テキストフォーム","size=\"34\" maxLength=\"50\" 
        $g_form_option"
        );

//口座名義 account name
$form->addElement(
        "text","form_account_name","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//契約会社名 contract company name
$form->addElement(
        "text","form_contract_name","テキストフォーム","size=\"40\" maxLength=\"30\" 
        $g_form_option"
        );

//契約代表者名 contracted representative name
$form->addElement(
        "text","form_represent_contract","テキストフォーム","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//納品書コメント delivery note comment
//ラヂオボタン radio button
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "コメント無効","1");
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "個別コメント有効","2");
$form_deliver_radio[] =& $form->createElement( "radio",NULL,NULL, "全体コメント有効","3");
$form->addGroup($form_deliver_radio, "form_deliver_radio", "");
//テキスト text
$form->addElement("textarea","form_deli_comment","",' rows="5" cols="75"'." $g_form_option_area");

//取引履歴 trade history
$form->addElement("textarea","form_record","",' rows="3" cols="75"'." $g_form_option_area");

//重要事項 important items 
$form->addElement("textarea","form_important","",' rows="3" cols="75"'." $g_form_option_area");

//地区 district
$select_ary = Select_Get($conn,'area');
$form->addElement('select', 'form_area_1',"", $select_ary,$g_form_option_select);

//業種 induistry type
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
                $data_list[1] = $data_list[1]."　";
        }
    }
    $select_value2[$data_list[2]] = $data_list[0]." ： ".$data_list[1]."　　 ".$data_list[3]." ： ".$data_list[4];
}

$form->addElement('select', 'form_btype',"", $select_value2,$g_form_option_select);

//施設 facility
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
    $select_value3[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
$form->addElement('select', 'form_inst',"", $select_value3,$g_form_option_select);

//業態 business type
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
    $select_value4[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
$form->addElement('select', 'form_bstruct',"", $select_value4,$g_form_option_select);

//担当者 staff
for($x=1;$x<=5;$x++){
$select_value5 = Select_Get($conn,'staff');
$form->addElement('select', 'form_staff_'.$x, 'セレクトボックス', $select_value5,$g_form_option_select);
}

//取引区分 trade classification
$select_value6 = Select_Get($conn,'trade_aord');
$form->addElement('select', 'trade_aord_1', 'セレクトボックス', $select_value6, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_close_day();\"");

//取引区分 trade classification
$select_value6 = Select_Get($conn,'trade_ord');
$form->addElement('select', 'trade_buy_1', 'セレクトボックス', $select_value6, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_buy_close_day();\"");

//締日 closing date
$select_value7 = Select_Get($conn,'close');
$freeze = $form->addElement('select', 'form_close_1', 'セレクトボックス', $select_value7, 
        "onKeyDown=\"chgKeycode();\" 
        onChange =\"window.focus();trade_close_day();trade_buy_close_day()\"");


$select_ary = Make_Ary_Bank($conn);
$bank_select = $form->addElement('hierselect', 'form_bank_1', '',$g_form_option_select ,"　　　");
$bank_select->setOptions(array($select_ary[0], $select_ary[1], $select_ary[2]));


//状態 status
$text = null;
$text[] =& $form->createElement( "radio",NULL,NULL, "取引中","1");
$text[] =& $form->createElement( "radio",NULL,NULL, "解約・休止中","2");
//$text[] =& $form->createElement( "radio",NULL,NULL, "解約","3");
$form->addGroup($text, "form_state", "");

//伝票番号 slip number
$form_slip_issue[] =& $form->createElement("radio",NULL,NULL, "有","1");
$form_slip_issue[] =& $form->createElement("radio",NULL,NULL, "指定","2");
$form_slip_issue[] =& $form->createElement("radio",NULL,NULL, "無","3");
$form->addGroup($form_slip_issue, "form_slip_issue", "伝票番号");

#2010-05-01 hashimoto-y
// 請求書宛先フォント大 billing address font large
$form->addElement("checkbox", "form_bill_address_font", "");


//請求書発行 issue billing slip
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "明細請求書","1");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "合計請求書","2");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "個別明細請求書","5");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "出力しない","3");
$form_claim_issue[] =& $form->createElement("radio",NULL,NULL, "指定","4");
$form->addGroup($form_claim_issue, "form_claim_issue", "請求書発行");
/*
//請求範囲 billing cope
$form_claim_scope[] =& $form->createElement( "radio",NULL,NULL, "繰越額を含める","t");
$form_claim_scope[] =& $form->createElement( "radio",NULL,NULL, "繰越額を含めない","f");
$form->addGroup($form_claim_scope, "form_claim_scope", "");
*/
//請求書送付 send billing slip
$form_claim_send[] =& $form->createElement( "radio",NULL,NULL, "郵送","1");
$form_claim_send[] =& $form->createElement( "radio",NULL,NULL, "メール","2");
$form_claim_send[] =& $form->createElement( "radio",NULL,NULL, "両方","3");
$form->addGroup($form_claim_send, "form_claim_send", "");

//請求書様式 billing format
$select_value = Select_Get($conn,'claim_pattern');
$form->addElement("select","claim_pattern","",$select_value);

//まるめ区分 round up/down
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "切捨","1"
         );
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "四捨五入","2"
         );
$form_coax[] =& $form->createElement(
         "radio",NULL,NULL, "切上","3"
         );
$freeze = $form->addGroup($form_coax, "form_coax", "まるめ区分");
//if($change_flg == true){
//    $freeze->freeze();
//}

//課税区分 tax classification
$form_tax_division[] =& $form->createElement(
         "radio",NULL,NULL, "外税","1"
         );
$form_tax_division[] =& $form->createElement(
         "radio",NULL,NULL, "内税","2"
         );
$form_tax_division[] =& $form->createElement(
         "radio",NULL,NULL, "非課税","3"
         );
$freeze = $form->addGroup($form_tax_division, "form_tax_div", "課税区分");
//if($change_flg == true){
//    $freeze->freeze();
//}

//課税単位 tax unit
$form_tax_unit[] =& $form->createElement(
         "radio",NULL,NULL, "締日単位","1"
         );
$form_tax_unit[] =& $form->createElement(
         "radio",NULL,NULL, "伝票単位","2"
         );
$freeze = $form->addGroup($form_tax_unit, "form_tax_unit", "課税単位");
//if($change_flg == true){
//    $freeze->freeze();
//}

//端数区分 round up/down
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "切捨","1"
         );
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "四捨五入","2"
         );
$from_fraction_div[] =& $form->createElement(
         "radio",NULL,NULL, "切上","3"
         );
$freeze = $form->addGroup($from_fraction_div, "from_fraction_div", "端数区分");
//if($change_flg == true){
//    $freeze->freeze();
//}

//課税区分 tax classification
$form_c_tax_div[] =& $form->createElement(
         "radio",NULL,NULL, "外税","1"
         );
#2009-12-25 aoyama-n
#$form_c_tax_div[] =& $form->createElement(
#         "radio",NULL,NULL, "内税","2"
#         );
$form_c_tax_div[] =& $form->createElement(
         "radio",NULL,NULL, "非課税","3"
         );
$freeze = $form->addGroup($form_c_tax_div, "form_c_tax_div", "課税区分");
//if($change_flg == true){
//一時的にフリーズ
#    $freeze->freeze();
//}
#2009-12-25 aoyama-n
if($new_flg == false){
    $freeze->freeze();
}

//取得資格・得意分野 acquired license/field of expertise
$form->addElement("textarea","form_qualify_pride","テキストフォーム"," rows=\"2\" cols=\"75\" $g_form_option_area");

//特約 special clause
$form->addElement("textarea","form_special_contract","テキストフォーム"," rows=\"2\" cols=\"75\" $g_form_option_area");

//その他 others
$form->addElement("textarea","form_other","テキストフォーム"," rows=\"2\" cols=\"75\" $g_form_option_area");

//登録（ヘッダ） registration (header)
$form->addElement("button","new_button","登録画面",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//変更・一覧 edit/list
$form->addElement("button","change_button","変更・一覧","onClick=\"javascript:Referer('1-1-101.php')\"");

//hidden
$form->addElement("hidden", "input_button_flg");

//ショップを仕入先として扱う場合のフォーム form when the shop will be used as a supplier
//支払日 payment day
//支払月 payment month
//月month
$select_month[null] = null;
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[0] = "当月";
    }elseif($i == 1){
        $select_month[1] = "翌月";
    }else{
        $select_month[$i] = $i."ヶ月後";
    }
}
$form->addElement("select", "form_payout_month", "セレクトボックス", $select_month, $g_form_option_select);

//日 day
for($i = 0; $i <= 29; $i++){
    if($i == 29){
        $select_day[$i] = '月末';
    }elseif($i == 0){
        $select_day[null] = null;
    }else{
        $select_day[$i] = $i."日";
    }
}
//$form->addElement("select", "form_payout_day", "セレクトボックス", $select_month, $g_form_option_select);
$form->addElement("select", "form_payout_day", "セレクトボックス", $select_day, $g_form_option_select);

//銀行 bank
$form->addElement('text', 'form_bank_name', '', "size=\"95\" maxLength=\"40\" $g_form_option");

//支店名 branch bank name
$form->addElement("text", "form_b_bank_name", "","size=\"47\" maxlength=\"20\" $g_form_option");


/***************************/
//ルール作成（QuickForm）create rules
/***************************/
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->registerRule("telfax","function","Chk_Telfax");
//■FCグループ FC group
//●必須チェック required field
//$form->addRule("form_shop_gr_1", "FCグループを選択してください。","required");
$form->addRule("form_rank", "FC・取引先区分を選択して下さい。","required");

//■業種 industry 
//●必須チェック required field
$form->addRule("form_btype", "業種を選択して下さい。","required");

//■ショップコード shop code
//●必須チェック required field
//●半角数字チェック hald width number check
$form->addGroupRule('form_shop_cd', array(
        'cd1' => array(
                array('ショップコードは半角数字のみです。', 'required'),
                array('ショップコードは半角数字のみです。', "regex", "/^[0-9]+$/")
        ),
        'cd2' => array(
                array('ショップコードは半角数字のみです。','required'),
                array('ショップコードは半角数字のみです。',"regex", "/^[0-9]+$/")
        ),
));

//■ショップ名 shop name
//●必須チェック required field
$form->addRule("form_shop_name", "ショップ名は1文字以上25文字以下です。","required");
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_shop_name", "ショップ名に スペースのみの登録はできません。", "no_sp_name");

//■略称 abbreviation
//●必須チェック required field
$form->addRule("form_shop_cname", "略称は1文字以上20文字以下です。","required");
$form->addRule("form_shop_cname", "略称に スペースのみの登録はできません。", "no_sp_name");

//■社名 comopany name
//●必須チェック required field
$form->addRule("form_comp_name", "社名は1文字以上25文字以下です。","required");

//■郵便番号 postal code 
//●必須チェック required field
//●半角数字チェック half width number check
//●文字数チェック check number of letters
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('郵便番号は半角数字のみ7桁です。', 'required'),
                array('郵便番号は半角数字のみ7桁です。', "regex", "/^[0-9]+$/"),
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('郵便番号は半角数字のみ7桁です。','required'),
                array('郵便番号は半角数字のみ7桁です。',"regex", "/^[0-9]+$/"),
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(4,4))
        ),
));

//■住所１ address 1
//●必須チェック required field
$form->addRule("form_address1", "住所１は1文字以上25文字以下です。","required");

//■地区 map 
//●必須チェック required field
$form->addRule("form_area_1", "地区を選択して下さい。","required");

//■TEL
//●必須チェック required field
//●半角数字チェック half width number check
$form->addRule("form_tel", "TELは半角数字と｢-｣のみ30桁以内です。", "required");
$form->addRule("form_tel","TELは半角数字と｢-｣のみ30桁以内です。","telfax");

//■代表者氏名 representative name
//●必須チェック required field
$form->addRule("form_represent_name", "代表者氏名は1文字以上15文字以下です。","required");

//■加盟金 joining fee
//●半角数字チェック half width number check
$form->addRule("form_join_money", "加盟金は半角数字のみです。","regex", "/^[0-9]+$/");

//■保証金 security deposit
//●半角数字チェック half width number check
$form->addRule("form_assure_money", "保証金は半角数字のみです。","regex", "/^[0-9]+$/");

//■ロイヤリティ royalty
//●必須チェック required field
//●半角数字チェック half width number check
$form->addRule("form_royalty", "ロイヤリティは半角数字のみ1文字以上3文字以下です。","required");
$form->addRule("form_royalty", "ロイヤリティは半角数字のみ1文字以上3文字以下です。","regex", "/^[0-9]+$/");

//■決算月 cut off month
//●半角数字チェック half width number check
$form->addRule("form_accounts_month", "決算月は半角数字のみです。","regex", "/^[0-9]+$/");

//■与信限度 credit limit
//●半角数字チェック half width number check
$form->addRule("form_limit_money", "与信限度は半角数字のみです。","regex", "/^[0-9]+$/");

//■資本金 capital 
//●半角数字チェック half width number check
$form->addRule("form_capital_money", "資本金は半角数字のみです。","regex", "/^[0-9]+$/");

//■締日 close day
//●必須チェック required field
$form->addRule("form_close_1", "締日を選択してください。","required");

//■取引区分 trade classifciation
//●必須チェック required field
$form->addRule("trade_aord_1", "得意先用の取引区分を選択してください。","required");

//■取引区分 trade classification
//●必須チェック required field
$form->addRule("trade_buy_1", "仕入先用の取引区分を選択してください。","required");

//■集金日（月） collection date (month)
//●必須チェック required field
//●半角数字チェック half width number check
$form->addRule("form_pay_month", "集金日（月）を選択して下さい。", "required");

//■集金日（日）collection date (day)
//●必須チェック required field
//●半角数字チェック half width number check
$form->addRule("form_pay_day", "集金日（日）を選択して下さい。", "required");

//■契約年月日 contract date
//●半角数字チェック half width number check
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(
                array('契約年月日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('契約年月日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('契約年月日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
));
//■契約期間 contract period 
//●半角数字チェック half width number check
$form->addRule("form_cont_peri", "契約期間は半角数字のみです。", "regex", "/^[0-9]+$/");

//■契約更新日 contract update date
//●半角数字チェック half width number check
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(
                array('契約更新日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('契約更新日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('契約更新日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
));

//■創業日 establishment date
//●半角数字チェック half width number check
$form->addGroupRule('form_establish_day', array(
        'y' => array(
                array('創業日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('創業日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('創業日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
));

//■法人登記日 registration date
//●半角数字チェック half width number check
$form->addGroupRule('form_corpo_day', array(
        'y' => array(
                array('法人登記日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'm' => array(
                array('法人登記日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
        'd' => array(
                array('法人登記日の日付は妥当ではありません。',"regex", "/^[0-9]+$/")
        ),
));

//■納品書コメント delivery note comment
//●文字数チェック number of letters check
$form->addRule("form_deli_comment", "納品書コメントは50文字以内です。", "mb_maxlength",'50');

//■集金日（月） collection date (month)
//●必須チェック required fiedl
//●半角数字チェック half width number check
$form->addRule("form_payout_month", "支払日（月）を選択して下さい。", "required");

//■集金日（日） collection date (day)
//●必須チェック required field 
//●半角数字チェック half width number check
$form->addRule("form_payout_day", "支払日（日）を選択して下さい。", "required");
/***************************/
//ルール作成（PHP） create rules PHP
/***************************/
if($_POST["button"]["entry_button"] == "登　録"){

    /****************************/
    //POST取得 acquire POST
    /****************************/
    $rank_cd             = $_POST["form_rank"];                //顧客区分コード customer classification code
    $form_state          = $_POST["form_state"];               //状態 status 
    $shop_cd1            = $_POST["form_shop_cd"]["cd1"];      //ショップコード1 shop code 1
    $shop_cd2            = $_POST["form_shop_cd"]["cd2"];      //ショップコード2 shop code 2
    $shop_name           = $_POST["form_shop_name"];           //ショップ名 shop name
    $shop_name_read      = $_POST["form_shop_read"];           //ショップ名(フリガナ) shop name (katakana)
    $shop_cname          = $_POST["form_shop_cname"];          //略称 abbreviation
    $comp_name           = $_POST["form_comp_name"];           //社名 company name
    $comp_name_read      = $_POST["form_comp_read"];           //社名(フリガナ) company name (katkana)
    $comp_name2          = $_POST["form_comp_name2"];          //社名 company name
    $comp_name_read2     = $_POST["form_comp_read2"];          //社名(フリガナ) company name (katkana)
    $post_no1            = $_POST["form_post"]["no1"];         //郵便番号 psotal code
    $post_no2            = $_POST["form_post"]["no2"];         //郵便番号 postal code
    $address1            = $_POST["form_address1"];            //住所1 address 1
    $address2            = $_POST["form_address2"];            //住所2 address 2
    $address3            = $_POST["form_address3"];            //住所2 address 2
    $address_read        = $_POST["form_address_read"];        //住所(フリガナ) address (kataakna)
    $area_id             = $_POST["form_area_1"];              //地区 district
    $tel                 = $_POST["form_tel"];                 //TEL 
    $fax                 = $_POST["form_fax"];                 //FAX
    $url                 = $_POST["form_url"];                 //URL
    $claim_cd1           = $_POST["form_claim"]["cd1"];        //請求先コード1 billing code 1
    $claim_cd2           = $_POST["form_claim"]["cd2"];        //請求先コード2 billing code 2
    $claim_name          = $_POST["form_claim"]["name"];       //請求先名 billing name
    $sv                  = $_POST["form_staff_1"];             //SV 
    $staff1              = $_POST["form_staff_2"];             //担当１ staff
    $staff2              = $_POST["form_staff_3"];             //担当２ staff
    $staff3              = $_POST["form_staff_4"];             //担当３ staff
    $staff4              = $_POST["form_staff_5"];             //担当４ staff
    $represent_name      = $_POST["form_represent_name"];      //代表者氏名 representative name
    $represent_position  = $_POST["form_represent_position"];  //代表者役職 representative position
    $represent_cell      = $_POST["form_represent_cell"];      //代表者携帯 representative tel
    $contact_name        = $_POST["form_contact_name"];        //連絡担当者氏名 contact in person name
    $contact_position    = $_POST["form_contact_position"];    //連絡担当者役職 contact in person position
    $contact_cell        = $_POST["form_contact_cell"];        //連絡担当者携帯 contact in person TEL
    $guarantor1          = $_POST["form_guarantor1"];          //保証人１ guarantor 1
    $guarantor1_address  = $_POST["form_guarantor1_address"];  //保証人１住所 guarantor 1 address
    $guarantor2          = $_POST["form_guarantor2"];          //保証人２ guarantor 2
    $guarantor2_address  = $_POST["form_guarantor2_address"];  //保証人２住所 guarantor 2 address
    $position            = $_POST["form_position"];            //営業拠点 base where sale is conducted
    $holiday             = $_POST["form_holiday"];             //休日 holdiay
    $business_limit      = $_POST["form_business_limit"];      //商圏 trade area
    $join_money          = $_POST["form_join_money"];          //加盟金 joining fee
    $assure_money        = $_POST["form_assure_money"];        //保証金 security deposit
    $royalty             = $_POST["form_royalty"];             //ロイヤリティ royalty
    $accounts_month      = $_POST["form_accounts_month"];      //決算月 cutoff month for accounting
    $collect_terms       = $_POST["form_collect_terms"];       //回収条件 collection terms
    $limit_money         = $_POST["form_limit_money"];         //与信限度 credit limit
    $capital_money       = $_POST["form_capital_money"];       //資本金 capital
    $aord_div            = $_POST["trade_aord_1"];             //得意先用取引区分 for customer trade classification
    $buy_div             = $_POST["trade_buy_1"];              //仕入先用取引区分 supplier trade classification
    $close_day           = $_POST["form_close_1"];             //締日 close day
    $pay_month           = $_POST["form_pay_month"];           //集金日(月) collection date (month)
    $pay_day             = $_POST["form_pay_day"];             //集金日(日) collection date (day)
    $pay_way             = $_POST["form_pay_way"];             //集金方法 collection method
    $transfer_name       = $_POST["form_transfer_name"];       //振込名義 deposit name 
    $account_name        = $_POST["form_account_name"];        //口座名義 account name
    $bank                = $_POST["form_bank_1"][2];              //振込銀行 desposit bank
    $contract_name       = $_POST["form_contract_name"];       //契約会社名 contract company name
    $represent_contract  = $_POST["form_represent_contract"];  //契約代表名 contract representative name
    $cont_s_day          = $_POST["form_cont_s_day"]["y"];     //契約年月日(年) contract start date (year)
    $cont_s_day         .= "-";
    $cont_s_day         .= $_POST["form_cont_s_day"]["m"];     //契約年月日(月) contract start date (month)
    $cont_s_day         .= "-";
    $cont_s_day         .= $_POST["form_cont_s_day"]["d"];     //契約年月日(日) contract start date (day)
    $cont_e_day          = $_POST["form_cont_e_day"]["y"];     //契約終了日(年) contract end day (year)
    $cont_e_day         .= "-";
    $cont_e_day         .= $_POST["form_cont_e_day"]["m"];     //契約終了日(月) contract end day (month)
    $cont_e_day         .= "-";
    $cont_e_day         .= $_POST["form_cont_e_day"]["d"];     //契約終了日(日) contract end day (day)
    $cont_peri           = $_POST["form_cont_peri"];           //契約期間 contract period
    $cont_r_day          = $_POST["form_cont_r_day"]["y"];     //契約更新日(年) contract update date (year)
    $cont_r_day         .= "-";
    $cont_r_day         .= $_POST["form_cont_r_day"]["m"];     //契約更新日(月) contract update date (month)
    $cont_r_day         .= "-";
    $cont_r_day         .= $_POST["form_cont_r_day"]["d"];     //契約更新日(日) contract update date (day)
    $establish_day       = $_POST["form_establish_day"]["y"];  //創業日(年) establishment date (year)
    $establish_day      .= "-";
    $establish_day      .= $_POST["form_establish_day"]["m"];  //創業日(月) establishment date (month)
    $establish_day      .= "-";
    $establish_day      .= $_POST["form_establish_day"]["d"];  //創業日(日) establishment date (day)
    $corpo_day           = $_POST["form_corpo_day"]["y"];      //法人登記日(年) registration date (year)
    $corpo_day          .= "-";
    $corpo_day          .= $_POST["form_corpo_day"]["m"];      //法人登記日(月) registration date (month)
    $corpo_day          .= "-";
    $corpo_day          .= $_POST["form_corpo_day"]["d"];      //法人登記日(日) registration date (day)
    $slip_issue          = $_POST["form_slip_issue"];          //伝票発行 issue slip
    $deli_comment        = $_POST["form_deli_comment"];        //納品書コメント delivery note comment
    $claim_issue         = $_POST["form_claim_issue"];         //請求書発行 issue billing statement
    $coax                = $_POST["form_coax"];                //まるめ区分 round up/down
    $tax_div             = $_POST["form_tax_div"];             //課税区分 tax classification
    $tax_unit            = $_POST["form_tax_unit"];            //課税単位 tax unit
    $fraction_div        = $_POST["from_fraction_div"];        //端数区分 round up/off
    $qualify_pride       = $_POST["form_qualify_pride"];       //取得資格・得意分野 acquired license/field of expertise
    $special_contract    = $_POST["form_special_contract"];    //特約 special clause
    $other               = $_POST["form_other"];               //その他 others
    $btype               = $_POST["form_btype"];               //業種 industry type
    $inst                = $_POST["form_inst"];                //施設 facility
    $bstruct             = $_POST["form_bstruct"];             //業態 business type
    $accountant_name     = $_POST["form_accountant_name"];     //会計担当者氏名 accounting reprsentative name
    $cname_read          = $_POST["form_cname_read"];          //略称(フリガナ) abbreviation (katakana)
    $email               = $_POST["form_email"];               //Email
    $direct_tel          = $_POST["form_direct_tel"];          //直通TEL direct TEL
    $record              = $_POST["form_record"];              //取引履歴 trade history
    $important           = $_POST["form_important"];           //重要事項  important items 
    $deliver_effect      = $_POST["form_deliver_radio"];       //納品書コメント(効果) delivery note comment (effect)
    $claim_send          = $_POST["form_claim_send"];          //請求書送付 billing statement send 
    $accounts_day       .= $_POST["form_accounts_day"];        //決算日(日)  cutoff day (day)
    $account_tel         = $_POST["form_account_tel"];         //会計ご担当者携帯 accounting staff TEL
    $prefix              = $_POST["form_prefix"];              //敬称 compellation
    $claim_pattern       = $_POST["claim_pattern"];            //請求書様式 billing format
    $c_tax_div           = $_POST["form_c_tax_div"];           //課税区分 tax classification

    //仕入先としての情報を抽出 extract the information as a supplier
    $bank_name           = $_POST["form_bank_name"];            //振込口座名 deposit account name
    $b_bank_name         = $_POST["form_b_bank_name"];          //振込口座名略称 deposit account abbreviation
    $payout_m            = $_POST["form_payout_month"];            //支払日 payment date
    $payout_d            = $_POST["form_payout_day"];             //支払日 payment date

    #2010-04-30 hashimoto-y
    $bill_address_font      = ($_POST["form_bill_address_font"] == '1')? 't' : 'f'; //請求先フォント billign font

    /***************************/
    //０埋め fill with 0s 
    /***************************/
    //得意先コード１ customer code 1
    $shop_cd1 = str_pad($shop_cd1, 6, 0, STR_POS_LEFT);

    //得意先コード２ customer code 2
    $shop_cd2 = str_pad($shop_cd2, 4, 0, STR_POS_LEFT);


/***************************/
//ルール作成（PHP） create rules
/***************************/
    //ショップコード shop code
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
                $shop_cd_err = "入力されたショップコードは使用中です。";
                $err_flg = true;
            }
        }
    }
    
    //■FAX
    $form->addRule("form_fax","FAXは半角数字と｢-｣のみ30桁以内です。","telfax");

    //Email
	if (!(ereg("^[^@]+@[^.]+\..+", $email)) && $email != "") {
        $email_err = "Emailが妥当ではありません。";
        $err_flg = true;
    }

    //■URL
    //●入力チェック check input
    if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null) {
        $url_err = "正しいURLを入力して下さい。";
        $err_flg = true;
    }

    //■直通TEL direct TEL
    //●半角数字と「-」以外はエラー error if anything other than half width number and - was inputted
    $form->addRule("form_direct_tel","直通TELは半角数字と｢-｣のみ30桁以内です。","telfax");

    //■会計ご担当携帯 accounting staff TEL
    //●半角数字と「-」以外はエラー error if anything other than half width number and - was inputted
    $form->addRule("form_account_tel","会計ご担当者携帯は半角数字と｢-｣のみ30桁以内です。","telfax");

    //■代表者携帯 representative TEL
    //●半角数字と「-」以外はエラー error if anything other than half width number and - was inputted
    $form->addRule("form_represent_cell","代表者携帯は半角数字と｢-｣のみ30桁以内です。","telfax");

    //■連絡担当者携帯 contact staff TEL
    //●半角数字と「-」以外はエラー error if anything other than half width number and - was inputted
    $form->addRule("form_contact_cell","連絡担当者携帯は半角数字と｢-｣のみ30桁以内です。","telfax");

    //■集金日 collection date
    if($aord_div == '61' && ($close_day != $pay_day || $pay_month != '0')){
        $close_day_err = "取引区分に現金を指定した場合の集金日は当月の締日にして下さい。";
        $err_flg = true;
    }elseif($aord_div == '11' && $pay_month == "0" && ($close_day >= $pay_day)){
        $close_day_err = "集金日に締日より前の日付は選択できません。";
        $err_flg = true;
    }

    //■支払日 payment date
    if($buy_div == '71' && ($close_day != $payout_d || $payout_m != '0')){
        $close_outday_err = "取引区分に現金を指定した場合の支払日は当月の締日にして下さい。";
        $err_flg = true;
    }elseif($buy_div == '21' && $payout_m == "0" && ($close_day >= $payout_d)){
        $close_outday_err = "支払日に締日以前の日付は選択できません。";
        $err_flg = true;
    }
    
    //■請求先 billing client
    //●入力チェック
    if($shop_cd1 == $claim_cd1 && $shop_cd2 == $claim_cd2){
        $claim_flg = true;
    }elseif($claim_cd1 == null && $claim_cd2 == null && $claim_name == null){
        $claim_flg = true;
    }elseif(($_POST["form_claim"]["cd1"] != null || $_POST["form_claim"]["cd2"] != null) && $_POST["form_claim"]["name"] == null){
        $claim_err = "正しい請求先コードを入力して下さい。";
        $err_flg = true;

    // 正しい請求先が入力された場合
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
        $claim_close_day  = $claim_data["close_day"];    //締め日
        $claim_coax       = $claim_data["coax"];         //丸め区分
        $claim_tax_div    = $claim_data["tax_div"];      //課税単位
        $claim_tax_franct = $claim_data["tax_franct"];   //端数区分 
        $claim_c_tax_div  = $claim_data["c_tax_div"];    //課税区分
        $claim_pay_m      = $claim_data["pay_m"];        //集金日（月）
        $claim_pay_d      = $claim_data["pay_d"];        //集金日（日）

        //請求先の締め日と同じではない場合処理開始
        if($close_day != $claim_close_day){
            // 月末判定
            if($claim_close_day == "29"){
                $claim_close_day_err = "締日は請求先と同じ 月末 を選択して下さい。";
            }else{  
                $claim_close_day_err = "締日は請求先と同じ ".$claim_close_day."日 を選択して下さい。";
            }       
            $err_flg = true; 
        }else{  
            $claim_flg = true; 
        }       

        //請求先の丸め区分と同じではない場合処理開始
        if($coax != $claim_coax){

            //エラーメッセージに表示するため丸め区分を置換
            if($claim_coax == "1"){
                $claim_coax = "切捨"; 
            }elseif($claim_coax == "2"){
                $claim_coax = "四捨五入";
            }elseif($claim_coax == "3"){
                $claim_coax = "切上"; 
            }       

            $claim_coax_err = "まるめ区分は請求先と同じ ".$claim_coax." を選択して下さい。";
            $err_flg = true;
        }

        //請求先の課税単位と同じではない場合処理開始
        if($tax_unit != $claim_tax_div){
            //エラーメッセージに表示するため課税単位を置換
            if($claim_tax_div == '2'){
                $claim_tax_div = "伝票単位";
            }elseif($claim_tax_div == '1'){
                $claim_tax_div = "締日単位";
            }

            $claim_tax_div_err = "課税単位は請求先と同じ ".$claim_tax_div." を選択して下さい。";
            $err_flg = true;
        }

        //請求先の端数区分と同じではない場合処理開始
        if($fraction_div != $claim_tax_franct){

            //エラーメッセージに表示するため端数区分を置換
            if($claim_tax_franct == '1'){
                $claim_tax_franct = "切捨";
            }elseif($claim_tax_franct == '2'){
                $claim_tax_franct = "四捨五入";
            }elseif($claim_tax_franct == '3'){
                $claim_tax_franct = "切上";
            }

            $claim_tax_franct_err = "端数は請求先と同じ ".$claim_tax_franct." を選択して下さい。";
            $err_flg = true;
        }

        //請求先の課税区分と同じではない場合処理開始
        if($c_tax_div != $claim_c_tax_div){

            //エラーメッセージに表示するため課税区分を置換
            if($claim_c_tax_div == '1'){
                $claim_c_tax_div = "外税";
            #2005-12-25 aoyama-n
            #}elseif($claim_c_tax_div == '2'){
            #    $claim_c_tax_div = "内税";
            #}
            }elseif($claim_c_tax_div == '3'){
                $claim_c_tax_div = "非課税";
            }

            $claim_c_tax_div_err = "課税区分は請求先と同じ ".$claim_c_tax_div." を選択して下さい。";
            $err_flg = true;
        }
        //請求先の集金日（月）と同じではない場合処理開始
        if($pay_m != $claim_pay_m){

            //エラーメッセージに表示するため集金日（月）を置換
            if($claim_pay_m == '0'){
                $claim_pay_m = "当月";
            }elseif($claim_pay_m == '1'){
                $claim_pay_m = "翌月";
            }else{
                $claim_pay_m = $claim_pay_m."ヶ月後";
            }

            $claim_pay_m_err = "集金日は請求先と同じ ".$claim_pay_m." を選択して下さい。";
        }
    }

    //■契約年月日・契約更新日
    //●日付の妥当性チェック
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

    //契約年月日
    if($sday_m != null || $sday_d != null || $sday_y != null){
        $sday_flg = true;
    }
    $check_s_day = checkdate($sday_m,$sday_d,$sday_y);
    if($check_s_day == false && $sday_flg == true){
        $sday_err = "契約年月日の日付は妥当ではありません。";
        $err_flg = true;
    }

    //契約更新日
    if($rday_m != null || $rday_d != null || $rday_y != null){
        $rday_flg = true;
    }
    $check_r_day = checkdate($rday_m,$rday_d,$rday_y);
    if($check_r_day == false && $rday_flg == true){
        $rday_err = "契約更新日の日付は妥当ではありません。";
        $err_flg = true;
    }

    //●契約更新日が契約年月日よりも前でないかチェック
    if($cont_s_day >= $cont_r_day && $cont_s_day != '--' && $cont_r_day != '--'){
        $sday_rday_err = "契約更新日の日付は妥当ではありません。";
        $err_flg = true;
    }

    //創業日
    if($eday_m != null || $eday_d != null || $eday_y != null){
        $eday_flg = true;
    }
    $check_e_day = checkdate($eday_m,$eday_d,$eday_y);
    if($check_e_day == false && $eday_flg == true){
        $eday_err = "創業日の日付は妥当ではありません。";
        $err_flg = true;
    }

    //法人登記日
    if($cday_m != null || $cday_d != null || $cday_y != null){
        $cday_flg = true;
    }
    $check_c_day = checkdate($cday_m,$cday_d,$cday_y);
    if($check_c_day == false && $cday_flg == true){
        $cday_err = "法人登記日の日付は妥当ではありません。";
        $err_flg = true;
    }

    #2010-05-01 hashimoto-y
    //請求先フォントサイズを大にチェックを入れ以下の条件を超えてないかチェック
    //住所１＝20 , 住所２＝20 , 住所３＝28 , 社名１＝20 , 社名２＝20
    if($bill_address_font == 't'){
        if( mb_strlen($address1) > 18 ){
            $address1_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、住所１は１８文字以下です。";
            $err_flg = true;
        }
        if( mb_strlen($address2) > 18 ){
            $address2_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、住所２は１８文字以下です。";
            $err_flg = true;
        }
        if( mb_strlen($address3) > 18 ){
            $address3_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、住所３は１８文字以下です。";
            $err_flg = true;
        }
        if( mb_strlen($comp_name) > 14 ){
            $comp_name1_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、社名１は１４文字以下です。";
            $err_flg = true;
        }
        if( mb_strlen($comp_name2) > 14 ){
            $comp_name2_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、社名２は１４文字以下です。";
            $err_flg = true;
        }
        if( mb_strlen($shop_name) > 14 ){
            $shop_name_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、ショップ名は１４文字以下です。";
            $err_flg = true;
        }
    }

}

if($_POST["button"]["entry_button"] == "登　録" && $form->validate() && $err_flg != true ){
    /******************************/
    //登録処理
    /******************************/
    Db_Query($conn, "BEGIN;");
    if($new_flg == true){
        //取引先マスタ
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    rank_cd,";                          //顧客区分
        $insert_sql .= "    client_id,";                        //得意先ID
        $insert_sql .= "    shop_id,";                          //ショップID
        $insert_sql .= "    create_day,";                       //作成日
        $insert_sql .= "    client_cd1,";                       //得意先コード
        $insert_sql .= "    client_cd2,";                       //支店コード
        $insert_sql .= "    state,";                            //状態
        $insert_sql .= "    client_name,";                      //得意先名
        $insert_sql .= "    client_read,";                      //得意先名（フリガナ）
        $insert_sql .= "    client_cname,";                     //略称
        $insert_sql .= "    post_no1,";                         //郵便番号１
        $insert_sql .= "    post_no2,";                         //郵便番号２
        $insert_sql .= "    address1,";                         //住所１
        $insert_sql .= "    address2,";                         //住所２
        $insert_sql .= "    address3,";                         //住所３
        $insert_sql .= "    address_read,";                     //住所（フリガナ）
        $insert_sql .= "    area_id,";                          //地区ID
        $insert_sql .= "    tel,";                              //tel
        $insert_sql .= "    fax,";                              //fax
        $insert_sql .= "    rep_name,";                         //代表者名
        $insert_sql .= "    sv_staff_id,";                      //SV
        $insert_sql .= "    b_staff_id1,";                      //担当１
        $insert_sql .= "    b_staff_id2,";                      //担当２
        $insert_sql .= "    b_staff_id3,";                      //担当３
        $insert_sql .= "    b_staff_id4,";                      //担当４
        $insert_sql .= "    charger_name,";                     //ご担当者１
        $insert_sql .= "    holiday,";                          //休日
        $insert_sql .= "    col_terms,";                        //回収条件
        $insert_sql .= "    credit_limit,";                     //与信限度
        $insert_sql .= "    capital,";                          //資本金
        $insert_sql .= "    trade_id,";                         //取引区分（得意先用）
        $insert_sql .= "    buy_trade_id,";                     //取引区分（仕入先用）
        $insert_sql .= "    close_day,";                        //締日
        $insert_sql .= "    pay_m,";                            //集金日（月）
        $insert_sql .= "    pay_d,";                            //集金日（日）
        $insert_sql .= "    pay_way,";                          //集金方法
        $insert_sql .= "    account_name,";                     //口座名義
        $insert_sql .= "    pay_name,";                         //振込名義
        $insert_sql .= "    account_id,";                          //口座ID
        $insert_sql .= "    cont_sday,";                        //契約開始日
        $insert_sql .= "    cont_eday,";                        //契約終了日
        $insert_sql .= "    cont_peri,";                        //契約期間
        $insert_sql .= "    cont_rday,";                        //契約更新日
        $insert_sql .= "    slip_out,";                         //伝票出力
        $insert_sql .= "    deliver_note,";                     //納品書コメント
        $insert_sql .= "    claim_out,";                        //請求書出力
        $insert_sql .= "    coax,";                             //金額：丸め区分
        $insert_sql .= "    tax_div,";                          //消費税：課税単位
        $insert_sql .= "    tax_franct,";                       //消費税：端数区分
        $insert_sql .= "    client_div,";                       //得意先区分
        $insert_sql .= "    shop_name,";                        //社名
        $insert_sql .= "    shop_read,";                        //社名(フリガナ)
        $insert_sql .= "    shop_name2,";                       //社名2
        $insert_sql .= "    shop_read2,";                       //社名2(フリガナ)
        $insert_sql .= "    url,";                              //URL
        $insert_sql .= "    represe,";                          //代表者役職
        $insert_sql .= "    rep_htel,";                         //代表者携帯
        $insert_sql .= "    charger,";                          //連絡担当者役職
        $insert_sql .= "    cha_htel,";                         //連絡担当者携帯
        $insert_sql .= "    surety_name1,";                     //保証人１名前
        $insert_sql .= "    surety_addr1,";                     //保証人１住所
        $insert_sql .= "    surety_name2,";                     //保証人２名前
        $insert_sql .= "    surety_addr2,";                     //保証人２住所
        $insert_sql .= "    trade_base,";                       //営業拠点
        $insert_sql .= "    trade_area,";                       //商圏
        $insert_sql .= "    join_money,";                       //加盟金
        $insert_sql .= "    guarant_money,";                    //保証金
        $insert_sql .= "    royalty_rate,";                     //ロイヤリティ
        $insert_sql .= "    cutoff_month,";                      //決算月
        $insert_sql .= "    c_compa_name,";                     //契約会社名
        $insert_sql .= "    c_compa_rep,";                      //契約代表者
        $insert_sql .= "    license,";                          //所有資格・得意分野
        $insert_sql .= "    s_contract,";                       //特約
        $insert_sql .= "    other,";                            //その他
        $insert_sql .= "    establish_day,";                    //創業日
        $insert_sql .= "    regist_day,";                       //法人登記日
        $insert_sql .= "    sbtype_id,";                        //業種
        $insert_sql .= "    inst_id,";                          //施設
        $insert_sql .= "    b_struct,";                         //業態
        $insert_sql .= "    accountant_name,";                  //会計担当者氏名
        $insert_sql .= "    client_cread,";                     //略称(フリガナ)
        $insert_sql .= "    email,";                            //Email
        $insert_sql .= "    direct_tel,";                       //直通TEL
        $insert_sql .= "    deal_history,";                     //取引履歴
        $insert_sql .= "    importance,";                       //重要事項
        $insert_sql .= "    deliver_effect,";                   //納品書コメント(効果)
        $insert_sql .= "    claim_send,";                       //請求書送付(郵送)
        $insert_sql .= "    cutoff_day,";                       //決算日
        #2009-12-25 aoyama-n
        #$insert_sql .= "    tax_rate_n,";                       //消費税率(現在)
        $insert_sql .= "    account_tel,";                      //会計ご担当者TEL
	    $insert_sql .= "    compellation,";                     //敬称
	    $insert_sql .= "    c_pattern_id,";                     //請求書様式
        $insert_sql .= "    c_tax_div,";                         //課税区分
//ここからは仕入先情報
        $insert_sql .= "    payout_m,";                         //支払日
        $insert_sql .= "    payout_d,";                         //支払日
        $insert_sql .= "    bank_name,";                        //口座名義
        $insert_sql .= "    b_bank_name,";                      //口座名義略称
//自社プロフィール用に登録
        $insert_sql .= "    my_coax,\n";                        //まるめ
        $insert_sql .= "    my_tax_franct,\n";                  //端数区分
        $insert_sql .= "    my_pay_m,\n";                       //回収予定日
        $insert_sql .= "    my_pay_d,\n";                       //回収予定日
        $insert_sql .= "    my_close_day,\n";                   //締日
        $insert_sql .= "    claim_set, \n";                     //請求番号設定  
        #2009-12-25 aoyama-n
        #$insert_sql .= "    cal_peri\n";                        //カレンダー表示期間
        $insert_sql .= "    cal_peri,\n";                        //カレンダー表示期間
        $insert_sql .= "    tax_rate_old,\n";                   //旧消費税率
        $insert_sql .= "    tax_rate_now,\n";                   //現消費税率
        $insert_sql .= "    tax_change_day_now,\n";             //現税率改定日
        $insert_sql .= "    tax_rate_new,\n";                   //新消費税率
        $insert_sql .= "    tax_change_day_new,\n";             //新税率改定日
        #2010-05-01 hashimoto-y
        $insert_sql .= "    bill_address_font \n";              //請求書宛先フォント
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    '$rank_cd',";                          //顧客区分
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";//得意先ID
        $insert_sql .= "    $shop_id,";                        //FCグループID
        $insert_sql .= "    NOW(),";                            //作成日
        $insert_sql .= "    '$shop_cd1',";                      //得意先コード
        $insert_sql .= "    '$shop_cd2',";                      //支店コード
        $insert_sql .= "    '$form_state',";                    //状態
        $insert_sql .= "    '$shop_name',";                     //得意先名
        $insert_sql .= "    '$shop_name_read',";                //得意先（フリガナ）
        $insert_sql .= "    '$shop_cname',";                    //略称
        $insert_sql .= "    '$post_no1',";                      //郵便番号１
        $insert_sql .= "    '$post_no2',";                      //郵便番号２
        $insert_sql .= "    '$address1',";                      //住所１
        $insert_sql .= "    '$address2',";                      //住所２
        $insert_sql .= "    '$address3',";                      //住所３
        $insert_sql .= "    '$address_read',";                  //住所（フリガナ）
        $insert_sql .= "    $area_id,";                         //地区ID
        $insert_sql .= "    '$tel',";                           //TEL
        $insert_sql .= "    '$fax',";                           //FAX
        $insert_sql .= "    '$represent_name',";                //代表者氏名
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
        $insert_sql .= "    $sv,";                              //契約担当１
        $insert_sql .= "    $staff1,";                          //契約担当２
        $insert_sql .= "    $staff2,";                          //巡回担当１
        $insert_sql .= "    $staff3,";                          //巡回担当２
        $insert_sql .= "    $staff4,";                          //巡回担当３
        $insert_sql .= "    '$contact_name',";                  //ご担当者１
        $insert_sql .= "    '$holiday',";                       //休日
        $insert_sql .= "    '$collect_terms',";                 //回収条件
        $insert_sql .= "    '$limit_money',";                   //与信限度
        $insert_sql .= "    '$capital_money',";                 //資本金
        $insert_sql .= "    '$aord_div',";                      //取引区分得意先用
        $insert_sql .= "    '$buy_div',";                       //取引区分仕入先用
        $insert_sql .= "    '$close_day',";                     //締日
        if($pay_month == ""){
                $pay_month = "    null"; 
        }
        $insert_sql .= "    '$pay_month',";                     //集金日（月）
        if($pay_day == ""){
                $pay_day = "    null"; 
        }
        $insert_sql .= "    '$pay_day',";                       //集金日（日）
        $insert_sql .= "    '$pay_way',";                       //集金方法
        $insert_sql .= "    '$account_name',";                  //口座名義
        $insert_sql .= "    '$transfer_name',";                 //振込名義
        if($bank == ""){
                $bank = "    null"; 
        }
        $insert_sql .= "    $bank,";                            //銀行
        if($cont_s_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_s_day',";                //契約開始日
        }
        if($cont_e_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_e_day',";                //契約終了日
        }
        if($cont_peri == ""){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_peri',";                 //契約期間
        }
        if($cont_r_day == "--"){
            $insert_sql .= "    null,";
        }else{
            $insert_sql .= "    '$cont_r_day',";                //契約更新日
        }
        $insert_sql .= "    '$slip_issue',";                    //伝票出力
        $insert_sql .= "    '$deli_comment',";                  //納品書コメント
        $insert_sql .= "    '$claim_issue',";                   //請求書出力
        $insert_sql .= "    '$coax',";                          //金額：丸め区分
        $insert_sql .= "    '$tax_unit',";                      //消費税：課税単位
        $insert_sql .= "    '$fraction_div',";                  //消費税：端数単位
        $insert_sql .= "    '3',";                              //得意先区分
        $insert_sql .= "    '$comp_name',";                     //社名
        $insert_sql .= "    '$comp_name_read',";                //社名(フリガナ)
        $insert_sql .= "    '$comp_name2',";                    //社名2
        $insert_sql .= "    '$comp_name_read2',";               //社名2(フリガナ)
        $insert_sql .= "    '$url',";                           //URL
        $insert_sql .= "    '$represent_position',";            //代表者役職
        $insert_sql .= "    '$represent_cell',";                //代表者携帯
        $insert_sql .= "    '$contact_position',";              //連絡担当者役職
        $insert_sql .= "    '$contact_cell',";                  //連絡担当者携帯
        $insert_sql .= "    '$guarantor1',";                    //保証人１名前
        $insert_sql .= "    '$guarantor1_address',";            //保証人１住所
        $insert_sql .= "    '$guarantor2',";                    //保証人２名前
        $insert_sql .= "    '$guarantor2_address',";            //保証人２住所
        $insert_sql .= "    '$position',";                      //営業拠点
        $insert_sql .= "    '$business_limit',";                //商圏
        $insert_sql .= "    '$join_money',";                    //加盟金
        $insert_sql .= "    '$assure_money',";                  //保証金
        $insert_sql .= "    '$royalty',";                       //ロイヤリティ
        $insert_sql .= "    '$accounts_month',";                //決算月
        $insert_sql .= "    '$contract_name',";                 //契約会社名
        $insert_sql .= "    '$represent_contract',";            //契約代表者
        $insert_sql .= "    '$qualify_pride',";                 //所有資格・得意分野
        $insert_sql .= "    '$special_contract',";              //特約
        $insert_sql .= "    '$other',";                         //その他
        if($establish_day == "--"){
        $insert_sql .= "    null,";                             //開業日
        }else{
        $insert_sql .= "    '$establish_day',";
        }
        if($corpo_day == "--"){
        $insert_sql .= "    null,";                              //法人登記日
        }else{
        $insert_sql .= "    '$corpo_day',";
        }
        $insert_sql .= "    $btype,";                           //業種
        if($inst == ""){
                $inst = "    null"; 
        }
        $insert_sql .= "    $inst,";                            //施設
        if($bstruct == ""){
                $bstruct = "    null"; 
        }
        $insert_sql .= "    $bstruct,";                         //業態
        $insert_sql .= "    '$accountant_name',";               //会計担当者氏名
        $insert_sql .= "    '$cname_read',";                    //略称(フリガナ)
        $insert_sql .= "    '$email',";                         //Email
        $insert_sql .= "    '$direct_tel',";                    //直通TEL
        $insert_sql .= "    '$record',";                        //取引履歴
        $insert_sql .= "    '$important',";                     //重要事項
        $insert_sql .= "    '$deliver_effect',";                //納品書コメント(効果)
        $insert_sql .= "    '$claim_send',";                    //請求書送付(郵送)
        $insert_sql .= "    '$accounts_day',";                  //決算日(日)
        #2009-12-25 aoyama-n
        #$insert_sql .= "    (SELECT";                           //消費税率(現在)
        #$insert_sql .= "        tax_rate_n";
        #$insert_sql .= "    FROM";
        #$insert_sql .= "        t_client";
        #$insert_sql .= "    WHERE";
        #$insert_sql .= "    client_div = '0'";
        #$insert_sql .= "    ) ,";
        $insert_sql .= "    '$account_tel',";
        $insert_sql .= "    '$prefix',";
        $insert_sql .= "    $claim_pattern,";
        $insert_sql .= "    $c_tax_div,";                        //課税区分
//ここからは仕入先情報
        $insert_sql .= "    '$payout_m',";                         //支払日
        $insert_sql .= "    '$payout_d',";                         //支払日
        $insert_sql .= "    '$bank_name',";                        //口座名義
        $insert_sql .= "    '$b_bank_name',";                       //口座名義略称
//自社プロフィール用に登録
        $insert_sql .= "    '$coax',\n";
        $insert_sql .= "    '$fraction_div',\n";
        $insert_sql .= "    '$pay_month',\n";
        $insert_sql .= "    '$pay_day',\n";
        $insert_sql .= "    '$close_day',\n";
        $insert_sql .= "    '1', \n";
        #2009-12-25 aoyama-n
        #$insert_sql .= "    '1'\n";
        $insert_sql .= "    '1',\n";
        $insert_sql .= "    (SELECT";                           //旧消費税率
        $insert_sql .= "        tax_rate_old";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //現消費税率
        $insert_sql .= "        tax_rate_now";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //現税率改定日
        $insert_sql .= "        tax_change_day_now";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //新消費税率
        $insert_sql .= "        tax_rate_new";
        $insert_sql .= "    FROM";
        $insert_sql .= "        t_client";
        $insert_sql .= "    WHERE";
        $insert_sql .= "    client_div = '0'";
        $insert_sql .= "    ) ,";
        $insert_sql .= "    (SELECT";                           //新税率改定日
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
        //登録した情報をログに残す
        $result = Log_Save( $conn, "shop", "1",$shop_cd1."-".$shop_cd2,$shop_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        //登録したショップのショップIDを抽出
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


        //■請求先
        //●入力時
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
        //選択した顧客区分コードが直営の場合
        $sql  = "SELECT";
        $sql .= "   group_kind";
        $sql .= " FROM";
        $sql .= "   t_rank";
        $sql .= " WHERE";
        $sql .= "   rank_cd = '$rank_cd'";
        $sql .= ";";

        $result     = Db_Query($conn, $sql);
        $group_kind = pg_fetch_result($result, 0);

        //直営の場合、既に直営が登録されているか検索
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

        //直営が登録されていますか？？
        if($fc_rank_num == 0 || $fc_rank_num == null){

            //登録したFCに基本出荷倉庫を選択する。
            $sql  = "INSERT INTO t_ware(";
            $sql .= "   ware_id,\n";
            $sql .= "   ware_cd,\n";
            $sql .= "   ware_name,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";   
            $sql .= "   (SELECT COALESCE(MAX(ware_id),0)+1 FROM t_ware ),";
            $sql .= "   '001',\n";
            $sql .= "   '初期倉庫',\n";
            $sql .= "   $fc_shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //登録した倉庫IDを抽出
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
                branch_name   => addslashes("本店"),
                bases_ware_id => $def_ware_id,
                note          => "",
                shop_id       => $fc_shop_id,
            );
            require_once(INCLUDE_DIR.(basename("2-1-200.php.inc"))); //現モジュール内のみで使用する関数ファイル

            //初期支店登録（成功時は登録したIDを返す）
            $branch_id = Regist_Branch($conn,"default",$values);

            //初期部署登録
            Regist_Init_Part($conn,$values[shop_id]);

            //部署に支店を登録
            if($branch_id != false){
                Update_Part_Branch($conn,$values[shop_id],$branch_id);
            }

            //本部を仕入先として登録する
            //本部の取引先マスタの情報を抽出
            $sql  = "SELECT\n";
            $sql .= "    t_client.client_cd1,\n";       //ショップコード1
            $sql .= "    t_client.client_name,\n";      //ショップ名
            $sql .= "    t_client.client_cname,\n";     //略称
            $sql .= "    t_client.post_no1,\n";         //郵便番号
            $sql .= "    t_client.post_no2,\n";         //郵便番号
            $sql .= "    t_client.address1,\n";         //住所1
            $sql .= "    t_client.area_id,\n";          //地区
            $sql .= "    t_client.tel,\n";              //TEL
            $sql .= "    t_client.rep_name,\n";         //代表者氏名
            $sql .= "    t_client.trade_id,\n";         //取引区分
            $sql .= "    t_client.close_day,\n";        //締日
            $sql .= "    t_client.pay_m,\n";            //集金日(月)
            $sql .= "    t_client.pay_d,\n";            //集金日(日)
            $sql .= "    t_client.coax,\n";             //まるめ区分
            $sql .= "    t_client.tax_div,\n";          //課税単位
            $sql .= "    t_client.tax_franct,\n";       //端数区分
            $sql .= "    t_client.sbtype_id\n";         //業種
            $sql .= " FROM\n";
            $sql .= "    t_client\n";
            $sql .= " WHERE\n";
            $sql .= "    t_client.client_div = '0'\n";
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            $h_client_data = pg_fetch_array($result, 0);

            //地区マスタに本部用の地区を登録
            //上記で登録がない場合のみ
            $sql  = "INSERT INTO t_area(\n";
            $sql .= "   area_id,\n";
            $sql .= "   area_cd,\n";
            $sql .= "   area_name,\n";
            $sql .= "   shop_id\n";
            $sql .= ")VALUES(\n";
            $sql .= "   (SELECT COALESCE(MAX(area_id),0)+1 FROM t_area),\n";
            $sql .= "   '0001',\n";
            $sql .= "   '本部地区',\n";
            $sql .= "   $fc_shop_id\n";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //地区IDを取得
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

            //本部のデータを登録
            $sql  = "INSERT INTO t_client(\n";
            $sql .= "    shop_id,\n";          //取引先マスタ
            $sql .= "    client_id,\n";        //仕入先ID
            $sql .= "    client_cd1,\n";       //仕入先CD
            $sql .= "    client_cd2,\n";       //仕入先CD２
            $sql .= "    state,\n";            //状態
            $sql .= "    client_div,\n";       //取引先区分
            $sql .= "    create_day,\n";       //作成日
            $sql .= "    shop_div,\n";         //本社・支社区分
            $sql .= "    client_name,\n";      //得意先名
            $sql .= "    client_cname,\n";     //略称
            $sql .= "    client_read,\n";      //得意先名（フリガナ）
            $sql .= "    post_no1,\n";         //郵便番号１
            $sql .= "    post_no2,\n";         //郵便番号２
            $sql .= "    address1,\n";         //住所１
            $sql .= "    area_id,\n";          //地区  
            $sql .= "    sbtype_id,\n";        //業種
            $sql .= "    tel,\n";              //電話番号
            $sql .= "    rep_name,\n";         //代表者名
            $sql .= "    close_day,\n";        //締日  
            $sql .= "    payout_m,\n";         //支払日(月)
            $sql .= "    payout_d,\n";         //支払日(日)
            $sql .= "    coax,\n";             //金額(丸め区分)
            $sql .= "    tax_div,\n";          //消費税(課税単位)
            $sql .= "    tax_franct,\n";       //消費税(端数)
            $sql .= "    c_tax_div,\n";
            $sql .= "    head_flg,\n";
            $sql .= "    trade_id, \n";
            $sql .= "    charge_branch_id \n";  //担当支店
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
            $sql .= "    '$coax',";                          //金額：丸め区分
            $sql .= "    '$tax_unit',";                      //消費税：課税単位
            $sql .= "    '$fraction_div',";                  //消費税：端数単位
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

            //東陽を得意先として登録する
            //東陽の情報を抽出
            $sql  = "SELECT\n";
            $sql .= "    t_client.client_cd1,\n";       //ショップコード1
            $sql .= "    t_client.client_cd2,\n";       //ショップコード２
            $sql .= "    t_client.client_name,\n";      //ショップ名
            $sql .= "    t_client.client_read,\n";      //ショップ名(フリガナ)
            $sql .= "    t_client.client_name2,\n";     //ショップ名２
            $sql .= "    t_client.client_read2,\n";     //ショップ名２（フリガナ）
            $sql .= "    t_client.client_cname,\n";     //略称
            $sql .= "    t_client.client_read,\n";      //略称（フリガナ）
            $sql .= "    t_client.post_no1,\n";         //郵便番号
            $sql .= "    t_client.post_no2,\n";         //郵便番号
            $sql .= "    t_client.address1,\n";         //住所1
            $sql .= "    t_client.address2,\n";         //住所2
            $sql .= "    t_client.address3,\n";         //住所3
            $sql .= "    t_client.address_read,\n";     //住所（フリガナ）
            $sql .= "    t_client.area_id,\n";          //地区  
            $sql .= "    t_client.tel,\n";              //TEL   
            $sql .= "    t_client.rep_name,\n";         //代表者氏名
            $sql .= "    t_client.trade_id,\n";         //取引区分
            $sql .= "    t_client.close_day,\n";        //締日  
            $sql .= "    t_client.pay_m,\n";            //集金日(月)
            $sql .= "    t_client.pay_d,\n";            //集金日(日)
            $sql .= "    t_client.coax,\n";             //まるめ区分
            $sql .= "    t_client.tax_div,\n";          //課税単位
            $sql .= "    t_client.tax_franct,\n";       //端数区分
            $sql .= "    t_client.sbtype_id,\n";        //業種  
            $sql .= "    t_client.c_tax_div,\n";
            $sql .= "    t_client.rep_name,\n";         //代表者名
            $sql .= "    t_client.represe,\n";          //代表者役職
            $sql .= "    t_client.tel,\n";              //電話番号
            $sql .= "    t_client.fax,\n";              //FAX
            $sql .= "    t_client.establish_day,\n";    //創業日
            $sql .= "    t_client.email\n";             //担当者Email
            $sql .= " FROM\n";
            $sql .= "    t_client\n";
            $sql .= " WHERE\n";
            $sql .= "    t_client.client_id = 93\n";    //東陽のデータ
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            $fc_client_data = pg_fetch_array($result, 0);


            //今から登録する得意先に対し、必要なマスタデータを先に登録
            //請求書フォーマット
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
            $sql .= "   '株式会社　ア メ ニ テ ィ',\n";
            $sql .= "   '代表取締役　山　戸　里　志',\n";
            $sql .= "   '〒221-0863 横 浜 市 神 奈 川区 羽 沢 町 685',\n";
            $sql .= "   'ＴＥＬ  045-371-7676   ＦＡＸ  045-371-7717',\n";
            $sql .= "   'みずほ銀行　横浜西口支店　　　　　当座預金　*******',\n";
            $sql .= "   'みずほ銀行　横浜駅前支店　　　　　当座預金　*******',\n";
            $sql .= "   '東京三菱銀行　新横浜支店　　　　　当座預金　*******',\n";
            $sql .= "   '横浜銀行　西谷支店　　　　　 　　 当座預金　*******',\n";
            $sql .= "   '商工中金　横浜西口支店　　 　 　　当座預金　*******',\n";
            $sql .= "   '横浜信用金庫　西谷支店　　　　　  当座預金　*******',\n";
            $sql .= "   '西日本シティ銀行　本店　営業部　　当座預金　*******',\n";
            $sql .= "   '',\n";
            $sql .= "   '※　振り込み手数料は誠に申し訳ございませんが、貴社にて御負担下さるようお願い致します。',\n";
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

            //登録した請求書ID
            $sql  = "SELECT\n";
            $sql .= "   MAX(c_pattern_id) AS c_pattern_id \n";
            $sql .= "FROM\n";
            $sql .= "   t_claim_sheet \n";
            $sql .= "WHERE\n";
            $sql .= "   shop_id = $fc_shop_id\n";
            $sql .= ";";

            $result = Db_Query($conn, $sql);    
            $c_pattern_id = pg_fetch_result($result, 0,0);

            //売上伝票フォーマット設定
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
            $sql .= "   '株式会社アメニティ',\n";
            $sql .= "   '',\n";
            $sql .= "   '代表取締役',\n";
            $sql .= "   '山戸里志',\n";
            $sql .= "   '〒221-0863　横浜市神奈川区羽沢町６８５
ＴＥＬ045-371-7676　ＦＡＸ045-371-7717 ',";
            $sql .= "   '',\n";
            $sql .= "   '取引銀行　みずほ銀行　　　横浜西口支店　当座　*******
　　　　　みずほ銀行　　　横浜駅前支店　当座　*******
　　　　　三菱東京ＵＦＪ　新横浜支店　　当座　*******
　　　　　横浜銀行　　　　西谷支店　　　当座　*******
　　　　　横浜信用金庫　　横浜西口支店　普通　*******　',\n";
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

            //登録した売上伝票ID
            $sql  = "SELECT\n";
            $sql .= "   MAX(s_pattern_id) AS s_pattern_id\n ";
            $sql .= "FROM\n";
            $sql .= "   t_slip_sheet\n ";
            $sql .= "WHERE\n";
            $sql .= "   shop_id = $fc_shop_id\n";
            $sql .= ";";

            $result = Db_Query($conn,$sql);
            $s_pattern_id = pg_fetch_result($result, 0,0);

            //東陽のデータを登録
            $sql  = "INSERT INTO t_client(\n";
            $sql .= "    client_id,\n";                                                                 //　１：得意先ID
            $sql .= "    shop_id,\n";                                                                   //　２：ショップID
            $sql .= "    client_cd1,\n";                                                                //　３：得意先CD１
            $sql .= "    client_cd2,\n";                                                                //　４：得意先CD２
            $sql .= "    state,\n";                                                                     //　５：状態
            $sql .= "    client_div,\n";                                                                //　６：取引先区分
            $sql .= "    create_day,\n";                                                                //　７：作成日
            $sql .= "    shop_div,\n";                                                                  //　８：本社・支社区分
            $sql .= "    client_name,\n";                                                               //　９：得意先名
            $sql .= "    client_read,\n";                                                               //１０：得意先名（フリガナ）
            $sql .= "    client_name2,\n";                                                              //１１：得意先名２
            $sql .= "    client_read2,\n";                                                              //１２：得意先名２（フリガナ）
            $sql .= "    client_cname,\n";                                                              //１３：略称
            $sql .= "    client_cread,\n";                                                              //１４：略称（フリガナ）
            $sql .= "    compellation,\n";                                                              //１５：敬称
            $sql .= "    rep_name,\n";                                                                  //１６：代表者名
            $sql .= "    represe,\n";                                                                   //１７：代表者役職
            $sql .= "    tel,\n";                                                                       //１８：電話番号
            $sql .= "    fax,\n";                                                                       //１９：FAX
            $sql .= ($fc_client_data[establish_day] != null)? " establish_day,\n" : null;               //２０：創業日
            $sql .= "    email,\n";                                                                     //２１：担当者Email
            $sql .= "    post_no1,\n";                                                                  //２２：郵便番号１
            $sql .= "    post_no2,\n";                                                                  //２３：郵便番号２
            $sql .= "    address1,\n";                                                                  //２４：住所１
            $sql .= "    address2,\n";                                                                  //２５：住所２
            $sql .= "    address3,\n";                                                                  //２６：住所３
            $sql .= "    address_read,\n";                                                              //２７：住所（フリガナ）
            $sql .= "    area_id,\n";                                                                   //２８：地区
            $sql .= "    sbtype_id,\n";                                                                 //２９：業態ID
            $sql .= "    trade_id,\n";                                                                  //３０：取引区分コード
            $sql .= "    close_day,\n";                                                                 //３１：締日
            $sql .= "    pay_m,\n";                                                                     //３２：支払日(月)
            $sql .= "    pay_d,\n";                                                                     //３３：支払日(日)
            $sql .= "    coax,\n";                                                                      //３４：金額(丸め区分)
            $sql .= "    tax_div,\n";                                                                   //３５：消費税(課税単位)
            $sql .= "    tax_franct,\n";                                                                //３６：消費税(端数)
            $sql .= "    c_tax_div,\n";                                                                 //３７：課税区分
            $sql .= "    bank_div,\n";                                                                  //３８：銀行手数料負担区分
            $sql .= "    act_flg,\n";                                                                   //３９：東陽フラグ
            $sql .= "    c_pattern_id,\n";                                                              //４０：請求書パターン
            $sql .= "    claim_out,\n";                                                                 //４１：請求書発行
            $sql .= "    claim_send,\n";                                                                //４２：請求書送付    
            $sql .= "    s_pattern_id,\n";                                                              //４３：売上伝票発行パターン
            $sql .= "    slip_out,\n";                                                                  //４４：伝票発行
            $sql .= "    deliver_effect,\n";                                                             //４５：納品書コメント有無
            $sql .= "    charge_branch_id ";
            $sql .= ")VALUES(\n";
            $sql .= "    (SELECT COALESCE(MAX(client_id),0)+1 FROM t_client),\n";                       //　１：得意先ID
            $sql .= "    $fc_shop_id,\n";                                                               //　２：ショップID
            $sql .= "    '$fc_client_data[client_cd1]',\n";                                             //　３：得意先CD１
            $sql .= "    '$fc_client_data[client_cd2]',\n";                                             //　４：得意先CD２
            $sql .= "    '1',\n";                                                                       //　５：状態
            $sql .= "    '1',\n";                                                                       //　６：得意先区分
            $sql .= "    NOW(),\n";                                                                     //　７：作成日
            $sql .= "    '1',\n";                                                                       //　８：本社・支社区分
            $sql .= "    '".addslashes($fc_client_data[client_name])."',\n";                            //　９：得意先名
            $sql .= "    '".addslashes($fc_client_data[client_read])."',\n";                            //１０：得意先名（フリガナ）
            $sql .= "    '".addslashes($fc_client_data[client_name2])."',\n";                           //１１：得意先名２
            $sql .= "    '".addslashes($fc_client_data[client_read2])."',\n";                           //１２：得意先名２（フリガナ）
            $sql .= "    '".addslashes($fc_client_data[client_cname])."',\n";                           //１３：略称
            $sql .= "    '".addslashes($fc_client_data[client_cread])."',\n";                           //１４：略称（フリガナ）
            $sql .= "    '1',\n";                                                                       //１５：敬称
            $sql .= "    '".addslashes($fc_client_data[rep_name])."',\n";                               //１６：代表者名
            $sql .= "    '".addslashes($fc_client_data[represe])."',\n";                                //１７：代表者役職
            $sql .= "    '$fc_client_data[tel]',\n";                                                    //１８：電話番号
            $sql .= "    '$fc_client_data[fax]',\n";                                                    //１９：FAX
            $sql .= ($fc_client_data[establish_day] != null)? "'$fc_client_data[establish_day]',\n" : null; //２０：創業日
            $sql .= "    '$fc_client_data[email]',\n";                                                  //２１：Email
            $sql .= "    '$fc_client_data[post_no1]',\n";                                               //２２：郵便番号１
            $sql .= "    '$fc_client_data[post_no2]',\n";                                               //２３：郵便番号２
            $sql .= "    '".addslashes($fc_client_data[address1])."',\n";                               //２４：住所１
            $sql .= "    '".addslashes($fc_client_data[address2])."',\n";                               //２５：住所２
            $sql .= "    '".addslashes($fc_client_data[address3])."',\n";                               //２６：住所３
            $sql .= "    '".addslashes($fc_client_data[address_read])."',\n";                           //２７：住所（フリガナ）
            $sql .= "    $area_id,\n";                                                                  //２８：地区
            $sql .= "    $fc_client_data[sbtype_id],\n";                                                //２９：業種
            $sql .= "    '$fc_client_data[trade_id]',\n";                                               //３０：取引区分
            $sql .= "    '$fc_client_data[close_day]',\n";                                              //３１：締日    
            $sql .= "    '$fc_client_data[pay_m]',\n";                                                  //３２：支払日（月）
            $sql .= "    '$fc_client_data[pay_d]',\n";                                                  //３３：支払日（日）
            $sql .= "    '$fc_client_data[coax]',\n";                                                   //３４：金額（丸め区分）
            $sql .= "    '$fc_client_data[tax_div]',\n";                                                //３５：消費税（課税単位）
            $sql .= "    '$fc_client_data[tax_franct]',\n";                                             //３６：消費税（端数）
            $sql .= "    '$fc_client_data[c_tax_div]',\n";                                              //３７：課税区分
            $sql .= "    '1',\n";                                                                       //３８：銀行手数料負担区分
            $sql .= "    't',\n";                                                                       //３９：東陽フラグ
            $sql .= "    $c_pattern_id,\n";                                                             //４０：請求書パターン
            $sql .= "    '1',\n";                                                                       //４１：請求書発行
            $sql .= "    '1',\n";                                                                       //４２：請求書送付
            $sql .= "    $s_pattern_id,\n";                                                             //４３：売上伝票発行パターン
            $sql .= "    '2',\n";                                                                       //４４：伝票発行
            $sql .= "    '2',\n";                                                                       //４５：納品書コメント
            $sql .= "    $branch_id ";
            $sql .= ");\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //登録した東陽のショップIDを抽出
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
            
            //東陽のデータを得意先情報テーブルに登録
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

            //請求先テーブルに登録
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

            //既に自分の顧客区分の単価が登録されている商品を抽出
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
            #$sql .= "   shop_id = 1\n";          //本部のデータ
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
            $sql .= "   t_price.shop_id = 1\n";          //本部のデータ
            $sql .= "   AND";
            $sql .= "   t_goods_info.shop_id = 1\n";     //本部のデータ
            $sql .= ";";


            $goods_res = Db_Query($conn, $sql);
            $goods_num = pg_num_rows($goods_res);

            for($i = 0; $i < $goods_num; $i++){

                $goods_id     = pg_fetch_result($goods_res, $i,0);

                #2009-10-09 hashimoto-y
                $stock_manage = pg_fetch_result($goods_res, $i,1);

                //単価テーブルへ登録
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

    //更新処理
    }else if($new_flg == false){
        // 得意先登録前に請求先IDを取得
        // 請求先が入力された場合
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

        //取引先マスタ
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
        $update_sql .= "    shop_id         = $shop_id,";                   //ショップID
        $update_sql .= "    shop_name       = '$comp_name',";               //社名
        $update_sql .= "    shop_read       = '$comp_name_read',";          //社名(フリガナ)
        $update_sql .= "    shop_name2      = '$comp_name2',";              //社名2
        $update_sql .= "    shop_read2      = '$comp_name_read2',";         //社名2(フリガナ)
        $update_sql .= "    url             = '$url',";                     //URL
        $update_sql .= "    represe         = '$represent_position',";      //代表者役職
        $update_sql .= "    rep_htel        = '$represent_cell',";          //代表者携帯
        $update_sql .= "    charger         = '$contact_position',";        //連絡担当者役職
        $update_sql .= "    cha_htel        = '$contact_cell',";            //連絡担当者携帯
        $update_sql .= "    surety_name1    = '$guarantor1',";              //保証人１名前
        $update_sql .= "    surety_addr1    = '$guarantor1_address',";      //保証人１住所
        $update_sql .= "    surety_name2    = '$guarantor2',";              //保証人２名前
        $update_sql .= "    surety_addr2    = '$guarantor2_address',";      //保証人２住所
        $update_sql .= "    trade_base      = '$position',";                //営業拠点
        $update_sql .= "    trade_area      = '$business_limit',";          //商圏
        $update_sql .= "    join_money      = '$join_money',";              //加盟金
        $update_sql .= "    guarant_money   = '$assure_money',";            //保証金
        $update_sql .= "    royalty_rate    = $royalty,";                   //ロイヤリティ
        $update_sql .= "    cutoff_month    = '$accounts_month',";          //決算月
        $update_sql .= "    c_compa_name    = '$contract_name',";           //契約会社名
        $update_sql .= "    c_compa_rep     = '$represent_contract',";      //契約代表者
        $update_sql .= "    license         = '$qualify_pride',";           //所有資格・得意分野
        $update_sql .= "    s_contract      = '$special_contract',";        //特約
        $update_sql .= "    other           = '$other',";                   //その他
        if($establish_day == "--"){
        $update_sql .= "    establish_day   = null,";                       //創業日
        }else{
        $update_sql .= "    establish_day   = '$establish_day',";
        }
        if($corpo_day == "--"){
        $update_sql .= "    regist_day      = null, ";                      //法人登記日
        }else{
        $update_sql .= "    regist_day      = '$corpo_day,',";
        }
        $update_sql .= "    sbtype_id       = $btype,";                     //業種
        if($inst == ""){
            $update_sql .= "        inst_id = null,";
        }else{
	        $update_sql .= "    inst_id     = $inst,";                      //施設
        }
        if($bstruct == ""){
            $update_sql .= "        b_struct = null,";
        }else{
	        $update_sql .= "    b_struct    = $bstruct,";                   //業態
        }
        $update_sql .= "    accountant_name = '$accountant_name', ";        //会計担当者氏名
        $update_sql .= "    client_cread    = '$cname_read', ";             //略称(フリガナ)
        $update_sql .= "    email           = '$email', ";                  //Email
        $update_sql .= "    direct_tel      = '$direct_tel', ";             //直通TEL
        $update_sql .= "    deal_history    = '$record', ";                 //取引履歴
        $update_sql .= "    importance      = '$important', ";              //重要事項
        $update_sql .= "    deliver_effect  = '$deliver_effect' ,";         //納品書コメント(効果)
        $update_sql .= "    claim_send      = '$claim_send', ";             //請求書送付(メール)
        $update_sql .= "    cutoff_day      = '$accounts_day', ";           //決算日
        $update_sql .= "    account_tel     = '$account_tel',";             //会計ご担当者携帯
        $update_sql .= "    compellation    = '$prefix', ";                 //敬称
        $update_sql .= "    c_pattern_id    = $claim_pattern,";             //請求書様式
        $update_sql .= "    c_tax_div       = $c_tax_div,";                 //課税区分
        $update_sql .= "    payout_d        = $payout_d,";                  //課税区分
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
        //登録した情報をログに残す
        $result = Log_Save( $conn, "shop", "2",$shop_cd1."-".$shop_cd2,$shop_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        if($change_flg == true){
            Child_Update($_GET[client_id], $close_day, $pay_month, $pay_day, $coax, $tax_unit, $fraction_div, $c_tax_div, $conn);
        }

        //請求先マスタ
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


        //代行先の名前をアップデート
        $act_data = array(
                        "act_id"   => $get_client_id,
                        "act_cd1"  => $shop_cd1,
                        "act_cd2"  => $shop_cd2,
                        "act_name" => $shop_cname 
                        );
        Aord_Act_Data_Update ($conn, $act_data);



        //更新履歴テーブル
        $update_sql  = " INSERT INTO t_renew (";
        $update_sql .= "    client_id,";                        //得意先ID
        $update_sql .= "    staff_id,";                         //スタッフID
        $update_sql .= "    renew_time";                        //現在のtimestamp
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

//自動入力ボタン押下
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["no1"];             //郵便番号１
    $post2     = $_POST["form_post"]["no2"];             //郵便番号２
    $post_value = Post_Get($post1,$post2,$conn);
    //郵便番号フラグをクリア
    $cons_data["input_button_flg"] = "";
    //郵便番号から自動入力
    $cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);
}

if($freeze_flg == true){

    // 戻るボタンの遷移先IDを取得
    // 新規登録時
    if ($get_client_id == null){
        $sql    = "SELECT MAX(client_id) FROM t_client \n";
        $sql   .= "WHERE shop_id = $shop_id \n";
        $sql   .= "AND   client_div = '3' \n";
        $sql   .= ";\n";
        $res    = Db_Query($conn, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    // 変更時
    }else{
        $get_id = $get_client_id;
    }

	//登録確認画面では以下のボタンを表示
	//戻る
	$form->addElement("button","return_button","戻　る","onClick=\"location.href='".$_SERVER["PHP_SELF"]."?client_id=$get_id'\"");
	//OK
	$form->addElement("button","comp_button","登録完了","onClick=\"location.href='./1-1-103.php'\"");

    //契約登録へ
	//$form->addElement("button","contract_button","契約登録","");

    $form->addElement("static","form_claim_link","","請求先");

    $form->freeze();

}else{

    //登録確認画面の場合は、以下のボタンを非表示
    //自動入力
    $button[] = $form->createElement("button","input_button","自動入力","onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""    ); 

    if($change_flg == true){
        $message = "以下の項目は子のデータにも反映されます。\\n・締日\\n・集金日\\n・丸め区分\\n・課税単位\\n・端数区分\\n・課税区分";
    }else{
        $message = "登録します。";
    }
    //登録ボタン
    $button[] = $form->createElement("submit", "entry_button", "登　録", "onClick=\"javascript:return Dialogue('$message','#', this)\" $disabled");

    // 変更時のみ出力
    if ($get_client_id != null){
        //戻るボタン
        $button[] = $form->createElement("button", "back_button", "戻　る", "onClick='javascript:location.href = \"./1-1-101.php\"'");
    }

    if($change_flg == true){
        $form->addElement("static","form_claim_link","","請求先");
    }else{
        $form->addElement("link","form_claim_link","","#","請求先","onClick=\"return Open_SubWin('../dialog/1-0-250.php',Array('form_claim[cd1]','form_claim[cd2]','form_claim[name]'), 500, 450,1,1);\"");
    }

    $form->addGroup($button, "button", "");
    //次へボタン
    if($next_id != null){
        $form->addElement("button","next_button","次　へ","onClick=\"location.href='./1-1-103.php?client_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","次　へ","disabled");
    }
    //前へボタン
    if($back_id != null){
        $form->addElement("button","back_button","前　へ","onClick=\"location.href='./1-1-103.php?client_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","前　へ","disabled");
    }
}

/*******************************/
//関数
/*******************************/
//初期部署登録関数
function Regist_Init_Part($db_con,$shop_id){

    $sql  = "INSERT INTO ";
    $sql .= "t_part(";
    $sql .= "part_id, part_cd, part_name, branch_id,note, ";
    $sql .= "shop_id";
    $sql .= ") ";
    $sql .= "VALUES(";
    $sql .= "(SELECT COALESCE(MAX(part_id), 0)+1 FROM t_part), ";
    $sql .= "'001', ";
    $sql .= "'初期部署', ";
    $sql .= "NULL, ";
    $sql .= "'', ";
    $sql .= "$shop_id ";
    $sql .= ") ";
    $sql .= ";";

    $result  = Db_Query($db_con, $sql);

}

//初期支店を部署に登録する関数
function Update_Part_Branch($db_con,$shop_id,$branch_id){

    // 変更SQL
    $sql  = "UPDATE t_part SET ";
    $sql .= "branch_id     = '$branch_id' ";
    $sql .= "WHERE shop_id = $shop_id ";
    $sql .= ";";

    $result  = Db_Query($db_con, $sql);

}


//親を変更した場合に子をアップデートする関数
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

//変更時に代行先OR照会口座先として指定されている伝票をアップデート
function Aord_Act_Data_Update ($conn, $act_data){

    //代行伝票アップデート
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

    //紹介口座先アップデート
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

/****************************契約終了日取得*************************/

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
//請求先
$where_sql = "    WHERE";
$where_sql .= "        client_div = '3'";

$code_value = Code_Value("t_client",$conn,'',4);

/****************************/
//js
/****************************/
//取引区分に現金を選択した場合は、締日を支払日にする。
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
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成
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
//ヘッダーに表示させる取引中データ件数
$result = Db_Query($conn, $count_sql);
$dealing_count = pg_fetch_result($result,0,0);

$count_sql  = " SELECT ";
$count_sql .= "     COUNT(client_cd1)";
$count_sql .= " FROM";
$count_sql .= "    t_client ";
$count_sql .= " WHERE";
$count_sql .= "    client_div = '3'";
$count_sql .= ";";
//ヘッダーに表示させる全件数
$result = Db_Query($conn, $count_sql);
$total_count = pg_fetch_result($result,0,0);

$page_title .= "(取引中".$dealing_count."件/全 ".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
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

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
