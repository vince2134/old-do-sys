<?php

/**
 * 概要 集計日報IDテーブルより集計日報IDを抽出する。
 *
 * 説明 
 *
 * @param   object    $db_con  DBコネクション
 *
 * @return  boolean   重複エラーが発生した場合は false
 *  OR
 * @return  int       集計日報ID
 *
 */
function Get_Daily_Slip_Id($db_con){

    //集計日報IDテーブル
    $sql  = "SELECT";
    $sql .= "   COALESCE(MAX(daily_slip_id), 0)+1 AS max_daily_slip_id ";
    $sql .= "FROM ";
    $sql .= "   t_daily_slip_id_serial ";
    $sql .= ";"; 

    $result = Db_Query($db_con, $sql);
    $max_id = pg_fetch_result($result, 0,0);

    //MAX+1したIDを登録
    $sql = "INSERT INTO t_daily_slip_id_serial (daily_slip_id) VALUES ($max_id);";
    $result = Db_Query($db_con, $sql);

    if($result === false){
        $err_message = pg_last_error();
        $err_format = "t_daily_slip_id_serial_pkey";
        Db_Query($db_con, "ROLLBACK;");

        //IDが重複した場合
        if(strstr($err_message, $err_format) != false){
            return false;

        //その他のエラー時は強制的に処理終了
        }else{
            exit;
        }
    }

    return $max_id;
}


?>
