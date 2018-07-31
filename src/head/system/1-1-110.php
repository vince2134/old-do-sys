<?php
//環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);
/****************値取得***********************/
//GET情報取得
$staff_id = $_GET["staff_id"];

//新規登録判定
if($staff_id!=null){
	//データ取得SQL
	$sql  = "SELECT ";
	$sql .= "photo ";
	$sql .= "FROM ";
	$sql .= "t_staff ";
	$sql .= "WHERE ";
	$sql .= "staff_id = $staff_id;";
	
	//DB接続
	$result = Db_Query($db_con,$sql);
	//GETデータ判定
    Get_Id_Check($result);
	$file_name = pg_fetch_result($result,0,0);
	//ファイルが存在するか
	if($file_name == false){
		//無ければ名無しのごんべいさん
		$file_name = 'photo.jpg';
	}
}else{
	$file_name = 'photo.jpg';
}

/*********************************************/

header("Content-type: image/jpeg");
header("Cache-control: no-cache");

// 縮小後の横サイズ。縦サイズは元の画像と縦横比が同じになるように調節する
define(ResizeX, 120);
define(ResizeY, 140);

// JPEG画像を読み込む
$im_inp = ImageCreateFromJPEG(STAFF_PHOTO_DIR."/".$file_name);

$ix = ImageSX($im_inp);    // 読み込んだ画像の横サイズを取得
$iy = ImageSY($im_inp);    // 読み込んだ画像の縦サイズを取得

$ox = ResizeX;   // サイズ変更後の横サイズ
$oy = ResizeY;   // サイズ変更後の横サイズ

// サイズ変更後の画像データを生成
$im_out = ImageCreateTrueColor($ox, $oy);
ImageCopyResized($im_out, $im_inp, 0, 0, 0, 0, $ox, $oy, $ix, $iy);

ImageJPEG($im_out);


// メモリーの解放
ImageDestroy($im_inp);
ImageDestroy($im_out);
exit;

?>
