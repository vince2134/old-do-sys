<?php
/*
 * 変更履歴
 * 1.0.0 (2006/03/21) 更新処理の変更(suzuki-t)
 * 1.1.0 (2006/04/12) 住所３の追加(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/21)
*/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0138    suzuki      CSV出力時にはサニタイジングを行わないように修正
 *  2007-05-11                  kaku-m      CSVの項目を修正
 *   2016/01/20                amano  Dialogue, Button_Submit, Button_Submit_1 関数でボタン名が送られない IE11 バグ対応   
 *
*/

$page_title = "運送業者マスタ";

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

if($_GET["trans_id"] != null){
    $get_trans_id = $_GET["trans_id"];
    $get_flg = true; 
}else{
    $get_flg = false;
}

/* GETしたIDの正当性チェック */
if ($_GET["trans_id"] != null && Get_Id_Check_Db($conn, $_GET["trans_id"], "trans_id", "t_trans", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/*****************************/
//オブジェクト作成
/*****************************/
//運送業者コード
$form->addElement(
		"text","form_trans_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
		".$g_form_option."\""
		);

//運送業者名
$form->addElement("text","form_trans_name","","size=\"34\" maxLength=\"25\" $g_form_option");

//略称
$form->addElement("text","form_trans_cname","テキストフォーム","size=\"22\" maxLength=\"10\" $g_form_option");

//郵便番号
$form_post[] =& $form->createElement(
        "text","no1","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"  
        onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        $g_form_option"
        );
$form->addGroup($form_post, "form_post", "form_post");

//住所1
$form->addElement(
        "text","form_address1","","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//住所2
$form->addElement(
        "text","form_address2","","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//住所3
$form->addElement(
        "text","form_address3","","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//TEL
$form->addElement(
        "text","form_tel","","size=\"17\" maxLength=\"13\" style=\"$g_form_style\" 
        $g_form_option"
        );

//FAX
$form->addElement(
        "text","form_fax","","size=\"17\" maxLength=\"13\" style=\"$g_form_style\" 
        $g_form_option"
        );
//グリーン指定業者
$form->addElement(
        "checkbox","form_green_trans");

//備考
$form->addElement(
        "text","form_trans_note","",
        "size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//button
// 入力権限のあるスタッフのみ出力
//自動入力
$form->addElement(
    "button","form_auto_input_button","自動入力",
    "onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""
);

//登録ボタン
$form->addElement(
    "submit","form_entry_button","登　録",
    "onClick=\"javascript:return Dialogue('登録します。','#', this)\" $disabled"
);

//クリア
$form->addElement(
    "button","form_clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//CSVボタン
$form->addElement(
        "button","form_csv_button","CSV出力",
        "onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\""
        );
//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","input_button_flg");
$form->addElement("hidden", "update_flg");

/****************************/
//初期値を抽出
/****************************/
if($get_flg == true){
    $sql  = "SELECT";
    $sql .= "   trans_cd,";
    $sql .= "   trans_name,";
    $sql .= "   trans_cname,";
    $sql .= "   post_no1,";
    $sql .= "   post_no2,";
    $sql .= "   address1,";
    $sql .= "   address2,";
    $sql .= "   address3,";
    $sql .= "   tel,";
    $sql .= "   fax,";
    $sql .= "   green_trans,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_trans";
    $sql .= " WHERE";
    $sql .= "   trans_id = $get_trans_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";"; 

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $total_cout = pg_num_rows($result);


    $def_data["form_trans_cd"]      = pg_fetch_result($result,0,0);
    $def_trans_cd                   = pg_fetch_result($result,0,0);
    $def_data["form_trans_name"]    = pg_fetch_result($result,0,1);
    $def_data["form_trans_cname"]   = pg_fetch_result($result,0,2);
    $def_data["form_post"]["no1"]   = pg_fetch_result($result,0,3);
    $def_data["form_post"]["no2"]   = pg_fetch_result($result,0,4);
    $def_data["form_address1"]      = pg_fetch_result($result,0,5);
    $def_data["form_address2"]      = pg_fetch_result($result,0,6);
    $def_data["form_address3"]      = pg_fetch_result($result,0,7);
    $def_data["form_tel"]           = pg_fetch_result($result,0,8);
    $def_data["form_fax"]           = pg_fetch_result($result,0,9);
    $def_data["form_green_trans"]   = (pg_fetch_result($result,0,10) == 't')? 1 : 0;
    $def_data["form_trans_note"]    = pg_fetch_result($result,0,11);
	$def_data["update_flg"]			=	"true";
    $form->setDefaults($def_data);
}


/****************************/
//ルール作成
/****************************/
//運送業者コード
$form->addRule("form_trans_cd", "運送業者コードは半角数字のみ4桁です。","required");
$form->addRule("form_trans_cd", "運送業者コードは半角数字のみ4桁です。", "regex", "/^[0-9]+$/");

//運送業者名
$form->addRule("form_trans_name", "運送業者名は1文字以上25文字以下です。","required");
// 全角/半角スペースのみチェック
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_trans_name", "運送業社名 にスペースのみの登録はできません。", "no_sp_name");

//略称
$form->addRule("form_trans_cname", "略称は1文字以上10文字以下です。","required");
// 全角/半角スペースのみチェック
$form->addRule("form_trans_cname", "略称 にスペースのみの登録はできません。", "no_sp_name");

//郵便番号
$form->addGroupRule("form_post", array(
    'no1' => array(
            array("郵便番号は7桁です。", 'required')
        ),      
    'no2' => array(
            array("郵便番号は7桁です。",'required')
        ),      
));

//住所１
$form->addRule("form_address1","住所１は1文字以上15文字以下です。","required");

//TEL
$form->addRule("form_tel", "TELは半角数字と「-」のみ13桁です。", "regex", "/^[0-9-]+$/");

//FAX
$form->addRule("form_fax", "FAXは半角数字と「-」のみ13桁です。", "regex", "/^[0-9-]+$/");


/****************************/
//登録ボタン押下処理
/****************************/
if($_POST["form_entry_button"] == "登　録"){

    /****************************/
    //POST情報取得
    /****************************/
    $trans_cd        = $_POST["form_trans_cd"];                                 //運送業者CD
    $trans_name      = $_POST["form_trans_name"];                               //運送業者名
    $trans_cname     = $_POST["form_trans_cname"];                              //略称
    $post_no1        = $_POST["form_post"]["no1"];                              //郵便番号１
    $post_no2        = $_POST["form_post"]["no2"];                              //郵便番号２
    $address1        = $_POST["form_address1"];                                 //住所１
    $address2        = $_POST["form_address2"];                                 //住所２
    $address3        = $_POST["form_address3"];                                 //住所３
    $tel             = $_POST["form_tel"];                                      //TEL
    $fax             = $_POST["form_fax"];                                      //FAX
    $green_trans     = ($_POST["form_green_trans"] == 1)? 't' : 'f';            //グリーン指定業者
    $trans_note      = $_POST["form_trans_note"];                               //備考
	$update_flg      = $_POST["update_flg"];									//登録・更新判定

    /***************************/
    //０埋め
    /***************************/
	if($trans_cd != null){
        //運送業者コードに０を埋める
        $trans_cd = str_pad($trans_cd, 4, 0, STR_POS_LEFT);
        //入力したコードがマスタに存在するかチェック
        $sql  = "SELECT ";
        $sql .= "    trans_cd ";                //運送業者コード
        $sql .= "FROM ";
        $sql .= "    t_trans ";
        $sql .= "WHERE ";
        $sql .= "    trans_cd = '$trans_cd' ";
        $sql .= "AND ";
        $sql .= "    shop_id = $shop_id ";

        //変更の場合は、自分のデータ以外を参照する
        if($get_trans_id != null){
            $sql .= " AND NOT ";
            $sql .= "trans_id = '$get_trans_id'";
        }
        $sql .= ";";
        $result = Db_Query($conn, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_trans_cd","既に使用されている 運送業者コード です。");
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

            //運送業者マスタに登録
            $insert_sql  = "INSERT INTO t_trans(";
            $insert_sql .= "    trans_id,";
            $insert_sql .= "    trans_cd,";
            $insert_sql .= "    trans_name,";
            $insert_sql .= "    trans_cname,";
            $insert_sql .= "    post_no1,";
            $insert_sql .= "    post_no2,";
            $insert_sql .= "    address1,";
            $insert_sql .= "    address2,";
            $insert_sql .= "    address3,";
            $insert_sql .= "    tel,";
            $insert_sql .= "    fax,";
            $insert_sql .= "    green_trans,";
            $insert_sql .= "    note,";
            $insert_sql .= "    shop_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(trans_id), 0)+1 FROM t_trans),";
            $insert_sql .= "    '$trans_cd',";
            $insert_sql .= "    '$trans_name',";
            $insert_sql .= "    '$trans_cname',";
            $insert_sql .= "    '$post_no1',";
            $insert_sql .= "    '$post_no2',";
            $insert_sql .= "    '$address1',";
            $insert_sql .= "    '$address2',";
            $insert_sql .= "    '$address3',";
            $insert_sql .= "    '$tel',";
            $insert_sql .= "    '$fax',";
            $insert_sql .= "    '$green_trans',";
            $insert_sql .= "    '$trans_note',";
            $insert_sql .= "    $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した情報をログに残す
            $result = Log_Save( $conn, "trans", "1", $trans_cd, $trans_name);
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
            $insert_sql .= "    t_trans";
            $insert_sql .= " SET";
            $insert_sql .= "    trans_cd = '$trans_cd',";
            $insert_sql .= "    trans_name = '$trans_name',";
            $insert_sql .= "    trans_cname = '$trans_cname',";
            $insert_sql .= "    post_no1 = '$post_no1',";
            $insert_sql .= "    post_no2 = '$post_no2',";
            $insert_sql .= "    address1 = '$address1',";
            $insert_sql .= "    address2 = '$address2',";
            $insert_sql .= "    address3 = '$address3',";
            $insert_sql .= "    tel = '$tel',";
            $insert_sql .= "    fax = '$fax',";
            $insert_sql .= "    green_trans = '$green_trans',";
            $insert_sql .= "    note = '$trans_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    trans_id = $get_trans_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //登録した情報をログに残す
            $result = Log_Save( $conn, "trans", "2", $trans_cd, $trans_name);
            //失敗した場合はロールバック
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");
        
        $def_fdata["form_trans_cd"]			=	"";
        $def_fdata["form_trans_name"]		=	"";
        $def_fdata["form_trans_cname"]		=	"";
        $def_fdata["form_post"]["no1"]		=	"";
        $def_fdata["form_post"]["no2"]		=	"";
        $def_fdata["form_address1"]			=	"";
        $def_fdata["form_address2"]			=	"";
        $def_fdata["form_address3"]			=	"";
        $def_fdata["form_tel"]				=	"";
        $def_fdata["form_fax"]				=	"";
        $def_fdata["form_green_trans"]		=	"";
        $def_fdata["form_trans_note"]		=	"";
		$def_fdata["update_flg"]			=	"";
		$form->setConstants($def_fdata);

    }

}

/*****************************/
//一覧作成
/*****************************/
$sql  = "SELECT";
$sql .= "   trans_cd,";
$sql .= "   trans_id,";
$sql .= "   trans_name,";
$sql .= "   trans_cname,";
$sql .= "   CASE green_trans";
$sql .= "       WHEN 't' THEN '○'";
$sql .= "       WHEN 'f' THEN ''";
$sql .= "   END,";
$sql .= "   note,";
$sql .= "   post_no1 || '-' || post_no2,";
$sql .= "   address1 || address2 || address3,";
$sql .= "   tel,";
$sql .= "   fax";
$sql .= " FROM";
$sql .= "   t_trans";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= " ORDER BY trans_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//自動入力ボタン押下
/*****************************/
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["no1"];             //郵便番号１
    $post2     = $_POST["form_post"]["no2"];             //郵便番号２
    $post_value = Post_Get($post1,$post2,$conn);
    //郵便番号フラグをクリア
    $cons_data["input_button_flg"] = "";
    //郵便番号から自動入力
    $cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);

/****************************/
//CSVボタン押下処理
/****************************/
}elseif($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "登　録"){

	$sql  = "SELECT";
	$sql .= "   trans_cd,";
	$sql .= "   trans_id,";
	$sql .= "   trans_name,";
	$sql .= "   trans_cname,";
	$sql .= "   CASE green_trans";
	$sql .= "       WHEN 't' THEN '○'";
	$sql .= "       WHEN 'f' THEN ''";
	$sql .= "   END,";
	$sql .= "   note,";
	$sql .= "   post_no1 || '-' || post_no2,";
	$sql .= "   address1,";
    $sql .= "   address2,";
    $sql .= "   address3,";
	$sql .= "   tel,";
	$sql .= "   fax";
	$sql .= " FROM";
	$sql .= "   t_trans";
	$sql .= " WHERE";
	$sql .= "   shop_id = $shop_id";
	$sql .= " ORDER BY trans_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV作成
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = $page_data[$i][6];
        $csv_page_data[$i][4] = $page_data[$i][7];
        $csv_page_data[$i][5] = $page_data[$i][8];
        $csv_page_data[$i][6] = $page_data[$i][9];
        $csv_page_data[$i][7] = $page_data[$i][10];
        $csv_page_data[$i][8] = $page_data[$i][11];
        $csv_page_data[$i][9] = $page_data[$i][4];
        $csv_page_data[$i][10] = $page_data[$i][5];
    }

    $csv_file_name = "運送業者マスタ".date("Ymd").".csv";
    $csv_header = array(
        "運送業者コード",
        "運送業者名",
        "略称",
        "郵便番号",
        "住所１",
        "住所２",
        "住所３",
        "TEL",
        "FAX",
        "グリーン指定業者",
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
	'comp_msg'   	=> "$comp_msg",
	'total_count'   => "$total_count",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign('page_data', $page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
