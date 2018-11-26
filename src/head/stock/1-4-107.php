<?php
/********************
 * �߸˰�ư����
 *
 *
 * �ѹ�����
 *    2006/07/10 (kaji)
 *      ��shop_gid��ʤ���
 *    2006/08/30 (watanabe-k)
 ********************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2007/04/03      B0702-028   kajioka-h   ̤��ǧ���ʤ��Ȥ���Х�����
 *                  B0702-029   kajioka-h   ̵�����ʤ��Ȥ���Х�����
 *  2007/06/05                  watanabe-k  ���ʤ����ϤǤ��ʤ��Х��ν���
 *  2007/06/05                  watanabe-k  ���ɲø�˥ե�����������ư���ʤ��Х��ν���
 *  2009/03/13                  hashimoto-y ���Ϥ������ʤȤϰ㤦���ʤ���ư�����Х��ν���
 *  2009/07/10                  aoyama-n    �߸˼�ʧ�Ȳ�ǰ�ư�μ�ʧ��ˡּ��Ҹˡפ�ɽ�������Х��ν���
 *  2009/10/12                  hashimoto-y �߸˴����ե饰�򥷥�å��̾��ʾ���ơ��֥���ѹ�
 */

$page_title = "�߸˰�ư����";

//�Ķ�����ե����� environment setting file
require_once("ENV_local.php");

//HTML_QuickForm����� create
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³ connect
$db_con = Db_Connect();

// ���¥����å� auth check
$auth       = Auth_Check($db_con);
// �ܥ���Disabled button
$disabled   = ($auth[0] == "r") ? "disabled" : null;

/****************************/
//�����ѿ����� acquire external variable
/****************************/
$shop_id     = $_SESSION["client_id"];   //�����ID trade partner ID
$staff_id    = $_SESSION["staff_id"];    //�����å�ID staff ID
$insert_flg  = $_GET["insert"];          //��Ͽ��ǧ��å�����ɽ���ե饰 register confirmatiom message display flag

/****************************/
//������� initial setting
/****************************/
//ɽ���Կ� display row number
if($_POST["max_row"] != NULL){
    $max_row = $_POST["max_row"];
}else{
    $max_row = 5;
}

//����Կ� delete number of rows
$del_history[] = NULL; 

//�߸˰�ư��˼����̤����ܤ�����硢��å�����ɽ�� if the screen transitioned from the goods movement to the next screen
if ($_POST["hdn_first"] == null && $insert_flg == true){
    $insert_msg = "��ư���ޤ�����";
    $form->addElement("hidden", "hdn_first", "1");
}else{
    $form->addElement("hidden", "hdn_first");
}


/****************************/
//�Կ��ɲý��� row addition process
/****************************/
if($_POST["add_row_flg"] == "true"){
	if($_POST["max_row"] == NULL){
		//����ͤ�POST��̵���١� because the initial value has no POST
		$max_row = 6;
	}else{
		//����Ԥˡܣ����� +1 to the maximum row
    	$max_row = $_POST["max_row"]+5;
	}
    //�Կ��ɲåե饰�򥯥ꥢ clear the row addition flag
    $add_row_data["add_row_flg"] = "";
    $form->setConstants($add_row_data);
}

/****************************/
//�Ժ������ row deletion process
/****************************/
if($_POST["del_row"] != ""){

    //����ꥹ�Ȥ���� acquire the deletion list
    $del_row = $_POST["del_row"];

    //������������ˤ��롣make array of the deletion history
    $del_history = explode(",", $del_row);


    //��������Կ� row number deleted
    $del_num     = count($del_history)-1;

}

//***************************/
//����Կ���hidden�˥��å� set the max row number to hidden
/****************************/
$max_row_data["max_row"] = $max_row;

$form->setConstants($max_row_data);

/****************************/
//���ʺ���(����) create parts (fixed)
/****************************/
//�߸˰�ư�� goods movement date
$text[] =& $form->createElement("text", "y", "",
        "size=\"4\" maxLength=\"4\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_move_day_day[y]', 'form_move_day[m]',4)\"
         onFocus=\"onForm_today(this,this.form,'form_move_day[y]','form_move_day[m]','form_move_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("text", "m", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onkeyup=\"changeText(this.form,'form_move_day[m]', 'form_move_day[d]',2)\"
         onFocus=\"onForm_today(this,this.form,'form_move_day[y]','form_move_day[m]','form_move_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$text[] =& $form->createElement("text", "d", "",
        "size=\"1\" maxLength=\"2\" style=\"$g_form_style\"
         onFocus=\"onForm_today(this,this.form,'form_move_day[y]','form_move_day[m]','form_move_day[d]')\"
         onBlur=\"blurForm(this)\""
);
$form->addGroup($text, "form_move_day", "", " - ");

//��ư���Ҹ�(����ɽ��) warehouse where the goods come from (list)
$select_value = Select_Get($db_con,'ware');
$form->addElement('select', 'form_org_move', '���쥯�ȥܥå���', $select_value,$g_form_option_select);
//��ư���Ҹ�(����ɽ��) warehouse where the goods go to (list)
$form->addElement('select', 'form_move', '���쥯�ȥܥå���', $select_value,$g_form_option_select);

//��ư���Ҹˤξ��ʤ�����ɽ�� display all the products of the warehouse where the goods will come from
$form->addElement("submit","form_show_button","��ư���Ҹˤξ��ʤ�����ɽ��");
//�Ҹ˰������ set warehouse at once
$form->addElement("submit","form_set_button","�Ҹ˰������");
//��ư(������1-4-107-1.php) move (page to go to 1-4-107-1.php)
$form->addElement("button","form_move_button","�ܡ�ư","onClick=\"javascript:Button_Submit('move_button_flg','#','true', this)\" $disabled");

//���ɲå�� row addition link
$form->addElement("link","add_row_link","","#","�ɲ�","
    onClick=\"javascript:Button_Submit_1('add_row_flg', '#foot', 'true', this);\""
);

//hidden
$form->addElement("hidden", "del_row");             //����� row deletion
$form->addElement("hidden", "add_row_flg");         //�ɲùԥե饰 row addition flag
$form->addElement("hidden", "max_row");             //����Կ� max row number
$form->addElement("hidden", "goods_search_row");    //���ʥ��������Ϲ� product code input row
$form->addElement("hidden", "ware_select_row1");    //��ư���Ҹ˥ץ����������ե饰 pull down seletion flag of the warehouse where the goods will come from
$form->addElement("hidden", "ware_select_row2");    //��ư���Ҹ˥ץ����������ե饰 pull down seletion flag of the warehouse where the goods will go to
$form->addElement("hidden", "move_button_flg");     //��ư�ܥ��󲡲�Ƚ�� determine if move button is pressed
// ���顼��å��������å�����hidden hidden for error message set
$form->addElement("text", "err_illegal_verify");    // ����POST invalid POST


/****************************/
//���ʥ��������� input product code
/****************************/
if($_POST["goods_search_row"] != null){

	//���ʥǡ������������� row that will acquire product data 
	$search_row = $_POST["goods_search_row"];

	$sql  = "SELECT \n";
    $sql .= "   t_goods.goods_id, \n";
    $sql .= "   t_goods.goods_cd, \n";
    $sql .= "   t_goods.goods_name, \n";
	$sql .= "   t_goods.unit \n";
    $sql .= "FROM \n";
    $sql .= "   t_goods \n";
    #2009-10-12 hashimoto-y
    #$sql .= "WHERE \n";
    #$sql .= "   goods_cd = '".$_POST["form_goods_cd"][$search_row]."' \n";
    #$sql .= "AND ";
    #$sql .= "   public_flg = 't' \n";
    #$sql .= "AND ";
    #$sql .= "   stock_manage = '1' \n";
    #$sql .= "AND ";
    #$sql .= "   accept_flg = '1' \n";
    #$sql .= "AND ";
    #$sql .= "   state IN ('1', '3') \n";
    #$sql .= "AND \n";
    #$sql .= "   goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) \n";
    #$sql .= ";";

    $sql .= "   INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";
    $sql .= "WHERE \n";
    $sql .= "   t_goods.goods_cd = '".$_POST["form_goods_cd"][$search_row]."' \n";
    $sql .= "AND ";
    $sql .= "   t_goods.public_flg = 't' \n";
    $sql .= "AND ";
    $sql .= "   t_goods_info.stock_manage = '1' \n";
    $sql .= "AND \n";
    $sql .= "t_goods_info.shop_id = $shop_id ";
    $sql .= "AND ";
    $sql .= "   t_goods.accept_flg = '1' \n";
    $sql .= "AND ";
    $sql .= "   t_goods.state IN ('1', '3') \n";
    $sql .= "AND \n";
    $sql .= "   t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) \n";
    $sql .= ";";

    $result = Db_Query($db_con, $sql);
    $data_num = pg_num_rows($result);

	//�ǡ�����¸�ߤ�����硢�ե�����˥ǡ�����ɽ�� if there is a data, display the data in form
	if($data_num == 1){
    	$goods_data = pg_fetch_array($result);

		$set_goods_data["hdn_goods_id"][$search_row]         = $goods_data[0];   //����ID product ID
		$goods_id                                            = $goods_data[0];   //POST���������Ҹ˽����ǻ��Ѥ���� because it will be used in warehouse process before POST
		$set_goods_data["form_goods_cd"][$search_row]        = $goods_data[1];   //����CD product code
		$set_goods_data["form_goods_cname"][$search_row]     = $goods_data[2];   //����̾ product name
		$set_goods_data["form_unit"][$search_row]            = $goods_data[3];   //ñ�� unit
	}else{
		//�ǡ�����̵�����ϡ������ initialize if there is no data
		$set_goods_data["hdn_goods_id"][$search_row]         = "";
		$set_goods_data["form_goods_cd"][$search_row]        = "";
		$set_goods_data["form_goods_cname"][$search_row]     = "";
		$set_goods_data["form_unit"][$search_row]            = "";
		$set_goods_data["form_bstock_num"][$search_row]      = "";                 
		$set_goods_data["form_brstock_num"][$search_row]     = "";
		$set_goods_data["form_astock_num"][$search_row]      = "";                 
		$set_goods_data["form_arstock_num"][$search_row]     = "";   
	}
	$set_goods_data["goods_search_row"]                      = "";
	$form->setConstants($set_goods_data);
}

/****************************/
//�Ҹ�������� warehouse selection process
/****************************/
//���ʥ����ɤ����Ϥ��줿���Ǥ������Ԥ� conduct process even if the product code is inputted
if($_POST["ware_select_row1"] != null || $_POST["ware_select_row2"] != null || $_POST["goods_search_row"] != null){
	//��ư������ư��μ���Ƚ�� determine which warehouse it comes from and it goes to
	if($_POST["ware_select_row1"] != null){
		//��ư���Ҹ� "from" warehouse
		$wname       = "form_b_ware";                            //��ư�����Ҹ�̾ name of the "from" warehouse 
		$sname       = "form_bstock_num";                        //��ư���κ߸˿�̾ number of units existing in the "from" warehouse
		$rname       = "form_brstock_num";                       //��ư���ΰ�����̾ number of units reserved in the "from" warehouse
		$search_row  = $_POST["ware_select_row1"];               //�߸˿����������� row that will acquire inventory number

		$all_ware_id = $_POST["form_org_move"];                  //��ư���Ҹˡʰ���ɽ���� "from" warehouse (list)
	}else if($_POST["ware_select_row2"] != null){
		//��ư���Ҹ� "to" warehouse
		$wname       = "form_a_ware";                            //��ư����Ҹ�̾ "to" warehouse name
		$sname       = "form_astock_num";                        //��ư��κ߸˿�̾ number of units existing in the "to" warehouse
		$rname       = "form_arstock_num";                       //��ư��ΰ�����̾ number of units reserved in the "to" warehouse
		$search_row  = $_POST["ware_select_row2"];               //�߸˿����������� row that will acquire inventory number

		$all_ware_id = $_POST["form_move"];                      //��ư���Ҹˡʰ���ɽ����
	}

	//�Ҹˤ����򤵤줿��ˡ����ʥ����ɤ����Ϥ�����硢���ʥ����ɤιԿ������
	if($_POST["goods_search_row"] != null){
		$search_row = $_POST["goods_search_row"];                //�߸˿�����������
		//��ư����¸��Ƚ��
		if($_POST["form_b_ware"][$search_row] != NULL){
			$wname       = "form_b_ware";                            //��ư�����Ҹ�̾
			$sname       = "form_bstock_num";                        //��ư���κ߸˿�̾
			$rname       = "form_brstock_num";                       //��ư���ΰ�����̾
			$all_ware_id = $_POST["form_org_move"];                  //��ư���Ҹˡʰ���ɽ����
			$b_ware_flg  = true;                                     //��ư������ư�褬ξ�����Ϥ���Ƥ��뤫Ƚ��ե饰
		}
		//��ư���¸��Ƚ��
		if($_POST["form_a_ware"][$search_row] != NULL){
			$wname       = "form_a_ware";                            //��ư����Ҹ�̾
			$sname       = "form_astock_num";                        //��ư��κ߸˿�̾
			$rname       = "form_arstock_num";                       //��ư��ΰ�����̾
			$all_ware_id = $_POST["form_move"];                      //��ư���Ҹˡʰ���ɽ����
			$a_ware_flg  = true;                                     //��ư������ư�褬ξ�����Ϥ���Ƥ��뤫Ƚ��ե饰
		}	

	}else{
		//���ʥ����ɤ����Ϥ�����ˡ��Ҹˤ����򤷤����
		$goods_id   = $_POST["hdn_goods_id"][$search_row];           //����ID
	}
    $ware_id    = $_POST["$wname"][$search_row];                     //�Ҹ�ID
/*
	//����ɽ�������򤷤��Ҹˤȥǡ��������򤷤��Ҹˤ��㤦��Ƚ��
	if($all_ware_id != $ware_id){
		//�㤦���ϡ��������Ҹˤ�����
		$set_data["form_org_move"]                      = "";
		$set_data["form_move"]                          = "";
	}
*/


	//���ʤ��Ҹˤ����򤵤�Ƥ���н�������
	if($goods_id != NULL && $ware_id != NULL){
	    $sql  = "SELECT \n";
	    $sql .= "   stock_num, \n";
		$sql .= "   rstock_num \n";
	    $sql .= "FROM \n";
	    $sql .= "   t_stock \n";
	    $sql .= "WHERE \n";
	    $sql .= "   shop_id = $shop_id \n";
	    $sql .= "AND \n";
	    $sql .= "   ware_id = $ware_id \n";
	    $sql .= "AND \n";
	    $sql .= "   goods_id = $goods_id \n";
	    $sql .= ";";
	    $result = Db_Query($db_con, $sql);

		//�������뾦�ʤ˺߸ˤ����뤫
	    if(pg_num_rows($result) != 0){
	        $stock_num  = pg_fetch_result($result,0,0);
			$rstock_num = pg_fetch_result($result,0,1);
	    }
	    $set_data["$sname"][$search_row] = ($stock_num != NULL)? $stock_num : 0;      //���߸Ŀ�
		$set_data["$rname"][$search_row] = ($rstock_num != NULL)? $rstock_num : 0;    //������

        //aoyama 2009-07-08
        //�ѿ��ν����
        $stock_num = "";
        $rstock_num = "";

	}else{
		//���򤵤�Ƥ��ʤ����ϡ������
		$set_data["$sname"][$search_row] = "";                 
		$set_data["$rname"][$search_row] = "";   
	}

	//��ư������ư�褬ξ�����Ϥ���Ƥ����硢��ư�褷���߸˿���������Ƥ��ʤ��١���ư�����������
	if($b_ware_flg == true && $a_ware_flg == true){

		$wname       = "form_b_ware";                            //��ư�����Ҹ�̾
		$sname       = "form_bstock_num";                        //��ư���κ߸˿�̾
		$rname       = "form_brstock_num";                       //��ư���ΰ�����̾
		$ware_id     = $_POST["$wname"][$search_row];            //�Ҹ�ID

		//���ʤ��Ҹˤ����򤵤�Ƥ���н�������
		if($goods_id != NULL && $ware_id != NULL){
		    $sql  = "SELECT \n";
		    $sql .= "   stock_num, \n";
			$sql .= "   rstock_num \n";
		    $sql .= "FROM \n";
		    $sql .= "   t_stock \n";
		    $sql .= "WHERE \n";
		    $sql .= "   shop_id = $shop_id \n";
		    $sql .= "AND \n";
		    $sql .= "   ware_id = $ware_id \n";
		    $sql .= "AND \n";
		    $sql .= "   goods_id = $goods_id \n";
		    $sql .= ";";
		    $result = Db_Query($db_con, $sql);

			//�������뾦�ʤ˺߸ˤ����뤫
		    if(pg_num_rows($result) != 0){
		        $stock_num  = pg_fetch_result($result,0,0);
				$rstock_num = pg_fetch_result($result,0,1);
		    }
		    $set_data["$sname"][$search_row] = ($stock_num != NULL)? $stock_num : 0;      //���߸Ŀ�
			$set_data["$rname"][$search_row] = ($rstock_num != NULL)? $rstock_num : 0;    //������
		}else{
			//���򤵤�Ƥ��ʤ����ϡ������
			$set_data["$sname"][$search_row] = "";                 
			$set_data["$rname"][$search_row] = "";   
		}

	}
	
	$set_data["ware_select_row1"]                      = "";
	$set_data["ware_select_row2"]                      = "";
	$form->setConstants($set_data);

}

/****************************/
//��ư���Ҹˤξ��ʤ�����ɽ���ܥ��󲡲�����
/****************************/
if($_POST["form_show_button"] == "��ư���Ҹˤξ��ʤ�����ɽ��"){
	$org_ware_id = $_POST["form_org_move"];                //��ư���Ҹˡʰ���ɽ����
	$ware_id     = $_POST["form_move"];                    //��ư���Ҹˡʰ���ɽ����
	
	//��ư������ư�褬���򤵤�Ƥ�����Τ߽�����Ԥ�
	if($org_ware_id != NULL && $ware_id != NULL){
		//�оݤ��Ҹˤ������ʥǡ��������SQL
		$sql  = "SELECT \n";
	    $sql .= "   b_stock.goods_id, \n";
		$sql .= "   b_stock.goods_cd, \n";
		$sql .= "   b_stock.goods_name, \n";
		$sql .= "   b_stock.ware_id, \n";
		$sql .= "   b_stock.stock_num, \n";
		$sql .= "   b_stock.rstock_num, \n";
		$sql .= "   b_stock.unit, \n";
		$sql .= "   a_stock.ware_id, \n";
		$sql .= "   a_stock.stock_num, \n";
		$sql .= "   a_stock.rstock_num \n";
	    $sql .= "FROM \n";
	    $sql .= "   ( \n";
        $sql .= "       SELECT \n";
		$sql .= "           t_goods.goods_cd, \n";
		$sql .= "           t_goods.goods_name, \n";
		$sql .= "           t_ware.ware_id, \n";
		$sql .= "           t_stock.stock_num, \n";
		$sql .= "           t_stock.rstock_num, \n";
		$sql .= "           t_goods.unit, \n";
		$sql .= "           t_stock.goods_id \n";
		$sql .= "       FROM \n";
		$sql .= "           t_stock \n";
		$sql .= "           INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id \n";
		$sql .= "           INNER JOIN t_goods ON t_stock.goods_id = t_goods.goods_id \n";
        #2009-10-12 hashimoto-y
        $sql .= "           INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

	    $sql .= "       WHERE \n";
	    $sql .= "           t_stock.shop_id = $shop_id \n";
	    $sql .= "       AND \n";
	    $sql .= "           t_stock.ware_id = $org_ware_id \n";
		$sql .= "       AND \n";
	    $sql .= "           t_goods.public_flg = 't' \n";
	    $sql .= "       AND \n";
        #2009-10-12 hashimoto-y
	    #$sql .= "           t_goods.stock_manage = '1' \n";
        $sql .= "           t_goods_info.stock_manage = '1' \n";
        $sql .= "       AND \n";
        $sql .= "           t_goods_info.shop_id = $shop_id ";

	    $sql .= "       AND \n";
	    $sql .= "           t_goods.accept_flg = '1' \n";
	    $sql .= "       AND \n";
	    $sql .= "           t_goods.state IN ('1', '3') \n";
	    $sql .= "   ) \n";
        $sql .= "   AS b_stock \n";
		$sql .= "   LEFT JOIN \n";
		$sql .= "   ( \n";
        $sql .= "       SELECT \n";
		$sql .= "           t_ware.ware_id, \n";
		$sql .= "           t_stock.stock_num, \n";
		$sql .= "           t_stock.rstock_num, \n";
		$sql .= "           t_stock.goods_id \n";
		$sql .= "       FROM \n";
		$sql .= "           t_stock \n";
		$sql .= "           INNER JOIN t_ware ON t_stock.ware_id = t_ware.ware_id \n";
		$sql .= "           INNER JOIN t_goods ON t_stock.goods_id = t_goods.goods_id \n";
        #2009-10-12 hashimoto-y
        $sql .= "           INNER JOIN t_goods_info   ON t_goods.goods_id  = t_goods_info.goods_id \n";

	    $sql .= "       WHERE \n";
	    $sql .= "           t_stock.shop_id = $shop_id \n";
	    $sql .= "       AND \n";
	    $sql .= "           t_stock.ware_id = $ware_id \n";
		$sql .= "       AND \n";
	    $sql .= "           t_goods.public_flg = 't' \n";
	    $sql .= "       AND \n";
        #2009-10-12 hashimoto-y
	    #$sql .= "           t_goods.stock_manage = '1' \n";
        $sql .= "           t_goods_info.stock_manage = '1' \n";
        $sql .= "       AND \n";
        $sql .= "           t_goods_info.shop_id = $shop_id ";

	    $sql .= "   ) \n";
        $sql .= "   AS a_stock \n";
		$sql .= "   ON b_stock.goods_id = a_stock.goods_id \n";
		$sql .= "   ORDER BY \n";
        $sql .= "       b_stock.goods_cd \n";
        $sql .= ";";
	    $result = Db_Query($db_con, $sql);
		$data_list = Get_Data($result, 2);

		for($i=0;$i<count($data_list);$i++){
			$set_data["hdn_goods_id"][$i]     = $data_list[$i][0];  //����ID
			$set_data["form_goods_cd"][$i]    = $data_list[$i][1];  //����CD
			$set_data["form_goods_cname"][$i] = $data_list[$i][2];  //����̾
			$set_data["form_b_ware"][$i]      = $org_ware_id;       //��ư���Ҹ�
			$set_data["form_bstock_num"][$i]  = ($data_list[$i][4] != NULL)? $data_list[$i][4] : 0;  //���߸Ŀ��ʰ�ư����
			$set_data["form_brstock_num"][$i] = ($data_list[$i][5] != NULL)? $data_list[$i][5] : 0;  //�������ʰ�ư����
			$set_data["form_unit"][$i]        = $data_list[$i][6];  //ñ��
			$set_data["form_a_ware"][$i]      = $ware_id;           //��ư���Ҹ�
			$set_data["form_astock_num"][$i]  = ($data_list[$i][8] != NULL)? $data_list[$i][8] : 0;  //���߸Ŀ��ʰ�ư���
			$set_data["form_arstock_num"][$i] = ($data_list[$i][9] != NULL)? $data_list[$i][9] : 0;  //�������ʰ�ư���
		}
		//�����ʥǡ���ʬ�ιԿ������
		$max_row = count($data_list);
		$set_data["max_row"] = $max_row;                       //ɽ���Կ�
		$form->setConstants($set_data);

	}else{
		//��ư������ư�褬���򤵤�Ƥ��ʤ����ϥ��顼ɽ��
		if($org_ware_id == NULL){
			$warning1 = "��ư���Ҹˤ����򤷤Ʋ�������";
		}
		if($ware_id == NULL){
			$warning2 = "��ư���Ҹˤ����򤷤Ʋ�������";
		}
	}


/****************************/
//�������ܥ��󲡲�����
/****************************/
}elseif($_POST["form_set_button"] == "�Ҹ˰������"){

    //��ư���Ҹ�
    $bfr_ware_id = ($_POST["form_org_move"] != null)? $_POST["form_org_move"] : "null";

    //��ư���Ҹ�
    $aft_ware_id = ($_POST["form_move"] != null)? $_POST["form_move"] : "null";

    //����ɽ������Ƥ���������Ҹˤ򥻥åȤ��롣
    for($i = 0; $i < $max_row; $i++){
        //ɽ����Ƚ��
        if(!in_array("$i", $del_history)){
            $set_data["form_b_ware"][$i] = $bfr_ware_id;
            $set_data["form_a_ware"][$i] = $aft_ware_id;

            //���˾��ʤ����Ϥ���Ƥ�����
            if($_POST["hdn_goods_id"][$i] != null){
                $bfr_data = Get_Stock_Num($db_con, $_POST["hdn_goods_id"][$i], $bfr_ware_id);
                $atr_data = Get_Stock_Num($db_con, $_POST["hdn_goods_id"][$i], $aft_ware_id);

                //��ư��
                $set_data["form_bstock_num"][$i]  = $bfr_data[0];    //�߸˿�
                $set_data["form_brstock_num"][$i] = $bfr_data[1];    //������

                //��ư��
                $set_data["form_astock_num"][$i]  = $atr_data[0];    //�߸˿�
                $set_data["form_arstock_num"][$i] = $atr_data[1];    //������

            }
        }
    }

    $form->setConstants($set_data);
}

/****************************/
//��ư�ܥ��󲡲�����
/****************************/
if($_POST["move_button_flg"] == "true"){

    //hashimoto
    //�����ϳ��
    $goods_id = array();


    // �ե饰�򥯥ꥢ
    $clear_hdn_data["move_button_flg"] = "";
    $form->setConstants($clear_hdn_data);

	//�ǡ����������
	$move_day                     = $_POST["form_move_day"];         //��ư��
    for($i=0, $j=0; $i<$max_row; $i++){
        if($_POST["form_goods_cd"][$i] != null){
            $goods_id[$j]         = $_POST["hdn_goods_id"][$i];      //����ID
            $goods_cname[$j]      = $_POST["form_goods_cname"][$i];   //����̾
			$b_ware[$j]           = $_POST["form_b_ware"][$i];       //��ư���Ҹ�
			$bstock_num[$j]       = $_POST["form_bstock_num"][$i];   //���߸Ŀ��ʰ�ư����
			$brstock_num[$j]      = $_POST["form_brstock_num"][$i];  //�������ʰ�ư����
			$move_num[$j]         = $_POST["form_move_num"][$i];     //��ư��
			$a_ware[$j]           = $_POST["form_a_ware"][$i];       //��ư���Ҹ�
			$astock_num[$j]       = $_POST["form_astock_num"][$i];   //���߸Ŀ��ʰ�ư���
			$arstock_num[$j]      = $_POST["form_arstock_num"][$i];  //�������ʰ�ư���
            $j++;
        }
    }

	/****************************/
    //���顼�����å�(PHP)
    /****************************/
	$error_flg = false;                                         //���顼Ƚ��ե饰

    // �� ���ʥ����ɤ��Խ���˰�ư�ܥ��󤬲������줿�����н����
    // ��ư�ܥ��󤬲����줿�����ľ��ʸ����ե饰��������
    if ($_POST["move_button_flg"] == "true" && $_POST["goods_search_row"] != null){

        // ���������Կ������
        $search_row = $_POST["goods_search_row"];

        // hidden�ξ���ID����γ����Ԥ˾���ID����Ǽ����Ƥ�����
        if ($_POST["hdn_goods_id"][$search_row] != null){
            // hidden�˳�Ǽ����Ƥ��뾦��ID��POST���줿���ʥ����ɤ�������������å�
            $sql  = "SELECT \n";
            $sql .= "   goods_id \n";
            $sql .= "FROM \n";
            $sql .= "   t_goods \n";
            $sql .= "WHERE \n";
            $sql .= "   goods_id = ".$_POST["hdn_goods_id"][$search_row]." \n";
            $sql .= "AND \n";
            $sql .= "   goods_cd = '".$_POST["form_goods_cd"][$search_row]."' \n";
            $sql .= "AND ";
            $sql .= "   public_flg = 't' \n";
            #2009-10-12 hashimoto-y
            #$sql .= "AND ";
            #$sql .= "   stock_manage = '1' \n";

            $sql .= "AND \n";
            $sql .= "   goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id) \n";
            $sql .= "AND ";
            $sql .= "   shop_id = $shop_id \n";
            $sql .= ";";
            $res  = Db_Query($db_con, $sql);
            $num  = pg_num_rows($res);
            // ��̤�����POST�ե饰��
            $illegal_verify_flg = ($num > 0) ? false : true; 
        // hidden��������ID����γ���������������ID����Ǽ����Ƥ��ʤ����
        }else{  
            // ����POST�ե饰��true��
            $illegal_verify_flg = true; 
        }

        // ����POST�ե饰true�ξ��ϥ��顼�򥻥å�
        if ($illegal_verify_flg == true){
            $form->setElementError("err_illegal_verify", "���ʾ���������� ��ư�ܥ��� ��������ޤ�����<br>������ľ���Ƥ���������");
            $error_flg = true;
        }

    }

    //����ư��
    //Ⱦ�ѡ�ɬ�ܥ����å�
    $form->addGroupRule("form_move_day", array(
        "y"   => array(
                array($err_message, "required"),
                array($err_message, "numeric")
                ),
        "m"   => array(
                array($err_message, "required"),
                array($err_message, "numeric")
                ),
        "d"   => array(
                array($err_message, "required"),
                array($err_message, "numeric")
                ),
    ));

    //���������������å�
    if(!checkdate((int)$move_day[m], (int)$move_day[d], (int)$move_day[y])){
        $form->setElementError("form_move_day","��ư�������դ������ǤϤ���ޤ���");
    }else{
        //�����
        $sql  = "SELECT \n";
        $sql .= "   MAX(close_day) \n";
        $sql .= "FROM \n";
        $sql .= "   t_sys_renew \n";
        $sql .= "WHERE\n";
        $sql .= "   shop_id = $shop_id \n";
        $sql .= "AND \n";
        $sql .= "   renew_div = '2' \n";
        $sql .= ";";
        $result = Db_Query($db_con, $sql);
        $renew_date = pg_fetch_result($result,0,0);
        $renew_date = ($renew_date == null) ? START_DAY : $renew_date;

        $move_day[m] = str_pad($move_day[m],2,0,STR_PAD_LEFT);
        $move_day[d] = str_pad($move_day[d],2,0,STR_PAD_LEFT);
        $move_date = implode("-",$move_day);

        if($renew_date >= $move_date){
            $form->setElementError("form_move_day","��ư�������դ������ǤϤ���ޤ���");
        }
    }

	//������������å�
    for($i = 0; $i < count($goods_id); $i++){
        if($goods_cname[$i] != null){
           $input_error_flg = true;
        }
    }
    if($input_error_flg != true){
        $goods_error0 ="���ʤ���Ĥ����򤵤�Ƥ��ޤ���";
		$error_flg = true;
    }

    //��ư������ư������ư�����ϥ����å�
    for($i = 0; $i < count($goods_id); $i++){
		//ɬ�ܥ����å�
        if($goods_id[$i] != null && ($move_num[$i] == null || $b_ware[$i] == null || $a_ware[$i] == null)){
			$goods_error1 = "�߸˰�ư���Ϥ˰�ư���Ҹ�̾�Ȱ�ư���Ȱ�ư���Ҹ�̾��ɬ�ܤǤ���";
			$error_flg = true;
        }

        //hashimoto
        //�߸˿���ɽ����������˰�ư�򲡤������
        if($bstock_num[$i] == null || $brstock_num[$i] == null || $astock_num[$i] == null || $arstock_num[$i] == null){
            $goods_error1 = "��ư���Ҹˤ⤷���ϰ�ư���Ҹˤκ߸˿���������ɽ�����줿��ˡְ�ư�פ򥯥�å����Ʋ�������";
            $error_flg = true;
        }

        //��ư��Ⱦ�ѿ��������å�
        if(!ereg("^[0-9]+$",$move_num[$i]) && $move_num[$i] != null){
			$goods_error2 = "��ư����Ⱦ�ѿ����ΤߤǤ���";
			$error_flg = true;
        }

		//��ư���Ȱ�ư�褬Ʊ����Ƚ��
		if($b_ware[$i] == $a_ware[$i]){
			$goods_error3 = "��ư���ҸˤȰ�ư���Ҹˤ�Ʊ���Ǥ���";
			$error_flg = true;
		}
    }

	//���顼�ξ��Ϥ���ʹߤ�ɽ��������Ԥʤ�ʤ�
    if($error_flg == false && $form->validate()){
		Db_Query($db_con, "BEGIN");

		for($i = 0; $i < count($goods_id); $i++){
			//��ʧ�ơ��֥���Ͽ�ʰ�ư����
            $sql  = "INSERT INTO \n";
            $sql .= "   t_stock_hand \n";
            $sql .= "( \n";
            $sql .= "   goods_id, \n";
            $sql .= "   enter_day, \n";
            $sql .= "   work_day, \n";
            $sql .= "   work_div, \n";
            $sql .= "   ware_id, \n";
            $sql .= "   io_div, \n";
            $sql .= "   num, \n";
            $sql .= "   staff_id, \n";
            //aoyama-n 2009-07-10
            $sql .= "   client_cname,";
            $sql .= "   shop_id \n";
            $sql .= ") \n";
            $sql .= "VALUES \n";
            $sql .= "( \n";
            $sql .= "   $goods_id[$i], \n";
            $sql .= "   NOW(), \n";
            $sql .= "   '$move_date', \n";
            $sql .= "   '5', \n";
            $sql .= "   $b_ware[$i], \n";
            $sql .= "   '2', \n";
            $sql .= "   $move_num[$i], \n";
            $sql .= "   $staff_id, \n";
            //aoyama-n 2009-07-10
            //��ư���Ҹ�̾��Ĥ�
            $sql .= "   (SELECT ware_name FROM t_ware WHERE ware_id = $a_ware[$i]),";
            $sql .= "   $shop_id \n";
            $sql .= ") \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }

			//��ʧ�ơ��֥���Ͽ�ʰ�ư���
            $sql  = "INSERT INTO \n";
            $sql .= "   t_stock_hand \n";
            $sql .= "( \n";
            $sql .= "   goods_id, \n";
            $sql .= "   enter_day, \n";
            $sql .= "   work_day, \n";
            $sql .= "   work_div, \n";
            $sql .= "   ware_id, \n";
            $sql .= "   io_div, \n";
            $sql .= "   num, \n";
            $sql .= "   staff_id, \n";
            //aoyama-n 2009-07-10
            $sql .= "   client_cname,";
            $sql .= "   shop_id \n";
            $sql .= ") \n";
            $sql .= "VALUES \n";
            $sql .= "( \n";
            $sql .= "   $goods_id[$i], \n";
            $sql .= "   now(), \n";
            $sql .= "   '$move_date', \n";
            $sql .= "   '5', \n";
            $sql .= "   $a_ware[$i], \n";
            $sql .= "   '1', \n";
            $sql .= "   $move_num[$i], \n";
            $sql .= "   $staff_id, \n";
            //aoyama-n 2009-07-10
            //��ư���Ҹ�̾��Ĥ�
            $sql .= "   (SELECT ware_name FROM t_ware WHERE ware_id = $b_ware[$i]),";
            $sql .= "   $shop_id \n";
            $sql .= ") \n";
            $sql .= ";";
            $result = Db_Query($db_con, $sql);
            if($result == false){
                Db_Query($db_con, "ROLLBACK;");
                exit;
            }
		}

		Db_Query($db_con, "COMMIT;");
        header("Location: ./1-4-107.php?insert=true");
	}
}

/****************************/
//���ʺ����ʲ��ѡ�
/****************************/
//���ֹ楫����
$row_num = 1;
$select_value = Select_Get($db_con,'ware');
for($i = 0; $i < $max_row; $i++){
    //ɽ����Ƚ��
    if(!in_array("$i", $del_history)){
        $del_data = $del_row.",".$i;

		//���ʥ�����      
	    $form->addElement(
	        "text","form_goods_cd[$i]","","size=\"10\" maxLength=\"8\"
	        style=\"$g_form_style\" $g_form_option
	        onChange=\"goods_search_2(this.form, 'form_goods_cd', 'goods_search_row', $i, $row_num)\""
	    );

		//����̾
		$form->addElement(
	        "text","form_goods_cname[$i]","",
	        "size=\"34\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: left\" readonly'"
	    );

		//��ư���Ҹ�
		$form->addElement('select', "form_b_ware[$i]", '���쥯�ȥܥå���', $select_value,
			"onKeyDown=\"chgKeycode();\" onChange =\"goods_search_2(this.form, 'form_goods_cd', 'ware_select_row1', $i, $row_num);window.focus();\""
		);

        //�Ҹˤ����򤵤�Ƥ�����Ϥ��Τޤޡ����򤵤�Ƥ��ʤ����ϡ������������򤷤��Ҹˤ򥻥å�
        if($_POST["form_b_ware"][$i] != null){
            $set_data["form_b_ware"][$i] = $_POST["form_b_ware"][$i];   
        }elseif($_POST["add_row_flg"] == "true" && $i > $max_row-6){
            $set_data["form_b_ware"][$i] = $_POST["form_org_move"];
        }    
        $form->setConstants($set_data);

		//�߸˿�(��ư��)
		$form->addElement(
	        "text","form_bstock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//������(��ư��)
		$form->addElement(
	        "text","form_brstock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//��ư��
	    $form->addElement(
	        "text","form_move_num[$i]","",
	        "class=\"money\" size=\"11\" maxLength=\"5\" 
	        style=\"$g_form_style\" $g_form_option"
	    );

		//ñ��
		$form->addElement(
	        "text","form_unit[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: left\" readonly'"
	    );

		//��ư���Ҹ�
		$form->addElement('select', "form_a_ware[$i]", '���쥯�ȥܥå���', $select_value,
			"onKeyDown=\"chgKeycode();\" onChange =\"goods_search_2(this.form, 'form_goods_cd', 'ware_select_row2', $i, $row_num);window.focus();\""
		);

        //�Ҹˤ����򤵤�Ƥ�����Ϥ��Τޤޡ����򤵤�Ƥ��ʤ����ϡ������������򤷤��Ҹˤ򥻥å�
        if($_POST["form_a_ware"][$i] != null){
            $set_data["form_a_ware"][$i] = $_POST["form_a_ware"][$i];   
        }elseif($_POST["add_row_flg"] == "true" && $i > $max_row-6){
            $set_data["form_a_ware"][$i] = $_POST["form_move"];
        }    
        $form->setConstants($set_data);

		//�߸˿�(��ư��)
		$form->addElement(
	        "text","form_astock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//������(��ư��)
		$form->addElement(
	        "text","form_arstock_num[$i]","",
	        "size=\"11\"  
	        style=\"color : #000000; 
	        border : #ffffff 1px solid; 
	        background-color: #ffffff; 
	        text-align: right\" readonly'"
	    );

		//�������
		$form->addElement(
		    "link","form_search[$i]","","#","����",
		    "TABINDEX=-1 onClick=\"return Open_SubWin_2('../dialog/1-0-210.php', Array('form_goods_cd[$i]','goods_search_row'), 500, 450,'true',1,$i, $row_num);\""
		);

/*
		//������
		$form->addElement(
		    "link","form_del_row[$i]","",
		    "#","���","onClick=\"return Dialogue_1('������ޤ���', '$del_data', 'del_row');\""
		); 
*/
        //������
        //�ǽ��Ԥ��������硢���������κǽ��Ԥ˹�碌��
        if($row_num == $max_row-$del_num){
            $form->addElement(
                "link","form_del_row[$i]","",
                "#","���",
                "TABINDEX=-1 
                onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num-1);return false;\"");

        //�ǽ��԰ʳ����������硢�������Ԥ�Ʊ��NO�ιԤ˹�碌��
        }else{  
            $form->addElement(
                "link","form_del_row[$i]","","#",
                "���",
                "TABINDEX=-1 
                onClick=\"javascript:Dialogue_3('������ޤ���', '$del_data', 'del_row' ,$row_num);return false;\""
            ); 
        }       


		//����ID
	    $form->addElement("hidden","hdn_goods_id[$i]");

		/****************************/
        //ɽ����HTML����
        /****************************/
        $html .= "<tr class=\"Result1\">";
        $html .=    "  <A NAME=$row_num><td align=\"right\">$row_num</td>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cd[$i]"]]->toHtml();
        $html .=    "��";
        $html .=        $form->_elements[$form->_elementIndex["form_search[$i]"]]->toHtml();
        $html .=    "��";
        $html .=    "<br>";
        $html .=        $form->_elements[$form->_elementIndex["form_goods_cname[$i]"]]->toHtml();
        $html .=    "</td>";
		$html .=    "<td align=\"left\">";
	    $html .=        $form->_elements[$form->_elementIndex["form_b_ware[$i]"]]->toHtml();
	    $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_bstock_num[$i]"]]->toHtml();
		$html .=    "<br>";
		$html .=        $form->_elements[$form->_elementIndex["form_brstock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_move_num[$i]"]]->toHtml();
        $html .=    "</td>";
		$html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_unit[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"left\">";
        $html .=        $form->_elements[$form->_elementIndex["form_a_ware[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .=    "<td align=\"right\">";
        $html .=        $form->_elements[$form->_elementIndex["form_astock_num[$i]"]]->toHtml();
		$html .=    "<br>";
		$html .=        $form->_elements[$form->_elementIndex["form_arstock_num[$i]"]]->toHtml();
        $html .=    "</td>";
        $html .= "  <td align=\"center\">";
        $html .=        $form->_elements[$form->_elementIndex["form_del_row[$i]"]]->toHtml();
        $html .= "  </td>";
        $html .= "</tr>";

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
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);
/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/
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
	'html'          => "$html",
	'warning1'      => "$warning1",
	'warning2'      => "$warning2",
	'goods_error0'  => "$goods_error0",
	'goods_error1'  => "$goods_error1",
	'goods_error2'  => "$goods_error2",
	'goods_error3'  => "$goods_error3",
	'insert_msg'    => "$insert_msg",
));

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));




//���ʤ��Ҹˤ��Ȥκ߸˿��Ȱ����������
function Get_Stock_Num($db_con, $goods_id, $ware_id){

	$sql  = "SELECT \n";
	$sql .= "   stock_num, \n";
	$sql .= "   rstock_num \n";
	$sql .= "FROM \n";
	$sql .= "   t_stock \n";
	$sql .= "WHERE \n";
	$sql .= "   shop_id = ".$_SESSION["client_id"]." \n";
	$sql .= "AND \n";
	$sql .= "   ware_id = $ware_id \n";
	$sql .= "AND \n";
	$sql .= "   goods_id = $goods_id \n";
	$sql .= ";";
	$result = Db_Query($db_con, $sql);

    if(pg_num_rows($result) > 0){
        return pg_fetch_array($result, 0);
    }else{
        return array(0,0);
    }
}


?>
