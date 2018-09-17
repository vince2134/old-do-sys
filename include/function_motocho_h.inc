<?php

// 売掛残高取得
function Ar_Balance_Sql($start_day, $client_id){

    $sql  = "SELECT \n";
    $sql .= "   ar_balance_this, \n";
    $sql .= "   monthly_close_day_this \n";
    $sql .= "FROM \n";
    $sql .= "   t_ar_balance \n";
    $sql .= "WHERE \n";
    $sql .= "   monthly_close_day_this <= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   monthly_close_day_this DESC \n";
    $sql .= "LIMIT 1 OFFSET 0 \n";
    $sql .= ";";

    return $sql;

}

// 初期売掛残高取得
function Ar_First_Balance_Sql($client_id){

    $sql  = "SELECT \n";
    $sql .= "   ar_balance \n";
    $sql .= "FROM \n";
    $sql .= "   t_first_ar_balance \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= ";";

    return $sql;

}

// 売上の繰越額取得
function Sale_Amount_Sql($start_day, $monthly_close_day, $client_id){

    $sql  = "SELECT \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               trade_id IN (11, 15, 61) \n";
    $sql .= "           THEN \n";
    $sql .= "               (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               trade_id IN (13, 14, 63, 64) \n";
    $sql .= "           THEN \n";
    $sql .= "               (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "       END \n";
    $sql .= "   ) \n";
    $sql .= "   AS sale_amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_sale_h \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    // 集計期間（開始）が月次締日の場合
    if ($start_day == $monthly_close_day){
        $sql .= "AND \n";
        $sql .= "   sale_day = '$start_day' \n";
    // 集計期間（開始）が月次締日でない場合
    }else{
        $sql .= "AND \n";
        $sql .= "   sale_day > '$monthly_close_day' \n";
        $sql .= "AND \n";
        $sql .= "   sale_day <= CAST('$start_day' AS DATE) - CAST('1 day' AS INTERVAL) \n";
    }
    $sql .= ";";

    return $sql;

}

// 入金の繰越額取得
function Payin_Amount_Sql($start_day, $monthly_close_day, $client_id){

    $sql  = "SELECT \n";
    $sql .= "   SUM(COALESCE(t_payin_d.amount, 0)) AS pay_amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h INNER JOIN t_payin_d ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.client_id = $client_id \n";
    // 集計期間（開始）が月次締日の場合
    if ($start_day == $monthly_close_day){
        $sql .= "AND \n";
        $sql .= "   t_payin_h.pay_day = '$start_day' \n";
    // 集計期間（開始）が月次締日でない場合
    }else{
        $sql .= "AND \n";
        $sql .= "   t_payin_h.pay_day > '$monthly_close_day' \n";
        $sql .= "AND \n";
        $sql .= "   t_payin_h.pay_day <= CAST('$start_day' AS DATE) - CAST('1 day' AS INTERVAL) \n";
    }
    $sql .= ";";

    return $sql;

}

// 売掛伝票明細データ取得
function Ar_Particular_Sql($start_day, $end_day, $client_id, $limit = null, $offset = null){

    /*****
    取得カラムの説明
        trade_day           売上日 / 入金日
        slip_no             伝票番号
        c_staff             担当者
        trade_id            取引区分
        trade_cd            取引区分コード
        official_goods_name 商品名 / 伝票消費税
        num                 数量
        sale_price          単価
        sale_amount         売上額
        payin_amount        入金額
        line                行数
        payin_flg           入金明細フラグ
        sale_flg            売上明細フラグ
        tax_flg             消費税フラグ
        lumptax_flg         一括消費税フラグ
        royalty_flg         ロイヤリティフラグ
    *****/

    // 入金伝票データ
    $sql  = "SELECT \n";
    $sql .= "   t_payin_h.pay_day       AS trade_day, \n";
    $sql .= "   t_payin_h.pay_no        AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   CASE t_trade.trade_id \n";
    $sql .= "       WHEN 31 THEN '入金（集金）' \n";
    $sql .= "       WHEN 32 THEN '入金（振込）' \n";
    $sql .= "       WHEN 33 THEN '入金（手形）' \n";
    $sql .= "       WHEN 34 THEN '相殺' \n";
    $sql .= "       WHEN 35 THEN '手数料' \n";
    $sql .= "       WHEN 36 THEN '入金（その他）' \n";
    $sql .= "       WHEN 37 THEN 'スイット相殺' \n";
    $sql .= "       WHEN 38 THEN '調整' \n";
    $sql .= "       WHEN 39 THEN '入金（現金売上）' \n";
    $sql .= "   END \n";
    $sql .= "                           AS goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS sale_price, \n";
    $sql .= "   NULL                    AS sale_amount, \n";
    $sql .= "   t_payin_d.amount        AS payin_amount, \n";
    $sql .= "   NULL                    AS line, \n";
    $sql .= "   't'                     AS payin_flg, \n";
    $sql .= "   'f'                     AS sale_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_payin_h \n";
    $sql .= "   INNER JOIN t_payin_d    ON t_payin_h.pay_id = t_payin_d.pay_id \n";
    $sql .= "   INNER JOIN t_trade      ON t_payin_d.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payin_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.pay_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   t_payin_h.pay_day <= '$end_day' \n";

    $sql .= "UNION ALL \n";

    // 売上伝票データ
    $sql .= "SELECT \n";
    $sql .= "   t_sale_h.sale_day       AS trade_day, \n";
    $sql .= "   t_sale_h.sale_no        AS slip_no, \n";
    $sql .= "   t_sale_h.c_staff_name   AS c_staff, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   t_sale_d.official_goods_name AS goods_name, \n";
    $sql .= "   t_sale_d.num, \n";
    $sql .= "   t_sale_d.sale_price, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (11, 15, 61) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_sale_d.sale_amount * 1 \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (13, 14, 63, 64) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_sale_d.sale_amount * -1 \n";
    $sql .= "   END \n";
    $sql .= "                           AS sale_amount, \n";
    $sql .= "   NULL                    AS payin_amount, \n";
    $sql .= "   t_sale_d.line, \n";
    $sql .= "   'f'                     AS payin_flg, \n";
    $sql .= "   't'                     AS sale_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_sale_h \n";
    $sql .= "   INNER JOIN t_sale_d     ON t_sale_h.sale_id = t_sale_d.sale_id \n";
    $sql .= "   INNER JOIN t_trade      ON t_sale_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day <= '$end_day' \n";

    $sql .= "UNION ALL \n";

    // 売上伝票単位の消費税
    $sql .= "SELECT \n";
    $sql .= "   t_sale_h.sale_day       AS trade_day, \n";
    $sql .= "   t_sale_h.sale_no        AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   '伝票消費税'            AS goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS sale_price, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (11, 15, 61) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_sale_h.tax_amount * 1 \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (13, 14, 63, 64) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_sale_h.tax_amount * -1 \n";
    $sql .= "   END \n";
    $sql .= "                           AS sale_amount, \n";
    $sql .= "   NULL                    AS payin_amount, \n";
    $sql .= "   MAX(t_sale_d.line) + 1  AS line, \n";
    $sql .= "   'f'                     AS payin_flg, \n";
    $sql .= "   't'                     AS sale_flg, \n";
    $sql .= "   't'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_sale_h \n";
    $sql .= "   INNER JOIN t_sale_d     ON t_sale_h.sale_id = t_sale_d.sale_id \n";
    $sql .= "   INNER JOIN t_trade      ON t_sale_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_sale_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   t_sale_h.sale_day <= '$end_day' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_sale_h.sale_day, \n";
    $sql .= "   t_sale_h.sale_no, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   t_sale_h.tax_amount \n";

    $sql .= "UNION ALL \n";

    // 一括消費税
    $sql .= "SELECT \n";
    $sql .= "   allocate_day            AS trade_day, \n";
    $sql .= "   '-'                     AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   NULL                    AS trade_id, \n";
    $sql .= "   NULL                    AS trade_cd, \n";
    $sql .= "   goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS sale_price, \n";
    $sql .= "   tax_amount              AS sale_amount, \n";
    $sql .= "   NULL                    AS payin_amount, \n";
    $sql .= "   NULL                    AS line, \n";
    $sql .= "   'f'                     AS payin_flg, \n";
    $sql .= "   'f'                     AS sale_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   't'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_lump_amount \n";
    $sql .= "WHERE \n";
    $sql .= "   data_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   bill_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day <= '$end_day' \n";

    $sql .= "UNION ALL \n";

    // ロイヤリティ
    $sql .= "SELECT \n";
    $sql .= "   allocate_day            AS trade_day, \n";
    $sql .= "   '-'                     AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   NULL                    AS trade_id, \n";
    $sql .= "   NULL                    AS trade_cd, \n";
    $sql .= "   goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS sale_price, \n";
    $sql .= "   net_amount              AS sale_amount, \n";
    $sql .= "   NULL                    AS payin_amount, \n";
    $sql .= "   NULL                    AS line, \n";
    $sql .= "   'f'                     AS payin_flg, \n";
    $sql .= "   'f'                     AS sale_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   't'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_lump_amount \n";
    $sql .= "WHERE \n";
    $sql .= "   data_div = '1' \n";
    $sql .= "AND \n";
    $sql .= "   bill_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day <= '$end_day' \n";

    $sql .= "UNION ALL \n";

    // ロイヤリティ（消費税）
    $sql .= "SELECT \n";
    $sql .= "   allocate_day            AS trade_day, \n";
    $sql .= "   NULL                    AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   NULL                    AS trade_id, \n";
    $sql .= "   NULL                    AS trade_cd, \n";
    $sql .= "   '消費税金額'            AS goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS sale_price, \n";
    $sql .= "   tax_amount              AS sale_amount, \n";
    $sql .= "   NULL                    AS payin_amount, \n";
    $sql .= "   NULL                    AS line, \n";
    $sql .= "   'f'                     AS payin_flg, \n";
    $sql .= "   'f'                     AS sale_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   't'                     AS lumptax_flg, \n";
    $sql .= "   't'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_lump_amount \n";
    $sql .= "WHERE \n";
    $sql .= "   data_div = '1' \n";
    $sql .= "AND \n";
    $sql .= "   bill_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day <= '$end_day' \n";

    // ソート条件
    $sql .= "ORDER BY \n";
    $sql .= "   trade_day, \n";
    $sql .= "   royalty_flg, \n";
    $sql .= "   lumptax_flg, \n";
    $sql .= "   slip_no, \n";
    $sql .= "   trade_cd, \n";
    $sql .= "   line \n";

    // 取得件数指定
    $sql .= ($limit != null)    ? "LIMIT $limit \n" : null;

    // 取得開始位置指定
    $sql .= ($offset != null)   ? "OFFSET $offset \n" : null;

    $sql .= ";";

    return $sql;

}

// 伝票明細データ取得
function Get_Claim_Data($db_con, $client_id){

    // 該当得意先の請求先を取得
    $sql  = "SELECT \n";
    $sql .= "   t_claim.claim_div, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_client.client_cname \n";
    $sql .= "FROM \n";
    $sql .= "   t_claim \n";
    $sql .= "   INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_claim.client_id = $client_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_claim.claim_div \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $ary_claim_data = Get_Data($res, 2, "ASSOC");
    }else{
        $ary_claim_data = null;
    }

    return $ary_claim_data;

}

// 買掛残高取得
function Ap_Balance_Sql($start_day, $client_id){

    $sql  = "SELECT \n";
    $sql .= "   ap_balance_this, \n";
    $sql .= "   monthly_close_day_this \n";
    $sql .= "FROM \n";
    $sql .= "   t_ap_balance \n";
    $sql .= "WHERE \n";
    $sql .= "   monthly_close_day_this <= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "ORDER BY \n";
    $sql .= "   monthly_close_day_this DESC \n";
    $sql .= "LIMIT 1 OFFSET 0 \n";
    $sql .= ";";

    return $sql;

}

// 初期買掛残高取得
function Ap_First_Balance_Sql($client_id){

    $sql  = "SELECT \n";
    $sql .= "   ap_balance \n";
    $sql .= "FROM \n";
    $sql .= "   t_first_ap_balance \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= ";";

    return $sql;

}

// 仕入の繰越額取得
function Buy_Amount_Sql($start_day, $monthly_close_day, $client_id){

    $sql  = "SELECT \n";
    $sql .= "   SUM( \n";
    $sql .= "       CASE \n";
    $sql .= "           WHEN \n";
    $sql .= "               trade_id IN (21, 25, 71) \n";
    $sql .= "           THEN \n";
    $sql .= "               (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * 1 \n";
    $sql .= "           WHEN \n";
    $sql .= "               trade_id IN (23, 24, 73, 74) \n";
    $sql .= "           THEN \n";
    $sql .= "               (COALESCE(net_amount, 0) + COALESCE(tax_amount, 0)) * -1 \n";
    $sql .= "       END \n";
    $sql .= "   ) \n";
    $sql .= "   AS buy_amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    // 集計期間（開始）が月次締日の場合
    if ($start_day == $monthly_close_day){
        $sql .= "AND \n";
        $sql .= "   arrival_day = '$start_day' \n";
    // 集計期間（開始）が月次締日でない場合
    }else{
        $sql .= "AND \n";
        $sql .= "   arrival_day > '$monthly_close_day' \n";
        $sql .= "AND \n";
        $sql .= "   arrival_day <= CAST('$start_day' AS DATE) - CAST('1 day' AS INTERVAL) \n";
    }
    $sql .= ";";

    return $sql;

}

// 支払の繰越額取得
function Payout_Amount_Sql($start_day, $monthly_close_day, $client_id){

    $sql  = "SELECT \n";
    $sql .= "   SUM(COALESCE(t_payout_d.pay_amount, 0)) AS pay_amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_payout_h INNER JOIN t_payout_d ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.client_id = $client_id \n";
    // 集計期間（開始）が月次締日の場合
    if ($start_day == $monthly_close_day){
        $sql .= "AND \n";
        $sql .= "   t_payout_h.pay_day = '$start_day' \n";
    // 集計期間（開始）が月次締日でない場合
    }else{
        $sql .= "AND \n";
        $sql .= "   t_payout_h.pay_day > '$monthly_close_day' \n";
        $sql .= "AND \n";
        $sql .= "   t_payout_h.pay_day <= CAST('$start_day' AS DATE) - CAST('1 day' AS INTERVAL) \n";
    }
    $sql .= ";";

    return $sql;

}

// 買掛伝票明細データ取得
function Ap_Particular_Sql($start_day, $end_day, $client_id, $limit = null, $offset = null){

    /*****
    取得カラムの説明
        trade_day           仕入日 / 支払日
        slip_no             伝票番号
        c_staff             担当者
        trade_id            取引区分
        trade_cd            取引区分コード
        goods_name          商品名 / 伝票消費税
        num                 数量
        buy_price           単価
        buy_amount          仕入額
        payout_amount       支払額
        line                行数
        payout_flg          支払明細フラグ
        buy_flg             仕入明細フラグ
        tax_flg             消費税フラグ
        lumptax_flg         一括消費税フラグ
        royalty_flg         ロイヤリティフラグ
    *****/

    // 支払明細データ
    $sql  = "SELECT \n";
    $sql .= "   t_payout_h.pay_day      AS trade_day, \n";
    $sql .= "   t_payout_h.pay_no       AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   CASE t_trade.trade_id \n";
    $sql .= "       WHEN 41 THEN '支払（現金）' \n";
    $sql .= "       WHEN 43 THEN '支払（振込）' \n";
    $sql .= "       WHEN 44 THEN '支払（手形）' \n";
    $sql .= "       WHEN 45 THEN '相殺' \n";
    $sql .= "       WHEN 46 THEN '支払（調整）' \n";
    $sql .= "       WHEN 47 THEN '支払（その他）' \n";
    $sql .= "       WHEN 48 THEN '手数料' \n";
    $sql .= "       WHEN 49 THEN '支払（現金仕入）' \n";
    $sql .= "   END \n";
    $sql .= "                           AS goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS buy_price, \n";
    $sql .= "   NULL                    AS buy_amount, \n";
    $sql .= "   t_payout_d.pay_amount   AS payout_amount, \n";
    $sql .= "   NULL                    AS line, \n";
    $sql .= "   't'                     AS payout_flg, \n";
    $sql .= "   'f'                     AS buy_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_payout_h \n";
    $sql .= "   INNER JOIN t_payout_d   ON t_payout_h.pay_id = t_payout_d.pay_id \n";
    $sql .= "   INNER JOIN t_trade      ON t_payout_d.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_payout_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.pay_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   t_payout_h.pay_day <= '$end_day' \n";

    $sql .= "UNION ALL \n";

    // 仕入伝票データ
    $sql .= "SELECT \n";
    $sql .= "   t_buy_h.arrival_day    AS trade_day, \n";
    $sql .= "   t_buy_h.buy_no         AS slip_no, \n";
    $sql .= "   t_buy_h.c_staff_name   AS c_staff, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   t_buy_d.goods_name, \n";
    $sql .= "   t_buy_d.num, \n";
    $sql .= "   t_buy_d.buy_price, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_buy_d.buy_amount * 1 \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (23, 24, 73, 74) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_buy_d.buy_amount * -1 \n";
    $sql .= "   END \n";
    $sql .= "                           AS buy_amount, \n";
    $sql .= "   NULL                    AS payout_amount, \n";
    $sql .= "   t_buy_d.line, \n";
    $sql .= "   'f'                     AS payout_flg, \n";
    $sql .= "   't'                     AS buy_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "   INNER JOIN t_buy_d      ON t_buy_h.buy_id = t_buy_d.buy_id \n";
    $sql .= "   INNER JOIN t_trade      ON t_buy_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_buy_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_buy_h.arrival_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   t_buy_h.arrival_day <= '$end_day' \n";

    $sql .= "UNION ALL \n";

    // 仕入伝票単位の消費税
    $sql .= "SELECT \n";
    $sql .= "   t_buy_h.arrival_day     AS trade_day, \n";
    $sql .= "   t_buy_h.buy_no          AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   '伝票消費税'            AS goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS buy_price, \n";
    $sql .= "   CASE \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (21, 25, 71) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_buy_h.tax_amount * 1 \n";
    $sql .= "       WHEN \n";
    $sql .= "           t_trade.trade_id IN (23, 24, 73, 74) \n";
    $sql .= "       THEN \n";
    $sql .= "           t_buy_h.tax_amount * -1 \n";
    $sql .= "   END \n";
    $sql .= "                           AS buy_amount, \n";
    $sql .= "   NULL                    AS payout_amount, \n";
    $sql .= "   MAX(t_buy_d.line) + 1   AS line, \n";
    $sql .= "   'f'                     AS payout_flg, \n";
    $sql .= "   't'                     AS buy_flg, \n";
    $sql .= "   't'                     AS tax_flg, \n";
    $sql .= "   'f'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "   INNER JOIN t_buy_d      ON t_buy_h.buy_id = t_buy_d.buy_id \n";
    $sql .= "   INNER JOIN t_trade      ON t_buy_h.trade_id = t_trade.trade_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   t_buy_h.client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   t_buy_h.arrival_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   t_buy_h.arrival_day <= '$end_day' \n";
    $sql .= "GROUP BY \n";
    $sql .= "   t_buy_h.arrival_day, \n";
    $sql .= "   t_buy_h.buy_no, \n";
    $sql .= "   t_trade.trade_id, \n";
    $sql .= "   t_trade.trade_cd, \n";
    $sql .= "   t_buy_h.tax_amount \n";

    $sql .= "UNION ALL \n";

    // 一括消費税
    $sql .= "SELECT \n";
    $sql .= "   allocate_day            AS trade_day, \n";
    $sql .= "   '-'                     AS slip_no, \n";
    $sql .= "   NULL                    AS c_staff, \n";
    $sql .= "   NULL                    AS trade_id, \n";
    $sql .= "   NULL                    AS trade_cd, \n";
    $sql .= "   goods_name, \n";
    $sql .= "   NULL                    AS num, \n";
    $sql .= "   NULL                    AS buy_price, \n";
    $sql .= "   tax_amount              AS buy_amount, \n";
    $sql .= "   NULL                    AS payout_amount, \n";
    $sql .= "   NULL                    AS line, \n";
    $sql .= "   'f'                     AS payout_flg, \n";
    $sql .= "   'f'                     AS buy_flg, \n";
    $sql .= "   'f'                     AS tax_flg, \n";
    $sql .= "   't'                     AS lumptax_flg, \n";
    $sql .= "   'f'                     AS royalty_flg \n";
    $sql .= "FROM \n";
    $sql .= "   t_lump_amount \n";
    $sql .= "WHERE \n";
    $sql .= "   data_div = '2' \n";
    $sql .= "AND \n";
    $sql .= "   schedule_payment_id IS NOT NULL \n";
    $sql .= "AND \n";
    $sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= "AND \n";
    $sql .= "   client_id = $client_id \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day >= '$start_day' \n";
    $sql .= "AND \n";
    $sql .= "   allocate_day <= '$end_day' \n";

    // ソート条件
    $sql .= "ORDER BY \n";
    $sql .= "   trade_day, \n";
    $sql .= "   lumptax_flg, \n";
    $sql .= "   slip_no, \n";
    $sql .= "   trade_cd, \n";
    $sql .= "   line \n";

    // 取得件数指定
    $sql .= ($limit != null)    ? "LIMIT $limit \n" : null;

    // 取得開始位置指定
    $sql .= ($offset != null)   ? "OFFSET $offset \n" : null;

    $sql .= ";";

    return $sql;

}

// 金額が負数の場合にセル内の文字色を赤にする関数
function Font_Color($num){
    return ((int)$num < 0) ? " style=\"color: #ff0000;\"" : null;
}

?>
