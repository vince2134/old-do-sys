<?php

/**
 *
 * テンプレートファイル内でnumber_format+マイナス赤字対応を適用する関数
 *   
 * @param   int       $num          対象の数値
 * @param   int       $dot          小数第何位まで表示するか（任意）
 * @param   boolean   $null_flg     true: 数値nullならnullのまま返す（任意）
 *
 * @return  NULL or                 NULL
 *          string                  number_format（赤字）された値
 *
 */

function smarty_modifier_Minus_Numformat ($num, $dot = 0, $null_flg = false){
    if ($null_flg === true && $num === NULL){
        return NULL;
    }else{
        return ($num < 0) ? "<span style=\"color: #ff0000;\">".number_format($num, $dot)."</span>" : number_format($num, $dot);
    }
}

?>
