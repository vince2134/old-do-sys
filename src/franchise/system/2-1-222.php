<?php
/*************************
�ѹ�����
    ���������ѹ������ɽ�����ʤ��褦���ѹ�
    �������å�̾��ñ������ơ��֥�˻Ĥ�

    2006/07/06 shop_gid��ʤ��� (kaji)
************************/

/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-06-26     �����ѹ�����watanabe-k   ñ�����ѹ������ޥ�����ͽ��ǡ����˻Ĥ��褦�˽���
 *  2007-08-24     �����ѹ�����watanabe-k   ���ʥޥ���Ʊ��������Ԥʤ�ʤ��褦�˽���
 *  2015/05/13                  amano 	  Dialogue�ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�
*/



$page_title = "���ʥޥ���";

//�Ķ�����ե�����
require_once("ENV_local.php");
require_once(INCLUDE_DIR."function_keiyaku.inc"); //�����Ϣ�δؿ�

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]",null,
"onSubmit=return confirm(true)");

//DB����³
$conn = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($conn);
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
session_start();
//$shop_gid = $_SESSION["shop_gid"];
$shop_id = $_SESSION["client_id"];
$get_goods_id = $_GET["goods_id"];                          //GET��������ID
Get_ID_Check2($get_goods_id);
$rank_cd  = $_SESSION["rank_cd"];
$staff_id = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];

/*
$where  = " (rank_cd = '0003' OR ";
$where .= ($_SESSION["group_kind"] == "2") ? " shop_id IN (".Rank_Sql().") " : " shop_id = ".$_SESSION["client_id"]." ";
$where .= " ) ";
if ($_GET["goods_id"] != null && Get_Id_Check_Db($conn, $_GET["goods_id"], "goods_id", "t_price", "num", $where) != true){
//    header("Location: ../top.php");
}
*/
// GET��ID�����å�
if ($_GET["goods_id"] != null && ereg("^[0-9]+$", $_GET["goods_id"])){
    // ñ������Ѿ��ʤξ��
    $sql  = "SELECT * \n";
    $sql .= "FROM   t_price \n";
    $sql .= "WHERE  goods_id = ".$_GET["goods_id"]." \n";
    $sql .= "AND    rank_cd = '0003' \n";
    $sql .= ";";
    $res  = Db_Query($conn, $sql);
    $num1 = pg_num_rows($res);
    // ñ��̤���꾦�ʤξ��
    $sql  = "SELECT * \n";
    $sql .= "FROM   t_goods \n";
    $sql .= "WHERE  goods_id = ".$_GET["goods_id"]." \n";
    $sql .= "AND    shop_id ";
    $sql .= ($_SESSION["group_kind"] == "2") ? "IN (".Rank_Sql().") \n"
                                             : "= ".$_SESSION["client_id"]." \n";
    $sql .= ";";
    $res  = Db_Query($conn, $sql);
    $num2 = pg_num_rows($res);
    // ���
    if ($num1 == 0 && $num2 == 0){
        header("Location: ../top.php");
    }
}else{
    header("Location: ../top.php");
}

/****************************/
//��Ͽ���Υ����å�̾�����
/****************************/
$sql  = "SELECT";
$sql .= "   staff_name"; 
$sql .= " FROM";
$sql .= "   t_staff";
$sql .= " WHERE";
$sql .= "   t_staff.staff_id = $staff_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$staff_name = pg_fetch_result($result, 0,0);

/****************************/
//����̾�����
/****************************/
/*
if($get_goods_id != null){
    $sql  = " SELECT";
    $sql .= "    t_goods.goods_name,";
    $sql .= "    t_goods.public_flg,";
    $sql .= "    t_goods.goods_cname";
    $sql .= " FROM";
    $sql .= "   t_goods";
    $sql .= " WHERE";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= ";";
    $result = Db_Query($conn, $sql );
    //Get����ID�������ʾ���menu������
    Get_Id_Check($result);

    $goods_name = htmlspecialchars(pg_fetch_result($result,0,0));                 //����̾
    $public_flg = pg_fetch_result($result, 0,1);                                  //�����ե饰
    $goods_cname = htmlspecialchars(pg_fetch_result($result,0,2));                //ά��
}else{
    header("location: ../top.php");
}

/****************************/
//����̾�����
/****************************/
$sql  = " SELECT";
$sql .= "    t_goods.goods_name,";
$sql .= "    t_goods.goods_cname,";
$sql .= "    t_goods.public_flg";
$sql .= " FROM";
$sql .= "   t_goods";
$sql .= " WHERE";
$sql .= "   goods_id = $get_goods_id";
$sql .= "   AND\n";
$sql .= "   compose_flg = 'f'\n";
$sql .= "   AND\n";
$sql .= "   no_change_flg = 'f'\n";
$sql .= ";"; 
$result = Db_Query($conn, $sql );
Get_ID_Check($result);
$goods_name = htmlspecialchars(pg_fetch_result($result,0,0));                 //����̾
$goods_cname = htmlspecialchars(pg_fetch_result($result,0,1));

/****************************/
//��������Ƚ��
/****************************/
$public_flg = pg_fetch_result($result,0,2);
if($public_flg == "t"){
    $head_flg = true;
}else{
    $head_flg = false;
}
///////////////////////////////��������////////////////////////////////////////

if(isset($_POST["f_page1"])){
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 100 - 100;
}else{
    $offset = 0;
}

//�������ʤξ��
if($head_flg == true){
    $sql  = "SELECT\n";
    $sql .= "   to_char(t_rprice.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
    $sql .= "   t_rank.rank_name,\n";
    $sql .= "   t_rprice.price,\n";
    $sql .= "   t_rprice.rprice,\n";
    $sql .= "   t_rprice.staff_name\n";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rank\n";
    $sql .= "    ON t_price.rank_cd = t_rank.rank_cd\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rprice\n";
    $sql .= "    ON t_price.price_id = t_rprice.price_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_id = $get_goods_id\n";
    $sql .= "   AND\n";
    $sql .= "   (t_price.rank_cd = '2'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '3'\n";
    $sql .= "    )\n";
    $sql .= "   AND\n";
    //$sql .= "   t_price.shop_gid = $shop_gid\n";
//    $sql .= "   t_price.shop_id = $shop_id\n";
    $sql .= ($group_kind == '2')? "t_price.shop_id IN (".Rank_Sql().") " : "t_price.shop_id = $shop_id ";
    $sql .= "   AND\n";
    $sql .= "   t_rprice.rprice_flg = 't'\n";

//FC���ʤξ��
}else{

    $sql  = " SELECT\n";
    $sql .= "   to_char(t_rprice.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
    $sql .= "   t_rank.rank_name,\n";
    $sql .= "   t_rprice.price,\n";
    $sql .= "   t_rprice.rprice,\n";
    $sql .= "   t_rprice.staff_name\n";
    $sql .= " FROM\n";
    $sql .= "    t_goods\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_price\n";
    $sql .= "    ON t_goods.goods_id = t_price.goods_id\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rank\n";
    $sql .= "    ON t_price.rank_cd = t_rank.rank_cd\n";
    $sql .= "        INNER JOIN\n";
    $sql .= "    t_rprice\n";
    $sql .= "    ON t_price.price_id = t_rprice.price_id\n";
    $sql .= " WHERE\n";
    $sql .= "   t_goods.goods_id = $get_goods_id\n";
    $sql .= "   AND\n";
    $sql .= "   (t_price.rank_cd = '1'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '2'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '3'\n";
    $sql .= "   OR\n";
    $sql .= "   t_price.rank_cd = '4'\n";
    $sql .= "   )\n";
    $sql .= "   AND\n";
    //$sql .= "   t_price.shop_gid = $shop_gid\n";
//    $sql .= "   t_price.shop_id = $shop_id\n";
    $sql .= ($group_kind == 2)? " t_price.shop_id IN (".Rank_Sql().")" : " t_price.shop_id = ".$shop_id."";
    $sql .= "   AND\n";
    $sql .= "   t_rprice.rprice_flg = 't'\n";
    
}

//�����������
$num_sql = $sql.";";

$result = Db_Query($conn, $num_sql);
$total_count = pg_num_rows($result);

$sql .= " ORDER BY t_rprice.price_cday DESC, t_price.rank_cd";
$sql .= " LIMIT 100 OFFSET $offset";
$sql .= ";"; 

$result = Db_Query($conn, $sql);
$show_num = pg_num_rows($result);
for($i = 0; $i < $show_num; $i++){
    $page_data[$i] = pg_fetch_array($result, $i, PGSQL_NUM);
    $page_data[$i][4] = htmlspecialchars($page_data[$i][4]);
}

/****************************/
//�ڡ�������
/****************************/

//ɽ���ϰϻ���
$range = "100";

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);


/////////////////////////////ñ����Ͽ/////////////////////////////////////////

/****************************/
//��Ͽ�������С�ɽ���ѡ�
/****************************/
$sql  = " SELECT\n";
$sql .= "   t_price.r_price,\n";
$sql .= "   t_rprice_n.rprice,\n";
$sql .= "   to_char(t_rprice_n.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
$sql .= "   t_price.rank_cd\n";
$sql .= " FROM\n";
$sql .= "   t_price\n";
$sql .= "   LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "        *\n";
$sql .= "    FROM\n";
$sql .= "        t_rprice\n";
$sql .= "    WHERE\n";
$sql .= "        rprice_flg = 'f'\n";
$sql .= "   ) AS t_rprice_n\n";
$sql .= " ON t_price.price_id = t_rprice_n.price_id\n";
$sql .= " WHERE\n";
$sql .= "   t_price.goods_id = $get_goods_id\n";
$sql .= "   AND\n";

//FC���ʤξ��
if($head_flg === false){
    $sql .= "   (t_price.rank_cd = 1\n";
}else{
    $sql .= "   (t_price.rank_cd = '$rank_cd'\n";
}

$sql .= "   OR\n";
$sql .= "   t_price.rank_cd = 4\n";
$sql .= "   OR\n";
//$sql .= "   t_price.shop_gid = $shop_gid)";
//$sql .= "   t_price.shop_id = $shop_id)";
$sql .= ($group_kind == 2)? " t_price.shop_id IN (".Rank_Sql().") )\n" : " t_price.shop_id = ".$shop_id.")\n";
$sql .= " ORDER BY t_price.rank_cd\n";
$sql .= ";\n";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
if($data_num != 0){
    for($j = 0; $j < $data_num; $j++){
        $price_data[] = pg_fetch_array($result, $j, PGSQL_NUM);
    }
    $warning = "������������������ꤷ����硢ñ���ѹ���¨���Ԥʤ��ޤ���";
}
/****************************/
//�ǡ������å�
/****************************/
for($i = 0; $i < pg_num_rows($result); $i++){

    //�ܵҶ�ʬñ��������Υ���0�˥��å�
    if(strlen($price_data[$i][3]) == 4){
        //��Ф����ǡ�����ɽ������������
        $show_price[0]  = explode(".", $price_data[$i][0]);
        $show_rprice[0] = explode(".", $price_data[$i][1]);
        $show_cday[0]   = explode("-", $price_data[$i][2]);

        //�ե����������ɽ���ǡ����򥻥å�
        $def_data["form_price"][0]["i"]  = $show_price[0][0];
        $def_data["form_price"][0]["d"]  = $show_price[0][1];
        $def_data["form_rprice"][0]["i"] = $show_rprice[0][0];
        $def_data["form_rprice"][0]["d"] = $show_rprice[0][1];
        $def_data["form_cday"][0]["y"]   = $show_cday[0][0];
        $def_data["form_cday"][0]["m"]   = $show_cday[0][1];
        $def_data["form_cday"][0]["d"]   = $show_cday[0][2];
    }else{

        $key = $price_data[$i][3]-1;

        //��Ф����ǡ�����ɽ������������
        $show_price[$key]  = explode(".", $price_data[$i][0]);
        $show_rprice[$key] = explode(".", $price_data[$i][1]);
        $show_cday[$key]   = explode("-", $price_data[$i][2]);

        //�ե����������ɽ���ǡ����򥻥å�

        $def_data["form_price"][$key]["i"]  = $show_price[$key][0];
        $def_data["form_price"][$key]["d"]  = $show_price[$key][1];
        $def_data["form_rprice"][$key]["i"] = $show_rprice[$key][0];
        $def_data["form_rprice"][$key]["d"] = $show_rprice[$key][1];
        $def_data["form_cday"][$key]["y"]   = $show_cday[$key][0];
        $def_data["form_cday"][$key]["m"]   = $show_cday[$key][1];
        $def_data["form_cday"][$key]["d"]   = $show_cday[$key][2];
    }
}

$form->setDefaults($def_data);

/****************************/
//�ե��������
/****************************/
//ñ��
$price_name = array("��������", "�Ķȸ���", "�߸˸���", "ɸ�����");

for($i = 0; $i < 4; $i++){
    //����ñ��
    if(($head_flg == true && ($i == 0 || $i == 3)) || $show_price[$i][0] != null){
        $dprice[$i][] =& $form->createElement(
            "text","i","",'size="11" maxLength="9" 
            style="color : #525552; 
            border : #ffffff 1px
            solid; background-color: #ffffff;
            text-align: right"
            readonly'
        );
        $dprice[$i][] =& $form->createElement(
            "text","d","",'size="2" maxLength="2"
            style="color : #525552; 
            border : #ffffff 1px solid;
             background-color: #ffffff;
            text-align: left"
            readonly'
        );
        $form->addGroup( $dprice[$i], "form_price[$i]", $price_name[$i],".");
    }else{
        $price[$i][] =& $form->createElement(
            "text","i","","size=\"11\" maxLength=\"9\"
            onkeyup=\"Default_focus(this.form,this,'form_price[$i][d]',9)\"
            $g_form_option
            style=\"text-align: right; $g_form_style\""
        );
        $price[$i][] =& $form->createElement("static","","","."    );
        $price[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\"
            $g_form_option
            style=\"text-align: left; $g_form_style\""
        );
        $form->addGroup( $price[$i], "form_price[$i]", $price_name[$i]);
    }    

    //����ñ��
    if(($head_flg == true && $i != 0 && $i != 3) || ($head_flg == false && $show_price[$i][0] != null)){

        $rprice[$i][] =& $form->createElement(
            "text","i","","size=\"11\" maxLength=\"9\"
            onkeyup=\"Default_focus(this.form,this,'form_rprice[$i][d]',9)\"
            $g_form_option
            style=\"text-align: right; $g_form_style\""
        );
        $rprice[$i][] =& $form->createElement("static","","","."    );
        $rprice[$i][] =& $form->createElement(
            "text","d","","size=\"2\" maxLength=\"2\"
            $g_form_option
            style=\"text-align: left; $g_form_style\""
        );
        $form->addGroup( $rprice[$i], "form_rprice[$i]", "");
		//��Ψ
		$form->addElement(
		        "text","form_cost_rate[$i]","",
                "size=\"3\" maxLength=\"3\" 
                style=\"text-align: right; $g_form_style\"
                onkeyup=\"cost_rate('$i','".$price_data[3][0]."');\"
		        $g_form_option"
		        );

    //������
        $date[$i][] =& $form->createElement(
                "text","y","","size=\"4\" maxLength=\"4\" 
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','y','m',1)\"
                onBlur=\"blurForm(this)\"
                style=\"$g_form_style\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","m","","size=\"2\" maxLength=\"2\" 
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','m','d',2)\"
                onBlur=\"blurForm(this)\"
                style=\"$g_form_style\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onBlur=\"blurForm(this)\"
                style=\"$g_form_style\""
            );
        $form->addGroup( $date[$i],"form_cday[$i]","");
    }
}

//�ܥ���
$form->addElement(
    "button","new_button","��Ͽ����",
    "onClick=\"javascript:location.href='2-1-221.php'\"");
$form->addElement(
    "button","change_button","�ѹ�������",
    "onClick=\"javascript:location.href='2-1-220.php'\"");
$form->addElement(
    "button","form_set_price_button","ñ������",
    $g_button_color."
     onClick='javascript:location.href = \"./2-1-222.php?goods_id=$get_goods_id\"'");


/****************************/
//�ܥ��󲡲�����
/****************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){

    /****************************/
    //POST����
    /****************************/
    for($i = 0; $i < 4; $i++){
        $price_i[$i]  = $_POST["form_price"][$i]["i"];
        $price_d[$i]  = $_POST["form_price"][$i]["d"];
        $rprice_i[$i] = $_POST["form_rprice"][$i]["i"];
        $rprice_d[$i] = $_POST["form_rprice"][$i]["d"];
        $cday_y[$i]   = $_POST["form_cday"][$i]["y"];
        $cday_m[$i]   = $_POST["form_cday"][$i]["m"];
        $cday_d[$i]   = $_POST["form_cday"][$i]["d"];
    }

    /***************************/
    //�롼�����
    /***************************/
    for($i = 0; $i < 4; $i++){
        //������ñ��
        //��Ⱦ�ѥ����å�
/*
        if(($price_i[$i] != null && !ereg("^[0-9]+$", $price_i[$i]))
            ||
           ($price_d[$i] != null && (!ereg("^[0-9]+$", $price_d[$i]) && $price_i[$i] != null))
        ){
            $price_err = "����ñ����Ⱦ�ѿ����ΤߤǤ���";  
            $err_flg = true; 
            break;
        }
*/

        //��ɬ�ܥ����å�
        $form->addGroupRule("form_price[$i]", array(
            'i' => array(
                    array("".$price_name[$i]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���", 'required'),
                    array("".$price_name[$i]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���", "regex", "/^[0-9]+$/")
            ),
            'd' => array(
                    array("".$price_name[$i]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���", "regex", "/^[0-9]+$/")
            ),
        ));
/*
        if($price_i[$i] != null && !ereg("^[0-9]+$", $price_i[$i])){
            $price_err = "����ñ����Ⱦ�ѿ����ΤߤǤ���";  
            $err_flg = true; 
            break;
        }
*/
/*
        if($price_d[$i] != null){
            if(!ereg("^[0-9]+$", $price_d[$i]) || $price_i[$i] == null){
                $price_err = "����ñ����Ⱦ�ѿ����ΤߤǤ���";  
                $err_flg = true; 
                break;
            }
        }
*/
        //�����ϥ����å�
        if($price_i[$i] != null){
            $price_input_flg = true;
        }

        //������ñ��
        //��Ⱦ�ѥ����å�
        if(($rprice_i[$i] != null && !ereg("^[0-9]+$", $rprice_i[$i]))
            ||
           ($rprice_d[$i] != null && !ereg("^[0-9]+$", $rprice_d[$i]))
        ){
            $rprice_err = "����ñ����Ⱦ�ѿ����ΤߤǤ���";  
            $err_flg = true;
            break;
        }

        //�����ϥ����å�
        if(($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i]) && $rprice_i[$i] == null){
            $rprice_err = "����ñ�����ѹ��ˡ�����ñ���Ȳ�������ɬ�����ϤǤ���";
            $err_flg = true;
            break;
        }

        //��������
        //��Ⱦ�ѥ����å�
        if(($cday_y[$i] != null && !ereg("^[0-9]+$", $cday_y[$i]))
            ||
          ($cday_m[$i] != null && !ereg("^[0-9]+$", $cday_m[$i]))
            ||
          ($cday_d[$i] != null && !ereg("^[0-9]+$", $cday_m[$i]))
        ){
            $cday_err = "��������Ⱦ�ѿ����ΤߤǤ���";
            $err_flg = true;
            break;
        }

        //�����ϥ����å�
        if($rprice_i[$i] != null && ($cday_y[$i] == null || $cday_m[$i] == null || $cday_d[$i] == null)){
            $cday_err = "����ñ�����ѹ��ˡ�����ñ���Ȳ�������ɬ�����ϤǤ���";
            $err_flg = true;
            break;
        }elseif($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null){
            $input_flg[$i] = true;
        }

        //�����������������å�
        if(!checkdate((int)$cday_m[$i], (int)$cday_d[$i], (int)$cday_y[$i]) && $input_flg[$i] == true){
            $cday_err = "�����������դ������ǤϤ���ޤ���";
            $err_flg = true;
            break;
        }
 
        //��ñ�������ǽ���ե����å�
        if($cday_y[$i]."-".$cday_m[$i]."-".$cday_d[$i] < date("Y-m-d") && $input_flg[$i] == true){
            $cday_err = "�����������դ������ǤϤ���ޤ���";
            $err_flg = true;
            break;
        }

    }
    /****************************/
    //�������
    /****************************/
    if($err_flg != true && $form->validate()){


        Db_query($conn, "BEGIN;");

        /*******************************/
        //����ñ����Ͽ
        /*******************************/
        for($i = 0; $i < 4; $i++){

            $rank_cd = $i+1;        //FC��ʬ������
            //�������ʤǤʤ���ñ��̤��Ͽ������ñ�������Ϥ�����
            if($head_flg == false && $show_price[$i][0] == null && $price_i[$i] != null){
                $insert_sql  = " INSERT INTO t_price (";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    goods_id,";
                $insert_sql .= "    rank_cd,";
                $insert_sql .= "    r_price,";
                //$insert_sql .= "    shop_gid";
                $insert_sql .= "    shop_id";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                $insert_sql .= "    $get_goods_id,";
                $insert_sql .= "    '$rank_cd',";
                $insert_sql .= "    '$price_i[$i].$price_d[$i]',";
                //$insert_sql .= "    $shop_gid";
                $insert_sql .= "    $shop_id";
                $insert_sql .= ");";

                $result = Db_Query($conn, $insert_sql);
                
                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
            }
        }

        /*******************************/
        //����ñ��
        /*******************************/
        for($i = 0; $i < 4; $i++){
//            if($input_flg[$i] == true){
                $rank_cd = $i+1;        //FC��ʬ������

                //ñ������ơ��֥��̤����Υǡ�������
                $delete_sql  = " DELETE FROM ";
                $delete_sql .= "    t_rprice";
                $delete_sql .= " WHERE";
                $delete_sql .= "    price_id = (";
                $delete_sql .= "                SELECT";
                $delete_sql .= "                    price_id";
                $delete_sql .= "                FROM";
                $delete_sql .= "                    t_price";
                $delete_sql .= "                WHERE";
                //$delete_sql .= "                    shop_gid = $shop_gid";
//                $delete_sql .= "                    shop_id = $shop_id";
                $delete_sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    goods_id = $get_goods_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    rank_cd = '$rank_cd'";
                $delete_sql .= "    )";
                $delete_sql .= "    AND";
                $delete_sql .= "    rprice_flg = 'f'";
                $delete_sql .= ";";

                $result = Db_Query($conn, $delete_sql);

                //���Ԥ������ϥ���Хå�
                if($result === false){
                    Db_Query($conn, "ROLLBACK;");
                    exit;
                }
//            }
        }

        //ñ�������������������ξ�硢������ȿ�Ǥ���
        //����������
        $today = date('Y-m-d');

        //ñ������ơ��֥����Ͽ
        for($i = 0; $i < $data_num; $i++){
            //����������
            $cday_m[$i] = str_pad($cday_m[$i], 2, 0, STR_PAD_LEFT);
            $cday_d[$i] = str_pad($cday_d[$i], 2, 0, STR_PAD_LEFT);
            $cday       = $cday_y[$i]."-".$cday_m[$i]."-".$cday_d[$i];
            //������������������Ƚ��
            $cday_flg   = ($today >= $cday && $cday != '-00-00')? true : false;

            if($input_flg[$i] == true){
                $rank_cd = $i+1;        //FC��ʬ������

                //�������ʤǤ��������ñ�������Ϥ�����
                //     OR
                //FC���ʤǤ��������ñ�������Ϥ�����
                if(($head_flg == true && ($i != 0 || $i != 3) && $rprice_i[$i] != null) 
                    ||
                ($head_flg == false && $rprice_i[$i] != null)){
                    $insert_sql  = " INSERT INTO t_rprice (";
                    $insert_sql .= "    price_id,";
                    $insert_sql .= "    price,";
                    $insert_sql .= "    rprice,";
                    $insert_sql .= "    price_cday,";
                    $insert_sql .= "    rprice_flg,";
                    $insert_sql .= "    staff_name";
                    $insert_sql .= " )VALUES(";
                    $insert_sql .= "    (SELECT";
                    $insert_sql .= "        price_id";
                    $insert_sql .= "    FROM";
                    $insert_sql .= "        t_price";
                    $insert_sql .= "    WHERE";
                    //$insert_sql .= "        shop_gid = $shop_gid";
                    //$insert_sql .= "        shop_id = $shop_id";
                    $insert_sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        goods_id = $get_goods_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        rank_cd = '$rank_cd'";
                    $insert_sql .= "    ),";
                    $insert_sql .= "    (SELECT";
                    $insert_sql .= "        r_price";
                    $insert_sql .= "    FROM";
                    $insert_sql .= "        t_price";
                    $insert_sql .= "    WHERE";
                    //$insert_sql .= "        shop_gid = $shop_gid";
//                    $insert_sql .= "        shop_id = $shop_id";
                    $insert_sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        goods_id = $get_goods_id";
                    $insert_sql .= "        AND";
                    $insert_sql .= "        rank_cd = '$rank_cd'";
                    $insert_sql .= "    ),";
                    $insert_sql .= "    $rprice_i[$i].$rprice_d[$i],";
                    if($cday_flg === true){
                        $insert_sql .= "    now(),";
                    }else{
                        $insert_sql .= "    '$cday',";
                    }
                    if($cday_flg === true){    
                        $insert_sql .= "    't',";
                    }else{
                        $insert_sql .= "    'f',";
                    }
                    $insert_sql .= "    '".addslashes($staff_name)."'";
                    $insert_sql .= ");";

                    $result = Db_Query($conn, $insert_sql);
                
                    //���Ԥ������ϥ���Хå�
                    if($result === false){
                        Db_Query($conn, "ROLLBACK;");
                        exit;
                    }
                }

                //ñ���������
                if($cday_flg == true){
                    $sql  = "UPDATE";
                    $sql .= "   t_price ";
                    $sql .= "SET";
                    $sql .= "   r_price = $rprice_i[$i].$rprice_d[$i] ";
                    $sql .= "WHERE";
                    $sql .= "   price_id = (SELECT\n";
                    $sql .= "                   price_id\n";
                    $sql .= "               FROM\n";
                    $sql .= "                   t_price\n";
                    $sql .= "               WHERE\n";
                    $sql .= ($group_kind == 2)? " shop_id IN (".Rank_Sql().")" : " shop_id = $shop_id";
//                    $sql .= "                   shop_id = $shop_id\n";
                    $sql .= "                   AND\n";
                    $sql .= "                   goods_id = $get_goods_id\n";
                    $sql .= "                   AND\n";
                    $sql .= "                   rank_cd = '".$rank_cd."'";
                    $sql .= "               )\n";
                    $sql .= ";\n";

                    $result = Db_Query($conn, $sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK;");
                        exit;
                    }

/*
                    //ñ�����ѹ������ޥ�����ͽ��ǡ�����ȿ�Ǥ��롣
                    //�Ķ�ñ��
                    if($rank_cd == '2'){
                        $result = Mst_Sync_Goods($conn,$get_goods_id,"price","buy");
                        if($result === false){
                            exit;
                        }
                    //ɸ������ξ��
                    }elseif($rank_cd == '4'){
                        $result = Mst_Sync_Goods($conn,$get_goods_id,"price","sale");
                        if($result === false){
                            exit;
                        }
                    }
*/
                }
            }
        }    
        Db_Query($conn, "COMMIT;");
        $freeze_flg = true;
    }
}

if($freeze_flg == true){
    $form->addElement("button","form_entry_button","�ϡ���","onClick=\"location.href='./2-1-221.php'\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick=\"javascript:history.back()\"");
    $form->freeze();

}else{
    //�ܥ���
    $form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#', this)\" $disabled");
    $form->addElement("button","form_back_button","�ᡡ��","onClick='javascript:location.href = \"./2-1-221.php?goods_id=$get_goods_id\"'");
}

/****************************/
//javascript����
/****************************/
$js  = "function cost_rate(num, price){ \n";
$js .= "    //�ե�����̾���\n";
$js .= "    var PI = \"form_rprice\"+\"[\"+num+\"][i]\";\n";
$js .= "    var PD = \"form_rprice\"+\"[\"+num+\"][d]\";\n";
$js .= "    var CR = \"form_cost_rate\"+\"[\"+num+\"]\";\n";

$js .= "    //VALUE \n";
$js .= "    var PR  = eval(price);\n";
$js .= "    var CRV = document.dateForm.elements[CR].value;\n";

$js .= "    //���줾��Υե����ब���Ϥ���Ƥ��ơ������������ξ��\n";
$js .= "    if(CRV != null && isNaN(CRV) == false && CRV != 0){\n";
$js .= "        //�������ʲ��������롣\n";
$js .= "        PR100 = eval(PR*100);\n";
$js .= "        CC = eval(CRV / 100); \n";

$js .= "        CP = eval(eval(PR100) * eval(CRV));\n";
$js .= "        PRICE = eval(CP / 100); \n";
$js .= "        PRICE = Math.floor(PRICE) / 100;\n";
$js .= "        PRICE = String(PRICE);\n";
$js .= "        PRICE_D = PRICE.split(\".\");\n";
$js .= "        if(PRICE_D[1] == undefined){\n";
$js .= "            PRICE_D[1] = \"00\"\n";
$js .= "        }\n"; 

$js .= "        document.dateForm.elements[PI].value = PRICE_D[0];\n";
$js .= "        document.dateForm.elements[PD].value = PRICE_D[1];\n";

$js .= "    }else if(CRV == ''){\n";
$js .= "        document.dateForm.elements[PI].value = \"\";\n";
$js .= "        document.dateForm.elements[PD].value = \"\";\n";
$js .= "    }else if(CRV == '0'){\n";
$js .= "        document.dateForm.elements[PI].value = \"0\";\n";
$js .= "        document.dateForm.elements[PD].value = \"00\"; \n";
$js .= "    }else if(isNaN(CRV) == true){\n";
$js .= "        document.dateForm.elements[PI].value = \"\";\n";
$js .= "        document.dateForm.elements[PD].value = \"\";\n";
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
/****************************/$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
if($get_goods_id != null){
    $page_title .= "��".$form->_elements[$form->_elementIndex[form_set_price_button]]->toHtml();
}$page_header = Create_Header($page_title);

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
	'html_page'     => "$html_page",
	'html_page2'    => "$html_page2",
    'goods_name'    => "$goods_name",
    'goods_cname'   => "$goods_cname",
    'price_err'     => "$price_err",
    'rprice_err'    => "$rprice_err",
    'cday_err'      => "$cday_err",
    'js'            => "$js",
    'warning'       => "$warning",
));

$smarty->assign('page_data', $page_data);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
