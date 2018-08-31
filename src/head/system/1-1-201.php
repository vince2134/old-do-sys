<?php
/*--------------------------------------------------------------------
    @Program         1-1-201.php
    @fnc.Overview    department master部署マスタ
    @author          ふくだ
    @Cng.Tracking    #1: 2006/02/07
--------------------------------------------------------------------*/

/******************************************************/
//revision history 変更履歴  
//  (2006/03/15)
//  ・$_SESSION[shop_id]を$_SESSION[client_id]に変更
//  ・$_SESSION[shop_aid]を削除

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 *   2016/01/21                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応

 
 *//******************************************************/
/*----------------------------------------------------------
    ページ内定義
----------------------------------------------------------*/

/*------------------------------------------------
    variable definition 変数定義
------------------------------------------------*/
// page name ページ名
$page_title        = "部署マスタ";

// environment set up file 環境設定ファイル
require_once("ENV_local.php");

// Database connection set up DB接続設定
$con               = Db_Connect();

// form フォーム
$form = new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null );

// authorization check 権限チェック
$auth       = Auth_Check($con);
// no input・change authorization message 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// button disabled ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// form object name フォームオブジェクト名
$f_part_cd         = "form_part_cd";
$f_part_name       = "form_part_name";
$f_note            = "form_note";
$f_btn_gr          = "form_btn_gr";
$f_btn_add         = "form_btn_add";
$f_btn_clear       = "form_btn_clear";
$f_btn_csv_out     = "form_btn_csv_out";
$f_hdn_post_csv    = "form_hdn_post_csv";
$f_hdn_part_id     = "form_hdn_part_id";
$f_hdn_status      = "form_hdn_status";
$f_hdn_process     = "form_hdn_process";

// label name・value ラベル名・バリュー
$l_part_cd         = "部署コード";
$l_part_name       = "部署名";
$l_note            = "備考";
$v_btn_add         = "登　録";
$v_btn_clear       = "クリア";
$v_btn_csv_out     = "CSV出力";

// form string limitationフォーム文字数制限値
$maxlen_part_cd    = 3;
$maxlen_part_name  = 8;
$maxlen_note       = 30;

// acquire session data SESSIONデータ取得
session_start();
$ss_staff_id       = $_SESSION["staff_id"];
$ss_shop_id        = $_SESSION["client_id"];

/* check the validyt of the ID that was GET GETしたIDの正当性チェック */
if ($_GET["id"] != null && Get_Id_Check_Db($con, $_GET["id"], "part_id", "t_part", "num", "  shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/*------------------------------------------------
    QuickForm - Form Object Definition QuickForm - フォームオブジェクト定義
------------------------------------------------*/
// Text テキスト
$form->addElement("text", $f_part_cd, $l_part_cd, "size=\"3\" maxlength=\"$maxlen_part_cd\" style=\"$g_form_style\" $g_form_option onKeyup=\"fontColor(this)\"");
$form->addElement("text", $f_part_name, $l_part_name,"size=\"22\" maxLength=\"$maxlen_part_name\" $g_form_option");
$form->addElement("text", $f_note, $l_note, "size=\"34\" maxlength=\"$maxlen_note\" $g_form_option");

// Button ボタン
$button[] = $form->createElement("submit", $f_btn_add, $v_btn_add, "onClick=\"javascript:return Dialogue4('登録します');\" $disabled");
$button[] = $form->createElement("button", $f_btn_clear, $v_btn_clear, "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
$button[] = $form->createElement("button", $f_btn_csv_out, $v_btn_csv_out, "onClick=\"javascript:Button_Submit('$f_hdn_post_csv', '#', 'post_csv_out', this);\"");
$form->addGroup($button, $f_btn_gr, null);

// hidden
$form->addElement("hidden", $f_hdn_post_csv, null);
$form->addElement("hidden", $f_hdn_part_id, null);
$form->addElement("hidden", $f_hdn_status, null);
$form->addElement("hidden", $f_hdn_process, null);

/*----------------------------------------------------------
    Process when reading the page ページ読み込み時の処理
----------------------------------------------------------*/

/*------------------------------------------------
    Acquire POST data POSTデータ取得
------------------------------------------------*/
// Acquire POST data (Register・Change) POSTデータ取得（登録・変更）
if (isset($_POST[$f_btn_gr][$f_btn_add])){
    $post_data[$f_part_cd]     = $_POST[$f_part_cd];
    $post_data[$f_part_name]   = $_POST[$f_part_name];
    $post_data[$f_note]        = $_POST[$f_note];
    $post_data[$f_hdn_part_id] = $_POST[$f_hdn_part_id];
    $post_data[$f_hdn_status]  = $_POST[$f_hdn_status];
    $post_data[$f_hdn_process] = $_POST[$f_hdn_process];
    $post_add_flg              = true;
}

// Acquire POST data (csv output) POSTデータ取得（csv出力）
if ($_POST[$f_hdn_post_csv] == "post_csv_out" && $post_add_flg == false){
    $post_csv_out_flg = true;
}

/*------------------------------------------------
    Acquire Process プロセスの取得
------------------------------------------------*/
// If being POST POSTされている場合
if ($post_add_flg == true){

    // When bing POST: Other than that POSTされた状態：それ以外
    $process = ($post_data[$f_hdn_process] == "begin") ? "post" : $post_data[$f_hdn_process];

// If not being POST POSTされていない場合
}else{

    // Initial status 初期状態
    $process = "begin";

}

/*------------------------------------------------
    Status Decision (Change・Register) ステータスの判断（登録・変更）
------------------------------------------------*/
// If there is GET data (Transition from the text link) GETデータがある場合（テキストリンクからの遷移）
if (isset($_GET["id"])){

    // Status decision using the value that was GET and the session data  GETした値とセッションデータからステータス判断
    $sql  = "SELECT ";
    $sql .= "part_id ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "part_id = ".$_GET["id"]." ";
    $sql .= "AND ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    //GET Data Decision GETデータ判定
    Get_Id_Check($res);
    $status = (pg_fetch_result($res, 0, 0) == 0) ? "add" : "chg";
// If there is no GET data GETデータがない場合
}else{

    // Initial status: Other than that 初期状態：それ以外
    $status = ($process == "begin") ? "add" : $post_data[$f_hdn_status];

}

/*------------------------------------------------
    Acquire ID IDの取得
------------------------------------------------*/
// If there is GET Data and if the status is changed (the ID that was GET is the valid one when transitioned from the text link) GETデータがあり、ステータスが変更の場合（テキストリンクからの遷移で、GETしたIDが正当）
if (isset($_GET["id"]) && $status == "chg"){

    // Acquire GET data GETデータを取得
    $get_part_id = $_GET["id"];

// Other than that それ以外
}else{
    // Initial Status: Other than that 初期状態：それ以外
    $get_part_id = ($post_data[$f_hdn_process] == "complete") ? null : $post_data[$f_hdn_part_id];

}


/*----------------------------------------------------------
    Process when register button is pressed 登録ボタン押下時の処理
----------------------------------------------------------*/
// Register pressed flag 登録押下フラグあり
if ($post_add_flg == true){

    /*------------------------------------------------
        If ther is an input, digit fill operation  入力があれば桁埋め作業
    ------------------------------------------------*/
    // department code (fill 0 in until 3 digits) 部署コード（3桁まで0埋め）
    if ($post_data[$f_part_cd] != null){
        $post_data[$f_part_cd] = str_pad($post_data[$f_part_cd], $maxlen_part_cd, "0", STR_PAD_LEFT);
    }

    /*------------------------------------------------
        QuickFrom - custom rule definition QuickForm - カスタムルール定義
    ------------------------------------------------*/
    // check multi-byte stringth length マルチバイト文字列長チェック
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

    // duplication check 重複チェック
    if ($status == "chg"){
        $sql  = "SELECT ";
        $sql .= "part_cd ";
        $sql .= "FROM ";
        $sql .= "t_part ";
        $sql .= "WHERE ";
        $sql .= "part_id = $get_part_id ";
        $sql .= "AND ";
        $sql .= "shop_id = $ss_shop_id ";
        $sql .= ";";
        $res  = Db_Query($con, $sql);
        $origin_data = pg_fetch_result($res, 0);
    }else{
        $origin_data = null;
    }
    $sql  = "SELECT ";
    $sql .= "COUNT(part_cd) ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "part_cd = '".$post_data[$f_part_cd]."' ";
    $sql .= "AND shop_id = $ss_shop_id ";
    $sql .= ";";
    $part_cd_duplicate_flg = Duplicate_Chk($con, $status, $origin_data, $post_data[$f_part_cd], $sql);

    /*------------------------------------------------
        QuickForm - rule definition QuickForm - ルール定義
    ------------------------------------------------*/
    // Check mandatory field 必須項目チェック
    $form->addRule($f_part_cd, $l_part_cd." は半角数字のみです。", "required", null);
    $form->addRule($f_part_name, $l_part_name." は1文字以上8文字以下です。", "required", null);
    // Only check full-width/half-width space 全角/半角スペースのみチェック
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule($f_part_name, "部署名に スペースのみの登録はできません。", "no_sp_name");

    // Check half-width number半角数字チェック
    $form->addRule($f_part_cd, $l_part_cd." は半角数字のみです。", "regex", "/^[0-9]+$/");

    // Duplication check 重複チェック
    if ($part_cd_duplicate_flg == true){
        $form->setElementError($f_part_cd, "既に使用されている ".$l_part_cd." です。");
    }

    /*------------------------------------------------
        QuickForm - Error check エラーチェック
    ------------------------------------------------*/
    $qf_err_flg = ($form->validate() == false) ? true : false;

    /*------------------------------------------------
        DB処理 Database process
    ------------------------------------------------*/
    // QuickFormでエラーが無ければ If there is no error in QuickForm
    if ($qf_err_flg == false){

        Db_Query($con, "BEGIN;");

        // Process for new registration 新規登録時の処理
        if ($status == "add"){

            //Register the operation classification 作業区分は登録
            $work_div = '1';
            //Registration completion message 登録完了メッセージ
            $comp_msg = "登録しました。";

            // INSERT record  レコードをINSERT
            $sql  = "INSERT INTO ";
            $sql .= "t_part(";
            $sql .= "part_id, part_cd, part_name, note, ";
            $sql .= "shop_id";
            $sql .= ") ";
            $sql .= "VALUES(";
            $sql .= "(SELECT COALESCE(MAX(part_id), 0)+1 FROM t_part), ";
            $sql .= "'$post_data[$f_part_cd]', ";
            $sql .= "'$post_data[$f_part_name]', ";
            $sql .= "'$post_data[$f_note]', ";
            $sql .= "$ss_shop_id ";
            $sql .= ") ";
            $sql .= ";";

        // Process when there is a change 変更時の処理
        }else{

            //Update the operation classification 作業区分は更新
            $work_div = '2';
            //Revision completion message 変更完了メッセージ
            $comp_msg = "変更しました。";

            // UPDATE record レコードをUPDATE
            $sql  = "UPDATE t_part ";
            $sql .= "SET ";
            $sql .= "part_cd = '$post_data[$f_part_cd]', ";
            $sql .= "part_name = '$post_data[$f_part_name]', ";
            $sql .= "note = '$post_data[$f_note]' ";
            $sql .= "WHERE part_id = $get_part_id ";
            $sql .= ";";
            

        }
        $res  = Db_Query($con, $sql);
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        //Write the value of department master in log 部署マスタの値をログに書き込む
        $res = Log_Save($con,'part',$work_div,$post_data[$f_part_cd],$post_data[$f_part_name]);
        //If there is a n error during registering in log ログ登録時にエラーになった場合
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        Db_Query($con, "COMMIT;");
    }

}

/*------------------------------------------------
    Store the process result in process 処理結果をプロセスに格納
------------------------------------------------*/
// Decide because of QuickForm Error QuickFormエラーにより判断
if ($post_add_flg == true){
    // Error: Process completed エラー：処理完了
    $process = ($qf_err_flg == true) ? "error" : "complete";
}


/*----------------------------------------------------------
    process when csv output button is pressed csv出力ボタン押下時の処理
----------------------------------------------------------*/
// Flag for when csv output is pressed csv出力押下フラグあり
if ($post_csv_out_flg == true){

    // Acquire record data  レコードデータ取得
    $sql  = "SELECT ";
    $sql .= "part_cd, ";
    $sql .= "part_name, ";
    $sql .= "note ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= "ORDER BY part_cd ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    $total_count = pg_numrows($res);
    for ($i = 0; $i < $total_count; $i++){
        $ary_csv_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // create csv file csvファイル作成
    $csv_file_name = $page_title.date("Ymd").".csv";
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_header    = array($l_part_cd, $l_part_name, $l_note);
    $csv_data      = Make_Csv($ary_csv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


/*----------------------------------------------------------
    Process for display output 画面出力用処理
----------------------------------------------------------*/

/*------------------------------------------------
    Acquire data for list 一覧用データ取得
------------------------------------------------*/
// Acquire all record data レコードデータを全て取得
$sql  = "SELECT ";
$sql .= "part_id, ";
$sql .= "part_cd, ";
$sql .= "part_name, ";
$sql .= "note ";
$sql .= "FROM ";
$sql .= "t_part ";
$sql .= "WHERE ";
$sql .= "shop_id = $ss_shop_id ";
$sql .= "ORDER BY part_cd ";
$sql .= ";";
$res  = Db_Query($con, $sql);
$total_count = pg_numrows($res);
for ($i = 0; $i < $total_count; $i++){
    $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
}

// sanitizing サニタイジング
for ($i = 0; $i < $total_count; $i++){
    for($j = 0; $j < count($ary_list_data[$i]); $j++){
        $ary_list_data[$i][$j] = htmlspecialchars($ary_list_data[$i][$j]);
    }
}

/*------------------------------------------------
    acquire/create data for complement in form フォームに補完するデータの取得・作成
------------------------------------------------*/
// At the start of the process when the status was changed ステータスが変更で、処理開始時
if ($status == "chg" && $process == "begin"){

    // Acquire appropriate data from the database DBから該当のレコード取得
    $sql  = "SELECT ";
    $sql .= "part_cd, ";
    $sql .= "part_name, ";
    $sql .= "note ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "part_id = ".$_GET["id"]." ";
    $sql .= "AND ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    $ary_rec_row_data = pg_fetch_array($res, 0, PGSQL_ASSOC);

    // レコードデータを補完 complement the record data
    $form_data[$f_part_cd]   = $ary_rec_row_data["part_cd"];
    $form_data[$f_part_name] = $ary_rec_row_data["part_name"];
    $form_data[$f_note]      = $ary_rec_row_data["note"];

// エラー時 at error 
}elseif ($process == "post" || $process == "error"){

    // POSTされたデータをそのまま補完 Complement the data that was POST
    $form_data[$f_part_cd]   = null;
    $form_data[$f_part_name] = null;
    $form_data[$f_note]      = null;

// その他 others
}else{

    // 空欄を補完 complement the blank part
    $form_data[$f_part_cd]   = "";
    $form_data[$f_part_name] = "";
    $form_data[$f_note]      = "";

}

/*------------------------------------------------
    フォームに補完するhiddenの取得・作成 acquire/create the hidden that will complement the form 
------------------------------------------------*/
// 処理完了なら when the process is complete
if ($process == "complete"){

    // hiddenを初期状態に initialize the hidden
    $form_data[$f_hdn_part_id] = "";
    $form_data[$f_hdn_status]  = "add";
    $form_data[$f_hdn_process] = "begin";

// それ以外 others
}else{

    // hiddenデータを保持 save the hidden data 
    $form_data[$f_hdn_part_id] = $get_part_id;
    $form_data[$f_hdn_status]  = $status;
    $form_data[$f_hdn_process] = $process;

}

/*------------------------------------------------
    フォームへデータ補完 complement the data to form
------------------------------------------------*/
$part_form = array(
    $f_part_cd     => $form_data[$f_part_cd],
    $f_part_name   => $form_data[$f_part_name],
    $f_note        => $form_data[$f_note],
    $f_hdn_part_id => $form_data[$f_hdn_part_id],
    $f_hdn_status  => $form_data[$f_hdn_status],
    $f_hdn_process => $form_data[$f_hdn_process]
);
$form->setConstants($part_form);


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
$page_menu = Create_Menu_h("system", "1");

/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= "(全".$total_count."件)";
$page_header = Create_Header($page_title);

// Render関連の設定 setting for Render related 
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign Form related variable
$smarty->assign("form", $renderer->toArray());

//その他の変数をassign assign other variables
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
    "auth_r_msg"  => "$auth_r_msg"
));
$smarty->assign("ary_list_data", $ary_list_data);
//テンプレートへ値を渡す pass the template value
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
