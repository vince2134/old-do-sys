<?php
/******************************/
// DB登録情報
/******************************/
// 環境設定ファイル
require_once("ENV_local.php");
function replaceText($str){
    $arr = array(
	"\x87\x40" => '(1)',
	"\x87\x41" => '(2)',
	"\x87\x42" => '(3)',
	"\x87\x43" => '(4)',
	"\x87\x44" => '(5)',
	"\x87\x45" => '(6)',
	"\x87\x46" => '(7)',
	"\x87\x47" => '(8)',
	"\x87\x48" => '(9)',
	"\x87\x49" => '(10)',
	"\x87\x4a" => '(11)',
	"\x87\x4b" => '(12)',
	"\x87\x4c" => '(13)',
	"\x87\x4d" => '(14)',
	"\x87\x4e" => '(15)',
	"\x87\x4f" => '(16)',
	"\x87\x50" => '(17)',
	"\x87\x51" => '(18)',
	"\x87\x52" => '(19)',
	"\x87\x53" => '(20)',
	"\x87\x54" => 'I',
	"\x87\x55" => 'II',
	"\x87\x56" => 'III',
	"\x87\x57" => 'IV',
	"\x87\x58" => 'V',
	"\x87\x59" => 'VI',
	"\x87\x5a" => 'VII',
	"\x87\x5b" => 'VIII',
	"\x87\x5c" => 'IX',
	"\x87\x5d" => 'X',
	"\x87\x5f" => 'ﾐﾘ',
	"\x87\x60" => 'ｷﾛ',
	"\x87\x61" => 'ｾﾝﾁ',
	"\x87\x62" => 'ﾒｰﾄﾙ',
	"\x87\x63" => 'ｸﾞﾗﾑ',
	"\x87\x64" => 'ﾄﾝ',
	"\x87\x65" => 'ｱｰﾙ',
	"\x87\x66" => 'ﾍｸﾀｰﾙ',
	"\x87\x67" => 'ﾘｯﾄﾙ',
	"\x87\x68" => 'ﾜｯﾄ',
	"\x87\x69" => 'ｶﾛﾘｰ',
	"\x87\x6a" => 'ﾄﾞﾙ',
	"\x87\x6b" => 'ｾﾝﾁ',
	"\x87\x6c" => 'ﾊﾟｰｾﾝﾄ',
	"\x87\x6d" => 'ﾐﾘﾊﾞｰﾙ',
	"\x87\x6e" => 'ﾍﾟｰｼﾞ',
	"\x87\x6f" => 'mm',
	"\x87\x70" => 'cm',
	"\x87\x71" => 'km',
	"\x87\x72" => 'mg',
	"\x87\x73" => 'kg',
	"\x87\x74" => 'cc',
	"\x87\x75" => 'm2',
	"\x87\x7e" => '平成',
	"\x87\x80" => '“',
	"\x87\x81" => '”',
	"\x87\x82" => 'No.',
	"\x87\x83" => 'K.K.',
	"\x87\x84" => 'TEL',
	"\x87\x85" => '（上）',
	"\x87\x86" => '（中）',
	"\x87\x87" => '（下）',
	"\x87\x88" => '（左）',
	"\x87\x89" => '（右）',
	"\x87\x8a" => '（株）',
	"\x87\x8b" => '（有）',
	"\x87\x8c" => '（代）',
	"\x87\x8d" => '明治',
	"\x87\x8e" => '大正',
	"\x87\x8f" => '昭和',
	"\x87\x90" => '≒',
	"\x87\x91" => '≡',
	"\x87\x92" => '∫',  
	"\x87\x93" => 'c∫',
	"\x87\x94" => 'Σ',
	"\x87\x95" => '√',
	"\x87\x96" => '⊥',
	"\x87\x97" => '∠',
	"\x87\x98" => '└',
	"\x87\x99" => 'Δ',
	"\x87\x9a" => '∵',
	"\x87\x9b" => '∩',
	"\x87\x9c" => '∪',
);
mb_convert_variables("Shift_Jis", "EUC-JP", $arr);
    return str_replace(array_keys($arr), array_values($arr), $str);
}

function removeSpace($str) {
	$arr = array(
		' ' => '',
		'　' => '');
	return str_replace(array_keys($arr), array_values($arr), $str);
}

// DB接続設定
$conn = Db_Connect();
$create_day = date("Y-m-d");
/******************************/
// 登録処理
/******************************/
$filepath =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/client.csv';
$logfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/client.log';
$errfile =  $_SERVER["DOCUMENT_ROOT"] . '/anet-dosys/files/client_err.log';
$buffer = file_get_contents($filepath);
$buffer = mb_convert_encoding(replaceText($buffer), "eucJP-win", "SJIS-win");
//$buffer = mb_convert_encoding(replaceText($buffer), "eucJP", "SJIS");
$fp = tmpfile();
fwrite($fp, $buffer);
rewind($fp);

$i=0;
while (($line = fgetcsv($fp)) !== FALSE) {
    if($i == 0){
        // タイトル行
        $header = $line;
        $i++;
        continue;
    }
    $records[] = $line;

    $i++;
}

fclose($fp);
$arr_state = array(1=>'取引中', 2=>'解約');
$arr_area = array(1173=>'京都市外', 1174=>'京都市内', 1175=>'滋賀県', 1176=>'大阪府');
$arr_btype = array(71=>'その他');
$arr_trade_id = array(11=>'掛売上',21=>'掛仕入',61=>'現金売上');
$arr_pay_m = array(0=>'同月', 1=>'翌月');
$arr_pay_d = array(29=>'末日');
$arr_pay_way = array('1' => '自動引落', '2' => '振込', '3' => '訪問集金', '4' => '手形','5' => 'その他');
$record_count = 0;

for ($i=0; $i<count($records); $i++){
	//if (100 < $i) break;
	$d = $records[$i];
	$client_cd1 = $d[1];    // 得意先コード
	$client_cd2 = $d[2];    // 支店コード
	$shop_id = 173;         // FCID 光様client_id
	$state = array_search($d[3], $arr_state);         // 状態
	$client_name = mb_substr(removeSpace($d[4]), 0, 25, "euc-jp");   // 得意先名
	$client_read = mb_substr(removeSpace($d[6]), 0, 50, "euc-jp");   // 得意先（フリガナ）
	$client_name2 = mb_substr(removeSpace($d[5]), 0, 25, "euc-jp");  // 得意先名2
	$client_read2 = mb_substr(removeSpace($d[7]), 0, 50, "euc-jp");  // 得意先2（フリガナ）
	$client_cname = mb_substr(removeSpace($d[8]), 0, 20, "euc-jp");  // 略称
	$post_no1 = $d[9];      // 郵便番号１
	$post_no2 = $d[10];     // 郵便番号２
	$address1 = mb_substr(removeSpace($d[11]), 0, 25, "euc-jp");     // 住所１
	$address2 = mb_substr(removeSpace($d[12]), 0, 25, "euc-jp");     // 住所２
	$address3 = '';         // 住所３
	$address_read = mb_substr(removeSpace($d[13]), 0, 50, "euc-jp"); // 住所（フリガナ）
	$area_id = intval(array_search($d[14], $arr_area));      // 地区ID
	$tel = $d[15];          // TEL
	$fax = $d[16];          // FAX
	$rep_name = $d[17];     // 代表者氏名
	$c_staff_id1 = '';      // 契約担当１
	$c_staff_id2 = '';      // 契約担当１
	$charger1 = $d[18];     // ご担当者１
	$charger2 = $d[19];     // ご担当者２
	$charger3 = $d[20];     // ご担当者３
	$charger_part1 = '';    // ご担当者部署１
	$charger_part2 = '';    // ご担当者部署２
	$charger_part3 = '';    // ご担当者部署３
	$charger_represe1 = ''; // ご担当者役職１
	$charger_represe2 = ''; // ご担当者役職２
	$charger_represe3 = ''; // ご担当者役職３
	$charger_note = '';     // ご担当者備考
	$trade_stime1 = ":";    // 営業時間（午前開始）
	$trade_etime1 = ":";    // 営業時間（午前終了）
	$trade_stime2 = ":";    // 営業時間（午後開始）
	$trade_etime2 = ":";    // 営業時間（午後終了）
	$btype = array_search($d[32], $arr_btype);       // 業種ID
	$holiday = '';          // 休日
	$close_day_cd = array_search($d[45], $arr_pay_d); // 締日
	if (!$close_day_cd) $close_day_cd = str_replace("日", "", $d[45]);
	$trade_id = array_search($d[44], $arr_trade_id);     // 取引区分
	$pay_m = array_search($d[46], $arr_pay_m);       // 集金日（月）
	$pay_d = array_search($d[47], $arr_pay_d);       // 集金日（日）
	if (!$pay_d) $pay_d = str_replace("日", "", $d[47]);
	$pay_way = array_search($d[48], $arr_pay_way);      // 支払い方法
	$account_name = '';     // 口座名義
	$pay_name = '';         // 振込名義
	$bank_enter_cd = '';    // 銀行
	$slip_out = 2;     // 伝票出力
	$deliver_note = '';     // 納品書コメント
	$claim_out = 1;    // 請求書出力
	$coax = 2;         // 金額：丸め区分
	$tax_div = 2;      // 消費税：課税単位
	$tax_franct = 2;   // 消費税：端数単位
	$cont_s_day = "--";     // 契約開始日
	$cont_e_day = "--";     // 契約終了日
	$cont_peri = "";        // 契約期間
	$cont_r_day = "--";     // 契約更新日
	$col_terms = '';        // 回収条件
	$cledit_limit = '';     // 与信限度
	$capital = '';          // 資本金
	$note = $d[68];         // 設備情報等/その他
	$email = '';            // Email
	$url = '';              // URL
	$represent_cell = '';   // 代表者携帯
	$direct_tel = '';       // 直通TEL
	$bstruct = '';          // 業態
	$inst ==  '';           // 施設
	$establish_day = "--";  // 創業日
	$record = '';           // 取引履歴
	$important = '';        // 重要事項
	$trans_account = '';    // お振込先口座名
	$bank_fc = '';          // 銀行/支店名
	$account_num = '';      // 口座番号
	$round_start = "--";    // 巡回開始日
	$deliver_radio = '';    // 納品書コメント(効果
	$claim_send = 1;   // 請求書送付
	$cname_read = '';       // 略称(フリガナ)
	$represe = '';          // 代表者役職
	$company_name = '';     // 親会社名
	$company_tel = '';      // 親会社TEL
	$company_address = '';  // 親会社住所
	$bank_div = '';
	$claim_note = '';
	$client_slip1 = '';
	$client_slip2 = '';
	$parent_establish_day = '--';  // 親会社創業日
	$parent_rep_name = '';   // 親会社代表者名
	$compellation = '';      // 親会社代表者名
	$s_pattern_id = 'null';
	$c_pattern_id = 'null';
	$c_tax_div = 'null';
	$charge_branch_id = 'null';
	$parents_flg = 'false';
	$bill_address_font = 'false';
	// 得意先マスタに登録
	//Db_Query($conn, "BEGIN;");
	$insert_sql  = " INSERT INTO t_client (";
	$insert_sql .= "    client_id,";                                        // 得意先ID
	$insert_sql .= "    client_cd1,";                                       // 得意先コード
	$insert_sql .= "    client_cd2,";                                       // 支店コード
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
	$insert_sql .= "    company_name,";                                     // 親会社名
	$insert_sql .= "    company_tel,";                                      // 親会社TEL
	$insert_sql .= "    company_address,";                                  // 親会社住所
	$insert_sql .= "    bank_div,";                                         // 銀行手数料負担区分
	$insert_sql .= "    claim_note,";                                       // 請求書コメント
	$insert_sql .= "    client_slip1,";                                     // 得意先１伝票印字
	$insert_sql .= "    client_slip2,";                                     // 得意先２伝票印字
	$insert_sql .= "    parent_establish_day,";                             // 親会社創業日
	$insert_sql .= "    parent_rep_name,";
	$insert_sql .= "    compellation,";                                     // 敬称
	$insert_sql .= "    s_pattern_id, ";                                    //売上伝票発行パターン
	$insert_sql .= "    c_pattern_id, ";                                    //請求書発行パターン
	$insert_sql .= "    c_tax_div,";                                         //課税区分i
	$insert_sql .= "    charge_branch_id,";                                         //担当支店
	$insert_sql .= "    parents_flg, ";                                     //親子フラグ
	$insert_sql .= "    bill_address_font ";                                //請求書宛先フォント
	$insert_sql .= " )VALUES(";
	$insert_sql .= "    (SELECT COALESCE(MAX(client_id), 0)+1 FROM t_client),";
	$insert_sql .= "    '$client_cd1',";                                    // 得意先コード
	$insert_sql .= "    '$client_cd2',";                                    // 支店コード
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
	$insert_sql .= "    '$company_name',";                                  // 親会社名
	$insert_sql .= "    '$company_tel',";                                   // 親会社TEL
	$insert_sql .= "    '$company_address',";                               // 親会社住所
	$insert_sql .= "    '$bank_div',";
	$insert_sql .= "    '$claim_note',";
	$insert_sql .= "    '$client_slip1',";
	$insert_sql .= "    '$client_slip2',";
	$insert_sql .= ($parent_establish_day != '--') ? " '$parent_establish_day', " : " null, ";  // 親会社創業日
	$insert_sql .= "    '$parent_rep_name',";                               // 親会社代表者名
	$insert_sql .= "    '$compellation',";                                   // 親会社代表者名
	$insert_sql .= "    $s_pattern_id,";
	$insert_sql .= "    $c_pattern_id,";
	$insert_sql .= "    $c_tax_div,";
	$insert_sql .= "    $charge_branch_id,";
	$insert_sql .= "    $parents_flg, \n";
	$insert_sql .= "    $bill_address_font \n";
	$insert_sql .= ");";
	$result = Db_Query($conn, $insert_sql);
	if($result === false){
		$err = "$record_count $client_id $client_cd1\n $insert_sql\n";
		file_put_contents($errfile, $err, FILE_APPEND | LOCK_EX);
		continue;
	    //Db_Query($conn, "ROLLBACK;");
	    //exit;
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
		$err = "$record_count $client_id $client_cd1\n $sql\n";
		file_put_contents($errfile, $err, FILE_APPEND | LOCK_EX);
	    //Db_Query($conn, "ROLLBACK;");
	    //exit;
	}
	$record_count++;
	$msg = "$record_count $client_id $client_cd1 inserted OK.\n";
	file_put_contents($logfile, $msg, FILE_APPEND | LOCK_EX);
	print "$msg<br />";

}
	print "$record_count records were inserted.<br />";
?>

