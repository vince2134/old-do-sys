<?php
/*
 * ����
 *  ����            BɼNo.      ô����      ����
 *  -----------------------------------------------------------
 *  2006/12/07      02-014      kajioka-h   GET�ο��ͥ����å��ɲ�
 *                  ssl-0052    kajioka-h   ���ê���ΤȤ�����������������������ۤ�ɽ������褦�ˤ���
 *                  ssl-0053    kajioka-h   CSV�Ρ����Ҹ�̾�פ�����Ҹˡפˤ���
 *  2006/12/09      02-025      kajioka-h   ê��������SQL��shop_id�ǹʤ����褦�˽���
 *                  02-026      kajioka-h   ���ҸˤΥơ��֥뤬�Ͷ�ʬ�ǤޤȤޤäƤ��ʤ��ä��Τ���
 *                  02-027      kajioka-h   �߸�ñ����ê����ۡ�����߸˶�ۡ����������ۤ򾮿�2��ޤ�ɽ������褦��
 *  2007/01/30      0070,0071   kajioka-h   ���Ҹˤ�ê��ñ����ñ��˹�פ���Ƥ���Τ�ʿ��ñ����ɽ������褦�˽���
 *  2016/01/22                amano  Button_Submit �ؿ��ǥܥ���̾�������ʤ� IE11 �Х��б�  
 */

$page_title = "ê������";

//�Ķ�����ե�����
require_once("ENV_local.php");

//HTML_QuickForm�����
$form =& new HTML_QuickForm( "dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB��³
$db_con = Db_Connect();

// ���¥����å�
$auth       = Auth_Check($db_con);

// ���ܥ����������
$back_url = ($_SESSION["group_kind"] == "1") ? "./1-4-205.php" : "./2-4-205.php";

//���ꥢ�ܥ����������
$clear_url = ($_SESSION["group_kind"] == "1") ? "./1-4-206.php" : "./2-4-206.php";


/****************************/
//������¹Դؿ�
/****************************/
function Get_Inv_Data($result){
    $g_goods      = "";                    //�Ͷ�ʬ�����
    $result_count = pg_numrows($result);   //���ǿ�
	$count = 0;                            //�Ͷ�ʬ��ɽ��������

    for($i = 0; $i < $result_count; $i++){
        $inv_data[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
//print_array($inv_data[$i]);
		//�Ͷ�ʬ��ɽ��Ƚ��
		if($inv_data[$i][1] != $g_goods && $i != 0){
			$row[$i+$count][0] = $inv_data[$i][0];         //�Ҹ�̾
			$row[$i+$count][1] = "�Ͷ�ʬ��";
			$row[$i+$count][2] = number_format($b_money, 2);  //ê����۹��
			$row[$i+$count][3] = number_format($a_money, 2);  //����ê����۹�� 
			//�Ҹ˷���
			$total_b_money = bcadd($total_b_money, $b_money, 2);
			$total_a_money = bcadd($total_a_money, $a_money, 2);
			$count++;
			$b_money = 0;
			$a_money = 0;
		}

        for($j=0;$j<count($inv_data[$i]);$j++){
            //�Ͷ�ʬ
            if($j==1){
                //�ǽ�ιԤ��Ͷ�ʬ���Ѥ�ä����ˡ�����ˣͶ�ʬ����     
                if($i==0 || $g_goods != $inv_data[$i][$j]){
                    $g_goods = $inv_data[$i][$j];
                    $inv_array = $inv_data[$i][$j];
                }else{
                    //���ιԤ�Ʊ������ά����
                    $inv_array = "";
                }
			//�ʳ��ι���
            }else{
				//ê�����
				if($j==5){
					//�Ͷ�ʬ�׷׻�
					$b_money = bcadd($b_money, $inv_data[$i][$j], 2);
				//����������
				}else if($j==9){
					//�Ͷ�ʬ�׷׻�
					$a_money = bcadd($a_money, $inv_data[$i][$j], 2);
				}

                //����Ƚ��
                if(is_numeric($inv_data[$i][$j])){
                    $inv_data[$i][$j] = number_format($inv_data[$i][$j], 2);
                }
                $inv_array = $inv_data[$i][$j];
            }
			//�ǡ���ɽ��
			//if($j == 4 || $j == 5 || $j == 7 || $j == 9){
			if($j == 3 || $j == 6 || $j == 8){
				$inv_array = number_format($inv_array);
			}
            $row[$i+$count][$j] = htmlspecialchars($inv_array);
        }
    }

	//�ǽ��ΣͶ�ʬ��ɽ��Ƚ��
	$row[$i+$count][0] = $inv_data[$i-1][0];         //�Ҹ�̾
	$row[$i+$count][1] = "�Ͷ�ʬ��";
	$row[$i+$count][2] = number_format($b_money, 2);   //ê����۹��
	$row[$i+$count][3] = number_format($a_money, 2);   //����ê����۹�� 
	//�Ҹ˷���
	$total_b_money = bcadd($total_b_money, $b_money, 2);
	$total_a_money = bcadd($total_a_money, $a_money, 2);
	$count++;

	//�Ҹ˷�ɽ��
	$row[$i+$count][0] = $inv_data[$i-1][0];             //�Ҹ�̾
	$row[$i+$count][1] = "�Ҹ˷�";
	$row[$i+$count][2] = number_format($total_b_money, 2);  //ê����۹��
	$row[$i+$count][3] = number_format($total_a_money, 2);  //����ê����۹�� 

    return $row;
}

function Get_Inv_Data2($result){
    $g_goods      = "";                    //�Ͷ�ʬ�����
    $result_count = pg_numrows($result);   //���ǿ�
    $count = 0;                            //�Ͷ�ʬ��ɽ��������

    for($i = 0; $i < $result_count; $i++){
        $inv_data[$i] = @pg_fetch_array ($result, $i, PGSQL_NUM);
        //�Ͷ�ʬ��ɽ��Ƚ��
//        if($inv_data[$i][1] != $g_goods && $i != 0){
        if($inv_data[$i][0] != $g_goods && $i != 0){
/*
            $row[$i+$count][0] = $inv_data[$i][0];         //�Ҹ�̾
            $row[$i+$count][1] = "�Ͷ�ʬ��";
            $row[$i+$count][2] = number_format($b_money);  //ê����۹��
            $row[$i+$count][3] = number_format($a_money);  //����ê����۹�� 
*/
            $row[$i+$count][1] = "�Ͷ�ʬ��";
            $row[$i+$count][2] = number_format($b_money, 2);  //ê����۹��
            $row[$i+$count][3] = number_format($a_money, 2);  //����ê����۹�� 
            //�Ҹ˷���
            $total_b_money = bcadd($total_b_money, $b_money, 2);
            $total_a_money = bcadd($total_a_money, $a_money, 2);
            $count++;
            $b_money = 0;
            $a_money = 0;
        }

        for($j=0;$j<count($inv_data[$i]);$j++){
            //�Ͷ�ʬ
//            if($j==1){
            if($j==0){
                //�ǽ�ιԤ��Ͷ�ʬ���Ѥ�ä����ˡ�����ˣͶ�ʬ����
                if($i==0 || $g_goods != $inv_data[$i][$j]){
                    $g_goods = $inv_data[$i][$j];
                    $inv_array = $inv_data[$i][$j];
                }else{
                    //���ιԤ�Ʊ������ά����
                    $inv_array = "";
                }
            //�ʳ��ι���
            }else{
                //ê�����
//                if($j==5){
                if($j==4){
                    //�Ͷ�ʬ�׷׻�
                    $b_money = bcadd($b_money, $inv_data[$i][$j], 2);
                //����������
//                }else if($j==9){
                }else if($j==8){
                    //�Ͷ�ʬ�׷׻�
                    $a_money = bcadd($a_money, $inv_data[$i][$j], 2);
                }

                //����Ƚ��
                if(is_numeric($inv_data[$i][$j])){
                    $inv_data[$i][$j] = number_format($inv_data[$i][$j], 2);
                }
                $inv_array = $inv_data[$i][$j];
            }
			//�ǡ���ɽ��
			//if($j == 4 || $j == 5 || $j == 7 || $j == 9){
			if($j == 2 || $j == 5 || $j == 7){
				$inv_array = number_format($inv_array);
			}
            //�ǡ���ɽ��
            $row[$i+$count][$j] = htmlspecialchars($inv_array);
        }
    }

    //�ǽ��ΣͶ�ʬ��ɽ��Ƚ��
/*
    $row[$i+$count][0] = $inv_data[$i-1][0];         //�Ҹ�̾
    $row[$i+$count][1] = "�Ͷ�ʬ��";
    $row[$i+$count][2] = number_format($b_money);   //ê����۹��
    $row[$i+$count][3] = number_format($a_money);   //����ê����۹��
*/
    $row[$i+$count][1] = "�Ͷ�ʬ��";
    $row[$i+$count][2] = number_format($b_money, 2);   //ê����۹��
    $row[$i+$count][3] = number_format($a_money, 2);   //����ê����۹��
    //�Ҹ˷���
    $total_b_money = bcadd($total_b_money, $b_money, 2);
    $total_a_money = bcadd($total_a_money, $a_money, 2);
    $count++;

    //�Ҹ˷�ɽ��
/*
    $row[$i+$count][0] = $inv_data[$i-1][0];             //�Ҹ�̾
    $row[$i+$count][1] = "�Ҹ˷�";
    $row[$i+$count][2] = number_format($total_b_money);  //ê����۹��
    $row[$i+$count][3] = number_format($total_a_money);  //����ê����۹��
*/
    $row[$i+$count][1] = "�Ҹ˷�";
    $row[$i+$count][2] = number_format($total_b_money, 2);  //ê����۹��
    $row[$i+$count][3] = number_format($total_a_money, 2);  //����ê����۹��

    return $row;
}


/****************************/
//�����ѿ�����
/****************************/
$shop_id   = $_SESSION["client_id"];                  //�����ID
$invent_no = $_GET["invent_no"];                      //����Ĵ���ֹ�

//����Ĵ���ֹ��hidden�ˤ���ݻ�����
if($_GET["invent_no"] != NULL){
	Get_Id_Check3($_GET["invent_no"]);
	$set_id_data["hdn_invent_no"] = $invent_no;
	$form->setConstants($set_id_data);
}else{
	$invent_no = $_POST["hdn_invent_no"];
}
$last_no   = $invent_no - 1;                          //����Ĵ���ֹ�
//����Ĵ���ֹ�ˣ�������
$last_no = str_pad($last_no, 10, 0, STR_POS_LEFT);
//����Ĵ���ֹ�ˣ�������
$invent_no = str_pad($invent_no, 10, 0, STR_POS_LEFT);

/****************************/
//���������
/****************************/
$def_data["form_output_type"] = "1";

$form->setDefaults($def_data);

/****************************/
//�ե��������
/****************************/
//���Ϸ���
$form_output_type[] =& $form->createElement( "radio",NULL,NULL, "����","1");
$form_output_type[] =& $form->createElement( "radio",NULL,NULL, "CSV","2");
$form->addGroup($form_output_type, "form_output_type", "���Ϸ���");

//�о��Ҹ�
/*
$form->addElement(
    "text","form_ware","","size=\"22\" maxLength=\"10\" 
    $g_form_option"
);
*/
$select_value = Select_Get($db_con,'ware');
    $form->addElement('select', 'form_ware', '���쥯�ȥܥå���', $select_value,"onkeydown=\"chgKeycode();\" onChange=\"javascript:Button_Submit('stock_search_flg','#','true', this);window.focus();\"");

//���ܥ���
$form->addElement(
    "button","form_back_button","�ᡡ��","onClick=\"location.href='".$back_url."'\"");

//ɽ���ܥ���
$form->addElement("submit","show_button","ɽ����");

//���ꥢ�ܥ���
$form->addElement("button","clear_button","���ꥢ","onClick=\"location.href='".$clear_url."?invent_no=$invent_no'\"");

$form->addElement("hidden", "hdn_invent_no");         //����Ĵ���ֹ�

/****************************/
//ê��������
/****************************/
$sql  = "SELECT ";
$sql .= "   expected_day ";
$sql .= "FROM ";
$sql .= "   t_invent ";
$sql .= "WHERE ";
$sql .= "   invent_no = '$invent_no' "; 
$sql .= "   AND "; 
$sql .= "   shop_id = $shop_id;"; 
$result = Db_Query($db_con, $sql);
Get_Id_Check($result);
$h_data_list = Get_Data($result);
$invent_day = $h_data_list[0][0];

/****************************/
//ê��Ĵ��ɽ�ֹ���Ф��롢���Ҹ˷��
/****************************/
$sql  = "SELECT ";
$sql .= "   COUNT(b_invent.ware_cd) ";
$sql .= "FROM ";
$sql .= "   (SELECT ";
$sql .= "       t_invent.ware_id,";
$sql .= "       t_contents.goods_id,";
$sql .= "       t_invent.ware_name,";
$sql .= "       t_invent.ware_cd,";
$sql .= "       t_contents.g_goods_name,";
$sql .= "       t_contents.g_goods_cd,";
$sql .= "       t_contents.goods_name,";
$sql .= "       t_contents.goods_cd,";
$sql .= "       t_contents.tstock_num,";
$sql .= "       t_contents.price,";
$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
$sql .= "   FROM ";
$sql .= "       t_invent ";
$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "   WHERE ";
$sql .= "       t_invent.invent_no = '$invent_no' ";
if($_POST["form_ware"] != NULL){
    $sql .= "   AND ";
    //$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
}
$sql .= "   AND ";
$sql .= "       t_invent.shop_id = $shop_id ";
$sql .= "   )AS b_invent ";
$sql .= "GROUP BY ";
$sql .= "    b_invent.ware_cd ";
$sql .= "ORDER BY ";
$sql .= "   b_invent.ware_cd;";

$result = Db_Query($db_con,$sql);
$i=0;
$row_count = NULL;
while($row_count_list = pg_fetch_array($result)){
    $row_count[$i] = $row_count_list[0];
    $i++;
}

//�Ҹˤ��Ȥ˥ǡ����������
for($c=0;$c<count($row_count);$c++){
	/****************************/
	//ê�������ǡ�������
	/****************************/
	$sql  = "SELECT ";
	$sql .= "   b_invent.ware_name,";                                      //����ê�����Ҹ�̾
	$sql .= "   b_invent.g_goods_name,";                                   //����ê���ΣͶ�ʬ̾
	$sql .= "   b_invent.goods_name,";                                     //����ê���ξ���̾
	$sql .= "   b_invent.tstock_num,";                                     //����ê���μ�ê��
	$sql .= "   b_invent.price,";                                          //����ê����ñ��
	$sql .= "   b_invent.money,";                                          //����ê����ê�����
	$sql .= "   a_invent.tstock_num,";                                     //����ê���μ�ê��
	$sql .= "   a_invent.money,";                                          //����ê����ê�����
	$sql .= "   (b_invent.tstock_num - COALESCE(a_invent.tstock_num, 0)) AS comp_num,"; //���������
	$sql .= "   (b_invent.money - COALESCE(a_invent.money, 0)) AS comp_money ";         //����������
	$sql .= "FROM ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_invent.ware_name,";
	$sql .= "       t_invent.ware_cd,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       t_contents.price,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$invent_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS b_invent ";
	$sql .= "LEFT JOIN ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$last_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS a_invent ";
	        
	$sql .= "ON b_invent.ware_id = a_invent.ware_id ";
	$sql .= "AND ";
	$sql .= "b_invent.goods_id = a_invent.goods_id ";

	$sql .= "ORDER BY ";
	$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd ";

	//�Ҹˤ��ϰϻ���
	if($c==0){
	     //���ɽ���ʤ顢��Ƭ�ιԤ���ɽ����
	    $r_count = 0;
	}else{
	    //���������Ҹˤ�Կ�ʬɽ��
		$r_count = 0;
		$num = $c - 1;
	    while($num >= 0){
	        $r_count = $r_count + $row_count[$num];
	        $num--;
	    }
	}
	$sql .= " LIMIT ".$row_count[$c]." OFFSET ".$r_count.";";
//echo $sql."<br><br>";
	$result = Db_Query($db_con, $sql);
	$data_list[$c] = Get_Inv_Data($result);
}

/****************************/
//���Ҹˤ�ê�������ǡ�������
/****************************/
$sql  = "SELECT ";
//$sql .= "   b_invent.ware_name,";                                      //����ê�����Ҹ�̾
$sql .= "   b_invent.g_goods_name,";                                   //����ê���ΣͶ�ʬ̾
$sql .= "   b_invent.goods_name,";                                     //����ê���ξ���̾
$sql .= "   SUM(b_invent.tstock_num),";                                //����ê���μ�ê��
$sql .= "   b_invent.price,";                                          //����ê����ñ��
$sql .= "   SUM(b_invent.money),";                                     //����ê����ê�����
$sql .= "   SUM(a_invent.tstock_num),";                                //����ê���μ�ê��
$sql .= "   SUM(a_invent.money),";                                     //����ê����ê�����
//$sql .= "   (SUM(b_invent.tstock_num) - SUM(a_invent.tstock_num)),";   //���������
//$sql .= "   (SUM(b_invent.money) - SUM(a_invent.money)) ";             //����������
$sql .= "   (SUM(b_invent.tstock_num) - COALESCE(SUM(a_invent.tstock_num), 0)),";   //���������
$sql .= "   (SUM(b_invent.money) - COALESCE(SUM(a_invent.money), 0)) ";             //����������
$sql .= "FROM ";
$sql .= "   (SELECT ";
//$sql .= "       t_invent.ware_id,";
$sql .= "       t_contents.goods_id,";
//$sql .= "       t_invent.ware_name,";
//$sql .= "       t_invent.ware_cd,";
$sql .= "       t_contents.g_goods_name,";
$sql .= "       t_contents.g_goods_cd,";
$sql .= "       t_contents.goods_name,";
$sql .= "       t_contents.goods_cd,";
$sql .= "       SUM(t_contents.tstock_num) AS tstock_num,";
//$sql .= "       SUM(t_contents.price) AS price, ";
$sql .= "       CASE ";
$sql .= "           WHEN ";
$sql .= "               SUM(t_contents.tstock_num) != 0 ";
$sql .= "           THEN ROUND(SUM(t_contents.tstock_num * t_contents.price) / SUM(t_contents.tstock_num), 2) ";
$sql .= "           ELSE NULL ";
$sql .= "       END AS price, ";
$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
$sql .= "   FROM ";
$sql .= "       t_invent ";
$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "   WHERE ";
$sql .= "       t_invent.invent_no = '$invent_no' ";
$sql .= "   AND ";
$sql .= "       t_invent.shop_id = $shop_id ";
$sql .= "   GROUP BY ";
$sql .= "       t_contents.goods_id, ";
$sql .= "       t_contents.g_goods_name, ";
$sql .= "       t_contents.g_goods_cd, ";
$sql .= "       t_contents.goods_name, ";
$sql .= "       t_contents.goods_cd ";
$sql .= "   )AS b_invent ";
$sql .= "LEFT JOIN ";
$sql .= "   (SELECT ";
//$sql .= "       t_invent.ware_id,";
$sql .= "       t_contents.goods_id,";
$sql .= "       SUM(t_contents.tstock_num) AS tstock_num,";
$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
$sql .= "   FROM ";
$sql .= "       t_invent ";
$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
$sql .= "   WHERE ";
$sql .= "       t_invent.invent_no = '$last_no' ";
$sql .= "   AND ";
$sql .= "       t_invent.shop_id = $shop_id ";
$sql .= "   GROUP BY ";
$sql .= "       t_contents.goods_id ";
$sql .= "   )AS a_invent ";

$sql .= "ON ";
//$sql .= "b_invent.ware_id = a_invent.ware_id ";
//$sql .= "AND ";
$sql .= "b_invent.goods_id = a_invent.goods_id ";

//$sql .= "GROUP BY b_invent.ware_cd,b_invent.ware_name,b_invent.g_goods_cd,b_invent.g_goods_name,b_invent.goods_cd,b_invent.goods_name,b_invent.price ";
$sql .= "GROUP BY b_invent.g_goods_cd,b_invent.g_goods_name,b_invent.goods_cd,b_invent.goods_name,b_invent.price ";

$sql .= "ORDER BY ";
//$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd;";
$sql .= "   b_invent.g_goods_cd,b_invent.goods_cd;";
//echo $sql;
$total_result = Db_Query($db_con, $sql);
$total_list = Get_Inv_Data2($total_result);



/******************************/
//CSV���ϥܥ��󲡲�����
/*****************************/
if($_POST["show_button"] == "ɽ����" && $_POST["form_output_type"] == "2"){
    /** CSV����SQL **/
    $sql  = "SELECT ";
	$sql .= "   b_invent.ware_name,";                                      //����ê�����Ҹ�̾
	$sql .= "   b_invent.g_goods_name,";                                   //����ê���ΣͶ�ʬ̾
	$sql .= "   b_invent.goods_name,";                                     //����ê���ξ���̾
	$sql .= "   b_invent.tstock_num,";                                     //����ê���μ�ê��
	$sql .= "   b_invent.price,";                                          //����ê����ñ��
	$sql .= "   b_invent.money,";                                          //����ê����ê�����
	$sql .= "   a_invent.tstock_num,";                                     //����ê���μ�ê��
	$sql .= "   a_invent.money,";                                          //����ê����ê�����
//	$sql .= "   (b_invent.tstock_num - a_invent.tstock_num) AS comp_num,"; //���������
//	$sql .= "   (b_invent.money - a_invent.money) AS comp_money ";         //����������
	$sql .= "   (b_invent.tstock_num - COALESCE(a_invent.tstock_num, 0)) AS comp_num,"; //���������
	$sql .= "   (b_invent.money - COALESCE(a_invent.money, 0)) AS comp_money ";         //����������
	$sql .= "FROM ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_invent.ware_name,";
	$sql .= "       t_invent.ware_cd,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       t_contents.price,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$invent_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS b_invent ";
	$sql .= "LEFT JOIN ";
	$sql .= "   (SELECT ";
	$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_contents.tstock_num,";
	$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$last_no' ";
	if($_POST["form_ware"] != NULL){
    	$sql .= "   AND ";
    	//$sql .= "       t_invent.ware_name LIKE '%".$_POST["form_ware"]."%'";
	    $sql .= "       t_invent.ware_id = ".$_POST["form_ware"]." ";
	}
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
	$sql .= "   )AS a_invent ";
	        
	$sql .= "ON b_invent.ware_id = a_invent.ware_id ";
	$sql .= "AND ";
	$sql .= "b_invent.goods_id = a_invent.goods_id ";

	$sql .= "ORDER BY ";
	$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd;";

    $result = Db_Query($db_con,$sql);

    //CSV�ǡ�������
	//����ܤ�ê������Ĵ���ֹ��ɽ��
	$invent_data[0][0]  = $invent_day;
	$invent_data[0][1]  = $invent_no;
	$invent_data[0][2]  = $last_no;
	$invent_data[0][3]  = "��";
	$invent_data[0][4]  = "��";
	$invent_data[0][5]  = "��";
	$invent_data[0][6]  = "��";
	$invent_data[0][7]  = "��";
	$invent_data[0][8]  = "��";
	$invent_data[0][9]  = "��";
	$invent_data[0][10] = "��";
	$invent_data[0][11] = "��";
	$invent_data[0][12] = "��";
	
	//���Ҹ˥ǡ���ɽ��
    $i=1;
    while($data_list = pg_fetch_array($result)){
		$invent_data[$i][0]  = "��";
		$invent_data[$i][1]  = "��";
		$invent_data[$i][2]  = "��";
        //�Ҹ�̾
        $invent_data[$i][3] = $data_list[0];
        //�Ͷ�ʬ̾
        $invent_data[$i][4] = $data_list[1];
        //����̾
        $invent_data[$i][5] = $data_list[2];
        //ê����
        $invent_data[$i][6] = $data_list[3];
        //ê��ñ��
        $invent_data[$i][7] = $data_list[4];
		//ê�����
        $invent_data[$i][8] = $data_list[5];
		//����߸˿�
        $invent_data[$i][9] = $data_list[6];
		//����߸˶��
        $invent_data[$i][10] = $data_list[7];
		//���������
        $invent_data[$i][11] = $data_list[8];
		//����������
        $invent_data[$i][12] = $data_list[9];
        $i++;
    }

	$sql  = "SELECT ";
	//$sql .= "   b_invent.ware_name,";                                      //����ê�����Ҹ�̾
	$sql .= "   '���Ҹ�',";                                                //����ê�����Ҹ�̾
	$sql .= "   b_invent.g_goods_name,";                                   //����ê���ΣͶ�ʬ̾
	$sql .= "   b_invent.goods_name,";                                     //����ê���ξ���̾
	//$sql .= "   SUM(b_invent.tstock_num),";                                //����ê���μ�ê��
	$sql .= "   b_invent.tstock_num,";                                     //����ê���μ�ê��
	$sql .= "   b_invent.price,";                                          //����ê����ñ��
	//$sql .= "   SUM(b_invent.money),";                                     //����ê����ê�����
	//$sql .= "   SUM(a_invent.tstock_num),";                                //����ê���μ�ê��
	//$sql .= "   SUM(a_invent.money),";                                     //����ê����ê�����
	$sql .= "   b_invent.money,";                                          //����ê����ê�����
	$sql .= "   a_invent.tstock_num,";                                     //����ê���μ�ê��
	$sql .= "   a_invent.money,";                                          //����ê����ê�����
//	$sql .= "   (SUM(b_invent.tstock_num) - SUM(a_invent.tstock_num)),";   //���������
//	$sql .= "   (SUM(b_invent.money) - SUM(a_invent.money)) ";             //����������
	//$sql .= "   (SUM(b_invent.tstock_num) - COALESCE(SUM(a_invent.tstock_num), 0)),";   //���������
	//$sql .= "   (SUM(b_invent.money) - COALESCE(SUM(a_invent.money), 0)) ";             //����������
	$sql .= "   (b_invent.tstock_num - COALESCE(a_invent.tstock_num, 0)),";   //���������
	$sql .= "   (b_invent.money - COALESCE(a_invent.money, 0)) ";             //����������
	$sql .= "FROM ";
	$sql .= "   (SELECT ";
	//$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	//$sql .= "       t_invent.ware_name,";
	//$sql .= "       t_invent.ware_cd,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd,";
	//$sql .= "       t_contents.tstock_num,";
	//$sql .= "       t_contents.price,";
	//$sql .= "       (t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "       SUM(t_contents.tstock_num) AS tstock_num, ";
    $sql .= "       CASE ";
    $sql .= "           WHEN ";
    $sql .= "               SUM(t_contents.tstock_num) != 0 ";
    $sql .= "           THEN ROUND(SUM(t_contents.tstock_num * t_contents.price) / SUM(t_contents.tstock_num), 2) ";
    $sql .= "           ELSE NULL ";
    $sql .= "       END AS price, ";
	$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$invent_no' ";
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
    $sql .= "   GROUP BY ";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       t_contents.g_goods_name,";
	$sql .= "       t_contents.g_goods_cd,";
	$sql .= "       t_contents.goods_name,";
	$sql .= "       t_contents.goods_cd";
	$sql .= "   )AS b_invent ";
	$sql .= "LEFT JOIN ";
	$sql .= "   (SELECT ";
	//$sql .= "       t_invent.ware_id,";
	$sql .= "       t_contents.goods_id,";
	$sql .= "       SUM(t_contents.tstock_num) AS tstock_num, ";
	$sql .= "       SUM(t_contents.tstock_num * t_contents.price) AS money ";
	$sql .= "   FROM ";
	$sql .= "       t_invent ";
	$sql .= "       INNER JOIN t_contents ON t_invent.invent_id = t_contents.invent_id ";
	$sql .= "   WHERE ";
	$sql .= "       t_invent.invent_no = '$last_no' ";
	$sql .= "   AND ";
	$sql .= "       t_invent.shop_id = $shop_id ";
    $sql .= "GROUP BY ";
    $sql .= "       t_contents.goods_id ";
	$sql .= "   )AS a_invent ";

	//$sql .= "ON b_invent.ware_id = a_invent.ware_id ";
	//$sql .= "AND ";
    $sql .= "ON ";
	$sql .= "b_invent.goods_id = a_invent.goods_id ";

	//$sql .= "GROUP BY b_invent.ware_cd,b_invent.ware_name,b_invent.g_goods_cd,b_invent.g_goods_name,b_invent.goods_cd,b_invent.goods_name,b_invent.price ";

	$sql .= "ORDER BY ";
	//$sql .= "   b_invent.ware_cd,b_invent.g_goods_cd,b_invent.goods_cd;";
	$sql .= "   b_invent.g_goods_cd,b_invent.goods_cd;";

	$total_result = Db_Query($db_con, $sql);

	//���Ҹ˥ǡ���ɽ��
	while($csv_list = pg_fetch_array($total_result)){
		$invent_data[$i][0]  = "��";
		$invent_data[$i][1]  = "��";
		$invent_data[$i][2]  = "��";
	    //�Ҹ�̾
	    $invent_data[$i][3] = "���Ҹ�";
	    //�Ͷ�ʬ̾
	    $invent_data[$i][4] = $csv_list[1];
	    //����̾
	    $invent_data[$i][5] = $csv_list[2];
	    //ê����
	    $invent_data[$i][6] = $csv_list[3];
	    //ê��ñ��
	    //$invent_data[$i][7] = $csv_list[4];
	    $invent_data[$i][7] = ($csv_list[4] == null) ? "-" : $csv_list[4];
		//ê�����
	    $invent_data[$i][8] = $csv_list[5];
		//����߸˿�
	    $invent_data[$i][9] = $csv_list[6];
		//����߸˶��
	    $invent_data[$i][10] = $csv_list[7];
		//���������
	    $invent_data[$i][11] = $csv_list[8];
		//����������
	    $invent_data[$i][12] = $csv_list[9];
		$i++;
	}

    //CSV�ե�����̾
    $csv_file_name = "ê������".date("Ymd").".csv";
    //CSV�إå�����
    $csv_header = array(
        "ê����", 
        "ê��Ĵ���ֹ�",
        "����ê��Ĵ���ֹ�",
        "�Ҹ�̾",
        "�Ͷ�ʬ̾", 
        "����̾",
        "ê����",
        "ê��ñ��",
        "ê�����",
        "����߸˿�",
        "����߸˶��",
        "���������",
        "����������"
    );
    $csv_file_name = mb_convert_encoding($csv_file_name, "SJIS", "EUC");
    $csv_data = Make_Csv($invent_data, $csv_header);
    Header("Content-disposition: attachment; filename=$csv_file_name");
    Header("Content-type: application/octet-stream; name=$csv_file_name");
    print $csv_data;
    exit;
}

/*
print "<pre>";
print_r ($_POST);
print "</pre>";
*/

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
//$page_menu = Create_Menu_h('stock','2');
/****************************/
//���̥إå�������
/****************************/
$page_header = Create_Header($page_title);

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
    'invent_day'    => "$invent_day",
    'invent_no'     => "$invent_no",
    'last_no'       => "$last_no",
));

$smarty->assign('row',$data_list);      //�Ҹ˥ǡ���
$smarty->assign('total',$total_list);   //���Ҹ˥ǡ���
//�ƥ�ץ졼�Ȥ��ͤ��Ϥ�
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
