<?php

/**
 * ����     analysis �ѥե����ॻ�å�
 *
 * ����     �������ܤ��������� <br>
 *
 * �ѹ����� <br>
 * 2007-10-28   aizawa-m    ����̾��maxlength�� 15��30 ���ѹ�
 *
 *  ����                ������  �ե�����̾ <br>
 *  -------------------------------------------------------- <br>
 *  ���Ϸ���            radio   [form_output_type]  <br>
 *  ���ǯ��(����)      text    [form_trade_ym_s]   <br>
 *  ���ǯ��(��λ)      radio   [form_trade_ym_e]   <br>
 *  ������              text    [form_client]       <br>
 *  ����(8��)           text    [form_goods]        <br>
 *  ����Ψ              radio   [form_margin]       <br>
 *  ɽ���о�            radio   [form_out_range]    <br>
 *  �ܵҶ�ʬ            select  [form_rank]         <br>
 *  M��ʬ               select  [form_g_goods]      <br>
 *  ������ʬ            select  [form_product]      <br>
 *  ����ʬ��            select  [form_g_product]    <br>
 *  �ȼ�(��ʬ��)        select  [form_lbtype]       <br>
 *  �����ӥ�̾          select  [form_serv]         <br>
 *  ���롼��                    [form_cilent_gr]    <br>
 *  ����о�            radio   [form_out_abstract] <br>
 *
 *
 * @param   object      $db_con         DB��³�꥽����
 * @param   string      $form           �ե����४�֥�������
 * @param   array       $def_fdata      �ե�����ǥե�����������Ǥ�ա�
 *
 * @return  void
 *
 * ABC�Ѥ����եե���������
 */
function Mk_Form ($db_con, $form, $def_fdata = null) {

    /****************************/
    // �ե�������������
    /****************************/
    // �ե��������ͤ��Ϥ���ʤ��ä����
    if ($def_fdata == null){
        $def_fdata = array(
            "form_output_type"  => "1",
            "form_trade_ym_s"   => array("y" => date("Y"), "m" => "01"),
            "form_trade_ym_e"   => "12",
            "form_trade_ym_e_abc"   => "12",
            "form_margin"       => "1",
            //"form_out_amount"   => "1",
            "form_out_range"    => "1",
            "form_out_abstract" => "1",
        );
    }

    // �ե��������ͥ��å�
    $form->setDefaults($def_fdata);

    /****************************/
    // �ե��������
    /****************************/
    // global css
    global $g_form_option, $g_form_option_select;

    // ���Ϸ���
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "����", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "CSV",  "2");
    $form->addGroup($obj, "form_output_type", "", " ");

    // ���ǯ��ʳ��ϡ�
    Addelement_Date_YM($form, "form_trade_ym_s", "���ǯ��", "-");

    // ���ǯ��ʽ�λ��
    $obj    =   null;
    //$obj[]  =&  $form->createElement("radio", null, null,  "������1����", "1");
    //$obj[]  =&  $form->createElement("radio", null, null,  "������2����", "2");
    $obj[]  =&  $form->createElement("radio", null, null,  "3����",  "3");
    $obj[]  =&  $form->createElement("radio", null, null,  "6����",  "6");
    $obj[]  =&  $form->createElement("radio", null, null, "12����", "12");
    $form->addGroup($obj, "form_trade_ym_e", "", " ");

    // ���ǯ��ʽ�λ��
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null,  "1����",  "1");
    $obj[]  =&  $form->createElement("radio", null, null,  "3����",  "3");
    $obj[]  =&  $form->createElement("radio", null, null,  "6����",  "6");
    $obj[]  =&  $form->createElement("radio", null, null, "12����", "12");
    $form->addGroup($obj, "form_trade_ym_e_abc", "", " ");

    // ����åס������衦�����襳����(6��-4�� ̾��)
    // �����襳���ɤȤ��ƻ��Ѥ������template¦�ǻ����Ǥޤǻ��ꤷ�Ʋ������ʥ�����2��Ф��ʤ�����ˡ�
    Addelement_Client_64n($form, "form_client", "", "-");

    // ���ʡ�8���
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "cd", "", "size=\"10\" maxLength=\"8\" class=\"ime_disabled\" $g_form_option");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"34\" maxLength=\"30\" $g_form_option");
    $form->addGroup($obj, "form_goods", "", "");

    // ����Ψ
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "ɽ��",   "1");
    $obj[]  =&  $form->createElement("radio", null, null, "��ɽ��", "2");
    $form->addGroup($obj, "form_margin", "", " ");

    // ���϶�ۡʻȤ�ʤ��ʤä���ä�����
    //$obj    =   null;
    //$obj[]  =&  $form->createElement("radio", null, null, "�����", "1");
    //$obj[]  =&  $form->createElement("radio", null, null, "�����׳�", "2");
    //$form->addGroup($obj, "form_out_amount", "", " ");

    // ɽ���о�
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "���0�ʳ�", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "����",      "2");
    $form->addGroup($obj, "form_out_range", "", " ");

    // ����о� 
    $obj    =   null;
    $obj[]  =&  $form->createElement("radio", null, null, "���۰ʳ�", "1");
    $obj[]  =&  $form->createElement("radio", null, null, "����",     "2");
    $form->addGroup($obj, "form_out_abstract", "", " ");

    // �ܵҶ�ʬ
    $item   =   null;
    $item   = Select_Get($db_con, "rank");
    $form->addElement("select", "form_rank", "", $item, $g_form_option_select);

    // �Ͷ�ʬ
    $item   =   null;
    $item   =   Select_Get($db_con, "g_goods");
    $form->addElement("select", "form_g_goods", "", $item, $g_form_option_select);

    // ������ʬ
    $item   =   null;
    $item   =   Select_Get($db_con, "product");
    $form->addElement("select", "form_product", "", $item, $g_form_option_select);

    // ����ʬ��
    $item   =   null;
    $item   =   Select_Get($db_con, "g_product");
    $form->addElement("select", "form_g_product", "", $item, $g_form_option_select);

    // ô����̾
    $item   =   null;
    $item   =   Select_Get($db_con, "cstaff");
    $form->addElement("select", "form_staff", "", $item, $g_form_option_select);

    // �ȼ����ʬ���
    $item   =   null;
    $item   =   Select_Get($db_con, "lbtype");
    $form->addElement("select", "form_lbtype","", $item, $g_form_option_select);

    // �����ӥ�̾
    $item   =   null;
    $item   =   Select_Get($db_con, "serv");
    $form->addElement("select", "form_serv", "", $item, $g_form_option_select);

    // ��°�ܻ�Ź
    $item   =   null;
    $item   =   Select_Get($db_con, "branch");
    $form->addElement("select", "form_branch", "", $item, $g_form_option_select);

    // ���� 
    $item   =   null;
    $item   =   Select_Get($db_con, "part");
    $form->addElement("select", "form_part", "", $item, $g_form_option_select);

    // FC���������ʬ
    $item   =   null;
    $item   =   Select_Get($db_con, "rank");
    $form->addElement("select", "form_rank", "", $item, $g_form_option_select);

    // ���롼�ץޥ���
    $obj    =   null;
    $item   =   null;
    $item   =   Select_Get($db_con, "client_gr");
    $obj[]  =&  $form->createElement("text", "name", "", "size=\"40\" maxlength=\"20\" onFocus=\"onForm(this);\" onBlur=\"blurForm(this);\"" );
    $obj[]  =&  $form->createElement("select", "cd", "", $item, $g_form_option_select);
    $form->addGroup($obj, "form_client_gr", "", " ");

    // ����åס�����
    $obj    =   null;
    $item   =   null;
    $item   =   Make_Shop_Part_Hierselect($db_con);
    $obj    =&  $form->addElement("hierselect", "form_shop_part", "", "$g_form_option_select", " ");
    $obj->setOptions($item);

    // ɽ���ܥ���
    $form->addElement("submit", "form_display", "ɽ����");

    // ���ꥢ�ܥ���
    $form->addElement("button", "form_clear", "���ꥢ", "onClick=\"javascript: location.href('".$_SERVER["PHP_SELF"]."');\"");

}


/**
 * ����     HTML_QuickForm�����Ѥ��Ƽ���襳���ɤ����ϥե�����������6��-4�� �����̾��
 *
 * ����     �����ɣ��������ɣ��������̾�Υե�����̾�����ꤵ��ʤ���硢cd1, cd2, name�Ȥʤ�ޤ�<br>
 *
 * �ѹ����� <br>
 * 2007-10-28   aizawa-m    �����̾��maxlenght�� 15��25 ���ѹ� <br>
 *
 * @param   object      $form           HTML_QuickForm���֥�������
 * @param   string      $form_name      HTML�ǤΥե�����̾
 * @param   string      $label          ɽ��̾
 * @param   string      $ifs            ���ڤ�ʸ��
 * @param   string      $cd1            �����ɣ��Υե�����̾
 * @param   string      $cd2            �����ɣ��Υե�����̾
 * @param   string      $name           �����̾�Υե�����̾
 * @param   string      $option         �ʤˤ������
 *
 * @return  object      $gr_obj         �ե����४�֥�������
 *
 */
function Addelement_Client_64n ($form, $form_name, $label = "", $ifs = "", $cd1 = "cd1", $cd2 = "cd2", $name = "name", $option = ""){

    // global css
    global $g_form_option;

    // js�ѥե�����̾
    $form_cd1       = "$form_name"."[".$cd1."]";
    $form_cd2       = "$form_name"."[".$cd2."]";

    // °����js
    $sizelen_cd1    = "size=\"7\" maxLength=\"6\" ";
    $sizelen_cd2    = "size=\"4\" maxLength=\"4\" ";
    $sizelen_name   = "size=\"34\" maxLength=\"25\" ";
    $onkeyup_cd1    = "onkeyup=\"changeText(this.form, '$form_cd1', '$form_cd2', 6);\" ";
    $onkeydown      = "onKeyDown=\"chgKeycode();\" ";
    $onfocus        = "onFocus=\"onForm(this);\" ";
    $onblur         = "onBlur=\"blurForm(this);\" ";
    $form_option_64 = "class=\"ime_disabled\" ".$option;
    $form_option_n  = $option;

    // �ե��������
    $obj    =   null;
    $obj[]  =&  $form->createElement("text", "$cd1", "", "$sizelen_cd1 $onkeyup_cd1 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", "$ifs");
    $obj[]  =&  $form->createElement("text", "$cd2", "", "$sizelen_cd2 $onkeydown $onfocus $onblur $form_option_64");
    $obj[]  =&  $form->createElement("static", "", "", " ");
    $obj[]  =&  $form->createElement("text", "$name", "", "$sizelen_name $onkeydown $g_form_option $form_option_n");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     HTML_QuickForm�����Ѥ������դ����ϥե���������
 *
 * ����     ǯ����Υե�����̾�����ꤵ��ʤ���硢y, m�Ȥʤ�ޤ�
 *
 * @param   object      $form           HTML_QuickForm���֥�������
 * @param   string      $form_name      HTML�ǤΥե�����̾
 * @param   string      $label          ɽ��̾
 * @param   string      $ifs            ���ڤ�ʸ��
 * @param   string      $yy             ǯ�Υե�����̾
 * @param   string      $mm             ��Υե�����̾
 * @param   string      $option         �ʤˤ������
 *
 * @return  object      $gr_obj         �ե����४�֥�������
 *
 */
function Addelement_Date_YM ($form, $form_name, $label = "", $ifs = "", $yy = "y", $mm = "m", $option = "") {

    // js�ѥե�����̾
    $form_y     = "$form_name"."[".$yy."]";
    $form_m     = "$form_name"."[".$mm."]";

    // °����js
    $sizelen_y  = "size=\"4\" maxLength=\"4\" ";
    $sizelen_m  = "size=\"1\" maxLength=\"2\" ";
    $onkeyup_y  = "onkeyup=\"changeText(this.form, '$form_y', '$form_m', 4);\" ";
    $onfocus    = "onfocus=\"Onform_Thisyear_Jan_YM(this, this.form, '$form_name', '$form_y', '$form_m');\" ";
    $onblur     = "onBlur=\"blurForm(this);\" ";
    $onkeydown  = "onKeyDown=\"chgKeycode();\" ";
    $form_option= "class=\"ime_disabled\" ".$option;

    // �ե��������
    $obj = null;
    $obj[] =& $form->createElement("text", "$yy", "", "$onkeyup_y $sizelen_y $onfocus $onblur $onkeydown $form_option");
    $obj[] =& $form->createElement("static", "", "", $ifs);
    $obj[] =& $form->createElement("text", "$mm", "", "$sizelen_m $onfocus $onblur $onkeydown $form_option");
    $gr_obj = $form->addGroup($obj, $form_name, $label, "");

    return $gr_obj;

}


/**
 * ����     ����åס�����Υҥ����쥯�ȥե���������ؿ��������ѡ�
 *
 * ����     �ҥ����쥯�Ȥ������Ǥ��衼�äơ�
 *
 * @param       $db_con     de-bi-konn
 *
 * @return      $res        ����åס����������
 *
 */
function Make_Shop_Part_Hierselect($db_con){

    // �ǡ����������������
    $sql  = "SELECT \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_rank.rank_name, \n";
    $sql .= "   t_client.client_id, \n";
    $sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2  AS client_cd, \n";
    $sql .= "   t_client.client_cname, \n";
    $sql .= "   t_part.part_id, \n";
    $sql .= "   t_part.part_cd, \n";
    $sql .= "   t_part.part_name \n";
    $sql .= "FROM \n";
    $sql .= "   t_rank \n";
    $sql .= "   LEFT JOIN t_client ON  t_rank.rank_cd       = t_client.rank_cd \n";
    $sql .= "   LEFT JOIN t_attach ON  t_client.client_id   = t_attach.shop_id \n";
    $sql .= "   LEFT JOIN t_part   ON  t_attach.part_id     = t_part.part_id   \n";
    $sql .= "WHERE \n";
    $sql .= "   t_client.client_div = '3' \n";
    $sql .= "ORDER BY \n";
    $sql .= "   t_rank.rank_cd, \n";
    $sql .= "   t_client.client_cd1, \n";
    $sql .= "   t_client.client_cd2, \n";
    $sql .= "   t_part.part_cd \n";
    $sql .= ";";

    // �ǡ�������
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // 1��ʾ夢����
    if ($num > 0){

        for ($i=0; $i<$num; $i++){

            // �ǡ��������ʥ쥳�������
            $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);

            // �Ƴ��ؤ�ID���ѿ�������
            $hier1_id = $data_list[$i]["rank_cd"];
            $hier2_id = $data_list[$i]["client_id"];
            $hier3_id = $data_list[$i]["part_id"];

            ///// ��1���������������
            if ($data_list[$i]["rank_cd"] != $data_list[$i-1]["rank_cd"]){
                $ary_hier1[$hier1_id]  = $data_list[$i]["rank_cd"];
                $ary_hier1[$hier1_id] .= " �� ";
                $ary_hier1[$hier1_id] .= htmlentities($data_list[$i]["rank_name"], ENT_COMPAT, EUC);
            }

            ///// ��2���������������
            if ($data_list[$i]["rank_cd"]   != $data_list[$i-1]["rank_cd"] ||
                $data_list[$i]["client_cd"] != $data_list[$i-1]["client_cd"]){
                if ($data_list[$i]["client_cd"] != null) {
                    $ary_hier2[$hier1_id][$hier2_id]  = $data_list[$i]["client_cd"];
                    $ary_hier2[$hier1_id][$hier2_id] .= " �� ";
                    $ary_hier2[$hier1_id][$hier2_id] .= htmlentities($data_list[$i]["client_cname"], ENT_COMPAT, EUC);
                }else{
                    $ary_hier2[$hier1_id][$hier2_id]  = null;
                }
            }

            ///// ��3���������������
            if ($data_list[$i]["rank_cd"]   != $data_list[$i-1]["rank_cd"] ||
                $data_list[$i]["client_cd"] != $data_list[$i-1]["client_cd"] ||
                $data_list[$i]["part_cd"]   != $data_list[$i-1]["part_cd"]){
                if ($data_list[$i]["rank_cd"]   != $data_list[$i-1]["rank_cd"] ||
                    $data_list[$i]["client_cd"] != $data_list[$i-1]["client_cd"]){
                    $ary_hier3[$hier1_id][$hier2_id][null] = "";
                }
                if ($data_list[$i]["part_cd"] != null) {
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id]  = $data_list[$i]["part_cd"];
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id] .= " �� ";
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id] .= htmlentities($data_list[$i]["part_name"], ENT_COMPAT, EUC);
                } else {
                    $ary_hier3[$hier1_id][$hier2_id][$hier3_id]  = null;
                }
            }
        }

        // 1�Ĥ�����ˤޤȤ��֤�
        return array($ary_hier1, $ary_hier2, $ary_hier3);

    // 1���̵�����
    }else{

        // ����������֤�
        $array[null] = "";
        return array($array, $array, $array);

    }

}


/**
 * ����     ǯ��ե�����Υ��顼�����å�
 *
 * ����     ɬ�ܥ����å������ͥ����å������դȤ��Ƥ������������å�<br>
 *          �ؿ���� setElementError ����
 *
 * @param   object      $form       HTML_QuickForm���֥�������
 * @param   string      $form_name  �ե�����̾��addGroup �Υ��롼��̾��
 * @param   string      $err_msg    ���顼��å�������Ǥ�ա�
 *
 * @return  void
 *
 */
function Err_Chk_Date_YM ($form, $form_name = null, $err_msg = null) {

    // POST��������˽�����Ԥ�
    if ($_POST != null) {

        // ���դΥե�����̾
        $form_name = ($form_name == null) ? "form_trade_ym_s" : $form_name;

        // ���顼��å��������
        $err_msg = ($err_msg == null) ? "���״��� ������������ޤ���" : $err_msg;

        // POST���줿���եե�������ͤ�����˥��å�
        $ary_keys = array_keys($_POST[$form_name]);
        $ary_vals = array_values($_POST[$form_name]);

        // ��ɬ�ܥ����å�
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "required")),
            $ary_keys[1] => array(array($err_msg, "required")),
        ));

        // �����ͥ����å�
        $form->addGroupRule($form_name, array(
            $ary_keys[0] => array(array($err_msg, "regex", "/^[0-9]+$/")),
            $ary_keys[1] => array(array($err_msg, "regex", "/^[0-9]+$/")),
        ));

        // ��ǯ��Ȥ��Ƥ������������å�
        // ǯ��������Ϥ�������
        if ($ary_vals[0] != null && $ary_vals[1] != null){
            // ǯ������դȤ����������������å�
            if (!checkdate((int)$ary_vals[1], 1, (int)$ary_vals[0])) {
                $form->setElementError($form_name, $err_msg);
            }
        }

    }

}

?>
