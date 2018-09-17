<?php

//���ʤΥ�󥿥븶�����֤��ޤ���
function Get_Goods_RentalCost($db_con,$goods_id){

	$sql = "
	SELECT
		t_price.r_price 
	FROM t_price 
	WHERE    t_price.goods_id = $goods_id  
		AND    t_price.shop_id  = 1  
		AND    t_price.rank_cd  = '6'  
	";

	$result = Db_Query($db_con, $sql);
	$price  = @pg_fetch_result($result,0,0);

	return $price;

}


//���ʥ����ɤ����󥿥븶����ɽ�����뤿���JS��������ޤ���
function Create_Js_Rcost($db_con){

	$sql = "
	SELECT
		t_goods.goods_cd,
		t_price.r_price 
	FROM
		t_goods 
	INNER JOIN t_price ON 
		t_goods.goods_id = t_price.goods_id
	WHERE    t_price.shop_id = 1  
		AND    t_price.rank_cd = '6'  
		AND    t_goods.accept_flg = '1'  
		AND    t_goods.rental_flg = 't'
	";

	$result = Db_Query($db_con, $sql);
	$goods_data = Get_Data($result,3);

	//���
	$count = count($goods_data);

	for($g=0;$g<$count;$g++){
		$goods_cd = $goods_data[$g][0]; //���ʥ�����
		$cost     = $goods_data[$g][1]; //��󥿥븶��

		$data .= "    data['$goods_cd']='$cost' \n";
	}


	$js = "
	function goods_rcost(cd){
		data = new Array($count);
		$data

		if(data[cd] == undefined){
			data[cd] = '';
		}
		return data[cd];
	}
	";

	return $js;

}







 /**
 * ��󥿥���Ͽ����ɽ������Ƚ��
 *
 * �ѹ�����
 * 1.0.0 (2006/09/06) ��������(suzuki-t)
 *
 * @version     1.0.0 (2006/09/06)
 *
 * @param               string      $db_con         DB���֥�������
 * @param               string      $rental_id      ��󥿥�ID   
 *
 * @return              string      $disp_stat[0]   ��󥿥���Ͽ���̼��̥ե饰
 *                                  1:��󥿥�ID̵��(�����Ͽ)
 *                                  2:����ѡ������
 *                                  3:������
 *                                  4:����ͽ��
 *                                  5:��ú�
 *                                  6:����������
 *
 *                                  $disp_stat[1]   ����饤��ե饰
 *                                  
 */

function Rental_display($db_con,$rental_id=false){

	//��󥿥�ID����Ƚ��
	if($rental_id != false){
		//��󥿥�����˱���������ɽ��

		//��󥿥����������饤��ե饰����
		$sql  = "SELECT ";
		$sql .= "    t_rental_d.rental_stat,";
		$sql .= "    t_rental_h.online_flg ";
		$sql .= "FROM ";
		$sql .= "    t_rental_d ";
		$sql .= "    INNER JOIN t_rental_h ON t_rental_h.rental_id = t_rental_d.rental_id ";
		$sql .= "WHERE ";
		$sql .= "    t_rental_h.rental_id = $rental_id;";
		$result = Db_Query($db_con, $sql);
		//GET�ǡ���Ƚ��
		Get_Id_Check($result);

		while($stat_num = pg_fetch_array($result)){
			//��󥿥�����������
			$stat = $stat_num[0];
			$stat_array[] = $stat;

			//����饤��ե饰
			$disp_stat[1] = $stat_num[1];
		}
		
		//���̷���Ƚ��
		if(in_array("21",$stat_array)){
			//������
			$disp_stat[0] = 3;
		}else if(in_array("22",$stat_array)){
			//����ͽ��
			$disp_stat[0] = 4;
		}else if(in_array("10",$stat_array) || in_array("20",$stat_array)){
			//����ѡ������
			$disp_stat[0] = 2;
		}else if(in_array("0",$stat_array)){
			//��ú�
			$disp_stat[0] = 5;
		}else if(in_array("11",$stat_array)){
			//����������
			$disp_stat[0] = 6;
		}

		//���ե饤��ξ��
		if($disp_stat[1] == "f"){
			$disp_stat[0] = 2;		
		}
		
	}else{
		//��󥿥�ID̵��
		$disp_stat[0] = 1;
		//���ե饤��
		$disp_stat[1] = 'f';
	}

	return $disp_stat;
}


 /**
 * ��󥿥���Ͽ(����)������¹Դؿ�
 *
 * �ѹ�����
 * 1.0.0 (2006/09/11) ��������(suzuki-t)
 *
 * @version     1.0.0 (2006/09/11)
 *
 * @param               object      $db_con         DB���֥�������
 * @param               string      $rental_id      ��󥿥�ID   
 * @param               boolean     $disp_flg       �¹Բ��̼��̥ե饰
 *                                  1:��󥿥���Ͽ(������) 
 *                                  2:��󥿥���Ͽ(����ѡ�����ѤΥ��ե饤��)
 *                                  3:CRON 
 *
 * @return              boolean     ������true
 *                                  ���ԡ�false
 *
 *                                  
 */
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/15      10-006      suzuki      ���̤�����������ʤ��ä���硢����ѥǡ�������
 *  2006/11/15      10-024      suzuki      ����ѡ�����ͽ��ζ�ۤ򹹿�
*/

function Rental_sql($db_con,$rental_id,$disp_flg=3){

	$today = date("Y-m-d");  //����������

	$sql  = "SELECT ";
	$sql .= "    rental_d_id,";            //��󥿥�ǡ���ID 0
	$sql .= "    line,";                   //�� 1
	$sql .= "    goods_id,";               //����ID 2
	$sql .= "    goods_cd,";               //����CD 3
	//$sql .= "    g_product_name,";         //����ʬ��̾ 4
	//$sql .= "    official_goods_name,";    //����̾(����) 5
	//$sql .= "    goods_name,";             //ά�� 6
	$sql .= "    g_product_id,";           //����ʬ��̾ 4
	$sql .= "    '',";                     //����̾(����) 5
	$sql .= "    goods_cname,";            //ά�� 6
	$sql .= "    num,";                    //���� 7
	$sql .= "    COALESCE(rental_price, 0),";           //��󥿥�ñ�� 8
	$sql .= "    COALESCE(rental_amount, 0),";          //��󥿥��� 9
	//$sql .= "    rental_price,";           //��󥿥�ñ�� 8
	//$sql .= "    rental_amount,";          //��󥿥��� 9
	$sql .= "    user_price,";             //�桼��ñ�� 10
	$sql .= "    user_amount,";            //�桼����� 11
	$sql .= "    serial_no,";              //���ꥢ���ֹ� 12
	$sql .= "    serial_flg,";             //���ꥢ������ե饰 13
	$sql .= "    rental_stat,";            //��󥿥���� 14
	$sql .= "    calcel_exec,";            //����»� 15
	$sql .= "    renew_num,";              //����� 16
	$sql .= "    calcel_day,";             //������ 17
	$sql .= "    exec_day, ";               //�»��� 18
	$sql .= "    shop_price,";             //����å�ñ�� 19
	$sql .= "    shop_amount ";            //����å׶�� 20
	$sql .= "FROM ";
	$sql .= "    t_rental_d ";
	$sql .= "WHERE ";
	//���̼¹�Ƚ��
	if($disp_flg == 3){
		//CRON
		$sql .= "    rental_stat = '22' ";  //����ͽ��
		$sql .= "AND ";
		$sql .= "    exec_day = '$today' ";
	}else if($disp_flg == 1){
		//��󥿥���Ͽ����(������)
		$sql .= "    rental_stat = '21' ";  //������
	}else if($disp_flg == 2){
		//��󥿥���Ͽ����(����ѡ�����Ѥǥ��ե饤��)
		$sql .= "    rental_stat = '10' ";  //�����
	}else if($disp_flg == 4){
		//FC���ե饤��Ǥβ���

		$sql .= "( ";
		$sql .= "    (rental_stat = '22' AND exec_day = '$today' )";  //����ͽ��
		$sql .= "OR ";
		$sql .= "    (rental_stat = '21')";  //������
		$sql .= ") ";
	}
	$sql .= "AND ";   
	$sql .= "    (calcel_exec = '2' OR calcel_exec = '3') "; 
	$sql .= "AND ";  
	$sql .= "    rental_id = $rental_id;"; 
	$result = Db_Query($db_con, $sql);
	$ren_data = Get_Data($result,3);

	//��󥿥�ǡ�����Ͽ
	for($i = 0; $i < count($ren_data); $i++){

		//¨����ǡ����ǿ��̤�����������ʤ� or ����»����������Υǡ����ǿ��̤�����������ʤ� ��Ƚ��
		//if($ren_data[$i][7] > $ren_data[$i][16] && ($ren_data[$i][15] == 2 || ($ren_data[$i][15] == 3 && $disp_flg == 3))){

		//���̤�����������ʤ���Ƚ�� 
		if($ren_data[$i][7] > $ren_data[$i][16]){

			//���󤷤ʤ�ʬ��ǡ�������Ͽ
			$sql  = "INSERT INTO t_rental_d (";
			$sql .= "    rental_d_id,";            //��󥿥�ǡ���ID
			$sql .= "    rental_id,";              //��󥿥�ID
			$sql .= "    line,";                   //��
			$sql .= "    goods_id,";               //����ID
			$sql .= "    goods_cd,";               //����CD
			//$sql .= "    g_product_name,";         //����ʬ��̾
			//$sql .= "    official_goods_name,";    //����̾(����)
			//$sql .= "    goods_name,";             //ά��
			$sql .= "    g_product_id,";           //����ʬ��̾
			$sql .= "    goods_cname,";            //ά��
			$sql .= "    num,";                    //����
			$sql .= "    serial_no,";              //���ꥢ���ֹ�
			$sql .= "    serial_flg,";             //���ꥢ������ե饰
			$sql .= "    rental_price,";           //��󥿥�ñ��
			$sql .= "    rental_amount,";          //��󥿥���
			$sql .= "    user_price,";             //�桼��ñ��
			$sql .= "    user_amount,";            //�桼�����
			$sql .= "    shop_price,";             //����å�ñ��
			$sql .= "    shop_amount,";            //����å׶��
			$sql .= "    rental_stat,";            //��󥿥����
			$sql .= "    calcel_exec, ";           //����»�
			$sql .= "    calcel_id ";              //����ID
			$sql .= ")VALUES(";
			$sql .= "    (SELECT COALESCE(MAX(rental_d_id), 0)+1 FROM t_rental_d),";  
			$sql .= "    $rental_id,";
			$sql .= "    (SELECT COALESCE(MAX(line),0)+1 FROM t_rental_d WHERE rental_id = $rental_id),";  
			$sql .= "    ".$ren_data[$i][2].",";
			$sql .= "    '".$ren_data[$i][3]."',";
			$sql .= "    '".$ren_data[$i][4]."',";
			//$sql .= "    '".$ren_data[$i][5]."',";
			$sql .= "    '".$ren_data[$i][6]."',";
			$sql .= "    ".($ren_data[$i][7] - $ren_data[$i][16]).","; //���� - �����
			//���ꥢ���ֹ����Ƚ��
			if($ren_data[$i][12] != NULL){
				$sql .= "    '".$ren_data[$i][12]."',";
			}else{
				$sql .= "    NULL,";
			}
			$sql .= "    '".$ren_data[$i][13]."',";
			$sql .= "    ".$ren_data[$i][8].",";
			$sql .= "    ".($ren_data[$i][8] * ($ren_data[$i][7] - $ren_data[$i][16])).","; //��󥿥�ñ����(���� - �����)
			$sql .= "    ".$ren_data[$i][10].",";
			$sql .= "    ".($ren_data[$i][10] * ($ren_data[$i][7] - $ren_data[$i][16])).","; //�桼��ñ����(���� - �����)
			$sql .= "    ".$ren_data[$i][19].",";
			$sql .= "    ".($ren_data[$i][19] * ($ren_data[$i][7] - $ren_data[$i][16])).","; //����å�ñ����(���� - �����)
			$sql .= "    '10',";
			$sql .= "    '1',";
			$sql .= "    ".$ren_data[$i][0];
			$sql .= ");";

			$result = Db_Query($db_con, $sql);

			if($result == false){
				return false;
			}
		}

		//���󤹤�ǡ�������
		$sql  = "UPDATE t_rental_d SET ";
		$sql .= "    num = ".$ren_data[$i][16].",";
		$sql .= "    rental_amount = ".($ren_data[$i][8] * $ren_data[$i][16]).",";
		$sql .= "    user_amount = ".($ren_data[$i][10] * $ren_data[$i][16]).",";
		$sql .= "    shop_amount = ".($ren_data[$i][19] * $ren_data[$i][16]).",";

		//����»�Ƚ��
		if(($ren_data[$i][15] == 2) || ($disp_flg == 3 && $ren_data[$i][15] == 3)){
			//¨����orCRON�¹Ԥβ���ͽ��
			$sql .= "    rental_stat = '20',";    //�����
			$sql .= "    calcel_exec = '4',";     //����λ
			$sql .= "    renew_num = NULL,";      //�����
			$sql .= "    calcel_day = '$today' "; //������������������
		}else if($ren_data[$i][15] == 3 && $disp_flg != 3){
			//�������˲���
			$sql .= "    rental_stat = '22',";    //����ͽ��
			$sql .= "    permit_flg = 't' ";      //����ǧ�ե饰
		}
		$sql .= "WHERE ";
		$sql .= "    rental_d_id = ".$ren_data[$i][0].";";
		$result = Db_Query($db_con, $sql);

		if($result == false){
			return false;
		}
	}

	return true;
}

//��󥿥�ǡ����������ޤ���
function Delete_Rental_D($db_con,$rental_id){
	//��󥿥�ǡ�������
	$sql  = "DELETE FROM";
	$sql .= "    t_rental_d";
	$sql .= " WHERE";
	$sql .= "    rental_id = $rental_id";
	$sql .= ";";

	$result = Db_Query($db_con, $sql);
	if($result == false){
		Db_Query($db_con, "ROLLBACK");
		exit;
	}
}


//����ʬ�ࡢ����̾��ά�Ρ����ꥢ������ե饰���֤�
function Get_Goods_Info($db_con,$goods_id){
	//����ʬ�ࡦ����̾�μ���
	$sql  = "SELECT ";
	$sql .= "    t_g_product.g_product_name,";
	$sql .= "    (t_g_product.g_product_name || '��' || t_goods.goods_name) AS official_goods_name, ";
	$sql .= "    t_goods.goods_name,";
	$sql .= "    t_goods.serial_flg, ";
	$sql .= "    t_goods.goods_cname ";
	$sql .= "FROM ";
	$sql .= "    t_g_product ";
	$sql .= "    INNER JOIN t_goods ON t_goods.g_product_id = t_g_product.g_product_id ";
	$sql .= "WHERE ";
	$sql .= "    t_goods.goods_id = ".$goods_id.";";
	$result = Db_Query($db_con, $sql);
	$data = pg_fetch_array($result);
	
	//print_array($data);
	return $data;
}

//����ʬ��ID������ʬ��̾���֤�
function Get_G_Product_Info($db_con,$g_product_id){
	$sql  = "SELECT ";
	$sql .= "    t_g_product.g_product_id,";
	$sql .= "    t_g_product.g_product_name ";
	$sql .= "FROM ";
	$sql .= "    t_g_product ";
	$sql .= "WHERE ";
	$sql .= "    t_g_product.g_product_id = ".$g_product_id.";";
	$result = Db_Query($db_con, $sql);
	$data = pg_fetch_array($result);
	
	return $data;
}


 /**
 * ��󥿥�JS����
 *
 * �ѹ�����
 * 1.0.0 (2006/09/06) ��������(suzuki-t)
 *
 * @version     1.0.0 (2006/09/06)
 *
 * @param               string      $db_con         DB���֥�������
 *
 * @return              string      $java_sheet     ���ʾ������JS
 *                                  
 *                                  
 */

function Create_JS_Rental($db_con){

	//��󥿥�ñ������
	$sql  = "SELECT\n";
	$sql .= "   t_goods.goods_id,\n";
	$sql .= "   t_goods.goods_cd,\n";
	//$sql .= "   t_g_product.g_product_name || '��' || t_goods.goods_name,\n";
	$sql .= "   t_goods.goods_cname,\n";
	$sql .= "   t_price.r_price, \n";
	$sql .= "   t_goods.g_product_id, \n";
	$sql .= "   t_goods.name_change \n";
	$sql .= " FROM\n";
	$sql .= "   t_goods \n";
	$sql .= "   INNER JOIN t_g_product ON t_goods.g_product_id = t_g_product.g_product_id ";
	$sql .= "   INNER JOIN t_price ON t_goods.goods_id = t_price.goods_id\n";
	$sql .= " WHERE \n";
	$sql .= "   t_price.shop_id = 1 ";
	$sql .= " AND ";
	$sql .= "   t_price.rank_cd = '5' ";
	$sql .= " AND ";
	$sql .= "   t_goods.accept_flg = '1' ";
	$sql .= " AND ";
	$sql .= "   t_goods.rental_flg = 't' ";
	$sql .= " AND ";
	$sql .= "   t_goods.state = 1 ";
	$sql .= ";\n";
	$result = Db_Query($db_con, $sql);
	$goods_data = Get_Data($result,3);

	//TPL�˾��ʥǡ�������JS�򵭽�
	$java_sheet  = "function goods_display(id,cd,name,price1,price2,row,sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,coax,cost_coax){ \n";
	$java_sheet .= "	data = new Array(".count($goods_data)."); \n";
	for($g=0;$g<count($goods_data);$g++){
		//data[����CD] = array(����ID,����CD,����̾,��󥿥�ñ��)
		$java_sheet .= "	data['".$goods_data[$g][1]."'] = new Array(".$goods_data[$g][0].",".$goods_data[$g][1].",'".$goods_data[$g][2]."','".$goods_data[$g][3]."','".$goods_data[$g][4]."','".$goods_data[$g][5]."'); \n";
	}


if ($_SESSION[group_kind] == "1") {
	$cost = " (goods_rcost(code))";
} else {
	$cost = "data[code][3]";
}

$java_sheet  .= <<<GOODS

	var goods_id   = id+"["+row+"]";         //����ID
	var cd_name    = cd+"["+row+"]";         //���ʥ�����
	var g_name     = name+"["+row+"]";       //����̾
	var r_price_i  = price1+"["+row+"][i]";  //��󥿥�ñ��
	var r_price_d  = price1+"["+row+"][d]"; 
	var u_price_i  = price2+"["+row+"][i]";  //�桼��ñ��
	var u_price_d  = price2+"["+row+"][d]"; 
	var u_price_d  = price2+"["+row+"][d]"; 
	var g_product_id  = "form_g_product_id["+row+"]"; 
	var change_flg  = "form_g_product_id["+row+"]"; 

	//���ʥ�����¸��Ƚ��
	var code = document.dateForm.elements[cd_name].value;
	if(data[code] != undefined){
		//��������ǡ�����ƥե����������
		document.dateForm.elements[goods_id].value     = data[code][0];
		document.dateForm.elements[g_name].value       = data[code][2];
		document.dateForm.elements[g_product_id].value = data[code][4];

		if(data[code][5] == "1"){
			document.forms[0].elements[g_name].readOnly = false;		
		}else{
			document.forms[0].elements[g_name].readOnly = true;		
		}


		//ʸ����ʬ��
		var price_array = data[code][3].split("."); //��󥿥�ñ��
		var cost_array = $cost.split("."); //��󥿥븶��
		if(cost_array[0] == undefined) cost_array[0]='';
		if(cost_array[1] == undefined) cost_array[1]='';
		
		document.dateForm.elements[r_price_i].value = cost_array[0];
		document.dateForm.elements[r_price_d].value = cost_array[1];
		document.dateForm.elements[u_price_i].value = price_array[0];
		document.dateForm.elements[u_price_d].value = price_array[1];

		//��۷׻�JS
		Mult_double_ren(sale_num,s_price_i,s_price_d,sale_amount,c_price_i,c_price_d,cost_amount,coax,true,cost_coax);
    }else{
		//�����ǡ�����̵������NULL
		document.dateForm.elements[goods_id].value    = "";
		document.dateForm.elements[cd_name].value     = "";
		document.dateForm.elements[g_name].value      = "";
		document.dateForm.elements[sale_num].value    = "";
		document.dateForm.elements[r_price_i].value   = "";
		document.dateForm.elements[r_price_d].value   = "";
		document.dateForm.elements[u_price_i].value   = "";
		document.dateForm.elements[u_price_d].value   = "";
		document.dateForm.elements[cost_amount].value = "";
		document.dateForm.elements[sale_amount].value = "";
	}
	
	return true;
}


//��󥿥�в����Υե����������˸��ߤ����դ�ɽ�����������ˤϤ�������ɽ��������
function Forward_today(which,me,form_y,form_m,form_d,claim_y,claim_m){
	if (document.all || document.getElementById){
		which.style.backgroundColor="#FDFD66"
	}
	today   = new Date();
	Year    = today.getYear();
	Month   = today.getMonth()+1;
	Day     = today.getDate();

	var nextday = new Date(Year,Month,Day);
	today.setDate (today.getMonth () + 1); // �����������
	CYear       = nextday.getYear();
	CMonth      = nextday.getMonth()+1;

	var Y = form_y;
	var M = form_m;
	var D = form_d;
	//��󥿥�в�������Ƚ��
	if(me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
		//��󥿥�в���������������ɽ��
		me.elements[Y].value = Year;
		me.elements[M].value = Month;
		me.elements[D].value = Day;
		//���ʤ�0���դ���
		if(me.elements[M].value <= 9){
				me.elements[M].value = "0" + Month;
		}
		if(me.elements[D].value <= 9){
				me.elements[D].value = "0" + Day;
		}
		//��������������ɽ��
		me.elements[claim_y].value = CYear;
		me.elements[claim_m].value = CMonth;
		//���ʤ�0���դ���
		if(me.elements[claim_m].value <= 9){
				me.elements[claim_m].value = "0" + CMonth;
		}
	}
}

//��󥿥�в����Υե���������ư
//���ˤ����ͤ������ͤ�������ɽ��
function Rental_claim(me,name,next,length,for_y,for_m,claim_y,claim_m){
	var F1 = name;
	var F2 = next;
	
	var nextday = new Date(me.elements[for_y].value,me.elements[for_m].value,1);
	nextday.setDate (today.getMonth () + 1); // �����������
	CYear       = nextday.getYear();
	CMonth      = nextday.getMonth()+1;

	//��������������ɽ��
	me.elements[claim_y].value = CYear;
	me.elements[claim_m].value = CMonth;
	//���ʤ�0���դ���
	if(me.elements[claim_m].value <= 9){
			me.elements[claim_m].value = "0" + CMonth;
	}


	len = me.elements[F1].value.length;
	if(length==len){
		me.elements[F2].focus();
	}
}

//�ե����������ˡ����������դ�ɽ������
function onForm_nextday(which,me,form_y,form_m,form_d){
	if (document.all || document.getElementById){
		which.style.backgroundColor="#FDFD66"
	}
	today       = new Date();
    today.setDate (today.getDate () + 1); // 1���������

	Year    = today.getYear();
	Month   = today.getMonth()+1;
	Day     = today.getDate();
	var Y = form_y;
	var M = form_m;
	var D = form_d;
	//�������Ϥ���Ƥ��뤫
	if(me.elements[Y].value == "" && me.elements[M].value == "" && me.elements[D].value == ""){
		me.elements[Y].value = Year;
		me.elements[M].value = Month;
		me.elements[D].value = Day;
		//���ʤ�0���դ���
		if(me.elements[M].value <= 9){
				me.elements[M].value = "0" + Month;
		}
		if(me.elements[D].value <= 9){
				me.elements[D].value = "0" + Day;
		}
	}
}


GOODS;

	return $java_sheet;
}

?>