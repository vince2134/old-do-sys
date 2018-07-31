<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0070    suzuki      登録・変更のログを残すように修正
 *  2006-12-11      ban_0131    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *   2016/01/20                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応    
 *  
 *
*/

$page_title = "施設マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//GETデータ取得
/****************************/
$get_inst_id = $_GET["inst_id"];

/* GETしたIDの正当性チェック */
if ($_GET["inst_id"] != null && Get_Id_Check_Db($conn, $_GET["inst_id"], "inst_id", "t_inst", "num") != true){
    header("Location: ../top.php");
}

/****************************/
//初期値を抽出
/****************************/
if($get_inst_id != null){
    $sql  = "SELECT";
    $sql .= "   inst_cd,";
    $sql .= "   inst_name,";
    $sql .= "   note,";
    $sql .= "   accept_flg ";
    $sql .= " FROM";
    $sql .= "   t_inst";
    $sql .= " WHERE";
    $sql .= "   inst_id = $get_inst_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_inst_cd"]       = pg_fetch_result($result,0,0);
    $def_inst_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_inst_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_inst_note"]     = pg_fetch_result($result,0,2);
    $def_data["form_accept"]        = pg_fetch_result($result,0,3);
    $def_data["update_flg"]         = true;
}else{
    $def_data["form_accept"]        = "2";
}
$form->setDefaults($def_data);

/*****************************/
//オブジェクト作成
/*****************************/
//施設コード
$form->addElement("text","form_inst_cd","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"".$g_form_option."\"");
//施設名
$form->addElement("text","form_inst_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//承認ラジオボタン
$form_accept[] =& $form->createElement("radio", null, null, "承認済", "1");
$form_accept[] =& $form->createElement("radio", null, null, "未承認", "2");
$form->addGroup($form_accept, "form_accept", "");

//ボタン
$form->addElement("submit","form_entry_button","登　録","onClick=\"return Dialogue('登録します。', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//備考
$form->addElement("text","form_inst_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");
/****************************/
//ルール作成
/****************************/
//施設コード
$form->addRule("form_inst_cd", "施設コードは半角数字のみ3桁です。","required");
$form->addRule("form_inst_cd", "施設コードは半角数字のみ3桁です。", "regex", "/^[0-9]+$/");

//施設名
$form->addRule("form_inst_name", "施設名は1文字以上10文字以下です。","required");
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_inst_name", "施設名 にスペースのみの登録はできません。", "no_sp_name");

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST情報取得
    /****************************/
    $inst_cd        = $_POST["form_inst_cd"];                                   //施設CD
    $inst_name      = $_POST["form_inst_name"];                                 //施設名
    $inst_note      = $_POST["form_inst_note"];                                 //備考
    $accept         = $_POST["form_accept"];
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //施設コード整形
    /***************************/
    $inst_cd = str_pad($inst_cd, 3, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   inst_cd";
    $sql .= " FROM";
    $sql .= "   t_inst";
    $sql .= " WHERE";
    $sql .= "   inst_cd = '$inst_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //使用済みエラー
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_inst_cd != $inst_cd))){
        $form->setElementError("form_inst_cd","既に使用されている 施設コード です。");
    }

    /***************************/
    //検証  
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //登録処理
        /*****************************/
        if($update_flg != true){

            $message = "登録しました。";

            $insert_sql  = "INSERT INTO t_inst(";
            $insert_sql .= "    inst_id,";
            $insert_sql .= "    inst_cd,";
            $insert_sql .= "    inst_name,";
            $insert_sql .= "    note, ";
            $insert_sql .= "    accept_flg ";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(inst_id), 0)+1 FROM t_inst),";
            $insert_sql .= "    '$inst_cd',";
            $insert_sql .= "    '$inst_name',";
            $insert_sql .= "    '$inst_note', ";
            $insert_sql .= "    '$accept' ";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した情報をログに残す
            $result = Log_Save( $conn, "inst", "1", $inst_cd, $inst_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*******************************/
        //変更処理
        /*******************************/
        }elseif($update_flg == true){
            $message = "変更しました。";

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_inst";
            $insert_sql .= " SET";
            $insert_sql .= "    inst_cd = '$inst_cd',";
            $insert_sql .= "    inst_name = '$inst_name',";
            $insert_sql .= "    note = '$inst_note', ";
            $insert_sql .= "    accept_flg = '$accept' ";
            $insert_sql .= " WHERE";
            $insert_sql .= "    inst_id = $get_inst_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
   
            //登録した情報をログに残す
            $result = Log_Save( $conn, "inst", "2", $inst_cd, $inst_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_inst_cd"]       = "";                                   //施設CD
        $set_data["form_inst_name"]     = "";                                 //施設名
        $set_data["form_inst_note"]     = "";                                 //備考
        $set_data["form_accept"]        = "2";
        $set_data["update_flg"]         = "";

        $form->setConstants($set_data);

    }
}

/*****************************
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   inst_cd,";
$sql .= "   inst_id,";
$sql .= "   inst_name,";
$sql .= "   note,";
$sql .= "   accept_flg ";
$sql .= " FROM";
$sql .= "   t_inst";
$sql .= "   ORDER BY t_inst.inst_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSVボタン押下処理
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "登　録"){

	$sql  = "SELECT";
	$sql .= "   inst_cd,";
	$sql .= "   inst_id,";
	$sql .= "   inst_name,";
	$sql .= "   note,";
	$sql .= "   accept_flg ";
	$sql .= " FROM";
	$sql .= "   t_inst";
	$sql .= "   ORDER BY t_inst.inst_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][2] = $page_data[$i][2];
        $csv_page_data[$i][3] = $page_data[$i][3];
        $csv_page_data[$i][4] = ($page_data[$i][4] == "1") ? "○" : "×";
    }

    $csv_file_name = "施設マスタ".date("Ymd").".csv";
    $csv_header = array(
        "施設コード",
        "施設名",
        "備考",
        "承認"
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
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
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "(全".$total_count."件)";
$page_header = Create_Header($page_title);


// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'total_count'   => "$total_count",
    'message'       => "$message",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign("page_data",$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
