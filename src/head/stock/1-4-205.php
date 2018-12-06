<?php

/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/06      ban_0017    suzuki      日付のゼロ埋め追加
 *  2007/03/06      作業項目73  ふ          棚卸一覧と差異明細一覧を１モジュールに集約したため、リンク先をひとつにまとめる
 *
 *
*/

$page_title = "棚卸実績一覧";

//環境設定ファイル env setting file
require_once("ENV_local.php");

//HTML_QuickFormを作成 create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続 connect
$db_con = Db_Connect();

// 権限チェック auth check
$auth       = Auth_Check($db_con);

/************************* ***/
//外部変数取得 acquire external varibale
/****************************/
$shop_id      = $_SESSION["client_id"]; 

/****************************/
//フォーム作成 create form
/****************************/
//調査番号 survey number
$form->addElement("text","form_invent_no","",
        "size=\"13\" maxLength=\"10\" style=\"$g_form_style\"  $g_form_option");

//棚卸日 survey date
$form_expected_day[] =& $form->createElement(
    "text","sy","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[sy]','form_ex_day[sm]',4)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","sm","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[sm]','form_ex_day[sd]',2)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","sd","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[sd]','form_ex_day[ey]',2)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","〜");
$form_expected_day[] =& $form->createElement(
    "text","ey","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[ey]','form_ex_day[em]',4)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","em","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_ex_day[em]','form_ex_day[ed]',2)\"".$g_form_option."\"");
$form_expected_day[] =& $form->createElement("static","","","-");
$form_expected_day[] =& $form->createElement(
    "text","ed","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup( $form_expected_day,"form_ex_day","");

//表示 display
$form->addElement("submit","form_show_button","表　示");

//クリア clear
$form->addElement("button","form_clear_button","クリア","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");

// 棚卸調査表リンクボタン stocktaking survey chart link button
$form->addElement("button", "4_201_button", "棚卸調査表", "onClick=\"location.href('./1-4-201.php');\"");

// 棚卸実績一覧リンクボタン stocktaking result list link button
$form->addElement("button", "4_205_button", "棚卸実績一覧", "$g_button_color onClick=\"location.href('".$_SERVER["PHP_SELF"]."');\"");

$form->addElement("hidden", "h_invent_no");          //検索条件の調査票番号 survey slip number of the search condition
$form->addElement("hidden", "h_ex_start");           //検索条件の棚卸開始日 start date of the stocktaking of the search condition
$form->addElement("hidden", "h_ex_end");             //検索条件の棚卸終了日 end date of the stocktaking of the search condition

/****************************/
//ページ数情報取得 acquire the page number info
/****************************/
$page_count  = $_POST["f_page1"];       //現在のページ数 current page number
if($page_count == NULL){
    $offset = 0;
}else{
    $offset = $page_count * 100 - 100;   
}

/****************************/
//表示ボタン押下処理 display button pressed process
/****************************/
if($_POST["form_show_button"] == "表　示"){
    //現在のページ数初期化 initialize the current page number
    $page_count = null;
    $offset = 0;

    /****************************/
    //POST情報取得 acquire the post information
    /****************************/
    //調査表番号 survey chsart number
    if($_POST["form_invent_no"] != NULL){
        $invent_no = $_POST["form_invent_no"];  
        $invent_data["h_invent_no"] = stripslashes($invent_no);
        $form->setConstants($invent_data);
    }
    //棚卸開始日 stocktaking start date
    if($_POST["form_ex_day"]["sy"] != NULL && $_POST["form_ex_day"]["sm"] != NULL && $_POST["form_ex_day"]["sd"] != NULL){
		$base_date_y = str_pad($_POST["form_ex_day"]["sy"],4, 0, STR_PAD_LEFT);  
		$base_date_m = str_pad($_POST["form_ex_day"]["sm"],2, 0, STR_PAD_LEFT); 
		$base_date_d = str_pad($_POST["form_ex_day"]["sd"],2, 0, STR_PAD_LEFT); 
        $ex_start = $base_date_y."-".$base_date_m."-".$base_date_d;
        $start_data["h_ex_start"] = stripslashes($ex_start);
        $form->setConstants($start_data);
    }
    //棚卸終了日 stocktaking end date
    if($_POST["form_ex_day"]["ey"] != NULL && $_POST["form_ex_day"]["em"] != NULL && $_POST["form_ex_day"]["ed"] != NULL){
		$base_date_ey = str_pad($_POST["form_ex_day"]["ey"],4, 0, STR_PAD_LEFT);  
		$base_date_em = str_pad($_POST["form_ex_day"]["em"],2, 0, STR_PAD_LEFT); 
		$base_date_ed = str_pad($_POST["form_ex_day"]["ed"],2, 0, STR_PAD_LEFT); 
        $ex_end = $base_date_ey."-".$base_date_em."-".$base_date_ed;
        $end_data["h_ex_end"] = stripslashes($ex_end);
        $form->setConstants($end_data);
    }

//表示ボタンが押されていない場合（ページ処理） if the display button is not pressed (page process)
}else if(count($_POST) > 0 && $_POST["form_show_button"] != "表　示"){

    /****************************/
    //POST情報取得 acquire post info 
    /****************************/
    if($_POST["h_invent_no"] != NULL){
        $invent_no = $_POST["h_invent_no"];  //棚卸調査番号 stocktaking survey number
    }
    //棚卸開始日 stocktaking start date
    if($_POST["h_ex_start"] != NULL){
        $ex_start = $_POST["h_ex_start"];
    }
    //棚卸終了日 stocktakin end date
    if($_POST["h_ex_end"] != NULL){
        $ex_end   = $_POST["h_ex_end"];
    }
}

/****************************/
//エラーチェック(PHP) error check
/****************************/
$error_flg = false;             //エラー判定フラグ error decision flag
//◇棚卸開始日 start stocktaking date
//・日付妥当性チェック check the valiidity of the date
if($_POST["form_ex_day"]["sy"] != null || $_POST["form_ex_day"]["sm"] != null || $_POST["form_ex_day"]["sd"] != null){

	//数値判定 determine the value
	if(!ereg("^[0-9]{4}$",$_POST["form_ex_day"]["sy"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["sm"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["sd"])){
		$error = "棚卸日(開始)の日付は妥当ではありません。";
        $error_flg = true;
	}

    $day_y = (int)$_POST["form_ex_day"]["sy"];
    $day_m = (int)$_POST["form_ex_day"]["sm"];
    $day_d = (int)$_POST["form_ex_day"]["sd"];
    if(!checkdate($day_m,$day_d,$day_y)){
        $error = "棚卸日(開始)の日付は妥当ではありません。";
        $error_flg = true;
    }
}

//◇棚卸開始日 start date of the stocktaking
//・日付妥当性チェック check date valdity
if($_POST["form_ex_day"]["ey"] != null || $_POST["form_ex_day"]["em"] != null || $_POST["form_ex_day"]["ed"] != null){

	//数値判定 determine the value
	if(!ereg("^[0-9]{4}$",$_POST["form_ex_day"]["ey"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["em"]) || !ereg("^[0-9]{2}$",$_POST["form_ex_day"]["ed"])){
		$error = "棚卸日(終了)の日付は妥当ではありません。";
        $error_flg = true;
	}

    $day_y = (int)$_POST["form_ex_day"]["ey"];
    $day_m = (int)$_POST["form_ex_day"]["em"];
    $day_d = (int)$_POST["form_ex_day"]["ed"];
    if(!checkdate($day_m,$day_d,$day_y)){
        $error = "棚卸日(終了)の日付は妥当ではありません。";
        $error_flg = true;
    }
}

/****************************/
//棚卸実績データ取得SQL SQL that acquire stocktaking result data
/****************************/
//エラーの場合は表示を行なわない do not display if error
if($error_flg == false){
    $sql  = "SELECT DISTINCT ";
    $sql .= "    expected_day,";           //棚卸日 stocktaking date
    $sql .= "    invent_no ";              //調査表番号 stocktaking chart number
    $sql .= "FROM ";
    $sql .= "    t_invent ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    renew_flg = 't' ";
    //棚卸日時が指定されているか is the stocktaking date assigned
    if($ex_start != NULL){
        $sql .= "    AND ";
        $sql .= "        expected_day >= '$ex_start' ";
    }
    if($ex_end != NULL){
        $sql .= "    AND ";
        $sql .= "        expected_day <= '$ex_end' ";
    }
    //調査番号が指定されている場合 if the survey nnumber is assigned
    if($invent_no != NULL){
        $sql .= "    AND ";
        $sql .= "        invent_no LIKE '%$invent_no%' ";
    }
    $sql .= "ORDER BY ";
    $sql .= "    invent_no DESC ";

    $result = Db_Query($db_con,$sql."LIMIT 100 OFFSET $offset;");
    $page_data = Get_Data($result);

    $result = Db_Query($db_con,$sql.";");
    //全件数 all items
    $total_count = pg_num_rows($result);

    //表示範囲指定 assign the display area
    $range = "100";
    
}else{
    //全件数 all items
    $total_count = 0;
    //表示範囲指定 assign the display area
    $range = "100";
}

/****************************/
//HTMLヘッダ header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成 create menu
/****************************/
$page_menu = Create_Menu_h('stock','2');
/****************************/
//画面ヘッダー作成 create screen header
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex["4_201_button"]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex["4_205_button"]]->toHtml();
$page_header = Create_Header($page_title);

/****************************/
//ページ作成 create page
/****************************/
$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);


// Render関連の設定 render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign assign the form related variables
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign assign the other variblaes
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'error'         => "$error",
	'ex_start'      => "$ex_start",
	'ex_end'        => "$ex_end",
));

$smarty->assign('row',$page_data);
//テンプレートへ値を渡す pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
