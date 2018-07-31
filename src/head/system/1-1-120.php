<?php

/**
 *������
 *  2007/02/19           watanabe-k  �����ܥ�����
 *   2016/01/21                amano  Button_Submit_1 �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
**/

$page_title = "�桼����������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
// Javascript���
/****************************/
$js_data = <<<PRINT_HTML_SRC

/*** ���֥�˥塼�����å� ***/
function Allcheck_Submenu2(me, ary_key){

    /* �����å�Ƚ�� */
    if (document.dateForm.elements[me].checked == true){
        /* ���֥�˥塼��ե������ʬ�롼�� */
        for (i=1; i<=ary_key[3]; i++){
            /* �����å�ON */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+ary_key[2]+"]["+i+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = true;
        }
    }else{
        /* ���֥�˥塼��ե������ʬ�롼�� */
        for (i=1; i<=ary_key[3]; i++){
            /* �����å�OFF */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+ary_key[2]+"]["+i+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = false;
        }
    }

}


/*** ��˥塼�����å� ***/
function Allcheck_Menu2(me, ary_key){

    /* �����å�Ƚ�� */
    if (document.dateForm.elements[me].checked == true){
        /* ���֥�˥塼��ʬ�롼�� */
        for (i=1; i<=ary_key[2]; i++){
            /* ���֥�˥塼�����å�ON */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = true;
            /* ���֥�˥塼��ե������ʬ�롼�� */
            for (j=1; j<=ary_key[3][i-1]; j++){
                /* �����å�ON */
                var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+j+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = true;
            }
        }
    }else{
        /* ���֥�˥塼��ʬ�롼�� */
        for (i=1; i<=ary_key[2]; i++){
            /* ���֥�˥塼�����å�OFF */
            var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = false;
            /* ���֥�˥塼��ե������ʬ�롼�� */
            for (j=1; j<=ary_key[3][i-1]; j++){
                /* �����å�OFF */
                var target = "permit"+"["+ary_key[0]+"]["+ary_key[1]+"]["+i+"]["+j+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = false;
            }
        }
    }

}


/*** �ȥåץ����å� ***/
function Allcheck_Top2(me, ary_key){

    if (document.dateForm.elements[me].checked == true){
        /* ��˥塼��ʬ�롼�� */
        for (i=1; i<=ary_key[1]; i++){
            /* ��˥塼�����å�ON */
            var target = "permit"+"["+ary_key[0]+"]["+i+"]["+0+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = true;
            /* ���֥�˥塼��ʬ�롼�� */
            for (j=1; j<=ary_key[2][i-1]; j++){
                /* ���֥�˥塼�����å�ON */
                var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+0+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = true;
                /* ���֥�˥塼��ե������ʬ�롼�� */
                for(k=1; k<=ary_key[3][i-1][j-1]; k++){
                    /* �����å�ON */
                    var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+k+"]["+ary_key[4]+"]";
                    document.dateForm.elements[target].checked = true;
                }
            }
        }
    }else{
        /* ��˥塼��ʬ�롼�� */
        for (i=1; i<=ary_key[1]; i++){
            /* ��˥塼�����å�OFF */
            var target = "permit"+"["+ary_key[0]+"]["+i+"]["+0+"]["+0+"]["+ary_key[4]+"]";
            document.dateForm.elements[target].checked = false;
            /* ���֥�˥塼��ʬ�롼�� */
            for (j=1; j<=ary_key[2][i-1]; j++){
                /* ���֥�˥塼�����å�OFF */
                var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+0+"]["+ary_key[4]+"]";
                document.dateForm.elements[target].checked = false;
                /* ���֥�˥塼��ե������ʬ�롼�� */
                for(k=1; k<=ary_key[3][i-1][j-1]; k++){
                    /* �����å�OFF */
                    var target = "permit"+"["+ary_key[0]+"]["+i+"]["+j+"]["+k+"]["+ary_key[4]+"]";
                    document.dateForm.elements[target].checked = false;
                }
            }
        }
    }

}

PRINT_HTML_SRC;


/****************************/
// �����ѥ�᡼������
/****************************/
// �����å�ID
$staff_id   = $_GET["staff_id"];

// ô���ԥ�����
$charge_cd  = $_POST["form_charge_cd"];

// �����å�̾
$staff_name = $_POST["form_staff_name"];

//�������å���Ͽ�ʳ���������ܤ�TOP�����ܤ�����
//if ($_POST["staff_url"] == null){
//    header("Location: ../top.php");
//}

/* GET����ID�������������å� */
if ($staff_id != null && !ereg("^[0-9]+$", $staff_id)){
    header("Location: ../top.php");
    exit;       
}   
if ($staff_id != null && Get_Id_Check_Db($db_con, $staff_id, "staff_id", "t_staff", "num") != true){
    header("Location: ../top.php");
    exit;
}

/* �����ѹ��Բ�ǽ�ե饰���ǧ */
if ($staff_id != null){
    $sql = "SELECT h_change_flg FROM t_staff WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $h_change_ng_flg = (pg_fetch_result($res, 0) == "t") ? true : false;
}

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
/*** ���������å����ܤ�������� ***/
if ($_POST["form_staff_kind"] == "1"){
    $type = "fc";
}else
if ($_POST["form_staff_kind"] == "4"){
    $type = "head";
}
$ary_mod_data = Permit_Item($type);
$ary_h_mod_data = $ary_mod_data[0];

/*** ���������å��ܥå������ǤθĿ����� ***/
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

// rowspan����
$h_rowspan = 0;
for ($i=0; $i<count($ary_h[2]); $i++){
    $h_rowspan++;
    $h_menu_rowspan[$i] = count($ary_h[2][$i]) + array_sum($ary_h[2][$i]);
    for ($j=0; $j<count($ary_h[2][$i]); $j++){
        $h_rowspan++;
        $h_rowspan += $ary_h[2][$i][$j];
    }
}
$h_submenu_rowspan = $ary_h[2];

$ary_opt  = array("r", "w", "n");
for ($i=0; $i<count($ary_opt); $i++){

    // �����ȥåץ����å�
    // // js����2��������
    // // [0]: ������FC��
    // // [1]: ��˥塼���������
    // // [2]: ��˥塼��Υ��֥�˥塼���������
    // // [3]: ��˥塼��Υ��֥�˥塼��ι��ܿ��������
    $js_opt_h  = "['h', ".$ary_h[0].", ";
    foreach ($ary_h[1] as $key => $value){
        $js_opt_h .= ($key == 0) ? "[" : null;
        $js_opt_h .= $value;
        $js_opt_h .= ($ary_h[0]-1 != $key) ? ", " : "], ";
    }
    foreach ($ary_h[2] as $key1 => $value1){
        $js_opt_h .= ($key1 == 0) ? "[" : null;
        foreach ($value1 as $key2 => $value2){
            $js_opt_h .= ($key2 == 0) ? "[" : null;
            $js_opt_h .= $value2;
            $js_opt_h .= ($ary_h[1][$key1]-1 != $key2) ? ", " : "]";
        }
        $js_opt_h .= (count($ary_h[1])-1 != $key1) ? ", " : "]";
    }
    $js_opt_h .= ", '".$ary_opt[$i]."']";
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[h][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[h][0][0][0][".$ary_opt[$i]."]', $js_opt_h);\"");
    }else{
        $form->addElement("hidden", "permit[h][0][0][0][".$ary_opt[$i]."]", "");
    }

    // ������˥塼�����å�
    // // js����2��������
    // // [0]: ������FC��
    // // [1]: ��˥塼�ֹ�
    // // [2]: ���֥�˥塼���������
    // // [3]: ���֥�˥塼��ι��ܿ��������
    if ($ary_opt[$i] != "n"){
        foreach ($ary_h[2] as $key1 => $value1){
            $num = (int)$key1+1;
            $js_opt_sub = null;
            foreach ($value1 as $key2 => $value2){
                $js_opt_sub .= (count($value1)-1 != $key2) ? "$value2, " : "$value2";
            }
            $form->addElement("checkbox", "permit[h][".$num."][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][".$num."][0][0][".$ary_opt[$i]."]', ['h', ".$num.", ".$ary_h[1][$key1].", [".$js_opt_sub."], '".$ary_opt[$i]."']);\"");
        }
    }else{
        foreach ($ary_h[2] as $key => $value){
            $num = (int)$key+1;
            $form->addElement("hidden", "permit[h][".$num."][0][0][".$ary_opt[$i]."]", "");
        }
    }
}

$ary_opt  = array("r", "w", "n");
// �������֥�˥塼�ʲ������å�
for ($i=1; $i<=$ary_h[0]; $i++){
    for ($j=1; $j<=$ary_h[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_h[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[h][$i][$j][$k][$ary_opt[$l]]";
                if ($ary_opt[$l] != "n"){
                    if ($k == 0){
                        $js = "onClick=\"javascript: Allcheck_Submenu2('$me', ['h', $i, $j, ".$ary_h[2][$i-1][$j-1].", '$ary_opt[$l]']);\"";
                    }else{
                        $js = null;
                    }
                    $form->addElement("checkbox", $me, "", "", $js);
                }else{
                    $form->addElement("hidden", $me, "");
                }
            }
        }
    }
}

/*** FC�����å����ܤ�������� ***/
$ary_f_mod_data = $ary_mod_data[1];

/*** FC�����å��ܥå������ǤθĿ����� ***/
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

// rowspan����
$f_rowspan = 0;
for ($i=0; $i<count($ary_f[2]); $i++){
    $f_rowspan++;
    $f_menu_rowspan[$i] = count($ary_f[2][$i]) + array_sum($ary_f[2][$i]);
    for ($j=0; $j<count($ary_f[2][$i]); $j++){
        $f_rowspan++;
        $f_rowspan += $ary_f[2][$i][$j];
    }
}
$f_submenu_rowspan = $ary_f[2];


$ary_opt  = array("r", "w", "n");
for ($i=0; $i<count($ary_opt); $i++){

    // FC�ȥåץ����å�
    // // js����2��������
    // // [0]: ������FC��
    // // [1]: ��˥塼���������
    // // [2]: ��˥塼��Υ��֥�˥塼���������
    // // [3]: ��˥塼��Υ��֥�˥塼��ι��ܿ��������
    $js_opt_f  = "['f', ".$ary_f[0].", ";
    foreach ($ary_f[1] as $key => $value){
        $js_opt_f .= ($key == 0) ? "[" : null;
        $js_opt_f .= $value;
        $js_opt_f .= ($ary_f[0]-1 != $key) ? ", " : "], ";
    }
    foreach ($ary_f[2] as $key1 => $value1){
        $js_opt_f .= ($key1 == 0) ? "[" : null;
        foreach ($value1 as $key2 => $value2){
            $js_opt_f .= ($key2 == 0) ? "[" : null;
            $js_opt_f .= $value2;
            $js_opt_f .= ($ary_f[1][$key1]-1 != $key2) ? ", " : "]";
        }
        $js_opt_f .= (count($ary_f[1])-1 != $key1) ? ", " : "]";
    }
    $js_opt_f .= ", '".$ary_opt[$i]."']";
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[f][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[f][0][0][0][".$ary_opt[$i]."]', $js_opt_f);\"");
    }else{
        $form->addElement("hidden", "permit[f][0][0][0][".$ary_opt[$i]."]", "");
    }

    // FC��˥塼�����å�
    // // js����2��������
    // // [0]: ������FC��
    // // [1]: ��˥塼�ֹ�
    // // [2]: ���֥�˥塼���������
    // // [3]: ���֥�˥塼��ι��ܿ��������
    if ($ary_opt[$i] != "n"){
        foreach ($ary_f[2] as $key1 => $value1){
            $num = (int)$key1+1;
            $js_opt_sub = null;
            foreach ($value1 as $key2 => $value2){
                $js_opt_sub .= (count($value1)-1 != $key2) ? "$value2, " : "$value2";
            }
            $form->addElement("checkbox", "permit[f][".$num."][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][".$num."][0][0][".$ary_opt[$i]."]', ['f', ".$num.", ".$ary_f[1][$key1].", [".$js_opt_sub."], '".$ary_opt[$i]."']);\"");
        }
    }else{
        foreach ($ary_f[2] as $key => $value){
            $num = (int)$key+1;
            $form->addElement("hidden", "permit[f][".$num."][0][0][".$ary_opt[$i]."]", "");
        }
    }
}

$ary_opt  = array("r", "w", "n");
// FC���֥�˥塼�ʲ������å�
for ($i=1; $i<=$ary_f[0]; $i++){
    for ($j=1; $j<=$ary_f[1][$i-1]; $j++){
        for ($k=0; $k<=$ary_f[2][$i-1][$j-1]; $k++){
            for ($l=0; $l<count($ary_opt); $l++){
                $me = "permit[f][$i][$j][$k][$ary_opt[$l]]";
                if ($ary_opt[$l] != "n"){
                    if ($k == 0){
                        $js = "onClick=\"javascript: Allcheck_Submenu2('$me', ['f', $i, $j, ".$ary_f[2][$i-1][$j-1].", '$ary_opt[$l]']);\"";
                    }else{
                        $js = null;
                    }
                    $form->addElement("checkbox", $me, "", "", $js);
                }else{
                    $form->addElement("hidden", $me, "");
                }
            }
        }
    }
}

// ������¤���Ϳ��������å�
$form->addElement("checkbox", "permit_delete", "", "");

// ��ǧ���¤���Ϳ��������å�
$form->addElement("checkbox", "permit_accept", "", "");

// ����ܥ���
if ($h_change_ng_flg != true){
    $form->addElement("submit", "form_set_button", "�ߡ���", "
        onClick=\"javascript:Button_Submit_1('set_permit_flg', './1-1-109.php?staff_id=$staff_id', 'true', this);\"
        $disabled
    ");
}

// ���ܥ���
$form->addElement("button", "form_return_button", "�ᡡ��", "
    onClick=\"javascript:Button_Submit_1('permit_rtn_flg', './1-1-109.php?staff_id=$staff_id', 'true', this);\"
");

$form->addElement("hidden", "set_permit_flg");
$form->addElement("hidden", "permit_rtn_flg");


/****************************/
// �ե�����ѡ������ - �����åեޥ���
/****************************/
$form->addElement("hidden", "form_staff_kind", "");
$form->addElement("hidden", "form_cshop_head", "");
$form->addElement("hidden", "form_cshop", "");
$form->addElement("hidden", "form_state", "");
$form->addElement("hidden", "form_change_flg", "");
$form->addElement("hidden", "form_staff_cd[cd1]", "");
$form->addElement("hidden", "form_staff_cd[cd2]", "");
$form->addElement("hidden", "form_staff_name", "");
$form->addElement("hidden", "form_photo_ref", "");
$form->addElement("hidden", "form_photo_del", "");
$form->addElement("hidden", "form_staff_read", "");
$form->addElement("hidden", "form_staff_ascii", "");
$form->addElement("hidden", "form_sex", "");
$form->addElement("hidden", "form_birth_day[y]", "");
$form->addElement("hidden", "form_birth_day[m]", "");
$form->addElement("hidden", "form_birth_day[d]", "");
$form->addElement("hidden", "form_retire_day[y]", "");
$form->addElement("hidden", "form_retire_day[m]", "");
$form->addElement("hidden", "form_retire_day[d]", "");
$form->addElement("hidden", "form_study", "");
$form->addElement("hidden", "form_toilet_license", "");
$form->addElement("hidden", "form_charge_cd", "");
$form->addElement("hidden", "form_join_day[y]", "");
$form->addElement("hidden", "form_join_day[m]", "");
$form->addElement("hidden", "form_join_day[d]", "");
$form->addElement("hidden", "form_employ_type", "");
$form->addElement("hidden", "form_part_head", "");
$form->addElement("hidden", "form_part[0]", "");
$form->addElement("hidden", "form_part[1]", "");
$form->addElement("hidden", "form_section_head", "");
$form->addElement("hidden", "form_section", "");
$form->addElement("hidden", "form_position", "");
$form->addElement("hidden", "form_job_type", "");
$form->addElement("hidden", "form_ware_head", "");
$form->addElement("hidden", "form_ware", "");
$form->addElement("hidden", "form_license", "");
$form->addElement("hidden", "form_note", "");
$form->addElement("hidden", "form_login_info", "");
$form->addElement("hidden", "form_login_id", "");
$form->addElement("hidden", "form_password1", "");
$form->addElement("hidden", "form_password2", "");
$form->addElement("hidden", "form_round_staff", "");
$form->addElement("hidden", "hdn_staff_id");


/****************************/
// �ե�����ǥե����������
/****************************/
// �����å�IDͭ�ܸ��¤������
if ($_GET["staff_id"] != null && $_POST["form_set_button"] == null && $_POST["set_permit_flg"] != "true"){
    $sql = "SELECT * FROM t_permit WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $ary_permit_data = (pg_num_rows($res) != 0) ? pg_fetch_array($res, 0, PGSQL_ASSOC) : null;

    $permit_col = Permit_Col("head");

    if ($ary_permit_data != null){
        $ary_type = array("h", "f");
        while (List($key, $value) = Each($ary_permit_data)){
            for ($i=0; $i<count($ary_type); $i++){
                for ($j=1; $j<=count($permit_col[$ary_type[$i]]); $j++){
                    for ($k=1; $k<=count($permit_col[$ary_type[$i]][$j]); $k++){
                        for ($l=0; $l<count($permit_col[$ary_type[$i]][$j][$k]); $l++){
                            if (in_array($key, $permit_col[$ary_type[$i]][$j][$k][$l])){
                                $def_fdata["permit"][$ary_type[$i]][$j][$k][$l][$value] = true;
                            }
                        }
                    }
                }
            }
        }
        $def_fdata["permit_delete"] = ($ary_permit_data["del_flg"] == "t") ? true : false;
        $def_fdata["permit_accept"] = ($ary_permit_data["accept_flg"] == "t") ? true : false;
        $form->setConstants($def_fdata);

    }

}


/****************************/
// �����ˤ���ѹ����ԲĤΥ����åդξ��ϥե꡼��
/****************************/
if ($h_change_ng_flg == true){
    $form->freeze();
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
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/
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
    'js_data'       => "$js_data",
    'charge_cd'     => stripslashes(htmlspecialchars($charge_cd)),
    'staff_name'    => stripslashes(htmlspecialchars($staff_name)),
    'auth_r_msg'    => "$auth_r_msg",
    'h_rowspan'         => $h_rowspan,
    'h_menu_rowspan'    => $h_menu_rowspan,
    'h_submenu_rowspan' => $h_submenu_rowspan,
    'f_rowspan'         => $f_rowspan,
    'f_menu_rowspan'    => $f_menu_rowspan,
    'f_submenu_rowspan' => $f_submenu_rowspan,
));

$smarty->assign("ary_h_mod_data", $ary_h_mod_data);
$smarty->assign("ary_f_mod_data", $ary_f_mod_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
