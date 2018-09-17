<?php
/********************************************************************
 *
 * QuickForm - レジスタルール定義
 *
 * クイックフォームのレジスタルール用関数
 *  
 *  Function($param, $param2, $param3){}
 *  $form->addRule($param2, "message", "Function", $param3);
 *
 * @author      ふくだ
 * @version     1.0.0 (2006/02/06)
 *
 *******************************************************************/

/**
 * マルチバイト文字列長チェック
 *
 * 変更履歴
 * 1.0.0 (2005/xx/xx)   新規作成(morita-d)
 *
 * @author      morita-d <morita-d@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/xx/xx)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクト名
 * @param       integer     $maxlen         許容文字列数
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Mb_Maxlength($param, $f_name, $maxlen){ 

    return (mb_strlen($f_name, "EUC-JP") <= $maxlen) ? true : false;

}


/**
 * 半角/全角スペースだけの値は駄目
 *
 * 変更履歴
 * 1.0.0 (2006/11/25)   新規作成
 *
 * @author      fkd
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクト名
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function No_Sp_Name($param, $f_name){

    return (ereg("^[ 　]+$", $f_name)) ? false : true;

}


/**
 * 日付が正当かチェック(1フォーム用)
 *
 * 変更履歴
 * 1.0.0 (2006/11/25)   新規作成
 *
 * @author      fkd
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         日付（年月日）フォームオブジェクトの配列名
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Check_Date_Qf($param, $f_name){

    return (checkdate($f_name["m"], $f_name["d"], $f_name["y"])) ? true : false;

}


/**
 * 日付が正当かチェック(2フォーム用)
 *
 * 変更履歴
 * 1.0.0 (2006/11/29)   新規作成
 *
 * @author      fkd
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         日付（年月日）フォームオブジェクトの配列名
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Check_Date_Qf2($param, $f_name){

    if (checkdate($f_name["sm"], $f_name["sd"], $f_name["sy"]) && checkdate($f_name["em"], $f_name["ed"], $f_name["ey"])){
        return true;
    }else{
        return false;
    }

}


/**
 * グループフォームのマルチバイト文字列長チェック
 *
 * 変更履歴
 * 1.0.0 (2006/02/06)   新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクト名の配列
 * @param       integer     $maxlen         許容文字列数の配列
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Mb_Maxlength_Groupform($param, $f_name, $maxlen){ 

    // 全て入力されている場合
    if (Required_Groupform($param, $f_name) == true){

        // 配列の数だけループ
        $i = 0;
        foreach ($f_name as $key => $val){
            // 文字数を超えている場合はエラーフラグを立てる
            $ary_err_flg[] = (mb_strlen($val, "EUC-JP") > $maxlen[$i]) ? true : false;
            $i++;
        }

        // エラーフラグtrueの場合はfalseを返す
        return (in_array(true, $ary_err_flg)) ? false : true;

    // 空欄がある場合
    }else{

        // チェックせずtrueを返す
        return true;

    }

}


/**
 * グループフォームの必須項目入力チェック
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクトの配列
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Required_Groupform($param, $f_name){

    // 配列の数だけループ
    foreach ($f_name as $key => $val){
        // 空欄があればエラーフラグを立てる
        $ary_err_flg[] = ($val == null) ? true : false;
    }

    // エラーフラグtrueの場合はfalseを返す
    return (in_array(true, $ary_err_flg)) ? false : true;

}


/**
 * グループフォームの半角数字チェック
 *
 * 変更履歴
 * 1.0.0 (2006 節分)    新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006 節分)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクトの配列
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Numeric_Groupform($param, $f_name){

    // 全て入力されている場合
    if (Required_Groupform($param, $f_name) == true){

        // 配列の数だけループ
        foreach ($f_name as $key => $val){
            // 半角数字以外があればエラーフラグを立てる
            $ary_err_flg[] = (!ereg("^[0-9]+$", $val)) ? true : false;
        }

        // エラーフラグtrueの場合はfalseを返す
        return (in_array(true, $ary_err_flg)) ? false : true;

    // 空欄がある場合
    }else{

        // チェックせずtrueを返す
        return true;

    }

}


/**
 * グループフォームの半角数字＋ハイフンチェック
 *
 * 変更履歴
 * 1.0.0 (2006/02/06)    新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクトの配列
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Numhyphen_Groupform($param, $f_name){

    // 全て入力されている場合
    if (Required_Groupform($param, $f_name) == true){

        // 配列の数だけループ
        foreach ($f_name as $key => $val){
            // 半角数字＋ハイフン以外があればエラーフラグを立てる
            $ary_err_flg[] = (!ereg("^[0-9-]+$", $val)) ? true : false;
        }

        // エラーフラグtrueの場合はfalseを返す
        return (in_array(true, $ary_err_flg)) ? false : true;

    // 空欄がある場合
    }else{

        // チェックせずtrueを返す
        return true;

    }

}


/**
 * グループフォームの半角英数字＋ハイフン＋アンダースコアチェック
 * パスワードチェック用
 *
 * 変更履歴
 * 1.0.0 (2006/02/06)    新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクトの配列
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Password_Groupform($param, $f_name){

    // 全て入力されている場合
    if (Required_Groupform($param, $f_name) == true){

        // 配列の数だけループ
        foreach ($f_name as $key => $val){
            // 半角英数字＋ハイフン＋アンダースコア以外があればエラーフラグを立てる
            $ary_err_flg[] = (!ereg("^[0-9a-zA-Z_-]+$", $val)) ? true : false;
        }

        // エラーフラグtrueの場合はfalseを返す
        return (in_array(true, $ary_err_flg)) ? false : true;

    // 空欄がある場合
    }else{

        // チェックせずtrueを返す
        return true;

    }

}


/**
 * 日付グループフォームの正当性チェック
 * 
 * 変更履歴
 * 1.0.0 (2006/02/06)    新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクトの配列
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Date_Groupform($param, $f_name){

    // 全て入力されている場合
    if (Required_Groupform($param, $f_name) == true){

        // 文字列キーを配列で取得
        $key = array_keys($f_name);

        // 日付が正当ではない場合はfalseを返す
        return (checkdate($f_name[$key[1]], $f_name[$key[2]], $f_name[$key[0]]) == false) ? false : true;

    // 空欄がある場合
    }else{

        // チェックせずtrueを返す
        return true;

    }

}


/**
 * アスキーコードチェック
 * 
 * 変更履歴
 * 1.0.0 (2006/02/07)    新規作成（ふくだ）
 *
 * @author      ふくだ
 *
 * @version     1.0.0 (2006/02/07)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクト
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Ascii($param, $f_name){

    // 入力がある場合
    if ($f_name != null){

        // 文字数分ループ
        $len = mb_strlen($f_name);
        for ($i = 0; $i < $len; $i++){
            // アスキーコード以外の文字がある場合はtrueを返す
            $ascii_err_flg[] = (ord(mb_substr($f_name, $i, 1)) > 127) ? true : false;
        }

        // エラーがあった場合はfalseを返す
        return (in_array(true, $ascii_err_flg)) ? false : true;

    // 入力が無い場合
    }else{

        // チェックせずtrueを返す
        return true;

    }

}


/**
 *フラグを判別し、trueの場合はQuickFormでエラーにする。 
 * 
 * 変更履歴
 * 1.0.0 (2006/02/07)    新規作成（ふくだ）
 *
 * @author      watanabe-k
 *
 * @version     1.0.0 (2006/02/07)
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         フォームオブジェクト
 *
 * @return      boolean                     エラー：false
 *
 *
 */
function Check_Flg($param, $f_name, $flg){
    if($flg === false){
        return true;
    }else{
        return false;
    }
}


/**
*TEL・FAX番号のチェック
*
* 変更履歴
* 1.0.0(2006/11/13)新規作成（kaku-m）
*
* @author    kaku-m
*
*@param boolean  $param       不明
*@param string   $f_name      フォームオブジェクト名
*
*/

function Chk_Telfax($param,$f_name){
    //入力がある場合
    if($f_name != null){
        //半角数字と間に入るハイフン（-）のみ可
        if(ereg("(^[0-9]{1}([0-9]*-?[0-9]+)*[0-9]+$)+",$f_name) != false){
            //ただしい表記の場合trueを返す
            return true;
        }else{
            //正しくない場合、falseを返す
            return false;
        }
    //空の場合
    }else{
        //trueを返す
        return true;
    }
}


/**
 * 値が1〜100の数値かチェック
 *
 * 変更履歴
 * 1.0.0 (2007/05/08)   新規作成
 *
 * @author      kj
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          不明
 * @param       string      $f_name         日付（年月日）フォームオブジェクトの配列名
 *
 * @return      boolean                     エラー：false
 *
 */
function Check_Percent_Qf($param, $f_name)
{
    return ($f_name >= 0 && $f_name <= 100) ? true : false;
}


?>
