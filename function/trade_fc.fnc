<?php

/**
 *
 * 売上確定時の在庫受払、自動入金のクエリを発行
 *
 * ・売上巡回担当者テーブル、売上出庫品テーブルを登録してあることが前提
 * ・引数の売上IDから取引区分を取得し、それによって必要なクエリを発行する
 * 　割賦売上の場合の処理を追加（2006-09-05）
 * ・代行、紹介口座の自動仕入、自動売上等は呼出元のモジュールで下の方の関数を呼んでください
 *
 *
 * 変更履歴
 * 1.1.0 (2006-09-16) kaji
 *   ・とりあえず割賦売上をデフォルト2回に変更
 * 1.1.1 (2006-09-26) kaji
 *   ・掛売上のときの受払が間違っていたのを修正
 *     売上は「1：入庫」→「2：出庫」、引当は「2：出庫」→「1：入庫」
 * 2006-12-12  掛値引・現金値引は受払いには登録しないように修正 suzuki
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $sale_id    売上ID
 *
 * @return      bool        成功：true
 *                          失敗：false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2006/09/16)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/03/02      要望5-2     kajioka-h   手書伝票の売上時の受払処理を「出荷倉庫→担当者倉庫→得意先」という流れに
 *  2007/03/27      要望21他    kajioka-h   予定データの売上確定時の受払は「引当削除」「売上登録」という処理に
 *  2007/03/28      要望21他    kajioka-h   商品予定出荷していない予定伝票は、ヘッダの出荷倉庫を担当者の拠点倉庫に更新する
 *  2007-06-07                  fukuda      FC_Trade_Query: 売上ヘッダからデータ取得する際、前受相殺額合計も取得
 *  2007-06-07                  fukuda      FC_Payin_Query: ↑で取得した前受相殺額合計がある場合は取引区分「前受相殺」で入金する
 *  2007/06/09      その他14    kajioka-h   「掛売上」はプラス、「掛返品」「掛値引」はマイナスで前受相殺する
 *  2007-07-12                  fukuda      「支払締」を「仕入締」に変更
 *
 */
function FC_Trade_Query($db_con, $sale_id)
{
    //売上ヘッダから
    //取引区分、手書伝票フラグ、ショップID、出荷倉庫ID、巡回担当者（メイン）、伝票番号、売上日取得
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.trade_id, ";      //取引区分
    $sql .= "    t_sale_h.contract_div, ";  //契約区分
    $sql .= "    t_sale_h.hand_slip_flg, "; //手書伝票フラグ
    $sql .= "    t_sale_h.client_id, ";     //得意先ID
    $sql .= "    t_sale_h.ware_id, ";       //出荷倉庫ID
    $sql .= "    t_sale_h.shop_id, ";       //ショップID
    $sql .= "    t_sale_h.act_id, ";        //受託先ID
    $sql .= "    t_sale_staff.staff_id, ";  //巡回担当者ID（メイン）
    $sql .= "    t_sale_h.sale_no, ";       //伝票番号
    $sql .= "    t_sale_h.aord_id, ";       //受注ID
    $sql .= "    t_sale_h.net_amount, ";    //売上金額（税抜）
    $sql .= "    t_sale_h.tax_amount, ";    //消費税額（税抜）
    $sql .= "    t_sale_h.sale_day, ";      //売上日
    $sql .= "    t_sale_h.claim_day, ";     //請求日
    $sql .= "    t_sale_h.advance_offset_totalamount, ";    // 前受相殺額合計（2007-06-07 fukuda）
    $sql .= "    t_sale_h.claim_div ";                      // 請求先区分（2007-06-12 fukuda）
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "    INNER JOIN t_sale_staff ON t_sale_h.sale_id = t_sale_staff.sale_id ";
    $sql .= "        AND t_sale_staff.staff_div ='0' ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = $sale_id ";
    $sql .= ";";
//echo "$sql<br>";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //レコードが存在しない場合は処理終わり
    if(pg_num_rows($result) == 0){
        return true;
    }

    $trade_id      = pg_fetch_result($result, 0, "trade_id");       //取引区分
    $contract_div  = pg_fetch_result($result, 0, "contract_div");   //契約区分
    $hand_slip_flg = pg_fetch_result($result, 0, "hand_slip_flg");  //手書伝票フラグ
    $client_id     = pg_fetch_result($result, 0, "client_id");      //得意先ID
    $ware_id       = pg_fetch_result($result, 0, "ware_id");        //出荷倉庫ID（伝票の）
    $shop_id       = pg_fetch_result($result, 0, "shop_id");        //ショップID（代行の場合は委託先ID）
    $act_id        = pg_fetch_result($result, 0, "act_id");         //受託先ID
    $staff_id      = pg_fetch_result($result, 0, "staff_id");       //巡回担当者ID（メイン）
    $slip_no       = pg_fetch_result($result, 0, "sale_no");        //伝票番号
    $aord_id       = pg_fetch_result($result, 0, "aord_id");        //受注ID
    $net_amount    = pg_fetch_result($result, 0, "net_amount");     //売上金額（税抜）
    $tax_amount    = pg_fetch_result($result, 0, "tax_amount");     //消費税額（税抜）
    $sale_day      = pg_fetch_result($result, 0, "sale_day");       //売上日
    $claim_day     = pg_fetch_result($result, 0, "claim_day");      //請求日
    $advance_offset= pg_fetch_result($result, 0, "advance_offset_totalamount");     // 前受相殺額合計（2007-06-07 fukuda）
    $claim_div     = pg_fetch_result($result, 0, "claim_div");                      // 請求先区分（2007-06-12 fukuda）

    $branch_id     = Get_Branch_Id($db_con, $staff_id);             //巡回担当者の支店ID
    $staff_bases_ware_id = Get_Ware_Id($db_con, $branch_id);        //巡回担当者の拠点倉庫ID
    $staff_ware_id = Get_Staff_Ware_Id($db_con, $staff_id);         //巡回担当者の担当倉庫ID

    //受注ヘッダの商品予定出荷フラグ取得
    $sql  = "SELECT t_aorder_h.move_flg \n";
    $sql .= "FROM t_aorder_h INNER JOIN t_sale_h ON t_aorder_h.aord_id = t_sale_h.aord_id \n";
    $sql .= "WHERE t_sale_h.sale_id = $sale_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $move_flg = ($hand_slip_flg == "f") ? pg_fetch_result($result, 0, "move_flg") : "f";    //商品予定出荷フラグ

    //売上データID取得
    $sql = "SELECT sale_d_id FROM t_sale_d WHERE sale_id = $sale_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $count = pg_num_rows($result);
    for($i=0;$i<$count;$i++){
        $sale_d_id[$i] = pg_fetch_result($result, $i, "sale_d_id");
    }


    //契約区分が2「オンライン代行」で、受託先の場合（巡回報告）はまだ受払は書かない
    //契約区分が3「オフライン代行」の場合は受払は書かない
    //if(($contract_div == "2" && $_SESSION["group_kind"] == "2") || $contract_div != 3){

    //契約区分が1「自社巡回」のときのみ
    if($contract_div == "1"){

        //予定伝票の場合
        if($hand_slip_flg == "f"){
            //商品予定出荷していない場合は、受注ヘッダ、売上ヘッダの出荷倉庫を現時点の担当者の拠点倉庫に更新
            if($move_flg == "f"){
                $sql  = "UPDATE t_aorder_h SET \n";
                $sql .= "    ware_id = $staff_bases_ware_id , \n";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $staff_bases_ware_id) \n";
                $sql .= "WHERE \n";
                $sql .= "    aord_id = (SELECT aord_id FROM t_sale_h WHERE sale_id = $sale_id) \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    return false;
                }

                $sql  = "UPDATE t_sale_h SET \n";
                $sql .= "    ware_id = $staff_bases_ware_id , \n";
                $sql .= "    ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $staff_bases_ware_id) \n";
                $sql .= "WHERE \n";
                $sql .= "    sale_id = $sale_id \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    return false;
                }
            }

            //受注の受払（引当）を全て削除
            $sql  = "DELETE FROM t_stock_hand \n";
            $sql .= "WHERE aord_d_id IN ( \n";
            $sql .= "    SELECT \n";
            $sql .= "        t_aorder_d.aord_d_id \n";
            $sql .= "    FROM \n";
            $sql .= "        t_sale_h \n";
            $sql .= "        INNER JOIN t_aorder_h ON t_sale_h.aord_id = t_aorder_h.aord_id \n";
            $sql .= "        INNER JOIN t_aorder_d ON t_aorder_h.aord_id = t_aorder_d.aord_id \n";
            $sql .= "    WHERE \n";
            $sql .= "        t_sale_h.sale_id = $sale_id \n";
            $sql .= "    ) \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result === false){
                return false;
            }
        }


        //売上データID分ループ
        for($i=0;$i<$count;$i++){

            //出庫品テーブルから商品ID、数量を取得
            $sql  = "SELECT ";
            $sql .= "    goods_id, ";
            $sql .= "    num ";
            $sql .= "FROM ";
            $sql .= "    t_sale_ship ";
            $sql .= "WHERE ";
            $sql .= "    sale_d_id = ".$sale_d_id[$i]." ";
            $sql .= ";";
//echo "$sql<br>";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                return false;
            }

            $ship_count = pg_num_rows($result);
            //出庫品テーブル分ループ
            for($j=0;$j<$ship_count;$j++){

                $goods_id = pg_fetch_result($result, $j, "goods_id");
                $num      = pg_fetch_result($result, $j, "num");


                //取引区分ごとの処理
                switch($trade_id){
                    case "11":
                    case "15":
                    case "61":
                        //掛売上、または割賦売上の場合
                        //現金売上の場合

                        //手書伝票の場合
                        if($hand_slip_flg == 't'){

                            //売上ヘッダの出荷倉庫（拠点倉庫）から担当倉庫に「移動」
                            //出荷倉庫から「移動」で「出庫」
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "5",        //移動
                                //$client_id, 
                                null, 
                                $ware_id,   //出荷倉庫
                                "2",        //出庫
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }

                            //担当倉庫へ「移動」で「入庫」
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "5",        //移動
                                //$client_id, 
                                null, 
                                $staff_ware_id,     //担当倉庫
                                "1",        //入庫
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }

                            //担当者倉庫から「売上」で「出庫」
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "2",        //売上
                                $client_id, 
                                $staff_ware_id,     //担当倉庫
                                "2",        //出庫
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }


                        //手書伝票じゃない場合
                        }else{
/*
                            //受払に「引当」を「出庫」
                            $return = FC_Trade_Stock_hand_Query(
                                $db_con, 
                                $goods_id, 
                                $sale_day, 
                                "1",        //引当
                                //null, 
                                $client_id, 
                                $ware_id,   //出荷倉庫
                                //"2", 
                                "1",    //やっぱり引当は「入庫」？
                                $num, 
                                $slip_no, 
                                $sale_d_id[$i], 
                                $_SESSION["staff_id"], 
                                $shop_id
                            );

                            if($return === false){
                                return false;
                            }
*/
                            if($move_flg == "t"){
                                //商品予定出荷している場合、担当倉庫から「売上」で「出庫」
                                $return = FC_Trade_Stock_hand_Query(
                                    $db_con, 
                                    $goods_id, 
                                    $sale_day, 
                                    "2",        //売上
                                    $client_id, 
                                    $staff_ware_id, //担当倉庫
                                    "2",        //出庫
                                    $num, 
                                    $slip_no, 
                                    $sale_d_id[$i], 
                                    $_SESSION["staff_id"], 
                                    $shop_id
                                );
                            }else{
                                //商品予定出荷していない場合、出荷倉庫から「売上」で「出庫」
                                $return = FC_Trade_Stock_hand_Query(
                                    $db_con, 
                                    $goods_id, 
                                    $sale_day, 
                                    "2",        //売上
                                    $client_id, 
                                    $ware_id,   //出荷倉庫
                                    "2",        //出庫
                                    $num, 
                                    $slip_no, 
                                    $sale_d_id[$i], 
                                    $_SESSION["staff_id"], 
                                    $shop_id
                                );
                            }
                            if($return === false){
                                return false;
                            }

                        }//手書伝票じゃない場合終わり

                        break;

                    case "13":
                    case "63":
                        //掛返品の場合
                        //現金返品の場合
                        //出荷倉庫から「売上」で「入庫」
                        $return = FC_Trade_Stock_hand_Query(
                            $db_con, 
                            $goods_id, 
                            $sale_day, 
                            "2",        //売上
                            $client_id, 
                            $ware_id,   //出荷倉庫
                            "1",        //入庫
                            $num, 
                            $slip_no, 
                            $sale_d_id[$i], 
                            $_SESSION["staff_id"], 
                            $shop_id
                        );

                        if($return === false){
                            return false;
                        }

                        //手書伝票しかないので、引当の処理はナシ

                        break;

                    case "14":
                    case "64":
                        //掛値引の場合
                        //現金値引の場合
/*
                        //受払に出庫品テーブルの商品を「売上」で「出庫」
                        $return = FC_Trade_Stock_hand_Query(
                            $db_con, 
                            $goods_id, 
                            $sale_day, 
                            "2", 
                            $client_id, 
                            $ware_id, 
                            "2", 
                            $num, 
                            $slip_no, 
                            $sale_d_id[$i], 
                            $_SESSION["staff_id"], 
                            $shop_id
                        );

                        if($return === false){
                            return false;
                        }

                        //手書伝票しかないので、引当の処理はナシ
*/
                        break;

                }//取引区分ごとの処理

            }//出庫品テーブル分のループ終わり

        }//売上データID分ループ終わり

    }//受払処理おわり



    //取引区分が「現金」の場合は自動で入金をおこす
    if($trade_id == "61" || $trade_id == "63" || $trade_id == "64"){
        //取引区分が「63：現金返品」または「64：現金値引」の場合はマイナスの入金
        if($trade_id == "63" || $trade_id == "64"){
            $pay_amount = ($net_amount + $tax_amount) * (-1);
        }else{
            $pay_amount = ($net_amount + $tax_amount);
        }

        //入金テーブルに「現金入金」
        $return = FC_Payin_Query($db_con, $sale_id, $client_id, $pay_amount, $sale_day, $shop_id);
        if($return === false){
            return false;
        }

    // 取引区分が「掛」（割賦じゃない）、かつ前受相殺額がある場合
    }elseif($trade_id != "15" && $advance_offset != null){
        //取引区分が「掛返品」または「掛値引」の場合はマイナスの入金
        if($trade_id == "13" || $trade_id == "14"){
            $advance_offset = $advance_offset * (-1);
        }
        //入金テーブルに「前受相殺」
        $return = FC_Payin_Query($db_con, $sale_id, $client_id, $pay_amount, $sale_day, $shop_id, $advance_offset, $claim_div);
    }

    //取引区分が「割賦売上」の場合は割賦売上テーブルに2回割賦でとりあえず登録
    if($trade_id == "15"){
        //分割回数
        $sql = "UPDATE t_sale_h SET total_split_num = 2 WHERE sale_id = $sale_id;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

        $claim_day_arr = explode("-", $claim_day);
        //分割テーブル
        $division_array = Division_Price($db_con, $client_id, ($net_amount + $tax_amount), $claim_day_arr[0], $claim_day_arr[1]);
        for($k=0;$k<2;$k++){
            $sql  = "INSERT INTO \n";
            $sql .= "    t_installment_sales \n";
            $sql .= "( \n";
            $sql .= "    installment_sales_id, \n";
            $sql .= "    sale_id, \n";
            $sql .= "    collect_day, \n";
            $sql .= "    collect_amount \n";
            $sql .= ") VALUES ( \n";
            $sql .= "    (SELECT COALESCE(MAX(installment_sales_id), 0)+1 FROM t_installment_sales), \n";
            $sql .= "    $sale_id, \n";
            $sql .= "    '".$division_array[1][$k]."', \n";
            $sql .= "    ".$division_array[0][$k]." \n";
            $sql .= ") \n";
            $sql .= ";";

            $result = Db_Query($db_con, $sql);
            if($result === false){
                return false;
            }
        }
    }else{
        //割賦売上以外は分割回数を初期化
        $sql = "UPDATE t_sale_h SET total_split_num = null WHERE sale_id = $sale_id;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
    }


    return true;

}



/**
 *
 * 在庫受払に登録するクエリを発行
 *
 * ■履歴
 * 1.0.0 (2006/08/18) kaji
 *   ・新規作成
 * 1.0.1 (2006/10/12) kaji
 *   ・受払に略称を残すように
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $goods_id   商品ID
 * @param       string      $sale_day   作業実施日（売上日）
 * @param       string      $work_div   作業区分
 * @param       int         $client_id  得意先ID
 * @param       int         $ware_id    倉庫ID
 * @param       string      $io_div     入出庫区分
 * @param       int         $num        移動数
 * @param       string      $slip_no    伝票番号
 * @param       int         $sale_d_id  売上データID
 * @param       int         $staff_id   スタッフID（作業者ID）
 * @param       int         $shop_id    ショップID
 *
 * @return      bool        成功：true
 *                          失敗：false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.1 (2006/10/12)
 *
 */
function FC_Trade_Stock_hand_Query($db_con, $goods_id, $sale_day, $work_div, $client_id, $ware_id, $io_div, $num, $slip_no, $sale_d_id, $staff_id, $shop_id)
{
    $sql  = "SELECT ";
    $sql .= "    t_sale_h.client_cname ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "    INNER JOIN t_sale_d ON t_sale_h.sale_id = t_sale_d.sale_id ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_d.sale_d_id = ".$sale_d_id." ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $client_cname = pg_fetch_result($result, 0, 0);     //略称
	$client_cname = addslashes($client_cname);

    $sql  = "INSERT INTO t_stock_hand ( ";
    $sql .= "    goods_id, ";
    $sql .= "    enter_day, ";
    $sql .= "    work_day, ";
    $sql .= "    work_div, ";
    if($client_id != null){
        $sql .= "    client_id, ";
        $sql .= "    client_cname, ";
    }
    $sql .= "    ware_id, ";
    $sql .= "    io_div, ";
    $sql .= "    num, ";
    $sql .= "    slip_no, ";
    $sql .= "    sale_d_id, ";
    $sql .= "    staff_id, ";
    $sql .= "    shop_id ";
    $sql .= ") VALUES ( ";
    $sql .= "    ".$goods_id.", ";
    $sql .= "    CURRENT_TIMESTAMP, ";
    $sql .= "    '$sale_day', ";
    $sql .= "    '$work_div', ";
    if($client_id != null){
        $sql .= "    ".$client_id.", ";
        $sql .= "    '".$client_cname."', ";
    }
    $sql .= "    ".$ware_id.", ";
    $sql .= "    '$io_div', ";
    $sql .= "    ".$num.", ";
    $sql .= "    '".$slip_no."', ";
    $sql .= "    ".$sale_d_id.", ";
    $sql .= "    ".$staff_id.", ";
    $sql .= "    ".$shop_id." ";
    $sql .= "); ";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}



/**
 *
 * 入金テーブルに登録するクエリを発行
 *
 * 変更履歴
 * 1.0.1 (2006-09-26) kaji
 *   ・担当者カラム（ac_staff_xx）から集金担当カラム（collect_staff_xx）に変更
 *
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $sale_id    売上ID
 * @param       int         $client_id  得意先ID
 * @param       int         $amount     入金額
 * @param       string      $sale_day   入金日（売上日）
 * @param       int         $shop_id    ショップID
 * @param       int         $advance_offset     前受相殺額合計（ない場合はnull）
 * @param       str         $claim_div          請求先区分（ない場合はnull）
 *
 * @return      bool        成功：true
 *                          失敗：false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/18)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/05/23      xx-xxx      kajioka-h   代行伝票の現金取引が可能になった
 *
 */
function FC_Payin_Query($db_con, $sale_id, $client_id, $amount, $sale_day, $shop_id, $advance_offset = null, $claim_div = null)
{
    //入金IDを取得
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $pay_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //入金番号取得判定
    if($_SESSION["group_kind"] == '2'){
        //直営

        //最大値の伝票番号取得
        $sql  = "SELECT ";
        $sql .= "    MAX(pay_no) ";
        $sql .= "FROM ";
        $sql .= "    t_payin_no_serial;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $pay_no = pg_fetch_result($result, 0, 0) + 1;
        $pay_no = str_pad($pay_no, 8, '0', STR_PAD_LEFT);   //入金番号

        //現在の最大値を更新
        $sql  = "INSERT INTO t_payin_no_serial VALUES('$pay_no');";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

    }else{ 
        //FC

        $sql  = "SELECT ";
        $sql .= "    MAX(pay_no) ";
        $sql .= "FROM ";
        $sql .= "    t_payin_h ";
        $sql .= "WHERE ";
        $sql .= "    shop_id = $shop_id ";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $pay_no = pg_fetch_result($result, 0, 0) + 1;
        $pay_no = str_pad($pay_no, 8, '0', STR_PAD_LEFT);   //入金番号
    }


    //代行の情報を取得
    $sql  = "SELECT \n";
    $sql .= "    contract_div, \n";
    $sql .= "    act_id, \n";
    $sql .= "    act_cd1, \n";
    $sql .= "    act_cd2, \n";
    $sql .= "    act_name1, \n";
    $sql .= "    act_cname \n";
    $sql .= "FROM \n";
    $sql .= "    t_sale_h \n";
    $sql .= "WHERE \n";
    $sql .= "    sale_id = $sale_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    $contract_div = pg_fetch_result($result, 0, "contract_div");
    if($contract_div != "1"){
        $act_id     = pg_fetch_result($result, 0, "act_id");
        $act_cd1    = pg_fetch_result($result, 0, "act_cd1");
        $act_cd2    = pg_fetch_result($result, 0, "act_cd2");
        $act_name   = pg_fetch_result($result, 0, "act_name1");
        $act_cname  = pg_fetch_result($result, 0, "act_cname");
    }


    $sql  = "INSERT INTO ";
    $sql .= "   t_payin_h ";
    $sql .= "( ";
    $sql .= "    pay_id, ";
    $sql .= "    pay_no, ";
    $sql .= "    pay_day, ";
    $sql .= "    client_id, ";
    $sql .= "    client_cd1, ";
    $sql .= "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_cname, ";
/*
    $sql .= "    c_bank_cd, ";
    $sql .= "    c_bank_name, ";
    $sql .= "    c_b_bank_cd, ";
    $sql .= "    c_b_bank_name, ";
    $sql .= "    c_deposit_kind, ";
    $sql .= "    c_account_no, ";
*/
    $sql .= "    claim_div, ";
    //$sql .= "    bill_id, ";
    //$sql .= "    claim_cd1, ";
    //$sql .= "    claim_cd2, ";
    //$sql .= "    claim_cname, ";
    $sql .= "    input_day, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    //2006-09-26 kaji 担当者カラムから集金担当カラムに変更
    //$sql .= "    ac_staff_id, ";      //巡回担当者(メイン)のID
    //$sql .= "    ac_staff_name, ";    //巡回担当者(メイン)の名前
    $sql .= "    collect_staff_id, ";      //巡回担当者(メイン)のID
    $sql .= "    collect_staff_name, ";    //巡回担当者(メイン)の名前
    $sql .= "    act_client_id, ";
    $sql .= "    act_client_cd1, ";
    $sql .= "    act_client_cd2, ";
    $sql .= "    act_client_name, ";
    $sql .= "    act_client_cname, ";
    $sql .= "    sale_id, ";
    $sql .= "    shop_id ";
    $sql .= ") VALUES ( ";
    $sql .= "    $pay_id, ";
    $sql .= "    '$pay_no', ";
    $sql .= "    '$sale_day', ";
    $sql .= "    $client_id, ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
/*
    $sql .= "   ( ";
    $sql .= "       SELECT t_bank.bank_cd FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_bank.bank_name FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       LEFT JOIN t_bank ON t_b_bank.bank_id = t_bank.bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_b_bank.b_bank_cd FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_b_bank.b_bank_name FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       LEFT JOIN t_b_bank ON t_account.b_bank_id = t_b_bank.b_bank_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_account.deposit_kind FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
    $sql .= "   ( ";
    $sql .= "       SELECT t_account.account_no FROM t_client ";
    $sql .= "       LEFT JOIN t_account ON t_client.account_id = t_account.account_id ";
    $sql .= "       WHERE t_client.client_id = $client_id ";
    $sql .= "   ), ";
*/
    //$sql .= "    claim_div, ";
    //$sql .= "    bill_id, ";
    //$sql .= "    claim_cd1, ";
    //$sql .= "    claim_cd2, ";
    //$sql .= "    claim_cname, ";
    // 前受相殺時（2007-06-12 fukuda）
    if ($advance_offset !== null){
        $sql .= "   '$claim_div', \n";
/*
        $sql .= "   (SELECT t_client.client_cd1 FROM t_claim \n";
        $sql .= "       INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       WHERE t_claim.client_id = $client_id AND t_claim.claim_div = '$claim_div'), \n";
        $sql .= "   (SELECT t_client.client_cd2 FROM t_claim \n";
        $sql .= "       INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       WHERE t_claim.client_id = $client_id AND t_claim.claim_div = '$claim_div'), \n";
        $sql .= "   (SELECT t_client.client_cname FROM t_claim \n";
        $sql .= "       INNER JOIN t_client ON t_claim.claim_id = t_client.client_id \n";
        $sql .= "       WHERE t_claim.client_id = $client_id AND t_claim.claim_div = '$claim_div'), \n";
*/
    //それ以外は請求先区分だけ固定で登録
    }else{
        $sql .= "    '1', ";
    }
    $sql .= "    CURRENT_TIMESTAMP, ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    //代行伝票の場合、代行の情報を登録
    if($contract_div != "1"){
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    $act_id, ";
        $sql .= "    '$act_cd1', ";
        $sql .= "    '$act_cd2', ";
        $sql .= "    '".addslashes($act_name)."', ";
        $sql .= "    '".addslashes($act_cname)."', ";
    }else{
        $sql .= "    (SELECT staff_id FROM t_sale_staff WHERE sale_id = $sale_id AND staff_div = '0'), ";
        $sql .= "    (SELECT staff_name FROM t_sale_staff WHERE sale_id = $sale_id AND staff_div = '0'), ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
        $sql .= "    NULL, ";
    }
    $sql .= "    ".$sale_id.", ";
    $sql .= "    $shop_id ";
    $sql .= ");";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }


    //入金データIDを取得
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $pay_d_id  = $microtime[1].substr("$microtime[0]", 2, 5);

    $sql  = "INSERT INTO ";
    $sql .= "    t_payin_d ";
    $sql .= "( ";
    $sql .= "    pay_d_id, ";
    $sql .= "    pay_id, ";
    $sql .= "    trade_id, ";
    $sql .= "    amount ";
    //$sql .= "    bank_id, ";
    //$sql .= "    bank_cd, ";
    //$sql .= "    bank_name, ";
    //$sql .= "    payable_day, ";
    //$sql .= "    payable_no, ";
    //$sql .= "    note ";
    $sql .= ") VALUES ( ";
    $sql .= "    $pay_d_id, ";
    $sql .= "    $pay_id, ";
    if ($advance_offset === null){
        $sql .= "    '39', ";
        $sql .= "    $amount ";
    }else{
        $sql .= "    '40', ";
        $sql .= "    $advance_offset ";
    }
    $sql .= ");";
//echo "$sql<br>";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}



/**
 *
 * 受託先が委託先へ代行料を売上（受託先用）
 *
 * 受注IDから代行料を計算し、売上テーブルへ登録
 * ・受注ヘッダの売上金額と、代行料区分等から代行料を計算
 * ・まるめ区分、端数、消費税率は自社（受託先）の設定を参照する
 *
 * 変更履歴
 *    1.0.0 (2006//) (kaji)
 *      ・新規作成
 *    1.0.1 (2006/10/18) (suzuki-t)
 *      ・請求日を直営の翌月の締日に変更
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $aord_id    受注ID
 * @param       int         $shop_id    得意先ID（委託先）（東陽）
 * @param       int         $act_id     ショップID（委託先）（自分のID）
 *
 * @return      bool        成功：登録したデータの売上データID
 *                          失敗：false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2006/08/18)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-029      kajioka-h   まるめ区分取得前にまるめていたのを修正
 *                  03-034      kajioka-h   売上率が空欄の場合はnullを入れる
 *  2006/11/16      -           suzuki-t    商品名(正式)取得SQL変更
 *  2006/12/08      03-088      suzuki-t    売上担当者登録
 *  2007/03/30      要件26-2    kajioka-h   売上の商品名を「納入先略称＋半角スペース＋業務代行料」に
 *  2007/05/03      他79,152    kajioka-h   代行料の仕様変更
 *  2007/05/30      xx-xxx      kajioka-h   Get_Dataの引数を5に変更
 *  2007/06/18      その他14    kajioka-h   売上データの前受相殺フラグを登録（特に使わないけど念のため）
 *  2009/12/24                  aoyama-n    税率をTaxRateクラスから取得
 *
 */
function FC_Act_Sale_Query($db_con, $aord_id, $shop_id, $act_id)
{

    /****************************/
    //外部変数取得
    /****************************/
    $staff_id    = $_SESSION["staff_id"];     //ログイン者ID
    $staff_name  = $_SESSION["staff_name"];   //ログイン者名


    //契約区分が2（オンライン代行）の場合、受託先から委託先へ自動で売上を起こす

    //委託先のまるめ区分、端数区分、請求日（支払日）を取得
    //$sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE client_id = ".$shop_id.";";
    $sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE act_flg = true AND shop_id = ".$act_id.";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $coax = pg_fetch_result($result, 0, "coax");    //まるめ区分
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");    //端数区分
    //$pay_m = pg_fetch_result($result, 0, "pay_m");  //請求日（月）
    //$pay_d = pg_fetch_result($result, 0, "pay_d");  //請求日（日）

/*
    //受注ヘッダから代行依頼料（％）、売上金額（合計）を取得
    $sql  = "SELECT act_request_rate, net_amount FROM t_aorder_h WHERE aord_id = $aord_id; ";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_request_rate = pg_fetch_result($result, 0, "act_request_rate");    //代行依頼料（％）
    $net_amount = pg_fetch_result($result, 0, "net_amount");    //売上金額
*/

    //受注ヘッダから以下の項目を取得
    $sql  = "SELECT \n";
    $sql .= "    net_amount, \n";           //売上金額（税抜）
    $sql .= "    trust_cost_amount, \n";    //原価金額（受託先）
    $sql .= "    trust_net_amount, \n";     //売上金額（受託先）
    $sql .= "    trust_tax_amount, \n";     //消費税額（受託先）
    $sql .= "    act_div, \n";              //代行料区分
    $sql .= "    act_request_price, \n";    //代行料（固定）
    $sql .= "    act_request_rate, \n";     //代行料（％）
    $sql .= "    hand_plan_flg \n";         //予定手書フラグ
    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "WHERE \n";
    $sql .= "    aord_id = $aord_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    $net_amount = pg_fetch_result($result, 0, "net_amount");            //売上金額（税抜）
    $cost_amount = pg_fetch_result($result, 0, "trust_cost_amount");    //原価金額（受託先）
    $act_div = pg_fetch_result($result, 0, "act_div");                  //代行料区分
    $act_request_price = pg_fetch_result($result, 0, "act_request_price");  //代行料（固定）
    $act_request_rate = pg_fetch_result($result, 0, "act_request_rate");    //代行料（％）
    $hand_plan_flg = (pg_fetch_result($result, 0, "hand_plan_flg") == "t") ? "true" : "false";  //予定手書フラグ

    //代行料は発生しない場合
    if($act_div == "1"){
        //return true;
        return false;   //受払を紐付けられないので、「発生しない」はなし

    //代行料（固定）の場合
    }elseif($act_div == "2"){
        $act_amount = $act_request_price;

    //代行料（％）の場合
    }elseif($act_div == "3"){
    	$act_amount = bcmul($net_amount, bcdiv($act_request_rate, 100, 2), 2);
        $act_amount = Coax_Col($coax, $act_amount);                         //代行料
    }
/*
    }else{
        $act_amount = pg_fetch_result($result, 0, "trust_net_amount");      //売上金額（受託先）
        $act_tax    = pg_fetch_result($result, 0, "trust_tax_amount");      //消費税額（受託先）

        $cost_amount = pg_fetch_result($result, 0, "trust_cost_amount");    //原価金額（受託先）
    }
*/

    //代行料の商品ID、商品名、商品名（略称）、単位、課税区分を取得
    $sql  = "SELECT goods_id, goods_name, goods_cname, unit, tax_div FROM t_goods WHERE goods_cd = '09999901';";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_goods_id = pg_fetch_result($result, 0, "goods_id");        //代行料の商品ID
    $act_goods_name = pg_fetch_result($result, 0, "goods_name");    //代行料の商品名
    $act_goods_cname = pg_fetch_result($result, 0, "goods_cname");  //代行料の商品名（略称）
    $act_unit = pg_fetch_result($result, 0, "unit");                //代行料の単位
    $act_tax_div = pg_fetch_result($result, 0, "tax_div");          //代行料の課税区分

    #2009-12-24 aoyama-n
    //受注ヘッダの売上日（配送日）を取得
    $sql  = "SELECT ord_time FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $sale_day  = pg_fetch_result($result, 0, "ord_time");      //売上日

    #2009-12-24 aoyama-n
    //請求締がされている場合は締めた日の翌日を請求日にする
    $sale_day_arr = explode("-", $sale_day);

    #2013-05-23 hashimoto-y
    #請求先区分(claim_div)の条件不足
    #オンライン代行の場合、請求先区分「1」固定
    #if(!Check_Bill_Close_Day($db_con, $shop_id, $sale_day_arr[0], $sale_day_arr[1], $sale_day_arr[2])){
    if(!Check_Bill_Close_Day_Claim($db_con, $shop_id, "1" ,$sale_day_arr[0], $sale_day_arr[1], $sale_day_arr[2])){
        $sql  = "SELECT\n";
        $sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
        $sql .= "FROM\n";
        $sql .= "   t_bill_d \n";
        $sql .= "WHERE \n";
        $sql .= "   t_bill_d.client_id = $client_id";
        $sql .= ";";

        $next_close_day = pg_fetch_result($result, 0, 0);       //請求日
    }else{
        $next_close_day = $sale_day;                            //請求日
    }

    //受注ヘッダから得意先（納入先）名（略称）を取得
    $sql  = "SELECT client_cname FROM t_aorder_h WHERE aord_id = $aord_id; ";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $client_cname = pg_fetch_result($result, 0, "client_cname");    //得意先名（納入先）名（略称）

    //受託先（自分）の消費税率を取得
    #2009-12-24 aoyama-n
    #$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ".$act_id.";";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$tax_rate = pg_fetch_result($result, 0, "tax_rate_n");  //消費税率

    #2009-12-24 aoyama-n
    //オンライン代行の受託先の処理では自社の端数・まるめ区分・課税区分を使用する
    //税率クラス　インスタンス生成
    $tax_rate_obj = new TaxRate($act_id);
    $tax_rate_obj->setTaxRateDay($next_close_day);
    $tax_rate = $tax_rate_obj->getClientTaxRate($act_id);

    //代行料の消費税を計算
    $array_amount = Total_Amount(array($act_amount), array($act_tax_div), $coax, $tax_franct, $tax_rate, $act_id, $db_con);
    //$act_amount = $array_amount[0];     //代行料
    $act_tax = $array_amount[1];        //消費税額

    //自動で起こす代行料を登録する売上ヘッダに使う売上ID生成
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_sale_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //同じく、売上番号取得
    $sql  = "SELECT ";
    $sql .= "    MAX(ord_no) ";
    $sql .= "FROM ";
    $sql .= "    t_aorder_no_serial_fc ";
    $sql .= "WHERE ";
    $sql .= "    shop_id = ".$act_id." ";   //直営以外しか代行料で売上しないので、Rank_Sql使ってません
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_sale_no = pg_fetch_result($result, 0, 0) + 1;
    $act_sale_no = str_pad($act_sale_no, 8, '0', STR_PAD_LEFT);  //売上番号

    //現在の最大値を更新
    $sql  = "INSERT INTO t_aorder_no_serial_fc (ord_no,shop_id)VALUES('$act_sale_no',$act_id);";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

/*
    //受託先が代行に要した原価を取得
    //$sql  = "SELECT SUM(trust_trade_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
    //受託先が代行に要した原価金額（受託先）を取得
    $sql  = "SELECT SUM(trust_cost_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $cost_amount = pg_fetch_result($result, 0, 0);      //受託先原価
*/

	//受注の仕入金額の合計値取得
    //$sql  = "SELECT SUM(buy_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
	//受注の仕入金額（受託先）の合計値取得
    $sql  = "SELECT SUM(trust_buy_amount) FROM t_aorder_d WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $buy_amount = pg_fetch_result($result, 0, 0);      //在庫金額の合計

    //受託先の巡回担当者を取得
    $sql  = "SELECT staff_div, staff_id, sale_rate, staff_name,course_id FROM t_aorder_staff WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $staff_count = pg_num_rows($result);
    for($i=0;$i<$staff_count;$i++){
        $array_staff[$i]["staff_div"]  = pg_fetch_result($result, $i, "staff_div");
        $array_staff[$i]["staff_id"]   = pg_fetch_result($result, $i, "staff_id");
        $array_staff[$i]["sale_rate"]  = pg_fetch_result($result, $i, "sale_rate");
        $array_staff[$i]["staff_name"] = pg_fetch_result($result, $i, "staff_name");
		$array_staff[$i]["staff_name"] = addslashes($array_staff[$i]["staff_name"]);
        $array_staff[$i]["course_id"]  = pg_fetch_result($result, $i, "course_id");
    }

    //受注ヘッダの売上日（配送日）を取得
    #2009-12-24 aoyama-n
    #$sql  = "SELECT ord_time FROM t_aorder_h WHERE aord_id = $aord_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$sale_day  = pg_fetch_result($result, 0, "ord_time");      //売上日

/*
	//直営の締日を取得
    $sql  = "SELECT close_day FROM t_client WHERE client_id = $shop_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $close_day = pg_fetch_result($result, 0, "close_day");   //締日

	//月末判定
	if($close_day == 29){
		//来月の月末が締日として計算
		$max_day = date("t",mktime(0, 0, 0,date("n")+1,1,date("Y")));
		$str = mktime(0, 0, 0,date("n")+1,$max_day,date("Y"));
	}else{
		//来月の締日を計算
		$str = mktime(0, 0, 0,date("n")+1,$close_day,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day = date("d",$str);
	//請求日
	$next_close_day = $year."-".$month."-".$day;
*/

    //請求締がされている場合は締めた日の翌日を請求日にする
    #2009-12-24 aoyama-n
    #$sale_day_arr = explode("-", $sale_day);

    #if(!Check_Bill_Close_Day($db_con, $shop_id, $sale_day_arr[0], $sale_day_arr[1], $sale_day_arr[2])){
        #$sql  = "SELECT\n";
        #$sql .= "   COALESCE(MAX(bill_close_day_this), '".START_DAY."') \n";
        #$sql .= "FROM\n";
        #$sql .= "   t_bill_d \n";
        #$sql .= "WHERE \n";
        #$sql .= "   t_bill_d.client_id = $client_id";
        #$sql .= ";";

        #$next_close_day = pg_fetch_result($result, 0, 0);       //請求日
    #}else{
        #$next_close_day = $sale_day;                            //請求日
    #}

    //出荷倉庫、備考、訂正理由取得
    $sql = "SELECT ware_id, ware_name, note, reason_cor, round_form FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $ware_id    = pg_fetch_result($result, 0, "ware_id");   //出荷倉庫ID
    $ware_name  = pg_fetch_result($result, 0, "ware_name"); //出荷倉庫名
    $note       = pg_fetch_result($result, 0, "note");      //備考
    $reason_cor = pg_fetch_result($result, 0, "reason_cor");    //訂正理由
    $round_form = pg_fetch_result($result, 0, "round_form");    //巡回形式

    //売上ヘッダ登録SQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_sale_h ";
    $sql .= "( ";
    $sql .= "    sale_id, ";
    $sql .= "    sale_no, ";
    $sql .= "    aord_id, ";
    $sql .= "    sale_day, ";
    $sql .= "    claim_day, ";
    $sql .= "    trade_id, ";
    $sql .= "    client_id, ";
    $sql .= "    c_shop_name, ";
    $sql .= "    c_shop_name2, ";
    $sql .= "    client_cd1, ";
    $sql .= "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_name2, ";
    $sql .= "    client_cname, ";
    $sql .= "    c_post_no1, ";
    $sql .= "    c_post_no2, ";
    $sql .= "    c_address1, ";
    $sql .= "    c_address2, ";
    $sql .= "    c_address3, ";
    $sql .= "    claim_id, ";
    $sql .= "    claim_div, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    $sql .= "    cost_amount, ";
    $sql .= "    net_amount, ";
    $sql .= "    tax_amount, ";
    $sql .= "    shop_id, ";
    $sql .= "    act_request_flg, ";
    $sql .= "    contract_div, ";
    $sql .= "    slip_out, ";
    $sql .= "    ware_id, ";
    $sql .= "    ware_name, ";
    $sql .= "    note, ";
    $sql .= "    reason_cor, ";
    $sql .= "    round_form, ";
	$sql .= "    c_staff_id, ";
    $sql .= "    c_staff_name, ";
    $sql .= "    act_div, ";
    $sql .= "    act_request_price, ";
    $sql .= "    act_request_rate, ";
    $sql .= "    hand_plan_flg ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_sale_id, ";
    $sql .= "    '$act_sale_no', ";
    $sql .= "    $aord_id, ";
    $sql .= "    '$sale_day', ";
    $sql .= "    '$next_close_day', ";
    $sql .= "    '11', ";
    $sql .= "    $shop_id, ";
    $sql .= "    (SELECT shop_name FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT shop_name2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT post_no1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT post_no2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT address1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT address2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT address3 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT claim_id FROM t_claim WHERE client_id = $shop_id AND claim_div = '1'), ";
    $sql .= "    '1', ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    $cost_amount, ";
    $sql .= "    $act_amount, ";
    $sql .= "    $act_tax, ";
    $sql .= "    $act_id, ";
    $sql .= "    't',";
    $sql .= "    '2',";
    $sql .= "    (SELECT slip_out FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    $ware_id,";
    $sql .= "    '".addslashes($ware_name)."', ";
    $sql .= "    '".addslashes($note)."', ";
    $sql .= "    '".addslashes($reason_cor)."', ";
    $sql .= "    '".addslashes($round_form)."', ";
	$sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    '$act_div', ";
    $sql .= ($act_request_price != null) ? "    $act_request_price, " : "    null, ";
    $sql .= "    '$act_request_rate', ";
    $sql .= "    $hand_plan_flg ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //代行料売上の売上データID生成
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_sale_d_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //代行料指定判定
    if($act_goods_id != NULL){
        //商品分類・正式名称取得
        $sql  = "SELECT ";
        $sql .= "    t_g_product.g_product_name,";
        $sql .= "    t_g_product.g_product_name || '　' || t_goods.goods_name "; 
        $sql .= "FROM ";
        $sql .= "    t_g_product ";
        $sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
        $sql .= "WHERE ";
        $sql .= "    t_goods.goods_id = $act_goods_id;";
        $result = Db_Query($db_con, $sql);
        $pro_data = NULL;
        $pro_data = Get_Data($result,5);
    }

    //売上データ登録SQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_sale_d ";
    $sql .= "( ";
    $sql .= "    sale_d_id, ";
    $sql .= "    sale_id, ";
    $sql .= "    line, ";
    $sql .= "    sale_div_cd, ";
    $sql .= "    goods_print_flg, ";
    $sql .= "    goods_id, ";
    $sql .= "    goods_cd, ";
    $sql .= "    goods_name, ";
    $sql .= "    num, ";
    $sql .= "    unit, ";
    $sql .= "    tax_div, ";
    $sql .= "    buy_price, ";
    $sql .= "    cost_price, ";
    $sql .= "    sale_price, ";
    $sql .= "    buy_amount, ";
    $sql .= "    cost_amount, ";
    $sql .= "    sale_amount, ";
    $sql .= "    g_product_name, ";
    $sql .= "    official_goods_name, ";
    $sql .= "    advance_flg ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_sale_d_id, ";
    $sql .= "    $act_sale_id, ";
    $sql .= "    1, ";
    $sql .= "    '01', ";       //販売区分はリピート
    $sql .= "    true, ";
    $sql .= "    $act_goods_id, ";
    $sql .= "    '09999901', ";
    //$sql .= "    '".addslashes($act_goods_name)."', ";
    $sql .= "    '".addslashes($client_cname." ".$act_goods_name)."', ";
    $sql .= "    1, ";
    $sql .= "    '$act_unit', ";
    $sql .= "    '$act_tax_div', ";
    $sql .= "    $buy_amount, ";
    $sql .= "    $cost_amount, ";
    $sql .= "    $act_amount, ";
    $sql .= "    $buy_amount, ";
    $sql .= "    $cost_amount, ";
    $sql .= "    $act_amount, ";
    $sql .= "    '".$pro_data[0][0]."', ";
    //$sql .= "    '".$pro_data[0][1]."' ";
    $sql .= "    '".addslashes($client_cname." ".$act_goods_name)."', ";
    $sql .= "    '1' ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //巡回担当者登録SQL
    for($i=0;$i<$staff_count;$i++){
        $sql  = "INSERT INTO ";
        $sql .= "    t_sale_staff ";
        $sql .= "( ";
        $sql .= "    sale_id, ";
        $sql .= "    staff_div, ";
        $sql .= "    staff_id, ";
        $sql .= "    sale_rate, ";
        $sql .= "    staff_name, ";
        $sql .= "    course_id ";
        $sql .= ") VALUES ( ";
        $sql .= "    ".$act_sale_id.", ";
        $sql .= "    '".$array_staff[$i]["staff_div"]."', ";
        $sql .= "    ".$array_staff[$i]["staff_id"].", ";
        $sql .= ($array_staff[$i]["sale_rate"] == null) ? "    null, " : "    '".$array_staff[$i]["sale_rate"]."', ";
        $sql .= "    '".$array_staff[$i]["staff_name"]."',";
        //コース指定判定
        if($array_staff[$i]["course_id"] != NULL){
            $sql .= "    ".$array_staff[$i]["course_id"];
        }else{
            $sql .= "    NULL";
        }
        $sql .= ");";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

    }

    //戻り値に売上データID
    return $act_sale_d_id;

}



/**
 *
 * 委託先が受託先へ代行料を仕入（東陽（委託先）用）
 *（仕入は委託先ではなく本部に起こします）
 *
 * 売上IDから代行料を計算し、仕入テーブルへ登録
 * 
 * ■履歴
 * 1.0.0 (2006/08/18) kaji
 *   ・新規作成
 * 1.0.1 (2006/10/12) kaji
 *   ・仕入ヘッダに略称を残すように
 *   ・代行料をまるめる処理追加
 * 1.0.2 (2006/10/18) suzuki-t
 *   ・請求日を代行先の翌月の締日に変更
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $sale_id    売上ID
 * @param       int         $shop_id    仕入先ID（受託先）
 * @param       int         $act_id     ショップID（委託先）（東陽）（自分のID）
 *                                      （仕入は委託先ではなく本部に起こします）
 *
 * @return      bool        成功：true
 *                          失敗：false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.2 (2006/10/18)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-050      kajioka-h   備考、訂正理由、商品出荷倉庫、販売区分を入れる
 *  2006/12/08      03-087      suzuki      仕入担当者登録
 *  2007/02/21      要望6-1     kajioka-h   手書伝票で代行先を登録できるようにする対応
 *  2007/03/16      03-001      kajioka-h   代行料の計算に、受託先ではなく自分の課税区分を使っていたのを修正
 *                  xx-xxx      kajioka-h   入荷倉庫を基本出荷倉庫からログインユーザの拠点倉庫に変更
 *  2007/03/30      要件26-2    kajioka-h   仕入の商品名を「納入先略称＋半角スペース＋業務代行料」に
 *  2007/04/02      要件6-2     kajioka-h   代行伝票の納入先への売上の取引区分と、委託先への代行料仕入を以下のように変更
 *                                               売上      仕入
 *                                              掛売上 → 掛仕入
 *                                              掛返品 → 掛返品
 *                                              掛値引 → 掛値引
 *  2007/04/03      その他25    kajioka-h   代行料の仕入は委託先（東陽）ではなく、本部に変更
 *                                          ・本部の消費税率で代行料を計算
 *                                          ・入荷倉庫を本部の基本倉庫に変更
 *                                          ・仕入ヘッダのshop_idを本部のIDに変更
 *                                          ・仕入ヘッダにbuy_div=2を登録
 *  2007/04/26      他79,152    kajioka-h   代行料の仕様変更
 *  2007/05/23      xx-xxx      kajioka-h   現金取引の代行が可能になったため、仕入の取区処理を変更（売上が現金でも、仕入は掛）
 *  2009/12/24                  aoyama-n    税率をTaxRateクラスから取得
 *
 */
function FC_Act_Buy_Query($db_con, $sale_id, $shop_id, $act_id)
{

    //契約区分が2か3（オンライン代行、オフライン代行）の場合は、委託先から受託先へ自動で仕入を起こす

    //本部のclient_idを取得
    $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $head_id = pg_fetch_result($result, 0, "client_id");    //本部のclient_id

    //代行依頼料を取得
    $sql = "SELECT hand_slip_flg FROM t_sale_h WHERE sale_id = $sale_id ;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    //契約からきた場合は受注ヘッダから代行料区分、代行料（固定）、代行料（％）を取得
    if(pg_fetch_result($result, 0, 0) == "f"){
        $sql  = "SELECT ";
        $sql .= "    t_aorder_h.act_div, \n";              //代行料区分
        $sql .= "    t_aorder_h.act_request_price, \n";    //代行料（固定）
        #2009-12-24 aoyama-n
        #$sql .= "    t_aorder_h.act_request_rate \n";      //代行料（％）
        $sql .= "    t_aorder_h.act_request_rate, \n";      //代行料（％）
        $sql .= "    t_aorder_h.act_id \n";                 //代行者ID
        $sql .= "FROM ";
        $sql .= "    t_aorder_h ";
        $sql .= "    INNER JOIN t_sale_h ON t_aorder_h.aord_id = t_sale_h.aord_id ";
        $sql .= "WHERE ";
        $sql .= "    t_sale_h.sale_id = $sale_id ";
        $sql .= ";";
    //手書伝票の場合は売上ヘッダから代行料区分、代行料（固定）、代行料（％）を取得
    }else{
        $sql  = "SELECT \n";
        $sql .= "    act_div, \n";              //代行料区分
        $sql .= "    act_request_price, \n";    //代行料（固定）
        #2009-12-24 aoyama-n
        #$sql .= "    act_request_rate \n";      //代行料（％）
        $sql .= "    act_request_rate, \n";      //代行料（％）
        $sql .= "    act_id \n";                 //代行者ID
        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";
        $sql .= "WHERE \n";
        $sql .= "    sale_id = $sale_id \n";
        $sql .= ";";
    }

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_div            = pg_fetch_result($result, 0, "act_div");               //代行料区分
    $act_request_price  = pg_fetch_result($result, 0, "act_request_price");     //代行料（固定）
    $act_request_rate   = pg_fetch_result($result, 0, "act_request_rate");      //代行料（％）
    #2009-12-24 aoyama-n
    $trustee_id         = pg_fetch_result($result, 0, "act_id");                //代行者ID

	//受託先のまるめ区分、端数区分、請求日（支払日）を取得
    $sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE client_id = ".$shop_id.";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $coax = pg_fetch_result($result, 0, "coax");    //まるめ区分
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");    //端数区分
    //$pay_m = pg_fetch_result($result, 0, "pay_m");  //請求日（月）
    //$pay_d = pg_fetch_result($result, 0, "pay_d");  //請求日（日）

    //売上ヘッダから売上金額（合計）、得意先名（納入先）名（略称）を取得
    $sql  = "SELECT net_amount, client_cname, trade_id FROM t_sale_h WHERE sale_id = $sale_id; ";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $net_amount = pg_fetch_result($result, 0, "net_amount");    //売上金額
    $client_cname = pg_fetch_result($result, 0, "client_cname");    //得意先（納入先）名（略称）
    $trade_id = pg_fetch_result($result, 0, "trade_id");        //売上の取引区分
    //売上の取区が「掛返品」「現金返品」の場合、仕入の取区は「掛返品」
    if($trade_id == "13" || $trade_id == "63"){
        $buy_trade_id = "23";
    //売上の取区が「掛値引」「現金値引」の場合、仕入の取区は「掛値引」
    }elseif($trade_id == "14" || $trade_id == "64"){
        $buy_trade_id = "24";
    //それ以外は、仕入の取区は「掛仕入」
    }else{
        $buy_trade_id = "21";
    }

    //$act_amount = $net_amount * $act_request_rate / 100;    //代行料（仮）
	//2006-10-13 suzuki
	//$act_amount = bcmul($net_amount,bcdiv($act_request_rate,100,2),2);  //代行料（仮）
	//1.0.1 (2006/10/12) 代行料をまるめ処理
    //$act_amount = Coax_Col($coax, $act_amount);     //代行料（まるめ後）

    //代行料の計算
    //代行料は発生しない場合
    if($act_div == "1"){
        return true;

    //代行料（固定）の場合
    }elseif($act_div == "2"){
        $act_amount = $act_request_price;               //代行料

    //代行料（％）の場合
    }elseif($act_div == "3"){
    	$act_amount = bcmul($net_amount, bcdiv($act_request_rate, 100, 2), 2);
        $act_amount = Coax_Col($coax, $act_amount);     //代行料
    }

    //代行料の商品ID、商品名、単位、課税区分を取得
    $sql  = "SELECT goods_id, goods_name, unit, tax_div FROM t_goods WHERE goods_cd = '09999901';";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_goods_id = pg_fetch_result($result, 0, "goods_id");        //代行料の商品ID
    $act_goods_name = pg_fetch_result($result, 0, "goods_name");    //代行料の商品名
    //$act_goods_name = addslashes($act_goods_name);
    $act_unit = pg_fetch_result($result, 0, "unit");                //代行料の単位
    $act_tax_div = pg_fetch_result($result, 0, "tax_div");          //代行料の課税区分

	//売上ヘッダの売上日（配送日）を取得
    #2009-12-24 aoyama-n
    $sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $buy_day     = pg_fetch_result($result, 0, "sale_day");     //売上日

    #2009-12-24 aoyama-n
    $buy_day_arr = explode("-", $buy_day);

    //仕入締がされている場合は締めた日の翌日を仕入日にする
    //if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2])){
    if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2], $head_id)){
        $sql  = "SELECT \n";
        $sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        $sql .= "FROM \n";
        $sql .= "    t_schedule_payment \n";
        $sql .= "WHERE \n";
        $sql .= "    client_id = $shop_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $next_close_day = pg_fetch_result($result, 0, 0);       //仕入日
    }else{
        $next_close_day = $buy_day;                             //仕入日
    }

    //委託先（自分）の消費税率を取得
    //$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ".$act_id.";";
    //本部の消費税率を取得
    #2009-12-24 aoyama-n
    #$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ".$head_id.";";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$tax_rate = pg_fetch_result($result, 0, "tax_rate_n");  //消費税率

    #2009-12-24 aoyama-n
    //税率クラス　インスタンス生成
    $tax_rate_obj = new TaxRate($head_id);
    $tax_rate_obj->setTaxRateDay($next_close_day);
    $tax_rate = $tax_rate_obj->getClientTaxRate($trustee_id);

    //代行料の消費税を計算
    $array_amount = Total_Amount(array($act_amount), array($act_tax_div), $coax, $tax_franct, $tax_rate, $shop_id, $db_con);
    $act_amount = $array_amount[0];     //代行料
    $act_tax = $array_amount[1];        //消費税額

    //自動で起こす代行料を登録する仕入ヘッダに使う仕入ID生成
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_buy_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //同じく、仕入番号取得
    $sql  = "SELECT ";
    $sql .= "    MAX(buy_no) ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
    $sql .= "WHERE ";
    //$sql .= "    shop_id IN (".Rank_Sql().") ";     //直営しか代行料で仕入しないので、Rank_Sqlのみ
    $sql .= "    shop_id = $head_id ";  //本部の仕入番号MAXを取得
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $act_buy_no = pg_fetch_result($result, 0, 0) + 1;
    $act_buy_no = str_pad($act_buy_no, 8, '0', STR_PAD_LEFT);   //仕入番号

	//売上ヘッダの売上日（配送日）を取得
    #2009-12-24 aoyama-n
    #消費税取得前で処理する
    #$sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$buy_day     = pg_fetch_result($result, 0, "sale_day");     //売上日

/*
	//代行先の締日を取得
    $sql  = "SELECT close_day FROM t_client WHERE client_id = $shop_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $close_day = pg_fetch_result($result, 0, "close_day");   //締日
	//月末判定
	if($close_day == 29){
		//来月の月末が締日として計算
		$max_day = date("t",mktime(0, 0, 0,date("n")+1,1,date("Y")));
		$str = mktime(0, 0, 0,date("n")+1,$max_day,date("Y"));
	}else{
		//来月の締日を計算
		$str = mktime(0, 0, 0,date("n")+1,$close_day,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day = date("d",$str);
	//請求日
	$next_close_day = $year."-".$month."-".$day;
*/
    #2009-12-24 aoyama-n
    #$buy_day_arr = explode("-", $buy_day);

    //仕入締がされている場合は締めた日の翌日を仕入日にする
    //if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2])){
    #2009-12-24 aoyama-n
    #if(!Check_Payment_Close_Day($db_con, $shop_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2], $head_id)){
        #$sql  = "SELECT \n";
        #$sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        #$sql .= "FROM \n";
        #$sql .= "    t_schedule_payment \n";
        #$sql .= "WHERE \n";
        #$sql .= "    client_id = $shop_id \n";
        #$sql .= ";";
        #$result = Db_Query($db_con, $sql);

        #$next_close_day = pg_fetch_result($result, 0, 0);       //仕入日
    #}else{
        #$next_close_day = $buy_day;                             //仕入日
    #}

    //入荷倉庫抽出
    //$ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con));    //オペレータの拠点倉庫

    //委託先の巡回担当者（代行料を仕入た人）を取得
    //する処理が必要（まだ不明）

    //仕入ヘッダ登録SQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_h ";
    $sql .= "( ";
    $sql .= "    buy_id, ";
    $sql .= "    shop_id, ";
    $sql .= "    buy_no, ";
    $sql .= "    buy_day, ";
    $sql .= "    arrival_day, ";
    $sql .= "    trade_id, ";
    $sql .= "    client_id, ";
    $sql .= "    client_cd1, ";
    $sql .= "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_name2, ";
    $sql .= "    client_cname, ";
    $sql .= "    ware_id, ";
    $sql .= "    ware_name, ";
    $sql .= "    c_staff_id, ";
    $sql .= "    c_staff_name, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    $sql .= "    net_amount, ";
    $sql .= "    tax_amount, ";
    $sql .= "    act_sale_id, ";
    $sql .= "    buy_div ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_buy_id, ";
    //$sql .= "    $act_id, ";
    $sql .= "    $head_id, ";
    $sql .= "    '$act_buy_no', ";
    $sql .= "    '$next_close_day', ";
    $sql .= "    '$buy_day', ";
    $sql .= "    '$buy_trade_id', ";
    $sql .= "    $shop_id, ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $shop_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $shop_id), ";
    //$sql .= "    (SELECT ware_id FROM t_client WHERE client_id = $act_id), ";
    //$sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = (SELECT ware_id FROM t_client WHERE client_id = $act_id)), ";
    //$sql .= "    $ware_id, ";
    //$sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
    $sql .= "    (SELECT ware_id FROM t_client WHERE client_id = $head_id), ";
    $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = (SELECT ware_id FROM t_client WHERE client_id = $head_id)), ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    $act_amount, ";
    $sql .= "    $act_tax, ";
    $sql .= "    $sale_id, ";
    $sql .= "    '2' ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //代行料仕入の仕入データID生成
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $act_buy_d_id = $microtime[1].substr("$microtime[0]", 2, 5);

    //仕入データ登録SQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_d ";
    $sql .= "( ";
    $sql .= "    buy_d_id, ";
    $sql .= "    buy_id, ";
    $sql .= "    line, ";
    $sql .= "    goods_id, ";
    $sql .= "    goods_name, ";
    $sql .= "    goods_cd, ";
    $sql .= "    tax_div, ";
    $sql .= "    num, ";
    $sql .= "    buy_price, ";
    $sql .= "    buy_amount ";
    $sql .= ") VALUES ( ";
    $sql .= "    $act_buy_d_id, ";
    $sql .= "    $act_buy_id, ";
    $sql .= "    1, ";
    $sql .= "    $act_goods_id, ";
    //$sql .= "    '$act_goods_name', ";
    $sql .= "    '".addslashes($client_cname." ".$act_goods_name)."', ";
    $sql .= "    '09999901', ";
    $sql .= "    '$act_tax_div', ";
    $sql .= "    1, ";
    $sql .= "    $act_amount, ";
    $sql .= "    $act_amount ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}





/**
 *
 * 紹介料を仕入
 *
 * 売上IDから紹介料を計算し、仕入テーブルへ登録
 *
 *
 * ■履歴
 * 1.0.0 (2006/08/18) kaji
 *   ・新規作成
 * 1.0.1 (2006/10/12) kaji
 *   ・仕入ヘッダに略称を残すように
 * 1.0.2 (2006/10/18) suzuki-t
 *   ・請求日を紹介者の翌月の締日に変更
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $sale_id    売上ID
 * @param       int         $client_id  紹介者ID
 *
 * @return      bool        成功：true
 *                          失敗：false
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.2 (2006/10/18)
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2006/11/11      03-007      kajioka-h   仕入先の場合はclient_cd2を登録しないように
 *  2006/12/08      03-077      suzuki      仕入担当者を登録
 *  2007/03/16      xx-xxx      kajioka-h   入荷倉庫を基本出荷倉庫からログインユーザの拠点倉庫に変更
 *  2007/03/30      要件26-2    kajioka-h   仕入の商品名を「得意先略称＋半角スペース＋紹介口座料」に
 *  2007/04/03      その他25    kajioka-h   紹介者がFCの場合、紹介料の仕入は委託先（東陽）ではなく、本部に変更
 *                                          ・本部の消費税率で紹介料を計算
 *                                          ・入荷倉庫を本部の基本倉庫に変更
 *                                          ・仕入ヘッダのshop_idを本部のIDに変更
 *                                          ・仕入ヘッダにbuy_div=2を登録
 *
 */
function FC_Intro_Buy_Query($db_con, $sale_id, $client_id)
{

    //紹介者がFCか仕入先か判定
    $sql = "SELECT client_div FROM t_client WHERE client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_client_div = pg_fetch_result($result, 0, "client_div");  //紹介者の取引先区分
    //紹介者がFCの場合、本部のclient_idを取得
    if($intro_client_div == "3"){
        //本部のclient_idを取得
        $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $head_id = pg_fetch_result($result, 0, "client_id");        //本部のclient_id
    }

    //売上IDから紹介料を取得
    $sql  = "SELECT ";
    $sql .= "    intro_amount, ";
    $sql .= "    shop_id, ";
    $sql .= "    client_cname ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "WHERE ";
    $sql .= "    sale_id = $sale_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_amount = pg_fetch_result($result, 0, "intro_amount");    //紹介料
    $shop_id      = pg_fetch_result($result, 0, "shop_id");         //ショップID
    $client_cname = pg_fetch_result($result, 0, "client_cname");    //

    //紹介料の商品ID、商品名、単位、課税区分を取得
    $sql  = "SELECT goods_id, goods_name, unit, tax_div FROM t_goods WHERE goods_cd = '09999902';";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_goods_id = pg_fetch_result($result, 0, "goods_id");        //紹介料の商品ID
    $intro_goods_name = pg_fetch_result($result, 0, "goods_name");    //紹介料の商品名
	//$intro_goods_name = addslashes($intro_goods_name);

    //$intro_unit = pg_fetch_result($result, 0, "unit");                //紹介料の単位
    $intro_tax_div = pg_fetch_result($result, 0, "tax_div");          //紹介料の課税区分

    //紹介者のまるめ区分、端数区分、請求日（支払日）を取得
    $sql  = "SELECT coax, tax_franct, pay_m, pay_d FROM t_client WHERE client_id = ".$client_id.";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $coax = pg_fetch_result($result, 0, "coax");    //まるめ区分
    $tax_franct = pg_fetch_result($result, 0, "tax_franct");    //端数区分
    //$pay_m = pg_fetch_result($result, 0, "pay_m");  //請求日（月）
    //$pay_d = pg_fetch_result($result, 0, "pay_d");  //請求日（日）

    //売上ヘッダの売上日（配送日）を取得
    #2009-12-24 aoyama-n
    $sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $buy_day     = pg_fetch_result($result, 0, "sale_day");         //売上日

    #2009-12-24 aoyama-n
    $buy_day_arr = explode("-", $buy_day);

    //仕入締チェック
    $check_pcd = !Check_Payment_Close_Day($db_con, $client_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2]);
    //仕入締がされている場合は締めた日の翌日を仕入日にする
    if($check_pcd){
        $sql  = "SELECT \n";
        $sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        $sql .= "FROM \n";
        $sql .= "    t_schedule_payment \n";
        $sql .= "WHERE \n";
        $sql .= "    client_id = $client_id \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);

        $next_close_day = pg_fetch_result($result, 0, 0);       //仕入日
    //仕入締がされてない場合は、売上日を仕入日に
    }else{
        $next_close_day = $buy_day;                             //仕入日
    }

    //自分の消費税率を取得
    #2009-12-24 aoyama-n
    #$sql  = "SELECT tax_rate_n FROM t_client WHERE client_id = ";
    #$sql .= ($intro_client_div == "3") ? "$head_id;" : "$shop_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$tax_rate = pg_fetch_result($result, 0, "tax_rate_n");  //消費税率

    #2009-12-24 aoyama-n
    //税率クラス　インスタンス生成
    if ($intro_client_div == "3") {
      $tax_rate_obj = new TaxRate($head_id);
    }else{
      $tax_rate_obj = new TaxRate($shop_id);
    }
    $tax_rate_obj->setTaxRateDay($next_close_day);
    $tax_rate = $tax_rate_obj->getClientTaxRate($client_id);


    //紹介料の消費税を計算
    $array_amount = Total_Amount(array($intro_amount), array($intro_tax_div), $coax, $tax_franct, $tax_rate, $client_id, $db_con);
    $intro_amount = $array_amount[0];   //紹介料
    $intro_tax    = $array_amount[1];   //消費税額

    //自動で起こす紹介料を登録する仕入ヘッダに使う仕入ID生成
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $intro_buy_id   = $microtime[1].substr("$microtime[0]", 2, 5);

    //同じく、仕入番号取得
    $sql  = "SELECT ";
    $sql .= "    MAX(buy_no) ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
    $sql .= "WHERE ";
    //紹介口座がFCなら本部の仕入番号
    if($intro_client_div == "3"){
        $sql .= "   shop_id = $head_id ";
    //仕入先なら直営、またはFCの仕入番号
    }else{
        if($_SESSION["group_kind"] == "2"){
            $sql .= "   shop_id IN (".Rank_Sql().") ";
        }else{
            $sql .= "   shop_id = $shop_id ";
        }
    }
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_buy_no = pg_fetch_result($result, 0, 0);
    $intro_buy_no = $intro_buy_no +1;
    $intro_buy_no = str_pad($intro_buy_no, 8, 0, STR_POS_LEFT);     //仕入番号

    //売上ヘッダの売上日（配送日）を取得
    #2009-12-24 aoyama-n
    #消費税取得の前で処理する
    #$sql  = "SELECT sale_day FROM t_sale_h WHERE sale_id = $sale_id;";
    #$result = Db_Query($db_con, $sql);
    #if($result === false){
    #    return false;
    #}
    #$buy_day     = pg_fetch_result($result, 0, "sale_day");         //売上日

/*
	//紹介者の締日を取得
    $sql  = "SELECT close_day FROM t_client WHERE client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $close_day = pg_fetch_result($result, 0, "close_day");   //締日
	//月末判定
	if($close_day == 29){
		//来月の月末が締日として計算
		$max_day = date("t",mktime(0, 0, 0,date("n")+1,1,date("Y")));
		$str = mktime(0, 0, 0,date("n")+1,$max_day,date("Y"));
	}else{
		//来月の締日を計算
		$str = mktime(0, 0, 0,date("n")+1,$close_day,date("Y"));
	}
	$year  = date("Y",$str);
	$month = date("m",$str);
	$day = date("d",$str);
	//請求日
	$next_close_day = $year."-".$month."-".$day;
*/
    #2009-12-24 aoyama-n
    #$buy_day_arr = explode("-", $buy_day);

    //仕入締チェック
    #$check_pcd = !Check_Payment_Close_Day($db_con, $client_id, $buy_day_arr[0], $buy_day_arr[1], $buy_day_arr[2]);
    //仕入締がされている場合は締めた日の翌日を仕入日にする
    #if($check_pcd){
        #$sql  = "SELECT \n";
        #$sql .= "    COALESCE(MAX(payment_close_day), '".START_DAY."')+1 \n";
        #$sql .= "FROM \n";
        #$sql .= "    t_schedule_payment \n";
        #$sql .= "WHERE \n";
        #$sql .= "    client_id = $client_id \n";
        #$sql .= ";";
        #$result = Db_Query($db_con, $sql);

        #$next_close_day = pg_fetch_result($result, 0, 0);       //仕入日
    //仕入締がされてない場合は、売上日を仕入日に
    #}else{
        #$next_close_day = $buy_day;                             //仕入日
    #}

    //取引先区分を取得して、仕入先だった場合client_cd2はNULL
    $sql = "SELECT client_div, client_cd2 FROM t_client WHERE client_id = $client_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    if(pg_fetch_result($result, 0, "client_div") != "2"){
        $client_cd2 = pg_fetch_result($result, 0, "client_cd2");
    }else{
        $client_cd2 = null;
    }

    //入荷倉庫抽出
    if($intro_client_div == "3"){
        //本部に仕入を起す場合は、本部の基本倉庫を入荷倉庫に
        $sql = "SELECT ware_id FROM t_client WHERE client_id = $head_id;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }
        $ware_id = pg_fetch_result($result, 0, "ware_id");          //本部の基本倉庫
    }else{
        //FCに仕入を起す場合は、オペレータの拠点倉庫を入荷倉庫に
        $ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con));    //オペレータの拠点倉庫
    }

    //委託先の巡回担当者（紹介料を仕入れた人）を取得
    //する処理が必要（まだ不明）

    //仕入ヘッダ登録SQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_h ";
    $sql .= "( ";
    $sql .= "    buy_id, ";
    $sql .= "    shop_id, ";
    $sql .= "    buy_no, ";
    $sql .= "    buy_day, ";
    $sql .= "    arrival_day, ";
    $sql .= "    trade_id, ";
    $sql .= "    client_id, ";
    $sql .= "    client_cd1, ";
    $sql .= ($client_cd2 == null) ? "" : "    client_cd2, ";
    $sql .= "    client_name, ";
    $sql .= "    client_name2, ";
    $sql .= "    client_cname, ";
    $sql .= "    ware_id, ";
    $sql .= "    ware_name, ";
    $sql .= "    c_staff_id, ";
    $sql .= "    c_staff_name, ";
    $sql .= "    e_staff_id, ";
    $sql .= "    e_staff_name, ";
    $sql .= "    net_amount, ";
    $sql .= "    tax_amount, ";
    $sql .= ($intro_client_div == "3") ? "    buy_div, " : "";
    $sql .= "    intro_sale_id ";
    $sql .= ") VALUES ( ";
    $sql .= "    $intro_buy_id, ";
    $sql .= ($intro_client_div == "3") ? "    $head_id, " : "    $shop_id, ";
    $sql .= "    '$intro_buy_no', ";
    $sql .= "    '$next_close_day', ";
    $sql .= "    '$buy_day', ";
    $sql .= "    '21', ";
    $sql .= "    $client_id, ";
    $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $client_id), ";
    $sql .= ($client_cd2 == null) ? "" : "    '$client_cd2', ";
    $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $client_id), ";
    $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $client_id), ";
    //$sql .= "    (SELECT ware_id FROM t_client WHERE client_id = $shop_id), ";
    //$sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = (SELECT ware_id FROM t_client WHERE client_id = $shop_id)), ";
    $sql .= "    $ware_id, ";
    $sql .= "    (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id), ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    ".$_SESSION["staff_id"].", ";
    $sql .= "    '".addslashes($_SESSION["staff_name"])."', ";
    $sql .= "    $intro_amount, ";
    $sql .= "    $intro_tax, ";
    $sql .= ($intro_client_div == "3") ? "    '2', " : "";
    $sql .= "    $sale_id ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    //代行料仕入の仕入データID生成
    $microtime = NULL;
    $microtime = explode(" ",microtime());
    $intro_buy_d_id = $microtime[1].substr("$microtime[0]", 2, 5);

    //仕入データ登録SQL
    $sql  = "INSERT INTO ";
    $sql .= "    t_buy_d ";
    $sql .= "( ";
    $sql .= "    buy_d_id, ";
    $sql .= "    buy_id, ";
    $sql .= "    line, ";
    $sql .= "    goods_id, ";
    $sql .= "    goods_name, ";
    $sql .= "    goods_cd, ";
    $sql .= "    tax_div, ";
    $sql .= "    num, ";
    $sql .= "    buy_price, ";
    $sql .= "    buy_amount ";
    $sql .= ") VALUES ( ";
    $sql .= "    $intro_buy_d_id, ";
    $sql .= "    $intro_buy_id, ";
    $sql .= "    1, ";
    $sql .= "    $intro_goods_id, ";
    //$sql .= "    '$intro_goods_name', ";
    $sql .= "    '".addslashes($client_cname." ".$intro_goods_name)."', ";
    $sql .= "    '09999902', ";
    $sql .= "    '$intro_tax_div', ";
    $sql .= "    1, ";
    $sql .= "    $intro_amount, ";
    $sql .= "    $intro_amount ";
    $sql .= ");";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return true;

}


/**
 *
 * 紹介料を計算
 *
 * 受注または売上IDから紹介料を計算
 * 受注または売上のヘッダ・データの売上金額、口座率・口座金額は登録済とする
 *
 *
 * ■履歴
 * 1.0.0 (2007/02/27) kaji
 *   ・新規作成
 * 1.1.0 (2007/04/06) kaji
 *   ・紹介口座料の仕様変更に対応
 *
 * @param       object      $db_con     DB接続リソース
 * @param       string      $slip_div   伝票区分（受注、売上のどちらのテーブルから計算するか）
 *                                          "aord"  ：受注
 *                                          "sale"  ：売上
 * @param       int         $slip_id    伝票ID
 *
 * @return      int         紹介口座料
 *                          失敗、または紹介料は発生しない設定の場合は false
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.1.0 (2007/04/06)
 *
 */
function FC_Intro_Amount_Calc($db_con, $slip_div, $slip_id)
{
    //計算する際にデータを取得するテーブル名
    $table_name = ($slip_div == "aord") ? "t_aorder_" : "t_sale_";

    //ヘッダの紹介者ID、口座単価（得意先）、口座率（得意先）、売上金額（税抜）を取得
    $sql  = "SELECT \n";
    $sql .= "    intro_account_id, \n";
    $sql .= "    intro_ac_div, \n";
    $sql .= "    intro_ac_price, \n";
    $sql .= "    intro_ac_rate, \n";
    $sql .= "    net_amount \n";
    $sql .= "FROM \n";
    $sql .= "    ".$table_name."h \n";
    $sql .= "WHERE \n";
    $sql .= "    ".$slip_div."_id = ".$slip_id." \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_account_id       = pg_fetch_result($result, 0, "intro_account_id");      //紹介者ID
    $intro_account_div      = pg_fetch_result($result, 0, "intro_ac_div");          //口座区分
    $intro_account_price    = pg_fetch_result($result, 0, "intro_ac_price");        //口座単価（得意先）
    $intro_account_rate     = pg_fetch_result($result, 0, "intro_ac_rate");         //口座率（得意先）
    $net_amount             = pg_fetch_result($result, 0, "net_amount");            //売上金額（税抜）

    //紹介者のまるめ区分取得
    $sql = "SELECT coax FROM t_client WHERE client_id = $intro_account_id;";
    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }
    $intro_coax = pg_fetch_result($result, 0, "coax");  //紹介者のまるめ区分


    //紹介料は発生しない場合
    if($intro_account_div == "1"){
        $intro_amount = false;

    //固定額
    }elseif($intro_account_div == "2"){
        $intro_amount = $intro_account_price;

    //売上率
    }elseif($intro_account_div == "3"){
        $intro_amount = bcmul($net_amount, bcdiv($intro_account_rate, 100, 2), 2);
        $intro_amount = Coax_Col($intro_coax, $intro_amount);

    //商品別
    }elseif($intro_account_div == "4"){

        //データテーブルの口座単価、口座率、売上金額を取得
        $sql  = "SELECT \n";
        $sql .= "    account_price, \n";
        $sql .= "    account_rate, \n";
        $sql .= "    sale_amount \n";
        $sql .= "FROM \n";
        $sql .= "    ".$table_name."d \n";
        $sql .= "WHERE \n";
        $sql .= "    ".$slip_div."_id = ".$slip_id." \n";
        $sql .= ";";

        $result = Db_Query($db_con, $sql);
        if($result === false){
            return false;
        }

        $count = pg_num_rows($result);
        for($i=0, $intro_amount=0 ; $i<$count; $i++){
            $account_price  = pg_fetch_result($result, $i, "account_price");    //口座単価
            $account_rate   = pg_fetch_result($result, $i, "account_rate");     //口座率
            $sale_amount    = pg_fetch_result($result, $i, "sale_amount");      //売上金額

            //口座単価あり、口座率なしの場合、口座単価を加える
            if($account_price != null && $account_rate == null){
                $intro_amount = bcadd($intro_amount, $account_price);

            //口座単価なし、口座率ありの場合、売上金額×口座率を加える
            }elseif($account_price == null && $account_rate != null){
                $price = bcmul($sale_amount, bcdiv($account_rate, 100, 2), 2);
                $price = Coax_Col($intro_coax, $price);
                $intro_amount = bcadd($intro_amount, $price);
            }
        }
    }


    return $intro_amount;   //紹介口座料

}


/**
 *
 * 商品予定出荷済なら巡回担当（メイン）の担当倉庫、やってなかったら受注ヘッダの出荷倉庫を返すだけの関数
 *
 *
 * ■履歴
 * 1.0.0 (2007/03/28) kaji
 *   ・新規作成
 *
 * @param       object      $db_con     DB接続リソース
 * @param       int         $aord_id    受注ID
 *
 * @return      成功：int   倉庫ID
 *              失敗：bool  false
 *
 *
 * @author      kajioka-h <kajioka-h@bhsk.co.jp>
 * @version     1.0.0 (2007/03/28)
 *
 */
function FC_Move_Ware_Id($db_con, $aord_id)
{
    $sql  = "SELECT \n";
    $sql .= "    CASE t_aorder_h.move_flg \n";
    $sql .= "        WHEN true THEN t_attach.ware_id \n";
    $sql .= "        ELSE t_aorder_h.ware_id \n";
    $sql .= "    END \n";
    $sql .= "FROM \n";
    $sql .= "    t_aorder_h \n";
    $sql .= "    INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
    $sql .= "        AND t_aorder_staff.staff_div = '0' \n";
    $sql .= "    INNER JOIN t_attach ON t_aorder_staff.staff_id = t_attach.staff_id \n";
    $sql .= "        AND t_attach.h_staff_flg = false \n";
    $sql .= "WHERE \n";
    $sql .= "    t_aorder_h.aord_id = $aord_id \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    if($result === false){
        return false;
    }

    return pg_fetch_result($result, 0, 0);

}

?>
