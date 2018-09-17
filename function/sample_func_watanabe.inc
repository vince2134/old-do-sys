<?php
/***********************************************************
 *
 * （福田）（渡部）作成関数
 *
 * 変更履歴
 * 1.0.0 (2005/10/18) 新規作成(suzuki-t)
 *
 * @version             1.1.0 (2005/10/18)
 * @author              suzuki-t <suzuki-t@bhsk.co.jp>
 *
 ***********************************************************/

require_once('db.fnc');

/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 */
function Check_Bill_Day($db_con, $yy, $mm, $dd, $client_id){

    $sql  = "SELECT\n";
    $sql .= "   MAX(close_day) \n";
    $sql .= "FROM\n";
    $sql .= "   t_bill\n";
    $sql .= "WHERE\n";

    //本部処理の場合
    if($_SESSION[shop_id] == 1){
        $sql .= "   t_bill.claim_id = (SELECT\n";
        $sql .= "                           claim_id\n";
        $sql .= "                       FROM\n";
        $sql .= "                           t_claim\n";
        $sql .= "                       WHERE\n";
        $sql .= "                           client_id = $client_id\n";
        $sql .= "                       )\n";
    //FC処理の場合
    }else{
        $sql .= "   t_bill.claim_id = $client_id\n";
    }
    $sql .= ";\n";  

    $result = Db_Query($db_con, $sql);

    $bill_close_day = pg_fetch_result($result, 0,0);
 
    //引数で渡された日付を結合
    $mm = str_pad($mm, 0, 2, STR_PAD_LEFT);
    $dd = str_pad($dd, 0, 2, STR_PAD_LEFT);
    $pram_date = $yy."-".$mm."-".$dd;

    //抽出した日付が渡された日付より大きい場合はエラー
    if($bill_close_day >= $pram_date){
        return false;
    }
    return true;
}

/**
 * CSV形式のデータを作成
 *
 * 配列の要素ごとにカンマを挿入する。
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(watanabe-k)
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.0 (2005/03/22)
 *
 * @param               array           $db_num     ＤＢから取得したレコード数
 * @param               string          $row        ＤＢから取得したデータ         
 *
 * @return              array
 *
 *
 */
/*
function Make_Csv($row ,$header){
    if(count($row) == 0){
        $row[] = "";
    }
    // 配列にヘッダー行を追加
    $count = array_unshift($row, $header);
    for($i = 0; $i < $count; $i++){
        for($j = 0; $j < count($row[$i]); $j++){
            // エンコード
            $row[$i][$j] = mb_convert_encoding($row[$i][$j], "SJIS", "EUC-JP");
            // "→""
            $row[$i][$j] = str_replace("\"", "\"\"", $row[$i][$j]);
            // ""で囲む
            $row[$i][$j] = "\"".$row[$i][$j]."\""; 
        }

        // 配列をカンマ区切りで結合
        $data_csv[$i] = implode(",", $row[$i]);
    }
        $data_csv = implode("\n", $data_csv);
    return $data_csv;       
}

/**
 * レコード数を取得する。
 * 
 * 
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(watanabe-k)
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.0 (2005/03/22)
 *
 * @param               string          $table_name         テーブル名
 * @param               string          $where_sql          where文       
 *
 * @return              integer
 *
 *
 */
function Db_Count($conn, $sql){
//    $conn = Db_Con();
//    $sql = "SELECT * FROM $table_name WHERE shop_id = $shop_id $where_sql ;" ;
//echo $sql."<br>";
    $result = Db_Query($conn, $sql);
    $db_max = pg_num_rows($result);
    return $db_max;
}


/**
 * DBからデータを取得する。
 *
 *
 *
 * 変更履歴
 * 1.0.0 (2005/03/22) 新規作成(watanabe-k)
 *
 * @author              watanabe-k <watanabe-k@bhsk.co.jp>
 *
 * @version             1.0.0 (2005/03/22)
 *
 * @param               string          $result     クエリ情報
 *
 * @return              array
 *
 *
 */
/*
function Get_Data($result, $output_type=""){
    $result_count = pg_numrows($result);

    for($i = 0; $i < $result_count; $i++){
        $row[] = @pg_fetch_array ($result, $i, PGSQL_NUM);
    }

    if($output_type != 2){
        for($i = 0; $i < $result_count; $i++){
            for($j = 0; $j < count($row[$i]); $j++){
                $row[$i][$j] = htmlspecialchars($row[$i][$j]);
            }
        }
    }

    return $row;
}








////////////////以下いらないもの････････････････････････/////////////////


function Get_Data2($result, $output_type=""){
    $result_count = pg_numrows($result);
    for($i = 0; $i < $result_count; $i++){
        $row[] = @pg_fetch_array ($result, $i, PGSQL_NUM);
    }
    if($output_type != 2){
        for($i = 0; $i < $result_count; $i++){
            for($j = 0; $j < count($row[$i]); $j++){
                $row[$i][$j] = htmlspecialchars($row[$i][$j]);
            }
        }
    }
    return $row;
}


function Db_Count2($table_name, $shop_id, $where_sql){
    $conn = Db_Con();
    $sql = "SELECT * FROM $table_name WHERE shop_gid = $shop_id $where_sql ;" ;
//echo $sql."<br>";
    $result = Db_Query($conn, $sql);
    $db_max = pg_num_rows($result);
    return $db_max;
}

//DBコネクト関数
function DB_Con(){
    $conn = pg_connect("dbname=amenity user=postgres") or die("接続エラー");
    return $conn;
}
//クエリ発行関数
function DB_Que($conn, $sql){
    $result = pg_query($conn, $sql) or die("クエリエラー");
    return $result;
}



//表示データ作成関数
function Make_Page($table_name, $field_name, $shop_id, $where_sql="", $page_count, $output_type="", $key=0){
    //OFFSETデータ作成
    if($page_count > 1){
        $page_num = ($page_count-1)* 10;
    }else{
        $page_num = 0;
    }
    //DB接続
    $conn = Db_Con();
    //sql作成
    $select_sql = implode(", ", $field_name);
    $sql  = "SELECT $select_sql";
    $sql .= " FROM $table_name";
    $sql .= " WHERE shop_id = $shop_id";
    $sql .= " $where_sql";
    $sql .= " ORDER BY $field_name[$key] ASC";
    if($output_type != 2){
        $sql .= " LIMIT 10 OFFSET $page_num";
    }
    $sql .= ";"; 
//echo $sql."<br>";

    //sql発行(関数未完成？？)
    $result = DB_Que($conn, $sql);

    //データ取得
    $page_data = Get_Data2($result ,$output_type);
    
    return $page_data;
}

//表示データ作成関数
function Make_Page2($table_name, $field_name, $shop_gid, $where_sql="", $page_count, $output_type="", $key=0){
    //OFFSETデータ作成
    if($page_count > 1){
        $page_num = ($page_count-1)* 10;
    }else{
        $page_num = 0;
    }

    //DB接続
    $conn = Db_Con();

    //sql作成
    $select_sql = implode(", ", $field_name);
    $sql  = "SELECT $select_sql";
    $sql .= " FROM $table_name";
//    $sql .= " WHERE shop_id = $shop_id";
    $sql .= " WHERE shop_gid = $shop_gid";
    $sql .= " $where_sql";
    $sql .= " ORDER BY $field_name[$key] ASC";
    if($output_type != 2){
        $sql .= " LIMIT 10 OFFSET $page_num";
    }
    $sql .= ";";
//echo $sql."<br>";

    //sql発行(関数未完成？？)
    $result = DB_Que($conn, $sql);

    //データ取得
    $page_data = Get_Data2($result ,$output_type);

    return $page_data;
}
*/

function getmicrotime(){    list($usec, $sec) = explode(" ",microtime());    return ((float)$sec + (float)$usec);}
function sql_test($conn, $pre, $exe){

    Db_Query($conn, $pre);

    $a = getmicrotime();


    for($i =0; $i < 5053; $i++){
        $res =Db_Query($conn, $exe);
    }
    $b = bcsub(getmicrotime(),$a,10);
    print $b;

//    $data = pg_fetch_all($res);
    $res =Db_Query($conn, "EXPLAIN ".$exe);
    print "<pre style=\"font: 10px; font-family: 'ＭＳ ゴシック'; \>";

    for($i = 0; $i < pg_num_rows($res); $i++){

        $a =  pg_fetch_result($res, $i ,0);

        $a = str_replace("Index Scan", "<font color=blue>Index Scan</font>", $a);
        $a = str_replace("Seq Scan", "<font color=red>Seq Scan</font>", $a);
//        $a = str_replace("Nested Loop", "<font color=yellow>Nested Loop</font>", $a);

        print $a."<br>";
    }

    print "</pre>";

    print_array($data);

}
?>
