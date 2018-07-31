<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006-12-14      kaji-201    kaji        �����ʤξ��֤򸫤�褦�ˡ�������̵���ˤ��줿�Ȥ���
 *  2007/08/22                  kajioka-h   �߸˸�����ɽ����ñ��ɽ����ñ��������̤��¤Ӥ˹�碌��
 *
 */

$page_title = "�����ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);

/****************************/
//�����ѿ�����
/****************************/
$shop_id = $_SESSION["client_id"];
$rank_cd  = $_SESSION["rank_cd"];
$group_kind = $_SESSION["group_kind"];
$get_goods_id = $_GET["goods_id"];
Get_Id_Check3($get_goods_id);
Get_Id_Check2($get_goods_id);

/****************************/
//�������
/****************************/
$max_row = 10;

/****************************/
//�ե���������ʸ����
/****************************/
//����
$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","1");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "̵��","2");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ����ľ�ġ�","3");
$form->addGroup($form_state, "form_state_type", "����");

//�����ʥ�����
$code_value = Code_Value("t_goods",$conn);
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        $g_form_option");

//������̾
$form->addElement(
        "text","form_goods_name","",'size="34" maxLength="30"
         '." $g_form_option");
//ά��
$form->addElement(
        "text","form_goods_cname","",'size="34" maxLength="10"
         '." $g_form_option");

//ñ��
$form->addElement(
        "text","form_unit","",'size="5" maxLength="5"
         '." $g_form_option");

//��̾�ѹ�
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ���","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ��Բ�","2");
$form->addGroup( $name_change, "form_name_change", "");

//���Ƕ�ʬ
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "�����","3");
$form->addGroup( $tax_div, "form_tax_div", "");

//�ܵҶ�ʬñ��
//$rank_name = array("����ñ��","ɸ�����","�Ķ�ñ��");
//for($i = 0; $i < 3; $i++){
$rank_name = array("��������", "�߸˸���", "�Ķȸ���", "ɸ�����");
for($i = 0; $i < count($rank_name); $i++){
    //�ܵҶ�ʬ���Ȥ˥ե���������
    $form->addElement(
        "text","form_rank_price[$i]","$rank_name[$i]",
        "style =\"color : #000000;
        text-align : right;
        border : #ffffff 1px solid;
        background-color: #ffffff;\"
        readonly"
    );
}

/***************************/
//���������
/***************************/

if($get_goods_id != null){
    //�ƾ��ʾ�������
    $sql  = "SELECT\n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_goods.goods_cname,\n";
    $sql .= "    t_goods.unit,\n";
    $sql .= "    t_goods.tax_div,\n";
    $sql .= "    t_goods.state,\n";
    $sql .= "    t_goods.name_change\n";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= " WHERE\n";
    $sql .= "    t_goods.goods_id = $get_goods_id\n";
    $sql .= "    AND\n";
    $sql .= "    t_goods.compose_flg = 't'\n";
    $sql .= "    AND\n";
    $sql .= ($_SESSION["group_kind"] == "2") ? "    t_goods.state IN ('1', '3') \n" : "    t_goods.state = '1' \n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $num = pg_num_rows($result);

    $set_goods_data = pg_fetch_array($result, 0);    //���������ƾ��ʤΥǡ����򥻥å�

    $set_update_data["form_goods_cd"]       = $set_goods_data["goods_cd"];
    $set_update_data["form_goods_name"]     = $set_goods_data["goods_name"];
    $set_update_data["form_goods_cname"]    = $set_goods_data["goods_cname"];
    $set_update_data["form_unit"]           = $set_goods_data["unit"];
    $set_update_data["form_state_type"]     = $set_goods_data["state"];
    $set_update_data["form_name_change"]    = $set_goods_data["name_change"];
    $set_update_data["form_tax_div"]        = $set_goods_data["tax_div"];
    $def_goods_cd = $set_goods_data["goods_cd"];

    //�Ҥξ��ʤΥǡ��������
    $sql  = "SELECT \n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_price.r_price,\n";               //��������
    $sql .= "    t_price2.r_price AS price,\n";     //ɸ�����
    $sql .= "    t_price3.r_price AS price2,\n";    //�Ķȸ���
    $sql .= "    t_price4.r_price AS price3,\n";    //�߸˸���
    $sql .= "    t_goods.count\n";
    $sql .= " FROM\n";
    $sql .= "    (SELECT\n";
    $sql .= "        t_goods.goods_id,\n";
    $sql .= "        t_goods.goods_cd,\n";
    $sql .= "        t_goods.goods_name,\n";
    $sql .= "        t_compose.count\n";
    $sql .= "     FROM\n";
    $sql .= "        t_goods\n";
    $sql .= "            INNER JOIN\n";
    $sql .= "        t_compose\n";
    $sql .= "        ON t_goods.goods_id = t_compose.parts_goods_id\n";
    $sql .= "     WHERE\n";
    $sql .= "        t_compose.goods_id = $get_goods_id\n";
    $sql .= "    ) AS t_goods\n";
    $sql .= "        LEFT JOIN\n";
//����ñ��
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = '$rank_cd'\n";
    $sql .= "    ) AS t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        LEFT JOIN\n";
//ɸ��ñ��
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = '4'\n";
    $sql .= "    ) AS t_price2\n";
    $sql .= "    ON t_goods.goods_id = t_price2.goods_id\n";
    $sql .= "        LEFT JOIN\n";
//�Ķ�ñ��
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = '2'\n";
    $sql .= "        AND\n";
//    $sql .= "        shop_gid = $shop_gid\n";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= "    ) AS t_price3\n";
    $sql .= "    ON t_goods.goods_id = t_price3.goods_id\n";
    $sql .= "        LEFT JOIN\n";
//�߸˸���
    $sql .= "    (SELECT\n";
    $sql .= "        goods_id,\n";
    $sql .= "        r_price\n";
    $sql .= "    FROM\n";
    $sql .= "        t_price\n";
    $sql .= "    WHERE\n";
    $sql .= "        rank_cd = '3'\n";
    $sql .= "        AND\n";
    $sql .= ($group_kind == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = $shop_id ";
    $sql .= "    ) AS t_price4\n";
    $sql .= "    ON t_goods.goods_id = t_price4.goods_id\n";
    $sql .= " ;\n";

    $result = Db_Query($conn, $sql);
    $parts_num = pg_num_rows($result);
    for($i = 0; $i < $parts_num; $i++){
        $set_parts_goods_data[$i] = pg_fetch_array($result, $i);
    }

    //���åȤ����������
    for($i = 0; $i < $parts_num; $i++){
        //����ñ���Τʤ����ʤ�TOP������
        if($set_parts_goods_data[$i]["r_price"] == null){
            header("Location:../top.php");
            exit;
        }

        $set_update_data["form_parts_goods_cd"][$i]   = $set_parts_goods_data[$i]["goods_cd"];
        $set_update_data["form_parts_goods_name"][$i] = $set_parts_goods_data[$i]["goods_name"];
        $set_update_data["form_buy_price"][$i] = number_format($set_parts_goods_data[$i]["r_price"],2);
        $set_update_data["form_count"][$i]            = $set_parts_goods_data[$i]["count"];
        //ñ��
        //ɸ��
        $price = bcmul($set_parts_goods_data[$i]["price"],$set_parts_goods_data[$i]["count"],2);

        //�Ķ�
        $price2 = bcmul($set_parts_goods_data[$i]["price2"],$set_parts_goods_data[$i]["count"],2);        

        //����
        $buy_total = bcmul($set_parts_goods_data[$i]["r_price"],$set_parts_goods_data[$i]["count"],2);
        $set_update_data["form_buy_money"][$i] = number_format($buy_total,2);

        //�߸�
        $price3 = bcmul($set_parts_goods_data[$i]["price3"], $set_parts_goods_data[$i]["count"], 2);

        //����
        $buy_amount1 = bcadd($buy_amount1, $buy_total,2);
        //ɸ�����
        $buy_amount2 = bcadd($buy_amount2, $price,2);
        //�Ķ�
        $buy_amount3 = bcadd($buy_amount3, $price2,2); 
        //�߸�
        $buy_amount4 = bcadd($buy_amount4, $price3, 2); 
    }

/*
    $set_update_data["form_rank_price"][0] = $buy_amount1;
    $set_update_data["form_rank_price"][1] = $buy_amount2;
    $set_update_data["form_rank_price"][2] = $buy_amount3;
*/
    $set_update_data["form_rank_price"][0] = $buy_amount1;
    $set_update_data["form_rank_price"][1] = $buy_amount4;
    $set_update_data["form_rank_price"][2] = $buy_amount3;
    $set_update_data["form_rank_price"][3] = $buy_amount2;

    $max_row = $parts_num;

    $form->setConstants($set_update_data);
    //����  
//    $id_data = Make_Get_Id($conn, "compose",$set_goods_data["goods_cd"]);
//    $next_id = $id_data[0];
//    $back_id = $id_data[1];

}

//button
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:Referer('2-1-229.php')\"");

$form->addElement("button","form_total_button","�硡��","");

//hidden
$form->addElement("hidden", "delete_row");             //�����
$form->addElement("hidden", "add_flg");         //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�

if($freeze_flg == true){
    $form->addElement("button","form_entry_button","�ϡ���","onClick=\"location.href='./2-1-230.php'\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"history.back()\"");
    $form->addElement("static","form_goods_link","","�����ʥ�����","");
    $form->freeze();
}else{
    //���إܥ���
/*
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./2-1-230.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }

    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./2-1-230.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
    }
*/
    $form->addElement(
        "link","form_goods_link","","#","�����ʥ�����",
        "onClick=\"return Open_SubWin('../dialog/2-0-210.php', Array('form_compose_goods[cd]', 'form_compose_goods[name]'), 500, 450);\""
    );

}
$form->freeze();

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

for($i = 0; $i < $max_row; $i++){    //�����Ƚ��
    //���ʥ�����
    $form_goods =& $form->addElement(
        "text","form_parts_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
        style = \"color: #000000;
        border : #ffffff 1px solid;
        text-align : right;
        background-color : #ffffff;\"
        $g_text_readonly"
    );

    //����̾
    $form_goods =& $form->addElement(
        "text","form_parts_goods_name[$i]","","size=\"34\" 
        style = \"color: #000000;
        border : #ffffff 1px solid;
        text-align : right;
        background-color : #ffffff;\"
        $g_text_readonly"
    );

    //����ñ��
    $form_goods =& $form->addElement(
        "text","form_buy_price[$i]","","
        style = \"color: #000000;
        border : #ffffff 1px solid;
        text-align : right;
        background-color : #ffffff;\"
        $g_text_readonly"
    );

    //����  
    $form->addElement(
        "text","form_count[$i]","","
        style = \"color: #000000;
        border : #ffffff 1px solid;
        text-align : right;
        background-color : #ffffff;\"
        $g_text_readonly"
    );

    //�������
    $form_goods =& $form->addElement(
        "text","form_buy_money[$i]","","
        style = \"color: #000000;
        border : #ffffff 1px solid;
        text-align : right;
        background-color : #ffffff;\"
        $g_text_readonly"
    );

    /****************************/
    //ɽ����HTML����
    /****************************/
    $html .= "<tr class=\"Result1\">\n";
    $html .=    "<td align=\"right\">$row_num</td>\n";
    //���ʥ����ɡ�����̾
    $html .=    "<td align=\"left\">\n";
    $html .=        $form->_elements[$form->_elementIndex["form_parts_goods_cd[$i]"]]->toHtml();
    $html .=    "</td>\n";
    $html .=    "<td align=\"left\">\n";
    $html .=        $form->_elements[$form->_elementIndex["form_parts_goods_name[$i]"]]->toHtml();
    $html .=    "</td>\n";

    //����ñ��
    $html .=    "<td>\n";
    $html .=        $form->_elements[$form->_elementIndex["form_buy_price[$i]"]]->toHtml();
    $html .=    "</td>\n";

    //���̡�ʬ��/ʬ���
    $html .=    "<td align=\"center\">\n";
    $html .=        $form->_elements[$form->_elementIndex["form_count[$i]"]]->toHtml();
    $html .=    "</td>\n";

    //�������
    $html .=    "<td>\n";
    $html .=        $form->_elements[$form->_elementIndex["form_buy_money[$i]"]]->toHtml();
    $html .=    "</td>\n";        if($freeze_flg != true && $update_flg != true)
    $html .= "</tr>\n";        

    //���ֹ���
    $row_num = $row_num+1;
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

/****************************/
//���������
/****************************/
$compose_goods_sql  = " SELECT";
$compose_goods_sql .= "    COUNT(t_goods_id.goods_id)";
$compose_goods_sql .= " FROM";
$compose_goods_sql .= "    (SELECT ";
$compose_goods_sql .= "    DISTINCT";
$compose_goods_sql .= "    t_compose.goods_id ";
$compose_goods_sql .= "    FROM ";
$compose_goods_sql .= "    t_compose";
$compose_goods_sql .= "     INNER JOIN ";
$compose_goods_sql .= "    t_goods ";
$compose_goods_sql .= "    ON t_compose.goods_id = t_goods.goods_id ";
$compose_goods_sql .= " WHERE ";
$compose_goods_sql .= "    t_goods.accept_flg = '1' ";
$compose_goods_sql .= "    ) AS t_goods_id";
//�إå�����ɽ�������������
$total_count_sql = $compose_goods_sql.";";
$result = Db_Query($conn, $total_count_sql);
$match_count = @pg_fetch_result($result,0,0);

$sql  = "SELECT\n";
$sql .= "    t_goods.goods_id,\n";
$sql .= "    t_goods.goods_cd,\n";
$sql .= "    t_goods.goods_name,\n";
$sql .= "    t_com_goods.goods_cd,\n";
$sql .= "    t_com_goods.goods_name,\n";
$sql .= "    t_compose.count,\n";
$sql .= "    CASE t_com_goods.accept_flg \n";
$sql .= "       WHEN '1' THEN '��'\n";
$sql .= "       WHEN '2' THEN '��'\n";
$sql .= "    END, \n";
$sql .= "    t_price.r_price \n";
$sql .= "FROM\n";
$sql .= "    t_compose\n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods\n";
$sql .= "    ON t_compose.goods_id = t_goods.goods_id\n";
$sql .= "       INNER JOIN\n";
$sql .= "    t_goods AS t_com_goods\n";
$sql .= "    ON t_compose.parts_goods_id = t_com_goods.goods_id\n";
$sql .= "       LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "       goods_id,\n";
$sql .= "       r_price\n";
$sql .= "   FROM\n";
$sql .= "       t_price\n";
$sql .= "   WHERE\n";
$sql .= "       rank_cd = '$rank_cd'\n";
$sql .= "   ) AS t_price\n";
$sql .= "   ON t_com_goods.goods_id = t_price.goods_id\n";
$sql .= "WHERE\n";
$sql .= "    t_goods.accept_flg = '1'\n";

$result = Db_Query($conn, $sql.";");
$total_count = pg_num_rows($result);



$page_title .= "(��".$match_count."��)";
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
	'count_err'                 => "$count_err",
	'count_numeric_err'         => "$count_numeric_err",
	'used_goods_err'            => "$used_goods_err",
	'used_compose_goods_err'    => "$used_compose_goods_err",
	'compose_goods_flg_err'     => "$compose_goods_flg_err",
	'goods_input_err'           => "$goods_input_err",
	'freeze_flg'                => "$freeze_flg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
