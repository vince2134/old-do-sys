<?php
/*
 * �ѹ�����
 * 1.0.0 (2006/03/21) �������Υե������ѹ�(suzuki-t)
 *
 * @author		suzuki-t <suzuki-t@bhsk.co.jp>
 *
 * @version		1.0.1 (2006/07/12)
*/

/*
 * �Х���������
 * 1.0.0 (2006/03/21)
 * ��¤�ʤ����򤵤�Ƥ��ʤ��ȡ�SQL���顼��ɽ�������١�
 * �����¹�Ƚ��ˡ���¤�ʤ�NULLȽ����ɲä���(suzuki-t)
 *
 * 1.0.1 (2006/07/12) kaji
 * ��Ͽ�ܥ��󲡲���γ�ǧ���̤��ѹ��������Ƥ�ȿ�Ǥ���Ƥ��ʥХ�����
 *
*/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/21��0077��������  watanabe-k��ʬ�Ҥ�ʬ���ʸ�����������������ʬ�ҤΥ��顼����ɽ������ʤ��Х��ν���
 * ��2006/11/21��0078��������  watanabe-k��GET��ID�����å��ɲ�
 * ��2006/11/21��0078��������  watanabe-k���ѹ����ϻ��˥إå������ѹ������ɲ�OR�����Ԥ����ѹ�������äƤ���Х��ν���
 *   2006-12-08  ban_0076      suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *   2007-01-24  �����ѹ�      watanabe-k  �ܥ���ο����ѹ�
 *   2007-07-25                watanabe-k  �ƾ��ʤ��ѹ��������˸��οƾ��ʤΥե饰���ѹ�����ʤ��Х��ν���
 *   2007-09-06                watanabe-k  ��¤�ʤ��ѹ����˾��ʤ�����10����ʾ�ξ��ɽ������ʤ��Х��ν���
 *
 */

$page_title = "��¤�ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
             "onSubmit=return confirm(true)");
//DB����³
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
$shop_id = $_SESSION["client_id"];
$get_goods_id = $_GET["goods_id"];
Get_Id_Check3($get_goods_id);
if($get_goods_id == null){
    $new_flg = true;
}else{
    $new_flg = false;
}

/****************************/
//�������
/****************************/
//ɽ���Կ�
if(isset($_POST["max_row"])){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 10;
}
//����Կ�
$del_history[] = null;

/****************************/
//�Կ��ɲ�
/****************************/
if($_POST["add_row_flg"]==true){
    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+1;
    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//�Ժ������
/****************************/
if(isset($_POST["del_row"])){

    //����ꥹ�Ȥ����
    $del_row = $_POST["del_row"];

    //������������ˤ��롣
    $del_history = explode(",", $del_row);
}

/***************************/
//���������
/***************************/
$max_data["max_row"] = $max_row;
$form->setConstants($max_data);

/*****************************/
//����ͥ��å�
/*****************************/
//if($new_flg != true){
//if($new_flg != true && $_POST["form_entry_button"] != "�С�Ͽ"){
if($new_flg != true && $_POST["first_set"] != 1){
    $get_sql  = "SELECT";
    $get_sql .= "   t_make.goods_cd,";
    $get_sql .= "   t_make.goods_name,";
    $get_sql .= "   t_parts.goods_cd,";
    $get_sql .= "   t_parts.goods_name,";
    $get_sql .= "   t_make_goods.denominator,";
    $get_sql .= "   t_make_goods.numerator";
    $get_sql .= " FROM";
    $get_sql .= "   t_make_goods,";
    $get_sql .= "   t_goods AS t_make,";
    $get_sql .= "   t_goods AS t_parts";
    $get_sql .= " WHERE";
    $get_sql .= "   t_make_goods.goods_id = $get_goods_id";
    $get_sql .= "   AND";
    $get_sql .= "   t_make_goods.goods_id = t_make.goods_id";
    $get_sql .= "   AND";
    $get_sql .= "   t_make_goods.parts_goods_id = t_parts.goods_id";
    $get_sql .= "   ORDER BY t_parts.goods_cd";
    $get_sql .= ";";

    $get_res = Db_query($conn, $get_sql);
    Get_Id_Check($get_res);

    $get_num = pg_num_rows($get_res);
    for($i = 0; $i < $get_num; $i++){
        $get_goods_data[] = pg_fetch_array($get_res, $i, PGSQL_NUM);
        
        $def_data["form_goods_cd"][$i]  = $get_goods_data[$i][2];
        $def_data["form_goods_name"][$i]  = $get_goods_data[$i][3];
        $def_data["form_denominator"][$i] = $get_goods_data[$i][4];
        $def_data["form_numerator"][$i]   = $get_goods_data[$i][5];
    
    }
    $def_data["form_make_goods"]["cd"] = $get_goods_data[0][0];
    $def_data["form_make_goods"]["name"] = $get_goods_data[0][1];
    
    //ɽ�����
    $max_row = $get_num;
    $def_data["max_row"] = $max_row;

    $form->setConstants($def_data);

    $id_data = Make_Get_Id($conn, "make_goods", $get_goods_data[0][0]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];

}

/****************************/
//�ե���������ʸ����
/****************************/
$where  = " WHERE";
$where .= "     t_goods.public_flg = 't'";
$where .= "     AND";
$where .= "     t_goods.accept_flg = '1'";
$where .= "     AND";
$where .= "     t_goods.compose_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.state IN (1,3)";
$where .= "     AND";
$where .= "     t_goods.no_change_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price where rank_cd = '1' AND shop_id = $shop_id)";

$code_value .= Code_Value("t_goods",$conn , $where);
$form_make_goods[] =& $form->createElement(
        "text","cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        onKeyUp=\"javascript:goods(this,'form_make_goods[name]')\" 
        ".$g_form_option."\""
    );
$form_make_goods[] =& $form->createElement(
        "text","name","","size=\"34\" 
                $g_text_readonly"
    );
$form->addGroup( $form_make_goods, "form_make_goods", "");

//button

//��Ͽ�ʥإå���
//$form->addElement("button","new_button","��Ͽ����","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","��Ͽ����", $g_button_color."onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('1-1-223.php')\"");

//hidden
$form->addElement("hidden", "del_row");             //�����
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "first_set", "1");      //����Կ�

/*****************************/
//POST�������
/*****************************/
$make_goods_cd = $_POST["form_make_goods"]["cd"];
$make_goods_name = $_POST["form_make_goods"]["name"];

for($i = 0; $i < $max_row; $i++){
    if($_POST["form_goods_cd"][$i] != null){
        $goods_cd[$i] = $_POST['form_goods_cd'][$i];
        $goods_name[$i] = $_POST["form_goods_name"][$i];

        $numerator[$i] = $_POST["form_numerator"][$i];
        $denominator[$i] = $_POST["form_denominator"][$i];

        $all_input_flg = true;
        $input_flg[$i] = true;
    }
}

/****************************/
//�롼�������QuickForm��
/****************************/
//����¤��
//��ɬ�ܥ����å�
$form->addGroupRule('form_make_goods', array(
        'cd' => array(
                array('��¤�ʤ����������ʥ����ɤ����Ϥ��Ʋ�������', 'required')
        ),      
        'name' => array(
                array('��¤�ʤ����������ʥ����ɤ����Ϥ��Ʋ�������','required')
        )      
));

/****************************/
//�롼�������PHP�˥��顼��ͥ���̤�ͤ���ɬ��ͭ�ꡩ��
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /*****************************/
    //POST�������
    /*****************************/
    $make_goods_cd = $_POST["form_make_goods"]["cd"];
    $make_goods_name = $_POST["form_make_goods"]["name"];

    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_goods_cd"][$i] != null){
            $goods_cd[$i] = $_POST['form_goods_cd'][$i];
            $goods_name[$i] = $_POST["form_goods_name"][$i];

            $numerator[$i] = $_POST["form_numerator"][$i];
            $denominator[$i] = $_POST["form_denominator"][$i];

            $all_input_flg = true;
            $input_flg[$i] = true;
        }
    }

    for($i = 0; $i < $max_row; $i++){
        //����̾
        //��ɬ�ܥ����å�
        if($goods_cd[$i] != null && $goods_name[$i] == null){
            $goods_err = "���ʤ����������ʥ����ɤ����Ϥ��Ʋ�������";
            $err_flg = true;
        }

        //��Ʊ�쾦�ʤ�ʣ�����򤵤�Ƥ�����
        for($j = 0; $j < $max_row; $j++){
            if($input_flg[$i] == true && $i != $j && $goods_cd[$i] == $goods_cd[$j]){
                $used_goods_err = "���ʤ�Ʊ�����ʤ�2��ʾ����򤵤�Ƥ��ޤ���";
                $err_flg = true;
            }
        }

        //����¤�ʤ�Ʊ�����ʤ����򤵤�Ƥ�����
        if($make_goods_cd === $goods_cd[$i]){
            $used_make_goods_err = "��¤�ʤ�Ʊ�����ʤ����ʤȤ������򤵤�Ƥ��ޤ���";
            $err_flg = true;
        }

        //��ʬ��
        //��ɬ�ܥ����å�
        if($numerator[$i] == null && $goods_name[$i] != null){
            $numerator_err = "���̡�ʬ�ҡˤ�Ⱦ�ѿ�����1��9�פ�1ʸ���ʾ�2ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }

        //�����������å�
        if($numerator[$i] != null  && !ereg("^[0-9]+$", $numerator[$i])){      
            $numerator_err = '���̡�ʬ�ҡˤ�Ⱦ�ѿ�����1��9�פ�1ʸ���ʾ�2ʸ���ʲ��Ǥ���';
            $err_flg = true;
        }       

        //��ʬ��
        //��ɬ�ܥ����å�
        if($denominator[$i] == null && $goods_name[$i] != null){
            $denominator_err = "���̡�ʬ��ˤ�Ⱦ�ѿ�����1��9�פ�1ʸ���ʾ�2ʸ���ʲ��Ǥ���";
            $err_flg = true;
        }

        //�����������å�
        if($denominator[$i] != null  && !ereg("^[0-9]+$", $denominator[$i])){      
            $denominator_err = '���̡�ʬ��ˤ�Ⱦ�ѿ�����1��9�פ�1ʸ���ʾ�2ʸ���ʲ��Ǥ���';
            $err_flg = true; 
        } 

    }

    //�����ʤ�����null
    if($all_input_flg != true){
        $goods_input_err = "���ʤ���Ĥ����򤵤�Ƥ��ޤ���";
        $err_flg = true;

    //��������¤�ʤȤ�����Ͽ����Ƥ�����
    }elseif($all_input_flg == true && $err_flg != true && $make_goods_cd != null){
        $make_goods_sql  = " SELECT";
        $make_goods_sql .= "    goods_id,";
        $make_goods_sql .= "    make_goods_flg";
        $make_goods_sql .= " FROM";
        $make_goods_sql .= "    t_goods";
        $make_goods_sql .= " WHERE";
        $make_goods_sql .= "    shop_id = $shop_id";
        $make_goods_sql .= "    AND";
        $make_goods_sql .= "    goods_cd = '$make_goods_cd'";
        $make_goods_sql .= ";";

        $make_goods_res = Db_query($conn, $make_goods_sql);
        $make_goods_id  = pg_fetch_result($make_goods_res, 0,0);
        $make_goods_flg = pg_fetch_result($make_goods_res, 0,1);

        if($new_flg == true && $make_goods_flg == 't'){
            $make_goods_flg_err = "��¤�ʤȤ������򤷤����ʤϤ��Ǥ���¤�ʤȤ�����Ͽ����Ƥ��ޤ���";
            $err_flg = true;
        }elseif($new_flg == false && $make_goods_id != $get_goods_id && $make_goods_flg == 't'){
            $make_goods_flg_err = "��¤�ʤȤ������򤷤����ʤϤ��Ǥ���¤�ʤȤ�����Ͽ����Ƥ��ޤ���";
            $err_flg = true;
        }elseif($new_flg == false && $make_goods_id != $get_goods_id && $make_goods_flg != 't'){
            $make_flg = true;
        }
    }
}

/****************************/
//����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ" && $form->validate() && $err_flg != true){

    /*****************************/
    //��Ͽ����
    /*****************************/
    Db_Query($conn, "BEGIN;");

    $insert_sql  = " UPDATE";
    $insert_sql .= "    t_goods";
    $insert_sql .= " SET";
    $insert_sql .= "    make_goods_flg = 't'";
    $insert_sql .= " WHERE";
    $insert_sql .= "    goods_id = $make_goods_id";
    $insert_sql .= ";";

    $result = Db_Query($conn, $insert_sql);
    if($result === false){
        Db_Query($conn, "ROLLBACK");
        exit;
    }

    $work_div = '1';

    //�ѹ���
    if($new_flg == false){
        $insert_sql  = " DELETE FROM";
        $insert_sql .= "    t_make_goods";
        $insert_sql .= " WHERE";
        $insert_sql .= "    goods_id = $get_goods_id";
        $insert_sql .= ";";

        $result = Db_Query($conn, $insert_sql);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }

        //�ѹ������ѹ������¤�ʤξ���ID�����פ��ʤ������ġ��ѹ������¤�ʤΡ���¤�ʥե饰��f��
        if($make_flg == true){
            $insert_sql  = " UPDATE";
            $insert_sql .= "    t_goods";
            $insert_sql .= " SET";
            $insert_sql .= "    make_goods_flg = 'f'";
            $insert_sql .= " WHERE";
            $insert_sql .= "    goods_id = $get_goods_id";
            $insert_sql .= ";";

            $result = Db_Query($conn,$insert_sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }
        }

        $work_div = '2';

    }
    for($i = 0; $i < $max_row; $i++){
        if($input_flg[$i] == true){
            $insert_sql  = " INSERT INTO t_make_goods VALUES(";
            $insert_sql .= "    $make_goods_id,";
            $insert_sql .= "    (SELECT";
            $insert_sql .= "        goods_id";
            $insert_sql .= "      FROM";
            $insert_sql .= "        t_goods";
            $insert_sql .= "      WHERE";
            $insert_sql .= "        shop_id = $shop_id";
            $insert_sql .= "        AND";
            $insert_sql .= "        goods_cd = '$goods_cd[$i]'";
            $insert_sql .= "    ),";
            $insert_sql .= "    '$denominator[$i]',";
            $insert_sql .= "    '$numerator[$i]'";
            $insert_sql .= ");";

            $result = Db_Query($conn, "$insert_sql");
            if($result === false){
                Db_Queery($conn, "ROLLBACK");
                exit;
            }
        }
    }

    $result = Log_Save( $conn, "make_goods", $work_div,$make_goods_cd, $make_goods_name);
    if($result === false){
        Db_Queery($conn, "ROLLBACK");
        exit;
    }

    Db_Query($conn," COMMIT;");
    $freeze_flg = true;
}

if($freeze_flg == true){

    // ���ܥ����������ID����
    // ������Ͽ��
    if ($get_goods_id == null){
        $get_id = $make_goods_id;
    // �ѹ���
    }else{
        $get_id = $get_goods_id;
    }

    $form->addElement("button","form_entry_button","�ϡ���","onClick=\"location.href='./1-1-224.php'\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"location.href='".$_SERVER["PHP_SELF"]."?goods_id=$get_id'\"");
    
    $form->addElement("static","form_goods_link","","��¤��","");
    $form->freeze();
}else{

    $form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#')\" $disabled");

    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./1-1-224.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }

    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./1-1-224.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
    }

    $form->addElement(
        "link","form_goods_link","","#","��¤��",
        "onClick=\"return Open_SubWin('../dialog/1-0-210.php', Array('form_make_goods[cd]', 'form_make_goods[name]'), 500, 450);\""
    );

}

/*****************************/
//�ե������������ư��
/*****************************/
//���ֹ楫����
$row_num = 1;

if($freeze_flg == true){
    $style  = "color : #000000;"; 
    $style .= "border : #ffffff 1px solid;"; 
    $style .= "background-color: #ffffff;";

    $g_form_option = "readonly";
}

for($i = 0; $i < $max_row; $i++){

    //�����Ƚ��
    if(!in_array("$i", $del_history)){
        //�������
        $del_data = $del_row.",".$i;

        //���ʥ�����
        $form_goods =& $form->addElement(
                "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
                onKeyUp=\"javascript:goods(this,'form_goods_name[$i]')\" 
                style=\"$style;$g_form_style\"
                ".$g_form_option."\"
            ");
        //����̾
        $form_good =& $form->addElement(
                "text","form_goods_name[$i]","","size=\"34\" maxLength=\"30\" 
                $g_text_readonly"
            );

        //������
        $form->addElement(
                "text","form_numerator[$i]","","size=\"3\" maxLength=\"3\" style=\"$style text-align: right;$g_form_style\"
                $g_form_option"
            );
        $form->addElement(
                "text","form_denominator[$i]","","size=\"3\" maxLength=\"3\" style=\"$style text-align: right;$g_form_style\"
                $g_form_option"
            );
        $form->addGroup($form_num, "form_count[$i]");

        /****************************/
        //ɽ����HTML����
        /****************************/
        $html .= "<tr class=\"Result1\">\n";
        $html .=    "<td align=\"right\">$row_num</td>\n";

        //���ʥ����ɡ�����̾
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        if($freeze_flg != true){
            $html .=        "��<a href=\"#\" onClick=\"return Open_SubWin('../dialog/1-0-210.php', Array('form_goods_cd[$i]', 'form_goods_name[$i]'), 500, 450);\">����</a>��";
        }
        $html .=    "</td>\n";
        $html .=    "<td align=\"left\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_name[$i]"]]->toHtml();
        $html .=    "</td>\n";

        //���̡�ʬ��/ʬ���
        $html .=    "<td align=\"center\">\n";
        $html .=        $form->_elements[$form->_elementIndex["form_numerator[$i]"]]->toHtml();
        $html .=        "/";
        $html .=        $form->_elements[$form->_elementIndex["form_denominator[$i]"]]->toHtml();
        $html .=    "</td>\n";
        if($freeze_flg != true){
            $html .=    "<td align=\"center\">";
            $html .=       "<a href=\"#\" onClick=\"javascript:Dialogue_1('������ޤ���', '$del_data', 'del_row')\">���</a>";
            $html .=    "</td>\n";
        }
        $html .= "</tr>\n";

        //���ֹ��ܣ�
        $row_num = $row_num+1;
    }
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
//���������
/****************************/
$make_goods_sql  = " SELECT";
$make_goods_sql .= "    COUNT(t_goods.goods_id)";
$make_goods_sql .= " FROM";
$make_goods_sql .= "    t_goods";
$make_goods_sql .= " WHERE";
$make_goods_sql .= "    t_goods.shop_id = $shop_id";
$make_goods_sql .= "    AND";
$make_goods_sql .= "    t_goods.make_goods_flg = 't'";

//�إå�����ɽ�������������
$total_count_sql = $make_goods_sql.";";
$count_res = Db_Query($conn, $total_count_sql);
$total_count = pg_fetch_result($count_res,0,0);

$page_title .= "(��".$total_count."��)";
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'               => "$html_header",
	'page_menu'                 => "$page_menu",
	'page_header'               => "$page_header",
	'html_footer'               => "$html_footer",
    'html'                      => "$html",
    'code_value'                => "$code_value",
    'goods_err'                 => "$goods_err",
    'numerator_err'             => "$numerator_err",
    'numerator_numeric_err'     => "$numerator_numeric_err",
    'denominator_err'           => "$denominator_err",
    'denominator_numeric_err'   => "$denominator_numeric_err",
    'used_goods_err'            => "$used_goods_err",
    'used_make_goods_err'       => "$used_make_goods_err",
    'make_goods_flg_err'        => "$make_goods_flg_err",
    'goods_input_err'           => "$goods_input_err",
    'next_id'                   => "$next_id",
    'back_id'                   => "$back_id",
    'freeze_flg'                => "$freeze_flg",
    'auth_r_msg'                => "$auth_r_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
