<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2016/01/22                amano  Dialogue �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�  
*/

$page_title = "������Ω����";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

/****************************/
//�����ѿ�����
/****************************/
$shop_id      = $_SESSION["client_id"];
$get_build_id = $_GET["build_id"];
$get_type     = $_GET["new_flg"];

Get_Id_Check3($get_build_id);
if($get_type == "true"){
    $mesg_color = "#0000FF";
    $mesg       = "��Ͽ���ޤ�����";
}


/****************************/
//���������
/****************************/
$def_data = array(
                "hdn_build_id" => "$get_build_id"
            );
$form->setDefaults($def_data);

/****************************/
//�ե��������
/****************************/
//�إå��ܥ���
$form->addElement("button", "new_button", "�С�Ͽ","onClick=\"location.href='./1-4-109.php'\"");
$form->addElement("button", "list_button", "�졡��",$g_button_color." onClick=\"location.href='./1-4-115.php'\"");

$form->addElement("hidden", "hdn_build_id");

//����ܥ���
$form->addElement("submit", "form_del_button", "���", "onClick=\"javascript:return Dialogue('������ޤ���','#', this)\"");

//���ܥ���
$form->addElement("button", "form_back_button", "�ᡡ��", "onClick=\"location.href='./1-4-115.php'\"");

//O��K�ܥ���
$form->addElement("button", "form_ok_button", "�ϡ���", "onClick=\"location.href='./1-4-109.php'\"");

/****************************/
//���٥�Ƚ���
/****************************/
$del_button_flg = ($_POST["form_del_button"] == "���")? true : false;

//����ܥ��󲡲�����
if($del_button_flg == true){

    $del_build_id = $_POST["hdn_build_id"];

    //���
    $del_result_flg = Del_Build_Data($db_con, $del_build_id);

    if($del_result_flg === true){
        $mesg = "������ޤ�����";
        $mesg_color = "#0000FF";
    }else{
        $mesg = "���Ǥ˺���ѤߤǤ���";
        $mesg_color = "#FF0000";
    }
}else{
    /****************************/
    //ɽ���ǡ������
    /****************************/
    //�����ʾ��ʥǡ������
    $build_goods_data = Get_Build_Goods_Data($db_con, $get_build_id);

    //���˥�������
    $build_goods_data = Html_Build_Data($build_goods_data);

    //���ʥǡ������
    $parts_goods_data = Get_Parts_Goods_Data($db_con, $get_build_id);

    //���˥�������
    $parts_goods_data = Html_Build_Data($parts_goods_data);
}

/****************************/
//�ؿ�����
/****************************/
function Get_Build_Goods_Data($db_con, $build_id){

    if($build_id == null){
        return;
    }

    // �ѹ�SQL
    $sql  = "SELECT ";
    $sql .= "   t_build.build_id, ";
    $sql .= "   LPAD(t_build.build_id, 8, 0) AS build_cd, ";
    $sql .= "   t_build.build_day, ";
    $sql .= "   t_goods.goods_cd, ";
    $sql .= "   t_goods.goods_name, ";
    $sql .= "   t_output_ware.ware_cd || ' : ' || t_output_ware.ware_name AS output_ware_name, ";
    $sql .= "   t_input_ware.ware_cd || ' : ' || t_input_ware.ware_name AS input_ware_name, ";
    $sql .= "   t_build.build_num ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_goods ";
    $sql .= "   ON t_build.goods_id = t_goods.goods_id ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_ware AS t_output_ware ";
    $sql .= "   ON t_build.output_ware_id = t_output_ware.ware_id ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_ware AS t_input_ware ";
    $sql .= "   ON t_build.input_ware_id = t_input_ware.ware_id ";
    $sql .= "WHERE ";
    $sql .= "   t_build.build_id = $build_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);

    //�ǡ�����������Ϸ�̤��������Ͽ
    if(pg_num_rows($result) != "0"){
        $build_goods_data = pg_fetch_all($result);
    }
    return $build_goods_data;
}

function Get_Parts_Goods_Data($db_con, $build_id){

    if($build_id == null){
        return;
    }

    $sql  = "SELECT";
    $sql .= "   t_goods.goods_cd, ";
    $sql .= "   t_goods.goods_name, ";
    $sql .= "   t_make_goods.numerator || '/' || t_make_goods.denominator AS parts_num, ";
    $sql .= "   t_stock_hand.num ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_stock_hand ";
    $sql .= "   ON t_build.build_id = t_stock_hand.build_id ";
    $sql .= "   AND ";
    $sql .= "   t_build.build_id = $build_id ";
    $sql .= "       INNER JOIN ";
    $sql .= "   t_goods ";
    $sql .= "   ON t_stock_hand.goods_id = t_goods.goods_id "; 
    $sql .= "   AND ";
    $sql .= "   t_stock_hand.io_div = '2'";
    $sql .= "       LEFT JOIN ";
    $sql .= "   t_make_goods ";
    $sql .= "   ON t_goods.goods_id = t_make_goods.parts_goods_id ";
    $sql .= "   AND ";
    $sql .= "   t_build.goods_id = t_make_goods.goods_id ";
    $sql .= "WHERE ";
    $sql .= "   t_stock_hand.work_day > '".Get_Monthly_Renew($db_con)."' ";
    $sql .= "ORDER BY goods_cd ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    Get_Id_Check($result);

    //�ǡ�����������Ϸ�̤��������Ͽ
    if(pg_num_rows($result) != "0"){
        $parts_goods_data = pg_fetch_all($result);
    }
    return $parts_goods_data;
}

function Html_Build_Data($data){

    $count = count($data);

    if($count == 0){
        return;
    }

    for($i = 0; $i < $count; $i++){
        $data[$i]["no"] = $i + 1;

        foreach($data[$i] AS $key => $var){
            $data[$i][$key] = htmlspecialchars($var);
        }
    }

    return $data;
}

function Del_Build_Data($db_con, $build_id){

    Db_Query($db_con, "BEGIN;");

    $sql  = "SELECT";
    $sql .= "   COUNT(build_id) ";
    $sql .= "FROM ";
    $sql .= "   t_build ";
    $sql .= "WHERE ";
    $sql .= "   build_id = $build_id ";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $add_num = pg_fetch_result($result, 0, 0);

    if($add_num == 0){
        return false;
    }

    //���
    $sql  = "DELETE FROM t_build WHERE build_id = $build_id;";

    $resuld = Db_Query($db_con, $sql);
    if($result === false){
        Db_Query($db_con, "ROLLBACK;");
        exit;
    }

    Db_Query($db_con, "COMMIT;");
    return true;
}

//�ǿ��η�����������
function Get_Monthly_Renew($db_con, $div=null){
    //�ǿ��η�����������
    $plus1_flg = true;
    $sql  = "SELECT";
    $sql .= "   COALESCE(MAX(close_day), null) ";
    $sql .= "FROM";
    $sql .= "   t_sys_renew ";
    $sql .= "WHERE";
    $sql .= "   shop_id = $_SESSION[client_id]";
    $sql .= "   AND";
    $sql .= "   renew_div = '2'";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    $max_close_day = pg_fetch_result($result, 0,0);

    if ($div == '1'){
        $ary_close_day = explode('-', $max_close_day);
        $renew_date    = date("Y-m-d", mktime(0, 0, 0, $ary_close_day[1] , $ary_close_day[2]+1, $ary_close_day[0]));
    }else{
        $renew_date    = $max_close_day;
    }

    return $renew_date;
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
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[list_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'del_button_flg'    => "$del_button_flg",
    'mesg'              => "$mesg",
    'mesg_color'        => "$mesg_color",
)); 
$smarty->assign("build_goods_data", $build_goods_data);
$smarty->assign("parts_goods_data", $parts_goods_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
