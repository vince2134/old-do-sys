<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/18) �����ӥ������ɤ��ϰϥ����å����(suzuki-t)
 * 1.1.0 (2006/03/20) �����ӥ������ɤν�ʣ�����å�����(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/20)
*/

$page_title = "�����ӥ��ޥ���";

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
// ����ܥ���Disabled
$del_disabled = ($auth[1] == "f") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION["client_id"];

/* GET����ID�������������å� */
if ($_GET["serv_id"] != null && Get_Id_Check_Db($db_con, $_GET["serv_id"], "serv_id", "t_serv", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//���ɽ��
/****************************/
$def_data["form_tax_div"]       = 1;                        //���Ƕ�ʬ
$def_data["form_accept"]        = "2";
$form->setDefaults($def_data);

/****************************/
//�������
/****************************/
//�����ӥ�������
$form->addElement("text","form_serv_cd","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//�����ӥ�̾
$form->addElement("text","form_serv_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//����
$form->addElement("text","form_note","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\"".$g_form_option."\"");
//���Ƕ�ʬ
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "�����","3");
$form->addGroup( $tax_div, "form_tax_div","");
//��ǧ�饸���ܥ���
$form_accept[] =& $form->createElement("radio", null, null, "��ǧ��", "1");
$form_accept[] =& $form->createElement("radio", null, null, "̤��ǧ", "2");
$form->addGroup($form_accept, "form_accept", "");
//���ꥢ
$form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//��Ͽ
$form->addElement("submit","entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#')\" $disabled");
//CSV����
$form->addElement("button","csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg','#','true')\"");

//������󥯲���Ƚ��ե饰
$form->addElement("hidden", "update_flg");
//CSV���ϥܥ��󲡲�Ƚ��ե饰
$form->addElement("hidden", "csv_button_flg");

/******************************/
//CSV���ϥܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"]==true && $_POST["entry_button"] != "�С�Ͽ"){
    /** CSV����SQL **/
    $sql = "SELECT ";
    $sql .= "serv_cd,";                //�����ӥ�������
    $sql .= "serv_name,";              //�����ӥ�̾
	$sql .= "CASE tax_div ";           //���Ƕ�ʬ
	$sql .= "    WHEN '1' THEN '����'";
	$sql .= "    WHEN '2' THEN '����'";
	$sql .= "    WHEN '3' THEN '�����'";
    $sql .= "END,";
	$sql .= "note, ";                   //����
    $sql .= "accept_flg ";
    $sql .= "FROM ";
    $sql .= "t_serv ";
    $sql .= "WHERE ";
    $sql .= "public_flg = true ";
    $sql .= "ORDER BY ";
    $sql .= "serv_cd;";

    $result = Db_Query($db_con,$sql);

    //CSV�ǡ�������
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //�����ӥ�������
        $serv_data[$i][0] = $data_list[0];
        //�����ӥ�̾
        $serv_data[$i][1] = $data_list[1];
        //���Ƕ�ʬ
        $serv_data[$i][2] = $data_list[2];
		//����
        $serv_data[$i][3] = $data_list[3];
		//��ǧ
        $serv_data[$i][4] = ($data_list[4] == "1") ? "��" : "��";
        $i++;
    }

    //CSV�ե�����̾
    $csv_file_name = "�����ӥ��ޥ���".date("Ymd").".csv";
    //CSV�إå�����
    $csv_header = array(
        "�����ӥ�������", 
        "�����ӥ�̾",
		"���Ƕ�ʬ",
        "����",
        "��ǧ"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($serv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;    
}

/****************************/
//�ѹ������ʥ�󥯡�
/****************************/

//�ѹ���󥯲���Ƚ��
if($_GET["serv_id"] != ""){

    //�ѹ������󥿥�ID�����
    $update_num = $_GET["serv_id"];

    /** �����ӥ��ޥ�������SQL���� **/
    $sql = "SELECT ";
    $sql .= "serv_cd,";                //�����ӥ�������
    $sql .= "serv_name,";              //�����ӥ�̾
	$sql .= "tax_div,";                //���Ƕ�ʬ
    $sql .= "note, ";                  //����
    $sql .= "accept_flg ";
    $sql .= "FROM ";
    $sql .= "t_serv ";
    $sql .= "WHERE ";
    $sql .= "public_flg = 't' ";
    $sql .= "AND ";
    $sql .= "serv_id = ".$update_num.";";
    $result = Db_Query($db_con,$sql);
    //GET�ǡ���Ƚ��
    Get_Id_Check($result);
    $data_list = pg_fetch_array($result,0);

    //�ե�������ͤ�����
    $def_fdata["form_serv_cd"]                        =    $data_list[0];  
    $def_fdata["form_serv_name"]                      =    $data_list[1]; 
	$def_fdata["form_tax_div"]                        =    $data_list[2];  
    $def_fdata["form_note"]                           =    $data_list[3]; 
    $def_fdata["form_accept"]                         =    $data_list[4]; 
    $def_fdata["update_flg"]                          =    "true"; 
    
    $form->setDefaults($def_fdata);
}

/****************************/
//���顼�����å�(AddRule)
/****************************/
//�������ӥ�������
//��ɬ�ܥ����å�
$form->addRule('form_serv_cd','�����ӥ������� ��Ⱦ�ѿ����ΤߤǤ���','required');
//��ʸ��������å�
$form->addRule('form_serv_cd','�����ӥ������� ��Ⱦ�ѿ����ΤߤǤ���', "regex", "/^[0-9]+$/");

//�������ӥ�̾
//��ɬ�ܥ����å�
$form->addRule('form_serv_name','�����ӥ�̾ ��1ʸ���ʾ�15ʸ���ʲ��Ǥ���','required');
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_serv_name", "�����ӥ�̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

/****************************/
//��Ͽ����
/****************************/
if($_POST["entry_button"] == "�С�Ͽ"){
    //���ϥե������ͼ���
    $serv_cd      = $_POST["form_serv_cd"];                //�����ӥ�������
    $serv_name    = $_POST["form_serv_name"];              //�����ӥ�̾
	$tax_div      = $_POST["form_tax_div"];                //���Ƕ�ʬ
    $note         = $_POST["form_note"];                   //���� 
    $accept       = $_POST["form_accept"];                 //
    $update_flg   = $_POST["update_flg"];                  //��Ͽ������Ƚ��
    $update_num   = $_GET["serv_id"];                      //�����ӥ�ID


    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    //�������ӥ�������
    //����ʣ�����å�
    //���������η�
    if($serv_cd != null){
        //�����ӥ������ɤˣ�������
        $serv_cd = str_pad($serv_cd, 4, 0, STR_POS_LEFT);
        //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
        $sql  = "SELECT ";
        $sql .= "serv_cd ";                //�����ӥ�������
        $sql .= "FROM ";
        $sql .= "t_serv ";
        $sql .= "WHERE ";
        $sql .= "serv_cd = '$serv_cd' ";
        $sql .= "AND ";
        $sql .= "shop_id = $shop_id";

        //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if($update_num != null && $update_flg == "true"){
            $sql .= " AND NOT ";
            $sql .= "serv_id = '$update_num'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_serv_cd","���˻��Ѥ���Ƥ��� �����ӥ������� �Ǥ���");
        }
/*
        //�������η�
        if($serv_cd >= 5000 && $serv_cd < 9000){
            $form->setElementError("form_serv_cd","�����ӥ������� ��5000��8999�����ѤǤ��ޤ���");
        }
*/
    }

    //���顼�κݤˤϡ���Ͽ������Ԥ�ʤ�
    if($form->validate()){
        
        Db_Query($db_con, "BEGIN;");

        //��������Ͽ��Ƚ��
        if($update_flg == "true"){
            //��ȶ�ʬ�Ϲ���
            $work_div = '2';
            //�ѹ���λ��å�����
            $comp_msg = "�ѹ����ޤ�����";

            $sql  = "UPDATE ";
            $sql .= "t_serv ";
            $sql .= "SET ";
            $sql .= "serv_cd = '$serv_cd',";
            $sql .= "serv_name = '$serv_name',";
			$sql .= "tax_div = '$tax_div',";
            $sql .= "note = '$note', ";
            $sql .= "accept_flg = '$accept' ";
            $sql .= "WHERE ";
            $sql .= "serv_id = $update_num;";
        }else{
            //��ȶ�ʬ����Ͽ
            $work_div = '1';
            //��Ͽ��λ��å�����
            $comp_msg = "��Ͽ���ޤ�����";

            $sql  = "INSERT INTO ";
            $sql .= "t_serv (";
			$sql .= "serv_id,";
			$sql .= "serv_cd,";
			$sql .= "serv_name,";
			$sql .= "tax_div,";
			$sql .= "note,";
			$sql .= "public_flg,";
			$sql .= "shop_id, ";
            $sql .= "accept_flg ";
            $sql .= ")VALUES(";
            $sql .= "(SELECT ";
            $sql .= "COALESCE(MAX(serv_id), 0)+1 ";
            $sql .= "FROM ";
            $sql .= "t_serv),";
            $sql .= "'$serv_cd',";
            $sql .= "'$serv_name',";
			$sql .= "'$tax_div',";
            $sql .= "'$note',";
            $sql .= "true,";
            $sql .= "$shop_id,";
            $sql .= "'$accept');";
        }
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        //�����ӥ��ޥ������ͤ���˽񤭹���
        $result = Log_Save($db_con,'serv',$work_div,$serv_cd,$serv_name);
        //����Ͽ���˥��顼�ˤʤä����
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");

        //�ե�������ͤ�����
        $def_fdata["form_serv_cd"]                        =    "";
        $def_fdata["form_serv_name"]                      =    "";
		$def_fdata["form_tax_div"]                        =    "1";
        $def_fdata["form_note"]                           =    "";
        $def_fdata["form_accept"]                         =    "2";
        $def_fdata["update_flg"]                          =    "";

        $form->setConstants($def_fdata);
    }
}

/******************************/
//�إå�����ɽ�������������
/*****************************/
/** �����ӥ��ޥ�������SQL���� **/
$sql = "SELECT ";
$sql .= "serv_id,";                //�����ӥ�ID
$sql .= "serv_cd,";                //�����ӥ�������
$sql .= "serv_name,";              //�����ӥ�̾
$sql .= "CASE tax_div ";           //���Ƕ�ʬ
$sql .= "    WHEN '1' THEN '����'";
$sql .= "    WHEN '2' THEN '����'";
$sql .= "    WHEN '3' THEN '�����'";
$sql .= "END,";
$sql .= "note, ";                   //����
$sql .= "accept_flg ";
$sql .= "FROM ";
$sql .= "t_serv ";
$sql .= "WHERE ";
$sql .= "public_flg = true ";
$sql .= "ORDER BY ";
$sql .= "serv_cd;";

$result = Db_Query($db_con,$sql);
//���������(�إå���)
$total_count = pg_num_rows($result);

//�ԥǡ������ʤ����
$row = Get_Data($result);

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
    'comp_msg'      => "$comp_msg",
    'auth_r_msg'    => "$auth_r_msg",
));
$smarty->assign('row',$row);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
