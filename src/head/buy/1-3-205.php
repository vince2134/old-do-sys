<?php
/****************************/
// �ѹ�����
//   �ơ��֥��¸�ߤ��Ƥ��ʤ������򻲾Ȥ��Ƥ��뤿�ᥨ�顼���ǤƤ���Τǡ�����
/***************************/

/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/11��06-074��������watanabe-k��GET�����å��ɲ�
 *   2007/03/08  ����¾25      kajioka-h   ��ư�ǵ����������ʤ顢�����������Ƥ��ʤ��Ƥ�����ɽ������褦���ѹ�
 *   2009/09/18                aoyama-n    �Ͱ����ʵڤӼ����ʬ���Ͱ������ʤξ����ֻ���ɽ��
 *   2009/09/18                aoyama-n    ���ʤΥ����Ƚ��line�˽���
 *
 */

$page_title = "�����Ȳ�";

// �Ķ�����ե����� env setting file
require_once("ENV_local.php");

// HTML_QuickForm����� create
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

// DB��³ connect db
$db_con = Db_Connect();

// ���¥����å� auth check
$auth   = Auth_Check($db_con);

/****************************/
// �����ѿ����� acquire external variable
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
$buy_id       = $_GET["buy_id"];             // ����ID purchase Id
Get_Id_Check3($buy_id);
Get_Id_Check2($buy_id);
$input_flg    = $_GET["input_flg"];          // ���ܸ����̥ե饰 identification flag where the page transitioned from 
$buy_div      = $_GET["buy_div"];           //�������ʬ purchase client classification


/****************************/
// ������� component definition
/****************************/
// ������ purchase arrival date
$text="";
$text[] =& $form->createElement("static", "y", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "m", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "d", "", "");
$form->addGroup($text, "form_arrival_day", "");

// ������ purchase date
$text="";
$text[] =& $form->createElement("static", "y", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "m", "", "");
$text[] =& $form->createElement("static", "", "", "-");
$text[] =& $form->createElement("static", "d", "", "");
$form->addGroup($text, "form_buy_day", "");

// ȯ���ֹ� purchase order number
$form->addElement("static", "form_ord_no", "", "");
// ��ɼ�ֹ� slip number
$form->addElement("static", "form_buy_no", "", "");

// ������̾ purchase client nmae
$form_client[] =& $form->createElement("static", "cd1", "", "");
$form_client[] =& $form->createElement("static", "", "", " ");
$form_client[] =& $form->createElement("static", "name", "", "");
$form->addGroup($form_client, "form_client", "");

// ľ����̾ direct destination name
$form->addElement("static", "form_direct_name", "", "");
// �����Ҹ� purchase warehose
$form->addElement("static", "form_ware_name", "", "");
// �����ʬ trade classification
$form->addElement("static", "form_trade_buy", "", "");
// ô���� assigned staff
$form->addElement("static", "form_oc_staff_name", "", "");
// ô���� assigned staff
$form->addElement("static", "form_c_staff_name", "", "");
// ���� remarks
$form->addElement("static", "form_note", "", "");

// ���ܸ������å� check where it transitioned from
if($input_flg == true){
    // �������ϡʥ��ե饤��˲��� input purchase (offline) screen
    $form->addElement("button", "ok_button", "�ϡ���", "onClick=\"Submit_Page('".Make_Rtn_Page("buy")."');\"");

    // ��� go back
    if ($_GET[change_ord_flg] == null && $_GET["inst_err"] == null){

        if($buy_div == '1'){
            $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"location.href='1-3-201.php?buy_id=$buy_id'\"");
        }else{
            $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"location.href='1-3-207.php?buy_id=$buy_id'\"");
        }
    }
    $freeze_flg = true;    // ������λ��å�����ɽ���ե饰 purchase complete message display flag
}else{
    // ȯ��Ȳ���� purchase order inquiry screen
    // ��� go back
    $form->addElement("button", "return_button", "�ᡡ��", "onClick=\"javascript:history.back()\"");
}

// ����۹�� total sales amount
$form->addElement("text", "form_buy_total", "", "size=\"18\" maxLength=\"15\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #FFFFFF; text-align: right\" readonly");

// �����ǳ�(���) total tax amount
$form->addElement("text", "form_buy_tax", "", "size=\"18\" maxLength=\"15\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly");

// ����ۡ��ǹ����) total sales with tax
$form->addElement("text", "form_buy_money", "", "size=\"18\" maxLength=\"15\" style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly");

/****************************/
// �����إå������Ƚ����� decision process for extracting purchase header 
/****************************/
if($_GET[del_buy_flg] == null && $_GET[del_ord_flg] == null && $_GET[change_ord_flg] == null && $_GET["inst_err"] == null && $_GET["ps_stat"] == null){
    $sql  = "SELECT renew_flg FROM t_buy_h WHERE t_buy_h.buy_id = $buy_id AND shop_id = $shop_id;";
    $result = Db_Query($db_con, $sql);
    // GET�ǡ���Ƚ�� decidison of GET data
    Get_Id_Check($result);

    // ���������ե饰���� acquire daily update flag
    $renew_flg = pg_fetch_result($result, 0, 0);

    //��ư�ǵ������������ɤ���Ƚ�� decide if it was an automatic purchase
    $sql  = "SELECT \n";
    $sql .= "    CASE \n";
    $sql .= "        WHEN intro_sale_id IS NOT NULL OR act_sale_id IS NOT NULL \n";
    $sql .= "            THEN 't' \n";
    $sql .= "            ELSE 'f' \n";
    $sql .= "    END AS intro_act_flg \n";
    $sql .= "FROM \n";
    $sql .= "    t_buy_h \n";
    $sql .= "WHERE \n";
    $sql .= "    buy_id = $buy_id AND shop_id = $shop_id \n";
    $sql .= ";";
    $result = Db_Query($db_con, $sql);
    //��ư�ǵ����������ʤ顢���������ե饰��"t"�ˤ�������ɽ������ if it was an automatic purchase then make the daily update flag "t" then show details
    $renew_flg = (pg_fetch_result($result, 0, 0) == "t") ? "t" : $renew_flg;

    //���������ե饰���ǣ��Ǥ���Ͽ�ե饰��true�ξ��ȥåפ����� if the daily update is "t" and the register flag is true then transition to the top screen
    if($renew_flg == 't' && $input_flg == 'true'){
        header("Location:../top.php");
    }elseif($renew_flg == 'f' && $input_flg != 'true'){
        header("Location:../top.php");
    }

    $sql  = "SELECT ";
    $sql .= "    t_buy_h.buy_no, ";
    $sql .= "    t_order_h.ord_no, ";
    $sql .= "    t_buy_h.buy_day, ";
    $sql .= "    t_buy_h.arrival_day, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.client_cd1, "   : " t_client.client_cd1, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.client_name, "  : " t_client.client_name, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.direct_name, "  : " t_direct.direct_name, ";
//$sql .= ($renew_flg == "t") ? " t_buy_h.ware_name, "    : " t_ware.ware_name, ";
    $sql .= "   CASE buy_div\n";
    $sql .= "       WHEN '2' THEN t_buy_h.client_cd1 || '-'|| t_buy_h.client_cd2\n";
    $sql .= "       ELSE t_buy_h.client_cd1\n";
    $sql .= "   END AS client_cd1,\n";
//    $sql .= "    t_buy_h.client_cd1, ";
    $sql .= "    t_buy_h.client_cname, ";
    $sql .= "    t_buy_h.direct_name, ";
    $sql .= "    t_buy_h.ware_name, ";
    $sql .= "    t_trade.trade_name,";
//$sql .= ($renew_flg == "t") ? " t_buy_h.c_staff_name, " : " t_staff.staff_name, ";
    $sql .= "    t_buy_h.c_staff_name, ";
    $sql .= "    t_buy_h.note, ";
    $sql .= "    t_buy_h.net_amount, ";
    $sql .= "    t_buy_h.tax_amount, ";
    $sql .= "    t_buy_h.trade_id, ";
    $sql .= "   t_buy_h.client_id ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
//$sql .= ($renew_flg != "t") ? " LEFT JOIN " : null;
//$sql .= ($renew_flg != "t") ? " t_direct "  : null;
//$sql .= ($renew_flg != "t") ? " ON t_buy_h.direct_id  = t_direct.direct_id " : null;
    $sql .= "    LEFT JOIN ";
    $sql .= "    t_order_h ";
    $sql .= "    ON t_buy_h.ord_id = t_order_h.ord_id ";
    $sql .= "    INNER JOIN";
    $sql .= "    t_trade";
    $sql .= "    ON t_buy_h.trade_id = t_trade.trade_id ";
//if ($renew_flg != "t"){
//    $sql .= "    INNER JOIN t_client ON t_buy_h.client_id  = t_client.client_id ";
//    $sql .= "    INNER JOIN t_ware   ON t_buy_h.ware_id    = t_ware.ware_id ";
//    $sql .= "    INNER JOIN t_staff  ON t_buy_h.c_staff_id = t_staff.staff_id ";
//}
    $sql .= "WHERE ";
    $sql .= "    t_buy_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_buy_h.buy_id = $buy_id;";

    $result = Db_Query($db_con, $sql);
    $h_data_list = Get_Data($result);

    $sql  = "SELECT ";
//$sql .= "    t_staff.staff_name ";
    $sql .= "    t_buy_h.oc_staff_name ";
    $sql .= "FROM ";
    $sql .= "    t_buy_h ";
    $sql .= "    INNER JOIN t_staff ON t_buy_h.oc_staff_id = t_staff.staff_id ";
    $sql .= "WHERE ";
    $sql .= "    t_buy_h.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "    t_buy_h.buy_id = $buy_id;";

    $result = Db_Query($db_con,$sql);   
    $oc_staff = Get_Data($result);
}

/****************************/
// �����ǡ������SQL�������������SQL for extracting purchase data (after DU)
/****************************/
$data_sql  = "SELECT ";
//$data_sql .= ($renew_flg == "t") ? " t_buy_d.goods_cd," : " t_goods.goods_cd,";
$data_sql .= "    t_buy_d.goods_cd, ";
$data_sql .= "    t_buy_d.goods_name,";
$data_sql .= "    t_buy_d.num,"; 
$data_sql .= "    t_buy_d.buy_price,";
//aoyama-n 2009-09-18
#$data_sql .= "    t_buy_d.buy_amount ";
$data_sql .= "    t_buy_d.buy_amount, ";
$data_sql .= "    t_goods.discount_flg ";
$data_sql .= "FROM ";
$data_sql .= "    t_buy_d ";
$data_sql .= "    INNER JOIN t_buy_h ON t_buy_d.buy_id = t_buy_h.buy_id ";
//aoyama-n 2009-09-18
$data_sql .= "    INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id ";
//$data_sql .= ($renew_flg != "t") ? "INNER JOIN t_goods ON t_buy_d.goods_id = t_goods.goods_id " : null;
$data_sql .= "WHERE ";
$data_sql .= "    t_buy_d.buy_id = $buy_id ";
$data_sql .= "AND ";
$data_sql .= "    t_buy_h.shop_id = $shop_id ";
$data_sql .= "ORDER BY ";
//$data_sql .= ($renew_flg == "t") ? " t_buy_d.goods_cd;" : " t_goods.goods_cd;";
//aoyama-n 2009-09-18
#$data_sql .= " t_buy_d.goods_cd;";
$data_sql .= " t_buy_d.line;";

$result = Db_Query($db_con,$data_sql);

/****************************/
// �����ǡ�����ɽ�� display purchase data
/****************************/
// �ԥǡ������ʤ���� create the row data component
$row_data = Get_Data($result);
for($i=0; $i<count($row_data); $i++){
    for($j=0; $j<count($row_data[$i]); $j++){
        if($j == 2 || $j == 4){
            $row_data[$i][$j] = number_format($row_data[$i][$j]);
        }else if($j == 3){
            $row_data[$i][$j] = number_format($row_data[$i][$j], 2);
        }
    }
}

/****************************/
// �����إå���ɽ�� display purchase header
/****************************/
$def_fdata["form_buy_no"]           =   $h_data_list[0][0];                         // ��ɼ�ֹ� slip number
$def_fdata["form_ord_no"]           =   $h_data_list[0][1];                         // ȯ���ֹ� purchase order number

// �������� create date
$form_buy_day                       =   explode("-", $h_data_list[0][2]);
$form_arrival_day                   =   explode("-", $h_data_list[0][3]);

$def_fdata["form_buy_day"]["y"]     =   $form_buy_day[0];                           // ������(ǯ) purchase date year
$def_fdata["form_buy_day"]["m"]     =   $form_buy_day[1];                           // ������(��) purchase date mth
$def_fdata["form_buy_day"]["d"]     =   $form_buy_day[2];                           // ������(��) purchase date day

$def_fdata["form_arrival_day"]["y"] =   $form_arrival_day[0];                       // ������(ǯ) purchase arrival date year
$def_fdata["form_arrival_day"]["m"] =   $form_arrival_day[1];                       // ������(��)purchase arrival date mth
$def_fdata["form_arrival_day"]["d"] =   $form_arrival_day[2];                       // ������(��) purchase arrival date day

$def_fdata["form_client"]["cd1"]    =   $h_data_list[0][4];                         // ������    purchase client
$def_fdata["form_client"]["name"]   =   $h_data_list[0][5];                          

$def_fdata["form_direct_name"]      =   $h_data_list[0][6];                         // ľ���� direct destination
$def_fdata["form_ware_name"]        =   $h_data_list[0][7];                         // �Ҹ� warehouse
$def_fdata["form_trade_buy"]        =   $h_data_list[0][8];                         // �����ʬ trade classification
$def_fdata["form_c_staff_name"]     =   $h_data_list[0][9];                         // ô���� assigned staff
$def_fdata["form_note"]             =   $h_data_list[0][10];

$def_fdata["form_buy_total"]        =   number_format($h_data_list[0][11]);         // ��ȴ��� amount without tax
$def_fdata["form_buy_tax"]          =   number_format($h_data_list[0][12]);         // ������ tax
$total_money                        =   $h_data_list[0][11] + $h_data_list[0][12];  // �ǹ���� amount with tax
$def_fdata["form_buy_money"]        =   number_format($total_money);                         
$def_fdata["form_oc_staff_name"]    =   $oc_staff[0][0];                            // ȯ��ô���� purchase order assigned staff

$client_id                          =   $h_data_list[0][14];                        // ������ID purchase client ID

$form->setDefaults($def_fdata);

//�����ʬ������ξ�硢�������ϥܥ������ if trade classification "installement" then create the "input installmenT" button
if($h_data_list[0][13] == '25' && $input_flg == true){
    $form->addElement("button", "form_split_button","�������","onClick=\"location.href='1-3-206.php?buy_id=".$buy_id."'\"");
}


/****************************/
// ������ξ��ּ��� acqiore the condition of the purchase client
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
// ��̳���������ɼ���ٻ���
// �����������ɼ�ֹ�����ۤ���Ϥ��� output the sales slip number and sales amount in the detail of the agency fee
/****************************/
if ($input_flg == null){

    $sql  = "SELECT \n";
    $sql .= "   t_sale_h.sale_no, \n";
    $sql .= "   t_sale_h.net_amount + t_sale_h.tax_amount AS sale_amount \n";
    $sql .= "FROM \n";
    $sql .= "   t_buy_h \n";
    $sql .= "   INNER JOIN t_sale_h ON t_buy_h.act_sale_id = t_sale_h.sale_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_buy_h.buy_id = $buy_id \n";
    $sql .= ";";
    $res  = Db_Query($db_con, $sql);
    $num  = pg_num_rows($res);

    // �쥳���ɤ������� if there is a record
    if ($num > 0){

        $act_sale_flg    = true;                            // ��̳������ե饰 agency fee flag

        $act_sale_no     = pg_fetch_result($res, 0, 0);     // ����ֹ� sale number
        $act_sale_amount = pg_fetch_result($res, 0, 1);     // �������  agency sales amount

        // �ե�������ͤ򥻥å� set the value in form
        $set_act_data["form_act_sale_no"]       = str_pad($act_sale_no, 8, "0", STR_PAD_LEFT);
        $set_act_data["form_act_sale_amount"]   = number_format($act_sale_amount);
        $form->setConstants($set_act_data);

        // ����ֹ� sale number
        $form->addElement("text", "form_act_sale_no", "", "size=\"18\" maxLength=\"15\"
            style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: left\" readonly
        ");

        // ������� agency sale amount
        $form->addElement("text", "form_act_sale_amount", "", "size=\"18\" maxLength=\"15\"
            style=\"color: #585858; border: #ffffff 1px solid; background-color: #ffffff; text-align: right\" readonly
        ");

    }


}


/****************************/
// HTML�إå� html header
/****************************/
$html_header = Html_Header($page_title);

/****************************/
// HTML�եå� html footer
/****************************/
$html_footer = Html_Footer();

/****************************/
// ��˥塼���� create menu
/****************************/
$page_menu = Create_Menu_h("buy", "2");

/****************************/
// ���̥إå������� create screen header
/****************************/
$page_header = Create_Header($page_title);

//  Render��Ϣ������ render related setting
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

// form��Ϣ���ѿ���assign assign form related variable
$smarty->assign("form", $renderer->toArray());

// ����¾���ѿ���assign assign other variables
$smarty->assign("var", array(
    "html_header"   => "$html_header",
    "page_menu"     => "$page_menu",
    "page_header"   => "$page_header",
    "html_footer"   => "$html_footer",
    "input_flg"     => "$input_flg",
    "freeze_flg"    => "$freeze_flg",
    "act_sale_flg"  => "$act_sale_flg",
    "client_state_print"    => "$client_state_print",
));
$smarty->assign("row", $row_data);
// �ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
