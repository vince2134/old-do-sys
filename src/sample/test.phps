<?php

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm����
$form = new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

$db_con = Db_Connect();

/*
$large_genre[null] = null;
$large_genre[0] = "�¿�";
$large_genre[1] = "�ο�";

//������
$middle_genre[0][1] = "��������";
$middle_genre[0][2] = "����";
$middle_genre[1][3] = "�ο�" ;
$middle_genre[1][4] = "�ե������";
$middle_genre[1][5] = "�����ꥢ����";

//������
$small_genre[0][1] = array("��������", "��������", "��ˣ", "����");
$small_genre[0][2] = array("����������", "��ž����", "���餷����");
$small_genre[1][3] = array("���ơ���", "�ο�����");
$small_genre[1][4] = array("����������", "�ץ�ե�����", "���饫���");
$small_genre[1][5] = array("����������", "�ԥ�", "�ѥ���");

$obj_genre_select = &$form->addElement("hierselect", "genre", "����������", "", "����");
$obj_genre_select->setOptions(array($large_genre, $middle_genre, $small_genre));
*/

/*
$sql  = "SELECT ";
$sql .= "   t_bank.bank_id, ";
$sql .= "   t_bank.bank_cd, ";
$sql .= "   t_bank.bank_name, ";
$sql .= "   t_b_bank.b_bank_id, ";
$sql .= "   t_b_bank.b_bank_cd, ";
$sql .= "   t_b_bank.b_bank_name, ";
$sql .= "   t_account.account_id, ";
$sql .= "   t_account.account_no ";
$sql .= "FROM ";
$sql .= "   t_bank ";
$sql .= "   INNER JOIN t_b_bank ON t_bank.bank_id = t_b_bank.bank_id ";
$sql .= "   INNER JOIN t_account ON t_b_bank.b_bank_id = t_account.b_bank_id ";
$sql .= "WHERE ";
$sql .= ($_SESSION["group_kind"] == "2") ? " t_bank.shop_id IN (".Rank_Sql().") " : " t_bank.shop_id = ".$_SESSION["client_id"]." ";
$sql .= "ORDER BY ";
$sql .= "   t_bank.bank_cd, t_b_bank.b_bank_cd, t_account.account_no ";
$sql .= ";"; 
$res  = Db_Query($db_con, $sql);
$num  = pg_num_rows($res);
// hierselect���������
$ary_hier1[null] = null;
$ary_hier2       = null;
$ary_hier3       = null;
if ($num > 0){
    for ($i=0; $i<$num; $i++){
        // �ǡ��������ʥ쥳�������
        $data_list[$i] = pg_fetch_array($res, $i, PGSQL_ASSOC);
        // ʬ����䤹���褦�˳Ƴ��ؤ�ID���ѿ�������
        $hier1_id = $data_list[$i]["bank_id"];
        $hier2_id = $data_list[$i]["b_bank_id"];
        $hier3_id = $data_list[$i]["account_id"];
        /* ��1��������������� */
/*
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
            // ��1���إ����ƥ�������
            $ary_hier1[$hier1_id] = $data_list[$i]["bank_cd"]."��".$data_list[$i]["bank_name"];
        }
        /* ��2��������������� */
/*
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
            // ��2���إ��쥯�ȥ����ƥ�κǽ��NULL������
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"]){
                $ary_hier2[$hier1_id][null] = null;
            }
            // ��2���إ����ƥ�������
            $ary_hier2[$hier1_id][$hier2_id] = $data_list[$i]["b_bank_cd"]."��".$data_list[$i]["b_bank_name"];
        }
        /* ��3��������������� */
/*
        // ���߻��ȥ쥳���ɤζ�ԥ����ɤ����˻��Ȥ����쥳���ɤζ�ԥ����ɤ��ۤʤ���
        // �ޤ��ϡ����߻��ȥ쥳���ɤλ�Ź�����ɤ����˻��Ȥ����쥳���ɤλ�Ź�����ɤ��ۤʤ���
        // �ޤ��ϡ����߻��ȥ쥳���ɤθ����ֹ�����˻��Ȥ����쥳���ɤθ����ֹ椬�ۤʤ���
        if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] ||
            $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"] ||
            $data_list[$i]["account_no"] != $data_list[$i-1]["account_no"]){
            // ��3���إ��쥯�ȥ����ƥ�κǽ��NULL������
            if ($data_list[$i]["bank_cd"] != $data_list[$i-1]["bank_cd"] || 
                $data_list[$i]["b_bank_cd"] != $data_list[$i-1]["b_bank_cd"]){
                $ary_hier3[$hier1_id][$hier2_id][null] = null;
            }
            // ��3���إ����ƥ�������
            $ary_hier3[$hier1_id][$hier2_id][$hier3_id] = $data_list[$i]["account_no"];
        }
    }
    // 1�Ĥ�����ˤޤȤ��
    $ary_hier_item = array($ary_hier1, $ary_hier2, $ary_hier3);
//print_array($data_list);
print_array($ary_hier_item);
}
*/

// ��������ؿ�
$select_value = Make_Ary_Bank($db_con);

// Ϣ��html
$attach_html = " �� ";

// ��ԡ���Ź������
$obj_bank_select = &$form->addElement("hierselect", "form_bank", "", "", $attach_html);
$obj_bank_select->setOptions($select_value);


/****************************/
//HTML�إå�
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå�
/****************************/
$html_footer = Html_Footer();

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'html_footer'   => "$html_footer",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
