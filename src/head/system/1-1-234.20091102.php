<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0069    suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *  2006-12-11      ban_0130    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  
 *  
 *
*/

$page_title = "���֥ޥ���";

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
$get_bstruct_id = $_GET["bstruct_id"];

/* GET����ID�������������å� */
if ($_GET["bstruct_id"] != null && Get_Id_Check_Db($conn, $_GET["bstruct_id"], "bstruct_id", "t_bstruct", "num") != true){
    header("Location: ../top.php");
}

/****************************/
//����ͤ����
/****************************/
if($get_bstruct_id != null){
    $sql  = "SELECT";
    $sql .= "   bstruct_cd,";
    $sql .= "   bstruct_name,";
    $sql .= "   note,";
    $sql .= "   accept_flg";
    $sql .= " FROM";
    $sql .= "   t_bstruct";
    $sql .= " WHERE";
    $sql .= "   bstruct_id = $get_bstruct_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_bstruct_cd"]       = pg_fetch_result($result,0,0);
    $def_bstruct_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_bstruct_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_bstruct_note"]     = pg_fetch_result($result,0,2);
    $def_data["form_accept"]       = pg_fetch_result($result,0,3);
    $def_data["update_flg"]            = true;
}else{
    $def_data["form_accept"]           = "2";
}

$form->setDefaults($def_data);

/*****************************/
//���֥������Ⱥ���
/*****************************/
//���֥�����
$form->addElement("text","form_bstruct_cd","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"".$g_form_option."\"");
//����̾
$form->addElement("text","form_bstruct_name","","size=\"34\" maxLength=\"20\"".$g_form_option."\"");

//�ܥ���
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#')\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");

//����
$form->addElement("text","form_bstruct_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//��ǧ�����å�
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "��ǧ��","1");
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "̤��ǧ","2");
$form->addGroup($form_accept, "form_accept", "");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");
/****************************/
//�롼�����
/****************************/
//���֥�����
$form->addRule("form_bstruct_cd", "���֥����ɤ�Ⱦ�ѿ����Τ�3��Ǥ���","required");
$form->addRule("form_bstruct_cd", "���֥����ɤ�Ⱦ�ѿ����Τ�3��Ǥ���", "regex", "/^[0-9]+$/");

//����̾
$form->addRule("form_bstruct_name", "����̾��1ʸ���ʾ�20ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_bstruct_name", "����̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $bstruct_cd        = $_POST["form_bstruct_cd"];                                   //����CD
    $bstruct_name      = $_POST["form_bstruct_name"];                                 //����̾
    $bstruct_note      = $_POST["form_bstruct_note"];                                 //����
    $accept            = $_POST["form_accept"];
    $update_flg        = $_POST["update_flg"];

    /***************************/
    //���֥���������
    /***************************/
    $bstruct_cd = str_pad($bstruct_cd, 3, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   bstruct_cd";
    $sql .= " FROM";
    $sql .= "   t_bstruct";
    $sql .= " WHERE";
    $sql .= "   bstruct_cd = '$bstruct_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //���ѺѤߥ��顼
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_bstruct_cd != $bstruct_cd))){
        $form->setElementError("form_bstruct_cd","���˻��Ѥ���Ƥ��� ���֥����� �Ǥ���");
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
            $work_div = 1;

            $insert_sql  = "INSERT INTO t_bstruct(";
            $insert_sql .= "    bstruct_id,";
            $insert_sql .= "    bstruct_cd,";
            $insert_sql .= "    bstruct_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    accept_flg";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(bstruct_id), 0)+1 FROM t_bstruct),";
            $insert_sql .= "    '$bstruct_cd',";
            $insert_sql .= "    '$bstruct_name',";
            $insert_sql .= "    '$bstruct_note',";
            $insert_sql .= "    '$accept'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
/*
            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "bstruct", "1", $bstruct_cd, $bstruct_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
*/
        /*******************************/
        //�ѹ�����
        /*******************************/
        }elseif($update_flg == true){
            $message = "�ѹ����ޤ�����";
            $work_div = 2;

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_bstruct";
            $insert_sql .= " SET";
            $insert_sql .= "    bstruct_cd = '$bstruct_cd',";
            $insert_sql .= "    bstruct_name = '$bstruct_name',";
            $insert_sql .= "    note = '$bstruct_note',";
            $insert_sql .= "    accept_flg = '$accept'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    bstruct_id = $get_bstruct_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
  /* 
            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "bstruct", "2", $bstruct_cd, $bstruct_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
*/
        }

		//���֥ޥ������ͤ���˽񤭹���
		//�ʥǡ��������ɡ�����CD  ̾�Ρ�����̾��
        $result = Log_Save($conn,'bstruct',$work_div,$bstruct_cd,$bstruct_name);
        //����Ͽ���˥��顼�ˤʤä����
        if($result === false){
            Db_Query($conn,"ROLLBACK;");
            exit;
        }

        Db_Query($conn, "COMMIT");

        $set_data["form_bstruct_cd"]       = "";                                 //����CD
        $set_data["form_bstruct_name"]     = "";                                 //����̾
        $set_data["form_bstruct_note"]     = "";                                 //����
        $set_data["update_flg"]            = "";

        $form->setConstants($set_data);

    }
}

/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   bstruct_cd,";
$sql .= "   bstruct_id,";
$sql .= "   bstruct_name,";
$sql .= "   note,";
$sql .= "   accept_flg";
$sql .= " FROM";
$sql .= "   t_bstruct";
$sql .= "   ORDER BY t_bstruct.bstruct_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT";
	$sql .= "   bstruct_cd,";
	$sql .= "   bstruct_id,";
	$sql .= "   bstruct_name,";
	$sql .= "   note,";
	$sql .= "   accept_flg";
	$sql .= " FROM";
	$sql .= "   t_bstruct";
	$sql .= "   ORDER BY t_bstruct.bstruct_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = ($page_data[$i][4] == "1") ? "��" : "��";
    }

    $csv_file_name = "���֥ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "���֥�����",
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
    'auth_r_msg'    => "$auth_r_msg",
    'message'       => "$message"
));

$smarty->assign("page_data",$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
