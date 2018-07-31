<?php
//環境設定ファイル
require_once("ENV_local.php");

// DB接続設定
$db_con = Db_Connect();

// 権限チェック
$auth = Auth_Check($db_con);

// 画像パス設定
$shop_id = $_GET["shop_id"];
Get_Id_Check2($shop_id);
$path_shain = COMPANY_SEAL_DIR.$shop_id.".jpg";

header("Content-type: image/jpeg");
header("Cache-control: no-cache");

// 縮小後の横サイズ。縦サイズは元の画像と縦横比が同じになるように調節する
define(ResizeX, 60);
define(ResizeY, 60);

// JPEG画像を読み込む
$im_inp = ImageCreateFromJPEG($path_shain);

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
