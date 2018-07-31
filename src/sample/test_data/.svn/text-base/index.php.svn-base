<?php

$file_list =  File_List_Link();

echo <<<HTML_PRINT
<html>
<head>
<!--口-->
<meta http-equiv='Content-Type' content='text/html; charset=EUC-JP'>
<title>ファイルリスト</title>
</head>
<body>
$file_list
</body>
</html>
HTML_PRINT;


#ファイルリストをリンクで取得
function File_List_Link($dir="./"){

    $files = scandir($dir);

    while ($file = each($files)) {
        // [.]  [..] [.htaccess] は表示しない
        if ($file[1] != "." && $file[1] != ".." && $file[1] != ".htaccess") {
            $file_list .= "<a href='$dir$file[1]'>$file[1]</a><br>\n";
        }
    }

    return $file_list;
}

?>
