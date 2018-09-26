<?php
/************************************
 * �ѹ�����
 *   2006/06/16                watanabe-k    ��������������ǡ������SQL���ѹ�
 *   2007/03/01                  morita-d    ����̾������̾�Τ�ɽ������褦���ѹ� 
 *
 *
 ************************************/
$page_title = "���Ȳ�";

//�Ķ�����ե����� env setting file
require_once("ENV_local.php");

//HTML_QuickForm����� create HTML_quickform
$form =& new HTML_QuickForm("dateForm", "POST", $_SERVER["PHP_SELF"]);

//DB��³ connect to db
$db_con = Db_Connect();

// ���¥����å� authority check
$auth       = Auth_Check($db_con);


/*
 * ����
 * �����ա�������BɼNo.��������ô���ԡ��������ơ�
 * ��2006/11/07��08-097��������watnabe-k�� Get�����å��ɲ�
 * ��2006/11/07��08-098��������watnabe-k�� Get�����å��ɲ�
 * ��2006/11/07��08-099��������watnabe-k�� SQL��､�� 
 * ��2006/11/07��08-116��������suzuki��    �����ɼ���ȯ�Ԥ������ܤǤ���褦�˽��� 
 * ��2006/11/08��08-132��������suzuki��    ������̾��ά��ɽ�� 
 * ��2009/07/06��      ��������aoyama-n��  ��ɼ���ƤΥ����Ƚ���ʥ����ɤ���line�˽��� 
 *   2009/10/13                hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 *
 */

/****************************/
//�ǡ������ܺ����ؿ� create function for data items
/****************************/
//(����������ID) argument: sales order ID 
function Get_Sale_Item($aord_id){
    if($aord_id != NULL){
        //�����鶽������ was it recorded from sales order
        $row_item[] = array("No.","���ʥ�����<br>����̾","�����","���߸˿�","�вٿ�","����ñ��<br>���ñ��","�������<br>�����");
    }else{
        //��夫�鶽������ was it recorded from sales 
        $row_item[] = array("No.","���ʥ�����<br>����̾","���߸˿�","�вٿ�","����ñ��<br>���ñ��","�������<br>�����");
    }

    return $row_item;
}

/****************************/
//��ɼȯ�Խ��� issue slip process
/****************************/
$order_sheet  = " function Order_Sheet(hidden1,ord_id){\n";
$order_sheet .= "    res = window.confirm(\"��ɼ��ȯ�Ԥ��ޤ���������Ǥ�����\");\n";
$order_sheet .= "    if (res == true){\n";
$order_sheet .= "        var id = ord_id;\n";
$order_sheet .= "        var hdn1 = hidden1;\n";
$order_sheet .= "        window.open('../../head/sale/1-2-206.php?sale_id='+id,'_blank','');\n";
$order_sheet .= "        document.dateForm.elements[hdn1].value = ord_id;\n";
$order_sheet .= "        //Ʊ��������ɥ������ܤ���\n";
$order_sheet .= "        document.dateForm.target=\"_self\";\n";
$order_sheet .= "        //�����̤����ܤ���\n";
$order_sheet .= "        document.dateForm.action='#';\n";
$order_sheet .= "        //POST�������������\n";
$order_sheet .= "        document.dateForm.submit();\n";
$order_sheet .= "        return true;\n";
$order_sheet .= "   }else{\n";
$order_sheet .= "        return false;\n";
$order_sheet .= "    }\n";
$order_sheet .= "}\n";

/****************************/
//����ؿ���� function definition for contract
/****************************/
require_once(INCLUDE_DIR."function_keiyaku.inc");
/****************************/
//�����ѿ����� acquire external vairiable
/****************************/
$staff_id     = $_SESSION[staff_id];
$shop_id      = $_SESSION[client_id];
$sale_id      = $_GET["sale_id"];             //����ID Sales order ID
$input_flg    = $_GET["input_flg"];           //������ϼ��̥ե饰 sales input identification flag
$slip_flg     = $_GET["slip_flg"];           //���Ȳ񡦰��ȯ�Լ��̥ե饰 sales inquiry/ issue all at once identification flag
$del_flg     = $_GET["del_flg"];                //����ե饰 delete flag 
$renew_flg     = $_GET["renew_flg"];           //���������ե饰 daily update flag
$aord_del_flg  = $_GET["aord_del_flg"];     //�������ե饰 sales order delete flag
$aord_finish_flg  = $_GET["aord_finish_flg"];     //�������ե饰 sales order delete flag

if($aord_del_flg != true && $aord_finish_flg != true && $_GET["inst_err"] != true){
    //�����ͥ����å�Ƚ�� determine invald value
    Get_Id_Check2($_GET["sale_id"]);
    Get_Id_Check3($_GET["sale_id"]);

    if($del_flg != 'true' && $renew_flg != 'true'){
        //������Ƚ��ؿ� function for determining compatibility 
        Injustice_check($db_con,"sale",$sale_id,$shop_id);
    }
}
/****************************/
//������� component definition
/****************************/
//���׾��� sales recorded date
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_sale_day","form_sale_day");

//������ invoice date
$text="";
$text[] =& $form->createElement("static","y","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","m","","");
$text[] =& $form->createElement("static","","","-");
$text[] =& $form->createElement("static","d","","");
$form->addGroup( $text,"form_claim_day","form_claim_day");

//��ɼ�ֹ� slip number 
$form->addElement("static","form_sale_no","","");
//�����ֹ� sales order number 
$form->addElement("static","form_ord_no","","");

//������̾ customer name
$form_client[] =& $form->createElement("static","cd1","","");
$form_client[] =& $form->createElement("static","","","-");
$form_client[] =& $form->createElement("static","cd2","","");
$form_client[] =& $form->createElement("static","",""," ");
$form_client[] =& $form->createElement("static","name","","");
$form->addGroup( $form_client, "form_client", "");

//���꡼����� green designation
$form->addElement("static","form_trans_check","","");
//�����ȼ�̾ carrier 
$form->addElement("static","form_trans_name","","");
//ľ����̾ direct destination name
$form->addElement("static","form_direct_name","","");
//�в��Ҹ� shipping warehouse
$form->addElement("static","form_w are_name","","");
//�����ʬ trade classification
$form->addElement("static","form_trade_sale","","");
//����ô���� sales order staff
$form->addElement("static","form_staff_name","","");
//���ô���� sales staff
$form->addElement("static","form_cstaff_name","","");
//���� remakrs
//���� remarks 
$form->addElement("static","form_note","","");

//��ɼȯ�� issue slip
$form->addElement("button","order_button","��ɼȯ��","onClick=\"javascript:Order_Sheet('order_sheet_id',$sale_id);\"");
//��ɼȯ��ID issue slip ID
$form->addElement("hidden", "order_sheet_id");

//���ܸ������å� check the page transitioned from
if($input_flg == true){
    //������ϲ��� sales input screen
    //OK�ܥ��� ok button
    $form->addElement("button", "ok_button", "�ϡ���",
        "onClick=\"location.href='".Make_Rtn_Page("sale")."'\""
    );
    //��� back 
    $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='1-2-201.php?sale_id=$sale_id'\"");

    //Ǽ�ʽ���� delivery note output
    $form->addElement("button","order_button","��ɼȯ��","onClick=\"javascript:Order_Sheet('order_sheet_id',$sale_id);\"");

    $freeze_flg = true;    //��崰λ��å�����ɽ���ե饰 sales complete message display flag

}else{
    //���ܸ�����Ƚ�� determine the page transitioned from
    if($slip_flg == true){
        //���Ȳ� sales inquiry 
        //��� back 
        $form->addElement("button", "return_button", "�ᡡ��",
        "onClick=\"location.href='".Make_Rtn_Page("sale")."'\""
        );
    }else{
        //���ȯ�Բ��� issue all at one screen
        //��� back
        $form->addElement("button","return_button","�ᡡ��","onClick=\"location.href='1-2-202.php'\"");
    }
}

//����۹�� total sales 
$form->addElement(
    "text","form_sale_total","",
    "size=\"25\" maxLength=\"18\" 
    style=\"color : #585858; 
    border : #FFFFFF 1px solid; 
    background-color: #FFFFFF; 
    text-align: right\" readonly'"
);

//�����ǳ�(���) tax total
$form->addElement(
        "text","form_sale_tax","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

//����ۡ��ǹ����) sales total with tax
$form->addElement(
        "text","form_sale_money","",
        "size=\"25\" maxLength=\"18\" 
        style=\"color : #585858; 
        border : #FFFFFF 1px solid; 
        background-color: #FFFFFF; 
        text-align: right\" 
        readonly"
);

if($del_flg != 'true' && $renew_flg != 'true' && $aord_del_flg != 'true' && $_GET["inst_err"] != true && $_GET["aord_finish_flg"] != true){
    /****************************/
    //���إå������Ƚ����� sales header extraction determination process
    /****************************/
    $sql  = "SELECT ";
    $sql .= "    aord_id,";
    $sql .= "    renew_flg ";
    $sql .= "FROM ";
    $sql .= "    t_sale_h ";
    $sql .= "WHERE ";
    $sql .= "    t_sale_h.sale_id = $sale_id";
    $sql .= "    AND";
    $sql .= "    t_sale_h.shop_id = $shop_id";
    $sql .= ";";
    $result = Db_Query($db_con,$sql);

    //GET�ǡ���Ƚ�� determine GET data
    Get_Id_Check($result);
    $stat = Get_Data($result);
    $aord_id   = $stat[0][0];            //����ID sales order ID 
    $renew_flg = $stat[0][1];            //���������ե饰 daily update flag

    //���������ե饰��true�� is the daily update flag true
    if($renew_flg == 't'){
        /****************************/
        //���إå����SQL������������� sales header extract SQL (after daily update)
        /****************************/
        $sql  = "SELECT ";                             
        $sql .= "    t_sale_h.sale_no,";
        $sql .= "    t_aorder_h.ord_no,";
        $sql .= "    t_sale_h.sale_day,";
        $sql .= "    t_sale_h.claim_day,";
        $sql .= "    t_sale_h.client_cd1,";
        $sql .= "    t_sale_h.client_cd2,";
        $sql .= "    t_sale_h.client_cname,";
        $sql .= "    t_sale_h.green_flg,";
        $sql .= "    t_sale_h.trans_cname,";
        $sql .= "    t_sale_h.direct_cname,";
        $sql .= "    t_sale_h.ware_name,";
        $sql .= "    CASE t_sale_h.trade_id";            
        $sql .= "        WHEN '11' THEN '�����'";
        $sql .= "        WHEN '13' THEN '������'";
        $sql .= "        WHEN '14' THEN '���Ͱ�'";
        $sql .= "        WHEN '15' THEN '�������'";
        $sql .= "        WHEN '61' THEN '�������'";
        $sql .= "        WHEN '63' THEN '��������'";
        $sql .= "        WHEN '64' THEN '�����Ͱ�'";
        $sql .= "    END,";
        $sql .= "    t_sale_h.c_staff_name,";
        $sql .= "    t_sale_h.note, ";
        $sql .= "    t_sale_h.net_amount, ";
        $sql .= "    t_sale_h.tax_amount, ";
//        $sql .= "    t_sale_h.ac_staff_name,";
        $sql .= "    t_aorder_h.c_staff_name,";
        $sql .= "    t_sale_h.ware_id, ";
        $sql .= "   t_sale_h.client_id \n";
        $sql .= "FROM ";
        $sql .= "    t_sale_h ";

        $sql .= "    LEFT JOIN ";
        $sql .= "    t_aorder_h ";
        $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id ";

        $sql .= "WHERE ";
        $sql .= "    t_sale_h.shop_id = $shop_id ";
        $sql .= "AND ";
        $sql .= "    t_sale_h.sale_id = $sale_id;";
    }elseif($slip_flg == 'true' && $renew_flg == 'f'){
        header("Location:../top.php");
        exit;
    }else{
        /****************************/
        //���إå������SQL sales header extract SQL
        /****************************/

        $sql  = "SELECT \n";
        $sql .= "    t_sale_h.sale_no,\n";
        $sql .= "    t_aorder_h.ord_no,\n";
        $sql .= "    t_sale_h.sale_day,\n";
        $sql .= "    t_sale_h.claim_day,\n";
//    $sql .= "    t_client.client_cd1,\n";
//    $sql .= "    t_client.client_cd2,\n";
//    $sql .= "    t_client.client_name,\n";
        $sql .= "    t_sale_h.client_cd1,\n";
        $sql .= "    t_sale_h.client_cd2,\n";
        $sql .= "    t_sale_h.client_cname,\n";
        $sql .= "    t_sale_h.green_flg,\n";
//    $sql .= "    t_trans.trans_cname,\n";
//    $sql .= "    t_direct.direct_cname,\n";
//    $sql .= "    t_ware.ware_name,\n";
        $sql .= "    t_sale_h.trans_cname,\n";
        $sql .= "    t_sale_h.direct_cname,\n";
        $sql .= "    t_sale_h.ware_name,\n";
        $sql .= "    CASE t_sale_h.trade_id\n";
        $sql .= "        WHEN '11' THEN '�����'\n";
        $sql .= "        WHEN '13' THEN '������'\n";
        $sql .= "        WHEN '14' THEN '���Ͱ�'\n";
        $sql .= "        WHEN '15' THEN '�������'\n";
        $sql .= "        WHEN '61' THEN '�������'\n";
        $sql .= "        WHEN '63' THEN '��������'\n";
        $sql .= "        WHEN '64' THEN '�����Ͱ�'\n";
        $sql .= "    END,\n";
        $sql .= "    t_sale_h.c_staff_name,\n";
        $sql .= "    t_sale_h.note, \n";
        $sql .= "    t_sale_h.net_amount, \n";
        $sql .= "    t_sale_h.tax_amount, \n";
//    $sql .= "    ac_staff.staff_name, \n";
//        $sql .= "    t_sale_h.ac_staff_name, \n";
        $sql .= "    t_aorder_h.c_staff_name, \n";
        $sql .= "    t_sale_h.ware_id, \n";
        $sql .= "   t_sale_h.client_id \n";
        $sql .= "FROM \n";
        $sql .= "    t_sale_h \n";

        $sql .= "    LEFT JOIN \n";
        $sql .= "    t_trans \n";
        $sql .= "    ON t_sale_h.trans_id  = t_trans.trans_id \n";

        $sql .= "    LEFT JOIN \n";
        $sql .= "    t_direct \n";
        $sql .= "    ON t_sale_h.direct_id  = t_direct.direct_id \n";

        $sql .= "    LEFT JOIN \n";
        $sql .= "    t_aorder_h \n";
        $sql .= "    ON t_sale_h.aord_id = t_aorder_h.aord_id \n";

//    $sql .= "    INNER JOIN t_client ON t_sale_h.client_id  = t_client.client_id \n";
    //$sql .= "    INNER JOIN t_ware   ON t_sale_h.ware_id    = t_ware.ware_id \n";
//    $sql .= "    INNER JOIN t_staff AS c_staff  ON t_sale_h.c_staff_id = c_staff.staff_id \n";
//    $sql .= "    INNER JOIN t_staff AS ac_staff  ON t_sale_h.ac_staff_id = ac_staff.staff_id \n";
        $sql .= "WHERE \n";
        $sql .= "    t_sale_h.shop_id = $shop_id \n";
        $sql .= "AND \n";
        $sql .= "    t_sale_h.sale_id = $sale_id;\n";
    }

    $result = Db_Query($db_con,$sql);
    $h_data_list = Get_Data($result);

    /****************************/
    //���ǡ������SQL sales data extract SQL
    /****************************/
    $data_sql  = "SELECT ";
    //���������ե饰��true�� daily update flag is true or not?
    if($renew_flg == 't'){
        $data_sql .= "    t_sale_d.goods_cd,";
    }else{
//    $data_sql .= "    t_goods.goods_cd,";
        $data_sql .= "    t_sale_d.goods_cd,";
    }
    //$data_sql .= "    t_sale_d.goods_name,";
    $data_sql .= "    t_sale_d.official_goods_name,";
    $data_sql .= "    t_sale_d.num,"; 
    $data_sql .= "    t_sale_d.cost_price,";
    $data_sql .= "    t_sale_d.sale_price,";
    $data_sql .= "    t_sale_d.cost_amount, ";
    $data_sql .= "    t_sale_d.sale_amount, ";
    //����ID��������ϡ��������ɽ�� display the ordered number of units received if there is a sales order ID 
    if($aord_id != NULL){
        $data_sql .= "    t_aorder_d.num, ";
    }
    #2009-10-13 hashimoto-y
    #$data_sql .= "    CASE t_goods.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";
    $data_sql .= "    CASE t_goods_info.stock_manage WHEN 1 THEN COALESCE(t_stock.stock_num,0) END AS stock_num ";

    $data_sql .= "FROM ";
    $data_sql .= "    t_sale_d ";
    $data_sql .= "    INNER JOIN t_sale_h ON t_sale_d.sale_id = t_sale_h.sale_id ";
    //����ID��������ϡ�����ǡ����ơ��֥�ȷ�� combine with sales order data table if there is a sales order ID
    if($aord_id != NULL){
        $data_sql .= "    INNER JOIN t_aorder_d ON t_sale_d.aord_d_id = t_aorder_d.aord_d_id ";
    }
    //���������ե饰��true�� is the faily update id true
    //if($renew_flg == 't'){
        $data_sql .= "    INNER JOIN t_goods ON t_sale_d.goods_id = t_goods.goods_id ";
    //}
    $data_sql .= "   LEFT JOIN ";
    $data_sql .= "   (SELECT";
    $data_sql .= "       goods_id,";
    $data_sql .= "       SUM(stock_num)AS stock_num";
    $data_sql .= "   FROM";
    $data_sql .= "       t_stock";
    $data_sql .= "   WHERE";
    $data_sql .= "       shop_id = $shop_id";
    $data_sql .= "       AND";
    $data_sql .= "       ware_id = ".$h_data_list[0][17];
    $data_sql .= "       GROUP BY t_stock.goods_id";
    $data_sql .= "   )AS t_stock";
    $data_sql .= "   ON t_sale_d.goods_id = t_stock.goods_id ";

    #2009-10-13 hashimoto-y
    $data_sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id ";

    $data_sql .= "WHERE ";
    $data_sql .= "    t_sale_d.sale_id = $sale_id ";
    $data_sql .= "AND ";
    $data_sql .= "    t_sale_h.shop_id = $shop_id ";
    #2009-10-13 hashimoto-y
    $data_sql .= "AND ";
    $data_sql .= "    t_goods_info.shop_id = $shop_id ";

    $data_sql .= "ORDER BY ";
    //aoyama-n 2009-07-06
    //���������ե饰��true�� is the daily update flag true 
    //if($renew_flg == 't'){
    //    $data_sql .= "    t_sale_d.goods_cd;";
    //}else{
//    $data_sql .= "    t_goods.goods_cd;";
    //    $data_sql .= "    t_sale_d.goods_cd;";
    //}
    $data_sql .= "    t_sale_d.line;";

    $result = Db_Query($db_con,$data_sql);

    /****************************/
    //���ǡ�����ɽ�� display sales data
    /****************************/
    //�Թ������ʤ���� create row items components 
    $row_item = Get_Sale_Item($aord_id);

    //�ԥǡ������ʤ���� create row data component 
    $row_data = Get_Data($result);
    for($i=0;$i<count($row_data);$i++){
        for($j=0;$j<count($row_data[$i]);$j++){
            //����ñ�������ñ�� costper unit, selling price per unit 
            if($j==3 || $j==4){
                $row_data[$i][$j] = number_format($row_data[$i][$j],2);
            }
            //�вٿ���������ۡ������ number of units to be shipped, cost price, sales price
            if($j==2 || $j==5 || $j==6){
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }
            //�������ɽ�������硢��Ĥ����� it will deviate one each if number of units will be displayed 
            if($aord_id != NULL && $j==7){
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }
        
            //�����ɽ��Ƚ�� determine if the ordered number of units will be displayed 
            if($aord_id != NULL && $j==8){
                //���߸˿� current inv number 
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }else if($aord_id == NULL && $j==7){
                //���߸˿� current inv number
                $row_data[$i][$j] = number_format($row_data[$i][$j]);
            }
        }
    }
    /****************************/
    //���إå���ɽ�� display sales header
    /****************************/
    $def_fdata["form_sale_no"]                      =   $h_data_list[0][0];                          //��ɼ�ֹ� slip number 
    $def_fdata["form_ord_no"]                       =   $h_data_list[0][1];                          //�����ֹ� saleso rrder number 

    //�������� create daily update 
    $form_sale_day                                  =   explode('-',$h_data_list[0][2]);
    $form_claim_day                                 =   explode('-',$h_data_list[0][3]);

    $def_fdata["form_sale_day"]["y"]                =   $form_sale_day[0];                           //�����(ǯ) sales date year
    $def_fdata["form_sale_day"]["m"]                =   $form_sale_day[1];                           //�����(��) sales date month
    $def_fdata["form_sale_day"]["d"]                =   $form_sale_day[2];                           //�����(��) sales date day

    $def_fdata["form_claim_day"]["y"]               =   $form_claim_day[0];                          //������(ǯ) invoice date year 
    $def_fdata["form_claim_day"]["m"]               =   $form_claim_day[1];                          //������(��) invoice date month 
    $def_fdata["form_claim_day"]["d"]               =   $form_claim_day[2];                          //������(��) invoice date day

    $def_fdata["form_client"]["cd1"]                =   $h_data_list[0][4];                          //������cd1 customer code 1 
    $def_fdata["form_client"]["cd2"]                =   $h_data_list[0][5];                          //������cd2customer code 2
    $def_fdata["form_client"]["name"]               =   $h_data_list[0][6];                          //������̾ cusotmer name

    $client_id                                      =   $h_data_list[0][18];

    //���꡼�����Ƚ�� determube uf green destination is checked
    if($h_data_list[0][7] == 't'){
        $def_fdata["form_trans_check"]              = "���꡼����ꤢ�ꡡ";
    }
    $def_fdata["form_trans_name"]                   =   $h_data_list[0][8];                         //�����ȼ� carrier
    $def_fdata["form_direct_name"]                  =   $h_data_list[0][9];                         //ľ���� direct destination
    $def_fdata["form_ware_name"]                    =   $h_data_list[0][10];                         //�Ҹ� waarehouse
    $def_fdata["form_trade_sale"]                   =   $h_data_list[0][11];                         //�����ʬ trade classification
    $def_fdata["form_cstaff_name"]                   =   $h_data_list[0][12];                         //���ô���� sales staff
    $def_fdata["form_note"]                         =   $h_data_list[0][13];

    $def_fdata["form_sale_total"]                   =   number_format($h_data_list[0][14]);          //��ȴ��� amount with no tax
    $def_fdata["form_sale_tax"]                     =   number_format($h_data_list[0][15]);          //������ tax
    $total_money                                    =   $h_data_list[0][14] + $h_data_list[0][15];   //�ǹ���� amt with tax
    $def_fdata["form_sale_money"]                   =   number_format($total_money);                         
    $def_fdata["form_staff_name"]                   =   $h_data_list[0][16];                         //����ô����           sales order slaff              
    $form->setDefaults($def_fdata);

    /****************************/
    //��ɼȯ�ԥܥ��󲡲����� when the issue slip button is pressed 
    /****************************/
    if($_POST["order_sheet_id"]!=NULL){

        Db_Query($db_con, "BEGIN");

        $flg_update  = " UPDATE ";
        $flg_update .= "    t_sale_h ";
        $flg_update .= "    SET ";
        $flg_update .= "    slip_flg = 't', ";
        $flg_update .= "    slip_out_day = NOW() ";
        $flg_update .= "    where ";
        $flg_update .= "    sale_id = ".$_POST["order_sheet_id"];
        $flg_update .= "    AND ";
        $flg_update .= "    slip_flg ='f' ";
        $flg_update .= ";";

        //�����ǡ������ number of corresponding data
        $result = @Db_Query($db_con, $flg_update);
        if($result == false){
            Db_Query($db_con, "ROLLBACK");
            exit;
        }
        Db_Query($db_con, "COMMIT");

    }

    if($h_data_list[0][11] == "�������" && $input_flg == true){
        //ʬ��������� input sales divided into 7 
        //$form->addElement("button","slip_bill_button","ʬ������","onClick=\"location.href='1-2-208.php?sale_id=$sale_id'\"");
	    $form->addElement("button","slip_bill_button","ʬ������","onClick=\"SubMenu2('".HEAD_DIR."sale/1-2-208.php?sale_id=".$sale_id."')\"");
	    $form->addElement("hidden","slip_bill_flg");    //����������ܥե饰 flag for transitioning to salses input  
	
	    $slip_data["slip_bill_flg"] = true;
	    $form->setConstants($slip_data);   
    }
}


/****************************/
// ������ξ��ֽ��� output the customer status 
/****************************/
$client_state_print = Get_Client_State($db_con, $client_id);


/****************************/
//HTML�إå� html header 
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTML�եå� html footer 
/****************************/
$html_footer = Html_Footer();

/****************************/
//��˥塼���� create menu 
/****************************/
$page_menu = Create_Menu_h('sale','2');
/****************************/
//���̥إå������� create screen header 
/****************************/
$page_header = Create_Header($page_title);

// Render��Ϣ������ render related settings 
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign assign form related variable
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign assign other variables
$smarty->assign('var',array(
    'html_header'   => "$html_header",
    'page_menu'     => "$page_menu",
    'page_header'   => "$page_header",
    'html_footer'   => "$html_footer",
    'aord_id'       => "$aord_id",
    'input_flg'     => "$input_flg",
    'order_sheet'   => "$order_sheet",
    'freeze_flg'    => "$freeze_flg",
    "client_state_print"    => "$client_state_print",
));
$smarty->assign('item',$row_item);
$smarty->assign('row',$row_data);
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ� pass the value to the template 
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
