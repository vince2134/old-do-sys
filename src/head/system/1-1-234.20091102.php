<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0069    suzuki      登録・変更のログを残すように修正
 *  2006-12-11      ban_0130    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *  
 *  
 *
*/

$page_title = "業態マスタ";

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
$get_bstruct_id = $_GET["bstruct_id"];

/* GETしたIDの正当性チェック */
if ($_GET["bstruct_id"] != null && Get_Id_Check_Db($conn, $_GET["bstruct_id"], "bstruct_id", "t_bstruct", "num") != true){
    header("Location: ../top.php");
}

/****************************/
//初期値を抽出
/****************************/
if($get_bstruct_id != null){
    $sql  = "SELECT";
    $sql .= "   bstruct_cd,";
    $sql .= "   bstruct_name,";
    $sql .= "   note,";
    $sql .= "   accept_flg";
    $sql .= " FROM";
    $sql .= "   t_bstruct";
    $sql .= " WHERE";
    $sql .= "   bstruct_id = $get_bstruct_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_bstruct_cd"]       = pg_fetch_result($result,0,0);
    $def_bstruct_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_bstruct_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_bstruct_note"]     = pg_fetch_result($result,0,2);
    $def_data["form_accept"]       = pg_fetch_result($result,0,3);
    $def_data["update_flg"]            = true;
}else{
    $def_data["form_accept"]           = "2";
}

$form->setDefaults($def_data);

/*****************************/
//オブジェクト作成
/*****************************/
//業態コード
$form->addElement("text","form_bstruct_cd","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"".$g_form_option."\"");
//業態名
$form->addElement("text","form_bstruct_name","","size=\"34\" maxLength=\"20\"".$g_form_option."\"");

//ボタン
$form->addElement("submit","form_entry_button","登　録","onClick=\"return Dialogue('登録します。', '#')\" $disabled");
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");

//備考
$form->addElement("text","form_bstruct_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//承認チェック
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "承認済","1");
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "未承認","2");
$form->addGroup($form_accept, "form_accept", "");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");
/****************************/
//ルール作成
/****************************/
//業態コード
$form->addRule("form_bstruct_cd", "業態コードは半角数字のみ3桁です。","required");
$form->addRule("form_bstruct_cd", "業態コードは半角数字のみ3桁です。", "regex", "/^[0-9]+$/");

//業態名
$form->addRule("form_bstruct_name", "業態名は1文字以上20文字以下です。","required");
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_bstruct_name", "業態名 にスペースのみの登録はできません。", "no_sp_name");

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST情報取得
    /****************************/
    $bstruct_cd        = $_POST["form_bstruct_cd"];                                   //業態CD
    $bstruct_name      = $_POST["form_bstruct_name"];                                 //業態名
    $bstruct_note      = $_POST["form_bstruct_note"];                                 //備考
    $accept            = $_POST["form_accept"];
    $update_flg        = $_POST["update_flg"];

    /***************************/
    //業態コード整形
    /***************************/
    $bstruct_cd = str_pad($bstruct_cd, 3, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   bstruct_cd";
    $sql .= " FROM";
    $sql .= "   t_bstruct";
    $sql .= " WHERE";
    $sql .= "   bstruct_cd = '$bstruct_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //使用済みエラー
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_bstruct_cd != $bstruct_cd))){
        $form->setElementError("form_bstruct_cd","既に使用されている 業態コード です。");
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
            $work_div = 1;

            $insert_sql  = "INSERT INTO t_bstruct(";
            $insert_sql .= "    bstruct_id,";
            $insert_sql .= "    bstruct_cd,";
            $insert_sql .= "    bstruct_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    accept_flg";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(bstruct_id), 0)+1 FROM t_bstruct),";
            $insert_sql .= "    '$bstruct_cd',";
            $insert_sql .= "    '$bstruct_name',";
            $insert_sql .= "    '$bstruct_note',";
            $insert_sql .= "    '$accept'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
/*
            //登録した情報をログに残す
            $result = Log_Save( $conn, "bstruct", "1", $bstruct_cd, $bstruct_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
*/
        /*******************************/
        //変更処理
        /*******************************/
        }elseif($update_flg == true){
            $message = "変更しました。";
            $work_div = 2;

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_bstruct";
            $insert_sql .= " SET";
            $insert_sql .= "    bstruct_cd = '$bstruct_cd',";
            $insert_sql .= "    bstruct_name = '$bstruct_name',";
            $insert_sql .= "    note = '$bstruct_note',";
            $insert_sql .= "    accept_flg = '$accept'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    bstruct_id = $get_bstruct_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
  /* 
            //登録した情報をログに残す
            $result = Log_Save( $conn, "bstruct", "2", $bstruct_cd, $bstruct_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
*/
        }

		//業態マスタの値をログに書き込む
		//（データコード：業態CD  名称：業態名）
        $result = Log_Save($conn,'bstruct',$work_div,$bstruct_cd,$bstruct_name);
        //ログ登録時にエラーになった場合
        if($result === false){
            Db_Query($conn,"ROLLBACK;");
            exit;
        }

        Db_Query($conn, "COMMIT");

        $set_data["form_bstruct_cd"]       = "";                                 //業態CD
        $set_data["form_bstruct_name"]     = "";                                 //業態名
        $set_data["form_bstruct_note"]     = "";                                 //備考
        $set_data["update_flg"]            = "";

        $form->setConstants($set_data);

    }
}

/*****************************
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   bstruct_cd,";
$sql .= "   bstruct_id,";
$sql .= "   bstruct_name,";
$sql .= "   note,";
$sql .= "   accept_flg";
$sql .= " FROM";
$sql .= "   t_bstruct";
$sql .= "   ORDER BY t_bstruct.bstruct_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSVボタン押下処理
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "登　録"){

	$sql  = "SELECT";
	$sql .= "   bstruct_cd,";
	$sql .= "   bstruct_id,";
	$sql .= "   bstruct_name,";
	$sql .= "   note,";
	$sql .= "   accept_flg";
	$sql .= " FROM";
	$sql .= "   t_bstruct";
	$sql .= "   ORDER BY t_bstruct.bstruct_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = ($page_data[$i][4] == "1") ? "○" : "×";
    }

    $csv_file_name = "業態マスタ".date("Ymd").".csv";
    $csv_header = array(
        "業態コード",
        "業態名",
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
    'auth_r_msg'    => "$auth_r_msg",
    'message'       => "$message"
));

$smarty->assign("page_data",$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
