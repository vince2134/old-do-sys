<?php

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-08      ban_0088    suzuki      ��������Ͽ����ޥ���̾�ѹ�
 *  2006-12-11      ban_0143    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2015/05/01                  amano  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
 *  
 *
*/

$page_title = "������ʬ�ޥ���";

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

/****************************/
//�����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$group_kind = $_SESSION["group_kind"];

$get_product_id = $_GET["product_id"];

/* GET����ID�������������å� */
$where  = "(public_flg = 't' AND accept_flg = '1') ";
$where .= "OR ( ";
$where .= "shop_id = 1 OR ";
$where .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
$where .= ") ";
if ($_GET["product_id"] != null && Get_Id_Check_Db($conn, $_GET["product_id"], "product_id", "t_product", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
//����ͤ����
/****************************/
if($get_product_id != null){
    $sql  = "SELECT";
    $sql .= "   product_cd,";
    $sql .= "   product_name,";
    $sql .= "   note,";
    $sql .= "   public_flg ";             //��ͭ�ե饰
    $sql .= " FROM";
    $sql .= "   t_product";
    $sql .= " WHERE";
    $sql .= "   product_id = $get_product_id";
    $sql .= "   AND";
    $sql .= "   (public_flg = 't' ";
    $sql .= "   AND";
    $sql .= "   accept_flg = '1'";
    $sql .= "   OR ";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= ")";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    $def_data["form_product_cd"]       = pg_fetch_result($result,0,0);
    $def_product_cd                    = pg_fetch_result($result,0,0);
    $def_data["form_product_name"]     = ($def_product_cd >= 5000 && $def_product_cd <= 8999) ? pg_fetch_result($result,0,1)
                                                                                              : htmlspecialchars(pg_fetch_result($result,0,1));
    $def_data["form_product_note"]     = ($def_product_cd >= 5000 && $def_product_cd <= 8999) ? pg_fetch_result($result,0,2)
                                                                                              : htmlspecialchars(pg_fetch_result($result,0,2));
    $public_flg                        = pg_fetch_result($result,0,3);
    $def_data["update_flg"]            = true;
    $form->setDefaults($def_data);
}

/*****************************/
//���֥������Ⱥ���
/*****************************/
//������ʬ������
//��ͭ�ե饰Ƚ��
if($public_flg=='t'){
    $form->addElement("static","form_product_cd","","");
}else{
    $form->addElement("text","form_product_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style;text-align: left;\"".$g_form_option."\"");
}
//������ʬ̾
//��ͭ�ե饰Ƚ��
if($public_flg=='t'){
    $form->addElement("static","form_product_name","","");
}else{
    $form->addElement("text","form_product_name","","size=\"22\" maxLength=\"10\"".$g_form_option."\"");
}

// ���ϸ��¤Τ��륹���åդΤ߽���
//�ܥ���
//��ͭ�ե饰Ƚ��
if($public_flg!='t'){
    $form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"return Dialogue('��Ͽ���ޤ���', '#', this)\" $disabled");
}
$form->addElement("button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");

//����
//��ͭ�ե饰Ƚ��
if($public_flg=='t'){
    $form->addElement("static","form_product_note","","");
}else{
    $form->addElement("text","form_product_note","","size=\"34\" maxLength=\"30\" ".$g_form_option."\"");
}

//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","update_flg");

/****************************/
//�롼�����
/****************************/
//������ʬ������
$form->addRule("form_product_cd", "������ʬ�����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���","required");
$form->addRule("form_product_cd", "������ʬ�����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���", "regex", "/^[0-9]+$/");

//������ʬ̾
$form->addRule("form_product_name", "������ʬ̾��1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_product_name", "������ʬ̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $product_cd        = $_POST["form_product_cd"];                                   //������ʬCD
    $product_name      = $_POST["form_product_name"];                                 //������ʬ̾
    $product_note      = $_POST["form_product_note"];                                 //����
    $update_flg        = $_POST["update_flg"];

    /***************************/
    //������ʬ����������
    /***************************/
    $product_cd = str_pad($product_cd, 4, 0, STR_PAD_LEFT);

    $sql  = "SELECT";
    $sql .= "   product_cd";
    $sql .= " FROM";
    $sql .= "   t_product";
    $sql .= " WHERE";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= "   AND";
    $sql .= "   product_cd = '$product_cd'";
    $sql .= ";";

    $result = Db_Query($conn, $sql);
    $num = pg_num_rows($result);


    //���ѺѤߥ��顼
    if($num > 0 && ($update_flg != true || ($update_flg == true && $def_product_cd != $product_cd))){
        $form->setElementError("form_product_cd","���˻��Ѥ���Ƥ��������ʬ�����ɤǤ���");
    }

    //�������η�
    if($product_cd < 5000 || $product_cd >= 9000){
        $form->setElementError("form_product_cd","������ʬ�����ɤ�5000��8999�ʳ������ѤǤ��ޤ���");
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

            $insert_sql  = "INSERT INTO t_product(";
            $insert_sql .= "    product_id,";
            $insert_sql .= "    product_cd,";
            $insert_sql .= "    product_name,";
            $insert_sql .= "    note,";
            $insert_sql .= "    public_flg,";
            $insert_sql .= "    shop_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(product_id), 0)+1 FROM t_product),";
            $insert_sql .= "    '$product_cd',";
            $insert_sql .= "    '$product_name',";
            $insert_sql .= "    '$product_note',";
            $insert_sql .= "    'f',";
            $insert_sql .= "    $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ�����Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�������������˻Ĥ�
            $result = Log_Save( $conn, "product", "1", $product_cd, $product_name);
            //���Ԥ������ϥ�����Хå�
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
            $insert_sql .= "    t_product";
            $insert_sql .= " SET";
            $insert_sql .= "    product_cd = '$product_cd',";
            $insert_sql .= "    product_name = '$product_name',";
            $insert_sql .= "    note = '$product_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    product_id = $get_product_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�������������˻Ĥ�
            $result = Log_Save( $conn, "product", "2", $product_cd, $product_name);
            //���Ԥ������ϥ�����Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
            $message = "�ѹ����ޤ�����";
        }
        Db_Query($conn, "COMMIT");

        $set_data["form_product_cd"]    = "";                                   //������ʬCD
        $set_data["form_product_name"]  = "";                                 //������ʬ̾
        $set_data["form_product_note"]  = "";                                 //����  
        $set_data["update_flg"]         = "";

        $form->setConstants($set_data);
    }

}


/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   DISTINCT";
$sql .= "   product_cd,";
$sql .= "   product_id,";
$sql .= "   product_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_product";
$sql .= " WHERE";
$sql .= "   public_flg = 't'";
$sql .= "   AND";
$sql .= "   accept_flg = '1'";
$sql .= "   OR";
$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
$sql .= "   ORDER BY product_cd";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);



/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT";
	$sql .= "   DISTINCT";
	$sql .= "   product_cd,";
	$sql .= "   product_id,";
	$sql .= "   product_name,";
	$sql .= "   note";
	$sql .= " FROM";
	$sql .= "   t_product";
	$sql .= " WHERE";
	$sql .= "   public_flg = 't'";
	$sql .= "   AND";
	$sql .= "   accept_flg = '1'";
	$sql .= "   OR";
	$sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
	$sql .= "   ORDER BY product_cd";
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

    $csv_file_name = "������ʬ�ޥ���".date("Ymd").".csv";
    $csv_header = array(
        "������ʬ������",
        "������ʬ̾",
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
    'message'       => "$message",
));

$smarty->assign('page_data', $page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>