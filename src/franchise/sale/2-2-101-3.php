<?php
$page_title = "巡回予定カレンダー(月)";

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

//巡回基準日
$sql  = "SELECT stand_day FROM t_stand;";
$result = Db_Query($db_con, $sql); 
$stand_day = pg_fetch_result($result,0,0);   
$day_by = substr($stand_day,0,4);
$day_bm = substr($stand_day,5,2);
$day_bd = substr($stand_day,8,2);

//巡回基準日の月の日数取得
$stand_num = date("t",mktime(0, 0, 0,$day_bm,1,$day_by));
$monday_array = NULL;   //月曜日配列
//巡回基準日の月の、月曜日の日付を取得
for($s=1;$s<=$stand_num;$s++){
	$monday = date('w', mktime(0, 0, 0,$day_bm,$s,$day_by));
	//月曜か判定
	if($monday == 1){
		$monday_array[] = date('d', mktime(0, 0, 0,$day_bm,$s,$day_by));
	}
}
//巡回基準日の週を取得
for($s=0;$s<count($monday_array);$s++){
	if($day_bd == $monday_array[$s]){
		$stand_day_week = $s+1;
	}
}

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
//初期表示
/****************************/
$def_fdata = array(
    "form_output"     => "1",

);
$form->setDefaults($def_fdata);

/****************************/
//POST情報取得
/****************************/
$post_part_id = $_POST["form_part_1"];    //部署
$post_staff_id = $_POST["form_staff_1"];  //担当者

/****************************/
//フォーム定義
/****************************/
//出力形式
$radio1[] =& $form->createElement( "radio",NULL,NULL, "画面","1");
$radio1[] =& $form->createElement( "radio",NULL,NULL, "帳票","2");
$form->addGroup($radio1, "form_output", "出力形式");

//部署
$select_value = NULL;
$select_value = Select_Get($db_con,'part');
$form->addElement('select', 'form_part_1', 'セレクトボックス', $select_value,$g_form_option_select);

//担当者
$select_value = NULL;
$select_value = Select_Get($db_con,'cstaff');
$form->addElement('select', 'form_staff_1', 'セレクトボックス', $select_value,$g_form_option_select);

//表示ボタン
$button[] = $form->createElement("submit","indicate_button","表　示","onClick=\"javascript:Which_Type('form_output','".FC_DIR."sale/2-2-103.php','#')\"");

//クリアボタン
$button[] = $form->createElement("button","clear_button","クリア","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$form->addGroup($button, "form_button", "ボタン");

//単月変更
$form->addElement("button","form_single_month_change_button","照　会","onClick=\"javascript:Referer('2-2-101-2.php')\"");
//マスタ変更
$form->addElement("button","form_master_change_button","変　更","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//伝票作成
$form->addElement("button","form_slip_button","伝票作成","onClick=\"javascript:Referer('2-2-201.php')\"");
//コース表示ボタン
$form->addElement("button","form_course","コース表示");

$form->addElement("hidden", "back_button_flg");     //前月ボタン押下判定
$form->addElement("hidden", "next_button_flg");     //翌月ボタン押下判定
$form->addElement("hidden", "next_count");          //今月から何ヶ月後
$form->addElement("hidden", "back_count");          //今月から何ヶ月前

/****************************/
//得意先情報取得
/****************************/
//カレンダー表示期間取得
$sql  = "SELECT ";
$sql .= "    cal_peri ";    //カレンダー表示期間
$sql .= "FROM ";
$sql .= "    t_client ";
$sql .= "WHERE ";
$sql .= "    client_id = $client_id;";
$result = Db_Query($db_con, $sql);
$num = pg_num_rows($result);
//ボタンの間に表示する為だけのカレンダー表示期間の範囲
if($num == 1){
	//今月＋カレンダー表示期間分表示
	$num_range = pg_fetch_result($result, 0,0);
	//仮表示期間
	$num_range++;
}else{
	//今月＋一ヶ月
	$num_range = 1;
}

//担当者指定判定
if($post_staff_id != NULL){
	//担当者を指定した場合、データをカレンダー表示期間分表示

	//存在判定
	if($num == 1){
		//今月＋カレンダー表示期間分表示
		$cal_peri = $num_range;
	}else{
		//今月＋一ヶ月
		$cal_peri = 1;
	}
}else{
	//指定なしの場合は、一ヶ月分データ表示
	//一ヶ月分表示
	$cal_peri = 1;
}

/****************************/
//日付データ取得
/****************************/
//前月の月取得
$str = mktime(0, 0, 0, date("n")-1,1,date("Y"));
$b_year  = date("Y",$str);
$b_month = date("m",$str);

//カレンダー表示期間の最後の月取得
$str = mktime(0, 0, 0, date("n")+$num_range,1,date("Y"));
$c_year  = date("Y",$str);
$c_month = date("m",$str);

//担当者が指定されている場合は、ループの数を増やす
if($post_staff_id != NULL){
	$cal_peri++;
}

//カレンダー表示期間
$cal_range = $b_year."年 ".$b_month."月 〜 ".$c_year."年 ".$c_month."月";

//カレンダーHTML
$calendar = NULL;
$cal_data_flg = false;  //全ての担当者の受注データ存在フラグ判定

//カレンダー表示期間分、カレンダー表示HTML作成
for($y=0;$y<$cal_peri;$y++){

	/****************************/
	//表示する日付データ取得
	/****************************/

	//表示する月取得
	$str = mktime(0, 0, 0, date("n")+$y,1,date("Y"));
	$year[$y]  = date("Y",$str);
	$month[$y] = date("m",$str);

	//月の日数取得
	$day = date("t",mktime(0, 0, 0, $month[$y],1,$year[$y]));
	//月の最初の日の曜日
	$first_day = date('w', mktime(0, 0, 0, date("n")+$y, 1, date("Y")));
	//月の最後の日の曜日
	$last_day = date('w', mktime(0, 0, 0, date("n")+$y, $day, date("Y")));

	/****************************/
	//前月ボタン押下処理
	/****************************/
	if($_POST["back_button_flg"] == true){
		//POST判定
		if($_POST["back_count"] == NULL){
			//無い
			$back_count = 1;
		}else{
			//有る
			//今月に、月数分引く
	    	$back_count = $_POST["back_count"]+1;
		}

		//POST判定
		if($_POST["next_count"] == NULL){
			//無い、
			$next_count = 0;
		}else{
			//有る
			//今月に、月数分足す
	    	$next_count = $_POST["next_count"];
		}

	    //翌月ボタンフラグをクリア
	    $next_data["back_button_flg"] = "";
		$back_data["back_count"]      = $back_count;
	    $form->setConstants($back_data);

		//今月の月取得
		$str = mktime(0, 0, 0, $month[$y]-$back_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("n",$str);

		//足した分の月を考慮する
		$str = mktime(0, 0, 0, $month[$y]+$next_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("m",$str);

		//前月は、今月から見て一ヶ月前しかださないように判定する
		$l_day = date("Y-m-d", mktime(0, 0, 0, date("n")-1,1,date("Y")));
		if($year[$y]."-".$month[$y]."-01" == $l_day){
			//前月ボタンを非表示にする
			$b_disabled_flg = true;
		}

		//前月ボタンフラグをクリア
	    $back_data["back_button_flg"] = "";
	    $form->setConstants($back_data);

		//月の日数取得
		$day = date("t",mktime(0, 0, 0, $month[$y],1,$year[$y]));
		//月の最初の日の曜日
		$first_day = date('w', mktime(0, 0, 0, date("n")-$back_count+$next_count, 1, date("Y")));
		//月の最後の日の曜日
		$last_day = date('w', mktime(0, 0, 0, date("n")-$back_count+$next_count, $day, date("Y")));
	}

	/****************************/
	//翌月ボタン押下処理
	/****************************/
	if($_POST["next_button_flg"] == true){

		//POST判定
		if($_POST["next_count"] == NULL){
			//無い、
			$next_count = 1;
		}else{
			//有る
			//今月に、月数分足す
	    	$next_count = $_POST["next_count"]+1;
		}

		//POST判定
		if($_POST["back_count"] == NULL){
			//無い
			$back_count = 0;
		}else{
			//有る
			//今月に、月数分引く
	    	$back_count = $_POST["back_count"];
		}

	    //翌月ボタンフラグをクリア
	    $next_data["next_button_flg"] = "";
		$next_data["next_count"]      = $next_count;
	    $form->setConstants($next_data);

		//今月の月取得
		$str = mktime(0, 0, 0, $month[$y]+$next_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("n",$str);
		//引いた分の月を考慮する
		$str = mktime(0, 0, 0, $month[$y]-$back_count,1,$year[$y]);
		$year[$y]  = date("Y",$str);
		$month[$y] = date("m",$str);

		//カレンダー表示期間分しか表示させない為判定
		$f_day = date("Y-m-d", mktime(0, 0, 0, date("n")+$num_range,1,date("Y")));
		if($year[$y]."-".$month[$y]."-01" == $f_day){
			//翌月ボタンを非表示にする
			$n_disabled_flg = true;
		}

		//月の日数取得
		$day = date("t",mktime(0, 0, 0, $month[$y],1,$year[$y]));
		//月の最初の日の曜日
		$first_day = date('w', mktime(0, 0, 0, date("n")+$next_count-$back_count, 1, date("Y")));
		//月の最後の日の曜日
		$last_day = date('w', mktime(0, 0, 0, date("n")+$next_count-$back_count, $day, date("Y")));
	}

	//日曜判定
	if($first_day == 0){
		//日曜
		$first_day = 6;
	}else{
		//以外
		$first_day = $first_day-1;
	}
	//日曜判定
	if($last_day == 0){
		//日曜
		$last_day = 6;
	}else{
		//以外
		$last_day = $last_day-1;
	}

	//月の週の数を得る
	$last_week_days = ($day + $first_day) % 7;
	if ($last_week_days == 0){
		$weeks = ($day + $first_day) / 7;
	}else{
		$weeks = ceil(($day + $first_day) / 7);
	}

	/****************************/
	//照会データ取得（契約区分が通常）
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
		$sql .= "    t_part.part_name, \n";              //部署名0
		$sql .= "    t_staff$i.staff_name, \n";          //スタッフ名1
		$sql .= "    t_aorder_h.net_amount, \n";         //売上金額2
		$sql .= "    t_aorder_h.ord_time, \n";           //受注日3
		$sql .= "    t_aorder_h.route, \n";              //順路4
		$sql .= "    t_client.client_cname, \n";         //得意先名5
		$sql .= "    t_aorder_h.aord_id, \n";            //受注ID6
		$sql .= "    t_aorder_h.hand_slip_flg, \n";      //手書伝票フラグ7
		$sql .= "    t_aorder_h.reserve_del_flg, \n";    //保留伝票削除フラグ8
		$sql .= "    t_aorder_h.confirm_flg,  \n";       //更新フラグ9
		$sql .= "    t_staff$i.staff_cd1, \n";           //スタッフコード1 10
		$sql .= "    t_staff$i.staff_cd2,  \n";          //スタッフコード2 11
		$sql .= "    t_staff$i.staff_id,  \n";           //スタッフID12
		$sql .= "    t_aorder_h.reason, \n";             //保留理由13
		$sql .= "    t_aorder_h.confirm_flg, \n";        //確定伝票14
		$sql .= "    t_client.client_id, \n";            //得意先ID15
		$sql .= "    t_staff$i.charge_cd,  \n";          //担当者コード16
		$sql .= "    t_client.client_cd1, \n";           //得意先コード1 17
		$sql .= "    t_client.client_cd2, \n";           //得意先コード2 18
		$sql .= "    t_aorder_h.tax_amount, \n";         //消費税額 19
		$sql .= "    t_staff$i.sale_rate,  \n";          //売上率 20
		$sql .= "    t_part.part_cd, \n";                //部署名CD 21
		$sql .= "    t_aorder_h.shop_id, \n";            //取引先ID 22
		$sql .= "    t_staff_count.num,\n";              //伝票人数 23
		$sql .= "    t_aorder_h.act_id, \n";             //代行先ID 24
		$sql .= "    t_aorder_h.trust_confirm_flg \n";   //確定伝票(受託先) 25

		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

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

		$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id  \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

		$sql .= "    LEFT JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";

		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ps_stat != '4'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.contract_div = '1' \n";
		$sql .= "    AND  \n";
		$sql .= "    t_attach.h_staff_flg = 'false'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";

		//部署指定判定
		if($post_part_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_part.part_id = $post_part_id  \n";
		}
		//担当者指定判定
		if($post_staff_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
		}

		$sql .= "UNION  \n";

		//更新後
		$sql .= "SELECT  \n";
		$sql .= "    t_part.part_name, \n";              //部署名0
		$sql .= "    t_staff$i.staff_name, \n";          //スタッフ名1
		$sql .= "    sale_h.net_amount, \n";             //売上金額2
		$sql .= "    t_aorder_h.ord_time, \n";           //受注日3
		$sql .= "    t_aorder_h.route, \n";              //順路4
		$sql .= "    t_aorder_h.client_cname, \n";       //得意先名5
		$sql .= "    sale_h.sale_id, \n";                //売上ID6
		$sql .= "    t_aorder_h.hand_slip_flg, \n";      //手書伝票フラグ7
		$sql .= "    t_aorder_h.reserve_del_flg, \n";    //保留伝票削除フラグ8
		$sql .= "    t_aorder_h.confirm_flg, \n";        //更新フラグ9
		$sql .= "    t_staff$i.staff_cd1, \n";           //スタッフコード1 10
		$sql .= "    t_staff$i.staff_cd2, \n";           //スタッフコード2 11
		$sql .= "    t_staff$i.staff_id,  \n";           //スタッフID12
		$sql .= "    t_aorder_h.reason,  \n";            //保留理由13
		$sql .= "    t_aorder_h.confirm_flg, \n";        //確定伝票14
		$sql .= "    t_client.client_id,  \n";           //得意先ID15
		$sql .= "    t_staff$i.charge_cd,  \n";          //担当者コード16
		$sql .= "    t_client.client_cd1, \n";           //得意先コード1 17
		$sql .= "    t_client.client_cd2, \n";           //得意先コード2 18
		$sql .= "    sale_h.tax_amount, \n";             //消費税額 19
		$sql .= "    t_staff$i.sale_rate, \n";           //売上率 20
		$sql .= "    t_part.part_cd, \n";                //部署名CD 21
		$sql .= "    t_aorder_h.shop_id, \n";            //取引先ID 22
		$sql .= "    t_staff_count.num, \n";             //伝票人数 23
		$sql .= "    t_aorder_h.act_id, \n";             //代行先ID 24
		$sql .= "    t_aorder_h.trust_confirm_flg \n";   //確定伝票(受託先) 25
		   
		$sql .= "FROM  \n";

		$sql .= "    t_aorder_h  \n";

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

		$sql .= "    INNER JOIN t_attach ON t_staff$i.staff_id = t_attach.staff_id  \n";

		$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
		$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

		$sql .= "    INNER JOIN  \n";
		$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

		$sql .= "WHERE  \n";
		if($_SESSION["group_kind"] == '2'){
		    $sql .= "    t_aorder_h.shop_id IN (".Rank_Sql().") \n";
		}else{
		    $sql .= "    t_aorder_h.shop_id = $client_id  \n";
		}
		$sql .= "    AND  \n";
		$sql .= "    t_client.state = '1'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_attach.h_staff_flg = 'false'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.contract_div = '1' \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
		$sql .= "    AND  \n";
		$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";
		//部署指定判定
		if($post_part_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_part.part_id = $post_part_id  \n";
		}
		//担当者指定判定
		if($post_staff_id != NULL){
			$sql .= "    AND  \n";
			$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
		}

		//FCの場合は、代行のカレンダーは結合して表示
		if($_SESSION["group_kind"] == '3'){
			$sql .= "UNION  \n";

			//更新前
			$sql .= "SELECT  \n";
			$sql .= "    t_part.part_name, \n";              //部署名0
			$sql .= "    t_staff$i.staff_name, \n";          //スタッフ名1
			$sql .= "    t_aorder_h.net_amount, \n";         //売上金額2
			$sql .= "    t_aorder_h.ord_time, \n";           //受注日3
			$sql .= "    t_aorder_h.route, \n";              //順路4
			$sql .= "    t_client.client_cname, \n";         //得意先名5
			$sql .= "    t_aorder_h.aord_id, \n";            //受注ID6
			$sql .= "    t_aorder_h.hand_slip_flg, \n";      //手書伝票フラグ7
			$sql .= "    t_aorder_h.reserve_del_flg, \n";    //保留伝票削除フラグ8
			$sql .= "    t_aorder_h.confirm_flg,  \n";       //更新フラグ9
			$sql .= "    t_staff$i.staff_cd1, \n";           //スタッフコード1 10
			$sql .= "    t_staff$i.staff_cd2,  \n";          //スタッフコード2 11
			$sql .= "    t_staff$i.staff_id,  \n";           //スタッフID12
			$sql .= "    t_aorder_h.reason, \n";             //保留理由13
			$sql .= "    t_aorder_h.confirm_flg, \n";        //確定伝票14
			$sql .= "    t_client.client_id, \n";            //得意先ID15
			$sql .= "    t_staff$i.charge_cd,  \n";          //担当者コード16
			$sql .= "    t_client.client_cd1, \n";           //得意先コード1 17
			$sql .= "    t_client.client_cd2, \n";           //得意先コード2 18
			$sql .= "    t_aorder_h.tax_amount, \n";         //消費税額 19
			$sql .= "    t_staff$i.sale_rate,  \n";          //売上率 20
			$sql .= "    t_part.part_cd, \n";                //部署名CD 21
			$sql .= "    t_aorder_h.shop_id, \n";            //取引先ID 22
			$sql .= "    NULL,\n";                           //伝票人数 23
			$sql .= "    t_aorder_h.act_id, \n";             //代行先ID 24
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //確定伝票(受託先) 25

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

			$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
			$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

			$sql .= "    LEFT JOIN  \n";
			$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'false')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

			$sql .= "WHERE  \n";

			$sql .= "    t_aorder_h.act_id = $client_id  \n";
			
			$sql .= "    AND  \n";
			$sql .= "    t_client.state = '1'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ps_stat != '4'  \n";
			$sql .= "    AND  \n";
			$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";

			//部署指定判定
			if($post_part_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_part.part_id = $post_part_id  \n";
			}
			//担当者指定判定
			if($post_staff_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
			}

			$sql .= "UNION  \n";

			//更新後
			$sql .= "SELECT  \n";
			$sql .= "    t_part.part_name, \n";              //部署名0
			$sql .= "    t_staff$i.staff_name, \n";          //スタッフ名1
			$sql .= "    sale_h.net_amount, \n";             //売上金額2
			$sql .= "    t_aorder_h.ord_time, \n";           //受注日3
			$sql .= "    t_aorder_h.route, \n";              //順路4
			$sql .= "    t_aorder_h.client_cname, \n";       //得意先名5
			$sql .= "    sale_h.sale_id, \n";                //売上ID6
			$sql .= "    t_aorder_h.hand_slip_flg, \n";      //手書伝票フラグ7
			$sql .= "    t_aorder_h.reserve_del_flg, \n";    //保留伝票削除フラグ8
			$sql .= "    t_aorder_h.confirm_flg, \n";        //更新フラグ9
			$sql .= "    t_staff$i.staff_cd1, \n";           //スタッフコード1 10
			$sql .= "    t_staff$i.staff_cd2, \n";           //スタッフコード2 11
			$sql .= "    t_staff$i.staff_id,  \n";           //スタッフID12
			$sql .= "    t_aorder_h.reason,  \n";            //保留理由13
			$sql .= "    t_aorder_h.confirm_flg, \n";        //確定伝票14
			$sql .= "    t_client.client_id,  \n";           //得意先ID15
			$sql .= "    t_staff$i.charge_cd,  \n";          //担当者コード16
			$sql .= "    t_client.client_cd1, \n";           //得意先コード1 17
			$sql .= "    t_client.client_cd2, \n";           //得意先コード2 18
			$sql .= "    sale_h.tax_amount, \n";             //消費税額 19
			$sql .= "    t_staff$i.sale_rate, \n";           //売上率 20
			$sql .= "    t_part.part_cd, \n";                //部署名CD 21
			$sql .= "    t_aorder_h.shop_id, \n";            //取引先ID 22
			$sql .= "    NULL, \n";                          //伝票人数 23
			$sql .= "    t_aorder_h.act_id, \n";             //代行先ID 24
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //確定伝票(受託先) 25
	  
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

			$sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id  \n";
			$sql .= "    INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id  \n";

			$sql .= "    INNER JOIN  \n";
			$sql .= "    (SELECT * FROM t_sale_h WHERE renew_flg = 'true')AS sale_h ON t_aorder_h.aord_id = sale_h.aord_id  \n";

			$sql .= "WHERE  \n";
	
		    $sql .= "    t_aorder_h.act_id = $client_id  \n";

			$sql .= "    AND  \n";
			$sql .= "    t_client.state = '1'  \n";
			$sql .= "    AND  \n";
			$sql .= "    (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";
			//部署指定判定
			if($post_part_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_part.part_id = $post_part_id  \n";
			}
			//担当者指定判定
			if($post_staff_id != NULL){
				$sql .= "    AND  \n";
				$sql .= "    t_staff$i.staff_id = $post_staff_id  \n";
			}
		}
	}
	$sql .= "ORDER BY  \n";
	$sql .= "    part_cd, \n";
	$sql .= "    charge_cd, \n";
	$sql .= "    ord_time, \n";
	$sql .= "    route, \n";
	$sql .= "    client_cd1, \n";
	$sql .= "    client_cd2; \n";

	$result = Db_Query($db_con, $sql);
	$data_list = Get_Data($result);

	/****************************/
	//巡回担当者HTML作成
	/****************************/
	$n_data_list = NULL;
	$staff_data_flg = false;  //受注データ存在フラグ判定

	for($x=0;$x<count($data_list);$x++){
		$ymd = $data_list[$x][3];          //巡回日
		$staff_id = $data_list[$x][12];    //スタッフID

		//連想配列に登録する。
		$n_data_list[$staff_id][$ymd][] = $data_list[$x];
	
		$data_list2[$staff_id][$y][0][0] = $data_list[$x][0];    //部署名
		$data_list2[$staff_id][$y][0][1] = $data_list[$x][1];    //スタッフ名
		$data_list2[$staff_id][$y][0][2]++;                          //予定件数

		//予定金額 (売上金額+消費税額)×売上率
		$money1 = $data_list[$x][2] + $data_list[$x][19];
		$money2 = $data_list[$x][20] / 100;
		//売上率判定
		if($money2 != 0){
			//売上率から計算
			$total1 = bcmul($money1,$money2,2);
		}else{
			//オフライン代行の場合は、売上率は無い為乗算しない
			$total1 = $money1;
		}
		$data_list2[$staff_id][$y][0][3] = bcadd($total1,$data_list2[$staff_id][$y][0][3]);

		//受注データが存在した
		$staff_data_flg = true;
		//一件以上受注データが存在した
		$cal_data_flg = true;
	}

	//受注データが存在した場合にその担当者データをカレンダー配列作成
	if($staff_data_flg == true){
		/****************************/
		//カレンダーテーブル処理
		/****************************/

		//数値形式変更
		while($money_num = each($data_list2)){
			$money = $money_num[0];
			//予定金額切捨て
			$data_list2[$money][$y][0][3] = floor($data_list2[$money][$y][0][3]);
			$data_list2[$money][$y][0][3] = number_format($data_list2[$money][$y][0][3]);
		}
		//指標をリセットする
		reset($data_list2);

		//ABCD週の表示配列
		$abcd[1] = "A";
		$abcd[2] = "B";
		$abcd[3] = "C";
		$abcd[4] = "D";

		//ABCD配列の添字
		//基準日の月か判定
		if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
			//基準日から始まる為A週にする
			$base_date[0] = 1;
		}else{
			//月の最初の日が何週か取得処理
			$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
		}
		$row = $base_date[0];

		$day_num = 0;   //カレンダーに表示させる日
		$day_num2 = 0;  //データを表示させる為に使用する日

		//担当者ごとに巡回データ作成
		while($staff_num = each($n_data_list)){
			//担当者の添字取得
			$staff = $staff_num[0];

			//前月ボタン
			//非表示判定
			if($b_disabled_flg == true){
				//非表示
				$form->addElement("button","back_button[$staff]","<<　前月","disabled");
			}else{
				//表示
				$form->addElement("button","back_button[$staff]","<<　前月","onClick=\"javascript:Button_Submit('back_button_flg','#$staff','true')\"");
			}

			//翌月ボタン
			//非表示判定
			if($n_disabled_flg == true){
				//非表示
				$form->addElement("button","next_button[$staff]","翌月　>>","disabled");
			}else{
				//表示
				$form->addElement("button","next_button[$staff]","翌月　>>","onClick=\"javascript:Button_Submit('next_button_flg','#$staff','true')\"");
			}

			//月のカレンダー作成
			for($c=1;$c<=$weeks;$c++){
				//既にカレンダー配列が作成されているか判定
				if($c==1 && $calendar[$staff][$y] != NULL){
					//既にあった場合は配列を上書きする
					$calendar[$staff][$y] = "<tr class=\"cal_flame\">";
				}else{
					//二行目からは、配列にただ結合する
					$calendar[$staff][$y] .= "<tr class=\"cal_flame\">";
				}

				$calendar[$staff][$y] .= "	    <td align=\"center\" valign=\"center\" bgcolor=\"#e5e5e5\" rowspan=\"2\">";
				//巡回基準日の月の場合は、基準日の週からABCD週を表示。基準日の月以外は、通常通り表示
				if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
					$calendar[$staff][$y] .= $abcd[$row];
				}
				$calendar[$staff][$y] .= "      </td>";
				$j=0;
				//セルの上作成処理
				while($j<7){
					//休日判定を行なうか判定
					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						//月がまだ始まっていない為、休日判定を行わない
						$cal_flg = true;
					}else{
						//月が開始された為、休日判定を行なう
						$cal_flg = false;

						//休日判定に使用するセルの日付取得
						$cal_num = $day_num + 1;
						$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
						$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
					}

					//曜日判定
					if($j == 5 && ($holiday[$cal_date] != 1)){
						//土曜かつ休日ではない
						$calendar[$staff][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#99FFFF\">";
					}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg != true)){
						//日曜or休日
						$calendar[$staff][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#FFDDE7\">";
					}else{
						//月〜金
						$calendar[$staff][$y] .= "<td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\">";
					}

					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						$calendar[$staff][$y] .= "</td>";
					}else{
						$day_num++;
						//データが存在する場合は、日にちをリンクにする
						if($n_data_list[$staff][$cal_date][0][6] != NULL){
							//データが存在する
							
							$aord_id_array = NULL;     //受注ID配列
							//該当日の受注ID全てを一括訂正に渡す
							for($p=0;$p<count($n_data_list[$staff][$cal_date]);$p++){
								$aord_id_array[$p] = $n_data_list[$staff][$cal_date][$p][6];
							}

							//シリアライズ化
							$array_id = serialize($aord_id_array);
							$array_id = urlencode($array_id);
							
							//受注ID配列を渡す処理が未
							$calendar[$staff][$y] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php',";
							$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$cal_date][0][22].",1)\">$day_num</a></td>";
						}else{
							//データが存在しない
							$calendar[$staff][$y] .= "$day_num</td>";
						}
					}
					$j++;
				}
				$calendar[$staff][$y] .= "</tr>";

				//カレンダーに各担当者のデータを表示
				$calendar[$staff][$y] .= "<tr>";
				$j=0;
				//セルの下作成処理
				while($j<7){

					//休日判定を行なうか判定
					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						//月がまだ始まっていない為、休日判定を行わない
						$cal_flg2 = true;
					}else{
						//月が開始された為、休日判定を行なう
						$cal_flg2 = false;

						//休日判定に使用するセルの日付取得
						$cal_num = $day_num2 + 1;
						$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
						$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
					}

					//曜日判定
					if($j == 5 && ($holiday[$cal_date] != 1)){
						//土曜かつ休日ではない
						$calendar[$staff][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" height=\"33\" >";
					}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg2 != true)){
						//日曜or休日
						$calendar[$staff][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" height=\"33\" >";
					}else{
						//月〜金
						$calendar[$staff][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" height=\"33\">";
					}
						
					//月の最初の日が何曜日から始まるか判定
					if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
						//始まる前の曜日
						$calendar[$staff][$y] .= "</td>";
					}else{
						//始まる日より後の曜日
			
						$day_num2++;
						$today = str_pad($day_num2, 2, 0, STR_POS_LEFT);
						$date = "$year[$y]-$month[$y]-$today";  //各セルに表示する日付
						//該当日に巡回データが複数存在した場合、その件数分表示
						for($p=0;$p<count($n_data_list[$staff][$date]);$p++){
							//該当日に巡回データが存在するか判定
							if($n_data_list[$staff][$date][$p][6] != NULL){

								//順路指定判定
								if($n_data_list[$staff][$date][$p][4] != NULL){
									//順路形式変更
									$route = str_pad($n_data_list[$staff][$date][$p][4], 4, 0, STR_POS_LEFT);
									$route1 = substr($route,0,2);
									$route2 = substr($route,2,2);
									$route = $route1."-".$route2;
								}else{
									//オフライン代行の場合は空白表示
									$route = "　 　";
								}

								//リンク色判定
								if($n_data_list[$staff][$date][$p][14] == "t" || $n_data_list[$staff][$date][$p][25] == "t"){
									//確定伝票
									//遷移先：予定訂正ダイアログ
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: gray;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][24] != NULL){
									//代行伝票
									//遷移先：予定訂正ダイアログ
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: green;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][23] == 1){
									//予定伝票(一人)
									//遷移先：予定訂正ダイアログ
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: blue;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][23] == 2){
									//予定伝票(二人)
									//遷移先：予定訂正ダイアログ
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: Fuchsia;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}elseif($n_data_list[$staff][$date][$p][23] == 3 || $n_data_list[$staff][$date][$p][23] == 4){
									//予定伝票(三人以上)
									//遷移先：予定訂正ダイアログ
									$calendar[$staff][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
									$calendar[$staff][$y] .= "450,200,".$n_data_list[$staff][$date][$p][15].",".$n_data_list[$staff][$date][$p][6].")\"";
									$calendar[$staff][$y] .= " style=\"color: #FF6600;\">";
									$calendar[$staff][$y] .= $n_data_list[$staff][$date][$p][5]."</a><br>";
								}
							}
						}
						$calendar[$staff][$y] .= "</td>";
					}
					$j++;
				}
				$calendar[$staff][$y] .= "</tr>";
				//巡回基準日の月の場合は、基準日の週からABCD週を表示。基準日の月以外は、通常通り表示
				if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
					$row++;
					//D週になったら、またA週に値をもどす
					if($row == 5){
						$row = 1;
					}
				}
			}
			//ABCD配列の添字
			//基準日の月か判定
			if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
				//基準日から始まる為A週にする
				$base_date[0] = 1;
			}else{
				//月の最初の日が何週か取得処理
				$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
			}
			$row = $base_date[0];

			$day_num = 0;
			$day_num2 = 0;
		}
		//指標をリセットする
		reset($n_data_list);
		//月のカレンダーデータがある
		$cal_msg[$staff][$y] = NULL;
	}else{
		//データない月は警告表示
		$calendar[$staff][$y] .= "<br>";
		$cal_msg[$staff][$y] = "巡回データがありません。";
	}

	//検索時には代行カレンダー非表示
	if($post_part_id == NULL && $post_staff_id == NULL && $_SESSION["group_kind"] != 3){
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
			$sql .= "    t_aorder_h.confirm_flg, \n";        //確定フラグ 15
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //確定フラグ(受託先) 16

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
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";

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
			$sql .= "    t_staff$i.sale_rate,  \n";          //売上率 14
			$sql .= "    t_aorder_h.confirm_flg, \n";        //確定フラグ 15
			$sql .= "    t_aorder_h.trust_confirm_flg \n";   //確定フラグ(受託先) 16
			   
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
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time >= '$year[$y]-$month[$y]-01'  \n";
			$sql .= "    AND  \n";
			$sql .= "    t_aorder_h.ord_time <= '$year[$y]-$month[$y]-$day'  \n";
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
		
			$act_data_list2[$act_id][$y][0][0] = $act_data_list[$x][0];    //受託先名
			$act_data_list2[$act_id][$y][0][1]++;                          //予定件数

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
			$act_data_list2[$act_id][$y][0][2] = bcadd($total1,$act_data_list2[$act_id][$y][0][2]);

			//受注データが存在した
			$act_data_flg = true;
			//一件以上受注データが存在した
			$cal_data_flg = true;
		}

		//受注データが存在した場合にその受託データをカレンダー配列作成
		if($act_data_flg == true){
			/****************************/
			//カレンダーテーブル処理
			/****************************/

			//数値形式変更
			$money_num = NULL;
			while($money_num = each($act_data_list2)){
				$money = $money_num[0];
				//予定金額切捨て
				$act_data_list2[$money][$y][0][2] = floor($act_data_list2[$money][$y][0][2]);
				$act_data_list2[$money][$y][0][2] = number_format($act_data_list2[$money][$y][0][2]);
			}
			//指標をリセットする
			reset($act_data_list2);

			//ABCD配列の添字
			//基準日の月か判定
			$base_date = NULL;
			$row = NULL;
			if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
				//基準日から始まる為A週にする
				$base_date[0] = 1;
			}else{
				//月の最初の日が何週か取得処理
				$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
			}
			$row = $base_date[0];

			$day_num = 0;   //カレンダーに表示させる日
			$day_num2 = 0;  //データを表示させる為に使用する日

			//受託先ごとに巡回データ作成
			$act_num = NULL;
			while($act_num = each($n_data_list)){
				//受託先の添字取得
				$act = $act_num[0];

				//前月ボタン
				//非表示判定
				if($b_disabled_flg == true){
					//非表示
					$form->addElement("button","back_button[$act]","<<　前月","disabled");
				}else{
					//表示
					$form->addElement("button","back_button[$act]","<<　前月","onClick=\"javascript:Button_Submit('back_button_flg','#$act','true')\"");
				}

				//翌月ボタン
				//非表示判定
				if($n_disabled_flg == true){
					//非表示
					$form->addElement("button","next_button[$act]","翌月　>>","disabled");
				}else{
					//表示
					$form->addElement("button","next_button[$act]","翌月　>>","onClick=\"javascript:Button_Submit('next_button_flg','#$act','true')\"");
				}

				//月のカレンダー作成
				for($c=1;$c<=$weeks;$c++){
					//既にカレンダー配列が作成されているか判定
					if($c==1 && $act_calendar[$act][$y] != NULL){
						//既にあった場合は配列を上書きする
						$act_calendar[$act][$y] = "<tr class=\"cal_flame\">";
					}else{
						//二行目からは、配列にただ結合する
						$act_calendar[$act][$y] .= "<tr class=\"cal_flame\">";
					}

					$act_calendar[$act][$y] .= "	    <td align=\"center\" valign=\"center\" bgcolor=\"#e5e5e5\" rowspan=\"2\">";
					//巡回基準日の月の場合は、基準日の週からABCD週を表示。基準日の月以外は、通常通り表示
					if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
						$act_calendar[$act][$y] .= $abcd[$row];
					}
					$act_calendar[$act][$y] .= "      </td>";
					$j=0;
					//セルの上作成処理
					while($j<7){
						//休日判定を行なうか判定
						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							//月がまだ始まっていない為、休日判定を行わない
							$cal_flg = true;
						}else{
							//月が開始された為、休日判定を行なう
							$cal_flg = false;

							//休日判定に使用するセルの日付取得
							$cal_num = $day_num + 1;
							$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
							$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
						}

						//曜日判定
						if($j == 5 && ($holiday[$cal_date] != 1)){
							//土曜かつ休日ではない
							$act_calendar[$act][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#99FFFF\">";
						}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg != true)){
							//日曜or休日
							$act_calendar[$act][$y] .= "	    <td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\" bgcolor=\"#FFDDE7\">";
						}else{
							//月〜金
							$act_calendar[$act][$y] .= "<td class=\"cal\" width=\"135px\" align=\"center\" valign=\"top\">";
						}

						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							$act_calendar[$act][$y] .= "</td>";
						}else{
							$day_num++;
							//データが存在する場合は、日にちをリンクにする
							if($n_data_list[$act][$cal_date][0][8] != NULL){
								//データが存在する
								
								$aord_id_array = NULL;     //受注ID配列
								//該当日の受注ID全てを一括訂正に渡す
								for($p=0;$p<count($n_data_list[$act][$cal_date]);$p++){
									$aord_id_array[$p] = $n_data_list[$act][$cal_date][$p][8];
								}

								//シリアライズ化
								$array_id = serialize($aord_id_array);
								$array_id = urlencode($array_id);
								
								//受注ID配列を渡す処理が未
								$act_calendar[$act][$y] .= "<a href=\"#\" style=\"color: #555555;\" onClick=\"return Link_Switch('2-2-101i.php',";
								$act_calendar[$act][$y] .= "450,200,".$n_data_list[$act][$cal_date][0][1].",1)\">$day_num</a></td>";
							}else{
								//データが存在しない
								$act_calendar[$act][$y] .= "$day_num</td>";
							}
						}
						$j++;
					}
					$act_calendar[$act][$y] .= "</tr>";

					//カレンダーに各担当者のデータを表示
					$act_calendar[$act][$y] .= "<tr>";
					$j=0;
					//セルの下作成処理
					while($j<7){

						//休日判定を行なうか判定
						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							//月がまだ始まっていない為、休日判定を行わない
							$cal_flg2 = true;
						}else{
							//月が開始された為、休日判定を行なう
							$cal_flg2 = false;

							//休日判定に使用するセルの日付取得
							$cal_num = $day_num2 + 1;
							$cal_today = str_pad($cal_num, 2, 0, STR_POS_LEFT);
							$cal_date = "$year[$y]-$month[$y]-$cal_today"; 
						}

						//曜日判定
						if($j == 5 && ($holiday[$cal_date] != 1)){
							//土曜かつ休日ではない
							$act_calendar[$act][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#99FFFF\" height=\"33\" >";
						}else if($j == 6 || ($holiday[$cal_date] == 1 && $cal_flg2 != true)){
							//日曜or休日
							$act_calendar[$act][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" bgcolor=\"#FFDDE7\" height=\"33\" >";
						}else{
							//月〜金
							$act_calendar[$act][$y] .= "	    <td class=\"cal2\" width=\"135px\" align=\"left\" valign=\"top\" height=\"33\">";
						}
							
						//月の最初の日が何曜日から始まるか判定
						if(($c-1==0 && $j<$first_day) || ($c-1==$weeks-1 && $j>$last_day)){
							//始まる前の曜日
							$act_calendar[$act][$y] .= "</td>";
						}else{
							//始まる日より後の曜日
				
							$day_num2++;
							$today = str_pad($day_num2, 2, 0, STR_POS_LEFT);
							$date = "$year[$y]-$month[$y]-$today";  //各セルに表示する日付
							//該当日に巡回データが複数存在した場合、その件数分表示
							for($p=0;$p<count($n_data_list[$act][$date]);$p++){
								//該当日に巡回データが存在するか判定
								if($n_data_list[$act][$date][$p][8] != NULL){

									//順路指定判定
									if($n_data_list[$act][$date][$p][6] != NULL){
										//順路形式変更
										$route = str_pad($n_data_list[$act][$date][$p][6], 4, 0, STR_POS_LEFT);
										$route1 = substr($route,0,2);
										$route2 = substr($route,2,2);
										$route = $route1."-".$route2;
									}else{
										//オフライン代行の場合は空白表示
										$route = "　 　";
									}

									//リンク色判定
									if($n_data_list[$act][$date][$p][15] == "t" || $n_data_list[$act][$date][$p][25] == "t"){
										//確定伝票
										//遷移先：予定訂正ダイアログ
										$act_calendar[$act][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
										$act_calendar[$act][$y] .= "450,200,".$n_data_list[$act][$date][$p][9].",".$n_data_list[$act][$date][$p][8].")\"";
										$act_calendar[$act][$y] .= "style=\"color: gray;\">";
										$act_calendar[$act][$y] .= $n_data_list[$act][$date][$p][7]."</a><br>";
									}elseif($n_data_list[$act][$date][$p][1] != NULL){
										//代行伝票
										//遷移先：予定訂正ダイアログ
										$act_calendar[$act][$y] .= $route." <a href=\"#\" onClick=\"return Link_Switch('2-2-101d.php',";
										$act_calendar[$act][$y] .= "450,200,".$n_data_list[$act][$date][$p][9].",".$n_data_list[$act][$date][$p][8].")\"";
										$act_calendar[$act][$y] .= "style=\"color: green;\">";
										$act_calendar[$act][$y] .= $n_data_list[$act][$date][$p][7]."</a><br>";
									}
								}
							}
							$act_calendar[$act][$y] .= "</td>";
						}
						$j++;
					}
					$act_calendar[$act][$y] .= "</tr>";
					//巡回基準日の月の場合は、基準日の週からABCD週を表示。基準日の月以外は、通常通り表示
					if($stand_day_week <= $c || $stand_day < "$year[$y]-$month[$y]-01"){
						$row++;
						//D週になったら、またA週に値をもどす
						if($row == 5){
							$row = 1;
						}
					}
				}
				//ABCD配列の添字
				//基準日の月か判定
				if("$day_by-$day_bm-$day_bd 00:00" > "$year[$y]-$month[$y]-01 00:00"){
					//基準日から始まる為A週にする
					$base_date[0] = 1;
				}else{
					//月の最初の日が何週か取得処理
					$base_date = Basic_date($day_by,$day_bm,$day_bd,$year[$y],$month[$y],1);
				}
				$row = $base_date[0];

				$day_num = 0;
				$day_num2 = 0;
			}
			//指標をリセットする
			reset($n_data_list);
			//月のカレンダーデータがある
			$act_cal_msg[$act][$y] = NULL;
		}else{
			//データない月は警告表示
			$act_calendar[$act][$y] .= "<br>";
			$act_cal_msg[$act][$y] = "巡回データがありません。";
		}
	}
}

//データが無い場合は、リンク先指定なしのボタン作成
if($cal_data_flg == false){

	//前月ボタン
	//非表示判定
	if($b_disabled_flg == true){
		//非表示
		$form->addElement("button","back_button","<<　前月","disabled");
	}else{
		//表示
		$form->addElement("button","back_button","<<　前月","onClick=\"javascript:Button_Submit('back_button_flg','#','true')\"");
	}

	//翌月ボタン
	//非表示判定
	if($n_disabled_flg == true){
		//非表示
		$form->addElement("button","next_button","翌月　>>","disabled");
	}else{
		//表示
		$form->addElement("button","next_button","翌月　>>","onClick=\"javascript:Button_Submit('next_button_flg','#','true')\"");
	}
	
	$data_msg = "巡回データがありません。";
}

/*
print "<pre>";
print_r ($data_list2);
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
	'cal_data_flg'    => "$cal_data_flg",
	'cal_range'       => "$cal_range",
	'data_msg'        => "$data_msg",
));

//表示データ
$smarty->assign("disp_data", $data_list2);
$smarty->assign("calendar", $calendar);
$smarty->assign("act_disp_data", $act_data_list2);
$smarty->assign("act_calendar", $act_calendar);
$smarty->assign("cal_msg", $cal_msg);
$smarty->assign("act_cal_msg", $act_cal_msg);
$smarty->assign("year", $year);
$smarty->assign("month", $month);

//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
