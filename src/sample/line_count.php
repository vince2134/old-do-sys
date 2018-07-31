<?php

//ソースファイルのステップ数をカウントする

$h_dir[0]   = "../head";
$h_dir[1]   = "../franchise";

$d_dir[0]   = "/analysis";
$d_dir[1]   = "/buy";
$d_dir[2]   = "/dialog";
$d_dir[3]   = "/renew";
$d_dir[4]   = "/stock";
$d_dir[5]   = "/system";
$d_dir[6]   = "/sale";

$d_name[0]  = "データ出力";
$d_name[1]  = "仕入管理";
$d_name[2]  = "ダイアログ";
$d_name[3]  = "更新処理";
$d_name[4]  = "在庫管理";
$d_name[5]  = "マスタ管理";
$d_name[6]  = "売上管理";

/*
print "<font color=red>";
print "※以下はカウントしない。";
print "<br></font>";

print "・本部の仕入管理のロジック<br>";
print "・本部・FCのデータ出力のロジック<br>";
print "・本部・FCの更新処理のロジック<br>";
print "・ＦＣの売上管理のロジック<br>";
*/
print "<hr>";

//2回ループ（本部・FC）
for($s = 0; $s < 2; $s++){
    if($s == 0){
        print "■本部<br>";
    }else{
        print "■FC<br>";
    }
    //5回ループ（各ディレクトリ分）
    for($i = 0; $i < 7; $i++){

        print "<hr>";
        print "・".$d_name[$i]."<br><br>";

        //2回ループ（ロジック・テンプレート）
        for($h = 0; $h < 2; $h++){

            //対象となるディレクトリ
            //ロジック
            if($h == 0){
                $target_dir = $h_dir[$s].$d_dir[$i];
            //テンプレート
            }elseif($h == 1){
                $target_dir = $h_dir[$s].$d_dir[$i]."/templates";
            }

            print "<b>".$target_dir."</b><br>";
//------------------------------------------------------------------------
//カウントしないもの
//-------------------------------------------------------------------------
/*
            //本部の仕入管理のロジックは未完のためカウントしない。
            if($s == 0 && $i == 1){ 
                print "未完成<br><br>";
                continue;

            //本部・FCともに、データ出力のロジックは未完のためカウントしない。
            }elseif($i == 0){
                print "未完成<br><br>";
                continue;

            //本部・FCともに、更新処理のロジックは未完のためかうんとしない。
            }elseif($i == 3){
                print "未完成<br><br>";
                continue;

            //FCの売上管理のロジックは未完のためカウントしない。
            }elseif($s == 1 && $i == 6){
                print "未完成<br><br>";
                continue;
            }

*/
//-------------------------------------------------------------------------

            $file = scandir($target_dir);

            //ディレクトリ内に存在するファイル数回ループ
            for($j = 0; $j < count($file); $j++){
                $file[$j] = trim($file[$j]);

                //ディレクトリの場合はカウントしない
                $target_file = $target_dir."/".$file[$j];
                if(!is_dir($target_file)){
                    //ステップ数を求める
                    $line = shell_exec("wc -l $target_file");
                    $count_data = explode(' ', trim($line));
                    $count[] = $count_data[0];
                    print $file[$j]."　：　".$count_data[0]."<br>";
                }
            }
            //ディレクトリ毎のステップ数合計
            $total_count[$i][$h] = @array_sum($count);
            print "合計：".$total_count[$i][$h];

            //データディレクトリ毎のステップ数合計
            $dir_count[$i] = $total_count[$i][0] + $total_count[$i][1];

            $count = null;
            print "<br><br>";
        }
        //ヘッダディレクトリ毎のステップ数合計
        $total_dir_count[$s] = @array_sum($dir_count);
    }

    print "<hr size=10 color=red>";
}
print "本部合計 ： ".$total_dir_count[0];
print "<br>";
print "FC合計 ： ".$total_dir_count[1];
print "<br>";
print "総合計 ： ".array_sum($total_dir_count);

?>
