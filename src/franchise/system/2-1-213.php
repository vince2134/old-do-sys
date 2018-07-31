<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/20) �϶襳���ɤν�ʣ�����å�����(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/20)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0080    suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *  2006-12-11      ban_0140    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 *  
 *
*/

$page_title = "�϶�ޥ���";

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
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

/* GET����ID�������������å� */
$where = ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["area_id"] != null && Get_Id_Check_Db($conn, $_GET["area_id"], "area_id", "t_area", "num", $where) != true){
    header("Location: ../top.php");
}

/*****************************/
//���֥������Ⱥ���
/*****************************/
//�϶襳����
$form->addElement("text","form_area_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style;text-align: left;\"".$g_form_option."\"");
//�϶�̾
$form->addElement("text","form_area_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//�ܥ���
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");

//����
$form->addElement("text","form_area_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden", "update_flg");

/****************************/
//�ѹ������ʥ�󥯡�
/****************************/
if($_GET["area_id"] != ""){

	//�ѹ������϶�ID�����
    $update_num = $_GET["area_id"];

    $sql  = "SELECT";
    $sql .= "   area_cd,";
    $sql .= "   area_name,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_area";
    $sql .= " WHERE";
    $sql .= "   area_id = $update_num";
    $sql .= "   AND";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
	Get_Id_Check($result);

    $def_data["form_area_cd"]       = pg_fetch_result($result,0,0);
    $def_data["form_area_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_area_note"]     = pg_fetch_result($result,0,2);
	$def_data["update_flg"]			=	"true";
    $form->setDefaults($def_data);
}

/****************************/
//�롼�����
/****************************/
//�϶襳����
$form->addRule("form_area_cd", "�϶襳���ɤ�Ⱦ�ѿ����Τ�4��Ǥ���","required");
$form->addRule("form_area_cd", "�϶襳���ɤ�Ⱦ�ѿ����Τ�4��Ǥ���","regex", "/^[0-9]+$/");

//�϶�̾
$form->addRule("form_area_name", "�϶�̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_area_name", "�϶�̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $area_cd        = $_POST["form_area_cd"];                                   //�϶�CD
    $area_name      = $_POST["form_area_name"];                                 //�϶�̾
    $area_note      = $_POST["form_area_note"];                                 //����  
	$update_flg     = $_POST["update_flg"];										//��Ͽ������Ƚ��
	$update_num     = $_GET["area_id"];                                         //�϶�ID

    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    //���϶�CD
    //����ʣ�����å�
    if($area_cd != null){
	    $area_cd = str_pad($area_cd, 4, 0, STR_POS_LEFT);

	    $sql  = "SELECT";
	    $sql .= "   area_cd";
	    $sql .= " FROM";
	    $sql .= "   t_area";
	    $sql .= " WHERE";
        $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
	    $sql .= "   AND";
	    $sql .= "   area_cd = '$area_cd' ";

		//�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if($update_num != null && $update_flg == "true"){
            $sql .= " AND NOT ";
            $sql .= "area_id = '$update_num'";
        }
        $sql .= ";";
        $result = Db_Query($conn, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_area_cd","���˻��Ѥ���Ƥ��� �϶襳���� �Ǥ���");
        }
	}

    /***************************/
    //����  
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //��Ͽ����
        /*****************************/
		//��������Ͽ��Ƚ��
		if($update_flg != "true"){
			//��ȶ�ʬ����Ͽ
			$work_div = '1';
			//��Ͽ��λ��å�����
			$comp_msg = "��Ͽ���ޤ�����";

            $insert_sql  = "INSERT INTO t_area(";
            $insert_sql .= "    area_id,";
            $insert_sql .= "    area_cd,";
            $insert_sql .= "    area_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    shop_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(area_id), 0)+1 FROM t_area),";
            $insert_sql .= "    '$area_cd',";
            $insert_sql .= "    '$area_name',";
            $insert_sql .= "    '$area_note',";
            $insert_sql .= "     $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*******************************/
        //�ѹ�����
        /*******************************/
        }else{
			//��ȶ�ʬ�Ϲ���
			$work_div = '2';
			//�ѹ���λ��å�����
			$comp_msg = "�ѹ����ޤ�����";
            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_area";
            $insert_sql .= " SET";
            $insert_sql .= "    area_cd = '$area_cd',";
            $insert_sql .= "    area_name = '$area_name',";
            $insert_sql .= "    note = '$area_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    area_id = $update_num";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }

		//��Ͽ/���������������˻Ĥ�
        $result = Log_Save( $conn, "area", $work_div, $area_cd, $area_name);
        //���Ԥ������ϥ���Хå�
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        Db_Query($conn, "COMMIT");
        $def_fdata["form_area_cd"]			=	"";
        $def_fdata["form_area_name"]		=	"";
        $def_fdata["form_area_note"]		=	"";
		$def_fdata["update_flg"]			=	"";
		$form->setConstants($def_fdata);
    }
}

/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   area_cd,";
$sql .= "   area_id,";
$sql .= "   area_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_area";
$sql .= " WHERE";
$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
$sql .= "   ORDER BY t_area.area_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT";
	$sql .= "   area_cd,";
	$sql .= "   area_id,";
	$sql .= "   area_name,";
	$sql .= "   note";
	$sql .= " FROM";
	$sql .= "   t_area";
	$sql .= " WHERE";
	$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
	$sql .= "   ORDER BY t_area.area_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
    }

    $csv_file_name = "�϶�ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "�϶襳����",
        "�϶�̾",
        "����"
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
$page_menu = Create_Menu_f('system','1');

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
	'comp_msg'   	=> "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign("page_data",$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
