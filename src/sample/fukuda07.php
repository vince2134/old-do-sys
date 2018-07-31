<?php

/**************************************************/
// 初期設定 Smarty
/**************************************************/
// 環境設定ファイル指定
require_once("ENV_local.php");
// HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
// DB接続設定
$db_con = Db_Connect();


/**************************************************/
// 初期設定 処理
/**************************************************/
// 場所
$src_path = "/usr/local/apache2/htdocs/amenity";

// 検索場所
$search_path["src"]["head"]["sale"]             = null;
$search_path["src"]["head"]["buy"]              = null;
$search_path["src"]["head"]["stock"]            = null;
$search_path["src"]["head"]["renew"]            = null;
$search_path["src"]["head"]["analysis"]         = null;
$search_path["src"]["head"]["system"]           = null;
$search_path["src"]["head"]["dialog"]           = null;
$search_path["src"]["franchise"]["sale"]        = null;
$search_path["src"]["franchise"]["buy"]         = null;
$search_path["src"]["franchise"]["stock"]       = null;
$search_path["src"]["franchise"]["renew"]       = null;
$search_path["src"]["franchise"]["analysis"]    = null;
$search_path["src"]["franchise"]["system"]      = null;
$search_path["src"]["franchise"]["dialog"]      = null;
$search_path["function"]                        = null;
$search_path["js"]                              = null;
$search_path["cron"]                            = null;
$search_path["include"]                         = null;
$search_path["config"]                          = null;
$search_path["css"]                             = null;

// 取得除外リスト
// モジュール用
$cutout_mod = array(
    "old",
    "bak",
    "org",
    "ENV_local",
    "test",
    "sample",
);
// 関数らへん用
$cutout_fnc = array(
    ".old",
    ".bak",
    "OLD",
);

// エラーメッセージ集
$ary_err_msg = array(
    // ファイル未選択エラー1
    "no_select_src" => array(
        "ファイルを選択してください。",
        "ファイルを選択してください。",
        "ファイルを選択してください。",
        "っちょ、ファイル選択しんさいや。",
        "半年ロムってろ。",
    ),
    // ファイル未選択エラー2
    "no_select_tpl" => array(
        "テンプレートのないファイルが選択されています。",
        "テンプレートのないファイルが選択されています。",
        "テンプレないよ。",
    ),
    // ランダム選択エラー
    "no_random" => array(
        "それはないわ。",
        "つまんね。",
    ),
);

// ボタンdisabled設定
$quick_btn_disabled     = ($_POST["form_quick"] != null || $_POST["form_commit"] != null) ? "disabled" : "";
$back_btn_disabled      = ($_POST["form_quick"] == null) ? "disabled" : "";
$commit_btn_disabled    = ($_POST["form_quick"] == null) ? "disabled" : "";

// デフォルト値
$def_data["form_src_tpl"] = "2";
$form->setDefaults($def_data);


/**************************************************/
// 関数
/**************************************************/
// 配列内のNULL行を除去
function Unnull_Array($ary){
    foreach ($ary as $key => $value){
        ($value != null) ? $ary_unnull[] = $value : null;
    }
    return $ary_unnull;
}

// 除外リストにマッチする行を除去
function Cutout_Array($ary, $cutout){
    foreach ($ary as $ary_key => $ary_value){
        $cut_flg = false;
        foreach ($cutout as $cut_key => $cut_value){
            if (strstr($ary_value, $cut_value) && $cut_flg != true){
                $cut_flg = true;
                break;
            }
        }
        if ($cut_flg == true){
            break;
        }
        $ary_cut[] = $ary_value;
    }
    return $ary_cut;
}

// ファイルパスを元にテンプレパスを作成
function Make_Tpl_Path($ary){
    foreach ($ary as $key => $value){
        $file_name = substr(strrchr($value, "/"), 1);
        $ary_tpl_path[] = str_replace($file_name, "templates/$file_name.tpl", $value);
    }
    return $ary_tpl_path;
}

// ファイルパスを元にデモパスを作成
function Make_Demo_Path($ary){
    foreach ($ary as $key => $value){
//        $ary_demo_path[] = str_replace("/amenity/", "/demo/amenity/", $value);
        $ary_demo_path[] = str_replace("/amenity/", "/fukuda/amenity013101/", $value);
    }
    return $ary_demo_path;
}

// ファイルパスからファイル名だけぶっこ抜き
function Clip_File_Name($ary){
    foreach ($ary as $key => $value){
        $ary_file_name[] = substr(strrchr($value, "/"), 1);
    }
    return $ary_file_name;
}


/**************************************************/
// ファイルパス作成
/**************************************************/
foreach ($search_path as $key1 => $value1){
    // モジュール
    if (is_array($value1)){
        // 本部・FCでループ
        foreach ($value1 as $key2 => $value2){
            if (is_array($value2)){
                // 区分でループ
                foreach ($value2 as $key3 => $value3){
                    // パス収集コマンド
                    $cmd[$key1][$key2][$key3] = "ls -l $src_path/$key1/$key2/$key3/*.php | awk '{print $9}'";
                    // コマンド実行
                    $src_file_path[$key1][$key2][$key3] = explode("\n", shell_exec($cmd[$key1][$key2][$key3]));
                    // NULL行を除去
                    $src_file_path[$key1][$key2][$key3] = Unnull_Array($src_file_path[$key1][$key2][$key3]);
                    // 除外リストにマッチする行を除去
                    $src_file_path[$key1][$key2][$key3] = Cutout_Array($src_file_path[$key1][$key2][$key3], $cutout_mod);
                    // テンプレパス作成
                    $src_file_path_tpl[$key1][$key2][$key3] = Make_Tpl_Path($src_file_path[$key1][$key2][$key3]);
                    // デモパス作成
                    $dst_file_path[$key1][$key2][$key3] = Make_Demo_Path($src_file_path[$key1][$key2][$key3]);
                    // デモテンプレパス作成
                    $dst_file_path_tpl[$key1][$key2][$key3] = Make_Tpl_Path($dst_file_path[$key1][$key2][$key3]);
                }
            }
        }
    // 関数らへん
    }else{
        // パス収集コマンド
        $cmd[$key1] = "ls -l $src_path/$key1/*.* | awk '{print $9}'";
        // コマンド実行
        $src_file_path[$key1] = explode("\n", shell_exec($cmd[$key1]));
        // NULL行を除去
        $src_file_path[$key1] = Unnull_Array($src_file_path[$key1]);
        // 除外リストにマッチする行を除去
        $src_file_path[$key1] = Cutout_Array($src_file_path[$key1], $cutout_fnc);
        // デモパス作成
        $dst_file_path[$key1] = Make_Demo_Path($src_file_path[$key1]);
    }
}


/**************************************************/
// 選択完了ボタン押下時の処理
/**************************************************/
if ($_POST["form_quick"] != null){

    // 検索場所でループ
    foreach ($search_path as $key1 => $value1){
        // モジュール
        if (is_array($value1)){
            // 本部・FCでループ
            foreach ($value1 as $key2 => $value2){
                if (is_array($value2)){
                    // 区分でループ
                    foreach ($value2 as $key3 => $value3){
                        // セレクトボックスの選択がある場合
                        if ($_POST["form_".$key2."_".$key3] != null){
                            // 作成したセレクトボックスでループ
                            foreach ($_POST["form_".$key2."_".$key3] as $post_key => $post_value){
                                // ソースをアップする場合
                                if ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2"){
                                // 選択された/アップする予定の ファイルパスを変数に代入
                                    $select_src_file[] = $src_file_path[$key1][$key2][$key3][$post_value];
                                    $upload_dst_file[] = $dst_file_path[$key1][$key2][$key3][$post_value];
                                }
                                // テンプレをアップする場合
                                if ($_POST["form_src_tpl"] == "3"){
                                    // 選択された/アップする予定の ファイルパスを変数に代入
                                    $select_src_file_tpl[] = $src_file_path_tpl[$key1][$key2][$key3][$post_value];
                                    $upload_dst_file_tpl[] = $dst_file_path_tpl[$key1][$key2][$key3][$post_value];
                                }
                            }
                        }
                    }
                }
            }
        // 関数らへん
        }else{
            // セレクトボックスの選択がある＋ソースをアップする場合
            if ($_POST["form_".$key1] != null && ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2")){
                // 作成したセレクトボックスでループ
                foreach ($_POST["form_".$key1] as $post_key => $post_value){
                    // 選択された/アップする予定の ファイルパスを変数に代入
                    $select_src_file[] = $src_file_path[$key1][$post_value];
                    $upload_dst_file[] = $dst_file_path[$key1][$post_value];
                }
            }
        }
    }

    /* エラーチェック */
    // 選択が無い場合（ファイルパス変数が作成されていない場合）
    if ($select_src_file == null && $select_src_file_tpl == null){
        $no_select_err_msg = $ary_err_msg["no_select_src"][array_rand($ary_err_msg["no_select_src"])];
        $err_flg = true;
    }

    /* エラーチェック */
    // ランダムエラー
    if ($_POST["form_src_tpl"] == "4" && $err_flg != true){
        $no_random_err_msg = $ary_err_msg["no_random"][array_rand($ary_err_msg["no_random"])];
        $err_flg = true;
    }

    // エラー時は選択完了ボタンをenabledに設定
    $quick_btn_disabled     = ($err_flg == true) ? "" : "disabled";
    // 戻るするボタンdisabled設定
    $back_btn_disabled      = ($err_flg == true) ? "disabled" : "";
    // アップするボタンdisabled設定
    $commit_btn_disabled    = ($err_flg == true) ? "disabled" : "";

    // 選択された/アップする予定の ファイルパスをhiddenにセット
    if ($select_src_file != null && ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2")){
        foreach ($select_src_file as $key => $value){
            $hdn_set["src_file_path[$key]"] = $value;
        }
    }
    if ($upload_dst_file != null && ($_POST["form_src_tpl"] == "1" || $_POST["form_src_tpl"] == "2")){
        foreach ($upload_dst_file as $key => $value){
            $hdn_set["dst_file_path[$key]"] = $value;
        }
    }
    if ($select_src_file_tpl != null && $_POST["form_src_tpl"] == "3"){
        foreach ($select_src_file_tpl as $key => $value){
            $hdn_set["src_file_path_tpl[$key]"] = $value;
        }
    }
    if ($upload_dst_file_tpl != null && $_POST["form_src_tpl"] == "3"){
        foreach ($upload_dst_file_tpl as $key => $value){
            $hdn_set["dst_file_path_tpl[$key]"] = $value;
        }
    }
    $form->setConstants($hdn_set);


}


/**************************************************/
// アップするボタン押下時の処理
/**************************************************/
if ($_POST["form_commit"] != null){

    // POSTされたファイルパスからコマンド作成
    if ($_POST["src_file_path"] != null){
        foreach ($_POST["src_file_path"] as $key => $value){
            $upload_cmd[] = "cp -fp ".$value." ".$_POST["dst_file_path"][$key];
        }
    }
    if ($_POST["src_file_path_tpl"] != null){
        foreach ($_POST["src_file_path_tpl"] as $key => $value){
            $upload_cmd[] = "cp -fp ".$value." ".$_POST["dst_file_path_tpl"][$key];
        }
    }

    // コマンド実行
    foreach ($upload_cmd as $key => $value){
        // エスケープ後、コマンド実行
        $result = shell_exec(escapeshellcmd($value));
print_array($result);

    }
print_array($upload_cmd);
//print_array($result);
        

}


/**************************************************/
// フォーム作成
/**************************************************/
// 検索場所でループ
foreach ($search_path as $key1 => $value1){
    if (is_array($value1)){
        // 本部・FCでループ
        foreach ($value1 as $key2 => $value2){
            if (is_array($value2)){
                // 区分でループ
                foreach ($value2 as $key3 => $value3){
                    $select_value = "";
                    $select_value = Clip_File_Name($src_file_path[$key1][$key2][$key3]);
                    $option = "multiple size=\"15\" style=\"width: 120px;\"";
                    $commit_freeze[] = $form->addElement("select", "form_".$key2."_".$key3, "", $select_value, $option);
                    $form->addElement("hidden", "hdn_select[$key1][$key2][$key3]", "", $select_value, $option);
                }
            }
        }
    }else{
        $select_value = "";
        $select_value = Clip_File_Name($src_file_path[$key1]);
        $option = "multiple size=\"10\" style=\"width: 120px;\"";
        $commit_freeze[] = $form->addElement("select", "form_".$key1, "", $select_value, $option);
        $form->addElement("hidden", "hdn_select[$key1]", "", $select_value, $option);
    }
}

// テンプレもチェック
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "ソースとテンプレ", "1");
$radio[] =& $form->createElement("radio", null, null, "いやいや、ソースだけ", "2");
$radio[] =& $form->createElement("radio", null, null, "むしろテンプレだけ", "3");
$radio[] =& $form->createElement("radio", null, null, "じゃあ、おまかせで", "4");
$commit_freeze[] = $form->addGroup($radio, "form_src_tpl", "", "<br>");

// とりあえずこれでボタン
$form->addElement("submit", "form_quick", "選択完了", $quick_btn_disabled);

// 戻るボタン
$form->addElement("button", "form_back", "一つ戻る", $back_btn_disabled." onClick=\"history.back();\"");

// アップするよボタン
$form->addElement("submit", "form_commit", "アップする", $commit_btn_disabled);

// 最初からやり直すボタン
$form->addELement("button", "form_clear", "最初に戻る", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

// hidden アップする元ファイル
if ($select_src_file != null){
    foreach ($select_src_file as $key => $value){
        $form->addElement("hidden", "src_file_path[$key]", "", "");
    }
}

// hidden アップする先ファイル
if ($upload_dst_file != null){
    foreach ($upload_dst_file as $key => $value){
        $form->addElement("hidden", "dst_file_path[$key]", "", "");
    }
}

// hidden アップする元ファイル テンプレ
if ($select_src_file_tpl != null){
    foreach ($select_src_file_tpl as $key => $value){
        $form->addElement("hidden", "src_file_path_tpl[$key]", "", "");
    }
}

// hidden アップする先ファイル テンプレ
if ($upload_dst_file_tpl != null){
    foreach ($upload_dst_file_tpl as $key => $value){
        $form->addElement("hidden", "dst_file_path_tpl[$key]", "", "");
    }
}

// 選択完了ボタン押下＋エラー無し時
if (($_POST["form_quick"] != null || $_POST["form_commit"]) && $err_flg != true){
    // フリーズ処理
    $commit_freeze_form = $form->addGroup($commit_freeze, "commit_freeze", "");
    $commit_freeze_form->freeze();
}


/**************************************************/
// html作成
/**************************************************/
$html  = "";
$html  = "<table border=\"0\" style=\"font-size: 11px;\">\n";
$html .= "  <tr valign=\"top\">\n";
foreach ($search_path as $key1 => $value1){
    if (is_array($value1)){
        foreach ($value1 as $key2 => $value2){
            if (is_array($value2)){
                foreach ($value2 as $key3 => $value3){
$html .= "      <td style=\"padding-right: 5px; padding-bottom: 10px;\">\n";
$html .= "          <b>".$key2."/".$key3."</b><br>\n";
$html .=            $form->_elements[$form->_elementIndex["form_".$key2."_".$key3]]->toHtml()."\n";
$html .= "      </td>\n";
                }
            }
$html .= "  </tr>\n";
$html .= "  <tr valign=\"top\">\n";
        }
    }else{
$html .= "      <td>\n";
$html .= "          <b>".$key1."</b><br>\n";
$html .=            $form->_elements[$form->_elementIndex["form_".$key1]]->toHtml()."\n";
$html .= "      </td>\n";
    }
}
$html .= "  </tr>\n";
$html .= "</table>\n";


/**************************************************/
// Smarty
/**************************************************/
// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);
// form関連の変数をassign
$smarty->assign("form", $renderer->toArray());
// その他の変数をassign
$smarty->assign("html", $html);
$smarty->assign("err", array(
    "no_random_err_msg"     => $no_random_err_msg,
    "no_select_err_msg"     => $no_select_err_msg,
));
// テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF].".tpl"));

?>
