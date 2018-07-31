<?php
/*******************************/
//�����ѹ�����
//
// (2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�
// (2006/10/16) (watanabe-k)
//              ���������󤫤�ͽ�����٤����ܤ���ȡ���ɼ����ϩ��ˤʤäƤ��ʤ��Х��ν���
//              ������Ǹ������Ƥ�����褬ɽ������Ƥ��ޤ��Х��ν���
//              ��������¹Ԥ��Ƥ⡢������������Υ����å������ꥢ����ʤ��Х��ν���
/* (2006-11-01�ˡ������ֹ椬�դ�줿�����ɼ��ɽ��<suzuki>
                ��������¦������ô���Ԥθ������Ǥ���褦���ѹ�<suzuki>
                ���ٻ��桦����������������ɼ��ɽ��<suzuki>
                ����������ɽ������ʬɽ��<suzuki>
   (2006-11-02�ˡ�����������Ƚ���ɲ�<suzuki>
   (2006-11-06�ˡ����¦��ͽ��ǡ������٤����ܤǤ���褦�˽���<suzuki>
*/
//
//
/*******************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/10      02-056      suzuki      ô���ԥ����ɤ�Ⱦ�ѿ��������å����ɲ�
 *  2006/11/10      02-053      suzuki      �������ɽ��
 *  2006/11/10      02-054      suzuki      ���ս�˥�����
 *  2006/11/10      02-045      suzuki      �ƣ�¦�ν�������Ǥϡ�Ʊ������Ʊ��ô���Ԥ������ɼ��������ɼ��Ż���
 *  2006/11/13      02-062      suzuki      ��Զ�ʬ�Ǹ����Ǥ���褦�˽���
 *  2006/12/07      ban_0057    suzuki      ���դ򥼥����
 *  2007/01/30                  watanabe-k  ȯ�Է����������ǽ�Ȥ���褦�˽���
 *  2007/02/07                  watanabe-k  ľ�İʳ��ǥ����󤷤����˥����ꥨ�顼���Ǥ�Х��ν���
 *  2007/03/22                  watanabe-k  �إå��Υܥ�����ѹ�
 *  2007/03/27                  watanabe-k  ���ô���ԤΥꥹ�Ȥ򥹥��åեޥ����򸵤˺�������褦�˽��� 
 *  2007/04/06                  watanabe-k  �������ܤ��ѹ�
 *  2007/05/14                  watanabe-k  ȯ������ɽ������褦�˽���
 *  2007/05/22                  watanabe-k  ��Խ���ɽ�Υܥ���̾���ѹ� 
 *  2007/05/22                  watanabe-k  ʸ���ν��� 
 *  2007/07/26                  watanabe-k  ��ɼȯ�Ԥǥ����ꥨ�顼��ɽ�������Х��ν��� 
*/

$page_title = "��������";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."common_quickform.inc");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth   = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"]; 


/****************************/
//�����������
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_display_num"      => "1",
    "form_attach_branch"    => "",
    "form_round_staff"      => array("cd" => "", "select" => ""),
    "form_part"             => "",
    "form_multi_staff"      => "",
    "form_not_multi_staff"  => "",
    "form_ware"             => "",
    "form_charge_fc"        => array("cd1" => "", "cd2" => "", "name" => "", "select" => array("0" => "", "1" => "")),
    "form_round_day"        => array(
        "sy" => date("Y"),
        "sm" => date("m"),
        "sd" => date("d"),
        "ey" => date("Y"),
        "em" => date("m"),
        "ed" => date("d")
    ),
    "form_act_div"          => "1" 
);

// �����������
//Restore_Filter($form, "hdn_show_button_flg", $ary_form_list);
//Restore_Filter($form, "form_show_button", $ary_form_list);
Restore_Filter2($form, "contract", "form_show_button", $ary_form_list);

/****************************/
// ���������
/****************************/
$limit          = null;
$offset         = "0";
$total_count    = "0";
$page_count     = ($_POST["f_page1"] != null) ? $_POST["f_page1"] : "1";

/****************************/
// �ե�����ѡ������
/****************************/
/* ���̥ե����� */

Search_Form($db_con, $form, $ary_form_list);

//ɽ�����ʤ��ե��������
$form->removeElement("form_client");
$form->removeElement("form_claim");
$form->removeElement("form_claim_day");
$form->removeElement("form_client_branch");
$form->removeElement("form_ware");

// �������ô���ԥ����ɡʥ���޶��ڤ��
$form->addElement("text", "form_not_multi_staff", "", "size=\"40\" style=\"$g_form_style\" $g_form_option");

//��Զ�ʬ
$radio = null; 
$radio[] = $form->createElement("radio", null, null, "����ʤ�", "1");
$radio[] = $form->createElement("radio", null, null, "���ҽ��", "2");
$radio[] = $form->createElement("radio", null, null, "���ʬ", "3");
$form->addGroup($radio, "form_act_div", "");

// ɽ���ܥ���
//$form->addElement("button", "form_show_button", "ɽ����", "onClick=\"javascript:Button_Submit('hdn_show_button_flg','$_SERVER[PHP_SELF]','t');\"");
$form->addElement("submit", "form_show_button", "ɽ����", "");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

$search_html = Search_Table($form);

$form->addElement("button", "form_preslipout_button", "����������(0)", 
                "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-114.php','form_hdn_submit','������ȯ��');\" ");
$form->addElement("button", "form_slipout_button", "���ֽ�������(1)", 
                "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-114.php','form_hdn_submit','��������ȯ��');\" ");
$form->addElement("button", "form_reslipout_button", "(1)��ȯ��", 
                    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-114.php','form_hdn_submit', '���ơ�ȯ���ԡ�');\" 
                ");

// �إå���ɽ������ܥ���
$form->addElement("button","slip_button","��������",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","act_button","��Դ��ֽ���ɽ","onClick=\"location.href='./2-2-116.php'\"");
$form->addElement("button","2-2-111_button","����ͽ��в�","onClick=\"location.href='./2-2-111.php'\"");
$form->addElement("button","2-2-204_button","ͽ����ɼȯ��","onClick=\"location.href='./2-2-204.php'\"");

//�ܥ��󲡲�hidden
$form->addElement("hidden", "form_hdn_submit");
$form->addElement("hidden","hdn_show_button_flg");

/****************************/
//���٥��Ƚ�̥ե饰����
/****************************/
//ɽ���ܥ��󤬲������줿��硢ɽ���ܥ��󲡲��ե饰��Ω�Ƥ�
//$show_button_flg    = ($_POST["hdn_show_button_flg"] == 't')? true : false;
$show_button_flg    = ($_POST["form_show_button"] == 'ɽ����')? true : false;
//��������ܥ��󤬲������줿��硢���ꥢ�ܥ���ե饰��Ω�Ƥ�
if($_POST["form_slipout_button"] == "������������"
    ||
   $_POST["form_preslipout_button"] == "������ȯ��"    
    ||
   $_POST["form_reslipout_button"] == "���ơ�ȯ���ԡ�"
    ){
    $slipout_button_flg = true;
}


/****************************/
//ɽ���ܥ��󲡲�
/****************************/
if($show_button_flg == true || $_POST["switch_page_flg"]== 't'){
    /****************************/
    //POST�������
    /****************************/
    $send_sday_y        = $_POST["form_round_day"]["sy"];       //�������ʳ���ǯ�� 
    $send_sday_m        = $_POST["form_round_day"]["sm"];       //�������ʳ��Ϸ��
    $send_sday_d        = $_POST["form_round_day"]["sd"];       //�������ʳ�������
    $send_eday_y        = $_POST["form_round_day"]["ey"];       //�������ʽ�λǯ�� 
    $send_eday_m        = $_POST["form_round_day"]["em"];       //�������ʽ�λ���
    $send_eday_d        = $_POST["form_round_day"]["ed"];       //�������ʽ�λ����

    $act_div            = $_POST["form_act_div"];               //��ԥե饰
    $display_num        = $_POST["form_display_num"];           //ɽ�����

    $charge_fc_cd1      = $_POST["form_charge_fc"]["cd1"];      //������FC�������ɣ�
    $charge_fc_cd2      = $_POST["form_charge_fc"]["cd2"];      //������FC�������ɣ�
    $charge_fc_name     = $_POST["form_charge_fc"]["name"];     //������FC��̾
    $charge_fc_id       = $_POST["form_charge_fc"]["select"]["1"];  //������FC��ID

    $attach_branch      = $_POST["form_attach_branch"];         //��°��ŹID
    $part_id            = $_POST["form_part"];                  //����

    $staff_cd           = $_POST["form_round_staff"]["cd"];     //���ô���ԥ�����
    $staff_id           = $_POST["form_round_staff"]["select"]; //���ô����ID

    $staff_in_cd        = $_POST["form_multi_staff"];           //���ô���ԥ�����(����޶��ڤ�)
    $staff_not_in_cd    = $_POST["form_not_multi_staff"];       //�������ô���ԥ�����(����޶��ڤ�) 

    /****************************/
    //�롼�����
    /****************************/
    //ô���ԥ����ɤ�Ⱦ�ѿ��������å�
    $form->addGroupRule('form_round_staff', array(
            'cd' => array(
                    array('ô���ԥ����� ��Ⱦ�ѿ����ΤߤǤ���', 'regex', "/^[0-9]+$/")
            ),
        )
    );

    //ô���ԥ����ɡʥ���޶��ڤ�ˤ�Ⱦ�ѿ��������å�
    Err_Chk_Delimited($form, "form_multi_staff", "���ô���ԥ�����(����޶��ڤ�) ��Ⱦ�ѿ����ȡ�,�פΤߤǤ���");

    //����ô���ԥ����ɡʥ���޶��ڤ�ˤ����ꤵ��Ƥ�����
    Err_Chk_Delimited($form, "form_not_multi_staff", "����ô���ԥ�����(����޶��ڤ�) ��Ⱦ�ѿ����ȡ�,�פΤߤǤ���");

    //ͽ������
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
                    array('ͽ��������ɬ�����ϤǤ���', 'required')
            ),      
            'em' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            ),      
            'ed' => array(
                    array('ͽ��������ɬ�����ϤǤ���','required')
            )         
    ));

    Err_Chk_Date($form, "form_round_day", "ͽ������ �����դ������ǤϤ���ޤ���");

    $set_data["hdn_show_button_flg"] = "";
    /***************************/
    //�͸���
    /***************************/
/*
    if($form->validate() || $_GET["search"] == '1'){
        //�Х�ǡ��ȥե饰
        $validate_flg = true;
    }
*/
    $form->validate();
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = true;
}else{
    $post_flg = false;
}

/***************************/
//��Ｐ����
/***************************/
//if($validate_flg === true){
if(!$err_flg && $post_flg == true){

    //���դ���
    $send_sday = str_pad($send_sday_y,4,"0",STR_PAD_LEFT)."-".str_pad($send_sday_m,2,"0",STR_PAD_LEFT)."-".str_pad($send_sday_d,2,"0",STR_PAD_LEFT);
    $send_eday = str_pad($send_eday_y,4,"0",STR_PAD_LEFT)."-".str_pad($send_eday_m,2,"0",STR_PAD_LEFT)."-".str_pad($send_eday_d,2,"0",STR_PAD_LEFT);

    //�������ʳ��ϡˤ����Ϥ��줿���
    if($send_sday != '--' && $send_sday != null){
        $where_sql  = " AND t_aorder_h.ord_time >= '$send_sday'\n";
    }

    //�������ʽ�λ�ˤ����Ϥ��줿���
    if($send_eday != '--' && $send_eday != null){
        $where_sql .= " AND t_aorder_h.ord_time <= '$send_eday'\n";
    }
    $date_sql = $where_sql;

    //���ô���ԥ����ɤ����Ϥ��줿���
    if($staff_cd != null || $staff_id != null || $staff_not_in_cd != null || $staff_in_cd != null){
        $where_sql .= " AND t_aorder_staff.staff_id IN (\n";
        $where_sql .= "         SELECT\n";
        $where_sql .= "             t_staff.staff_id\n";
        $where_sql .= "         FROM\n";
        $where_sql .= "             t_aorder_staff\n";
        $where_sql .= "                 INNER JOIN\n";
        $where_sql .= "             t_staff\n";
        $where_sql .= "             ON t_aorder_staff.staff_id = t_staff.staff_id\n";

        //���ô���ԡʥ���޶��ڤ��
        //���ô���ԥ�����
        if($staff_in_cd != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         charge_cd IN ($staff_in_cd)\n";
        }

        if($staff_cd != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         t_staff.charge_cd = $staff_cd \n";
        }

        //�������ô���ԥ����ɡʥ���޶��ڤ��
        if($staff_not_in_cd != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         charge_cd NOT IN ($staff_not_in_cd)\n";
        }

        //���ô���Ԥ����򤵤�Ƥ������
        if($staff_id != null){
            $where_sql .= "         AND\n";
            $where_sql .= "         t_staff.staff_id = $staff_id\n";
        }

        $where_sql .= ")\n";

        /*
        * ����
        * �����ա�������BɼNo.��������ô���ԡ��������ơ�
        * ��2006/11/01��02-036��������suzuki-t��  ������¦������ô���Ԥθ�����Ǥ���褦���ѹ�
        */
       if($group_kind == '2'){
            $where2_sql  .= " AND t_aorder_h.act_id IS NULL\n";
       }
    }

    //�������򤵤줿���
    if($part_id != NULL){
        $where_sql .= " AND t_aorder_staff.staff_id IN (";
        $where_sql .= "             SELECT\n";
        $where_sql .= "                 staff_id\n";
        $where_sql .= "             FROM\n";
        $where_sql .= "                 t_attach\n";
        $where_sql .= "             WHERE\n";
        $where_sql .= "                 t_attach.part_id = $part_id\n";
        $where_sql .= "             )\n";

        /*
        * ����
        * �����ա�������BɼNo.��������ô���ԡ��������ơ�
        * ��2006/11/01��02-036��������suzuki-t��  ������¦������ô���Ԥθ�����Ǥ���褦���ѹ�
        */
        if($group_kind == '2'){
            $where2_sql .= " AND t_aorder_h.act_id IS NULL\n";
        }
    }

    //�����ID
    if($charge_fc_id != null){
        $where2_sql .= " AND t_aorder_h.act_id = $charge_fc_id ";

        $where_sql  .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }

    //�����CD��
    if($charge_fc_cd1 != null){    
        $where2_sql .= " AND t_aorder_h.act_cd1 LIKE '%$charge_fc_cd1' ";

        $where_sql  .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }

    //�����CD2
    if($charge_fc_cd2 != null){
        $where2_sql .= " AND t_aorder_h.act_cd2 LIKE '%$charge_fc_cd2' ";

        $where_sql  .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }

    //�����̾
    if($charge_fc_name != null){
        $where2_sql .= " AND t_aorder_h.act_id IN (SELECT \n";
        $where2_sql .= "                             client_id \n";
        $where2_sql .= "                         FROM \n";
        $where2_sql .= "                             t_client \n";
        $where2_sql .= "                         WHERE \n";
        $where2_sql .= "                             (t_client.client_name LIKE '%$charge_fc_name%' \n";
        $where2_sql .= "                             OR t_client.client_name2 LIKE '%$charge_fc_name%' \n";
        $where2_sql .= "                             OR t_client.shop_name LIKE '%$charge_fc_name%' \n";
        $where2_sql .= "                             OR t_client.client_cname LIKE '%$charge_fc_name%')) \n";

        $where_sql .= " AND t_aorder_h.act_id IS NOT NULL\n";
    }


    //��°�ޥ���
    if($attach_branch != null){
        $where_sql .= "  AND t_aorder_staff.staff_id IN (SELECT \n";
        $where_sql .= "                                     t_attach.staff_id  \n";
        $where_sql .= "                                 FROM \n";
        $where_sql .= "                                     t_part \n";
        $where_sql .= "                                         INNER JOIN ";
        $where_sql .= "                                     t_attach \n";
        $where_sql .= "                                     ON t_part.part_id = t_attach.part_id ";
        $where_sql .= "                                 WHERE \n";
        $where_sql .= "                                     branch_id = $attach_branch \n";
        $where_sql .= "                                 ) \n";

        if($group_kind == '2'){
            $where2_sql  .= " AND t_aorder_h.act_id IS NULL\n";
        }
    }

    //��ɼ��ʬ
    if($act_div == "2"){
        $where_sql .= " AND t_aorder_h.act_id IS NULL ";
    }elseif($act_div == "3"){ 
        $where_sql .= " AND t_aorder_h.act_id IS NOT NULL ";
    }

    /*
    * ����
    * �����ա�������BɼNo.��������ô���ԡ��������ơ�
    * ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
    */
    /****************************/
    //����ؿ����
    /****************************/
    require_once(INCLUDE_DIR."function_keiyaku.inc");
    /****************************/
    //������ɽ�����ּ���
    /****************************/
    $cal_array = Cal_range($db_con,$shop_id,true);
    $end_day   = $cal_array[1];     //�оݽ�λ����

    /****************************/
    //����ɽ����SQL����
    /****************************/
    //ľ�Ĥξ��
    if($group_kind == '2'){
        //���ʬ�ʳ������򤵤줿���
        if($act_div != '3'){
            //--�����Ҥ�ͽ����ɼ
            $sql  = "(";
            $sql .= "SELECT\n";
            $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)";
            $sql .= "    ||";
            $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          //--����No.
            $sql .= "   t_aorder_h.ord_time,\n";                                            //--������
            $sql .= "   LPAD( CAST(t_staff.charge_cd AS text), 4, '0') AS charge_cd,\n";    //--�����åե����ɡ�0����
            $sql .= "   t_staff.staff_name,\n";                                             //--���ô����
            $sql .= "   COUNT(t_aorder_h.ord_time), \n";                                    //--�����
            $sql .= "   t_staff.staff_id,\n";                                               //--�����å�ID
            $sql .= "   CAST('' AS text) AS daikou_flg,\n";                                 //--��Ԥ�̵ͭ
            $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";                 //��������ȯ����
            $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
            $sql .= "   daily_slip_id \n";
            $sql .= "FROM\n";
            $sql .= "   t_aorder_h\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
            $sql .= "   AND t_aorder_staff.staff_div = 0\n";                               //--�ᥤ��ô����
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_client\n";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id\n";

            // ��2006/11/01��02-018��������suzuki-t��  �ٻ��桦�����������ɽ��
            //$sql .= "   AND t_client.state = '1'\n";

            $sql .= "       INNER JOIN\n";
            $sql .= "   t_staff\n";
            $sql .= "   ON t_staff.staff_id = t_aorder_staff.staff_id\n";
            $sql .= "WHERE \n";
            $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().")\n";                         //--������ɼ(ľ�Ĥ�ID�����ƻ��ꤷ�Ʋ�����)
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.act_id IS NULL\n";
            $sql .= "   AND\n";
//          $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�
            $sql .= "   t_aorder_h.del_flg = false \n";

            // ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            $sql .=     $where_sql;
            $sql .= "GROUP BY\n";
            $sql .= "   t_aorder_h.daily_slip_id, \n";
            $sql .= "   t_aorder_h.ord_time,\n";
            $sql .= "   t_staff.staff_id,\n";
            $sql .= "   t_staff.charge_cd,\n";
            $sql .= "   t_staff.staff_name \n";
            $sql .= "ORDER BY\n";
            $sql .= "   t_staff.charge_cd, \n";
            $sql .= "   t_aorder_h.ord_time\n";
            $sql .= ")\n";
        }

        //����ʤ������򤵤줿���
        if($act_div == '1'){
            $sql .= "UNION\n";
        }

        //���ҽ��ʳ������򤵤줿���
        if($act_div != '2'){
            //--����������ͽ����ɼ
            $sql .= "(\n";
            $sql .= "SELECT \n";
            $sql .= "   CAST('' AS text) AS No,\n";                                         //--����No.����Ԥ�̵����
            $sql .= "   t_aorder_h.ord_time,\n";                                            //--������
            $sql .= "   CAST(t_client.client_cd1 AS text)\n";
            $sql .= "    || '-' ||\n";
            $sql .= "   CAST(t_client.client_cd2 AS text),\n";                              //--�����襳����
            $sql .= "   t_client.shop_name,\n";                                             //--���ô����
            $sql .= "   COUNT(t_aorder_h.ord_time), \n";                                    //--�����
            $sql .= "   t_client.client_id,\n";                                             //--������
            $sql .= "   CAST('��' AS text) AS daikou_flg,\n";                                //--��Ԥ�̵ͭ 
            $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";
            $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
            $sql .= "   daily_slip_id \n";
            $sql .= "FROM \n";
            $sql .= "   t_aorder_h \n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_client \n";
            $sql .= "   ON t_aorder_h.act_id = t_client.client_id \n";
            $sql .= "   AND (t_aorder_h.contract_div=2 OR t_aorder_h.contract_div=3)\n";
            $sql .= " WHERE\n";
            $sql .= "   t_aorder_h.shop_id IN (".Rank_Sql().") \n";
            $sql .= "   AND\n";
//          $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�
            $sql .= "   t_aorder_h.del_flg = false\n";

            // ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            $sql .= "   $date_sql ";
            $sql .=     $where2_sql ;
            $sql .= " GROUP BY\n";
            $sql .= "   t_aorder_h.daily_slip_id, \n";
            $sql .= "   t_aorder_h.ord_time,\n";
            $sql .= "   t_client.client_id,\n";
            $sql .= "   t_client.client_cd1,\n";
            $sql .= "   t_client.client_cd2,\n";
            $sql .= "   t_client.shop_name\n";
            $sql .= " ORDER BY\n";
            $sql .= "   t_client.client_cd1,\n";
            $sql .= "   t_client.client_cd2,\n";
            $sql .= "   t_aorder_h.ord_time \n";
            $sql .= ") ";
        }

        //����ʤ������򤵤줿���
        if($act_div == '1'){
            $sql .= " ORDER by 7,3 ";
        }

    //ľ�İʳ��ξ��
    }else{
        $sql  = "(\n";
        $sql .= "SELECT\n";
        $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)\n";
        $sql .= "    ||\n";
        $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          //����No.
        $sql .= "   t_aorder_h.ord_time,\n";                                            //������
        $sql .= "   lpad(t_staff.charge_cd, 4, '0') AS charge_cd,\n";                   //ô���ԥ�����
        $sql .= "   t_staff.staff_name,\n";                                             //���ô����
//        $sql .= "   count(t_aorder_h.ord_time), \n";                                    //�����
        $sql .= "   NULL, \n";
        $sql .= "   t_staff.staff_id, \n";
        $sql .= "   CAST('' AS text) AS daikou_flg,\n";                                  //--��Ԥ�̵ͭ
//        $sql .= "   NULL, \n";
        $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";
        $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
        $sql .= "   daily_slip_id, \n";
        $sql .= "   t_aorder_h.shop_id ";
        $sql .= "FROM\n";
        $sql .= "   t_aorder_h\n";
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_aorder_staff\n";
        $sql .= "   ON t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_div = 0 \n";                                   //�ᥤ��ô����
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_staff\n";
        $sql .= "   ON  t_staff.staff_id = t_aorder_staff.staff_id \n";
        $sql .= "WHERE\n";
        $sql .= "   t_aorder_h.shop_id=$shop_id\n"; // ����å�
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.contract_div = '1'";
        $sql .= "   AND\n";
//      $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�
        $sql .= "   t_aorder_h.del_flg = false\n";

        // ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

        $sql .=     $where_sql;
        $sql .= "GROUP BY t_aorder_h.shop_id,t_aorder_h.daily_slip_id, t_aorder_h.ord_time,t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name \n";
        $sql .= "ORDER BY t_staff.charge_cd,t_aorder_h.ord_time \n";
        $sql .= ")\n";

        //  ��2006/11/01��02-005��������suzuki-t��  �����ֹ椬�դ�줿�����ɼ��ɽ��
//      $sql .= ";\n";
        //--����������ͽ����ɼ
        $sql .= "UNION \n";

        $sql .= "(\n";
        $sql .= "SELECT \n";
        $sql .= "   (substr( replace( t_aorder_h.ord_time, '-','') ,3)\n";
        $sql .= "    ||\n";
        $sql .= "   lpad(t_staff.charge_cd, 4, '0'))AS No,\n";                          //����No.
        $sql .= "   t_aorder_h.ord_time,\n";                                            //������
        $sql .= "   lpad(t_staff.charge_cd, 4, '0') AS charge_cd,\n";                   //ô���ԥ�����
        $sql .= "   t_staff.staff_name,\n";                                             //���ô����
        $sql .= "   NULL, \n";
//        $sql .= "   count(t_aorder_h.ord_time), \n";                                    //�����
//      $sql .= "   $shop_id,\n";                                                       //--������
        $sql .= "   t_staff.staff_id, \n";                                               //--�����å�ID

        $sql .= "   CAST('��' AS text) AS daikou_flg,\n";                                //--��Ԥ�̵ͭ 
//        $sql .= "   NULL, \n";
        $sql .= "   MAX(daily_slip_out_day) AS daily_slip_out_day, \n";
        $sql .= "   MAX(slip_out_day) AS slip_out_day, \n";
        $sql .= "   daily_slip_id, \n";
        $sql .= "   t_aorder_h.shop_id ";
        $sql .= "FROM \n";
        $sql .= "   t_aorder_h\n";
        $sql .= "   INNER JOIN t_aorder_staff ON t_aorder_h.aord_id = t_aorder_staff.aord_id \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_staff.staff_div = 0 \n";                                   //�ᥤ��ô����
        $sql .= "       INNER JOIN\n";
        $sql .= "   t_staff\n";
        $sql .= "   ON  t_staff.staff_id = t_aorder_staff.staff_id \n";
        $sql .= " WHERE\n";
        $sql .= "   t_aorder_h.act_id = $shop_id \n";
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.contract_div = '2' ";
        $sql .= "   AND\n";
//        $sql .= "   t_aorder_h.ord_no IS NOT NULL \n";
//        $sql .= "   AND\n";
//      $sql .= "   t_aorder_h.reserve_del_flg = false\n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�
        $sql .= "   t_aorder_h.del_flg = false\n";

        // ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
        $sql .= "   AND\n";
        $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

        $sql .=     $where_sql;
        $sql .= "GROUP BY t_aorder_h.shop_id, t_aorder_h.daily_slip_id, t_aorder_h.ord_time,t_staff.staff_id,t_staff.charge_cd,t_staff.staff_name \n";
        $sql .= "ORDER BY t_staff.charge_cd,t_aorder_h.ord_time \n";
        $sql .= ") \n";
        $sql .= " ORDER by 3,2 ";
    }


    $result = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($result);

    //ɽ�����
    if($display_num != null){
        // ɽ�����
        switch ($display_num){
            case "1":
                $limit = $total_count;
                break;
            case "2":
                $limit = "100";
                break;
        }

        // �������ϰ���
        $offset = ($page_count != null) ? ($page_count - 1) * $limit : "0";

        // �Ժ���ǥڡ�����ɽ������쥳���ɤ�̵���ʤ�����н�
        if($page_count != null){
            // �Ժ����match_count��offset�δط������줿���
            if ($total_count <= $offset){
                // ���ե��åȤ����������
                $offset     = $offset - $limit;
                // ɽ������ڡ�����1�ڡ������ˡʰ쵤��2�ڡ���ʬ�������Ƥ������ʤɤˤ��б����Ƥʤ��Ǥ���
                $page_count = $page_count - 1;
                // �������ʲ����ϥڡ������ܤ���Ϥ����ʤ�(null�ˤ���)
                $page_count = ($total_count <= $display_num) ? null : $page_count;
            }
        }else{
            $offset = 0;
        }
        $limit_offset   = ($limit != null) ? " LIMIT $limit OFFSET $offset \n" : null;
        $result         = Db_Query($db_con, $sql.$limit_offset);
        $match_count    = pg_num_rows($result);
        $page_data      = Get_Data($result);
    }

}else{
    $match_count = 0;
}

/***************************/
//ͽ��ǡ������٤��������ID�����
/***************************/
for($i = 0, $key=1; $i < $match_count; $i++,$key++){
    
    $page_data[$i]["key"] = $limit*($page_count-1) +$key;

    //ľ�Ĥ�Ƚ��
    if($group_kind == '2'){
        //ľ��

        //��Ԥξ��
        if($page_data[$i][6] == '��'){
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id, \n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n";
            $sql .= "FROM\n";
            $sql .= "   t_aorder_h \n";
            $sql .= "       INNER JOIN \n";
            $sql .= "   t_client \n";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
            $sql .= "WHERE\n";
            $sql .= "   t_aorder_h.act_id = ".$page_data[$i][5]."\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.del_flg = false \n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            // ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            $sql .= "ORDER BY t_aorder_h.route\n";
            $sql .= ";";
        //��԰ʳ�
        }else{
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n";
            $sql .= " FROM\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   t_aorder_h\n";
            $sql .= "   ON\n";
            $sql .= ($group_kind == 2)? "  t_aorder_h.shop_id IN (".Rank_Sql().")\n" : "  t_aorder_h.shop_id = $shop_id";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_staff.staff_div = '0'\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_staff.staff_id = ".$page_data[$i][5]."\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
        
            // ��2006/11/01��02-018��������suzuki-t��  �ٻ��桦�����������ɽ��
            //$sql .= "   AND t_client.state = '1'\n";
            
            $sql .= "       INNER JOIN ";
            $sql .= "   t_client ";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";

            $sql .= "WHERE\n";
//            $sql .= "   t_aorder_h.reserve_del_flg = false \n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�
            $sql .= "   t_aorder_h.del_flg = false \n";  //(2006/09/06) (kaji) �����ɼ�ϰ�����ɽ�����ʤ�

            // ��2006/11/02��02-037��������suzuki-t������������ɽ�����ֻ���  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            $sql .= "ORDER BY t_aorder_h.route\n";
            $sql .= ";";
        }
    }else{
        //�ƣ�
        if($page_data[$i][6] == ''){
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n";
            $sql .= " FROM\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "   INNER JOIN t_aorder_h ON t_aorder_h.shop_id = $shop_id ";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_div = '0'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_id = ".$page_data[$i][5]."\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.aord_id = t_aorder_staff.aord_id\n";
       
            $sql .= "   INNER JOIN ";
            $sql .= "   t_client ";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";


            $sql .= "WHERE\n";
            $sql .= "   t_aorder_h.del_flg = false \n";  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";
            $sql .= "   AND \n";
            $sql .= "   t_aorder_h.contract_div = '1' \n";

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            $sql .= ";";
//        $sql .= "UNION\n";

        }elseif($page_data[$i][6] == '��'){
            $sql  = "SELECT\n";
            $sql .= "   t_aorder_h.aord_id,\n";
            $sql .= "   t_aorder_h.ord_no, \n";
            $sql .= "   t_client.slip_out \n" ;
            $sql .= " FROM\n";
            $sql .= "   t_aorder_staff\n";
            $sql .= "   INNER JOIN t_aorder_h ON t_aorder_h.act_id = $shop_id ";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_div = '0'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_staff.staff_id = ".$page_data[$i][5]."\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.ord_time = '".$page_data[$i][1]."'\n";
            $sql .= "       AND\n";
            $sql .= "           t_aorder_h.aord_id = t_aorder_staff.aord_id\n";

            $sql .= "   INNER JOIN ";
            $sql .= "   t_client ";
            $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";

            $sql .= "WHERE\n";
            $sql .= "   t_aorder_h.del_flg = false \n";  
            $sql .= "   AND\n";
            $sql .= "   t_aorder_h.ord_time <= '$end_day' \n";
            $sql .= "   AND \n";
            $sql .= "   t_aorder_h.contract_div IN ('3', '2') \n";

            if($page_data[$i][9] != null){
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id = ".$page_data[$i][9]." \n";
            }else{
                $sql .= "   AND \n";
                $sql .= "   t_aorder_h.daily_slip_id IS NULL \n";
            } 

            $sql .= ";";

            //PDF¦����ԤȤ��ư����ʤ��褦�ˡ�null�򥻥å�
            $page_data[$i][6] = null;
        }
    }

    $result = Db_Query($db_con, $sql);
    $num = pg_num_rows($result);

    $page_data[$i][4] = $num;   //�����

    //��������ȯ�ԺѤߥե饰������
    unset($slip_out_flg);

    for($j = 0; $j < $num; $j++){
        $get_ary[$i][$j] = pg_fetch_result($result,$j,0);

        //��ɼȯ���о�(�̾�ξ��)
        if(pg_fetch_result($result,$j,2) == '1'){
            $slip_ary[$i][] = pg_fetch_result($result,$j,0);
        }

        //��������ȯ�ԺѤߥ����å�
        $slip_out_chk = pg_fetch_result($result,$j,1);
        if($slip_out_chk != null){
            $slip_out_flg[] = 't';
        }else{
            $slip_out_flg[] = 'f';
        }
    }

    //���٤�����ID
    $page_data[$i]["ary_id"] = urlencode(serialize($get_ary[$i]));

    //��ɼȯ�Ԥ�����ID
    if(count($slip_ary[$i]) > 0){
        $page_data[$i]["slip_out_id"]     = implode(',', $slip_ary[$i]);
    }

    //����Ѥ�ID
    $page_data[$i]["slip_ary_id"]     = implode(',',$get_ary[$i]);
    $page_data[$i]["slip_all_count"]  = count($get_ary[$i]);    //��ɼ�����

    //��ɼȯ�Ԥ��Ƥ������ɽ��
    $sql  = "SELECT";
    $sql .= "   COUNT(aord_id) AS slip_out_count ";
    $sql .= "FROM ";
    $sql .= "   t_aorder_h ";
    $sql .= "       INNER JOIN ";
    $sql .="    t_client ";
    $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= "   aord_id IN (".$page_data[$i]["slip_ary_id"].")";
    $sql .= "   AND ";
    $sql .= "   slip_out_day IS NOT NULL ";
    $sql .= "   AND ";
    $sql .= "   t_client.slip_out NOT IN ('2', '3') ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $page_data[$i]["slip_out_count"] = pg_fetch_result($result, 0,0);

    //��ɼȯ�Է���������ο�
    $sql  = "SELECT";
    $sql .= "   COUNT(aord_id) AS slip_format_count ";
    $sql .= "FROM ";
    $sql .= "   t_aorder_h ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_client ";
    $sql .= "   ON t_aorder_h.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= "   aord_id IN (".$page_data[$i]["slip_ary_id"].")";
    $sql .= "   AND ";
    $sql .= "   t_client.slip_out IN ('2', '3') ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $page_data[$i]["slip_format_count"] = pg_fetch_result($result, 0,0);

    //��ɼ��ȯ�ԺѤߤ�̤ȯ�Ԥο��������
    $slip_state_count = array_count_values($slip_out_flg);
    $page_data[$i]["slip_count"]   = $slip_state_count['t'];    //���ֺ�
    $page_data[$i]["unslip_count"] = $slip_state_count['f'];    //������

    //��ɼȯ�Ԥ��Ƥ��ʤ���ɼ��¸�ߤ������
    if(in_array('f', $slip_out_flg)){
        $page_data[$i]["slip_flg"] = false;

        //��������̤ȯ�Ԥ����ꤵ��Ƥ������
        if($slip_state == '2'){
            unset($page_data[$i]);
        }
    }else{
        $page_data[$i]["slip_flg"] = true;

        //��������ȯ�ԺѤߤ����ꤵ��Ƥ������
        if($slip_state == '3'){
            unset($page_data[$i]);
        }
    }
}

//ɽ���ǡ�������Υ����򿶤�ʤ���
if(is_array($page_data)){
    $page_data = array_values($page_data);
}

/***************************/
//ưŪ�ե��������
/***************************/
$form->addElement("checkbox", "aord_prefix_all", "", "����������(0)", 
                    "onClick=\"javascript:All_Check_Aord_Prefix('aord_prefix_all')\"
                ");
$form->addElement("checkbox", "aord_unfix_all", "", "���ֽ�������(1)", 
                    "onClick=\"javascript:All_Check_Aord_Unfix('aord_unfix_all')\"
                ");
$form->addElement("checkbox", "aord_fix_all", "", "(1)��ȯ��", 
                    "onClick=\"javascript:All_Check_Aord_Fix('aord_fix_all')\"
                ");

//��ɼȯ��
// �������å��ѥ����å��ܥå���
$form->addElement("checkbox", "slip_out_all", "�����ɼȯ��", "�����ɼȯ��",
    "onClick=\"javascript:All_Check_Slip('slip_out_all');\""
);
$form->addElement("checkbox", "reslip_out_all", "��ȯ��", "��ȯ��",
    "onClick=\"javascript:All_Check_Reslip('reslip_out_all');\""
);

$form->addElement("hidden","hdn_button");
$form->addElement("hidden","src_module","��������");                 //�����ɼ��PDF�ˤ����ܸ����Τ뤿������
//ɽ���ǡ������
$match_count = count($page_data);

$form->addElement("button", "slip_out_button", "�����ɼȯ��",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '�����ɼȯ��');\""
);

$form->addElement("button", "reslip_out_button", "���ơ�ȯ���ԡ�",
    "onClick=\"javascript:Post_Next_Page('".FC_DIR."sale/2-2-205.php','form_hdn_submit', '��ȯ��');\""
);

//�������˳�������ǡ���ʬ�롼��
$k = 0;
for($i = 0; $i < $match_count; $i++){


    //ȯ�ԺѤξ��
    if($page_data[$i]["slip_flg"] == true){
        $slipout_chk_data[] = $i;

        $form->addElement(
            "checkbox", "form_reslipout_check[$i]", "", "");
        $set_data["form_reslipout_check"][$i] = "";
    //̤ȯ�Ԥξ��
    }else{
        $unslipout_chk_data[] = $i;

        $form->addElement(
            "checkbox", "form_preslipout_check[$i]", "", ""
        );
        $set_data["form_preslipout_check"][$i] = "";

        $form->addElement(
            "checkbox", "form_slipout_check[$i]", "", "");
        $set_data["form_slipout_check"][$i] = "";
    }

    // ������
    $form->addElement(
        "hidden", "hdn_send_day[$i]"
    );
    $set_data["hdn_send_day"][$i] = $page_data[$i][1];

    // �����å�ID
    $form->addElement(
        "hidden", "hdn_staff_id[$i]"
    );
    $set_data["hdn_staff_id"][$i] = $page_data[$i][5];

    // ��Զ�ʬ
    $form->addElement(
        "hidden", "hdn_act_flg[$i]"
    );
    $set_data["hdn_act_flg"][$i] = $page_data[$i][6];
    //��������ID
    $form->addElement(
        "hidden", "hdn_daily_slip_id[$i]"
    );
    $set_data["hdn_daily_slip_id"][$i] = $page_data[$i][9];

    //��ɼID
    $form->addElement(
        "hidden", "hdn_imp_slip_id[$i]"
    );
    $set_data["hdn_imp_slip_id"][$i] = implode(',', $get_ary[$i]);


    //��ɼȯ��
    //��ɼ������Ȼ�����ɼ����ꤷ�Ƥ���������ο���Ʊ�����
    //����ɽ�����ʤ�
    if($page_data[$i]["slip_all_count"] == $page_data[$i]["slip_format_count"]){
    //��ɼ��������������ɼ����ꤷ�Ƥ���������ο����������Τȡ�ȯ�ԺѤߤ���ɼ�ο���Ʊ�����
    //��ȯ��
    }elseif(($page_data[$i]["slip_all_count"] - $page_data[$i]["slip_format_count"]) == $page_data[$i]["slip_out_count"]){
        $form->addElement("advcheckbox", "form_reslip_check[$i]", NULL, NULL, NULL, array("f", $page_data[$i]["slip_out_id"]));
        $reslip_out_id[$k] = $page_data[$i]["slip_out_id"];
        $set_data["form_reslip_check"][$i] = "f";
    //ȯ��
    }elseif($page_data[$i]["slip_flg"] == true){
        $form->addElement("advcheckbox", "form_slip_check[$i]", NULL, NULL, NULL, array("f", $page_data[$i]["slip_out_id"]));
        $slip_out_id[$k] = $page_data[$i]["slip_out_id"];
        $set_data["form_slip_check"][$i] = "f";
    }
    $k++;
}

//�ͤ򥻥å�
$form->setConstants($set_data);

/****************************/
//js
/****************************/
// ��������(ALL�����å�JS�����)
$javascript   = Create_Allcheck_Js ("All_Check_Aord_Prefix","form_preslipout_check",$unslipout_chk_data,1);
$javascript  .= Create_Allcheck_Js ("All_Check_Aord_Unfix" ,"form_slipout_check"   ,$unslipout_chk_data,1);
$javascript  .= Create_Allcheck_Js ("All_Check_Aord_Fix"   ,"form_reslipout_check"   ,$slipout_chk_data,1);
// ��ɼȯ��(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js  ("All_Check_Slip",  "form_slip_check",  $slip_out_id);
// ��ȯ��(ALL�����å�JS�����)
$javascript .= Create_Allcheck_Js  ("All_Check_Reslip", "form_reslip_check",    $reslip_out_id);



//�ܥ����POST���Ϥ�
$javascript  .= "function Post_Next_Page(page,hidden_form, mesg){\n";
$javascript  .= "   var hdn = hidden_form;\n";
$javascript  .= "   document.dateForm.elements[hdn].value = mesg;\n";
$javascript  .= "   //�̲��̤ǥ�����ɥ��򳫤�\n";
$javascript  .= "   document.dateForm.target=\"_blank\";\n";
$javascript  .= "   document.dateForm.action=page;\n";
$javascript  .= "   //POST�������������\n";
$javascript  .= "   document.dateForm.submit();\n";
$javascript  .= "   document.dateForm.target=\"_self\";\n";
$javascript  .= "   document.dateForm.action='./2-2-113.php';\n";
$javascript  .= "}\n";

/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼����
/****************************/
$page_menu = Create_Menu_f('sale','1');

/****************************/
//���̥إå�������
/****************************/

$page_title .= "��".$form->_elements[$form->_elementIndex[slip_button]]->toHtml();
if($group_kind == '2'){
    $page_title .= "��".$form->_elements[$form->_elementIndex[act_button]]->toHtml();
}
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-204_button"]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex["2-2-111_button"]]->toHtml();

$page_header = Create_Header($page_title);

$html_page  = Html_Page2($total_count,$page_count,1,$limit,950);
$html_page2 = Html_Page2($total_count,$page_count,2,$limit,950);

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
    'charges_msg'   => "$charges_msg",
    'chargee_msg'   => "$chargee_msg",
    'decimal_msg'   => "$decimal_msg",
    'nodecimal_msg' => "$nodecimal_msg",
    'match_count'   => "$match_count",
    'javascript'    => "$javascript",
    'search_html'   => "$search_html"
));
$smarty->assign('page_data',$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
