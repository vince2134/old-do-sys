<?php
/********************************/
//�ѹ�����
//    ��ñ��������˥����å�̾����Ͽ
//
//    (2006/07/06) shop_gid��ʤ�����(kaji)
//    (2006/10/23) (kaji)
/*********************************/


/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007-01-23     �����ѹ�����watanabe-k���ܥ���ο����ѹ�
 *  2007-01-30     �����ѹ�����watanabe-k����󥿥븶�����ɲ�
 *  2007-04-11     �����ѹ�����watanabe-k���ܵҶ�ʬñ����ɬ�ܤȤ��롣
 *  2007-04-11     �����ѹ�����  morita-d���֣ӣӡסֻ�����פξ���ñ����ɬ�ܤˤ��ʤ�(�ϡ��ɥ����ǥ��󥰤ˤ�����)
 *  2007-08-25     �����ѹ�����watanabe-k  ����Ʊ����Ϣ�ν�������
 *  2009/10/13                 hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *
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
// ���ϡ��ѹ�����̵����å�����
$auth_r_msg = ($auth[0] == "r") ? $auth[3] : null;
// �ܥ���Disabled
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ�����
/****************************/
//$shop_gid = $_SESSION["shop_gid"];
$shop_id = $_SESSION["client_id"];
$staff_id = $_SESSION["staff_id"];
$get_goods_id = $_GET["goods_id"];                          //GET��������ID

/* GET����ID�������������å� */
$where = " public_flg = 't' AND compose_flg = 'f' ";
if ($_GET["goods_id"] != null && Get_Id_Check_Db($conn, $_GET["goods_id"], "goods_id", "t_goods", "num", $where) != true){
    header("Location: ../top.php");
}

/****************************/
//�����å�
/****************************/
$sql  = "SELECT";
$sql .= "   staff_name";
$sql .= " FROM";
$sql .= "   t_staff";
$sql .= " WHERE";
$sql .= "   staff_id = $staff_id";
$sql .= ";";

$result = Db_Query($conn, $sql);
$staff_name = pg_fetch_result($result, 0, 0);

/****************************/
//����̾�����
/****************************/
if($get_goods_id != null){
    $sql  = " SELECT";
    $sql .= "    t_goods.goods_name,";
    $sql .= "    t_goods.goods_cname,";
    $sql .= "    rental_flg ";
    $sql .= " FROM";
    $sql .= "   t_goods";
    $sql .= " WHERE";
    $sql .= "   goods_id = $get_goods_id";
    $sql .= "   AND";
    $sql .= "   public_flg = 't'";
    $sql .= "   AND\n";
    $sql .= "   compose_flg = 'f'\n";
    $sql .= "   AND\n";
    $sql .= "   shop_id = $shop_id\n";
    $sql .= "   AND\n";
    $sql .= "   no_change_flg = 'f'\n";
    $sql .= ";"; 

    $result = Db_Query($conn, $sql);
    Get_Id_Check($result);

    $goods_name  = htmlspecialchars(pg_fetch_result($result,0,0));
    $goods_cname = htmlspecialchars(pg_fetch_result($result,0,1));
    $rental_flg  = pg_fetch_result($result, 0,2);
}else{
    header("Location: ../top.php");
}
////////////////////////////////��������///////////////////////////////////////
if(isset($_POST["f_page1"])){
    $page_count  = $_POST["f_page1"];
    $offset = $page_count * 10 - 10;
}else{
    $offset = 0;
}

$show_sql  = " SELECT";
$show_sql .= "   to_char(t_rprice.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
$show_sql .= "   t_rank.rank_name,";
$show_sql .= "   t_rprice.price,";
$show_sql .= "   t_rprice.rprice,";
$show_sql .= "   t_rprice.staff_name";
$show_sql .= " FROM";
$show_sql .= "   t_rank,";
$show_sql .= "   t_price,";
$show_sql .= "   t_rprice";
$show_sql .= " WHERE";
$show_sql .= "   t_price.price_id = t_rprice.price_id";
$show_sql .= "   AND";
$show_sql .= "   t_price.rank_cd = t_rank.rank_cd";
$show_sql .= "   AND";
$show_sql .= "   t_rprice.rprice_flg = 't'";
$show_sql .= "   AND";
$show_sql .= "   t_price.goods_id = $get_goods_id";
$show_sql .= "   AND";
$show_sql .= "   t_price.rank_cd != '2'";
$show_sql .= "   AND";
$show_sql .= "   t_price.rank_cd != '3'";

//�����������
$num_sql = $show_sql.";";

$num_result = Db_Query($conn, $num_sql);
$total_count = pg_num_rows($num_result);

$show_sql .= " ORDER BY t_rprice.price_cday DESC ,t_rank.rank_cd LIMIT 100 OFFSET $offset";
$show_sql .= ";";

$show_result = Db_Query($conn, $show_sql);
$show_num = pg_num_rows($show_result);
for($i = 0; $i < $show_num; $i++){
    $show_data[$i] = pg_fetch_array($show_result, $i, PGSQL_NUM);

    //�����å�̾�򥵥˥�����
    $show_data[$i][4] = htmlspecialchars($show_data[$i][4]);

}

///////////////////////////////ñ����Ͽ/////////////////////////////////////

/****************************/
//Get�����å�
/****************************/
Get_Id_Check3($_GET[goods_id]);

//���ʥޥ����Ǿ��ʤȤ��ư����Ƥ��뤫����
$sql  = "SELECT \n";
$sql .= "   goods_id \n";
$sql .= "FROM \n";
$sql .= "   t_goods \n";
$sql .= "WHERE \n";
$sql .= "   t_goods.goods_id = $get_goods_id\n";
$sql .= "   AND\n";
$sql .= "   compose_flg = 'f'\n";
$sql .= "   AND\n";
$sql .= "   shop_id = $shop_id\n";
$sql .= "   AND\n";
$sql .= "   no_change_flg = 'f'\n";
$sql .= ";\n";   

$result = Db_Query($conn, $sql);
Get_Id_Check($result);

/****************************/
//��Ͽ�ǡ��������
/****************************/
$sql  = "SELECT\n";
$sql .= "    t_rank_price.r_price,\n";
$sql .= "    t_rank_price.rprice,\n";
$sql .= "    to_char(t_rank_price.price_cday, 'yyyy-mm-dd') AS price_cday,\n";
$sql .= "    t_rank_data.rank_name,\n";
$sql .= "    t_rank_data.rank_cd\n";
$sql .= " FROM\n";
$sql .= "   (SELECT\n";
$sql .= "        rank_cd,\n";
$sql .= "        rank_name,\n";
$sql .= "        disp_flg\n";
$sql .= "    FROM\n";
$sql .= "        t_rank\n";
$sql .= "    WHERE\n";
$sql .= "        rank_cd != '2'\n";
$sql .= "        AND\n";
$sql .= "        rank_cd != '3'\n";
$sql .= "        AND\n";
$sql .= "        rank_cd != '0000'\n";
$sql .= "   ) AS t_rank_data\n";
$sql .= "   LEFT JOIN\n";
$sql .= "   (SELECT\n";
$sql .= "       t_price.rank_cd,\n";
$sql .= "       t_price.r_price,\n";
$sql .= "       t_rprice_n.rprice,\n";
$sql .= "       t_rprice_n.price_cday\n";
$sql .= "   FROM t_rank,\n";
$sql .= "       t_price\n";
$sql .= "       LEFT JOIN\n";
$sql .= "       (SELECT * FROM t_rprice WHERE rprice_flg = 'f' ) AS t_rprice_n\n";
$sql .= "        ON t_price.price_id = t_rprice_n.price_id\n";
$sql .= "   WHERE\n";
$sql .= "       t_price.shop_id = $shop_id\n";
$sql .= "       AND\n";
$sql .= "       t_price.goods_id = $get_goods_id\n";
$sql .= "       AND\n";
$sql .= "    t_price.rank_cd = t_rank.rank_cd) AS t_rank_price\n";
$sql .= " ON t_rank_data.rank_cd = t_rank_price.rank_cd\n";
$sql .= " ORDER BY t_rank_data.disp_flg, t_rank_data.rank_cd\n";
$sql .= " ; \n";

$result = Db_Query($conn, $sql);
$data_num = pg_num_rows($result);
if( $data_num!= 0){
    for($j = 0; $j < $data_num; $j++){
        $price_data[] = pg_fetch_array($result, $j);
    }
}

/******************************/
//�ǡ������å�
/******************************/
for($i = 0; $i < $data_num; $i++){
    //����ñ��
    if($price_data[$i][0] == null){

        //����ñ����ɸ��ñ�����ܵҶ�ʬñ���ξ��
        if(($i == 0 || $i == 1 || $i > 3)
        //�⤷���ϡ�
        ||
        //��󥿥�ñ���������ϥ�󥿥뾦�ʤξ��Τ�ɬ��
        ($rental_flg == 't' && ($i == 2 || $i == 3))){

            //���ϡ��ɥ����ǥ���
            //�֣ӣӡסֻ�����פξ���ñ����ɬ�ܤˤ��ʤ�
            //[�ü�]��ɬ�ܤȤ��ʤ��褦�˽���
            if($price_data[$i][4] != "0005" && $price_data[$i][4] != "0100" && $price_data[$i][4] != "0055"){
                $required_flg[$i] = true;
            }
        }
    }

    $e_price[$i]    = explode(".", $price_data[$i][0]);
    $e_rprice[$i]   = explode(".", $price_data[$i][1]); 
    $e_cday[$i]     = explode("-", $price_data[$i][2]);

    $def_data["form_price"][$i]["i"]    = $e_price[$i][0];
    $def_data["form_price"][$i]["d"]    = $e_price[$i][1];
    $def_data["form_rprice"][$i]["i"]   = $e_rprice[$i][0];
    $def_data["form_rprice"][$i]["d"]   = $e_rprice[$i][1];
    $def_data["form_cost_rate"][$i]     = $price_data[$i]["cost_rate"];
    $def_data["form_cday"][$i]["y"]     = $e_cday[$i][0];
    $def_data["form_cday"][$i]["m"]     = $e_cday[$i][1];
    $def_data["form_cday"][$i]["d"]     = $e_cday[$i][2];
}

$form->setDefaults($def_data);

/******************************/
//��������Ƚ��
/******************************/
if($price_data[0][0] == null){
    $new_flg = true;
}else{
    $new_flg = false;

    $warning = "������������������ꤷ����硢ñ���ѹ���¨���Ԥʤ��ޤ���";
}
/******************************/
//�ե��������
/******************************/
//ñ��
for($i = 0; $i < $data_num; $i++){

    //����ñ��
    if($price_data[$i][0] == null){
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
        $form->addGroup( $price[$i], "form_price[$i]", $price_data[$i][3]);
    }else{
        $dprice[$i][] =& $form->createElement(
            "static","i","",""
        );      
        $dprice[$i][] =& $form->createElement(
            "static","d","",""
        );
        $form->addGroup( $dprice[$i], "form_price[$i]", $price_data[$i][3],".");
            //����ñ��
            $rprice[$i][] =& $form->createElement(
                "text","i","","size=\"11\" maxLength=\"9\"
                onkeyup=\"Default_focus(this.form,this,'form_rprice[$i][d]',9);\"
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
                "text","form_cost_rate[$i]","","size=\"3\" maxLength=\"3\" 
                style=\"text-align: right ;$g_form_style\"
                onkeyup=\"cost_rate('$i','".$price_data[1][0]."');\" 
                $g_form_option"
                );

        //������
        $date[$i][] =& $form->createElement(
                "text","y","","size=\"4\" maxLength=\"4\"
                style=\"$g_form_style\"
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','y','m',1)\" 
                onBlur=\"blurForm(this)\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","m","","size=\"2\" maxLength=\"2\" 
                style=\"$g_form_style\"
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onkeyup=\"move_text(this.form,'form_cday[$i]','m','d',2)\"
                onBlur=\"blurForm(this)\""
            );
        $date[$i][] =& $form->createElement(
                "static","","","-"
            );
        $date[$i][] =& $form->createElement(
                "text","d","","size=\"2\" maxLength=\"2\" 
                style=\"$g_form_style\"
                onFocus=\"Comp_Form_NextToday(this,this.form,'form_cday[$i]','y','m','d')\"
                onBlur=\"blurForm(this)\""
            );
        $form->addGroup( $date[$i],"form_cday[$i]","");
    }
}

$form->addElement(
    "button","new_button","��Ͽ����",
    "onClick=\"javascript:location.href='1-1-221.php'\""
);
$form->addElement(
    "button","change_button","�ѹ�������",
    "onClick=\"javascript:location.href='1-1-220.php'\"");
$form->addElement(
    "button","form_set_price_button","ñ������",
    $g_button_color." 
    onClick='javascript:location.href = \"./1-1-222.php?goods_id=$get_goods_id\"'"
);

//����ñ���ѥ��顼�ե�����
$form->addElement("text", "rprice_err","");

//�������ѥ��顼�ե�����
$form->addElement("text", "cday_err","");

//����ñ����������ɬ�ܥ����å����顼�ե�����
$form->addElement("text", "duble_err","");

/*******************************/
//�ܥ��󲡲�����
/*******************************/
if($_POST["form_entry_button"] == "�С�Ͽ"){
    for($i = 0; $i < $data_num; $i++){

        //����ñ��
        $price_i[$i] = $_POST["form_price"][$i]["i"];
        $price_d[$i] = $_POST["form_price"][$i]["d"];
        //����ñ��
        $rprice_i[$i] = $_POST["form_rprice"][$i]["i"];
        $rprice_d[$i] = $_POST["form_rprice"][$i]["d"];
        //�ݤ�Ψ
        $cost_rate[$i] = $_POST["form_cost_rate"][$i]; 
        //������
        $cday_y[$i] = $_POST["form_cday"][$i]["y"];
        $cday_m[$i] = $_POST["form_cday"][$i]["m"];
        $cday_d[$i] = $_POST["form_cday"][$i]["d"];


        //����ñ��
        if($price_data[$i][0] == null){

            //����ñ����ɸ��ñ�����ܵҶ�ʬñ���ξ��
            if(($i == 0 || $i == 1 || $i > 3)
            //�⤷���ϡ�
            ||
            //��󥿥�ñ���������ϥ�󥿥뾦�ʤξ��Τ�ɬ��
            ($rental_flg == 't' && ($i == 2 || $i == 3))){
                //��ɬ�ܥ����å�

                //���ϡ��ɥ����ǥ���
                //�֣ӣӡסֻ�����פξ���ñ����ɬ�ܤˤ��ʤ�
                if($price_data[$i][4] != "0005" && $price_data[$i][4] != "0100" && $price_data[$i][4] != "0055"){

                    $form->addGroupRule("form_price[$i]", array(
                        'i' => array(
                            array("".$price_data[$i][3]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���", 'required')
                        ),      
                    ));
                }
            }
        }

            //�����������å�
            $form->addGroupRule("form_price[$i]", array(
                'i' => array(
                        array("".$price_data[$i][3]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���", 'regex', "/^[0-9]+$/")
                ),      
                'd' => array(
                        array("".$price_data[$i][3]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���", 'regex', "/^[0-9]+$/")
                ),      
            ));
//            $form->addGroupRule("form_price[$i]",$price_data[$i][3]."�θ���ñ����Ⱦ�ѿ����Τ�ɬ�����ϤǤ���","regex", "/^[0-9]+$/");

            //������ñ��
            //�����������å�
            if(($rprice_i[$i] != null && !ereg("^[0-9]+$", $rprice_i[$i]))
                || 
            ($rprice_d[$i] != null && !ereg("^[0-9]+$", $rprice_d[$i]))
            ){
                $form->setElementError("rprice_err","����ñ����Ⱦ�ѿ����ΤߤǤ���");
            }

            //��ñ��������
            //�����������å�
            if(($cday_y[$i] != null  && !ereg("^[0-9]+$", $cday_y[$i]))
                || 
            ($cday_m[$i] != null && !ereg("^[0-9]+$", $cday_m[$i]))
                || 
            ($cday_d[$i] != null && !ereg("^[0-9]+$", $cday_d[$i]))
            ){
                $form->setElementError("cday_err","��������Ⱦ�ѿ����ΤߤǤ���");
            }

            //��ɬ�ܥ����å�
            if(
            (($rprice_i[$i] != null)
                && 
            ($cday_y[$i] == null || $cday_m[$i] == null || $cday_d[$i] == null))
                ||
            (($rprice_i[$i] == null)
                && 
            ($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null))
            ){
                $form->setElementError("duble_err","����ñ�����ѹ��ˡ�����ñ���Ȳ�������ɬ�����ϤǤ���");
            }
    
            //�����������������å�
            if(($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null)
                && 
            (!checkdate((int)$cday_m[$i], (int)$cday_d[$i], (int)$cday_y[$i]))
            ){
                $form->setElementError("cday_err","��������Ⱦ�ѿ����ΤߤǤ���");
            }

            //�����ե����å��ʲ������դ�error��
            if(($cday_y[$i] != null || $cday_m[$i] != null || $cday_d[$i] != null)
            &&
            ($cday_y[$i]."-".$cday_m[$i]."-".$cday_d[$i] < date("Y-m-d"))
            ){
                $form->setElementError("cday_err","��������Ⱦ�ѿ����ΤߤǤ���");
            } 
    }

    if($form->validate() && $err_flg != true){
    
        /*****************************/
        //��Ͽ��������
        /*****************************/
        Db_Query($conn, "BEGIN");

        /*****************************/
        //����ñ����Ͽ
        /*****************************/
        //ñ���ޥ�������Ͽ���ʤ����
        for($i = 0; $i < $data_num; $i++){
            if($price_i[$i] != null){
                //��Ͽ��̵ͭ���ǧ
                $sql  = "SELECT \n";
                $sql .= "   COUNT(price_id) \n";
                $sql .= "FROM \n";
                $sql .= "   t_price \n";
                $sql .= "WHERE \n";
                $sql .= "   shop_id = $shop_id \n";
                $sql .= "   AND \n";
                $sql .= "   goods_id = $get_goods_id \n";
                $sql .= "   AND \n";
                $sql .= "   rank_cd = '".$price_data[$i][4]."' ";
                $sql .= ";";
                $result = Db_Query($conn, $sql);
                $add_num = pg_fetch_result($result, 0,0);

                //������Ͽ�Ѥߤξ��
                if($add_num > 0){
                    continue;
                }

                $insert_sql  = " INSERT INTO t_price(";
                $insert_sql .= "    price_id,";
                $insert_sql .= "    goods_id,";
                $insert_sql .= "    rank_cd,";
                $insert_sql .= "    r_price,";
                //$insert_sql .= "    shop_gid";
                $insert_sql .= "    shop_id";
                $insert_sql .= " )VALUES(";
                $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                $insert_sql .= "    $get_goods_id,";
                $insert_sql .= "    '".$price_data[$i][4]."',";
                $insert_sql .= "    $price_i[$i].$price_d[$i],";
                //$insert_sql .= "    $shop_gid";
                $insert_sql .= "    $shop_id";
                $insert_sql .= ");";

                $result = Db_Query($conn, $insert_sql);

                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                }
            }
        }

        //���Ϥ��줿�ǡ���ʬ�롼��
        for($i = 0; $i < $data_num; $i++){
            if($price_i[$i] != null && $i > 2){
                /*
                $sql  = "SELECT";
                $sql .= "   shop_gid";
                $sql .= " FROM";
                $sql .= "   t_shop_gr";
                $sql .= " WHERE";
                $sql .= "   rank_cd = '".$price_data[$i][4]."'";
                $sql .= ";";
                */
                //�ܵҶ�ʬ�����פ�����FC��client_id�����
                $sql  = "SELECT \n";
                $sql .= "    t_client.client_id \n";
                $sql .= "FROM \n";
                $sql .= "    t_rank \n";
                $sql .= "    INNER JOIN t_client ON t_rank.rank_cd = t_client.rank_cd \n";
                $sql .= "WHERE \n";
                $sql .= "    t_client.client_div = '3' \n";
                $sql .= "    AND \n";
                $sql .= "    t_client.rank_cd = '".$price_data[$i][4]."'\n";
                $sql .= ";";

                $res = Db_Query($conn, $sql);
                $num = pg_num_rows($res);

                $sql  = "SELECT";
                $sql .= "   group_kind";
                $sql .= " FROM";
                $sql .= "   t_rank";
                $sql .= " WHERE";
                $sql .= "   rank_cd = '".$price_data[$i][4]."'";
                $sql .= ";";

                $result = Db_Query($conn, $sql);
                $group_kind = pg_fetch_result($result , 0);

                //���롼�׼��̤����
                if($group_kind == '2'){
                    $num = 1;
                }

                //���롼��ʬ�롼��
                for($k = 0; $k < $num; $k++){
                    $rank_shop_id = pg_fetch_result($res,$k,0);

                    /*****************************/
                    //�Ķȡ��߸�ñ����Ͽ
                    /*****************************/
                    for($j = 2; $j < 4; $j++){
                        $insert_sql  = "INSERT INTO t_price (";
                        $insert_sql .= "    price_id,";
                        $insert_sql .= "    goods_id,";
                        $insert_sql .= "    rank_cd,";
                        $insert_sql .= "    r_price,";
                        //$insert_sql .= "    shop_gid";
                        $insert_sql .= "    shop_id";
                        $insert_sql .= ")VALUES(";
                        $insert_sql .= "    (SELECT COALESCE(MAX(price_id), 0)+1 FROM t_price),";
                        $insert_sql .= "    $get_goods_id,";
                        $insert_sql .= "    '$j',";
                        $insert_sql .= "    (SELECT";
                        $insert_sql .= "        r_price";
                        $insert_sql .= "     FROM";
                        $insert_sql .= "        t_price";
                        $insert_sql .= "     WHERE";
                        $insert_sql .= "        rank_cd = '".$price_data[$i][4]."'";
                        $insert_sql .= "        AND";
                        //$insert_sql .= "        shop_gid = $shop_gid";
                        $insert_sql .= "        shop_id = $shop_id";
                        $insert_sql .= "        AND";
                        $insert_sql .= "        goods_id = $get_goods_id";
                        $insert_sql .= "    ),";
                        $insert_sql .= "    $rank_shop_id";
                        $insert_sql .= ");";

                        $result = Db_Query($conn, $insert_sql);
                        if($result === false){
                            Db_Query($conn, "ROLLBACK;");
                            exit;
                        }
                    } 
                    //����å��̾��ʾ���ơ��֥�
                    $insert_sql  = "INSERT INTO t_goods_info (";
                    $insert_sql .= "    goods_id,";
                    $insert_sql .= "    compose_flg,";
                    $insert_sql .= "    head_fc_flg,";
                    //$insert_sql .= "    shop_gid";
                    #2009-10-13 hashimoto-y
                    $insert_sql .= "    stock_manage,";
                    
                    $insert_sql .= "    shop_id";
                    $insert_sql .= ")VALUES(";
                    $insert_sql .= "    $get_goods_id,";
                    $insert_sql .= "    'f',";
                    $insert_sql .= "    'f',";
                    $insert_sql .= "    (SELECT stock_manage FROM t_goods_info WHERE goods_id = $get_goods_id AND shop_id = $shop_id),";
                    $insert_sql .= "    $rank_shop_id";
                    $insert_sql .= ");";

                    $result = Db_Query($conn, $insert_sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK");
                        exit;
                    }
                }
            }
        }

        /*******************************/
        //ñ������
        /*******************************/
        if($new_flg === false){
            for($i = 0; $i < $data_num; $i++){

                //ñ������ơ��֥����̤����Υǡ�������
                $delete_sql  = "DELETE FROM";
                $delete_sql .= "     t_rprice";
                $delete_sql .= " WHERE";
                $delete_sql .= "    price_id = (";
                $delete_sql .= "                SELECT";
                $delete_sql .= "                    price_id";
                $delete_sql .= "                FROM";
                $delete_sql .= "                    t_price";
                $delete_sql .= "                WHERE";
                //$delete_sql .= "                    shop_gid = $shop_gid";
                $delete_sql .= "                    shop_id = $shop_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    goods_id = $get_goods_id";
                $delete_sql .= "                    AND";
                $delete_sql .= "                    rank_cd = '".$price_data[$i][4]."'";
                $delete_sql .= "    )";
                $delete_sql .= "    AND";
                $delete_sql .= "    rprice_flg = 'f'";
                $delete_sql .= ";";

                $result = Db_Query($conn, $delete_sql);
                if($result === false){
                    Db_Query($conn, "ROLLBACK");
                    exit;
                }
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
                $cday_flg   = ($today >= $cday && $cday != "-00-00")? true : false;
                if($rprice_i[$i] != null){
                    
                    //ñ������ơ��֥����Ͽ
                    $insert_sql  = " INSERT INTO t_rprice (\n";
                    $insert_sql .= "    price_id,\n";
                    $insert_sql .= "    price,\n";
                    $insert_sql .= "    rprice,\n";
                    $insert_sql .= "    price_cday,\n";
                    $insert_sql .= "    rprice_flg,\n";
                    $insert_sql .= "    staff_name\n";
                    $insert_sql .= " )VALUES(\n";
                    $insert_sql .= "    (SELECT\n";
                    $insert_sql .= "        price_id\n";
                    $insert_sql .= "    FROM\n";
                    $insert_sql .= "        t_price\n";
                    $insert_sql .= "    WHERE\n";
                    //$insert_sql .= "        shop_gid = $shop_gid";
                    $insert_sql .= "        shop_id = $shop_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        goods_id = $get_goods_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        rank_cd = '".$price_data[$i][4]."'\n";
                    $insert_sql .= "    ),\n";
                    $insert_sql .= "    (SELECT\n";
                    $insert_sql .= "        r_price\n";
                    $insert_sql .= "    FROM\n";
                    $insert_sql .= "        t_price\n";   
                    $insert_sql .= "    WHERE\n";
                    //$insert_sql .= "        shop_gid = $shop_gid";
                    $insert_sql .= "        shop_id = $shop_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        goods_id = $get_goods_id\n";
                    $insert_sql .= "        AND\n";
                    $insert_sql .= "        rank_cd = '".$price_data[$i][4]."'\n";
                    $insert_sql .= "    ),\n";
                    $insert_sql .= "    $rprice_i[$i].$rprice_d[$i],\n";
                    if($cday_flg == true){
                        $insert_sql .= "now(),\n";
                    }else{
                        $insert_sql .= "    '$cday',\n";
                    }

                    //�������˺������������դ���Ͽ���줿���
                    if($cday_flg == true){
                        $insert_sql .= "    't',\n";
                    //�������������ʹߤξ��
                    }else{
                        $insert_sql .= "    'f',\n";
                    }

                    $insert_sql .= "    '".addslashes($staff_name)."'\n";
                    $insert_sql .= ");\n";

                    $result = Db_Query($conn, $insert_sql);
                    if($result === false){
                        Db_Query($conn, "ROLLBACK");
                        exit;
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
                        $sql .= "                   shop_id = $shop_id\n";
                        $sql .= "                   AND\n";
                        $sql .= "                   goods_id = $get_goods_id\n";
                        $sql .= "                   AND\n";
                        $sql .= "                   rank_cd = '".$price_data[$i][4]."'";
                        $sql .= "               )\n";
                        $sql .= ";\n";
                    
                        $result = Db_Query($conn, $sql);
                        if($result === false){
                            Db_Query($conn, "ROLLBACK;");
                            exit;
                        }

/*
                        //ñ�����ѹ������ޥ���������ǡ�����ȿ��
                        //ɸ��ñ���ξ��Τ�
                        if($price_data[$i][4] === '4'){
                            $result = Mst_Sync_Goods($conn,$get_goods_id,"price", "sale");
                            if($result === false){
                                exit;
                            }
                        }
*/
                    }
                } 
            }
        }
        Db_Query($conn, "COMMIT;");
        $freeze_flg = true;
    }
}

if($freeze_flg == true){
    $form->addElement("button","form_entry_button","�ϡ���","onClick=\"location.href='./1-1-221.php'\"");
    $form->addElement("button","form_back_button","�ᡡ��","onClick='javascript:location.href=\"./1-1-222.php?goods_id=$get_goods_id\"'");
    $form->freeze();
}else{
    //�ܥ���
    $form->addElement("submit","form_entry_button","�С�Ͽ","onClick=\"javascript:return Dialogue('��Ͽ���ޤ���','#')\" $disabled");
    $form->addElement("button","form_back_button","�ᡡ��","onClick='javascript:location.href = \"./1-1-221.php?goods_id=$get_goods_id\"'");
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
/****************************/
$page_menu = Create_Menu_h('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[new_button]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[change_button]]->toHtml();
if($get_goods_id != null){
    $page_title .= "��".$form->_elements[$form->_elementIndex[form_set_price_button]]->toHtml();
}
$page_header = Create_Header($page_title);

/****************************/
//�ڡ�������
/****************************/
//ɽ���ϰϻ���
$range = "100";

//�ڡ����������
$page_count = $_POST["f_page1"];

$html_page = Html_Page($total_count,$page_count,1,$range);
$html_page2 = Html_Page($total_count,$page_count,2,$range);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
    'html_header'       => "$html_header",
    'page_menu'         => "$page_menu",
    'page_header'       => "$page_header",
    'html_footer'       => "$html_footer",
    'html_page'         => "$html_page",
    'html_page2'        => "$html_page2",
    'goods_name'        => "$goods_name",
    'goods_cname'       => "$goods_cname",
    'new_flg'           => "$new_flg",
    'js'                => "$js",
    'auth_r_msg'        => "$auth_r_msg",
    'warning'           => "$warning",
    'rental_flg'        => "$rental_flg"
));
$smarty->assign('input_flg', $input_flg);
$smarty->assign('show_data', $show_data);
$smarty->assign("required_flg", $required_flg);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
