<?php
/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/16��0064����������watanabe-k���ѹ����Ϲ�����ʸ�����Ԥ�ɽ�����ʤ��褦�˽���
 * ��2006/11/16��0065����������watanabe-k��Ʊ�쾦�ʤ������ԲĤȤʤ�褦�˽���
 * ��2006/11/16��0066����������watanabe-k��GET�����å��ɲ�
 * ��2006/11/16��0067����������watanabe-k��GET�����å��ɲ�
 * ��2006/11/16��0068����������watanabe-k��GET�����å��ɲ�
 * ��2006/11/16��0069����������watanabe-k��ľ��ͭ�����ʤ����ʤ˻���Ǥ��ʤ��褦�˽���
 * ��2006/11/16��0071����������watanabe-k����ǧ�ե饰����Ͽ����褦�˽���
 * ��2006/11/16��0072����������watanabe-k���Դ֤��������Ͽ���Ƥ�OK�Ȥʤ�褦�˽���
 *   2006-12-08  ban_0071      suzuki      ��Ͽ���ѹ��Υ���Ĥ��褦�˽���
 *   2007-01-22  �����ѹ�      watanabe-k  �ܥ���ο����ѹ�
 *   2007-06-25                watanabe-k  �����ʤ��ѹ������ޥ�����ͽ��ǡ�����ȿ�Ǥ��롣
 *   2009-10-08  �����ѹ�      hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *
 */


$page_title = "�����ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //�����Ϣ�δؿ�

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,"onSubmit=return confirm(true)");

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
if($get_goods_id != null){
    Get_Id_Check3($get_goods_id);
    $update_flg = true;
}else{
    $update_flg = false;
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
if($_POST["add_flg"]==true){
    //����Ԥˡ��ܣ�����
    $max_row = $_POST["max_row"]+1;
    //�Կ��ɲåե饰�򥯥ꥢ
    $add_row_data["add_flg"] = "";
    $add_row_data["max_row"] = $max_row;
    $form->setConstants($add_row_data);
}

/****************************/
//�Ժ������
/****************************/
if(isset($_POST["delete_row"])){
    //����ꥹ�Ȥ����
    $delete_row = $_POST["delete_row"];

    //������������ˤ��롣
    $del_history = explode(",", $delete_row);
}

/***************************/
//���������
/***************************/
$def_data["form_tax_div"]       = 1;
$def_data["form_name_change"]       = 1;
$def_data["form_state_type"]       = 1;
$def_data["form_accept"]       = "2";
$def_data["max_row"]            = $max_row;
//���������
$form->setDefaults($def_data);


/****************************/
//�ե���������ʸ����
/****************************/
//����
$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ��","1");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "̵��","2");
$form_state[] =& $form->createElement( "radio",NULL,NULL, "ͭ����ľ�ġ�","3");
$form->addGroup($form_state, "form_state_type", "����");

//��ǧ�饸���ܥ���
$form_accept[] =& $form->createElement("radio", null, null, "��ǧ��", "1");
$form_accept[] =& $form->createElement("radio", null, null, "̤��ǧ", "2");
$form->addGroup($form_accept, "form_accept", "");

//�����ʥ�����
$where  = " WHERE";
$where .= "     t_goods.public_flg = 't'";
$where .= "     AND";
$where .= "     t_goods.accept_flg = '1'";
$where .= "     AND";
$where .= "     t_goods.compose_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.no_change_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.state = '1'";

$code_value = Code_Value("t_goods",$conn, $where);
$form->addElement(
        "text","form_goods_cd","","size=\"10\" maxLength=\"8\" style=\"$g_form_style\"
        $g_form_option"
);

//������̾
$form->addElement(
        "text","form_goods_name","",'size="34" maxLength="30"
         '." $g_form_option"
);

//ά��
$form->addElement(
        "text","form_goods_cname","",'size="34" maxLength="10"
         '." $g_form_option"
);

//ñ��
$form->addElement(
        "text","form_unit","",'size="5" maxLength="5"
         '." $g_form_option"
);

//��̾�ѹ�
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ���","1");
$name_change[] =& $form->createElement( "radio",NULL,NULL, "�ѹ��Բ�","2");
$form->addGroup( $name_change, "form_name_change", "");
$form->addElement($type,"form_name_change_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//���Ƕ�ʬ
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","1");
//$tax_div[] =& $form->createElement( "radio",NULL,NULL, "����","2");
$tax_div[] =& $form->createElement( "radio",NULL,NULL, "�����","3");
$form->addGroup( $tax_div, "form_tax_div", "");
$form->addElement($type,"form_tax_div_name","","size=\"10\" maxLength=\"8\"
       $g_form_option"
);

//button
//��Ͽ�ʥإå���
//$form->addElement("button","new_button","�С�Ͽ","style=\"color: #ff0000;\" onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
$form->addElement("button","new_button","�С�Ͽ",$g_button_color."  onClick=\"location.href='$_SERVER[PHP_SELF]'\"");
//�ѹ�������
$form->addElement("button","change_button","�ѹ�������","onClick=\"javascript:location.href='./1-1-229.php'\"");

$form->addElement("submit","form_total_button","��ư�׻�","#");

//hidden
$form->addElement("hidden", "delete_row");          //�����
$form->addElement("hidden", "add_flg");             //�ɲùԥե饰
$form->addElement("hidden", "max_row");             //����Կ�
$form->addElement("hidden", "search_row");          //���ʸ����ե饰

$rank_name = array("�ղ�","ɸ�����");
for($i = 0; $i < 2; $i++){
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

//���顼�������ѥե��������
$form->addElement("text","price_err","","");
$form->addElement("text","parts_goods_err","","");
$form->addElement("text","count_err","","");

/***************************/
//�����ǡ�������
/***************************/
if($update_flg === true){

    //�ƾ��ʾ�������
    $sql  = "SELECT\n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_goods.goods_cname,\n";
    $sql .= "    t_goods.unit,\n";
    $sql .= "    t_goods.tax_div,\n";
    $sql .= "    t_goods.state,\n";
    $sql .= "    t_goods.name_change,\n";
    $sql .= "    t_goods.accept_flg ";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= " WHERE\n";
    $sql .= "    t_goods.goods_id = $get_goods_id\n";
    $sql .= "    AND\n";
    $sql .= "    t_goods.compose_flg = 't'\n";
    $sql .= "    AND\n";
    $sql .= "    t_goods.shop_id = $shop_id\n";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);
    $num = pg_num_rows($result);
    $set_goods_data = pg_fetch_array($result, 0);

    //���������ƾ��ʤΥǡ����򥻥å�
    $set_update_data["form_goods_cd"]       = $set_goods_data["goods_cd"];
    $set_update_data["form_goods_name"]     = $set_goods_data["goods_name"];
    $set_update_data["form_goods_cname"]    = $set_goods_data["goods_cname"];
    $set_update_data["form_unit"]           = $set_goods_data["unit"];
    $set_update_data["form_state_type"]     = $set_goods_data["state"];
    $set_update_data["form_name_change"]    = $set_goods_data["name_change"];
    $set_update_data["form_tax_div"]        = $set_goods_data["tax_div"];
    $set_update_data["form_accept"]         = $set_goods_data["accept_flg"];

    $def_goods_cd = $set_goods_data["goods_cd"];
    
    //�Ҥξ��ʤΥǡ��������
    $sql  = "SELECT \n";
    $sql .= "    t_goods.goods_cd,\n";
    $sql .= "    t_goods.goods_name,\n";
    $sql .= "    t_price.r_price,\n";
    $sql .= "    t_price2.r_price AS price,\n";
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
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price AS t_price2\n";
    $sql .= "    ON t_goods.goods_id = t_price2.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "    t_price.rank_cd = '1'\n";
    $sql .= "    AND\n";
    $sql .= "    t_price.shop_id = $shop_id\n";
    $sql .= "    AND\n";
    $sql .= "    t_price2.rank_cd = '4'\n";
    $sql .= "    AND\n";
    $sql .= "    t_price2.shop_id = $shop_id\n";
    $sql .= " ;\n"; 

    $result = Db_Query($conn, $sql);
    $parts_num = pg_num_rows($result);
    for($i = 0; $i < $parts_num; $i++){
        $set_parts_goods_data[$i] = pg_fetch_array($result, $i);
    }

    //���åȤ����������
    for($i = 0; $i < $parts_num; $i++){
        $set_update_data["form_parts_goods_cd"][$i]   = $set_parts_goods_data[$i]["goods_cd"];
        $set_update_data["form_parts_goods_name"][$i] = $set_parts_goods_data[$i]["goods_name"];
        $set_update_data["form_buy_price"][$i] = number_format($set_parts_goods_data[$i]["r_price"],2);
        $set_update_data["form_count"][$i]            = $set_parts_goods_data[$i]["count"];
        //ñ��
        $price = bcmul($set_parts_goods_data[$i]["price"],$set_parts_goods_data[$i]["count"],2);
        $buy_total = bcmul($set_parts_goods_data[$i]["r_price"],$set_parts_goods_data[$i]["count"],2);
        $set_update_data["form_buy_money"][$i] = number_format($buy_total,2);

        //�ղ�
        $buy_amount1 = bcadd($buy_amount1, $buy_total,2);
        //ɸ�����
        $buy_amount2 = bcadd($buy_amount2, $price,2);
    }

    $max_row = $parts_num;

    $set_update_data["form_rank_price"][0] = $buy_amount1;
    $set_update_data["form_rank_price"][1] = $buy_amount2;

    $form->setDefaults($set_update_data);
    //����
    $id_data = Make_Get_Id($conn, "compose",$set_goods_data["goods_cd"]);
    $next_id = $id_data[0];
    $back_id = $id_data[1];
}

/****************************/
//��ư�׻��ܥ���ɽ������
/****************************/
if($_POST["form_total_button"] == "��ư�׻�" || $_POST["form_entry_button"] == "�С�Ͽ"){

    //���ʥǡ�������
    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_parts_goods_cd"][$i] != null){
            $parts_goods_cd[$i]   = $_POST['form_parts_goods_cd'][$i];
            $parts_goods_name[$i] = $_POST["form_parts_goods_name"][$i];
            $count[$i]            = $_POST["form_count"][$i];

            //���ʤ����򤵤줿���ʤ�ñ�������
            $sql  = "SELECT\n";
            $sql .= "   t_price.r_price\n";
            $sql .= " FROM\n";
            $sql .= "   t_price\n";
            $sql .= "       INNER JOIN\n";
            $sql .= "   (SELECT\n";
            $sql .= "       goods_id\n";
            $sql .= "   FROM\n";
            $sql .= "       t_goods\n";
            $sql .= "   WHERE\n";
            $sql .= "       goods_cd = '$parts_goods_cd[$i]'\n";
            $sql .= "       AND\n";
            $sql .= "       shop_id = $shop_id\n";
            $sql .= "   ) AS t_goods\n";
            $sql .= "   ON t_price.goods_id = t_goods.goods_id\n";
            $sql .= " WHERE\n";
            $sql .= "   t_price.rank_cd IN ('1','4')\n";
            $sql .= "   AND\n";
            $sql .= "   t_price.shop_id = $shop_id\n";
            $sql .= ";";

            $result = Db_Query($conn, $sql);

            for($j = 0; $j < 2; $j++){
                $buy_money = bcmul($count[$i], pg_fetch_result($result,$j,0),2);
                $total_price[$j] = bcadd($total_price[$j],$buy_money,2);
            }
        }
    }

    //�׻���̤򥻥å�
    for($i = 0; $i < 2; $i++){
        $set_price_data["form_rank_price[$i]"] = $total_price[$i];
    }

    $form->setConstants($set_price_data);
}

/****************************/
//��Ͽ�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /*****************************/
    //POST�������
    /*****************************/
    $state                  = $_POST["form_state_type"];        //����
    $goods_cd               = $_POST["form_goods_cd"];          //�����ʥ�����
    $goods_name             = $_POST["form_goods_name"];        //������̾
    $goods_cname            = $_POST["form_goods_cname"];       //ά��
    $unit                   = $_POST["form_unit"];              //ñ��
    $tax_div                = $_POST["form_tax_div"];           //���Ƕ�ʬ
    $name_change            = $_POST["form_name_change"];        //��̾�ѹ�
    $accept                 = $_POST["form_accept"];

    $j = 0;
    $parts_goods_cd = null;
    $parts_goods_name = null;
    $count = null;

    //���ʥǡ�������
    for($i = 0; $i < $max_row; $i++){
        if($_POST["form_parts_goods_cd"][$i] != null){
            $parts_goods_cd[$j]   = $_POST['form_parts_goods_cd'][$i];
            $parts_goods_name[$j] = $_POST["form_parts_goods_name"][$i];
            $count[$j]            = $_POST["form_count"][$i];
            $j++;
        }
    }
    /****************************/
    //�롼�������Quick_Form�ǥ����å���
    /****************************/
    //�������ʥ�����
    //��ɬ�ܥ����å�
    $form->addRule('form_goods_cd','�����ʥ����ɤ�8ʸ����Ⱦ�ѿ����Ǥ���', 'required');

    //��Ⱦ�ѥ����å�
    $form->addRule('form_goods_cd','�����ʥ����ɤ�8ʸ����Ⱦ�ѿ����Ǥ���', "regex", "/^[0-9]+$/");

    //��������̾
    //��ɬ�ܥ����å�  
    $form->addRule('form_goods_name','������̾�ϣ�ʸ���ʾ�30ʸ���ʲ��Ǥ���','required');
    // ����/Ⱦ�ѥ��ڡ����Τߥ����å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_goods_name", "������̾ �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    //��ά��
    //��ɬ�ܥ����å�
    $form->addRule('form_goods_cname','ά�Τ�1ʸ���ʾ�10ʸ���ʲ��Ǥ���','required'); 
    // ����/Ⱦ�ѥ��ڡ����Τߥ����å�
    $form->registerRule("no_sp_name", "function", "No_Sp_Name");
    $form->addRule("form_goods_cname", "ά�� �˥��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���", "no_sp_name");

    /****************************/
    //�롼�������PHP�ǥ����å���
    /****************************/
    //���������ηϥ����å�
    if($goods_cd != null && (strlen($goods_cd) >= 8) && substr($goods_cd, 0, 1) != 0){
        $form->setElementError("form_goods_cd","���ʥ����ɤξ壱��ϡ֣��פǤ���");
    }

    //���ʥ���������
    $goods_cd = str_pad($goods_cd, 8, 0, STR_PAD_LEFT);

    //���ʥ����ɶ��������å�
    $sql  = " SELECT";
    $sql .= "     goods_cd";
    $sql .= " FROM";
    $sql .= "     t_goods";
    $sql .= " WHERE";
    $sql .= "     shop_id = $shop_id";
    $sql .= "     AND";
    $sql .= "     goods_cd = '$goods_cd'";
    $sql .= " ;";

    $result = Db_Query($conn, $sql);
    $db_goods_cd = @pg_fetch_result($result, 0,0);       //��ʣ�������ʥ�����

    if($db_goods_cd != null && $update_flg != true){
        $form->setElementError("form_goods_cd","���˻��Ѥ���Ƥ��� ���ʥ����� �Ǥ���");
    }elseif($db_goods_cd != null && $update_flg == true && $def_goods_cd != $db_goods_cd){
        $form->setElementError("form_goods_cd","���˻��Ѥ���Ƥ��� ���ʥ����� �Ǥ���");
    }

    //��Ͽ�����ξ��
    if($_GET["goods_id"] == null){
        //�������ϥ����å�
        for($i = 0; $i < $max_row; $i++){
            if($parts_goods_name[$i] != null){
                $input_flg = true;
            }
        }

        if($input_flg != true){
            $form->setElementError("parts_goods_err","���ʤ���Ĥ����򤵤�Ƥ��ޤ���");
        }else{

            for($i = 0; $i < count($parts_goods_cd); $i++){
                //������
                //��ɬ�ܥ����å�
                if($parts_goods_cd[$i] != "" && $parts_goods_name[$i] == null){
                    $form->setElementError("parts_goods_err","���ʤ����������ʥ����ɤ����Ϥ��Ʋ�������");
                }

                //������
                //��ɬ�ܥ����å�
                if($count[$i] == null && $parts_goods_name[$i] != null){
                    $form->setElementError("count_err","���̤�Ⱦ�ѿ�����1ʸ���ʾ�5ʸ���ʲ��Ǥ���");
                }

                //�����������å�
                if($count[$i] != null  && !ereg("^[0-9]+$", $count[$i])){
                    $form->setElementError("count_err",'���̤�Ⱦ�ѿ�����1ʸ���ʾ�5ʸ���ʲ��Ǥ���');
                }
        
                //��Ʊ�쾦�ʤ�ʣ�����򤵤�Ƥ�����
                for($j = 0; $j < count($parts_goods_cd); $j++){
                    if($i != $j && $parts_goods_cd[$i] == $parts_goods_cd[$j]){
                        $form->setElementError("parts_goods_err","�����ʤ�Ʊ�����ʤ�ʣ�����򤵤�Ƥ��ޤ���");
                        break;
                    }
                }
            }
        }
    }

    /****************************/
    //����
    /****************************/
    if($form->validate()){

        Db_Query($conn, "BEGIN");

        /*****************************/
        //��������
        /*****************************/
        if($update_flg === true){
            //���ʥޥ����ξ�����ѹ�
			$work_div = 2;

            $sql  = "UPDATE t_goods SET\n";
            $sql .= "   goods_cd = '$goods_cd',\n";
            $sql .= "   goods_name = '$goods_name',\n";
            $sql .= "   goods_cname = '$goods_cname',\n";
            $sql .= "   unit = '$unit',\n";
            $sql .= "   tax_div = '$tax_div',\n";
            $sql .= "   name_change = '$name_change',\n";
            $sql .= "   state = '$state',\n";
            $sql .= "   accept_flg = '$accept' ";
            $sql .= "WHERE\n";
            $sql .= "   goods_id = $get_goods_id\n";
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK;");
                exit;
            }

            //���ʥޥ������ѹ������ޥ�����ͽ��ǡ�����ȿ��
            $result = Mst_Sync_Goods($conn,$get_goods_id,"name");
            if($result === false){
                exit;
            }

        /*****************************/
        //��Ͽ����
        /*****************************/
        }else{
            //�����ʤ��ʥޥ�������Ͽ    
			$work_div = 1;

            $sql  = "INSERT INTO t_goods (\n";
            $sql .= "    goods_id\n,";
            $sql .= "    goods_cd,\n";
            $sql .= "    goods_name,\n";
            $sql .= "    goods_cname,\n";
            $sql .= "    unit,\n";
            $sql .= "    tax_div,\n";
            $sql .= "    name_change,\n";
            #2009-10-08 hashimoto-y
            #$sql .= "    stock_manage,\n";
            $sql .= "    compose_flg,\n";
            $sql .= "    state,\n";
            $sql .= "    public_flg,\n";
            $sql .= "    shop_id, \n";
            $sql .= "    accept_flg ";
            $sql .= " )VALUES(\n";
            $sql .= "    (SELECT COALESCE(MAX(goods_id),0)+1 FROM t_goods),\n";
            $sql .= "    '$goods_cd',\n";
            $sql .= "    '$goods_name',\n";
            $sql .= "    '$goods_cname',\n";
            $sql .= "    '$unit',\n";
            $sql .= "    '$tax_div',\n";
            $sql .= "    '$name_change',\n";
            #2009-10-08 hashimoto-y
            #$sql .= "    '2',\n";
            $sql .= "    't',\n";
            $sql .= "    '$state',\n";
            $sql .= "    't',\n";
            $sql .= "    $shop_id,\n";
            $sql .= "    '$accept'";
            $sql .= ");\n"; 

            $result = Db_Query($conn, $sql);
            if($result === false){
                Db_Query($conn, "ROLLBACK");
                exit;
            }

            //��Ͽ���������ʤξ���ID����� 
            $sql  = "SELECT\n";
            $sql .= "   goods_id\n";
            $sql .= " FROM\n";
            $sql .= "   t_goods\n";
            $sql .= " WHERE\n";
            $sql .= "   goods_cd = '$goods_cd'\n";
            $sql .= "   AND\n";
            $sql .= "   shop_id = $shop_id\n";
            $sql .= ";\n";

            $result = Db_Query($conn, $sql);
            $goods_id = pg_fetch_result($result, 0, 0);

            //�����ʤ����ʤ����ʥޥ�������Ͽ
            for($i = 0; $i < count($parts_goods_cd); $i++){
                $sql  = "INSERT INTO t_compose (\n";
                $sql .= "   goods_id,\n";
                $sql .= "   parts_goods_id,\n";
                $sql .= "   count\n";
                $sql .= ")VALUES(\n";
                $sql .= "   $goods_id,\n";
                $sql .= "   (SELECT\n";
                $sql .= "       goods_id\n";
                $sql .= "   FROM\n";
                $sql .= "       t_goods\n";
                $sql .= "   WHERE\n";
                $sql .= "       goods_cd = '$parts_goods_cd[$i]'\n";
                $sql .= "       AND\n";
                $sql .= "       shop_id = $shop_id\n";
                $sql .= "   ),\n";
                $sql .= "   $count[$i]\n";
                $sql .= ");\n";
                $result = Db_Query($conn, $sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                } 
            }
        }

        //��Ͽ�����������˻Ĥ�
        $result = Log_Save( $conn, "compose", $work_div,$goods_cd,$goods_name);
        if($result === false){
            Db_Query($conn, "ROLLBACK");
            exit;
        }
        Db_query($conn, "COMMIT;");
        $freeze_flg = true;
    }
//���ʸ�������
}elseif($_POST["search_row"] != null){

    $search_row = $_POST["search_row"];
    $goods_cd = $_POST["form_parts_goods_cd"][$search_row];

    $sql  = "SELECT";
    $sql .= "   t_goods.goods_name,\n";
    $sql .= "   t_price.r_price\n";
    $sql .= " FROM\n";
    $sql .= "   t_goods\n";
    $sql .= "       INNER JOIN\n";
    $sql .= "   t_price\n";
    $sql .= "   ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_cd = '$goods_cd'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.public_flg = 't'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.accept_flg = '1'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.state = '1'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.compose_flg = 'f'";
    $sql .= "   AND\n";
    $sql .= "   t_goods.shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.rank_cd = '1'\n";
    $sql .= "   AND\n";
    $sql .= "   t_goods.no_change_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   t_price.shop_id = $shop_id";
    $sql .= ";\n";

    $result = Db_Query($conn, $sql);
    $goods_name = @pg_fetch_result($result, 0, 0);
    $price      = @pg_fetch_result($result, 0, 1);

    $set_goods_data["form_parts_goods_name"][$search_row] = $goods_name;
    $set_goods_data["form_buy_price"][$search_row] = $price;
    $set_goods_data["form_count"][$search_row] = "";
    $set_goods_data["search_row"] = "";

    $form->setConstants($set_goods_data);
}

/******************************/
//��Ͽ�����
/******************************/
if($freeze_flg == true){

    // �����ץܥ����������ID����
    // ������
    if ($get_goods_id == null){
        $sql    = "SELECT MAX(goods_id) FROM t_goods WHERE shop_id = $shop_id AND compose_flg = 't';";
        $res    = Db_Query($conn, $sql);
        $get_id = pg_fetch_result($res, 0, 0);
    }else{
        $get_id = $get_goods_id;
    }

    $form->addElement("button","form_entry_button","�ϡ���","onClick=\"location.href='./1-1-230.php'\" $disabled");
    $form->addElement("button","form_back_button","�ᡡ��", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."?goods_id=$get_id'\"");
    $form->addElement("static","form_goods_link","","�����ʥ�����","");
    $form->freeze();
}else{
	// ���ϸ��¤Τ��륹���åդΤ߽���
	$form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('�����ʤϰ�����Ͽ������ѹ��Ǥ��ޤ���','#')\" $disabled");
    //���إܥ���
    if($next_id != null){
        $form->addElement("button","next_button","������","onClick=\"location.href='./1-1-230.php?goods_id=$next_id'\"");
    }else{
        $form->addElement("button","next_button","������","disabled");
    }

    //���إܥ���
    if($back_id != null){
        $form->addElement("button","back_button","������","onClick=\"location.href='./1-1-230.php?goods_id=$back_id'\"");
    }else{
        $form->addElement("button","back_button","������","disabled");
    }

    $form->addElement(
        "link","form_goods_link","","#","�����ʥ�����",
        "onClick=\"return Open_SubWin('../dialog/2-0-210.php', Array('form_compose_goods[cd]', 'form_compose_goods[name]'), 500, 450);\""
     );

}

/*****************************/
//�ե������������ư��
/*****************************/
//���ֹ楫����
$row_num = 1;

if($freeze_flg == true || $update_flg == true){
    $style  = "color : #000000;";
    $style .= "border : #ffffff 1px solid;";
    $style .= "background-color: #ffffff;";
    $g_form_option = "readonly";
}

for($i = 0; $i < $max_row; $i++){    //�����Ƚ��
    if(!in_array("$i", $del_history)){
        //�������
        $del_data = $delete_row.",".$i;

        /***************************/
        //ưŪ�ե��������
        /***************************/ 
        //���ʥ�����
        $form_goods =& $form->addElement(
                "text","form_parts_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
                onChange=\"goods_search_1(this.form, 'form_parts_goods_cd', 'search_row', $i)\" 
                $g_form_option style=\"$style ime-mode: disabled;\"
            ");

        //����̾
        $form_goods =& $form->addElement(
                "text","form_parts_goods_name[$i]","","size=\"34\" style=\"$style\" $g_text_readonly"
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
                "text","form_count[$i]","","size=\"5\" maxLength=\"5\" style=\"$style ime-mode: disabled; text-align: right\"
                onKeyup=\"buy_money('$i')\"
                $g_form_option"
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
        if($freeze_flg != true && $update_flg != true){
            $html .=    "��<a href=\"#\" onClick=\"return Open_SubWin('../dialog/1-0-210.php', 
                Array('form_parts_goods_cd[$i]', 'search_row'), 500, 450,5,$shop_id,$i);\">����</a>��";
        }
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
        $html .=    "</td>\n";

        if($freeze_flg != true && $update_flg != true){
            $html .=    "<td align=\"center\">";
            $html .=       "<a href=\"#\" onClick=\"javascript:Dialogue_1('������ޤ���',  '$del_data', 'delete_row')\">���</a>";
            $html .=    "</td>\n";
        }
        $html .= "</tr>\n";

        //���ֹ���
        $row_num = $row_num+1;
    }
}

/****************************/
//javascript
/****************************/
$js  = "function buy_money(num){\n";
$js .= "   //�ե�����̾���\n";
$js .= "    var BP = \"form_buy_price\"+\"[\"+num+\"]\";\n";
$js .= "    var BM = \"form_buy_money\"+\"[\"+num+\"]\";\n";
$js .= "    var CO = \"form_count\"+\"[\"+num+\"]\";\n";

$js .= "    //VALUE \n";
$js .= "    var BPV = document.dateForm.elements[BP].value;\n";
$js .= "    var COV = document.dateForm.elements[CO].value;\n";

$js .= "    //����ޤ������\n";
$js .= "    var BPV = BPV.replace(\",\",\"\");\n";
$js .= "    var BPV = BPV.replace(\",\",\"\");\n";

$js .= "    //�׻�\n";
$js .= "    if(isNaN(COV) == false && COV != \"\" && BPV != \"\"){ \n";
$js .= "        var COV = eval(COV * 1000) \n";
$js .= "        var BMV = eval(BPV * COV)/1000;\n";
$js .= "        var BMV = String(myFormatNumber(BMV));\n";

$js .= "        var AB = BMV.split(\".\");\n";
$js .= "        if(AB[1] == undefined){\n";
$js .= "            AB[1] = \"00\"; \n";
$js .= "        }\n";

$js .= "        document.dateForm.elements[BM].value = AB[0]+\".\"+AB[1];\n";
$js .= "    }else{\n";
$js .= "        document.dateForm.elements[BM].value = \"\";\n";
$js .= "    }\n";
$js .= "}\n";

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
$compose_goods_sql .= "    ) AS t_goods_id";
//�إå�����ɽ�������������
$total_count_sql = $compose_goods_sql.";";
$result = Db_Query($conn, $total_count_sql);
$total_count = @pg_fetch_result($result,0,0);

$page_title .= "������".$total_count."���";
$page_title .= "������".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
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
    'freeze_flg'                => "$freeze_flg",
    'auth_r_msg'                => "$auth_r_msg",
    'js'                        => "$js"
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
