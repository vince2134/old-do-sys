<?php
/**
 *
 * ���°���
 *
 *
 *
 *
 *
 *
 *
 *   !! ������FC���̤Ȥ��Ʊ�����������ƤǤ� !!
 *   !! �ѹ�������������򤤤��ä�¾���˥��ԤäƤ������� !!
 *
 *
 *
 *
 *
 *
 *
 * ��
 *
 *
 * @author      
 * @version     
 *
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/08/07                  kajioka-h   ʡ�Ĵؿ���function/permit.inc�ˤ�Ȥäƽ�ľ����
 *                                          CSV���ϤΤߤ��ѹ��ʲ���ɽ���Ϥʤ���
 */

$page_title = "���°���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");
//DB��³
$db_con = Db_Connect();


//--------------------------//
// ���´�Ϣ����
//--------------------------//
// ���¥����å�
//$auth       = Auth_Check($db_con);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;



//--------------------------//
// �����ѿ�����
//--------------------------//
$group_kind = $_SESSION["group_kind"];



//--------------------------//
// �����ѿ�����
//--------------------------//
$def_data = array(
    "form_del_compe"	=> "1",
    "form_accept_compe"	=> "1",
    "form_compe_invest"	=> "1",
    "form_staff_state"	=> "�߿���",
);
$form->setDefaults($def_data);



//--------------------------//
//�ե���������ʸ����
//--------------------------//
//CSV���ϥܥ���
$form->addElement("submit", "csv_btn", "CSV����");

//ɽ��
//$form->addElement("submit","show_btn","ɽ����");

//���ꥢ
$form->addElement("button","clear_btn","���ꥢ","onClick=\"javascript:location.href('$_SERVER[PHP_SELF]');\"");


//����åץ�����
$text[] =& $form->createElement("text","cd1","�ƥ����ȥե�����","size=\"7\" maxLength=\"6\" style=\"$g_form_style\"  onkeyup=\"changeText(this.form,'form_client_cd[cd1]','form_client_cd[cd2]',6)\"".$g_form_option."\"");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("text","cd2","�ƥ����ȥե�����","size=\"4\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");
$form->addGroup( $text, "form_client_cd", "form_client_cd");

//ô���ԥ�����
$form->addElement("text","form_charge_cd","�ƥ����ȥե�����","size=\"5\" maxLength=\"4\" style=\"$g_form_style\"  ".$g_form_option."\"");

//�������
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "̵��","3");
$form->addGroup($radio, "form_del_compe", "�������");

//��ǧ����
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "̵��","3");
$form->addGroup($radio, "form_accept_compe", "��ǧ����");

//������Ϳ
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$radio[] =& $form->createElement( "radio",NULL,NULL, "��","2");
$radio[] =& $form->createElement( "radio",NULL,NULL, "̤","3");
$form->addGroup($radio, "form_compe_invest", "������Ϳ");

//�߿�����
$radio = "";
$radio[] =& $form->createElement( "radio",NULL,NULL, "�߿���","�߿���");
$radio[] =& $form->createElement( "radio",NULL,NULL, "�࿦","�࿦");
$radio[] =& $form->createElement( "radio",NULL,NULL, "�ٶ�","�ٶ�");
$radio[] =& $form->createElement( "radio",NULL,NULL, "����","����");
$form->addGroup($radio, "form_staff_state", "�߿�����");

//����å�̾
$form->addElement("text","form_client_name","�ƥ����ȥե�����","size=\"34\" maxLength=\"15\" ".$g_form_option."\"");
//�����å�̾
$form->addElement("text","form_staff_name","�ƥ����ȥե�����","size=\"22\" maxLength=\"10\" ".$g_form_option."\"");

//����ܡ�
$select_value="";
$select_value=array(""=>"","��ʬ��"=>"��ʬ��",);
$form->addElement("select","form_select_kind","���쥯�ȥܥå���",$select_value,$g_form_option_select);




//--------------------------//
// CSV����
//--------------------------//
if($_POST['csv_btn'] != null){


    if($group_kind == "1"){
    	$csv_data  = Make_Permit_Data($db_con, $group_kind);
    }
	$csv_data .= Make_Permit_Data($db_con, "2");
//print_array($csv_data);


    $csv_file_name = $page_title.date("Ymd").".csv";
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");


    header("Content-disposition: attachment; filename=$csv_file_name");
    header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;

    exit();
}



//--------------------------//
//HTML�إå�
//--------------------------//
$html_header = Html_Header($page_title);


//--------------------------//
//HTML�եå�
//--------------------------//
$html_footer = Html_Footer();


//--------------------------//
//���̥إå�������
//--------------------------//
$page_header = Create_Header($page_title);


// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());
//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",

));
$smarty->assign('ary_data',$ary);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));



/**
 *
 *
 *
 */
function Make_Permit_Data($db_con, $group_kind)
{

	//--------------------------//
	// ���Ϥ���ʸ��
	//--------------------------//
	$non = "��";    //���¤ʤ�
	$read = "��";   //ɽ��
	$write = "��";  //����


	//���¤ΰ�������
    $menu_array = Permit_Item();
//print_array($menu_array);

    $permit_array = Permit_Col("head");
//print_array($permit_array);


    //--- CSV�إå����� ---//
    //CSV�إå�1����
	if($group_kind == "1"){
	    $h_csv1  = array("����");
	}else{
	    $h_csv1  = array("FC");
	}

    //CSV�إå�2����
    $h_csv2  = array(
        "�����åվ���",
    );

    //CSV�إå�3����
    $h_csv3  = array(
        "����åץ�����",
        "����å�̾",
        "ô���ԥ�����",
        "�����åռ���",
        "�ͥåȥ����ID",
        "�����å�̾",
        "�߿�����",
        "�������",
        "��ǧ����",
    );

    //CSV�إå�4����
    $h_csv4  = array(
    );

    $count2 = count($h_csv2);
    $count3 = count($h_csv3);
    $count4 = count($h_csv4);
    for($i=0; $i<$count3; $i++){
        if($i < ($count3 - $count2)){
            //CSV�إå�2���ܤˡ�""�פ��ɲ�
            array_push($h_csv2, "");
        }

        if($i < ($count3 - $count4)){
            //CSV�إå�4���ܤˡ�""�פ��ɲ�
            array_push($h_csv4, "");
        }
    }


	if($group_kind == "1"){
	    $menu_array_data = $menu_array[0];			//��˥塼����
	    $permit_array_data = $permit_array["h"];	//��������
	}else{
	    $menu_array_data = $menu_array[1];
	    $permit_array_data = $permit_array["f"];
	}
/*
print_array($menu_array_data);
print_array($permit_array_data);
*/


    //��˥塼���ʬ��2���ܡ�
    $count_menu_array_1 = count($menu_array_data);
    for($i=0; $i < $count_menu_array_1; $i++){

        //��˥塼���ʬ��3���ܡ�
        $count_menu_array_2 = count($menu_array_data[$i][1]);
        for($j=0; $j < $count_menu_array_2; $j++){

            //��˥塼����ʬ��4���ܡ�
            $count_menu_array_3 = count($menu_array_data[$i][1][$j][1]);

            //����ʬ���ʤ��ʹ������ޥ����������
            if($count_menu_array_3 == 0){

                //CSV2����
                if($j == 0){
                    array_push($h_csv2, $menu_array_data[$i][0]);
                }else{
                    array_push($h_csv2, "");
                }
                array_push($h_csv3, $menu_array_data[$i][1][$j][0]);	//CSV3����
                array_push($h_csv4, "");                            	//CSV4����

            //����ʬ������ʹ������ޥ���������ʳ���
            }else{

                for($k=0; $k < $count_menu_array_3; $k++){

                    //CSV2����
                    if($j == 0 && $k == 0){
                        array_push($h_csv2, $menu_array_data[$i][0]);
                    }else{
                        array_push($h_csv2, "");
                    }

                    //CSV3����
                    if($k == 0){
                        array_push($h_csv3, $menu_array_data[$i][1][$j][0]);
                    }else{
                        array_push($h_csv3, "");
                    }

                    array_push($h_csv4, $menu_array_data[$i][1][$j][1][$k]);   //CSV4����
                }

            }

        }

    }
/*
print_array($h_csv2, "CSV2����");
print_array($h_csv3, "CSV3����");
print_array($h_csv4, "CSV4����");
*/


    //WHERE������

    //������FC����
    if($group_kind == "1"){
        $where_sql  = "    t_attach.h_staff_flg = true \n";
    }else{
        $where_sql  = "    t_attach.h_staff_flg = false \n";
    }

    //FC���̤ΤȤ��ϼ�����åפΤ�ɽ��
    if($_SESSION["group_kind"] != "1"){
        $where_sql  = "    t_attach.shop_id = ".$_SESSION["client_id"]." \n";
    }

    //����åץ�����1
	if($_POST["form_client_cd"]["cd1"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_client.client_cd1 = '".$_POST["form_client_cd"]["cd1"]."' \n";
    }
    //����åץ�����2
	if($_POST["form_client_cd"]["cd2"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_client.client_cd2 = '".$_POST["form_client_cd"]["cd2"]."' \n";
    }
    //����å�̾
	if($_POST["form_client_name"] != null){
        $where_sql .= "    AND \n";
        $where_sql .= "    ( \n";
	    $where_sql .= "        t_client.client_name LIKE '%".$_POST["form_client_name"]."%' \n";
        $where_sql .= "        OR \n";
	    $where_sql .= "        t_client.client_name2 LIKE '%".$_POST["form_client_name"]."%' \n";
        $where_sql .= "        OR \n";
	    $where_sql .= "        t_client.client_cname LIKE '%".$_POST["form_client_name"]."%' \n";
        $where_sql .= "    ) \n";
    }

    //ô���ԥ�����
	if($_POST["form_charge_cd"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_staff.charge_cd = ".(int)$_POST["form_charge_cd"]." \n";
    }
    //�����å�̾
	if($_POST["form_staff_name"] != null){
        $where_sql .= "    AND \n";
	    $where_sql .= "    t_staff.staff_name LIKE '%".$_POST["form_staff_name"]."%' \n";
    }

    //�������
	if($_POST["form_del_compe"] != "1"){
        $where_sql .= "    AND \n";
	    if($_POST["form_del_compe"] == "2"){
    	    $where_sql .= "    t_permit.del_flg = true \n";
        }elseif($_POST["form_del_compe"] == "3"){
    	    $where_sql .= "    t_permit.del_flg = false \n";
        }
    }
    //��ǧ����
	if($_POST["form_accept_compe"] != "1"){
        $where_sql .= "    AND \n";
	    if($_POST["form_accept_compe"] == "2"){
    	    $where_sql .= "    t_permit.accept_flg = true \n";
        }elseif($_POST["form_accept_compe"] == "3"){
    	    $where_sql .= "    t_permit.accept_flg = false \n";
        }
    }

    //�߿�����
	if($_POST["form_staff_state"] != "����"){
        $where_sql .= "    AND \n";
	    if($_POST["form_staff_state"] == "�߿���"){
    	    $where_sql .= "    t_staff.state = '�߿���' \n";
	    }elseif($_POST["form_staff_state"] == "�࿦"){
    	    $where_sql .= "    t_staff.state = '�࿦' \n";
	    }elseif($_POST["form_staff_state"] == "�ٶ�"){
    	    $where_sql .= "    t_staff.state = '�ٶ�' \n";
        }
    }

    //������Ϳ
	if($_POST["form_compe_invest"] != "1"){
        $where_sql .= "    AND \n";
	    if($_POST["form_compe_invest"] == "2"){
    	    $where_sql .= "    t_permit.staff_id IS NOT NULL \n";
        }elseif($_POST["form_compe_invest"] == "3"){
    	    $where_sql .= "    t_permit.staff_id IS NULL \n";
        }
    }



    //SQL����
    $sql  = "SELECT \n";
    $sql .= "    t_client.client_cd1 || '-' || t_client.client_cd2 AS client_cd, \n";
    $sql .= "    t_client.client_cname, \n";
    $sql .= "    lpad(t_staff.charge_cd, 4, '0') AS charge_cd, \n";
    $sql .= "    CASE t_rank.group_kind \n";
    $sql .= "        WHEN '1' THEN '����' \n";
    $sql .= "        WHEN '2' THEN 'ľ��' \n";
    $sql .= "        ELSE 'FC' \n";
    $sql .= "    END AS group_kind, \n";
    $sql .= "    CASE t_staff.staff_cd1 \n";
    $sql .= "        WHEN null THEN null \n";
    $sql .= "        ELSE t_staff.staff_cd1 || '-' || t_staff.staff_cd2 \n";
    $sql .= "    END AS staff_cd, \n";
    $sql .= "    t_staff.staff_name, \n";
    $sql .= "    t_staff.state, \n";
    $sql .= "    CASE t_permit.del_flg \n";
    $sql .= "        WHEN true THEN 'ͭ' \n";
    $sql .= "        WHEN false THEN '̵' \n";
    $sql .= "    END, \n";
    $sql .= "    CASE t_permit.accept_flg \n";
    $sql .= "        WHEN true THEN 'ͭ' \n";
    $sql .= "        WHEN false THEN '̵' \n";
    $sql .= "    END, \n";

    //����
    $count_permit_array_1 = count($permit_array_data);
    for($i=1; $i <= $count_permit_array_1; $i++){

        $count_permit_array_2 = count($permit_array_data[$i]);
        for($j=1; $j <= $count_permit_array_2; $j++){

            $count_permit_array_3 = count($permit_array_data[$i][$j]);
            for($k=0; $k < $count_permit_array_3; $k++){

                //0���ܤ�null���ä��鼡�Υ롼�פ�
                if($permit_array_data[$i][$j][$k][0] == null){
                    continue;

                }else{
                    $sql .= "    CASE t_permit.".$permit_array_data[$i][$j][$k][0]." \n";
                    $sql .= "        WHEN 'n' THEN '$non' \n";
                    $sql .= "        WHEN 'r' THEN '$read' \n";
                    $sql .= "        WHEN 'w' THEN '$write' \n";
                    if($i == $count_permit_array_1 && $j == $count_permit_array_2 && $k == ($count_permit_array_3 - 1)){
                        $sql .= "    END \n";
                    }else{
                        $sql .= "    END, \n";
                    }
                }
            }
        }
    }

    $sql .= "FROM \n";
    $sql .= "    t_staff \n";
    $sql .= "    LEFT JOIN t_permit ON t_permit.staff_id = t_staff.staff_id \n";
    $sql .= "    INNER JOIN t_attach ON t_attach.staff_id = t_staff.staff_id \n";
    $sql .= "    INNER JOIN t_client ON t_client.client_id = t_attach.shop_id \n";
    $sql .= "    INNER JOIN t_rank ON t_rank.rank_cd = t_client.rank_cd \n";
    $sql .= "WHERE \n";
    $sql .= $where_sql;
    $sql .= "ORDER BY \n";
    $sql .= "    client_cd1, \n";
    $sql .= "    client_cd2, \n";
    $sql .= "    charge_cd \n";
    $sql .= ";";
//print_array($sql);

    $result = Db_Query($db_con, $sql);
    for($i=0, $result_array=array(); $i<pg_num_rows($result); $i++){
        $result_array[] = pg_fetch_array($result, $i, PGSQL_NUM);
    }
//print_array($result_array);


    //CSV�ǡ�����4���ܤ���2���ܤޤǤΥإå��򤯤äĤ����1���ܤ�Make_Csv�ؿ��Ǥ��äĤ����
    array_unshift($result_array, $h_csv4);
    array_unshift($result_array, $h_csv3);
    array_unshift($result_array, $h_csv2);
//print_array($result_array);

    $csv_data  = Make_Csv($result_array, $h_csv1);

    if($group_kind == "1"){
        $csv_data .= "\n\n";
    }

	return $csv_data;
}


?>
