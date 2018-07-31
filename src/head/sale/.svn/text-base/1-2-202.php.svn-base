<?php

/*
 * 履歴：
 * 　日付　　　　B票No.　　　　担当者　　　内容　
 * 　2006/10/31　08-052　　　　fukuda-s  　検索の日付フォームにフォーカスを合わせても日付がセットされないバグの修正
 * 　2006/11/09　08-143　　　　watanabe-k　得意先名が略称で表示されていないバグの修正
 *   2006/11/09  08-151        suzuki      エラー時にはデータを表示しない
 *   2006/12/07  ban_0049      suzuki      日付をゼロ埋め
 *   2006/12/07  ban_0050      suzuki      売上ID抽出処理修正
 *   2007/01/25                watanabe-k  売上伝票一括発行
 *   2007/03/19                watanabe-k  再発行処理追加
 *   2007-05-07                fukuda      ソート順を日付の昇順に変更
 *
 */



$page_title = "売上伝票一括発行";

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
$s_client_id  = $_SESSION[client_id];

/****************************/
//デフォルト値設定
/****************************/
$def_fdata = array(
    "form_slip_type"        => "1",
    "form_order_slip"       => "1",
    "form_renew"            => "1",
);
$form->setDefaults($def_fdata);

/****************************/
//フォーム作成
/****************************/
//伝票形式
$radio = "";
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "通常伝票","1"
);
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "指定伝票","2"
);
$form->addGroup($radio, "form_slip_type", "伝票形式");

//発行状況
$radio = "";
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "全て","1"
);
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "発行済","2"
);
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "未発行","3"
);
$form->addGroup($radio, "form_order_slip", "発行状況");

//取引区分
$select_value = Select_Get($db_con,'trade_sale');
$form->addElement(
    'select', 'form_trade_sale', 'セレクトボックス', 
    $select_value,$g_form_option_select
);

//日次更新
$radio = "";
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "指定なし","1"
);
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "実施済","2"
);
$radio[] =& $form->createElement( 
    "radio",NULL,NULL, "未実施","3"
);
$form->addGroup($radio, "form_renew", "日次更新");

//伝票番号
$form->addElement(
    "text","form_slip_no","テキストフォーム","size=\"10\" style=\"$g_form_style\" maxLength=\"8\" 
    ".$g_form_option."\""
);

//売上計上日
$text = "";

$text[] =& $form->createElement("text", "start_y", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[start_y]','form_sale_day[start_m]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[start_y]','form_sale_day[start_m]','form_sale_day[start_d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "start_m", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[start_m]','form_sale_day[start_d]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[start_y]','form_sale_day[start_m]','form_sale_day[start_d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "start_d", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[start_d]','form_sale_day[end_y]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[start_y]','form_sale_day[start_m]','form_sale_day[start_d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static","",""," 〜 ");
$text[] =& $form->createElement("text", "end_y", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[end_y]','form_sale_day[end_m]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[end_y]','form_sale_day[end_m]','form_sale_day[end_d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "end_m", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_sale_day[end_m]','form_sale_day[end_d]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[end_y]','form_sale_day[end_m]','form_sale_day[end_d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "end_d", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm_today(this,this.form,'form_sale_day[end_y]','form_sale_day[end_m]','form_sale_day[end_d]')\"
         onBlur=\"blurForm(this)\""
);
$form->addGroup( $text,"form_sale_day","売上計上日");

//得意先コード
$text = "";
$text[] = $form->createElement(
    "text","cd1","",
    "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"
    onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\" 
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\""
);
$text[] = $form->createElement("static","","","-");
$text[] = $form->createElement(
    "text","cd2","",
    "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\""
);
$form->addGroup( $text, "form_client_cd", "得意先コード");

//得意先名
$form->addElement(
    "text","form_client_name","",
    "size=\"34\" maxLength=\"15\" 
    onFocus=\"onForm(this)\" 
    onBlur=\"blurForm(this)\""
);

//表示ボタン
$form->addElement(
    "submit","form_show_button","表　示"
);

//クリアボタン
$form->addElement(
    "button","form_clear_button","クリア",
    "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\""
);


//売上伝票一括発行
$form->addElement(
    "button","sale_button","売上伝票一括発行",
    $g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\""
);
//入力・変更
$form->addElement(
    "button","new_button","入力・変更",
    "onClick=\"javascript:Referer('1-2-201.php')\""
);
//照会
$form->addElement(
    "button","change_button","照　会",
    "onClick=\"javascript:Referer('1-2-203.php')\""
);

//hidden
$form->addElement("hidden","form_h_slip_no");
$form->addElement("hidden","form_h_sale_sday");
$form->addElement("hidden","form_h_sale_eday");
$form->addElement("hidden","form_h_client_cd1");
$form->addElement("hidden","form_h_client_cd2");
$form->addElement("hidden","form_h_client_name");
$form->addElement("hidden","form_h_slip_type");
$form->addElement("hidden","form_h_order_slip");
$form->addElement("hidden","form_h_renew");
$form->addElement("hidden","form_h_trade_sale");

//伝票発行ボタン押下フラグ
$form->addElement("hidden","slip_button_flg");

/****************************/
//表示ボタン押下処理
/****************************/
if($_POST["form_show_button"] == "表　示"){
    $page_count = null;
    $offset = 0;
    $slip_no          = $_POST["form_slip_no"];                  //伝票番号
    $sale_sday        = str_pad($_POST["form_sale_day"]["start_y"],4,"0",STR_PAD_LEFT);      //売上計上日(開始年)
    $sale_sday       .= "-"; 
    $sale_sday       .= str_pad($_POST["form_sale_day"]["start_m"],2,"0",STR_PAD_LEFT);      //売上計上日(開始月)
    $sale_sday       .= "-"; 
    $sale_sday       .= str_pad($_POST["form_sale_day"]["start_d"],2,"0",STR_PAD_LEFT);      //売上計上日(開始日)
    $sale_eday        = str_pad($_POST["form_sale_day"]["end_y"],4,"0",STR_PAD_LEFT);        //売上計上日(終了年)
    $sale_eday       .= "-"; 
    $sale_eday       .= str_pad($_POST["form_sale_day"]["end_m"],2,"0",STR_PAD_LEFT);        //売上計上日(終了月)
    $sale_eday       .= "-"; 
    $sale_eday       .= str_pad($_POST["form_sale_day"]["end_d"],2,"0",STR_PAD_LEFT);        //売上計上日(終了日)
    $client_cd1       = $_POST["form_client_cd"]["cd1"];         //得意先コード１
    $client_cd2       = $_POST["form_client_cd"]["cd2"];         //得意先コード２
    $client_name      = $_POST["form_client_name"];              //得意先名
    $slip_type        = $_POST["form_slip_type"];                //伝票形式
    $order_slip       = $_POST["form_order_slip"];               //発行状況
    $renew            = $_POST["form_renew"];                    //日次更新
    $trade_sale       = $_POST["form_trade_sale"];               //取引区分



    //ルール作成
    //売上計上日(開始)
    //●半角チェック
    $form->addGroupRule('form_sale_day', array(
            'start_y' => array(
                    array('売上計上日の日付は妥当ではありません。','numeric')
            ),
            'start_m' => array(
                    array('売上計上日の日付は妥当ではありません。','numeric')
            ),
            'start_d' => array(
                    array('売上計上日の日付は妥当ではありません。','numeric')
            ),
            'end_y' => array(
                    array('売上計上日の日付は妥当ではありません。','numeric')
            ),  
            'end_m' => array(
                    array('売上計上日の日付は妥当ではありません。','numeric')
            ),
            'end_d' => array(
                    array('売上計上日の日付は妥当ではありません。','numeric')
            )
    ));

    /****************************/
    //エラーチェック(PHP)
    /****************************/
    if(!($_POST["form_sale_day"]["start_y"] == null 
    && $_POST["form_sale_day"]["start_m"] == null 
    && $_POST["form_sale_day"]["start_d"] == null 
    || $_POST["form_sale_day"]["start_y"] != null 
    && $_POST["form_sale_day"]["start_m"] != null 
    && $_POST["form_sale_day"]["start_d"] != null)){
        $sale_day_error = "売上計上日が妥当ではありません。";
        $err_flg = true;
    }

    if(!($_POST["form_sale_day"]["end_y"] == null 
    && $_POST["form_sale_day"]["end_m"] == null 
    && $_POST["form_sale_day"]["end_d"] == null 
    || $_POST["form_sale_day"]["end_y"] != null 
    && $_POST["form_sale_day"]["end_m"] != null 
    && $_POST["form_sale_day"]["end_d"] != null)){
        $sale_day_error = "売上計上日が妥当ではありません。";
        $err_flg = true;
    }
    //■売上計上日
    //●日付の妥当性チェック
    $sale_sday_y = (int)$_POST["form_sale_day"]["start_y"];
    $sale_sday_m = (int)$_POST["form_sale_day"]["start_m"];
    $sale_sday_d = (int)$_POST["form_sale_day"]["start_d"];
    $sale_eday_y = (int)$_POST["form_sale_day"]["end_y"];
    $sale_eday_m = (int)$_POST["form_sale_day"]["end_m"];
    $sale_eday_d = (int)$_POST["form_sale_day"]["end_d"];

    $check_sale_sday = checkdate($sale_sday_m,$sale_sday_d,$sale_sday_y);
    if($check_sale_sday == false && $sale_sday != "0000-00-00"){
        $sale_day_error = "売上計上日が妥当ではありません。";
        $err_flg = true;
    }

    $check_sale_eday = checkdate($sale_eday_m,$sale_eday_d,$sale_eday_y);
    if($check_sale_eday == false && $sale_eday != "0000-00-00"){
        $sale_day_error = "売上計上日が妥当ではありません。";
        $err_flg = true;
    }
    
    //検証
    if($form->validate() && $err_flg != true){
        $post_flg = true;
    }
//ページ分けリンク押下処理
}else if(count($_POST) > 0 && $_POST["form_show_button"] != "表　示"){
    //ページ数
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
    $slip_no           =  $_POST["form_h_slip_no"];           //伝票番号
    $sale_sday         =  $_POST["form_h_sale_sday"];         //売上計上日(開始)
    $sale_eday         =  $_POST["form_h_sale_eday"];         //売上計上日(終了)
    $client_cd1        =  $_POST["form_h_client_cd1"];        //得意先コード１
    $client_cd2        =  $_POST["form_h_client_cd2"];        //得意先コード２
    $client_name       =  $_POST["form_h_client_name"];       //得意先名
    $slip_type         =  $_POST["form_h_slip_type"];         //伝票形式
    $order_slip        =  $_POST["form_h_order_slip"];        //発行状況
    $renew             =  $_POST["form_h_renew"];             //日次更新
    $trade_sale        =  $_POST["form_h_trade_sale"];        //取引区分

    if($_POST["slip_button_flg"] != true){
        $post_flg = true;
    }
}else{  
    $offset = 0;
    $renew  = '1';
    $slip_type = '1';
    $order_slip = '1';
    $post_flg = true;
}

/***************************/
//伝票発行ボタンが押された場合
/***************************/
if($_POST["output_slip_button"] == "伝票発行" || $_POST["output_re_slip_button"] == "再発行"){

    $slip_button_flg = true;                                  //伝票発行ボタンフラグ

    if($_POST["output_slip_button"] == "伝票発行"){
        $ary_check_id = $_POST["slip_check"];
    }else{
        $ary_check_id = $_POST["re_slip_check"];
    }

    //チェックされている伝票のIDをカンマ区切り（SQLで使用）
    if(count($ary_check_id) > 0){


		$sale_id = NULL;    //伝票出力ID配列
		$i = 0;
		while($check_num = each($ary_check_id)){
			//この添字のIDを使用する
			$check = $check_num[0];
			if($check_num[1] != NULL && $check_num[1] != "f"){
				if($i == 0){
					$sale_id = $ary_check_id[$check];
				}else{
					$sale_id .= ",".$ary_check_id[$check];
				}
				$i++;
			}
		}
/*
        for($i = 0; $i < count($_POST[slip_check]); $i++){
            if($j > 0 && $_POST["slip_check"][$i] != null){
                $sale_id         .= ",".$_POST["slip_check"][$i];     //チェックボックス
            }elseif($_POST["slip_check"][$i] != null){
                $sale_id         = $_POST["slip_check"][$i];     //チェックボックス
                $j = 1;
            } 
        }
*/
		//チェック存在判定
		if($sale_id != NULL){
			//チェックあり
        	$check_flg       = true;
		}else{
			//チェックなし
			$error = "発行する伝票が一つも選択されていません。";
        	$check_flg       = false;
		}
    }else{
        $error = "発行する伝票が一つも選択されていません。";
        $check_flg       = false;
    }

    //チェックがあった場合
    if($check_flg == true){

        Db_Query($db_con, "BEGIN");

        $sql  = "UPDATE t_sale_h SET";
        $sql .= "   slip_flg = 't', ";
        $sql .= "   slip_out_day = NOW() ";
        $sql .= "WHERE";
        $sql .= "   t_sale_h.sale_id IN ($sale_id)";
        $sql .= "   AND";
        $sql .= "   slip_flg ='f' ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK");
        }
        Db_Query($db_con, "COMMIT");
    }
}

if($post_flg == true){
    //日付を分割
    $exp_sale_sday = explode('-', $sale_sday);
    $exp_sale_eday = explode('-', $sale_eday);

    $set_data["form_slip_no"]             =  stripslashes($slip_no);           //伝票番号
    $set_data["form_client_cd"]["cd1"]    =  stripslashes($client_cd1);        //得意先CD１
    $set_data["form_client_cd"]["cd2"]    =  stripslashes($client_cd2);        //得意先CD２
    $set_data["form_client_name"]         =  stripslashes($client_name);       //得意先名
    $set_data["form_slip_type"]           =  stripslashes($slip_type);         //伝票出力形式
    $set_data["form_order_slip"]          =  stripslashes($order_slip);        //発行状況
    $set_data["form_renew"]               =  stripslashes($renew);             //日時更新
    $set_data["form_trade_sale"]          =  stripslashes($trade_sale);        //取引区分          
    $set_data["form_h_slip_no"]           =  stripslashes($slip_no);           //伝票番号
	if(stripslashes($sale_sday) != "0000-00-00"){
		$set_data["form_sale_day"]["start_y"] =  stripslashes($exp_sale_sday[0]);  //売上計上日（年）
	    $set_data["form_sale_day"]["start_m"] =  stripslashes($exp_sale_sday[1]);  //売上計上日（月）
	    $set_data["form_sale_day"]["start_d"] =  stripslashes($exp_sale_sday[2]);  //売上計上日（日）
    	$set_data["form_h_sale_sday"]         =  stripslashes($sale_sday);         //売上計上日(開始)
	}
	if(stripslashes($sale_eday) != "0000-00-00"){
		$set_data["form_sale_day"]["end_y"]   =  stripslashes($exp_sale_eday[0]);  //売上計上日（年）
	    $set_data["form_sale_day"]["end_m"]   =  stripslashes($exp_sale_eday[1]);  //売上計上日（月）
	    $set_data["form_sale_day"]["end_d"]   =  stripslashes($exp_sale_eday[2]);  //売上計上日（日）
    	$set_data["form_h_sale_eday"]         =  stripslashes($sale_eday);         //売上計上日(終了)
    }
	$set_data["form_h_client_cd1"]        =  stripslashes($client_cd1);        //得意先コード１
    $set_data["form_h_client_cd2"]        =  stripslashes($client_cd2);        //得意先コード２
    $set_data["form_h_client_name"]       =  stripslashes($client_name);       //得意先名
    $set_data["form_h_slip_type"]         =  stripslashes($slip_type);         //伝票形式
    $set_data["form_h_order_slip"]        =  stripslashes($order_slip);        //発行状況
    $set_data["form_h_renew"]             =  stripslashes($renew);             //日次更新
    $set_data["form_h_trade_sale"]        =  stripslashes($trade_sale);        //取引区分
}

//毎回初期化
//$set_data["slip_button_flg"]          =  "";                 //伝票発行ボタン押下フラグ
$set_data["slip_check_all"]           =  "";                 //全チェック
$form->setConstants($set_data);


//post_flgがtrueかつ、エラーがない場合
if($post_flg == true ){

    //日時更新実施
    if($renew != '3'){

        //伝票番号が指定された場合
        if($slip_no != null){
            $slip_no_sql  = " AND t_sale_h.sale_no LIKE '$slip_no%'";
        }

        //売上計上日（開始）が指定された場合
        if($sale_sday != null && $sale_sday != "0000-00-00"){
            $sale_sday_sql  = " AND '$sale_sday' <= t_sale_h.sale_day";
        }

        //売上計上日（終了）が指定された場合
        if($sale_eday != null && $sale_eday != "0000-00-00"){
            $sale_eday_sql  = " AND t_sale_h.sale_day <= '$sale_eday'";
        }

        //得意先コードが指定された場合
        if($client_cd1 != null){
            $client_cd1_sql  = " AND t_sale_h.client_cd1 LIKE '$client_cd1%'";
        }

        //得意先支店コードが指定された場合
        if($client_cd2 != null){
            $client_cd2_sql  = " AND t_sale_h.client_cd2 LIKE '$client_cd2%'";
        }

        //得意先名が指定された場合
        if($client_name != null){
            $client_name_sql  = " AND (t_sale_h.client_name LIKE '%$client_name%' ";
            $client_name_sql .= " OR t_sale_h.client_name2 LIKE '%$client_name%' ";
            $client_name_sql .= " OR t_sale_h.client_cname LIKE '%$client_name%')";
        }

        //取引区分が指定された場合
        if($trade_sale != null){
            $trade_sale_sql  = " AND t_sale_h.trade_id = $trade_sale";
        }

        //発行状況が指定された場合
        if($order_slip != '1'){
            if($order_slip == '2'){
                $order_slip_sql  = " AND t_sale_h.slip_flg = 't'";
            }else{
                $order_slip_sql  = " AND t_sale_h.slip_flg = 'f'";
            }
        }

        $where_aft_sql  = $slip_no_sql;
        $where_aft_sql .= $sale_sday_sql;
        $where_aft_sql .= $sale_eday_sql;
        $where_aft_sql .= $client_cd1_sql;
        $where_aft_sql .= $client_cd2_sql;
        $where_aft_sql .= $client_name_sql;
        $where_aft_sql .= $trade_sale_sql;
        $where_aft_sql .= $order_slip_sql;
    }

    //日時更新未実施 
    if($renew != '2'){
        //伝票番号が指定された場合
        if($slip_no != null){
            $slip_no_sql  = " AND t_sale_h.sale_no LIKE '$slip_no%'";
        }

        //売上計上日（開始）が指定された場合
        if($sale_sday != null && $sale_sday != "0000-00-00"){
            $sale_sday_sql  = " AND '$sale_sday' <= t_sale_h.sale_day";
        }

        //売上計上日（終了）が指定された場合
        if($sale_eday != null && $sale_eday != "0000-00-00"){
            $sale_eday_sql  = " AND t_sale_h.sale_day <= '$sale_eday'";
        }

        //得意先コードが指定された場合
        if($client_cd1 != null){
            $client_cd1_sql  = " AND t_sale_h.client_cd1 LIKE '$client_cd1%'";
        }

        //得意先支店コードが指定された場合
        if($client_cd2 != null){
            $client_cd2_sql  = " AND t_sale_h.client_cd2 LIKE '$client_cd2%'";
        }

        //得意先名が指定された場合
        if($client_name != null){
            $client_name_sql  = " AND (t_sale_h.client_name LIKE '%$client_name%' ";
            $client_name_sql .= " OR t_sale_h.client_name2 LIKE '%$client_name%' ";
            $client_name_sql .= " OR t_sale_h.client_cname LIKE '%$client_name%')";
        }

        //取引区分が指定された場合
        if($trade_sale != null){
            $trade_sale_sql  = " AND t_sale_h.trade_id = $trade_sale";
        }

        //発行状況が指定された場合
        if($order_slip != '1'){
            if($order_slip == '2'){
                $order_slip_sql  = " AND t_sale_h.slip_flg = 't'";
            }else{
                $order_slip_sql  = " AND t_sale_h.slip_flg = 'f'";
            }
        }

        $where_bfr_sql  = $slip_no_sql;
        $where_bfr_sql .= $sale_sday_sql;
        $where_bfr_sql .= $sale_eday_sql;
        $where_bfr_sql .= $client_cd1_sql;
        $where_bfr_sql .= $client_cd2_sql;
        $where_bfr_sql .= $client_name_sql;
        $where_bfr_sql .= $trade_sale_sql;
        $where_bfr_sql .= $order_slip_sql;
    }
}

/****************************/
//SQL作成
/****************************/
//日時更新前
if($renew != '3'){
    //伝票形式が指定伝票
    if($slip_button_flg == true && $check_flg == true){
        $sql  = "SELECT\n";
        $sql .= "    t_sale_h.sale_no,\n";
        $sql .= "    t_sale_h.sale_day,\n";
        $sql .= "    t_sale_h.client_name,\n";
        $sql .= "    t_sale_d.goods_name,\n";
        $sql .= "    t_sale_d.num,\n";
        $sql .= "    t_sale_d.unit,\n";
        $sql .= "    t_sale_d.cost_price,\n";
        $sql .= "    t_sale_d.cost_amount,\n";
        $sql .= "    CASE t_client.slip_out\n";
        $sql .= "       WHEN '1' THEN '有'\n";
        $sql .= "       WHEN '2' THEN '無'\n";
        $sql .= "    END AS slip_out_div,\n";
        $sql .= "    t_sale_h.slip_out_day ";
        $sql .= " FROM\n";
        $sql .= "    (SELECT\n";
        $sql .= "        t_sale_h.sale_id,\n";
        $sql .= "        t_sale_h.sale_no,\n";
        $sql .= "        t_sale_h.sale_day,\n";
        $sql .= "        t_sale_h.client_name,\n";
        $sql .= "        t_sale_h.client_id, \n";
        $sql .= "        t_sale_h.slip_out_day \n";
        $sql .= "     FROM\n";
        $sql .= "        t_sale_h\n";
        $sql .= "     WHERE\n";
        $sql .= "       t_sale_h.sale_id IN ($sale_id)\n";
        $sql .= "       AND\n";
        $sql .= "       t_sale_h.renew_flg = 't'\n";
        $sql .= "     GROUP BY\n";
        $sql .= "        t_sale_h.sale_id,\n";
        $sql .= "        t_sale_h.sale_no,\n";
        $sql .= "        t_sale_h.sale_day,\n";
        $sql .= "        t_sale_h.client_id,\n";
        $sql .= "        t_sale_h.client_cd1,\n";
        $sql .= "        t_sale_h.client_cd2,\n";
        $sql .= "        t_sale_h.client_name,\n";
        $sql .= "        t_sale_h.trade_id,\n";
        $sql .= "        t_sale_h.slip_flg,\n";
        $sql .= "        t_sale_h.renew_flg,\n";
        $sql .= "        t_sale_h.slip_out_day \n";
        $sql .= "    ) AS t_sale_h\n";
        $sql .= "        INNER JOIN\n";
        $sql .= "    t_sale_d\n";
        $sql .= "    ON t_sale_h.sale_id = t_sale_d.sale_id\n";
        $sql .= "        INNER JOIN\n";
        $sql .= "    t_client\n";
        $sql .= "    ON t_sale_h.client_id = t_client.client_id\n";
    //伝票形式が通常伝票
    }else{
        $sql  = " SELECT \n";
        $sql .= "    t_sale_h.sale_id,\n";
        $sql .= "    t_sale_h.sale_no,\n";
        $sql .= "    t_sale_h.sale_day,\n";
        $sql .= "    t_sale_h.client_cd1,\n";
        $sql .= "    t_sale_h.client_cd2,\n";
        $sql .= "    t_sale_h.client_cname,\n";
        $sql .= "    t_sale_h.trade_id,\n";
        $sql .= "    sum(t_sale_h.net_amount + t_sale_h.tax_amount) ,\n";
        $sql .= "    t_sale_h.slip_flg,\n";
        $sql .= "    t_sale_h.renew_flg,\n";
        $sql .= "    CASE t_client.slip_out\n";
        $sql .= "       WHEN '1' THEN '有'\n";
        $sql .= "       WHEN '2' THEN '無'\n";
        $sql .= "    END AS slip_out_div,\n";
        $sql .= "    t_sale_h.slip_out_day ";
        $sql .= " FROM\n";
        $sql .= "    t_sale_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "    t_client\n";
        $sql .= "    ON t_sale_h.client_id = t_client.client_id\n";
        $sql .= " WHERE\n";
        $sql .= "    t_sale_h.shop_id = $s_client_id\n";
        $sql .= "    AND\n";
        $sql .= "    t_sale_h.renew_flg = 't'\n";
        $sql .=      $where_aft_sql;
        $sql .= " GROUP BY t_sale_h.sale_id, \n";
        $sql .= "    t_sale_h.sale_no, \n";
        $sql .= "    t_sale_h.sale_day, \n";
        $sql .= "    t_sale_h.client_cd1, \n";
        $sql .= "    t_sale_h.client_cd2, \n";
        $sql .= "    t_sale_h.client_cname, \n";
        $sql .= "    t_sale_h.trade_id, \n";
        $sql .= "    t_sale_h.slip_flg, \n";
        $sql .= "    t_sale_h.renew_flg, \n";
        $sql .= "    slip_out_div,\n";
        $sql .= "    t_sale_h.slip_out_day ";
    }
}

//指定なしの場合
if($renew == '1' || ($slip_button_flg == true && $check_flg == true)){
    $sql .= " UNION ALL \n";
}

//日時更新後
if($renew != '2'){
    //伝票形式が指定伝票
    if($slip_button_flg == true && $check_flg == true){
        $sql .= "SELECT\n";
        $sql .= "    t_sale_h.sale_no,\n";
        $sql .= "    t_sale_h.sale_day,\n";
        $sql .= "    t_sale_h.client_name,\n";
        $sql .= "    t_sale_d.goods_name,\n";
        $sql .= "    t_sale_d.num,\n";
        $sql .= "    t_sale_d.unit,\n";
        $sql .= "    t_sale_d.cost_price,\n";
        $sql .= "    t_sale_d.cost_amount,\n";
        $sql .= "    CASE t_sale_h.slip_out\n";
        $sql .= "       WHEN '1' THEN '有'\n";
        $sql .= "       WHEN '2' THEN '無'\n";
        $sql .= "    END AS slip_out_div,\n";
        $sql .= "    t_sale_h.slip_out_day ";
        $sql .= " FROM\n";
        $sql .= "    (SELECT\n";
        $sql .= "        t_sale_h.sale_id,\n";
        $sql .= "        t_sale_h.sale_no,\n";
        $sql .= "        t_sale_h.sale_day,\n";
        $sql .= "        t_sale_h.client_name,\n";
        $sql .= "        t_client.slip_out, \n";
        $sql .= "        t_sale_h.slip_out_day ";
        $sql .= "     FROM\n";
        $sql .= "        t_sale_h\n";
        $sql .= "            INNER JOIN\n";
        $sql .= "        t_client\n";
        $sql .= "        ON t_sale_h.client_id = t_client.client_id\n";
        $sql .= "     WHERE\n";
        $sql .= "        t_sale_h.sale_id IN ($sale_id)\n";
        $sql .= "        AND\n";
        $sql .= "        t_sale_h.renew_flg = 'f'\n";
        $sql .= "     GROUP BY\n";
        $sql .= "        t_sale_h.sale_id,\n";
        $sql .= "        t_sale_h.sale_no,\n";
        $sql .= "        t_sale_h.sale_day,\n";
        $sql .= "        t_sale_h.client_cd1,\n";
        $sql .= "        t_sale_h.client_cd2,\n";
        $sql .= "        t_sale_h.client_name,\n";
        $sql .= "        t_sale_h.trade_id,\n";
        $sql .= "        t_client.slip_out,\n";
        $sql .= "        t_sale_h.slip_flg,\n";
        $sql .= "        t_sale_h.renew_flg,\n";
        $sql .= "        t_sale_h.slip_out_day \n";
        $sql .= "     ORDER BY sale_no DESC\n";
        $sql .= "    ) AS t_sale_h\n";
        $sql .= "        INNER JOIN\n";
        $sql .= "    t_sale_d\n";
        $sql .= "    ON t_sale_h.sale_id = t_sale_d.sale_id\n";
        $sql .= "        INNER JOIN\n";
        $sql .= "    t_goods\n";
        $sql .= "    ON t_sale_d.goods_id = t_goods.goods_id\n";
    //伝票形式が通常伝票
    }else{
        $sql .= " SELECT\n";
        $sql .= "    t_sale_h.sale_id,\n";
        $sql .= "    t_sale_h.sale_no,\n";
        $sql .= "    t_sale_h.sale_day,\n";
        $sql .= "    t_sale_h.client_cd1,\n";
        $sql .= "    t_sale_h.client_cd2,\n";
        $sql .= "    t_sale_h.client_cname,\n";
        $sql .= "    t_sale_h.trade_id,\n";
        $sql .= "    sum(t_sale_h.net_amount + t_sale_h.tax_amount) ,\n";
        $sql .= "    t_sale_h.slip_flg,\n";
        $sql .= "    t_sale_h.renew_flg,\n";
        $sql .= "    CASE t_client.slip_out\n";
        $sql .= "       WHEN '1' THEN '有'\n";
        $sql .= "       WHEN '2' THEN '無'\n";
        $sql .= "    END AS slip_out_div, \n";
        $sql .= "    t_sale_h.slip_out_day ";
        $sql .= " FROM\n";
        $sql .= "    t_sale_h\n";
        $sql .="        INNER JOIN\n";
        $sql .= "    t_client\n";
        $sql .= "    ON t_sale_h.client_id = t_client.client_id\n";
        $sql .= " WHERE\n";
        $sql .= "    t_sale_h.shop_id = $s_client_id\n";
        $sql .= "    AND\n";
        $sql .= "    t_sale_h.renew_flg = 'f'\n";
        $sql .=      $where_bfr_sql;
        $sql .= " GROUP BY t_sale_h.sale_id, \n";
        $sql .= "    t_sale_h.sale_no, \n";
        $sql .= "    t_sale_h.sale_day, \n";
        $sql .= "    t_sale_h.client_cd1, \n";
        $sql .= "    t_sale_h.client_cd2, \n";
        $sql .= "    t_sale_h.client_cname,\n ";
        $sql .= "    t_sale_h.trade_id, \n";
        $sql .= "    t_sale_h.slip_flg, \n";
        $sql .= "    t_sale_h.renew_flg, \n";
        $sql .= "    slip_out_div, \n";
        $sql .= "    t_sale_h.slip_out_day ";
    }
    //オーダーバイ
    $sql     .= " ORDER BY sale_day, sale_no DESC\n";
}

//全件取得SQL
$total_sql = $sql.";";

//print_array($total_sql);
/**************************/
//表示データ作成
/**************************/
//指定伝票の場合
if($_POST["output_slip_button"] == "伝票発行" || $_POST["output_re_slip_button"] == "再発行"){

    $result      = Db_Query($db_con, $total_sql);
    $page_data   = Get_Data($result, '2');
//通常伝票の場合
}else{
    //リミット
    $limit_sql   = " LIMIT 100 OFFSET $offset";

    $sql         = $sql.$limit_sql.";";
    $result      = Db_Query($db_con, $sql);
    $page_data   = Get_Data($result);
    $num         = pg_num_rows($result);

    //合計金額とナンバーフォーマット
    for($i = 0; $i < $num; $i++){
        $total_amount = $total_amount + $page_data[$i][7];
        $page_data[$i][7] = number_format($page_data[$i][7]);
    }
    $total_amount = number_format($total_amount);

    //データ件数
    $result      = Db_Query($db_con, $total_sql.";");
    $total_count = pg_num_rows($result);
}

//print_array($page_data);
/***************************/
//伝票関連フォーム作成
/***************************/
/*
//伝票発行全てチェック
$form->addElement(
    'checkbox', 'slip_check_all', 'チェックボックス', '伝票発行',
    "onClick=\"javascript:All_check('slip_check_all','slip_check','$num')\""
);
*/

// 請求書発行ALL
$form->addElement("checkbox", "slip_check_all", "", "売上伝票発行", "onClick=\"javascript:All_Check_Slip('slip_check_all')\"");
$form->addElement("checkbox", "re_slip_check_all", "", "再発行", "onClick=\"javascript:All_Check_Re_Slip('re_slip_check_all')\"");

$i = 0;
for($j = 0; $j <= $total_count; $j++){
    $chk_bill_id = $claim_data[$i][bill_id];

    //発行形式が有の場合
    if($page_data[$i][10] == "有") {
        //未発行の場合
        if($page_data[$i][8] == 'f'){
            $form->addElement("advcheckbox", "slip_check[$i]",    NULL, NULL, NULL, array(null ,$page_data[$i][0]));
            $slip_data[$i] = $page_data[$i][0];
        }else{
            $form->addElement("advcheckbox", "re_slip_check[$i]", NULL, NULL, NULL, array(null ,$page_data[$i][0]));
            $form->addElement("static", "slip_check[$i]", NULL, $page_data[$i][11], NULL, "");
            $re_slip_data[$i] = $page_data[$i][0];
        }
    }else{
        $form->addElement("static", "slip_check[$i]", NULL, NULL, NULL, "");
    }
    $i++;
}

// 請求確定(ALLチェックJSを作成)
$javascript  = Create_Allcheck_Js ("All_Check_Slip","slip_check",$slip_data);
$javascript .= Create_Allcheck_Js ("All_Check_Re_Slip","re_slip_check",$re_slip_data);

//伝票発行
//通常伝票発行の場合
if($slip_type != '2'){
    $form->addElement(
        "button","output_slip_button","伝票発行",
        "onClick=\"javascript:document.dateForm.elements['hdn_button'].value = '';
        Post_book_vote('".HEAD_DIR."sale/1-2-206.php','".HEAD_DIR."sale/1-2-202.php')\""
    );
    $form->addElement(
        "button","output_re_slip_button","再発行",
        "onClick=\"javascript:document.dateForm.elements['hdn_button'].value = '再発行';
        Post_book_vote('".HEAD_DIR."sale/1-2-206.php','".HEAD_DIR."sale/1-2-202.php')\""
    );
}else{
    $form->addElement(
        "submit","output_slip_button","伝票発行"
    );
    $form->addElement(
        "submit","output_re_slip_button","再発行"
    );
}

$form->addElement("hidden","hdn_button");
/****************************/
//CSV出力処理
/****************************/
if(($_POST["output_slip_button"] == "伝票発行" || $_POST["output_re_slip_button"] == "再発行") && $error == NULL){
    //CSVファイル名
    $csv_file_name = "売上伝票一括発行.csv";

    //CSVヘッダ
    $csv_header[] = "伝票番号";
    $csv_header[] = "売上日";
    $csv_header[] = "得意先名";
    $csv_header[] = "商品";
    $csv_header[] = "数量";
    $csv_header[] = "単位";
    $csv_header[] = "単価";
    $csv_header[] = "金額";

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC"); 
    $csv_data = Make_Csv($page_data, $csv_header);
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
$page_menu = Create_Menu_h('sale','2');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[sale_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//初期表示判定
if(($form->validate() && $err_flg != true && $error == NULL) || count($_POST) == 0){
	//正常
	$smarty->assign("row", $page_data);
}else{
	//エラー時
	$total_amount = 0;
	$total_count = 0;
}

/****************************/
//ページ作成
/****************************/
//表示範囲指定
$range = "100";

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'total_amount'  => "$total_amount",
    'error'         => "$error",
    'sale_day_error'  => "$sale_day_error",
    'javascript'    => "$javascript"
));

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
