<?php

/**
 *
 * �ƥ�ץ졼�ȥե��������number_format+�ޥ��ʥ��ֻ��б���Ŭ�Ѥ���ؿ�
 *   
 * @param   int       $num          �оݤο���
 * @param   int       $dot          �����貿�̤ޤ�ɽ�����뤫��Ǥ�ա�
 * @param   boolean   $null_flg     true: ����null�ʤ�null�Τޤ��֤���Ǥ�ա�
 *
 * @return  NULL or                 NULL
 *          string                  number_format���ֻ��ˤ��줿��
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
