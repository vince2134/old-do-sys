<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-03-22                  watanabe-k  �����ɼ��ɽ�����ʤ��褦�˽���
 *  2007-03-22                  watanabe-k  �إå���ɽ������ܥ����ɽ��
 *  2007-04-12                  fukuda      ����������������ɲ�
 *  2007-05-14                  watanabe-k  ���������ȯ������ɽ��
 *  2007-05-15                  watanabe-k  ͽ����ɼȯ�Ե�ǽ���ɲ�
 *  2007-05-22                  watanabe-k  ���̤Υ����ȥ���ѹ�
 *  2007-05-23                  watanabe-k  ɽ������ǡ����Υ��롼�ԥ󥰤��ѹ�
 *
*/

$page_title = "��Դ��ֽ���ɽ";

// �Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

// ����ؿ����
require_once(INCLUDE_DIR."function_keiyaku.inc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"], "", "target=_self");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"  => "1",
    "form_client_branch"=> "",
    "form_client"       => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_claim"        => array("cd1" => "", "cd2" => "", "name" => ""),
    "form_round_day"    => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => date("d"),
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("d"),
    ),
    "form_charge_fc"    => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
);

// �����������
Restore_Filter2($form, "contract", "form_show_button", $ary_form_list);


/****************************/
// ���å��������å�
/****************************/
if ($_SESSION["group_kind"] != "2"){
    header("Location: ".FC_DIR."top.php");
}

/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"]; 


/****************************/
// ���������
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */
Search_Form($db_con, $form, $ary_form_list);

// ��ɬ�פʥե��������
$form->removeElement("form_attach_branch");
$form->removeElement("form_round_staff");
$form->removeElement("form_multi_staff");
$form->removeElement("form_part");
$form->removeElement("form_ware");
$form->removeElement("form_claim_day");

/* �⥸�塼���̥ե����� */
// ɽ���ܥ���
/*
$form->addElement("button", "form_show_button", "ɽ����",
    "onClick=\"javascript: Button_Submit('show_button_flg', '".$_SERVER["PHP_SELF"]."', 'true');\""
);
*/
$form->addElement("submit", "form_show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// �������å��ѥ����å��ܥå���
$form->addElement("checkbox", "aord_prefix_all", "������", "����������(0)",
    "onClick=\"javascript:All_Check_Preslip('aord_prefix_all');\""
);
$form->addElement("checkbox", "aord_unfix_all", "��������", "���ֽ�������(1)",
    "onClick=\"javascript:All_Check_Unslip('aord_unfix_all');\""
);
$form->addElement("checkbox", "aord_fix_all", "��ȯ��", "(1)��ȯ��",
    "onClick=\"javascript:All_Check_Slip('aord_fix_all');\""
);
$form->addElement("checkbox", "slip_out_all", "�����ɼȯ��", "�����ɼȯ��",
    "onClick=\"javascript:All_Slip_Check('slip_out_all');\""
);
$form->addElement("checkbox", "reslip_out_all", "��ȯ��", "��ȯ��",
    "onClick=\"javascript:All_Reslip_Check('reslip_out_all');\""
);





// ������������ܥ���
$form->addElement("button", "form_preslipout_button", "����������(0)",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-117.php','form_hdn_submit','������ȯ��');\""
);
$form->addElement("button", "form_slipout_button", "���ֽ�������(1)",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-117.php','form_hdn_submit','��������ȯ��');\""
);
$form->addElement("button", "form_reslipout_button", "(1)��ȯ��",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-117.php','form_hdn_submit', '���ơ�ȯ���ԡ�');\""
);

$form->addElement("button", "slip_out_button", "�����ɼȯ��",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '�����ɼȯ��');\""
);

$form->addElement("button", "reslip_out_button", "���ơ�ȯ���ԡ�",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '��ȯ��');\""
);

// �إå���ɽ������ܥ���
$form->addElement("button", "2-2-113_button", "��������",     "onClick=\"location.href='./2-2-113.php'\"");
$form->addElement("button", "2-2-116_button", "��Դ��ֽ���ɽ",   "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");
$form->addElement("button", "2-2-204_button", "ͽ����ɼȯ��", "onClick=\"location.href='./2-2-204.php'\"");
$form->addElement("button", "2-2-111_button", "����ͽ��в�", "onClick=\"location.href='./2-2-111.php'\"");


// ɽ���ܥ��󲡲��ե饰
$form->addElement("hidden", "show_button_flg");

// Ģɼ���ϥܥ���ե饰
$form->addElement("hidden", "form_hdn_submit");

// ���ɽ���ե饰
$form->addElement("hidden", "renew_flg", "t");

// �⥸�塼��Ƚ���ѡ������ɼȯ�Ԥǻ��ѡ�
$form->addElement("hidden", "src_module", "��Խ���ɽ");

/****************************/
// ���٥��Ƚ�̥ե饰����
/****************************/
/*
$show_button_flg = ($_POST["show_button_flg"] == "true") ? true : false;
$submit_flg      = ($show_button_flg == false  && $_POST["renew_flg"] == "t") ? true : false;
*/
$show_button_flg = ($_POST["form_show_button"] != null) ? true : false;
$submit_flg      = ($_POST["form_show_button"] == null && $_POST != null) ? true : false;


/****************************/
// �ƥ��٥�Ƚ���
/****************************/
//ɽ���ܥ��󲡲�
if($show_button_flg == true){

    // ����POST�ǡ�����0���
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);
    $form->addGroupRule('form_round_day', array(
            'sy' => array(
                    array('ͽ��������ɬ�����ϤǤ���', 'required')
            ),      
            'sm' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            ),      
            'sd' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            ),         
            'ey' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            ),         
            'em' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            ),         
            'ed' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            ),         
    ));

    /****************************/
    // ���顼�����å�
    /****************************/
    // �����̥ե���������å�
    Search_Err_Chk($form);

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

    //ɽ���ܥ���ե饰���ꥢ
    $set_data["show_button_flg"] = "";

}


/****************************/
// 1. ɽ���ܥ��󲡲��ܥ��顼�ʤ���
// 2. �ڡ����ڤ��ؤ���������¾��POST��
/****************************/
if (($show_button_flg == true && $err_flg != true) || $submit_flg == true){

    // ����POST�ǡ�����0���
    $_POST["form_round_day"] = Str_Pad_Date($_POST["form_round_day"]);

    // 1. �ե�������ͤ��ѿ��˥��å�
    // 2. SESSION��hidden�ѡˤ��͡ʸ�����������ؿ���ǥ��åȡˤ��ѿ��˥��å�
    // ����������������˻���
    $where["display_num"]       = $_POST["form_display_num"];
    $where["client_branch"]     = $_POST["form_client_branch"];
    $where["client_cd1"]        = $_POST["form_client"]["cd1"];
    $where["client_cd2"]        = $_POST["form_client"]["cd2"];
    $where["client_name"]       = $_POST["form_client"]["name"];
    $where["claim_cd1"]         = $_POST["form_claim"]["cd1"];
    $where["claim_cd2"]         = $_POST["form_claim"]["cd2"];
    $where["claim_name"]        = $_POST["form_claim"]["name"];
    $where["round_day_sy"]      = $_POST["form_round_day"]["sy"];
    $where["round_day_sm"]      = $_POST["form_round_day"]["sm"];
    $where["round_day_sd"]      = $_POST["form_round_day"]["sd"];
    $where["round_day_ey"]      = $_POST["form_round_day"]["ey"];
    $where["round_day_em"]      = $_POST["form_round_day"]["em"];
    $where["round_day_ed"]      = $_POST["form_round_day"]["ed"];
    $where["charge_fc_cd1"]     = $_POST["form_charge_fc"]["cd1"];
    $where["charge_fc_cd2"]     = $_POST["form_charge_fc"]["cd2"];
    $where["charge_fc_name"]    = $_POST["form_charge_fc"]["name"];
    $where["charge_fc_select"]  = $_POST["form_charge_fc"]["select"]["1"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������
/****************************/
if ($post_flg == true && $err_flg != true){

    // �����������
    $total_count = Get_Aord_Data($db_con, $where, "", "", "count");

    // 1�ڡ�����ɽ�����������ξ��
    if ($where["display_num"] == "1") {
        $range = $total_count;
    } else {
        $range = "100";
    }

    // ���ߤΥڡ�����������å�����
    $page_info = Check_Page($total_count, $range, $_POST["f_page1"]);
    $page      = $page_info[0]; //���ߤΥڡ�����
    $page_snum = $page_info[1]; //ɽ�����Ϸ��
    $page_enum = $page_info[2]; //ɽ����λ���

    // �ڡ����ץ������ɽ��Ƚ��
    if($page == "1"){
        // �ڡ����������ʤ�ڡ����ץ���������ɽ��
        $c_page = NULL;
    }else{
        // �ڡ�����ʬ�ץ�������ɽ��
        $c_page = $page;
    }

    // �ڡ�������
    $html_page  = Html_Page2($total_count, $c_page, 1, $range);
    $html_page2 = Html_Page2($total_count, $c_page, 2, $range);

    // �����ǡ�������
    $aord_data  = Get_Aord_Data($db_con, $where, $page_snum, $page_enum);

    // ɽ�������˽���
    $result_data  = Get_Aord_Html_Data($db_con, $aord_data, $form, $page_snum);

    $aord_data  = $result_data[0];   //ɽ���ǡ���
    $preslip_id = $result_data[1];   //�������о�ID
    $unslip_id  = $result_data[2];   //���������о�ID
    $slip_id    = $result_data[3];   //��ȯ���о�ID
    $sheet_id   = $result_data[4];   //�����ɼȯ��ID
    $resheet_id = $result_data[5];   //��ɼ��ȯ��ID

}




/****************************/
// html
/****************************/
/* �����ơ��֥� */
$html_s .= "\n";
$html_s .= "<table>\n";
$html_s .= "    <tr>\n";
$html_s .= "        <td>\n";
// ���̸����ơ��֥�
$html_s .= Search_Table($form);
// �ܥ���
$html_s .= "<table align=\"right\"><tr><td>\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_show_button"]]->toHtml()."��\n";
$html_s .= "    ".$form->_elements[$form->_elementIndex["form_clear_button"]]->toHtml()."\n";
$html_s .= "</td></tr></table>\n";
$html_s .= "        </td>\n";
$html_s .= "    </tr>\n";
$html_s .= "</table>\n";
$html_s .= "\n";

/****************************/
// js
/****************************/
// ��������ALL�����å�JS�������
$javascript .= Create_Allcheck_Js("All_Check_Preslip", "form_preslip_out", $preslip_id);
// ��������(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js("All_Check_Unslip",  "form_unslip_out",  $unslip_id);
// ��ȯ��(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js("All_Check_Slip",    "form_slip_out",    $slip_id);
// ��ɼȯ��(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js("All_Slip_Check",    "form_slip_check",    $sheet_id);
// ��ɼ��ȯ��(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js("All_Reslip_Check",    "form_reslip_check",    $resheet_id);

// �ܥ����POST���Ϥ�
$javascript  .= "function Post_Next_Page(page,hidden_form, mesg){\n";
$javascript  .= "   var hdn = hidden_form;\n";
$javascript  .= "   document.dateForm.elements[hdn].value = mesg;\n";
$javascript  .= "   //�̲��̤ǥ�����ɥ��򳫤�\n";
$javascript  .= "   document.dateForm.target=\"_blank\";\n";
$javascript  .= "   document.dateForm.action=page;\n";
$javascript  .= "   //POST�������������\n";
$javascript  .= "   document.dateForm.submit();\n";
$javascript  .= "   document.dateForm.target=\"_self\";\n";
$javascript  .= "   document.dateForm.action='".$_SERVER["PHP_SELF"]."';\n";
$javascript  .= "}\n";


/****************************/
//�ؿ�����
/****************************/
//��ԥǡ������
function Get_Aord_Data($db_con, $where, $page_snum, $page_enum, $kind=""){
    //������ɽ�����ּ���
    $cal_array = Cal_range($db_con,$_SESSION["client_id"],true);
    $end_day   = $cal_array[1];     //�оݽ�λ����

    $offset = $page_snum-1; //ɽ�����ʤ����
    $limit  = ($page_enum - $page_snum) +1;    //��ڡ���������η��

    //**************************//
    //HTML��value�ͤ�SQL�Ѥ˲ù�
    //**************************//
    $round_day_s = $where["round_day_sy"]."-".$where["round_day_sm"]."-".$where["round_day_sd"];
    $round_day_e = $where["round_day_ey"]."-".$where["round_day_em"]."-".$where["round_day_ed"];

    /****************************/
    //����ǡ��������SQL
    /****************************/
    $sql_column = "
        SELECT
            t_aorder_h.ord_time,
            CAST(t_aorder_h.act_cd1 AS text) || '-' || CAST(t_aorder_h.act_cd2 AS text) AS shop_cd,
            t_client.shop_name,
            COUNT(t_aorder_h.ord_time) AS count, 
            t_aorder_h.act_id,
--            t_aorder_h.act_name 
            MAX(t_aorder_h.daily_slip_out_day) AS daily_slip_out_day,
            MAX(t_aorder_h.slip_out_day) AS slip_out_day,
            daily_slip_id 
    ";

    $sql = "
        FROM 
            t_aorder_h
                INNER JOIN
            t_client
            ON t_aorder_h.act_id = t_client.client_id 
            AND (t_aorder_h.contract_div = '2' OR t_aorder_h.contract_div = '3') 
                INNER JOIN
            t_client AS t_client1
            ON t_aorder_h.client_id = t_client1.client_id
        WHERE
            t_aorder_h.shop_id IN (".Rank_Sql().")
            AND
            t_aorder_h.del_flg = false
            AND
            t_aorder_h.ord_time <= '$end_day' 
    ";

    // ��������ɲ�
    // ����������ʳ��ϡ�
    if($round_day_s != "--"){
        $sql .= "AND t_aorder_h.ord_time >= '$round_day_s' ";
    }

    // ����������ʽ�λ��
    if($round_day_e != "--"){
        $sql .= "AND t_aorder_h.ord_time <= '$round_day_e' ";
    }

    // ������
    // �����襳���ɣ������Ϥ��줿���
    if($where["client_cd1"] != null){
        $sql .= "AND t_aorder_h.client_cd1 LIKE '".$where["client_cd1"]."%' ";
    }

    // �����襳���ɣ������Ϥ��줿���
    if($where["client_cd2"] != null){
        $sql .= "AND t_aorder_h.client_cd2 LIKE '".$where["client_cd2"]."%' ";
    }

    // ������̾�����Ϥ��줿���
    if($where["client_name"] != null){
        // ������̾
        $sql .= "AND (t_aorder_h.client_name  LIKE '%".$where["client_name"]."%' ";
        // ������̾��
        $sql .= "OR t_aorder_h.client_name2 LIKE '%".$where["client_name"]."%' ";
        // ������̾��ά�Ρ�
        $sql .= "OR t_aorder_h.client_cname LIKE '%".$where["client_name"]."%' ";
        // ������̾�ʥեꥬ�ʡ�
        $sql .= "OR t_aorder_h.client_id IN (
                    SELECT 
                        t_client.client_id 
                    FROM 
                        t_client 
                    WHERE 
                        t_client.client_div = '1' 
                        AND
                        t_client.client_read LIKE '%".$where["client_name"]."%'
                        AND
                        t_client.shop_id IN (".Rank_Sql().")
                    )
                ) 
            ";
    }

    // ������
    if($where["claim_cd1"] != null || $where["claim_cd2"] != null || $where["claim_name"] != null){
        $sql .= "AND t_aorder_h.claim_id IN (
                SELECT 
                    t_client.client_id 
                FROM 
                    t_client 
                WHERE 
                    t_client.client_div = '1' 
                    AND
                    t_client.shop_id IN (".Rank_Sql().") 
        ";

        // �����襳���ɣ�
        if($where["claim_cd1"] != null){
            $sql .= "AND t_client.client_cd1 LIKE '".$where["claim_cd1"]."%' ";
        }

        // �����襳���ɣ�
        if($where["claim_cd2"] != null){
            $sql .= "AND t_client.client_cd2 LIKE '".$where["claim_cd2"]."%' ";
        }

        // ������̾
        if($where["claim_name"] != null){
            // ������̾
            $sql .= "AND (t_client.client_name LIKE '%".$where["claim_name"]."%' ";
            // ������̾��
            $sql .= "OR t_client.client_name2  LIKE '%".$where["claim_name"]."%' ";
            // ������̾��ά�Ρ�
            $sql .= "OR t_client.client_cname  LIKE '%".$where["claim_name"]."%' ";
            // ������̾�ʥեꥬ�ʡ�
            $sql .= "OR t_client.client_read   LIKE '%".$where["claim_name"]."%')";
        }

        $sql .= ") ";
    }

    //������FC
    // ������FC�����ɣ�
    if($where["charge_fc_cd1"] != null){
        $sql .= "AND t_aorder_h.act_cd1 LIKE '".$where["charge_fc_cd1"]."%' ";
    }

    // ������FC�����ɣ�
    if($where["charge_fc_cd2"] != null){
        $sql .= "AND t_aorder_h.act_cd2 LIKE '".$where["charge_fc_cd2"]."%' ";
    }

    // ������FC̾
/*
    if($where["charge_fc_name"] != null){
        // ������FC̾
        $sql .= "AND (t_aorder_h.act_name LIKE '%".$where["charge_fc_name"]."%' ";
        $sql .= "OR  t_aorder_h.act_id IN (
                        SELECT 
                            t_client.client_id 
                        FROM 
                            t_client 
                        WHERE 
                            t_client.client_div = '3' 
            ";
        // ������FC̾2
        $sql .= "AND (t_client.client_name2 LIKE '%".$where["charge_fc_name"]."%' ";
        $sql .= "OR   t_client.client_cname LIKE '%".$where["charge_fc_name"]."%' ";
        $sql .= "OR   t_client.client_read  LIKE '%".$where["charge_fc_name"]."%')";
        $sql .= ")) ";
    }
*/
    if ($where["charge_fc_name"] != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_aorder_h.act_name   LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.shop_name    LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name  LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_name2 LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "       OR \n";
        $sql .= "       t_client.client_cname LIKE '%".$where["charge_fc_name"]."%' \n";
        $sql .= "   ) \n";
    }

    // ������FC���쥯��
    if ($where["charge_fc_select"] != null){
        $sql .= "AND t_aorder_h.act_id = ".$where["charge_fc_select"]." \n";
    }

    // �ܵ�ô����Ź
    if($where["client_branch"] != null){
        $sql .= "AND t_aorder_h.client_id IN ( ";
        $sql .= "       SELECT ";
        $sql .= "           t_client.client_id ";
        $sql .= "       FROM ";
        $sql .= "           t_client ";
        $sql .="        WHERE ";
        $sql .= "           t_client.charge_branch_id = ".$where["client_branch"]." ";
        $sql .= "   )";
    }

    $group_by = "
        GROUP BY
            t_aorder_h.daily_slip_id, 
            t_aorder_h.ord_time,
            t_aorder_h.act_id,
            t_aorder_h.act_cd1,
            t_aorder_h.act_cd2,
            t_client.shop_name
--            t_aorder_h.act_name 
    ";

    $order_by = "
        ORDER BY
            t_aorder_h.act_cd1,
            t_aorder_h.act_cd2,
            t_aorder_h.ord_time
    ";

    if ($where["count_select"] != "all") {
        $limit_sql .= "LIMIT $limit OFFSET $offset ";
    }


    //�����˳��������ַ���פ��֤��ƽ�λ
    if ($kind == "count") {
        $sql_column = "SELECT COUNT(t_aorder_h.aord_id) AS count ";
        $exec_sql   = "SELECT COUNT(count.count) FROM (".$sql_column.$sql.$group_by." ) AS count";
        $result     = Db_Query($db_con, $exec_sql);
        $data       = pg_fetch_result($result, 0 ,0);
        return $data;

    //������ �����ǡ��������
    } else {
        $exec_sql   = "$sql_column"."$sql"."$group_by"."$order_by"."$limit_sql";
        $result = Db_Query($db_con, $exec_sql);
    }

    if(pg_num_rows($result) > 0){
        $aord_data = pg_fetch_all($result);
    }
    return $aord_data;
}

//��Ԥ��Ȥ���ɼ�ǡ������
function Get_Aord_Html_Data($db_con, $aord_data, $form, $page_snum){
    //������ɽ�����ּ���
    $cal_array = Cal_range($db_con,$_SESSION["client_id"],true);
    $end_day   = $cal_array[1];     //�оݽ�λ����

    $count = count($aord_data);

    $k = 0;     //�����å��ܥå���������
    for($i = 0; $i < $count; $i++){
        //�����ɼ���Ȥ���ɼ���
        $sql  = "SELECT\n";
        $sql .= "   t_aorder_h.aord_id, \n";
        $sql .= "   t_aorder_h.ord_no,  \n";
        $sql .= "   t_client.slip_out, \n";
        $sql .= "   t_aorder_h.slip_out_day \n";
        $sql .= "FROM\n";
        $sql .= "   t_aorder_h \n";
        $sql .= "       INNER JOIN \n";
        $sql .= "   t_client ";
        $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
        $sql .= "WHERE\n";
        $sql .= "   t_aorder_h.act_id = ".$aord_data[$i]["act_id"]."\n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time = '".$aord_data[$i]["ord_time"]."'\n";
        $sql .= "   AND\n";
//        $sql .= "   t_aorder_h.reserve_del_flg = false \n";
        $sql .= "   t_aorder_h.del_flg = false \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

        if($aord_data[$i]["daily_slip_id"] != null){
            $sql .= "   AND";
            $sql .= "   t_aorder_h.daily_slip_id = ".$aord_data[$i]["daily_slip_id"]." \n";
        }else{
            $sql .= "   AND";
            $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
        }

        $sql .= "ORDER BY t_aorder_h.route\n";
        $sql .= ";";

        $result      = Db_Query($db_con, $sql);
        $aord_d_data = pg_fetch_all($result);

        $d_count = count($aord_d_data);

        //��ɼ��������
        $slip_out_count = 0;
        $unslip_out_count = 0;

        for($j = 0; $j < $d_count; $j++){
            //���֤��Ƥ�����ɼ��
            if($aord_d_data[$j]["ord_no"] != null){
                $slip_out_count++;
            //��������ɼ��               
            }else{
                $unslip_out_count++;
            }
            $aord_data[$i]["aord_id"][] = $aord_d_data[$j]["aord_id"];

            //������ޥ�������ɼȯ��ͭ�˻��ꤷ�Ƥ�����
            if($aord_d_data[$j]["slip_out"] == '1'){
                $aord_data[$i]["slip_id"][] = $aord_d_data[$j]["aord_id"];
                $aord_data[$i]["slip_day"][] = $aord_d_data[$j]["slip_out_day"];
            }
        }

        //���ֺѤ�
        $aord_data[$i]["slip_out_count"]    = $slip_out_count;
        //������
        $aord_data[$i]["unslip_out_count"] = $unslip_out_count;

        //����򥷥ꥢ�饤����
        $aord_data[$i]["uni_aord_id"]       = urlencode(serialize($aord_data[$i]["aord_id"]));

        //���˥�������
        $aord_data[$i]["shop_name"]     = htmlspecialchars($aord_data[$i]["shop_name"]);
        $aord_data[$i]["client_name"]   = htmlspecialchars($aord_data[$i]["client_name"]);

        //���
        $aord_data[$i]["ord_time"]  = "<a href=\"./2-2-106.php?aord_id_array=".$aord_data[$i]["uni_aord_id"]."&back_display=act_count\">".$aord_data[$i]["ord_time"]."</a>";

        //�Ԥ��طʿ�
        if($i % 2){
            $aord_data[$i]["bg_color"] = "Result2";
        }else{
            $aord_data[$i]["bg_color"] = "Result1";
        }

        //ưŪ�ե��������
        //��������
        // ����������ɼ��������
        if ($aord_data[$i]["unslip_out_count"] > 0) {
            // ������
            $form->addElement("advcheckbox", "form_preslip_out[$k]", NULL, NULL, NULL, array("f", $aord_data[$i]["uni_aord_id"]));
            $preslip_id[$k] = $aord_data[$i]["uni_aord_id"];
            // ��������ȯ��
            $form->addElement("advcheckbox", "form_unslip_out[$k]", NULL, NULL, NULL, array("f", $aord_data[$i]["uni_aord_id"]));
            $unslip_id[$k] = $aord_data[$i]["uni_aord_id"];

        }else{
            // ��������ȯ����
            $form->addElement("static", "form_unslip_out[$k]", "",$aord_data[$i]["daily_slip_out_day"]);
            $set_data["form_unslip_out"][$k] = $aord_data[$i]["daily_slip_out_day"];

            // ��ȯ��
            $form->addElement("advcheckbox", "form_slip_out[$k]", NULL, NULL, NULL, array("f", $aord_data[$i]["uni_aord_id"]));
            $slip_id[$k] = $aord_data[$i]["uni_aord_id"];

            //ȯ�Ԥ�����ɼ��¸�ߤ�����
            if(is_array($aord_data[$i]["slip_id"])){

                $target_id = null;
                $target_id = implode(',', $aord_data[$i]["slip_id"]);

                //�ޤ��������ȯ�Ԥ��Ƥ��ʤ���ɼ��������
                if(in_array("",$aord_data[$i]["slip_day"])){
                    // ��ɼȯ��
                    $form->addElement("advcheckbox", "form_slip_check[$k]",   NULL, NULL, NULL, array("f", $target_id));
                    $sheet_id[$k] = $target_id;
                }else{
                    //��ɼȯ����
                    $form->addElement("static","form_slip_check[$k]", "", $aord_data[$i]["slip_out_day"]);
                    $set_data["form_slip_check"][$k] = $aord_data[$i]["slip_out_day"];

                    // ��ȯ��
                    $form->addElement("advcheckbox", "form_reslip_check[$k]", NULL, NULL, NULL, array("f", $target_id));
                    $resheet_id[$k] = $target_id;
                }
            }
        }

        $form->setConstants($set_data);

        $aord_data[$i]["no"] = $page_snum++;
        $k++;

    }

    return array($aord_data, $preslip_id, $unslip_id, $slip_id, $sheet_id, $resheet_id);
}

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-113_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-116_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-204_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-111_button"]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'html_page'     => "$html_page",
    'html_page2'    => "$html_page2",
    'javascript'    => "$javascript",
    "post_flg"      => "$post_flg",
    "err_flg"       => "$err_flg",
));
$smarty->assign('aord_data',$aord_data);
$smarty->assign("html", array(
    "html_s"        => $html_s,
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
