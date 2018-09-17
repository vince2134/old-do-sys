<?php
/*********************************************************************
 * @Program         func_qf_chk_rule.inc
 * @fnc.Overview    QuickForm - ルール定義
 * @author          
 * @Cng.Tracking    #1: 20060131
 ********************************************************************/

/*------------------------------------------------------------------
    ルール定義
------------------------------------------------------------------*/

/*--------------------------------------------------------
    説明:   QuickForm - 必須項目チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
    return: void
--------------------------------------------------------*/
function Qf_Chk_Required($form, $f_name, $l_name){

    // フォームが配列（複数）なら
    if (is_array($f_name)){

        // 両方nullの場合
        if ($f_name[1] == null && $f_name[2] == null){
            $form->setElementError($f_name[0], $l_name." は必須項目です。");
        // どちらか片方がnullの場合
        }elseif ($f_name[1] == null || $f_name[2] == null){
            $form->setElementError($f_name[0], "正しい ".$l_name." を入力してください。");
        }

    }else{

        $form->addRule($f_name, $l_name." は必須項目です。", "required", null);

    }

}


/*--------------------------------------------------------
    説明:   QuickForm - [0-9]チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numeric($form, $f_name, $l_name){

    // フォームが配列（複数）なら
    if (is_array($f_name)){

        if ( ($f_name[1] != null && $f_name[2] != null) &&
             (!ereg("^[0-9]+$", $f_name[1]) || !ereg("^[0-9]+$", $f_name[2])) ){
            $form->setElementError($f_name[0], $l_name." は半角数字のみ使用可です。");
        }

    }else{

        $form->addRule($f_name, $l_name." は半角数字のみ使用可です。", "numeric", null);

    }

}


/*--------------------------------------------------------
    説明:   QuickForm - [0-9-]チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numhyphen($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." は半角数字と「-」の".$maxlen."桁以内です。", "numhyphen");

}


/*--------------------------------------------------------
    説明:   QuickForm - 重複チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $duplicate_flg         重複フラグ(重複: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Duplicate($form, $f_name, $l_name, $duplicate_flg){

    if ($duplicate_flg == true){
        $form->setElementError($f_name, "既に使用されている".$l_name."です。");
    }

}


/*--------------------------------------------------------
    説明:   QuickForm - 同一ショップ内での重複数チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $num_over_flg          個数オーバフラグ(エラー: true)
            $maxnum                最大個数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numover($form, $f_name, $l_name, $num_over_flg, $maxnum){

    if ($num_over_flg == true){
        $form->setElementError($f_name, $l_name." は同一ショップ内で".$maxnum."個までです。");
    }

}


/*--------------------------------------------------------
    説明:   QuickForm - 郵便番号フォーマットチェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen1               最大桁数１
            $maxlen2               最大桁数２
            $format_err_flg        フォーマットエラーフラグ(エラー: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Post($form, $f_name, $l_name, $maxlen1, $maxlen2, $format_err_flg){

    if ($format_err_flg == true){
        $form->setElementError($f_name, $l_name." は半角数字".$maxlen1."桁-".$maxlen2."桁です。");
    }

}


/*--------------------------------------------------------
    説明:   QuickForm - TEL, FAXフォーマットチェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
    return: void
--------------------------------------------------------*/
function Qf_Chk_Telfax($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." は半角数字と「-」の".$maxlen."桁以内です。", "telfax");

}


/*--------------------------------------------------------
    説明:   QuickForm - 文字列長チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name                項目名
            $maxlen                最大桁数
            $fnc_type              使用する関数(1byte/MultiByte用)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Strlen($form, $f_name, $l_name, $maxlen, $unit, $fnc_type){

    $form->addRule($f_name, $l_name." は".$maxlen.$unit."以内です。", $fnc_type, $maxlen);
#    $form->applyFilter($f_name, "trim");

}


/*--------------------------------------------------------
    説明:   QuickForm - 2フォーム間の入力内容整合性チェック
    param:  $form                  フォーム
            $f_name                フォーム名
            $l_name1               項目名１
            $l_name2               項目名２
            $consistent_err_flg    整合性エラーフラグ(エラー: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Consistent($form, $f_name, $l_name){

    // フォームが配列（複数）なら
    if (is_array($f_name)){

        // フォーム１とフォーム２の入力内容が異なれば
        if ($f_name[0] != $f_name[1]){
            $form->setElementError($f_name[0], $l_name[0].", ".$l_name[1]." の入力内容が異なります。");
        }

    }

}


?>
