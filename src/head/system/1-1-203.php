<?php
/******************************************************/
//変更履歴  
//  (2006/03/16)
//  ・shop_idをclient_idに変更
//  ・shop_aidを削除
//　・一覧ｓｑｌ変更
/******************************************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0135    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *  2007-02-16                  watanabe-k  own_shop_id削除
 *   2016/01/20                amano  Dialogue, Button_Submit 関数でボタン名が送られない IE11 バグ対応*  
 *  
 *
*/

$page_title = "倉庫マスタ";

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
$client_id   = $_SESSION["client_id"];

$get_ware_id = $_GET["ware_id"];

/* GETしたIDの正当性チェック */
if ($_GET["ware_id"] != null && Get_Id_Check_Db($conn, $_GET["ware_id"], "ware_id", "t_ware", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//初期値を抽出
/****************************/
$def_data["form_count_flg"]     = 't';
$form->setDefaults($def_data);

if($get_ware_id != null){
    $sql  = "SELECT";
    $sql .= "   ware_cd,";
    $sql .= "   ware_name,";
    $sql .= "   count_flg,";
    $sql .= "   nondisp_flg,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_ware";
    $sql .= " WHERE";
    $sql .= "   ware_id = $get_ware_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    $def_data["form_ware_cd"]       = pg_fetch_result($result,0,0);
    $def_ware_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_ware_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_count_flg"]     = pg_fetch_result($result,0,2);
    $def_data["form_nondisp_flg"]     = (pg_fetch_result($result,0,3) == 't')? 1 : 0;
    $def_data["form_ware_note"]     = pg_fetch_result($result,0,4);
    $def_data["update_flg"]         = true;

    $form->setDefaults($def_data);
}

/*****************************/
//オブジェクト作成
/*****************************/
//テキスト
$form->addElement("text","form_ware_cd","","size=\"3\" maxLength=\"3\" style=\"text-align: left;$g_form_style\"".$g_form_option."\"");
$form->addElement("text","form_ware_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//備考
$form->addElement("text","form_ware_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//発注点カウント
//ラヂオボタン
$form_count_flg[] =& $form->createElement( "radio",NULL,NULL, "する","t");
$form_count_flg[] =& $form->createElement( "radio",NULL,NULL, "しない","f");
$form->addGroup($form_count_flg, "form_count_flg", "");

//非表示
$form->addElement('checkbox', 'form_nondisp_flg', '', '');

//ボタン
$form->addElement("submit","form_entry_button","登　録","onClick=\"return Dialogue('登録します。','#', this)\" $disabled");
$form->addElement("button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");

/****************************/
//ルール作成
/****************************/
//倉庫コード
$form->addRule("form_ware_cd", "倉庫コードは半角数字のみ3桁です。","required");
$form->addRule("form_ware_cd", "倉庫コードは半角数字のみ3桁です。","regex", "/^[0-9]+$/");

//倉庫名
$form->addRule("form_ware_name", "倉庫名は1文字以上10文字以下です。","required");
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_ware_name", "倉庫名に スペースのみの登録はできません。", "no_sp_name");

/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST情報取得
    /****************************/
    $ware_cd        = $_POST["form_ware_cd"];                                   //倉庫CD
    $ware_name      = $_POST["form_ware_name"];                                 //倉庫名
    $count_flg      = $_POST["form_count_flg"];                                 //発注点カウントフラグ
    $nondisp_flg    = ($_POST["form_nondisp_flg"] == '1')? 't' : 'f';           //非表示
    $ware_note      = $_POST["form_ware_note"];                                 //備考
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //倉庫コード整形
    /***************************/
    $ware_cd = str_pad($ware_cd, 3, 0, STR_PAD_LEFT);

    //□倉庫コード
    //重複チェック
    $sql  = "SELECT";
    $sql .= "   ware_cd";
    $sql .= " FROM";
    $sql .= "   t_ware";
    $sql .= " WHERE";
    $sql .= "   shop_id = $client_id";
    $sql .= "   AND";
    $sql .= "   ware_cd = '$ware_cd'";
    $sql .= ";";
    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_ware_cd != $ware_cd))){
        $form->setElementError("form_ware_cd","既に使用されている 倉庫コード です。");
    }

    //非表示
    //在庫数チェック
    if($nondisp_flg == 't'){
       $sql  = "SELECT ";
       $sql .= "DISTINCT ";
       $sql .= "   stock_num";
       $sql .= " FROM";
       $sql .= "   t_stock";
       $sql .= " WHERE";
       $sql .= "   shop_id = $client_id";
       $sql .= " AND";
       $sql .= "   ware_id = ";
       $sql .= "   (SELECT ";
       $sql .= "       ware_id ";
       $sql .= "   FROM ";
       $sql .= "       t_ware ";
       $sql .= "   WHERE";
       $sql .= "       shop_id = $client_id";
       $sql .= "   AND";
       $sql .= "       ware_cd = '$ware_cd'";
       $sql .= "   )";
       $sql .= ";";
       $result = Db_Query($conn, $sql);
       $stock_flg = false;
       while($stock_num = pg_fetch_array($result)){
           if($stock_num[0] != 0){
               $stock_flg = true;
           }
       }
       if($stock_flg == true){
           $form->setElementError("form_ware_cd","在庫がある倉庫は非表示にできません。");
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
        if($update_flg != true){

            $insert_sql  = "INSERT INTO t_ware(";
            $insert_sql .= "    ware_id,";
            $insert_sql .= "    ware_cd,";
            $insert_sql .= "    ware_name,";
//            $insert_sql .= "    own_shop_id,";
            $insert_sql .= "    count_flg,";
            $insert_sql .= "    note,";
            $insert_sql .= "    shop_id,";
            $insert_sql .= "    nondisp_flg";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(ware_id), 0)+1 FROM t_ware),";
            $insert_sql .= "    '$ware_cd',";
            $insert_sql .= "    '$ware_name',";
//            $insert_sql .= "    $client_id,";
            $insert_sql .= "    '$count_flg',";
            $insert_sql .= "    '$ware_note',";
            $insert_sql .= "    $client_id,";
            $insert_sql .= "    '$nondisp_flg'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
            //登録した情報をログに残す
            $result = Log_Save( $conn, "ware", "1", $ware_cd, $ware_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            $message = "登録しました。";
        /*******************************/
        //変更処理
        /*******************************/
        }elseif($update_flg == true){
            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_ware";
            $insert_sql .= " SET";
            $insert_sql .= "    ware_cd = '$ware_cd',";
            $insert_sql .= "    ware_name = '$ware_name',";
            $insert_sql .= "    count_flg = '$count_flg',";
            $insert_sql .= "    nondisp_flg = '$nondisp_flg',";
            $insert_sql .= "    note = '$ware_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    ware_id = $get_ware_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した情報をログに残す
            $result = Log_Save( $conn, "ware", "2", $ware_cd, $ware_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
            $message = "変更しました。";
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_ware_cd"]      = "";               //倉庫CD
        $set_data["form_ware_name"]    = "";               //倉庫名
        $set_data["form_count_flg"]    = "t";              //発注点カウントフラグ
        $set_data["form_nondisp_flg"]  = "";               //非表示
        $set_data["form_ware_note"]    = "";               //備考  
        $set_data["update_flg"]        = "";

        $form->setConstants($set_data);
    }
}

/*****************************
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   t_ware.ware_cd,";
$sql .= "   t_ware.ware_id,";
$sql .= "   t_ware.ware_name,";
$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
$sql .= "   CASE t_ware.count_flg";
$sql .= "       WHEN true  THEN '○'";
$sql .= "       WHEN false THEN ''";
$sql .= "   END,";
$sql .= "   CASE t_ware.nondisp_flg";
$sql .= "       WHEN true  THEN '○'";
$sql .= "       WHEN false THEN ''";
$sql .= "   END,";
$sql .= "   t_ware.note";
$sql .= " FROM";
$sql .= "   t_client,";
$sql .= "   t_ware";
$sql .= " WHERE";
//$sql .= "   t_ware.own_shop_id = t_client.client_id";
$sql .= "   t_ware.shop_id = t_client.client_id";
$sql .= "   AND";
$sql .= "   t_client.client_div != '3'";
$sql .= "   AND";
$sql .= "   t_ware.ware_id <> 0";
$sql .= "   ORDER BY t_ware.ware_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/****************************/
//CSVボタン押下処理
/****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "登　録"){

	$sql  = "SELECT";
	$sql .= "   t_ware.ware_cd,";
	$sql .= "   t_ware.ware_id,";
	$sql .= "   t_ware.ware_name,";
	$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,";
	$sql .= "   CASE t_ware.count_flg";
	$sql .= "       WHEN true  THEN '○'";
	$sql .= "       WHEN false THEN ''";
	$sql .= "   END,";
	$sql .= "   CASE t_ware.nondisp_flg";
	$sql .= "       WHEN true  THEN '○'";
	$sql .= "       WHEN false THEN ''";
	$sql .= "   END,";
	$sql .= "   t_ware.note";
	$sql .= " FROM";
	$sql .= "   t_client,";
	$sql .= "   t_ware";
	$sql .= " WHERE";
//	$sql .= "   t_ware.own_shop_id = t_client.client_id";
	$sql .= "   t_ware.shop_id = t_client.client_id";
	$sql .= "   AND";
	$sql .= "   t_client.client_div != '3'";
	$sql .= "   AND";
	$sql .= "   t_ware.ware_id <> 0";
	$sql .= "   ORDER BY t_ware.ware_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = $page_data[$i][5];
        $csv_page_data[$i][4] = $page_data[$i][6];
        $csv_page_data[$i][5] = $page_data[$i][7];
    }

    $csv_file_name = "倉庫マスタ".date("Ymd").".csv";

    $csv_header = array(
        "倉庫コード",
        "倉庫名",
        "ショップコード",
        "非表示",
        "備考"
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}




/****************************e
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

$smarty->assign('page_data', $page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
