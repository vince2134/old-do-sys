<?php
/**
 *
 * オンライン代行の巡回報告処理（エラーチェックからデータ登録まで）
 *
 * 呼出元
 * ・2-1-238（受託巡回（報告一覧／確定））
 * ・2-2-106（予定データ明細）
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/26      他79,152    kajioka-h   代行料の仕様変更
 *  2007/05/31      xx-xxx      kajioka-h   処理状況を2にしないように変更
 *  2007/06/07      xx-xxx      kajioka-h   「委託先」→「代行先」に文言変更
 *  2007-06-25                  fukuda      このファイル内の、エラーメッセージ出力フォーマットを統一
 *
 */

    /******************************/
    // 警告
    /******************************/

    // 商品予定出荷で在庫移動しているかチェックのため受注IDを取得
    if ($aord_array != null && $_POST["warn_report_flg"] != true){

        $aord_array_count = count($aord_array);
        for ($s = 0, $aord_array_str = null; $s < $aord_array_count; $s++){
            $aord_array_str .= $aord_array[$s].", ";
        }
        $aord_array_str = substr($aord_array_str, 0, (strlen($aord_array_str) - 2));

        // 未確定、削除されてない伝票で、商品予定出荷されてない伝票番号を取得
        $sql  = "SELECT \n";
        $sql .= "   ord_no \n";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h \n";
        $sql .= "WHERE \n";
        $sql .= "   aord_id IN (".$aord_array_str.") \n";
        $sql .= "AND \n";
        $sql .= "   move_flg = false \n";
        $sql .= "AND \n";
        $sql .= "   trust_confirm_flg = false \n";
        $sql .= "AND \n";
        $sql .= "   del_flg = false \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $aord_array_count = pg_num_rows($result);

        if ($aord_array_count != 0){

            for ($s = 0, $move_warning = "伝票番号 "; $s < $aord_array_count; $s++){
                $move_warning .= pg_fetch_result($result, $s, 0)." ";
                $alert_flg = true;
            }
            $move_warning .= " の伝票は商品予定出荷で担当倉庫へ在庫移動されていません。<br>";

            // 無視用ボタン
            $form->addElement("button", "form_confirm_warn", "警告を無視して報告", "
                onClick=\"javascript:Button_Submit('warn_report_flg','".$_SERVER["REQUEST_URI"]."', true);\" $disabled
            ");
            $form->addElement("hidden", "warn_report_flg");

        }

    }


    /******************************/
    // 報告
    /******************************/
    // チェック判定
    if (
        $aord_array != null && 
        ($_POST["warn_report_flg"] == true || 
        (
            ($_POST["report_flg"] == true || $_POST["hdn_report"] != null) && $move_warning == null)
        )
    ){

        // トランザクション開始
        Db_Query($db_con, "BEGIN;");

        // チェックした受注ID分伝票表示
        for ($s = 0; $s < count($aord_array); $s++){

            // 既に巡回報告されていないかチェック
            $sql  = "SELECT \n";
            $sql .= "   trust_confirm_flg, \n";
            $sql .= "   ord_no \n";
            $sql .= "FROM \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "WHERE \n";
            $sql .= "   aord_id = ".$aord_array[$s]." \n";
            $sql .= "AND \n";
            $sql .= "   trust_confirm_flg = true \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if (pg_num_rows($result) != 0){
                $trust_confirm_err  = "既に巡回報告が行われているため以下の伝票番号を報告できません。";
                $trust_confirm_no[] = pg_fetch_result($result, 0, 1);
                $err_flg = true;
            }

            /****************************/
            //受注ヘッダーテーブル更新
            /****************************/
            $sql  = "UPDATE \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "SET \n";
            $sql .= "   trust_confirm_flg = 't', \n";   // 確定フラグ
            $sql .= "   cancel_flg = 't' \n";           // 取消フラグ
            $sql .= "WHERE \n";
            $sql .= "   aord_id = ".$aord_array[$s]." \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if ($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            // 代行料存在判定
            $sql  = "SELECT \n";
            $sql .= "   aord_id \n";
            $sql .= "FROM \n";
            $sql .= "   t_sale_h \n";
            $sql .= "WHERE \n";
            $sql .= "   aord_id = ".$aord_array[$s]." \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            $aord_count = pg_num_rows($result);

            $sql  = "SELECT \n";
            $sql .= "   shop_id, \n";
            $sql .= "   client_id, \n";
            $sql .= "   ord_time, \n";
            $sql .= "   del_flg, \n";
            $sql .= "   ord_no, \n";
            $sql .= "   claim_div \n";
            $sql .= "FROM \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "WHERE \n";
            $sql .= "   aord_id = ".$aord_array[$s]." \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            $shop_data = Get_Data($result);

            $ord_time_arr = explode("-", $shop_data[0][2]);

            // 巡回日チェック月次（委託先が得意先に対して月次やってたら売上確定できないので）
            if (!Check_Monthly_Renew($db_con, $shop_data[0][1], 1, $ord_time_arr[0], $ord_time_arr[1], $ord_time_arr[2], $shop_data[0][0])){
                $ord_time_itaku_err  = "予定巡回日が代行先の前回月次更新以前のため以下の伝票番号を報告できません。";
                $ord_time_itaku_no[] = $shop_data[0][4];
                $err_flg = true;
            }

            //巡回日がシステム開始日より先かチェック
            $err_mess = Sys_Start_Date_Chk($ord_time_arr[0], $ord_time_arr[1], $ord_time_arr[2], "巡回日");
            if($err_mess != null){
                $ord_time_start_err  = "予定巡回日に".START_DAY."以前の日付が登録されているため以下の伝票を報告できません。";
                $ord_time_start_no[] = $shop_data[0][4];
                $err_flg = true;
            }

            // 削除されているかチェック
            if($shop_data[0][3] == "t"){
                $del_err  = "伝票が削除されているため以下の伝票を報告できません。";
                $del_no[] = $shop_data[0][4];
                $err_flg = true;
            }

            // 予定巡回日を取得
            $array_date = explode("-", $shop_data[0][2]);

            // 予定巡回日が請求日が前回より先かチェック
            #2013-05-23 hashimoto-y
            #請求先区分(claim_div)の条件不足
            #if (Check_Bill_Close_Day($db_con, $shop_data[0][1], $array_date[0], $array_date[1], $array_date[2]) == false){ 
            if (Check_Bill_Close_Day_Claim($db_con, $shop_data[0][1], $shop_data[0][5], $array_date[0], $array_date[1], $array_date[2]) == false){ 
                $claim_day_bill_err     = "予定巡回日に請求書作成済の日付が入力されているため以下の伝票を報告できません。";
                $claim_day_bill_no[]    = $shop_data[0][4];
                $err_flg = true;
            }

            // 予定巡回日未来チェック
            if ($shop_data[0][2] > date("Y-m-d")){
                $err_future_date_msg    = "予定巡回日が未来の日付になっているため以下の伝票を報告できません。";
                $ary_future_date_no[]   = $shop_data[0][4];
                $err_flg = true;
                
            }

            // 存在していなければ登録
            if ($aord_count == 0){

                // 東陽のclient_idを取得（各ショップの得意先マスタに自動で登録されるやつ）
                $sql  = "SELECT \n";
                $sql .= "   client_id \n";
                $sql .= "FROM \n";
                $sql .= "   t_client \n";
                $sql .= "WHERE \n";
                $sql .= "   shop_id = $shop_id \n";
                $sql .= "AND \n";
                $sql .= "   act_flg = true \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                $toyo_id = pg_fetch_result($result, 0, 0);

                /****************************/
                // 代行料登録処理
                /****************************/
                // 巡回日チェック月次（自分が委託先に対して月次やってたらダメ）
                if (!Check_Monthly_Renew($db_con, $toyo_id, 1, $ord_time_arr[0], $ord_time_arr[1], $ord_time_arr[2])){
                    $ord_time_err  = "予定巡回日が前回の月次更新以前のため以下の伝票を報告できません。";
                    $ord_time_no[] = $shop_data[0][4];
                    $err_flg = true;
                }

                // 巡回日、受注番号、出荷倉庫（受注ヘッダの）、商品予定出荷フラグを取得
                $sql  = "SELECT \n";
                $sql .= "   ord_time, \n";
                $sql .= "   ord_no, \n";
                $sql .= "   ware_id, \n";
                $sql .= "   move_flg \n";
                $sql .= "FROM \n";
                $sql .= "   t_aorder_h \n";
                $sql .= "WHERE \n";
                $sql .= "   t_aorder_h.aord_id = ".$aord_array[$s]." \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                $stock_data = Get_Data($result);
                $ord_time = $stock_data[0][0];      // 巡回日
                $ord_no   = $stock_data[0][1];      // 受注番号
                $ware_id  = $stock_data[0][2];      // 出荷倉庫ID
                $move_flg = $stock_data[0][3];      // 商品予定出荷フラグ

                // 巡回担当者（メイン）の担当倉庫を取得
                $sql  = "SELECT \n";
                $sql .= "   staff_id \n";
                $sql .= "FROM \n";
                $sql .= "   t_aorder_staff \n";
                $sql .= "WHERE \n";
                $sql .= "   aord_id = ".$aord_array[$s]." \n";
                $sql .= "AND \n";
                $sql .= "   staff_div = '0' \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                $staff_ware_id = Get_Staff_Ware_Id($db_con, pg_fetch_result($result, 0, "staff_id"));

                // 商品予定出荷していない場合、ヘッダの出荷倉庫を担当者の拠点倉庫に更新
                if ($move_flg == "f"){

                    $sql  = "SELECT \n";
                    $sql .= "   staff_id \n";
                    $sql .= "FROM \n";
                    $sql .= "   t_aorder_staff \n";
                    $sql .= "WHERE \n";
                    $sql .= "   t_aorder_staff.aord_id = ".$aord_array[$s]." \n";
                    $sql .= "AND \n";
                    $sql .="    t_aorder_staff.staff_div = '0' \n";
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $move_staff_id = pg_fetch_result($result, 0, 0);
                    $ware_id = Get_Ware_Id($db_con, Get_Branch_Id($db_con, $move_staff_id));

                    $sql  = "UPDATE \n";
                    $sql .= "   t_aorder_h \n";
                    $sql .= "SET \n";
                    $sql .= "   ware_id = $ware_id, \n";
                    $sql .= "   ware_name = (SELECT ware_name FROM t_ware WHERE ware_id = $ware_id) \n";
                    $sql .= "WHERE \n";
                    $sql .= "   aord_id = ".$aord_array[$s]." \n";
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    if ($result == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }

                }

                // 代行料売上
                $sale_d_id = FC_Act_Sale_Query($db_con,$aord_array[$s],$toyo_id,$shop_id);

                if ($sale_d_id === false){

                    // 同時実行制御処理
                    $err_message = pg_last_error();
                    $err_format = "t_aorder_no_serial_fc_pkey";

                    Db_Query($db_con, "ROLLBACK;");

                    //入金番号が重複した場合
                    if(strstr($err_message,$err_format) != false){
                        $error_sale    = "以下の伝票は、売上番号が重複しました。もう一度報告を行ってください。";
                        $err_sale_no[] = $ord_no;
                        $err_flg = true;

                        $err_data["report_flg"] = false;
                        $form->setConstants($err_data);
                        break;
                    }else{
                        exit;
                    }

                }


                /****************************/
                // 在庫受払登録処理
                /****************************/
                $sql  = "SELECT \n";
                $sql .= "   t_aorder_d.aord_d_id, \n";      // 受注データID
                $sql .= "   t_aorder_h.client_id, \n";      // 得意先ID
                $sql .= "   t_aorder_h.client_cname \n";    // 得意先（略称）
                $sql .= "FROM \n";
                $sql .= "   t_aorder_h \n";
                $sql .= "   INNER JOIN t_aorder_d \n";
                $sql .= "       ON t_aorder_h.aord_id = t_aorder_d.aord_id \n";
                $sql .= "WHERE \n";
                $sql .= "   t_aorder_h.aord_id = ".$aord_array[$s]." \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                $data_list = Get_Data($result, 3);

                // 受注に紐付いている引当の受払を全削除
                $sql  = "DELETE FROM \n";
                $sql .= "   t_stock_hand \n";
                $sql .= "WHERE \n";
                $sql .= "   aord_d_id IN \n";
                $sql .= "       ( \n";
                $sql .= "           SELECT aord_d_id FROM t_aorder_d WHERE aord_id = ".$aord_array[$s]." \n";
                $sql .= "       ) \n";
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if ($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                // 受払に登録するデータ取得
                for ($d = 0; $d < count($data_list); $d++){
                    $sql  = "SELECT \n";
                    $sql .= "   t_aorder_ship.goods_id, \n";
                    $sql .= "   t_aorder_ship.goods_name, \n";
                    $sql .= "   t_aorder_ship.num \n";
                    $sql .= "FROM \n";
                    $sql .= "   t_aorder_ship \n";
                    $sql .= "WHERE \n";
                    $sql .= "   t_aorder_ship.aord_d_id = ".$data_list[$d][0]." \n";
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $goods_data = Get_Data($result,3);
                    for ($x = 0; $x < count($goods_data); $x++){
                        $goods_id[]   = $goods_data[$x][0];         // 商品ID
                        $goods_name[] = $goods_data[$x][1];         // 商品名
                        $goods_num[]  = $goods_data[$x][2];         // 数量
                    }
                }

                // 受払いテーブルに、売上を行った全ての商品登録
                for ($g = 0; $g < count($goods_id); $g++){

                    //作業区分「2：売上」、入出庫区分「2：出庫」
                    $sql  = "INSERT INTO \n";
                    $sql .= "   t_stock_hand \n";
                    $sql .= "( \n";
                    $sql .= "   goods_id, \n";
                    $sql .= "   enter_day, \n";
                    $sql .= "   work_day, \n";   
                    $sql .= "   work_div, \n";
                    $sql .= "   client_id, \n";
                    $sql .= "   client_cname, \n";
                    $sql .= "   ware_id, \n";
                    $sql .= "   io_div, \n";
                    $sql .= "   num, \n";
                    $sql .= "   slip_no, \n";
                    $sql .= "   sale_d_id, \n";
                    $sql .= "   staff_id, \n";
                    $sql .= "   shop_id \n";
                    $sql .= ") \n";
                    $sql .= "VALUES \n";
                    $sql .= "( \n";
                    $sql .= "   ".$goods_id[$g].", \n";   
                    $sql .= "   NOW(), \n";
                    $sql .= "   '$ord_time', \n";
                    $sql .= "   '2', \n";
                    $sql .= "   ".$data_list[0][1].", \n";
                    $sql .= "   '".$data_list[0][2]."', \n";
                    //商品予定出荷済は担当倉庫から、してない場合は出荷倉庫（拠点倉庫）から売上
                    if ($move_flg == "t"){
                        $sql .= "   $staff_ware_id, \n";
                    }else{
                        $sql .= "   $ware_id, \n";
                    }
                    $sql .= "   '2', \n";
                    $sql .= "   ".$goods_num[$g].", \n";
                    $sql .= "   '$ord_no', \n";
                    $sql .= "   $sale_d_id, \n"; 
                    $sql .= "   ".$_SESSION["staff_id"].", \n";
                    $sql .= "   $shop_id \n";
                    $sql .= ") \n";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql);
                    if($result == false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }

                }

            }

            // 初期化？
            $goods_id   = null;     // 商品ID
            $goods_name = null;     // 商品名
            $goods_num  = null;     // 数量

        }   // 伝票ループ終了


        /******************************/
        // まとめ
        /******************************/
        // 全体を通してエラーが無かった場合
        if ($err_flg != true){

            // トランザクション完結
            Db_Query($db_con, "COMMIT;");

            // 報告完了メッセージ
            $repo_comp_mess = "報告しました。";

            // 巡回報告画面の場合
            if (strstr($_SERVER["PHP_SELF"], "2-1-238") !== false){
                header("Location: ./2-1-238.php?search=1");
            }

        // エラーがあった場合
        }else{

            // ロールバック
            Db_Query($db_con, "ROLLBACK;");

        }


    /******************************/
    // 伝票にチェックが無い場合
    /******************************/
    }elseif ($aord_array == null){

        // チェックが無い場合はエラー
        $error_msg3 = "報告する伝票が一つも選択されていません。";
        $error_flg = true;

    }


    // 報告ボタン押下フラグ初期化
    $con_data["report_flg"] = "";
    $con_data["warn_report_flg"] = "";

?>
