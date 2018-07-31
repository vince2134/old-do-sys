<?php
$page_title = "予定データ照会";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/*****************************/
//外部変数取得
/*****************************/
$shop_id    = $_SESSION["client_id"];       //取引先ID

/*****************************/
//フォーム作成
/*****************************/
//伝票番号
$form->addElement(
    "text","form_slip_no","",
    "size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
     onFocus=\"onForm(this)\"
     onBlur=\"blurForm(this)\""
);

//配送日(開始)
$form_ord_day[] =& $form->createElement(
        "text","sy","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[sy]', 'form_ord_day[sm]',4)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);

$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","sm","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[sm]', 'form_ord_day[sd]',2)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","sd","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onkeyup=\"changeText(this.form,'form_ord_day[sd]','form_ord_day[ey]',2)\"
        onFocus=\"onForm(this)\"
        onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","〜");
//配送日(終了)
$form_ord_day[] =& $form->createElement(
        "text","ey","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[ey]', 'form_ord_day[em]',4)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","em","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_ord_day[em]', 'form_ord_day[ed]',2)\"
         onFocus=\"onForm(this)\"
         onBlur=\"blurForm(this)\""
);
$form_ord_day[] =& $form->createElement("static","","","-");
$form_ord_day[] =& $form->createElement(
        "text","ed","","size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
        onFocus=\"onForm(this)\" 
        onBlur=\"blurForm(this)\""
);
$form->addGroup( $form_ord_day,"form_ord_day","");

//巡回担当
$form_c_staff_id = Select_Get($db_con,'cstaff');
$form->addElement('select', 'form_staff', 'セレクトボックス', $form_c_staff_id, $g_form_option_select);

//表示ボタン
$form->addElement("submit","form_show_button","表　示","
        onClick=\"javascript:Which_Type('form_output_type','1-2-207.php','# ');\""
);

//クリア
$form->addElement("button","form_clear_button","クリア",
        "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);

//入力値記憶用hidden
$form->addElement("hidden","hdn_slip_no");                                  //伝票番号
$form->addElement("hidden","hdn_ord_day_sy");                               //配送日（開始）年
$form->addElement("hidden","hdn_ord_day_sm");                               //配送日（開始）月
$form->addElement("hidden","hdn_ord_day_sd");                               //配送日（開始）日
$form->addElement("hidden","hdn_ord_day_ey");                               //配送日（開始）年
$form->addElement("hidden","hdn_ord_day_em");                               //配送日（開始）月
$form->addElement("hidden","hdn_ord_day_ed");                               //配送日（開始）日
$form->addElement("hidden","hdn_staff");                                    //巡回担当者

/****************************/
//当日日付
/****************************/
$date = date("Y-m-d");                                                      //当日日付

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_show_button"] == "表　示"){
	//現在のページ数初期化
    $page_count = null;
    $offset = 0;

    /******************************/
    //POST情報取得
    /******************************/
    $ord_day_sy  = $_POST["form_ord_day"]["sy"];                      //配送日開始（年）
    $ord_day_sm  = $_POST["form_ord_day"]["sm"];                      //配送日開始（月）
    $ord_day_sd  = $_POST["form_ord_day"]["sd"];                      //配送日開始（日）
	if($ord_day_sy != NULL && $ord_day_sm != NULL && $ord_day_sd != NULL){
		$sday = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;        
	}
	$ord_day_ey  = $_POST["form_ord_day"]["ey"];                      //配送日終了（年）
    $ord_day_em  = $_POST["form_ord_day"]["em"];                      //配送日終了（月）
    $ord_day_ed  = $_POST["form_ord_day"]["ed"];                      //配送日終了（日）
	if($ord_day_ey != NULL && $ord_day_em != NULL && $ord_day_ed != NULL){
		$eday = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;        
	}
    $slip_no      = $_POST["form_slip_no"];                           //伝票番号
    $staff_id     = $_POST["form_staff"];                             //巡回担当者

    $post_flg       = true;                                           //POSTフラグ
/****************************/
//ページ分けリンク押下処理
/****************************/
}elseif(count($_POST)>0 && $_POST["form_show_button"] != "表　示"){

	$page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;

    /******************************/
    //POST情報取得
    /******************************/
    $ord_day_sy  = $_POST["hdn_ord_day_sy"];                      //配送日開始（年）
    $ord_day_sm  = $_POST["hdn_ord_day_sm"];                      //配送日開始（月）
    $ord_day_sd  = $_POST["hdn_ord_day_sd"];                      //配送日開始（日）
	if($ord_day_sy != NULL && $ord_day_sm != NULL && $ord_day_sd != NULL){
		$sday = $ord_day_sy."-".$ord_day_sm."-".$ord_day_sd;        
	}
	$ord_day_ey  = $_POST["hdn_ord_day_ey"];                      //配送日終了（年）
    $ord_day_em  = $_POST["hdn_ord_day_em"];                      //配送日終了（月）
    $ord_day_ed  = $_POST["hdn_ord_day_ed"];                      //配送日終了（日）
	if($ord_day_ey != NULL && $ord_day_em != NULL && $ord_day_ed != NULL){
		$eday = $ord_day_ey."-".$ord_day_em."-".$ord_day_ed;        
	}
    $slip_no      = $_POST["hdn_slip_no"];                           //伝票番号
    $staff_id     = $_POST["hdn_staff"];                             //巡回担当者

    $post_flg       = true;                                           //POSTフラグ
}

/****************************/
//POSTがあれば
/****************************/
if($post_flg == true){
 
    /****************************/
    //エラーチェック(PHP)
    /****************************/
	$error_flg = false;            //エラー判定フラグ

	//◇配送日
    //・文字種チェック
    if($ord_day_sy != null || $ord_day_sm != null || $ord_day_sd != null){
        $day_sy = (int)$ord_day_sy;
        $day_sm = (int)$ord_day_sm;
        $day_sd = (int)$ord_day_sd;
        if(!checkdate($day_sm,$day_sd,$day_sy)){
			$error_msg = "配送日開始 の日付は妥当ではありません。";
			$error_flg = true;
        }
    }
	if($ord_day_ey != null || $ord_day_em != null || $ord_day_ed != null){
        $day_ey = (int)$ord_day_ey;
        $day_em = (int)$ord_day_em;
        $day_ed = (int)$ord_day_ed;
        if(!checkdate($day_em,$day_ed,$day_ey)){
			$error_msg2 = "配送日終了 の日付は妥当ではありません。";
			$error_flg = true;
        }
    }

    /******************************/
    //値検証
    /******************************/
    if($error_flg == false){
   
        /*******************************/
        //検索条件をhiddenにセット
        /*******************************/
        $def_data["form_ord_day"]["sy"]      = $ord_day_sy;               
        $def_data["form_ord_day"]["sm"]      = $ord_day_sm;               
        $def_data["form_ord_day"]["sd"]      = $ord_day_sd;          
		$def_data["form_ord_day"]["ey"]      = $ord_day_ey;               
        $def_data["form_ord_day"]["em"]      = $ord_day_em;               
        $def_data["form_ord_day"]["ed"]      = $ord_day_ed;          
        $def_data["form_slip_no"]            = $slip_no;  
		$def_data["form_staff"]              = $staff_id;          

        $def_data["hdn_ord_day_sy"]      = stripslashes($ord_day_sy);               
        $def_data["hdn_ord_day_sm"]      = stripslashes($ord_day_sm);               
        $def_data["hdn_ord_day_sd"]      = stripslashes($ord_day_sd);          
		$def_data["hdn_ord_day_ey"]      = stripslashes($ord_day_ey);               
        $def_data["hdn_ord_day_em"]      = stripslashes($ord_day_em);               
        $def_data["hdn_ord_day_ed"]      = stripslashes($ord_day_ed);          
        $def_data["hdn_slip_no"]         = stripslashes($slip_no);  
		$def_data["hdn_staff"]           = stripslashes($staff_id);          
        $def_data["show_button_flg"]            = "";
        $form->setConstants($def_data); 

        /****************************/
        //WHERE_SQL 作成
        /****************************/
		$where_sql = NULL;
        //伝票番号が指定された場合
        if($slip_no != null){
            $where_sql .= " AND t_aorder_h.ord_no LIKE '$slip_no%' ";
        }

		//配送日（開始）が指定された場合
        if($sday != null){
            $where_sql  = " AND '$sday' <= t_aorder_h.ord_time ";
        }

        //配送日（終了）が指定された場合
        if($eday != null){
            $where_sql  = " AND t_aorder_h.ord_time < '$eday' ";
        }

        //巡回担当者が指定された場合
        if($staff_id != null){
            $where_sql .= " AND (";
			$where_sql .= "  t_aorder_h.d_staff_id1 = $staff_id ";
			$where_sql .= " OR ";
			$where_sql .= "  t_aorder_h.d_staff_id2 = $staff_id ";
			$where_sql .= " OR ";
			$where_sql .= "  t_aorder_h.d_staff_id3 = $staff_id ";
			$where_sql .= " OR ";
			$where_sql .= "  t_aorder_h.d_staff_id4 = $staff_id ) ";
        }
    }
}

/****************************/
//SQL作成
/****************************/
$sql  = "SELECT DISTINCT ";
$sql .= "    t_aorder_h.ord_no,";        //受注ID
$sql .= "    t_aorder_h.aord_id,";       //伝票番号
$sql .= "    t_aorder_h.ord_time,";      //配送日
$sql .= "    t_client.client_name,";     //得意先名
$sql .= "    t_trade.trade_id,";         //取引区分コード
$sql .= "    t_aorder_h.net_amount,";    //売上金額
$sql .= "    t_staff1.staff_name,";      //担当者１
$sql .= "    t_staff2.staff_name,";      //担当者２
$sql .= "    t_staff3.staff_name,";      //担当者３
$sql .= "    t_staff4.staff_name ";      //担当者４
$sql .= "FROM ";
$sql .= "    t_aorder_h ";

$sql .= "    INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id ";
$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
$sql .= "    INNER JOIN t_trade ON t_trade.trade_id = t_aorder_h.trade_id ";

$sql .= "    LEFT JOIN t_staff AS t_staff1 ON t_staff1.staff_id = t_aorder_h.d_staff_id1 "; 
$sql .= "    LEFT JOIN t_staff AS t_staff2 ON t_staff2.staff_id = t_aorder_h.d_staff_id2 "; 
$sql .= "    LEFT JOIN t_staff AS t_staff3 ON t_staff3.staff_id = t_aorder_h.d_staff_id3 "; 
$sql .= "    LEFT JOIN t_staff AS t_staff4 ON t_staff4.staff_id = t_aorder_h.d_staff_id4 "; 

$sql .= "WHERE";
$sql .= "    t_aorder_h.shop_id = $shop_id ";
$sql .= "    AND ";
$sql .= "    t_aorder_d.contract_id IS NOT NULL ";
$sql .= $where_sql;
$sql .= "ORDER BY ";
$sql .= "    t_aorder_h.ord_no ";
//ヒット件数
$total_sql = $sql.";";
$result = Db_Query($db_con,$total_sql);
$total_count = pg_num_rows($result);

//OFFSET作成
if($page_count != null){
    $offset = $page_count * 100 - 100;}
else{
    $offset = 0;
}

$sql .= " LIMIT 100 OFFSET $offset";
$sql .= ";";

$result = Db_Query($db_con, $sql);
$page_data = Get_Data($result);

//形式変更
for($i=0;$i<count($page_data);$i++){
	//金額形式変更
	$page_data[$i][5] = number_format($page_data[$i][5]);
	//巡回担当表示判定
	for($c=7;$c<=9;$c++){
		//値が入力されている場合は、メイン以外は改行を追加
		if($page_data[$i][$c] != NULL){
			$page_data[$i][$c] = "<br>".$page_data[$i][$c];
		}
	}
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
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

/****************************/
//ページ作成
/****************************/
//表示範囲指定
$range = "100";

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
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
	'error_msg'     => "$error_msg",
	'error_msg2'    => "$error_msg2",
));

$smarty->assign("page_data",$page_data);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
