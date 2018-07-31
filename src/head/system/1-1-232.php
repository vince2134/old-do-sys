<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/18) ��ʬ�ॳ���ɤ���ʬ��ID��UNIQUE���ѹ�(suzuki-t)
 * 1.1.0 (2006/03/21) ��ʬ��ȼ拾���ɤ�ɬ�ܥ����å�����(suzuki-t)
 * 1.1.1 (2006/09/16) ���µ�ǽ��Ϳ��WATANABE-K��
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/21)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0129    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2007-01-23      �����ѹ�����watanabe-k���ܥ���ο�����  
 *  2007/04/18                  kajioka-h   �֣Ͷ�ʬ�ע�����ʬ��פ�ɽ���ѹ�
 *   2016/01/20                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�   
 *
*/

$page_title = "�ȼ�ޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null; 
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null; 

/*****************************/
//�����ѿ�����
/*****************************/
$get_sbtype_id = $_GET["sbtype_id"];

/* GET����ID�������������å� */
if ($_GET["sbtype_id"] != null && Get_Id_Check_Db($conn, $_GET["sbtype_id"], "sbtype_id", "t_sbtype", "num") != true){
    header("Location: ../top.php");
}

/*****************************/
//����ͤ����
/*****************************/
if($get_sbtype_id != null){
    $sql  = "SELECT";
    $sql .= "   t_sbtype.sbtype_cd,";
    $sql .= "   t_sbtype.sbtype_name,";
    $sql .= "   t_sbtype.note,";
    $sql .= "   t_sbtype.lbtype_id,";
    $sql .= "   t_sbtype.accept_flg";
    $sql .= " FROM";
    $sql .= "   t_sbtype";
    $sql .= " WHERE";
    $sql .= "   t_sbtype.sbtype_id = $get_sbtype_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $get_data = pg_fetch_array($result);

    $def_data["form_btype_cd"]   = $get_data[0];
    $def_data["form_btype_name"] = $get_data[1];
    $def_data["form_btype_note"] = $get_data[2];
    $def_data["form_btype"]      = $get_data[3];
    $def_data["form_accept"]     = $get_data[4];
    $def_data["update_flg"]      = true;
    $def_btype_cd = $get_data[0];
}else{
    $def_data["form_accept"]    = "2";
}

$form->setDefaults($def_data);

/*****************************/
//���֥������Ⱥ���
/*****************************/
//��ʬ��ȼ拾����
$form->addElement("text","form_btype_cd","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"".$g_form_option."\"");
//�ȼ�̾
$form->addElement("text","form_btype_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//���ϡ��ѹ�
$form->addElement("button","big_button","��ʬ��","onClick=\"javascript:Referer('1-1-205.php')\"");
//�Ȳ�
$form->addElement("button","small_button","��ʬ��",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//�ܥ���
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//����
$form->addElement("text","form_btype_note","","size=\"70\" maxLength=\"40\" ".$g_form_option."\"");

//��ǧ
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "��ǧ��","1");
$form_accept[] =& $form->createElement( "radio",NULL,NULL, "̤��ǧ","2");
$form->addGroup($form_accept, "form_accept", "");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");

//�ȼ拾����
$sql  = "SELECT";
$sql .= "   lbtype_id,";
$sql .= "   lbtype_cd,";
$sql .= "   lbtype_name";
$sql .= " FROM";
$sql .= "   t_lbtype";
$sql .= " ORDER BY lbtype_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$num = pg_num_rows($result);
$select_value[""] = "";
for($i = 0; $i < $num; $i++){
    $select_value[pg_fetch_result($result,$i,0)] = pg_fetch_result($result,$i,1)."��".pg_fetch_result($result,$i,2);
}
$form->addElement('select', 'form_btype', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

/****************************/
//�롼�����
/****************************/
//��ʬ��ȼ拾����
$form->addRule("form_btype", "��ʬ��ȼ拾���ɤ����򤷤Ƥ���������","required");

//��ʬ��ȼ拾����
$form->addRule("form_btype_cd", "��ʬ��ȼ拾���ɤ�Ⱦ�ѿ����Τ�3��Ǥ���","required");
$form->addRule("form_btype_cd", "��ʬ��ȼ拾���ɤ�Ⱦ�ѿ����Τ�3��Ǥ���", "regex", "/^[0-9]+$/");

//�ȼ�̾
$form->addRule("form_btype_name", "��ʬ��ȼ�̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_btype_name", "�ȼ�̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/***************************/
//��Ͽ�ܥ��󲡲�����
/***************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){
    /*****************************/
    //POST�������
    /*****************************/
    $btype_id       = $_POST["form_btype"];
    $btype_cd       = $_POST["form_btype_cd"];
    $btype_name     = $_POST["form_btype_name"];
    $btype_note     = $_POST["form_btype_note"];
    $update_flg     = $_POST["update_flg"];
    $accept         = $_POST["form_accept"];

    /****************************/
    //��ʬ��ȼ拾��������
    /****************************/
	if($btype_cd != null && $btype_id != null){
	    $btype_cd = str_pad($btype_cd, 3, 0, STR_POS_LEFT);
	    //���ѺѤߥ����å�
	    $sql  = "SELECT";
	    $sql .= "   sbtype_cd";
	    $sql .= " FROM";
	    $sql .= "   t_sbtype";
	    $sql .= " WHERE";
	    $sql .= "   sbtype_cd = '$btype_cd'";
		$sql .= " AND ";
		$sql .= "   lbtype_id = $btype_id";
	    $sql .= ";";

	    $result = Db_Query($conn, $sql);
	    $num = pg_num_rows($result);

	    //���ѺѤߥ��顼
	    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_btype_cd != $btype_cd))){
	        $form->setElementError("form_btype_cd","���˻��Ѥ���Ƥ��� ��ʬ��ȼ拾���� �Ǥ���");
	    }
	}
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /******************************/
        //��Ͽ����
        /******************************/
        if($update_flg != true){
            $message = "��Ͽ���ޤ�����";

            $insert_sql  = "INSERT INTO t_sbtype(";
            $insert_sql .= "    sbtype_id,";
            $insert_sql .= "    sbtype_cd,";
            $insert_sql .= "    sbtype_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    lbtype_id,";
            $insert_sql .= "    accept_flg";
            $insert_sql .= " )VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(sbtype_id),0) +1 FROM t_sbtype),";
            $insert_sql .= "    '$btype_cd',";
            $insert_sql .= "    '$btype_name',";
            $insert_sql .= "    '$btype_note',";
            $insert_sql .= "    $btype_id,";
            $insert_sql .= "    '$accept'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save($conn, "sbtype", "1", $btype_cd, $btype_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*********************************/
        //�ѹ�����
        /*********************************/
        }elseif($update_flg == true){
    
            $message = "�ѹ����ޤ�����";

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_sbtype";
            $insert_sql .= " SET";
            $insert_sql .= "    sbtype_cd = '$btype_cd',";
            $insert_sql .= "    sbtype_name = '$btype_name',";
            $insert_sql .= "    note = '$btype_note',";
            $insert_sql .= "    lbtype_id = $btype_id,";
            $insert_sql .= "    accept_flg = $accept";
            $insert_sql .= " WHERE";
            $insert_sql .= "    sbtype_id = $get_sbtype_id";
            $insert_sql .= ";";

            $reuslt = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
            }

            //��Ͽ�������˻Ĥ�
            $result = Log_Save($conn, "sbtype", "2", $btype_cd, $btype_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $data["form_btype"]      = "";
        $data["form_btype_cd"]   = "";
        $data["form_btype_name"] = "";
        $data["form_btype_note"] = "";
        $data["update_flg"]      = "";

        $form->setConstants($data);
    }
/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
}elseif($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){
	$sql  = "SELECT";
	$sql .= "   t_lbtype.lbtype_cd,";
	$sql .= "   t_lbtype.lbtype_name,";
	$sql .= "   t_lbtype.note,";
	$sql .= "   t_lbtype.accept_flg,";
	$sql .= "   t_sbtype.sbtype_id,";
	$sql .= "   t_sbtype.sbtype_cd,";
	$sql .= "   t_sbtype.sbtype_name,";
	$sql .= "   t_sbtype.note, ";
	$sql .= "   t_sbtype.accept_flg ";
	$sql .= " FROM";
	$sql .= "   t_lbtype";
	$sql .= "       LEFT JOIN";
	$sql .= "   t_sbtype";
	$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
	$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
	$sql .= ";"; 

    $result = Db_Query($conn, $sql);
    $total_count = pg_num_rows($result);
    $page_data = Get_Data($result,2);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][1];
        $csv_page_data[$i][2] = $page_data[$i][2];
        $csv_page_data[$i][3] = ($page_data[$i][3] == "1") ? "��" : "��";
        $csv_page_data[$i][4] = $page_data[$i][5];
        $csv_page_data[$i][5] = $page_data[$i][6];
        $csv_page_data[$i][6] = $page_data[$i][7];
        $csv_page_data[$i][7] = ($page_data[$i][8] == "1") ? "��" : "��";
    }

    $csv_file_name = "�ȼ�ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "��ʬ��ȼ拾����",
        "��ʬ��ȼ�̾",
        "��ʬ������",
        "��ʬ�ྵǧ",
        "��ʬ��ȼ拾����",
        "��ʬ��ȼ�̾",
        "��ʬ������",
        "��ʬ�ྵǧ"
      );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/*****************************/
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   t_lbtype.lbtype_cd,";
$sql .= "   t_lbtype.lbtype_name,";
$sql .= "   t_lbtype.note,";
$sql .= "   t_sbtype.sbtype_id,";
$sql .= "   t_sbtype.sbtype_cd,";
$sql .= "   t_sbtype.sbtype_name,";
$sql .= "   t_sbtype.note,";
$sql .= "   t_lbtype.accept_flg,";
$sql .= "   t_sbtype.accept_flg";
$sql .= " FROM";
$sql .= "   t_lbtype";
$sql .= "       LEFT JOIN";
$sql .= "   t_sbtype";
$sql .= "       ON t_lbtype.lbtype_id = t_sbtype.lbtype_id";
$sql .= " ORDER BY t_lbtype.lbtype_cd, t_sbtype.sbtype_cd";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

for($i = 0; $i < $total_count; $i++){
    for($j = 0; $j < $total_count; $j++){
        if($i != $j && $page_data[$i][0] == $page_data[$j][0]){
            $page_data[$j][0] = null;
            $page_data[$j][1] = null;
            $page_data[$j][2] = null;
            $page_data[$j][7] = null;
        }
    }
}

for($i = 0; $i < $total_count; $i++){
    if($page_data[$i][0] == null){
        $tr[$i] = $tr[$i-1];
    }else{  
        if($tr[$i-1] == "Result1"){
            $tr[$i] = "Result2";
        }else{  
            $tr[$i] = "Result1";
        }       
    }
}

$sql  = "SELECT";
$sql .= "   COUNT(sbtype_id)";
$sql .= "FROM";
$sql .= "   t_sbtype";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_fetch_result($result,0,0);

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
$page_title .= "��".$form->_elements[$form->_elementIndex[big_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[small_button]]->toHtml();
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
));
$smarty->assign("tr", $tr);
$smarty->assign("page_data", $page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
