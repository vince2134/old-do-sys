<?php
$page_title = "���ߥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB��³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

/*****************************/
//���֥������Ⱥ���
/*****************************/
//�ܥ���
$form->addElement("button","form_csv_button","CSV����","onClick=\"javascript:Button_Submit('csv_button_flg', '#', 'true');\"");
//hidden
$form->addElement("hidden","csv_button_flg");

/*****************************
//��������
/*****************************/
$sql  = "SELECT";
$sql .= "   inst_cd,";
$sql .= "   inst_name,";
$sql .= "   note";
$sql .= " FROM";
$sql .= "   t_inst";
$sql .= " WHERE";
$sql .= "   accept_flg = '1'";
$sql .= "   ORDER BY t_inst.inst_cd";
$sql .= ";";

$result = Db_Query($conn, $sql);
$total_count = pg_num_rows($result);
$page_data = Get_Data($result);

/*****************************/
//CSV�ܥ��󲡲�����
/*****************************/
if($_POST["csv_button_flg"] == true){
    //CSV����
    for($i = 0; $i < $total_count; $i++){
        $csv_page_data[$i][0] = $page_data[$i][0];
        $csv_page_data[$i][1] = $page_data[$i][1];
        $csv_page_data[$i][2] = $page_data[$i][2];
    }

    $csv_file_name = "���ߥޥ���".date("Ymd").".csv";
    $csv_header = array(
        "���ߥ�����",
        "����̾",
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
));

$smarty->assign("page_data",$page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
