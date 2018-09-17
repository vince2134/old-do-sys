<?php


//DB情報(DB接続時に使用)
define (DB_INFO, "host=$g_db_host port=$g_db_port dbname=$g_db_name");

//画像ディレクトリ
define (IMAGE_DIR, PATH."image/");

//設定ファイルディレクトリ
define (CONFIG_DIR, PATH."config/");

//includeディレクトリ
define (INCLUDE_DIR, PATH."include/");

//スタイルシートディレクトリ
define (CSS_DIR, PATH."css/");

//FPDFディレクトリ
define (FPDF_DIR, PATH."fpdf/mbfpdf.php");

//JavaScriptディレクトリ
define (JS_DIR, PATH."js/");

//社印の保存ディレクトリ
define (COMPANY_SEAL_DIR, PATH."data/company_seal/");

//スタッフ写真の保存ディレクトリ
define (STAFF_PHOTO_DIR, PATH."data/photo/");

//トップページ(本部)
define (TOP_PAGE_H, PATH."src/head/top.php");

//トップページ（FC）
define (TOP_PAGE_F, PATH."src/franchise/top.php");

//ログイン画面
define (LOGIN_PAGE, PATH."src/login.php");

//ログアウト画面
define (LOGOUT_PAGE, PATH."src/logout.php");

//HTML文字コード
define (HTML_CHAR, $g_html_charset);
//本部ディレクトリ
define (HEAD_DIR,PATH."src/head/");
//FCディレクトリ
define (FC_DIR,PATH."src/franchise/");

//アイテムアルバム
define (ALBUM_DIR,PATH."data/item_album/");

//システム開始日
define (START_DAY, "2005-01-01");

//ログファイル
define (LOG_FILE,PATH."log/cron_log.txt");

//マニュアル
define (MANUAL_DIR,PATH."manual/");

//analysisディレクト
define (ANALYSIS_DIR,PATH."src/analysis/");

define (STR_POS_LEFT, STR_PAD_LEFT); //amano 2015-02-13
?>
