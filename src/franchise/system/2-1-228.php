<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0083    suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *  
 *  
 *
*/

/*----------------------------------------------------------
    �ڡ��������
----------------------------------------------------------*/

/*------------------------------------------------
    �������ȥե��������
------------------------------------------------*/
// �Ķ�����ե�����
require_once("ENV_local.php");

/*------------------------------------------------
    �ѿ����
------------------------------------------------*/
// �ڡ���̾
$page_title = "�������ޥ���";

// �ե�����
$form = new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null, "onSubmit=javascript:return confirm(true)");

// DB��³����
$db_con     = Db_Connect();


// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/*------------------------------------------------
    �����ѿ�����
------------------------------------------------*/
$shop_id        = $_SESSION["client_id"];
$group_kind     = $_SESSION["group_kind"];
$get_staff_id   = $_GET["staff_id"];
$post_staff_id  = $_POST["form_staff_select"];

$where = ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["staff_id"] != null && Get_Id_Check_Db($db_con, $_GET["staff_id"], "staff_id", "t_attach", "num", $where) != true){
    header("Location: ../top.php");
}

/*------------------------------------------------
    �ɹ����ν���
------------------------------------------------*/
// �����å�ID����
if ($get_staff_id != null || $post_staff_id != null){
    $staff_id = ($get_staff_id != null) ? $get_staff_id : $post_staff_id;
}

// ��Ͽor�ѹ�Ƚ��
if ($staff_id != null){
    $sql    = "SELECT COUNT(staff_id) FROM t_course WHERE staff_id = $staff_id;";
    $res    = Db_Query($db_con, $sql);
    $count  = pg_fetch_result($res, 0);
    $submit_state   = ($count > 0) ? "�ѹ�" : "��Ͽ";
    $submit_label   = ($count > 0) ? "�ѡ���" : "�С�Ͽ";
}else{
    $submit_label   = "�С�Ͽ";
}


/*------------------------------------------------
    QuickForm - �ե����४�֥����������
------------------------------------------------*/
/* �إå��ե����� */
// ��Ͽ����
$form->addElement("button", "new_button", "��Ͽ����", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", "onClick=\"javascript:Referer('2-1-227.php')\"");

/* �ᥤ��ե����� */
// ô����
$select_value = Select_Get($db_con, "staff");
$freeze_form = $form->addElement("select", "form_staff_select", "", $select_value, "onChange=\"document.dateForm.submit();\"");

// �����åդλ��꤬������Τ�����
if ($get_staff_id != null || $post_staff_id != null){

    // ������̾
    // ����ʬ��롼��
    for ($i=0; $i<3; $i++){
        // ����롼��
        $j_num = ($i == 1) ? 5 : 4;                     // ����ʬ1�ξ��Τ���5���ܤ�¸�ߤ���Τ�5��롼��
        for ($j=0; $j<$j_num; $j++){
            // ������롼��
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // ��5���ܤ�1�������ʤ��Τ�1�롼��
            for ($k=0; $k<$k_num; $k++){
                $form->addElement("text", "form_course_name[$i][$j][$k]", "", "size=\"24\" maxlength=\"15\" $g_form_option");
            }
        }
    }

    // ��Ͽ�ܥ���
    $form->addElement("submit", "form_submit_btn", $submit_label, "onClick=\"javascript:return Dialogue4('".$submit_state."���ޤ�');\" $disabled");

    // OK�ܥ���
    $form->addElement("button", "form_ok_btn", "�ϡ���", "onClick=javascript:location.href='./2-1-227.php'");
    
    // ���ܥ���
    $form->addElement("button", "form_return_btn", "�ᡡ��", "onClick=\"history.back()\"");

}

/* �ե꡼�� */
// �����������ܤ��Ƥ�����GET������˾��Ͻ��ô���ԥ��쥯�ȥܥå�����GET�ǡ��������������ե꡼��
if ($_GET["staff_id"] != null){
    $get_staff_data["form_staff_select"] = $_GET["staff_id"];
    $form->setConstants($get_staff_data);
    $freeze_form->freeze();
}


/*----------------------------------------------------------
    ��Ͽ�ܥ��󲡲����ν���
----------------------------------------------------------*/
if (isset($_POST["form_submit_btn"])){

    /*------------------------------------------------
        ���顼�����å�
    ------------------------------------------------*/
    // ������̾
    // ����/Ⱦ�ѥ��ڡ����Τߥ����å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_bank_name", "���̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");
    foreach ($_POST["form_course_name"] as $key1 => $value1){
        foreach ($value1 as $key2 => $value2){
            foreach ($value2 as $key3 => $value3){
                if (ereg("^[ ��]+$", $value3)){
                    $form_err_flg = true;
                    break;
                }
            }
            if ($form_err_flg == true){
                break;
            }
        }
        if ($form_err_flg == true){
            break;
        }
    }

    // ���顼��̵�����
    if ($form_err_flg != true){
    /*------------------------------------------------
        DB����
    ------------------------------------------------*/
    Db_Query($db_con, "BEGIN;");

    // POST�ǡ��������������
    // ���˥������Ȣ����˥������Ȥ˻��Ѥ��줿�Τ��������Ȥ������ؤ�
    foreach ($_POST["form_course_name"] as $key1 => $value1){
        foreach ($value1 as $key2 => $value2){
            foreach ($value2 as $key3 => $value3){

                // ��������աˤξ������̤���������
                if ($key1 == "1"){
                    $post_course_name[$key1][$key2][$key3] = $value3;
                // ����ʳ��ξ����������Ȥ������ؤ�������
                }else{
                    switch ($key3){
                        case "0":
                            $post_course_name[$key1][$key2][6] = $value3;
                            break;
                        case "1":
                            $post_course_name[$key1][$key2][0] = $value3;
                            break;
                        case "2":
                            $post_course_name[$key1][$key2][1] = $value3;
                            break;
                        case "3":
                            $post_course_name[$key1][$key2][2] = $value3;
                            break;
                        case "4":
                            $post_course_name[$key1][$key2][3] = $value3;
                            break;
                        case "5":
                            $post_course_name[$key1][$key2][4] = $value3;
                            break;
                        case "6":
                            $post_course_name[$key1][$key2][5] = $value3;
                            break;
                    }
                }

            }
        }
    }

    // ����ǥ롼�ס�ABCD������������աˡ�����������ˡ�
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // ����ʬ1�ξ��Τ���5���ܤ�¸�ߤ���Τ�5��롼��
        // ���ǥ롼��
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // ��5���ܤ�1�������ʤ��Τ�1�롼��
            // �����ǥ롼��
            for ($k=0; $k<$k_num; $k++){

                // INSERT
                if ($submit_state == "��Ͽ"){
					$work_div = 1;

                    $sql  = "INSERT INTO t_course ";
                    $sql .= "( ";
                    $sql .= "   course_id, ";       // ������ID
                    $sql .= "   course_name, ";     // ������̾
                    $sql .= "   staff_id, ";        // ô����ID
                    $sql .= "   round_div, ";       // ����ʬ
                    $sql .= "   abcd_week, ";       // ��̾(ABCD)
                    $sql .= "   cale_week, ";       // ��̾(1234)
                    $sql .= "   week_rday, ";       // ��������
                    $sql .= "   rday, ";            // ������
                    $sql .= "   shop_id ";          // ����å�ID
                    $sql .= ") ";
                    $sql .= "VALUES ";
                    $sql .= "( ";
                    $sql .= "   (SELECT COALESCE(MAX(course_id), 0)+1 FROM t_course), ";
                    $sql .= "   '".(string)($post_course_name[$i][$j][$k])."', ";
                    $sql .= "   $staff_id, ";
                    $sql .= "   '".($i+1)."', ";
                    $sql .=     ($i == 0) ? "'".($j+1)."', " : "NULL, ";
                    $sql .=     ($i == 2) ? "'".($j+1)."', " : "NULL, ";
                    $sql .=     ($i != 1) ? "'".($k+1)."', " : "NULL, ";
                    if ($i == 1 && $j == 4 && $k == 0){
                        $sql .= " '30', ";          // ��������աˤη����ξ���30����Ͽ����
                    }else{
                        $sql .=     ($i == 1) ? "'".(($j*7)+($k+1))."', " : "NULL, ";
                    }
                    $sql .= "   $shop_id ";
                    $sql .= ") ";
                    $sql .= ";";
                // UPDATE
                }else{
					$work_div = 2;

                    $sql  = "UPDATE t_course ";
                    $sql .= "SET ";
                    $sql .= "   course_name = '".(string)($post_course_name[$i][$j][$k])."' ";
                    $sql .= "WHERE ";
                    $sql .= "   staff_id = $staff_id ";
                    $sql .= "AND ";
                    $sql .= "   round_div = '".($i+1)."' ";
                    $sql .= "AND ";
                    $sql .=     ($i == 0) ? "abcd_week = '".($j+1)."' " : "abcd_week IS NULL ";
                    $sql .= "AND ";
                    $sql .=     ($i == 2) ? "cale_week = '".($j+1)."' " : "cale_week IS NULL ";
                    $sql .= "AND ";
                    $sql .=     ($i != 1) ? "week_rday = '".($k+1)."' " : "week_rday IS NULL ";
                    $sql .= "AND ";
                    if ($i == 1 && $j == 4 && $k == 0){
                        $sql .= " rday = 30 ";    // ��������աˤη����ξ���30�ǻ��ꤹ��
                    }else{
                        $sql .=     ($i == 1) ? "rday = ".(($j*7)+($k+1))." " : "rday IS NULL ";
                    }
                    $sql .= "AND ";
                    $sql .= "   shop_id = $shop_id ";
                    $sql .= ";";
                }

                $res = Db_Query($db_con,$sql);
                if ($res == false){
                    Db_Query($db_con,"ROLLBACK;");
                    exit;
                }

            }
        }
    }

	//�������ޥ������ͤ���˽񤭹���
	//�ʥǡ��������ɡ����ô����CD  ̾�Ρ����ô����̾��
	$sql  = "SELECT ";
	$sql .= "    charge_cd,";
	$sql .= "    staff_name ";
	$sql .= "FROM ";
	$sql .= "    t_staff ";
	$sql .= "WHERE ";
	$sql .= "    staff_id = $staff_id;";
	$res = Db_Query($db_con,$sql);
	$data_list = Get_Data($res,3);
    $result = Log_Save($db_con,'course',$work_div,$data_list[0][0],$data_list[0][1]);
    //����Ͽ���˥��顼�ˤʤä����
    if($result === false){
        Db_Query($db_con,"ROLLBACK;");
        exit;
    }

    Db_Query($db_con, "COMMIT;");

    $form->freeze();

    $touroku_ok_flg = true;

    }else{

        // ���顼��å���������
        $err_msg1 = "������̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���";

    }

}

/*----------------------------------------------------------
    ����ɽ�ǡ�������
----------------------------------------------------------*/
/*
// ���쥯�ȥܥå����ǥ����åդ����򤬤��줿���ϰ�ö�ե��������ˤ���
if ($_POST["form_staff_select"] != null){
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // ����ʬ1�ξ��Τ���5���ܤ�¸�ߤ���Τ�5��롼��
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // ��5���ܤ�1�������ʤ��Τ�1�롼��
            for ($k=0; $k<$k_num; $k++){
                $course_null["form_course_name"][$i][$j][$k] = "";
            }
        }
    }
    $form->setDefaults($cource_null);
}
*/


// �����åդλ��꤬������Τߺ���
if ($get_staff_id != null || $post_staff_id != null){

    /* �ե�����˥ǡ�����֤ä��� */
    // ��Ͽ�ܥ��󲡲�����POST���줿�ǡ���������
    // ���ɽ���ξ���null������
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // ����ʬ1�ξ��Τ���5���ܤ�¸�ߤ���Τ�5��롼��
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // ��5���ܤ�1�������ʤ��Τ�1�롼��
            for ($k=0; $k<$k_num; $k++){
                $course_data["form_course_name"][$i][$j][$k] = (isset($_POST["form_submit_btn"])) ? $_POST["form_course_name"][$i][$j][$k] : "";
            }
        }
    }

    /*------------------------------------------------
        ��Ͽ�ѥ�����̾����
    ------------------------------------------------*/
    $sql  = "SELECT ";
    $sql .= "   t_course.round_div, ";  // ����ʬ(1:ABCD��, 2:��������ա�, 3:�����������)
    $sql .= "   t_course.abcd_week, ";  // ��̾��ABCD��
    $sql .= "   t_course.cale_week, ";  // ��̾��1��4��
    $sql .= "   t_course.rday, ";       // ������
    $sql .= "   t_course.week_rday, ";  // ��������
    $sql .= "   t_course.course_name "; // ������̾
    $sql .= "FROM t_course ";
    $sql .= "   INNER JOIN t_staff ";
    $sql .= "   ON t_course.staff_id = t_staff.staff_id ";
    $sql .= "   AND t_staff.staff_id = $staff_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_course.shop_id IN (".Rank_Sql().") " : " t_course.shop_id = $shop_id ";
    $sql .= "ORDER BY ";
    $sql .= "   t_staff.charge_cd, ";
    $sql .= "   t_staff.staff_name, ";
    $sql .= "   t_course.round_div, ";
    $sql .= "   t_course.abcd_week, ";
    $sql .= "   t_course.cale_week, ";
    $sql .= "   t_course.rday, ";
    $sql .= "   t_course.week_rday ";
    $sql .= ";"; 
    $res  = Db_Query($db_con, $sql);
    $total_count = @pg_num_rows($res);
    for ($i=0; $i<$total_count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // �ե������Ǽ�ѥ�����̾�ǡ�������
    for ($i=0; $i<$total_count; $i++){

        // ����key����
        $round_div  = $ary_list_data[$i][0]-1;  // ����ʬ
        $abcd_week  = $ary_list_data[$i][1]-1;  // ��̾(ABCD)
        $cale_week  = $ary_list_data[$i][2]-1;  // ��̾(1234)
        $week_rday  = $ary_list_data[$i][4]-1;  // ��������

        // ��������աˤξ��
        if ($ary_list_data[$i][0] == "2"){
            // ����key����
            // ���������ʷ��˥������Ȥǡ˲����ܤˤ����뤫���Сʻ�������30�ʤ�4��
            $week_num   = ($ary_list_data[$i][3] != "30") ? bcdiv(($ary_list_data[$i][3]-1), 7) : 4;
            // ���������ʷ��˥������Ȥǡˢ��ǻ��Ф������β����ܤˤ����뤫���Сʻ�������30�ʤ�0��
            $day_num    = ($ary_list_data[$i][3] != "30") ? ($ary_list_data[$i][3]-1) - ($week_num*7) : 0;
        }

        // ������̾��ABCD���ξ���
        if ($ary_list_data[$i][0] == "1"){
            $course_data["form_course_name"][$round_div][$abcd_week][$week_rday]    = $ary_list_data[$i][5];
        // ������̾�ʷ�������աˤξ���
        }elseif ($ary_list_data[$i][0] == "2"){
            $course_data["form_course_name"][$round_div][$week_num][$day_num]       = $ary_list_data[$i][5];
        // ������̾�ʷ���������ˤξ���
        }elseif ($ary_list_data[$i][0] == "3"){
            $course_data["form_course_name"][$round_div][$cale_week][$week_rday]    = $ary_list_data[$i][5];
        }

    }

    // ���˥������Ȣ����˥������Ȥ˻��Ѥ��줿�Τ��������Ȥ������ؤ�
    for ($i=0; $i<count($course_data["form_course_name"][0]); $i++){
        $ary_cd0[$i][0] = $course_data["form_course_name"][0][$i][6];
        $ary_cd0[$i][1] = $course_data["form_course_name"][0][$i][0];
        $ary_cd0[$i][2] = $course_data["form_course_name"][0][$i][1];
        $ary_cd0[$i][3] = $course_data["form_course_name"][0][$i][2];
        $ary_cd0[$i][4] = $course_data["form_course_name"][0][$i][3];
        $ary_cd0[$i][5] = $course_data["form_course_name"][0][$i][4];
        $ary_cd0[$i][6] = $course_data["form_course_name"][0][$i][5];
    }
    $course_data["form_course_name"][0] = $ary_cd0; 
    for ($i=0; $i<count($course_data["form_course_name"][2]); $i++){
        $ary_cd1[$i][0] = $course_data["form_course_name"][2][$i][6];
        $ary_cd1[$i][1] = $course_data["form_course_name"][2][$i][0];
        $ary_cd1[$i][2] = $course_data["form_course_name"][2][$i][1];
        $ary_cd1[$i][3] = $course_data["form_course_name"][2][$i][2];
        $ary_cd1[$i][4] = $course_data["form_course_name"][2][$i][3];
        $ary_cd1[$i][5] = $course_data["form_course_name"][2][$i][4];
        $ary_cd1[$i][6] = $course_data["form_course_name"][2][$i][5];
    }
    $course_data["form_course_name"][2] = $ary_cd1; 

if ($form_err_flg != true){
    // ������̾��ե�����˥��å�
    $form->setConstants($course_data);
}

    /*------------------------------------------------
        ���������Ƽ���
    ------------------------------------------------*/
    /* ����Ϣ�������������� */
    for ($i=0; $i<3; $i++){
        $j_num = ($i == 1) ? 5 : 4;                     // ����ʬ1�ξ��Τ���5���ܤ�¸�ߤ���Τ�5��롼��
        for ($j=0; $j<$j_num; $j++){
            $k_num = ($i == 1 && $j == 4) ? 1 : 7;      // ��5���ܤ�1�������ʤ��Τ�1�롼��
            for ($k=0; $k<$k_num; $k++){
                $ary_disp_data[$i][$j][$k] = null;
            }
        }
    }

    /* ���������Ƽ�����ABCD���� */
    // ����롼��
    for ($i=0; $i<4; $i++){

        // ����������
        $where_sql  = " AND (t_contract.abcd_week = '".($i+1)."' ";
        $where_sql .= ($i <= 1) ? ") " : null;
        $where_sql .= ($i == 2) ? " OR (t_contract.abcd_week = '1' AND t_contract.cycle = '2')) " : null;
        $where_sql .= ($i == 3) ? " OR (t_contract.abcd_week = '2' AND t_contract.cycle = '2')) " : null;

        $sql  = "SELECT ";
        $sql .= "   t_contract.week_rday, ";        // ��������
        $sql .= "   t_contract.route, ";            // ��ϩ
        $sql .= "   t_client.client_cname, ";       // ������̾��ά�Ρ�
        $sql .= "   t_client.client_id, ";          // ������ID
        $sql .= "   t_contract.contract_id ";       // �������ID
        $sql .= "FROM ";
        $sql .= "   t_contract ";
        $sql .= "   INNER JOIN t_con_staff ";
        $sql .= "       ON t_contract.contract_id = t_con_staff.contract_id ";
        $sql .= "       AND t_con_staff.staff_id = $staff_id ";
        $sql .= "   INNER JOIN t_client ";
        $sql .= "       ON t_contract.client_id = t_client.client_id ";
        $sql .= "WHERE ";
        $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
        $sql .= "AND ";
        $sql .= "   t_contract.round_div = '1' ";
        $sql .= $where_sql;
        $sql .= "ORDER BY ";
        $sql .= "   t_contract.week_rday, ";
        $sql .= "   t_contract.route, ";
        $sql .= "   t_client.client_id ";
        $sql .= ";";

        $res  = Db_Query($db_con, $sql);
        $total_count = pg_num_rows($res);
        $ary_list_data = null;
        for ($j=0; $j<$total_count; $j++){
            $ary_list_data[] = @pg_fetch_array($res, $j, PGSQL_NUM);
        }

        // 1������η������ֹ�
        $client_row = 0;

        // ���������ư�������
        for ($j=0; $j<$total_count; $j++){

            // ����key����
            $week_rday  = $ary_list_data[$j][0]-1;  // ��������

            // ��ϩ�����������4���0��ᢪxx-xx�η��ˡ�
            $route = str_pad($ary_list_data[$j][1], 4, "0", STR_PAD_LEFT);
            $route = substr($route, 0, 2)."-".substr($route, 2, 2);

            // ɽ���ѥǡ����������
            // $ary_disp_data[����ʬ][��][����][���������]
            $ary_disp_data[0][$i][$week_rday][$client_row][0] = $ary_list_data[$j][3];      // ������ID
            $ary_disp_data[0][$i][$week_rday][$client_row][1] = $route;                     // �����ѽ�ϩ
            $ary_disp_data[0][$i][$week_rday][$client_row][2] = htmlspecialchars($ary_list_data[$j][2]);      // ������̾��ά�Ρ�

            // �������Ʊ���Ǥ����1��û������̤������ˤʤä���0���᤹
            ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]) ? $client_row++ : $client_row = 0;

        }

    }

    /* ���������Ƽ����ʷ�������աˡ� */
    // ����������
    $sql  = "SELECT ";
    $sql .= "   t_contract.rday, ";             // ������
    $sql .= "   t_contract.route, ";            // ��ϩ
    $sql .= "   t_client.client_cname, ";       // ������̾��ά�Ρ�
    $sql .= "   t_client.client_id, ";          // ������ID
    $sql .= "   t_contract.contract_id ";       // �������ID
    $sql .= "FROM ";
    $sql .= "   t_contract ";
    $sql .= "   INNER JOIN t_con_staff ";
    $sql .= "       ON t_contract.contract_id = t_con_staff.contract_id ";
    $sql .= "       AND t_con_staff.staff_id = $staff_id ";
    $sql .= "   INNER JOIN t_client ";
    $sql .= "       ON t_contract.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "   t_contract.round_div = '2' ";
    $sql .= $where_sql;
    $sql .= "ORDER BY ";
    $sql .= "   t_contract.rday, ";
    $sql .= "   t_contract.route, ";
    $sql .= "   t_client.client_id ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $ary_list_data = null;
    for ($i=0; $i<$total_count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // 1������η������ֹ�
    $client_row = 0;

    // ���������ư�������
    for ($i=0; $i<$total_count; $i++){

        // ����key����
        // ���������ʷ��˥������Ȥǡ˲����ܤˤ����뤫���Сʻ�������30�ʤ�4��
        $week_num   = ($ary_list_data[$i][0] != "30") ? bcdiv(($ary_list_data[$i][0]-1), 7) : 4;
        // ���������ʷ��˥������Ȥǡˢ��ǻ��Ф������β����ܤˤ����뤫���Сʻ�������30�ʤ�0��
        $day_num    = ($ary_list_data[$i][0] != "30") ? ($ary_list_data[$i][0]-1) - ($week_num*7) : 0;

        // ��ϩ�����������4���0��ᢪxx-xx�η��ˡ�
        $route = str_pad($ary_list_data[$j][1], 4, "0", STR_PAD_LEFT);
        $route = substr($route, 0, 2)."-".substr($route, 2, 2);

        // ɽ���ѥǡ����������
        // $ary_disp_data[����ʬ][���ʷ��˥������ȤȤ������Ρ�][���ν��β����ܤ�][���������]
        $ary_disp_data[1][$week_num][$day_num][$client_row][0] = $ary_list_data[$i][3];     // ������ID
        $ary_disp_data[1][$week_num][$day_num][$client_row][1] = $route;                    // �����ѽ�ϩ
        $ary_disp_data[1][$week_num][$day_num][$client_row][2] = htmlspecialchars($ary_list_data[$i][2]);     // ������̾��ά�Ρ�

        // ��������Ʊ���Ǥ����1��û������̤����ˤʤä���0���᤹
        ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]) ? $client_row++ : $client_row = 0;

    }

    /* ���������Ƽ����ʷ���������ˡ� */
    // ����������
    $sql  = "SELECT ";
    $sql .= "   t_contract.cale_week, ";    // ��̾(1234)
    $sql .= "   t_contract.week_rday, ";    // ��������
    $sql .= "   t_contract.route, ";        // ��ϩ
    $sql .= "   t_client.client_cname, ";   // ������̾��ά�Ρ�
    $sql .= "   t_client.client_id, ";      // ������ID
    $sql .= "   t_contract.contract_id ";   // �������ID
    $sql .= "FROM t_contract ";
    $sql .= "   INNER JOIN t_con_staff ";
    $sql .= "       ON t_contract.contract_id = t_con_staff.contract_id ";
    $sql .= "       AND t_con_staff.staff_id = $staff_id ";
    $sql .= "   INNER JOIN t_client ";
    $sql .= "       ON t_contract.client_id = t_client.client_id ";
    $sql .= "WHERE ";
    $sql .= ($group_kind == "2") ? " t_client.shop_id IN (".Rank_Sql().") " : " t_client.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "   t_contract.round_div = '3' ";
    $sql .= "ORDER BY ";
    $sql .= "   t_contract.cale_week, ";
    $sql .= "   t_contract.week_rday, ";
    $sql .= "   t_contract.route, ";
    $sql .= "   t_client.client_id ";
    $sql .= ";";

    $res  = Db_Query($db_con, $sql);
    $total_count = pg_num_rows($res);
    $ary_list_data = null;
    for ($i=0; $i<$total_count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // 1������η������ֹ�
    $client_row = 0;

    // ���������ư�������
    for ($i=0; $i<$total_count; $i++){

        // ����key����
        $cale_week  = $ary_list_data[$i][0]-1;      // ��̾(1234)
        $week_rday  = $ary_list_data[$i][1]-1;      // ��������

        // ��ϩ�����������4���0��ᢪxx-xx�η��ˡ�
        $route = str_pad($ary_list_data[$j][2], 4, "0", STR_PAD_LEFT);
        $route = substr($route, 0, 2)."-".substr($route, 2, 2);

        // ɽ���ѥǡ����������
        // $ary_disp_data[����ʬ][���ʷ��˥������ȤȤ������Ρ�][���ν��β����ܤ�][���������]
        $ary_disp_data[2][$cale_week][$week_rday][$client_row][0] = $ary_list_data[$i][4];     // ������ID
        $ary_disp_data[2][$cale_week][$week_rday][$client_row][1] = $route;                    // �����ѽ�ϩ
        $ary_disp_data[2][$cale_week][$week_rday][$client_row][2] = htmlspecialchars($ary_list_data[$i][3]);     // ������̾��ά�Ρ�

        // ��������Ʊ���Ǥ����1��û������̤����ˤʤä���0���᤹
        ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]) ? $client_row++ : $client_row = 0;

        // Ʊ��������ǡ������������Ѥ��з������ֹ��0���᤹
        //               ����������Ʊ���Ǥ���з������ֹ��1��û�����
        if ($ary_list_data[$j][0] == $ary_list_data[$j+1][0]){
            ($ary_list_data[$j][1] != $ary_list_data[$j+1][0]) ? $client_row = 0 : $client_row++;
        // �����Ѥ�������̵�ѤǷ������ֹ��0���᤹
        }else{
            $client_row = 0;
        }

    }

    // ���˥������Ȣ����˥������Ȥ˻��Ѥ��줿�Τ��������Ȥ������ؤ�
    for ($i=0; $i<count($ary_disp_data[0]); $i++){
        $ary_0[$i][0] = $ary_disp_data[0][$i][6];
        $ary_0[$i][1] = $ary_disp_data[0][$i][0];
        $ary_0[$i][2] = $ary_disp_data[0][$i][1];
        $ary_0[$i][3] = $ary_disp_data[0][$i][2];
        $ary_0[$i][4] = $ary_disp_data[0][$i][3];
        $ary_0[$i][5] = $ary_disp_data[0][$i][4];
        $ary_0[$i][6] = $ary_disp_data[0][$i][5];
    }
    $ary_disp_data[0] = $ary_0; 
    for ($i=0; $i<count($ary_disp_data[2]); $i++){
        $ary_1[$i][0] = $ary_disp_data[2][$i][6];
        $ary_1[$i][1] = $ary_disp_data[2][$i][0];
        $ary_1[$i][2] = $ary_disp_data[2][$i][1];
        $ary_1[$i][3] = $ary_disp_data[2][$i][2];
        $ary_1[$i][4] = $ary_disp_data[2][$i][3];
        $ary_1[$i][5] = $ary_disp_data[2][$i][4];
        $ary_1[$i][6] = $ary_disp_data[2][$i][5];
    }
    $ary_disp_data[2] = $ary_1; 

}


/*----------------------------------------------------------
    ���̽��ϥ�å���������
----------------------------------------------------------*/
// ���ô���Ԥ����ꤵ��Ƥ��ʤ����Υ�å�����
$staff_select_msg = ($get_staff_id == null && $post_staff_id == null) ? "�����ô���Ԥ����򤷤Ʋ�������" : null;


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
$page_menu = Create_Menu_f("system", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
$smarty->assign("var", array(
	"html_header" => "$html_header",
	"page_menu"   => "$page_menu",
	"page_header" => "$page_header",
	"html_footer" => "$html_footer",
	"total_count" => "$total_count",
    'auth_r_msg'  => "$auth_r_msg",
    "staff_select_msg"  => $staff_select_msg,
    "submit_state"      => "$submit_state",
    "form_err_flg"      => "$form_err_flg",
    "err_msg1"          => "$err_msg1",
    "touroku_ok_flg"    => "$touroku_ok_flg",
));
$smarty->assign("ary_disp_data", $ary_disp_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
