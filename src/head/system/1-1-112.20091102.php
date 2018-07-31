<?php

$page_title = "レンタル商品登録";

//環境設定ファイル
require_once("ENV_local.php");
//HTML_QuickFormを作成
$form =& new HTML_QuickForm("dateForm", "POST", "$_SERVER[PHP_SELF]");

//DB接続
$db_con = Db_Connect();

//全商品取得
$code_value = Code_Value("t_goods",$db_con);

//ショップ名取得
$shop_id = $_SESSION["client_id"];
$sql = "SELECT client_name ";
$sql .= "FROM t_client ";
$sql .= "WHERE client_id = ".$shop_id.";";
$result = Db_Query($db_con,$sql);
$shop_name = pg_fetch_result($result,0,0);

//フォームのデフォルト値
$def_date = array(
	"shop_txt"     => "$shop_name"
);
$form->setDefaults($def_date);

/****************************/
//部品定義
/****************************/

//ショップ名
$form->addElement("text","shop_txt","テキストフォーム",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');

//レンタル先
$form->addElement("text","rental_txt","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");

//備考
$form->addElement("text","note_txt","テキストフォーム","size=\"34\" maxLength=\"15\"".$g_form_option."\"");

//レンタル料
$form->addElement("text","money_txt","テキストフォーム","size=\"11\" style=\"text-align: right\" maxLength=\"9\"".$g_form_option."\"");

//レンタル数
$form->addElement("text","num_txt","テキストフォーム","size=\"11\" style=\"text-align: right\" maxLength=\"9\"".$g_form_option."\"");

//商品名
$text[] =& $form->createElement("text","code","テキストフォーム","size=\"10\" maxLength=\"8\" onKeyUp=\"javascript:goods(this,'f_goods[name]')\"".$g_form_option."\"");
$text[] =& $form->createElement("text","name","テキストフォーム",'size="34" style="color : #000000; border : #ffffff 1px solid; background-color: #ffffff;" readonly');
$form->addGroup( $text, "f_goods", "f_goods");

//登録ボタン
$button[] = $form->createElement("submit","touroku","登　録","onClick=\"javascript: return Dialogue('登録します。','#')\"");
//クリアボタン
$button[] = $form->createElement("button","clear","クリア","onClick=\"javascript: return Button_Submit('clear_flg','#','true')\"");
//戻るボタン
$button[] = $form->createElement("button","modoru","戻　る","onClick=\"javascript:history.back()\"");
$form->addGroup($button, "button", "");

//クリアボタン押下判定フラグ
$form->addElement("hidden", "clear_flg");
//削除リンク押下判定フラグ
$form->addElement("hidden", "delete_row_id");
//更新リンク押下判定フラグ
$form->addElement("hidden", "update_flg");

/****************************/
//エラーチェック定義
/****************************/

//必須入力チェック
$form->addRule('rental_txt','レンタル先は必須項目です。','required');
$form->addGroupRule('f_goods', array(
	'code' => array(
		array('商品名は必須項目です。','required')
	)
));
$form->addRule('money_txt','レンタル料は必須項目です。','required');
$form->addRule('num_txt','レンタル数は必須項目です。','required');
$form->addRule('money_txt','レンタル料は1〜9桁で、半角数字のみです。','numeric');
$form->addRule('num_txt','レンタル数は1〜9桁で、半角数字のみです。','numeric');

/****************************/
//変更処理（リンク）
/****************************/

//変更リンク押下判定
if($_GET["rental_id"] != ""){

	//変更するレンタルIDを取得
	$update_num = $_GET["rental_id"];

	//変更するレンタル情報をフォームに復元SQL
	//(レンタル先・商品コード・商品名・レンタル料・レンタル数・備考)
	$sql = "SELECT rental_client,t_goods.goods_cd,t_goods.goods_name,";
	$sql .= "rental_price,rental_num,note ";
	$sql .= "FROM t_goods,t_rental ";
	$sql .= "WHERE t_goods.goods_id = t_rental.goods_id ";
	$sql .= "AND rental_id = ".$update_num.";";
	$result = Db_Query($db_con,$sql);
	//GETデータ判定
	Get_Id_Check($result);
	$data_list = pg_fetch_array($result,0);

	//フォーム復元
	$def_date = array(
	    "rental_txt"     => "$data_list[0]",
		"f_goods[code]"  => "$data_list[1]",
		"f_goods[name]"  => "$data_list[2]",
		"money_txt"      => "$data_list[3]",
		"num_txt"        => "$data_list[4]",
		"note_txt"       => "$data_list[5]",
		"update_flg"     => "true",
	);
	$form->setDefaults($def_date);
}

/****************************/
//登録処理
/****************************/

//登録ボタン押下判定
if(isset($_POST["button"]["touroku"])){
	//エラーの際には、登録処理を行わない
	if($form->validate()){
		//入力フォーム値取得
		$rental_txt = $_POST["rental_txt"];
		$money_txt = $_POST["money_txt"];
		$num_txt = $_POST["num_txt"];
		$note_txt = $_POST["note_txt"];
		$update_flg = $_POST["update_flg"];

		//商品ID取得SQL
		$code = $_POST["f_goods"]["code"];
		$sql = "SELECT goods_id FROM t_goods WHERE goods_cd = '".$code."';";
		$result = Db_Query($db_con,$sql);
		//登録されていない商品コードか
		if(pg_num_rows($result) != null){
			$goods_id = pg_fetch_result($result,0,0);
			//レンタル額計算
			$rental_amount = $money_txt * $num_txt;

			Db_Query($db_con, "BEGIN;");
			//更新か登録か判定
			if($update_flg == "true"){
				//変更完了メッセージ
				$comp_msg = "変更しました。";

				//該当するレンタルIDを取得
				$update_num = $_GET["rental_id"];

				//商品更新SQL
				$sql = "UPDATE t_rental SET ";
				$sql .= "rental_client = '".$rental_txt;
				$sql .= "',goods_id = ".$goods_id;
				$sql .= ",rental_price = ".$money_txt;
				$sql .= ",rental_num = ".$num_txt;
				$sql .= ",rental_amount = ".$rental_amount;
				$sql .= ",note = '".$note_txt;
				$sql .= "' WHERE rental_id = ".$update_num.";";
			}else{
				//登録完了メッセージ
				$comp_msg = "登録しました。";

				//商品登録SQL
				$sql = "INSERT INTO t_rental VALUES(";
				$sql .= "(SELECT ";
				$sql .= "COALESCE(MAX(rental_id), 0)+1 ";
				$sql .= "FROM ";
				$sql .= "t_rental),";
				$sql .= $shop_id.",'";
				$sql .= $rental_txt."',".$goods_id.",";
				$sql .= $money_txt.",".$num_txt.",";
				$sql .= $rental_amount.",'".$note_txt."');";
			}

		 	$result = Db_Query($db_con,$sql);

			if($result == false){
				Db_Query($db_con,"ROLLBACK;");
				exit;
		    }
		
			Db_Query($db_con, "COMMIT;");

			//フォーム&変更フラグ初期化
			$def_date = array(
			    "rental_txt"     => "",
				"money_txt"     => "",
				"num_txt"     => "",
				"note_txt"     => "",
				"f_goods[name]" => "",
				"f_goods[code]" => "",
				"update_flg"     => ""
			);
			$form->setConstants($def_date);
		}else{
			//登録されていなかったら、エラー表示
			$error_value = "正しい商品コードを入力して下さい。";
		}
	}
}

/****************************/
//削除処理（リンク）
/****************************/

//削除リンク押下判定
if($_POST["delete_row_id"] != ""){

	//削除するレンタルIDを取得
	$delete_num = $_POST["delete_row_id"];
	Db_Query($db_con, "BEGIN;");
	//削除SQL
	$sql = "DELETE FROM t_rental ";
	$sql .= "WHERE rental_id = ".$delete_num.";";

	//実行
 	$result = Db_Query($db_con,$sql);
	if($result == false){
		Db_Query($db_con,"ROLLBACK;");
		exit;
	}
	
	Db_Query($db_con, "COMMIT;");

	//削除フラグ初期化
	$add_data = array(
		"delete_row_id"     => ""
	);
	$form->setConstants($add_data);
}

/****************************/
//クリア処理
/****************************/

//クリアボタン押下判定
if($_POST["clear_flg"] == "true"){

	//フォーム初期化
	$def_date = array(
	    "rental_txt"     => "",
		"f_goods[code]"  => "",
		"f_goods[name]"  => "",
		"money_txt"      => "",
		"num_txt"        => "",
		"note_txt"       => "",
	);
	$form->setConstants($def_date);
}

/****************************/
//データ取得
/****************************/

//レンタル料取得SQL(レンタル先・商品名・レンタル料・レンタル数・レンタル額・備考・レンタルID)
//レンタル先の昇順で並び替え
$sql = "SELECT rental_client,t_goods.goods_name,rental_price,";
$sql .= "rental_num,rental_amount,t_rental.note,rental_id ";
$sql .= "FROM t_goods,t_rental,t_client ";
$sql .= "WHERE t_goods.goods_id = t_rental.goods_id ";
$sql .= "AND t_client.client_id = t_rental.client_id ";
$sql .= "AND t_rental.client_id = ".$shop_id;
$sql .= " ORDER BY rental_client ASC;";

//全件数・データ取得
$result = Db_Query($db_con,$sql);
$total_count = pg_num_rows($result);


//行データ部品を作成
while($data_list = pg_fetch_array($result)){
	$row[] = array($data_list[0],$data_list[1],$data_list[2],$data_list[3],$data_list[4],$data_list[5],$data_list[6]);
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
$page_menu = Create_Menu_h('system','1');
/****************************/
//画面ヘッダー作成
/****************************/
$page_title .= "　（全".$total_count."件）";
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
	'code_value'    => "$code_value",
	'total_count' => "$total_count",
	'error_value'  => "$error_value",
	'comp_msg'   	=> "$comp_msg"
));
$smarty->assign('row',$row);
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
