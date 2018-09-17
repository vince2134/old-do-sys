<?php
/*********************************************************************
 * @Program         func_qf_chk_rule.inc
 * @fnc.Overview    QuickForm - �롼�����
 * @author          
 * @Cng.Tracking    #1: 20060131
 ********************************************************************/

/*------------------------------------------------------------------
    �롼�����
------------------------------------------------------------------*/

/*--------------------------------------------------------
    ����:   QuickForm - ɬ�ܹ��ܥ����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
    return: void
--------------------------------------------------------*/
function Qf_Chk_Required($form, $f_name, $l_name){

    // �ե����ब�����ʣ���ˤʤ�
    if (is_array($f_name)){

        // ξ��null�ξ��
        if ($f_name[1] == null && $f_name[2] == null){
            $form->setElementError($f_name[0], $l_name." ��ɬ�ܹ��ܤǤ���");
        // �ɤ��餫������null�ξ��
        }elseif ($f_name[1] == null || $f_name[2] == null){
            $form->setElementError($f_name[0], "������ ".$l_name." �����Ϥ��Ƥ���������");
        }

    }else{

        $form->addRule($f_name, $l_name." ��ɬ�ܹ��ܤǤ���", "required", null);

    }

}


/*--------------------------------------------------------
    ����:   QuickForm - [0-9]�����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $maxlen                ������
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numeric($form, $f_name, $l_name){

    // �ե����ब�����ʣ���ˤʤ�
    if (is_array($f_name)){

        if ( ($f_name[1] != null && $f_name[2] != null) &&
             (!ereg("^[0-9]+$", $f_name[1]) || !ereg("^[0-9]+$", $f_name[2])) ){
            $form->setElementError($f_name[0], $l_name." ��Ⱦ�ѿ����Τ߻��ѲĤǤ���");
        }

    }else{

        $form->addRule($f_name, $l_name." ��Ⱦ�ѿ����Τ߻��ѲĤǤ���", "numeric", null);

    }

}


/*--------------------------------------------------------
    ����:   QuickForm - [0-9-]�����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $maxlen                ������
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numhyphen($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." ��Ⱦ�ѿ����ȡ�-�פ�".$maxlen."�����Ǥ���", "numhyphen");

}


/*--------------------------------------------------------
    ����:   QuickForm - ��ʣ�����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $duplicate_flg         ��ʣ�ե饰(��ʣ: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Duplicate($form, $f_name, $l_name, $duplicate_flg){

    if ($duplicate_flg == true){
        $form->setElementError($f_name, "���˻��Ѥ���Ƥ���".$l_name."�Ǥ���");
    }

}


/*--------------------------------------------------------
    ����:   QuickForm - Ʊ�쥷��å���Ǥν�ʣ�������å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $num_over_flg          �Ŀ������Хե饰(���顼: true)
            $maxnum                ����Ŀ�
    return: void
--------------------------------------------------------*/
function Qf_Chk_Numover($form, $f_name, $l_name, $num_over_flg, $maxnum){

    if ($num_over_flg == true){
        $form->setElementError($f_name, $l_name." ��Ʊ�쥷��å����".$maxnum."�ĤޤǤǤ���");
    }

}


/*--------------------------------------------------------
    ����:   QuickForm - ͹���ֹ�ե����ޥåȥ����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $maxlen1               ��������
            $maxlen2               ��������
            $format_err_flg        �ե����ޥåȥ��顼�ե饰(���顼: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Post($form, $f_name, $l_name, $maxlen1, $maxlen2, $format_err_flg){

    if ($format_err_flg == true){
        $form->setElementError($f_name, $l_name." ��Ⱦ�ѿ���".$maxlen1."��-".$maxlen2."��Ǥ���");
    }

}


/*--------------------------------------------------------
    ����:   QuickForm - TEL, FAX�ե����ޥåȥ����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $maxlen                ������
    return: void
--------------------------------------------------------*/
function Qf_Chk_Telfax($form, $f_name, $l_name, $maxlen){

    $form->addRule($f_name, $l_name." ��Ⱦ�ѿ����ȡ�-�פ�".$maxlen."�����Ǥ���", "telfax");

}


/*--------------------------------------------------------
    ����:   QuickForm - ʸ����Ĺ�����å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name                ����̾
            $maxlen                ������
            $fnc_type              ���Ѥ���ؿ�(1byte/MultiByte��)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Strlen($form, $f_name, $l_name, $maxlen, $unit, $fnc_type){

    $form->addRule($f_name, $l_name." ��".$maxlen.$unit."����Ǥ���", $fnc_type, $maxlen);
#    $form->applyFilter($f_name, "trim");

}


/*--------------------------------------------------------
    ����:   QuickForm - 2�ե�����֤��������������������å�
    param:  $form                  �ե�����
            $f_name                �ե�����̾
            $l_name1               ����̾��
            $l_name2               ����̾��
            $consistent_err_flg    ���������顼�ե饰(���顼: true)
    return: void
--------------------------------------------------------*/
function Qf_Chk_Consistent($form, $f_name, $l_name){

    // �ե����ब�����ʣ���ˤʤ�
    if (is_array($f_name)){

        // �ե����ࣱ�ȥե����ࣲ���������Ƥ��ۤʤ��
        if ($f_name[0] != $f_name[1]){
            $form->setElementError($f_name[0], $l_name[0].", ".$l_name[1]." ���������Ƥ��ۤʤ�ޤ���");
        }

    }

}


?>