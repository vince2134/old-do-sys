<?php
$functions = get_defined_functions();
sort( $functions['internal'] );
print "<b>PHP�δؿ�����</b><br>";
echo implode( "<br>", $functions['internal'] );

?>
