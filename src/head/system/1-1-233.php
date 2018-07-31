<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0070    suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *  2006-12-11      ban_0131    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *   2016/01/20                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�    
 *  
 *
*/

$page_title = "���ߥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//GET�ǡ�������
/****************************/
$get_inst_id = $_GET["inst_id"];

/* GET����ID�������������å� */
if ($_GET["inst_id"] != null && Get_Id_Check_Db($conn, $_GET["inst_id"], "inst_id", "t_inst", "num") != true){
    header("Location: ../top.php");
}

/****************************/
//����ͤ����
/****************************/
if($get_inst_id != null){
    $sql  = "SELECT";
    $sql .= "   inst_cd,";
    $sql .= "   inst_name,";
    $sql .= "   note,";
    $sql .= "   accept_flg ";
    $sql .= " FROM";
    $sql .= "   t_inst";
    $sql .= " WHERE";
    $sql .= "   inst_id = $get_inst_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_inst_cd"]       = pg_fetch_result($result,0,0);
    $def_inst_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_inst_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_inst_note"]     = pg_fetch_result($result,0,2);
    $def_data["form_accept"]        = pg_fetch_result($result,0,3);
    $def_data["update_flg"]         = true;
}else{
    $def_data["form_accept"]        = "2";
}
$form->setDefaults($def_data);

/*****************************/
//���֥������Ⱥ���
/*****************************/
//���ߥ�����
$form->addElement("text","form_inst_cd","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"".$g_form_option."\"");
//����̾
$form->addElement("text","form_inst_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//��ǧ�饸���ܥ���
$form_accept[] =& $form->createElement("radio", null, null, "��ǧ��", "1");
$form_accept[] =& $form->createElement("radio", null, null, "̤��ǧ", "2");
$form->addGroup($form_accept, "form_accept", "");

//�ܥ���
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//����
$form->addElement("text","form_inst_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");
/****************************/
//�롼�����
/****************************/
//���ߥ�����
$form->addRule("form_inst_cd", "���ߥ����ɤ�Ⱦ�ѿ����Τ�3��Ǥ���","required");
$form->addRule("form_inst_cd", "���ߥ����ɤ�Ⱦ�ѿ����Τ�3��Ǥ���", "regex", "/^[0-9]+$/");

//����̾
$form->addRule("form_inst_name", "����̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_inst_name", "����̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $inst_cd        = $_POST["form_inst_cd"];                                   //����CD
    $inst_name      = $_POST["form_inst_name"];                                 //����̾
    $inst_note      = $_POST["form_inst_note"];                                 //����
    $accept         = $_POST["form_accept"];
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //���ߥ���������
    /***************************/
    $inst_cd = str_pad($inst_cd, 3, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   inst_cd";
    $sql .= " FROM";
    $sql .= "   t_inst";
    $sql .= " WHERE";
    $sql .= "   inst_cd = '$inst_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //���ѺѤߥ��顼
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_inst_cd != $inst_cd))){
        $form->setElementError("form_inst_cd","���˻��Ѥ���Ƥ��� ���ߥ����� �Ǥ���");
    }

    /***************************/
    //����  
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //��Ͽ����
        /*****************************/
        if($update_flg != true){

            $message = "��Ͽ���ޤ�����";

            $insert_sql  = "INSERT INTO t_inst(";
            $insert_sql .= "    inst_id,";
            $insert_sql .= "    inst_cd,";
            $insert_sql .= "    inst_name,";
            $insert_sql .= "    note, ";
            $insert_sql .= "    accept_flg ";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(inst_id), 0)+1 FROM t_inst),";
            $insert_sql .= "    '$inst_cd',";
            $insert_sql .= "    '$inst_name',";
            $insert_sql .= "    '$inst_note', ";
            $insert_sql .= "    '$accept' ";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "inst", "1", $inst_cd, $inst_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*******************************/
        //�ѹ�����
        /*******************************/
        }elseif($update_flg == true){
            $message = "�ѹ����ޤ�����";

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_inst";
            $insert_sql .= " SET";
            $insert_sql .= "    inst_cd = '$inst_cd',";
            $insert_sql .= "    inst_name = '$inst_name',";
            $insert_sql .= "    note = '$inst_note', ";
            $insert_sql .= "    accept_flg = '$accept' ";
            $insert_sql .= " WHERE";
            $insert_sql .= "    inst_id = $get_inst_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
   
            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "inst", "2", $inst_cd, $inst_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_inst_cd"]       = "";                                   //����CD
        $set_data["form_inst_name"]     = "";                                 //����̾
        $set_data["form_inst_note"]     = "";                                 //����
        $set_data["form_accept"]        = "2";
        $set_data["update_flg"]         = "";

        $form->setConstants($set_data);

    }
}

/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   inst_cd,";
$sql .= "   inst_id,";
$sql .= "   inst_name,";
$sql .= "   note,";
$sql .= "   accept_flg ";
$sql .= " FROM";
$sql .= "   t_inst";
$sql .= "   ORDER BY t_inst.inst_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT";
	$sql .= "   inst_cd,";
	$sql .= "   inst_id,";
	$sql .= "   inst_name,";
	$sql .= "   note,";
	$sql .= "   accept_flg ";
	$sql .= " FROM";
	$sql .= "   t_inst";
	$sql .= "   ORDER BY t_inst.inst_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][2] = $page_data[$i][2];
        $csv_page_data[$i][3] = $page_data[$i][3];
        $csv_page_data[$i][4] = ($page_data[$i][4] == "1") ? "��" : "��";
    }

    $csv_file_name = "���ߥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "���ߥ�����",
        "����̾",
        "����",
        "��ǧ"
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
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
$page_title .= "(��".$total_count."��)";
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
    'message'       => "$message",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign("page_data",$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
