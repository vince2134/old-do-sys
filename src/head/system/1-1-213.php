<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0136    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *   2016/01/20                amano  Dialogue, Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�     
 *  
 *
*/

$page_title = "�϶�ޥ���";

//environment setting file �Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm����� Create HTML_QuickForm 
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB��³ connect to database
$conn = Db_Connect();

// ���¥����å� check authorization
$auth       = Auth_Check($conn);
// ���ϡ��ѹ�����̵����å����� no input/revision authorization message
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled button disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ����� Acquire outside variable
/****************************/
$shop_id    = $_SESSION["client_id"];

$get_area_id = $_GET["area_id"];

/* GET����ID�������������å� Check the validity of the ID that was GET */ 
if ($_GET["area_id"] != null && Get_Id_Check_Db($conn, $_GET["area_id"], "area_id", "t_area", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//����ͤ���� Extract the initial value
/****************************/
if($get_area_id != null){
    $sql  = "SELECT";
    $sql .= "   area_cd,";
    $sql .= "   area_name,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_area";
    $sql .= " WHERE";
    $sql .= "   area_id = $get_area_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";";

    $result = Db_Query($conn, $sql);

    $def_data["form_area_cd"]       = pg_fetch_result($result,0,0);
    $def_area_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_area_name"]     = pg_fetch_result($result,0,1);
    $def_data["form_area_note"]     = pg_fetch_result($result,0,2);
    $def_data["update_flg"]         = true;
    $form->setDefaults($def_data);
}

/*****************************/
//���֥������Ⱥ��� create object
/*****************************/
//�϶襳���� district code
$form->addElement("text","form_area_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" ".$g_form_option."\"");
//�϶�̾ district name
$form->addElement("text","form_area_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");
//�ܥ��� button
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\"");

//���� remarks
$form->addElement("text","form_area_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//hidden 
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");
/****************************/
//�롼����� crete rules
/****************************/
//�϶襳���� district code
$form->addRule("form_area_cd", "�϶襳���ɤ�Ⱦ�ѿ����Τ�4��Ǥ���","required");
$form->addRule("form_area_cd", "�϶襳���ɤ�Ⱦ�ѿ����Τ�4��Ǥ���", "regex", "/^[0-9]+$/");

//�϶�̾ district name
$form->addRule("form_area_name", "�϶�̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å� only check half-width/full-width space
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_area_name", "�϶�̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ�ܥ��󲡲����� process when register button is pressed 
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST������� acquire POST info
    /****************************/
    $area_cd        = $_POST["form_area_cd"];                                   //�϶�CD districtCD
    $area_name      = $_POST["form_area_name"];                                 //�϶�̾ district name
    $area_note      = $_POST["form_area_note"];                                 //���� remarks
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //�϶襳�������� arrange district code
    /***************************/
    $area_cd = str_pad($area_cd, 4, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   area_cd";
    $sql .= " FROM";
    $sql .= "   t_area";
    $sql .= " WHERE";
    $sql .= "   shop_id = $shop_id";
    $sql .= "   AND";
    $sql .= "   area_cd = '$area_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);

    //���ѺѤߥ��顼 "already used" error
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_area_cd != $area_cd))){
        $form->setElementError("form_area_cd","���˻��Ѥ���Ƥ��� �϶襳���� �Ǥ���");
    }

    /***************************/
    //����  verify
    /***************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //��Ͽ���� registration process
        /*****************************/
        if($update_flg != true){

            $message = "��Ͽ���ޤ�����";

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
            $insert_sql .= "    $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå� rollback when failed
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ� leave the register info in log
            $result = Log_Save( $conn, "area", "1", $area_cd, $area_name);
            //���Ԥ������ϥ���Хå� rollback when failed 
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

        /*******************************/
        //�ѹ����� revision process
        /*******************************/
        }elseif($update_flg == true){
            $message = "�ѹ����ޤ�����";

            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_area";
            $insert_sql .= " SET";
            $insert_sql .= "    area_cd = '$area_cd',";
            $insert_sql .= "    area_name = '$area_name',";
            $insert_sql .= "    note = '$area_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    area_id = $get_area_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
   
            //��Ͽ�����������˻Ĥ� leave the register info in log
            $result = Log_Save( $conn, "area", "2", $area_cd, $area_name);
            //���Ԥ������ϥ���Хå� rollback when failed 
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_area_cd"]       = "";                                   //�϶�CD districtCD
        $set_data["form_area_name"]     = "";                                 //�϶�̾ distric name
        $set_data["form_area_note"]     = "";                                 //���� remarks 
        $set_data["update_flg"]         = "";

        $form->setConstants($set_data);

    }
}

/*****************************
//�������� create list
/*****************************/
$sql  = "SELECT";
$sql .= "   area_cd,";
$sql .= "   area_id,";
$sql .= "   area_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_area";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= "   ORDER BY t_area.area_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSV�ܥ��󲡲����� process when CSV button is pressed 
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
	$sql .= "   shop_id = $shop_id";
	$sql .= "   ORDER BY t_area.area_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV���� create csv
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
//HTML�إå� HTML Header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� HTML footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå������� create display header
/****************************/
$page_title .= "(��".$total_count."��)";
$page_header = Create_Header($page_title);


// Render��Ϣ������ render related settings
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variables
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other variables
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

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
