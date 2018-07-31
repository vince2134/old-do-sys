<?php
/*
 * 概要 テーブルのタイトル欄（年月）を取得する関数
 *      
 * 変更履歴
 *  2007-10-04  aizawa-m        新規作成
 *  2007-10-07  aizawa-m        引数に集計期間を追加
 *
 *  @param:     $start_y        開始年
 *              $start_m        開始月
 *              $period         集計期間
 *
 *  @return:    $disp_head      表のヘッダ(タイトル)配列
 */
function Get_Header_YM ( $start_y , $start_m , $period ) {

    //12ヶ月分を取得する 
    for ( $i=0 ; $i<$period ; $i++ ) {
         //日付の書式を変える
        $this_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i, 1, $start_y ));
        $next_date = date("Y-m-d", mktime(0, 0, 0, $start_m + $i + 1, 1, $start_y ));

        //年月の配列（テーブルヘッダ用)
        $date           = substr($this_date, 0, 7);
        $year           = substr($this_date, 0, 4);
        $month          = substr($this_date, 5, 2);
        $disp_head[$i]  = $year."年".$month."月";

    }
    //戻り値
    return $disp_head;
}

?>
