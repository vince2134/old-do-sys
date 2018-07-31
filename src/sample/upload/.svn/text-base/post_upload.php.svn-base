<?php
$page_title = "";
//環境設定ファイル
require_once("ENV_local.php");

//HTML_QuickFormを作成
$form =& new HTML_QuickForm( "$_SERVER[PHP_SELF]","POST");

require_once(PATH."function/html.fnc");

//HTMLイメージ作成用部品
require_once(PATH."include/html_quick.php");

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
$page_header = Create_Header($page_title);

// Render関連の設定
$renderer =& new HTML_QuickForm_Renderer_ArraySmarty($smarty);
$form->accept($renderer);

//form関連の変数をassign
$smarty->assign('form',$renderer->toArray());

if($_POST["up"]==true){
	//参照先ファイル名を取得
	$f_name = $_FILES['File']['name'];
	//アップロード先のパス指定
	$path = "csv/";
	$up_file = $path.$f_name;
	//アップロード
	move_uploaded_file( $_FILES['File']['tmp_name'],$up_file);
}
print date( '最終アップロード日時：Y/m/d (D) H:i:s', filemtime('csv/KEN_ALL.CSV'));
if($_POST["insert"]==true){
	$db_con = Db_Connect();
	$fp = fopen ("csv/KEN_ALL.CSV","r");
	$count_diff = 0;//登録データ数
	$count_same = 0;//登録除外データ数
	//CSVのデータをwhile文
	while($data = fgets($fp, 10000)) {
		//CSVデータを配列に入れる
		for ($i = 0; $i < count($data); $i++) {
			list($csv[0],$csv[1],$csv[2],$csv[3],$csv[4],$csv[5],$csv[6],$csv[7],$csv[8]) = explode(",",$data); 
			
			//エンコーディングする
			for ($i = 0; $i < 9; $i++) {
				$csv[$i] = trim($csv[$i],"\"");
				$csv[$i] = mb_convert_encoding($csv[$i],'EUC-JP','SJIS');
			}
			//最初に出てくる｢（｣,｢(｣の位置を調べる
			$strpos1 = mb_strpos($csv[5],'(');
			$strpos2 = mb_strpos($csv[8],'（');
			//｢(｣の前の文字列を抜き出す
			if($strpos1!=false){
				$csv[5] = mb_substr($csv[5],0,$strpos1);
				$csv[5] = mb_substr($csv[5],0,54);
			}
			//｢（｣の前の文字列を抜き出す
			if($strpos2!=false){
				$csv[8] = mb_substr($csv[8],0,$strpos2);
				$csv[8] = mb_substr($csv[8],0,14);
			}
            // 半角カナ→全角カナ、半角sp→全角sp
            $csv[3] = mb_convert_kana($csv[3], "KVS");
            $csv[4] = mb_convert_kana($csv[4], "KVS");
            $csv[5] = mb_convert_kana($csv[5], "KVS");
		}
		$post_no = 0;//重複する郵便番号
		//重複する郵便番号がないかチェック
	    $select_sql = "SELECT post_no FROM t_post_no WHERE post_no = '".$csv[2]."';";
		$result1 = Db_Query($db_con,$select_sql);
	    if($result1===false){
	        print "SQLが実行できません";
	        exit;
	    }else{
	        $post_no = pg_num_rows($result1);
	    }
		//重複する郵便番号がなかったらDBに登録
	    if($post_no==0){
			//｢以下に掲載がない場合｣｢イカニケイサイガナイバアイ｣を登録しない
			if($csv[5] == "イカニケイサイガナイバアイ"){
					$data_sql = "insert into t_post_no values('".$csv[2]."','','".$csv[6].$csv[7]."','');";
			}else{
					$data_sql = "insert into t_post_no values('".$csv[2]."','".$csv[5]."','".$csv[6].$csv[7]."','".$csv[8]."');";
			}
			$result = Db_Query($db_con,$data_sql);
			if($result === false)
			{
				print "SQLが実行できません";
				print $data_sql;
			    exit;
			}
			$count_diff = $count_diff +1;
		//重複する郵便番号があったらカウントする
		}else{
			$count_same = $count_same +1;
		}
	}
	$count = "登録完了<br>";
	$count .= "登録したデータ数は".$count_diff."です。<br>";
	$count .= "登録しなかったデータ数は".$count_same."です。<br>";
	fclose ($fp);
}

if($_POST["delete"]==true){
	$db_con = Db_Connect();
	$sql = "delete from t_post_no;";
	$result = Db_Query($db_con,$sql);
	if($result===false){
	    print "SQLが実行できません";
	    exit;
	}else{
		$delete = "削除完了<br>";
	}
}

//その他の変数をassign
$smarty->assign('var',array(
	'html_header'   => "$html_header",
	'page_menu'     => "$page_menu",
	'page_header'   => "$page_header",
	'html_footer'   => "$html_footer",
	'count'   => "$count",
	'delete'   => "$delete",
));
//テンプレートへ値を渡す
$smarty->display(basename($_SERVER[PHP_SELF] .".tpl"));

?>
