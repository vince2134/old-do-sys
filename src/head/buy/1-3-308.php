<?php

/*
 * 新規作成
 *　日付：2007/06/14　担当者：aizawa-m　　　本部：締期間中の仕入・支払の明細を表示する
 *
 * 変更
 *　日付　　　　担当者　　　内容
 *　2007/06/14　aizawa_m　　金額のものは、負数の場合全て赤文字
 *  2007-07-12  fukuda      「支払締」を「仕入締」に変更
 *
 */

$page_title = "支払明細";   //本部ですよ

//環境設定ファイル
require_once("ENV_local.php");


//************************************************//
//	    -----------QuickForm-------------
//************************************************//

$form = new HTML_QuickForm("dateForm","POST");


/**********************************/
//DB接続   
/**********************************/
$con    = Db_Connect("");
//$con    = Db_Connect("aizawa");


/**********************************/
//支払予定データ取得用変数   
/**********************************/
//セッションのショップID
$shop_id    = $_SESSION["client_id"];
//GET値を格納
$schedule_payment_id    = $_GET["pay_id"];  //支払予定ID
$client_id              = $_GET["c_id"];    //仕入先ID
//システム開始日
$s_system_day   = START_DAY;

//GET値の数値チェック（数値でない場合はTOP画面へ）
Get_Id_Check3( array( $schedule_payment_id  , $client_id ) );


/**********************************/
//前回の締日と今回の締日を抽出   
/**********************************/
//クエリ作成 -支払予定テーブル-
$s_sql =    "SELECT "."\n";
$s_sql.=    "   payment_close_day "."\n";   //仕入締日
$s_sql.=    "FROM "."\n";
$s_sql.=    "   t_schedule_payment "."\n";
$s_sql.=    "WHERE "."\n";
$s_sql.=    "   client_id = ".$client_id."\n" ;
$s_sql.=    "AND "."\n";
$s_sql.=    "   shop_id = ".$shop_id."\n" ;
$s_sql.=    "AND "."\n" ;
$s_sql.=    "   (   SELECT "."\n";          //GETで受け取った支払予定IDの仕入締日を抽出
$s_sql.=    "           payment_close_day "."\n" ;
$s_sql.=    "       FROM "."\n" ;
$s_sql.=    "           t_schedule_payment "."\n" ;
$s_sql.=    "       WHERE "."\n" ;
$s_sql.=    "           schedule_payment_id = ".$schedule_payment_id."\n" ;
$s_sql.=    "   ) "."\n" ;
$s_sql.=    "   >=  payment_close_day "."\n" ;
$s_sql.=    "ORDER BY payment_close_day DESC"."\n";
$s_sql.=    "LIMIT 2"."\n";     //2行（今回と前回）
$s_sql.=    "OFFSET 0"."\n";    //先頭から
$s_sql.=    ";";

//クエリ実行
$ret_s_sql  = Db_Query( $con , $s_sql );

//echo nl2br($s_sql); 
//クエリ結果件数
$max    = pg_num_rows( $ret_s_sql );

//---検索結果が0件の場合---//
if ( $max == 0 ) {
    //TOP画面へ遷移
    header( "location: ../top.php" );
}

//クエリ結果を配列で取得
for ( $i=0; $i < $max ; $i++ ) {
    //連想配列で仕入締日を取得
    $arr_close_day  = pg_fetch_array( $ret_s_sql , $i );       
    //仕入締日
    $close_day[$i]    = $arr_close_day['payment_close_day'];
}

//---ｸｴﾘ結果が1件の場合---//
if ( $max == 1 ) {
    //前回の仕入締日をシステム開始日に設定
    $close_day[$i]  = $s_system_day;   
}

//print_array( $close_day);


/**********************************/
//支払予定テーブルデータを抽出   
/**********************************/
//クエリ作成
$p_sql =    "SELECT "."\n";
$p_sql.=    "   last_account_payable ,"."\n" ;      //前回買掛残高
$p_sql.=    "   payment , "."\n" ;                  //今回支払額
$p_sql.=    "   rest_amount ,"."\n" ;               //繰越額
$p_sql.=    "   sale_amount ,"."\n" ;               //今回仕入額
$p_sql.=    "   tax_amount ,"."\n" ;                //今回消費税額
$p_sql.=    "   account_payable ,"."\n" ;           //今回仕入額（税込）
$p_sql.=    "   ca_balance_this ,"."\n" ;           //今回買掛残高（税込）
$p_sql.=    "   schedule_of_payment_this ,"."\n" ;  //今回支払予定額
$p_sql.=    "   payment_expected_date ,"."\n" ;     //支払予定日
$p_sql.=    "   client_cname , "."\n" ;             //仕入先名(略称)
$p_sql.=    "   client_cd1 , "."\n" ;               //仕入先コード1
$p_sql.=    "   client_cd2 ,"."\n" ;                //仕入先コード2
$p_sql.=    "   tax_div "."\n" ;                    //消費税（課税単位）
$p_sql.=    "FROM "."\n";   
$p_sql.=    "   t_schedule_payment "."\n" ;
$p_sql.=    "WHERE "."\n";
$p_sql.=    "   schedule_payment_id = ".$schedule_payment_id."\n" ;
$p_sql.=    ";";

//クエリ実行
$ret_pay    = Db_Query( $con , $p_sql );

//---クエリのエラー判定---//
if ( !$ret_pay ) {
    exit();
}

//---検索結果が0件の場合---//
if ( pg_num_rows( $ret_pay ) == 0 ) {
        //Top画面へ遷移
        header( "location: ../top.php" );
}

//クエリ結果を配列で取得
$arr_pay    = pg_fetch_array( $ret_pay , 0 );

//支払予定テーブルデータを配列に格納 (負数赤文字対応）
$pay_data[0]    = Numformat_Ortho( $arr_pay["last_account_payable"] );//前回買掛残高
$pay_data[1]    = Numformat_Ortho( $arr_pay["payment"] );             //今回支払額
$pay_data[2]    = Numformat_Ortho( $arr_pay["rest_amount"] );         //繰越額
$pay_data[3]    = Numformat_Ortho( $arr_pay["sale_amount"] );         //今回仕入額
$pay_data[4]    = Numformat_Ortho( $arr_pay["tax_amount"] );          //今回消費税額
$pay_data[5]    = Numformat_Ortho( $arr_pay["account_payable"] );     //今回仕入額（税込）
$pay_data[6]    = Numformat_Ortho( $arr_pay["ca_balance_this"] );     //今回買掛残高（税込）
$pay_data[7]    = Numformat_Ortho( $arr_pay["schedule_of_payment_this"] ); //今回支払予定額
$pay_data[8]    = $arr_pay["payment_expected_date"];                //支払予定日
$pay_data[9]    = Change_Html( $arr_pay["client_cname"] );          //仕入先名（略称）
$pay_data[10]   = $arr_pay["client_cd1"];                           //仕入先コード1
$pay_data[11]   = $arr_pay["client_cd2"];                           //仕入先コード2         
$tax_div        = $arr_pay['tax_div'];                              //消費税（課税単位）


/**********************************/
//支払明細抽出のクエリの作成   
/**********************************/
//クエリ作成
$sql =  "SELECT "."\n" ;
$sql.=  "   t_payout_h.pay_day ,"."\n" ;        //支払日
$sql.=  "   t_payout_h.pay_no  ,"."\n" ;        //支払番号
$sql.=  "   (   SELECT trade_cname "."\n" ;     //取引区分名
$sql.=  "       FROM t_trade "."\n" ; 
$sql.=  "       WHERE t_trade.trade_id = t_payout_d.trade_id ) AS trade_name ,"."\n" ;
$sql.=  "   (   CASE t_payout_d.trade_id "."\n" ;
$sql.=  "           WHEN '41' THEN '支払（現金）' "."\n" ;
$sql.=  "           WHEN '43' THEN '支払（振込）' "."\n" ;
$sql.=  "           WHEN '44' THEN '支払（手形）' "."\n" ;
$sql.=  "           WHEN '45' THEN '相殺' "."\n" ;
$sql.=  "           WHEN '46' THEN '調整' "."\n" ;
$sql.=  "           WHEN '47' THEN '支払（その他）' "."\n" ;
$sql.=  "           WHEN '48' THEN '手数料' "."\n" ;
$sql.=  "           ELSE '' "."\n";
$sql.=  "       END ";
$sql.=  "   ) AS goods_name , "."\n" ; 
$sql.=  "   NULL AS count ,"."\n" ;
$sql.=  "   NULL AS price ,"."\n" ;
$sql.=  "   NULL AS amount ,"."\n" ;
$sql.=  "   NULL AS tax_div ,"."\n" ;
$sql.=  "   t_payout_d.pay_amount ,"."\n" ;     //支払金額
$sql.=  "   NULL AS line ,"."\n" ;
$sql.=  "   1 AS div "."\n" ;   //支払の場合は"1"
$sql.=  "FROM "."\n" ;
$sql.=  "   t_payout_h , t_payout_d "."\n" ;
$sql.=  "WHERE "."\n" ;
$sql.=  "       t_payout_h.pay_id = t_payout_d.pay_id "."\n" ;
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.pay_day > '".$close_day[1]."' \n"; 
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.pay_day  <= '".$close_day[0]."' \n" ;
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.shop_id = ".$shop_id."\n" ;
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.client_id = ".$client_id."\n" ;
$sql.=  "   AND " ;
$sql.=  "       t_payout_h.renew_flg = 't' "."\n";      //日次更新済み
$sql.=  "   AND "."\n";
$sql.=  "       t_payout_h.buy_id IS NULL "."\n" ;      //仕入IDがNULL

$sql.=  "UNION ALL"."\n";
$sql.=  "   ( " ;
$sql.=  "       SELECT "."\n";
$sql.=  "           t_buy_h.buy_day ,"."\n";        //仕入日
$sql.=  "           t_buy_h.buy_no ,"."\n" ;        //仕入番号
$sql.=  "           ( SELECT trade_cname FROM t_trade "."\n";
$sql.=  "               WHERE t_trade.trade_id = t_buy_h.trade_id ) ,"."\n";//取引区分(略称)
$sql.=  "           t_buy_d.goods_name , "."\n" ;   //商品名
$sql.=  "           t_buy_d.num , "."\n" ;          //仕入数
$sql.=  "           (   CASE "."\n";                
$sql.=  "               WHEN t_buy_h.trade_id = 23 OR t_buy_h.trade_id = 24 "."\n";
$sql.=  "                   THEN t_buy_d.buy_price * -1 "."\n";
$sql.=  "               ELSE t_buy_d.buy_price "."\n";
$sql.=  "               END ) ,"."\n" ;             //仕入単価
$sql.=  "           (   CASE "."\n";            
$sql.=  "               WHEN t_buy_h.trade_id = 23 OR t_buy_h.trade_id = 24 "."\n";
$sql.=  "                    THEN t_buy_d.buy_amount * -1 "."\n";
$sql.=  "               ELSE t_buy_d.buy_amount "."\n" ;
$sql.=  "               END ) , "."\n";     //仕入金額（税抜）
$sql.=  "           (   CASE WHEN t_buy_d.tax_div = 3 "."\n";
$sql.=  "                   THEN '非課税' ELSE '' END ),"."\n" ;//課税区分
$sql.=  "           NULL ,"."\n";       
$sql.=  "           t_buy_d.line ,"."\n" ;  //行番号
$sql.=  "           2 AS div "."\n" ;       //仕入の場合は"2"
$sql.=  "       FROM ";
$sql.=  "           t_buy_h , t_buy_d "."\n" ;
$sql.=  "       WHERE ";
$sql.=  "           t_buy_h.buy_id = t_buy_d.buy_id "."\n";     //ヘッダとデータ
$sql.=  "       AND "."\n";
$sql.=  "           t_buy_h.buy_day > '".$close_day[1]."' \n";      //前回の仕入締日 
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.buy_day <= '".$close_day[0]."' \n" ;//今回の仕入締日
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.client_id = ".$client_id."\n" ;     //仕入先ID
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.shop_id = ".$shop_id."\n" ;         //ショップID
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.renew_flg = 't' "."\n";             //日次更新済み
$sql.=  "       AND " ;
$sql.=  "           t_buy_h.trade_id IN ( 21 , 23 , 24 , 25 ) "."\n" ;  //掛の仕入のみ

//---課税単位が2(伝票単位)の場合---//
if ( $tax_div == '2' ) {
    $sql.=  "   UNION ALL"."\n";
    $sql.=  "       SELECT "."\n" ;
    $sql.=  "           t_buy_h.buy_day ,"."\n" ;       //仕入日
    $sql.=  "           t_buy_h.buy_no ,"."\n" ;        //仕入番号
    $sql.=  "           NULL ,"."\n" ;                  
    $sql.=  "           '消費税金額' ,"."\n" ;      
    $sql.=  "           NULL ,"."\n" ;
    $sql.=  "           NULL ,"."\n" ;
//    $sql.=  "           t_buy_h.tax_amount ,"."\n" ;        //消費税額
    $sql.=  "           (   CASE "."\n";
    $sql.=  "               WHEN t_buy_h.trade_id = 23 OR t_buy_h.trade_id = 24 "."\n";
    $sql.=  "                   THEN t_buy_h.tax_amount * -1 "."\n";
    $sql.=  "               ELSE t_buy_h.tax_amount "."\n";
    $sql.=  "               END ) ,"."\n";
    $sql.=  "           NULL ,"."\n" ;
    $sql.=  "           t_buy_h.buy_id ,"."\n" ;            //仕入ID（不要）
    $sql.=  "           MAX( t_buy_d.line ) + 1 ,"."\n" ;   //仕入データの行番号のMAX+1
    $sql.=  "           3 AS div "."\n" ;                   //消費税の場合は"3"
    $sql.=  "       FROM " ;
    $sql.=  "           t_buy_h , t_buy_d "."\n" ;
    $sql.=  "       WHERE "."\n" ;
    $sql.=  "           t_buy_h.buy_id = t_buy_d.buy_id "."\n";     //ヘッダとデータ
    $sql.=  "       AND "."\n";
    $sql.=  "           t_buy_h.buy_day > '".$close_day[1]."' \n";  //前回の仕入締日 
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.buy_day <= '".$close_day[0]."' \n" ;//今回の仕入締日
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.client_id = ".$client_id."\n" ;     //仕入先ID
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.shop_id = ".$shop_id."\n" ;         //ショップID
    $sql.=  "       AND ";
    $sql.=  "           t_buy_h.renew_flg = 't' "."\n" ;            //日次更新済み
    $sql.=  "       AND " ;
    $sql.=  "           t_buy_h.trade_id IN ( 21 , 23 , 24 , 25 ) "."\n" ;  //掛のみ
    $sql.=  "       GROUP BY "."\n";
    $sql.=  "           t_buy_h.buy_day , "."\n" ;
    $sql.=  "           t_buy_h.buy_no , "."\n" ;
    $sql.=  "           t_buy_h.trade_id , "."\n" ;
    $sql.=  "           t_buy_h.tax_amount ,"."\n" ;
    $sql.=  "           t_buy_h.buy_id  "."\n" ;
}
$sql.=  "       ORDER BY "."\n" ;
$sql.=  "           buy_day , "."\n" ;
$sql.=  "           buy_no , "."\n" ;
$sql.=  "           line ASC " ;
$sql.=  "   ) "."\n" ;
$sql.=  "ORDER BY "."\n" ;
$sql.=  "   pay_day , "."\n" ;
$sql.=  "   pay_no , "."\n" ;
$sql.=  "   line ASC "."\n" ;      
$sql.=  ";";

//echo nl2br($sql); 
//クエリ実行
$ret_sql    = Db_Query( $con , $sql ) ;

//---クエリのエラー判定---//
if ( !$ret_sql ) {
    exit();
}

//クエリの結果件数を取得
$all_row    = pg_num_rows( $ret_sql );

//現在の情報を保持する変数
$cur_day    = '';
$cur_no     = '';
$cur_div    = '';
//一つ前の情報を保持する変数
$hold_day   = '';
$hold_no    = '';
$hold_div   = '';

//---検索結果件数分ループする---//
for ( $i=0 ; $i < $all_row ; $i++ ) {

    //$i行目のレコードを取得
    $arr_data       =   pg_fetch_array( $ret_sql , $i );

    /**********************************/
    //取得したデータを配列に格納
    /**********************************/
    //---"div"が3(消費税額)の場合---//
    if ( $arr_data['div'] == 3 ) {
            //右寄せで表示
            $detail_data[$i][3] = "<p align='RIGHT'>".$arr_data['goods_name']."</p>";       
            //3桁毎カンマと負数赤文字対応の関数
            $detail_data[$i][6] = Numformat_Ortho( $arr_data['amount'] );   //消費税額
    }
    //---"div"が1(支払額)の場合---//
    else if ( $arr_data['div'] == 1 ) {
        $detail_data[$i][0] = substr( $arr_data['pay_day'] , 5 , 5 );   //月日
        $detail_data[$i][1] = $arr_data['pay_no'];      //伝票番号
        $detail_data[$i][2] = $arr_data['trade_name'];  //取引区分
        $detail_data[$i][3] = $arr_data['goods_name'];  //商品名
        $detail_data[$i][8] = Numformat_Ortho( $arr_data['pay_amount'] ); //支払

        //比較用で現在のデータを格納
        $cur_day    = $detail_data[$i][0];  //仕入締日  
        $cur_no     = $detail_data[$i][1];  //伝票番号
        $cur_div    = $detail_data[$i][2];  //取引区分
    }
    //---"div"が2(仕入額)の場合---//
    else {
        $detail_data[$i][0] = substr( $arr_data['pay_day'] , 5 , 5 );   //月日  
        $detail_data[$i][1] = $arr_data['pay_no'];                      //伝票番号   
        $detail_data[$i][2] = $arr_data['trade_name'];                  //取引区分
        $detail_data[$i][3] = Change_Html( $arr_data['goods_name'] );   //商品名
        $detail_data[$i][4] = number_format( $arr_data['count'] );      //数量(カンマ)
        $detail_data[$i][5] = Numformat_Ortho( $arr_data['price'] , 2 );    //単価
        $detail_data[$i][6] = Numformat_Ortho( $arr_data['amount'] );       //金額
        $detail_data[$i][7] = $arr_data['tax_div'];     //税区分
    
        //比較用で現在のデータを格納
        $cur_day    = $detail_data[$i][0];  //仕入締日  
        $cur_no     = $detail_data[$i][1];  //伝票番号
        $cur_div    = $detail_data[$i][2];  //取引区分
    }

    /*********************************************/
    //仕入締日・伝票番号・取引区分の表示チェック
    /*********************************************/
    //---前回と今回の「月日」が同じ場合---//
    if ( $hold_day == $cur_day ) {
        //月日を空にする
        $detail_data[$i][0] = '' ;  
    } else {
        //現在の月日を保持する
        $hold_day   = $cur_day;  
    }
    //---前回と今回の「伝票番号」が同じ場合---//
    if ( $hold_no == $cur_no ) {
        //伝票番号を空にする 
        $detail_data[$i][1] = ''; 
       
        //---前回と今回の「取引区分」が同じ場合---//
        if ( $hold_div == $cur_div ) { 
            //取引区分を空にする 
            $detail_data[$i][2] = '';       
        }
    } else {
        $hold_no    = $cur_no;  //伝票番号を保持
        $hold_div   = $cur_div; //取引区分を保持
    }
}


/****************************/
//フォームの作成
/****************************/
//戻るボタン（検索条件復元)
$form->addElement( "button" , "btn_back" , "戻　る" , "onClick=javascript:location.href='1-3-301.php?search=1';" );


/****************************/
//DB切断
/****************************/
Db_Disconnect( $con );

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

//その他の変数をassign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'err_mess'      => "$err_mess",
    'invent_no'     => "$invent_no",
    'group_kind'    => "$group_kind",
));


//QuikFormのフォームを送信する
$render =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($render);
$smarty->assign("form",$render->toArray());

// 明細データ配列をassignする
$smarty->assign("detail_data",  $detail_data    );
$smarty->assign("close_day",    $close_day[0]   );      //仕入締日
$smarty->assign("pay_data",     $pay_data       );      //支払予定テーブルデータ配列
$smarty->assign("tax_div",      $tax_div       );       //消費税（課税単位）
 
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));


/*************************************************************************/
// *
// *
// * 文字列を実体参照に変換処理
// *
// *
// * @author              aizawa-m <aizawa-m@bhsk.co.jp>
// * @version             1.0.0 (2007/06/11)
// *
/*************************************************************************/
function Change_Html( $string ) {
    $trans_tbl      = array(    '&amp;' => '&'  ,
                                '&#59;' => ';'  ,
                                '&quot;'=> '\'' ,
                                '&#039;'=> "'"  ,
                                '&lt;'  => '<'  ,
                                '&gt;'  => '>'  ,
                                '&#37;' => '%'  ,
                                '&#40;' => '('  ,
                                '&#41;' => ')'  ,
                                '&#43;' => '+'
         );

         $trans_tbl      = array_flip ( $trans_tbl );
         return strtr ( $string , $trans_tbl );
}
?>
