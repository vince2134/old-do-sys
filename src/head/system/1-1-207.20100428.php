<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/20) �ƽХ����ɤν�ʣ�����å�����(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.1.0 (2006/03/20)
*/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-01-23      �����ѹ�����watanabe-k���ܥ���ο����ѹ�
 *  2010-04-28      Rev.1.5���� hashimoto-y ��ɽ����ǽ���ɲ�
 *
*/




$page_title = "��ԥޥ���";

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

/****************************/
//�����ѿ�����
/****************************/
$shop_id  = $_SESSION[client_id];

/* GET����ID�������������å� */
if ($_GET["bank_id"] != null && Get_Id_Check_Db($db_con, $_GET["bank_id"], "bank_id", "t_bank", "num", " shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/****************************/
//�������
/****************************/
//��ԥ�����
$form->addElement("text","form_bank_cd","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"".$g_form_option."\"");
//���̾
$form->addElement("text","form_bank_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//���̾�ʥեꥬ�ʡ�
$form->addElement("text","form_bank_kana","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\"".$g_form_option."\"");
//ά��
$form->addElement("text","form_bank_cname","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\"".$g_form_option."\"");

#2010-04-22 hashimoto-y
$form->addElement('checkbox', 'form_nondisp_flg', '', '');

//����
$form->addElement("text","form_note","�ƥ����ȥե�����","size=\"34\" maxLength=\"30\"".$g_form_option."\"");
//���ꥢ
$form->addElement("button","clear_button","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
//��Ͽ
$form->addElement("submit","entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#')\" $disabled");
//CSV����
$form->addElement("button","csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg','#','true')\"");

$form->addElement("button","bank_button","�����Ͽ����",$g_button_color." onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","bank_mine_button","��Ź��Ͽ����","onClick=\"javascript:Referer('1-1-208.php')\"");
$form->addElement("button","bank_account_button","������Ͽ����","onClick=\"javascript:Referer('1-1-210.php')\"");

//������󥯲���Ƚ��ե饰
$form->addElement("hidden", "update_flg");
//CSV���ϥܥ��󲡲�Ƚ��ե饰
$form->addElement("hidden", "csv_button_flg");

/******************************/
//CSV���ϥܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"]==true && $_POST["entry_button"] != "�С�Ͽ" && $_POST["input_button_flg"]!=true){
    /** CSV����SQL **/
    $sql = "SELECT ";
    $sql .= "   bank_cd,";             //��ԥ�����
    $sql .= "   bank_name,";           //���̾
    $sql .= "   bank_kana, ";          //���̾�ʥեꥬ�ʡ�
    $sql .= "   bank_cname,";          //ά��
    #2010-04-28 hashimoto-y
    $sql .= "   CASE nondisp_flg";     //��ɽ��
    $sql .= "   WHEN true  THEN '��'";          
    $sql .= "   WHEN false THEN ''";          
    $sql .= "   END,";          

    $sql .= "   note ";                //����
    $sql .= " FROM ";
    $sql .= "   t_bank ";
    $sql .= " WHERE ";
    $sql .= "   shop_id = $shop_id ";
    $sql .= "   ORDER BY ";
    $sql .= "   bank_cd;";

    $result = Db_Query($db_con,$sql);

    //CSV�ǡ�������
    $i=0;
    while($data_list = pg_fetch_array($result)){
        //��ԥ�����
        $bank_data[$i][0] = $data_list[0];
        //���̾
        $bank_data[$i][1] = $data_list[1];
        //���̾�ʥեꥬ�ʡ�
        $bank_data[$i][2] = $data_list[2];
        //ά��
        $bank_data[$i][3] = $data_list[3];

        #2010-04-28 hashimoto-y
        #//����
        #$bank_data[$i][4] = $data_list[4];
        //��ɽ��
        $bank_data[$i][4] = $data_list[4];
        //����
        $bank_data[$i][5] = $data_list[5];
        $i++;
    }

    //CSV�ե�����̾
    $csv_file_name = "��ԥޥ���".date("Ymd").".csv";
    //CSV�إå�����
    $csv_header = array(
        "��ԥ�����", 
        "���̾",
        "���̾�ʥեꥬ�ʡ�",
        "ά��",
        #2010-04-28 hashimoto-y
        "��ɽ��",
        "����"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($bank_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/****************************/
//�ѹ������ʥ�󥯡�
/****************************/

//�ѹ���󥯲���Ƚ��
if($_GET["bank_id"] != ""){

    //�ѹ������󥿥�ID�����
    $update_num = $_GET["bank_id"];

    /** ��ԥޥ�������SQL���� **/
    $sql = "SELECT ";
    $sql .= "bank_cd,";             //��ԥ�����
    $sql .= "bank_name,";           //���̾
    $sql .= "bank_kana,";           //���̾�ʥեꥬ�ʡ�
    $sql .= "bank_cname,";          //ά��
    #2010-04-28 hashimoto-y
    $sql .= "nondisp_flg,";         //��ɽ��
    $sql .= "note ";                //����
    $sql .= "FROM ";
    $sql .= "t_bank ";
    $sql .= "WHERE ";
    $sql .= "shop_id = $shop_id ";
	$sql .= "AND ";
    $sql .= "bank_id = ".$update_num.";";
    $result = Db_Query($db_con,$sql);
    //GET�ǡ���Ƚ��
    Get_Id_Check($result);
    $data_list = pg_fetch_array($result,0);

    //�ե�������ͤ�����
    $def_fdata["form_bank_cd"]                        =    $data_list[0];  
    $def_fdata["form_bank_name"]                      =    $data_list[1];  
    $def_fdata["form_bank_kana"]                      =    $data_list[2];  
    $def_fdata["form_bank_cname"]                     =    $data_list[3];  
    #2010-04-28 hashimoto-y
    #$def_fdata["form_note"]                           =    $data_list[4]; 
    $def_fdata["form_nondisp_flg"]                    =    ($data_list[4] == 't')? 1 : 0; 
    $def_fdata["form_note"]                           =    $data_list[5]; 
    $def_fdata["update_flg"]                          =    "true"; 

    $form->setDefaults($def_fdata);
}

/****************************/
//���顼�����å�(AddRule)
/****************************/
//����ԥ�����
//��ɬ�ܥ����å�
$form->addRule('form_bank_cd','��ԥ����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���','required');
$form->addRule('form_bank_cd','��ԥ����ɤ�Ⱦ�ѿ����Τ�4��Ǥ���', "regex", "/^[0-9]+$/");

//�����̾
//��ɬ�ܥ����å�
$form->addRule('form_bank_name','���̾ ��1ʸ���ʾ�15ʸ���ʲ��Ǥ���','required');
// ����/Ⱦ�ѥ��ڡ����Τߥ����å�
$form->registerRule("no_sp_name", "function", "No_Sp_Name");
$form->addRule("form_bank_name", "���̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

//�����̾�ʥեꥬ�ʡ�
//��ɬ�ܥ����å�
$form->addRule('form_bank_kana','���̾�ʥեꥬ�ʡ� ��1ʸ���ʾ�15ʸ���ʲ��Ǥ���','required');

//��ά��
//��ɬ�ܥ����å�
$form->addRule('form_bank_cname','ά�� ��1ʸ���ʾ�10ʸ���ʲ��Ǥ���','required');

/****************************/
//��Ͽ����
/****************************/
if($_POST["entry_button"] == "�С�Ͽ"){
    //���ϥե������ͼ���
    $bank_cd      = $_POST["form_bank_cd"];                 //��ԥ�����
    $bank_name    = $_POST["form_bank_name"];               //���̾
    $bank_kana    = $_POST["form_bank_kana"];               //���̾�ʥեꥬ�ʡ�
    $bank_cname   = $_POST["form_bank_cname"];              //ά��
    #2010-04-28 hashimoto-y
    $nondisp_flg  = ($_POST["form_nondisp_flg"] == '1')? 't' : 'f';             //��ɽ��
    $note         = $_POST["form_note"];                    //���� 
    $update_flg   = $_POST["update_flg"];                   //��Ͽ������Ƚ��
    $update_num   = $_GET["bank_id"];                       //���ID


    /****************************/
    //���顼�����å�(PHP)
    /****************************/
    //���ƽХ�����
    //����ʣ�����å�
    if($bank_cd != null){
        //�ƽХ����ɤˣ�������
        $bank_cd = str_pad($bank_cd, 4, 0, STR_POS_LEFT);
        //���Ϥ��������ɤ��ޥ�����¸�ߤ��뤫�����å�
        $sql  = "SELECT ";
        $sql .= "   bank_cd ";                //�ƽХ�����
        $sql .= "FROM ";
        $sql .= "   t_bank ";
        $sql .= "WHERE ";
        $sql .= "   bank_cd = '$bank_cd' ";
        $sql .= "   AND ";
        $sql .= "   shop_id = $shop_id";

        //�ѹ��ξ��ϡ���ʬ�Υǡ����ʳ��򻲾Ȥ���
        if($update_num != null && $update_flg == "true"){
            $sql .= " AND NOT ";
            $sql .= "bank_id = '$update_num'";
        }
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $row_count = pg_num_rows($result);
        if($row_count != 0){
            $form->setElementError("form_bank_cd","���˻��Ѥ���Ƥ��� ��ԥ����� �Ǥ���");
        }
    }

    //�����̾�ʥեꥬ�ʡ�
    //�������ʸ���������Ѳ�ǽ
    if (!mb_ereg("^[0-9A-Z��-�ݎގߎ��� ]+$", $bank_kana)){
        $form->setElementError("form_bank_kana", "���̾�ʥեꥬ�ʡ� �ϡ�Ⱦ�ю��š���ʸ���ˤ�Ⱦ�ѱѿ�������ʸ���ˤΤ߻��Ѳ�ǽ�Ǥ���");
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
            $sql .= "t_bank ";
            $sql .= "SET ";
            $sql .= "bank_cd = '$bank_cd',";
            $sql .= "bank_name = '$bank_name',";
            $sql .= "bank_kana = '$bank_kana',";
            $sql .= "bank_cname = '$bank_cname',";
            #2010-04-28 hashimoto-y
            $sql .= "nondisp_flg = '$nondisp_flg',";
            $sql .= "note = '$note' ";
            $sql .= "WHERE ";
            $sql .= "bank_id = $update_num;";
        }else{
            //��ȶ�ʬ����Ͽ
            $work_div = '1';
            //��Ͽ��λ��å�����
            $comp_msg = "��Ͽ���ޤ�����";

            $sql  = "INSERT INTO t_bank (";
            $sql .= "   bank_id,";
            $sql .= "   bank_cd,";
            $sql .= "   bank_name,";
            $sql .= "   bank_kana,";
            $sql .= "   bank_cname,";
            #2010-04-28 hashimoto-y
            $sql .= "   nondisp_flg,";
            $sql .= "   note,";
            $sql .= "   shop_id";
            $sql .= " )VALUES(";
            $sql .= " (SELECT COALESCE(MAX(bank_id), 0)+1 FROM t_bank),";
            $sql .= "'$bank_cd',";
            $sql .= "'$bank_name',";
            $sql .= "'$bank_kana',";
            $sql .= "'$bank_cname',";
            #2010-04-28 hashimoto-y
            $sql .= "'$nondisp_flg',";
            $sql .= "'$note',";
            $sql .= "$shop_id);";
        }
        $result = Db_Query($db_con,$sql);
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        //��ԥޥ������ͤ���˽񤭹���
        $result = Log_Save($db_con,'bank',$work_div,$bank_cd,$bank_name);
        //����Ͽ���˥��顼�ˤʤä����
        if($result == false){
            Db_Query($db_con,"ROLLBACK;");
            exit;
        }
        Db_Query($db_con, "COMMIT;");

        //�ե�������ͤ�����
        $def_fdata["form_bank_cd"]                        =    "";
        $def_fdata["form_bank_name"]                      =    "";
        $def_fdata["form_bank_kana"]                      =    "";
        $def_fdata["form_bank_cname"]                     =    "";
        #2010-04-28 hashimoto-y
        $def_fdata["form_nondisp_flg"]                    =    "";
        $def_fdata["form_note"]                           =    "";
        $def_fdata["update_flg"]                          =    "";

        $form->setConstants($def_fdata);
    }
}

/******************************/
//�إå�����ɽ�������������
/*****************************/
/** ��ԥޥ�������SQL���� **/
$sql  = "SELECT ";
$sql .= "   bank_id,";                //���ID
$sql .= "   bank_cd,";                //��ԥ�����
$sql .= "   bank_name,";              //���̾
$sql .= "   bank_kana,";              //���̾�ʥեꥬ�ʡ�
$sql .= "   bank_cname,";             //ά��
#2010-04-28 hashimoto-y
$sql .= "   CASE nondisp_flg";     //��ɽ��
$sql .= "   WHEN true  THEN '��'";          
$sql .= "   WHEN false THEN ''";          
$sql .= "   END,";          

$sql .= "   note";
$sql .= " FROM ";
$sql .= "   t_bank ";
$sql .= " WHERE ";
$sql .= "   shop_id = $shop_id ";
$sql .= " ORDER BY bank_cd;";

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
$page_title .= "��".$form->_elements[$form->_elementIndex[bank_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[bank_mine_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[bank_account_button]]->toHtml();
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
