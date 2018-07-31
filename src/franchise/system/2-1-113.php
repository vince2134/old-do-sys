<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0084    suzuki      登録・変更のログを残すように修正
 *  
 *  
 *
*/

/*--------------------------------------------------------------------
    @Program         2-1-113
    @fnc.Overview    グループマスタ
    @author          kaku-m
    @Cng.Tracking    #1: 2006/11/24
--------------------------------------------------------------------*/

/*----------------------------------------------------------
    ページ内定義
----------------------------------------------------------*/

/*------------------------------------------------
    変数定義
------------------------------------------------*/
// ページ名
$page_title        = "グループマスタ";

// 環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$con               = Db_Connect();

// フォーム
$form = new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null );

// 権限チェック
//$auth       = Auth_Check($con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// フォームオブジェクト名
$f_gr_cd           = "form_gr_cd";
$f_gr_name         = "form_gr_name";
$f_note            = "form_note";
$f_btn_gr          = "form_btn_gr";
$f_btn_add         = "form_btn_add";
$f_btn_clear       = "form_btn_clear";
$f_btn_csv_out     = "form_btn_csv_out";
$f_hdn_post_csv    = "form_hdn_post_csv";
$f_hdn_gr_id       = "form_hdn_gr_id";
$f_hdn_status      = "form_hdn_status";
$f_hdn_process     = "form_hdn_process";

// ラベル名・バリュー
$l_gr_cd           = "グループコード";
$l_gr_name         = "グループ名";
$l_note            = "備考";
$v_btn_add         = "登　録";
$v_btn_clear       = "クリア";
$v_btn_csv_out     = "CSV出力";

// フォーム文字数制限値
$maxlen_gr_cd    = 3;
$maxlen_gr_name  = 20;
$maxlen_note       = 30;

// SESSIONデータ取得
session_start();
$ss_staff_id       = $_SESSION["staff_id"];
$ss_shop_id        = $_SESSION["client_id"];
$ss_group_kind     = $_SESSION["group_kind"];

/*------------------------------------------------
    QuickForm - フォームオブジェクト定義
------------------------------------------------*/
// テキスト
//グループコード
$form->addElement("text", $f_gr_cd, $l_gr_cd, "size=\"3\" maxlength=\"$maxlen_gr_cd\" style=\"$g_form_style\" $g_form_option onKeyup=\"fontColor(this)\"");
//グループ名
$form->addElement("text", $f_gr_name, $l_gr_name,"size=\"45\" maxLength=\"$maxlen_gr_name\" $g_form_option");
//備考
$form->addElement("text", $f_note, $l_note, "size=\"35\" maxlength=\"$maxlen_note\" $g_form_option");

// ボタン
$button[] = $form->createElement("submit", $f_btn_add, $v_btn_add, "onClick=\"javascript:return Dialogue4('登録します');\" $disabled");
$button[] = $form->createElement("button", $f_btn_clear, $v_btn_clear, "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
$button[] = $form->createElement("button", $f_btn_csv_out, $v_btn_csv_out, "onClick=\"javascript:Button_Submit('$f_hdn_post_csv', '#', 'post_csv_out');\"");
$form->addGroup($button, $f_btn_gr, null);

// hidden
$form->addElement("hidden", $f_hdn_post_csv, null);
$form->addElement("hidden", $f_hdn_gr_id, null);
$form->addElement("hidden", $f_hdn_status, null);
$form->addElement("hidden", $f_hdn_process, null);

/*----------------------------------------------------------
    ページ読み込み時の処理
----------------------------------------------------------*/

/*------------------------------------------------
    POSTデータ取得
------------------------------------------------*/
// POSTデータ取得（登録・変更）
if (isset($_POST[$f_btn_gr][$f_btn_add])){
    $post_data[$f_gr_cd]     = $_POST[$f_gr_cd];
    $post_data[$f_gr_name]   = $_POST[$f_gr_name];
    $post_data[$f_note]        = $_POST[$f_note];
    $post_data[$f_hdn_gr_id] = $_POST[$f_hdn_gr_id];
    $post_data[$f_hdn_status]  = $_POST[$f_hdn_status];
    $post_data[$f_hdn_process] = $_POST[$f_hdn_process];
    $post_add_flg              = true;
}

// POSTデータ取得（csv出力）
if ($_POST[$f_hdn_post_csv] == "post_csv_out" && $post_add_flg == false){
    $post_csv_out_flg = true;
}

/*------------------------------------------------
    プロセスの取得
------------------------------------------------*/
// POSTされている場合
if ($post_add_flg == true){

    // POSTされた状態：それ以外
    $process = ($post_data[$f_hdn_process] == "begin") ? "post" : $post_data[$f_hdn_process];

// POSTされていない場合
}else{

    // 初期状態
    $process = "begin";

}

/*------------------------------------------------
    ステータスの判断（登録・変更）
------------------------------------------------*/
// GETデータがある場合（テキストリンクからの遷移）
if ($_GET["id"] != ""){

    Get_Id_Check3($_GET["id"]);
    // GETした値とセッションデータからステータス判断
    $sql  = "SELECT ";
    $sql .= "client_gr_id ";
    $sql .= "FROM ";
    $sql .= "t_client_gr ";
    $sql .= "WHERE ";
    $sql .= "client_gr_id = ".$_GET["id"]." ";
    $sql .= "AND ";
    if($ss_group_kind == "2"){
        $sql .= "shop_id IN (".Rank_Sql().")";
    }else{
        $sql .= "shop_id = $ss_shop_id ";
    }
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    //GETデータ判定
    Get_Id_Check($res);
    $status = (pg_fetch_result($res, 0, 0) == 0) ? "add" : "chg";
// GETデータがない場合
}else{

    // 初期状態：それ以外
    $status = ($process == "begin") ? "add" : $post_data[$f_hdn_status];

}

/*------------------------------------------------
    IDの取得
------------------------------------------------*/
// GETデータがあり、ステータスが変更の場合（テキストリンクからの遷移で、GETしたIDが正当）
if (isset($_GET["id"]) && $status == "chg"){

    // GETデータを取得
    $get_gr_id = $_GET["id"];

// それ以外
}else{
    // 初期状態：それ以外
    $get_gr_id = ($post_data[$f_hdn_process] == "complete") ? null : $post_data[$f_hdn_gr_id];

}


/*----------------------------------------------------------
    登録ボタン押下時の処理
----------------------------------------------------------*/
// 登録押下フラグあり
if ($post_add_flg == true){

    /*------------------------------------------------
        入力があれば桁埋め作業
    ------------------------------------------------*/
    // グループコード（3桁まで0埋め）
    if ($post_data[$f_gr_cd] != null){
        $post_data[$f_gr_cd] = str_pad($post_data[$f_gr_cd], $maxlen_gr_cd, "0", STR_PAD_LEFT);
    }

    /*------------------------------------------------
        QuickForm - カスタムルール定義
    ------------------------------------------------*/
    // マルチバイト文字列長チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

    // 重複チェック
    if ($status == "chg"){
        $sql  = "SELECT ";
        $sql .= "client_gr_cd ";
        $sql .= "FROM ";
        $sql .= "t_client_gr ";
        $sql .= "WHERE ";
        $sql .= "client_gr_id = $get_gr_id ";
        $sql .= "AND ";
        $sql .= "shop_id = $ss_shop_id ";
        $sql .= ";";
        $res  = Db_Query($con, $sql);
        $origin_data = pg_fetch_result($res, 0);
    }else{
        $origin_data = null;
    }
    $sql  = "SELECT ";
    $sql .= "COUNT(client_gr_cd) ";
    $sql .= "FROM ";
    $sql .= "t_client_gr ";
    $sql .= "WHERE ";
    $sql .= "client_gr_cd = '".$post_data[$f_gr_cd]."' ";
    $sql .= "AND shop_id = $ss_shop_id ";
    $sql .= ";";
    $gr_cd_duplicate_flg = Duplicate_Chk($con, $status, $origin_data, $post_data[$f_gr_cd], $sql);

    /*------------------------------------------------
        QuickForm - ルール定義
    ------------------------------------------------*/
    // 必須項目チェック
    $form->addRule($f_gr_cd, $l_gr_cd." は半角数字のみです。", "required", null);
    $form->addRule($f_gr_name, $l_gr_name." は1文字以上20文字以下です。", "required", null);

    // 半角数字チェック
    $form->addRule($f_gr_cd, $l_gr_cd." は半角数字のみです。", "numeric");

    // 重複チェック
    if ($gr_cd_duplicate_flg == true){
        $form->setElementError($f_gr_cd, "既に使用されている ".$l_gr_cd." です。");
    }

    /*------------------------------------------------
        QuickForm - エラーチェック
    ------------------------------------------------*/
    $qf_err_flg = ($form->validate() == false) ? true : false;


    //スペースチェック
    $post_data[$f_gr_name] = Space_rm($post_data[$f_gr_name]);
    if($post_data[$f_gr_name] == ""){
        $qf_err_flg = true;
        $space_err = "スペースでの登録は出来ません。";
    }

    /*------------------------------------------------
        DB処理
    ------------------------------------------------*/
    // QuickFormでエラーが無ければ
    if ($qf_err_flg == false){

        Db_Query($con, "BEGIN;");

        // 新規登録時の処理
        if ($status == "add"){

            //作業区分は登録
            $work_div = '1';
            //登録完了メッセージ
            $comp_msg = "登録しました。";

            // レコードをINSERT
            $sql  = "INSERT INTO ";
            $sql .= "t_client_gr(";
            $sql .= "client_gr_id, client_gr_cd, client_gr_name, note, ";
            $sql .= "shop_id";
            $sql .= ") ";
            $sql .= "VALUES(";
            $sql .= "(SELECT COALESCE(MAX(client_gr_id), 0)+1 FROM t_client_gr), ";
            $sql .= "'$post_data[$f_gr_cd]', ";
            $sql .= "'$post_data[$f_gr_name]', ";
            $sql .= "'$post_data[$f_note]', ";
            $sql .= "$ss_shop_id ";
            $sql .= ") ";
            $sql .= ";";

        // 変更時の処理
        }else{

            //作業区分は更新
            $work_div = '2';
            //変更完了メッセージ
            $comp_msg = "変更しました。";

            // レコードをUPDATE
            $sql  = "UPDATE t_client_gr ";
            $sql .= "SET ";
            $sql .= "client_gr_cd = '$post_data[$f_gr_cd]', ";
            $sql .= "client_gr_name = '$post_data[$f_gr_name]', ";
            $sql .= "note = '$post_data[$f_note]' ";
            $sql .= "WHERE client_gr_id = $get_gr_id ";
            $sql .= ";";


        }
        $res  = Db_Query($con, $sql);
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        //グループマスタの値をログに書き込む
        $res = Log_Save($con,'gr',$work_div,$post_data[$f_gr_cd],$post_data[$f_gr_name]);
        //ログ登録時にエラーになった場合
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        Db_Query($con, "COMMIT;");
    }

}

/*------------------------------------------------
    処理結果をプロセスに格納
------------------------------------------------*/
// QuickFormエラーにより判断
if ($post_add_flg == true){
    // エラー：処理完了
    $process = ($qf_err_flg == true) ? "error" : "complete";
}


/*----------------------------------------------------------
    csv出力ボタン押下時の処理
----------------------------------------------------------*/
// csv出力押下フラグあり
if ($post_csv_out_flg == true){

    // レコードデータ取得
    $sql  = "SELECT ";
    $sql .= "client_gr_cd, ";
    $sql .= "client_gr_name, ";
    $sql .= "note ";
    $sql .= "FROM ";
    $sql .= "t_client_gr ";
    $sql .= "WHERE ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= "ORDER BY client_gr_cd ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    $total_count = pg_numrows($res);
    for ($i = 0; $i < $total_count; $i++){
        $ary_csv_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // csvファイル作成
    $csv_file_name = $page_title.date("Ymd").".csv";
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_header    = array($l_gr_cd, $l_gr_name, $l_note);
    $csv_data      = Make_Csv($ary_csv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


/*----------------------------------------------------------
    画面出力用処理
----------------------------------------------------------*/

/*------------------------------------------------
    一覧用データ取得
------------------------------------------------*/
// レコードデータを全て取得
$sql  = "SELECT ";
$sql .= "client_gr_id, ";
$sql .= "client_gr_cd, ";
$sql .= "client_gr_name, ";
$sql .= "note ";
$sql .= "FROM ";
$sql .= "t_client_gr ";
$sql .= "WHERE ";
if($ss_group_kind == "2"){
    $sql .= "shop_id IN (".Rank_Sql().")";
}else{
    $sql .= "shop_id = $ss_shop_id ";
}
$sql .= "ORDER BY client_gr_cd ";
$sql .= ";";
$res  = Db_Query($con, $sql);
$total_count = pg_numrows($res);
for ($i = 0; $i < $total_count; $i++){
    $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
}

// サニタイジング
for ($i = 0; $i < $total_count; $i++){
    for($j = 0; $j < count($ary_list_data[$i]); $j++){
        $ary_list_data[$i][$j] = htmlspecialchars($ary_list_data[$i][$j]);
    }
}

/*------------------------------------------------
    フォームに補完するデータの取得・作成
------------------------------------------------*/
// ステータスが変更で、処理開始時
if ($status == "chg" && $process == "begin"){

    // DBから該当のレコード取得
    $sql  = "SELECT ";
    $sql .= "client_gr_cd, ";
    $sql .= "client_gr_name, ";
    $sql .= "note ";
    $sql .= "FROM ";
    $sql .= "t_client_gr ";
    $sql .= "WHERE ";
    $sql .= "client_gr_id = ".$_GET["id"]." ";
    $sql .= "AND ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    $ary_rec_row_data = pg_fetch_array($res, 0, PGSQL_ASSOC);

    // レコードデータを補完
    $form_data[$f_gr_cd]   = $ary_rec_row_data["client_gr_cd"];
    $form_data[$f_gr_name] = $ary_rec_row_data["client_gr_name"];
    $form_data[$f_note]      = $ary_rec_row_data["note"];

// エラー時
}elseif ($process == "post" || $process == "error"){

    // POSTされたデータをそのまま補完
    $form_data[$f_gr_cd]   = null;
    $form_data[$f_gr_name] = null;
    $form_data[$f_note]      = null;

// その他
}else{

    // 空欄を補完
    $form_data[$f_gr_cd]   = "";
    $form_data[$f_gr_name] = "";
    $form_data[$f_note]      = "";

}

/*------------------------------------------------
    フォームに補完するhiddenの取得・作成
------------------------------------------------*/
// 処理完了なら
if ($process == "complete"){

    // hiddenを初期状態に
    $form_data[$f_hdn_gr_id] = "";
    $form_data[$f_hdn_status]  = "add";
    $form_data[$f_hdn_process] = "begin";

// それ以外
}else{

    // hiddenデータを保持
    $form_data[$f_hdn_gr_id] = $get_gr_id;
    $form_data[$f_hdn_status]  = $status;
    $form_data[$f_hdn_process] = $process;

}

/*------------------------------------------------
    フォームへデータ補完
------------------------------------------------*/
$gr_form = array(
    $f_gr_cd     => $form_data[$f_gr_cd],
    $f_gr_name   => $form_data[$f_gr_name],
    $f_note        => $form_data[$f_note],
    $f_hdn_gr_id => $form_data[$f_hdn_gr_id],
    $f_hdn_status  => $form_data[$f_hdn_status],
    $f_hdn_process => $form_data[$f_hdn_process]
);
$form->setConstants($gr_form);

/****************************/
//半角スペース取り除く関数
/****************************/
function Space_rm($str){
    $str = ereg_replace(" ","　",$str);
    $count = mb_strlen($str);
    $sp_count = substr_count($str,"　");
    if($count == $sp_count){
        $str = ereg_replace("　","",$str);
        return $str;
    }else{
        return $str;
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
$page_title .= "(全".$total_count."件)";
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign
$smarty->assign("var", array(
        "html_header" => "$html_header",
        "page_menu"   => "$page_menu",
        "page_header" => "$page_header",
        "html_footer" => "$html_footer",
        "html_page"   => "$html_page",
        "html_page2"  => "$html_page2",
        "total_count" => "$total_count",
    "qf_err_flg"  => "$qf_err_flg",
    "comp_msg"    => "$comp_msg",
    "space_err"   => "$space_err",
    "auth_r_msg"  => "$auth_r_msg"
));
$smarty->assign("ary_list_data", $ary_list_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

