<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/20) 地区コードの重複チェック修正(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/20)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0080    suzuki      登録・変更のログを残すように修正
 *  2006-12-11      ban_0140    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *  2015/05/01                  amano  Dialogue関数でボタン名が送られない IE11 バグ対応
 *  
 *
*/

$page_title = "地区マスタ";

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
//外部変数取得
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/* GETしたIDの正当性チェック */
$where = ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["area_id"] != null && Get_Id_Check_Db($conn, $_GET["area_id"], "area_id", "t_area", "num", $where) != true){
    header("Location: ../top.php");
}

/*****************************/
//オブジェクト作成
/*****************************/
//地区コード
$form->addElement("text","form_area_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style;text-align: left;\"".$g_form_option."\"");
//地区名
$form->addElement("text","form_area_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//ボタン
$form->addElement("submit","form_entry_button","登　録","onClick=\"return Dialogue('登録します。', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");

//備考
$form->addElement("text","form_area_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden", "update_flg");

/****************************/
//変更処理（リンク）
/****************************/
if($_GET["area_id"] != ""){

	//変更する地区IDを取得
    $update_num = $_GET["area_id"];

    $sql  = "SELECT";
    $sql .= "   area_cd,";
    $sql .= "   area_name,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_area";
    $sql .= " WHERE";
    $sql .= "   area_id = $update_num";
    $sql .= "   AND";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
	Get_Id_Check($result);

    $def_data["form_area_cd"]       = pg_fetch_result($result,0,0);
    $def_data["form_area_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_area_note"]     = pg_fetch_result($result,0,2);
	$def_data["update_flg"]			=	"true";
    $form->setDefaults($def_data);
}

/****************************/
//ルール作成
/****************************/
//地区コード
$form->addRule("form_area_cd", "地区コードは半角数字のみ4桁です。","required");
$form->addRule("form_area_cd", "地区コードは半角数字のみ4桁です。","regex", "/^[0-9]+$/");

//地区名
$form->addRule("form_area_name", "地区名は1文字以上10文字以下です。","required");
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_area_name", "地区名 にスペースのみの登録はできません。", "no_sp_name");

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST情報取得
    /****************************/
    $area_cd        = $_POST["form_area_cd"];                                   //地区CD
    $area_name      = $_POST["form_area_name"];                                 //地区名
    $area_note      = $_POST["form_area_note"];                                 //備考  
	$update_flg     = $_POST["update_flg"];										//登録・更新判定
	$update_num     = $_GET["area_id"];                                         //地区ID

    /****************************/
    //エラーチェック(PHP)
    /****************************/
    //◇地区CD
    //・重複チェック
    if($area_cd != null){
	    $area_cd = str_pad($area_cd, 4, 0, STR_POS_LEFT);

	    $sql  = "SELECT";
	    $sql .= "   area_cd";
	    $sql .= " FROM";
	    $sql .= "   t_area";
	    $sql .= " WHERE";
        $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
	    $sql .= "   AND";
	    $sql .= "   area_cd = '$area_cd' ";

		//変更の場合は、自分のデータ以外を参照する
        if($update_num != null && $update_flg == "true"){
            $sql .= " AND NOT ";
            $sql .= "area_id = '$update_num'";
        }
        $sql .= ";";
        $result = Db_Query($conn, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_area_cd","既に使用されている 地区コード です。");
        }
	}

    /***************************/
    //検証  
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //登録処理
        /*****************************/
		//更新か登録か判定
		if($update_flg != "true"){
			//作業区分は登録
			$work_div = '1';
			//登録完了メッセージ
			$comp_msg = "登録しました。";

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
            $insert_sql .= "     $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*******************************/
        //変更処理
        /*******************************/
        }else{
			//作業区分は更新
			$work_div = '2';
			//変更完了メッセージ
			$comp_msg = "変更しました。";
            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_area";
            $insert_sql .= " SET";
            $insert_sql .= "    area_cd = '$area_cd',";
            $insert_sql .= "    area_name = '$area_name',";
            $insert_sql .= "    note = '$area_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    area_id = $update_num";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }

		//登録/更新した情報をログに残す
        $result = Log_Save( $conn, "area", $work_div, $area_cd, $area_name);
        //失敗した場合はロールバック
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        Db_Query($conn, "COMMIT");
        $def_fdata["form_area_cd"]			=	"";
        $def_fdata["form_area_name"]		=	"";
        $def_fdata["form_area_note"]		=	"";
		$def_fdata["update_flg"]			=	"";
		$form->setConstants($def_fdata);
    }
}

/*****************************
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   area_cd,";
$sql .= "   area_id,";
$sql .= "   area_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_area";
$sql .= " WHERE";
$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
$sql .= "   ORDER BY t_area.area_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSVボタン押下処理
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
	$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
	$sql .= "   ORDER BY t_area.area_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV作成
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
$page_menu = Create_Menu_f('system','1');

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
	'comp_msg'   	=> "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign("page_data",$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
