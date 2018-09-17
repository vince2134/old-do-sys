<?php
/**
 * ���� ���Ҥ�������٥ơ��֥��������ޤ���
 *
 * ����
 *
 * @param array     $ary_sale_all_data   ������٥ǡ��� 
 * @param string    $num_sale_all        ���ٷ��
 * 
 * @return string HTML�ǡ���
 *
 */
function Op_All_Sale_Html($ary_sale_all_data,$num_sale_all=""){
	// �����ڥ졼���ǡ��������ʬ�롼��
	// $i 	�롼�ץ�����
	// $j 	���ϥơ��֥�ι��ֹ�
	
		if ($ary_sale_all_data == NULL) {
		$ary_sale_all_data[] = array();
	}
	
	if ($num_sale_all == "") {
		$num_sale_all = count($ary_sale_all_data);
	}

	for ($i=0, $j=0; $i<$num_sale_all; $i++){

		//ɽ��
		//�����ξ��
		if ($_SESSION[group_kind] == "1") {
			$t_title = array("���ô����");
		//FC�ξ��
		} else {
			$t_title = array("���ô����");
		}
		
		/* �ե�����ɥ��å����ν��� */
		// �ǽ�ιԤξ��
		if ($i == 0){
			$html .= "<font color=\"#555555\">���������</font>\n";
			$html .= "<table class=\"List_Table\" border=\"1\" width=\"915\">\n";
			$html .= "<col width=\"25\">\n";
			$html .= "<col width=\"120\">\n";
			$html .= "<col width=\"70\" span=\"10\">\n";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\" width=\"25\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"130\">".$t_title[0]."</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"85\">���׾���</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">���������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�ݾ�����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�����ǹ�<br>���</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">���ǹ����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�ǹ������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�������</td>\n";
			$html .= "  </tr>\n";
		}

		/* �����쥳���ɥǡ����ν��� */
		// �����������������ǡ����Τ��륪�ڥ졼���ξ���
		if ($ary_sale_all_data[$i][4] != null){
			$html .= "  <tr class=\"Result1\">\n";
			$html .= "      <td align=\"right\">".++$j."</td>\n";
			// ����ô���Ԥ������󻲾ȥǡ�����Ʊ�����
			// ô���Ԥ����󻲾ȥǡ�����Ʊ������ô����̾��ɽ�������ʤ��������Ѥ�äƤʤ�����
			if ($ary_sale_all_data[$i][2] == $ary_sale_all_data[$i-1][2] &&
				$ary_sale_all_data[$i][3] == $ary_sale_all_data[$i-1][3]){
				$html .= "<td></td>\n";
			}else{
				$html .= "<td>".htmlspecialchars($ary_sale_all_data[$i][3])."</td>\n";
			}
			$html .= "      <td align=\"center\">".$ary_sale_all_data[$i][4]."</td>\n";
			for ($a=5; $a<=13; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($ary_sale_all_data[$i][$a])."</td>\n";
			}
			$html .= "  </tr>\n";
		}

		// �ǽ��Ԥ��ġ����ֹ椬�ޤ�0��ɽ������쥳���ɤ�1���̵���ä��ˤξ��
		if ($i == $num_sale_all-1 && $j == 0){
			$html .= "  <tr class=\"Result1\">\n";
			// ɽ��������ʬ�롼��
			for ($k=0; $k<=11; $k++){
				$html .= "<td align=\"center\">-</td>\n";
			}
			$html .= "  </tr>\n";
		}

		/* ����ס����ڥ졼������פν����Ѥ˶�ۤ�û����Ƥ��� */
		for ($a=5; $a<=13; $a++){
			$c_part_total[$a] 	+= $ary_sale_all_data[$i][$a];	// �������
			$e_staff_total[$a]	+= $ary_sale_all_data[$i][$a];	// �������
		}

		/* ����פν��Ϣ��û����Ƥ�������פΥꥻ�å� */
		// ���󻲾ȹԤȼ��󻲾ȹԤ����𤬰ۤʤ롢�ޤ��Ϻǽ��Ԥξ��
		if ($ary_sale_all_data[$i][2] != $ary_sale_all_data[$i+1][2] || $i == $num_sale_all-1){
			$html .= "  <tr class=\"Result2\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>�����</b></td>\n";
			for ($a=5; $a<=13; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($c_part_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			for ($a=5; $a<=13; $a++){
				$c_part_total[$a] = 0;
			}
		}

		/* ����פν��� */
		// �ǽ��Ԥξ��
		if ($i == $num_sale_all-1){
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>�����</b></td>\n";
			for ($a=5; $a<=13; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($e_staff_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			$html .= "</table>\n";
			$html .= "<br>\n";
			// �������פ�ꥻ�å�
			for ($a=5; $a<=13; $a++){
				$e_staff_total[$a] = 0;
			}
		}
	}

	return $html;

}


/**
 * ���� ���Ҥλ������٥ơ��֥��������ޤ���
 *
 * ����
 *
 * @param array     $ary_sale_all_data   �������٥ǡ��� 
 * @param string    $num_sale_all        ���ٷ��
 * 
 * @return string HTML�ǡ���
 *
 */
function Op_All_Buy_Html($ary_sale_all_data, $num_sale_all=""){

	if ($ary_sale_all_data == NULL) {
		$ary_sale_all_data[] = array();
	}

	if ($num_sale_all == "") {
		$num_sale_all = count($ary_sale_all_data);
	}

	// �����ڥ졼���ǡ��������ʬ�롼��
	// $i 	�롼�ץ�����
	// $j 	���ϥơ��֥�ι��ֹ�
	for ($i=0, $j=0; $i<$num_sale_all; $i++){

		/* �ե�����ɥ��å����ν��� */
		// �ǽ�ιԤξ��
		if ($i == 0){
			$html .= "<font color=\"#555555\">����������</font>\n";
			$html .= "<table class=\"List_Table\" border=\"1\" width=\"840\">\n";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\" width=\"25\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"130\">����ô����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"85\">������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�ݻ���</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">���������</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�ݾ�����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�����ǹ�<br>���</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">���ǹ����</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">�ǹ������</td>\n";
			$html .= "  </tr>\n";
		}

		/* �����쥳���ɥǡ����ν��� */
		// �����������������ǡ����Τ��륪�ڥ졼���ξ���
		if ($ary_sale_all_data[$i][4] != null){
			$html .= "  <tr class=\"Result1\">\n";
			$html .= "      <td align=\"right\">".++$j."</td>\n";
			// ����ô���Ԥ������󻲾ȥǡ�����Ʊ�����
			// ô���Ԥ����󻲾ȥǡ�����Ʊ������ô����̾��ɽ�������ʤ��������Ѥ�äƤʤ�����
			if ($ary_sale_all_data[$i][2] == $ary_sale_all_data[$i-1][2] &&
				$ary_sale_all_data[$i][3] == $ary_sale_all_data[$i-1][3]){
				$html .= "<td></td>\n";
			}else{
				$html .= "<td>".htmlspecialchars($ary_sale_all_data[$i][3])."</td>\n";
			}
			$html .= "      <td align=\"center\">".$ary_sale_all_data[$i][4]."</td>\n";
			for ($a=5; $a<=12; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($ary_sale_all_data[$i][$a])."</td>\n";
			}
			$html .= "  </tr>\n";
		}

		// �ǽ��Ԥ��ġ����ֹ椬�ޤ�0��ɽ������쥳���ɤ�1���̵���ä��ˤξ��
		if ($i == $num_sale_all-1 && $j == 0){
			$html .= "  <tr class=\"Result1\">\n";
			// ɽ��������ʬ�롼��
			for ($k=0; $k<=10; $k++){
				$html .= "<td align=\"center\">-</td>\n";
			}
			$html .= "  </tr>\n";
		}

		/* ����ס����ڥ졼������פν����Ѥ˶�ۤ�û����Ƥ��� */
		for ($a=5; $a<=12; $a++){
			$c_part_total[$a] 	+= $ary_sale_all_data[$i][$a];	// �������
			$e_staff_total[$a]	+= $ary_sale_all_data[$i][$a];	// �������
		}

		/* ����פν��Ϣ��û����Ƥ�������פΥꥻ�å� */
		// ���󻲾ȹԤȼ��󻲾ȹԤ����𤬰ۤʤ롢�ޤ��Ϻǽ��Ԥξ��
		if ($ary_sale_all_data[$i][2] != $ary_sale_all_data[$i+1][2] || $i == $num_sale_all-1){
			$html .= "  <tr class=\"Result2\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>�����</b></td>\n";
			for ($a=5; $a<=12; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($c_part_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			for ($a=5; $a<=12; $a++){
				$c_part_total[$a] = 0;
			}
		}

		/* ����פν��� */
		// �ǽ��Ԥξ��
		if ($i == $num_sale_all-1){
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>�����</b></td>\n";
			for ($a=5; $a<=12; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($e_staff_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			$html .= "</table>\n";
			$html .= "<br>\n";
			// �������פ�ꥻ�å�
			for ($a=5; $a<=12; $a++){
				$e_staff_total[$a] = 0;
			}
		}
	}
	return $html;

}


/**
 * ���� ���Ҥ��������٥ơ��֥��������ޤ���
 *
 * ����
 *
 * @param array     $ary_payin_all_data   �������٥ǡ��� 
 * @param string    $num_payin_all        ���ٷ��
 * 
 * @return string HTML�ǡ���
 *
 */
function Op_All_Payin_Html($ary_payin_all_data, $num_payin_all=""){

	if ($ary_payin_all_data == NULL) {
		$ary_payin_all_data[] = array();
	}

	if ($num_payin_all == "") {
		$num_payin_all = count($ary_payin_all_data);
	}


	$html .= "<font color=\"#555555\">����������</font>\n";
	$html .= "<table class=\"List_Table\" border=\"1\">\n";
	$html .= "<col width=\"25\">";
	$html .= "<col width=\"70\" span=\"6\">";
	$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
	$html .= "      <td class=\"Title_Green\">No.</td>\n";
	$html .= "      <td class=\"Title_Green\">������</td>\n";
	$html .= "      <td class=\"Title_Green\">����</td>\n";
	$html .= "      <td class=\"Title_Green\">��������</td>\n";
	$html .= "      <td class=\"Title_Green\">�������</td>\n";
	$html .= "      <td class=\"Title_Green\">����¾</td>\n";
	$html .= "      <td class=\"Title_Green\">�����</td>\n";
	$html .= "  </tr>\n";
	// ����쥳���ɿ�ʬ�롼��
	// y: ��No.
	for ($x=0, $y=0; $x<$num_payin_all; $x++){
			// ��������null�Ǥʤ����
			if ($ary_payin_all_data[$x][1] != null){
					$html .= "  <tr class=\"Result1\">\n";
					$html .= "      <td align=\"right\">".++$y."</td>\n";
					$html .= "      <td align=\"center\">".$ary_payin_all_data[$x][1]."</td>\n";
					// �����ʬ�Τߥ롼��
					for ($a=2; $a<=6; $a++){
							// �ʥ�С��ե����ޥåȤ�������
							$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_all_data[$x][$a])."</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// �ǽ��Ԥ��ġ����ֹ椬�ޤ�0��ɽ������쥳���ɤ�1���̵���ä��ˤξ��
			if ($x == $num_payin_all-1 && $y == 0){
					// ����쥳���ɽ��Ϥ�����˥ϥ��ե����᤿�Ԥ���Ϥ������Υ롼�פ�֥졼��
					$html .= "  <tr class=\"Result1\">";
					for ($a=0; $a<=6; $a++){
							$html .= "<td align=\"center\">-</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// �����ʬ�Τߥ롼��
			for ($a=2; $a<=6; $a++){
					// �����ʬ��û����Ƥ���
					$ary_payin_all_total[$a] += $ary_payin_all_data[$x][$a];
			}
	}
	// ��������פ����
	$html .= "  <tr class=\"Result3\">\n";
	$html .= "      <td></td>\n";
	$html .= "      <td><b>�����</b></td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[2])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[3])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[4])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[5])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[6])."</td>\n";
	$html .= "  </tr>";
	$html .= "</table>\n";

	return $html;
}


/**
 * ���� ���Ҥλ�ʧ���٥ơ��֥��������ޤ���
 *
 * ����
 *
 * @param array     $ary_payin_all_data   ��ʧ���٥ǡ��� 
 * @param string    $num_payin_all        ���ٷ��
 * 
 * @return string HTML�ǡ���
 *
 */
function Op_All_Payout_Html($ary_payin_all_data,$num_payin_all=""){

	if ($ary_payin_all_data == NULL) {
		$ary_payin_all_data[] = array();
	}

	if ($num_payin_all == "") {
		$num_payin_all = count($ary_payin_all_data);
	}

	$html .= "<font color=\"#555555\">����ʧ����</font>\n";
	$html .= "<table class=\"List_Table\" border=\"1\">\n";
	$html .= "<col width=\"25\">";
	$html .= "<col width=\"70\" span=\"6\">";
	$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
	$html .= "      <td class=\"Title_Green\">No.</td>\n";
	$html .= "      <td class=\"Title_Green\">��ʧ��</td>\n";
	$html .= "      <td class=\"Title_Green\">�����ʧ</td>\n";
	$html .= "      <td class=\"Title_Green\">������ʧ</td>\n";
	$html .= "      <td class=\"Title_Green\">�����ʧ</td>\n";
	$html .= "      <td class=\"Title_Green\">����¾</td>\n";
	$html .= "      <td class=\"Title_Green\">�����</td>\n";
	$html .= "  </tr>\n";
	// ����쥳���ɿ�ʬ�롼��
	// y: ��No.
	for ($x=0, $y=0; $x<$num_payin_all; $x++){
			// ��������null�Ǥʤ����
			if ($ary_payin_all_data[$x][1] != null){
					$html .= "  <tr class=\"Result1\">\n";
					$html .= "      <td align=\"right\">".++$y."</td>\n";
					$html .= "      <td align=\"center\">".$ary_payin_all_data[$x][1]."</td>\n";
					// �����ʬ�Τߥ롼��
					for ($a=2; $a<=6; $a++){
							// �ʥ�С��ե����ޥåȤ�������
							$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_all_data[$x][$a])."</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// �ǽ��Ԥ��ġ����ֹ椬�ޤ�0��ɽ������쥳���ɤ�1���̵���ä��ˤξ��
			if ($x == $num_payin_all-1 && $y == 0){
					// ����쥳���ɽ��Ϥ�����˥ϥ��ե����᤿�Ԥ���Ϥ������Υ롼�פ�֥졼��
					$html .= "  <tr class=\"Result1\">";
					for ($a=0; $a<=6; $a++){
							$html .= "<td align=\"center\">-</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// �����ʬ�Τߥ롼��
			for ($a=2; $a<=6; $a++){
					// �����ʬ��û����Ƥ���
					$ary_payin_all_total[$a] += $ary_payin_all_data[$x][$a];
			}
	}
	// ��������פ����
	$html .= "  <tr class=\"Result3\">\n";
	$html .= "      <td></td>\n";
	$html .= "      <td><b>�����</b></td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[2])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[3])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[4])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[5])."</td>\n";
	$html .= "      <td align=\"right\">".Minus_Numformat($ary_payin_all_total[6])."</td>\n";
	$html .= "  </tr>";
	$html .= "</table>\n";

	return $html;
}






/**
 * ���� ���ڥ졼�������٥ơ��֥��������ޤ���
 *
 * ����
 *
 * @param array     $ary_payout_select_data   ��ʧ���٥ǡ��� 
 * @param string    $num_payout_select        ���ٷ��
 * 
 * @return string HTML�ǡ���
 *
 */
function Op_Select_Html($ary_sale_select_data, $num_sale_select, $ary_payin_select_data, $num_payin_select){
	/*** ���ڥ졼����html�ǡ������� ***/
	// ���򤵤줿���ڥ졼�������쥳���ɿ�ʬ�롼��
	// $i 	�롼�ץ�����
	// $j 	���ϥơ��֥�ι��ֹ�
	for ($i=0, $j=0; $i<$num_sale_select; $i++){

		/* ���ڥ졼����ե�����ɥ��å����ν��� */
		// ���󻲾ȹԤȺ��󻲾ȹԤΥ��ڥ졼�����ۤʤ롢�ޤ��ϻ��ȹԤ�1���ܤξ��
		if ($ary_sale_select_data[$i][0] != $ary_sale_select_data[$i-1][0] || $i == 0){
			$html .= "<fieldset>\n";
			$html .= "<legend><span style=\"font: bold 15px; color: #555555;\">��".$ary_sale_select_data[$i][1]."��</span></legend>\n";
			$html .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
			$html .= "<col width=\"25\">\n";
			$html .= "<col width=\"120\">\n";
			$html .= "<col width=\"70\" span=\"10\">\n";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\">���ô����</td>\n";
			$html .= "      <td class=\"Title_Green\">���׾���</td>\n";
			$html .= "      <td class=\"Title_Green\">�������</td>\n";
			$html .= "      <td class=\"Title_Green\">�����</td>\n";
			$html .= "      <td class=\"Title_Green\">�����</td>\n";
			$html .= "      <td class=\"Title_Green\">���������</td>\n";
			$html .= "      <td class=\"Title_Green\">�ݾ�����</td>\n";
			$html .= "      <td class=\"Title_Green\">�����ǹ�<br>���</td>\n";
			$html .= "      <td class=\"Title_Green\">���ǹ����</td>\n";
			$html .= "      <td class=\"Title_Green\">�ǹ������</td>\n";
			$html .= "      <td class=\"Title_Green\">�������</td>\n";
			$html .= "  </tr>\n";
		}

		/* �����쥳���ɥǡ����ν��� */
		// �����������������ǡ����Τ��륪�ڥ졼���ξ���
		if ($ary_sale_select_data[$i][4] != null){
			$html .= "  <tr class=\"Result1\">\n";
			$html .= "      <td align=\"right\">".++$j."</td>\n";
			// ���ڥ졼��������ô���Ԥ������󻲾ȥǡ�����Ʊ�����
			if ($ary_sale_select_data[$i][0] == $ary_sale_select_data[$i-1][0] &&
				$ary_sale_select_data[$i][2] == $ary_sale_select_data[$i-1][2] &&
				$ary_sale_select_data[$i][3] == $ary_sale_select_data[$i-1][3]){
				// ô����̾��ɽ�������ʤ�
				$html .= "<td></td>\n";
			// ���ڥ졼��������ô���Ԥ������󻲾ȥǡ�����Ʊ���Ǥʤ����
			}else{
				// ô����̾��ɽ��
				$html .= "<td>".$ary_sale_select_data[$i][3]."</td>\n";
			}
			$html .= "      <td align=\"center\">".$ary_sale_select_data[$i][4]."</td>\n";
			// �����ʬ�Τߥ롼��
			for ($a=5; $a<=13; $a++){
				// �ʥ�С��ե����ޥåȽ���
				$html .= "<td align=\"right\">".Minus_Numformat($ary_sale_select_data[$i][$a])."</td>\n";
			}
			$html .= "  </tr>\n";
		// �������̵���������ǡ�����̵�����ڥ졼���ξ���
		}else{
			$html .= "  <tr class=\"Result1\">\n";
			// ɽ��������ʬ�롼��
			for ($k=0; $k<=11; $k++){
				$html .= "<td align=\"center\">-</td>\n";
			}
			$html .= "  </tr>\n";
		}

		/* ����ס����ڥ졼������פν����Ѥ˶�ۤ�û����Ƥ��� */
		for ($a=5; $a<=13; $a++){
			$c_part_total[$a] 	+= $ary_sale_select_data[$i][$a]; 	// �������
			$e_staff_total[$a]	+= $ary_sale_select_data[$i][$a]; 	// ���ڥ졼�����������
		}

		/* ����פν��Ϣ��û����Ƥ�������פΥꥻ�å� */
		// ���󻲾ȹԤȼ��󻲾ȹԤΥ��ڥ졼���ޤ������𤬰ۤʤ롢�ޤ��Ϻǽ��Ԥξ��
		if ($ary_sale_select_data[$i][0] != $ary_sale_select_data[$i+1][0] ||
			$ary_sale_select_data[$i][2] != $ary_sale_select_data[$i+1][2] || $i == $num_sale_select-1){
			// ����פν���
			$html .= "  <tr class=\"Result2\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>�����</b></td>\n";
			// �����ʬ�Τߥ롼��
			for ($a=5; $a<=13; $a++){
				// �û����Ƥ�������פΥʥ�С��ե����ޥåȽ���
				$html .= "<td align=\"right\">".Minus_Numformat($c_part_total[$a])."</td>\n";
				// �û����Ƥ�������פΥꥻ�å�
				$c_part_total[$a] = 0;
			}
			$html .= "  </tr>\n";
		}

		/* ���ڥ졼��������פν��Ϣ��û����Ƥ������ڥ졼��������פΥꥻ�å� */
		// ���󻲾ȹԤȼ��󻲾ȹԤΥ��ڥ졼�����ۤʤ롢�ޤ��Ϻǽ��쥳���ɤξ��
		if ($ary_sale_select_data[$i][0] != $ary_sale_select_data[$i+1][0] || $i == $num_sale_select-1){
			// ���ڥ졼��������פν���
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>�����</b></td>\n";
			// �����ʬ�Τߥ롼��
			for ($a=5; $a<=13; $a++){
				// �û����Ƥ������ڥ졼��������פΥʥ�С��ե����ޥåȽ���
				$html .= "<td align=\"right\">".Minus_Numformat($e_staff_total[$a])."</td>\n";
				// �û����Ƥ������ڥ졼��������פΥꥻ�å�
				$e_staff_total[$a] = 0;
			}
			$html .= "  </tr>\n";
			$html .= "</table>\n";

			/* ����ǡ����ν��� */
			$html .= "<br>\n";
			$html .= "<table class=\"List_Table\" border=\"1\">\n";
			$html .= "<col width=\"25\">";
			$html .= "<col width=\"70\" span=\"6\">";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\">������</td>\n";
			$html .= "      <td class=\"Title_Green\">����</td>\n";
			$html .= "      <td class=\"Title_Green\">��������</td>\n";
			$html .= "      <td class=\"Title_Green\">�������</td>\n";
			$html .= "      <td class=\"Title_Green\">����¾����</td>\n";
			$html .= "      <td class=\"Title_Green\">�����</td>\n";
			$html .= "  </tr>\n";
			// ���򤵤줿���ڥ졼��������쥳���ɿ�ʬ�롼��
			$y = 0;
			for ($x=0; $x<$num_payin_select; $x++){
				// ���߻��Ȥ��Ƥ��륪�ڥ졼�������ǡ����ˤȡ����߻��Ȥ��Ƥ��륪�ڥ졼��������ǡ����ˤ�Ʊ�����
				if ($ary_sale_select_data[$i][0] == $ary_payin_select_data[$x][0]){
					// ���߻��ȥ쥳���ɡ�����ˤ���������null�ǤϤʤ����
					if ($ary_payin_select_data[$x][1] != null){
						// ����쥳���ɽ���
						$html .= "  <tr class=\"Result1\">\n";
						$html .= "      <td align=\"right\">".++$y."</td>\n";
						$html .= "      <td align=\"center\">".$ary_payin_select_data[$x][1]."</td>\n";
						// �����ʬ�Τߥʥ�С��ե����ޥåȽ���
						for ($a=2; $a<=6; $a++){
							$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_select_data[$x][$a])."</td>\n";
						}
						$html .= "  </tr>\n";
						// �����ʬ��û����Ƥ���
						for ($a=2; $a<=6; $a++){
							$ary_payin_total[$a] += $ary_payin_select_data[$x][$a];
						}
					// ���߻��ȥ쥳���ɡ�����ˤ���������null�ξ��
					}else{
						// ����쥳���ɽ��Ϥ�����˥ϥ��ե����᤿�Ԥ���Ϥ������Υ롼�פ�֥졼��
						$html .= "  <tr class=\"Result1\">";
						for ($a=0; $a<=6; $a++){
							$html .= "<td align=\"center\">-</td>\n";
						}
						$html .= "  </tr>\n";
						break;
					}
				}
			}
			// ���߻��Ȥ��Ƥ��륪�ڥ졼��������ǡ�������פ����
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td><b>�����</b></td>\n";
			for ($a=2; $a<=6; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_total[$a])."</td>\n";
			}
			// ����ǡ���������������ꥻ�å�
			$ary_payin_total = array();
			$html .= "  </tr>";
			$html .= "</table>\n";
			$html .= "</fieldset>\n";
			$html .= "<br>\n";
			$html .= ($i != $num_sale_select-1) ? " </td></tr><tr><td>\n" : null;
			$j = 0;
		}
	}

	return $html;
}
?>