<?php /* Smarty version 2.6.9, created on 2006-01-23 16:17:47
         compiled from post_upload.php.tpl */ ?>
<html>
<body>
<script language="javascript" src="../../../js/amenity.js">
</script>
<form name="dateForm" method="post" enctype="multipart/form-data" action="post_upload.php">
    <INPUT TYPE="hidden" NAME="MAX_FILE_SIZE" SIZE="15000">
	csv�ե�����̾��<input type="file" name="File">
    <input type="submit" name="up" value="���åץ���">
����<input type="submit" value="�ģ¤���Ͽ" name="insert" onClick="return dialogue4('DB����Ͽ���ޤ���')">
	<input type="submit" value="DB�Υǡ�������" name="delete" onClick="return dialogue4('DB�Υǡ����������ޤ���')">
	<p>
	<?php echo $this->_tpl_vars['var']['count'];  echo $this->_tpl_vars['var']['delete']; ?>

	</p>
</form>

</body>
</html>