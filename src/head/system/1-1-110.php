<?php
//�Ķ�����ե�����
require_once("ENV_local.php");

// DB��³����
$db_con = Db_Connect();

// ���¥����å�
$auth = Auth_Check($db_con);
/****************�ͼ���***********************/
//GET�������
$staff_id = $_GET["staff_id"];

//������ϿȽ��
if($staff_id!=null){
	//�ǡ�������SQL
	$sql  = "SELECT ";
	$sql .= "photo ";
	$sql .= "FROM ";
	$sql .= "t_staff ";
	$sql .= "WHERE ";
	$sql .= "staff_id = $staff_id;";
	
	//DB��³
	$result = Db_Query($db_con,$sql);
	//GET�ǡ���Ƚ��
    Get_Id_Check($result);
	$file_name = pg_fetch_result($result,0,0);
	//�ե����뤬¸�ߤ��뤫
	if($file_name == false){
		//̵�����̵̾���Τ���٤�����
		$file_name = 'photo.jpg';
	}
}else{
	$file_name = 'photo.jpg';
}

/*********************************************/

header("Content-type: image/jpeg");
header("Cache-control: no-cache");

// �̾���β����������ĥ������ϸ��β����ȽĲ��椬Ʊ���ˤʤ�褦��Ĵ�᤹��
define(ResizeX, 120);
define(ResizeY, 140);

// JPEG�������ɤ߹���
$im_inp = ImageCreateFromJPEG(STAFF_PHOTO_DIR."/".$file_name);

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
