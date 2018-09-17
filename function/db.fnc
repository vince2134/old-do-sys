<?php

//データベースへ接続を行う
function Db_Connect($db_name=""){

    //接続DBが無い場合は  本番用DBに接続
    if($db_name == "" ){
        $db_con  = pg_connect(DB_INFO);
    //それ以外の場合は　指定DBに接続
    }else{
        #$db_name = "amenity_test_demo";
        #$db_con  = pg_connect("host=127.0.0.1 port=5432 dbname=$db_name");
        $db_con  = pg_connect("host=210.196.79.249 port=5432 dbname=$db_name");
    }

    if (!$db_con){
        echo "データベースとの接続に失敗しました。";
        exit;
    }

    return $db_con;
}


//SQLを実行する
function Db_Query($db_con, $sql, $debug=""){

	$result = @pg_query($db_con,$sql);

	//SQL実行に失敗した場合は、自動でデバックを行う
	if($result == ""){

        $duplicate_err = "duplicate";

		// SQL文とエラーメッセージを表示
        //UNIQUE制約ではじかれた場合はエラー表示しない
        if(!strstr(pg_last_error(), $duplicate_err)){
		    echo "$sql <br />";
		    echo  pg_last_error ();
		    echo "<hr>";
        }

		return false;

	//デバックフラグが1の場合は、デバック処理を行う
	}else if($debug === 1){

		echo "$sql <br />";
		echo  pg_last_error ();
		echo "<hr>";
	}
/*
*/	
	return $result;
}

//DBとの接続を切断する
function Db_Disconnect($db_con){

	$pg_close = pg_close($db_con);

	if (!$db_con){
		echo "データベースとの切断に失敗しました。";
		exit;
	}

}

/**
 * 概要  テーブルに配列データを登録する 
 *
 * 説明
 *
 * @param resource  $db_con       DB接続リソース
 * @param string    $table_name   テーブル名
 * @param array     $data         登録データ
 *
 * @return resource               成功時はDBリソース、失敗時はfalse
 *
 */
function Db_Insert($db_con, $table_name, $data, $debug_flg=NULL){
    //項目生成
    $count = 0;
    foreach($data AS $column => $value){

        //最初以外はカンマを付けて結合
        if ($count != "0"){
            $columns .= ","."$column";
            $values  .= ","."$value";
        } else {
            $columns = "$column";
            $values  = "$value";
        } 

        $count++;
    }

    //INSERT
    $sql = "INSERT INTO $table_name ($columns) VALUES($values);";
    $result = Db_Query($db_con, $sql,$debug_flg);  
    return $result;
}


/**
 * 概要  テーブルを更新する 
 *
 * 説明
 *
 * @param resource  $db_con       DB接続リソース
 * @param string    $table_name   テーブル名
 * @param array     $data         更新データ
 * @param array     $where        更新条件
 *
 * @return resource               成功時はDBリソース、失敗時はfalse
 *
 */
function Db_Update($db_con, $table_name, $data, $where, $debug_flg=NULL){

    //対象項目生成
    $count = 0;
    foreach($data AS $column => $value){

        //最初以外はカンマを付けて結合
        if ($count != "0"){
            $columns .= ","."$column = $value";
        } else {
            $columns  = "$column = $value";
        } 

        $count++;
    }

    //条件文作成
    $count = 0;
    foreach($where AS $column => $value){

        //最初以外はカンマを付けて結合
        if ($count != "0"){
            $w_columns .= "AND   $column = $value";
        } else {
            $w_columns  = "WHERE $column = $value";
        } 

        $count++;
    }

    //UPDATE条件が無い場合はエラー
    if($w_columns == NULL || $w_columns == ""){
        return false;
    }

    //UPDATE
    $sql = "UPDATE $table_name SET $columns $w_columns;";
    $result = Db_Query($db_con, $sql,$debug_flg);  
    return $result;

}


?>
