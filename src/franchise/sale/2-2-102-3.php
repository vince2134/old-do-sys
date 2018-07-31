<?php
$page_title = "巡回予定カレンダー(週)";

//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

/****************************/
//外部変数
/****************************/
$client_id = $_SESSION["client_id"];

/****************************/
//得意先情報取得
/****************************/
$sql  = "SELECT ";
$sql .= "    cal_peri ";    //カレンダー表示期間
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_id = $client_id;";
$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
//該当データがある
if($num == 1){
	$cal_peri      = pg_fetch_result($result, 0,0);
}

//巡回基準日
$sql  = "SELECT stand_day FROM t_stand;";
$result = Db_Query($db_con, $sql); 
$stand_day = pg_fetch_result($result,0,0);   
$day_by = substr($stand_day,0,4);
$day_bm = substr($stand_day,5,2);
$day_bd = substr($stand_day,8,2);

//仮カレンダー表示期間データ
$cal_peri = 3;

/****************************/
//休日データ取得
/****************************/
$sql  = "SELECT ";
$sql .= "    holiday ";     //休日
$sql .= "FROM ";
$sql .= "    t_holiday ";
$sql .= "WHERE ";
$sql .= "    shop_id = $client_id;";
$result = Db_Query($db_con, $sql);
$h_data = Get_Data($result);
for($h=0;$h<count($h_data);$h++){
	//休日データを連想配列によって定義
	$holiday[$h_data[$h][0]] = "1";
}

/****************************/
//日付データ取得
/****************************/
//本日の日付取得
$year  = date("Y");
$month = date("m");
$day   = date("d");

//カレンダー表示期間
$cal_range = $year."年 ".str_pad($month-1, 2, 0, STR_POS_LEFT)."月 〜 ".$year."年 ".str_pad($month+$cal_peri, 2, 0, STR_POS_LEFT)."月";

//一週間後の日付取得
$next = mktime(0, 0, 0, $month,$day+6,$year);
$nyear  = date("Y",$next);
$nmonth = date("m",$next);
$nday   = date("d",$next);

/****************************/
//POST情報取得
/****************************/
$post_part_id = $_POST["form_part_1"];        //部署

//予定日が指定されているか
if($_POST["form_sale_day"]["y"] != NULL && $_POST["form_sale_day"]["m"] != NULL && $_POST["form_sale_day"]["d"] != NULL){
	$year = $_POST["form_sale_day"]["y"];    
	$month = $_POST["form_sale_day"]["m"];
	$day = $_POST["form_sale_day"]["d"];

	//予定日から一週間後の日付
	$next = mktime(0, 0, 0, $month,$day+6,$year);
	$nyear  = date("Y",$next);
	$nmonth = date("m",$next);
	$nday   = date("d",$next);

	//予定日を基準するフラグ
	$sale_day_flg = true;
}

/****************************/
//前日・先週ボタン押下処理
/****************************/
if($_POST["back_d_button_flg"] == true || $_POST["back_w_button_flg"] == true){
	//POST判定
	if($_POST["back_d_count"] == NULL){
		//先週判定
		if($_POST["back_w_button_flg"] == true){
			//無い
			$back_d_count = 7;
		}else{
			//無い
			$back_d_count = 1;
		}
	}else{
		//先週判定
		if($_POST["back_w_button_flg"] == true){
			//有る
			//今日から、日数分引く
	    	$back_d_count = $_POST["back_d_count"]+7;
		}else{
			//有る
			//今日から、日数分引く
	    	$back_d_count = $_POST["back_d_count"]+1;
		}
	}

	//POST判定
	if($_POST["next_d_count"] == NULL){
		//無い、
		$next_d_count = 0;
	}else{
		//有る
		//今日に、日数分足す
    	$next_d_count = $_POST["next_d_count"];
	}

	//予定日基準判定
	if($sale_day_flg == true){
		//予定日の日付取得
		$str = mktime(0, 0, 0, $month,$day-$back_d_count,$year);
	}else{
		//今日の日付取得
		$str = mktime(0, 0, 0, date("n"),date("j")-$back_d_count,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("n",$str);
	$day   = date("j",$str);

	//足した分の日を考慮する
	$str = mktime(0, 0, 0, $month,$day+$next_d_count,$year);
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day   = date("d",$str);

	//一週間後の日付取得
	$next = mktime(0, 0, 0, $month,$day+6,$year);
	$nyear  = date("Y",$next);
	$nmonth = date("m",$next);
	$nday   = date("d",$next);

	//前日は、今月から見て一ヶ月前しかださないように判定する
	$last_day = date("Y-m-d", mktime(0, 0, 0, date("n")-1,1,date("Y")));
	
	//前月の最初の週か
	$check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day-7,$year));
	if($check_day <= $last_day){
		//先週ボタンを非表示にする
		$bw_disabled_flg = true;
	}

	//前月の１日か
	if($year."-".$month."-".$day == $last_day){
		//前日ボタンを非表示にする
		$bd_disabled_flg = true;
	}

	//前日ボタンフラグをクリア
    $back_data["back_d_button_flg"] = "";
	//先週ボタンフラグクリア
	$back_data["back_w_button_flg"] = "";
	$back_data["back_d_count"]      = $back_d_count;
    $form->setConstants($back_data);
}

/****************************/
//翌日・翌週ボタン押下処理
/****************************/
if($_POST["next_d_button_flg"] == true || $_POST["next_w_button_flg"] == true){

	//POST判定
	if($_POST["next_d_count"] == NULL){
		//翌週判定
		if($_POST["next_w_button_flg"] == true){
			//無い
			$next_d_count = 7;
		}else{
			//無い、
			$next_d_count = 1;
		}
	}else{
		//翌週判定
		if($_POST["next_w_button_flg"] == true){
			//有る
			//今月に、月数分足す
	    	$next_d_count = $_POST["next_d_count"]+7;
		}else{
			//有る
			//今月に、月数分足す
	    	$next_d_count = $_POST["next_d_count"]+1;
		}
	}

	//POST判定
	if($_POST["back_d_count"] == NULL){
		//無い
		$back_d_count = 0;
	}else{
		//有る
		//今月に、月数分引く
    	$back_d_count = $_POST["back_d_count"];
	}

	//予定日基準判定
	if($sale_day_flg == true){
		//予定日の日付取得
		$str = mktime(0, 0, 0, $month,$day+$next_d_count,$year);
	}else{
		//今日の日付取得
		$str = mktime(0, 0, 0, date("n"),date("j")+$next_d_count,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("n",$str);
	$day   = date("j",$str);

	//引いた分の日を考慮する
	$str = mktime(0, 0, 0, $month,$day-$back_d_count,$year);
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day   = date("d",$str);

	//カレンダー表示期間分しか表示させない為判定
	$max_day = date("t",mktime(0, 0, 0, date("n")+$cal_peri,1,date("Y")));
	$fast_day = date("Y-m-d", mktime(0, 0, 0, date("n")+$cal_peri,$max_day,date("Y")));

	//翌月の最初の週か
	$check_day = date("Y-m-d", mktime(0, 0, 0, $month,$day+7,$year));
	if($check_day >= $fast_day){
		//翌週ボタンを非表示にする
		$nw_disabled_flg = true;

		//月末までの日付取得
		$nyear = substr($fast_day,0,4);
		$nmonth = substr($fast_day,5,2);
		$nday = substr($fast_day,8,2);
	}else{
		//一週間後の日付取得
		$next = mktime(0, 0, 0, $month,$day+6,$year);
		$nyear  = date("Y",$next);
		$nmonth = date("m",$next);
		$nday   = date("d",$next);
	}

	//翌月の１日か
	if($year."-".$month."-".$day == $fast_day){
		//翌日ボタンを非表示にする
		$nd_disabled_flg = true;
	}

	//翌日ボタンフラグをクリア
    $next_data["next_d_button_flg"] = "";
	//翌週ボタンフラグをクリア
	$next_data["next_w_button_flg"] = "";
	$next_data["next_d_count"]      = $next_d_count;
    $form->setConstants($next_data);
}

/****************************/
//初期表示
/****************************/
$def_fdata = array(
    "form_output"     => "1",

);
$form->setDefaults($def_fdata);

/****************************/
//フォーム定義
/****************************/
//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "帳票","2");
$form->addGroup($radio1, "form_output", "出力形式");

//部署
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', 'セレクトボックス', $select_value,$g_form_option_select);

//表示ボタン
$button[] = $form->createElement("submit","indicate_button","表　示","onClick=\"javascript:Which_Type('form_output','".FC_DIR."sale/2-2-115-2.php','#')\"");

//クリアボタン
$button[] = $form->createElement("button","clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addGroup($button, "form_button", "ボタン");

//巡回予定表
//$form->addElement("button","form_patrol_button","巡回予定表","onClick=\"javascript:Referer('2-2-102.php')\"");
//単月変更
$form->addElement("button","form_single_month_change_button","照　会","onClick=\"javascript:Referer('2-2-102-2.php')\"");
//マスタ変更
$form->addElement("button","form_master_change_button","変　更","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//伝票作成
$form->addElement("button","form_slip_button","伝票作成","onClick=\"javascript:Referer('2-2-201.php')\"");
//コース表示ボタン
$form->addElement("button","form_course","コース表示");

$form->addElement("hidden", "back_w_button_flg");     //先週ボタン押下判定
$form->addElement("hidden", "back_d_button_flg");     //前日ボタン押下判定
$form->addElement("hidden", "next_w_button_flg");     //翌週ボタン押下判定
$form->addElement("hidden", "next_d_button_flg");     //翌日ボタン押下判定
$form->addElement("hidden", "next_d_count");          //今日から何日後
$form->addElement("hidden", "back_d_count");          //今日から何日前

//予定日
$text = NULL;
$text[] =& $form->createElement("text","y","テキストフォーム","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_sale_day[y]','form_sale_day[m]',4)\" ".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","m","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_sale_day[m]','form_sale_day[d]',2)\" ".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","d","テキストフォーム","size=\"1\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup( $text,"form_sale_day","form_sale_day");

/****************************/
//一時変更データ取得
/****************************/
//巡回担当者識別配列
$aorder_staff = array(1=>"0",2=>"1",3=>"2",4=>"3");

for($i=1;$i<=4;$i++){

	//担当者（メイン）判定
	if($i!=1){
		//メイン以外はUNIONで結合
		$sql .= "UNION  \n";
		$sql .= "SELECT  \n";
	}else{
		//メイン
		$sql  = "SELECT  \n";
	}

	//更新前
	$sql .= "    t_part.part_name,";              //部署名0
	$sql .= "    t_staff$i.staff_name,";          //スタッフ名1
	$sql .= "    t_aorder_h.net_amount,";         //売上金額2
	$sql .= "    t_aorder_h.ord_time,";           //受注日3
	$sql .= "    t_aorder_h.route,";              //順路4
	$sql .= "    t_client.client_cname,";         //得意先名5
	$sql .= "    t_aorder_h.aord_id,";            //受注ID6
	$sql .= "    t_aorder_h.hand_slip_flg,";      //手書伝票フラグ7
	$sql .= "    t_aorder_h.reserve_del_flg,";    //保留伝票削除フラグ8
	$sql .= "    t_aorder_h.confirm_flg, ";       //更新フラグ9
	$sql .= "    t_staff$i.staff_cd1,";           //スタッフコード1 10
	$sql .= "    t_staff$i.staff_cd2, ";          //スタッフコード2 11
	$sql .= "    CASE ";                          //部署ID12
	$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
	$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
	$sql .= "    END,";
	$sql .= "    t_aorder_h.reason,";             //保留理由13
	$sql .= "    t_aorder_h.confirm_flg,";        //確定伝票14
	$sql .= "    t_client.client_id,";            //得意先ID15
	$sql .= "    t_staff$i.charge_cd, ";          //担当者コード16
	$sql .= "    t_client.client_cd1,";           //得意先コード1 17
	$sql .= "    t_client.client_cd2, ";          //得意先コード2 18
	$sql .= "    t_staff$i.staff_id, ";           //スタッフID19
	$sql .= "    t_aorder_h.tax_amount,";         //消費税額 20
	$sql .= "    t_staff$i.sale_rate,";           //売上率 21
	$sql .= "    t_part.part_cd, ";               //部署名CD 22
	$sql .= "    t_aorder_h.shop_id, \n";         //取引先ID 23
	$sql .= "    t_staff_count.num,\n";           //伝票人数 24
	$sql .= "    t_aorder_h.act_id \n";           //代行先ID 25
	$sql .= "FROM ";

	$sql .= "    t_aorder_h ";

	$sql .= "    INNER JOIN ( \n";
	$sql .= "        SELECT \n";
	$sql .= "            aord_id,\n";
	$sql .= "            count(aord_id)AS num \n";
	$sql .= "        FROM \n";
	$sql .= "            t_aorder_staff \n";
	$sql .= "        WHERE ";
	$sql .= "            sale_rate IS NOT NULL \n";
	$sql .= "        GROUP BY \n";
	$sql .= "            aord_id \n";
	$sql .= "    )AS t_staff_count ON t_staff_count.aord_id = t_aorder_h.aord_id  \n";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_aorder_staff.aord_id,";
	$sql .= "             t_staff.staff_id,";
	$sql .= "             t_staff.staff_name,";
	$sql .= "             t_staff.staff_cd1,";
	$sql .= "             t_staff.staff_cd2,";
	$sql .= "             t_staff.charge_cd,";
	$sql .= "             t_aorder_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_aorder_staff ";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
	$sql .= "         WHERE ";
	$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate != '0' ";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
	$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

	$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id ";

	$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
	$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	$sql .= "    LEFT JOIN ";
	$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

	$sql .= "WHERE ";

	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
	}else{
	    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
	}
	$sql .= "    AND ";
	$sql .= "    t_client.state = '1' ";
	$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
	$sql .= "    AND ";
	$sql .= "    t_attach.h_staff_flg = 'false' ";
	$sql .= "    AND  \n";
	$sql .= "    t_aorder_h.contract_div = '1' \n";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";

	//部署指定判定
	if($post_part_id != NULL){
		$sql .= "    AND ";
		$sql .= "    t_part.part_id = $post_part_id ";
	}

	$sql .= "UNION ";

	//更新後
	$sql .= "SELECT ";
	$sql .= "    t_part.part_name,";              //部署名0
	$sql .= "    t_staff$i.staff_name,";          //スタッフ名1
	$sql .= "    sale_h.net_amount,";             //売上金額2
	$sql .= "    t_aorder_h.ord_time,";           //受注日3
	$sql .= "    t_aorder_h.route,";              //順路4
	$sql .= "    t_aorder_h.client_cname,";       //得意先名5
	$sql .= "    sale_h.sale_id,";                //売上ID6
	$sql .= "    t_aorder_h.hand_slip_flg,";      //手書伝票フラグ7
	$sql .= "    t_aorder_h.reserve_del_flg,";    //保留伝票削除フラグ8
	$sql .= "    t_aorder_h.confirm_flg,";        //更新フラグ9
	$sql .= "    t_staff$i.staff_cd1,";           //スタッフコード1 10
	$sql .= "    t_staff$i.staff_cd2,";           //スタッフコード2 11
	$sql .= "    CASE ";           //部署ID12
	$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
	$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
	$sql .= "    END,";
	$sql .= "    t_aorder_h.reason, ";            //保留理由13
	$sql .= "    t_aorder_h.confirm_flg,";        //確定伝票14
	$sql .= "    t_client.client_id, ";           //得意先ID15
	$sql .= "    t_staff$i.charge_cd, ";          //担当者コード16
	$sql .= "    t_client.client_cd1,";           //得意先コード1 17
	$sql .= "    t_client.client_cd2, ";          //得意先コード2 18
	$sql .= "    t_staff$i.staff_id, ";           //スタッフID19
	$sql .= "    sale_h.tax_amount,";             //消費税額 20
	$sql .= "    t_staff$i.sale_rate,";           //売上率 21
	$sql .= "    t_part.part_cd, ";               //部署名CD 22
	$sql .= "    t_aorder_h.shop_id, \n";         //取引先ID 23
	$sql .= "    t_staff_count.num, \n";          //伝票人数 24
	$sql .= "    t_aorder_h.act_id \n";           //代行先ID 25
	   
	$sql .= "FROM ";

	$sql .= "    t_aorder_h ";

	$sql .= "    INNER JOIN ( \n";
	$sql .= "        SELECT \n";
	$sql .= "            aord_id,\n";
	$sql .= "            count(aord_id)AS num \n";
	$sql .= "        FROM \n";
	$sql .= "            t_aorder_staff \n";
	$sql .= "        WHERE ";
	$sql .= "            sale_rate IS NOT NULL \n";
	$sql .= "        GROUP BY \n";
	$sql .= "            aord_id \n";
	$sql .= "    )AS t_staff_count ON t_staff_count.aord_id = t_aorder_h.aord_id  \n";

	$sql .= "    LEFT JOIN ";
	$sql .= "        (SELECT ";
	$sql .= "             t_aorder_staff.aord_id,";
	$sql .= "             t_staff.staff_id,";
	$sql .= "             t_aorder_staff.staff_name,";
	$sql .= "             t_staff.staff_cd1,";
	$sql .= "             t_staff.staff_cd2,";
	$sql .= "             t_staff.charge_cd,";
	$sql .= "             t_aorder_staff.sale_rate ";
	$sql .= "         FROM ";
	$sql .= "             t_aorder_staff ";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
	$sql .= "         WHERE ";
	$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate != '0' ";
	$sql .= "         AND ";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
	$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

	$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id ";
	$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
	$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

	$sql .= "    INNER JOIN ";
	$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

	$sql .= "WHERE ";
	if($_SESSION["group_kind"] == '2'){
	    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
	}else{
	    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
	}
	$sql .= "    AND ";
	$sql .= "    t_client.state = '1' ";
	$sql .= "    AND ";
	$sql .= "    t_attach.h_staff_flg = 'false' ";
	$sql .= "    AND  \n";
	$sql .= "    t_aorder_h.contract_div = '1' \n";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
	$sql .= "    AND ";
	$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";
	//部署指定判定
	if($post_part_id != NULL){
		$sql .= "    AND ";
		$sql .= "    t_part.part_id = $post_part_id ";
	}

	//FCの場合は、代行のカレンダーは結合して表示
	if($_SESSION["group_kind"] == '3'){
		$sql .= "UNION  \n";

		//更新前
		$sql .= "SELECT ";
		$sql .= "    t_part.part_name,";              //部署名0
		$sql .= "    t_staff$i.staff_name,";          //スタッフ名1
		$sql .= "    t_aorder_h.net_amount,";         //売上金額2
		$sql .= "    t_aorder_h.ord_time,";           //受注日3
		$sql .= "    t_aorder_h.route,";              //順路4
		$sql .= "    t_client.client_cname,";         //得意先名5
		$sql .= "    t_aorder_h.aord_id,";            //受注ID6
		$sql .= "    t_aorder_h.hand_slip_flg,";      //手書伝票フラグ7
		$sql .= "    t_aorder_h.reserve_del_flg,";    //保留伝票削除フラグ8
		$sql .= "    t_aorder_h.confirm_flg, ";       //更新フラグ9
		$sql .= "    t_staff$i.staff_cd1,";           //スタッフコード1 10
		$sql .= "    t_staff$i.staff_cd2, ";          //スタッフコード2 11
		$sql .= "    CASE ";                          //部署ID12
		$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
		$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
		$sql .= "    END,";
		$sql .= "    t_aorder_h.reason,";             //保留理由13
		$sql .= "    t_aorder_h.confirm_flg,";        //確定伝票14
		$sql .= "    t_client.client_id,";            //得意先ID15
		$sql .= "    t_staff$i.charge_cd, ";          //担当者コード16
		$sql .= "    t_client.client_cd1,";           //得意先コード1 17
		$sql .= "    t_client.client_cd2, ";          //得意先コード2 18
		$sql .= "    t_staff$i.staff_id, ";           //スタッフID19
		$sql .= "    t_aorder_h.tax_amount,";         //消費税額 20
		$sql .= "    t_staff$i.sale_rate,";           //売上率 21
		$sql .= "    t_part.part_cd, ";               //部署名CD 22
		$sql .= "    t_aorder_h.shop_id, \n";         //取引先ID 23
		$sql .= "    NULL,\n";                        //伝票人数 24
		$sql .= "    t_aorder_h.act_id \n";           //代行先ID 25

		$sql .= "FROM ";

		$sql .= "    t_aorder_h ";

		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_staff.staff_id,";
		$sql .= "             t_staff.staff_name,";
		$sql .= "             t_staff.staff_cd1,";
		$sql .= "             t_staff.staff_cd2,";
		$sql .= "             t_staff.charge_cd,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate != '0' ";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

		$sql .= "    LEFT JOIN ";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

		$sql .= "WHERE ";

	    $sql .= "    t_aorder_h.act_id = $client_id  \n";
		
		$sql .= "    AND ";
		$sql .= "    t_client.state = '1' ";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";

		//部署指定判定
		if($post_part_id != NULL){
			$sql .= "    AND ";
			$sql .= "    t_part.part_id = $post_part_id ";
		}

		$sql .= "UNION ";

		//更新後
		$sql .= "SELECT ";
		$sql .= "    t_part.part_name,";              //部署名0
		$sql .= "    t_staff$i.staff_name,";          //スタッフ名1
		$sql .= "    sale_h.net_amount,";             //売上金額2
		$sql .= "    t_aorder_h.ord_time,";           //受注日3
		$sql .= "    t_aorder_h.route,";              //順路4
		$sql .= "    t_aorder_h.client_cname,";       //得意先名5
		$sql .= "    sale_h.sale_id,";                //売上ID6
		$sql .= "    t_aorder_h.hand_slip_flg,";      //手書伝票フラグ7
		$sql .= "    t_aorder_h.reserve_del_flg,";    //保留伝票削除フラグ8
		$sql .= "    t_aorder_h.confirm_flg,";        //更新フラグ9
		$sql .= "    t_staff$i.staff_cd1,";           //スタッフコード1 10
		$sql .= "    t_staff$i.staff_cd2,";           //スタッフコード2 11
		$sql .= "    CASE ";           //部署ID12
		$sql .= "    WHEN t_part.part_id IS NULL THEN 0 ";
		$sql .= "    WHEN t_part.part_id IS NOT NULL THEN t_part.part_id ";
		$sql .= "    END,";
		$sql .= "    t_aorder_h.reason, ";            //保留理由13
		$sql .= "    t_aorder_h.confirm_flg,";        //確定伝票14
		$sql .= "    t_client.client_id, ";           //得意先ID15
		$sql .= "    t_staff$i.charge_cd, ";          //担当者コード16
		$sql .= "    t_client.client_cd1,";           //得意先コード1 17
		$sql .= "    t_client.client_cd2, ";          //得意先コード2 18
		$sql .= "    t_staff$i.staff_id, ";           //スタッフID19
		$sql .= "    sale_h.tax_amount,";             //消費税額 20
		$sql .= "    t_staff$i.sale_rate,";           //売上率 21
		$sql .= "    t_part.part_cd, ";               //部署名CD 22
		$sql .= "    t_aorder_h.shop_id, \n";         //取引先ID 23
		$sql .= "    NULL, \n";                       //伝票人数 24
		$sql .= "    t_aorder_h.act_id \n";           //代行先ID 25
		   
		$sql .= "FROM ";

		$sql .= "    t_aorder_h ";

		$sql .= "    LEFT JOIN ";
		$sql .= "        (SELECT ";
		$sql .= "             t_aorder_staff.aord_id,";
		$sql .= "             t_staff.staff_id,";
		$sql .= "             t_aorder_staff.staff_name,";
		$sql .= "             t_staff.staff_cd1,";
		$sql .= "             t_staff.staff_cd2,";
		$sql .= "             t_staff.charge_cd,";
		$sql .= "             t_aorder_staff.sale_rate ";
		$sql .= "         FROM ";
		$sql .= "             t_aorder_staff ";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id ";
		$sql .= "         WHERE ";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."'";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate != '0' ";
		$sql .= "         AND ";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL ";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id ";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";

		$sql .= "    INNER JOIN ";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id ";

		$sql .= "WHERE ";

		$sql .= "    t_aorder_h.act_id = $client_id  \n";

		$sql .= "    AND ";
		$sql .= "    t_client.state = '1' ";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' ";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' ";
		//部署指定判定
		if($post_part_id != NULL){
			$sql .= "    AND ";
			$sql .= "    t_part.part_id = $post_part_id ";
		}
	}
}
$sql .= "ORDER BY ";
$sql .= "    part_cd, ";
$sql .= "    charge_cd,";
$sql .= "    ord_time, ";
$sql .= "    route,";
$sql .= "    client_cd1,";
$sql .= "    client_cd2;";

$result = Db_Query($db_con, $sql);
$data_list = Get_Data($result);

/****************************/
//受注ヘッダーにある巡回担当者のデータを担当者配列に上書きする
/****************************/
$n_data_list = NULL;
$staff_data_flg = false;  //受注データ存在フラグ判定
for($x=0;$x<count($data_list);$x++){
	$ymd = $data_list[$x][3];          //巡回日
	$part_id = $data_list[$x][12];     //部署ID
	$staff_id = $data_list[$x][19];    //スタッフID

	//連想配列に登録する。
	$n_data_list[$part_id][$staff_id][$ymd][] = $data_list[$x];

	$data_list2[$part_id][0][0] = $data_list[$x][0];    //部署名
	$data_list2[$part_id][0][1]++;                          //予定件数

	//予定金額 (売上金額+消費税額)×売上率
	$money1 = $data_list[$x][2] + $data_list[$x][20];
	$money2 = $data_list[$x][21] / 100;
	//売上率判定
	if($money2 != 0){
		//売上率から計算
		$total1 = bcmul($money1,$money2,2);
	}else{
		//オフライン代行の場合は、売上率は無い為乗算しない
		$total1 = $money1;
	}
	$data_list2[$part_id][0][2] = bcadd($total1,$data_list2[$part_id][0][2]);

	//受注データが存在した
	$staff_data_flg = true;
}

//受注データが存在した場合にその担当者データをカレンダー配列に上書き
if($staff_data_flg == true){

	//数値形式変更
	while($money_num = each($data_list2)){
		$money = $money_num[0];
		//予定金額切捨て
		$data_list2[$money][0][2] = floor($data_list2[$money][0][2]);
		$data_list2[$money][0][2] = number_format($data_list2[$money][0][2]);
	}
	//指標をリセットする
	reset($data_list2);

	/****************************/
	//カレンダーテーブル作成処理
	/****************************/

	//カレンダーHTML
	$calendar   = NULL;
	$date_num_y = NULL;
	$date_num_m = NULL;
	$date_num_d = NULL;

	//ABCD週の表示データ作成
	for($ab=0;$ab<7;$ab++){
		//該当日が何週か取得処理
		$next = mktime(0, 0, 0, $month,$day+$ab,$year);
		$nyear     = date("Y",$next); //年
		$nmonth    = date("m",$next); //月
		$nday      = date("d",$next); //日
		$week[$ab] = date("w",$next); //曜日

		$date_num_y[] = $nyear;       //一週間の年配列
		$date_num_m[] = $nmonth;      //一週間の月配列
		$date_num_d[] = $nday;        //一週間の日配列

		//ABCD判別関数
		//月の最初の日が何週か取得処理
		$base_date = Basic_date($day_by,$day_bm,$day_bd,$nyear,$nmonth,$nday);
		$row = $base_date[0];
		//基準日より過去の日付の場合は、０を代入
		if($row == NULL){
			$row = 0;
		}
		$abcd[$ab] = $row;
	}

	//ABCD週の表示配列
	$abcd_w[1] = "A";
	$abcd_w[2] = "B";
	$abcd_w[3] = "C";
	$abcd_w[4] = "D";

	//ABCD週の結合数取得
	$rowspan = array_count_values($abcd);

	/****************************/
	//カレンダーテーブル上書き処理
	/****************************/
	//部署ごとに巡回データ作成
	while($part_num = each($n_data_list)){
		//部署の添字取得
		$part = $part_num[0];

		//先週ボタン
		//非表示判定
		if($bw_disabled_flg == true){
			//非表示
			$form->addElement("button","back_w_button[$part]","<<　先週","disabled");
		}else{
			//表示
			$form->addElement("button","back_w_button[$part]","<<　先週","onClick=\"javascript:Button_Submit('back_w_button_flg','#$part','true')\"");
		}

		//前日ボタン
		//非表示判定
		if($bd_disabled_flg == true){
			//非表示
			$form->addElement("button","back_d_button[$part]","<<　前日","disabled");
		}else{
			//表示
			$form->addElement("button","back_d_button[$part]","<<　前日","onClick=\"javascript:Button_Submit('back_d_button_flg','#$part','true')\"");
		}

		//翌週ボタン
		//非表示判定
		if($nw_disabled_flg == true){
			//非表示
			$form->addElement("button","next_w_button[$part]","翌週　>>","disabled");
		}else{
			//表示
			$form->addElement("button","next_w_button[$part]","翌週　>>","onClick=\"javascript:Button_Submit('next_w_button_flg','#$part','true')\"");
		}

		//翌日ボタン
		//非表示判定
		if($nd_disabled_flg == true){
			//非表示
			$form->addElement("button","next_d_button[$part]","翌日　>>","disabled");
		}else{
			//表示
			$form->addElement("button","next_d_button[$part]","翌日　>>","onClick=\"javascript:Button_Submit('next_d_button_flg','#$part','true')\"");
		}

		/****************************/
		//巡回担当者
		/****************************/
		//部署に属するスタッフがいた場合に表示
		if($n_data_list[$part] != NULL){
			//担当者ごとに巡回データ作成
			while($staff_num = each($n_data_list[$part])){
				//担当者ID
				$staff_id = $staff_num[0];

				/****************************/
				//ABCD週HTML
				/****************************/
				$calendar[$part]  = "<tr height=\"40\">";
				$calendar[$part] .=	"  <td align=\"center\" bgcolor=\"#cccccc\" width=\"60\"><b>巡回基準</b></td>";
				//ABCD週作成
				while($abcd_num = each($rowspan)){
					//ABCDの添字取得
					$ab_num = $abcd_num[0];
					$calendar[$part] .= "  <td align=\"center\" bgcolor=\"#e5e5e5\" colspan=\"".$rowspan[$ab_num]."\" style=\"font-size: 130%; font-weight: bold; padding: 0px;\">".$abcd_w[$ab_num]."</td>";
				}
				$calendar[$part] .= "</tr>";
				//指標をリセットする
				reset($rowspan);

				/****************************/
				//曜日HTML
				/****************************/
				//曜日配列
				$week_w[0] = "日";
				$week_w[1] = "月";
				$week_w[2] = "火";
				$week_w[3] = "水";
				$week_w[4] = "木";
				$week_w[5] = "金";
				$week_w[6] = "土";

				$calendar[$part]  .= "<tr height=\"20\">";
				$calendar[$part]  .= "	<td align=\"center\" bgcolor=\"#cccccc\" rowspan=\"2\" width=\"80\"><b>巡回担当者</b></td>";
				//一週間分表示
				for($w=0;$w<7;$w++){
					//曜日判定
					if($week[$w] == 6 && $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] != 1){
						//土曜かつ休日ではない
						$calendar[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
					}else if($week[$w] == 0 || $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] == 1){
						//日曜or休日
						$calendar[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
					}else{
						//月〜金
						$calendar[$part] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
					}
					$calendar[$part] .= $week_w[$week[$w]]."</b></td>";
				}
				$calendar[$part] .= "</tr>";

				//担当者名
				$num1 = each($n_data_list[$part][$staff_id]);
				$num2 = each($n_data_list[$part][$staff_id][$num1[0]]);
				$staff_name = $n_data_list[$part][$staff_id][$num1[0]][$num2[0]][1];
				$calendar2[$part][$staff_id]  = "<tr>";
				$calendar2[$part][$staff_id]  .= "<td width=\"80px\" align=\"center\" valign=\"center\" bgcolor=\"#E5E5E5\" >";
				$calendar2[$part][$staff_id]  .= "<font size=\"2\">$staff_name</font></td>";

				//一週間分表示
				for($d=0;$d<7;$d++){
					//曜日判定
					if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
						//土曜かつ休日ではない
						$calendar2[$part][$staff_id] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" class=\"cal3\" width=\"13%\">";
					}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
						//日曜or休日
						$calendar2[$part][$staff_id] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" class=\"cal3\" width=\"13%\">";
					}else{
						//月〜金
						$calendar2[$part][$staff_id] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" class=\"cal3\" width=\"13%\">";
					}
					//データ存在判定
					$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
					//該当日に巡回データが複数存在した場合、その件数分表示
					for($y=0;$y<count($n_data_list[$part][$staff_id][$date]);$y++){
						//該当日に巡回データが存在するか判定
						if($n_data_list[$part][$staff_id][$date][$y][6] != NULL){

							//データが存在した為、その日をリンクにする
							$link_data[$part][$d] = true;

							//予定明細に渡す受注ID配列作成
							for($p=0;$p<count($n_data_list[$part][$staff_id][$date]);$p++){
								$aord_id_array[$staff_id][$date][$p] = $n_data_list[$part][$staff_id][$date][$p][6];
							}

							//順路指定判定
							if($n_data_list[$part][$staff_id][$date][$y][4] != NULL){
								//順路形式変更
								$route = str_pad($n_data_list[$part][$staff_id][$date][$y][4], 4, 0, STR_POS_LEFT);
								$route1 = substr($route,0,2);
								$route2 = substr($route,2,2);
								$route = $route1."-".$route2;
							}else{
								//オフライン代行の場合は空白表示
								$route = "　 　";
							}

							//リンク色判定
							if($n_data_list[$part][$staff_id][$date][$y][14] == "t"){
								//確定伝票
								//遷移先：予定訂正ダイアログ
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: gray;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][25] != NULL){
								//代行伝票
								//遷移先：予定訂正ダイアログ
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: green;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][24] == 1){
								//予定伝票(一人)
								//遷移先：予定訂正ダイアログ
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: blue;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][24] == 2){
								//予定伝票(二人)
								//遷移先：予定訂正ダイアログ
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: Fuchsia;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}elseif($n_data_list[$part][$staff_id][$date][$y][24] == 3 || $n_data_list[$part][$staff_id][$date][$y][23] == 4){
								//予定伝票(三人以上)
								//遷移先：予定訂正ダイアログ
								$calendar2[$part][$staff_id] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
								$calendar2[$part][$staff_id] .= "450,200,".$n_data_list[$part][$staff_id][$date][$y][15].",".$n_data_list[$part][$staff_id][$date][$y][6].")\" style=\"color: #FF6600;\">";
								$calendar2[$part][$staff_id] .= $n_data_list[$part][$staff_id][$date][$y][5]."</a><br>";
							}
						}
					}
					$calendar2[$part][$staff_id] .= "</font></td>";
				}
				$calendar2[$part][$staff_id] .= "</tr>";
			}

			/****************************/
			//日付HTML上書き処理
			/****************************/
			$calendar3[$part]  = "<tr height=\"20\" style=\"font-size: 130%; font-weight: bold; \">";
			//一週間分表示
			for($d=0;$d<7;$d++){
				//曜日判定
				if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
					//土曜かつ休日ではない
					$calendar3[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
				}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
					//日曜or休日
					$calendar3[$part] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
				}else{
					//月〜金
					$calendar3[$part] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
				}
				//土日休判定
				if($week[$d] == 6 || $week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
					//日付リンク判定
					if($link_data[$part][$d] == true){
						
						//該当日の受注ID全てを予定明細に渡す
						$aord_id_array2 = NULL;
						//週の日付
						$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
						while($aord_num = each($aord_id_array)){
							//スタッフID
							$aord_staff_id = $aord_num[0];
							//各スタッフの週の日付にデータがあった場合に、受注ID配列に追加
							for($p=0;$p<count($aord_id_array[$aord_staff_id][$date]);$p++){
								$aord_id_array2[] = $aord_id_array[$aord_staff_id][$date][$p];
							}
						}
						//指標をリセットする
						reset($aord_id_array);

						//シリアライズ化
						$array_id = serialize($aord_id_array2);
						$array_id = urlencode($array_id);

						//月〜金（リンク）
						$calendar3[$part] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php?aord_id_array=".$array_id."',450,200)\">".$date_num_d[$d]."</b></td>";
					}else{
						//土日休（リンクなし）
						$calendar3[$part] .= $date_num_d[$d]."</b></td>";
					}
				}else{
					//日付リンク判定
					if($link_data[$part][$d] == true){
						
						//該当日の受注ID全てを予定明細に渡す
						$aord_id_array2 = NULL;
						//週の日付
						$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
						while($aord_num = each($aord_id_array)){
							//スタッフID
							$aord_staff_id = $aord_num[0];
							//各スタッフの週の日付にデータがあった場合に、受注ID配列に追加
							for($p=0;$p<count($aord_id_array[$aord_staff_id][$date]);$p++){
								$aord_id_array2[] = $aord_id_array[$aord_staff_id][$date][$p];
							}
						}
						//指標をリセットする
						reset($aord_id_array);

						//シリアライズ化
						$array_id = serialize($aord_id_array2);
						$array_id = urlencode($array_id);

						//月〜金（リンク）
						$calendar3[$part] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php?aord_id_array=".$array_id."',450,200)\">".$date_num_d[$d]."</b></td>";
					}else{
						//月〜金（リンクなし）
						$calendar3[$part] .= $date_num_d[$d]."</b></td>";
					}
				}
			}
			$calendar3[$part] .= "</tr>";
		}
	}
}

//検索時には代行カレンダー非表示
if($post_part_id == NULL && $_SESSION["group_kind"] != 3){
	/****************************/
	//照会データ取得（契約区分が代行）
	/****************************/
	for($i=1;$i<=4;$i++){

		//担当者（メイン）判定
		if($i!=1){
			//メイン以外はUNIONで結合
			$sql .= "UNION  \n";
			$sql .= "SELECT  \n";
		}else{
			//メイン
			$sql  = "SELECT  \n";
		}

		//更新前
		$sql .= "    t_act.shop_name, \n";               //受託先名0
		$sql .= "    t_aorder_h.act_id, \n";             //受託先ID1
		$sql .= "    t_act.client_cd1, \n";              //受託先コード1 2
		$sql .= "    t_act.client_cd2, \n";              //受託先コード2 3
		$sql .= "    t_aorder_h.net_amount, \n";         //売上金額4
		$sql .= "    t_aorder_h.ord_time, \n";           //受注日5
		$sql .= "    t_aorder_h.route, \n";              //順路6
		$sql .= "    t_client.client_cname, \n";         //得意先名7
		$sql .= "    t_aorder_h.aord_id, \n";            //受注ID8
		$sql .= "    t_client.client_id, \n";            //得意先ID9
		$sql .= "    t_staff$i.charge_cd,  \n";          //担当者コード10
		$sql .= "    t_client.client_cd1, \n";           //得意先コード1 11
		$sql .= "    t_client.client_cd2, \n";           //得意先コード2 12
		$sql .= "    t_aorder_h.tax_amount, \n";         //消費税額 13
		$sql .= "    t_staff$i.sale_rate,  \n";          //売上率 14
		$sql .= "    t_aorder_h.confirm_flg \n";         //確定フラグ 15

		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "        (SELECT  \n";
		$sql .= "             t_aorder_staff.aord_id, \n";
		$sql .= "             t_staff.staff_id, \n";
		$sql .= "             t_staff.staff_name, \n";
		$sql .= "             t_staff.staff_cd1, \n";
		$sql .= "             t_staff.staff_cd2, \n";
		$sql .= "             t_staff.charge_cd, \n";
		$sql .= "             t_aorder_staff.sale_rate  \n";
		$sql .= "         FROM  \n";
		$sql .= "             t_aorder_staff  \n";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id  \n";
		$sql .= "         WHERE  \n";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."' \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate != '0'  \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL  \n";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id  \n";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";
		$sql .= "    INNER JOIN t_client AS t_act ON t_act.client_id = t_aorder_h.act_id  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";

		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.act_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_act.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND \n";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";

		$sql .= "UNION  \n";

		//更新後
		$sql .= "SELECT  \n";
		$sql .= "    t_act.shop_name, \n";               //受託先名0
		$sql .= "    t_aorder_h.act_id, \n";             //受託先ID1
		$sql .= "    t_act.client_cd1, \n";              //受託先コード1 2
		$sql .= "    t_act.client_cd2, \n";              //受託先コード2 3
		$sql .= "    sale_h.net_amount, \n";             //売上金額4
		$sql .= "    t_aorder_h.ord_time, \n";           //受注日5
		$sql .= "    t_aorder_h.route, \n";              //順路6
		$sql .= "    t_aorder_h.client_cname, \n";       //得意先名7
		$sql .= "    sale_h.sale_id, \n";                //売上ID8
		$sql .= "    t_client.client_id,  \n";           //得意先ID9
		$sql .= "    t_staff$i.charge_cd,  \n";          //担当者コード10
		$sql .= "    t_client.client_cd1, \n";           //得意先コード1 11
		$sql .= "    t_client.client_cd2, \n";           //得意先コード2 12
		$sql .= "    sale_h.tax_amount, \n";             //消費税額 13
		$sql .= "    t_staff$i.sale_rate, \n";           //売上率 14
		$sql .= "    t_aorder_h.confirm_flg \n";         //確定フラグ 15

		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "        (SELECT  \n";
		$sql .= "             t_aorder_staff.aord_id, \n";
		$sql .= "             t_staff.staff_id, \n";
		$sql .= "             t_aorder_staff.staff_name, \n";
		$sql .= "             t_staff.staff_cd1, \n";
		$sql .= "             t_staff.staff_cd2, \n";
		$sql .= "             t_staff.charge_cd, \n";
		$sql .= "             t_aorder_staff.sale_rate  \n";
		$sql .= "         FROM  \n";
		$sql .= "             t_aorder_staff  \n";
		$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id  \n";
		$sql .= "         WHERE  \n";
		$sql .= "             t_aorder_staff.staff_div = '".$aorder_staff[$i]."' \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate != '0'  \n";
		$sql .= "         AND  \n";
		$sql .= "             t_aorder_staff.sale_rate IS NOT NULL  \n";
		$sql .= "        )AS t_staff$i ON t_staff$i.aord_id = t_aorder_h.aord_id  \n";

		$sql .= "    LEFT JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id AND t_attach.h_staff_flg = 'false' \n";

		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";
		$sql .= "    INNER JOIN t_client AS t_act ON t_act.client_id = t_aorder_h.act_id  \n";

		$sql .= "    INNER JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";
		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.act_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_act.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
		$sql .= "    AND \n";
		$sql .= "    t_aorder_h.ord_time >= '$year-$month-$day' \n";
		$sql .= "    AND ";
		$sql .= "    t_aorder_h.ord_time <= '$nyear-$nmonth-$nday' \n";
	}
	$sql .= "ORDER BY  \n";
	$sql .= "    2, \n";
	$sql .= "    3, \n";
	$sql .= "    10, \n";
	$sql .= "    5, \n";
	$sql .= "    6, \n";
	$sql .= "    11, \n";
	$sql .= "    12; \n";

	$result = Db_Query($db_con, $sql);
	$act_data_list = Get_Data($result);

	/****************************/
	//受託先HTML作成
	/****************************/
	$n_data_list = NULL;
	$act_data_flg = false;  //受注データ存在フラグ判定
	for($x=0;$x<count($act_data_list);$x++){
		$ymd = $act_data_list[$x][5];          //巡回日
		$act_id = "daiko".$act_data_list[$x][1];       //受託先ID

		//連想配列に登録する。
		$n_data_list[$act_id][$ymd][] = $act_data_list[$x];
		
		$act_data_list2[$act_id][0][0]++;                          //予定件数

		//予定金額 (売上金額+消費税額)×売上率
		$money1 = $act_data_list[$x][4] + $act_data_list[$x][13];
		$money2 = $act_data_list[$x][14] / 100;
		//売上率判定
		if($money2 != 0){
			//売上率から計算
			$total1 = bcmul($money1,$money2,2);
		}else{
			//オフライン代行の場合は、売上率は無い為乗算しない
			$total1 = $money1;
		}
		$act_data_list2[$act_id][0][1] = bcadd($total1,$act_data_list2[$act_id][0][1]);

		//受注データが存在した
		$act_data_flg = true;
	}
	//print_array($n_data_list);
	//受注データが存在した場合にその担当者データをカレンダー配列に上書き
	if($act_data_flg == true){

		//数値形式変更
		$money_num = NULL;
		$link_data = NULL;

		while($money_num = each($act_data_list2)){
			$money = $money_num[0];
			//予定金額切捨て
			$act_data_list2[$money][0][1] = floor($act_data_list2[$money][0][1]);
			$act_data_list2[$money][0][1] = number_format($act_data_list2[$money][0][1]);
		}
		//指標をリセットする
		reset($act_data_list2);

		/****************************/
		//カレンダーテーブル作成処理
		/****************************/

		//カレンダーHTML
		$date_num_y = NULL;
		$date_num_m = NULL;
		$date_num_d = NULL;

		//ABCD週の表示データ作成
		for($ab=0;$ab<7;$ab++){
			//該当日が何週か取得処理
			$next = mktime(0, 0, 0, $month,$day+$ab,$year);
			$nyear     = date("Y",$next); //年
			$nmonth    = date("m",$next); //月
			$nday      = date("d",$next); //日
			$week[$ab] = date("w",$next); //曜日

			$date_num_y[] = $nyear;       //一週間の年配列
			$date_num_m[] = $nmonth;      //一週間の月配列
			$date_num_d[] = $nday;        //一週間の日配列

			//ABCD判別関数
			//月の最初の日が何週か取得処理
			$base_date = Basic_date($day_by,$day_bm,$day_bd,$nyear,$nmonth,$nday);
			$row = $base_date[0];
			//基準日より過去の日付の場合は、０を代入
			if($row == NULL){
				$row = 0;
			}
			$abcd[$ab] = $row;
		}

		//ABCD週の表示配列
		$abcd_w[1] = "A";
		$abcd_w[2] = "B";
		$abcd_w[3] = "C";
		$abcd_w[4] = "D";

		//ABCD週の結合数取得
		$rowspan = array_count_values($abcd);

		/****************************/
		//カレンダーテーブル上書き処理
		/****************************/
		//受託先ごとに巡回データ作成
		while($act_num = each($n_data_list)){
			//受託先の添字取得
			$act = $act_num[0];

			//先週ボタン
			//非表示判定
			if($bw_disabled_flg == true){
				//非表示
				$form->addElement("button","back_w_button[$act]","<<　先週","disabled");
			}else{
				//表示
				$form->addElement("button","back_w_button[$act]","<<　先週","onClick=\"javascript:Button_Submit('back_w_button_flg','#$act','true')\"");
			}

			//前日ボタン
			//非表示判定
			if($bd_disabled_flg == true){
				//非表示
				$form->addElement("button","back_d_button[$act]","<<　前日","disabled");
			}else{
				//表示
				$form->addElement("button","back_d_button[$act]","<<　前日","onClick=\"javascript:Button_Submit('back_d_button_flg','#$act','true')\"");
			}

			//翌週ボタン
			//非表示判定
			if($nw_disabled_flg == true){
				//非表示
				$form->addElement("button","next_w_button[$act]","翌週　>>","disabled");
			}else{
				//表示
				$form->addElement("button","next_w_button[$act]","翌週　>>","onClick=\"javascript:Button_Submit('next_w_button_flg','#$act','true')\"");
			}

			//翌日ボタン
			//非表示判定
			if($nd_disabled_flg == true){
				//非表示
				$form->addElement("button","next_d_button[$act]","翌日　>>","disabled");
			}else{
				//表示
				$form->addElement("button","next_d_button[$act]","翌日　>>","onClick=\"javascript:Button_Submit('next_d_button_flg','#$act','true')\"");
			}

			/****************************/
			//ABCD週HTML
			/****************************/
			$act_calendar[$act]  = "<tr height=\"40\">";
			$act_calendar[$act] .=	"  <td align=\"center\" bgcolor=\"#cccccc\" width=\"60\"><b>巡回基準</b></td>";
			//ABCD週作成
			while($abcd_num = each($rowspan)){
				//ABCDの添字取得
				$ab_num = $abcd_num[0];
				$act_calendar[$act] .= "  <td align=\"center\" bgcolor=\"#e5e5e5\" colspan=\"".$rowspan[$ab_num]."\" style=\"font-size: 130%; font-weight: bold; padding: 0px;\">".$abcd_w[$ab_num]."</td>";
			}
			$act_calendar[$act] .= "</tr>";
			//指標をリセットする
			reset($rowspan);

			/****************************/
			//曜日HTML
			/****************************/
			$act_calendar[$act]  .= "<tr height=\"20\">";
			$act_calendar[$act]  .= "	<td align=\"center\" bgcolor=\"#cccccc\" rowspan=\"2\" width=\"80\"><b>巡回担当者</b></td>";
			//一週間分表示
			for($w=0;$w<7;$w++){
				//曜日判定
				if($week[$w] == 6 && $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] != 1){
					//土曜かつ休日ではない
					$act_calendar[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
				}else if($week[$w] == 0 || $holiday[$date_num_y[$w]."-".$date_num_m[$w]."-".$date_num_d[$w]] == 1){
					//日曜or休日
					$act_calendar[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
				}else{
					//月〜金
					$act_calendar[$act] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
				}
				$act_calendar[$act] .= $week_w[$week[$w]]."</b></td>";
			}
			$act_calendar[$act] .= "</tr>";

			//受託先名
			$num1 = each($n_data_list[$act]);
			$num2 = each($n_data_list[$act][$num1[0]]);
			$act_name = $n_data_list[$act][$num1[0]][$num2[0]][0];
			$act_calendar2[$act]  = "<tr>";
			$act_calendar2[$act]  .= "<td width=\"80px\" align=\"center\" valign=\"center\" bgcolor=\"#E5E5E5\" >";
			$act_calendar2[$act]  .= "<font size=\"2\">$act_name</font></td>";

			//一週間分表示
			for($d=0;$d<7;$d++){
				//曜日判定
				if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
					//土曜かつ休日ではない
					$act_calendar2[$act] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" class=\"cal3\" width=\"13%\">";
				}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
					//日曜or休日
					$act_calendar2[$act] .= "	    <td width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" class=\"cal3\" width=\"13%\">";
				}else{
					//月〜金
					$act_calendar2[$act] .= "       <td width=\"135px\" align=\"left\" valign=\"top\" class=\"cal3\" width=\"13%\">";
				}
				//データ存在判定
				$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];

				//該当日に巡回データが複数存在した場合、その件数分表示
				for($y=0;$y<count($n_data_list[$act][$date]);$y++){

					//該当日に巡回データが存在するか判定
					if($n_data_list[$act][$date][$y][8] != NULL){

						//データが存在した為、その日をリンクにする
						$link_data[$act][$d] = true;

						//予定明細に渡す受注ID配列作成
						for($p=0;$p<count($n_data_list[$act][$date]);$p++){
							$aord_id_array[$act][$date][$p] = $n_data_list[$act][$date][$p][6];
						}

						//順路指定判定
						if($n_data_list[$act][$date][$y][6] != NULL){
							//順路形式変更
							$route = str_pad($n_data_list[$act][$date][$y][6], 4, 0, STR_POS_LEFT);
							$route1 = substr($route,0,2);
							$route2 = substr($route,2,2);
							$route = $route1."-".$route2;
						}else{
							//オフライン代行の場合は空白表示
							$route = "　 　";
						}

						//リンク色判定
						if($n_data_list[$act][$date][$y][15] == "t"){
							//確定伝票
							//遷移先：予定訂正ダイアログ
							$act_calendar2[$act] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
							$act_calendar2[$act] .= "450,200,".$n_data_list[$act][$date][$y][9].",".$n_data_list[$act][$date][$y][8].")\" style=\"color: gray;\">";
							$act_calendar2[$act] .= $n_data_list[$act][$date][$y][7]."</a><br>";
						}elseif($n_data_list[$act][$date][$y][1] != NULL){
							//代行伝票
							//遷移先：予定訂正ダイアログ
							$act_calendar2[$act] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
							$act_calendar2[$act] .= "450,200,".$n_data_list[$act][$date][$y][9].",".$n_data_list[$act][$date][$y][8].")\" style=\"color: green;\">";
							$act_calendar2[$act] .= $n_data_list[$act][$date][$y][7]."</a><br>";
						}
					}
				}
				$act_calendar2[$act] .= "</font></td>";
			}
			$act_calendar2[$act] .= "</tr>";
		}

		/****************************/
		//日付HTML上書き処理
		/****************************/
		$act_calendar3[$act]  = "<tr height=\"20\" style=\"font-size: 130%; font-weight: bold; \">";
		//一週間分表示
		for($d=0;$d<7;$d++){
			//曜日判定
			if($week[$d] == 6 && $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] != 1){
				//土曜かつ休日ではない
				$act_calendar3[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#99FFFF\"><b>";
			}else if($week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
				//日曜or休日
				$act_calendar3[$act] .= "	    <td width=\"135px\" align=\"center\" bgcolor=\"#FFDDE7\"><b>";
			}else{
				//月〜金
				$act_calendar3[$act] .= "<td width=\"135px\" align=\"center\" bgcolor=\"#cccccc\"><b>";
			}
			//土日休判定
			if($week[$d] == 6 || $week[$d] == 0 || $holiday[$date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d]] == 1){
				//日付リンク判定
				if($link_data[$act][$d] == true){
					
					//該当日の受注ID全てを予定明細に渡す
					$aord_id_array2 = NULL;
					//週の日付
					$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
					while($aord_num = each($aord_id_array)){
						//受託先ID
						$aord_act_id = $aord_num[0];
						//受託先の週の日付にデータがあった場合に、受注ID配列に追加
						for($p=0;$p<count($aord_id_array[$aord_act_id][$date]);$p++){
							$aord_id_array2[] = $aord_id_array[$aord_act_id][$date][$p];
						}
					}
					//指標をリセットする
					reset($aord_id_array);

					//シリアライズ化
					$array_id = serialize($aord_id_array2);
					$array_id = urlencode($array_id);

					//土日休（リンク）
					$act_calendar3[$act] .= "<a href=\"2-2-106.php?aord_id_array=".$array_id."\" style=\"color: #555555;\">";
					$act_calendar3[$act] .= $date_num_d[$d]."</b></td>";
				}else{
					//土日休（リンクなし）
					$act_calendar3[$act] .= $date_num_d[$d]."</b></td>";
				}
			}else{
				//日付リンク判定
				if($link_data[$act][$d] == true){
					
					//該当日の受注ID全てを予定明細に渡す
					$aord_id_array2 = NULL;
					//週の日付
					$date = $date_num_y[$d]."-".$date_num_m[$d]."-".$date_num_d[$d];
					while($aord_num = each($aord_id_array)){
						//受託先ID
						$aord_act_id = $aord_num[0];
						//受託先の週の日付にデータがあった場合に、受注ID配列に追加
						for($p=0;$p<count($aord_id_array[$aord_act_id][$date]);$p++){
							$aord_id_array2[] = $aord_id_array[$aord_act_id][$date][$p];
						}
					}
					//指標をリセットする
					reset($aord_id_array);

					//シリアライズ化
					$array_id = serialize($aord_id_array2);
					$array_id = urlencode($array_id);

					//月〜金（リンク）
					$act_calendar3[$act] .= "<a href=\"2-2-106.php?aord_id_array=".$array_id."\" style=\"color: #555555;\">".$date_num_d[$d]."</b></td>";
				}else{
					//月〜金（リンクなし）
					$act_calendar3[$act] .= $date_num_d[$d]."</b></td>";
				}
			}
		}
		$act_calendar3[$act] .= "</tr>";
	}
}

//データが無い場合は、リンク先指定なしのボタン作成
if($staff_data_flg == false){

	//先週ボタン
	//非表示判定
	if($bw_disabled_flg == true){
		//非表示
		$form->addElement("button","back_w_button","<<　先週","disabled");
	}else{
		//表示
		$form->addElement("button","back_w_button","<<　先週","onClick=\"javascript:Button_Submit('back_w_button_flg','#','true')\"");
	}

	//前日ボタン
	//非表示判定
	if($bd_disabled_flg == true){
		//非表示
		$form->addElement("button","back_d_button","<<　前日","disabled");
	}else{
		//表示
		$form->addElement("button","back_d_button","<<　前日","onClick=\"javascript:Button_Submit('back_d_button_flg','#','true')\"");
	}

	//翌週ボタン
	//非表示判定
	if($nw_disabled_flg == true){
		//非表示
		$form->addElement("button","next_w_button","翌週　>>","disabled");
	}else{
		//表示
		$form->addElement("button","next_w_button","翌週　>>","onClick=\"javascript:Button_Submit('next_w_button_flg','#','true')\"");
	}

	//翌日ボタン
	//非表示判定
	if($nd_disabled_flg == true){
		//非表示
		$form->addElement("button","next_d_button","翌日　>>","disabled");
	}else{
		//表示
		$form->addElement("button","next_d_button","翌日　>>","onClick=\"javascript:Button_Submit('next_d_button_flg','#','true')\"");
	}
	
	$data_msg = "巡回データがありません。";
}

/*
print "<pre>";
print_r ($keys_list);
print "</pre>";
*/

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
$page_menu = Create_Menu_f('sale','1');

/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　".$form->_elements[$form->_elementIndex[form_single_month_change_button]]->toHtml();
$page_title .= "　".$form->_elements[$form->_elementIndex[form_master_change_button]]->toHtml();
//$page_title .= "　".$form->_elements[$form->_elementIndex[form_patrol_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);


//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'     => "$html_header",
	'page_menu'       => "$page_menu",
	'page_header'     => "$page_header",
	'html_footer'     => "$html_footer",
	'year'            => "$year",
	'month'           => "$month",
	'staff_data_flg'  => "$staff_data_flg",
	'charge_data_flg' => "$charge_data_flg",
	'cal_range'       => "$cal_range",
	'data_msg'        => "$data_msg",
));

//表示データ
$smarty->assign("disp_data", $data_list2);
$smarty->assign("calendar", $calendar);
$smarty->assign("calendar2", $calendar2);
$smarty->assign("calendar3", $calendar3);

$smarty->assign("act_disp_data", $act_data_list2);
$smarty->assign("act_calendar", $act_calendar);
$smarty->assign("act_calendar2", $act_calendar2);
$smarty->assign("act_calendar3", $act_calendar3);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>

