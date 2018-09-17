<?php
/*********************************************************************
 *
 * ふくだかんすう
 *
 * @author      ふくだ
 * @version     1.0.0 (2006 節分)
 *
 *********************************************************************/

// 設定
require_once("db.fnc");

/**
 *
 * POSTされたデータが既に登録されているデータと重複していないかチェック
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    ふくだ新規作成
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       string      $con            DB接続関数
 * @param       string      $status         ステータス（新規・変更）
 * @param       string      $origin_data    変更前データ（無い場合はnull）
 * @param       string      $post_data      POSTされたデータ
 * @param       string      $sql            重複をチェックするSQL
 *
 * @return      boolean                     エラー：true
 *
 */
/*
function Duplicate_Chk($con, $status, $origin_data, $post_data, $sql){

    // POSTされたデータが配列の場合（２フォームの重複チェックの場合）
    if (is_array($post_data)){
        $post_data = $post_data[0]."-".$post_data[1];
        // 変更の場合（元データがある場合）
        if ($status == "chg"){
            $origin_data = $origin_data[0]."-".$origin_data[1];
        }
    }

    // 新規登録の場合・変更で元データとPOSTデータが違う場合
    if ( (($status == "add") && ($post_data != null) ||
         (($status == "chg") && ($origin_data != $post_data) && ($post_data) != null)) ){

        $res = Db_Query($con, $sql);

        // 該当レコードが1件以上あれば重複エラー
        return (pg_fetch_result($res, 0, 0) >= 1) ? true : false;

    }

    return false;

}
*/

/**
 *
 * POSTされたデータがDBに存在しているかチェック
 *
 * 変更履歴
 * 1.0.0 (2006/02/06)    ふくだ新規作成
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       string      $con            DB接続関数
 * @param       string      $post_data      POSTされたデータ
 * @param       string      $sql            存在をチェックするSQL
 *
 * @return      boolean                     エラー：false
 *
 */
/*
function Exist_Chk($con, $post_data, $sql){

    $res = Db_Query($con, $sql);

    // 該当レコードが0件の場合はエラー
    return (pg_fetch_result($res, 0, 0) == 0) ? false : true;

}
*/

/**
 *
 * 該当テーブルのコードと名前を全て取得
 * コードのフォームが2つの場合は自動フォーカス移動
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    ふくだ新規作成
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       string      $con            DB接続関数
 * @param       string      $table          テーブル名
 * @param       string      $cd_col         コードのカラム名(2個の場合は配列で)
 * @param       string      $value_col      名前のカラム名
 * @param       string      $option         抽出時の条件(SQL文のWHERE句と同じフォーマットで)
 *
 * @return                  $js             Javascript
 *
 */
/*
function Code_Value_Disp2($name, $cd_col, $value_col, $ary_rec_data){

    $row = count($ary_rec_data);

    // Javascript作成
    $js  = "function Code_Value_$name(me, cd_form){\n";
    $js .= "    data = new Array($row);\n";

    // コードのフォームが配列が配列の場合（コードフォームが２つ）
    if (is_array($cd_col)){

        for ($i = 0; $i < $row; $i++){
            $js .= "    data['".$ary_rec_data[$i][$cd_col[0]]."-".$ary_rec_data[$i][$cd_col[1]]."']=\"".$ary_rec_data[$i][$value_col]."\"\n";
        }
        $js .= "    var cd1  = cd_form[0]+\"[\"+cd_form[1]+\"]\";\n";
        $js .= "    var cd2  = cd_form[0]+\"[\"+cd_form[2]+\"]\";\n";
        $js .= "    var data = data[me.elements[cd1].value+\"-\"+me.elements[cd2].value];\n";

    // コードのフォームが配列ではない場合（コードフォームが１つ）
    }else{

        for ($i = 0; $i < $row; $i++){
            $js .= "    data['".$ary_rec_data[$i][$cd_col]."']=\"".$ary_rec_data[$i][$value_col]."\"\n";
        }
#        $js .= "    var cd1  = form+\"[\"+cd_form[0]+\"]\";\n";
#        $js .= "    var cd1  = form+\"[\"+cd_form+\"]\";\n";
#        $js .= "    var cd   = cd_form;\n";
        $js .= "    var data = data[me.elements[cd_form].value];\n";

    }
    $js .= "    if (data == undefined){\n";
    $js .= "        document.all.$name.innerHTML = \"\";\n";
    $js .= "    }else{\n";
    $js .= "        document.all.$name.innerHTML = data;\n";
    $js .= "    }\n";
    $js .= "}\n";

    return $js;

}

*/








#-------------------------ここから下は古そう--------------------------------

/*--------------------------------------------------------
    関数名: Address_Get
    説明:   入力された郵便番号から住所レコードを取得
    param:  $post1_data      郵便番号上3桁の入力データ
            $post2_data      郵便番号下4桁の入力データ
            $post_table      郵便番号テーブル名
            $post_no_col     郵便番号のカラム名
    return: $ary_addr_record 住所データの配列
--------------------------------------------------------*/
function Address_Get($post1_data, $post2_data, $post_table, $post_no_col){

    // 入力された郵便番号データのtrim
    $post1_data = trim($post1_data);
    $post2_data = trim($post2_data);

    // 入力された郵便番号のフォーマットが正当な場合
    if (Post_Format_Chk($post1_data, $post2_data, 3, 4) == false &&
        $post1_data != null && $post2_data != null){

        $sql  = "SELECT * FROM $post_table ";
        $sql .= "WHERE $post_no_col = '".$post1_data.$post2_data."' ";
        $sql .= ";";
        $con  = Db_Connect();
        $res  = Db_Query($con, $sql);

        // 住所レコードが1件あれば住所データ取得
        if (pg_num_rows($res) == 1){
            $ary_addr_record = pg_fetch_array($res, 0, PGSQL_ASSOC);
            return $ary_addr_record;
        }

    }

}


/*--------------------------------------------------------
    関数名: Code_Value_Disp
    説明:   該当テーブルのコードと名前を全て取得
            コードのフォームが2つの場合は自動フォーカス移動
    param:  $name            Javascriptユーザ関数名(Code_Value_$name)
            $table           テーブル名
            $cd_col          コードのカラム名(2個の場合は配列で)
            $value_col       名前のカラム名
            $option          抽出時の条件(SQL文のWHERE句と同じフォーマットで)
    return: $ary_record      コードと名前の配列
--------------------------------------------------------*/
// 作成途中('A`)
function code_value_disp($name, $table, $cd_col, $value_col, $option = null){

    // SQL文用コードカラム部作成
    if (is_array($cd_col)){
        $sql_opt = "$cd_col[0], $cd_col[1]";
    }else{
        $sql_opt = "$cd_col";
    }

    // SQL文
    $sql  = "SELECT ";
    $sql .= "$sql_opt, ";
    $sql .= "$value_col ";
    $sql .= "FROM $table ";
    $sql .= $option;
    $sql .= " ;";

    // コードと名前を取得
    $con  = Db_Connect();
    $res  = Db_Query($con, $sql);
    $row  = pg_num_rows($res);
    for ($i = 0; $i < $row; $i++){
        $ary_record[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);
    }

    // Javascript作成
    $js  = "function Code_Value_$name(form, value_form, cd_form){\n";
    $js .= "    data = new Array($row);\n";

    if (is_array($cd_col)){

        // コードのフォームが2つある場合
        for ($i = 0; $i < $row; $i++){
            $js .= "    data['".$ary_record[$i][$cd_col[0]]."-".$ary_record[$i][$cd_col[1]]."']=\"".$ary_record[$i][$value_col]."\"\n";
        }
        $js .= "    var cd1   = form+\"[\"+cd_form[0]+\"]\";\n";
        $js .= "    var cd2   = form+\"[\"+cd_form[1]+\"]\";\n";
        $js .= "    var data = data[document.dateForm.elements[cd1].value+\"-\"+document.dateForm.elements[cd2].value];\n";
        // 0000補完（参照テーブルがショップテーブルの場合のみ）
        if ($table == "t_shop"){
            $js .= "    if ((document.dateForm.elements[cd1].value != \"\") && (document.dateForm.elements[cd2].value == \"\")){\n";
            $js .= "        document.dateForm.elements[cd2].value = \"0000\";\n";
            $js .= "        document.dateForm.elements[cd2].value = \"0000\";\n";
            $js .= "    }\n";
        }
        // フォーカス移動（さらに文字列を選択状態に）
        $js .= "    len = document.dateForm.elements[cd1].value.length;\n";
        $js .= "    if (cd_form[2]==len){\n";
        $js .= "        document.dateForm.elements[cd2].focus()\n";
        $js .= "        document.dateForm.elements[cd2].select()\n";
        $js .= "    }\n";

    }else{

        // コードのフォームが1つの場合
        for ($i = 0; $i < $row; $i++){
            $js .= "    data['".$ary_record[$i][$cd_col]."']=\"".$ary_record[$i][$value_col]."\"\n";
        }
        $js .= "    var cd1  = form+\"[\"+cd_form[0]+\"]\";\n";
        $js .= "    var data = data[document.dateForm.elements[cd1].value];\n";
    }

    $js .= "    var value = form+\"[\"+value_form+\"]\";\n";
    $js .= "    if (data == undefined){\n";
    $js .= "        document.dateForm.elements[value].value = \"\";\n";
    $js .= "    }else{\n";
    $js .= "        document.dateForm.elements[value].value = data;\n";
    $js .= "    }\n";
    $js .= "}\n";

    return $js;

}


?>
