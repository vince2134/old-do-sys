<?php
/**
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      ban_0052    suzuki      担当者CDの検索条件修正
 *
 * 概要 請求に関するデータを取得する
 *
 * 説明 第5引数にcountが指定された場合は、一致する件数を返します。
 *
 * @param string   $db_con     DB接続リソース
 * @param array    $where      SQL条件文
 * @param string   $page_snum  表示開始件数
 * @param string   $page_enum  表示終了件数
 * @param string   $kind       戻り値の種類
 *
 * @return array               請求データ
 */
function Get_Claim_Data($db_con, $where, $page_snum="", $page_enum="", $kind=""){

	$offset = $page_snum-1; //表示しない件数
	$limit  = ($page_enum - $page_snum) +1;    //一ページあたりの件数

	//**************************//
	//HTMLのvalue値をSQL用に加工
	//**************************//
	// 請求締日（開始）
	if ($where[close_day_s][y] != NULL) {
		$yy_1 = str_pad($where[close_day_s][y], 4, 0, STR_POS_LEFT);
	}
	if ($where[close_day_s][m] != NULL) {
		$mm_1 = str_pad($where[close_day_s][m], 2, 0, STR_POS_LEFT);
	}
	if ($where[close_day_s][d] != NULL) {
		$dd_1 = str_pad($where[close_day_s][d], 2, 0, STR_POS_LEFT);
	}
	$close_day_s = "$yy_1"."$mm_1"."$dd_1";
	
	// 請求締日（終了）
	if ($where[close_day_e][y] != NULL) {
		$yy_2 = str_pad($where[close_day_e][y], 4, 0, STR_POS_LEFT);
	}
	if ($where[close_day_e][m] != NULL) {
		$mm_2 = str_pad($where[close_day_e][m], 2, 0, STR_POS_LEFT);
	}
	if ($where[close_day_e][d] != NULL) {
		$dd_2 = str_pad($where[close_day_e][d], 2, 0, STR_POS_LEFT);
	}
	$close_day_e = "$yy_2"."$mm_2"."$dd_2";

	// 請求更新
	if ($where[claim_update] == "1") {
		$where[claim_update] = "";
	}elseif ($where[claim_update] == "2") {
		$where[claim_update] = "t";
	}elseif ($where[claim_update] == "3") {
		$where[claim_update] = "f";
	}

	/****************************/
	//請求書データを抽出SQL
	/****************************/
	$sql_column = "
	SELECT	
		t_bill.bill_id,   
		t_bill.bill_no,   
		t_bill_d.bill_close_day_this,   
		t_bill_d.client_id,
		t_bill_d.client_cd1,
		t_bill_d.client_cd2,
		t_bill_d.client_cname,
		t_bill.claim_cd1,
		t_bill.claim_cd2,
		t_bill.claim_cname,
		t_bill.staff_cd,
		t_bill.staff_name,
		t_bill_d.bill_amount_last, 
		t_bill_d.pay_amount,
		t_bill_d.rest_amount,
		t_bill_d.sale_amount,
		t_bill_d.tax_amount,
		t_bill_d.intax_amount,
		t_bill_d.bill_amount_this, 
		t_bill.last_update_flg,
		t_bill.last_update_day
	";
	$sql = "
	FROM	
		t_bill INNER JOIN t_bill_d
		ON t_bill.bill_id = t_bill_d.bill_id	

	WHERE	
		t_bill.shop_id = $_SESSION[client_id]
	AND	
		t_bill.bill_no IS NOT NULL
	AND	
		t_bill_d.close_day IS NOT NULL
	AND	
		t_bill.first_set_flg = 'f'
	";

	// 請求番号
	if ($where[bill_no] != "") {
		$sql .= "AND t_bill.bill_no LIKE '$where[bill_no]%'";
	}
	// 請求締日（開始）
	if ($close_day_s != "") {
		$sql .= "AND t_bill_d.bill_close_day_this >= '$close_day_s' ";
	}
	// 請求締日（終了）
	if ($close_day_e != "") {
		$sql .= "AND t_bill_d.bill_close_day_this <= '$close_day_e' ";
	}
	// 得意先コード
	if ($where[client_cd][1] != "") {
		$sql .= "AND t_bill_d.client_cd1 LIKE '".$where[client_cd][1]."%'";
	}
	if ($where[client_cd][2] != "") {
		$sql .= "AND t_bill_d.client_cd2 LIKE '".$where[client_cd][2]."%'";
	}
	// 得意先名
	if ($where[client_cname] != "") {
		$sql .= " AND (t_bill_d.client_name1 LIKE '%$where[client_cname]%'";
		$sql .= " OR t_bill_d.client_name2 LIKE '%$where[client_cname]%'";
		$sql .= " OR t_bill_d.client_cname LIKE '%$where[client_cname]%'";
		$sql .= ")";
	}

	// 請求先コード
	if ($where[claim_cd][1] != "") {
		$sql .= "AND t_bill.claim_cd1 LIKE '".$where[claim_cd][1]."%'";
	}
	if ($where[claim_cd][2] != "") {
		$sql .= "AND t_bill.claim_cd2 LIKE '".$where[claim_cd][2]."%'";
	}
	// 請求先名
	if ($where[claim_cname] != "") {
		$sql .= " AND (t_bill.claim_name1 LIKE '%$where[claim_cname]%'";
		$sql .= " OR t_bill.claim_name2 LIKE '%$where[claim_cname]%'";
		$sql .= " OR t_bill.claim_cname LIKE '%$where[claim_cname]%'";
		$sql .= ")";
	}

	// 担当者コード
	if ($where[staff_cd] != "") {
		//$sql .= "AND t_bill.staff_cd LIKE '".$where[staff_cd]."%'";
		$sql .= "AND t_bill.staff_cd = ".(int)$where[staff_cd];
	}
	// 担当者名
	if ($where[staff_name] != "") {
		$sql .= "AND t_bill.staff_name LIKE '%".$where[staff_name]."%'";
	}

	// 前回御請求額
	if ($where[bill_amount_last][min] != "") {
		$sql .= "AND t_bill_d.bill_amount_last >= '".$where[bill_amount_last][min]."'";
	}
	if ($where[bill_amount_last][max] != "") {
		$sql .= "AND t_bill_d.bill_amount_last <= '".$where[bill_amount_last][max]."'";
	}
	
	// 今回入金額
	if ($where[pay_amount][min] != "") {
		$sql .= "AND t_bill_d.pay_amount >= '".$where[pay_amount][min]."'";
	}
	if ($where[pay_amount][max] != "") {
		$sql .= "AND t_bill_d.pay_amount <= '".$where[pay_amount][max]."'";
	}

	// 繰越残高額
	if ($where[rest_amount][min] != "") {
		$sql .= "AND t_bill_d.rest_amount >= '".$where[rest_amount][min]."'";
	}
	if ($where[rest_amount][max] != "") {
		$sql .= "AND t_bill_d.rest_amount <= '".$where[rest_amount][max]."'";
	}

	// 今回御請求額
	if ($where[bill_amount_this][min] != "") {
		$sql .= "AND t_bill_d.bill_amount_this >= '".$where[bill_amount_this][min]."'";
	}
	if ($where[bill_amount_this][max] != "") {
		$sql .= "AND t_bill_d.bill_amount_this <= '".$where[bill_amount_this][max]."'";
	}
	
	// 請求更新
	if ($where[claim_update] != "") {
		$sql .= "AND t_bill.last_update_flg = '$where[claim_update]' ";
	}

	$sql_another = "ORDER BY t_bill_d.bill_close_day_this, t_bill_d.client_cd1, t_bill_d.client_cd2 ";
	
	if ($where[hyoujikensuu] != "all") {
		$sql_another .= "LIMIT $limit OFFSET $offset ";
	}
	
	//検索に該当した「件数」を返して終了
	if ($kind == "count") {
		$sql_column = "SELECT COUNT(t_bill.bill_id) ";
		$exec_sql   = "$sql_column"."$sql";
		$result     = Db_Query($db_con, $exec_sql);
		$data       = pg_fetch_result($result, 0 ,0);
		return $data;

	//一覧用 請求書データを取得
	} else {
		$exec_sql   = "$sql_column"."$sql"."$sql_another";
		$result = Db_Query($db_con, $exec_sql);
	}
	
	
	/****************************/
	//請求書データをテンプレート用に加工する
	/****************************/
	$i="0";
	while ($data[$i] = pg_fetch_array ($result)) {

		$bill_id = $data[$i][bill_id];
		$client_id = $data[$i][client_id];

		//合計
		$data[0][sum][bill_amount_last] += $data[$i][bill_amount_last];
		$data[0][sum][pay_amount]       += $data[$i][pay_amount];
		$data[0][sum][rest_amount]      += $data[$i][rest_amount];
		$data[0][sum][sale_amount]      += $data[$i][sale_amount];
		$data[0][sum][tax_amount]       += $data[$i][tax_amount];
		$data[0][sum][intax_amount]     += $data[$i][intax_amount];
		$data[0][sum][bill_amount_this] += $data[$i][bill_amount_this];
		
		//行No.
		$data[$i][no] = $page_snum;
		$data[0][sum][no] ++; //件数

		//請求番号リンク
		//本部の場合
		if ($_SESSION[group_kind] == "1") {
			$data[$i][bill_no]    = "<a href=\"1-2-304.php?claim_id=$bill_id&client_id=$client_id\">".$data[$i][bill_no]."</a>";
		//FCの場合
		} else {
			$data[$i][bill_no]    = "<a href=\"2-2-304.php?claim_id=$bill_id&client_id=$client_id\">".$data[$i][bill_no]."</a>";
		}

		$data[$i][client_name]      = htmlspecialchars($data[$i][client_name]);
		$data[$i][client_cname]      = htmlspecialchars($data[$i][client_cname]);
		$data[$i][claim_name]       = htmlspecialchars($data[$i][claim_name]);
		$data[$i][claim_cname]       = htmlspecialchars($data[$i][claim_cname]);
		$data[$i][staff_name]       = htmlspecialchars($data[$i][staff_name]);

		//担当者コードを0埋め
		if ($data[$i][staff_cd] != NULL){
			$data[$i][staff_cd]         = str_pad($data[$i][staff_cd], 4, 0, STR_POS_LEFT);
			$data[0][sum][staff_cd]++;
		}

		//前回請求額がマイナスの場合は赤文字で表示
			$data[$i][bill_amount_last] = Minus_Numformat($data[$i][bill_amount_last]);
		
		//今回入金額がマイナスの場合は赤文字で表示
			$data[$i][pay_amount]       = Minus_Numformat($data[$i][pay_amount]);
	
		//今繰越残高額がマイナスの場合は赤文字で表示
			$data[$i][rest_amount]      = Minus_Numformat($data[$i][rest_amount]);
	
		//今回買上額がマイナスの場合は赤文字で表示
			$data[$i][sale_amount]      = Minus_Numformat($data[$i][sale_amount]);
	
		//今回消費税額がマイナスの場合は赤文字で表示
			$data[$i][tax_amount]       = Minus_Numformat($data[$i][tax_amount]);
	
		//税込買上額がマイナスの場合は赤文字で表示
			$data[$i][intax_amount]     = Minus_Numformat($data[$i][intax_amount]);
	
		//今回御請求額がマイナスの場合は赤文字で表示
			$data[$i][bill_amount_this] = Minus_Numformat($data[$i][bill_amount_this]);

		
		$i++;
		$page_snum++;

	}

	/****************************/
	//合計額についての処理
	/****************************/
	//前回請求額がマイナスの場合は赤文字で表示
	if ($data[0][sum][bill_amount_last] < 0){
		$data[0][sum][bill_amount_last] = number_format($data[0][sum][bill_amount_last]);
		$data[0][sum][bill_amount_last] = "<font color=\"red\">".$data[0][sum][bill_amount_last]."</font>";
	}	else {
		$data[0][sum][bill_amount_last] = number_format($data[0][sum][bill_amount_last]);
	}
	
	//今回入金額がマイナスの場合は赤文字で表示
	if ($data[0][sum][pay_amount] < 0){
		$data[0][sum][pay_amount]       = number_format($data[0][sum][pay_amount]);
		$data[0][sum][pay_amount] = "<font color=\"red\">".$data[0][sum][pay_amount]."</font>";
	}	else {
		$data[0][sum][pay_amount]       = number_format($data[0][sum][pay_amount]);
	}

	//今繰越残高額がマイナスの場合は赤文字で表示
	if ($data[0][sum][rest_amount] < 0){
		$data[0][sum][rest_amount]      = number_format($data[0][sum][rest_amount]);
		$data[0][sum][rest_amount] = "<font color=\"red\">".$data[0][sum][rest_amount]."</font>";
	}	else {
		$data[0][sum][rest_amount]      = number_format($data[0][sum][rest_amount]);
	}

	//今回買上額がマイナスの場合は赤文字で表示
	if ($data[0][sum][sale_amount] < 0){
		$data[0][sum][sale_amount]      = number_format($data[0][sum][sale_amount]);
		$data[0][sum][sale_amount] = "<font color=\"red\">".$data[0][sum][sale_amount]."</font>";
	}	else {
		$data[0][sum][sale_amount]      = number_format($data[0][sum][sale_amount]);
	}

	//今回消費税額がマイナスの場合は赤文字で表示
	if ($data[0][sum][tax_amount] < 0){
		$data[0][sum][tax_amount]       = number_format($data[0][sum][tax_amount]);
		$data[0][sum][tax_amount] = "<font color=\"red\">".$data[0][sum][tax_amount]."</font>";
	}	else {
		$data[0][sum][tax_amount]       = number_format($data[0][sum][tax_amount]);
	}

	//税込買上額がマイナスの場合は赤文字で表示
	if ($data[0][sum][intax_amount] < 0){
		$data[0][sum][intax_amount]     = number_format($data[0][sum][intax_amount]);
		$data[0][sum][intax_amount] = "<font color=\"red\">".$data[0][sum][intax_amount]."</font>";
	}	else {
		$data[0][sum][intax_amount]     = number_format($data[0][sum][intax_amount]);
	}

	//今回御請求額がマイナスの場合は赤文字で表示
	if ($data[0][sum][bill_amount_this] < 0){
		$data[0][sum][bill_amount_this] = number_format($data[0][sum][bill_amount_this]);
		$data[0][sum][bill_amount_this] = "<font color=\"red\">".$data[0][sum][bill_amount_this]."</font>";
	}	else {
		$data[0][sum][bill_amount_this] = number_format($data[0][sum][bill_amount_this]);
	}

	//while処理で最終配列は"NULL"が入るため取り除く
	array_pop($data);

	return $data;
}

?>
