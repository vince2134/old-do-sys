<?php
$page_title = "レンタルTOレンタル";

// 環境設定ファイル
require_once("ENV_local.php");

// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null);

// DB接続
$db_con = Db_Connect();

// 権限チェック
//$auth       = Auth_Check($db_con);
//$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
//($auth[0] == "r") ? $form->freeze() : null;


/****************************/
// デフォルト値設定
/****************************/
$def_fdata = array(
	"form_output_radio" =>  1,
    "form_state_check"  =>  array(
        "keiyakutyu"        => 1,
        "shinkishinsei"     => 1,
        "kaiyakushinsei"    => 1,
        "kaiyakuzumi"       => 0,
    ),
);
$form->setDefaults($def_fdata);


/****************************/
// フォームパーツ作成
/****************************/
/*** ヘッダフォーム　***/
// 登録画面
$form->addElement("button", "new_button", "登録画面", "onClick=\"javascript:location.href='1-1-141.php'\"");

// 変更・一覧
$form->addElement("button", "change_button", "変更・一覧", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

/*** メインフォーム ***/
// 出力形式
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, "画面", "1");
$radio[] =& $form->createElement("radio", null, null, "帳票", "2");
$form->addGroup($radio, "form_output_radio", "");

// 状況
$check[] =& $form->addElement("checkbox", "keiyakutyu", "", "契約中");
$check[] =& $form->addElement("checkbox", "shinkishinsei", "", "新規申請");
$check[] =& $form->addElement("checkbox", "kaiyakushinsei", "", "解約申請");
$check[] =& $form->addElement("checkbox", "kaiyakuzumi", "", "解約済");
$form->addGroup($check, "form_state_check", "");

// レンタル番号
$form->addElement("text", "form_rental_no", "", "size=\"9\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// ショップコード
$form->addElement("text", "form_shop_cd", "", "size=\"14\" maxlength=\"6\" style=\"$g_form_style\" $g_form_option");

// ショップ名
$form->addElement("text", "form_shop_name", "", "size=\"28\" maxlength=\"25\" $g_form_option");

// 商品コード
$form->addElement("text", "form_goods_cd", "", "size=\"14\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// 商品名
$form->addElement("text", "form_goods_name", "", "size=\"28\" maxlength=\"35\" $g_form_option");

// 表示ボタン
$form->addElement("button","form_show_button","表　示"); 

// クリアボタン
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// 戻るボタン
$form->addElement("button", "form_back_button", "戻　る", "onClick=\"javascript:history.back()\"");


/****************************/
// 一覧表示用データ取得
/****************************/
$sql  = "SELECT ";
$sql .= "   t_rental_h.shop_id, ";
$sql .= "   t_rental_h.shop_name, ";
$sql .= "   t_rental_h.rental_amount, ";
$sql .= "   t_rental_h.user_amount, ";
$sql .= "   t_rental_h.client_id, ";
$sql .= "   t_rental_h.client_cd1, ";
$sql .= "   t_rental_h.client_cd2, ";
$sql .= "   t_rental_h.client_name, ";
$sql .= "   t_rental_h.client_name2, ";
$sql .= "   t_rental_h.rental_id, ";
$sql .= "   t_rental_h.rental_no, ";
$sql .= "   t_rental_h.forward_day, ";
$sql .= "   t_rental_h.apply_day, ";
$sql .= "   t_rental_d.rental_stat, ";
$sql .= "   t_rental_d.goods_id, ";
$sql .= "   t_rental_d.goods_cd, ";
$sql .= "   t_rental_d.goods_name, ";
$sql .= "   t_rental_d.num, ";
$sql .= "   t_rental_d.serial_no, ";
$sql .= "   t_rental_d.rental_price, ";
$sql .= "   t_rental_d.rental_amount, ";
$sql .= "   t_rental_d.user_price, ";
$sql .= "   t_rental_d.user_amount ";
//$sql .= "   * ";
$sql .= "FROM ";
$sql .= "   t_rental_h ";
$sql .= "   LEFT JOIN t_rental_d ON t_rental_h.rental_id = t_rental_d.rental_id ";
$sql .= ";";
$res  = Db_Query($db_con, $sql);
$data_list = Get_Data($res, "", "ASSOC");
//print_array($data_list);

// 取得した全レコード数分ループ
foreach ($data_list as $key => $value){
    // 取得結果を連想配列へ代入
    $assoc_ary_data[$value["shop_id"]][$value["client_id"]][$value["rental_id"]][] = $value;
}

// 作成した連想配列から各レコードのrowspanを算出
foreach ($assoc_ary_data as $shop_key => $shop_value){
    foreach ($shop_value as $client_key => $client_value){
        foreach ($client_value as $rental_key => $rental_value){
            // 設置先カラム用rowspan
            $ary_client_rowspan[$shop_key][$client_key] += count($rental_value);
            // レンタル番号カラム用rowspan
            $ary_rental_rowspan[$shop_key][$client_key][$rental_key] = count($rental_value);
        }
    }
}
print_array($ary_client_rowspan, "設置先カラム用rowspan");
print_array($ary_rental_rowspan, "レンタル番号カラム用rowspan");
print_array($assoc_ary_data, "レコードデータ");

// 画面出力用html変数定義
$html = null;

// ショップID単位のループ
foreach ($assoc_ary_data as $shop_key => $shop_value){

    // 得意先毎行番号カウンタ
    $j = 0;

    // 各ショップのヘッダを出力
    $html .= "<table>\n";
    $html .= "  <tr>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "      <td></td>\n";
    $html .= "  </tr>\n";
    $html .= "</table>\n";

    // ショップ単位のレンタルデータ
    $html .= "<table border=\"1\">\n";
    $html .= "  <tr>\n";
    $html .= "      <td>No.</td>\n";
    $html .= "      <td>設置先</td>\n";
    $html .= "      <td>レンタル番号</td>\n";
    $html .= "      <td>出荷日</td>\n";
    $html .= "      <td>変更日・解約日</td>\n";
    $html .= "      <td>状況</td>\n";
    $html .= "      <td>商品コード<br>商品名</td>\n";
    $html .= "      <td>数量</td>\n";
    $html .= "      <td>シリアル</td>\n";
    $html .= "      <td>レンタル単価<br>　　　　金額</td>\n";
    $html .= "      <td>ユーザ提供単価<br>　　　　　金額</td>\n";
    $html .= "  </tr>\n";

    // 得意先ID単位のループ
    foreach ($shop_value as $client_key => $client_value){

        // レンタル毎カウンタ
        $k = 0;

        // レンタルID単位のループ
        foreach ($client_value as $rental_key => $rental_value){

            $rs_c = $ary_client_rowspan[$shop_key][$client_key];
            $rs_r = $ary_rental_rowspan[$shop_key][$client_key][$rental_key];

            $html .= "<tr>\n";
            if ($j == 0 && $k == 0){
            $html .= "  <td rowspan=\"".$rs_c."\">".++$j."</td>\n";
            $html .= "  <td rowspan=\"".$rs_c."\">".$rental_value["client_name"]."<br>".$rental_value["client_name2"]."</td>\n";
            }
            if ($k == 0){
            $html .= "  <td rowspan=\"".$rs_r."\">ren</td>\n";
            $html .= "  <td rowspan=\"".$rs_r."\">ren</td>\n";
            }
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "  <td>goo</td>\n";
            $html .= "</tr>";

            // 得意先単位の金額合計を出力

            $k++;

        }

    }

    $html .= "</table>";
    $html .= "<br><br>";

}

//print_array($ary_disp_data);

/****************************/
// 一覧表作成
/****************************/
$disp_data = array(             // ショップ毎データ配列
    "0" =>  array(                  // ショップ１データ配列
        "0" =>  "ｱﾒﾆﾃｨｸﾘｴｲﾄ(東陽商会)", // ショップ名
        "1" =>  "40",                   // 合計レンタル数
        "2" =>  "33,760",               // 合計レンタル金額
        "3" =>  "36,680",               // 合計ユーザ提供金額
        "4" =>  array(                  // レンタル先毎データ配列
            "0" =>  array(                  // レンタル先１データ配列
                "0" =>  "Result1",              // 行色css
                "1" =>  "得意先A",              // 得意先名
                "2" =>  array(                  // 出荷日毎データ配列
                    "0" =>  array(                  // 出荷日１データ配列
                        "0" =>  "1",                    // レンタルヘッダID
                        "1" =>  "chg_req",              // ステータス
                        "2" =>  "2006-04-01",           // 出荷日
                        "3" =>  array(                  // レンタル商品毎データ配列
                            "0" =>  array(                  // レンタル商品１データ配列
                                "",                             // レンタル変更・解約日
                                "契約中",                       // 状態
                                "センサXTOTO",                  // 商品名
                                "1",                            // 数量
                                "A-1",                          // シリアル
                                array("1,000", "1,000"),        // レンタル単価、金額
                                array("1,200", "1,200"),        // ユーザ提供単価、金額
                                "",                             // 備考
                            ),
                            "1" =>  array(                  // レンタル商品２データ配列
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "053",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(                  // レンタル商品３データa配列
                                "2006-04-20",
                                "解約済",
                                "自動水栓 せせらぎ",
                                "1",
                                "051",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(                  // レンタル商品４データa配列
                                "2006-07-01",
                                "解約申請",
                                "自動水栓 せせらぎ",
                                "1",
                                "052",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(                  // レンタル商品５データa配列
                                "2006-07-20",
                                "解約申請",
                                "シートクリーナー本体",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                    "1" =>  array(                  // 出荷日２データ配列
                        "0" =>  "2",
                        "1" =>  "new_req",
                        "2" =>  "---",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "新規申請",
                                "自動水栓 せせらぎ",
                                "1",
                                "",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "新規申請",
                                "シートクリーナー本体",
                                "4",
                                "",
                                array("200", "800"),
                                array("300", "1,200"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "新規申請",
                                "ピピキャッチCT1",
                                "5",
                                "",
                                array("120", "600"),
                                array("150", "750"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
            "1" =>  array(                  // レンタル先２データ配列
                "0" =>  "Result2",
                "1" =>  "得意先B",
                "2" =>  array(
                    "0" =>  array(
                        "0" =>  "3",
                        "1" =>  "non_req",
                        "2" =>  "2006-04-11",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "契約中",
                                "センサXTOTO",
                                "1",
                                "A-1",
                                array("1,000", "1,000"),
                                array("1,200", "1,200"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "052",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "053",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(
                                "2006-07-01",
                                "解約済",
                                "自動水栓 せせらぎ",
                                "1",
                                "051",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(
                                "",
                                "契約中",
                                "シートクリーナー本体",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                    "1" =>  array(
                        "0" =>  "4",
                        "1" =>  "new_req",
                        "2" =>  "---",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "新規申請",
                                "自動水栓 せせらぎ",
                                "1",
                                "",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "新規申請",
                                "シートクリーナー本体",
                                "4",
                                "",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "新規申請",
                                "ピピキャッチCT1",
                                "5",
                                "",
                                array("120", "600"),
                                array("150", "750"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    "1" =>  array(                  // ショップ２データ配列
        "0" =>  "メディスポ",           // ショップ名
        "1" =>  "40",                   // 合計レンタル数
        "2" =>  "33,760",               // 合計レンタル金額
        "3" =>  "36,680",               // 合計ユーザ提供金額
        "4" =>  array(                  // レンタル先毎データ配列
            "0" =>  array(                  // レンタル先１データ配列
                "0" =>  "Result1",              // 行色css
                "1" =>  "得意先A",              // 得意先名
                "2" =>  array(                  // 出荷日毎データ配列
                    "0" =>  array(                  // 出荷日１データ配列
                        "0" =>  "5",                    // レンタルヘッダID
                        "1" =>  "non_req",              // ステータス
                        "2" =>  "2006-04-01",           // 出荷日
                        "3" =>  array(                  // レンタル商品毎データ配列
                            "0" =>  array(                  // レンタル商品１データ配列
                                "",                             // レンタル変更・解約日
                                "契約中",                       // 状態
                                "センサXTOTO",                  // 商品名
                                "1",                            // 数量
                                "A-1",                          // シリアル
                                array("1,000", "1,000"),        // レンタル単価、金額
                                array("1,200", "1,200"),        // ユーザ提供単価、金額
                                "",                             // 備考
                            ),
                            "1" =>  array(                  // レンタル商品２データ配列
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "052",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(                  // レンタル商品３データa配列
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "053",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(                  // レンタル商品４データa配列
                                "2006-07-01",
                                "解約済",
                                "自動水栓 せせらぎ",
                                "1",
                                "051",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(                  // レンタル商品５データa配列
                                "",
                                "契約中",
                                "シートクリーナー本体",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
            "1" =>  array(                  // レンタル先２データ配列
                "0" =>  "Result2",
                "1" =>  "得意先B",
                "2" =>  array(
                    "0" =>  array(
                        "0" =>  "6",
                        "1" =>  "non_req",
                        "2" =>  "2006-04-11",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "契約中",
                                "センサXTOTO",
                                "1",
                                "A-1",
                                array("1,000", "1,000"),
                                array("1,200", "1,200"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "152",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "153",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "3" =>  array(
                                "2006-07-01",
                                "解約済",
                                "自動水栓 せせらぎ",
                                "1",
                                "151",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "4" =>  array(
                                "",
                                "契約中",
                                "シートクリーナー本体",
                                "6",
                                "-",
                                array("200", "1,200"),
                                array("300", "1,800"),
                                "",
                            ),
                        ),
                    ),
                    "1" =>  array(
                        "0" =>  "7",
                        "1" =>  "non_req",
                        "2" =>  "2006-06-06",
                        "3" =>  array(
                            "0" =>  array(
                                "",
                                "契約中",
                                "自動水栓 せせらぎ",
                                "1",
                                "251",
                                array("900", "900"),
                                array("1,000", "1,000"),
                                "",
                            ),
                            "1" =>  array(
                                "",
                                "契約中",
                                "シートクリーナー本体",
                                "4",
                                "-",
                                array("200", "800"),
                                array("300", "1,200"),
                                "",
                            ),
                            "2" =>  array(
                                "",
                                "契約中",
                                "ピピキャッチCT1",
                                "5",
                                "B-1",
                                array("120", "600"),
                                array("150", "750"),
                                "",
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
    

// 一覧用データの個数カウント(rowspan属性値算出用)
// ショップ毎ループ
for ($i = 0; $i < count($disp_data); $i++){
    // レンタル先毎ループ
    for ($j = 0; $j < count($disp_data[$i][4]); $j++){
        // レンタルヘッダID毎ループ
        for ($k = 0; $k < count($disp_data[$i][4][$j][2]); $k++){
            // 商品数カウント
            $count = count($disp_data[$i][4][$j][2][$k][3]);
            $disp_count[$i][$j] += $count;
        }
    }
}


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
$page_menu = Create_Menu_h("system", "1");

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign("var", array(
	"html_header"   => "$html_header",
	"page_menu"     => "$page_menu",
	"page_header"   => "$page_header",
	"html_footer"   => "$html_footer",
    "html"          => "$html",
));

//表示データ
$smarty->assign("disp_data", $disp_data);
$smarty->assign("disp_count", $disp_count);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
