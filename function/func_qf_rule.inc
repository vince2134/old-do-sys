<?php
/********************************************************************
 *
 * QuickForm - �쥸�����롼�����
 *
 * �����å��ե�����Υ쥸�����롼���Ѵؿ�
 *  
 *  Function($param, $param2, $param3){}
 *  $form->addRule($param2, "message", "Function", $param3);
 *
 * @author      �դ���
 * @version     1.0.0 (2006/02/06)
 *
 *******************************************************************/

/**
 * �ޥ���Х���ʸ����Ĺ�����å�
 *
 * �ѹ�����
 * 1.0.0 (2005/xx/xx)   ��������(morita-d)
 *
 * @author      morita-d <morita-d@bhsk.co.jp>
 *
 * @version     1.0.0 (2005/xx/xx)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥�������̾
 * @param       integer     $maxlen         ����ʸ�����
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Mb_Maxlength($param, $f_name, $maxlen){ 

    return (mb_strlen($f_name, "EUC-JP") <= $maxlen) ? true : false;

}


/**
 * Ⱦ��/���ѥ��ڡ����������ͤ�����
 *
 * �ѹ�����
 * 1.0.0 (2006/11/25)   ��������
 *
 * @author      fkd
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥�������̾
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function No_Sp_Name($param, $f_name){

    return (ereg("^[ ��]+$", $f_name)) ? false : true;

}


/**
 * ���դ������������å�(1�ե�������)
 *
 * �ѹ�����
 * 1.0.0 (2006/11/25)   ��������
 *
 * @author      fkd
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         ���ա�ǯ�����˥ե����४�֥������Ȥ�����̾
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Check_Date_Qf($param, $f_name){

    return (checkdate($f_name["m"], $f_name["d"], $f_name["y"])) ? true : false;

}


/**
 * ���դ������������å�(2�ե�������)
 *
 * �ѹ�����
 * 1.0.0 (2006/11/29)   ��������
 *
 * @author      fkd
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         ���ա�ǯ�����˥ե����४�֥������Ȥ�����̾
 *
 * @return      boolean                     ���顼��false
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
 * ���롼�ץե�����Υޥ���Х���ʸ����Ĺ�����å�
 *
 * �ѹ�����
 * 1.0.0 (2006/02/06)   ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥�������̾������
 * @param       integer     $maxlen         ����ʸ�����������
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Mb_Maxlength_Groupform($param, $f_name, $maxlen){ 

    // �������Ϥ���Ƥ�����
    if (Required_Groupform($param, $f_name) == true){

        // ����ο������롼��
        $i = 0;
        foreach ($f_name as $key => $val){
            // ʸ������Ķ���Ƥ�����ϥ��顼�ե饰��Ω�Ƥ�
            $ary_err_flg[] = (mb_strlen($val, "EUC-JP") > $maxlen[$i]) ? true : false;
            $i++;
        }

        // ���顼�ե饰true�ξ���false���֤�
        return (in_array(true, $ary_err_flg)) ? false : true;

    // ���󤬤�����
    }else{

        // �����å�����true���֤�
        return true;

    }

}


/**
 * ���롼�ץե������ɬ�ܹ������ϥ����å�
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥������Ȥ�����
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Required_Groupform($param, $f_name){

    // ����ο������롼��
    foreach ($f_name as $key => $val){
        // ���󤬤���Х��顼�ե饰��Ω�Ƥ�
        $ary_err_flg[] = ($val == null) ? true : false;
    }

    // ���顼�ե饰true�ξ���false���֤�
    return (in_array(true, $ary_err_flg)) ? false : true;

}


/**
 * ���롼�ץե������Ⱦ�ѿ��������å�
 *
 * �ѹ�����
 * 1.0.0 (2006 ��ʬ)    ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006 ��ʬ)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥������Ȥ�����
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Numeric_Groupform($param, $f_name){

    // �������Ϥ���Ƥ�����
    if (Required_Groupform($param, $f_name) == true){

        // ����ο������롼��
        foreach ($f_name as $key => $val){
            // Ⱦ�ѿ����ʳ�������Х��顼�ե饰��Ω�Ƥ�
            $ary_err_flg[] = (!ereg("^[0-9]+$", $val)) ? true : false;
        }

        // ���顼�ե饰true�ξ���false���֤�
        return (in_array(true, $ary_err_flg)) ? false : true;

    // ���󤬤�����
    }else{

        // �����å�����true���֤�
        return true;

    }

}


/**
 * ���롼�ץե������Ⱦ�ѿ����ܥϥ��ե�����å�
 *
 * �ѹ�����
 * 1.0.0 (2006/02/06)    ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥������Ȥ�����
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Numhyphen_Groupform($param, $f_name){

    // �������Ϥ���Ƥ�����
    if (Required_Groupform($param, $f_name) == true){

        // ����ο������롼��
        foreach ($f_name as $key => $val){
            // Ⱦ�ѿ����ܥϥ��ե�ʳ�������Х��顼�ե饰��Ω�Ƥ�
            $ary_err_flg[] = (!ereg("^[0-9-]+$", $val)) ? true : false;
        }

        // ���顼�ե饰true�ξ���false���֤�
        return (in_array(true, $ary_err_flg)) ? false : true;

    // ���󤬤�����
    }else{

        // �����å�����true���֤�
        return true;

    }

}


/**
 * ���롼�ץե������Ⱦ�ѱѿ����ܥϥ��ե�ܥ�����������������å�
 * �ѥ���ɥ����å���
 *
 * �ѹ�����
 * 1.0.0 (2006/02/06)    ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥������Ȥ�����
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Password_Groupform($param, $f_name){

    // �������Ϥ���Ƥ�����
    if (Required_Groupform($param, $f_name) == true){

        // ����ο������롼��
        foreach ($f_name as $key => $val){
            // Ⱦ�ѱѿ����ܥϥ��ե�ܥ�������������ʳ�������Х��顼�ե饰��Ω�Ƥ�
            $ary_err_flg[] = (!ereg("^[0-9a-zA-Z_-]+$", $val)) ? true : false;
        }

        // ���顼�ե饰true�ξ���false���֤�
        return (in_array(true, $ary_err_flg)) ? false : true;

    // ���󤬤�����
    }else{

        // �����å�����true���֤�
        return true;

    }

}


/**
 * ���ե��롼�ץե�����������������å�
 * 
 * �ѹ�����
 * 1.0.0 (2006/02/06)    ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006/02/06)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥������Ȥ�����
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Date_Groupform($param, $f_name){

    // �������Ϥ���Ƥ�����
    if (Required_Groupform($param, $f_name) == true){

        // ʸ���󥭡�������Ǽ���
        $key = array_keys($f_name);

        // ���դ������ǤϤʤ�����false���֤�
        return (checkdate($f_name[$key[1]], $f_name[$key[2]], $f_name[$key[0]]) == false) ? false : true;

    // ���󤬤�����
    }else{

        // �����å�����true���֤�
        return true;

    }

}


/**
 * �������������ɥ����å�
 * 
 * �ѹ�����
 * 1.0.0 (2006/02/07)    ���������ʤդ�����
 *
 * @author      �դ���
 *
 * @version     1.0.0 (2006/02/07)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥�������
 *
 * @return      boolean                     ���顼��false
 *
 *
 */
function Ascii($param, $f_name){

    // ���Ϥ�������
    if ($f_name != null){

        // ʸ����ʬ�롼��
        $len = mb_strlen($f_name);
        for ($i = 0; $i < $len; $i++){
            // �������������ɰʳ���ʸ�����������true���֤�
            $ascii_err_flg[] = (ord(mb_substr($f_name, $i, 1)) > 127) ? true : false;
        }

        // ���顼�����ä�����false���֤�
        return (in_array(true, $ascii_err_flg)) ? false : true;

    // ���Ϥ�̵�����
    }else{

        // �����å�����true���֤�
        return true;

    }

}


/**
 *�ե饰��Ƚ�̤���true�ξ���QuickForm�ǥ��顼�ˤ��롣 
 * 
 * �ѹ�����
 * 1.0.0 (2006/02/07)    ���������ʤդ�����
 *
 * @author      watanabe-k
 *
 * @version     1.0.0 (2006/02/07)
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         �ե����४�֥�������
 *
 * @return      boolean                     ���顼��false
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
*TEL��FAX�ֹ�Υ����å�
*
* �ѹ�����
* 1.0.0(2006/11/13)����������kaku-m��
*
* @author    kaku-m
*
*@param boolean  $param       ����
*@param string   $f_name      �ե����४�֥�������̾
*
*/

function Chk_Telfax($param,$f_name){
    //���Ϥ�������
    if($f_name != null){
        //Ⱦ�ѿ����ȴ֤�����ϥ��ե��-�ˤΤ߲�
        if(ereg("(^[0-9]{1}([0-9]*-?[0-9]+)*[0-9]+$)+",$f_name) != false){
            //��������ɽ���ξ��true���֤�
            return true;
        }else{
            //�������ʤ���硢false���֤�
            return false;
        }
    //���ξ��
    }else{
        //true���֤�
        return true;
    }
}


/**
 * �ͤ�1��100�ο��ͤ������å�
 *
 * �ѹ�����
 * 1.0.0 (2007/05/08)   ��������
 *
 * @author      kj
 *
 * @version     1.0.0
 *
 * @param       boolean     $param          ����
 * @param       string      $f_name         ���ա�ǯ�����˥ե����४�֥������Ȥ�����̾
 *
 * @return      boolean                     ���顼��false
 *
 */
function Check_Percent_Qf($param, $f_name)
{
    return ($f_name >= 0 && $f_name <= 100) ? true : false;
}


?>