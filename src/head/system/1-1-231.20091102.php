<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/18) サービスコードの範囲チェック削除(suzuki-t)
 * 1.1.0 (2006/03/20) サービスコードの重複チェック修正(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/20)
*/

$page_title = "サービスマスタ";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
// 入力・変更権限無しメッセージ
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// ボタンDisabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// 削除ボタンDisabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//外部変数取得
/****************************/
$shop_id  = $_SESSION["client_id"];

/* GETしたIDの正当性チェック */
if ($_GET["serv_id"] != null && Get_Id_Check_Db($db_con, $_GET["serv_id"], "serv_id", "t_serv", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//初期表示
/****************************/
$def_data["form_tax_div"]       = 1;                        //課税区分
$def_data["form_accept"]        = "2";
$form->setDefaults($def_data);

/****************************/
//部品定義
/****************************/
//サービスコード
$form->addElement("text","form_serv_cd","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//サービス名
$form->addElement("text","form_serv_name","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//備考
$form->addElement("text","form_note","テキストフォーム","size=\"34\" maxLength=\"30\"".$g_form_option."\"");
//課税区分
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "外税","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "内税","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "非課税","3");
$form->addGroup( $tax_div, "form_tax_div","");
//承認ラジオボタン
$form_accept[] =& $form->createElement("radio", null, null, "承認済", "1");
$form_accept[] =& $form->createElement("radio", null, null, "未承認", "2");
$form->addGroup($form_accept, "form_accept", "");
//クリア
$form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//登録
$form->addElement("submit","entry_button","登　録","onClick=\"javascript:return Dialogue('登録します。','#')\" $disabled");
//CSV出力
$form->addElement("button","csv_button","CSV出力","onClick=\"javascript:Button_Submit('csv_button_flg','#','true')\"");

//更新リンク押下判定フラグ
$form->addElement("hidden", "update_flg");
//CSV出力ボタン押下判定フラグ
$form->addElement("hidden", "csv_button_flg");

/******************************/
//CSV出力ボタン押下処理
/*****************************/
if($_POST["csv_button_flg"]==true && $_POST["entry_button"] != "登　録"){
    /** CSV作成SQL **/
    $sql = "SELECT ";
    $sql .= "serv_cd,";                //サービスコード
    $sql .= "serv_name,";              //サービス名
	$sql .= "CASE tax_div ";           //課税区分
	$sql .= "    WHEN '1' THEN '外税'";
	$sql .= "    WHEN '2' THEN '内税'";
	$sql .= "    WHEN '3' THEN '非課税'";
    $sql .= "END,";
	$sql .= "note, ";                   //備考
    $sql .= "accept_flg ";
    $sql .= "FROM ";
    $sql .= "t_serv ";
    $sql .= "WHERE ";
    $sql .= "public_flg = true ";
    $sql .= "ORDER BY ";
    $sql .= "serv_cd;";

    $result = Db_Query($db_con,$sql);

    //CSVデータ取得
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //サービスコード
        $serv_data[$i][0] = $data_list[0];
        //サービス名
        $serv_data[$i][1] = $data_list[1];
        //課税区分
        $serv_data[$i][2] = $data_list[2];
		//備考
        $serv_data[$i][3] = $data_list[3];
		//承認
        $serv_data[$i][4] = ($data_list[4] == "1") ? "○" : "×";
        $i++;
    }

    //CSVファイル名
    $csv_file_name = "サービスマスタ".date("Ymd").".csv";
    //CSVヘッダ作成
    $csv_header = array(
        "サービスコード", 
        "サービス名",
		"課税区分",
        "備考",
        "承認"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($serv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;    
}

/****************************/
//変更処理（リンク）
/****************************/

//変更リンク押下判定
if($_GET["serv_id"] != ""){

    //変更するレンタルIDを取得
    $update_num = $_GET["serv_id"];

    /** サービスマスタ取得SQL作成 **/
    $sql = "SELECT ";
    $sql .= "serv_cd,";                //サービスコード
    $sql .= "serv_name,";              //サービス名
	$sql .= "tax_div,";                //課税区分
    $sql .= "note, ";                  //備考
    $sql .= "accept_flg ";
    $sql .= "FROM ";
    $sql .= "t_serv ";
    $sql .= "WHERE ";
    $sql .= "public_flg = 't' ";
    $sql .= "AND ";
    $sql .= "serv_id = ".$update_num.";";
    $result = Db_Query($db_con,$sql);
    //GETデータ判定
    Get_Id_Check($result);
    $data_list = pg_fetch_array($result,0);

    //フォームに値を復元
    $def_fdata["form_serv_cd"]                        =    $data_list[0];  
    $def_fdata["form_serv_name"]                      =    $data_list[1]; 
	$def_fdata["form_tax_div"]                        =    $data_list[2];  
    $def_fdata["form_note"]                           =    $data_list[3]; 
    $def_fdata["form_accept"]                         =    $data_list[4]; 
    $def_fdata["update_flg"]                          =    "true"; 
    
    $form->setDefaults($def_fdata);
}

/****************************/
//エラーチェック(AddRule)
/****************************/
//◇サービスコード
//・必須チェック
$form->addRule('form_serv_cd','サービスコード は半角数字のみです。','required');
//・文字種チェック
$form->addRule('form_serv_cd','サービスコード は半角数字のみです。', "regex", "/^[0-9]+$/");

//◇サービス名
//・必須チェック
$form->addRule('form_serv_name','サービス名 は1文字以上15文字以下です。','required');
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_serv_name", "サービス名 にスペースのみの登録はできません。", "no_sp_name");

/****************************/
//登録処理
/****************************/
if($_POST["entry_button"] == "登　録"){
    //入力フォーム値取得
    $serv_cd      = $_POST["form_serv_cd"];                //サービスコード
    $serv_name    = $_POST["form_serv_name"];              //サービス名
	$tax_div      = $_POST["form_tax_div"];                //課税区分
    $note         = $_POST["form_note"];                   //備考 
    $accept       = $_POST["form_accept"];                 //
    $update_flg   = $_POST["update_flg"];                  //登録・更新判定
    $update_num   = $_GET["serv_id"];                      //サービスID


    /****************************/
    //エラーチェック(PHP)
    /****************************/
    //◇サービスコード
    //・重複チェック
    //・コード体系
    if($serv_cd != null){
        //サービスコードに０を埋める
        $serv_cd = str_pad($serv_cd, 4, 0, STR_POS_LEFT);
        //入力したコードがマスタに存在するかチェック
        $sql  = "SELECT ";
        $sql .= "serv_cd ";                //サービスコード
        $sql .= "FROM ";
        $sql .= "t_serv ";
        $sql .= "WHERE ";
        $sql .= "serv_cd = '$serv_cd' ";
        $sql .= "AND ";
        $sql .= "shop_id = $shop_id";

        //変更の場合は、自分のデータ以外を参照する
        if($update_num != null && $update_flg == "true"){
            $sql .= " AND NOT ";
            $sql .= "serv_id = '$update_num'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_serv_cd","既に使用されている サービスコード です。");
        }
/*
        //コード体系
        if($serv_cd >= 5000 && $serv_cd < 9000){
            $form->setElementError("form_serv_cd","サービスコード に5000〜8999は利用できません。");
        }
*/
    }

    //エラーの際には、登録処理を行わない
    if($form->validate()){
        
        Db_Query($db_con, "BEGIN;");

        //更新か登録か判定
        if($update_flg == "true"){
            //作業区分は更新
            $work_div = '2';
            //変更完了メッセージ
            $comp_msg = "変更しました。";

            $sql  = "UPDATE ";
            $sql .= "t_serv ";
            $sql .= "SET ";
            $sql .= "serv_cd = '$serv_cd',";
            $sql .= "serv_name = '$serv_name',";
			$sql .= "tax_div = '$tax_div',";
            $sql .= "note = '$note', ";
            $sql .= "accept_flg = '$accept' ";
            $sql .= "WHERE ";
            $sql .= "serv_id = $update_num;";
        }else{
            //作業区分は登録
            $work_div = '1';
            //登録完了メッセージ
            $comp_msg = "登録しました。";

            $sql  = "INSERT INTO ";
            $sql .= "t_serv (";
			$sql .= "serv_id,";
			$sql .= "serv_cd,";
			$sql .= "serv_name,";
			$sql .= "tax_div,";
			$sql .= "note,";
			$sql .= "public_flg,";
			$sql .= "shop_id, ";
            $sql .= "accept_flg ";
            $sql .= ")VALUES(";
            $sql .= "(SELECT ";
            $sql .= "COALESCE(MAX(serv_id), 0)+1 ";
            $sql .= "FROM ";
            $sql .= "t_serv),";
            $sql .= "'$serv_cd',";
            $sql .= "'$serv_name',";
			$sql .= "'$tax_div',";
            $sql .= "'$note',";
            $sql .= "true,";
            $sql .= "$shop_id,";
            $sql .= "'$accept');";
        }
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        //サービスマスタの値をログに書き込む
        $result = Log_Save($db_con,'serv',$work_div,$serv_cd,$serv_name);
        //ログ登録時にエラーになった場合
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");

        //フォームの値を初期化
        $def_fdata["form_serv_cd"]                        =    "";
        $def_fdata["form_serv_name"]                      =    "";
		$def_fdata["form_tax_div"]                        =    "1";
        $def_fdata["form_note"]                           =    "";
        $def_fdata["form_accept"]                         =    "2";
        $def_fdata["update_flg"]                          =    "";

        $form->setConstants($def_fdata);
    }
}

/******************************/
//ヘッダーに表示させる全件数
/*****************************/
/** サービスマスタ取得SQL作成 **/
$sql = "SELECT ";
$sql .= "serv_id,";                //サービスID
$sql .= "serv_cd,";                //サービスコード
$sql .= "serv_name,";              //サービス名
$sql .= "CASE tax_div ";           //課税区分
$sql .= "    WHEN '1' THEN '外税'";
$sql .= "    WHEN '2' THEN '内税'";
$sql .= "    WHEN '3' THEN '非課税'";
$sql .= "END,";
$sql .= "note, ";                   //備考
$sql .= "accept_flg ";
$sql .= "FROM ";
$sql .= "t_serv ";
$sql .= "WHERE ";
$sql .= "public_flg = true ";
$sql .= "ORDER BY ";
$sql .= "serv_cd;";

$result = Db_Query($db_con,$sql);
//全件数取得(ヘッダー)
$total_count = pg_num_rows($result);

//行データ部品を作成
$row = Get_Data($result);

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
    'comp_msg'      => "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));
$smarty->assign('row',$row);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
