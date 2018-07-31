<?php
$page_title = "�桼����������";

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

/****************************/
// �ե�����ѡ��ĺ���
/****************************/
/*** ���������å����ܤ�������� ***/
$ary_h_mod_data = array(
    "0" =>  array(
        "0" =>  "������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "������",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "�������������",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "�����",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "5" =>  array(
                "0" =>  "���Ӵ���",
                "1" =>  array(),
            ),
        ),
    ),
    "1" =>  array(
        "0" =>  "��������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "ȯ����",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "��ʧ����",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "���Ӵ���",
                "1" =>  array(),
            ),
        ),
    ),  
    "2" =>  array(
        "0" =>  "�߸˴���",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "�߸˼��",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "ê������",
                "1" =>  array(),
            ),
        ),
    ),
    "3" =>  array(
        "0" =>  "����",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "��������",
                "1" =>  array(),
            ),
        ),
    ),
    "4" =>  array(
        "0" =>  "�ǡ�������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "���׾���",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "�����",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "ABCʬ��",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "CSV����",
                "1" =>  array(),
            ),
        ),
    ),
    "5" =>  array(
        "0" =>  "�ޥ���������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "���������ޥ���",
                "1" =>  array("�ȼ�", "����", "����", "�����ӥ�", "������",),
            ),
            "1" =>  array(
                "0" =>  "������ͭ�ޥ���",
                "1" =>  array("�����å�", "�Ͷ�ʬ", "������ʬ", "����ʬ��", "����",),
            ),  
            "2" =>  array(
                "0" =>  "���̥ޥ���",
                "1" =>  array("����", "�Ҹ�", "�϶�", "���", "��¤��", "FC��ʬ", "FC", "������", "����", "������", "ľ����", "�����ȼ�",),
            ),
            "3" =>  array(
                "0" =>  "Ģɼ����",
                "1" =>  array(
                    "ȯ��񥳥���", "��ʸ��ե����ޥå�", "�����ɼ", "Ǽ�ʽ�", "�����",),
            ),
            "4" =>  array(
                "0" =>  "�����ƥ�����",
                "1" =>  array("�����ץ�ե�����", "��ݻĹ�������", "��ݻĹ�������", "����Ĺ�������", "�ѥ�����ѹ�",),
            ),
        ),
    ),
);

/*** ���������å��ܥå������ǤθĿ����� ***/
// ��˥塼��
$ary_h[0] = 6;
// �ƥ�˥塼��Υ��֥�˥塼��
$ary_h[1] = array(6, 4, 2, 1, 5, 5);
// �ƥ��֥�˥塼��Υ����å��ܥå�����
$ary_h[2] = array(
    0 => array(0, 0, 0, 0, 0, 0),
    1 => array(0, 0, 0, 0),
    2 => array(0, 0),
    3 => array(0),
    4 => array(0, 0, 0, 0, 0),
    5 => array(5, 5, 12, 5, 5),
);

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
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[h][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[h][0][0][0][".$ary_opt[$i]."]', ['h', 6, [6, 4, 2, 1, 5, 5], [[0, 0, 0, 0, 0, 0], [0, 0, 0, 0], [0, 0], [0], [0, 0, 0, 0, 0], [5, 5, 12, 5, 5]], '".$ary_opt[$i]."']);\"");
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
        $form->addElement("checkbox", "permit[h][1][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][1][0][0][".$ary_opt[$i]."]', ['h', 1, 6, [0, 0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][2][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][2][0][0][".$ary_opt[$i]."]', ['h', 2, 4, [0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][3][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][3][0][0][".$ary_opt[$i]."]', ['h', 3, 2, [0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][4][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][4][0][0][".$ary_opt[$i]."]', ['h', 4, 1, [0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][5][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][5][0][0][".$ary_opt[$i]."]', ['h', 5, 5, [0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[h][6][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[h][6][0][0][".$ary_opt[$i]."]', ['h', 6, 5, [5, 5, 12, 5, 5], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[h][1][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][2][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][3][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][4][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][5][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[h][6][0][0][".$ary_opt[$i]."]", "");
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
$ary_f_mod_data = array(
    "0" =>  array(
        "0" =>  "������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "ͽ����",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "�����",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "���Ӵ���",
                "1" =>  array(),
            ),
        ),
    ),
    "1" =>  array(
        "0" =>  "��������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "ȯ����",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "��ʧ����",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "���Ӵ���",
                "1" =>  array(),
            ),
        ),
    ),
    "2" =>  array(
        "0" =>  "�߸˴���",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "�߸˼��",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "ê������",
                "1" =>  array(),
            ),
        ),
    ),
    "3" =>  array(
        "0" =>  "����",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "��������",
                "1" =>  array(),
            ),
        ),
    ),
    "4" =>  array(
        "0" =>  "�ǡ�������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "���׾���",
                "1" =>  array(),
            ),
            "1" =>  array(
                "0" =>  "�����",
                "1" =>  array(),
            ),
            "2" =>  array(
                "0" =>  "ABCʬ��",
                "1" =>  array(),
            ),
            "3" =>  array(
                "0" =>  "�������",
                "1" =>  array(),
            ),
            "4" =>  array(
                "0" =>  "CSV����",
                "1" =>  array(),
            ),
        ),
    ),
    "5" =>  array(
        "0" =>  "�ޥ���������",
        "1" =>  array(
            "0" =>  array(
                "0" =>  "���̥ޥ���",
                "1" =>  array("����", "�Ҹ�", "�϶�", "���", "������", "������", "����", "������", "ľ����", "�����ȼ�",),
            ),
            "1" =>  array(
                "0" =>  "������ͭ�ޥ���",
                "1" =>  array("�����å�", "�Ͷ�ʬ", "������ʬ", "����ʬ��", "����",),
            ),
            "2" =>  array(
                "0" =>  "Ģɼ����",
                "1" =>  array("ȯ��񥳥���", "�����ɼ", "�����",),
            ),
            "3" =>  array(
                "0" =>  "�����ƥ�����",
                "1" =>  array("���ҥץ�ե�����", "��ݻĹ�������", "��ݻĹ�������", "����Ĺ�������", "�ѥ�����ѹ�", "��������",),
            ),
            "4" =>  array(
                "0" =>  "���������ޥ���",
                "1" =>  array("�ȼ�", "����", "����", "�����ӥ�", "������",),
            ),
        ),
    ),
);


/*** FC�����å��ܥå������ǤθĿ����� ***/
// ��˥塼��
$ary_f[0] = 6;
// �ƥ�˥塼��Υ��֥�˥塼��
$ary_f[1] = array(5, 4, 2, 1, 5, 5);
// �ƥ��֥�˥塼��Υ����å��ܥå�����
$ary_f[2] = array(
    0 => array(0, 0, 0, 0, 0),
    1 => array(0, 0, 0, 0),
    2 => array(0, 0),
    3 => array(0),
    4 => array(0, 0, 0, 0, 0),
    5 => array(10, 5, 3, 6, 5)
);

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
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[f][0][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Top2('permit[f][0][0][0][".$ary_opt[$i]."]', ['f', 6, [5, 4, 2, 1, 5, 5], [[0, 0, 0, 0, 0], [0, 0, 0, 0], [0, 0], [0], [0, 0, 0, 0, 0], [10, 5, 3, 6, 5]], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[f][0][0][0][".$ary_opt[$i]."]", "");
    }

    // FC��˥塼�����å�
    if ($ary_opt[$i] != "n"){
        $form->addElement("checkbox", "permit[f][1][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][1][0][0][".$ary_opt[$i]."]', ['f', 1, 5, [0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][2][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][2][0][0][".$ary_opt[$i]."]', ['f', 2, 4, [0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][3][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][3][0][0][".$ary_opt[$i]."]', ['f', 3, 2, [0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][4][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][4][0][0][".$ary_opt[$i]."]', ['f', 4, 1, [0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][5][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][5][0][0][".$ary_opt[$i]."]', ['f', 5, 5, [0, 0, 0, 0, 0], '".$ary_opt[$i]."']);\"");
        $form->addElement("checkbox", "permit[f][6][0][0][".$ary_opt[$i]."]", "", "", "onClick=\"javascript: Allcheck_Menu2('permit[f][6][0][0][".$ary_opt[$i]."]', ['f', 6, 5, [10, 5, 3, 6, 5], '".$ary_opt[$i]."']);\"");
    }else{
        $form->addElement("hidden", "permit[f][1][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][2][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][3][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][4][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][5][0][0][".$ary_opt[$i]."]", "");
        $form->addElement("hidden", "permit[f][6][0][0][".$ary_opt[$i]."]", "");
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
$form->addElement("submit", "form_set_button", "�ߡ���", "onClick=\"return Dialogue('���ꤷ�ޤ���','1-1-109-2.php?staff_id=$staff_id');\" $disabled");

// �����ܥ���
$form->addElement("button", "form_print_button", "������", "onClick=\"javascript:window.open('".HEAD_DIR."system/1-1-124.php','_blank','')\"");

// ���ܥ���
$form->addElement("button", "form_return_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");


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
$form->addElement("hidden", "form_part", "");
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


/****************************/
// �ե�����ǥե����������
/****************************/
// �����å�IDͭ�ܸ��¤������
if ($_GET["staff_id"] != null && $_POST["form_set_button"] == null){
    $sql = "SELECT * FROM t_permit WHERE staff_id = $staff_id;";
    $res = Db_Query($db_con, $sql);
    $ary_permit_data = (pg_num_rows($res) != 0) ? pg_fetch_array($res, 0, PGSQL_ASSOC) : null;

    /*** ���������¥����å�����<->���¥ơ��֥륫���̾ �б����� ***/
    /* ������ */
    // ������ - ������
    $permit_col["h"][1][1][0]   = array("h_2_101", "h_2_102", "h_2_103", "h_2_104", "h_2_105", "h_2_106", "h_2_107", "h_2_108", "h_2_109");
    // ������ - �������������
    $permit_col["h"][1][2][0]   = array(null);
    // ������ - �����
    $permit_col["h"][1][3][0]   = array("h_2_201", "h_2_202", "h_2_203", "h_2_205", "h_2_206", "h_2_207", "h_2_208");
    // ������ - �������
    $permit_col["h"][1][4][0]   = array("h_2_301", "h_2_302", "h_2_303", "h_2_304", "h_2_305", "h_2_306");
    // ������ - �������
    $permit_col["h"][1][5][0]   = array("h_2_401", "h_2_402", "h_2_403", "h_2_404", "h_2_406");
    // ������ - ���Ӵ���
    $permit_col["h"][1][6][0]   = array("h_2_501", "h_2_502", "h_2_503", "h_2_504");

    /* �������� */
    // �������� - ȯ����
    $permit_col["h"][2][1][0]   = array("h_3_101", "h_3_102", "h_3_104", "h_3_105", "h_3_106", "h_3_111");
    // �������� - �������
    $permit_col["h"][2][2][0]   = array("h_3_201", "h_3_202", "h_3_203", "h_3_205");
    // �������� - ��ʧ����
    $permit_col["h"][2][3][0]   = array("h_3_301", "h_3_302", "h_3_303", "h_3_304", "h_3_306");
    // �������� - ���Ӵ���
    $permit_col["h"][2][4][0]   = array("h_3_401", "h_3_402", "h_3_403", "h_3_404");

    /* �߸˴��� */
    // �߸˴��� - �߸˼��
    $permit_col["h"][3][1][0]   = array("h_4_101", "h_4_102", "h_4_104", "h_4_105", "h_4_106", "h_4_107", "h_4_108", "h_4_109", "h_4_110", "h_4_111", "h_4_112", "h_4_114");
    // �߸˴��� - ê������
    $permit_col["h"][3][2][0]   = array("h_4_201", "h_4_202", "h_4_204", "h_4_205", "h_4_206", "h_4_207", "h_4_208", "h_4_209");

    /* ���� */
    // ��������
    $permit_col["h"][4][1][0]   = array("h_5_101", "h_5_102", "h_5_103", "h_5_104", "h_5_105", "h_5_106", "h_5_107", "h_5_108", "h_5_109");

    /* �ǡ������� */
    // �ǡ������� - ���׾���
    $permit_col["h"][5][1][0]   = array("h_6_132", "h_6_131", "h_6_133", "h_6_135", "h_6_143");
    // �ǡ������� - �����
    $permit_col["h"][5][2][0]   = array("h_6_101", "h_6_103", "h_6_104", "h_6_105", "h_6_106", "h_6_107", "h_6_108");
    // �ǡ������� - ABCʬ��
    $permit_col["h"][5][3][0]   = array("h_6_110", "h_6_111", "h_6_112", "h_6_113", "h_6_114");
    // �ǡ������� - �������
    $permit_col["h"][5][4][0]   = array("h_6_121", "h_6_122");
    // �ǡ������� - CSV����
    $permit_col["h"][5][5][0]   = array("h_6_301", "h_6_302", "h_6_303");

    /* �ޥ������� */
    // �ޥ��������� - ���������ޥ���
    $permit_col["h"][6][1][0]   = array(null);
    $permit_col["h"][6][1][1]   = array("h_1_205");// �ȼ�
    $permit_col["h"][6][1][2]   = array("h_1_234");// ����
    $permit_col["h"][6][1][3]   = array("h_1_233");// ����
    $permit_col["h"][6][1][4]   = array("h_1_231", "h_1_232");// �����ӥ�
    $permit_col["h"][6][1][5]   = array("h_1_229", "h_1_230");// ������
    // �ޥ��������� - ������ͭ�ޥ���
    $permit_col["h"][6][2][0]   = array(null);
    $permit_col["h"][6][2][1]   = array("h_1_107", "h_1_108", "h_1_109", "h_1_110", "h_1_120", "h_1_124");// �����å�
    $permit_col["h"][6][2][2]   = array("h_1_211");// �Ͷ�ʬ
    $permit_col["h"][6][2][3]   = array("h_1_209");// ������ʬ
    $permit_col["h"][6][2][4]   = array(null);// ����ʬ��
    $permit_col["h"][6][2][5]   = array("h_1_220", "h_1_221", "h_1_222");// ����
    // �ޥ��������� - ���̥ޥ���
    $permit_col["h"][6][3][0]   = array(null);
    $permit_col["h"][6][3][1]   = array("h_1_201");// ����
    $permit_col["h"][6][3][2]   = array("h_1_203");// �Ҹ�
    $permit_col["h"][6][3][3]   = array("h_1_213");// �϶�
    $permit_col["h"][6][3][4]   = array("h_1_207", "h_1_208");// ���
    $permit_col["h"][6][3][5]   = array("h_1_223", "h_1_224");// ��¤��
    $permit_col["h"][6][3][6]   = array("h_1_227");// FC��ʬ
    $permit_col["h"][6][3][7]   = array("h_1_101", "h_1_102", "h_1_103");// FC
    $permit_col["h"][6][3][8]   = array("h_1_113", "h_1_114", "h_1_111", "h_1_115");// ������
    $permit_col["h"][6][3][9]   = array("h_1_116", "h_1_123", "h_1_104", "h_1_105", "h_1_119", "h_1_106", "h_1_112");// ����
    $permit_col["h"][6][3][10]  = array("h_1_215", "h_1_216", "h_1_217");// ������
    $permit_col["h"][6][3][11]  = array("h_1_218", "h_1_219");// ľ����
    $permit_col["h"][6][3][12]  = array("h_1_225");// �����ȼ�
    // �ޥ��������� - Ģɼ����
    $permit_col["h"][6][4][0]   = array(null);
    $permit_col["h"][6][4][1]   = array("h_1_303");// ȯ��񥳥���
    $permit_col["h"][6][4][2]   = array("h_1_304");// ��ʸ��ե����ޥå�
    $permit_col["h"][6][4][3]   = array("h_1_311");// �����ɼ
    $permit_col["h"][6][4][4]   = array("h_1_312");// Ǽ�ʽ�
    $permit_col["h"][6][4][5]   = array("h_1_310");// �����
    // �ޥ��������� - �����ƥ�����
    $permit_col["h"][6][5][0]   = array(null);
    $permit_col["h"][6][5][1]   = array("h_1_301");// �����ץ�ե�����
    $permit_col["h"][6][5][2]   = array("h_1_305");// ��ݻĹ�������
    $permit_col["h"][6][5][3]   = array("h_1_306");// ��ݻĹ�������
    $permit_col["h"][6][5][4]   = array("h_1_307");// ����Ĺ�������
    $permit_col["h"][6][5][5]   = array("h_1_302");// �ѥ�����ѹ�

    /*** FC�����¥����å�����<->���¥ơ��֥륫���̾ �б����� ***/
    /* ������ */
    // ������ - ͽ���� 
    $permit_col["f"][1][1][0]   = array("f_2_101", "f_2_102", "f_2_103", "f_2_115", "f_2_104", "f_2_106", "f_2_107", "f_2_108", "f_2_111", "f_2_112", "f_2_113", "f_2_114");
    // ������ - �����
    $permit_col["f"][1][2][0]   = array("f_2_201", "f_2_202", "f_2_204", "f_2_205", "f_2_206", "f_2_207", "f_2_208", "f_2_209", "f_2_210", "f_2_211", "f_2_212", "f_2_213", "f_2_214");
    // ������ - ������� 
    $permit_col["f"][1][3][0]   = array("f_2_301", "f_2_302", "f_2_303", "f_2_304", "f_2_305", "f_2_306");
    // ������ - ������� 
    $permit_col["f"][1][4][0]   = array("f_2_401", "f_2_402", "f_2_403", "f_2_404", "f_2_406");
    // ������ - ���Ӵ��� 
    $permit_col["f"][1][5][0]   = array("f_2_501", "f_2_502", "f_2_503", "f_2_504");

    /* �������� */
    // �������� - ȯ����
    $permit_col["f"][2][1][0]   = array("f_3_101", "f_3_102", "f_3_103", "f_3_104", "f_3_105", "f_3_107", "f_3_106", "f_3_111");
    // �������� - �������
    $permit_col["f"][2][2][0]   = array("f_3_201", "f_3_202", "f_3_203", "f_3_205");
    // �������� - ��ʧ����
    $permit_col["f"][2][3][0]   = array("f_3_301", "f_3_302", "f_3_303", "f_3_304", "f_3_306");
    // �������� - ���Ӵ���
    $permit_col["f"][2][4][0]   = array("f_3_401", "f_3_402", "f_3_403", "f_3_404");

    /* �߸˴��� */
    // �߸˴��� - �߸˼��
    $permit_col["f"][3][1][0]   = array("f_4_101", "f_4_102", "f_4_105", "f_4_106", "f_4_107", "f_4_108", "f_4_109", "f_4_110", "f_4_111", "f_4_113");
    // �߸˴��� - ê������
    $permit_col["f"][3][2][0]   = array("f_4_201", "f_4_202", "f_4_204", "f_4_205", "f_4_206", "f_4_207", "f_4_208", "f_4_209");

    /* ���� */
    // ���� - ��������
    $permit_col["f"][4][1][0]   = array("f_5_101", "f_5_102", "f_5_103", "f_5_104", "f_5_105", "f_5_106", "f_5_107", "f_5_108", "f_5_109");

    /* �ǡ������� */
    // �ǡ������� - ���׾���
    $permit_col["f"][5][1][0]   = array("f_6_132", "f_6_131", "f_6_135", "f_6_137", "f_6_151", "f_6_153");
    // �ǡ������� - �����
    $permit_col["f"][5][2][0]   = array("f_6_100", "f_6_101", "f_6_103", "f_6_104", "f_6_106", "f_6_108");
    // �ǡ������� - ABCʬ��
    $permit_col["f"][5][3][0]   = array("f_6_110", "f_6_112", "f_6_114");
    // �ǡ������� - �������
    $permit_col["f"][5][4][0]   = array("f_6_121", "f_6_122");
    // �ǡ������� - CSV����
    $permit_col["f"][5][5][0]   = array("f_6_201", "f_6_202", "f_6_203");

    /* �ޥ��������� */
    // �ޥ��������� - ���̥ޥ���
    $permit_col["f"][6][1][0]   = array(null);
    $permit_col["f"][6][1][1]   = array("f_1_201");// ����
    $permit_col["f"][6][1][2]   = array("f_1_203");// �Ҹ�
    $permit_col["f"][6][1][3]   = array("f_1_213");// �϶�
    $permit_col["f"][6][1][4]   = array("f_1_207", "f_1_208");// ���
    $permit_col["f"][6][1][5]   = array("f_1_227");// ������
    $permit_col["f"][6][1][6]   = array("f_1_101", "f_1_102", "f_1_103", "f_1_106");// ������
    $permit_col["f"][6][1][7]   = array("f_1_111", "f_1_115", "f_1_104", "f_1_105", "f_1_114");// ����
    $permit_col["f"][6][1][8]   = array("f_1_215", "f_1_216", "f_1_217");// ������
    $permit_col["f"][6][1][9]   = array("f_1_218", "f_1_219");// ľ����
    $permit_col["f"][6][1][10]  = array("f_1_225");// �����ȼ�
    // �ޥ��������� - ������ͭ�ޥ���
    $permit_col["f"][6][2][0]   = array(null);
    $permit_col["f"][6][2][1]   = array("f_1_107", "f_1_108", "f_1_110", "f_1_112", "f_1_124");// �����å�
    $permit_col["f"][6][2][2]   = array("f_1_211");// �Ͷ�ʬ
    $permit_col["f"][6][2][3]   = array(null);// ������ʬ
    $permit_col["f"][6][2][4]   = array(null);// ����ʬ��
    $permit_col["f"][6][2][5]   = array("f_1_220", "f_1_221", "f_1_222");// ����
    // �ޥ��������� - Ģɼ����
    $permit_col["f"][6][3][0]   = array(null);
    $permit_col["f"][6][3][1]   = array("f_1_303");// ȯ��񥳥���
    $permit_col["f"][6][3][2]   = array("f_1_308");// �����ɼ
    $permit_col["f"][6][3][3]   = array("f_1_307");// �����
    // �ޥ��������� - �����ƥ�����
    $permit_col["f"][6][4][0]   = array(null);
    $permit_col["f"][6][4][1]   = array("f_1_301");// ���ҥץ�ե�����
    $permit_col["f"][6][4][2]   = array("f_1_304");// ��ݻĹ�������
    $permit_col["f"][6][4][3]   = array("f_1_305");// ��ݻĹ�������
    $permit_col["f"][6][4][4]   = array("f_1_306");// ����Ĺ�������
    $permit_col["f"][6][4][5]   = array("f_1_302");// �ѥ�����ѹ�
    $permit_col["f"][6][4][6]   = array(null);// ��������
    // �ޥ��������� - ���������ޥ���
    $permit_col["f"][6][5][0]   = array(null);
    $permit_col["f"][6][5][1]   = array("f_1_231");// �ȼ�
    $permit_col["f"][6][5][2]   = array("f_1_234");// ����
    $permit_col["f"][6][5][3]   = array("f_1_233");// ����
    $permit_col["f"][6][5][4]   = array(null);// �����ӥ�
    $permit_col["f"][6][5][5]   = array(null);// ������

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
    'charge_cd'     => "$charge_cd",
    'staff_name'    => "$staff_name",
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
