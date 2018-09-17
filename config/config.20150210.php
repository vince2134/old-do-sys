<?php
#=======================================#
# 環境設定ファイル                      #
#=======================================#


/****************************
システム関連
****************************/
//ソースの文字コード
$g_src_charset        = "EUC-JP";
//バージョン情報
$g_sys_version        = "Revision 1.6.0";

/****************************
DB関連
****************************/
$g_db_host = "127.0.0.1";   //localhost
$g_db_name = "amenity_demo_new";
//$g_db_port = "5432";
$g_db_port = "5433";

/****************************
HTML関連
****************************/
$g_html_charset       = "EUC-JP";
$g_html_title         = "デモ";
$g_html_bgcolor       = "#FFFF66";
$g_html_font          = "";
$g_html_font_size     = "18";
$g_html_font_color    = "";
$g_text_readonly      = "readonly";

/****************************
JAVASCRIPT関連
****************************/
//$g_form_option = "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\""; //テキスト入力用
//$g_form_option_select = "onChange =\"window.focus();\""; //セレクトボックス用
    
$g_form_option          = "onKeyDown=\"chgKeycode();\" onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\""; //テキスト入力用
$g_form_option_area     = "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"";                             //テキストエリア入力用
$g_form_option_select   = "onKeyDown=\"chgKeycode();\" onChange =\"window.focus();\"";                      //セレクトボックス用
$g_form_style           = "ime-mode: disabled;";                                                            //IMEの状態を半角英数字にする
$g_button_color         = "style=\"background-color:#FDFD88; font-weight:bold;\"";                          //buttonの色

/****************************
PATH関連
****************************/
//使用していない
$g_top_page       = PATH ."src/index.php";

//ブラウザの戻るを使用出来るようにページをキャッシュする
// privateと設定すること も可能で、この場合、プロキシがキャッシュすることは許可
session_cache_limiter('private, must-revalidate');

//セッション開始
session_start();

/****************************
mail
****************************/
//エラー通知する宛先
$g_error_add = "amano@xyn.jp";
//$g_error_add = "morita-d@bhsk.co.jp,suzuki-t@bhsk.co.jp";
//$g_error_add = "suzuki-t@bhsk.co.jp";

//通知 ON/OFF
$g_error_mail = true;

/****************************
メンテナンス切替フラグ
*****************************/
$g_mente_mode = false;          //ログインできる
#$g_mente_mode = true;         //ログインできない

?>
