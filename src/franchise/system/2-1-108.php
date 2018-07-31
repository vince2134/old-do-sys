<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/16) ��°�ޥ������ɲá������������ɲ�(suzuki-t)
 *       (2006/05/26) �ѹ��Ǥ��ʤ����ܤ��ѹ�
 *       (2006/08/09) �����ѹ��Ǥ��ʤ��Х�����
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.0.0 (2006/03/16)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/25      21-040      ��          �����å�̾�˥��ڡ����Τߤ���Ͽ����ǽ�ʥХ�����
 *  2006-12-08      ban_0092    suzuki      ������˥��˻Ĥ��褦�˽���
 *  2007-02-09                  watanabe-k��ô���Ҹˤ���Ͽ�������ɲ�
 *  2007/03/30      B0702-018   kajioka-h   group_kind��Ƚ�꼰����=�פˤʤäƤ����Τ��==�פ˽���
 *  2007/06/25                  fukuda      ô���ԥ����ɤ�ʸ��������Ϥ���ȥ����å������Υ����ꥨ�顼��ȯ�������Զ��ν���
 *  2007/09/03      0709��礻3 kajioka-h   �����åպ������DB�λ������������顼��Фʤ��褦�˴ؿ���Ȥ�ʤ��褦�ѹ�
 *
 */


/****************************/
// �ڡ�����������
/****************************/
$page_title = "�����åեޥ���";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
// �����ѥ�᡼������
/****************************/
// �����å�ID��GET��
if ($_GET["staff_id"] != null){
    $staff_id = $_GET["staff_id"];
}else
// �����å�ID��POST��
if ($_POST["form_staff_id"] != null){
    $staff_id = $_POST["form_staff_id"];
}

// SESSION
$client_id      = $_SESSION["client_id"];           // ����å�ID
$ss_staff_id    = $_SESSION["staff_id"];            // �����å�ID�ʼ�ʬ��
$rank_cd        = $_SESSION["rank_cd"];             //�ܵҶ�ʬCD
$group_kind     = $_SESSION["group_kind"];          //���롼�׼���

/* GET�����ͤ������������å� */
if ($staff_id != null){
    if ($staff_id != null && !ereg("^[0-9]+$", $staff_id)){
        header("Location: ../top.php");
        exit;   
    }
    $sql  = "SELECT ";
    $sql .= "   staff_id ";
    $sql .= "FROM ";
    $sql .= "   t_attach ";
    $sql .= "WHERE ";
    $sql .= "   staff_id = $staff_id ";
    $sql .= "AND ";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $client_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    if (pg_num_rows($res) == 0){
        header("Location: ../top.php");
        exit;   
    }
}else{
    ($_SESSION["group_kind"] == "2") ? header("Location: 2-1-107.php") : null;
}


/****************************/
// ��������
/****************************/
// ����/�ѹ�������̻�
if ($_POST == null){
    $_SESSION["108_permit"]         = null; 
    $_SESSION["108_permit_delete"]  = null; 
    $_SESSION["108_permit_accept"]  = null; 
}


// ������Ͽ��
if ($_POST == null){

    $ary_mod_data = Permit_Item();

    // FCʬ���¥����å��ܥå�����SESSION�����
    $ary_f_mod_data = $ary_mod_data[1];
    // ��˥塼��
    $ary_f[0] = count($ary_f_mod_data);
    for ($i = 0; $i < $ary_f[0]; $i++){
        // �ƥ�˥塼��Υ��֥�˥塼��
        $ary_f[1][$i] = count($ary_f_mod_data[$i][1]);
        for ($j = 0; $j < $ary_f[1][$i]; $j++){
            // �ƥ��֥�˥塼��Υ����å��ܥå�����
            $ary_f[2][$i][$j] = count($ary_f_mod_data[$i][1][$j][1]);
        }       
    }
    $ary_opt  = array("r", "w", "n");
    for ($i=0; $i<=$ary_f[0]; $i++){
        for ($j=0; $j<=$ary_f[1][$i-1]; $j++){
            for ($k=0; $k<=$ary_f[2][$i-1][$j-1]; $k++){
                for ($l=0; $l<count($ary_opt); $l++){
                    $_SESSION["108_permit"]["f"][$i][$j][$k][$ary_opt[$l]] = "";
                }       
            }       
        }       
    }

    // �������ǧ���¥����å��ܥå�����SESSION����
    $_SESSION["108_permit_delete"] = "";
    $_SESSION["108_permit_accept"] = "";

}

// ������Ͽ�������¥ڡ���������ܥ��󤬲�������Ƥ�������ܥ��󤬲�������Ƥ��ʤ����
if ($_POST["set_permit_flg"] != null && $_POST["permit_rtn_flg"] != "true"){

    // POST���줿���¾����SESSION�˥��å�
    foreach ($_SESSION["108_permit"] as $key_a => $value_a){
        foreach ($value_a as $key_b => $value_b){
            foreach ($value_b as $key_c => $value_c){
                foreach ($value_c as $key_d => $value_d){
                    foreach ($value_d as $key_e => $value_e){
                        $_SESSION["108_permit"][$key_a][$key_b][$key_c][$key_d][$key_e] =
                        ($_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] != null) ?
                        $_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] : "";
                    }
                }
            }
        }
    }
    $_SESSION["108_permit_delete"]  = ($_POST["permit_delete"] != null) ? $_POST["permit_delete"] : "";
    $_SESSION["108_permit_accept"]  = ($_POST["permit_accept"] != null) ? $_POST["permit_accept"] : "";

}

// ������Ͽ�������¥ڡ��������ܥ��󤬲������줿���
if ($_POST["permit_rtn_flg"] == "true"){

    // SESSION�˥��åȤ��Ƥ��븢�¾����POST�˥��å�
    $_POST["permit"]        = $set_permit["permit"]         = $_SESSION["108_permit"];
    $_POST["permit_delete"] = $set_permit["permit_delete"]  = $_SESSION["108_permit_delete"];
    $_POST["permit_accept"] = $set_permit["permit_accept"]  = $_SESSION["108_permit_accept"];
    $form->setConstants($set_permit);

    // ���¥ڡ��������ܥ���ե饰�򥯥ꥢ
    $clear["permit_rtn_flg"] = "";
    $form->setConstants($clear);

}


/****************************/
// �������
/****************************/
/* ���������ΰ�����å����� */
// �����å��ѹ���
if ($staff_id != null){
    // ������ޥ����ơ��֥����Ͽ�����뤫��ǧ
    $sql  = "SELECT * FROM t_login WHERE staff_id = $staff_id ;";
    $res  = Db_Query($db_con, $sql);
    // ��������󿷵���Ͽ��/����������ѹ���
    $login_info_type = (pg_num_rows($res) == 0) ? "��Ͽ" : "�ѹ�";
    $password_msg    = (pg_num_rows($res) == 0) ? null : "�ѹ����ʤ�����̤����";
// �����åտ�����Ͽ��
}else{
    $login_info_type = "��Ͽ";
}
$login_info_msg = $login_info_type."���� �����򤷤���硢�ʲ��ι��ܤ�ɬ�����Ϥˤʤ�ޤ�";

/* ���������å����� */
// �����å��ѹ���
if ($staff_id != null){
    // ���¥ޥ����ơ��֥����Ͽ�����뤫��ǧ
    $sql  = "SELECT COUNT(staff_id) FROM t_permit WHERE staff_id = $staff_id ;";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_fetch_result($res, 0, 0);
    // ������Ͽ����Ƥ���
    if ($num > 0){
        $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "�ѹ��������Ǥ��ޤ���" : "�����";
    // ���٤���Ͽ�������Ȥ��ʤ�
    }else{
        $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "���ꤵ��ޤ���" : null;
    }
// �����åտ�����Ͽ��
}else{
    $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "���ꤵ��ޤ���" : null;
}
$cons_data["permit_set_msg"] = "$permit_set_msg";
$form->setConstants($cons_data);


/****************************/
// �ե�����ǥե����������
/****************************/
// ��Ͽ���ѹ�Ƚ��
if ($staff_id != null || $_POST["form_staff_id"] != null){

    // ���������åեǡ�������
    $sql  = "SELECT ";
    $sql .= "    t_staff.staff_cd1, ";                      // �ͥåȥ����ID��
    $sql .= "    t_staff.staff_cd2, ";                      // �ͥåȥ����ID��
    $sql .= "    t_staff.charge_cd,";                       // ô���ԥ�����
    $sql .= "    t_staff.staff_name, ";                     // �����å�̾
    $sql .= "    t_staff.staff_read, ";                     // �����å�̾(�եꥬ��)
    $sql .= "    t_staff.staff_ascii, ";                    // �����å�̾(���޻�)
    $sql .= "    t_staff.sex, ";                            // ����
    $sql .= "    t_staff.birth_day, ";                      // ��ǯ����
    $sql .= "    t_staff.state, ";                          // �߿�����
    $sql .= "    t_staff.join_day, ";                       // ����ǯ����
    $sql .= "    t_staff.retire_day, ";                     // �࿦��
    $sql .= "    t_staff.employ_type , ";                   // ���ѷ���
    $sql .= "    t_staff.position, ";                       // ��
    $sql .= "    t_staff.job_type, ";                       // ����
    $sql .= "    t_staff.study, ";                          // ��������
    $sql .= "    t_staff.toilet_license, ";                 // �ȥ�����ǻλ��
    $sql .= "    t_staff.license, ";                        // �������
    $sql .= "    t_staff.note, ";                           // ����
    $sql .= "    t_staff.photo,";                           // �̿��ʥե�����̾��
    $sql .= "    t_staff.change_flg, ";                     // �ѹ��Բ�ǽ�ե饰
    $sql .= "    t_login.login_id, ";                       // ������ID
    $sql .= "    t_staff.round_staff_flg, ";
    $sql .= "    t_staff.h_change_flg ";
    $sql .= "FROM ";
    $sql .= "    t_staff ";
    $sql .= "        LEFT  JOIN t_login  ON t_staff.staff_id = t_login.staff_id ";
    $sql .= "        INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
    $sql .= "WHERE ";
    $sql .= "    t_staff.staff_id = $staff_id ";
    $sql .= "AND ";
    //ľ��Ƚ��
    if($_SESSION[group_kind] == '2'){
        //ľ��
        $sql .= "    t_attach.shop_id IN(".Rank_Sql().")";
    }else{ 
        //�ƣ�
        $sql .= "    t_attach.shop_id = $client_id ";
    }
    $sql .= ";";
    $res = Db_Query($db_con, $sql);

    // GET�ǡ���Ƚ��������Ǥ����TOP�����ܡ�
    Get_Id_Check($res);
    $data_list = pg_fetch_array($res, 0);

    $change_flg                                          =    $data_list["change_flg"];

    // �ե�������ͤ�����
    // �ͥåȥ����ID��̵��������ɽ��
    if ($data_list["staff_cd1"] == null && $data_list["staff_cd2"] == null){
        $staff_code_flg                                  =    't';
    }else{
        $def_fdata["form_staff_cd"]["cd1"]               =    $data_list["staff_cd1"];
        $def_fdata["form_staff_cd"]["cd2"]               =    $data_list["staff_cd2"]; 
    }

    // ô���ԥ����ɤˣ�������
    $data_list["charge_cd"] = str_pad($data_list["charge_cd"], 4, 0, STR_POS_LEFT);
    $def_fdata["form_charge_cd"]                         =    $data_list["charge_cd"];
    $def_fdata["h_charge_cd"]                            =    $data_list["charge_cd"];
    $def_fdata["form_staff_name"]                        =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_name"]) : $data_list["staff_name"];
    $def_fdata["h_staff_name"]                           =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_name"]) : $data_list["staff_name"];
    $def_fdata["form_staff_read"]                        =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_read"]) : $data_list["staff_read"];
    $def_fdata["form_staff_ascii"]                       =    ($change_flg == "t") ? htmlspecialchars($data_list["staff_ascii"]) : $data_list["staff_ascii"];
    
    // �ѹ��Բ�ǽȽ��
    if ($change_flg == "t"){
        $def_fdata["form_sex"]                           =    ($data_list["sex"] == "1") ? "��" : "��";
    }else{
        $def_fdata["form_sex"]                           =    $data_list["sex"];
    }

    // ��ǯ������̵��������ɽ��
    if ($data_list["birth_day"] == null){
        $birth_day_flg                                   =    "t";
    }else{
        $def_fdata["form_birth_day"]["y"]                =    substr($data_list["birth_day"], 0, 4);
        $def_fdata["form_birth_day"]["m"]                =    substr($data_list["birth_day"], 5, 2);
        $def_fdata["form_birth_day"]["d"]                =    substr($data_list["birth_day"], 8, 2);
    }

    $def_fdata["form_state"]                             =    $data_list["state"];
    // ����ǯ������̵��������ɽ��
    if ($data_list["join_day"] == null){
        $join_day_flg                                    =    "t";
    }else{
        $def_fdata["form_join_day"]["y"]                 =    substr($data_list["join_day"], 0, 4);
        $def_fdata["form_join_day"]["m"]                 =    substr($data_list["join_day"], 5, 2);
        $def_fdata["form_join_day"]["d"]                 =    substr($data_list["join_day"], 8, 2);
    }
    
    // �࿦����̵��������ɽ��
    if ($data_list["retire_day"] == null){
        $retire_day_flg                                  =    "t";
    }else{
        $def_fdata["form_retire_day"]["y"]               =    substr($data_list["retire_day"], 0, 4);
        $def_fdata["form_retire_day"]["m"]               =    substr($data_list["retire_day"], 5, 2);
        $def_fdata["form_retire_day"]["d"]               =    substr($data_list["retire_day"], 8, 2);
    }

    $def_fdata["form_employ_type"]                       =    $data_list["employ_type"]; 
    $def_fdata["form_position"]                          =    $data_list["position"];
    $def_fdata["form_job_type"]                          =    $data_list["job_type"]; 
    $def_fdata["form_study"]                             =    ($change_flg == "t") ? htmlspecialchars($data_list["study"]) : $data_list["study"];
    
    // �ѹ��Բ�ǽȽ��
    if ($change_flg == "t"){
        if ($data_list["toilet_license"] == "1"){
            $def_fdata["form_toilet_license"]            =    "����ȥ�����ǻ�";
        }else if ($data_list["toilet_license"] == "2"){
            $def_fdata["form_toilet_license"]            =    "����ȥ�����ǻ�";
        }else{
            $def_fdata["form_toilet_license"]            =    "̵";
        }
    }else{
        $def_fdata["form_toilet_license"]                =    $data_list["toilet_license"];
    }

    $def_fdata["form_license"]                           =    $data_list["license"];
    $def_fdata["form_note"]                              =    $data_list["note"];
    $def_fdata["form_photo"]                             =    $data_list["photo"];
    $def_fdata["form_photo_del"]                         =    "1";
    $def_fdata["form_login_id"]                          =    $data_list["login_id"];
    $def_fdata["form_staff_id"]                          =    $staff_id;
    $def_fdata["staff_url"]                              =    "true";
    $def_fdata["form_round_staff"]                       =    ($data_list["round_staff_flg"] == "t") ? true : false;
    $def_fdata["form_h_change_flg"]                      =    ($data_list["h_change_flg"] == "t") ? true : false;

    // ���ء����إܥ���˥��åȤ����ͤ����
    $id_data = Make_Get_Id($db_con, "staff", $data_list[2], "2");
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    // ��°�ޥ��������ѹ��������
    $sql  = "SELECT ";
    $sql .= "    t_attach.shop_id, ";                 // �����ID
    $sql .= "    t_attach.part_id, ";                 // ����ID
    $sql .= "    t_attach.section, ";                 // ��°����ʲݡ�
    $sql .= "    t_attach.ware_id,  ";                // �Ҹ�ID
    $sql .= "    t_part.branch_id ";
    $sql .= "FROM ";
    $sql .= "    t_attach "; 
    $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
    $sql .= "    INNER JOIN t_part  ON t_attach.part_id = t_part.part_id ";
    $sql .= "WHERE ";
    //ľ��Ƚ��
    if($_SESSION[group_kind] == '2'){
        //ľ��
        $sql .= "    t_attach.shop_id IN(".Rank_Sql().")";
    }else{ 
        //�ƣ�
        $sql .= "    t_attach.shop_id = $client_id ";
    }
    $sql .= "AND ";
    $sql .= "    t_attach.staff_id = $staff_id ";
    $res = Db_Query($db_con,$sql.";");

    $data_list = pg_fetch_array($res, 0);
    $def_fdata["form_cshop"]                            =    $data_list["shop_id"];
    $def_fdata["form_part"][0]                          =    $data_list["branch_id"];
    $def_fdata["form_part"][1]                          =    $data_list["part_id"];
    $def_fdata["form_section"]                          =    $data_list["section"];
    $def_fdata["form_ware"]                             =    $data_list["ware_id"];

}else{
    $def_fdata = array(
        "form_sex"             => "1",
        "form_state"           => "�߿���",
        "form_employ_type"     => "�������å�",
        "form_job_type"        => "�Ķ�",
        "form_toilet_license"  => "3",
        "staff_url"            => "true",
    );
    $staff_code_flg = "f";     // �ͥåȥ����IDɽ��
    $birth_day_flg  = "f";     // ��ǯ����ɽ��
    $join_day_flg   = "f";     // ����ǯ����ɽ��
    $retire_day_flg = "f";     // �࿦��ɽ��

}

$def_fdata["form_login_info"] = "1";

$form->setDefaults($def_fdata);


/****************************/
// �ե�����ѡ������
/****************************/
// �߿�����
// �ѹ��Բ�ǽȽ��
if ($change_flg == "t"){
    $form->addElement("static", "form_state", "", "");
}else{
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "�߿���", "�߿���");
    $radio[] =& $form->createElement("radio", null, null, "�࿦", "�࿦");
    $radio[] =& $form->createElement("radio", null, null, "�ٶ�", "�ٶ�");
    $form->addGroup($radio, "form_state", "�߿�");
}

// ����������ѹ�����Ĥ��ʤ�
$form->addElement("checkbox", "form_h_change_flg", "", "����������ѹ�����Ĥ��ʤ�");

// �ͥåȥ����ID
// ��Ͽ���ͥåȥ����ID����Ͽ����Ƥ��ʤ���硢��ɽ��
if ($staff_id != null && $staff_code_flg != "t"){
    $text = null;
    $text[] =& $form->createElement("static", "cd1", "", "");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("static", "cd2", "", "");
    $form->addGroup($text, "form_staff_cd", "form_staff_cd");
}

// �����å�̾
// �ѹ��Բ�ǽȽ��
$type = ($change_flg == "t") ? "static" : "text";
$opt  = ($change_flg == "t") ? "" : "size=\"22\" maxLength=\"10\" ".$g_form_option."\"";
$form->addElement($type, "form_staff_name", "", $opt);

// �����å�̾(�եꥬ��)
// �ѹ��Բ�ǽȽ��
$type = ($change_flg == "t") ? "static" : "text";
$opt  = ($change_flg == "t") ? "" : "size=\"22\" maxLength=\"20\" ".$g_form_option."\"";
$form->addElement($type, "form_staff_read", "", $opt);

// �����å�̾(���޻�)
// �ѹ��Բ�ǽȽ��
$type = ($change_flg == "t") ? "static" : "text";
$opt  = ($change_flg == "t") ? "" : "size=\"22\" maxLength=\"30\" style=\"$g_form_style\" ".$g_form_option."\"";
$form->addElement($type, "form_staff_ascii", "", $opt);

// ����
// �ѹ��Բ�ǽȽ��
if ($change_flg == "t"){
    $form->addElement("static", "form_sex", "", "");
}else{
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "��", "1");
    $radio[] =& $form->createElement("radio", null, null, "��", "2");
    $form->addGroup($radio, "form_sex", "����");
}

// ��ǯ����
// �ѹ��Բ�ǽȽ��
if ($change_flg == "t"){
    // ��ǯ��������Ͽ����Ƥ��ʤ���硢��ɽ��
    if ($birth_day_flg != "t"){
        $text = null;
        $text[] =& $form->createElement("static", "y", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "m", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "d", "", "");
        $form->addGroup( $text, "form_birth_day", "form_birth_day");
    }
}else{
    $text = null;
    $text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_birth_day[y]','form_birth_day[m]',4)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_birth_day[m]','form_birth_day[d]',2)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
    $form->addGroup( $text, "form_birth_day", "form_birth_day");
}

// �࿦��
// �ѹ��Բ�ǽȽ��
if ($change_flg == "t"){
    // �࿦������Ͽ����Ƥ��ʤ���硢��ɽ��
    if ($retire_day_flg != "t"){
        $text = null;
        $text[] =& $form->createElement("static", "y", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "m", "", "");
        $text[] =& $form->createElement("static", "", "", "-");
        $text[] =& $form->createElement("static", "d", "", "");
        $form->addGroup( $text, "form_retire_day", "form_retire_day");
    }
}else{
    $text = null;
    $text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_retire_day[y]','form_retire_day[m]',4)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_retire_day[m]','form_retire_day[d]',2)\"".$g_form_option."\"");
    $text[] =& $form->createElement("static", "", "", "-");
    $text[] =& $form->createElement("text", "d", "",  "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
    $form->addGroup( $text, "form_retire_day", "form_retire_day");
}

// ��������
// �ѹ��Բ�ǽȽ��
if ($change_flg == "t"){
    $form->addElement("static", "form_study", "", "");
}else{
    $form->addElement("text", "form_study", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
}

// �ȥ�����ǻ��
// �ѹ��Բ�ǽȽ��
if ($change_flg == "t"){
    $form->addElement("static", "form_toilet_license", "", "");
}else{
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "����ȥ�����ǻ�", "1");
    $radio[] =& $form->createElement("radio", null, null, "����ȥ�����ǻ�", "2");
    $radio[] =& $form->createElement("radio", null, null, "̵", "3");
    $form->addGroup($radio, "form_toilet_license", "�ȥ�����ǻ��");
}

// �����̿�����饸���ܥ���
// �ѹ��Բ�ǽor��ϿȽ��
if ($change_flg != "t" && $staff_id != null){
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "������ʤ�<br>", "1");
    $radio[] =& $form->createElement("radio", null, null, "�������", "2");
    $form->addGroup($radio, "form_photo_del", "�����̿�");
}

// �ե�����ʾ����̿���
// �ѹ��Բ�ǽȽ��
if ($change_flg != "t"){
    $form->addElement("file", "form_photo_ref", "�����̿�", "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"");
}

// �����̿��ե�����̾
$form->addElement("hidden", "form_photo");

// ô���ԥ�����
$form->addElement("text", "form_charge_cd", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");

// ����ǯ����
$text = null;
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_join_day[y]','form_join_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_join_day[m]','form_join_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"".$g_form_option."\"");
$form->addGroup( $text, "form_join_day", "form_join_day");

// ���ѷ���
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "�������å�", "�������å�");
$radio[] =& $form->createElement("radio", null, null, "�ѡ���", "�ѡ���");
$radio[] =& $form->createElement("radio", null, null, "����Х���", "����Х���");
$radio[] =& $form->createElement("radio", null, null, "����", "����");
$radio[] =& $form->createElement("radio", null, null, "����", "����");
$radio[] =& $form->createElement("radio", null, null, "����¾", "����¾");
$form->addGroup($radio, "form_employ_type", "���ѷ���");

// ��°����
/*
$select_value = Select_Get($db_con, "part");
$form->addElement("select", "form_part", "", $select_value, $g_form_option_select);
*/
$obj_bank_select =& $form->addElement("hierselect", "form_part", "", "");
$obj_bank_select->setOptions(Make_Ary_Branch($db_con));

// ��°����(��)
$form->addElement("text", "form_section", "", "size=\"22\" maxLength=\"7\" ".$g_form_option."\"");

// ��
$form->addElement("text", "form_position", "", "size=\"15\" maxLength=\"7\" ".$g_form_option."\"");

// ����
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "�Ķ�", "�Ķ�");
$radio[] =& $form->createElement("radio", null, null, "�����ӥ�", "�����ӥ�");
$radio[] =& $form->createElement("radio", null, null, "��̳", "��̳");
$radio[] =& $form->createElement("radio", null, null, "����¾", "����¾");
$form->addGroup($radio, "form_job_type", "����");

// ô���Ҹ�
//ô���Ҹˤ�ɽ�����ʤ�
//$select_value = Select_Get($db_con, "ware");
//$form->addElement("select", "form_ware", "", $select_value, $g_form_option_select);
$form->addElement("hidden", "form_ware");

// ���ô����
$form->addElement("checkbox", "form_round_staff", "", "");

// �������
$form->addElement("textarea", "form_license", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// ����
//$form->addElement("text", "form_note", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
$form->addElement("textarea", "form_note", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// ������ID
$form->addElement("text", "form_login_id", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");

// �ѥ���ɡ��ѥ���ɡʳ�ǧ��
$form->addElement("password", "form_password1", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addElement("password", "form_password2", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");

// ���������ΰ���
$radio = null; 
$radio[] =& $form->createElement("radio", null, null, $login_info_type."���ʤ�", "1");
$radio[] =& $form->createElement("radio", null, null, $login_info_type."����", "2");
if ($login_info_type == "�ѹ�"){$radio[] =& $form->createElement("radio", null, null, "�������", "3");}
$form->addGroup($radio, "form_login_info", "���������ΰ���");

// ��Ͽ(�إå�)
$form->addElement("button", "new_button", "��Ͽ����", "style=\"color:#ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:Referer('2-1-107.php')\"");

/*** hidden�ե����� ***/
// GET�Ǽ������������å�ID����¸
$form->addElement("hidden", "form_staff_id");

// �ѹ��ԲĤξ��Ǥ⡢ô���ԥ����ɡ������å�̾���ݻ�����
$form->addElement("hidden", "h_charge_cd");
$form->addElement("hidden", "h_staff_name");

// �����å���Ͽ���̤�URL
$form->addElement("hidden", "staff_url");

// ����̤���ꥨ�顼�������ѥե�����
$form->addElement("text", "permit_error");

// ��������ѥե饰
$form->addElement("hidden", "set_permit_flg");


/****************************/
// �ե�����ѡ������(����)
/****************************/
/*** FC�����å��ܥå������ǤθĿ����� ***/
$ary_mod_data = Permit_Item();

$ary_f_mod_data = $ary_mod_data[1];

// ��˥塼��
$ary_f[0] = count($ary_f_mod_data);
for ($i = 0; $i < $ary_f[0]; $i++){
    // �ƥ�˥塼��Υ��֥�˥塼��
    $ary_f[1][$i] = count($ary_f_mod_data[$i][1]);
    for ($j = 0; $j < $ary_f[1][$i]; $j++){
        // �ƥ��֥�˥塼��Υ����å��ܥå�����
        $ary_f[2][$i][$j] = count($ary_f_mod_data[$i][1][$j][1]);
    }
}

$ary_opt  = array("r", "w", "n");
for ($i=0; $i<=$ary_f[0]; $i++){
    for ($j=0; $j<=$ary_f[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_f[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[f][$i][$j][$k][$ary_opt[$l]]";
                $form->addElement("hidden", $me, "");
            }       
        }       
    }
}


// ������¥����å�
$form->addElement("hidden", "permit_delete", "");

// ��ǧ���¥����å�
$form->addElement("hidden", "permit_accept", "");

// ����ܥ���
$form->addElement("hidden", "form_set_button", "");


/****************************/
// ��Ͽ�ܥ��󲡲�������
/****************************/
if ($_POST["entry_button"] != null){

    /****************************/
    // ���顼�����å�(AddRule)
    /****************************/
    /*** ô���ԥ����� ***/
    // �ѹ��Բ�ǽȽ��
    if ($change_flg != "t"){
        // ɬ�ܥ����å�
        $form->addRule("form_charge_cd", "ô���ԥ����� ��Ⱦ�ѿ����ΤߤǤ���", "required");
        // ʸ��������å�
        $form->addRule("form_charge_cd", "ô���ԥ����� ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");
    }

    /*** �����å�̾ ***/
    // �ѹ��Բ�ǽȽ��
    if ($change_flg != "t"){
        //��ɬ�ܥ����å�
        $form->addRule("form_staff_name", "�����å�̾ ��10ʸ������Ǥ���", "required");
        // ���ڡ��������å�
        $form->registerRule("no_sp_name", "function", "No_Sp_Name");
        $form->addRule("form_staff_name", "�����å�̾�� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");
    }

    /*** �����å�̾�ʥ��޻��� ***/
    // �ѹ��Բ�ǽȽ��
    if ($change_flg != "t"){
        // ɬ�ܥ����å�
        $form->addRule("form_staff_ascii", "�����å�̾(���޻�) �ϥ������������ɤΤ߻��ѲĤǤ���", "required");
        // ʸ��������å�
        $form->addRule("form_staff_ascii", "�����å�̾(���޻�) �ϥ������������ɤΤ߻��ѲĤǤ���", "ascii");
    }

    /*** �����̿� ***/
    // ��ĥ�ҥ����å�
    $form->addRule("form_photo_ref", "�����ʲ����ե�����Ǥ���", "mimetype", array("image/jpeg", "image/jpeg","image/pjpeg"));

    /*** ��ǯ���� ***/
    // ʸ��������å�
    $form->addGroupRule("form_birth_day", array(
        "y" => array(
            array("��ǯ���� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
        "m" => array(
            array("��ǯ���� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
        "d" => array(
            array("��ǯ���� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
    ));

    /*** ����ǯ���� ***/
    // ʸ��������å�
    $form->addGroupRule("form_join_day", array(
        "y" => array(
            array("����ǯ���� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
        "m" => array(
            array("����ǯ���� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
        "d" => array(
            array("����ǯ���� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
    ));

    /*** �࿦�� ***/
    // ʸ��������å�
    $form->addGroupRule("form_retire_day", array(
        "y" => array(
            array("�࿦�� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
        "m" => array(
            array("�࿦�� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
        "d" => array(
            array("�࿦�� �����դ������ǤϤ���ޤ���", "regex", "/^[0-9]+$/")
        ),
    ));

    /*** ������� ***/
    // ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_license","������� ��200ʸ������Ǥ���","mb_maxlength","200");

    /*** ���� ***/
    // ʸ���������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note","���� ��2000ʸ������Ǥ���","mb_maxlength","2000");


    // ������������Ͽ/�ѹ����� �˥����å����դ��Ƥ�����
    if ($_POST["form_login_info"] == "2"){

        /*** ������ID ***/
        // ɬ�ܥ����å�
        $form->addRule("form_login_id", "������ID ��6ʸ���ʾ�20ʸ������Ǥ���", "required");
        // ʸ���������å�
        $form->addRule("form_login_id", "������ID ��6ʸ���ʾ�20ʸ������Ǥ���", "rangelength", array(6, 20));

        /*** �ѥ���� ***/
        // �����ξ��ϥѥ���ɤ�ɬ�ܤǤϤʤ�
        if ($login_info_type == "��Ͽ"){
            // ɬ�ܥ����å�
            $form->addRule("form_password1", "�ѥ���� ��6ʸ���ʾ�20ʸ������Ǥ���", "required");
        }
        // ʸ���������å�
        $form->addRule("form_password1", "�ѥ���� ��6ʸ���ʾ�20ʸ������Ǥ���", "rangelength", array(6, 20));

        /*** ���� ***/
        // ��Ͽ/�ѹ����롡���ġ���������ܥ��󤬲�������Ƥ��ʤ����
        if ($_POST["form_login_info"] == "2" && $_POST["set_permit_flg"] == null){
            // �����å��ѹ���
            if ($staff_id != null){
                // ���¥ơ��֥����Ͽ��̵����Х��顼
                $sql = "SELECT staff_id FROM t_permit WHERE staff_id = $staff_id;";
                $res = Db_Query($db_con, $sql);
                if (pg_num_rows($res) == 0){
                    $form->setElementError("permit_error", "���� �������ɬ�ܤǤ���");
                }
            // �����åտ�����Ͽ��
            }else{
                // ����̵�Ѥǥ��顼
                $form->setElementError("permit_error", "���� �������ɬ�ܤǤ���");
            }
        }

    }

    // �ѹ��Բ�ǽ��
    if ($_POST["form_charge_cd"] != null){
        $charge_cd      = $_POST["form_charge_cd"];      //ô���ԥ�����
    }else{
        $charge_cd      = $_POST["h_charge_cd"];         //ô���ԥ�����
    }
    $staff_name     = $_POST["form_staff_name"];         //�����å�̾
    $staff_read     = $_POST["form_staff_read"];         //�����å�̾(�եꥬ��)
    $staff_ascii    = $_POST["form_staff_ascii"];        //�����å�̾(���޻�)
    $sex            = $_POST["form_sex"];                //����
    $birth_day_y    = $_POST["form_birth_day"]["y"];     //��ǯ����
    $birth_day_m    = $_POST["form_birth_day"]["m"]; 
    $birth_day_d    = $_POST["form_birth_day"]["d"];
    $state          = $_POST["form_state"];              //�߿�����
    $join_day_y     = $_POST["form_join_day"]["y"];      //����ǯ����
    $join_day_m     = $_POST["form_join_day"]["m"];     
    $join_day_d     = $_POST["form_join_day"]["d"];
    $retire_day_y   = $_POST["form_retire_day"]["y"];    //�࿦��
    $retire_day_m   = $_POST["form_retire_day"]["m"];    
    $retire_day_d   = $_POST["form_retire_day"]["d"];
    $employ_type    = $_POST["form_employ_type"];        //���ѷ���
    $part_id        = $_POST["form_part"][1];               //����ID
    $section        = $_POST["form_section"];            //��°����ʲݡ�
    $position       = $_POST["form_position"];           //��
    $job_type       = $_POST["form_job_type"];           //����
    $study          = $_POST["form_study"];              //��������
    $toilet_license = $_POST["form_toilet_license"];     //�ȥ�����ǻλ��
    $license        = $_POST["form_license"];            //�������
    $note           = $_POST["form_note"];               //����
    $ware_id        = $_POST["form_ware"];               //ô���Ҹ�ID
    $photo_del      = $_POST["form_photo_del"];          //�̿�����ե饰
    $photo          = $_POST["form_photo"];              //�̿��ե�����̾
    $login_id       = $_POST["form_login_id"];           //������ID
    $password1      = $_POST["form_password1"];          //�ѥ����
    $password2      = $_POST["form_password2"];          //�ѥ���ɳ�ǧ
    $permit_msg     = $_POST["permit_msg"];              //���������å�����
    $round_staff    = ($_POST["form_round_staff"] == "1") ? "t" : "f";        // ���ô����
    $h_change_flg   = ($_POST["form_h_change_flg"] == "1") ? "t" : "f";

    /****************************/
    // ���顼�����å�(PHP)
    /****************************/
    /*** ô���ԥ����� ***/
    // ��ʣ�����å�
    if ($charge_cd != null && ereg("^[0-9]+$", $charge_cd)){

        // ô���ԥ����ɤˣ�������
        $charge_cd = str_pad($charge_cd, 4, 0, STR_POS_LEFT);

        //���롼�׼���Ƚ��
        if($group_kind == '2'){
            //ľ��

            // ���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
            $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = '$charge_cd' ";
            $sql .= "AND ";
            $sql .= "    t_rank.rank_cd = '$rank_cd' ";

        }else if($group_kind == '3'){
            //�ƣ�

            // ���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff  ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = '$charge_cd' ";
            $sql .= "AND ";
            $sql .= "    t_attach.shop_id = $client_id ";
        }
        // �ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if ($staff_id != null){
            $sql .= " AND NOT ";
            $sql .= "t_attach.staff_id = '$staff_id'";
        }
        $sql .= ";";
        $res = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($res);
        if ($row_count != 0){
            $form->setElementError("form_charge_cd", "���˻��Ѥ���Ƥ��� ô���ԥ����� �Ǥ���");
        }
    }

    /*** ��ǯ���� ***/
    // ���դ�¸�ߥ����å�
    // �������Ϥ��줿���˥����å���Ԥ�
    if ($birth_day_y != null || $birth_day_m != null || $birth_day_d != null){
        $birth_day_y = (int)$birth_day_y;
        $birth_day_m = (int)$birth_day_m;
        $birth_day_d = (int)$birth_day_d;
        // ���դ������������å�
        if (checkdate($birth_day_m,$birth_day_d,$birth_day_y)){
            $birth_day_y = str_pad($birth_day_y, 4, "0", STR_PAD_LEFT);
            $birth_day_m = str_pad($birth_day_m, 2, "0", STR_PAD_LEFT);
            $birth_day_d = str_pad($birth_day_d, 2, "0", STR_PAD_LEFT);
            $birth_day = "'".$birth_day_y."-".$birth_day_m."-".$birth_day_d."'";
        }else{
            $form->setElementError("form_birth_day","��ǯ���� �������ǤϤ���ޤ���");
        }
    }else{
        // �������Ϥ���Ƥ��ʤ�����NULL����
        $birth_day = "null";
    }

    /*** ����ǯ���� ***/
    // ���դ�¸�ߥ����å�
    if ($join_day_y != null || $join_day_m != null || $join_day_d != null){
        $join_day_y = (int)$join_day_y;
        $join_day_m = (int)$join_day_m;
        $join_day_d = (int)$join_day_d;
        if (checkdate($join_day_m,$join_day_d,$join_day_y)){
            $join_day_y = str_pad($join_day_y, 4, "0", STR_PAD_LEFT);
            $join_day_m = str_pad($join_day_m, 2, "0", STR_PAD_LEFT);
            $join_day_d = str_pad($join_day_d, 2, "0", STR_PAD_LEFT);
            $join_day = "'".$join_day_y."-".$join_day_m."-".$join_day_d."'";
        }else{
            $form->setElementError("form_join_day","����ǯ���� �������ǤϤ���ޤ���");
        }
    }else{
        $join_day = "null";
    }

    /*** �࿦�� ***/
    // ���դ�¸�ߥ����å�
    if ($retire_day_y != null || $retire_day_m != null || $retire_day_d != null){
        $retire_day_y = (int)$retire_day_y;
        $retire_day_m = (int)$retire_day_m;
        $retire_day_d = (int)$retire_day_d;
        if (checkdate($retire_day_m,$retire_day_d,$retire_day_y)){
            $retire_day_y = str_pad($retire_day_y, 4, "0", STR_PAD_LEFT);
            $retire_day_m = str_pad($retire_day_m, 2, "0", STR_PAD_LEFT);
            $retire_day_d = str_pad($retire_day_d, 2, "0", STR_PAD_LEFT);
            $retire_day = "'".$retire_day_y."-".$retire_day_m."-".$retire_day_d."'";
        }else{
            $form->setElementError("form_retire_day","�࿦�� �������ǤϤ���ޤ���");
        }
    }else{
        $retire_day = "null";
    }

    // �����������Ͽ�������˥����å����դ��Ƥ���
    if ($_POST["form_login_info"] == "2"){

        /*** ������ID ***/
        // ʸ��������å�
        if (!ereg("^[0-9a-zA-Z_-]+$", $login_id) && $login_id != null){
            $form->setElementError("form_login_id","������ID ��Ⱦ�ѱѿ������ϥ��ե󡢥�������С��Τ߻��ѲĤǤ���");
        }

        // ��ʣ�����å�
        if ($login_id != null){
            //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "    login_id ";
            $sql .= "FROM ";
            $sql .= "    t_login ";
            $sql .= "WHERE ";
            $sql .= "    login_id = '$login_id' ";
            // �ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "    staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_login_id", "���˻��Ѥ���Ƥ��� ������ID �Ǥ���");
            }
        }

        /*** �ѥ���ɡ��ѥ���ɳ�ǧ ***/
        // ʸ��������å�
        if (!ereg("^[0-9a-zA-Z_-]+$", $password1) && $password1 != null){
            $form->setElementError("form_password1","�ѥ���� ��Ⱦ�ѱѿ������ϥ��ե󡢥�������С��Τ߻��ѲĤǤ���");
        }
        // �ͤ���������
        if ($password1 != $password2 && $password1 != null){
            $form->setElementError("form_password1","�ѥ���ɤȳ�ǧ�Ѥ����Ϥ��줿�ѥ���ɤ��ۤʤ�ޤ���");
        }
    }

    /***��°����***/
    //ɬ�ܥ����å�
    if($part_id == null){
       $form->setElementError("form_part","��°�����ɬ�ܤǤ���"); 
    }

    // ���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
    if ($form->validate() && $err_flg == false){
        Db_Query($db_con, "BEGIN;");

        // ��Ͽ�ξ�����������Ԥʤ�
        if ($staff_id == null){
            // �����å�ID����
            // ��¾����
            Db_Query($db_con,"LOCK TABLE t_staff;");
            $sql  = "SELECT COALESCE(MAX(staff_id), 0)+1 FROM t_staff;";
            $res = Db_Query($db_con,$sql);
            $staff_id_get = pg_fetch_result($res, 0, 0);
        }

        /****************************/
        // �����Υ��åץ��ɡ����
        /****************************/
        // ������ʤ��˥����å�&�ե����뤬���ꤵ��Ƥ�Ȥ�����Ͽ���˥ե����뤬���ꤵ��Ƥ��뤫
        if (($photo_del == 1 && $_FILES["form_photo_ref"]["tmp_name"] != null) || 
            ($staff_id == null && $_FILES["form_photo_ref"]["tmp_name"] != null)){
            // �̿��Υե�����̾����
            if ($staff_id == null){
                $photo = $staff_id_get.".jpg";
            }else{
                //  �ѹ�����
                $photo = $staff_id.".jpg";
            }
            // ���åץ�����Υѥ�����
            $up_file = STAFF_PHOTO_DIR.$photo;
            // ���åץ���
            $res = move_uploaded_file($_FILES['form_photo_ref']['tmp_name'], $up_file);
            if ($res == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
        }

        // �̿��κ��Ƚ��
        if ($photo_del == 2){
            // �ѹ�����
            $photo = $staff_id.".jpg";
            // ���åץ�����Υѥ�����
            $up_file = STAFF_PHOTO_DIR.$photo;
            // �ե�����¸��Ƚ��
            if (file_exists($up_file)){
                // �ե�������
                $res = unlink($up_file);
                if ($res == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }
            }
            $photo = "";
        }

        Db_Query($db_con, "BEGIN;");

        /****************************/
        // �����åեޥ�����Ͽ����������
        /****************************/
        if ($staff_id != null){

            /*** �ѹ����� ***/
            // ��ȶ�ʬ�Ϲ���
            $work_div = "2";

            // �ѹ��Բ�ǽȽ��
//            if ($change_flg != "t"){
                $sql  = "UPDATE \n";
                $sql .= "    t_staff \n";
                $sql .= "SET \n";
                if ($change_flg != "t"){
                    $sql .= "    staff_name       = '$staff_name', \n";    
                    $sql .= "    staff_read       = '$staff_read', \n";    
                    $sql .= "    staff_ascii      = '$staff_ascii', \n";    
                    $sql .= "    sex              = '$sex',\n";
                    $sql .= "    birth_day        = $birth_day, \n";    
                    $sql .= "    retire_day       = $retire_day, \n";    
                    $sql .= "    study            = '$study', \n";        
                    $sql .= "    toilet_license   = '$toilet_license', \n";
                    $sql .= "    photo            = '$photo', \n";
                    $sql .= "    state            = '$state', \n";        
                }
                $sql .= "    charge_cd        = '$charge_cd',\n";        
                $sql .= "    join_day         = $join_day, \n";        
                $sql .= "    employ_type      = '$employ_type', \n";
                $sql .= "    position         = '$position', \n";        
                $sql .= "    job_type         = '$job_type', \n";        
                $sql .= "    license          = '$license', \n";        
                $sql .= "    note             = '$note', \n";    
                $sql .= "    round_staff_flg  = '$round_staff', \n"; 
                $sql .= "    h_change_flg     = '$h_change_flg' \n"; 
                $sql .= "WHERE \n";
                $sql .= "    staff_id = $staff_id;";
//            }

        }else{

            /*** ��Ͽ���� ***/
            // ��ȶ�ʬ����Ͽ
            $work_div = '1';

            $sql  = "INSERT INTO ";
            $sql .= "    t_staff ";
            $sql .= "VALUES(";
            $sql .= "    $staff_id_get,";
            $sql .= "    null,";
            $sql .= "    null,";
            $sql .= "    '$staff_name',";
            $sql .= "    '$staff_read',";
            $sql .= "    '$staff_ascii',";
            $sql .= "    '$sex',";
            $sql .= "    $birth_day,";
            $sql .= "    '$state',";
            $sql .= "    $join_day,";
            $sql .= "    $retire_day,";
            $sql .= "    '$employ_type',";
            $sql .= "    '$position',";
            $sql .= "    '$job_type',";
            $sql .= "    '$study',";
            $sql .= "    '$toilet_license',";
            $sql .= "    '$license',";
            $sql .= "    '$note',";
            $sql .= "    '$photo',";
            $sql .= "    false,";
            $sql .= "    '$charge_cd',";
            $sql .= "    '$round_staff', ";
            $sql .= "    '$h_change_flg');";

        }

        $res = Db_Query($db_con,$sql);
        if ($res == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        // �����åեޥ������ͤ���˽񤭹���
        $res = Log_Save($db_con, "staff", $work_div, $charge_cd, $staff_name);
        // ����Ͽ���˥��顼�ˤʤä����
        if ($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /****************************/
        // ��°�ޥ�����Ͽ����������
        /****************************/

        //ô���Ҹ���Ͽ�ؿ�
        $create_ware_staff_data = array($charge_cd,     //ô���ԥ�����
                                        $staff_name,    //ô����̾
                                        $client_id,     //����å�ID
                                        $staff_id_get,  //�����å�ID
                                        $db_con,        //Db���ͥ������
                                        $ware_id        //�Ҹ�ID
                                );
        $ware_id    = Create_Ware_Staff($create_ware_staff_data);

        // �ѹ�Ƚ��
        if ($staff_id != null){
            // ��������
            $sql  = "UPDATE\n ";
            $sql .= "    t_attach \n";
            $sql .= "SET \n";
            // ��°����¸��Ƚ��
            $sql .= ($part_id != null) ? "part_id = $part_id, \n" : null;
            // ô���Ҹ�¸��Ƚ��
            $sql .= ($ware_id != null) ? "ware_id = $ware_id, \n" : "ware_id = NULL, \n";
            $sql .= "    section = '$section' \n";
            $sql .= "WHERE \n";
            $sql .= "    staff_id = $staff_id \n";
            $sql .= "AND \n";
            $sql .= ($group_kind == '2')? "shop_id IN (".Rank_Sql().") \n" : "  shop_id = $client_id\n";
            $sql .= "; \n";
        }else{
            // ��Ͽ����
            $sql  = "INSERT INTO ";
            $sql .= "    t_attach ";
            $sql .= "VALUES(";
            $sql .= "    $client_id,";
            $sql .= "    $staff_id_get,";
            // ��°����¸��Ƚ��
            $sql .= ($part_id != null) ? "$part_id, " : "NULL, ";
            $sql .= "    '$section',";
            // ô���Ҹ�¸��Ƚ��
            $sql .= ($ware_id != null) ? "$ware_id,"  : "NULL, ";
            $sql .= "'f',";
            $sql .= "'f');";
        }   
        $res = Db_Query($db_con,$sql);
        if ($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /****************************/
        // ������ޥ�����Ͽ����������
        /****************************/
        // �����������Ͽ�������˥����å����դ��Ƥ�����
        if ($_POST["form_login_info"] == "2"){
            // �ѥ���ɤ�ϥå��岽
            $crypt_pass = crypt($password1);
            // ��Ͽ���ѹ�Ƚ��
            if ($login_info_type == "��Ͽ"){
                // �����å���Ͽ��Ʊ���˥�����������Ͽ������
                if ($staff_id == null){
                    $sql  = "INSERT INTO ";
                    $sql .= "    t_login ";
                    $sql .= "VALUES(";
                    $sql .= "(SELECT ";
                    $sql .= "    t_staff.staff_id ";
                    $sql .= "FROM ";
                    $sql .= "    t_staff ";
                    $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
                    $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
                    $sql .= "WHERE ";
                    $sql .= "    t_staff.charge_cd = $charge_cd ";
                    $sql .= "AND ";
                    $sql .= "    t_attach.shop_id = $client_id ";
                    $sql .= "),";
                    $sql .= "'$login_id',";
                    $sql .= "'$crypt_pass');";
                }else{
                // �����å���Ͽ��ˡ��ɲäǥ�����������Ͽ������
                    $sql  = "INSERT INTO ";
                    $sql .= "    t_login ";
                    $sql .= "        (";
                    $sql .= "        staff_id, ";
                    $sql .= "        login_id, ";
                    $sql .= "        password";
                    $sql .= "        ) ";
                    $sql .= "VALUES ";
                    $sql .= "        (";
                    $sql .= "        $staff_id, ";
                    $sql .= "        '$login_id', ";
                    $sql .= "        '$crypt_pass'";
                    $sql .= "        )";
                    $sql .= ";";
                 }  
            }else{
                //�ѹ�����
                $sql  = "UPDATE ";
                $sql .= "   t_login ";
                $sql .= "SET ";
                $sql .= "   login_id = '$login_id' ";
                //�ѥ���ɤ�̤���Ϥξ��ϡ��������ʤ�
                if ($password1!=null){
                    $sql .= ",";
                    $sql .= "password = '$crypt_pass' ";
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id;";
            }
            $res = Db_Query($db_con,$sql);
            if ($res == false){
                Db_Query($db_con,"ROLLBACK;");
                exit;
            }
        }

        /****************************/
        // ���¥ޥ�����Ͽ����������
        /****************************/
        // �����������Ͽ/�����ܸ������ꤵ��Ƥ�����
        if ($_POST["form_login_info"] == "2" && $_POST["set_permit_flg"] != null){
            // �������
            $permit_delete = ($_POST["permit_delete"] != null) ? "TRUE" : "FALSE";

            // ��ǧ����
            $permit_accept = ($_POST["permit_accept"] != null) ? "TRUE" : "FALSE";

            //
            $permit_col = Permit_Col("fc");

            $p = 0;
            // FC�����¥ơ��֥�Υ����̾����Ϳ���븢�¡�n, r, w�ˤ򥻥åȤˤ�������κ���
            for ($i=1; $i<=$ary_f[0]; $i++){
                for ($j=1; $j<=$ary_f[1][$i-1]; $j++){
                    for ($k=1; $k<=$ary_f[2][$i-1][$j-1]; $k++){
                        $me = "[$i][$j][$k]";
                        if ($_POST[permit][f][$i][$j][$k][n] == null){  $permit_data[$p] = array($permit_col[f][$i][$j][$k], "n");}
                        if ($_POST[permit][f][$i][$j][$k][r] == 1){     $permit_data[$p] = array($permit_col[f][$i][$j][$k], "r");}
                        if ($_POST[permit][f][$i][$j][$k][w] == 1){     $permit_data[$p] = array($permit_col[f][$i][$j][$k], "w");}
                        $p++;
                    }
                }
            }
            $p = 0;
            // ���¥ơ��֥�Υ����̾����Ϳ���븢�¡�n, r, w�ˤ򥻥åȤˤ�������κ���
            for ($j=1; $j<=count($permit_col[f]); $j++){
                for ($k=1; $k<=count($permit_col[f][$j]); $k++){
                    for ($l=0; $l<count($permit_col[f][$j][$k]); $l++){
                        $permit_data[$p] = ($_POST[permit][f][$j][$k][$l][n] == null)   ? array($permit_col[f][$j][$k][$l], "n") : null;
                        $permit_data[$p] = ($_POST[permit][f][$j][$k][$l][r] == 1)      ? array($permit_col[f][$j][$k][$l], "r") : $permit_data[$p];
                        $permit_data[$p] = ($_POST[permit][f][$j][$k][$l][w] == 1)      ? array($permit_col[f][$j][$k][$l], "w") : $permit_data[$p];
                        $p++;
                    }
                }
            }

            // �������Ǥ������
            for ($i=0; $i<count($permit_data); $i++){
                if ($permit_data[$i][0][0] != null){
                    $permit_data_unnull[] = $permit_data[$i];
                }
            }
            $permit_data = $permit_data_unnull;

            /*** SQL���� ***/
            // �쥳����������������Ƚ��
            if ($staff_id != null){
                $sql  = "SELECT ";
                $sql .= "   staff_id ";
                $sql .= "FROM ";
                $sql .= "   t_permit ";
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id ";
                $sql .= ";";
                $res  = Db_Query($db_con, $sql);
                $num  = pg_num_rows($res);
                $status = ($num < 1) ? "insert" : "update";
            }else{
                $status = "insert";
            }

            // ������Ͽ�Υ����åա��ޤ���
            // �ѹ��ǲ��˸�����Ͽ���Ԥ��Ƥ��ʤ������å�
            if ($status == "insert"){
                $sql  = "INSERT INTO ";
                $sql .= "   t_permit ";
                $sql .= "       (";
                $sql .= "       staff_id, ";
                $sql .= "       del_flg, ";
                $sql .= "       accept_flg, ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                        $sql .= $permit_data[$i][0][$j];
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "       ) ";
                $sql .= "VALUES";
                $sql .= "       (";
                $sql .= "       (SELECT ";
                $sql .= "           t_staff.staff_id ";
                $sql .= "       FROM ";
                $sql .= "           t_staff ";
                $sql .= "           INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
                $sql .= "           INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
                $sql .= "       WHERE ";
                $sql .= "           t_staff.charge_cd = '$charge_cd' ";
                $sql .= "       AND ";
                $sql .= ($_SESSION["group_kind"] == "2") ? "t_attach.shop_id IN (".Rank_Sql().") " : " t_attach.shop_id = $client_id ";
                $sql .= "       ), ";
                $sql .= "       $permit_delete, ";
                $sql .= "       $permit_accept, ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                    $sql .= "'".$permit_data[$i][1]."'";
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "       ) ";
                $sql .= ";";
            // �ѹ��ǲ��˸�����Ͽ���Ԥ��Ƥ��륹���å�
            }else{
                $sql  = "UPDATE ";
                $sql .= "   t_permit ";
                $sql .= "SET ";
                $sql .= "   del_flg = '$permit_delete', ";
                $sql .= "   accept_flg = '$permit_accept'";
                $sql .= ($permit_data != null) ? "," : " ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                        $sql .= "   ".$permit_data[$i][0][$j]." = '".$permit_data[$i][1]."'";
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id ";
                $sql .= ";";
            }

            $res = Db_Query($db_con, $sql);
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }


        /****************************/
        // ���������������
        /****************************/
        // ������������˥����å����դ��Ƥ�����
        if ($_POST["form_login_info"] == "3"){

            // ������ޥ���
            $sql  = "DELETE FROM t_login WHERE staff_id = $staff_id;";
            $res  = Db_Query($db_con, $sql);
            if ($res === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

            // ���¥ޥ���
            $sql  = "DELETE FROM t_permit WHERE staff_id = $staff_id;";
            $res  = Db_Query($db_con, $sql);
            if ($res === false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

        }

        // ������Ͽ�ξ��ϡ�GET����̵���١�GET�������
        if ($staff_id == ""){
            $staff_id = $staff_id_get;        //�����å�ID
        }

        Db_Query($db_con, "COMMIT;");
        $freeze_flg = true;
    }


/******************************/
// ����ܥ��󲡲�����
/******************************/
}elseif ($_POST["del_button_flg"] == true){

    // ������褦�Ȥ��Ƥ��륹���åդ���ʬ�ξ��
    if ($staff_id == $ss_staff_id){

        $staff_del_restrict_msg = "���Υ����åդϺ���Ǥ��ޤ���";
        $staff_del_restrict_flg = true; 

    // ������褦�Ȥ��Ƥ��륹���åդ���ʬ�Ǥʤ����
    }else{  

        Db_Query($db_con, "BEGIN;");

        // �Ҹ�ID�����
        $sql  = "SELECT ware_id FROM t_attach WHERE staff_id = $staff_id AND h_staff_flg = 'f';";
        $res  = Db_Query($db_con, $sql);
        $num_ware   = pg_num_rows($res);
        if ($num_ware > 0){
            $del_ware_id = pg_fetch_result($res, 0, 0);
        }

		//���Ѥ�ô����CD�������å�̾����
		$sql  = "SELECT ";
		$sql .= "    charge_cd,";
		$sql .= "    staff_name ";
		$sql .= "FROM ";
		$sql .= "    t_staff ";
		$sql .= "WHERE ";
		$sql .= "    staff_id = $staff_id;";
		$result = Db_Query($db_con, $sql); 
		$data_list = Get_Data($result,3);

        // �����åեޥ���
        $sql  = "DELETE FROM t_staff WHERE staff_id = $staff_id;";
        //$res  = Db_Query($db_con, $sql);
        $res  = @pg_query($db_con, $sql);

        // ����Բĥ쥳���ɤξ��
        if ($res == false){ 
            $err_return = pg_last_error();
            $err_format = "violates foreign key";

            Db_Query($db_con, "ROLLBACK;");

            if (strstr($err_return, $err_format) != false){ 
                $staff_del_restrict_msg = "���Υ����åդϺ���Ǥ��ޤ���";
                $staff_del_restrict_flg = true; 
            }       

        // �����λ
        }else{  

			//�����åեޥ������ͤ���˽񤭹���
			//�ʥǡ��������ɡ������å�CD  ̾�Ρ������å�̾��
	        $res = Log_Save($db_con, "staff", 3,$data_list[0][0],$data_list[0][1]);
	        //����Ͽ���˥��顼�ˤʤä����
	        if($result === false){
	            Db_Query($db_con,"ROLLBACK;");
	            exit;
	        }

            // ô���Ҹˤ�������
            if ($del_ware_id != null){
                $sql  = "DELETE FROM t_ware WHERE ware_id = $del_ware_id;";
                //$res  = Db_Query($db_con, $sql);
                $res  = @pg_query($db_con, $sql);
                // ����Բĥ쥳���ɤξ��
                if ($res == false){ 
                    $err_return = pg_last_error();
                    $err_format = "violates foreign key";
                    Db_Query($db_con, "ROLLBACK;");
                    if (strstr($err_return, $err_format) != false){ 
                        $staff_del_restrict_msg = "���Υ����åդϺ���Ǥ��ޤ���";
                        $staff_del_restrict_flg = true; 
                    }
                }
            }

            Db_Query($db_con, "COMMIT;");
            header("Location: 2-1-107.php");

        }

    }

}
    
/******************************/
// ���ѥե�����ѡ������
/******************************/
/*** ���ϲ��̤ǤΤ�ɽ������ե����� ***/
if ($freeze_flg != true){

    // ��Ͽ�ܥ���
    $form->addElement("submit", "entry_button", "�С�Ͽ", "onClick=\"javascript:return Dialogue4('��Ͽ���ޤ���')\" $disabled");
    // ����ܥ���
    $form->addElement("button", "del_button", "���", "style=\"color: #ff0000;\" onClick=\"javascript:Dialogue_2('������ޤ���', '#', 'true', 'del_button_flg')\" $del_disabled");
    $form->addElement("hidden", "del_button_flg", "", "");
    $form->addElement("hidden", "freeze_flg", "", "");
    // ���¥��
    $form->addElement("link", "form_permit_link", "", "#", "����", "onClick=\"javascript:return Submit_Page2('2-1-112.php?staff_id=$staff_id');\"");
    // ���إܥ���
    $option = ($next_id != null) ? "onClick=\"location.href='./2-1-108.php?staff_id=$next_id'\"" : "disabled";
    $form->addElement("button", "next_button", "������", $option);
    // ���إܥ���
    $option = ($back_id != null) ? "onClick=\"location.href='./2-1-108.php?staff_id=$back_id'\"" : "disabled";
    $form->addElement("button", "back_button", "������", $option);

/*** ��Ͽ��ǧ���̤ǤΤ�ɽ������ե����� ***/
}else{

    // ���ܥ�����������ѹ����̡ˤΥ����å�ID���������
    $sql  = "SELECT \n";
    $sql .= "   t_staff.staff_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_attach \n";
    $sql .= "   INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_staff.charge_cd = '$charge_cd' \n";
    $sql .= "AND \n"; 
    $sql .= "   t_attach.shop_id = ".$_SESSION["client_id"]." \n";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $return_id = pg_fetch_result($res, 0, 0);
    }

    //���ܥ���
    $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"location.href='./2-1-108.php?staff_id=".$return_id."'\"");
    //OK�ܥ���
    $form->addElement("button", "comp_button", "�ϡ���", "onClick=\"location.href='./2-1-108.php'\"");
    //���¥��
    $form->addElement("static", "form_permit_link", "", "����");

    $form->freeze();

    $password_msg = null;
//    $permit_set_msg = "�ѹ�����ޤ���";

    // �֥���������������פξ��
    if ($_POST["form_login_info"] == "3"){
        // ���������ơ��֥��ɽ������ˤ���
        $clear_login_form["form_login_id"]  = "";
        $clear_login_form["form_password1"] = "";
        $clear_login_form["form_password2"] = "";
        $permit_set_msg                     = "������ޤ���";
        $form->setConstants($clear_login_form);
    // ����Ͽ/�ѹ�����פξ��
    }elseif ($_POST["form_login_info"] == "2"){
        if ($permit_set_msg == "�ѹ��������Ǥ��ޤ���"){
            $permit_set_msg = "�ѹ����ޤ���"; 
        }elseif ($permit_set_msg == "�����"){
            $permit_set_msg = "�����"; 
        }else{  
            $permit_set_msg = "��Ͽ���ޤ���"; 
        }       
    // ����Ͽ/�ѹ����ʤ��פξ��
    }elseif ($_POST["form_login_info"] == "1"){
        if ($staff_id == null){
            $clear_login_form["form_login_id"]  = "";
            $clear_login_form["form_password1"] = "";
            $clear_login_form["form_password2"] = "";
            $form->setConstants($clear_login_form);
        }else{  
            $sql = "SELECT staff_id FROM t_permit WHERE staff_id = $staff_id;";
            $res = Db_Query($db_con, $sql);
            if (pg_num_rows($res) == 0){
                $clear_login_form["form_login_id"]  = "";
                $clear_login_form["form_password1"] = "";
                $clear_login_form["form_password2"] = "";
                $permit_set_msg = ""; 
                $form->setConstants($clear_login_form);
            }else{
                $sql = "SELECT login_id FROM t_login WHERE staff_id = $staff_id;";
                $res = Db_Query($db_con, $sql);
                $set_login_form["form_login_id"]  = pg_fetch_result($res, 0);
                $set_login_form["form_password1"] = "";
                $set_login_form["form_password2"] = "";
                $form->setConstants($set_login_form);
                $permit_set_msg = "�����";
            }       
        }       
    }

}

function Create_Ware_Staff($ary){

    $charge_cd  = $ary[0];  //ô���ԥ�����
    $staff_name = $ary[1];  //ô����̾
    $attach_id  = $ary[2];  //FC����å�ID  �������ϥ��å�����ID�򤷤褦
    $staff_id   = $ary[3];  //��Ͽ���������å�ID
    $conn       = $ary[4];  //DB���ͥ������
    $ware_id    = $ary[5];  //�Ҹ�ID

    //�ѹ�
    //�Ҹ�ID��������
    if($ware_id != null){
        //�ҸˤΥǡ����򹹿�
        $sql  = "UPDATE \n";
        $sql .= "   t_ware \n";
        $sql .= "SET \n";
        $sql .= "   ware_cd   = '$charge_cd',  \n";
        $sql .= "   ware_name = '$staff_name' \n";
        $sql .= "WHERE \n";
        $sql .= "   ware_id = $ware_id \n";
        $sql .= ";";
    //������Ͽ
    //�Ҹ�ID��̵�����
    }else{
        //�Ҹ˥ޥ����˥����å�̾�Ҹˤ����
        $sql  = "INSERT INTO t_ware (";
        $sql .= "   ware_id,\n";
        $sql .= "   ware_cd, \n";
        $sql .= "   ware_name,\n";
        $sql .= "   count_flg, \n";
        $sql .= "   nondisp_flg, \n";
        $sql .= "   shop_id, \n";
        $sql .= "   staff_ware_flg \n";
        $sql .= ")VALUES(\n";
        $sql .= "   (SELECT COALESCE(MAX(ware_id),0)+1 FROM t_ware),\n";
        $sql .= "   '$charge_cd',\n";
        $sql .= "   '$staff_name',\n";
        $sql .= "   'f',\n";
        $sql .= "   'f',\n";
        $sql .= "   $attach_id,\n";
        $sql .= "   't' \n";
        $sql .= ");\n";
    }

    $result = Db_Query($conn, $sql);
    if($result === false){
        Db_Query($conn, "ROLLBACk;");
    }

    //��Ͽ����Ҹ�ID�����
    $sql  = "SELECT \n";
    $sql .= "   t_ware.ware_id \n";
    $sql .= "FROM \n";
    $sql .= "   t_ware \n";
    $sql .= "WHERE \n";
    $sql .= "   t_ware.ware_cd = '$charge_cd'\n";
    $sql .= "   AND \n";
    $sql .= "   t_ware.shop_id = $attach_id \n";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $add_ware_id = pg_fetch_result($result, 0, 0);

    return $add_ware_id;
}

/******************************/
//�إå�����ɽ�������������
/*****************************/
/** �����åեޥ�������SQL���� **/
$sql  = "SELECT ";
$sql .= "    count(staff_id) ";                    //�����å�ID
$sql .= "FROM ";
$sql .= "    t_attach ";
$sql .= "WHERE ";
$sql .= "    shop_id = $client_id ";
$res = Db_Query($db_con,$sql.";");
//���������(�إå���)
$total_count_h = pg_fetch_result($res,0,0);

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
$page_menu = Create_Menu_f('system','1');
/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count_h."��)";
if ($_SESSION["group_kind"] != "2"){
    $page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
    $page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
}
$page_header = Create_Header($page_title);

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
$smarty->assign("var", array(
    'html_header'               => "$html_header",
    'page_menu'                 => "$page_menu",
    'page_header'               => "$page_header",
    'html_footer'               => "$html_footer",
    'password_msg'              => "$password_msg",
    'login_info_msg'            => "$login_info_msg",
    'login_msg'                 => "$login_msg",
    'staff_id'                  => "$staff_id",
    'staff_id'                  => "$staff_id",
    'change_flg'                => "$change_flg",
    'back_id'                   => "$back_id",
    'next_id'                   => "$next_id",
    'freeze_flg'                => "$freeze_flg",
    'permit_set_msg'            => "$permit_set_msg",
    'staff_del_restrict_msg'    => "$staff_del_restrict_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
