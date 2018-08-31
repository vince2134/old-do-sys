<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0136    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *   2016/01/20                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応     
 *  
 *
*/

$page_title = "地区マスタ";

//environment setting file 環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成 Create HTML_QuickForm 
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB接続 connect to database
$conn = Db_Connect();

// 権限チェック check authorization
$auth       = Auth_Check($conn);
// 入力・変更権限無しメッセージ no input/revision authorization message
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled button disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//外部変数取得 Acquire outside variable
/****************************/
$shop_id    = $_SESSION["client_id"];

$get_area_id = $_GET["area_id"];

/* GETしたIDの正当性チェック Check the validity of the ID that was GET */ 
if ($_GET["area_id"] != null && Get_Id_Check_Db($conn, $_GET["area_id"], "area_id", "t_area", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//初期値を抽出 Extract the initial value
/****************************/
if($get_area_id != null){
    $sql  = "SELECT";
    $sql .= "   area_cd,";
    $sql .= "   area_name,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_area";
    $sql .= " WHERE";
    $sql .= "   area_id = $get_area_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_area_cd"]       = pg_fetch_result($result,0,0);
    $def_area_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_area_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_area_note"]     = pg_fetch_result($result,0,2);
    $def_data["update_flg"]         = true;
    $form->setDefaults($def_data);
}

/*****************************/
//オブジェクト作成 create object
/*****************************/
//地区コード district code
$form->addElement("text","form_area_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//地区名 district name
$form->addElement("text","form_area_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");
//ボタン button
$form->addElement("submit","form_entry_button","登　録","onClick=\"return Dialogue('登録します。', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//備考 remarks
$form->addElement("text","form_area_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden 
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");
/****************************/
//ルール作成 crete rules
/****************************/
//地区コード district code
$form->addRule("form_area_cd", "地区コードは半角数字のみ4桁です。","required");
$form->addRule("form_area_cd", "地区コードは半角数字のみ4桁です。", "regex", "/^[0-9]+$/");

//地区名 district name
$form->addRule("form_area_name", "地区名は1文字以上10文字以下です。","required");
// 全角/半角スペースのみチェック only check half-width/full-width space
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_area_name", "地区名 にスペースのみの登録はできません。", "no_sp_name");

/****************************/
//登録ボタン押下処理 process when register button is pressed 
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST情報取得 acquire POST info
    /****************************/
    $area_cd        = $_POST["form_area_cd"];                                   //地区CD districtCD
    $area_name      = $_POST["form_area_name"];                                 //地区名 district name
    $area_note      = $_POST["form_area_note"];                                 //備考 remarks
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //地区コード整形 arrange district code
    /***************************/
    $area_cd = str_pad($area_cd, 4, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   area_cd";
    $sql .= " FROM";
    $sql .= "   t_area";
    $sql .= " WHERE";
    $sql .= "   shop_id = $shop_id";
    $sql .= "   AND";
    $sql .= "   area_cd = '$area_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //使用済みエラー "already used" error
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_area_cd != $area_cd))){
        $form->setElementError("form_area_cd","既に使用されている 地区コード です。");
    }

    /***************************/
    //検証  verify
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //登録処理 registration process
        /*****************************/
        if($update_flg != true){

            $message = "登録しました。";

            $insert_sql  = "INSERT INTO t_area(";
            $insert_sql .= "    area_id,";
            $insert_sql .= "    area_cd,";
            $insert_sql .= "    area_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    shop_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(area_id), 0)+1 FROM t_area),";
            $insert_sql .= "    '$area_cd',";
            $insert_sql .= "    '$area_name',";
            $insert_sql .= "    '$area_note',";
            $insert_sql .= "    $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック rollback when failed
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した情報をログに残す leave the register info in log
            $result = Log_Save( $conn, "area", "1", $area_cd, $area_name);
            //失敗した場合はロールバック rollback when failed 
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*******************************/
        //変更処理 revision process
        /*******************************/
        }elseif($update_flg == true){
            $message = "変更しました。";

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_area";
            $insert_sql .= " SET";
            $insert_sql .= "    area_cd = '$area_cd',";
            $insert_sql .= "    area_name = '$area_name',";
            $insert_sql .= "    note = '$area_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    area_id = $get_area_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
   
            //登録した情報をログに残す leave the register info in log
            $result = Log_Save( $conn, "area", "2", $area_cd, $area_name);
            //失敗した場合はロールバック rollback when failed 
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_area_cd"]       = "";                                   //地区CD districtCD
        $set_data["form_area_name"]     = "";                                 //地区名 distric name
        $set_data["form_area_note"]     = "";                                 //備考 remarks 
        $set_data["update_flg"]         = "";

        $form->setConstants($set_data);

    }
}

/*****************************
//一覧作成 create list
/*****************************/
$sql  = "SELECT";
$sql .= "   area_cd,";
$sql .= "   area_id,";
$sql .= "   area_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_area";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= "   ORDER BY t_area.area_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSVボタン押下処理 process when CSV button is pressed 
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "登　録"){

	$sql  = "SELECT";
	$sql .= "   area_cd,";
	$sql .= "   area_id,";
	$sql .= "   area_name,";
	$sql .= "   note";
	$sql .= " FROM";
	$sql .= "   t_area";
	$sql .= " WHERE";
	$sql .= "   shop_id = $shop_id";
	$sql .= "   ORDER BY t_area.area_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV作成 create csv
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
    }

    $csv_file_name = "地区マスタ".date("Ymd").".csv";
    $csv_header = array(
        "地区コード",
        "地区名",
        "備考"
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/****************************/
//HTMLヘッダ HTML Header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//画面ヘッダー作成 create display header
/****************************/
$page_title .= "(全".$total_count."件)";
$page_header = Create_Header($page_title);


// Render関連の設定 render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign form related variables
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign other variables
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

//テンプレートへ値を渡す pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
