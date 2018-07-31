<?php

system("./file_list.sh");

$fp = fopen("file_list.txt","r");

$i=0;
while($data = fgets($fp)){
    $i++;
    echo "$i <a href=\"../../$data\">../../".$data."</a><br>";
}


?>
