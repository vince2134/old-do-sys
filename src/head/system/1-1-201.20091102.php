<?php
/*--------------------------------------------------------------------
    @Program         1-1-201.php
    @fnc.Overview    ����ޥ���
    @author          �դ���
    @Cng.Tracking    #1: 2006/02/07
--------------------------------------------------------------------*/

/******************************************************/
//�ѹ�����  
//  (2006/03/15)
//  ��$_SESSION[shop_id]��$_SESSION[client_id]���ѹ�
//  ��$_SESSION[shop_aid]����
/******************************************************/
/*----------------------------------------------------------
    �ڡ��������
----------------------------------------------------------*/

/*------------------------------------------------
    �ѿ����
------------------------------------------------*/
// �ڡ���̾
$page_title        = "����ޥ���";

// �Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$con               = Db_Connect();

// �ե�����
$form = new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]", null );

// ���¥����å�
$auth       = Auth_Check($con);
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

// �ե����४�֥�������̾
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

// ��٥�̾���Х�塼
$l_part_cd         = "���𥳡���";
$l_part_name       = "����̾";
$l_note            = "����";
$v_btn_add         = "�С�Ͽ";
$v_btn_clear       = "���ꥢ";
$v_btn_csv_out     = "CSV����";

// �ե�����ʸ����������
$maxlen_part_cd    = 3;
$maxlen_part_name  = 8;
$maxlen_note       = 30;

// SESSION�ǡ�������
session_start();
$ss_staff_id       = $_SESSION["staff_id"];
$ss_shop_id        = $_SESSION["client_id"];

/* GET����ID�������������å� */
if ($_GET["id"] != null && Get_Id_Check_Db($con, $_GET["id"], "part_id", "t_part", "num", "  shop_id = 1 ") != true){
    header("Location: ../top.php");
}

/*------------------------------------------------
    QuickForm - �ե����४�֥����������
------------------------------------------------*/
// �ƥ�����
$form->addElement("text", $f_part_cd, $l_part_cd, "size=\"3\" maxlength=\"$maxlen_part_cd\" style=\"$g_form_style\" $g_form_option onKeyup=\"fontColor(this)\"");
$form->addElement("text", $f_part_name, $l_part_name,"size=\"22\" maxLength=\"$maxlen_part_name\" $g_form_option");
$form->addElement("text", $f_note, $l_note, "size=\"34\" maxlength=\"$maxlen_note\" $g_form_option");

// �ܥ���
$button[] = $form->createElement("submit", $f_btn_add, $v_btn_add, "onClick=\"javascript:return Dialogue4('��Ͽ���ޤ�');\" $disabled");
$button[] = $form->createElement("button", $f_btn_clear, $v_btn_clear, "onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");
$button[] = $form->createElement("button", $f_btn_csv_out, $v_btn_csv_out, "onClick=\"javascript:Button_Submit('$f_hdn_post_csv', '#', 'post_csv_out');\"");
$form->addGroup($button, $f_btn_gr, null);

// hidden
$form->addElement("hidden", $f_hdn_post_csv, null);
$form->addElement("hidden", $f_hdn_part_id, null);
$form->addElement("hidden", $f_hdn_status, null);
$form->addElement("hidden", $f_hdn_process, null);

/*----------------------------------------------------------
    �ڡ����ɤ߹��߻��ν���
----------------------------------------------------------*/

/*------------------------------------------------
    POST�ǡ�������
------------------------------------------------*/
// POST�ǡ�����������Ͽ���ѹ���
if (isset($_POST[$f_btn_gr][$f_btn_add])){
    $post_data[$f_part_cd]     = $_POST[$f_part_cd];
    $post_data[$f_part_name]   = $_POST[$f_part_name];
    $post_data[$f_note]        = $_POST[$f_note];
    $post_data[$f_hdn_part_id] = $_POST[$f_hdn_part_id];
    $post_data[$f_hdn_status]  = $_POST[$f_hdn_status];
    $post_data[$f_hdn_process] = $_POST[$f_hdn_process];
    $post_add_flg              = true;
}

// POST�ǡ���������csv���ϡ�
if ($_POST[$f_hdn_post_csv] == "post_csv_out" && $post_add_flg == false){
    $post_csv_out_flg = true;
}

/*------------------------------------------------
    �ץ����μ���
------------------------------------------------*/
// POST����Ƥ�����
if ($post_add_flg == true){

    // POST���줿���֡�����ʳ�
    $process = ($post_data[$f_hdn_process] == "begin") ? "post" : $post_data[$f_hdn_process];

// POST����Ƥ��ʤ����
}else{

    // �������
    $process = "begin";

}

/*------------------------------------------------
    ���ơ�������Ƚ�ǡ���Ͽ���ѹ���
------------------------------------------------*/
// GET�ǡ�����������ʥƥ����ȥ�󥯤�������ܡ�
if (isset($_GET["id"])){

    // GET�����ͤȥ��å����ǡ������饹�ơ�����Ƚ��
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
    //GET�ǡ���Ƚ��
    Get_Id_Check($res);
    $status = (pg_fetch_result($res, 0, 0) == 0) ? "add" : "chg";
// GET�ǡ������ʤ����
}else{

    // ������֡�����ʳ�
    $status = ($process == "begin") ? "add" : $post_data[$f_hdn_status];

}

/*------------------------------------------------
    ID�μ���
------------------------------------------------*/
// GET�ǡ��������ꡢ���ơ��������ѹ��ξ��ʥƥ����ȥ�󥯤�������ܤǡ�GET����ID��������
if (isset($_GET["id"]) && $status == "chg"){

    // GET�ǡ��������
    $get_part_id = $_GET["id"];

// ����ʳ�
}else{
    // ������֡�����ʳ�
    $get_part_id = ($post_data[$f_hdn_process] == "complete") ? null : $post_data[$f_hdn_part_id];

}


/*----------------------------------------------------------
    ��Ͽ�ܥ��󲡲����ν���
----------------------------------------------------------*/
// ��Ͽ�����ե饰����
if ($post_add_flg == true){

    /*------------------------------------------------
        ���Ϥ�����з������
    ------------------------------------------------*/
    // ���𥳡��ɡ�3��ޤ�0����
    if ($post_data[$f_part_cd] != null){
        $post_data[$f_part_cd] = str_pad($post_data[$f_part_cd], $maxlen_part_cd, "0", STR_PAD_LEFT);
    }

    /*------------------------------------------------
        QuickForm - ��������롼�����
    ------------------------------------------------*/
    // �ޥ���Х���ʸ����Ĺ�����å�
    $form->registerRule("mb_maxlength", "function", "Mb_Maxlength");

    // ��ʣ�����å�
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
        QuickForm - �롼�����
    ------------------------------------------------*/
    // ɬ�ܹ��ܥ����å�
    $form->addRule($f_part_cd, $l_part_cd." ��Ⱦ�ѿ����ΤߤǤ���", "required", null);
    $form->addRule($f_part_name, $l_part_name." ��1ʸ���ʾ�8ʸ���ʲ��Ǥ���", "required", null);
    // ����/Ⱦ�ѥ��ڡ����Τߥ����å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule($f_part_name, "����̾�� ���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    // Ⱦ�ѿ��������å�
    $form->addRule($f_part_cd, $l_part_cd." ��Ⱦ�ѿ����ΤߤǤ���", "regex", "/^[0-9]+$/");

    // ��ʣ�����å�
    if ($part_cd_duplicate_flg == true){
        $form->setElementError($f_part_cd, "���˻��Ѥ���Ƥ��� ".$l_part_cd." �Ǥ���");
    }

    /*------------------------------------------------
        QuickForm - ���顼�����å�
    ------------------------------------------------*/
    $qf_err_flg = ($form->validate() == false) ? true : false;

    /*------------------------------------------------
        DB����
    ------------------------------------------------*/
    // QuickForm�ǥ��顼��̵�����
    if ($qf_err_flg == false){

        Db_Query($con, "BEGIN;");

        // ������Ͽ���ν���
        if ($status == "add"){

            //��ȶ�ʬ����Ͽ
            $work_div = '1';
            //��Ͽ��λ��å�����
            $comp_msg = "��Ͽ���ޤ�����";

            // �쥳���ɤ�INSERT
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

        // �ѹ����ν���
        }else{

            //��ȶ�ʬ�Ϲ���
            $work_div = '2';
            //�ѹ���λ��å�����
            $comp_msg = "�ѹ����ޤ�����";

            // �쥳���ɤ�UPDATE
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
        //����ޥ������ͤ���˽񤭹���
        $res = Log_Save($con,'part',$work_div,$post_data[$f_part_cd],$post_data[$f_part_name]);
        //����Ͽ���˥��顼�ˤʤä����
        if($res == false){
            Db_Query($con,"ROLLBACK;");
            exit;
        }
        Db_Query($con, "COMMIT;");
    }

}

/*------------------------------------------------
    ������̤�ץ����˳�Ǽ
------------------------------------------------*/
// QuickForm���顼�ˤ��Ƚ��
if ($post_add_flg == true){
    // ���顼��������λ
    $process = ($qf_err_flg == true) ? "error" : "complete";
}


/*----------------------------------------------------------
    csv���ϥܥ��󲡲����ν���
----------------------------------------------------------*/
// csv���ϲ����ե饰����
if ($post_csv_out_flg == true){

    // �쥳���ɥǡ�������
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

    // csv�ե��������
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
    ���̽����ѽ���
----------------------------------------------------------*/

/*------------------------------------------------
    �����ѥǡ�������
------------------------------------------------*/
// �쥳���ɥǡ��������Ƽ���
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

// ���˥�������
for ($i = 0; $i < $total_count; $i++){
    for($j = 0; $j < count($ary_list_data[$i]); $j++){
        $ary_list_data[$i][$j] = htmlspecialchars($ary_list_data[$i][$j]);
    }
}

/*------------------------------------------------
    �ե�������䴰����ǡ����μ���������
------------------------------------------------*/
// ���ơ��������ѹ��ǡ��������ϻ�
if ($status == "chg" && $process == "begin"){

    // DB���鳺���Υ쥳���ɼ���
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

    // �쥳���ɥǡ������䴰
    $form_data[$f_part_cd]   = $ary_rec_row_data["part_cd"];
    $form_data[$f_part_name] = $ary_rec_row_data["part_name"];
    $form_data[$f_note]      = $ary_rec_row_data["note"];

// ���顼��
}elseif ($process == "post" || $process == "error"){

    // POST���줿�ǡ����򤽤Τޤ��䴰
    $form_data[$f_part_cd]   = null;
    $form_data[$f_part_name] = null;
    $form_data[$f_note]      = null;

// ����¾
}else{

    // ������䴰
    $form_data[$f_part_cd]   = "";
    $form_data[$f_part_name] = "";
    $form_data[$f_note]      = "";

}

/*------------------------------------------------
    �ե�������䴰����hidden�μ���������
------------------------------------------------*/
// ������λ�ʤ�
if ($process == "complete"){

    // hidden�������֤�
    $form_data[$f_hdn_part_id] = "";
    $form_data[$f_hdn_status]  = "add";
    $form_data[$f_hdn_process] = "begin";

// ����ʳ�
}else{

    // hidden�ǡ������ݻ�
    $form_data[$f_hdn_part_id] = $get_part_id;
    $form_data[$f_hdn_status]  = $status;
    $form_data[$f_hdn_process] = $process;

}

/*------------------------------------------------
    �ե�����إǡ����䴰
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
$page_menu = Create_Menu_h("system", "1");

/****************************/
//���̥إå�������
/****************************/
$page_title .= "(��".$total_count."��)";
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign("form", $renderer->toArray());

//����¾���ѿ���assign
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
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
