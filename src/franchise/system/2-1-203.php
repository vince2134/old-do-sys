<?php
/***********************************/
//  �ѹ�����
//  ��2006/03/17��

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0139    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2007-02-07                  watanabe-k  ô���Ԥ��Ҹˤ�ɽ�����ʤ��褦�˽���
 *                              watanabe-k  �����Ҹˤ��� 
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�  
 *
*/

$page_title = "�Ҹ˥ޥ���";

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
$client_id      = $_SESSION["client_id"];
$group_kind     = $_SESSION["group_kind"];
//$shop_gid    = $_SESSION["shop_gid"];

$get_ware_id    = $_GET["ware_id"];

/* GET����ID�������������å� */
$where = ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
if ($_GET["ware_id"] != null && Get_Id_Check_Db($conn, $_GET["ware_id"], "ware_id", "t_ware", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
//����ͤ����
/****************************/
$def_data["form_count_flg"]     = 't';
$form->setDefaults($def_data);

$def_data["form_count_flg"]     = 't';
$form->setDefaults($def_data);
if($get_ware_id != null){
    $sql  = "SELECT";
    $sql .= "   t_ware.ware_cd,";
    $sql .= "   t_ware.ware_name,";
//    $sql .= "   t_client.client_name,";
    $sql .= "   t_ware.count_flg,";
    $sql .= "   t_ware.nondisp_flg,";
    $sql .= "   t_ware.note";
    $sql .= " FROM";
    $sql .= "   t_ware";
//    $sql .= "   t_client";
    $sql .= " WHERE";
    $sql .= "   t_ware.ware_id = $get_ware_id";
//    $sql .= "   AND";
//    $sql .= "   t_ware.own_shop_id = t_client.client_id";
//ô���Ԥ��Ҹˤ�ɽ�����ʤ�
    $sql .= "   AND";
    $sql .= "   t_ware.staff_ware_flg = 'f'\n";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    $def_data["form_ware_cd"]       = pg_fetch_result($result,0,0);
    $def_ware_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_ware_name"]     = pg_fetch_result($result,0,1);    
//    $def_data["form_own_shop"]      = pg_fetch_result($result,0,2);
    $def_data["form_count_flg"]     = pg_fetch_result($result,0,2);
    $def_data["form_nondisp_flg"]   = (pg_fetch_result($result,0,3) == 't')? 1 : 0;
    $def_data["form_ware_note"]     = pg_fetch_result($result,0,4);
    $def_data["update_flg"]         = true;

    $form->setDefaults($def_data);
}

/*****************************/
//���֥������Ⱥ���
/*****************************/
//�ƥ�����
$form->addElement("text","form_ware_cd","","size=\"3\" maxLength=\"3\" style=\"text-align: left; $g_form_style\"".$g_form_option."\"");
$form->addElement("text","form_ware_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

//�����Ҹ�
/*
if($get_ware_id != null && $_POST["update_flg"] != true){
    $form->addElement("static","form_own_shop","","");
}else{
    if ($group_kind == "3"){
        $form->addElement("static","form_own_shop","","");
    }else{
        $select_value = Select_Get($conn,'own_shop');
        $form->addElement('select', 'form_own_shop', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
    }
}
*/

//����
$form->addElement("text","form_ware_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//ȯ�����������
//��¥��ܥ���
$form_count_flg[] =& $form->createElement( "radio",NULL,NULL, "����","t");
$form_count_flg[] =& $form->createElement( "radio",NULL,NULL, "���ʤ�","f");
$form->addGroup($form_count_flg, "form_count_flg", "");

//��ɽ��
$form->addElement('checkbox', 'form_nondisp_flg', '', '');

//�ܥ���
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");
$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");

/****************************/
//�롼�����
/****************************/
//�Ҹ˥�����
$form->addRule("form_ware_cd", "�Ҹ˥����ɤ�Ⱦ�ѿ����Τ�3��Ǥ���","required");
$form->addRule("form_ware_cd", "�Ҹ˥����ɤ�Ⱦ�ѿ����Τ�3��Ǥ���", "regex", "/^[0-9]+$/");

//�Ҹ�̾
$form->addRule("form_ware_name", "�Ҹ�̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_ware_name", "�Ҹ�̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/*
//�����Ҹ�
if($get_ware_id == null && $group_kind != "3"){
    $form->addRule("form_own_shop","�����Ҹˤ�ɬ�ܹ��ܤǤ���","required");
}
*/
/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $ware_cd        = $_POST["form_ware_cd"];                                   //�Ҹ�CD
    $ware_name      = $_POST["form_ware_name"];                                 //�Ҹ�̾
//    $own_shop_id    = ($group_kind == "3") ? $client_id : $_POST["form_own_shop"];  //�����Ҹ�
    $count_flg      = $_POST["form_count_flg"];                                 //ȯ����������ȥե饰
    $nondisp_flg    = ($_POST["form_nondisp_flg"] == '1')? 't' : 'f';           //��ɽ��
    $ware_note      = $_POST["form_ware_note"];                                 //����
    $update_flg     = $_POST["update_flg"];

    /***************************/
    //�Ҹ˥���������
    /***************************/
    $ware_cd = str_pad($ware_cd, 3, 0, STR_PAD_LEFT);

    //���Ҹ˥�����
    //��ʣ�����å�
    $sql  = "SELECT";
    $sql .= "   ware_cd";
    $sql .= " FROM";
    $sql .= "   t_ware";
    $sql .= " WHERE";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $client_id ";
    $sql .= "   AND";
    $sql .= "   ware_cd = '$ware_cd'";
    $sql .= ";";
    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_ware_cd != $ware_cd))){
        $form->setElementError("form_ware_cd","���˻��Ѥ���Ƥ��� �Ҹ˥����� �Ǥ���");
    }

    //��ɽ��
    //�߸˿������å�
    if($nondisp_flg == 't'){
       $sql  = "SELECT ";
       $sql .= "DISTINCT ";
       $sql .= "   stock_num";
       $sql .= " FROM";
       $sql .= "   t_stock";
       $sql .= " WHERE";
       $sql .= "   shop_id = $client_id";
       $sql .= " AND";
       $sql .= "   ware_id = ";
       $sql .= "   (SELECT ";
       $sql .= "       ware_id ";
       $sql .= "   FROM ";
       $sql .= "       t_ware ";
       $sql .= "   WHERE";
       $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $client_id ";
       $sql .= "   AND";
       $sql .= "       ware_cd = '$ware_cd'";
       $sql .= "   )";
       $sql .= ";";
       $result = Db_Query($conn, $sql);
       $stock_flg = false;
       while($stock_num = pg_fetch_array($result)){
           if($stock_num[0] != 0){
               $stock_flg = true;
           }
       }
       if($stock_flg == true){
           $form->setElementError("form_ware_cd","�߸ˤ������Ҹˤ���ɽ���ˤǤ��ޤ���");
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
        if($update_flg != true){

            $insert_sql  = "INSERT INTO t_ware(";
            $insert_sql .= "    ware_id,";
            $insert_sql .= "    ware_cd,";
            $insert_sql .= "    ware_name,";
//            $insert_sql .= "    own_shop_id,";
            $insert_sql .= "    count_flg,";
            $insert_sql .= "    note,";
            $insert_sql .= "    shop_id,";
            $insert_sql .= "    nondisp_flg";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(ware_id), 0)+1 FROM t_ware),";
            $insert_sql .= "    '$ware_cd',";
            $insert_sql .= "    '$ware_name',";
//            $insert_sql .= "    $own_shop_id,";
            $insert_sql .= "    '$count_flg',";
            $insert_sql .= "    '$ware_note',";
            $insert_sql .= "    $client_id,";
            $insert_sql .= "    '$nondisp_flg'";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "ware", "1", $ware_cd, $ware_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            $message = "��Ͽ���ޤ�����";
        /*******************************/
        //�ѹ�����
        /*******************************/
        }elseif($update_flg == true){
            $insert_sql  = "UPDATE ";
            $insert_sql .= "    t_ware";
            $insert_sql .= " SET";
            $insert_sql .= "    ware_cd = '$ware_cd',";
            $insert_sql .= "    ware_name = '$ware_name',";
            $insert_sql .= "    count_flg = '$count_flg',";
            $insert_sql .= "    nondisp_flg = '$nondisp_flg',";
            $insert_sql .= "    note = '$ware_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    ware_id = $get_ware_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "ware", "2", $ware_cd, $ware_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
            $message = "�ѹ����ޤ�����";
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_ware_cd"]      = "";               //�Ҹ�CD
        $set_data["form_ware_name"]    = "";               //�Ҹ�̾
//        $set_data["form_own_shop"]     = "";               //�����Ҹ�
        $set_data["form_count_flg"]    = "t";              //ȯ����������ȥե饰
        $set_data["form_nondisp_flg"]  = "";               //��ɽ��
        $set_data["form_ware_note"]    = "";               //����  
        $set_data["update_flg"]        = "";

        $form->setConstants($set_data);
    }
}

/*****************************
//��������
/*****************************/
$sql  = "SELECT\n";
$sql .= "   t_ware.ware_cd,\n";
$sql .= "   t_ware.ware_id,\n";
$sql .= "   t_ware.ware_name,\n";
/*
$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,\n";
$sql .= "   t_client.client_name,\n";
*/
$sql .= "   CASE t_ware.count_flg\n";
$sql .= "       WHEN true  THEN '��'\n";
$sql .= "       WHEN false THEN ''\n";
$sql .= "   END,\n";
$sql .= "   CASE t_ware.nondisp_flg\n";
$sql .= "       WHEN true  THEN '��'\n";
$sql .= "       WHEN false THEN ''\n";
$sql .= "   END,\n";
$sql .= "   t_ware.note\n";
$sql .= " FROM\n";
//$sql .= "   t_client,\n";
$sql .= "   t_ware\n";
$sql .= " WHERE\n";
//$sql .= "   t_ware.own_shop_id = t_client.client_id\n";
//$sql .= "   AND\n";
//$sql .= "   t_client.client_div = '3' \n";
//$sql .= "   AND\n";
//$sql .= "   t_client.attach_gid = $shop_gid\n";
$sql .= ($group_kind == "2") ? " t_ware.shop_id IN (".Rank_Sql().") " : " t_ware.shop_id = $client_id ";
//ô���Ԥ��Ҹˤ�ɽ�����ʤ���
$sql .= "   AND \n";
$sql .= "   staff_ware_flg = 'f'";
$sql .= "   ORDER BY t_ware.ware_cd\n";
$sql .= ";\n";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/****************************/
//CSV�ܥ��󲡲�����
/****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT\n";
	$sql .= "   t_ware.ware_cd,\n";
	$sql .= "   t_ware.ware_id,\n";
	$sql .= "   t_ware.ware_name,\n";
//	$sql .= "   t_client.client_cd1 || '-' || t_client.client_cd2,\n";
//	$sql .= "   t_client.client_name,\n";
	$sql .= "   CASE t_ware.count_flg\n";
	$sql .= "       WHEN true  THEN '��'\n";
	$sql .= "       WHEN false THEN ''\n";
	$sql .= "   END,\n";
	$sql .= "   CASE t_ware.nondisp_flg\n";
	$sql .= "       WHEN true  THEN '��'\n";
	$sql .= "       WHEN false THEN ''\n";
	$sql .= "   END,\n";
	$sql .= "   t_ware.note\n";
	$sql .= " FROM\n";
//	$sql .= "   t_client,\n";
	$sql .= "   t_ware\n";
	$sql .= " WHERE\n";
//	$sql .= "   t_ware.own_shop_id = t_client.client_id\n";
//	$sql .= "   AND\n";
//	$sql .= "   t_client.client_div = '3' \n";
//	$sql .= "   AND\n";
	//$sql .= "   t_client.attach_gid = $shop_gid\n";
	$sql .= ($group_kind == "2") ? " t_ware.shop_id IN (".Rank_Sql().") " : " t_ware.shop_id = $client_id ";
    $sql .= "   AND \n";
    $sql .= "   staff_ware_flg = 'f'";
	$sql .= "   ORDER BY t_ware.ware_cd\n";
	$sql .= ";\n";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = $page_data[$i][4];
        $csv_page_data[$i][4] = $page_data[$i][5];
/*
        $csv_page_data[$i][5] = $page_data[$i][6];
        $csv_page_data[$i][6] = $page_data[$i][7];
*/
    }

    $csv_file_name = "�Ҹ˥ޥ���".date("Ymd").".csv";

    $csv_header = array(
        "�Ҹ˥�����",
        "�Ҹ�̾",
//        "����åץ�����",
//        "����å�̾",
        "ȯ�����������",
        "��ɽ��",
        "����"
    );

    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($csv_page_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}




/****************************e
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
    'message'       => "$message",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign('page_data', $page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
