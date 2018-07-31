<?php

/******************************
 *  �ѹ�����
 *      ����2006-10-31��ά�Τˡ�,�פ����Ϥ���Ƥ�����ʤ��褦�˽�����suzuki-t��
 *      ����2007-05-08��������ά�Τ�Ʊ����硢�����ǡ������礷�Ƥ��ޤ��Զ�������morita-d��
 *      ����2007-05-31�˸������˾���ʬ����ɲá�morita-d��
 *
 *
******************************/
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/11/13      10-016      suzuki      ���ե饤����ɼ����ɽ���ˤ���
 *  2010/05/13      Rev.1.5     hashimoto-y ���ɽ���˸������ܤ���ɽ�����뽤��
*/

$page_title = "��󥿥�TO��󥿥�";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);


/****************************/
// �������������Ϣ
/****************************/
// �����ե�������������
$ary_form_list = array(
    "form_stat_check"   => array("stat1" => "1", "stat2" => "1", "stat3" => "1", "stat4" => "1", "stat5" => "1", "stat6" => "1"),
    "form_rental_no"    => "",
    "form_client"       => array("cd1" => "", "cd2" => ""), 
    "form_client_name"  => "",  
    "form_goods_cd"     => "",  
    "form_goods_cname"   => "",  
    "form_g_product_id"   => "",  
);

$module_no = Get_Mod_No();
if ($_SESSION[$module_no] != null){
    $ary_pass_list = array(
        "form_stat_check"   => array(
            "stat1" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat1"] == "1") ? "1" : ""),
            "stat2" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat2"] == "1") ? "1" : ""),
            "stat3" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat3"] == "1") ? "1" : ""),
            "stat4" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat4"] == "1") ? "1" : ""),
            "stat5" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat5"] == "1") ? "1" : ""),
            "stat6" => (($_SESSION[$module_no]["all"]["form_stat_check"]["stat6"] == "1") ? "1" : ""),
        ),      
    );
}else{
    $ary_pass_list = array(
        "form_stat_check"   => array(
            "stat1" => "1", 
            "stat2" => "1", 
            "stat3" => "1", 
            "stat4" => "1", 
            "stat5" => "1", 
            "stat6" => "1", 
        ),      
    );
}

// �����������
Restore_Filter2($form, array("contract", "rental"), "form_show_button", $ary_form_list, $ary_pass_list);


/****************************/
// �����ѿ�����
/****************************/
$shop_id    = $_SESSION["client_id"];
$staff_id   = $_SESSION["staff_id"];
$group_kind = $_SESSION["group_kind"];


/****************************/
// �����ɽ��
/****************************/
$form->setDefaults($ary_form_list);


/****************************/
// �ե�����ѡ������
/****************************/
// ����
$check = null;
$check[] =& $form->addElement("checkbox", "stat1", "", "����������");
$check[] =& $form->addElement("checkbox", "stat6", "", "��ú�");
$check[] =& $form->addElement("checkbox", "stat2", "", "�����");
$check[] =& $form->addElement("checkbox", "stat3", "", "������");
$check[] =& $form->addElement("checkbox", "stat4", "", "����ͽ��");
$check[] =& $form->addElement("checkbox", "stat5", "", "�����");
$form->addGroup($check, "form_stat_check", "");

// ��󥿥��ֹ�
$form->addElement("text", "form_rental_no", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// �桼��������
Addelement_Client_64($form, "form_client", "�桼��������", "-");

// �桼��̾
$form->addElement("text", "form_client_name", "", "size=\"34\" maxlength=\"15\" $g_form_option");

// ���ʥ�����
$form->addElement("text", "form_goods_cd", "", "size=\"10\" maxlength=\"8\" style=\"$g_form_style\" $g_form_option");

// ����̾
$form->addElement("text", "form_goods_cname", "", "size=\"28\" maxlength=\"35\" $g_form_option");

//����ʬ��ޥ���
$g_product_ary = Select_Get($db_con, 'g_product'); //����ʬ��ޥ���
$form->addElement('select', "form_g_product_id","", $g_product_ary);

// ɽ���ܥ���
$form->addElement("submit", "form_show_button", "ɽ����");

// ���ꥢ�ܥ���
$form->addElement("button", "form_clear_button", "���ꥢ", "onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");

// ��Ͽ�ʥإå���
$form->addElement("button", "input_btn", "�С�Ͽ", "onClick=\"location.href='2-1-141.php'\"");
// �����ʥإå���
$form->addElement("button", "disp_btn", "�졡��", "$g_button_color onClick=\"location.href='".$_SERVER["PHP_SELF"]."'\"");


/****************************/
// ɽ���ܥ��󲡲���
/****************************/

#2010-05-13 hashimoto-y
if($_POST["form_show_button"]=="ɽ����"){


if ($_POST["form_display"] != null){

    /****************************/
    // ���顼�����å�
    /****************************/
    # �ʤ�

    /****************************/
    // ���顼�����å���̽���
    /****************************/
    // �����å�Ŭ��
    $test = $form->validate();

    // ��̤�ե饰��
    $err_flg = (count($form->_errors) > 0) ? true : false;

    $post_flg = ($err_flg != true) ? true : false;

}


/****************************/
// POST���ѿ��˥��å�
/****************************/
if ($_POST != null){

    $stat_check1    = $_POST["form_stat_check"]["stat1"];
    $stat_check2    = $_POST["form_stat_check"]["stat2"];
    $stat_check3    = $_POST["form_stat_check"]["stat3"];
    $stat_check4    = $_POST["form_stat_check"]["stat4"];
    $stat_check5    = $_POST["form_stat_check"]["stat5"];
    $stat_check6    = $_POST["form_stat_check"]["stat6"];
    $rental_no      = $_POST["form_rental_no"];
    $client_cd1     = $_POST["form_client"]["cd1"];
    $client_cd2     = $_POST["form_client"]["cd2"];
    $client_name    = $_POST["form_client_name"];
    $goods_cd       = $_POST["form_goods_cd"];
    $goods_cname    = $_POST["form_goods_cname"];
    $g_product_id   = $_POST["form_g_product_id"];

    $post_flg = true;

}


/****************************/
// �����ǡ�������������
/****************************/
if ($post_flg == true && $err_flg != true){

    $sql  = null;

    // ����
    if ($stat_check1 != null || $stat_check2 != null || $stat_check3 != null || $stat_check4 != null || $stat_check5 != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        // ����������Ƚ��
        if ($stat_check1 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '11' \n";
        }
        // �����Ƚ��
        if ($stat_check2 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '10' \n";
        }
        // ������Ƚ��
        if ($stat_check3 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '21' \n";
        }
        // ����ͽ��Ƚ��
        if ($stat_check4 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '22' \n";
        }
        // �����Ƚ��
        if ($stat_check5 != null){
            $stat_sql[] = "       t_rental_d.rental_stat = '20' \n";
        }
	    // ��ú�Ƚ��
	    if ($stat_check6){
		    $stat_sql[] = "       t_rental_d.rental_stat = '0' \n";
	    }
        for ($i = 0; $i < count($stat_sql); $i++){
            if($i != 0){
                $sql .= "       OR \n";
            }
            $sql .= $stat_sql[$i];
        }
        $sql .= "   ) \n";
    }
    // ��󥿥��ֹ�
    $sql .= ($rental_no != null) ? "AND t_rental_h.rental_no LIKE '$rental_no%' \n" : null;
    // �桼�������ɣ�
    $sql .= ($client_cd1 != null) ? "AND t_rental_h.client_cd1 LIKE '$client_cd1%' \n" : null;
    // �桼�������ɣ�
    $sql .= ($client_cd2 != null) ? "AND t_rental_h.client_cd2 LIKE '$client_cd2%' \n" : null;
    //�桼��̾
    if($client_name != null){
        $sql .= "AND \n";
        $sql .= "   ( \n";
        $sql .= "       t_rental_h.client_name  LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
    	$sql .= "       t_rental_h.client_name2 LIKE '%$client_name%' \n";
        $sql .= "       OR \n";
	    $sql .= "       t_rental_h.client_cname LIKE '%$client_name%' \n";
        $sql .= "   ) \n";
    }
		
		
    // ����ʬ��
    $sql .= ($g_product_id != null) ? "AND t_rental_d.g_product_id = $g_product_id" : null;

    // ���ʥ�����
    $sql .= ($goods_cd != null) ? "AND t_rental_d.goods_cd LIKE '$goods_cd%' \n" : null;

    // ����̾
    $sql .= ($goods_cname != null) ? "AND t_rental_d.goods_cname LIKE '$goods_cname%' \n" : null;

/*
    // ����̾
    if ($goods_name != null){
        $sql .= "AND \n";
        $sql .= "( \n";
        $sql .= "   t_rental_d.goods_name LIKE '%$goods_name%' \n";
        $sql .= "   OR \n";
        $sql .= "   t_rental_d.official_goods_name LIKE '%$goods_name%' \n";
        $sql .= ") \n";
    }

 */
    $where_sql = $sql;

}


/****************************/
// �ǡ���ɽ�����ʺ�������
/****************************/
$sql  = "SELECT \n";
$sql .= "   t_rental_h.shop_id, \n";                            //����å�ID 0
$sql .= "   t_rental_h.shop_cd1, \n";                           //����å�CD1 1
$sql .= "   t_rental_h.shop_cd2, \n";                           //����å�CD2 2
$sql .= "   t_rental_h.shop_cname, \n";                         //����å�̾(ά��) 3
$sql .= "   t_rental_h.client_cname || ',' \n";                 //������̾(ά��),NO���Ȥ�rowspan��,������CD1,������CD2 4
$sql .= "   || t_count2.rowspan2 || ',' \n";  
$sql .= "   || CASE WHEN t_rental_h.client_cd1 IS NULL THEN '' \n";
$sql .= "           ELSE t_rental_h.client_cd1 \n";
$sql .= "      END || ',' \n";
$sql .= "   || CASE WHEN t_rental_h.client_cd2 IS NULL THEN '' \n";
$sql .= "           ELSE t_rental_h.client_cd2 \n";
$sql .= "      END, \n";
$sql .= "   t_rental_h.rental_id, \n";                          //��󥿥�ID 5
$sql .= "   t_rental_h.rental_no || ',' \n";
$sql .= "   || t_count.rowspan || ',' \n";
$sql .= "   || t_rental_h.rental_id, \n";                        //��󥿥��ֹ�,��󥿥��ֹ椴�Ȥ�rowspan��,��󥿥�ID 6
$sql .= "   t_rental_h.forward_day, \n";                        //�в��� 7
$sql .= "   t_rental_d.calcel_day, \n";                         //�ѹ����������� 8
$sql .= "   CASE t_rental_d.rental_stat \n";                    //��󥿥���� 9
$sql .= "        WHEN '0'  THEN '��ú�' \n";
$sql .= "        WHEN '10' THEN '�����' \n";
$sql .= "        WHEN '11' THEN '����������' \n";
$sql .= "        WHEN '20' THEN '�����' \n";
$sql .= "        WHEN '21' THEN '������' \n";
$sql .= "        WHEN '22' THEN '����ͽ��' \n";
$sql .= "   END, \n";
$sql .= "   t_rental_d.goods_id, \n";                           //����ID 10
$sql .= "   t_rental_d.goods_cd, \n";                           //����CD 11
//$sql .= "   t_rental_d.official_goods_name, \n";                //����̾ 12
$sql .= "   t_g_product.g_product_name || '��' || t_rental_d.goods_cname, \n";  //����̾ 12
$sql .= "   t_rental_d.num, \n";                                //���� 13
$sql .= "   t_rental_d.serial_no, \n";                          //���ꥢ��NO 14
$sql .= "   t_rental_d.shop_price, \n";                       //��󥿥�ñ�� 15
$sql .= "   t_rental_d.shop_amount, \n";                      //��󥿥��� 16
$sql .= "   t_rental_d.user_price, \n";                         //�桼��ñ�� 17
$sql .= "   t_rental_d.user_amount, \n";                        //�桼����� 18
$sql .= "   t_rental_h.note_fc \n";                             //����(����å���) 19
$sql .= "FROM \n";
$sql .= "   t_rental_h \n";
$sql .= "   INNER JOIN t_rental_d ON t_rental_h.rental_id = t_rental_d.rental_id \n";
$sql .= "   INNER JOIN t_goods ON t_rental_d.goods_id = t_goods.goods_id \n";
$sql .= "   INNER JOIN t_g_product ON t_rental_d.g_product_id = t_g_product.g_product_id \n";
$sql .= "   INNER JOIN \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_rental_d.rental_id, \n";
$sql .= "           count(t_rental_d.rental_d_id) AS rowspan \n";
$sql .= "       FROM \n";
$sql .= "           t_rental_d \n";
$sql .= "           INNER JOIN t_rental_h ON t_rental_h.rental_id = t_rental_d.rental_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_rental_h.shop_id = $shop_id \n";
if ($stat_check1 == null && $stat_check2 == null && $stat_check3 == null && $stat_check4 == null && $stat_check5 == null && $stat_check6 == null){
$sql .= "       AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20', '0') \n ";
}
$sql .=         $where_sql;
$sql .= "       GROUP BY \n";
$sql .= "           t_rental_d.rental_id \n";
$sql .= "   ) \n";
$sql .= "   AS t_count \n";
$sql .= "   ON t_count.rental_id = t_rental_h.rental_id \n";
$sql .= "   LEFT JOIN \n";
$sql .= "   ( \n";
$sql .= "       SELECT \n";
$sql .= "           t_rental_h.shop_id, \n";
$sql .= "           t_rental_h.client_id, \n";
$sql .= "           t_rental_h.client_cd1, \n";
$sql .= "           t_rental_h.client_cd2, \n";
$sql .= "           t_rental_h.client_cname, \n";
$sql .= "           count(t_rental_d.rental_d_id)AS rowspan2 \n";
$sql .= "       FROM \n";
$sql .= "           t_rental_d \n";
$sql .= "           INNER JOIN t_rental_h ON t_rental_h.rental_id = t_rental_d.rental_id \n";
$sql .= "       WHERE \n";
$sql .= "           t_rental_h.shop_id = $shop_id \n";
if ($stat_check1 == null && $stat_check2 == null && $stat_check3 == null && $stat_check4 == null && $stat_check5 == null && $stat_check6 == null){
$sql .= "       AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20', '0') \n ";
}
$sql .=         $where_sql;
$sql .= "       GROUP BY \n";
$sql .= "           t_rental_h.shop_id, \n";
$sql .= "           t_rental_h.client_id, \n";
$sql .= "           t_rental_h.client_cd1, \n";
$sql .= "           t_rental_h.client_cd2, \n";
$sql .= "           t_rental_h.client_cname \n";
$sql .= "   ) \n";
$sql .= "   AS t_count2 \n";
//�ʲ��ξ����ȡ������Υ��ե饤��ǡ����ȷ�礷�Ƥ��ޤ���
/*
$sql .= "   ON t_count2.shop_id = t_rental_h.shop_id \n";
$sql .= "   AND \n";
$sql .= "      t_count2.client_id = t_rental_h.client_id \n";
$sql .= "       ( \n";
$sql .= "           ( \n";
$sql .= "               t_count2.client_cname = t_rental_h.client_cname \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd1 IS NULL \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd2 IS NULL \n";
$sql .= "           ) \n";
$sql .= "           OR \n";
$sql .= "           ( \n";
$sql .= "               t_count2.client_cname = t_rental_h.client_cname \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd1 = t_rental_h.client_cd1 \n";
$sql .= "               AND \n";
$sql .= "               t_count2.client_cd2 = t_rental_h.client_cd2 \n";
$sql .= "           ) \n";
$sql .= "       ) \n";
*/
$sql .= "   ON t_count2.shop_id = t_rental_h.shop_id \n";
$sql .= "   AND \n";
$sql .= "      t_count2.client_id = t_rental_h.client_id \n";

$sql .= "WHERE \n";
//$sql .= "   t_rental_h.shop_id = $shop_id \n";
//$sql .= "AND ";
//$sql .= "    t_rental_h.online_flg = 't' \n";
$sql .= "    t_rental_h.regist_shop_id = $shop_id \n";
if ($stat_check1 == null && $stat_check2 == null && $stat_check3 == null && $stat_check4 == null && $stat_check5 == null && $stat_check6 == null){
//$sql .= "AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20') \n ";
$sql .= "       AND t_rental_d.rental_stat IN ('11', '10', '21', '22', '20', '0') \n ";
}
$sql .=     $where_sql;
$sql .= "ORDER BY \n";
$sql .= "   t_rental_h.shop_cd1, \n";
$sql .= "   t_rental_h.shop_cd2, \n";
$sql .= "   t_rental_h.client_cd1, \n";
$sql .= "   t_rental_h.client_cd2, \n";
$sql .= "   t_rental_h.rental_no, \n";
$sql .= "   t_rental_d.line \n";
$sql .= ";";
$result = Db_Query($db_con, $sql); 
$disp_data = Get_Data($result);
//print_array($_POST);

/****************************/
//�ǡ���ɽ�������ѹ�
/****************************/
$n_data_list = NULL;
for($x=0;$x<count($disp_data);$x++){
	$shop_num   = $disp_data[$x][0];     //����å�ID
	$client_num = $disp_data[$x][4];     //������̾(ά��),NO���Ȥ�rowspan��,������CD1,������CD2
	$rental_num = $disp_data[$x][6];     //��󥿥��ֹ�,��󥿥��ֹ椴�Ȥ�rowspan��

	//Ϣ���������Ͽ���롣$n_data_list[����å�ID][���������][��󥿥����]
	$n_data_list[$shop_num][$client_num][$rental_num][] = $disp_data[$x];

	$disp_data2[$shop_num][0] = $disp_data[$x][1]."-".$disp_data[$x][2];           //����å�CD
	$disp_data2[$shop_num][1] = $disp_data[$x][3];                                 //����å�̾
	$disp_data2[$shop_num][2] = $disp_data2[$shop_num][2] + $disp_data[$x][13];    //��󥿥��׿�
	$disp_data2[$shop_num][3] = $disp_data2[$shop_num][3] + $disp_data[$x][16];    //��󥿥��׳�
	$disp_data2[$shop_num][4] = $disp_data2[$shop_num][4] + $disp_data[$x][18];    //�桼���󶡳�
}

/****************************/
//HTML��������
/****************************/
//�ǡ�����������˺���
if($disp_data != NULL){
	//����åפ��Ȥ˷����֤�
	$html = NULL;

	while($shop_arr = each($n_data_list)){
		$shop = $shop_arr[0]; //����å�ID
		$no   = 1;            //�Ԥ�NO

		while($client_arr = each($n_data_list[$shop])){

		/* 2006-10-31 ά�Τˡ�,�פ����Ϥ���Ƥ�����ʤ��褦�˽��� */
		$client2 = explode(',',$client_arr[0]);  //������̾(ά��),NO���Ȥ�rowspan��,������CD1,������CD2

		//ά�Τˡ�,�פ����ä����ʬ�䤵��Ƥ���Τǡ�ʬ�䤵�줿ά�Τ�ʸ������
		for($c=0;$c<count($client2)-3;$c++){
			//�������Ƭ��Ƚ��
			if($c==0){
				//ʬ�䤷����Ƭ�ˤϡ�,�פ��դ��ʤ�
				$client[0] = $client2[$c];
			}else{
				//��Ƭ�ʳ��ϡ���,�פ�ʬ�䤵�줿�١�ʸ�������ˡ�,�פ��դ���
				$client[0] .= ",".$client2[$c];
			}
		}
		$client[1] = $client2[(count($client2)-3)]; //NO���Ȥ�rowspan��
		$client[2] = $client2[(count($client2)-2)]; //������CD1
		$client[3] = $client2[(count($client2)-1)]; //������CD2

			//��Ƚ��
			if(($no % 2) == 0){
				//������
				$html[$shop] .= "<tr class=\"Result2\">";
			}else{
				//�����
				$html[$shop] .= "<tr class=\"Result1\">";
			}

			//����ͽ����
			$sum_num = NULL;
			$rental_money = NULL;
			$user_money = NULL;
			
			//NO
			$html[$shop] .= "    <td  align=\"right\" rowspan=".($client[1]+1).">$no</td> ";
			//CD����Ƚ��Ƚ��
			if($client[2] != NULL){
				//����饤��

				//������
				$html[$shop] .= "    <td  align=\"left\" rowspan=".($client[1]+1).">".$client[2]."-".$client[3]."<br>".$client[0]."</td> ";
			}else{
				//���ե饤��

				//������
				$html[$shop] .= "    <td  align=\"left\" rowspan=".($client[1]+1).">".$client[0]."</td> ";
			}

			$ren_no = 0;    //��󥿥��ֹ椴�ȤιԿ�
			while($rental_arr = each($n_data_list[$shop][$client_arr[0]])){
				$rental = explode(',',$rental_arr[0]);  //��󥿥��ֹ�,��󥿥��ֹ椴�Ȥ�rowspan��,��󥿥�ID

				//<tr>Ƚ��
				if($ren_no != 0){
					//�����褴�Ȥΰ���ܰʳ���<tr>����Ϥ����
					//��Ƚ��
					if(($no % 2) == 0){
						//������
						$html[$shop] .= "<tr class=\"Result2\">";
					}else{
						//�����
						$html[$shop] .= "<tr class=\"Result1\">";
					}
				}

				//��󥿥��ֹ�
				$html[$shop] .= "<td  align=\"left\" rowspan=".$rental[1]."><a href='".FC_DIR."system/2-1-141.php?rental_id=".$rental[2]."'>".$rental[0]."</a></td>";
				//�в���
				$html[$shop] .= "<td  align=\"center\" rowspan=".$rental[1].">".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][0][7]."</td>";
				
				//��󥿥�ǡ������ȷ����֤�
				for($x=0;$x<count($n_data_list[$shop][$client_arr[0]][$rental_arr[0]]);$x++){

					//<tr>Ƚ��
					if($x!=0){
						//��󥿥��ֹ椴�Ȥΰ���ܰʳ���<tr>����Ϥ����
						//��Ƚ��
						if(($no % 2) == 0){
							//������
							$html[$shop] .= "<tr class=\"Result2\">";
						}else{
							//�����
							$html[$shop] .= "<tr class=\"Result1\">";
						}
					}

					//�ѹ���������
					$html[$shop] .= "<td  align=\"center\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][8]."</td>";
					
					//������font���顼Ƚ��
					switch($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]){
						//����
						case "����������" :
						case "������" :
							$html[$shop] .= "<td  align=\"center\" ><font color=red>".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]."</font></td>";
							break;
						case "�����" :
							$html[$shop] .= "<td  align=\"center\" ><font color=blue>".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]."</font></td>";
							break;
						default:
							//��ú�
	                        //�����
	                        //����ͽ��
							$html[$shop] .= "<td  align=\"center\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][9]."</td>";
					}

					//����̾
					$html[$shop] .= "<td  align=\"left\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][11]."<br>".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][12]."</td>";
					//����
					$html[$shop] .= "<td  align=\"right\" >".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][13])."</td>";
					//���ꥢ��
					$html[$shop] .= "<td  align=\"left\" >".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][14]."</td>";

					//��󥿥�ñ�������
					$html[$shop] .= "<td  align=\"right\" >".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][15],2).
					                "<br>".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][17],2)."</td>";
					//�桼��ñ�������
					$html[$shop] .= "<td  align=\"right\" >".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][16]).
					"<br>".number_format($n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][18])."</td>";

					//�����Ƚ��
					if($x==0){
						//����
						$html[$shop] .= "<td  align=\"left\" rowspan=".$rental[1].">".$n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][19]."</td>";
					}
					$html[$shop] .= "</tr>";

					//�����褴�Ȥι�׷׻�
					$sum_num    = $sum_num + $n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][13];   //����
					$rental_money = $rental_money + $n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][16];//��󥿥���
					$user_money   = $user_money + $n_data_list[$shop][$client_arr[0]][$rental_arr[0]][$x][18];  //�桼�����

				}
				$ren_no++;
			}
			
			//�����褴�Ȥι�׹�
			$html[$shop] .= "<tr class=\"Result3\">";
			$html[$shop] .= "    <td  align=\"center\"><b>���</b></td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "    <td  align=\"right\">".number_format($sum_num)."</td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "    <td  align=\"right\">".number_format($rental_money)."<br>".number_format($user_money)."</td>";
			$html[$shop] .= "    <td  >��</td>";
			$html[$shop] .= "</tr>";

			//���׷׻�
			$total_num = $total_num + $sum_num;
			$total_rental = $total_rental + $rental_money;
			$total_user = $total_user + $user_money;

			$no++;
		}
	}

	//��۷����ѹ�
	while($money_num = each($disp_data2)){
		$money = $money_num[0];
		$disp_data2[$money][2] = number_format($disp_data2[$money][2]);
		$disp_data2[$money][3] = number_format($disp_data2[$money][3]);
		$disp_data2[$money][4] = number_format($disp_data2[$money][4]);
	}
}


#2010-05-13 hashimoto-y
}

//print_array($n_data_list);
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
$page_menu = Create_Menu_f('system','1');

/****************************/
//���̥إå�������
/****************************/
$page_title .= "��".$form->_elements[$form->_elementIndex[input_btn]]->toHtml();
$page_title .= "��".$form->_elements[$form->_elementIndex[disp_btn]]->toHtml();
$page_header = Create_Header($page_title);

// Render��Ϣ������
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form��Ϣ���ѿ���assign
$smarty->assign('form',$renderer->toArray());

//����¾���ѿ���assign
$smarty->assign('var',array(
	'html_header'    => "$html_header",
	'page_menu'      => "$page_menu",
	'page_header'    => "$page_header",
	'html_footer'    => "$html_footer",
));

//ɽ���ǡ���
$smarty->assign("disp_data", $disp_data);
$smarty->assign("disp_data2",$disp_data2);
$smarty->assign("html", $html);

//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
