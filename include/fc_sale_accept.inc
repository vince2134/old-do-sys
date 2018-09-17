<?php
/**
 *
 * 代行の巡回承認処理（エラーチェックからデータ登録まで）
 *
 * 呼出元
 * ・2-1-237（委託巡回（報告一覧／確定））
 * ・2-2-106（予定データ明細）
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/04/03      B0702-033   kajioka-h   仕入番号が重複したときにエラーメッセージが表示されないバグ修正
 *  2007/04/09      要件1-4     kajioka-h   紹介料の仕様変更に対応
 *  2007/04/26      他79,152    kajioka-h   代行料の仕様変更
 *  2007/05/23      xx-xxx      kajioka-h   代行伝票の現金取引可能になった
 *  2007/05/30      xx-xxx      kajioka-h   予定手書フラグを売上ヘッダに残すように変更
 *  2007/06/05      xx-xxx      kajioka-h   直送先を残す
 *  2007-06-08      xx-xxx      fukuda      前受金関連のカラム追加により、受注伝票から売上伝票を作成するクエリにカラムを追加
 *  2007-06-08      xx-xxx      fukuda      前受相殺額がある伝票の確定時、取引区分「前受相殺」で入金を起こすよう修正
 *  2007-06-08      xx-xxx      fukuda      ↑用のエラーチェック追加
 *  2007/06/14      その他14    kajioka-h   前受ありで予定巡回日 != 請求日の場合エラーチェック追加（やっぱりなし070615）
 *  2007-07-12                  fukuda      「支払締」を「仕入締」に変更
 *
 */

    //チェック判定
    if($aord_array != NULL){

        //本部のclient_idを取得
        $sql = "SELECT client_id FROM t_client WHERE rank_cd = (SELECT rank_cd FROM t_rank WHERE group_kind = '1');";
        $result = Db_Query($db_con, $sql);
        $head_id = pg_fetch_result($result, 0, "client_id");        //本部のclient_id


        Db_Query($db_con, "BEGIN;");

        //チェックした受注ID分伝票表示
        for($s=0;$s<count($aord_array);$s++){

            //エラー時に表示する伝票番号取得
            $sql  = "SELECT ord_no FROM t_aorder_h WHERE aord_id = ".$aord_array[$s].";";
            $result = Db_Query($db_con, $sql);
            $ord_no = pg_fetch_result($result,0,"ord_no"); //伝票番号

            //既に承認されていないかチェック
            $sql = "SELECT renew_flg FROM t_sale_h WHERE sale_id = ".$aord_array[$s].";";
            $result = Db_Query($db_con, $sql);
            if(pg_num_rows($result) != 0){
                $confirm_err = "以下の伝票は、承認されているため承認できません。";
                $confirm_err_no[$ord_no] = $ord_no;
            }

            //まだ承認されていない場合のみ以降の処理実行
            if($confirm_err_no[$ord_no] == NULL){
                $sql  = "SELECT \n";
                $sql .= "    contract_div, \n";
                $sql .= "    confirm_flg, \n";
                $sql .= "    trust_confirm_flg, \n";
                $sql .= "    del_flg, \n";
                $sql .= "    act_id \n";
                $sql .= "FROM \n";
                $sql .= "    t_aorder_h \n";
                $sql .= "WHERE \n";
                $sql .= "    aord_id = ".$aord_array[$s]." \n";
                $sql .= ";";

                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                $contract_div       = pg_fetch_result($result, 0, "contract_div");      //契約区分
                $confirm_flg        = pg_fetch_result($result, 0, "confirm_flg");       //確定（承認）フラグ
                $trust_confirm_flg  = pg_fetch_result($result, 0, "trust_confirm_flg"); //受託先確定（報告）フラグ
                $del_flg            = pg_fetch_result($result, 0, "del_flg");           //削除フラグ
                $act_id             = pg_fetch_result($result, 0, "act_id");            //代行者ID

                if($del_flg == "t"){
                    $del_err = "以下の伝票は、削除されているため承認できません。";
                    $del_err_no[$ord_no] = $ord_no;
                }

                //オンライン代行で取消されているかチェック
                if($contract_div == "2" && $trust_confirm_flg == "f"){
                    $cancel_err = "以下の伝票は、取消されているため承認できません。";
                    $cancel_err_no[$ord_no] = $ord_no;
                }


                $buy_amount = NULL;   //紹介料配列

                /****************************/
                //受注ヘッダーテーブル更新
                /****************************/
                $sql  = "UPDATE t_aorder_h SET";
                $sql .= "   confirm_flg = 't',";         //確定フラグ
                $sql .= "   ps_stat = '3' ";             //処理状況
                $sql .= "WHERE";
                $sql .= "   aord_id = ".$aord_array[$s];
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
                if($result == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                /****************************/
                //受注ヘッダーを基に、売上ヘッダー作成
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    ord_no,"; //0
                $sql .= "    ord_time,"; //1
                $sql .= "    arrival_day,"; //2
                $sql .= "    client_id,"; //3
                $sql .= "    trade_id,"; //4
                $sql .= "    ware_id,"; //5
                $sql .= "    note,"; //6
                $sql .= "    cost_amount,"; //7
                $sql .= "    net_amount,"; //8
                $sql .= "    tax_amount,"; //9
                $sql .= "    intro_ac_name,"; //10
                $sql .= "    slip_flg,"; //11
                $sql .= "    shop_id, "; //12
                $sql .= "    intro_account_id,"; //13
                $sql .= "    intro_amount,"; //14
                $sql .= "    contract_div,"; //15
                $sql .= "    client_cd1,"; //16
                $sql .= "    client_cd2,"; //17
                $sql .= "    client_cname,"; //18
                $sql .= "    client_name,"; //19
                $sql .= "    client_name2,"; //20
                $sql .= "    ware_name, ";    //21
                $sql .= "    reason_cor,";    //22
                $sql .= "    route,";         //23
                $sql .= "    intro_ac_price,"; //24
                $sql .= "    intro_ac_rate,";  //25
                $sql .= "    claim_id,";   //26
                $sql .= "    claim_div,  "; //27
                $sql .= "    round_form,";  //28
                $sql .= "    slip_out, ";   //29
                $sql .= "    intro_ac_cd1, ";   //30
                $sql .= "    intro_ac_cd2, ";   //31
                $sql .= "    intro_ac_div, ";   //32
                $sql .= "    act_div, ";        //33
                $sql .= "    act_request_price, ";  //34
                $sql .= "    act_request_rate, ";   //35
                $sql .= "    hand_plan_flg, ";  //36
                $sql .= "    direct_id, ";      //37
                $sql .= "    direct_name, ";    //38
                $sql .= "    direct_name2, ";   //39
                $sql .= "    direct_cname, ";   //40
                $sql .= "    advance_offset_totalamount ";   //41  前受相殺額合計（2007-06-08 fukuda）

                $sql .= "FROM ";
                $sql .= "    t_aorder_h ";
                $sql .= "WHERE ";
                $sql .= "   aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list = Get_Data($result,5);

                //配送日を取得
                $array_date = explode("-", $data_list[0][1]);
                //配送日が前回月次更新より先かチェック
                if(Check_Monthly_Renew($db_con, $data_list[0][3], "1", $array_date[0], $array_date[1], $array_date[2]) == false){
                    $deli_day_renew_err = "以下の伝票は、配送日が前回の月次更新以前の伝票です。";
                    $deli_day_renew_err_no[$ord_no] = $ord_no;
                }
                //代行料仕入を起こす際、本部が代行者に月次更新をやってないかチェック
                if(Check_Monthly_Renew($db_con, $act_id, "2", $array_date[0], $array_date[1], $array_date[2], $head_id) == false){
                    $deli_day_act_renew_err = "以下の伝票は、配送日が前回の本部月次更新以前の伝票です。";
                    $deli_day_act_renew_err_no[$ord_no] = $ord_no;
                }
                //紹介料仕入を起こす際、本部が代行者に月次更新をやってないかチェック
                if($data_list[0][13] != null && $_SESSION["group_kind"] == "2"){
                    $sql = "SELECT client_div FROM t_client WHERE client_id = ".$data_list[0][13].";";
                    $result = Db_Query($db_con, $sql);
                    if(pg_fetch_result($result, 0, "client_div") == "3"){
                        if(Check_Monthly_Renew($db_con, $data_list[0][13], "2", $array_date[0], $array_date[1], $array_date[2], $head_id) == false){
                            $deli_day_intro_renew_err = "以下の伝票は、配送日が前回の本部月次更新以前の伝票です。";
                            $deli_day_intro_renew_err_no[$ord_no] = $ord_no;
                        }
                    }
                }


                //請求日を取得
                $array_date = explode("-", $data_list[0][2]);
                //請求日が前回月次更新より先かチェック
                if(Check_Monthly_Renew($db_con, $data_list[0][3], "1", $array_date[0], $array_date[1], $array_date[2]) == false){
                    $claim_day_renew_err = "以下の伝票は、請求日が前回の月次更新以前の伝票です。";
                    $claim_day_renew_err_no[$ord_no] = $ord_no;
                }
                //請求日が前回より先かチェック
                #2013-05-23 hashimoto-y
                #請求先区分(claim_div)の条件不足
                #if(Check_Bill_Close_Day($db_con, $data_list[0][3], $array_date[0], $array_date[1], $array_date[2]) == false){
                if(Check_Bill_Close_Day_Claim($db_con, $data_list[0][3], $data_list[0][27], $array_date[0], $array_date[1], $array_date[2]) == false){
                    $claim_day_bill_err  = "以下の伝票は、請求日に請求書作成済の日付が入力されています。<br>";
                    $claim_day_bill_err .= "請求日を変更するか、請求書を削除して下さい。";
                    $claim_day_bill_err_no[$ord_no] = $ord_no;
                }
                //代行料仕入を起こす際、本部が代行者に仕入締をやってないかチェック
                if(Check_Payment_Close_Day($db_con, $act_id, $array_date[0], $array_date[1], $array_date[2], $head_id) == false){
                    $pay_day_act_err  = "以下の伝票は、請求日が前回の本部仕入締日以前の伝票です。";
                    $pay_day_act_err_no[$ord_no] = $ord_no;
                }
                //紹介料仕入を起こす際、本部が代行者に仕入締をやってないかチェック
                if($data_list[0][13] != null && $_SESSION["group_kind"] == "2"){
                    $sql = "SELECT client_div FROM t_client WHERE client_id = ".$data_list[0][13].";";
                    $result = Db_Query($db_con, $sql);
                    if(pg_fetch_result($result, 0, "client_div") == "3"){
                        if(Check_Payment_Close_Day($db_con, $data_list[0][13], $array_date[0], $array_date[1], $array_date[2], $head_id) == false){
                            $pay_day_intro_renew_err = "以下の伝票は、配送日が前回の本部月次更新以前の伝票です。";
                            $pay_day_intro_renew_err_no[$ord_no] = $ord_no;
                        }
                    }
                }

                // 受注ヘッダから取得した前受相殺額合計を変数にセット
                $advance_offset = $data_list[0][41];

                // 受注ヘッダ取得→今ココ→受注ヘッダを元に売上ヘッダ登録
                // 請求先に対する前受金残高取得（引数：ord_time, client_id, claim_div）
                $advance_balance = Advance_Offset_Claim($db_con, $data_list[0][1], $data_list[0][3], $data_list[0][27]);

                $sql  = "INSERT INTO t_sale_h(";
                $sql .= "    sale_id,";         //売上ID
                $sql .= "    sale_no,";         //売上番号
                $sql .= "    aord_id,";         //受注ID
                $sql .= "    sale_day,";        //売上日
                $sql .= "    claim_day,";       //請求日
                $sql .= "    client_id,";       //得意先ID
                $sql .= "    trade_id,";        //取引区分
                $sql .= "    ware_id,";         //出荷倉庫
                $sql .= "    note,";            //備考
                $sql .= "    cost_amount,";     //原価金額
                $sql .= "    net_amount,";      //売上金額
                $sql .= "    tax_amount,";      //消費税額
                $sql .= "    intro_ac_name,";   //紹介口座名
                $sql .= "    slip_flg,";        //伝票出力フラグ
                $sql .= "    shop_id,";         //取引先ID
                $sql .= "    intro_account_id,";//紹介口座ID
                $sql .= "    intro_amount,";    //紹介口座料
                $sql .= "    c_shop_name,";     //ショップ名
                $sql .= "    c_shop_name2,";    //ショップ名２
                $sql .= "    client_cd1,";      //得意先CD1
                $sql .= "    client_cd2,";      //得意先CD2
                $sql .= "    client_cname,";    //略称
                $sql .= "    client_name,";     //得意先名1
                $sql .= "    client_name2,";    //得意先名2
                $sql .= "    c_post_no1,";      //郵便番号1
                $sql .= "    c_post_no2,";      //郵便番号2
                $sql .= "    c_address1,";      //住所１
                $sql .= "    c_address2,";      //住所２
                $sql .= "    c_address3,";      //住所３
                $sql .= "    ware_name,";       //出荷倉庫名
                $sql .= "    reason_cor,";      //訂正理由
                $sql .= "    route,";           //順路
                $sql .= "    intro_ac_price,";  //口座単価(得意先)
                $sql .= "    intro_ac_rate,";   //口座率(得意先)
                $sql .= "    claim_id,";        //請求先ID
                $sql .= "    claim_div,";       //請求先区分
                $sql .= "    round_form,";      //巡回形式
                $sql .= "    contract_div,";    //契約区分
                $sql .= "    slip_out,";        //伝票形式
                $sql .= "    e_staff_id,";      //オペレータID
                $sql .= "    e_staff_name, ";   //オペレータ名
                $sql .= "    act_id,";          //代行者ID
                $sql .= "    act_cd1,";         //代行者CD1
                $sql .= "    act_cd2,";         //代行者CD2
                $sql .= "    act_name1,";       //代行者名1
                $sql .= "    act_name2,";       //代行者名2
                $sql .= "    act_cname, ";      //代行者名（略称）
                $sql .= "    intro_ac_cd1, ";   //紹介口座先CD1
                $sql .= "    intro_ac_cd2, ";   //紹介口座先CD2
                $sql .= "    intro_ac_div, ";   //紹介口座料区分
                $sql .= "    act_div, ";        //代行料区分
                $sql .= "    act_request_price, ";  //代行料（固定）
                $sql .= "    act_request_rate, ";   //代行料（％）
                if($data_list[0][37] != null){
                    $sql .= "    direct_id, ";      //直送先ID
                    $sql .= "    direct_cd, ";      //直送先CD
                    $sql .= "    direct_name, ";    //直送先名
                    $sql .= "    direct_name2, ";   //直送先名2
                    $sql .= "    direct_cname, ";   //直送先略称
                    $sql .= "    d_post_no1, ";     //直送先郵便番号1
                    $sql .= "    d_post_no2, ";     //直送先郵便番号2
                    $sql .= "    d_address1, ";     //直送先住所1
                    $sql .= "    d_address2, ";     //直送先住所2
                    $sql .= "    d_address3, ";     //直送先住所3
                    $sql .= "    d_tel, ";          //直送先電話番号
                    $sql .= "    d_fax, ";          //直送先FAX
                }
                $sql .= "    hand_plan_flg, ";  //予定手書フラグ
                $sql .= "   advance_offset_totalamount \n";     // 前受相殺額合計（2007-06-08 fukuda）

                $sql .= ")VALUES(";
                $sql .= "    ".$aord_array[$s].",";
                //受注番号指定判定
                if($data_list[0][0] != NULL){
                    $sql .= "    '".$data_list[0][0]."',";
                }else{
                    $sql .= "    NULL,";
                }
                $sql .= "    ".$aord_array[$s].",";
                $sql .= "    '".$data_list[0][1]."',";
                $sql .= "    '".$data_list[0][2]."',";
                $sql .= "    ".$data_list[0][3].",";
                $sql .= "    '".$data_list[0][4]."',";
                $sql .= "    NULL,";         //代行伝票の出荷倉庫は代行側なので売上にはNULL
                $sql .= "    '".$data_list[0][6]."',";
                $sql .= "    ".$data_list[0][7].",";
                $sql .= "    ".$data_list[0][8].",";
                $sql .= "    ".$data_list[0][9].",";
                $sql .= "    '".$data_list[0][10]."',";
                $sql .= "    '".$data_list[0][11]."',";
                $sql .= "    ".$data_list[0][12].",";
                //紹介口座判定
                if($data_list[0][13] != NULL){
                    $sql .= "    ".$data_list[0][13].",";
                }else{
                    $sql .= "    NULL,";
                }
                //紹介口座料判定
                if($data_list[0][14] != NULL){
                    $sql .= "    ".$data_list[0][14].",";
                }else{
                    $sql .= "    NULL,";
                }

                $sql .= "    (SELECT ";
                $sql .= "        t_client.shop_name ";   //ショップ名
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.shop_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.shop_name2 ";  //ショップ名2
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.shop_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    '".$data_list[0][16]."',";
                $sql .= "    '".$data_list[0][17]."',";
                $sql .= "    '".$data_list[0][18]."',";
                $sql .= "    '".$data_list[0][19]."',";
                $sql .= "    '".$data_list[0][20]."',";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.post_no1 ";      //郵便番号1
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.post_no2 ";      //郵便番号2
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address1 ";      //住所１
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address2 ";      //住所２
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    (SELECT ";
                $sql .= "        t_client.address3 ";      //住所３
                $sql .= "    FROM ";
                $sql .= "        t_aorder_h ";
                $sql .= "        INNER JOIN t_client ON t_client.client_id = t_aorder_h.client_id ";
                $sql .= "    WHERE ";
                $sql .= "        t_aorder_h.aord_id = ".$aord_array[$s]."),";

                $sql .= "    NULL,";   //代行伝票の出荷倉庫は代行側なので売上にはNULL
                $sql .= "    '".$data_list[0][22]."',";
                //順路指定判定
                if($data_list[0][23] != NULL){
                    $sql .= "    ".$data_list[0][23].",";
                }else{
                    $sql .= "    NULL,";
                }
                //口座単価(得意先)指定判定
                if($data_list[0][24] != NULL){
                    $sql .= "    ".$data_list[0][24].",";
                }else{
                    $sql .= "    NULL,";
                }
                $sql .= "    '".$data_list[0][25]."',";
                $sql .= "    ".$data_list[0][26].",";
                $sql .= "    '".$data_list[0][27]."',";
                $sql .= "    '".$data_list[0][28]."',";
                //契約区分
                $sql .= "    '".$data_list[0][15]."',";
                $sql .= "    '".$data_list[0][29]."',";
                $sql .= "    ".$_SESSION["staff_id"].",";
                $sql .= "    '".addslashes($_SESSION["staff_name"])."',";
                $sql .= "    $act_id,";     //代行者ID
                $sql .= "    (SELECT client_cd1 FROM t_client WHERE client_id = $act_id),";     //代行者CD1
                $sql .= "    (SELECT client_cd2 FROM t_client WHERE client_id = $act_id),";     //代行者CD2
                $sql .= "    (SELECT client_name FROM t_client WHERE client_id = $act_id),";    //代行者名1
                $sql .= "    (SELECT client_name2 FROM t_client WHERE client_id = $act_id),";   //代行者名2
                $sql .= "    (SELECT client_cname FROM t_client WHERE client_id = $act_id), ";  //代行者名（略称）
                $sql .= "    '".$data_list[0][30]."', ";
                $sql .= "    '".$data_list[0][31]."', ";
                $sql .= "    '".$data_list[0][32]."', ";
                $sql .= "    '".$data_list[0][33]."', ";
                $sql .= ($data_list[0][34] != null) ? "    ".$data_list[0][34].", " : "    null, ";
                $sql .= "    '".$data_list[0][35]."', ";
                if($data_list[0][37] != null){
                    $sql .= "    ".$data_list[0][37].", ";
                    $sql .= "    (SELECT direct_cd FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    '".$data_list[0][38]."', ";
                    $sql .= "    '".$data_list[0][39]."', ";
                    $sql .= "    '".$data_list[0][40]."', ";
                    $sql .= "    (SELECT post_no1 FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    (SELECT post_no2 FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    (SELECT address1 FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    (SELECT address2 FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    (SELECT address3 FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    (SELECT tel FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                    $sql .= "    (SELECT fax FROM t_direct WHERE direct_id = ".$data_list[0][37]."), ";
                }
                $sql .= "    '".$data_list[0][36]."', ";
                if ($data_list[0][41] != null){
                    $sql .= "    ".$data_list[0][41]." \n";     // 前受相殺額合計（2007-06-08 fukuda）
                }else{
                    $sql .= "    NULL \n";
                }

                $sql .= ");";
                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

                /****************************/
                //巡回担当者テーブル登録
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    staff_div,";
                $sql .= "    staff_id,";
                $sql .= "    sale_rate,";
                $sql .= "    staff_name,";
                $sql .= "    course_id ";
                $sql .= "FROM ";
                $sql .= "    t_aorder_staff ";
                $sql .= "WHERE ";
                $sql .= "    aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list3 = Get_Data($result,5);

                for($a=0;$a<count($data_list3);$a++){
                    $sql  = "INSERT INTO t_sale_staff( ";
                    $sql .= "    sale_id,";                         //売上ID
                    $sql .= "    staff_div,";                       //担当者識別
                    $sql .= "    staff_id,";                        //担当者ID
                    $sql .= "    sale_rate,";                       //売上率
                    $sql .= "    staff_name,";                      //担当者名
                    $sql .= "    course_id ";                       //コースID
                    $sql .= "    )VALUES(";
                    $sql .= "    ".$aord_array[$s].",";
                    $sql .= "    '".$data_list3[$a][0]."',";
                    $sql .= "    ".$data_list3[$a][1].",";
                    //売上率指定判定
                    if($data_list3[$a][2] != NULL){
                        $sql .= "    ".$data_list3[$a][2].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list3[$a][3]."',";
                    //コース指定判定
                    if($data_list3[$a][4] != NULL){
                        $sql .= "    ".$data_list3[$a][4];
                    }else{
                        $sql .= "    NULL";
                    }
                    $sql .= ");";
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK;");
                        exit;
                    }
                }

                /****************************/
                //受注データを基に、売上データ作成
                /****************************/
                $sql  = "SELECT ";
                $sql .= "    t_aorder_d.aord_d_id,";        //受注データID0
                $sql .= "    t_aorder_d.line,";             //行1
                $sql .= "    t_aorder_d.sale_div_cd, ";     //販売区分2
                $sql .= "    t_aorder_d.serv_print_flg, ";  //サービス印字3
                $sql .= "    t_aorder_d.serv_id,";          //サービスID4
                $sql .= "    t_aorder_d.set_flg,";          //一式フラグ5
                $sql .= "    t_aorder_d.goods_print_flg, "; //アイテム印字6
                $sql .= "    t_aorder_d.goods_id,";         //アイテムID7
                $sql .= "    t_aorder_d.goods_name,";       //アイテム名8
                $sql .= "    t_aorder_d.num,";              //アイテム数9
                $sql .= "    t_aorder_d.tax_div,";          //課税区分10
                $sql .= "    t_aorder_d.buy_price,";        //仕入単価11
                $sql .= "    t_aorder_d.cost_price,";       //営業単価12
                $sql .= "    t_aorder_d.sale_price,";       //売上単価13
                $sql .= "    t_aorder_d.buy_amount,";       //仕入金額14
                $sql .= "    t_aorder_d.cost_amount,";      //営業金額15
                $sql .= "    t_aorder_d.sale_amount,";      //売上金額16
                $sql .= "    t_aorder_d.rgoods_id,";        //本体ID
                $sql .= "    t_aorder_d.rgoods_name,";      //本体名
                $sql .= "    t_aorder_d.rgoods_num,";       //本体数
                $sql .= "    t_aorder_d.egoods_id,";        //消耗品ID
                $sql .= "    t_aorder_d.egoods_name,";      //消耗品名
                $sql .= "    t_aorder_d.egoods_num,";       //消耗品数
                $sql .= "    t_aorder_d.contract_id,";      //契約情報ID
                $sql .= "    t_aorder_d.account_price,";    //口座単位
                $sql .= "    t_aorder_d.account_rate,";     //口座率

                $sql .= "    t_aorder_d.serv_name, ";       //サービス名
                $sql .= "    t_aorder_d.serv_cd, ";         //サービスCD
                $sql .= "    t_aorder_d.goods_cd, ";        //アイテムCD
                $sql .= "    t_aorder_d.rgoods_cd, ";       //本体CD
                $sql .= "    t_aorder_d.egoods_cd, ";       //消耗品CD
                $sql .= "    t_goods.unit, ";               //商品単位
                $sql .= "    t_aorder_d.g_product_name,";   //商品分類名
                $sql .= "    t_aorder_d.official_goods_name, ";  //正式名
                $sql .= "   t_aorder_d.advance_flg, \n";            // 前受相殺フラグ（2007-06-08 fukuda）
                $sql .= "   t_aorder_d.advance_offset_amount \n";   // 前受相殺額（2007-06-08 fukuda）
                $sql .= "FROM ";
                $sql .= "    t_aorder_d ";
                $sql .= "    LEFT JOIN t_goods ON t_goods.goods_id = t_aorder_d.goods_id ";
                $sql .= "WHERE ";
                $sql .= "   t_aorder_d.aord_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql);
                $data_list2 = Get_Data($result,5);

                for($a=0;$a<count($data_list2);$a++){
/*
                    //アイテムID指定判定
                    if($data_list2[$a][7] != NULL){
                        //商品分類・正式名称取得
                        $sql  = "SELECT ";
                        $sql .= "    t_g_product.g_product_name,";
                        $sql .= "    t_goods.goods_name ";
                        $sql .= "FROM ";
                        $sql .= "    t_g_product ";
                        $sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
                        $sql .= "WHERE ";
                        $sql .= "    t_goods.goods_id = ".$data_list2[$a][7].";";
                        $result = Db_Query($db_con, $sql);
                        $pro_data = NULL;
                        $pro_data = Get_Data($result,3);
                    }
*/

                    $sql  = "INSERT INTO t_sale_d(";
                    $sql .= "    sale_d_id,";         //売上データID
                    $sql .= "    sale_id,";           //売上ID
                    $sql .= "    line,";              //行
                    $sql .= "    sale_div_cd,";       //販売区分CD
                    $sql .= "    serv_print_flg,";    //サービス印字
                    $sql .= "    serv_id,";           //サービスID
                    $sql .= "    set_flg,";           //一式フラグ
                    $sql .= "    goods_print_flg, ";  //アイテム印字
                    $sql .= "    goods_id,";          //アイテムID
                    $sql .= "    goods_name,";        //アイテム名
                    $sql .= "    num,";               //アイテム数
                    $sql .= "    tax_div,";           //課税区分
                    $sql .= "    buy_price,";         //仕入単価
                    $sql .= "    cost_price,";        //営業単価
                    $sql .= "    sale_price,";        //売上単価
                    $sql .= "    buy_amount,";        //仕入金額
                    $sql .= "    cost_amount,";       //営業金額
                    $sql .= "    sale_amount,";       //売上金額
                    $sql .= "    rgoods_id,";         //本体ID
                    $sql .= "    rgoods_name,";       //本体名
                    $sql .= "    rgoods_num,";        //本体数
                    $sql .= "    egoods_id,";         //消耗品ID
                    $sql .= "    egoods_name,";       //消耗品名
                    $sql .= "    egoods_num,";        //消耗品数
                    $sql .= "    aord_d_id,";         //受注データID
                    $sql .= "    contract_id,";       //契約情報ID
                    $sql .= "    account_price,";     //口座単価
                    $sql .= "    account_rate, ";     //口座率
                    $sql .= "    serv_name,";         //サービス名
                    $sql .= "    serv_cd, ";          //サービスCD
                    $sql .= "    goods_cd, ";         //アイテムCD
                    $sql .= "    rgoods_cd,";         //本体CD
                    $sql .= "    egoods_cd, ";        //消耗品CD
                    $sql .= "    unit, ";             //商品単位
                    $sql .= "    g_product_name,";    //商品分類
                    $sql .= "    official_goods_name,";//アイテム名(正式名称)
                    $sql .= "   advance_flg, \n";           // 前受相殺フラグ（2007-06-08 fukuda）
                    $sql .= "   advance_offset_amount \n";  // 前受相殺額（2007-06-08 fukuda）
                    $sql .= ")VALUES(";
                    $sql .= "    ".$data_list2[$a][0].",";
                    $sql .= "    ".$aord_array[$s].",";
                    $sql .= "    '".$data_list2[$a][1]."',";
                    $sql .= "    '".$data_list2[$a][2]."',";
                    $sql .= "    '".$data_list2[$a][3]."',";
                    //サービスID
                    if($data_list2[$a][4] != NULL){
                        $sql .= "    ".$data_list2[$a][4].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list2[$a][5]."',";
                    $sql .= "    '".$data_list2[$a][6]."',";
                    //アイテム商品ID
                    if($data_list2[$a][7] != NULL){
                        $sql .= "    ".$data_list2[$a][7].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list2[$a][8]."',";
                    //アイテム数
                    if($data_list2[$a][9] != NULL){
                        $sql .= "    ".$data_list2[$a][9].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list2[$a][10]."',";
                    $sql .= "    ".$data_list2[$a][12].",";
                    $sql .= "    ".$data_list2[$a][12].",";
                    $sql .= "    ".$data_list2[$a][13].",";
                    $sql .= "    ".$data_list2[$a][15].",";
                    $sql .= "    ".$data_list2[$a][15].",";
                    $sql .= "    ".$data_list2[$a][16].",";
                    //本体商品ID
                    if($data_list2[$a][17] != NULL){
                        $sql .= "    ".$data_list2[$a][17].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list2[$a][18]."',";
                    //本体数
                    if($data_list2[$a][19] != NULL){
                        $sql .= "    ".$data_list2[$a][19].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    //消耗品ID
                    if($data_list2[$a][20] != NULL){
                        $sql .= "    ".$data_list2[$a][20].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list2[$a][21]."',";
                    //消耗品数
                    if($data_list2[$a][22] != NULL){
                        $sql .= "    ".$data_list2[$a][22].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    ".$data_list2[$a][0].",";
                    //契約情報ID
                    if($data_list2[$a][23] != null){
                        $sql .= "    ".$data_list2[$a][23].",";
                    }else{
                        $sql .= "    null, ";
                    }
                    //口座単価 
                    if($data_list2[$a][24] != NULL){  
                        $sql .= "    ".$data_list2[$a][24].",";
                    }else{
                        $sql .= "    NULL,";
                    }
                    $sql .= "    '".$data_list2[$a][25]."',";

                    $sql .= "    '".$data_list2[$a][26]."',";
                    $sql .= "    '".$data_list2[$a][27]."',";
                    $sql .= "    '".$data_list2[$a][28]."',";
                    $sql .= "    '".$data_list2[$a][29]."',";
                    $sql .= "    '".$data_list2[$a][30]."',";
                    $sql .= "    '".$data_list2[$a][31]."',";
                    $sql .= "    '".$data_list2[$a][32]."',";
                    $sql .= "    '".$data_list2[$a][33]."',";
                    $sql .= "   '".$data_list2[$a][34]."', \n";
                    if ($data_list2[$a][35] != null){
                        $sql .= "   ".$data_list2[$a][35]." \n";
                    }else{
                        $sql .= "   NULL \n";
                    }
                    $sql .= ");";
                    $result = Db_Query($db_con, $sql);
                    if($result === false){
                        Db_Query($db_con, "ROLLBACK");
                        exit;
                    }

                    /****************************/
                    //受注の内訳テーブルを基に、売上の内訳テーブル作成
                    /****************************/
/*
                    $sql  = "SELECT ";
                    $sql .= "    aord_d_id,";
                    $sql .= "    line,";
                    $sql .= "    goods_id,";
                    $sql .= "    goods_name,";
                    $sql .= "    num,";
                    $sql .= "    trade_price,";
                    $sql .= "    trade_amount,";
                    $sql .= "    sale_price,";
                    $sql .= "    sale_amount, ";
                    $sql .= "    goods_cd ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_detail ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_d_id = ".$data_list2[$a][0];
                    $result = Db_Query($db_con, $sql);
                    $data_list4 = Get_Data($result,3);

                    for($x=0;$x<count($data_list4);$x++){
                        $sql  = "INSERT INTO t_sale_detail( ";
                        $sql .= "    sale_d_id,";
                        $sql .= "    line,";
                        $sql .= "    goods_id,";
                        $sql .= "    goods_name,";
                        $sql .= "    num,";
                        $sql .= "    trade_price,";
                        $sql .= "    trade_amount,";
                        $sql .= "    sale_price,";
                        $sql .= "    sale_amount,";
                        $sql .= "    goods_cd ";
                        $sql .= "    )VALUES(";
                        $sql .= "    ".$data_list4[$x][0].",";
                        $sql .= "    ".$data_list4[$x][1].",";
                        $sql .= "    ".$data_list4[$x][2].",";
                        $sql .= "    '".$data_list4[$x][3]."',";
                        $sql .= "    ".$data_list4[$x][4].",";
                        $sql .= "    ".$data_list4[$x][5].",";
                        $sql .= "    ".$data_list4[$x][6].",";
                        $sql .= "    ".$data_list4[$x][7].",";
                        $sql .= "    ".$data_list4[$x][8].",";
                        $sql .= "    '".$data_list4[$x][9]."'";
                        $sql .= ");";
                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK");
                            exit;
                        }
                    }
*/
                    /****************************/
                    //受注の出庫品テーブルを基に、売上の出庫品テーブル作成
                    /****************************/
                    $sql  = "SELECT ";
                    $sql .= "    aord_d_id,";
                    $sql .= "    goods_id,";
                    $sql .= "    goods_name,";
                    $sql .= "    num,";
                    $sql .= "    goods_cd ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_ship ";
                    $sql .= "WHERE ";
                    $sql .= "    aord_d_id = ".$data_list2[$a][0].";";
                    $result = Db_Query($db_con, $sql);
                    $data_list5 = Get_Data($result,5);

                    //ログインIDの情報を抽出
/*
                    $sql  = "SELECT";
                    $sql .= "   t_ware.ware_id ";
                    $sql .= " FROM";
                    $sql .= "   t_client LEFT JOIN t_ware ON t_client.ware_id = t_ware.ware_id ";
                    $sql .= " WHERE";
                    $sql .= "   client_id = $shop_id";
                    $sql .= ";";

                    $result = Db_Query($db_con, $sql); 
                    $client_data = Get_Data($result);
                    $ware_id     = $client_data[0][0];        //出荷倉庫ID
*/
                    //拠点倉庫ID
                    $ware_id = Get_ware_id($db_con, Get_Branch_Id($db_con));

                    //受払に登録するデータ取得
                    $sql  = "SELECT ";
                    $sql .= "    t_sale_h.sale_day,";     //巡回日
                    $sql .= "    t_sale_h.sale_no ";      //受注番号
                    $sql .= "FROM ";
                    $sql .= "    t_sale_h ";
                    $sql .= "    INNER JOIN t_sale_d ON t_sale_d.sale_id = t_sale_h.sale_id ";
                    $sql .= "WHERE ";
                    $sql .= "    t_sale_h.sale_id = ".$aord_array[$s].";";
                    $result = Db_Query($db_con, $sql);
                    $stock_data = Get_Data($result);

                    for($c=0;$c<count($data_list5);$c++){
                        $sql  = "INSERT INTO t_sale_ship( ";
                        $sql .= "    sale_d_id,";
                        $sql .= "    goods_id,";
                        $sql .= "    goods_name,";
                        $sql .= "    num,";
                        $sql .= "    goods_cd ";
                        $sql .= "    )VALUES(";
                        $sql .= "    ".$data_list5[$c][0].",";
                        $sql .= "    ".$data_list5[$c][1].",";
                        $sql .= "    '".$data_list5[$c][2]."',";
                        $sql .= "    ".$data_list5[$c][3].",";
                        $sql .= "    '".$data_list5[$c][4]."'";
                        $sql .= ");";
                        $result = Db_Query($db_con, $sql);
                        if($result === false){
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }
                }//売上データ登録おわり

                /****************************/
                //売上IDから紹介料を計算し、仕入テーブルへ登録
                /****************************/
                //紹介料指定判定
                $sql  = "SELECT ";
                $sql .= "    intro_account_id, ";
                $sql .= "    intro_amount, ";
                $sql .= "    intro_ac_div ";
                $sql .= "FROM ";
                $sql .= "    t_sale_h ";
                $sql .= "WHERE ";
                $sql .= "    sale_id = ".$aord_array[$s];
                $sql .= ";";
                $result = Db_Query($db_con, $sql);
            
                $intro_account_id   = pg_fetch_result($result, 0, "intro_account_id");  //紹介者ID
                $intro_amount       = pg_fetch_result($result, 0, "intro_amount");      //紹介料
                $intro_ac_div       = pg_fetch_result($result, 0, "intro_ac_div");      //紹介料区分

                //紹介料区分が発生しないじゃない、紹介料が0より大きい場合、紹介料仕入を登録
                if($intro_account_id != NULL && $intro_amount > 0 && $intro_ac_div != "1"){
                    $result = FC_Intro_Buy_Query($db_con, $aord_array[$s], $data_list[0][13]);
                    if($result === false){
                        //同時実行制御処理
                        $err_message = pg_last_error();
                        $err_format = "t_buy_h_buy_no_key";

                        //仕入番号が重複した場合
                        if(strstr($err_message,$err_format) != false){
                            $error_buy = "以下の伝票は、仕入番号が重複しました。もう一度承認を行ってください。";
                            $error_buy_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }
                }


                /****************************/
                //代行料登録処理
                /****************************/
                //代行料存在判定
                $sql  = "SELECT act_sale_id FROM t_buy_h WHERE act_sale_id = ".$aord_array[$s];
                $result = Db_Query($db_con, $sql.";");
                $aord_count = pg_num_rows($result);
                //存在していなければ登録
                if($aord_count == 0){
                    $sql  = "SELECT ";
                    $sql .= "    act_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_aorder_h ";
                    $sql .= "WHERE ";
                    $sql .= "   aord_id = ".$aord_array[$s];
                    $sql .= ";";
                    $result = Db_Query($db_con, $sql);
                    $shop_data = Get_Data($result);
                    $buy_d_id = FC_Act_Buy_Query($db_con, $aord_array[$s],$shop_data[0][0],$shop_id);
                    if($buy_d_id === false){
                        //同時実行制御処理
                        $err_message = pg_last_error();
                        $err_format = "t_buy_h_buy_no_key";

                        //仕入番号が重複した場合
                        if(strstr($err_message,$err_format) != false){
                            $error_buy = "以下の伝票は、仕入番号が重複しました。もう一度承認を行ってください。";
                            $error_buy_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                             Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }

                }//代行料登録おわり


                // 前受金エラーフラグ
                $advance_err_flg = false;

                // 未来の日付が入力されていないかチェック
                if ($data_list[0][1] > date("Y-m-d")){
                    $err_future_date_msg    = "予定巡回日が未来の日付になっているため以下の伝票を承認できません。";
                    $ary_future_date_no[]   = $data_list[0][0];
                    $advance_err_flg = true;
                } 

                /****************************/
                // 前受相殺用 エラーチェック
                /****************************/
                // 受注ヘッダの前受相殺額合計がある場合
                if ($advance_offset != null){
                    // 現金の場合
                    if ($data_list[0][4] == 61 || $data_list[0][4] == 63 || $data_list[0][4] == 64){
                        $err_trade_advance_msg  = "以下の伝票番号の取引区分が現金売上になっています。<br>";
                        $err_trade_advance_msg .= "前受相殺額のある伝票は取引区分を掛売上に変更してください。";
                        $ary_trade_advance_no[] = $data_list[0][0];
                        $advance_err_flg = true;
                    }
                    // 確定されていない伝票がないかチェック（引数：ord_time, client_id, claim_div）
                    if (Chk_Advance_Fix($db_con, $data_list[0][1], $data_list[0][3], $data_list[0][27]) === false){
                        $err_advance_fix_msg  = "予定巡回日以前に未確定の前受金伝票が存在するため以下の伝票番号を承認できません。<br>";
                        $err_advance_fix_msg .= "前受金確定を行ってください。";
                        $ary_advance_fix_no[] = $data_list[0][0];
                        $advance_err_flg = true;
                    }
                    // 前受相殺額合計 > 前受金残高 かつこれまでに同じ得意先、同じ請求先区分にこのエラーがない場合の場合
                    if ($advance_offset > $advance_balance && $ary_err_client_claim[$data_list[0][3]] != $data_list[0][27]){
                        // エラー
                        $err_paucity_advance_msg  = "確定済の前受金残高が不足しているため以下の伝票番号を承認できません。";
                        $ary_paucity_advance_no[] = $data_list[0][0];
                        $advance_err_flg = true;
                        // エラーのあった得意先、請求先はこのエラーチェックをもう行わないようにする判断のため
                        // 得意先と請求先のペアを変数にセットしておく（array[得意先ID] => 請求先区分）
                        $ary_err_client_claim[$data_list[0][3]] = $data_list[0][27];
                    }
/*
                    //予定巡回日 != 請求日 の場合
                    if ($data_list[0][1] != $data_list[0][2]){
                        $err_day_advance_msg  = "以下の伝票番号は予定巡回日と請求日が異なっています。";
                        $err_day_advance_msg .= "前受相殺額のある伝票は予定巡回日と請求日を一致させて下さい。";
                        $ary_day_advance_no[] = $data_list[0][0];
                        $advance_err_flg = true;
                    }
*/
                    // 次のループへ
                    if ($advance_err_flg == true){
                        continue;
                    }                    
                }

                //現金取引の場合、入金をおこす
                if($data_list[0][4] == "61"){
                    //入金テーブルに「現金入金」
                    $return = FC_Payin_Query($db_con, $aord_array[$s], $data_list[0][3], $data_list[0][8] + $data_list[0][9], $data_list[0][1], $data_list[0][12]);
                    if($return == false){

                        //同時実行制御処理
                        $err_message = pg_last_error();
                        //$err_format = ($_SESSION["group_kind"] == "2") ? "t_payin_no_serial_pkey" : "t_payin_h_pay_no_key";
                        $err_format = "t_payin_no_serial_pkey";

                        //入金番号が重複した場合
                        if(strstr($err_message, $err_format) != false){
                            $error_payin = "以下の伝票は、入金番号が重複しました。もう一度承認を行ってください。";
                            $error_payin_no[$ord_no] = $ord_no;

                            $err_data["confirm_flg"] = false;
                            $form->setConstants($err_data);
                        }else{
                            Db_Query($db_con, "ROLLBACK;");
                            exit;
                        }
                    }
                // 掛の場合
                }else{

                    // 受注ヘッダから取得した前受相殺額合計がある場合
                    if ($advance_offset != null){

                        //入金テーブルに「前受相殺」（後ろの引数2つ：前受相殺額合計、請求先区分）
                        $return = FC_Payin_Query($db_con, $aord_array[$s], $data_list[0][3], $data_list[0][8] + $data_list[0][9], $data_list[0][1], $data_list[0][12], $advance_offset, $data_list[0][27]);
                        if($return == false){
                            //同時実行制御処理
                            $err_message = pg_last_error();
                            //$err_format = ($_SESSION["group_kind"] == "2") ? "t_payin_no_serial_pkey" : "t_payin_h_pay_no_key";
                            $err_format = "t_payin_no_serial_pkey";
                            //入金番号が重複した場合
                            if(strstr($err_message, $err_format) != false){
                                $error_payin = "以下の伝票は、入金番号が重複しました。もう一度承認を行ってください。";
                                $error_payin_no[$ord_no] = $ord_no;

                                $err_data["confirm_flg"] = false;
                                $form->setConstants($err_data);
                            }else{
                                Db_Query($db_con, "ROLLBACK;");
                                exit;
                            }
                        }

                    }

                }//入金登録おわり


            }//承認処理おわり

        }//チェックした受注ID分ループおわり


        //エラーの場合、自画面に遷移しない
        if( $error_buy                  == NULL && 
            $error_payin                == null && 
            $deli_day_renew_err         == NULL && 
            $claim_day_renew_err        == NULL && 
            $claim_day_bill_err         == NULL && 
            $confirm_err                == NULL && 
            $del_err                    == NULL && 
            $cancel_err                 == NULL && 
            $deli_day_act_renew_err     == null && 
            $deli_day_intro_renew_err   == null && 
            $pay_day_act_err            == null && 
            $pay_day_intro_renew_err    == null &&
            $err_trade_advance_msg      == null &&
            $err_future_date_msg        == null &&
            $err_advance_fix_msg        == null &&
            $err_paucity_advance_msg    == null &&
            $err_day_advance_msg        == null
        ){
            //正常

            Db_Query($db_con, "COMMIT;");
//            header("Location: ./2-1-237.php");
        $accept_comp_mess = "承認しました。";       //承認完了メッセージ

        }else{
            //エラー

            Db_Query($db_con, "ROLLBACK;");

            //既に承認
            if($confirm_err_no != NULL){
                while($error_confirm_no = each($confirm_err_no)){
                    $e_confirm_no = $error_confirm_no[0];
                    $confirm_err .= "<br>　　".$e_confirm_no;
                }
            }

            //保留削除
            if($del_err_no != NULL){
                while($error_no = each($del_err_no)){
                    $e_no = $error_no[0];
                    $del_err .= "<br>　　".$e_no;
                }
            }

            //既に取消
            if($cancel_err_no != NULL){
                while($error_cancel_no = each($cancel_err_no)){
                    $e_cancel_no = $error_cancel_no[0];
                    $cancel_err .= "<br>　　".$e_cancel_no;
                }
            }

            //配送日 が前回の月次更新以前
            if($deli_day_renew_err_no != NULL){
                while($error_deli_day_no = each($deli_day_renew_err_no)){
                    $e_deli_day_no = $error_deli_day_no[0];
                    $deli_day_renew_err .= "<br>　　".$e_deli_day_no;
                }
            }

            //請求日 が前回の月次更新以前
            if($claim_day_renew_err_no != NULL){
                while($error_claim_day_renew_no = each($claim_day_renew_err_no)){
                    $e_claim_day_renew_no = $error_claim_day_renew_no[0];
                    $claim_day_renew_err .= "<br>　　".$e_claim_day_renew_no;
                }
            }

            //請求日 に請求書作成済
            if($claim_day_bill_err_no != NULL){
                while($error_claim_day_bill_no = each($claim_day_bill_err_no)){
                    $e_claim_day_bill_no = $error_claim_day_bill_no[0];
                    $claim_day_bill_err .= "<br>　　".$e_claim_day_bill_no;
                }
            }

            //仕入番号が重複
            if($error_buy_no != NULL){
                while($error_buy_no_arr = each($error_buy_no)){
                    $e_buy_no = $error_buy_no_arr[0];
                    $error_buy .= "<br>　　".$e_buy_no;
                }
            }

            //入金番号が重複
            if($error_payin_no != NULL){
                while($error_payin_no_arr = each($error_payin_no)){
                    $e_payin_no = $error_payin_no_arr[0];
                    $error_payin .= "<br>　　".$e_payin_no;
                }
            }

            //代行料の本部月次以前
            if($deli_day_act_renew_err != NULL){
                while($deli_day_act_renew_no = each($deli_day_act_renew_err_no)){
                    $e_buy_no = $deli_day_act_renew_no[0];
                    $deli_day_act_renew_err .= "<br>　　".$e_buy_no;
                }
            }

            //代行料の本部仕入締以前
            if($pay_day_act_err != NULL){
                while($pay_day_act_no = each($pay_day_act_err_no)){
                    $e_buy_no = $pay_day_act_no[0];
                    $pay_day_act_err .= "<br>　　".$e_buy_no;
                }
            }

            //紹介料の本部月次以前
            if($deli_day_intro_renew_err != NULL){
                while($deli_day_intro_renew_no = each($deli_day_intro_renew_err_no)){
                    $e_buy_no = $deli_day_intro_renew_no[0];
                    $deli_day_intro_renew_err .= "<br>　　".$e_buy_no;
                }
            }

            //紹介料の本部仕入締以前
            if($pay_day_intro_renew_err != NULL){
                while($pay_day_intro_renew_no = each($pay_day_intro_renew_err_no)){
                    $e_buy_no = $pay_day_intro_renew_no[0];
                    $pay_day_intro_renew_err .= "<br>　　".$e_buy_no;
                }
            }

/*
            //前受ありで予定巡回日 != 請求日
            if($err_day_advance_msg != NULL){
                while($ary_day_advance_err_no = each($ary_day_advance_no)){
                    $e_buy_no = $ary_day_advance_err_no[1];
                    $err_day_advance_msg .= "<br>　　".$e_buy_no;
                }
            }
*/

        }
    }else{
        //チェックが無い場合はエラー

        $error_msg3 = "承認する伝票が一つも選択されていません。";
        $error_flg = true;
    }

?>
