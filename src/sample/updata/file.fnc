<?php

//ファイルをアップロードする
# $form_name    : HTMLのフォーム名
# $up_dir_name  : サーバ側での保存ディレクトリ
# $up_file_name : サーバ側での保存ファイル名
# 戻り値        : 成功 true, 失敗 false
function File_Upload ($form_name, $up_dir_name, $up_file_name){

    $file_path_f = $up_dir_name .$up_file_name;   //サーバ側での保存先
    $file_tmp    = $_FILES[$form_name][tmp_name]; //データ
    $file_name   = $_FILES[$form_name][name];     //名前
    $file_type   = $_FILES[$form_name][type];     //タイプ
    $file_size   = $_FILES[$form_name][size];     //サイズ

    $error=""; //エラー判定変数

    // 「magic_quotes_gpc = On」のときは 「\」除去
    if (get_magic_quotes_gpc()) {
        $file_name  = stripslashes($file_name);
    }

    //アップロードファイル確認
    if(!is_uploaded_file($file_tmp)){
        $error .= "アップロードされたファイルが見つかりません。<hr>";
    }

    //ファイルサイズチェック1
    if ($file_size==0){
        $error .= "<b>ファイルサイズが0です</b><hr>";
    }

    //ファイルサイズチェック2
    if($file_size>=8000000){
        $error .= "<b>ファイルサイズが8Mを超えています。</b><hr>";
    }

    //ファイルタイプチェック
    #if(!ereg ("^image","$file_type")){
    #    $error .= "画像ファイルではありません。<hr>";
    #}

    //ファイル名チェック
    if(ereg ("([\\/:*?\"<>|])","$file_name")){
        $error .= "\\ / : * ? \" < > |  はファイル名として不適切です。<hr>";
    }

    //エラーがなければアップロード処理開始
    if($error == ""){
        move_uploaded_file ($file_tmp, "$file_path_f");
        chmod ($file_path_f, 0644);
        return true;

    //エラーがある場合
    }else{
        echo $error;
        return false;
    }

    return true;

}

//ファイルの文字コードを変換する
function File_Mb_Convert ($filename, $str_from="SJIS", $str_to="EUC-JP")
{

    //ファイルの中身を変数へ格納する
    $fd = fopen ($filename, "r");
	flock  ($fd, LOCK_EX);
    $contents = fread ($fd, filesize ($filename));
    fclose ($fd);

    //文字コードを変換
    $contents = mb_convert_encoding ($contents, $str_to, $str_from);
    $fd = fopen ($filename, "w+");
    //書き込み
	flock  ($fd, LOCK_EX);
    fwrite ($fd, $contents);
    fclose ($fd);
}

?>
