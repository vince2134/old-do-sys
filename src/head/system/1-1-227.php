<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0077    suzuki      ���˻Ĥ��ޥ���̾�ѹ�
 *  2006-12-11      ban_0137    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *   2016/01/20                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�     
 *  
 *
*/

$page_title = "FC��������ʬ�ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
if($_GET["rank_cd"] != null){
    $get_rank_cd = "'".$_GET["rank_cd"]."'";
}

/* GET����ID�������������å� */
if ($_GET["rank_cd"] != null && Get_Id_Check_Db($conn, $_GET["rank_cd"], "rank_cd", "t_rank", "str", " disp_flg = 't' ") != true){
//    header("Location: ../top.php");
}

/****************************/
//����ͤ����
/****************************/
if($get_rank_cd != null){
    $sql  = "SELECT";
    $sql .= "   rank_cd,";
    $sql .= "   rank_name,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_rank";
    $sql .= " WHERE";
    $sql .= "   rank_cd = $get_rank_cd";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_rank_cd"]       = pg_fetch_result($result,0,0);
    $def_rank_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_rank_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_rank_note"]     = pg_fetch_result($result,0,2);
    $def_data["update_flg"]         = true;
    $form->setDefaults($def_data);
}

/*****************************/
//���֥������Ⱥ���
/*****************************/
//FC��������ʬ������
$form->addElement("text","form_rank_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//FC��������ʬ̾
$form->addElement("text","form_rank_name","","size=\"22\" maxLength=\"15\"".$g_form_option."\"");

//�ܥ���
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//����
$form->addElement("text","form_rank_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");

/****************************/
//�롼�����
/****************************/
//FC��������ʬ������
$form->addRule("form_rank_cd", "FC��������ʬ�����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���","required");
$form->addRule("form_rank_cd", "FC��������ʬ�����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���", "regex", "/^[0-9]+$/");

//FC��������ʬ̾
$form->addRule("form_rank_name", "FC��������ʬ̾��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_rank_name", "FC��������ʬ̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $rank_cd        = $_POST["form_rank_cd"];                                   //FC��������ʬCD
    $rank_name      = $_POST["form_rank_name"];                                 //FC��������ʬ̾
    $rank_note      = $_POST["form_rank_note"];                                 //����
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //FC��������ʬ����������
    /***************************/
    $rank_cd = str_pad($rank_cd, 4, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   rank_cd";
    $sql .= " FROM";
    $sql .= "   t_rank";
    $sql .= " WHERE";
    $sql .= "   rank_cd = '$rank_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //���ѺѤߥ��顼
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_rank_cd != $rank_cd))){
        $form->setElementError("form_rank_cd","���˻��Ѥ���Ƥ��� FC��������ʬ������ �Ǥ���");
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

            $insert_sql  = "INSERT INTO t_rank(";
            $insert_sql .= "    rank_cd,";
            $insert_sql .= "    rank_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    disp_flg";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    '$rank_cd',";
            $insert_sql .= "    '$rank_name',";
            $insert_sql .= "    '$rank_note',";
            $insert_sql .= "    't'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "rank", "1", $rank_cd, $rank_name);
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
            $insert_sql .= "    t_rank";
            $insert_sql .= " SET";
            $insert_sql .= "    rank_cd = '$rank_cd',";
            $insert_sql .= "    rank_name = '$rank_name',";
            $insert_sql .= "    note = '$rank_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    rank_cd = $get_rank_cd";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "rank", "2", $rank_cd, $rank_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_rank_cd"]       = "";                                   //FC��������ʬCD
        $set_data["form_rank_name"]     = "";                                 //FC��������ʬ̾
        $set_data["form_rank_note"]     = "";                                 //����
        $set_data["update_flg"]         = "";

        $form->setConstants($set_data);
    }
}

/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   rank_cd,";
$sql .= "   rank_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_rank";
$sql .= " WHERE";
$sql .= "   disp_flg = 't'";
$sql .= "   ORDER BY t_rank.rank_cd";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT";
	$sql .= "   rank_cd,";
	$sql .= "   rank_name,";
	$sql .= "   note";
	$sql .= " FROM";
	$sql .= "   t_rank";
	$sql .= " WHERE";
	$sql .= "   disp_flg = 't'";
	$sql .= "   ORDER BY t_rank.rank_cd";
	$sql .= ";"; 

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV����
    $csv_file_name = "FC��������ʬ�ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "FC��������ʬ������",
        "FC��������ʬ̾",
        "����"
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($page_data, $csv_header);
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
	'total_count'    => "$total_count",
    'message'       => "$message",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign('page_data',$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
