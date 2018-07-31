<?php
/************************
 *変更履歴
 *  ・商品マスタの構成変更に伴い、抽出条件変更
 *  (2007-06-20) 行追加を5行に修正<watanabe-k>
 *
 *
*************************/


//session_start();


$page_title = "商品グループ設定";

//環境設定ファイル
require_once("ENV_local.php");
//ショップID取得
$shop_id = $_SESSION["client_id"];

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "dateForm","POST","$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

// 権限チェック
$auth       = Auth_Check($db_con);
$disabled   = ($auth[0] == "r") ? "disabled" : null;

//商品取得
$where  = " WHERE";
$where .= "     t_goods.public_flg = 't'";
$where .= "     AND";
$where .= "     t_goods.accept_flg = '1'";
$where .= "     AND";
$where .= "     t_goods.compose_flg = 'f'";
$where .= "     AND";
$where .= "     t_goods.state IN (1,3)";
$where .= "     AND";
$where .= "     t_goods.no_change_flg = 'f'";
$where .= "     AND\n";
$where .= "     t_goods.goods_id IN (SELECT goods_id FROM t_price WHERE rank_cd = '1' AND shop_id = $shop_id)";

$code_value .= Code_Value("t_goods",$db_con , $where);

//トランザクションの開始
$start = "BEGIN;";
$lock = "LOCK TABLE t_goods_gr;";

//トランザクションの終了
$end = "COMMIT;";

/****************************/
//HTMLイメージ作成用部品(固定)
/****************************/

//コメント
$form->addElement("text","note","テキストフォーム",'size="34" maxLength="50" onFocus="onForm(this)" onBlur="blurForm(this)"');

//グループ名
$form->addElement("text","g_name","テキストフォーム",'size="34" maxLength="10" onFocus="onForm(this)" onBlur="blurForm(this)"');

//登録ボタン
$button[] = $form->createElement("submit","touroku","登　録","onClick=\"javascript: return Dialogue('登録します。','#')\" $disabled");
//削除ボタン
$button[] = $form->createElement("button","delete","削　除","onClick=\"javascript: return Dialogue_2('削除します。','#','true','delete_button_flg')\" $disabled");
//表示ボタン
$button[] = $form->createElement("button","display","表　示","onClick=\"javascript:Button_Submit('show_button_flg','#','true')\"");

$form->addGroup($button, "button", "");

//追加リンク押下判定フラグ
$form->addElement("hidden", "insert_row_flg");
//削除リンク押下判定フラグ
$form->addElement("hidden", "delete_row_flg");
//最大行数
$form->addElement("hidden", "max_row");
//削除保持
$form->addElement("hidden", "d_history");
//表示ボタンフラグ
$form->addElement("hidden", "show_button_flg");
//削除ボタンフラグ
$form->addElement("hidden", "delete_button_flg");

/****************************/
//エラーチェック定義
/****************************/

//必須入力チェック
$form->addRule('g_name','グループ名は必須項目です。','required');
$form->addRule('note','コメントは必須項目です。','required');

/****************************/
//初期処理
/****************************/

//現在の行数取得
if(isset($_POST["max_row"])){
	$row = $_POST["max_row"];
	$d_history[] = null;
}else{
	//データの行数
	$row = 10;
	$d_history[] = null;
	//データ行数を保持。
	$def_date = array(
		"max_row"     => "$row",
	);
	$form->setConstants($def_date);
}

/****************************/
//表示処理
/****************************/

//表示ボタン押下判定
if($_POST["show_button_flg"] == true){
	//グループが選択されているか。
	if($_POST["g_select"] != ""){
		//グループID取得
		$group_id = $_POST["g_select"];

		//選択されたグループデータ取得SQL(グループコード・商品名・グループ名・コメント)
		$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,goods_gname,note FROM t_goods,t_goods_gr";
		$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id and goods_gid = ".$group_id;
		$sql .= " ORDER BY t_goods_gr.goods_id ASC;";
		$result = Db_Query($db_con,$sql);

		//データの行数取得
		$row = pg_num_rows($result);
		//フォーム識別番号
		$count = 0;
		//デフォルト値表示
		while($data_list = pg_fetch_array($result)){
			$count++;
			//データ行数と選択グループを保持。
			//フォームに商品コード・商品名・グループ名・コメント表示
			$def_date = array(
				"max_row"     => "$row",
				"g_select"     => "$group_id",
			    "f_goods".$count     => "$data_list[0]",
				"t_goods".$count     => "$data_list[1]",
				"g_name"		     => "$data_list[2]",
				"note"     			 => "$data_list[3]",
				"show_button_flg"    => "",
			);
			$form->setConstants($def_date);
		}
	}else{
		//グループデータ取得SQL(商品コード・商品名・商品ID)
		$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,t_goods.goods_id FROM t_goods,t_goods_gr";
		$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id";
		$sql .= " ORDER BY t_goods_gr.goods_id ASC;";
		$result = Db_Query($db_con,$sql);

		//初期表示行数
		$row = 10;
		//フォーム識別番号
		$count = 0;

		//フォームを初期化
		while($data_list = pg_fetch_array($result)){
			$count++;
			$def_date = array(
			    "f_goods".$count     => "",
				"t_goods".$count     => ""
			);
			$form->setConstants($def_date);
		}
	
		//最大行数・グループ名・コメント、初期化
		$add_data = array(
			"max_row"     => "$row",
			"g_name"     => "",
			"note"     => "",
			"g_select"     => ""
		);
		$form->setConstants($add_data);
	}
	//削除履歴をPOST情報に追加、グループ名は選択されていないので、null
	$add_data = array(
		"delete_row_flg"     => "",
		"d_history"         => "",
	);
	$form->setConstants($add_data);
}

/****************************/
//追加処理
/****************************/

//追加リンク押下判定
if($_POST["insert_row_flg"] == true){
	//最大行に、＋１する
	$row = $_POST["max_row"]+5;
    $add_data = array(
		"max_row"     		 => "$row",
		"insert_row_flg"     => "",
	);  
	$form->setConstants($add_data);
	//非表示する行取得
	$history = $_POST["d_history"];
	//,で分解
	$d_history = explode(",", $history);
}

/****************************/
//削除処理（リンク）
/****************************/

//削除リンク押下判定
if($_POST["delete_row_flg"] != ""){
	//新しく削除する行を履歴に追加
	$delete_num = $_POST["delete_row_flg"];
	$history = $delete_num.",".$_POST["d_history"];
	//削除履歴をPOST情報に追加
	$add_data = array(
		"delete_row_flg"     => "",
		"d_history"         => "$history"
	);
	$form->setConstants($add_data);
	//,で分解
	$d_history = explode(",", $history);
}

/****************************/
//登録処理
/****************************/

//登録ボタン押下判定
if(isset($_POST["button"]["touroku"]) && $form->validate()){

	//非表示する行取得
	$history = $_POST["d_history"];
	//,で分解
	$d_history = explode(",", $history);
	
	//エラーチェックフラグ
	$error_flg = false;
	//グループ名・コメント取得
	$g_name = $_POST["g_name"];
	$note = $_POST["note"];
	$count_goods = 1;
	$goods_id[0] = null;

	//現在表示している商品コードを取得
	$insert = $_POST;

	for($i=0;$i<count($insert);$i++){
		//値があれば、商品コード配列に保持
		if($insert["f_goods".$i] != null){
			//商品コードが半角数字か
			if(ereg("[0-9]{8}", $insert["f_goods".$i])){
				//商品コードを配列に保持
				$goods_code[$count_goods] = $insert["f_goods".$i];
				$sql = "SELECT goods_id FROM t_goods WHERE goods_cd = '".$goods_code[$count_goods]."';";
				$result = Db_Query($db_con,$sql);
				//登録されていない商品コードか
				if(pg_num_rows($result) != null){
					//登録されていれば配列に保存
					$id = pg_fetch_result($result,0,0);
					//商品IDの重複チェック
					if(in_array($id,$goods_id)){
						//重複していたら、エラー表示
						$error_value = "商品コードが重複しています。";
						//これ以降の処理を行わない処理
						$error_flg = true;
						break;
					}
					//商品IDを配列に保持
					$goods_id[$count_goods] = $id;
					$count_goods++;
				}else{
					//登録されていなかったら、エラー表示
					$error_value = "正しい商品コードを入力して下さい。";
					//これ以降の処理を行わない処理
					$error_flg = true;
					break;
				}
			}else{
				//半角数字以外ならエラー表示
				$error_value = "商品コードは８文字で、半角数字のみです。";
				//これ以降の処理を行わない処理
				$error_flg = true;
				break;
			}
		}
	}

	//チェックがエラーか
	if($error_flg != true){
		
		//グループが選択されている場合、グループIDを取得
		if($_POST["g_select"] != ""){
			$group_id = $_POST["g_select"];

			//グループ名の重複チェック
			$sql = "SELECT goods_gname from t_goods_gr ";
			$sql .= "WHERE goods_gname = '".$g_name."' ";
			$sql .= "AND NOT goods_gid = ".$group_id.";";
			$result = Db_Query($db_con,$sql);
			if(pg_num_rows($result) != null){
				//重複していたら、エラー表示
				$error_value = "既に使用されている グループ名 です。";
				//これ以降の処理を行わない処理
				$error_flg = true;
			}

			if($error_flg != true){
				//トランザクション開始
				$result = Db_Query($db_con,$start);
				$result = Db_Query($db_con,$lock);
				//データ全消去
				$sql = "DELETE FROM t_goods_gr WHERE goods_gid = ".$group_id.";";
				$result = Db_Query($db_con,$sql);
				//トランザクション終了
				$result = Db_Query($db_con,$end);
			}
		}else{
			
			//選択されていない場合、新規グループ登録
			//グループIDの割り当てSQL
			$sql = "SELECT max(goods_gid) FROM t_goods_gr;";
			$result = Db_Query($db_con,$sql);
			//一番大きいID+1
			$group_id = pg_fetch_result($result,0,0) + 1;

			//グループ名の重複チェック
			$sql = "SELECT goods_gname from t_goods_gr ";
			$sql .= "WHERE goods_gname = '".$g_name."';";
			$result = Db_Query($db_con,$sql);
			if(pg_num_rows($result) != null){
				//重複していたら、エラー表示
				$error_value = "既に使用されている グループ名 です。";
				//これ以降の処理を行わない処理
				$error_flg = true;
			}

			//入力したグループ名を選択
			$add_data = array(
				"g_select"         => "$group_id"
			);
			$form->setConstants($add_data);
		}

		//チェックがエラーか
		if($error_flg != true){
			//登録されたデータを表示する
			if(count($goods_id) != 0){

				$result = Db_Query($db_con,$start);
				$result = Db_Query($db_con,$lock);
				//表示データ登録
				for($i=1;$i<count($goods_id);$i++){
					//表示しているグループ、または、新規グループに登録
					$sql = "INSERT INTO t_goods_gr(goods_gid,goods_gname,note,goods_id) VALUES($group_id,'$g_name','$note',$goods_id[$i]);";
					$result = Db_Query($db_con,$sql);
				}
				$result = Db_Query($db_con,$end);

				//選択されたグループデータ取得SQL
				$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,goods_gname,note FROM t_goods,t_goods_gr";
				$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id and goods_gid = ".$group_id;
				$sql .= " ORDER BY t_goods_gr.goods_id ASC;";

				$result = Db_Query($db_con,$sql);

				//データの行数取得
				$row = pg_num_rows($result);

				//フォーム識別番号
				$count = 0;
				//デフォルト値表示
				while($data_list = pg_fetch_array($result)){
					$count++;
					//データ行数と選択グループを保持。
					//フォームに商品コード・商品名・グループ名・コメント表示
					$def_date = array(
						"max_row"     => "$row",
						"g_select"         => "$group_id",
					    "f_goods".$count     => "$data_list[0]",
						"t_goods".$count     => "$data_list[1]",
						"g_name"		     => "$data_list[2]",
						"note"     			 => "$data_list[3]",
						
					);
					$form->setConstants($def_date);
				}
			}else{
				//登録する商品が入力されていない場合、エラー表示
				$error_value = "商品コードは必須項目です。";
				//初期表示行数
				$row = 10;
			}
		}
	}
	if($error_flg != true){
		header("Location: ./1-4-104.php");
	}
}

/****************************/
//削除処理（ボタン）
/****************************/

//削除ボタン押下判定
if($_POST["delete_button_flg"] == true){
	//グループが選択されているか。
	if($_POST["g_select"] != ""){
		//グループID取得
		$group_id = $_POST["g_select"];
		
		$result = Db_Query($db_con,$start);
		$result = Db_Query($db_con,$lock);

		//選択されたグループデータ取得SQL
		$sql = "DELETE FROM t_goods_gr";
		$sql .= " WHERE goods_gid = ".$group_id.";";
		$result = Db_Query($db_con,$sql);
		
		$result = Db_Query($db_con,$end);

		//グループデータ取得SQL
		$sql = "SELECT t_goods.goods_cd,t_goods.goods_name,t_goods.goods_id FROM t_goods,t_goods_gr";
		$sql .= " WHERE t_goods.goods_id = t_goods_gr.goods_id";
		$sql .= " ORDER BY t_goods_gr.goods_id ASC;";
		$result = Db_Query($db_con,$sql);

		//フォーム識別番号
		$count = 0;

		//フォームを初期化
		while($data_list = pg_fetch_array($result)){
			$count++;
			$def_date = array(
			    "f_goods".$count     => "",
				"t_goods".$count     => ""
			);
			$form->setConstants($def_date);
		}
	
		//初期表示行数
		$row = 10;

		//最大行数・グループ名・コメント、初期化
		$add_data = array(
			"max_row"     => "$row",
			"g_name"     => "",
			"note"     => "",
		);
		$form->setConstants($add_data);
		
	}else{
		//削除するグループ名が選択されていない場合、エラー表示
		$error_value = "削除するグループ名を選択して下さい。";
	}	
	//削除履歴をPOST情報に追加、グループ名はないので、null
	$add_data = array(
		"delete_row_flg"     => "",
		"delete_button_flg"     => "",
		"g_select"         => ""
	);
	$form->setConstants($add_data);
}

/****************************/
//HTMLイメージ作成用部品(変動)
/****************************/

//商品グループ
$select_value = Select_Get($db_con,'goods_gr');
$form->addElement('select', 'g_select', 'セレクトボックス', $select_value,$g_form_option_select);

//行データ部品
for($r=1;$r<=$row;$r++){
	$form->addElement("text","f_goods".$r,"テキストフォーム","size=\"10\" maxLength=\"8\" value=\"\" style=\"$g_form_style\" onKeyUp=\"javascript:goods(this,'t_goods".$r."')\" onFocus=\"onForm(this)\" onBlur=\"blurForm(this)\"");
	$form->addElement("text","t_goods".$r,"テキストフォーム","size=\"34\" value=\"\" $g_text_readonly");
}

//行データ部品をTPLに渡す
$row_count=1;
for($r=1;$r<=$row;$r++){
	if(!in_array("$r", $d_history)){
		$html_row .= "<tr class=\"Result1\">\n";
		$html_row .= "<td align=\"right\">".$row_count."</td>\n";
		$html_row .= "<td align=\"center\">";
		$html_row .=  $form->_elements[$form->_elementIndex["f_goods".$r]]->toHtml();
		$html_row .= "（<a href=\"#\" onClick=\"return Open_SubWin('../dialog/1-0-210.php',Array('f_goods".$r."','t_goods".$r."'),500,450);\">検索</a>）</td>\n";
		$html_row .= "<td align=\"left\">\n";
		$html_row .=  $form->_elements[$form->_elementIndex["t_goods".$r]]->toHtml();
		$html_row .= "</td>\n<td align=\"center\">";
		$html_row .= "<a href=\"#\" style=\"color:blue\" onClick=\"javascript: return Dialogue_1('削除します。',".$r.",'delete_row_flg')\">削除</a>";
		$html_row .= "</td>\n</tr>\n";
		$row_count++;
	}
}

/****************************/
//HTMLヘッダ
/****************************/
$html_header = Html_Header($page_title);

/****************************/
//HTMLフッタ
/****************************/
$html_footer = Html_Footer();

/****************************/
//メニュー作成
/****************************/
$page_menu = Create_Menu_h('stock','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'html_row'      => "$html_row",
	'code_value'    => "$code_value",
	'error_value'   => "$error_value",
));


//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
