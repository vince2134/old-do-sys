<?php
/****************************
 * 変更履歴
 *  ・(2006-08-03)商品を略称から正式名称へ変更<watanabe-k>
 *  ・(2006-08-21)商品分類を表示するように変更<watanabe-k>
 *
 *
*****************************/

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/22      11-007      ふ          取扱期間検索フォームのエラーチェック修正
 *  2006/11/22      11-008      ふ          取扱期間検索フォームのエラーチェック修正
 *  2006/11/23      11-199~204  ふ          受払データ取得クエリを作り直し
 *  2006/12/06      ban_0013    suzuki      日付のゼロ埋め追加
 *  2006/12/15                  suzuki      初期表示の取扱期間を前回の月次更新にするように修正
 *  2007/02/22                  watanabe-k  不要機能の削除    
 *  2007/04/17      B0702-043   kajioka-h   ウィンドウタイトルに画面切替ボタンのHTMLが出力されていたのを修正
 *  2009/10/09                  hashimoto-y 在庫管理フラグをショップ別商品情報テーブルに変更
 *  2009/10/09_1                hashimoto-y 取扱期間の開始日をフォームに変更
 *  2009/10/12                  aoyama-n    会計情報CSV出力機能追加 
 *  2009/10/20                  aoyama-n    会計情報CSVのデータとして「移動」「組立」を追加 
 *  2009/10/21                  hashimoto-y 初期表示で開始日をsetConstantsしてないバグ修正 
 *  2010/01/08                  aoyama-n    在庫照会から遷移後、表示ボタンをクリックするとCSVが出力される不具合修正
 *  2010/05/12      Rev.1.5     hashimoto-y 初期表示に検索項目だけ表示する修正
*  2016/01/22                amano  Button_Submit 関数でボタン名が送られない IE11 バグ対応  
 *
*/

$page_title = "在庫受払照会";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);

/****************************/
//外部変数取得
/****************************/
$shop_id      = $_SESSION["client_id"]; 
$get_goods_id = $_GET["goods_id"];       
$get_ware_id  = $_GET["ware_id"];

/*** GETデータの正当性チェック ***/
if ($get_goods_id != null && Get_Id_Check_Db($db_con, $get_goods_id, "goods_id", "t_goods", "num", "shop_id = 1") != true){
    header("Location: ../top.php");
}
if ($get_ware_id != null && Get_Id_Check_Db($db_con, $get_ware_id, "ware_id", "t_ware", "num", "shop_id = 1") != true){
    header("Location: ../top.php");
}

//商品IDをhiddenにより保持する
if($_GET["goods_id"] != NULL){
    Get_Id_Check3($_GET["goods_id"]);
    $set_id_data["hdn_goods_id"] = $get_goods_id;
    $form->setConstants($set_id_data);
}else{
    $get_goods_id = $_POST["hdn_goods_id"];
}
//倉庫IDをhiddenにより保持する
if($_GET["ware_id"] != NULL){
    Get_Id_Check3($_GET["ware_id"]);
    $set_id_data["hdn_ware_id"] = $get_ware_id;
    $form->setConstants($set_id_data);
}else{
    $get_ware_id = $_POST["hdn_ware_id"];
}

/****************************/
//デフォルト値設定
/****************************/
/*
$def_data = array(
    "form_output"           => "1"
);
*/

//2009-10-12 aoyama-n
$def_data = array(
    "form_output_type"      => "1"
);

//最新の月次更新日を取得
$plus1_flg = true;
$sql  = "SELECT";
$sql .= "   COALESCE(MAX(close_day), null) ";
$sql .= "FROM";
$sql .= "   t_sys_renew ";
$sql .= "WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= "   AND";
$sql .= "   renew_div = '2'";
$sql .= ";";
$result = Db_Query($db_con, $sql);
$max_close_day = pg_fetch_result($result, 0,0);

if($max_close_day == null){
    $plus1_flg = false;
    $sql  = "SELECT \n";
    $sql .= "   COALESCE(MIN(work_day), null) \n";
    $sql .= "FROM \n";
    $sql .= "   t_stock_hand \n";
    $sql .= "WHERE \n";
    $sql .= "   work_div = '6' \n";
    $sql .= "AND \n";
    $sql .= "   adjust_reason = '1' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $max_close_day = pg_fetch_result($result, 0,0);
}
$ary_close_day = explode('-', $max_close_day);

// 月次更新が1度でも行われている場合は月次更新日＋１にする
if ($plus1_flg === true){
    $plus1_date = date("Y-m-d", mktime(0, 0, 0, $ary_close_day[1] , $ary_close_day[2]+1, $ary_close_day[0]));
    $ary_close_day = explode('-', $plus1_date);
}else{
    $plus1_date = $max_close_day;
}

$def_data[form_hand_day][sy] = $ary_close_day[0];
$def_data[form_hand_day][sm] = $ary_close_day[1];
$def_data[form_hand_day][sd] = $ary_close_day[2];

$form->setDefaults($def_data);

$max_close_day = $ary_close_day[0]."-".$ary_close_day[1]."-".$ary_close_day[2];

/****************************/
//部品定義
/****************************/
//商品・倉庫が指定されているか
if($get_goods_id == NULL && $get_ware_id == NULL){
/*
    //出力形式
    $radio = "";
    $radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
    $radio[] =& $form->createElement( "radio",NULL,NULL, "帳票","2");
    $form->addGroup($radio, "form_output", "出力形式");
*/
    //2009-10-12 aoyama-n
    //出力形式
    $radio = "";
    $radio[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
    $radio[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
    $form->addGroup($radio, "form_output_type", "出力形式");

    //商品コード
    $form->addElement("text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\" $g_form_option");

    //商品名
    $form->addElement("text","form_goods_cname","","size=\"34\" maxLength=\"15\" $g_form_goods");

    //商品分類
    $select_value = Select_Get($db_con, "g_product");
    $form->addElement("select", "form_g_product", "", $select_value, $g_form_option_select);

    //倉庫
    $select_value = Select_Get($db_con,'ware');
    $form->addElement('select', 'form_ware', 'セレクトボックス', $select_value,$g_form_option_select);
}

//取扱期間
$text="";
#2009-10-09_1 hashimoto-y
#$text[] =& $form->createElement(
#"text","sy","テキストフォーム"," size=\"4\" maxLength=\"4\" style=\"color : #000000;border : #ffffff 1px solid;background-color: #ffffff; text-align: right;\" onkeyup=\"changeText(this.form,'form_hand_day[sy]','form_hand_day[sm]',4)\" readonly"
#);
$text[] =& $form->createElement(
"text","sy","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[sy]','form_hand_day[sm]',4)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[sy]','form_hand_day[sm]','form_hand_day[sd]')\"
        onBlur=\"blurForm(this)\" "

);


$text[] =& $form->createElement("static","","","-");

#2009-10-09_1 hashimoto-y
#$text[] =& $form->createElement(
#"text","sm","テキストフォーム"," size=\"1\" maxLength=\"2\" style=\"color : #000000;border : #ffffff 1px solid;background-color:#ffffff; text-align: right;\" onkeyup=\"changeText(this.form,'form_hand_day[sm]','form_hand_day[sd]',2)\" readonly"
#);
$text[] =& $form->createElement(
"text","sm","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[sm]','form_hand_day[sd]',2)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[sy]','form_hand_day[sm]','form_hand_day[sd]')\"
        onBlur=\"blurForm(this)\""
);


$text[] =& $form->createElement("static","","","-");

#2009-10-09_1 hashimoto-y
$text[] =& $form->createElement(
"text","sd","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[sy]','form_hand_day[sm]','form_hand_day[sd]')\"
        onBlur=\"blurForm(this)\""
);


/*
$text[] =& $form->createElement("static","","","　〜　");
$text[] =& $form->createElement(
"text","ey","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hand_day[ey]','form_hand_day[em]',4)\"".$g_form_option."\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","em","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_hand_day[em]','form_hand_day[ed]',2)\"".$g_form_option."\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","ed","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\""
);
$form->addGroup( $text,"form_hand_day","form_hand_day");
*/
$text[] =& $form->createElement("static","","","　〜　");
$text[] =& $form->createElement(
"text","ey","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[ey]','form_hand_day[em]',4)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[ey]','form_hand_day[em]','form_hand_day[ed]')\"
        onBlur=\"blurForm(this)\" "
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","em","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" 
        onkeyup=\"changeText(this.form,'form_hand_day[em]','form_hand_day[ed]',2)\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[ey]','form_hand_day[em]','form_hand_day[ed]')\"
        onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement(
"text","ed","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onFocus=\"onForm_today(this,this.form,'form_hand_day[ey]','form_hand_day[em]','form_hand_day[ed]')\"
        onBlur=\"blurForm(this)\""
);
$form->addGroup( $text,"form_hand_day","form_hand_day");



// 在庫照会リンクボタン
$form->addElement("button", "4_101_button", "在庫照会", "onClick=\"location.href('./1-4-101.php');\"");

// 在庫受払リンクボタン
$form->addElement("button", "4_105_button", "在庫受払", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

// 滞留在庫一覧リンクボタン
$form->addElement("button", "4_110_button", "滞留在庫一覧", "onClick=\"javascript:location.href('./1-4-110.php')\"");




//遷移元判定
if(($get_goods_id == NULL && $get_ware_id == NULL) || ($get_goods_id != NULL && $get_ware_id != NULL)){
//受払照会・在庫照会の場合
    //表示
//    $form->addElement("submit","show_button","表　示","onClick=\"javascript:Which_Type('form_output','1-4-106.php','#');\"");
    $form->addElement("submit","show_button","表　示","#");
    //クリア
    $form->addElement("button","clear_button","クリア","onClick=\"javascript:location.href='1-4-105.php?ware_id=".$get_ware_id."&goods_id=".$get_goods_id."'\"");
}else{
//発注点警告・出荷予定一覧の場合
    //表示
    $form->addElement("button","show_button","表　示","onClick=\"javascript:Button_Submit('show_button_flg','1-4-105.php','true', this)\"");  
    //閉じる
    $form->addElement("button","clear_button","閉じる","onClick=\"window.close()\"");
}

$form->addElement("hidden", "show_button_flg");      //表示ボタン押下判定
$form->addElement("hidden", "hdn_goods_id");         //商品ID
$form->addElement("hidden", "hdn_ware_id");          //倉庫ID
$form->addElement("hidden", "hdn_g_product_id");     //商品分類ID

$form->addElement("hidden", "h_ware_id");            //検索条件の倉庫ID
$form->addElement("hidden", "h_goods_cd");           //検索条件の商品CD
$form->addElement("hidden", "h_goods_cname");         //検索条件の商品名
$form->addElement("hidden", "h_hand_start");         //検索条件の取扱開始日
$form->addElement("hidden", "h_hand_end");           //検索条件の取扱終了日

/****************************/
//ページ数情報取得
/****************************/
$page_count  = $_POST["f_page1"];       //現在のページ数
if($page_count == NULL){
    $offset = 0;
}else{
    $offset = $page_count * 100 - 100;   
}

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["show_button"] == "表　示" || $_POST["show_button_flg"] == true){
    //現在のページ数初期化
    $page_count = null;
    $offset = 0;
    $client_data["show_button_flg"]     = "";        //表示ボタン
    $form->setConstants($client_data);

    /****************************/
    //POST情報取得
    /****************************/
    if($_POST["form_ware"] != NULL){
        $ware_id    = $_POST["form_ware"];        //倉庫ID
        $set_data["h_ware_id"] = stripslashes($ware_id);
//      $ware_data["h_ware_id"] = stripslashes($ware_id);
//      $form->setConstants($ware_data);
    }
    if($_POST["form_goods_cd"] != NULL){
        $goods_cd   = $_POST["form_goods_cd"];    //商品CD
        $set_data["h_goods_cd"] = stripslashes($goods_cd);
//      $goods_data["h_goods_cd"] = stripslashes($goods_cd);
//      $form->setConstants($goods_data);
    }
    if($_POST["form_goods_cname"] != NULL){
        $goods_cname = $_POST["form_goods_cname"];  //商品名
        $set_data["h_goods_cname"] = stripslashes($goods_cname);
//      $goods2_data["h_goods_cname"] = stripslashes($goods_cname);
//      $form->setConstants($goods2_data);
    }
    //取扱開始日
    if($_POST["form_hand_day"]["sy"] != NULL && $_POST["form_hand_day"]["sm"] != NULL && $_POST["form_hand_day"]["sd"] != NULL){
        $hand_start = $_POST["form_hand_day"]["sy"]."-".$_POST["form_hand_day"]["sm"]."-".$_POST["form_hand_day"]["sd"];
        //2009-10-20 aoyama-n
		$y_day = str_pad($_POST["form_hand_day"]["sy"],4, 0, STR_PAD_LEFT);  
		$m_day = str_pad($_POST["form_hand_day"]["sm"],2, 0, STR_PAD_LEFT); 
		$d_day = str_pad($_POST["form_hand_day"]["sd"],2, 0, STR_PAD_LEFT); 
        $hand_start   = $y_day."-".$m_day."-".$d_day;
        $set_data["h_hand_start"] = stripslashes($hand_start);
//      $start_data["h_hand_start"] = stripslashes($hand_start);
//      $form->setConstants($start_data);
    }
    //取扱終了日
    if($_POST["form_hand_day"]["ey"] != NULL && $_POST["form_hand_day"]["em"] != NULL && $_POST["form_hand_day"]["ed"] != NULL){
		$y_day = str_pad($_POST["form_hand_day"]["ey"],4, 0, STR_PAD_LEFT);  
		$m_day = str_pad($_POST["form_hand_day"]["em"],2, 0, STR_PAD_LEFT); 
		$d_day = str_pad($_POST["form_hand_day"]["ed"],2, 0, STR_PAD_LEFT); 
        $hand_end   = $y_day."-".$m_day."-".$d_day;
        $set_data["h_hand_end"] = stripslashes($hand_end);
//      $form->setConstants($end_data);
    }
    //商品分類
    if($_POST["form_g_product"] != null){
        $g_product_id = $_POST["form_g_product"];
        $set_data["hdn_g_product_id"] = $g_product_id;
    }
    $form->setConstants($set_data);

    //2009-10-12 aoyama-n
    //出力形式
    if($_POST["form_output_type"] != null){
        $output_type = $_POST["form_output_type"];
    }

//表示ボタンが押されていない場合（ページ処理）
}else if(count($_POST) > 0 && ($_POST["show_button"] != "表　示" || $_POST["show_button_flg"] != true)){

    /****************************/
    //POST情報取得
    /****************************/
    if($_POST["h_ware_id"] != NULL){
        $ware_id    = $_POST["h_ware_id"];     //倉庫ID
    }
    if($_POST["h_goods_cd"] != NULL){
        $goods_cd   = $_POST["h_goods_cd"];    //商品CD
    }
    if($_POST["h_goods_cname"] != NULL){
        $goods_cname = $_POST["h_goods_cname"];  //商品名
    }
    //取扱開始日
    if($_POST["h_hand_start"] != NULL){
        $hand_start = $_POST["h_hand_start"];
    }
    //取扱終了日
    if($_POST["h_hand_end"] != NULL){
        $hand_end   = $_POST["h_hand_end"];
    }
    //商品分類
    if($_POST["hdn_g_product_id"] != null){
        $g_product_id = $_POST["hdn_g_product_id"];
    }
    //2009-10-12 aoyama-n
    //出力形式
    if($_POST["form_output_type"] != null){
        $output_type = $_POST["form_output_type"];
    }
//初期表示・クリアボタンが押された場合
}else{
//    $hand_start = $max_close_day;
    $hand_start = $plus1_date;
    //2009-10-12 aoyama-n
    $output_type = "1";              //出力形式   

    #2009-10-21 hashimoto-y
    $set_data["h_hand_start"] = $hand_start;
    $form->setConstants($set_data);
}

/****************************/
//エラーチェック(PHP)
/****************************/
$error_flg = false;             //エラー判定フラグ
/*
//◇取扱開始日
//・日付妥当性チェック
if ($_POST["show_button"] != null && 
    ($_POST["form_hand_day"]["sy"] != null || $_POST["form_hand_day"]["sm"] != null || $_POST["form_hand_day"]["sd"] != null)){
    $day_y = (int)$_POST["form_hand_day"]["sy"];
    $day_m = (int)$_POST["form_hand_day"]["sm"];
    $day_d = (int)$_POST["form_hand_day"]["sd"];
    if(!checkdate($day_m,$day_d,$day_y)){
        $error = "取扱期間 の検索には「年」「月」「日」は全て必須入力です。";
        $error_flg = true;
    }
}
*/
#2009-10-09_1 hashimoto-y
if ($_POST["show_button"] != null && 
    ($_POST["form_hand_day"]["sy"] != null || $_POST["form_hand_day"]["sm"] != null || $_POST["form_hand_day"]["sd"] != null)){
    if ($_POST["form_hand_day"]["sy"] == null || $_POST["form_hand_day"]["sm"] == null || $_POST["form_hand_day"]["sd"] == null){
        $error = "取扱期間 開始日の検索には「年」「月」「日」は全て必須入力です。";
        $error_flg = true;
    }elseif (!ereg("^[0-9]+$", $_POST["form_hand_day"]["sy"]) ||
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["sm"]) || 
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["sd"])){
        $error = "取扱期間 が妥当ではありません。";
        $error_flg = true;
    }elseif(!checkdate((int)$_POST["form_hand_day"]["sm"], (int)$_POST["form_hand_day"]["sd"], (int)$_POST["form_hand_day"]["sy"])){
        $error = "取扱期間 が妥当ではありません。";
        $error_flg = true;
    }
}


//◇取扱期間終了日
//・日付妥当性チェック
// 年月日のいずれかにNULLがある場合
if ($_POST["show_button"] != null && 
    $_POST["form_hand_day"]["ey"] == null || $_POST["form_hand_day"]["em"] == null || $_POST["form_hand_day"]["ed"] == null){
    // 「年月日全てがNULL」ではない場合
    if (!($_POST["form_hand_day"]["ey"] == null && $_POST["form_hand_day"]["em"] == null && $_POST["form_hand_day"]["ed"] == null)){
        $error = "取扱期間 終了日の検索には「年」「月」「日」は全て必須入力です。";
        $error_flg = true;
    }
}else{
    if (!ereg("^[0-9]+$", $_POST["form_hand_day"]["ey"]) ||
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["em"]) || 
        !ereg("^[0-9]+$", $_POST["form_hand_day"]["ed"])){
        $error = "取扱期間 が妥当ではありません。";
        $error_flg = true;
    }
    if(!checkdate((int)$_POST["form_hand_day"]["em"], (int)$_POST["form_hand_day"]["ed"], (int)$_POST["form_hand_day"]["ey"])){
        $error = "取扱期間 が妥当ではありません。";
        $error_flg = true;
    }
}
/*
//月次更新のデータを抽出
$sql  = "SELECT \n";
$sql .= "   MAX(close_day) AS renew_date\n";
$sql .= " FROM \n";
$sql .= "   t_sys_renew \n";
$sql .= " WHERE \n";
$sql .= "   renew_div = '2'\n";
$sql .= "   AND \n";
$sql .= "   shop_id = $shop_id\n";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$renew_day = pg_fetch_result($result, 0,0);         //月次更新日
*/
/*
//既に月次更新を行っている場合で、取扱期間開始日が指定された場合
if($renew_day != null && $hand_start != null){

    $sql  = "SELECT \n";
    $sql .= "   COUNT(*) \n";
    $sql .= "FROM\n";
    $sql .= "   t_sys_renew \n";
    $sql .= "WHERE\n";
    $sql .= "   close_day = '$hand_start'\n";
    $sql .= "   AND\n";
    $sql .= "   renew_div = '2'\n";
    $sql .= "   AND\n";
    $sql .= "   shop_id = $shop_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $day_count = pg_fetch_result($result, 0,0);

    if($day_count == 0){
        $error = "取扱期間の開始日には自社の締日を指定してください。";
        $error_flg = true;
    }else{
        $renew_day = $hand_start;
    }
}

/****************************/
//本部受払データ取得SQL
/****************************/
// 取扱期間開始日がNULLの場合はシステム開始日を代入
$hand_start = ($hand_start == null || $hand_start == '--') ? START_DAY : $hand_start;



#2010-05-12 hashimoto-y
if( ($_POST["show_button"] == "表　示" || $_POST["show_button_flg"] == true) || (count($_POST) > 0 && ($_POST["show_button"] != "表　示" || $_POST["show_button_flg"] != true)) ){

//エラーの場合は表示を行なわない
if($error_flg == false){

    //2009-10-12 aoyama-n
    //出力形式が「画面」の場合
    #2010-01-08 aoyama-n
    #if($output_type == "1"){
    if($output_type != "2"){

        $sql  = "SELECT \n";
        $sql .= "   t_ware.ware_name, \n";                              // 倉庫名
        $sql .= "   t_goods.goods_cd, \n";                              // 商品コード
        $sql .= "   t_goods.goods_name, \n";                            // 商品名
        $sql .= "   t_stock_total.ware_id, \n";                         // 在庫集計の倉庫ID
        $sql .= "   t_stock_total.goods_id, \n";                        // 在庫集計の商品ID
        $sql .= "   COALESCE(t_stock_total.old_count,0) AS zenzai, \n";             // 前残在庫
        $sql .= "   COALESCE(t_stock_total.in_count,0)  AS nyuuko, \n";             // 入庫数
        $sql .= "   COALESCE(t_stock_total.out_count,0) AS syukko, \n";             // 出庫数
        $sql .= "   COALESCE(t_stock_total.old_count,0) \n";
        $sql .= "   + COALESCE(t_stock_total.in_count,0) \n";
        $sql .= "   - COALESCE(t_stock_total.out_count,0) AS genzai, \n";           // 現在庫数
        $sql .= "   t_g_product.g_product_name \n";

        $sql .= "FROM \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           stock_hand.ware_id, \n";
        $sql .= "           stock_hand.goods_id, \n";
        $sql .= "           stock_hand.shop_id, \n";
        $sql .= "           t_ware_in.in_count, \n";
        $sql .= "           t_ware_out.out_count, \n";
        //2009-10-11 aoyama-n
        #$sql .= "           COALESCE(t_last_stock_num1.old_count1, 0) + COALESCE(t_last_stock_num2.old_count2, 0) AS old_count \n";
        $sql .= "           COALESCE(t_last_stock_num1.old_count1, 0) AS old_count \n";
        $sql .= "       FROM \n";
                            // ■倉庫、商品、ショップの受払情報（受払テーブル）引当・発注残以外
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id, \n";
        $sql .= "                   goods_id, \n";
        $sql .= "                   shop_id, \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        if($hand_end != NULL){
        $sql .= "               AND \n";
        $sql .= "                   work_day <= '$hand_end' \n";
        }
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id, shop_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS stock_hand \n";
                            // ■入庫数（受払テーブル）引当・発注残・システム開始在庫調整以外
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id, \n";
        $sql .= "                   SUM(num) AS in_count \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   '$hand_start' <= work_day \n";
        if($hand_end != NULL){
        $sql .= "               AND \n";
        $sql .= "                   work_day <= '$hand_end' \n";
        }
        $sql .= "               AND \n";
        $sql .= "                   io_div = '1' \n";
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        //2009-10-12 aoyama-n
        #$sql .= "               AND \n";
        #$sql .= "                   NOT (work_div = '6' AND adjust_reason = '1') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_ware_in \n";
        $sql .= "           ON stock_hand.ware_goods_id = t_ware_in.ware_goods_id \n";
                        // ■出庫数（受払テーブル）引当・発注残・システム開始在庫調整以外
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id,\n";
        $sql .= "                   SUM (num) AS out_count \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   '$hand_start' <= work_day \n";
        if($hand_end != NULL){
        $sql .= "               AND \n";
        $sql .= "                   work_day <= '$hand_end' \n";
        }
        $sql .= "               AND \n";
        $sql .= "                   io_div = '2' \n";
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        //2009-10-12 aoyama-n
        #$sql .= "               AND \n";
        #$sql .= "                   NOT (work_div = '6' AND adjust_reason = '1') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_ware_out \n";
        $sql .= "           ON stock_hand.ware_goods_id = t_ware_out.ware_goods_id \n";
                        // ■前残在庫1/2（受払テーブル）取扱期間開始日より前の受払データ（引当、発注残を除く）
        $sql .= "           LEFT JOIN \n";
        $sql .= "           ( \n";
        $sql .= "               SELECT \n";
        $sql .= "                   ware_id || '-' || goods_id AS ware_goods_id, \n";
        $sql .= "                   SUM(COALESCE(num, 0) * \n";
        $sql .= "                       CASE io_div \n";
        $sql .= "                           WHEN '1' THEN 1 \n";
        $sql .= "                           WHEN '2' THEN -1 \n";
        $sql .= "                       END \n";
        $sql .= "                   ) \n";
        $sql .= "                   AS old_count1 \n";
        $sql .= "               FROM \n";
        $sql .= "                   t_stock_hand \n";
        $sql .= "               WHERE \n";
        $sql .= "                   shop_id = $shop_id \n";
        $sql .= "               AND \n";
        $sql .= "                   work_day < '$hand_start' \n";
        $sql .= "               AND \n";
        $sql .= "                   work_div NOT IN ('1', '3') \n";
        $sql .= "               GROUP BY \n";
        $sql .= "                   ware_id, goods_id \n";
        $sql .= "           ) \n";
        $sql .= "           AS t_last_stock_num1 \n";
        $sql .= "           ON stock_hand.ware_goods_id = t_last_stock_num1.ware_goods_id \n";
                        // ■前残在庫2/2（受払テーブル）取扱期間開始日以降のシステム開始在庫調整
        //2009-10-12 aoyama-n
        #$sql .= "           LEFT JOIN \n";
        #$sql .= "           ( \n";
        #$sql .= "               SELECT \n";
        #$sql .= "                   ware_id || '-' || goods_id AS ware_goods_id, \n";
        #$sql .= "                   SUM(COALESCE(num, 0) * \n";
        #$sql .= "                       CASE io_div \n";
        #$sql .= "                           WHEN '1' THEN 1 \n";
        #$sql .= "                           WHEN '2' THEN -1 \n";
        #$sql .= "                       END \n";
        #$sql .= "                   ) \n";
        #$sql .= "                   AS old_count2 \n";
        #$sql .= "               FROM \n";
        #$sql .= "                   t_stock_hand \n";
        #$sql .= "               WHERE \n";
        #$sql .= "                   shop_id = $shop_id \n";
        #$sql .= "               AND \n";
        #$sql .= "                   '$hand_start' <= work_day \n";
        #$sql .= "               AND \n";
        #$sql .= "                   work_div = '6' AND adjust_reason = '1' \n";
        #$sql .= "               GROUP BY \n";
        #$sql .= "                   ware_id, goods_id \n";
        #$sql .= "           ) \n";
        #$sql .= "           AS t_last_stock_num2 \n";
        #$sql .= "           ON stock_hand.ware_goods_id = t_last_stock_num2.ware_goods_id \n";
        $sql .= "   ) \n";
        $sql .= "   AS t_stock_total \n";

        $sql .= "   INNER JOIN t_ware ON t_ware.ware_id = t_stock_total.ware_id \n";
        $sql .= "   INNER JOIN t_goods ON t_goods.goods_id = t_stock_total.goods_id \n";
        $sql .= "   INNER JOIN t_client ON t_client.client_id = t_stock_total.shop_id \n";
        $sql .= "   INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id \n";
        #2009-10-09 hashimoto-y
        $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

        $sql .= "WHERE \n";
        #2009-10-09 hashimoto-y
        #$sql .= "   t_goods.stock_manage = '1' \n";
        $sql .= "   t_goods_info.stock_manage = '1' \n";
        $sql .= "   AND \n";
        $sql .= "   t_goods_info.shop_id = $shop_id ";

        // GET情報に商品IDがあった場合
        $sql .= ($get_goods_id != NULL) ?   "AND t_stock_total.goods_id = $get_goods_id \n" : null;
        // GET情報に倉庫IDがあった場合
        $sql .= ($get_ware_id != NULL) ?    "AND t_stock_total.ware_id = $get_ware_id \n" : null;
        // 倉庫IDが指定されている場合
        $sql .= ($ware_id != NULL) ?        "AND t_stock_total.ware_id = $ware_id \n" : null;
        // 商品分類が指定されている場合
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // 商品CDが指定されている場合
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //商品名が指定されている場合
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;

        $sql .= "ORDER BY \n";
        $sql .= "   t_ware.ware_cd, t_g_product.g_product_cd, t_goods.goods_cd \n";

        $result = Db_Query($db_con,$sql."LIMIT 100 OFFSET $offset;\n");
        $page_data = Get_Data($result);

        for($x=0;$x<count($page_data);$x++){
            for($j=0;$j<count($page_data[$x]);$j++){
                //入庫数は形式変更
                if($j==5){
                    $page_data[$x][$j] = number_format($page_data[$x][$j]);
                //出庫数は形式変更
                }else if($j==6){
                    $page_data[$x][$j] = number_format($page_data[$x][$j]);
                }
            }
        }

        $result = Db_Query($db_con,$sql.";");
        //全件数
        $total_count = pg_num_rows($result);

        //表示範囲指定
        $range = "100";


    //2009-10-12 aoyama-n
    //出力形式が「CSV」の場合
    }else{

        $sql  = "SELECT\n";
        $sql .= "  work_day,\n";
        $sql .= "  g_product_cd,\n";
        $sql .= "  g_product_name,\n";
        $sql .= "  goods_cd,\n";
        $sql .= "  goods_name,\n";
        $sql .= "  num,\n";
        $sql .= "  price,\n";
        $sql .= "  work_div,\n";
        $sql .= "  io_div,\n";
        $sql .= "  client_cname \n";
        $sql .= "FROM\n";
        //売上データ
        $sql .= "  (SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    t_sale_d.sale_price AS price,\n";
        $sql .= "    '売上' AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '入庫' WHEN 2 THEN '出庫' END AS io_div,\n";
        $sql .= "    t_stock_hand.client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_sale_d\n";
        $sql .= "    ON t_stock_hand.sale_d_id = t_sale_d.sale_d_id\n";
        $sql .= "    INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div = '2'\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
 
        // GET情報に商品IDがあった場合
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET情報に倉庫IDがあった場合
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // 倉庫IDが指定されている場合
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // 商品分類が指定されている場合
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // 商品CDが指定されている場合
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //商品名が指定されている場合
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
 
        $sql .= "  UNION ALL\n";
        //仕入データ
        $sql .= "  SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    t_buy_d.buy_price AS price,\n";
        $sql .= "    '仕入' AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '入庫' WHEN 2 THEN '出庫' END AS io_div,\n";
        $sql .= "    t_stock_hand.client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_buy_d\n";
        $sql .= "    ON t_stock_hand.buy_d_id = t_buy_d.buy_d_id\n";
        $sql .= "    INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div = '4'\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
 
        // GET情報に商品IDがあった場合
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET情報に倉庫IDがあった場合
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // 倉庫IDが指定されている場合
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // 商品分類が指定されている場合
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // 商品CDが指定されている場合
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //商品名が指定されている場合
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
 
        $sql .= "  UNION ALL\n";
        //調整データ
        $sql .= "  SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    t_stock_hand.adjust_price AS price,\n";
        $sql .= "    '調整' AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '入庫' WHEN 2 THEN '出庫' END AS io_div,\n";
        $sql .= "    '自倉庫' AS client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div = '6'\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
        // GET情報に商品IDがあった場合
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET情報に倉庫IDがあった場合
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // 倉庫IDが指定されている場合
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // 商品分類が指定されている場合
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // 商品CDが指定されている場合
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //商品名が指定されている場合
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;
   
        //2009-10-20 aoyama-n
        $sql .= "  UNION ALL\n";
        //移動・組立データ
        $sql .= "  SELECT\n";
        $sql .= "    t_stock_hand.work_day,\n";
        $sql .= "    t_g_product.g_product_cd,\n";
        $sql .= "    t_g_product.g_product_name,\n";
        $sql .= "    t_goods.goods_cd,\n";
        $sql .= "    t_goods.goods_name,\n";
        $sql .= "    t_stock_hand.num,\n";
        $sql .= "    NULL AS price,\n";
        $sql .= "    CASE work_div WHEN '5' THEN '移動' WHEN '7' THEN '組立' END AS work_div,\n";
        $sql .= "    CASE io_div WHEN 1 THEN '入庫' WHEN 2 THEN '出庫' END AS io_div,\n";
        $sql .= "    COALESCE( client_cname,'自倉庫' ) AS client_cname\n";
        $sql .= "  FROM\n";
        $sql .= "    t_stock_hand INNER JOIN t_goods\n";
        $sql .= "    ON t_stock_hand.goods_id = t_goods.goods_id\n";
        $sql .= "    INNER JOIN t_goods_info\n";
        $sql .= "    ON t_goods.goods_id = t_goods_info.goods_id\n";
        $sql .= "    LEFT JOIN t_g_product\n";
        $sql .= "    ON t_goods.g_product_id = t_g_product.g_product_id\n";
        $sql .= "  WHERE\n";
        $sql .= "    t_stock_hand.shop_id = $shop_id\n";
        $sql .= "    AND t_stock_hand.work_div IN ('5', '7')\n";
        $sql .= "    AND t_stock_hand.work_day >= '$hand_start'\n";
        if($hand_end != NULL){
        $sql .= "    AND t_stock_hand.work_day <= '$hand_end'\n";
        }
        $sql .= "    AND t_goods_info.stock_manage = '1'\n";
        $sql .= "    AND t_goods_info.shop_id = $shop_id\n";
        // GET情報に商品IDがあった場合
        #$sql .= ($get_goods_id != NULL) ?   "AND t_stock_hand.goods_id = $get_goods_id \n" : null;
        // GET情報に倉庫IDがあった場合
        #$sql .= ($get_ware_id != NULL) ?    "AND t_stock_hand.ware_id = $get_ware_id \n" : null;
        // 倉庫IDが指定されている場合
        $sql .= ($ware_id != NULL) ?        "AND t_stock_hand.ware_id = $ware_id \n" : null;
        // 商品分類が指定されている場合
        $sql .= ($g_product_id != null) ?   "AND t_g_product.g_product_id = $g_product_id \n" : null;
        // 商品CDが指定されている場合
        $sql .= ($goods_cd != NULL) ?       "AND t_goods.goods_cd LIKE '$goods_cd%' \n" : null;
        //商品名が指定されている場合
        $sql .= ($goods_cname != NULL) ?    "AND t_goods.goods_name LIKE '%$goods_cname%' \n" : null;

        $sql .= "  ) AS stock_hand\n";
        $sql .= "ORDER BY g_product_cd,goods_cd,work_day\n";
 
        //SQL実行
        $res        = Db_Query($db_con, $sql);
        $stock_hand_data = Get_Data($res, $output_type);
   
        //CSVファイル名
        $csv_file_name = "在庫会計情報".date("Ymd").".csv";
  
        // CSVのタイトル
        $csv_header = array(
                    "受払日",
                    "商品分類コード",
                    "商品分類名",
                    "商品コード",
                    "商品名",
                    "受払数",
                    "単価",
                    "作業区分",
                    "入出庫区分",
                    "受払先"
        );
 
        //クエリの結果をセット
        $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
        $csv_data = Make_Csv($stock_hand_data, $csv_header);
 
        //CSV出力
        Header("Content-disposition: attachment; filename=$csv_file_name");
        Header("Content-type: application/octet-stream; name=$csv_file_name");
        print $csv_data;
        exit;
  
    }
    
}else{
    //全件数
    $total_count = 0;
    //表示範囲指定
    $range = "100";
}

#2010-05-12 hashimoto-y
$display_flg = true;
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
//$page_menu = Create_Menu_h('stock','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["4_101_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["4_105_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["4_110_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    //'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'hand_start'    => "$hand_start",
    'hand_end'      => "$hand_end",
    'error'         => "$error",
    'get_goods_id'  => "$get_goods_id",
    'get_ware_id'   => "$get_ware_id",
    'display_flg'    => "$display_flg",
));
$smarty->assign('row',$page_data);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
