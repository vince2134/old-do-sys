<?php
/**
 *
 * POSTの取得から登録ボタンが押された判定の前あたりまでのチェック
 *
 * 呼出元
 * ・2-2-107（予定データ訂正）
 * ・2-2-201（手書伝票発行）
 * ・2-2-202（売上伝票訂正）
 * ・2-2-118（予定手書）
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/06/09      その他14    kajioka-h   前受金
 *  2007/07/17      B0702-073   kajioka-h   予定手書伝票発行で作成した伝票を確定後に売上伝票（訂正）で変更すると、訂正理由がなくても変更できるバグ修正
 *  2007/08/28                  kajioka-h   代行伝票で代行料が売上％ので一式○の場合、原価合計額は原価単価と同じにする
 *
 */

/****************************/
//POSTデータ取得
/****************************/
$trade_amount = NULL;                    //営業金額初期化
$sale_amount = NULL;                     //売上金額初期化

//5行分取得その1
for($s=1;$s<=5;$s++){
    $divide[$s]  = $_POST["form_divide"][$s];        //販売区分
    $serv_id[$s] = $_POST["form_serv"][$s];          //サービスID

    $slip_flg[$s] = $_POST["form_print_flg1"][$s];   //サービス印字フラグ1
    if($slip_flg[$s] == NULL){
        $slip_flg[$s] = 'false';
    }else{
        $slip_flg[$s] = 'true';
    }

    $set_flg[$s] = $_POST["form_issiki"][$s];        //一式フラグ1
    if($set_flg[$s] == NULL){
        $set_flg[$s] = 'false';
    }else{
        $set_flg[$s] = 'true';
    }

    //営業原価
    $t_price1[$s] = $_POST["form_trade_price"][$s][1];
    $t_price2[$s] = $_POST["form_trade_price"][$s][2];
    $trade_price[$s] = $t_price1[$s].".".$t_price2[$s];

    //売上単価
    $s_price1[$s] = $_POST["form_sale_price"][$s][1];
    $s_price2[$s] = $_POST["form_sale_price"][$s][2];
    $sale_price[$s] = $s_price1[$s].".".$s_price2[$s];

    //金額計算処理判定
    if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] != null){
    //一式○　数量○の場合、営業金額は、単価×数量。売上金額は、単価×１
        //営業金額
        //代行伝票で代行料が売上％ので一式○の場合、原価合計額は原価単価と同じ
        //　一式○のとき売上単価＝売上合計額で、原価単価＝売上単価×代行料％＝売上合計額×代行料％＝原価合計額
        //　よって、数量１で計算して原価単価＝原価合計額を登録
        if($contract_div != "1" && $_POST["act_div"][0] == "3"){
            $trade_amount[$s] = bcmul($trade_price[$s], 1, 2);
        //それ以外は単価×数量
        }else{
            $trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s], 2);
        }
        //$trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
        if($contract_div == "1"){
            $trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);
        }else{
            $trade_amount[$s] = Coax_Col($daiko_coax, $trade_amount[$s]);
        }

        //売上金額
        $sale_amount[$s] = bcmul($sale_price[$s], 1,2);
        $sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);

    //一式○　数量×の場合、単価×１
    }else if($set_flg[$s] == 'true' && $_POST["form_goods_num1"][$s] == null){
        //営業金額
        $trade_amount[$s] = bcmul($trade_price[$s], 1,2);
        if($contract_div == "1"){
            $trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);
        }else{
            $trade_amount[$s] = Coax_Col($daiko_coax, $trade_amount[$s]);
        }

        //売上金額
        $sale_amount[$s] = bcmul($sale_price[$s], 1,2);
        $sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);

    //一式×　数量○の場合、単価×数量
    }else if($set_flg[$s] == 'false' && $_POST["form_goods_num1"][$s] != null){
        //営業金額
        $trade_amount[$s] = bcmul($trade_price[$s], $_POST["form_goods_num1"][$s],2);
        if($contract_div == "1"){
            $trade_amount[$s] = Coax_Col($coax, $trade_amount[$s]);
        }else{
            $trade_amount[$s] = Coax_Col($daiko_coax, $trade_amount[$s]);
        }

        //売上金額
        $sale_amount[$s] = bcmul($sale_price[$s], $_POST["form_goods_num1"][$s],2);
        $sale_amount[$s] = Coax_Col($coax, $sale_amount[$s]);
    }

    //クリアボタン押下の場合、初期化する為に復元しない
    if($post_flg2 != true){
        //何故か解からないが、セットしてあげないと復元されない。
        $aprice_div[$s] = $_POST["form_aprice_div"][$s][0];                //口座区分
        $con_data2["form_aprice_div[$s]"] = $aprice_div[$s];
    }

    //口座区分判定
    if($aprice_div[$s] == 2){
        //固定金額
        $ac_price[$s] = $_POST["form_account_price"][$s];                 //口座単位
    }else if($aprice_div[$s] == 3){
        //率
        $ac_rate[$s] = $_POST["form_account_rate"][$s];                   //口座率
    }

    //指定無しの場合は、NULL代入
    if($ac_price[$s] == NULL){
        $ac_price[$s] = 'NULL';
    }

    //前受
    $ad_flg[$s] = $_POST["form_ad_offset_radio"][$s];                   //前受相殺フラグ
    if($ad_flg[$s] == "2"){
        $ad_offset_amount[$s] = $_POST["form_ad_offset_amount"][$s];    //前受相殺額
        $ad_offset_total_amount += $ad_offset_amount[$s];
        $ad_offset_flg = true;                                          //前受入力されてるよフラグ
    }

}//5行分取得その1おわり


//代行で受託先の場合、前受入力されているかチェック
if($plan_aord_flg && $contract_div != "1" && $_SESSION["group_kind"] == "3"){
    $sql = "SELECT advance_offset_totalamount FROM t_aorder_h WHERE aord_id = $aord_id;";
    $result = Db_Query($db_con, $sql);
    $ad_offset_flg = (pg_fetch_result($result, 0, "advance_offset_totalamount") != null) ? true : false;
}


$delivery_day_y           = $_POST["form_delivery_day"]["y"];     //配送日
$delivery_day_m           = $_POST["form_delivery_day"]["m"];
$delivery_day_d           = $_POST["form_delivery_day"]["d"];
$delivery_day = $delivery_day_y."-".$delivery_day_m."-".$delivery_day_d;

$request_day_y           = $_POST["form_request_day"]["y"];      //請求日
$request_day_m           = $_POST["form_request_day"]["m"];
$request_day_d           = $_POST["form_request_day"]["d"];
$request_day = $request_day_y."-".$request_day_m."-".$request_day_d;

$claim_data = $_POST["form_claim"];                           //請求先,請求先区分
$c_data = explode(',', $claim_data);
$claim_id = $c_data[0];                                       //請求先ID
$claim_div = $c_data[1];                                      //請求先区分

$note = $_POST["form_note"];                                     //備考

$direct_id              = $_POST["form_direct_select"];         //直送先ID


$intro_account_id       = $_POST["hdn_intro_account_id"];       //紹介口座先ID
$intro_ac_div_arr = array("1", "2", "3", "4");  //紹介口座区分確認用

//初期表示時はDBから、それ以外はPOSTから復元
if((($plan_aord_flg || ($hand_plan_flg && $plan_sale_flg != true)) && $_POST["check_value_flg"] != "t") || (($plan_sale_flg || $hand_slip_flg) && $_POST["intro_ac_div"][0] != null)){
    $intro_ac_div = (in_array($_POST["intro_ac_div"][0], $intro_ac_div_arr)) ? $_POST["intro_ac_div"][0] : "1";   //紹介口座区分
}
$intro_ac_price         = $_POST["intro_ac_price"];             //紹介口座単価
$intro_ac_rate          = $_POST["intro_ac_rate"];              //紹介口座率

$con_data2["intro_ac_div[]"] = $intro_ac_div;
$form->setConstants($con_data2);


if($hand_slip_flg == true || $hand_plan_flg == true){
    $act_id = $_POST["hdn_daiko_id"];                       //代行者ID

    $act_div_arr = array("1", "2", "3");    //代行料区分確認用
    $act_div = in_array($_POST["act_div"][0], $act_div_arr) ? $_POST["act_div"][0] : "1";   //代行料区分
    $act_request_price = $_POST["act_request_price"];       //代行料（固定額）
    $act_request_rate  = $_POST["act_request_rate"];        //代行料（％）
}else{
    $act_id = $_POST["hdn_act_id"];
}


//手書伝票で使う
if($hand_slip_flg == true){
    $ac_staff_id = $_POST["form_ac_staff_select"];  //売上担当者

//手書伝票以外で使う
}else{

    $route  = $_POST["form_route_load"][1];      //順路
    $route .= $_POST["form_route_load"][2];

    //巡回担当チーム
    $staff_check = NULL;                         //重複判定配列
    $staff_rate = NULL;                          //売上率登録用配列

    $staff1 = $_POST["form_c_staff_id1"];        //巡回担当１
    $staff_check[0] = $staff1;
    $rate1 = $_POST["form_sale_rate1"];          //売上率１
    $staff_rate[0] = $rate1;

    $staff2 = $_POST["form_c_staff_id2"];        //巡回担当２
    //入力値がある場合に重複判定配列に代入
    if($staff2 != NULL){
        $staff_check[1] = $staff2;
    }
    $rate2 = $_POST["form_sale_rate2"];          //売上率２
    $staff_rate[1] = $rate2;

    $staff3 = $_POST["form_c_staff_id3"];        //巡回担当３
    //入力値がある場合に重複判定配列に代入
    if($staff3 != NULL){
        $staff_check[2] = $staff3;
    }
    $rate3 = $_POST["form_sale_rate3"];          //売上率３
    $staff_rate[2] = $rate3;

    $staff4 = $_POST["form_c_staff_id4"];        //巡回担当４
    //入力値がある場合に重複判定配列に代入
    if($staff4 != NULL){
        $staff_check[3] = $staff4;
    }
    $rate4 = $_POST["form_sale_rate4"];          //売上率４
    $staff_rate[3] = $rate4;


    $trade_aord = $_POST["trade_aord"];         //取引区分
    $reason = $_POST["form_reason"];            //訂正理由

}


//5行分取得その2
for($s=1;$s<=5;$s++){
    //★受注アイテム
    $goods_item_id[$s] = $_POST["hdn_goods_id1"][$s];                   //商品ID
    //指定判定
    if($goods_item_id[$s] != NULL){

        $goods_item_cd[$s] = $_POST["form_goods_cd1"][$s];              //商品コード
        $goods_item_name[$s] = $_POST["form_goods_name1"][$s];          //商品名（略称）
        $official_goods_name[$s] = $_POST["official_goods_name"][$s];   //商品名（正式）
        $goods_item_num[$s] = $_POST["form_goods_num1"][$s];            //数量
        $goods_item_flg[$s] = $_POST["form_print_flg2"][$s];            //伝票印字フラグ
        if($goods_item_flg[$s] == NULL){
            $goods_item_flg[$s] = 'false';
        }else{
            $goods_item_flg[$s] = 'true';
        }

        $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_item_id[$s].";";
        $result = Db_Query($db_con, $sql);
        $goods_item_com[$s] = pg_fetch_result($result,0,0);          //構成品フラグ

        //構成品判定
        if($goods_item_com[$s] == 'f'){
            //構成品では無い場合、納品フラグをfalse
            $goods_item_deli[$s] = 'false';
        }else{
            //各構成品の商品情報取得
            $sql  = "SELECT ";
            $sql .= "    parts_goods_id ";                       //構成品ID
            $sql .= "FROM ";
            $sql .= "    t_compose ";
            $sql .= "WHERE ";
            $sql .= "    goods_id = ".$goods_item_id[$s].";";
            $result = Db_Query($db_con, $sql);
            $item_parts[$s] = Get_Data($result);

            //各構成品の数量取得
            for($i=0;$i<count($item_parts[$s]);$i++){
                $sql  = "SELECT ";
                $sql .= "    t_goods.goods_name,";
                $sql .= "    t_goods.goods_cname,";
                $sql .= "    t_compose.count ";
                $sql .= "FROM ";
                $sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                $sql .= "WHERE ";
                $sql .= "    t_compose.goods_id = ".$goods_item_id[$s]." ";
                $sql .= "AND ";
                $sql .= "    t_compose.parts_goods_id = ".$item_parts[$s][$i][0].";";
                $result = Db_Query($db_con, $sql);
                $item_parts_name[$s][$i] = pg_fetch_result($result,0,0);    //商品名
                $item_parts_cname[$s][$i] = pg_fetch_result($result,0,1);   //略称
                $parts_num = pg_fetch_result($result,0,2);                  //構成品に対する数量
                $item_parts_num[$s][$i] = $parts_num * $goods_item_num[$s]; //数量
            }
        }
    }else{
        //一式フラグ・アイテム数量のエラー判定の為、入力値を取得
        $goods_item_num[$s] = $_POST["form_goods_num1"][$s];            //数量
        $goods_item_flg[$s] = $_POST["form_print_flg2"][$s];            //伝票印字フラグ
        if($goods_item_flg[$s] == NULL){
            $goods_item_flg[$s] = 'false';
        }else{
            $goods_item_flg[$s] = 'true';
        }
    }

    //★受注本体
    $goods_body_id[$s] = $_POST["hdn_goods_id2"][$s];            //商品ID
    //指定判定
    if($goods_body_id[$s] != NULL){

        $goods_body_cd[$s] = $_POST["form_goods_cd2"][$s];       //商品コード
        $goods_body_name[$s] = $_POST["form_goods_name2"][$s];   //略称
        $goods_body_num[$s] = $_POST["form_goods_num2"][$s];     //数量

    }else{
        //本体商品・数量のエラー判定の為、入力値を取得
        $goods_body_num[$s] = $_POST["form_goods_num2"][$s];     //数量
    }

    //★受注消耗品
    $goods_expend_id[$s] = $_POST["hdn_goods_id3"][$s];          //商品ID
    //指定判定
    if($goods_expend_id[$s] != NULL){

        $goods_expend_cd[$s] = $_POST["form_goods_cd3"][$s];     //商品コード
        $goods_expend_name[$s] = $_POST["form_goods_name3"][$s]; //商品名
        $goods_expend_num[$s] = $_POST["form_goods_num3"][$s];   //数量
        
        $sql = "SELECT compose_flg FROM t_goods WHERE goods_id = ".$goods_expend_id[$s].";";
        $result = Db_Query($db_con, $sql);
        $goods_expend_com[$s] = pg_fetch_result($result,0,0);    //構成品フラグ

        //構成品判定
        if($goods_expend_com[$s] == 'f'){
            //構成品では無い場合、納品フラグをfalse
            $goods_expend_deli[$s] = 'false';
        }else{
            //各構成品の商品情報取得
            $sql  = "SELECT ";
            $sql .= "    parts_goods_id ";                 //構成品ID
            $sql .= "FROM ";
            $sql .= "    t_compose ";
            $sql .= "WHERE ";
            $sql .= "    goods_id = ".$goods_expend_id[$s].";";
            $result = Db_Query($db_con, $sql);
            $expend_parts[$s] = Get_Data($result);

            //各構成品の数量取得
            for($i=0;$i<count($expend_parts[$s]);$i++){
                $sql  = "SELECT ";
                $sql .= "    t_goods.goods_name,";
                $sql .= "    t_goods.goods_cname,";
                $sql .= "    t_compose.count ";
                $sql .= "FROM ";
                $sql .= "    t_compose INNER JOIN t_goods ON t_compose.parts_goods_id = t_goods.goods_id ";
                $sql .= "WHERE ";
                $sql .= "    t_compose.goods_id = ".$goods_expend_id[$s]." ";
                $sql .= "AND ";
                $sql .= "    t_compose.parts_goods_id = ".$expend_parts[$s][$i][0].";";
                $result = Db_Query($db_con, $sql);

                $expend_parts_name[$s][$i] = pg_fetch_result($result,0,0);      //商品名
                $expend_parts_cname[$s][$i] = pg_fetch_result($result,0,1);     //略称
                $parts_num = pg_fetch_result($result,0,2);                      //構成品に対する数量
                $expend_parts_num[$s][$i] = $parts_num * $goods_expend_num[$s]; //数量
            }
        }
    }else{
        //消耗品・数量のエラー判定の為、入力値を取得
        $goods_expend_num[$s] = $_POST["form_goods_num3"][$s];    //数量
    }
}//5行分取得その2おわり


/****************************/
//エラーチェック(addRule)
/****************************/
//配送日
//●必須チェック
$delivery_day_err = ($hand_slip_flg) ? $h_mess[26] : $h_mess[35];
$form->addGroupRule('form_delivery_day', array(
        'y' => array(
                array($delivery_day_err, 'required'),
        ),
        'm' => array(
                array($delivery_day_err, 'required'),
        ),
        'd' => array(
                array($delivery_day_err, 'required'),
        )
));

//契約区分が通常or直営のみ
if($contract_div == '1' || $group_kind == 2){
    //請求日
    //●必須チェック
    $form->addGroupRule('form_request_day', array(
            'y' => array(
                    array($h_mess[25], 'required'),
            ),
            'm' => array(
                    array($h_mess[25],'required'),
            ),
            'd' => array(
                    array($h_mess[25],'required'),
            )
    ));
}

//備考
//●文字数チェック
$form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
$form->addRule("form_note",$h_mess[23],"mb_maxlength","100");


//手書以外の場合にチェック
if($hand_slip_flg != true){
    //取引区分
    //●必須チェック
    $form->addRule('trade_aord',$h_mess[30],'required');

    //訂正理由
    //●必須チェック（予定手書の新規登録時はなし）
    //if($hand_plan_flg != true || $new_entry != "true"){
    //if($hand_plan_flg != true || $aord_id != null){
    if(!($hand_plan_flg == true && $aord_id == null && $plan_sale_flg != true)){
        $form->addRule('form_reason',$h_mess[36],'required');
    }

    //契約区分が通常orＦＣのみ
    if($contract_div == '1' || $group_kind == 3){
        //巡回担当チーム
        //●必須チェック
        //メイン
        $form->addRule('form_c_staff_id1',$h_mess[8],'required');
        $form->addRule('form_sale_rate1',$h_mess[8],'required');

        //サブ１
        //●担当者と売上率が両方入力されているか
        if($staff2 == NULL && $rate2 != NULL){
            $form->addRule('form_c_staff_id2',$h_mess[9],'required');
        }
        if($staff2 != NULL && $rate2 == NULL && ((int)$rate1 + (int)$rate3 + (int)$rate4) != 100){
            $form->addRule('form_sale_rate2',$h_mess[9],'required');
        }

        //サブ２
        //●担当者と売上率が両方入力されているか
        if($staff3 == NULL && $rate3 != NULL){
            $form->addRule('form_c_staff_id3',$h_mess[10],'required');
        }
        if($staff3 != NULL && $rate3 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate4) != 100){
            $form->addRule('form_sale_rate3',$h_mess[10],'required');
        }

        //サブ３
        //●担当者と売上率が両方入力されているか
        if($staff4 == NULL && $rate4 != NULL){
            $form->addRule('form_c_staff_id4',$h_mess[11],'required');
        }
        if($staff4 != NULL && $rate4 == NULL && ((int)$rate1 + (int)$rate2 + (int)$rate3) != 100){
            $form->addRule('form_sale_rate4',$h_mess[11],'required');
        }

        //順路
        //●必須チェック
        //●半角数字チェック
        $form->addGroupRule('form_route_load', array(
                '1' => array(
                        array($h_mess[18], 'required'),
                        array($h_mess[18], 'numeric')
                ),
                '2' => array(
                        array($h_mess[18],'required'),
                        array($h_mess[18], 'numeric')
                ),
        ));
    }
}//手書以外チェックおわり


$input_goods_flg = false;   //商品入力判定フラグ
for($n=1;$n<=5;$n++){

    //入力行判定
    if($divide[$n] != NULL || $slip_flg[$n] == 'true' || $serv_id[$n] != NULL ||$goods_item_flg[$n] == 'true' || $goods_item_id[$n] != NULL || $goods_item_num[$n] != NULL || $set_flg[$n] == 'true' || $t_price1[$n] != NULL || $t_price2[$n] != NULL || $s_price1[$n] != NULL || $s_price2[$n] != NULL || $trade_amount[$n] != NULL || $sale_amount[$n] != NULL || $goods_body_id[$n] != NULL || $goods_expend_id[$n] || $goods_body_num[$n] != NULL || $goods_expend_num[$n] != NULL || $aprice_div[$n] == 2 || $aprice_div[$n] == 3 || $ad_flg[$n] == "2"){
        //販売区分
        //●必須チェック
        $form->addRule("form_divide[$n]",$d_mess[0][$n],'required');

        //サービス・アイテム
        //●必須チェック
        if($serv_id[$n] == NULL && $goods_item_id[$n] == NULL){
            //両方入力していない場合エラー
            $form->addRule("form_serv[$n]",$d_mess[1][$n],'required');
        }else if($serv_id[$n] == NULL && $set_flg[$n] == 'true'){
            if($contract_div == "1"){
                //一式にチェックがあり、サービスが選択されていない場合エラー
                $form->addRule("form_serv[$n]",$d_mess[2][$n],'required');
            }else{
                $form->setElementError("form_serv[$n]", $d_mess[26][$n]);
            }
        }

        //数量・一式
        //●必須チェック
        if($goods_item_num[$n] == NULL && $set_flg[$n] == 'false' && $serv_id[$n] != NULL){
            //サービスが選択されている時に、両方入力していない場合エラー
            $form->addRule("form_goods_num1[$n]",$d_mess[3][$n],'required');
        }

        //営業原価・売上単価
        //●必須チェック
        //●半角数字チェック
        $form->addGroupRule("form_trade_price[$n]", array(
            '1' => array(
                    array($d_mess[5][$n], 'required'),
                    array($d_mess[5][$n], 'numeric')
            ),
            '2' => array(
                    array($d_mess[5][$n],'required'),
                    array($d_mess[5][$n], 'numeric')
            ),
        ));

        $form->addGroupRule("form_sale_price[$n]", array(
            '1' => array(
                    array($d_mess[7][$n], 'required'),
                    array($d_mess[7][$n], 'numeric')
            ),
            '2' => array(
                    array($d_mess[7][$n],'required'),
                    array($d_mess[7][$n], 'numeric')
            ),
        ));

        //口座区分判定
        if($aprice_div[$n] == 2){
            //固定金額
            //●必須チェック
            $form->addRule("form_account_price[$n]",$d_mess[13][$n],'required');
        }else if($aprice_div[$n] == 3){
            //率
            //●必須チェック
            $form->addRule("form_account_rate[$n]",$d_mess[13][$n],'required');
        }

        //商品入力判定フラグ
        $input_goods_flg = true;
    }
}//5行商品入力判定おわり

//アイテム・数量
//●必須チェック
for($n=1;$n<=5;$n++){
    //商品ID指定判定
    if($goods_item_id[$n] != NULL){
        $form->addRule("official_goods_name[$n]", $d_mess[27][$n], 'required'); //アイテム正式名必須チェック
        $form->addRule("form_goods_name1[$n]", $d_mess[28][$n], 'required');    //アイテム略称必須チェック
        $form->addRule("form_goods_num1[$n]",$d_mess[8][$n],'required');        //アイテム数量必須チェック
    }
}

//消耗品・数量
//●必須チェック
for($n=1;$n<=5;$n++){
    //商品ID指定判定
    if($goods_expend_id[$n] != NULL){
        $form->addRule("form_goods_name3[$n]", $d_mess[29][$n], 'required');    //消耗品名必須チェック
        $form->addRule("form_goods_num3[$n]",$d_mess[9][$n],'required');
    }
}

//本体・数量
//●必須チェック
for($n=1;$n<=5;$n++){
    //商品ID指定判定
    if($goods_body_id[$n] != NULL){
        $form->addRule("form_goods_name2[$n]", $d_mess[30][$n], 'required');    //本体商品名必須チェック
        $form->addRule("form_goods_num2[$n]",$d_mess[10][$n],'required');
    }
}


?>
