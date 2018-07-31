<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0128    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *  2007/04/18                  kajioka-h   「Ｍ区分」→「大分類」に表現変更
 *   2016/01/20                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応*    
 *  
 *
*/

$page_title = "業種マスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB接続
$conn = Db_Connect();

// 権限チェック
$auth       = Auth_Check($conn);
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null; 
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null; 

/*****************************/
//外部変数取得
/*****************************/
$get_lbtype_id = $_GET["lbtype_id"];
/* GETしたIDの正当性チェック */
if ($_GET["lbtype_id"] != null && Get_Id_Check_Db($conn, $_GET["lbtype_id"], "lbtype_id", "t_lbtype", "num") != true){
    header("Location: ../top.php");
    exit;
}

/*****************************/
//初期値を抽出
/*****************************/
if($get_lbtype_id != null){
    $sql  = "SELECT";
    $sql .= "   t_lbtype.lbtype_cd,";
    $sql .= "   t_lbtype.lbtype_name,";
    $sql .= "   t_lbtype.note,";
    $sql .= "   t_lbtype.accept_flg";
    $sql .= " FROM";
    $sql .= "   t_lbtype";
    $sql .= " WHERE";
    $sql .= "   t_lbtype.lbtype_id = $get_lbtype_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $get_data = pg_fetch_array($result);

    $def_data["form_btype_cd"]   = $get_data[0];
    $def_data["form_btype_name"] = $get_data[1];
    $def_data["form_btype_note"] = $get_data[2];
    $def_data["form_accept"]     = $get_data[3];
    $def_data["update_flg"]         = true;

    $def_btype_cd = $get_data[0];

}else{
    $def_data["form_accept"] = '2'; //承認
}

$form->setDefaults($def_data);

/*****************************/
//オブジェクト作成
/*****************************/
//業種コード
$form->addElement("text", "form_btype_cd", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//業種名
$form->addElement("text", "form_btype_name", "", "size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//入力・変更
$form->addElement("button", "small_button", "小分類", "onClick=\"javascript:Referer('1-1-232.php')\"");
//照会
$form->addElement("button", "big_button", "大分類", $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//ボタン
//$form->addElement("submit", "form_entry_button", "登　録", "onClick=\"return Dialogue('登録します。', '#')\" $disabled");
$form->addElement("submit", "form_entry_button", "登　録", "onClick=\"return Dialogue('登録します。', '$_SERVER[PHP_SELF]?lbtype_id=$get_lbtype_id&post=true', this)\" $disabled");
$form->addElement("button", "form_clear_button", "クリア", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button", "form_csv_button", "CSV出力", "onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//備考
$form->addElement("text", "form_btype_note", "", "size=\"70\" maxLength=\"40\" ".$g_form_option."\"");

//hidden
$form->addElement("hidden", "csv_button_flg");
$form->addElement("hidden", "update_flg");

//承認チェック
$form_accept[] =& $form->createElement("radio", null, null, "承認済", "1");
$form_accept[] =& $form->createElement("radio", null, null, "未承認", "2");
$form->addGroup($form_accept, "form_accept", "");

/****************************/
//ルール作成
/****************************/
//大分類業種コード
$form->addRule("form_btype_cd", "大分類業種コードは半角数字のみ3桁です。", "required");
$form->addRule("form_btype_cd", "大分類業種コードは半角数字のみ3桁です。", "regex", "/^[0-9]+$/");

//業種名
$form->addRule("form_btype_name", "大分類業種名は1文字以上10文字以下です。", "required");
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_btype_name", "大分類業種名 にスペースのみの登録はできません。", "no_sp_name");

/***************************/
//登録ボタン押下処理
/***************************/
if($_POST["form_entry_button"] == "登　録"){
    
    /*****************************/
    //POST情報取得
    /*****************************/
    $btype_cd       = $_POST["form_btype_cd"];
    $btype_name     = $_POST["form_btype_name"];
    $btype_note     = $_POST["form_btype_note"];
    $update_flg     = $_POST["update_flg"];
    $accept         = $_POST["form_accept"];

    /****************************/
    //大分類業種コード整形
    /****************************/
    $btype_cd = str_pad($btype_cd, 4, 0, STR_POS_LEFT);

    //使用済みチェック
    $sql  = "SELECT lbtype_cd FROM t_lbtype WHERE lbtype_cd = '$btype_cd';";
    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //使用済みエラー
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_btype_cd != $btype_cd))){
        $form->setElementError("form_btype_cd", "既に使用されている 大分類業種コード です。");
    }


    /****************************/
    //値検証
    /****************************/        
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /******************************/
        //登録処理
        /******************************/
        if($update_flg != true){

            $message = "登録しました。";

            $insert_sql  = "INSERT INTO t_lbtype(";
            $insert_sql .= "    lbtype_id,";
            $insert_sql .= "    lbtype_cd,";
            $insert_sql .= "    lbtype_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    accept_flg";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(lbtype_id),0) +1 FROM t_lbtype),";
            $insert_sql .= "    '$btype_cd',";
            $insert_sql .= "    '$btype_name',";
            $insert_sql .= "    '$btype_note',";
            $insert_sql .= "    '$accept'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した情報をログに残す
            $result = Log_Save($conn, "lbtype", "1", $btype_cd, $btype_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*********************************/
        //変更処理
        /*********************************/
        }elseif($update_flg == true){
            
            $message = "変更しました。";

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_lbtype";
            $insert_sql .= " SET";
            $insert_sql .= "    lbtype_cd = '$btype_cd',";
            $insert_sql .= "    lbtype_name = '$btype_name',";
            $insert_sql .= "    note = '$btype_note',";
            $insert_sql .= "    accept_flg = '$accept'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    lbtype_id = $get_lbtype_id";
            $insert_sql .= ";";

            $reuslt = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
            }

            //登録情報をログに残す
            $result = Log_Save($conn, "lbtype", "2", $btype_cd, $btype_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $data["form_btype_cd"]   = "";
        $data["form_btype_name"] = "";
        $data["form_btype_note"] = "";
        $data["update_flg"]      = "";

        $form->setConstants($data);
    }
}
/*****************************/
//CSVボタン押下処理
/*****************************/
elseif($_POST["csv_button_flg"] == true){
    $sql  = "SELECT";
    $sql .= "   t_lbtype.lbtype_id,";
    $sql .= "   t_lbtype.lbtype_cd,";
    $sql .= "   t_lbtype.lbtype_name,";
    $sql .= "   t_lbtype.note,";
    $sql .= "   t_lbtype.accept_flg,";
    $sql .= "   t_sbtype.sbtype_cd,";
    $sql .= "   t_sbtype.sbtype_name,";
    $sql .= "   t_sbtype.note,";
    $sql .= "   t_sbtype.accept_flg";
    $sql .= " FROM";
    $sql .= "   t_lbtype";
    $sql .= "       LEFT JOIN";
    $sql .= "   t_sbtype";
    $sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
    $sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $total_count = pg_num_rows($result);
    $page_data = Get_Data($result,2);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][1];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = ($page_data[$i][4] == "1") ? "○" : "×";
        $csv_page_data[$i][4] = $page_data[$i][5];
        $csv_page_data[$i][5] = $page_data[$i][6];
        $csv_page_data[$i][6] = $page_data[$i][7];
        $csv_page_data[$i][7] = ($page_data[$i][8] == "1") ? "○" : "×";
    }

    $csv_file_name = "業種マスタ".date("Ymd").".csv";
    $csv_header = array(
        "大分類業種コード",
        "大分類業種名",
        "大分類備考",
        "大分類承認",
        "小分類業種コード",
        "小分類業種名",
        "小分類備考",
        "小分類承認",
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/*****************************/
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_id,";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_lbtype.note,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name,";
$sql .= "   t_sbtype.note,";
$sql .= "   t_lbtype.accept_flg,";
$sql .= "   t_sbtype.accept_flg";
$sql .= " FROM";
$sql .= "   t_lbtype";
$sql .= "       LEFT JOIN";
$sql .= "   t_sbtype";
$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

for($i = 0; $i < $total_count; $i++){
    for($j = 0; $j < $total_count; $j++){
        if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
            $page_data[$j][0] = null;
            $page_data[$j][1] = null;
            $page_data[$j][2] = null;
            $page_data[$j][3] = null; 
            $page_data[$j][7] = null; 
        }
    }
}
for($i = 0; $i < $total_count; $i++){
    if($page_data[$i][0] == null){
        $tr[$i] = $tr[$i-1];
    }else{
        $tr[$i] = ($tr[$i-1] == "Result1") ? "Result2" : "Result1";
    }
}

$sql         = "SELECT COUNT(lbtype_id) FROM t_lbtype ;";
$result      = Db_Query($conn, $sql);
$total_count = pg_fetch_result($result, 0, 0);

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
$page_title .= "　".$form->_elements[$form->_elementIndex[big_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[small_button]]->toHtml();
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
));
$smarty->assign("tr", $tr);
$smarty->assign("page_data", $page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
