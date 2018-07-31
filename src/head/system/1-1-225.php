<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/21) �����������ѹ�(suzuki-t)
 * 1.1.0 (2006/04/12) ���ꣳ���ɲ�(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/21)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-11      ban_0138    suzuki      CSV���ϻ��ˤϥ��˥������󥰤�Ԥ�ʤ��褦�˽���
 *  2007-05-11                  kaku-m      CSV�ι��ܤ���
 *   2016/01/20                amano  Dialogue, Button_Submit, Button_Submit_1 �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�   
 *
*/

$page_title = "�����ȼԥޥ���";

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

if($_GET["trans_id"] != null){
    $get_trans_id = $_GET["trans_id"];
    $get_flg = true; 
}else{
    $get_flg = false;
}

/* GET����ID�������������å� */
if ($_GET["trans_id"] != null && Get_Id_Check_Db($conn, $_GET["trans_id"], "trans_id", "t_trans", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/*****************************/
//���֥������Ⱥ���
/*****************************/
//�����ȼԥ�����
$form->addElement(
		"text","form_trans_cd","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
		".$g_form_option."\""
		);

//�����ȼ�̾
$form->addElement("text","form_trans_name","","size=\"34\" maxLength=\"25\" $g_form_option");

//ά��
$form->addElement("text","form_trans_cname","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" $g_form_option");

//͹���ֹ�
$form_post[] =& $form->createElement(
        "text","no1","","size=\"3\" maxLength=\"3\" style=\"$g_form_style\"  
        onkeyup=\"changeText(this.form,'form_post[no1]','form_post[no2]',3)\"".$g_form_option."\""
        );
$form_post[] =& $form->createElement(
        "static","","","-"
        );
$form_post[] =& $form->createElement(
        "text","no2","","size=\"4\" maxLength=\"4\" style=\"$g_form_style\" 
        $g_form_option"
        );
$form->addGroup($form_post, "form_post", "form_post");

//����1
$form->addElement(
        "text","form_address1","","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//����2
$form->addElement(
        "text","form_address2","","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//����3
$form->addElement(
        "text","form_address3","","size=\"34\" maxLength=\"15\" 
        $g_form_option"
        );

//TEL
$form->addElement(
        "text","form_tel","","size=\"17\" maxLength=\"13\" style=\"$g_form_style\" 
        $g_form_option"
        );

//FAX
$form->addElement(
        "text","form_fax","","size=\"17\" maxLength=\"13\" style=\"$g_form_style\" 
        $g_form_option"
        );
//���꡼�����ȼ�
$form->addElement(
        "checkbox","form_green_trans");

//����
$form->addElement(
        "text","form_trans_note","",
        "size=\"34\" maxLength=\"30\" ".$g_form_option."\"");

//button
// ���ϸ��¤Τ��륹���åդΤ߽���
//��ư����
$form->addElement(
    "button","form_auto_input_button","��ư����",
    "onClick=\"javascript:Button_Submit_1('input_button_flg', '#', 'true', this)\""
);

//��Ͽ�ܥ���
$form->addElement(
    "submit","form_entry_button","�С�Ͽ",
    "onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled"
);

//���ꥢ
$form->addElement(
    "button","form_clear_button","���ꥢ","onClick=\"location.href='$_SERVER[PHP_SELF]'\"");

//CSV�ܥ���
$form->addElement(
        "button","form_csv_button","CSV����",
        "onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true', this);\""
        );
//hidden
$form->addElement("hidden","csv_button_flg");
$form->addElement("hidden","input_button_flg");
$form->addElement("hidden", "update_flg");

/****************************/
//����ͤ����
/****************************/
if($get_flg == true){
    $sql  = "SELECT";
    $sql .= "   trans_cd,";
    $sql .= "   trans_name,";
    $sql .= "   trans_cname,";
    $sql .= "   post_no1,";
    $sql .= "   post_no2,";
    $sql .= "   address1,";
    $sql .= "   address2,";
    $sql .= "   address3,";
    $sql .= "   tel,";
    $sql .= "   fax,";
    $sql .= "   green_trans,";
    $sql .= "   note";
    $sql .= " FROM";
    $sql .= "   t_trans";
    $sql .= " WHERE";
    $sql .= "   trans_id = $get_trans_id";
    $sql .= "   AND";
    $sql .= "   shop_id = $shop_id";
    $sql .= ";"; 

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $total_cout = pg_num_rows($result);


    $def_data["form_trans_cd"]      = pg_fetch_result($result,0,0);
    $def_trans_cd                   = pg_fetch_result($result,0,0);
    $def_data["form_trans_name"]    = pg_fetch_result($result,0,1);
    $def_data["form_trans_cname"]   = pg_fetch_result($result,0,2);
    $def_data["form_post"]["no1"]   = pg_fetch_result($result,0,3);
    $def_data["form_post"]["no2"]   = pg_fetch_result($result,0,4);
    $def_data["form_address1"]      = pg_fetch_result($result,0,5);
    $def_data["form_address2"]      = pg_fetch_result($result,0,6);
    $def_data["form_address3"]      = pg_fetch_result($result,0,7);
    $def_data["form_tel"]           = pg_fetch_result($result,0,8);
    $def_data["form_fax"]           = pg_fetch_result($result,0,9);
    $def_data["form_green_trans"]   = (pg_fetch_result($result,0,10) == 't')? 1 : 0;
    $def_data["form_trans_note"]    = pg_fetch_result($result,0,11);
	$def_data["update_flg"]			=	"true";
    $form->setDefaults($def_data);
}


/****************************/
//�롼�����
/****************************/
//�����ȼԥ�����
$form->addRule("form_trans_cd", "�����ȼԥ����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���","required");
$form->addRule("form_trans_cd", "�����ȼԥ����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���", "regex", "/^[0-9]+$/");

//�����ȼ�̾
$form->addRule("form_trans_name", "�����ȼ�̾��1ʸ���ʾ�25ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_trans_name", "�����ȼ�̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//ά��
$form->addRule("form_trans_cname", "ά�Τ�1ʸ���ʾ�10ʸ���ʲ��Ǥ���","required");
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->addRule("form_trans_cname", "ά�� �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//͹���ֹ�
$form->addGroupRule("form_post", array(
    'no1' => array(
            array("͹���ֹ��7��Ǥ���", 'required')
        ),      
    'no2' => array(
            array("͹���ֹ��7��Ǥ���",'required')
        ),      
));

//���꣱
$form->addRule("form_address1","���꣱��1ʸ���ʾ�15ʸ���ʲ��Ǥ���","required");

//TEL
$form->addRule("form_tel", "TEL��Ⱦ�ѿ����ȡ�-�פΤ�13��Ǥ���", "regex", "/^[0-9-]+$/");

//FAX
$form->addRule("form_fax", "FAX��Ⱦ�ѿ����ȡ�-�פΤ�13��Ǥ���", "regex", "/^[0-9-]+$/");


/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST�������
    /****************************/
    $trans_cd        = $_POST["form_trans_cd"];                                 //�����ȼ�CD
    $trans_name      = $_POST["form_trans_name"];                               //�����ȼ�̾
    $trans_cname     = $_POST["form_trans_cname"];                              //ά��
    $post_no1        = $_POST["form_post"]["no1"];                              //͹���ֹ棱
    $post_no2        = $_POST["form_post"]["no2"];                              //͹���ֹ棲
    $address1        = $_POST["form_address1"];                                 //���꣱
    $address2        = $_POST["form_address2"];                                 //���ꣲ
    $address3        = $_POST["form_address3"];                                 //���ꣳ
    $tel             = $_POST["form_tel"];                                      //TEL
    $fax             = $_POST["form_fax"];                                      //FAX
    $green_trans     = ($_POST["form_green_trans"] == 1)? 't' : 'f';            //���꡼�����ȼ�
    $trans_note      = $_POST["form_trans_note"];                               //����
	$update_flg      = $_POST["update_flg"];									//��Ͽ������Ƚ��

    /***************************/
    //�����
    /***************************/
	if($trans_cd != null){
        //�����ȼԥ����ɤˣ�������
        $trans_cd = str_pad($trans_cd, 4, 0, STR_POS_LEFT);
        //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
        $sql  = "SELECT ";
        $sql .= "    trans_cd ";                //�����ȼԥ�����
        $sql .= "FROM ";
        $sql .= "    t_trans ";
        $sql .= "WHERE ";
        $sql .= "    trans_cd = '$trans_cd' ";
        $sql .= "AND ";
        $sql .= "    shop_id = $shop_id ";

        //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if($get_trans_id != null){
            $sql .= " AND NOT ";
            $sql .= "trans_id = '$get_trans_id'";
        }
        $sql .= ";";
        $result = Db_Query($conn, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_trans_cd","���˻��Ѥ���Ƥ��� �����ȼԥ����� �Ǥ���");
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

            //�����ȼԥޥ�������Ͽ
            $insert_sql  = "INSERT INTO t_trans(";
            $insert_sql .= "    trans_id,";
            $insert_sql .= "    trans_cd,";
            $insert_sql .= "    trans_name,";
            $insert_sql .= "    trans_cname,";
            $insert_sql .= "    post_no1,";
            $insert_sql .= "    post_no2,";
            $insert_sql .= "    address1,";
            $insert_sql .= "    address2,";
            $insert_sql .= "    address3,";
            $insert_sql .= "    tel,";
            $insert_sql .= "    fax,";
            $insert_sql .= "    green_trans,";
            $insert_sql .= "    note,";
            $insert_sql .= "    shop_id";
            $insert_sql .= ")VALUES(";
            $insert_sql .= "    (SELECT COALESCE(MAX(trans_id), 0)+1 FROM t_trans),";
            $insert_sql .= "    '$trans_cd',";
            $insert_sql .= "    '$trans_name',";
            $insert_sql .= "    '$trans_cname',";
            $insert_sql .= "    '$post_no1',";
            $insert_sql .= "    '$post_no2',";
            $insert_sql .= "    '$address1',";
            $insert_sql .= "    '$address2',";
            $insert_sql .= "    '$address3',";
            $insert_sql .= "    '$tel',";
            $insert_sql .= "    '$fax',";
            $insert_sql .= "    '$green_trans',";
            $insert_sql .= "    '$trans_note',";
            $insert_sql .= "    $shop_id";
            $insert_sql .= ");";

            $result = Db_Query($conn, $insert_sql);

            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "trans", "1", $trans_cd, $trans_name);
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
            $insert_sql .= "    t_trans";
            $insert_sql .= " SET";
            $insert_sql .= "    trans_cd = '$trans_cd',";
            $insert_sql .= "    trans_name = '$trans_name',";
            $insert_sql .= "    trans_cname = '$trans_cname',";
            $insert_sql .= "    post_no1 = '$post_no1',";
            $insert_sql .= "    post_no2 = '$post_no2',";
            $insert_sql .= "    address1 = '$address1',";
            $insert_sql .= "    address2 = '$address2',";
            $insert_sql .= "    address3 = '$address3',";
            $insert_sql .= "    tel = '$tel',";
            $insert_sql .= "    fax = '$fax',";
            $insert_sql .= "    green_trans = '$green_trans',";
            $insert_sql .= "    note = '$trans_note'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    trans_id = $get_trans_id";
            $insert_sql .= ";";

            $result = Db_Query($conn, $insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ�����������˻Ĥ�
            $result = Log_Save( $conn, "trans", "2", $trans_cd, $trans_name);
            //���Ԥ������ϥ���Хå�
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }
        }
        Db_Query($conn, "COMMIT");
        
        $def_fdata["form_trans_cd"]			=	"";
        $def_fdata["form_trans_name"]		=	"";
        $def_fdata["form_trans_cname"]		=	"";
        $def_fdata["form_post"]["no1"]		=	"";
        $def_fdata["form_post"]["no2"]		=	"";
        $def_fdata["form_address1"]			=	"";
        $def_fdata["form_address2"]			=	"";
        $def_fdata["form_address3"]			=	"";
        $def_fdata["form_tel"]				=	"";
        $def_fdata["form_fax"]				=	"";
        $def_fdata["form_green_trans"]		=	"";
        $def_fdata["form_trans_note"]		=	"";
		$def_fdata["update_flg"]			=	"";
		$form->setConstants($def_fdata);

    }

}

/*****************************/
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   trans_cd,";
$sql .= "   trans_id,";
$sql .= "   trans_name,";
$sql .= "   trans_cname,";
$sql .= "   CASE green_trans";
$sql .= "       WHEN 't' THEN '��'";
$sql .= "       WHEN 'f' THEN ''";
$sql .= "   END,";
$sql .= "   note,";
$sql .= "   post_no1 || '-' || post_no2,";
$sql .= "   address1 || address2 || address3,";
$sql .= "   tel,";
$sql .= "   fax";
$sql .= " FROM";
$sql .= "   t_trans";
$sql .= " WHERE";
$sql .= "   shop_id = $shop_id";
$sql .= " ORDER BY trans_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//��ư���ϥܥ��󲡲�
/*****************************/
if($_POST["input_button_flg"]==true){
    $post1     = $_POST["form_post"]["no1"];             //͹���ֹ棱
    $post2     = $_POST["form_post"]["no2"];             //͹���ֹ棲
    $post_value = Post_Get($post1,$post2,$conn);
    //͹���ֹ�ե饰�򥯥ꥢ
    $cons_data["input_button_flg"] = "";
    //͹���ֹ椫�鼫ư����
    $cons_data["form_post"]["no1"] = $_POST["form_post"]["no1"];
    $cons_data["form_post"]["no2"] = $_POST["form_post"]["no2"];
    $cons_data["form_address_read"] = $post_value[0];
    $cons_data["form_address1"] = $post_value[1];
    $cons_data["form_address2"] = $post_value[2];

    $form->setConstants($cons_data);

/****************************/
//CSV�ܥ��󲡲�����
/****************************/
}elseif($_POST["csv_button_flg"] == true && $_POST["form_entry_button"] != "�С�Ͽ"){

	$sql  = "SELECT";
	$sql .= "   trans_cd,";
	$sql .= "   trans_id,";
	$sql .= "   trans_name,";
	$sql .= "   trans_cname,";
	$sql .= "   CASE green_trans";
	$sql .= "       WHEN 't' THEN '��'";
	$sql .= "       WHEN 'f' THEN ''";
	$sql .= "   END,";
	$sql .= "   note,";
	$sql .= "   post_no1 || '-' || post_no2,";
	$sql .= "   address1,";
    $sql .= "   address2,";
    $sql .= "   address3,";
	$sql .= "   tel,";
	$sql .= "   fax";
	$sql .= " FROM";
	$sql .= "   t_trans";
	$sql .= " WHERE";
	$sql .= "   shop_id = $shop_id";
	$sql .= " ORDER BY trans_cd";
	$sql .= ";";

	$result = Db_Query($conn, $sql);
	$total_count = pg_num_rows($result);
	$page_data = Get_Data($result,2);

    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][2];
        $csv_page_data[$i][2] = $page_data[$i][3];
        $csv_page_data[$i][3] = $page_data[$i][6];
        $csv_page_data[$i][4] = $page_data[$i][7];
        $csv_page_data[$i][5] = $page_data[$i][8];
        $csv_page_data[$i][6] = $page_data[$i][9];
        $csv_page_data[$i][7] = $page_data[$i][10];
        $csv_page_data[$i][8] = $page_data[$i][11];
        $csv_page_data[$i][9] = $page_data[$i][4];
        $csv_page_data[$i][10] = $page_data[$i][5];
    }

    $csv_file_name = "�����ȼԥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "�����ȼԥ�����",
        "�����ȼ�̾",
        "ά��",
        "͹���ֹ�",
        "���꣱",
        "���ꣲ",
        "���ꣳ",
        "TEL",
        "FAX",
        "���꡼�����ȼ�",
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
	'comp_msg'   	=> "$comp_msg",
	'total_count'   => "$total_count",
    'auth_r_msg'    => "$auth_r_msg",
));

$smarty->assign('page_data', $page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
