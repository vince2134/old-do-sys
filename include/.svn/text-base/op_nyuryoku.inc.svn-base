<?php
/**
 * 概要 全社の売上明細テーブルを作成します。
 *
 * 説明
 *
 * @param array     $ary_sale_all_data   売上明細データ 
 * @param string    $num_sale_all        明細件数
 * 
 * @return string HTMLデータ
 *
 */
function Op_All_Sale_Html($ary_sale_all_data,$num_sale_all=""){
	// 全オペレータデータ配列数分ループ
	// $i 	ループカウンタ
	// $j 	出力テーブルの行番号
	
		if ($ary_sale_all_data == NULL) {
		$ary_sale_all_data[] = array();
	}
	
	if ($num_sale_all == "") {
		$num_sale_all = count($ary_sale_all_data);
	}

	for ($i=0, $j=0; $i<$num_sale_all; $i++){

		//表題
		//本部の場合
		if ($_SESSION[group_kind] == "1") {
			$t_title = array("売上担当者");
		//FCの場合
		} else {
			$t_title = array("売上担当者");
		}
		
		/* フィールドセット等の出力 */
		// 最初の行の場合
		if ($i == 0){
			$html .= "<font color=\"#555555\">■売上明細</font>\n";
			$html .= "<table class=\"List_Table\" border=\"1\" width=\"915\">\n";
			$html .= "<col width=\"25\">\n";
			$html .= "<col width=\"120\">\n";
			$html .= "<col width=\"70\" span=\"10\">\n";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\" width=\"25\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"130\">".$t_title[0]."</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"85\">売上計上日</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">現金売上</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">掛売上</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">売上合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">現金消費税</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">掛消費税</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">現金税込<br>合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">掛税込合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">税込総合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">粗利金額</td>\n";
			$html .= "  </tr>\n";
		}

		/* 取得レコードデータの出力 */
		// 売上日がある場合（売上データのあるオペレータの場合）
		if ($ary_sale_all_data[$i][4] != null){
			$html .= "  <tr class=\"Result1\">\n";
			$html .= "      <td align=\"right\">".++$j."</td>\n";
			// 部署・担当者が、前回参照データと同じ場合
			// 担当者が前回参照データと同じ場合は担当者名を表示させない（部署が変わってない場合）
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

		// 最終行かつ、行番号がまだ0（表示するレコードが1件も無かった）の場合
		if ($i == $num_sale_all-1 && $j == 0){
			$html .= "  <tr class=\"Result1\">\n";
			// 表示カラム数分ループ
			for ($k=0; $k<=11; $k++){
				$html .= "<td align=\"center\">-</td>\n";
			}
			$html .= "  </tr>\n";
		}

		/* 部署計・オペレータ総合計の出力用に金額を加算していく */
		for ($a=5; $a<=13; $a++){
			$c_part_total[$a] 	+= $ary_sale_all_data[$i][$a];	// 部署計用
			$e_staff_total[$a]	+= $ary_sale_all_data[$i][$a];	// 総合計用
		}

		/* 部署計の出力→加算してきた部署計のリセット */
		// 今回参照行と次回参照行の部署が異なる、または最終行の場合
		if ($ary_sale_all_data[$i][2] != $ary_sale_all_data[$i+1][2] || $i == $num_sale_all-1){
			$html .= "  <tr class=\"Result2\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>部署計</b></td>\n";
			for ($a=5; $a<=13; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($c_part_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			for ($a=5; $a<=13; $a++){
				$c_part_total[$a] = 0;
			}
		}

		/* 総合計の出力 */
		// 最終行の場合
		if ($i == $num_sale_all-1){
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>総合計</b></td>\n";
			for ($a=5; $a<=13; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($e_staff_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			$html .= "</table>\n";
			$html .= "<br>\n";
			// 売上総合計をリセット
			for ($a=5; $a<=13; $a++){
				$e_staff_total[$a] = 0;
			}
		}
	}

	return $html;

}


/**
 * 概要 全社の仕入明細テーブルを作成します。
 *
 * 説明
 *
 * @param array     $ary_sale_all_data   仕入明細データ 
 * @param string    $num_sale_all        明細件数
 * 
 * @return string HTMLデータ
 *
 */
function Op_All_Buy_Html($ary_sale_all_data, $num_sale_all=""){

	if ($ary_sale_all_data == NULL) {
		$ary_sale_all_data[] = array();
	}

	if ($num_sale_all == "") {
		$num_sale_all = count($ary_sale_all_data);
	}

	// 全オペレータデータ配列数分ループ
	// $i 	ループカウンタ
	// $j 	出力テーブルの行番号
	for ($i=0, $j=0; $i<$num_sale_all; $i++){

		/* フィールドセット等の出力 */
		// 最初の行の場合
		if ($i == 0){
			$html .= "<font color=\"#555555\">■仕入明細</font>\n";
			$html .= "<table class=\"List_Table\" border=\"1\" width=\"840\">\n";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\" width=\"25\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"130\">仕入担当者</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"85\">仕入日</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">現金仕入</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">掛仕入</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">仕入合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">現金消費税</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">掛消費税</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">現金税込<br>合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">掛税込合計</td>\n";
			$html .= "      <td class=\"Title_Green\" width=\"75\">税込総合計</td>\n";
			$html .= "  </tr>\n";
		}

		/* 取得レコードデータの出力 */
		// 売上日がある場合（売上データのあるオペレータの場合）
		if ($ary_sale_all_data[$i][4] != null){
			$html .= "  <tr class=\"Result1\">\n";
			$html .= "      <td align=\"right\">".++$j."</td>\n";
			// 部署・担当者が、前回参照データと同じ場合
			// 担当者が前回参照データと同じ場合は担当者名を表示させない（部署が変わってない場合）
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

		// 最終行かつ、行番号がまだ0（表示するレコードが1件も無かった）の場合
		if ($i == $num_sale_all-1 && $j == 0){
			$html .= "  <tr class=\"Result1\">\n";
			// 表示カラム数分ループ
			for ($k=0; $k<=10; $k++){
				$html .= "<td align=\"center\">-</td>\n";
			}
			$html .= "  </tr>\n";
		}

		/* 部署計・オペレータ総合計の出力用に金額を加算していく */
		for ($a=5; $a<=12; $a++){
			$c_part_total[$a] 	+= $ary_sale_all_data[$i][$a];	// 部署計用
			$e_staff_total[$a]	+= $ary_sale_all_data[$i][$a];	// 総合計用
		}

		/* 部署計の出力→加算してきた部署計のリセット */
		// 今回参照行と次回参照行の部署が異なる、または最終行の場合
		if ($ary_sale_all_data[$i][2] != $ary_sale_all_data[$i+1][2] || $i == $num_sale_all-1){
			$html .= "  <tr class=\"Result2\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>部署計</b></td>\n";
			for ($a=5; $a<=12; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($c_part_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			for ($a=5; $a<=12; $a++){
				$c_part_total[$a] = 0;
			}
		}

		/* 総合計の出力 */
		// 最終行の場合
		if ($i == $num_sale_all-1){
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>総合計</b></td>\n";
			for ($a=5; $a<=12; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($e_staff_total[$a])."</td>\n";
			}
			$html .= "  </tr>\n";
			$html .= "</table>\n";
			$html .= "<br>\n";
			// 売上総合計をリセット
			for ($a=5; $a<=12; $a++){
				$e_staff_total[$a] = 0;
			}
		}
	}
	return $html;

}


/**
 * 概要 全社の入金明細テーブルを作成します。
 *
 * 説明
 *
 * @param array     $ary_payin_all_data   入金明細データ 
 * @param string    $num_payin_all        明細件数
 * 
 * @return string HTMLデータ
 *
 */
function Op_All_Payin_Html($ary_payin_all_data, $num_payin_all=""){

	if ($ary_payin_all_data == NULL) {
		$ary_payin_all_data[] = array();
	}

	if ($num_payin_all == "") {
		$num_payin_all = count($ary_payin_all_data);
	}


	$html .= "<font color=\"#555555\">■入金明細</font>\n";
	$html .= "<table class=\"List_Table\" border=\"1\">\n";
	$html .= "<col width=\"25\">";
	$html .= "<col width=\"70\" span=\"6\">";
	$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
	$html .= "      <td class=\"Title_Green\">No.</td>\n";
	$html .= "      <td class=\"Title_Green\">入金日</td>\n";
	$html .= "      <td class=\"Title_Green\">集金</td>\n";
	$html .= "      <td class=\"Title_Green\">振込入金</td>\n";
	$html .= "      <td class=\"Title_Green\">手形入金</td>\n";
	$html .= "      <td class=\"Title_Green\">その他</td>\n";
	$html .= "      <td class=\"Title_Green\">手数料</td>\n";
	$html .= "  </tr>\n";
	// 入金レコード数分ループ
	// y: 行No.
	for ($x=0, $y=0; $x<$num_payin_all; $x++){
			// 入金日がnullでない場合
			if ($ary_payin_all_data[$x][1] != null){
					$html .= "  <tr class=\"Result1\">\n";
					$html .= "      <td align=\"right\">".++$y."</td>\n";
					$html .= "      <td align=\"center\">".$ary_payin_all_data[$x][1]."</td>\n";
					// 金額部分のみループ
					for ($a=2; $a<=6; $a++){
							// ナンバーフォーマットし、出力
							$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_all_data[$x][$a])."</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// 最終行かつ、行番号がまだ0（表示するレコードが1件も無かった）の場合
			if ($x == $num_payin_all-1 && $y == 0){
					// 入金レコード出力の代わりにハイフンで埋めた行を出力し、このループをブレーク
					$html .= "  <tr class=\"Result1\">";
					for ($a=0; $a<=6; $a++){
							$html .= "<td align=\"center\">-</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// 金額部分のみループ
			for ($a=2; $a<=6; $a++){
					// 金額部分を加算していく
					$ary_payin_all_total[$a] += $ary_payin_all_data[$x][$a];
			}
	}
	// 入金総合計を出力
	$html .= "  <tr class=\"Result3\">\n";
	$html .= "      <td></td>\n";
	$html .= "      <td><b>総合計</b></td>\n";
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
 * 概要 全社の支払明細テーブルを作成します。
 *
 * 説明
 *
 * @param array     $ary_payin_all_data   支払明細データ 
 * @param string    $num_payin_all        明細件数
 * 
 * @return string HTMLデータ
 *
 */
function Op_All_Payout_Html($ary_payin_all_data,$num_payin_all=""){

	if ($ary_payin_all_data == NULL) {
		$ary_payin_all_data[] = array();
	}

	if ($num_payin_all == "") {
		$num_payin_all = count($ary_payin_all_data);
	}

	$html .= "<font color=\"#555555\">■支払明細</font>\n";
	$html .= "<table class=\"List_Table\" border=\"1\">\n";
	$html .= "<col width=\"25\">";
	$html .= "<col width=\"70\" span=\"6\">";
	$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
	$html .= "      <td class=\"Title_Green\">No.</td>\n";
	$html .= "      <td class=\"Title_Green\">支払日</td>\n";
	$html .= "      <td class=\"Title_Green\">現金支払</td>\n";
	$html .= "      <td class=\"Title_Green\">振込支払</td>\n";
	$html .= "      <td class=\"Title_Green\">手形支払</td>\n";
	$html .= "      <td class=\"Title_Green\">その他</td>\n";
	$html .= "      <td class=\"Title_Green\">手数料</td>\n";
	$html .= "  </tr>\n";
	// 入金レコード数分ループ
	// y: 行No.
	for ($x=0, $y=0; $x<$num_payin_all; $x++){
			// 入金日がnullでない場合
			if ($ary_payin_all_data[$x][1] != null){
					$html .= "  <tr class=\"Result1\">\n";
					$html .= "      <td align=\"right\">".++$y."</td>\n";
					$html .= "      <td align=\"center\">".$ary_payin_all_data[$x][1]."</td>\n";
					// 金額部分のみループ
					for ($a=2; $a<=6; $a++){
							// ナンバーフォーマットし、出力
							$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_all_data[$x][$a])."</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// 最終行かつ、行番号がまだ0（表示するレコードが1件も無かった）の場合
			if ($x == $num_payin_all-1 && $y == 0){
					// 入金レコード出力の代わりにハイフンで埋めた行を出力し、このループをブレーク
					$html .= "  <tr class=\"Result1\">";
					for ($a=0; $a<=6; $a++){
							$html .= "<td align=\"center\">-</td>\n";
					}
					$html .= "  </tr>\n";
			}
			// 金額部分のみループ
			for ($a=2; $a<=6; $a++){
					// 金額部分を加算していく
					$ary_payin_all_total[$a] += $ary_payin_all_data[$x][$a];
			}
	}
	// 入金総合計を出力
	$html .= "  <tr class=\"Result3\">\n";
	$html .= "      <td></td>\n";
	$html .= "      <td><b>総合計</b></td>\n";
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
 * 概要 オペレータの明細テーブルを作成します。
 *
 * 説明
 *
 * @param array     $ary_payout_select_data   支払明細データ 
 * @param string    $num_payout_select        明細件数
 * 
 * @return string HTMLデータ
 *
 */
function Op_Select_Html($ary_sale_select_data, $num_sale_select, $ary_payin_select_data, $num_payin_select){
	/*** オペレータ毎htmlデータ作成 ***/
	// 選択されたオペレータの売上レコード数分ループ
	// $i 	ループカウンタ
	// $j 	出力テーブルの行番号
	for ($i=0, $j=0; $i<$num_sale_select; $i++){

		/* オペレータ毎フィールドセット等の出力 */
		// 前回参照行と今回参照行のオペレータが異なる、または参照行が1行目の場合
		if ($ary_sale_select_data[$i][0] != $ary_sale_select_data[$i-1][0] || $i == 0){
			$html .= "<fieldset>\n";
			$html .= "<legend><span style=\"font: bold 15px; color: #555555;\">【".$ary_sale_select_data[$i][1]."】</span></legend>\n";
			$html .= "<table class=\"List_Table\" border=\"1\" width=\"100%\">\n";
			$html .= "<col width=\"25\">\n";
			$html .= "<col width=\"120\">\n";
			$html .= "<col width=\"70\" span=\"10\">\n";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\">巡回担当者</td>\n";
			$html .= "      <td class=\"Title_Green\">売上計上日</td>\n";
			$html .= "      <td class=\"Title_Green\">現金売上</td>\n";
			$html .= "      <td class=\"Title_Green\">掛売上</td>\n";
			$html .= "      <td class=\"Title_Green\">売上合計</td>\n";
			$html .= "      <td class=\"Title_Green\">現金消費税</td>\n";
			$html .= "      <td class=\"Title_Green\">掛消費税</td>\n";
			$html .= "      <td class=\"Title_Green\">現金税込<br>合計</td>\n";
			$html .= "      <td class=\"Title_Green\">掛税込合計</td>\n";
			$html .= "      <td class=\"Title_Green\">税込総合計</td>\n";
			$html .= "      <td class=\"Title_Green\">粗利金額</td>\n";
			$html .= "  </tr>\n";
		}

		/* 取得レコードデータの出力 */
		// 売上日がある場合（売上データのあるオペレータの場合）
		if ($ary_sale_select_data[$i][4] != null){
			$html .= "  <tr class=\"Result1\">\n";
			$html .= "      <td align=\"right\">".++$j."</td>\n";
			// オペレータ・部署・担当者が、前回参照データと同じ場合
			if ($ary_sale_select_data[$i][0] == $ary_sale_select_data[$i-1][0] &&
				$ary_sale_select_data[$i][2] == $ary_sale_select_data[$i-1][2] &&
				$ary_sale_select_data[$i][3] == $ary_sale_select_data[$i-1][3]){
				// 担当者名を表示させない
				$html .= "<td></td>\n";
			// オペレータ・部署・担当者が、前回参照データと同じでない場合
			}else{
				// 担当者名を表示
				$html .= "<td>".$ary_sale_select_data[$i][3]."</td>\n";
			}
			$html .= "      <td align=\"center\">".$ary_sale_select_data[$i][4]."</td>\n";
			// 金額部分のみループ
			for ($a=5; $a<=13; $a++){
				// ナンバーフォーマット出力
				$html .= "<td align=\"right\">".Minus_Numformat($ary_sale_select_data[$i][$a])."</td>\n";
			}
			$html .= "  </tr>\n";
		// 売上日が無い場合（売上データの無いオペレータの場合）
		}else{
			$html .= "  <tr class=\"Result1\">\n";
			// 表示カラム数分ループ
			for ($k=0; $k<=11; $k++){
				$html .= "<td align=\"center\">-</td>\n";
			}
			$html .= "  </tr>\n";
		}

		/* 部署計・オペレータ総合計の出力用に金額を加算していく */
		for ($a=5; $a<=13; $a++){
			$c_part_total[$a] 	+= $ary_sale_select_data[$i][$a]; 	// 部署計用
			$e_staff_total[$a]	+= $ary_sale_select_data[$i][$a]; 	// オペレータ毎総合計用
		}

		/* 部署計の出力→加算してきた部署計のリセット */
		// 今回参照行と次回参照行のオペレータまたは部署が異なる、または最終行の場合
		if ($ary_sale_select_data[$i][0] != $ary_sale_select_data[$i+1][0] ||
			$ary_sale_select_data[$i][2] != $ary_sale_select_data[$i+1][2] || $i == $num_sale_select-1){
			// 部署計の出力
			$html .= "  <tr class=\"Result2\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>部署計</b></td>\n";
			// 金額部分のみループ
			for ($a=5; $a<=13; $a++){
				// 加算してきた部署計のナンバーフォーマット出力
				$html .= "<td align=\"right\">".Minus_Numformat($c_part_total[$a])."</td>\n";
				// 加算してきた部署計のリセット
				$c_part_total[$a] = 0;
			}
			$html .= "  </tr>\n";
		}

		/* オペレータ毎総合計の出力→加算してきたオペレータ毎総合計のリセット */
		// 今回参照行と次回参照行のオペレータが異なる、または最終レコードの場合
		if ($ary_sale_select_data[$i][0] != $ary_sale_select_data[$i+1][0] || $i == $num_sale_select-1){
			// オペレータ毎総合計の出力
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td colspan=\"2\"><b>総合計</b></td>\n";
			// 金額部分のみループ
			for ($a=5; $a<=13; $a++){
				// 加算してきたオペレータ毎総合計のナンバーフォーマット出力
				$html .= "<td align=\"right\">".Minus_Numformat($e_staff_total[$a])."</td>\n";
				// 加算してきたオペレータ毎総合計のリセット
				$e_staff_total[$a] = 0;
			}
			$html .= "  </tr>\n";
			$html .= "</table>\n";

			/* 入金データの出力 */
			$html .= "<br>\n";
			$html .= "<table class=\"List_Table\" border=\"1\">\n";
			$html .= "<col width=\"25\">";
			$html .= "<col width=\"70\" span=\"6\">";
			$html .= "  <tr align=\"center\" style=\"font-weight: bold;\">\n";
			$html .= "      <td class=\"Title_Green\">No.</td>\n";
			$html .= "      <td class=\"Title_Green\">入金日</td>\n";
			$html .= "      <td class=\"Title_Green\">集金</td>\n";
			$html .= "      <td class=\"Title_Green\">振込入金</td>\n";
			$html .= "      <td class=\"Title_Green\">手形入金</td>\n";
			$html .= "      <td class=\"Title_Green\">その他入金</td>\n";
			$html .= "      <td class=\"Title_Green\">手数料</td>\n";
			$html .= "  </tr>\n";
			// 選択されたオペレータの入金レコード数分ループ
			$y = 0;
			for ($x=0; $x<$num_payin_select; $x++){
				// 現在参照しているオペレータ（売上データ）と、現在参照しているオペレータ（入金データ）が同じ場合
				if ($ary_sale_select_data[$i][0] == $ary_payin_select_data[$x][0]){
					// 現在参照レコード（入金）の入金日がnullではない場合
					if ($ary_payin_select_data[$x][1] != null){
						// 入金レコード出力
						$html .= "  <tr class=\"Result1\">\n";
						$html .= "      <td align=\"right\">".++$y."</td>\n";
						$html .= "      <td align=\"center\">".$ary_payin_select_data[$x][1]."</td>\n";
						// 金額部分のみナンバーフォーマット出力
						for ($a=2; $a<=6; $a++){
							$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_select_data[$x][$a])."</td>\n";
						}
						$html .= "  </tr>\n";
						// 金額部分を加算していく
						for ($a=2; $a<=6; $a++){
							$ary_payin_total[$a] += $ary_payin_select_data[$x][$a];
						}
					// 現在参照レコード（入金）の入金日がnullの場合
					}else{
						// 入金レコード出力の代わりにハイフンで埋めた行を出力し、このループをブレーク
						$html .= "  <tr class=\"Result1\">";
						for ($a=0; $a<=6; $a++){
							$html .= "<td align=\"center\">-</td>\n";
						}
						$html .= "  </tr>\n";
						break;
					}
				}
			}
			// 現在参照しているオペレータの入金データ総合計を出力
			$html .= "  <tr class=\"Result3\">\n";
			$html .= "      <td></td>\n";
			$html .= "      <td><b>総合計</b></td>\n";
			for ($a=2; $a<=6; $a++){
				$html .= "<td align=\"right\">".Minus_Numformat($ary_payin_total[$a])."</td>\n";
			}
			// 入金データ総合計用配列をリセット
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
