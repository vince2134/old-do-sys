<?php

/**
 *
 * テンプレートでデータの後に単位を付ける関数
 *  
 * 使用例．{$value|Plug_Unit_Add:"%"} 
 * 
 * @param   int     $num        対象の数値
 * @param   string  $unit       付けたい単位(case文で追加）
 *
 * @return  string  単位を付加した値（$numがNULLの場合はNULL）
 *
 */
function smarty_modifier_Plug_Unit_Add ($num, $unit){
    if ($num == NULL){
        return NULL;
    }else{
        switch ($unit) {
            case "%":
                $num = $num."%";
                break;
            default:
                break;
        }
    }
    return $num;
}

?>
