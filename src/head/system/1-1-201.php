<?php
/*--------------------------------------------------------------------
    @Program         1-1-201.php
    @fnc.Overview    department master����ޥ���
    @author          �դ���
    @Cng.Tracking    #1: 2006/02/07
--------------------------------------------------------------------*/

/******************************************************/
//revision history �ѹ�����  
//  (2006/03/15)
//  ��$_SESSION[shop_id]��$_SESSION[client_id]���ѹ�
//  ��$_SESSION[shop_aid]����

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 *   2016/01/21                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�

 
 *//******************************************************/
/*----------------------------------------------------------
    �ڡ��������
----------------------------------------------------------*/

/*------------------------------------------------
    variable definition �ѿ����
------------------------------------------------*/
// page name �ڡ���̾
$page_title        = "����ޥ���";

// environment set up file �Ķ�����ե�����
require_once("ENV_local.php");

// Database connection set up DB��³����
$con               = Db_Connect();

// form �ե�����
$form = new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null );

// authorization check ���¥����å�
$auth       = Auth_Check($con);
// no input��change authorization message ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// button disabled �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// form object name �ե����४�֥�������̾
$f_part_cd         = "form_part_cd";
$f_part_name       = "form_part_name";
$f_note            = "form_note";
$f_btn_gr          = "form_btn_gr";
$f_btn_add         = "form_btn_add";
$f_btn_clear       = "form_btn_clear";
$f_btn_csv_out     = "form_btn_csv_out";
$f_hdn_post_csv    = "form_hdn_post_csv";
$f_hdn_part_id     = "form_hdn_part_id";
$f_hdn_status      = "form_hdn_status";
$f_hdn_process     = "form_hdn_process";

// label name��value ��٥�̾���Х�塼
$l_part_cd         = "���𥳡���";
$l_part_name       = "����̾";
$l_note            = "����";
$v_btn_add         = "�С�Ͽ";
$v_btn_clear       = "���ꥢ";
$v_btn_csv_out     = "CSV����";

// form string limitation�ե�����ʸ����������
$maxlen_part_cd    = 3;
$maxlen_part_name  = 8;
$maxlen_note       = 30;

// acquire session data SESSION�ǡ�������
session_start();
$ss_staff_id       = $_SESSION["staff_id"];
$ss_shop_id        = $_SESSION["client_id"];

/* check the validyt of the ID that was GET GET����ID�������������å� */
if ($_GET["id"] != null && Get_Id_Check_Db($con, $_GET["id"], "part_id", "t_part", "num", "  shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/*------------------------------------------------
    QuickForm - Form Object Definition QuickForm - �ե����४�֥����������
------------------------------------------------*/
// Text �ƥ�����
$form->addElement("text", $f_part_cd, $l_part_cd, "size=\"3\" maxlength=\"$maxlen_part_cd\" style=\"$g_form_style\" $g_form_option onKeyup=\"fontColor(this)\"");
$form->addElement("text", $f_part_name, $l_part_name,"size=\"22\" maxLength=\"$maxlen_part_name\" $g_form_option");
$form->addElement("text", $f_note, $l_note, "size=\"34\" maxlength=\"$maxlen_note\" $g_form_option");

// Button �ܥ���
$button[] = $form->createElement("submit", $f_btn_add, $v_btn_add, "onClick=\"javascript:return Dialogue4('��Ͽ���ޤ�');\" $disabled");
$button[] = $form->createElement("button", $f_btn_clear, $v_btn_clear, "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
$button[] = $form->createElement("button", $f_btn_csv_out, $v_btn_csv_out, "onClick=\"javascript:Button_Submit('$f_hdn_post_csv', '#', 'post_csv_out', this);\"");
$form->addGroup($button, $f_btn_gr, null);

// hidden
$form->addElement("hidden", $f_hdn_post_csv, null);
$form->addElement("hidden", $f_hdn_part_id, null);
$form->addElement("hidden", $f_hdn_status, null);
$form->addElement("hidden", $f_hdn_process, null);

/*----------------------------------------------------------
    Process when reading the page �ڡ����ɤ߹��߻��ν���
----------------------------------------------------------*/

/*------------------------------------------------
    Acquire POST data POST�ǡ�������
------------------------------------------------*/
// Acquire POST data (Register��Change) POST�ǡ�����������Ͽ���ѹ���
if (isset($_POST[$f_btn_gr][$f_btn_add])){
    $post_data[$f_part_cd]     = $_POST[$f_part_cd];
    $post_data[$f_part_name]   = $_POST[$f_part_name];
    $post_data[$f_note]        = $_POST[$f_note];
    $post_data[$f_hdn_part_id] = $_POST[$f_hdn_part_id];
    $post_data[$f_hdn_status]  = $_POST[$f_hdn_status];
    $post_data[$f_hdn_process] = $_POST[$f_hdn_process];
    $post_add_flg              = true;
}

// Acquire POST data (csv output) POST�ǡ���������csv���ϡ�
if ($_POST[$f_hdn_post_csv] == "post_csv_out" && $post_add_flg == false){
    $post_csv_out_flg = true;
}

/*------------------------------------------------
    Acquire Process �ץ����μ���
------------------------------------------------*/
// If being POST POST����Ƥ�����
if ($post_add_flg == true){

    // When bing POST: Other than that POST���줿���֡�����ʳ�
    $process = ($post_data[$f_hdn_process] == "begin") ? "post" : $post_data[$f_hdn_process];

// If not being POST POST����Ƥ��ʤ����
}else{

    // Initial status �������
    $process = "begin";

}

/*------------------------------------------------
    Status Decision (Change��Register) ���ơ�������Ƚ�ǡ���Ͽ���ѹ���
------------------------------------------------*/
// If there is GET data (Transition from the text link) GET�ǡ�����������ʥƥ����ȥ�󥯤�������ܡ�
if (isset($_GET["id"])){

    // Status decision using the value that was GET and the session data  GET�����ͤȥ��å����ǡ������饹�ơ�����Ƚ��
    $sql  = "SELECT ";
    $sql .= "part_id ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "part_id = ".$_GET["id"]." ";
    $sql .= "AND ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    //GET Data Decision GET�ǡ���Ƚ��
    Get_Id_Check($res);
    $status = (pg_fetch_result($res, 0, 0) == 0) ? "add" : "chg";
// If there is no GET data GET�ǡ������ʤ����
}else{

    // Initial status: Other than that ������֡�����ʳ�
    $status = ($process == "begin") ? "add" : $post_data[$f_hdn_status];

}

/*------------------------------------------------
    Acquire ID ID�μ���
------------------------------------------------*/
// If there is GET Data and if the status is changed (the ID that was GET is the valid one when transitioned from the text link) GET�ǡ��������ꡢ���ơ��������ѹ��ξ��ʥƥ����ȥ�󥯤�������ܤǡ�GET����ID��������
if (isset($_GET["id"]) && $status == "chg"){

    // Acquire GET data GET�ǡ��������
    $get_part_id = $_GET["id"];

// Other than that ����ʳ�
}else{
    // Initial Status: Other than that ������֡�����ʳ�
    $get_part_id = ($post_data[$f_hdn_process] == "complete") ? null : $post_data[$f_hdn_part_id];

}


/*----------------------------------------------------------
    Process when register button is pressed ��Ͽ�ܥ��󲡲����ν���
----------------------------------------------------------*/
// Register pressed flag ��Ͽ�����ե饰����
if ($post_add_flg == true){

    /*------------------------------------------------
        If ther is an input, digit fill operation  ���Ϥ�����з������
    ------------------------------------------------*/
    // department code (fill 0 in until 3 digits) ���𥳡��ɡ�3��ޤ�0����
    if ($post_data[$f_part_cd] != null){
        $post_data[$f_part_cd] = str_pad($post_data[$f_part_cd], $maxlen_part_cd, "0", STR_PAD_LEFT);
    }

    /*------------------------------------------------
        QuickFrom - custom rule definition QuickForm - ��������롼�����
    ------------------------------------------------*/
    // check multi-byte stringth length �ޥ���Х���ʸ����Ĺ�����å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

    // duplication check ��ʣ�����å�
    if ($status == "chg"){
        $sql  = "SELECT ";
        $sql .= "part_cd ";
        $sql .= "FROM ";
        $sql .= "t_part ";
        $sql .= "WHERE ";
        $sql .= "part_id = $get_part_id ";
        $sql .= "AND ";
        $sql .= "shop_id = $ss_shop_id ";
        $sql .= ";";
        $res  = Db_Query($con, $sql);
        $origin_data = pg_fetch_result($res, 0);
    }else{
        $origin_data = null;
    }
    $sql  = "SELECT ";
    $sql .= "COUNT(part_cd) ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "part_cd = '".$post_data[$f_part_cd]."' ";
    $sql .= "AND shop_id = $ss_shop_id ";
    $sql .= ";";
    $part_cd_duplicate_flg = Duplicate_Chk($con, $status, $origin_data, $post_data[$f_part_cd], $sql);

    /*------------------------------------------------
        QuickForm - rule definition QuickForm - �롼�����
    ------------------------------------------------*/
    // Check mandatory field ɬ�ܹ��ܥ����å�
    $form->addRule($f_part_cd, $l_part_cd." ��Ⱦ�ѿ����ΤߤǤ���", "required", null);
    $form->addRule($f_part_name, $l_part_name." ��1ʸ���ʾ�8ʸ���ʲ��Ǥ���", "required", null);
    // Only check full-width/half-width space ����/Ⱦ�ѥ��ڡ����Τߥ����å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule($f_part_name, "����̾�� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    // Check half-width numberȾ�ѿ��������å�
    $form->addRule($f_part_cd, $l_part_cd." ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

    // Duplication check ��ʣ�����å�
    if ($part_cd_duplicate_flg == true){
        $form->setElementError($f_part_cd, "���˻��Ѥ���Ƥ��� ".$l_part_cd." �Ǥ���");
    }

    /*------------------------------------------------
        QuickForm - Error check ���顼�����å�
    ------------------------------------------------*/
    $qf_err_flg = ($form->validate() == false) ? true : false;

    /*------------------------------------------------
        DB���� Database process
    ------------------------------------------------*/
    // QuickForm�ǥ��顼��̵����� If there is no error in QuickForm
    if ($qf_err_flg == false){

        Db_Query($con, "BEGIN;");

        // Process for new registration ������Ͽ���ν���
        if ($status == "add"){

            //Register the operation classification ��ȶ�ʬ����Ͽ
            $work_div = '1';
            //Registration completion message ��Ͽ��λ��å�����
            $comp_msg = "��Ͽ���ޤ�����";

            // INSERT record  �쥳���ɤ�INSERT
            $sql  = "INSERT INTO ";
            $sql .= "t_part(";
            $sql .= "part_id, part_cd, part_name, note, ";
            $sql .= "shop_id";
            $sql .= ") ";
            $sql .= "VALUES(";
            $sql .= "(SELECT COALESCE(MAX(part_id), 0)+1 FROM t_part), ";
            $sql .= "'$post_data[$f_part_cd]', ";
            $sql .= "'$post_data[$f_part_name]', ";
            $sql .= "'$post_data[$f_note]', ";
            $sql .= "$ss_shop_id ";
            $sql .= ") ";
            $sql .= ";";

        // Process when there is a change �ѹ����ν���
        }else{

            //Update the operation classification ��ȶ�ʬ�Ϲ���
            $work_div = '2';
            //Revision completion message �ѹ���λ��å�����
            $comp_msg = "�ѹ����ޤ�����";

            // UPDATE record �쥳���ɤ�UPDATE
            $sql  = "UPDATE t_part ";
            $sql .= "SET ";
            $sql .= "part_cd = '$post_data[$f_part_cd]', ";
            $sql .= "part_name = '$post_data[$f_part_name]', ";
            $sql .= "note = '$post_data[$f_note]' ";
            $sql .= "WHERE part_id = $get_part_id ";
            $sql .= ";";
            

        }
        $res  = Db_Query($con, $sql);
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        //Write the value of department master in log ����ޥ������ͤ���˽񤭹���
        $res = Log_Save($con,'part',$work_div,$post_data[$f_part_cd],$post_data[$f_part_name]);
        //If there is a n error during registering in log ����Ͽ���˥��顼�ˤʤä����
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        Db_Query($con, "COMMIT;");
    }

}

/*------------------------------------------------
    Store the process result in process ������̤�ץ����˳�Ǽ
------------------------------------------------*/
// Decide because of QuickForm Error QuickForm���顼�ˤ��Ƚ��
if ($post_add_flg == true){
    // Error: Process completed ���顼��������λ
    $process = ($qf_err_flg == true) ? "error" : "complete";
}


/*----------------------------------------------------------
    process when csv output button is pressed csv���ϥܥ��󲡲����ν���
----------------------------------------------------------*/
// Flag for when csv output is pressed csv���ϲ����ե饰����
if ($post_csv_out_flg == true){

    // Acquire record data  �쥳���ɥǡ�������
    $sql  = "SELECT ";
    $sql .= "part_cd, ";
    $sql .= "part_name, ";
    $sql .= "note ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= "ORDER BY part_cd ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    $total_count = pg_numrows($res);
    for ($i = 0; $i < $total_count; $i++){
        $ary_csv_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
    }

    // create csv file csv�ե��������
    $csv_file_name = $page_title.date("Ymd").".csv";
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_header    = array($l_part_cd, $l_part_name, $l_note);
    $csv_data      = Make_Csv($ary_csv_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}


/*----------------------------------------------------------
    Process for display output ���̽����ѽ���
----------------------------------------------------------*/

/*------------------------------------------------
    Acquire data for list �����ѥǡ�������
------------------------------------------------*/
// Acquire all record data �쥳���ɥǡ��������Ƽ���
$sql  = "SELECT ";
$sql .= "part_id, ";
$sql .= "part_cd, ";
$sql .= "part_name, ";
$sql .= "note ";
$sql .= "FROM ";
$sql .= "t_part ";
$sql .= "WHERE ";
$sql .= "shop_id = $ss_shop_id ";
$sql .= "ORDER BY part_cd ";
$sql .= ";";
$res  = Db_Query($con, $sql);
$total_count = pg_numrows($res);
for ($i = 0; $i < $total_count; $i++){
    $ary_list_data[] = @pg_fetch_array($res, $i, PGSQL_NUM);
}

// sanitizing ���˥�������
for ($i = 0; $i < $total_count; $i++){
    for($j = 0; $j < count($ary_list_data[$i]); $j++){
        $ary_list_data[$i][$j] = htmlspecialchars($ary_list_data[$i][$j]);
    }
}

/*------------------------------------------------
    acquire/create data for complement in form �ե�������䴰����ǡ����μ���������
------------------------------------------------*/
// At the start of the process when the status was changed ���ơ��������ѹ��ǡ��������ϻ�
if ($status == "chg" && $process == "begin"){

    // Acquire appropriate data from the database DB���鳺���Υ쥳���ɼ���
    $sql  = "SELECT ";
    $sql .= "part_cd, ";
    $sql .= "part_name, ";
    $sql .= "note ";
    $sql .= "FROM ";
    $sql .= "t_part ";
    $sql .= "WHERE ";
    $sql .= "part_id = ".$_GET["id"]." ";
    $sql .= "AND ";
    $sql .= "shop_id = $ss_shop_id ";
    $sql .= ";";
    $res  = Db_Query($con, $sql);
    $ary_rec_row_data = pg_fetch_array($res, 0, PGSQL_ASSOC);

    // �쥳���ɥǡ������䴰 complement the record data
    $form_data[$f_part_cd]   = $ary_rec_row_data["part_cd"];
    $form_data[$f_part_name] = $ary_rec_row_data["part_name"];
    $form_data[$f_note]      = $ary_rec_row_data["note"];

// ���顼�� at error 
}elseif ($process == "post" || $process == "error"){

    // POST���줿�ǡ����򤽤Τޤ��䴰 Complement the data that was POST
    $form_data[$f_part_cd]   = null;
    $form_data[$f_part_name] = null;
    $form_data[$f_note]      = null;

// ����¾ others
}else{

    // ������䴰 complement the blank part
    $form_data[$f_part_cd]   = "";
    $form_data[$f_part_name] = "";
    $form_data[$f_note]      = "";

}

/*------------------------------------------------
    �ե�������䴰����hidden�μ��������� acquire/create the hidden that will complement the form 
------------------------------------------------*/
// ������λ�ʤ� when the process is complete
if ($process == "complete"){

    // hidden�������֤� initialize the hidden
    $form_data[$f_hdn_part_id] = "";
    $form_data[$f_hdn_status]  = "add";
    $form_data[$f_hdn_process] = "begin";

// ����ʳ� others
}else{

    // hidden�ǡ������ݻ� save the hidden data 
    $form_data[$f_hdn_part_id] = $get_part_id;
    $form_data[$f_hdn_status]  = $status;
    $form_data[$f_hdn_process] = $process;

}

/*------------------------------------------------
    �ե�����إǡ����䴰 complement the data to form
------------------------------------------------*/
$part_form = array(
    $f_part_cd     => $form_data[$f_part_cd],
    $f_part_name   => $form_data[$f_part_name],
    $f_note        => $form_data[$f_note],
    $f_hdn_part_id => $form_data[$f_hdn_part_id],
    $f_hdn_status  => $form_data[$f_hdn_status],
    $f_hdn_process => $form_data[$f_hdn_process]
);
$form->setConstants($part_form);


/****************************/
//HTML�إå� html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h("system", "1");

/****************************/
//���̥إå������� create screen header
/****************************/
$page_title .= "(��".$total_count."��)";
$page_header = Create_Header($page_title);

// Render��Ϣ������ setting for Render related 
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign Form related variable
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign assign other variables
$smarty->assign("var", array(
	"html_header" => "$html_header",
	"page_menu"   => "$page_menu",
	"page_header" => "$page_header",
	"html_footer" => "$html_footer",
	"html_page"   => "$html_page",
	"html_page2"  => "$html_page2",
	"total_count" => "$total_count",
    "qf_err_flg"  => "$qf_err_flg",
    "comp_msg"    => "$comp_msg",
    "auth_r_msg"  => "$auth_r_msg"
));
$smarty->assign("ary_list_data", $ary_list_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the template value
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
