<?php

function InOut($in = 'EUC-JP',$out = 'SJIS')
{
        ini_set("output_buffering","on");
        ini_set("output_handler","mb_output_handler");
        ini_set("mbstring.http_input","auto");
        ini_set("mbstring.internal_encoding",$in);
        ini_set("mbstring.http_output","$out");
        mb_http_output($out);
        ob_start('mb_output_handler');
}

// ����ʸ�������� ����ʸ�������ɻ���
InOut('EUC-JP','SJIS');

#$csv = exec("./shiire.sh");
#echo $csv;
#passthru ("./shiire.sh");
$file_name = mb_convert_encoding("��������ɽ.csv", "SJIS", "EUC-JP");
//$data      = mb_convert_encoding($data     , "SJIS", "EUC-JP");
// HTTP�إå�
Header("Content-disposition: attachment; filename=$file_name");
Header("Content-type: application/octet-stream; name=$file_name");

system ("./shiire.sh",$aa);
#echo $aa
?>
