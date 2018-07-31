<?php

/**
 * 得意先別・仕入先別のクライアント毎の金額・合計・平均を集計
 * 
 * ※注     この関数を使う上での、クエリ作成の注意 <br>    
 *              ��XXX_cdのデータを取得する場合          例.  serv_cd AS cd <br>
 *              ��XXX_nameのデータを取得する場合        例.  serv_name AS name <br>
 *              ��DBにない（必要ない）データを取得する場合  例.  NULL AS rank_cd <br>
 * 
 * 変更履歴
 * 1.0.0 (2007/10/05) 新規作成<br> 
 * 1.1.0 (2007/10/13) テーブルORカラム名の違うデータにも対応 <br>
 * 1.2.0 (2007/10/14) カラム名を共通化（$d_name,$divを使わないように）<br>
 *                    FC・取引先区分コードと名前のカラムを追加 <br>
 * 1.3.0 (2007/10/15) 粗利率の算出処理を追加 <br>
 * 1.3.1 (2007/10/15) 引数を$_POST に変更 <br>
 * 1.3.1 (2007/10/27) htmlspecialcharsをなくした（CSVに出力するため） <br>
 *
 * @author  
 *
 * @param       resource    $result         クエリの実行結果
 * @param       array       $ary_term       画面で入力された検索条件
 *      
 * @return      array       $disp_data      得意先毎の月金額,合計,平均,総合計,総平均を返す。
 *                                      
 */
function Edit_Query_Data ( $result , $ary_term ) {

    //--------------------------//
    //引数のPOSTから値を取得
    //--------------------------//
    $period     = $ary_term["form_trade_ym_e"];    //集計期間
    $out_range  = $ary_term["form_out_range"];     //表示対象
    $margin     = $ary_term["form_margin"];        //粗利率


    //---------------------------//
    // 得意先件数でループする
    //---------------------------// 

    //クライアントの件数を取得
    $count  = pg_num_rows( $result );

    //売上数の表示は画面によって異なるため、
    //d_nameにより判断する

    //クライアント数をカウントする変数 
    $client_count   = 0;     
    for ( $i=0 ; $i < $count ; $i++ ) {
        
        //各行の合計算出用変数の初期化
        $sum_net_amount = 0; 
        $sum_arari_gaku = 0;
        $sum_num = 0;


        //項目毎の情報を格納
        //コード
        $disp_data[$i]["cd"]     = pg_fetch_result($result, $i, "cd");
        //名前
        $disp_data[$i]["name"]   = pg_fetch_result($result, $i, "name");
        //FC・取引先区分コード
        $disp_data[$i]["rank_cd"]= pg_fetch_result($result, $i, "rank_cd");
        //FC・取引先区分名
        $disp_data[$i]["rank_name"]= pg_fetch_result($result, $i, "rank_name");


        //------------------------------------------//
        // 集計期間分ループ（得意先ごとの合計を算出）
        //------------------------------------------//
        for ( $j=0 ; $j < $period ; $j++ ) {
            //金額
            $str        = "net_amount".(string)($j+1);
            $net_amount = pg_fetch_result($result, $i, $str);
            $disp_data[$i]["net_amount"][$j] = $net_amount;     //出力用の配列に格納
            $sum_net_amount     += $net_amount;     //得意先ごとの金額合計を算出
            $total_net_amount[$j]   += $net_amount; //月ごとの金額合計を算出
            
            //粗利額
            $str        = "arari_gaku".(string)($j+1);
            $arari_gaku = pg_fetch_result($result, $i, $str);
            $disp_data[$i]["arari_gaku"][$j] = $arari_gaku; //出力用の配列に格納
            $sum_arari_gaku     += $arari_gaku;     //得意先ごとの粗利額合計を算出
            $total_arari_gaku[$j] += $arari_gaku;   //月ごとの粗利額合計を算出
            
            //粗利率
            $disp_data[$i]["arari_rate"][$j] = Cal_Arari_Rate($net_amount, $arari_gaku, $margin);
    
            //売上数
            $num_name    = "num".(string)($j+1);
            $num         = pg_fetch_result($result, $i, $num_name);
            $disp_data[$i]["num"][$j] = $num;   //出力用の配列に格納
            $sum_num    += $num;    //得意先ごとの売上数合計を算出
            $total_num[$j] += $num; //月ごとの売上数合計を算出
        }


        //-----------------------------------------// 
        // 得意先毎の合計を出力用データ配列に代入 
        //-----------------------------------------//

        //合計金額
        $disp_data[$i]["sum_net_amount"] = $sum_net_amount;
        //平均値（集計期間で割る）
        $ave_net_amount = bcdiv($sum_net_amount, $period, 2);
        $disp_data[$i]["ave_net_amount"] = $ave_net_amount;


        //合計粗利額
        $disp_data[$i]["sum_arari_gaku"] = $sum_arari_gaku;
        //平均値（集計期間で割る）
        $ave_arari_gaku  = bcdiv($sum_arari_gaku, $period, 2);
        $disp_data[$i]["ave_arari_gaku"] = $ave_arari_gaku;


        //合計粗利率
        $disp_data[$i]["sum_arari_rate"] = Cal_Arari_Rate($sum_net_amount, $sum_arari_gaku, $margin);
        //平均粗利率
        $disp_data[$i]["ave_arari_rate"] = Cal_Arari_Rate($ave_net_amount, $ave_arari_gaku, $margin); 


        //合計売上数
        $disp_data[$i]["sum_num"] = $sum_num;
        //平均値（集計期間で割る）
        $disp_data[$i]["ave_num"] = bcdiv($sum_num, $period, 2);
        

        //---------------------------------//
        // 得意先の合計金額が￥0の場合
        //---------------------------------//
        if ( $out_range == "1" AND $sum_net_amount == 0 ) { //出力対象が「金額0以外」の場合 
            unset( $disp_data[$i] );    //$i番目の得意先を配列から削除する
        } else {
            //得意先をカウントする
            $client_count   = $client_count + 1;
            //行番号
            $disp_data[$i]["no"] = $client_count;
        }
    }

    //初期値
    $sum_total_net_amount   = 0;
    $sum_total_arari_gaku   = 0;
    $sum_total_num          = 0;
    //配列要素が0でない場合
    if ( count($disp_data) != 0 ) {
        //金額の総合計
        $sum_total_net_amount   = array_sum( $total_net_amount );
        //粗利額の総合計
        $sum_total_arari_gaku   = array_sum( $total_arari_gaku );
        //売上数の総合計
        $sum_total_num          = array_sum( $total_num );
    }


    //----------------------------------------------//
    // テーブル合計行の編集($disp_dataの最後に追加)
    //----------------------------------------------//
    
    /*** 店舗数を格納 ***/
    $disp_data[$i]["total_count"] = $client_count;
    

    /*** 売上or仕入金額 ***/
    //月ごとの総合計額を格納
    $disp_data[$i]["total_net_amount"]  = $total_net_amount;
    //総合計値を取得
    $disp_data[$i]["sum_net_amount"]    = $sum_total_net_amount;
    //総合計値の月平均
    $ave_total_net_amount               = bcdiv($sum_total_net_amount, $period, 2);
    $disp_data[$i]["ave_net_amount"]    = $ave_total_net_amount;

    
    /*** 粗理額 ***/
    //月ごとの粗利額合計を格納
    $disp_data[$i]["total_arari_gaku"]  = $total_arari_gaku;
    //粗利額の総合計値を取得
    $disp_data[$i]["sum_arari_gaku"]    = $sum_total_arari_gaku;
    //粗利額の総平均を取得
    $ave_total_arari_gaku               = bcdiv($sum_total_arari_gaku, $period, 2);
    $disp_data[$i]["ave_arari_gaku"]    = $ave_total_arari_gaku;


    /*** 粗利率 ***/
    for ( $int=0; $int < $period; $int++ ) {
        //月ごとの総合計と月ごとの総粗利額
        $disp_data[$i]["total_arari_rate"][$int] = 
            Cal_Arari_Rate($total_net_amount[$int], $total_arari_gaku[$int], $margin);
    }
    //総合計と総粗利額
    $disp_data[$i]["sum_arari_rate"] =
            Cal_Arari_Rate($sum_total_net_amount, $sum_total_arari_gaku, $margin);
    //総平均と総粗利平均
    $disp_data[$i]["ave_arari_rate"] = 
            Cal_Arari_Rate($ave_total_net_amount, $ave_total_arari_gaku, $margin);

    /*** 売上数 ***/
    //月ごとの売上数合計を格納
    $disp_data[$i]["total_num"] = $total_num;
    //売上数の月合計が格納されている配列から、合計値を取得
    $disp_data[$i]["sum_num"]   = $sum_total_num;
    //合計行の月平均を取得
    $disp_data[$i]["sum"]["ave_num"] = bcdiv($sum_total_num, $period, 2);
    

    //配列の添え字を振りなおす
    $disp_data  = array_values( $disp_data );


//    print_array($disp_data);
    //戻り値
    return $disp_data;
}



/**
 * ほげほげ別ぴよぴよ別の小計・合計・平均を集計
 *
 * ※注     この関数を使う上での、クエリ作成の注意 <br>
 *              �’箴綽瑤鯢充┐靴覆げ萍未任眦呂靴討�        例.  NULL AS num <br>
 *              ��担当者別の場合、担当者コードはstaff_cd    例.  charge_cd AS staff_cd <br>
 *
 *
 * @author      kj<kj@bhsk.co.jp>
 *
 * @param       resource    $result         クエリの実行結果
 * @param       array       $ary_term       画面で入力された検索条件、もしくはPOST <br>
 *                                          集計期間（form_trade_ym_e）、表示対象（form_out_range）、粗利率（form_margin）が必要
 *
 * @return      array       $disp_data      ほげほげ毎の小計金額、合計、平均と総合計、総平均を配列にくっつけて返す。 <br>
 *                                          その他のデータ <br>
 *                                          ・$disp_data[$i]["rowspan"]：ほげほげ別のrowspanに使う　くっつかれている行はnull <br>
 *                                          ・$disp_data[$i]["sub_flg"]："true"の場合は小計の行 <br>
 *                                              通常行は 奇数行 "1"  偶数行 "2" <br>
 *
 */
/*
 * 履歴：
 *  日付            B票No.      担当者      内容
 *  -----------------------------------------------------------
 *  2007/11/03                  kajioka-h   新規作成
 *  2007/11/04                  aizawa-m    ぴよぴよ毎に「FC・取引先コード」と「FC・取引先名」を追加
 *  2007/11/10                  kajioka-h   ほげに金額0のぴよが1件の場合におかしくなるバグ修正
 *
 */
function Edit_Query_Data_Hogepiyo($result ,$ary_term){

/*
$aaa = pg_fetch_all($result);
print_array($aaa);
*/
    //--------------------------//
    //引数のPOSTから値を取得
    //--------------------------//
    $period     = $ary_term["form_trade_ym_e"];    //集計期間
    $out_range  = $ary_term["form_out_range"];     //表示対象
    $margin     = $ary_term["form_margin"];        //粗利率

// debug
$start = microtime();

    //---------------------------//
    // データ件数でループする
    //---------------------------//

    //クエリの件数を取得
    $count = pg_num_rows($result );

    $rowspan    = 0;    //ほげほげのrowspan
    $no         = 1;    //行No.
    $data_num   = 0;    //合計行に表示する
    $class_num  = "2";  //行に指定するClassのResult番号


    // debug
    $hp_start = microtime();
    for ( $i=0, $ary_line=0 ; $i <= $count ; $i++ ) {

        //各行の合計算出用変数の初期化
        $sub_net_amount = 0;    //月合計の売上金額
        $sub_arari_gaku = 0;    //月合計の粗利額
        $sub_num = 0;           //月合計の売上数

        //ほげほげコード
        //最後の小計以外
        if($i < $count){
            $first_column_cd = pg_fetch_result($result, $i, "cd");
        }


        //1行目の場合、ほげほげが変わってないかチェック用変数セット
        if($i == 0){
            $pre_first_column_cd = $first_column_cd;
        }

        //前の行と変わった、またはデータがなくなった（最後の小計用）場合、小計を配列に入れる
        if(($first_column_cd != $pre_first_column_cd || $i == $count) && $rowspan != 0){

            #hashimoto-y
            /*
            echo "通過：" .$no ."<br>";
            echo $i ."<br>";
            echo $first_column_cd ."<br>";
            echo $pre_first_column_cd ."<br>";
            echo $count ."<br>";
            echo $rowspan ."<br>";
            */

            // debug
            $hp2_start = microtime();
            //------------------------------------------//
            // 集計期間分ループ（ほげぴよごとの合計を算出）
            //------------------------------------------//
            for ( $j=0 ; $j < $period ; $j++ ) {

                //小計金額
                $disp_data[$data_num]["net_amount"][$j] = $sub_total_net_amount[$j];
                //小計月合計
                $sub_net_amount += $sub_total_net_amount[$j];

                //小計粗利額
                $disp_data[$data_num]["arari_gaku"][$j] = $sub_total_arari_gaku[$j];
                //小計月合計
                $sub_arari_gaku += $sub_total_arari_gaku[$j];

                //小計粗利率
                $disp_data[$data_num]["arari_rate"][$j] = Cal_Arari_Rate($sub_total_net_amount[$j], $sub_total_arari_gaku[$j], $margin);
                //小計売上数
                $disp_data[$data_num]["num"][$j]        = $sub_total_num[$j];
                //小計月合計
                $sub_num += $sub_total_num[$j];

            }

            //小計月合計
            //売上金額
            $disp_data[$data_num]["sum_net_amount"] = $sub_net_amount;
            //粗利金額
            $disp_data[$data_num]["sum_arari_gaku"] = $sub_arari_gaku;
            //粗利率
            $disp_data[$data_num]["sum_arari_rate"] = Cal_Arari_Rate($sub_net_amount, $sub_arari_gaku, $margin);
            //売上数
            $disp_data[$data_num]["sum_num"] = $sub_num;

            //小計月平均
            //売上金額
            $sub_ave_net_amount = bcdiv($sub_net_amount, $period, 2);
            $disp_data[$data_num]["ave_net_amount"] = $sub_ave_net_amount;
            //粗利金額
            $sub_ave_arari_gaku = bcdiv($sub_arari_gaku, $period, 2);
            $disp_data[$data_num]["ave_arari_gaku"] = $sub_ave_arari_gaku;
            //粗利率
            $disp_data[$data_num]["ave_arari_rate"] = Cal_Arari_Rate($sub_ave_net_amount, $sub_ave_arari_gaku, $margin);
            //売上数
            $disp_data[$data_num]["ave_num"] = bcdiv($sub_num, $period, 2);


            //小計フラグ
            $disp_data[$data_num]["sub_flg"]    = "true";

            //rowspan
            $disp_data[$data_num - $rowspan]["rowspan"]    = $rowspan + 1;
            $disp_data[$data_num]["rowspan"]    = null;

            //rowspan を初期化
            $rowspan = 0;

            //行番号をカウントアップ
            $no++;

            //配列の添字をカウントアップ
            $data_num++;

            //Classに指定するResult番号初期化
            $class_num = "2";

            //各行の合計算出用変数の初期化
            $sub_net_amount = 0;
            $sub_arari_gaku = 0;
            $sub_num        = 0;

            //ほげほげぴよぴよごとの月合計を初期化
            $sub_total_net_amount   = array();
            $sub_total_arari_gaku   = array();
            $sub_total_num          = array();

        }
        
        //データがあるうちは（最後の小計以外）ほげほげぴよぴよ計算
        if($i < $count){

            //項目毎の情報を格納

            //行No.
            $disp_data[$data_num]["no"]        = $no;

            //ほげほげコード
            $disp_data[$data_num]["cd"]     = $first_column_cd;
            //ほげほげ名前
            $first_column_name  = pg_fetch_result($result, $i, "name");
            $disp_data[$data_num]["name"]   = $first_column_name;

            //ぴよぴよコード
            $second_column_cd   = pg_fetch_result($result, $i, "cd2");
            $disp_data[$data_num]["cd2"]    = $second_column_cd;
            //ぴよぴよ名前
            $second_column_name = pg_fetch_result($result, $i, "name2");
            $disp_data[$data_num]["name2"]  = $second_column_name;

            // aizwa-m追加
            //ぴよぴよFC・取引先コード
            $second_rank_cd     = pg_fetch_result($result, $i, "rank_cd");
            $disp_data[$data_num]["rank_cd"]    = $second_rank_cd;
    
            // aizawa-m追加
            //ぴよぴよFC・取引先名
            $second_rank_name   = pg_fetch_result($result, $i, "rank_name");
            $disp_data[$data_num]["rank_name"]  = $second_rank_name;
        

            //------------------------------------------//
            // 集計期間分ループ（ほげほげぴよぴよごとの合計を算出）
            //------------------------------------------//
            for ( $j=0 ; $j < $period ; $j++ ) {
                //金額
                $str        = "net_amount".(string)($j+1);
                $net_amount = pg_fetch_result($result, $i, $str);
                $disp_data[$data_num]["net_amount"][$j] = $net_amount;     //出力用の配列に格納
                $sub_net_amount             += $net_amount;     //ほげほげぴよぴよごとの月合計を算出
                $sub_total_net_amount[$j]   += $net_amount;     //ほげほげごとの月ごとの合計を算出（小計用）
                $total_net_amount[$j]       += $net_amount;     //月ごとの合計を算出（最終合計用）

                //粗利額
                $str        = "arari_gaku".(string)($j+1);
                $arari_gaku = pg_fetch_result($result, $i, $str);
                $disp_data[$data_num]["arari_gaku"][$j] = $arari_gaku; //出力用の配列に格納
                $sub_arari_gaku             += $arari_gaku;     //ほげほげぴよぴよごとの月合計を算出
                $sub_total_arari_gaku[$j]   += $arari_gaku;     //ほげほげごとの月ごとの合計を算出（小計用）
                $total_arari_gaku[$j]       += $arari_gaku;     //月ごとの合計を算出（最終合計用）

                //粗利率
                $disp_data[$data_num]["arari_rate"][$j] = Cal_Arari_Rate($net_amount, $arari_gaku, $margin);

                //売上数
                $num_name    = "num".(string)($j+1);
                $num         = pg_fetch_result($result, $i, $num_name);
                $disp_data[$data_num]["num"][$j] = $num;   //出力用の配列に格納
                $sub_num            += $num;    //ほげほげぴよぴよごとの月合計を算出
                $sub_total_num[$j]  += $num;    //ほげほげごとの月ごとの合計を算出（小計用）
                $total_num[$j]      += $num;    //月ごとの合計を算出（最終合計用）
            }

            // debug
            $hp2_end = microtime();

            //-----------------------------------------//
            // ほげほげぴよぴよ毎の合計を出力用データ配列に代入
            //-----------------------------------------//

            //月合計売上金額
            $disp_data[$data_num]["sum_net_amount"] = $sub_net_amount;
            //月平均売上金額
            $ave_net_amount = bcdiv($sub_net_amount, $period, 2);
            $disp_data[$data_num]["ave_net_amount"] = $ave_net_amount;


            //月合計粗利額
            $disp_data[$data_num]["sum_arari_gaku"] = $sub_arari_gaku;
            //月平均粗利額
            $ave_arari_gaku  = bcdiv($sub_arari_gaku, $period, 2);
            $disp_data[$data_num]["ave_arari_gaku"] = $ave_arari_gaku;


            //月合計粗利率
            $disp_data[$data_num]["sum_arari_rate"] = Cal_Arari_Rate($sub_net_amount, $sub_arari_gaku, $margin);
            //月平均粗利率
            $disp_data[$data_num]["ave_arari_rate"] = Cal_Arari_Rate($ave_net_amount, $ave_arari_gaku, $margin);


            //---------------------------------//
            // ほげほげぴよぴよの月合計金額が￥0の場合
            //---------------------------------//
            //出力対象が「金額0以外」の場合
            if ( $out_range == "1" AND $sub_net_amount == 0 ) {
                unset( $disp_data[$data_num] );     //$data_num番目のほげほげぴよぴよを配列から削除する

            } else {
                //月合計売上数
                $disp_data[$data_num]["sum_num"] = $sub_num;
                //月平均売上数
                $disp_data[$data_num]["ave_num"] = bcdiv($sub_num, $period, 2);

                //小計フラグ
                $class_num = ($class_num == "1") ? "2" : "1";
                $disp_data[$data_num]["sub_flg"]    = $class_num;

                //rowspan
                $rowspan++;
                $disp_data[$data_num]["rowspan"]    = null;

                //配列の添字をカウントアップ
                $data_num++;

            }

            //比較用ほげほげコードを置換
            $pre_first_column_cd = $first_column_cd;

        }

    }
    // debug 
    $hp_end = microtime();

    //初期値
    $sum_total_net_amount   = 0;
    $sum_total_arari_gaku   = 0;
    $sum_total_num          = 0;

    //配列要素が0の場合
    if ( count($disp_data) == 0 ) {
        //総合計用のダミー配列を作る
        for ( $j=0 ; $j < $period ; $j++ ) {
            $total_net_amount[$j] = 0;
            $total_arari_gaku[$j] = 0;
            $total_num[$j]        = 0;
        }
    }

    //月ごとの金額の総合計
    $sum_total_net_amount   = array_sum( $total_net_amount );
    //月ごとの粗利額の総合計
    $sum_total_arari_gaku   = array_sum( $total_arari_gaku );
    //月ごとの売上数の総合計
    $sum_total_num          = array_sum( $total_num );


    //----------------------------------------------//
    // テーブル合計行の編集($disp_dataの最後に追加)
    //----------------------------------------------//

    //ほげほげ件数を格納
    $disp_data[$data_num]["total_count"] = $no - 1;


    //売上or仕入金額
    //月ごとの総合計額を格納
    $disp_data[$data_num]["total_net_amount"]   = $total_net_amount;
    //総合計値を取得
    $disp_data[$data_num]["sum_net_amount"]     = $sum_total_net_amount;
    //総合計値の月平均
    $ave_total_net_amount                       = bcdiv($sum_total_net_amount, $period, 2);
    $disp_data[$data_num]["ave_net_amount"]     = $ave_total_net_amount;


    //粗利額
    //月ごとの粗利額合計を格納
    $disp_data[$data_num]["total_arari_gaku"]   = $total_arari_gaku;
    //粗利額の総合計値を取得
    $disp_data[$data_num]["sum_arari_gaku"]     = $sum_total_arari_gaku;
    //粗利額の総平均を取得
    $ave_total_arari_gaku                       = bcdiv($sum_total_arari_gaku, $period, 2);
    $disp_data[$data_num]["ave_arari_gaku"]     = $ave_total_arari_gaku;


    //粗利額
    for ( $int=0; $int < $period; $int++ ) {
        //月ごとの総合計と月ごとの総粗利額
        $disp_data[$data_num]["total_arari_rate"][$int] =
            Cal_Arari_Rate($total_net_amount[$int], $total_arari_gaku[$int], $margin);
    }
    //総合計と総粗利額
    $disp_data[$data_num]["sum_arari_rate"] =
            Cal_Arari_Rate($sum_total_net_amount, $sum_total_arari_gaku, $margin);
    //総平均と総粗利平均
    $disp_data[$data_num]["ave_arari_rate"] =
            Cal_Arari_Rate($ave_total_net_amount, $ave_total_arari_gaku, $margin);


    //売上数
    //月ごとの売上数合計を格納
    $disp_data[$data_num]["total_num"] = $total_num;
    //売上数の月合計が格納されている配列から、合計値を取得
    $disp_data[$data_num]["sum_num"]   = $sum_total_num;
    //合計行の月平均を取得
    $disp_data[$data_num]["sum"]["ave_num"] = bcdiv($sum_total_num, $period, 2);


    //配列の添え字を振りなおす
    $disp_data  = array_values( $disp_data );

$end = microtime();

/*
$hp_start   = Cnt_Microtime($hp_start);
$hp_end     = Cnt_Microtime($hp_end);
$hp2_start  = Cnt_Microtime($hp2_start);
$hp2_end    = Cnt_Microtime($hp2_end);
$start  = Cnt_Microtime($start);
$end    = Cnt_Microtime($end);

echo "ほげ集計ループ：".($hp_end-$hp_start);
echo "<br>";
echo "ほげほげぴよぴよ集計ループ：".($hp2_end-$hp2_start);
echo "<br>";
echo "集計全体:".($end-$start);
echo "<br>";
*/

//print_array($disp_data);
    //戻り値
    return $disp_data;
}



/**
 * 粗利率を計算する関数 
 *      
 * 変更履歴
 * 2007-10-16   aizawa-m    新規作成 <br>
 * 2007-10-28   aizawa-m    売上金額と粗利額の計算を絶対値で行うように変更 <br>
 *
 * @param   int     $net_amount     売上金額
 * @param   int     $arari_gaku     粗利益額
 * @param   string  $margin         粗利率の表示：default"1"=表示、"2"=非表示
 *
 * @return  int     $arari_rate     粗利率(非表示の場合はNULL)
 *
 */
function Cal_Arari_Rate ($net_amount, $arari_gaku, $margin="1") {

    //非表示の場合
    if ( $margin == "2" ) {
        return NULL;
    }
    // 売上金額 または 粗利益額が￥0の場合
    else if ($net_amount == 0 OR $arari_gaku == 0 ) {
        return 0;     //そのまま0を返す
    }
    else {
        // 粗利益額÷売上金額×100 を四捨五入
        $arari_rate = round( (abs($arari_gaku)/abs($net_amount)) * 100 ); 

        // 売上金額か粗利益額のどちらかが0より小さい場合
        if ( ($net_amount > 0 AND $arari_gaku < 0) OR 
                ($net_amount < 0 AND $arari_gaku > 0) ) {
            $arari_rate = $arari_rate * - 1;    // 粗利率をマイナスにする
        }

        return $arari_rate;
    }
}

/*
 * (仮)DEBUG用 microtime() 編集関数
 *
 * マイクロ秒と秒数を足した数を返す
 *
 */
function Cnt_Microtime($micro_time){

    $arr    = explode(" ", $micro_time);

    $second = (float)$arr[0]+(float)$arr[1];

    return $second;

}


?>
