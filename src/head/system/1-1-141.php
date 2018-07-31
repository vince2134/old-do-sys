<?php
$page_title = "レンタルTOレンタル";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

//  DB接続
$db_con = Db_Connect();

//  権限チェック
$auth       = Auth_Check($db_con);
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
($auth[0] == "r") ? $form->freeze() : null;

/****************************/
// 外部変数
/****************************/
$rental_h_id    = $_GET["rental_h_id"]; // レンタルヘッダID
$state          = $_GET["state"];       // 状況


/****************************/
// 一覧用データ作成
/****************************/
// 新規登録（オフラインショップ用）でない場合
if ($rental_h_id != null){

    // 該当レンタルヘッダIDのショップIDを取得
    // 以下の処理はとりあえず（メディスポ＝オフライン扱い、略称＝オンライン扱い）
    $fshop_id = ($rental_h_id == "5" || $rental_h_id == "6" || $rental_h_id == "7") ? "189" : "113";

    // 該当レンタルヘッダIDのショップがオンラインかオフラインか調べる
    // 以下の処理はとりあえず
    $fshop_network = ($rental_h_id == "5" || $rental_h_id == "6" || $rental_h_id == "7") ? "off" : "on";

    // 該当ショップの請求日を取得
    // 以下の処理はとりあえず
    $seikyu_date = "25日";

    /* ショップデータ */
    $disp_fshop_data = array(
        $fshop_id,                      // ショップID
        $seikyu_date,                   // 請求日（日）
    );

}

/* テーブル１用データ */
if ($state != null){
    $disp_table1_data = array(
        "45",                           // 申請担当者
        "44",                           // 巡回担当者
        "バブ日立ソフト",               // お客様名
        "045-xxx-xxxx",                 // お客様TEL
        array("123", "4567"),           // お客様住所（郵便番号１、郵便番号２）
        array("神奈川県横浜市磯子区磯子", "システムプラザ磯子2号館"),  
                                        // お客様住所（住所１、住所２）
        "2006",                         // レンタル申込日（年）
        "06",                           // レンタル申込日（月）
        "08",                           // レンタル申込日（日）
    );
}

/* テーブル２用データ */
if ($state == null || $state == "new_req"){
    $disp_seikyu_data = date("m");      // 請求日（月）
}else{
    $disp_table2_data = array(
        "2006",                         // レンタル出荷日（年）
        "06",                           // レンタル出荷日（月）
        "09",                           // レンタル出荷日（日）
        "44",                           // 本部担当者
        "備考１",                       // 備考
        "6",                            // 請求日（月）
        "25日",                         // 請求日（日）
    );
}

/* 商品一覧データ */
// 新規登録時（オフライン）
// 以下の配列はとりあえず
if ($state == null){
    $disp_goods_data = array(
        "0" =>  array(
            "Result1",
            "00000001",
            "センサXTOTO",
            "1",
            array("0001"),
            array("1000", "1,000"),
            array("1200", "1,200"),
        ),
        "1" =>  array(
            "Result2",
            "00000002",
            "自動水栓 せせらぎ",
            "3",
            array("1001", "1002", "1003"),
            array("1000", "1,000"),
            array("1200", "1,200"),
        ),
        "2" =>  array(
            "Result1",
            "00000003",
            "シートクリーナー本体",
            "6",
            array(""),
            array("200", "1,200"),
            array("300", "1,800"),
        ),
    );
}

// 契約中時（オフライン）
if ($state == "non_req" && $fshop_network == "off"){
    $disp_goods_data = array(           // 商品毎データ
        "0" =>  array(                      // 商品１データ
            "0" =>  "Result1",                  // 行色css
            "1" =>  "00000001",                 // 商品コード
            "2" =>  "センサXTOTO",              // 商品名
            "3" =>  "1",                        // 契約中のシリアル数
            "4" =>  array(                      // シリアル毎データ
                "0" =>  array(                      // シリアル１データ
                    "契約中",                           // 状況
                    "1",                                // 数量
                    "",                                 // 解約日
                    "A-1",                              // シリアル
                ),
            ),
            "5" =>  array("1000", "1,000"),     // レンタル単価、金額
            "6" =>  array("1200", "1,200"),     // ユーザ提供単価、金額
        ),
        "1" =>  array(                      // 商品２データ
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "自動水栓 せせらぎ",
            "3" =>  "2",
            "4" =>  array(
                "0" =>  array(
                    "契約中",
                    "1",
                    "",
                    "051",
                ),
                "1" =>  array(
                    "契約中",
                    "1",
                    "",
                    "052",
                ),
                "2" =>  array(
                    "解約済",
                    "1",
                    "2006-07-01",
                    "053",
                ),
            ),
            "5" =>  array("900", "1,800"),
            "6" =>  array("1000", "2,000"),
        ),
        "2" =>  array(                      // 商品３データ
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "シートクリーナー本体",
            "3" =>  "1",
            "4" =>  array(
                "0" =>  array(
                    "契約中",
                    "6",
                    "",
                    "-",
                ),
            ),
            "5" =>  array("1000", "1,000"),
            "6" =>  array("1200", "1,200"),
        ),
    );
}

// 新規申請時（オンライン）
if ($state == "new_req"){
    $disp_goods_data = array(           // 商品毎データ
        "0" =>  array(                      // 商品１データ
            "0" =>  "Result1",                  // 行色css
            "1" =>  "00000001",                 // 商品コード
            "2" =>  "センサXTOTO",              // 商品名
            "3" =>  array(                      // シリアル毎データ
                array("1", "0001"),                 // 数量、シリアル
                array("1", "0002"),
                array("1", "0003"),
            ),
            "4" =>  array("1000", "3,000"),     // レンタル単価、金額
            "5" =>  array("1,200", "3,600"),
        ),
        "1" =>  array(                      // 商品２データ
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "自動水栓 せせらぎ",
            "3" =>  array(
                array("1", "1001"),
                array("1", "1002"),
            ),
            "4" =>  array("900", "1,800"),
            "5" =>  array("1,000", "2,000"),
        ),
        "2" =>  array(                      // 商品３データ
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "シートクリーナー本体",
            "3" =>  array(
                array("6", "-"),
            ),
            "4" =>  array("200", "1,200"),
            "5" =>  array("300", "1,800"),
        ),
    );

    // 一覧用データの個数カウント(rowspan属性値算出用)
    // 商品毎ループ
    for ($i = 0; $i < count($disp_goods_data); $i++){
        // シリアル数カウント
        $count = count($disp_goods_data[$i][3]);
        $disp_count[$i] += $count; 
    }

}

// 契約中時（オンライン）
if ($state == "non_req" && $fshop_network == "on"){
    $disp_goods_data = array(           // 商品毎データ
        "0" =>  array(                      // 商品１データ
            "0" =>  "Result1",                  // 行色css
            "1" =>  "00000001",                 // 商品コード
            "2" =>  "センサXTOTO",              // 商品名
            "3" =>  "1",                        // 契約中のシリアル数
            "4" =>  array(                      // シリアル毎データ
                "0" =>  array(                      //  シリアル１データ
                    "契約中",                           // 状況
                    "1",                                // 数量
                    "",                                 // 解約日
                    "A-1",                              // シリアル
                ),
            ),
            "5" =>  array("1000", "1,000"),     // レンタル単価、金額
            "6" =>  array("1,200", "1,200"),    // ユーザ提供単価、金額
        ),
        "1" =>  array(                      // 商品２データ
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "自動水栓 せせらぎ",
            "3" =>  "2",
            "4" =>  array(
                "0" =>  array(
                    "契約中",
                    "1",
                    "",
                    "051",
                ),
                "1" =>  array(
                    "契約中",
                    "1",
                    "",
                    "052",
                ),
                "2" =>  array(
                    "解約済",
                    "1",
                    "2006-07-01",
                    "053",
                ),
            ),
            "5" =>  array("900", "900"),
            "6" =>  array("1,000", "1,000"),
        ),
        "2" =>  array(
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "シートクリーナー本体",
            "3" =>  "1",
            "4" =>  array(
                "0" =>  array(
                    "契約中",
                    "6",
                    "",
                    "-",
                ),
            ),
            "5" =>  array("200", "1,200"),
            "6" =>  array("300", "1,800"),
        ),
    );
}

// 解約申請時（オンライン）
if ($state == "chg_req"){
    $disp_goods_data  = array(                // 商品毎データ
        "0" =>  array(                      // 商品１データ
            "0" =>  "Result1",                  // 行色css
            "1" =>  "00000001",                 // 商品コード
            "2" =>  "センサXTOTO",              // 商品名
            "3" =>  "1",                        // 契約中のシリアル数
            "4" =>  array(                          // シリアル毎データ
                "0" =>  array(                          // シリアル１データ
                    "契約中",                               // 状況
                    "1",                                    // 数量
                    "",                                     // 解約申請数
                    "",                                     // 解約日
                    "A-1",                                  // シリアル
                ),
            ),
            "5" =>  array("1000", "1,000"),     // レンタル単価、金額
            "6" =>  array("1,200", "1,200"),    // ユーザ提供単価、金額
        ),
        "1" =>  array(                      // 商品２データ
            "0" =>  "Result2",
            "1" =>  "00000002",
            "2" =>  "自動水栓 せせらぎ",
            "3" =>  "3",
            "4" =>  array(
                "0" =>  array(
                    "契約中",
                    "1",
                    "",
                    "",
                    "051",
                ),
                "1" =>  array(
                    "契約中",
                    "1",
                    "",
                    "",
                    "052",
                ),
                "2" =>  array(
                    "契約中",
                    "1",
                    "",
                    "",
                    "053",
                ),
                "3" =>  array(
                    "解約済",
                    "1",
                    "",
                    "2006-07-01",
                    "047"
                ),
                "4" =>  array(
                    "解約済",
                    "1",
                    "",
                    "2006-07-01",
                    "048",
                ),
                "5" =>  array(
                    "解約済",
                    "1",
                    "",
                    "2006-07-04",
                    "049",
                ),
                "6" =>  array(
                    "解約申請",
                    "1",
                    "1",
                    "2006-07-20",
                    "050",
                ),
            ),
            "5" =>  array("900", "2,700"),
            "6" =>  array("1,000", "3,000"),
        ),
        "2" =>  array(
            "0" =>  "Result1",
            "1" =>  "00000003",
            "2" =>  "シートクリーナー本体",
            "3" =>  "1",
            "4" =>  array(
                "0" =>  array(
                    "契約中",
                    "4",
                    "",
                    "",
                    "-",
                ),
                "1" =>  array(
                    "解約済",
                    "1",
                    "",
                    "2006-07-01",
                    "-",
                ),
                "2" =>  array(
                    "解約済",
                    "2",
                    "",
                    "2006-07-04",
                    "-",
                ),
            ),
            "5" =>  array("200", "300"),
            "6" =>  array("1,200", "1,800"),
        ),
    );
}
            

/****************************/
// フォームパーツ作成
/****************************/
/*** ヘッダフォーム　***/
// 登録画面
$form->addElement("button", "new_button", "登録画面", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "onClick=\"javascript:location.href='1-1-142.php'\"");

/*** メインフォーム ***/
// ショップ名
$select_value = Select_Get($db_con, "fshop");
$fshop = $form->addElement("select", "form_fshop_select", "", $select_value, $g_form_option_select);


// 申請担当者
$select_value = Select_Get($db_con, "staff");
$table1_1[] = $form->addElement("select", "form_shinsei_tantou_select", "", $select_value, $g_form_option_select);

// 巡回担当者
$select_value = Select_Get($db_con, "staff");
$table1_1[] = $form->addElement("select", "form_junkai_tantou_select", "", $select_value, $g_form_option_select);

// お客様名
$table1_2[] = $form->addElement("text", "form_name", "", "size=\"30\" $g_form_option");

// お客様TEL
$table1_2[] = $form->addElement("text", "form_tel", "", "size=\"30\" style=\"$g_form_style\" $g_form_option");

// お客様住所（郵便番号）
$text = null;
$text[] = $form->createElement("static", "", "", "〒");
$text[] = $form->createElement("text", "no1", "", "size=\"3\" style=\"$g_form_style\" $g_form_option");
$text[] = $form->createElement("static", "", "", "-");
$text[] = $form->createElement("text", "no2", "", "size=\"4\" style=\"$g_form_style\" $g_form_option");
$table1_2[] = $form->addGroup($text, "form_post", "");

// お客様住所（住所１、住所２）
$table1_2[] = $form->addElement("text", "form_address2", "", "size=\"50\" $g_form_option");
$table1_2[] = $form->addElement("text", "form_address1", "", "size=\"50\" $g_form_option");

// レンタル申込日
$text = null;
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_moushikomi_date[y]','form_moushikomi_date[m]',4)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_moushikomi_date[m]','form_moushikomi_date[d]',2)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" $g_form_option");
$table1_2[] = $form->addGroup($text, "form_moushikomi_date", "");


// レンタル出荷日
$text = null;
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_syukka_date[y]','form_syukka_date[m]',4)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_syukka_date[m]','form_syukka_date[d]',2)\" $g_form_option");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" $g_form_option");
$table2[] = $form->addGroup($text, "form_syukka_date", "");

// 本部担当者
$select_value = Select_Get($db_con, "staff");
$table2[] = $form->addElement("select", "form_honbu_tantou_select", "", $select_value, $g_form_option_select);

// 備考
$table2[] = $form->addElement("text", "form_note", "", "size=\"50\" style=\"$g_form_style\" $g_form_option");

// 請求日（月）
$array_month[null] = null;
for ($i=1; $i<=12; $i++){
    $array_month[$i] = $i;
};
$table2[] = $form->addElement("select", "form_seikyu_month_select", "", $array_month, $g_form_option_select);

// 請求日(日)
$table2[] = $form->addElement("static", "form_seikyu_date_static", "", "");


for ($i=0; $i<count($disp_goods_data); $i++){
    // 商品コード
    $form->addElement("text", "form_goods_cd[$i]", "", "size=\"10\" maxlenght=\"8\" style=\"$g_form_style\" $g_form_option");   

    // 商品名
    $form->addElement("text", "form_goods_name[$i]", "", "size=\"40\" maxlength=\"35\" style=\"$g_form_style\" $g_form_option");

    // 数量
    $form->addElement("text", "form_goods_num[$i]", "", "size=\"6\" style=\"text-align: right; $g_form_style\" $g_form_option");   

    // 契約中時（オフライン）のみ
    if ($state == "non_req" && $fshop_network == "off"){
        for ($j=0; $j<count($disp_goods_data[$i][4]); $j++){
            // 状況が"契約中"の場合のみ
            if ($disp_goods_data[$i][4][$j][0] == "契約中"){
                // 解約チェックボックス
                $form->addElement("checkbox", "form_kaiyaku_check[$i][$j]", "", "");
            }
            // シリアルが"-"の場合のみ
            if ($disp_goods_data[$i][4][$j][3] == "-"){
                // 解約数
                $form->addElement("text", "form_kaiyaku_num[$i][$j]", "", "size=\"3\" style=\"$g_form_style\" $g_form_option");
            }
        }
    }

    // 配列データ内のシリアルのKey位置
    $serial = ($state == null) ? 4 : $serial;                                   // 新規登録時（オフライン）
    $serial = ($state == "non_req" && $fshop_network == "off") ? 4 : $serial;   // 契約中時　（オフライン）
    $serial = ($state == "new_req") ? 3 : $serial;                              // 新規申請時（オンライン）
    $serial = ($state == "non_req" && $fshop_network == "on") ? 4 : $serial;    // 契約中時　（オンライン）
    $serial = ($state == "chg_req") ? 4 : $serial;                              // 解約申請時（オンライン）
    for ($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
        // シリアル
        $form->addElement("text", "form_serial[$i][$j]", "", "size=\"10\" style=\"$g_form_style\" $g_form_option");   
    }

    // レンタル単価
    $form->addElement("text", "form_rental_price[$i]", "", "size=\"11\" maxLength=\"9\" class=\"money\" style=\"$g_form_style\" $g_form_option");

    // レンタル金額
    $form->addElement("static", "form_rental_amount[$i]", "", "");   

    // ユーザ提供単価
    $form->addElement("text", "form_user_price[$i]", "", "size=\"11\" maxLength=\"9\" class=\"money\" style=\"$g_form_style\" $g_form_option");

    // ユーザ提供金額
    $form->addElement("static", "form_user_amount[$i]",  "", "");   

}


// 登録ボタン（新規登録時（オフライン））
$form->addElement("button", "form_add_button", "登　録", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=5'\"");

// 変更ボタン（契約中時（オフライン））
$form->addElement("button", "form_chg_off_button", "変　更", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=$rental_h_id&state=chg_req'\"");

// 承認ボタン（新規申請時（オンライン））
$form->addElement("button", "form_new_accept_button", "承　認", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=$rental_h_id&state=new_req'\"");

// 変更ボタン（契約中時（オンライン））
$form->addElement("button", "form_chg_on_button", "変　更", "onClick=\"javascript: location.href='1-1-143.php?rental_h_id=$rental_h_id&state=chg_req'\"");

// 解約承認ボタン（解約申請時（オンライン））
$form->addElement("button", "form_chg_accept_button", "解約承認", "onClick=\"javascript: location.href='1-1-142.php'\"");

// 戻るボタン
$form->addElement("button", "form_back_button", "戻　る", "onClick=\"javascript:history.back()\"");


/****************************/
// freeze
/****************************/
// ショップ名
($state != null) ? $fshop->freeze() : null;

// 新規申請時（オンライン）
if ($state == "new_req"){
    $freeze_table1_2 = $form->addGroup($table1_2, "freeze_table1_2", "");
    $freeze_table1_2->freeze();
}

// 契約中時（オンライン）
if ($state == "non_req" && $fshop_network == "on"){
    $freeze_table1_1 = $form->addGroup($table1_1, "freeze_table1_1", "");
    $freeze_table1_1->freeze();
    $freeze_table1_2 = $form->addGroup($table1_2, "freeze_table1_2", "");
    $freeze_table1_2->freeze();
}

// 解約申請時（オンライン）
if ($state == "chg_req"){
    $freeze_table1_2 = $form->addGroup($table1_2, "freeze_table1_2", "");
    $freeze_table1_2->freeze();
}


/****************************/
// フォームデータSET（ショップ名）
/****************************/
// 新規登録時以外
if ($state != null){
    $fshop_data["form_fshop_select"]        =   $disp_fshop_data[0];
    $fshop_data["form_seikyu_date_static"]  =   $disp_fshop_data[1];
    $form->setDefaults($fshop_data);
}

/****************************/
// フォームデータSET（テーブル１）
/****************************/
// 新規登録時以外
if ($state != null){
    $def_table1_data = array(
        "form_shinsei_tantou_select"    =>  $disp_table1_data[0],
        "form_junkai_tantou_select"     =>  $disp_table1_data[1],
        "form_name"                     =>  $disp_table1_data[2],
        "form_tel"                      =>  $disp_table1_data[3],
        "form_post"                     =>  array(
            "no1"                       =>  $disp_table1_data[4][0],
            "no2"                       =>  $disp_table1_data[4][1],
        ),
        "form_address1"                 =>  $disp_table1_data[5][0],
        "form_address2"                 =>  $disp_table1_data[5][1],
        "form_moushikomi_date[y]"       =>  $disp_table1_data[6], 
        "form_moushikomi_date[m]"       =>  $disp_table1_data[7],
        "form_moushikomi_date[d]"       =>  $disp_table1_data[8],
    );
    $form->setDefaults($def_table1_data);
}

/****************************/
// フォームデータSET（テーブル２）
/****************************/
// 契約中・解約申請時
if ($state == "non_req" || $state == "chg_req"){
    $def_table2_data = array(
        "form_syukka_date[y]"           =>  "$disp_table2_data[0]", 
        "form_syukka_date[m]"           =>  "$disp_table2_data[1]",
        "form_syukka_date[d]"           =>  "$disp_table2_data[2]",
        "form_honbu_tantou_select"      =>  "$disp_table2_data[3]",
        "form_note"                     =>  "$disp_table2_data[4]",
        "form_seikyu_month_select"      =>  "$disp_table2_data[5]",
        "form_seikyu_date_static"       =>  "$disp_table2_data[6]",
    );
    $form->setDefaults($def_table2_data);
}

// 新規登録時（オフライン）
if($state == null || $state == "new_req"){
    $def_table2_data["form_seikyu_month_select"] =  $disp_seikyu_data;
    $form->setDefaults($def_table2_data);
}

/****************************/
// フォームデータSET（一覧table）
/****************************/
// 新規登録時（オフライン）
// 以下の処理はとりあえず
if ($state == null){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_goods_cd[$i]"         =>  $disp_goods_data[$i][1],
            "form_goods_name[$i]"       =>  $disp_goods_data[$i][2],
            "form_goods_num[$i]"        =>  $disp_goods_data[$i][3],
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
            "form_rental_amount[$i]"    =>  $disp_goods_data[$i][5][1],
            "form_user_price[$i]"       =>  $disp_goods_data[$i][6][0],
            "form_user_amount[$i]"      =>  $disp_goods_data[$i][6][1],
        );
        $form->setDefaults($def_goods_data);
    }
}

// 契約中時（オフライン）
if ($state == "non_req" && $fshop_network == "off"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][3],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
            "form_user_price[$i]"       =>  $disp_goods_data[$i][6][0],
        );
        $form->setDefaults($def_goods_data);
    }
}
    

// 新規申請時（オンライン）
if ($state == "new_req"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_goods_num[$i]"    =>  $disp_goods_data[$i][3][$j][0],
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][1],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][4][0],
        );
        $form->setDefaults($def_goods_data);
    }
}

// 契約中時（オンライン）
if ($state == "non_req" && $fshop_network == "on"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][3],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_goods_name[$i]"       =>  $disp_goods_data[$i][2],
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
        );
        $form->setDefaults($def_goods_data);
    }
}

// 解約申請時（オンライン）
if ($state == "chg_req"){
    for ($i=0; $i<count($disp_goods_data); $i++){
        for($j=0; $j<count($disp_goods_data[$i][$serial]); $j++){
            $def_serial_data = array(
                "form_serial[$i][$j]"   =>  $disp_goods_data[$i][$serial][$j][4],
            );
            $form->setDefaults($def_serial_data);
        }
        $def_goods_data = array(
            "form_rental_price[$i]"     =>  $disp_goods_data[$i][5][0],
        );
        $form->setDefaults($def_goods_data);
    }
}

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
$page_menu = Create_Menu_h("system", "1");

/****************************/
// 画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


//  Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

// その他の変数をassign
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "state"         => "$state",  
    "fshop_network" => "$fshop_network",
    "disp_count"    => "$disp_count",
));

// 表示データ
$smarty->assign("disp_table1_data", $disp_table1_data);
$smarty->assign("disp_table2_data", $disp_table2_data);
$smarty->assign("disp_goods_data", $disp_goods_data);

// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
