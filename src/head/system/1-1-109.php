<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/16) ��°�ޥ������ɲá������������ɲ�(suzuki-t)
 * 1.1.0 (2006/03/21) ��Ͽ��������(suzuki-t)
 *
 * @author      suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version     1.1.0 (2006/03/21)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/25      21-039      ��          �����å�̾�˥��ڡ����Τߤ���Ͽ����ǽ�ʥХ�����
 *  2006-12-08      ban_0091    suzuki      ������˥��˻Ĥ��褦�˽���
 *  2007-01-23      �����ѹ�    watanabe-k  �ܥ���ο����ѹ�
 *  2007-02-07                  watanabe-k  �����åեޥ�����Ͽ����ô���Ҹˤ���Ͽ����������ɲ�
 *  2007-02-09                  ��          ����ˤ���ѹ��ԲĤΥ����åդξ��ϥե꡼��������������ɲ�
 *  2007-02-19                  watanabe-k  ��Ź����������Ͽ����褦�˽���
 *  2007-02-27                  watanabe-k  FC¦������ѹ�����Ĥ���Ȥ��������å��ܥå�������
 *  2007-03-29                  fukuda      �إå���ʬ�˽��Ϥ��Ƥ������������åդ��ޤޤ�Ƥ������ὤ��
 *  2007/06/25                  fukuda      ô���ԥ����ɤ�ʸ��������Ϥ���ȥ����å������Υ����ꥨ�顼��ȯ�������Զ��ν���
 *  2007/06/26      B0702-065   kajioka-h   ���ء����إܥ���Υ����Ȥ������Ȱۤʤ�Х�����
 *  2007/09/03      0709��礻3 kajioka-h   �����åպ������DB�λ������������顼��Фʤ��褦�˴ؿ��Ȥ�ʤ��褦�ѹ�
 *   2016/01/20                amano  Dialogue_2 �ؿ�ǥܥ���̾�������ʤ� IE11 �Х��б�    
 */

/****************************/
// �ڡ�����������
/****************************/
$page_title = "�����åեޥ���";

// �Ķ�����ե�����
require_once("ENV_local.php");

// HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
// ����ѥ�᡼������
/****************************/
// GET
$staff_id       = $_GET["staff_id"];                // �����å�ID


// SESSION
$client_id      = $_SESSION["client_id"];           // ����å�ID
$ss_staff_id    = $_SESSION["staff_id"];            // �����å�ID�ʼ�ʬ��
$group_kind     = $_SESSION["group_kind"];

/* GET����ID�������������å� */
if ($staff_id != null && !ereg("^[0-9]+$", $staff_id)){
    header("Location: ../top.php");
    exit;   
}
if ($staff_id != null && Get_Id_Check_Db($db_con, $staff_id, "staff_id", "t_staff", "num") != true){
    header("Location: ../top.php");
    exit;   
}

if ($staff_id != null){
    $set_id["hdn_staff_id"] = $staff_id;
    $form->setConstants($set_id);
}
if ($_POST["hdn_staff_id"] != null){
    $staff_id = $_POST["hdn_staff_id"];
}


/****************************/
// ��������
/****************************/
// ����/�ѹ�������̻�
if ($_POST == null){
    $_SESSION["109_permit"]         = null;
    $_SESSION["109_permit_delete"]  = null;
    $_SESSION["109_permit_accept"]  = null;
}


// ������Ͽ��
if ($_POST == null){

    $ary_mod_data = Permit_Item();

    // ����ʬ���¥����å��ܥå�����SESSION�����
    $ary_h_mod_data = $ary_mod_data[0];
    // ��˥塼��
    $ary_h[0] = count($ary_h_mod_data);
    for ($i = 0; $i < $ary_h[0]; $i++){
        // �ƥ�˥塼��Υ��֥�˥塼��
        $ary_h[1][$i] = count($ary_h_mod_data[$i][1]);
        for ($j = 0; $j < $ary_h[1][$i]; $j++){
            // �ƥ��֥�˥塼��Υ����å��ܥå�����
            $ary_h[2][$i][$j] = count($ary_h_mod_data[$i][1][$j][1]);
        }
    }
    $ary_opt = array("r", "w", "n");
    for ($i=0; $i<=$ary_h[0]; $i++){
        for ($j=0; $j<=$ary_h[1][$i-1]; $j++){
            for ($k=0; $k<=$ary_h[2][$i-1][$j-1]; $k++){
                for ($l=0; $l<count($ary_opt); $l++){
                    $_SESSION["109_permit"]["h"][$i][$j][$k][$ary_opt[$l]] = "";
                }
            }
        }
    }

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
                    $_SESSION["109_permit"]["f"][$i][$j][$k][$ary_opt[$l]] = "";
                }
            }
        }
    }

    // �������ǧ���¥����å��ܥå�����SESSION����
    $_SESSION["109_permit_delete"] = "";
    $_SESSION["109_permit_accept"] = "";

}

// ������Ͽ�������¥ڡ���������ܥ��󤬲�������Ƥ�������ܥ��󤬲�������Ƥ��ʤ����
if ($_POST["set_permit_flg"] != null && $_POST["permit_rtn_flg"] != "true"){

    // POST���줿���¾����SESSION�˥��å�
    foreach ($_SESSION["109_permit"] as $key_a => $value_a){
        foreach ($value_a as $key_b => $value_b){
            foreach ($value_b as $key_c => $value_c){
                foreach ($value_c as $key_d => $value_d){
                    foreach ($value_d as $key_e => $value_e){
                        $_SESSION["109_permit"][$key_a][$key_b][$key_c][$key_d][$key_e] = 
                        ($_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] != null) ?
                        $_POST["permit"][$key_a][$key_b][$key_c][$key_d][$key_e] : "";
                    }
                }
            }
        }
    }
    $_SESSION["109_permit_delete"]  = ($_POST["permit_delete"] != null) ? $_POST["permit_delete"] : "";
    $_SESSION["109_permit_accept"]  = ($_POST["permit_accept"] != null) ? $_POST["permit_accept"] : "";

}

// ������Ͽ�������¥ڡ��������ܥ��󤬲������줿���
if ($_POST["permit_rtn_flg"] == "true"){

    // SESSION�˥��åȤ��Ƥ��븢�¾����POST�˥��å�
    $_POST["permit"]        = $set_permit["permit"]         = $_SESSION["109_permit"];
    $_POST["permit_delete"] = $set_permit["permit_delete"]  = $_SESSION["109_permit_delete"];
    $_POST["permit_accept"] = $set_permit["permit_accept"]  = $_SESSION["109_permit_accept"];
    $form->setConstants($set_permit);

    // ���¥ڡ��������ܥ���ե饰�򥯥ꥢ
    $clear["permit_rtn_flg"] = "";
    $form->setConstants($clear);

}


/****************************/
// �������
/****************************/
/* �����ѹ��Բ�ǽ�ե饰���ǧ */
if ($staff_id != null){
    $sql = "SELECT h_change_flg FROM t_staff WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $h_change_ng_flg = (pg_fetch_result($res, 0) == "t") ? true : false;
}

/* ��°��Ϣ��å����� */
// �����褬���ꤵ��Ƥ��ʤ���Х�å���������
if (($_POST["form_staff_kind"] == null || $_POST["form_staff_kind"] == "0") && $staff_id == null){
    $warning1 = "�����åռ��̤����򤷤Ʋ�������";
}else{
    $warning1 = null;
}

// ����å�̾�����ꤵ��Ƥ��ʤ���Х�å���������
if ($_POST["form_cshop"] == null && $staff_id == null && $_POST["form_staff_kind"] != 3){
    $warning2 = "����å�̾�����򤷤Ʋ�������";
}else{
    $warning2 = null;
}

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
        $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "���ꤷ�ޤ���" : null;
    }
// �����åտ�����Ͽ��
}else{
    $permit_set_msg = ($_POST["set_permit_flg"] != null) ? "���ꤷ�ޤ���" : null;
}
$cons_data["permit_set_msg"] = "$permit_set_msg";
$form->setConstants($cons_data);

/****************************/
// �ե�����ǥե����������
/****************************/
// ��Ͽ���ѹ�Ƚ��
if ($staff_id != null && $_POST["first_time"] == false){

    // ���������åեǡ�������
    $sql  = "SELECT ";
    $sql .= "    staff_cd1, ";                      // �ͥåȥ����ID��
    $sql .= "    staff_cd2, ";                      // �ͥåȥ����ID��
    $sql .= "    charge_cd,";                       // ô���ԥ�����
    $sql .= "    staff_name, ";                     // �����å�̾
    $sql .= "    staff_read, ";                     // �����å�̾(�եꥬ��)
    $sql .= "    staff_ascii, ";                    // �����å�̾(���޻�)
    $sql .= "    sex, ";                            // ����
    $sql .= "    birth_day, ";                      // ��ǯ����
    $sql .= "    state, ";                          // �߿�����
    $sql .= "    join_day, ";                       // ����ǯ����
    $sql .= "    retire_day, ";                     // �࿦��
    $sql .= "    employ_type , ";                   // ���ѷ���
    $sql .= "    position, ";                       // ��
    $sql .= "    job_type, ";                       // ����
    $sql .= "    study, ";                          // ��������
    $sql .= "    toilet_license, ";                 // �ȥ�����ǻλ��
    $sql .= "    license, ";                        // �������
    $sql .= "    note, ";                           // ����
    $sql .= "    photo,";                           // �̿��ʥե�����̾��
    $sql .= "    change_flg, ";                     // �ѹ��Բ�ǽ�ե饰
    $sql .= "    t_login.login_id, ";               // ������ID
    $sql .= "    t_attach.shop_id, ";
    $sql .= "    t_staff.round_staff_flg ";
    $sql .= "FROM ";
    $sql .= "    t_staff ";
    $sql .= "        LEFT JOIN t_login ON t_staff.staff_id = t_login.staff_id ";
    $sql .= "        LEFT JOIN t_attach ON t_staff.staff_id = t_attach.staff_id ";
    $sql .= "WHERE ";
    $sql .= "    t_staff.staff_id = $staff_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);

    // GET�ǡ���Ƚ��������Ǥ����TOP�����ܡ�
    Get_Id_Check($res);
    $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);

    // �ե�������ͤ�����
    $def_fdata["form_change_flg"]           = ($data_list["change_flg"] == "t") ?  true : false;
    $def_fdata["form_staff_cd"]["cd1"]      = $data_list["staff_cd1"];
    $def_fdata["form_staff_cd"]["cd2"]      = $data_list["staff_cd2"];
    $def_fdata["form_staff_name"]           = $data_list["staff_name"]; 
    $def_fdata["form_staff_read"]           = $data_list["staff_read"]; 
    $def_fdata["form_staff_ascii"]          = $data_list["staff_ascii"];
    $def_fdata["form_sex"]                  = $data_list["sex"];
    $def_fdata["form_birth_day"]["y"]       = substr($data_list["birth_day"], 0, 4);
    $def_fdata["form_birth_day"]["m"]       = substr($data_list["birth_day"], 5, 2);
    $def_fdata["form_birth_day"]["d"]       = substr($data_list["birth_day"], 8, 2);
    $def_fdata["form_retire_day"]["y"]      = substr($data_list["retire_day"], 0, 4);
    $def_fdata["form_retire_day"]["m"]      = substr($data_list["retire_day"], 5, 2);
    $def_fdata["form_retire_day"]["d"]      = substr($data_list["retire_day"], 8, 2);
    $def_fdata["form_study"]                = $data_list["study"];
    $def_fdata["form_toilet_license"]       = $data_list["toilet_license"];
    $def_fdata["form_photo"]                = $data_list["photo"];
    $def_fdata["form_photo_del"]            ="1";

    $def_fdata["form_charge_cd"]            = str_pad($data_list["charge_cd"], 4, 0, STR_POS_LEFT); 
    $def_fdata["form_join_day"]["y"]        = substr($data_list["join_day"], 0, 4);
    $def_fdata["form_join_day"]["m"]        = substr($data_list["join_day"], 5, 2);
    $def_fdata["form_join_day"]["d"]        = substr($data_list["join_day"], 8, 2);
    $def_fdata["form_employ_type"]          = $data_list["employ_type"]; 
    $def_fdata["form_position"]             = $data_list["position"];
    $def_fdata["form_state"]                = $data_list["state"];
    $def_fdata["form_job_type"]             = $data_list["job_type"]; 
    $def_fdata["form_note"]                 = $data_list["note"];
    $def_fdata["form_license"]              = $data_list["license"];
    $def_fdata["form_round_staff"]          = ($data_list["round_staff_flg"] == "t") ? true : false;

    $def_fdata["form_login_id"]             = $data_list["login_id"];

    // ���ء����إܥ���Υ��������
    //$id_data = Make_Get_Id($db_con, "staff", $data_list["charge_cd"]);
    $id_data = Make_Get_Id($db_con, "staff", $staff_id);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

    // ��°�ޥ��������ѹ��������
    $sql  = "SELECT ";
    $sql .= "    t_attach.shop_id, ";                //�����ID
    $sql .= "    t_attach.part_id, ";                //���ID
    $sql .= "    t_attach.section, ";                //��°���ʲݡ�
    $sql .= "    t_attach.ware_id, ";                //�Ҹ�ID
    $sql .= "    CASE t_rank.group_kind";           //�����åռ���
    $sql .= "        WHEN '1' THEN '3' ";
    $sql .= "        WHEN '2' THEN '2' ";
    $sql .= "        WHEN '3' THEN '1' ";
    $sql .= "    END, ";
    $sql .= "    t_part.branch_id ";
    $sql .= "FROM ";
    $sql .= "    t_attach "; 
    $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd  ";
    $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
    $sql .= "    LEFT JOIN t_part ON t_attach.part_id = t_part.part_id ";
    $sql .= "WHERE ";
    $sql .= "    t_attach.staff_id = $staff_id ";
    $res  = Db_Query($db_con, $sql.";");

    $data_num = pg_num_rows($res);

    // ����ľ��($data_num == 2)�ξ��ϡ���ﳺ�������
    if ($data_num == 2){

        // ����
        $head_sql  = "SELECT ";
        $head_sql .= "    t_client.client_id, ";             // ����ID
        $head_sql .= "    t_client.client_name, ";           // ����̾
        $head_sql .= "    t_attach.part_id, ";               // ���ID
        $head_sql .= "    t_attach.section, ";               // ��°���
        $head_sql .= "    t_attach.ware_id  ";              // �Ҹ�ID
        $head_sql .= "FROM ";
        $head_sql .= "    t_attach "; 
        $head_sql .= "      INNER JOIN \n";
        $head_sql .= "    t_client \n";
        $head_sql .= "    ON t_attach.shop_id = t_client.client_id ";
        $head_sql .= "WHERE ";
        $head_sql .= "    t_attach.staff_id = $staff_id ";
        $head_sql .= "AND ";
        $head_sql .= "    t_client.client_div = '0' ";
        $head_sql .= "AND ";
        $head_sql .= "    h_staff_flg = 't'";

        $res       = Db_Query($db_con, $head_sql.";");
        $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);

        $def_fdata["client_id_head"]                        = $data_list["client_id"];
        $def_fdata["form_cshop_head"]                       = $data_list["client_name"];
        $def_fdata["form_part_head"]                        = $data_list["part_id"];
        $def_fdata["form_section_head"]                     = $data_list["section"];
        $def_fdata["form_ware_head"]                        = $data_list["ware_id"];

        // ľ��
        $sql  = "SELECT ";
        $sql .= "    t_attach.shop_id, ";                //�����ID
        $sql .= "    t_attach.part_id, ";                //���ID
        $sql .= "    t_attach.section, ";                //��°���ʲݡ�
        $sql .= "    t_attach.ware_id, ";                //�Ҹ�ID
        $sql .= "    CASE t_rank.group_kind";           //�����åռ���
        $sql .= "        WHEN '1' THEN '3' ";
        $sql .= "        WHEN '2' THEN '2' ";
        $sql .= "        WHEN '3' THEN '1' ";
        $sql .= "    END, ";
        $sql .= "    t_part.branch_id ";
        $sql .= "FROM ";
        $sql .= "    t_attach "; 
        $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
        $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd  ";
        $sql .= "    INNER JOIN t_staff ON t_staff.staff_id = t_attach.staff_id ";
        $sql .= "    INNER JOIN t_part ON t_attach.part_id = t_part.part_id ";
        $sql .= "WHERE ";
        $sql .= "    t_attach.staff_id = $staff_id ";
        $sql .= "    AND \n";
        $sql .= "    t_attach.h_staff_flg = 'f' \n";

        $res       = Db_Query($db_con, $sql);
        $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);
        $def_fdata["form_cshop"]                            = $data_list["shop_id"];
        $cshop_id                                           = $data_list["shop_id"];
        $def_fdata["form_section"]                          = $data_list["section"];
        $def_fdata["form_ware"]                             = $data_list["ware_id"];
        $def_fdata["form_part"][0]                          = $data_list["branch_id"];
        $def_fdata["form_part"][1]                          = $data_list["part_id"];
        $def_fdata["form_staff_kind"]                       = "4";
        $cshop_head_flg                                     = "true";           // ����������ɽ���ե饰

    }else{

        // FC��ľ��
        $data_list = pg_fetch_array($res, 0, PGSQL_ASSOC);
        $def_fdata["form_cshop"]                            = $data_list["shop_id"];
        $cshop_id                                           = $data_list["shop_id"];
//        $def_fdata["form_part"]                             = $data_list["part_id"];
        $def_fdata["form_section"]                          = $data_list["section"];
        $def_fdata["form_ware"]                             = $data_list["ware_id"];
        $def_fdata["form_part"][0]                          = $data_list["branch_id"];
        $def_fdata["form_part"][1]                          = $data_list["part_id"];
        $staff_kind                                         = $data_list["case"];

        // ����
        $head_sql  = "SELECT ";
        $head_sql .= "    t_client.client_id, ";             // ����ID
        $head_sql .= "    t_client.client_name, ";           // ����̾
        $head_sql .= "    t_attach.part_id, ";               // ���ID
        $head_sql .= "    t_attach.section, ";               // ��°���
        $head_sql .= "    t_attach.ware_id  ";               // �Ҹ�ID
        $head_sql .= "FROM ";
        $head_sql .= "    t_attach "; 
        $head_sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
        $head_sql .= "WHERE ";
        $head_sql .= "    t_attach.staff_id = $staff_id ";
        $head_sql .= "AND ";
        $head_sql .= "    t_client.client_div = '0' ";
        $head_sql .= "AND ";
        $head_sql .= "    h_staff_flg = 't';";
        $res       = Db_Query($db_con, $head_sql);
        $data_num  = pg_num_rows($res);
        if ($data_num != 0){
            $data_list = pg_fetch_array($res, 0);
            $def_fdata["client_id_head"]                    = $data_list["clietn_id"];
            $def_fdata["form_cshop_head"]                   = $data_list["client_name"];
            $def_fdata["form_part_head"]                    = $data_list["part_id"];
            $def_fdata["form_section_head"]                 = $data_list["section"];
            $def_fdata["form_ware_head"]                    = $data_list["ware_id"];
            //����������ɽ���ե饰(����å�̾���̵��)
            $only_head_flg                                  = "true";
        }
        $def_fdata["form_staff_kind"]                       = $staff_kind;
    }

    //�ѹ��ν��ɽ�������ϡ����ֺǽ���������Ԥ�ʤ��褦�ˤ���
    $def_fdata["first_time"]                                = true;

}else{

    $def_fdata = array(
        "form_sex"              => "1",
        "form_state"            => "�߿���",
        "form_employ_type"      => "�������å�",
        "form_job_type"         => "�Ķ�",
        "form_toilet_license"   => "3"
    );

}
$def_fdata["form_login_info"] = "1";

$form->setDefaults($def_fdata);


/****************************/
// ����Ǥ��븢�¤�Ĵ�٤�
/****************************/
// �����åռ��̤����Ϥ����뤱��0(̤����)�ǤϤʤ�
// �ޤ��ϥ�����Ǽ������Ƥ��������åռ��̤�������
if (($_POST["form_staff_kind"] != null && $_POST["form_staff_kind"] != 0 ) || $def_fdata["form_staff_kind"] != null){
    $select_staff_kind = true;
    $staff_kind_auth = ($def_fdata["form_staff_kind"] != null) ? $def_fdata["form_staff_kind"] : $_POST["form_staff_kind"];
}else{
    $select_staff_kind = false;
}

// ���򤵤줿�����åռ��̤��������ǽ�ʸ��¤�Ĵ�٤�
if ($select_kind_auth == true){

    switch ($staff_kind_auth){
        case 1:
            $auth_type = array("fc");
            break;
        case 2:
            $auth_type = array("fc");
            break;
        case 3:
            $auth_type = array("head");
            break;
        case 4:
            $auth_type = array("head", "fc");
            break;
    }

}


/****************************/
// �ե�����ѡ������
/****************************/
// �����åռ���
$select_value = array(
/*
    "",
    "FC�����å�",
    "ľ�ĥ����å�",
    "������å�",
    "����ľ�ĥ����å�",
*/
    ""  => "",
    "1" => "FC�����å�",
    "4" => "����ľ�ĥ����å�",
);
//$freeze1=$form->addElement("select", "form_staff_kind", "", $select_value, "onChange=\"javascript: Button_Submit('staff_search_flg','#','true');window.focus();\"");
$freeze1=$form->addElement("select", "form_staff_kind", "", $select_value, "onChange=\"javascript: Button_Submit('staff_search_flg','#','true', this);\"");

// ����
// �����åռ��̤��������or������ľ�ġˤξ��
$form->addElement("text", "form_cshop_head", "", "size=\"34\" maxLength=\"15\" style=\"color: #585858; border: white 1px solid; background-color: white; text-align: left\" readonly");

// ����å�̾
// �����åռ��̤�������ľ�ġ�or��ľ�ġˤξ��
if ($_POST["form_staff_kind"] == 2 || $_POST["form_staff_kind"] == 4 || $staff_kind == 2 || $staff_kind == 4 || $cshop_head_flg == "true"){
    // ľ�ĤΥ���å�
//    $select_value = Select_Get($db_con, "dshop");
    $sql = "SELECT client_id, client_cd1, client_cd2, client_cname FROM t_client where client_id = 93;";
    $result = Db_Query($db_con,$sql);
    $select_value = null;
    $select_value[""] = "";
    while($data_list = pg_fetch_array($result)){
        $data_list[0] = htmlspecialchars($data_list[0]);
        $data_list[1] = htmlspecialchars($data_list[1]);
        $data_list[2] = htmlspecialchars($data_list[2]);
        $data_list[3] = htmlspecialchars($data_list[3]);
        $select_value[$data_list[0]] = $data_list[1]."-".$data_list[2]." �� ".$data_list[3];
    } 
    $group_kind = 2;
// �����åռ��̤���FC�ˤξ��
}else if ($_POST["form_staff_kind"] == 1 || $staff_kind == 1){
    // FC�Υ���å�
    $select_value = Select_Get($db_con, "fshop");
    $group_kind = null;
}else{
    // �����
    $select_value = null;
    $group_kind = null;
}
//$freeze2=$form->addElement("select", "form_cshop", "", $select_value, "onChange=\"javascript:Button_Submit('cshop_search_flg','#','true');window.focus();\"");
$freeze2=$form->addElement("select", "form_cshop", "", $select_value, "onChange=\"javascript:Button_Submit('cshop_search_flg','#','true', this);\"");

//�ѹ��ξ��˥���å״֤ǤΥ����åդΰ�ư���ԲĤȤ���
if($staff_id != null){
    $freeze1->freeze();
    $freeze2->freeze();
}

// �߿�����
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "�߿���", "�߿���");
$radio[] =& $form->createElement("radio", null, null, "�࿦", "�࿦");
$radio[] =& $form->createElement("radio", null, null, "�ٶ�", "�ٶ�");
$change_ng_freeze_radio = $form->addGroup($radio, "form_state", "�߿�");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// FC¦������ѹ�����Ĥ��ʤ�
$change_ng_freeze[] = $form->addElement("checkbox", "form_change_flg", "", "FC¦������ѹ�����Ĥ��ʤ�");

// �ͥåȥ����ID
$text = "";
$text[] =& $form->createElement("text", "cd1", "", "size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_staff_cd[cd1]','form_staff_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "cd2", "", "size=\"3\" maxLength=\"3\" style=\"$g_form_style\" ".$g_form_option."\"");
$form->addGroup($text, "form_staff_cd", "form_staff_cd");

// �����å�̾
$change_ng_freeze[] = $form->addElement("text", "form_staff_name", "", "size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

// �����å�̾(�եꥬ��)
$change_ng_freeze[] = $form->addElement("text", "form_staff_read", "", "size=\"22\" maxLength=\"20\" ".$g_form_option."\"");

// �����å�̾(���޻�)
$change_ng_freeze[] = $form->addElement("text", "form_staff_ascii", "", "size=\"22\" maxLength=\"30\" ".$g_form_option."\"");

// ����
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "��", "1");
$radio[] =& $form->createElement("radio", null, null, "��", "2");
$change_ng_freeze_radio = $form->addGroup($radio, "form_sex", "����");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// ��ǯ����    
$text="";
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_birth_day[y]','form_birth_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_birth_day[m]','form_birth_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addGroup($text, "form_birth_day", "form_birth_day");

// �࿦��
$text="";
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_retire_day[y]','form_retire_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_retire_day[m]','form_retire_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addGroup($text, "form_retire_day", "form_retire_day");

// ��������
$change_ng_freeze[] = $form->addElement("text", "form_study", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");

// �ȥ�����ǻ��
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "����ȥ�����ǻ�", "1");
$radio[] =& $form->createElement("radio", null, null, "����ȥ�����ǻ�", "2");
$radio[] =& $form->createElement("radio", null, null, "̵", "3");
$change_ng_freeze_radio = $form->addGroup($radio, "form_toilet_license", "�ȥ�����ǻ��");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// �ե�����ʾ����̿���
if ($h_change_ng_flg != true){
    $form->addElement("file", "form_photo_ref", "�����̿�", "onBlur=\"blurForm(this)\" onFocus=\"onForm(this)\"");
}

// �����̿��ե�����̾
$form->addElement("hidden", "form_photo");

// �����̿����
// ��ϿȽ��
if ($staff_id != null && $h_change_ng_flg != true){
    $radio = null;
    $radio[] =& $form->createElement("radio", null, null, "������ʤ�<br>", "1");
    $radio[] =& $form->createElement("radio", null, null, "�������", "2");
    $form->addGroup($radio, "form_photo_del", "�����̿�");
}

// ô���ԥ�����
$change_ng_freeze[] = $form->addElement("text", "form_charge_cd", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");

// ����ǯ����
$text="";
$text[] =& $form->createElement("text", "y", "", "size=\"4\" maxLength=\"4\" style=\"$g_form_style\" onkeyup=\"changeText(this.form,'form_join_day[y]','form_join_day[m]',4)\"".$g_form_option."\"");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("text", "m", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_join_day[m]','form_join_day[d]',2)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text", "d", "", "size=\"2\" maxLength=\"2\" style=\"$g_form_style\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addGroup($text, "form_join_day", "form_join_day");

// ���ѷ���
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "�������å�", "�������å�");
$radio[] =& $form->createElement("radio", null, null, "�ѡ���", "�ѡ���");
$radio[] =& $form->createElement("radio", null, null, "����Х���", "����Х���");
$radio[] =& $form->createElement("radio", null, null, "����", "����");
$radio[] =& $form->createElement("radio", null, null, "����", "����");
$radio[] =& $form->createElement("radio", null, null, "����¾", "����¾");
$change_ng_freeze_radio = $form->addGroup($radio, "form_employ_type", "���ѷ���");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// ����
$radio = null;
$radio[] =& $form->createElement("radio", null, null, "�Ķ�", "�Ķ�");
$radio[] =& $form->createElement("radio", null, null, "�����ӥ�", "�����ӥ�");
$radio[] =& $form->createElement("radio", null, null, "��̳", "��̳");
$radio[] =& $form->createElement("radio", null, null, "����¾", "����¾");
$change_ng_freeze_radio = $form->addGroup($radio, "form_job_type", "����");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

// �����������
/*
$select_value = Select_Get($db_con, "part");
$change_ng_freeze[] = $form->addElement("select", "form_part_head", "", $select_value, $g_form_option_select);
*/

// ��°���(��)�������
$change_ng_freeze[] = $form->addElement("text", "form_section_head", "", "size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

// ��°���(��)
$change_ng_freeze[] = $form->addElement("text", "form_section", "", "size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

// ��
$change_ng_freeze[] = $form->addElement("text", "form_position", "", "size=\"15\" maxLength=\"7\" ".$g_form_option."\"");

// �������
$change_ng_freeze[] = $form->addElement("textarea", "form_license", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// ����
//$change_ng_freeze[] = $form->addElement("text", "form_note", "", "size=\"34\" maxLength=\"50\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addElement("textarea", "form_note", "", "rows=\"5\" cols=\"59\"".$g_form_option_area."\"");

// ���ô����
$change_ng_freeze[] = $form->addElement("checkbox", "form_round_staff", "", "");

// ���������ΰ���
$radio = null;
$radio[] =& $form->createElement("radio", null, null, $login_info_type."���ʤ�", "1");
$radio[] =& $form->createElement("radio", null, null, $login_info_type."����", "2");
if ($login_info_type == "�ѹ�"){$radio[] =& $form->createElement("radio", null, null, "�������", "3");}
$change_ng_freeze_radio = $form->addGroup($radio, "form_login_info", "���������ΰ���");
($h_change_ng_flg == true) ? $change_ng_freeze_radio->freeze() : null;

//������ID
$change_ng_freeze[] = $form->addElement("text", "form_login_id", "", "size=\"24\" maxLength=\"20\" style=\"$g_form_style\" ".$g_form_option."\"");

//�ѥ���ɡ��ѥ���ɡʳ�ǧ��
$change_ng_freeze[] = $form->addElement("password", "form_password1", "", "size=\"24\" maxLength=\"20\" ".$g_form_option."\"");
$change_ng_freeze[] = $form->addElement("password", "form_password2", "", "size=\"24\" maxLength=\"20\" ".$g_form_option."\"");

//��Ͽ���̥ܥ���ʥإå����
//$form->addElement("button", "new_button", "��Ͽ����", "style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button", "new_button", "��Ͽ����",$g_button_color."  onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//�ѹ��������ܥ���ʥإå����
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:Referer('1-1-107.php')\"");


// �����åռ��̤��������or������ľ�ġˤξ��
if ($_POST["form_staff_kind"] == 3 || $_POST["form_staff_kind"] == 4 || $cshop_head_flg == "true" || $only_head_flg == "true"){
    // ����ID����
    $sql  = "SELECT ";
    $sql .= "    client_id, ";
    $sql .= "    client_name ";
    $sql .= "FROM ";
    $sql .= "    t_client ";
    $sql .= "WHERE ";
    $sql .= "    client_div = '0' ";
    $aql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    // �����ǡ���ͭ
    if ($num == 1){
        $data_list = pg_fetch_array($res, 0);
        $head_data["client_id_head"]  = $data_list[0];
        $head_data["form_cshop_head"] = $data_list[1];
    }
    // �����
    $head_data["staff_search_flg"] = "";
    $form->setConstants($head_data);
}

// ô���Ҹˡ������
$where  = "WHERE shop_id = $client_id";
$where .= " AND nondisp_flg = 'f'";
$select_value = Select_Get($db_con, "ware", $where);
$change_ng_freeze[] = $form->addElement("select", "form_ware_head", "", $select_value, $g_form_option_select);

// �ƣá�ľ�Ĥν�°���롼�׼���
if ($_POST["form_cshop"] != null || $staff_kind == 1 || $staff_kind == 2 || $cshop_head_flg == "true"){
    if ($_POST["form_cshop"] != null){
        $cshop_id = $_POST["form_cshop"];
    }
    
    // �����
    $fc_data["cshop_search_flg"] = "";
    $form->setConstants($fc_data);
}

// ��°���
$obj_bank_select =& $form->addElement("hierselect", "form_part", "", "");
/*
if ($cshop_id != null){
    $where  = "WHERE ";
    $where .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql("0003").") " : " shop_id = $cshop_id ";
    $select_value = Select_Get($db_con, "part", $where);
}else{
    // �����
    $select_value = null;
}
$change_ng_freeze[] = $form->addElement("select", "form_part", "", $select_value, $g_form_option_select);
*/
$cshop_id;
if($cshop_id != null){
    $obj_bank_select->setOptions(Make_Ary_Branch($db_con, $cshop_id));
}else{
    $obj_bank_select->setOptions(null);
}


// ô���Ҹ�
// ô���Ҹˤϲ��̤ˤ�ɽ�����ʤ����ᡢhidden���ͤ�����ޤ��
/*
if ($cshop_id != null){
//    $where  = "WHERE shop_id = $cshop_id ";
    $where  = "WHERE ";
    $where .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql("0003").") " : " shop_id = $cshop_id ";
    $where .= "AND nondisp_flg = 'f'";
    // �����
    $select_value = null;
    $select_value = Select_Get($db_con, "ware", $where);
}else{
    // �����
    $select_value = null;
}
$form->addElement("select", "form_ware", "", $select_value, $g_form_option_select);
*/
$form->addElement("hidden", "form_ware");


/*** hidden�ե����� ***/
// �����åռ��̥ե饰
$form->addElement("hidden", "staff_search_flg");
// ����å�̾�ե饰
$form->addElement("hidden", "cshop_search_flg");
// ����ID
$form->addElement("hidden", "client_id_head");
// ���ɽ���ե饰
$form->addElement("hidden", "first_time");
// ����̤���ꥨ�顼�������ѥե�����
$form->addElement("text", "permit_error");
// ��������ѥե饰
$form->addElement("hidden", "set_permit_flg");
// �����å�ID
$form->addElement("hidden", "hdn_staff_id");


/****************************/
// �ե�����ѡ������ - ����
/****************************/
/*** ��������å��ܥå������ǤθĿ����� ***/
$ary_mod_data = Permit_Item();

$ary_h_mod_data = $ary_mod_data[0];

// ��˥塼��
$ary_h[0] = count($ary_h_mod_data);
for ($i = 0; $i < $ary_h[0]; $i++){
    // �ƥ�˥塼��Υ��֥�˥塼��
    $ary_h[1][$i] = count($ary_h_mod_data[$i][1]);
    for ($j = 0; $j < $ary_h[1][$i]; $j++){
        // �ƥ��֥�˥塼��Υ����å��ܥå�����
        $ary_h[2][$i][$j] = count($ary_h_mod_data[$i][1][$j][1]);
    }
}

$ary_opt = array("r", "w", "n");
for ($i=0; $i<=$ary_h[0]; $i++){
    for ($j=0; $j<=$ary_h[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_h[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[h][$i][$j][$k][$ary_opt[$l]]";
                $form->addElement("hidden", $me, "");
            }
        }
    }
}

/*** FC�����å��ܥå������ǤθĿ����� ***/
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
    //���顼�����å�(AddRule)
    /****************************/
    //����ξ��ϥ����å�̵��
    if ($_POST["form_staff_kind"] != 3){
        /*** ����å�̾ ***/
        // ɬ�ܥ����å�
        $form->addRule("form_cshop", "����å�̾�����򤷤Ʋ�������", "required");
    }

    /*** �ͥåȥ����ID ***/
    // ʸ��������å�
    $form->addGroupRule("form_staff_cd", array(
        "cd1" => array(
            array("�ͥåȥ����ID ��Ⱦ�ѿ���ΤߤǤ���", "regex", "/^[0-9]+$/")
        ),
        "cd2" => array(
            array("�ͥåȥ����ID ��Ⱦ�ѿ���ΤߤǤ���", "regex", "/^[0-9]+$/"),
        )
    ));

    /*** ô���ԥ����� ***/
    // ɬ�ܥ����å�
    $form->addRule("form_charge_cd", "ô���ԥ����� ��Ⱦ�ѿ���ΤߤǤ���", "required");
    // ʸ��������å�
    $form->addRule("form_charge_cd", "ô���ԥ����� ��Ⱦ�ѿ���ΤߤǤ���", "regex", "/^[0-9]+$/");

    /*** �����å�̾ ***/
    // ɬ�ܥ����å�
    $form->addRule("form_staff_name", "�����å�̾ ��10ʸ������Ǥ���", "required");
    // ���ڡ��������å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_staff_name", "�����å�̾�� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    /*** �����å�̾�ʥ��޻���***/
    // ɬ�ܥ����å�
    $form->addRule("form_staff_ascii", "�����å�̾(���޻�) �ϥ������������ɤΤ߻��ѲĤǤ���", "required");
    //��ʸ��������å�
    $form->addRule("form_staff_ascii", "�����å�̾(���޻�) �ϥ������������ɤΤ߻��ѲĤǤ���", "ascii");

    /*** �����̿� ***/
    // ��ĥ�ҥ����å�
    $form->addRule("form_photo_ref", "�����ʲ����ե�����Ǥ���", "mimetype", array("image/jpeg", "image/jpeg", "image/pjpeg"));

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

    /*** �࿦��***/
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
    // ʸ��������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_license", "������� ��200ʸ������Ǥ���", "mb_maxlength", "200");

    /*** ���� ***/
    // ʸ��������å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");
    $form->addRule("form_note", "���� ��2000ʸ������Ǥ���", "mb_maxlength", "2000");

    // ������������Ͽ/�ѹ����� �˥����å����դ��Ƥ�����
    if ($_POST["form_login_info"] == "2"){

        /*** ������ID ***/
        // ɬ�ܥ����å�
        $form->addRule("form_login_id", "������ID ��6ʸ���ʾ�20ʸ������Ǥ���", "required");
        // ʸ��������å�
        $form->addRule("form_login_id", "������ID ��6ʸ���ʾ�20ʸ������Ǥ���", "rangelength", array(6, 20));

        /*** �ѥ���� ***/
        // �����ξ��ϥѥ���ɤ�ɬ�ܤǤϤʤ�
        if ($login_info_type == "��Ͽ"){
            // ɬ�ܥ����å�
            $form->addRule("form_password1", "�ѥ���� ��6ʸ���ʾ�20ʸ������Ǥ���", "required");
        }
        // ʸ��������å�
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

    // POST����
    $cshop_id       = $_POST["form_cshop"];                 // ����å�ID
    $change_flg     = $_POST["form_change_flg"];            // �ѹ��Բ�ǽ�ե饰
    $staff_cd1      = $_POST["form_staff_cd"]["cd1"];       // �ͥåȥ����ID1
    $staff_cd2      = $_POST["form_staff_cd"]["cd2"];       // �ͥåȥ����ID2
    $staff_name     = $_POST["form_staff_name"];            // �����å�̾
    $charge_cd      = $_POST["form_charge_cd"];             // ô���ԥ�����
    $staff_name     = $_POST["form_staff_name"];            // �����å�̾
    $staff_read     = $_POST["form_staff_read"];            // �����å�̾(�եꥬ��)
    $staff_ascii    = $_POST["form_staff_ascii"];           // �����å�̾(���޻�)
    $sex            = $_POST["form_sex"];                   // ����
    $birth_day_y    = $_POST["form_birth_day"]["y"];        // ��ǯ����
    $birth_day_m    = $_POST["form_birth_day"]["m"]; 
    $birth_day_d    = $_POST["form_birth_day"]["d"];
    $state          = $_POST["form_state"];                 // �߿�����
    $join_day_y     = $_POST["form_join_day"]["y"];         // ����ǯ����
    $join_day_m     = $_POST["form_join_day"]["m"];     
    $join_day_d     = $_POST["form_join_day"]["d"];
    $retire_day_y   = $_POST["form_retire_day"]["y"];       // �࿦��
    $retire_day_m   = $_POST["form_retire_day"]["m"];    
    $retire_day_d   = $_POST["form_retire_day"]["d"];
    $employ_type    = $_POST["form_employ_type"];           // ���ѷ���
    $part_id        = $_POST["form_part"][1];               // ���ID
    $section        = $_POST["form_section"];               // ��°���ʲݡ�
    $position       = $_POST["form_position"];              // ��
    $job_type       = $_POST["form_job_type"];              // ����
    $ware_id_head   = $_POST["form_ware_head"];             // ô���Ҹ�ID (����)
    $study          = $_POST["form_study"];                 // ��������
    $toilet_license = $_POST["form_toilet_license"];        // �ȥ�����ǻλ��
    $license        = $_POST["form_license"];               // �������
    $note           = $_POST["form_note"];                  // ����
    $ware_id        = $_POST["form_ware"];                  // ô���Ҹ�ID
    $photo_del      = $_POST["form_photo_del"];             // �̿�����ե饰
    $photo          = $_POST["form_photo"];                 // �̿��ե�����̾
    $login_info     = $_POST["form_login_info"];            // ���������ΰ���
    $login_id       = $_POST["form_login_id"];              // ������ID
    $password1      = $_POST["form_password1"];             // �ѥ����
    $password2      = $_POST["form_password2"];             // �ѥ���ɳ�ǧ
    $round_staff    = ($_POST["form_round_staff"] == "1") ? "t" : "f";

    // �������POST����
    $client_id_head = $_POST["client_id_head"];             // ����å�ID (����)
    $part_id_head   = $_POST["form_part_head"];             // ���ID (����)
    $section_head   = $_POST["form_section_head"];          // ��°���(��) (����)

    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    /*** �ͥåȥ����ID ***/
    // ��ʣ�����å�
    if ($staff_cd1 != null && $staff_cd2 != null){

        // �ͥåȥ����ID0���
        $staff_cd1 = str_pad($staff_cd1, 6, 0, STR_POS_LEFT);
        $staff_cd2 = str_pad($staff_cd2, 3, 0, STR_POS_LEFT);

        //���Ϥ��줿�ͥåȥ����ID���ޥ�����¸�ߤ��뤫�����å�
        $sql  = "SELECT ";
        $sql .= "   staff_cd1, ";
        $sql .= "   staff_cd2 ";
        $sql .= "FROM ";
        $sql .= "   t_staff ";
        $sql .= "WHERE ";
        $sql .= "   staff_cd1 = '$staff_cd1' ";
        $sql .= "AND ";
        $sql .= "   staff_cd2 = '$staff_cd2' ";
        //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if ($staff_id != null){
            $sql .= "AND NOT ";
            $sql .= "   staff_id = '$staff_id' ";
        }
        $sql .= ";";
        $res  = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($res);
        if ($row_count != 0){
            $form->setElementError("form_staff_cd", "���˻��Ѥ���Ƥ��� �ͥåȥ����ID �Ǥ���");
        }

    }

    // ��¦�Τߤ����Ϥϥ��顼
    if ($staff_cd1 != null || $staff_cd2 != null){
        if ($staff_cd1 == null || $staff_cd2 == null){
            $form->setElementError("form_staff_cd", "�ͥåȥ����ID ��Ⱦ�ѿ���ΤߤǤ���");
        }
    }

    /*** ô���ԥ����� ***/
    // ��ʣ�����å�
//    if ($charge_cd != null && $cshop_id != null){
    if ($charge_cd != null && ereg("^[0-9]+$", $charge_cd)){

        //FC�Υ���åפν�ʣ�����å�
        if ($_POST["form_staff_kind"] == 1 && $cshop_id != null){

            //ô���ԥ�����0���
            $charge_cd = str_pad($charge_cd, 4, 0, STR_POS_LEFT);

            //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = $charge_cd ";
            $sql .= "AND ";
            $sql .= "    t_attach.shop_id = $cshop_id ";
            
            //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "   t_attach.staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_charge_cd", "���˻��Ѥ���Ƥ��� ô���ԥ����� �Ǥ���");
            }

        }
        //ľ�ĤΥ���åפν�ʣ�����å�
        if (($_POST["form_staff_kind"] == 2 || $_POST["form_staff_kind"] == 4) && $cshop_id != null){

            //ô���ԥ�����0���
            $charge_cd = str_pad($charge_cd, 4, 0, STR_POS_LEFT);

            //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "    INNER JOIN t_client ON t_attach.shop_id = t_client.client_id ";
            $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = $charge_cd ";
            $sql .= "AND ";
            $sql .= "    t_rank.rank_cd = (";
            $sql .= "                     SELECT ";
            $sql .= "                         rank_cd ";
            $sql .= "                     FROM ";
            $sql .= "                         t_client ";
            $sql .= "                     WHERE ";
            $sql .= "                         client_id = $cshop_id ";
            $sql .= "                     ) ";
            
            //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "   t_attach.staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_charge_cd", "���˻��Ѥ���Ƥ��� ô���ԥ����� �Ǥ���");
            }

        }

        // ����롼�פǤ�ô���ԥ����ɤν�ʣ�����å�
        if (($_POST["form_staff_kind"] == 3 || $_POST["form_staff_kind"] == 4)  && $cshop_id == null){

            //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "    t_staff.charge_cd ";
            $sql .= "FROM ";
            $sql .= "    t_attach ";
            $sql .= "    INNER JOIN t_staff ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = '$charge_cd' ";
            $sql .= "AND ";
            $sql .= "    t_attach.shop_id = $client_id_head ";

            //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
            if ($staff_id != null){
                $sql .= " AND NOT ";
                $sql .= "t_attach.staff_id = '$staff_id'";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_charge_cd", "���˻��Ѥ���Ƥ��� ô���ԥ����� �Ǥ���");
            }

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
            $form->setElementError("form_birth_day", "��ǯ���� �������ǤϤ���ޤ���");
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
            $form->setElementError("form_join_day", "����ǯ���� �������ǤϤ���ޤ���");
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
            $form->setElementError("form_retire_day", "�࿦�� �������ǤϤ���ޤ���");
        }
    }else{
        $retire_day = "null";
    }

    // �����������Ͽ���ѹ��˥����å����դ��Ƥ�����
    if ($_POST["form_login_info"] == "2"){

        /*** ������ID ***/
        // ʸ��������å�
        if (!ereg("^[0-9a-zA-Z_-]+$", $login_id) && $login_id != null){
            $form->setElementError("form_login_id", "������ID ��Ⱦ�ѱѿ�����ϥ��ե󡢥�������С��Τ߻��ѲĤǤ���");
        }

        // ��ʣ�����å�
        if ($login_id != null){
            // ���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
            $sql  = "SELECT ";
            $sql .= "   login_id ";
            $sql .= "FROM ";
            $sql .= "   t_login ";
            $sql .= "WHERE ";
            $sql .= "   login_id = '$login_id' ";
            // �ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
            if ($staff_id != null){
                $sql .= "AND NOT ";
                $sql .= "   staff_id = '$staff_id' ";
            }
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $row_count = pg_num_rows($res);
            if ($row_count != 0){
                $form->setElementError("form_login_id", "���˻��Ѥ���Ƥ��� ������ID �Ǥ���");
            }
        }

        /*** �ѥ���ɡ��ѥ���ɳ�ǧ ***/
        // ʸ��������å�
        if (!ereg("^[0-9a-zA-Z_-]+$", $password1) && $password1 != null){
            $form->setElementError("form_password1", "�ѥ���� ��Ⱦ�ѱѿ�����ϥ��ե󡢥�������С��Τ߻��ѲĤǤ���");
        }
        // �ͤ���������
        if ($password1 != $password2 && $password1 != null){
            $form->setElementError("form_password1", "�ѥ���ɤȳ�ǧ�Ѥ����Ϥ��줿�ѥ���ɤ��ۤʤ�ޤ���");
        }

    }

    if($part_id == null){
        $form->setElementError("form_part","��°����ɬ�ܤǤ���");
    }

    // ���顼�κݤˤϡ���Ͽ���ѹ�������Ԥ�ʤ�
    if ($form->validate()){
        Db_Query($db_con, "BEGIN;");

        // ��Ͽ�ξ�����������Ԥʤ�
        if ($staff_id == null){
            // �����å�ID����
            // ��¾����
            Db_Query($db_con, "LOCK TABLE t_staff;");
            $sql  = "SELECT COALESCE(MAX(staff_id), 0)+1 FROM t_staff;";
            $res  = Db_Query($db_con, $sql);
            //��Ͽ���륹���å�ID
            $staff_id_get = pg_fetch_result($res, 0, 0);
            
        }else{
            $staff_id_get = $staff_id;
        }

        /****************************/
        //�����Υ��åץ��ɡ����
        /****************************/
        //������ʤ��˥����å��ܥե����뤬���ꤵ��Ƥ�Ȥ����ޤ�����Ͽ���˥ե����뤬���ꤵ��Ƥ��뤫
        if (($photo_del == 1 && $_FILES["form_photo_ref"]["tmp_name"] != null) || 
            ($staff_id == null && $_FILES["form_photo_ref"]["tmp_name"] != null)){
            // �̿��Υե�����̾����
            if ($staff_id == null){
                $photo = $staff_id_get.".jpg";
            }else{
                // �ѹ�����
                $photo = $staff_id.".jpg";
            }
            // ���åץ�����Υѥ�����
            $up_file = STAFF_PHOTO_DIR.$photo;
            // ���åץ���
            $res = move_uploaded_file($_FILES["form_photo_ref"]["tmp_name"], $up_file);
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


        /****************************/
        // �����åեޥ�����Ͽ����������
        /****************************/
        $staff_cd1_sql = ($staff_cd1 != null) ? "'$staff_cd1'" : "NULL";
        $staff_cd2_sql = ($staff_cd2 != null) ? "'$staff_cd2'" : "NULL";

        //��Ͽ���ѹ�Ƚ��
        if ($staff_id != null){

            /*** �ѹ����� ***/
            //��ȶ�ʬ�Ϲ���
            $work_div = "2";

            $sql  = "UPDATE ";
            $sql .= "   t_staff ";
            $sql .= "SET ";
            $sql .= "   staff_cd1        = $staff_cd1_sql, ";        
            $sql .= "   staff_cd2        = $staff_cd2_sql, ";        
            $sql .= "   charge_cd        = '$charge_cd', ";        
            $sql .= "   staff_name       = '$staff_name', ";    
            $sql .= "   staff_read       = '$staff_read', ";    
            $sql .= "   staff_ascii      = '$staff_ascii', ";    
            $sql .= "   sex              = '$sex', ";            
            $sql .= "   birth_day        = $birth_day, ";    
            $sql .= "   state            = '$state', ";        
            $sql .= "   join_day         = $join_day, ";        
            $sql .= "   retire_day       = $retire_day, ";    
            $sql .= "   employ_type      = '$employ_type', ";
            $sql .= "   position         = '$position', ";        
            $sql .= "   job_type         = '$job_type', ";        
            $sql .= "   study            = '$study', ";        
            $sql .= "   toilet_license   = '$toilet_license', ";
            $sql .= "   license          = '$license', ";        
            $sql .= "   note             = '$note', ";    
            $sql .= "   photo            = '$photo', ";    
            $sql .= ($change_flg == 1) ? "change_flg = 't', " : "change_flg = 'f', ";
            $sql .= "   round_staff_flg  = '$round_staff' ";
            $sql .= "WHERE ";
            $sql .= "   staff_id = $staff_id;";

        }else{

            /*** ��Ͽ���� ***/
            //��ȶ�ʬ����Ͽ
            $work_div = "1";

            $sql  = "INSERT INTO ";
            $sql .= "   t_staff ";
            $sql .= "VALUES( ";
            $sql .= "   $staff_id_get, ";
            $sql .= "   $staff_cd1_sql, ";
            $sql .= "   $staff_cd2_sql, ";
            $sql .= "   '$staff_name', ";
            $sql .= "   '$staff_read', ";
            $sql .= "   '$staff_ascii', ";
            $sql .= "   '$sex', ";
            $sql .= "   $birth_day, ";
            $sql .= "   '$state', ";
            $sql .= "   $join_day, ";
            $sql .= "   $retire_day, ";
            $sql .= "   '$employ_type', ";
            $sql .= "   '$position', ";
            $sql .= "   '$job_type', ";
            $sql .= "   '$study', ";
            $sql .= "   '$toilet_license', ";
            $sql .= "   '$license', ";
            $sql .= "   '$note', ";
            $sql .= "   '$photo', ";
            $sql .=     ($change_flg == 1) ? "'t', " : "'f', ";
            $sql .= "   '$charge_cd', ";
            $sql .= "   '$round_staff' ";
            $sql .= ");";
        }
        $res = Db_Query($db_con, $sql);
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
/*
        //�ѹ�Ƚ��
        if ($staff_id != null){
            //��������
            //staff_id����˥ǡ������
            $sql  = "DELETE FROM ";
            $sql .= "    t_attach ";
            $sql .= "WHERE ";
            $sql .= "    staff_id = $staff_id;";
            $res = Db_Query($db_con,$sql);
        }
*/

        //��Ͽ���ѹ��ˤ�����餺����°�ޥ�������ٺ�����롣
        $sql = "DELETE FROM t_attach WHERE staff_id = $staff_id_get;";
        $result = Db_Query($db_con, $sql);
        if($result === false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }

        /*** ��Ͽ���� ***/
        //�����åռ���Ƚ��
        switch ($_POST["form_staff_kind"]){
            case "1":

            //FC or ľ��
            case "2":
/*
                $sql  = "INSERT INTO ";
                $sql .= "    t_attach ";
                $sql .= "VALUES(";
                $sql .= "    $cshop_id,";
                $sql .= "    $staff_id_get,";
                $sql .=      ($part_id != null) ? "$part_id, " : "null, ";
                $sql .= "    '$section',";
                $sql .=      ($ware_id != null) ? "$ware_id, " : "null, ";
                $sql .= "    'f',";
                $sql .= "    'f');";
*/

                //ô���Ҹ˺���
                //�ؿ���Ϥ���������
                $create_ware_staff_data = array($charge_cd,     //ô���ԥ�����
                                                $staff_name,    //�����å�̾
                                                $cshop_id,      //��°����å�ID
                                                $staff_id_get,  //�����å�ID����Ͽ��
                                                $db_con,        //DB���ͥ������
                                                $ware_id        //�Ҹ�ID
                                            );
                $ware_id = Create_Ware_Staff($create_ware_staff_data);

                //��°�ޥ�����Ͽ
                //�ؿ���Ϥ���������
                $add_attach_data = array($staff_id_get,
                                         $part_id,
                                         $section,
                                         $ware_id,
                                         'f',
                                         'f',
                                         $cshop_id
                                    );
                $sql = Add_Attach($add_attach_data);

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
                break;
            //����
            case "3":
/*
                $sql  = "INSERT INTO ";
                $sql .= "    t_attach ";
                $sql .= "VALUES(";
                $sql .= "    $client_id_head,";
                $sql .= "    $staff_id_get,";
                $sql .=      ($part_id_head != null) ? "$part_id_head, " : "null, ";
                $sql .= "    '$section_head',";
                $sql .=      ($ware_id_head != null) ? "$ware_id_head, " : "null, ";
                $sql .= "    't',";
                $sql .= "    'f');";
*/
                break;

            // ����
            // ľ��
            case "4":
/*
                $head_sql  = "INSERT INTO ";
                $head_sql .= "    t_attach ";
                $head_sql .= "VALUES(";
                $head_sql .= "    $client_id_head,";
                $head_sql .= "    $staff_id_get,";
                $head_sql .= "    1, ";
                $head_sql .= "    '$section_head',";
                $head_sql .=      ($ware_id_head != null) ? "$ware_id_head, " : "null, ";
                $head_sql .= "    't',";
                $head_sql .= "    't');";

                $sql  = "INSERT INTO ";
                $sql .= "    t_attach ";
                $sql .= "VALUES(";
                $sql .= "    $cshop_id,";
                $sql .= "    $staff_id_get,";
                $sql .=      ($part_id != null) ? "$part_id, " : "null, ";
                $sql .= "    '$section',";
                $sql .=      ($ware_id != null) ? "$ware_id, " : "null, ";
                $sql .= "    'f',";
                $sql .= "    't');";
*/

                //ľ�ĥ����å� 
                //ô���Ҹ˺���
                //�ؿ���Ϥ���������
                $create_ware_staff_data = array($charge_cd,     //ô���ԥ�����
                                                $staff_name,    //�����å�̾
                                                $cshop_id,      //��°����å�ID
                                                $staff_id_get,  //�����å�ID����Ͽ��
                                                $db_con,        //DB���ͥ������
                                                $ware_id        //�Ҹ�ID
                                            );
                $ware_id = Create_Ware_Staff($create_ware_staff_data);

                //��°�ޥ�����Ͽ
                //�ؿ���Ϥ���������
                $add_attach_data = array($staff_id_get,
                                         $part_id,
                                         $section,
                                         $ware_id,
                                         'f',
                                         't',
                                         $cshop_id
                                    );
                $sql = Add_Attach($add_attach_data);

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                }

                //������å�(������åդ��Ҹˤ���Ͽ�ϹԤʤ�ʤ�)
                //��°�ޥ�����Ͽ
                //�ؿ���Ϥ���������
                $add_attach_data = array($staff_id_get,
                                         null,
                                         null,
                                         null,
                                         't',
                                         't',
                                         $client_id
                                    );
                $sql = Add_Attach($add_attach_data);

                $result = Db_Query($db_con, $sql);
                if($result === false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }
        }
/*
        // ����ľ�Ĥξ��ϡ����줾����Ͽ����
        if ($_POST["form_staff_kind"] == "4"){
            $head_result = Db_Query($db_con, $head_sql);
            if ($head_result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
        }
        $res = Db_Query($db_con,$sql);
        if ($res == false){
            Db_Query($db_con, "ROLLBACK;");
            exit;
        }
*/
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
                    $sql .= "WHERE ";
                    $sql .= "    t_staff.charge_cd = $charge_cd ";
                    $sql .= "AND ";
                    //�����åռ���Ƚ��
                    switch ($_POST["form_staff_kind"]){
                        //FCorľ�ĤΥ����å�ID�������
                        case "1":
                        case "2":
                            $sql .= "    t_attach.shop_id = $cshop_id ";
                            break;
                        //����or����ľ�ĤΥ����å�ID�������
                        case "3":
                        case "4":
                            $sql .= "    t_attach.shop_id = $client_id_head ";
                            break;
                    }
                    $sql .= "),";
                    $sql .= "'$login_id',";
                    $sql .= "'$crypt_pass');";
                // �����å���Ͽ��ˡ��ɲäǥ�����������Ͽ������
                }else{
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
                // ��������
                $sql  = "UPDATE ";
                $sql .= "   t_login ";
                $sql .= "SET ";
                $sql .= "   login_id = '$login_id' ";
                // �ѥ���ɤ�̤���Ϥξ��ϡ��������ʤ�
                if ($password1!=null){
                    $sql .= ",";
                    $sql .= "password = '$crypt_pass' ";
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id;";
            }
            $res = Db_Query($db_con, $sql);
            if ($res == false){
                Db_Query($db_con, "ROLLBACK;");
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
            $permit_col = Permit_Col("head");

            $p = 0;
            $ary_type = array("h", "f");
            // ���¥ơ��֥�Υ����̾����Ϳ���븢�¡�n, r, w�ˤ򥻥åȤˤ�������κ���
            for ($i=0; $i<count($ary_type); $i++){
                for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                    for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                        for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                            $permit_data[$p] = ($_POST[permit][$ary_type[$i]][$j][$k][$l][n] == null)   ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : null;
                            $permit_data[$p] = ($_POST[permit][$ary_type[$i]][$j][$k][$l][r] == 1)      ? array($permit_col[$ary_type[$i]][$j][$k][$l], "r") : $permit_data[$p];
                            $permit_data[$p] = ($_POST[permit][$ary_type[$i]][$j][$k][$l][w] == 1)      ? array($permit_col[$ary_type[$i]][$j][$k][$l], "w") : $permit_data[$p];
                            $p++;
                        }
                    }
                }
            }

            /* �����åռ��̤ˤ�븢���ѹ� */
            // �����åռ������ơ�����FC�ˤ�������������
            switch ($_POST["form_staff_kind"]){
                case 1:
                    $auth_type = array("fc");
                    break;
                case 2:
                    $auth_type = array("fc");
                    break;
                case 3:
                    $auth_type = array("head");
                    break;
                case 4:
                    $auth_type = array("head", "fc");
                    break;
            }
            $p = 0;
            $ary_type = array("h", "f");
            for ($i=0; $i<count($ary_type); $i++){
                for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                    for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                        for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                            // �����åռ������Ƥ�����̵�����
                            if (!in_array("head", $auth_type)){
                                // �����Ѹ��¤�none�ˤ���
                                $permit_data[$p] = ($ary_type[$i] == "h") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : $permit_data[$p];
                            }
                            // �����åռ������Ƥ�FC��̵�����
                            if (!in_array("fc", $auth_type)){
                                // FC�Ѹ��¤�none�ˤ���
                                $permit_data[$p] = ($ary_type[$i] == "f") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : $permit_data[$p];
                            }
                            $p++;
                        }
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
                $sql .= "(SELECT ";
                $sql .= "    t_staff.staff_id ";
                $sql .= "FROM ";
                $sql .= "    t_staff ";
                $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
                $sql .= "WHERE ";
                $sql .= "    t_staff.charge_cd = $charge_cd ";
                $sql .= "AND ";
                //�����åռ���Ƚ��
                switch ($_POST["form_staff_kind"]){
                    //FCorľ�ĤΥ����å�ID�������
                    case "1":
                    case "2":
                        $sql .= "    t_attach.shop_id = $cshop_id ";
                        break;
                    //����or����ľ�ĤΥ����å�ID�������
                    case "3":
                    case "4":
                        $sql .= "    t_attach.shop_id = $client_id_head ";
                        break;
                }
                $sql .= "),";
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

        // �֥����������ѹ����ʤ��פ˥����å����դ��Ƥ����礫�ġ������å��ѹ��ξ��
        }elseif ($_POST["form_login_info"] == "1" && $staff_id != null){

            // ���¥ơ��֥����Ͽ��������
            $sql = "SELECT staff_id FROM t_permit WHERE staff_id = $staff_id;";
            $res = Db_Query($db_con, $sql);
            $num = pg_num_rows($res);
            if ($num > 0){

                /* �����åռ��̤ˤ�븢���ѹ� */
                // �����åռ������ơ�����FC�ˤ�������������
                switch ($_POST["form_staff_kind"]){
                    case 1:
                        $auth_type = array("fc");
                        break;
                    case 2:
                        $auth_type = array("fc");
                        break;
                    case 3:
                        $auth_type = array("head");
                        break;
                    case 4:
                        $auth_type = array("head", "fc");
                        break;
                }

                $permit_col = Permit_Col("head");

                $p = 0;
                $ary_type = array("h", "f");
                for ($i=0; $i<count($ary_type); $i++){
                    for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                        for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                            for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                                // �����åռ������Ƥ�����̵�����
                                if (!in_array("head", $auth_type)){
                                    // �����Ѹ��¤�none�ˤ���
                                    $permit_data[$p] = ($ary_type[$i] == "h") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : null;
                                }
                                // �����åռ������Ƥ�FC��̵�����
                                if (!in_array("fc", $auth_type)){
                                    // FC�Ѹ��¤�none�ˤ���
                                    $permit_data[$p] = ($ary_type[$i] == "f") ? array($permit_col[$ary_type[$i]][$j][$k][$l], "n") : null;
                                }
                                $p++;
                            }
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

                // ���º��SQL
                $sql  = "UPDATE ";
                $sql .= "   t_permit ";
                $sql .= "SET ";
                $sql .= "   staff_id = $staff_id";
                $sql .= (count($permit_data) > 0) ? ", " : " ";
                for ($i=0; $i<count($permit_data); $i++){
                    for ($j=0; $j<count($permit_data[$i][0]); $j++){
                        $sql .= "   ".$permit_data[$i][0][$j]." = '".$permit_data[$i][1]."'";
                        $sql .= (($i == count($permit_data)-1) && ($j == count($permit_data[$i][0])-1)) ? " " : ", ";
                    }
                }
                $sql .= "WHERE ";
                $sql .= "   staff_id = $staff_id ";
                $sql .= ";";
                $res = Db_Query($db_con, $sql);
                if ($res == false){
                    Db_Query($db_con, "ROLLBACK;");
                    exit;
                }

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

        // ������Ͽ�ξ���GET����̵���١�GET�������
        if ($staff_id == ""){
            $sql  = "SELECT ";
            $sql .= "    t_staff.staff_id ";
            $sql .= "FROM ";
            $sql .= "    t_staff ";
            $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id ";
            $sql .= "WHERE ";
            $sql .= "    t_staff.charge_cd = $charge_cd ";
            $sql .= "AND ";
            //�����åռ���Ƚ��
            switch ($_POST["form_staff_kind"]){
                //FCorľ�ĤΥ����å�ID�������
                case "1":
                case "2":
                    $sql .= "    t_attach.shop_id = $cshop_id ";
                    break;
                //����or����ľ�ĤΥ����å�ID�������
                case "3":
                case "4":
                    $sql .= "    t_attach.shop_id = $client_id_head ";
                    break;
            }
            $sql .= ";";
            $res  = Db_Query($db_con,$sql);
            $staff_id = pg_fetch_result($res, 0, 0);        //�����å�ID
        }

        Db_Query($db_con, "COMMIT;");
        $freeze_flg = true;

    }


/******************************/
// ����ܥ��󲡲�������
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

            Db_Query($db_con, "COMMIT;");

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
            header("Location: 1-1-107.php");

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
    $form->addElement("button", "del_button", "���", "style=\"color: #ff0000;\" onClick=\"javascript:Dialogue_2('������ޤ���', '#', 'true', 'del_button_flg', this)\" $del_disabled");
    $form->addElement("hidden", "del_button_flg", "", "");
    // ���¥��
    $form->addElement("link", "form_permit_link", "", "#", "����", "onClick=\"javascript:return Submit_Page2('1-1-120.php?staff_id=$staff_id')\"");
    // ���إܥ���
    $option = ($next_id != null) ? "onClick=\"location.href='./1-1-109.php?staff_id=$next_id'\"" : "disabled";
    $form->addElement("button", "next_button", "������", $option);
    // ���إܥ���
    $option = ($back_id != null) ? "onClick=\"location.href='./1-1-109.php?staff_id=$back_id'\"" : "disabled";
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
    $sql .= "   t_attach.shop_id = $cshop_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);
    if ($num > 0){
        $return_id = pg_fetch_result($res, 0, 0);
    }

    // ���ܥ���
    $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"location.href='./1-1-109.php?staff_id=".$return_id."'\"");
    // OK�ܥ���
    $form->addElement("button", "comp_button", "O ��K", "onClick=\"location.href='./1-1-109.php'\" $disabled");
    // ���¥��
    $form->addElement("static", "form_permit_link", "", "����");

    $form->freeze();

    $password_msg = null;
//    $permit_set_msg = "�ѹ����ޤ���";

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

/******************************/
//�إå�����ɽ�������������
/*****************************/
/** �����åեޥ�������SQL���� **/
$sql  = "SELECT \n";
$sql .= "   count(staff_id) \n";                    //�����å�ID
$sql .= "FROM \n";
$sql .= "   t_attach \n";
$sql .= "WHERE shop_id != 1 \n";
$result = Db_Query($db_con,$sql.";");
//��������(�إå���)
$total_count_h = pg_fetch_result($result,0,0);


/****************************/
// ����ˤ���ѹ��Բĥ����åդξ��ϥե꡼��
/****************************/
if ($h_change_ng_flg == true){
    $freeze = $form->addGroup($change_ng_freeze, "change_ng_freeze", "");
    $freeze->freeze();
}


/****************************/
//�ؿ�
/****************************/
/**
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
**/
function Create_Ware_Staff($ary){

    $charge_cd  = $ary[0];  //ô���ԥ�����
    $staff_name = $ary[1];  //ô����̾
    $attach_id  = $ary[2];  //FC����å�ID  ������ϥ��å�����ID�򤷤褦
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

/**
 * ��°�ޥ�������Ͽ����ؿ�
 *
 *
 *
 *
**/
function Add_Attach($ary){

    $staff_id    = $ary[0];    //�����å�ID
    $part_id     = $ary[1];    //���ID
    $section     = $ary[2];    //��
    $ware_id     = $ary[3];    //�Ҹ�ID
    $h_staff_flg = $ary[4];    //������åեե饰
    $sys_flg     = $ary[5];    //�����ƥ����إե饰
    $shop_id     = $ary[6];    //��°����å�ID

    $sql  = "INSERT INTO t_attach (";
    $sql .= "   staff_id,";
    $sql .= "   part_id, ";
    $sql .= "   section, ";
    $sql .= "   ware_id, ";
    $sql .= "   h_staff_flg, ";
    $sql .= "   sys_flg,";
    $sql .= "   shop_id ";
    $sql .= ")VALUES(";
    $sql .= "   $staff_id,";
    $sql .=     ($part_id != null) ? "$part_id, " : "null, ";
    $sql .= "   '$section', ";
    $sql .=     ($ware_id != null) ? "$ware_id, " : "null, ";
    $sql .= "   '$h_staff_flg',";
    $sql .= "   '$sys_flg',";
    $sql .= "   $shop_id ";
    $sql .= ");";

    return $sql;

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
//��˥塼����
/****************************/
$page_menu = Create_Menu_h("system", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count_h."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ��assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ��assign
$smarty->assign("var", array(
    'html_header'               => "$html_header",
    'page_menu'                 => "$page_menu",
    'page_header'               => "$page_header",
    'html_footer'               => "$html_footer",
    'password_msg'              => "$password_msg",
    'login_info_msg'            => "$login_info_msg",
    'staff_id'                  => "$staff_id",
    'back_id'                   => "$back_id",
    'next_id'                   => "$next_id",
    'freeze_flg'                => "$freeze_flg",
    'cshop_head_flg'            => "$cshop_head_flg",
    'only_head_flg'             => "$only_head_flg",
    'warning'                   => "$warning1",
    'warning2'                  => "$warning2",
    'permit_set_msg'            => "$permit_set_msg",
    'staff_del_restrict_msg'    => "$staff_del_restrict_msg",
    'select_staff_kind'         => "$select_staff_kind",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
