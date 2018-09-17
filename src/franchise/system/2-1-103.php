<?php
/******************************
*変更履歴
*   （2006/05/15）修正分反映
*   （2006/05/22）請求先IDを登録前に取得するように変更
*   （2006/05/24）「集金日」を変更。
*   （2006/05/24）「締日」の右側に「集金方法」を表示し、「集金日」の右側は空けておく。
*   （2006/05/24）「集金方法」に「自動引落」を追加し「納品時」を削除する。
*   （2006/05/24）「取引区分」で「現金売上」を選択した場合は、「締日」「集金日」は空白を選択する。
*   （2006/05/29）種別の追加
*   （2006/06/16）敬称
*   （2006/06/19）代表者の必須チェックを無効にする。
*   （2006/06/22）契約に遷移する際に、取引先IDを渡す。
*   （2006/07/06）shop_gidをなくす(kaji)
*   （2006/07/07）代行の場合は得意先名・略称変更不可(suzuki)
*   （2006/07/21）口座区分登録(suzuki)
*    (2006/07/22)得意先マスタで異なる請求先を指定する場合には、(watanabe-k)
        以下の項目に関しては請求先と同様の設定をする。
            ・締日
            ・課税単位
            ・消費税端数区分
            ・金額のまるめ区分
*    (2006/07/28) 請求書、売上伝票発行パターン登録処理追加（watanabe-k）
*    (2006/07/31) 課税区分登録、変更処理追加（watanabe-k）
*    (2006/08/07) 戻るボタンの遷移先を変更（watanabe-k）
*    (2006/08/21) 「銀行手数料」と「設備・その他」が変更できないバグの修正(watanabe-k)
*    (2006/08/22) 請求先２の登録処理を追加（watanabe-k）
*    (2006/08/23) DB構成変更に伴い請求先２の登録処理を変更（watanabe-k）
*    (2006/08/29) 「締日」が月末で「集金日」が当月の1日という不正な設定ができてしまう。（watanabe-k）
*    (2006/08/31)口座番号を登録できるように変更（watanabe-k）
*    (2006/09/02) 変更時にクエリエラーが出るバグを修正（kaji）
*    (2006/09/30) 請求先1登録時にクエリーエラーが出るバグを修正（kaji）
*    (2006/10/30) 変更時の状態が「休止中・解約」のときの受注伝票削除処理追加（suzuki）
*                「休止中・解約」から取引中に変更したときの受注伝票作成処理追加（suzuki）
*     2006/11/13          kaku-m  TEL・FAX番号のチェックを関数で行うように修正。
*    (2006/11/22) 「休止中・解約」から取引中に変更したときに巡回日削除処理修正（suzuki）

     (2006-11-28) 依頼中の契約の巡回日も作成するように修正<suzuki>
	              理由：契約登録時には巡回日を作成している為、依頼中のままだとCRONを実行しても依頼中の巡回日は作成されない。
	                    本当なら受託した時に作成すればいいのだが、変更ステップ数が大きい為、得意先側を修正
*******************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0085    suzuki      登録・変更のログを残すように修正
 *  2006-12-22      new_0005    kajioka-h   担当情報の部署1~3が変更できなかったバグ修正
 *  2007-01-24                  watanabe-k  照会口座先にFCを選択可能とする処理を追加
 *  2007-02-01                  watanabe-k  振込名義１と振込名義２を請求先１に合わせるように修正
 *  2007-02-02                  watanabe-k  付番前の伝票には変更内容を反映する処理を追加
 *  2007-02-16                  watanabe-k  集金方法に手形を追加
 *  2007-02-16                  morita-d    担当支店を支店マスタか抽出するように変更
 *  2007-02-22                  watanabe-k  不要機能を削除
 *  2007-02-28                  watanabe-k  直営以外で紹介口座にFCが選択できないように修正
 *  2007-03-14                  watanabe-k  親で変更した内容を子に反映するように修正
 *  2007-03-16     その他79     watanabe-k  種別の削除、グループの位置変更
 *  2007-03-27     その他105    watanabe-k  売上伝票の発行形式に無効を追加
 *  2007-04-03                  watanabe-k  ■得意先マスタの契約担当1と契約担当2は以下のようにする

                                            ・名称を以下のように変更
                                            「契約担当1」⇒「現契約担当」
                                            「契約担当2」⇒「初期契約社員」

                                            ・プルダウンに表示するスタッフは以下のようにする
                                            「現契約担当」は在職者のみを表示する
                                            「初期契約社員」は全スタッフを表示する  
 *  2007-04-04                  watanabe-k　紹介口座先が変更された場合も予定データをアップデートするように修正
 *  2007-04-05                  morita-d　　取引状態を変更しても予定データ作成しないように修正
 *  2007-04-05                  morita-d　　紹介口座料を設定できないように修正
 *  2007-04-11                  watanabe-k　紹介口座先が　有　⇒　無　になった場合請求内容テーブルの口座率と口座単価にnullをセット
 *  2007-04-23                  watanabe-k  グループ選択時の独立チェックをはずす
 *  2007-05-04                  watanabe-k  確定されていない伝票に変更内容を反映する
 *  2007-05-08                  watanabe-k  取引区分に現金を指定した場合は、締日を支払日とする
 *  2007-05-09                  morita-d    丸め区分が変更された場合、契約マスタの金額を再計算し警告を表示する
 *  2007-05-18                  watanabe-k  請求書を作成する月を選択できるように修正
 *  2007-05-31                  watanabe-k  伝票発行形式を確定されていない伝票に反映するように修正 
 *  2007-06-20                  morita-d    前受金の受注伝票を、売掛に変更する処理を追加 
 *  2007-07-12                  watanabe-k  伝票発行の無を他表に変更
 *  2009/12/25                  aoyama-n    課税区分の内税を削除
 *  2010-05-01      Rev.1.5　　 hashimoto-y 請求書の宛先フォントサイズ変更機能の追加
 *  2011-02-11      Rev.1.6　　 watanabe-k  契約マスタへ渡す得意先IDの抽出が正しくないバグの修正
 *  2015/04/03                  amano  Dialogue関数でボタン名が送られない IE11 バグ対応
*/

$page_title = "得意先マスタ";

// 環境設定ファイル
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //契約関連の関数

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null, "onSubmit=return confirm(true)");

// DBに接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
// 初期値設定(radio・select)
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
// 新規判別
/****************************/
$shop_id        = $_SESSION[client_id];
$group_kind     = $_SESSION[group_kind];
$staff_id       = $_SESSION[staff_id];
$get_client_id  = (isset($_GET["client_id"])) ? $_GET["client_id"] : null;
$new_flg        = (isset($_GET["client_id"])) ? false : true;

/* GETしたIDの正当性チェック */
$where  = " client_div = '1' AND ";
$where .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().")" : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["client_id"] != null && Get_Id_Check_Db($conn, $_GET["client_id"], "client_id", "t_client", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
// 初期設定（GETがある場合）
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
    $select_sql .= "    t_client_intro_act.client_div AS intro_act_div,\n";     //紹介口座先区分
    $select_sql .= "    t_client_intro_act.client_cd2 AS intro_act_cd2, \n";     //紹介口座先コード２
    $select_sql .= "    t_client_intro_act.intro_account_id  AS intro_act_id, \n";      //紹介口座先ID

    //請求書作成月
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
    //請求書宛先フォント
    $select_sql .= "    t_client.bill_address_font ";

    $select_sql .= " FROM\n";
    $select_sql .= "    t_client\n";
    $select_sql .= "        INNER JOIN\n";

    //請求先１用の結合
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

    //取引先情報テーブル
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

    //請求先２用の結合
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

    //取引先情報テーブル
    $select_sql .= "    t_client_info";
    $select_sql .="     ON t_client.client_id = t_client_info.client_id";
    $select_sql .= " WHERE\n";
    $select_sql .= "    t_client.client_id = $_GET[client_id]\n";
    $select_sql .= ";";

    // クエリ発行
    $result = Db_Query($conn, $select_sql);
    Get_Id_Check($result);
    // データ取得
    $client_data = @pg_fetch_array($result, 0);

    // 初期値データ
    $defa_data["form_client"]["cd1"]          = $client_data[0];         // 得意先コード１
    $defa_data["form_client"]["cd2"]          = $client_data[1];         // 得意先コード２
    $defa_data["form_state"]                  = $client_data[2];         // 状態
    $defa_data["form_client_name"]            = $client_data[3];         // 得意先名
    $defa_data["form_client_read"]            = $client_data[4];         // 得意先名(フリガナ)
    $defa_data["form_client_cname"]           = $client_data[5];         // 略称
    $defa_data["form_post"]["no1"]            = $client_data[6];         // 郵便番号１
    $defa_data["form_post"]["no2"]            = $client_data[7];         // 郵便番号２
    $defa_data["form_address1"]               = $client_data[8];         // 住所１
    $defa_data["form_address2"]               = $client_data[9];         // 住所２
    $defa_data["form_address_read"]           = $client_data[10];        // 住所(フリガナ)
    $defa_data["form_area_id"]                = $client_data[11];        // 地区
    $defa_data["form_tel"]                    = $client_data[12];        // TEL
    $defa_data["form_fax"]                    = $client_data[13];        // FAX
    $defa_data["form_rep_name"]               = $client_data[14];        // 代表者氏名
    $defa_data["form_charger1"]               = $client_data[15];        // ご担当者１
    $defa_data["form_charger2"]               = $client_data[16];        // ご担当者２
    $defa_data["form_charger3"]               = $client_data[17];        // ご担当者３
    $defa_data["form_charger_part1"]          = $client_data[18];        // 窓口ご担当
    $defa_data["form_charger_part2"]          = $client_data[19];        // キーマン
    $trade_stime1[1] = substr($client_data[20],0,2);
    $trade_stime1[2] = substr($client_data[20],3,2);
    $trade_etime1[1] = substr($client_data[21],0,2);
    $trade_etime1[2] = substr($client_data[21],3,2);
    $trade_stime2[1] = substr($client_data[22],0,2);
    $trade_stime2[2] = substr($client_data[22],3,2);
    $trade_etime2[1] = substr($client_data[23],0,2);
    $trade_etime2[2] = substr($client_data[23],3,2);
    $defa_data["form_trade_stime1"]["h"]      = $trade_stime1[1];        // 営業時間(午前開始時間)
    $defa_data["form_trade_stime1"]["m"]      = $trade_stime1[2];        // 営業時間(午前開始時間)
    $defa_data["form_trade_etime1"]["h"]      = $trade_etime1[1];        // 営業時間(午前終了時間)
    $defa_data["form_trade_etime1"]["m"]      = $trade_etime1[2];        // 営業時間(午前終了時間)
    $defa_data["form_trade_stime2"]["h"]      = $trade_stime2[1];        // 営業時間(午後後開始時間)
    $defa_data["form_trade_stime2"]["m"]      = $trade_stime2[2];        // 営業時間(午後開始時間)
    $defa_data["form_trade_etime2"]["h"]      = $trade_etime2[1];        // 営業時間(午後終了時間)
    $defa_data["form_trade_etime2"]["m"]      = $trade_etime2[2];        // 営業時間(午後終了時間)
    $defa_data["form_holiday"]                = $client_data[24];        // 休日
    $defa_data["form_btype"]                  = $client_data[25];        // 業種
    $defa_data["form_b_struct"]               = $client_data[26];        // 業態
    $defa_data["form_claim"]["cd1"]           = $client_data[27];        // 請求先コード１
    $defa_data["form_claim"]["cd2"]           = $client_data[28];        // 請求先コード２
    $defa_data["form_claim"]["name"]          = $client_data[29];        // 請求先名

    $defa_data["form_intro_act"]["cd"]        = $client_data[30];        // 紹介口座先コード
    $defa_data["form_intro_act"]["name"]      = $client_data[31];        // 紹介口座先名
    /*
		if($client_data[32] != null){
        $defa_data["form_account"]["1"] = checked;
        $check_which = 1;
        $defa_data["form_account"]["price"]       = $client_data[32];        // 口座料
    }
    if($client_data[33] != null){
        $defa_data["form_account"]["2"] = checked;
        $check_which = 2;
        $defa_data["form_account"]["rate"]        = $client_data[33];        // 口座料(率)
    }
		*/
    //$defa_data["form_cshop"]                  = $client_data[34];        // 担当支店
    $defa_data["form_c_staff_id1"]            = $client_data[35];        // 契約担当１
    $defa_data["form_c_staff_id2"]            = $client_data[36];        // 契約担当２
//     $defa_data["form_d_staff_id1"]            = $client_data[37];        // 巡回担当１
//     $defa_data["form_d_staff_id2"]            = $client_data[38];        // 巡回担当２
//     $defa_data["form_d_staff_id3"]            = $client_data[39];        // 巡回担当３
    $defa_data["form_col_terms"]              = $client_data[37];        // 回収条件
    $defa_data["form_cledit_limit"]           = $client_data[38];        // 与信限度
    $defa_data["form_capital"]                = $client_data[39];        // 資本金
    $defa_data["trade_aord_1"]                = $client_data[40];        // 取引区分
    $defa_data["form_close"]                  = $client_data[41];        // 締日
    $defa_data["form_pay_m"]                  = $client_data[42];        // 集金日(月) 
    $defa_data["form_pay_d"]                  = $client_data[43];        // 集金日(日)
    $defa_data["form_pay_way"]                = $client_data[44];        // 集金方法
    $defa_data["form_bank"][1]                = $client_data[45];        // 振込銀行
    $defa_data["form_pay_name"]               = $client_data[46];        // 振込名義
    $defa_data["form_account_name"]           = $client_data[47];        // 口座名義
    $cont_s_day[y] = substr($client_data[48],0,4);
    $cont_s_day[m] = substr($client_data[48],5,2);
    $cont_s_day[d] = substr($client_data[48],8,2);
    $cont_e_day[y] = substr($client_data[49],0,4);
    $cont_e_day[m] = substr($client_data[49],5,2);
    $cont_e_day[d] = substr($client_data[49],8,2);
    $cont_r_day[y] = substr($client_data[51],0,4);
    $cont_r_day[m] = substr($client_data[51],5,2);
    $cont_r_day[d] = substr($client_data[51],8,2);
    $defa_data["form_cont_s_day"]["y"]        = $cont_s_day[y];          // 契約年月日(年)
    $defa_data["form_cont_s_day"]["m"]        = $cont_s_day[m];          // 契約年月日(月)
    $defa_data["form_cont_s_day"]["d"]        = $cont_s_day[d];          // 契約年月日(日)
    $defa_data["form_cont_e_day"]["y"]        = $cont_e_day[y];          // 契約終了日(年)
    $defa_data["form_cont_e_day"]["m"]        = $cont_e_day[m];          // 契約終了日(月)
    $defa_data["form_cont_e_day"]["d"]        = $cont_e_day[d];          // 契約終了日(日)
    $defa_data["form_cont_peri"]              = $client_data[50];        // 契約期間
    $defa_data["form_cont_r_day"]["y"]        = $cont_r_day[y];          // 契約更新日(年)
    $defa_data["form_cont_r_day"]["m"]        = $cont_r_day[m];          // 契約更新日(月)
    $defa_data["form_cont_r_day"]["d"]        = $cont_r_day[d];          // 契約更新日(日)
    $defa_data["form_slip_out"]               = $client_data[52];        // 伝票発行
    $defa_data["form_deliver_note"]           = $client_data[53];        // 納品書コメント
    $defa_data["form_claim_out"]              = $client_data[54];        // 請求書発行
    $defa_data["form_coax"]                   = $client_data[55];        // 丸め
    $defa_data["form_tax_div"]                = $client_data[56];        // 消費税(課税単位)
    $defa_data["form_tax_franct"]             = $client_data[57];        // 消費税(端数区分)
    $defa_data["form_note"]                   = $client_data[58];        // 設備情報等・その他
    $defa_data["form_email"]                  = $client_data[59];        // Email
    $defa_data["form_url"]                    = $client_data[60];        // URL
    $defa_data["form_represent_cell"]         = $client_data[61];        // 代表者携帯
    $defa_data["form_direct_tel"]             = $client_data[62];        // 直通TEL
    $defa_data["form_bstruct"]                = $client_data[63];        // 業態
    $defa_data["form_inst"]                   = $client_data[64];        // 施設
    $establish_day[y] = substr($client_data[65],0,4);
    $establish_day[m] = substr($client_data[65],5,2);
    $establish_day[d] = substr($client_data[65],8,2);
    $defa_data["form_establish_day"]["y"]     = $establish_day[y];       // 創業日(年)
    $defa_data["form_establish_day"]["m"]     = $establish_day[m];       // 創業日(月)
    $defa_data["form_establish_day"]["d"]     = $establish_day[d];       // 創業日(日)
    $defa_data["form_record"]                 = $client_data[66];        // 取引履歴
    $defa_data["form_important"]              = $client_data[67];        // 重要事項
    $defa_data["form_trans_account"]          = $client_data[68];        // お振込先口座名
    $defa_data["form_bank_fc"]                = $client_data[69];        // 銀行/支店名
    $defa_data["form_account_num"]            = $client_data[70];        // 口座番号
    $round_start[y] = substr($client_data[71],0,4);
    $round_start[m] = substr($client_data[71],5,2);
    $round_start[d] = substr($client_data[71],8,2);
    $defa_data["form_round_start"]["y"]       = $round_start[y];         // 巡回開始日(年)
    $defa_data["form_round_start"]["m"]       = $round_start[m];         // 巡回開始日(月)
    $defa_data["form_round_start"]["d"]       = $round_start[d];         // 巡回開始日(日)
    $defa_data["form_deliver_radio"]          = $client_data[72];        // 納品書コメント(効果)
    $defa_data["form_claim_send"]             = $client_data[73];        // 請求書送付(郵送)
    $defa_data["form_charger_part3"]          = $client_data[74];        // 経理会計窓口
    $defa_data["form_cname_read"]             = $client_data[76];        // 略称(フリガナ)
    $defa_data["form_rep_position"]           = $client_data[77];        // 代表者役職
    $defa_data["form_bank"][0]                = $client_data[78];        // 振込銀行
    $defa_data["form_address3"]               = $client_data[79];        // 住所３
    $defa_data["form_company_name"]           = $client_data[80];        // 親会社名
    $defa_data["form_company_tel"]            = $client_data[81];        // 親会社TEL
    $defa_data["form_company_address"]        = $client_data[82];        // 親会社住所
    $defa_data["form_client_name2"]           = $client_data[83];        // 得意先名2
    $defa_data["form_client_read2"]           = $client_data[84];        // 得意先名2(フリガナ)
    $defa_data["form_charger_represe1"]       = $client_data[85];        // ご担当者役職１
    $defa_data["form_charger_represe2"]       = $client_data[86];        // ご担当者役職２
    $defa_data["form_charger_represe3"]       = $client_data[87];        // ご担当者役職３
    $defa_data["form_charger_note"]           = $client_data[88];        // ご担当者備考
    $defa_data["form_bank_div"]               = $client_data[89];        // ご担当者備考
    $defa_data["form_claim_note"]             = $client_data[90];        // 請求書コメント
    $defa_data["form_client_slip1"]           = $client_data[91];        // 得意先１伝票印字
    $defa_data["form_client_slip2"]           = $client_data[92];        // 得意先２伝票印字
    $defa_data["form_parent_rep_name"]        = $client_data[93];        // 親会社代表者氏名
    $parent_establish_day[y] = substr($client_data[94],0,4);
    $parent_establish_day[m] = substr($client_data[94],5,2);
    $parent_establish_day[d] = substr($client_data[94],8,2);
    $defa_data["form_parent_establish_day"]["y"]   = $parent_establish_day[y];
    $defa_data["form_parent_establish_day"]["m"]   = $parent_establish_day[m];
    $defa_data["form_parent_establish_day"]["d"]   = $parent_establish_day[d];
//    $defa_data["form_type"]                   = $client_data[95];
    $defa_data["form_prefix"]                 = $client_data[96];
    $defa_data["form_act_flg"]                = $client_data[97];            // 代行フラグ
    $act_flg                                  = $client_data[97];        
    $defa_data["form_s_pattern_select"]       = $client_data[98];            //伝票発行パターン
    $defa_data["form_c_pattern_select"]       = $client_data[99];            //請求書発効パターン
    $defa_data["form_charge_branch_id"]       = $client_data[charge_branch_id];           //担当支店
    $defa_data["form_c_tax_div"]              = $client_data["c_tax_div"];   //課税区分
    $defa_data["form_claim2"]["cd1"]          = $client_data["claim2_cd1"];  //請求先２コード１
    $defa_data["form_claim2"]["cd2"]          = $client_data["claim2_cd2"];  //請求先２コード２
    $defa_data["form_claim2"]["name"]         = $client_data["claim2_name"]; //請求先２名
    $defa_data["form_bank"][2]                = $client_data["account_id"]; //口座ID 

    $defa_data["form_client_gr"]              = $client_data["client_gr_id"];
    $defa_data["form_parents_div"]            = $client_data["parents_flg"];


    #2010-04-30 hashimoto-y
    $defa_data["form_bill_address_font"]      = ($client_data["bill_address_font"] == 't')? 1 : 0;


    if($client_data["intro_act_div"] == '3'){
        $defa_data["form_intro_act"]["cd2"]       = $client_data["intro_act_cd2"];  //紹介口座先CD2
        $defa_data["form_client_div"]         = '1';
    }elseif($client_data["intro_act_div"] == '2'){
        $defa_data["form_client_div"]         = '2';
    }else{
        $defa_data["form_client_div"]         = '1';
    }
//    $defa_data["hdn_intro_ac_id"]             = $client_data["intro_act_id"];   //紹介口座ID


    //請求書作成月
    for($i = 0; $i < 12; $i++){
        $defa_data["claim1_monthly_check"][$i] = ($client_data["month".($i+1)."_flg"] == 't')? $client_data["month".($i+1)."_flg"] : null;
    }

   // 初期値設定
    $form->setDefaults($defa_data);

    $id_data = Make_Get_Id($conn, "client",$client_data[0].",".$client_data[1]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    // 自分が他の請求先として登録されているか
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

    // 変更不可フラグ
    $change_flg = ($claim_num > 0) ? true : false;

    //請求先２に値があり、売掛残がある場合
    if($client_data["claim2_id"] != null){
        $warning = "※ 請求先２は削除できますが、今までの売掛は請求に挙がらなくなります。";
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
// フォーム作成
/***************************/
// 種別
/*
$form_type[] =& $form->createElement("radio", null, null, "リピート", "1");
$form_type[] =& $form->createElement("radio", null, null, "リピート外", "2");
$form->addGroup($form_type, "form_type", "");
*/
// 得意先コード
$form_client[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_client[cd1]', 'form_client[cd2]',6)\"".$g_form_option."\"");
$form_client[] =& $form->createElement("static", "", "", "-");
$form_client[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_client, "form_client", "");

// 得意先コード空きコード検索リンク
$form->addElement("link", "form_cd_search", "", "#", "空きコード検索", "tabindex=\"-1\" 
    onClick=\"javascript:return Open_SubWin('../dialog/2-0-103.php', Array('form_client[cd1]','form_client[cd2]'), 570, 650, 3, 1);\"
");

// 取引中
$text = null;
$text[] =& $form->createElement("radio", null, null, "取引中", "1");
$text[] =& $form->createElement("radio", null, null, "解約・休止中", "2");
//$text[] =& $form->createElement("radio", null, null, "解約", "3");
$freeze_state = $form->addGroup($text, "form_state", "");

//一時的に状態を変更不可----------------------------------------------------------------------------------------------------------------------------------------
//if($new_flg == false){
//    $freeze_state->freeze();
//}
//--------------------------------------------------------------------------------------------------------------------------------------------------------------



// 得意先名
$freeze_text[] = $form->addElement("text", "form_client_name", "",'size="44" maxLength="25"'." $g_form_option");

// 得意先名２
$freeze_text[] = $form->addElement("text", "form_client_name2", "",'size="44" maxLength="25"'." $g_form_option");

// 得意先名（フリガナ）
$freeze_text[] = $form->addElement("text", "form_client_read", "",'size="46" maxLength="50"'." $g_form_option");

// 得意先名２（フリガナ）
$freeze_text[] = $form->addElement("text", "form_client_read2", "",'size="46" maxLength="50"'." $g_form_option");

// 得意先名１伝票印字
$form->addElement("checkbox", "form_client_slip1", "");

// 得意先名２伝票印字
$form->addElement("checkbox", "form_client_slip2", "");


// 略称
$freeze_text[] = $form->addElement("text", "form_client_cname", "",'size="44" maxLength="20"'." $g_form_option");

// 略称（フリガナ）
$freeze_text[] = $form->addElement("text", "form_cname_read", "",'size="46" maxLength="40"'." $g_form_option");

// 郵便番号
$form_post[] =& $form->createElement("text", "no1", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_post[no1]', 'form_post[no2]',3)\"".$g_form_option."\"");
$form_post[] =& $form->createElement("static", "", "", "-");
$form_post[] =& $form->createElement("text", "no2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_post, "form_post", "");

// 住所１
$form->addElement("text", "form_address1", "",'size="44" maxLength="25"'." $g_form_option");

// 住所２
$form->addElement("text", "form_address2", "",'size="46" maxLength="25"'." $g_form_option");

// 住所３
$form->addElement("text", "form_address3", "",'size="44" maxLength="30"'." $g_form_option");

// 住所(フリガナ)
$form->addElement("text", "form_address_read", "",'size="46" maxLength="50"'." $g_form_option");
        
// 郵便番号
// 自動入力ボタンが押下された場合
if($_POST["input_button_flg"] == true){
    $post1      = $_POST["form_post"]["no1"];             // 郵便番号１
    $post2      = $_POST["form_post"]["no2"];             // 郵便番号２
    $post_value = Post_Get($post1, $post2, $conn);
    // 郵便番号フラグをクリア
    $cons_data["input_button_flg"]  = "";
    // 郵便番号から自動入力
    $cons_data["form_post"]["no1"]  = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"]  = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"]     = $post_value[1];
    $cons_data["form_address2"]     = $post_value[2];

    $form->setConstants($cons_data);
}

// 地区
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

// 代表者
$form->addElement("text", "form_rep_name", "",'size="34" maxLength="15"'." $g_form_option");

// 代表者役職
$form->addElement("text", "form_rep_position", "",'size="22" maxLength="10"'." $g_form_option");

// 代表者携帯
$form->addElement("text", "form_represent_cell", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option");

// 直通TEL
$form->addElement("text", "form_direct_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\""." $g_form_option");

// 親会社名
$form->addElement("text", "form_company_name", "", "size=\"44\" maxLength=\"30\" $g_form_option");

// 親会社TEL
$form->addElement("text", "form_company_tel", "", "size=\"34\" maxLength=\"30\" style=\"$g_form_style\" $g_form_option");

// 親会社住所
$form->addElement("text", "form_company_address", "", "size=\"120\" maxLength=\"100\" $g_form_option");

// 親会社創業日
$form_parent_establish_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_parent_establish_day[y]', 'form_parent_establish_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_parent_establish_day[] =& $form->createElement("static", "", "", "-");
$form_parent_establish_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_parent_establish_day[m]', 'form_parent_establish_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_parent_establish_day[] =& $form->createElement("static", "", "", "-");
$form_parent_establish_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_parent_establish_day, "form_parent_establish_day", "");

// 親会社代表者氏名
$form->addElement("text", "form_parent_rep_name", "",'size="34" maxLength="15"'." $g_form_option");

// 部署１
$form->addElement("text", "form_charger_part1", "", "size=\"22\" maxLength=\"10\" $g_form_option");
// 部署２
$form->addElement("text", "form_charger_part2", "", "size=\"22\" maxLength=\"10\" $g_form_option");
// 部署３
$form->addElement("text", "form_charger_part3", "", "size=\"22\" maxLength=\"10\" $g_form_option");
// 役職１
$form->addElement("text", "form_charger_represe1", "", "size\"22\" maxLength=\"10\" $g_form_option");
// 役職２
$form->addElement("text", "form_charger_represe2", "", "size\"22\" maxLength=\"10\" $g_form_option");
// 役職３
$form->addElement("text", "form_charger_represe3", "", "size\"22\" maxLength=\"10\" $g_form_option");

// ご担当1
$form->addElement("text", "form_charger1", "",'size="34" maxLength="15"'." $g_form_option");

// ご担当2
$form->addElement("text", "form_charger2", "",'size="34" maxLength="15"'." $g_form_option");

// ご担当3
$form->addElement("text", "form_charger3", "",'size="34" maxLength="15"'." $g_form_option");

// 担当者備考
$form->addElement("textarea", "form_charger_note", "", 'rows="5" cols="75"'." $g_form_option_area");

// 銀行手数料負担区分
$form_bank_div[] =& $form->createElement("radio", null, null, "お客様負担", "1");
$form_bank_div[] =& $form->createElement("radio", null, null, "自社負担", "2");
$form->addGroup($form_bank_div, "form_bank_div", "");

// 営業時間
// 午前開始時間
$form_stime1[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime1[h]', 'form_trade_stime1[m]',2)\"".$g_form_option."\"");
$form_stime1[] =& $form->createElement("static", "", "", "：");
$form_stime1[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime1[m]', 'form_trade_etime1[h]',2)\"".$g_form_option."\"");
$form->addGroup($form_stime1, "form_trade_stime1", "");

// 午前終了時間
$form_etime1[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_etime1[h]', 'form_trade_etime1[m]',2)\"".$g_form_option."\"");
$form_etime1[] =& $form->createElement("static", "", "", "：");
$form_etime1[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_etime1[m]', 'form_trade_stime2[h]',2)\"".$g_form_option."\"");
$form->addGroup($form_etime1, "form_trade_etime1", "");

// 午後開始時間
$form_stime2[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime2[h]', 'form_trade_stime2[m]',2)\"".$g_form_option."\"");
$form_stime2[] =& $form->createElement("static", "", "", "：");
$form_stime2[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_stime2[m]', 'form_trade_etime2[h]',2)\"".$g_form_option."\"");
$form->addGroup($form_stime2, "form_trade_stime2", "");

// 午後終了時間
$form_etime2[] =& $form->createElement("text", "h", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_trade_etime2[h]', 'form_trade_etime2[m]',2)\"".$g_form_option."\"");
$form_etime2[] =& $form->createElement("static", "", "", "：");
$form_etime2[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\""." $g_form_option");
$form->addGroup($form_etime2, "form_trade_etime2", "");

// 休日
$form->addElement("text", "form_holiday", "",'size="22" maxLength="10"'." $g_form_option");

// 業種
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
            $data_list[1] = $data_list[1]."　";
        }
    }
    
    $select_value[$data_list[2]] = $data_list[0]." ： ".$data_list[1]."　　 ".$data_list[3]." ： ".$data_list[4];
}

$form->addElement("select", "form_btype", "", $select_value, $g_form_option_select);

// 施設
$sql    = "SELECT inst_id, inst_cd, inst_name FROM t_inst WHERE accept_flg = '1' ORDER BY inst_cd;";
$result = Db_Query($conn, $sql);
$select_value       = "";
$select_value[""]   = "";
while($data_list = pg_fetch_array($result)){
    $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
$form->addElement("select", 'form_inst',"", $select_value,$g_form_option_select);

// 業態
$sql    = "SELECT bstruct_id, bstruct_cd, bstruct_name FROM t_bstruct WHERE accept_flg = '1' ORDER BY bstruct_cd;";
$result = Db_Query($conn, $sql);
$select_value       = "";
$select_value[""]   = "";
while($data_list = pg_fetch_array($result)){
    $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
$form->addElement("select", 'form_bstruct',"", $select_value,$g_form_option_select);

// 請求先1
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

//請求先２
$form_claim2[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\" 
            onkeyup=\"changeText(this.form, 'form_claim2[cd1]', 'form_claim2[cd2]',6)\" 
            onkeyup=\"javascript:claim1('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]','','',''); 
            changeText(this.form,'form_claim2[cd1]','form_claim2[cd2]',6)\"".$g_form_option."\"");
$form_claim2[] =& $form->createElement("static", "", "", "-");
$form_claim2[] =& $form->createElement("text", "cd2", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"javascript:claim1('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]','','','')\"".$g_form_option."\"");
$form_claim2[] =& $form->createElement("text", "name", "", "size=\"44\" $g_text_readonly");
$freeze = $form->addGroup($form_claim2, "form_claim2", "");
($change_flg == true) ? $freeze->freeze() : null;

// 紹介口座先
//直営の場合のみ
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

//照会口座用ラジオボタン
$form_client_div[] =& $form->createElement("radio", null, null, "FC", "1", "onClick=code_disable(); onChange=client_div();");
$form_client_div[] =& $form->createElement("radio", null, null, "仕入先", "2", "onClick=code_disable(); onChange=client_div();");
$form->addGroup($form_client_div, "form_client_div", "");

// お振込先口座名
$form->addElement("text", "form_trans_account", "",'size="34" maxLength="20"'." $g_form_option");

// 銀行支店名
$form->addElement("text", "form_bank_fc", "",'size="34" maxLength="20"'." $g_form_option");

// 口座番号
$form->addElement("text", "form_account_num", "", "size=\"20\" maxLength=\"15\" style=\"$g_form_style\""." $g_form_option");

/*
// 口座料(口座名義ごと)
$form_account[] =& $form->createElement("checkbox", "1" ,"" ,"" ,"onClick='return Check_Button2(1);'");
$form_account[] =& $form->createElement("static", "　", "", "固定金額");
$form_account[] =& $form->createElement("text", "price", "", "size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form_account[] =& $form->createElement("static", "", "", "円　　　　");
$form_account[] =& $form->createElement("checkbox", "2" ,"" ,"" ,"onClick='return Check_Button2(2);'");
$form_account[] =& $form->createElement("static", "", "", "売上の");
$form_account[] =& $form->createElement("text", "rate", "", "size=\"3\" maxLength=\"3\" $g_form_option style=\"text-align: right; $g_form_style\"");
$form_account[] =& $form->createElement("static", "", "", "％");
$form->addGroup($form_account, "form_account", "");
*/


// 担当支店
/*
if($_SESSION[group_kind] == "2"){
    $select_ary = Select_Get($conn,'dshop');
}else{
    $where  = " AND t_client.client_id = $_SESSION[client_id]";
    $select_ary = Select_Get($conn,'fshop',$where);
}
$form->addElement("select", 'form_cshop',"", $select_ary, $g_form_option_select );
*/

// 担当支店
$select_value = Select_Get($conn,'branch');
$form->addElement('select', 'form_charge_branch_id', '支店', $select_value,$g_form_option_select);

// 契約担当1
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
    $select_value[$data_list[0]] = $data_list[1]." ： ".$data_list[2];
}
*/

$select_ary = Select_Get($conn,'cstaff');
$form->addElement("select", 'form_c_staff_id1', "", $select_ary, $g_form_option_select );

// 契約担当2
// $select_ary = Select_Get($conn,'cstaff');
$select_ary = Select_Get($conn,'cstaff',"","1");
$form->addElement("select", 'form_c_staff_id2', "", $select_ary, $g_form_option_select );

// 巡回担当者1
// $select_ary = null;
// $select_ary = Select_Get($conn,'cstaff');
// $form->addElement("select", 'form_d_staff_id1',"", $select_ary, $g_form_option_select );

// 巡回担当者2
// $form->addElement("select", 'form_d_staff_id2',"", $select_ary, $g_form_option_select );

// 巡回担当者3
// $form->addElement("select", 'form_d_staff_id3',"", $select_ary, $g_form_option_select );

// 巡回開始日
$form_round_start[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_round_start[y]', 'form_round_start[m]',4)\" ".$g_form_option."\"");
$form_round_start[] =& $form->createElement("static", "", "", "-");
$form_round_start[] =& $form->createElement("text", "m", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_round_start[m]', 'form_round_start[d]',2)\" ".$g_form_option."\"");
$form_round_start[] =& $form->createElement("static", "", "", "-");
$form_round_start[] =& $form->createElement("text", "d", "", "size=\"1\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup($form_round_start, "form_round_start", "");

// 回収条件
$form->addElement("text", "form_col_terms", "",'size="34" maxLength="50"'." $g_form_option");

// 与信限度
$form->addElement("text", "form_cledit_limit", "", "class=money size=\"11\" maxLength=\"9\" $g_form_option style=\"text-align: right; $g_form_style\"");

// 資本金
$form->addElement("text", "form_capital", "", "class=money size=\"11\" maxLength=\"9\"$g_form_option style=\"text-align: right; $g_form_style\"");

// 取引区分
$select_value = Select_Get($conn, "trade_aord");
// $select_value[11] .= "　(締日、集金日が必須となります。)";
//$form->addElement("select", 'trade_aord_1', "", $select_value, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();pay_way()\"");
$form->addElement("select", 'trade_aord_1', "", $select_value, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_close_day();\"");

// 締日
$select_value = Select_Get($conn,'close');
$freeze = $form->addElement("select", "form_close", "締日", $select_value, "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();trade_close_day();\"");
//($change_flg == true) ? $freeze->freeze() : null;

// 集金日
// 月
$select_month[null] = null; 
for($i = 0; $i <= 12; $i++){
    if($i == 0){
        $select_month[$i] = "当月";
    }elseif($i == 1){
        $select_month[$i] = "翌月";
    }else{
        $select_month[$i] = $i."ヶ月後";
    }
}
$form->addElement("select", "form_pay_m", "", $select_month, $g_form_option_select);

// 日
for($i = 0; $i <= 29; $i++){
    if($i == 29){
        $select_day[$i] = '月末';
    }elseif($i == 0){
        $select_day[null] = null;
    }else{
        $select_day[$i] = $i."日";
    }
}
$form->addElement("select", "form_pay_d", "", $select_day, $g_form_option_select);

// 支払い方法
$select_value = Select_Get($conn, "pay_way");
$form->addElement("select", 'form_pay_way',"", $select_value,$g_form_option_select);      

// 振込銀行
/*
$select_ary = Select_Get($conn,'bank');
$sql  = " WHERE"; 
//$sql .= "   t_bank.shop_gid = $_SESSION[shop_gid]";
$sql .=($_SESSION[group_kind] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = $_SESSION[client_id] ";

$ary_b_bank = Select_Get($conn,'b_bank', $sql);
$bank_select = $form->addElement('hierselect', 'form_bank', '',$g_form_option_select ,
    "</td><td class=\"Title_Purple\"><b>振込銀行支店</b></td><td class=\"value\">");
$bank_select->setOptions(array($select_ary, $ary_b_bank));
*/

$select_ary = Make_Ary_Bank($conn);
$bank_select = $form->addElement('hierselect', 'form_bank', '',$g_form_option_select ,"　　　");
$bank_select->setOptions(array($select_ary[0], $select_ary[1], $select_ary[2]));


// 振込名義
$form->addElement("text", "form_pay_name", "",'size="34" maxLength="50"'." $g_form_option");

// 口座名義
$form->addElement("text", "form_account_name", "",'size="34" maxLength="15"'." $g_form_option");

// 契約年月日
$form_cont_s_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_s_day[y]', 'form_cont_s_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_s_day[] =& $form->createElement("static", "", "", "-");
$form_cont_s_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_s_day[m]', 'form_cont_s_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_s_day[] =& $form->createElement("static", "", "", "-");
$form_cont_s_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_cont_s_day, "form_cont_s_day", "");

// 契約終了日
$form_cont_e_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_e_day[y]', 'form_cont_e_day[m]',4)\"".$g_form_option."\"");
$form_cont_e_day[] =& $form->createElement("static", "", "", "-");
$form_cont_e_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_e_day[m]', 'form_cont_e_day[d]',2)\"".$g_form_option."\"");
$form_cont_e_day[] =& $form->createElement("static", "", "", "-");
$form_cont_e_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup($form_cont_e_day, "form_cont_e_day", "");

// 契約期間
$form->addElement("text", "form_cont_peri", "", "size=\"2\" maxLength=\"2\" style=\"text-align: right; $g_form_style\" onkeyup=\"Contract(this.form)\" $g_form_option");

// 契約更新日
$form_cont_r_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_r_day[y]', 'form_cont_r_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_r_day[] =& $form->createElement("static", "", "", "-");
$form_cont_r_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_cont_r_day[m]', 'form_cont_r_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_cont_r_day[] =& $form->createElement("static", "", "", "-");
$form_cont_r_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_cont_r_day, "form_cont_r_day", "");

// 創業日
$form_establish_day[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_establish_day[y]', 'form_establish_day[m]',4)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_establish_day[] =& $form->createElement("static", "", "", "-");
$form_establish_day[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form, 'form_establish_day[m]', 'form_establish_day[d]',2)\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form_establish_day[] =& $form->createElement("static", "", "", "-");
$form_establish_day[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onchange=\"Contract(this.form)\"".$g_form_option."\"");
$form->addGroup($form_establish_day, "form_establish_day", "form_establish_day");

// 伝票発行
$form_slip_out[] =& $form->createElement("radio", null, null, "有",   "1");
$form_slip_out[] =& $form->createElement("radio", null, null, "指定", "2");
$form_slip_out[] =& $form->createElement("radio", null, null, "他票（作業完了報告書等）",   "3");
$form->addGroup($form_slip_out, "form_slip_out", "");

// 納品書コメント
// ラヂオボタン
$form_deliver_radio[] =& $form->createElement("radio", null, null, "コメント無効", "1");
$form_deliver_radio[] =& $form->createElement("radio", null, null, "個別コメント有効", "2");
$form_deliver_radio[] =& $form->createElement("radio", null, null, "全体コメント有効", "3");
$form->addGroup($form_deliver_radio, "form_deliver_radio", "");
// テキスト
$form->addElement("textarea", "form_deliver_note", "",' rows="5" cols="75"'." $g_form_option_area");

#2010-04-30 hashimoto-y
// 請求書宛先フォント大
$form->addElement("checkbox", "form_bill_address_font", "");


// 請求書発行
$form_claim_out[] =& $form->createElement("radio", null, null, "明細請求書", "1");
$form_claim_out[] =& $form->createElement("radio", null, null, "合計請求書", "2");
$form_claim_out[] =& $form->createElement("radio", null, null, "個別明細請求書", "5");
$form_claim_out[] =& $form->createElement("radio", null, null, "出力しない", "3");
$form_claim_out[] =& $form->createElement("radio", null, null, "指定",       "4");
$form->addGroup($form_claim_out, "form_claim_out", "");
/*
// 請求範囲
$form_claim_scope[] =& $form->createElement("radio", null, null, "繰越額を含める", "t");
$form_claim_scope[] =& $form->createElement("radio", null, null, "繰越額を含めない", "f");
$form->addGroup($form_claim_scope, "form_claim_scope", "");
*/

// 請求書送付
$form_claim_send[] =& $form->createElement("radio", null, null, "郵送", "1");
$form_claim_send[] =& $form->createElement("radio", null, null, "メール", "2");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "WEB", "4");
$form_claim_send[] =& $form->createElement( "radio",null,NULL, "郵送・メール", "3");
$form->addGroup($form_claim_send, "form_claim_send", "");

// 請求書コメント
$form->addElement("textarea", "form_claim_note", "",' rows="5" cols="75"'." $g_form_option_area");

// 敬称
$form_prefix_radio[] =& $form->createElement("radio", null, null, "御中", "1");
$form_prefix_radio[] =& $form->createElement("radio", null, null, "様", "2");
$form->addGroup($form_prefix_radio, "form_prefix", "");

// 金額
// 丸め区分
$form_coax[] =& $form->createElement("radio", null, null, "切捨", "1");
$form_coax[] =& $form->createElement("radio", null, null, "四捨五入", "2");
$form_coax[] =& $form->createElement("radio", null, null, "切上", "3");
$freeze = $form->addGroup($form_coax, "form_coax", "");
//($change_flg == true) ? $freeze->freeze() : null;

// 課税単位
$form_tax_div[] =& $form->createElement("radio", null, null, "伝票単位", "2");
$form_tax_div[] =& $form->createElement("radio", null, null, "締日単位", "1");
$freeze = $form->addGroup($form_tax_div, "form_tax_div", "");
//($change_flg == true) ? $freeze->freeze() : null;

// 課税区分
$form_c_tax_div[] =& $form->createElement("radio", null, null, "外税", "1");
#2009-12-25 aoyama-n
#$form_c_tax_div[] =& $form->createElement("radio", null, null, "内税", "2");
$freeze = $form->addGroup($form_c_tax_div, "form_c_tax_div", "");
//($change_flg == true) ? $freeze->freeze() : null;
//一時的に状態を変更不可---------------------------------------------------------------------------------------------------------------
    //一時的
//    if($new_flg === false){
    $freeze->freeze();
//    }
//



// 端数区分
$form_tax_franct[] =& $form->createElement("radio", null, null, "切捨", "1");
$form_tax_franct[] =& $form->createElement("radio", null, null, "四捨五入", "2");
$form_tax_franct[] =& $form->createElement("radio", null, null, "切上", "3");
$freeze = $form->addGroup($form_tax_franct, "form_tax_franct", "");
//($change_flg == true) ? $freeze->freeze() : null;

// 設備情報等・その他
$form->addElement("textarea", "form_note", "",' rows="3" cols="75"'." $g_form_option_area");

// 取引履歴
$form->addElement("textarea", "form_record", "",' rows="3" cols="75"'." $g_form_option_area");

// 重要事項
$form->addElement("textarea", "form_important", "",' rows="3" cols="75"'." $g_form_option_area");

// hidden
$form->addElement("hidden", "input_button_flg");
$form->addElement("hidden", "ok_button_flg");
$form->addElement("hidden", "form_act_flg");    // 代行フラグ

//紹介口座先IDを持ちまわる
//$form->addElement("hidden", "hdn_intro_ac_id");     //紹介口座先ID

// セレクトボックス
/*
$select_value = Null;
$select_value[1] = "パターン１";
$select_value[2] = "パターン２";
$select_value[3] = "パターン３";
$select_value[4] = "パターン４";
$select_value[5] = "パターン５";
$select_value[6] = "パターン６";
$select_value[7] = "パターン７";
$select_value[8] = "パターン８";
$select_value[9] = "パターン９";
$select_value[10] = "パターン１０";
*/

//売上伝票発行パターン
$select_value = null;
$select_value = Select_Get($conn,"pattern");
$form->addElement("select", "form_s_pattern_select", "",$select_value,$g_form_option_select);

//請求書発行パターン
$select_value = null;
$select_value = Select_Get($conn,"claim_pattern");
$form->addElement("select", "form_c_pattern_select", "",$select_value,$g_form_option_select);


//グループ
$select_value = null;
$select_value = Select_Get($conn, "client_gr");
$form->addElement("select", "form_client_gr", "",$select_value,$g_form_option_select);

$form_parents_div[] =& $form->createElement("radio", null, null, "親", "true");
$form_parents_div[] =& $form->createElement("radio", null, null, "子", "false");
$form_parents_div[] =& $form->createElement("radio", null, null, "独立", "null");
$freeze = $form->addGroup($form_parents_div, "form_parents_div", "");


//請求作成月（請求先１）
for($i = 0; $i < 12; $i++){
    $form->addElement("checkbox", "claim1_monthly_check[$i]","", ($i+1)."月");
}

/****************************/
// ルール作成
/****************************/
//telfaxチェックのルール追加
$form->registerRule("telfax","function","Chk_Telfax");

// ■地区
// ●必須チェック
$form->addRule("form_area_id", "地区を選択して下さい。", "required");

// ■業種
// ●必須チェック
$form->addRule("form_btype", "業種を選択して下さい。", "required");

$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
/*
// ■FCグループ
// ●必須チェック
$form->addRule("form_shop_gr_1", "FCグループを選択してください。", "required");
*/

// ■得意先コード
// ●必須チェック
$form->addGroupRule('form_client', array(
        'cd1' => array(array('得意先コードは半角数字のみです。', 'required')),      
        'cd2' => array(array('得意先コードは半角数字のみです。', 'required')),      
));

// ●半角数字チェック
$form->addGroupRule('form_client', array(
        'cd1' => array(array('得意先コードは半角数字のみです。', "regex", "/^[0-9]+$/")),      
        'cd2' => array(array('得意先コードは半角数字のみです。', "regex", "/^[0-9]+$/")),
));

// ■得意先名
// ●必須チェック
$form->addRule("form_client_name", "得意先名は1文字以上25文字以下です。", "required");
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_client_name", "得意先名 にスペースのみの登録はできません。", "no_sp_name");

// ■略称
// ●必須チェック
$form->addRule("form_client_cname", "略称は1文字以上20文字以下です。", "required");
$form->addRule("form_client_cname", "略称 にスペースのみの登録はできません。", "no_sp_name");

// ■郵便番号
// ●必須チェック
// ●半角数字チェック
// ●文字数チェック
$form->addGroupRule('form_post', array(
        'no1' => array(
                array('郵便番号は半角数字のみ7桁です。', 'required'),
                array('郵便番号は半角数字のみ7桁です。', "regex", "/^[0-9]+$/"),
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(3,3))
        ),
        'no2' => array(
                array('郵便番号は半角数字のみ7桁です。', 'required'),
                array('郵便番号は半角数字のみ7桁です。', "regex", "/^[0-9]+$/"),
                array('郵便番号は半角数字のみ7桁です。', "rangelength", array(4,4))
        ),
));

// ■住所１
// ●必須チェック
$form->addRule("form_address1", "住所１は1文字以上25文字以下です。", "required");

// ■TEL
// ●必須チェック
// ●半角数字チェック
$form->addRule(form_tel, "TELは半角数字と｢-｣のみ30桁以内です。", "required");
$form->addRule("form_tel","TELは半角数字と｢-｣のみ30桁以内です。", "telfax");

// ■代表者氏名
// ●必須チェック
// $form->addRule("form_rep_name", "代表者氏名は1文字以上15文字以下です。", "required");

// ■親会社創業日
// ●半角数字チェック
$form->addGroupRule('form_parent_establish_day', array(
        'y' => array(array('親会社の創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'm' => array(array('親会社の創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'd' => array(array('親会社の創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
));

// ■営業時間
// ■午前開始時間
// ●半角数字チェック
$form->addGroupRule('form_trade_stime1', array(
        'h' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
        'm' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
));

// ■午前終了時間
// ●半角数字チェック
$form->addGroupRule('form_trade_etime1', array(
        'h' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
        'm' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
));

// ■午後開始時間
// ●半角数字チェック
$form->addGroupRule('form_trade_stime2', array(
        'h' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
        'm' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
));

// ■午後終了時間
// ●半角数字チェック
$form->addGroupRule('form_trade_etime2', array(
        'h' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
        'm' => array(array('営業時間は半角数字のみです。', "regex", "/^[0-9]+$/")),
));
/*
// ■口座料
// ●半角数字チェック
$form->addGroupRule('form_account', array(
        'price' => array(array('口座料は半角数字のみです。', "regex", "/^[0-9]+$/")),
        'rate' => array(array('口座料は半角数字のみです。', "regex", "/^[0-9]+$/")),
));
*/

// ■担当支店
// ●入力チェック
//$form->addRule("form_cshop", "担当支店を選択して下さい。", "required");

// ■担当支店
// ●入力チェック
$form->addRule("form_charge_branch_id", "担当支店を選択して下さい。", "required");


// ■与信限度
// ●半角数字チェック
$form->addRule("form_cledit_limit", "与信限度は半角数字のみです。", "regex", "/^[0-9]+$/");

// ■資本金
// ●半角数字チェック
$form->addRule("form_capital", "資本金は半角数字のみです。", "regex", "/^[0-9]+$/");

// ■集金日（月）
// ●半角数字チェック
$form->addRule("form_pay_m", "集金日（月）を選択して下さい。", "required");

// ■集金日（日）
// ●半角数字チェック
$form->addRule("form_pay_d", "集金日（日）を選択して下さい。", "required");

// ■契約年月日
// ●半角数字チェック
$form->addGroupRule('form_cont_s_day', array(
        'y' => array(array('契約年月日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'm' => array(array('契約年月日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'd' => array(array('契約年月日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
));
// ■契約終了日
// ●半角数字チェック
$form->addGroupRule('form_cont_e_day', array(
        'y' => array(array('契約終了日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'm' => array(array('契約終了日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'd' => array(array('契約年月日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
));
// ■契約更新日
// ●半角数字チェック
$form->addGroupRule('form_cont_r_day', array(
        'y' => array(array('契約更新日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'm' => array(array('契約更新日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'd' => array(array('契約更新日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
));

// ■創業日
// ●半角数字チェック
$form->addGroupRule('form_establish_day', array(
        'y' => array(array('創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'm' => array(array('創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'd' => array(array('創業日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
));

// ■取引区分
// ●必須チェック
$form->addRule("trade_aord_1", "取引区分を選択して下さい。", "required");

// ■納品書コメント
// ●半角数字チェック
$form->addRule("form_deliver_note", "納品書コメントは50文字以内です。", "mb_maxlength",'50');

// ■契約期間
// ●半角数字チェック
$form->addRule("form_cont_peri", "契約期間は半角数字のみです。", "regex", "/^[0-9]+$/");

// ■巡回開始日
// ●半角数字チェック
$form->addGroupRule('form_round_start', array(
        'y' => array(array('巡回開始日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'm' => array(array('巡回開始日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
        'd' => array(array('巡回開始日の日付は妥当ではありません。', "regex", "/^[0-9]+$/")),
));

// 伝票発行パターン
$form->addRule("form_s_pattern_select", "売上伝票発行パターンを選択して下さい。", "required");

// 請求書発行パターン
$form->addRule("form_c_pattern_select", "請求書発行パターンを選択して下さい。", "required");

/***************************/
// ルール作成（PHP）
// ***************************/
if($_POST["button"]["entry_button"] == "登　録"){
    /****************************/
    // POST取得
    /****************************/
//     $shop_gr        = $_POST["form_shop_gr_1"];                 // FCグループ
    $client_cd1             = $_POST["form_client"]["cd1"];             // 得意先コード１
    $client_cd2             = $_POST["form_client"]["cd2"];             // 得意先コード２
    $state                  = $_POST["form_state"];                     // 状態
    $client_name            = $_POST["form_client_name"];               // 得意先名
    $client_read            = $_POST["form_client_read"];               // 得意先名（フリガナ）
    $client_name2           = $_POST["form_client_name2"];              // 得意先名2
    $client_read2           = $_POST["form_client_read2"];              // 得意先名（フリガナ）2
    $client_cname           = $_POST["form_client_cname"];              // 略称
    $cname_read             = $_POST["form_cname_read"];                // 略称（フリガナ）
    $post_no1               = $_POST["form_post"]["no1"];               // 郵便番号１
    $post_no2               = $_POST["form_post"]["no2"];               // 郵便番号２
    $address1               = $_POST["form_address1"];                  // 住所１
    $address2               = $_POST["form_address2"];                  // 住所２
    $address3               = $_POST["form_address3"];                  // 住所３
    $address_read           = $_POST["form_address_read"];              // 住所１（フリガナ）
    $area_id                = $_POST["form_area_id"];                   // 地区コード
    $tel                    = $_POST["form_tel"];                       // TEL
    $fax                    = $_POST["form_fax"];                       // FAX
    $rep_name               = $_POST["form_rep_name"];                  // 代表者氏名

/*20060420追加*/
    $charger1               = $_POST["form_charger1"];                  // ご担当者１
    $charger2               = $_POST["form_charger2"];                  // ご担当者２
    $charger3               = $_POST["form_charger3"];                  // ご担当者３
    $charger_represe1       = $_POST["form_charger_represe1"];          // ご担当者役職１
    $charger_represe2       = $_POST["form_charger_represe2"];          // ご担当者役職２
    $charger_represe3       = $_POST["form_charger_represe3"];          // ご担当者役職３
    $charger_part1          = $_POST["form_charger_part1"];             // ご担当者部署１
    $charger_part2          = $_POST["form_charger_part2"];             // ご担当者部署２
    $charger_part3          = $_POST["form_charger_part3"];             // ご担当者部署３
    $charger_note           = $_POST["form_charger_note"];              // ご担当者備考
/**************/

    $trade_stime1           = str_pad($_POST["form_trade_stime1"]["h"],2,0,STR_PAD_LEFT);         // 営業時間（午前開始）
    $trade_stime1          .= ":"; 
    $trade_stime1          .= str_pad($_POST["form_trade_stime1"]["m"],2,0,STR_PAD_LEFT);
    $trade_etime1           = str_pad($_POST["form_trade_etime1"]["h"],2,0,STR_PAD_LEFT);         // 営業時間（午前終了）
    $trade_etime1          .= ":"; 
    $trade_etime1          .= str_pad($_POST["form_trade_etime1"]["m"],2,0,STR_PAD_LEFT);
    $trade_stime2           = str_pad($_POST["form_trade_stime2"]["h"],2,0,STR_PAD_LEFT);         // 営業時間（午後開始）
    $trade_stime2          .= ":"; 
    $trade_stime2          .= str_pad($_POST["form_trade_stime2"]["m"],2,0,STR_PAD_LEFT);
    $trade_etime2           = str_pad($_POST["form_trade_etime2"]["h"],2,0,STR_PAD_LEFT);         // 営業時間（午後終了）
    $trade_etime2          .= ":"; 
    $trade_etime2          .= str_pad($_POST["form_trade_etime2"]["m"],2,0,STR_PAD_LEFT);
    $holiday                = $_POST["form_holiday"];                   // 休日
    $btype                  = $_POST["form_btype"];                     // 業種コード
    $b_struct               = $_POST["form_b_struct"];                  // 業態
    $claim_cd1              = $_POST["form_claim"]["cd1"];              // 請求先コード１
    $claim_cd2              = $_POST["form_claim"]["cd2"];              // 請求先コード２
    $claim_name             = $_POST["form_claim"]["name"];             // 請求先名
    $intro_act_cd           = $_POST["form_intro_act"]["cd"];           // 紹介口座先コード
    $intro_act_cd2          = $_POST["form_intro_act"]["cd2"];          // 紹介口座先コード2
    $intro_act_name         = $_POST["form_intro_act"]["name"];         // 紹介口座先名
    $intro_act_div          = $_POST["form_client_div"];         // 紹介口座先名
    //$price_check            = $_POST["form_account"]["1"];
    //$account_price          = $_POST["form_account"]["price"];          // 口座料
    //$rate_check             = $_POST["form_account"]["2"];
    //$account_rate           = $_POST["form_account"]["rate"];           // 口座率
    //$cshop_id               = $_POST["form_cshop"];                     // 担当支店
    $charge_branch_id       = $_POST["form_charge_branch_id"];                     // 担当支店
    $c_staff_id1            = $_POST["form_c_staff_id1"];               // 契約担当１
    $c_staff_id2            = $_POST["form_c_staff_id2"];               // 契約担当２
//     $d_staff_id1    = $_POST["form_d_staff_id1"];               // 巡回担当１
//     $d_staff_id2    = $_POST["form_d_staff_id2"];               // 巡回担当２
//     $d_staff_id3    = $_POST["form_d_staff_id3"];               // 巡回担当３
    $col_terms              = $_POST["form_col_terms"];                 // 回収条件
    $cledit_limit           = $_POST["form_cledit_limit"];              // 与信限度
    $capital                = $_POST["form_capital"];                   // 資本金
    $trade_id               = $_POST["trade_aord_1"];                  // 取引区分
    $close_day_cd           = $_POST["form_close"];                     // 締日
    $pay_m                  = $_POST["form_pay_m"];                     // 集金日（月）
    $pay_d                  = $_POST["form_pay_d"];                     // 集金日（日）
    $pay_way                = $_POST["form_pay_way"];                   // 集金方法
//    $bank_enter_cd          = $_POST["form_bank"][1];                      // 銀行呼出コード
    $bank_enter_cd          = $_POST["form_bank"][2];
    $pay_name               = $_POST["form_pay_name"];                  // 振込名義
    $account_name           = $_POST["form_account_name"];              // 口座名義
    $cont_s_day             = $_POST["form_cont_s_day"]["y"];           // 契約開始日
    $cont_s_day            .= "-"; 
    $cont_s_day            .= $_POST["form_cont_s_day"]["m"];
    $cont_s_day            .= "-"; 
    $cont_s_day            .= $_POST["form_cont_s_day"]["d"];
    $cont_e_day             = $_POST["form_cont_e_day"]["y"];            // 契約終了日
    $cont_e_day            .= "-"; 
    $cont_e_day            .= $_POST["form_cont_e_day"]["m"];
    $cont_e_day            .= "-"; 
    $cont_e_day            .= $_POST["form_cont_e_day"]["d"];
    $cont_peri              = $_POST["form_cont_peri"];                 // 契約期間
    $cont_r_day             = $_POST["form_cont_r_day"]["y"];            // 契約更新日
    $cont_r_day            .= "-"; 
    $cont_r_day            .= $_POST["form_cont_r_day"]["m"];
    $cont_r_day            .= "-"; 
    $cont_r_day            .= $_POST["form_cont_r_day"]["d"];
    $slip_out               = $_POST["form_slip_out"];                  // 伝票発行
    $deliver_note           = $_POST["form_deliver_note"];              // 納品書コメント
    $claim_out              = $_POST["form_claim_out"];                 // 請求書発行
    $coax                   = $_POST["form_coax"];                      // 金額：丸め区分
    $tax_div                = $_POST["form_tax_div"];                   // 消費税：課税単位
    $tax_franct             = $_POST["form_tax_franct"];                // 消費税：端数区分
    $note                   = $_POST["form_note"];                      // 設備情報等・その他
    $email                  = $_POST["form_email"];                     // Email
    $url                    = $_POST["form_url"];                       // URL
    $represent_cell         = $_POST["form_represent_cell"];            // 代表者携帯
    $represe                = $_POST["form_rep_position"];              // 代表者役職
    $direct_tel             = $_POST["form_direct_tel"];                // 直通TEL
    $bstruct                = $_POST["form_bstruct"];                   // 業態
    $inst                   = $_POST["form_inst"];                      // 施設
    $establish_day          = $_POST["form_establish_day"]["y"];        // 創業日
    $establish_day         .= "-"; 
    $establish_day         .= $_POST["form_establish_day"]["m"];
    $establish_day         .= "-"; 
    $establish_day         .= $_POST["form_establish_day"]["d"];
    $record                 = $_POST["form_record"];                    // 取引履歴
    $important              = $_POST["form_important"];                 // 重要事項
    $trans_account          = $_POST["form_trans_account"];             // お振込先口座名
    $bank_fc                = $_POST["form_bank_fc"];                   // 銀行/支店名
    $account_num            = $_POST["form_account_num"];               // 口座番号
    $round_start            = $_POST["form_round_start"]["y"];          // 巡回開始日
    $round_start           .= "-"; 
    $round_start           .= $_POST["form_round_start"]["m"];
    $round_start           .= "-"; 
    $round_start           .= $_POST["form_round_start"]["d"];
    $deliver_radio          = $_POST["form_deliver_radio"];             // 納品書コメント(効果
    $claim_send             = $_POST["form_claim_send"];                // 請求書送付
    $company_name           = $_POST["form_company_name"];              // 親会社名
    $company_tel            = $_POST["form_company_tel"];               // 親会社TEL
    $company_address        = $_POST["form_company_address"];           // 親会社住所
    $bank_div               = $_POST["form_bank_div"];                  // 銀行手数料負担区分
    $claim_note             = $_POST["form_claim_note"];                // 請求書コメント
    $client_slip1           = $_POST["form_client_slip1"];              // 得意先１伝票印字
    $client_slip2           = $_POST["form_client_slip2"];              // 得意先２伝票印字
    $parent_rep_name        = $_POST["form_parent_rep_name"];           // 親会社代表者名
    $parent_establish_day   = $_POST["form_parent_establish_day"]["y"];
    $parent_establish_day  .= "-";
    $parent_establish_day  .= $_POST["form_parent_establish_day"]["m"];
    $parent_establish_day  .= "-";
    $parent_establish_day  .= $_POST["form_parent_establish_day"]["d"];
//    $type                   = $_POST["form_type"];                      // 種別
    // $claim_scope    = $_POST["form_claim_scope"];                    // 請求範囲
    $compellation           = $_POST["form_prefix"];                    // 敬称

    $s_pattern_id           = $_POST["form_s_pattern_select"];          //売上伝票発行パターン
    $c_pattern_id           = $_POST["form_c_pattern_select"];          //請求書発行パターン
    $c_tax_div              = $_POST["form_c_tax_div"];                 //課税区分
    $claim2_cd1             = $_POST["form_claim2"]["cd1"];             // 請求先2コード１
    $claim2_cd2             = $_POST["form_claim2"]["cd2"];             // 請求先2コード２
    $claim2_name            = $_POST["form_claim2"]["name"];            // 請求先名2

    $client_gr_id           = $_POST["form_client_gr"];                 //グループID
    $parents_flg            = $_POST["form_parents_div"];               //親子フラグ

    $claim1_monthly_check   = $_POST["claim1_monthly_check"];           //請求書作成月
    $claim2_monthly_check   = $_POST["claim2_monthly_check"];           //請求書作成月

    #2010-04-30 hashimoto-y
    $bill_address_font      = ($_POST["form_bill_address_font"] == '1')? 't' : 'f'; //請求先フォント
    

    // エラー判別フラグ
    $err_flg = false;
    /****************************/
    // 口座料チェックボックス判別
    /****************************/
    if($price_check == 1){
        $check_which = 1;
    }else if($rate_check == 1){
        $check_which = 2;
    }else{
        $check_which = 0;
    }
    
    /***************************/
    // ０埋め
    /***************************/
    // 得意先コード１
    $client_cd1 = str_pad($client_cd1, 6, 0, STR_POS_LEFT);

    // 得意先コード２
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
            $client_cd_err = "入力された得意先コードは使用中です。";
            $err_flg = true;
        }
    }

    //グループチェック
    if(($parents_flg == "true" || $parents_flg == "false") && $client_gr_id == null){    
        $form->setElementError("form_client_gr", "親または子を選択した場合はグループは必須項目です。");
        $err_flg = true;
    }


    // ■紹介口座先
    // ●入力チェック
    if($_POST["form_intro_act"]["cd"] != null && $_POST["form_intro_act"]["name"] == null){
        $intro_act_err = "正しい紹介口座先コードを入力して下さい。";
        $err_flg = true;
    }
    
	//紹介口座先
	//必須判定(口座料が選択されているときは必須)
	if(($price_check != NULL || $rate_check != NULL) 
        && 
        (($intro_act_div == '1' && ($intro_act_cd == NULL || $intro_act_cd2 == NULL)) 
        ||
        ($intro_act_div == '2' && $intro_act_cd == NULL) 
        ||
        $intro_act_name == NULL)){
		$form->setElementError("form_intro_act","ご紹介口座 を選択して下さい。");
	}


    // ■FAX
    // ●半角数字と「-」以外はエラー
    $form->addRule("form_fax","FAXは半角数字と｢-｣のみ30桁以内です。","telfax");

    // ■Email
    if (!(ereg("^[^@]+@[^.]+\..+", $email)) && $email != "") {
        $email_err = "Emailが妥当ではありません。";
        $err_flg = true;
    }

    // ■URL
    // ●入力チェック
    if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url) && $url != null) {
        $url_err = "正しいURLを入力して下さい。";
        $err_flg = true;
    }

    // ■代表者携帯     実際にこの項目は存在しない
    // ●半角数字と「-」以外はエラー
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$represent_cell) && $represent_cell != ""){
        $rep_cell_err = "代表者携帯は半角数字と｢-｣のみ30桁以内です。";
        $err_flg = true;
    }

    // ■直通TEL         実際にこの項目は存在しない
    // ●半角数字と「-」以外はエラー
    if(!ereg("^[0-9]+-?[0-9]+-?[0-9]+$",$direct_tel) && $direct_tel != ""){
        $d_tel_err = "直通TELは半角数字と｢-｣のみ30桁以内です。";
        $err_flg = true;
    }

    // ■親会社TEL
    // ●半角数字と「-」以外はエラー
    $form->addRule("form_company_tel","親会社TELは半角数字と｢-｣のみ30桁以内です。","telfax");

    // ■締日
    // ●必須チェック
    if($_POST["form_close"] == 0){
        $close_err = "締日を選択して下さい。";
        $err_flg = true;
    //取引区分が現金で締め日と支払日が同じでない場合
    }elseif($trade_id == '61' && ($close_day_cd != $pay_d || $pay_m != '0')){
        $close_err = "取引区分に現金を指定した場合の集金日は当月の締日にして下さい。";
        $err_flg = true;
    //支払日が当月で日付が締日より小さい場合
    }elseif($trade_id == '11' && $_POST["form_pay_m"] == "0" && ($_POST["form_close"] >= $_POST["form_pay_d"])){
//        $close_err = "集金日（月）で当月を選択した場合は締日より小さい集金日（日）を選択して下さい。";
        $close_err = "集金日に締日以前の日付は選択できません。";
        $err_flg = true;
    }

    //請求書作成月
    //請求先1
    if(!is_array($claim1_monthly_check)){
        $claim1_check_flg = false;
        $form->setElementError("claim1_monthly_check[0]", "請求先1の請求月を選択して下さい。");
    }else{
        $claim1_check_flg = true;
    }

    // ■請求先
    // ●入力チェック
    if($client_cd1 == $claim_cd1 && $client_cd2 == $claim_cd2){
        $claim_flg = true;
    }elseif(
        ($_POST["form_claim"]["cd1"] != null || $_POST["form_claim"]["cd2"] != null || $_POST["form_claim"]["name"] != null)
        &&
        ($_POST["form_claim"]["cd1"] == null || $_POST["form_claim"]["cd2"] == null || $_POST["form_claim"]["name"] == null)
    ){
        $claim_err = "正しい請求先コードを入力して下さい。";
        $err_flg = true;
    // 正しい請求先が入力された場合
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
        $claim_close_day  = $claim_data["close_day"];    //締め日
        $claim_coax       = $claim_data["coax"];         //丸め区分
        $claim_tax_div    = $claim_data["tax_div"];      //課税単位
        $claim_tax_franct = $claim_data["tax_franct"];   //端数区分 
        $claim_c_tax_div  = $claim_data["c_tax_div"];    //課税区分
        //請求書作成月
        for($i = 1; $i < 13; $i++){
            if($claim_data["month".$i."_flg"] == 't'){
                $claim_month_data[$i-1] = '1';

                //エラーメッセージ
                if($claim_month_msg == null){
                    $claim_month_msg .= $i."月";
                }else{
                    $claim_month_msg .= ",".$i."月";
                }
            }
        }


        //請求先の締め日と同じではない場合処理開始
        if($close_day_cd != $claim_close_day){
            // 月末判定
            if($claim_close_day == "29"){
                $claim_err = "締日は請求先1と同じ 月末 を選択して下さい。";
            }else{
                $claim_err = "締日は請求先1と同じ ".$claim_close_day."日 を選択して下さい。";
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

            $claim_coax_err = "まるめ区分は請求先1と同じ ".$claim_coax." を選択して下さい。";
            $err_flg = true;
        }     

        //請求先の課税単位と同じではない場合処理開始
        if($tax_div != $claim_tax_div){

            //エラーメッセージに表示するため課税単位を置換
            if($claim_tax_div == '2'){
                $claim_tax_div = "伝票単位";
            }elseif($claim_tax_div == '1'){
                $claim_tax_div = "締日単位";
            }

            $claim_tax_div_err = "課税単位は請求先1と同じ ".$claim_tax_div." を選択して下さい。";

            $err_flg = true;
        }

        //請求先の端数区分と同じではない場合処理開始
        if($tax_franct != $claim_tax_franct){

            //エラーメッセージに表示するため端数区分を置換
            if($claim_tax_franct == '1'){
                $claim_tax_franct = "切捨";
            }elseif($claim_tax_franct == '2'){
                $claim_tax_franct = "四捨五入";
            }elseif($claim_tax_franct == '3'){
                $claim_tax_franct = "切上";
            }

            $claim_tax_franct_err = "端数は請求先1と同じ ".$claim_tax_franct." を選択して下さい。";
            $err_flg = true;
        }

        //請求先の課税区分と同じではない場合処理開始
        if($c_tax_div != $claim_c_tax_div){

            //エラーメッセージに表示するため課税区分を置換
            if($claim_c_tax_div == '1'){
                $claim_c_tax_div = "外税";
            }elseif($claim_c_tax_div == '2'){
                $claim_c_tax_div = "内税";
            }

            $claim_c_tax_div_err = "課税区分は請求先1と同じ ".$claim_c_tax_div." を選択して下さい。";
            $err_flg = true;
        }

        //請求書作成月
        foreach($claim_month_data AS $key => $val){
            if($val != $claim1_monthly_check[$key]){
                $claim_month_err_flg = true;
                break;
            }
        }

        if($claim_month_err_flg === true && $claim1_check_flg === true){
            $claim_month_err = "請求月は請求先1と同じ ".$claim_month_msg." を選択して下さい。";
        }
    }

    // ■請求先2
    // ●入力チェック
    if(($claim2_cd1 != null || $claim2_cd2 != null || $claim2_name != null)
        &&
        ($claim2_cd1 == null || $claim2_cd2 == null || $claim2_name == null)
    ){
        $claim2_err = "正しい請求先コードを入力して下さい。";
        $err_flg = true;
    //請求先１と同じ場合
    }elseif(($claim_cd1 == $claim2_cd1 && $claim_cd2 == $claim2_cd2 && $claim_name == $claim2_name)
            &&
        ($claim_cd1 != null && $claim_cd2 != null && $claim_name != null)){
            $claim2_err = "請求先1と同じ請求先が請求先2に指定されています。";
            $err_flg = true;
    // 正しい請求先が入力された場合
    }elseif($claim2_cd1 != null && $claim2_cd2 != null && $claim2_name != null){
        $claim2_flg = true;
    //空白の場合
    }elseif($claim2_cd1 == null && $claim2_cd2 == null && $claim2_name == null && $new_flg == false){
        //空白の場合でもともと空白で無い場合は削除できるかチェック
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

        //登録されていた場合
        if($add_num > 0){
            //請求先２を指定している契約の行番号を抽出
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

            //契約マスタで使用している場合
            if($add_count > 0){
                for($i = 0; $i < $add_count; $i++){
                    $line = pg_fetch_result($result, $i, 0);

                    $mess .= ($i == 0)? " ".$line : " ,".$line;
                }

                $err_mess = "契約マスタの".$mess."行目で請求先2を指定しているため、削除できません。";
                $err_flg = true;
            }
        }
    }

    // ■契約年月日・契約更新日
    // ●日付の妥当性チェック
    // ■契約年月日・契約更新日
    // ●日付の妥当性チェック
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
        $csday_err = "契約年月日の日付は妥当ではありません。";
        $err_flg = true;
    }
    if($crday_m != null || $crday_d != null || $crday_y != null){
        $crday_flg = true;
    }
    $check_r_day = checkdate($crday_m,$crday_d,$crday_y);
    if($check_r_day == false && $crday_flg == true){
        $crday_err = "契約更新日の日付は妥当ではありません。";
        $err_flg = true;
    }
    if($rsday_m != null || $rsday_d != null || $rsday_y != null){
        $rsday_flg = true;
    }
    $check_r_day = checkdate($rsday_m,$rsday_d,$rsday_y);
    if($check_r_day == false && $rsday_flg == true){
        $rsday_err = "巡回開始日の日付は妥当ではありません。";
        $err_flg = true;
    }
    if($esday_m != null || $esday_d != null || $esday_y != null){
        $esday_flg = true;
    }
    $check_r_day = checkdate($esday_m,$esday_d,$esday_y);
    if($check_r_day == false && $esday_flg == true){
        $esday_err = "創業日の日付は妥当ではありません。";
        $err_flg = true;
    }

    // 親会社創業日日付妥当性チェック
    if($parent_esday_m != null || $parent_esday_d != null || $parent_esday_y != null){
        $parent_esday_flg = true;
    }

    $check_r_day = checkdate($esday_m,$esday_d,$esday_y);
    if($check_r_day == false && $esday_flg == true){
        $parent_esday_err = "創業日の日付は妥当ではありません。";
        $err_flg = true;
    }

    // ●契約更新日が契約年月日よりも前でないかチェック
    if($cont_s_day >= $cont_r_day && $cont_s_day != '--' && $cont_r_day != '--'){
        $sday_rday_err = "契約更新日の日付は妥当ではありません。";
        $err_flg = true;
    }

    #2010-04-30 hashimoto-y
    //請求先フォントサイズを大にチェックを入れ以下の条件を超えてないかチェック
    //住所１＝18 , 住所２＝18 , 住所３＝18 , 得意先名１＝14 , 得意先名２＝14
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
        //得意先名１を印字しないチェックが付いてなく、且つ、２０文字を超える場合
        if( $client_slip1 != 1 && mb_strlen($client_name) > 14 ){
            $client_name1_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、得意先名１は１４文字以下です。";
            $err_flg = true;
        }
        //得意先名２を印字しないチェックが付いてなく、且つ、２０文字を超える場合
        if( $client_slip2 != 1 && mb_strlen($client_name2) > 14 ){
            $client_name2_err = "請求書の宛先とラベルのフォントサイズを大きくする場合、得意先名２は１４文字以下です。";
            $err_flg = true;
        }
    }

}

    // エラーの際には、登録・変更処理を行わない
if($_POST["button"]["entry_button"] == "登　録" && $form->validate() && $err_flg != true ){
    /******************************/
    // DB登録情報
    /******************************/
    $create_day = date("Y-m-d");
    /******************************/
    // 登録処理
    /******************************/

    // 得意先マスタに登録
    if($new_flg == true){
        Db_Query($conn, "BEGIN;");
        $insert_sql  = " INSERT INTO t_client (";
        $insert_sql .= "    client_id,";                                        // 得意先ID
        $insert_sql .= "    client_cd1,";                                       // 得意先コード
        $insert_sql .= "    client_cd2,";                                       // 支店コード
        // $insert_sql .= "    shop_gid,";                                      // FCグループID
        $insert_sql .= "    shop_id,";                                          // FCID
        $insert_sql .= "    create_day,";                                       // 作成日
        $insert_sql .= "    state,";                                            // 状態
        $insert_sql .= "    client_name,";                                      // 得意先名
        $insert_sql .= "    client_read,";                                      // 得意先名（フリガナ）
        $insert_sql .= "    client_name2,";                                     // 得意先名2
        $insert_sql .= "    client_read2,";                                     // 得意先名2（フリガナ）
        $insert_sql .= "    client_cname,";                                     // 略称
        $insert_sql .= "    post_no1,";                                         // 郵便番号１
        $insert_sql .= "    post_no2,";                                         // 郵便番号２
        $insert_sql .= "    address1,";                                         // 住所１
        $insert_sql .= "    address2,";                                         // 住所２
        $insert_sql .= "    address3,";                                         // 住所３
        $insert_sql .= "    address_read,";                                     // 住所（フリガナ）
        $insert_sql .= "    area_id,";                                          // 地区ID
        $insert_sql .= "    tel,";                                              // tel
        $insert_sql .= "    fax,";                                              // fax
        $insert_sql .= "    rep_name,";                                         // 代表者氏名
        $insert_sql .= "    c_staff_id1,";                                      // 契約担当１
        $insert_sql .= "    c_staff_id2,";                                      // 契約担当２
//         $insert_sql .= "    d_staff_id1,";                                     // 巡回担当１
//         $insert_sql .= "    d_staff_id2,";                                     // 巡回担当２
//         $insert_sql .= "    d_staff_id3,";                                     // 巡回担当３
        $insert_sql .= "    charger1,";                                         // ご担当者１
        $insert_sql .= "    charger2,";                                         // ご担当者２
        $insert_sql .= "    charger3,";                                         // ご担当者３
        $insert_sql .= "    charger_part1,";                                    // ご担当者部署１
        $insert_sql .= "    charger_part2,";                                    // ご担当者部署２
        $insert_sql .= "    charger_part3,";                                    // ご担当者部署３
        $insert_sql .= "    charger_represe1,";                                 // ご担当者部署３
        $insert_sql .= "    charger_represe2,";                                 // ご担当者部署３
        $insert_sql .= "    charger_represe3,";                                 // ご担当者部署３
        $insert_sql .= "    charger_note,";                                     // ご担当者備考

        $insert_sql .= "    trade_stime1,";                                     // 営業時間（午前開始）
        $insert_sql .= "    trade_etime1,";                                     // 営業時間（午前終了）
        $insert_sql .= "    trade_stime2,";                                     // 営業時間（午後開始）
        $insert_sql .= "    trade_etime2,";                                     // 営業時間（午後終了）
        $insert_sql .= "    sbtype_id,";                                        // 業種ID
        $insert_sql .= "    holiday,";                                          // 休日
        $insert_sql .= "    close_day,";                                        // 締日
        $insert_sql .= "    trade_id,";                                          // 取引区分
        $insert_sql .= "    pay_m,";                                            // 集金日（月）
        $insert_sql .= "    pay_d,";                                            // 集金日（日）
        $insert_sql .= "    pay_way,";                                          // 集金方法
        $insert_sql .= "    account_name,";                                     // 口座名義
        $insert_sql .= "    pay_name,";                                         // 振込名義
//        $insert_sql .= "    b_bank_id,";                                        // 銀行ID
        $insert_sql .= "    account_id,";                                       //口座番号ID
        $insert_sql .= "    slip_out,";                                         // 伝票出力
        $insert_sql .= "    deliver_note,";                                     // 納品書コメント
        $insert_sql .= "    claim_out,";                                        // 請求書出力
        $insert_sql .= "    coax,";                                             // 金額：丸め区分
        $insert_sql .= "    tax_div,";                                          // 消費税：課税単位
        $insert_sql .= "    tax_franct,";                                       // 消費税：端数区分
        $insert_sql .= "    cont_sday,";                                        // 契約開始日
        $insert_sql .= "    cont_eday,";                                        // 契約終了日
        $insert_sql .= "    cont_peri,";                                        // 契約期間
        $insert_sql .= "    cont_rday,";                                        // 契約更新日
        $insert_sql .= "    col_terms,";                                        // 回収条件
        $insert_sql .= "    credit_limit,";                                     // 与信限度
        $insert_sql .= "    capital,";                                          // 資本金
        $insert_sql .= "    note,";                                             // 設備情報等/その他
        $insert_sql .= "    client_div,";                                       // 得意先区分
/*
        // 口座料・口座率判別
        if($price_check == 1){
            $insert_sql .= "    intro_ac_price,";                               // 口座料
        }else if($rate_check == 1){
            $insert_sql .= "    intro_ac_rate,";                                // 口座率
        }
*/
        $insert_sql .= "    email,";                                            // Email
        $insert_sql .= "    url,";                                              // URL
        $insert_sql .= "    rep_htel,";                                         // 代表者携帯
        $insert_sql .= "    direct_tel,";                                       // 直通TEL
        $insert_sql .= "    b_struct,";                                         // 業態
        $insert_sql .= "    inst_id,";                                          // 施設
        $insert_sql .= "    establish_day,";                                    // 創業日
        $insert_sql .= "    deal_history,";                                     // 取引履歴
        $insert_sql .= "    importance,";                                       // 重要事項
        $insert_sql .= "    intro_ac_name,";                                    // お振込先口座名
        $insert_sql .= "    intro_bank,";                                       // 銀行/支店名
        $insert_sql .= "    intro_ac_num,";                                     // 口座番号
        $insert_sql .= "    round_day,";                                        // 巡回開始日
        $insert_sql .= "    deliver_effect,";                                   // 納品書コメント(効果)
        $insert_sql .= "    claim_send,";                                       // 請求書送付
        $insert_sql .= "    client_cread,";                                     // 略称(フリガナ)
        $insert_sql .= "    represe,";                                          // 代表者役職
        $insert_sql .= "    shop_name,";
        $insert_sql .= "    shop_div,";
        $insert_sql .= "    royalty_rate,";
        #2009-12-25 aoyama-n
        #$insert_sql .= "    tax_rate_n,";
        $insert_sql .= "    company_name,";                                     // 親会社名
        $insert_sql .= "    company_tel,";                                      // 親会社TEL
        $insert_sql .= "    company_address,";                                  // 親会社住所
        $insert_sql .= "    bank_div,";                                         // 銀行手数料負担区分
        $insert_sql .= "    claim_note,";                                       // 請求書コメント
        $insert_sql .= "    client_slip1,";                                     // 得意先１伝票印字
        $insert_sql .= "    client_slip2,";                                     // 得意先２伝票印字
        $insert_sql .= "    parent_establish_day,";                             // 親会社創業日
        $insert_sql .= "    parent_rep_name,";
//        $insert_sql .= "    type,";                                             // 種別
        $insert_sql .= "    compellation,";                                     // 敬称
        // $insert_sql .= "    claim_scope";                                    // 請求範囲
		//$insert_sql .= "    intro_ac_div, ";                                    // 口座区分
        $insert_sql .= "    s_pattern_id, ";                                    //売上伝票発行パターン
        $insert_sql .= "    c_pattern_id, ";                                    //請求書発行パターン
        $insert_sql .= "    c_tax_div,";                                         //課税区分i
        $insert_sql .= "    charge_branch_id,";                                         //担当支店
        $insert_sql .= ($client_gr_id != null)? " client_gr_id, " : null;                                     //グループID
        $insert_sql .= "    parents_flg, ";                                     //親子フラグ
        #2010-04-30 hashimoto-y
        $insert_sql .= "    bill_address_font ";                                //請求書宛先フォント
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
        $insert_sql .= "    '$client_cd1',";                                    // 得意先コード
        $insert_sql .= "    '$client_cd2',";                                    // 支店コード
        // $insert_sql .= "    $shop_gid,";                                       // FCグループID
        $insert_sql .= "    $shop_id,";                                         // FCID
        $insert_sql .= "    NOW(),";                                            // 作成日
        $insert_sql .= "    '$state',";                                         // 状態
        $insert_sql .= "    '$client_name',";                                   // 得意先名
        $insert_sql .= "    '$client_read',";                                   // 得意先（フリガナ）
        $insert_sql .= "    '$client_name2',";                                  // 得意先名2
        $insert_sql .= "    '$client_read2',";                                  // 得意先2（フリガナ）
        $insert_sql .= "    '$client_cname',";                                  // 略称
        $insert_sql .= "    '$post_no1',";                                      // 郵便番号１
        $insert_sql .= "    '$post_no2',";                                      // 郵便番号２
        $insert_sql .= "    '$address1',";                                      // 住所１
        $insert_sql .= "    '$address2',";                                      // 住所２
        $insert_sql .= "    '$address3',";                                      // 住所３
        $insert_sql .= "    '$address_read',";                                  // 住所（フリガナ）
        $insert_sql .= "    $area_id,";                                         // 地区ID
        $insert_sql .= "    '$tel',";                                           // TEL
        $insert_sql .= "    '$fax',";                                           // FAX
        $insert_sql .= "    '$rep_name',";                                      // 代表者氏名
        $insert_sql .= ($c_staff_id1 == "") ? " null, " : "$c_staff_id1, ";     // 契約担当１
        $insert_sql .= ($c_staff_id2 == "") ? " null, " : "$c_staff_id2, ";     // 契約担当１
        $insert_sql .= "    '$charger1',";                                      // ご担当者１
        $insert_sql .= "    '$charger2',";                                      // ご担当者２
        $insert_sql .= "    '$charger3',";                                      // ご担当者３
        $insert_sql .= "    '$charger_part1',";                                 // ご担当者部署１
        $insert_sql .= "    '$charger_part2',";                                 // ご担当者部署２
        $insert_sql .= "    '$charger_part3',";                                 // ご担当者部署３
        $insert_sql .= "    '$charger_represe1',";                              // ご担当者役職１
        $insert_sql .= "    '$charger_represe2',";                              // ご担当者役職２
        $insert_sql .= "    '$charger_represe3',";                              // ご担当者役職３
        $insert_sql .= "    '$charger_note',";                                  // ご担当者備考
        $insert_sql .= ($trade_stime1 == ":") ? " null, " : " '$trade_stime1', ";   // 営業時間（午前開始）
        $insert_sql .= ($trade_etime1 == ":") ? " null, " : " '$trade_etime1', ";   // 営業時間（午前終了）
        $insert_sql .= ($trade_stime2 == ":") ? " null, " : " '$trade_stime2', ";   // 営業時間（午後開始）
        $insert_sql .= ($trade_etime2 == ":") ? " null, " : " '$trade_etime2', ";   // 営業時間（午後終了）
        $insert_sql .= ($btype == "") ? " null, " : " $btype, ";                // 業種ID
        $insert_sql .= "    '$holiday',";                                       // 休日
        $insert_sql .= "    '$close_day_cd',";                                  // 締日
        $insert_sql .= "    '$trade_id',";                                      // 取引区分
        $insert_sql .= ($pay_m == "") ? " null, " : " $pay_m, ";                // 集金日（月）
        $insert_sql .= ($pay_d == "") ? " null, " : " $pay_d, ";                // 集金日（日）
        $insert_sql .= "    '$pay_way',";                                       // 支払い方法
        $insert_sql .= "    '$account_name',";                                  // 口座名義
        $insert_sql .= "    '$pay_name',";                                      // 振込名義
        $insert_sql .= ($bank_enter_cd == "") ? " null, " : " $bank_enter_cd, ";// 銀行
        $insert_sql .= "    '$slip_out',";                                      // 伝票出力
        $insert_sql .= "    '$deliver_note',";                                  // 納品書コメント
        $insert_sql .= "    '$claim_out',";                                     // 請求書出力
        $insert_sql .= "    '$coax',";                                          // 金額：丸め区分
        $insert_sql .= "    '$tax_div',";                                       // 消費税：課税単位
        $insert_sql .= "    '$tax_franct',";                                    // 消費税：端数単位
        $insert_sql .= ($cont_s_day == "--") ? " null, " : " '$cont_s_day', ";  // 契約開始日
        $insert_sql .= ($cont_e_day == "--") ? " null, " : " '$cont_e_day', ";  // 契約終了日
        $insert_sql .= ($cont_peri == "") ? " null, " : " '$cont_peri', ";      // 契約期間
        $insert_sql .= ($cont_r_day == "--") ? " null, " : " '$cont_r_day', ";  // 契約更新日
        $insert_sql .= "    '$col_terms',";                                     // 回収条件
        $insert_sql .= "    '$cledit_limit',";                                  // 与信限度
        $insert_sql .= "    '$capital',";                                       // 資本金
        $insert_sql .= "    '$note',";                                          // 設備情報等/その他
        $insert_sql .= "    '1',";                                              // 得意先区分
/*
        // 口座料・口座率判別
        if($price_check == 1 && $account_price != NULL){
            $insert_sql .= "    $account_price,";                               // 口座料
        }else if($rate_check == 1 && $account_rate != NULL){
            $insert_sql .= "    $account_rate,";                                // 口座料(率)
        }
*/
        $insert_sql .= "    '$email',";                                         // Email
        $insert_sql .= "    '$url',";                                           // URL
        $insert_sql .= "    '$represent_cell',";                                // 代表者携帯
        $insert_sql .= "    '$direct_tel',";                                    // 直通TEL
        $insert_sql .= ($bstruct == "") ? " null, " : " '$bstruct', ";          // 業態
        $insert_sql .= ($inst == "") ? " null, " : " $inst, ";                  // 施設
        $insert_sql .= ($establish_day == "--") ? " null, " : " '$establish_day', ";    // 創業日
        $insert_sql .= "    '$record',";                                        // 取引履歴
        $insert_sql .= "    '$important',";                                     // 重要事項
        $insert_sql .= "    '$trans_account',";                                 // お振込先口座名
        $insert_sql .= "    '$bank_fc',";                                       // 銀行/支店名
        $insert_sql .= "    '$account_num',";                                   // 口座番号
        $insert_sql .= ($round_start == "--") ? " null, " : " '$round_start', ";// 巡回開始日
        $insert_sql .= "    '$deliver_radio',";                                 // 納品書コメント(効果
        $insert_sql .= "    '$claim_send',";                                    // 請求書送付
        $insert_sql .= "    '$cname_read',";                                    // 略称(フリガナ)
        $insert_sql .= "    '$represe',";                                       // 代表者役職
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        $insert_sql .= "    '',";
        #2009-12-25 aoyama-n
        #$insert_sql .= "    (SELECT tax_rate_n FROM t_client WHERE client_div = '0'), ";    // 消費税率(現在)
        $insert_sql .= "    '$company_name',";                                  // 親会社名
        $insert_sql .= "    '$company_tel',";                                   // 親会社TEL
        $insert_sql .= "    '$company_address',";                               // 親会社住所
        $insert_sql .= "    '$bank_div',";
        $insert_sql .= "    '$claim_note',";
        $insert_sql .= "    '$client_slip1',";
        $insert_sql .= "    '$client_slip2',";
        $insert_sql .= ($parent_establish_day != '--') ? " '$parent_establish_day', " : " null, ";  // 親会社創業日
        $insert_sql .= "    '$parent_rep_name',";                               // 親会社代表者名
//        $insert_sql .= "    '$type',";
        $insert_sql .= "    '$compellation',";                                   // 親会社代表者名
        // $insert_sql .= "    '$claim_scope'";
/*
		//口座区分判定
		if($price_check == 1 && $account_price != NULL){
			//固定金額
			$insert_sql .= "    '1',";                                   
		}else if($rate_check == 1 && $account_rate != NULL){
			//％指定
			$insert_sql .= "    '2',";                                   
		}else{
			//なし
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

        //登録した得意先の得意先IDを抽出
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

        // ■請求先
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
        // ●請求先１入力時
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
        // ●請求先１未入力時
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

        //請求先２
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
        
        //■得意先情報テーブルに登録
        $insert_sql  = " INSERT INTO t_client_info (";
        $insert_sql .= "    client_id,";
        $insert_sql .= "    intro_account_id,";
        $insert_sql .= "    cclient_shop";
        $insert_sql .= " )VALUES(";
        $insert_sql .= "    $client_id,";

        //紹介口座先（仕入先の場合）
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
        //紹介口座先（FCの場合）
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

        // 登録した情報をログに残す
        $result = Log_Save( $conn, "client", "1", $client_cd1."-".$client_cd2, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

    /******************************/
    // 更新処理
    /******************************/
    }else if($new_flg == false){
        // 得意先登録前に請求先IDを取得
        // 請求先が入力された場合
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

        //請求先名２
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

        // 得意先マスタ
        Db_Query($conn, "BEGIN;");

        //変更前の丸め区分を取得
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
		//口座区分判定
		if($price_check == 1 && $account_price != NULL){
			//固定金額
			$update_sql .= "    intro_ac_div = '1', ";                                   
		}else if($rate_check == 1 && $account_rate != NULL){
			//％指定
			$update_sql .= "    intro_ac_div = '2', ";                                   
		}else{
			//なし
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

        //親の場合は子のデータも全てアップデート
        if($change_flg == true){
            Child_Update($_GET["client_id"], $close_day_cd, $pay_m, $pay_d, $coax, $tax_div, $tax_franct, $c_tax_div, $claim_out, $conn, $claim1_monthly_check);
        }



        //請求先1
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

        // 取引先情報テーブル
        //登録前の照会口座先
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

        //請求先２の契約がある場合
        $check_con_flg = Check_Con_Claim2($conn, $_GET["client_id"]);

        //契約マスタに請求先２に対する契約がある場合
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
            //取引先情報テーブル請求先２
            //請求先２は必須ではないため登録の有無にかかわらず、データを削除
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
            // 更新履歴テーブル
            $update_sql  = " INSERT INTO t_renew (";
            $update_sql .= "    client_id,";                        // 得意先ID
            $update_sql .= "    staff_id,";                         // スタッフID
            $update_sql .= "    renew_time";                        // 現在のtimestamp
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

		//丸め区分の変更をチェックし、契約マスタの金額を再計算する
		$update_con_mesg = Update_Con_Amount($conn, $_GET["client_id"], $coax_before);

        /****************************/
        //付番前の伝票に対し修正内容を反映させる
        /****************************/
        //紹介口座先IDと紹介口座名を抽出
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
        //紹介口座先が選択されていた場合
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
		Update_Aord_Trade($conn, $get_client_id); //前受金の受注伝票を売掛に変更
/*
        //請求先１
        $sql    =  Aord_Update($aord_pram, '1', $intro_array);
        $result =  Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
        //請求先２
        $sql    =  Aord_Update($aord_pram, '2', $intro_array);
        $result =  Db_Query($conn, $sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK;");
            exit;
        }
*/
        // 変更した情報をログに残す
        $result = Log_Save( $conn, "client", "2", $client_cd1."-".$client_cd2, $client_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
    }

    Db_Query($conn, "COMMIT;");
    $complete_flg = true;

    // 契約に遷移する場合に登録した取引先IDを渡す為、取得
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

// ボタン
// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "onClick=\"javascript:location='2-1-101.php'\"");

// 登録(ヘッダ)
$form->addElement("button", "new_button", "登録画面", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// DBに登録後のフォームを作成
if($complete_flg == true){

    // 戻るボタンの遷移先ID取得
    // 新規登録時
    if ($get_client_id == null){
        $sql    = "SELECT MAX(client_id) FROM t_client WHERE shop_id = $shop_id AND client_div = '1';\n";
        $res    = Db_Query($conn, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    // 変更時
    }else{
        $get_id = $get_client_id;
    }

    $form->addElement("static", "intro_claim_link", "", "請求先1");
    $form->addElement("static", "intro_claim_link2", "", "請求先2");
    $form->addElement("static", "intro_act_link", "", "ご紹介口座");
    $button[] = $form->createElement("button", "back_button", "戻　る", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."?client_id=$get_id'\"");
    // ＯＫ
    $button[] = $form->addElement("button", "ok_button", "登録完了", "onClick=\"javascript:Button_Submit_1('ok_button_flg', '#', 'true')\"");

    // 契約登録
    $button[] = $form->addElement("button", "contract_button", "契約登録", "onClick=\"location.href='./2-1-115.php?client_id=$con_client_id'\"");

    $form->freeze();
}else{

    // ご照会料のチェックボックスのチェック
    //$onload = "Check_Button2($check_which);";
    // DBに登録前のフォームを作成
    if($change_flg == true){
        $form->addElement("static", "intro_claim_link", "", "請求先1");
        $form->addElement("static", "intro_claim_link2", "", "請求先2");
    }else{
        $form->addElement("link", "intro_claim_link", "", "#", "請求先1", "onClick=\"javascript:return Open_SubWin('../dialog/2-0-250.php',Array('form_claim[cd1]', 'form_claim[cd2]', 'form_claim[name]', 'form_pay_name', 'form_account_name'), 500, 450,4,2)\"");
        $form->addElement("link", "intro_claim_link2", "", "#", "請求先2", "onClick=\"javascript:return Open_SubWin('../dialog/2-0-250.php',Array('form_claim2[cd1]', 'form_claim2[cd2]', 'form_claim2[name]'), 500, 450,4,1)\"");
    }

    //直営の場合
    if($group_kind == '2'){
        $form->addElement("link", "intro_act_link", "", "#", "ご紹介口座", "onClick=\"javascript:return Open_SubWin_client('../dialog/2-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450)\"");
    }else{
        $form->addElement("link", "intro_act_link", "", "#", "ご紹介口座", "onClick=\"javascript:return Open_SubWin('../dialog/2-0-208.php', Array('form_intro_act[cd]', 'form_intro_act[name]'), 500, 450)\"");
    }

    // 登録済一覧確認
    $button[] = $form->createElement("button", "list_confirm_button", "登録済一覧確認", "style=width:110 onClick=\"javascript:return Open_mlessDialog('../dialog/2-0-250-1.php', '470', '500')\"");

    $button[] = $form->createElement("button", "input_button", "自動入力", "onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true')\""); 

    if($change_flg === true){
        //ダイアログに表示するメッセージ
        $message  = "以下の項目は子のデータにも反映されます。\\n";
        $message .= "・締日\\n";
        $message .= "・集金日\\n";
        $message .= "・売上伝票発行\\n";
        $message .= "・請求書発行\\n";
        $message .= "・丸め区分\\n";
        $message .= "・課税単位\\n";
        $message .= "・端数区分\\n";
        $message .= "・課税区分\\n";
        $message .= "・請求月\\n";

        $button[] = $form->createElement("submit", "entry_button", "登　録", "onClick=\"javascript:return Dialogue('$message', '#', this)\" $disabled");
    }else{
        $button[] = $form->createElement("submit", "entry_button", "登　録", "onClick=\"javascript:return Dialogue('登録します。', '#', this)\" $disabled");
    }
//    ($get_client_id != null) ? $button[] = $form->createElement("button", "res_button", "実　績", "onClick=\"javascript:window.open('".FC_DIR."system/2-1-106.php?client_id=$_GET[client_id]', '_blank', 'width=480,height=600')\"") : null;

    // 新規登録時は出力しない
    if ($get_client_id != null){
        //$button[] = $form->createElement("button", "back_button", "戻　る", "onClick='javascript:history.back()'");
        $button[] = $form->createElement("button", "back_button", "戻　る", "onClick=\"location.href='./2-1-101.php'\"");
    }

}
// 次へボタン
if($next_id != null){
    $form->addElement("button", "next_button", "次　へ", "onClick=\"location.href='./2-1-103.php?client_id=$next_id'\"");
}else{
    $form->addElement("button", "next_button", "次　へ", "disabled");
}
// 前へボタン
if($back_id != null){
    $form->addElement("button", "back_button", "前　へ", "onClick=\"location.href='./2-1-103.php?client_id=$back_id'\"");
}else{
    $form->addElement("button", "back_button", "前　へ", "disabled");
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

        //紹介口座先　有　⇒　無
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

//契約マスタで紹介口座料を発生しないようにする
function Intro_Act_Update($intro_act_array, $client_id,  $db_con){

    $aord_update_flg = false;

    //紹介口座先　有　⇒　無
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

        //口座率、口座単価にnullをセット
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

        //受注ヘッダアップデート時に使用
        $aord_update_flg = true;
    }

    return $aord_update_flg;
}

//子の課税区分を親と合わせる
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

    //請求書作成月を合わせる
    Child_bill_Make_Month ($claim1_monthly_check, $client_id, $db_con);

}


//子の請求月を親と合わせる
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
 * 概要　親と子の得意先IDを取得します。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $client_id   請求先ID
 *
 * @return array  得意先ID
 *
 */

//■親と子の得意先IDを取得
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
	//親と子の得意先IDを返す
	return $data;
}


/**
 * 概要　金額を再計算すべき契約の情報を取得します
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $client_id   得意先ID
 *
 * @return array    契約情報
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
			--　一式で単価に端数がある場合
			WHEN set_flg = 't' AND num IS NULL AND sale_price NOT LIKE '%.00' THEN '1'
		
			--　単価×数量に端数がある場合
			WHEN set_flg = 'f' AND (sale_price * num) NOT LIKE '%.00' THEN '1'
		
			--　サービスのみで端数がある場合
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
		//端数のある契約IDの場合
		if($data[coax_flg] == "1"){
			$contract_data[] = $data; //契約情報を配列に登録
		}
	}

	//契約情報を返す
	//print_array($contract_data);
	return $contract_data;

}

/**
 * 概要　契約の金額を再計算します。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $client_id   得意先ID
 * @param integer   $coax        変更前の丸め区分
 *
 * @return string    変更メッセージ
 *
 */
//丸めの変更により契約金額が変更されるかチェックする
function Update_Con_Amount($db_con, $client_id,$coax){

	//変更後の丸め区分を取得
	$tax_div     = Get_Tax_div($db_con,$client_id);
	//echo $coax."<br>";
	//echo $tax_div[coax]."<br>";
	
	//変更前と変更後の丸め区分が異なる場合
	if($coax != $tax_div[coax]){
	
		//親子の得意先IDを取得
		$client_id_ary = Get_Claim_Family($db_con, $client_id);
		foreach($client_id_ary AS $key => $client_id ){
		
			//金額を再計算すべき契約の情報を取得
			$contract_ary = Get_Contract_Coax($db_con, $client_id);

			//再計算すべき契約がある場合
			if(count($contract_ary) > 0){
				foreach($contract_ary AS $key => $con_data ){

					$contract_id  = $con_data[contract_id];
					$client_cname = htmlspecialchars($con_data[client_cname]);
					
					//契約の金額を再計算
					Update_Act_Amount($db_con, $contract_id, "contract");
		
					//再計算した得意先コードと契約番号を返す
					//$mesg .= "<a href=\"2-1-115.php?client_id=".$client_id."\">";
					$mesg .= $con_data[client_cd]." ".$client_cname." 契約No. ".$con_data[line]."<br>";
					//$mesg .= "</a>";

				}	
			}

		}
	
	//丸め区分が変更されなかった場合
	}else{
		//echo "丸め区分は変更されませんでした";	
	}

	return $mesg;
}


/**
 * 概要　前受金のある受注伝票の取引区分を売掛に変更します。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $client_id   得意先ID
 *
 * @return boolean  実行結果
 *
 */
function Update_Aord_Trade($db_con, $client_id){

	//未処理で前受金の受注
	$sub_sql  = "SELECT aord_id FROM t_aorder_h \n";
	$sub_sql .= " WHERE client_id = $client_id \n";
	$sub_sql .= " AND ps_stat = '1'  \n";
	$sub_sql .= " AND advance_offset_totalamount IS NOT NULL \n";

	//取引区分を売掛に変更
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
 * 概要　請求先2の契約が存在するか確認。
 *
 * 説明
 *
 * @param object    $db_con      DBコネクション
 * @param integer   $client_id   得意先ID
 *
 * @return boolean  実行結果
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
// 請求先
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
// HTMLヘッダ
/****************************/
// 得意先が代行の場合は、得意先名と略称をフリーズ
if($act_flg == "t" || $_POST["form_act_flg"] == "t"){
    $freeze_form = $form->addGroup($freeze_text,"freeze_text", "");
    $freeze_form->freeze();
}

/****************************/
//js
/****************************/
//請求先１で使用する
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
    //code1取得
    $cd1 = pg_fetch_result($result,$i,0);
    //code2取得
    $cd2 = pg_fetch_result($result,$i,1);
    //name取得
    $name = pg_fetch_result($result,$i,2);
    $name = addslashes($name);
    //振込名義１
    $pay_name1 = pg_fetch_result($result, $i,3);
    $pay_name1 = addslashes($pay_name1);    
    //振込名義２
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

//照会口座先で使用する
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

//直営の場合
if($group_kind == '2'){
    $js  .= "function client2(code1,code2,name){\n";
}else{
    $js  .= "function client2(code1,name){\n";
}
$js  .= "  data = new Array($row);\n";

for($i=0;$i<$row;$i++){
    //code1取得
    $cd1 = pg_fetch_result($result,$i,0);
    //code2取得
    $cd2 = pg_fetch_result($result,$i,1);
    //name取得
    $name = pg_fetch_result($result,$i,2);
    $name = addslashes($name);

    //直営の場合
    if($group_kind == '2'){
        $js .= "  data['$cd1-$cd2']=\"$name\";\n";
    }else{
        $js .= "  data['$cd1']=\"$name\";\n";
    }
}

//直営の場合
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

//直営の場合のみ
if($group_kind == '2'){

    //紹介口座先選択ラジオボタン
    $js .= "function client_div(){\n";
    $js .= "    var dis_code = \"form_intro_act[cd]\"\n";
    $js .= "    var dis_code2 = \"form_intro_act[cd2]\"\n";
    $js .= "    var dis_name = \"form_intro_act[name]\"\n";

    $js .= "    document.dateForm.elements[dis_code].value = \"\"\n";
    $js .= "    document.dateForm.elements[dis_code2].value = \"\"\n";
    $js .= "    document.dateForm.elements[dis_name].value = \"\"\n";
    $js .= "}\n";

    //コードdisable
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
        //コードdisable
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

    //選択した紹介口座区分によりダイアログを変更する
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

//取引区分に現金を選択した場合は、締日を支払日にする。
$js .= "function trade_close_day(){\n";
$js .= "  if(document.dateForm.trade_aord_1.value=='61'){\n";
$js .= "      var close_day = document.dateForm.form_close.value\n";
$js .= "      document.dateForm.form_pay_m.value='0';\n";
$js .= "      document.dateForm.form_pay_d.value=close_day;\n";
$js .= "  } \n";
$js .= "}\n";


/****************************/
// HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
// メニュー作成
/****************************/
$page_menu = Create_Menu_f('system', '1');

/****************************/
// 画面ヘッダー作成
/****************************/

/****************************/
// 全件数取得
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

// ヘッダーに表示させる全件数
$total_count_sql = $client_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(全".$total_count."件)";
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign('form',$renderer->toArray());
// その他の変数をassign
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

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
