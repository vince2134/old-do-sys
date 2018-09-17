<?php
/**
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/12/07      ban_0051    suzuki      担当者CDの検索条件修正
 *
 *
 * 概要 請求書に関するデータを取得する
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
 
function Get_Slip_Data($db_con, $where, $page_snum, $page_enum,$kind=""){
	$offset = $page_snum-1; //表示しない件数
	$limit  = ($page_enum - $page_snum) +1;    //一ページあたりの件数

	// 日付POSTデータの0埋め
	$_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
	$_POST["form_claim_day"] = Str_Pad_Date($_POST["form_claim_day"]);

	//変数定義
	$shop_id          = $_SESSION[client_id];
	$display_num      = $_POST["form_display_num"];           //表示件数
	$charge_branch_id = $_POST["form_client_branch"];         //顧客担当支店ID
	$attach_branch_id = $_POST["form_attach_branch"];         //所属支店ID

	$client_cd1       = $_POST["form_client"]["cd1"];         //得意先CD1
	$client_cd2       = $_POST["form_client"]["cd2"];         //得意先CD2                           
	$client_name      = $_POST["form_client"]["name"];        //得意先名                           
	$staff_cd         = $_POST["form_round_staff"]["cd"];     //巡回担当者コード
	$staff_id         = $_POST["form_round_staff"]["select"]; //巡回担当者ID
	$part_id          = $_POST["form_part"];                  //部署

	$claim_cd1        = $_POST["form_claim"]["cd1"];          //請求先CD1
	$claim_cd2        = $_POST["form_claim"]["cd2"];          //請求先CD2                           
	$claim_name       = $_POST["form_claim"]["name"];         //請求先名                           

	$staff_cd_csv     = $_POST["form_multi_staff"];           //巡回担当者コード(カンマ区切り)
	$ware_id          = $_POST["form_ware"];                  //部署

	$round_day_sy     = $_POST["form_round_day"]["sy"];       //配送日（開始年） 
	$round_day_sm     = $_POST["form_round_day"]["sm"];       //配送日（開始月）
	$round_day_sd     = $_POST["form_round_day"]["sd"];       //配送日（開始日）
	$round_day_ey     = $_POST["form_round_day"]["ey"];       //配送日（終了年） 
	$round_day_em     = $_POST["form_round_day"]["em"];       //配送日（終了月）
	$round_day_ed     = $_POST["form_round_day"]["ed"];       //配送日（終了日）
	$round_day_s      = $round_day_sy."-".$round_day_sm."-".$round_day_sd; //配送日（開始）
	$round_day_e      = $round_day_ey."-".$round_day_em."-".$round_day_ed; //配送日（終了）

	$claim_day_sy     = $_POST["form_claim_day"]["sy"];       //請求日（開始年） 
	$claim_day_sm     = $_POST["form_claim_day"]["sm"];       //請求日（開始月）
	$claim_day_sd     = $_POST["form_claim_day"]["sd"];       //請求日（開始日）
	$claim_day_ey     = $_POST["form_claim_day"]["ey"];       //請求日（終了年） 
	$claim_day_em     = $_POST["form_claim_day"]["em"];       //請求日（終了月）
	$claim_day_ed     = $_POST["form_claim_day"]["ed"];       //請求日（終了日）
	$claim_day_s      = $claim_day_sy."-".$claim_day_sm."-".$claim_day_sd; //請求日（開始）
	$claim_day_e      = $claim_day_ey."-".$claim_day_em."-".$claim_day_ed; //請求日（終了）

	$act_cd1          = $_POST["form_charge_fc"]["cd1"];      //委託先CD1
	$act_cd2          = $_POST["form_charge_fc"]["cd2"];      //委託先CD2                           
	$act_name         = $_POST["form_charge_fc"]["name"];     //委託先名                           
	$act_id           = $_POST["form_charge_fc"]["select"]["1"];   //委託先id                           

	$charge_fc_cd1    = $_POST["form_charge_fc"]["cd1"];      //委託先cd1
	$charge_fc_cd2    = $_POST["form_charge_fc"]["cd2"];      //委託先cd2
	$charge_fc_name   = $_POST["form_charge_fc"]["name"];     //委託先名
	$charge_fc_id     = $_POST["form_charge_fc"]["select"]["1"];   //委託先ID

	$slip_out         = $_POST["slip_out"];                   //伝票形式
	$slip_flg         = $_POST["slip_flg"];                   //発行状況
	$ord_no_s         = $_POST["ord_no"]["s"];                //伝票番号（開始）
	$ord_no_e         = $_POST["ord_no"]["e"];                //伝票番号（終了）
	$contract_div     = $_POST["contract_div"];               //契約区分

	//カレンダ表示期間取得
	$cal_array = Cal_range($db_con,$shop_id,true);
	$end_day   = $cal_array[1];     //対象終了期間

	//************************************************
	//検索条件作成
	//************************************************
	//担当支店ID
	if($charge_branch_id != null){
		$where_sql .= "  AND t_client.charge_branch_id = $charge_branch_id \n";
	}

	//所属支店ID
	if($attach_branch_id != null){
		$where_sql .= "  AND t_staff1.staff_id IN (SELECT \n";
		$where_sql .= "                                     t_attach.staff_id  \n";
		$where_sql .= "                                 FROM \n";
		$where_sql .= "                                     t_part \n";
		$where_sql .= "                                         INNER JOIN ";
		$where_sql .= "                                     t_attach \n";
		$where_sql .= "                                     ON t_part.part_id = t_attach.part_id ";
		$where_sql .= "                                 WHERE \n";
		$where_sql .= "                                     branch_id = $attach_branch_id \n";
		$where_sql .= "                                 ) \n";
	
		//代行伝票は表示しない
		if($group_kind == '2'){
			$where_sql  .= " AND t_aorder_h.act_id IS NULL\n";
		}
	}

	//巡回担当者コードが入力された場合
	if($staff_cd != null || $staff_id != null || $staff_cd_csv != null){
		$where_sql .= " AND t_staff1.staff_id IN (\n";
		$where_sql .= "         SELECT\n";
		$where_sql .= "             t_staff.staff_id\n";
		$where_sql .= "         FROM\n";
		$where_sql .= "             t_attach\n";
		$where_sql .= "                 INNER JOIN\n";
		$where_sql .= "             t_staff\n";
		$where_sql .= "             ON t_attach.staff_id = t_staff.staff_id\n";
		$where_sql .= "             WHERE t_attach.shop_id = $shop_id\n";

		//巡回担当者（カンマ区切り）
		if($staff_cd_csv != null){
		    $where_sql .= "        AND t_staff.charge_cd IN ($staff_cd_csv)\n";
		}
		//巡回担当者が選択されていた場合
		if($staff_id != null){
		    $where_sql .= "        AND t_staff.staff_id = $staff_id\n";
		}
		//巡回担当者コード
		if($staff_cd != null){
		    $where_sql .= "        AND t_staff.charge_cd = $staff_cd \n";
		}
		$where_sql .= ")\n";
	
		if($group_kind == '2'){
		    #$where2_sql  .= " AND t_aorder_h.act_id IS NULL\n";
		}
	}
 
	//部署が選択された場合
	if($part_id != NULL){
		$where_sql .= " AND t_staff1.staff_id IN (";
		$where_sql .= "             SELECT\n";
		$where_sql .= "                 staff_id\n";
		$where_sql .= "             FROM\n";
		$where_sql .= "                 t_attach\n";
		$where_sql .= "             WHERE\n";
		$where_sql .= "                 t_attach.part_id = $part_id\n";
		$where_sql .= "             )\n";
	
		/*
		* 履歴：
		* 　日付　　　　B票No.　　　　担当者　　　内容　
		* 　2006/11/01　02-036　　　　suzuki-t　  委託先側で部署・担当者の検索をできるように変更
		*/
		if($group_kind == '2'){
		    $where2_sql .= " AND t_aorder_h.act_id IS NULL\n";
		}
	}

	//倉庫
	if($ware_id != null){
		$where_sql .= "  AND t_aorder_h.ware_id = $ware_id \n";
	}

	//配送日（開始）が指定された場合
	if($round_day_s != "--"){
		$where_sql .= " AND '$round_day_s' <= t_aorder_h.ord_time \n";
	}

	//配送日（終了）が指定された場合
	if($round_day_e != "--"){
		$where_sql .= " AND t_aorder_h.ord_time <= '$round_day_e' \n";
	}


	//請求日（開始）が指定された場合
	if($claim_day_s != "--"){
		$where_sql .= " AND '$claim_day_s' <= t_aorder_h.arrival_day \n";
	}

	//請求日（終了）が指定された場合
	if($claim_day_e != "--"){
		$where_sql .= " AND t_aorder_h.arrival_day <= '$claim_day_e' \n";
	}

	//得意先コード1
	if($client_cd1 != null){
		$where_sql  .= " AND t_aorder_h.client_cd1 LIKE '$client_cd1%'";
	}
	//得意先コード2
	if($client_cd2 != null){
			$where_sql  .= " AND t_aorder_h.client_cd2 LIKE '$client_cd2%'";
	}
	//得意先名
	if($client_name != null){
		$where_sql  .= " AND ";
			$where_sql .= "    ( t_aorder_h.client_cname LIKE '%$client_name%' ";
			$where_sql .= "      OR ";
			$where_sql .= "      t_aorder_h.client_name LIKE '%$client_name%' ";
			$where_sql .= "      OR ";
			$where_sql .= "      t_aorder_h.client_name2 LIKE '%$client_name%' ";
			$where_sql .= "    ) ";
	}

	//請求先が指定された場合
	if($claim_id != null || $claim_cd1 != null || $claim_cd2 != null || $claim_name != null){
		$where_sql .= " AND t_aorder_h.claim_id IN (\n";
		$where_sql .= "                         SELECT\n";
		$where_sql .= "                             client_id \n";
		$where_sql .= "                         FROM \n";
		$where_sql .= "                             t_client \n";
		$where_sql .= "                         WHERE t_client.t_client_div != '2'\n";
	
		//請求先ID
		if($claim_id != null){
			$where_sql .= "                       AND t_client.client_id = $claim_id ";
		}
		//請求先CD１
		if($claim_cd1 != null){    
			$where_sql .= "                       AND t_client.client_cd1 LIKE '%$claim_cd1' ";
		}
		//請求先CD2
		if($claim_cd2 != null){
			$where_sql .= "                       AND t_client.client_cd2 LIKE '%$claim_cd2' ";
		}
		//請求先名
		if($claim_name != null){
			$where_sql .= "                       AND \n";
			$where_sql .= "                           (t_client.client_name LIKE '%$claim_name%' \n";
			$where_sql .= "                           OR t_client.client_name2 LIKE '%$claim_name%' \n";
			$where_sql .= "                           OR t_client.shop_name LIKE '%$claim_name%' \n";
			$where_sql .= "                           OR t_client.client_cname LIKE '%$claim_name%')) \n";
		}
	
		$where_sql .= ")\n";
	}
 
	//代行先ID
	if($charge_fc_id != null){
		$where_sql .= " AND t_aorder_h.act_id = $charge_fc_id ";
	}
	//代行先CD１
	if($charge_fc_cd1 != null){    
		$where_sql .= " AND t_aorder_h.act_cd1 LIKE '%$charge_fc_cd1' ";
	}
	//代行先CD2
	if($charge_fc_cd2 != null){
		$where_sql .= " AND t_aorder_h.act_cd2 LIKE '%$charge_fc_cd2' ";
	}
	//代行先名
	if($charge_fc_name != null){
		$where_sql .= " AND t_aorder_h.act_id IN (SELECT \n";
		$where_sql .= "                             client_id \n";
		$where_sql .= "                         FROM \n";
		$where_sql .= "                             t_client \n";
		$where_sql .= "                         WHERE \n";
		$where_sql .= "                             (t_client.client_name LIKE '%$charge_fc_name%' \n";
		$where_sql .= "                             OR t_client.client_name2 LIKE '%$charge_fc_name%' \n";
		$where_sql .= "                             OR t_client.shop_name LIKE '%$charge_fc_name%' \n";
		$where_sql .= "                             OR t_client.client_cname LIKE '%$charge_fc_name%')) \n";
	}

	//通常伝票判定（1:通常 2:指定 3:他表）
	if($slip_out != "0"){
		$where_sql .= " AND t_client.slip_out = '$slip_out' \n";
	}

	//発行済判定(t:発行済 f:未発行)
	if($slip_flg != "0"){
		$where_sql .= " AND t_aorder_h.slip_flg = '$slip_flg' \n";
	}

	//伝票番号（開始）
	if($ord_no_s != null){
		$where_sql .= " AND  '$ord_no_s' <= t_aorder_h.ord_no \n";
	}
	//伝票番号（終了）
	if($ord_no_e != null){
		$where_sql .= " AND t_aorder_h.ord_no <= '$ord_no_e' \n";
	}

	//************************************************
	//検索処理実施
	//************************************************
	//受注ヘッダー取得SQL
	$sql_column  = "SELECT \n";
	$sql_column .= "    '$offset' AS offset,\n";
	$sql_column .= "    t_aorder_h.aord_id,\n";
	$sql_column .= "    t_aorder_h.ord_no,\n";
	$sql_column .= "    t_aorder_h.ord_time,\n";
	$sql_column .= "    t_aorder_h.client_cname,\n";
	$sql_column .= "    t_staff1.charge_cd  AS staff_cd1  ,\n"; 
	$sql_column .= "    t_staff1.staff_name AS staff_name1,\n";
	$sql_column .= "    t_aorder_h.slip_flg, ";
	$sql_column .= "    t_aorder_h.act_id, ";
	$sql_column .= "    (t_aorder_h.act_cd1 || '-' || t_aorder_h.act_cd2) AS act_cd, ";
	$sql_column .= "    t_aorder_h.act_name, ";
	$sql_column .= "    t_aorder_h.route, ";
	$sql_column .= "    t_aorder_h.client_cd1, ";
	$sql_column .= "    t_aorder_h.client_cd2, ";
	$sql_column .= "    CASE t_client.slip_out ";
//	$sql_column .= "    CASE t_aorder_h.slip_out ";
	$sql_column .= "        WHEN '1' THEN '通常' ";
	$sql_column .= "        WHEN '2' THEN '指定' ";
	$sql_column .= "        WHEN '3' THEN '他票' ";
	$sql_column .= "    END AS slip_out, \n";
	$sql_column .= "    t_aorder_h.slip_out_day ";

	$sql  = "FROM \n";
	$sql .= "    t_aorder_h \n";
	$sql .= "    INNER JOIN t_client ON t_aorder_h.client_id  = t_client.client_id \n";

	//巡回担当者1
	$sql .= "    LEFT JOIN \n";
	$sql .= "        (SELECT \n";
	$sql .= "             t_aorder_staff.aord_id,\n";
	$sql .= "             t_staff.staff_id, \n";
	$sql .= "             t_staff.charge_cd, \n";
	$sql .= "             t_aorder_staff.staff_name \n";
	$sql .= "         FROM \n";
	$sql .= "             t_aorder_staff \n";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
	$sql .= "         WHERE \n";
	$sql .= "             t_aorder_staff.staff_div = '0'\n";
	$sql .= "         AND \n";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
	$sql .= "        )AS t_staff1 ON t_staff1.aord_id = t_aorder_h.aord_id \n";

/*
	//巡回担当者2
	$sql .= "    LEFT JOIN \n";
	$sql .= "        (SELECT \n";
	$sql .= "             t_aorder_staff.aord_id,\n";
	$sql .= "             t_staff.charge_cd, \n";
	$sql .= "             t_aorder_staff.staff_name \n";
	$sql .= "         FROM \n";
	$sql .= "             t_aorder_staff \n";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
	$sql .= "         WHERE \n";
	$sql .= "             t_aorder_staff.staff_div = '1'\n";
	$sql .= "         AND \n";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
	$sql .= "        )AS t_staff2 ON t_staff2.aord_id = t_aorder_h.aord_id \n";

	//巡回担当者3
	$sql .= "    LEFT JOIN \n";
	$sql .= "        (SELECT \n";
	$sql .= "             t_aorder_staff.aord_id,\n";
	$sql .= "             t_staff.charge_cd, \n";
	$sql .= "             t_aorder_staff.staff_name \n";
	$sql .= "         FROM \n";
	$sql .= "             t_aorder_staff \n";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
	$sql .= "         WHERE \n";
	$sql .= "             t_aorder_staff.staff_div = '2'\n";
	$sql .= "         AND \n";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
	$sql .= "        )AS t_staff3 ON t_staff3.aord_id = t_aorder_h.aord_id \n";

	//巡回担当者4
	$sql .= "    LEFT JOIN \n";
	$sql .= "        (SELECT \n";
	$sql .= "             t_aorder_staff.aord_id,\n";
	$sql .= "             t_staff.charge_cd, \n";
	$sql .= "             t_aorder_staff.staff_name \n";
	$sql .= "         FROM \n";
	$sql .= "             t_aorder_staff \n";
	$sql .= "             LEFT JOIN t_staff ON t_staff.staff_id = t_aorder_staff.staff_id \n";
	$sql .= "         WHERE \n";
	$sql .= "             t_aorder_staff.staff_div = '3'\n";
	$sql .= "         AND \n";
	$sql .= "             t_aorder_staff.sale_rate IS NOT NULL\n";
	$sql .= "        )AS t_staff4 ON t_staff4.aord_id = t_aorder_h.aord_id \n";
*/
	$sql .= "WHERE \n";
	
	$sql .= "    ( \n";
	//直営の場合
	if($_SESSION["group_kind"] == '2'){
		$sql .= "    t_aorder_h.shop_id = $_SESSION[client_id] AND t_aorder_h.confirm_flg = 'f' \n";       //自社伝票

		//契約区分が指定された場合
		if($contract_div != "0"){
			$sql .= " AND t_aorder_h.contract_div = '$contract_div' \n";
		}

	//FCの場合
	}else{

		//自社伝票
		if($contract_div == "0" || $contract_div == 1){
			$sql .= " (t_aorder_h.shop_id = $_SESSION[client_id] AND t_aorder_h.contract_div = 1 AND t_aorder_h.confirm_flg = 'f')";
		}
		
		if($contract_div == "0"){
			$sql .= " OR";
		}
		
		//オンライン代行伝票
		if($contract_div == "0" || $contract_div == 2){
			$sql .= " (t_aorder_h.act_id  = $_SESSION[client_id] AND t_aorder_h.contract_div = 2 AND t_aorder_h.trust_confirm_flg = 'f')";
		}

	}
	$sql .= "    ) \n";

	/*
	//直営の場合
	if($_SESSION["group_kind"] == '2'){
		//直営の場合は、通常・オンライン・オフライン全て表示する為、デフォルトは契約区分は指定しない
		$sql .= "    t_aorder_h.shop_id = $shop_id ";
		$sql .= "AND \n";
		$sql .= "    t_aorder_h.confirm_flg = 'f' \n";       //確定フラグ

	//FCの場合
	}else{
		//契約区分が「全て」または「通常」の場合
		if($con_div_sql == NULL || $con_div == '2'){
			//通常伝票
			$sql .= "    t_aorder_h.shop_id = $shop_id ";
			$sql .= "AND \n";
			$sql .= "    t_aorder_h.contract_div = '1' \n";
			$sql .= "AND \n";
			$sql .= "    t_aorder_h.confirm_flg = 'f' \n";   //確定フラグ

		//オンライン伝票
		}else if($con_div == '3'){
			$sql .= "    t_aorder_h.act_id = $shop_id \n";
			$sql .= "AND \n";
			$sql .= "    t_aorder_h.contract_div = '2' \n";
			$sql .= "AND \n";
			$sql .= "    t_aorder_h.trust_confirm_flg = 'f' \n";   //確定フラグ(受託先)
		}
	}
	*/
	$sql .= "AND \n";
	$sql .= "    (t_aorder_h.ps_stat = '1' OR t_aorder_h.ps_stat = '2') \n"; //未処理or 取引中
	$sql .= "AND \n";
	$sql .= "    t_aorder_h.del_flg = 'f' \n";                 //削除伝票でない
	$sql .= "AND \n";
	$sql .= "    t_aorder_h.ord_no IS NOT NULL \n";            //付番済伝票
	$sql .= "AND \n";
	$sql .= "   t_aorder_h.ord_time <= '$end_day' \n";         //カレンダー表示終了日
	$sql .= $where_sql;
	$sql_another  = "\n ORDER BY \n";

/*
	$sql_another  = "\n ORDER BY \n";
	$sql_another .= "    staff_cd1  ,\n"; 
	$sql_another .= "    t_aorder_h.ord_time,\n";
	$sql_another .= "    t_aorder_h.ord_no \n";
	//$sql_another .= " 5,3,2 ";
*/  
  switch ($where["hdn_sort_col"]){
        case "sl_client_cd":
	        $sql_another .= "   t_aorder_h.client_cd1, \n";
	        $sql_another .= "   t_aorder_h.client_cd2, \n";
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_time, \n";
	        $sql_another .= "   t_aorder_h.ord_no \n";
            break;
        case "sl_client_name":
	        $sql_another .= "   t_aorder_h.client_cname, \n";
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_time, \n";
	        $sql_another .= "   t_aorder_h.ord_no \n";
            break;
        case "sl_slip":
	        $sql_another .= "   t_aorder_h.ord_no, \n";
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_time \n";
            break;
        case "sl_round_day":
	        $sql_another .= "   t_aorder_h.ord_time, \n";
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_no \n";
            break;
        case "sl_staff":
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_time, \n";
	        $sql_another .= "   t_aorder_h.ord_no \n";
            break;
        case "sl_act_client_cd":
	        $sql_another .= "   t_aorder_h.act_cd1, \n";
	        $sql_another .= "   t_aorder_h.act_cd2, \n";
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_time, \n";
	        $sql_another .= "   t_aorder_h.ord_no \n";
            break;
        case "sl_act_client_name":
	        $sql_another .= "   t_aorder_h.act_name, \n";
	        $sql_another .= "   t_aorder_h.act_cd1, \n";
	        $sql_another .= "   t_aorder_h.act_cd2, \n";
	        $sql_another .= "   staff_cd1, \n"; 
	        $sql_another .= "   t_aorder_h.ord_time, \n";
	        $sql_another .= "   t_aorder_h.ord_no \n";
            break;
    }

	if ($where[form_display_num] != "1") {
		$sql_another .= "LIMIT $limit OFFSET $offset ";
	}

	//検索に該当した「件数」を返して終了
	if ($kind == "count") {
		$sql_column = "SELECT COUNT(t_aorder_h.aord_id) ";
		$exec_sql   = "$sql_column"."$sql";
		$result     = Db_Query($db_con, $exec_sql);
		$slip_data       = pg_fetch_result($result, 0 ,0);
		return $slip_data;

	//一覧用 データを取得
	} else {
		$exec_sql   = "$sql_column"."$sql"."$sql_another";
		$result = Db_Query($db_con, $exec_sql);

		if(pg_num_rows($result) != "0"){
			$slip_data   = pg_fetch_all($result);
		}

	}


	//print_array($slip_data);
	return $slip_data;
}


//データを表示用に変換
function HTML_Slip_Data($data,$form){

	//データが有る場合
	if(count($data) != "0"){

		foreach( $data as $key => $val ){
	
			//偶数行は緑
			if ($key%2 == "0"){
				$data[$key]["class"] = "Result1";
				
			//奇数行は白
			}else{
				$data[$key]["class"] = "Result2";
			}
	
			$aord_id = $val[aord_id];
			$data[$key][no]           = $val[offset]+$key+1;
			//$data[$key][no]           = $key+1;
			$data[$key][ord_no]       = "<a href=\"2-2-106.php?aord_id[0]=$aord_id&back_display=output\">".$val[ord_no]."</a>";
			if($val[staff_cd1] != NULL){
				$data[$key][staff_cd1]    = str_pad($val[staff_cd1], 4, 0, STR_POS_LEFT);
			}
			$data[$key][client_cname] = htmlspecialchars($val[client_cname]);
			if($val[act_cd] == "-"){
				$data[$key][act_cd]    = "";
			}
			$data[$key][act_name]     = htmlspecialchars($val[act_name]);
			$data[$key][staff_name1]  = htmlspecialchars($val[staff_name1]);

			//指定伝票の場合
			if ($val[slip_out] == "指定" || $val[slip_out] == "他票"){

			//「通常」かつ「未発行」の場合
			}elseif( $val[slip_out] == "通常" && $val[slip_flg] == "f" ){
				$form->addElement("advcheckbox", "form_slip_check[$key]", NULL, NULL, NULL, array("f", "$aord_id"));
				$form_slip_check_list[$key] = $aord_id;

			//「通常」かつ「発行済」の場合は出力日を表示する
			}else{
				$form->addElement("static", "form_slip_check[$key]", NULL,$val[slip_out_day]);
				$chk_form["form_slip_check"][$key] = $val[slip_out_day]; 

				$form->addElement("advcheckbox", "form_re_slip_check[$key]", NULL, NULL, NULL, array("f", "$aord_id"));
				$form_re_slip_check_list[$key] = $aord_id;
			}
	
		}
		//発行日をセット（検索条件復元でform_slip_checkにfがセットされるため）
		$form->setConstants($chk_form);

	}

	// 売上伝票発行ALL　(JSを作成)
	$javascript  = Create_Allcheck_Js ("All_Check_Slip","form_slip_check",$form_slip_check_list);
	// 再発行ALL　(JSを作成)
	$javascript .= Create_Allcheck_Js ("All_Check_Re_Slip","form_re_slip_check",$form_re_slip_check_list);

	$disp_data[js]   = $javascript;
	$disp_data[html] = $data;

	return $disp_data;
}


?>
