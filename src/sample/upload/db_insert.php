<?php
require "../../function/db_con.php";
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
	}
	$post_no = 0;//重複する郵便番号
	//重複する郵便番号がないかチェック
    $select_sql = "SELECT post_no FROM t_post_no WHERE post_no = '".$csv[2]."';";
    $result1 = pg_query($connect,$select_sql);
    if($result1==false){
        print "SQLが実行できません";
        exit;
    }else{
        $post_no = pg_num_rows($result1);
    }
	//重複する郵便番号がなかったらDBに登録
    if($post_no==0){
		//｢以下に掲載がない場合｣｢ｲｶﾆｹｲｻｲｶﾞﾅｲﾊﾞｱｲ｣を登録しない
		if($csv[5] == "イカニケイサイガナイバアイ"){
				$data_sql = "insert into t_post_no values('".$csv[2]."','".$csv[3].$csv[4]."','".$csv[6].$csv[7]."','');";
		}else{
				$data_sql = "insert into t_post_no values('".$csv[2]."','".$csv[3].$csv[4].$csv[5]."','".$csv[6].$csv[7]."','".$csv[8]."');";
		}
		$result = pg_query($connect,$data_sql);
		if($result == false)
		{
			print "SQLが実行できません";
			print $data_sql;
			print $csv[2][1];
		    exit;
		}
		$count_diff = $count_diff +1;
	//重複する郵便番号があったらカウントする
	}else{
		$count_same = $count_same +1;
	}
}
print "登録完了<br>";
print "登録したデータ数は".$count_diff."です。<br>";
print "登録しなかったデータ数は".$count_same."です。<br>";
print "　　　　　　　　　　　　　　　　";
print "<input type=\"submit\" value=\"閉じる\" onClick=\"javascript:window.close()\">";
fclose ($fp);
?>