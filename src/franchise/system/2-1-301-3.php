<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);

// �����ѥ�����
$shop_id = $_GET["shop_id"];
Get_Id_Check2($shop_id);
$path_shain = COMPANY_SEAL_DIR.$shop_id.".jpg";

header("Content-type: image/jpeg");
header("Cache-control: no-cache");

// �̾���β����������ĥ������ϸ��β����ȽĲ��椬Ʊ���ˤʤ�褦��Ĵ�᤹��
define(ResizeX, 60);
define(ResizeY, 60);

// JPEG�������ɤ߹���
$im_inp = ImageCreateFromJPEG($path_shain);

$ix = ImageSX($im_inp);    // �ɤ߹���������β������������
$iy = ImageSY($im_inp);    // �ɤ߹���������νĥ����������

$ox = ResizeX;   // �������ѹ���β�������
$oy = ResizeY;   // �������ѹ���β�������

// �������ѹ���β����ǡ���������
$im_out = ImageCreateTrueColor($ox, $oy);
ImageCopyResized($im_out, $im_inp, 0, 0, 0, 0, $ox, $oy, $ix, $iy);

ImageJPEG($im_out);


// ���꡼�β���
ImageDestroy($im_inp);
ImageDestroy($im_out);
exit;

?>
