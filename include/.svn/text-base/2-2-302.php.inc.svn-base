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
function Get_Claim_Data($db_con, $where, $page_snum, $page_enum, $kind=""){

    $offset = $page_snum - 1;                   // 表示しない件数
    $limit  = ($page_enum - $page_snum) + 1;    // 一ページあたりの件数

    //**************************//
    // HTMLのvalue値をSQL用に加工
    //**************************//
    // 請求締日
    if ($where["form_close_day"]["y"] != null) {
        $yy_1 = str_pad($where["form_close_day"]["y"], 4, 0, STR_POS_LEFT);
    }else{
        $yy_1 = "____";
    }
    if ($where["form_close_day"]["m"] != null) {
        $mm_1 = str_pad($where["form_close_day"]["m"], 2, 0, STR_POS_LEFT);
    }else{
        $mm_1 = "__";
    }
    $dd_1 = str_pad($where["form_close_day"]["d"], 2, 0, STR_POS_LEFT);

    // 回収予定日（開始）
    if ($where["form_collect_day"]["sy"] != null) {
        $yy_3 = str_pad($where["form_collect_day"]["sy"], 4, 0, STR_POS_LEFT);
    }
    if ($where["form_collect_day"]["sm"] != null) {
        $mm_3 = str_pad($where["form_collect_day"]["sm"], 2, 0, STR_POS_LEFT);
    }
    if ($where["form_collect_day"]["sd"] != null) {
        $dd_3 = str_pad($where["form_collect_day"]["sd"], 2, 0, STR_POS_LEFT);
    }
    $collect_day_s = "$yy_3"."$mm_3"."$dd_3";
    
    // 回収予定日（終了）
    if ($where["form_collect_day"]["ey"] != null) {
        $yy_4 = str_pad($where["form_collect_day"]["ey"], 4, 0, STR_POS_LEFT);
    }
    if ($where["form_collect_day"]["em"] != null) {
        $mm_4 = str_pad($where["form_collect_day"]["em"], 2, 0, STR_POS_LEFT);
    }
    if ($where["form_collect_day"]["ed"] != null) {
        $dd_4 = str_pad($where["form_collect_day"]["ed"], 2, 0, STR_POS_LEFT);
    }
    $collect_day_e = "$yy_4"."$mm_4"."$dd_4";

    // 請求書送付
    if ($where["form_claim_send"] == "1") {
        $where["form_claim_send"] = "";
    }else{
        $where["form_claim_send"] = $where["form_claim_send"] - 1;
    }

    // 請求更新
    if ($where["form_last_update"] == "1") {
        $where["form_last_update"] = "";
    }else
    if ($where["form_last_update"] == "2") {
        $where["form_last_update"] = "f";
    }else
    if ($where["form_last_update"] == "3") {
        $where["form_last_update"] = "t";
    }

    /****************************/
    // 請求書データを抽出SQL
    /****************************/
    $sql_column  = "SELECT \n";
    $sql_column .= "    t_bill.bill_id, \n";
    $sql_column .= "    t_bill.bill_no, \n";
    $sql_column .= "    t_bill_d.bill_close_day_this, \n";
    $sql_column .= "    t_bill.claim_id, \n";
    $sql_column .= "    t_bill.claim_cd1, \n";
    $sql_column .= "    t_bill.claim_cd2, \n";
    $sql_column .= "    t_bill.claim_cname, \n";
    $sql_column .= "    t_bill.collect_day, \n";
    $sql_column .= "    t_bill_d.bill_amount_this, \n";
    $sql_column .= "    t_bill.staff_cd, \n";
    $sql_column .= "    t_bill.staff_name, \n";
    $sql_column .= "    t_bill.claim_send, \n";
    $sql_column .= "    t_bill.pay_way, \n";
    $sql_column .= "    renew_cancel.bill_id AS cancel_bill_id, \n";
    $sql_column .= "    t_bill.fix_flg, \n";
    $sql_column .= "    t_bill.last_update_flg, \n";
    $sql_column .= "    t_bill.last_update_day, \n";
    $sql_column .= "    t_bill.close_day, \n";
    $sql_column .= "    t_bill.issue_day, \n";
    $sql_column .= "    t_bill.bill_format, \n";
    $sql_column .= "    t_bill.ownership_flg \n";

    $sql  = "FROM \n";
    $sql .= "   t_bill \n";
    $sql .= "   INNER JOIN t_client ON t_bill.claim_id = t_client.client_id \n";
    $sql .= "   INNER JOIN t_bill_d ON t_bill.bill_id = t_bill_d.bill_id \n";
    $sql .= "   LEFT JOIN \n";
    $sql .= "   ( \n";
    $sql .= "       SELECT \n";
    $sql .= "           t_bill.bill_id \n";
    $sql .= "       FROM \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   claim_id, \n";
    $sql .= "                   MAX(bill_id) AS bill_id, \n";
    $sql .= "                   close_day, \n";
    $sql .= "                   last_update_flg \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_bill \n";
    $sql .= "               WHERE \n";
    $sql .= "                   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "               AND \n";
    $sql .= "                   last_update_flg = 't' \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   claim_id, \n";
    $sql .= "                   last_update_flg, \n";
    $sql .= "                   close_day \n";
    $sql .= "               ORDER BY \n";
    $sql .= "                   claim_id \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_bill \n";
    $sql .= "           INNER JOIN \n";
    $sql .= "           ( \n";
    $sql .= "               SELECT \n";
    $sql .= "                   claim_id, \n";
    $sql .= "                   MAX(close_day) AS close_day \n";
    $sql .= "               FROM \n";
    $sql .= "                   t_sys_renew \n";
    $sql .= "               WHERE \n";
    $sql .= "                   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "               AND \n";
    $sql .= "                 renew_div = '3' \n";
    $sql .= "               GROUP BY \n";
    $sql .= "                   claim_id \n";
    $sql .= "               ORDER BY \n";
    $sql .= "                   claim_id \n";
    $sql .= "           ) \n";
    $sql .= "           AS t_sys_renew \n";
    $sql .= "           ON t_bill.claim_id = t_sys_renew.claim_id \n";
    $sql .= "       WHERE \n";
    $sql .= "       t_bill.close_day >= t_sys_renew.close_day \n";
    $sql .= "   ) \n";
    $sql .= "   AS renew_cancel \n";
    $sql .= "   ON t_bill.bill_id = renew_cancel.bill_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_bill.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_bill_d.bill_data_div = '0' \n";
    $sql .= "AND \n";
    $sql .= "   t_bill.bill_no IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   t_bill.first_set_flg = 'f' \n";

    // 検索条件追加
    // FC・取引先コード１
    if ($where["form_client"]["cd1"] != null){
        $sql .= "AND t_bill.bill_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_bill_d \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_bill_d.client_cd1 LIKE '".$where["form_client"]["cd1"]."%' \n";
        $sql .= "       GROUP BY \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "   ) \n";
    }
    // FC・取引先コード２
    if ($where["form_client"]["cd2"] != null){
        $sql .= "AND t_bill.bill_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_bill_d \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_bill_d.client_cd2 LIKE '".$where["form_client"]["cd2"]."%' \n";
        $sql .= "       GROUP BY \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "   ) \n";
    }
    // FC・取引先名
    if ($where["form_client"]["name"] != null){
        $sql .= "AND t_bill.bill_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_bill_d \n";
        $sql .= "       WHERE \n";
        $sql .= "           ( \n";
        $sql .= "               t_bill_d.client_name1 LIKE '%".$where["form_client"]["name"]."%' \n";
        $sql .= "               OR \n";
        $sql .= "               t_bill_d.client_name2 LIKE '%".$where["form_client"]["name"]."%' \n";
        $sql .= "               OR \n";
        $sql .= "               t_bill_d.client_cname LIKE '%".$where["form_client"]["name"]."%' \n";
        $sql .= "           ) \n";
        $sql .= "       GROUP BY \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "   ) \n";
    }
    // 担当者（SV）コード
    // 担当者（SV）セレクト
    if ($where["form_sv_staff"]["cd"] != null || $where["form_sv_staff"]["select"] != null){
        $sql .= "AND \n";
        $sql .= "   t_bill.claim_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_client.client_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_client \n";
        $sql .= "           INNER JOIN t_staff ON t_client.sv_staff_id = t_staff.staff_id \n";
        $sql .= "       WHERE \n";
        $sql .= "           t_client.client_id IS NOT NULL \n";
        if ($where["form_sv_staff"]["cd"] != null){
        $sql .= "       AND \n";
        $sql .= "           t_staff.charge_cd = '".$where["form_sv_staff"]["cd"]."' \n";
        }       
        if ($where["form_sv_staff"]["select"] != null){
        $sql .= "       AND \n";
        $sql .= "           t_client.sv_staff_id = ".$where["form_sv_staff"]["select"]." \n";
        }       
        $sql .= "   ) \n";
    }
    // 請求先コード１
    if ($where["form_claim"]["cd1"] != null){
        $sql .= "AND t_bill.claim_cd1 LIKE '".$where["form_claim"]["cd1"]."%' \n";
    }
    // 請求先コード２
    if ($where["form_claim"]["cd2"] != null){
        $sql .= "AND t_bill.claim_cd2 LIKE '".$where["form_claim"]["cd2"]."%' \n";
    }
    // 請求先名
    if ($where["form_claim"]["name"] != null){
        $sql .= "AND \n";
        $sql .= "    ( \n";
        $sql .= "        t_bill.claim_name1 LIKE '%".$where["form_claim"]["name"]."%' \n";
        $sql .= "        OR \n";
        $sql .= "        t_bill.claim_name2 LIKE '%".$where["form_claim"]["name"]."%' \n";
        $sql .= "        OR \n";
        $sql .= "        t_bill.claim_cname LIKE '%".$where["form_claim"]["name"]."%' \n";
        $sql .= "    ) \n";
    }
    // 請求額（開始）
    if ($where["form_amount_this"]["s"] != null){
        $sql .= "AND t_bill_d.bill_amount_this >= '".$where["form_amount_this"]["s"]."' \n";
    }
    // 請求額（終了）
    if ($where["form_amount_this"]["e"] != null){
        $sql .= "AND t_bill_d.bill_amount_this <= '".$where["form_amount_this"]["e"]."' \n";
    }
    // 請求締日（日：全て）
    if ($dd_1 == "00"){
        $sql .= "AND t_bill_d.bill_close_day_this LIKE '".$yy_1."-".$mm_1."-__' \n";
    }else
    // 請求締日（日：月末）
    if ($dd_1 == "29"){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_bill_d.bill_close_day_this LIKE '".$yy_1."-".$mm_1."-28' \n";
        $sql .= "       OR \n";
        $sql .= "       t_bill_d.bill_close_day_this LIKE '".$yy_1."-".$mm_1."-29' \n";
        $sql .= "       OR \n";
        $sql .= "       t_bill_d.bill_close_day_this LIKE '".$yy_1."-".$mm_1."-30' \n";
        $sql .= "       OR \n";
        $sql .= "       t_bill_d.bill_close_day_this LIKE '".$yy_1."-".$mm_1."-31' \n";
        $sql .= "   ) \n";
    // 請求締日（日：日付指定）
    }else{
        $sql .= "AND t_bill_d.bill_close_day_this LIKE '".$yy_1."-".$mm_1."-".$dd_1."' \n";
    }
    // 回収予定日（開始）
    if ($collect_day_s != "") {
        $sql .= "AND t_bill.collect_day >= '$collect_day_s' \n";
    }
    // 回収予定日（終了）   
    if ($collect_day_e != "") {
        $sql .= "AND t_bill.collect_day <= '$collect_day_e' \n";
    }
    // 請求書発行
    if ($where["form_issue"] == "2"){
        $sql .= "AND t_bill.issue_day IS NULL \n";
    }else
    if ($where["form_issue"] == "3"){
        $sql .= "AND t_bill.issue_day IS NOT NULL \n";
    }
    // 請求書送付
    if ($where["form_claim_send"] != ""){
        $sql .= "AND t_bill.claim_send = '".$where["form_claim_send"]."' \n";
    }
    // 請求更新
    if ($where["form_last_update"] != ""){
        $sql .= "AND t_bill.last_update_flg = '".$where["form_last_update"]."' \n";
    }
    // 請求番号（開始）
    if ($where["form_bill_no"]["s"] != null){
        $sql .= "AND t_bill.bill_no >= '".str_pad($where["form_bill_no"]["s"], 8, 0, STR_PAD_LEFT)."' \n";
    }
    // 請求番号（終了）
    if ($where["form_bill_no"]["e"] != null){
        $sql .= "AND t_bill.bill_no <= '".str_pad($where["form_bill_no"]["e"], 8, 0, STR_PAD_LEFT)."' \n";
    }
    // 顧客担当支店
    if ($where["form_client_branch"] != null){
        $sql .= "AND t_client.charge_branch_id = ".$where["form_client_branch"]." \n";
    }
    // 所属本支店
    // 巡回担当者コード
    // 巡回担当者セレクト
    // 部署
    if (
        $where["form_round_staff"]["cd"] != null || $where["form_round_staff"]["select"] != null ||
        $where["form_part"] != null || $where["form_attach_branch"] != null
    ){
        $sql .= "AND \n";
        $sql .= "   t_bill.bill_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_bill_d \n";
        $sql .= "           INNER JOIN t_contract   ON  t_bill_d.client_id = t_contract.client_id \n";
        $sql .= "                                   AND t_contract.contract_div = '1' \n";
        $sql .= "                                   AND t_contract.shop_id IN ".Rank_Sql2()." \n";
        $sql .= "           INNER JOIN t_con_staff  ON  t_contract.contract_id = t_con_staff.contract_id \n";
        $sql .= "                                   AND t_con_staff.staff_div = '0' \n";
        if ($where["form_round_staff"]["select"] != null){
        $sql .= "                                   AND t_con_staff.staff_id = ".$where["form_round_staff"]["select"]." \n";
        }
        $sql .= "           INNER JOIN t_staff      ON  t_con_staff.staff_id = t_staff.staff_id \n";
        if ($where["form_round_staff"]["cd"] != null){
        $sql .= "                                   AND t_staff.charge_cd = '".$where["form_round_staff"]["cd"]."' \n";
        }
        $sql .= "           INNER JOIN t_attach     ON  t_con_staff.staff_id = t_attach.staff_id \n";
        $sql .= "                                   AND t_attach.shop_id IN ".Rank_Sql2()." \n";
        if ($where["form_part"] != null){
        $sql .= "                                   AND t_attach.part_id = ".$where["form_part"]." \n";
        }
        $sql .= "           INNER JOIN t_part       ON  t_attach.part_id = t_part.part_id \n";
        if ($where["form_attach_branch"] != null){
        $sql .= "                                   AND t_part.branch_id = ".$where["form_attach_branch"]." \n";
        }
        $sql .= "       GROUP BY \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "    ) \n";
    }
    // 委託先FCコード１
    // 委託先FCコード２
    // 委託先FC名
    // 委託先FCセレクト
    if (
        $where["form_charge_fc"]["cd1"] != null || $where["form_charge_fc"]["cd2"] != null ||
        $where["form_charge_fc"]["name"] != null || $where["form_charge_fc"]["select"][1] != null
    ){
        $sql .= "AND \n";
        $sql .= "   t_bill.bill_id IN \n";
        $sql .= "   ( \n";
        $sql .= "       SELECT \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "       FROM \n";
        $sql .= "           t_bill_d \n";
        $sql .= "           INNER JOIN t_contract   ON  t_bill_d.client_id = t_contract.client_id \n";
        $sql .= "                                   AND t_contract.contract_div IN ('2', '3') \n";
        $sql .= "                                   AND t_contract.shop_id IN ".Rank_Sql2()." \n";
        if ($where["form_charge_fc"]["select"][1] != null){
        $sql .= "                                   AND t_contract.trust_id = ".$where["form_charge_fc"]["select"][1]." \n";
        }
        $sql .= "           INNER JOIN t_client     ON  t_contract.trust_id = t_client.client_id \n";
        if ($where["form_charge_fc"]["cd1"] != null){
        $sql .= "                                   AND t_client.client_cd1 LIKE '".$where["form_charge_fc"]["cd1"]."%' \n";
        }
        if ($where["form_charge_fc"]["cd2"] != null){
        $sql .= "                                   AND t_client.client_cd2 LIKE '".$where["form_charge_fc"]["cd2"]."%' \n";
        }
        if ($where["form_charge_fc"]["name"] != null){
        $sql .= "                                   AND \n";
        $sql .= "                                   ( \n";
        $sql .= "                                       t_client.client_name  LIKE '%".$where["form_charge_fc"]["name"]."%' \n";
        $sql .= "                                       OR \n";
        $sql .= "                                       t_client.client_name2 LIKE '%".$where["form_charge_fc"]["name"]."%' \n";
        $sql .= "                                       OR \n";
        $sql .= "                                       t_client.client_cname LIKE '%".$where["form_charge_fc"]["name"]."%' \n";
        $sql .= "                                   ) \n";
        }
        $sql .= "       GROUP BY \n";
        $sql .= "           t_bill_d.bill_id \n";
        $sql .= "    ) \n";
    }


    //抽出条件
    if($where["form_data_state"] == 'toyo'){
        $sql .= "AND ";
        $sql .= "   t_bill.claim_id != 93 ";
    }

    $sql_another  = "ORDER BY \n";
    switch ($where["hdn_sort_col"]){
        // 請求番号
        case "sl_slip":
                $sql_another .= "   t_bill.bill_no, \n";
                $sql_another .= "   t_bill_d.bill_close_day_this, \n";
                $sql_another .= "   t_bill.claim_cd1, \n";
                $sql_another .= "   t_bill.claim_cd2 \n";
            break;
        // 請求締日
        case "sl_close_day":
                $sql_another .= "   t_bill_d.bill_close_day_this, \n";
                $sql_another .= "   t_bill.claim_cd1, \n";
                $sql_another .= "   t_bill.claim_cd2 \n";
            break;
        // 請求先コード
        case "sl_claim_cd":
                $sql_another .= "   t_bill.claim_cd1, \n";
                $sql_another .= "   t_bill.claim_cd2, \n";
                $sql_another .= "   t_bill_d.bill_close_day_this \n";
            break;
        // 請求先名
        case "sl_claim_name":
                $sql_another .= "   t_bill.claim_cname, \n";
                $sql_another .= "   t_bill_d.bill_close_day_this, \n";
                $sql_another .= "   t_bill.claim_cd1, \n";
                $sql_another .= "   t_bill.claim_cd2 \n";
            break;
        // 回収予定日
        case "sl_collect_day":
                $sql_another .= "   t_bill.collect_day, \n";
                $sql_another .= "   t_bill_d.bill_close_day_this, \n";
                $sql_another .= "   t_bill.claim_cd1, \n";
                $sql_another .= "   t_bill.claim_cd2 \n";
            break;
        // 担当者
        case "sl_staff":
                $sql_another .= "   t_bill.staff_cd, \n";
                $sql_another .= "   t_bill_d.bill_close_day_this, \n";
                $sql_another .= "   t_bill.claim_cd1, \n";
                $sql_another .= "   t_bill.claim_cd2 \n";
            break;
    }
    
    if ($where["form_display_num"] != "1") {
        $sql_another .= "LIMIT $limit OFFSET $offset \n";
    }
    
    // 検索に該当した「件数」を返して終了
    if ($kind == "count") {
        $sql_column = "SELECT COUNT(t_bill.bill_id) \n";
        $exec_sql   = "$sql_column"."$sql";
        $result     = Db_Query($db_con, $exec_sql);
        $data       = pg_fetch_result($result, 0 ,0);
        return $data;

    // 一覧用 請求書データを取得
    } else {
        $exec_sql   = "$sql_column"."$sql"."$sql_another";
        $result     = Db_Query($db_con, $exec_sql);
    }
    
    /****************************/
    //請求書データをテンプレート用に加工する
    /****************************/
    $i="0";
    while ($data[$i] = pg_fetch_array ($result)) {

        $claim_id = $data[$i]["claim_id"];

        //行No.
        $data[$i]["no"] = $page_snum;

        //件数
        $data[0]["sum"]["no"] ++;

        $bill_id = $data[$i]["bill_id"];
        
        //合計
        $b_amount_this_sum[$claim_id] = $data[$i]["bill_amount_this"];  // 最新の今回ご請求額(ソート順が考慮されていません)
        
        //請求番号
        //本部の場合
        if ($_SESSION["group_kind"] == "1") {
            $data[$i]["bill_no"]    = "<a href=\"1-2-304.php?claim_id=$bill_id\">".$data[$i]["bill_no"]."</a>";
        //FCの場合
        } else {
            $data[$i]["bill_no"]    = "<a href=\"2-2-304.php?claim_id=$bill_id\">".$data[$i]["bill_no"]."</a>";
        }
        $data[$i]["client_name"]    = htmlspecialchars($data[$i]["client_name"]);
        $data[$i]["claim_cname"]    = htmlspecialchars($data[$i]["claim_cname"]);
        $data[$i]["staff_name"]     = htmlspecialchars($data[$i]["staff_name"]);

        //担当者コードを0埋め
        if ($data[$i]["staff_cd"] != null){
            $data[$i]["staff_cd"]   = str_pad($data[$i]["staff_cd"], 4, 0, STR_POS_LEFT);
            $data[0]["sum"]["staff_cd"]++;
        }

        //今回御請求額がマイナスの場合は赤文字で表示
        $data[$i]["bill_amount_this"] = Minus_Numformat($data[$i]["bill_amount_this"]);


        //請求書送付
        if ($data[$i]["claim_send"] == "1") {
            $data[$i]["claim_send"] = "郵送";
        }else
        if ($data[$i]["claim_send"] == "2") {
            $data[$i]["claim_send"] = "メール";
        }else
        if ($data[$i]["claim_send"] == "3") {
            $data[$i]["claim_send"] = "郵送・メール";
        }else
        if ($data[$i]["claim_send"] == "4") {
            $data[$i]["claim_send"] = "WEB";
        }
    
        // 請求書発行
        if ($data[$i]["fix_flg"] == "t") {
            $data[$i]["claim_issue"] = "";
    
        }else{
            $data[$i]["claim_issue"] = "t";
    
        }

        // 請求更新取消・削除
        $data[$i][delete] = "<a href=\"".$_SERVER["PHP_SELF"]."\" onClick=\"Javascript:Link_Action('delete','$bill_id');return false;\">取消</a>";
        
        $i++;
        $page_snum++;
    }
    
    /****************************/
    //合計額についての処理
    /****************************/
    //今回御請求額は最新のデータを集計する
    if(is_array($b_amount_this_sum)){
        $data[0]["sum"]["bill_amount_this"] = array_sum($b_amount_this_sum);
    }
    $data[0]["sum"]["bill_amount_this"] = Minus_Numformat($data[0]["sum"]["bill_amount_this"]);
    
    //while処理で最終配列は"null"が入るため取り除く
    array_pop($data);

    return $data;
}


/**
 * 概要　チェックボックスの全チェックを行なうjavascriptを作成します。
 *
 * 説明　HTML_QuickFormのadvcheckboxで作成されたチェックボックス用の関数です。
 *
 * @param string    $function_name   javascriptの関数名
 * @param string    $name            全チェックするチェックボックス名
 *
 * @return string          全チェックのjavascript
 */
/*
function Create_Allcheck_Js ($function_name, $name, $data) {

  if (is_array($data)) {
        while ($val = each($data)) {
            $line        = $val[0];
            $bill_id     = $val[1];
            $f_name_val  = $name."[".$line."]";
            $f_name_chk  = "__".$name."[".$line."]";
        
            $js_parts1 .= "         document.forms[0].elements[\"$f_name_val\"].value = \"$bill_id\";\n ";
            $js_parts1 .= "         document.forms[0].elements[\"$f_name_chk\"].checked = true; \n";
        
            $js_parts2 .= "         document.forms[0].elements[\"$f_name_val\"].value = \"f\";\n ";
            $js_parts2 .= "         document.forms[0].elements[\"$f_name_chk\"].checked = false; \n";
        
        }
    }
    $javascript = "
    function $function_name (all_name) {
        var ALL = all_name;
        if(document.forms[0].elements[ALL].checked == true){
            $js_parts1
        }else{
            $js_parts2
        }
    }
    ";

    return $javascript;
}
*/
//SELECT bill_id,count(bill_id) FROM t_bill_d WHERE bill_data_div =0 GROUP BY bill_id ORDER BY bill_id;




?>
