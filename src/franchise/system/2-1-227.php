<?php
$page_title = "�������ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;


/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];


/****************************/
//�������
/****************************/
/* �إå��ե����� */
// ��Ͽ����
$form->addElement("button", "new_button", "��Ͽ����", "onClick=\"javascript:Referer('2-1-228.php')\"");

// �ѹ�������
$form->addElement("button", "change_button", "�ѹ�������", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

/* �ᥤ��ե����� */
// ô����
$select_value = Select_Get($db_con, "staff");
$form->addElement("select", "form_staff_select", "", $select_value, $g_form_option_select);

// ɽ��
$form->addElement("submit", "show_button", "ɽ����");

//���ꥢ
$form->addElement("button", "clear_button", "���ꥢ", "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");



/****************************/
// �ڡ����ɹ����ν���
/****************************/
// ����������
$sql = "SELECT DISTINCT staff_id FROM t_course;";
$res = Db_Query($db_con, $sql);
$total_count =  pg_num_rows($res);


/****************************/
// ����ɽ�ѥǡ�������
/****************************/
// ɽ���ܥ��󤬲������줿���
if (isset($_POST["show_button"])){

    // ���򤵤줿�����åդ�staff_id���ѿ�������
    $staff_id   = $_POST["form_staff_select"];

    /* ����Ϣ�������������� */
    // �����åդ����򤵤�Ƥ������1�롼�פΤ�
    // ����Ƥ��ʤ�����t_course����Ͽ����Ƥ�����staff_id�����ʣʬ������������ʬ�롼�פ���
    $sql  = "SELECT DISTINCT staff_id FROM t_course WHERE ";
    $sql .= ($group_kind == "2") ? " t_course.shop_id IN (".Rank_Sql().") " : " t_course.shop_id = $shop_id ";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = ($staff_id == null) ? pg_num_rows($res) : 1;
    for ($i=0; $i<$num; $i++){
        for ($j=0; $j<3; $j++){
            for ($k=0; $k<3; $k++){
                for ($l=0; $l<5; $l++){
                    for ($m=0; $m<7; $m++){
                        $ary_disp_data[$i][$j][$k][$l][$m] = null;
                    }
                }
            }
        }
    }

    /* ���ɽ���ѥǡ������� */
    $staff_count = ($staff_id != null) ? 1 : $num;

    // ����ɽ���ѹʤ����SQL
    $where_sql  = ($staff_id != null) ? " AND t_staff.staff_id = $staff_id " : null;

    /* ����ɽ���ѥǡ�������SQL */
    $sql  = "SELECT ";
    $sql .= "   t_staff.staff_id, ";    // �ʽ��˥����å�ID
    $sql .= "   t_staff.charge_cd, ";   // �ʽ���ô���ԥ�����
    $sql .= "   t_staff.staff_name, ";  // �ʽ��˥����å�̾
    $sql .= "   t_course.round_div, ";  // ����ʬ(1:ABCD��, 2:��������ա�, 3:�����������)
    $sql .= "   t_course.abcd_week, ";  // ��̾��ABCD��
    $sql .= "   t_course.cale_week, ";  // ��̾��1��4��
    $sql .= "   t_course.rday, ";       // ������
    $sql .= "   t_course.week_rday, ";  // ��������
    $sql .= "   t_course.course_name "; // ������̾
    $sql .= "FROM t_course ";
    $sql .= "   INNER JOIN t_staff ";
    $sql .= "   ON t_course.staff_id = t_staff.staff_id ";
    $sql .= $where_sql;
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
    $count = @pg_num_rows($res);
    for ($i=0; $i<$count; $i++){
        $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    /* ����ɽ���ѥǡ������� */
    $staff_row = 0;   // ô����ñ�̤ι��ֹ�

    // ����ɽ���ѥǡ�������
    for ($i=0; $i<$count; $i++){

        // �Կ�css
        $ary_disp_data[$staff_row][0]       = (bcmod($staff_row, 2) == 0) ? "Result1" : "Result2";

        // �����åվ���
        $ary_disp_data[$staff_row][1][0]    = $ary_list_data[$i][0]; // �����å�ID
        $ary_disp_data[$staff_row][1][1]    = htmlspecialchars($ary_list_data[$i][2]); // �����å�̾

        // ����ɽ���Ѥ�����key����
        $round_div  = $ary_list_data[$i][3]-1;  // ����ʬ
        $abcd_week  = $ary_list_data[$i][4]-1;  // ��̾(ABCD)
        $cale_week  = $ary_list_data[$i][5]-1;  // ��̾(1-4)
        $week_rday  = $ary_list_data[$i][7]-1;  // ��������

        // ��������աˤξ��
        if ($ary_list_data[$i][3] == "2"){
            // ���������ʷ��˥������Ȥǡ˲����ܤˤ����뤫����
            $week_num   = ($ary_list_data[$i][6] != "30") ? bcdiv(($ary_list_data[$i][6]-1), 7) : 4;
            // ���������ʷ��˥������Ȥǡˢ��ǻ��Ф������β����ܤˤ����뤫����
            $day_num    = ($ary_list_data[$i][6] != "30") ? ($ary_list_data[$i][6]-1) - ($week_num*7) : 0;
        }

        // ������̾��ABCD���ξ���
        if ($ary_list_data[$i][3] == "1"){
            $ary_disp_data[$staff_row][2][$round_div][$abcd_week][$week_rday]   = htmlspecialchars($ary_list_data[$i][8]);
        // ������̾�ʷ�������աˤξ���
        }elseif ($ary_list_data[$i][3] == "2"){
            $ary_disp_data[$staff_row][2][$round_div][$week_num][$day_num]      = htmlspecialchars($ary_list_data[$i][8]);
        // ������̾�ʷ���������ˤξ���
        }elseif ($ary_list_data[$i][3] == "3"){
            $ary_disp_data[$staff_row][2][$round_div][$cale_week][$week_rday]   = htmlspecialchars($ary_list_data[$i][8]);
        }

        // ô���Ԥ��Ѥ�����ô����ñ�̤ι��ֹ��1��û�����
        ($ary_list_data[$i][0] != $ary_list_data[$i+1][0]) ? $staff_row++ : null;

    }

    /* ���򤵤줿�����åդΥ쥳���ɤ�̵����� */
    if ($staff_id != null && $count == 0){

        // �����å�̾���SQL
        $sql = "SELECT staff_name FROM t_staff WHERE staff_id = $_POST[form_staff_select];";
        $res = Db_Query($db_con, $sql);

        // ����̵���Ȥ��襤�����ʤΤǶ��ǡ�������
        $ary_disp_data[0][0]    = "Result1";                    // �Կ�css
        $ary_disp_data[0][1][0] = $_POST["form_staff_select"];  // ���ô����ID
        $ary_disp_data[0][1][1] = htmlspecialchars(pg_fetch_result($res, 0));     // ���ô����̾

        // ���ɽ����
        $staff_count = 1;

    }

}

// ���˥������Ȣ����˥������Ȥ˻��Ѥ��줿�Τ��������Ȥ������ؤ�
for ($i=0; $i<count($ary_disp_data[0][2][0]); $i++){
    $ary_0[$i][0] = $ary_disp_data[0][2][0][$i][6];
    $ary_0[$i][1] = $ary_disp_data[0][2][0][$i][0];
    $ary_0[$i][2] = $ary_disp_data[0][2][0][$i][1];
    $ary_0[$i][3] = $ary_disp_data[0][2][0][$i][2];
    $ary_0[$i][4] = $ary_disp_data[0][2][0][$i][3];
    $ary_0[$i][5] = $ary_disp_data[0][2][0][$i][4];
    $ary_0[$i][6] = $ary_disp_data[0][2][0][$i][5];
}
$ary_disp_data[0][2][0] = $ary_0;
for ($i=0; $i<count($ary_disp_data[0][2][2]); $i++){
    $ary_1[$i][0] = $ary_disp_data[0][2][2][$i][6];
    $ary_1[$i][1] = $ary_disp_data[0][2][2][$i][0];
    $ary_1[$i][2] = $ary_disp_data[0][2][2][$i][1];
    $ary_1[$i][3] = $ary_disp_data[0][2][2][$i][2];
    $ary_1[$i][4] = $ary_disp_data[0][2][2][$i][3];
    $ary_1[$i][5] = $ary_disp_data[0][2][2][$i][4];
    $ary_1[$i][6] = $ary_disp_data[0][2][2][$i][5];
}
$ary_disp_data[0][2][2] = $ary_1;


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
$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
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
    'total_count'   => "$total_count",
    'auth_r_msg'    => "$auth_r_msg",
    'comp_msg'      => "$comp_msg",
    'staff_count'   => "$staff_count",
));

$smarty->assign("ary_disp_data", $ary_disp_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
